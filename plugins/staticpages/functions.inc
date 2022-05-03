<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.7                                                   |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the Static     |
// | Pages' PHP files.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2019 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Blaine Lang      - blaine AT portalparts DOT com                 |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
 * Implementation of the Plugin API for the Static Pages plugin
 *
 * @package StaticPages
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

$plugin_path = $_CONF['path'] . 'plugins/staticpages/';

/**
 * Language file include
 */
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';
if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}

Language::override(array(
    'LANG_STATIC', 'PLG_staticpages_MESSAGE15', 'PLG_staticpages_MESSAGE19',
    'PLG_staticpages_MESSAGE20', 'PLG_staticpages_MESSAGE21',
));

/**
 * Check and see if we need to load the plugin configuration
 */
if (!isset($_SP_CONF['allow_php'])) {
    $sp_config = config::get_instance();
    $_SP_CONF = $sp_config->get_config('staticpages');
}

// +---------------------------------------------------------------------------+
// | Plugin API - Services                                                     |
// +---------------------------------------------------------------------------+

include_once $plugin_path . 'services.inc.php';

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
 * Returns the items for this plugin that should appear on the main menu
 * NOTE: this MUST return the url/value pairs in the following format
 * $<arrayname>[<label>] = <url>
 */
function plugin_getmenuitems_staticpages()
{
    global $_CONF, $_TABLES, $_SP_CONF;

    $order = '';
    if (!empty($_SP_CONF['sort_menu_by'])) {
        $order = ' ORDER BY ';
        if ($_SP_CONF['sort_menu_by'] == 'date') {
            $order .= 'modified DESC';
        } elseif ($_SP_CONF['sort_menu_by'] == 'label') {
            $order .= 'sp_label';
        } elseif ($_SP_CONF['sort_menu_by'] == 'title') {
            $order .= 'sp_title';
        } else { // default to "sort by id"
            $order .= 'sp_id';
        }
    }

    $current_topic = TOPIC_currentTopic();
if (!empty($current_topic)) {
        $topic_sql = " AND (ta.tid = '{$current_topic}' OR ta.tid = '" . TOPIC_ALL_OPTION . "')";
    } else {
        if (COM_onFrontpage()) {
            $topic_sql = " AND (ta.tid = '" . TOPIC_HOMEONLY_OPTION . "' OR ta.tid = '" . TOPIC_ALL_OPTION . "')";
        } else {
            $topic_sql = " AND (ta.tid = '" . TOPIC_ALL_OPTION . "')";
        }
    }

    // Have to recheck for homeonly and all since the staticpage could be that
    $com_topic_sql = COM_getTopicSQL('', 0, 'ta');
    if ($com_topic_sql != "") {
        $topic_sql .= " AND (" . $com_topic_sql . "";

        if (COM_onFrontpage()) {
            $topic_sql .= " OR (ta.tid = '" . TOPIC_HOMEONLY_OPTION . "' OR ta.tid = '" . TOPIC_ALL_OPTION . "'))";
        } else {
            $topic_sql .= " OR ta.tid = '" . TOPIC_ALL_OPTION . "')";
        }
    }

    $sql = "SELECT sp.sp_id, sp.sp_label
        FROM {$_TABLES['staticpage']} sp, {$_TABLES['topic_assignments']} ta
        WHERE (sp.sp_onmenu = 1) AND (sp.draft_flag = 0) AND (sp.template_flag = 0)
        AND ta.type = 'staticpages' AND ta.id = sp_id $topic_sql
        " . COM_getPermSql('AND', 0, 2, 'sp') . COM_getLangSql('sp_id', 'AND', 'sp') . $order;

    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    $menuitems = array();
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $menuitems[$A['sp_label']] = COM_buildURL($_CONF['site_url']
            . '/staticpages/index.php?page=' . $A['sp_id']);
    }

    return $menuitems;
}

/**
 * Plugin should display [a] comment[s]
 *
 * @param   string  $id     Unique idenifier for item comment belongs to
 * @param   int     $cid    Comment id to display (possibly including sub-comments)
 * @param   string  $title  Page/comment title
 * @param   string  $order  'ASC' or 'DSC' or blank
 * @param   string  $format 'threaded', 'nested', or 'flat'
 * @param   int     $page   Page number of comments to display
 * @param   boolean $view   True to view comment (by cid), false to display (by $pid)
 * @return  mixed   results of calling the plugin_displaycomment_ function
 */
function plugin_displaycomment_staticpages($id, $cid, $title, $order, $format, $page, $view)
{
    global $_TABLES, $LANG_ACCESS, $LANG_STATIC;

    $retval = '';

    $sql = "SELECT COUNT(*) AS count, commentcode, owner_id, group_id, perm_owner, "
        . "perm_group, perm_members, perm_anon "
        . "FROM {$_TABLES['staticpage']} "
        . "WHERE (sp_id = '$id') AND (draft_flag = 0) AND (template_flag = 0)" . COM_getPermSQL('AND')
        . ' GROUP BY sp_id';
    $result = DB_query($sql);
    $A = DB_fetchArray($result);
    $allowed = $A['count'];

    if ($allowed == 1) {
        $delete_option = (SEC_hasRights('staticpages.edit') &&
            (SEC_hasAccess($A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon']) == 3));
        $retval .= CMT_userComments($id, $title, 'staticpages', $order, $format,
            $cid, $page, $view, $delete_option,
            $A['commentcode']);
    } else {
        $retval .= COM_showMessageText($LANG_STATIC['deny_msg'], $LANG_ACCESS['accessdenied']);
    }

    return $retval;
}

/**
 * Return the comment code to this plugin item. This is based not only the code of the actual plugin item but the access the user has to the item
 *
 * @param   string $id   Item id to which $cid belongs
 * @param   int    $uid  user id or 0 = current user
 * @return  int    Return a CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
 */
function plugin_commentenabled_staticpages($id, $uid = 0)
{
    global $_CONF, $_TABLES;

    // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
    $commentCode = COMMENT_CODE_DISABLED;

    $sql = "SELECT sp_id, commentcode, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon FROM {$_TABLES['staticpage']}";
    $sql .= " WHERE (template_flag = 0) AND sp_id = '" . DB_escapeString($id) . "' " . COM_getPermSQL('AND', $uid);
    if (!SEC_hasRights('staticpages.edit')) {
        $sql .= ' AND (draft_flag = 0)';
    }
    $result = DB_query($sql);
    $A = DB_fetchArray($result);
    if (DB_numRows($result) == 1 && TOPIC_hasMultiTopicAccess('staticpages', $id) > 0) { // Need read access of topics to post comment
        if ($A['commentcode'] == COMMENT_CODE_ENABLED) {
            $commentCode = COMMENT_CODE_ENABLED;
        } elseif ($A['commentcode'] == COMMENT_CODE_CLOSED) { // Closed but still visible so give admins access
            if (SEC_hasRights('staticpages.edit', 'AND', $uid) &&
                (SEC_hasAccess($A['owner_id'], $A['group_id'],
                        $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                        $A['perm_anon'], $uid) == 3)) {
                $commentCode = COMMENT_CODE_ENABLED; // If Admin then treat comment like enabled
            } else {
                $commentCode = COMMENT_CODE_CLOSED;
            }
        }
    }

    return $commentCode;
}

/**
 * Static Page saves a comment
 *
 * @param   string $title    comment title
 * @param   string $comment  comment text
 * @param   string $id       Item id to which $cid belongs
 * @param   int    $pid      comment parent
 * @param   string $postmode 'html' or 'text'
 * @return  mixed  false for failure, HTML string (redirect?) for success
 */
function plugin_savecomment_staticpages($title, $comment, $id, $pid, $postmode)
{
    global $_CONF, $_TABLES, $LANG03;

    $retval = '';

    // Use plugin_commentenabled_foo permission check to determine if user has permissions to save a comment for this item
    // CommentCode: COMMENT_CODE_ENABLED (0), COMMENT_CODE_DISABLED (-1), COMMENT_CODE_CLOSED (1)
    if (plugin_commentenabled_staticpages($id) != COMMENT_CODE_ENABLED) {
        COM_handle404($_CONF['site_url'] . '/index.php');
    }

    $ret = CMT_saveComment($title, $comment, $id, $pid, 'staticpages', $postmode);
    if (($ret > 0) || is_string($ret)) { // failure //FIXME: some failures should not return to comment form
        if (is_string($ret)) {
            $retval .= $ret;
        }

        $retval .= CMT_commentForm($title, $comment, $id, $pid, 'staticpages',
            $LANG03[14], $postmode);

        if (!defined('COMMENT_ON_SAME_PAGE')) {
            $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
        } else {
            if (!COMMENT_ON_SAME_PAGE) {
                $retval = COM_createHTMLDocument($retval, array('pagetitle' => $LANG03[1]));
            }
        }
    } else { // success
        $url = COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page='
            . $id);
        // if the comment ends up in the submission queue, say so
        if (($_CONF['commentsubmission'] == 1) &&
            !SEC_hasRights('comment.submit')
        ) {
            $url .= ($_CONF['url_rewrite'] ? '?' : '&') . 'msg=15';
        }
        COM_redirect($url);
    }

    return $retval;
}

/**
 * Comment Submission approved
 *
 * @param   string $id       Item id to which $cid belongs
 * @param   int     $cid    Approved Comment id
 */
function plugin_moderationcommentapprove_staticpages($id, $cid)
{
    // Nothing needed to do on approval of comment to plugin item

    return true;
}

/**
 * staticpages: delete a comment
 *
 * @param   int    $cid Comment to be deleted
 * @param   string $id  Item id to which $cid belongs
 * @param   boolean $returnOption  Either return a boolean on success or not, or redirect
 * @return  mixed        Based on $returnOption. false for failure or true for success, else a redirect for success or failure
 */
function plugin_deletecomment_staticpages($cid, $id, $returnBoolean)
{
    global $_CONF, $_TABLES, $_USER;

    $retval = false;

    $has_editPermissions = SEC_hasRights('staticpages.edit');
    $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['staticpage']} WHERE sp_id = '{$id}'");
    $A = DB_fetchArray($result);

    if ($has_editPermissions && SEC_hasAccess($A['owner_id'],
            $A['group_id'], $A['perm_owner'], $A['perm_group'],
            $A['perm_members'], $A['perm_anon']) == 3
    ) {
        CMT_deleteComment($cid, $id, 'staticpages');

        if ($returnBoolean) {
            $retval = true;
        } else {
            $url = COM_buildUrl($_CONF['site_url'] . '/staticpages/index.php?page='
                . $id);
            COM_redirect($url);
        }
    } else {
        COM_errorLog("User {$_USER['username']} (IP: " . \Geeklog\IP::getIPAddress() . ") "
            . "tried to illegally delete comment $cid from staticpage $id");

        if ($returnBoolean) {
            $retval = false;
        } else {
            COM_redirect($_CONF['site_url'] . '/index.php');
        }
    }

    return $retval;
}

/**
 * Did user create any pages
 *
 * @param    int     $uid
 * @return   string        number of pages user contributed. If nothing leave blank
 */
function plugin_usercontributed_staticpages($uid)
{
    global $_TABLES, $LANG_STATIC;

    $retval = '';

    $count = DB_getItem($_TABLES['staticpage'], 'COUNT(owner_id)', "owner_id = {$uid}");

    if ($count > 0) {
        $retval = str_replace('%s', $count, $LANG_STATIC['num_pages']);
    }

    return $retval;
}

/**
 * Helper function: Count static pages visible to the current user
 *
 * @return   int     number of pages
 */
function SP_countVisiblePages()
{
    global $_TABLES;

    $perms = SP_getPerms();
    if (!empty($perms)) {
        $perms = ' WHERE ' . $perms;
    }
    if (!SEC_hasRights('staticpages.edit')) {
        if (empty($perms)) {
            $perms .= ' WHERE';
        } else {
            $perms .= ' AND';
        }
        $perms .= ' (draft_flag = 0) AND (template_flag = 0)';
    }
    $result = DB_query("SELECT COUNT(*) AS cnt FROM {$_TABLES['staticpage']}" . $perms);
    $A = DB_fetchArray($result);

    return $A['cnt'];
}

/**
 * Prepare static page for display.
 *
 * @param    string $page          static page id
 * @param    array  $A             static page data
 * @param    string $comment_order sorting of comments
 * @param    string $comment_mode  comment mode (nested, flat, etc.)
 * @param    int    $comment_page
 * @param    int    $msg           optional message number
 * @param    string $query         optional search query string to highlight
 * @return   string                HTML for the static page
 */
function SP_displayPage($page, $A, $comment_order = 'ASC', $comment_mode = 'nested', $comment_page = 1, $msg = 0, $query = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG01, $LANG11, $LANG_STATIC, $_IMAGE_TYPE, $_SP_CONF;

    $retval = '';

    // get content
    $content = $A['sp_content'];
    if (!empty($query)) {
        $content = COM_highlightQuery($content, $query);
    }

    if ($A['sp_format'] === 'blankpage') {
        // The format is "blank page", only return the content of the page - nothing else.
        $retval = $content;
    } else {
        // The format is not "blank page", we need to do some more processing
        $sp_url = COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page=' . $page);
        $headerCode = '<link rel="canonical" href="' . $sp_url . '"' . XHTML . '>';

        // Meta Tags
        if ($_SP_CONF['meta_tags'] > 0) {
            $headerCode .= PHP_EOL . PLG_getMetaTags(
                    'staticpages', $page,
                    array(
                        array(
                            'name'    => 'description',
                            'content' => $A['meta_description'],
                        ),
                        array(
                            'name'    => 'keywords',
                            'content' => $A['meta_keywords'],
                        ),
                    )
                );
        }

        // Add hreflang link element if Multi Language Content is setup
        // Only allow hreflang link element to be visible when on canonical url
        // ie no second pages which can happen with comments or with extra trailing variables like from a search query
        if (strtolower(COM_getCurrentURL()) == strtolower($sp_url)) {
            $headerCode .= COM_createHREFLang('staticpages', $page);
        }

        // Previous and next pages
        $sp_prev = stripslashes($A['sp_prev']);
        if ($sp_prev !== '') {
            $headerCode .= PHP_EOL . sprintf(
                    '<link href="%s"%s>',
                    COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page=' . $sp_prev),
                    XHTML
                );
        }
        $sp_next = stripslashes($A['sp_next']);
        if ($sp_next !== '') {
            $headerCode .= PHP_EOL . sprintf(
                    '<link href="%s"%s>',
                    COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page=' . $sp_next),
                    XHTML
                );
        }

        $page_title = stripslashes($A['sp_page_title']);
        if (empty($page_title)) {
            $page_title = stripslashes($A['sp_title']);
        }

        if ($A['sp_format'] === 'allblocks' || $A['sp_format'] === 'leftblocks') {
            $what = 'menu';
        } else {
            $what = 'none';
        }
        if ($msg > 0) {
            $retval .= COM_showMessage($msg, 'staticpages');
        }

        $spage = COM_newTemplate(CTL_plugin_templatePath('staticpages'));
        $spage->set_file(array(
            'page'     => 'staticpage.thtml',
            'comments' => 'spcomments.thtml',
        ));

        $spage->set_var('sp_id', $page);

        if ($A['sp_inblock'] == 1) {
            $spage->set_var('block_start', COM_startBlock(stripslashes($A['sp_title']), $A['sp_help'],
                COM_getBlockTemplate('_staticpages_block', 'header')));
        }

        if (XHTML != '') {
            $spage->set_var('xmlns', ' xmlns="http://www.w3.org/1999/xhtml"');
        }

        $author_name = COM_getDisplayName($A['owner_id']);
        $author_username = DB_getItem($_TABLES['users'], 'username',
            "uid = {$A['owner_id']}");
        $spage->set_var('author_id', $A['owner_id']);
        $spage->set_var('author', $author_name);
        $spage->set_var('author_name', $author_name);
        $spage->set_var('author_username', $author_username);

        if ($A['owner_id'] > 1) {
            $profile_link = $_CONF['site_url']
                . '/users.php?mode=profile&amp;uid=' . $A['owner_id'];
            $authorNameTag = COM_getProfileLink($A['owner_id'], $author_username, $author_name, '', '');
            $spage->set_var('lang_author', $LANG_STATIC['author']);
            $spage->set_var('start_author_anchortag', $authorNameTag);
            $spage->set_var('end_author_anchortag', '');
            $spage->set_var('author_link', $authorNameTag);

            $photo = '';
            if ($_CONF['allow_user_photo']) {
                require_once $_CONF['path_system'] . 'lib-user.php';

                $photo = DB_getItem($_TABLES['users'], 'photo',
                    "uid = {$A['owner_id']}");
                $photo = USER_getPhoto($A['owner_id'], $photo);
                if (!empty($photo)) {
                    $spage->set_var('author_photo', $photo);
                    $camera_icon = '<img src="' . $_CONF['layout_url']
                        . '/images/smallcamera.' . $_IMAGE_TYPE
                        . '" alt=""' . XHTML . '>';
                    $spage->set_var('camera_icon',
                        COM_createLink($camera_icon, $profile_link));
                }
            }
            if (empty($photo)) {
                $spage->set_var('author_photo', '');
                $spage->set_var('camera_icon', '');
            }
        } else {
            $spage->set_var('start_author_anchortag', '');
            $spage->set_var('end_author_anchortag', '');
            $spage->set_var('author_link', $author_name);
        }

        if ($_CONF['hideprintericon'] == 0) {
            $icon_url = $_CONF['layout_url'] . '/images/print.' . $_IMAGE_TYPE;
			
			$attr = array();
			$attr['title'] = $LANG_STATIC['printable_format'];
			
			$icon_path = $_CONF['path_layout'] . '/images/print.' . $_IMAGE_TYPE;
			$sizeAttributes = COM_getImgSizeAttributes($icon_path, false);
			if (is_array($sizeAttributes)) {
				$attr['width'] = $sizeAttributes['width'];
				$attr['height'] = $sizeAttributes['height'];
			}			
            
            $printicon = COM_createImage($icon_url, $LANG01[65], $attr);
            $print_url = COM_buildURL($_CONF['site_url']
                . '/staticpages/index.php?page=' . $page
                . '&amp;disp_mode=print');
            $icon = COM_createLink($printicon, $print_url, array('rel' => 'nofollow'));
            $spage->set_var('printable_url', $print_url);
            $spage->set_var('print_icon', $icon);
        }
        if ((SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'],
                    $A['perm_group'], $A['perm_members'], $A['perm_anon']) == 3) &&
            SEC_hasRights('staticpages.edit')
        ) {
            $icon_url = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
			
			$attr = array();
			$attr['title'] = $LANG_STATIC['edit'];
			
			$icon_path = $_CONF['path_layout'] . '/images/edit.' . $_IMAGE_TYPE;
			$sizeAttributes = COM_getImgSizeAttributes($icon_path, false);
			if (is_array($sizeAttributes)) {
				$attr['width'] = $sizeAttributes['width'];
				$attr['height'] = $sizeAttributes['height'];
			}			
            
            $editiconhtml = COM_createImage($icon_url, $LANG_STATIC['edit'], $attr);
            $attr = array(
                'class' => 'editlink',
                'title' => $LANG_STATIC['edit'],
                'rel'   => 'nofollow',
            );
            $url = $_CONF['site_admin_url']
                . '/plugins/staticpages/index.php?mode=edit&amp;sp_id=' . $page;
            $icon = '&nbsp;'
                . COM_createLink(
                    $editiconhtml,  //display
                    $url,           //target
                    $attr           //other attributes
                );
            $spage->set_var('edit_icon', $icon);
        }

        if ($A['commentcode'] >= 0) {
            $delete_option = (SEC_hasRights('staticpages.edit') &&
            SEC_hasAccess($A['owner_id'], $A['group_id'],
                $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                $A['perm_anon']) == 3 ? true : false);
            require_once $_CONF['path_system'] . 'lib-comment.php';
            $spage->set_var('commentbar',
                CMT_userComments($page, $A['sp_title'], 'staticpages',
                    $comment_order, $comment_mode, 0, $comment_page, false,
                    $delete_option, $A['commentcode']));
        }

        $spage->set_var('content', $content);

        $spage->set_var('lastupdate', '');
        if ($_SP_CONF['show_date'] == 1 && $A['sp_onlastupdate'] == 1) {
            $curtime = COM_getUserDateTimeFormat($A['modified']);
            $lastupdate = $LANG_STATIC['lastupdated'] . ': ' . $curtime[0];
            $spage->set_var('lang_updated', $LANG_STATIC['lastupdated']);
            $spage->set_var('updated_date', $curtime[0]);
            $spage->set_var('lastupdate', $lastupdate);
        }

        $spage->set_var('hits', '');
        if ($_SP_CONF['show_hits'] == 1 && $A['sp_onhits'] == 1) {
            $num_hits = COM_numberFormat($A['sp_hits']);
            $hits = $LANG_STATIC['hits'] . ': ' . $num_hits;
            $spage->set_var('lang_hits', $LANG_STATIC['hits']);
            $spage->set_var('hits_number', $num_hits);
            $spage->set_var('sp_hits', $num_hits);
            $spage->set_var('hits', $hits);
        }

        // Call to plugins to set template variables
        PLG_templateSetVars('staticpage', $spage);

        if ($A['sp_inblock'] == 1) {
            $spage->set_var('block_end', COM_endBlock(COM_getBlockTemplate('_staticpages_block',
                'footer')));
        }

        $retval .= $spage->finish($spage->parse('output', 'page'));

        if (!isset($_USER['noboxes'])) {
            if (COM_isAnonUser()) {
                $_USER['noboxes'] = 0;
            } else {
                $_USER['noboxes'] = DB_getItem($_TABLES['user_attributes'], 'noboxes', "uid = '{$_USER['uid']}'");
            }
        }

        if (($A['sp_format'] == 'allblocks') && ($_USER['noboxes'] != 1)) {
            $rightblock = true;
        } elseif (($A['sp_format'] == 'leftblocks') ||
            ($A['sp_format'] == 'noblocks')
        ) {
            $rightblock = false;
        } else {
            $rightblock = -1;
        }

        $breadcrumbs = '';
        if (!$_SP_CONF['disable_breadcrumbs_staticpages']) {
            $breadcrumbs = TOPIC_breadcrumbs('staticpages', $page);
        }

        $retval = COM_createHTMLDocument($retval, array('what' => $what, 'pagetitle' => $page_title, 'breadcrumbs' => $breadcrumbs, 'headercode' => $headerCode, 'rightblock' => $rightblock));
    }

    return $retval;
}

/**
 * Prepare static page for print (i.e. display as "printable version").
 *
 * @param    string $page static page id
 * @param    array  $A    static page data
 * @return   string              HTML for the static page
 */
function SP_printPage($page, $A)
{
    global $_CONF, $_TABLES, $LANG01;

    $sp_url = COM_buildURL($_CONF['site_url']
        . '/staticpages/index.php?page=' . $page);

    $printableURL = COM_buildURL($_CONF['site_url']
        . '/staticpages/index.php?page=' . $page
        . '&amp;disp_mode=print');
		
    // $num_hits = COM_numberFormat($A['sp_hits']);

	$comments_with_count = "";
    if ($A['commentcode'] >= 0) {
        $commentsUrl = $sp_url . '#comments';
        $comments = DB_count($_TABLES['comments'],
            array('sid', 'type'), array($page, 'staticpages'));
        $numComments = COM_numberFormat($comments);

        if ($numComments > 1) {
            $comments_with_count = sprintf($LANG01[121], $numComments);
        } else {
            $comments_with_count = sprintf($LANG01[143], $numComments);
        }

        if ($comments > 0) {
            $comments_with_count = COM_createLink($comments_with_count,
                $commentsUrl);
        }
    }
	
	$itemTitle = "";
	$itemTitle = stripslashes($A['sp_title']);
	$itemByline = "";
	$itemModified = "";
	if ($A['sp_onlastupdate']) {
		$curtime = COM_getUserDateTimeFormat($A['modified']);
		$itemModified = sprintf($LANG01[6], $curtime[0]);
	}
	/*
	if ($_CONF['contributedbyline'] == 1) {
		$curtime = COM_getUserDateTimeFormat($A['created']);
		$authorname = COM_getDisplayName($A['owner_id']);
		$itemByline = sprintf($LANG01[5], $authorname, $curtime[0]);

	}			
	*/
	
	$display = COM_createHTMLPrintableDocument(
		$A['sp_content'],
		array(
			'itemURL'   	=> $sp_url,
			'printableURL'  => $printableURL,
			'itemtitle' 	=> $itemTitle,
			'itembyline' 	=> $itemByline,
			'itemmodified' 	=> $itemModified,
			'itemextras' 	=> $comments_with_count
		)
	);
	
	return $display;
}

/**
 * Prepare static page for display
 *
 * @param    string $page          static page id
 * @param    string $mode          type of display to return ('', 'print', 'autotag'
 * @param    string $comment_order sorting of comments
 * @param    string $comment_mode  comment mode (nested, flat, etc.)
 * @param    int    $comment_page
 * @param    int    $msg           optional message number
 * @param    string $query         optional search query string to highlight
 * @return   string                  HTML for the static page
 */
function SP_returnStaticpage($page = '', $mode = '', $comment_order = 'ASC', $comment_mode = 'nested', $comment_page = 1, $msg = 0, $query = '')
{
    global $_TABLES, $_USER;

    $retval = '';

    $args = array(
        'sp_id' => $page,
        'mode'  => $mode,
    );
    $svc_msg = array();

    if (PLG_invokeService('staticpages', 'get', $args, $output, $svc_msg) == PLG_RET_OK) {
        // Grab page id from database since some comparisons are case sensitive
        // and staticpage ids are not.
        $result = DB_query(
            "SELECT sp_id, owner_id FROM {$_TABLES['staticpage']} "
            . "WHERE (sp_id = '" . DB_escapeString($page) . "')"
        );

        if ($result !== false) {
            list ($page, $owner_id) = DB_fetchArray($result);
        } else {
            $owner_id = 0;
        }

        if ($mode === 'print') {
            $retval = SP_printPage($page, $output);
        } elseif ($mode === 'autotag') {
            // This allows for the autotag to be used within templates and return page templates
            if ($output['template_flag']  == 1) {
                $retval = $output['page_data'];
            } else {
                $retval = $output['sp_content'];
            }
        } else {
            $retval = SP_displayPage($page, $output, $comment_order, $comment_mode, $comment_page, $msg, $query);
        }

        // Increment hit counter for page, but don't count views for the author
        // of the page (feature request #0001572)
        if (COM_isAnonUser() || ($_USER['uid'] != $owner_id)) {
            DB_query(
                "UPDATE {$_TABLES['staticpage']} SET sp_hits = sp_hits + 1 "
                . "WHERE (sp_id = '" . DB_escapeString($page) . "')  "
                . "  AND (draft_flag = 0) AND (template_flag = 0) "
            );
        }
    }

    return $retval;
}

/**
 * Shows the statistics for the Static Pages plugin on stats.php.
 * If $showsitestats is 1 then we are to only print the overall stats in the
 * 'site statistics box' otherwise we show the detailed stats
 *
 * @param    int $showsitestats Flag to let us know which stats to get
 * @return   string
 */
function plugin_showstats_staticpages($showsitestats)
{
    global $_CONF, $_TABLES, $LANG_STATIC;

    $retval = '';

    $perms = SP_getPerms();
    if (!empty($perms)) {
        $perms = ' AND ' . $perms;
    }
    $result = DB_query("SELECT sp_id,sp_title,sp_page_title,sp_hits FROM {$_TABLES['staticpage']} WHERE (sp_hits > 0) AND (draft_flag = 0) AND (template_flag = 0)" . $perms . ' ORDER BY sp_hits DESC LIMIT 10');
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        require_once $_CONF['path_system'] . 'lib-admin.php';

        $header_arr = array(
            array('text'         => $LANG_STATIC['stats_page_title'],
                  'field'        => 'sid',
                  'header_class' => 'stats-header-title'),
            array('text'         => $LANG_STATIC['stats_hits'],
                  'field'        => 'sp_hits',
                  'header_class' => 'stats-header-count',
                  'field_class'  => 'stats-list-count'),
        );
        $data_arr = array();
        $text_arr = array('has_menu' => false,
                          'title'    => $LANG_STATIC['stats_headline'],
                          'form_url' => $_CONF['site_url'] . '/stats.php',
        );
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $A['sp_title'] = stripslashes(trim($A['sp_title']));
            if (empty($A['sp_title'])) {
                $A['sp_title'] = $A['sp_page_title'];
                if (empty($A['sp_title'])) {
                    $A['sp_title'] = $A['sp_id'];
                }
                $A['sp_title'] = '(' . $A['sp_title'] . ')';
            }
            $A['sid'] = COM_createLink($A['sp_title'],
                COM_buildUrl($_CONF['site_url']
                    . "/staticpages/index.php?page={$A['sp_id']}"));
            $A['sp_hits'] = COM_NumberFormat($A['sp_hits']);
            $data_arr[$i] = $A;
        }
        $retval .= ADMIN_simpleList("", $header_arr, $text_arr, $data_arr);
    } else {
        $retval .= COM_startBlock($LANG_STATIC['stats_headline']);
        $retval .= $LANG_STATIC['stats_no_hits'];
        $retval .= COM_endBlock();
    }

    return $retval;
}

/**
 * New stats plugin API function for proper integration with the site stats
 *
 * @return   array(item text, item count);
 */
function plugin_statssummary_staticpages()
{
    global $LANG_STATIC;

    $total_pages = SP_countVisiblePages();

    return array($LANG_STATIC['pages'], COM_numberFormat($total_pages));
}

/**
 * Geeklog is asking us to provide any new items that show up in the type
 * drop-down on search.php.  Let's let users search static pages!
 *
 * @return string
 */
function plugin_searchtypes_staticpages()
{
    global $LANG_STATIC, $_SP_CONF;

    if ($_SP_CONF['includesearch'] == 1) {
        $tmp['staticpages'] = $LANG_STATIC['pages'];

        return $tmp;
    } else {
        return '';
    }
}

/**
 * this searches for static pages matching the user query and returns an array of
 * for the header and table rows back to search.php where it will be formated and
 * printed
 *
 * @param    string $query     Keywords user is looking for
 * @param    date   $datestart Start date to get results for
 * @param    date   $dateend   End date to get results for
 * @param    string $topic     The topic they were searching in
 * @param    string $type      Type of items they are searching, or 'all' (deprecated)
 * @param    int    $author    Get all results by this author
 * @param    string $keyType   search key type: 'all', 'phrase', 'any'
 * @param    int    $page      page number of current search (deprecated)
 * @param    int    $perpage   number of results per page (deprecated)
 * @return   array
 */
function plugin_dopluginsearch_staticpages($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $_TABLES, $_DB_dbms, $LANG_STATIC, $LANG09, $_SP_CONF;

    if ($_SP_CONF['includesearch'] != 1) {
        return array();
    }

    // Make sure the query is SQL safe
    $query = trim(DB_escapeString($query));

    $sql = "SELECT sp.sp_id AS id, sp.sp_title AS title, sp.sp_content AS description, ";
    $sql .= "UNIX_TIMESTAMP(sp.created) AS date, sp.owner_id AS uid, sp.sp_hits AS hits, ";
    $sql .= "CONCAT('/staticpages/index.php?page=', sp.sp_id) AS url ";
    $sql .= "FROM {$_TABLES['staticpage']} AS sp,{$_TABLES['users']} AS u, {$_TABLES['topic_assignments']} ta ";
    $sql .= "WHERE (sp.owner_id = u.uid) AND (draft_flag = 0) AND (template_flag = 0) ";
    $sql .= "AND ta.type = 'staticpages' AND ta.id = sp.sp_id ";
    $sql .= COM_getPermSQL('AND') . COM_getLangSQL('sp_id', 'AND', 'sp') . ' ';

    // Topic Permissions
    $topic_perms = COM_getTopicSQL('', 0, 'ta');
    if ($topic_perms != '') {
        $topic_perms = " AND (" . $topic_perms . "";
        $topic_perms .= " OR (ta.tid = '" . TOPIC_HOMEONLY_OPTION . "' OR ta.tid = '" . TOPIC_ALL_OPTION . "'))";
    }
    $sql .= $topic_perms;

    if (!empty($author)) {
        $sql .= "AND (owner_id = '$author') ";
    }

    if (!empty($topic)) {
        // Retrieve list of inherited topics
        if ($topic == TOPIC_ALL_OPTION) {
            $sql .= "AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '" . TOPIC_ALL_OPTION . "') OR (ta.inherit = 0 AND ta.tid = '" . TOPIC_HOMEONLY_OPTION . "')) ";
        } else {
            $tid_list = TOPIC_getChildList($topic);
            $sql .= "AND (ta.tid IN('" . TOPIC_ALL_OPTION . "',{$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND (ta.tid = '" . $topic . "' OR ta.tid = '" . TOPIC_ALL_OPTION . "')))) ";
        }
    }

    // Search 0 = Excluded, 1 = Default, 2 = Included
    // SQL Default for regular pages
    $searchsql = "(search = 1 AND sp_centerblock = 0 AND sp_php = 0 AND template_id = '')";
	$searchsqlRemove  = '';
    if ($_SP_CONF['includesearchcenterblocks']) {
        $searchsql .= ' OR (sp_centerblock = 1 AND search = 1)';
    } else {
		// Make sure we fully remove center blocks
		// Since they could be included below since they can also be a template or have PHP
		$searchsqlRemove .= ' AND NOT (sp_centerblock = 1  AND search = 1)';
	}

    if ($_SP_CONF['includesearchphp']) {
        $searchsql .= ' OR (sp_php > 0 AND search = 1)';
    } else {
		// Make sure we fully remove php pages
		// Since they could be included below since they can also be a template or be a center block
		$searchsqlRemove .= ' AND NOT (sp_php > 0 AND search = 1)';
    }

    if ($_SP_CONF['includesearchtemplate']) {
        $searchsql .= " OR (template_id <> '' AND search = 1)";
    } else {
		// Make sure we fully remove template pages
		// Since they could be included above since they can also be a center block or have PHP
		$searchsqlRemove .= " AND NOT (template_id <> '' AND search = 1)";
    }
	// Include all pages marked include and add rest of search sql
    $sql .= " AND (search = 2 OR ($searchsql))$searchsqlRemove ";

    $search_p = new SearchCriteria('staticpages', $LANG_STATIC['pages']);

    $columns = array('title' => 'sp_title', 'sp_content');
    $sql .= $search_p->getDateRangeSQL('AND', 'created', $datestart, $dateend);
    list($sql, $ftsql) = $search_p->buildSearchSQL($keyType, $query, $columns, $sql);

    $sql .= " GROUP BY sp_id, sp_title, sp_content, created, owner_id, sp_hits";

    $search_p->setSQL($sql);
    $search_p->setFtSQL($ftsql);
    $search_p->setRank(3);
    $search_p->setURLRewrite(true);

    // Search static page comments
    $sql = "SELECT c.cid AS id, c.title AS title, c.comment AS description, ";
    $sql .= "UNIX_TIMESTAMP(c.date) AS date, c.uid AS uid, '0' AS hits, ";
    $sql .= "CONCAT('/comment.php?mode=view&amp;cid=',c.cid) AS url ";
    $sql .= "FROM {$_TABLES['users']} AS u, {$_TABLES['topic_assignments']} ta , {$_TABLES['comments']} AS c ";
    $sql .= "LEFT JOIN {$_TABLES['staticpage']} AS s ON ((s.sp_id = c.sid) ";
    $sql .= COM_getPermSQL('AND', 0, 2, 's') . COM_getLangSQL('sp_id', 'AND', 's') . ") ";
    $sql .= "WHERE (u.uid = c.uid) AND (s.draft_flag = 0) AND (s.template_flag = 0) AND (s.commentcode >= 0) AND (s.created <= NOW()) ";
    $sql .= "AND ta.type = 'staticpages' AND ta.id = s.sp_id ";

    // Topic Permissions
    $sql .= $topic_perms;

    if (!empty($author)) {
        $sql .= "AND (c.uid = '$author') ";
    }

    if (!empty($topic)) {
        if ($topic == TOPIC_ALL_OPTION) {
            $sql .= "AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '" . TOPIC_ALL_OPTION . "') OR (ta.inherit = 0 AND ta.tid = '" . TOPIC_HOMEONLY_OPTION . "')) ";
        } else {
            $sql .= "AND (ta.tid IN('" . TOPIC_ALL_OPTION . "',{$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND (ta.tid = '" . $topic . "' OR ta.tid = '" . TOPIC_ALL_OPTION . "')))) ";
        }
    }

    $search_c = new SearchCriteria('comments', array($LANG_STATIC['pages'], $LANG09[66]));

    $columns = array('title' => 'c.title', 'comment');
    $sql .= $search_c->getDateRangeSQL('AND', 'c.date', $datestart, $dateend);
    list($sql, $ftsql) = $search_c->buildSearchSQL($keyType, $query, $columns, $sql);

    $sql .= " GROUP BY c.cid, c.title, c.comment, c.date, c.uid ";

    $search_c->setSQL($sql);
    $search_c->setFtSQL($ftsql);
    $search_c->setRank(2);

    return array($search_p, $search_c);
}

/**
 * This will put an option for static pages in the command and control block on
 * moderation.php
 *
 * @return array|false
 */
function plugin_cclabel_staticpages()
{
    global $LANG_STATIC, $_CONF;

    if (SEC_hasRights('staticpages.edit,staticpages.delete', 'OR')) {
        return array($LANG_STATIC['staticpages'],
            $_CONF['site_admin_url'] . '/plugins/staticpages/index.php',
            plugin_geticon_staticpages());
    }

    return false;
}

/**
 * returns the administrative option for this plugin
 *
 * @return array
 */
function plugin_getadminoption_staticpages()
{
    global $_CONF, $_TABLES, $LANG_STATIC;

    if (SEC_hasRights('staticpages.edit,staticpages.delete', 'OR')) {
        $result = DB_query("SELECT COUNT(*) AS cnt FROM {$_TABLES['staticpage']}" . COM_getPermSQL('WHERE')); // COM_getPermSQL('WHERE', 0, 3));
        $A = DB_fetchArray($result);
        $total_pages = $A['cnt'];

        return array($LANG_STATIC['staticpages'], $_CONF['site_admin_url'] . '/plugins/staticpages/index.php', $total_pages);
    } else {
        return array();
    }
}

/**
 * Return SQL where statement with appropriate permissions
 * Takes User id and permission and returns SQL where clause which will return
 * the appropriate objects.
 * This assumes that the table has the following security structure:
 * owner_id        | mediumint(8)
 * group_id        | mediumint(8)
 * perm_owner      | tinyint(1) unsigned
 * perm_group      | tinyint(1) unsigned
 * perm_members    | tinyint(1) unsigned
 * perm_anon       | tinyint(1) unsigned
 * This will work with the standard GL tables
 *
 * @param    string $table  Table name (used in joins)
 * @param    int    $access Access if blank read access  2 = read 3 = read/edit
 * @param    int    $u_id   User ID if blank current user
 * @return   string          Where clause of sql statement
 */
function SP_getPerms($table = '', $access = 2, $u_id = 0)
{
    global $_USER, $_GROUPS;

    if ($table != '') {
        $table .= '.';
    }

    if (empty($u_id)) {
        if (isset ($_USER['uid'])) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }
        $GROUPS = $_GROUPS;
    } else {
        $uid = $u_id;
        $GROUPS = SEC_getUserGroups($uid);
    }

    $sql = '(';

    if ($uid > 1) {
        $sql .= "((owner_id = '{$uid}') AND (perm_owner >= $access)) OR ";

        $sql .= "((group_id IN (" . implode(',', $GROUPS) . ")) "
            . "AND (perm_group >= $access)) OR (perm_members >= $access)";
    } else {
        $sql .= "perm_anon >= $access";
    }

    $sql .= ')';

    return $sql;
}

/**
 * Display static pages in the center block.
 *
 * @param   int    $where where the static page will be displayed (0..3)
 * @param   int    $page  page number
 * @param   string $topic topic ID
 * @return          string   HTML for the static page (can be empty)
 */
function plugin_centerblock_staticpages($where = 1, $page = 1, $topic = '')
{
    global $_CONF, $_TABLES, $_SP_CONF, $LANG_STATIC, $_IMAGE_TYPE, $LANG01;

    $retval = '';

    if ($page > 1) {
        return $retval; // we only support page 1 at the moment ...
    }

    $moresql = "(sp_where = $where) AND ";
    $displayFeatured = false;

    // If there are no featured stories, we won't be called with $where == 2.
    // So, if asked to display pages for the top of the page, check if we
    // have pages to be displayed after the featured story and if there is
    // no featured story, display those pages as well.
    if (($where == 1) && ($_CONF['showfirstasfeatured'] == 0)) {
        if (DB_count($_TABLES['stories'], 'featured', 1) == 0) {
            // no featured story found - redefine $moresql
            $moresql = "(sp_where = 1 OR sp_where = 2) AND ";
            $displayFeatured = true;
        }
    }

    if (empty($topic)) {
        $moresql .= "((ta.tid = '" . TOPIC_HOMEONLY_OPTION . "') OR (ta.tid = '" . TOPIC_ALL_OPTION . "'))";
    } else {
        $moresql .= "((ta.tid = '{$topic}') OR (ta.tid = '" . TOPIC_ALL_OPTION . "'))";
    }

    if ($_SP_CONF['sort_by'] == 'date') {
        $sort = 'modified DESC';
    } elseif ($_SP_CONF['sort_by'] == 'title') {
        $sort = 'sp_title';
    } else { // default to "sort by id"
        $sort = 'sp_id';
    }
    if ($displayFeatured) {
        $sort = 'sp_where,' . $sort;
    }

    $perms = SP_getPerms();
    if (!empty($perms)) {
        $perms = ' AND ' . $perms;
    }
    $spsql = "SELECT sp_id,sp_title,sp_content,sp_onhits,sp_onlastupdate,sp_format,created,modified,sp_hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,sp_php,sp_inblock,sp_help
        FROM {$_TABLES['staticpage']}, {$_TABLES['topic_assignments']} ta
        WHERE (sp_centerblock = 1) AND (draft_flag = 0) AND (template_flag = 0)
        AND ta.type = 'staticpages' AND ta.id = sp_id
        " . COM_getLangSql('sp_id', 'AND') . ' AND ' . $moresql . $perms . " ORDER BY " . $sort;

    $result = DB_query($spsql);

    $pages = DB_numRows($result);
    if ($pages > 0) {
        for ($i = 0; $i < $pages; $i++) {
            $S = DB_fetchArray($result);

            if ($where == 0) {
                switch ($S['sp_format']) {
                    case 'noblocks':
                        $what = 'none';
                        break;

                    case 'allblocks':
                    case 'leftblocks':
                        $what = 'menu';
                        break;
                }

                $msg = (int) Geeklog\Input::fGet('msg', 0);
                $retval .= COM_showMessage($msg);
            }

            $spage = COM_newTemplate(CTL_plugin_templatePath('staticpages'));
            $spage->set_file(array('page' => 'centerblock.thtml'));

            if (($S['sp_inblock'] == 1) && !empty($S['sp_title'])
                && (($where != 0) || ($S['sp_format'] != 'blankpage'))
            ) {
                $spage->set_var('block_start', COM_startBlock($S['sp_title'], $S['sp_help'],
                    COM_getBlockTemplate('_staticpages_centerblock', 'header')));
            }

            if ($_CONF['hideprintericon'] == 0) {
                $icon_url = $_CONF['layout_url'] . '/images/print.' . $_IMAGE_TYPE;
				
				$attr = array();
				$attr['title'] = $LANG_STATIC['printable_format'];
				
				$icon_path = $_CONF['path_layout'] . '/images/print.' . $_IMAGE_TYPE;
				$sizeAttributes = COM_getImgSizeAttributes($icon_path, false);
				if (is_array($sizeAttributes)) {
					$attr['width'] = $sizeAttributes['width'];
					$attr['height'] = $sizeAttributes['height'];
				}				

                $printicon = COM_createImage($icon_url, $LANG01[65], $attr);
                $print_url = COM_buildURL($_CONF['site_url']
                    . '/staticpages/index.php?page=' . $S['sp_id']
                    . '&amp;disp_mode=print');
                $icon = COM_createLink($printicon, $print_url, array('rel' => 'nofollow'));
                $spage->set_var('print_icon', $icon);
            }
            if ((SEC_hasAccess($S['owner_id'], $S['group_id'], $S['perm_owner'],
                        $S['perm_group'], $S['perm_members'], $S['perm_anon']) == 3) &&
                SEC_hasRights('staticpages.edit')
            ) {
                $icon_url = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
				$icon_url = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
				
				$attr = array();
				$attr['title'] = $LANG_STATIC['edit'];
				
				$icon_path = $_CONF['path_layout'] . '/images/edit.' . $_IMAGE_TYPE;
				$sizeAttributes = COM_getImgSizeAttributes($icon_path, false);
				if (is_array($sizeAttributes)) {
					$attr['width'] = $sizeAttributes['width'];
					$attr['height'] = $sizeAttributes['height'];
				}				
				
                $editiconhtml = COM_createImage($icon_url, $LANG_STATIC['edit'],
                    $attr);
                $url = $_CONF['site_admin_url']
                    . '/plugins/staticpages/index.php?mode=edit&amp;sp_id=' . $S['sp_id'];
                $attr = array(
                    'class' => 'editlink',
                    'title' => $LANG_STATIC['edit'],
                    'rel'   => 'nofollow',
                );
                $icon = '&nbsp;'
                    . COM_createLink(
                        $editiconhtml,  //display
                        $url,           //target
                        $attr           //other attributes
                    );
                $spage->set_var('edit_icon', $icon);
            }

            $spage->set_var('lastupdate', '');
            if ($_SP_CONF['show_date'] == 1 && $S['sp_onlastupdate'] == 1) {
                $curtime = COM_getUserDateTimeFormat($S['modified']);
                $lastupdate = $LANG_STATIC['lastupdated'] . ': ' . $curtime[0];
                $spage->set_var('lang_updated', $LANG_STATIC['lastupdated']);
                $spage->set_var('updated_date', $curtime[0]);
                $spage->set_var('lastupdate', $lastupdate);

            }

            $spage->set_var('hits', '');
            if ($_SP_CONF['show_hits'] == 1 && $S['sp_onhits'] == 1) {
                $num_hits = COM_numberFormat($S['sp_hits']);
                $hits = $LANG_STATIC['hits'] . ': ' . $num_hits;
                $spage->set_var('lang_hits', $LANG_STATIC['hits']);
                $spage->set_var('hits_number', $num_hits);
                $spage->set_var('sp_hits', $num_hits);
                $spage->set_var('hits', $hits);
            }

            $SP_retval = array();
            $mode = '';
            $args = array(
                'sp_id' => $S['sp_id'],
                'mode'  => $mode,
            );
            $svc_msg = array();

            if (PLG_invokeService('staticpages', 'get', $args, $SP_retval, $svc_msg) == PLG_RET_OK) {
                $content = $SP_retval['sp_content'];
            }

            $spage->set_var('content', $content);

            if (($S['sp_inblock'] == 1) && !empty($S['sp_title']) &&
                (($where != 0) || ($S['sp_format'] != 'blankpage'))
            ) {
                $spage->set_var('block_end', COM_endBlock(COM_getBlockTemplate('_staticpages_centerblock', 'footer')));
            }

            $retval .= $spage->finish($spage->parse('output', 'page'));

            if ($where == 0) {
                if ($S['sp_format'] == 'allblocks') {
                    $rightblock = true;
                } elseif ($S['sp_format'] != 'blankpage') {
                    $rightblock = -1;
                }

                if ($S['sp_format'] != 'blankpage') {
                    $retval = COM_createHTMLDocument($retval, array('what' => $what, 'rightblock' => $rightblock));
                }
            }

            // increment hit counter for page
            DB_query("UPDATE {$_TABLES['staticpage']} SET sp_hits = sp_hits + 1 WHERE (sp_id = '{$S['sp_id']}') AND (draft_flag = 0) AND (template_flag = 0)");
        }
    }

    return $retval;
}

/**
 * A user is about to be deleted. Update ownership of any static pages owned
 * by that user or delete them.
 *
 * @param  int $uid User id of deleted user
 */
function plugin_user_delete_staticpages($uid)
{
    global $_TABLES, $_SP_CONF;

    if (DB_count($_TABLES['staticpage'], 'owner_id', $uid) == 0) {
        return;
    }

    // Figure out root user
    $rootgroup = DB_getItem($_TABLES['groups'], 'grp_id',
        "grp_name = 'Root'");
    $result = DB_query("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
    $A = DB_fetchArray($result);
    $rootuser = $A['ug_uid'];

    if ($_SP_CONF['delete_pages'] == 1) {
        // delete the pages for the user if able

        $sql = "SELECT sp_id FROM {$_TABLES['staticpage']} WHERE owner_id = $uid";

        $result = DB_query($sql);
        $nrows = DB_numRows($result);

        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);

            $args = array(
                'sp_id' => $A['sp_id'],
            );
            if (PLG_RET_OK != PLG_invokeService('staticpages', 'delete', $args, $display, $svc_msg)) {
                // Couldn't delete for some reason (security, page is a template being used, etc)
                // Can't stop user delete so assign new ownership to page
                DB_query("UPDATE {$_TABLES['staticpage']} SET owner_id = $rootuser WHERE sp_id = '{$A['sp_id']}'");
            }
        }
    } else {
        // assign ownership to a user from the Root group

        DB_query("UPDATE {$_TABLES['staticpage']} SET owner_id = $rootuser WHERE owner_id = $uid");
    }
}

/**
 * Return the current version of code.
 * Used in the Plugin Editor to show the registered version and code version
 */
function plugin_chkVersion_staticpages()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/staticpages/autoinstall.php';

    $inst_parms = plugin_autoinstall_staticpages('staticpages');

    return $inst_parms['info']['pi_version'];
}

/**
 * Implements the [staticpage:] autotag. (and [page:])
 *
 * @param  string $op
 * @param  string $content
 * @param  array  $autotag
 * @return string|array
 * @throws InvalidArgumentException
 */
function plugin_autotags_staticpages($op, $content = '', $autotag = array())
{
    global $_CONF, $_TABLES, $_SP_CONF, $LANG_STATIC, $_GROUPS;

    static $recursive = array();

    // Note as of Geeklog v2.2.1 added short version of staticpage autotags (staticpage = page and staticpage_content = page_content)
    // At some point we should depreciate staticpage and staticpage_content autotag name or at least hide the descriptions
    if ($op == 'tagname') {
        return array('staticpage', 'staticpage_content', 'page', 'page_content');
    } elseif ($op == 'permission' || $op == 'nopermission') {
        $flag = ($op == 'permission');
        $tagnames = array();

        if (isset($_GROUPS['Static Page Admin'])) {
            $group_id = $_GROUPS['Static Page Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                "grp_name = 'Static Page Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();
        $p = 'autotag_permissions_staticpage_content';
        if (COM_getPermTag($owner_id, $group_id,
                $_SP_CONF[$p][0], $_SP_CONF[$p][1],
                $_SP_CONF[$p][2], $_SP_CONF[$p][3]) == $flag
        ) {
            $tagnames[] = 'staticpage_content';
            $tagnames[] = 'page_content';
        }
        $p = 'autotag_permissions_staticpage';
        if (COM_getPermTag($owner_id, $group_id,
                $_SP_CONF[$p][0], $_SP_CONF[$p][1],
                $_SP_CONF[$p][2], $_SP_CONF[$p][3]) == $flag
        ) {
            $tagnames[] = 'staticpage';
            $tagnames[] = 'page';
        }

        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'description') {
        return array(
            'staticpage'         => $LANG_STATIC['autotag_desc_staticpage'],
            'staticpage_content' => $LANG_STATIC['autotag_desc_staticpage_content'],
            'page'         => $LANG_STATIC['autotag_desc_page'],
            'page_content' => $LANG_STATIC['autotag_desc_page_content'],
        );
    } elseif ($op == 'parse') {
        if ($autotag['tag'] == 'staticpage' || $autotag['tag'] == 'page') {
            $sp_id = COM_applyFilter($autotag['parm1']);
            $sp_id = COM_switchLanguageIdForObject($sp_id);
            if (!empty($sp_id)) {
                $result = DB_query("SELECT COUNT(*) AS count "
                    . "FROM {$_TABLES['staticpage']} "
                    . "WHERE sp_id = '$sp_id'");
                $A = DB_fetchArray($result);
                if ($A['count'] > 0) {
                    $url = COM_buildURL($_CONF['site_url']
                        . '/staticpages/index.php?page=' . $sp_id);
                    if (empty($autotag['parm2'])) {
                        $linktext = stripslashes(DB_getItem($_TABLES['staticpage'],
                            'sp_title', "sp_id = '$sp_id'"));
                    } else {
                        $linktext = $autotag['parm2'];
                    }
                    $link = COM_createLink($linktext, $url);
                    $content = str_replace($autotag['tagstr'], $link, $content);
                }
            }
        } elseif ($autotag['tag'] == 'staticpage_content' || $autotag['tag'] == 'page_content') {
            $sp_id = COM_applyFilter($autotag['parm1']);
            $sp_id = COM_switchLanguageIdForObject($sp_id);
            if (!empty($sp_id)) {
                $result = DB_query("SELECT COUNT(*) AS count "
                    . "FROM {$_TABLES['staticpage']} "
                    . "WHERE sp_id = '$sp_id'");
                $A = DB_fetchArray($result);
                if ($A['count'] > 0) {
                    if (isset($recursive[$sp_id])) {
                        $content = '';
                    } else {
                        $recursive[$sp_id] = true;
                        $sp_content = SP_returnStaticpage($sp_id, 'autotag');
                        $content = str_replace($autotag['tagstr'], $sp_content,
                            $content);
                        unset($recursive[$sp_id]);
                    }
                }
            }
        }

        return $content;
    } elseif ($op === 'closetag') {
        return array();
    } else {
        throw new InvalidArgumentException('Bad argument for "$op"');
    }
}

/**
 * Returns the URL of the plugin's icon
 *
 * @return   string      URL of the icon
 */
function plugin_geticon_staticpages()
{
    global $_CONF;

    return $_CONF['site_url'] . '/staticpages/images/staticpages.png';
}

/**
 * Update the Static Pages plugin
 *
 * @return   int     Number of message to display (true = generic success msg)
 */
function plugin_upgrade_staticpages()
{
    global $_CONF, $_TABLES, $_DB_dbms;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'staticpages'");
    $code_version = plugin_chkVersion_staticpages();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/staticpages/autoinstall.php';

    if (!plugin_compatible_with_this_version_staticpages('staticpages')) {
        return 3002;
    }

    // Retrieve other plugin info like min geeklog version and homepage
    $inst_parms = plugin_autoinstall_staticpages('staticpages');

    require_once $_CONF['path'] . 'plugins/staticpages/sql/'
        . $_DB_dbms . '_updates.php';

    require_once $_CONF['path'] . 'plugins/staticpages/install_updates.php';

    $current_version = $installed_version;
    $done = false;
    $current_config = false;
    while (!$done) {
        switch ($current_version) {
            case '1.4.3':
                $plugin_path = $_CONF['path'] . 'plugins/staticpages/';
                require_once $plugin_path . 'install_defaults.php';

                if (file_exists($plugin_path . 'config.php')) {
                    global $_DB_table_prefix, $_SP_CONF;

                    require_once $plugin_path . 'config.php';
                }

                if (!plugin_initconfig_staticpages()) {
                    echo 'There was an error upgrading the Static Pages plugin';

                    return false;
                }

                if (isset($_UPDATES, $_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }
                $current_config = true;

                $current_version = '1.5.0';
                break;

            case '1.5.0':
                // no db changes
                $current_version = '1.5.1';
                break;

            case '1.5.1':
                // no db changes
                $current_version = '1.6.0';
                break;

            case '1.6.0':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                if (!$current_config) {
                    SP_update_ConfValues_1_6_0();
                }

                $current_version = '1.6.1';
                break;

            case '1.6.1':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                if (!$current_config) {
                    SP_update_ConfValues_1_6_1();
                }

                $current_version = '1.6.2';
                break;

            case '1.6.2':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                $current_version = '1.6.3';
                break;

            case '1.6.3':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                if (!$current_config) {
                    // Update to Config Tables must be performed here and not in regualar SQL update array since if config is current then they shouldn't be run
                    // Set new Tab column to whatever fieldset is
                    $sql = "UPDATE {$_TABLES['conf_values']} SET tab = fieldset WHERE group_name = 'staticpages'";
                    DB_query($sql);

                    SP_update_ConfValues_1_6_3();
                }

                SP_update_ConfigSecurity_1_6_3();

                $current_version = '1.6.4';
                break;

            case '1.6.4':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                if (!$current_config) {
                    SP_update_ConfValues_1_6_4();
                }

                SP_update_TopicAssignmentsFor_1_6_4();

                $current_version = '1.6.5';
                break;

            case '1.6.5':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                // Give "filemanager.admin" feature to Static Page Admin
                if (DB_count($_TABLES['features'], 'ft_name', 'filemanager.admin') == 1) {
                    $featureId = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'filemanager.admin' ");
                    $staticPageAdminId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin' ");
                    DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$featureId}, {$staticPageAdminId}) ");
                }

                SP_update_ConfValues_1_6_5();

                $current_version = '1.6.6';
                break;

            case '1.6.6':
                $current_version = '1.6.7';
                break;

            case '1.6.7':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                $current_version = '1.6.8';
                break;
            case '1.6.8':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                $current_version = '1.6.9';
                break;

            case '1.6.9':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                SP_update_ConfValues_1_7_0();

                $current_version = '1.7.0';
                break;

            case '1.7.0':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }

                staticpages_update_ConfValues_1_7_1();

                staticpages_update_search_cache_1_7_1();

                staticpages_addStructuredDataSecurityRight_1_7_1();

                $current_version = '1.7.1';
                break;

            case '1.7.1':
                if (isset($_UPDATES[$current_version])) {
                    $_SQL = $_UPDATES[$current_version];
                    foreach ($_SQL as $sql) {
                        DB_query($sql);
                    }
                }
                staticpages_update_ConfValues_1_7_2();

                $current_version = '1.7.2';
                break;

            case '1.72':
                $current_version = '1.7.3'; // Ships with Geeklog v2.2.2
                break;

            default:
                $done = true;
        }
    }

    // update plugin version number and other info
    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '{$inst_parms['info']['pi_gl_version']}', pi_homepage = '{$inst_parms['info']['pi_homepage']}' WHERE pi_name = 'staticpages'");

    COM_errorLog( "Updated staticpages plugin from v$installed_version to v$code_version", 1 );

    return true;
}

/**
 * Called during site migration - handle changed URLs or paths
 *
 * @param    array $old_conf contents of the $_CONF array on the old site
 * @return   boolean             true on success, otherwise false
 */
function plugin_migrate_staticpages($old_conf)
{
    global $_CONF;

    $tables = array(
        'staticpage' => 'sp_id, sp_content',
    );

    if ($old_conf['site_url'] != $_CONF['site_url']) {
        Installer::updateSiteUrl($old_conf['site_url'], $_CONF['site_url'], $tables);
    }

    COM_errorLog('Successfully migrated the "staticpages" plugin');

    return true;
}

/**
 * Automatic uninstall function for plugins
 *
 * @return   array
 * This code is automatically uninstalling the plugin.
 * It passes an array to the core code function that removes
 * tables, groups, features and php blocks from the tables.
 * Additionally, this code can perform special actions that cannot be
 * foreseen by the core code (interactions with other plugins for example)
 */
function plugin_autouninstall_staticpages()
{

    // Delete multi-language support Core Config option for Staticpage Plugin
    $c = config::get_instance();
    $c->del('langurl_staticpages', 'Core');

    $out = array(
        /* give the name of the tables, without $_TABLES[] */
        'tables'     => array('staticpage'),
        /* give the full name of the group, as in the db */
        'groups'     => array('Static Page Admin', // correct Admin group name
            'Static Pages Admin' // typo in Geeklog 1.6.0
        ),
        /* give the full name of the feature, as in the db */
        'features'   => array('staticpages.edit',
            'staticpages.delete',
            'staticpages.PHP',
            'config.staticpages.tab_main',
            'config.staticpages.tab_whatsnew',
            'config.staticpages.tab_search',
            'config.staticpages.tab_permissions',
            'config.staticpages.tab_autotag_permissions'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array('phpblock_calendar'),
        /* give all vars with their name */
        'vars'       => array(),
    );

    return $out;
}

function plugin_getListField_staticpages($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_ACCESS, $LANG_STATIC, $_TABLES;

    $retval = '';

    $access = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']);

    switch ($fieldname) {
        case 'edit':
            if ($access == 3) {
                $retval = COM_createLink($icon_arr['edit'],
                    "{$_CONF['site_admin_url']}/plugins/staticpages/index.php?mode=edit&amp;sp_id={$A['sp_id']}");
            }
            break;

        case 'copy':
            if ($access == 3) {
                $retval = COM_createLink($icon_arr['copy'],
                    "{$_CONF['site_admin_url']}/plugins/staticpages/index.php?mode=clone&amp;sp_id={$A['sp_id']}");
            }
            break;

        case 'access':
            if ($access == 3) {
                $retval = $LANG_ACCESS['edit'];
            } else {
                $retval = $LANG_ACCESS['readonly'];
            }
            break;

        case 'draft_flag':
            if ($A['draft_flag'] == 1) {
                $retval = $LANG_STATIC['draft_yes'];
            } else {
                $retval = $LANG_STATIC['draft_no'];
            }
            break;

        case 'sp_title':
            $sp_title = trim(stripslashes($A['sp_title']));
            if (empty($sp_title)) {
                $sp_title = $A['sp_page_title'];
                if (empty($sp_title)) {
                    $sp_title = $A['sp_id'];
                }
                $sp_title = '(' . $sp_title . ')';
            }
            $url = COM_buildURL($_CONF['site_url'] .
                '/staticpages/index.php?page=' . $A['sp_id']);
            $attr = array();
            if (!empty($A['sp_page_title'])) {
                $attr['title'] = htmlspecialchars($A['sp_page_title']);
            }
            $retval = COM_createLink($sp_title, $url, $attr);
            break;

        case 'username':
        case 'fullname':
            $retval = COM_getDisplayName($A['owner_id'], $A['username'],
                $A['fullname']);
            break;

        case 'sp_centerblock':
            if ($A['sp_centerblock']) {
                switch ($A['sp_where']) {
                    case '1':
                        $where = $LANG_STATIC['centerblock_top'];
                        break;
                    case '2':
                        $where = $LANG_STATIC['centerblock_feat'];
                        break;
                    case '3':
                        $where = $LANG_STATIC['centerblock_bottom'];
                        break;
                    default:
                        $where = $LANG_STATIC['centerblock_entire'];
                        break;
                }
                $retval = $where;
            } else {
                $retval = $LANG_STATIC['centerblock_no'];
            }
            break;

        case 'template_id':
            if ($A['template_id']) {
                // Find name of template and see if have access to it
                $result = DB_query("SELECT * FROM {$_TABLES['staticpage']} WHERE sp_id = '{$A['template_id']}'" . COM_getPermSQL('AND'));
                if (DB_numRows($result)) {
                    $B = DB_fetchArray($result);
                    $access = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']);
                    $sp_title = trim(stripslashes($B['sp_title']));
                    if (empty($sp_title)) {
                        $sp_title = $B['sp_page_title'];
                        if (empty($sp_title)) {
                            $sp_title = $B['sp_id'];
                        }
                        $sp_title = '(' . $sp_title . ')';
                    }

                    $url = COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page=' . $B['sp_id']);
                    $attr = array();
                    if (!empty($B['sp_page_title'])) {
                        $attr['title'] = htmlspecialchars($B['sp_page_title']);
                    }
                    $retval = COM_createLink($sp_title, $url, $attr);
                    if ($access == 3) {
                        $retval .= ' ' . COM_createLink($icon_arr['edit'], "{$_CONF['site_admin_url']}/plugins/staticpages/index.php?mode=edit&amp;sp_id={$B['sp_id']}");
                    }

                } else {
                    // Assume no access, This will create an issue if they edit the staticpage

                }

            } else {
                // Check to see if actually a template
                if ($A['template_flag']) {
                    $result = DB_query("SELECT count(template_id) num_temp FROM {$_TABLES['staticpage']} WHERE template_id = '{$A['sp_id']}'"); // . COM_getPermSQL('AND', 0, 3));
                    if (DB_numRows($result)) {
                        $B = DB_fetchArray($result);
                        $desc = sprintf($LANG_STATIC['used_by'], $B['num_temp']);
                        $retval = COM_getTooltip($LANG_STATIC['yes'], $desc);
                    }
                } else {
                    $retval = '';
                }
            }
            break;

        case 'unixdate':
            $retval = COM_strftime($_CONF['daytime'], $A['unixdate']);
            break;

        default:
            $retval = $fieldvalue;
            break;
    }

    return $retval;
}

/**
 * Render the actual content of a static page (without any surrounding blocks)
 *
 * @param    array  $A
 * @return   string                  rendered content (HTML)
 */
function SP_render_content($A)
{
    global $_CONF, $_SP_CONF, $LANG_STATIC, $_STRUCT_DATA, $_TABLES;

    $retval = '';

    $sp_id = $A['sp_id'];
    $sp_url = COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page=' . $sp_id);
    $sp_content = $A['sp_content'];
    $page_data = $A['page_data'];
    $sp_php = $A['sp_php'];
    $structured_data_type = $A['structured_data_type'];
    $draft_flag = $A['draft_flag'];
    $cache_time = $A['cache_time'];
    $template_id = $A['template_id'];

    // Retrieve non php staticpage from cache
	if (($cache_time > 0 || $cache_time == -1) AND !$draft_flag) {
        $cache_found = false;

        // Don't need to cache per theme since not rendered in a block yet
        $cacheInstance = 'staticpage__' . $sp_id . '__' . CACHE_security_hash();
        $retval = CACHE_check_instance($cacheInstance);
        if ($retval && $cache_time == -1) {
            $cache_found = true;
        } elseif ($retval && $cache_time > 0) {
            $lu = CACHE_get_instance_update($cacheInstance);
            $now = time();
            if (($now - $lu) < $cache_time) {
                $cache_found = true;
            } else {
                $retval = '';
            }
        }

        // Now find structured data cache if required
        // Structured Data is cached by itself. Need to cache in case structured data autotags exist in page.
        // Since autotags are executed when the page is rendered therefore we have to cache structured data if page is cached.
        if (!empty($structured_data_type) && $cache_found) {
            if (!$_STRUCT_DATA->get_cachedScript('staticpages', $sp_id, $cache_time)) {
                // Structured Data missing for some reason even though page cache found. Render all again
                $retval = '';
            } else {
                return $retval;
            }
        } elseif ($cache_found) {
            return $retval;
        }

    }

    // See if uses template, if so get it
    if ($template_id != '') {
        $retval = '';
        $mode = '';

        // suppress warnings on loading xml document so we can fail gracefully if need be
        libxml_use_internal_errors(true);
        // Load xml staticpage document
        $xmlObject = simplexml_load_string($page_data);

        if ($xmlObject === false) {
            // Error happened when try to load data so xml not setup correctly
            //$errors = libxml_get_errors();
            //print_r($errors);
            // This is important enough to write to the error log
            COM_errorLog("Page ID: $sp_id has an error in it's XML formatting. It uses the page ID: $template_id as it's template.", 1);
        } else {
            // create array of XML data
            $tag = array();
            foreach ($xmlObject->variable as $variable) {
                $key = $variable["name"] . '';
                $value = $variable->data;
                $tag[$key] = $value;
            }

            // Loop through variables to replace any autotags first
            foreach ($tag as &$value) {
                $value = PLG_replaceTags($value, '', false, 'staticpages', $sp_id);
            }
            unset($value);

            $args = array(
                'sp_id'    => $template_id,
                'mode'     => $mode,
                'template' => true, // tells service that it is okay to retrieve a template staticpage since requested by another staticpage
                'gl_svc'   => '',
            );
            $svc_msg = array();

            if (PLG_invokeService('staticpages', 'get', $args, $output, $svc_msg) == PLG_RET_OK) {

                // Need to do below twice for backwards compatibility with pre Staticpage plugin v1.6.8 way of handling templates
                // Reason is in case [staticpage_content: autotag is in staticpage template page variable which is used to load staticpage within staticpage template.
                // This staticpage may be a template and have may have template variables as well which we need to compile
                for ($i = 1; $i <= 2; $i++) { // only do for 2 levels (this could become a setting of how deep to check for each staticpage which uses a template???)
                    // Treat as normal staticpage template but really just want to use a view and load no files
                    $sp_template = COM_newTemplate(CTL_plugin_templatePath('staticpages'));
                    $sp_template->set_view(array(
                        'page_view' => $output['page_data'],
                    ));

                    // Staticpage specific template variables
                    // Set Staticpage Title
                    $sp_template->set_var('sp_title', stripslashes($A['sp_title']));
                    // ISO 8601 dates for created and modified
                    $sp_template->set_var('sp_created', date('c', strtotime($A['created'])));
                    $sp_template->set_var('sp_updated', date('c', strtotime($A['modified'])));

                    // Add all the staticpage variables as template variables now
                    foreach ($tag as $key => $value) {
                        $sp_template->set_var($key, $value);
                    }

                    $output['page_data'] = $sp_template->finish($sp_template->parse('output', 'page_view'));
                }

                /* Old way of applying variables left for bug checking (Staticpage plugin v1.6.8, Geeklog v2.1.2)
                $retval['sp_content'] = str_replace(array_keys($tag), array_values($tag), $retval['sp_content']);
                // Remove any unknown staticpage template variables as long as they use the curly brackets ie {templatevariable}
                // If template variable format is different then any unused ones will display
                $retval['sp_content'] = preg_replace('/{[^ \t\r\n}]+}/', '', $retval['sp_content']);
                */
                $sp_content = $output['page_data'];
            }
        }
    }

    if ($_SP_CONF['allow_php'] == 1) {
        // Check for type (ie html or php)
        if ($sp_php != 0) {
            $retarray = COM_handleEval($page_data, $sp_php);
            $sp_content = $retarray['output'];
        }
        $sp_content = PLG_replaceTags($sp_content, '', false, 'staticpages', $sp_id);
    } else {
        if ($sp_php != 0) {
            COM_errorLog("PHP in static pages is disabled. Can not display page.", 1);
            $sp_content = $LANG_STATIC['deny_msg'];
        } else {
            $sp_content = PLG_replaceTags($sp_content, '', false, 'staticpages', $sp_id);
        }
    }

    $sp_content = stripslashes($sp_content);

    // Figure out structured data if need be
    if (!empty($structured_data_type)) {
        $properties['headline'] = $A['sp_title'];
        $properties['url'] = $sp_url;
        $properties['datePublished'] = $A['created'];
        $properties['dateModified'] = $A['modified'];
        $properties['description'] = $A['meta_description'];
        $properties['keywords'] = $A['meta_keywords'];
        if ($A['commentcode'] >= 0) {
            require_once $_CONF['path_system'] . 'lib-comment.php';
            $properties['commentCount'] = CMT_commentCount($sp_id, 'staticpages');
        }
        $properties['author']['name'] = COM_getDisplayName($A['owner_id']);
        if (!USER_isBanned($A['owner_id'])) {
            $properties['author']['url'] = $_CONF['site_url'] . '/users.php?mode=profile&amp;uid=' . $A['owner_id'];
        }

        $attributes['multi_language'] = true;
        // Since staticpage can be cached and autotags within content may insert structured data properties need to cache structured data info as well.
        if (($cache_time > 0 || $cache_time == -1) AND !$draft_flag) {
            $attributes['cache'] = true;
        }
        $_STRUCT_DATA->add_type('staticpages', $sp_id, $structured_data_type, $properties, $attributes);

        /* Decided not to included structure data right by page content even though slightly faster. Rather keep all structured data in the head
        // Cache structured data results with staticpage cache
        if (($cache_time > 0 || $cache_time == -1) && $sp_php == 0) {
            $sp_structureddata = $_STRUCT_DATA->toScript('staticpages', $sp_id);
            $sp_content = $sp_structureddata . $sp_content;
        }
        */
    }


    if (($cache_time > 0 || $cache_time == -1) AND !$draft_flag) {
        CACHE_create_instance($cacheInstance, $sp_content);

        // Also update search cache for pages that use templates at this point
        if ($template_id != '' OR $sp_php) {
            $search_sp_content = DB_escapeString($sp_content);
            $sql = "UPDATE {$_TABLES['staticpage']} SET sp_content = '$search_sp_content' WHERE sp_id = '$sp_id'";
            $result = DB_query($sql);
        }
    }

    return $sp_content;
}

/**
 * Return true since this plugin supports webservices
 *
 * @return  boolean     True, if webservices are supported
 */
function plugin_wsEnabled_staticpages()
{
    return true;
}

/**
 * Return headlines for New Static Pages section in the What's New block, if enabled
 *
 * @return   mixed       array(headline, byline), or boolean false if disabled
 */
function plugin_whatsnewsupported_staticpages()
{
    global $_SP_CONF, $LANG_STATIC, $LANG_WHATSNEW;

    if ($_SP_CONF['hidenewstaticpages'] == 'hide') {
        $retval = false;
    } else {
        $retval = array($LANG_STATIC['pages'],
            COM_formatTimeString($LANG_WHATSNEW['new_last'],
                $_SP_CONF['newstaticpagesinterval']),
        );
    }

    return $retval;
}

/**
 * Return list of Static Pages for the Related Items block
 *
 * @param    array $tids list of topic ids
 * @param    int   $max  maximum number of items to return
 * @param    int   $trim max length of text
 * @return   array   array of links to related staticpages with unix timestamp as key
 */
function plugin_getrelateditems_staticpages($tids, $max, $trim)
{
    global $_CONF, $_TABLES, $_SP_CONF;

    $newstaticpages = array();

    // Use setting from What's New block here since similar settings needed
    if ($_SP_CONF['hidenewstaticpages'] == 'modified') {
        $datecolumn = 'modified';
    } else {
        $datecolumn = 'created';
    }
    $extra_sql = "";
    if ($_SP_CONF['includecenterblocks'] == 0) {
        $extra_sql = ' AND sp_centerblock = 0';
    }
    if ($_SP_CONF['includephp'] == 0) {
        $extra_sql .= ' AND sp_php = 0';
    }

    // Find newest Static Pages user has access too
    $sql = "SELECT sp_id, sp_title, UNIX_TIMESTAMP({$datecolumn}) sp_date
        FROM {$_TABLES['staticpage']}, {$_TABLES['topic_assignments']} ta
        WHERE ta.type = 'staticpages' AND ta.id = sp_id AND (ta.tid IN ('" . implode("','", $tids) . "'))
        AND sp_content IS NOT NULL AND (draft_flag = 0) AND (template_flag = 0)
        {$extra_sql} " . COM_getPermSQL('AND') . "
        GROUP BY sp_id ORDER BY {$datecolumn} DESC LIMIT {$max}";

    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if ($nrows > 0) {
        $newstaticpages = array();

        for ($x = 0; $x < $nrows; $x++) {
            $A = DB_fetchArray($result);

            $url = COM_buildURL($_CONF['site_url']
                . '/staticpages/index.php?page=' . $A['sp_id']);

            $title = COM_undoSpecialChars(stripslashes($A['sp_title']));
            if ($trim > 0) {
                $titletouse = COM_truncate($title, $trim, '...');
            } else {
                $titletouse = $title;
            }
            if ($title != $titletouse) {
                $attr = array('title' => htmlspecialchars($title));
            } else {
                $attr = array();
            }
            $astaticpage = str_replace('$', '&#36;', $titletouse);
            $astaticpage = str_replace(' ', '&nbsp;', $astaticpage);

            $newstaticpages[$A['sp_date']] = COM_createLink($astaticpage, $url, $attr);
        }
    }

    return $newstaticpages;
}

/**
 * Return new Static Pages for the What's New block
 *
 * @return   string  HTML list of new staticpages
 */
function plugin_getwhatsnew_staticpages()
{
    global $_CONF, $_TABLES, $_SP_CONF, $LANG_STATIC;

    $retval = '';
    if ($_SP_CONF['hidenewstaticpages'] == 'modified') {
        $datecolumn = 'modified';
    } else {
        $datecolumn = 'created';
    }
    $extra_sql = "";
    if ($_SP_CONF['includecenterblocks'] == 0) {
        $extra_sql = ' AND sp_centerblock = 0';
    }
    if ($_SP_CONF['includephp'] == 0) {
        $extra_sql .= ' AND sp_php = 0';
    }
    $sql = array();
    $sql['mysql'] = "SELECT sp_id, sp_title
        FROM {$_TABLES['staticpage']}
        WHERE sp_content IS NOT NULL AND (draft_flag = 0) AND (template_flag = 0) AND ({$datecolumn} >= (DATE_SUB(NOW(), INTERVAL {$_SP_CONF['newstaticpagesinterval']} SECOND)))
        {$extra_sql}
        " . COM_getPermSQL('AND') . "
        ORDER BY {$datecolumn} DESC LIMIT 15";

    $sql['pgsql'] = "SELECT sp_id, sp_title
        FROM {$_TABLES['staticpage']}
        WHERE sp_content IS NOT NULL AND (draft_flag = 0) AND (template_flag = 0) AND ({$datecolumn} >= (NOW() - INTERVAL '{$_SP_CONF['newstaticpagesinterval']} SECONDS'))
        {$extra_sql}
        " . COM_getPermSQL('AND') . "
        ORDER BY {$datecolumn} DESC LIMIT 15";

    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if ($nrows > 0) {
        $newstaticpages = array();

        for ($x = 0; $x < $nrows; $x++) {
            $A = DB_fetchArray($result);

            $url = COM_buildURL($_CONF['site_url']
                . '/staticpages/index.php?page=' . $A['sp_id']);

            $title = COM_undoSpecialChars(stripslashes($A['sp_title']));
            $titletouse = COM_truncate($title, $_SP_CONF['title_trim_length'],
                '...');
            if ($title != $titletouse) {
                $attr = array('title' => htmlspecialchars($title));
            } else {
                $attr = array();
            }
            $astaticpage = str_replace('$', '&#36;', $titletouse);
            $astaticpage = str_replace(' ', '&nbsp;', $astaticpage);

            $newstaticpages[] = COM_createLink($astaticpage, $url, $attr);
        }

        $retval .= COM_makeList($newstaticpages, PLG_getThemeItem('core-css-list-new', 'core'));
    } else {
        $retval .= $LANG_STATIC['no_new_pages'] . '<br' . XHTML . '>' . LB;
    }

    return $retval;
}

/**
 * Return new Static Page comments for the What's New block
 *
 * @param    int $numreturn      If 0 will return results for What's New Block.
 *                               If > 0 will return last X new comments for User Profile.
 * @param    int $uid            ID of the user to return results for. 0 = all users.
 * @return   array list of new comments (dups, type, title, sid, lastdate) or (sid, title, cid, unixdate)
 */
function plugin_getwhatsnewcomment_staticpages($numreturn = 0, $uid = 0)
{
    global $_CONF, $_TABLES;

    $stwhere = '';

    if ($uid > 0) {
        $stwhere = " AND ({$_TABLES['comments']}.uid = $uid)";
    }
    if ($numreturn == 0) {
        $sql['mysql'] = "SELECT DISTINCT COUNT(*) AS dups, type, sp_title title, sid, max(date) AS lastdate FROM {$_TABLES['comments']}, {$_TABLES['staticpage']} sp"
            . " WHERE type = 'staticpages' AND (sp.sp_id = sid) AND (sp.commentcode >= 0) AND (sp.draft_flag = 0) AND (sp.template_flag = 0)" . COM_getPermSQL('AND', 0, 2, 'sp')
            . " AND (date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newcommentsinterval']} SECOND))) {$stwhere} GROUP BY sid, type, sp_title, sid ORDER BY 5 DESC LIMIT 15";
        $sql['pgsql'] = "SELECT DISTINCT COUNT(*) AS dups, type, sp_title AS title, sid, max(date) AS lastdate FROM {$_TABLES['comments']}, {$_TABLES['staticpage']} sp"
            . " WHERE type = 'staticpages' AND (sp.sp_id = sid) AND (sp.commentcode >= 0) AND (sp.draft_flag = 0) AND (sp.template_flag = 0)" . COM_getPermSQL('AND', 0, 2, 'sp')
            . " AND (date >= (NOW()+ INTERVAL '{$_CONF['newcommentsinterval']} SECOND')) {$stwhere}  GROUP BY sid, type, sp_title, sid ORDER BY 5 DESC LIMIT 15";
    } else {
        $sql = "SELECT {$_TABLES['comments']}.sid, {$_TABLES['comments']}.title AS title, cid, UNIX_TIMESTAMP({$_TABLES['comments']}.date) AS unixdate FROM {$_TABLES['comments']}, {$_TABLES['staticpage']} sp"
            . " WHERE type = 'staticpages' AND (sp.sp_id = sid) AND (sp.commentcode >= 0) AND (sp.draft_flag = 0) AND (sp.template_flag = 0)" . COM_getPermSQL('AND', 0, 2, 'sp')
            . "{$stwhere} ORDER BY unixdate DESC LIMIT $numreturn";
    }

    $A = array();
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($x = 0; $x < $nrows; $x++) {
            $A[] = DB_fetchArray($result);
        }
    }

    return $A;
}

/**
 * Return information for a static page
 *
 * @param    string $sp_id   static page ID or '*'
 * @param    string $what    comma-separated list of properties
 * @param    int    $uid     user ID or 0 = current user
 * @param    array  $options (reserved for future extensions)
 * @return   mixed               string or array of strings with the information
 */
function plugin_getiteminfo_staticpages($sp_id, $what, $uid = 0, $options = array())
{
    global $_CONF, $_TABLES;

    // parse $what to see what we need to pull from the database
    $properties = explode(',', $what);
    $fields = array();
    foreach ($properties as $p) {
        switch ($p) {
            case 'date-created':
                $fields[] = 'UNIX_TIMESTAMP(created) AS c_unixdate';
                break;

            case 'date-modified':
                $fields[] = 'UNIX_TIMESTAMP(modified) AS m_unixdate';
                break;

            case 'description':
            case 'excerpt':
                $fields[] = 'sp_content';
                $fields[] = 'sp_php';
                break;

            case 'id':
                $fields[] = 'sp_id';
                break;

            case 'title':
                $fields[] = 'sp_title';
                break;

            case 'page_title':
                $fields[] = 'sp_page_title';
                break;

            case 'url':
                // needed for $sp_id == '*', but also in case we're only requesting
                // the URL (so that $fields isn't empty)
                $fields[] = 'sp_id';
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
    $where = ' WHERE (template_flag = 0)';
    if (!SEC_hasRights('staticpages.edit', 'AND', $uid)) {
        $where .= ' AND (draft_flag = 0)';
    }

    if ($sp_id != '*') {
        $where .= " AND (sp_id = '" . DB_escapeString($sp_id) . "')";
    }
    if ($uid > 0) {
        $permSql = COM_getPermSQL('AND', $uid);
    } else {
        $permSql = COM_getPermSQL('AND');
    }
    $sql = "SELECT " . implode(',', $fields)
        . " FROM {$_TABLES['staticpage']}" . $where . $permSql;
    if ($sp_id != '*') {
        $sql .= ' LIMIT 1';
    }

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    $retval = array();
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);

        $props = array();
        foreach ($properties as $p) {
            switch ($p) {
                case 'date-created':
                    $props['date-created'] = $A['c_unixdate'];
                    break;

                case 'date-modified':
                    $props['date-modified'] = $A['m_unixdate'];
                    break;

                case 'description':
                case 'excerpt':
                    $retval = '';
                    $mode = '';
                    $args = array(
                        'sp_id' => $sp_id,
                        'mode'  => $mode,
                    );
                    $svc_msg = array();

                    if (PLG_invokeService('staticpages', 'get', $args, $output, $svc_msg) == PLG_RET_OK) {
                        $props[$p] = $output['sp_content'];
                    }
                    break;

                case 'id':
                    $props['id'] = $A['sp_id'];
                    break;

                case 'title':
                    $props['title'] = stripslashes($A['sp_title']);
                    break;

                case 'page_title':
                    $props['page_title'] = stripslashes($A['sp_page_title']);
                    break;

                case 'url':
                    if (empty($A['sp_id'])) {
                        $props['url'] = COM_buildURL($_CONF['site_url']
                            . '/staticpages/index.php?page=' . $sp_id);
                    } else {
                        $props['url'] = COM_buildURL($_CONF['site_url']
                            . '/staticpages/index.php?page=' . $A['sp_id']);
                    }
                    break;

                default:
                    // return empty string for unknown properties
                    $props[$p] = '';
                    break;
            }
        }

        $mapped = array();
        foreach ($props as $key => $value) {
            if ($sp_id == '*') {
                if ($value != '') {
                    $mapped[$key] = $value;
                }
            } else {
                $mapped[] = $value;
            }
        }

        if ($sp_id == '*') {
            $retval[] = $mapped;
        } else {
            $retval = $mapped;
            break;
        }
    }

    if (($sp_id != '*') && (count($retval) == 1)) {
        $retval = $retval[0];
    }

    return $retval;
}

/**
 * Provide URL of a documentation file
 *
 * @param    string $file documentation file being requested, e.g. 'config'
 * @return   mixed           URL or false when not available
 */
function plugin_getdocumentationurl_staticpages($file)
{
    static $docUrl;

    switch ($file) {
        case 'index':
        case 'config':
            if (isset($docUrl)) {
                $retval = $docUrl;
            } else {
                $retval = COM_getDocumentUrl('docs', 'staticpages.html');
                $docUrl = $retval;
            }
            break;

        default:
            $retval = false;
            break;
    }

    return $retval;
}

/**
 * Provides text for a Configuration tooltip
 *
 * @param    string $id      Id of config value
 * @return   mixed           Text to use regular tooltip, NULL to use config
 *                           tooltip hack, or empty string when not available
 */
function plugin_getconfigtooltip_staticpages($id)
{
    // Use config tooltip hack where tooltip is read from the config documentation
    return;
}

/**
 * Provide URL for the link to a comment's parent item.
 * NOTE: The Plugin API does not support $_CONF['url_rewrite'] here,
 *       so we'll end up with a non-rewritten URL ...
 *
 * @return   string   string of URL
 */
function plugin_getcommenturlid_staticpages($id)
{
    global $_CONF;

    // Cannot use COM_buildURL as comment stuff does not support URL Rewrite
    return $_CONF['site_url'] . '/staticpages/index.php?page=' . $id;
}

/**
 * Callback function when an item was saved
 *
 * @param    string $id         (unused) ID of item being saved
 * @param    string $type       type of item ('article', 'staticpages', ...)
 * @param    string $old_id     (unused) previous ID of item, if != $id
 * @param    string  $sub_type  (unused) sub type of item (since Geeklog 2.2.2)
 * @see      PLG_itemSaved
 */
function plugin_itemsaved_staticpages($id, $type, $old_id, $sub_type)
{
    global $_TABLES;

    /* Not needed anymore since topic now stored in topic assignments
    // we're really only interested in Topic ID changes
    if (($type == 'topic') && !empty($old_id) && ($id != $old_id)) {
        DB_change($_TABLES['staticpage'], 'sp_tid', $id, 'sp_tid', $old_id);
    }
    */
}

/**
 * Callback function when an item was deleted
 *
 * @param    string  $id        ID of item being deleted
 * @param    string  $type      type of item ('article', 'staticpages', ...)
 * @param    string  $sub_type  (unused) sub type of item (since Geeklog 2.2.2)
 * @see      PLG_itemDeleted
 */
function plugin_itemdeleted_staticpages($id, $type, $sub_type)
{
    global $_TABLES;

    // we're really only interested in Topic Deletes
    if ($type == 'topic') {
        // Need to make sure at least one topic left. Default is all

        // Find all staticpages that are assigned to the deleted topic
        $sql = "SELECT id FROM {$_TABLES['topic_assignments']} WHERE type = 'staticpages' AND tid ='$id'";

        $result = DB_query($sql);
        $nrows = DB_numRows($result);

        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);

            // Now check if staticpage has at least 2 topics (1 will be deleted)
            $sql = "SELECT id FROM {$_TABLES['topic_assignments']} WHERE type = 'staticpages' AND id ='{$A['id']}'";
            $resultB = DB_query($sql);
            $nrowsB = DB_numRows($resultB);

            if ($nrowsB < 2) {
                // Only deleted topic assigned so add all topic default assignment
                TOPIC_addTopicAssignments('staticpages', $A['id']);
            }
        }
    }
}

/**
 * This function is called to inform plugins when a group's information has
 * changed or a new group has been created.
 *
 * @param    int    $grp_id Group ID
 * @param    string $mode   type of change: 'new', 'edit', or 'delete'
 * @return   void
 */
function plugin_group_changed_staticpages($grp_id, $mode)
{
    global $_TABLES, $_GROUPS;

    if ($mode == 'delete') {
        // Change any deleted group ids to Static Page Admin if exist, if does not change to root group
        $new_group_id = 0;
        if (isset($_GROUPS['Static Page Admin'])) {
            $new_group_id = $_GROUPS['Static Page Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }

        // Update Staticpages with new group id
        $sql = "UPDATE {$_TABLES['staticpage']} SET group_id = $new_group_id WHERE group_id = $grp_id";
        $result = DB_query($sql);
    }
}

/**
 * Lets Geeklog know the names of language variables and arrays that can be overridden if need be
 *
 * @return   array
 */
function plugin_getlanguageoverrides_staticpages()
{

    return array('LANG_STATIC');
}

/**
 * Return URL of item even if the item doesn't exist, e.g., after it has been deleted
 *
 * @param  string  $sub_type  (unused) sub type of plugin
 * @param  string  $item_id   the id of the item
 * @return string
 * @since  Geeklog 2.2.2
 */
function plugin_idToURL_staticpages($sub_type, $item_id)
{
    global $_CONF;

    return COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page=' . $item_id);
}
