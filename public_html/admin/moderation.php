<?php

###############################################################################
# moderation.php
# This is the admins story moderation and editing file.
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
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
# Command and Control Panel

function commandcontrol() {
	global $CONF,$LANG01,$LANG29;
	startblock($LANG29[34]);
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr align=center valign=top>";
	print "<td width=11%><a href={$CONF["site_url"]}/admin/story.php><img src={$CONF["site_url"]}/images/admin/story.gif border=0><br>{$LANG01[11]}</a></td>";
	print "<td width=11%><a href={$CONF["site_url"]}/admin/block.php><img src={$CONF["site_url"]}/images/admin/block.gif border=0><br>{$LANG01[12]}</a></td>";
	print "<td width=11%><a href={$CONF["site_url"]}/admin/topic.php><img src={$CONF["site_url"]}/images/admin/topic.gif border=0><br>{$LANG01[13]}</a></td>";
	print "<td width=11%><a href={$CONF["site_url"]}/admin/link.php><img src={$CONF["site_url"]}/images/admin/link.gif border=0><br>{$LANG01[14]}</a></td>";
	print "<td width=11%><a href={$CONF["site_url"]}/admin/event.php><img src={$CONF["site_url"]}/images/admin/event.gif border=0><br>{$LANG01[15]}</a></td>";
	print "<td width=11%><a href={$CONF["site_url"]}/admin/poll.php><img src={$CONF["site_url"]}/images/admin/poll.gif border=0><br>{$LANG01[16]}</a></td>";
	print "<td width=11%><a href={$CONF["site_url"]}/admin/user.php><img src={$CONF["site_url"]}/images/admin/user.gif border=0><br>{$LANG01[17]}</a></td>";
	print "<td width=11%><a href={$CONF["site_url"]}/admin/plugins.php><img src={$CONF["site_url"]}/images/admin/plugins.gif border=0><br>Plug-ins</a></td>";
	print "<td width=11%><a href={$CONF["site_url"]}/admin/index.php?mode=logout><img src={$CONF["site_url"]}/images/admin/logout.gif border=0><br>{$LANG01[19]}</a></td></tr><tr align=center valign=top>";
	ShowPluginModerationOptions();
	print "</tr></table>";
	endblock();
	itemlist("story");
	itemlist("link");
	itemlist("event");
	ShowPluginModerationLists();
}

###############################################################################
# Displays the moderation list of items from the submission tables

function itemlist($type) {
	global $LANG29,$CONF;
	$isplugin = false;
	switch ($type) {
		case "event":
			startblock($LANG29[37],"cceventsubmission.html");
			$sql = "SELECT eid AS id,title,datestart,url FROM eventsubmission ORDER BY datestart ASC";
			$H =  array("Title","Start Date","URL");
			break;
		case "link":
			startblock($LANG29[36],"cclinksubmission.html");
			$sql = "SELECT lid AS id,title,category,url FROM linksubmission ORDER BY title ASC";
			$H =  array("Title","Category","URL");
			break;
		default:
			if ((strlen($type) > 0) && ($type <> 'story')) {
				$function = 'plugin_itemlist_' . $type;
				if (function_exists($function)) {
					// great, we found the plugin, now call it's itemlist method
					list($sql, $H) = $function();
					$isplugin = true;
					break;
				} else {
					// function not found, error out
					errorlog("Could not find plugin function: " . $function);
					return;
				}
			} else {
				startblock($LANG29[35],"ccstorysubmission.html");
				$sql = "SELECT sid AS id,title,UNIX_TIMESTAMP(date) AS day,tid FROM storysubmission ORDER BY date ASC";
				$H =  array("Title","Date","Topic");
				break;
			}
	}
	$result = dbquery($sql,1);
	if (mysql_errno()) {
                #was more than likely a plugin that doesn't need moderation
                $nrows = -1;
        } else {
                $nrows = mysql_num_rows($result);
        }
	if ($nrows > 0) {
		print "<form action={$CONF["site_url"]}/admin/moderation.php method=POST>\n";
		print "<input type=hidden name=type value=$type><input type=hidden name=count value=$nrows><input type=hidden name=mode value=moderation>\n";
		print "<table cellpadding=0 cellspacing=3 border=0 width=100%>\n";
		print "<tr align=left><th>&nbsp;</th><th><b>{$H[0]}</b></th><th><b>{$H[1]}</b></th><th><b>{$H[2]}</b></th><th align=center><b>{$LANG29[2]}</b></th><th align=center>";
		print "<b>{$LANG29[1]}</b>";
		print "</th></tr>\n";
		print "<tr style=\"background: black;\" align=left><td colspan=8><img src={$CONF["site_url"]}/images/speck.gif width=1 height=1</td></tr>\n";
		for ($i=1; $i<=$nrows; $i++) {
			$A = mysql_fetch_array($result);
			if ($type == "story") {
#				$A[3] = getitem("topics","topic","tid = {$A[3]}");
				$A[2] = strftime("%c",$A[2]);
			}
			if ($isplugin)  {
				print "<tr align=left><td><a href={$CONF["site_url"]}/admin/plugins/$type/$type.php?mode=editsubmission&id={$A["id"]}>Edit</a></td>";
			} else {
				print "<tr align=left><td><a href={$CONF["site_url"]}/admin/$type.php?mode=editsubmission&id={$A["id"]}>Edit</a></td>";
			}
			print "<td>{$A[1]}</td><td>{$A[2]}</td><td>{$A[3]}</td>";
			print "<td align=center><input type=radio name=action[$i] value=delete></td>";
			print "<td align=center>";
			print "<input type=radio name=action[$i] value=approve><input type=hidden name=id[$i] value={$A[0]}>";
			print "</td></tr>\n";
		}
		print "<tr><td colspan=8 align=center><input type=hidden name=count value=$nrows><input type=submit value={$LANG29[38]}></td></tr>";
		print "</table></form>";
	} else {
		if ($nrows <> -1) print $LANG29[39];
	}
	endblock();
}

###############################################################################
# Acts on moderation directivs

function moderation($mid,$action,$type,$count) {
	switch ($type) {
		case "event":
			$id = "eid";
			$table = "events";
			$fields = "eid,title,description,location,datestart,dateend,url";
			break;
		case "link":
			$id = "lid";
			$table = "links";
			$fields = "lid,category,url,description,title";
			break;
		case "story":
			$id = "sid";
			$table = "stories";
			$fields = "sid,uid,tid,title,introtext,date";
			break;
		default:
			if (strlen($type) <= 0) {
				// something is terribly wrong, bail
				errorlog("Unable to find type of $type in moderation() in moderation.php");
				return;
			}
			list($id, $table, $fields) = GetPluginModerationValues($type);
			errorlog('id = '.$id.' table = '.$table.' fields = '.$fields);
	}
	for ($i=1; $i<=$count; $i++) {
		switch ($action[$i]) {
			case "delete":
				if ((strlen($type) > 0) && ($type <> 'story')) {
					//There may be some plugin specific processing that needs to 
					//happen first.
					DoPluginModerationDelete($type, $mid[$i]);
				}
				if (empty($mid[$i])) {
					errorlog("moderation.php just tried deleting everyting in table {$type}submission because it got an empty id.  Please report this immediately to your site administrator");
					exit;
				}
				dbdelete("{$type}submission","$id",$mid[$i]);
				break;
			case "approve":
				if ((strlen($type) > 0) && ($type <> 'story')) {
					//There may be some plugin specific processing that needs to 
					//happen first.
					DoPluginModerationApprove($type,$mid[$i]);
				}
				dbcopy("$table","$fields","$fields","{$type}submission","$id",$mid[$i]);
				break;
		}
	}
	commandcontrol();
}

###############################################################################
# MAIN

include("../layout/header.php");
switch ($mode) {
	case "moderation":
		moderation($id,$action,$type,$count);
		break;
	default:
		commandcontrol();
		break;
}
include("../layout/footer.php");


?>
