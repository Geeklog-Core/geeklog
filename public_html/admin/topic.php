<?php

###############################################################################
# topic.php
# This is the admin topics interface!
#
# Copyright (C) 2000 Jason Whitteburg
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
# Displays the topic editor

function edittopic($tid="") {
	global $LANG27,$CONF;
	startblock($LANG27[1]);
	if (!empty($tid)) {
		$result = dbquery("SELECT * FROM topics where tid ='$tid'");
		$A = mysql_fetch_array($result);
	}	 
	print "<form action={$CONF["site_url"]}/admin/topic.php method=post>";
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr><td colspan=2><input type=submit value=save name=mode> ";
	print "<input type=submit value=cancel name=mode> ";
	if (!empty($tid))
		print "<input type=submit value=delete name=mode>";
	print "<tr></td>";
	print "<tr><td align=right>{$LANG27[2]}:</td><td><input type=text size=20 name=tid value=\"{$A["tid"]}\"> {$LANG27[5]}</td></tr>";
	// show sort order only if they specified sortnum as the sort method
	if ($CONF["sortmethod"] <> 'alpha')
		print "<tr><td align=right>{$LANG27[10]}:</td><td><input type=text size=3 maxlength=3 name=sortnum value=\"{$A["sortnum"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG27[11]}:</td><td><input type=text size=3 maxlength=3 name=limitnews value=\"{$A["limitnews"]}\"> (default is {$CONF["limitnews"]})</td></tr>";
	print "<tr><td align=right>{$LANG27[3]}:</td><td><input type=text size=48 name=topic value=\"{$A["topic"]}\"></td></tr>";
	if ($A["tid"] == "") { $A["imageurl"] = "/images/topics/"; }
	print "<tr><td align=right>{$LANG27[4]}:</td><td><input type=text size=48 maxlength=96 name=imageurl value=\"{$A["imageurl"]}\"></td></tr>";
	print "<tr><td colspan=2 class=warning>{$LANG27[6]}</td></tr>";
	print "</table></form>";
	endblock();
}

###############################################################################
# Saves $tid to the database

function savetopic($tid,$topic,$imageurl,$sortnum,$limitnews) {
	global $CONF,$LANG27;
	if (!empty($tid) && !empty($topic)) {
		if ($imageurl == "/images/topics/") { $imageurl = ""; }	
		dbsave("topics","tid, topic, imageurl, sortnum, limitnews","'$tid', '$topic', '$imageurl','$sortnum','$limitnews'","admin/topic.php?msg=13");
	} else {
		include("../layout/header.php");
		errorlog($LANG27[7],2);
		edittopic($tid);
		include("../layout/footer.php");
	}
}

###############################################################################
# Displays a list of topics

function listtopics() {
	global $LANG27,$CONF;
	startblock($LANG27[8]);
	adminedit("topic",$LANG27[9]);
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr align=center valign=bottom>";
	$result = dbquery("SELECT * FROM topics");
	$nrows = mysql_num_rows($result);
	$counter = 1;
	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
		if (!empty($A["imageurl"])) {
			print "<td><a href={$CONF["site_url"]}/admin/topic.php?mode=edit&tid={$A["tid"]}><img src={$CONF["site_url"]}{$A["imageurl"]} border=0><br>{$A["topic"]}</a></td>";
		} else {
			print "<td><a href={$CONF["site_url"]}/admin/topic.php?mode=edit&tid={$A["tid"]}>{$A["topic"]}</a></td>";
		}
		if ($counter == 5) {
			$counter = 1;
			print "</tr><tr align=center>";
		} else {
			$counter = $counter + 1;
		}			
	}
	print "</tr></table></form>";
	endblock();
}

###############################################################################
# MAIN

switch ($mode) {
	case "delete":
		dbdelete("stories","tid",$tid);
		dbdelete("blocks","tid",$tid);
		dbdelete("topics","tid",$tid,"/admin/topic.php?msg=14");
		break;
	case "save":
		savetopic($tid,$topic,$imageurl,$sortnum,$limitnews);
		break;
	case "edit":
		include("../layout/header.php");
		edittopic($tid);
		include("../layout/footer.php");
		break;
	case "cancel":
	default:
		include("../layout/header.php");
		showmessage($msg);
		listtopics();
		include("../layout/footer.php");
		break;}

?>
