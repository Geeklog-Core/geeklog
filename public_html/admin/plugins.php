<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | plugins.php                                                               |
// |                                                                           |
// | Geeklog plugin administration page.                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: plugins.php,v 1.34 2003/07/05 16:37:58 dhaun Exp $

require_once('../lib-common.php');
require_once('auth.inc.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($HTTP_POST_VARS);

$display = '';

if (!SEC_inGroup('Root')) {
    $display .= COM_siteHeader ('menu');
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[38];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
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

	$result = DB_query("SELECT pi_homepage,pi_version,pi_gl_version,pi_enabled FROM {$_TABLES['plugins']} WHERE pi_name = '$pi_name'");
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
    $plg_templates->set_var('start_block_editor', COM_startBlock ($LANG32[13],
            '', COM_getBlockTemplate ('_admin_block', 'header')));
    $plg_templates->set_var('lang_save', $LANG32[23]);
    $plg_templates->set_var('lang_cancel', $LANG32[24]);
    $plg_templates->set_var('lang_delete', $LANG32[25]);
    $public_img = $_CONF['site_url'] . '/' . $pi_name . '/images/' . $pi_name . '.gif';
    $fh = @fopen ($public_img, 'r');
    if ($fh === false) {
        $admin_img = $_CONF['site_admin_url'] . '/plugins/' . $pi_name
                   . '/images/' . $pi_name . '.gif';
        $plg_templates->set_var ('pi_icon', $admin_img);
    } else {
        fclose ($fh);
        $plg_templates->set_var ('pi_icon', $public_img);
    }
    if (!empty($pi_name)) {
        $plg_templates->set_var ('delete_option', '<input type="submit" value="'
                                 . $LANG32[25] . '" name="mode">');
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
    $plg_templates->set_var('end_block',
            COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));

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
    $plg_templates->set_var('start_block_pluginlist', COM_startBlock($LANG32[5],
            '', COM_getBlockTemplate ('_admin_block', 'header')));
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
    $plg_templates->set_var('end_block',
            COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));
    $plg_templates->parse('output', 'list');
    $retval .= $plg_templates->finish($plg_templates->get_var('output'));
	$retval .= show_newplugins();

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
		DB_save($_TABLES['plugins'],'pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage',"'$pi_name', '$pi_version', '$pi_gl_version', $enabled, '$pi_homepage'",$_CONF['site_admin_url'] . '/plugins.php?msg=28');
	} else {
        $retval = '';
		$retval .= COM_siteHeader('menu');
		COM_errorLog("error saving plugin, no pi_name provided",1);
		$retval .= plugineditor($pi_name);
		$retval .= COM_siteFooter();
        return $retval;
	}
}

/**
* Creates list of uninstalled plugins (if any) and offers install link to them.
*
* @return   string   HTML containing list of uninstalled plugins
*
*/
function show_newplugins()
{
    global $_CONF, $_TABLES, $LANG32;

    $plugins = array ();
    $plugins_dir = $_CONF['path'] . 'plugins/';
    $fd = opendir ($plugins_dir);
    $index = 1;
    $retval = '';
    $newplugins = array ();
    while (($dir = @readdir ($fd)) == TRUE) {
        if (is_dir ($plugins_dir . $dir) && ($dir <> '.') && ($dir <> '..') &&
                ($dir <> 'CVS') && (substr ($dir, 0 , 1) <> '.')) {
            clearstatcache ();
            // Check and see if this plugin is installed - if there is a record.
            // If not then it's a new plugin
            if (DB_count($_TABLES['plugins'],'pi_name',$dir) == 0) {
                // additionally, check if a 'functions.inc' exists
                if (file_exists ($plugins_dir . $dir . '/functions.inc')) {
                    // and finally, since we're going to link to it, check if
                    // an install script exists
                    $adminurl = $_CONF['site_admin_url'];
                    if (strrpos ($adminurl, '/') == strlen ($adminurl)) {
                        $adminurl = substr ($adminurl, 0, -1);
                    }
                    $pos = strrpos ($adminurl, '/');
                    if ($pos === false) {
                        // didn't work out - use the URL
                        $admindir = $_CONF['site_admin_url'];
                    } else {
                        $admindir = $_CONF['path_html']
                                  . substr ($adminurl, $pos + 1);
                    }
                    $fh = @fopen ($admindir . '/plugins/' . $dir
                        . '/install.php', 'r');
                    if ($fh) {
                        fclose ($fh);
                        $newplugins[] = $dir;
                    }
                }
            }
        }
    }

    if (sizeof ($newplugins) > 0) {
        $templdir = $_CONF['path_layout'] . 'admin/plugins';
        if (file_exists ($templdir . '/newpluginlist.thtml') &&
                file_exists ($templdir . '/newlistitem.thtml')) {
            $newtemplate = new Template ($templdir);
            $newtemplate->set_file (array ('list'=>'newpluginlist.thtml',
                                           'row'=>'newlistitem.thtml'));
            $newtemplate->set_var ('site_url', $_CONF['site_url']);
            $newtemplate->set_var ('site_admin_url', $_CONF['site_admin_url']);
            $newtemplate->set_var ('layout_url', $_CONF['layout_url']);
            $newtemplate->set_var ('lang_pluginname', $LANG32[16]);
            $newtemplate->set_var ('start_block_newlist',
                    COM_startBlock ($LANG32[14], '',
                            COM_getBlockTemplate ('_admin_block', 'header')));
            for ($i = 0; $i < sizeof ($newplugins); $i++) {
                $newtemplate->set_var ('lang_install', $LANG32[22]);
                $newtemplate->set_var ('pi_name', $newplugins[$i]);
                $newtemplate->set_var ('row_num', $i + 1);
                $newtemplate->set_var ('start_install_anchortag', '<a href="'
                    . $_CONF['site_admin_url'] . '/plugins/' . $newplugins[$i]
                    . '/install.php?action=install">');
                $newtemplate->set_var ('end_install_anchortag', '</a>');
                $newtemplate->parse ('plugin_list', 'row', true);
            }
            $newtemplate->set_var ('end_block',
                COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer')));
            $newtemplate->parse ('output', 'list');
            $retval .= $newtemplate->finish ($newtemplate->get_var ('output'));
        } else {
            $retval =  COM_startBlock ($LANG32[14], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
            $retval .= '<table border="0">' . LB;
            $retval .= '<tr><th align="left">' . $LANG32[16] .'</th></tr>' . LB;
            for ($i = 0; $i < sizeof ($newplugins); $i++) {
                $retval .= '<tr><td>' . $newplugins[$i] . '</td><td><a href="'
                    . $_CONF['site_admin_url'] . '/plugins/' . $newplugins[$i]
                    . '/install.php?action=install">' . $LANG32[22]
                    . '</a></td></tr>' . LB;
            }
            $retval .= '</table>' . LB;
            $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block',
                                                           'footer'));
        }
    }

    return $retval;
}

/**
* Uninstall a plugin (call its uninstall function).
*
* @param    pi_name   string   name of the plugin to uninstall
* @return             string   HTML for error or success message
*
*/
function do_uninstall ($pi_name)
{
    global $_CONF, $MESSAGE;

    $retval = '';

    // if the plugin is disabled, load the functions.inc now
    if (!function_exists ('plugin_uninstall_' . $pi_name)) {
        require_once ($_CONF['path'] . 'plugins/' . $pi_name . '/functions.inc');
    }

    if (PLG_uninstall ($pi_name)) {
        $retval .= COM_showMessage (45);
    } else {
        $timestamp = strftime ($_CONF['daytime']);
        $retval .= COM_startBlock ($MESSAGE[40] . ' - ' . $timestamp, '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
                . '<img src="' . $_CONF['layout_url']
                . '/images/sysmessage.gif" border="0" align="top" alt="">'
                . $LANG08[6] . '<br><br>'
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    return $retval;
}

###############################################################################
# MAIN
if (($mode == $LANG32[25]) && !empty ($LANG32[25])) { // delete
    if ($confirmed == 1) {
        $display .= COM_siteHeader('menu');
        $display .= do_uninstall ($pi_name);
        $display .= listplugins($page);
        $display .= COM_siteFooter();
    } else { // ask user for confirmation
        $display .= COM_siteHeader ('menu');
        $display .= COM_startBlock ($LANG32[30], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $LANG32[31];
        $display .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= plugineditor ($pi_name, 1);
        $display .= COM_siteFooter ();
    }	
} else if ($mode == 'edit') {
    $display .= COM_siteHeader('menu');
    $display .= plugineditor($pi_name);
    $display .= COM_siteFooter();
} else if (($mode == $LANG32[23]) && !empty ($LANG32[23])) { // save
    $display .= saveplugin($pi_name, $pi_version, $pi_gl_version, $enabled, $pi_homepage);
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader('menu');
    $display .= COM_showMessage($msg);
    $display .= listplugins($page);
    $display .= COM_siteFooter();
}

echo $display;

?>
