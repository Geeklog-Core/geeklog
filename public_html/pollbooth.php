<?php

###############################################################################
# pollbooth.php
# This is the pollbooth file.
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

include("common.php");
include("custom_code.php");

###############################################################################
# Saves the users vote, if allowed for the poll $qid

function pollsave() {
	global $qid,$aid,$db,$REMOTE_ADDR,$LANG07;
	dbchange("pollquestions","voters","voters + 1","qid",$qid);
	dbchange("pollanswers","votes","votes + 1","qid",$qid,"aid",$aid);
	dbsave("pollvoters","ipaddress, date, qid","'$REMOTE_ADDR',unix_timestamp(),'$qid'");
	startblock($LANG07[1]);
	print "{$LANG07[2]} $qid";
	endblock();
	pollresults($qid);
}

###############################################################################
# List all the polls on the system if no $qid is provided

function polllist() {
	global $CONF,$LANG07;
	$result = dbquery("SELECT qid FROM pollquestions");
	$nrows = mysql_num_rows($result);
	$counter = 0;
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>\n";
	print "<tr align=center valign=top>";
	for ($i = 1; $i <= $nrows; $i++) {
		if ($counter == 3) {
			print "</tr><tr align=center valign=top>";
			$counter = 1;
		} else {
			$counter = $counter + 1;
		}
		print "<td>";
		$Q = mysql_fetch_array($result);
		pollresults($Q["qid"],"119");
		print "[ <a href={$CONF["site_url"]}/pollbooth.php?qid={$Q["qid"]}>{$LANG07[3]}</a> ]</td>\n";
	}
	print "</table>\n";
}

###############################################################################
# MAIN
#
# no qid will load a list of polls
# no aid will let you vote on the select poll
# an aid greater than 0 will save a vote for that answer on the selected poll
# an aid of -1 will display the select poll

if ($reply == $LANG01[25]) {
	refresh("{$CONF["site_url"]}/comment.php?sid=$qid&pid=$pid&type=$type");
	exit;			
}
if (empty($qid)) {
	include("layout/header.php");
	polllist();
} else if (empty($aid)) {
	include("layout/header.php");
	if (empty($HTTP_COOKIE_VARS[$qid])) {
		pollvote($qid);
	} else {
		pollresults($qid,400,$order,$mode);
	}
} else if ($aid  > 0  and empty($HTTP_COOKIE_VARS[$qid])) {
	setcookie($qid,$aid,time()+$CONF["pollcookietime"]);
	include("layout/header.php");
	pollsave();
} else {
	include("layout/header.php");
	pollresults($qid,400,$order,$mode);
}
include("layout/footer.php");

?>
