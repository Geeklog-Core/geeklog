<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | group.php                                                                 |
// |                                                                           |
// | Geeklog group administration page.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
// $Id: group.php,v 1.28 2003/06/28 11:24:45 dhaun Exp $

/**
* This file is the Geeklog Group administration page
*
* @author   Tony Bibbs  <tony@tonybibbs.com>
*
*/

/**
* Geeklog common function library
*/
require_once('../lib-common.php');

/**
* Verifies that current user even has access to the page to this point
*/
require_once('auth.inc.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($HTTP_POST_VARS);

$display = '';

// Make sure user has rights to access this page 
if (!SEC_hasRights('group.edit')) {
    $display .= COM_siteHeader ('menu');
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[32];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    echo $display;
    exit;
}

/**
* Shows the group editor form
*
* @param    string      $grp_id     ID of group to edit
* @return   string      HTML for group editor
*
*/
function editgroup($grp_id = '') 
{
    global $_TABLES, $_CONF, $_USER, $LANG_ACCESS;

    $retval = '';

    $group_templates = new Template($_CONF['path_layout'] . 'admin/group');
    $group_templates->set_file('editor','groupeditor.thtml');
    $group_templates->set_var('site_url', $_CONF['site_url']);
    $group_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $group_templates->set_var('layout_url', $_CONF['layout_url']);
    $group_templates->set_var('lang_save', $LANG_ACCESS['save']);
    $group_templates->set_var('lang_cancel', $LANG_ACCESS['cancel']);

	if (!empty($grp_id)) {
		$result = DB_query("SELECT * FROM {$_TABLES['groups']} WHERE grp_id ='$grp_id'");
		$A = DB_fetchArray($result);

	    // If this is a not Root user (e.g. Group Admin) and they are editing the 
	    // Root root then bail...they can't change groups
		if (!SEC_inGroup('Root') AND (DB_getItem($_TABLES['groups'],'grp_name',"grp_id = $grp_id") == "Root")) {
            $retval .= COM_startBlock ($LANG_ACCESS['groupeditor'], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
            $retval .= $LANG_ACCESS['canteditroot'];
			$retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
			return $retval;
		}
	} else {
		$A['owner_id'] = $_USER['uid'];

		// this is the one instance where we default the group
		// most topics should belong to the normal user group 
		$A['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Normal User'");
		$A['grp_gl_core'] = 0;
	}

    $retval .= COM_startBlock ($LANG_ACCESS['groupeditor'], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

	if (!empty($grp_id)) {
		if ($A['grp_gl_core'] == 0) {
			// Groups tied to Geeklogs functionality shouldn't be deleted
            $group_templates->set_var('delete_option', '<input type="submit" value="' . $LANG_ACCESS['delete'] . '" name="mode">');
            $group_templates->set_var('group_core', 0);
		} else {
            $group_templates->set_var('group_core', 1);
		}
		$group_templates->set_var('group_id', $A['grp_id']);
	} else {
        $group_templates->set_var('group_core', 0);
	}

    $group_templates->set_var('lang_groupname', $LANG_ACCESS['groupname']);

	if ($A['grp_gl_core'] == 0) {	
        $group_templates->set_var('groupname_inputtype', 'text');
        $group_templates->set_var('groupname_static', '');
	} else {
        $group_templates->set_var('groupname_inputtype', 'hidden');
        $group_templates->set_var('groupname_static', $A['grp_name']);
	}
    $group_templates->set_var('group_name', $A['grp_name']);

    $group_templates->set_var('lang_description', $LANG_ACCESS['description']);
    $group_templates->set_var('group_description', $A['grp_descr']);
    $group_templates->set_var('lang_securitygroups', $LANG_ACCESS['securitygroups']);

	//$groups = SEC_getUserGroups('','',$grp_id);
    if (!empty($grp_id)) {
        $tmp = DB_query("SELECT ug_main_grp_id FROM {$_TABLES['group_assignments']} WHERE ug_grp_id = $grp_id"); 
        $num_groups = DB_numRows($tmp);
        for ($x = 1; $x <= $num_groups; $x++) {
            $G = DB_fetchArray($tmp);
            if ($x > 1) {
                $selected .= ' ' . $G['ug_main_grp_id'];
            } else {
                $selected .= $G['ug_main_grp_id'];
            }
        }
    }
	if ($A['grp_gl_core'] == 1) {
        $group_templates->set_var('lang_securitygroupmsg', $LANG_ACCESS['coregroupmsg']);

		if (!empty($selected)) {
            $inclause = str_replace(' ',',',$selected);
			$result= DB_query("SELECT grp_id,grp_name FROM {$_TABLES['groups']} WHERE grp_id <> $grp_id AND grp_id in ($inclause) ORDER BY grp_name");
		    $nrows = DB_numRows($result);
		} else {
			$nrows = 0;
		}

		if ($nrows == 0) {
			// this group doesn't belong to anything...give a friendly message
            $group_templates->set_var('group_options', $LANG_ACCESS['nogroupsforcoregroup']);
		} else {
            $groupoptions = '';
            for ($i = 1; $i <= $nrows; $i++) {
                $GRPS = DB_fetchArray($result);
                $groupoptions .= $GRPS['grp_name'] . '<input type="hidden" name="groups[]" value="' . $GRPS['grp_id'] . '"><br>' .LB;
            }
            $group_templates->set_var('group_options', $groupoptions);
        }
	} else {
        $group_templates->set_var('lang_securitygroupmsg', $LANG_ACCESS['groupmsg']);
        COM_errorLog("SELECTED: $selected");
		// You can no longer give access to the Root group....it's pointless and doesn't
        // make any sense
        if (!empty($grp_id)) {
            $group_templates->set_var('group_options', COM_checkList($_TABLES['groups'],'grp_id,grp_name',"grp_id <> $grp_id AND grp_name <> 'Root'",$selected));
        } else {
            $group_templates->set_var('group_options', COM_checkList($_TABLES['groups'],'grp_id,grp_name',"grp_name <> 'Root'",''));
        }
	}
    $group_templates->set_var('lang_rights', $LANG_ACCESS['rights']);

	if ($A['grp_gl_core'] == 1) {
        $group_templates->set_var('lang_rightsmsg', $LANG_ACCESS['corerightsdescr']);
	} else {
        $group_templates->set_var('lang_rightsmsg', $LANG_ACCESS['rightsdescr']);
	}

	$group_templates->set_var('rights_options', printrights($grp_id, $A['grp_gl_core']));
    $group_templates->parse('output','editor');
    $retval .= $group_templates->finish($group_templates->get_var('output'));
	$retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

	return $retval;
}


/**
* Get the indirect features for a group, i.e. a list of all the features
* that this group inherited from other groups.
*
* @param    int      $grp_id   ID of group
* @return   string   comma-separated list of feature names
*
*/
function getIndirectFeatures ($grp_id)
{
    global $_TABLES;

    $checked = array ();
    $tocheck = array ($grp_id);

    do {
        $grp = array_pop ($tocheck);

        $result = DB_query ("SELECT ug_main_grp_id FROM {$_TABLES['group_assignments']} WHERE ug_grp_id = $grp AND ug_uid IS NULL");
        $numrows = DB_numRows ($result);

        $checked[] = $grp;

        for ($j = 0; $j < $numrows; $j++) {
            $A = DB_fetchArray ($result);
            if (!in_array ($A['ug_main_grp_id'], $checked) &&
                !in_array ($A['ug_main_grp_id'], $tocheck)) {
                $tocheck[] = $A['ug_main_grp_id'];
            }
        }
    }
    while (sizeof ($tocheck) > 0);

    // get features for all groups in $checked
    $glist = join (',', $checked);
    $result = DB_query("SELECT DISTINCT ft_name FROM {$_TABLES['access']},{$_TABLES['features']} WHERE ft_id = acc_ft_id AND acc_grp_id IN ($glist)");
    $nrows = DB_numRows ($result);

    $retval = '';
    for ($j = 1; $j <= $nrows; $j++) {
        $A = DB_fetchArray ($result);
        $retval .= $A['ft_name'];
        if ($j < $nrows) {
            $retval .= ',';
        }
    }

    return $retval;
}

/**
* Prints the features a group has access.  Please follow the comments in the
* code closely if you need to modify this function. Also right is synonymous
* with feature.
*
* @param    mixed       $grp_id     ID to print rights for
* @param    boolean     $core       indicates if group is a core Geeklog group
* @return   string      HTML for rights
*
*/
function printrights($grp_id='', $core=0) 
{
	global $_TABLES, $VERBOSE, $_USER, $LANG_ACCESS;

	// $VERBOSE = true;
	// this gets a bit complicated so bear with the comments
	// first query for all available features
	$features = DB_query("SELECT * FROM {$_TABLES['features']} ORDER BY ft_name");
	$nfeatures = DB_numRows($features);

	if (!empty($grp_id)) {
		// now get all the feature this group gets directly
 		$directfeatures = DB_query("SELECT acc_ft_id,ft_name FROM {$_TABLES['access']},{$_TABLES['features']} WHERE ft_id = acc_ft_id AND acc_grp_id = $grp_id",1);

        // now in many cases the features will be given to this user indirectly
        // via membership to another group.  These are not editable and must,
        // instead, be removed from that group directly
		$indirectfeatures = getIndirectFeatures ($grp_id);
		$indirectfeatures = explode(',',$indirectfeatures);

		// Build an array of indirect features
		for ($i = 0; $i < sizeof($indirectfeatures); $i++) {		
			$grpftarray[current($indirectfeatures)] = 'indirect'; 
			next($indirectfeatures);
		}

		// Build an arrray of direct features	
		$ndirect = DB_numRows($directfeatures);
		for ($i = 1; $i <= $ndirect; $i++) {
			$A = DB_fetchArray($directfeatures);
			$grpftarray1[$A['ft_name']] = 'direct'; 
		}

		// Now merge the two arrays	
		$grpftarray = array_merge($grpftarray,$grpftarray1);
		if ($VERBOSE) {
			// this is for debugging purposes
			for ($i = 1; $i < sizeof($grpftarray); $i++) {
				COM_errorLog("element $i is feature " . key($grpftarray) . " and is " . current($grpftarray),1);
				next($grpftarray); 
			}
		}
	} 

	// OK, now loop through and print all the features giving edit rights
    // to only the ones that are direct features
	$ftcount = 0;
    $retval = '<tr>' . LB;
	for ($i = 1; $i <= $nfeatures; $i++) {		
		if ($i > 0 AND ($i % 3 == 1)) {
			$retval .= "</tr>\n<tr>";
		}
		$A = DB_fetchArray($features);

		if ((($grpftarray[$A['ft_name']] == 'direct') OR empty($grpftarray[$A['ft_name']])) AND ($core == 0)) {
			$ftcount++;
			$retval .= '<td><input type="checkbox" name="features[]" value="'. $A['ft_id'] . '"';
			if ($grpftarray[$A['ft_name']] == 'direct') {
				$retval .= ' CHECKED';
			} 
			$retval .= '>' . $A['ft_name'] . '</td>';
		} else {
			// either this is an indirect right OR this is a core feature
			if ((($core == 1) AND ($grpftarray[$A['ft_name']] == 'indirect' OR $grpftarray[$A['ft_name']] == 'direct')) OR ($core == 0)) {
				$ftcount++;
                $retval .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<i>' .  $A['ft_name'] . '</i>)</td>';
			}
		}
	}
	if ($ftcount == 0) {
		// This group doesn't have rights to any features
		$retval .= '<td colspan="3">' . $LANG_ACCESS['grouphasnorights'] . '</td>';
	}
    
	$retval .= '</tr>' . LB;

    return $retval;
}

/**
* Save a group to the database
*
* @param    string  $grp_id         ID of group to save
* @param    string  $grp_name       Group Name
* @param    string  $grp_descr      Description of group
* @param    boolean $grp_gl_core    Flag that indicates if this is a core Geeklog group
* @param    array   $features       Features the group has access to
* @param    array   $groups         Groups this group will belong to
* @return   string  Either empty string on success (cause of refresh) or HTML for some sort of error
*
*/
function savegroup($grp_id,$grp_name,$grp_descr,$grp_gl_core,$features,$groups) 
{
	global $_TABLES, $_CONF, $LANG_ACCESS;

    if (!empty($grp_name) && !empty($grp_descr)) {
        if ($grp_gl_core == 1 AND !is_array($features)) {
            print COM_errorLog("sorry, no valid features were passed to this core group and saving could cause problem...bailing");
            exit;
        }
        $grp_descr = COM_stripslashes ($grp_descr);
        $grp_descr = addslashes ($grp_descr);
        if (empty($grp_id)) {
            DB_query("REPLACE INTO {$_TABLES['groups']} (grp_name, grp_descr,grp_gl_core) VALUES ('$grp_name', '$grp_descr',$grp_gl_core)");
        } else {
            DB_query("REPLACE INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES ($grp_id,'$grp_name', '$grp_descr',$grp_gl_core)");
        }
        if (empty($grp_id)) {
            $grp_id = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = '$grp_name'");
        }

        // now save the features
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_grp_id = $grp_id");
        for ($i = 1; $i <= sizeof($features); $i++) {
            DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id,acc_grp_id) VALUES (" . current($features) . ",$grp_id)");
            next($features);
        }
        COM_errorLog('groups = ' . $groups);
        if ($VERBOSE) COM_errorLog("deleting all group_assignments for group $grp_id/$grp_name",1);
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_grp_id = $grp_id");
        if (!empty($groups)) {
            for ($i = 1; $i <= sizeof($groups); $i++) {
                if ($VERBOSE) COM_errorLog("adding group_assignment " . current($groups) . " for $grp_name",1);
                $sql = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_grp_id) VALUES (" . current($groups) . ",$grp_id)";
                DB_query($sql);
                next($groups);
            }
        }

        // Make sure Root group belongs to any new group
        if (DB_getItem($_TABLES['group_assignments'], 'count(*)',"ug_main_grp_id = $grp_id AND ug_grp_id = 1") == 0) {
            DB_query("INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_grp_id) VALUES ($grp_id, 1)");
        }

		echo COM_refresh($_CONF['site_admin_url'] . '/group.php?msg=49');
	} else {
		$retval .= COM_siteHeader ('menu');
		$retval .= COM_startBlock ($LANG_ACCESS['missingfields'], '',
                           COM_getBlockTemplate ('_msg_block', 'header'));
		$retval .= $LANG_ACCESS['missingfieldsmsg'];
		$retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
		$retval .= editgroup ($grp_id);
		$retval .= COM_siteFooter ();

        return $retval;
	}   
}

/**
* Lists all the groups in the system
*
* @return   string  HTML for group listing
*
*/
function listgroups() 
{
    global $_TABLES, $_CONF, $LANG_ACCESS;

    $retval .= COM_startBlock ($LANG_ACCESS['groupmanager'], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $group_templates = new Template($_CONF['path_layout'] . 'admin/group');
    $group_templates->set_file(array('list'=>'grouplist.thtml','row'=>'listitem.thtml'));
    $group_templates->set_var('site_url', $_CONF['site_url']);
    $group_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $group_templates->set_var('layout_url', $_CONF['layout_url']);
    $group_templates->set_var('lang_newgroup', $LANG_ACCESS['newgroup']);
    $group_templates->set_var('lang_adminhome', $LANG_ACCESS['adminhome']);
    $group_templates->set_var('lang_instructions', $LANG_ACCESS['newgroupmsg']); 
    $group_templates->set_var('lang_groupname', $LANG_ACCESS['groupname']);
    $group_templates->set_var('lang_description', $LANG_ACCESS['description']);
    $group_templates->set_var('lang_coregroup', $LANG_ACCESS['coregroup']);
    $group_templates->set_var('lang_list_users', $LANG_ACCESS['listusers']);

    $result = DB_query("SELECT * FROM {$_TABLES['groups']}");
    $nrows = DB_numRows($result);
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        if ($A['grp_gl_core'] == 1) {
            $core = $LANG_ACCESS['yes'];
        } else {
            $core = $LANG_ACCESS['no'];
        }
        $group_templates->set_var('group_id', $A['grp_id']);
        $group_templates->set_var('group_name', $A['grp_name']);
        $group_templates->set_var('group_description', $A['grp_descr']);
        $group_templates->set_var('group_core', $core);
        $group_templates->set_var('lang_list', $LANG_ACCESS['listthem']);
        $group_templates->parse('group_row', 'row', true);
    }
    $group_templates->parse('output', 'list');
    $retval .= $group_templates->finish($group_templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Get a list (actually an array) of all groups this group belongs to.
*
* @param   basegroup   int     id of group
* @return              array   array of all groups 'basegroup' belongs to
*
*/
function getGroupList ($basegroup)
{
    global $_TABLES;

    $to_check = array ();
    array_push ($to_check, $basegroup);

    $checked = array ();

    while (sizeof ($to_check) > 0) {
        $thisgroup = array_pop ($to_check);
        if ($thisgroup > 0) {
            $result = DB_query ("SELECT ug_grp_id FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $thisgroup");
            $numGroups = DB_numRows ($result);
            for ($i = 0; $i < $numGroups; $i++) {
                $A = DB_fetchArray ($result);
                if (!in_array ($A['ug_grp_id'], $checked)) {
                    if (!in_array ($A['ug_grp_id'], $to_check)) {
                        array_push ($to_check, $A['ug_grp_id']);
                    }
                }
            }
            $checked[] = $thisgroup;
        }
    }

    return $checked;
}

/**
* Display a list of all users in a given group.
*
* @param   grp_id        int      group id
* @param   curpage       int      page number
* @param   query_limit   int      users per page
* @return                string   HTML for user listing
*
*/
function listusers ($grp_id, $curpage = 1, $query_limit = 50)
{
    global $_TABLES, $_CONF, $LANG28, $LANG_ACCESS;

    $retval = '';

    if ($curpage <= 0) {
        $curpage = 1;
    }
    if ($query_limit == 0) {
        $limit = 50;
    } else {
        $limit = $query_limit;
    }
    $offset = (($curpage - 1) * $limit);

    $groups = getGroupList ($grp_id);
    $groupList = implode (',', $groups);

    $sql = "FROM {$_TABLES['users']},{$_TABLES['group_assignments']} WHERE {$_TABLES['users']}.uid > 1 AND {$_TABLES['users']}.uid = {$_TABLES['group_assignments']}.ug_uid AND ({$_TABLES['group_assignments']}.ug_main_grp_id IN ({$groupList}))";
    $result = DB_query ("SELECT DISTINCT uid,username,fullname,email " . $sql
                        . " ORDER BY username LIMIT $offset,$limit");
    $nrows = DB_numRows ($result);

    $cntresult = DB_query ("SELECT COUNT(DISTINCT {$_TABLES['users']}.uid) AS count " . $sql);
    $C = DB_fetchArray ($cntresult);
    $num_pages = ceil ($C['count'] / $limit);

    $headline = sprintf ($LANG_ACCESS['usersingroup'],
                         DB_getItem ($_TABLES['groups'], 'grp_name',
                         "grp_id = '$grp_id'"));
    $retval .= COM_startBlock ($headline . ' (' . $C['count'] . ')', '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $user_templates = new Template ($_CONF['path_layout'] . 'admin/user');
    $user_templates->set_file (array ('list' => 'plainlist.thtml',
                                      'row' => 'listitem.thtml'));
    $user_templates->set_var ('site_url', $_CONF['site_url']);
    $user_templates->set_var ('site_admin_url', $_CONF['site_admin_url']);
    $user_templates->set_var ('layout_url', $_CONF['layout_url']);
    $user_templates->set_var ('lang_adminhome', $LANG28[16]);
    $user_templates->set_var ('lang_username', $LANG28[3]);
    $user_templates->set_var ('lang_fullname', $LANG28[4]);
    $user_templates->set_var ('lang_emailaddress', $LANG28[7]);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray ($result);
        $user_templates->set_var ('user_id', $A['uid']);
        $user_templates->set_var ('username', $A['username']);
        $user_templates->set_var ('user_fullname', $A['fullname']);
        $user_templates->set_var ('user_email', $A['email']);
        $user_templates->parse ('user_row', 'row', true);
    }

    if ($num_pages > 1) {
        $base_url = $_CONF['site_admin_url']
                  . '/group.php?mode=listusers&amp;grp_id=' . $grp_id;
        $user_templates->set_var ('google_paging',
                COM_printPageNavigation ($base_url, $curpage, $num_pages));    
    } else {
        $user_templates->set_var ('google_paging', '');
    }
    $user_templates->parse ('output', 'list');
    $retval .= $user_templates->finish ($user_templates->get_var ('output'));

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

// MAIN
if (($mode == $LANG_ACCESS['delete']) && !empty ($LANG_ACCESS['delete'])) {
    if (!isset ($grp_id) || empty ($grp_id) || ($grp_id == 0)) {
        COM_errorLog ('Attempted to delete group grp_id=' . $grp_id);
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/group.php');
    } else {
        DB_delete($_TABLES['access'],'acc_grp_id',$grp_id);
        DB_delete($_TABLES['groups'],'grp_id',$grp_id);
        $display = COM_refresh($_CONF['site_admin_url'] . '/group.php?msg=50');
    }
} else if (($mode == $LANG_ACCESS['save']) && !empty ($LANG_ACCESS['save'])) {
    $display .= savegroup($grp_id,$grp_name,$grp_descr,$grp_gl_core,$features,
            $HTTP_POST_VARS[$_TABLES['groups']]);
} else if ($mode == 'edit') {
    $display .= COM_siteHeader('menu');
    $display .= editgroup($grp_id);
    $display .= COM_siteFooter();
} else if ($mode == 'listusers') {
    $display .= COM_siteHeader ('menu');
    $display .= listusers ($grp_id, $page);
    $display .= COM_siteFooter ();
}
else { // 'cancel' or no mode at all
    $display .= COM_siteHeader('menu');
    $display .= COM_showMessage($msg);
    $display .= listgroups();
    $display .= COM_siteFooter();
}

echo $display;

?>
