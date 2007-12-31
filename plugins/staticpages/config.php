<?php

require_once $_CONF['path_system'] . 'classes/config.class.php';
$sp_config = config::get_instance();
$sp_config->initConfig();


$LANG_configsubgroups['staticpages'][0] = 'Main Settings';
$LANG_fs['staticpages'][0] = 'Main Settings';

if(! $sp_config->group_exists('staticpages')){

    $sp_config->add('version', '1.5.0', 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('allow_php', 1, 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('sort_by', 'id',  'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('sort_menu_by', 'label', 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('delete_pages', 0 , 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('aftersave', 'item', 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('in_block', 1, 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('show_hits', 1, 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('show_date', 1, 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('filter_html', 0, 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('censor', 1, 'text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('default_permissions', array (3,2,2,2), '@text', 0, 0, null, 0, true, 'staticpages');
    $sp_config->add('atom_max_items', 10, 'text', 0, 0, null, 0, true, 'staticpages');


}

$_SP_CONF = $sp_config->get_config('staticpages');

?>
