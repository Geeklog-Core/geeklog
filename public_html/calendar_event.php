<?php
###############################################################################
# calendar_event.php
# This is the calendar event resource script!
#
# Copyright (C) 2001 Jason Whittenburg
# jwhitten@securitygeeks.com
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
include('lib-common.php');
function adduserevent($eid) {
	global $USER, $LANG02;
	
	
	$retval .= startblock("Adding Event to {$USER['username']}'s Calendar");
	$eventsql = "SELECT *, datestart AS start, dateend AS end FROM {$CONF['db_prefix']}events where eid='$eid'";
	$result = dbquery($eventsql);
	$nrows = mysql_num_rows($result);
	if ($nrows == 1) {
		$A = mysql_fetch_array($result);
		$retval .= '<table border="0">'.LB
			.'<tr>'.LB
			.'<td colspan="2">'.$LANG02[8].'</td>'.LB
			.'</tr>'.LB
			.'<tr valign="top">'.LB
			.'<td><b>Event:</b></td>'.LB
			.'<td><a href="'.$A["url"].' target="_new">'.$A['title'].'</a></td>'.LB
			.'</tr>'.LB
			.'<tr valign="top">'.LB
			.'<td><b>Starts:</b></td>'.LB
			.'<td>'.$A['start'].'</td>'.LB
			.'</tr>'.LB
			.'<tr valign="top">'.LB
			.'<td><b>Ends:</b></td>'.LB
			.'<td>'.$A['end'].'</td>'.LB
			.'</tr>'.LB
			.'<tr valign="top">'.LB
			.'<td><b>Location:</b></td>'.LB
			.'<td>'.$A['location'].'</td>'.LB
			.'</tr>'.LB
			.'<tr valign="top">'.LB
			.'<td><b>Description:</b></td>'.LB
			.'<td>'.$A['description'].'</td>'.LB
			.'</tr>'.LB
			.'</table>';l
	} else {
		$retval .= showmessage(23);
	  	return $retval;
	}	
	$retval .= '<form name="userevent" method="post" action="'.$CONF['site_url'].'/calendar_event.php">'
		.'<input type="hidden" name="mode" value="saveuserevent">'
		.'<input type="hidden" name="eid" value="'.$eid.'">'
		.'<input type="submit" value="'.$LANG02[9].'"></form>';
		
	return $retval;
}

function saveuserevent($eid, $reminder, $emailreminder) {
	global $MESSAGE, $USER;
	//startblock("saving event");
	if (strlen($emailreminder) == 0) 
		$emailreminder = 0;
	else
		$emailreminder = 1; 
	//print $eid . ", " . $reminder . ", " . $emailreminder . "<br><b>done</b>";
	$savesql = "Insert into userevent (uid, eid) values ('{$USER['uid']}', '{$eid}')";
	//print "<br>sql = " . $savesql . "</br><br>";
	dbquery($savesql);
	return $refresh("{$CONF['site_url']}/calendar.php?msg=24");
}

###############################################################################
# MAIN
switch ($mode) {
	case 'addevent':
		$display .= site_header();
		if (!empty($eid)) {
			$display .= adduserevent($eid);
		} else {
			$display .= showmessage(23);
		}
		$display .= endblock()
			.site_footer();
		break;
	case 'saveuserevent':
		if (!empty($eid)) {
			$display .= saveuserevent($eid,$remind,$emailreminder);
		} else {
			$display .= showmessage(23);
		}
		break;
	case 'deleteevent':
		dbquery("delete from userevent where uid={$USER['uid']} and eid='$eid'");
		$display .= refresh($CONF['site_url'] . "/calendar.php?msg=26");
		break;
	default:
		site_header();
		if (!empty($eid)) {
			$display .= startblock($LANG30[9]);
			$datesql = "SELECT *,datestart AS start,dateend AS end FROM {$CONF['db_prefix']}events WHERE eid = '$eid'";
		} else {
			$display .= startblock($LANG30[10] . " $month/$day/$year");
			$thedate= $year . "-". $month . "-" . $day;
			$datesql = "SELECT *,datestart AS start,dateend AS end FROM {$CONF['db_prefix']}events WHERE \"$thedate\" BETWEEN datestart and dateend ORDER BY datestart asc,title";
		}
		$display .= "[ <a href={$CONF['site_url']}/submit.php?type=event>{$LANG02[6]}</a> ][ <a href={$CONF['site_url']}/calendar.php>Back to Calendar</a> ]<br>";
		$result = dbquery($datesql);
		$nrows = mysql_num_rows($result);
		if ($nrows==0) {
			$display .= $LANG02[1];
		} else {
			for($i=0;$i<$nrows;$i++) {
				$A = mysql_fetch_array($result);
				if (hasaccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
					if (strftime("%B",strtotime($A["start"])) != $currentmonth) {
						$display .= '<br><h1>' . strftime("%B %Y",strtotime($A["start"])) . '</h1>'.LB;
						$currentmonth = strftime("%B",strtotime($A["start"]));
					}
					$display .= '<table cellspacing="0" cellpadding="3" border="0" width="100%">'.LB
						.'<tr><td colspan="2"><h2><a href="'.$A['url'].'">'.$A['title'].'</a>&nbsp;';
						
					if (!empty($USER['uid'])) {
						$tmpresult = dbquery("select * from userevent where eid='{$A["eid"]}' and uid={$USER['uid']}");
						$tmpnrows = mysql_num_rows($tmpresult);
						if ($tmpnrows > 0) {
							$display .= '<font size="-2">[<a href="'.$CONF['site_url'].'/calendar_event.php?eid='.$A['eid'].'&mode=deleteevent">'.$LANG02[10].'</a>]</font></h2></td></tr>'.LB;
						} else {
							$display .= '<font size="-2">[<a href="'.$CONF['site_url'].'/calendar_event.php?eid='.$A['eid'].'&mode=addevent">'.$LANG02[9].'</a>]</font></h2></td></tr>'.LB;
						}
					}
					$display .= '<tr valign="top"><td align="right"><b>'.$LANG02[3].'</b></td><td width="100%">'.strftime("%A %e",strtotime($A["start"])).' - '.strftime("%A %d",strtotime($A["end"])).'</td></tr>'.LB
						.'<tr valign="top"><td align="right"><b>'.$LANG02[4].'</b></td><td width="100%">'.$A['location'].'</td></tr>'.LB
						.'<tr valign="top"><td align="right"><b>'.$LANG02[5].'</b></td><td width="100%">'.$A['description'].'</td></tr>'.LB
						.'</table>';
				} else {
					$display .= '<br><b>'.$LANG_ACCESS['accessdenied'].'</b>'
						.'<p>'.$LANG_ACCESS['eventdenialmsg'];
				}
			} 
		}
	
		$display .= endblock()
			.site_footer();
		
} // end switch
echo $display
?>
