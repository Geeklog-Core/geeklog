<?php

namespace Geeklog\Media;

/**
 * Validates and re-encodes browser-edited images with PHP GD.
 * Only raster JPEG, PNG and WebP are supported; no SVG or animated GIF.
 */
class MediaImageEditor
{
    public static function encodeUpload(array $file, $extension, $maxUploadBytes)
    {
        if (!extension_loaded('gd')) {
            throw new \RuntimeException('PHP GD is required for image editing.');
        }
        if (!isset($file['error']) || (int) $file['error'] !== UPLOAD_ERR_OK
            || empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            throw new \RuntimeException('The edited image was not uploaded successfully.');
        }
        $length = (int) $file['size'];
        if ($length <= 0 || ($maxUploadBytes > 0 && $length > $maxUploadBytes)
            || $length > 32 * 1024 * 1024) {
            throw new \RuntimeException('The edited image exceeds the upload limit.');
        }
        $extension = strtolower($extension);
        if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            throw new \RuntimeException('This image format cannot be edited.');
        }
        $info = @getimagesize($file['tmp_name']);
        if (!$info || empty($info[0]) || empty($info[1])
            || $info[0] > 10000 || $info[1] > 10000
            || (float) $info[0] * $info[1] > 24000000) {
            throw new \RuntimeException('Invalid image or image dimensions exceed the safety limit.');
        }
        $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP];
        if (!in_array($info[2], $allowedTypes, true)) {
            throw new \RuntimeException('The uploaded file is not a supported raster image.');
        }
        $data = @file_get_contents($file['tmp_name']);
        if ($data === false) {
            throw new \RuntimeException('The edited image cannot be read.');
        }
        $image = @imagecreatefromstring($data);
        unset($data);
        if ($image === false) {
            throw new \RuntimeException('The edited image could not be decoded.');
        }
        return $image;
    }

    public static function writeImage($image, $destination, $extension)
    {
        $extension = strtolower($extension);
        if ($extension === 'jpg' || $extension === 'jpeg') {
            $result = imagejpeg($image, $destination, 88);
        } elseif ($extension === 'png') {
            imagealphablending($image, false);
            imagesavealpha($image, true);
            $result = imagepng($image, $destination, 6);
        } elseif ($extension === 'webp' && function_exists('imagewebp')) {
            imagealphablending($image, false);
            imagesavealpha($image, true);
            $result = imagewebp($image, $destination, 85);
        } else {
            throw new \RuntimeException('The server cannot encode this image format.');
        }
        if (!$result || !is_file($destination) || filesize($destination) === 0) {
            throw new \RuntimeException('The edited image could not be saved.');
        }
    }
}
