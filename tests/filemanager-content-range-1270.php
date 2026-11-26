<?php
/** Regression test for #1270: exercise the real filename selection method. */
require_once dirname(__DIR__) . '/system/vendor/servocoder/richfilemanager-php/src/Repository/BaseUploadHandler.php';

error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

class FilenameTestStorage
{
    public function getFileSize($path)
    {
        // Match the string offset produced by the Content-Range parser.
        return (string) filesize($path);
    }
}

class FilenameTestHandler extends \RFM\Repository\BaseUploadHandler
{
    private $directory;

    public function __construct($directory)
    {
        $this->directory = $directory;
        $this->storage = new FilenameTestStorage();
    }

    protected function get_upload_path($file_name = null, $version = null)
    {
        return $this->directory . '/' . $file_name;
    }

    public function choose($name, $range)
    {
        return $this->get_unique_filename('', $name, 12, 'image/jpeg', 0, null, $range);
    }
}

$dir = tempnam(sys_get_temp_dir(), 'gl1270-');
if ($dir === false || !unlink($dir) || !mkdir($dir, 0700)) {
    throw new RuntimeException('Cannot create isolated test directory');
}

try {
    file_put_contents($dir . '/existing.jpg', 'abcd');
    file_put_contents($dir . '/empty.jpg', '');
    mkdir($dir . '/folder.jpg');
    $handler = new FilenameTestHandler($dir);
    $range = preg_split('/[^0-9]+/', 'bytes 4-7/12');
    $mismatch = preg_split('/[^0-9]+/', 'bytes 2-5/12');

    $cases = array(
        array('fresh.jpg', null, 'fresh.jpg'),
        array('fresh.jpg', array(), 'fresh.jpg'),
        array('existing.jpg', null, 'existing_1.jpg'),
        array('empty.jpg', null, 'empty_1.jpg'),
        array('existing.jpg', $range, 'existing.jpg'),
        array('existing.jpg', $mismatch, 'existing_1.jpg'),
        array('folder.jpg', null, 'folder_1.jpg'),
    );

    foreach ($cases as $case) {
        $actual = $handler->choose($case[0], $case[1]);
        if ($actual !== $case[2]) {
            throw new RuntimeException('Expected ' . $case[2] . ', got ' . $actual);
        }
    }
    if (file_get_contents($dir . '/existing.jpg') !== 'abcd' || filesize($dir . '/empty.jpg') !== 0) {
        throw new RuntimeException('Original fixture changed');
    }
    echo "OK: #1270 filename selection scenarios passed (7 cases)\n";
} finally {
    unlink($dir . '/existing.jpg');
    unlink($dir . '/empty.jpg');
    rmdir($dir . '/folder.jpg');
    rmdir($dir);
}
