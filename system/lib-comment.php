<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | lib-comment.php                                                           |
// |                                                                           |
// | Geeklog comment library.                                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-comment.php') !== false) {
    die('This file can not be used on its own!');
}

if ($_CONF['allow_user_photo']) {
    /**
    * only needed for the USER_getPhoto function
    */
    require_once $_CONF['path_system'] . 'lib-user.php';
}

define('COMMENT_ON_SAME_PAGE',
       ($_CONF['comment_on_same_page'] && !CMT_isCommentPage()));
$prefix = COMMENT_ON_SAME_PAGE ? 'cmt_' : '';
define('CMT_CID',      $prefix . 'cid');
define('CMT_SID',      $prefix . 'sid');
define('CMT_PID',      $prefix . 'pid');
define('CMT_UID',      $prefix . 'uid');
define('CMT_TYPE',     $prefix . 'type');
define('CMT_USERNAME', $prefix . 'username');
define('CMT_MODE',     $prefix . 'mode');

/**
* This function displays the comment control bar
*
* Prints the control that allows the user to interact with Geeklog Comments
*
* @param    string  $sid    ID of item in question
* @param    string  $title  Title of item
* @param    string  $type   Type of item (i.e. article, photo, etc)
* @param    string  $order  Order that comments are displayed in
* @param    string  $mode   Mode (nested, flat, etc.)
* @param    int     $ccode  Comment code: -1=no comments, 0=allowed, 1=closed
* @return   string          HTML Formated comment bar
* @see CMT_userComments
*
*/
function CMT_commentBar( $sid, $title, $type, $order, $mode, $ccode = 0 )
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG03;

    $is_comment_page = CMT_isCommentPage();

    $nrows = DB_count( $_TABLES['comments'], array( 'sid', 'type' ),
                       array( $sid, $type ));

    $commentbar = COM_newTemplate($_CONF['path_layout'] . 'comment');
    $commentbar->set_file( array( 'commentbar' => 'commentbar.thtml' ));

    $commentbar->set_var( 'lang_comments', $LANG01[3] );
    $commentbar->set_var( 'lang_refresh', $LANG01[39] );
    $commentbar->set_var( 'lang_reply', $LANG01[60] );
    $commentbar->set_var( 'lang_disclaimer', $LANG01[26] );

    if ( $ccode == 0 && !COMMENT_ON_SAME_PAGE) {
        $commentbar->set_var( 'reply_hidden_or_submit', 'submit' );
    } else {
        $commentbar->set_var( 'reply_hidden_or_submit', 'hidden' );
    }
    $commentbar->set_var( 'num_comments', COM_numberFormat( $nrows ));
    $commentbar->set_var( 'comment_type', $type );
    $commentbar->set_var( 'sid', $sid );

    $cmt_title = stripslashes($title);
    $commentbar->set_var('story_title', $cmt_title);
    // Article's are pre-escaped.
    if ($type != 'article') {
        $cmt_title = htmlspecialchars($cmt_title);
    }
    $commentbar->set_var('comment_title', $cmt_title);

    // Link to plugin defined link or lacking that a generic link
    // that the plugin should support (hopefully)
    list($plgurl, $plgid) = CMT_getCommentUrlId($type);
    $articleUrl = "$plgurl?$plgid=$sid";

    $commentbar->set_var('article_url', $articleUrl);
    if ($is_comment_page) {
        $link = COM_createLink($cmt_title, $articleUrl,
                               array('class' => 'non-ul b'));
        $commentbar->set_var('story_link', $link);
        $commentbar->set_var('start_storylink_anchortag',
                             '<a href="' . $articleUrl . '" class="non-ul">');
        $commentbar->set_var('end_storylink_anchortag', '</a>');
    } else {
        $commentbar->set_var('story_link', $articleUrl);
    }

    if (! COM_isAnonUser()) {
        $username = $_USER['username'];
        $fullname = $_USER['fullname'];
    } else {
        $result = DB_query( "SELECT username,fullname FROM {$_TABLES['users']} WHERE uid = 1" );
        $N = DB_fetchArray( $result );
        $username = $N['username'];
        $fullname = $N['fullname'];
    }
    if( empty( $fullname )) {
        $fullname = $username;
    }
    $commentbar->set_var( 'user_name', $username );
    $commentbar->set_var( 'user_fullname', $fullname );

    if (! COM_isAnonUser()) {
        $author = COM_getDisplayName( $_USER['uid'], $username, $fullname );
        $commentbar->set_var( 'user_nullname', $author );
        $commentbar->set_var( 'author', $author );
        $commentbar->set_var( 'login_logout_url',
                              $_CONF['site_url'] . '/users.php?mode=logout' );
        $commentbar->set_var( 'lang_login_logout', $LANG01[35] );
    } else {
        $commentbar->set_var( 'user_nullname', '' );
        $commentbar->set_var( 'login_logout_url',
                              $_CONF['site_url'] . '/users.php?mode=new' );
        $commentbar->set_var( 'lang_login_logout', $LANG01[61] );
    }

    $comment_url = $_CONF['site_url'] . '/comment.php';
    if ($is_comment_page) {
        $commentbar->set_var( 'parent_url', $comment_url . '#comments' );
        $commentbar->set_var( 'editor_url', $comment_url . '#commenteditform' );
        $hidden = '';
        $commentmode = COM_applyFilter($_REQUEST[CMT_MODE]);
        $cid = 0;
        if (isset($_REQUEST[CMT_CID])) {        
            $cid = COM_applyFilter($_REQUEST[CMT_CID], true);
        }
        $pid = 0;
        if (isset($_REQUEST[CMT_PID])) {
            $pid = COM_applyFilter($_REQUEST[CMT_PID], true);
        }
        if (in_array($commentmode, array('view', $LANG03[28], $LANG03[34], $LANG03[14], 'edit'))) {
            $hidden .= '<input type="hidden" name="' . CMT_CID . '" value="' . $cid . '"' . XHTML . '>';
            $hidden .= '<input type="hidden" name="' . CMT_PID . '" value="' . $cid . '"' . XHTML . '>';
        }
        else if ( $commentmode == 'display' || empty($commentmode) ) {
            $hidden .= '<input type="hidden" name="' . CMT_PID . '" value="' . $pid . '"' . XHTML . '>';
        }
        $hidden .= '<input type="hidden" name="mode" value="' . $commentmode . '"' . XHTML . '>';
        $commentbar->set_var( 'hidden_field', $hidden );
        $commentbar->set_var( 'hidden_field_reply', '' );
        $commentbar->set_var( 'nprefix', '' );
    } else { // article and plugin
        $commentbar->set_var( 'parent_url', $articleUrl . '#comments' );
        if (COMMENT_ON_SAME_PAGE) {
            $commentbar->set_var( 'editor_url', $articleUrl . '#commenteditform' );
            $commentbar->set_var( 'nprefix', 'cmd_' );
        } else {
            $commentbar->set_var( 'editor_url', $comment_url . '#commenteditform' );
            $commentbar->set_var( 'nprefix', '' );
        }
        $hidden = '<input type="hidden" name="' . $plgid . '" value="' . $sid . '"' . XHTML . '>';
        $commentbar->set_var( 'hidden_field', $hidden );
        $commentbar->set_var( 'hidden_field_reply', $hidden );
    }

    // Order
    $selector = '<select name="order">' . LB
              . COM_optionList( $_TABLES['sortcodes'], 'code,name', $order )
              . LB . '</select>';
    $commentbar->set_var( 'order_selector', $selector);

    // Mode
    if ($is_comment_page) {
        $selector = '<select name="format">';
    } else {
        $selector = '<select name="mode">';
    }
    $selector .= LB
               . COM_optionList( $_TABLES['commentmodes'], 'mode,name', $mode )
               . LB . '</select>';
    $commentbar->set_var( 'mode_selector', $selector);

    return $commentbar->finish( $commentbar->parse( 'output', 'commentbar' ));
}


/**
* This function prints &$comments (db results set of comments) in comment format
* -For previews, &$comments is assumed to be an associative array containing
*  data for a single comment.
*
* @param    array    &$comments Database result set of comments to be printed
* @param    string   $mode      'flat', 'threaded', etc
* @param    string   $type      Type of item (article, polls, etc.)
* @param    string   $order     How to order the comments 'ASC' or 'DESC'
* @param    boolean  $delete_option   if current user can delete comments
* @param    boolean  $preview   Preview display (for edit) or not
* @param    int      $ccode     Comment code: -1=no comments, 0=allowed, 1=closed
* @param    int      $cpage     page number of comments to display
* @return   string   HTML       Formated Comment
*
*/
function CMT_getComment( &$comments, $mode, $type, $order, $delete_option = false, $preview = false, $ccode = 0, 
                         $cpage = 1 )
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG03, $MESSAGE, $_IMAGE_TYPE;

    $indent = 0;  // begin with 0 indent
    $retval = ''; // initialize return value

    $template = COM_newTemplate($_CONF['path_layout'] . 'comment');
    $template->set_file( array( 'comment' => 'comment.thtml',
                               'thread'  => 'thread.thtml'  ));

    // generic template variables
    $template->set_var( 'lang_authoredby', $LANG01[42] );
    $template->set_var( 'lang_on', $LANG01[36] );
    $template->set_var( 'lang_permlink', $LANG01[120] );
    $template->set_var( 'order', $order );

    if( $ccode == 0 ) {
        $template->set_var( 'lang_replytothis', $LANG01[43] );
        $template->set_var( 'lang_reply', $LANG01[25] );
    } else {
        $template->set_var( 'lang_replytothis', '' );
        $template->set_var( 'lang_reply', '' );
    }

    // Make sure we have a default value for comment indentation
    if (!isset($_CONF['comment_indent'])) {
        $_CONF['comment_indent'] = 25;
    }

    if ($preview) {
        $A = $comments;
        if (empty( $A['nice_date'])) {
            $A['nice_date'] = time();
        }
        if (!isset($A['cid'])) {
            $A['cid'] = 0;
        }
        if (!isset($A['photo'])) {
            if (isset($_USER['photo'])) {
                $A['photo'] = $_USER['photo'];
            } else {
                $A['photo'] = '';
            }
        }
        if (! isset($A['email'])) {
            if (isset($_USER['email'])) {
                $A['email'] = $_USER['email'];
            } else {
                $A['email'] = '';
            }
        }
        $mode = 'flat';
    } else {
        $A = DB_fetchArray( $comments );
    }

    if (empty($A)) {
        return '';
    }

    $commentmode = '';
    if (isset($_REQUEST[CMT_MODE])) {
        $commentmode = COM_applyFilter($_REQUEST[CMT_MODE]);
    }
    $submit = (($commentmode == $LANG03[29]) || ($commentmode == $LANG03[35]));
    $token = '';
    if ($delete_option && !$preview && !$submit) {
        $token = SEC_createToken();
    }

    // check for comment edit

    $row = 1;
    do {
        // check for comment edit
        $commentedit = DB_query("SELECT cid,uid,UNIX_TIMESTAMP(time) AS time FROM {$_TABLES['commentedits']} WHERE cid = {$A['cid']}");
        $B = DB_fetchArray($commentedit);
        if ($B) { //comment edit present
            // get correct editor name
            if ($A['uid'] == $B['uid']) {
                $editname = $A['username'];
            } else {
                $editname = DB_getItem($_TABLES['users'], 'username',
                                       "uid={$B['uid']}");
            }
            // add edit info to text
            $A['comment'] .= '<div class="comment-edit">' . $LANG03[30] . ' '
                          . strftime($_CONF['date'], $B['time']) . ' '
                          . $LANG03[31] . ' ' . $editname
                          . '</div><!-- /COMMENTEDIT -->';
        }

        // determines indentation for current comment
        if ($mode == 'threaded' || $mode == 'nested') {
            $indent = ($A['indent'] - $A['pindent']) * $_CONF['comment_indent'];
        }

        // Filemgmt plugin is doing special processing.
        // Therefore, I support specially, against my better judgment.
        // May should delete this code part.
        if ($type == 'filemgmt') {
            $A['sid'] = str_replace('fileid_', '', $A['sid']);
        }

        // comment variables
        $template->set_var('indent', $indent);
        $template->set_var('author_name', strip_tags($A['username']));
        $template->set_var('author_id', $A['uid']);
        $template->set_var('cid', $A['cid']);
        $template->set_var('cssid', $row % 2);

        if ($A['uid'] > 1) {
            $fullname = '';
            if (! empty($A['fullname'])) {
                $fullname = $A['fullname'];
            }
            $fullname = COM_getDisplayName($A['uid'], $A['username'],
                                           $fullname);
            $template->set_var('author_fullname', $fullname);
            $template->set_var('author', $fullname);
            $alttext = $fullname;

            $photo = '';
            if ($_CONF['allow_user_photo']) {
                if (isset($A['photo']) && empty($A['photo'])) {
                    $A['photo'] = '(none)';
                }
                $photo = USER_getPhoto($A['uid'], $A['photo'], $A['email']);
            }
            $profile_link = $_CONF['site_url']
                          . '/users.php?mode=profile&amp;uid=' . $A['uid'];
            if (! empty($photo)) {
                $template->set_var('author_photo', $photo);
                $camera_icon = '<img src="' . $_CONF['layout_url']
                    . '/images/smallcamera.' . $_IMAGE_TYPE . '" alt=""'
                    . XHTML . '>';
                $template->set_var('camera_icon',
                                   COM_createLink($camera_icon, $profile_link));
            } else {
                $template->set_var('author_photo', '');
                $template->set_var('camera_icon', '');
            }

            $template->set_var('start_author_anchortag',
                               '<a href="' . $profile_link . '">' );
            $template->set_var('end_author_anchortag', '</a>');
            $template->set_var('author_link',
                               COM_createLink($fullname, $profile_link));

        } else {
            // comment is from anonymous user
            if (isset($A['name'])) {
                $A['username'] = strip_tags($A['name']);
            }
            $template->set_var( 'author', $A['username'] );
            $template->set_var( 'author_fullname', $A['username'] );
            $template->set_var( 'author_link', $A['username'] );
            $template->set_var( 'author_photo', '' );
            $template->set_var( 'camera_icon', '' );
            $template->set_var( 'start_author_anchortag', '' );
            $template->set_var( 'end_author_anchortag', '' );
        }

        // hide reply link from anonymous users if they can't post replies
        $hidefromanon = false;
        if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
                                 ($_CONF['commentsloginrequired'] == 1))) {
            $hidefromanon = true;
        }

        // this will hide HTML that should not be viewed in preview mode
        if( $preview || $hidefromanon ) {
            $template->set_var( 'hide_if_preview', 'style="display:none"' );
        } else {
            $template->set_var( 'hide_if_preview', '' );
        }

        // for threaded mode, add a link to comment parent
        if( $mode == 'threaded' && $A['pid'] != 0 && $indent == 0 ) {
            $pid = DB_getItem($_TABLES['comments'], 'pid',
                              "cid = '{$A['pid']}'");
            if ($pid != 0) {
                $plink = $_CONF['site_url'] . '/comment.php?mode=display'
                       . '&amp;sid=' . $A['sid'] . '&amp;type=' . $type
                       . '&amp;order=' . $order . '&amp;pid=' . $pid
                       . '&amp;format=threaded';
            } else {
                $plink = $_CONF['site_url'] . '/comment.php?mode=view'
                       . '&amp;sid=' . $A['sid'] . '&amp;type=' . $type
                       . '&amp;order=' . $order . '&amp;cid=' . $A['pid']
                       . '&amp;format=threaded';
            }
            $parent_link = COM_createLink($LANG01[44], $plink) . ' | ';
            $template->set_var('parent_link', $parent_link);
        } else {
            $template->set_var('parent_link', '');
        }

        $template->set_var( 'date', strftime( $_CONF['date'], $A['nice_date'] ));
        $template->set_var( 'sid', $A['sid'] );
        $template->set_var( 'type', $A['type'] );

        // COMMENT edit rights
        $edit_option = false;
        if (isset($A['uid']) && isset($_USER['uid'])
                && ($_USER['uid'] == $A['uid']) && ($_CONF['comment_edit'] == 1)
                && ((time() - $A['nice_date']) < $_CONF['comment_edittime'])
                && (DB_getItem($_TABLES['comments'], 'COUNT(*)',
                               "pid = {$A['cid']}") == 0)) {
            $edit_option = true;
            if (empty($token) && !$preview && !$submit) {
                $token = SEC_createToken();
            }
        } elseif (SEC_hasRights('comment.moderate')) { 
            $edit_option = true;
        }

        if (COMMENT_ON_SAME_PAGE) {
            list($plgurl, $plgid) = CMT_getCommentUrlId($type);
        }
        
        // edit link
        $edit = '';
        if ($edit_option) {
            if (COMMENT_ON_SAME_PAGE) {
                $editlink = $plgurl . '?' . CMT_MODE . '=edit&amp;' . CMT_CID . '='
                    . $A['cid'] . "&amp;$plgid=" . $A['sid'] . '&amp;' . CMT_TYPE . '=' . $type
                    . '&amp;mode=' . $mode
                    . '&amp;order=' . $order
                    . '&amp;cpage=' . $cpage
                    . '#commenteditform';
            } else {
                $editlink = $_CONF['site_url'] . '/comment.php?mode=edit&amp;cid='
                    . $A['cid'] . '&amp;sid=' . $A['sid'] . '&amp;type=' . $type;
            }
            $edit = COM_createLink($LANG01[4], $editlink) . ' | ';
        }

        // unsubscribe link
        $unsubscribe = '';
        if (($_CONF['allow_reply_notifications'] == 1) && !COM_isAnonUser()
                && isset($A['uid']) && isset($_USER['uid'])
                && ($_USER['uid'] == $A['uid'])) {
            $hash = DB_getItem($_TABLES['commentnotifications'], 'deletehash',
                               "cid = {$A['cid']} AND uid = {$_USER['uid']}");
            if (! empty($hash)) {
                if (COMMENT_ON_SAME_PAGE) {
                    $unsublink = $plgurl . '?' . CMT_MODE . "=unsubscribe&amp;$plgid="
                               . $A['sid'] . '&amp;key=' . $hash;
                } else {
                    $unsublink = $_CONF['site_url']
                               . '/comment.php?mode=unsubscribe&amp;key=' . $hash;
                }
                $unsubattr = array('title' => $LANG03[43]);
                $unsubscribe = COM_createLink($LANG03[42], $unsublink,
                                              $unsubattr) . ' | ';
            }
        }

        // if deletion is allowed, displays delete link
        if ($delete_option) {
            $deloption = '';

            // always place edit option first, if available
            if (! empty($edit)) {
                $deloption .= $edit;
            }

            // actual delete option
            if (COMMENT_ON_SAME_PAGE) {
                $dellink = $plgurl .'?' . CMT_MODE . '=delete&amp;' . CMT_CID . '='
                    . $A['cid'] . "&amp;$plgid=" . $A['sid'] . '&amp;' . CMT_TYPE . '=' . $type
                    . '&amp;' . CSRF_TOKEN . '=' . $token;
            } else {
                $dellink = $_CONF['site_url'] . '/comment.php?mode=delete&amp;cid='
                    . $A['cid'] . '&amp;sid=' . $A['sid'] . '&amp;type=' . $type
                    . '&amp;' . CSRF_TOKEN . '=' . $token;
            }
            $delattr = array('onclick' => "return confirm('{$MESSAGE[76]}');");
            $deloption .= COM_createLink($LANG01[28], $dellink, $delattr) . ' | ';

            if (!empty($A['ipaddress'])) {
                if (empty($_CONF['ip_lookup'])) {
                    $deloption .= $A['ipaddress'] . '  | ';
                } else {
                    $iplookup = str_replace('*', $A['ipaddress'],
                                            $_CONF['ip_lookup']);
                    $deloption .= COM_createLink($A['ipaddress'], $iplookup) . ' | ';
                }
            }

            if (! empty($unsubscribe)) {
                $deloption .= $unsubscribe;
            }

            $template->set_var('delete_option', $deloption);
        } elseif ($edit_option) {
            $template->set_var('delete_option', $edit . $unsubscribe);
        } elseif (! COM_isAnonUser()) {
            $reportthis = '';
            if ($A['uid'] != $_USER['uid']) {
                if (COMMENT_ON_SAME_PAGE) {
                    $reportthis_link = $plgurl .'?' . CMT_MODE . '=report&amp;' . CMT_CID . '=' . $A['cid']
                        . '&amp;' . CMT_TYPE . '=' . $type;
                } else {
                    $reportthis_link = $_CONF['site_url']
                        . '/comment.php?mode=report&amp;cid=' . $A['cid']
                        . '&amp;type=' . $type;
                }
                $report_attr = array('title' => $LANG01[110]);
                $reportthis = COM_createLink($LANG01[109], $reportthis_link,
                                             $report_attr) . ' | ';
            }
            $template->set_var('delete_option', $reportthis . $unsubscribe);
        } else {
            $template->set_var('delete_option', '');
        }
        
        //and finally: format the actual text of the comment, but check only the text, not sig or edit
        $text = str_replace('<!-- COMMENTSIG --><div class="comment-sig">', '',
                            $A['comment']);
        $text = str_replace('</div><!-- /COMMENTSIG -->', '', $text);
        $text = str_replace('<div class="comment-edit">', '', $text);
        $text = str_replace('</div><!-- /COMMENTEDIT -->', '', $text);
        if (preg_match('/<.*>/', $text) == 0) {
//          $A['comment'] = '<p>' . nl2br($A['comment']) . '</p>';
            $A['comment'] = '<div class="commentbody">' . nl2br($A['comment']) . '</div>';
        }

        // highlight search terms if specified
        if( !empty( $_REQUEST['query'] )) {
            $A['comment'] = COM_highlightQuery( $A['comment'],
                                                $_REQUEST['query'] );
        }

        $A['comment'] = str_replace( '$', '&#36;',  $A['comment'] );
        $A['comment'] = str_replace( '{', '&#123;', $A['comment'] );
        $A['comment'] = str_replace( '}', '&#125;', $A['comment'] );
        
        // Replace any plugin autolink tags
        $A['comment'] = PLG_replaceTags( $A['comment'] );        

        // create a reply to link
        $reply_link = '';
        if ($ccode == 0) {
            if (COMMENT_ON_SAME_PAGE) {
                $reply_link = $plgurl ."?$plgid=" . $A['sid']
                            . '&amp;' . CMT_PID . '=' . $A['cid']
                            . '&amp;' . CMT_TYPE . '=' . $A['type']
                            . '&amp;mode=' . $mode
                            . '&amp;order=' . $order
                            . '&amp;cpage=' . $cpage
                            . '#commenteditform';
            } else {
                $reply_link = $_CONF['site_url'] . '/comment.php?sid=' . $A['sid']
                            . '&amp;pid=' . $A['cid'] . '&amp;type=' . $A['type'];
            }
            $reply_option = COM_createLink($LANG01[43], $reply_link,
                                           array('rel' => 'nofollow')) . ' | ';
            $template->set_var('reply_option', $reply_option);
        } else {
            $template->set_var('reply_option', '');
        }
        $template->set_var('reply_link', $reply_link);

        // format title for display, must happen after reply_link is created
        $A['title'] = htmlspecialchars( $A['title'] );
        $A['title'] = str_replace( '$', '&#36;', $A['title'] );

        $template->set_var( 'title', $A['title'] );
        $template->set_var( 'comments', $A['comment'] );

        // parse the templates
        if( ($mode == 'threaded') && $indent > 0 ) {
            $template->set_var( 'pid', $A['pid'] );
            $retval .= $template->parse( 'output', 'thread' );
        } else {
            $template->set_var( 'pid', $A['cid'] );
            $retval .= $template->parse( 'output', 'comment' );
        }
        $row++;
    } while( !$preview && ($A = DB_fetchArray( $comments )));
    


    return $retval;
}

/**
* This function displays the comments in a high level format.
*
* Begins displaying user comments for an item
*
* @param    string      $sid       ID for item to show comments for
* @param    string      $title     Title of item
* @param    string      $type      Type of item (article, polls, etc.)
* @param    string      $order     How to order the comments 'ASC' or 'DESC'
* @param    string      $mode      comment mode (nested, flat, etc.)
* @param    int         $pid       id of parent comment
* @param    int         $page      page number of comments to display
* @param    boolean     $cid       true if $pid should be interpreted as a cid instead
* @param    boolean     $delete_option   if current user can delete comments
* @param    int         $ccode     Comment code: -1=no comments, 0=allowed, 1=closed
* @return   string  HTML Formated Comments
* @see CMT_commentBar
*
*/
function CMT_userComments( $sid, $title, $type='article', $order='', $mode='', $pid = 0, $page = 1, $cid = false, $delete_option = false, $ccode = 0 )
{
    global $_CONF, $_TABLES, $_USER, $LANG01;

    $retval = '';

    if (! COM_isAnonUser()) {
        $result = DB_query( "SELECT commentorder,commentmode,commentlimit FROM {$_TABLES['usercomment']} WHERE uid = '{$_USER['uid']}'" );
        $U = DB_fetchArray( $result );
        if( empty( $order ) ) {
            $order = $U['commentorder'];
        }
        if( empty( $mode ) ) {
            $mode = $U['commentmode'];
        }
        $limit = $U['commentlimit'];
    }

    if( $order != 'ASC' && $order != 'DESC' ) {
        $order = 'ASC';
    }

    if( empty( $mode )) {
        $mode = $_CONF['comment_mode'];
    }

    if( empty( $limit )) {
        $limit = $_CONF['comment_limit'];
    }

    if( !is_numeric($page) || $page < 1 ) {
        $page = 1;
    }

    $start = $limit * ( $page - 1 );

    $template = COM_newTemplate($_CONF['path_layout'] . 'comment');
    $template->set_file( array( 'commentarea' => 'startcomment.thtml' ));
    $template->set_var( 'commentbar',
            CMT_commentBar( $sid, $title, $type, $order, $mode, $ccode ));
    $template->set_var( 'sid', $sid );
    $template->set_var( 'comment_type', $type );
    $template->set_var( 'area_id', 'commentarea' );

    if( $mode == 'nested' || $mode == 'threaded' || $mode == 'flat' ) {
        // build query
        switch( $mode ) {
            case 'flat':
                if( $cid ) {
                    $count = 1;

                    $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, "
                       . "UNIX_TIMESTAMP(c.date) AS nice_date "
                       . "FROM {$_TABLES['comments']} AS c, {$_TABLES['users']} AS u "
                       . "WHERE c.uid = u.uid AND c.cid = $pid AND type='{$type}'";
                } else {
                    $count = DB_count( $_TABLES['comments'],
                                array( 'sid', 'type' ), array( $sid, $type ));

                    $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, "
                       . "UNIX_TIMESTAMP(c.date) AS nice_date "
                       . "FROM {$_TABLES['comments']} AS c, {$_TABLES['users']} AS u "
                       . "WHERE c.uid = u.uid AND c.sid = '$sid' AND type='{$type}' "
                       . "ORDER BY date $order LIMIT $start, $limit";
                }
                break;

            case 'nested':
            case 'threaded':
            default:
                if( $order == 'DESC' ) {
                    $cOrder = 'c.rht DESC';
                } else {
                    $cOrder = 'c.lft ASC';
                }

                // We can simplify the query, and hence increase performance
                // when pid = 0 (when fetching all the comments for a given sid)
                if( $cid ) {  // pid refers to commentid rather than parentid
                    // count the total number of applicable comments
                    $q2 = "SELECT COUNT(*) "
                        . "FROM {$_TABLES['comments']} AS c, {$_TABLES['comments']} AS c2 "
                        . "WHERE c.sid = '$sid' AND (c.lft >= c2.lft AND c.lft <= c2.rht) "
                        . "AND c2.cid = $pid AND c.type='{$type}'";
                    $result = DB_query( $q2 );
                    list( $count ) = DB_fetchArray( $result );

                    $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, c2.indent AS pindent, "
                       . "UNIX_TIMESTAMP(c.date) AS nice_date "
                       . "FROM {$_TABLES['comments']} AS c, {$_TABLES['comments']} AS c2, "
                       . "{$_TABLES['users']} AS u "
                       . "WHERE c.sid = '$sid' AND (c.lft >= c2.lft AND c.lft <= c2.rht) "
                       . "AND c2.cid = $pid AND c.uid = u.uid AND c.type='{$type}' "
                       . "ORDER BY $cOrder LIMIT $start, $limit";
                } else {    // pid refers to parentid rather than commentid
                    if( $pid == 0 ) {  // the simple, fast case
                        // count the total number of applicable comments
                        $count = DB_count( $_TABLES['comments'],
                                array( 'sid', 'type' ), array( $sid, $type ));

                        $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, 0 AS pindent, "
                           . "UNIX_TIMESTAMP(c.date) AS nice_date "
                           . "FROM {$_TABLES['comments']} AS c, {$_TABLES['users']} AS u "
                           . "WHERE c.sid = '$sid' AND c.uid = u.uid  AND type='{$type}' "
                           . "ORDER BY $cOrder LIMIT $start, $limit";
                    } else {
                        // count the total number of applicable comments
                        $q2 = "SELECT COUNT(*) "
                            . "FROM {$_TABLES['comments']} AS c, {$_TABLES['comments']} AS c2 "
                            . "WHERE c.sid = '$sid' AND (c.lft > c2.lft AND c.lft < c2.rht) "
                            . "AND c2.cid = $pid AND c.type='{$type}'";
                        $result = DB_query($q2);
                        list($count) = DB_fetchArray($result);

                        $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, c2.indent + 1 AS pindent, "
                           . "UNIX_TIMESTAMP(c.date) AS nice_date "
                           . "FROM {$_TABLES['comments']} AS c, {$_TABLES['comments']} AS c2, "
                           . "{$_TABLES['users']} AS u "
                           . "WHERE c.sid = '$sid' AND (c.lft > c2.lft AND c.lft < c2.rht) "
                           . "AND c2.cid = $pid AND c.uid = u.uid AND c.type='{$type}' "
                           . "ORDER BY $cOrder LIMIT $start, $limit";
                    }
                }
                break;
        }

        $thecomments = '';
        $result = DB_query( $q );

        $thecomments .= CMT_getComment( $result, $mode, $type, $order,
                                        $delete_option, false, $ccode, $page );

        // Pagination
        $tot_pages =  ceil($count / $limit);
        $is_comment_page = CMT_isCommentPage();
        if ($is_comment_page) {
            $pLink[0] = "comment.php?sid=$sid";
            $pLink[0] .= "&amp;" . CMT_TYPE . "=$type&amp;order=$order&amp;format=$mode";
        } else {
            list($plgurl, $plgid) = CMT_getCommentUrlId($type);
            $pLink[0] = "$plgurl?$plgid=$sid"; 
            $pLink[0] .= "&amp;" . CMT_TYPE . "=$type&amp;order=$order&amp;mode=$mode";
        }
        $pLink[1] = "#comments"; 
        $page_str = "cpage=";
        $template->set_var('pagenav',
                           COM_printPageNavigation($pLink, $page, $tot_pages, $page_str, false));

        $template->set_var('comments', $thecomments);

        if (COMMENT_ON_SAME_PAGE) {
            if ($ccode == 0) {
                $cmode = COM_applyFilter(COM_getArgument(CMT_MODE));
                $html = CMT_handleComment($cmode, $type, $title, $sid, $mode);
                $template->set_var('commenteditor', $html);
            }
        }

        $retval = $template->finish($template->parse('output', 'commentarea'));
    }

    return $retval;
}

/**
* Displays the comment form
*
* @param    string  $title      Title of comment
* @param    string  $comment    Text of comment
* @param    string  $sid        ID of object comment belongs to
* @param    int     $pid        ID of parent comment
* @param    string  $type       Type of object comment is posted to
* @param    string  $mode       Mode, e.g. 'preview'
* @param    string  $postmode   Indicates if comment is plain text or HTML
* @param    string  $format     'threaded', 'nested', or 'flat'
* @param    string  $order      'ASC' or 'DESC' or blank
* @param    int     $page       Page number of comments to display
* @return   string  HTML for comment form
*
*/
function CMT_commentForm($title, $comment, $sid, $pid='0', $type, $mode, $postmode, $format='', $order='', $page='')
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG03, $LANG12, $LANG_ADMIN
    , $LANG_ACCESS, $MESSAGE, $_SCRIPTS;

    $retval = '';

    // never trust $uid ...
    if (empty ($_USER['uid'])) {
        $uid = 1;
    } else {
        $uid = $_USER['uid'];
    }

    if (empty($format)) {
        if(isset($_REQUEST['format'])) {
            $format = COM_applyFilter($_REQUEST['format']);
        }
        if (!in_array($format, array('threaded', 'nested', 'flat', 'nocomment'))) {
            if (COM_isAnonUser()) {
                $format = $_CONF['comment_mode'];
            } else {
                $format = DB_getItem( $_TABLES['usercomment'], 'commentmode', 
                                      "uid = $uid" );
            }
        }
    }

    if (empty($order)) {
        if (isset($_REQUEST['order'])) {
            $order = COM_applyFilter($_REQUEST['order']);
        }
    }

    if (empty($page)) {
        if (isset($_REQUEST['cpage'])) {
            $page = COM_applyFilter($_REQUEST['cpage'], true);
            if (empty($page)) $page = 1;
        }
    }

    $commentuid = $uid;
    $table = $_TABLES['comments'];
    if (($mode == 'edit' || $mode == $LANG03[28]) && isset($_REQUEST[CMT_CID])) {
        $cid = COM_applyFilter ($_REQUEST[CMT_CID]);
        $commentuid = DB_getItem ($_TABLES['comments'], 'uid', "cid = '$cid'");
    } elseif ($mode == 'editsubmission' || $mode == $LANG03[34]) {
        $cid = COM_applyFilter ($_REQUEST[CMT_CID]);
        $commentuid = DB_getItem ($_TABLES['commentsubmissions'], 'uid', "cid = '$cid'");
        $table = $_TABLES['commentsubmissions'];
    }

    if (COM_isAnonUser() &&
            (($_CONF['loginrequired'] == 1) || ($_CONF['commentsloginrequired'] == 1))) {
        $retval .= SEC_loginRequiredForm();
        return $retval;
    } else {
        COM_clearSpeedlimit ($_CONF['commentspeedlimit'], 'comment');

        $last = 0;
        if ($mode != 'edit' && $mode != 'editsubmission' 
                && $mode != $LANG03[28] && $mode != $LANG03[34]) {
            // not edit mode or preview changes
            $last = COM_checkSpeedlimit ('comment');
        }

        if ($last > 0) {
            if (COMMENT_ON_SAME_PAGE) {
                $retval .= COM_startBlock ($MESSAGE[40], '',
                                   COM_getBlockTemplate ('_msg_block', 'header'))
                    . $LANG03[45]
                    . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            } else {
                $retval .= COM_startBlock ($LANG12[26], '',
                                   COM_getBlockTemplate ('_msg_block', 'header'))
                    . $LANG03[7] . $last . $LANG03[8]
                    . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            }
        } else {

            if (($postmode != 'html') && ($postmode != 'plaintext')) {
                if (empty($postmode) && $_CONF['advanced_editor'] && $_USER['advanced_editor']) {
                    $postmode = 'html';
                } elseif (empty($postmode)) {
                    $postmode = $_CONF['postmode'];
                }
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

            // Replace $, {, and } with special HTML equivalents
            $commenttext = str_replace('$','&#36;',$commenttext);
            $commenttext = str_replace('{','&#123;',$commenttext);
            $commenttext = str_replace('}','&#125;',$commenttext);
            
            // Remove any autotags the user doesn't have permission to use
            $commenttext = PLG_replaceTags($commenttext, '', true);

            // Autotags can now be used in templates when an article is rendered
            // for this reason, replace [, ] in order to prevent garbled characters
            $commenttext = str_replace('[','&#91;',$commenttext);
            $commenttext = str_replace(']','&#93;',$commenttext);

            $title = COM_checkWords (strip_tags (COM_stripslashes ($title)));
            // $title = str_replace('$','&#36;',$title); done in CMT_getComment

            $_POST['title'] = $title;
            $newcomment = $comment;
            if ($mode == $LANG03[28] ) { // for preview
                $newcomment = CMT_prepareText($comment, $postmode, $type, true, $cid);
            } elseif ($mode == $LANG03[34]) {
                $newcomment = CMT_prepareText($comment, $postmode, $type, true);
            } else {
                $newcomment = CMT_prepareText($comment, $postmode, $type);
            }
            $_POST['comment'] = $newcomment;

            // Preview mode:
            if (($mode == $LANG03[14] || $mode == $LANG03[28] || $mode == $LANG03[34]) && !empty($title) && !empty($comment) ) {
                $start = COM_newTemplate($_CONF['path_layout'] . 'comment');
                $start->set_file(array('comment' => 'startcomment.thtml'));
                $start->set_var('hide_if_preview', 'style="display:none"');
                $start->set_var( 'area_id', 'commentperview' );

                // Clean up all the vars
                $A = array();
                foreach ($_POST as $key => $value) {
                    if (($key == CMT_PID) || ($key == CMT_CID)) {
                        $A[$key] = COM_applyFilter ($_POST[$key], true);
                    } else if (($key == 'title') || ($key == 'comment')) {
                        // these have already been filtered above
                        $A[$key] = $_POST[$key];
                    } else if ($key == CMT_USERNAME) {
                        $A[$key] = htmlspecialchars(COM_checkWords(strip_tags(
                                    COM_stripslashes($_POST[$key]))));
                    } else {
                        $A[$key] = COM_applyFilter ($_POST[$key]);
                    }
                }

                // correct time and username for edit preview
                if (($mode == $LANG03[28]) || ($mode == $LANG03[34])) { 
                    $A['nice_date'] = DB_getItem($table, 'UNIX_TIMESTAMP(date)',
                                                 "cid = '$cid'");
                    if ($_USER['uid'] != $commentuid) {
                        $uresult = DB_query("SELECT username, fullname, email, photo FROM {$_TABLES['users']} WHERE uid = $commentuid");
                        $A = array_merge($A, DB_fetchArray($uresult));
                    }
                } 
                if (($uid != 1) || empty($A[CMT_USERNAME])) {
                    $A[CMT_USERNAME] = DB_getItem ($_TABLES['users'], 'username',
                                                 "uid = $uid");
                }

                if (COMMENT_ON_SAME_PAGE) {
                    $A['cid'] = $A[CMT_CID];
                    $A['sid'] = $A[CMT_SID];
                    $A['pid'] = $A[CMT_PID];
                    $A['uid'] = $A[CMT_UID];
                    $A['type'] = $A[CMT_TYPE];
                    $A['username'] = $A[CMT_USERNAME];
                }

                $thecomments = CMT_getComment ($A, 'flat', $type, 'ASC', false,
                                               true);

                $start->set_var( 'comments', $thecomments );
                $retval .= COM_startBlock ($LANG03[14])
                        . $start->finish( $start->parse( 'output', 'comment' ))
                        . COM_endBlock ();
            } else if ($mode == $LANG03[14]) {
                $retval .= COM_showMessageText($LANG03[12], $LANG03[17]);
                $mode = 'error';
            }

            $comment_template = COM_newTemplate($_CONF['path_layout'] . 'comment');
            if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
                $comment_template->set_file('form', 'commentform_advanced.thtml');
                
                if (COM_isAnonUser()) {
                    $link_message = "";
                } else {
                    $link_message = $LANG01[138];    
                } 
                $comment_template->set_var('noscript', COM_getNoScript(false, '', $link_message));
                
                // Add JavaScript
                $js = 'geeklogEditorBasePath = "' . $_CONF['site_url'] . '/fckeditor/";';
                // Hide the Advanced Editor as Javascript is required. If JS is enabled then the JS below will un-hide it
                $js .= 'document.getElementById("advanced_editor").style.display="";';                 
                $_SCRIPTS->setJavaScript($js, true);
                $_SCRIPTS->setJavaScriptFile('submitcomment_fckeditor', '/javascript/submitcomment_fckeditor.js');
            } else {
                $comment_template->set_file('form', 'commentform.thtml');
            }

            $is_comment_page = CMT_isCommentPage();
            if ($is_comment_page) {
                $comment_template->set_var('nprefix', '');
            } else {
                $comment_template->set_var('nprefix', 'cmt_');
            }
            $comment_template->set_var('format', $format);
            $comment_template->set_var('order', $order);
            $comment_template->set_var('cpage', $page);

            $comment_template->set_var('start_block_postacomment', COM_startBlock($LANG03[1]));
            if ($_CONF['show_fullname'] == 1) {
                $comment_template->set_var('lang_username', $LANG_ACCESS['name']);
            } elseif (COM_isAnonUser()) {
                $comment_template->set_var('lang_username', $LANG03[44]);
            } else {
                $comment_template->set_var('lang_username', $LANG03[5]);
            }
            $comment_template->set_var('sid', $sid);
            $comment_template->set_var('pid', $pid);
            $comment_template->set_var('type', $type);
            if ($mode == 'edit' || $mode == 'editsubmission' || $mode == $LANG03[28] || $mode == $LANG03[34]) {
                $comment_template->set_var('hidewhenediting',
                                           ' style="display:none;"');
            } else {
                $comment_template->set_var('hidewhenediting', '');
            }

            if (COMMENT_ON_SAME_PAGE) {
                list($plgurl, $plgid) = CMT_getCommentUrlId($type);

                // Filemgmt plugin is doing special processing.
                // Therefore, I support specially, against my better judgment.
                // May should delete this code part.
                if ($type == 'filemgmt') {
                    $sid = str_replace('fileid_', '', $sid);
                }

                $formurl = "$plgurl?$plgid=$sid#commentperview";
            } else {
                $formurl = $_CONF['site_url'] . '/comment.php';
            }

            if ($mode == 'edit' || $mode == $LANG03[28]) { //edit modes
            	$comment_template->set_var('start_block_postacomment',
                                           COM_startBlock($LANG03[32]));
            	$comment_template->set_var('cid', '<input type="hidden" name="' . CMT_CID . '" value="' . $cid . '"' . XHTML . '>');
            } else if ($mode == 'editsubmission' || $mode == $LANG03[34]) {
                $comment_template->set_var('start_block_postacomment',
                                           COM_startBlock($LANG03[33]));
                $comment_template->set_var('cid', '<input type="hidden" name="' . CMT_CID . '" value="' . $cid . '"' . XHTML . '>');
            } else {
                $comment_template->set_var('start_block_postacomment',
                                           COM_startBlock($LANG03[1]));
            	$comment_template->set_var('cid', '');
            }
            $comment_template->set_var('form_url', $formurl);

            if (COM_isAnonUser()) {
                // Anonymous user
                $comment_template->set_var('uid', 1);
                if (isset($A[CMT_USERNAME])) {
                    $name = $A[CMT_USERNAME]; // for preview
                } elseif (isset($_COOKIE[$_CONF['cookie_anon_name']])) {
                    // stored as cookie, name used before
                    $name = htmlspecialchars(COM_checkWords(strip_tags(
                        COM_stripslashes($_COOKIE[$_CONF['cookie_anon_name']]))));
                } else {
                    $name = COM_getDisplayName(1); // anonymous user
                }
                $usernameblock = '<input type="text" name="' . CMT_USERNAME . '" size="16" value="' . 
                                 $name . '" maxlength="32"' . XHTML . '>';
                $comment_template->set_var('username', $usernameblock);

                $comment_template->set_var('action_url',
                    $_CONF['site_url'] . '/users.php?mode=new');
                $comment_template->set_var('lang_logoutorcreateaccount',
                    $LANG03[04]);
            } else {
                if ($commentuid != $_USER['uid']) {
                    $uresult = DB_query("SELECT username, fullname FROM {$_TABLES['users']} WHERE uid = $commentuid");
                    list($username, $fullname) = DB_fetchArray($uresult);
                } else {
                    $username = $_USER['username'];
                    $fullname = $_USER['fullname'];
                }
                $comment_template->set_var('gltoken_name', CSRF_TOKEN);
                $comment_template->set_var('gltoken', SEC_createToken());
                $comment_template->set_var('uid', $commentuid);
                $name = COM_getDisplayName($commentuid, $username, $fullname);
                $comment_template->set_var('username', $name);
                $comment_template->set_var('action_url',
                    $_CONF['site_url'] . '/users.php?mode=logout');
                $comment_template->set_var('lang_logoutorcreateaccount',
                    $LANG03[03]);
            }
            
            $comment_template->set_var('lang_cancel', $LANG_ADMIN['cancel']); 

            if ($mode == 'editsubmission' OR $mode == 'edit' OR $mode == $LANG03[34] OR $mode == $LANG03[28]) {
                $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                           . '" name="mode"%s' . XHTML . '>';            
                $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
                $comment_template->set_var ('delete_option',
                                          sprintf ($delbutton, $jsconfirm));            
            }
            if ($mode == 'editsubmission' OR $mode == $LANG03[34]) { // Preview Submission changes (for edit)
                $comment_template->set_var('formtype', 'editsubmission');
            } elseif ($mode == 'edit' OR $mode == $LANG03[28]) { // Preview changes (for edit)
                $comment_template->set_var('formtype', 'edit');
            } else {
                $comment_template->set_var('formtype', 'new');
            }    
            

            if ($postmode == 'html') {
                $comment_template->set_var ('show_texteditor', 'none');
                $comment_template->set_var ('show_htmleditor', '');
            } else {
                $comment_template->set_var ('show_texteditor', '');
                $comment_template->set_var ('show_htmleditor', 'none');
            }

            $comment_template->set_var('lang_title', $LANG03[16]);
            $comment_template->set_var('title', htmlspecialchars($title));
            $comment_template->set_var('lang_comment', $LANG03[9]);
            $comment_template->set_var('comment', $commenttext);
            $comment_template->set_var('lang_postmode', $LANG03[2]);
            $comment_template->set_var('postmode_options',
                COM_optionList($_TABLES['postmodes'], 'code,name', $postmode));
            $comment_template->set_var('allowed_html',
                COM_allowedHTML($type == 'article'
                                ? 'story.edit' : "$type.edit"));
            $comment_template->set_var('lang_importantstuff', $LANG03[18]);
            $comment_template->set_var('lang_instr_line1', $LANG03[19]);
            $comment_template->set_var('lang_instr_line2', $LANG03[20]);
            $comment_template->set_var('lang_instr_line3', $LANG03[21]);
            $comment_template->set_var('lang_instr_line4', $LANG03[22]);
            $comment_template->set_var('lang_instr_line5', $LANG03[23]);

            if ($mode == 'edit' || $mode == $LANG03[28]) {
                //editing comment or preview changes
                $comment_template->set_var('lang_preview', $LANG03[28]); 
            } elseif ($mode == 'editsubmission' || $mode == $LANG03[34]) {
                $comment_template->set_var('lang_preview', $LANG03[34]);
            } else {
            	//new comment
                $comment_template->set_var('lang_preview', $LANG03[14]);
            }

            if ($mode == $LANG03[28] || ($mode == 'edit' && $_CONF['skip_preview'] == 1)) {
                PLG_templateSetVars('comment', $comment_template); // Only for a edit form with a save button displayed (CAPTCHA related issue)
                // for editing
                $comment_template->set_var('save_option',
                    '<input type="submit" name="' . CMT_MODE . '" value="' . $LANG03[29] // 'Submit Changes'
                    . '"' . XHTML . '>');
            } elseif ($mode == $LANG03[34] || ($mode == 'editsubmission' && $_CONF['skip_preview'] == 1))  {
                PLG_templateSetVars('comment', $comment_template);
                // editing submission comment
                $comment_template->set_var('save_option',
                    '<input type="submit" name="' . CMT_MODE . '" value="' . $LANG03[35] // 'Save Changes to Queue'
                    . '"' . XHTML . '>');
            } elseif (($_CONF['skip_preview'] == 1) || ($mode == $LANG03[14])) {
                PLG_templateSetVars('comment', $comment_template);
                $comment_template->set_var('save_option',
                    '<input type="submit" name="' . CMT_MODE . '" value="' . $LANG03[11] // 'Submit Comment'
                    . '"' . XHTML . '>');

            }
            
            if (($_CONF['allow_reply_notifications'] == 1 && $uid != 1) && 
                    ($mode == '' || $mode == $LANG03[14] || $mode == 'error')) {
                $checked = '';
                if (isset($_POST['notify'])) {
                    $checked = ' checked="checked"';
                }
                $comment_template->set_var('notification',
                    '<p><input type="checkbox"' . ' name="notify"' . $checked
                    . '>' . $LANG03[36] . '</p>');
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
 * @author   Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param    string      $title      Title of comment
 * @param    string      $comment    Text of comment
 * @param    string      $sid        ID of object receiving comment
 * @param    int         $pid        ID of parent comment
 * @param    string      $type       Type of comment this is (article, polls, etc)
 * @param    string      $postmode   Indicates if text is HTML or plain text
 * @return   int         -1 == queued, 0 == comment saved, > 0 indicates error
 *
 */
// FIXME: This function relies on $cid being NULL without being initialized in 
//        the case of a comment submission. This is not ideal.
function CMT_saveComment($title, $comment, $sid, $pid, $type, $postmode)
{
    global $_CONF, $_TABLES, $_USER, $LANG03;

    $ret = 0;

    // Get a valid uid
    if (empty ($_USER['uid'])) {
        $uid = 1;
    } else {
        $uid = $_USER['uid'];
    }

    // Sanity check
    if (empty ($sid) || empty ($title) || empty ($comment) || empty ($type) ) {
        COM_errorLog("CMT_saveComment: $uid from {$_SERVER['REMOTE_ADDR']} tried "
                   . 'to submit a comment with one or more missing values.');
        return $ret = 1;
    }

    // Check that anonymous comments are allowed
    if (($uid == 1) && (($_CONF['loginrequired'] == 1)
            || ($_CONF['commentsloginrequired'] == 1))) {
        COM_errorLog("CMT_saveComment: IP address {$_SERVER['REMOTE_ADDR']} "
                   . 'attempted to save a comment with anonymous comments disabled for site.');
        return $ret = 2;
    }

    // Check for people breaking the speed limit
    COM_clearSpeedlimit ($_CONF['commentspeedlimit'], 'comment');
    $last = COM_checkSpeedlimit ('comment');
    if ($last > 0) {
        COM_errorLog("CMT_saveComment: $uid from {$_SERVER['REMOTE_ADDR']} tried "
                   . 'to submit a comment before the speed limit expired');
        return $ret = 3;
    }

    // Let plugins have a chance to check for spam
    $spamcheck = '<h1>' . $title . '</h1><p>' . $comment . '</p>';
    $result = PLG_checkforSpam ($spamcheck, $_CONF['spamx']);
    // Now check the result and display message if spam action was taken
    if ($result > 0) {
        COM_updateSpeedlimit ('comment');                                // update speed limit nonetheless
        COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden'); // then tell them to get lost ...
    }

    // Let plugins have a chance to decide what to do before saving the comment, return errors.
    if ($someError = PLG_commentPreSave($uid, $title, $comment, $sid, $pid, $type, $postmode)) {
        return $someError;
    }

    $comment = addslashes(CMT_prepareText($comment, $postmode, $type));
    $title = addslashes(COM_checkWords(strip_tags($title)));
    if (($uid == 1) && isset($_POST[CMT_USERNAME])) {
        $anon = COM_getDisplayName(1);
        if (strcmp($_POST[CMT_USERNAME], $anon) != 0) {
            $username = COM_checkWords(strip_tags(COM_stripslashes($_POST[CMT_USERNAME])));
            setcookie($_CONF['cookie_anon_name'], $username, time() + 31536000,
                      $_CONF['cookie_path'], $_CONF['cookiedomain'],
                      $_CONF['cookiesecure']);
            $name = addslashes($username);
        }
    }

    // check for non-int pid's
    // this should just create a top level comment that is a reply to the original item
    if (!is_numeric($pid) || ($pid < 0)) {
        $pid = 0;
    }

    COM_updateSpeedlimit('comment');
    if (empty($title) || empty($comment)) {
        COM_errorLog("CMT_saveComment: $uid from {$_SERVER['REMOTE_ADDR']} tried "
                   . 'to submit a comment with invalid $title and/or $comment.');
        return $ret = 5;
    } 
    
    if (($_CONF['commentsubmission'] == 1) && !SEC_hasRights('comment.submit')) {
        // comment into comment submission table enabled
        if (isset($name)) {
            DB_query("INSERT INTO {$_TABLES['commentsubmissions']} (sid,uid,name,comment,type,date,title,pid,ipaddress) "
                   . "VALUES ('$sid',$uid,'$name','$comment','$type',NOW(),'$title',$pid,'{$_SERVER['REMOTE_ADDR']}')");
        } else {
            DB_query("INSERT INTO {$_TABLES['commentsubmissions']} (sid,uid,comment,type,date,title,pid,ipaddress) "
                   . "VALUES ('$sid',$uid,'$comment','$type',NOW(),'$title',$pid,'{$_SERVER['REMOTE_ADDR']}')");
        }

        $ret = -1; // comment queued
    } elseif ($pid > 0) {
        DB_lockTable ($_TABLES['comments']);

        $result = DB_query("SELECT rht, indent FROM {$_TABLES['comments']} WHERE cid = $pid AND sid = '$sid'");
        list($rht, $indent) = DB_fetchArray($result);
        if ( !DB_error() ) {
            $rht2=$rht+1;
            $indent+=1;
            DB_query("UPDATE {$_TABLES['comments']} SET lft = lft + 2 "
                   . "WHERE sid = '$sid' AND type = '$type' AND lft >= $rht");
            DB_query("UPDATE {$_TABLES['comments']} SET rht = rht + 2 "
                   . "WHERE sid = '$sid' AND type = '$type' AND rht >= $rht");
            if (isset($name)) {
                DB_save ($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,ipaddress,name',
             "'$sid',$uid,'$comment',now(),'$title',$pid,$rht,$rht2,$indent,'$type','{$_SERVER['REMOTE_ADDR']}','$name'");
            } else {
                DB_save ($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,ipaddress',
             "'$sid',$uid,'$comment',now(),'$title',$pid,$rht,$rht2,$indent,'$type','{$_SERVER['REMOTE_ADDR']}'");
            }

            $cid = DB_insertId('',$_TABLES['comments'].'_cid_seq');
        } else { //replying to non-existent comment or comment in wrong article
            COM_errorLog("CMT_saveComment: $uid from {$_SERVER['REMOTE_ADDR']} tried "
                       . 'to reply to a non-existent comment or the pid/sid did not match');
            $ret = 4; // Cannot return here, tables locked!
        }
        DB_unlockTable($_TABLES['comments']);
        
        // notify parent of new comment
        // Must occur after table unlock, only with valid $cid and $pid
        // NOTE: This could be modified to send notifications to all parents in the comment tree
        //       with only a modification to the below SELECT statement
        if ($_CONF['allow_reply_notifications'] == 1 && $cid > 0 && $pid > 0) {
        	$result = DB_query("SELECT cid, uid, deletehash FROM {$_TABLES['commentnotifications']} WHERE cid = $pid");
        	$A = DB_fetchArray($result);
        	if ($A !== false) {
        		CMT_sendReplyNotification($A);
        	}
        }
    } else {
        DB_lockTable ($_TABLES['comments']);
        $rht = DB_getItem($_TABLES['comments'], 'MAX(rht)', "sid = '$sid'");
        if ( DB_error() ) {
            $rht = 0;
        }
        $rht2=$rht+1;  // value of new comment's "lft"
        $rht3=$rht+2;  // value of new comment's "rht"
        if (isset($name)) {
            DB_save ($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,ipaddress,name',
                "'$sid',$uid,'$comment',now(),'$title',$pid,$rht2,$rht3,0,'$type','{$_SERVER['REMOTE_ADDR']}','$name'");
        } else {
            DB_save ($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,ipaddress',
                "'$sid',$uid,'$comment',now(),'$title',$pid,$rht2,$rht3,0,'$type','{$_SERVER['REMOTE_ADDR']}'");
        }
        $cid = DB_insertId('',$_TABLES['comments'].'_cid_seq');
        DB_unlockTable($_TABLES['comments']);
    }

    // save user notification information
    if (isset($_POST['notify']) && ($ret == -1 || $ret == 0) ) {
        $deletehash = md5($title . $cid . $comment . rand());
        if ($ret == -1) {
            //null goes into cid, comment not published yet, set moderation queue id
            DB_save($_TABLES['commentnotifications'], 'uid,deletehash,mid',"$uid,'$deletehash',$cid");
        } else {
            DB_save($_TABLES['commentnotifications'], 'cid,uid,deletehash',"$cid,$uid,'$deletehash'");
        }
    }

    // Send notification of comment if no errors and notifications enabled
    // for comments
    if ((($ret == -1) || ($ret == 0)) && isset($_CONF['notification']) &&
            in_array('comment', $_CONF['notification'])) {
        if ($ret == -1) {
            $cid = 0; // comment went into the submission queue
        }
        if (($uid == 1) && isset($username)) {
            CMT_sendNotification($title, $comment, $uid, $username, $_SERVER['REMOTE_ADDR'], $type, $cid);
        } else {
            CMT_sendNotification($title, $comment, $uid, '', $_SERVER['REMOTE_ADDR'], $type, $cid);
        }
    }
    
    return $ret;
}

/**
* Send an email notification for a new comment submission.
*
* @param    $title      string      comment title
* @param    $comment    string      text of the comment
* @param    $uid        int         user id
* @param    $username   string      optional name of anonymous user
* @param    $ipaddress  string      poster's IP address
* @param    $type       string      type of comment ('article', 'polls', ...)
* @param    $cid        int         comment id (or 0 when in submission queue)
* @return               boolean     true if successfully sent, otherwise false
*
*/
function CMT_sendNotification($title, $comment, $uid, $username, $ipaddress, $type, $cid)
{
    global $_CONF, $_TABLES, $LANG01, $LANG03, $LANG08, $LANG09, $LANG29;

    // sanity check
    if (($username == $_SERVER['REMOTE_ADDR']) &&
            ($ipaddress != $_SERVER['REMOTE_ADDR'])) {
        COM_errorLog("The API for CMT_sendNotification has changed ...");
        return false;
    }

    // we have to undo the addslashes() call from savecomment()
    $title = stripslashes($title);
    $comment = stripslashes($comment);

    // strip HTML if posted in HTML mode
    if (preg_match('/<.*>/', $comment) != 0) {
        $comment = strip_tags($comment);
    }

    if ($uid < 1) {
        $uid = 1;
    }
    if (($uid == 1) && !empty($username)) {
        $author = $username;
    } else {
        $author = COM_getDisplayName($uid);
    }
    if (($uid == 1) && !empty($ipaddress)) {
        // add IP address for anonymous posters
        $author .= ' (' . $ipaddress . ')';
    }

    $mailbody = "$LANG03[16]: $title\n"
              . "$LANG03[5]: $author\n";

    if ($type != 'article') {
        $mailbody .= "$LANG09[5]: $type\n";
    }

    if ($_CONF['emailstorieslength'] > 0) {
        if ($_CONF['emailstorieslength'] > 1) {
            $comment = MBYTE_substr($comment, 0, $_CONF['emailstorieslength'])
                     . '...';
        }
        $mailbody .= $comment . "\n\n";
    }

    if ($cid == 0) {
        $mailsubject = $_CONF['site_name'] . ' ' . $LANG29[41];
        $mailbody .= $LANG01[10] . ' <' . $_CONF['site_admin_url']
                  . "/moderation.php>\n\n";
    } else {
        $mailsubject = $_CONF['site_name'] . ' ' . $LANG03[9];
        $mailbody .= $LANG03[39] . ' <' . $_CONF['site_url']
                  . '/comment.php?mode=view&cid=' . $cid . ">\n\n";
    }

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";


    return COM_mail($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
 * Deletes a given comment
 *
 * The function expects the calling function to check to make sure the
 * requesting user has the correct permissions and that the comment exits
 * for the specified $type and $sid.
 *
 * @author  Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param   string      $type   article, or plugin identifier
 * @param   string      $sid    id of object comment belongs to
 * @param   int         $cid    Comment ID
 * @return  string      0 indicates success, >0 identifies problem
 */
function CMT_deleteComment ($cid, $sid, $type)
{
    global $_CONF, $_TABLES, $_USER;

    $ret = 0;  // Assume good status unless reported otherwise

    // Sanity check, note we return immediately here and no DB operations
    // are performed
    if (!is_numeric ($cid) || ($cid < 0) || empty ($sid) || empty ($type)) {
        COM_errorLog("CMT_deleteComment: {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
                   . 'to delete a comment with one or more missing/bad values.');
        return $ret = 1;
    }

    // Delete the comment from the DB and update the other comments to
    // maintain the tree structure
    // A lock is needed here to prevent other additions and/or deletions
    // from happening at the same time. A transaction would work better,
    // but aren't supported with MyISAM tables.
    DB_lockTable ($_TABLES['comments']);
    $result = DB_query("SELECT pid, lft, rht FROM {$_TABLES['comments']} "
                     . "WHERE cid = $cid AND sid = '$sid' AND type = '$type'");
    if ( DB_numRows($result) == 1 ) {
        list($pid,$lft,$rht) = DB_fetchArray($result);
        DB_change ($_TABLES['comments'], 'pid', $pid, 'pid', $cid);
        DB_delete ($_TABLES['comments'], 'cid', $cid);
        DB_query("UPDATE {$_TABLES['comments']} SET indent = indent - 1 "
           . "WHERE sid = '$sid' AND type = '$type' AND lft BETWEEN $lft AND $rht");
        DB_query("UPDATE {$_TABLES['comments']} SET lft = lft - 2 "
           . "WHERE sid = '$sid' AND type = '$type'  AND lft >= $rht");
        DB_query("UPDATE {$_TABLES['comments']} SET rht = rht - 2 "
           . "WHERE sid = '$sid' AND type = '$type'  AND rht >= $rht");
    } else {
        COM_errorLog("CMT_deleteComment: {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
                   . 'to delete a comment that doesn\'t exist as described.');
        return $ret = 2;
    }

    DB_unlockTable ($_TABLES['comments']);

    return $ret;
}

/**
* Display form to report abusive comment.
*
* @param    string  $cid    comment id
* @param    string  $type   type of comment ('article', 'polls', ...)
* @return   string          HTML for the form (or error message)
*
*/
function CMT_reportAbusiveComment ($cid, $type)
{
    global $_CONF, $_TABLES, $LANG03, $LANG12;

    $retval = '';

    if (COM_isAnonUser()) {
        $retval .= SEC_loginRequiredForm();

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

    $start = COM_newTemplate($_CONF['path_layout'] . 'comment');
    $start->set_file(array('report' => 'reportcomment.thtml'));
    $start->set_var('lang_report_this', $LANG03[25]);
    $start->set_var('lang_send_report', $LANG03[10]);
    $start->set_var('cid', $cid);
    $start->set_var('type', $type);
    $start->set_var('gltoken_name', CSRF_TOKEN);
    $start->set_var('gltoken', SEC_createToken());

    $result = DB_query ("SELECT uid,sid,pid,title,comment,UNIX_TIMESTAMP(date) AS nice_date FROM {$_TABLES['comments']} WHERE cid = $cid AND type = '$type'");
    $A = DB_fetchArray ($result);

    $result = DB_query ("SELECT username,fullname,photo,email FROM {$_TABLES['users']} WHERE uid = {$A['uid']}");
    $B = DB_fetchArray ($result);

    // prepare data for comment preview
    $A['cid'] = $cid;
    $A['type'] = $type;
    $A['username'] = $B['username'];
    $A['fullname'] = $B['fullname'];
    $A['photo'] = $B['photo'];
    $A['email'] = $B['email'];
    $A['indent'] = 0;
    $A['pindent'] = 0;

    $thecomment = CMT_getComment ($A, 'flat', $type, 'ASC', false, true);
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
* @param    string  $type   type of comment ('article', 'polls', ...)
* @return   string          Meta refresh or HTML for error message
*
*/
function CMT_sendReport($cid, $type)
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $LANG08;

    if (COM_isAnonUser()) {
        $retval = SEC_loginRequiredForm();
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[27]));

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

    $author = COM_getDisplayName ($A['uid']);
    if (($A['uid'] <= 1) && !empty ($A['ipaddress'])) {
        // add IP address for anonymous posters
        $author .= ' (' . $A['ipaddress'] . ')';
    }

    $mailbody = sprintf ($LANG03[26], $username);
    $mailbody .= "\n\n"
              . "$LANG03[16]: $title\n"
              . "$LANG03[5]: $author\n";

    if ($type != 'article') {
        $mailbody .= "$LANG09[5]: $type\n";
    }

    if ($_CONF['emailstorieslength'] > 0) {
        if ($_CONF['emailstorieslength'] > 1) {
            $comment = MBYTE_substr ($comment, 0, $_CONF['emailstorieslength'])
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

    if (COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody)) {
        $msg = 27; // message sent
    } else {
        $msg = 85; // problem sending the email
    }
    COM_updateSpeedlimit ('mail');

    return COM_refresh ($_CONF['site_url'] . "/index.php?msg=$msg");
}

/**
 * Handles a comment edit submission
 *
 * @copyright Jared Wenerd 2008
 * @author Jared Wenerd, wenerd87 AT gmail DOT com
 * @param  string $mode whether to store edited comment in the queue
 * @return string HTML (possibly a refresh)
 */
function CMT_handleEditSubmit($mode = null)
{
    global $_CONF, $_TABLES, $_USER, $LANG03;

    $display = '';

    $type = COM_applyFilter($_POST[CMT_TYPE]);
    $sid = COM_applyFilter($_POST[CMT_SID]);
    $cid = COM_applyFilter($_POST[CMT_CID]);
    $postmode = COM_applyFilter($_POST['postmode']);
    
    $commentuid = DB_getItem ($_TABLES['comments'], 'uid', "cid = '$cid'");
    if ( empty($_USER['uid'])) {
        $uid = 1;
    } else {
        $uid = $_USER['uid'];
    }
        
    // check for bad input
    if (empty($sid) || empty($_POST['title']) || empty($_POST['comment']) ||
            !is_numeric($cid) || ($cid < 1)) {
        COM_errorLog("CMT_handleEditSubmit(): {{$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
                   . 'to edit a comment with one or more missing values.');
        return COM_refresh($_CONF['site_url'] . '/index.php');
    } elseif ( $uid != $commentuid && !SEC_hasRights( 'comment.moderate' ) ) {
        //check permissions
        COM_errorLog("CMT_handleEditSubmit(): {{$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
                   . 'to edit a comment without proper permission.');
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }

    $comment = CMT_prepareText($_POST['comment'], $postmode, $type);
    $title = COM_checkWords (strip_tags (COM_stripslashes ($_POST['title'])));
    
    if ($mode == $LANG03[35]) {
        $table = $_TABLES['commentsubmissions'];
    } else {
        $table = $_TABLES['comments'];
    }
    
    if (!empty ($title) && !empty ($comment)) {
        COM_updateSpeedlimit ('comment');
        $title = addslashes ($title);
        $comment = addslashes ($comment);
  
        // save the comment into the table
        DB_query("UPDATE $table SET comment = '$comment', title = '$title', type = '$type'"
                . " WHERE cid=$cid AND sid='$sid'");
        
        if (DB_error() ) { //saving to non-existent comment or comment in wrong article
            COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
                       . 'to edit to a non-existent comment or the cid/sid did not match');
            return COM_refresh($_CONF['site_url'] . '/index.php');
        }
        //save edit information for published comment
        if ($mode != $LANG03[35]) {
            DB_save($_TABLES['commentedits'],'cid,uid,time',"$cid,$uid,NOW()");
        } else {
            return COM_refresh (COM_buildUrl ($_CONF['site_admin_url'] . "/moderation.php"));
        }
        
    } else {
        COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
                   . 'to submit a comment with invalid $title and/or $comment.');
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }

    list($plgurl, $plgid) = CMT_getCommentUrlId($type);
    $formurl = "$plgurl?$plgid=$sid";

    return COM_refresh($formurl);

}

/**
 * Filters comment text and appends necessary tags (sig and/or edit)
 *
 * @copyright Jared Wenerd 2008
 * @author Jared Wenerd, wenerd87 AT gmail DOT com
 * @param string  $comment  comment text
 * @param string  $postmode ('html', 'plaintext', ...)
 * @param string  $type     Type of item (article, polls, etc.)
 * @param boolean $edit     if true append edit tag
 * @param int     $cid      commentid if editing comment (for proper sig)
 * @return string of comment text
 */
function CMT_prepareText($comment, $postmode, $type, $edit = false, $cid = null)
{
    global $_USER, $_TABLES, $LANG03, $_CONF; 

    // Remove any autotags the user doesn't have permission to use
    $comment = PLG_replaceTags($comment, '', true);    
    
    if ($postmode == 'html') {
        $html_perm = ($type == 'article') ? 'story.edit' : "$type.edit";
        $comment = COM_checkWords(COM_checkHTML(COM_stripslashes($comment),
                                                $html_perm));
    } else {
    	// plaintext
        $comment = htmlspecialchars(COM_checkWords(COM_stripslashes($comment)));
        $newcomment = COM_makeClickableLinks ($comment);
        if (strcmp ($comment, $newcomment) != 0) {
            $comment = nl2br ($newcomment);
        }
    }
    
    if ($edit) {
        $comment .= '<div class="comment-edit">' . $LANG03[30] . ' '
                 . strftime($_CONF['date'], time()) . ' ' .$LANG03[31] .' ' 
                 . $_USER['username'] . '</div><!-- /COMMENTEDIT -->';
        $text = $comment;
        
    }
    
    if (empty ($_USER['uid'])) {
        $uid = 1;
    } elseif ($edit && is_numeric($cid) ){
        //if comment moderator
        $uid = DB_getItem ($_TABLES['comments'], 'uid', "cid = '$cid'");
    } else {
        $uid = $_USER['uid'];
    }
    
    $sig = '';
    if ($uid > 1) {
        $sig = DB_getItem ($_TABLES['users'], 'sig', "uid = '$uid'");
        if (!empty ($sig)) {
            $comment .= '<!-- COMMENTSIG --><div class="comment-sig">';
            if ( $postmode == 'html') {
                $comment .= '---<br' . XHTML . '>' . nl2br($sig);
            } else {
                $comment .=  '---' . LB . $sig;
            }
        $comment .= '</div><!-- /COMMENTSIG -->';
        }
    }
    
    return $comment;
}

/**
 * Disables comments for all stories where current time is past comment expire
 * time and enables comments for certain number of most recent stories.
 *
 * @copyright Jared Wenerd 2008
 * @author Jared Wenerd, wenerd87 AT gmail DOT com
 */
function CMT_updateCommentcodes()
{
    global $_CONF, $_TABLES;

    if ($_CONF['comment_close_rec_stories'] > 0) {
        $results = DB_query("SELECT sid FROM {$_TABLES['stories']} WHERE (date <= NOW()) AND (draft_flag = 0) ORDER BY date DESC LIMIT {$_CONF['comment_close_rec_stories']}");
        while ($A = DB_fetchArray($results)) {
            $allowedcomments[] = $A['sid'];
        }
        // update comment codes
        $sql = ' AND ';
        if (count($allowedcomments) > 1) {
            $sql .= "sid NOT IN ('" . implode("','", $allowedcomments) . "')";
        } else {
            $sql .= "sid <> '$sid'";
        }
        $sql = "UPDATE {$_TABLES['stories']} SET commentcode = 1 WHERE (commentcode = 0) AND (date < NOW()) AND (draft_flag = 0)" . $sql;
        DB_query($sql);
    }

    $sql = "UPDATE {$_TABLES['stories']} SET commentcode = 1 WHERE UNIX_TIMESTAMP(comment_expire) < UNIX_TIMESTAMP() AND UNIX_TIMESTAMP(comment_expire) <> 0";
    DB_query($sql);
}

/**
 * Rebuilds hierarchical data of comments after moderation using recursion.
 *
 * @copyright Jared Wenerd 2008
 * @author Jared Wenerd, wenerd87 AT gmail DOT com
 * @param  string $sid   id of object comment belongs to
 * @param  int    $pid   id of parent comment
 * @param  int    $left  id of left-hand successor
 * @return int           id of right-hand successor
 * @see    CMT_deleteComment
 *
 */
function CMT_rebuildTree($sid, $pid = 0, $left = 0)
{
    global $_TABLES;
    
    $right = $left + 1;
    $result = DB_query ("SELECT cid FROM {$_TABLES['comments']} WHERE sid = '$sid' AND pid = $pid ORDER BY date ASC");
    while (DB_numRows($result) != 0 && $A = DB_fetchArray ($result)) {
        $right = CMT_rebuildTree($sid, $A['cid'], $right);
        
    }
    if ($pid != 0) {
        DB_query ("UPDATE {$_TABLES['comments']} SET lft = $left, rht = $right WHERE cid = $pid");
    }
    
    return $right+1;
}

/**
 * Moves comment from submission table to comments table
 * 
 * @param   int   cid  comment id
 * @copyright Jared Wenerd 2008
 * @author Jared Wenerd, wenerd87 AT gmail DOT com
 * @param  string $cid comment id
 * @return string of story id 
 */
function CMT_approveModeration($cid)
{
    global $_CONF, $_TABLES;
    
    $result = DB_query("SELECT type, sid, date, title, comment, uid, name, pid, ipaddress FROM {$_TABLES['commentsubmissions']} WHERE cid = '$cid'");
    $A = DB_fetchArray($result);
    
    if ($A['pid'] > 0) {
        // get indent+1 of parent 
        $indent = DB_getItem($_TABLES['comments'], 'indent+1',
                             "cid = '{$A['pid']}'");
    } else {
        $indent = 0;
    }

    $A['title'] = addslashes($A['title']);
    $A['comment'] = addslashes($A['comment']);

    if (isset($A['name'])) {
        // insert data
        $A['name'] = addslashes($A['name']);
        DB_save($_TABLES['comments'], 'type,sid,date,title,comment,uid,name,pid,ipaddress,indent',
                        "'{$A['type']}','{$A['sid']}','{$A['date']}','{$A['title']}','{$A['comment']}','{$A['uid']}',".
                        "'{$A['name']}','{$A['pid']}','{$A['ipaddress']}',$indent");
    } else {
        // insert data, null automatically goes into name column
        DB_save($_TABLES['comments'], 'type,sid,date,title,comment,uid,pid,ipaddress,indent',
                        "'{$A['type']}','{$A['sid']}','{$A['date']}','{$A['title']}','{$A['comment']}','{$A['uid']}',".
                        "'{$A['pid']}','{$A['ipaddress']}',$indent");
    }
    $newcid = DB_insertId('','comments_cid_seq');

    DB_delete($_TABLES['commentsubmissions'], 'cid', $cid);

    DB_change($_TABLES['commentnotifications'], 'cid', $newcid, 'mid', $cid);

    // notify of new published comment
    if ($_CONF['allow_reply_notifications'] == 1 && $A['pid'] > 0) {
        $result = DB_query("SELECT cid, uid, deletehash FROM {$_TABLES['commentnotifications']} WHERE cid = {$A['pid']}");
        $B = DB_fetchArray($result);
        if ($B !== false) {
            CMT_sendReplyNotification($B);
        }
    }

    return $A['sid'];
}

/**
 * Sends a notification of new comment reply
 * 
 * @param  array    $A          contains cid, uid, and deletekey
 * @param  boolean  $send_self  send notification when replying to self?
 * @copyright Jared Wenerd 2008
 * @author Jared Wenerd, wenerd87 AT gmail DOT com
 */
function CMT_sendReplyNotification($A, $send_self = false)
{
    global $_CONF, $_TABLES, $_USER, $LANG03;

    if (($_USER['uid'] != $A['uid']) || $send_self) {

        $name = COM_getDisplayName($A['uid']);
        $title = DB_getItem($_TABLES['comments'], 'title', "cid = {$A['cid']}");
        $commenturl = $_CONF['site_url'] . '/comment.php';

        $mailsubject = $_CONF['site_name'] . ': ' . $LANG03[37];

        $mailbody  = sprintf($LANG03[41], $name) . LB . LB;
        $mailbody .= sprintf($LANG03[38], $title) . LB . LB;
        $mailbody .= $LANG03[39] . LB . '<' . $commenturl . '?mode=view&cid='
                  . $A['cid'] . '&format=nested' . '>' . LB . LB;
        $mailbody .= $LANG03[40] . LB . '<' . $commenturl
                  . '?mode=unsubscribe&key=' . $A['deletehash'] . '>' . LB;

        $email = DB_getItem($_TABLES['users'], 'email', "uid = {$A['uid']}");
        if (!empty($email)) {
            COM_mail($email, $mailsubject, $mailbody);
        }

    }
}

/**
 * Handles a comment submission
 *
 * @copyright Vincent Furia 2005
 * @author Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @return string HTML (possibly a refresh)
 */
function CMT_handleCancel()
{
    global $_CONF;
    
    $display = '';

    $type = COM_applyFilter($_POST[CMT_TYPE]);
    list($plgurl, $plgid) = CMT_getCommentUrlId($type);
    if ($plgurl == '') {
        $display = COM_refresh($_CONF['site_url'] . '/index.php');
    } else {
        $sid = COM_applyFilter($_POST[CMT_SID]);
        $display = COM_refresh("$plgurl?$plgid=$sid");
    }
    echo $display;
    exit;
}

/**
 * Handles a comment submission
 *
 * @copyright Vincent Furia 2005
 * @author Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @return string HTML (possibly a refresh)
 */
function CMT_handleSubmit($title, $sid, $pid, $type, $postmode, $uid)
{
    global $_CONF, $_TABLES, $LANG03;

    $display = '';

    $display = PLG_commentSave($type, $title, $_POST['comment'],
                               $sid, $pid, $postmode);
    if (!$display) {
        $display = COM_refresh($_CONF['site_url'] . '/index.php');
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
function CMT_handleDelete($sid, $type, $formtype)
{
    global $_CONF, $_TABLES;

    $display = '';

    $cid = COM_applyFilter($_REQUEST[CMT_CID], true);

    if ($formtype == 'editsubmission') {
        DB_delete($_TABLES['commentsubmissions'], 'cid', $cid);
        $display = COM_refresh($_CONF['site_admin_url'] . '/moderation.php');
    } else {
        $display = PLG_commentDelete($type, $cid, $sid);
        if (!$display) {
            $display = COM_refresh($_CONF['site_url'] . '/index.php');
        }
    }

    return $display;
}

/**
 * Handles a comment view request
 *
 * @copyright Vincent Furia 2005
 * @author Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param string  $format 'threaded', 'nested', or 'flat'
 * @param string  $order  'ASC' or 'DESC' or blank
 * @param int     $page   Page number of comments to display
 * @param boolean $view   View or display (true for view)
 * @return string HTML (possibly a refresh)
 */
function CMT_handleView($format, $order, $page, $view = true)
{
    global $_CONF, $_TABLES, $_USER;

    $display = '';

    if ($view) {
        $cid = COM_applyFilter ($_REQUEST[CMT_CID], true);
    } else {
        $cid = COM_applyFilter ($_REQUEST[CMT_PID], true);
    }

    if ($cid <= 0) {
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }

    $sql = "SELECT sid, title, type FROM {$_TABLES['comments']} WHERE cid = $cid";
    $A = DB_fetchArray( DB_query($sql) );
    $sid   = $A['sid'];
    $title = $A['title'];
    $type  = $A['type'];

    $display = PLG_displayComment($type, $sid, $cid, $title,
                                  $order, $format, $page, $view);
    if (!$display) {
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }
    
    $display = COM_showMessageFromParameter() . $display;
    $display = COM_createHTMLDocument($display, array('pagetitle' => $title));

    return $display;
}

/**
 * Handles a comment edit submission
 *
 * @copyright Jared Wenerd 2008
 * @author Jared Wenerd, wenerd87 AT gmail DOT com
 * @param  string  $mode   'edit' or 'editsubmission'
 * @param  string  $format 'threaded', 'nested', or 'flat'
 * @param  string  $order  'ASC' or 'DESC' or blank
 * @param  int     $page   Page number of comments to display
 * @return string HTML (possibly a refresh)
 */
function CMT_handleEdit($mode='', $postmode='', $format, $order, $page)
{
    global $_TABLES, $LANG03, $_CONF;
    
    //get needed data
    $cid = COM_applyFilter ($_REQUEST[CMT_CID]);
    if ($mode == 'editsubmission') {
        $table = $_TABLES['commentsubmissions'];
        $result = DB_query("SELECT type, sid FROM {$_TABLES['commentsubmissions']} WHERE cid = $cid");
        list($type, $sid) = DB_fetchArray($result);
    } else {
        $table = $_TABLES['comments'];
        $type = COM_applyFilter ($_REQUEST[CMT_TYPE]);

        if (COMMENT_ON_SAME_PAGE) {
            list($plgurl, $plgid) = CMT_getCommentUrlId($type);
            $sid = COM_applyFilter ($_REQUEST[$plgid]);
        } else {
            $sid = COM_applyFilter ($_REQUEST['sid']);
        }
    }

    // Filemgmt plugin is doing special processing.
    // Therefore, I support specially, against my better judgment.
    // May should delete this code part.
    if ($type == 'filemgmt') {
        $sid = 'fileid_' . $sid;
    }

    //check for bad data 
    if (!is_numeric ($cid) || ($cid < 0) || empty ($sid) || empty ($type)) {
        COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
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
        COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
               . 'to edit a comment that doesn\'t exist as described.');
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }

    return CMT_commentForm($title, $commenttext, $sid, $cid, $type, $mode, $postmode,
                           $format, $order, $page);
}

/**
 * Handles comment processing
 *
 * @param    string   $mode    Mode of comment processing
 * @param    string   $type    Type of item (article, polls, etc.)
 * @param    string   $title   Title of item
 * @param    string   $sid     ID for item to show comments for
 * @param    string   $format  'threaded', 'nested', or 'flat'
 * @return   string            HTML formated
 */
function CMT_handleComment($mode='', $type='', $title='', $sid='', $format='')
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $LANG_ADMIN, $topic, $_PLUGINS;

    $commentmode = '';
    if (!empty($_REQUEST[CMT_MODE])) {
        $commentmode = COM_applyFilter($_REQUEST[CMT_MODE]);
    }

    if (empty($mode)) {
        $mode = COM_applyFilter(COM_getArgument(CMT_MODE));
    }

    if (empty($commentmode) && !empty($mode)) {
        $commentmode = $mode;
    }

    if (empty($sid) && !empty($_REQUEST[CMT_SID])) {
        $sid = COM_applyFilter($_REQUEST[CMT_SID]);
    }

    $pid = 0;
    if (!empty($_REQUEST[CMT_PID])) {
        $pid = COM_applyFilter($_REQUEST[CMT_PID], true);
    }

    if (empty($type) && !empty($_REQUEST[CMT_TYPE])) {
        $type = COM_applyFilter($_REQUEST[CMT_TYPE]);
    }

    if (!empty($_REQUEST['title'])) {
        $title = COM_applyFilter($_REQUEST['title']);
    }

    if (!empty($_REQUEST[CMT_UID])) {
        $uid = COM_applyFilter($_REQUEST[CMT_UID]);
    } else {
        $uid = 1;
        if (!empty($_USER['uid'])) {
            $uid = $_USER['uid'];
        }
    }

    $postmode = $_CONF['postmode'];
    if (isset($_REQUEST['postmode'])) {
        $postmode = COM_applyFilter($_REQUEST['postmode']);
    }

    $formtype = '';
    if (!empty($_REQUEST['formtype'])) {
        $formtype = COM_applyFilter($_REQUEST['formtype']);
    }

    // Get comment id, may not be there...will handle in function
    $cid = '';
    if (isset($_REQUEST[CMT_CID])) {
        $cid = COM_applyFilter($_REQUEST[CMT_CID]);
    }
    TOPIC_getTopic('comment', $cid);

    if(empty($format) && isset( $_REQUEST['format'] )) {
        $format = COM_applyFilter( $_REQUEST['format'] );
    }
    if (!in_array($format, array('threaded', 'nested', 'flat', 'nocomment'))) {
        if (COM_isAnonUser()) {
            $format = $_CONF['comment_mode'];
        } else {
            $format = DB_getItem( $_TABLES['usercomment'], 'commentmode', 
                                  "uid = {$_USER['uid']}" );
        }
    }

    $order = '';
    if (isset($_REQUEST['order'])) {
        $order = COM_applyFilter($_REQUEST['order']);
    }

    $cpage = 1;
    if (!empty($_REQUEST['cpage'])) {
        $cpage = COM_applyFilter($_REQUEST['cpage'], true);
        if (empty($cpage)) $cpage = 1;
    }

    $is_comment_page = CMT_isCommentPage();

    $retval = '';

    if ($_CONF['show_comments_at_replying'] && $is_comment_page && !empty($sid) && !empty($type)
        && in_array($commentmode, array('', $LANG03[28], $LANG03[34], $LANG03[14], 'edit'))) {
        if ($commentmode == 'edit') {
            $cid = COM_applyFilter ($_REQUEST[CMT_CID]);
            if (!is_numeric ($cid) || ($cid < 0)) {
                COM_errorLog("CMT_handleComment(): {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried "
                       . 'to edit a comment with one or more missing/bad values.');
                return COM_refresh($_CONF['site_url'] . '/index.php');
            }
            $pid = $cid;
        }
        if (($pid > 0) && empty($title)) {
            $atype = addslashes($type);
            $title = DB_getItem($_TABLES['comments'], 'title',
                                "(cid = $pid) AND (type = '$atype')");
        }
        if (empty($title)) {
            $title = PLG_getItemInfo($type, $sid, 'title');
            $title = str_replace ( '$', '&#36;', $title );
            // CMT_userComments expects non-htmlspecial chars for title...
            $title = str_replace ( '&amp;', '&', $title );
            $title = str_replace ( '&quot;', '"', $title );
            $title = str_replace ( '&lt;', '<', $title );
            $title = str_replace ( '&gt;', '>', $title );
        }
        $retval .= CMT_userComments($sid, $title, $type, $order, $format, $pid, $cpage, ($pid > 0), false, 0);
    }

    switch ($commentmode) {

        case $LANG03[28]: // Preview Changes (for edit)
        case $LANG03[34]: // Preview Submission changes (for edit)
        case $LANG03[14]: // Preview
            $retval .= CMT_commentForm ($title, $_POST['comment'],
                            $sid, $pid, $type, $commentmode, $postmode,
                            $format, $order, $cpage);
            if ($is_comment_page) {
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[14]));
            }
            break;

        case $LANG03[35]: // Submit Changes to Moderation table
        case $LANG03[29]: // Submit Changes
            if (SEC_checkToken()) {
                $retval .= CMT_handleEditSubmit($commentmode);
            } else {
                echo COM_refresh($_CONF['site_url'] . '/index.php');
                exit;
            }
            break;

        case $LANG03[11]: // Submit comment
            $retval .= CMT_handleSubmit($title, $sid, $pid, $type, $postmode, $uid);
            break;

        case $LANG_ADMIN['delete']:
        case 'delete': // Delete comment
            if (SEC_checkToken()) {
                $retval .= CMT_handleDelete($sid, $type, $formtype);
            } else {
                echo COM_refresh($_CONF['site_url'] . '/index.php');
                exit;
            }
            break;

        case 'view': // View comment by $cid
            $retval .= CMT_handleView($format, $order, $cpage, true);
            break;

        case 'display': // View comment by $pid
            $retval .= CMT_handleView($format, $order, $cpage, false);
            break;

        case 'report':
            if ($is_comment_page) {
                $retval .= CMT_reportAbusiveComment(COM_applyFilter($_GET[CMT_CID], true),
                                                    COM_applyFilter($_GET[CMT_TYPE]));
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[27]));
            }
            break;

        case 'sendreport':
            if (SEC_checkToken()) {
                $retval .= CMT_sendReport(COM_applyFilter($_POST[CMT_CID], true),
                                          COM_applyFilter($_POST[CMT_TYPE]));
            } else {
                echo COM_refresh($_CONF['site_url'] . '/index.php');
                exit;
            }
            break;

        case 'editsubmission':
            if (!SEC_hasRights('comment.moderate')) {
                echo COM_refresh($_CONF['site_url'] . '/index.php');
                exit;
            }
            // deliberate fall-through
        case 'edit':
            $retval .= CMT_handleEdit($commentmode, $postmode, $format, $order, $page);
            if ($is_comment_page) {
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
            }
            break;

        case 'unsubscribe':
            $cid = 0;
            $key = COM_applyFilter($_GET['key']);
            if (!empty($key)) {
                $key = addslashes($key);
                $cid = DB_getItem($_TABLES['commentnotifications'], 'cid',
                                  "deletehash = '$key'");

                if (!empty($cid)) {
                    $redirecturl = $_CONF['site_url']
                                 . '/comment.php?mode=view&amp;cid=' . $cid
                                 . '&amp;format=nested&amp;msg=16';
                    DB_delete($_TABLES['commentnotifications'], 'deletehash', $key,
                              $redirecturl);
                    exit;
                }
            }
            echo COM_refresh($_CONF['site_url'] . '/index.php');
            exit;
            break;

        case $LANG_ADMIN['cancel']:
            if ($formtype == 'editsubmission') {
                echo COM_refresh($_CONF['site_admin_url'] . '/moderation.php');
                exit;
            } else {
                $retval .= CMT_handleCancel();  // moved to function for readibility
            }
            break;

        default: // New Comment or Reply Comment

            $abort = false;
            // Check to make sure comment type exists
            if ($type != 'article' && !in_array($type, $_PLUGINS)) {
                $abort = true;
            }
            
            // Check article permissions
            if (!$abort && ($type == 'article') && !empty($sid)) {
                $dbTitle = DB_getItem($_TABLES['stories'], 'title',
                            "(sid = '$sid') AND (draft_flag = 0) AND (date <= NOW()) AND (commentcode = 0)"
                            . COM_getPermSQL('AND'));

                // if ($dbTitle === null || TOPIC_hasMultiTopicAccess('article', $sid) < 2) { // Make sure have at least read access to topics to post comment
                if ($dbTitle === null || TOPIC_hasMultiTopicAccess('article', $sid, $topic) < 2) { // Make sure have at least read access to current topic of article to post comment
                    // no permissions, or no story of that title
                    $abort = true;
                }
            }

            if (!$abort && !empty($sid) && !empty($type)) {
                if (($pid > 0) && empty($title)) {
                    $atype = addslashes($type);
                    $title = DB_getItem($_TABLES['comments'], 'title',
                                        "(cid = $pid) AND (type = '$atype')");
                }
                if (empty($title)) {
                    $title = PLG_getItemInfo($type, $sid, 'title');
                    
                    // Check title, if for some reason blank assume no access allowed to plugin item (therefore cannot add comment) so return to homepage
                    if (is_array($title) || empty($title) || ($title == false)) {
                        echo COM_refresh($_CONF['site_url'] . '/index.php');
                        exit;
                    }
                    $title = str_replace ( '$', '&#36;', $title );
                    // CMT_commentForm expects non-htmlspecial chars for title...
                    $title = str_replace ( '&amp;', '&', $title );
                    $title = str_replace ( '&quot;', '"', $title );
                    $title = str_replace ( '&lt;', '<', $title );
                    $title = str_replace ( '&gt;', '>', $title );
                }
                $retval .= CMT_commentForm ($title, '', $sid, $pid, $type, $commentmode,
                                            $postmode, $format, $order, $cpage);
            } else {
                echo COM_refresh($_CONF['site_url'] . '/index.php');
                exit;
            }
            if ($is_comment_page) {
                $noindex = '<meta name="robots" content="noindex"' . XHTML . '>';
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1], 'headercode' => $noindex));
            }
            break;
    }

    return $retval;
}

/**
 * Check if we're on Geeklog's comment page
 *
 * @return boolean  true: on comment page, false: on other page
 */
function CMT_isCommentPage()
{
    static $result;

    if (!isset($result)) {
        $parts = explode('/', $_SERVER['PHP_SELF']);
        $page = array_pop($parts);
        $result = ($page == 'comment.php');
    }

    return $result;
}

/**
 * Get view URL and name of unique identifier
 *
 * @param   string   $type   Plugin to delete comment
 * @return  array    string of URL of view page, name of unique identifier
 * @see     function PLG_getCommentUrlId
 */
function CMT_getCommentUrlId($type)
{
    global $_CONF;

    if ($type == 'article') {
        $retval[0] = COM_buildUrl($_CONF['site_url'] . '/article.php');
        $retval[1] = 'story';
    } else {
        $retval = PLG_getCommentUrlId($type);
    }

    return $retval;
}

/**
 * article: saves a comment
 *
 * @param   string  $title  comment title
 * @param   string  $comment comment text
 * @param   string  $id     Item id to which $cid belongs
 * @param   int     $pid    comment parent
 * @param   string  $postmode 'html' or 'text'
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_savecomment_article($title, $comment, $id, $pid, $postmode)
{
    global $_CONF, $_TABLES, $LANG03, $_USER;

    $retval = '';

    $commentcode = DB_getItem($_TABLES['stories'], 'commentcode',
                "(sid = '$id') AND (draft_flag = 0) AND (date <= NOW())"
                . COM_getPermSQL('AND'));
    if (!isset($commentcode) || ($commentcode != 0 || TOPIC_hasMultiTopicAccess('article', $id) < 2)) { // Need read access of topics to post comment
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }

    $ret = CMT_saveComment($title, $comment, $id, $pid, 'article', $postmode);
    if ($ret == -1) {
        $url = COM_buildUrl($_CONF['site_url'] . '/article.php?story=' . $id);
        $url .= (strpos($url, '?') ? '&' : '?') . 'msg=15';
        $retval = COM_refresh($url);
    } elseif ($ret > 0) { // failure
        // FIXME: some failures should not return to comment form
        $retval .= CMT_commentForm($title, $comment, $id, $pid, 'article',
                                  $LANG03[14], $postmode);
        $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
    } else { // success
        $comments = DB_count($_TABLES['comments'], array('type', 'sid'), array('article', $id));
        DB_change($_TABLES['stories'], 'comments', $comments, 'sid', $id);
        COM_olderStuff(); // update comment count in Older Stories block
        $retval = COM_refresh(COM_buildUrl($_CONF['site_url']
                              . "/article.php?story=$id"));
    }

    return $retval;
}

/**
 * article: delete a comment
 *
 * @param   int     $cid    Comment to be deleted
 * @param   string  $id     Item id to which $cid belongs
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_deletecomment_article($cid, $id)
{
    global $_CONF, $_TABLES, $_USER;

    $retval = '';

    $has_editPermissions = SEC_hasRights ('story.edit');
    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon "
                      . "FROM {$_TABLES['stories']} WHERE sid = '$id'");
    $A = DB_fetchArray ($result);

    if ($has_editPermissions && SEC_hasAccess ($A['owner_id'],
            $A['group_id'], $A['perm_owner'], $A['perm_group'],
            $A['perm_members'], $A['perm_anon']) == 3) {
        CMT_deleteComment($cid, $id, 'article');
        $comments = DB_count ($_TABLES['comments'], 'sid', $id);
        DB_change ($_TABLES['stories'], 'comments', $comments, 'sid', $id);
        $retval .= COM_refresh(COM_buildUrl($_CONF['site_url']
                 . "/article.php?story=$id") . '#comments');
    } else {
        COM_errorLog ("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) "
                    . "tried to illegally delete comment $cid from $type $id");
        $retval .= COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    return $retval;
}

/**
 * article: display [a] comment[s]
 *
 * @param   string  $id     Unique idenifier for item comment belongs to
 * @param   int     $cid    Comment id to display (possibly including sub-comments)
 * @param   string  $title  Page/comment title
 * @param   string  $order  'ASC' or 'DESC' or blank
 * @param   string  $format 'threaded', 'nested', or 'flat'
 * @param   int     $page   Page number of comments to display
 * @param   boolean $view   True to view comment (by cid), false to display (by $pid)
 * @return  mixed   results of calling the plugin_displaycomment_ function
*/
function plugin_displaycomment_article($id, $cid, $title, $order, $format, $page, $view)
{
    global $_TABLES, $LANG_ACCESS;

    $retval = '';

    $sql = 'SELECT COUNT(*) AS count, commentcode, owner_id, group_id, perm_owner, perm_group, '
         . "perm_members, perm_anon FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta WHERE (sid = '$id') "
         . 'AND (draft_flag = 0) AND (commentcode >= 0) AND (date <= NOW()) AND ta.type = "article" AND ta.id = sid ' . COM_getPermSQL('AND') 
         . COM_getTopicSQL('AND', 0, 'ta') . ' GROUP BY sid, owner_id, group_id, perm_owner, perm_group,perm_members, perm_anon ';
    $result = DB_query ($sql);
    $A = DB_fetchArray ($result);
    $allowed = $A['count'];

    if ($allowed > 0) { // Was equal 1 but when multiple topics in play the comment could belong to more than onetopic creating a higher count
        $delete_option = (SEC_hasRights('story.edit') &&
            (SEC_hasAccess($A['owner_id'], $A['group_id'],
                $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                $A['perm_anon']) == 3));
        $retval .= CMT_userComments ($id, $title, 'article', $order,
                       $format, $cid, $page, $view, $delete_option,
                       $A['commentcode']);
    } else {
        $retval .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                           COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG_ACCESS['storydenialmsg']
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    return $retval;
}
?>
