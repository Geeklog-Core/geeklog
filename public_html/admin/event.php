<?php

###############################################################################
# event.php
# This is the admin interface for the events system
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
# Displays the events editor form

function editevent($eid="") {
	global $LANG22,$CONF;
	startblock($LANG22[1]);
	if (!empty($eid)) {
		$result = dbquery("SELECT * FROM events where eid ='$eid'");
		$A = mysql_fetch_array($result);
	} 
	print "<form action={$CONF["site_url"]}/admin/event.php name=events method=post>";
	print "<table border=0 cellspacing=0 cellpadding=3>";
	print "<tr><td colspan=2><input type=submit value=save name=mode> ";
	print "<input type=submit value=cancel name=mode> ";
	if ($A["eid"] == "") { 
		$A["eid"] = makesid(); 
	}
        if (!empty($eid))
		print "<input type=submit value=delete name=mode>";
	print "<input type=hidden name=eid value={$A["eid"]}>";
	print "</td></tr>";
	print "<tr><td align=right>{$LANG22[3]}:</td><td><input type=text size=48 maxlength=96 name=title value=\"{$A["title"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG22[4]}:</td><td><input type=text size=48  maxlength=96 name=url value=\"{$A["url"]}\"> {$LANG22[9]}</td></tr>";
	print "<tr><td align=right>{$LANG22[5]}:</td><td><input type=text size=10 name=datestart value={$A["datestart"]}> YYYY-MM-DD</td></tr>";
	print "<tr><td align=right>{$LANG22[6]}:</td><td><input type=text size=10 name=dateend value={$A["dateend"]}> YYYY-MM-DD</td></tr>";
	print "<tr><td align=right>{$LANG22[7]}:</td><td><textarea name=location cols=50 rows=3 wrap=virtual>{$A["location"]}</textarea></td></tr>";
	print "<tr><td align=right>{$LANG22[8]}:</td><td><textarea name=description cols=50 rows=6 wrap=virtual>{$A["description"]}</textarea></td></tr>";
	print "</table></form>";
	endblock();
}

###############################################################################
# Svaes the events evente database

function saveevent($eid,$title,$url,$datestart,$dateend,$location,$description) {
	global $CONF,$LANG22;

	# clean 'em up 
	$description = addslashes(checkhtml(checkwords($description)));
	$title = addslashes(checkhtml(checkwords($title)));

	if (!empty($eid) && !empty($description) && !empty($title)) {
		dbsave("events","eid,title,url,datestart,dateend,location,description","$eid,'$title','$url','$datestart','$dateend','$location','$description'","admin/event.php?msg=17");
	} else {
		include("../layout/header.php");
		errorlog($LANG22[10],2);
		editevent($eid);
		include("../layout/footer.php");
	}
}

###############################################################################
# Displays the list of events items

function listevents() {
	global $LANG22,$CONF;
	startblock($LANG22[11]);
	adminedit("event",$LANG22[12]);
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr><th align=left>{$LANG22[13]}</th><th>{$LANG22[14]}</th><th>{$LANG22[15]}</th></tr>";
	$result = dbquery("SELECT eid,title,datestart,dateend FROM events ORDER BY datestart");
	$nrows = mysql_num_rows($result);
	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
		print "<tr align=center><td align=left><a href={$CONF["site_url"]}/admin/event.php?mode=edit&eid={$A["eid"]}>" . stripslashes($A["title"]) . "</a></td>";
		print "<td>{$A["datestart"]}</td><td>{$A["dateend"]}</td></tr>";
	}
	print "</table></form>";
	endblock();
}

###############################################################################
# MAIN

switch ($mode) {
	case "delete":
		dbdelete("events","eid",$eid,"/admin/event.php?msg=18");
		break;
	case "save":
		saveevent($eid,$title,$url,$datestart,$dateend,$location,$description);
		break;
	case "edit":
		include("../layout/header.php");
		editevent($eid);
		include("../layout/footer.php");
		break;
	case "cancel":
	default:
		include("../layout/header.php");
		showmessage($msg);
		listevents();
		include("../layout/footer.php");
		break;
}

?>
