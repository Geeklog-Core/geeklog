<?php

function spamx_update_ConfValues_1_2_1()
{
    global $_CONF;

    $c = config::get_instance();

    // Add in all the New Tabs
    $c->add('tab_main', null, 'tab', 0, 0, null, 0, true, 'spamx', 0);

    return true;
}

function spamx_update_ConfValues_1_2_2()
{
    global $_CONF, $_SPX_DEFAULT;

    // Now add in new Config options
    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/spamx/install_defaults.php';

    // Add in new config options
    $c->add('tab_modules', null, 'tab', 0, 0, null, 0, true, 'spamx', 10);
    $c->add('fs_sfs', null, 'fieldset', 0, 0, null, 0, true, 'spamx', 10);
    $c->add('sfs_enabled', $_SPX_DEFAULT['sfs_enabled'], 'select',
        0, 0, 1, 10, true, 'spamx', 10);
    $c->add('fs_snl', null, 'fieldset', 0, 10, null, 0, true, 'spamx', 10);
    $c->add('snl_enabled', $_SPX_DEFAULT['snl_enabled'], 'select',
        0, 10, 1, 10, true, 'spamx', 10);
    $c->add('snl_num_links', $_SPX_DEFAULT['snl_num_links'], 'text',
        0, 10, null, 20, true, 'spamx', 10);

    return true;
}

function spamx_update_ConfValues_1_3_0()
{
    global $_CONF, $_SPX_DEFAULT;

    // Now add in new Config options
    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/spamx/install_defaults.php';

    // Add in new config options
    $c->add('max_age', $_SPX_DEFAULT['max_age'], 'text',
        0, 0, null, 60, true, 'spamx', 0);
    $c->add('sfs_confidence', $_SPX_DEFAULT['sfs_confidence'], 'text',
        0, 0, null, 20, true, 'spamx', 10);
    $c->add('records_delete', $_SPX_DEFAULT['records_delete'], '%text', 0, 0, null, 70, true, 'spamx', 0);

    return true;
}

function spamx_update_ConfValues_1_3_4()
{
    global $_CONF, $_SPX_DEFAULT;

    // Now add in new Config options
    $c = config::get_instance();

    require_once $_CONF['path'] . 'plugins/spamx/install_defaults.php';

    // Add in new config options for Akismet module
    $c->add('fs_akismet', null, 'fieldset', 0, 20, null, 0, true, 'spamx', 10);
    $c->add('akismet_enabled', $_SPX_DEFAULT['akismet_enabled'], 'select', 0, 20, 1, 10, true, 'spamx', 10);
    $c->add('akismet_api_key', $_SPX_DEFAULT['akismet_api_key'], 'text', 0, 20, null, 20, true, 'spamx', 10);

    return true;
}
