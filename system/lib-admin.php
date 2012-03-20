<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | lib-admin.php                                                             |
// |                                                                           |
// | Admin-related functions needed in more than one place.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
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

/**
* This file contains functions used in the admin panels (mostly for the
* various lists of stories, users, etc.).
*
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-admin.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Default number of list entries per page
*/
if (! defined('DEFAULT_ENTRIES_PER_PAGE')) {
    define('DEFAULT_ENTRIES_PER_PAGE', 50);
}

/**
* Common function used in Admin scripts to display a list of items
*
* @param    string  $fieldfunction  Name of a function used to display the list item row details
* @param    array   $header_arr     array of header fields with sortables and table fields
* @param    array   $text_arr       array with different text strings
* @param    array   $data_arr       array with sql query data - array of list records
* @param    array   $options        array of options - intially just used for the Check-All feature
* @param    array   $form_arr       optional extra forms at top or bottom
* @return   string                  HTML output of function
*
*/
function ADMIN_simpleList($fieldfunction, $header_arr, $text_arr,
                           $data_arr, $options = '', $form_arr='')
{
    global $_CONF, $_TABLES, $LANG01, $LANG_ADMIN, $LANG_ACCESS, $MESSAGE,
           $_IMAGE_TYPE;

    $retval = '';

    $help_url = '';
    if (!empty($text_arr['help_url'])) {
        $help_url = $text_arr['help_url'];
    }

    $title = '';
    if (!empty($text_arr['title'])) {
        $title = $text_arr['title'];
    }

    $form_url = '';
    if (!empty($text_arr['form_url'])) {
        $form_url = $text_arr['form_url'];
    }

    $admin_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/lists');
    $admin_templates->set_file (
        array (
            'list' => 'list.thtml',
            'header' => 'header.thtml',
            'row' => 'listitem.thtml',
            'field' => 'field.thtml'
        )
    );
    $admin_templates->set_var('form_url', $form_url);
    $admin_templates->set_var('lang_edit', $LANG_ADMIN['edit']);
    $admin_templates->set_var('lang_deleteall', $LANG01[124]);
    $admin_templates->set_var('lang_delconfirm', $LANG01[125]);
    if (isset($form_arr['top'])) {
        $admin_templates->set_var('formfields_top', $form_arr['top']);
    }
    if (isset($form_arr['bottom'])) {
        $admin_templates->set_var('formfields_bottom', $form_arr['bottom']);
    }

    # define icon paths. Those will be transmitted to $fieldfunction.
    $icons_type_arr = array('edit', 'copy', 'list', 'addchild', 'install', 'unavailable', 'info');
    $icon_arr = array();
    foreach ($icons_type_arr as $icon_type) {
        $icon_url = "{$_CONF['layout_url']}/images/$icon_type.$_IMAGE_TYPE";
        $icon_arr[$icon_type] = COM_createImage($icon_url, $LANG_ADMIN[$icon_type]);
    }

    // Check if the delete checkbox and support for the delete all feature should be displayed
    $min_data = 1;
    if (is_array($options) && isset($options['chkminimum'])) {
        $min_data = $options['chkminimum'];
    }
    if (count($data_arr) > $min_data AND is_array($options) AND $options['chkdelete']) {
        $admin_templates->set_var('header_text', '<input type="checkbox" name="chk_selectall" title="'.$LANG01[126].'" onclick="caItems(this.form);"' . XHTML . '>');
        $admin_templates->set_var('class', "admin-list-field");
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
        $use_fieldfunction = is_callable($fieldfunction);
        for ($i = 0; $i < count($data_arr); $i++) {
            if (count($data_arr) > $min_data AND is_array($options) AND $options['chkdelete']) {
                $admin_templates->set_var('itemtext', '<input type="checkbox" name="delitem[]" value="' . $data_arr[$i][$options['chkfield']].'"' . XHTML . '>');
                $admin_templates->set_var('class', "admin-list-field");
                $admin_templates->parse('item_field', 'field', true);
            }
            for ($j = 0; $j < count($header_arr); $j++) {
                $fieldname = $header_arr[$j]['field'];
                if (isset($data_arr[$i][$fieldname])) {
                    $fieldvalue = strval($data_arr[$i][$fieldname]);
                } else {
                    $fieldvalue = '';
                }
                if ($use_fieldfunction) {
                    $fieldvalue = $fieldfunction($fieldname, $fieldvalue, $data_arr[$i], $icon_arr);
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

    if (!empty($title)) {
        $retval .= COM_startBlock($title, $help_url,
                            COM_getBlockTemplate('_admin_block', 'header'));
    }
    $retval .= $admin_templates->finish($admin_templates->get_var('output'));
    if (!empty($title)) {
        $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
    }

    return $retval;
}

/**
* Creates a list of data with a search, filter, clickable headers etc.
*
* @param    string  $component      name of the list
* @param    string  $fieldfunction  name of the function that handles special entries
* @param    array   $header_arr     array of header fields with sortables and table fields
* @param    array   $text_arr       array with different text strings
* @param    array   $query_arr      array with sql-options
* @param    array   $defsort_arr    default sorting values
* @param    string  $filter         additional drop-down filters
* @param    string  $extra          additional values passed to fieldfunction
* @param    array   $options        array of options - intially just used for the Check-All feature
* @param    array   $form_arr       optional extra forms at top or bottom
* @param    bool    $showsearch     whether to show the search functionality
* @return   string                  HTML output of function
*
*/
function ADMIN_list($component, $fieldfunction, $header_arr, $text_arr,
            $query_arr, $defsort_arr, $filter = '', $extra = '',
            $options = '', $form_arr='', $showsearch = true)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG_ACCESS, $LANG01, $_IMAGE_TYPE, $MESSAGE;

    // set all variables to avoid warnings
    $retval = '';
    $filter_str = '';
    $order_sql = '';
    $group_by_sql = '';
    $limit = '';
    $prevorder = '';
    if (isset ($_GET['prevorder'])) { # what was the last sorting?
        $prevorder = COM_applyFilter ($_GET['prevorder']);
    }

    $query = '';
    if (isset ($_REQUEST['q'])) { // get query (text-search)
        $query = strip_tags(COM_stripslashes($_REQUEST['q']));
    }

    $query_limit = '';
    if (isset($_REQUEST['query_limit'])) { // get query-limit (list-length)
        $query_limit = COM_applyFilter($_REQUEST['query_limit'], true);
        if ($query_limit == 0) {
            $query_limit = DEFAULT_ENTRIES_PER_PAGE;
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

    $inline_form = false;
    if (isset($text_arr['inline'])) {
        $inline_form = $text_arr['inline'];
    }

    # get all template fields.
    $admin_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/lists');
    $template_files = array(
            'list'   => ($inline_form ? 'inline.thtml' : 'list.thtml'),
            'header' => 'header.thtml',
            'row'    => 'listitem.thtml',
            'field'  => 'field.thtml' );
    if ($showsearch) {
        $template_files['search'] = 'searchmenu.thtml';
    }
    $admin_templates->set_file($template_files);

    $admin_templates->set_var('form_url', $form_url);
    $admin_templates->set_var('lang_edit', $LANG_ADMIN['edit']);
    $admin_templates->set_var('lang_deleteall', $LANG01[124]);
    $admin_templates->set_var('lang_delconfirm', $LANG01[125]);
    if (isset($form_arr['top'])) {
        $admin_templates->set_var('formfields_top', $form_arr['top']);
    }
    if (isset($form_arr['bottom'])) {
        $admin_templates->set_var('formfields_bottom', $form_arr['bottom']);
    }
    // Check if the delete checkbox and support for the delete all feature should be displayed
    if (is_array($options) AND $options['chkdelete']) {
        $admin_templates->set_var('header_text', '<input type="checkbox" name="chk_selectall" title="'.$LANG01[126].'" onclick="caItems(this.form);"' . XHTML . '>');
        $admin_templates->set_var('class', "admin-list-field");
        $admin_templates->set_var('show_deleteimage', '');
        $admin_templates->parse('header_row', 'header', true);
        $admin_templates->clear_var('on_click');
    } else {
        $admin_templates->set_var('show_deleteimage','display:none;');
    }

    # define icon paths. Those will be transmitted to $fieldfunction.
    $icons_type_arr = array('edit', 'copy', 'list', 'addchild', 'deleteitem', 'enabled', 'disabled', 'unavailable', 'warning', 'info');
    $icon_arr = array();
    foreach ($icons_type_arr as $icon_type) {
        $icon_url = "{$_CONF['layout_url']}/images/$icon_type.$_IMAGE_TYPE";
        $icon_arr[$icon_type] = COM_createImage($icon_url, $LANG_ADMIN[$icon_type], array('style' => 'vertical-align: middle;'));
    }

    $has_extras = '';
    if (isset($text_arr['has_extras'])) { # does this one use extras? (search, google paging)
        $has_extras = $text_arr['has_extras'];
    }
    if ($has_extras) { // show search
        $admin_templates->set_var('lang_search', $LANG_ADMIN['search']);
        $admin_templates->set_var('lang_submit', $LANG_ADMIN['submit']);
        $admin_templates->set_var('lang_limit_results',
                                  $LANG_ADMIN['limit_results']);
        $admin_templates->set_var('last_query', htmlspecialchars($query));
        $admin_templates->set_var('filter', $filter);
    }

    $sql_query = addslashes($query); // replace quotes etc for security
    $sql = $query_arr['sql']; // get sql from array that builds data

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
    $img_arrow_url = "{$_CONF['layout_url']}/images/$arrow.$_IMAGE_TYPE";
    $img_arrow = '&nbsp;' . COM_createImage($img_arrow_url, $arrow);

    if (!empty ($order_for_query)) { # concat order string
        $order_sql = "ORDER BY $order_for_query $direction";
    }
    $th_subtags = ''; // other tags in the th, such as onclick and mouseover
    $header_text = ''; // title as displayed to the user
    // HEADER FIELDS array(text, field, sort, class)
    // this part defines the contents & format of the header fields

    for ($i=0; $i < count( $header_arr ); $i++) { #iterate through all headers
        $header_text = $header_arr[$i]['text'];
        $th_subtags = '';
        if ($header_arr[$i]['sort'] != false) { # is this sortable?
            if ($order==$header_arr[$i]['field']) { # is this currently sorted?
                $header_text .= $img_arrow;
            }
            # make the mouseover effect is sortable
            $th_subtags = " onmouseover=\"this.style.cursor='pointer';\"";
            $order_var = $i; # assign number to field so we know what to sort
            if (strpos ($form_url, '?') > 0) {
                $separator = '&amp;';
            } else {
                $separator = '?';
            }
            $th_subtags .= " onclick=\"window.location.href='$form_url$separator" // onclick action
                    ."order=$order_var&amp;prevorder=$order&amp;direction=$direction";
            if (!empty($page)) {
                $th_subtags .= '&amp;' . $component . 'listpage=' . $page;
            }
            if (!empty($query)) {
                $th_subtags .= '&amp;q=' . urlencode($query);
            }
            if (!empty($query_limit)) {
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

    if ($has_extras) {
        /**
        * default query limit if no other ch osen.
        * @todo maybe this could be a setting from the list?
        */
        $limit = DEFAULT_ENTRIES_PER_PAGE;
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
        $admin_templates->parse('search_menu', 'search', true);
    }

    if (is_callable($fieldfunction)) {
        if (!empty($extra)) $use_fieldfunction = 2;
        else $use_fieldfunction = 1;
    } else $use_fieldfunction = 0;

    if (!empty($query_arr['query_group'])){ # add group by to sql
        $group_by_sql = " GROUP BY {$query_arr['query_group']}";
    }
    
    # SQL
    $sql .= "$filter_str $group_by_sql $order_sql $limit;";
    // echo $sql;
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    $r = 1; # r is the counter for the actual displayed rows for correct coloring
    for ($i = 0; $i < $nrows; $i++) { # now go through actual data
        $A = DB_fetchArray($result);
        $this_row = false; # as long as no fields are returned, dont print row
        if (is_array($options) AND $options['chkdelete']) {
            $admin_templates->set_var('class', "admin-list-field");
            $admin_templates->set_var('itemtext', '<input type="checkbox" name="delitem[]" value="' . $A[$options['chkfield']].'"' . XHTML . '>');
            $admin_templates->parse('item_field', 'field', true);
        }
        for ($j = 0; $j < count($header_arr); $j++) {
            $fieldname = $header_arr[$j]['field']; # get field name from headers
            if (isset($A[$fieldname])) {
                $fieldvalue = strval($A[$fieldname]); # yes, get its data
            } else {
                $fieldvalue = '';                
            }
            switch ($use_fieldfunction) {
            case 2: $fieldvalue = $fieldfunction($fieldname, $fieldvalue, $A, $icon_arr, $extra);
                    break;
            case 1: $fieldvalue = $fieldfunction($fieldname, $fieldvalue, $A, $icon_arr);
                    break;
            default: break;
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

    // Do the actual output
    if (!empty($title)) {
        $retval .= COM_startBlock($title, $help_url,
                            COM_getBlockTemplate('_admin_block', 'header'));
    }
    $retval .= $admin_templates->finish($admin_templates->get_var('output'));
    if (!empty($title)) {
        $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
    }

    return $retval;
}

/**
* Creates a menu with an optional icon and optional text below
* this is used in the admin screens but may be used elsewhere also.
*
* @param    array   $menu_arr       array of text & URL of the menu entries
* @param    string  $text           instructions to be displayed
* @param    string  icon            url of an icon that will be displayed
* @return   string                  HTML output of function
*
*/
function ADMIN_createMenu($menu_arr, $text, $icon = '')
{
    global $_CONF;

    $admin_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/lists');
    $admin_templates->set_file (
        array ('top_menu' => 'topmenu.thtml')
    );

    $menu_fields = '';
    $attr = array('class' => 'admin-menu-item');
    for ($i = 0; $i < count($menu_arr); $i++) { # iterate through menu
        $menu_fields .= COM_createLink($menu_arr[$i]['text'], $menu_arr[$i]['url'], $attr);
        if ($i < (count($menu_arr) -1)) {
            $menu_fields .= ' | '; # add separator
        }
    }
    if (!empty ($icon)) {
        $attr = array('class' => 'admin-menu-icon');
        $icon = COM_createImage($icon, '', $attr);
        $admin_templates->set_var('icon', $icon);
    }
    $admin_templates->set_var('menu_fields', $menu_fields);
    $admin_templates->set_var('lang_instructions', $text);
    $admin_templates->parse('top_menu', 'top_menu');
    $retval = $admin_templates->finish($admin_templates->get_var('top_menu'));
    return $retval;
}


/**
 * The following functions are helper functions used as $fieldfunction with
 * ADMIN_list and ADMIN_simpleList (see above)
 *
 */


/**
 * used for the list of blocks in admin/block.php
 *
 */
function ADMIN_getListField_blocks($fieldname, $fieldvalue, $A, $icon_arr, $token)
{
    global $_CONF, $LANG_ADMIN, $LANG21, $_IMAGE_TYPE, $_TABLES;

    $retval = false;

    $access = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'],
                    $A['perm_group'], $A['perm_members'], $A['perm_anon']);

    if (($access > 0) && (TOPIC_hasMultiTopicAccess('block', $A['bid']) > 0)) {
        switch ($fieldname) {
        case 'edit':
            if ($access == 3) {
                $retval = COM_createLink($icon_arr['edit'],
                    "{$_CONF['site_admin_url']}/block.php?mode=edit&amp;bid={$A['bid']}");
            }
            break;

        case 'title':
            $retval = stripslashes($A['title']);
            if (empty($retval)) {
                $retval = '(' . $A['name'] . ')';
            }
            break;

        case 'blockorder':
            $retval .= $A['blockorder'];
            break;

        case 'is_enabled':
            if ($access == 3) {
                if ($A['is_enabled'] == 1) {
                    $switch = ' checked="checked"';
                } else {
                    $switch = '';
                }
                $retval = '<input type="checkbox" name="enabledblocks[]" '
                            . 'onclick="submit()" value="' . $A['bid'] . '"'
                            . $switch . XHTML . '>'
                        . '<input type="hidden" name="visibleblocks[]" value="'
                            . $A['bid'] . '"' . XHTML . '>';
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
                $csrftoken = '&amp;' . CSRF_TOKEN . '=' . $token;
                $retval.="<img src=\"{$_CONF['layout_url']}/images/admin/$blockcontrol_image\" width=\"45\" height=\"20\" usemap=\"#arrow{$A['bid']}\" alt=\"\"" . XHTML . ">"
                        ."<map id=\"arrow{$A['bid']}\" name=\"arrow{$A['bid']}\">"
                        ."<area coords=\"0,0,12,20\"  title=\"{$LANG21[58]}\" href=\"{$_CONF['site_admin_url']}/block.php?mode=move&amp;bid={$A['bid']}&amp;where=up{$csrftoken}\" alt=\"{$LANG21[58]}\"" . XHTML . ">"
                        ."<area coords=\"13,0,29,20\" title=\"$moveTitleMsg\" href=\"{$_CONF['site_admin_url']}/block.php?mode=move&amp;bid={$A['bid']}&amp;where=$switchside{$csrftoken}\" alt=\"$moveTitleMsg\"" . XHTML . ">"
                        ."<area coords=\"30,0,43,20\" title=\"{$LANG21[57]}\" href=\"{$_CONF['site_admin_url']}/block.php?mode=move&amp;bid={$A['bid']}&amp;where=dn${csrftoken}\" alt=\"{$LANG21[57]}\"" . XHTML . ">"
                        ."</map>";
            }
            break;
            
        case 'topic':
            $retval = TOPIC_getTopicAdminColumn('block', $A['bid']);
            break;

        default:
            $retval = $fieldvalue;
            break;
        }
    }

    return $retval;
}

/**
 * used for the list of blocks in admin/block.php
 *
 */
function ADMIN_getListField_dynamicblocks($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG_ADMIN, $LANG21, $_IMAGE_TYPE, $_TABLES;

    $retval = false;
    
    switch ($fieldname) {
    case 'title':
        $retval = stripslashes($A['title']);
        if (empty($retval)) {
            $retval = '(' . $A['name'] . ')';
        }
        break;

    case 'is_enabled':
        if ($A['enable'] == 1) {
            $retval = $LANG21[5]; // Yes
        } else {
            $retval = $LANG21[6]; // No
        }
        break;

    case 'topic':
        if ($A['topic_option'] == TOPIC_ALL_OPTION) {
            $retval = $LANG21[7];                
        } elseif ($A['topic_option'] == TOPIC_HOMEONLY_OPTION) {
            $retval = $LANG21[43];    
        } else {
            $element_num = count($A['topic']);
            
            if ($element_num == 0) {
                $retval = $LANG21[47]; // None
            } elseif ($element_num > 1) {
                $retval = $LANG21[44]; // Multiple
            } else {
                $retval = DB_getItem($_TABLES['topics'], 'topic', "tid = '{$A['topic'][0]}'");
            }
        }        

        break;

    default:
        $retval = $fieldvalue;
        break;
    }

    return $retval;
}

/**
 * used for the list of groups and in the group editor in admin/group.php
 *
 */
function ADMIN_getListField_groups($fieldname, $fieldvalue, $A, $icon_arr, $selected = '')
{
    global $_CONF, $LANG_ACCESS, $LANG_ADMIN, $thisUsersGroups;

    $retval = false;

    if(! is_array($thisUsersGroups)) {
        $thisUsersGroups = SEC_getUserGroups();
    }

    $show_all_groups = false;
    if (isset($_REQUEST['chk_showall']) && ($_REQUEST['chk_showall'] == 1)) {
        $show_all_groups = true;
    }

    if (in_array($A['grp_id'], $thisUsersGroups) ||
          SEC_groupIsRemoteUserAndHaveAccess($A['grp_id'], $thisUsersGroups)) {
        switch($fieldname) {
        case 'edit':
            $url = $_CONF['site_admin_url'] . '/group.php?mode=edit&amp;grp_id='
                 . $A['grp_id'];
            if ($show_all_groups) {
                $url .= '&amp;chk_showall=1';
            }
            $retval = COM_createLink($icon_arr['edit'], $url);
            break;

        case 'grp_gl_core':
            if ($A['grp_gl_core'] == 1) {
                $retval = $LANG_ACCESS['yes'];
            } else {
                $retval = $LANG_ACCESS['no'];
            }
            break;

        case 'grp_default':
            if ($A['grp_default'] != 0) {
                $retval = $LANG_ACCESS['yes'];
            } else {
                $retval = $LANG_ACCESS['no'];
            }
            break;

        case 'list':
            $url = $_CONF['site_admin_url'] . '/group.php?mode=';
            if ($show_all_groups) {
                $param = '&amp;grp_id=' . $A['grp_id'] . '&amp;chk_showall=1';
            } else {
                $param = '&amp;grp_id=' . $A['grp_id'];
            }

            $retval = COM_createLink($icon_arr['list'],
                                     $url . 'listusers' . $param);
            if (($A['grp_name'] != 'All Users') &&
                    ($A['grp_name'] != 'Logged-in Users')) {
                $retval .= '&nbsp;&nbsp;' . COM_createLink($icon_arr['edit'],
                                                $url . 'editusers' . $param);
            }
            break;

        case 'checkbox':
            $retval = '<input type="checkbox" name="groups[]" value="'
                    . $A['grp_id'] . '"';
            if (is_array($selected) && in_array($A['grp_id'], $selected)) {
                $retval .= ' checked="checked"';
            }
            $retval .= XHTML . '>';
            break;

        case 'disabled-checkbox':
            $retval = '<input type="checkbox" checked="checked" '
                    . 'disabled="disabled"' . XHTML . '>'
                    . '<input type="hidden" name="groups[]" value="'
                    . $A['grp_id'] . '"' . XHTML . '>';
            break;

        case 'grp_name':
            $retval = ucwords($fieldvalue);
            break;

        default:
            $retval = $fieldvalue;
            break;
        }
    }

    return $retval;
}

/**
 * used for the list of users in admin/user.php
 *
 */
function ADMIN_getListField_users($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG04, $LANG28, $_IMAGE_TYPE;

    $retval = '';

    switch ($fieldname) {
        case 'delete':
            $retval = '<input type="checkbox" name="delitem[]" checked="checked"' . XHTML . '>';
            break;
        case 'edit':
            $retval = COM_createLink($icon_arr['edit'],
                "{$_CONF['site_admin_url']}/user.php?mode=edit&amp;uid={$A['uid']}");
            break;
        case 'username':
            $photoico = '';
            if (!empty ($A['photo'])) {
                $photoico = "&nbsp;<img src=\"{$_CONF['layout_url']}/images/smallcamera."
                          . $_IMAGE_TYPE . '" alt="{$LANG04[77]}"' . XHTML . '>';
            } else {
                $photoico = '';
            }
            $retval = COM_createLink($fieldvalue, $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' .  $A['uid']) . $photoico;
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
                $retval = $LANG_ADMIN['na'];
            } else {
                $retval = $fieldvalue;
            }
            break;
        case 'phantom_date':
        case 'offline_months':
            $retval = COM_numberFormat(round($fieldvalue / 2592000));
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
            $retval = sprintf ('<span class="strike" title="%s">%s</span>',
                               $LANG28[42], $retval);
        }
    }

    return $retval;
}

/**
 * used for the list of stories in admin/story.php
 *
 */
function ADMIN_getListField_stories($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG24, $LANG_ACCESS, $_IMAGE_TYPE;

    static $topics;

    if (!isset($topics)) {
        $topics = array();
    }

    $retval = '';

    switch ($fieldname) {
    case 'unixdate':
        $curtime = COM_getUserDateTimeFormat($A['unixdate']);
        $retval = strftime($_CONF['daytime'], $curtime[1]);
        break;

    case 'title':
        $A['title'] = str_replace('$', '&#36;', $A['title']);
        $article_url = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                                    . $A['sid']);
        $attr = array();
        if (! empty($A['page_title'])) {
            $attr['title'] = htmlspecialchars($A['page_title']);
        }
        $retval = COM_createLink(stripslashes($A['title']), $article_url, $attr);
        break;

    case 'draft_flag':
        if ($A['draft_flag'] == 1) {
            $retval = $LANG24[35];
        } else {
            $retval = $LANG24[36];
        }
        break;

    case 'access':
    case 'copy':
    case 'edit':
    case 'edit_adv':
        $access = SEC_hasAccess($A['owner_id'], $A['group_id'],
                                $A['perm_owner'], $A['perm_group'],
                                $A['perm_members'], $A['perm_anon']);
        if ($access == 3) {
            if (TOPIC_hasMultiTopicAccess('article', $A['sid']) == 3) {
                $access = $LANG_ACCESS['edit'];
            } else {
                $access = $LANG_ACCESS['readonly'];
            }
        } else {
            $access = $LANG_ACCESS['readonly'];
        }
        if ($fieldname == 'access') {
            $retval = $access;
        } elseif ($access == $LANG_ACCESS['edit']) {
            if ($fieldname == 'edit_adv') {
                $editmode = 'adv';
            } elseif ($fieldname == 'edit') {
                $editmode = 'std';
            }
            if ($fieldname == 'copy') {
                $copyurl = $_CONF['site_admin_url']
                         . '/story.php?mode=clone&amp;sid=' . $A['sid'];
                $retval = COM_createLink($icon_arr['copy'], $copyurl);
            } else {
                $editurl = $_CONF['site_admin_url']
                         . '/story.php?mode=edit&amp;editor=' . $editmode
                         . '&amp;sid=' . $A['sid'];
                $retval = COM_createLink($icon_arr['edit'], $editurl);
            }
        }
        break;

    case 'featured':
        if ($A['featured'] == 1) {
            $retval = $LANG24[35];
        } else {
            $retval = $LANG24[36];
        }
        break;

    case 'ping':
        // Allow ping if all topics allow anonymous access that story belongs too
        $topic_anon = 0;
        $tids = TOPIC_getTopicIdsForObject('article', $A['sid']);
        foreach ($tids as $tid) {
            $current_access = DB_getItem($_TABLES['topics'], 'perm_anon', "tid = '" . addslashes($tid) . "'");
            if ($topic_anon < $current_access) {
                $topic_anon = $current_access;
            }            
        }

        if (($A['draft_flag'] == 0) && ($A['unixdate'] < time()) &&
                ($A['perm_anon'] != 0) && ($topic_anon != 0)) {
            $pingico = '<img src="' . $_CONF['layout_url'] . '/images/sendping.'
                     . $_IMAGE_TYPE . '" alt="' . $LANG24[21] . '" title="'
                     . $LANG24[21] . '"' . XHTML . '>';
            $url = $_CONF['site_admin_url']
                 . '/trackback.php?mode=sendall&amp;id=' . $A['sid'];
            $retval = COM_createLink($pingico, $url);
        } else {
            $retval = '';
        }
        break;
        
    case 'topic_ids':
        $retval = TOPIC_getTopicAdminColumn('article', $A['sid']);
        break;

    case 'username':
    case 'fullname':
        $retval = COM_getDisplayName($A['uid'], $A['username'], $A['fullname']);
        break;

    default:
        $retval = $fieldvalue;
        break;
    }

    return $retval;
}

/**
 * used for the list of feeds in admin/syndication.php
 *
 */
function ADMIN_getListField_syndication($fieldname, $fieldvalue, $A, $icon_arr, $token)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG33, $_IMAGE_TYPE;

    $retval = '';

    switch ($fieldname) {
    case 'edit':
        $retval = COM_createLink($icon_arr['edit'],
            "{$_CONF['site_admin_url']}/syndication.php?mode=edit&amp;fid={$A['fid']}");
        break;

    case 'type':
        if ($A['type'] == 'article') {
            $retval = $LANG33[55];
        } else {
            $retval = ucwords($A['type']);
        }
        break;

    case 'format':
        $retval = str_replace('-' , ' ', ucwords($A['format']));
        break;

    case 'updated':
        if ($A['is_enabled'] == 1) {
            $retval = strftime($_CONF['daytime'], $A['date']);
        } else {
            $retval = $LANG_ADMIN['na'];
        }
        break;

    case 'is_enabled':
        if ($A['is_enabled'] == 1) {
            $switch = ' checked="checked"';
        } else {
            $switch = '';
        }
        $retval = '<input type="checkbox" name="enabledfeeds[]" onclick="submit()" value="' . $A['fid'] . '"' . $switch . XHTML . '>'
                . '<input type="hidden" name="visiblefeeds[]" value="' . $A['fid'] . '"' . XHTML . '>';
        break;

    case 'header_tid':
        if ($A['header_tid'] == 'all') {
            $retval = $LANG33[43];
        } elseif ($A['header_tid'] == 'none') {
            $retval = $LANG33[44];
        } else {
            $retval = DB_getItem($_TABLES['topics'], 'topic',
                                 "tid = '{$A['header_tid']}'");
        }
        break;

    case 'filename':
        $url = SYND_getFeedUrl();
        $retval = COM_createLink($A['filename'], $url . $A['filename']);
        break;

    default:
        $retval = $fieldvalue;
        break;
    }

    return $retval;
}

/**
 * used for the list of plugins in admin/plugins.php
 *
 */
function ADMIN_getListField_plugins($fieldname, $fieldvalue, $A, $icon_arr, $token)
{
    global $_CONF, $LANG_ADMIN, $LANG32;

    $retval = '';

    switch ($fieldname) {
    case 'info_installed':
        $retval = COM_createLink($icon_arr['info'],
                "{$_CONF['site_admin_url']}/plugins.php?mode=info_installed&amp;pi_name={$A['pi_name']}",
                array('title' => $LANG32[13]));
        break;

    case 'pi_name':
        $retval = plugin_get_pluginname($A['pi_name']);
        break;

    case 'pi_version':
        $plugin_code_version = PLG_chkVersion($A['pi_name']);
        if (empty($plugin_code_version)) {
            $code_version = $LANG_ADMIN['na'];
        } else {
            $code_version = $plugin_code_version;
        }
        $pi_installed_version = $A['pi_version'];
        if (empty($plugin_code_version) ||
                ($pi_installed_version == $code_version)) {
            $retval = $pi_installed_version;
        } else {
            $retval = "{$LANG32[37]}: $pi_installed_version,&nbsp;{$LANG32[36]}: $plugin_code_version";
            if ($A['pi_enabled'] == 1) {
                $retval .= " <b>{$LANG32[38]}</b>";
                $csrftok = '&amp;' . CSRF_TOKEN . '=' . $token;
                $style = 'style="vertical-align: middle;"';
                $img = $_CONF['layout_url'] . '/images/update.png';
                $img = "<img $style alt=\"[" . $LANG32[38] . "]\" src=\"$img\"" . XHTML . ">";
                $url = $_CONF['site_admin_url'] . '/plugins.php?mode=updatethisplugin&amp;pi_name=' . $A['pi_name'] . $csrftok;
                $retval .= COM_CreateLink($img, $url, array('title' => $LANG32[42]));
            }
        }
        break;

    case 'pi_dependencies':
            if (PLG_checkDependencies($A['pi_name'])) {
                $retval = COM_getTooltip($LANG32[51], PLG_printDependencies($A['pi_name'], $A['pi_gl_version']));
            } else {
                $style = "display: inline; color: #a00; border-bottom: 1px dotted #a00;";
                $retval = COM_getTooltip("<b class='notbold' style='$style'>{$LANG32[52]}</b>", PLG_printDependencies($A['pi_name'], $A['pi_gl_version']));
            }
        break;

    case 'pi_load':
        $csrftok = '&amp;' . CSRF_TOKEN . '=' . $token;
        $style   = "style='vertical-align: middle;'";
        $upimg   = $_CONF['layout_url'] . '/images/admin/up.png';
        $dnimg   = $_CONF['layout_url'] . '/images/admin/down.png';
        $url     = $_CONF['site_admin_url'] . '/plugins.php?mode=change_load_order&amp;pi_name=' . $A['pi_name'] . $csrftok . '&amp;where=';
        $retval .= COM_CreateLink( "<img $style alt='+' src='$upimg'" . XHTML . ">", $url . 'up' , array('title' => $LANG32[44]));
        $retval .= '&nbsp;' . $A['pi_load'] . '&nbsp;';
        $retval .= COM_CreateLink( "<img $style alt='-' src='$dnimg'" . XHTML . ">", $url . 'dn' , array('title' => $LANG32[45]));
        break;

    case 'pi_enabled':
        if (!PLG_checkDependencies($A['pi_name'])) {
            $retval = str_replace('<img ', '<img title="' . $LANG32[64] . '" ', $icon_arr['warning']);
        } else {
            $not_present = false;
            if ($A['pi_enabled'] == 1) {
                $switch = 'enabled';
                $title  = $LANG32[49];
            } else {
                $switch = 'disabled';
                $title  = $LANG32[48];
                if (!file_exists($_CONF['path'] . 'plugins/' . $A['pi_name'] . '/functions.inc')) {
                    $not_present = true;
                }
            }
            if ($not_present) {
                $retval = str_replace('<img ', '<img title="' . $LANG32[64] . '" ', $icon_arr['unavailable']);
            } else {
                $sorting = '';
                $csrftoken = '&amp;' . CSRF_TOKEN . '=' . $token;
                if (!empty($_GET['order']) && !empty($_GET['direction'])) { // Remember how the list was sorted
                    $ord = trim($_GET['order']);
                    $dir = trim($_GET['direction']);
                    $old = trim($_GET['prevorder']);
                    $sorting = "&amp;order=$ord&amp;direction=$dir&amp;prevorder=$old";
                }
                $retval = COM_createLink($icon_arr[$switch], $_CONF['site_admin_url'] .
                            '/plugins.php?mode=toggle&amp;pi_name=' . $A['pi_name'] . $csrftoken . $sorting,
                            array('title' => $title));
            }
        }
        break;

    case 'delete':
        $csrftoken = '&amp;' . CSRF_TOKEN . '=' . $token;
        $id = 'uninstall_' . $A['pi_name']; // used by JavaScript
        $message = sprintf($LANG32[47], "\'" . plugin_get_pluginname($A['pi_name']) . "\'"); // used by JavaScript
        $url = $_CONF['site_admin_url'] . '/plugins.php?mode=delete&amp;pi_name=' . $A['pi_name'] . $csrftoken;
        $link_args = array('title' => $LANG32[46],
                          'onclick' => "confirm_action('$message', '$url&amp;confirmed=1')",
                          'id' => $id);
        $retval .= COM_CreateLink($icon_arr['deleteitem'], $url, $link_args);
        // If javascript is available, we will be using it to get a confirmation from the user. So we need to hide the default link.
        $retval .= '<script type="text/javascript">document.getElementById("' . $id . '").href = "javascript:void(0);";</script>';
        break;

    default:
        $retval = $fieldvalue;
        break;
    }

    return $retval;
}

/**
 * used for the lists of submissions and draft stories in admin/moderation.php
 *
 */
function ADMIN_getListField_moderation($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG_ADMIN;

    $retval = '';

    $type = '';
    if (isset($A['_moderation_type'])) {
        $type = $A['_moderation_type'];
    }
    switch ($fieldname) {
    case 'edit':
        $retval = COM_createLink($icon_arr['edit'], $A['edit']);
        break;

    case 'delete':
        $retval = "<input type=\"radio\" name=\"action[{$A['row']}]\" value=\"delete\"" . XHTML . ">";
        break;

    case 'approve':
        $retval = "<input type=\"radio\" name=\"action[{$A['row']}]\" value=\"approve\"" . XHTML . ">"
                 ."<input type=\"hidden\" name=\"id[{$A['row']}]\" value=\"{$A[0]}\"" . XHTML . ">";
        break;

    case 'day':
        $retval = strftime($_CONF['daytime'], $A['day']);
        break;

    case 'tid':
        $retval = DB_getItem($_TABLES['topics'], 'topic',
                             "tid = '{$A['tid']}'");
        break;

    case 'uid':
        $name = '';
        if ($A['uid'] == 1) {
            $name = htmlspecialchars(COM_stripslashes(DB_getItem($_TABLES['commentsubmissions'], 'name', "cid = '{$A['id']}'")));
        }
        if (empty($name)) {
            $name = COM_getDisplayName($A['uid']);
        }
        if ($A['uid'] == 1) {
            $retval = $name;
        } else {
            $retval = COM_createLink($name, $_CONF['site_url']
                            . '/users.php?mode=profile&amp;uid=' . $A['uid']);
        }
        break;

    case 'publishfuture':
        if (!SEC_inGroup('Comment Submitters', $A['uid']) && ($A['uid'] > 1)) {
            $retval = "<input type=\"checkbox\" name=\"publishfuture[]\" value=\"{$A['uid']}\"" . XHTML . ">";
        } else {
            $retval = $LANG_ADMIN['na'];
        }
        break;

    default:
        if (($fieldname == 3) && (($type == 'story') || ($type == 'story_draft'))) {
            $retval = TOPIC_getTopicAdminColumn('article', $A[0]);
        } elseif (($fieldname == 2) && ($type == 'comment')) {
            $commenttext = COM_getTextContent($A['comment']);
            $excerpt = htmlspecialchars(COM_truncate($commenttext, 140, '...'));

            // try to provide a link to the parent item (e.g. article, poll)
            $info = PLG_getItemInfo($A['type'], $A['sid'], 'title,url');
            if (empty($info) || empty($info[0]) || empty($info[1])) {
                // if not available, display excerpt from the comment
                $retval = htmlspecialchars(COM_truncate($commenttext, 40,
                                                        '...'));
                if (strlen($commenttext) > 40) {
                    $retval = '<span title="' . $excerpt . '">' . $retval
                            . '</span>';
                }
            } else {
                $retval = COM_createLink($info[0], $info[1],
                                         array('title' => $excerpt));
            }
        } else {
            $retval = COM_makeClickableLinks(stripslashes($fieldvalue));
        }
        break;
    }

    return $retval;
}

/**
 * used for the list of ping services in admin/trackback.php
 *
 */
function ADMIN_getListField_trackback($fieldname, $fieldvalue, $A, $icon_arr, $token)
{
    global $_CONF, $LANG_TRB;

    $retval = '';

    switch($fieldname) {
    case 'edit':
        $retval = COM_createLink($icon_arr['edit'],
            "{$_CONF['site_admin_url']}/trackback.php?mode=editservice&amp;service_id={$A['pid']}");
        break;

    case 'name':
        $retval = COM_createLink($A['name'], $A['site_url']);
        break;

    case 'method':
        if ($A['method'] == 'weblogUpdates.ping') {
            $retval = $LANG_TRB['ping_standard'];
        } else if ($A['method'] == 'weblogUpdates.extendedPing') {
            $retval = $LANG_TRB['ping_extended'];
        } else {
            $retval = '<span class="warningsmall">' . $LANG_TRB['ping_unknown']
                    .  '</span>';
        }
        break;

    case 'is_enabled':
        if ($A['is_enabled'] == 1) {
            $switch = ' checked="checked"';
        } else {
            $switch = '';
        }
        $retval = '<input type="checkbox" name="enabledservices[]" '
                        . 'onclick="submit()" value="' . $A['pid'] . '"'
                        . $switch . XHTML . '>'
                  . '<input type="hidden" name="visibleservices[]" value="'
                            . $A['pid'] . '"' . XHTML . '>';
        break;

    default:
        $retval = $fieldvalue;
        break;
    }

    return $retval;
}

/**
 * used in the user editor in admin/user.php
 *
 */
function ADMIN_getListField_usergroups($fieldname, $fieldvalue, $A, $icon_arr, $selected = '')
{
    global $thisUsersGroups;

    $retval = false;

    if(! is_array($thisUsersGroups)) {
        $thisUsersGroups = SEC_getUserGroups();
    }

    if (in_array($A['grp_id'], $thisUsersGroups ) ||
          SEC_groupIsRemoteUserAndHaveAccess($A['grp_id'], $thisUsersGroups)) {
        switch($fieldname) {
        case 'checkbox':
            $checked = '';
            if (is_array($selected) && in_array($A['grp_id'], $selected)) {
                $checked = ' checked="checked"';
            }
            if (($A['grp_name'] == 'All Users') ||
                ($A['grp_name'] == 'Logged-in Users') ||
                ($A['grp_name'] == 'Remote Users')) {
                $retval = '<input type="checkbox" disabled="disabled"'
                        . $checked . XHTML . '>';
                if (! empty($checked)) {
                    $retval .= '<input type="hidden" name="groups[]" value="'
                            . $A['grp_id'] . '"' . $checked . XHTML . '>';
                }
            } else {
                $retval = '<input type="checkbox" name="groups[]" value="'
                        . $A['grp_id'] . '"' . $checked . XHTML . '>';
            }
            break;

        case 'grp_name':
            $retval = ucwords($fieldvalue);
            break;

        default:
            $retval = $fieldvalue;
            break;
        }
    }

    return $retval;
}

/**
 * used to display the entries for the list of uninstalled plugins, in admin/plugins.php
 *
 */
function ADMIN_getListField_newplugins($fieldname, $fieldvalue, $A, $icon_arr, $selected = '')
{
    global $_CONF, $LANG32;

    $retval = false;
    switch($fieldname) {
    case 'info_uninstalled':
        $retval  = COM_createLink($icon_arr['info'],
            "{$_CONF['site_admin_url']}/plugins.php?mode=info_uninstalled&amp;pi_name={$A['pi_name']}",
            array('title' => $LANG32[13]));
        break;

    case 'pi_version':
        $params = PLG_getParams($A['pi_name']);
        $retval = $params['info']['pi_version'];
        break;

    case 'pi_dependencies':
        if (PLG_checkDependencies($A['pi_name'])) {
            $retval = COM_getTooltip($LANG32[51], PLG_printDependencies($A['pi_name'], $A['pi_gl_version']));
        } else {
            $style = "display: inline; color: #a00; border-bottom: 1px dotted #a00;";
            $retval = COM_getTooltip("<b class='notbold' style='$style'>{$LANG32[52]}</b>", PLG_printDependencies($A['pi_name'], $A['pi_gl_version']));
        }
        break;

    case 'install_link':
        if (PLG_checkDependencies($A['pi_name'])) {
            $retval = COM_createLink($icon_arr['install'], $A['install_link'],
            array('title' => $LANG32[62]));
        } else {
            $retval = str_replace('<img ', '<img title="' . $LANG32[63] . '" ', $icon_arr['unavailable']);
        }
        break;

    default:
        $retval = $fieldvalue;
        break;
    }
    return $retval;
}

?>
