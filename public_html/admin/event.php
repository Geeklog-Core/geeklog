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

if (!hasrights('event.edit')) {
        site_header('menu');
        startblock($MESSAGE[30]);
        print $MESSAGE[35];
        endblock();
        site_footer();
        errorlog("User {$USER["username"]} tried to illegally access the event administration screen",1);
        exit;
}

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

###############################################################################
# Displays the events editor form

function editevent($mode,$eid="") {
	global $LANG22,$CONF,$LANG_ACCESS,$USER;
	startblock($LANG22[1]);
	if ($mode <> 'editsubmission' AND !empty($eid)) {
		$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}events where eid ='$eid'");
		$A = mysql_fetch_array($result);
		$access = hasaccess($A["owner_id"],$A["group_id"],$A["perm_owner"],$A["perm_group"],$A["perm_members"],$A["perm_anon"]);
		if ($access == 0 OR $access == 2) {
                        startblock($LANG22[16]);
                        print  $LANG22[17];
                        endblock();
                        return;
                }
	} else {
		if ($mode == 'editsubmission') {
			$result = dbquery ("SELECT * FROM {$CONF["db_prefix"]}eventsubmission where eid = '$eid'");
                        $A = mysql_fetch_array($result);
		}
		$A["owner_id"] = $USER['uid'];
		$A["group_id"] = getitem('groups','grp_id',"grp_name = 'Event Admin'");
		$A["perm_owner"] = 3;
                $A["perm_group"] = 3;
                $A["perm_members"] = 2;
                $A["perm_anon"] = 2;
		$access = 3;
	}
	print "<form action={$CONF["site_url"]}/admin/event.php name=events method=post>";
	print "<table border=0 cellspacing=0 cellpadding=3>";
	print "<tr><td colspan=2><input type=submit value=save name=mode> ";
	print "<input type=submit value=cancel name=mode> ";
	if ($A["eid"] == "") { 
		$A["eid"] = makesid(); 
	}
        if (!empty($eid) && hasrights('event.edit'))
		print "<input type=submit value=delete name=mode>";
	print "<input type=hidden name=eid value={$A["eid"]}>";
	print "</td></tr>";
	print "<tr><td align=right>{$LANG22[3]}:</td><td><input type=text size=48 maxlength=96 name=title value=\"{$A["title"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG22[4]}:</td><td><input type=text size=48  maxlength=96 name=url value=\"{$A["url"]}\"> {$LANG22[9]}</td></tr>";
	print "<tr><td align=right>{$LANG22[5]}:</td><td><input type=text size=12 name=datestart value={$A["datestart"]}> YYYY-MM-DD</td></tr>";
	print "<tr><td align=right>{$LANG22[6]}:</td><td><input type=text size=12 name=dateend value={$A["dateend"]}> YYYY-MM-DD</td></tr>";
	print "<tr><td align=right>{$LANG22[7]}:</td><td><textarea name=location cols=50 rows=3 wrap=virtual>{$A["location"]}</textarea></td></tr>";
	print "<tr><td align=right>{$LANG22[8]}:</td><td><textarea name=description cols=50 rows=6 wrap=virtual>{$A["description"]}</textarea></td></tr>";

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

	print "</table></form>";
	endblock();
}

###############################################################################
# Svaes the events evente database

function saveevent($eid,$title,$url,$datestart,$dateend,$location,$description,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) {
	global $CONF,$LANG22;

	# clean 'em up 
	$description = addslashes(checkhtml(checkwords($description)));
	$title = addslashes(checkhtml(checkwords($title)));

	if (!empty($eid) && !empty($description) && !empty($title)) {
		dbdelete("eventsubmission","eid",$eid);

		#Convert array values to numeric permission values
                list($perm_owner,$perm_group,$perm_members,$perm_anon) = getpermissionvalues($perm_owner,$perm_group,$perm_members,$perm_anon);

		dbsave("events","eid,title,url,datestart,dateend,location,description,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon","$eid,'$title','$url','$datestart','$dateend','$location','$description',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon","admin/event.php?msg=17");
	} else {
		site_header('menu');
		errorlog($LANG22[10],2);
		editevent($mode,$eid);
		site_footer();
	}
}

###############################################################################
# Displays the list of events items

function listevents() {
	global $LANG22,$CONF,$LANG_ACCESS;
	startblock($LANG22[11]);
	adminedit("event",$LANG22[12]);
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr><th align=left>{$LANG22[13]}</th><th>{$LANG_ACCESS[access]}</th><th>{$LANG22[14]}</th><th>{$LANG22[15]}</th></tr>";
	$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}events ORDER BY datestart");
	$nrows = mysql_num_rows($result);
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
		print "<tr align=center><td align=left><a href={$CONF["site_url"]}/admin/event.php?mode=edit&eid={$A["eid"]}>" . stripslashes($A["title"]) . "</a></td>";
		print "<td>$access</td><td>{$A["datestart"]}</td><td>{$A["dateend"]}</td></tr>";
	}
	print "</table></form>";
	endblock();
}

###############################################################################
# MAIN

switch ($mode) {
	case "delete":
		dbdelete('events','eid',$eid,'/admin/event.php?msg=18');
		break;
	case "save":
		saveevent($eid,$title,$url,$datestart,$dateend,$location,$description,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
		break;
	case "editsubmission":
		site_header('menu');
		editevent($mode,$id);
		site_footer();
		break;
	case "edit":
		site_header('menu');
		editevent($mode,$eid);
		site_footer();
		break;
	case "cancel":
	default:
		site_header('menu');
		showmessage($msg);
		listevents();
		site_footer();
		break;
}

?>
