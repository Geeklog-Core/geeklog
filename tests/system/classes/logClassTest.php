<?php

use Geeklog\Log;
use \PHPUnit\Framework\TestCase;

/**
 * Class logClassTest
 * @package system\classes
 */
class logClassTest extends TestCase
{
    /**
     * @var string
     */
    private $pathToLogDir;

    /**
     * @var array
     */
    private $files = ['404.log', 'access.log', 'error.log', 'spamx.log'];

    public function setUp(): void
    {
        $this->pathToLogDir = Tst::$root . 'logs' . DIRECTORY_SEPARATOR;
        Log::init($this->pathToLogDir);

        if (!is_callable('COM_strftime')) {
            function COM_strftime($format, $timestamp = null)
            {
                return strftime($format, $timestamp);
            }
        }
    }

    public function tearDown(): void
    {
        $entry = '*** dummy entry ***' . PHP_EOL;

        foreach ($this->files as $file) {
            @file_put_contents($this->pathToLogDir . $file, $entry);
        }
    }

    public function testSetTimeStampFormat()
    {
        $data = [
            // Common to all log files
            '%c',

            // Install default
            '%A, %B %d %Y @ %I:%M %p %Z',
            '%m/%d %I:%M%p',
            '%x',
            '%d-%b',
            '%I:%M %p %Z',
        ];

        foreach ($data as $datum) {
            Log::setTimeStampFormat($datum);
            $this->assertEquals($datum, Geeklog\Log::getTimeStampFormat());
        }
    }

    public function testClear()
    {
        foreach ($this->files as $file) {
            Log::clear($file);
            $timestamp = Log::formatTimeStamp();
            $expected = "{$timestamp} - Log File Cleared " . PHP_EOL;
            $this->assertEquals($expected, Log::getContents($file));
        }
    }

    public function testTruncate()
    {
        foreach ($this->files as $file) {
            $path = $this->pathToLogDir . $file;

            for ($i = 0; $i < 1000; $i++) {
                $line = base64_encode(random_bytes(1000)) . PHP_EOL;
                file_put_contents($path, $line);
            }

            $ceiling = 10000 + mt_rand(0, 10000);

            Log::truncate($file, $ceiling);
            $this->assertEquals(true, (filesize($path) <= $ceiling));
        }
    }
}
