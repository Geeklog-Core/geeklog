<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.3 for Geeklog - The Ultimate Weblog                 |
// +---------------------------------------------------------------------------+
// | install.php                                                               |
// |                                                                           |
// | This file installs and removes the data structures for the Static Pages   |
// | plugin for Geeklog.                                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002,2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Tom Willett      - twillett@users.sourceforge.net
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
//
// $Id: install.php,v 1.11 2003/05/30 12:24:32 dhaun Exp $

require_once('../../../lib-common.php');
$langfile = $_CONF['path'] . 'plugins/staticpages/language/' . $_CONF['language'] . '.php';
if (file_exists ($langfile)) {
    require_once ($langfile);
} else {
    require_once ($_CONF['path'] . 'plugins/staticpages/language/english.php');
}
require_once($_CONF['path'] . 'plugins/staticpages/config.php');
require_once($_CONF['path'] . 'plugins/staticpages/functions.inc');

// Only let Root users access this page
if (!SEC_inGroup('Root')) {
    // Someone is trying to illegally access this page
    COM_errorLog("Someone has tried to illegally access the Static Pages install/uninstall page.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: $REMOTE_ADDR",1);
    $display = COM_siteHeader();
    $display .= COM_startBlock($LANG_STATIC['access_denied']);
    $display .= $LANG_STATIC['access_denied_msg'];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    echo $display;
    exit;
}
 
/**
* Puts the datastructures for this plugin into the Geeklog database
*
*/
function plugin_install_staticpages()
{
    global $_TABLES, $_CONF, $_SP_CONF;

    COM_errorLog('Attempting to install the Static Page Plugin',1);

    // Installs the static pages plugin

    $createsql = "CREATE TABLE {$_TABLES['staticpage']} (sp_id varchar(20) DEFAULT '' NOT NULL,"
        . "sp_uid mediumint(8) DEFAULT '1' NOT NULL,"
        . "sp_title varchar(128) DEFAULT '' NOT NULL,"
        . "sp_content text DEFAULT '' NOT NULL,"
        . "sp_hits mediumint(8) unsigned DEFAULT '0' NOT NULL,"
        . "sp_date datetime NOT NULL,"
        . "sp_format varchar(20) NOT NULL,"
        . "sp_onmenu tinyint(1) unsigned NOT NULL DEFAULT '0',"
        . "sp_label varchar(64),"
        . "group_id mediumint(8) unsigned NOT NULL default '1',"
        . "owner_id mediumint(8) unsigned NOT NULL default '1',"
        . "perm_owner tinyint(1) unsigned NOT NULL default '3',"
        . "perm_group tinyint(1) unsigned NOT NULL default '2',"
        . "perm_members tinyint(1) unsigned NOT NULL default '2',"
        . "perm_anon tinyint(1) unsigned NOT NULL default '2',"
        . "sp_centerblock tinyint(1) unsigned NOT NULL default '0',"
        . "sp_tid varchar(20) NOT NULL default 'none',"
        . "sp_where tinyint(1) unsigned NOT NULL default '1',"
        . "sp_php tinyint(1) unsigned NOT NULL default '0',"
        . "sp_nf tinyint(1) unsigned default '0',"
        . "PRIMARY KEY (sp_id),"
        . "KEY staticpage_sp_uid (sp_uid),"
        . "KEY staticpage_sp_date (sp_date),"
        . "KEY staticpage_sp_onmenu (sp_onmenu),"
        . "KEY staticpage_sp_centerblock (sp_centerblock),"
        . "KEY staticpage_sp_tid (sp_tid),"
        . "KEY staticpage_sp_where (sp_where)"
        . ") TYPE=MyISAM";

    COM_errorLog("Attempting to create table staticpage for Static Page plugin", 1);
    DB_query($createsql,1);

    if (DB_error()) {
        return false;
    }

    COM_errorLog('...success',1);
    $steps['createtable'] = 1;

    // Create the static page admin security group
    COM_errorLog("Attempting to create Static Page admin group", 1);
    DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) "
        . "VALUES ('Static Page Admin', 'Users in this group can administer the Static Pages plugin')",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
    }
    COM_errorLog('...success',1);
    $steps['insertgroup'] = 1;

    $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin'");

    // Add static page features
    COM_errorLog('Attempting to add staticpages.edit feature',1);
    DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
        . "VALUES ('staticpages.edit','Access to Static Pages editor')",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
    }
    $edit_id = DB_insertId();
    COM_errorLog('...success',1);
    $steps['insertedfeatureedit'] = 1;

    COM_errorLog('Attempting to add staticpages.delete feature',1);
    DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
        . "VALUES ('staticpages.delete','Ability to delete static pages')",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
    }
    $delete_id = DB_insertId();
    COM_errorLog('...success',1);
    $steps['insertedfeaturedelete'] = 1;

    COM_errorLog('Attempting to add staticpages.PHP feature',1);
    DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
        . "VALUES ('staticpages.PHP','Ability use PHP in static pages')",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
    }
    $php_id = DB_insertId();
    COM_errorLog('...success',1);
    $steps['insertedphpfeature'] = 1;
    
    // Now add the features to the group
    COM_errorLog('Attempting to give Static Page Admin group access to staticpages.edit feature',1);
    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($edit_id, $group_id)");
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
    }
    COM_errorLog('...success',1);
    $steps['addededittogroup'] = 1;

    COM_errorLog('Attempting to give Static Page Admin group access to staticpages.delete feature',1);
    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($delete_id, $group_id)",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
    }
    COM_errorLog('...success',1);
    $steps['addeddeletetogroup'] = 1;

    COM_errorLog('Attempting to give Static Page Admin group access to staticpages.PHP feature',1);
    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($php_id, $group_id)",1);
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
    }
    COM_errorLog('...success',1);
    $steps['addedphptogroup']=1;
    
    // OK, now give Root users access to this plugin now! NOTE: Root group should always be 1
    COM_errorLog('Attempting to give all users in Root group access static page admin group',1);
    DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES ($group_id, NULL, 1)");
    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
    }
    COM_errorLog('...success',1);
    $steps['addedrootuserstogroup'] = 1;

    // Register the plugin with Geeklog
    if (DB_count($_TABLES['plugins'],'pi_name','staticpages') > 0) {
        COM_errorLog('Attempting to remove staticpage entry prior to adding an updated entry',1);
        DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'staticpages'");
        if (DB_error()) {
            plugin_uninstall_staticpages($steps);
            return false;
        }
        COM_errorLog('...success',1);
    } else {
        // Only install data on a fresh installation
        // This plugin has no install data
    }

    COM_errorLog('Registering Static Page plugin with Geeklog', 1);
    DB_delete($_TABLES['plugins'],'pi_name','staticpages');
    DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
        . "VALUES ('staticpages', '{$_SP_CONF['version']}', '1.3.8', 'http://www.tonybibbs.com', 1)");

    if (DB_error()) {
        plugin_uninstall_staticpages($steps);
        return false;
    }
    COM_errorLog('...success',1);
    COM_errorLog('Succesfully installed the Static Page Plugin!',1);

    return true;
}

$display = COM_siteHeader();

if ($action == 'uninstall') {
    if (plugin_uninstall_staticpages ()) {
        $display .= COM_showMessage (45);
    } else {
        $timestamp = strftime($_CONF['daytime']);
        $display .= COM_startBlock ($MESSAGE[40] . ' - ' . $timestamp)
                 . '<p><img src="' . $_CONF['layout_url']
                 . '/images/sysmessage.gif" border="0" align="top" alt="">'
                 . $LANG08[6] . '</p>' . COM_endBlock ();
    }
} else if (DB_count ($_TABLES['plugins'], 'pi_name', 'staticpages') == 0) {
    // plugin not installed - do it now
    if (plugin_install_staticpages ()) {
        $display = COM_refresh ($_CONF['site_admin_url']
                                . '/plugins.php?msg=44');
    } else {
        $timestamp = strftime($_CONF['daytime']);
        $display .= COM_startBlock ($MESSAGE[40] . ' - ' . $timestamp)
                 . '<p><img src="' . $_CONF['layout_url']
                 . '/images/sysmessage.gif" border="0" align="top" alt="">'
                 . $LANG08[6] . '</p>' . COM_endBlock ();
    }
} else {
    // plugin already installed
    $display .= COM_startBlock ($LANG32[6])
             . '<p>' . $LANG32[7] . '</p>'
             . COM_endBlock ();
}

$display .= COM_siteFooter();

echo $display;

?>
