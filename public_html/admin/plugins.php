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
// $Id: plugins.php,v 1.10 2001/10/29 17:35:50 tony_bibbs Exp $

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
	global $HTTP_POST_VARS,$_USER,$_CONF, $LANG32;
	
	if (empty($pi_name)) {
		return (COM_errorLog($LANG32[12]));
	}
	$result = DB_query("SELECT * FROM {$_TABLES['plugins']} WHERE pi_name = '$pi_name'");
	$A = DB_fetchArray($result);
	$retval .= COM_startBlock($LANG32[13]);
	$retval .= "<form action={$_CONF['site_url']}/admin/plugins.php method=post>";
	$retval .= '<table border="0" cellspacing="0" cellpadding=3>';
	$retval .= '<tr><td colspan="2" align="left"><input type="submit" value=save name=mode> ';
	$retval .= '<input type="submit" value=cancel name=mode> ';
	if (!empty($pi_name)) {
		$retval .= '<input type="submit" value=delete name=mode> ';
	}
	$retval .= "<tr></td>";
	$retval .= "<tr><td align=right><b>Plug-in Name:</b></td><td>{$A["pi_name"]}";
	$retval .= "<input type=hidden name=pi_name value={$A["pi_name"]}>";
	$retval .= "<input type=hidden name=confirmed value=$confirmed></td></tr>";
	$retval .= "<tr><td align=right><b>Plug-in Homepage:</b></td><td><a href={$A["pi_homepage"]}>{$A["pi_homepage"]}</a>";
	$retval .= "<input type=hidden name=pi_homepage value={$A["pi_homepage"]}></td></tr>";
	$retval .= "<tr><td align=right><b>Plug-in Version:</b></td><td>{$A["pi_version"]}";
	$retval .= "<input type=hidden name=pi_version value={$A["pi_version"]}></td></tr>";
	$retval .= "<tr><td align=right><b>Geeklog Version:</b></td><td>{$A["pi_gl_version"]}";
	$retval .= "<input type=hidden name=pi_gl_version value={$A["pi_gl_version"]}></td></tr>";
	$retval .= "<tr><td align=right><b>Enabled:</b></td><td><input type=checkbox name=enabled";
	if ($A['pi_enabled'] == 1) {
		$retval .= " checked";
	}
	$retval .= "></table>";
	$retval .= "</form>";
	$retval .= COM_endBlock();
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

	$retval .= COM_startBlock($LANG32[5]);

	COM_adminEdit("plugins",$LANG32[11]);

	if (empty($page)) $page = 1;
	$limit = (50 * $page) - 50;
	$result = DB_query("SELECT pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage FROM {$_TABLES['plugins']}");
	$nrows = DB_numRows($result);
	if ($nrows > 0) {
		$retval .= '<table cellpadding="0" cellspacing=3 border="0" width="100%">\n';
		$retval .= '<tr><th align="left">#</th><th align="left">Plug-in Name</th><th>Plug-in Version</th><th>Geeklog Version</th><th>Enabled</th></tr>';
 		for ($i = 1; $i <= $nrows; $i++) {
			$scount = (50 * $page) - 50 + $i;
			$A = DB_fetchArray($result);
			$retval .= "<tr align=center><td align=left><a href={$_CONF['site_url']}/admin/plugins.php?mode=edit&pi_name={$A["pi_name"]}>$scount</a></td>";
			$retval .= "<td align=left><a href={$A["pi_homepage"]} target=_blank>{$A["pi_name"]}</a></td>";
			$retval .= "<td>{$A["pi_version"]}</td><td>{$A["pi_gl_version"]}</td>";
			if ($A["pi_enabled"] == 1) {
				$retval .= "<td>Yes</td>";
			} else {
				$retval .= "<td>No</td>";
            }
		}
		$retval .= "<tr><td clospan=6>";
		if (dbcount("plugins") > 50) {
			$prevpage = $page - 1; 
			$nextpage = $page + 1; 
			if ($pagestart >= 50) {
				$retval .= "<a href={$_CONF['site_url']}/admin/plugins.php?mode=list&page=$prevpage>Prev</a> ";
			}
			if ($pagestart <= (dbcount("plugins") - 50)) {
				$retval .= "<a href={$_CONF['site_url']}/admin/plugins.php?mode=list&page=$nextpage>Next</a> ";
			}
		}
		$retval .= "</td></tr></table>\n";
	} else {
		// no plug-ins installed, gave a message that says as much
		$retval .= $LANG32[10];
	}
	$retval .= COM_endBlock();	
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

    $retval .= COM_startBlock($LANG32[2]);
    $retval .= $LANG32[1];
    $retval .= COM_endBlock();
    $retval .= COM_startBlock($LANG32[3]);

    /* new stuff */
    require_once($_CONF["path"] . "/include/upload.class.php");
    $upload = new Upload();
    $upload->printFormStart($_CONF['site_url'] . "/admin/plugins.php");
    $retval .= '<table border="0" cellspacing="0" cellpadding=3>';
    $retval .= "<tr><td><b>{$LANG32[4]}:</b><td>";
    $upload->printFormField("plugin_file");
    $retval .= '</td></tr>';
    $retval .= '<tr><td colspan="2" align="center">';
    $upload->printFormSubmit();
    $retval .= '<input type="hidden" name=mode value=install></td></tr>';
    $retval .= "</table></form>";
    $retval .= COM_endBlock();

    return $retval;
}

/**
* Actually installs a plugin
*
*/
function installplugin() {
	global $_TABLES, $_CONF, $HTTP_POST_FILES, $LANG32, $LANG01;

	require_once($_CONF["path"] . "/include/upload.class.php");

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

			return $retval;
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

				return $retval;
			}
		} 

		// Extract the compressed plugin
		$command = $_CONF['unzipcommand'] . $_CONF['path'] . 'plugins/' . $filename;
		COM_errorLog ('command = ' . $command,1);
		exec($command);

		// Move the main web pages to the Geeklog web tree
		if (!rename($_CONF['path'] . 'plugins/' . $plugin_name . '/public_html/', $_CONF['path_html'] . $plugin_name . '/')) {
			// error doing the copy
			$retval .= COM_errorLog('Unable to copy ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/public_html/ to ' . $_CONF['path_html'/g] . $plugin_name . '/');
			return $retval;
		}

		// Move the admin pages to the plugin directory in admin tree
		if (!rename($_CONF['path'] . 'plugins/' . $plugin_name . '/admin/', $_CONF['path_html'] . 'admin/plugins/' . $plugin_name . '/')) {
			// Error doing the copy
			$retval .= COM_errorLog('Unable to copy ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/admin/ to ' . $_CONF['path_html'] . 'admin/plugins/' . $plugin_name . '/');
			return $retval;
		}

		// Almost home free, load table structures and import the data
		if ($isupgrade) {
			// do upgrade stuff
			if (file_exists($_CONF['path'] . 'plugins/' . $plugin_name . '/updates/update_' . $A["pi_version"] . '.sql')) {	
			    // great, found and upgrade script for this plugin, run it  
			    exec('mysql -u' . $_CONF['db_user'] . ' -p'. $_CONF['db_pass'] . ' ' . $_CONF['db_name'] . ' < ' . $_CONF['path'] . 'plugins/updates/update_' . $plugin_version . '.sql');
			    COM_errorLog("just ran update sql",1);
			}
		} else { 
			// fresh install
			// load table structures, if any
			if (file_exists($_CONF['path'] . 'plugins/' . $plugin_name . '/table.sql')) {
				// found table.sql, run it
				if (strlen($_CONF['db_pass']) == 0) {
					$command = 'mysql -u' . $_CONF['db_user'] . ' ' . $_CONF['db_name'] . ' < ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/table.sql';
				} else {
					$command = 'mysql -u' . $_CONF['db_user'] . ' -p'. $_CONF['db_pass'] . ' ' . $_CONF['db_name'] . ' < ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/table.sql';
				}
				COM_errorLog('command = ' . $command,1);
				exec($command);
			    COM_errorLog("just ran table.sql",1);
			} else {
				$retval .= COM_errorLog("table.sql for $plugin_name plugin doesn't exist");
			}

			// Load data
			if (file_exists($_CONF['path'] . 'plugins/' . $plugin_name . '/data.sql')) {
				// found data.sql, import it
				if (strlen($_CONF['db_pass']) == 0) {
					$command = 'mysql -u' . $_CONF['db_user'] . ' ' . $_CONF['db_name'] . ' < ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/data.sql';
				} else {
					$command = 'mysql -u' . $_CONF['db_user'] . ' -p'. $_CONF['db_pass'] . ' ' . $_CONF['db_name'] . ' < ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/data.sql';
				}
				COM_errorLog('command = ' . $command,1);
				exec($command);
			    COM_errorLog("just ran data.sql",1);
			
			} else {
				COM_errorLog("data.sql for $plugin_name plugin doesn't exist",1);
			}
			// Now remove the tarball
			$command = $_CONF["rmcommand"] . $_CONF["path"] . "plugins/" . $filename;
			COM_errorLog('command = ' . $command,1);
			exec($command);

			// If we got here then we are done, refresh the plugin page
			COM_refresh($_CONF['sit_url'] . '/admin/plugins.php');
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

	// First undo any schema changes
	if (file_exists($_CONF['path'] . 'plugins/' . $plugin_name . '/undo.sql')) {
        	// found undo.sql, execute it
                if (strlen($_CONF['dbpass']) == 0) {
                	$command = 'mysql -u' . $_CONF['dbuser'] . ' ' . $_CONF['dbname'] . ' < ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/undo.sql';
                } else {
                        $command = 'mysql -u' . $_CONF['dbuser'] . ' -p'. $_CONF['dbpass'] . ' ' . $_CONF['dbname'] . ' < ' . $_CONF['path'] . 'plugins/' . $plugin_name . '/undo.sql';
                }
                COM_errorLog('command = ' . $command,1);
                exec($command);
                COM_errorLog("just ran undo.sql",1);
	} else {
		// undo.sql not found...log this (note, may not necessary mean an error
		COM_errorLog($_CONF['path'] . 'plugins/' . $plugin_name . '/undo.sql not found!',1);
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

	// sweet, uninstall complete
	return COM_refresh($_CONF['site_url'] . '/index.php?msg=29');			
}

###############################################################################
# MAIN
switch ($mode) {
	case "delete":
		if ($confirmed == 1) {
			removeplugin($pi_name);
		} else {
			$display .= COM_siteHeader("menu");
			$display .= COM_startBlock($LANG32[13]);
			$display .= $LANG32[12];
			$display .= COM_endBlock();
			$display .= plugineditor($pi_name,1);
			$display .= COM_siteFooter();
		}	
		break;
	case "edit":
		$display .= COM_siteHeader("menu");
		if (empty($pi_name)) {
			$display .= installpluginform();
		} else {
			$display .= plugineditor($pi_name);
		}
		$display .= COM_siteFooter();
		break;
	case "save":
		$display .= saveplugin($pi_name, $pi_version, $pi_gl_version, $enabled, $pi_homepage);
		break;
  	case "install":
		$display .= installplugin($plugin_file);
		break;
	case "cancel":
	default:
		$display .= COM_siteHeader("menu");
		$display .= COM_showMessage($msg);
		$display .= listplugins($page);
		$display .= COM_siteFooter();
		break;
}

echo $display;

?>
