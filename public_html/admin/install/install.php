<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// | Geeklog installation script.                                              |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@users.sourceforge.net                |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | See the INSTALL.HTML file for more information on configuration           |
// | information                                                               |
// +---------------------------------------------------------------------------+
//
// $Id: install.php,v 1.35 2002/07/23 10:12:35 dhaun Exp $

if (!defined ("LB")) {
    define("LB", "\n");
}
if (!defined ('VERSION')) {
    define('VERSION', '1.3.6');
}

// Turn this on to have the install process print debug messages.  NOTE: these
// message will get written to installerrors.log as this file may not know
// anything about error.log (the Geeklog error log file)
$_INST_DEBUG = false;

/**
* Shows welcome page and gets location of /path/to/geeklog/. NOTE: this
* Doesn't use the template class because we need to know the path to geeklog
* before we can include it.
*
*/
function INST_welcomePage()
{
    // prepare some hints about what /path/to/geeklog might be ...
    $thisFile = __FILE__;
    $thisFile = strtr ($thisFile, '\\', '/'); // replace all '\' with '/'
    $glPath = $thisFile;
    for ($i = 0; $i < 4; $i++) {
        $remains = strrchr ($glPath, '/');
        if ($remains === false) {
            break;
        } else {
            $glPath = substr ($glPath, 0, -strlen ($remains));
        }
    }
    if (!file_exists ($glPath . '/config.php')) {
        $glPath = '';
    }

    $retval = '';

    $retval .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . LB;
    $retval .= '<html>' . LB;
    $retval .= '<head>' . LB;
    $retval .= '<title>Geeklog ' . VERSION . ' Installation</title>' . LB;
    $retval .= '</head>' . LB;
    $retval .= '<body bgcolor="#ffffff">' . LB;
    $retval .= '<h2>Geeklog Installation (Step 1 of 2)</h2>' . LB;
    $retval .= '<p>Welcome to Geeklog ' . VERSION . '.  This installation script has changed so please be sure to read this introductory paragraph in its entirety before proceeding.  We no longer support the web-based setup of config.php.  Due to complications in supporting a variety of operating systems in a variety of environments we have opted to revert that portion of the installation back to config.php.  With that said, you should edit config.php prior to running this script.  This script will, however, apply the database structures for both fresh installations and upgrades.';  
    $retval .= '<p>If you are new to Geeklog, welcome!  Of all the choices of open-source weblogs we are glad you have chosen to install Geeklog.  With Geeklog version ' . VERSION . ' you will be able to experience rich features, easy administration and an extendable platform that is fast and, most importantly, secure!  Ok, enough of the marketing rant...now for the installation! You are only 3 short steps from having Geeklog running on your system.<p>Before we get started it is important that if you are upgrading an existing Geeklog installation you back up your database AND your file system.  This installation script will alter your Geeklog database. Also, if you are upgrading from version 1.3 or older you may need your old lib-database.php file so be sure to save a copy of this file. <b>YOU HAVE BEEN WARNED</b>! <p> Also, this script will only upgrade you from 1.2.5-1 or later to version ' . VERSION . '.  If you are running a version of Geeklog older than 1.2.5-1 then you will need to manually upgrade to 1.2.5-1 using the scripts in /path/to/geeklog/sql/updates/. This script will do incremental upgrades after this version (i.e. when 1.4 comes out this script will be able to upgrade from 1.2.5-1, 1.3.x directly to 1.4).  Please note this script will not upgrade any beta versions of Geeklog. ';
    if (!ini_get ('register_globals')) {
        $retval .= '<p><strong>Warning:</strong> You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.</p>';
    }
    $install_options = '<option value="new_db">New Database</option>'.LB;
    $install_options .= '<option value="upgrade_db">Upgrade Database</option>'.LB;
    $retval .= '<center>' . LB;
    $retval .= '<form action="install.php" method="post">' . LB;
    $retval .= '<table border="0" cellpadding="0" cellspacing="0" width="100%">' . LB;
    $retval .= '<tr><td align="right">Installation Type:&nbsp;</td><td><select name="install_type">'. LB;
    $retval .= $install_options;
    $retval .= '</select></td></tr>'.LB;
    $retval .= '<tr><td align="right">Path to Geeklog:&nbsp;</td><td><input type="text" name="geeklog_path" value="' . $glPath . '" size="40"> do not include trailing "/" or "\".</td></tr>'.LB;
    $retval .= '<tr><td colspan="2" align="left"><p><br><strong>Hint:</strong> The complete path to this file is <b>' . $thisFile;
    if (!empty ($glPath)) {
        $retval .= '</b><br>and it appears your Path to Geeklog is <b>' . $glPath;
    }
    $retval .= '</b></p></td></tr>';
    $retval .= '<tr><td colspan="2" align="center"><input type="submit" value="Next >>"></td></tr>' . LB;
    $retval .= '</table>' . LB;
    $retval .= '<input type="hidden" name="page" value="1">' . LB;
    $retval .= '</form>' . LB;
    $retval .= '</center>' . LB;
    $retval .= '</body>' . LB;
    $retval .= '</html>' . LB;

    return $retval;
}

function INST_getDatabaseSettings($install_type, $geeklog_path)
{
    global $_CONF, $_TABLES;
    
    $db_templates = new Template($_CONF['path_system'] . 'install_templates');
    $db_templates->set_file(array('db'=>'databasesettings.tpl'));
    $db_templates->set_var('geeklog_path', $geeklog_path);
    
    if ($install_type == 'upgrade_db') {
        $db_templates->set_var('upgrade',1);
        // They already have a lib-database file...they can't change their tables names
        $old_versions = array('1.2.5-1','1.3','1.3.1','1.3.2','1.3.2-1','1.3.3','1.3.4','1.3.5');
        $versiondd = '<tr><td align="right"><b>Current Geeklog Version:</b></td><td><select name="version">';
        for ($j = 1; $j <= count($old_versions); $j++) {
           $versiondd .= '<option>' . current($old_versions) . '</option>';
           next($old_versions);
        }
        $versiondd .= '</select></td></tr>';
        $db_templates->set_var('UPGRADE_OPTIONS', $versiondd);
        $db_templates->set_var('DB_TABLE_OPTIONS', '');
    } else {
        // This is a fresh installation, let them change their table settings
        $db_templates->set_var('upgrade',0);
        $db_templates->set_var('UPGRADE_OPTIONS','');
    }

    return $db_templates->parse('output','db');
}

function INST_createDatabaseStructures() {
    global $_CONF, $_DB_dbms, $_TABLES;

    // Because the create table syntax can vary from dbms-to-dbms we are
    // leaving that up to each database driver (e.g. mysql.class.php, 
    // postgresql.class.php, etc)


    // Include lib-database.php now that it exists
    //require_once($_CONF['path_system'] . 'lib-database.php');
    //require_once($_CONF['path_system'] . 'databases/' . $_DB_dbms . '.class.php');
    //$instDB = new database($_DB_host,$_DB_name,$_DB_user,$_DB_pass,'');


    // Get DBMS-specific create table array and data array
    require_once($_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php');

    $progress = '';

    for ($i = 1; $i <= count($_SQL); $i++) {
        DB_query(current($_SQL));
        next($_SQL);
    }

    // Now insert mandatory data and a small subset of initial data
    for ($i = 1; $i <= count($_DATA); $i++) {
        $progress .= "executing " . current($_DATA) . "<br>\n";
        DB_query(current($_DATA));
        next($_DATA);
    }

    return true;
    // Done with installation...redirect to success page
    echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_CONF['site_url'] . '/admin/install/success.php"></head></html>';    
}

function INST_doDatabaseUpgrades($current_gl_version, $table_prefix) {
    global $_TABLES, $_CONF, $_DB_dbms;

    // Because the upgrade sql syntax can vary from dbms-to-dbms we are
    // leaving that up to each Geeklog database driver

    $done = false;
    $progress = '';
    while ($done == false) {
        switch ($current_gl_version) {
        case '1.2.5-1':
            // Get DMBS-specific update sql
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.2.5-1_to_1.3.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL));
                next($_SQL);
            }
            // OK, now we need to add all users except anonymous to the All Users group and Logged in users group
            // I can hard-code these group numbers because the group table was JUST created with these numbers
            $result = DB_query("SELECT uid FROM {$_TABLES['users']} WHERE uid <> 1");
            $nrows = DB_numRows($result);
            for ($i = 1; $i <= $nrows; $i++) {
                $U = DB_fetchArray($result);
                DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES (2, {$U['uid']}, NULL)");
                DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES (13, {$U['uid']}, NULL)");
            }
            // Now take care of any orphans off the user table...and let me curse MySQL lack for supporint foreign
            // keys at this time ;-)
            $result = DB_query("SELECT MAX(uid) FROM {$_TABLES['users']}");
            $ITEM = DB_fetchArray($result);
            $max_uid = $ITEM[0];
            if (!empty($max_uid) AND $max_uid <> 0) {
                DB_query("DELETE FROM {$_TABLES['userindex']} WHERE uid > $max_uid");
                DB_query("DELETE FROM {$_TABLES['userinfo']} WHERE uid > $max_uid");
                DB_query("DELETE FROM {$_TABLES['userprefs']} WHERE uid > $max_uid");
                DB_query("DELETE FROM {$_TABLES['usercomment']} WHERE uid > $max_uid");
            }
            $current_gl_version = '1.3';
            $_SQL = '';
            break;
        case '1.3':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3_to_1.3.1.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL));
                next($_SQL);
            }
            $current_gl_version = '1.3.1';
            $_SQL = '';
            break;
        case '1.3.1':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.1_to_1.3.2.php');
             for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL));
                next($_SQL);
            }
            $current_gl_version = '1.3.2-1';
            $_SQL = '';
            break;
        case '1.3.2':
        case '1.3.2-1':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.2-1_to_1.3.3.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL));
                next($_SQL);
            }
            // Now we need to switch how user blocks are stored.  Right now we only store the blocks the
            // user wants.  This will switch it to store the ones they don't want which allows us to add
            // new blocks and ensure they are shown to the user.
            $result = DB_query("SELECT {$_TABLES['users']}.uid,boxes FROM {$_TABLES['users']},{$_TABLES['userindex']} WHERE boxes IS NOT NULL AND boxes <> '' AND {$_TABLES['users']}.uid = {$_TABLES['userindex']}.uid");
            $nrows = DB_numRows($result);
            for ($i = 1; $i <= $nrows; $i++) {
                $row = DB_fetchArray($result);
                $ublocks = str_replace(' ',',',$row['boxes']);
                $result2 = DB_query("SELECT bid,name FROM {$_TABLES['blocks']} WHERE bid NOT IN ($ublocks)");
                $newblocks = '';
                for ($x = 1; $x <= DB_numRows($result2); $x++) {
                    $curblock = DB_fetchArray($result2);
                    if ($curblock['name'] <> 'user_block' AND $curblock['name'] <> 'admin_block' AND $curblock['name'] <> 'section_block') {
                        $newblocks .= $curblock['bid'];
                        if ($x <> DB_numRows($result2)) {
                            $newblocks .= ' ';
                        }
                    }
                }
                DB_query("UPDATE {$_TABLES['userindex']} SET boxes = '$newblocks' WHERE uid = {$row['uid']}");
            }
            $current_gl_version = '1.3.3';
            $_SQL = '';
            break;
        case '1.3.3':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.3_to_1.3.4.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }

            $current_gl_version = '1.3.4';
            $_SQL = '';
            break;
	case '1.3.4':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.4_to_1.3.5.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }
            $result = DB_query("SELECT ft_id FROM {$_TABLES['features']} WHERE ft_name = 'user.mail'");
            $row = DB_fetchArray($result);            
            $mail_ft = $row['ft_id'];
            $result = DB_query("SELECT grp_id FROM {$_TABLES['groups']} WHERE grp_name = 'Mail Admin'");
            $row = DB_fetchArray($result);
            $group_id = $row['grp_id'];
            DB_query("INSERT INTO {$_TABLES['access']} (acc_grp_id, acc_ft_id) VALUES ($group_id, $mail_ft)");

            $current_gl_version = '1.3.5';
            $_SQL = '';
            break;
        case '1.3.5':
            require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.5_to_1.3.6.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                DB_query(current($_SQL));
                next($_SQL);
            }

            $current_gl_version = '1.3.6';
            $_SQL = '';
            break;
        default:
            $done = true;
        }
    }
    return true;
}

// Main
if (isset ($HTTP_POST_VARS['page'])) {
    $page = $HTTP_POST_VARS['page'];
}
else {
    $page = 0;
}

if (isset ($HTTP_POST_VARS['action']) && ($HTTP_POST_VARS['action'] == '<< Previous')) {
    $page = 0;
}

// If possible, load the config file so we can get current settings.  If we
// can't then that means this is a fresh installation OR they want to start
// with the our system defaults.

// Include template class if we got it
if ($page > 0) {
    require_once($HTTP_POST_VARS['geeklog_path'] . '/system/classes/template.class.php');
    require_once($HTTP_POST_VARS['geeklog_path'] . '/config.php');
    require_once($HTTP_POST_VARS['geeklog_path'] . '/system/lib-database.php');
}

$display = '';

switch ($page) {
case 1:
    if ($HTTP_POST_VARS['install_type'] == 'complete_upgrade') {
        $upgrade = 1;
    } else {
        $upgrade = 0;
    }
    $display .= INST_getDatabaseSettings($HTTP_POST_VARS['install_type'], $HTTP_POST_VARS['geeklog_path']); 
    break;
case 2:
    if (!empty($version)) {
        if (INST_doDatabaseUpgrades($version, $HTTP_POST_VARS['prefix'])) {
            // Great, installation is complete
            // Done with installation...redirect to success page
            echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_CONF['site_url'] . '/admin/install/success.php"></head></html>';
        }
    } else {
        if (INST_createDatabaseStructures()) {
            // Done with installation...redirect to success page
            echo '<html><head><meta http-equiv="refresh" content="0; URL=' . $_CONF['site_url'] . '/admin/install/success.php"></head></html>';
            // Great, installation is complete
        }
    }
    break;
default:
    // Ok, let's display a welcome page
    $display .= INST_welcomePage();
    break;
}

echo $display;

?>
