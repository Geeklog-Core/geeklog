<?php

###############################################################################
# link.php
# This is the admin links interface!
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

if (!hasrights('link.edit')) {
        site_header('menu');
        startblock($MESSAGE[30]);
        print $MESSAGE[34];
        endblock();
        site_footer();
	errorlog("User {$USER["username"]} tried to illegally access the link administration screen",1);
        exit;
}

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

###############################################################################
# Displays the link editor form

function editlink($lid="") {
	global $LANG23,$CONF,$USER,$LANG_ACCESS;

	startblock($LANG23[1]);
	if (!empty($lid)) {
		$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}links where lid ='$lid'");
		$A = mysql_fetch_array($result);
		$access = hasaccess($A["private_flag"],$A["owner_id"],$A["group_id"]);
		if ($access == 0) {
			startblock($LANG23[16]);
                        print  $LANG23[17];
                        endblock();
                        return;
                }
	} else {
		$A['owner_id'] = $USER['uid'];
		$A['private_flag'] = 1;
		$access = 1;
	}
	print "<form action={$CONF["site_url"]}/admin/link.php method=post>";
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr><td colspan=2><input type=submit value=save name=mode> ";
	if ($A["lid"] == "") { 
		$A["lid"] = 0; 
	}
	print "<input type=submit value=cancel name=mode> ";
	if (!empty($lid) && hasrights('link.edit'))
		print "<input type=submit value=delete name=mode>";
	print "<input type=hidden name=lid value={$A["lid"]}><tr></td>";
	print "<tr><td align=right>{$LANG23[3]}:</td><td><input type=text size=48 maxlength=96 name=title value=\"{$A["title"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG23[4]}:</td><td><input type=text size=48  maxlength=96 name=url value=\"{$A["url"]}\"> {$LANG23[6]}</td></tr>";
	print "<tr><td align=right>{$LANG23[5]}:</td><td>";
	$result	= mysql_query("SELECT distinct category from links");
	$nrows	= mysql_num_rows($result);
	if ($nrows>0) {
		print "<select name=categorydd>\n";
		print "<option>{$LANG23[7]}</option>\n";
		for ($i=0;$i<$nrows;$i++) {
			$category = mysql_result($result,$i);
			print "<option value=\"$category\"";
			if ($A["category"] == $category) { print " selected"; }
			print ">$category</option>\n";
		}
		print "</select>\n";
		print "If other, specify: ";
	}
	print "<input type=text name=category size=12 maxlength=32>\n</td></tr>";
	print "<tr><td align=right>{$LANG23[8]}:</td><td><input type=text size=11 name=hits value={$A["hits"]}></td></tr>";
	print "<tr><td align=right>{$LANG23[9]}:</td><td><textarea name=description cols=50 rows=6 wrap=virtual>" . stripslashes($A["description"]) . "</textarea></td></tr>";

	#user access info
        print "<tr><td colspan=2><hr><td></tr>";
        print "<tr><td colspan=2><b>{$LANG_ACCESS[accessrights]}</b></td></tr>";
        print "<tr><td align=right>{$LANG_ACCESS[owner]}:</td><td>" . getitem("users","username","uid = {$A["owner_id"]}");
        print "<input type=hidden name=owner_id value={$A["owner_id"]}>" . "</td></tr>";
        print "<tr><td align=right>{$LANG_ACCESS[group]}:</td><td>";
        $usergroups = getusergroups();
	if ($access == 1) {
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
	}
        print "</td></tr><tr><td colspan=2>{$LANG_ACCESS[grantgrouplabel]}&nbsp;<input type=checkbox name=private_flag ";
        if ($A["private_flag"] == 0) {
                print "CHECKED";
        }
        print "></td></tr>";
        print "<tr><td colspan=2>{$LANG_ACCESS[grantgroupmsg]}<td></tr>";

	print "</table></form>";
	endblock();
}

###############################################################################
# Svaes the links to the database

function savelink($lid,$category,$categorydd,$url,$description,$title,$hits,$owner_id,$group_id,$private_flag) {
	global $CONF,$LANG23; 

	# clean 'em up 
	$description = addslashes(checkhtml(checkwords($description)));
	$title = addslashes(checkhtml(checkwords($title)));

	if (!empty($title) && !empty($description) && !empty($url)) {
		if (!empty($lid)) {
			dbdelete("links","lid",$lid);
		} else {
			$lid = makesid();
		}
		if ($categorydd!="Other" && !empty($categorydd)) {
			$category = $categorydd;
		} else if ($categorydd!="Other") {
			refresh("{$CONF["site_url"]}/admin/link.php");
		}

		if ($private_flag == 'on') {
                        $private_flag = 0;
                } else {
                        $private_flag = 1;
		}
		dbsave("links","lid,category,url,description,title,hits,owner_id,group_id,private_flag","$lid,'$category','$url','$description','$title','$hits',$owner_id,$group_id,$private_flag","admin/link.php?msg=15");
	} else {
		site_header('menu');
		errorlog($LANG23[10],2);
		editlink($lid);
		site_footer();
	}
}

###############################################################################
# Displays the list of links

function listlinks() {
	global $LANG23,$LANG_ACCESS,$CONF;
	startblock($LANG23[11]);
	adminedit("link",$LANG23[12]);
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr><th align=left>{$LANG23[13]}</th><th>{$LANG_ACCESS[access]}</th><th>{$LANG23[14]}</th><th>{$LANG23[15]}</th></tr>";
	$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}links ORDER BY category asc,title");
	$nrows = mysql_num_rows($result);
	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
	 	$access = hasaccess($A["private_flag"],$A["owner_id"],$A["group_id"]);
                if ($access) {
                	if ($access == 1) {
                        	$access = $LANG_ACCESS[ownerroot];
                        } else {
                                $access = $LANG_ACCESS[group];
                        }
                } else {
                        $access = $LANG_ACCESS[readonly];
                }	
		print "<tr align=center><td align=left><a href={$CONF["site_url"]}../admin/link.php?mode=edit&lid={$A["lid"]}>" . stripslashes($A["title"]) . "</a></td>";
		print "<td>$access</td><td>{$A["category"]}</td><td>{$A["url"]}</td></tr>";
	}
	print "</table></form>";
	endblock();
}

###############################################################################
# MAIN

switch ($mode) {
	case 'delete':
		dbdelete('links','lid',$lid,'/admin/link.php?msg=16');
		break;
	case 'save':
		savelink($lid,$category,$categorydd,$url,$description,$title,$hits,$owner_id,$group_id,$private_flag);
		break;
	case 'edit':
		site_header('menu');
		editlink($lid);
		site_footer();
		break;
	case 'cancel':
	default:
		site_header('menu');
		showmessage($msg);
		listlinks();
		site_footer();
		break;
}

?>
