<?php
###############################################################################
# block.php
# This is the admin blocks interface!
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
include("../lib-common.php");
include("auth.inc.php");

if (!hasrights('block.edit')) {
	$display .= site_header()
		.startblock($MESSAGE[30])
		.$MESSAGE[31]
		.endblock()
		.site_footer();
	echo $display;
	exit;
}

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

function editdefaultblock($A,$access) {
	global $USER,$LANG21,$CONF,$LANG_ACCESS;

	$retval .= startblock($LANG21[3])
		.'<form action="'.$CONF['site_url'].'/admin/block.php" method="post">'
		.'<table border="0" cellspacing="0" cellpadding="3" width="100%">'.LB
		.'<tr>'.LB
		.'<td colspan="2"><input type="submit" value="save" name="mode"> '
		.'<input type="submit" value="cancel" name="mode"> '
		.'<input type="hidden" name="bid" value="'.$A['bid'].'></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[5].'</td>'.LB
		.'<td>'.$A['title'].'</td>'.LB
		.'</tr>'.LB
		.'<input type="hidden" name="title" value="'.$A['title'].'"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[6].'</td>'
		.'<td>all<input type="hidden" name="tid" value="all"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[39].':</td>'.LB
		.'<td><select name="onleft">'.LN
		.'<option value="1"';
	if ($A['onleft'] == 1) {
		$retval .= ' selected="selected"';
	}
	$retval .= '>'.$LANG21[40].'</option>'.LB
		.'<option value="0"';
	if ($A['onleft'] == 0) {
		$retval .= ' selected="selected"';
	}
	$retval .= '>'.$LANG21[41].'</option>'
		.'</select></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[9].':</td>'.LB
		.'<td><input type="text" size="3" name="blockorder" value="'.$A['blockorder'].'"> 0 - 255</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[10].':</td>'.LB
		.'<td>gldefault<input type="hidden" name="type" value="gldefault"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><hr></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><b>'.$LANG_ACCESS['accessrights'].'</b></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG_ACCESS['owner'].':</td>'.LB
		.'<td>'.getitem('users','username',"uid = '{$A['owner_id']}'")
		.'<input type="hidden" name="owner_id" value="'.$A['owner_id'].'"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG_ACCESS['group'].':</td>'.LB
		.'<td>';
		
	$usergroups = getusergroups();
	if ($access == 3) {
		$retval .= '<select name="group_id">';
		for ($i=0;$i<count($usergroups);$i++) {
			$retval .= '<option value="'.$usergroups[key($usergroups)];
			if ($A['group_id'] == $usergroups[key($usergroups)]) {
				$retval .= ' selected="selected"';
			}
			$retval .= '>'.key($usergroups).'</option>'.LB;
			next($usergroups);
		}
		$retval .= '</select>'.LB;
	} else {
		// They can't set the group then
		
		$retval .= getitem('groups','grp_name',"grp_id = '{$A['group_id']}'")
			.'<input type="hidden" name="group_id" value="'.$A['group_id'].'">';
	}

	$retval .= '</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><b>'.$LANG_ACCESS['permissions'].':</b></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2">'.$LANG_ACCESS['permissionskey'].'</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2">'.getpermissionshtml($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']).'</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2">'.$LANG_ACCESS['permmsg'].'<td>'.LB
		.'</tr>'.LB
		.'</table></form>'
		.endblock();
	
	return $retval;
}

###############################################################################
# Displays the edit block form

function editblock($bid='') {
	global $USER,$LANG21,$CONF,$LANG_ACCESS;

	if (!empty($bid)) {
		$result = dbquery("SELECT * FROM {$CONF['db_prefix']}blocks where bid ='$bid'");
		$A = mysql_fetch_array($result);
		$access = hasaccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
		if ($access == 2 || $access == 0) {
			$retval .= startblock($LANG21[44])
				.$LANG21[45]
				.endblock();

			return $retval;
		} 
		if ($A['type'] == 'gldefault') {
			$retval .= editdefaultblock($A,$access);
			return $retval;
		}
	} else {
		$A['bid'] = 0;
		$A['blockorder'] = 0;
		$A['owner_id'] = $USER['uid'];
		$A['perm_owner'] = 3;
		$A['perm_group'] = 3;
		$A['perm_members'] = 2;
		$A['perm_anon'] = 2;
		$access = 3;
	}

	$retval .= startblock($LANG21[3])
		.'<form action="'.$CONF['site_url'].'/admin/block.php" method="post">'
		.'<table border="0" cellspacing="0" cellpadding="3" width="100%">'.LB
		.'<tr>'.LB
		.'<td colspan="2"><input type="submit" value=save name=mode> '
		.'<input type="submit" value="cancel" name="mode"> ';
		
	if ($A['type'] != 'layout') {
		if (!empty($bid) && hasrights('block.edit'))
			$retval .= '<input type="submit" value="delete" name="mode">';
	}
	
	$retval .= '<input type="hidden" name="bid" value="'.$A['bid'].'"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[5].':</td>'.LB
		.'<td><input type="text" size="48" name="title" value="'.$A['title'].'\"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[6].':</td>'.LB
		.'<td><select name="tid">'.LB
		.'<option value="all">'.$LANG21[7].'</option>'.LB
		.'<option value="homeonly"';
	if ($A['tid'] == 'homeonly') {
		$retval .= ' selected="selected"';
	}
	$retval .= '>'.$LANG21[43].'</option>'.LB
		.optionlist('topics','tid,topic',$A['tid'])
		.'</select></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[39].':</td>'.LB
		.'<td><select name="onleft">'.LB
		.'<option value="1"';
	if ($A['onleft'] == 1) {
		$retval .= ' selected="selected"';
	}
	$retval .= '>'.$LANG21[40].'</option>'.LB
		.'<option value="0"';
	if ($A['onleft'] == 0) {
		$retval .= ' selected="selected"';
	}
	$retval .= '>'.$LANG21[41].'</option>'.LB
		.'</select></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[9].':</td>'.LB
		.'<td><input type="text" size="3" name="blockorder" value="'.$A['blockorder'].'"> 0 - 255</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[10].':</td>'.LB
		.'<td><select name="type">'.LB
		.'<option value="portal"';
	if ($A['type'] == 'portal') {
		$retval .= ' selected="selected"';
	}
	$retval .= '>'.$LANG21[11].'</option>'.LB
		.'<option value="normal"';
	if ($A['type'] == 'normal') {
		$retval .= ' selected="selected"';
	}
	$retval .= '>'.$LANG21[12].'</option>'.LB
		.'<option value="layout"';
	if ($A['type'] == 'layout') {
		$retval .= ' selected="selected"';
	}
	$retval .= '>'.$LANG21[26].'</option>'.LB
		.'<option value="phpblock"';
	if ($A['type'] == 'phpblock') {
		$retval .= ' selected="selected"';
	}
	$retval .= '>'.$LANG21[27].'</option>'.LB
		.'</select></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><hr></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><b>'.$LANG_ACCESS['accessrights'].'</b></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG_ACCESS['owner'].':</td>'.LB
		.'<td>'.getitem('users','username',"uid = '{$A['owner_id']}'")
		.'<input type="hidden" name="owner_id" value="'.$A['owner_id'].'"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG_ACCESS['group'].':</td>'.LD
		.'<td>';
		
	$usergroups = getusergroups();

	if ($access == 3) {
		$retval .= '<select name="group_id">';
		for ($i=0;$i<count($usergroups);$i++) {
			$retval .= '<option value="'.$usergroups[key($usergroups)].'"';
			if ($A['group_id'] == $usergroups[key($usergroups)]) {
				$retval .= ' selected="selected"';
			}
			$retval .= '>'.key($usergroups).'</option>';
			next($usergroups);
		}
		$retval .= '</select>'.LB;
	} else {
		// They can't set the group then
		
		$retval .= getitem('groups','grp_name',"grp_id = '{$A['group_id']}'")
			.'<input type="hidden" name="group_id" value="'.$A['group_id'].'">';
	}
	
	$retval .= '</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><b>'.$LANG_ACCESS['permissions'].':</b></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2">'.$LANG_ACCESS['permissionskey'].'</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2">'.getpermissionshtml($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']).'</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2">'.$LANG_ACCESS['permmsg'].'<td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><hr></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><b>'.$LANG21[28].'</b></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[29].':</td>'.LB
		.'<td><input type="text" size="50" maxlength="50" name="phpblockfn" value="'.$A['phpblockfn'].'"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2">'.$LANG21[30].'</td>'.LB
		.'</tr>'.LB
		.'<tr><td colspan="2"><hr></td></tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><b>'.$LANG21[13].'</b></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[14].':</td>'.LB
		.'<td><input type="text" size="50" maxlength="96" name="rdfurl" value="'.$A['rdfurl'].'"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG21[15].':</td>'.LB
		.'<td><input type="text" size="19" name="rdfupdated" value="'.$A['rdfupdated'].'"></td>'.LB
		.'</tr>'.LB
		.'<tr><td colspan="2"><hr></td></tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2"><b>'.$LANG21[16].'</b></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right" valign="top">'.$LANG21[17].':</td>'.LB
		.'<td><textarea name="content" cols="50" rows="8" wrap="virtual">'.$A['content'].'</textarea></td>'.LB
		.'</tr>'.LB
		.'</table></form>'
		.endblock();
		
	return $retval;
}

###############################################################################
# Saves the block to the database

function saveblock($bid,$title,$type,$blockorder,$content,$tid,$rdfurl,$rdfupdated,$phpblockfn,$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) {
	global $CONF,$LANG21,$LANG01,$HTTP_POST_VARS;

	if (($type == "normal" && !empty($title) && !empty($content)) OR ($type == "portal" && !empty($title) && !empty($rdfurl)) OR ($type == "layout" && !empty($content)) OR ($type == "gldefault" && (strlen($blockorder)>0)) OR ($type == "phpblock" && !empty($phpblockfn) && !empty($title))) {
		if ($type == "portal") {
			$content = "";
			$phpblockfn = "";
		}
		if ($type == "gldefault") {
			$content = "";
			$rdfurl = "";
			$rdfupdated = "";
			$phpblockfn = "";
		}
		if ($type == "phpblock") {
			if (!(stristr($phpblockfn,'phpblock_'))) {
				// This is a BAD function name, must have phpblock_ prefix
				$retval .= site_header()
					.startblock($LANG21[37])
					.$LANG21[38]
					.endblock()
					.editblock($bid)
					.site_footer();
				return $retval;
			}
			$content = '';
			$rdfurl = '';
			$rdfupdated = '';
		}
		if ($type == 'normal') {
			$rdfurl = '';
			$rdfupdated = '';
			$phpblockfn = '';
		}
		if ($type == 'layout') {
			$rdfurl = '';
			$rdfupdated = '';
			$phpblockfn = '';
		}
		// Convert array values to numeric permission values
		
		list($perm_owner,$perm_group,$perm_members,$perm_anon) = getpermissionvalues($perm_owner,$perm_group,$perm_members,$perm_anon);
	
		dbsave('blocks','bid,title,type,blockorder,content,tid,rdfurl,rdfupdated,phpblockfn,onleft,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',"$bid,'$title','$type','$blockorder','$content','$tid','$rdfurl','$rdfupdated','$phpblockfn',$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon","admin/block.php?msg=11");

	} else {
		$retval .= site_header()
			.startblock($LANG21[32]);
		if ($type == 'portal') {
			// Portal block is missing fields
			$retval .= $LANG21[33];
		} else if ($type == 'phpblock') {
			// PHP Block is missing field
			$retval .= $LANG21[34];
		} else if ($type == 'normal') {
			// Normal block is missing field
			$retval .= $LANG21[35];
		} else if ($type == 'gldefault') {
			// Default geeklog field missing 
			$retval .= $LANG21[42];
		} else {
			// Layout block missing content
			$retval .= $LANG21[36];
		}
		$retval .= endblock()
			.editblock($bid)
			.site_footer();
	}
	
	return $retval;
}

###############################################################################
# Displays a list of existing blocks

function listblocks() {
	global $LANG21,$CONF,$LANG_ACCESS;

	$retval .= startblock($LANG21[19])
		.adminedit('block',$LANG21[25])
		.'<table border="0" cellspacing="0" cellpadding="2" width="100%">'.LB
		.'<tr align="center">'.LB
		.'<td align="left"><b>'.$LANG21[20].'</b></td>'.LB
		.'<td><b>'.$LANG_ACCESS['access'].'</b></td>'.LB
		.'<td><b>'.$LANG21[22].'</b></td>'.LB
		.'<td><b>'.$LANG21[39].'</b></td>'.LB
		.'<td><b>'.$LANG21[23].'</b></td>'.LB
		.'<td><b>'.$LANG21[24].'</b></td>'.LB
		.'</tr>'.LB;
		
	#$result = dbquery("SELECT bid,title,type,blockorder,tid,onleft FROM {$CONF['db_prefix']}blocks ORDER BY type,title asc");
	$result = dbquery("SELECT * FROM {$CONF['db_prefix']}blocks ORDER BY onleft DESC,blockorder");
	$nrows = mysql_num_rows($result);

	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
		$access = hasaccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
		if ($access > 0) {
			if ($access == 3) {
				$access = $LANG_ACCESS[edit];
			} else {
				$access = $LANG_ACCESS[readonly];
			}
		} else {
			$access = $LANG_ACCESS[none];
		}
		if ($A['onleft'] == 1) {
			$side = $LANG21[40];
		} else {
			$side = $LANG21[41];
		}
		if ($A['type'] == 'layout') {
			$side = '-';
			$A['blockorder'] = '-';
			$A[4] = '-';
			$A[5] = '-';
		}

		$retval .= '<tr align="center">'.LB
			.'<td align="left"><a href="'.$CONF['site_url'].'/admin/block.php?mode=edit&bid='.$A[0].'">'.$A[1].'</a></td>'.LB
			.'<td>'.$access.'</td>'.LB
			.'<td>'.$A['type'].'</td>'.LB
			.'<td>'.$side.'</td>'.LB
			.'<td>'.$A['blockorder'].'</td>'.LB
			.'<td>'.$A['tid'].'</td>'.LB
			.'</tr>'.LB;
	}
	$retval .= '</table>'
		.endblock();
		
	return $retval;
}

###############################################################################
# MAIN

switch ($mode) {
	case 'delete':
		$display .= dbdelete('blocks','bid',$bid,'/admin/block.php?msg=12');
		break;
	case 'save':
		$display .= saveblock($bid,$title,$type,$blockorder,$content,$tid,$rdfurl,$rdfupdated,$phpblockfn,$onleft,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
		break;
	case 'edit':
		$display .= site_header()
			.editblock($bid)
			.site_footer();
		break;
	case 'cancel':
	default:
		$display .= site_header()
			.showmessage($msg)
			.listblocks()
			.site_footer();
		break;
}

echo $display;
?>
