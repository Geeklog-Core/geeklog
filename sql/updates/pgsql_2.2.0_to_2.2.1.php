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

// Add structured data type to article table and modified date
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `structured_data_type` tinyint(4) NOT NULL DEFAULT 0 AFTER `commentcode`";
$_SQL[] = "ALTER TABLE {$_TABLES['stories']} ADD `modified` timestamp default NULL AFTER `date`";

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
        2 => array('warning', 24, 25), // FCKEditor removed
        3 => array('warning', 26, 27) // Google+ OAuth Login Method removed
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
    
    // Default Structured Data type for new articles
    $c->add('structured_data_type_default',2,'select',1,7,39,1275,TRUE, $me, 7); // Setting article as the default
    
    // Add absolute path for logo image which is used by the Publisher property with Structured Data
    $c->add('path_site_logo','','text',0,0,NULL,65,TRUE, $me, 0);
    
    // Add switch to enable setting of language id for item if Geeklog Multi Language is setup
    $c->add('new_item_set_current_lang',0,'select',6,28,0,380,TRUE, $me, 28);
    
    // Remove Google+ OAuth login method 
    $c->del('google_login', $me);
    $c->del('google_consumer_key', $me);
    $c->del('google_consumer_secret', $me);

    return true;
}

/**
 * Convert all user accounts that use Google+ OAuth login method to regular accounts
 *
 * @return bool
 */
function convertGoogleAccounts221()
{
    global $_TABLES;

    $remote_grp = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Remote Users'");
    
    // Find all Google accounts
    $sql = "SELECT uid, status, email FROM {$_TABLES['users']} 
        WHERE remoteservice = 'oauth.google'";
    
    $result = DB_query($sql);
    $numRows = DB_numRows($result);
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);
        
        $uid = $A['uid'];
        $status = $A['status'];
        $email = $A['email'];
        
        // Remove them from remote accounts group
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $remote_grp AND ug_uid = $uid");
        
        
        // If user account is active and has no email then it cannot function as a regular account so lock it
        // Cannot set status to USER_ACCOUNT_NEW_EMAIL since user doesn't know his password as a new one is being created
        if ($status == USER_ACCOUNT_ACTIVE && empty($email)) {
            $status = USER_ACCOUNT_LOCKED;
        }
        // If account looking for new email then lock it since user does not know password and admin has deemed email to be invalid
        if ($status == USER_ACCOUNT_NEW_EMAIL) {
            $status = USER_ACCOUNT_LOCKED;
        }
        
        // Add null to remoteusername and remoteservice
        $sql = "UPDATE {$_TABLES['users']} SET 
        remoteusername = NULL, remoteservice = NULL, status = $status 
        WHERE uid = $uid";
        DB_query($sql);
        
        // Update user with random password
        $passwd = ''; //Pass empty so random will be created
        SEC_updateUserPassword($passwd, $uid);
    }
    
    return true;
}
