<?php

###############################################################################
# story.php
# This is the admin story moderation and editing file.
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

include('../common.php');
include('../custom_code.php');
include('auth.inc.php');

if (!hasrights('story.edit')) {
	site_header('menu');
        startblock($MESSAGE[30]); 
        print $MESSAGE[31];
        endblock();
        site_footer();
	errorlog("User {$USER["username"]} tried to illegally access the story administration screen",1);
        exit;
}

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

###############################################################################
# Displays the Story Editor

function storyeditor($sid,$mode="") {
	global $HTTP_POST_VARS,$USER,$CONF,$LANG24,$LANG_ACCESS;
	if (!empty($sid) && $mode == "edit") {
		$result = dbquery("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$CONF["db_prefix"]}stories WHERE sid = '$sid'");
		$A = mysql_fetch_array($result);
		$access = hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]);
		if ($access == 2) {
			startblock($LANG24[40]);
			print $LANG24[41];
			endblock();
			article($A,n);
			return;
		} else if ($access == 0) {
			startblock($LANG24[40]);
                        print $LANG24[42];
                        endblock();
                        return;
		}
	} elseif (!empty($sid) && $mode == "editsubmission") {
		$result = dbquery("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$CONF["db_prefix"]}storysubmission WHERE sid = '$sid'");
		$A = mysql_fetch_array($result);
		$A["commentcode"] = 0;
		$A["featured"] = 0;
		$A["statuscode"] = 0;
		$A["owner_id"] = $USER["uid"];
		$A["group_id"] = getitem('groups','grp_id',"grp_name = 'Story Admin'");
		$A["perm_owner"] = 3;
		$A["perm_group"] = 3;
		$A["perm_members"] = 2;
		$A["perm_anon"] = 2;
		$access = 3;
	} elseif ($mode == "edit") {
		$A["sid"] = makesid();
		$A["uid"] = $USER["uid"];
		$A["unixdate"] = time();
		$A["commentcode"] = 0;
		$A["statuscode"] = 0;
		$A["featured"] = 0;
		$A["owner_id"] = $USER["uid"];
		$A["perm_owner"] = 3;
                $A["perm_group"] = 3;
                $A["perm_members"] = 2;
                $A["perm_anon"] = 2;
		$access = 3;
	} else {
		$A = $HTTP_POST_VARS;
		if ($A["postmode"] == "html") {
			$A["introtext"] = checkhtml(checkwords($A["introtext"]));
			$A["bodytext"] = checkhtml(checkwords($A["bodytext"]));
		} else {
			$A["introtext"] = htmlspecialchars(checkwords($A["introtext"]));
			$A["bodytext"] = htmlspecialchars(checkwords($A["bodytext"]));
		}
		$A["title"] = strip_tags($A["title"]);
	}
	if (!empty($A["title"])) {
		startblock($LANG24[26]);
		article($A,"n");
		endblock();
	}
	startblock($LANG24[5]);
	print "<form action={$CONF["site_url"]}/admin/story.php method=post>";
	print "<table border=0 cellspacing=0 cellpadding=3 width=\"100%\">";
	print "<tr><td colspan=2><input type=submit value=save name=mode> ";
	print "<input type=submit value=preview name=mode> ";
	print "<input type=submit value=cancel name=mode> ";
	if ($access == 3) {
		print "<input type=submit value=delete name=mode> ";
	}
	if ($A["type"] == "editsubmission" || $mode == "editsubmission") {
                print "<input type=hidden name=type value=submission>";
        }
	print "<tr></td>";
	print "<tr><td align=right>{$LANG24[7]}:</td><td>" . getitem("users","username","uid = {$A["uid"]}") . "<input type=hidden name=uid value={$A["uid"]}></td></tr>";
	#user access info
	print "<tr><td colspan=2><hr><td></tr>";
	print "<tr><td colspan=2><b>{$LANG_ACCESS[accessrights]}</b></td></tr>";
	print "<tr><td align=right>{$LANG_ACCESS[owner]}:</td><td>" . getitem("users","username","uid = {$A["owner_id"]}");
	print "<input type=hidden name=owner_id value={$A["owner_id"]}>" . "</td></tr>";
	print "<tr><td align=right>{$LANG_ACCESS[group]}:</td><td>";
	$usergroups = getusergroups();
	if ($access == 3) {
		print "<SELECT name=group_id>";
		for ($i=0;$i<count($usergroups);$i++) {
			print "<option value=" . $usergroups[key($usergroups)];
			if ($A["group_id"] == $usergroups[key($usergroups)]) {
				print " SELECTED";
			}
			print ">" . key($usergroups) . "</option>";
			next($usergroups);
		}
		print "</SELECT>";
	} else {
		#they can't set the group then
		print getitem("groups","grp_name","grp_id = {$A["group_id"]}");
		print "<input type=\"hidden\" name=\"group_id\" value=\"{$A["group_id"]}\">";
	}
	print "</td><tr><tr><td colspan=\"2\"><b>{$LANG_ACCESS[permissions]}</b>:</td></tr><tr><td colspan=2>";
	print "</td><tr><tr><td colspan=\"2\">{$LANG_ACCESS[permissionskey]}</td></tr><tr><td colspan=2>";
	$html = getpermissionshtml($A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]);
	print $html;
	print "</td></tr>";
	#print "></td></tr>";
	print "<tr><td colspan=2>{$LANG_ACCESS[permmsg]}<td></tr>";
	print "<tr><td colspan=2><hr><td></tr>";
	$curtime = getuserdatetimeformat($A["unixdate"]);
	print "<tr><td align=right>{$LANG24[15]}:</td><td>". $curtime[0] . "<input type=hidden name=unixdate value={$A["unixdate"]}></td></tr>";
	#print "<tr><td align=right>{$LANG24[15]}:</td><td>". strftime($CONF["date"],$A["unixdate"]) . "<input type=hidden name=unixdate value={$A["unixdate"]}></td></tr>";
	print "<tr><td align=right>{$LANG24[13]}:</td><td><input type=text size=48 maxlength=255 name=title value=\"" . stripslashes($A["title"]) . "\"></td></tr>";
	print "<tr><td align=right>{$LANG24[14]}:</td><td><select name=tid>";
	optionlist("topics","tid,topic",$A["tid"]);
	print "</select></td></tr>";
	print "<tr><td align=right>{$LANG24[34]}:</td><td><input type=checkbox name=draft_flag";
	if ($A["draft_flag"] == 1)
		print " checked";
	print "></td></tr>";
	print "<tr><td align=right>{$LANG24[3]}:</td><td><select name=statuscode>";
	optionlist("statuscodes","code,name",$A["statuscode"]);
	print "</select> <select name=commentcode>";
	optionlist("commentcodes","code,name",$A["commentcode"]);
	print "</select> <select name=featured>";
	optionlist("featurecodes","code,name",$A["featured"]);
	print "</select> <select name=frontpage>";
	optionlist("frontpagecodes","code,name",1);
	print "</select></td></tr>";

	print "<tr><td valign=top align=right>{$LANG24[16]}:</td><td><textarea name=introtext cols=50 rows=6 wrap=virtual>" . stripslashes($A["introtext"]) . "</textarea></td></tr>";
	print "<tr><td valign=top align=right>{$LANG24[17]}:</td><td><textarea name=bodytext cols=50 rows=8 wrap=virtual>" . stripslashes($A["bodytext"]) . "</textarea></td></tr>";
	print "<tr valign=top><td align=right><b>{$LANG24[4]}:</b></td><td><select name=postmode>";
	optionlist("postmodes","code,name",$A["postmode"]);
	print "</select><br>";
	allowedhtml();
	print "</td></tr>\n";
	print "<tr><td align=right>{$LANG24[18]}:</td><td><input type=hidden name=hits value={$A["hits"]}>{$A["hits"]}</td></tr>";
	print "<tr><td align=right>{$LANG24[19]}:</td><td>{$A["comments"]}<input type=hidden name=comments value={$A["comments"]}></td></tr>";
	print "<tr><td align=right>{$LANG24[39]}:</td><td>{$A["numemails"]}<input type=hidden name=numemails value={$A["numemails"]}></td></tr>";
	print "<input type=hidden name=sid value={$A["sid"]}></td></tr>";
	print "</table>";
	endblock();
	print "</form>";
}

###############################################################################
# Displays a list of stories

function liststories($page="1") {
	global $LANG24,$CONF,$LANG_ACCESS;
	startblock($LANG24[22]);
	adminedit("story",$LANG24[23]);
	if (empty($page)) $page = 1;
	$limit = (50 * $page) - 50;
	$result = dbquery("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$CONF["db_prefix"]}stories ORDER BY date DESC LIMIT $limit,50");
	$nrows = mysql_num_rows($result);
	if ($nrows > 0) {
		print "<table cellpadding=0 cellspacing=3 border=0 width=100%>\n";
		print "<tr><th align=left>#</th><th align=left>{$LANG24[13]}</th><th>{$LANG_ACCESS[access]}</th><th>{$LANG24[34]}</th><th>{$LANG24[7]}</th><th>{$LANG24[15]}</th><th>{$LANG24[14]}</th><th>{$LANG24[32]}</th></tr>";
 		for ($i=1; $i<=$nrows; $i++) {
			$scount = (50 * $page) - 50 + $i;
			$A = mysql_fetch_array($result);
			$access = hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]);
			if ($access > 0) {
				if ($access == 3) {
					$access = $LANG_ACCESS[edit];
				} else {
					$access = $LANG_ACCESS[readonly];
				}
			} else {
				$access = $LANG_ACCESS[none];
			}
			$curtime = getuserdatetimeformat($A["unixdate"]);
			print "<tr align=center><td align=left><a href={$CONF["site_url"]}/admin/story.php?mode=edit&sid={$A["sid"]}>$scount</a></td>";
			print "<td align=left><a href={$CONF["site_url"]}/article.php?story={$A["sid"]}>" . stripslashes($A["title"]) . "</a></td>";
			print "<td align=center>$access</td>";
			if ($A["draft_flag"] == 1)
				print "<td>{$LANG24[35]}</td>";
			else
				print "<td>{$LANG24[36]}</td>";
			print "<td>" . getitem("users","username","uid = {$A["uid"]}") . "</td>";
			#print "<td>" . strftime("%x %X",$A["unixdate"]) . "</td>";
			print "<td>" . $curtime[0] . "</td>";
			print "<td>{$A["tid"]}</td><td>";
			if ($A["featured"] == 1) {
				print "{$LANG24[35]}</td></tr>";
			} else {
				print "{$LANG24[36]}</td></tr>";
			}
		}
		print "<tr><td clospan=6>";
		if (dbcount("stories") > 50) {
			$prevpage = $page - 1;
			$nextpage = $page + 1;
			if ($pagestart >= 50) {
				print "<a href={$CONF["site_url"]}/admin/story.php?mode=list&page=$prevpage>{$LANG24[1]}</a> ";
			}
			if ($pagestart <= (dbcount("stories") - 50)) {
				print "<a href={$CONF["site_url"]}/admin/story.php?mode=list&page=$nextpage>{$LANG24[2]}</a> ";
			}
		}
		print "</td></tr></table>\n";
	}
	endblock();
}

###############################################################################
# Saves a story to the database

function submitstory($type="",$sid,$uid,$tid,$title,$introtext,$bodytext,$hits,$unixdate,$comments,$featured,$commentcode,$statuscode,$postmode,$frontpage,$draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) {
	global $CONF,$LANG24;
	if (!empty($title) && !empty($introtext)) {
		if (empty($hits)) $hits = 0;

		if ($draft_flag == "on")
			$draft_flag = 1;
		else
			$draft_flag = 0;

		#Convert array values to numeric permission values
		list($perm_owner,$perm_group,$perm_members,$perm_anon) = getpermissionvalues($perm_owner,$perm_group,$perm_members,$perm_anon);

		if ($featured == "1") {
			#there can only be one non-draft featured story
			if ($draft_flag == 0)
				dbchange("stories","featured","0","featured","1","draft_flag","0");

			#if set to featured force to show on front page
			$frontpage = 1;
		}
		if (empty($numemails)) {
			$numemails = 0;
		}

		$date = date("Y-m-d H:i:s",$unixdate);


		# Get the related URLs
		$fulltext = "$introtext $bodytext";
		$check = " ";
		while($check != $reg[0]) {
			$check = $reg[0];

			#this gets any links from the article
			eregi("<a([^<]|(<[^/])|(</[^a])|(</a[^>]))*</a>",$fulltext,$reg);

			#this gets what is between <a href=...> and </a>
			preg_match("/<a href=([^\]]+)>([^\]]+)<\/a>/",stripslashes($reg[0]),$url_text);
			if (empty($url_text[1])) {
				preg_match("/<A HREF=([^\]]+)>([^\]]+)<\/A>/",stripslashes($reg[0]),$url_text);
			}
			
                        $orig = $reg[0]; 

			#if links is too long, shorten it and add ... at the end
			if (strlen($url_text[2]) > 26) {
				$new_text = substr($url_text[2],0,26) . '...';
				#note, this assumes there is no space between > and url_text[1]
				$reg[0] = str_replace(">".$url_text[2],">".$new_text,$reg[0]);
			}	
			if(stristr($fulltext,"<img ")) {
				#this is a linked images tag, ignore
				$reg[0] = "";
			}
			if ($reg[0] != "") {
				$fulltext = str_replace($orig,"",$fulltext);
			}
			if ($check != $reg[0]) {
				#Only write if we are dealing with something other than an image 
                                if(!(stristr($reg[0],"<img "))) { 
					$related .= "<li>" . stripslashes($reg[0]);
				}
			}
		}
		$author = getitem("users","username","uid = $uid");
		$topic = getitem("topics","topic","tid = '$tid'");
		if ($CONF["contributedbyline"] == 1) {
			$related .= "<li><a href={$CONF["site_url"]}/search.php?mode=search&type=stories&author=$uid>{$LANG24[37]} $author</a>\n";
		}
		$related .= "<li><a href={$CONF["site_url"]}/search.php?mode=search&type=stories&topic=$tid>{$LANG24[38]} $topic</a>\n";
		$related = addslashes(checkhtml(checkwords($related)));

		# Clean up the text
		if ($postmode == "html") {
			$introtext = addslashes(checkhtml(checkwords($introtext)));
			$bodytext = addslashes(checkhtml(checkwords($bodytext)));
		} else {
			$introtext = addslashes(htmlspecialchars(checkwords($introtext)));
			$bodytext = addslashes(htmlspecialchars(checkwords($bodytext)));
		}
		$title = addslashes(htmlspecialchars(strip_tags(checkwords($title))));
		$comments = dbcount("comments","sid",$sid);
		if ($type = "submission") dbdelete("storysubmission","sid",$sid);
		dbsave("stories","sid,uid,tid,title,introtext,bodytext,hits,date,comments,related,featured,commentcode,statuscode,postmode,frontpage,draft_flag,numemails,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon","$sid,$uid,'$tid','$title','$introtext','$bodytext',$hits,'$date','$comments','$related',$featured,'$commentcode','$statuscode','$postmode','$frontpage',$draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon","admin/story.php?msg=9");
	} else {
		site_header("menu");
		errorlog($LANG24[31],2);
		storyeditor($sid);
		site_footer();
	}
}

###############################################################################
# MAIN

switch ($mode) {
	case "delete":
		if ($type == "submission") {
			dbdelete("storysubmission","sid",$sid,"/admin/moderation.php");
		} else {
			dbdelete("stories","sid",$sid,"/admin/story.php?msg=10");
		}
		break;
	case "preview":
		site_header("menu");
		storyeditor($sid,$mode);
		site_footer();
		break;
	case "edit":
		site_header("menu");
		storyeditor($sid,$mode);
		site_footer();
		break;
	case "editsubmission":
		site_header("menu");
		storyeditor($id,$mode);
		site_footer();
		break;
	case "save":
		submitstory($type,$sid,$uid,$tid,$title,$introtext,$bodytext,$hits,$unixdate,$comments,$featured,$commentcode,$statuscode,$postmode,$frontpage, $draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
		break;
	case "cancel":
	default:
		site_header("menu");
		showmessage($msg);
		liststories($page);
		site_footer();
		break;
}

?>
