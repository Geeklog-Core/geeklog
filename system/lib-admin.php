<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | lib-admin.php                                                             |
// |                                                                           |
// | Admin-related functions needed in more than one place.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                   |
// |          Mark Limburg       - mlimburg AT users DOT sourceforge DOT net   |
// |          Jason Whittenburg  - jwhitten AT securitygeeks DOT com           |
// |          Dirk Haun          - dirk AT haun-online DOT de                  |
// |          Oliver Spiesshofer - oliver AT spiesshofer DOT com               |
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
// $Id: lib-admin.php,v 1.97 2007/01/14 03:30:02 ospiess Exp $

if (strpos ($_SERVER['PHP_SELF'], 'lib-admin.php') !== false) {
    die ('This file can not be used on its own!');
}

/**
* Common function used in Admin scripts to display a list of items
*
* @param    string  $fieldfunction  Name of a function used to display the list item row details
* @param    array   $header_arr     array of header fields with sortables and table fields
* @param    array   $text_arr       array with different text strings
* @param    array   $data_arr       array with sql query data - array of list records
* @param    array   $menu_arr       menu-entries
* @param    array   $options        array of options - intially just used for the Check-All feature
* @return   string                  HTML output of function
*
*/
function ADMIN_simpleList($fieldfunction, $header_arr, $text_arr,
                           $data_arr, $menu_arr = '', $options = '')
{
    global $_CONF, $_TABLES, $LANG01, $LANG_ADMIN, $LANG_ACCESS, $_IMAGE_TYPE, $MESSAGE;

    $retval = '';

    $help_url = "";
    if (!empty($text_arr['help_url'])) {
        $help_url = $text_arr['help_url'];
    }

    $title = "";
    if (!empty($text_arr['title'])) {
        $title = $text_arr['title'];
    }

    $form_url = '';
    if (!empty($text_arr['form_url'])) {
        $form_url = $text_arr['form_url'];
    }

    $icon = '';
    if (isset($text_arr['icon'])) {
        $icon = $text_arr['icon'];
    }
    $admin_templates = new Template($_CONF['path_layout'] . 'admin/lists');
    $admin_templates->set_file (array ('topmenu' => 'topmenu_nosearch.thtml',
                                       'list' => 'list.thtml',
                                       'header' => 'header.thtml',
                                       'row' => 'listitem.thtml',
                                       'field' => 'field.thtml',
                                       'menufields' => 'menufields.thtml'
                                      ));
    $admin_templates->set_var('site_url', $_CONF['site_url']);
    $admin_templates->set_var('layout_url', $_CONF['layout_url']);
    $admin_templates->set_var('form_url', $form_url);
    if (isset ($text_arr['icon']) && ($text_arr['icon'] !== false)) {
        $admin_templates->set_var('icon', "<img src=\"{$text_arr['icon']}\" alt=\"\">");
    }

    $admin_templates->set_var('lang_edit', $LANG_ADMIN['edit']);
    $admin_templates->set_var('lang_deleteall', $LANG01[124]);
    $admin_templates->set_var('lang_delconfirm', $LANG01[125]);

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
        $admin_templates->set_var('lang_instructions', $text_arr['instructions']);
        $admin_templates->parse('top_menu', 'topmenu', true);
    }

    $icon_arr = array(
        'edit' => '<img src="' . $_CONF['layout_url'] . '/images/edit.'
             . $_IMAGE_TYPE . '" alt="' . $LANG_ADMIN['edit'] . '" title="'
             . $LANG_ADMIN['edit'] . '">',
        'copy' => '<img src="' . $_CONF['layout_url'] . '/images/copy.'
             . $_IMAGE_TYPE . '" alt="' . $LANG_ADMIN['copy'] . '" title="'
             . $LANG_ADMIN['copy'] . '">',
        'list' => '<img src="' . $_CONF['layout_url'] . '/images/list.'
            . $_IMAGE_TYPE . '" alt="' . $LANG_ACCESS['listthem']
            . '" title="' . $LANG_ACCESS['listthem'] . '">'
    );

    $retval .= COM_startBlock ($title, $help_url,
                               COM_getBlockTemplate ('_admin_block', 'header'));

    // Check if the delete checkbox and support for the delete all feature should be displayed
    if (count($data_arr) > 1 AND is_array($options) AND $options['chkdelete']) {
        $admin_templates->set_var('header_text', '<input type="checkbox" name="chk_selectall" title="'.$LANG01[126].'" onclick="caItems(this.form);">');
        $admin_templates->set_var('class', "admin-list-headerfield");
        $admin_templates->set_var('show_deleteimage', '');
        $admin_templates->parse('header_row', 'header', true);
        $admin_templates->clear_var('on_click');
    } else {
        $admin_templates->set_var('show_deleteimage','display:none;');
    }

    # HEADER FIELDS array(text, field, sort)
    for ($i=0; $i < count( $header_arr ); $i++) {
        $admin_templates->set_var('header_text', $header_arr[$i]['text']);
        if (!empty($header_arr[$i]['header_class'])) {
            $admin_templates->set_var('class', $header_arr[$i]['header_class']);
        } else {
            $admin_templates->set_var('class', "admin-list-headerfield");
        }
        $admin_templates->parse('header_row', 'header', true);
    }

    if (count($data_arr) == 0) {
        if (isset($text_arr['no_data'])) {
            $message = $text_arr['no_data'];
        } else {
            $message = $LANG_ADMIN['no_results'];
        }
        $admin_templates->set_var('message', $message);
    } else if ($data_arr === false) {
        $admin_templates->set_var('message', $LANG_ADMIN['data_error']);
    } else {
        $admin_templates->set_var('show_message', 'display:none;');
        for ($i = 0; $i < count($data_arr); $i++) {
            if (count($data_arr) > 1 AND is_array($options) AND $options['chkdelete']) {
                $admin_templates->set_var('itemtext', '<input type="checkbox" name="delitem[]" value="' . $data_arr[$i][$options['chkfield']].'">');
                $admin_templates->parse('item_field', 'field', true);
            }
            for ($j = 0; $j < count($header_arr); $j++) {
                $fieldname = $header_arr[$j]['field'];
                $fieldvalue = '';
                if (!empty($data_arr[$i][$fieldname])) {
                    $fieldvalue = $data_arr[$i][$fieldname];
                }
                if (!empty($fieldfunction)) {
                    $fieldvalue = $fieldfunction($fieldname, $fieldvalue, $data_arr[$i], $icon_arr);
                } else {
                    $fieldvalue = $fieldvalue;
                }
                if (!empty($header_arr[$j]['field_class'])) {
                    $admin_templates->set_var('class', $header_arr[$j]['field_class']);
                } else {
                      $admin_templates->set_var('class', "admin-list-field");
                }
                if ($fieldvalue !== false) {
                    $admin_templates->set_var('itemtext', $fieldvalue);
                    $admin_templates->parse('item_field', 'field', true);
                }
            }
            $admin_templates->set_var('cssid', ($i%2)+1);
            $admin_templates->parse('item_row', 'row', true);
            $admin_templates->clear_var('item_field');
        }
    }

    $admin_templates->parse('output', 'list');
    $retval .= $admin_templates->finish($admin_templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
    return $retval;

}

/**
* Creates a list of data with a menu, search, filter, clickable headers etc.
*
* @param    string  $component      name of the list
* @param    string  $fieldfunction  name of the function that handles special entries
* @param    array   $header_arr     array of header fields with sortables and table fields
* @param    array   $text_arr       array with different text strings
* @param    array   $query_arr      array with sql-options
* @param    array   $menu_arr       menu-entries
* @param    array   $defsort_arr    default sorting values
* @param    string  $filter         additional drop-down filters
* @param    string  $extra          additional values passed to fieldfunction
* @return   string                  HTML output of function
*
*/
function ADMIN_list($component, $fieldfunction, $header_arr, $text_arr,
            $query_arr, $menu_arr, $defsort_arr, $filter = '', $extra = '', $options = '')
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG_ACCESS, $LANG01, $_IMAGE_TYPE, $MESSAGE;

    // set all variables to avoid warnings
    $retval = '';
    $filter_str = '';
    $order_sql = '';
    $limit = '';
    $prevorder = '';
    if (isset ($_GET['prevorder'])) { # what was the last sorting?
        $prevorder = COM_applyFilter ($_GET['prevorder']);
    }

    $query = '';
    if (isset ($_REQUEST['q'])) { # get query (text-search)
        $query = $_REQUEST['q'];
    }

    $query_limit = "";
    if (isset($_REQUEST['query_limit'])) { # get query-limit (list-length)
        $query_limit = COM_applyFilter ($_REQUEST['query_limit'], true);
        if($query_limit == 0) {
            $query_limit = 50;
        }
    }

    // we assume that the current page is 1 to set it.
    $curpage = 1;
    $page = '';
    // get the current page from the interface. The variable is linked to the
    // component, i.e. the plugin/function calling this here to avoid overlap
    if (isset ($_REQUEST[$component . 'listpage'])) {
        $page = COM_applyFilter ($_REQUEST[$component . 'listpage'], true);
        $curpage = $page;
    }
    if ($curpage <= 0) {
        $curpage = 1; #current page has to be larger 0
    }

    #$unfiltered='';
    #if (!empty($query_arr['unfiltered'])) {
    #    $unfiltered = $query_arr['unfiltered'];
    #}

    $help_url = ''; # do we have a help url for the block-header?
    if (!empty ($text_arr['help_url'])) {
        $help_url = $text_arr['help_url'];
    }

    $form_url = ''; # what is the form-url for the search button and list sorters?
    if (!empty ($text_arr['form_url'])) {
        $form_url = $text_arr['form_url'];
    }

    $title = ''; # what is the title of the page?
    if (!empty ($text_arr['title'])) {
        $title = $text_arr['title'];
    }

    # get all template fields. Maybe menufields can be only loaded if used?
    $admin_templates = new Template($_CONF['path_layout'] . 'admin/lists');
    $admin_templates->set_file (array (
        'topmenu' => 'topmenu.thtml',
        'list' => 'list.thtml',
        'header' => 'header.thtml',
        'row' => 'listitem.thtml',
        'field' => 'field.thtml',
        'menufields' => 'menufields.thtml'
    ));

    # insert std. values into the template
    $admin_templates->set_var('site_url', $_CONF['site_url']);
    $admin_templates->set_var('layout_url', $_CONF['layout_url']);
    $admin_templates->set_var('form_url', $form_url);
    if ($text_arr['icon'] !== false or $text_arr['icon']='') {
        $admin_templates->set_var('icon', "<img src=\"{$text_arr['icon']}\" alt=\"\">");
    }
    $admin_templates->set_var('lang_edit', $LANG_ADMIN['edit']);
    $admin_templates->set_var('lang_deleteall', $LANG01[124]);
    $admin_templates->set_var('lang_delconfirm', $LANG01[125]);

    // Check if the delete checkbox and support for the delete all feature should be displayed
    if (is_array($options) AND $options['chkdelete']) {
        $admin_templates->set_var('header_text', '<input type="checkbox" name="chk_selectall" title="'.$LANG01[126].'" onclick="caItems(this.form);">');
        $admin_templates->set_var('class', "admin-list-headerfield");
        $admin_templates->set_var('show_deleteimage', '');
        $admin_templates->parse('header_row', 'header', true);
        $admin_templates->clear_var('on_click');
    } else {
        $admin_templates->set_var('show_deleteimage','display:none;');
    }

    # define icon paths. Those will be transmitted to $fieldfunction.
    $icon_arr = array(
        'edit' => '<img src="' . $_CONF['layout_url'] . '/images/edit.'
             . $_IMAGE_TYPE . '" alt="' . $LANG_ADMIN['edit']
             . '" title="' . $LANG_ADMIN['edit'] . '">',
        'copy' => '<img src="' . $_CONF['layout_url'] . '/images/copy.'
             . $_IMAGE_TYPE . '" alt="' . $LANG_ADMIN['copy']
             . '" title="' . $LANG_ADMIN['copy'] . '">',
        'list' => '<img src="' . $_CONF['layout_url'] . '/images/list.'
            . $_IMAGE_TYPE . '" alt="' . $LANG_ACCESS['listthem']
            . '" title="' . $LANG_ACCESS['listthem'] . '">'
    );
    // the user can disable the menu. if used, create it.
    if ($text_arr['has_menu']) {
        for ($i = 0; $i < count($menu_arr); $i++) { # iterate through menu
            $admin_templates->set_var('menu_url', $menu_arr[$i]['url'] );
            $admin_templates->set_var('menu_text', $menu_arr[$i]['text'] );
            if ($i < (count($menu_arr) -1)) {
                $admin_templates->set_var('line', '|' ); # add separator
            }
            $admin_templates->parse('menu_fields', 'menufields', true);
            $admin_templates->clear_var('line'); # clear separator after use
        }
        # add text strings to template
        $admin_templates->set_var('lang_instructions', $text_arr['instructions']);
        $admin_templates->set_var('lang_search', $LANG_ADMIN['search']);
        $admin_templates->set_var('lang_submit', $LANG_ADMIN['submit']);
        $admin_templates->set_var('lang_limit_results', $LANG_ADMIN['limit_results']);
        $admin_templates->set_var('last_query', COM_applyFilter($query));
        $admin_templates->set_var('filter', $filter);
        $admin_templates->parse('top_menu', 'topmenu', true);
    }

    $sql_query = addslashes ($query); # replace quotes etc for security
    $sql = $query_arr['sql']; # get sql from array that builds data

    $order_var = ''; # number that is displayed in URL
    $order = '';     # field that is used in SQL
    $order_var_link = ''; # Variable for google paging.

    // is the order set in the link (when sorting the list)
    if (!isset ($_GET['order'])) {
        $order = $defsort_arr['field']; // no, get the default
    } else {
        $order_var = COM_applyFilter ($_GET['order'], true);
        $order_var_link = "&amp;order=$order_var"; # keep the variable for the google paging
        $order = $header_arr[$order_var]['field'];  # current order field name
    }
    $order_for_query = $order;
    // this code sorts only by the field if its in table.field style.
    // removing this however makes match for arrow-display impossible, so removed it.
    // maybe now for more fields the table has to be added to the sortfield?
    //$order = explode ('.', $order);
    //if (count ($order) > 1) {
    //    $order = $order[1];
    //} else {
    //    $order = $order[0];
    //}

    $direction = '';
    if (!isset ($_GET['direction'])) { # get direction to sort after
        $direction = $defsort_arr['direction'];
    } else {
        $direction = COM_applyFilter ($_GET['direction']);
    }
    $direction = strtoupper ($direction);
    if ($order == $prevorder) { #reverse direction if prev. order was the same
        $direction = ($direction == 'DESC') ? 'ASC' : 'DESC';
    } else {
        $direction = ($direction == 'DESC') ? 'DESC' : 'ASC';
    }

    if ($direction == 'ASC') { # assign proper arrow img name dep. on sort order
        $arrow = 'bararrowdown';
    } else {
        $arrow = 'bararrowup';
    }
    # make actual order arrow image
    $img_arrow = '&nbsp;<img src="' . $_CONF['layout_url'] . '/images/' . $arrow
            . '.' . $_IMAGE_TYPE . '" alt="">';

    if (!empty ($order_for_query)) { # concat order string
        $order_sql = "ORDER BY $order_for_query $direction";
    }
    $th_subtags = ''; // other tags in the th, such as onlick and mouseover
    $header_text = ''; // title as displayed to the user
    // HEADER FIELDS array(text, field, sort, class)
    // this part defines the contents & format of the header fields

    for ($i=0; $i < count( $header_arr ); $i++) { #iterate through all headers
        $header_text = $header_arr[$i]['text'];
        if ($header_arr[$i]['sort'] != false) { # is this sortable?
            if ($order==$header_arr[$i]['field']) { # is this currently sorted?
                $header_text .= $img_arrow;
            }
            # make the mouseover effect is sortable
            $th_subtags = " OnMouseOver=\"this.style.cursor='pointer';\"";
            $order_var = $i; # assign number to field so we know what to sort
            if (strpos ($form_url, '?') > 0) {
                $separator = '&amp;';
            } else {
                $separator = '?';
            }
            $th_subtags .= " onclick=\"window.location.href='$form_url$separator" #onclick action
                    ."order=$order_var&amp;prevorder=$order&amp;direction=$direction";
            if (!empty ($page)) {
                $th_subtags .= '&amp;' . $component . 'listpage=' . $page;
            }
            if (!empty ($query)) {
                $th_subtags .= '&amp;q=' . $query;
            }
            if (!empty ($query_limit)) {
                $th_subtags .= '&amp;query_limit=' . $query_limit;
            }
            $th_subtags .= "';\"";
        }

        if (!empty($header_arr[$i]['header_class'])) {
            $admin_templates->set_var('class', $header_arr[$i]['header_class']);
        } else {
            $admin_templates->set_var('class', "admin-list-headerfield");
        }
        $admin_templates->set_var('header_text', $header_text);
        $admin_templates->set_var('th_subtags', $th_subtags);
        $admin_templates->parse('header_row', 'header', true);
        $admin_templates->clear_var('th_subtags'); // clear all for next header
        $admin_templates->clear_var('class');
        $admin_templates->clear_var('header_text');
    }

    $has_extras = '';
    if (isset($text_arr['has_extras'])) { # does this one use extras? (google paging)
        $has_extras = $text_arr['has_extras'];
    }
    if ($has_extras) {
        $limit = 50; # default query limit if not other chosen.
                     # maybe this could be a setting from the list?
        if (!empty($query_limit)) {
            $limit = $query_limit;
        }
        if ($query != '') { # set query into form after search
            $admin_templates->set_var ('query', urlencode($query) );
        } else {
            $admin_templates->set_var ('query', '');
        }
        $admin_templates->set_var ('query_limit', $query_limit);
        # choose proper dropdown field for query limit
        $admin_templates->set_var($limit . '_selected', 'selected="selected"');

        if (!empty($query_arr['default_filter'])){ # add default filter to sql
            $filter_str = " {$query_arr['default_filter']}";
        }
        if (!empty ($query)) { # add query fields with search term
            $filter_str .= " AND (";
            for ($f = 0; $f < count($query_arr['query_fields']); $f++) {
                $filter_str .= $query_arr['query_fields'][$f]
                            . " LIKE '%$sql_query%'";
                if ($f < (count($query_arr['query_fields']) - 1)) {
                    $filter_str .= " OR ";
                }
            }
            $filter_str .= ")";
        }
        $num_pages_sql = $sql . $filter_str;
        // COM_errorLog($num_pages_sql);
        $num_pages_result = DB_query($num_pages_sql);
        $num_rows = DB_numRows($num_pages_result);
        $num_pages = ceil ($num_rows / $limit);
        if ($num_pages < $curpage) { # make sure we dont go beyond possible results
               $curpage = 1;
        }
        $offset = (($curpage - 1) * $limit);
        $limit = "LIMIT $offset,$limit"; # get only current page data
        $admin_templates->set_var ('lang_records_found',
                                   $LANG_ADMIN['records_found']);
        $admin_templates->set_var ('records_found',
                                   COM_numberFormat ($num_rows));
    }

    # SQL
    $sql .= "$filter_str $order_sql $limit;";
    // echo $sql;
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    $r = 1; # r is the counter for the actual displayed rows for correct coloring
    for ($i = 0; $i < $nrows; $i++) { # now go through actual data
        $A = DB_fetchArray($result);
        $this_row = false; # as long as no fields are returned, dont print row
        if (is_array($options) AND $options['chkdelete']) {
            $admin_templates->set_var('class', "admin-list-field");
            $admin_templates->set_var('itemtext', '<input type="checkbox" name="delitem[]" value="' . $A[$options['chkfield']].'">');
            $admin_templates->parse('item_field', 'field', true);
        }
        for ($j = 0; $j < count($header_arr); $j++) {
            $fieldname = $header_arr[$j]['field']; # get field name from headers
            $fieldvalue = '';
            if (!empty($A[$fieldname])) { # is there a field in data like that?
                $fieldvalue = $A[$fieldname]; # yes, get its data
            }
            if (!empty ($fieldfunction) && !empty ($extra)) {
                $fieldvalue = $fieldfunction ($fieldname, $fieldvalue, $A, $icon_arr, $extra);
            } else if (!empty ($fieldfunction)) { # do we have a fieldfunction?
                $fieldvalue = $fieldfunction ($fieldname, $fieldvalue, $A, $icon_arr);
            } else { # if not just take the value
                $fieldvalue = $fieldvalue;
            }
            if ($fieldvalue !== false) { # return was there, so write line
                $this_row = true;
            } else {
                $fieldvalue = ''; // dont give emtpy fields
            }
            if (!empty($header_arr[$j]['field_class'])) {
                $admin_templates->set_var('class', $header_arr[$j]['field_class']);
            } else {
                $admin_templates->set_var('class', "admin-list-field");
            }
            $admin_templates->set_var('itemtext', $fieldvalue); # write field
            $admin_templates->parse('item_field', 'field', true);
        }
        if ($this_row) { # there was data in at least one field, so print line
            $r++; # switch to next color
            $admin_templates->set_var('cssid', ($r%2)+1); # make alternating table color
            $admin_templates->parse('item_row', 'row', true); # process the complete row
        }
        $admin_templates->clear_var('item_field'); # clear field
    }

    if ($nrows==0) { # there is no data. return notification message.
        if (isset($text_arr['no_data'])) {
            $message = $text_arr['no_data']; # there is a user-message
        } else {
            $message = $LANG_ADMIN['no_results']; # take std.
        }
        $admin_templates->set_var('message', $message);
    }

    if ($has_extras) { # now make google-paging
        $hasargs = strstr( $form_url, '?' );
        if( $hasargs ) {
            $sep = '&amp;';
        } else {
            $sep = '?';
        }
        if (!empty($query)) { # port query to next page
            $base_url = $form_url . $sep . 'q=' . urlencode($query) . "&amp;query_limit=$query_limit$order_var_link&amp;direction=$direction";
        } else {
            $base_url = $form_url . $sep ."query_limit=$query_limit$order_var_link&amp;direction=$direction";
        }

        if ($num_pages > 1) { # print actual google-paging
            $admin_templates->set_var('google_paging',COM_printPageNavigation($base_url,$curpage,$num_pages, $component . 'listpage='));
        } else {
            $admin_templates->set_var('google_paging', '');
        }
    }

    $admin_templates->parse('output', 'list');

    # Do the actual output
    $retval .= COM_startBlock ($title, $help_url,
                               COM_getBlockTemplate ('_admin_block', 'header'));
    if (!$has_extras) {
        $retval .= $text_arr['instructions'];
    }
    $retval .= $admin_templates->finish($admin_templates->get_var('output'))
             . COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}



function ADMIN_getListField_blocks($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_ADMIN, $LANG21, $_IMAGE_TYPE;
    $retval = false;

    $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);

    if (($access > 0) && (hasBlockTopicAccess ($A['tid']) > 0)) {
        switch($fieldname) {
            case "edit":
                if ($access == 3) {
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/block.php?mode=edit&amp;bid={$A['bid']}\">{$icon_arr['edit']}</a>";
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
                if ($access == 3) {
                    if ($A['is_enabled'] == 1) {
                        $switch = 'checked="checked"';
                    } else {
                        $switch = '';
                    }
                    $retval = "<form action=\"{$_CONF['site_admin_url']}/block.php\" method=\"post\"><fieldset>"
                             ."<input type=\"checkbox\" name=\"blkenable\" onclick=\"submit()\" value=\"{$A['bid']}\" $switch>"
                             ."<input type=\"hidden\" name=\"blkChange\" value=\"{$A['bid']}\"></fieldset></form>";
                }
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

function ADMIN_getListField_groups($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_ACCESS, $LANG_ADMIN, $thisUsersGroups;

    $retval = false;

    if( !is_array($thisUsersGroups) )
    {
        $thisUsersGroups = SEC_getUserGroups();
    }

    // Extra test required to handle that different ways this option is passed and need to be able to
    // over-ride the option using the posted form when the URL contains the variable as well
    $show_all_groups = false;
    if (isset($_POST['q'])) {   // Form has been posted - test actual option in this form
        if ($_POST['chk_showall'] == 1) {
            $show_all_groups = true;
        }
    } else if (isset ($_GET['showall']) && ($_GET['showall'] == 1)) {
        $show_all_groups = true;
    }

    if (in_array ($A['grp_id'], $thisUsersGroups ) ||
        SEC_groupIsRemoteUserAndHaveAccess( $A['grp_id'], $thisUsersGroups )) {
        switch($fieldname) {
            case 'edit':
                if ($show_all_groups) {
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/group.php?mode=edit&amp;grp_id={$A['grp_id']}&amp;chk_showall=1\">{$icon_arr['edit']}</a>";
                } else {
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/group.php?mode=edit&amp;grp_id={$A['grp_id']}\">{$icon_arr['edit']}</a>";
                }
                break;
            case 'grp_gl_core':
                if ($A['grp_gl_core'] == 1) {
                    $retval = $LANG_ACCESS['yes'];
                } else {
                    $retval = $LANG_ACCESS['no'];
                }
                break;
            case 'list':
                if ($show_all_groups) {
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/group.php?mode=listusers&amp;grp_id={$A['grp_id']}&amp;chk_showall=1\">"
                             ."{$icon_arr['list']}</a>&nbsp;&nbsp;"
                             ."<a href=\"{$_CONF['site_admin_url']}/group.php?mode=editusers&amp;grp_id={$A['grp_id']}&amp;chk_showall=1\">"
                             ."{$icon_arr['edit']}</a>";
                } else {
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/group.php?mode=listusers&amp;grp_id={$A['grp_id']}\">"
                             ."{$icon_arr['list']}</a>&nbsp;&nbsp;"
                             ."<a href=\"{$_CONF['site_admin_url']}/group.php?mode=editusers&amp;grp_id={$A['grp_id']}\">"
                             ."{$icon_arr['edit']}</a>";
                }
                break;
            default:
                $retval = $fieldvalue;
                break;
        }
    }

    return $retval;
}

function ADMIN_getListField_users($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG04, $LANG28, $_IMAGE_TYPE;

    $retval = '';

    switch ($fieldname) {
        case 'delete':
            $retval = '<input type="checkbox" name="delitem[]" checked="checked">';
            break;
        case 'edit':
            $retval = "<a href=\"{$_CONF['site_admin_url']}/user.php?mode=edit&amp;uid={$A['uid']}\">{$icon_arr['edit']}</a>";
            break;
        case 'username':
            $photoico = '';
            if (!empty ($A['photo'])) {
                $photoico = "&nbsp;<img src=\"{$_CONF['layout_url']}/images/smallcamera."
                          . $_IMAGE_TYPE . '" alt="{$LANG04[77]}">';
            } else {
                $photoico = '';
            }
            $retval = '<a href="' . $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' .  $A['uid'] . '">'
                    . $fieldvalue . '</a>' . $photoico;
            break;
        case 'lastlogin':
            if ($fieldvalue < 1) {
                // if the user never logged in, show the registration date
                $regdate = strftime ($_CONF['shortdate'], strtotime($A['regdate']));
                $retval = "({$LANG28[36]}, {$LANG28[53]} $regdate)";
            } else {
                $retval = strftime ($_CONF['shortdate'], $fieldvalue);
            }
            break;
        case 'lastlogin_short':
            if ($fieldvalue < 1) {
                // if the user never logged in, show the registration date
                $regdate = strftime ($_CONF['shortdate'], strtotime($A['regdate']));
                $retval = "({$LANG28[36]})";
            } else {
                $retval = strftime ($_CONF['shortdate'], $fieldvalue);
            }
            break;
        case 'online_days':
            if ($fieldvalue < 0){
                // users that never logged in, would have a negative online days
                $retval = "N/A";
            } else {
                $retval = $fieldvalue;
            }
            break;
        case 'phantom_date':
        case 'offline_months':
            $retval = COM_numberFormat(round($fieldvalue / 2592000, 1));
            break;
        case 'online_hours':
            $retval = COM_numberFormat(round($fieldvalue / 3600, 3));
            break;
        case 'regdate':
            $retval = strftime ($_CONF['shortdate'], strtotime($fieldvalue));
            break;
        case $_TABLES['users'] . '.uid':
            $retval = $A['uid'];
            break;
        default:
            $retval = $fieldvalue;
            break;
    }

    if (isset($A['status']) && ($A['status'] == USER_ACCOUNT_DISABLED)) {
        if (($fieldname != 'edit') && ($fieldname != 'username')) {
            $retval = sprintf ('<s title="%s">%s</s>', $LANG28[42], $retval);
        }
    }

    return $retval;
}

function ADMIN_getListField_stories($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG24, $LANG_ACCESS, $_IMAGE_TYPE;

    static $topics;

    if (!isset ($topics)) {
        $topics = array ();
    }

    $retval = '';

    switch($fieldname) {
        case "unixdate":
            $curtime = COM_getUserDateTimeFormat ($A['unixdate']);
            $retval = strftime($_CONF['daytime'], $curtime[1]);
            break;
        case "title":
            $A['title'] = str_replace('$', '&#36;', $A['title']);
            $article_url = COM_buildUrl ($_CONF['site_url'] . '/article.php?story='
                                  . $A['sid']);
            $retval =  "<a href=\"$article_url\">" . stripslashes($A['title']) . "</a>";
            break;
        case "draft_flag":
            if ($A['draft_flag'] == 1) {
                $retval = $LANG24[35];
            } else {
                $retval = $LANG24[36];
            }
            break;
        case "access":
        case "edit":
        case "edit_adv":
            $access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
                                     $A['perm_owner'], $A['perm_group'],
                                     $A['perm_members'], $A['perm_anon']);
            if ($access == 3) {
                if (SEC_hasTopicAccess ($A['tid']) == 3) {
                    $access = $LANG_ACCESS['edit'];
                } else {
                    $access = $LANG_ACCESS['readonly'];
                }
            } else {
                $access = $LANG_ACCESS['readonly'];
            }
            if ($fieldname == 'access') {
                $retval = $access;
            } else if ($access == $LANG_ACCESS['edit']) {
                if ($fieldname == 'edit_adv') {
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/story.php?mode=edit&amp;editor=adv&amp;sid={$A['sid']}\">{$icon_arr['edit']}</a>";
                } else if ($fieldname == 'edit') {
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/story.php?mode=edit&amp;editor=std&amp;sid={$A['sid']}\">{$icon_arr['edit']}</a>";
                }
            }
            break;
        case "featured":
            if ($A['featured'] == 1) {
                $retval = $LANG24[35];
            } else {
                $retval = $LANG24[36];
            }
            break;
        case "ping":
            $pingico = '<img src="' . $_CONF['layout_url'] . '/images/sendping.'
                     . $_IMAGE_TYPE . '" alt="' . $LANG24[21] . '" title="'
                     . $LANG24[21] . '">';
            if (($A['draft_flag'] == 0) && ($A['unixdate'] < time())) {
                $url = $_CONF['site_admin_url']
                     . '/trackback.php?mode=sendall&amp;id=' . $A['sid'];
                $retval = '<a href="' . $url . '">' . $pingico . '</a>';
            } else {
                $retval = '';
            }
            break;
        case 'tid':
            if (!isset ($topics[$A['tid']])) {
                $topics[$A['tid']] = DB_getItem ($_TABLES['topics'], 'topic',
                                                 "tid = '{$A['tid']}'");
            }
            $retval = $topics[$A['tid']];
            break;
        case 'username':
            $retval = COM_getDisplayName ($A['uid'], $A['username'], $A['fullname']);
            break;
        default:
            $retval = $fieldvalue;
            break;
    }

    return $retval;
}

function ADMIN_getListField_syndication($fieldname, $fieldvalue, $A, $icon_arr) {
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG33, $_IMAGE_TYPE;

    $retval = '';

    switch($fieldname) {
        case "edit":
            $retval = "<a href=\"{$_CONF['site_admin_url']}/syndication.php?mode=edit&amp;fid={$A['fid']}\">{$icon_arr['edit']}</a>";
            break;
        case 'type':
            $retval = ucwords($A['type']);
            break;
        case 'format':
            $retval = str_replace ('-' , ' ', ucwords ($A['format']));
            break;
        case 'updated':
            $retval = strftime ($_CONF['daytime'], $A['date']);
            break;
        case 'is_enabled':
            if ($A['is_enabled'] == 1) {
                $switch = 'checked="checked"';
            } else {
                $switch = '';
            }
            $retval = "<form action=\"{$_CONF['site_admin_url']}/syndication.php\" method=\"POST\"><fieldset>"
                     ."<input type=\"checkbox\" name=\"feedenable\" onclick=\"submit()\" value=\"{$A['fid']}\" $switch>"
                     ."<input type=\"hidden\" name=\"feedChange\" value=\"{$A['fid']}\"></fieldset></form>";
            break;
        case 'header_tid':
            if ($A['header_tid'] == 'all') {
                $retval = $LANG33[43];
            } elseif ($A['header_tid'] == 'none') {
                $retval = $LANG33[44];
            } else {
                $retval = DB_getItem ($_TABLES['topics'], 'topic',
                                      "tid = '{$A['header_tid']}'");
            }
            break;
        case 'filename':
            $url = SYND_getFeedUrl ();
            $retval = '<a href="' . $url . $A['filename'] . '">' . $A['filename'] . '</a>';
            break;
        default:
            $retval = $fieldvalue;
            break;
    }
    return $retval;
}

function ADMIN_getListField_plugins($fieldname, $fieldvalue, $A, $icon_arr) {
    global $_CONF, $LANG_ADMIN, $LANG32;
    $retval = '';

    switch($fieldname) {
        case "edit":
            $retval = "<a href=\"{$_CONF['site_admin_url']}/plugins.php?mode=edit&amp;pi_name={$A['pi_name']}\">{$icon_arr['edit']}</a>";
            break;
        case 'pi_version':
            $plugin_code_version = PLG_chkVersion ($A['pi_name']);
            if (empty ($plugin_code_version)) {
                $code_version = 'N/A';
            } else {
                $code_version = $plugin_code_version;
            }
            $pi_installed_version = $A['pi_version'];
            if (empty ($plugin_code_version) ||
                    ($pi_installed_version == $code_version)) {
                $retval = $pi_installed_version;
            } else {
                $retval = "{$LANG32[37]}: $pi_installed_version,&nbsp;{$LANG32[36]}: $plugin_code_version";
                if ($A['pi_enabled'] == 1) {
                    $retval .= " <b>{$LANG32[38]}</b>";
                }
            }
            break;
        case 'enabled':
            if ($A['pi_enabled'] == 1) {
                $switch = 'checked="checked"';
            } else {
                $switch = '';
            }
            $retval = "<form action=\"{$_CONF['site_admin_url']}/plugins.php\" method=\"post\"><fieldset>"
                     ."<input type=\"checkbox\" name=\"pluginenable\" onclick=\"submit()\" value=\"{$A['pi_name']}\" $switch>"
                     ."<input type=\"hidden\" name=\"pluginChange\" value=\"{$A['pi_name']}\">"
                     ."</fieldset></form>";
            break;
        default:
            $retval = $fieldvalue;
            break;
    }
    return $retval;
}

function ADMIN_getListField_moderation($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG_ADMIN;

    $retval = '';

    $type = '';
    if (isset ($A['_moderation_type'])) {
        $type = $A['_moderation_type'];
    }
    switch ($fieldname) {
        case 'edit':
            $retval = "<a href=\"{$A['edit']}\">{$icon_arr['edit']}</a>";
            break;
        case 'delete':
            $retval = "<input type=\"radio\" name=\"action[{$A['row']}]\" value=\"delete\">";
            break;
        case 'approve':
            $retval = "<input type=\"radio\" name=\"action[{$A['row']}]\" value=\"approve\">"
                     ."<input type=\"hidden\" name=\"id[{$A['row']}]\" value=\"{$A[0]}\">";
            break;
        case 'day':
            $retval = strftime ($_CONF['daytime'], $A['day']);
            break;
        case 'tid':
            $retval = DB_getItem ($_TABLES['topics'], 'topic',
                                  "tid = '{$A['tid']}'");
            break;
        default:
            if (($fieldname == 3) && ($type == 'story')) {
                $retval = DB_getItem ($_TABLES['topics'], 'topic',
                                      "tid = '{$A[3]}'");
            } else {
                $retval = COM_makeClickableLinks (stripslashes ($fieldvalue));
            }
            break;
    }

    return $retval;
}

function ADMIN_getListField_trackback($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_TRB;

    $retval = '';

    switch($fieldname) {
        case "edit":
            $retval = "<a href=\"{$_CONF['site_admin_url']}/trackback.php?mode=editservice&amp;service_id={$A['pid']}\">{$icon_arr['edit']}</a>";
            break;
        case "name":
            $retval = "<a href=\"{$A['site_url']}\">{$A['name']}</a>";
            break;
        case "method":
            if ($A['method'] == 'weblogUpdates.ping') {
                $retval = $LANG_TRB['ping_standard'];
            } else if ($A['method'] == 'weblogUpdates.extendedPing') {
                $retval = $LANG_TRB['ping_extended'];
            } else {
                $retval = '<span class="warningsmall">' .
                        $LANG_TRB['ping_unknown'] .  '</span>';
            }
            break;
        case "is_enabled":
            if ($A['is_enabled'] == 1) {
                $switch = 'checked="checked"';
            } else {
                $switch = '';
            }
            $retval = "<form action=\"{$_CONF['site_admin_url']}/trackback.php\" method=\"POST\"><fieldset>"
                     ."<input type=\"checkbox\" name=\"serviceenable\" onclick=\"submit()\" value=\"{$A['pid']}\" $switch>"
                     ."<input type=\"hidden\" name=\"serviceChange\" value=\"{$A['pid']}\">"
                     ."</fieldset></form>";
            break;
        default:
            $retval = $fieldvalue;
            break;
    }

    return $retval;
}

?>
