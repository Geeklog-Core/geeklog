<?php

###############################################################################
# polls.php
# This is the admins polls file.
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
# Saves a poll from the database

function savepoll($qid,$display,$question,$voters,$statuscode,$commentcode,$A,$V) {
	global $LANG25,$CONF;
	if (empty($voters)) { $voters = "0"; }
	dbdelete("pollquestions","qid",$qid);
	dbdelete("pollanswers","qid",$qid);
	$sql = "'$qid','$question',$voters,'" . date("Y-m-d H:i:s");
	if (!empty($display)) { 
		$sql .= "',$display";
	} else {
		$sql .= "',0";
	}
	$sql .= ",'$statuscode','$commentcode'";
	dbsave("pollquestions","qid, question, voters, date, display, statuscode, commentcode",$sql);
	for ($i=0; $i<sizeof($A); $i++) {
		if (!empty($A[$i])) {
			if (empty($V[$i])) { $V[$i] = "0"; }
			dbsave("pollanswers","qid, aid, answer, votes","'$qid', $i+1, '$A[$i]', $V[$i]");
		}
	}
	refresh($CONF["site_url"] . "/admin/poll.php?msg=19");
	//startblock($LANG25[3]);
	//print $LANG25[4];
	//endblock();
}

###############################################################################
# Displays the poll editor form

function editpoll($qid="") {
	global $LANG25,$CONF;
	$question = dbquery("select * from pollquestions WHERE qid='$qid'");
	$answers = dbquery("select answer,aid,votes from pollanswers WHERE qid='$qid'");
	$Q = mysql_fetch_array($question);
	startblock($LANG25[5]);
	print "<FORM ACTION={$CONF["site_url"]}/admin/poll.php METHOD=post>\n";
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr><td colspan=2><INPUT TYPE=SUBMIT NAME=mode VALUE=save> ";
	print "<input type=submit name=mode value=cancel> ";
	if (!empty($qid))
		print "<INPUT TYPE=SUBMIT NAME=mode VALUE=delete>";
	print "</td></tr>\n";
	print "<tr><td align=right>{$LANG25[6]}:</td><td><INPUT TYPE=TEXT NAME=qid value=\"{$Q["qid"]}\" SIZE=20> {$LANG25[7]}</td></tr>\n";
	print "<tr><td align=right>{$LANG25[9]}:</td><td><INPUT TYPE=TEXT NAME=question value=\"{$Q["question"]}\" SIZE=50 MAXLENGTH=255></td></tr>\n";
	print "</select></td></tr>";
	print "<tr><td align=right>{$LANG25[1]}:</td><td><select name=statuscode>";
	optionlist("statuscodes","code,name",$Q["statuscode"]);
	print "</select> <select name=commentcode>";
	optionlist("commentcodes","code,name",$Q["commentcode"]);
	print "</select></td></tr>";
	print "<tr><td align=right>{$LANG25[8]}:</td><td><INPUT TYPE=CHECKBOX NAME=display ";
	if ($Q["display"] = 1) { 
		print "checked ";
	}
	print "value=\"{$Q["display"]}\"></td></tr>\n";
	print "<tr><td align=right valign=top>{$LANG25[10]}:</td><td>\n";
	for ($i=0; $i<$CONF["maxanswers"]; $i++) {
		$A = mysql_fetch_array($answers);
		print "<INPUT TYPE=text NAME=\"answer[]\" value=\"{$A["answer"]}\" SIZE=30 MAXLENGTH=255>\n";
		print " / <INPUT TYPE=text NAME=\"votes[]\" value=\"{$A["votes"]}\" SIZE=5><BR>\n";
	}
	print "<td></tr>";
	print "</table></FORM>\n";
	endblock();
}

###############################################################################
# Displays a list of existing blocks

function listpoll() {
	global $CONF,$LANG25;
	startblock($LANG25[18]);
	adminedit("poll",$LANG25[19]);
	print "<table border=0 cellspacing=0 cellpadding=2 width=\"100%\">";
	print "<tr><th align=left>$LANG25[9]</th><th>$LANG25[20]</th><th>$LANG25[3]</th><th>$LANG25[8]</th></tr>";
	$result = dbquery("SELECT * FROM pollquestions");
	$nrows = mysql_num_rows($result);
	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
		if ($A[4] == 1) $A[4] = "Y";
		print "<tr align=center><td align=left><a href={$CONF["site_url"]}/admin/poll.php?mode=edit&qid={$A[0]}>{$A[1]}</a></td>";
		print "<td>{$A[2]}</td><td>{$A[3]}</td><td>{$A[4]}</td></tr>";
	}
	print "</table>";
	endblock();
}

###############################################################################
# MAIN


switch($mode)
{
	case "save":
		if (!empty($A[0]))
		{
			$voters = 0;
		        for ($i=0; $i<sizeof($answer); $i++) {
                		$voters = $voters + $votes[$i];
        		}
		        savepoll($qid,$display,$question,$voters,$statuscode,$commentcode,$answer,$votes);
		}
		break;
	case "edit":
	        include("../layout/header.php");
        	editpoll($qid);
        	include("../layout/footer.php");
		break;
	case "delete":
		if (!empty($qid))
		{
			dbdelete("pollquestions","qid",$qid);
		        dbdelete("pollanswers","qid",$qid,"/admin/poll.php?msg=20");
		}
		break;
	case cancel:
	default:
 		include("../layout/header.php");
		showmessage($msg);
		listpoll();
		include("../layout/footer.php");
		break;
}


?>
