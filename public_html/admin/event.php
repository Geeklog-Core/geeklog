<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | event.php                                                                 |
// | Geeklog event administration page.                                        |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
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
// $Id: event.php,v 1.8 2001/10/29 17:35:50 tony_bibbs Exp $

include('../lib-common.php');
include('auth.inc.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

$display = '';

// Ensure user even has the rights to access this page
if (!SEC_hasRights('event.edit')) {
    $display .= COM_siteHeader('menu');
    $display .= COM_startBlock($MESSAGE[30]);
    $display .= $MESSAGE[35];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();

    // Log attempt to error.log
    COM_errorLog("User {$_USER['username']} tried to illegally access the event administration screen",1);

    echo $display;

    exit;
}

/**
* Shows event editor
*
* $mode         string      Indicates if this is a submission or an regular entry
* $eid          string      ID of event to edit
*
*/
function editevent($mode, $eid='') 
{
	global $_TABLES, $LANG22, $_CONF, $LANG_ACCESS, $_USER;

    $retval = '';

	$retval .= COM_startBlock($LANG22[1]);

    $event_templates = new Template($_CONF['path_layout'] . 'admin/event');
    $event_templates->set_file('editor','eventeditor.thtml');
    $event_templates->set_var('site_url', $_CONF['site_url']);

	if ($mode <> 'editsubmission' AND !empty($eid)) {
		$result = DB_query("SELECT * FROM {$_TABLES['events']} WHERE eid ='$eid'");
		$A = DB_fetchArray($result);

        // Get what level of access user has to this object
		$access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
		if ($access == 0 OR $access == 2) {
            // Uh, oh!  User doesn't have access to this object
            $retval .= COM_startBlock($LANG22[16]);
            $retval .=  $LANG22[17];
            $retval .= COM_endBlock();
            return $retval ;
        }
	} else {
		if ($mode == 'editsubmission') {
			$result = DB_query ("SELECT * FROM {$_TABLES['eventsubmission']} WHERE eid = '$eid'");
            $A = DB_fetchArray($result);
		}
		$A['owner_id'] = $_USER['uid'];
		$A['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Event Admin'");
		$A['perm_owner'] = 3;
        $A['perm_group'] = 3;
        $A['perm_members'] = 2;
        $A['perm_anon'] = 2;
		$access = 3;
	}

	if ($A['eid'] == '') { 
		$A['eid'] = COM_makesid(); 
	}

    if (!empty($eid) && SEC_hasRights('event.edit')) {
        $event_templates->set_var('delete_option', '<input type="submit" value="delete" name="mode">');
    }

    $event_templates->set_var('event_id', $A['eid']);
    $event_templates->set_var('lang_eventtitle', $LANG22[3]);
    $event_templates->set_var('event_title', $A['title']);
    $event_templates->set_var('lang_eventurl', $LANG22[4]);
    $event_templates->set_var('event_url', $A['url']);
    $event_templates->set_var('lang_includehttp', $LANG22[9]);
    $event_templates->set_var('lang_eventstartdate', $LANG22[5]);
    $event_templates->set_var('event_startdate', $A['datestart']);
    $event_templates->set_var('lang_eventenddate', $LANG22[6]);
    $event_templates->set_var('event_enddate', $A['dateend']);
    $event_templates->set_var('lang_eventlocation', $LANG22[7]);
    $event_templates->set_var('event_location', $A['location']);
    $event_templates->set_var('lang_eventdescription', $LANG22[8]);
    $event_templates->set_var('event_description', $A['description']); 

	// user access info
    $event_templates->set_var('lang_accessrights', $LANG_ACCESS[accessrights]);
    $event_templates->set_var('lang_owner', $LANG_ACCESS[owner]);
    $event_templates->set_var('owner_username', DB_getItem($_TABLES['users'],'username',"uid = {$A['owner_id']}"));
    $event_templates->set_var('owner_id', $A['owner_id']);
    $event_templates->set_var('lang_group', $LANG_ACCESS[group]);

    $groupdd = '';
    $usergroups = SEC_getUserGroups();
	if ($access == 3) {
		$groupdd .= '<select name="group_id">';
        for ($i = 0; $i < count($usergroups); $i++) {
            $groupdd .= '<option value="' . $usergroups[key($usergroups)] . '"';
            if ($A['group_id'] == $usergroups[key($usergroups)]) {
                $groupdd .= ' selected="selected"';
            }
            $groupdd .= '>' . key($usergroups) . '</option>';
            next($usergroups);
        }
        $groupdd.= '</select>';
	} else {
		// they can't set the group then
        $groupdd .= DB_getItem($_TABLES['groups'],'grp_name',"grp_id = {$A['group_id']}");
		$groupdd .= '<input type="hidden" name="group_id" value="' . $A['group_id'] . '">';
	}
    $event_templates->set_var('group_dropdown', $groupdd);
    $event_templates->set_var('lang_permissions', $LANG_ACCESS[permissions]);
    $event_templates->set_var('lang_permissionskey', $LANG_ACCESS[permissionskey]);
    $event_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $event_templates->parse('output', 'editor');
    $retval .= $event_templates->finish($event_templates->get_var('output'));
	$retval .= COM_endBlock();
    return $retval;
}

###############################################################################
# Svaes the events evente database
/**
* Saves an event to the database
*
* @eid          string          Event ID
* @title        string          Event Title
* @url          string          URL for the event
* @datestart    string          Date the event begins on
* @dateend      string          Date the event ends on
* @location     string          Where the event will be held at
* @description  string          Description about the event
* @owner_id     string          ID of owner
* @group_id     string          ID of group event belongs to
* @perm_owner   string          Permissions the owner has on event
* @perm_group   string          Permissions the groups has on the event
* @perm_members string          Permisssions members have on the event
* @perm_anon    string          Permissions anonymous users have
*
*/
function saveevent($eid,$title,$url,$datestart,$dateend,$location,$description,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) 
{
	global $_TABLES, $_CONF, $LANG22;

	// clean 'em up 
	$description = addslashes(COM_checkHTML(COM_checkWords($description)));
	$title = addslashes(COM_checkHTML(COM_checkWords($title)));
	$title = addslashes(COM_checkHTML(COM_checkWords($location)));

	if (!empty($eid) && !empty($description) && !empty($title)) {
		DB_delete($_TABLES['eventsubmission'],'eid',$eid);

		// Convert array values to numeric permission values
        list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);

		DB_save($_TABLES['events'],'eid,title,url,datestart,dateend,location,description,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',"$eid,'$title','$url','$datestart','$dateend','$location','$description',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon",'admin/event.php?msg=17');
	} else {
		$retval .= COM_siteHeader('menu');
		COM_errorLog($LANG22[10],2);
		$retval .= editevent($mode,$eid);
		$retval .= COM_siteFooter();
        return $retval;
	}
}

/**
* lists all the events in the system
*
*/
function listevents() 
{
	global $_TABLES, $LANG22,$_CONF,$LANG_ACCESS;

    $retval = '';

	$retval .= COM_startBlock($LANG22[11]);

    $event_templates = new Template($_CONF['path_layout'] . 'admin/event');
    $event_templates->set_file(array('list'=>'eventlist.thtml','row'=>'listitem.thtml'));
    $event_templates->set_var('site_url', $_CONF['site_url']);
    $event_templates->set_var('lang_newevent', $LANG22[18]);
    $event_templates->set_var('lang_adminhome', $LANG22[19]);
    $event_templates->set_var('lang_instructions', $LANG22[12]);
    $event_templates->set_var('lang_eventtitle', $LANG22[13]);
    $event_templates->set_var('lang_access', $LANG_ACCESS[access]);
    $event_templates->set_var('lang_startdate', $LANG22[14]);
    $event_templates->set_var('lang_enddate', $LANG22[15]);
    
	$result = DB_query("SELECT * FROM {$_TABLES['events']} ORDER BY datestart");
	$nrows = DB_numRows($result);
	for ($i = 0;$i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access > 0) {
            if ($access == 3) {
                $access = $LANG_ACCESS[edit];
            } else {
                $access = $LANG_ACCESS[readonly];
            }
        } else {
                $access = $LANG_ACCESS[none];
        }
        $event_templates->set_var('event_id', $A['eid']);
        $event_templates->set_var('event_title', $A['title']);
        $event_templates->set_var('event_access', $access);
        $event_templates->set_var('event_startdate', $A['datestart']);
        $event_templates->set_var('event_enddate', $A['dateend']); 
        $event_templates->parse('event_row', 'row', true);
	}
    $event_templates->parse('output', 'list');
    $retval .= $event_templates->finish($event_templates->get_var('output'));
	$retval .= COM_endBlock();
    return $retval;
}

###############################################################################
# MAIN
switch ($mode) {
	case 'delete':
		DB_delete($_TABLES['events'],'eid',$eid,'/admin/event.php?msg=18');
		break;
	case 'save':
		$display .= saveevent($eid,$title,$url,$datestart,$dateend,$location,$description,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
		break;
	case 'editsubmission':
		$display .= COM_siteHeader('menu');
		$display .= editevent($mode,$id);
		$display .= COM_siteFooter();
		break;
	case 'edit':
		$display .= COM_siteHeader('menu');
		$display .= editevent($mode,$eid);
		$display .= COM_siteFooter();
		break;
	case 'cancel':
	default:
		$display .= COM_siteHeader('menu');
		$display .= COM_showMessage($msg);
		$display .= listevents();
		$display .= COM_siteFooter();
		break;
}

echo $display;

?>
