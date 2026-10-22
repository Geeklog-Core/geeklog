<?php
/** Focused regression guard for re-displayed configuration validation errors (#1158). */
$source = file_get_contents(dirname(__DIR__) . '/system/classes/config.class.php');
$guard = "htmlspecialchars(\$this->validationErrorValues[\$group][\$name], ENT_QUOTES, COM_getCharset())";
if ($source === false || strpos($source, $guard) === false) {
    fwrite(STDERR, "Missing escaping on failed configuration validation output\n");
    exit(1);
}
$payload = '\"><svg onload=alert(1)>';
$escaped = htmlspecialchars($payload, ENT_QUOTES, 'UTF-8');
if (strpos($escaped, '<') !== false || strpos($escaped, '"') !== false) {
    fwrite(STDERR, "HTML attribute escaping failed\n");
    exit(1);
}
echo "OK: config invalid-value attribute escaping guard\n";
