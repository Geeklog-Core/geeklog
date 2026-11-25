<?php
// PHP 5.6-compatible resource registration and cache suffix contract.
$_SERVER['PHP_SELF'] = '/admin/article.php';
$root = dirname(dirname(__DIR__)) . '/public_html/';
require $root . 'editors/tinymce/functions.php';
function check($condition, $message) {
    if (!$condition) { throw new RuntimeException($message); }
}
class ResourceStub {
    public $files = array();
    public $inline = '';
    public function setJavaScriptFile($name, $url, $footer, $priority, $defer) {
        $this->files[] = array($name, $url, $footer, $priority, $defer);
    }
    public function setJavaScript($code) { $this->inline = $code; }
}
$_CONF = array('site_url'=>'https://example.test', 'path_html'=>$root, 'path_editors'=>$root.'editors/');
$_SCRIPTS = new ResourceStub();
$LANG_ISO639_1 = 'fr';
adveditor_init_tinymce();
adveditor_setup_tinymce('/javascript/storyeditor_adveditor.js');
check(count($_SCRIPTS->files) === 4, 'Four ordered scripts');
foreach ($_SCRIPTS->files as $i => $file) {
    check($file[2] === true && $file[3] === 200 + $i && $file[4] === false, 'Script ordering');
    check(preg_match('~^https://example\\.test/.*\\.js\\?v=8\\.11\\.0-[0-9]+$~D', $file[1]), 'Versioned same-site URL');
}
check(strpos($_SCRIPTS->inline, 'geeklogTinyMceCacheSuffix') !== false, 'Cache suffix exposed');
check(strpos($_SCRIPTS->inline, 'fr-FR') !== false, 'French language');
$dir = sys_get_temp_dir() . '/geeklog-tinymce-' . uniqid();
mkdir($dir);
try {
    file_put_contents($dir . '/package.json', '{"version":"8.11.0"}');
    file_put_contents($dir . '/a.js', 'test');
    file_put_contents($dir . '/b.css', 'test');
    touch($dir . '/a.js', 100);
    touch($dir . '/b.css', 200);
    clearstatcache();
    $before = adveditor_tinymce_asset_info($dir);
    touch($dir . '/a.js', 150);
    clearstatcache();
    $after = adveditor_tinymce_asset_info($dir);
    check($before['suffix'] !== $after['suffix'], 'Changing a non-latest file invalidates vendor suffix');
    check($after === adveditor_tinymce_asset_info($dir), 'Stable suffix');
} finally {
    unlink($dir . '/a.js'); unlink($dir . '/b.css'); unlink($dir . '/package.json'); rmdir($dir);
}
echo "TinyMCE resource contract passed\n";
