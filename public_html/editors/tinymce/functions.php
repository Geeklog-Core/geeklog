<?php
// Geeklog Advanced Editor adapter. GPL-2.0-or-later.
if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}
function adveditor_config_tinymce()
{
    return array('name' => 'TinyMCE', 'file' => 'vendor/tinymce.min.js',
        'footer' => true, 'priority' => 200);
}

/**
 * Read the bundled engine version and fingerprint resource modification dates.
 * One stable suffix covers all dynamically loaded vendor assets.
 */
function adveditor_tinymce_asset_info($directory)
{
    $package = json_decode((string) @file_get_contents($directory . '/package.json'), true);
    $version = isset($package['version']) && preg_match('/^[0-9]+(?:\.[0-9]+){2}$/D', $package['version'])
        ? $package['version'] : 'unknown';
    $dates = array();
    $latest = 0;
    if (is_dir($directory)) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
            $directory, FilesystemIterator::SKIP_DOTS));
        foreach ($files as $file) {
            if ($file->isFile() && preg_match('/\.(js|css)$/i', $file->getFilename())) {
                $relative = str_replace('\\', '/', substr($file->getPathname(), strlen($directory) + 1));
                $mtime = $file->getMTime();
                $dates[$relative] = $mtime;
                $latest = max($latest, $mtime);
            }
        }
    }
    ksort($dates);
    return array('version' => $version, 'suffix' => '?v=' . $version . '-' . $latest . '-' .
        substr(sha1(serialize($dates)), 0, 12));
}

function adveditor_tinymce_resource_url($path, $version)
{
    global $_CONF;
    $path = '/' . ltrim($path, '/');
    $mtime = (int) @filemtime(rtrim($_CONF['path_html'], '/\\') . $path);
    return rtrim($_CONF['site_url'], '/') . $path . '?v=' . rawurlencode($version) . '-' . $mtime;
}

/**
 * Register all four scripts in the same ordered Resource group. A query string
 * on a local Resource path is rejected by its filesystem existence check.
 * Absolute same-site URLs bypass bundling and retain the real asset location.
 */
function adveditor_setup_tinymce($custom)
{
    global $_CONF, $_SCRIPTS;
    $dir = trim(str_replace(str_replace('\\', '/', $_CONF['path_html']), '',
        str_replace('\\', '/', $_CONF['path_editors'])), '/');
    $editor = '/' . $dir . '/tinymce';
    $assets = adveditor_tinymce_asset_info(__DIR__ . '/vendor');
    $scripts = array(
        'adveditor_tinymce' => $editor . '/vendor/tinymce.min.js',
        'adveditor_main' => '/javascript/advanced_editor.js',
        'adveditor_api_tinymce' => $editor . '/functions.js',
        'adveditor_custom' => $custom,
    );
    $priority = 200;
    foreach ($scripts as $name => $path) {
        if (is_string($path) && $path !== '' && is_file(rtrim($_CONF['path_html'], '/\\') . '/' . ltrim($path, '/'))) {
            $_SCRIPTS->setJavaScriptFile($name, adveditor_tinymce_resource_url($path, $assets['version']),
                true, $priority, false);
        }
        ++$priority;
    }
}

function adveditor_init_tinymce()
{
    global $_CONF, $_SCRIPTS, $LANG_ISO639_1;
    $dir = trim(str_replace(str_replace('\\', '/', $_CONF['path_html']), '',
        str_replace('\\', '/', $_CONF['path_editors'])), '/');
    $base = rtrim($_CONF['site_url'], '/') . '/' . $dir . '/tinymce/vendor';
    $assets = adveditor_tinymce_asset_info(__DIR__ . '/vendor');
    $map = array('fr' => 'fr-FR', 'fr-ca' => 'fr-FR', 'pt' => 'pt-PT', 'pt-br' => 'pt-BR',
        'he' => 'he-IL', 'ko' => 'ko-KR', 'zh-cn' => 'zh-CN', 'zh' => 'zh-TW',
        'nb' => 'nb-NO', 'sv' => 'sv-SE', 'sl' => 'sl-SI', 'bg' => 'bg-BG');
    $language = isset($map[$LANG_ISO639_1]) ? $map[$LANG_ISO639_1] : $LANG_ISO639_1;
    if (!preg_match('/^[a-z]{2}(?:-[A-Z]{2})?$/D', $language) ||
        !is_file(__DIR__ . '/vendor/langs/' . $language . '.js')) {
        $language = 'en';
    }
    $_SCRIPTS->setJavaScript('<script type="text/javascript">var geeklogTinyMceBase = ' .
        json_encode($base, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) .
        '; var geeklogTinyMceLanguage = ' . json_encode($language) .
        '; var geeklogTinyMceCacheSuffix = ' . json_encode($assets['suffix']) . ';</script>');
}
