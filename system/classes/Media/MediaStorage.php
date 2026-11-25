<?php

namespace Geeklog\Media;

/**
 * All filesystem mutations for the native Media Library live here.
 */
class MediaStorage
{
    private $root;
    private $rootPrefix;
    private $baseUrl;
    private $validator;
    private $maxUploadBytes;
    private $overwrite;
    private $excludedDirectories;

    public function __construct($root, $baseUrl, MediaValidator $validator, $maxUploadBytes, $overwrite, array $excludedDirectories = [])
    {
        $resolved = realpath($root);
        if ($resolved === false || !is_dir($resolved)) {
            throw new \RuntimeException('The media directory is unavailable.');
        }
        $this->root = rtrim($resolved, DIRECTORY_SEPARATOR);
        $this->rootPrefix = $this->root . DIRECTORY_SEPARATOR;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->validator = $validator;
        $this->maxUploadBytes = max(0, (int) $maxUploadBytes);
        $this->overwrite = (bool) $overwrite;
        // Keep legacy Geeklog's technical directories out of user media navigation.
        $this->excludedDirectories = ['_thumbs' => true];
        foreach ($excludedDirectories as $name) {
            if (is_string($name) && $name !== '') {
                $this->excludedDirectories[strtolower(trim($name, '/\\\\'))] = true;
            }
        }
    }

    public function listDirectory($logicalPath, $type)
    {
        $logicalPath = $this->validator->normalizeLogicalPath($logicalPath);
        $directory = $this->resolveExisting($logicalPath, true);
        $items = [];
        $iterator = new \DirectoryIterator($directory);
        foreach ($iterator as $entry) {
            if ($entry->isDot() || $entry->isLink()) {
                continue;
            }
            $name = $entry->getFilename();
            try {
                $this->validator->validateName($name);
            } catch (\RuntimeException $e) {
                continue;
            }
            $childPath = $logicalPath === '' ? $name : $logicalPath . '/' . $name;
            if ($entry->isDir() && $this->isExcludedDirectory($name)) {
                continue;
            }
            if ($entry->isDir()) {
                $items[] = [
                    'name' => $name, 'path' => $childPath, 'kind' => 'folder',
                    'size' => null, 'modified' => $entry->getMTime(), 'url' => null,
                    'image' => false,
                ];
            } elseif ($entry->isFile() && $this->validator->isAllowedFile($name, $type)) {
                $items[] = [
                    'name' => $name, 'path' => $childPath, 'kind' => 'file',
                    'size' => $entry->getSize(), 'modified' => $entry->getMTime(),
                    'version' => implode('-', [$entry->getMTime(), $entry->getSize(), $entry->getInode()]),
                    'url' => $this->publicUrl($childPath),
                    'image' => $this->validator->isImage($name),
                ];
            }
        }
        usort($items, function ($left, $right) {
            if ($left['kind'] !== $right['kind']) {
                return $left['kind'] === 'folder' ? -1 : 1;
            }
            return strnatcasecmp($left['name'], $right['name']);
        });
        return ['path' => $logicalPath, 'parent' => $this->parentPath($logicalPath), 'items' => $items];
    }

    public function upload($logicalDirectory, array $file, $type)
    {
        $directoryPath = $this->validator->normalizeLogicalPath($logicalDirectory);
        $directory = $this->resolveExisting($directoryPath, true);
        $validated = $this->validator->validateUpload($file, $type);
        if ($this->isExcludedDirectory($validated['name'])) {
            throw new \RuntimeException('Reserved technical filename.');
        }
        if ($this->maxUploadBytes > 0 && (int) $file['size'] > $this->maxUploadBytes) {
            throw new \RuntimeException('The uploaded file exceeds the configured size limit.');
        }
        $target = $directory . DIRECTORY_SEPARATOR . $validated['name'];
        if (file_exists($target) && !$this->overwrite) {
            throw new \RuntimeException('A file with that name already exists.');
        }
        if (is_link($target) || (file_exists($target) && !is_file($target))) {
            throw new \RuntimeException('The destination is not a regular file.');
        }
        if (!move_uploaded_file($file['tmp_name'], $target)) {
            throw new \RuntimeException('The uploaded file could not be stored.');
        }
        @chmod($target, 0644);
        return true;
    }

    /**
     * Commit an edited raster image, either retaining the public URL or creating a copy.
     * The original is never changed before a complete, validated temporary image exists.
     */
    public function saveEditedImage($logicalPath, array $file, $saveCopy)
    {
        $logicalPath = $this->validator->normalizeLogicalPath($logicalPath);
        if ($logicalPath === '') {
            throw new \RuntimeException('Choose an image to edit.');
        }
        $source = $this->resolveExisting($logicalPath, false);
        $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            throw new \RuntimeException('Only JPEG, PNG and WebP images can be edited.');
        }
        $this->validator->validateExistingFileName(basename($source), 'Image');
        if (is_link($source)) {
            throw new \RuntimeException('Symbolic links cannot be edited.');
        }
        $image = MediaImageEditor::encodeUpload($file, $extension, $this->maxUploadBytes);
        $directory = dirname($source);
        $temporary = @tempnam($directory, '.media-edit-');
        if (!$temporary) {
            imagedestroy($image);
            throw new \RuntimeException('Cannot create a temporary image.');
        }
        try {
            MediaImageEditor::writeImage($image, $temporary, $extension);
            @chmod($temporary, 0644);
            clearstatcache(true, $source);
            if (!is_file($source) || is_link($source)) {
                throw new \RuntimeException('The original image is no longer available.');
            }
            if ($saveCopy) {
                $base = pathinfo($source, PATHINFO_FILENAME);
                $target = null;
                for ($i = 1; $i <= 1000; ++$i) {
                    $candidate = $directory . DIRECTORY_SEPARATOR . $base
                        . '-edited' . ($i > 1 ? '-' . $i : '') . '.' . $extension;
                    if (!file_exists($candidate) && !is_link($candidate)) {
                        // Exclusive creation prevents silently overwriting an existing copy.
                        $handle = @fopen($candidate, 'x');
                        if ($handle === false) {
                            continue;
                        }
                        fclose($handle);
                        $target = $candidate;
                        break;
                    }
                }
                if ($target === null) {
                    throw new \RuntimeException('Cannot allocate a filename for the copy.');
                }
                if (!@rename($temporary, $target)) {
                    @unlink($target);
                    throw new \RuntimeException('Cannot save the image copy.');
                }
                return ['path' => ($logicalPath === basename($source) ? '' : dirname($logicalPath) . '/')
                    . basename($target), 'copied' => true];
            }
            // Atomic on local POSIX filesystems. On platforms that prohibit overwrite,
            // this fails without first deleting the existing image.
            if (!@rename($temporary, $source)) {
                throw new \RuntimeException('Cannot replace the original image.');
            }
            return ['path' => $logicalPath, 'copied' => false];
        } finally {
            imagedestroy($image);
            if (file_exists($temporary)) {
                @unlink($temporary);
            }
        }
    }

    public function createDirectory($logicalDirectory, $name)
    {
        $parent = $this->resolveExisting($this->validator->normalizeLogicalPath($logicalDirectory), true);
        $this->validator->validateName($name);
        if ($this->isExcludedDirectory($name)) {
            throw new \RuntimeException('Reserved technical directory name.');
        }
        $target = $parent . DIRECTORY_SEPARATOR . $name;
        if (file_exists($target) || is_link($target)) {
            throw new \RuntimeException('An item with that name already exists.');
        }
        if (!mkdir($target, 0755)) {
            throw new \RuntimeException('The folder could not be created.');
        }
        return true;
    }

    public function renameItem($logicalPath, $newName, $type)
    {
        $logicalPath = $this->validator->normalizeLogicalPath($logicalPath);
        if ($logicalPath === '') {
            throw new \RuntimeException('The media root cannot be renamed.');
        }
        $source = $this->resolveExisting($logicalPath, null);
        $this->validator->validateName($newName);
        if ($this->isExcludedDirectory($newName)) {
            throw new \RuntimeException('Reserved technical directory name.');
        }
        if (is_file($source)) {
            $this->validator->validateExistingFileName($newName, $type);
            $this->validator->validateFileContents($source, $newName);
        }
        $target = dirname($source) . DIRECTORY_SEPARATOR . $newName;
        if (file_exists($target) || is_link($target)) {
            throw new \RuntimeException('An item with that name already exists.');
        }
        if (!rename($source, $target)) {
            throw new \RuntimeException('The item could not be renamed.');
        }
        return true;
    }

    public function deleteItem($logicalPath)
    {
        $logicalPath = $this->validator->normalizeLogicalPath($logicalPath);
        if ($logicalPath === '') {
            throw new \RuntimeException('The media root cannot be deleted.');
        }
        $target = $this->resolveExisting($logicalPath, null);
        if (is_dir($target)) {
            $entries = scandir($target);
            if ($entries === false || count($entries) > 2) {
                throw new \RuntimeException('Only empty folders can be deleted.');
            }
            if (!rmdir($target)) {
                throw new \RuntimeException('The folder could not be deleted.');
            }
        } elseif (!unlink($target)) {
            throw new \RuntimeException('The file could not be deleted.');
        }
        return true;
    }

    private function isExcludedDirectory($name)
    {
        return isset($this->excludedDirectories[strtolower($name)]);
    }

    private function assertAccessiblePath($logicalPath)
    {
        if ($logicalPath === '') {
            return;
        }
        foreach (explode('/', $logicalPath) as $part) {
            if ($this->isExcludedDirectory($part)) {
                throw new \RuntimeException('This technical directory is not available in the Media Library.');
            }
        }
    }

    /** Validate a path without exposing a filesystem path to the browser. */
    public function resolveThumbnailSource($logicalPath, $type)
    {
        $logicalPath = $this->validator->normalizeLogicalPath($logicalPath);
        if ($logicalPath === '') {
            throw new \RuntimeException('Choose an image.');
        }
        $this->validator->validateExistingFileName(basename($logicalPath), $type);
        if (!$this->validator->isImage(basename($logicalPath))) {
            throw new \RuntimeException('The selected file is not an image.');
        }
        return $this->resolveExisting($logicalPath, false);
    }

    private function resolveExisting($logicalPath, $mustBeDirectory)
    {
        $this->assertAccessiblePath($logicalPath);
        $candidate = $logicalPath === ''
            ? $this->root
            : $this->root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $logicalPath);
        if ($this->containsSymlink($logicalPath)) {
            throw new \RuntimeException('Symbolic links are not available in the Media Library.');
        }
        $resolved = realpath($candidate);
        if ($resolved === false || !$this->isInsideRoot($resolved)) {
            throw new \RuntimeException('The requested media item was not found.');
        }
        if ($mustBeDirectory === true && !is_dir($resolved)) {
            throw new \RuntimeException('The requested folder was not found.');
        }
        if ($mustBeDirectory === false && !is_file($resolved)) {
            throw new \RuntimeException('The requested file was not found.');
        }
        return $resolved;
    }

    private function containsSymlink($logicalPath)
    {
        if ($logicalPath === '') {
            return is_link($this->root);
        }
        $current = $this->root;
        foreach (explode('/', $logicalPath) as $part) {
            $current .= DIRECTORY_SEPARATOR . $part;
            if (is_link($current)) {
                return true;
            }
        }
        return false;
    }

    private function isInsideRoot($path)
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        if (DIRECTORY_SEPARATOR === '\\') {
            return strcasecmp($path, $this->root) === 0
                || stripos($path . DIRECTORY_SEPARATOR, $this->rootPrefix) === 0;
        }
        return $path === $this->root || strpos($path . DIRECTORY_SEPARATOR, $this->rootPrefix) === 0;
    }

    private function publicUrl($logicalPath)
    {
        $parts = explode('/', $logicalPath);
        $parts = array_map('rawurlencode', $parts);
        return $this->baseUrl . '/' . implode('/', $parts);
    }

    private function parentPath($logicalPath)
    {
        if ($logicalPath === '' || strpos($logicalPath, '/') === false) {
            return '';
        }
        return substr($logicalPath, 0, strrpos($logicalPath, '/'));
    }
}
