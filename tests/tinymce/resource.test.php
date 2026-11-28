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
$locales = array(
    'en'=>'en', 'fr'=>'fr-FR', 'de'=>'de', 'es'=>'es', 'ru'=>'ru',
    'it'=>'it',
    'ja'=>'ja', 'he'=>'he-IL', 'fa'=>'fa', 'zh-Hans'=>'zh-CN', 'zh-Hant'=>'zh-TW',
    'FR_ca'=>'fr-FR', 'de-DE'=>'de', 'es_AR'=>'es', 'pt_BR'=>'pt-BR',
    'pt-PT'=>'pt-PT', 'zh_Hans_CN'=>'zh-CN', 'zh-Hant-HK'=>'zh-TW',
    'zh-SG'=>'zh-CN', 'zh-TW'=>'zh-TW', 'ko-KR'=>'ko-KR', 'nb_NO'=>'nb-NO',
    'sv-SE'=>'sv-SE', 'sl-SI'=>'sl-SI', 'bg-BG'=>'bg-BG',
    'en_US'=>'en', 'th'=>'en', '../fr'=>'en', 'fr/../../x'=>'en', ''=>'en',
);
foreach ($locales as $locale => $expected) {
    check(adveditor_tinymce_language($locale) === $expected, 'Locale: ' . $locale);
}
// Every installed pack must also be reachable by its own identifier.
foreach (glob($root . 'editors/tinymce/vendor/langs/*.js') as $file) {
    $locale = basename($file, '.js');
    check(adveditor_tinymce_language($locale) === $locale, 'Installed pack: ' . $locale);
}
// Check the locale declarations of every shipped UTF-8 Geeklog language file.
foreach (glob(dirname(dirname(__DIR__)) . '/language/*_utf-8.php') as $file) {
    $source = file_get_contents($file);
    check(preg_match('~\$LANG_ISO639_1\s*=\s*\x27([^\x27]+)\x27~', $source, $match) === 1, 'Language declaration: ' . $file);
    check(isset($locales[$match[1]]), 'Unreviewed Geeklog locale: ' . $match[1]);
    check(adveditor_tinymce_language($match[1]) === $locales[$match[1]], 'Geeklog locale: ' . $file);
}
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
