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
// $Id: lib-admin.php,v 1.1 2005/10/28 19:19:43 ospiess Exp $

// Set this to true to get various debug messages from this script

function ADMIN_list($component, $fieldfunction, $header, $default_order, $texts, $query_sql,
                    $menu, $filter, $form_url, $icon, $offset, $curpage, $query = '',
                    $query_limit = 50)
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

    $admin_templates = new Template($_CONF['path_layout'] . 'admin/lists');
    $admin_templates->set_file (array ('list' => 'list.thtml',
                                       'header' => 'header.thtml',
                                      'row' => 'listitem.thtml',
                                      'field' => 'field.thtml',
                                      'menufields' => 'menufields.thtml'
                                      ));
    $admin_templates->set_var('site_url', $_CONF['site_url']);
    $admin_templates->set_var('form_url', $form_url);
    $admin_templates->set_var('icon', $icon);

    for ($i = 0; $i < count($menu); $i++) {
        $admin_templates->set_var('menu_url', $menu[$i]['url'] );
        $admin_templates->set_var('menu_text', $menu[$i]['text'] );
        if ($i < (count($menu) -1)) {
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

    $admin_templates->set_var('lang_instructions', $texts['instructions']);
    $retval .= COM_startBlock ($texts['title'], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
    $admin_templates->set_var('last_query', $query);
    $admin_templates->set_var('filter', $filter);

    if (empty($order)) {
        $order = $default_order;
    }
    $orderby = $header[$order]['field'];

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

    if (empty($query_limit)) {
        $limit = 50;
    } else {
        $limit = $query_limit;
    }
    if ($query != '') {
        $admin_templates->set_var ('query', urlencode($query) );
    } else {
        $admin_templates->set_var ('query', '');
    }
    $admin_templates->set_var ('query_limit', $query_limit);
    $admin_templates->set_var($limit . '_selected', 'selected="selected"');

    if (!empty ($query)) {
        $num_pages = ceil (DB_getItem ($_TABLES[$query_sql['table']], 'count(*)',
                $query_sql['filtered']) / $limit);
        if ($num_pages < $curpage) {
            $curpage = 1;
        }
    } else {
        $num_pages = ceil (DB_getItem ($_TABLES[$query_sql['table']], 'count(*)',
                                       $query_sql['unfiltered']) / $limit);
    }
    $offset = (($curpage - 1) * $limit);

    # SQL
    $sql = $query_sql['sql'];
    if (!empty($query)) {
         $sql .= $query_sql['filtered'];
    } else {
        $sql .= $query_sql['unfiltered'];
    }
    $sql.= " ORDER BY $orderby $direction LIMIT $offset,$limit";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    # HEADER FIELDS array(text, field)
    for ($i=0; $i < count( $header ); $i++) {
        $admin_templates->set_var('header_text', $header[$i]['text']);
        if ($header[$i]['sort'] != false) {
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

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        // Edit icon
        $fieldvalue = $fieldfunction('edit', $editico, $A);
        $admin_templates->set_var('itemtext', $fieldvalue);
        $admin_templates->parse('item_field', 'field', true);
        // other fields
        for ($j = 0; $j < count($header); $j++) {
            $fieldname = $header[$j]['field'];
            $fieldvalue = $A[$fieldname];
            $fieldvalue = $fieldfunction($fieldname, $fieldvalue, $A);
            $admin_templates->set_var('itemtext', $fieldvalue);
            $admin_templates->parse('item_field', 'field', true);
        }
        $admin_templates->set_var('cssid', ($i%2)+1);
        $admin_templates->parse('item_row', 'row', true);
        $admin_templates->clear_var('item_field');
    }
    if (!empty($query)) {
        $base_url = $form_url . '?q=' . urlencode($query) . "&amp;query_limit={$query_limit}&amp;order={$order}&amp;direction={$prevdirection}";
    } else {
        $base_url = $form_url . "?query_limit={$query_limit}&amp;order={$order}&amp;direction={$prevdirection}";
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
