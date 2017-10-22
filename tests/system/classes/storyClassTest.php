<?php

use \PHPUnit\Framework\TestCase;

/**
 * (Very) Simple tests for the Story Class
 * There isn't much we can test without a database or lib-common.php, but
 * try it anyway ...
 */
class storyClass extends TestCase
{
    protected function setUp()
    {
    }

    public function testHasNoContent()
    {
        $st = new Story();
        $this->assertFalse($st->hasContent());
    }

    public function testHasNoContentAdmin()
    {
        $st = new Story('admin');
        $this->assertFalse($st->hasContent());
    }

    public function testGetSpamCheckFormatEmpty()
    {
        $st = new Story();
        $this->assertEquals('<h1></h1><p></p><p></p>',
            $st->getSpamCheckFormat());
    }

    public function testGetSidEmpty()
    {
        $st = new Story();
        $this->assertEquals("", $st->getSid());
    }

    public function testGetAccessNotSet()
    {
        $st = new Story();
        $this->assertNull($st->getAccess());
    }
}
