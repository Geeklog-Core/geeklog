<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | comment.php                                                               |
// |                                                                           |
// | Let user comment on a story, poll, or plugin.                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
// |          Vincent Furia     - vinny01@users.sourceforge.net                |
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
// $Id: comment.php,v 1.88 2005/01/25 04:04:15 vinny Exp $

/**
* This file is responsible for letting user enter a comment and saving the
* comments to the DB.  All comment display stuff is in lib-common.php
*
* @author   Jason Whittenburg
* @author   Tony Bibbs  <tony@tonybibbs.com>
*
*/

/**
* Geeklog common function library
*/
require_once('lib-common.php');

/**
 * Geeklog comment function library
 */
require_once( $_CONF['path_system'] . 'lib-comment.php' );

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

/**
 * Hanldes a comment submission
 *
 * @copyright Vincent Furia 2005
 * @author Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @return string HTML (possibly a refresh)
 */
function handleSubmit() {
    global $_POST, $_TABLES, $_CONF, $LANG03;

    $type = COM_applyFilter ($_POST['type']);
    $sid = COM_applyFilter ($_POST['sid']);
    switch ( $type ) {
        case 'article':
            $commentcode = DB_getItem ($_TABLES['stories'], 'commentcode',
                                       "sid = '$sid'");
            if ($commentcode < 0) {
                return COM_refresh ($_CONF['site_url'] . '/index.php');
            }

            $ret .= CMT_saveComment ( strip_tags ($_POST['title']), $_POST['comment'], 
                    $sid, COM_applyFilter ($_POST['pid'], true), 'article',
                    COM_applyFilter ($_POST['postmode']));

            if ( $ret > 0 ) { // failure
                $display .= COM_siteHeader()
                    . CMT_commentform ($uid, $title, $comment, $sid, $pid, 
                            $type, $LANG03[14], $postmode)
                    . COM_siteFooter();
            } else { // success
                $comments = DB_count ($_TABLES['comments'], 'sid', $sid);
                DB_change ($_TABLES['stories'], 'comments', $comments, 'sid', $sid);
                COM_olderStuff (); // update comment count in Older Stories block
                $display = COM_refresh (COM_buildUrl ($_CONF['site_url']
                    . "/article.php?story=$sid"));
            }
            break;

        case 'poll':
            $commentcode = DB_getItem ($_TABLES['pollquestions'], 'commentcode',
                                       "qid = '$sid'");
            if ($commentcode < 0) {
                return COM_refresh ($_CONF['site_url'] . '/index.php');
            }

            $ret .= CMT_saveComment (strip_tags ($_POST['title']), $_POST['comment'], 
                    $sid, COM_applyFilter ($_POST['pid'], true), 'poll',
                    COM_applyFilter ($_POST['postmode']));

            if ( $ret > 0 ) { // failure
                $display .= COM_siteHeader()
                    . CMT_commentform ($uid, $title, $comment, $sid, $pid, 
                            $type, $LANG03[14], $postmode)
                    . COM_siteFooter();
            } else { // success
                $display = COM_refresh ($_CONF['site_url']
                    . "/pollbooth.php?qid=$sid&aid=-1");
            }
            break;

        default: // assume plugin
            if ( !($display = PLG_handlePluginComment($type, null, 'save')) ) {
                $display = COM_refresh ($_CONF['site_url'] . '/index.php');
            }
            break;
    }

    return $display;
}

/**
 * Hanldes a comment submission
 *
 * @copyright Vincent Furia 2005
 * @author Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @return string HTML (possibly a refresh)
 */
function handleDelete() {
    global $_REQUEST, $_TABLES, $_CONF;

    $type = COM_applyFilter ($_REQUEST['type']);
    $sid = COM_applyFilter ($_REQUEST['sid']);
    switch ( $type ) {
        case 'article':
            $has_editPermissions = SEC_hasRights ('story.edit');
            $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'");
            $A = DB_fetchArray ($result);

            if ($has_editPermissions && SEC_hasAccess ($A['owner_id'],
                    $A['group_id'], $A['perm_owner'], $A['perm_group'],
                    $A['perm_members'], $A['perm_anon']) == 3) {
                $ret .= CMT_deleteComment(COM_applyFilter($_REQUEST['cid'], true), $sid, 'article');
                $comments = DB_count ($_TABLES['comments'], 'sid', $sid);
                DB_change ($_TABLES['stories'], 'comments', $comments,
                           'sid', $sid);
                $display .= COM_refresh (COM_buildUrl ($_CONF['site_url']
                                . "/article.php?story=$sid") . '#comments');
            } else {
                COM_errorLog ("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) "
                            . "tried to illegally delete comment $cid from $type $sid");
                $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
            }
            break;

        case 'poll':
            $has_editPermissions = SEC_hasRights ('poll.edit');
            $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid = '{$sid}'");
            $A = DB_fetchArray ($result);

            if ($has_editPermissions && SEC_hasAccess ($A['owner_id'],
                    $A['group_id'], $A['perm_owner'], $A['perm_group'],
                    $A['perm_members'], $A['perm_anon']) == 3) {
                $ret .= CMT_deleteComment(COM_applyFilter($_REQUEST['cid'], true), $sid, 'poll');
                $display .= COM_refresh ($_CONF['site_url'] . "/pollbooth.php?qid=$sid&aid=-1");
            } else {
                COM_errorLog ("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) "
                            . "tried to illegally delete comment $cid from $type $sid");
                $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
            }
            break;

        default: //assume plugin
            if ( !($display = PLG_handlePluginComment($type, 
                    COM_applyFilter($_REQUEST['cid'], true), 'delete')) ) {
                $display = COM_refresh ($_CONF['site_url'] . '/index.php');
            }
            break;
    }

    return $display;
}


// MAIN
$display = '';

if (isset ($_REQUEST['reply'])) {
    $_REQUEST['mode'] = '';
}

switch ( $_REQUEST['mode'] ) {
case $LANG03[14]: // Preview
    $display .= COM_siteHeader()
        . CMT_commentForm ( strip_tags ($_POST['title']), $_POST['comment'],
            COM_applyFilter ($_POST['sid']), COM_applyFilter ($_POST['pid'], true),
            COM_applyFilter ($_POST['type']), COM_applyFilter ($_POST['mode']),
            COM_applyFilter ($_POST['postmode']))
        . COM_siteFooter(); 
    break;

case $LANG03[11]: // Submit Comment
    $display = handleSubmit();  // moved to function for readibility
    break;

case 'delete':
    $display = handleDelete();  // moved to function for readibility
    break;

case 'view':
    $cid = COM_applyFilter ($_REQUEST['cid'], true);
    if ($cid > 0) {
        $sql = "SELECT sid, title, type FROM {$_TABLES['comments']} WHERE cid = $cid";
        $A = DB_fetchArray( DB_query($sql) );
        $sid = $A['sid'];
        $title = $A['title'];
        $type = $A['type'];
        $allowed = 1;
        if ($type == 'article') {
            $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE (sid = '$sid') AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND') . COM_getTopicSQL ('AND'));
            $A = DB_fetchArray ($result);
            $allowed = $A['count'];
        } else if ($type == 'poll') {
            $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['pollquestions']} WHERE (qid = '$sid')" . COM_getPermSQL ('AND'));
            $A = DB_fetchArray ($result);
            $allowed = $A['count'];
        }
        $display .= COM_siteHeader();
        if ($allowed == 1) {
            $format = COM_applyFilter ($_REQUEST['format']);
            if ( $format != 'threaded' && $format != 'nested' && $format != 'flat' ) {
                if ( $_USER['uid'] > 1 ) {
                    $format = DB_getItem( $_TABLES['usercomment'], 'commentmode', 
                                          "uid = {$_USER['uid']}" );
                } else {
                    $format = $_CONF['comment_mode'];
                }
            }
            if ($type == 'poll' || $type == 'article') {
                if ( $type == 'poll' ) {
                    $delete_option = SEC_hasRights( 'poll.edit' );
                } else {
                    $delete_option = SEC_hasRights( 'story.edit' );
                }
                $delete_option = ( $delete_option &&
                    SEC_hasAccess( $A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon'] ) == 3 ? true : false );
            } else {
                $delete_option = false;
            }
            $display .= CMT_userComments ($sid, $title, $type, 
                            COM_applyFilter ($_REQUEST['order']), $format, $cid,
                            COM_applyFilter ($_REQUEST['page'], true), true, $delete_option);
        } else {
            $display .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                                COM_getBlockTemplate ('_msg_block', 'header'))
                     . $LANG_ACCESS['storydenialmsg']
                     . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        }
        $display .= COM_siteFooter();
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
    break;

case 'display':
    $pid = COM_applyFilter ($_REQUEST['pid'], true);
    if ($pid > 0) {
        $sql = "SELECT sid, title, type FROM {$_TABLES['comments']} WHERE cid = $pid";
        $A = DB_fetchArray( DB_query($sql) );
        $sid = $A['sid'];
        $title = $A['title'];
        $type = $A['type'];
        $allowed = 1;
        if ($type == 'article') {
            $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE (sid = '$sid') AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND') . COM_getTopicSQL ('AND'));
            $A = DB_fetchArray ($result);
            $allowed = $A['count'];
        } else if ($type == 'poll') {
            $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['pollquestions']} WHERE (qid = '$sid')" . COM_getPermSQL ('AND'));
            $A = DB_fetchArray ($result);
            $allowed = $A['count'];
        }
        $display .= COM_siteHeader();
        if ($allowed == 1) {
            $format = COM_applyFilter ($_REQUEST['format']);
            if ( $format != 'threaded' && $format != 'nested' && $format != 'flat' ) {
                $format = 'threaded';
            }
            if ($type == 'poll' || $type == 'article') {
                if ( $type == 'poll' ) {
                    $delete_option = SEC_hasRights( 'poll.edit' );
                } else {
                    $delete_option = SEC_hasRights( 'story.edit' );
                }
                $delete_option = ( $delete_option &&
                    SEC_hasAccess( $A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon'] ) == 3 ? true : false );
            } else {
                $delete_option = false;
            }
            $display .= CMT_userComments ($sid, $title, $type,
                    COM_applyFilter ($_REQUEST['order']), $format, $pid,
                    COM_applyFilter ($_REQUEST['page'], true), false, $delete_option);
        } else {
            $display .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                                COM_getBlockTemplate ('_msg_block', 'header'))
                     . $LANG_ACCESS['storydenialmsg']
                     . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        }
        $display .= COM_siteFooter();
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
    break;

case 'report':
    $display = COM_siteHeader ('menu')
             . CMT_reportAbusiveComment (COM_applyFilter ($_GET['cid'], true),
                                         COM_applyFilter ($_GET['type']))
             . COM_siteFooter ();
    break;

case 'sendreport':
    $display = CMT_sendReport (COM_applyFilter ($_POST['cid'], true),
                               COM_applyFilter ($_POST['type']));
    break;

default:  // New Comment
    $sid = COM_applyFilter ($_REQUEST['sid']);
    $type = COM_applyFilter ($_REQUEST['type']);
    $title = strip_tags ($_REQUEST['title']);

    if (!empty ($sid) && !empty ($type)) { 
        if (empty ($title)) {
            if ($type == 'article') {
                $title = DB_getItem ($_TABLES['stories'], 'title',
                                     "sid = '{$sid}'");
            } elseif ($type == 'poll') {
                $title = DB_getItem ($_TABLES['pollquestions'], 'question',
                                     "qid = '{$sid}'");
            }
            $title = str_replace ('$', '&#36;', $title);
        }
        $display .= COM_siteHeader('menu', $LANG03[1])
            . CMT_commentForm ($title, '', $sid, COM_applyFilter ($_REQUEST['pid'], true),
                $type, COM_applyFilter ($_REQUEST['mode']), COM_applyFilter ($_REQUEST['postmode']))
            . COM_siteFooter();
    } else {
        $display .= COM_refresh($_CONF['site_url'] . '/index.php');
    }
    break;
}

echo $display;

?>
