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
// $Id: comment.php,v 1.66 2004/06/10 13:47:15 dhaun Exp $

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
* @param    int     $pid        ID of parent comment
* @param    string  $type       Type of object comment is posted to
* @param    string  $mode       Mode, e.g. 'preview'
* @param    string  $postmode   Indicates if comment is plain text or HTML
* @return   string  HTML for comment form
*
*/
function commentform($uid,$title,$comment,$sid,$pid='0',$type,$mode,$postmode) 
{
    global $_CONF, $_TABLES, $_USER, $HTTP_POST_VARS, $LANG03, $LANG12, $LANG_LOGIN;

    $retval = '';

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

            if (empty ($postmode)) {
                $postmode = $_CONF['postmode'];
            }

            $sig = '';
            if ($uid > 1) {
                $sig = DB_getItem ($_TABLES['users'], 'sig', "uid = '$uid'");
            }

            // Note:
            // $comment / $newcomment is what goes into the preview / is
            // actually stored in the database -> strip HTML
            // $commenttext is what the user entered and goes back into the
            // <textarea> -> don't strip HTML

            $commenttext = htmlspecialchars (COM_stripslashes ($comment));

            if ($postmode == 'html') {
                $comment = COM_checkWords (COM_checkHTML (addslashes (COM_stripslashes ($comment))));
            } else {
                $comment = htmlspecialchars (COM_checkWords (COM_stripslashes ($comment)));
            }
            // Replace $, {, and } with special HTML equivalents
            $commenttext = str_replace('$','&#36;',$commenttext);
            $commenttext = str_replace('{','&#123;',$commenttext);
            $commenttext = str_replace('}','&#125;',$commenttext);

            $title = htmlspecialchars (COM_checkWords (strip_tags (COM_stripslashes ($title))));
            // $title = str_replace('$','&#36;',$title); done in COM_getComment
            $title = str_replace('{','&#123;',$title);
            $title = str_replace('}','&#125;',$title);

            $HTTP_POST_VARS['title'] = addslashes ($title);
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
                $start->set_file( array( 'comment' => 'startcomment.thtml' ));
                $start->set_var( 'site_url', $_CONF['site_url'] );
                $start->set_var( 'layout_url', $_CONF['layout_url'] );

                if (empty ($HTTP_POST_VARS['username'])) {
                    $HTTP_POST_VARS['username'] = DB_getItem ($_TABLES['users'],
                            'username', "uid = {$HTTP_POST_VARS['uid']}");
                }
                $thecomments = COM_getComment ($HTTP_POST_VARS, 'flat', $type,
                                               'ASC', false, true );

                $start->set_var( 'comments', $thecomments );
                $retval .= COM_startBlock ($LANG03[14])
                        . $start->finish( $start->parse( 'output', 'comment' ))
                        . COM_endBlock ();
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
* @param        int         $pid        ID of parent comment
* @param        string      $type       Type of comment this is (article, poll, etc)
* @param        string      $postmode   Indicates if text is HTML or plain text
* @return       string      either nothing or HTML formated error
*
*/
function savecomment ($uid, $title, $comment, $sid, $pid, $type, $postmode) 
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $REMOTE_ADDR;

    $retval = '';

    // ignore $uid as it may be manipulated anyway
    if (empty ($_USER['uid'])) {
        $uid = 1;
    } else {
        $uid = $_USER['uid'];
    }

    if (empty ($sid) || empty ($title) || empty ($comment) || empty ($type) ||
            (($uid == 1) && (($_CONF['loginrequired'] == 1) ||
                ($_CONF['commentsloginrequired'] == 1)))) {
        $retval .= COM_refresh ($_CONF['site_url'] . '/index.php');
        return $retval;
    }

    // Check for people breaking the speed limit
    COM_clearSpeedlimit ($_CONF['commentspeedlimit'], 'comment');
    $last = COM_checkSpeedlimit ('comment');
    if ($last > 0) {
        $retval .= COM_startBlock ($LANG12[26], '', COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG03[7]
                . $last
                . $LANG03[8]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        return $retval;
    }

    // Clean 'em up a bit!
    if ($postmode == 'html') {
        $comment = COM_checkWords (COM_checkHTML (addslashes (COM_stripslashes ($comment))));
    } else {
        $comment = htmlspecialchars (COM_checkWords (COM_stripslashes ($comment)));
    }

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

    // check again for non-int pid's
    // this should just create a top level comment that is a reply to the original item
    if (!is_numeric($pid)) {
        $pid = 0;
    }

    $title = htmlspecialchars (COM_checkWords (strip_tags (COM_stripslashes ($title))));

    if (!empty ($title) && !empty ($comment)) {
        COM_updateSpeedlimit ('comment');
        $title = addslashes ($title);
        $comment = addslashes ($comment);

        // Insert the comment into the comment table
        DB_query("LOCK TABLES {$_TABLES['comments']} WRITE");
        if ($pid > 0) {
            $result = DB_query("SELECT rht, indent FROM {$_TABLES['comments']} WHERE cid = $pid");
            list($rht, $indent) = DB_fetchArray($result);
            DB_query("UPDATE {$_TABLES['comments']} SET lft = lft + 2 "
                   . "WHERE sid = '$sid' AND lft >= $rht");
            DB_query("UPDATE {$_TABLES['comments']} SET rht = rht + 2 "
                   . "WHERE sid = '$sid' AND rht >= $rht");
            DB_save ($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,ipaddress',
                    "'$sid',$uid,'$comment',now(),'$title',$pid,$rht,$rht+1,$indent+1,'$type','$REMOTE_ADDR'");
        } else {
            $rht = DB_getItem($_TABLES['comments'], 'MAX(rht)');
            DB_save ($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,ipaddress',
                    "'$sid',$uid,'$comment',now(),'$title',$pid,$rht+1,$rht+2,0,'$type','$REMOTE_ADDR'");
        }
        DB_query('UNLOCK TABLES');

        if (isset ($_CONF['notification']) &&
                in_array ('comment', $_CONF['notification'])) {
            $cid = DB_insertId();
            sendNotification ($title, $comment, $uid, $REMOTE_ADDR, $type, $cid);
        }

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
* Send an email notification for a new comment submission.
*
* @param    $title      string      comment title
* @param    $comment    string      text of the comment
* @param    $uid        integer     user id
* @param    $ipaddress  string      poster's IP address
* @param    $type       string      type of comment ('article', 'poll', ...)
* @param    $cid        integer     comment id
*
*/
function sendNotification ($title, $comment, $uid, $ipaddress, $type, $cid)
{
    global $_CONF, $_TABLES, $LANG03, $LANG08, $LANG09;

    // we have to undo the addslashes() call from savecomment()
    $title = stripslashes ($title);
    $comment = stripslashes ($comment);

    // strip HTML if posted in HTML mode
    if (preg_match ('/<.*>/', $comment) != 0) {
        $comment = strip_tags ($comment);
    }

    $author = DB_getItem ($_TABLES['users'], 'username', "uid = $uid");
    if (($uid <= 1) && !empty ($ipaddress)) {
        // add IP address for anonymous posters
        $author .= ' (' . $ipaddress . ')';
    }

    $mailbody = "$LANG03[16]: $title\n"
              . "$LANG03[5]: $author\n";

    if (($type != 'article') && ($type != 'poll')) {
        $mailbody .= "$LANG09[5]: $type\n";
    }

    if ($_CONF['emailstorieslength'] > 0) {
        if ($_CONF['emailstorieslength'] > 1) {
            $comment = substr ($comment, 0, $_CONF['emailstorieslength'])
                     . '...';
        }
        $mailbody .= $comment . "\n\n";
    }

    $mailbody .= $LANG08[33] . ' <' . $_CONF['site_url']
              . '/comment.php?mode=view&cid=' . $cid . ">\n\n";

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    $mailsubject = $_CONF['site_name'] . ' ' . $LANG03[9];

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
* Deletes a given comment
*
* @param    int         $cid    Comment ID
* @param    string      $sid    ID of object comment belongs to
* @param    string      $type   Comment type (e.g. article, poll, etc)
* @return   string      Returns string needed to redirect page to right place
*
*/
function deletecomment ($cid, $sid, $type) 
{
    global $_CONF, $_TABLES, $_USER, $REMOTE_ADDR;

    $retval = '';

    if (is_numeric ($cid) && ($cid > 0) && !empty ($sid) && !empty ($type)) {

        // only comments of type 'article' and 'poll' are handled by Geeklog
        if (($type == 'article') || ($type == 'poll')) {

            if ($type == 'article') {
                $table = $_TABLES['stories'];
                $idname = 'sid';
                $has_editPermissions = SEC_hasRights ('story.edit');
            } else {
                $table = $_TABLES['pollquestions'];
                $idname = 'qid';
                $has_editPermissions = SEC_hasRights ('poll.edit');
            }
            $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$table} WHERE {$idname} = '{$sid}'");
            $A = DB_fetchArray ($result);

            if ($has_editPermissions && SEC_hasAccess ($A['owner_id'],
                    $A['group_id'], $A['perm_owner'], $A['perm_group'],
                    $A['perm_members'], $A['perm_anon']) == 3) {
                DB_query("LOCK TABLES {$_TABLES['comments']} WRITE");
                $result = DB_query("SELECT pid, lft, rht FROM {$_TABLES['comments']} "
                                 . "WHERE cid = $cid");
                list($pid,$lft,$rht) = DB_fetchArray($result); 
                DB_change ($_TABLES['comments'], 'pid', $pid, 'pid', $cid);
                DB_delete ($_TABLES['comments'], 'cid', $cid);
                DB_query("UPDATE {$_TABLES['comments']} SET indent = indent - 1 "
                   . "WHERE sid = '$sid' AND lft BETWEEN $lft AND $rht");
                DB_query("UPDATE {$_TABLES['comments']} SET lft = lft - 2 "
                   . "WHERE sid = '$sid' AND lft >= $rht");
                DB_query("UPDATE {$_TABLES['comments']} SET rht = rht - 2 "
                   . "WHERE sid = '$sid' AND rht >= $rht");
                DB_query('UNLOCK TABLES');

                if ($type == 'poll') {
                    $retval .= COM_refresh ($_CONF['site_url']
                            . '/pollbooth.php?qid=' . $sid . '&aid=-1');
                } else {
                    $comments = DB_count ($_TABLES['comments'], 'sid', $sid);
                    DB_change ($_TABLES['stories'], 'comments', $comments,
                               'sid', $sid);
                    $retval .= COM_refresh ($_CONF['site_url']
                            . '/article.php?story=' . $sid . '#comments');
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

/**
* Display form to report abusive comment.
*
* @param    string  $cid    comment id
* @param    string  $type   type of comment ('article', 'poll', ...)
* @return   string          HTML for the form (or error message)
*
*/
function report_abusive_comment ($cid, $type)
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $LANG12, $LANG_LOGIN;

    $retval = '';

    if (empty ($_USER['username'])) {
        $retval .= COM_startBlock ($LANG_LOGIN[1], '',
                           COM_getBlockTemplate ('_msg_block', 'header'));     
        $loginreq = new Template ($_CONF['path_layout'] . 'submit');            
        $loginreq->set_file ('loginreq', 'submitloginrequired.thtml');          
        $loginreq->set_var ('login_message', $LANG_LOGIN[2]);
        $loginreq->set_var ('site_url', $_CONF['site_url']);                    
        $loginreq->set_var ('lang_login', $LANG_LOGIN[3]);
        $loginreq->set_var ('lang_newuser', $LANG_LOGIN[4]);
        $loginreq->parse ('errormsg', 'loginreq');
        $retval .= $loginreq->finish ($loginreq->get_var ('errormsg'));
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

        return $retval;
    }

    COM_clearSpeedlimit ($_CONF['speedlimit'], 'mail');
    $last = COM_checkSpeedlimit ('mail');
    if ($last > 0) {
        $retval .= COM_startBlock ($LANG12[26], '',
                            COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG12[30] . $last . $LANG12[31]
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

        return $retval;
    }

    $start = new Template ($_CONF['path_layout'] . 'comment');
    $start->set_file (array ('report' => 'reportcomment.thtml'));
    $start->set_var ('site_url', $_CONF['site_url']);
    $start->set_var ('layout_url', $_CONF['layout_url']);
    $start->set_var ('lang_report_this', $LANG03[25]);
    $start->set_var ('lang_send_report', $LANG03[10]);
    $start->set_var ('cid', $cid);
    $start->set_var ('type', $type);

    $result = DB_query ("SELECT uid,sid,pid,title,comment,UNIX_TIMESTAMP(date) AS nice_date FROM {$_TABLES['comments']} WHERE cid = $cid AND type = '$type'");
    $A = DB_fetchArray ($result);

    $result = DB_query ("SELECT username,fullname,photo FROM {$_TABLES['users']} WHERE uid = {$A['uid']}");
    $B = DB_fetchArray ($result);

    // prepare data for comment preview
    $A['cid'] = $cid;
    $A['type'] = $type;
    $A['username'] = $B['username'];
    $A['fullname'] = $B['fullname'];
    $A['photo'] = $B['photo'];
    $A['indent'] = 0;
    $A['pindent'] = 0;

    $thecomment = COM_getComment ($A, 'flat', $type, 'ASC', false, true);
    $start->set_var ('comment', $thecomment);
    $retval .= COM_startBlock ($LANG03[15])
            . $start->finish ($start->parse ('output', 'report'))
            . COM_endBlock ();

    return $retval;
}

/**
* Send report about abusive comment
*
* @param    string  $cid    comment id
* @param    string  $type   type of comment ('article', 'poll', ...)
* @return   string          Meta refresh or HTML for error message
*
*/
function send_report ($cid, $type)
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $LANG08, $LANG_LOGIN;

    if (empty ($_USER['username'])) {
        $retval = COM_siteHeader ('menu');
        $retval .= COM_startBlock ($LANG_LOGIN[1], '',
                           COM_getBlockTemplate ('_msg_block', 'header'));     
        $loginreq = new Template ($_CONF['path_layout'] . 'submit');            
        $loginreq->set_file ('loginreq', 'submitloginrequired.thtml');          
        $loginreq->set_var ('login_message', $LANG_LOGIN[2]);
        $loginreq->set_var ('site_url', $_CONF['site_url']);                    
        $loginreq->set_var ('lang_login', $LANG_LOGIN[3]);
        $loginreq->set_var ('lang_newuser', $LANG_LOGIN[4]);
        $loginreq->parse ('errormsg', 'loginreq');
        $retval .= $loginreq->finish ($loginreq->get_var ('errormsg'));
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval .= COM_siteFooter ();

        return $retval;
    }

    COM_clearSpeedlimit ($_CONF['speedlimit'], 'mail');
    if (COM_checkSpeedlimit ('mail') > 0) {
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    $username = DB_getItem ($_TABLES['users'], 'username',
                            "uid = {$_USER['uid']}");
    $result = DB_query ("SELECT uid,title,comment,sid,ipaddress FROM {$_TABLES['comments']} WHERE cid = $cid AND type = '$type'");
    $A = DB_fetchArray ($result);

    $title = stripslashes ($A['title']);
    $comment = stripslashes ($A['comment']);

    // strip HTML if posted in HTML mode
    if (preg_match ('/<.*>/', $comment) != 0) {
        $comment = strip_tags ($comment);
    }

    $author = DB_getItem ($_TABLES['users'], 'username', "uid = {$A['uid']}");
    if (($A['uid'] <= 1) && !empty ($A['ipaddress'])) {
        // add IP address for anonymous posters
        $author .= ' (' . $A['ipaddress'] . ')';
    }

    $mailbody = sprintf ($LANG03[26], $username);
    $mailbody .= "\n\n"
              . "$LANG03[16]: $title\n"
              . "$LANG03[5]: $author\n";
    
    if (($type != 'article') && ($type != 'poll')) {
        $mailbody .= "$LANG09[5]: $type\n";
    }

    if ($_CONF['emailstorieslength'] > 0) {
        if ($_CONF['emailstorieslength'] > 1) {
            $comment = substr ($comment, 0, $_CONF['emailstorieslength'])
                     . '...';
        }
        $mailbody .= $comment . "\n\n";
    }

    $mailbody .= $LANG08[33] . ' <' . $_CONF['site_url']
              . '/comment.php?mode=view&cid=' . $cid . ">\n\n";

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    $mailsubject = $_CONF['site_name'] . ' ' . $LANG03[27];

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
    COM_updateSpeedlimit ('mail');

    return COM_refresh ($_CONF['site_url'] . '/index.php?msg=27');
}


// MAIN
switch ($mode) {
case $LANG03[14]: // Preview
    $display .= COM_siteHeader()
        . commentform (COM_applyFilter ($HTTP_POST_VARS['uid'], true),
            strip_tags ($HTTP_POST_VARS['title']), $HTTP_POST_VARS['comment'],
            COM_applyFilter ($HTTP_POST_VARS['sid']),
            COM_applyFilter ($HTTP_POST_VARS['pid'], true),
            COM_applyFilter ($HTTP_POST_VARS['type']),
            COM_applyFilter ($HTTP_POST_VARS['mode']),
            COM_applyFilter ($HTTP_POST_VARS['postmode']))
        . COM_siteFooter(); 
    break;

case $LANG03[11]: // Submit Comment
    $display .= savecomment (COM_applyFilter ($HTTP_POST_VARS['uid'], true),
            strip_tags ($HTTP_POST_VARS['title']), $HTTP_POST_VARS['comment'],
            COM_applyFilter ($HTTP_POST_VARS['sid']),
            COM_applyFilter ($HTTP_POST_VARS['pid'], true),
            COM_applyFilter ($HTTP_POST_VARS['type']),
            COM_applyFilter ($HTTP_POST_VARS['postmode']));
    break;

case $LANG01[28]: // Delete
    $display .= deletecomment (COM_applyFilter ($cid, true),
                               COM_applyFilter ($sid), COM_applyFilter ($type));
    break;

case 'view':
    $cid = COM_applyFilter ($HTTP_GET_VARS['cid'], true);
    if ($cid > 0) {
        $sql = "SELECT sid, title, type FROM {$_TABLES['comments']} WHERE cid = $cid";
        $A = DB_fetchArray( DB_query($sql) );
        $sid = $A['sid'];
        $title = $A['title'];
        $type = $A['type'];
        $allowed = 1;
        if ($type == 'article') {
            $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE (sid = '$sid') AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSQL ('AND'));
            $A = DB_fetchArray ($result);
            $allowed = $A['count'];
        } else if ($type == 'poll') {
            $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['pollquestions']} WHERE (qid = '$sid')" . COM_getPermSQL ('AND'));
            $A = DB_fetchArray ($result);
            $allowed = $A['count'];
        }
        $display .= COM_siteHeader();
        if ($allowed == 1) {
            $format = COM_applyFilter ($HTTP_GET_VARS['format']);
            if ( $format != 'threaded' && $format != 'nested' && $format != 'flat' ) {  //FIXME
                $format = 'threaded';
            }
            $display .= COM_userComments ($sid, $title, $type, 
                            COM_applyFilter ($HTTP_GET_VARS['order']), $format, $cid,
                            COM_applyFilter ($HTTP_GET_VARS['page']), true);
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
    $sid = COM_applyFilter ($HTTP_GET_VARS['sid']);
    $type = COM_applyFilter ($HTTP_GET_VARS['type']);
    if (!empty ($sid) && !empty ($type)) {
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
            $display .= COM_userComments ($sid,
                    strip_tags ($HTTP_GET_VARS['title']), $type,
                    COM_applyFilter ($HTTP_GET_VARS['order']), 'threaded',
                    COM_applyFilter ($HTTP_GET_VARS['pid'], true),
                    COM_applyFilter ($HTTP_GET_VARS['page'], true));
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
             . report_abusive_comment (COM_applyFilter ($HTTP_GET_VARS['cid'],
                    true), COM_applyFilter ($HTTP_GET_VARS['type']))
             . COM_siteFooter ();
    break;

case 'sendreport':
    $display = send_report (COM_applyFilter ($HTTP_POST_VARS['cid'], true),
                            COM_applyFilter ($HTTP_POST_VARS['type']));
    break;

default:
    if (isset ($HTTP_POST_VARS['sid'])) {
        $sid = COM_applyFilter ($HTTP_POST_VARS['sid']);
        $type = COM_applyFilter ($HTTP_POST_VARS['type']);
        $title = strip_tags ($HTTP_POST_VARS['title']);
        $pid = COM_applyFilter ($HTTP_POST_VARS['pid'], true);
        $mode = COM_applyFilter ($HTTP_POST_VARS['mode']);
        $postmode = COM_applyFilter ($HTTP_POST_VARS['postmode']);
    } else {
        $sid = COM_applyFilter ($HTTP_GET_VARS['sid']);
        $type = COM_applyFilter ($HTTP_GET_VARS['type']);
        $title = strip_tags ($HTTP_GET_VARS['title']);
        $pid = COM_applyFilter ($HTTP_GET_VARS['pid'], true);
        $mode = COM_applyFilter ($HTTP_GET_VARS['mode']);
        $postmode = COM_applyFilter ($HTTP_GET_VARS['postmode']);
    }
    if (!empty ($sid)) {
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
        if (!empty ($type)) {
            $display .= COM_siteHeader()
                . commentform ($_USER['uid'], $title, '', $sid, $pid, $type,
                               $mode, $postmode)
                . COM_siteFooter();
        } else {
            $display .= COM_refresh($_CONF['site_url'] . '/index.php');
        }
    } else {
        // This could still be a plugin wanting comments
        if (isset ($HTTP_POST_VARS['cid'])) {
            $cid = COM_applyFilter ($HTTP_POST_VARS['cid'], true);
        } else {
            $cid = COM_applyFilter ($HTTP_GET_VARS['cid'], true);
        }
        if (!empty ($type) && !empty ($cid)) {
            $display .= PLG_callCommentForm ($type, $cid);
        } else {
            // must be a mistake at this point
            $display .= COM_refresh($_CONF['site_url'] . '/index.php');
        }
    }
}

echo $display;

?>
