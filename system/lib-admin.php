<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-admin.php                                                             |
// |                                                                           |
// | Admin-related functions needed in more than one place.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: lib-admin.php,v 1.3 2005/10/31 14:44:56 ospiess Exp $

function ADMIN_list($component, $fieldfunction, $header_arr, $text_arr, $query_arr,
                    $menu_arr, $filter)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $_IMAGE_TYPE;
    // Make sure user has access to this page
    if (!SEC_hasRights($component.'.edit')) {
        $retval .= COM_siteHeader ('menu');
        $retval .= COM_startBlock ($MESSAGE[30], '',
                   COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= $MESSAGE[37];
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval .= COM_siteFooter ();
        COM_accessLog("User {$_USER['username']} tried to illegally access the $component administration screen.");
        echo $retval;
        exit;
    }

    $order = COM_applyFilter ($_GET['order'], true);
    $prevorder = COM_applyFilter ($_GET['prevorder'], true);
    $direction = COM_applyFilter ($_GET['direction']);

    $retval = '';

    $offset = 0;
    if (isset ($_REQUEST['offset'])) {
        $offset = COM_applyFilter ($_REQUEST['offset'], true);
    }
    $curpage = 1;
    if (isset ($_REQUEST['page'])) {
        $page = COM_applyFilter ($_REQUEST['page'], true);
    }

    if ($curpage <= 0) {
        $curpage = 1;
    }

    $admin_templates = new Template($_CONF['path_layout'] . 'admin/lists');
    $admin_templates->set_file (array ('list' => 'list.thtml',
                                       'header' => 'header.thtml',
                                      'row' => 'listitem.thtml',
                                      'field' => 'field.thtml',
                                      'menufields' => 'menufields.thtml'
                                      ));
    $admin_templates->set_var('site_url', $_CONF['site_url']);
    $admin_templates->set_var('form_url', $text_arr['form_url']);
    $admin_templates->set_var('icon', $text_arr['icon']);

    for ($i = 0; $i < count($menu_arr); $i++) {
        $admin_templates->set_var('menu_url', $menu_arr[$i]['url'] );
        $admin_templates->set_var('menu_text', $menu_arr[$i]['text'] );
        if ($i < (count($menu_arr) -1)) {
            $admin_templates->set_var('line', '|' );
        }
        $admin_templates->parse('menu_fields', 'menufields', true);
        $admin_templates->clear_var('line');
    }
    
    $admin_templates->set_var('lang_search', $LANG_ADMIN['search']);
    $admin_templates->set_var('lang_submit', $LANG_ADMIN['submit']);
    $admin_templates->set_var('lang_limit_results', $LANG_ADMIN['limit_results']);
    $admin_templates->set_var('lang_edit', $LANG_ADMIN['edit']);
    $editico = '<img src="' . $_CONF['layout_url'] . '/images/edit.'
         . $_IMAGE_TYPE . '" border="0" alt="' . $LANG_ADMIN['edit'] . '" title="'
         . $LANG_ADMIN['edit'] . '">';

    $admin_templates->set_var('lang_instructions', $text_arr['instructions']);
    $retval .= COM_startBlock ($text_arr['title'], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
    $admin_templates->set_var('last_query', $query);
    $admin_templates->set_var('filter', $filter);
    
    $query = $query_arr['query'];
    $query = str_replace ('*', '%', $query);
    $sql_query = addslashes ($query);
    $sql = $query_arr['sql'];
    
    if (empty ($direction)) {
        $direction = 'asc';
    } else if ($order == $prevorder) {
        $direction = ($direction == 'desc') ? 'asc' : 'desc';
    } else {
        $direction = ($direction == 'desc') ? 'desc' : 'asc';
    }

    if ($direction == 'asc') {
        $arrow = 'bararrowdown';
    } else {
        $arrow = 'bararrowup';
    }
    $img_arrow = '&nbsp;<img src="' . $_CONF['layout_url'] . '/images/' . $arrow
            . '.' . $_IMAGE_TYPE . '" border="0" alt="">';
    
    # HEADER FIELDS array(text, field, sort)
    for ($i=0; $i < count( $header_arr ); $i++) {
        $admin_templates->set_var('header_text', $header_arr[$i]['text']);
        if ($header_arr[$i]['sort'] != false) {
            if (($header_arr[$i]['sort'] === 'default') && empty($order)) {
                $order = $i;
            }
            if ($order==$i) {
                $admin_templates->set_var('img_arrow', $img_arrow);
            }
            $admin_templates->set_var('mouse_over', "OnMouseOver=\"this.style.cursor='pointer';\"");
            $onclick="onclick=\"window.location.href='" .$form_url . "?"
                    ."order=$i&prevorder=$order&direction=$direction"
                    ."&page=$page&q=$query&query_limit=$query_limit';\"";
            $admin_templates->set_var('on_click', $onclick);
            $admin_templates->set_var('arrow', $arrow);
        }
        $admin_templates->parse('header_row', 'header', true);
        $admin_templates->clear_var('img_arrow');
        $admin_templates->clear_var('mouse_over');
        $admin_templates->clear_var('on_click');
        $admin_templates->clear_var('arrow');
    }

    $orderby = $header_arr[$order]['field'];

    if (empty($query_arr['query_limit'])) {
        $limit = 50;
    } else {
        $limit = $query_arr['query_limit'];
    }
    if ($query != '') {
        $admin_templates->set_var ('query', urlencode($query) );
    } else {
        $admin_templates->set_var ('query', '');
    }
    $admin_templates->set_var ('query_limit', $query_arr['query_limit']);
    $admin_templates->set_var($limit . '_selected', 'selected="selected"');

    if (!empty ($query)) {
        if (!empty($query_arr['unfiltered'])) {
            $filter_str = $query_arr['unfiltered'] . " AND (";
        } else {
            $filter_str = "(";
        }
        for ($f = 0; $f < count($query_arr['filter']); $f++) {
            $filter_str .= $query_arr['filter'][$f] . " LIKE '$sql_query'";
            if ($f < (count($query_arr['filter']) - 1)) {
                $filter_str .= " OR ";
            }
        }
        $filter_str .= ")";

        $num_pages = ceil (DB_getItem ($_TABLES[$query_arr['table']], 'count(*)',
                           $filter_str) / $limit);
        if ($num_pages < $curpage) {
            $curpage = 1;
        }
    } else {
        $num_pages = ceil (DB_getItem ($_TABLES[$query_arr['table']], 'count(*)',
                                       $query_arr['unfiltered']) / $limit);
    }
    $offset = (($curpage - 1) * $limit);

    # SQL
    if (!empty($query)) {
         $sql .=  $filter_str;
    } else {
        $sql .= $query_arr['unfiltered'];
    }
    $sql.= " ORDER BY $orderby $direction LIMIT $offset,$limit";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        // Edit icon
        $fieldvalue = $fieldfunction('edit', $editico, $A);
        $admin_templates->set_var('itemtext', $fieldvalue);
        $admin_templates->parse('item_field', 'field', true);
        // other fields
        for ($j = 0; $j < count($header_arr); $j++) {
            $fieldname = $header_arr[$j]['field'];
            $fieldvalue = $A[$fieldname];
            $fieldvalue = $fieldfunction($fieldname, $fieldvalue, $A);
            if ($fieldvalue !== false) {
                $admin_templates->set_var('itemtext', $fieldvalue);
                $admin_templates->parse('item_field', 'field', true);
            }
        }
        $admin_templates->set_var('cssid', ($i%2)+1);
        $admin_templates->parse('item_row', 'row', true);
        $admin_templates->clear_var('item_field');
    }
    if (!empty($query)) {
        $base_url = $form_url . '?q=' . urlencode($query) . "&amp;query_limit={$query_arr['query_limit']}&amp;order={$order}&amp;direction={$prevdirection}";
    } else {
        $base_url = $form_url . "?query_limit={$query_arr['query_limit']}&amp;order={$order}&amp;direction={$prevdirection}";
    }

    if ($num_pages > 1) {
        $admin_templates->set_var('google_paging',COM_printPageNavigation($base_url,$curpage,$num_pages));
    } else {
        $admin_templates->set_var('google_paging', '');
    }
    $admin_templates->parse('output', 'list');
    $retval .= $admin_templates->finish($admin_templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}
?>
