<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | plugins.php                                                               |
// | Geeklog plugin administration page.                                       |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
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
//
// $Id: plugins.php,v 1.23 2002/05/03 12:15:17 dhaun Exp $

include('../lib-common.php');
include('auth.inc.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

$display = '';

if (!SEC_inGroup('Root')) {
    $display .= COM_siteHeader('menu');
    $display .= COM_startBlock($MESSAGE[30]);
    $display .= $MESSAGE[38];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    COM_errorLog("User {$_USER['username']} tried to illegally access the poll administration screen",1);
    echo $display;
    exit;
}

/**
* Shows the plugin editor form
*
* @pi_name          string          Plugin name
* @confirmed        int             Flag indicated the user has confirmed an action
*
*/ 
function plugineditor($pi_name, $confirmed = 0) 
{
	global $_TABLES, $HTTP_POST_VARS, $_USER, $_CONF, $LANG32;

	if (strlen($pi_name) == 0) {
		return (COM_errorLog($LANG32[12]));
        exit;
	}

	$result = DB_query("SELECT * FROM {$_TABLES['plugins']} WHERE pi_name = '$pi_name'");
    if (DB_numRows($result) <> 1) {
        // Serious problem, we got a pi_name that doesn't exists or returned more than one row
        return COM_errorLog('Error in editing plugin ' . $pi_name . '. Either the plugin does not exist '
            . 'or there is more than one row with with same pi_name.  Bailing out to prevent trouble.');
    }

	$A = DB_fetchArray($result);

    $retval = '';

    $plg_templates = new Template($_CONF['path_layout'] . 'admin/plugins');
    $plg_templates->set_file('editor', 'editor.thtml');
    $plg_templates->set_var('site_url', $_CONF['site_url']);
    $plg_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $plg_templates->set_var('layout_url', $_CONF['layout_url']);
    $plg_templates->set_var('start_block_editor', COM_startBlock($LANG32[13]));
    $plg_templates->set_var('lang_save', $LANG32[23]);
    $plg_templates->set_var('lang_cancel', $LANG32[24]);
    $plg_templates->set_var('lang_delete', $LANG32[25]);
    $plg_templates->set_var('pi_icon', $_CONF['site_url'] . "/" . $pi_name . "/images/" . $pi_name . ".gif");
	if (!empty($pi_name)) {
		$plg_templates->set_var('delete_option', '<input type="submit" value="' . $LANG32[25] . '" name="mode">');
	}
    $plg_templates->set_var('confirmed', $confirmed);
    $plg_templates->set_var('lang_pluginname', $LANG32[26]);
    $plg_templates->set_var('pi_name', $pi_name);
    $plg_templates->set_var('lang_pluginhomepage', $LANG32[27]);
    $plg_templates->set_var('pi_homepage', $A['pi_homepage']);
    $plg_templates->set_var('lang_pluginversion', $LANG32[28]);
    $plg_templates->set_var('pi_version', $A['pi_version']);
    $plg_templates->set_var('lang_geeklogversion', $LANG32[29]);
    $plg_templates->set_var('pi_gl_version', $A['pi_gl_version']);
    $plg_templates->set_var('lang_enabled', $LANG32[19]);
	if ($A['pi_enabled'] == 1) {
        $plg_templates->set_var('enabled_checked', 'checked="checked"');
	} else {
        $plg_templates->set_var('enabled_checked', '');
    }
    $plg_templates->set_var('end_block', COM_endBlock());

    $retval .= $plg_templates->parse('output', 'editor');

    return $retval;
}

/**
* Shows all installed Geeklog plugins
*
* @page         int         Page number to show
*
*/
function listplugins($page = 1) 
{
	global $_TABLES, $LANG32, $_CONF;

    $retval = '';

    $plg_templates = new Template($_CONF['path_layout'] . 'admin/plugins');
    $plg_templates->set_file(array('list'=>'pluginlist.thtml','row'=>'listitem.thtml'));
    $plg_templates->set_var('site_url', $_CONF['site_url']);
    $plg_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $plg_templates->set_var('layout_url', $_CONF['layout_url']);
    $plg_templates->set_var('start_block_pluginlist', COM_startBlock($LANG32[5]));
    $plg_templates->set_var('lang_newplugin', $LANG32[14]);
    $plg_templates->set_var('lang_adminhome', $LANG32[15]);
    $plg_templates->set_var('lang_instructions', $LANG32[11]);
    $plg_templates->set_var('lang_pluginname', $LANG32[16]);
    $plg_templates->set_var('lang_pluginversion', $LANG32[17]);
    $plg_templates->set_var('lang_geeklogversion', $LANG32[18]);
    $plg_templates->set_var('lang_enabled', $LANG32[19]);

	$result = DB_query("SELECT pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage FROM {$_TABLES['plugins']}");
	$nrows = DB_numRows($result);
	if ($nrows > 0) {
 		for ($i = 1; $i <= $nrows; $i++) {
			$A = DB_fetchArray($result);
            $plg_templates->set_var('pi_name', $A['pi_name']);
            $plg_templates->set_var('row_num', $i);
            $plg_templates->set_var('pi_url', $A['pi_homepage']);
            $plg_templates->set_var('pi_version', $A['pi_version']);
            $plg_templates->set_var('pi_gl_version', $A['pi_gl_version']);
			if ($A['pi_enabled'] == 1) {
                $plg_templates->set_var('pi_enabled', $LANG32[20]);
			} else {
                $plg_templates->set_var('pi_enabled', $LANG32[21]);
            }
            $plg_templates->parse('plugin_list', 'row', true);
		}
	} else {
		// no plug-ins installed, give a message that says as much
		$plg_templates->set_var('lang_nopluginsinstalled', $LANG32[10]);
	}
    $plg_templates->set_var('end_block', COM_endBlock());
    $plg_templates->parse('output', 'list');
    $retval .= $plg_templates->finish($plg_templates->get_var('output'));

    return $retval;
}

/**
* Saves a plugin
*
* @pi_name          string  Plugin name
* @pi_version       string  Plugin version number
* @pi_gl_version    string  Last Geeklog version plugin is compatible with
* @enabled          int     Flag that indicates if plugin in enabled or not
* @pi_homepage      string  URL to homepage for plugin
*
*/ 
function saveplugin($pi_name, $pi_version, $pi_gl_version, $enabled, $pi_homepage) 
{
	global $_TABLES, $_CONF;

	if (!empty($pi_name)) {
		if ($enabled == 'on') {
			$enabled = 1;
		} else {
			$enabled = 0;
		}
		DB_save($_TABLES['plugins'],'pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage',"'$pi_name', '$pi_version', '$pi_gl_version', $enabled, '$pi_homepage'",'admin/plugins.php?msg=28');
	} else {
        $retval = '';
		$retval .= COM_siteHeader('menu');
		COM_errorLog("error saving plugin, no pi_name provided",1);
		$retval .= plugineditor($pi_name);
		$retval .= COM_siteFooter();
        return $retval;
	}
}

###############################################################################
# MAIN
switch ($mode) {
	case $LANG32[25]: // Delete
		if ($confirmed == 1) {
			removeplugin($pi_name);
		} else {
			$display .= COM_siteHeader('menu');
			$display .= COM_startBlock($LANG32[30]);
			$display .= $LANG32[31];
			$display .= COM_endBlock();
			$display .= plugineditor($pi_name,1);
			$display .= COM_siteFooter();
		}	
		break;
    case 'edit':
        $display .= COM_siteHeader('menu');
        $display .= plugineditor($pi_name);
        $display .= COM_siteFooter();
        break;
	case $LANG32[23]: // Save
		$display .= saveplugin($pi_name, $pi_version, $pi_gl_version, $enabled, $pi_homepage);
		break;
	case $LANG32[24]:
	default:
		$display .= COM_siteHeader('menu');
		$display .= COM_showMessage($msg);
		$display .= listplugins($page);
		$display .= COM_siteFooter();
		break;
}

echo $display;

?>
