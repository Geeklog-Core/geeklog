<?php
/** Source and encoding smoke guard for Geeklog issue #1158. */
$source = file_get_contents(dirname(__DIR__) . '/public_html/admin/group.php');
$expected = "htmlspecialchars($A['grp_descr'], ENT_QUOTES, COM_getCharset())";
if ($source === false || strpos($source, $expected) === false) {
    fwrite(STDERR, "Expected escaping guard not found\n");
    exit(1);
}
$payload = '\"><img src=x onerror=alert(1)>';
$safe = htmlspecialchars($payload, ENT_QUOTES, 'UTF-8');
if (strpos($safe, '<') !== false || strpos($safe, '"') !== false) {
    fwrite(STDERR, "HTML encoding failure\n");
    exit(1);
}
echo "OK: basic attribute escaping smoke guard\n";
