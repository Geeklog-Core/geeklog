<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | poll.php                                                                  |
// | Geeklog poll administration page                                          |
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
// $Id: poll.php,v 1.12 2002/04/11 22:14:01 tony_bibbs Exp $

// Set this to true if you want to log debug messages to error.log
$_POLL_VERBOSE = false;

include("../lib-common.php");
include('auth.inc.php');

$display = '';

if (!SEC_hasRights('poll.edit')) {
    $display .= COM_siteHeader('menu');
    $display .= COM_startBlock($MESSAGE[30]);
    $display .= $MESSAGE[36];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    $display .= COM_errorLog("User {$_USER['username']} tried to illegally access the poll administration screen",1);
    echo $display;
    exit;
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

/**
* Saves a poll
*
* Saves a poll question and potential answers to the database
*
* @qid              string          Question ID
* @display          int             Flag to indicate if poll appears on homepage
* @question         string          The text for the question
* @voters           int             Number of votes
* @statuscode       string          ??
* @commentcode      string          Indicates if users can comment on poll
* @A                array           Array of possible answers
* @V                array           Array of vote per each answer 
* @owner_id         int             ID of poll owner
* @group_id         int             ID of group poll belongs to
* @perm_owner       int             Permissions the owner has on poll
* @perm_grup        int             Permissions the group has on poll
* @perm_members     int             Permissions logged in members have on poll
* @perm_anon        int             Permissions anonymous users have on poll
*
*/
function savepoll($qid,$mainpage,$question,$voters,$statuscode,$commentcode,$A,$V,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) 
{ 
    global $_TABLES, $LANG25, $_CONF, $_POLL_VERBOSE;

    if ($_POLL_VERBOSE) {
        COM_errorLog('**** Inside savepoll() in admin/poll.php ***');
    }

    if (empty($voters)) { 
        $voters = '0'; 
    }

    // Convert array values to numeric permission values
    list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);

    if ($_POLL_VERBOSE) {
        COM_errorLog('owner permissions: ' . $perm_owner, 1);
        COM_errorLog('group permissions: ' . $perm_group, 1);
        COM_errorLog('member permissions: ' . $perm_member, 1);
        COM_errorLog('anonymous permissions: ' . $perm_anon, 1);
    }

    DB_delete($_TABLES['pollquestions'],'qid',$qid);
    DB_delete($_TABLES['pollanswers'],'qid',$qid);

    $sql = "'$qid','$question',$voters,'" . date("Y-m-d H:i:s");

    if ($mainpage == 'on') { 
        $sql .= "',1";
    } else {
        $sql .= "',0";
    }

    $sql .= ",'$statuscode','$commentcode',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon";

    // Save poll question
    DB_setDebug(true);
    DB_save($_TABLES['pollquestions'],"qid, question, voters, date, display, statuscode, commentcode, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon",$sql);
    DB_setDebug(false);

    // Save poll answers
    for ($i = 0; $i < sizeof($A); $i++) {
        if (!empty($A[$i])) {
            if (empty($V[$i])) { 
                $V[$i] = "0"; 
            }
            DB_save($_TABLES['pollanswers'],'qid, aid, answer, votes',"'$qid', $i+1, '$A[$i]', $V[$i]");
        }
    }

    if ($_POLL_VERBOSE) {
        COM_errorLog('**** Leaving savepoll() in admin/poll.php ***');
    }

    echo COM_refresh($_CONF['site_admin_url'] . '/poll.php?msg=19');
}

/**
* Shows poll editor
*
* Diplays the poll editor form
*
* @qid      string      ID of poll to edit
*
*/
function editpoll($qid='') 
{
    global $_TABLES, $LANG25, $_CONF, $_USER, $LANG_ACCESS;

    $retval .= '';

    $retval .= COM_startBlock($LANG25[5]);

    $poll_templates = new Template($_CONF['path_layout'] . 'admin/poll');
    $poll_templates->set_file(array('editor'=>'polleditor.thtml','answer'=>'pollansweroption.thtml'));
    $poll_templates->set_var('site_url', $_CONF['site_url']);
    $poll_templates->set_var('site_admin_url', $_CONF['site_admin_url']);

    if (!empty($qid)) {
        $question = DB_query("SELECT * FROM {$_TABLES["pollquestions"]} WHERE qid='$qid'");
        $answers = DB_query("SELECT answer,aid,votes FROM {$_TABLES["pollanswers"]} WHERE qid='$qid'");
        $Q = DB_fetchArray($question);

        // Get permissions for poll
    
        $access = SEC_hasAccess($Q['owner_id'],$Q['group_id'],$Q['perm_owner'],$Q['perm_group'],$Q['perm_members'],$Q['perm_anon']);
    
        if ($access == 0 OR $access == 2) {
            // User doesn't have access...bail
            $retval .= COM_startBlock($LANG25[21]);
            $retval .= $retval .=   $LANG25[22];
            $retval .= COM_endBlock();
            return $retval;
        }
    }

    if (!empty($qid) AND $access == 3) {
        $poll_templates->set_var('delete_option', '<input type="submit" name="mode" value="delete">');
    } else {
        $Q['owner_id'] = $_USER['uid'];
	    $Q['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Poll Admin'");
        $Q['perm_owner'] = 3;
        $Q['perm_group'] = 3;
        $Q['perm_members'] = 2;
        $Q['perm_anon'] = 2;
        $Q['statuscode'] = 0;
        $Q['commentcode'] = 0;
        $access = 3;
    }

    $poll_templates->set_var('lang_pollid', $LANG25[6]);
    $poll_templates->set_var('poll_id', $Q['qid']);
    $poll_templates->set_var('lang_donotusespaces', $LANG25[7]);
    $poll_templates->set_var('lang_question', $LANG25[9]);
    $poll_templates->set_var('poll_question', $Q['question']);
    $poll_templates->set_var('lang_mode', $LANG25[1]);
    $poll_templates->set_var('status_options', COM_optionList($_TABLES['statuscodes'],'code,name',$Q['statuscode'])); 
    $poll_templates->set_var('comment_options', COM_optionList($_TABLES['commentcodes'],'code,name',$Q['commentcode']));
    $poll_templates->set_var('lang_appearsonhomepage', $LANG25[8]);

    if ($Q['display'] == 1) { 
        $poll_templates->set_var('poll_display', 'checked');
    }

    // user access info 
    $poll_templates->set_var('lang_accessrights', $LANG_ACCESS[accessrights]);
    $poll_templates->set_var('lang_owner', $LANG_ACCESS[owner]);
    $poll_templates->set_var('owner_username', DB_getItem($_TABLES['users'],'username',"uid = {$Q['owner_id']}"));
    $poll_templates->set_var('owner_id', $Q['owner_id']);
    $poll_templates->set_var('lang_group', $LANG_ACCESS[group]);
   
    $groupdd = ''; 
    $usergroups = SEC_getUserGroups();
    if ($access == 3) {
        $groupdd .= '<select name="group_id">';
        for ($i = 0; $i < count($usergroups); $i++) {
            $groupdd .= '<option value="' . $usergroups[key($usergroups)] . '"';
            if ($Q['group_id'] == $usergroups[key($usergroups)]) {
                $groupdd .= ' selected';
            }
            $groupdd .=  '>' . key($usergroups) . '</option>';
            next($usergroups);
        }
        $groupdd .=  '</SELECT>';
    } else {
        // they can't set the group then
        $groupdd .= DB_getItem($_TABLES['groups'],'grp_name',"grp_id = {$Q['group_id']}");
        $groupdd .= '<input type="hidden" name="group_id" value="' . $A['group_id'] . '">';
    }
    $poll_templates->set_var('group_dropdown', $groupdd);
    $poll_templates->set_var('lang_permissions', $LANG_ACCESS[permissions]);
    $poll_templates->set_var('lang_permissoinskey', $LANG_ACCESS[permissionskey]);
    $poll_templates->set_var('permissions_editor', SEC_getPermissionsHTML($Q['perm_owner'],$Q['perm_group'],$Q['perm_members'],$Q['perm_anon']));
    $poll_templates->set_var('lang_permissions_msg', $LANG_ACCESS[permmsg]);
    $poll_templates->set_var('lang_answersvotes', $LANG25[10]);   
 
    for ($i = 0; $i < $_CONF['maxanswers']; $i++) {
        $A = DB_fetchArray($answers);
        $poll_templates->set_var('answer_text', $A['answer']);
        $poll_templates->set_var('answer_votes', $A['votes']);
        $poll_templates->parse('answer_option','answer',true);
    }

    $poll_templates->parse('output','editor');
    $retval .= $poll_templates->finish($poll_templates->get_var('output'));

    $retval .= COM_endBlock();

    return $retval;
}

/**
* lists existing polls
*
*/
function listpoll() 
{
    global $_TABLES, $_CONF, $LANG25, $LANG_ACCESS;

    $retval = '';

    $retval .= COM_startBlock($LANG25[18]);

    $poll_templates = new Template($_CONF['path_layout'] . 'admin/poll');
    $poll_templates->set_file(array('list'=>'polllist.thtml','row'=>'listitem.thtml'));
    $poll_templates->set_var('site_url', $_CONF['site_url']);
    $poll_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $poll_templates->set_var('layout_url', $_CONF['layout_url']);
    $poll_templates->set_var('lang_newpoll', $LANG25[23]);
    $poll_templates->set_var('lang_adminhome', $LANG25[24]);
    $poll_templates->set_var('lang_instructions', $LANG25[19]);
    $poll_templates->set_var('lang_question', $LANG25[9]);
    $poll_templates->set_var('lang_access', $LANG_ACCESS[access]);
    $poll_templates->set_var('lang_voters',  $LANG25[20]);
    $poll_templates->set_var('lang_pollcreated', $LANG25[3]);
    $poll_templates->set_var('lang_appearsonhomepage', $LANG25[8]);
 
    $result = DB_query("SELECT * FROM {$_TABLES['pollquestions']}");
    $nrows = DB_numRows($result);
    for ($i = 0; $i < $nrows; $i++) {
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
        $curtime = COM_getUserDateTimeFormat($A["date"]); 
        if ($A['display'] == 1) {
            $A['display'] = $LANG25[25];
        } else {
            $A['display'] = $LANG25[26];
        }
        $poll_templates->set_var('question_id', $A['qid']);
        $poll_templates->set_var('poll_question', $A['question']);
        $poll_templates->set_var('poll_access', $access);
        $poll_templates->set_var('poll_votes', $A['voters']);
        $poll_templates->set_var('poll_createdate', $curtime[0]);
        $poll_templates->set_var('poll_homepage', $A['display']);
        $poll_templates->parse('poll_row','row',true);
    }
    $poll_templates->parse('output', 'list');
    $retval .= $poll_templates->finish($poll_templates->get_var('output'));
    $retval .= COM_endBlock();

    return $retval;
}

// MAIN

$display = '';

switch($mode) {
case 'edit':
    $display .= COM_siteHeader('menu');
    $display .= editpoll($qid);
    $display .= COM_siteFooter();
    break;
case 'save':
    //if (!empty($A[0])) {
    if (!empty($qid)) {
        $voters = 0;
        for ($i = 0; $i < sizeof($answer); $i++) {
            $voters = $voters + $votes[$i];
        }
        savepoll($qid,$mainpage,$question,$voters,$statuscode,$commentcode,$answer,$votes,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
    }
    break;
case 'delete':
    if (!empty($qid)) {
        DB_delete($_TABLES['pollquestions'],'qid',$qid);
        DB_delete($_TABLES['pollanswers'],'qid',$qid);
        echo COM_refresh($_CONF['site_admin_url'] . '/poll.php?msg=20');
    }
case cancel:
default:
    $display .= COM_siteHeader('menu');
    $display .= COM_showMessage($msg);
    $display .= listpoll();
    $display .= COM_siteFooter();
}

echo $display;

?>
