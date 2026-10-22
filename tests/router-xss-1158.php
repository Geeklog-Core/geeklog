<?php
/** Regression guard for CVE-2023-37787 router editor output escaping. */
$source = file_get_contents(dirname(__DIR__) . '/public_html/admin/router.php');
foreach (array('rule', 'route') as $key) {
    $expected = "htmlspecialchars(\$A['" . $key . "'], ENT_QUOTES, COM_getCharset())";
    if ($source === false || strpos($source, $expected) === false) {
        fwrite(STDERR, "Missing output escape for router " . $key . "\n");
        exit(1);
    }
}
$input = '\"><img src=x onerror=alert(1)>';
$output = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
if (strpos($output, '<') !== false || strpos($output, '"') !== false) {
    fwrite(STDERR, "Unsafe HTML attribute encoding\n");
    exit(1);
}
echo "OK: router editor output escaping guard\n";
