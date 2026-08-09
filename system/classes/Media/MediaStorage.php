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

    public function __construct($root, $baseUrl, MediaValidator $validator, $maxUploadBytes, $overwrite)
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

    public function createDirectory($logicalDirectory, $name)
    {
        $parent = $this->resolveExisting($this->validator->normalizeLogicalPath($logicalDirectory), true);
        $this->validator->validateName($name);
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

    private function resolveExisting($logicalPath, $mustBeDirectory)
    {
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
