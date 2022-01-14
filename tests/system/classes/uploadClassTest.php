<?php

use \PHPUnit\Framework\TestCase;

/**
 * Simple tests for the upload class
 * Obviously, we can't really test the upload functionality. So test at least
 * the getter / setter methods.
 */
class uploadClass extends TestCase
{
    /**
     * @var upload
     */
    private $up;

    protected function setUp(): void
    {
        $this->up = new upload();
    }

    public function testSetMogrifyPath()
    {
        $this->assertTrue($this->up->setMogrifyPath('/path/to/mogrify'));
        // there is no getMogrifyPath() method ...
        $this->assertEquals('/path/to/mogrify', $this->up->getMogrifyPath());
    }

    public function testSetNetPBM()
    {
        $this->assertTrue($this->up->setNetPBM('/path/to/netpbm'));
        // there is no getNetPBM() method ...
        $this->assertEquals('/path/to/netpbm', $this->up->getNetPBMPath());
    }

    public function testSetGDLib()
    {
        $this->assertTrue($this->up->setGDLib());
        // there is no getGDLib() method ...
        $this->assertEquals('gdlib', $this->up->getImageLib());
    }

    public function testSetAutomaticResize()
    {
        $this->assertFalse($this->up->isAutoResize());
        $this->up->setAutomaticResize(true);
        $this->assertTrue($this->up->isAutoResize());
    }

    public function testGetMaxFileSizeDefault()
    {
        $up2 = new upload();
        $this->assertEquals(1048576, $up2->getMaxFileSize());
    }

    public function testSetMaxFileSize()
    {
        $this->assertTrue($this->up->setMaxFileSize(32768));
        $this->assertEquals(32768, $this->up->getMaxFileSize());
    }

    public function testSetMaxFileSizeNotNumeric()
    {
        $this->assertFalse($this->up->setMaxFileSize('Hello'));
    }

    public function testGetMaxDimensionsDefaults()
    {
        $up2 = new upload();
        $this->assertEquals(300, $up2->getMaxImageWidth());
        $this->assertEquals(300, $up2->getMaxImageHeight());
    }

    public function testSetMaxDimensions()
    {
        $this->assertTrue($this->up->setMaxDimensions(640, 480));
        $this->assertEquals(640, $this->up->getMaxImageWidth());
        $this->assertEquals(480, $this->up->getMaxImageHeight());
    }

    public function testSetMaxDimensionsNotNumericWidth()
    {
        // bug in Geeklog 1.7.0 and earlier - accepted one non-numeric value
        $this->assertFalse($this->up->setMaxDimensions('Hello', 480));
    }

    public function testSetMaxDimensionsNotNumericHeight()
    {
        // bug in Geeklog 1.7.0 and earlier - accepted one non-numeric value
        $this->assertFalse($this->up->setMaxDimensions(640, 'world'));
    }

    public function testSetMaxDimensionsNotNumeric()
    {
        $this->assertFalse($this->up->setMaxDimensions('Hello', 'world'));
    }

    public function testGetMaxFileUploadsDefault()
    {
        $up2 = new upload();
        $this->assertEquals(5, $up2->getMaxFileUploadsPerForm());
    }

    public function testSetMaxFileUploads()
    {
        $this->assertTrue($this->up->setMaxFileUploads(10));
        $this->assertEquals(10, $this->up->getMaxFileUploadsPerForm());
    }

    public function testGetKeepOriginalImageDefault()
    {
        $up2 = new upload();
        $this->assertFalse($up2->isKeepOriginalImage());
    }

    public function testKeepOriginalImage()
    {
        $this->assertTrue($this->up->keepOriginalImage(true));
        $this->assertTrue($this->up->isKeepOriginalImage());
        $this->assertTrue($this->up->keepOriginalImage(false));
    }

    public function testDontKeepOriginalImage()
    {
        $this->assertTrue($this->up->keepOriginalImage(false));
        $this->assertFalse($this->up->isKeepOriginalImage());
    }

    public function testGetJpegQualityDefault()
    {
        $up2 = new upload();
        $this->assertEquals(0, $up2->getJpegQuality());
    }

    public function testSetJpegQuality()
    {
        $this->assertTrue($this->up->setJpegQuality(72));
        $this->assertEquals(72, $this->up->getJpegQuality());
    }

    public function testSetJpegQualityTooBig()
    {
        $this->assertFalse($this->up->setJpegQuality(123));
    }

    public function testSetJpegQualityNegative()
    {
        $this->assertFalse($this->up->setJpegQuality(-2));
    }

    public function testSetJpegQualityZero()
    {
        $this->assertTrue($this->up->setJpegQuality(0));
        $this->assertEquals(0, $this->up->getJpegQuality());
    }

    public function testLimitByIPDefault()
    {
        $this->assertTrue($this->up->limitByIP());
    }

    public function testLimitByIPWrongParameter()
    {
        $up2 = new upload();

        $this->assertFalse($up2->limitByIP('127.0.0.1'));
        $this->assertTrue($up2->areErrors());
    }

    public function testLimitByIP()
    {
        $up2 = new upload();

        $this->assertTrue($up2->limitByIP(array('213.5.71.85', '213.5.71.86')));
        $this->assertFalse($up2->areErrors());
    }

    public function testContinueOnErrorDefault()
    {
        $up2 = new upload();
        $this->assertFalse($up2->isContinueOnError());
    }

    public function testSetContinueOnError()
    {
        $this->up->setContinueOnError(true);
        $this->assertTrue($this->up->isContinueOnError());
    }

    public function testSetDontContinueOnError()
    {
        $this->up->setContinueOnError(false);
        $this->assertFalse($this->up->isContinueOnError());
    }

    public function testSetLogFileFail()
    {
        // tricky to test: given logfile must exist but we don't have the
        // path to error.log - test for failure only
        $this->up->setLogFile('does-not-exist.log');
        // there is no getLogFile() method ...
        $this->assertEquals('', $this->up->getLogFile());
    }

    public function testSetLoggingFail()
    {
        // see testSetLogFileFail() ...
        $this->up->setLogging(true);
        $this->assertFalse($this->up->loggingEnabled());
    }

    public function testLoggingEnabledDefault()
    {
        $this->assertFalse($this->up->loggingEnabled());
    }

    public function testSetDebug()
    {
        $this->up->setDebug(true);
        // there is no getDebug() method ...
        $this->assertTrue($this->up->isDebug());
    }

    public function testGetIgnoreMimeCheckDefault()
    {
        // this better be off by default ...
        $up2 = new upload();
        $this->assertFalse($up2->isIgnoreMimeTest());
    }

    public function testSetIgnoreMimeCheck()
    {
        $up2 = new upload();
        $up2->setIgnoreMimeCheck(true);
        $this->assertTrue($up2->isIgnoreMimeTest());
    }

    public function testAreErrorsDefault()
    {
        $this->assertFalse($this->up->areErrors());
    }

    public function testSetAllowedMimeTypes()
    {
        $mytypes = array('image/jpeg' => 'jpg', 'image/jpeg' => 'jpeg');
        $this->up->setAllowedMimeTypes($mytypes);
        $this->assertEquals($mytypes, $this->up->getAllowedMimeTypes());
    }

    public function testSetAllowedMimeTypesIllegal()
    {
        // Perl scripts are NOT in the list of allowed types. However, that
        // list is only checked against during upload, so expect success here.
        $mytype = array('application/x-perl' => 'pl');
        $this->up->setAllowedMimeTypes($mytype);
        $this->assertEquals($mytype, $this->up->getAllowedMimeTypes());
    }

    public function testGetAllowedMimeTypesDefault()
    {
        $up2 = new upload();
        $allowed = $up2->getAllowedMimeTypes();
        $this->assertEquals(0, count($allowed));
    }

    public function testIgnoreCheckMimeType()
    {
        // checkMimeType() would require an actual upload, so only test that
        // the check can be disabled
        $up2 = new upload();
        $up2->setIgnoreMimeCheck(true);
        $this->assertTrue($up2->checkMimeType());
    }

    public function testGetPathDefault()
    {
        $this->assertEquals('', $this->up->getPath());
    }

    // not sure how to test setPath method as that would check for a
    // writable path ...

    public function testSetFileNames()
    {
        $myFiles = array('file1.tmp', 'file2.dat');
        $this->up->setFileNames($myFiles);
        $this->assertEquals($myFiles, $this->up->getFileNames());
    }

    public function testSetOneFileName()
    {
        $myfile = 'file1.dat';
        $this->up->setFileNames($myfile);
        $this->assertEquals(array($myfile), $this->up->getFileNames());
    }

    public function testSetPerms()
    {
        $myperms = array(0x644, 0x750);
        $this->up->setPerms($myperms);
        $this->assertEquals($myperms, $this->up->getPermissions());
    }

    public function testSetOnePerm()
    {
        $myperm = 0x664;
        $this->up->setPerms($myperm);
        $this->assertEquals(array($myperm), $this->up->getPermissions());
    }

    public function testNumFiles()
    {
        $this->assertEquals(0, $this->up->numFiles());
    }
}
