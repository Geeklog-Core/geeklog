<?php

use \PHPUnit\Framework\TestCase;

/**
 * (Very) Simple tests for the Story Class
 * There isn't much we can test without a database or lib-common.php, but
 * try it anyway ...
 */
class storyClass extends TestCase
{
    protected function setUp(): void
    {
    }

    public function testHasNoContent()
    {
        $st = new Article();
        $this->assertFalse($st->hasContent());
    }

    public function testHasNoContentAdmin()
    {
        $st = new Article('admin');
        $this->assertFalse($st->hasContent());
    }

    public function testGetSpamCheckFormatEmpty()
    {
        $st = new Article();
        $this->assertEquals('<h1></h1><p></p><p></p>',
            $st->getSpamCheckFormat());
    }

    public function testGetSidEmpty()
    {
        $st = new Article();
        $this->assertEquals("", $st->getSid());
    }

    public function testGetAccessNotSet()
    {
        $st = new Article();
        $this->assertNull($st->getAccess());
    }
}
