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
include("../lib-common.php");
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

	$retval .= startblock($LANG29[34])
		.'<table border="0" cellspacing="0" cellpadding="2" width="100%">'.LB
		.'<tr align="center" valign="top">'.LB;
		
	if (hasrights('story.edit')) {
		$retval .= '<td><a href="'.$CONF['site_url'].'/admin/story.php"><img src="'.$CONF['site_url'].'/images/icons/story.gif" border="0"><br>'.$LANG01[11].'</a></td>'.LB;
	}
	if (hasrights('block.edit')) {
		$retval .= '<td><a href="'.$CONF['site_url'].'/admin/block.php"><img src="'.$CONF['site_url'].'/images/icons/block.gif" border="0"><br>'.$LANG01[12].'</a></td>'.LB;
	}
	if (hasrights('topic.edit')) {
		$retval .= '<td><a href="'.$CONF['site_url'].'/admin/topic.php"><img src="'.$CONF['site_url'].'/images/icons/topic.gif" border="0"><br>'.$LANG01[13].'</a></td>'.LB;
	}
	if (hasrights('link.edit')) {
		$retval .= '.<td><a href="'.$CONF['site_url'].'/admin/link.php"><img src="'.$CONF['site_url'].'/images/icons/link.gif" border="0"><br>'.$LANG01[14].'</a></td>'.LB;
	}
	if (hasrights('event.edit')) {
		$retval .= '<td><a href="'.$CONF['site_url'].'/admin/event.php"><img src="'.$CONF['site_url'].'/images/icons/event.gif" border="0"><br>'.$LANG01[15].'</a></td>'.LB;
	}
	if (hasrights('poll.edit')) {
		$retval .= '.<td><a href="'.$CONF['site_url'].'/admin/poll.php"><img src="'.$CONF['site_url'].'/images/icons/poll.gif" border="0"><br>'.$LANG01[16].'</a></td>'.LB;
	}
	if (hasrights('user.edit')) {
		$retval .= '<td><a href="'.$CONF['site_url'].'/admin/user.php"><img src="'.$CONF['site_url'].'/images/icons/user.gif" border="0"><br>'.$LANG01[17].'</a></td>'.LB;
	}
	if (hasrights('group.edit')) {
		$retval .= '<td><a href="'.$CONF['site_url'].'/admin/group.php"><img src="'.$CONF['site_url'].'/images/icons/group.gif" border="0"><br>'.$LANG01[96].'</a></td>'.LB;
	}
	if (hasrights('plugin.edit')) {
		$retval .= '<td><a href="'.$CONF['site_url'].'/admin/plugins.php"><img src="'.$CONF['site_url'].'/images/icons/plugins.gif" border="0"><br>Plug-ins</a></td>'.LB;
	}

	$retval .= '<td><a href="'.$CONF['site_url'].'/admin/index.php?mode=logout"><img src="'.$CONF['site_url'].'/images/icons/logout.gif" border="0"><br>'.$LANG01[19].'</a></td>'.LB
		.'</tr>'.LB
#		.'<tr align="center" valign="top">'.LB
#		.ShowPluginModerationOptions()
#		.'</tr>'.LB
		.'</table>'.LB
		.endblock();
		
	if (hasrights('story.moderate')) {
		$retval .= itemlist('story');
	}
	if (hasrights('link.moderate')) {
		$retval .= itemlist('link');
	}
	if (hasrights('event.moderate')) {
		$retval .= itemlist('event');
	}

	$retval .= ShowPluginModerationLists();
	
	return $retval;
}

###############################################################################
# Displays the moderation list of items from the submission tables

function itemlist($type) {
	global $LANG29,$CONF;

	$isplugin = false;

	switch ($type) {
		case 'event':
			$retval .= startblock($LANG29[37],'cceventsubmission.html');
			$sql = "SELECT eid AS id,title,datestart,url FROM {$CONF['db_prefix']}eventsubmission ORDER BY datestart ASC";
			$H = array("Title","Start Date","URL");
			break;
		case 'link':
			$retval .= startblock($LANG29[36],'cclinksubmission.html');
			$sql = "SELECT lid AS id,title,category,url FROM {$CONF['db_prefix']}linksubmission ORDER BY title ASC";
			$H = array("Title","Category","URL");
			break;
		default:
			if ((strlen($type) > 0) && ($type <> 'story')) {
				$function = 'plugin_itemlist_' . $type;
				if (function_exists($function)) {
					// Great, we found the plugin, now call it's itemlist method

					list($sql, $H) = $function();
					$isplugin = true;
					break;
				} else {
					// Function not found, error out

					$retval .= errorlog("Could not find plugin function: " . $function);
					return $retval;
				}
			} else {
				$retval .= startblock($LANG29[35],'ccstorysubmission.html');
				$sql = "SELECT sid AS id,title,UNIX_TIMESTAMP(date) AS day,tid FROM {$CONF['db_prefix']}storysubmission ORDER BY date ASC";
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
		$retval .= '<form action="'.$CONF['site_url'].'/admin/moderation.php" method="POST">'
		.'<input type="hidden" name="type" value="'.$type.'>'
		.'<input type="hidden" name="count" value="'.$nrows.'">'
		.'<input type="hidden" name="mode" value="moderation">'
		.'<table cellpadding="0" cellspacing="3" border="0" width="100%">'.LB
		.'<tr>'.LB
		.'<td>&nbsp;</td>'.LB
		.'<td><b>'.$H[0].'</b></td>'.LB
		.'<td><b>'.$H[1].'</b></td>'.LB
		.'<td><b>'.$H[2].'</b></td>'.LB
		.'<td align="center"><b>'.$LANG29[2].'</b></td>'.LB
		.'<td align="center"><b>'.$LANG29[1].'</b></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB;
		
		for ($i=1; $i<=$nrows; $i++) {
			$A = mysql_fetch_array($result);
			if ($type == 'story') {
#				$A[3] = getitem("topics","topic","tid = {$A[3]}");
				$A[2] = strftime("%c",$A[2]);
			}
			if ($isplugin)  {
				$retval .= '<td><a href="'.$CONF['site_url'].'/admin/plugins/'.$type.'/'.$type.'.php?mode=editsubmission&id='.$A['id'].'">Edit</a></td>'.LB;
			} else {
				$retval .= '<td><a href="'.$CONF['site_url'].'/admin/'.$type.'.php?mode=editsubmission&id='.$A['id'].'>Edit</a></td>'.LB;
			}
			$retval .= '<td>'.$A[1].'</td>'.LB
				.'<td>'.$A[2].'</td>'.LB
				.'<td>'.$A[3].'</td>'.LB
				.'<td align="center"><input type="radio" name="action['.$i.']" value="delete"></td>'
				.'<td align="center"><input type="radio" name="action['.$i.']" value="approve">'
				.'<input type="hidden" name="id['.$i.']" value="'.$A[0].'"></td>'.LB
				.'</tr>'.LB;
		}
		$retval .= '<tr>'.LB
			.'<td colspan="8" align="center"><input type="hidden" name="count" value="'.$nrows.'"> '
			.'<input type="submit" value="'.$LANG29[38].'"></td>'
			.'</tr>'.LB
			.'</table></form>';
	} else {
		if ($nrows <> -1) {
			$retval .= $LANG29[39];
		}
	}
	
	$retval .= endblock();
	
	return $retval;
}

###############################################################################
# Acts on moderation directivs

function moderation($mid,$action,$type,$count) {

	switch ($type) {
		case 'event':
			$id = 'eid';
			$table = 'events';
			$fields = 'eid,title,description,location,datestart,dateend,url';
			break;
		case 'link':
			$id = 'lid';
			$table = 'links';
			$fields = 'lid,category,url,description,title';
			break;
		case 'story':
			$id = 'sid';
			$table = 'stories';
			$fields = 'sid,uid,tid,title,introtext,date';
			break;
		default:
			if (strlen($type) <= 0) {
				// something is terribly wrong, bail
				
				$retval .= errorlog("Unable to find type of $type in moderation() in moderation.php");
				return $retval;
			}
			list($id, $table, $fields) = GetPluginModerationValues($type);
			$display .= errorlog('id = '.$id.' table = '.$table.' fields = '.$fields);
	}
	for ($i=1; $i<=$count; $i++) {
		switch ($action[$i]) {
			case 'delete':
				if ((strlen($type) > 0) && ($type <> 'story')) {
					//There may be some plugin specific processing that needs to happen first.
					$retval .= DoPluginModerationDelete($type, $mid[$i]);
				}
				if (empty($mid[$i])) {
					$retval .= errorlog("moderation.php just tried deleting everyting in table {$type}submission because it got an empty id.  Please report this immediately to your site administrator");
					return $retval;
				}
				dbdelete("{$type}submission","$id",$mid[$i]);
				break;
			case "approve":
				if ((strlen($type) > 0) && ($type <> 'story')) {
					//There may be some plugin specific processing that needs to happen first.
					$retval .= DoPluginModerationApprove($type,$mid[$i]);
				}
				dbcopy("$table","$fields","$fields","{$type}submission","$id",$mid[$i]);
				break;
		}
	}

	$retval .= commandcontrol();
	
	return $retval;
}

###############################################################################
# MAIN

$display .= site_header();

switch ($mode) {
	case 'moderation':
		$display .= moderation($id,$action,$type,$count);
		break;
	default:
		$display .= commandcontrol();
		break;
}

$display .= site_footer();

echo $display;

?>