<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | comment.php                                                               |
// |                                                                           |
// | Let user comment on a story or plugin.                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Vincent Furia     - vinny01 AT users DOT sourceforge DOT net     |
// |          Jared Wenerd      - wenerd87 AT gmail DOT com                    |
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
* This file is responsible for letting user enter a comment and saving the
* comments to the DB.  All comment display stuff is in lib-common.php
*
* @author   Jason Whittenburg
* @author   Tony Bibbs, tonyAT tonybibbs DOT com
* @author   Vincent Furia, vinny01 AT users DOT sourceforge DOT net
* @author   Jared Wenerd, wenerd87 AT gmail DOT com
*
*/

/**
* Geeklog common function library
*/
require_once 'lib-common.php';

/**
 * Geeklog comment function library
 */
require_once $_CONF['path_system'] . 'lib-comment.php';

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);


/**
 * Handles a comment submission
 *
 * @copyright Vincent Furia 2005
 * @author Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @return string HTML (possibly a refresh)
 */
function handleCancel()
{
    global $_CONF;
    
    $display = '';

    $type = COM_applyFilter ($_POST['type']);
    $sid = COM_applyFilter ($_POST['sid']);
    switch ( $type ) {
        case 'article':
            $display = COM_refresh (COM_buildUrl ($_CONF['site_url']
                . "/article.php?story=$sid"));

            break;
        default: // assume plugin
            // Need a way to go back to initial page for plugins.
            $url = PLG_getItemInfo($type, $sid, 'url');
            if ($url == '') { // Then plugin doesn't support PLG_getItemInfo
                $url = $_CONF['site_url'] . '/index.php';
            }
            $display = COM_refresh ($url);

            break;
    }

    return $display;
}

/**
 * Handles a comment submission
 *
 * @copyright Vincent Furia 2005
 * @author Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @return string HTML (possibly a refresh)
 */
function handleSubmit()
{
    global $_CONF, $_TABLES, $_USER, $LANG03;

    $display = '';

    $type = COM_applyFilter ($_POST['type']);
    $sid = COM_applyFilter ($_POST['sid']);
    switch ( $type ) {
        case 'article':
            $commentcode = DB_getItem ($_TABLES['stories'], 'commentcode',
                                       "sid = '$sid'" . COM_getPermSQL('AND')
                                       . " AND (draft_flag = 0) AND (date <= NOW()) "
                                       . COM_getTopicSQL('AND'));
            if (!isset($commentcode) || ($commentcode != 0)) {
                return COM_refresh($_CONF['site_url'] . '/index.php');
            }

            $ret = CMT_saveComment ( strip_tags ($_POST['title']), 
                $_POST['comment'], $sid, COM_applyFilter ($_POST['pid'], true), 
                'article', COM_applyFilter ($_POST['postmode']));

            if ($ret == -1) {
                $url = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                                    . $sid);
                $url .= (strpos($url, '?') ? '&' : '?') . 'msg=15';
                $display = COM_refresh($url);
            } elseif ( $ret > 0 ) { // failure //FIXME: some failures should not return to comment form
                $display .= COM_siteHeader ('menu', $LANG03[1])
                         . CMT_commentForm ($_POST['title'], $_POST['comment'],
                           $sid, COM_applyFilter($_POST['pid']), $type,
                           $LANG03[14], COM_applyFilter($_POST['postmode']))
                         . COM_siteFooter();
            } else { // success
                $comments = DB_count ($_TABLES['comments'], 'sid', $sid);
                DB_change ($_TABLES['stories'], 'comments', $comments, 'sid', $sid);
                COM_olderStuff (); // update comment count in Older Stories block
                $display = COM_refresh (COM_buildUrl ($_CONF['site_url']
                    . "/article.php?story=$sid"));
            }
            break;
        default: // assume plugin
            if ( !($display = PLG_commentSave($type, strip_tags ($_POST['title']), 
                                $_POST['comment'], $sid, COM_applyFilter ($_POST['pid'], true),
                                COM_applyFilter ($_POST['postmode']))) ) {
                $display = COM_refresh ($_CONF['site_url'] . '/index.php');
            }
            break;
    }

    return $display;
}

/**
 * Handles a comment delete
 *
 * @copyright Vincent Furia 2005
 * @author Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @return string HTML (possibly a refresh)
 */
function handleDelete($formtype)
{
    global $_CONF, $_TABLES;

    $display = '';
    
    if ($formtype == 'editsubmission') {
        DB_delete($_TABLES['commentsubmissions'], 'cid', COM_applyFilter($_REQUEST['cid'], true));

        $display = COM_refresh ( $_CONF['site_admin_url'] . '/moderation.php');      
    } else {
        $type = COM_applyFilter($_REQUEST['type']);
        $sid = COM_applyFilter($_REQUEST['sid']);    
        
        switch ($type) {
        case 'article':
            $has_editPermissions = SEC_hasRights('story.edit');
            $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'");
            $A = DB_fetchArray($result);
    
            if ($has_editPermissions && SEC_hasAccess($A['owner_id'],
                    $A['group_id'], $A['perm_owner'], $A['perm_group'],
                    $A['perm_members'], $A['perm_anon']) == 3) {
                CMT_deleteComment(COM_applyFilter($_REQUEST['cid'], true), $sid,
                                  'article');
                $comments = DB_count($_TABLES['comments'], 'sid', $sid);
                DB_change($_TABLES['stories'], 'comments', $comments,
                          'sid', $sid);
                $display .= COM_refresh(COM_buildUrl ($_CONF['site_url']
                                        . "/article.php?story=$sid") . '#comments');
            } else {
                COM_errorLog("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) tried to illegally delete comment $cid from $type $sid");
                $display .= COM_refresh($_CONF['site_url'] . '/index.php');
            }
            break;
    
        default: // assume plugin
            if (!($display = PLG_commentDelete($type, 
                                COM_applyFilter($_REQUEST['cid'], true), $sid))) {
                $display = COM_refresh($_CONF['site_url'] . '/index.php');
            }
            break;
        }
    }
    
    return $display;
}

/**
 * Handles a comment view request
 *
 * @copyright Vincent Furia 2005
 * @author Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param boolean $view View or display (true for view)
 * @return string HTML (possibly a refresh)
 */
function handleView($view = true)
{
    global $_CONF, $_TABLES, $_USER, $LANG_ACCESS;

    $display = '';

    if ($view) {
        $cid = COM_applyFilter ($_REQUEST['cid'], true);
    } else {
        $cid = COM_applyFilter ($_REQUEST['pid'], true);
    }

    if ($cid <= 0) {
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }
    
    $sql = "SELECT sid, title, type FROM {$_TABLES['comments']} WHERE cid = $cid";
    $A = DB_fetchArray( DB_query($sql) );
    $sid   = $A['sid'];
    $title = $A['title'];
    $type  = $A['type'];

    $format = $_CONF['comment_mode'];
    if( isset( $_REQUEST['format'] )) {
        $format = COM_applyFilter( $_REQUEST['format'] );
    }
    if ( $format != 'threaded' && $format != 'nested' && $format != 'flat' ) {
        if (COM_isAnonUser()) {
            $format = $_CONF['comment_mode'];
        } else {
            $format = DB_getItem( $_TABLES['usercomment'], 'commentmode', 
                                  "uid = {$_USER['uid']}" );
        }
    }

    switch ( $type ) {
        case 'article':
            $sql = 'SELECT COUNT(*) AS count, commentcode, owner_id, group_id, perm_owner, perm_group, '
                 . "perm_members, perm_anon FROM {$_TABLES['stories']} WHERE (sid = '$sid') "
                 . 'AND (draft_flag = 0) AND (commentcode >= 0) AND (date <= NOW())' . COM_getPermSQL('AND') 
                 . COM_getTopicSQL('AND') . ' GROUP BY sid,owner_id, group_id, perm_owner, perm_group,perm_members, perm_anon ';
            $result = DB_query ($sql);
            $B = DB_fetchArray ($result);
            $allowed = $B['count'];

            if ( $allowed == 1 ) {
                $delete_option = ( SEC_hasRights( 'story.edit' ) &&
                    ( SEC_hasAccess( $B['owner_id'], $B['group_id'],
                        $B['perm_owner'], $B['perm_group'], $B['perm_members'],
                        $B['perm_anon'] ) == 3 ) );
                $order = '';
                if (isset ( $_REQUEST['order'])) {
                    $order = COM_applyFilter ($_REQUEST['order']);
                }
                $page = 0;
                if (isset ($_REQUEST['page'])) {
                    $page = COM_applyFilter ($_REQUEST['page'], true);
                }
                $display .= CMT_userComments ($sid, $title, $type, $order,
                                $format, $cid, $page, $view, $delete_option,
                                $B['commentcode']);
            } else {
                $display .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                                    COM_getBlockTemplate ('_msg_block', 'header'))
                         . $LANG_ACCESS['storydenialmsg']
                         . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            }
            break;

        default: // assume plugin
            $order = '';
            if (isset($_REQUEST['order'])) {
                $order = COM_applyFilter($_REQUEST['order']);
            }
            $page = 0;
            if (isset($_REQUEST['page'])) {
                $page = COM_applyFilter($_REQUEST['page'], true);
            }
            if ( !($display = PLG_displayComment($type, $sid, $cid, $title,
                                  $order, $format, $page, $view)) ) {
                return COM_refresh($_CONF['site_url'] . '/index.php');
            }
            break;
    }

    return COM_siteHeader('menu', $title)
           . COM_showMessageFromParameter()
           . $display
           . COM_siteFooter();
}

/**
 * Handles a comment edit submission
 *
 * @copyright Jared Wenerd 2008
 * @author Jared Wenerd, wenerd87 AT gmail DOT com
 * @param  string $mode 'edit' or 'editsubmission'
 * @return string HTML (possibly a refresh)
 */
function handleEdit($mode)
{
    global $_TABLES, $LANG03;
    
    //get needed data
    $cid = COM_applyFilter ($_REQUEST['cid']);
    if ($mode == 'editsubmission') {
        $table = $_TABLES['commentsubmissions'];
        $result = DB_query("SELECT type, sid FROM {$_TABLES['commentsubmissions']} WHERE cid = $cid");
        list($type, $sid) = DB_fetchArray($result);
    } else {
        $sid = COM_applyFilter ($_REQUEST['sid']);
        $type = COM_applyFilter ($_REQUEST['type']);
        $table = $_TABLES['comments'];
    }
    
    //check for bad data 
    if (!is_numeric ($cid) || ($cid < 0) || empty ($sid) || empty ($type)) {
        COM_errorLog("handleEdit(): {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
               . 'to edit a comment with one or more missing/bad values.');
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }
        
    $result = DB_query ("SELECT title,comment FROM $table "
        . "WHERE cid = $cid AND sid = '$sid' AND type = '$type'"); 
    if ( DB_numRows($result) == 1 ) {
        $A = DB_fetchArray ($result);
        $title = COM_stripslashes($A['title']);
        $commenttext = COM_stripslashes(COM_undoSpecialChars ($A['comment']));
        
        //remove signature   
        $pos = strpos( $commenttext,'<!-- COMMENTSIG --><span class="comment-sig">');
        if ( $pos > 0) { 
            $commenttext = substr($commenttext, 0, $pos);
        }
        
        //get format mode
        if ( preg_match( '/<.*>/', $commenttext ) != 0 ){
            $postmode = 'html';
        } else {
            $postmode = 'plaintext';
        }
    } else {
        COM_errorLog("handleEdit(): {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
               . 'to edit a comment that doesn\'t exist as described.');
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }
            
    return COM_siteHeader('menu', $LANG03[1])
           . CMT_commentForm($title, $commenttext, $sid, $cid, $type, $mode,
                             $postmode)
           . COM_siteFooter();
}


// MAIN
CMT_updateCommentcodes();
$display = '';

// If reply specified, force comment submission form
if (isset ($_REQUEST['reply'])) {
    $_REQUEST['mode'] = '';
}

$mode = '';
if (!empty ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}
$formtype = '';
if (!empty ($_REQUEST['formtype'])) {
    $formtype = COM_applyFilter ($_REQUEST['formtype']);
}
switch ($mode) {
case $LANG03[28]: // Preview Changes (for edit)
case $LANG03[34]: // Preview Submission changes (for edit)
case $LANG03[14]: // Preview
    $display .= COM_siteHeader('menu', $LANG03[14])
             . CMT_commentForm (strip_tags ($_POST['title']), $_POST['comment'],
                    COM_applyFilter ($_POST['sid']),
                    COM_applyFilter ($_POST['pid'], true),
                    COM_applyFilter ($_POST['type']), $mode,
                    COM_applyFilter ($_POST['postmode']))
             . COM_siteFooter(); 
    break;

case $LANG03[35]: // Submit Changes to Moderation table
case $LANG03[29]: // Submit Changes
    if (SEC_checkToken()) {
        $display .= CMT_handleEditSubmit($mode);
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
    break;
    
case $LANG03[11]: // Submit Comment
    $display .= handleSubmit();  // moved to function for readibility
    break;

case $LANG_ADMIN['delete']:    
case 'delete':
    if (SEC_checkToken()) {
        $display .= handleDelete($formtype);  // moved to function for readibility
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
    break;

case 'view':
    $display .= handleView(true);  // moved to function for readibility
    break;

case 'display':
    $display .= handleView(false);  // moved to function for readibility
    break;

case 'report':
    $display .= COM_siteHeader('menu', $LANG03[27])
             . CMT_reportAbusiveComment(COM_applyFilter($_GET['cid'], true),
                                        COM_applyFilter($_GET['type']))
             . COM_siteFooter();
    break;

case 'sendreport':
    if (SEC_checkToken()) {
        $display .= CMT_sendReport(COM_applyFilter($_POST['cid'], true),
                                   COM_applyFilter($_POST['type']));
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
    break;

case 'editsubmission':
    if (!SEC_hasRights('comment.moderate')) { 
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
        break; 
    }
    // deliberate fall-through
case 'edit':
    $display .= handleEdit($mode);
    break;

case 'unsubscribe':
    $cid = 0;
    $key = COM_applyFilter($_GET['key']);
    if (! empty($key)) {
        $key = addslashes($key);
        $cid = DB_getItem($_TABLES['commentnotifications'], 'cid',
                          "deletehash = '$key'");
        if (! empty($cid)) {
            $redirecturl = $_CONF['site_url']
                         . '/comment.php?mode=view&amp;cid=' . $cid
                         . '&amp;format=nested&amp;msg=16';
            DB_delete($_TABLES['commentnotifications'], 'deletehash', $key,
                      $redirecturl);
            exit;
        }
    }
    $display = COM_refresh($_CONF['site_url'] . '/index.php');
    break;
case $LANG_ADMIN['cancel']:
    if ($formtype == 'editsubmission') {
        $display = COM_refresh ( $_CONF['site_admin_url'] . '/moderation.php');        
    } else {
        $display .= handleCancel();  // moved to function for readibility
    }
    break;
default:  // New Comment
    $abort = false;
    $sid = '';
    if (isset($_REQUEST['sid'])) {
        $sid = COM_applyFilter($_REQUEST['sid']);
    }
    $type = 'article';
    if (isset($_REQUEST['type'])) {
        $type = COM_applyFilter($_REQUEST['type']);
    }
    $title = '';
    if (isset($_REQUEST['title'])) {
        $title = strip_tags($_REQUEST['title']);
    }
    $postmode = $_CONF['postmode'];
    if (isset($_REQUEST['postmode'])) {
        $postmode = COM_applyFilter($_REQUEST['postmode']);
    }

    if (($type == 'article') && !empty($sid)) {
        $dbTitle = DB_getItem($_TABLES['stories'], 'title',
                    "(sid = '$sid') AND (draft_flag = 0) AND (date <= NOW()) AND (commentcode = 0)"
                    . COM_getPermSQL('AND') . COM_getTopicSQL('AND'));
        if ($dbTitle === null) {
            // no permissions, or no story of that title
            $display = COM_refresh($_CONF['site_url'] . '/index.php');
            $abort = true;
        }
    }
    if (!$abort) {
        if (!empty($sid) && !empty($type)) {
            if (empty($title)) {
                if ($type == 'article') {
                    $title = $dbTitle;
                } else {
                    $title = PLG_getItemInfo($type, $sid, 'title');
                }
                $title = str_replace ('$', '&#36;', $title);
                // CMT_commentForm expects non-htmlspecial chars for title...
                $title = str_replace ( '&amp;', '&', $title );
                $title = str_replace ( '&quot;', '"', $title );
                $title = str_replace ( '&lt;', '<', $title );
                $title = str_replace ( '&gt;', '>', $title );
            }
            $noindex = '<meta name="robots" content="noindex"' . XHTML . '>'
                     . LB;
            $pid = 0;
            if (isset($_REQUEST['pid'])) {
                $pid = COM_applyFilter($_REQUEST['pid'], true);
            }
            $display .= COM_siteHeader('menu', $LANG03[1], $noindex)
                     . CMT_commentForm($title, '', $sid, $pid, $type, $mode,
                                       $postmode)
                     . COM_siteFooter();
        } else {
            $display .= COM_refresh($_CONF['site_url'] . '/index.php');
        }
    }
    break;
}

COM_output($display);

?>
