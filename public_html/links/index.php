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
 * 
 */
// $Id: index.php,v 1.8 2006/03/12 18:16:14 dhaun Exp $

require_once ('../lib-common.php');

// MAIN

$display = '';

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

    $display .= COM_startBlock ($LANG_LINKS[114]);

    $linklist = new Template ($_CONF['path'] . 'plugins/links/templates/');
    $linklist->set_file (array ('linklist' => 'links.thtml',
                                'catlinks' => 'categorylinks.thtml',
                                'link'     => 'linkdetails.thtml',
                                'catnav'   => 'categorynavigation.thtml',
                                'catrow'   => 'categoryrow.thtml',
                                'catcol'   => 'categorycol.thtml',
                                'actcol'   => 'categoryactivecol.thtml',
                                'pagenav'  => 'pagenavigation.thtml'));

    if ($_LI_CONF['linkcols'] > 0) {
        $result = DB_query ("SELECT DISTINCT category FROM {$_TABLES['links']}" . COM_getPermSQL () . " ORDER BY category");
        $nrows  = DB_numRows ($result);
        if ($nrows > 0) {
            $linklist->set_var ('lang_categories', $LANG_LINKS_ADMIN[14]);
            for ($i = 0; $i < $nrows; $i++) {
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

    $sql = "SELECT lid,category,url,description,title,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']}";
    if ($_LI_CONF['linkcols'] > 0) {
        if (!empty ($category)) {
            $sql .= " WHERE category = '" . addslashes ($category) . "'";
        } else {
            $sql .= " WHERE category = ''";
        }
        $sql .= COM_getPermSQL ('AND');
    } else {
        $sql .= COM_getPermSQL ();
    }
    $sql .= ' ORDER BY category ASC,title';
    $result = DB_query ($sql);
    $nrows = DB_numRows ($result);
    if ($nrows == 0) {
        $page = 0;

        $result = DB_query ("SELECT lid,url,title,description,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']} WHERE (hits > 0)" . COM_getPermSQL ('AND') . " ORDER BY hits DESC LIMIT 10");
        $nrows  = DB_numRows ($result);
        if ($nrows > 0) {
            $linklist->set_var ('link_details', '');
            $linklist->set_var ('link_category',
                                $LANG_LINKS_STATS['stats_headline']);
            for ($i = 0; $i < $nrows; $i++) {
                $A = DB_fetchArray ($result);
                $linklist->set_var ('link_url', COM_buildUrl ($_CONF['site_url']
                    . '/links/portal.php?what=link&amp;item=' . $A['lid']));
                $linklist->set_var ('link_actual_url', $A['url']);
                $linklist->set_var ('link_name', stripslashes($A['title']));
                $linklist->set_var ('link_hits', COM_numberFormat ($A['hits']));
                $linklist->set_var ('link_description',
                        nl2br (stripslashes ($A['description'])));
                if ((SEC_hasAccess ($A['owner_id'], $A['group_id'],
                        $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                        $A['perm_anon']) == 3) && SEC_hasRights('links.edit')) {
                    $editurl = $_CONF['site_admin_url']
                             . '/plugins/links/index.php?mode=edit&amp;lid='
                             . $A['lid'];
                    $linklist->set_var ('link_edit', '<a href="' . $editurl
                            . '">' . $LANG_ADMIN['edit'] . '</a>');
                    $linklist->set_var ('edit_icon', '<a href="' . $editurl
                            . '"><img src="' . $_CONF['layout_url']
                            . '/images/edit.' . $_IMAGE_TYPE . '" alt="'
                            . $LANG_ADMIN['edit'] . '" title="'
                            . $LANG_ADMIN['edit'] . '" border="0"></a>');
                } else {
                    $linklist->set_var ('link_edit', '');
                    $linklist->set_var ('edit_icon', '');
                }
                $linklist->parse ('link_details', 'link', true);
            }
            $linklist->parse ('category_links', 'catlinks', true);
        }
    } else {
        if ($_LI_CONF['linksperpage'] == 0) {
            $start = 1;
            $end = $nrows + 1;
        } else {
            if ($page > 0) {
                $start = (($page - 1) * $_LI_CONF['linksperpage']) + 1;
            } else {
                $page = 1;
                $start = 1;
            }
            $end = $start + $_LI_CONF['linksperpage'];
            if ($nrows < $end) {
                $end = $nrows + 1;
            }
        }

        $currentcategory = '';
        for ($i = 1; $i < $end; $i++) {
            $A = DB_fetchArray ($result);
            if ($i >= $start) {
                if ((strcasecmp ($A['category'], $currentcategory) != 0) AND ($i > $start)) {
                    // print the category and link
                    $linklist->parse ('category_links', 'catlinks', true);
                    $linklist->set_var ('link_details', '');
                    $currentcategory = $A['category'];
                    $linklist->set_var ('link_category', $currentcategory);
                } else if (strcasecmp ($A['category'], $currentcategory) != 0) {
                    $currentcategory = $A['category'];
                    $linklist->set_var ('link_category', $currentcategory);
                }
                $linklist->set_var ('link_url', COM_buildUrl ($_CONF['site_url']
                    . '/links/portal.php?what=link&amp;item=' . $A['lid']));
                $linklist->set_var ('link_actual_url', $A['url']);
                $linklist->set_var ('link_name', stripslashes ($A['title']));
                $linklist->set_var ('link_hits', COM_numberFormat ($A['hits']));
                $linklist->set_var ('link_description',
                        nl2br (stripslashes ($A['description'])));
                if ((SEC_hasAccess ($A['owner_id'], $A['group_id'],
                        $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                        $A['perm_anon']) == 3) && SEC_hasRights('links.edit')) {
                    $editurl = $_CONF['site_admin_url']
                             . '/plugins/links/index.php?mode=edit&amp;lid='
                             . $A['lid'];
                    $linklist->set_var ('link_edit', '<a href="' . $editurl
                            . '">' . $LANG_ADMIN['edit'] . '</a>');
                    $linklist->set_var ('edit_icon', '<a href="' . $editurl
                            . '"><img src="' . $_CONF['layout_url']
                            . '/images/edit.' . $_IMAGE_TYPE . '" alt="'
                            . $LANG_ADMIN['edit'] . '" title="'
                            . $LANG_ADMIN['edit'] . '" border="0"></a>');
                } else {
                    $linklist->set_var ('link_edit', '');
                    $linklist->set_var ('edit_icon', '');
                }
                $linklist->parse ('link_details', 'link', true);
            }
        }
        $linklist->parse ('category_links', 'catlinks', true);
    }

    if ($_LI_CONF['linksperpage'] > 0) {
        $pages = (int) ($nrows / $_LI_CONF['linksperpage']);
        if (($nrows % $_LI_CONF['linksperpage']) > 0 ) {
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
            COM_printPageNavigation ($_CONF['site_url'] . '/links/index.php' .
                                     $catlink, $page, $pages));
    } else {
        $linklist->set_var ('page_navigation', '');
    }

    $linklist->parse ('output', 'linklist');
    $display .= $linklist->finish ($linklist->get_var ('output'));
    $display .= COM_endBlock ();
}

$display .= COM_siteFooter ();

echo $display;

?>
