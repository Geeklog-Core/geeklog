<?php

###############################################################################
# group.php
# This is the admin groups interface!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com 
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

if (!hasrights('group.edit')) {
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

function editgroup($grp_id="") {
	global $CONF,$USER,$LANG_ACCESS;

	startblock($LANG_ACCESS[groupeditor]);
	if (!empty($grp_id)) {
		$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}groups where grp_id ='$grp_id'");
		$A = mysql_fetch_array($result);
	} else {
		$A["owner_id"] = $USER["uid"];
		#this is the one instance where we default the group
		#most topics should belong to the normal user group 
		# and the private flag should be turned OFF
		$A["group_id"] = getitem('groups','grp_id',"grp_name = 'Normal User'");
		$A["private_flag"] == 0;
	}
	print "<form action={$CONF["site_url"]}/admin/group.php method=post>";
	print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
	print "<tr><td colspan=2><input type=submit value=save name=mode> ";
	print "<input type=submit value=cancel name=mode> ";
	if (!empty($grp_id)) {
		if ($A["grp_gl_core"] == 0) {
			#Groups tied to Geeklogs functionality shouldn't be deleted
			print "<input type=submit value=delete name=mode>";
			print "<input type=\"hidden\" name=\"grp_gl_core\" value=\"1\">";
		} else {
			print "<input type=\"hidden\" name=\"grp_gl_core\" value=\"0\">";
		}
		print "<input type=hidden name=\"grp_id\" value=\"{$A["grp_id"]}\">";
	} else {
		print "<input type=\"hidden\" name=\"grp_gl_core\" value=\"0\">";
	}
		print "<tr></td>";
	if ($A["grp_gl_core"] == 0) {	
		print "<tr><td align=\"right\">{$LANG_ACCESS[groupname]}:</td><td><input type=\"text\" size=\"20\" maxlength=\"50\" name=\"grp_name\" value=\"{$A["grp_name"]}\"></td></tr>";
	} else {
		print "<tr><td align=\"right\">{$LANG_ACCESS[groupname]}:</td><td>{$A["grp_name"]}</td><input type=\"hidden\" name=\"grp_name\" value=\"{$A["grp_name"]}\"></tr>";
	}
	print "<tr><td align=\"right\">{$LANG_ACCESS[description]}:</td><td><input type=\"text\" size=\"40\" maxlength=\"255\" name=\"grp_descr\" value=\"{$A["grp_descr"]}\"></td></tr>";
	
	#If this is a not Root user (e.g. Group Admin) and they are editing a 
	#Root user then bail...they can't change groups
	if (!ingroup('Root') AND (getitem('groups','grp_name',"grp_id = $grp_id") == "Root")) {
		print "</tr></tr>";
		print "</table></form>";
		endblock();
		return;
	} else {
		print "<tr><td colspan=\"2\"><hr></td></tr>";
		print "<tr><td colspan=\"2\"><b>{$LANG_ACCESS[rights]}</b></td></tr>";
		if ($A["grp_gl_core"] == 1) {
			print "<tr><td colspan=\"2\">{$LANG_ACCESS[corerightsdescr]}</td></tr>";
		} else {
			print "<tr><td colspan=\"2\">{$LANG_ACCESS[rightsdescr]}</td></tr>";
		}
		print "<tr><td colspan=\"2\" width=\"100%\">";
		printrights($grp_id,$A["grp_gl_core"]);
		print "</tr></tr>";
                print "<tr><td colspan=\"2\"><hr></td></tr>";
		print "<tr><td colspan=\"2\"><b>{$LANG_ACCESS[securitygroups]}</b></td></tr>";
		$groups = getusergroups('','',$grp_id);
		if ($A["grp_gl_core"] == 1) {
			if (is_array($groups)) {
                       		$selected = implode(',',$groups);
               		} else {
                       		$selected = '';
               		}
			print "<tr><td colspan=\"2\">{$LANG_ACCESS[coregroupmsg]}</td></tr>";
			$result= dbquery("SELECT grp_name FROM groups WHERE grp_id <> $grp_id AND grp_id in ($selected) ORDER BY grp_name");
			$nrows = mysql_num_rows($result);
			print "<tr><td colspan=\"2\">&nbsp;</td></tr>";
			for ($i=1;$i<=$nrows;$i++) {
				$GRPS = mysql_fetch_array($result);
				print "<tr><td colspan=\"2\">{$GRPS["grp_name"]}</td></tr>";	
			} 	
		} else {
			if (is_array($groups)) {
                       		$selected = implode(' ',$groups);
               		} else {
                       		$selected = '';
               		}
			print "<tr><td colspan=\"2\">{$LANG_ACCESS[groupmsg]}</td></tr>";
			print "<tr><td colspan=\"2\" width=\"100%\">";

			#Only Root users can give rights to Root
			if (ingroup('Root')) {
				checklist('groups','grp_id,grp_name',"grp_id <> $grp_id",$selected);
			} else {
				checklist('groups','grp_id,grp_name',"grp_id <> $grp_id AND grp_name <> 'Root'",$selected);
			}
		}

		print "</tr></tr>";
		print "</table></form>";
		endblock();
		return;
	}

}

function printrights($grp_id="",$core=0) {
	global $VERBOSE,$USER;

	# this gets a bit complicated so bare with the comments

	#first query for all available features
	$features = dbquery("SELECT * FROM features ORDER BY ft_name");
	$nfeatures = mysql_num_rows($features);

	if (!empty($grp_id)) {
		#now get all the feature this group gets directly
 		$directfeatures = dbquery("SELECT acc_ft_id,ft_name FROM access,features WHERE ft_id = acc_ft_id AND acc_grp_id = $grp_id",1);

		#now in many cases the features will be give to this user indirectly via membership
		#to another group.  These are not editable and must, instead, be removed from that group
		# directly
		$indirectfeatures = getuserpermissions($grp_id);
		$indirectfeatures = explode(",",$indirectfeatures);

		#Build an array of indirect features
		for ($i=0;$i<sizeof($indirectfeatures);$i++) {		
			$grpftarray[current($indirectfeatures)] = 'indirect'; 
			next($indirectfeatures);
		}

		#Build an arrray of direct features	
		$ndirect = mysql_num_rows($directfeatures);
		for ($i=1;$i<=$ndirect;$i++) {
			$A = mysql_fetch_array($directfeatures);
			$grpftarray1[$A["ft_name"]] = 'direct'; 
		}

		#Now merge the two	
		$grpftarray = array_merge($grpftarray,$grpftarray1);

		if ($VERBOSE) {
			#this is for debugging purposes
			for ($i=1;$i<sizeof($grpftarray);$i++) {
				errorlog("element $i is feature " . key($grpftarray) . " and is " . current($grpftarray),1);
				next($grpftarray); 
			}
		}

	} 

	#OK, now loop through and print all the features giving edit rights to only the ones that
	#are direct features
	print "\n\n<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n<tr>";	
	for ($i=1;$i<=$nfeatures;$i++) {		
		if ($i > 0 AND ($i % 3 == 1)) {
			print "</tr>\n<tr>";
		}
		$A = mysql_fetch_array($features);
		if ((($grpftarray[$A["ft_name"]] == 'direct') OR empty($grpftarray[$A["ft_name"]])) AND ($core == 0)) {
			print "\n<td><input type=\"checkbox\" name=\"features[]\" value=\"{$A["ft_id"]}\"";
			if ($grpftarray[$A["ft_name"]] == 'direct') {
				print " CHECKED";
			} 
			print "> {$A["ft_name"]}</td>";
		} else {
			#either this is an indirect right OR this is a core feature
			if ((($core == 1) AND ($grpftarray[$A["ft_name"]] == 'indirect' OR $grpftarray[$A["ft_name"]] == 'direct')) OR ($core == 0)) {
				print "<td>{$A["ft_name"]}</td>";
			}
		}
	}
	print "</tr>\n</table>";
}
###############################################################################
# Saves $grp_id to the database

function savegroup($grp_id,$grp_name,$grp_descr,$grp_gl_core,$features,$groups) {
	global $CONF,$LANG_ACCESS;

	if (!empty($grp_name) && !empty($grp_descr)) {
		if (empty($grp_id)) {
			dbquery("REPLACE INTO groups (grp_name, grp_descr,grp_gl_core) VALUES ('$grp_name', '$grp_descr',$grp_gl_core)");
		} else {
			dbquery("REPLACE INTO groups (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ($grp_id,'$grp_name', '$grp_descr',$grp_gl_core)");
		}

		if (empty($grp_id)) {
			$grp_id = getitem('groups','grp_id',"grp_name = '$grp_name'");
		}

		#now save the features
		dbquery("DELETE FROM access WHERE acc_grp_id = $grp_id");
		for ($i=1;$i<=sizeof($features);$i++) {
			dbquery("INSERT INTO access (acc_ft_id,acc_grp_id) VALUES (" . current($features) . ",$grp_id)");
			next($features);
		}

		if (is_array($groups)) {
                        if ($VERBOSE) errorlog("deleting all group_assignments for group $grp_id/$grp_name",1);
                        dbquery("DELETE FROM group_assignments WHERE ug_grp_id = $grp_id");
                        if (!empty($groups)) {
                                for ($i=1;$i<=sizeof($groups);$i++) {
                                        if ($VERBOSE) errorlog("adding group_assignment " . current($groups) . " for $grp_name",1);
                                        $sql = "INSERT INTO group_assignments (ug_main_grp_id, ug_grp_id) VALUES (" . current($groups) . ",$grp_id)";
                                        dbquery($sql);
                                        next($groups);
                                }
                        }
                }
		refresh($CONF['site_url'] . '/admin/group.php?msg=13');
	} else {
		site_header('menu');
		startblock($LANG_ACCESS[missingfields]);
		print $LANG_ACCESS[missingfieldsmsg];
		endblock();
		editgroup($grp_id);
		site_footer();
	}
}

###############################################################################
# Displays a list of topics

function listgroups() {
	global $CONF,$LANG_ACCESS;
        startblock($LANG_ACCESS[groupmanager]);
        adminedit("group",$LANG_ACCESS[newgroupmsg]);
        print "<table border=0 cellspacing=0 cellpadding=2 width=100%>";
        print "<tr><th align=left>{$LANG_ACCESS[groupname]}</th><th>{$LANG_ACCESS[description]}</th><th>{$LANG_ACCESS[coregroup]}</th></tr>";
        $result = dbquery("SELECT * FROM {$CONF["db_prefix"]}groups");
        $nrows = mysql_num_rows($result);
        for ($i=0;$i<$nrows;$i++) {
                $A = mysql_fetch_array($result);
		if ($A["grp_gl_core"] == 1) {
			$core = $LANG_ACCESS[yes];
		} else {
			$core = $LANG_ACCESS[no];
		}
                print "<tr align=center><td align=left><a href={$CONF["site_url"]}/admin/group.php?mode=edit&grp_id={$A["grp_id"]}>" . stripslashes($A["grp_name"]) . "</a></td>";
                print "<td>" . stripslashes($A["grp_descr"]) . "</td><td>$core</td></tr>";
        }
        print "</table></form>";
        endblock();

}

###############################################################################
# MAIN

switch ($mode) {
	case "delete":
		dbdelete("access","acc_grp_id",$grp_id);
		dbdelete("groups","grp_id",$grp_id,"/admin/group.php?msg=14");
		break;
	case "save":
		savegroup($grp_id,$grp_name,$grp_descr,$grp_gl_core,$features,$groups);
		break;
	case "edit":
		site_header("menu");
		editgroup($grp_id);
		site_footer();
		break;
	case "cancel":
	default:
		site_header("menu");
		showmessage($msg);
		listgroups();
		site_footer();
		break;
}

?>
