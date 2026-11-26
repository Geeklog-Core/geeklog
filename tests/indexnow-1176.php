<?php
// Isolated callback regression test: never sends real IndexNow requests.
require __DIR__ . '/../plugins/xmlsitemap/xmlsitemap.class.php';
class TestSitemap1176 extends XMLSitemap
{
    public function endUpdate() { return true; }
    public function submitURL($url) {
        $GLOBALS['notifications'][] = $url;
        return 1;
    }
}
function COM_getCharset() { return 'utf-8'; }
function PLG_getItemInfo($type, $id, $fields, $uid) {
    return $GLOBALS['publicItem'] ? array(PLG_idToURL($type, '', $id), 0, 0, 'Test') : false;
}
function PLG_idToURL($type, $subtype, $id) {
    return 'https://example.test/article.php?story=' . $id;
}
$source = file_get_contents(__DIR__ . '/../plugins/xmlsitemap/functions.inc');
foreach (array('plugin_itemsaved_xmlsitemap', 'plugin_itemdeleted_xmlsitemap') as $name) {
    if (!preg_match('/^function ' . $name . '\\(.*?^\\}/ms', $source, $match)) {
        throw new RuntimeException('Callback not found: ' . $name);
    }
    $code = str_replace("require_once __DIR__ . '/xmlsitemap.class.php';", '', $match[0]);
    eval(str_replace('new XMLSitemap(', 'new TestSitemap1176(', $code));
}
$dir = sys_get_temp_dir() . '/indexnow1176-' . uniqid();
mkdir($dir);
$_CONF = array('path_html' => $dir . '/');
$_XMLSMAP_CONF = array('types' => array('article'), 'sitemap_file' => 'sitemap.xml', 'indexnow' => true);
function check1176($label, $public, $listed, $delete, $old, array $expected, $enabled = true)
{
    global $_CONF, $_XMLSMAP_CONF, $publicItem, $notifications;
    $publicItem = $public;
    $notifications = array();
    $_XMLSMAP_CONF['indexnow'] = $enabled;
    $xml = '<urlset>';
    if ($listed !== '') {
        $xml .= '<url><loc>' . htmlspecialchars(PLG_idToURL('article', '', $listed), ENT_QUOTES, 'UTF-8') . '</loc></url>';
    }
    file_put_contents($_CONF['path_html'] . 'sitemap.xml', $xml . '</urlset>');
    if ($delete) {
        plugin_itemdeleted_xmlsitemap('current', 'article', '');
    } else {
        plugin_itemsaved_xmlsitemap('current', 'article', $old, '');
    }
    $urls = array_map(function ($id) { return PLG_idToURL('article', '', $id); }, $expected);
    if ($notifications !== $urls) {
        throw new RuntimeException('FAIL: ' . $label . ' ' . json_encode($notifications));
    }
    echo "OK: $label\n";
}
try {
    check1176('Save draft', false, '', false, '', array());
    check1176('Publish', true, '', false, '', array('current'));
    check1176('Update public item', true, 'current', false, '', array('current'));
    check1176('Unpublish', false, 'current', false, '', array('current'));
    check1176('Rename public item', true, 'old', false, 'old', array('old','current'));
    check1176('Delete public item', false, 'current', true, '', array('current'));
    check1176('Delete unpublished draft', false, '', true, '', array());
    check1176('Disabled IndexNow', true, 'current', false, '', array(), false);
    echo "TOTAL: 8/8 checks passed\n";
} finally {
    unlink($dir . '/sitemap.xml');
    rmdir($dir);
}
