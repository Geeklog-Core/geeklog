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

function adveditor_init_tinymce()
{
    global $_CONF, $_SCRIPTS, $LANG_ISO639_1;
    $dir = trim(str_replace($_CONF['path_html'], '', $_CONF['path_editors']), '/');
    $base = $_CONF['site_url'] . '/' . $dir . '/tinymce/vendor';
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
        '; var geeklogTinyMceLanguage = ' . json_encode($language) . ';</script>');
}
