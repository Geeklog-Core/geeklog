<?php

namespace Geeklog\Test;

use PHPUnit\Framework\TestCase;

/**
 * Regression tests for content length settings in syndication (issue #1251).
 */
class SyndicationContentLengthTest extends TestCase
{
    public function testSummaryLengthBehavior()
    {
        // The helper itself is side-effect-free. Extract it from the actual
        // source to keep the test independent of the database/site bootstrap.
        $source = file_get_contents(__DIR__ . '/../../../system/lib-syndication.php');
        $matched = preg_match(
            '/function SYND_getFeedSummary\(\$text, \$length\)\s*\{.*?\n\}/s',
            $source,
            $matches
        );
        $this->assertSame(1, $matched, 'Syndication summary helper should exist');

        if (!function_exists('SYND_getFeedSummary')) {
            eval($matches[0]);
        }

        $fullText = '<p>Full article text <script>example()</script></p>';
        $this->assertSame('', \SYND_getFeedSummary($fullText, 0));
        $this->assertSame('', \SYND_getFeedSummary($fullText, '0'));
        $this->assertSame($fullText, \SYND_getFeedSummary($fullText, 1));

        // A positive length must delegate to the existing HTML-aware
        // truncator with the same arguments and suffix.
        if (!function_exists('COM_truncateHTML')) {
            eval('function COM_truncateHTML($text, $length, $suffix) {'
                . ' return substr($text, 0, $length) . $suffix; }');
        }

        $this->assertSame(
            \COM_truncateHTML($fullText, 12, ' ...'),
            \SYND_getFeedSummary($fullText, 12)
        );
    }
}
