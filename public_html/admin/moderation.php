<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | moderation.php                                                            |
// |                                                                           |
// | Geeklog main administration page.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
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

require_once '../lib-common.php';
require_once 'auth.inc.php';
require_once $_CONF['path_system'] . 'lib-user.php';
require_once $_CONF['path_system'] . 'lib-article.php';
require_once $_CONF['path_system'] . 'lib-comment.php';

// The maximum number of items on each moderation list
define('NUM_ITEMS_ON_MODERATION_LIST', 10);

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);


// Make sure user has rights to access this page
if (!SEC_hasModerationAccess()) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the moderation administration screen.");
    COM_output($display);
    exit;
}

/**
 * Prints the user submission lists at the top
 *
 * @param  string $token    CSRF token
 * @param  int    $approved the number of approved items
 * @param  int    $deleted  the number of deleted items
 * @return string           HTML for the C&C block
 */
function usersubmissions($token, $approved = 0, $deleted = 0)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG29, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    $approved = (int) $approved;
    $deleted = (int) $deleted;

    if (($approved > 0) || ($deleted > 0)) {
        $retval .= COM_showMessageText(sprintf($LANG29[45], $approved, $deleted), $LANG29[44]);
    }

    // writing the menu on top
    $menu_arr = array(
        array(
            'url'  => $_CONF['site_admin_url'],
            'text' => $LANG_ADMIN['admin_home'],
        ),
    );

    $retval .= COM_startBlock(
        $LANG29[13], '',
        COM_getBlockTemplate('_admin_block', 'header')
    );
    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG29['submissions_desc'],
        $_CONF['layout_url'] . '/images/icons/moderation.' . $_IMAGE_TYPE
    );

    // IMPORTANT - If any of the below submission lists change, please
    // update the function SEC_hasModerationAccess in lib-security.php to
    // reflect the changes

    if (SEC_hasRights('story.moderate')) {
        $retval .= itemlist('story', $token);
    }

    if (($_CONF['listdraftstories'] == 1) && SEC_hasRights('story.edit')) {
        $retval .= itemlist('story_draft', $token);
    }

    if (($_CONF['commentsubmission'] == 1) && SEC_hasRights('comment.moderate')) {
        $retval .= itemlist('comment', $token);
    }

    if (($_CONF['usersubmission'] == 1) &&
        SEC_hasRights('user.edit') &&
        SEC_hasRights('user.delete')) {
        $retval .= userlist($token);
    }

    $retval .= PLG_showModerationList($token)
        . COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
 * Displays items needing moderation
 * Displays the moderation list of items from the submission tables
 *
 * @param    string $type  Type of object to build list for
 * @param    string $token CSRF token
 * @return   string          HTML for the list of items
 */
function itemlist($type, $token)
{
    global $_CONF, $_TABLES, $LANG29, $LANG_ADMIN;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    if (empty($type)) {
        // something is terribly wrong, bail
        COM_errorLog('Submission type not set in moderation.php');

        return $retval;
    }

    $isPlugin = false;

    // Get current page
    $page = (int) Geeklog\Input::fGet('page_' . $type, 1);

    if ($page < 1) {
        $page = 1;
    }
    
    if ($type === 'comment') {
        $sql = "SELECT cid AS id,title,comment,date,uid,type,sid FROM {$_TABLES['commentsubmissions']} "
            . "ORDER BY cid ASC";
        $H = array($LANG29[10], $LANG29[36], $LANG29[14]);
        $section_title = $LANG29[41];
        $section_help = 'cccommentsubmission.html';
    } else {
        $function = 'plugin_itemlist_' . $type;
        if (function_exists($function)) {
            // Great, we found the plugin, now call its itemlist method
            $plugin = $function();

            if ($plugin instanceof Plugin) {
                $sql = $plugin->getsubmissionssql;
                $H = $plugin->submissionheading;
                $section_title = $plugin->submissionlabel;
                $section_help = $plugin->submissionhelpfile;
                if (($type !== 'story') && ($type !== 'story_draft')) {
                    $isPlugin = true;
                }
            } elseif (is_string($plugin)) {
                return '<div class="block-box">' . $plugin . '</div>' . LB;
            } else {
                return '';
            }
        }
    }

    if (empty($sql)) {
        // was more than likely a plugin that doesn't need moderation
        return '';
    }

    // Get the number of all entries for pagination
    $result = DB_query($sql, 1);
    if (DB_error()) {
        return '';
    }

    $numRows = (int) DB_numRows($result);
    $maxPage = (int) floor(($numRows - 1) / NUM_ITEMS_ON_MODERATION_LIST) + 1;
    if ($page > $maxPage) {
        $page = $maxPage;
    }

    // run SQL but this time ignore any errors
    $sql .= sprintf(
        ' LIMIT %d, %d',
        NUM_ITEMS_ON_MODERATION_LIST * ($page - 1),
        NUM_ITEMS_ON_MODERATION_LIST
    );
    $result = DB_query($sql, 1);

    if (DB_error()) {
        return '';
    } else {
        $numRows = DB_numRows($result);
    }

    $data_arr = array();

    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);
        /**
         * @todo There should be an API for these URLs ...
         */
        if ($isPlugin) {
            $A['edit'] = $_CONF['site_admin_url'] . '/plugins/' . $type
                . '/index.php?mode=editsubmission&amp;id=' . $A[0];
        } elseif ($type === 'comment') {
            $A['edit'] = $_CONF['site_url'] . '/comment.php'
                . '?mode=editsubmission&amp;cid=' . $A[0];
        } elseif ($type === 'story_draft') {
            $A['edit'] = $_CONF['site_admin_url'] . '/article.php'
                . '?mode=edit&amp;sid=' . $A[0];
        } else { // this pretty much only leaves $type == 'story'
            if ($type === 'story') {
                $filename = 'article';
            } else {
                $filename = $type;
            }

            $A['edit'] = $_CONF['site_admin_url'] . '/' . $filename
                . '.php?mode=editsubmission&amp;id=' . $A[0];
        }
        $A['row'] = $i;
        $A['_moderation_type'] = $type;
        $data_arr[$i] = $A;
    }

    if ($type === 'comment') {
        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_ADMIN['edit'], 'field' => 0),
            array('text' => $H[0], 'field' => 1),
            array('text' => $H[1], 'field' => 2),
            array('text' => $H[2], 'field' => 3),
            array('text' => $LANG29[2], 'field' => 'delete'),
            array('text' => $LANG29[1], 'field' => 'approve'),
            array('text' => $LANG29[42], 'field' => 'uid'),
            array('text' => $LANG29[43], 'field' => 'publishfuture'),
        );
    } elseif ($type === 'story' || $type === 'story_draft') {
        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_ADMIN['edit'], 'field' => 0),
            array('text' => $H[0], 'field' => 1),
            array('text' => $H[1], 'field' => 'uid'),
            array('text' => $H[2], 'field' => 3),
            array('text' => $H[3], 'field' => 4),
            array('text' => $LANG29[2], 'field' => 'delete'),
            array('text' => $LANG29[1], 'field' => 'approve'),
        );
    } else {
        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_ADMIN['edit'], 'field' => 0),
            array('text' => $H[0], 'field' => 1),
            array('text' => $H[1], 'field' => 2),
            array('text' => $H[2], 'field' => 3),
            array('text' => $LANG29[2], 'field' => 'delete'),
            array('text' => $LANG29[1], 'field' => 'approve'),
        );
    }

    $text_arr = array(
        'has_menu' => false,
        'title'    => $section_title,
        'help_url' => $section_help,
        'no_data'  => $LANG29[39],
        'form_url' => "{$_CONF['site_admin_url']}/moderation.php",
    );
    $form_arr = array('bottom' => '', 'top' => '');
    if ($numRows > 0) {
        
        $form_arr['bottom'] .= '<input type="hidden" name="type" value="' . $type . '"' . XHTML . '>' . LB
            . '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $token . '"' . XHTML . '>' . LB
            . '<input type="hidden" name="mode" value="moderation"' . XHTML . '>' . LB
            . '<input type="hidden" name="count" value="' . $numRows . '"' . XHTML . '>';

        $control = COM_createControl('type-submit', array(
            'name'  => 'submit',
            'value' => $LANG_ADMIN['submit'],
            'lang_button' => $LANG_ADMIN['submit'],
        ));
        $form_arr['bottom'] .= COM_createControl('controls-center', array(
            'control' => $control
        ));

        // Add pagination
        if ($maxPage > 1) {
            $form_arr['bottom'] .= COM_printPageNavigation(
                $_CONF['site_admin_url'] . '/moderation.php', $page, $maxPage,
                'page_' . $type . '='
            );
        }
    }

    $listOptions = array('chkdelete' => true, 'chkfield' => 'id');
    $retval .= ADMIN_simpleList('ADMIN_getListField_moderation', $header_arr,
        $text_arr, $data_arr, $listOptions, $form_arr);

    return $retval;
}

/**
 * Displays new user submissions
 * When enabled, this will list all the new users which have applied for a
 * site membership. When approving an application, an email containing the
 * password is sent out immediately.
 *
 * @param    string $token CSRF token
 * @return   string          HTML for the list of users
 */
function userlist($token)
{
    global $_CONF, $_TABLES, $LANG29, $LANG_ADMIN;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
    $sql = "SELECT uid as id,username,fullname,email FROM {$_TABLES['users']} WHERE status = 2";
    $result = DB_query($sql);
    $numRows = DB_numRows($result);
    $data_arr = array();
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);
        $A['edit'] = $_CONF['site_admin_url'] . '/user.php?mode=edit&amp;uid=' . $A['id'];
        $A['row'] = $i;
        $A['fullname'] = stripslashes($A['fullname']);
        $A['email'] = stripslashes($A['email']);
        $data_arr[$i] = $A;
    }
    $header_arr = array(
        array('text' => $LANG_ADMIN['edit'], 'field' => 0),
        array('text' => $LANG29[16], 'field' => 1),
        array('text' => $LANG29[17], 'field' => 2),
        array('text' => $LANG29[18], 'field' => 3),
        array('text' => $LANG29[2], 'field' => 'delete'),
        array('text' => $LANG29[1], 'field' => 'approve'),
    );

    $text_arr = array(
        'has_menu' => false,
                      'title'    => $LANG29[40],
                      'help_url' => 'ccusersubmission.html',
                      'no_data'  => $LANG29[39],
                      'form_url' => "{$_CONF['site_admin_url']}/moderation.php",
    );

    $listOptions = array('chkdelete' => true, 'chkfield' => 'id');

    $form_arr = array("bottom" => '', "top" => '');
    if ($numRows > 0) {

        $form_arr['bottom'] = '<input type="hidden" name="type" value="user"' . XHTML . '>' . LB
            . '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $token . '"' . XHTML . '>' . LB
            . '<input type="hidden" name="mode" value="moderation"' . XHTML . '>' . LB
            . '<input type="hidden" name="count" value="' . $numRows . '"' . XHTML . '>';

        $control = COM_createControl('type-submit', array(
            'name'  => 'submit',
            'value' => $LANG_ADMIN['submit'],
            'lang_button' => $LANG_ADMIN['submit'],
        ));
        $form_arr['bottom'] .= COM_createControl('controls-center', array(
            'control' => $control
        ));
    }

    $table = ADMIN_simpleList('ADMIN_getListField_moderation', $header_arr,
        $text_arr, $data_arr, $listOptions, $form_arr);
    $retval .= $table;

    return $retval;
}

/**
 * Moderates an item
 * This will actually perform moderation (approve or delete) one or more items
 *
 * @param    array  $mid    Array of items
 * @param    array  $action Array of actions to perform on items
 * @param    string $type   Type of items ('story', etc.)
 * @param    int    $count  Number of items to moderate
 * @return   string              HTML for "command and control" page
 */
function moderation($mid, $action, $type, $count)
{
    global $_CONF, $_TABLES;

    $retval = '';

    $sidArray = array();

    if (empty($type)) {
        // something is terribly wrong, bail
        $retval .= COM_errorLog("Submission type not set in moderation.php");

        return $retval;
    }

    if ($type === 'comment') {
        $id = 'cid';
        $table = $_TABLES['comments'];
        $submissionTable = $_TABLES['commentsubmissions'];
    } else {
        list($id, $table, $fields, $submissionTable) = PLG_getModerationValues($type);
    }

    // Set true if a valid action other than delete_all is selected
    $formAction = false;
    $approved = 0;
    $deleted = 0;

    for ($i = 0; $i < $count; $i++) {
        if (isset($action[$i]) && ($action[$i] != '')) {
            $formAction = true;
        } else {
            continue;
        }

        switch ($action[$i]) {
            case 'delete':
                if (empty($mid[$i])) {
                    $retval .= COM_errorLog("moderation.php just tried deleting everything in table {$submissionTable} because it got an empty id.  Please report this immediately to your site administrator");

                    return $retval;
                }

                // There may be some plugin specific processing that needs to
                // happen first.
                $retval .= PLG_deleteSubmission($type, $mid[$i]);

                // Notify plugins of a submission that is deleted
                PLG_submissionDeleted($type);

                DB_delete($submissionTable, $id, $mid[$i]);
                $deleted++;
                break;

            case 'approve':
                if ($type === 'story') {
                    $sql = "SELECT *, ta.tid
                    FROM {$_TABLES['storysubmission']}, {$_TABLES['topic_assignments']} ta
                    WHERE ta.type = 'article' AND ta.id = sid  AND sid = '$mid[$i]'";

                    $result = DB_query($sql);
                    $A = DB_fetchArray($result);
                    $A['related'] = DB_escapeString(implode("\n", STORY_extractLinks($A['introtext'])));
                    $A['owner_id'] = $A['uid'];
                    $A['title'] = DB_escapeString($A['title']);
                    $A['introtext'] = DB_escapeString($A['introtext']);
                    $A['bodytext'] = DB_escapeString($A['bodytext']);
                    $result = DB_query("SELECT group_id,perm_owner,perm_group,perm_members,perm_anon,archive_flag FROM {$_TABLES['topics']} WHERE tid = '{$A['tid']}'");
                    $T = DB_fetchArray($result);
                    if ($T['archive_flag'] == 1) {
                        $frontPage = 0;
                    } elseif (isset($_CONF['frontpage'])) {
                        $frontPage = $_CONF['frontpage'];
                    } else {
                        $frontPage = 1;
                    }
                    DB_save($_TABLES['stories'], 'sid,uid,title,introtext,bodytext,related,date,show_topic_icon,commentcode,trackbackcode,postmode,frontpage,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',
                        "'{$A['sid']}',{$A['uid']},'{$A['title']}','{$A['introtext']}','{$A['bodytext']}','{$A['related']}','{$A['date']}','{$_CONF['show_topic_icon']}','{$_CONF['comment_code']}','{$_CONF['trackback_code']}','{$A['postmode']}',$frontPage,{$A['owner_id']},{$T['group_id']},{$T['perm_owner']},{$T['perm_group']},{$T['perm_members']},{$T['perm_anon']}");
                    DB_delete($_TABLES['storysubmission'], "$id", $mid[$i]);
                    $approved++;

                    PLG_itemSaved($A['sid'], 'article');
                    COM_rdfUpToDateCheck();
                } elseif ($type === 'comment') {
                    $sid = CMT_approveModeration($mid[$i]);
                    $approved++;

                    if (!in_array($sid, $sidArray)) {
                        $sidArray[$i] = $sid;
                    }
                } else {
                    /**
                     * This is called in case this is a plugin. There may be some
                     * plugin specific processing that needs to happen.
                     */

                    // avoid unnecessary copy, e.g. for draft stories
                    if ($table != $submissionTable) {
                        DB_copy($table, $fields, $fields, $submissionTable, $id, $mid[$i]);
                    }
                    $retval .= PLG_approveSubmission($type, $mid[$i]);
                    $approved++;
                }
                break;
        }
    }

    // after loop update comment tree and count for each story
    if (count($sidArray) > 0) {
        foreach ($sidArray as $sid) {
            CMT_rebuildTree($sid);
            // update comment count of stories;
            $comments = DB_count($_TABLES['comments'], 'sid', $sid);
            DB_change($_TABLES['stories'], 'comments', $comments, 'sid', $sid);
        }
    }

    // Add new comment users to group comment.submit group
    if (isset($_POST['publishfuture']) && is_array($_POST['publishfuture'])) {
        foreach (Geeklog\Input::fPost('publishfuture') as $uid) {
            $uid = (int) $uid;

            if (($uid > 1) && !SEC_inGroup('Comment Submitters', $uid)) {
                SEC_addUserToGroup($uid, 'Comment Submitters');
            }
        }
    }

    // Check if there was no direct action used on the form
    // and if the delete_all submit action was used
    if (!$formAction && isset($_POST['delitem'])) {
        foreach (Geeklog\Input::fPost('delitem') as $delItem) {
            if (!empty($delItem)) {
                // There may be some plugin specific processing that needs
                // to happen first.
                $retval .= PLG_deleteSubmission($type, $delItem);

                // Notify plugins of a submission type that is deleted
                PLG_submissionDeleted($type);

                DB_delete($submissionTable, $id, $delItem);
                $deleted++;
            }
        }
    }

    $retval .= usersubmissions(SEC_createToken(), $approved, $deleted);

    return $retval;
}

/**
 * Moderate user submissions
 * Users from the user submission queue are either approved (an email containing
 * the password is sent out) or deleted.
 *
 * @param    int   $uid    Array of items
 * @param    array $action Action to perform ('delete', 'approve')
 * @param    int   $count  Number of items
 * @return   string              HTML for "command and control" page
 */
function moderateusers($uid, $action, $count)
{
    global $_CONF, $_TABLES, $LANG04;

    $retval = '';

    // Set true if an valid action other then delete_all is selected
    $formAction = false;
    $approved = 0;
    $deleted = 0;

    for ($i = 0; $i < $count; $i++) {
        if (isset($action[$i]) && ($action[$i] != '')) {
            $formAction = true;
        } else {
            continue;
        }

        switch ($action[$i]) {
            case 'delete': // Ok, delete everything related to this user
                if ($uid[$i] > 1) {
                    USER_deleteAccount($uid[$i]);
                    $deleted++;
                }
                break;

            case 'approve':
                $uid[$i] = COM_applyFilter($uid[$i], true);
                $result = DB_query("SELECT email,username, uid FROM {$_TABLES['users']} WHERE uid = $uid[$i]");
                $numRows = DB_numRows($result);

                if ($numRows == 1) {
                    $A = DB_fetchArray($result);
                    $sql = "UPDATE {$_TABLES['users']} SET status=3 WHERE uid={$A['uid']}";
                    DB_query($sql);
                    USER_createAndSendPassword($A['username'], $A['email'], $A['uid']);
                    $approved++;
                }
                break;
        }
    }

    // Check if there was no direct action used on the form
    // and if the delete_all submit action was used
    if (!$formAction && isset($_POST['delitem'])) {
        foreach (Geeklog\Input::fPost('delitem', array()) as $delUid) {
            $delUid = (int) $delUid;

            if ($delUid > 1) {
                USER_deleteAccount($delUid);
                $deleted++;
            }
        }
    }

    $retval .= usersubmissions(SEC_createToken(), $approved, $deleted);

    return $retval;
}

// MAIN
$display = '';

if ((Geeklog\Input::post('mode') === 'moderation') && SEC_checkToken()) {
    $action = Geeklog\Input::post('action', array());
    $id = Geeklog\Input::post('id');
    $type = Geeklog\Input::post('type');
    $count = (int) Geeklog\Input::fPost('count');

    if ($type === 'user') {
        $mod_result = moderateusers($id, $action, $count);
    } else {
        $mod_result = moderation($id, $action, $type, $count);
    }

    $display .= COM_showMessageFromParameter() . $mod_result;
} else {
    $display .= COM_showMessageFromParameter() . usersubmissions(SEC_createToken());
}

$display = COM_createHTMLDocument($display, array('pagetitle' => $LANG29[34]));

COM_output($display);
