<?php

##/ COMMON.PHP /###############################################################
#
#	Copyright (C) 2000 Jason Whittenburg - jwhitten@securitygeeks.com
#	Copyright (C) 2001 Tony Bibbs - tony@tonybibbs.com
#
#	This program is free software; you can redistribute it and/or
#	modify it under the terms of the GNU General Public License
#	as published by the Free Software Foundation; either version 2
#	of the License, or (at your option) any later version.
#
#	This program is distributed in the hope that it will be useful,
#	but WITHOUT ANY WARRANTY; without even the implied warranty of
#	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#	GNU General Public License for more details.
#
#	You should have received a copy of the GNU General Public License
#	along with this program; if not, write to the Free Software
#	Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
$VERSION="1.3";
###############################################################################

$VERBOSE = false; #turn this on go get various debug messages

##/ DATABASE SETTINGS /########################################################
#
#	These settings must suit your server environment.

include('/path/to/geeklog/config.php');

include($CONF['path'].$CONF["languagefile"]);
include($CONF['path_html'].'layout/'.$CONF["layout"].'/index.php');
include($CONF['path_html'].'sessions.php');
include($CONF['path_html'].'plugins.php');

setlocale(LC_ALL, $CONF["locale"]);

##/ USER LOADER /##############################################################
#
#	Portions of the code below come from phpBB (www.phpbb.org).

unset($USER);

// We MUST do this up here, so it's set even if the cookie's not present.

$user_logged_in = 0;
$logged_in = 0;
$userdata = Array();

// Check for a cookie on the users's machine.
// If the cookie exists, build an array of the users info and setup the theme.

// new code for the session ID cookie..
if(isset($HTTP_COOKIE_VARS[$CONF["cookie_session"]])) {
        $sessid = $HTTP_COOKIE_VARS[$CONF["cookie_session"]];
        $userid = get_userid_from_session($sessid, $CONF["cookie_timeout"], $REMOTE_ADDR, $CONF["cookie_ip"]);
        if ($userid) {
           $user_logged_in = 1;
           update_session_time($sessid, $CONF["cookie_ip"]);
           $userdata = get_userdata_from_id($userid);
           $USER = $userdata;
        }
} else
        errorlog("sessioncookie NOT set", 1);

// set expire dates: one for a year, one for 10 minutes
$expiredate1 = time() + 3600 * 24 * 365;
$expiredate2 = time() + 600;

// update LastVisit cookie. This cookie is updated each time auth.php runs
setcookie("LastVisit", time(), $expiredate1,  $CONF["cookie_path"], $CONF["cookiedomain"], $CONF["cookiesecure"]);
// set LastVisitTemp cookie, which only gets the time from the LastVisit
// cookie if it does not exist yet
// otherwise, it gets the time from the LastVisitTemp cookie
if (!isset($HTTP_COOKIE_VARS["LastVisitTemp"])) {
        $temptime = $HTTP_COOKIE_VARS["LastVisit"];
}
else {
        $temptime = $HTTP_COOKIE_VARS["LastVisitTemp"];
}

// set cookie.
setcookie("LastVisitTemp", $temptime ,$expiredate2, $CONF["cookie_path"], $CONF["site_url"], $CONF["cookiesecure"]);

## Get user permissions
$RIGHTS = explode(',',getuserpermissions());

###############################################################################
# BLOCK LOADER - Load all definable HTML blocks in to memory
###############################################################################

$result = dbquery("SELECT title,content FROM {$CONF["db_prefix"]}blocks WHERE type = 'layout'");
$nrows = mysql_num_rows($result);
for ($i = 1; $i <= $nrows; $i++) {
	$A = mysql_fetch_array($result);
	$BLOCK[$A["title"]] = $A["content"];
}

###############################################################################
# DATA BASE FUCNTIONS - ALL DATABASE CALLS ARE MADE THROUGH THESE FUNCTIONS
###############################################################################

###############################################################################
# Query Database - Main DB function that accepts a query string and provides
#			 back a result.  This function also traps error codes.

function dbquery($sql,$ignore_errors=0) {
	global $CONF,$LANG01;

	$db = mysql_connect($CONF["db_host"],$CONF["db_user"],$CONF["db_pass"]);
	@mysql_select_db($CONF["db_name"]) or die();

	$result = @mysql_query($sql,$db);
	if (mysql_errno() == 0 && !empty($result)) {
		return $result;
	} else {
		if ($ignore_errors == 1) return -1;
		$errortxt = "{$LANG01[50]} $sql\n";
		$errortxt .= " - {$LANG01[45]}: " . mysql_errno() . "\n";
		$errortxt .= " - {$LANG01[46]}: " . mysql_error();
		errorlog ($errortxt);
		exit;
	}
}

###############################################################################
# Delete from database

function dbdelete($table,$id,$value,$return="") {
	global $CONF;
	$sql = "DELETE FROM {$CONF["db_prefix"]}$table";
	if (!empty($id) && !empty($value)) {
		 $sql .= " WHERE $id = '$value'";
	}
	dbquery($sql);
	if ($table == "stories") {
		export_rdf();
		olderstuff();
	}
	if (!empty($return)) {
		refresh("{$CONF["site_url"]}/$return");
	}
}

###############################################################################
# Saves to the database

function dbsave($table,$fields,$values,$return="") {
	global $CONF;

	$sql = "REPLACE INTO {$CONF["db_prefix"]}$table ($fields) VALUES ($values)";
	dbquery($sql);

	if ($table == "stories") {
		export_rdf();
		olderstuff();
	}

	if (!empty($return)) {
		refresh("{$CONF["site_url"]}/$return");
	}
}

###############################################################################
# Changes an item in database

function dbchange($table,$id,$value,$id2="",$value2="",$id3="",$value3="",$return="") {
	global $CONF;
	
	$sql = "UPDATE {$CONF["db_prefix"]}$table SET $id = $value";

	if (!empty($id2) && !empty($value2)) {
		$sql .= " WHERE $id2 = '$value2'";
		if (!empty($id3) && !empty($value3)) {
			$sql .= " AND $id3 = '$value3'";
		}
	}

	dbquery($sql);

	if ($table == "stories") {
		export_rdf();
		olderstuff();
	}

	if (!empty($return)) {
		refresh("{$CONF["site_url"]}/$return");
	}
}

###############################################################################
# Counts the # of times $what appears a $feild in the $table

function dbcount($table,$id="",$value="",$id2="",$value2="") {
	global $CONF;
	
	$sql = "SELECT COUNT(*) FROM {$CONF["db_prefix"]}$table";

	if (!empty($id) && !empty($value)) {
		$sql .= " WHERE $id = '$value'";
		#if (!empty($id2) && !empty($value2)) {
		if (strlen($id2) && strlen($value2)) {
			$sql .= " AND $id2 = '$value2'";
		}
	}

	$result = dbquery($sql);
	return (mysql_result($result,0));
}

###############################################################################
# Moves an item in database between tables

function dbcopy($table,$fields,$values,$tablefrom,$id,$value,$return="") {
	global $CONF;

	$sql = "REPLACE INTO {$CONF["db_prefix"]}$table ($fields) SELECT $values FROM {$CONF["db_prefix"]}$tablefrom";
	if (!empty($id) && !empty($value)) {
		 $sql .= " WHERE $id = '$value'";
	}

	errorlog('sql ' . $sql);
	dbquery($sql);
	dbdelete($tablefrom,$id,$value);

	if ($table == "stories") {
		export_rdf();
		olderstuff();
	}

	if (!empty($return)) {
		refresh("{$CONF["site_url"]}/$return");
	}
}

###############################################################################
# STORY FUCNTIONS
###############################################################################

###############################################################################
# Displays the array passed to it as an article

function article($A,$index="") {
	global $mode,$CONF,$LANG01,$USER;
	if (!empty($USER["uid"])) {
		$result = dbquery("SELECT noicons FROM {$CONF["db_prefix"]}userprefs WHERE uid = {$USER["uid"]}",1);
		$nrows = mysql_num_rows($result);
		if ($nrows == 1) {
			$U = mysql_fetch_array($result);
			$USER["noicons"] = $U["noicons"];
		}
	}
	$curtime = getuserdatetimeformat($A["day"]);
	$A["day"] = $curtime[0];
	print "<table border=0 cellpadding=0 cellspacing=0 width=100%>\n";
	print "<tr><td class=storytitle>" . stripslashes($A["title"]) . "</TD></TR>\n";
	print "<tr><td height=1 class=storyunderline><IMG SRC={$CONF["site_url"]}/images/speck.gif width=1 height=1></td></tr>\n";
	print "<tr><td class=storybyline>" . $A["day"];
	if ($CONF["contributedbyline"] == 1) {
		if ($A["uid"] > 1) {
			print "<br>{$LANG01[1]} <a class=storybyline href={$CONF["site_url"]}/users.php?mode=profile&uid={$A["uid"]}>" . getitem("users","username","uid = {$A["uid"]}") . "</a></td></tr>\n";
		} else {
			print "<br>{$LANG01[1]} " . getitem("users","username","uid = '{$A["uid"]}'") . "</td></tr>\n";
		}
	}
	print "<tr><td>";
	if ($USER["noicons"] != 1) {
		$top	= getitem("topics","imageurl","tid = '{$A["tid"]}'");
		if (!empty($top)) {
			print "<a href={$CONF["site_url"]}/index.php?topic={$A["tid"]}><img align=right src={$CONF["site_url"]}$top alt={$A["tid"]} border=0></a>";
		}
	}
	print nl2br(stripslashes($A["introtext"]));
	if ($index == "n") {
		print "<br><br>";
		print nl2br(stripslashes($A["bodytext"]));
	} else {
		print "\n</td></tr><tr><td>\n<div align=right>\n";
		if (!empty($A["bodytext"])) {
			print "<a href={$CONF["site_url"]}/article.php?story={$A["sid"]}>{$LANG01[2]}</a> (" . sizeof(explode(" ",$A["bodytext"])) . " {$LANG01[62]}) \n";
		}
		if ($A["commentcode"] >= 0 && $A["comments"] > 0) {
			print "<a href={$CONF["site_url"]}/article.php?story={$A["sid"]}#comments> {$A["comments"]} {$LANG01[3]}</a>\n";
			$result = dbquery("SELECT UNIX_TIMESTAMP(date) AS day FROM {$CONF["db_prefix"]}comments WHERE sid = '{$A["sid"]}' ORDER BY date desc LIMIT 1");
			$C = mysql_fetch_array($result);
			print "<br><span class=storybyline>{$LANG01[27]}: " . strftime($CONF["daytime"],$C["day"]) . "</span>\n";
		} else if ($A["commentcode"] >= 0) {
			print " <a href={$CONF["site_url"]}/comment.php?sid={$A["sid"]}&pid=0&type=article>{$LANG01[60]}</a>\n";
		}
		print "<a href={$CONF["site_url"]}/profiles.php?sid={$A["sid"]}&what=emailstory><img src={$CONF["site_url"]}/images/mail.gif alt=\"{$LANG01[64]}\" border=0></a>&nbsp;<a href={$CONF["site_url"]}/article.php?story={$A["sid"]}&mode=print><img border=0 src={$CONF["site_url"]}/images/print.gif alt=\"{$LANG01[65]}\"></a>";
	}
	$access = hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]);
	print "\n\naccess = $access";
	if (hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]) == 3 AND hasrights('story.edit')) {
		print "<br><a href={$CONF["site_url"]}/admin/story.php?mode=edit&sid={$A["sid"]}>{$LANG01[4]}</a>";
	}
	print "</div></td>\n</tr>\n";
	print "</table><br>\n";
}

###############################################################################
# HTML WIDGETS
###############################################################################

###############################################################################
# Prints out our standard header and sets up a body block
# THIS IS GOING AWAY SOON - WILL BE REPLACED BY NEW BLOCK/TEMPLATE FUNCTIONS

function startblock($title="",$helpfile="") {
	global $BLOCK,$LANG01,$CONF;
	$block = $BLOCK["blockheader"];
	if (!empty($helpfile)) {
		$help = "<a class=blocktitle href={$CONF["site_url"]}/help/$helpfile target=_blank><img src={$CONF["site_url"]}/images/button_help.gif border=0 height=15 width=15 alt=\"?\"></a>";
	} else {
		$help = "&nbsp;";
	}
	$block = str_replace("%title",$title,$block);
	$block = str_replace("%help",$help,$block);
#	$trans = array("%title" => stripslashes($title), "%help" => $help);
#	print strtr($BLOCK["blockheader"],$trans);
	print $block;
}

###############################################################################
# Prints out our standard header and sets up a body block
# THIS IS GOING AWAY SOON - WILL BE REPLACED BY NEW BLOCK/TEMPLATE FUNCTIONS

function adminedit($type,$text="") {
	global $LANG01,$CONF;
	if (HandlePluginAdminEdit($type)) {
		//this was a plugin type, we are done now...exiting
		return;
	} else {
		print "<table border=0 cellspacing=0 cellpadding=2 width=\"100%\">";
		print "<tr><td rowspan=2><img src={$CONF["site_url"]}/images/icons/$type.gif></td>";
		print "<td>[ <a href={$CONF["site_url"]}/admin/$type.php?mode=edit>{$LANG01[52]} $type</a> | <a href={$CONF["site_url"]}/admin>{$LANG01[53]}</a> ]</td></tr>";
		print "<tr><td>$text</td></tr>";
		print "</table><p>";
	}
}

###############################################################################
# Same as startblock, but set up for the comments
# THIS IS GOING AWAY SOON - WILL BE REPLACED BY NEW BLOCK/TEMPLATE FUNCTIONS

function startcomment() {
	print "<table border=0 cellpadding=0 cellspacing=0 width=\"100%\">\n";
	print "<tr><td><table width=\"100%\" border=0 cellspacing=0 cellpadding=3>\n";
}

###############################################################################
# Closes out startcomment and startblock
# THIS IS GOING AWAY SOON - WILL BE REPLACED BY NEW BLOCK/TEMPLATE FUNCTIONS

function endblock() {
	global $BLOCK;
	print $BLOCK["blockfooter"];
}

###############################################################################
# Feteches the an item associated with a selection
# $selection is a selection list in the format of $id,$title

function getitem($table,$what,$selection) {
	$result = dbquery("SELECT $what FROM {$CONF["db_prefix"]}$table WHERE $selection");
	$ITEM = mysql_fetch_array($result);
	return $ITEM[0];
}

###############################################################################
# Creates a <option> list from a database list for use in forms
# $selection is a selection list in the format of $id,$title

function optionlist($table,$selection,$selected="") {
	$select_set = explode(",", $selection);
	$result = dbquery("SELECT $selection FROM {$CONF["db_prefix"]}$table ORDER BY $select_set[1]");
	$nrows = mysql_num_rows($result);
	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
		print "<option value=\"{$A[0]}\"";
		if ($A[0] == $selected) { print " selected"; }
		print ">{$A[1]}</option>\n";
	}
}

###############################################################################
# Creates a <input> checklist from a database list for use in forms
# $selection is a selection list in the format of $id, $title

function checklist($table,$selection,$where="",$selected="") {
	$sql = "SELECT $selection FROM {$CONF["db_prefix"]}$table";
	if (!empty($where)) $sql .= " WHERE $where";
	$result = dbquery($sql);
	$nrows = mysql_num_rows($result);
	if (!empty($selected)) $S = explode(" ",$selected);
	for ($i=0;$i<$nrows;$i++) {
		$access = true;
		$A = mysql_fetch_array($result);
		if ($table == 'topics' AND hastopicaccess($A['tid']) == 0) {
			$access = false;
		}
		if ($access) {
			print "<input type=checkbox name={$table}[] value=\"{$A[0]}\"";
			for ($x=0; $x<sizeof($S); $x++) {
				if ($A[0] == $S[$x]) print " checked";
			}
			if ($A[2]<10 && $A[2]>0) {
				print "><b>{$A[1]}</b><br>\n";
			} else {
				print ">{$A[1]}<br>\n";
			}
		}
	}
}

###############################################################################
# Prints out the HTTP headers post information for debugging
#
# The core of this code has been lifted from phpweblog which is licenced
# under the GPL.

function debug($A) {
	if (!empty($A)) {
		echo "<pre><p>---- DEBUG ----\n";
		for (reset($A);$k=key($A);next($A)) {
			printf("<li>%13s [%s]</li>\n",$k,$A[$k]);
		}
		echo "<br>---------------\n</pre>\n";
	}
}

###############################################################################
# Creates a vaild RDF file from the stories
#
# The core of this code has been lifted from phpweblog which is licenced
# under the GPL.

function export_rdf() {
	global $CONF;
	if ($CONF["backend"]>0) {
		$outputfile = $CONF["path_rdf"];
		$rdencoding = "UTF-8";
		$rdtitle = $CONF["site_name"];
		$rdlink	= $CONF["site_url"];
		$rddescr = $CONF["site_slogan"];
		$rdlang	= $CONF["locale"];

		$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}stories WHERE uid > 1 ORDER BY date DESC limit 10");
       		if (!$file = @fopen($outputfile,w)) {
			errorlog("{LANG01[54]} $outputfile",1);
		} else {
			fputs ( $file, "<?xml version=\"1.0\" encoding=\"$rdencoding\"?>\n\n" );
			fputs ( $file, "<!DOCTYPE rss PUBLIC \"-//Netscape Communications//DTD RSS 0.91//EN\"\n \"http://my.netscape.com/publish/formats/rss-0.91.dtd\">\n" );
			fputs ( $file, "<rss version=\"0.91\">\n\n" );
			fputs ( $file, "<channel>\n" );
			fputs ( $file, "<title>$rdtitle</title>\n ");
			fputs ( $file, "<link>$rdlink</link>\n");
			fputs ( $file, "<description>$rddescr</description>\n");
			fputs ( $file, "<language>$rdlang</language>\n\n");

			while ($row=mysql_fetch_array($result)) {
				$title = "title";
				$link = "sid";
				$author = "author";
				fputs ( $file, "<item>\n" );
				$title = "<title>" . htmlspecialchars(stripslashes($row[$title])) . "</title>\n";
				$author = "<author>" . htmlspecialchars(stripslashes($row[$author])) . "</author>\n";
				$link  = "<link>{$CONF["site_url"]}/article.php?story={$row[$link]}</link>\n";
				fputs ( $file,  $title );
				fputs ( $file,  $link );
				fputs ( $file, "</item>\n\n" );
			}
		}
		fputs ( $file, "</channel>\n");
		fputs ( $file, "</rss>\n");
		fclose( $file );
	}
}

###############################################################################
# Error logging routine
# $actionid: (1) write to log (2) write to screen (default) both

function errorlog($logentry,$actionid="") {
	global $CONF,$LANG01;
	if (!empty($logentry)) {
		$timestamp = strftime("%c");
		switch ($actionid) {
			case 1:
				$logfile = $CONF["path_log"] . "/error.log";
     				if (!$file=fopen($logfile,a)) {
					print "{$LANG01[33]} $logfile ($timestamp)<br>\n";
				}
				fputs ( $file, "$timestamp - $logentry \n");
				break;
			case 2:
				startblock("{$LANG01[55]} $timestamp");
				print nl2br($logentry);
				endblock();
				break;
			default:
				$logfile = $CONF["path_log"] . "/error.log";
     				if (!$file=fopen($logfile,a)) {
					print "{$LANG01[33]} $logfile ($timestamp)<br>\n";
				}
				fputs ( $file, "$timestamp - $logentry \n");
				startblock("{$LANG01[34]} - $timestamp");
				print nl2br($logentry);
				endblock();
				break;
		}
	}
}

###############################################################################
# Access logging routine

function accesslog($logentry) {
	global $CONF,$LANG01;
	$timestamp = strftime("%c");
	$logfile = $CONF["path_log"] . "/access.log";
	if (!$file=fopen($logfile,a)) {
		print $LANG01[33] . "$logfile ($timestamp)<br>\n";
	}
	fputs ( $file, "$timestamp - $logentry \n");
}


###############################################################################
# Displays the form for voting

function pollvote($qid) {
	global $HTTP_COOKIE_VARS,$REMOTE_ADDR,$LANG01,$CONF;
	$question = dbquery("select * FROM {$CONF["db_prefix"]}pollquestions WHERE qid='$qid'");
	$Q = mysql_fetch_array($question);
	if (hasaccess($Q["owner_id"],$Q["group_id"],$Q["perm_owner"],$Q["perm_group"],$Q["perm_members"],$Q["perm_anon"]) == 0) {
		return;
	}
	$nquestion = mysql_num_rows($question);
	$id = dbcount("pollvoters","ipaddress",$REMOTE_ADDR,"qid",$qid);
	if (empty($HTTP_COOKIE_VARS[$qid]) && $id == 0) {
		if ($nquestion == 1) {
			$answers	= dbquery("select answer,aid from pollanswers WHERE qid='$qid'");
			$nanswers	= mysql_num_rows($answers);
			if ($nanswers > 0) {
				print "<form action={$CONF["site_url"]}/pollbooth.php name=Vote method=GET>\n";
				startblock($LANG01[5]);
				print "<input type=hidden name=qid value=$qid>\n";
				print "<h2>{$Q["question"]}</h2>\n";
				for ($i=1; $i<=$nanswers; $i++) {
					$A = mysql_fetch_array($answers);
					print "<input type=radio name=aid value=" . $A["aid"] . "> " . $A["answer"] . "<br>\n";
				}
				print "<input type=submit value={$LANG01[56]}>\n";
				print " <a href={$CONF["site_url"]}/pollbooth.php?qid=$qid&aid=-1>{$LANG01[6]}</a><br>";
				print "<span class=storybyline align=right>{$Q["voters"]} {$LANG01[8]}";
				if ($Q["commentcode"] >= 0) print " | <a href={$CONF["site_url"]}/pollbooth.php?qid=$qid&aid=-1#comments>" . dbcount("comments","sid",$qid) . " {$LANG01[3]}</a>";
				print "</span>";
				endblock();
				print "</form>\n";
			}
		}
	} else {
		pollresults ($qid);
	}
}

###############################################################################
# Find the proper poll to display at the proper state to display it in.

function showpoll($size,$qid="") {
	global $HTTP_COOKIE_VARS,$REMOTE_ADDR,$CONF;
	dbquery("DELETE FROM {$CONF["db_prefix"]}pollvoters WHERE date < unix_timestamp() - {$CONF["polladdresstime"]}");
	if (!empty($qid)) {
		$id = dbcount("pollvoters","ipaddress",$REMOTE_ADDR,"qid",$qid);
		if (empty($HTTP_COOKIE_VARS[$qid]) && $id == 0) {
			pollvote($qid);
		} else {
			pollresults($qid,$size);
		}
	} else {
		$result = dbquery("select qid from pollquestions where display = 1");
		$nrows = mysql_num_rows($result);
		if ($nrows > 0) {
			for ($i=1; $i<=$nrows; $i++) {
				$Q = mysql_fetch_array($result);
				$qid = $Q["qid"];
				$id = dbcount("pollvoters","ipaddress",$REMOTE_ADDR,"qid",$qid);
				if (empty($HTTP_COOKIE_VARS[$qid]) && $id == 0) {
					pollvote($qid);
				} else {
					pollresults($qid,$size);
				}
			}
		}
	}
}

###############################################################################
# Displays the poll results for $qid.  $width contols the width if the graphing

function pollresults($qid,$scale=400,$order="",$mode="") {
	global $LANG01,$CONF;
	$question = dbquery("select * from pollquestions WHERE qid='$qid'");
	$Q = mysql_fetch_array($question);
	if (hasaccess($Q["owner_id"],$Q["group_id"],$Q["perm_owner"],$Q["perm_group"],$Q["perm_members"],$Q["perm_anon"]) == 0) {
		return;
	}
	$nquestion = mysql_num_rows($question);
	if ($nquestion == 1) {
		$answers = dbquery("select * from pollanswers WHERE qid='$qid' ORDER BY votes DESC");
		$nanswers = mysql_num_rows($answers);
		if ($nanswers > 0) {
			startblock($LANG01[7]);
			print "<h2>{$Q["question"]}</h2>";
			print "<table border=0 tcellpadding=3 cellspacing=0 align=center>\n";
			for ($i=1; $i<=$nanswers; $i++) {
				$A = mysql_fetch_array($answers);
				if ($Q["voters"] == 0) {
					$percent = 0;
				} else {
					$percent = $A["votes"] / $Q["voters"];
				}
				print "<tr>\n";
				print "<td align=right><b>{$A["answer"]}</b></td>\n";
				print "<td>";
				if ($scale < 120) {
					printf("%.2f", $percent * 100);
					print "%";
				} else {
					$width = $percent * $scale;
					print "<img src={$CONF["site_url"]}/images/bar.gif width=$width height=10 align=bottom> {$A["votes"]} ";
					printf("(%.2f)", $percent * 100);
					print "%";
				}
				print "</tr>\n";
			}
			print "</table>\n<span class=storybyline align=right><br>{$Q["voters"]} {$LANG01[8]}\n";
			if ($Q["commentcode"] >= 0) {
				print " | <a href={$CONF["site_url"]}/pollbooth.php?qid=$qid&aid=-1#comments>" . dbcount("comments","sid",$qid) . " {$LANG01[3]}</a>";
			}
			print "</span>\n";
			endblock();
			if ($scale > 399 && $Q["commentcode"] >= 0) {
				usercomments($qid,$Q["question"],'poll',$order,$mode);
			}
		}
	}
}

###############################################################################
# Creates the list of topics and the number of stories in each topic

function showtopics($topic="") {
	global $CONF, $USER, $LANG01, $PHP_SELF;
	if ($CONF["sortmethod"] == 'alpha')
		$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}topics ORDER BY tid ASC");
	else
		$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}topics ORDER BY sortnum");

	$nrows = mysql_num_rows($result);
	#Give a link to the hompage here since a lot of people use this
	#for navigating the site
	if (($PHP_SELF <> "/index.php") OR !empty($topic)) {
                print "<a href={$CONF["site_url"]}/index.php><b>{$LANG01[90]}</b></a><br>";
        } else {
                print "{$LANG01[90]}<br>";
        }

	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
		if (hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]) > 0) {
			if ($A["tid"]==$topic) {
				print $A["topic"];
				if ($CONF["showstorycount"] + $CONF["showsubmissioncount"] > 0) {
					print " (";
					if ($CONF["showstorycount"]) {
						print dbcount("stories","tid",$A["tid"]);
                			}

             				if ($CONF["showstorycount"]) {
						if ($CONF["showstorycount"]) print "/";
						print dbcount("storysubmission","tid",$A["tid"]);
					}
					print ")";
				}
				print "<br>\n";
			} else {
				print "<a href={$CONF["site_url"]}/index.php?topic={$A["tid"]}><b>{$A["topic"]}</b></a> ";
				if ($CONF["showstorycount"] + $CONF["showsubmissioncount"] > 0) {
					print "(";
					if ($CONF["showstorycount"])
						print dbcount("stories","tid",$A["tid"]);
					if ($CONF["showsubmissioncount"]) {
						if ($CONF["showstorycount"])
							print "/";
						print dbcount("storysubmission","tid",$A["tid"]);
					}
					print ")";
				}
				print "<br>\n";
			}
		} #end
	}
}

###############################################################################
# This is the admin menu

function usermenu() {
	global $USER,$CONF,$LANG01;

	if ($USER["uid"] > 1) {
		startblock($LANG01[47]);
		if ($CONF["personalcalendars"] == 1) {
			print "<a href=\"{$CONF["site_url"]}/calendar.php?mode=personal\">{$LANG01[66]}</a><br>\n";
		}
		ShowPluginUserOptions();
		print "<a href=\"{$CONF["site_url"]}/usersettings.php?mode=edit\">{$LANG01[48]}</a><br>\n";
		print "<a href=\"{$CONF["site_url"]}/usersettings.php?mode=preferences\">{$LANG01[49]}</a><br>\n";
		print "<a href=\"{$CONF["site_url"]}/usersettings.php?mode=comments\">{$LANG01[63]}</a><br>\n";
		print "<a href=\"{$CONF["site_url"]}/users.php?mode=logout\">{$LANG01[19]}</a>\n";
		endblock();
	} else {
		startblock($LANG01[47]);
		print "<form action=\"{$CONF["site_url"]}/users.php\" method=\"post\">\n";
		print "<b>{$LANG01[21]}:</b><br>\n<input type=\"text\" size=\"10\" name=\"loginname\" value=\"\"><br>\n";
		print "<b>{$LANG01[57]}:</b><br>\n<input type=\"password\" size=\"10\" name=\"passwd\"><br>\n";
		print "<input type=\"submit\" value=\"{$LANG01[58]}\">\n";
		print "</form>{$LANG01[59]}\n";
		endblock();
	}

}

function adminmenu() {
	global $USER,$CONF,$LANG01, $VERSION;

	if (ismoderator() OR hasrights('story.edit,block.edit,topic.edit,link.edit,event.edit,poll.edit,user.edit,plugin.edit,user.mail','OR')) {
		startblock($LANG01[9]);

		if (ismoderator()) {
			$num = dbcount("storysubmission","uid","0") + dbcount("eventsubmission","eid","0") + dbcount("linksubmission","lid","0");
			//now handle submissions for plugins
			$num = $num + GetPluginSubmissionCounts();
			print "<a href=\"{$CONF["site_url"]}/admin/moderation.php\">{$LANG01[10]}</a> ($num)<br>\n";
		}
		if (hasrights('story.edit')) {
			print "<a href=\"{$CONF["site_url"]}/admin/story.php\">{$LANG01[11]}</a> (" . dbcount("stories") . ")<br>\n";
		}
		if (hasrights('block.edit')) {
			print "<a href=\"{$CONF["site_url"]}/admin/block.php\">{$LANG01[12]}</a> (" . dbcount("blocks") . ")<br>\n";
		}
		if (hasrights('topic.edit')) {
			print "<a href=\"{$CONF["site_url"]}/admin/topic.php\">{$LANG01[13]}</a> (" . dbcount("topics") . ")<br>\n";
		}
		if (hasrights('link.edit')) {
			print "<a href=\"{$CONF["site_url"]}/admin/link.php\">{$LANG01[14]}</a> (" . dbcount("links") . ")<br>\n";
		}
		if (hasrights('event.edit')) {
			print "<a href=\"{$CONF["site_url"]}/admin/event.php\">{$LANG01[15]}</a> (" . dbcount("events") . ")<br>\n";
		}
		if (hasrights('poll.edit')) {
			print "<a href=\"{$CONF["site_url"]}/admin/poll.php\">{$LANG01[16]}</a> (" . dbcount("pollquestions") . ")<br>\n";
		}
		if (hasrights('user.edit')) {
			print "<a href=\"{$CONF["site_url"]}/admin/user.php\">{$LANG01[17]}</a> (" . (dbcount("users") - 1) . ")<br>\n";
		}
		if (hasrights('group.edit')) {
			print "<a href=\"{$CONF["site_url"]}/admin/group.php\">{$LANG01[96]}</a> (" . dbcount("groups") . ")<br>\n";
		}
		if (hasrights('plugin.edit')) {
			print "<a href=\"{$CONF["site_url"]}/admin/plugins.php\">{$LANG01[77]}</a> (" . dbcount("plugins") . ")<br>\n";
		}

		// This function wil show the admin options for all installed plugins (if any)

		ShowPluginAdminOptions();

		if (hasrights('user.mail')) {
			print "<a href=\"{$CONF["site_url"]}/admin/mail.php\">Mail</a><br>\n";
		}

		print "<a href=\"http://geeklog.sourceforge.net/versionchecker.php?version=" . $VERSION . "\" target=\"_new\">GL Version Test</a><br>\n";
		endblock();
	}

}

###############################################################################
# This function passes a meta tag to refresh after a form is sent.  This is
# necessary because for some reason Netscape and PHP4 don't play well with
# the header() function 100% of the time.

function refresh($url) {
	print "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
}

###############################################################################
# This function displays the comment control bar

function commentbar($sid,$title,$type,$order,$mode) {
	global $LANG01,$USER,$CONF;
	$nrows = dbcount("comments","sid",$sid);
	print "<a name=comments></a>";
	# Build comment control bar
	print "<table cellspacing=0 cellpadding=0 border=0 width=\"100%\">\n";
	print "<tr><td align=center class=commentbar1> " . stripslashes($title) . " | $nrows {$LANG01[3]} | ";
	if (!empty($USER["username"])) {
		print "{$USER["username"]} <a href={$CONF["site_url"]}/users.php?mode=logout class=commentbar1>{$LANG01[35]}</a>";
	} else {
		print "<a href={$CONF["site_url"]}/users.php?mode=new class=commentbar1>{$LANG01[61]}</a>";
	}
	print "</td></tr>\n";
	print "<tr><td align=center class=commentbar2>";
	if ($type == 1) {
		print "<form action={$CONF["site_url"]}/pollbooth.php method=POST>\n<input type=hidden name=scale value=400>\n";
		print "<input type=hidden name=qid value=$sid>\n<input type=hidden name=aid value=-1>\n";
	} else {
		print "<form action={$CONF["site_url"]}/article.php method=POST>\n<input type=hidden name=story value=$sid>\n";
	}
	# Order
	print "<select name=order>";
	optionlist("sortcodes","code,name",$order);
	print "</select> ";
	# Mode
	print "<select name=mode>";
	optionlist("commentmodes","mode,name",$mode);
	print "</select> <input type=submit value=\"{$LANG01[39]}\">";
	print " <input type=hidden name=type value=$type><input type=hidden name=pid value=0>";
	print "<input type=submit name=reply value=\"{$LANG01[25]}\"></td></form></tr>\n";
	print "<tr><td align=center class=commentbar3>{$LANG01[26]}</td></tr>\n";
	print "</table>\n";
}

###############################################################################
# This function displays the comments in a high level format.

function usercomments($sid,$title,$type="article",$order="",$mode="",$pid=0) {
	global $CONF,$LANG01,$USER;
	if (!empty($USER["uid"]) && empty($order) && empty($mode)) {
		$result = dbquery("SELECT commentorder,commentmode,commentlimit FROM {$CONF["db_prefix"]}usercomment WHERE uid = '{$USER["uid"]}'");
		$U = mysql_fetch_array($result);
		$order = $U[0];
		$mode = $U[1];
		$limit = $U[2];
	}
	if (empty($order)) $order = "ASC";
	if (empty($mode)) $mode = "threaded";
	if (empty($limit)) $limit = 100;
	switch ($mode) {
		case "nocomments":
			commentbar($sid,$title,$type,$order,$mode);
			print "<p>";
			break;
		case "nested":
			$result = dbquery("SELECT *,unix_timestamp(date) AS nice_date FROM {$CONF["db_prefix"]}comments WHERE sid = '$sid' AND pid = 0 ORDER By date $order LIMIT $limit");
			$nrows = mysql_num_rows($result);
			commentbar($sid,$title,$type,$order,$mode);
			if ($nrows>0) {
				startcomment();
				for ($i=0;$i<$nrows;$i++) {
					$A	= mysql_fetch_array($result);
					comment($A,0,$type,0,$mode);
					commentchildren($sid,$A["cid"],$order,$mode,$type);
				}
				endblock();
			} else {
				startcomment();
				print "<tr><td class=commenttitle align=center>{$LANG01[29]}</td></tr>";
				endblock();
			}
			break;
		case "flat":
			$result = dbquery("SELECT *,unix_timestamp(date) AS nice_date FROM {$CONF["db_prefix"]}comments WHERE sid = '$sid' ORDER By date $order LIMIT $limit");
			$nrows = mysql_num_rows($result);
			commentbar($sid,$title,$type,$order,$mode);
			if ($nrows>0) {
				startcomment();
				for ($i=0;$i<$nrows;$i++) {
					$A	= mysql_fetch_array($result);
					comment($A,0,$type,0,$mode);
				}
				endblock();
			} else {
				startcomment();
				print "<tr><td class=commenttitle align=center>{$LANG01[29]}</td></tr>";
				endblock();
			}
			break;
		case "threaded":
			$result = dbquery("SELECT *,unix_timestamp(date) AS nice_date FROM {$CONF["db_prefix"]}comments WHERE sid = '$sid' AND pid = $pid ORDER By date $order LIMIT $limit");
			$nrows = mysql_num_rows($result);
			commentbar($sid,$title,$type,$order,$mode);
			if ($nrows>0) {
				startcomment();
				for ($i=0;$i<$nrows;$i++) {
					$A	= mysql_fetch_array($result);
					comment($A,0,$type,0,$mode);
					print "<tr><td>";
					commentchildren($sid,$A["cid"],$order,$mode,$type);
					print "</td></tr>";
				}
				endblock();
			} else {
				startcomment();
				print "<tr><td class=commenttitle align=center>{$LANG01[29]}</td></tr>";
				endblock();
			}
			break;
	}
}

###############################################################################
# This function finds and prints the children of cid

function commentchildren($sid,$pid,$order,$mode,$type,$level=0) {
	$result = dbquery("SELECT *,unix_timestamp(date) AS nice_date FROM {$CONF["db_prefix"]}comments WHERE sid = '$sid' AND pid = $pid ORDER By date $order");
	$nrows = mysql_num_rows($result);
	if ($nrows>0) {
		if ($mode == "threaded") { print "<UL>"; }
		for ($i=0;$i<$nrows;$i++) {
			$A = mysql_fetch_array($result);
			comment($A,0,$type,$level+1,$mode);
			commentchildren($sid,$A["cid"],$order,$mode,$type,$level+1);
		}
		if ($mode == "threaded") { print "</UL>"; }
	} else {

	}
}

###############################################################################
# This function print $A in comment format

function comment($A,$mode=0,$type,$level=0,$mode="flat") {
	global $CONF,$LANG01,$USER,$order;
	$level = $level * 25;

	# if no date, make it now!
	if (empty($A["nice_date"])) { $A["nice_date"] = time(); }

	if ($mode == "threaded" && $level > 0) {
		print "<LI><B><a href={$CONF["site_url"]}/comment.php?mode=display&sid={$A["sid"]}&title=" . urlencode($A["title"]) . "&type=$type&order=$order&pid={$A["pid"]}>{$A["title"]}</a></B> - {$LANG01[42]} ";
		if ($A["uid"] == 1) {
			print $LANG01[24];
		} else {
			print "<a href={$CONF["site_url"]}/users.php?mode=profile&uid={$A["uid"]}>" . getitem("users","username","uid = {$A["uid"]}") . "</a>";
		}
		$A["nice_date"] = strftime($CONF["date"],$A["nice_date"]);
		print " {$LANG01[36]} {$A["nice_date"]}\n";
	} else {
		if ($level > 0) {
			print "<tr><td><table border=0 cellpadding=0 cellspacing=0 width=\"100%\">\n";
			print "<tr><td rowspan=3 width=$level><img src={$CONF["site_url"]}/images/speck.gif width=$level height=100%></td>\n";
		} else {
			print "<tr>";
		}
		print "<td class=commenttitle>" . stripslashes($A["title"]) . "</td></tr>\n";
		print "<tr><td>{$LANG01[42]} ";
		if ($A["uid"] == 1) {
			print $LANG01[24];
		} else {
			print "<a href={$CONF["site_url"]}/users.php?mode=profile&uid={$A["uid"]}>" . getitem("users","username","uid = {$A["uid"]}") . "</a>";
		}
		$A["nice_date"] = strftime($CONF["date"],$A["nice_date"]);
		print " on {$A["nice_date"]}</td></tr>\n";
		print "<tr><td valign=top>";
		echo nl2br(stripslashes($A["comment"]));
		if ($mode == 0) {
			print "<p>[ <a href={$CONF["site_url"]}/comment.php?sid={$A["sid"]}&pid={$A["cid"]}&title=" . rawurlencode($A["title"]) . "&type=$type>{$LANG01[43]}</a> ";

			# Until I find a better way to parent, we're stuck with this...

			if ($mode == "threaded" && $A["pid"] != 0) {
				$result = dbquery("SELECT title,pid from comments where cid = {$A["pid"]}");
				$P = mysql_fetch_array($result);
				print "| <a href={$CONF["site_url"]}/comment.php?mode=display&sid={$A["sid"]}&title=" . rawurlencode($P["title"]) . "&type=$type&order=$order&pid={$P["pid"]}>{$LANG01[44]}</a> ";
			}

			if (hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]) == 3) {
				print "| <a href={$CONF["site_url"]}/comment.php?mode={$LANG01[28]}&cid={$A["cid"]}&sid={$A["sid"]}&type=$type>{$LANG01[28]}</a> ";
			}
			print "]<p>";
		}
		echo "</td></tr>\n";
		if ($level > 0) {
			print "</table></td></tr>\n";
		}
	}
}

###############################################################################
# This function checks for words in the censor list.
#
# The core of this code has been lifted from thatphpware which is licenced
# under the GPL.

function checkwords($Message) {
	global $CONF;
	$EditedMessage = $Message;
	if ($CONF["censormode"] != 0) {
		if (is_array($CONF["censorlist"])) {
			$Replacement = $CONF["censorreplace"];
				if ($CONF["censormode"] == 1) { # Exact match
				$RegExPrefix   = '([^[:alpha:]]|^)';
				$RegExSuffix   = '([^[:alpha:]]|$)';
			} elseif ($CONF["censormode"] == 2) {    # Word beginning
				$RegExPrefix   = '([^[:alpha:]]|^)';
				$RegExSuffix   = '[[:alpha:]]*([^[:alpha:]]|$)';
			} elseif ($CONF["censormode"] == 3) {    # Word fragment
				$RegExPrefix   = '([^[:alpha:]]*)[[:alpha:]]*';
				$RegExSuffix   = '[[:alpha:]]*([^[:alpha:]]*)';
			}
			for ($i = 0; $i < count($CONF["censorlist"]) && $RegExPrefix != ''; $i++) {
				$EditedMessage = eregi_replace($RegExPrefix.$CONF["censorlist"][$i].$RegExSuffix,"\\1$Replacement\\2",$EditedMessage);
			}
		}
	}
	return ($EditedMessage);
}

###############################################################################
# This function checks html tags.
#
# The core of this code has been lifted from phpslash which is licenced under
# the GPL.
function checkhtml($str) {
        global $CONF;
	$str = stripslashes($str);

	// Get rid of any newline characters
	$str = preg_replace("/\n/","",$str);
        $str = strip_tags($str,$CONF["allowablehtml"]);
        return $str;
}

###############################################################################
# This function creates a 17 digit sid for stories based on the 14 digit date
# and a 3 digit random number that was seeded with the number of microseconds
# (.000001th of a second) since the last full second.

function makesid() {
	$sid = date("YmdHis");
	srand((double)microtime()*1000000);
	$sid .= rand(0,999);
	return $sid;
}

###############################################################################
# This function checks to see if an email address is in the correct from

function isemail($email) {
	if (eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*.[a-z]{2,3}$", $email, $check)) {
		return TRUE;
	} else {
		return FALSE;
	}
}

###############################################################################
# Creates the olderstuff block for display.

function olderstuff() {
	global $CONF,$LANG01;
	if ($CONF["olderstuff"] == 1) {
		$result = dbquery("SELECT sid,title,comments,unix_timestamp(date) AS day FROM {$CONF["db_prefix"]}stories ORDER BY date desc LIMIT {$CONF["limitnews"]}, {$CONF["limitnews"]}");
		$nrows = mysql_num_rows($result);
		if ($nrows>0) {
			$day = "noday";
			$string = "";
			for ($i=0;$i<$nrows;$i++) {
				$A = mysql_fetch_array($result);
                                $daycheck = strftime("%A",$A["day"]);
                                if ($day != $daycheck) {
                                        $day2 = strftime("%m/%d",$A["day"]);
                                        $day = $daycheck;
                                        $string .= "<br><b>$day</b> <small>$day2</small><br>";
                                }
				$string .= "<li><a href={$CONF["site_url"]}/article.php?story={$A["sid"]}>{$A["title"]}</a> ({$A["comments"]})\n";
			}
		$string = addslashes($string);
		dbdelete("blocks","title","{$LANG01[30]}");
		dbsave("blocks","title,blockorder,content","'{$LANG01[30]}','{$CONF["olderstufforder"]}','$string'");
		}
	}
}

###############################################################################
# Shows blocks based on order and topic

function showblock($side,$topic="") {
	global $CONF,$USER,$LANG21;

	#Get user preferences on blocks
	if (!empty($USER["uid"])) {
		$result = dbquery("SELECT boxes,noboxes FROM {$CONF["db_prefix"]}userindex WHERE uid = '{$USER["uid"]}'");
		$U = mysql_fetch_array($result);
	}

	if ($side == "left") {
		$sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) as date FROM {$CONF["db_prefix"]}blocks WHERE onleft = 1";
	} else {
		$sql = "SELECT *,UNIX_TIMESTAMP(rdfupdated) as date FROM {$CONF["db_prefix"]}blocks WHERE onleft = 0";
	}

	if (!empty($topic)) {
		$sql .= " AND (tid = '$topic' OR (tid = 'all' AND type <> 'layout'))";
	} else {
		$sql .= " AND (tid = 'homeonly' OR (tid = 'all' AND type != 'layout'))";
	}

	if (!empty($U["boxes"])) {
		$BOXES = explode(" ",$U["boxes"]);
		$sql .= " AND (";
		for ($i=0; $i<sizeof($BOXES); $i++) {
			$sql .= "bid = '$BOXES[$i]' OR ";
		}
		$result = dbquery("SELECT bid FROM {$CONF["db_prefix"]}blocks WHERE title = 'User Block' OR title = 'Section Block'");
		$nrows = mysql_num_rows($result);
		for ($i=1;$i<=$nrows;$i++) {
			$A = mysql_fetch_array($result);
			$sql .= "bid = '" . $A["bid"] . "' OR ";
		}
		$sql .= "bid = '-1')";
	} else {
		$sql .= " AND blockorder < 10";
	}
	$sql .= " ORDER BY blockorder,title asc";
	$result	= dbquery($sql);
	$nrows = mysql_num_rows($result);	
	for ($i=1;$i<=$nrows;$i++) {
		$A = mysql_fetch_array($result);
		if ($A["type"] == "portal") {
			rdfcheck($A["bid"],$A["rdfurl"],$A["date"]);
		}
		if ($A["type"] == "gldefault") {
			switch ($A["title"]) {
				case "User Block":
					usermenu();
					break;
				case "Admin Block":
					adminmenu();
					break;
				case "Section Block":
					startblock("Sections");
					showtopics($topic);
					endblock();
					break;
				case "Events Block":
					if (!$U["noboxes"] && $CONF["showupcomingevents"]) printupcomingevents();
					break;
				case "Poll Block":
                        		showpoll(60);
					break;
				case "Whats New Block":
					if (!$U["noboxes"]) whatsnewblock();
					break;
			}
		}
		if (hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]) > 0) {
			if ($A["type"] == "phpblock" && !$U["noboxes"]) {
                        	$function = $A["phpblockfn"];
                        	startblock($A["title"]);
                        	if (function_exists($function)) {
                                	#great, call it
                                	$function();
                        	} else {
                                	#show friendly error message
                                	print $LANG21[31];
                        	}
                       		endblock();
                	}
			if (!empty($A["content"]) && !$U["noboxes"]) {
				startblock($A["title"]);
				print nl2br(stripslashes($A["content"])) . "<br>\n";
				endblock();
			}
		}
	}
}

###############################################################################
# Checks to see if it's time to import and RDF/RSS block again

function rdfcheck($bid,$rdfurl,$date) {

	$nextupdate = $date + 3600;
	if ($nextupdate < time()) {
		rdfimport($bid,$rdfurl);
	}
}

###############################################################################
# Imports the RDF/RSS blocks

function rdfimport($bid,$rdfurl) {
	$update = date("Y-m-d H:i:s");
	$result = dbchange("blocks","rdfupdated","'$update'","bid","$bid");
	clearstatcache();
	if ($fp = fopen($rdfurl, "r")) {
		$rdffile = file($rdfurl);
		fclose($fp);
		$num = count($rdffile);
		if ($num > 1) {
			for ($i=0; $i < $num; $i++) {
				if ($rdffile[$i] == '') {
					continue;
				}
				if (ereg("<([^<>]*)>([^<>]*)?",$rdffile[$i],$regs)) {
					$item=$regs[1];
					$data=$regs[2];
					if ($item=='channel' || $item=='image' || $item=='item') {
						$type=$item;
						if ($item=='item') {
							$di++;
						}
					} else if (($item=='title') && ($type=='item')) {
						$channel_data_title[$di]=$data;
					} else if (($item=='link') && ($type=='item')) {
							$channel_data_link[$di]=$data;
					}
				}
			}
			$blockcontent = "";
			for ($i=1; $i <= $di; $i++) {
				$blockcontent .= "<LI><a href=" . addslashes($channel_data_link[$i]) . ">" . addslashes($channel_data_title[$i]) . "</a>";
			}
			$result = dbchange("blocks","content","'$blockcontent'","bid","$bid");
		}
	} else {
		errorlog("can not reach $rdfurl",1);
		$result = dbchange("blocks","content","GeekLog can not reach the suppiled RDF file at $update.  Please double check the URL provided.  Make sure your url is correctly entered and it begins with http://. GeekLog will try in one hour to fetch the file again.","bid","$bid");
	}
}

###############################################################################
# Displays which HTML tags are allowed
function allowedhtml() {
        global $CONF,$LANG01;
        $tmp = "<span class=warningsmall>{$LANG01[31]} " . htmlspecialchars($CONF["allowablehtml"]);
        $tmp .= "</span><br><br>\n";
	print $tmp;
}

###############################################################################
# Fetches a password for the given user

function getpassword($loginname) {
	global $LANG01;
	$result = dbquery("SELECT passwd FROM {$CONF["db_prefix"]}users WHERE username='$loginname'");
	$tmp = mysql_errno();
	$nrows = mysql_num_rows($result);
	if (($tmp == 0) && ($nrows == 1)) {
		$U = mysql_fetch_array($result);
		return($U["passwd"]);
	} else {
		$tmp = $LANG01[32] . "$loginname!";
		errorlog($tmp,1);
	}
}

function hit() {
	dbchange("vars","value","value + 1","name","totalhits");
}

function PrintUpcomingEvents() {
  global $LANG01,$CONF;

  startblock($LANG01[78]);

  $eventSql = "select eid, title, url, datestart, dateend from events
  where dateend >= NOW() AND (TO_DAYS(datestart) - TO_DAYS(NOW()) < 14)
  order by datestart, dateend";

  $allEvents = dbquery($eventSql);
  $numRows   = mysql_num_rows($allEvents);

  $numDays   = 0;         // Without limits, I'll force them.
  $theRow    = 1;         // Start with today!
  $oldDate1  = "no_day";  // Invalid Date!
  $oldDate2  = "last_d";  // Invalid Date!

  if ($numRows == 0) {
        #There aren't any upcoming events, show a nice
        #message
        print $LANG01[89];
  }

  while ($theRow <= $numRows AND $numDays < 14) {

    // Retreive the next event, and format the start date.
    $theEvent   = mysql_fetch_array($allEvents);
    // Start Date strings...
    $startDate  = $theEvent["datestart"];
    $theTime1   = strtotime($startDate);
    $dayName1   = strftime("%A", $theTime1);
    $abbrDate1  = strftime("%m/%d", $theTime1);

    // End Date strings...
    $endDate    = $theEvent["dateend"];
    $theTime2   = strtotime($endDate);
    $dayName2   = strftime("%A", $theTime2);
    $abbrDate2  = strftime("%m/%d", $theTime2);

    // If either of the dates [start/end] change, then display
    // a new header.

    if ($oldDate1 != $abbrDate1 OR $oldDate2 != $abbrDate2) {
      $oldDate1 = $abbrDate1;
      $oldDate2 = $abbrDate2;
      $numDays ++;
      if ($numDays < 14) {
        print "<br><b>$dayName1</b>&nbsp;<small>$abbrDate1</small>";

        // If different start and end Dates, then display end date:
        if ($abbrDate1 != $abbrDate2) {
          print " - <br><b>$dayName2</b>&nbsp;<small>$abbrDate2</small>";
        }
      }
    }

    // Now display this event record.
    if ($numDays < 14) {
      // Display the url now!
      print "<li><a
href={$CONF["site_url"]}/calendar_event.php?eid={$theEvent["eid"]}>{$theEvent
["title"]}</a><br></li>";
     }
     $theRow ++ ;  // Increment to next event in table!
  } // End of while loop!

print "<br>";

  endblock();
} // End of Function.

###############################################################################
# emails stories for topics the user specifies
function emailusertopics() {
        global $LANG08,$CONF;

        // Get users who want stories emailed to them
        $users = dbquery("SELECT username,email, etids FROM {$CONF["db_prefix"]}users, {$CONF["db_prefix"]}userindex WHERE userindex.uid = users.uid AND etids IS NOT NULL");
        $nrows = mysql_num_rows($users);
        $file = @fopen("testemail.txt",w);
        fputs($file, "got $nrows users who want stories emailed to them\n");
        // For each user, pull the stories they want and email it to them
        for ($x=0; $x<$nrows; $x++) {
                fputs($file, "inside for loop\n");
                $U = mysql_fetch_array($users);
                $cur_day = strftime("%D",time());
		$result = dbquery("SELECT value AS lastrun FROM {$CONF["db_prefix"]}vars WHERE name = 'lastemailedstories'");
		$L = mysql_fetch_array($result);
                $storysql = "SELECT sid, date AS day, title, introtext, bodytext from stories where date >= '" . $L["lastrun"] . "' AND (";
                //$storysql = "SELECT sid, date AS day, title, introtext, bodytext from stories where DATE_FORMAT(date,'%Y-%m-%d') = '" . strftime('%Y-%m-%d',time()) . "' AND (";
                $ETIDS = explode(" ",$U["etids"]);
                fputs($file, "got $ETIDS[$x] for a category\n");
                for ($i=0; $i<sizeof($ETIDS); $i++) {
                        if ($i == (sizeof($ETIDS) - 1))
                                $storysql .= "tid = '$ETIDS[$i]')";
                        else
                                $storysql .= "tid = '$ETIDS[$i]' OR ";
                }
                fputs($file, $storysql . "\n");
                $stories = dbquery($storysql);
                $nsrows = mysql_num_rows($stories);
                fputs($file, "got $nsrows stories that need to be emailed to user: {$U["username"]}\n");

                // If no new stories where pulled then exit out
                if ($nsrows == 0) return;

                // Loop through stories building the requested email message
                $mailtext = "{$LANG08[27]}\n";
                for ($y=0; $y<$nsrows; $y++) {
                        $S = mysql_fetch_array($stories);
                        fputs($file, "introtext = {$S["introtext"]}\n, bodytext = {$S["bodytext"]}\n");
                        $mailtext .= "\n------------------------------\n\n";
			$mailtext .= "Title: {$S["title"]}\n";
                        $mailtext .= "Date: " . strftime($CONF["date"],strtotime($S["day"])) . "\n\n";
                        $mailtext .= nl2br(stripslashes(strip_tags($S["introtext"]))) . "\n\n";
                        $mailtext .= "Read the full article at {$CONF["site_url"]}/article.php?story={$S["sid"]}\n";
                }
                        $mailtext .= "\n------------------------------\n";
                        $mailtext .= "\nEnd of Message\n";
                        $mailtext .= "\n------------------------------\n";
                        $toemail = $U["email"];
                        $mailto = "{$U["username"]} <{$toemail}>";
                        $mailfrom = "FROM: Iowa Outdoors <newsletter@iowaoutdoors.org>";                        $subject = strip_tags(stripslashes("Iowa Outdoors Daily Newsletter for " . strftime('%m/%d/%Y',time())));
                        fputs($file,"to: $toemail, from: $mailfrom, sub: $subject\ntext: $mailtext");
                        @mail($toemail,$subject,$mailtext,$mailfrom);
        }
	$tmpdate = date("Y-m-d H:i:s",time());
	dbquery("update vars set value = '$tmpdate'");
        fclose($file);
}


function whatsnewblock() {
	global $CONF,$LANG01;

	if ($CONF["whatsnewbox"] == 0) return;

	#find the newest stories; change 86400 to your desired interval in seconds
	$sql = "SELECT *,UNIX_TIMESTAMP(date) AS day FROM {$CONF["db_prefix"]}stories WHERE ";
	$now = time();
	$desired = $now - $CONF["newstoriesinterval"];

	$sql .= "UNIX_TIMESTAMP(date) > {$desired}";// ORDER BY day DESC"
	$sql .= " AND draft_flag = 0";
	$result = dbquery($sql);
	$nrows = mysql_num_rows($result);

	if ($nrows > 0) {
		$hours = (($CONF["newstoriesinterval"] / 60) / 60);
		if ($nrows == 1) {
			startblock("<b>{$LANG01[79]}: {$nrows} {$LANG01[81]} {$hours} {$LANG01[82]}</b>");
 		} else {
			startblock("<b>{$LANG01[79]}: {$nrows} {$LANG01[80]} {$hours} {$LANG01[82]}</b>");
		}
	} else {
		startblock("<div align=left><b>{$LANG01[79]}</b></div>");
	}

	#now go get the newest comments; change 172800 to desired interval in seconds
	print "<b>{$LANG01[83]}</b> <small>{$LANG01[85]}</small><br>";
	$sql    = "SELECT distinct *, count(*) as dups, comments.cid,comments.sid,stories.sid,stories.title,max(UNIX_TIMESTAMP(comments.date)) as day FROM {$CONF["db_prefix"]}comments,stories where ";
	$now = time();
	$desired = $now - $CONF["newcommentsinterval"];
	$sql .= "UNIX_TIMESTAMP(comments.date) > {$desired} and (stories.sid=comments.sid) GROUP BY comments.sid ORDER BY day DESC";
	$result = dbquery($sql);
	$nrows = mysql_num_rows($result);
	#cap max displayed at 15
	if ($nrows > 15) $nrows = 15;
	if ($nrows > 0) {
		for ($x=1;$x<=$nrows;$x++) {
			$A      = mysql_fetch_array($result);
			$robtime = strftime("%D %T",$A["day"]);
			$itemlen = strlen($A["title"]);
			#trim the length if over 26 characters
			if ($itemlen > 26) {
				print "<font class=storyclose>&#149; <a href={$CONF["site_url"]}/article.php?story={$A["sid"]}#comments>" . substr($A["title"],0,26) . "... ";
				if ($A["dups"] > 1) print "[+{$A["dups"]}]";
				print "</a></font><br>\n";
			} else {
				print "<font class=storyclose>&#149; <a href={$CONF["site_url"]}/article.php?story={$A["sid"]}#comments>{$A["title"]} ";
				if ($A["dups"] > 1) print "[+{$A["dups"]}]";
				print "</a></font><br>\n";
			}
		}
	} else {
		print "<font class=storyclose>{$LANG01[86]}</font>";
	}

	print "<br>";

	#get newest links; change 1209600 to desired interval in seconds
	print "<b>{$LANG01[84]}</b> <small>{$LANG01[87]}</small><br> ";
	$sql    = "SELECT * FROM {$CONF["db_prefix"]}links  ORDER BY lid DESC";
	$foundone = 0;
	$now = time();
	$desired = $now - $CONF["newlinksinterval"];
	$result = dbquery($sql);
	$nrows = mysql_num_rows($result);
	#cap max displayed at 10
	if ($nrows > 5) $nrows = 10;
	#print "query: {$sql} <br> nrows: {$nrows} | time is: " . strftime("%D %T",time()) . "<br>";
	if ($nrows > 0) {
		for ($x=1;$x<=$nrows;$x++) {
			$A      = mysql_fetch_array($result);
			#need to reparse the date from the link id
			$myyear  = substr($A["lid"],0,4);
			$mymonth = substr($A["lid"],4,2);
			$myday   = substr($A["lid"],6,2);
			$myhour  = substr($A["lid"],8,2);
			$mymin   = substr($A["lid"],10,2);
			$mysec   = substr($A["lid"],12,2);
			$newtime = "{$mymonth}/{$myday}/{$myyear} {$myhour}:{$mymin}:{$mysec}";
			$convtime = strtotime($newtime);
			if ($convtime > $desired) {
				$itemlen = strlen($A["title"]);
				#trim the length if over 26 characters, and strip 'http://'
				$foundone = 1;
				if ($itemlen > 26) {
					print "<font class=storyclose>&#149;<a href={$A["url"]} target=_blank>" . substr($A["title"],0,26) . "...</a></font><br>";
				} else {
					print "<font class=storyclose>&#149;<a href={$A["url"]} target=_blank>" . substr($A["title"],0,$itemlen) . "</a></font><br>";
				}
			}
		}
		if ($foundone == 0) {
			print "<font class=storyclose>{$LANG01[88]}</font><br>";
		}
	}

	print "<br>";
/*
	#get newest events; change 2592000 to desired interval in seconds
	print "<b>EVENTS</b> <small>last 30 days</small><br> ";
	$sql    = "SELECT * FROM {$CONF["db_prefix"]}events  ORDER BY eid DESC";
	$foundone = 0;
	$now = time();
	$desired = $now - 2592000;
	$result = dbquery($sql);
	$nrows = mysql_num_rows($result);
	#cap max displayed at 5
	if ($nrows > 5) $nrows = 5;
	if ($nrows > 0) {
		for ($x=1;$x<=$nrows;$x++) {
			$A       = mysql_fetch_array($result);
			#need to reparse the date from the event id
			$myyear  = substr($A["eid"],0,4);
			$mymonth = substr($A["eid"],4,2);
			$myday   = substr($A["eid"],6,2);
			$myhour  = substr($A["eid"],8,2);
			$mymin   = substr($A["eid"],10,2);
			$mysec   = substr($A["eid"],12,2);
			$newtime = "{$mymonth}/{$myday}/{$myyear} {$myhour}:{$mymin}:{$mysec}";
			$convtime = strtotime($newtime);
			if ($convtime > $desired) {
				$itemlen = strlen($A["title"]);
				#trim the length if over 20 characters
				$foundone = 1;
				if ($itemlen > 35) {
					print "<font class=storyclose>&#149;<a href={$A["url"]} target=_blank>" . substr($A["title"],0,35) . "...</a></font><br>";
				} else {
					print "<font class=storyclose>&#149;<a href={$A["url"]} target=_blank>" . substr($A["title"],0,$itemlen) . "</a></font><br>";
				}
			}
		}
		if ($foundone == 0) {
			print "<font class=storyclose>No recent new events</font><br>";
		}
	}
*/
	endblock();
} //end whatsnewblock()

###############################################################################
#
# Function: showmessage
#
# Author: Tony Bibbs
#   Date: 4/15/01
#
# Arguments:
# 	$msg - The number of the message to show
#
# Returns: (none)
#
# Description: Displays an error message.  HTML formatting is left to the
# caller to do
#
###############################################################################
#
# Modification History
#
# Name			Date		Description
# ----------------	-----------	---------------------------------------
#
###############################################################################
function showmessage($msg) {
	global $MESSAGE,$CONF;

	if ($msg > 0) {
		$timestamp = strftime("%c");
		startblock("{$MESSAGE[40]} - $timestamp");
		print "<img src={$CONF["site_url"]}/images/sysmessage.gif border=0 align=top>" . $MESSAGE[$msg] . "<BR><BR>";
		endblock();
	}
}

###############################################################################
#
# Function: PrintPageNavigation
#
# Author: Tony Bibbs
#   Date: 07/30/2001
#
# Arguments:
#       $page - the current page being displayed
#       $num_pages - total number of pages
#
# Returns: (none)
#
# Description: Shows the Google-like paging navigation
#
###############################################################################
#
# Modification History
#
# Name                  Date            Description
# ----------------      -----------     ---------------------------------------
# Baba                  19 Aug 2001     Bug fix - declared $CONF as global
#
###############################################################################
function PrintPageNavigation ($page, $num_pages, $topic="") {
	global $CONF,$LANG05;

	//Bail if there is only one page...makes no sense
	if ($num_pages == 1) return;

        if ($page > 1) {
                print "<a href={$CONF["site_url"]}/index.php";
                if (!empty($topic))
                        print "?topic=$topic&page=" . ($page-1) . ">$LANG05[6]</a> ";
                else
                        print "?page=" . ($page-1) . ">$LANG05[6]</a> ";
        } else
                print $LANG05[6] . " ";

        for ($pgcount=($page-10);($pgcount<=($page+9)) && ($pgcount<=$num_pages);$pgcount++) {
                if ($pgcount <= 0) $pgcount = 1;
                if ($pgcount == $page)
                        print "<b>" . $pgcount . "</b> ";
                else {
                        print "<a href={$CONF["site_url"]}/index.php";
                        if (!empty($topic))
                                print "?topic=$topic&page=$pgcount>$pgcount</a> ";
                        else
                                print "?page=$pgcount>$pgcount</a> ";
                }
        }
        if ($page == $num_pages)
                print $LANG05[5];
        else {
                print "<a href={$CONF["site_url"]}/index.php";
                if (!empty($topic))
                        print "?topic=$topic&page=" . ($page+1) . ">$LANG05[5]</a>";
                else
                        print "?page=" . ($page+1) . ">$LANG05[5]</a>";
        }
        print "<br>";
}

#This function takes a date in either unixtimestamp or in english and 
#formats it to the users preference.  If the user didn't specify a format
#the format in the config file is used.  This returns array where array[0]
# is the formated date and array[1] is the unixtimestamp
function getuserdatetimeformat($date="") {
        global $USER,$CONF;

        #Get display format for time
        if ($USER["uid"] > 1) {
                $result = dbquery("SELECT format FROM {$CONF["db_prefix"]}dateformats, {$CONF["db_prefix"]}userprefs WHERE dateformats.dfid = userprefs.dfid AND uid = {$USER["uid"]}");
                $nrows = mysql_num_rows($result);
                $A = mysql_fetch_array($result);
                if (empty($A["format"])) {
                        $dateformat = $CONF["date"];
                } else {
                        $dateformat = $A["format"];
                }
        } else {
                $dateformat = $CONF["date"];
        }

        if (empty($date)) {
                #date is empty, get current date/time
                $stamp = time();
        } else if (is_numeric($date)) {
                #this is a timestamp
                $stamp = $date;
        } else {
                #this is a string representation of a date/time
                $stamp = strtotime($date);
        }

        # Actuall format the date
        $date = strftime($dateformat,$stamp);
        return array($date, $stamp);
}

function getusergroups($uid='',$usergroups='',$cur_grp_id='') {
	global $USER,$VERBOSE;

	if ($VERBOSE) errorlog("****************in getusergroups(uid=$uid,usergroups=$usergroups,cur_grp_id=$cur_grp_id)***************",1);
	if (empty($uid)) $uid = $USER['uid'];
	if (empty($cur_grp_id)) {
                $result = dbquery("SELECT ug_main_grp_id,grp_name FROM group_assignments,groups WHERE grp_id = ug_main_grp_id AND ug_uid = $uid",1);
	} else {
                $result = dbquery("SELECT ug_main_grp_id,grp_name FROM group_assignments,groups WHERE grp_id = ug_main_grp_id AND ug_grp_id = $cur_grp_id",1);
        }
	if ($result == -1) return $usergroups;
	$nrows = mysql_num_rows($result);
	if ($VERBOSE) errorlog("got $nrows rows",1);
	for ($i=1;$i<=$nrows;$i++) {
		$A = mysql_fetch_array($result);
		if ($VERBOSE) errorlog('user is in group ' . $A['grp_name'],1);
		$usergroups[$A['grp_name']] = $A['ug_main_grp_id'];
		$usergroups = getusergroups($uid,$usergroups,$A["ug_main_grp_id"]);
	}
	if (is_array($usergroups)) ksort($usergroups);
	if ($VERBOSE) errorlog("****************leaving getusergroups(uid=$uid)***************",1);
	return $usergroups;
}

function ingroup($grp_to_verify,$uid="",$cur_grp_id="") {
	global $USER,$VERBOSE;

	if (empty($uid)) {
		if (empty($USER['uid'])) {
			$uid = 1;
		} else {
			$uid = $USER['uid'];
		}
	}

	if (is_numeric($grp_to_verify)) {
		$result = dbquery("SELECT grp_name FROM groups WHERE grp_id = $grp_to_verify",1);
		if ($result < 0) return false;
		$A = mysql_fetch_array($result);
		$grp_to_verify = $A["grp_name"];
	} else {
		if (dbcount('groups','grp_name',$grp_to_verify) == 0) {
			return false;
		}
	}

	if (empty($cur_grp_id)) {
		$result = dbquery("SELECT ug_main_grp_id,grp_name FROM group_assignments,groups WHERE grp_id = ug_main_grp_id AND ug_uid = $uid",1);
	} else {
		$sql = "SELECT ug_main_grp_id,grp_name FROM group_assignments,groups WHERE grp_id = ug_main_grp_id AND ug_grp_id = $cur_grp_id";
		$result = dbquery($sql,1);
	}

	if ($result == -1) return false;
	$nrows = mysql_num_rows($result);
	for ($i=1;$i<=$nrows;$i++) {
		$A = mysql_fetch_array($result);
		if ($A["grp_name"] == $grp_to_verify) {
			return true;
		} else {
			if (ingroup($grp_to_verify,$uid,$A["ug_main_grp_id"])) {
				return true;
			}
		} 
	}
	return false;
}
	
function ismoderator() {
	global $USER,$RIGHTS;

	#loop through GL core rights.
	for ($i=0;$i<count($RIGHTS);$i++) {
		if (stristr($RIGHTS[$i],'.moderate')) {
			return true;
		}
	}

	#if we get this far they are not a Geeklog moderator
	#see if they are a plugin moderator
	return IsPluginModerator();
		
}

#checks to see if user has access to view a topic
function hastopicaccess($tid) {
	if (empty($tid)) return 0;

	$result = dbquery("SELECT * FROM topics WHERE tid = '$tid'");
	$A = mysql_fetch_array($result);

	return hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]);
}

#this function takes the access info from a Geeklog object 
#and let's us know if the have access to the object
#returns 3 for read/edit, 2 for read only and 0 for no
#access 
function hasaccess($owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) {
	global $USER;

	#cache current user id
	if (empty($USER['uid'])) {
		$uid = 1;
	} else {
		$uid = $USER['uid'];
	}

	#if user is in Root group then return full access
	if (ingroup('Root')) return 3;

	#if user is owner then return 1 now 
	if ($uid == $owner_id) return $perm_owner;

	#Not private, if user is in group then give access
	if (ingroup($group_id)) {
		return $perm_group;
	} else {
		if ($uid == 1) {
			#this is an anonymous user, return it's rights
			return $perm_anon;
		} else { 
			#this is a logged in memeber, return their rights
			return $perm_members;
		}
	}
}
	
#takes either a single feature or an array of features and returns
#an array of wheather the user has those rights 
function hasrights($features,$operator="AND") {
	global $USER,$RIGHTS,$VERBOSE;

	if (strstr($features,',')) {
		$features = explode(',',$features);
	}
	
	if (is_array($features)) {
		#check all values passed
		for ($i=0;$i<count($features);$i++) {
			if ($operator == "OR") {
				#OR operator, return as soon as we find a true one
				if (in_array($features[$i],$RIGHTS)) {
					if ($VERBOSE) {
						errorlog("SECURITY: user has access to " . $features[$i],1);
					}
					return true;
				}
			} else {
				#this is an "AND" operator, bail if we find a false one
				if (!in_array($features[$i],$RIGHTS)) {
					if ($VERBOSE) {
						errorlog("SECURITY: user does not have access to " . $features[$i],1);
					}
					return false;
				}
			}
		}
		if ($operator == "OR") {
			if ($VERBOSE) {
				errorlog("SECURITY: user does not have access to " . $features[$i],1);
			}
			return false;
		} else {
			if ($VERBOSE) {
				errorlog("SECURITY: user has access to " . $features[$i],1);
			}
			return true;
		}
	} else {
		#check the one value
		if ($VERBOSE) {
			if (in_array($features,$RIGHTS)) {
				errorlog("SECURITY: user has access to " . $features,1);
			} else {
				errorlog("SECURITY: user does not have access to " . $features,1);
			}
		}
		return in_array($features,$RIGHTS);
	}
}

function getpermissionshtml($perm_owner,$perm_group,$perm_members,$perm_anon) {
	global $LANG_ACCESS;
	$html = '';
	#$html .= "\n<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">";
	$html .= "\n<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";

	#print the table header
	$html .= "\n<tr><th colspan=3>{$LANG_ACCESS["owner"]}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th colspan=3>{$LANG_ACCESS["group"]}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>{$LANG_ACCESS["members"]}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>{$LANG_ACCESS["anonymous"]}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th></tr>";

	#print owner permissions
	$html .= "\n<tr><td align=center>R<br><input type=checkbox name=perm_owner[] value=2";
	if ($perm_owner >= 2) {
		$html .= " CHECKED";
	}
	$html .= "></td><td align=center>E<br><input type=checkbox name=perm_owner[] value=1";
	if ($perm_owner == 3) {
		$html .= " CHECKED";
	}
	$html .= "></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

	#print group permissions
	$html .= "<td align=center>R<br><input type=checkbox name=perm_group[] value=2";
	if ($perm_group >= 2) {
		$html .= " CHECKED";
	}
	$html .= "></td><td align=center>E<br><input type=checkbox name=perm_group[] value=1";
	if ($perm_group == 3) {
		$html .= " CHECKED";
	}
	$html .= "></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";

	#print member permissions
	$html .= "<td align=center>R<br><input type=checkbox name=perm_members[] value=2";
	if ($perm_members == 2) {
		$html .= " CHECKED";
	}
	$html .= "></td>";

	#print anonymous permissions
	$html .= "<td align=center>R<br><input type=checkbox name=perm_anon[] value=2";
	if ($perm_anon == 2) {
		$html .= " CHECKED";
	}
	$html .= "></td>";

	$html .= "\n</tr>\n</table>";

	#return HTML
	return $html;
}

#recursively called to get permissions
function getuserpermissions($grp_id="") {
	global $USER,$VERBOSE;

	if ($VERBOSE) errorlog("**********inside getuserpermissions(grp_id=$grp_id)**********",1);
	if (empty($grp_id)) {
		#ok, this was the first time this function was called. Let's get all the groups this user belongs to
		#and get the permissions for each group.  NOTE: permissions are given to groups and NOT individuals
		$result = dbquery("SELECT ug_main_grp_id FROM group_assignments WHERE ug_uid = {$USER["uid"]}",1);
		if ($result <> -1) {
			$nrows = mysql_num_rows($result);
			if ($VERBOSE) errorlog("got $nrows row(s) in getuserpermissions",1);
			for ($i=1;$i<=$nrows;$i++) {
				$A = mysql_fetch_array($result);
				$rights .= getuserpermissions($A["ug_main_grp_id"]);	
			}
		}
	} else {
		#in this case we are going up the group tree for this user building a list of rights 
		#along the way.  First, get the rights for this group. 
		$result = dbquery("SELECT ft_name FROM access,features WHERE ft_id = acc_ft_id AND acc_grp_id = $grp_id",1);
		$nrows = mysql_num_rows($result);
		if ($VERBOSE) errorlog("got $nrows rights for group $grp_id in getuserpermissions",1);
		for ($j=1;$j<=$nrows;$j++) {
			$A = mysql_fetch_array($result);
			if ($VERBOSE) errorlog("Adding right " . $A["ft_name"] . " in getuserpermissions",1);
			$rights .= $A["ft_name"] . ",";
		}

		#now see if there are any groups tied to this one further up the tree.  If so
		#see if they have additional rights
		$result = dbquery("SELECT ug_main_grp_id FROM group_assignments WHERE ug_grp_id = $grp_id",1);
		$nrows = mysql_num_rows($result);
		if ($VERBOSE) errorlog("got $nrows groups tied to group $grp_id in getuserpermissions",1);
		for ($i=1;$i<=$nrows;$i++) {
			#now for each group, see if there are any rights assigned to it. If so, add to our 
			#comma delimited string
			$A = mysql_fetch_array($result);
			$rights .= getuserpermissions($A["ug_main_grp_id"]);
		}
	}
	if ($VERBOSE) errorlog("**********leaving getuserpermissions(grp_id=$grp_id)**********",1);
	return $rights;
}

function getpermissionvalues($perm_owner,$perm_group,$perm_members,$perm_anon) {
	$perm_owner = getpermissionvalue($perm_owner);
	$perm_group = getpermissionvalue($perm_group);
	$perm_members = getpermissionvalue($perm_members);
	$perm_anon = getpermissionvalue($perm_anon);

	return array($perm_owner,$perm_group,$perm_members,$perm_anon);
}

function getpermissionvalue($perm_x) {
	$value = 0;
	for ($i=1;$i<=sizeof($perm_x);$i++) {
        	$value = $value + current($perm_x);
                next($perm_x);
        }
	#if they have edit rights, assume read rights
	if ($value == 1) $value = 3;
	
	return $value;
}

# Now include all plugin functions
$result = dbquery('SELECT * from plugins WHERE pi_enabled = 1');
$nrows = mysql_num_rows($result);
for ($i = 1; $i <= $nrows; $i++) {
	$A = mysql_fetch_array($result);
	include_once($CONF["path"] . "plugins/" . $A['pi_name'] . "/functions.inc");
}
?>
