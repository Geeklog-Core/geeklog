<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog poll administration page                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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
// $Id: index.php,v 1.40 2006/12/12 09:50:03 ospiess Exp $

// Set this to true if you want to log debug messages to error.log
$_POLL_VERBOSE = false;

require_once ('../../../lib-common.php');
require_once ('../../auth.inc.php');

// number of polls to list per page
define ('POLLS_PER_PAGE', 50);

$display = '';

if (!SEC_hasRights ('polls.edit')) {
    $display .= COM_siteHeader ('menu', $MESSAGE[30]);
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[36];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    COM_accessLog ("User {$_USER['username']} tried to illegally access the poll administration screen.");
    echo $display;
    exit;
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

function listpolls()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG_ADMIN, $LANG25, $LANG_ACCESS;

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

    $retval = '';

    $header_arr = array(      # dislay 'text' and use table field 'field'
                    array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
                    array('text' => $LANG25[9], 'field' => 'question', 'sort' => true),
                    array('text' => $LANG25[20], 'field' => 'voters', 'sort' => true),
                    array('text' => $LANG_ACCESS['access'], 'field' => 'access', 'sort' => false),
                    array('text' => $LANG25[3], 'field' => 'unixdate', 'sort' => true),
                    array('text' => $LANG25[8], 'field' => 'display', 'sort' => true));

    $defsort_arr = array('field' => 'unixdate', 'direction' => 'desc');

    $menu_arr = array (
                    array('url' => $_CONF['site_admin_url'] . '/plugins/polls/index.php?mode=edit',
                          'text' => $LANG_ADMIN['create_new']),
                    array('url' => $_CONF['site_admin_url'],
                          'text' => $LANG_ADMIN['admin_home']));

    $text_arr = array('has_menu' => true,
                      'has_extras' => true,
                      'title' => $LANG25[18], 'instructions' => $LANG25[19],
                      'icon' => $_CONF['site_url'] . '/polls/images/polls.png',
                      'form_url' => $_CONF['site_admin_url'] . "/plugins/polls/index.php");

    $query_arr = array('table' => 'pollquestions',
                       'sql' => "SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['pollquestions']} WHERE 1=1",
                       'query_fields' => array('question'),
                       'default_filter' => COM_getPermSql ('AND'));

    $retval = ADMIN_list ('polls', 'plugin_getListField_polls', $header_arr,
                          $text_arr, $query_arr, $menu_arr, $defsort_arr);

    return $retval;
}

/**
* Saves a poll
*
* Saves a poll question and potential answers to the database
*
* @param    string  $qid            Question ID
* @param    int     $display        Flag to indicate if poll appears on homepage
* @param    string  $question       The text for the question
* @param    int     $voters         Number of votes
* @param    int     $statuscode     (unused)
* @param    int     $commentcode    Indicates if users can comment on poll
* @param    array   $A              Array of possible answers
* @param    array   $V              Array of vote per each answer
* @param    int     $owner_id       ID of poll owner
* @param    int     $group_id       ID of group poll belongs to
* @param    int     $perm_owner     Permissions the owner has on poll
* @param    int     $perm_grup      Permissions the group has on poll
* @param    int     $perm_members   Permissions logged in members have on poll
* @param    int     $perm_anon      Permissions anonymous users have on poll
* @return   string                  HTML redirect or error message
*
*/
function savepoll ($qid, $mainpage, $question, $voters, $statuscode, $commentcode, $A, $V, $R, $owner_id, $group_id, $perm_owner, $perm_group, $perm_members, $perm_anon)
{
    global $_CONF, $_TABLES, $LANG21, $LANG25, $MESSAGE, $_POLL_VERBOSE;

    $retval = '';

    // Convert array values to numeric permission values
    list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);

    $qid = COM_sanitizeID ($qid);

    $question = COM_stripslashes ($question);
    for ($i = 0; $i < sizeof ($A); $i++) {
        $A[$i] = COM_stripslashes ($A[$i]);
    }
    if (!empty ($question) && (sizeof ($A) > 0) && strlen ($A[0]) > 0) {

        if ($_POLL_VERBOSE) {
            COM_errorLog ('**** Inside savepoll() in '
                          . $_CONF['site_admin_url'] . '/plugins/polls/index.php ***');
        }

        $qid = str_replace (' ', '', $qid); // strip spaces from poll id

        $access = 0;
        if (DB_count ($_TABLES['pollquestions'], 'qid', $qid) > 0) {
            $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid = '{$qid}'");
            $P = DB_fetchArray ($result);
            $access = SEC_hasAccess ($P['owner_id'], $P['group_id'],
                    $P['perm_owner'], $P['perm_group'], $P['perm_members'],
                    $P['perm_anon']);
        } else {
            $access = SEC_hasAccess ($owner_id, $group_id, $perm_owner,
                                     $perm_group, $perm_members, $perm_anon);
        }
        if (($access < 3) || !SEC_inGroup ($group_id)) {
            $display .= COM_siteHeader ('menu', $MESSAGE[30]);
            $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
            $display .= $MESSAGE[31];
            $display .= COM_endBlock ();
            $display .= COM_siteFooter (COM_getBlockTemplate ('_msg_block',
                                                              'footer'));
            COM_accessLog("User {$_USER['username']} tried to illegally submit or edit poll $qid.");
            echo $display;
            exit;
        }

        if (empty ($voters)) {
            $voters = 0;
        }

        if ($_POLL_VERBOSE) {
            COM_errorLog('owner permissions: ' . $perm_owner, 1);
            COM_errorLog('group permissions: ' . $perm_group, 1);
            COM_errorLog('member permissions: ' . $perm_members, 1);
            COM_errorLog('anonymous permissions: ' . $perm_anon, 1);
        }

        DB_delete ($_TABLES['pollquestions'], 'qid', $qid);
        DB_delete ($_TABLES['pollanswers'], 'qid', $qid);

        $question = addslashes ($question);
        $sql = "'$qid','$question',$voters,'" . date ('Y-m-d H:i:s');

        if ($mainpage == 'on') {
            $sql .= "',1";
        } else {
            $sql .= "',0";
        }

        $sql .= ",'$statuscode','$commentcode',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon";

        // Save poll question
        DB_save($_TABLES['pollquestions'],"qid, question, voters, date, display, statuscode, commentcode, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon",$sql);

        // Save poll answers
        for ($i = 0; $i < sizeof($A); $i++) {
            if (strlen ($A[$i]) > 0) {
                if (empty($V[$i]) or !is_numeric($V[$i])) {
                    $V[$i] = "0";
                }
                $A[$i] = addslashes ($A[$i]);
                $R[$i] = addslashes ($R[$i]);
                DB_save ($_TABLES['pollanswers'], 'qid, aid, answer, votes, remark',
                         "'$qid', $i+1, '$A[$i]', $V[$i], '$R[$i]'");
            }
        }

        if ($_POLL_VERBOSE) {
            COM_errorLog ('**** Leaving savepoll() in '
                          . $_CONF['site_admin_url'] . '/plugins/polls/index.php ***');
        }

        return COM_refresh($_CONF['site_admin_url'] . '/plugins/polls/index.php?msg=19');

    } else {
        $retval .= COM_siteHeader ('menu', $LANG25[5]);
        $retval .= COM_startBlock ($LANG21[32], '',
                           COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= $LANG25[2];
        $retval .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval .= editpoll ($qid);
        $retval .= COM_siteFooter ();

        return $retval;
    }
}

/**
* Shows poll editor
*
* Diplays the poll editor form
*
* @param    string  $qid    ID of poll to edit
* @return   string          HTML for poll editor form
*
*/
function editpoll ($qid = '')
{
    global $_CONF, $_PO_CONF, $_GROUPS, $_TABLES, $_USER, $LANG25, $LANG_ACCESS,
           $LANG_ADMIN, $MESSAGE;

    $retval = '';

    $poll_templates = new Template ($_CONF['path']
                                    . 'plugins/polls/templates/admin/');
    $poll_templates->set_file (array ('editor' => 'polleditor.thtml',
                                      'answer' => 'pollansweroption.thtml'));
    $poll_templates->set_var ('site_url', $_CONF['site_url']);
    $poll_templates->set_var ('site_admin_url', $_CONF['site_admin_url']);
    $poll_templates->set_var ('layout_url', $_CONF['layout_url']);

    if (!empty ($qid)) {
        $question = DB_query("SELECT * FROM {$_TABLES['pollquestions']} WHERE qid='$qid'");
        $answers = DB_query("SELECT answer,aid,votes,remark FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY aid");
        $Q = DB_fetchArray($question);

        // Get permissions for poll

        $access = SEC_hasAccess($Q['owner_id'],$Q['group_id'],$Q['perm_owner'],$Q['perm_group'],$Q['perm_members'],$Q['perm_anon']);

        if ($access == 0 OR $access == 2) {
            // User doesn't have access...bail
            $retval .= COM_startBlock ($LANG25[21], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
            $retval .= $LANG25[22];
            $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            COM_accessLog("User {$_USER['username']} tried to illegally submit or edit poll $qid.");
            return $retval;
        }
    }

    $retval .= COM_startBlock ($LANG25[5], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    if (!empty ($qid) AND ($access == 3) AND !empty ($Q['owner_id'])) {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $poll_templates->set_var ('delete_option',
                                  sprintf ($delbutton, $jsconfirm));
        $poll_templates->set_var ('delete_option_no_confirmation',
                                  sprintf ($delbutton, ''));
    } else {
        $Q['qid'] = COM_makeSid ();
        $Q['question'] = '';
        $Q['voters'] = 0;
        $Q['display'] = 1;
        $Q['owner_id'] = $_USER['uid'];
        if (isset ($_GROUPS['Polls Admin'])) {
            $Q['group_id'] = $_GROUPS['Polls Admin'];
        } else {
            $Q['group_id'] = SEC_getFeatureGroup ('polls.edit');
        }
        SEC_setDefaultPermissions ($Q, $_PO_CONF['default_permissions']);
        $Q['statuscode'] = 0;
        $Q['commentcode'] = $_CONF['comment_code'];
        $access = 3;
    }

    $poll_templates->set_var('lang_pollid', $LANG25[6]);
    $poll_templates->set_var('poll_id', $Q['qid']);
    $poll_templates->set_var('lang_donotusespaces', $LANG25[7]);
    $poll_templates->set_var('lang_question', $LANG25[9]);
    $poll_templates->set_var('poll_question', htmlspecialchars ($Q['question']));
    $poll_templates->set_var('lang_mode', $LANG25[1]);
    $poll_templates->set_var ('status_options', COM_optionList ($_TABLES['statuscodes'], 'code,name', $Q['statuscode']));
    $poll_templates->set_var('comment_options', COM_optionList($_TABLES['commentcodes'],'code,name',$Q['commentcode']));
    $poll_templates->set_var('lang_appearsonhomepage', $LANG25[8]);

    if ($Q['display'] == 1) {
        $poll_templates->set_var('poll_display', 'checked="checked"');
    }

    // user access info
    $poll_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $poll_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $ownername = COM_getDisplayName ($Q['owner_id']);
    $poll_templates->set_var('owner_username', DB_getItem($_TABLES['users'],
                             'username', "uid = {$Q['owner_id']}"));
    $poll_templates->set_var('owner_name', $ownername);
    $poll_templates->set_var('owner', $ownername);
    $poll_templates->set_var('owner_id', $Q['owner_id']);
    $poll_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $poll_templates->set_var('group_dropdown',
                             SEC_getGroupDropdown ($Q['group_id'], $access));
    $poll_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $poll_templates->set_var('lang_permissionskey', $LANG_ACCESS['permissionskey']);
    $poll_templates->set_var('permissions_editor', SEC_getPermissionsHTML($Q['perm_owner'],$Q['perm_group'],$Q['perm_members'],$Q['perm_anon']));
    $poll_templates->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);
    $poll_templates->set_var('lang_answersvotes', $LANG25[10]);
    $poll_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $poll_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);

    if (isset ($answers)) {
        for ($i = 1; $i <= $_PO_CONF['maxanswers']; $i++) {
            $A = DB_fetchArray ($answers);
            $poll_templates->set_var ('answer_text',
                                      htmlspecialchars ($A['answer']));
            $poll_templates->set_var ('answer_votes', $A['votes']);
            $poll_templates->set_var ('remark_text', $A['remark']);
            if ($i < $_PO_CONF['maxanswers']) {
                $poll_templates->parse ('answer_option', 'answer', true);
            }
        }
    } else {
        for ($i = 1; $i <= $_PO_CONF['maxanswers']; $i++) {
            $poll_templates->set_var ('answer_text', '');
            $poll_templates->set_var ('answer_votes', '');
            $poll_templates->set_var ('remark_text', '');
            if ($i < $_PO_CONF['maxanswers']) {
                $poll_templates->parse ('answer_option', 'answer', true);
            }
        }
    }

    $poll_templates->parse('output','editor');
    $retval .= $poll_templates->finish($poll_templates->get_var('output'));

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Delete a poll
*
* @param    string  $qid    ID of poll to delete
* @return   string          HTML redirect
*
*/
function deletePoll ($qid)
{
    global $_CONF, $_TABLES, $_USER;

    $qid = addslashes ($qid);
    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid = '$qid'");
    $Q = DB_fetchArray ($result);
    $access = SEC_hasAccess ($Q['owner_id'], $Q['group_id'], $Q['perm_owner'],
            $Q['perm_group'], $Q['perm_members'], $Q['perm_anon']);
    if ($access < 3) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete poll $qid.");
        return COM_refresh ($_CONF['site_admin_url'] . '/plugins/polls/index.php');
    }

    DB_delete ($_TABLES['pollquestions'], 'qid', $qid);
    DB_delete ($_TABLES['pollanswers'], 'qid', $qid);
    DB_query ("DELETE FROM {$_TABLES['comments']} WHERE sid = '$qid' AND type = 'polls'");

    return COM_refresh ($_CONF['site_admin_url'] . '/plugins/polls/index.php?msg=20');
}

// MAIN

$display = '';

$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter($_REQUEST['mode']);
}

if ($mode == 'edit') {
    $display .= COM_siteHeader ('menu', $LANG25[5]);
    $qid = '';
    if (isset ($_GET['qid'])) {
        $qid = COM_applyFilter ($_GET['qid']);
    }
    $display .= editpoll ($qid);
    $display .= COM_siteFooter ();
} else if (($mode == $LANG_ADMIN['save']) && !empty ($LANG_ADMIN['save'])) {
    $qid = COM_applyFilter ($_POST['qid']);
    if (!empty ($qid)) {
        $voters = 0;
        for ($i = 0; $i < sizeof ($_POST['answer']); $i++) {
            $voters = $voters + COM_applyFilter ($_POST['votes'][$i], true);
        }
        $statuscode = 0;
        if (isset ($_POST['statuscode'])) {
            $statuscode = COM_applyFilter ($_POST['statuscode'], true);
        }
        $mainpage = '';
        if (isset ($_POST['mainpage'])) {
            $mainpage = COM_applyFilter ($_POST['mainpage']);
        }
        $display .= savepoll ($qid, $mainpage, $_POST['question'], $voters,
                        $statuscode,
                        COM_applyFilter ($_POST['commentcode'], true),
                        $_POST['answer'], $_POST['votes'], $_POST['remark'],
                        COM_applyFilter ($_POST['owner_id'], true),
                        COM_applyFilter ($_POST['group_id'], true),
                        $_POST['perm_owner'], $_POST['perm_group'],
                        $_POST['perm_members'], $_POST['perm_anon']);
    } else {
        $display .= COM_siteHeader ('menu', $LANG25[5]);
        $display .= COM_startBlock ($LANG21[32], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $LANG25[17];
        $display .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= editpoll ();
        $display .= COM_siteFooter ();
    }
} else if (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) {
    $qid = '';
    if (isset ($_POST['qid'])) {
        $qid = COM_applyFilter ($_POST['qid']);
    }
    if (empty ($qid)) {
        COM_errorLog ('Ignored possibly manipulated request to delete a poll.');
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/plugins/polls/index.php');
    } else {
        $display .= deletePoll ($qid);
    }
} else { // 'cancel' or no mode at all

    $display .= COM_siteHeader ('menu', $LANG25[18]);
    if (isset ($_REQUEST['msg'])) {
        $msg = COM_applyFilter ($_REQUEST['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage ($msg, 'polls');
        }
    }
    $display .= listpolls();
    $display .= COM_siteFooter ();
}

echo $display;

?>
