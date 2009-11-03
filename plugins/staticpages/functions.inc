<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the Static     |
// | Pages' PHP files.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
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

/**
* Check and see if we need to load the plugin configuration
*/
if (!isset($_SP_CONF['allow_php'])) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';

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
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
*/
function plugin_getmenuitems_staticpages()
{
    global $_CONF, $_TABLES, $_SP_CONF;

    $order = '';
    if (!empty ($_SP_CONF['sort_menu_by'])) {
        $order = ' ORDER BY ';
        if ($_SP_CONF['sort_menu_by'] == 'date') {
            $order .= 'sp_date DESC';
        } else if ($_SP_CONF['sort_menu_by'] == 'label') {
            $order .= 'sp_label';
        } else if ($_SP_CONF['sort_menu_by'] == 'title') {
            $order .= 'sp_title';
        } else { // default to "sort by id"
            $order .= 'sp_id';
        }
    }

    $result = DB_query('SELECT sp_id, sp_label FROM ' . $_TABLES['staticpage'] . ' WHERE sp_onmenu = 1' . COM_getPermSql('AND') . COM_getLangSql('sp_id', 'AND') . $order);
    $nrows = DB_numRows ($result);
    $menuitems = array ();
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray ($result);
        $menuitems[$A['sp_label']] = COM_buildURL ($_CONF['site_url'] . '/staticpages/index.php?page=' . $A['sp_id']);
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
function plugin_displaycomment_staticpages ($id, $cid, $title, $order, $format, $page, $view)
{
    global $_TABLES, $LANG_ACCESS;

    $retval = '';

    $sql = "SELECT COUNT(*) AS count, commentcode, owner_id, group_id, perm_owner, "
        . "perm_group, perm_members, perm_anon "
        . "FROM {$_TABLES['staticpage']} "
        . "WHERE (sp_id = '$id')" . COM_getPermSQL('AND')
        . ' GROUP BY sp_id';
    $result = DB_query ($sql);
    $A = DB_fetchArray ($result);
    $allowed = $A['count'];

    if ($allowed == 1) {
        $delete_option = (SEC_hasRights ('staticpages.edit') &&
                (SEC_hasAccess ($A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon']) == 3));
        $retval .= CMT_userComments ($id, $title, 'staticpages', $order, $format,
                                     $cid, $page, $view, $delete_option,
                                     $A['commentcode']);
    } else {
        $retval .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                        COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG_ACCESS['storydenialmsg']
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    return $retval;
}

/**
 * Static Page saves a comment
 *
 * @param   string  $title  comment title
 * @param   string  $comment comment text
 * @param   string  $id     Item id to which $cid belongs
 * @param   int     $pid    comment parent
 * @param   string  $postmode 'html' or 'text'
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_savecomment_staticpages($title, $comment, $id, $pid, $postmode)
{
    global $_CONF, $_TABLES, $LANG03, $_USER;

    $retval = '';

    $commentcode = DB_getItem($_TABLES['staticpage'], 'commentcode',
                              "sp_id = '$id'");
    if ($commentcode != 0) {
        return COM_refresh($_CONF['site_url'] . '/index.php');
    }

    $ret = CMT_saveComment($title, $comment, $id, $pid, 'staticpages', $postmode);
    if ($ret > 0) { // failure //FIXME: some failures should not return to comment form
        $retval .= COM_siteHeader('menu', $LANG03[1])
                . CMT_commentForm($title, $comment, $id, $pid, 'staticpages',
                                  $LANG03[14], $postmode)
                . COM_siteFooter();
    } else { // success
        $msg = '';
        if (($_CONF['commentsubmission'] == 1) &&
                !SEC_hasRights('comment.submit')) {
            $msg = '&msg=15';
        }
        $retval = COM_refresh ($_CONF['site_url']
                                . "/staticpages/index.php?page=$id$msg");
    }

    return $retval;
}

/**
 * staticpages: delete a comment
 *
 * @param   int     $cid    Comment to be deleted
 * @param   string  $id     Item id to which $cid belongs
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_deletecomment_staticpages($cid, $id)
{
    global $_CONF, $_TABLES, $_USER;

    $retval = '';

    $has_editPermissions = SEC_hasRights ('staticpages.edit');
    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon "
        . "FROM {$_TABLES['staticpage']} WHERE sp_id = '{$id}'");
    $A = DB_fetchArray ($result);

    if ($has_editPermissions && SEC_hasAccess ($A['owner_id'],
            $A['group_id'], $A['perm_owner'], $A['perm_group'],
            $A['perm_members'], $A['perm_anon']) == 3) {
        CMT_deleteComment($cid, $id, 'staticpages');
        $retval .= COM_refresh ($_CONF['site_url']
                                 . "/staticpages/index.php?page=$id");
    } else {
        COM_errorLog ("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) "
                    . "tried to illegally delete comment $cid from staticpage $id");
        $retval .= COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    return $retval;
}

/**
* Helper function: Count static pages visible to the current user
*
* @return   int     number of pages
*
*/
function SP_countVisiblePages ()
{
    global $_TABLES;

    $perms = SP_getPerms ();
    if (!empty ($perms)) {
        $perms = ' WHERE ' . $perms;
    }
    $result = DB_query ("SELECT COUNT(*) AS cnt FROM {$_TABLES['staticpage']}" . $perms);
    $A = DB_fetchArray ($result);

    return $A['cnt'];
}

/**
* Prepare static page for display.
*
* @param    string  $page           static page id
* @param    array   $A              static page data
* @param    string  $comment_order  sorting of comments
* @param    string  $comment_mode   comment mode (nested, flat, etc.)
* @param    int     $msg            optional message number
* @return   string                  HTML for the static page
*
*/
function SP_displayPage ($page, $A, $comment_order = 'ASC', $comment_mode = 'nested', $msg = 0)
{
    global $_CONF, $_TABLES, $_USER,
           $LANG01, $LANG11, $LANG_STATIC, $_IMAGE_TYPE, $_SP_CONF;

    $retval = '';

    $sp_url = COM_buildUrl($_CONF['site_url'] . '/staticpages/index.php?page='
                           . $page);
    $headercode = '<link rel="canonical" href="' . $sp_url . '"' . XHTML . '>';

    // Meta Tags
    If ($_SP_CONF['meta_tags'] > 0) {
        $meta_description  = $A['meta_description'];
        $meta_keywords  = $A['meta_keywords'];
        $headercode .= COM_createMetaTags($meta_description, $meta_keywords);
    }

    if ($A['sp_format'] == 'allblocks' OR $A['sp_format'] == 'leftblocks') {
        $retval .= COM_siteHeader('menu', $A['sp_title'], $headercode);
    } else {
        if ($A['sp_format'] <> 'blankpage') {
            $retval .= COM_siteHeader('none', $A['sp_title'], $headercode);
        }
    }
    if ($msg > 0) {
        $retval .= COM_showMessage($msg, 'staticpages');
    }
    if (($A['sp_inblock'] == 1) && ($A['sp_format'] != 'blankpage')) {
        $retval .= COM_startBlock (stripslashes ($A['sp_title']), $A['sp_help'],
                        COM_getBlockTemplate ('_staticpages_block', 'header'));
    }

    $spage = new Template( $_CONF['path'] . 'plugins/staticpages/templates/' );
    $spage->set_var('xhtml', XHTML);
    if (XHTML != '') {
        $spage->set_var('xmlns', ' xmlns="http://www.w3.org/1999/xhtml"');
    }
    $spage->set_var('site_url', $_CONF['site_url']);
    $spage->set_var('layout_url', $_CONF['layout_url']);
    $spage->set_var('site_admin_url', $_CONF['site_admin_url']);
    $spage -> set_file( array('page'=>'staticpage.thtml',
        'comments' => 'spcomments.thtml'));

    if ($A['sp_format'] <> 'blankpage') {
        if ($_CONF['hideprintericon'] == 0) {
            $icon_url = $_CONF['layout_url'] . '/images/print.' . $_IMAGE_TYPE;
            $attr = array('title' => $LANG_STATIC['printable_format']);
            $printicon = COM_createImage($icon_url, $LANG01[65], $attr);
            $print_url = COM_buildURL ($_CONF['site_url']
                . '/staticpages/index.php?page=' . $page . '&amp;disp_mode=print');
            $icon = COM_createLink($printicon, $print_url);
            $spage->set_var('print_icon', $icon);
        }
        if ((SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
                $A['perm_group'], $A['perm_members'], $A['perm_anon']) == 3) &&
                SEC_hasRights ('staticpages.edit')) {
            $icon_url = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
            $attr = array('title' => $LANG_STATIC['edit']);
            $editiconhtml = COM_createImage($icon_url, $LANG_STATIC['edit'], $attr);
            $attr = array('class' => 'editlink','title' => $LANG_STATIC['edit']);
            $url = $_CONF['site_admin_url']
                . '/plugins/staticpages/index.php?mode=edit&amp;sp_id=' . $page;
            $icon =
                '&nbsp;' . COM_createLink(
                $editiconhtml, //display
                $url,  //target
                $attr //other attributes
            );
            $spage->set_var('edit_icon', $icon);
        }
    }

    if($A['commentcode'] >= 0 ) {
        $delete_option = (SEC_hasRights('staticpages.edit') &&
            SEC_hasAccess($A['owner_id'], $A['group_id'],
            $A['perm_owner'], $A['perm_group'], $A['perm_members'],
            $A['perm_anon']) == 3 ? true : false);
        require_once $_CONF['path_system'] . 'lib-comment.php';
        $spage->set_var ('commentbar', CMT_userComments($page, $A['sp_title'], 'staticpages',
                                    $comment_order, $comment_mode, 0, 1, false,
                                    $delete_option, $A['commentcode']));
    }


    $content = SP_render_content (stripslashes ($A['sp_content']), $A['sp_php']);
    $spage->set_var('content', $content );

    $spage->set_var('info_separator', 'hidden');
    if ($A['sp_format'] <> 'blankpage') {
        $curtime = COM_getUserDateTimeFormat ($A['sp_date']);
        if ($_SP_CONF['show_date'] == 1) {
            $lastupdate = $LANG_STATIC['lastupdated']. ' ' . $curtime[0];
            $spage->set_var('lastupdate', $lastupdate);
        }

        if ($_SP_CONF['show_hits'] == 1) {
            if ($_SP_CONF['show_date'] == 1) {
                $spage->set_var('info_separator','visible');
            }
            $hits = COM_numberFormat ($A['sp_hits']) . ' ' . $LANG_STATIC['hits'];
            $spage->set_var('hits', $hits);
        }
    }

    $retval .= $spage->finish($spage->parse('output', 'page'));
    if (($A['sp_inblock'] == 1) && ($A['sp_format'] != 'blankpage')) {
        $retval .= COM_endBlock (COM_getBlockTemplate ('_staticpages_block',
                                                       'footer'));
    }

    if ($A['sp_format'] <> 'blankpage') {
        if (!isset($_USER['noboxes'])) {
            if (empty($_USER['uid']) || ($_USER['uid'] == 1)) {
                $_USER['noboxes'] = 0;
            } else {
                $_USER['noboxes'] = DB_getItem($_TABLES['userindex'],
                                        'noboxes', "uid = '{$_USER['uid']}'");
            }
        }

        if (($A['sp_format'] == 'allblocks') && ($_USER['noboxes'] != 1)) {
            $retval .= COM_siteFooter(true);
        } else if (($A['sp_format'] == 'leftblocks') || ($A['sp_format'] == 'noblocks')) {
            $retval .= COM_siteFooter(false);
        } else {
            $retval .= COM_siteFooter();
        }
    }

    return $retval;
}

/**
* Prepare static page for print (i.e. display as "printable version").
*
* @param    string  $page       static page id
* @param    array   $A          static page data
* @return   string              HTML for the static page
*
*/
function SP_printPage($page, $A)
{
    global $_CONF, $_TABLES, $LANG01, $LANG_DIRECTION;

    $template_path = staticpages_templatePath();
    $print = new Template($template_path);
    $print->set_file(array('print' => 'printable.thtml'));
    $print->set_var('site_url', $_CONF['site_url']);
    $print->set_var('site_admin_url', $_CONF['site_admin_url']);
    $print->set_var('layout_url', $_CONF['layout_url']);
    $print->set_var('site_name', $_CONF['site_name']);
    $print->set_var('site_slogan', $_CONF['site_slogan']);

    $print->set_var('direction', $LANG_DIRECTION);
    COM_setLangIdAndAttribute($print);
    $print->set_var('xhtml', XHTML);
    $print->set_var('page_title', $_CONF['site_name'] . ' - '
                                  . stripslashes($A['sp_title']));
    $sp_url = COM_buildUrl($_CONF['site_url']
                                  . '/staticpages/index.php?page=' . $page);
    $print->set_var('sp_url', $sp_url);
    $print->set_var('sp_title', stripslashes($A['sp_title']));
    $print->set_var('sp_content',
            SP_render_content(stripslashes($A['sp_content']), $A['sp_php']));
    $print->set_var('sp_hits', COM_numberFormat($A['sp_hits']));
    $printable = COM_buildURL($_CONF['site_url']
               . '/staticpages/index.php?page=' . $page . '&amp;mode=print');
    $print->set_var('printable_url', $printable);
    if ($A['commentcode'] >= 0) {
        $commentsUrl = $sp_url . '#comments';
        $comments = DB_count($_TABLES['comments'],
                             array('sid', 'type'), array($page, 'staticpages'));
        $numComments = COM_numberFormat($comments);
        $print->set_var('story_comments', $numComments);
        $print->set_var('comments_url', $commentsUrl);
        $print->set_var('comments_text', $numComments . ' ' . $LANG01[3]);
        $print->set_var('comments_count', $numComments);
        $print->set_var('lang_comments', $LANG01[3]);
        $comments_with_count = sprintf($LANG01[121], $numComments);

        if ($comments > 0) {
            $comments_with_count = COM_createLink($comments_with_count,
                                                  $commentsUrl);
        }
        $print->set_var('comments_with_count', $comments_with_count);
    }
    $print->parse('output', 'print');

    return $print->finish($print->get_var('output'));
}

/**
* Prepare static page for display
*
* @param    string  $page           static page id
* @param    string  $mode           type of display to return ('', 'print', 'autotag'
* @param    string  $comment_order  sorting of comments
* @param    string  $comment_mode   comment mode (nested, flat, etc.)
* @param    int     $msg            optional message number
* @return   string                  HTML for the static page
*
*/
function SP_returnStaticpage($page='', $mode='', $comment_order = 'ASC', $comment_mode = 'nested', $msg = 0)
{
    global $_CONF, $_TABLES, $LANG_ACCESS, $LANG_STATIC, $LANG_LOGIN;

    $retval = '';

    $args = array(
                'sp_id' => $page,
                'mode'  => $mode
                 );
    $svc_msg = array();

    if (PLG_invokeService('staticpages', 'get', $args, $retval, $svc_msg) == PLG_RET_OK) {

        if ($mode == 'print') {
            $retval = SP_printPage($page, $retval);
        } else if ($mode =='autotag') {
            $retval = SP_render_content(stripslashes($retval['sp_content']), $retval['sp_php']);
        } else {
            $retval = SP_displayPage($page, $retval, $comment_order, $comment_mode, $msg);
        }

        // increment hit counter for page
        DB_query("UPDATE {$_TABLES['staticpage']} SET sp_hits = sp_hits + 1 WHERE sp_id = '$page'");

    }

    return $retval;
}

/**
* Shows the statistics for the Static Pages plugin on stats.php.
* If $showsitestats is 1 then we are to only print the overall stats in the
* 'site statistics box' otherwise we show the detailed stats
*
* @param    int     showsitestate   Flag to let us know which stats to get
*/
function plugin_showstats_staticpages($showsitestats)
{
    global $_CONF, $_TABLES, $LANG_STATIC;

    $retval = '';

    $perms = SP_getPerms();
    if (!empty($perms)) {
        $perms = ' AND ' . $perms;
    }
    $result = DB_query("SELECT sp_id,sp_title,sp_hits FROM {$_TABLES['staticpage']} WHERE sp_hits > 0" . $perms . ' ORDER BY sp_hits DESC LIMIT 10');
    $nrows  = DB_numRows($result);
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
                          'title'    => $LANG_STATIC['stats_headline']
        );
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $A['sp_title'] = stripslashes($A['sp_title']);
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
*
*/
function plugin_statssummary_staticpages()
{
    global $LANG_STATIC;

    $total_pages = SP_countVisiblePages();

    return array($LANG_STATIC['staticpages'], COM_numberFormat($total_pages));
}

/**
* Geeklog is asking us to provide any new items that show up in the type
* drop-down on search.php.  Let's let users search static pages!
*
*/
function plugin_searchtypes_staticpages()
{
    global $LANG_STATIC, $_SP_CONF;

    if ($_SP_CONF['includesearch'] == 1) {
        $tmp['staticpages'] = $LANG_STATIC['staticpages'];
        
        return $tmp;
    }
}


/**
* this searches for static pages matching the user query and returns an array of
* for the header and table rows back to search.php where it will be formated and
* printed
*
* @param    string  $query      Keywords user is looking for
* @param    date    $datestart  Start date to get results for
* @param    date    $dateend    End date to get results for
* @param    string  $topic      The topic they were searching in
* @param    string  $type       Type of items they are searching, or 'all' (deprecated)
* @param    int     $author     Get all results by this author
* @param    string  $keyType    search key type: 'all', 'phrase', 'any'
* @param    int     $page       page number of current search (deprecated)
* @param    int     $perpage    number of results per page (deprecated)
*
*/
function plugin_dopluginsearch_staticpages($query, $datestart, $dateend, $topic, $type, $author, $keyType, $page, $perpage)
{
    global $_TABLES, $_DB_dbms, $LANG_STATIC, $LANG09, $_SP_CONF;

    if ($_SP_CONF['includesearch'] != 1) {
        return;
    }

    // Make sure the query is SQL safe
    $query = trim(addslashes($query));

    $sql = "SELECT sp.sp_id AS id, sp.sp_title AS title, sp.sp_content AS description, ";
    $sql .= "UNIX_TIMESTAMP(sp.sp_date) AS date, sp.sp_uid AS uid, sp.sp_hits AS hits, ";
    $sql .= "CONCAT('/staticpages/index.php?page=', sp.sp_id) AS url ";
    $sql .= "FROM {$_TABLES['staticpage']} AS sp,{$_TABLES['users']} AS u ";
    $sql .= "WHERE (sp.sp_uid = u.uid) AND (sp_php <> 1) ";
    $sql .= COM_getPermSQL('AND') . COM_getLangSQL('sp_id', 'AND', 'sp') . ' ';

    if (!empty ($author)) {
        $sql .= "AND (sp_uid = '$author') ";
    }

    $search_p = new SearchCriteria('staticpages', $LANG_STATIC['staticpages']);

    $columns = array('title' => 'sp_title', 'sp_content');
    $sql .= $search_p->getDateRangeSQL('AND', 'sp_date', $datestart, $dateend);
    list($sql,$ftsql) = $search_p->buildSearchSQL($keyType, $query, $columns, $sql);

    $search_p->setSQL($sql);
    $search_p->setFTSQL($ftsql);
    $search_p->setRank(3);
    $search_p->setURLRewrite(true);

    // Search static page comments
    $sql = "SELECT c.cid AS id, c.title AS title, c.comment AS description, ";
    $sql .= "UNIX_TIMESTAMP(c.date) AS date, c.uid AS uid, ";

    // MSSQL has a problem when concatenating numeric values
    if ($_DB_dbms == 'mssql') {
        $sql .= "'/comment.php?mode=view&amp;cid=' + CAST(c.cid AS varchar(10)) AS url ";
    } else {
        $sql .= "CONCAT('/comment.php?mode=view&amp;cid=',c.cid) AS url ";
    }

    $sql .= "FROM {$_TABLES['users']} AS u, {$_TABLES['comments']} AS c ";
    $sql .= "LEFT JOIN {$_TABLES['staticpage']} AS s ON ((s.sp_id = c.sid) ";
    $sql .= COM_getPermSQL('AND',0,2,'s') . COM_getLangSQL('sid','AND','s') . ") ";
    $sql .= "WHERE (u.uid = c.uid) AND (s.commentcode >= 0) AND (s.sp_date <= NOW()) ";

    if (!empty($author)) {
        $sql .= "AND (c.uid = '$author') ";
    }

    $search_c = new SearchCriteria('comments', array($LANG_STATIC['staticpages'],$LANG09[66]));

    $columns = array('title' => 'c.title', 'comment');
    $sql .= $search_c->getDateRangeSQL('AND', 'c_date', $datestart, $dateend);
    list($sql, $ftsql) = $search_c->buildSearchSQL($keyType, $query, $columns, $sql);

    $search_c->setSQL($sql);
    $search_c->setFTSQL($ftsql);
    $search_c->setRank(2);

    return array($search_p, $search_c);
}


/**
* This will put an option for static pages in the command and control block on
* moderation.php
*
*/
function plugin_cclabel_staticpages()
{
    global $LANG_STATIC, $_CONF;

    if (SEC_hasRights ('staticpages.edit,staticpages.delete', 'OR')) {
        return array ($LANG_STATIC['staticpages'],
                $_CONF['site_admin_url'] . '/plugins/staticpages/index.php',
                plugin_geticon_staticpages ());
    }

    return false;
}

/**
* returns the administrative option for this plugin
*
*/
function plugin_getadminoption_staticpages()
{
    global $_CONF, $_TABLES, $LANG_STATIC;

    if (SEC_hasRights ('staticpages.edit,staticpages.delete', 'OR')) {
        $result = DB_query ("SELECT COUNT(*) AS cnt FROM {$_TABLES['staticpage']}" . COM_getPermSQL ('WHERE', 0, 3));
        $A = DB_fetchArray ($result);
        $total_pages = $A['cnt'];
        return array ($LANG_STATIC['staticpages'], $_CONF['site_admin_url'] . '/plugins/staticpages/index.php', $total_pages);
    }
}

/**
* Return SQL where statement with appropriate permissions
*
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
* @param    string  $table  Table name (used in joins)
* @param    int     $access Access if blank read access  2 = read 3 = read/edit
* @param    int     $u_id   User ID if blank current user
* @return   string          Where clause of sql statement
*
*/
function SP_getPerms ($table = '', $access = '2', $u_id = '')
{
    global $_USER, $_GROUPS;

    if ($table != '') { $table .= '.'; }

    if ($u_id == '') {
        if (isset ($_USER['uid'])) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }
        $GROUPS = $_GROUPS;
    } else {
        $uid = $u_id;
        $GROUPS = SEC_getUserGroups ($uid);
    }

    $sql = '(';

    if ($uid > 1) {
        $sql .= "((owner_id = '{$uid}') AND (perm_owner >= $access)) OR ";

        $sql .= "((group_id IN (" . implode (',', $GROUPS) . ")) "
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
* @param   where   int      where the static page will be displayed (0..3)
* @param   page    int      page number
* @param   topic   string   topic ID
* @return          string   HTML for the static page (can be empty)
*/
function plugin_centerblock_staticpages ($where = 1, $page = 1, $topic ='')
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
        if (DB_count ($_TABLES['stories'], 'featured', 1) == 0) {
            // no featured story found - redefine $moresql
            $moresql = "(sp_where = 1 OR sp_where = 2) AND ";
            $displayFeatured = true;
        }
    }

    if (empty ($topic)) {
        $moresql .= "((sp_tid = 'none') OR (sp_tid = 'all'))";
    } else {
        $moresql .= "((sp_tid = '{$topic}') OR (sp_tid = 'all'))";
    }

    if ($_SP_CONF['sort_by'] == 'date') {
        $sort = 'sp_date DESC';
    } else if ($_SP_CONF['sort_by'] == 'title') {
        $sort = 'sp_title';
    } else { // default to "sort by id"
        $sort = 'sp_id';
    }
    if ($displayFeatured) {
        $sort = 'sp_where,' . $sort;
    }

    $perms = SP_getPerms ();
    if (!empty ($perms)) {
        $perms = ' AND ' . $perms;
    }
    $spsql = "SELECT sp_id,sp_title,sp_content,sp_format,sp_date,sp_hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,sp_php,sp_inblock,sp_help FROM {$_TABLES['staticpage']} WHERE (sp_centerblock = 1)" . COM_getLangSql ('sp_id', 'AND') . ' AND ' . $moresql . $perms . " ORDER BY " . $sort;
    $result = DB_query ($spsql);

    $pages = DB_numRows ($result);
    if ($pages > 0) {
        for ($i = 0; $i < $pages; $i++) {
            $S = DB_fetchArray ($result);

            if ($where == 0) {
                switch ($S['sp_format']) {
                    case 'noblocks':
                        $retval .= COM_siteHeader ('none');
                        break;
                    case 'allblocks':
                    case 'leftblocks':
                        $retval .= COM_siteHeader ('menu');
                        break;
                }
                if (isset($_GET['msg'])) {
                    $msg = COM_applyFilter($_GET['msg'], true);
                    if ($msg > 0) {
                        $retval .= COM_showMessage($msg);
                    }
                }
            }

            if (($S['sp_inblock'] == 1) && !empty ($S['sp_title'])
                && (($where != 0) || ($S['sp_format'] != 'blankpage'))) {
                $retval .= COM_startBlock ($S['sp_title'], $S['sp_help'],
                    COM_getBlockTemplate ('_staticpages_centerblock', 'header'));
            }

            $spage = new Template( $_CONF['path'] . 'plugins/staticpages/templates/' );
            $spage->set_file( array('page'=>'centerblock.thtml'));
            $spage->set_var('xhtml', XHTML);
            $spage->set_var('site_url', $_CONF['site_url']);
            $spage->set_var('layout_url', $_CONF['layout_url']);
            $spage->set_var('site_admin_url', $_CONF['site_admin_url']);

            if ($_CONF['hideprintericon'] == 0) {
                $icon_url = $_CONF['layout_url'] . '/images/print.' . $_IMAGE_TYPE;
                $attr = array('title' => $LANG_STATIC['printable_format']);
                $printicon = COM_createImage($icon_url, $LANG01[65], $attr);
                $print_url = COM_buildURL ($_CONF['site_url']
                    . '/staticpages/index.php?page=' . $S['sp_id'] . '&amp;mode=print');
                $icon = COM_createLink($printicon, $print_url);
                $spage->set_var('print_icon', $icon);
            }
            if ((SEC_hasAccess ($S['owner_id'], $S['group_id'], $S['perm_owner'],
                    $S['perm_group'], $S['perm_members'], $S['perm_anon']) == 3) &&
                    SEC_hasRights ('staticpages.edit')) {
                $icon_url = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
                $attr = array('title' => $LANG_STATIC['edit']);
                $editiconhtml = COM_createImage($icon_url, $LANG_STATIC['edit'], $attr);
                $url = $_CONF['site_admin_url']
                    . '/plugins/staticpages/index.php?mode=edit&amp;sp_id=' . $S['sp_id'];
                $attr = array('class' => 'editlink','title' => $LANG_STATIC['edit']);
                $icon =
                    '&nbsp;' . COM_createLink(
                    $editiconhtml, //display
                    $url,  //target
                    $attr //other attributes
                );
                $spage->set_var('edit_icon', $icon);
            }

            $spage->set_var('info_separator', 'hidden');
            if ($_SP_CONF['show_date'] == 1) {
                $curtime = COM_getUserDateTimeFormat($S['sp_date']);
                $lastupdate = $LANG_STATIC['lastupdated']. ' ' . $curtime[0];
                $spage->set_var('lastupdate', $lastupdate);
            }

            if ($_SP_CONF['show_hits'] == 1) {
                if ($_SP_CONF['show_date'] == 1) {
                    $spage->set_var('info_separator', 'visible');
                }
                $hits = COM_numberFormat($S['sp_hits']) . ' '
                                         . $LANG_STATIC['hits'];
                $spage->set_var('hits', $hits);
            }

            $content = SP_render_content (stripslashes ($S['sp_content']), $S['sp_php']);
            $spage->set_var('content', $content );
            $retval .= $spage->finish($spage->parse('output', 'page'));
            if (($S['sp_inblock'] == 1) && !empty ($S['sp_title'])
                && (($where != 0) || ($S['sp_format'] != 'blankpage'))) {
                $retval .= COM_endBlock (COM_getBlockTemplate ('_staticpages_centerblock', 'footer'));
            }

            if ($where == 0) {
                if ($S['sp_format'] == 'allblocks') {
                    $retval .= COM_siteFooter (true);
                } else if ($S['sp_format'] != 'blankpage') {
                    $retval .= COM_siteFooter ();
                }
            }

            // increment hit counter for page
            DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_hits = sp_hits + 1 WHERE sp_id = '{$S['sp_id']}'");
        }
    }

    return $retval;
}

/**
* A user is about to be deleted. Update ownership of any static pages owned
* by that user or delete them.
*
* @param   uid   int   User id of deleted user
*
*/
function plugin_user_delete_staticpages($uid)
{
    global $_TABLES, $_SP_CONF;

    if (DB_count ($_TABLES['staticpage'], 'sp_uid', $uid) +
            DB_count ($_TABLES['staticpage'], 'owner_id', $uid) == 0) {
        return;
    }

    if ($_SP_CONF['delete_pages'] == 1) {
        // delete the pages
        DB_query ("DELETE FROM {$_TABLES['staticpage']} WHERE (sp_uid = $uid) OR (owner_id = $uid)");
    } else {
        // assign ownership to a user from the Root group
        $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id',
                                 "grp_name = 'Root'");
        $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
        $A = DB_fetchArray ($result);
        $rootuser = $A['ug_uid'];

        DB_query ("UPDATE {$_TABLES['staticpage']} SET sp_uid = $rootuser WHERE sp_uid = $uid");
        DB_query ("UPDATE {$_TABLES['staticpage']} SET owner_id = $rootuser WHERE owner_id = $uid");
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
* Implements the [staticpage:] autotag.
*
*/
function plugin_autotags_staticpages($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES;

    static $recursive = array();

    if ($op == 'tagname' ) {
        return array('staticpage', 'staticpage_content');
    } else if ($op == 'parse') {
        if ($autotag['tag'] == 'staticpage' ) {
            $sp_id = COM_applyFilter($autotag['parm1']);
            if (! empty($sp_id)) {
                $url = COM_buildUrl($_CONF['site_url']
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
        } else if ($autotag['tag'] == 'staticpage_content') {
            $sp_id = COM_applyFilter($autotag['parm1']);
            if (! empty($sp_id)) {
                if (isset($recursive[$sp_id])) {
                    $content = '';
                } else {
                    $recursive[$sp_id] = true;
                    $sp_content = SP_returnStaticpage($sp_id, 'autotag');
                    $content = str_replace($autotag['tagstr'], $sp_content,
                                           $content);
                }
            }
        }

        return $content;
    }
}

/**
* Returns the URL of the plugin's icon
*
* @return   string      URL of the icon
*
*/
function plugin_geticon_staticpages ()
{
    global $_CONF;

    return $_CONF['site_url'] . '/staticpages/images/staticpages.png';
}

/**
* Update the Static Pages plugin
*
* @return   int     Number of message to display (true = generic success msg)
*
*/
function plugin_upgrade_staticpages()
{
    global $_CONF, $_TABLES, $_DB_dbms;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                    "pi_name = 'staticpages'");
    $code_version = plugin_chkVersion_staticpages();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/staticpages/autoinstall.php';

    if (! plugin_compatible_with_this_version_staticpages('staticpages')) {
        return 3002;
    }

    $inst_parms = plugin_autoinstall_staticpages('staticpages');
    $pi_gl_version = $inst_parms['info']['pi_gl_version'];

    require_once $_CONF['path'] . 'plugins/staticpages/sql/'
                                . $_DB_dbms . '_updates.php';

    $current_version = $installed_version;
    $done = false;
    while (! $done) {
        switch ($current_version) {
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

            update_ConfValues_1_6_0();

            $current_version = '1.6.1';
            break;

        default:
            $done = true;
        }
    }

    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '$pi_gl_version' WHERE pi_name = 'staticpages'");

    return true;
}

/**
* Called during site migration - handle changed URLs or paths
*
* @param    array   $old_conf   contents of the $_CONF array on the old site
* @param    boolean             true on success, otherwise false
*
*/
function plugin_migrate_staticpages($old_conf)
{
    global $_CONF;

    $tables = array(
        'staticpage'    => 'sp_id, sp_content'
    );

    if ($old_conf['site_url'] != $_CONF['site_url']) {
        INST_updateSiteUrl($old_conf['site_url'], $_CONF['site_url'], $tables);
    }

    return true;
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
*/
function plugin_autouninstall_staticpages ()
{
    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array('staticpage'),
        /* give the full name of the group, as in the db */
        'groups' => array('Static Page Admin', // correct Admin group name
                          'Static Pages Admin' // typo in Geeklog 1.6.0
                         ),
        /* give the full name of the feature, as in the db */
        'features' => array('staticpages.edit', 'staticpages.delete', 'staticpages.PHP'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array('phpblock_calendar'),
        /* give all vars with their name */
        'vars'=> array()
    );

    return $out;
}

/**
* Get path for the template files.
*
* @param    string  $path   subdirectory within the base template path
* @return   string          full path to template directory
*
*/
function staticpages_templatePath ($path = '')
{
    global $_CONF;

    if (empty ($path)) {
        $layout_path = $_CONF['path_layout'] . 'staticpages';
    } else {
        $layout_path = $_CONF['path_layout'] . 'staticpages/' . $path;
    }

    if (is_dir ($layout_path)) {
        $retval = $layout_path;
    } else {
        $retval = $_CONF['path'] . 'plugins/staticpages/templates';
        if (!empty ($path)) {
            $retval .= '/' . $path;
        }
    }

    return $retval;
}

function plugin_getListField_staticpages($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_ADMIN, $LANG_STATIC, $_TABLES;

    switch($fieldname) {
        case "edit":
            $retval = COM_createLink($icon_arr['edit'],
                "{$_CONF['site_admin_url']}/plugins/staticpages/index.php?mode=edit&amp;sp_id={$A['sp_id']}");
            break;
        case "copy":
            $retval = COM_createLink($icon_arr['copy'],
                "{$_CONF['site_admin_url']}/plugins/staticpages/index.php?mode=clone&amp;sp_id={$A['sp_id']}");
            break;
        case "sp_title":
            $sp_title = stripslashes ($A['sp_title']);
            $url = COM_buildUrl ($_CONF['site_url'] .
                                 '/staticpages/index.php?page=' . $A['sp_id']);
            $retval = COM_createLink($sp_title, $url, array('title'=>$LANG_STATIC['title_display']));
            break;
        case "sp_uid":
            $retval = COM_getDisplayName ($A['sp_uid']);
            break;
        case "sp_centerblock":
            if ($A['sp_centerblock']) {
                switch ($A['sp_where']) {
                    case '1': $where = $LANG_STATIC['centerblock_top']; break;
                    case '2': $where = $LANG_STATIC['centerblock_feat']; break;
                    case '3': $where = $LANG_STATIC['centerblock_bottom']; break;
                    default:  $where = $LANG_STATIC['centerblock_entire']; break;
                }
                $retval = $where;
            } else {
                $retval = $LANG_STATIC['centerblock_no'];
            }
            break;
        case "unixdate":
            $retval = strftime ($_CONF['daytime'], $A['unixdate']);
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
* @param    string  $sp_content the content (HTML or PHP source)
* @param    int     $sp_php     flag: 1 = content is PHP source, 0 = is HTML
* @return   string              rendered content (HTML)
*
*/
function SP_render_content ($sp_content, $sp_php)
{
    global $_SP_CONF, $LANG_STATIC;

    $retval = '';

    if ($_SP_CONF['allow_php'] == 1) {
        // Check for type (ie html or php)
        if ($sp_php == 1) {
            $retval = eval ($sp_content);
        } else if ($sp_php == 2) {
            ob_start ();
            eval ($sp_content);
            $retval = ob_get_contents ();
            ob_end_clean ();
        } else {
            $retval = $sp_content;
        }
        $retval = PLG_replacetags ($retval);
    } else {
        if ($sp_php != 0) {
            COM_errorLog ("PHP in static pages is disabled. Can not display page '$page'.", 1);
            $retval .= $LANG_STATIC['deny_msg'];
        } else {
            $retval .= PLG_replacetags ($sp_content);
        }
    }

    return $retval;
}

/**
 * Return true since this plugin supports webservices
 *
 * @return  bool	True, if webservices are supported
 */
function plugin_wsEnabled_staticpages()
{
    return true;
}

/**
* Return headlines for New Static Pages section in the What's New block, if enabled
*
* @return   mixed       array(headline, byline), or boolean false if disabled
*
*/
function plugin_whatsnewsupported_staticpages()
{
    global $_SP_CONF, $LANG_STATIC, $LANG_WHATSNEW;

    if ($_SP_CONF['hidenewstaticpages'] == 0) {
        $retval = array($LANG_STATIC['pages'],
                        COM_formatTimeString($LANG_WHATSNEW['new_last'],
                                             $_SP_CONF['newstaticpagesinterval'])
                       );
    } else {
        $retval = false;
    }

    return $retval;
}

/**
* Return new Static Pages for the What's New block
*
* @return   string  HTML list of new staticpages
*
*/
function plugin_getwhatsnew_staticpages()
{
    global $_CONF, $_TABLES, $_SP_CONF, $LANG_STATIC;

    $retval = '';

    $extra_sql = "";
    if ($_SP_CONF['includecenterblocks'] == 0) {
        $extra_sql =' AND sp_centerblock = 0';
    }
    if ($_SP_CONF['includephp'] == 0) {
        $extra_sql .=' AND sp_php = 0';
    }
    
    $sql = "SELECT sp_id, sp_title 
        FROM {$_TABLES['staticpage']} 
        WHERE NOT ISNULL(sp_content) AND (sp_date >= (DATE_SUB(NOW(), INTERVAL {$_SP_CONF['newstaticpagesinterval']} SECOND))) 
        {$extra_sql} 
        " . COM_getPermSQL( 'AND' ) . " 
        ORDER BY sp_date DESC LIMIT 15";

    $result = DB_query( $sql );

    $nrows = DB_numRows( $result );

    if( $nrows > 0)
    {
        $newstaticpages = array();

        for( $x = 0; $x < $nrows; $x++ )
        {
            $A = DB_fetchArray( $result );

            $url = COM_buildUrl( $_CONF['site_url']
                . '/staticpages/index.php?page=' . $A['sp_id'] );                

            $title = COM_undoSpecialChars( stripslashes( $A['sp_title'] ));
            $titletouse = COM_truncate( $title, $_SP_CONF['title_trim_length'],
                                        '...' );
            if( $title != $titletouse )
            {
                $attr = array('title' => htmlspecialchars($title));
            }
            else
            {
                $attr = array();
            }
            $astaticpage = str_replace( '$', '&#36;', $titletouse );
            $astaticpage = str_replace( ' ', '&nbsp;', $astaticpage );

            $newstaticpages[] = COM_createLink($astaticpage, $url, $attr);
        }

        $retval .= COM_makeList( $newstaticpages, 'list-new-plugins' );
    }
    else
    {
        $retval .= $LANG_STATIC['no_new_pages'] . '<br' . XHTML . '>' . LB;
    }

    return $retval;
}

/**
* Return information for a static page
*
* @param    string  $sp_id      static page ID or '*'
* @param    string  $what       comma-separated list of properties
* @param    int     $uid        user ID or 0 = current user
* @param    array   $options    (reserved for future extensions)
* @return   mixed               string or array of strings with the information
*
*/
function plugin_getiteminfo_staticpages($sp_id, $what, $uid = 0, $options = array())
{
    global $_CONF, $_TABLES;

    // parse $what to see what we need to pull from the database
    $properties = explode(',', $what);
    $fields = array();
    foreach ($properties as $p) {
        switch ($p) {
        case 'date-modified':
            $fields[] = 'UNIX_TIMESTAMP(sp_date) AS unixdate';
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
        case 'url':
            // needed for $sp_id == '*', but also in case we're only requesting
            // the URL (so that $fields isn't emtpy)
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
    if ($sp_id == '*') {
        $where = '';
        $permOp = 'WHERE';
    } else {
        $where = " WHERE sp_id = '" . addslashes($sp_id) . "'";
        $permOp = 'AND';
    }
    if ($uid > 0) {
        $permSql = COM_getPermSql($permOp, $uid);
    } else {
        $permSql = COM_getPermSql($permOp);
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
            case 'date-modified':
                $props['date-modified'] = $A['unixdate'];
                break;
            case 'description':
            case 'excerpt':
                $props[$p] = SP_render_content(stripslashes($A['sp_content']),
                                                            $A['sp_php']);
                break;
            case 'id':
                $props['id'] = $A['sp_id'];
                break;
            case 'title':
                $props['title'] = stripslashes($A['sp_title']);
                break;
            case 'url':
                if (empty($A['sp_id'])) {
                    $props['url'] = COM_buildUrl($_CONF['site_url']
                            . '/staticpages/index.php?page=' . $sp_id);
                } else {
                    $props['url'] = COM_buildUrl($_CONF['site_url']
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
* @param    string  $file   documentation file being requested, e.g. 'config'
* @return   mixed           URL or false when not available
*
*/
function plugin_getdocumentationurl_staticpages($file)
{
    global $_CONF;

    static $docurl;

    switch ($file) {
    case 'index':
    case 'config':
        if (isset($docurl)) {
            $retval = $docurl;
        } else {
            $doclang = COM_getLanguageName();
            $docs = 'docs/' . $doclang . '/staticpages.html';
            if (file_exists($_CONF['path_html'] . $docs)) {
                $retval = $_CONF['site_url'] . '/' . $docs;
            } else {
                $retval = $_CONF['site_url'] . '/docs/english/staticpages.html';
            }
            $docurl = $retval;
        }
        break;

    default:
        $retval = false;
        break;
    }

    return $retval;
}

/**
* Provide URL and ID for the link to a comment's parent
*
* NOTE: The Plugin API does not support $_CONF['url_rewrite'] here,
*       so we'll end up with a non-rewritten URL ...
*
* @return   array   array consisting of the base URL and the ID name
*
*/
function plugin_getcommenturlid_staticpages()
{
    global $_CONF;

    $tmp = array(
        $_CONF['site_url'] . '/staticpages/index.php',
        'page'
    );

    return $tmp;
}

?>
