<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-comment.php                                                           |
// |                                                                           |
// | Geeklog comment library.                                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
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

global $_CONF;

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// set to true to enable debug output in error.log
$_COMMENT_DEBUG = COM_isEnableDeveloperModeLog('comment');

if ($_CONF['allow_user_photo']) {
    // only needed for the USER_getPhoto function
    require_once $_CONF['path_system'] . 'lib-user.php';
}

define('COMMENT_ON_SAME_PAGE', ($_CONF['comment_on_same_page'] && !CMT_isCommentPage()));
global $CMT_formVariablePrefix; // Need to do this as lib-comment is not always required where we think
$CMT_formVariablePrefix = COMMENT_ON_SAME_PAGE ? 'cmt_' : ''; // this prefix is used in functions as a global variable in this library only
define('CMT_CID', $CMT_formVariablePrefix . 'cid');
define('CMT_SID', $CMT_formVariablePrefix . 'sid');
define('CMT_PID', $CMT_formVariablePrefix . 'pid');
define('CMT_TYPE', $CMT_formVariablePrefix . 'type');
define('CMT_USERNAME', $CMT_formVariablePrefix . 'username');
define('CMT_MODE', $CMT_formVariablePrefix . 'mode');

// Possible Comment Codes for Plugin Items
define('COMMENT_CODE_DISABLED', -1); // Comments will not display and no one can add, edit, etc...
define('COMMENT_CODE_ENABLED', 0); // Comments displayed and can be added, edited, etc... if user has access
define('COMMENT_CODE_CLOSED', 1); // Comments displayed but can not be added or edited by any user except admins

/**
 * This function displays the comment control bar
 * Prints the control that allows the user to interact with Geeklog Comments
 *
 * @param    string $sid   ID of item in question
 * @param    string $title Title of item
 * @param    string $type  Type of item (i.e. article, photo, etc)
 * @param    string $order Order that comments are displayed in
 * @param    string $mode  Mode (nested, flat, etc.)
 * @param    int    $commentCode Comment code: -1=no comments, 0=allowed, 1=closed
 * @return   string          HTML Formated comment bar
 * @see CMT_userComments
 */
function CMT_commentBar($sid, $title, $type, $order, $mode, $commentCode = 0)
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG03, $CMT_formVariablePrefix;

    $is_comment_page = CMT_isCommentPage();

    $nrows = DB_count($_TABLES['comments'], array('sid', 'type'),
        array($sid, $type));

    $commentBar = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'comment'));
    $commentBar->set_file(array('commentbar' => 'commentbar.thtml'));
    $commentBar->set_block('commentbar', 'postcomment_jumplink');
    $commentBar->set_block('commentbar', 'postcomment_button');

    $commentBar->set_var('lang_comments', $LANG01[3]);
    $commentBar->set_var('lang_refresh', $LANG01[39]);
    $commentBar->set_var('lang_reply', $LANG01[60]);
    $commentBar->set_var('lang_disclaimer', $LANG01[26]);

    // hide stuff from anonymous users if they can't post
    $hideFromAnon = false;
    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) || ($_CONF['commentsloginrequired'] == 1))) {
        $hideFromAnon = true;
    }

    // check item for read permissions and comments enabled for it
    $function = 'plugin_commentenabled_' . $type;
    $commentEnabled = true;
    if (function_exists($function)) {
        // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
        if (PLG_commentEnabled($type, $sid) != COMMENT_CODE_ENABLED) {
            $commentEnabled = false;
        }
    } else {
        COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
        // This way will be depreciated as of Geeklog v3.0.0
        // check item for read permissions at least
        if (empty(PLG_getItemInfo($type, $sid, 'url'))) {
            $commentEnabled = false;
        }
    }

    // Misc Comment Messages
    if ($commentCode == COMMENT_CODE_CLOSED) {
        $commentBar->set_var('lang_comments_closed', $LANG03['comments_closed_msg']);
    }
    if ($commentCode == COMMENT_CODE_ENABLED && $hideFromAnon) {
        if (COMMENT_ON_SAME_PAGE) {
            // lang_comment_post_login_required is posted on the editor itself
        } else {
            $commentBar->set_var(
                'lang_comment_post_login_required',
                sprintf($LANG03[6], $_CONF['site_url'] . '/users.php')
            );
        }
    }

    if ($commentCode == COMMENT_CODE_CLOSED && !$commentEnabled) {
        $commentBar->set_var('postcomment_action', '');
    } else {
        if (COMMENT_ON_SAME_PAGE) {
            $commentBar->parse('postcomment_action', 'postcomment_jumplink');
        } else {
            $commentBar->parse('postcomment_action', 'postcomment_button');
        }
    }
    $commentBar->set_var('num_comments', COM_numberFormat($nrows));
    $commentBar->set_var('comment_type', $type);
    $commentBar->set_var('sid', $sid);

    $cmt_title = stripslashes($title);
    $commentBar->set_var('story_title', $cmt_title);
    // Article's are pre-escaped.
    if ($type != 'article') {
        $cmt_title = htmlspecialchars($cmt_title);
    }
    $commentBar->set_var('comment_title', $cmt_title);

    // Link to plugin defined link or lacking that a generic link
    $pluginItemUrl = CMT_getCommentUrlId($type, $sid);

    $commentBar->set_var('article_url', $pluginItemUrl);
    if ($is_comment_page) {
        $link = COM_createLink($cmt_title, $pluginItemUrl,
            array('class' => 'non-ul b'));
        $commentBar->set_var('story_link', $link);
        $commentBar->set_var('start_storylink_anchortag',
            '<a href="' . $pluginItemUrl . '" class="non-ul">');
        $commentBar->set_var('end_storylink_anchortag', '</a>');
    } else {
        $commentBar->set_var('story_link', $pluginItemUrl);
    }

    if (!COM_isAnonUser()) {
        $username = $_USER['username'];
        $fullname = $_USER['fullname'];
    } else {
        $result = DB_query("SELECT username,fullname FROM {$_TABLES['users']} WHERE uid = 1");
        $N = DB_fetchArray($result);
        $username = $N['username'];
        $fullname = $N['fullname'];
    }
    if (empty($fullname)) {
        $fullname = $username;
    }
    $commentBar->set_var('user_name', $username);
    $commentBar->set_var('user_fullname', $fullname);

    if (!COM_isAnonUser()) {
        $author = COM_getDisplayName($_USER['uid'], $username, $fullname);
        $commentBar->set_var('user_nullname', $author);
        $commentBar->set_var('author', $author);
        $commentBar->set_var('login_logout_url',
            $_CONF['site_url'] . '/users.php?mode=logout');
        $commentBar->set_var('lang_login_logout', $LANG01[35]);
    } else {
        $commentBar->set_var('user_nullname', '');
        $commentBar->set_var('login_logout_url',
            $_CONF['site_url'] . '/users.php?mode=new');
        $commentBar->set_var('lang_login_logout', $LANG01[61]);
    }

    $comment_url = $_CONF['site_url'] . '/comment.php';
    if ($is_comment_page) {
        $commentBar->set_var('parent_url', $comment_url . '#comments');
        $commentBar->set_var('editor_url', $comment_url . '#commenteditform');
        $hidden = '';
        $commentMode = Geeklog\Input::fRequest(CMT_MODE, '');
        $cid = (int) Geeklog\Input::fRequest(CMT_CID, 0);
        $pid = (int) Geeklog\Input::fRequest(CMT_PID, 0);
        if (in_array($commentMode, array('view', $LANG03[28], $LANG03[34], $LANG03[14], 'edit'))) {
            $hidden .= '<input type="hidden" name="' . CMT_CID . '" value="' . $cid . '"' . XHTML . '>';
            $hidden .= '<input type="hidden" name="' . CMT_PID . '" value="' . $cid . '"' . XHTML . '>';
        } elseif ($commentMode === 'display' || empty($commentMode)) {
            $hidden .= '<input type="hidden" name="' . CMT_PID . '" value="' . $pid . '"' . XHTML . '>';
        }
        $hidden .= '<input type="hidden" name="mode" value="' . $commentMode . '"' . XHTML . '>';
        $commentBar->set_var('hidden_field', $hidden);
        $commentBar->set_var('hidden_field_reply', '');
        $commentBar->set_var('nprefix', '');
    } else { // article and plugin
        $commentBar->set_var('parent_url', $pluginItemUrl . '#comments');
        if (COMMENT_ON_SAME_PAGE) {
            $commentBar->set_var('editor_url', $pluginItemUrl . '#commenteditform');
            $commentBar->set_var('nprefix', $CMT_formVariablePrefix);
        } else {
            $commentBar->set_var('editor_url', $comment_url . '#commenteditform');
            $commentBar->set_var('nprefix', '');
        }
        $hidden = '<input type="hidden" name="' . $type . '" value="' . $sid . '"' . XHTML . '>';
        $commentBar->set_var('hidden_field', $hidden);
        $commentBar->set_var('hidden_field_reply', $hidden);
    }

    // Order
    $selector = COM_optionList($_TABLES['sortcodes'], 'code,name', $order);
    $selector = COM_createControl('type-select', array(
        'name' => 'order',
        'select_items' => $selector
    ));
    $commentBar->set_var('order_selector', $selector);

    // Mode
    $selector = COM_optionList($_TABLES['commentmodes'], 'mode,name', $mode);
    $selector = COM_createControl('type-select', array(
        'name' => $is_comment_page ? 'format' : 'mode',
        'select_items' => $selector
    ));
    $commentBar->set_var('mode_selector', $selector);

    return $commentBar->finish($commentBar->parse('output', 'commentbar'));
}


/**
 * This function prints &$comments (db results set of comments) in comment format
 * -For previews, &$comments is assumed to be an associative array containing
 *  data for a single comment.
 *
 * @param    array   &$comments     Database result set of comments to be printed
 * @param    string  $mode          'flat', 'threaded', etc
 * @param    string  $type          Type of item (article, polls, etc.)
 * @param    string  $order         How to order the comments 'ASC' or 'DESC'
 * @param    boolean $delete_option if current user can delete comments
 * @param    boolean $preview       Preview display (for edit) or not
 * @param    int     $commentCode   Comment code: -1=no comments, 0=allowed, 1=closed
 * @param    int     $commentPage   page number of comments to display
 * @return   string   HTML          Formatted Comment
 */
function CMT_getComment(&$comments, $mode, $type, $order, $delete_option = false, $preview = false, $commentCode = 0,
                        $commentPage = 1)
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG03, $LANG31, $LANG_ADMIN, $MESSAGE, $_IMAGE_TYPE;

    $indent = 0;  // begin with 0 indent
    $retval = ''; // initialize return value
	
	$is_comment_page = CMT_isCommentPage();

    $template = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'comment'));
    $template->set_file(array(
        'comment' => 'comment.thtml',
        'thread'  => 'thread.thtml',
    ));

    // Blocks
    $template->set_block('comment', 'comment_signature');
    $template->set_block('comment', 'comment_edit');

    // generic template variables
    $template->set_var('lang_authoredby', $LANG01[42]);
    $template->set_var('lang_on', $LANG01[36]);
    $template->set_var('lang_permlink', $LANG01[120]);
    $template->set_var('order', $order);

    if ($commentCode == COMMENT_CODE_ENABLED) {
        $template->set_var('lang_replytothis', $LANG01[43]);
        $template->set_var('lang_reply', $LANG01[25]);
    } else {
        $template->set_var('lang_replytothis', '');
        $template->set_var('lang_reply', '');
    }
	
	$template->set_var('is_comment_only_page', $is_comment_page); // Tell template if comment is display on own page

    // Make sure we have a default value for comment indentation
    if (!isset($_CONF['comment_indent'])) {
        $_CONF['comment_indent'] = 25;
    }

    if ($preview) {
		// Means array is post variables
		// These should all have been filtered already
		$A = $comments;
		if (empty($A['nice_date'])) {
			$A['nice_date'] = time();
		}
		if (!isset($A['cid'])) {
			$A['cid'] = 0;
		}
		
		// Need to check to see if comment being edited and previewed belongs to user doing the editing
		if (empty($A['photo']) && ($A['uid'] == $_USER['uid'])) {
			if (isset($_USER['photo'])) {
				$A['photo'] = $_USER['photo'];
			} else {
				$A['photo'] = '';
			}
		}
		if (empty($A['email'])) {
			if (isset($_USER['email'])) {
				$A['email'] = $_USER['email'];
			} else {
				$A['email'] = '';
			}
		}
		
        $mode = 'flat';
    } else {
        $A = DB_fetchArray($comments);
    }

    if (empty($A)) {
        return '';
    }

    $commentMode = Geeklog\Input::fRequest(CMT_MODE, '');
    // Do not create a new token if the following, as these items are handled later and need to compare the old token (this is currently checked in 2 spots in lib-comment)
    // $submit can equal 'Submit Changes' || 'Save Changes to Queue' || 'Delete'
    $submit = (($commentMode == $LANG03[29]) || ($commentMode == $LANG03[35]) || ($commentMode == $LANG_ADMIN['delete']));
    $token = '';
    if ($delete_option && !$preview && !$submit) {
        $token = SEC_createToken();
    }

    // check for comment edit
    $row = 1;

    do {
        // determines indentation for current comment
        if ($mode === 'threaded' || $mode === 'nested') {
            $indent = ($A['indent'] - $A['pindent']) * $_CONF['comment_indent'];
            // set the maximum indentation level to 16
            if ($indent > 400) {
                $indent = 400;
            }
        }

        // comment variables
        $template->set_var('indent', $indent);
        $template->set_var('author_name', GLText::stripTags($A['username']));
        $template->set_var('author_id', $A['uid']);
        $template->set_var('cid', $A['cid']);
        $template->set_var('cssid', $row % 2);

        if ($_CONF['likes_enabled'] != 0 && $_CONF['likes_comments'] != 0) {
            $likes_control = LIKES_control('comment', '', $A['cid'], $_CONF['likes_comments']) . ' | ';
            $template->set_var('likes_control', $likes_control);
        } else {
            $template->set_var('likes_control', '');
        }

        if ($A['uid'] > 1) {
            $fullname = '';
            if (!empty($A['fullname'])) {
                $fullname = $A['fullname'];
            }
            $fullname = COM_getDisplayName($A['uid'], $A['username'], $fullname);
            $template->set_var('author', $fullname);
            $altText = $fullname; 
            $photo = '';
            if ($_CONF['allow_user_photo']) {
                $photo = USER_getPhoto($A['uid'], $A['photo'], $A['email'], PLG_getThemeItem('comment-width-user-avatar', 'comment'), PLG_getThemeItem('comment-css-user-avatar', 'comment'));
            }
            $profile_link = $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['uid'];
            if (!empty($photo)) {
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

            $template->set_var('start_author_anchortag', '<a href="' . $profile_link . '">');
            $template->set_var('end_author_anchortag', '</a>');
//            $template->set_var('author_link', COM_createLink($fullname, $profile_link));
            $template->set_var('author_link', COM_getProfileLink($A['uid'], $A['username'], $fullname));
        } else {
            // comment is from anonymous user
            if (isset($A['name'])) {
                $A['username'] = GLText::stripTags($A['name']);
            }
            $A['username'] = GLText::remove4byteUtf8Chars($A['username']); // Need to do this if doing a comment preview when adding/editing a comment

            $anon_username = sprintf($LANG03['anon_user_name'], $A['username']);
            $template->set_var('author', $anon_username);
            $template->set_var('author_link', $anon_username);
            if ($_CONF['allow_user_photo']) {
                $photo = USER_getPhoto($A['uid'], '', '', PLG_getThemeItem('comment-width-user-avatar', 'comment'), PLG_getThemeItem('comment-css-user-avatar', 'comment'), $A['username']);
                $template->set_var('author_photo', $photo);
            }  else {
                $template->set_var('author_photo', '');
            }
            $template->set_var('camera_icon', '');
            $template->set_var('start_author_anchortag', '');
            $template->set_var('end_author_anchortag', '');
        }

        // hide reply link from anonymous users if they can't post replies
        $hideFromAnon = false;
        if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) || ($_CONF['commentsloginrequired'] == 1))) {
            $hideFromAnon = true;
        }

        // this will hide HTML that should not be viewed in preview mode
        if ($preview || $hideFromAnon) {
            $template->set_var('hide_if_preview', 'style="display:none"');
        } else {
            $template->set_var('hide_if_preview', '');
        }

        // for threaded mode, add a link to comment parent
        if ($mode === 'threaded' && $A['pid'] != 0 && $indent == 0) {
            $pid = DB_getItem($_TABLES['comments'], 'pid',
                "cid = '{$A['pid']}'");
            if ($pid != 0) {
                $pLink = $_CONF['site_url'] . '/comment.php?mode=display'
                    . '&amp;sid=' . $A['sid'] . '&amp;type=' . $type
                    . '&amp;order=' . $order . '&amp;pid=' . $pid
                    . '&amp;format=threaded';
            } else {
                $pLink = $_CONF['site_url'] . '/comment.php?mode=view'
                    . '&amp;sid=' . $A['sid'] . '&amp;type=' . $type
                    . '&amp;order=' . $order . '&amp;cid=' . $A['pid']
                    . '&amp;format=threaded';
            }
            $parent_link = COM_createLink($LANG01[44], $pLink) . ' | ';
            $template->set_var('parent_link', $parent_link);
        } else {
            $template->set_var('parent_link', '');
        }

        list($date, ) = COM_getUserDateTimeFormat($A['nice_date'], 'date');
        $template->set_var('date', $date);
        $template->set_var('sid', $A['sid']);
        $template->set_var('type', $A['type']);

        // COMMENT edit rights
        $edit_option = false;
        if (isset($A['uid']) && isset($_USER['uid'])
            && !COM_isAnonUser()
            && ($_USER['uid'] == $A['uid']) && ($_CONF['comment_edit'] == 1)
            && ((time() - $A['nice_date']) < $_CONF['comment_edittime'])
            && (DB_getItem($_TABLES['comments'], 'COUNT(*)',
                    "pid = {$A['cid']}") == 0)
        ) {
            $edit_option = true;
            if (empty($token) && !$preview && !$submit) {
                $token = SEC_createToken();
            }
        } elseif (SEC_hasRights('comment.moderate')) {
            $edit_option = true;
        }

        if (COMMENT_ON_SAME_PAGE) {
            $pluginUrl = CMT_getCommentUrlId($type, $A['sid']);
        }

        // edit link
        $edit = '';
        if ($edit_option) {
            if (COMMENT_ON_SAME_PAGE) {
                $editLink = $pluginUrl . '&amp;' . CMT_MODE . '=edit&amp;' . CMT_CID . '=' . $A['cid']
                    . '&amp;mode=' . $mode
                    . '&amp;order=' . $order
                    . '&amp;cpage=' . $commentPage
                    . '#commenteditform';
            } else {
                $editLink = $_CONF['site_url'] . '/comment.php?mode=edit&amp;cid=' . $A['cid'];
            }
            $edit = COM_createLink($LANG01[4], $editLink) . ' | ';
        }

        // unsubscribe link
        $unsubscribe = '';
        if (($_CONF['allow_reply_notifications'] == 1) && !COM_isAnonUser()
            && isset($A['uid']) && isset($_USER['uid'])
            && ($_USER['uid'] == $A['uid'])
        ) {
            $hash = DB_getItem($_TABLES['commentnotifications'], 'deletehash',
                "cid = {$A['cid']} AND uid = {$_USER['uid']}");
            if (!empty($hash)) {
                if (COMMENT_ON_SAME_PAGE) {
                    $unsubLink = $pluginUrl . '&amp;' . CMT_MODE . "=unsubscribe&amp;" . '&amp;key=' . $hash;
                } else {
                    $unsubLink = $_CONF['site_url']
                        . '/comment.php?mode=unsubscribe&amp;key=' . $hash;
                }
                $unsubAttr = array('title' => $LANG03[43]);
                $unsubscribe = COM_createLink($LANG03[42], $unsubLink, $unsubAttr) . ' | ';
            }
        }

        // if deletion is allowed, displays delete link
        if ($delete_option) {
            $delOption = '';

            // always place edit option first, if available
            if (!empty($edit)) {
                $delOption .= $edit;
            }

            // actual delete option
            if (COMMENT_ON_SAME_PAGE) {
                $delLink = $pluginUrl . '&amp;' . CMT_MODE . '=delete&amp;' . CMT_CID . '=' . $A['cid']
                    . '&amp;' . CSRF_TOKEN . '=' . $token;
            } else {
                $delLink = $_CONF['site_url'] . '/comment.php?mode=delete&amp;cid=' . $A['cid']
                    . '&amp;' . CSRF_TOKEN . '=' . $token;
            }
            $delAttr = array('onclick' => "return confirm('{$MESSAGE[76]}');");
            $delOption .= COM_createLink($LANG01[28], $delLink, $delAttr) . ' | ';

            if (!empty($A['ipaddress'])) {
                if (empty($_CONF['ip_lookup'])) {
                    $delOption .= $A['ipaddress'] . '  | ';
                } else {
                    $ipLookUp = str_replace('*', $A['ipaddress'], $_CONF['ip_lookup']);
                    $delOption .= COM_createLink($A['ipaddress'], $ipLookUp) . ' | ';
                }
            }

            if (!empty($unsubscribe)) {
                $delOption .= $unsubscribe;
            }

            $template->set_var('delete_option', $delOption);
        } elseif ($edit_option) {
            $template->set_var('delete_option', $edit . $unsubscribe);
        } elseif (!COM_isAnonUser()) {
            $reportThis = '';
            if ($A['uid'] != $_USER['uid']) {
                $reportThisLink = $_CONF['site_url'] . '/comment.php?mode=report&amp;cid=' . $A['cid'];
                $report_attr = array('title' => $LANG01[110]);
                $reportThis = COM_createLink($LANG01[109], $reportThisLink,
                        $report_attr) . ' | ';
            }
            $template->set_var('delete_option', $reportThis . $unsubscribe);
        } else {
            $template->set_var('delete_option', '');
        }

        // Comments really should a postmode that is saved with the comment (ie store either 'html' or 'plaintext') but they don't so lets figure out if comment is html by searching for html tags
        if (preg_match('/<.*>/', $A['comment']) == 0) {
            $A['comment'] = COM_nl2br($A['comment']);
        }

        // highlight search terms if specified
        if (!empty($_REQUEST['query'])) {
            $A['comment'] = COM_highlightQuery($A['comment'], Geeklog\Input::request('query'));
        }

        $A['comment'] = str_replace('$', '&#36;', $A['comment']);
        $A['comment'] = str_replace('{', '&#123;', $A['comment']);
        $A['comment'] = str_replace('}', '&#125;', $A['comment']);

        // Replace any plugin autolink tags
        $A['comment'] = PLG_replaceTags($A['comment'], '', false, 'comment', $A['cid']);

        // create a reply to link
        $function = 'plugin_commentenabled_' . $type;
        $commentEnabled = true;
        if (function_exists($function)) {
            // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
            if (PLG_commentEnabled($type, $A['sid']) != COMMENT_CODE_ENABLED) {
                $commentEnabled = false;
            }
        } else {
            COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
            // This way will be depreciated as of Geeklog v3.0.0
            // check item for read permissions at least
            if (empty(PLG_getItemInfo($type, $A['sid'], 'url'))) {
                $commentEnabled = false;
            }
        }
        $reply_link = '';
        if ($commentCode == COMMENT_CODE_ENABLED || ($commentCode == COMMENT_CODE_CLOSED && $commentEnabled)) {
            if (COMMENT_ON_SAME_PAGE) {
                $reply_link = $pluginUrl
                    . '&amp;' . CMT_PID . '=' . $A['cid']
                    . '&amp;' . CMT_TYPE . '=' . $A['type']
                    . '&amp;mode=' . $mode
                    . '&amp;order=' . $order
                    . '&amp;cpage=' . $commentPage
                    . '#commenteditform';
            } else {
                $reply_link = $_CONF['site_url'] . '/comment.php?sid=' . $A['sid']
                    . '&amp;pid=' . $A['cid'] . '&amp;type=' . $A['type'];
                if ($_CONF['show_comments_at_replying'] == true) {
                    $reply_link .= '#commenteditform';
                }
            }
            $reply_option = COM_createLink($LANG01[43], $reply_link, array('rel' => 'nofollow')) . ' | ';
            $template->set_var('reply_option', $reply_option);
        } else {
            $template->set_var('reply_option', '');
        }
        $template->set_var('reply_link', $reply_link);

        // Check for User Signature and add first
        // Get signature of comment owner
        if ($A['uid'] > 1 && !empty(trim($A['sig']))) {
			$template->set_var('signature_divider_html', $LANG31['sig_divider_html']);

			// Converts to HTML, fixes links, and executes autotags
			$sig_html = GLText::getDisplayText(stripslashes($A['sig']), $A['postmode'], GLTEXT_LATEST_VERSION);
			
			$template->set_var('user_signature', $sig_html);
			$template->parse('comment_signature', 'comment_signature');
        } else {
            $template->set_var('user_signature', '');
            $template->set_var('comment_signature', '');
        }

        // check for comment edit
        $commentEdit = DB_query("SELECT cid,uid,UNIX_TIMESTAMP(time) AS time FROM {$_TABLES['commentedits']} WHERE cid = {$A['cid']}");
        $B = DB_fetchArray($commentEdit);
        if ($B) { //comment edit present
            // get correct editor name
            if ($A['uid'] == $B['uid']) {
                $editName = $A['username'];
            } else {
                $editName = DB_getItem($_TABLES['users'], 'username', "uid={$B['uid']}");
            }

            // add edit info to text
            list($date, ) = COM_getUserDateTimeFormat($B['time'], 'date');
            $edit_info = $LANG03[30] . ' ' . $date . ' ' . $LANG03[31] . ' ' . $editName;
            $template->set_var('user_edit_info', $edit_info);
            $template->parse('comment_edit', 'comment_edit');
        } else{
            $template->unset_var('comment_edit');
        }

        // format title for display, must happen after reply_link is created
        $A['title'] = htmlspecialchars($A['title']);
        $A['title'] = str_replace('$', '&#36;', $A['title']);

        $template->set_var('title', $A['title']);
        $template->set_var('comments', $A['comment']);

        // parse the templates
        if (($mode === 'threaded') && $indent > 0) {
            $template->set_var('pid', $A['pid']);
            $retval .= $template->parse('output', 'thread');
        } else {
            $template->set_var('pid', $A['cid']);
            $retval .= $template->parse('output', 'comment');
        }
        $row++;
    } while (!$preview && ($A = DB_fetchArray($comments)));


    return $retval;
}

/**
 * This function displays the comments in a high level format.
 * Begins displaying user comments for an item
 *
 * @param    string  $sid           ID for item to show comments for
 * @param    string  $title         Title of item
 * @param    string  $type          Type of item (article, polls, etc.)
 * @param    string  $order         How to order the comments 'ASC' or 'DESC'
 * @param    string  $mode          comment mode (nested, flat, etc.)
 * @param    int     $pid           id of parent comment
 * @param    int     $page          page number of comments to display
 * @param    boolean $cid           true if $pid should be interpreted as a cid instead
 * @param    boolean $delete_option if current user can delete comments
 * @param    int     $commentCode   Comment code: -1=no comments, 0=allowed, 1=closed
 * @return   string  HTML Formatted Comments
 * @see CMT_commentBar
 */
function CMT_userComments($sid, $title, $type = 'article', $order = '', $mode = '', $pid = 0, $page = 1, $cid = false, $delete_option = false, $commentCode = 0)
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG03;

    $retval = '';

	$is_comment_page = CMT_isCommentPage();
	
    if (!COM_isAnonUser()) {
        $result = DB_query("SELECT commentorder,commentmode,commentlimit FROM {$_TABLES['user_attributes']} WHERE uid = '{$_USER['uid']}'");
        $U = DB_fetchArray($result);
        if (empty($order)) {
            $order = $U['commentorder'];
        }
        if (empty($mode)) {
            $mode = $U['commentmode'];
        }
        $limit = $U['commentlimit'];
    }

    if ($order != 'ASC' && $order != 'DESC') {
        $order = $_CONF['comment_order'];
    }

    if (empty($mode)) {
        $mode = $_CONF['comment_mode'];
    }

    if (empty($limit)) {
        $limit = $_CONF['comment_limit'];
    }

    // Retrieve base url in case needed for 404 error
    $pluginLink = CMT_getCommentUrlId($type, $sid);

    if (empty($page)) {
        // Assume first page if none given
        $page = 1;
    } elseif (!is_numeric($page) || $page < 1) {
        COM_handle404($pluginLink);
    }

    $start = $limit * ($page - 1);

    // trap if start page num is so large that ends up turning into an exponent which makes the sql statement fail
    if (!is_int($start)) {
        COM_handle404($pluginLink);
    }

    $template = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'comment'));
    $template->set_file(array('commentarea' => 'startcomment.thtml'));
    $template->set_var('commentbar',
        CMT_commentBar($sid, $title, $type, $order, $mode, $commentCode));
    $template->set_var('sid', $sid);
    $template->set_var('comment_type', $type);
    $template->set_var('area_id', 'commentarea');
	$template->set_var('is_comment_only_page', $is_comment_page); // Tell template if comment is display on own page
	$template->set_var('comment_page_title', sprintf($LANG03['comment_page_title'], stripslashes($title)));
	$template->set_var('comment_page_title_short', $LANG03['comments']);

    if ($mode === 'nested' || $mode === 'threaded' || $mode === 'flat') {
        // build query
        switch ($mode) {
            case 'flat':
                if ($cid) {
                    $count = 1;

                    $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, u.sig, u.postmode, "
                        . "UNIX_TIMESTAMP(c.date) AS nice_date "
                        . "FROM {$_TABLES['comments']} AS c, {$_TABLES['users']} AS u "
                        . "WHERE c.uid = u.uid AND c.cid = $pid AND type='{$type}'";
                } else {
                    $count = DB_count($_TABLES['comments'],
                        array('sid', 'type'), array($sid, $type));

                    $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, u.sig, u.postmode, "
                        . "UNIX_TIMESTAMP(c.date) AS nice_date "
                        . "FROM {$_TABLES['comments']} AS c, {$_TABLES['users']} AS u "
                        . "WHERE c.uid = u.uid AND c.sid = '$sid' AND type='{$type}' "
                        . "ORDER BY date $order LIMIT $start, $limit";
                }
                break;

            case 'nested':
            case 'threaded':
            default:
                if ($order === 'DESC') {
                    $cOrder = 'c.rht DESC';
                } else {
                    $cOrder = 'c.lft ASC';
                }

                // We can simplify the query, and hence increase performance
                // when pid = 0 (when fetching all the comments for a given sid)
                if ($cid) {  // pid refers to commentid rather than parentid
                    // count the total number of applicable comments
                    $q2 = "SELECT COUNT(*) "
                        . "FROM {$_TABLES['comments']} AS c, {$_TABLES['comments']} AS c2 "
                        . "WHERE c.sid = '$sid' AND (c.lft >= c2.lft AND c.lft <= c2.rht) "
                        . "AND c2.cid = $pid AND c.type='{$type}'";
                    $result = DB_query($q2);
                    list($count) = DB_fetchArray($result);

                    $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, u.sig, u.postmode, c2.indent AS pindent, "
                        . "UNIX_TIMESTAMP(c.date) AS nice_date "
                        . "FROM {$_TABLES['comments']} AS c, {$_TABLES['comments']} AS c2, "
                        . "{$_TABLES['users']} AS u "
                        . "WHERE c.sid = '$sid' AND (c.lft >= c2.lft AND c.lft <= c2.rht) "
                        . "AND c2.cid = $pid AND c.uid = u.uid AND c.type='{$type}' "
                        . "ORDER BY $cOrder LIMIT $start, $limit";
                } else {    // pid refers to parentid rather than commentid
                    if ($pid == 0) {  // the simple, fast case
                        // count the total number of applicable comments
                        $count = DB_count($_TABLES['comments'],
                            array('sid', 'type'), array($sid, $type));

                        $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, u.sig, u.postmode, 0 AS pindent, "
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

                        $q = "SELECT c.*, u.username, u.fullname, u.photo, u.email, u.sig, u.postmode, c2.indent + 1 AS pindent, "
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

        $theComments = '';
        $result = DB_query($q);

        if (DB_numRows($result) == 0) {
            if ($page > 1) {
                // Requested invalid page
                COM_handle404($pluginLink);
            }
        }

        $theComments .= CMT_getComment($result, $mode, $type, $order, $delete_option, false, $commentCode, $page);

        // Pagination
        $tot_pages = ceil($count / $limit);
        if ($is_comment_page) {
            $pLink[0] = "comment.php?sid=$sid&amp;type=$type"; // need type here as on comment.php and need to figure out where sid is from
            $pLink[0] .= "&amp;order=$order&amp;format=$mode";
        } else {
            $pLink[0] = $pluginLink;
            $pLink[0] .= "&amp;order=$order&amp;mode=$mode";
        }
        $pLink[1] = "#comments";
        $page_str = "cpage=";
        $template->set_var('pagenav',
            COM_printPageNavigation($pLink, $page, $tot_pages, $page_str, false));

        $template->set_var('comments', $theComments);

        if (COMMENT_ON_SAME_PAGE) {
            // check item for read permissions and comments enabled for it
            $function = 'plugin_commentenabled_' . $type;
            $commentEnabled = true;
            if (function_exists($function)) {
                // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
                if (PLG_commentEnabled($type, $sid) != COMMENT_CODE_ENABLED) {
                    $commentEnabled = false;
                }
            } else {
                COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
                // This way will be depreciated as of Geeklog v3.0.0
                // check item for read permissions at least
                if (empty(PLG_getItemInfo($type, $sid, 'url'))) {
                    $commentEnabled = false;
                }
            }
            if ($commentCode == COMMENT_CODE_ENABLED || ($commentCode == COMMENT_CODE_CLOSED && $commentEnabled)) {
                $cMode = COM_applyFilter(COM_getArgument(CMT_MODE));
                $html = CMT_handleComment($cMode, $type, $title, $sid, $mode);
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
 * @param    string $title    Title of comment
 * @param    string $comment  Text of comment
 * @param    string $sid      ID of object comment belongs to
 * @param    int    $pid      ID of parent comment
 * @param    string $type     Type of object comment is posted to
 * @param    string $mode     Mode, e.g. 'preview'
 * @param    string $postMode Indicates if comment is plain text or HTML
 * @param    string $format   'threaded', 'nested', or 'flat'
 * @param    string $order    'ASC' or 'DESC' or blank
 * @param    int    $page     Page number of comments to display
 * @return   string  HTML for comment form
 */
function CMT_commentForm($title, $comment, $sid, $pid, $type, $mode, $postMode, $format = '', $order = '', $page = 0)
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG03, $LANG12, $LANG_ADMIN
           , $LANG_ACCESS, $MESSAGE, $_SCRIPTS, $CMT_formVariablePrefix;

    $retval = '';

    // never trust $uid ...
    if (empty($_USER['uid'])) {
        $uid = 1;
    } else {
        $uid = (int) $_USER['uid'];
    }
    $isAnon = ($uid <= 1);

    if (empty($pid)) {
        $pid = 0;
    }

    if (empty($format)) {
        if (isset($_REQUEST['format'])) {
            $format = Geeklog\Input::fRequest('format');
        }
        if (!in_array($format, array('threaded', 'nested', 'flat', 'nocomment'))) {
            if (COM_isAnonUser()) {
                $format = $_CONF['comment_mode'];
            } else {
                $format = DB_getItem($_TABLES['user_attributes'], 'commentmode', "uid = {$uid}");
            }
        }
    }

    if (empty($order)) {
        if (isset($_REQUEST['order'])) {
            $order = Geeklog\Input::fRequest('order');
        }
    }

    if (empty($page)) {
        if (isset($_REQUEST['cpage'])) {
            $page = (int) Geeklog\Input::fRequest('cpage', 0);
            if (empty($page)) {
                $page = 1;
            }
        }
    }

    $commentUid = $uid;
    $table = '';
    $edit_comment = false;
    $edit_comment_submission = false; // flag if in edit submission (not regular edit of comment)
    if ($mode === 'edit' || $mode === $LANG03[28]) { // 28 = Preview Changes
        $table = $_TABLES['comments'];
        $edit_comment = true;
    } elseif ($mode === 'editsubmission' || $mode == $LANG03[34]) {
        $table = $_TABLES['commentsubmissions'];
        $edit_comment_submission = true;
    }
    if (!empty($table)) {
        $cid = (int) Geeklog\Input::fRequest(CMT_CID, 0);
        if ($cid <= 0) {
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
        $commentUid = DB_getItem($table, 'uid', "cid = '$cid'");
    }

    if (COM_isAnonUser() &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['commentsloginrequired'] == 1))
    ) {
        if (COMMENT_ON_SAME_PAGE) {
            $commentlogin = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'comment'));
            $commentlogin->set_file(array('comment' => 'commentlogin.thtml'));
            $commentlogin->set_var('start_block_postacomment', COM_startBlock($LANG03[1]));
            $commentlogin->set_var(
                'lang_comment_post_login_required',
                sprintf($LANG03[6], $_CONF['site_url'] . '/users.php')
            );
            $commentlogin->set_var('end_block', COM_endBlock());
            $retval .= $commentlogin->finish($commentlogin->parse('output', 'comment'));
        } else {
            $retval .= SEC_loginRequiredForm();
        }

        return $retval;
    } else {
        COM_clearSpeedlimit($_CONF['commentspeedlimit'], 'comment');

        $last = 0;
        if ($mode !== 'edit' && $mode !== 'editsubmission'
            && $mode != $LANG03[28] && $mode != $LANG03[34]
        ) {
            // not edit mode or preview changes
            $last = COM_checkSpeedlimit('comment', SPEED_LIMIT_MAX_COMMENT);
        }

        if ($last > 0) {
            if (COMMENT_ON_SAME_PAGE) {
                $retval .= COM_showMessageText($LANG03[45], $MESSAGE[40]);
            } else {
                $retval .= COM_showMessageText($LANG03[7] . $last . $LANG03[8], $LANG12[26]);
            }
        } else {
            // Add JavaScript
            $_SCRIPTS->setJavaScriptFile('postmode_control', '/javascript/postmode_control.js');

            if (($postMode !== 'html') && ($postMode !== 'plaintext')) {
                if (empty($postMode) && $_CONF['advanced_editor'] && $_USER['advanced_editor']) {
                    $postMode = 'html';
                } elseif (empty($postMode)) {
                    $postMode = $_CONF['postmode'];
                }
            }

            // Note:
            // $comment / $newComment is what goes into the preview / is
            // actually stored in the database -> strip HTML
            // $commentText is what the user entered and goes back into the
            // <textarea> -> don't strip HTML

            $commentText = GLText::remove4byteUtf8Chars($comment);
            $commentText = htmlspecialchars($commentText);

            // Replace $, {, and } with special HTML equivalents
            $commentText = str_replace('$', '&#36;', $commentText);
            $commentText = str_replace('{', '&#123;', $commentText);
            $commentText = str_replace('}', '&#125;', $commentText);

            // Remove any autotags the user doesn't have permission to use
            $commentText = PLG_replaceTags($commentText, '', true);

            // Autotags can now be used in templates when an article is rendered
            // for this reason, replace [, ] in order to prevent garbled characters
            $commentText = str_replace('[', '&#91;', $commentText);
            $commentText = str_replace(']', '&#93;', $commentText);

            $title = COM_checkWords(GLText::stripTags($title), 'comment');
            $title = GLText::remove4byteUtf8Chars($title);

            // $title = str_replace('$','&#36;',$title); done in CMT_getComment

            $_POST['title'] = $title;

            $newComment = CMT_prepareText($comment, $postMode, $type);

            $_POST['comment'] = $newComment;

            $errorComment = false;
            // Different Preview mode: Admin Edit existing live comment, Submission Edit, New Comment Preview
            if (($mode == $LANG03[14] || $mode == $LANG03[28] || $mode == $LANG03[34])) {
                $start = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'comment'));
                $start->set_file(array('comment' => 'startcomment.thtml'));
                $start->set_var('hide_if_preview', 'style="display:none"');
                $start->set_var('area_id', 'commentpreview');

                // Clean up all the vars
                $A = array();
                foreach ($_POST as $key => $value) {
                    if (($key == CMT_PID) || ($key == CMT_CID)) {
                        $A[$key] = (int) Geeklog\Input::fPost($key);
                    } elseif (($key === 'title') || ($key === 'comment')) {
                        // these have already been filtered above
                        $A[$key] = Geeklog\Input::post($key);
                    } elseif ($key == CMT_USERNAME) {
                        $A[$key] = htmlspecialchars(
                            COM_checkWords(GLText::stripTags(Geeklog\Input::post($key)), 'comment')
                        );
                    } else {
                        $A[$key] = Geeklog\Input::fPost($key);
                    }
                }
                // Since these are past in the array below lets make sure if in POST for preview that we make them equal to empty
                // They have no reason to be in POST but could be injected in
                $A['photo'] = '';
                $A['email'] = '';
				$A['sig'] = '';
				$A['postmode'] = 'plaintext';

				if (!COM_isAnonUser($commentUid)) {
					$uresult = DB_query("SELECT username, fullname, email, sig, postmode, photo FROM {$_TABLES['users']} WHERE uid = $commentUid");
					$A = array_merge($A, DB_fetchArray($uresult));
				}

                // correct time and username for edit preview
				if (!empty($table)) {
					$A['nice_date'] = DB_getItem($table, 'UNIX_TIMESTAMP(date)', "cid = '" . DB_escapeString($cid) . "'");
				} else {
					$A['nice_date'] = time();
				}				

                if (($commentUid != 1) || empty($A[CMT_USERNAME])) {
					$A[CMT_USERNAME] = COM_getDisplayName($commentUid);
                }

                if (COMMENT_ON_SAME_PAGE) {
                    if (isset($A[CMT_CID])) {
                        $A['cid'] = $A[CMT_CID];
                    }
                    $A['username'] = $A[CMT_USERNAME];
                }

                // This stuff should always stay the same and has been filtered and checked already by
                // CMT_handlePreview and CMT_handleEdit which calls the function we are currently in CMT_commentForm
                $A['type'] = $type;
                $A['sid'] = $sid;
                $A['pid'] = $pid;
                $A['uid'] = $commentUid;

                $thecomments = CMT_getComment($A, 'flat', $type, 'ASC', false, true);

                $start->set_var('comments', $thecomments);

                $retval .= COM_startBlock($LANG03[14])
                    . $start->finish($start->parse('output', 'comment'))
                    . COM_endBlock();

                // Add in error check for missing content during preview
                if (empty($title) || empty($comment)) {
                    $retval .= COM_showMessageText($LANG03[12], $LANG03[17]);
                    $errorComment = true;
                }
            }

            $permission = ($type == 'article') ? 'story.edit' : "$type.edit";

            $comment_template = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'comment'));
            if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
                $comment_template->set_file('form', 'commentform_advanced.thtml');

                if (COM_isAnonUser()) {
                    $link_message = "";
                } else {
                    $link_message = $LANG01[138];
                }
                $comment_template->set_var('noscript', COM_getNoScript(false, '', $link_message));

                // Setup Advanced Editor
                COM_setupAdvancedEditor('/javascript/submitcomment_adveditor.js', $permission);

            } else {
                $comment_template->set_file('form', 'commentform.thtml');
            }
            // Blocks
            $comment_template->set_block('form', 'record_edit');
            $comment_template->set_block('form', 'username_anon');

            $is_comment_page = CMT_isCommentPage();
            if ($is_comment_page) {
                $comment_template->set_var('nprefix', '');
            } else {
                $comment_template->set_var('nprefix', $CMT_formVariablePrefix);
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
                // Only allow admins to disable record of edit
                if (SEC_hasRights('comment.moderate') AND !$edit_comment_submission) {
                    $comment_template->set_var('lang_record_edit', $LANG03['record_edit']);

                    if ($mode == 'edit') {
                        $record_edit = true;
                    } elseif (isset($_POST['record_edit'])) {
                        $record_edit = true;
                    } else {
                        $record_edit = false;
                    }
                    if ($record_edit) {
                        $comment_template->set_var('record_edit_checked', "checked");
                    } else {
                        $comment_template->set_var('record_edit_checked', "");
                    }

                    $comment_template->parse('record_edit', 'record_edit'); // Add record_edit block to record_edit variable
                } else {
                    $comment_template->set_var('record_edit', '');
                }

                $comment_template->set_var('hidewhenediting',
                    ' style="display:none;"');
            } else {
                $comment_template->set_var('record_edit', '');
                $comment_template->set_var('hidewhenediting', '');
            }

            if (COMMENT_ON_SAME_PAGE) {
                $formUrl = CMT_getCommentUrlId($type, $sid) . "#commentpreview";
				$commentBlockTemplate = 'blockheader-child.thtml';
            } else {
                $formUrl = $_CONF['site_url'] . '/comment.php#commentpreview'; // commentpreview needed for when showing replies on the same page
				$commentBlockTemplate = 'blockheader.thtml';
            }

            if ($mode === 'edit' || $mode === $LANG03[28]) { //edit modes
                $comment_template->set_var('start_block_postacomment',
                    COM_startBlock($LANG03[32], '', $commentBlockTemplate));
                $comment_template->set_var('cid', '<input type="hidden" name="' . CMT_CID . '" value="' . $cid . '"' . XHTML . '>');
            } elseif ($mode == 'editsubmission' || $mode == $LANG03[34]) {
                $comment_template->set_var('start_block_postacomment',
                    COM_startBlock($LANG03[33], '', $commentBlockTemplate));
                $comment_template->set_var('cid', '<input type="hidden" name="' . CMT_CID . '" value="' . $cid . '"' . XHTML . '>');
            } else {
                $comment_template->set_var('start_block_postacomment',
                    COM_startBlock($LANG03[1], '', $commentBlockTemplate));
                $comment_template->set_var('cid', '');
            }
            $comment_template->set_var('form_url', $formUrl);

            if (COM_isAnonUser()) {
                // Anonymous user
                $comment_template->set_var('uid', 1);
                if (isset($A[CMT_USERNAME])) {
                    $name = $A[CMT_USERNAME]; // for preview
                    $name = GLText::remove4byteUtf8Chars($name);
                } elseif (isset($_COOKIE[$_CONF['cookie_anon_name']])) {
                    // stored as cookie, name used before
					$name = GLText::stripTags($_COOKIE[$_CONF['cookie_anon_name']]);
					$name = COM_checkWords($name, 'comment');
					$name = GLText::remove4byteUtf8Chars($name);						
                } else {
                    $name = COM_getDisplayName(1); // anonymous user
                }

                $name = COM_escHTML($name);
                $comment_template->set_var('username_value', $name);
                $comment_template->set_var('lang_anonymous', $LANG03[24]);
                $comment_template->parse('username', 'username_anon');

                $comment_template->set_var('action_url',
                    $_CONF['site_url'] . '/users.php?mode=new');
                $comment_template->set_var('lang_logoutorcreateaccount',
                    $LANG03[04]);
            } else {
                if ($commentUid != $_USER['uid']) {
                    if (!COM_isAnonUser($commentUid)) {
                        $uresult = DB_query("SELECT username, fullname FROM {$_TABLES['users']} WHERE uid = $commentUid");
                        list($username, $fullname) = DB_fetchArray($uresult);
                    }
                } else {
                    $username = $_USER['username'];
                    $fullname = $_USER['fullname'];
                }
                $comment_template->set_var('gltoken_name', CSRF_TOKEN);
                $comment_template->set_var('gltoken', SEC_createToken());
                $comment_template->set_var('uid', $commentUid);

                if (COM_isAnonUser($commentUid)) {
                    // Since anonymous user get name stored with comment
                    if ($mode == $LANG03[14] || $mode == $LANG03[28] || $mode == $LANG03[34]) { // // Preview mode
                        $name = $A[CMT_USERNAME];
                        $name = GLText::remove4byteUtf8Chars($name);
                    } else {
                        $cn_result = DB_query("SELECT name FROM $table WHERE cid = $cid");
                        list($name) = DB_fetchArray($cn_result);
                    }
                    $comment_template->set_var('lang_anonymous', $LANG03[24]);
                    //$comment_template->set_var('CMT_USERNAME', CMT_USERNAME);
                    $comment_template->set_var('username_value', $name);
                    $comment_template->parse('username', 'username_anon');
                } else {

                    $name = COM_getDisplayName($commentUid, $username, $fullname);
                    $comment_template->set_var('username', $name);

                }

                $comment_template->set_var('action_url',
                    $_CONF['site_url'] . '/users.php?mode=logout');
                $comment_template->set_var('lang_logoutorcreateaccount',
                    $LANG03[03]);
            }

            $comment_template->set_var('lang_cancel', $LANG_ADMIN['cancel']);

            if ($mode == 'editsubmission' OR $mode == 'edit' OR $mode == $LANG03[34] OR $mode == $LANG03[28]) {
                if (SEC_hasRights('comment.moderate')) {
                    $comment_template->set_var('allow_delete', true);
                    $comment_template->set_var('lang_delete', $LANG_ADMIN['delete']);
                    $comment_template->set_var('confirm_message', $MESSAGE[76]);
                }
            }
            if ($mode == 'editsubmission' OR $mode == $LANG03[34]) { // Preview Submission changes (for edit)
                $comment_template->set_var('formtype', 'editsubmission');
            } elseif ($mode == 'edit' OR $mode == $LANG03[28]) { // Preview changes (for edit)
                $comment_template->set_var('formtype', 'edit');
            } else {
                $comment_template->set_var('formtype', 'new');
            }


            if ($postMode == 'html') {
                $comment_template->set_var('show_texteditor', 'none');
                $comment_template->set_var('show_htmleditor', '');
            } else {
                $comment_template->set_var('show_texteditor', '');
                $comment_template->set_var('show_htmleditor', 'none');
            }

            $comment_template->set_var('lang_title', $LANG03[16]);
            $comment_template->set_var('title', htmlspecialchars($title));
            $comment_template->set_var('lang_comment', $LANG03[9]);
            $comment_template->set_var('comment', $commentText);
            $comment_template->set_var('lang_postmode', $LANG03[2]);
            $comment_template->set_var('postmode_options',
                COM_optionList($_TABLES['postmodes'], 'code,name', $postMode));
            $allowed_html = '';
            foreach (array('plaintext', 'html') as $pm) {
                $allowed_html .= COM_allowedHTML($permission, false, 1, $pm);
            }
            $allowed_html .= COM_allowedAutotags();
            $comment_template->set_var('is_anon', $isAnon);
            $comment_template->set_var('allowed_html', $allowed_html);
            $comment_template->set_var('lang_importantstuff', $LANG03[18]);
            $comment_template->set_var('lang_instr_line1', $LANG03[19]);
            $comment_template->set_var('lang_instr_line2', $LANG03[20]);
            $comment_template->set_var('lang_instr_line3', $LANG03[21]);
            $comment_template->set_var('lang_instr_line4', $LANG03[22]);
            $comment_template->set_var('lang_instr_line5', $LANG03[23]);
            $comment_template->set_var('lang_instr_line6', $LANG03['instr_line6']);

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
                $comment_template->set_var('allow_save', true);
                $comment_template->set_var('lang_save', $LANG03[29]);
            } elseif ($mode == $LANG03[34] || ($mode == 'editsubmission' && $_CONF['skip_preview'] == 1)) {
                PLG_templateSetVars('comment', $comment_template);
                $comment_template->set_var('allow_save', true);
                $comment_template->set_var('lang_save', $LANG03[35]);

            } elseif (($_CONF['skip_preview'] == 1) || ($mode == $LANG03[14])) {
                PLG_templateSetVars('comment', $comment_template);
                $comment_template->set_var('allow_save', true);
                $comment_template->set_var('lang_save', $LANG03[11]);
            }

            if (($_CONF['allow_reply_notifications'] == 1 && $uid != 1) && ($mode == '' || $mode == $LANG03[14] || $errorComment)) {
            //if (($_CONF['allow_reply_notifications'] == 1 && $uid != 1) && ($mode == '' || $mode == $LANG03[14] || $mode === 'error')) {
                $comment_template->set_var('allow_notify', true);
                $comment_template->set_var('lang_notify', $LANG03[36]);
                $checked = isset($_POST['notify']) ? ' checked="checked"' : '';
                $comment_template->set_var('notify_checked', $checked);
            }

            $comment_template->set_var('end_block', COM_endBlock());
            $comment_template->parse('output', 'form');
            $retval .= $comment_template->finish($comment_template->get_var('output'));
        }
    }

    return $retval;
}

/**
 * Save a new comment
 *
 * @author   Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param    string $title    Title of comment
 * @param    string $comment  Text of comment
 * @param    string $sid      ID of object receiving comment
 * @param    int    $pid      ID of parent comment
 * @param    string $type     Type of comment this is (article, polls, etc)
 * @param    string $postmode Indicates if text is HTML or plain text
 * @return   int|string       -1 == queued, 0 == comment saved, > 0 or a string indicates error
 */
function CMT_saveComment($title, $comment, $sid, $pid, $type, $postmode)
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $_COMMENT_DEBUG;

    $ret = 0;
    $cid = 0;

    // Get a valid uid
    if (empty($_USER['uid'])) {
        $uid = 1;
    } else {
        $uid = $_USER['uid'];
    }

    // Sanity check
    if (empty($sid) || empty($title) || empty($comment) || empty($type)) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_saveComment: $uid from " . \Geeklog\IP::getIPAddress() . " tried to submit a comment with one or more missing values.");
        }
        return $ret = 1;
    }

    // Check that anonymous comments are allowed
    if (($uid == 1) && (($_CONF['loginrequired'] == 1) || ($_CONF['commentsloginrequired'] == 1))) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_saveComment: IP address " . \Geeklog\IP::getIPAddress() . " attempted to save a comment with anonymous comments disabled for site.");
        }
        return $ret = 2;
    }

    // Check for people breaking the speed limit
    COM_clearSpeedlimit($_CONF['commentspeedlimit'], 'comment');
    $last = COM_checkSpeedlimit('comment', SPEED_LIMIT_MAX_COMMENT);
    if ($last > 0) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_saveComment: $uid from " . \Geeklog\IP::getIPAddress() . " tried to submit a comment before the speed limit expired.");
        }

        return $ret = 3;
    }

    // Let plugins have a chance to check for spam
    $spamCheck = '<h1>' . $title . '</h1><p>' . $comment . '</p>';

    $permanentlink = COM_getCurrentURL(); // Should be link to article, staticpage, etc.. of comment
    $authorname = null;
    $authoremail = null;
    $authorurl = null;
    if (!COM_isAnonUser()) {
        $authorname = $_USER['username'];
        if (!empty($_USER['email'])) {
            $authoremail = $_USER['email'];
        }
        if (!empty($_USER['homepage'])) {
            $authorurl = $_USER['homepage'];
        }
    }

    $result = PLG_checkForSpam($spamCheck, $_CONF['spamx'], $permanentlink, Geeklog\Akismet::COMMENT_TYPE_COMMENT, $authorname, $authoremail, $authorurl);

    // Now check the result and display message if spam action was taken
    if ($result > PLG_SPAM_NOT_FOUND) {
        COM_updateSpeedlimit('comment');                                // update speed limit nonetheless
        COM_displayMessageAndAbort($result, 'spamx', 403, 'Forbidden'); // then tell them to get lost ...
    }

    // Let plugins have a chance to decide what to do before saving the comment, return errors.
    if ($someError = PLG_commentPreSave($uid, $title, $comment, $sid, $pid, $type, $postmode)) {
        return COM_showMessageText($title, $someError);
    }

    // Store unescaped comment and title for use in notification.
    $comment0 = CMT_prepareText($comment, $postmode, $type);
    $title0 = COM_checkWords(GLText::stripTags($title), 'comment');
    $title0 = GLText::remove4byteUtf8Chars($title0);

    $comment = DB_escapeString($comment0);
    $title = DB_escapeString($title0);
    // Get Name for anonymous user comments being added or edited
    if (($uid == 1) && isset($_POST[CMT_USERNAME])) {
        $anon = COM_getDisplayName(1);
        if (strcmp($_POST[CMT_USERNAME], $anon) != 0) {
            $username = COM_checkWords(GLText::stripTags(Geeklog\Input::post(CMT_USERNAME)), 'comment');
            $username = GLText::remove4byteUtf8Chars($username);
            SEC_setCookie($_CONF['cookie_anon_name'], $username, time() + 31536000);
            $name = DB_escapeString($username);
        }
    }

    // check for non-int pid's
    // this should just create a top level comment that is a reply to the original item
    if (!is_numeric($pid) || ($pid < 0)) {
        $pid = 0;
    }

    COM_updateSpeedlimit('comment');
    if (empty($title) || empty($comment)) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_saveComment: $uid from " . \Geeklog\IP::getIPAddress() . " tried to submit a comment with invalid $title and/or $comment.");
        }
        return $ret = 5;
    }

    if (($_CONF['commentsubmission'] == 1) && !SEC_hasRights('comment.submit')) {
        // comment into comment submission table enabled
        $seq = \Geeklog\IP::getSeq();

        if (isset($name) AND trim($name) == '') {
            DB_query("INSERT INTO {$_TABLES['commentsubmissions']} (sid,uid,name,comment,type,date,title,pid,seq) "
                . "VALUES ('$sid',$uid,NULL,'$comment','$type',NOW(),'$title',$pid,$seq)");
        } elseif (isset($name)) {
            DB_query("INSERT INTO {$_TABLES['commentsubmissions']} (sid,uid,name,comment,type,date,title,pid,seq) "
                . "VALUES ('$sid',$uid,'$name','$comment','$type',NOW(),'$title',$pid,$seq)");
        } else {
            DB_query("INSERT INTO {$_TABLES['commentsubmissions']} (sid,uid,comment,type,date,title,pid,seq) "
                . "VALUES ('$sid',$uid,'$comment','$type',NOW(),'$title',$pid,$seq)");
        }

        $cid = DB_insertId('', $_TABLES['commentsubmissions'] . '_cid_seq');

        $ret = -1; // comment queued
    } elseif ($pid > 0) {
        DB_lockTable([$_TABLES['comments'], $_TABLES['ip_addresses']]);

        $result = DB_query("SELECT rht, indent FROM {$_TABLES['comments']} WHERE cid = $pid AND sid = '$sid'");
        list($rht, $indent) = DB_fetchArray($result);
        if (!DB_error()) {
            $rht2 = $rht + 1;
            $indent += 1;
            DB_query("UPDATE {$_TABLES['comments']} SET lft = lft + 2 "
                . "WHERE sid = '$sid' AND type = '$type' AND lft >= $rht");
            DB_query("UPDATE {$_TABLES['comments']} SET rht = rht + 2 "
                . "WHERE sid = '$sid' AND type = '$type' AND rht >= $rht");

            $seq = \Geeklog\IP::getSeq();

            if (isset($name) AND trim($name) == '') {
                DB_save($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,seq,name',
                    "'$sid',$uid,'$comment',now(),'$title',$pid,$rht,$rht2,$indent,'$type',$seq,NULL");
            } elseif (isset($name)) {
                DB_save($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,seq,name',
                    "'$sid',$uid,'$comment',now(),'$title',$pid,$rht,$rht2,$indent,'$type',$seq,'$name'");
            } else {
                DB_save($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,seq',
                    "'$sid',$uid,'$comment',now(),'$title',$pid,$rht,$rht2,$indent,'$type',$seq");
            }

            $cid = DB_insertId('', $_TABLES['comments'] . '_cid_seq');

        } else { //replying to non-existent comment or comment in wrong article
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_saveComment: $uid from " . \Geeklog\IP::getIPAddress() . " tried to reply to a non-existent comment or the pid/sid did not match.");
            }
            $ret = 4; // Cannot return here, tables locked!
        }
        DB_unlockTable([$_TABLES['comments'], $_TABLES['ip_addresses']]);

        // If no error then
        if ($ret != 4) {
            // Update Comment Feeds
            COM_rdfUpToDateCheck('comment');

            // Delete What's New block cache so it can get updated again
            if ($_CONF['whatsnew_cache_time'] > 0 AND !$_CONF['hidenewcomments']) {
                $cacheInstance = 'whatsnew__'; // remove all whatsnew instances
                CACHE_remove_instance($cacheInstance);
            }

            // notify parent of new comment
            // Must occur after table unlock, only with valid $cid and $pid
            // NOTE: This could be modified to send notifications to all parents in the comment tree
            //       with only a modification to the below SELECT statement
            //       See: http://wiki.geeklog.net/index.php/CommentAlgorithm
            if ($_CONF['allow_reply_notifications'] == 1 && $cid > 0 && $pid > 0) {
                // $sql = "SELECT cid, uid, deletehash FROM {$_TABLES['commentnotifications']} WHERE cid = $pid"; // Used in Geeklog 2.0.0 and before. Notification sent only if someone directly replies to the comment (not a reply of a reply)
                $sql = "SELECT cn.cid, cn.uid, cn.deletehash "
                    . "FROM {$_TABLES['comments']} AS c, {$_TABLES['comments']} AS c2, "
                    . "{$_TABLES['commentnotifications']} AS cn "
                    . "WHERE c2.cid = cn.cid AND (c.lft >= c2.lft AND c.lft <= c2.rht) "
                    . "AND c.cid = $pid GROUP BY cn.uid";
                $result = DB_query($sql);
                $A = DB_fetchArray($result);
                if ($A !== false) {
                    CMT_sendReplyNotification($A);
                }
            }
        }
    } else {
        DB_lockTable([$_TABLES['comments'], $_TABLES['ip_addresses']]);
        $rht = DB_getItem($_TABLES['comments'], 'MAX(rht)', "sid = '$sid'");
        if (DB_error()) {
            $rht = 0;
        }
        $rht2 = $rht + 1;  // value of new comment's "lft"
        $rht3 = $rht + 2;  // value of new comment's "rht"
        $seq = \Geeklog\IP::getSeq();

        if (isset($name) AND trim($name) == '') {
            DB_save($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,seq,name',
                "'$sid',$uid,'$comment',now(),'$title',$pid,$rht2,$rht3,0,'$type',$seq,NULL");
        } elseif (isset($name)) {
            DB_save($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,seq,name',
                "'$sid',$uid,'$comment',now(),'$title',$pid,$rht2,$rht3,0,'$type',$seq,'$name'");
        } else {
            DB_save($_TABLES['comments'], 'sid,uid,comment,date,title,pid,lft,rht,indent,type,seq',
                "'$sid',$uid,'$comment',now(),'$title',$pid,$rht2,$rht3,0,'$type',$seq");
        }

        $cid = DB_insertId('', $_TABLES['comments'] . '_cid_seq');
        DB_unlockTable([$_TABLES['comments'], $_TABLES['ip_addresses']]);

        // Update Comment Feeds
        COM_rdfUpToDateCheck('comment');

        // Delete What's New block cache so it can get updated again
        if ($_CONF['whatsnew_cache_time'] > 0 AND !$_CONF['hidenewcomments']) {
            $cacheInstance = 'whatsnew__'; // remove all whatsnew instances
            CACHE_remove_instance($cacheInstance);
        }
    }

    // save user notification information
    if (isset($_POST['notify']) && ($ret == -1 || $ret == 0)) {
        $cid4hash = ($cid == 0) ? '' : $cid;
        $cid4db = ($cid == 0) ? null : $cid;

        $deletehash = md5($title . $cid4hash . $comment . rand());
        if ($ret == -1) {
            //null goes into cid, comment not published yet, set moderation queue id
            DB_save($_TABLES['commentnotifications'], 'uid,deletehash,mid', "$uid,'$deletehash',{$cid4db}");
        } else {
            DB_save($_TABLES['commentnotifications'], 'cid,uid,deletehash', "{$cid4db},$uid,'$deletehash'");
        }
    }

    // Send notification of comment if no errors and notifications enabled
    // for comments
    if ((($ret == -1) || ($ret == 0)) && isset($_CONF['notification']) &&
        in_array('comment', $_CONF['notification'])
    ) {
        if ($ret == -1) {
            $cid = 0; // comment went into the submission queue
        }
        if (($uid == 1) && isset($username)) {
            CMT_sendNotification($title0, $comment0, $uid, $username, \Geeklog\IP::getIPAddress(), $type, $sid, $cid);
        } else {
            CMT_sendNotification($title0, $comment0, $uid, '', \Geeklog\IP::getIPAddress(), $type, $sid, $cid);
        }
    }

    return $ret;
}

/**
 * Send an email notification for a new comment submission or report comment abuse.
 *
 * @param    $title      string      comment title
 * @param    $comment    string      text of the comment
 * @param    $uid        int         user id
 * @param    $username   string      optional name of anonymous user
 * @param    $ipaddress  string      poster's IP address
 * @param    $type       string      type of comment ('article', 'polls', ...)
 * @param    $sid        string      id of type
 * @param    $cid        int         comment id (or 0 when in submission queue)
 * @param    $reporter 	 string      If not empty then Comment Abuse Report and this is the username of the reporter
 * @param    $date 	 	 int   	 	 For Comment Abuse Report. Date of comment
 * @return               boolean     true if successfully sent, otherwise false
 */
function CMT_sendNotification($title, $comment, $uid, $username, $ipaddress, $type, $sid, $cid, $reporter = '', $date = null)
{
    global $_CONF, $LANG01, $LANG03, $LANG08, $LANG09, $LANG29, $LANG31;

    // sanity check
    if (($username == \Geeklog\IP::getIPAddress()) &&
        ($ipaddress != \Geeklog\IP::getIPAddress())
    ) {
        COM_errorLog("The API for CMT_sendNotification has changed ...");

        return false;
    }

    $comment = str_replace("\r\n", "\n", $comment);

    // Replace tags first incase they insert html
    $comment = PLG_replaceTags($comment, '', false, 'comment', $cid);

    // strip HTML if posted in HTML mode
    if (preg_match('/<.*>/', $comment) != 0) {
		$content_html = GLText::htmlFixURLs($comment);
        $content_plaintext = GLText::html2Text($content_html);
    } else {
		$content_plaintext = $comment;
		$content_html = COM_nl2br($content_plaintext);
	}

    if ($uid < 1) {
        $uid = 1;
    }
    if (($uid == 1) && !empty($username)) {
        $author = $username;
    } else {
        $author = COM_getDisplayName($uid);
    }
	
	// Create HTML and plaintext version of submission email
	$t = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'emails/'));
	
	$t->set_file(array('email_html' => 'comment_submission-html.thtml'));
	// Remove line feeds from plain text templates since required to use {LB} template variable
	$t->preprocess_fn = "CTL_removeLineFeeds"; // Set preprocess_fn before the template file you want to use it on		
	$t->set_file(array('email_plaintext' => 'comment_submission-plaintext.thtml'));

	$t->set_var('email_divider', $LANG31['email_divider']);
	$t->set_var('email_divider_html', $LANG31['email_divider_html']);
	$t->set_var('LB', LB);
	
	$t->set_var('lang_title', $LANG03[16]); // Title
	$t->set_var('submission_title', $title);
	$t->set_var('lang_author', $LANG03[5]); // Username
	$t->set_var('submission_author', $author);
	$t->set_var('lang_date', $LANG08[32]);
	$t->set_var('lang_type', $LANG09[5]); // Type
	$t->set_var('submission_type', $type);	
	
	// Truncate as needed
    if ($_CONF['emailstorieslength'] > 0) {
        if ($_CONF['emailstorieslength'] > 1) {
			$content_plaintext = COM_truncate($content_plaintext, $_CONF['emailstorieslength'], '...');
			$content_html = COM_truncateHTML($content_html, $_CONF['emailstorieslength'], '...');
        }
        $t->set_var('submission_content_plaintext', $content_plaintext);
		$t->set_var('submission_content_html', $content_html);
    }	

	if (!empty($reporter)) {
		// This is a Comment Abuse Report notification
		$t->set_var('submission_date', $date);
		
		$mailsubject = $_CONF['site_name'] . ' ' . $LANG03[27]; // Abuse Report
		
		$t->set_var('lang_abuse_comment_msg', sprintf($LANG03[26], $reporter)); // %s reported the following abusive comment post:
		
		$t->set_var('lang_url_label', $LANG03['read_comment'] ); // Read the full comment at
		
		$submission_url = $_CONF['site_url'] . '/comment.php?mode=view&cid=' . $cid;
	} else {
		// This is a new Comment Submission notification
		$t->set_var('submission_date', COM_strftime($_CONF['date']));
		
		if ($cid == 0) {
			$mailsubject = $_CONF['site_name'] . ' ' . $LANG29[41]; // Comment Submissions
			
			$t->set_var('lang_url_label', $LANG01[10]); // Submissions
			
			$submission_url = $_CONF['site_admin_url'] . "/moderation.php";
		} else {
			$mailsubject = $_CONF['site_name'] . ' ' . $LANG03[9]; // Comment
			
			$t->set_var('lang_url_label', $LANG03[39]); // You may view the comment thread at the following address
			
			$submission_url = $_CONF['site_url'] . '/comment.php?mode=view&cid=' . $cid;
		}
	}
	$t->set_var('submission_url', $submission_url);	

	$pluginItemUrl = CMT_getCommentUrlId($type, $sid);
	$t->set_var('lang_item_url', $LANG03['comment_for']); // The above comment is for the following item
	$t->set_var('item_url', $pluginItemUrl);	

	// Output final content
	$message[] = $t->parse('output', 'email_html');	
	$message[] = $t->parse('output', 'email_plaintext');	
	
	return COM_mail($_CONF['site_mail'], $mailsubject, $message, '', true);
}

/**
 * Deletes a given comment
 * The function expects the calling function to check to make sure the
 * requesting user has the correct permissions and that the comment exits
 * for the specified $type and $sid.
 *
 * @author  Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * $param	boolean	$forSingle	if false then all comments can be deleted by item id or just type (as of Geeklog 2.2.2)
 * @param   string 	$type 		article, or plugin identifier
 * @param   string 	$sid  		id of item comment belongs to
 * @param   int    	$cid  		Comment ID
 * @return  string  			0 indicates success, >0 identifies problem
 */
function CMT_deleteComment($cid, $sid, $type, $forSingle = true)
{
    global $_CONF, $_TABLES, $_USER, $_COMMENT_DEBUG;

    $ret = 0;  // Assume good status unless reported otherwise

    // Sanity check, note we return immediately here and no DB operations are performed
    if ($forSingle && (!is_numeric($cid) || ($cid < 0) || empty($sid) || empty($type))) {
		// Delete individual comment - cid must be numeric and have sid and type
        if ($_COMMENT_DEBUG) {
			COM_errorLog("CMT_deleteComment: {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to delete a comment with one or more missing/bad values.");
        }
        return $ret = 1;
    } elseif (!$forSingle && (empty($sid) || empty($type))) {
		// Delete all comments for item id - cid must be empty
		if ($_COMMENT_DEBUG) {
			COM_errorLog("CMT_deleteComment: {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to delete all comments for type $type and id $sid.");
        }
        return $ret = 1;
	} elseif (!$forSingle &&  empty($type)) {
		// Delete all comments for type - cid and sid must be empty
		if ($_COMMENT_DEBUG) {
			COM_errorLog("CMT_deleteComment: {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to delete all comments for type $type.");
        }
        return $ret = 1;
	}

    // For Single Comment Deletes
	// Delete the comment from the DB and update the other comments to
    // maintain the tree structure
	
	
    // A lock is needed here to prevent other additions and/or deletions
    // from happening at the same time on the comments table. A transaction would work better,
    // but aren't supported with MyISAM tables.
	// *** All tables have to be locked that are accessed in this process before the unlock happens ***
    DB_lockTable([$_TABLES['comments'], $_TABLES['commentnotifications'], $_TABLES['commentedits'], $_TABLES['commentsubmissions'], $_TABLES['likes']]);
	$sql = "SELECT pid, lft, rht, cid 
			FROM {$_TABLES['comments']}
			WHERE type = '$type'";
	if (!empty($sid)) {
		$sql .= " AND sid = '$sid'";
	}			
	if ($forSingle) {
		$sql .= " AND cid = $cid";
	}
		
    $result = DB_query($sql); 
	$numRows = DB_numRows($result);
    if (($forSingle && ($numRows == 1)) || (!$forSingle && ($numRows > 0))) {
		for ($i = 0; $i < $numRows; $i++) {
			list($pid, $lft, $rht, $cid) = DB_fetchArray($result);
			
			// Only do this for single comment deletes. If Item or type being deleted then all parent comments are getting deleted so doesn't matter
			if ($forSingle) {
				DB_change($_TABLES['comments'], 'pid', $pid, 'pid', $cid);
				DB_delete($_TABLES['comments'], 'cid', $cid);
				
				DB_query("UPDATE {$_TABLES['comments']} SET indent = indent - 1 "
					. "WHERE sid = '$sid' AND type = '$type' AND lft BETWEEN $lft AND $rht");
				DB_query("UPDATE {$_TABLES['comments']} SET lft = lft - 2 "
					. "WHERE sid = '$sid' AND type = '$type'  AND lft >= $rht");
				DB_query("UPDATE {$_TABLES['comments']} SET rht = rht - 2 "
					. "WHERE sid = '$sid' AND type = '$type'  AND rht >= $rht");				
			}
				
			// These comment records need to be delete per comment
			DB_delete($_TABLES['commentnotifications'], 'cid', $cid);
			DB_delete($_TABLES['commentedits'], 'cid', $cid);

			LIKES_deleteActions('comment', '', $cid);
		}
		
		if (!$forSingle) {
			// Delete all comments and comment submissions at once for item deletes or plugin uninstalls
			if (!empty($sid)) {
				// When an item is deleted
				DB_delete($_TABLES['comments'], array('type', 'sid'), array($type, $sid));
				DB_delete($_TABLES['commentsubmissions'], array('type', 'sid'), array($type, $sid));
			} else {
				// When a plugin (type) is deleted/uninstalled
				DB_delete($_TABLES['comments'], 'type', $type);
				DB_delete($_TABLES['commentsubmissions'], 'type', $type);
			}
		}
		DB_unlockTable([$_TABLES['comments'], $_TABLES['commentnotifications'], $_TABLES['commentedits'], $_TABLES['commentsubmissions'], $_TABLES['likes']]);

        // Update Comment Feeds
        COM_rdfUpToDateCheck('comment');

        // Delete What's New block cache so it can get updated again
        if ($_CONF['whatsnew_cache_time'] > 0 AND !$_CONF['hidenewcomments']) {
            $cacheInstance = 'whatsnew__'; // remove all whatsnew instances
            CACHE_remove_instance($cacheInstance);
        }
		
        // Delete Likes block cache so it can get updated again
		if ($_CONF['likes_block_enable'] && $_CONF['likes_block_cache_time'] > 0) {
			$cacheInstance = 'likesblock__'; // remove all likes block instances
			CACHE_remove_instance($cacheInstance);
		}		
    } else {
        DB_unlockTable([$_TABLES['comments'], $_TABLES['commentnotifications'], $_TABLES['commentedits'], $_TABLES['commentsubmissions'], $_TABLES['likes']]);
        if ($_COMMENT_DEBUG) {
			if ($forSingle) {
				COM_errorLog("CMT_deleteComment: {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to delete a comment that doesn't exist as described.");
			} elseif (!empty($sid)) {
				COM_errorLog("CMT_deleteComment: {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to delete all comments for a type $type and id $sid that doesn't have any.");
			} else {
				COM_errorLog("CMT_deleteComment: {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to delete all comments for a type $type that doesn't have any.");
			}
        }
        return $ret = 2;
    }

    return $ret;
}

/**
 * Check permissions for sending comment abuse report.
 *
 * @param    string $cid  comment id
 * @param    string $type type of comment ('article', 'polls', ...)
 * @return   string          HTML for the form (or error message)
 */
function CMT_handleReport($cid, $commentMode)
{
    global $_CONF, $_TABLES, $_USER, $_COMMENT_DEBUG;

    $retval = '';

    // get required data for checks
    if ($cid > 0) {
        // Check comment exist
        $result = DB_query("SELECT cid, type, sid, uid FROM {$_TABLES['comments']} WHERE cid = $cid");
        list($cid, $type, $sid, $commentuid) = DB_fetchArray($result);
        if (empty($cid)) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handleReport(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to report a comment that does not exist.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }

        $uid = 1;
        if (!empty($_USER['uid'])) {
            $uid = $_USER['uid'];
        }

        // check comment permissions
        if (COM_isAnonUser()) {
            $retval .= SEC_loginRequiredForm();

            return $retval;

            //if ($_COMMENT_DEBUG) {
                //COM_errorLog("CMT_handleReport(): {$_USER['uid']} from {$_SERVER['REMOTE_ADDR']} tried to report an existing comment $cid which is not allowed for anonymous users.");
            //}
            //COM_handle404($_CONF['site_url'] . '/index.php');
        }

        if ($uid == $commentuid) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handleReport(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to report his own comment.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }

        // check item for read permissions and comments enabled for it
        $function = 'plugin_commentenabled_' . $type;
        if (function_exists($function)) {
            // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
            if (PLG_commentEnabled($type, $sid) == COMMENT_CODE_DISABLED) {
                if ($_COMMENT_DEBUG) {
                    COM_errorLog("CMT_handleReport(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to report a comment without proper permission or comments have been disabled for the {$type} with id {$sid}.");
                }
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
        } else {
            COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
            // This way will be depreciated as of Geeklog v3.0.0
            // check item for read permissions at least
            if (empty(PLG_getItemInfo($type, $sid, 'url'))) {
                if ($_COMMENT_DEBUG) {
                    COM_errorLog("CMT_handleReport(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to report a comment without proper permission for the {$type} with id {$sid}.");
                }
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
        }
    } else {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleReport(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to report a comment that does not exist.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    if ($commentMode == 'report') {
        $retval .= CMT_reportAbusiveComment($cid);
    } else { // 'sendreport'
        $retval .= CMT_sendReport($cid);
    }

    return $retval;
}

/**
 * Display form to report abusive comment.
 *
 * @param    string $cid  comment id
 * @return   string          HTML for the form (or error message)
 */
function CMT_reportAbusiveComment($cid)
{
    global $_CONF, $_TABLES, $LANG03, $LANG12, $LANG_ADMIN, $_USER;

    $retval = '';

    COM_clearSpeedlimit($_CONF['speedlimit'], 'mail');
    $last = COM_checkSpeedlimit('mail', SPEED_LIMIT_MAX_MAIL);
    if ($last > 0) {
        $retval .= COM_showMessageText($LANG12[30] . $last . $LANG12[31], $LANG12[26]);

        return $retval;
    }

    $start = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'comment'));
    $start->set_file(array('report' => 'reportcomment.thtml'));
    $start->set_var('lang_report_this', $LANG03[25]);
    $start->set_var('lang_send_report', $LANG03[10]);
    $start->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $start->set_var('cid', $cid);

    $start->set_var('gltoken_name', CSRF_TOKEN);
    $start->set_var('gltoken', SEC_createToken());

    $result = DB_query("SELECT uid,type,sid,pid,title,comment,UNIX_TIMESTAMP(date) AS nice_date FROM {$_TABLES['comments']} WHERE cid = $cid");
    $A = DB_fetchArray($result);

    $result = DB_query("SELECT username, fullname, photo, email, sig, postmode FROM {$_TABLES['users']} WHERE uid = {$A['uid']}");
    $B = DB_fetchArray($result);

    // prepare data for comment preview
    $A['cid'] = $cid;
    $A['username'] = $B['username'];
    $A['fullname'] = $B['fullname'];
    $A['photo'] = $B['photo'];
    $A['email'] = $B['email'];
	$A['sig'] = $B['sig'];
	$A['postmode'] = $B['postmode'];
    $A['indent'] = 0;
    $A['pindent'] = 0;

    $thecomment = CMT_getComment($A, 'flat', $A['type'], 'ASC', false, true);
    $start->set_var('comment', $thecomment);
    $retval .= COM_startBlock($LANG03[15])
        . $start->finish($start->parse('output', 'report'))
        . COM_endBlock();

    return $retval;
}

/**
 * Send report about abusive comment
 *
 * @param    string $cid  comment id
 * @return   string|void
 */
function CMT_sendReport($cid)
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $LANG08, $LANG09, $LANG12, $MESSAGE;

    COM_clearSpeedlimit($_CONF['speedlimit'], 'mail');
    $last = COM_checkSpeedlimit('mail', SPEED_LIMIT_MAX_MAIL);
    if ($last > 0) {
        $content = COM_showMessageText($LANG08[39] . $last . $LANG08[40], $LANG12[26]);
        $display = COM_createHTMLDocument($content);
        COM_output($display);
        exit;
    }

    $result = DB_query(
        "SELECT c.uid, c.title, c.comment, c.type, c.sid, UNIX_TIMESTAMP(c.date) AS nice_date, i.ipaddress FROM {$_TABLES['comments']} AS c "
        . "LEFT JOIN {$_TABLES['ip_addresses']} AS i "
        . "ON c.seq = i.seq "
        . "WHERE c.cid = $cid"
    );
    $A = DB_fetchArray($result);
	

    $title = $A['title']; // stripslashes($A['title']);
    $comment = $A['comment']; // stripslashes($A['comment']);
	$username = ''; // retrieved in notification email function COM_getDisplayName($A['uid']);
	$ipaddress = $A['ipaddress'];
	$type = $A['type'];
	$sid = $A['sid'];
	list($date, ) = COM_getUserDateTimeFormat($A['nice_date'], 'date');
	$reporter = COM_getDisplayName($_USER['uid']);
	
	if (CMT_sendNotification($title, $comment, $A['uid'], $username, $ipaddress, $type, $sid, $cid, $reporter, $date)) {
        COM_setSystemMessage($MESSAGE[27]);
    } else {
        COM_setSystemMessage($MESSAGE[85]);
    }

    COM_updateSpeedlimit('mail');

	$pluginItemUrl = CMT_getCommentUrlId($type, $sid);
    COM_redirect($pluginItemUrl);
}

/**
 * Handles a comment edit (saves it)
 *
 * @copyright Jared Wenerd 2008
 * @author    Jared Wenerd, wenerd87 AT gmail DOT com
 * @param  string $mode whether to store edited comment in the queue
 * @return string HTML (possibly a refresh)
 */
function CMT_handleEditSubmit($mode = null)
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $_COMMENT_DEBUG;

    // Befor displaying the comment edit form lets do some checks to see if user has appropriate permissions and we have good content for a save
    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) || ($_CONF['commentsloginrequired'] == 1))) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit a comment without proper permission.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    // get required data for checks
    $cid = (int) Geeklog\Input::fPost(CMT_CID, 0);
    $postmode = Geeklog\Input::fPost('postmode', '');
    if (SEC_hasRights('comment.moderate')) {
        if (isset($_POST['record_edit'])) {
            $record_edit = true;
        } else {
            $record_edit = false;
        }
    } else {
        $record_edit = true;
    }

    if ($mode == $LANG03[35]) {
        $table = $_TABLES['commentsubmissions'];
        $record_edit = false;
    } else {
        $table = $_TABLES['comments'];
    }

    // Check comment exist
    $result = DB_query("SELECT cid, type, sid, uid FROM $table WHERE cid = $cid");
    list($cid, $type, $sid, $commentuid) = DB_fetchArray($result);
    if (empty($cid)) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit a comment that does not exist.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    // check item for read permissions and comments enabled for it
    $function = 'plugin_commentenabled_' . $type;
    if (function_exists($function)) {
        // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
        if (PLG_commentEnabled($type, $sid) != COMMENT_CODE_ENABLED) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview a comment without proper permission or comments have been disabled for the {$type} with id {$sid}.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
    } else {
        COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
        // This way will be depreciated as of Geeklog v3.0.0
        // check item for read permissions at least
        if (empty(PLG_getItemInfo($type, $sid, 'url'))) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview a comment without proper permission for the {$type} with id {$sid}.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
    }

    $uid = 1;
    if (!empty($_USER['uid'])) {
        $uid = $_USER['uid'];
    }

    // check comment permissions
    if ($uid != $commentuid && !SEC_hasRights('comment.moderate')) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit a comment without proper permission.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    // if own comment edit allowed for user then make sure within time limit
    if ($table == $_TABLES['comments'] && $_CONF['comment_edit'] == 1 && !COM_isAnonUser() && $uid == $commentuid && !SEC_hasRights('comment.moderate')) {
        if (!COM_isAnonUser()) {
            $nice_date = DB_getItem($table, 'UNIX_TIMESTAMP(date)', "cid = $cid");
            if ((time() - $nice_date) < $_CONF['comment_edittime']) {
                // All is good continue on
            } else {
                if ($_COMMENT_DEBUG) {
                    COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit his own comment $cid after the comment edit time limit had expired.");
                }
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
        } else {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit his own comment $cid which is not allowed for anonymous users.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
    }

    // check for bad input
    if (empty($_POST['title']) || empty($_POST['comment']) || ($cid <= 0)) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit a comment with one or more missing values.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    $comment = CMT_prepareText(Geeklog\Input::post('comment'), $postmode, $mode);
    $title = COM_checkWords(GLText::stripTags(Geeklog\Input::post('title')), 'comment');
    $title = GLText::remove4byteUtf8Chars($title);

    if (!empty($title) && !empty($comment)) {
        COM_updateSpeedlimit('comment');
        $title = DB_escapeString($title);
        $comment = DB_escapeString($comment);

        // Get Name for anonymous user comments being added or edited
        $sql_name = ", name = NULL "; // If Null will use anonymous
        if (COM_isAnonUser($commentuid)) {
            $anon = COM_getDisplayName($commentuid);
            if (strcmp($_POST[CMT_USERNAME], $anon) != 0) {
                $username = COM_checkWords(GLText::stripTags(Geeklog\Input::post(CMT_USERNAME)), 'comment');
                $username = GLText::remove4byteUtf8Chars($username);
                $name = DB_escapeString($username);

                // Add name to update sql
                if (trim($name) != '') {
                    $sql_name = ", name = '$name' ";
                } else { // if Blank set to Null (will use anonymous)
                    $sql_name = ", name = NULL ";
                }
            }
        }

        // save the comment into the table
        DB_query("UPDATE $table SET comment = '$comment', title = '$title'" . $sql_name
            . " WHERE cid=$cid");

        if (DB_error()) { //saving to non-existent comment or comment in wrong article
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit to a non-existent comment or the cid/sid did not match.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
        //save edit information for published comment
        // Update any feeds
        if ($mode != $LANG03[35]) {
            if ($record_edit) {
                DB_save($_TABLES['commentedits'], 'cid,uid,time', "$cid,$uid,NOW()");
            }

            COM_rdfUpToDateCheck('comment');

            // Delete What's New block cache so it can get updated again
            if ($_CONF['whatsnew_cache_time'] > 0 AND !$_CONF['hidenewcomments']) {
                $cacheInstance = 'whatsnew__'; // remove all whatsnew instances
                CACHE_remove_instance($cacheInstance);
            }
        } else {
            COM_redirect(COM_buildUrl($_CONF['site_admin_url'] . "/moderation.php"));
        }

    } else {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleEditSubmit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to submit a comment with invalid $title and/or $comment.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    $formUrl = CMT_getCommentUrlId($type, $sid);
    COM_redirect($formUrl);
}

/**
 * Filters comment text and appends necessary tags (sig and/or edit)
 *
 * @copyright Jared Wenerd 2008
 * @author    Jared Wenerd, wenerd87 AT gmail DOT com
 * @param string  $comment  comment text
 * @param string  $postMode ('html', 'plaintext', ...)
 * @param string  $type     Type of item (article, polls, etc.)
 * @return string of comment text
 */
function CMT_prepareText($comment, $postMode, $type)
{
    global $_USER, $_TABLES, $LANG03, $_CONF;

    // Remove any autotags the user doesn't have permission to use
    $comment = PLG_replaceTags($comment, '', true);
    $comment = GLText::remove4byteUtf8Chars($comment);

    if ($postMode === 'html') {
        $html_perm = ($type == 'article') ? 'story.edit' : "$type.edit";
        $comment = COM_checkWords(
            COM_checkHTML($comment, $html_perm),
            'comment'
        );
    } else {
        // plaintext
        $comment = htmlspecialchars(
            COM_checkWords($comment, 'comment')
        );
        $newComment = COM_makeClickableLinks($comment);
        if (strcmp($comment, $newComment) != 0) {
            $comment = COM_nl2br($newComment);
        }
    }

    return $comment;
}

/**
 * Disables comments for all stories where current time is past comment expire
 * time and enables comments for certain number of most recent stories.
 *
 * @copyright Jared Wenerd 2008
 * @author    Jared Wenerd, wenerd87 AT gmail DOT com
 */
function CMT_updateCommentcodes()
{
    global $_CONF, $_TABLES;

    if ($_CONF['comment_close_rec_stories'] > 0) {
        $allowedComments = array();
        $results = DB_query("SELECT sid FROM {$_TABLES['stories']} WHERE (date <= NOW()) AND (draft_flag = 0) ORDER BY date DESC LIMIT {$_CONF['comment_close_rec_stories']}");

        while ($A = DB_fetchArray($results)) {
            $allowedComments[] = DB_escapeString($A['sid']);
        }

        // update comment codes
        $sql = ' AND ';
        if (count($allowedComments) > 1) {
            $sql .= "sid NOT IN ('" . implode("','", $allowedComments) . "')";
        } else {
            $sql .= "sid <> '{$allowedComments[0]}'";
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
 * @author    Jared Wenerd, wenerd87 AT gmail DOT com
 * @param  string type  type of object comment belongs to
 * @param  string $sid  id of object comment belongs to
 * @param  int    $pid  id of parent comment
 * @param  int    $left id of left-hand successor
 * @return int          id of right-hand successor
 * @see       CMT_deleteComment
 */
function CMT_rebuildTree($type, $sid, $pid = 0, $left = 0)
{
    global $_TABLES;

    $right = $left + 1;
    $result = DB_query("SELECT cid FROM {$_TABLES['comments']} WHERE type = '$type' AND sid = '$sid' AND pid = $pid ORDER BY date ASC");
    while (DB_numRows($result) != 0 && $A = DB_fetchArray($result)) {
        $right = CMT_rebuildTree($type, $sid, $A['cid'], $right);

    }
    if ($pid != 0) {
        DB_query("UPDATE {$_TABLES['comments']} SET lft = $left, rht = $right WHERE cid = $pid");
    }

    return $right + 1;
}

/**
 * Moves comment from submission table to comments table
 *
 * @copyright  Jared Wenerd 2008
 * @author     Jared Wenerd, wenerd87 AT gmail DOT com
 * @param  string $cid comment id
 * @return string of story id
 */
function CMT_approveModeration($cid)
{
    global $_CONF, $_TABLES;

    $cid = DB_escapeString($cid);
    $result = DB_query(
        "SELECT c.type, c.sid, c.date, c.title, c.comment, c.uid, c.name, c.pid, i.ipaddress FROM {$_TABLES['commentsubmissions']} AS c "
        . "LEFT JOIN {$_TABLES['ip_addresses']} AS i "
        . "ON c.seq = i.seq "
        . "WHERE c.cid = '$cid'"
    );
    $A = DB_fetchArray($result);

    if ($A['pid'] > 0) {
        // get indent+1 of parent
        $indent = DB_getItem($_TABLES['comments'], 'indent+1', "cid = '{$A['pid']}'");

        if (empty($indent)) {
            $indent = 0;
        }
    } else {
        $indent = 0;
    }

    $A['title'] = DB_escapeString($A['title']);
    $A['comment'] = DB_escapeString($A['comment']);

    if (isset($A['name'])) {
        // insert data
        $A['name'] = DB_escapeString($A['name']);
        DB_save($_TABLES['comments'], 'type,sid,date,title,comment,uid,name,pid,seq,indent',
            "'{$A['type']}','{$A['sid']}','{$A['date']}','{$A['title']}','{$A['comment']}','{$A['uid']}'," .
            "'{$A['name']}','{$A['pid']}',{$A['seq']},$indent");
    } else {
        // insert data, null automatically goes into name column
        DB_save($_TABLES['comments'], 'type,sid,date,title,comment,uid,pid,seq,indent',
            "'{$A['type']}','{$A['sid']}','{$A['date']}','{$A['title']}','{$A['comment']}','{$A['uid']}'," .
            "'{$A['pid']}',{$A['seq']},$indent");
    }
    $newCid = DB_insertId('', 'comments_cid_seq');

    DB_delete($_TABLES['commentsubmissions'], 'cid', $cid);
    // Update notification with new id and remove comment submission id
    DB_query("UPDATE {$_TABLES['commentnotifications']} SET cid = {$newCid}, `mid` = NULL WHERE `mid` = {$cid}");

    // notify of new published comment
    if ($_CONF['allow_reply_notifications'] == 1 && $A['pid'] > 0) {
        // $sql = "SELECT cid, uid, deletehash FROM {$_TABLES['commentnotifications']} WHERE cid = $pid"; // Used in Geeklog 2.0.0 and before. Notification sent only if someone directly replies to the comment (not a reply of a reply)
        $sql = "SELECT cn.cid, cn.uid, cn.deletehash "
            . "FROM {$_TABLES['comments']} AS c, {$_TABLES['comments']} AS c2, "
            . "{$_TABLES['commentnotifications']} AS cn "
            . "WHERE c2.cid = cn.cid AND (c.lft >= c2.lft AND c.lft <= c2.rht) "
            . "AND c.cid = {$A['pid']} GROUP BY cn.uid";
        $result = DB_query($sql);
        $B = DB_fetchArray($result);
        if ($B !== false) {
            CMT_sendReplyNotification($B);
        }
    }

    // Update Comment Feeds
    COM_rdfUpToDateCheck('comment');

    // Delete What's New block cache so it can get updated again
    if ($_CONF['whatsnew_cache_time'] > 0 AND !$_CONF['hidenewcomments']) {
        $cacheInstance = 'whatsnew__'; // remove all whatsnew instances
        CACHE_remove_instance($cacheInstance);
    }

    // update comment tree
    CMT_rebuildTree($A['type'], $A['sid']);

    // Call plugins in case they want to update something
    PLG_approveCommentSubmission($A['type'], $A['sid'], $newCid);

    return array('type' => $A['type'],
                 'sid' => $A['sid']);
}

/**
 * Sends a notification of new comment reply
 *
 * @param  array   $A         contains cid, uid, and deletekey
 * @param  boolean $send_self send notification when replying to self?
 * @copyright Jared Wenerd 2008
 * @author    Jared Wenerd, wenerd87 AT gmail DOT com
 */
function CMT_sendReplyNotification($A, $send_self = false)
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $LANG31;

    if (($_USER['uid'] != $A['uid']) || $send_self) {
        $result = DB_query("SELECT email, status FROM {$_TABLES['users']} WHERE uid = {$A['uid']}");
        $nrows = DB_numRows($result);                                     

        if ($nrows == 1) {
            $B = DB_fetchArray($result);
            
            if ($B['status'] == USER_ACCOUNT_ACTIVE && !empty($B['email'])) {
				// Create HTML and plaintext version of submission email
				$t = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'emails/'));
				
				$t->set_file(array('email_html' => 'comment_reply-html.thtml'));
				// Remove line feeds from plain text templates since required to use {LB} template variable
				$t->preprocess_fn = "CTL_removeLineFeeds"; // Set preprocess_fn before the template file you want to use it on						
				$t->set_file(array('email_plaintext' => 'comment_reply-plaintext.thtml'));

				$t->set_var('email_divider', $LANG31['email_divider']);
				$t->set_var('email_divider_html', $LANG31['email_divider_html']);
				$t->set_var('LB', LB);
				
				
				$name = COM_getDisplayName($A['uid']);
				$title = DB_getItem($_TABLES['comments'], 'title', "cid = {$A['cid']}");
				$commentUrl = $_CONF['site_url'] . '/comment.php';
				
				$t->set_var('lang_hello_name', sprintf($LANG03[41], $name)); // Hello %s
				$t->set_var('lang_new_comment_msg', sprintf($LANG03[38], $title)); // A reply has been made to your comment ...
				$t->set_var('lang_url_label', $LANG03[39]); // You may view the comment thread at the following address
				$t->set_var('submission_url', $commentUrl . '?mode=view&cid=' . $A['cid'] . '&format=nested');
				$t->set_var('lang_unsubscribe_url', $LANG03[40]); // If you wish to receive no further notifications of replies, visit the following link
				$t->set_var('unsubscribe_url', $commentUrl . '?mode=unsubscribe&key=' . $A['deletehash']); 

				// Output final content
				$message[] = $t->parse('output', 'email_html');	
				$message[] = $t->parse('output', 'email_plaintext');	
				
				$mailSubject = $_CONF['site_name'] . ': ' . $LANG03[37]; // New Comment Reply
				
				COM_mail($B['email'], $mailSubject, $message, '', true);
			}
		}
    }
}

/**
 * Handles a comment submission
 *
 * @copyright Vincent Furia 2005
 * @author    Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @return string HTML (possibly a refresh)
 */
function CMT_handleCancel()
{
    global $_CONF, $_TABLES, $_COMMENT_DEBUG;

    $cid = (int) Geeklog\Input::fRequest(CMT_CID, 0);

    // Note: If it is just cid then this does not work with comments in submission table
    // so make sure comments in submission table include type and sid
    if ($cid > 0) {
        $type = '';
        $sid = '';
        $sql = "SELECT type, sid FROM {$_TABLES['comments']} WHERE cid = " . $cid;
        $result = DB_query($sql);
        if (DB_numRows($result) > 0) {
            list ($type, $sid) = DB_fetchArray($result);
        }
    } else {
        $type = Geeklog\Input::fRequest(CMT_TYPE, '');
        $sid = Geeklog\Input::fRequest(CMT_SID, '');
    }

    if (empty($type) || empty($sid)) {
        COM_handle404($_CONF['site_url'] . '/index.php');
    } else {
        // just check item for read permissions, doesn't matter if comment is closed or disabled
        // as some things like Report Abuse is allowed if comments are visible but posting
        // is closed. Cannot use PLG_commentEnabled here since if comments closed it will not allow access

        // check item for read permissions and comments enabled for it
        $function = 'plugin_commentenabled_' . $type;
        if (function_exists($function)) {
            // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
            if (PLG_commentEnabled($type, $sid) == COMMENT_CODE_DISABLED) {
                if ($_COMMENT_DEBUG) {
                    COM_errorLog("CMT_handleCancel(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to cancel a comment without proper permission or comments have been disabled for the {$type} with id {$sid}.");
                }
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
        } else {
            COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
            // This way will be depreciated as of Geeklog v3.0.0
            // check item for read permissions at least
            if (empty(PLG_getItemInfo($type, $sid, 'url'))) {
                if ($_COMMENT_DEBUG) {
                    COM_errorLog("CMT_handleCancel(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to cancel a comment without proper permission for the {$type} with id {$sid}.");
                }
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
        }

        // Get URL to redirect back too
        $formUrl = CMT_getCommentUrlId($type, $sid);
        if (empty($formUrl)) {
            COM_handle404($_CONF['site_url'] . '/index.php');
        } else {
            COM_redirect($formUrl);
        }
    }
}

/**
 * Handles a comment submission
 *
 * @copyright Vincent Furia 2005
 * @author    Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @param  string $title
 * @param  string $sid
 * @param  int    $pid
 * @param  string $type
 * @param  string $postMode
 * @return string HTML (possibly a refresh)
 */
function CMT_handleSubmit($title, $sid, $pid, $type, $postMode)
{
    global $_CONF;

    // Calls plugin to check if user has permissions to submit comment for items
    // Then Plugin will call CMT_saveComment for actual save of comment
    $display = PLG_commentSave($type, $title, Geeklog\Input::post('comment'), $sid, $pid, $postMode);
    if (!$display) {
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    return $display;
}

/**
 * Handles a comment submission
 *
 * @copyright Vincent Furia 2005
 * @author    Vincent Furia <vinny01 AT users DOT sourceforge DOT net>
 * @param  string $formType
 * @return string HTML (possibly a refresh)
 */
function CMT_handleDelete($formType)
{
    global $_CONF, $_TABLES, $_USER, $_COMMENT_DEBUG;

    $display = '';

    // check comment permissions for delete
    if (!SEC_hasRights('comment.moderate')) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleDelete(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to delete a comment without proper permission.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    $cid = (int) Geeklog\Input::fRequest(CMT_CID, 0);

    if ($formType === 'editsubmission') {
        $table = $_TABLES['commentsubmissions'];
    } else {
        $table = $_TABLES['comments'];
    }

    if ($cid > 0) {
        $result = DB_query("SELECT cid, type, sid FROM $table WHERE cid = $cid");
        list($cid, $type, $sid) = DB_fetchArray($result);
        if (empty($cid)) {
            $cid = 0;
        }
    }
    if ($cid <= 0) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleDelete(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to delete a comment that does not exist.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    if ($formType === 'editsubmission') {
        DB_delete($_TABLES['commentsubmissions'], 'cid', $cid);
        COM_redirect($_CONF['site_admin_url'] . '/moderation.php');
    } else {
        $display = PLG_commentDelete($type, $cid, $sid, false);
        if (!$display) {
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
    }

    return $display;
}

/**
 * Handles a comment view request
 *
 * @copyright Vincent Furia 2005
 * @author    Vincent Furia, vinny01 AT users DOT sourceforge DOT net
 * @param  string $format 'threaded', 'nested', or 'flat'
 * @param  string $order  'ASC' or 'DESC' or blank
 * @param  int    $page   Page number of comments to display
 * @param  bool   $view   View or display (true for view)
 * @return string HTML (possibly a refresh)
 */
function CMT_handleView($format, $order, $page, $view = true)
{
    global $_CONF, $_TABLES, $_USER;

    $cid = 0;
    if ($view) {
        if (isset($_REQUEST[CMT_CID])) {
            $cid = (int) Geeklog\Input::fRequest(CMT_CID);
        }
    } else {
        if (isset($_REQUEST[CMT_PID])) {
            $cid = (int) Geeklog\Input::fRequest(CMT_PID);
        }
    }
    if ($cid <= 0) {
        COM_handle404();
    }

    $sql = "SELECT sid, title, type FROM {$_TABLES['comments']} WHERE cid = $cid";
    $A = DB_fetchArray(DB_query($sql));
    $sid = $A['sid'];
    //$title = $A['title'];
    $type = $A['type'];
	$title = PLG_getItemInfo($type, $sid, 'title'); // Need title of item not comment title

    $display = PLG_displayComment($type, $sid, $cid, $title,
        $order, $format, $page, $view);
    if (!$display) {
        COM_handle404();
    }

    $display = COM_showMessageFromParameter() . $display;
    $display = COM_createHTMLDocument($display, array('pagetitle' => $title));

    return $display;
}

/**
 * Handles a comment preview form
 *
 * @param  string $mode   'editsubmission' or 'edit' or '' (for new/replies comments)
 * @param  string $format 'threaded', 'nested', or 'flat'
 * @param  string $order  'ASC' or 'DESC' or blank
 * @param  int    $page   Page number of comments to display
 * @return string HTML (possibly a refresh)
 */
function CMT_handlePreview($title, $comment, $sid, $pid, $type, $mode, $postMode, $format, $order, $page)
{
    global $_TABLES, $LANG03, $_CONF, $_USER, $_COMMENT_DEBUG;

    // get required data for checks for edits
    // New replies and New comments bypass this part
    $cid = (int) Geeklog\Input::fRequest(CMT_CID, 0);
    if ($cid > 0) {
        // Befor previewing the comment edit form lets do some checks to see if user has appropriate permissions
        if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) || ($_CONF['commentsloginrequired'] == 1))) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handlePreview(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview a comment without proper permission.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }

        if ($mode === $LANG03[34]) { // Preview Submission changes (for edit)) {
            $table = $_TABLES['commentsubmissions'];
        } else { // all other modes are for comments table
            $table = $_TABLES['comments'];
        }

        // Check comment exist
        $result = DB_query("SELECT cid, type, sid, uid FROM $table WHERE cid = $cid");
        list($cid, $db_type, $db_sid, $commentuid) = DB_fetchArray($result);
        if (empty($cid) || ($type != $db_type) || ($sid != $db_sid)) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handlePreview(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview a comment that does not exist.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        } else{
            $type = $db_type;
            $sid = $db_sid;
        }

        $uid = 1;
        if (!empty($_USER['uid'])) {
            $uid = $_USER['uid'];
        }

        // check comment permissions
        if (COM_isAnonUser()) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handlePreview(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview an existing comment $cid which is not allowed for anonymous users.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }

        if ($uid != $commentuid && !SEC_hasRights('comment.moderate')) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handlePreview(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview a comment without proper permission.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }

        // if own comment edit allowed for user then make sure within time limit
        if ($table == $_TABLES['comments'] && $_CONF['comment_edit'] == 1 && !COM_isAnonUser() && $uid == $commentuid && !SEC_hasRights('comment.moderate')) {
            $nice_date = DB_getItem($table, 'UNIX_TIMESTAMP(date)', "cid = $cid");
            if ((time() - $nice_date) < $_CONF['comment_edittime']) {
                // ALl is good continue on
            } else {
                if ($_COMMENT_DEBUG) {
                    COM_errorLog("CMT_handlePreview(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview his own comment $cid after the comment edit time limit had expired.");
                }
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
        }
    }

    // check item for read permissions and comments enabled for it
    $function = 'plugin_commentenabled_' . $type;
    if (function_exists($function)) {
        // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
        if (PLG_commentEnabled($type, $sid) != COMMENT_CODE_ENABLED) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handlePreview(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview a comment without proper permission or comments have been disabled for the {$type} with id {$sid}.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
    } else {
        COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
        // This way will be depreciated as of Geeklog v3.0.0
        // check item for read permissions at least
        if (empty(PLG_getItemInfo($type, $sid, 'url'))) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handlePreview(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview a comment without proper permission for the {$type} with id {$sid}.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
    }

    return CMT_commentForm(
        $title, $comment,
        $sid, $pid, $type, $mode, $postMode,
        $format, $order, $page
    );
}

/**
 * Handles a comment edit form
 *
 * @copyright Jared Wenerd 2008
 * @author    Jared Wenerd, wenerd87 AT gmail DOT com
 * @param  string $mode   'edit' or 'editsubmission'
 * @param  string $format 'threaded', 'nested', or 'flat'
 * @param  string $order  'ASC' or 'DESC' or blank
 * @param  int    $page   Page number of comments to display
 * @return string HTML (possibly a refresh)
 */
function CMT_handleEdit($mode, $format, $order, $page)
{
    global $_TABLES, $LANG03, $_CONF, $_USER, $_COMMENT_DEBUG;

    // Before displaying the comment edit form lets do some checks to see if user has appropriate permissions
    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) || ($_CONF['commentsloginrequired'] == 1))) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit a comment without proper permission.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    // get required data for checks
    $cid = (int) Geeklog\Input::fRequest(CMT_CID, 0);
    if ($cid <= 0) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit a comment with one or more missing/bad values.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    if ($mode === 'editsubmission') {
        $table = $_TABLES['commentsubmissions'];
    } else {
        $table = $_TABLES['comments'];
    }

    // Check comment exist
    $result = DB_query("SELECT cid, title, comment, type, sid, uid FROM $table WHERE cid = $cid");
    list($cid, $title, $comment, $type, $sid, $commentuid) = DB_fetchArray($result);
    if (empty($cid)) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit a comment that does not exist.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    // check item for read permissions and comments enabled for it
    $function = 'plugin_commentenabled_' . $type;
    if (function_exists($function)) {
        // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
        if (PLG_commentEnabled($type, $sid) != COMMENT_CODE_ENABLED) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview a comment without proper permission or comments have been disabled for the {$type} with id {$sid}.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
    } else {
        COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
        // This way will be depreciated as of Geeklog v3.0.0
        // check item for read permissions at least
        if (empty(PLG_getItemInfo($type, $sid, 'url'))) {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to preview a comment without proper permission for the {$type} with id {$sid}.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
    }

    $uid = 1;
    if (!empty($_USER['uid'])) {
        $uid = $_USER['uid'];
    }

    // check comment permissions
    if ($uid != $commentuid && !SEC_hasRights('comment.moderate')) {
        if ($_COMMENT_DEBUG) {
            COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit a comment without proper permission.");
        }
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    // if own comment edit allowed for user then make sure within time limit
    if ($table == $_TABLES['comments'] && $_CONF['comment_edit'] == 1 && $uid == $commentuid && !SEC_hasRights('comment.moderate')) {
        if (!COM_isAnonUser()) {
            $nice_date = DB_getItem($table, 'UNIX_TIMESTAMP(date)', "cid = $cid");
            if ((time() - $nice_date) < $_CONF['comment_edittime']) {
                // ALl is good continue on
            } else {
                if ($_COMMENT_DEBUG) {
                    COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit his own comment $cid after the comment edit time limit had expired.");
                }
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
        } else {
            if ($_COMMENT_DEBUG) {
                COM_errorLog("CMT_handleEdit(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit his own comment $cid which is not allowed for anonymous users.");
            }
            COM_handle404($_CONF['site_url'] . '/index.php');
        }
    }

    // Comments really should use a postmode that is saved with the comment (ie store either 'html' or 'plaintext')
    // but they don't so lets figure out if comment is html by searching for html tags
    $comment = COM_undoSpecialChars($comment);
    if (preg_match('/<.*>/', $comment) != 0) {
        $postMode = 'html';
    } else {
        $postMode = 'plaintext';
    }

    return CMT_commentForm($title, $comment, $sid, $cid, $type, $mode, $postMode,
        $format, $order, $page);
}

/**
 * Handles comment processing
 *
 * @param    string $mode   Mode of comment processing
 * @param    string $type   Type of item (article, polls, etc.)
 * @param    string $title  Title of item
 * @param    string $sid    ID for item to show comments for
 * @param    string $format 'threaded', 'nested', or 'flat'
 * @return   string         HTML formatted
 */
function CMT_handleComment($mode = '', $type = '', $title = '', $sid = '', $format = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG03, $LANG_ADMIN, $_COMMENT_DEBUG;

	// Some plugin may still be using Global $topic variable so check and update $_USER array as needed
	_depreciatedCheckGlobalTopicVariableUsed();

    $commentMode = Geeklog\Input::fRequest(CMT_MODE, '');

    if (empty($mode)) {
        $mode = COM_applyFilter(COM_getArgument(CMT_MODE));
    }

    if (empty($commentMode) && !empty($mode)) {
        $commentMode = $mode;
    }

    if (empty($sid) && !empty($_REQUEST[CMT_SID])) {
        $sid = Geeklog\Input::fRequest(CMT_SID);
    }

    if (empty($type) && !empty($_REQUEST[CMT_TYPE])) {
        $type = Geeklog\Input::fRequest(CMT_TYPE);
    }

    if (!empty($_REQUEST['title'])) {
        $title = Geeklog\Input::request('title'); // apply filters later in CMT_commentForm or CMT_saveComment
    }

    $postMode = Geeklog\Input::fRequest('postmode', $_CONF['postmode']);
    $formType = Geeklog\Input::fRequest('formtype', '');

    $pid = (int) Geeklog\Input::fRequest(CMT_PID, 0);

    // Get comment id, may not be there...will handle in function
    $cid = (int) Geeklog\Input::fRequest(CMT_CID, 0);
    TOPIC_getTopic('comment', $cid);

    if (empty($format) && isset($_REQUEST['format'])) {
        $format = Geeklog\Input::fRequest('format');
    }
    if (!in_array($format, array('threaded', 'nested', 'flat', 'nocomment'))) {
        if (COM_isAnonUser()) {
            $format = $_CONF['comment_mode'];
        } else {
            $format = DB_getItem($_TABLES['user_attributes'], 'commentmode', "uid = {$_USER['uid']}");
        }
    }

    $order = Geeklog\Input::fRequest('order', '');

    $cPage = 1;
    if (!empty($_REQUEST['cpage'])) {
        $cPage = (int) Geeklog\Input::fRequest('cpage');
        if (empty($cPage)) {
            $cPage = 1;
        }
    }

    $is_comment_page = CMT_isCommentPage();

    $retval = '';

    if ($_CONF['show_comments_at_replying'] && $is_comment_page && !empty($sid) && !empty($type)
        && in_array($commentMode, array('', $LANG03[28], $LANG03[34], $LANG03[14], 'edit'))
    ) {
        if ($commentMode === 'edit') {
            $cid = (int) Geeklog\Input::fRequest(CMT_CID, 0);
            if ($cid <= 0) {
                if ($_COMMENT_DEBUG) {
                    COM_errorLog("CMT_handleComment(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to edit a comment with one or more missing/bad values.");
                }
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
            $pid = $cid;
        }
        if (($pid > 0) && empty($title)) {
            $atype = DB_escapeString($type);
            $title = DB_getItem($_TABLES['comments'], 'title', "(cid = {$pid}) AND (type = '{$atype}')");
        }
        if (empty($title)) {
            $title = PLG_getItemInfo($type, $sid, 'title');
            $title = str_replace('$', '&#36;', $title);
            // CMT_userComments expects non-htmlspecial chars for title...
            $title = str_replace('&amp;', '&', $title);
            $title = str_replace('&quot;', '"', $title);
            $title = str_replace('&lt;', '<', $title);
            $title = str_replace('&gt;', '>', $title);
        }

        $retval .= CMT_userComments($sid, $title, $type, $order, $format, $pid, $cPage, ($pid > 0), false, 0);
    }

    switch ($commentMode) {
        case $LANG03[28]: // Preview Changes (for edit)
        case $LANG03[34]: // Preview Submission changes (for edit)
        case $LANG03[14]: // Preview
            $retval .= CMT_handlePreview(
                $title, Geeklog\Input::post('comment'),
                $sid, $pid, $type, $commentMode, $postMode, $format, $order, $cPage);
            if ($is_comment_page) {
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[14]));
            }
            break;

        case $LANG03[35]: // Submit Changes to Moderation table
        case $LANG03[29]: // Submit Changes
            if (SEC_checkToken()) {
                $retval .= CMT_handleEditSubmit($commentMode);
            } else {
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
            break;

        case $LANG03[11]: // Submit new comment
            $retval .= CMT_handleSubmit($title, $sid, $pid, $type, $postMode);
            break;

        case $LANG_ADMIN['delete']:
        case 'delete': // Delete comment
            if (SEC_checkToken()) {
                $retval .= CMT_handleDelete($formType);
            } else {
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
            break;

        case 'view': // View comment by $cid
            $retval .= CMT_handleView($format, $order, $cPage, true);
            break;

        case 'display': // View comment by $pid
            $retval .= CMT_handleView($format, $order, $cPage, false);
            break;

        case 'report':
            $retval .= CMT_handleReport($cid, $commentMode);
            $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[27]));
            break;

        case 'sendreport':
            if (SEC_checkToken()) {
                $retval .= CMT_handleReport($cid, $commentMode);
            } else {
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
            break;

        case 'editsubmission':
            if (!SEC_hasRights('comment.moderate')) {
                COM_handle404($_CONF['site_url'] . '/index.php');
            }
        // deliberate fall-through
        case 'edit':
            $retval .= CMT_handleEdit($commentMode, $format, $order, $cPage);
            if ($is_comment_page) {
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
            }
            break;

        case 'unsubscribe':
            $key = Geeklog\Input::fGet('key');
            if (!empty($key)) {
                $key = DB_escapeString($key);
                $cid = DB_getItem($_TABLES['commentnotifications'], 'cid', "deletehash = '{$key}'");

                if (!empty($cid)) {
                    $redirectUrl = $_CONF['site_url']
                        . '/comment.php?mode=view&amp;cid=' . $cid
                        . '&amp;format=nested&amp;msg=16';
                    DB_delete($_TABLES['commentnotifications'], 'deletehash', $key, $redirectUrl);
                    exit;
                }
            }

            COM_handle404($_CONF['site_url'] . '/index.php');
            break;

        case $LANG_ADMIN['cancel']:
            if ($formType === 'editsubmission') {
                COM_redirect($_CONF['site_admin_url'] . '/moderation.php');
            } else {
                $retval .= CMT_handleCancel();  // moved to function for readability
            }
            break;

        default: // New Comment or Reply Comment
            // Figure out title of new comment
            if (($pid > 0) && empty($title)) {
                $atype = DB_escapeString($type);
                $title = DB_getItem($_TABLES['comments'], 'title', "(cid = $pid) AND (type = '{$atype}')");
            }
            if (empty($title)) {
                $title = PLG_getItemInfo($type, $sid, 'title');

                // Check title, if for some reason blank assume no access allowed to plugin item (therefore cannot add comment) so error 404
                if (is_array($title) || empty($title) || ($title == false)) {
                    if ($_COMMENT_DEBUG) {
                        COM_errorLog("CMT_handleComment(): {$_USER['uid']} from " . \Geeklog\IP::getIPAddress() . " tried to create a new comment (or new reply) without proper permission for the {$type} with id {$sid}.");
                    }
                    COM_handle404($_CONF['site_url'] . '/index.php');
                }
                $title = str_replace('$', '&#36;', $title);
                // CMT_commentForm expects non-htmlspecial chars for title...
                $title = str_replace('&amp;', '&', $title);
                $title = str_replace('&quot;', '"', $title);
                $title = str_replace('&lt;', '<', $title);
                $title = str_replace('&gt;', '>', $title);
            }

            $retval .= CMT_handlePreview(
                $title, '',
                $sid, $pid, $type, $commentMode, $postMode, $format, $order, $cPage);
            if ($is_comment_page) {
                $noIndex = '<meta name="robots" content="noindex"' . XHTML . '>';
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1], 'headercode' => $noIndex));
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
        $result = ($page === 'comment.php');
    }

    return $result;
}

/**
 * Get URL of location where comment is displayed for item.
 * Plugins that supports comments must support PLG_getItemInfo
 *
 * @param   string $type Plugin
 * @param   string $id Id of plugin item
 * @return  array    URL to plugin item where comment is found
 * @see     function PLG_getItemInfo
 */
function CMT_getCommentUrlId($type, $id)
{
    global $_CONF, $_TABLES;

    // #Issue #1022 to fix articles with multiple pages and where comments are located
    // Need to add extra field to this function but still support old function until Geeklog v3.0.0
    // When Geeklog v3.0.0 remember to remove extra code in PLG_getCommentUrlId
    $function = 'plugin_getcommenturlid_' . $type;
    if (function_exists($function)) {
        $fct = new ReflectionFunction($function);
        if ($fct->getNumberOfRequiredParameters() == 0) {
            COM_deprecatedLog(__FUNCTION__, '2.2.1', '3.0.0', 'plugin_getcommenturlid_' . $type . " will require a id field passed to it");

            if ($type == 'article') {
                $retval[0] = COM_buildURL($_CONF['site_url'] . '/article.php');
                $retval[1] = 'story';
            } else {
                $retval = PLG_getCommentUrlId($type, '');
            }

            list($plgurl, $plgid) = $retval;
            $retval = "$plgurl?$plgid=$id";
        } else {
            $retval = PLG_getCommentUrlId($type, $id);

            // Backup support if plugin doesn't have plugin_getcommenturlid_foo function as in most cases this would work
            if (empty($retval)) {
                $retval = PLG_getItemInfo($type, $id, 'url');
            }
        }
		
		return $retval;
    }
}

/*
 * Implement *some* of the Plugin API functions for comments. While comments
 * aren't a plugin (and likely never will be), implementing some of the API
 * functions here will save us from doing special handling elsewhere.
 */

/**
 * Do we support comment feeds? (use plugin api)
 *
 * @return   array   id/name pairs of all supported feeds
 */
function plugin_getfeednames_comment()
{
    global $_TABLES, $LANG33;

    $feeds = array();

    $feeds[] = array('id' => 'all', 'name' => $LANG33[23]);

    $result = DB_query("SELECT tid, topic FROM {$_TABLES['topics']} " . COM_getPermSQL('AND') . " ORDER BY topic ASC");
    $num = DB_numRows($result);

    if ($num > 0) {
        for ($i = 0; $i < $num; $i++) {
            $A = DB_fetchArray($result);
            $feeds[] = array('id' => $A['tid'], 'name' => $A['topic']);
        }
    }

    return $feeds;
}

/**
 * Provide feed data
 *
 * @param    int    $feed feed ID
 * @param    string $link
 * @param    string $update
 * @return   array          feed entries
 */
function plugin_getfeedcontent_comment($feed, &$link, &$update)
{
    global $_CONF, $_TABLES;

    $result = DB_query("SELECT topic,limits,content_length FROM {$_TABLES['syndication']} WHERE fid = '$feed'");
    $S = DB_fetchArray($result);

    // If topic is all then make it root so all topics are returned (since articles cannot belong to all topics)
    if ($S['topic'] == TOPIC_ALL_OPTION OR empty($S['topic'])) {
        $S['topic'] = TOPIC_ROOT;
    }

    // Retrieve list of inherited topics for anonymous user
    $tid_list = TOPIC_getChildList($S['topic'], 1);

    $sql = "SELECT c.cid, c.sid, c.title as title, c.comment, UNIX_TIMESTAMP(c.date) AS modified, "
        . " s.title as article_title, c.uid, s.uid as article_author "
        . "FROM {$_TABLES['comments']} c, {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta "
        . "WHERE (s.draft_flag = 0) AND (s.date <= NOW()) "
        . COM_getPermSQL('AND', 1, 2, 's')
        . " AND ta.type = 'article' AND ta.id = s.sid "
        . " AND c.type = 'article' AND s.sid = c.sid "
        . "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$S['topic']}'))) "
        . "GROUP BY c.cid, c.sid, c.title, c.comment, UNIX_TIMESTAMP(c.date), s.title, c.uid, s.uid "
        . "ORDER BY modified DESC  LIMIT 0, {$S['limits']} ";

    $result = DB_query($sql);

    $content = array();
    $cids = array();
    $numRows = DB_numRows($result);

    for ($i = 0; $i < $numRows; $i++) {
        $row = DB_fetchArray($result);
        $cids[] = $row['cid'];

        $title = stripslashes($row['title']);
        $body = stripslashes($row['comment']);
        if ($S['content_length'] > 1) {
            $body = SYND_truncateSummary($body, $S['content_length']);
        }
        $articleLink = COM_buildURL($_CONF['site_url'] . "/article.php?story={$row['sid']}");

        $link = $_CONF['site_url'] . "/comment.php?mode=view&cid={$row['cid']}";
        $articleTitle = $row['article_title'];

        if ($_CONF['comment_feeds_article_tag_position'] !== 'none') {
            $articleAuthor = sprintf($_CONF['comment_feeds_article_author_tag'],
                $_CONF['site_url'] . '/users.php?mode=profile&uid=' . $row['article_author'],
                COM_getDisplayName($row['article_author']));
            $commentAuthor = sprintf($_CONF['comment_feeds_comment_author_tag'],
                $_CONF['site_url'] . '/users.php?mode=profile&uid=' . $row['uid'],
                COM_getDisplayName($row['uid']));
            $magicTag = sprintf($_CONF['comment_feeds_article_tag'], $articleLink, $articleTitle, $articleAuthor, $commentAuthor);

            if ($_CONF['comment_feeds_article_tag_position'] === 'start') {
                $body = $magicTag . $body;
            } else {
                $body .= $magicTag;
            }
        }

        $content[] = array(
            'title'   => $title,
            'summary' => $body,
            'link'    => $link,
            'uid'     => $row['uid'],
            'author'  => COM_getDisplayName($row['uid']),
            'date'    => $row['modified'],
            'format'  => 'html',
        );
    }

    $link = $_CONF['site_url'];
    $update = implode(',', $cids);

    return $content;
}

/**
 * Checking if comment feeds are up to date
 *
 * @param    int    $feed          id of feed to be checked
 * @param    string $topic         topic
 * @param    string $update_data   data describing current feed contents
 * @param    string $limit         number of entries or number of hours
 * @param    string $updated_type  (optional) type of feed to be updated
 * @param    string $updated_topic (optional) feed's "topic" to be updated
 * @param    string $updated_id    (optional) id of entry that has changed
 * @return   bool                  true: feed data is up to date; false: isn't
 */
function plugin_feedupdatecheck_comment($feed, $topic, $update_data, $limit, $updated_type = '', $updated_topic = '', $updated_id = '')
{
    global $_TABLES, $_TOPICS;

    if ($updated_type !== 'comment') {
        // we're not interested
        $updated_type = '';
        $updated_topic = '';
        $updated_id = '';
    }

    /* Original
    $sql = "SELECT c.cid, UNIX_TIMESTAMP(c.date) AS modified "
           ." FROM {$_TABLES['comments']} as c "
           ." JOIN {$_TABLES['stories']} as s ON s.sid = c.sid "
           ." JOIN {$_TABLES['topics']} as t ON t.tid = s.tid "
           .COM_getPermSQL('WHERE', 1, 2, 's')
           .COM_getPermSQL('AND', 1, 2, 't')
           ." AND type='article' ";
   */

    /*
    if( $topic != 'all' )
    {
        $sql .= " AND topic='{$topic}' ";
    } */


    // If topic is all then make it root so all topics are returned (since articles cannot belong to all topics)
    if ($topic == TOPIC_ALL_OPTION || empty($topic)) {
        $topic = TOPIC_ROOT;
    }

    // Retrieve list of inherited topics for anonymous user
    $tid_list = TOPIC_getChildList($topic, 1);

    $sql = "SELECT c.cid, UNIX_TIMESTAMP(c.date) AS modified "
        . "FROM {$_TABLES['comments']} c, {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta "
        . "WHERE (s.draft_flag = 0) AND (s.date <= NOW()) "
        . COM_getPermSQL('AND', 1, 2, 's')
        . " AND ta.type = 'article' AND ta.id = s.sid "
        . " AND c.type = 'article' AND s.sid = c.sid "
        . "AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$topic}'))) "
        . "GROUP BY c.cid, UNIX_TIMESTAMP(c.date) "
        . "ORDER BY modified DESC  LIMIT 0, {$limit} ";

    $result = DB_query($sql);
    $num = DB_numRows($result);

    $cids = array();
    for ($i = 0; $i < $num; $i++) {
        $A = DB_fetchArray($result);

        if ($A['cid'] == $updated_id) {
            // this feed has to be updated - no further checks needed
            return false;
        }

        $cids[] = $A['cid'];
    }
    $current = implode(',', $cids);

    return ($current == $update_data);
}

/**
 * This function counts the number of comments this type of item has
 *
 * @param    string $sid   ID of item in question
 * @param    string $type  Type of item (i.e. article, photo, etc)
 * @return   int           Number of comments
 */
function CMT_commentCount($sid, $type)
{
    global $_TABLES;

    $nrows = DB_count($_TABLES['comments'], array('sid', 'type'),
        array($sid, $type));

    return $nrows;
}

/**
 * Did user create any comments
 *
 * @return   string   number of comments user contributed. If nothing leave blank
 */
function plugin_usercontributed_comment($uid)
{
    global $_TABLES, $LANG03;

    $retval = '';

    // Include comments and comment submissions
    $count = DB_getItem($_TABLES['comments'], 'COUNT(uid)', "uid = {$uid}") + DB_getItem($_TABLES['commentsubmissions'], 'COUNT(uid)', "uid = {$uid}");

    if ($count > 0) {
        $retval = str_replace('%s', $count, $LANG03['num_comments']);
    }

    return $retval;
}

/**
 * Find out Likes plural label for item
 *
 * @return   string 	Plural name of item that can be liked or disliked
 */
function plugin_likeslabel_comment($sub_type)
{
    global $_CONF, $LANG_LIKES;

    $retval = false;

    if ($_CONF['likes_comments'] > 0) {
		$retval = $LANG_LIKES['comments'];
    }

    return $retval;
}

/**
 * Is Likes system enabled for comments
 *
 * @return   int    0 = disabled, 1 = Likes and Dislikes, 2 = Likes only
 */
function plugin_likesenabled_comment($sub_type, $id)
{
    global $_CONF;

    $retval = false;

    if ($_CONF['likes_comments'] > 0) {
        $retval = $_CONF['likes_comments'];
    }

    return $retval;
}

/**
 * Can user perform a like action on item
 * Need to check not only likes enabled for item but same owner and read permissions to item
 * Note: $Id is filtered as a string by likes.php.
 *       If needed do additional checks here (like if you need a numeric value)
 *       but you cannot change the value of id since it will not change in the original calling function
 *
 * @return   bool
 */
function plugin_canuserlike_comment($sub_type, $id, $uid, $ip)
{
    global $_CONF, $_TABLES;

    $retval = false;

    if ($_CONF['likes_comments'] > 0) {
    	// Make sure $id is just a number as comment id is numeric
        // Cannot change id in this function, since the id from the calling function is used else where
    	if (strval((int) $id) == $id) {
            $sql = "SELECT c.type, c.sid, c.uid, i.ipaddress FROM {$_TABLES['comments']} AS c "
                . "LEFT JOIN {$_TABLES['ip_addresses']} AS i "
                . "ON c.seq = i.seq "
                . "WHERE c.cid = " . $id;
            $result = DB_query($sql);
            if (DB_numRows($result) > 0) {
                list ($type, $sid, $owner_id, $owner_ip) = DB_fetchArray($result);
                // check item for read permissions and comments enabled for it
                $commentCode = COMMENT_CODE_DISABLED;
                $function = 'plugin_commentenabled_' . $type;
                if (function_exists($function)) {
                    // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
                    $commentCode = PLG_commentEnabled($type, $sid);
                } else {
                    COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
                    // This way will be depreciated as of Geeklog v3.0.0
                    // check item for read permissions at least
                    if (!empty(PLG_getItemInfo($type, $sid, 'url'))) {
                        $commentCode = COMMENT_CODE_ENABLED;
                    }
                }

                if ($commentCode == COMMENT_CODE_ENABLED) {
                    // Make sure owner of comment and user not the same
                    if ($owner_id != $uid) {
                        $retval = true;
                    } elseif ($uid == 1 AND $owner_id == 1 AND $ip != $owner_ip) {
                        $retval = true;
                    }
                }
            }
        }
    }

    return $retval;
}

/**
 * Get URL for item like is for
 * Note: $Id is filtered as a string by likes.php.
 *       If needed do additional checks here (like if you need a numeric value)
 *       but you cannot change the value of id since it will not change in the original calling function
 *
 * @return   string    URL of item like is for
 */
function plugin_getItemLikeURL_comment($sub_type, $id)
{
    global $_CONF, $_TABLES;

    $retval = '';

    if ($_CONF['likes_comments'] > 0) {
        // Make sure $id is just a number as comment id is numeric
        // Cannot change id in this function, since the id from the calling function is used else where
        if (strval((int) $id) == $id) {
            $sql = "SELECT type, sid FROM {$_TABLES['comments']} WHERE cid = " . $id;
            $result = DB_query($sql);
            if (DB_numRows($result) > 0) {
                list ($type, $sid) = DB_fetchArray($result);
                // check item for read permissions and comments enabled for it
                $commentAccess = COMMENT_CODE_DISABLED;
                $function = 'plugin_commentenabled_' . $type;
                if (function_exists($function)) {
                    // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
                    $commentAccess = PLG_commentEnabled($type, $sid);
                } else {
                    COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
                    // This way will be depreciated as of Geeklog v3.0.0
                    // check item for read permissions at least
                    if (!empty(PLG_getItemInfo($type, $sid, 'url'))) {
                        $commentAccess = COMMENT_CODE_ENABLED;
                    }
                }

                if ($commentAccess == COMMENT_CODE_ENABLED) {
                    $retval = CMT_getCommentUrlId($type, $sid);
                }
            }
        }
    }

    return $retval;
}

/**
 * Return information for a comment
 *
 * @param    string $cid		comment ID or '*'
 * @param    string $what    	comma-separated list of properties
 * @param    int    $uid     	user ID or 0 = current user
 * @param    array  $options 	(reserved for future extensions)
 * @return   mixed              string or array of strings with the information
 */
function plugin_getiteminfo_comment($cid, $what, $uid = 0, $options = array())
{
    global $_CONF, $_TABLES;

    // parse $what to see what we need to pull from the database
    $properties = explode(',', $what);
    $fields = [];
	$fields[] = 'cid';
	$fields[] = 'type';
	$fields[] = 'sid AS itemID';
    foreach ($properties as $p) {
        switch ($p) {
            case 'date-created':
                $fields[] = 'UNIX_TIMESTAMP(created) AS c_unixdate';
                break;

            case 'description':
            case 'excerpt':
                $fields[] = 'comment';
                break;

            case 'id':
                // Already grabbing it
                break;

            case 'title':
                $fields[] = 'title';
                break;
				
            case 'likes':
				// Likes comment setting is a global variable and not an item per item setting
                $fields[] = $_CONF['likes_comments'] . ' AS likes';
                $groupby_fields[] = 'likes';
                break;	

            case 'url':
                // needed for $cid == '*', but also in case we're only requesting
                // the URL (so that $fields isn't empty)
                $fields[] = 'cid';
                break;

            default:
                // nothing to do
                break;
        }
    }

    $fields = array_unique($fields);

    if (count($fields) == 0) {
        $retval = array();

        return $retval;
    }

    // prepare SQL request
	$where = "";
    if ($cid != '*') {
        $where = " WHERE (cid = '" . DB_escapeString($cid) . "')";
    }

    $sql = "SELECT " . implode(',', $fields)
        . " FROM {$_TABLES['comments']}" . $where;
    if ($cid != '*') {
        $sql .= ' LIMIT 1';
    }

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    $retval = array();
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);
		
		// Can't check permission in above SQL for read access to item of comment and if comment is enabled so do it now
		// check item for read permissions and comments enabled for it
		$commentAccess = COMMENT_CODE_DISABLED;
		$type = $A['type'];
		$function = 'plugin_commentenabled_' . $type;
		if (function_exists($function)) {
			// CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
			$commentAccess = PLG_commentEnabled($type, $A['itemID'], $uid);
		} else {
			COM_deprecatedLog('plugin_getiteminfo_' . $type, '2.2.1', '3.0.0', 'plugin_commentenabled_' . $type . " is now required to check if comments are enabled for a plugin item.");
			// This way will be depreciated as of Geeklog v3.0.0
			// check item for read permissions at least
			if (!empty(PLG_getItemInfo($type, $A['itemID'], 'url', $uid))) {
				$commentAccess = COMMENT_CODE_ENABLED;
			}
		}

		// CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
		if ($commentAccess != COMMENT_CODE_DISABLED) { // enabled and closed is allowed since readable
			$props = array();
			foreach ($properties as $p) {
				switch ($p) {
					case 'date-created':
						$props['date'] = $A['c_unixdate'];
						break;

					case 'description':
					case 'excerpt':
						// Comments really should a postmode that is saved with the comment (ie store either 'html' or 'plaintext') but they don't so lets figure out if comment is html by searching for html tags
						if (preg_match('/<.*>/', $A['comment']) == 0) {
							$A['comment'] = COM_nl2br($A['comment']);
						}

						$A['comment'] = str_replace('$', '&#36;', $A['comment']);
						$A['comment'] = str_replace('{', '&#123;', $A['comment']);
						$A['comment'] = str_replace('}', '&#125;', $A['comment']);

						// Replace any plugin autotags
						$A['comment'] = PLG_replaceTags($A['comment'], '', false, 'comment', $A['cid']);
						
						$props[$p] = $A['comment'];
						break;

					case 'id':
						$props['id'] = $A['cid'];
						break;

					case 'title':
						$props['title'] = stripslashes($A['title']);
						break;
						
					case 'likes':
						$props['likes'] = $A['likes'];
						break;						

					case 'url':
						$props['url'] = $_CONF['site_url'] . "/comment.php?mode=view&cid={$A['cid']}";
						break;

					default:
						// return empty string for unknown properties
						$props[$p] = '';
						break;
				}
			}

			$mapped = array();
			foreach ($props as $key => $value) {
				if ($cid == '*') {
					if ($value != '') {
						$mapped[$key] = $value;
					}
				} else {
					$mapped[] = $value;
				}
			}

			if ($cid == '*') {
				$retval[] = $mapped;
			} else {
				$retval = $mapped;
				break;
			}
		}
    }

    if (($cid != '*') && (count($retval) == 1)) {
        $retval = $retval[0];
    }

    return $retval;
}

/**
 * A user is about to be deleted. Update ownership of any comments owned
 * by that user or delete them.
 *
 * @param   int $uid User id of deleted user
 */
function plugin_user_delete_comment($uid)
{
    global $_TABLES, $_CONF;
	
	// Delete any submission records
	DB_delete($_TABLES['commentsubmissions'], 'uid', $uid);
	
    if (DB_count($_TABLES['comments'], 'uid', $uid) == 0) {
        // there are no comments owned by this user
        return;
    }

    DB_query("UPDATE {$_TABLES['comments']} SET uid = 1 WHERE uid = $uid");

	// Delete Comment related records
	DB_delete($_TABLES['commentedits'], 'uid', $uid);
	DB_delete($_TABLES['commentnotifications'], 'uid', $uid);
}
