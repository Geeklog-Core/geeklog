<?php
/**
 * Regression guard for Geeklog issue #1163 (missing HTTP_REFERER).
 *
 * Standalone: php tests/security-referer-1163.php
 * Exercises the exact token-referrer predicate extracted from lib-security.php.
 * Does not replace an end-to-end CSRF token validation test.
 */
$source = file_get_contents(dirname(__DIR__) . '/system/lib-security.php');
$needle = '!isset($_SERVER[\'HTTP_REFERER\']) || $tokendata[\'urlfor\'] != $_SERVER[\'HTTP_REFERER\']';
if ($source === false || strpos($source, $needle) === false) {
    fwrite(STDERR, "Missing or modified HTTP_REFERER guard in SEC_checkToken\n");
    exit(1);
}

$cases = array(
    array('name' => 'missing referer', 'referer' => null, 'expected_reject' => true),
    array('name' => 'matching referer', 'referer' => 'https://example.test/admin/comment.php', 'expected_reject' => false),
    array('name' => 'mismatched referer', 'referer' => 'https://example.test/admin/other.php', 'expected_reject' => true),
    array('name' => 'empty referer', 'referer' => '', 'expected_reject' => true),
);

set_error_handler(function ($severity, $message) {
    throw new ErrorException($message, 0, $severity);
});
foreach ($cases as $case) {
    $_SERVER = array();
    if ($case['referer'] !== null) {
        $_SERVER['HTTP_REFERER'] = $case['referer'];
    }
    $tokendata = array('urlfor' => 'https://example.test/admin/comment.php');
    $reject = !isset($_SERVER['HTTP_REFERER']) || $tokendata['urlfor'] != $_SERVER['HTTP_REFERER'];
    if ($reject !== $case['expected_reject']) {
        fwrite(STDERR, "FAILED: " . $case['name'] . "\n");
        exit(1);
    }
}
restore_error_handler();
echo "OK: #1163 referer guard scenarios passed (4 cases)\n";
