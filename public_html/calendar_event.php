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
include("common.php");
include("custom_code.php");

function adduserevent($eid) {
	global $USER, $LANG02;
	startblock("Adding Event to {$USER["username"]}'s Calendar");
	$eventsql = "SELECT *, datestart AS start, dateend AS end FROM events where eid='$eid'";
	$result = dbquery($eventsql);
	$nrows = mysql_num_rows($result);
	if ($nrows == 1) {
		$A = mysql_fetch_array($result);
		print "<br><P>{$LANG02[8]}</P>";
		print "<b>Event:</b> <a href={$A["url"]} target=_new>" . $A["title"] . "</a><br><br>";
		print "<b>Starts:</b> " . $A["start"] . "&nbsp;&nbsp;";
		print "<b>Ends:</b> " . $A["end"] . "<br><br>";
		print "<b>Location:</b> " . $A["location"] . "<br><br>";
		print "<b>Description:</b> " . $A["description"] . "<br><br>";
	} else {
		showmessage(23);
	  	return;
	}	
	#print "<table><td align=right> Set reminder for: </td><td align=left><form name=userevent methood=post action={$CONF["site_url"]}/calendar_event.php>\n";
	#print "<select name=remind><option>1 day</option><option>3 days</option><option>1 week</option></select>";
	#print "</td><td> prior to event</td></tr><tr><td align=right>Email reminder:</td><td align=left>";
	#print "<input type=checkbox name=emailreminder><input type=hidden name=eid value={$eid}><input type=hidden name=mode value=saveuserevent></td></tr>";
	#print "<tr><td colspan=3 align=left><input type=submit value=\"{$LANG02[9]}\"></td></tr></form></table>";
	print "<form name=userevent method=post action={$CONF["site_url"]}/calendar_event.php><input type=hidden name=mode value=saveuserevent><input type=hidden name=eid value={$eid}><input type=submit value=\"{$LANG02[9]}\"><br>&nbsp;</td></tr></form></table>";
}

function saveuserevent($eid, $reminder, $emailreminder) {
	global $MESSAGE, $USER;
	//startblock("saving event");
	if (strlen($emailreminder) == 0) 
		$emailreminder = 0;
	else
		$emailreminder = 1; 
	//print $eid . ", " . $reminder . ", " . $emailreminder . "<br><b>done</b>";
	$savesql = "Insert into userevent (uid, eid) values ('{$USER["uid"]}', '{$eid}')";
	//print "<br>sql = " . $savesql . "</br><br>";
	dbquery($savesql);
	refresh("{$CONF["site_url"]}/calendar.php?msg=24");
}

###############################################################################
# MAIN

switch ($mode) {
	case "addevent":
		include("layout/header.php");
		if (!empty($eid)) 
			adduserevent($eid);
		else
			showmessage(23);
		endblock();
		include("layout/footer.php");
		break;
	case "saveuserevent":
		if (!empty($eid))
			saveuserevent($eid,$remind,$emailreminder);
		else
			showmessage(23);
		break;
	case "deleteevent":
		dbquery("delete from userevent where uid={$USER["uid"]} and eid='$eid'");
		refresh($CONF["site_url"] . "/calendar.php?msg=26");
		break;
	default:
		include("layout/header.php");
		if (!empty($eid)) {
			startblock($LANG30[9]);
			$datesql = "SELECT *,datestart AS start,dateend AS end FROM events WHERE eid = '$eid'";
		} else {
			startblock($LANG30[10] . " $month/$day/$year");
			$thedate= $year . "-". $month . "-" . $day;
			$datesql = "SELECT *,datestart AS start,dateend AS end FROM events WHERE \"$thedate\" BETWEEN datestart and dateend ORDER BY datestart asc,title";

		}
		print "[ <a href={$CONF["site_url"]}/submit.php?type=event>{$LANG02[6]}</a> ][ <a href={$CONF["site_url"]}/calendar.php>Back to Calendar</a> ]<br>";
		//dbquery("delete FROM events WHERE dateend < CURDATE()");
		$result = dbquery($datesql);

		$nrows = mysql_num_rows($result);
		if ($nrows==0) {
			print $LANG02[1];
		} else {
			for($i=0;$i<$nrows;$i++) {
				$A = mysql_fetch_array($result);
				if (strftime("%B",strtotime($A["start"])) != $currentmonth) {
					print "<br><h1>" . strftime("%B %Y",strtotime($A["start"])) . "</h1>\n";
					$currentmonth = strftime("%B",strtotime($A["start"]));
				}
				print "<table cellspacing=0 cellpadding=3 border=0 width=\"100%\">\n";
				print "<tr><td colspan=2><h2><a href={$A["url"]}>{$A["title"]}</a>&nbsp;";
				if (!empty($USER["uid"])) {
					$tmpresult = dbquery("select * from userevent where eid='{$A["eid"]}' and uid={$USER["uid"]}");
					$tmpnrows = mysql_num_rows($tmpresult);
					if ($tmpnrows > 0) {
						print "<font size=-2>[<a href={$CONF["site_url"]}/calendar_event.php?eid={$A["eid"]}&mode=deleteevent>{$LANG02[10]}</a>]</font></h2></td></tr>\n";
					} else {
						print "<font size=-2>[<a href={$CONF["site_url"]}/calendar_event.php?eid={$A["eid"]}&mode=addevent>{$LANG02[9]}</a>]</font></h2></td></tr>\n";
					}
				}
				print "<tr><td align=right><b>{$LANG02[3]}</b></td><td width=\"100%\">" . strftime("%A %e",strtotime($A["start"])) . " - " . strftime("%A %d",strtotime($A["end"])) . "</td></tr>\n";
				print "<tr><td align=right><b>{$LANG02[4]}</b></td><td width=\"100%\">{$A["location"]}</span></td></tr>\n";
				print "<tr><td align=right valign=top><b>{$LANG02[5]}</b></td><td width=\"100%\">{$A["description"]}</span></td></tr>\n";
				print "</table>";
			} 
		}
	
		endblock();
		include("layout/footer.php");
} // end switch
?>
