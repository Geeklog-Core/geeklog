<?php

###############################################################################
# plugins.php
# This is the admin story moderation and editing file.
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

include("../common.php");
include("../custom_code.php");
include("auth.inc.php");

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

###############################################################################
# Displays the Plugin Editor

function plugineditor($pi_name) {
	global $HTTP_POST_VARS,$USER,$CONF;
	
	if (empty($pi_name)) {
		errorlog("no plugin name provided to plugineditor()");
		return;
	}
	$result = dbquery("SELECT * FROM plugins WHERE pi_name = '$pi_name'");
	$A = mysql_fetch_array($result);
	startblock("Plugin Editor");
	print "<form action={$CONF["base"]}/admin/plugins.php method=post>";
	print "<table border=0 cellspacing=0 cellpadding=3>";
	print "<tr><td colspan=2 align=left><input type=submit value=save name=mode> ";
	print "<input type=submit value=cancel name=mode> ";
	if (!empty($pi_name)) {
		print "<input type=submit value=delete name=mode> ";
	}
	print "<tr></td>";
	print "<tr><td align=right><b>Plug-in Name:</b></td><td>{$A["pi_name"]}";
	print "<input type=hidden name=pi_name value={$A["pi_name"]}></td></tr>";
	print "<tr><td align=right><b>Plug-in Homepage:</b></td><td><a href={$A["pi_homepage"]}>{$A["pi_homepage"]}</a>";
	print "<input type=hidden name=pi_homepage value={$A["pi_homepage"]}></td></tr>";
	print "<tr><td align=right><b>Plug-in Version:</b></td><td>{$A["pi_version"]}";
	print "<input type=hidden name=pi_version value={$A["pi_version"]}></td></tr>";
	print "<tr><td align=right><b>Geeklog Version:</b></td><td>{$A["pi_gl_version"]}";
	print "<input type=hidden name=pi_gl_version value={$A["pi_gl_version"]}></td></tr>";
	print "<tr><td align=right><b>Enabled:</b></td><td><input type=checkbox name=enabled";
	if ($A['pi_enabled'] == 1) {
		print " checked";
	}
	print "></table>";
	print "</form>";
	endblock();
}

###############################################################################
# Displays a list of plugins

function listplugins($page="1") {
	global $LANG32,$CONF;
	startblock($LANG32[5]);
	adminedit("plugins",$LANG32[11]);
	if (empty($page)) $page = 1;
	$limit = (50 * $page) - 50;
	$result = dbquery("SELECT pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage FROM plugins");
	$nrows = mysql_num_rows($result);
	if ($nrows > 0) {
		print "<table cellpadding=0 cellspacing=3 border=0 width=100%>\n";
		print "<tr><th align=left>#</th><th align=left>Plug-in Name</th><th>Plug-in Version</th><th>Geeklog Version</th><th>Enabled</th></tr>";
 		for ($i=1; $i<=$nrows; $i++) {
			$scount = (50 * $page) - 50 + $i;
			$A = mysql_fetch_array($result);
			print "<tr align=center><td align=left><a href={$CONF["base"]}/admin/plugins.php?mode=edit&pi_name={$A["pi_name"]}>$scount</a></td>";
			print "<td align=left><a href={$A["pi_homepage"]} target=_new>{$A["pi_name"]}</a></td>";
			print "<td>{$A["pi_version"]}</td><td>{$A["pi_gl_version"]}</td>";
			if ($A["pi_enabled"] == 1)
				print "<td>Yes</td>";
			else
				print "<td>No</td>";
		}
		print "<tr><td clospan=6>";
		if (dbcount("plugins") > 50) {
			$prevpage = $page - 1; 
			$nextpage = $page + 1; 
			if ($pagestart >= 50) {
				print "<a href={$CONF["base"]}/admin/plugins.php?mode=list&page=$prevpage>Prev</a> ";
			}
			if ($pagestart <= (dbcount("plugins") - 50)) {
				print "<a href={$CONF["base"]}/admin/plugins.php?mode=list&page=$nextpage>Next</a> ";
			}
		}
		print "</td></tr></table>\n";
	} else {
		#no plug-ins installed, gave a message that says as much
		print $LANG32[10];
	}
	endblock();	
}

###############################################################################
# Saves plugin 

function saveplugin($pi_name, $pi_version, $pi_gl_version, $enabled, $pi_homepage) {
	global $CONF;
	if (!empty($pi_name)) {
		if ($enabled == 'on') {
			$enabled = 1;
		} else {
			$enabled = 0;
		}
		dbsave("plugins","pi_name, pi_version, pi_gl_version, pi_enabled, pi_homepage","'$pi_name', '$pi_version', '$pi_gl_version', $enabled, '$pi_homepage'","admin/plugins.php?msg=28");
	} else {
		include("../layout/header.php");
		errorlog("error saving plugin, no pi_name provided",1);
		plugineditor($pi_name);
		include("../layout/footer.php");
	}
}

###############################################################################
# Shows plugin installation form 

function installpluginform() {
	global $LANG32, $CONF;
        startblock($LANG32[2]);
        print $LANG32[1];
        endblock();
        startblock($LANG32[3]);

        /* new stuff */
        require_once($CONF["path"] . "/include/upload.class.php");
        $upload = new Upload();
        $upload->printFormStart($CONF["base"] . "/admin/plugins.php");
        print "<table border=0 cellspacing=0 cellpadding=3>";
        print "<tr><td><b>{$LANG32[4]}:</b><td>";
        $upload->printFormField("plugin_file");
        print "</td></tr>";
        print "<tr><td colspan=2 align=center>";
        $upload->printFormSubmit();
        print "<input type=hidden name=mode value=install></td></tr>";
        print "</table></form>";

        endblock();
}

###############################################################################
# Uploads and installs the plugin

function installplugin() {
	global $CONF, $HTTP_POST_FILES, $LANG32, $LANG01, $VERSION;
	require_once($CONF["path"] . "/include/upload.class.php");

	$upload = new Upload();
       	$upload->setAllowedMimeTypes(array("application/x-tar", "application/x-gzip-compressed","application/x-zip-compressed"));
       	$upload->setUploadPath($CONF["path"] .  "/plugins");

       	if ($upload->doUpload()) {
		//Good, file got uploaded, now install everything
		$filename =  $HTTP_POST_FILES[$upload->uploadFieldName][name];
		$index = strpos(strtolower($filename), '.tar.gz');
		if ($index === false) {
			$index = strpos(strtolower($filename), '.tgz');
		}
		$tmp = substr_replace($filename,'',$index);
		$file_attrs = explode('_', $tmp);
		$plugin_name = $file_attrs[0];
		$plugin_version = $file_attrs[1];
		$plugin_geeklog_version = $file_attrs[2];
	
		#first verify that this plug-in is even compatible with this version of GL
		if ($plugin_geeklog_version > $VERSION) {
			#remove the tarball and show an error message
			include('../layout/header.php');
			# this plugin isn't compatible with this version of Geeklog
			startblock($LANG32[8]);	
			print $LANG32[9];
			endblock();
			if (!unlink($CONF['path'] . 'plugins/' . $filename)) {
				errorlog('unable to remove ' . $CONF['path'] . 'plugins/' . $filename);
			}
			include('../layout/footer.php');
			return;
		}

		#See if we need to upgrade
		$result = dbquery("select pi_version from plugins where pi_name = '" . $plugin_name . "'");
		$isupgrade = false;
		if (mysql_num_rows($result) > 0) {
			$A = mysql_fetch_array($result);
			if ($A["pi_version"] < $plugin_version) {
				# this is an upgrade
				$isgrade = true;
			} else if ($A["pi_version"] == $plugin_version) {
				# they are trying to install on that exists already, give an error 
				include('../layout/header.php');
				startblock($LANG32[6]);
				print $LANG32[7];
				endblock();
				if (!unlink($CONF['path'] . 'plugins/' . $filename)) {
					errorlog('unable to remove ' . $CONF['path'] . 'plugins/' . $filename);
				}
				include('../layout/footer.php');
				return;
			}
		} 

		# Extract the compressed plugin
		$command = $CONF['unzipcommand'] . $CONF['path'] . 'plugins/' . $filename;
		$command = $CONF['unzipcommand'] . $CONF['path'] . 'plugins/' . $filename;
		errorlog ('command = ' . $command,1);
		exec($command);

		#move the main web pages to the Geeklog web tree
		if (!rename($CONF['path'] . 'plugins/' . $plugin_name . '/public_html/', $CONF['html'] . $plugin_name . '/')) {
			#error doing the copy
			errorlog('Unable to copy ' . $CONF['path'] . 'plugins/' . $plugin_name . '/public_html/ to ' . $CONF['html'] . $plugin_name . '/');
			return;
		}

		#move the admin pages to the plugin directory in admin tree
		if (!rename($CONF['path'] . 'plugins/' . $plugin_name . '/admin/', $CONF['html'] . 'admin/plugins/' . $plugin_name . '/')) {
			#error doing the copy
			errorlog('Unable to copy ' . $CONF['path'] . 'plugins/' . $plugin_name . '/admin/ to ' . $CONF['html'] . 'admin/plugins/' . $plugin_name . '/');
			return;
		}

		#almost home free, load table structures and import the data

		if ($isupgrade) {
			#do upgrade stuff
			if (file_exists($CONF['path'] . 'plugins/' . $plugin_name . '/updates/update_' . $A["pi_version"] . '.sql')) {	
			#great, found and upgrade script for this plugin, run it  
			exec('mysql -u' . $CONF['dbuser'] . ' -p'. $CONF['dbpass'] . ' ' . $CONF['dbname'] . ' < ' . $CONF['base'] . 'plugins/updates/update_' . $plugin_version . '.sql');
			errorlog("just ran update sql",1);
			}

		} else { 
			#fresh install
			#load table structures, if any
			if (file_exists($CONF['path'] . 'plugins/' . $plugin_name . '/table.sql')) {
				#found table.sql, run it
				if (strlen($CONF['dbpass']) == 0) {
					$command = 'mysql -u' . $CONF['dbuser'] . ' ' . $CONF['dbname'] . ' < ' . $CONF['path'] . 'plugins/' . $plugin_name . '/table.sql';
				} else {
					$command = 'mysql -u' . $CONF['dbuser'] . ' -p'. $CONF['dbpass'] . ' ' . $CONF['dbname'] . ' < ' . $CONF['path'] . 'plugins/' . $plugin_name . '/table.sql';
				}
				errorlog('command = ' . $command,1);
				exec($command);
			errorlog("just ran table.sql",1);
			} else {
				errorlog("table.sql for $plugin_name plugin doesn't exist");
			}

			#load data
			if (file_exists($CONF['path'] . 'plugins/' . $plugin_name . '/data.sql')) {
				#found data.sql, import it
				if (strlen($CONF['dbpass']) == 0) {
					$command = 'mysql -u' . $CONF['dbuser'] . ' ' . $CONF['dbname'] . ' < ' . $CONF['path'] . 'plugins/' . $plugin_name . '/data.sql';
				} else {
					$command = 'mysql -u' . $CONF['dbuser'] . ' -p'. $CONF['dbpass'] . ' ' . $CONF['dbname'] . ' < ' . $CONF['path'] . 'plugins/' . $plugin_name . '/data.sql';
				}
				errorlog('command = ' . $command,1);
				exec($command);
			errorlog("just ran data.sql",1);
			
			#if we got here then we are done, refresh the plugin page
			} else {
				errorlog("data.sql for $plugin_name plugin doesn't exist",1);
			}
			refresh($CONF['base'] . '/admin/plugins.php');
		}

       	} else {
               	$errors = $upload->getUploadErrors();
               	print "<strong>::Errors occured::</strong><br />\n";
               	while(list($filename,$values) = each($errors)) {
                       	"File: " . print $filename . "<br />";
                       	$count = count($values);
                       	for($i=0; $i<$count; $i++) {
                               	print "==>" . $values[$i] . "<br />";
                       	}
               	}
       	}
}

###############################################################################
# MAIN

switch ($mode) {
	case "delete":
		removeplugin($pi_name);
		break;
	case "edit":
		include("../layout/header.php");
		if (empty($pi_name)) {
			installpluginform();
		} else {
			plugineditor($pi_name);
		}
		include("../layout/footer.php");
		break;
	case "save":
		saveplugin($pi_name, $pi_version, $pi_gl_version, $enabled, $pi_homepage);
		break;
  	case "install":
		installplugin($plugin_file);
		break;
	case "cancel":
	default:
		include("../layout/header.php");
		showmessage($msg);
		listplugins($page);
		include("../layout/footer.php");
		break;
}

?>
