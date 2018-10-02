<?php

// *************************************
// Fix Group Assignments from Geeklog Install

// Remove Admin User (2) from all default groups assignments from the install except Root (1), All Users (2), Logged-In Users (13)
// Decided to delete all groups except listed above instead of original groups assigned since bug in previous user editor added inherited groups as actual group assignments
$_SQL[] = "DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_main_grp_id != 1 AND ug_main_grp_id != 2 AND ug_main_grp_id != 13) AND ug_uid = 2 AND ug_grp_id IS NULL";
// Remove All Users (2) from any other group (should be just for users)
$_SQL[] = "DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 2 AND ug_uid IS NULL AND ug_grp_id > 0";
// Remove Root Group (1) from All Users Group (2) (which all users already belong too)
$_SQL[] = "DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 2 AND ug_uid IS NULL AND ug_grp_id = 1";
// *************************************

// Remove unused Vars table record (originally inserted by devel-db-update script)
$_SQL[] = "DELETE FROM {$_TABLES['vars']} WHERE name = 'geeklog'";


/**
 * Upgrade Messages
 */
function upgrade_message220()
{
    // 3 upgrade message types exist 'information', 'warning', 'error'
    // error type means the user cannot continue upgrade until fixed

    // Fix User Security Group assignments for Groups: Root, Admin, All Users
    // Fix User Security Group assignments for Users: Admin
    $upgradeMessages['2.2.0'] = array(
        1 => array('warning', 22, 23), // Fix User Security Group assignments for Groups: Root, Admin, All Users - Fix User Security Group assignments for Users: Admin
        2 => array('warning', 24, 25) // FCKEditor removed
    );

    return $upgradeMessages;
}

/**
 * Add/Edit/Delete config options for new version
 */
function update_ConfValuesFor221()
{
    global $_CONF, $_TABLES;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $c = config::get_instance();

    $me = 'Core';
    
    // FCKEditor removed so make sure config is not set to use it. If is switch advance editor to CKEditor
    if (isset($_CONF['advanced_editor_name']) && $_CONF['advanced_editor_name'] == 'fckeditor') {
        $c->add('advanced_editor_name','ckeditor','select',4,20,NULL,845,TRUE, $me, 20);
    }

    return true;
}
