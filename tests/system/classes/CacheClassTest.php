<?php

namespace Geeklog\Test;

use Geeklog\Cache;
use PHPUnit\Framework\TestCase;

class CacheClassTest extends TestCase
{
    /**
     * Enabling caching must reverse a previous disable operation.
     */
    public function testEnableRestoresCaching()
    {
        $initialState = Cache::isEnabled();

        try {
            Cache::disable();
            $this->assertFalse(Cache::isEnabled());

            Cache::enable();
            $this->assertTrue(Cache::isEnabled());
        } finally {
            if ($initialState) {
                Cache::enable();
            } else {
                Cache::disable();
            }
        }
    }
}
