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

function editevent($eid="") {
	global $LANG22,$CONF,$LANG_ACCESS;
	startblock($LANG22[1]);
	if (!empty($eid)) {
		$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}events where eid ='$eid'");
		$A = mysql_fetch_array($result);
		$access = hasaccess($A["private_flag"],$A["owner_id"],$A["group_id"]);
		if ($access == 0) {
                        startblock($LANG22[16]);
                        print  $LANG22[17];
                        endblock();
                        return;
                }
	} else {
		$A['owner_id'] = $USER['uid'];
		$A['private_flag'] = 1;
		$access = 1;
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
	print "<tr><td align=right>{$LANG22[5]}:</td><td><input type=text size=10 name=datestart value={$A["datestart"]}> YYYY-MM-DD</td></tr>";
	print "<tr><td align=right>{$LANG22[6]}:</td><td><input type=text size=10 name=dateend value={$A["dateend"]}> YYYY-MM-DD</td></tr>";
	print "<tr><td align=right>{$LANG22[7]}:</td><td><textarea name=location cols=50 rows=3 wrap=virtual>{$A["location"]}</textarea></td></tr>";
	print "<tr><td align=right>{$LANG22[8]}:</td><td><textarea name=description cols=50 rows=6 wrap=virtual>{$A["description"]}</textarea></td></tr>";

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
# Svaes the events evente database

function saveevent($eid,$title,$url,$datestart,$dateend,$location,$description,$owner_id,$group_id,$private_flag) {
	global $CONF,$LANG22;

	# clean 'em up 
	$description = addslashes(checkhtml(checkwords($description)));
	$title = addslashes(checkhtml(checkwords($title)));

	if (!empty($eid) && !empty($description) && !empty($title)) {
		if ($private_flag == 'on') {
                        $private_flag = 0;
                } else {
                        $private_flag = 1;
		}
		dbsave("events","eid,title,url,datestart,dateend,location,description,owner_id,group_id,private_flag","$eid,'$title','$url','$datestart','$dateend','$location','$description',$owner_id,$group_id,$private_flag","admin/event.php?msg=17");
	} else {
		site_header('menu');
		errorlog($LANG22[10],2);
		editevent($eid);
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
		saveevent($eid,$title,$url,$datestart,$dateend,$location,$description,$owner_id,$group_id,$private_flag);
		break;
	case "edit":
		site_header('menu');
		editevent($eid);
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
