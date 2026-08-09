<?php

namespace Geeklog\Media;

/**
 * Validation helpers for the native Media Library.
 */
class MediaValidator
{
    private $allowedExtensions;
    private $imageExtensions;

    private $blockedExtensions = [
        'php', 'php3', 'php4', 'php5', 'php7', 'php8', 'phtml', 'phar',
        'cgi', 'pl', 'py', 'sh', 'bash', 'cmd', 'bat', 'com', 'exe', 'dll',
        'htaccess', 'config', 'ini', 'user.ini',
    ];

    private $mimeTypes = [
        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'gif'  => ['image/gif'],
        'png'  => ['image/png'],
        'webp' => ['image/webp'],
        'svg'  => ['image/svg+xml', 'text/xml', 'application/xml'],
        'ogv'  => ['video/ogg', 'application/ogg'],
        'mp4'  => ['video/mp4', 'application/mp4'],
        'webm' => ['video/webm', 'audio/webm'],
        'ogg'  => ['audio/ogg', 'application/ogg'],
        'mp3'  => ['audio/mpeg', 'audio/mp3'],
        'wav'  => ['audio/wav', 'audio/x-wav', 'audio/vnd.wave'],
    ];

    public function __construct(array $imageExtensions, array $videoExtensions, array $audioExtensions)
    {
        $this->imageExtensions = $this->normalizeExtensions($imageExtensions);
        $this->allowedExtensions = array_values(array_unique(array_merge(
            $this->imageExtensions,
            $this->normalizeExtensions($videoExtensions),
            $this->normalizeExtensions($audioExtensions)
        )));
    }

    public function normalizeLogicalPath($path)
    {
        if (!is_string($path) || strpos($path, "\0") !== false) {
            throw new \RuntimeException('Invalid media path.');
        }

        $path = trim($path);
        if ($path === '' || $path === '.') {
            return '';
        }

        if (preg_match('#^(?:[a-z][a-z0-9+.-]*:|[a-z]:|[/\\\\])#i', $path)) {
            throw new \RuntimeException('Invalid media path.');
        }

        if (strpos($path, '\\') !== false) {
            throw new \RuntimeException('Invalid media path.');
        }

        $parts = explode('/', trim($path, '/'));
        $normalized = [];
        foreach ($parts as $part) {
            if ($part === '' || $part === '.' || $part === '..') {
                throw new \RuntimeException('Invalid media path.');
            }
            $this->validateName($part);
            $normalized[] = $part;
        }

        return implode('/', $normalized);
    }

    public function validateName($name)
    {
        if (!is_string($name) || $name === '' || $name === '.' || $name === '..'
            || strpos($name, "\0") !== false || preg_match('/[\\x00-\\x1f\\x7f]/', $name)
            || strpos($name, '/') !== false || strpos($name, '\\') !== false
            || $name[0] === '.') {
            throw new \RuntimeException('Invalid file or folder name.');
        }

        if (preg_match('/[<>:"|?*]/', $name)) {
            throw new \RuntimeException('Invalid file or folder name.');
        }

        $trimmed = rtrim($name, ". ");
        if ($trimmed !== $name || $trimmed === '') {
            throw new \RuntimeException('Invalid file or folder name.');
        }

        return $name;
    }

    public function validateExistingFileName($name, $type)
    {
        $this->validateName($name);
        $extension = $this->extension($name);
        if ($this->isBlockedExtension($extension) || !in_array($extension, $this->allowedExtensions, true)) {
            throw new \RuntimeException('This file type is not allowed.');
        }
        if ($type === 'Image' && !in_array($extension, $this->imageExtensions, true)) {
            throw new \RuntimeException('Only image files can be selected here.');
        }
    }

    public function validateUpload(array $file, $type)
    {
        if (!isset($file['error']) || (int) $file['error'] !== UPLOAD_ERR_OK
            || empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            throw new \RuntimeException('The upload did not complete successfully.');
        }

        $name = basename((string) $file['name']);
        $this->validateExistingFileName($name, $type);
        $extension = $this->extension($name);

        // SVG is active content. Existing SVG files remain browseable, but new
        // uploads require a dedicated sanitizer and are deliberately rejected.
        if ($extension === 'svg') {
            throw new \RuntimeException('SVG uploads are not supported.');
        }

        if (!function_exists('finfo_open')) {
            throw new \RuntimeException('Server-side MIME detection is unavailable.');
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = $finfo ? finfo_file($finfo, $file['tmp_name']) : false;
        if ($finfo) {
            finfo_close($finfo);
        }
        if (!$mime || !isset($this->mimeTypes[$extension])
            || !in_array(strtolower($mime), $this->mimeTypes[$extension], true)) {
            throw new \RuntimeException('The file contents do not match the file extension.');
        }

        return ['name' => $name, 'extension' => $extension, 'mime' => strtolower($mime)];
    }

    public function validateFileContents($path, $name)
    {
        $extension = $this->extension($name);
        if ($extension === 'svg') {
            return true;
        }
        if (!function_exists('finfo_open') || !isset($this->mimeTypes[$extension])) {
            throw new \RuntimeException('This file type cannot be validated safely.');
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = $finfo ? finfo_file($finfo, $path) : false;
        if ($finfo) {
            finfo_close($finfo);
        }
        if (!$mime || !in_array(strtolower($mime), $this->mimeTypes[$extension], true)) {
            throw new \RuntimeException('The file contents do not match the file extension.');
        }
        return true;
    }

    public function isImage($name)
    {
        return in_array($this->extension($name), $this->imageExtensions, true);
    }

    public function isAllowedFile($name, $type)
    {
        try {
            $this->validateExistingFileName($name, $type);
            return true;
        } catch (\RuntimeException $e) {
            return false;
        }
    }

    public function extension($name)
    {
        return strtolower((string) pathinfo($name, PATHINFO_EXTENSION));
    }

    private function isBlockedExtension($extension)
    {
        return $extension === '' || in_array(strtolower($extension), $this->blockedExtensions, true);
    }

    private function normalizeExtensions(array $extensions)
    {
        $result = [];
        foreach ($extensions as $extension) {
            $extension = strtolower(ltrim(trim((string) $extension), '.'));
            if ($extension !== '' && !$this->isBlockedExtension($extension)) {
                $result[] = $extension;
            }
        }
        return array_values(array_unique($result));
    }
}
