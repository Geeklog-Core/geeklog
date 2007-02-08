<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | lib-comment.php                                                           |
// |                                                                           |
// | Geeklog comment library.                                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Vincent Furia     - vinny01 AT users DOT sourceforge DOT net     |
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
// $Id: lib-comment.php,v 1.53 2007/02/08 06:38:15 ospiess Exp $

if (strpos ($_SERVER['PHP_SELF'], 'lib-comment.php') !== false) {
    die ('This file can not be used on its own!');
}

if( $_CONF['allow_user_photo'] )
{
    // only needed for the USER_getPhoto function
    require_once ($_CONF['path_system'] . 'lib-user.php');
}

/**
* This function displays the comment control bar
*
* Prints the control that allows the user to interact with Geeklog Comments
*
* @param    string  $sid    ID of item in question
* @param    string  $title  Title of item
* @param    string  $type   Type of item (i.e. story, photo, etc)
* @param    string  $order  Order that comments are displayed in
* @param    string  $mode   Mode (nested, flat, etc.)
* @param    int     $ccode  Comment code: -1=no comments, 0=allowed, 1=closed
* @return   string          HTML Formated comment bar
* @see CMT_userComments
* @see CMT_commentChildren
*
*/
function CMT_commentBar( $sid, $title, $type, $order, $mode, $ccode = 0 )
{
    global $_CONF, $_TABLES, $_USER, $LANG01;

    $parts = explode( '/', $_SERVER['PHP_SELF'] );
    $page = array_pop( $parts );
    $nrows = DB_count( $_TABLES['comments'], array( 'sid', 'type' ),
                       array( $sid, $type ));

    $commentbar = new Template( $_CONF['path_layout'] . 'comment' );
    $commentbar->set_file( array( 'commentbar' => 'commentbar.thtml' ));
    $commentbar->set_var( 'site_url', $_CONF['site_url'] );
    $commentbar->set_var( 'layout_url', $_CONF['layout_url'] );

    $commentbar->set_var( 'lang_comments', $LANG01[3] );
    $commentbar->set_var( 'lang_refresh', $LANG01[39] );
    $commentbar->set_var( 'lang_reply', $LANG01[60] );
    $commentbar->set_var( 'lang_disclaimer', $LANG01[26] );

    if( $ccode == 0 ) {
        $commentbar->set_var( 'reply_hidden_or_submit', 'submit' );
    } else {
        $commentbar->set_var( 'reply_hidden_or_submit', 'hidden' );
    }
    $commentbar->set_var( 'story_title', stripslashes( $title ));
    $commentbar->set_var( 'num_comments', COM_numberFormat( $nrows ));
    $commentbar->set_var( 'comment_type', $type );
    $commentbar->set_Var( 'sid', $sid );

    if( $type == 'article' ) {
        $articleUrl = COM_buildUrl( $_CONF['site_url']
                                    . "/article.php?story=$sid" );
        $commentbar->set_var( 'story_link', $articleUrl );
        $commentbar->set_var( 'article_url', $articleUrl );

        if( $page == 'comment.php' ) {
            $commentbar->set_var( 'start_storylink_anchortag',
                COM_createLink(
                    stripslashes( $title ),
                    $articleUrl,
                    array('class'=>'non-ul b')
                )
            );
        }
    } else { // for a plugin
        // Link to plugin defined link or lacking that a generic link that the plugin should support (hopefully)
        list($plgurl, $plgid) = PLG_getCommentUrlId($type);
        $commentbar->set_var( 'story_link', "$plgurl?$plgid=$sid" );
    }

    if( !empty( $_USER['uid'] ) && ( $_USER['uid'] > 1 )) {
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

    if( !empty( $_USER['username'] )) {
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

    if( $page == 'comment.php' ) {
        $commentbar->set_var( 'parent_url',
                              $_CONF['site_url'] . '/comment.php' );
        $hidden = '';
        if( $_REQUEST['mode'] == 'view' ) {
            $hidden .= '<input type="hidden" name="cid" value="' . $_REQUEST['cid'] . '">';
            $hidden .= '<input type="hidden" name="pid" value="' . $_REQUEST['cid'] . '">';
        }
        else if( $_REQUEST['mode'] == 'display' ) {
            $hidden .= '<input type="hidden" name="pid" value="' . $_REQUEST['pid'] . '">';
        }
        $commentbar->set_var( 'hidden_field', $hidden .
                '<input type="hidden" name="mode" value="' . $_REQUEST['mode'] . '">' );
    } else if( $type == 'article' ) {
        $commentbar->set_var( 'parent_url',
                              $_CONF['site_url'] . '/article.php' );
        $commentbar->set_var( 'hidden_field',
                '<input type="hidden" name="story" value="' . $sid . '">' );
    } else { // plugin
        // Link to plugin defined link or lacking that a generic link that the plugin should support (hopefully)
        list($plgurl, $plgid) = PLG_getCommentUrlId($type);
        $commentbar->set_var( 'parent_url', $plgurl );
        $commentbar->set_var( 'hidden_field',
                '<input type="hidden" name="' . $plgid . '" value="' . $sid . '">' );
    }

    // Order
    $selector = '<select name="order">' . LB
              . COM_optionList( $_TABLES['sortcodes'], 'code,name', $order )
              . LB . '</select>';
    $commentbar->set_var( 'order_selector', $selector);

    // Mode
    if( $page == 'comment.php' ) {
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
* @param    string   $type      Type of item (article, poll, etc.)
* @param    string   $order     How to order the comments 'ASC' or 'DESC'
* @param    boolean  $delete_option   if current user can delete comments
* @param    boolean  $preview   Preview display (for edit) or not
* @param    int      $ccode     Comment code: -1=no comments, 0=allowed, 1=closed
* @return   string   HTML       Formated Comment
*
*/
function CMT_getComment( &$comments, $mode, $type, $order, $delete_option = false, $preview = false, $ccode = 0 )
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $MESSAGE, $_IMAGE_TYPE;

    $indent = 0;  // begin with 0 indent
    $retval = ''; // initialize return value

    $template = new Template( $_CONF['path_layout'] . 'comment' );
    $template->set_file( array( 'comment' => 'comment.thtml',
                                'thread'  => 'thread.thtml'  ));

    // generic template variables
    $template->set_var( 'site_url', $_CONF['site_url'] );
    $template->set_var( 'layout_url', $_CONF['layout_url'] );
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
    if( !isset( $_CONF['comment_indent'] )) {
        $_CONF['comment_indent'] = 25;
    }

    if( $preview ) {
        $A = $comments;
        if( empty( $A['nice_date'] )) {
            $A['nice_date'] = time();
        }
        if( !isset( $A['cid'] )) {
            $A['cid'] = 0;
        }
        if( !isset( $A['photo'] )) {
            if( isset( $_USER['photo'] )) {
                $A['photo'] = $_USER['photo'];
            } else {
                $A['photo'] = '';
            }
        }
        $mode = 'flat';
    } else {
        $A = DB_fetchArray( $comments );
    }

    if( empty( $A ) ) {
        return '';
    }

    $row = 1;
    do {
        // determines indentation for current comment
        if( $mode == 'threaded' || $mode == 'nested' ) {
            $indent = ($A['indent'] - $A['pindent']) * $_CONF['comment_indent'];
        }

        // comment variables
        $template->set_var( 'indent', $indent );
        $template->set_var( 'author_name', $A['username'] );
        $template->set_var( 'author_id', $A['uid'] );
        $template->set_var( 'cid', $A['cid'] );
        $template->set_var( 'cssid', $row % 2 );

        if( $A['uid'] > 1 ) {
            $fullname = COM_getDisplayName( $A['uid'], $A['username'],
                                            $A['fullname'] );
            $template->set_var( 'author_fullname', $fullname );
            $template->set_var( 'author', $fullname );
            $alttext = $fullname;

            $photo = '';
            if( $_CONF['allow_user_photo'] ) {
                if (isset ($A['photo']) && empty ($A['photo'])) {
                    $A['photo'] = '(none)';
                }
                $photo = USER_getPhoto( $A['uid'], $A['photo'], $A['email'] );
            }
            if( !empty( $photo )) {
                $template->set_var( 'author_photo', $photo );
                $camera_icon = '<img src="' . $_CONF['layout_url']
                    . '/images/smallcamera.' . $_IMAGE_TYPE . '" alt="">';
                $template->set_var( 'camera_icon',
                    COM_createLink(
                        $camera_icon,
                        $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['uid']
                    )
                );
            } else {
                $template->set_var( 'author_photo', '' );
                $template->set_var( 'camera_icon', '' );
            }

            $template->set_var( 'start_author_anchortag',
                COM_createLink(
                    $A['username'],
                    $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['uid']
                )
            );
            $template->set_var( 'end_author_anchortag', '</a>' );
        } else {
            $template->set_var( 'author', $A['username'] );
            $template->set_var( 'author_fullname', $A['username'] );
            $template->set_var( 'author_photo', '' );
            $template->set_var( 'camera_icon', '' );
            $template->set_var( 'start_author_anchortag', '' );
            $template->set_var( 'end_author_anchortag', '' );
        }

        // hide reply link from anonymous users if they can't post replies
        $hidefromanon = false;
        if( empty( $_USER['username'] ) && (( $_CONF['loginrequired'] == 1 )
                || ( $_CONF['commentsloginrequired'] == 1 ))) {
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
            $result = DB_query( "SELECT title,pid FROM {$_TABLES['comments']} WHERE cid = '{$A['pid']}'" );
            $P = DB_fetchArray( $result );
            if( $P['pid'] != 0 ) {
                $plink = $_CONF['site_url'] . '/comment.php?mode=display&amp;sid='
                       . $A['sid'] . '&amp;title=' . urlencode( htmlspecialchars( $P['title'] ))
                       . '&amp;type=' . $type . '&amp;order=' . $order . '&amp;pid='
                       . $P['pid'] . '&amp;format=threaded';
            } else {
                $plink = $_CONF['site_url'] . '/comment.php?mode=view&amp;sid='
                       . $A['sid'] . '&amp;title=' . urlencode( htmlspecialchars( $P['title'] ))
                       . '&amp;type=' . $type . '&amp;order=' . $order . '&amp;cid='
                       . $A['pid'] . '&amp;format=threaded';
            }
            $template->set_var( 'parent_link', COM_createLink($LANG01[44], $plink));
        } else {
            $template->set_var( 'parent_link', '');
        }

        $template->set_var( 'date', strftime( $_CONF['date'], $A['nice_date'] ));
        $template->set_var( 'sid', $A['sid'] );
        $template->set_var( 'type', $A['type'] );

        // If deletion is allowed, displays delete link
        if( $delete_option ) {
            $dellink = $_CONF['site_url'] . '/comment.php?mode=delete&amp;cid='
                . $A['cid'] . '&amp;sid=' . $A['sid'] . '&amp;type=' . $type;
            $delattr = array('onclick' => "return confirm('{$MESSAGE[76]}');");
            $deloption = COM_createLink( $LANG01[28], $dellink, $delattr) . ' | ';
            if( !empty( $A['ipaddress'] )) {
                if( empty( $_CONF['ip_lookup'] )) {
                    $deloption .= $A['ipaddress'] . '  | ';
                } else {
                    $iplookup = str_replace( '*', $A['ipaddress'], $_CONF['ip_lookup'] );
                    $deloption .= COM_createLink($A['ipaddress'], $iplookup) . ' | ';
                }
            }
            $template->set_var( 'delete_option', $deloption );
        } else if( !empty( $_USER['username'] )) {
            $reportthis_link = $_CONF['site_url']
                . '/comment.php?mode=report&amp;cid=' . $A['cid']
                . '&amp;type=' . $type;
            $report_attr = array('title' => $LANG01[110]);
            $reportthis = COM_createLink($LANG01[109], $reportthis_link, $report_attr) . ' | ';
            $template->set_var( 'delete_option', $reportthis );
        } else {
            $template->set_var( 'delete_option', '' );
        }

        // and finally: format the actual text of the comment
        if( preg_match( '/<.*>/', $A['comment'] ) == 0 ) {
            $A['comment'] = nl2br( $A['comment'] );
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
        if( $ccode == 0 ) {
            $reply_link = $_CONF['site_url'] . '/comment.php?sid=' . $A['sid']
                        . '&amp;pid=' . $A['cid'] . '&amp;title='
                        . urlencode( $A['title'] ) . '&amp;type=' . $A['type'];
            $reply_option = COM_createLink($LANG01[43], $reply_link ) . ' | ';
            $template->set_var( 'reply_option', $reply_option );
        } else {
            $template->set_var( 'reply_option', '' );
        }
        $template->set_var( 'reply_link', $reply_link );

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
    } while( $A = DB_fetchArray( $comments ));

    return $retval;
}

/**
* This function displays the comments in a high level format.
*
* Begins displaying user comments for an item
*
* @param    string      $sid       ID for item to show comments for
* @param    string      $title     Title of item
* @param    string      $type      Type of item (article, poll, etc.)
* @param    string      $order     How to order the comments 'ASC' or 'DESC'
* @param    string      $mode      comment mode (nested, flat, etc.)
* @param    int         $pid       id of parent comment
* @param    int         $page      page number of comments to display
* @param    boolean     $cid       true if $pid should be interpreted as a cid instead
* @param    boolean     $delete_option   if current user can delete comments
* @param    int         $ccode     Comment code: -1=no comments, 0=allowed, 1=closed
* @return   string  HTML Formated Comments
* @see function CMT_commentBar
* @see function CMT_commentChildren
*
*/
function CMT_userComments( $sid, $title, $type='article', $order='', $mode='', $pid = 0, $page = 1, $cid = false, $delete_option = false, $ccode = 0 )
{
    global $_CONF, $_TABLES, $_USER, $LANG01;

    if( !empty( $_USER['uid'] ) ) {
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

    $template = new Template( $_CONF['path_layout'] . 'comment' );
    $template->set_file( array( 'commentarea' => 'startcomment.thtml' ));
    $template->set_var( 'site_url', $_CONF['site_url'] );
    $template->set_var( 'layout_url', $_CONF['layout_url'] );
    $template->set_var( 'commentbar',
            CMT_commentBar( $sid, $title, $type, $order, $mode, $ccode ));
    $template->set_var( 'sid', $sid );
    $template->set_var( 'comment_type', $type );

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
                                        $delete_option, false, $ccode );

        // Pagination
        $tot_pages =  ceil( $count / $limit );
        $pLink = $_CONF['site_url'] . "/article.php?story=$sid&amp;type=$type&amp;order=$order&amp;mode=$mode";
        $template->set_var( 'pagenav',
                         COM_printPageNavigation($pLink, $page, $tot_pages));

        $template->set_var( 'comments', $thecomments );
        $retval = $template->parse( 'output', 'commentarea' );
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
* @return   string  HTML for comment form
*
*/
function CMT_commentForm($title,$comment,$sid,$pid='0',$type,$mode,$postmode)
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $LANG12, $LANG_LOGIN;

    $retval = '';

    // never trust $uid ...
    if (empty ($_USER['uid'])) {
        $uid = 1;
    } else {
        $uid = $_USER['uid'];
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

            if (($_CONF['advanced_editor'] == 1) && file_exists ($_CONF['path_layout'] . 'comment/commentform_advanced.thtml')) {
                $postmode = 'html';
            } elseif (empty ($postmode)) {
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

            $fakepostmode = $postmode;
            if ($postmode == 'html') {
                $comment = COM_checkWords (COM_checkHTML  (COM_stripslashes ($comment)));
            } else {
                $comment = htmlspecialchars (COM_checkWords (COM_stripslashes ($comment)));
                $newcomment = COM_makeClickableLinks ($comment);
                if (strcmp ($comment, $newcomment) != 0) {
                    $comment = nl2br ($newcomment);
                    $fakepostmode = 'html';
                }
            }
            // Replace $, {, and } with special HTML equivalents
            $commenttext = str_replace('$','&#36;',$commenttext);
            $commenttext = str_replace('{','&#123;',$commenttext);
            $commenttext = str_replace('}','&#125;',$commenttext);

            $title = COM_checkWords (strip_tags (COM_stripslashes ($title)));
            // $title = str_replace('$','&#36;',$title); done in CMT_getComment

            $_POST['title'] = $title;
            $newcomment = $comment;
            if (!empty ($sig)) {
                if (($postmode == 'html') || ($fakepostmode == 'html')) {
                    $newcomment .= '<p>---<br>' . nl2br ($sig);
                } else {
                    $newcomment .= LB . LB . '---' . LB . $sig;
                }
            }
            $_POST['comment'] = $newcomment;

            // Preview mode:
            if ($mode == $LANG03[14] && !empty($title) && !empty($comment) ) {
                $start = new Template( $_CONF['path_layout'] . 'comment' );
                $start->set_file( array( 'comment' => 'startcomment.thtml' ));
                $start->set_var( 'site_url', $_CONF['site_url'] );
                $start->set_var( 'layout_url', $_CONF['layout_url'] );
                $start->set_var( 'hide_if_preview', 'style="display:none"' );

                // Clean up all the vars
                $A = array();
                foreach ($_POST as $key => $value) {
                    if (($key == 'pid') || ($key == 'cid')) {
                        $A[$key] = COM_applyFilter ($_POST[$key], true);
                    } else if (($key == 'title') || ($key == 'comment')) {
                        // these have already been filtered above
                        $A[$key] = $_POST[$key];
                    } else {
                        $A[$key] = COM_applyFilter ($_POST[$key]);
                    }
                }

                if (empty ($A['username'])) {
                    $A['username'] = DB_getItem ($_TABLES['users'], 'username',
                                                 "uid = $uid");
                }
                $thecomments = CMT_getComment ($A, 'flat', $type, 'ASC', false,
                                               true);

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
                PLG_templateSetVars ('comment', $comment_template);
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
 * @author   Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @param    string      $title      Title of comment
 * @param    string      $comment    Text of comment
 * @param    string      $sid        ID of object receiving comment
 * @param    int         $pid        ID of parent comment
 * @param    string      $type       Type of comment this is (article, polls, etc)
 * @param    string      $postmode   Indicates if text is HTML or plain text
 * @return   int         0 for success, > 0 indicates error
 *
 */
function CMT_saveComment ($title, $comment, $sid, $pid, $type, $postmode)
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
        // update speed limit nonetheless
        COM_updateSpeedlimit ('comment');

        // then tell them to get lost ...
        COM_displayMessageAndAbort ($result, 'spamx', 403, 'Forbidden');
    }

    // Let plugins have a chance to decide what to do before saving the comment, return errors.
    if ($someError = PLG_commentPreSave($uid, $title, $comment, $sid, $pid, $type, $postmode)) {
        return $someError;
    }

    // Clean 'em up a bit!
    if ($postmode == 'html') {
        $comment = COM_checkWords (COM_checkHTML (COM_stripslashes ($comment)));
    } else {
        $comment = htmlspecialchars (COM_checkWords (COM_stripslashes ($comment)));
        $newcomment = COM_makeClickableLinks ($comment);
        if (strcmp ($comment, $newcomment) != 0) {
            $comment = nl2br ($newcomment);
            $postmode = 'html';
        }
    }
    $title = COM_checkWords (strip_tags (COM_stripslashes ($title)));

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

    // check for non-int pid's
    // this should just create a top level comment that is a reply to the original item
    if (!is_numeric($pid) || ($pid < 0)) {
        $pid = 0;
    }

    if (!empty ($title) && !empty ($comment)) {
        COM_updateSpeedlimit ('comment');
        $title = addslashes ($title);
        $comment = addslashes ($comment);

        // Insert the comment into the comment table
        DB_lockTable ($_TABLES['comments']);
        if ($pid > 0) {
            $result = DB_query("SELECT rht, indent FROM {$_TABLES['comments']} WHERE cid = $pid "
                             . "AND sid = '$sid'");
            list($rht, $indent) = DB_fetchArray($result);
            if ( !DB_error() ) {
                DB_query("UPDATE {$_TABLES['comments']} SET lft = lft + 2 "
                       . "WHERE sid = '$sid' AND type = '$type' AND lft >= $rht");
                DB_query("UPDATE {$_TABLES['comments']} SET rht = rht + 2 "
                       . "WHERE sid = '$sid' AND type = '$type' AND rht >= $rht");
                DB_save ($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,ipaddress',
                        "'$sid',$uid,'$comment',now(),'$title',$pid,$rht,$rht+1,$indent+1,'$type','{$_SERVER['REMOTE_ADDR']}'");
            } else { //replying to non-existent comment or comment in wrong article
                COM_errorLog("CMT_saveComment: $uid from {$_SERVER['REMOTE_ADDR']} tried "
                           . 'to reply to a non-existent comment or the pid/sid did not match');
                $ret = 4; // Cannot return here, tables locked!
            }
        } else {
            $rht = DB_getItem($_TABLES['comments'], 'MAX(rht)', "sid = '$sid'");
            if ( DB_error() ) {
                $rht = 0;
            }
            DB_save ($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,ipaddress',
                    "'$sid',$uid,'$comment',now(),'$title',$pid,$rht+1,$rht+2,0,'$type','{$_SERVER['REMOTE_ADDR']}'");
        }
        $cid = DB_insertId();
        DB_unlockTable ($_TABLES['comments']);

        // Send notification of comment if no errors and notications enabled for comments
        if (($ret == 0) && isset ($_CONF['notification']) &&
                in_array ('comment', $_CONF['notification'])) {
            CMT_sendNotification ($title, $comment, $uid, $_SERVER['REMOTE_ADDR'],
                              $type, $cid);
        }
    } else {
        COM_errorLog("CMT_saveComment: $uid from {$_SERVER['REMOTE_ADDR']} tried "
                   . 'to submit a comment with invalid $title and/or $comment.');
        return $ret = 5;
    }

    return $ret;
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
function CMT_sendNotification ($title, $comment, $uid, $ipaddress, $type, $cid)
{
    global $_CONF, $_TABLES, $LANG03, $LANG08, $LANG09;

    // we have to undo the addslashes() call from savecomment()
    $title = stripslashes ($title);
    $comment = stripslashes ($comment);

    // strip HTML if posted in HTML mode
    if (preg_match ('/<.*>/', $comment) != 0) {
        $comment = strip_tags ($comment);
    }

    $author = COM_getDisplayName ($uid);
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

    $mailsubject = $_CONF['site_name'] . ' ' . $LANG03[9];

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

/**
 * Deletes a given comment
 *
 * The function expects the calling function to check to make sure the
 * requesting user has the correct permissions and that the comment exits
 * for the specified $type and $sid.
 *
 * @author  Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @param   string      $type   article, poll, or plugin identifier
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
* @param    string  $type   type of comment ('article', 'poll', ...)
* @return   string          HTML for the form (or error message)
*
*/
function CMT_reportAbusiveComment ($cid, $type)
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
* @param    string  $type   type of comment ('article', 'poll', ...)
* @return   string          Meta refresh or HTML for error message
*
*/
function CMT_sendReport ($cid, $type)
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $LANG08, $LANG_LOGIN;

    if (empty ($_USER['username'])) {
        $retval = COM_siteHeader ('menu', $LANG_LOGIN[1]);
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

    $author = COM_getDisplayName ($A['uid']);
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

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
    COM_updateSpeedlimit ('mail');

    return COM_refresh ($_CONF['site_url'] . '/index.php?msg=27');
}

?>
