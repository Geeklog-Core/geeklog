<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | comment.php                                                               |
// |                                                                           |
// | Let user comment on a story.                                              |
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
// $Id: comment.php,v 1.44 2003/06/25 08:39:02 dhaun Exp $

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

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($HTTP_POST_VARS);

/**
* Displays the comment form
*
* @param    int     $uid        User ID
* @param    string  $title      Title of comment
* @param    string  $comment    Text of comment
* @param    string  $sid        ID of object comment belongs to
* @param    string  $pid        ID of parent comment
* @param    string  $type       Type of object comment is posted to
* @param    string  $mode       Mode, e.g. 'preview'
* @param    string  $postmode   Indicates if comment is plain text or HTML
* @return   string  HTML for comment form
*
*/
function commentform($uid,$title,$comment,$sid,$pid='0',$type,$mode,$postmode) 
{
    global $_TABLES, $HTTP_POST_VARS, $REMOTE_ADDR, $_CONF, $LANG03, $LANG12, $LANG_LOGIN, $_USER;

    $retval = '';

    if (empty ($postmode)) {
        $postmode = $_CONF['postmode'];
    }

    $sig = '';
    if ($uid > 1) {
        $sig = DB_getItem ($_TABLES['users'], 'sig', "uid = '$uid'");
    }

    if (empty($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['commentsloginrequired'] == 1))) {
        $retval .= COM_startBlock ($LANG_LOGIN[1], '',
                           COM_getBlockTemplate ('_msg_block', 'header'));
        $loginreq = new Template($_CONF['path_layout'] . 'submit');
        $loginreq->set_file('loginreq', 'submitloginrequired.thtml');
        $loginreq->set_var('login_message', $LANG_LOGIN[2]);
        $loginreq->set_var('site_url', $_CONF['site_url']);
        $loginreq->set_var('lang_login', $LANG_LOGIN[3]);
        $loginreq->set_var('lang_newuser', $LANG_LOGIN[4]);
        $loginreq->parse('errormsg', 'loginreq');
        $retval .= $loginreq->finish($loginreq->get_var('errormsg'));
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        return $retval;
    } else {
        COM_clearSpeedlimit ($_CONF['commentspeedlimit'], 'comment');

        $last = COM_checkSpeedlimit ('comment');

        if ($last > 0) {
            $retval .= COM_startBlock ($LANG12[26], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG03[7]
                . $last
                . $LANG03[8]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        } else {
            if ($postmode == 'html') {
                $commenttext = stripslashes($comment);
                $commenttext = str_replace('$','&#36;',$commenttext);

                $comment = COM_checkHTML(COM_checkWords($comment));
                $title = COM_checkHTML(htmlspecialchars(COM_checkWords($title)));
            } else {
                $title = stripslashes(htmlspecialchars(COM_checkWords($title)));
                $comment = stripslashes(htmlspecialchars(COM_checkWords($comment)));
                $commenttext = str_replace('$','&#36;',$comment);
                $title = str_replace('$','&#36;',$title);
            }
            // Replace { and } with special HTML equivalents
            $commenttext = str_replace('{','&#123;',$commenttext);
            $commenttext = str_replace('}','&#125;',$commenttext);

            $title = strip_tags(COM_checkWords($title));
            $HTTP_POST_VARS['title'] = $title;
            $newcomment = $comment;
            if (!empty ($sig)) {
                if (!$postmode == 'html') {
                    $newcomment .= '<p>---<br>' . nl2br ($sig);
                } else {
                    $newcomment .= LB . LB . '---' . LB . $sig;
                }
            }
            $HTTP_POST_VARS['comment'] = addslashes ($newcomment);

            if ($mode == $LANG03[14] && !empty($title) && !empty($comment) ) {
                $start = new Template( $_CONF['path_layout'] . 'comment' );
                $start->set_file( array( 'startcomment' => 'startcomment.thtml' ));
                $start->set_var( 'site_url', $_CONF['site_url'] );
                $start->set_var( 'layout_url', $_CONF['layout_url'] );

                $thecomments = COM_comment ($HTTP_POST_VARS, 1, $type, 0,
                                            'flat', true);

                $start->set_var( 'comments', $thecomments );
                $retval .= $start->finish( $start->parse( 'output', 'startcomment' ));
            } else if ($mode == $LANG03[14]) {
                $retval .= COM_startBlock ($LANG03[17], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                    . $LANG03[12]
                    . COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
                $mode = 'error';
            }

            $comment_template = new Template($_CONF['path_layout'] . 'comment');
            if (($_CONF['advanced_editor'] == 1) && file_exists ($_CONF['path_layout'] . 'comment/commentform_advanced.thtml')) {
                $comment_template->set_file('form','commentform_advanced.thtml');
            } else {
                $comment_template->set_file('form','commentform.thtml');
            }
            $comment_template->set_var('site_url', $_CONF['site_url']);
            $comment_template->set_var('start_block_postacomment', COM_startBlock($LANG03[1]));
            $comment_template->set_var('lang_username', $LANG03[5]);
            $comment_template->set_var('sid', $sid);
            $comment_template->set_var('pid', $pid);
            $comment_template->set_var('type', $type);

            if (!empty($_USER['username'])) {
                $comment_template->set_var('uid', $_USER['uid']);
                $comment_template->set_var('username', $_USER['username']);
                $comment_template->set_var('action_url', $_CONF['site_url'] . '/users.php?mode=logout');
                $comment_template->set_var('lang_logoutorcreateaccount', $LANG03[03]);
            } else {
                $comment_template->set_var('uid', 1);
                $comment_template->set_var('username', $LANG03[24]);
                $comment_template->set_var('action_url', $_CONF['site_url'] . '/users.php?mode=new'); 
                $comment_template->set_var('lang_logoutorcreateaccount', $LANG03[04]);
            }

            $comment_template->set_var('lang_title', $LANG03[16]);
            $comment_template->set_var('title', stripslashes($title));
            $comment_template->set_var('lang_comment', $LANG03[9]);
            $comment_template->set_var('comment', $commenttext);
            $comment_template->set_var('lang_postmode', $LANG03[2]);
            $comment_template->set_var('postmode_options', COM_optionList($_TABLES['postmodes'],'code,name',$postmode));
            $comment_template->set_var('allowed_html', COM_allowedHTML());
            $comment_template->set_var('lang_importantstuff', $LANG03[18]);
            $comment_template->set_var('lang_instr_line1', $LANG03[19]);	
            $comment_template->set_var('lang_instr_line2', $LANG03[20]);	
            $comment_template->set_var('lang_instr_line3', $LANG03[21]);	
            $comment_template->set_var('lang_instr_line4', $LANG03[22]);	
            $comment_template->set_var('lang_instr_line5', $LANG03[23]);	
            $comment_template->set_var('lang_preview', $LANG03[14]);

            if (($_CONF['skip_preview'] == 1) || ($mode == $LANG03[14])) {
                $comment_template->set_var('save_option', '<input type="submit" name="mode" value="' . $LANG03[11] . '">');
            }

            $comment_template->set_var('end_block', COM_endBlock());	
            $comment_template->parse('output', 'form');
            $retval .= $comment_template->finish($comment_template->get_var('output'));
        }
    }

    return $retval;
}

/**
* Save a comment
*
* @param        int         $uid        User ID of user making the comment
* @param        string      $title      Title of comment
* @param        string      $comment    Text of comment
* @param        string      $sid        ID of object receiving comment
* @param        string      $pid        ID of parent comment
* @param        string      $type       Type of comment this is (article, poll, etc)
* @param        string      $postmode   Indicates if text is HTML or plain text
* @return       string      either nothing or HTML formated error
*
*/
function savecomment($uid,$title,$comment,$sid,$pid,$type,$postmode) 
{
    global $_TABLES, $_CONF, $LANG03, $REMOTE_ADDR; 

    $retval = '';

    // Get signature
    $sig = '';
    if ($uid > 1) {
        $sig = DB_getItem($_TABLES['users'],'sig', "uid = '$uid'");
    }
    if (!empty ($sig)) {
        if ($postmode == 'html') {
            $comment .= '<p>---<br>' . nl2br($sig);
        } else {
            $comment .= LB . LB . '---' . LB . $sig;
        }
    }

    // Clean 'em up a bit!
    if ($postmode == 'html') {
        $comment = addslashes(COM_checkHTML(COM_checkWords($comment)));
    } else {
        $comment = addslashes(htmlspecialchars(COM_checkWords($comment)));
    } 

    // check again for non-int pid's
    // this should just create a top level comment that is a reply to the original item
    if (!is_numeric($pid)) {
        $pid = 0;
    }

    $title = addslashes(strip_tags(COM_checkWords($title)));

    if (!empty ($title) && !empty ($comment)) {
        COM_updateSpeedlimit ('comment');
        DB_save ($_TABLES['comments'], 'sid,uid,comment,date,title,pid,type',
                "'$sid',$uid,'$comment',now(),'$title',$pid,'$type'");

        if ($type == 'poll') {
            $retval = COM_refresh ($_CONF['site_url']
                    . "/pollbooth.php?qid=$sid&aid=-1");
        } elseif ($type == 'article') {
            $comments = DB_count ($_TABLES['comments'], 'sid', $sid);
            DB_change($_TABLES['stories'],'comments',$comments,'sid',$sid);
            $retval = COM_refresh ($_CONF['site_url']
                    . "/article.php?story=$sid");
        } else { // assume it's a comment handled by a plugin
            $cid = DB_getItem ($_TABLES['comments'], 'cid', "(type = '$type') AND (pid = '$pid') AND (sid = '$sid') AND (uid = '$uid')");
            $retval = PLG_handlePluginComment ($type, $cid, 'save');
            if (empty ($retval)) {
                $retval = COM_refresh ($_CONF['site_url'] . '/index.php');
            }
        }
    } else {
        $retval .= COM_siteHeader()
            . commentform ($uid, $title, $comment, $sid, $pid, $type,
                           $LANG03[14], $postmode)
            . COM_siteFooter();
    }

    return $retval;
}

/**
* Deletes a given comment
*
* @param    string      $cid    Comment ID
* @param    string      $sid    ID of object comment belongs to
* @param    string      $type   Comment type (e.g. article, poll, etc)
* @return   string      Returns string needed to redirect page to right place
*
*/
function deletecomment($cid,$sid,$type) 
{
    global $_TABLES, $_CONF, $_USER, $REMOTE_ADDR;

    $retval = '';

    if (!empty ($sid) && !empty ($cid) && is_numeric ($cid)) {

        // only comments of type 'article' and 'poll' are handled by Geeklog
        if (($type == 'article') || ($type == 'poll')) {

            if ($type == 'article') {
                $table = $_TABLES['stories'];
                $idname = 'sid';
            } else {
                $table = $_TABLES['pollquestions'];
                $idname = 'qid';
            }
            $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$table} WHERE {$idname} = '{$sid}'");
            $A = DB_fetchArray ($result);
            if (SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
                $A['perm_group'], $A['perm_members'], $A['perm_anon']) == 3) {
                $pid = DB_getItem ($_TABLES['comments'], 'pid', "cid = '$cid'");

                DB_change ($_TABLES['comments'], 'pid', $pid, 'pid', $cid);
                DB_delete ($_TABLES['comments'], 'cid', $cid);

                if ($type == 'poll') {
                    $retval .= COM_refresh ($_CONF['site_url']
                            . '/pollbooth.php?qid=' . $sid . '&aid=-1');
                } else {
                    $comments = DB_count ($_TABLES['comments'], 'sid', $sid);
                    DB_change ($_TABLES['stories'], 'comments', $comments,
                               'sid', $sid);
                    $retval .= COM_refresh ($_CONF['site_url']
                            . '/article.php?story=' . $sid);
                }
            } else {
                COM_errorLog ('User ' . $_USER['username'] . ' (IP: '
                        . $REMOTE_ADDR . ') tried to illegally delete comment '
                        . $cid . ' from ' . $type . ' ' . $sid);
                $retval .= COM_refresh ($_CONF['site_url'] . '/index.php');
            }
        } else {
            // See if plugin will handle this
            $retval = PLG_handlePluginComment ($type, $cid, 'delete');
            if (empty ($retval)) {
                $retval = COM_refresh ($_CONF['site_url'] . '/index.php');
            }
        }
    } else {
        $retval .= COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    return $retval;
}

// MAIN
$title = strip_tags ($title);
switch ($mode) {
case $LANG03[14]: //Preview
    $display .= COM_siteHeader()
        . commentform($uid,$title,$comment,$sid,$pid,$type,$mode,$postmode)
        . COM_siteFooter(); 
    break;
case $LANG03[11]: //Submit Comment
    $display .= savecomment($uid,$title,$comment,$sid,$pid,$type,$postmode);
    break;
case $LANG01[28]: //Delete
    $display .= deletecomment (strip_tags ($cid), strip_tags ($sid), $type);
    break;
case 'display':
    $display .= COM_siteHeader()
        . COM_userComments($sid,$title,$type,$order,'threaded',$pid)
        . COM_siteFooter();
    break;
default:
    if (!empty($sid)) {
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
        $display .= COM_siteHeader()
            . commentform('',$title,'',$sid,$pid,$type,$mode,$postmode)
            . COM_siteFooter();
    } else {
        // This could still be a plugin wanting comments
        if (strlen($type) > 0) {
            $display .= PLG_callCommentForm($type,$cid);
        } else {
            // must be a mistake at this point
            $display .= COM_refresh("{$_CONF['site_url']}/index.php");
        }
    }
}

echo $display;

?>
