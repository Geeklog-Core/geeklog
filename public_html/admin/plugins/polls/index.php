<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Polls plugin administration page                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
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

/**
* Polls plugin administration page
*
* @package Polls
* @subpackage admin
*/

/**
* Geeklog common function library and Admin authentication
*/
require_once '../../../lib-common.php';
require_once '../../auth.inc.php';

// Set this to true if you want to log debug messages to error.log
$_POLL_VERBOSE = false;

$display = '';

if (!SEC_hasRights('polls.edit')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the poll administration screen.");
    COM_output($display);
    exit;
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

function listpolls()
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE, $LANG_ADMIN, $LANG25, $LANG_ACCESS;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
    // writing the menu on top
    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'] . '/plugins/polls/index.php?mode=edit',
              'text' => $LANG_ADMIN['create_new']),
        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']));

    $retval .= COM_startBlock($LANG25[18], '',
                              COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG25[19],
        plugin_geticon_polls()
    );

    // writing the actual list
    $header_arr = array(      # display 'text' and use table field 'field'
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG25[9], 'field' => 'topic', 'sort' => true),
        array('text' => $LANG25[20], 'field' => 'voters', 'sort' => true),
        array('text' => $LANG_ACCESS['access'], 'field' => 'access', 'sort' => false),
        array('text' => $LANG25[3], 'field' => 'unixdate', 'sort' => true),
        array('text' => $LANG25[33], 'field' => 'is_open', 'sort' => true)
    );

    $defsort_arr = array('field' => 'unixdate', 'direction' => 'desc');

    $text_arr = array(
        'has_extras'   => true,
        'instructions' => $LANG25[19],
        'form_url'     => $_CONF['site_admin_url'] . '/plugins/polls/index.php'
    );

    $query_arr = array(
        'table' => 'polltopics',
        'sql' => "SELECT *,UNIX_TIMESTAMP(created) AS unixdate "
            . "FROM {$_TABLES['polltopics']} WHERE 1=1",
        'query_fields' => array('topic'),
        'default_filter' => COM_getPermSql ('AND')
    );

    $retval .= ADMIN_list (
        'polls', 'plugin_getListField_polls', $header_arr,
        $text_arr, $query_arr, $defsort_arr
    );
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
* Saves a poll
*
* Saves a poll topic and potential answers to the database
*
* @param    string  $pid            Poll topic ID
* @param    string  $old_pid        Previous poll topic ID
* @param    array   $Q              Array of poll questions
* @param    string  $mainpage       Checkbox: poll appears on homepage
* @param    string  $topic          The text for the topic
* @param    string  $meta_description
* @param    string  $meta_keywords
* @param    int     $statuscode     (unused)
* @param    string  $open           Checkbox: poll open for voting
* @param    string  $hideresults    Checkbox: hide results until closed
* @param    int     $commentcode    Indicates if users can comment on poll
* @param    array   $A              Array of possible answers
* @param    array   $V              Array of vote per each answer
* @param    array   $R              Array of remark per each answer
* @param    int     $owner_id       ID of poll owner
* @param    int     $group_id       ID of group poll belongs to
* @param    int     $perm_owner     Permissions the owner has on poll
* @param    int     $perm_grup      Permissions the group has on poll
* @param    int     $perm_members   Permissions logged in members have on poll
* @param    int     $perm_anon      Permissions anonymous users have on poll
* @return   string                  HTML redirect or error message
*
*/
function savepoll($pid, $old_pid, $Q, $mainpage, $topic, $meta_description, $meta_keywords, $statuscode, $open,
                  $hideresults, $commentcode, $A, $V, $R, $owner_id, $group_id,
                  $perm_owner, $perm_group, $perm_members, $perm_anon)

{
    global $_CONF, $_TABLES, $_USER, $LANG21, $LANG25, $MESSAGE, $_POLL_VERBOSE,
           $_PO_CONF;

    $retval = '';

    // Convert array values to numeric permission values
    list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);

    $topic = COM_stripslashes($topic);
    $meta_description = strip_tags(COM_stripslashes($meta_description));
    $meta_keywords = strip_tags(COM_stripslashes($meta_keywords));
    $pid = COM_sanitizeID($pid);
    $old_pid = COM_sanitizeID($old_pid);
    if (empty($pid)) {
        if (empty($old_pid)) {
            $pid = COM_makeSid();
        } else {
            $pid = $old_pid;
        }
    }

    // check if any question was entered
    if (empty($topic) or (count($Q) == 0) or (strlen($Q[0]) == 0) or
            (strlen($A[0][0]) == 0)) {
        $retval .= COM_startBlock ($LANG21[32], '',
                           COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= $LANG25[2];
        $retval .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG25[5]));
        return $retval;
    }

    if (!SEC_checkToken()) {
        COM_accessLog("User {$_USER['username']} tried to save poll $pid and failed CSRF checks.");
        return COM_refresh($_CONF['site_admin_url']
                           . '/plugins/polls/index.php');
    }

    // check for poll id change
    if (!empty($old_pid) && ($pid != $old_pid)) {
        // check if new pid is already in use
        if (DB_count($_TABLES['polltopics'], 'pid', $pid) > 0) {
            // TBD: abort, display editor with all content intact again
            $pid = $old_pid; // for now ...
        }
    }

    // start processing the poll topic
    if ($_POLL_VERBOSE) {
        COM_errorLog ('**** Inside savepoll() in '
                      . $_CONF['site_admin_url'] . '/plugins/polls/index.php ***');
    }

    $access = 0;
    if (DB_count ($_TABLES['polltopics'], 'pid', $pid) > 0) {
        $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['polltopics']} WHERE pid = '{$pid}'");
        $P = DB_fetchArray ($result);
        $access = SEC_hasAccess ($P['owner_id'], $P['group_id'],
                $P['perm_owner'], $P['perm_group'], $P['perm_members'],
                $P['perm_anon']);
    } else {
        $access = SEC_hasAccess ($owner_id, $group_id, $perm_owner,
                                 $perm_group, $perm_members, $perm_anon);
    }
    if (($access < 3) || !SEC_inGroup($group_id)) {
        $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
        $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
        COM_accessLog("User {$_USER['username']} tried to illegally submit or edit poll $pid.");
        COM_output($display);
        exit;
    }

    if ($_POLL_VERBOSE) {
        COM_errorLog('owner permissions: ' . $perm_owner, 1);
        COM_errorLog('group permissions: ' . $perm_group, 1);
        COM_errorLog('member permissions: ' . $perm_members, 1);
        COM_errorLog('anonymous permissions: ' . $perm_anon, 1);
    }

    // we delete everything and re-create it with the input from the form
    $del_pid = $pid;
    if (!empty($old_pid) && ($pid != $old_pid)) {
        $del_pid = $old_pid; // delete by old pid, create using new pid below
    }
    // Retrieve Created Date before delete
    $created_date = DB_getItem($_TABLES['polltopics'], 'created', "pid = '{$del_pid}'");
    if ($created_date == '') {
        $created_date = date ('Y-m-d H:i:s');
    }
    
    DB_delete($_TABLES['polltopics'], 'pid', $del_pid);
    DB_delete($_TABLES['pollanswers'], 'pid', $del_pid);
    DB_delete($_TABLES['pollquestions'], 'pid', $del_pid);

    $topic = addslashes($topic);
    $meta_description = addslashes($meta_description);
    $meta_keywords = addslashes($meta_keywords);

    $k = 0; // set up a counter to make sure we do assign a straight line of question id's
    // first dimension of array are the questions
    $num_questions = count($Q);
    $num_total_votes = 0;
    $num_questions_exist = 0;
    for ($i = 0; $i < $num_questions; $i++) {
        $Q[$i] = COM_stripslashes($Q[$i]);
        if (strlen($Q[$i]) > 0) { // only insert questions that exist
            $num_questions_exist++;
            
            $Q[$i] = addslashes($Q[$i]);
            DB_save($_TABLES['pollquestions'], 'qid, pid, question',
                                               "'$k', '$pid', '$Q[$i]'");
            // within the questions, we have another dimensions with answers,
            // votes and remarks
            $num_answers = count($A[$i]);
            for ($j = 0; $j < $num_answers; $j++) {
                $A[$i][$j] = COM_stripslashes($A[$i][$j]);
                if (strlen($A[$i][$j]) > 0) { // only insert answers etc that exist
                    if (!is_numeric($V[$i][$j])) {
                        $V[$i][$j] = "0";
                    }
                    $A[$i][$j] = addslashes ($A[$i][$j]);
                    $R[$i][$j] = addslashes ($R[$i][$j]);
                    $sql = "INSERT INTO {$_TABLES['pollanswers']} (pid, qid, aid, answer, votes, remark) VALUES "
                        . "('$pid', '$k', " . ($j+1) . ", '{$A[$i][$j]}', {$V[$i][$j]}, '{$R[$i][$j]}');";
                    DB_query($sql);
                    
                    $num_total_votes = $num_total_votes + $V[$i][$j];
                }
            }
            $k++;
        }
    }
    
    // determine the number of voters (cannot use records in pollvoters table since they get deleted after a time $_PO_CONF['polladdresstime'])
    if ($num_questions_exist > 0) {
        $numvoters = $num_total_votes / $num_questions_exist;
    } else {
        // This shouldn't happen
        $numvoters = $num_total_votes;
    }
    
    // save topics after the questions so we can include question count into table
    $sql = "'$pid','$topic','$meta_description','$meta_keywords',$numvoters, $k, '$created_date', '" . date ('Y-m-d H:i:s');

    if ($mainpage == 'on') {
        $sql .= "',1";
    } else {
        $sql .= "',0";
    }
    if ($open == 'on') {
        $sql .= ",1";
    } else {
        $sql .= ",0";
    }
    if ($hideresults == 'on') {
        $sql .= ",1";
    } else {
        $sql .= ",0";
    }

    $sql .= ",'$statuscode','$commentcode',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon";

    // Save poll topic
    DB_save($_TABLES['polltopics'], "pid, topic, meta_description, meta_keywords, voters, questions, created, modified, display, is_open, hideresults, statuscode, commentcode, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon", $sql);

    if (empty($old_pid) || ($old_pid == $pid)) {
        PLG_itemSaved($pid, 'polls');
    } else {
        DB_change($_TABLES['comments'], 'sid', addslashes($pid),
                  array('sid', 'type'), array(addslashes($old_pid), 'polls'));
        PLG_itemSaved($pid, 'polls', $old_pid);
    }

    if ($_POLL_VERBOSE) {
        COM_errorLog ('**** Leaving savepoll() in '
                      . $_CONF['site_admin_url'] . '/plugins/polls/index.php ***');
    }

    return PLG_afterSaveSwitch (
        $_PO_CONF['aftersave'],
        $_CONF['site_url'] . '/polls/index.php?pid=' . $pid,
        'polls',
        19
    );

    return COM_refresh($_CONF['site_admin_url'] . '/plugins/polls/index.php?msg=19');
}

/**
* Shows poll editor
*
* Diplays the poll editor form
*
* @param    string  $pid    ID of poll to edit
* @return   string          HTML for poll editor form
*
*/
function editpoll ($pid = '')
{
    global $_CONF, $_PO_CONF, $_GROUPS, $_TABLES, $_USER, $LANG25, $LANG_ACCESS,
           $LANG_ADMIN, $MESSAGE, $LANG_POLLS, $_SCRIPTS;

    $retval = '';

    if (!empty($pid)) {
        $topic = DB_query("SELECT * FROM {$_TABLES['polltopics']} WHERE pid='$pid'");
        $T = DB_fetchArray($topic);

        // Get permissions for poll
        $access = SEC_hasAccess($T['owner_id'],$T['group_id'],$T['perm_owner'],$T['perm_group'],$T['perm_members'],$T['perm_anon']);
        if ($access == 0 OR $access == 2) {
            // User doesn't have access...bail
            $retval .= COM_startBlock($LANG25[21], '',
                            COM_getBlockTemplate('_msg_block', 'header'));
            $retval .= $LANG25[22];
            $retval .= COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
            COM_accessLog("User {$_USER['username']} tried to illegally submit or edit poll $pid.");
            return $retval;
        }
    }

    // writing the menu on top
    require_once $_CONF['path_system'] . 'lib-admin.php';

    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'] . '/plugins/polls/index.php',
              'text' => $LANG_ADMIN['list_all']),
        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']));

    $token = SEC_createToken();

    $retval .= COM_startBlock($LANG25[5], '',
                              COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG_POLLS['editinstructions'],
        plugin_geticon_polls()
    );
    $retval .= SEC_getTokenExpiryNotice($token);

    $poll_templates = COM_newTemplate($_CONF['path']
                                    . 'plugins/polls/templates/admin/');
    $poll_templates->set_file (array ('editor' => 'polleditor.thtml',
                                      'question' => 'pollquestions.thtml',
                                      'answer' => 'pollansweroption.thtml'));

    if (!empty ($pid) AND ($access == 3) AND !empty ($T['owner_id'])) {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s' . XHTML . '>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $poll_templates->set_var ('delete_option',
                                  sprintf ($delbutton, $jsconfirm));
        $poll_templates->set_var ('delete_option_no_confirmation',
                                  sprintf ($delbutton, ''));
    } else {
        $T['pid'] = COM_makeSid ();
        $T['topic'] = '';
        $T['meta_description'] = '';
        $T['meta_keywords'] = '';
        $T['voters'] = 0;
        $T['display'] = 1;
        $T['is_open'] = 1;
        $T['hideresults'] = 0;
        $T['owner_id'] = $_USER['uid'];
        if (isset ($_GROUPS['Polls Admin'])) {
            $T['group_id'] = $_GROUPS['Polls Admin'];
        } else {
            $T['group_id'] = SEC_getFeatureGroup ('polls.edit');
        }
        SEC_setDefaultPermissions ($T, $_PO_CONF['default_permissions']);
        $T['statuscode'] = 0;
        $T['commentcode'] = $_CONF['comment_code'];
        $access = 3;
    }
    
    $poll_templates->set_var('noscript', COM_getNoScript(false, ''));        
    
    // Add JavaScript
    // Hide the Advanced Editor as Javascript is required. If JS is enabled then the JS below will un-hide it
    $js = 'document.getElementById("advanced_editor").style.display="";';                 
    $_SCRIPTS->setJavaScript($js, true);    
    $_SCRIPTS->setJavaScriptFile('polls_editor', '/polls/polls_editor.js');

    $poll_templates->set_var('lang_pollid', $LANG25[6]);
    $poll_templates->set_var('poll_id', $T['pid']);
    $poll_templates->set_var('lang_donotusespaces', $LANG25[7]);
    $poll_templates->set_var('lang_topic', $LANG25[9]);
    $poll_templates->set_var('poll_topic', htmlspecialchars ($T['topic']));
    $poll_templates->set_var('lang_mode', $LANG25[1]);
    
    $poll_templates->set_var('lang_metadescription',
                             $LANG_ADMIN['meta_description']);
    $poll_templates->set_var('lang_metakeywords', $LANG_ADMIN['meta_keywords']);
    if (!empty($T['meta_description'])) {
        $poll_templates->set_var('meta_description', $T['meta_description']);
    }
    if (!empty($T['meta_keywords'])) {
        $poll_templates->set_var('meta_keywords', $T['meta_keywords']);        
    }
    if (($_CONF['meta_tags'] > 0) && ($_PO_CONF['meta_tags'] > 0)) {
        $poll_templates->set_var('hide_meta', '');
    } else {
        $poll_templates->set_var('hide_meta', ' style="display:none;"');
    }

    $poll_templates->set_var('status_options', COM_optionList ($_TABLES['statuscodes'], 'code,name', $T['statuscode']));
    $poll_templates->set_var('comment_options', COM_optionList($_TABLES['commentcodes'],'code,name',$T['commentcode']));

    $poll_templates->set_var('lang_appearsonhomepage', $LANG25[8]);
    $poll_templates->set_var('lang_openforvoting', $LANG25[33]);
    $poll_templates->set_var('lang_hideresults', $LANG25[37]);
    $poll_templates->set_var('poll_hideresults_explain', $LANG25[38]);
    $poll_templates->set_var('poll_topic_info', $LANG25[39]);

    if ($T['display'] == 1) {
        $poll_templates->set_var('poll_display', 'checked="checked"');
    }

    if ($T['is_open'] == 1) {
        $poll_templates->set_var('poll_open', 'checked="checked"');
    }
    if ($T['hideresults'] == 1) {
        $poll_templates->set_var('poll_hideresults', 'checked="checked"');
    }
    // user access info
    $poll_templates->set_var('lang_accessrights', $LANG_ACCESS['accessrights']);
    $poll_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $ownername = COM_getDisplayName ($T['owner_id']);
    $poll_templates->set_var('owner_username', DB_getItem($_TABLES['users'],
                             'username', "uid = {$T['owner_id']}"));
    $poll_templates->set_var('owner_name', $ownername);
    $poll_templates->set_var('owner', $ownername);
    $poll_templates->set_var('owner_id', $T['owner_id']);
    $poll_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $poll_templates->set_var('group_dropdown',
                             SEC_getGroupDropdown ($T['group_id'], $access));
    $poll_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $poll_templates->set_var('lang_permissionskey', $LANG_ACCESS['permissionskey']);
    $poll_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $poll_templates->set_var('permissions_editor', SEC_getPermissionsHTML($T['perm_owner'],$T['perm_group'],$T['perm_members'],$T['perm_anon']));
    $poll_templates->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);
    $poll_templates->set_var('lang_answersvotes', $LANG25[10]);
    $poll_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $poll_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);

    // repeat for several questions

    $question_sql = "SELECT question,qid "
        . "FROM {$_TABLES['pollquestions']} WHERE pid='$pid' ORDER BY qid;";
    $questions = DB_query($question_sql);
    include ($_CONF['path_system'] . 'classes/navbar.class.php');
    $navbar = new navbar;
    for ($j=0; $j<$_PO_CONF['maxquestions']; $j++) {
        $display_id = $j+1;
        if ($j > 0) {
            $poll_templates->set_var('style', 'style="display:none;"');
        } else {
            $poll_templates->set_var('style', '');
        }
        $navbar->add_menuitem(
            $LANG25[31] . " $display_id",
            "showhidePollsEditorDiv(\"$j\",$j,{$_PO_CONF['maxquestions']});return false;",
            true
        );
        $Q = DB_fetchArray ($questions);
        $poll_templates->set_var('question_text', $Q['question']);
        $poll_templates->set_var('question_id', $j);
        $poll_templates->set_var('lang_question', $LANG25[31] . " $display_id");
        $poll_templates->set_var('lang_saveaddnew', $LANG25[32]);

        // answers
        $answer_sql = "SELECT answer,aid,votes,remark "
            . "FROM {$_TABLES['pollanswers']} WHERE qid='$j' AND pid='$pid' ORDER BY aid";
        $answers = DB_query($answer_sql);

        for ($i=0; $i<$_PO_CONF['maxanswers']; $i++) {
            if (isset ($answers)) {
                $A = DB_fetchArray ($answers);
                $poll_templates->set_var ('answer_text',
                                          htmlspecialchars ($A['answer']));
                $poll_templates->set_var ('answer_votes', $A['votes']);
                $poll_templates->set_var ('remark_text', $A['remark']);
            } else {
                $poll_templates->set_var ('answer_text', '');
                $poll_templates->set_var ('answer_votes', '');
                $poll_templates->set_var ('remark_text', '');

            }
            $poll_templates->parse ('answer_option', 'answer', true);
        }
        $poll_templates->parse ('question_list', 'question', true);
        $poll_templates->clear_var ('answer_option');
    }
    $navbar->set_selected($LANG25[31] . " 1");
    $poll_templates->set_var ('navbar', $navbar->generate());
    $poll_templates->set_var('gltoken_name', CSRF_TOKEN);
    $poll_templates->set_var('gltoken', $token);

    $poll_templates->parse('output','editor');
    $retval .= $poll_templates->finish($poll_templates->get_var('output'));

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Delete a poll
*
* @param    string  $pid    ID of poll to delete
* @return   string          HTML redirect
*
*/
function deletePoll ($pid)
{
    global $_CONF, $_TABLES, $_USER;

    $pid = addslashes ($pid);
    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['polltopics']} WHERE pid = '$pid'");
    $Q = DB_fetchArray ($result);
    $access = SEC_hasAccess ($Q['owner_id'], $Q['group_id'], $Q['perm_owner'],
            $Q['perm_group'], $Q['perm_members'], $Q['perm_anon']);
    if ($access < 3) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete poll $pid.");
        return COM_refresh ($_CONF['site_admin_url'] . '/plugins/polls/index.php');
    }

    DB_delete($_TABLES['polltopics'], 'pid', $pid);
    DB_delete($_TABLES['pollanswers'], 'pid', $pid);
    DB_delete($_TABLES['pollquestions'], 'pid', $pid);
    DB_delete($_TABLES['comments'], array('sid', 'type'),
                                    array($pid,  'polls'));

    PLG_itemDeleted($pid, 'polls');

    return COM_refresh ($_CONF['site_admin_url'] . '/plugins/polls/index.php?msg=20');
}

// MAIN

$display = '';

$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter($_REQUEST['mode']);
}

if ($mode == 'edit') {
    $pid = '';
    if (isset ($_GET['pid'])) {
        $pid = COM_applyFilter ($_GET['pid']);
    }
    $display .= editpoll ($pid);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG25[5]));
} elseif (($mode == $LANG_ADMIN['save']) && !empty($LANG_ADMIN['save'])) {
    $pid = COM_applyFilter($_POST['pid']);
    $old_pid = '';
    if (isset($_POST['old_pid'])) {
        $old_pid = COM_applyFilter($_POST['old_pid']);
    }
    if (empty($pid) && !empty($old_pid)) {
        $pid = $old_pid;
    }
    if (empty($old_pid) && (! empty($pid))) {
        $old_pid = $pid;
    }
    if (!empty($pid)) {
        $statuscode = 0;
        if (isset ($_POST['statuscode'])) {
            $statuscode = COM_applyFilter ($_POST['statuscode'], true);
        }
        $mainpage = '';
        if (isset ($_POST['mainpage'])) {
            $mainpage = COM_applyFilter ($_POST['mainpage']);
        }
        $open = '';
        if (isset ($_POST['open'])) {
            $open = COM_applyFilter ($_POST['open']);
        }
        $hideresults = '';
        if (isset ($_POST['hideresults'])) {
            $hideresults = COM_applyFilter ($_POST['hideresults']);
        }
        $display .= savepoll ($pid, $old_pid, $_POST['question'], $mainpage,
                        $_POST['topic'], $_POST['meta_description'],
                        $_POST['meta_keywords'], $statuscode, $open,
                        $hideresults,
                        COM_applyFilter ($_POST['commentcode'], true),
                        $_POST['answer'], $_POST['votes'], $_POST['remark'],
                        COM_applyFilter ($_POST['owner_id'], true),
                        COM_applyFilter ($_POST['group_id'], true),
                        $_POST['perm_owner'], $_POST['perm_group'],
                        $_POST['perm_members'], $_POST['perm_anon']);
    } else {
        $display .= COM_startBlock ($LANG21[32], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $LANG25[17];
        $display .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= editpoll ();
        $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG25[5]));
    }
} elseif (($mode == $LANG_ADMIN['delete']) && !empty($LANG_ADMIN['delete'])) {
    $pid = '';
    if (isset ($_POST['pid'])) {
        $pid = COM_applyFilter ($_POST['pid']);
    }
    if (empty ($pid)) {
        COM_errorLog ('Ignored possibly manipulated request to delete a poll.');
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/plugins/polls/index.php');
    } elseif (SEC_checkToken()) {
        $display .= deletePoll ($pid);
    } else {
        COM_accessLog("User {$_USER['username']} tried to illegally delete poll $pid and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
    }
} else { // 'cancel' or no mode at all

    if (isset ($_REQUEST['msg'])) {
        $msg = COM_applyFilter ($_REQUEST['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage ($msg, 'polls');
        }
    }
    $display .= listpolls();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG25[18]));
}

COM_output($display);

?>
