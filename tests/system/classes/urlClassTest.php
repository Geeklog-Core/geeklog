<?php

use \PHPUnit\Framework\TestCase as TestCase;

/**
 * Simple tests for the url class
 */
class urlClass extends TestCase
{
    /**
     * @var Url
     */
    private $url;

    protected function setUp()
    {
        // Assign default values
        $this->url = new Url();
    }

    public function testIsEnabled()
    {
        $this->assertTrue($this->url->isEnabled());
    }

    public function testSetEnabled()
    {
        $this->url->setEnabled(false);
        $this->assertFalse($this->url->isEnabled());
        $this->url->setEnabled(true);
        $this->assertTrue($this->url->isEnabled());
    }

    public function testNumArguments()
    {
        $this->assertEquals(0, $this->url->numArguments());
    }

    public function testSetArgNames()
    {
        $this->assertTrue($this->url->setArgNames(array('test')));
    }

    public function testGetUnknownArgument()
    {
        // unknown argument names always return ''
        $this->assertEquals('', $this->url->getArgument('blah'));
    }

    public function testGetFakeArgument()
    {
        $_GET['test'] = 42;
        $this->assertEquals(42, $this->url->getArgument('test'));
    }

    public function testBuildUrl()
    {
        $this->assertEquals('http://www.example.com/index.php/value',
            $this->url->buildUrl('http://www.example.com/index.php?name=value'));
    }

    public function testBuildUrlNoChange()
    {
        $this->assertEquals('http://www.example.com/index.php',
            $this->url->buildUrl('http://www.example.com/index.php'));
    }

    // additional tests, starting with: new url(false)

    public function testIsDisabled()
    {
        $url2 = new url(false);
        $this->assertFalse($url2->isEnabled());
    }

    public function testSetEnabled2()
    {
        $url2 = new url(false);

        $url2->setEnabled(true);
        $this->assertTrue($url2->isEnabled());

        $url2->setEnabled(false);
        $this->assertFalse($url2->isEnabled());
    }

    public function testBuildUrl2()
    {
        $url2 = new url(false);

        $this->assertEquals('http://www.example.com/index.php/value',
            $url2->buildUrl('http://www.example.com/index.php/value'));
    }
}
