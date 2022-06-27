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
 * @package    Links
 * @subpackage public_html
 * @filesource
 * @version    2.1
 * @since      GL 1.4.0
 * @copyright  Copyright &copy; 2005-2010
 * @license    http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author     Tony Bibbs, tony AT tonybibbs DOT com
 * @author     Mark Limburg, mlimburg AT users DOT sourceforge DOT net
 * @author     Jason Whittenburg, jwhitten AT securitygeeks DOT com
 * @author     Tom Willett, tomw AT pigstye DOT net
 * @author     Trinity Bays, trinity93 AT gmail DOT com
 * @author     Dirk Haun, dirk AT haun-online DOT de
 */

 // Geeklog common function library. If VERSION set then lib-common already loaded. Check required for URL Routing functionality (with or without "index.php")
 if (!defined('VERSION')) {
     require_once '../lib-common.php';
 } else {
      // You have to set any global variables used by this file since the scope is different as it is routed through index.php (and lib-common is loaded from there. See Github Issue #945 for more info
      global $_CONF, $_PLUGINS, $_LI_CONF;
 }

if (!in_array('links', $_PLUGINS)) {
    COM_handle404();
    exit;
}

/**
 * Create the links list depending on the category given
 *
 * @param    array $message message(s) to display
 * @return   string              the links page
 */
function links_list($message)
{
    global $_CONF, $_TABLES, $_LI_CONF, $LANG_LINKS_ADMIN, $LANG_LINKS,
           $LANG_LINKS_STATS;

    define('LINKS_PLACEHOLDER', 'links_placeholder');

    $display = '';

    if ($_CONF['url_rewrite'] && !$_CONF['url_routing']) {
        COM_setArgNames(array('category'));
        $cid = COM_applyFilter(COM_getArgument('category'));
    } elseif ($_CONF['url_rewrite'] && $_CONF['url_routing']) {
        COM_setArgNames(array(LINKS_PLACEHOLDER, 'category'));
        $cid = COM_applyFilter(COM_getArgument('category'));
    } else {
        $cid = GLText::stripTags(Geeklog\Input::fGet('category'));
    }

    // If empty assume root
    if (empty($cid)) {
        $cid = $_LI_CONF['root'];
    }

    $cat = DB_escapeString($cid);
    $page = (int) Geeklog\Input::fGet('page', 0);
    if ($page == 0) {
        $page = 1;
    }

    if (empty($cid)) {
        if ($page > 1) {
            $page_title = sprintf($LANG_LINKS[114] . ' (%d)', $page);
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
            $page_title = sprintf($LANG_LINKS[114] . ': %s (%d)', $category,
                $page);
        } else {
            $page_title = sprintf($LANG_LINKS[114] . ': %s', $category);
        }
    }

    // Check has access and existent to this category
    if ($cid != $_LI_CONF['root']) {
        $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['linkcategories']} WHERE cid='{$cat}'");
        $nrows = DB_numRows($result);                                     

        if ($nrows == 1) {
			$A = DB_fetchArray($result);
			if (SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']) < 2) {
				$display .= COM_showMessage(5, 'links');
				$display = COM_createHTMLDocument($display, array('pagetitle' => $page_title));
				COM_output($display);
				exit;
			}

			// check existent
			if (!isset($A['owner_id'])) {
				$display .= COM_showMessage(16, 'links');
				$display = COM_createHTMLDocument($display, array('pagetitle' => $page_title));
				COM_output($display);
				exit;
			}
		} else {
			// Links Category doesn't exist
			COM_handle404($_CONF['site_url'] . '/links/index.php');
		}
    }

    if (is_array($message) && !empty($message[0])) {
        $display .= COM_showMessageText($message[1], $message[0]);
    } elseif (isset($_REQUEST['msg'])) {
        $msg = (int) Geeklog\Input::fRequest('msg');
        if ($msg > 0) {
            $display .= COM_showMessage($msg, 'links');
        }
    }

    $linkList = COM_newTemplate(CTL_plugin_templatePath('links'));
    $linkList->set_file(array(
        'linklist' => 'links.thtml',
        'catlinks' => 'categorylinks.thtml',
        'link'     => 'linkdetails.thtml',
        'catnav'   => 'categorynavigation.thtml',
        'catrow'   => 'categoryrow.thtml',
        'catcol'   => 'categorycol.thtml',
        'actcol'   => 'categoryactivecol.thtml',
        'pagenav'  => 'pagenavigation.thtml',
        'catdrop'  => 'categorydropdown.thtml',
    ));
    $linkList->set_var('blockheader', COM_startBlock($LANG_LINKS[114]));

    if ($_LI_CONF['linkcols'] > 0) {
        // Create breadcrumb trail
        $linkList->set_var('breadcrumbs',
            links_breadcrumbs($_LI_CONF['root'], $cid));

        // Set dropdown for category jump
        $linkList->set_var('lang_go', $LANG_LINKS[124]);
        $linkList->set_var('link_dropdown', links_select_box(2, $cid));

        // Show categories
        $sql = "SELECT cid,pid,category,description FROM {$_TABLES['linkcategories']} WHERE pid='{$cat}'";
        $sql .= COM_getLangSQL('cid', 'AND');
        $sql .= COM_getPermSQL('AND') . " ORDER BY category";
        $result = DB_query($sql);
        $nrows = DB_numRows($result);
        if ($nrows > 0) {
            $linkList->set_var('lang_categories', $LANG_LINKS_ADMIN[14]);
            for ($i = 1; $i <= $nrows; $i++) {
                $C = DB_fetchArray($result);
                // Get number of child links user can see in this category
                $ccid = DB_escapeString($C['cid']);
                $result1 = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['links']} WHERE cid='{$ccid}'" . COM_getPermSQL('AND'));
                $D = DB_fetchArray($result1);

                // Get number of child categories user can see in this category
                $result2 = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['linkcategories']} WHERE pid='{$ccid}'" . COM_getPermSQL('AND'));
                $E = DB_fetchArray($result2);

                // Format numbers for display
                $display_count = '';
                // don't show zeroes
                if ($E['count'] > 0) {
                    $display_count = COM_numberFormat($E['count']);
                }
                if (($E['count'] > 0) && ($D['count'] > 0)) {
                    $display_count .= ', ';
                }
                if ($D['count'] > 0) {
                    $display_count .= COM_numberFormat($D['count']);
                }
                // add brackets if child items exist
                if ($display_count <> '') {
                    $display_count = '(' . $display_count . ')';
                }

                $linkList->set_var('category_name', $C['category']);
                if ($_LI_CONF['show_category_descriptions']) {
                    $linkList->set_var('category_description', PLG_replaceTags($C['description']));
                } else {
                    $linkList->set_var('category_description', '');
                }
                $linkList->set_var(
                    'category_link',
                    COM_buildURL($_CONF['site_url'] . '/links/index.php?category=' . rawurlencode($C['cid']))
                );
                $linkList->set_var('category_count', $display_count);
                $linkList->set_var('width', floor(100 / $_LI_CONF['linkcols']));
                if (!empty($cid) && ($cid == $C['cid'])) {
                    $linkList->parse('category_col', 'actcol', true);
                } else {
                    $linkList->parse('category_col', 'catcol', true);
                }
                if ($i % $_LI_CONF['linkcols'] == 0) {
                    $linkList->parse('category_row', 'catrow', true);
                    $linkList->set_var('category_col', '');
                }
            }
            if ($nrows % $_LI_CONF['linkcols'] != 0) {
                $linkList->parse('category_row', 'catrow', true);
            }
            $linkList->parse('category_navigation', 'catnav', true);
        } else {
            $linkList->set_var('category_navigation', '');
        }
    } else {
        $linkList->set_var('category_navigation', '');
    }
    if ($_LI_CONF['linkcols'] == 0) {
        $linkList->set_var('category_dropdown', '');
    } else {
        $linkList->parse('category_dropdown', 'catdrop', true);
    }

    $linkList->set_var('cid', $cid);
    $linkList->set_var('cid_plain', $cid);
    $linkList->set_var('cid_encoded', rawurlencode($cid));
    $linkList->set_var('lang_addalink', $LANG_LINKS[116]);

    // Build SQL for links
    $sql = 'SELECT lid,cid,url,description,title,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon';
    $from_where = " FROM {$_TABLES['links']}";
    if ($_LI_CONF['linkcols'] > 0) {
        if (!empty($cid)) {
            $from_where .= " WHERE cid='" . DB_escapeString($cid) . "'";
        } else {
            $from_where .= " WHERE cid=''";
        }
        $from_where .= COM_getPermSQL('AND');
    } else {
        $from_where .= COM_getPermSQL();
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
    $result = DB_query($sql . $from_where . $order . $limit);
    $nrows = DB_numRows($result);

    if ($nrows == 0) {
        if (($cid == $_LI_CONF['root']) && ($page <= 1) && $_LI_CONF['show_top10']) {
            $result = DB_query("SELECT lid,url,title,description,hits,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['links']} WHERE (hits > 0)" . COM_getPermSQL('AND') . LINKS_getCategorySQL('AND') . " ORDER BY hits DESC LIMIT 10");
            $nrows = DB_numRows($result);
            if ($nrows > 0) {
                $linkList->set_var('link_details', '');
                $linkList->set_var('link_category',
                    $LANG_LINKS_STATS['stats_headline']);
                for ($i = 0; $i < $nrows; $i++) {
                    $A = DB_fetchArray($result);
                    prepare_link_item($A, $linkList);
                    $linkList->parse('link_details', 'link', true);
                }
                $linkList->parse('category_links', 'catlinks', true);
            }
        }
        $linkList->set_var('page_navigation', '');
    } else {
        $currentcid = '';
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            if (strcasecmp($A['cid'], $currentcid) != 0) {
                // print the category and link
                if ($i > 0) {
                    $linkList->parse('category_links', 'catlinks', true);
                    $linkList->set_var('link_details', '');
                }
                $currentcid = $A['cid'];
                $currentcategory = DB_getItem($_TABLES['linkcategories'],
                    'category', "cid = '" . DB_escapeString($currentcid) . "'");
                if ($A['cid'] == $_LI_CONF['root']) {
                    $linkList->set_var('link_category', $LANG_LINKS['root']);
                } else {
                    $linkList->set_var('link_category', $currentcategory);
                }
            }

            prepare_link_item($A, $linkList);
            $linkList->parse('link_details', 'link', true);
        }
        $linkList->parse('category_links', 'catlinks', true);

        $result = DB_query('SELECT COUNT(*) AS count ' . $from_where);
        list($numlinks) = DB_fetchArray($result);
        $pages = 0;
        if ($_LI_CONF['linksperpage'] > 0) {
            $pages = (int) ($numlinks / $_LI_CONF['linksperpage']);
            if (($numlinks % $_LI_CONF['linksperpage']) > 0) {
                $pages++;
            }
        }
        if ($pages > 0) {
            if (($_LI_CONF['linkcols'] > 0) && !empty($currentcid)) {
                $catlink = '?category=' . rawurlencode($currentcid);
            } else {
                $catlink = '';
            }
            $linkList->set_var('page_navigation',
                COM_printPageNavigation($_CONF['site_url']
                    . '/links/index.php' . $catlink, $page, $pages));
        } else {
            $linkList->set_var('page_navigation', '');
        }
    }
    $linkList->set_var('blockfooter', COM_endBlock());
    $linkList->parse('output', 'linklist');
    $display .= $linkList->finish($linkList->get_var('output'));
    $display = COM_createHTMLDocument($display, array('pagetitle' => $page_title));

    return $display;
}


/**
 * Prepare a link item for rendering
 *
 * @param    array $A        link details
 * @param    ref   $template reference of the links template
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
	
	$description = PLG_replaceTags(stripslashes($A['description']));
	// Just like comments, link description really should have a postmode that is saved with the description (ie store either 'html' or 'plaintext') OR just remove HTML but they don't so lets figure out if description is html by searching for html tags. This is done in links notification email as well
	// Needs to be done after autotags incase they insert HTML
	if (preg_match('/<.*>/', $description) == 0) {
		$description = COM_nl2br($description);
	}	
    $template->set_var('link_description', $description);

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
        SEC_hasRights('links.edit')
    ) {
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
if (isset($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

$message = array();
if (($mode === 'report') && !COM_isAnonUser()) {
    if (isset($_GET['lid'])) {
        $lid = Geeklog\Input::fGet('lid');
    }
    if (!empty($lid)) {
        $lidsl = DB_escapeString($lid);
        $result = DB_query("SELECT url, title FROM {$_TABLES['links']} WHERE lid = '$lidsl'");
        list($url, $title) = DB_fetchArray($result);
		
		
		// Create HTML and plaintext version of report email
		$t = COM_newTemplate(CTL_plugin_templatePath('links', 'emails'));
		
		$t->set_file(array('email_html' => 'link_report-html.thtml'));
		// Remove line feeds from plain text templates since required to use {LB} template variable
		$t->preprocess_fn = "CTL_removeLineFeeds"; // Set preprocess_fn before the template file you want to use it on		
		$t->set_file(array('email_plaintext' => 'link_report-plaintext.thtml'));

		$t->set_var('email_divider', $LANG31['email_divider']);
		$t->set_var('email_divider_html', $LANG31['email_divider_html']);
		$t->set_var('LB', LB);
		
		$t->set_var('lang_link_broken_msg', $LANG_LINKS[119]); // The following link has been reported to be broken:
		
		$t->set_var('reported_link_title', $title);
		$t->set_var('reported_link', $url);
		
		$t->set_var('lang_edit_link_msg', $LANG_LINKS[120]); // To edit the link, click her
		$editurl = $_CONF['site_admin_url'] . '/plugins/links/index.php?mode=edit&lid=' . $lid;
		$t->set_var('edit_link', $editurl);

		$t->set_var('lang_reported_by', $LANG_LINKS[121]); // The broken Link was reported by: 
		$t->set_var('reporter_author', COM_getDisplayName($_USER['uid']));

		// Output final content
		$message[] = $t->parse('output', 'email_html');	
		$message[] = $t->parse('output', 'email_plaintext');
		
		COM_mail($_CONF['site_mail'], $LANG_LINKS[118], $message, '' , true);		
		
		$message = array($LANG_LINKS[123], $LANG_LINKS[122]);
    }
}

if (COM_isAnonUser() &&
    (($_CONF['loginrequired'] == 1) || ($_LI_CONF['linksloginrequired'] == 1))
) {
    $display .= SEC_loginRequiredForm();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_LINKS[114]));
} else {
    $display .= links_list($message);
}

COM_output($display);
