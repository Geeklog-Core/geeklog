<?php

###############################################################################
# index.php
# This is, well duh, the index page!
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
# MAIN

site_header("menu");

$maxstories = 0;

// if no page sent then assume the first
if (empty($page)) $page = 1;

if (!empty($USER["uid"])) {
	$result = dbquery("SELECT noboxes,maxstories,tids,aids FROM {$CONF["db_prefix"]}userindex WHERE uid = '{$USER["uid"]}'");
	$U = mysql_fetch_array($result);
	if ($U["maxstories"] >= $CONF["minnews"]) $maxstories = $U["maxstories"];
	if ((!empty($topic)) && ($maxstories == 0)) {
		$tmp = dbquery("SELECT limitnews FROM {$CONF["db_prefix"]}topics WHERE tid = '{$topic}'");
		$T = mysql_fetch_array($tmp);
		if ($T["limitnews"] >= $CONF["minnews"])
			$maxstories = $T["limitnews"];
	}
	if ($maxstories == 0) $maxstories = $CONF["limitnews"];
	$U["maxstories"] = $maxstories;
} else {
	$U["maxstories"] = $CONF["limitnews"];
}

$limit = (($U["maxstories"] * $page) - ($U["maxstories"]) - 1);
if ($limit < 0) $limit=0;

showmessage($msg);

for ($i=0;$i<=1;$i++) {

	if ($page>1) $i = 1;

	$sql	= "SELECT *,unix_timestamp(date) AS day FROM {$CONF["db_prefix"]}stories WHERE draft_flag = 0";

	# if a topic was provided only select those stories.
	if (!empty($topic)) {
		$sql .= " AND tid = '$topic' AND ";
	} else {
		$sql .= " AND frontpage = 1 AND ";
	}

	if (!empty($U["aids"])) {
		$AIDS = explode(" ",$U["aids"]);
		for ($i=0; $i<sizeof($AIDS); $i++) {
			$sql .= "uid != '$AIDS[$i]' AND";
		}
	}

	if (!empty($U["tids"])) {
		$TIDS = explode(" ",$U["tids"]);
		for ($i=0; $i<sizeof($TIDS); $i++) {
			$sql .= "tid != '$TIDS[$i]' AND";
		}
	}


	# if this is the first pass get the featured story, if any
	if ($i == 0) {
		$sql .= " featured = 1 ORDER BY date desc LIMIT 1";
	} else {
		if ($feature == "true") $U["maxstories"] = $U["maxstories"] - 1;

 		$sql .= " featured != 1 ORDER BY date desc LIMIT $limit,{$U["maxstories"]}";
	}
	$result = dbquery($sql);
	$nrows = mysql_num_rows($result);

	$countsql = "SELECT count(*) count FROM {$CONF["db_prefix"]}stories WHERE draft_flag = 0";
	if (!empty($topic)) {
		$countsql = $countsql . " AND tid='$topic'";
	} else {
		$countsql = $countsql . " AND frontpage = 1";
	}
	$data = dbquery($countsql);
	$D = mysql_fetch_array($data);
	$num_pages = ceil($D["count"] / $U["maxstories"]);
	if ($nrows > 0) {
		for ($x=1;$x<=$nrows;$x++) {
			$A	= mysql_fetch_array($result);
			if ($i == 0) {
				print "<b>{$LANG05[4]}:</b>";
				$A["title"] = "<BIG>{$A["title"]}</BIG>";
				$feature = "true";
			}
			article($A,"y");
		}

		// Print Google-like paging navigation
		if ($i==1) PrintPageNavigation($page, $num_pages, $topic);

	} else if ($i == 1 && $feature != "true") {
		startblock($LANG05[1]);
		print "{$LANG05[2]} ";
		if (!empty($topic)) { print $LANG05[3]; }
		endblock();
	}
}

# this closes the story block <td> which is started in layout/header.php, but never gets closed
print "</td>\n\n";

# Display any blocks, polls, olderstuff configured for this page
# </td> removed from lines 136 and 138, since closing </td> already exists in footer.php

print "<td><img src={$CONF["site_url"]}/images/speck.gif height=1 width=10></td>\n";
if ($U["noboxes"] != 1) {
	print "<td valign=top width=180>\n";
	showblock("right",$topic);
	print "<br><img src={$CONF["site_url"]}/images/speck.gif width=180 height=1>\n";
} else {
	print "<td>&nbsp";
}

site_footer();

?>

