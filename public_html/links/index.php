<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Links Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This is the main page for the Geeklog Links Plugin                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Tom Willett       - tomw AT pigstye DOT net                      |
// |          Trinity Bays      - trinity93 AT gmail DOT com                   |
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

/**
 * This is the links page
 *
 * @package Links
 * @subpackage public_html
 * @filesource
 * @version 2.1
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2010
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Tony Bibbs, tony AT tonybibbs DOT com
 * @author Mark Limburg, mlimburg AT users DOT sourceforge DOT net
 * @author Jason Whittenburg, jwhitten AT securitygeeks DOT com
 * @author Tom Willett, tomw AT pigstye DOT net
 * @author Trinity Bays, trinity93 AT gmail DOT com
 * @author Dirk Haun, dirk AT haun-online DOT de
 *
 */

/** 
* Geeklog common function library
*/
require_once '../lib-common.php';

if (!in_array('links', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

/**
* Create the links list depending on the category given
*
* @param    array   $message    message(s) to display
* @return   string              the links page
*
*/
function links_list($message)
{
    global $_CONF, $_TABLES, $_LI_CONF, $LANG_LINKS_ADMIN, $LANG_LINKS,
           $LANG_LINKS_STATS;

    $cid = $_LI_CONF['root'];
    $display = '';
    if (isset($_GET['category'])) {
        $cid = strip_tags(COM_stripslashes($_GET['category']));
    } elseif (isset($_POST['category'])) {
        $cid = strip_tags(COM_stripslashes($_POST['category']));
    }
    $cat = addslashes($cid);
    $page = 0;
    if (isset ($_GET['page'])) {
        $page = COM_applyFilter ($_GET['page'], true);
    }
    if ($page == 0) {
        $page = 1;
    }

    if (empty($cid)) {
        if ($page > 1) {
            $page_title = sprintf ($LANG_LINKS[114] . ' (%d)', $page);
        } else {
            $page_title = $LANG_LINKS[114];
        }
    } else {
        if ($cid == $_LI_CONF['root']) {
            $category = $LANG_LINKS['root'];
        } else {
            $category = DB_getItem($_TABLES['linkcategories'], 'category',
                                   "cid = '{$cat}'");
        }
        if ($page > 1) {
            $page_title = sprintf ($LANG_LINKS[114] . ': %s (%d)', $category,
                                                                   $page);
        } else {
            $page_title = sprintf ($LANG_LINKS[114] . ': %s', $category);
        }
    }
    
    // Check has access and existent to this category
    if ($cid != $_LI_CONF['root']) {
        $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['linkcategories']} WHERE cid='{$cat}'");
        $A = DB_fetchArray($result);
        if (SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']) < 2) {
            $display .= COM_siteHeader ('menu', $page_title);
            $display .= COM_showMessage (5, 'links');
            $display .= COM_siteFooter ();
            COM_output($display);
            exit;
        }
        
        // check existent
        if ( !isset($A['owner_id']) ) {
            $display .= COM_siteHeader ('menu', $page_title);
            $display .= COM_showMessage (16, 'links');
            $display .= COM_siteFooter ();
            COM_output($display);
            exit;
        }
    }

    $display .= COM_siteHeader ('menu', $page_title);

    if (is_array($message) && !empty($message[0])) {
        $display .= COM_startBlock($message[0], '',
                                 COM_getBlockTemplate('_msg_block', 'header'));
        $display .= $message[1];
        $display .= COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
    } else if (isset($_REQUEST['msg'])) {
        $msg = COM_applyFilter($_REQUEST['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage($msg, 'links');
        }
    }

    $linklist = COM_newTemplate($_CONF['path'] . 'plugins/links/templates/');
    $linklist->set_file (array ('linklist' => 'links.thtml',
                                'catlinks' => 'categorylinks.thtml',
                                'link'     => 'linkdetails.thtml',
                                'catnav'   => 'categorynavigation.thtml',
                                'catrow'   => 'categoryrow.thtml',
                                'catcol'   => 'categorycol.thtml',
                                'actcol'   => 'categoryactivecol.thtml',
                                'pagenav'  => 'pagenavigation.thtml',
                                'catdrop'  => 'categorydropdown.thtml'));
    $linklist->set_var('blockheader', COM_startBlock($LANG_LINKS[114]));

    if ($_LI_CONF['linkcols'] > 0) {
        // Create breadcrumb trail
        $linklist->set_var('breadcrumbs',
                           links_breadcrumbs($_LI_CONF['root'], $cid));

        // Set dropdown for category jump
        $linklist->set_var('lang_go', $LANG_LINKS[124]);
        $linklist->set_var('link_dropdown', links_select_box(2, $cid));

        // Show categories
        $sql = "SELECT cid,pid,category,description FROM {$_TABLES['linkcategories']} WHERE pid='{$cat}'";
        $sql .= COM_getLangSQL('cid', 'AND');
        $sql .= COM_getPermSQL('AND') . " ORDER BY category";
        $result = DB_query($sql);
        $nrows  = DB_numRows ($result);
        if ($nrows > 0) {
            $linklist->set_var ('lang_categories', $LANG_LINKS_ADMIN[14]);
            for ($i = 1; $i <= $nrows; $i++) {
                $C = DB_fetchArray($result);
                // Get number of child links user can see in this category
                $ccid = addslashes($C['cid']);
                $result1 = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['links']} WHERE cid='{$ccid}'" . COM_getPermSQL('AND'));
                $D = DB_fetchArray($result1);

                // Get number of child categories user can see in this category
                $result2 = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['linkcategories']} WHERE pid='{$ccid}'" . COM_getPermSQL('AND'));
                $E = DB_fetchArray($result2);

                // Format numbers for display
                $display_count = '';
                // don't show zeroes
                if ($E['count']>0) {
                    $display_count = COM_numberFormat ($E['count']);
                }
                if (($E['count']>0) && ($D['count']>0)) {
                    $display_count .= ', ';
                }
                if ($D['count']>0) {
                    $display_count .= COM_numberFormat ($D['count']);
                }
                // add brackets if child items exist
                if ($display_count<>'') {
                    $display_count = '('.$display_count.')';
                }

                $linklist->set_var ('category_name', $C['category']);
                if ($_LI_CONF['show_category_descriptions']) {
                    $linklist->set_var ('category_description', PLG_replaceTags( $C['description'] ));
                } else {
                    $linklist->set_var ('category_description', '');
                }
                $linklist->set_var ('category_link', $_CONF['site_url'] .
                    '/links/index.php?category=' . rawurlencode ($C['cid']));
                $linklist->set_var ('category_count', $display_count);
                $linklist->set_var ('width', floor (100 / $_LI_CONF['linkcols']));
                if (!empty($cid) && ($cid == $C['cid'])) {
                    $linklist->parse ('category_col', 'actcol', true);
                } else {
                    $linklist->parse ('category_col', 'catcol', true);
                }
                if ($i % $_LI_CONF['linkcols'] == 0) {
                    $linklist->parse ('category_row', 'catrow', true);
                    $linklist->set_var ('category_col', '');
                }
            }
            if ($nrows % $_LI_CONF['linkcols'] != 0) {
                $linklist->parse ('category_row', 'catrow', true);
            }
            $linklist->parse ('category_navigation', 'catnav', true);
        } else {
            $linklist->set_var ('category_navigation', '');
        }
    } else {
        $linklist->set_var ('category_navigation', '');
    }
    if ($_LI_CONF['linkcols'] == 0) {
        $linklist->set_var('category_dropdown', '');
    } else {
        $linklist->parse('category_dropdown', 'catdrop', true);
    }

    $linklist->set_var('cid', $cid);
    $linklist->set_var('cid_plain', $cid);
    $linklist->set_var('cid_encoded', rawurlencode($cid));
    $linklist->set_var('lang_addalink', $LANG_LINKS[116]);

    // Build SQL for links
    $sql = 'SELECT lid,cid,url,description,title,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon';
    $from_where = " FROM {$_TABLES['links']}";
    if ($_LI_CONF['linkcols'] > 0) {
        if (!empty($cid)) {
            $from_where .= " WHERE cid='" . addslashes($cid) . "'";
        } else {
            $from_where .= " WHERE cid=''";
        }
        $from_where .= COM_getPermSQL ('AND');
    } else {
        $from_where .= COM_getPermSQL ();
    }
    $order = ' ORDER BY cid ASC,title';
    $limit = '';
    if ($_LI_CONF['linksperpage'] > 0) {
        if ($page < 1) {
            $start = 0;
        } else {
            $start = ($page - 1) * $_LI_CONF['linksperpage'];
        }
        $limit = ' LIMIT ' . $start . ',' . $_LI_CONF['linksperpage'];
    }
    $result = DB_query ($sql . $from_where . $order . $limit);
    $nrows = DB_numRows ($result);

    if ($nrows == 0) {
        if (($cid == $_LI_CONF['root']) && ($page <= 1) && $_LI_CONF['show_top10']) {
            $result = DB_query("SELECT lid,url,title,description,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']} WHERE (hits > 0)" . COM_getPermSQL('AND') . LINKS_getCategorySQL('AND') . " ORDER BY hits DESC LIMIT 10");
            $nrows  = DB_numRows ($result);
            if ($nrows > 0) {
                $linklist->set_var ('link_details', '');
                $linklist->set_var ('link_category',
                                    $LANG_LINKS_STATS['stats_headline']);
                for ($i = 0; $i < $nrows; $i++) {
                    $A = DB_fetchArray ($result);
                    prepare_link_item ($A, $linklist);
                    $linklist->parse ('link_details', 'link', true);
                }
                $linklist->parse ('category_links', 'catlinks', true);
            }
        }
        $linklist->set_var ('page_navigation', '');
    } else {
        $currentcid = '';
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            if (strcasecmp ($A['cid'], $currentcid) != 0) {
                // print the category and link
                if ($i > 0) {
                    $linklist->parse('category_links', 'catlinks', true);
                    $linklist->set_var('link_details', '');
                }
                $currentcid = $A['cid'];
                $currentcategory = DB_getItem($_TABLES['linkcategories'],
                        'category', "cid = '" . addslashes($currentcid) . "'");
                if ($A['cid'] == $_LI_CONF['root']) {
                    $linklist->set_var('link_category', $LANG_LINKS['root']);
                } else {
                    $linklist->set_var('link_category', $currentcategory);
                }
            }

            prepare_link_item($A, $linklist);
            $linklist->parse('link_details', 'link', true);
        }
        $linklist->parse('category_links', 'catlinks', true);

        $result = DB_query ('SELECT COUNT(*) AS count ' . $from_where);
        list($numlinks) = DB_fetchArray ($result);
        $pages = 0;
        if ($_LI_CONF['linksperpage'] > 0) {
            $pages = (int) ($numlinks / $_LI_CONF['linksperpage']);
            if (($numlinks % $_LI_CONF['linksperpage']) > 0 ) {
                $pages++;
            }
        }
        if ($pages > 0) {
            if (($_LI_CONF['linkcols'] > 0) && !empty($currentcid)) {
                $catlink = '?category=' . rawurlencode($currentcid);
            } else {
                $catlink = '';
            }
            $linklist->set_var('page_navigation',
                    COM_printPageNavigation($_CONF['site_url']
                        . '/links/index.php' . $catlink, $page, $pages));
        } else {
            $linklist->set_var ('page_navigation', '');
        }
    }
    $linklist->set_var ('blockfooter',COM_endBlock());
    $linklist->parse ('output', 'linklist');
    $display .= $linklist->finish ($linklist->get_var ('output'));

    return $display;
}


/**
* Prepare a link item for rendering
*
* @param    array   $A          link details
* @param    ref     $template   reference of the links template
*
*/
function prepare_link_item($A, &$template)
{
    global $_CONF, $_LI_CONF, $LANG_ADMIN, $LANG_LINKS, $LANG_DIRECTION,
           $_IMAGE_TYPE;

    $url = COM_buildUrl($_CONF['site_url']
                        . '/links/portal.php?what=link&amp;item=' . $A['lid']);
    $actualUrl = stripslashes($A['url']);
    $title = stripslashes($A['title']);

    $template->set_var('link_url', $url);
    $template->set_var('link_actual_url', $actualUrl);
    $template->set_var('link_actual_url_encoded', rawurlencode($actualUrl));
    $template->set_var('link_name', $title);
    $template->set_var('link_name_encoded', rawurlencode($title));
    $template->set_var('link_hits', COM_numberFormat($A['hits']));
    $template->set_var('link_description',
                       PLG_replaceTags( nl2br(stripslashes($A['description'])) ));

    $attr = array('title' => $actualUrl);
    if (substr($actualUrl, 0, strlen($_CONF['site_url'])) != $_CONF['site_url']) {
        $class = 'ext-link';
        if ((!empty($LANG_DIRECTION)) && ($LANG_DIRECTION == 'rtl')) {
            $class .= '-rtl';
        }
        $attr['class'] = $class;
        if ($_LI_CONF['new_window']) {
            $attr['target'] = '_blank';
        }
    }
    $html = COM_createLink($title, $url, $attr);
    $template->set_var('link_html', $html);

    if (!COM_isAnonUser() && !SEC_hasRights('links.edit')) {
        $reporturl = $_CONF['site_url']
                   . '/links/index.php?mode=report&amp;lid=' . $A['lid'];
        $template->set_var('link_broken',
                COM_createLink($LANG_LINKS[117], $reporturl,
                               array('class' => 'pluginSmallText',
                                     'rel'   => 'nofollow'))
        );
    } else {
        $template->set_var('link_broken', '');
    }

    if ((SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'],
            $A['perm_group'], $A['perm_members'], $A['perm_anon']) == 3) &&
            SEC_hasRights('links.edit')) {
        $editurl = $_CONF['site_admin_url']
                 . '/plugins/links/index.php?mode=edit&amp;lid=' . $A['lid'];
        $template->set_var('link_edit',
                           COM_createLink($LANG_ADMIN['edit'], $editurl));
        $edit_icon = "<img src=\"{$_CONF['layout_url']}/images/edit.$_IMAGE_TYPE\" "
            . "alt=\"{$LANG_ADMIN['edit']}\" title=\"{$LANG_ADMIN['edit']}\"" . XHTML . ">";
        $template->set_var('edit_icon', COM_createLink($edit_icon, $editurl));
    } else {
        $template->set_var('link_edit', '');
        $template->set_var('edit_icon', '');
    }
}


// MAIN

$display = '';
$mode = '';
$root = $_LI_CONF['root'];
if (isset ($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

$message = array();
if (($mode == 'report') && !COM_isAnonUser()) {
    if (isset ($_GET['lid'])) {
        $lid = COM_applyFilter($_GET['lid']);
    }
    if (!empty($lid)) {
        $lidsl = addslashes($lid);
        $result = DB_query("SELECT url, title FROM {$_TABLES['links']} WHERE lid = '$lidsl'");
        list($url, $title) = DB_fetchArray($result);

        $editurl = $_CONF['site_admin_url']
                 . '/plugins/links/index.php?mode=edit&lid=' . $lid;
        $msg = $LANG_LINKS[119] . LB . LB . "$title, <$url>". LB . LB
             .  $LANG_LINKS[120] . LB . '<' . $editurl . '>' . LB . LB
             .  $LANG_LINKS[121] . $_USER['username'] . ', IP: '
             . $_SERVER['REMOTE_ADDR'];
        COM_mail($_CONF['site_mail'], $LANG_LINKS[118], $msg);
        $message = array($LANG_LINKS[123], $LANG_LINKS[122]);
    }
}

if (COM_isAnonUser() &&
    (($_CONF['loginrequired'] == 1) || ($_LI_CONF['linksloginrequired'] == 1))) {
    $display .= COM_siteHeader('menu', $LANG_LINKS[114]);
    $display .= SEC_loginRequiredForm();
} else {
    $display .= links_list($message);
}

$display .= COM_siteFooter ();

COM_output($display);

?>
