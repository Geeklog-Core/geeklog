<?php

function xmlsitemap_update_ConfValues_1_0_0()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();
    $me = 'xmlsitemap';

    // Add in all the New Tabs
    $c->add('tab_main', null, 'tab', 0, 0, null, 0, true, $me, 0);
    $c->add('tab_pri', null, 'tab', 0, 1, null, 0, true, $me, 1);
    $c->add('tab_freq', null, 'tab', 0, 2, null, 0, true, $me, 2);

    return true;
}

function xmlsitemap_update_ConfValues_1_0_1()
{
    global $_CONF, $_XMLSMAP_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $_CONF['path'] . 'plugins/xmlsitemap/install_defaults.php';

    $c = config::get_instance();
    $me = 'xmlsitemap';
    
    // Content types to include lastmod element
    $c->add('lastmod', $_XMLSMAP_DEFAULT['lastmod'], '%text', 0, 0, null,
        50, true, $me, 0);       

    // Ping targets
    $c->add('tab_ping', null, 'tab', 0, 3, null, 0, true, $me, 3);
    $c->add('fs_ping', null, 'fieldset', 0, 3, null, 0, true, $me, 3);
    $c->add('ping_google', $_XMLSMAP_DEFAULT['ping_google'], 'select', 0,
        3, 1, 100, true, $me, 3);
    $c->add('ping_bing', $_XMLSMAP_DEFAULT['ping_bing'], 'select', 0,
        3, 1, 110, true, $me, 3);
}

?>
