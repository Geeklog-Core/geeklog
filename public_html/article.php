<?php

###############################################################################
# article.php
# This is the article page that brings it to life!
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
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

###############################################################################
# MAIN

# First see if we have a plugin that may be trying to use the Geeklog comment engine
if (DoPluginCommentSupportCheck($type)) {
	# Yes, this is a plugin wanting to be commented on...do it
	refresh("{$CONF["site_url"]}/comment.php?sid=$story&pid=$pid&type=$type");
}

$result = dbquery("SELECT count(*) as count FROM {$CONF["db_prefix"]}stories WHERE sid = '$story'");
$A = mysql_fetch_array($result);
if ($A["count"] > 0) {
	if ($reply == $LANG01[25]) {
		refresh("{$CONF["site_url"]}/comment.php?sid=$story&pid=$pid&type=$type");
	} else if ($mode == "print") {
		$result = dbquery("SELECT *,unix_timestamp(date) AS day from stories WHERE sid = '$story'");
		$A = mysql_fetch_array($result);
		$CONF["pagetitle"] = stripslashes($A["title"]);
		print "<html><title>{$CONF["site_name"]} : {$CONF["pagetitle"]}</title><body>\n";
		print "<H1>" . stripslashes($A["title"]) . "</H1>\n";
		print "<H3>" . strftime($CONF["date"],$A["day"]) . "</H3>";
		if ($CONF["contributedbyline"] == 1) {
			print "<BR><H3>$LANG01[1] " . getitem("users","username","uid = {$A["uid"]}") . "</H3>\n";
		}
		print "<p>" . nl2br(stripslashes($A["introtext"]));
		print "\n<p>" . nl2br(stripslashes($A["bodytext"]));
		print "<p><a href={$CONF["site_url"]}/article.php?story=$story#comments>" . dbcount("comments","sid",$A["sid"]) . " $LANG01[3]</a>\n";
		print "<br><br><hr>\n";
		print "<p>{$CONF["site_name"]}<br>\n";
		print "<a href={$CONF["site_url"]}/article.php?story=$story>{$CONF["site_url"]}/article.php?story=$story</a>\n";
		print "</body></html>";
	} else {

		#Set page title
		$result = dbquery("SELECT *,unix_timestamp(date) AS day from stories WHERE sid = '$story'");
		$A = mysql_fetch_array($result);
		$CONF["pagetitle"] = stripslashes($A["title"]);

		site_header("menu");
		dbchange("stories","hits","hits + 1","sid",$story);
		$sql	= "SELECT *,unix_timestamp(date) AS day from {$CONF["db_prefix"]}stories WHERE sid = '$story' ";
		$result = dbquery($sql);
		$A = mysql_fetch_array($result);

		# Display whats related any polls configured for this page
		
		echo "<table border=\"0\" align=\"right\">\n"
			."<tr>\n"
			."<td><img src={$CONF["site_url"]}/images/speck.gif height=1 width=10></td>\n"
			."<td valign=\"top\">\n";
			
		startblock("$LANG11[1]");
		print nl2br($A["related"]);
		endblock();
		
		startblock("$LANG11[4]");
		echo "<li><a href={$CONF["site_url"]}/profiles.php?sid=$story&what=emailstory>$LANG11[2]</a>\n"
			."<li><a href={$CONF["site_url"]}/article.php?story=$story&mode=print>$LANG11[3]</a>";
		endblock();

		if (dbcount("pollquestions","qid",$story) > 0) {
			showpoll(80,$story);
		}
		
		echo "<br><img src={$CONF["site_url"]}/images/speck.gif width=180 height=1></td>\n"
			."</tr>\n"
			."</table>\n";

		article($A,"n");

		# Display the comments
		if ($A["commentcode"] >= 0) {
			print "<br>\n";
			usercomments($story,$A["title"],"article",$order,$mode);
		}
		site_footer();
	}
} else {
	refresh("{$CONF["site_url"]}/index.php");
}

?>
