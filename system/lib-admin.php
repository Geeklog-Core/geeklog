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
// $Id: lib-admin.php,v 1.12 2005/11/03 10:25:50 ospiess Exp $

function ADMIN_list($component, $fieldfunction, $header_arr, $text_arr, $query_arr,
                    $menu_arr, $defsort_arr)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $_IMAGE_TYPE, $MESSAGE;
    
    $order_var = $_GET['order'];
    if (!empty($order_var)) {
        $order_var = COM_applyFilter ($order_var, true);
        $order = $header_arr[$order_var]['field'];
    }
    $prevorder = COM_applyFilter ($_GET['prevorder']);
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
    $admin_templates->set_file (array ('topmenu' => 'topmenu.thtml',
                                       'list' => 'list.thtml',
                                       'header' => 'header.thtml',
                                       'row' => 'listitem.thtml',
                                       'field' => 'field.thtml',
                                       'menufields' => 'menufields.thtml'
                                      ));
    $admin_templates->set_var('site_url', $_CONF['site_url']);
    $admin_templates->set_var('form_url', $text_arr['form_url']);
    $admin_templates->set_var('icon', $text_arr['icon']);
    
    $query = $query_arr['query'];
    $query = str_replace ('*', '%', $query);
    
    if ($text_arr['has_menu']) {
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
        $admin_templates->set_var('lang_instructions', $text_arr['instructions']);
        $admin_templates->set_var('last_query', $query);
        $admin_templates->set_var('filter', $filter);
        $admin_templates->parse('top_menu', 'topmenu', true);
    }

    $admin_templates->set_var('lang_edit', $LANG_ADMIN['edit']);
    
    $icon_arr = array(
        'edit' => '<img src="' . $_CONF['layout_url'] . '/images/edit.'
             . $_IMAGE_TYPE . '" border="0" alt="' . $LANG_ADMIN['edit'] . '" title="'
             . $LANG_ADMIN['edit'] . '">',
        'copy' => '<img src="' . $_CONF['layout_url'] . '/images/copy.'
             . $_IMAGE_TYPE . '" border="0" alt="' . $LANG_ADMIN['copy'] . '" title="'
             . $LANG_ADMIN['copy'] . '">',
        'list' => '<img src="' . $_CONF['layout_url'] . '/images/list.'
            . $_IMAGE_TYPE . '" border="0" alt="' . $LANG_ACCESS['listthem']
            . '" title="' . $LANG_ACCESS['listthem'] . '">'
    );

    $retval .= COM_startBlock ($text_arr['title'], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $sql_query = addslashes ($query);
    $sql = $query_arr['sql'];
    
    if (empty($direction)) {
        if (empty($order)) {
            $order = $defsort_arr['field'];
            $direction = $defsort_arr['direction'];
        } else {
            $direction = 'asc';
        }
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
            if ($order==$header_arr[$i]['field']) {
                $admin_templates->set_var('img_arrow', $img_arrow);
            }
            $admin_templates->set_var('mouse_over', "OnMouseOver=\"this.style.cursor='pointer';\"");
            $order_var = $i;
            $onclick="onclick=\"window.location.href='$form_url?"
                    ."order=$order_var&prevorder=$order&direction=$direction"
                    ."&page=$page&q=$query&query_limit=$query_limit';\"";
            $admin_templates->set_var('on_click', $onclick);
        }
        $admin_templates->parse('header_row', 'header', true);
        $admin_templates->clear_var('img_arrow');
        $admin_templates->clear_var('mouse_over');
        $admin_templates->clear_var('on_click');
        $admin_templates->clear_var('arrow');
    }

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


    if (!empty($query_arr['default_filter'])){
        $filter_str = " AND {$query_arr['default_filter']}";
    }
    if (!empty ($query)) {
        $filter_str .= " AND (";
        for ($f = 0; $f < count($query_arr['query_fields']); $f++) {
            $filter_str .= $query_arr['query_fields'][$f] . " LIKE '$sql_query'";
            if ($f < (count($query_arr['query_fields']) - 1)) {
                $filter_str .= " OR ";
            }
        }
        $filter_str .= ")";
        $num_pages = ceil (DB_getItem ($_TABLES[$query_arr['table']], 'count(*)',
                           "1 " . $filter_str) / $limit);
        if ($num_pages < $curpage) {
            $curpage = 1;
        }
    } else {
        $num_pages = ceil (DB_getItem ($_TABLES[$query_arr['table']], 'count(*)',
                                       $query_arr['unfiltered']) / $limit);
    }

    $offset = (($curpage - 1) * $limit);

    # SQL
    $sql .= "$filter_str ORDER BY $order $direction LIMIT $offset,$limit;";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        for ($j = 0; $j < count($header_arr); $j++) {
            $fieldname = $header_arr[$j]['field'];
            $fieldvalue = $fieldfunction($fieldname, $A[$fieldname], $A, $icon_arr);
            if ($fieldvalue !== false) {
                $admin_templates->set_var('itemtext', $fieldvalue);
                $admin_templates->parse('item_field', 'field', true);
            }
        }
        $admin_templates->set_var('cssid', ($i%2)+1);
        $admin_templates->parse('item_row', 'row', true);
        $admin_templates->clear_var('item_field');
    }
    
    if ($nrows==0) {
        $admin_templates->set_var('message', $LANG_ADMIN['no_results']);
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

function ADMIN_getListField_blocks($fieldname, $fieldvalue, $A, $icon_arr) {
    global $_CONF, $LANG_ADMIN, $LANG21, $_IMAGE_TYPE;

    $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);

    if (($access > 0) && (hasBlockTopicAccess ($A['tid']) > 0)) {
        switch($fieldname) {
            case "edit":
                if ($access == 3) {
                    $retval = "<a href=\"{$_CONF[site_admin_url]}/block.php?mode=edit&amp;bid={$A['bid']}\">{$icon_arr['edit']}</a>";
                }
                break;
            case 'title':
                $retval = stripslashes ($A['title']);
                if (empty ($retval)) {
                    $retval = '(' . $A['name'] . ')';
                }
                break;
            case 'blockorder':
                $retval .= $A['blockorder'];
                break;
            case 'is_enabled':
                if ($A['is_enabled'] == 1) {
                    $switch = 'checked="checked"';
                } else {
                    $switch = '';
                }
                $retval = "<form action=\"{$_CONF['site_admin_url']}/block.php\" method=\"post\">"
                         ."<input type=\"checkbox\" name=\"blkenable\" onclick=\"submit()\" value=\"{$A['bid']}\" $switch><input type=\"hidden\" name=\"blkChange\" value=\"{$A['bid']}\"></form>";
                break;
            case 'move':
                if ($access == 3) {
                    if ($A['onleft'] == 1) {
                        $side = $LANG21[40];
                        $blockcontrol_image = 'block-right.' . $_IMAGE_TYPE;
                        $moveTitleMsg = $LANG21[59];
                        $switchside = '1';
                    } else {
                        $blockcontrol_image = 'block-left.' . $_IMAGE_TYPE;
                        $moveTitleMsg = $LANG21[60];
                        $switchside = '0';
                    }
                    $retval.="<img src=\"{$_CONF['layout_url']}/images/admin/$blockcontrol_image\" width=\"45\" height=\"20\" border=\"0\" usemap=\"#arrow{$A['bid']}\" alt=\"\">"
                            ."<map name=\"arrow{$A['bid']}\">"
                            ."<area coords=\"0,0,12,20\"  title=\"{$LANG21[58]}\" href=\"{$_CONF['site_admin_url']}/block.php?mode=move&amp;bid={$A['bid']}&amp;where=up\" alt=\"{$LANG21[58]}\">"
                            ."<area coords=\"13,0,29,20\" title=\"$moveTitleMsg\" href=\"{$_CONF['site_admin_url']}/block.php?mode=move&amp;bid={$A['bid']}&amp;where=$switchside\" alt=\"$moveTitleMsg\">"
                            ."<area coords=\"30,0,43,20\" title=\"{$LANG21[57]}\" href=\"{$_CONF['site_admin_url']}/block.php?mode=move&amp;bid={$A['bid']}&amp;where=dn\" alt=\"{$LANG21[57]}\">"
                            ."</map>";
                }
                break;
            default:
                $retval = $fieldvalue;
                break;
        }
    }
    return $retval;
}

function ADMIN_getListField_events($fieldname, $fieldvalue, $A, $icon_arr) {
    global $_CONF, $LANG_ACCESS, $LANG_ADMIN;

    $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);

    switch($fieldname) {
        case "edit":
            if ($access == 3) {
                $retval = "<a href=\"{$_CONF[site_admin_url]}/event.php?mode=edit&amp;eid={$A['eid']}\">{$icon_arr['edit']}</a>";
            }
            break;
        case "copy":
            if ($access == 3) {
                $retval = "<a href=\"{$_CONF[site_admin_url]}/event.php?mode=clone&amp;eid={$A['eid']}\">{$icon_arr['copy']}</a>";
            }
            break;
        case 'access':
            if ($access == 3) {
                $retval = $LANG_ACCESS['edit'];
            } else {
                $retval = $LANG_ACCESS['readonly'];
            }
            break;
        case 'title':
            $retval = stripslashes ($A['title']);
            break;
        default:
            $retval = $fieldvalue;
            break;
    }
    return $retval;
}

function ADMIN_getListField_groups($fieldname, $fieldvalue, $A, $icon_arr) {
    global $_CONF, $LANG_ACCESS, $LANG_ADMIN;
    if (in_array ($A['grp_id'], SEC_getUserGroups() )) {
        switch($fieldname) {
            case "edit":
                $retval = "<a href=\"{$_CONF[site_admin_url]}/group.php?mode=edit&amp;grp_id={$A['grp_id']}\">{$icon_arr['edit']}</a>";
                break;
            case 'grp_gl_core':
                if ($A['grp_gl_core'] == 1) {
                    $retval = $LANG_ACCESS['yes'];
                } else {
                    $retval = $LANG_ACCESS['no'];
                }
                break;
            case 'list':
                $retval = "<a href=\"{$_CONF[site_admin_url]}/group.php?mode=listusers&amp;grp_id={$A['grp_id']}\">"
                         ."{$icon_arr['list']}</a>&nbsp;&nbsp;"
                         ."<a href=\"{$_CONF[site_admin_url]}/group.php?mode=editusers&amp;grp_id={$A['grp_id']}\">"
                         ."{$icon_arr['edit']}</a>";
                break;
            default:
                $retval = $fieldvalue;
                break;
        }
    }
    return $retval;
}
?>
