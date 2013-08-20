<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | moderation.php                                                            |
// |                                                                           |
// | Geeklog main administration page.                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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
require_once $_CONF['path_system'] . 'lib-story.php';
require_once $_CONF['path_system'] . 'lib-comment.php';

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
* @param    string  $token  CSRF token
* @return   string          HTML for the C&C block
*
*/
function usersubmissions($token)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG29, $_IMAGE_TYPE;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    // writing the menu on top
    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home'])
    );

    $retval .= COM_startBlock($LANG29[13], '',
                              COM_getBlockTemplate('_admin_block', 'header'));
    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG29['submissions_desc'],
        $_CONF['layout_url'] . '/images/icons/moderation.'. $_IMAGE_TYPE
    );    

    // IMPORTANT - If any of the below submission lists change, please 
    // update the function SEC_hasModerationAccess in lib-security.php to 
    // reflect the changes
    
    if (SEC_hasRights('story.moderate')) {
        $retval .= itemlist('story', $token);
    }

    if ($_CONF['listdraftstories'] == 1) {
        if (SEC_hasRights('story.edit')) {
            $retval .= itemlist('story_draft', $token);
        }
    }
    
    if ($_CONF['commentsubmission'] == 1) {
        if (SEC_hasRights('comment.moderate')) {
            $retval .= itemlist('comment', $token);
        }
    }

    if ($_CONF['usersubmission'] == 1) {
        if (SEC_hasRights('user.edit') && SEC_hasRights('user.delete')) {
            $retval .= userlist($token);
        }
    }

    $retval .= PLG_showModerationList($token);
    
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
* Displays items needing moderation
*
* Displays the moderation list of items from the submission tables
*
* @param    string  $type   Type of object to build list for
* @param    string  $token  CSRF token
* @return   string          HTML for the list of items
*
*/
function itemlist($type, $token)
{
    global $_CONF, $_TABLES, $LANG29, $LANG_ADMIN;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    if (empty($type)) {
        // something is terribly wrong, bail
        COM_errorLog("Submission type not set in moderation.php");
        return $retval;
    }

    $isplugin = false;

    if ($type == 'comment') {
        $sql = "SELECT cid AS id,title,comment,date,uid,type,sid "
              . "FROM {$_TABLES['commentsubmissions']} "
              . "ORDER BY cid ASC";
        $H = array($LANG29[10], $LANG29[36], $LANG29[14]);
        $section_title = $LANG29[41];
        $section_help = 'cccommentsubmission.html';
    } else {
        $function = 'plugin_itemlist_' . $type;
        if (function_exists($function)) {
            // Great, we found the plugin, now call its itemlist method
            $plugin = $function();
            if (is_object($plugin)) {
                $helpfile = $plugin->submissionhelpfile;
                $sql = $plugin->getsubmissionssql;
                $H = $plugin->submissionheading;
                $section_title = $plugin->submissionlabel;
                $section_help = $helpfile;
                if (($type != 'story') && ($type != 'story_draft')) {
                    $isplugin = true;
                }
            } else if (is_string($plugin)) {
                return '<div class="block-box">' . $plugin . '</div>' . LB;
            }
        }
    }

    // run SQL but this time ignore any errors
    if (!empty($sql)) {
        $sql .= ' LIMIT 50'; // quick'n'dirty workaround to prevent timeouts
        $result = DB_query($sql, 1);
    }
    if (empty($sql) || DB_error()) {
        // was more than likely a plugin that doesn't need moderation
        $nrows = 0;
        return;
    } else {
        $nrows = DB_numRows($result);
    }
    $data_arr = array();
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        /**
         * @todo There should be an API for these URLs ...
         */
        if ($isplugin) {
            $A['edit'] = $_CONF['site_admin_url'] . '/plugins/' . $type
                     . '/index.php?mode=editsubmission&amp;id=' . $A[0];
        } elseif ($type == 'comment') {
            $A['edit'] = $_CONF['site_url'] . '/comment.php'
                    . '?mode=editsubmission&amp;cid=' . $A[0];
        } elseif ($type == 'story_draft') {
            $A['edit'] = $_CONF['site_admin_url'] . '/story.php'
                     . '?mode=edit&amp;sid=' . $A[0];
        } else { // this pretty much only leaves $type == 'story'
            $A['edit'] = $_CONF['site_admin_url'] . '/' .  $type
                     . '.php?mode=editsubmission&amp;id=' . $A[0];
        }
        $A['row'] = $i;
        $A['_moderation_type'] = $type;
        $data_arr[$i] = $A;
    }

    if ($type == 'comment') {
        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_ADMIN['edit'], 'field' => 0),
            array('text' => $H[0], 'field' => 1),
            array('text' => $H[1], 'field' => 2),
            array('text' => $H[2], 'field' => 3),
            array('text' => $LANG29[2], 'field' => 'delete'),
            array('text' => $LANG29[1], 'field' => 'approve'),
            array('text' => $LANG29[42], 'field' => 'uid'),
            array('text' => $LANG29[43], 'field' => 'publishfuture')
        );            
    } elseif ($type == 'story' || $type == 'story_draft') {
        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_ADMIN['edit'], 'field' => 0),
            array('text' => $H[0], 'field' => 1),
            array('text' => $H[1], 'field' => 'uid'),
            array('text' => $H[2], 'field' => 3),
            array('text' => $H[3], 'field' => 4),
            array('text' => $LANG29[2], 'field' => 'delete'),
            array('text' => $LANG29[1], 'field' => 'approve')
        );            
    } else {
        $header_arr = array(      // display 'text' and use table field 'field'
            array('text' => $LANG_ADMIN['edit'], 'field' => 0),
            array('text' => $H[0], 'field' => 1),
            array('text' => $H[1], 'field' => 2),
            array('text' => $H[2], 'field' => 3),
            array('text' => $LANG29[2], 'field' => 'delete'),
            array('text' => $LANG29[1], 'field' => 'approve')
        );          
    }

    $text_arr = array('has_menu' => false,
                      'title'    => $section_title,
                      'help_url' => $section_help,
                      'no_data'  => $LANG29[39],
                      'form_url' => "{$_CONF['site_admin_url']}/moderation.php"
    );
    $form_arr = array('bottom' => '', 'top' => '');
    if ($nrows > 0) {
        $form_arr['bottom'] = '<input type="hidden" name="type" value="' . $type . '"' . XHTML . '>' . LB
                . '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $token . '"'. XHTML . '>' . LB
                . '<input type="hidden" name="mode" value="moderation"' . XHTML . '>' . LB
                . '<input type="hidden" name="count" value="' . $nrows . '"' . XHTML . '>'
                . '<p class="aligncenter"><input type="submit" value="'
                . $LANG_ADMIN['submit'] . '"' . XHTML . '></p>' . LB;
    }

    $listoptions = array('chkdelete' => true, 'chkfield' => 'id');
    $retval .= ADMIN_simpleList('ADMIN_getListField_moderation', $header_arr,
                                $text_arr, $data_arr, $listoptions, $form_arr);

    return $retval;
}

/**
* Displays new user submissions
*
* When enabled, this will list all the new users which have applied for a
* site membership. When approving an application, an email containing the
* password is sent out immediately.
*
* @param    string  $token  CSRF token
* @return   string          HTML for the list of users
*
*/
function userlist($token)
{
    global $_CONF, $_TABLES, $LANG29, $LANG_ADMIN;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';
    $sql = "SELECT uid as id,username,fullname,email FROM {$_TABLES['users']} WHERE status = 2";
    $result = DB_query ($sql);
    $nrows = DB_numRows($result);
    $data_arr = array();
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $A['edit'] = $_CONF['site_admin_url'].'/user.php?mode=edit&amp;uid='.$A['id'];
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
        array('text' => $LANG29[1], 'field' => 'approve')
    );

    $text_arr = array('has_menu'  => false,
                      'title'     => $LANG29[40],
                      'help_url'  => 'ccusersubmission.html',
                      'no_data'   => $LANG29[39],
                      'form_url'  => "{$_CONF['site_admin_url']}/moderation.php"
    );

    $listoptions = array('chkdelete' => true, 'chkfield' => 'id');

    $form_arr = array("bottom" => '', "top" => '');
    if ($nrows > 0) {
        $form_arr['bottom'] = '<input type="hidden" name="type" value="user"' . XHTML . '>' . LB
                . '<input type="hidden" name="' . CSRF_TOKEN . '" value="' . $token . '"'. XHTML . '>' . LB
                . '<input type="hidden" name="mode" value="moderation"' . XHTML . '>' . LB
                . '<input type="hidden" name="count" value="' . $nrows . '"' . XHTML . '>'
                . '<p align="center"><input type="submit" value="'
                . $LANG_ADMIN['submit'] . '"' . XHTML . '></p>' . LB;
    }

    $table = ADMIN_simpleList('ADMIN_getListField_moderation', $header_arr,
                              $text_arr, $data_arr, $listoptions, $form_arr);
    $retval .= $table;


    return $retval;
}

/**
* Moderates an item
*
* This will actually perform moderation (approve or delete) one or more items
*
* @param    array   $mid        Array of items
* @param    array   $action     Array of actions to perform on items
* @param    string  $type       Type of items ('story', etc.)
* @param    int     $count      Number of items to moderate
* @return   string              HTML for "command and control" page
*
*/
function moderation($mid, $action, $type, $count)
{
    global $_CONF, $_TABLES;

    $retval = '';

    if (empty($type)) {
        // something is terribly wrong, bail
        $retval .= COM_errorLog("Submission type not set in moderation.php");
        return $retval;
    }

    if ($type == 'comment') {
        $id = 'cid';
        $table = $_TABLES['comments'];
        $submissiontable = $_TABLES['commentsubmissions'];
        $sidArray[] = '';
    } else {
        list($id, $table, $fields, $submissiontable) = PLG_getModerationValues($type);
    }

    // Set true if a valid action other than delete_all is selected
    $formaction = false;

    for ($i = 0; $i < $count; $i++) {
        if (isset($action[$i]) AND ($action[$i] != '')) {
            $formaction = true;
        } else {
            continue;
        }

        switch ($action[$i]) {
        case 'delete':
            if (empty($mid[$i])) {
                $retval .= COM_errorLog("moderation.php just tried deleting everything in table $submissiontable because it got an empty id.  Please report this immediately to your site administrator");
                return $retval;
            }

            // There may be some plugin specific processing that needs to
            // happen first.
            $retval .= PLG_deleteSubmission($type, $mid[$i]);
            
            // Notify plugins of a submission that is deleted
            PLG_submissionDeleted($type);

            DB_delete($submissiontable, $id, $mid[$i]);
            break;

        case 'approve':
            if ($type == 'story') {
                $sql = "SELECT *, ta.tid 
                    FROM {$_TABLES['storysubmission']}, {$_TABLES['topic_assignments']} ta 
                    WHERE ta.type = 'article' AND ta.id = sid  AND sid = '$mid[$i]'";
                
                $result = DB_query ($sql);
                $A = DB_fetchArray ($result);
                $A['related'] = DB_escapeString(implode ("\n", STORY_extractLinks ($A['introtext'])));
                $A['owner_id'] = $A['uid'];
                $A['title'] = DB_escapeString($A['title']);
                $A['introtext'] = DB_escapeString($A['introtext']);
                $A['bodytext'] = DB_escapeString( $A['bodytext'] );
                $result = DB_query ("SELECT group_id,perm_owner,perm_group,perm_members,perm_anon,archive_flag FROM {$_TABLES['topics']} WHERE tid = '{$A['tid']}'");
                $T = DB_fetchArray ($result);
                if ($T['archive_flag'] == 1) {
                    $frontpage = 0;
                } elseif (isset ($_CONF['frontpage'])) {
                    $frontpage = $_CONF['frontpage'];
                } else {
                    $frontpage = 1;
                }
                DB_save ($_TABLES['stories'],'sid,uid,title,introtext,bodytext,related,date,show_topic_icon,commentcode,trackbackcode,postmode,frontpage,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',
                "'{$A['sid']}',{$A['uid']},'{$A['title']}','{$A['introtext']}','{$A['bodytext']}','{$A['related']}','{$A['date']}','{$_CONF['show_topic_icon']}','{$_CONF['comment_code']}','{$_CONF['trackback_code']}','{$A['postmode']}',$frontpage,{$A['owner_id']},{$T['group_id']},{$T['perm_owner']},{$T['perm_group']},{$T['perm_members']},{$T['perm_anon']}");
                DB_delete($_TABLES['storysubmission'],"$id",$mid[$i]);

                PLG_itemSaved($A['sid'], 'article');
                COM_rdfUpToDateCheck ();
            } elseif ($type == 'comment') {
                $sid = CMT_approveModeration($mid[$i]);
                if (! in_array($sid, $sidArray)) {
                    $sidArray[$i] = $sid; 
                }
            } else {
                /**
                * This is called in case this is a plugin. There may be some
                * plugin specific processing that needs to happen.
                */

                // avoid unnecessary copy, e.g. for draft stories
                if ($table != $submissiontable) {
                    DB_copy($table, $fields, $fields,
                            $submissiontable, $id, $mid[$i]);
                }
                $retval .= PLG_approveSubmission($type, $mid[$i]);
            }
            break;
        }
    }

    // after loop update comment tree and count for each story
    if (isset($sidArray)) {
        foreach ($sidArray as $sid) {
            CMT_rebuildTree($sid);
            // update comment count of stories;
            $comments = DB_count($_TABLES['comments'], 'sid', $sid);
            DB_change($_TABLES['stories'], 'comments', $comments, 'sid', $sid);
        }
    }

    // Add new comment users to group comment.submit group
    if (isset($_POST['publishfuture']) ) {
        for ($i = 0; $i < count($_POST['publishfuture']); $i++ ) {
            $uid =  COM_applyFilter($_POST['publishfuture'][$i], true);
            if ($uid > 1 && !SEC_inGroup('Comment Submitters', $uid)) {
                SEC_addUserToGroup($uid, 'Comment Submitters');
            }
        }
    }

    // Check if there was no direct action used on the form
    // and if the delete_all submit action was used
    if (!$formaction AND isset($_POST['delitem'])) {
        foreach ($_POST['delitem'] as $delitem) {
            $delitem = COM_applyFilter($delitem);
            if (! empty($delitem)) {
                // There may be some plugin specific processing that needs
                // to happen first.
                $retval .= PLG_deleteSubmission($type, $delitem);
                
                // Notify plugins of a submission type that is deleted
                PLG_submissionDeleted($type);

                DB_delete($submissiontable, $id, $delitem);
            }
        }
    }

    $retval .= usersubmissions(SEC_createToken());

    return $retval;
}

/**
* Moderate user submissions
*
* Users from the user submission queue are either appoved (an email containing
* the password is sent out) or deleted.
*
* @param    int     $uid        Array of items
* @param    array   $action     Action to perform ('delete', 'approve')
* @param    int     $count      Number of items
* @return   string              HTML for "command and control" page
*
*/
function moderateusers ($uid, $action, $count)
{
    global $_CONF, $_TABLES, $LANG04;

    $retval = '';

    // Set true if an valid action other then delete_all is selected
    $formaction = false;

    for ($i = 0; $i < $count; $i++) {
        if (isset($action[$i]) AND ($action[$i] != '')) {
            $formaction = true;
        } else {
            continue;
        }

        switch ($action[$i]) {
        case 'delete': // Ok, delete everything related to this user
            if ($uid[$i] > 1) {
                USER_deleteAccount($uid[$i]);
            }
            break;

        case 'approve':
            $uid[$i] = COM_applyFilter($uid[$i], true);
            $result = DB_query("SELECT email,username, uid FROM {$_TABLES['users']} WHERE uid = $uid[$i]");
            $nrows = DB_numRows($result);
            if ($nrows == 1) {
                $A = DB_fetchArray($result);
                $sql = "UPDATE {$_TABLES['users']} SET status=3 WHERE uid={$A['uid']}";
                DB_query($sql);
                USER_createAndSendPassword($A['username'], $A['email'], $A['uid']);
            }
            break;
        }
    }

    // Check if there was no direct action used on the form
    // and if the delete_all submit action was used
    if (!$formaction AND isset($_POST['delitem'])) {
        foreach ($_POST['delitem'] as $del_uid) {
            $del_uid = COM_applyFilter($del_uid,true);
            if ($del_uid > 1) {
                USER_deleteAccount($del_uid);
            }
        }
    }

    $retval .= usersubmissions(SEC_createToken());

    return $retval;
}

// MAIN

$display = '';

if (isset($_POST['mode']) && ($_POST['mode'] == 'moderation') &&
        SEC_checkToken()) {
    $action = array();
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
    }
    if ($_POST['type'] == 'user') {
        $mod_result = moderateusers($_POST['id'], $action,
                                    COM_applyFilter($_POST['count'], true));
    } else {
        $mod_result = moderation($_POST['id'], $action, $_POST['type'],
                                 COM_applyFilter($_POST['count'], true));
    }
    $display .= COM_showMessageFromParameter()
             .  $mod_result;
} else {
    $display .= COM_showMessageFromParameter()
             .  usersubmissions(SEC_createToken());
}

$display = COM_createHTMLDocument($display, array('pagetitle' => $LANG29[34]));

COM_output($display);

?>
