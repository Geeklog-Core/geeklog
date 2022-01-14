<?php

use \PHPUnit\Framework\TestCase;

/**
 * Simple tests for the downloader class
 * Obviously, we can't really test the download functionality. So test at least
 * the getter / setter methods.
 */
class downloaderClass extends TestCase
{
    /**
     * @var downloader
     */
    private $dl;

    protected function setUp(): void
    {
        $this->dl = new downloader();
    }

    public function testLoggingEnabledDefault()
    {
        $this->assertFalse($this->dl->loggingEnabled());
    }

    public function testAreErrorsDefault()
    {
        $this->assertFalse($this->dl->areErrors());
    }

    public function testGetPathDefault()
    {
        $this->assertEquals('', $this->dl->getPath());
    }

    public function testGetAllowedExtensionsDefault()
    {
        $this->assertEquals(array(), $this->dl->getAllowedExtensions());
    }

    public function testCheckExtensionNotAllowedDefault()
    {
        // by default, nothing is allowed
        $this->assertFalse($this->dl->checkExtension('jpg'));
    }

    public function testSetDebug()
    {
        $this->dl->setDebug(true);
        // there is no getDebug() method ...
        $this->assertTrue($this->dl->isDebug());
    }

    public function testLimitByIPDefault()
    {
        $this->assertTrue($this->dl->limitByIP());
    }

    public function testLimitByIPWrongParameter()
    {
        $dl2 = new downloader();

        $this->assertFalse($dl2->limitByIP('127.0.0.1'));
        $this->assertTrue($dl2->areErrors());
    }

    public function testLimitByIP()
    {
        $dl2 = new downloader();

        $this->assertTrue($dl2->limitByIP(array('213.5.71.85', '213.5.71.86')));
        $this->assertFalse($dl2->areErrors());
    }

    public function testSetLogFileFail()
    {
        // tricky to test: given logfile must exist but we don't have the
        // path to error.log - test for failure only
        $this->dl->setLogFile('does-not-exist.log');
        // there is no getLogFile() method ...
        $this->assertEquals('', $this->dl->getLogFile());
    }

    public function testSetLoggingFail()
    {
        // see testSetLogFileFail() ...
        $this->dl->setLogging(true);
        $this->assertFalse($this->dl->loggingEnabled());
    }

    public function testSetAllowedExtensions()
    {
        $dl2 = new downloader();
        $dl2->setAllowedExtensions(array('jpg'  => 'image/jpeg',
                                         'jpeg' => 'image/jpeg'));
        $this->assertFalse($dl2->areErrors());

        $this->assertTrue($dl2->checkExtension('jpg'));
        $this->assertTrue($dl2->checkExtension('jpeg'));
        $this->assertFalse($dl2->checkExtension('pl'));
    }

    public function testSetAllowedExtensionsFail()
    {
        // .pl (Perl scripts) is not allowed
        $dl2 = new downloader();
        $dl2->setAllowedExtensions(array('jpg' => 'image/jpeg',
                                         'pl'  => 'application/x-perl'));
        $this->assertTrue($dl2->areErrors());

        // one invalid extension will invalidate the entire list
        $this->assertFalse($dl2->checkExtension('jpg'));
        $this->assertFalse($dl2->checkExtension('jpeg'));
        $this->assertFalse($dl2->checkExtension('pl'));
    }

}
