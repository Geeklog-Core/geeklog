<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Links Plugin 1.0                                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | This is the main page for the Geeklog Links Plugin                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Tom Willett       - tomw AT pigstye DOT net                      |
// |          Trinity Bays      - trinity AT steubentech DOT com               |
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
//
/**
 * This is the links page
 *
 * @package Links
 * @subpackage public_html
 * @filesource
 * @version 1.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005-2006
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Tony Bibbs <tony AT tonybibbs DOT com>
 * @author Mark Limburg <mlimburg AT users DOT sourceforge DOT net>
 * @author Jason Whittenburg <jwhitten AT securitygeeks DOT com>
 * @author Tom Willett <tomw AT pigstye DOT net>
 * @author Trinity Bays <trinity AT steubentech DOT com>
 * @author Dirk Haun <dirk AT haun-online DOT de>
 *
 */
// $Id: index.php,v 1.14 2007/02/08 05:57:18 ospiess Exp $

require_once ('../lib-common.php');

/**
* Prepare a link item for rendering
*
* @param    array   $A          link details
* @param    ref     $template   reference of the links template
*
*/
function prepare_link_item ($A, &$template)
{
    global $_CONF, $LANG_ADMIN, $LANG_LINKS, $_IMAGE_TYPE;

    $url = COM_buildUrl ($_CONF['site_url']
                 . '/links/portal.php?what=link&amp;item=' . $A['lid']);
    $template->set_var ('link_url', $url);
    $template->set_var ('link_actual_url', $A['url']);
    $template->set_var ('link_name', stripslashes ($A['title']));
    $template->set_var ('link_hits', COM_numberFormat ($A['hits']));
    $template->set_var ('link_description',
                        nl2br (stripslashes ($A['description'])));
    $reporturl = $_CONF['admin_url']
             . '/links/index.php?mode=report&amp;lid=' . $A['lid']
             . '&amp;url='. $A['url'] . '&amp;title=' . stripslashes ($A['title']);
    $template->set_var ('link_broken',
        COM_createLink($LANG_LINKS[117], $reporturl, array('class'=>"pluginSmallText"))
    );

    if ((SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
            $A['perm_group'], $A['perm_members'], $A['perm_anon']) == 3) &&
            SEC_hasRights ('links.edit')) {
        $editurl = $_CONF['site_admin_url']
                 . '/plugins/links/index.php?mode=edit&amp;lid=' . $A['lid'];
        $template->set_var ('link_edit', COM_createLink($LANG_ADMIN['edit'],$editurl));
        $edit_icon = "<img src=\"{$_CONF['layout_url']}/images/edit$_IMAGE_TYPE\" "
            . "alt=\"{$LANG_ADMIN['edit']}\" title=\"{$LANG_ADMIN['edit']}\">";
        $template->set_var ('edit_icon', COM_createLink($edit_icon, $editurl));
    } else {
        $template->set_var ('link_edit', '');
        $template->set_var ('edit_icon', '');
    }

}


// MAIN

$display = '';
$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

if ($mode == 'report') {
    if (isset ($_GET['title'])) {
        $title = COM_applyFilter ($_GET['title']);
    }
    if (isset ($_GET['lid'])) {
        $lid = COM_applyFilter ($_GET['lid']);
    }
    if (isset ($_GET['url'])) {
        $url = COM_applyFilter ($_GET['url']);
    }
    $editurl = $_CONF['site_admin_url']
        . '/plugins/links/index.php?mode=edit&amp;lid=' . $lid;
    $msg = $LANG_LINKS[119] . " $title ( $url )". LB
        .  $LANG_LINKS[120] . $editurl . LB
        .  $LANG_LINKS[121] . $_USER['username'] . ", IP: " . $_SERVER["REMOTE_ADDR"];
    COM_mail($_CONF['site_mail'], $LANG_LINKS[118], $msg, $_CONF['site_mail']);
    $message = array ($LANG_LINK[123], $LANG_LINK[122]);
}

if (empty ($_USER['username']) &&
    (($_CONF['loginrequired'] == 1) || ($_LI_CONF['linksloginrequired'] == 1))) {
    $display .= COM_siteHeader ('menu', $LANG_LINKS[114]);
    $display .= COM_startBlock ($LANG_LOGIN[1], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $login = new Template ($_CONF['path_layout'] . 'submit');
    $login->set_file (array ('login' => 'submitloginrequired.thtml'));
    $login->set_var ('login_message', $LANG_LOGIN[2]);
    $login->set_var ('site_url', $_CONF['site_url']);
    $login->set_var ('lang_login', $LANG_LOGIN[3]);
    $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
    $login->parse ('output', 'login');
    $display .= $login->finish ($login->get_var ('output'));
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
} else {
    $category = '';
    if (isset ($_GET['category'])) {
        $category = strip_tags (COM_stripslashes ($_GET['category']));
    }
    $page = 0;
    if (isset ($_GET['page'])) {
        $page = COM_applyFilter ($_GET['page'], true);
    }
    if ($page == 0) {
        $page = 1;
    }

    if (empty ($category)) {
        if ($page > 1) {
            $page_title = sprintf ($LANG_LINKS[114] . ' (%d)', $page);
        } else {
            $page_title = $LANG_LINKS[114];
        }
    } else {
        if ($page > 1) {
            $page_title = sprintf ($LANG_LINKS[114] . ': %s (%d)', $category,
                                                                   $page);
        } else {
            $page_title = sprintf ($LANG_LINKS[114] . ': %s', $category);
        }
    }
    $display .= COM_siteHeader ('menu', $page_title);

    if (!empty($message[0])) {
        $display .= COM_startBlock ($message[0], '',
            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $message[1];
        $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    $linklist = new Template ($_CONF['path'] . 'plugins/links/templates/');
    $linklist->set_file (array ('linklist' => 'links.thtml',
                                'catlinks' => 'categorylinks.thtml',
                                'link'     => 'linkdetails.thtml',
                                'catnav'   => 'categorynavigation.thtml',
                                'catrow'   => 'categoryrow.thtml',
                                'catcol'   => 'categorycol.thtml',
                                'actcol'   => 'categoryactivecol.thtml',
                                'pagenav'  => 'pagenavigation.thtml'));
    $linklist->set_var ('blockheader',COM_startBlock($LANG_LINKS[114]));
    $linklist->set_var ('layout_url',$_CONF['layout_url']);

    if ($_LI_CONF['linkcols'] > 0) {
        $result = DB_query ("SELECT DISTINCT category FROM {$_TABLES['links']}" . COM_getPermSQL () . " ORDER BY category");
        $nrows  = DB_numRows ($result);
        if ($nrows > 0) {
            $linklist->set_var ('lang_categories', $LANG_LINKS_ADMIN[14]);
            for ($i = 1; $i <= $nrows; $i++) {
                $C = DB_fetchArray ($result);
                $cat = addslashes ($C['category']);
                $result1 = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['links']} WHERE category = '{$cat}'" . COM_getPermSQL ('AND'));
                $D = DB_fetchArray ($result1);
                if (empty ($C['category'])) {
                    $linklist->set_var ('category_name', $LANG_LINKS_ADMIN[7]);
                } else {
                    $linklist->set_var ('category_name', $C['category']);
                }
                $linklist->set_var ('category_link', $_CONF['site_url'] .
                    '/links/index.php?category=' . urlencode ($C['category']));
                $linklist->set_var ('category_count',
                                    COM_numberFormat ($D['count']));
                $linklist->set_var ('width', floor (100 / $_LI_CONF['linkcols']));
                if (!empty ($category) && ($category == $C['category'])) {
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

    $linklist->set_var ('site_url', $_CONF['site_url']);
    $linklist->set_var ('lang_addalink', $LANG_LINKS[116]);

    $sql = 'SELECT lid,category,url,description,title,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon';
    $from_where = " FROM {$_TABLES['links']}";
    if ($_LI_CONF['linkcols'] > 0) {
        if (!empty ($category)) {
            $from_where .= " WHERE category = '" . addslashes ($category) . "'";
        } else {
            $from_where .= " WHERE category = ''";
        }
        $from_where .= COM_getPermSQL ('AND');
    } else {
        $from_where .= COM_getPermSQL ();
    }
    $order = ' ORDER BY category ASC,title';
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
        if (empty ($category) && ($page <= 1) && $_LI_CONF['show_top10']) {
            $result = DB_query ("SELECT lid,url,title,description,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']} WHERE (hits > 0)" . COM_getPermSQL ('AND') . " ORDER BY hits DESC LIMIT 10");
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
        $currentcategory = '';
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray ($result);
            if (strcasecmp ($A['category'], $currentcategory) != 0) {
                // print the category and link
                if ($i > 0) {
                    $linklist->parse ('category_links', 'catlinks', true);
                    $linklist->set_var ('link_details', '');
                }
                $currentcategory = $A['category'];
                $linklist->set_var ('link_category', $currentcategory);
            }

            prepare_link_item ($A, $linklist);
            $linklist->parse ('link_details', 'link', true);
        }
        $linklist->parse ('category_links', 'catlinks', true);

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
            if (($_LI_CONF['linkcols'] > 0) && isset ($currentcategory)) {
                $catlink = '?category=' . urlencode ($currentcategory);
            } else {
                $catlink = '';
            }
            $linklist->set_var ('page_navigation',
                    COM_printPageNavigation ($_CONF['site_url']
                        . '/links/index.php' .  $catlink, $page, $pages));
        } else {
            $linklist->set_var ('page_navigation', '');
        }
    }
    $linklist->set_var ('blockfooter',COM_endBlock());
    $linklist->parse ('output', 'linklist');
    $display .= $linklist->finish ($linklist->get_var ('output'));

}

$display .= COM_siteFooter ();

echo $display;

?>
