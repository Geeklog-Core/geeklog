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
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@dingoblue.net.au                    |
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
// $Id: install.php,v 1.25 2002/04/17 19:57:24 tony_bibbs Exp $

define(LB, "\n");

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
    $retval = '';

    $retval .= '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . LB;
    $retval .= '<html>' . LB;
    $retval .= '<head>' . LB;
    $retval .= '<title>Geeklog 1.3 Installation</title>' . LB;
    $retval .= '</head>' . LB;
    $retval .= '<body bgcolor="#ffffff">' . LB;
    $retval .= '<h2>Geeklog Installation (Step 1 of 2)</h2>' . LB;
    $retval .= '<P>Welcome to Geeklog 1.3.5.  This installation script has changed so please be sure to read this introductory paragraph in its entirety before proceeding.  We no longer support the web-based setup of config.php.  Due to complications in supporting a variety of operating systemss in a variety of environments we have opted to revert that portion of the installation back to config.php.  With that said, you should edit config.php prior to running this script.  This script will, however, apply the database structures for both fresh installations and upgrades.';  
    $retval .= '<P>If you are new to Geeklog, welcome!  Of all the choices of open-source weblogs we are glad you have chosen to install Geeklog.  With Geeklog version 1.3.5 you will be able to experience rich features, easy administration and an extendable platform that is fast and, most importantly, secure!  Ok, enough of the marketing rant...now for the installation! You are only 3 short steps from having Geeklog running on your system.<P>Before we get started it is important that if you are upgrading an existing Geeklog installation you back up your database AND your file system.  This installation script will alter your Geeklog database. Also, if you are upgrading from version 1.3 or older you may need your old lib-database.php file so be sure to save a copy of this file. <b>YOU HAVE BEEN WARNED</b>! <P> Also, this script will only upgrade you from 1.2.5-1 or later to version 1.3.5.  If you are running a version of Geeklog older than 1.2.5-1 then you will need to manaully upgrade to 1.2.5-1 using the scripts in /path/to/geeklog/sql/updates/. This script will do incremental upgrades after this version (i.e. when 1.4 comes out this script will be able to upgrade from 1.2.5-1, 1.3.x directly to 1.4.  Please note this script will not upgrade any beta versions of Geeklog. ';
    $install_options = '<option value="new_db">New Database</option>'.LB;
    $install_options .= '<option value="upgrade_db">Upgrade Database</option>'.LB;
    $retval .= '<center>' . LB;
    $retval .= '<form action="install.php" method="post">' . LB;
    $retval .= '<table border="0" cellpadding="0" cellspacing="0">' . LB;
    $retval .= '<tr><td align="right">Installation Type:</td><td><select name="install_type">'. LB;
    $retval .= $install_options;
    $retval .= '</select></td>'.LB;
    $retval .= '<tr><td align="right">Path to Geeklog: </td><td><input type="text" name="geeklog_path"> do not include trailing "/" or "\".</td></tr>'.LB;
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
        // The already have a lib-database file...they can't chnage their tables names
        $old_versions = array('1.2.5-1','1.3','1.3.1','1.3.2','1.3.2-1','1.3.3','1.3.4');
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
        //reset($_TABLES);
        //for ($i = 1; $i <= count($_TABLES); $i++) {
        //    $db_templates->set_var('orig_tablename', key($_TABLES));
        //    $db_templates->set_var('new_tablename', current($_TABLES));
        //    $db_templates->parse('TABLE_ENTRY', 'tableentry', true);
        //    next($_TABLES);
        //}
        $db_templates->set_var('UPGRADE_OPTIONS','');
        //$db_templates->parse('DB_TABLE_OPTIONS', 'tables'); 
    }

    return $db_templates->parse('output','db');
}

function INST_createDatabaseStructures() {
    global $_CONF, $_DB_dbms, $_TABLES;

    // Because the create table syntax can vary from dbms-to-dbms we are
    // leaving that up to each database driver (e.g. mysql.class.php, 
    // postgresql.class.php, etc)


    // Include lib-database.php now that it exists
    //include_once($_CONF['path_system'] . 'lib-database.php');
    //include_once($_CONF['path_system'] . 'databases/' . $_DB_dbms . '.class.php');
    //$instDB = new database($_DB_host,$_DB_name,$_DB_user,$_DB_pass,'');


    // Get DBMS-specific create table array and data array
    include_once($_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php');

    $progress = '';

    for ($i = 1; $i <= count($_SQL); $i++) {
        //DB_query(current($_SQL));
        //$progress .= "executing " . current($_SQL) . "<br>\n";
        DB_query(current($_SQL));
        //$error = $instDB->dbError(current($_SQL));
        //if (!empty($error)) {
        //    echo $progress . $error;
        //    return false;
        //}
        next($_SQL);
    }

    // Now insert mandatory data and a small subset of initial data
    for ($i = 1; $i <= count($_DATA); $i++) {
        $progress .= "executing " . current($_DATA) . "<br>\n";
        DB_query(current($_DATA));
        //$error = $instDB->dbError(current($_DATA));
        //if (!empty($error)) {
        //    echo $progress . $error;
        //    return false;
        //}
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
            include_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.2.5-1_to_1.3.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL),1);
                //$error = DB_error(current($_SQL));
                //if (!empty($error)) {
                //    echo $progress . $error;
                //    return false;
                //}
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
            include_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3_to_1.3.1.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL),1);
                //$error = $instDB->dbError(current($_SQL));
                //if (!empty($error)) {
                //    echo $progress . $error;
                //    return false;
                //}
                next($_SQL);
            }
            $current_gl_version = '1.3.1';
            $_SQL = '';
            break;
        case '1.3.1':
            include_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.1_to_1.3.2.php');
             for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL),1);
                //$error = $instDB->dbError(current($_SQL));
                //if (!empty($error)) {
                //    echo $progress . $error;
                //    return false;
                //}
                next($_SQL);
            }
            $current_gl_version = '1.3.2-1';
            $_SQL = '';
            break;
        case '1.3.2':
        case '1.3.2-1':
            include_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.2-1_to_1.3.3.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL),1);
                //$error = $instDB->dbError(current($_SQL));
                //if (!empty($error)) {
                //    echo $progress . $error;
                //    return false;
                //}
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
            include_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.3_to_1.3.4.php');
            for ($i = 1; $i <= count($_SQL); $i++) {
                $progress .= "executing " . current($_SQL) . "<br>\n";
                DB_query(current($_SQL),1);
                //$error = $instDB->dbError(current($_SQL));
                //if (!empty($error)) {
                //    echo $progress . $error;
                //    return false;
                //}
                next($_SQL);
            }

            $current_gl_version = '1.3.4';
            $_SQL = '';
            break;
	case '1.3.4':
            include_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.4_to_1.3.5.php');
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
        default:
            $done = true;
        }
    }
    return true;
}

// Main

if ($action == '<< Previous') {
    $page = 0;
}

// If possible, load the config file so we can get current settings.  If we
// can't then that means this is a fresh installation OR they want to start
// with the our system defaults.

// Include template class if we got it
if ($page > 0) {
    include_once($geeklog_path . '/system/classes/template.class.php');
    include_once($geeklog_path . '/config.php');
    include_once($geeklog_path . '/system/lib-database.php');
}

$display = '';

switch ($page) {
case 1:
    if ($install_type == 'complete_upgrade') {
        $upgrade = 1;
    } else {
        $upgrade = 0;
    }
    $display .= INST_getDatabaseSettings($install_type, $geeklog_path); 
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
