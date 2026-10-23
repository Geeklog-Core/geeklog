<?php

namespace Geeklog\Test;

use Geeklog\LocaleData;
use PHPUnit\Framework\TestCase;

/**
 * Regression coverage for optional Italian language files (issue #1229).
 */
class LocaleDataItalianTest extends TestCase
{
    public function testItalianIsRegistered()
    {
        $this->assertTrue(LocaleData::isLanguageSupported('italian_utf-8'));
    }

    public function testInstalledItalianFileIsSelectableOnlyWhenReadable()
    {
        $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'geeklog-locale-' . uniqid('', true);
        $this->assertTrue(mkdir($directory, 0700));

        try {
            $locale = new LocaleData();

            $this->assertArrayNotHasKey('italian_utf-8', $locale->getLanguageList($directory, 'UTF-8'));

            file_put_contents($directory . DIRECTORY_SEPARATOR . 'italian_utf-8.php', '<?php // test fixture');

            $languages = $locale->getLanguageList($directory, 'UTF-8');
            $this->assertArrayHasKey('italian_utf-8', $languages);
            $this->assertSame('Italiano (Italian)', $languages['italian_utf-8']);

            $filtered = $locale->getLanguageList($directory, 'UTF-8', true, ['english_utf-8']);
            $this->assertArrayNotHasKey('italian_utf-8', $filtered);

            $filtered = $locale->getLanguageList($directory, 'UTF-8', true, ['italian_utf-8']);
            $this->assertArrayHasKey('italian_utf-8', $filtered);
        } finally {
            @unlink($directory . DIRECTORY_SEPARATOR . 'italian_utf-8.php');
            @rmdir($directory);
        }
    }
}
