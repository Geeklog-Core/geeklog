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
// $Id: poll.php,v 1.8 2001/10/17 23:35:48 tony_bibbs Exp $

// Set this to true if you want to log debug messages to error.log
$_POLL_VERBOSE = true;

include("../lib-common.php");
include('auth.inc.php');

$display = '';

if (!SEC_hasRights('poll.edit')) {
    $display .= site_header('menu');
    $display .= COM_startBlock($MESSAGE[30]);
    $display .= $MESSAGE[36];
    $display .= COM_endBlock();
    $display .= site_footer();
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
function savepoll($qid,$display,$question,$voters,$statuscode,$commentcode,$A,$V,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) 
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
    if (!empty($display)) { 
        $sql .= "',$display";
    } else {
        $sql .= "',0";
    }

    $sql .= ",'$statuscode','$commentcode',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon";

    // Save poll question
    DB_save($_TABLES['pollquestions'],"qid, question, voters, date, display, statuscode, commentcode, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon",$sql);

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
	COM_errorLog('refreshing to: ' . $_CONF['site_url'] . '/admin/poll.php?msg=19');
        COM_errorLog('**** Leaving savepoll() in admin/poll.php ***');
    }

    COM_refresh($_CONF['site_url'] . '/admin/poll.php?msg=19');
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

    $retval .= COM_startBlock($LANG25[5]);
    $retval .=  "<FORM ACTION={$_CONF['site_url']}/admin/poll.php METHOD=post>" . LB;
    $retval .=  '<table border="0" cellspacing="0" cellpadding=2 width="100%">' . LB;
    $retval .=  '<tr><td colspan="2"><INPUT type="submit" NAME=mode VALUE=save>' . LB;
    $retval .=  '<input type="submit" name=mode value=cancel> ' . LB;
    if (!empty($qid) AND $access == 3) {
        $retval .=  '<INPUT type="submit" NAME=mode VALUE=delete>';
    } else {
        $Q['owner_id'] = $_USER['uid'];
	$Q['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Poll Admin'");
	COM_errorLog("group_id in admin/poll.php is {$Q["group_id"]}",1);
        $Q['perm_owner'] = 3;
        $Q['perm_group'] = 3;
        $Q['perm_members'] = 2;
        $Q['perm_anon'] = 2;
        $Q['statuscode'] = 0;
        $Q['commentcode'] = 0;
        $access = 3;
    }
    $retval .= '</td></tr>' . LB;
    $retval .= '<tr><td align="right">' . $LANG25[6] . ':</td><td><INPUT TYPE=TEXT NAME=qid value="' . $Q["qid"] . '" SIZE="20"> ' 
        . $LANG25[7] . '</td></tr>' . LB;
    $retval .= '<tr><td align="right">'. $LANG25[9] .':</td><td><INPUT TYPE=TEXT NAME=question value="' . $Q["question"] 
        . '" SIZE=50 MAXLENGTH=255></td></tr>' . LB;
    $retval .= '</select></td></tr>' . LB;
    $retval .= '<tr><td align="right">' . $LANG25[1] . ':</td><td><select name=statuscode>' . LB;
    $retval .= COM_optionList($_TABLES['statuscodes'],'code,name',$Q["statuscode"]);
    $retval .= '</select>' . LB . '<select name=commentcode>' . LB;
    $retval .= COM_optionList($_TABLES['commentcodes'],'code,name',$Q["commentcode"]);
    $retval .= '</select></td></tr>' . LB;
    $retval .= '<tr><td align="right">' . $LANG25[8] . ':</td><td><INPUT TYPE=CHECKBOX NAME=display ';
    if ($Q['display'] == 1) { 
        $retval .=  'checked ';
    }
    $retval .= 'value="' . $Q['display'] . '"></td></tr>' . LB;
    // user access info 
    $retval .= '<tr><td colspan="2"><hr><td></tr>' . LB; 
    $retval .= '<tr><td colspan="2"><b>' . $LANG_ACCESS[accessrights] . '</b></td></tr>' . LB;
    $retval .= '<tr><td align="right">' . $LANG_ACCESS[owner] . ':</td><td>' 
        . DB_getItem($_TABLES['users'],'username',"uid = {$Q['owner_id']}") . LB;
    $retval .= '<input type="hidden" name=owner_id value=' . $Q['owner_id'] . '></td></tr>' . LB;
    $retval .= '<tr><td align="right">' . $LANG_ACCESS[group] . ':</td><td>' . LB;
    $usergroups = SEC_getUserGroups();
    if ($access == 3) {
        $retval .= '<SELECT name=group_id>';
        for ($i = 0; $i < count($usergroups); $i++) {
            $retval .= '<option value=' . $usergroups[key($usergroups)];
            if ($Q['group_id'] == $usergroups[key($usergroups)]) {
                $retval .= ' SELECTED';
            }
            $retval .=  '>' . key($usergroups) . '</option>';
            next($usergroups);
        }
        $retval .=  '</SELECT>';
    } else {
        // they can't set the group then
        $retval .= DB_getItem($_TABLES['groups'],'grp_name',"grp_id = {$Q['group_id']}");
        $retval .= '<input type="hidden" name="group_id" value="' . $A['group_id'] . '">';
    }
    $retval .= '</td><tr><tr><td colspan="2"><b>' . $LANG_ACCESS[permissions] . '</b>:</td></tr><tr><td colspan="2">';
    $retval .= '</td><tr><tr><td colspan="2">' . $LANG_ACCESS[permissionskey] . '</td></tr><tr><td colspan="2">';
    $retval .= SEC_getPermissionsHTML($Q['perm_owner'],$Q['perm_group'],$Q['perm_members'],$Q['perm_anon']);
    $retval .= '</td></tr>';
    $retval .= '<tr><td colspan="2">' . $LANG_ACCESS[permmsg] . '</td></tr>' . LB;	
    $retval .= '<tr><td colspan="2"><hr><td></tr>' . LB; 
    $retval .= '<tr><td align="right" valign="top">' . $LANG25[10] . ':</td><td>' . LB;
    for ($i = 0; $i < $_CONF['maxanswers']; $i++) {
        $A = DB_fetchArray($answers);
        $retval .= '<INPUT TYPE=text NAME="answer[]" value="' . $A['answer'] . '" SIZE=30 MAXLENGTH=255>' . LB;
        $retval .= ' / <INPUT TYPE=text NAME="votes[]" value="' . $A['votes'] . '" SIZE=5><BR>' . LB;
    }
    $retval .= '<td></tr>';
    $retval .= '</table></FORM>' . LB;
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
    $retval .= COM_adminEdit('poll',$LANG25[19]);
    $retval .= '<table border="0" cellspacing="0" cellpadding=2 width="100%">' . LB;
    $retval .= '<tr><th align="left">' . $LANG25[9] . '</th><th>' . $LANG_ACCESS[access] . '</th><th>' 
        . $LANG25[20] . '</th><th>' . $LANG25[3] . '</th><th>' . $LANG25[8] . '</th></tr>';
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
        if ($A[4] == 1) $A[4] = 'Y';
        $retval .= '<tr align="center"><td align="left"><a href="' . $_CONF['site_url'] 
            . '/admin/poll.php?mode=edit&qid=' . $A[0] . '">' . $A[1] . '</a></td>';
        $retval .= '<td>' . $access . '</td><td>' . $A[2] . '</td><td>' . $curtime[0] . '</td><td>' . $A[4] . '</td></tr>';
    }
    $retval .=  '</table>' . LB;
    $retval .= COM_endBlock();

    return $retval;
}

// MAIN

$display = '';

switch($mode) {
case 'save':
    if (!empty($A[0])) {
        $voters = 0;
        for ($i = 0; $i < sizeof($answer); $i++) {
            $voters = $voters + $votes[$i];
        }
        savepoll($qid,$display,$question,$voters,$statuscode,$commentcode,$answer,$votes,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
    }
    $display .= site_header('menu');
    $display .= COM_showMessage($msg);
    $display .= listpoll();
    $display .= site_footer();
    echo $display;
    break;
case 'edit':
    $display .= site_header('menu');
    $display .= editpoll($qid);
    $display .= site_footer();
    echo $display;
    break;
case 'delete':
    if (!empty($qid)) {
        DB_delete($_TABLES['pollquestions'],'qid',$qid);
        DB_delete($_TABLES['pollanswers'],'qid',$qid,'/admin/poll.php?msg=20');
    }
case cancel:
default:
    $display .= site_header('menu');
    $display .= COM_showMessage($msg);
    $display .= listpoll();
    $display .= site_footer();
    echo $display;
    break;
}

?>
