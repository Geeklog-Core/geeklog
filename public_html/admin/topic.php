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

if (!hasrights('topic.edit')) {
        site_header("menu");
        startblock($MESSAGE[30]);
        print $MESSAGE[32];
        endblock();
        site_footer();
        exit;
}

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

###############################################################################
# Displays the topic editor

function edittopic($tid="") {
	global $LANG27,$CONF,$USER,$LANG_ACCESS;
	startblock($LANG27[1]);
	if (!empty($tid)) {
		$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}topics where tid ='$tid'");
		$A = mysql_fetch_array($result);
		$access = hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]);
		if ($access == 0 OR $access == 2) {
                        startblock($LANG27[12]);
                        print $LANG27[13]; 
                        endblock();
                        return;
                }
	} else {
		$A["owner_id"] = $USER["uid"];
		#this is the one instance where we default the group
		#most topics should belong to the normal user group 
		# and the private flag should be turned OFF
		$A["group_id"] = getitem('groups','grp_id',"grp_name = 'Normal User'");
		$A["perm_owner"] = 3;
                $A["perm_group"] = 3;
                $A["perm_members"] = 2;
                $A["perm_anon"] = 2;
		$access = 3;
	}
	print "<form action={$CONF["site_url"]}/admin/topic.php method=post>";
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr><td colspan=2><input type=submit value=save name=mode> ";
	print "<input type=submit value=cancel name=mode> ";
	if (!empty($tid))
		print "<input type=submit value=delete name=mode>";
	print "<tr></td>";
	print "<tr><td align=right>{$LANG27[2]}:</td><td><input type=text size=20 name=tid value=\"{$A["tid"]}\"> {$LANG27[5]}</td></tr>";

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
        print "<tr><td colspan=2>{$LANG_ACCESS[lockmsg]}<td></tr>";
        print "<tr><td colspan=2><hr><td></tr>";

	// show sort order only if they specified sortnum as the sort method
	if ($CONF["sortmethod"] <> 'alpha')
		print "<tr><td align=right>{$LANG27[10]}:</td><td><input type=text size=3 maxlength=3 name=sortnum value=\"{$A["sortnum"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG27[11]}:</td><td><input type=text size=3 maxlength=3 name=limitnews value=\"{$A["limitnews"]}\"> (default is {$CONF["limitnews"]})</td></tr>";
	print "<tr><td align=right>{$LANG27[3]}:</td><td><input type=text size=48 name=topic value=\"{$A["topic"]}\"></td></tr>";
	if ($A["tid"] == "") { $A["imageurl"] = "/images/icons/"; }
	print "<tr><td align=right>{$LANG27[4]}:</td><td><input type=text size=48 maxlength=96 name=imageurl value=\"{$A["imageurl"]}\"></td></tr>";
	print "<tr><td colspan=2 class=warning>{$LANG27[6]}</td></tr>";
	print "</table></form>";
	endblock();
}

###############################################################################
# Saves $tid to the database

function savetopic($tid,$topic,$imageurl,$sortnum,$limitnews,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) {
	global $CONF,$LANG27;

	if (!empty($tid) && !empty($topic)) {
		if ($imageurl == '/images/topics/') { 
			$imageurl = ''; 
		}	

		#Convert array values to numeric permission values
                list($perm_owner,$perm_group,$perm_members,$perm_anon) = getpermissionvalues($perm_owner,$perm_group,$perm_members,$perm_anon);

		dbsave("topics","tid, topic, imageurl, sortnum, limitnews, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon","'$tid', '$topic', '$imageurl','$sortnum','$limitnews',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_group","admin/topic.php?msg=13");
	} else {
		site_header('menu');
		errorlog($LANG27[7],2);
		edittopic($tid);
		site_footer();
	}
}

###############################################################################
# Displays a list of topics

function listtopics() {
	global $LANG27,$CONF,$LANG_ACCESS;
	startblock($LANG27[8]);
	adminedit("topic",$LANG27[9]);
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr align=center valign=bottom>";
	$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}topics");
	$nrows = mysql_num_rows($result);
	$counter = 1;
	for ($i=0;$i<$nrows;$i++) {
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
		if (!empty($A["imageurl"])) {
			print "<td><a href={$CONF["site_url"]}/admin/topic.php?mode=edit&tid={$A["tid"]}><img src={$CONF["site_url"]}{$A["imageurl"]} border=0><br>{$A["topic"]}</a> ($access)</td>";
		} else {
			print "<td><a href={$CONF["site_url"]}/admin/topic.php?mode=edit&tid={$A["tid"]}>{$A["topic"]}</a> ($access)</td>";
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
		savetopic($tid,$topic,$imageurl,$sortnum,$limitnews,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
		break;
	case "edit":
		site_header("menu");
		edittopic($tid);
		site_footer();
		break;
	case "cancel":
	default:
		site_header("menu");
		showmessage($msg);
		listtopics();
		site_footer();
		break;}

?>
