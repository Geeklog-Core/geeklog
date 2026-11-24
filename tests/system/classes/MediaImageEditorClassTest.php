<?php

namespace Geeklog\Test;

use Geeklog\Media\MediaImageEditor;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class MediaImageEditorClassTest extends TestCase
{
    public function setUp(): void
    {
        require_once \Tst::$root . 'system/classes/Media/MediaImageEditor.php';
        if (!extension_loaded('gd')) {
            $this->markTestSkipped('PHP GD is not installed.');
        }
    }

    public function testWritesJpegPngAndWebp()
    {
        $image = imagecreatetruecolor(12, 8);
        $this->assertNotFalse($image);
        try {
            $formats = ['jpg' => IMAGETYPE_JPEG, 'png' => IMAGETYPE_PNG];
            if (function_exists('imagewebp')) {
                $formats['webp'] = IMAGETYPE_WEBP;
            }
            foreach ($formats as $ext => $expected) {
                $target = tempnam(sys_get_temp_dir(), 'gl-media-');
                try {
                    MediaImageEditor::writeImage($image, $target, $ext);
                    $size = getimagesize($target);
                    $this->assertSame(12, $size[0]);
                    $this->assertSame(8, $size[1]);
                    $this->assertSame($expected, $size[2]);
                } finally {
                    @unlink($target);
                }
            }
        } finally {
            imagedestroy($image);
        }
    }

    public function testRejectsUnsupportedOutputFormat()
    {
        $image = imagecreatetruecolor(2, 2);
        $this->expectException(RuntimeException::class);
        try {
            MediaImageEditor::writeImage($image, '/dev/null', 'gif');
        } finally {
            imagedestroy($image);
        }
    }

    public function testRejectsNonUploadedInput()
    {
        $imageFile = tempnam(sys_get_temp_dir(), 'gl-media-');
        try {
            file_put_contents($imageFile, 'not an upload');
            $this->expectException(RuntimeException::class);
            MediaImageEditor::encodeUpload([
                'error' => UPLOAD_ERR_OK,
                'size' => filesize($imageFile),
                'tmp_name' => $imageFile,
            ], 'png', 1024);
        } finally {
            @unlink($imageFile);
        }
    }
}
