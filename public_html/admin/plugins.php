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
// $Id: plugins.php,v 1.14 2001/12/06 21:52:03 tony_bibbs Exp $

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
    $plg_templates->set_var('start_block_editor', COM_startBlock($LANG32[13]));
    $plg_templates->set_var('lang_save', $LANG32[23]);
    $plg_templates->set_var('lang_cancel', $LANG32[24]);
    $plg_templates->set_var('lang_delete', $LANG32[25]);
    $plg_templates->set_var('pi_name', $pi_name);
    $plg_templates->set_var('pi_homepage', $A['pi_homepage']);
    $plg_templates->set_var('pi_version', $A['pi_version']);
    $plg_templates->set_var('pi_gl_version', $A['pi_gl_version']);
	if (!empty($pi_name)) {
		$plg_templates->set_var('delete_option', '<input type="submit" value="' . $LANG32[25] . '" name="mode">');
	}
    $plg_templates->set_var('confirmed', $confirmed);
    $plg_templates->set_var('lang_pluginname', $LANG32[26]);
    $plg_templates->set_var('lang_pluginhomepage', $LANG32[27]);
    $plg_templates->set_var('pi_homepage', $A['pi_homepage']);
    $plg_templates->set_var('lang_pluginversion', $LANG32[28]);
    $plg_templates->set_var('pi_version', $A['pi_version']);
    $plg_templates->set_var('lang_geeklogversion', $LANG32[29]);
    $plg_templates->set_var('pi_gl_version', $A['pi_gl_version']);
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

/**
* Shows the plugin installation form
*
*/
function installpluginform() 
{
	global $LANG32, $_CONF;

    $retval = '';

    $plg_templates = new Template($_CONF['path_layout'] . 'admin/plugins');
    $plg_templates->set_file('form', 'installform.thtml');
    $plg_templates->set_var('site_url', $_CONF['site_url']);
    $plg_templates->set_var('start_block_disclaimer', COM_startBlock($LANG32[2]));
    $plg_templates->set_var('lang_disclaimertext', $LANG32[1]);
    $plg_templates->set_var('start_block_form', COM_startBlock($LANG32[3]));
    $plg_templates->set_var('lang_pluginfile', $LANG32[4]);
    $plg_templates->set_var('lang_install',$LANG32[22]); 
    $plg_templates->set_var('end_block', COM_endBlock());
    $plg_templates->parse('output', 'form');

    $retval .= $plg_templates->finish($plg_templates->get_var('output'));

    return $retval;
}

/**
* Actually installs a plugin
*
*/
function installplugin() {
	global $_TABLES, $_CONF, $HTTP_POST_FILES, $LANG32, $LANG01;

	require_once($_CONF['path_system'] . "classes/upload.class.php");

	$upload = new Upload();
  	$upload->setAllowedMimeTypes(array("application/x-tar", "application/x-gzip-compressed","application/x-zip-compressed"));
   	$upload->setUploadPath($_CONF["path"] .  "/plugins");
   	if ($upload->doUpload()) {
		//Good, file got uploaded, now install everything
		$filename =  $HTTP_POST_FILES[$upload->uploadFieldName][name];
		$index = strpos(strtolower($filename), '.tar.gz');
		if ($index === false) {
			$index = strpos(strtolower($filename), '.tgz');
			if ($index === false) {
				$index = strpos(strtolower($filename),'.zip');
			}
		}
		$tmp = substr_replace($filename,'',$index);
		$file_attrs = explode('_', $tmp);
		$plugin_name = $file_attrs[0];
		$plugin_version = $file_attrs[1];
		$plugin_geeklog_version = $file_attrs[2];
	
		// first verify that this plug-in is even compatible with this version of GL
		if ($plugin_geeklog_version > VERSION) {
			// remove the tarball and show an error message
			$retval .= COM_siteHeader('menu');
			// this plugin isn't compatible with this version of Geeklog
			$retval .= COM_startBlock($LANG32[8]);	
			$retval .= $LANG32[9];
			$retval .= COM_endBlock();
			if (!unlink($_CONF['path'] . 'plugins/' . $filename)) {
				$retval .= COM_errorLog('unable to remove ' . $_CONF['path'] . 'plugins/' . $filename);
			}
            $retval .= COM_siteFooter();

			echo $retval;
            exit;
		}

		// See if we need to upgrade
		$result = DB_query("select pi_version from {$_TABLES['plugins']} WHERE pi_name = '$plugin_name'");
		$isupgrade = false;
		if (DB_numRows($result) > 0) {
			$A = DB_fetchArray($result);
			if ($A['pi_version'] < $plugin_version) {
				// this is an upgrade
				$isgrade = true;
			} else if ($A["pi_version"] == $plugin_version) {
				// they are trying to install on that exists already, give an error 
                $retval .= COM_siteHeader('menu');
				$retval .= COM_startBlock($LANG32[6]);
				$retval .= $LANG32[7];
				$retval .= COM_endBlock();
				if (!unlink($_CONF['path'] . 'plugins/' . $filename)) {
					$retval .= COM_errorLog('unable to remove ' . $_CONF['path'] . 'plugins/' . $filename);
				}
                $retval .= COM_siteFooter();

				echo $retval;
                exit;
			}
		} 

		// Extract the compressed plugin
		$command = $_CONF['unzipcommand'] . $_CONF['path'] . 'plugins/' . $filename;
		COM_errorLog ('command = ' . $command,1);
		exec($command);

		// Move the main web pages to the Geeklog web tree
		if (!rename($_CONF['path'] . 'plugins/' . $plugin_name . '/public_html', $_CONF['path_html'] . $plugin_name)) {
			// error doing the copy
			$retval .= COM_errorLog('Unable to copy ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/public_html/ to ' . $_CONF['path_html'/g] . $plugin_name . '/');
			echo $retval;
            exit;
		}

		// Move the admin pages to the plugin directory in admin tree
		if (!rename($_CONF['path'] . 'plugins/' . $plugin_name . '/admin', $_CONF['path_html'] . 'admin/plugins/' . $plugin_name)) {
			// Error doing the copy
			$retval .= COM_errorLog('Unable to copy ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/admin/ to ' . $_CONF['path_html'] . 'admin/plugins/' . $plugin_name . '/');
			echo $retval;
            exit;
		}

		// Almost home free, load table structures and import the data
       
        // first include needed function file
        include_once($_CONF['path'] . 'plugins/' . $plugin_name . '/functions.inc');

		if ($isupgrade) {
			// do upgrade stuff
            PLG_upgrade($plugin_name);
		} else { 
            if (!PLG_install($plugin_name)) {
                // Problem occurred when the plugin tried to install data structures and data
                echo COM_errorLog('Error creating data structures and inserting data for plugin' . $plugin_name,2);
                exit;
            } 

			// Now remove the tarball
			$command = $_CONF['rmcommand'] . $_CONF['path'] . 'plugins/' . $filename;
			COM_errorLog('command = ' . $command,1);
			exec($command);

			// If we got here then we are done, refresh the plugin page
			echo COM_refresh($_CONF['sit_url'] . '/admin/plugins.php');
		}
    } else {
        $errors = $upload->getUploadErrors();
        $retval .= "<strong>::Errors occured::</strong><br />\n";
        while (list($filename,$values) = each($errors)) {
            "File: " . $retval .= $filename . "<br />";
            $count = count($values);
            for($i=0; $i<$count; $i++) {
                $retval .= "==>" . $values[$i] . "<br />";
            }
        }
    }
    return $retval;
}

/** 
* This uninstalls a plugin
*
*/
function removeplugin($plugin_name) 
{
	global $_CONF, $_TABLES;

    COM_errorLog("*** inside removeplugins ***",1);

    $retval = '';

	$result = DB_query("SELECT * FROM {$_TABLES['plugins']} WHERE pi_name = '$plugin_name'");

	if (DB_numRows($result) == 1) {
		// good, found the row
		$A = DB_fetchArray($result);
	} else {
		// couldn't find plugin...bail
        $retval .= COM_siteHeader('menu'); 
		$retval .= COM_startBlock("Can't find plugin: $plugin_name");
		$retval .= "couldn't find plugin $plugin_name in table plugins...exiting";
		$retval .= COM_endBlock();
        $retval .= COM_siteFooter();
		COM_errorLog("couldn't find plugin $plugin_name in table plugins...exiting", 1);
        return $retval;
	}

    // Now let the plug-in uninstall and database structures, and data if needed
    COM_errorLog('About to call PLG_uninstall function for ' . $plugin_name,1);
    if (!PLG_uninstall($plugin_name)) { 
        // uninstall of db-structures failed...log it and bail 
        COM_errorLog('Unable to uninstall data and data structures for plugin ' . $plugin_name, 2);
        exit;
    } else {
        COM_errorLog('successfully uninstalled data and data structures for plugin ' . $plugin_name, 1);
    }

	// Now remove any file associated with the plugin	
	// remove the /path/to/geeklog/plugins/<plugin_name> directory
	$command = $_CONF['rmcommand'] . $_CONF['path'] . 'plugins/' . $plugin_name;
	COM_errorLog('executing the following: ' . $command,1);
	exec($command);

	// remove the path/to/geeklog/public_html/<plugin_name> directory
	$command = $_CONF['rmcommand'] . $_CONF['path_html'] . $plugin_name;
	COM_errorLog('executing the following: ' . $command,1);
	exec($command);

	// remove the /path/to/geeklog/public_html/admin/plugins/<plugin_name> directory
	$command = $_CONF['rmcommand'] . $_CONF['path_html'] . 'admin/plugins/' . $plugin_name;
	COM_errorLog('executing the following: ' . $command,1);
	exec($command);

    COM_errorLog('*** Leaving removeplugin ***');

	// sweet, uninstall complete
	echo COM_refresh($_CONF['site_url'] . '/index.php?msg=45');			
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
		if (empty($pi_name)) {
			$display .= installpluginform();
		} else {
			$display .= plugineditor($pi_name);
		}
		$display .= COM_siteFooter();
		break;
	case $LANG32[23]: // Save
		$display .= saveplugin($pi_name, $pi_version, $pi_gl_version, $enabled, $pi_homepage);
		break;
  	case 'install':
		$display .= installplugin($plugin_file);
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
