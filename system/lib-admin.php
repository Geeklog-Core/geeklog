<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
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
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

/**
 * Default number of list entries per page
 */
if (!defined('DEFAULT_ENTRIES_PER_PAGE')) {
    define('DEFAULT_ENTRIES_PER_PAGE', 50);
}

/**
 * Common function used in Admin scripts to display a list of items
 *
 * @param    string $fieldFunction Name of a function used to display the list item row details
 * @param    array  $header_arr    array of header fields with sortables and table fields
 * @param    array  $text_arr      array with different text strings
 * @param    array  $data_arr      array with sql query data - array of list records
 * @param    array  $options       array of options - initially just used for the Check-All feature
 * @param    array  $form_arr      optional extra forms at top or bottom
 * @return   string                  HTML output of function
 */
function ADMIN_simpleList($fieldFunction, $header_arr, $text_arr,
                          $data_arr, $options = array(), $form_arr = array())
{
    global $_CONF, $LANG01, $LANG_ADMIN, $_IMAGE_TYPE;

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

    $admin_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/lists'));
    $admin_templates->set_file(
        array(
            'list'   => 'list.thtml',
            'header' => 'header.thtml',
            'row'    => 'listitem.thtml',
            'field'  => 'field.thtml',
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
	$icons_type_arr = array('edit', 'copy', 'list', 'addchild', 'install', 'deleteitem', 'enabled', 'disabled', 'unavailable', 'warning', 'info');	
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
    if (count($data_arr) > $min_data && is_array($options) && isset($options['chkdelete']) && $options['chkdelete']) {
        $header_text = COM_createControl('type-checkbox', array(
            'name' => 'chk_selectall',
            'title' => $LANG01[126],
            'onclick' => 'caItems(this.form);'
        ));
        $admin_templates->set_var('header_text', $header_text);
        $admin_templates->set_var('class', "admin-list-field");
        $admin_templates->set_var('show_deleteimage', true);
        $admin_templates->parse('header_row', 'header', true);
        $admin_templates->clear_var('on_click');
    } else {
        $admin_templates->clear_var('show_deleteimage');
    }

    # HEADER FIELDS array(text, field, sort)
    for ($i = 0; $i < count($header_arr); $i++) {
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
    } elseif ($data_arr === false) {
        $admin_templates->set_var('message', $LANG_ADMIN['data_error']);
    } else {
        $admin_templates->set_var('show_message', 'display:none;');
        $useFieldFunction = is_callable($fieldFunction);

        for ($i = 0; $i < count($data_arr); $i++) {
            if (count($data_arr) > $min_data && is_array($options) && isset($options['chkdelete']) && $options['chkdelete']) {
                $itemtext = COM_createControl('type-checkbox', array(
                    'name' => 'delitem[]',
                    'value' => $data_arr[$i][$options['chkfield']]
                ));
                $admin_templates->set_var('itemtext', $itemtext);
                $admin_templates->set_var('class', "admin-list-field");
                $admin_templates->parse('item_field', 'field', true);
            }
            for ($j = 0; $j < count($header_arr); $j++) {
                $fieldName = $header_arr[$j]['field'];
                if (isset($data_arr[$i][$fieldName]) &&
                    !empty($data_arr[$i][$fieldName])
                ) {
                    $fieldValue = strval($data_arr[$i][$fieldName]);
                } else {
                    $fieldValue = '';
                }
                if ($useFieldFunction) {
                    $fieldValue = call_user_func($fieldFunction, $fieldName, $fieldValue, $data_arr[$i], $icon_arr);
                }
                if (!empty($header_arr[$j]['field_class'])) {
                    $admin_templates->set_var('class', $header_arr[$j]['field_class']);
                } else {
                    $admin_templates->set_var('class', "admin-list-field");
                }
                if ($fieldValue !== false) {
                    $admin_templates->set_var('itemtext', $fieldValue);
                    $admin_templates->parse('item_field', 'field', true);
                }
            }
            $admin_templates->set_var('cssid', ($i % 2) + 1);
            $admin_templates->parse('item_row', 'row', true);
            $admin_templates->clear_var('item_field');
        }
    }

    $admin_templates->parse('output', 'list');

    if (!empty($title)) {
        $retval .= COM_startBlock(
            $title, $help_url,
            COM_getBlockTemplate('_admin_block', 'header')
        );
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
 * @param    string $component      name of the list
 * @param    string $fieldFunction  name of the function that handles special entries
 * @param    array  $header_arr     array of header fields with sortables and table fields
 * @param    array  $text_arr       array with different text strings
 * @param    array  $query_arr      array with sql-options
 * @param    array  $defSort_arr    default sorting values
 * @param    string $filter         additional drop-down filters
 * @param    string $extra          additional values passed to fieldfunction
 * @param    array  $options        array of options - initially just used for the Check-All feature
 * @param    array  $form_arr       optional extra forms at top or bottom
 * @param    bool   $showSearch     whether to show the search functionality
 * @param    string $pageNavUrl     additional url values that page navigation and sorting by columns may need for any
 *                                  additional filters
 * @return   string                  HTML output of function
 */
function ADMIN_list($component, $fieldFunction, $header_arr, $text_arr,
                    $query_arr, $defSort_arr, $filter = '', $extra = '',
                    $options = array(), $form_arr = array(), $showSearch = true, $pageNavUrl = '')
{
    global $_CONF, $LANG_ADMIN, $LANG01, $_IMAGE_TYPE;

    // set all variables to avoid warnings
    $retval = '';
    $filter_str = '';
    $order_sql = '';
    $group_by_sql = '';
    $limit = '';
    $prevOrder = Geeklog\Input::fGet('prevorder', '');  // what was the last sorting?
    $prevOrder = preg_replace('/[^0-9A-Za-z_]/', '', $prevOrder);
    $query = Geeklog\Input::request('q', '');           // get query (text-search)
    if (!empty($query)) {
        $query = GLText::stripTags($query);
    }

    $query_limit = '';
    if (isset($_REQUEST['query_limit'])) { // get query-limit (list-length)
        $query_limit = (int) Geeklog\Input::fRequest('query_limit', 0);
        if ($query_limit <= 0) {
            $query_limit = DEFAULT_ENTRIES_PER_PAGE;
        }
    }

    // we assume that the current page is 1 to set it.
    $currentPage = 1;
    $page = '';
    // get the current page from the interface. The variable is linked to the
    // component, i.e. the plugin/function calling this here to avoid overlap
    if (isset($_REQUEST[$component . 'listpage'])) {
        $page = (int) Geeklog\Input::fRequest($component . 'listpage');
        $currentPage = $page;
    }
    if ($currentPage <= 0) {
        $currentPage = 1; // current page has to be larger 0
    }

    $help_url = ''; // do we have a help url for the block-header?
    if (!empty($text_arr['help_url'])) {
        $help_url = $text_arr['help_url'];
    }

    $form_url = ''; // what is the form-url for the search button and list sorters?
    if (!empty($text_arr['form_url'])) {
        $form_url = $text_arr['form_url'];
    }

    $title = '';    // what is the title of the page?
    if (!empty($text_arr['title'])) {
        $title = $text_arr['title'];
    }

    $inline_form = false;
    if (isset($text_arr['inline'])) {
        $inline_form = $text_arr['inline'];
    }

    # get all template fields.
    $admin_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/lists'));
    $template_files = array(
        'list'   => ($inline_form ? 'inline.thtml' : 'list.thtml'),
        'header' => 'header.thtml',
        'row'    => 'listitem.thtml',
        'field'  => 'field.thtml',
    );
    if ($showSearch) {
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
    if (is_array($options) && isset($options['chkdelete']) && $options['chkdelete']) {
        $header_text = COM_createControl('type-checkbox', array(
            'name' => 'chk_selectall',
            'title' => $LANG01[126],
            'onclick' => 'caItems(this.form);'
        ));
        $admin_templates->set_var('header_text', $header_text);
        $admin_templates->set_var('class', "admin-list-field");
        $admin_templates->set_var('show_deleteimage', true);
        $admin_templates->parse('header_row', 'header', true);
        $admin_templates->clear_var('on_click');
    } else {
        $admin_templates->clear_var('show_deleteimage');
    }

    // define icon paths. Those will be transmitted to $fieldFunction.
	$icons_type_arr = array('edit', 'copy', 'list', 'addchild', 'install', 'deleteitem', 'enabled', 'disabled', 'unavailable', 'warning', 'info');	
    $icon_arr = array();
    foreach ($icons_type_arr as $icon_type) {
        $icon_url = "{$_CONF['layout_url']}/images/$icon_type.$_IMAGE_TYPE";
        $icon_arr[$icon_type] = COM_createImage($icon_url, $LANG_ADMIN[$icon_type], array('style' => 'vertical-align: middle;'));
    }

    $has_extras = '';
    if (isset($text_arr['has_extras'])) { // does this one use extras? (search, google paging)
        $has_extras = $text_arr['has_extras'];
    }
    if ($has_extras) { // show search
        $admin_templates->set_var('lang_search', $LANG_ADMIN['search']);
        $admin_templates->set_var('lang_submit', $LANG_ADMIN['submit']);
        $admin_templates->set_var('lang_limit_results', $LANG_ADMIN['limit_results']);
        $admin_templates->set_var('last_query', htmlspecialchars($query));
        $admin_templates->set_var('filter', $filter);
    }

    $sql_query = DB_escapeString($query); // replace quotes etc for security
    $sql = $query_arr['sql'];   // get sql from array that builds data

    $order_var = '';            // number that is displayed in URL
    $order_var_link = '';       // Variable for google paging.

    // is the order set in the link (when sorting the list)
    if (!isset($_GET['order'])) {
        $order = $defSort_arr['field']; // no, get the default
    } else {
        $order_var = (int) Geeklog\Input::fGet('order', 0);

        if (isset($header_arr[$order_var])) {
            $order_var_link = "&amp;order=$order_var";  // keep the variable for the google paging
            $order = $header_arr[$order_var]['field'];  // current order field name
        } else {
            $order_var = '';
            $order = $defSort_arr['field']; // no, get the default
        }
    }

    if (isset($header_arr[$order_var]['sort_field'])) {
        // See if specific sort fields are set for the current field
        $order_for_query = $header_arr[$order_var]['sort_field'];
    } else {
        $order_for_query = $order;
    }

    // this code sorts only by the field if its in table.field style.
    // removing this however makes match for arrow-display impossible, so removed it.
    // maybe now for more fields the table has to be added to the sortfield?
    //$order = explode ('.', $order);
    //if (count ($order) > 1) {
    //    $order = $order[1];
    //} else {
    //    $order = $order[0];
    //}

    $direction = Geeklog\Input::fGet('direction', $defSort_arr['direction']);   // get direction to sort after
    $direction = strtoupper($direction);
    if ($order == $prevOrder) { // reverse direction if prev. order was the same
        $direction = ($direction === 'DESC') ? 'ASC' : 'DESC';
    } else {
        $direction = ($direction === 'DESC') ? 'DESC' : 'ASC';
    }

    if ($direction === 'ASC') { // assign proper arrow img name dep. on sort order
        $arrow = 'bararrowdown';
    } else {
        $arrow = 'bararrowup';
    }

    // make actual order arrow image
    $img_arrow_url = "{$_CONF['layout_url']}/images/$arrow.$_IMAGE_TYPE";
    $img_arrow = '&nbsp;' . COM_createImage($img_arrow_url, $arrow);

    if (!empty($order_for_query)) { # concat order string
        $order_sql = "ORDER BY $order_for_query $direction";
    }

    $th_subtags = ''; // other tags in the th, such as onclick and mouseover
    $header_text = ''; // title as displayed to the user
    // HEADER FIELDS array(text, field, sort, class)
    // this part defines the contents & format of the header fields

    for ($i = 0; $i < count($header_arr); $i++) {     // iterate through all headers
        $header_text = $header_arr[$i]['text'];
        $th_subtags = '';
        if ($header_arr[$i]['sort'] != false) {       // is this sortable?
            if ($order == $header_arr[$i]['field']) { // is this currently sorted?
                $header_text .= $img_arrow;
            }

            // make the mouseover effect is sortable
            $th_subtags = " onmouseover=\"this.style.cursor='pointer';\"";
            $order_var = $i; // assign number to field so we know what to sort
            if (strpos($form_url, '?') > 0) {
                $separator = '&amp;';
            } else {
                $separator = '?';
            }
            $th_subtags .= " onclick=\"window.location.href='$form_url$separator" // onclick action
                . "order=$order_var&amp;prevorder=$order&amp;direction=$direction";
            if (!empty($page)) {
                $th_subtags .= '&amp;' . $component . 'listpage=' . $page;
            }
            if (!empty($query)) {
                $th_subtags .= '&amp;q=' . urlencode($query);
            }
            if (!empty($query_limit)) {
                $th_subtags .= '&amp;query_limit=' . $query_limit;
            }
            if (!empty($pageNavUrl)) { // used for any additional filters
                $th_subtags .= $pageNavUrl;
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


    if (!empty($query_arr['query_group'])) { # add group by to sql
        $group_by_sql = " GROUP BY {$query_arr['query_group']}";
    }

    if ($has_extras && $showSearch) {
        /**
         * default query limit if no other chosen.
         *
         * @todo maybe this could be a setting from the list?
         */
        $limit = DEFAULT_ENTRIES_PER_PAGE;
        if (!empty($query_limit)) {
            $limit = $query_limit;
        }
        if ($query != '') { # set query into form after search
            $admin_templates->set_var('query', urlencode($query));
        } else {
            $admin_templates->set_var('query', '');
        }
        $admin_templates->set_var('query_limit', $query_limit);
        // choose proper dropdown field for query limit
        $admin_templates->set_var($limit . '_selected', 'selected="selected"');

        if (!empty($query_arr['default_filter'])) { # add default filter to sql
            $filter_str = " {$query_arr['default_filter']}";
        }
        if (!empty($query)) { # add query fields with search term
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
        $num_pages_sql = $sql . $filter_str . $group_by_sql;
        $num_pages_result = DB_query($num_pages_sql);
        $num_rows = DB_numRows($num_pages_result);
        $num_pages = ceil($num_rows / $limit);
        if ($num_pages < $currentPage) { # make sure we dont go beyond possible results
            $currentPage = 1;
        }
        $offset = (($currentPage - 1) * $limit);
        $limit = "LIMIT $offset,$limit"; # get only current page data
        $admin_templates->set_var('lang_records_found',
            $LANG_ADMIN['records_found']);
        $admin_templates->set_var('records_found',
            COM_numberFormat($num_rows));
        $admin_templates->parse('search_menu', 'search', true);
    }

    if (is_callable($fieldFunction)) {
        if (!empty($extra)) {
            $useFieldFunction = 2;
        } else {
            $useFieldFunction = 1;
        }
    } else {
        $useFieldFunction = 0;
    }

    // SQL
    $sql .= "$filter_str $group_by_sql $order_sql $limit;";
    $result = DB_query($sql);
    $numRows = DB_numRows($result);
    $r = 1; // r is the counter for the actual displayed rows for correct coloring
    for ($i = 0; $i < $numRows; $i++) { # now go through actual data
        $A = DB_fetchArray($result);
        $this_row = false; # as long as no fields are returned, dont print row
        if (is_array($options) && isset($options['chkdelete']) && $options['chkdelete']) {
            $itemtext = COM_createControl('type-checkbox', array(
                'name' => 'delitem[]',
                'value' => $A[$options['chkfield']]
            ));
            $admin_templates->set_var('itemtext', $itemtext);
            $admin_templates->set_var('class', "admin-list-field");
            $admin_templates->parse('item_field', 'field', true);
        }
        for ($j = 0; $j < count($header_arr); $j++) {
            $fieldName = $header_arr[$j]['field']; # get field name from headers
            if (isset($A[$fieldName])) {
                $fieldValue = strval($A[$fieldName]); # yes, get its data
            } else {
                $fieldValue = '';
            }

            switch ($useFieldFunction) {
                case 2:
                    $fieldValue = call_user_func($fieldFunction, $fieldName, $fieldValue, $A, $icon_arr, $extra);
                    break;

                case 1:
                    $fieldValue = call_user_func($fieldFunction, $fieldName, $fieldValue, $A, $icon_arr);
                    break;

                default:
                    break;
            }

            if ($fieldValue !== false) { # return was there, so write line
                $this_row = true;
            } else {
                $fieldValue = ''; // don't give empty fields
            }
            if (!empty($header_arr[$j]['field_class'])) {
                $admin_templates->set_var('class', $header_arr[$j]['field_class']);
            } else {
                $admin_templates->set_var('class', "admin-list-field");
            }
            $admin_templates->set_var('itemtext', $fieldValue); # write field
            $admin_templates->parse('item_field', 'field', true);
        }
        if ($this_row) { # there was data in at least one field, so print line
            $r++; # switch to next color
            $admin_templates->set_var('cssid', ($r % 2) + 1); # make alternating table color
            $admin_templates->parse('item_row', 'row', true); # process the complete row
        }
        $admin_templates->clear_var('item_field'); # clear field
    }

    if ($numRows == 0) { # there is no data. return notification message.
        if (isset($text_arr['no_data'])) {
            $message = $text_arr['no_data']; # there is a user-message
        } else {
            $message = $LANG_ADMIN['no_results']; # take std.
        }
        $admin_templates->set_var('message', $message);
    }

    if ($has_extras && $showSearch) {
        $hasArgs = strstr($form_url, '?');
        if ($hasArgs) {
            $sep = '&amp;';
        } else {
            $sep = '?';
        }
        if (!empty($query)) { # port query to next page
            $base_url = $form_url . $sep . 'q=' . urlencode($query)
                . "&amp;query_limit=$query_limit$order_var_link&amp;direction=$direction$pageNavUrl";
        } else {
            $base_url = $form_url . $sep . "query_limit=$query_limit$order_var_link&amp;direction=$direction$pageNavUrl";
        }

        if ($num_pages > 1) { # print actual google-paging
            $admin_templates->set_var('google_paging', COM_printPageNavigation($base_url, $currentPage, $num_pages, $component . 'listpage='));
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
 * @param    array  $menu_arr array of text & URL of the menu entries
 * @param    string $text     instructions to be displayed
 * @param    string $icon     url of an icon that will be displayed
 * @return   string           HTML output of function
 */
function ADMIN_createMenu($menu_arr, $text, $icon = '')
{
    global $_CONF;

    $admin_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/lists'));
    $admin_templates->set_file(
        array('top_menu' => 'topmenu.thtml')
    );

    $menu_fields = '';
    $attr = array('class' => 'admin-menu-item');
    for ($i = 0; $i < count($menu_arr); $i++) { # iterate through menu
        $menu_fields .= COM_createLink($menu_arr[$i]['text'], $menu_arr[$i]['url'], $attr);
        if ($i < (count($menu_arr) - 1)) {
            $menu_fields .= ' | '; # add separator
        }
    }
    if (!empty($icon)) {
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
 */

/**
 * used for the list of groups and in the group editor in admin/group.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @param  string $selected
 * @return string
 */
function ADMIN_getListField_groups($fieldName, $fieldValue, $A, $icon_arr, $selected = '')
{
    global $_CONF, $LANG_ACCESS, $thisUsersGroups, $_GROUP_MAINGROUPS, $_GROUP_LOOPGROUPS;

    $retval = false;

    if (!is_array($thisUsersGroups)) {
        $thisUsersGroups = SEC_getUserGroups();
    }

    $show_all_groups = false;
    if (Geeklog\Input::request('chk_showall') == 1) {
        $show_all_groups = true;
    }

    if (in_array($A['grp_id'], $thisUsersGroups) ||
        SEC_groupIsRemoteUserAndHaveAccess($A['grp_id'], $thisUsersGroups)
    ) {
        switch ($fieldName) {
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
                    ($A['grp_name'] != 'Logged-in Users')
                ) {
                    $retval .= '&nbsp;&nbsp;' . COM_createLink($icon_arr['edit'],
                            $url . 'editusers' . $param);
                }
                break;

            case 'checkbox':
                $vars = array(
                    'name' => 'groups[]',
                    'value' => $A['grp_id']);
                if (is_array($selected) && in_array($A['grp_id'], $selected)) {
                    $vars = array_merge($vars, array('checked' => true));
                } elseif (in_array($A['grp_id'], $_GROUP_MAINGROUPS)) { // If inherited then disable and check
                    $vars = array_merge($vars, array(
                        'checked' => true, 'disabled' => true));
                } elseif (in_array($A['grp_id'], $_GROUP_LOOPGROUPS)) { // If loops back to itself then disable but do not check
                    $vars = array_merge($vars, array(
                        'checked' => false, 'disabled' => true));
                }
                $retval = COM_createControl('type-checkbox', $vars);
                break;

            case 'disabled-checkbox':
                $retval = COM_createControl('type-checkbox', array(
                    'checked' => true, 'disabled' => true));
                $retval .= '<input type="hidden" name="groups[]" value="' . $A['grp_id'] . '"' . XHTML . '>';
                break;

            case 'grp_name':
                $retval = ucwords($fieldValue);
                break;

            default:
                $retval = $fieldValue;
                break;
        }
    }

    return $retval;
}

/**
 * used for the list of users in admin/user.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @return string
 */
function ADMIN_getListField_users($fieldName, $fieldValue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG28, $_IMAGE_TYPE;

    switch ($fieldName) {
        case 'delete':
            $retval = COM_createControl('type-checkbox', array(
                'name' => 'delitem[]',
                'checked' => true));
            break;

        case 'edit':
            $retval = COM_createLink($icon_arr['edit'],
                "{$_CONF['site_admin_url']}/user.php?mode=edit&amp;uid={$A['uid']}");
            break;

        case 'username':
            if (!empty($A['photo'])) {
                $photoIcon = "&nbsp;<img src=\"{$_CONF['layout_url']}/images/smallcamera."
                    . $_IMAGE_TYPE . '" alt="{$LANG04[77]}"' . XHTML . '>';
            } else {
                $photoIcon = '';
            }
            $retval = COM_createLink($fieldValue, $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $A['uid']) . $photoIcon;
            break;

        case 'lastlogin':
            if ($fieldValue < 1) {
                // if the user never logged in, show the registration date
                $regdate = strftime($_CONF['shortdate'], strtotime($A['regdate']));
                $retval = "({$LANG28[36]}, {$LANG28[53]} $regdate)";
            } else {
                $retval = strftime($_CONF['shortdate'], $fieldValue);
            }
            break;

        case 'contributed':
            // Has user ever logged in?
            if ($A['lastlogin_short'] < 1) {
                $retval = $LANG28['na'];
            } else {
                $retval = '';
                $content_contributed = PLG_userContributed($A['uid']);
                if (is_array($content_contributed) && (count($content_contributed) > 0)) {
                    foreach ($content_contributed as $pluginname) {
                        if (!empty($retval)) {
                            $retval .= ", ";
                        }
                        $retval .= $pluginname;
                    }
                }

                if (empty($retval)) {
                    $retval = $LANG28['nothing'];
                } else {
                    // Add in search link
                    $url = "/search.php?type=all&amp;author={$A['uid']}&amp;mode=search";
                    $retval = COM_createLink($retval, $url);
                }
            }

            break;

        case 'lastlogin_short':
            if ($fieldValue < 1) {
                // if the user never logged in, show the registration date
                $regdate = strftime($_CONF['shortdate'], strtotime($A['regdate']));
                $retval = "({$LANG28[36]})";
            } else {
                $retval = strftime($_CONF['shortdate'], $fieldValue);
            }
            break;

        case 'online_days':
            if ($fieldValue < 0) {
                // users that never logged in, would have a negative online days
                $retval = $LANG_ADMIN['na'];
            } else {
                $retval = $fieldValue;
            }
            break;

        case 'phantom_date':
        case 'offline_months':
            $retval = COM_numberFormat(round($fieldValue / 2592000));
            break;

        case 'online_hours':
            $retval = COM_numberFormat(round($fieldValue / 3600, 3));
            break;

        case 'regdate':
            $retval = strftime($_CONF['shortdate'], strtotime($fieldValue));
            break;

        case $_TABLES['users'] . '.uid':
            $retval = $A['uid'];
            break;

        default:
            $retval = $fieldValue;
            break;
    }

    if (isset($A['status']) && ($A['status'] == USER_ACCOUNT_DISABLED)) {
        if (($fieldName != 'edit') && ($fieldName != 'username')) {
            $retval = COM_createControl('display-text-strikethrough', array('text' =>  $retval, 'title' =>  $LANG28[42]));
        }
    }

    return $retval;
}

/**
 * used for the list of stories in admin/article.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @return string
 */
function ADMIN_getListField_stories($fieldName, $fieldValue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG24, $LANG_ACCESS, $_IMAGE_TYPE;

    static $topics;

    if (!isset($topics)) {
        $topics = array();
    }

    $retval = '';

    switch ($fieldName) {
        case 'unixdate':
            $currentTime = COM_getUserDateTimeFormat($A['unixdate']);
            $retval = strftime($_CONF['daytime'], $currentTime[1]);
            break;

        case 'title':
            $A['title'] = str_replace('$', '&#36;', $A['title']);
            $article_url = COM_buildURL($_CONF['site_url'] . '/article.php?story=' . $A['sid']);
            $attr = array();
            if (!empty($A['page_title'])) {
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
            if ($fieldName === 'access') {
                $retval = $access;
            } elseif ($access === $LANG_ACCESS['edit']) {
                if ($fieldName == 'edit_adv') {
                    $editMode = 'adv';
                } elseif ($fieldName === 'edit') {
                    $editMode = 'std';
                }
                if ($fieldName === 'copy') {
                    $copyUrl = $_CONF['site_admin_url']
                        . '/article.php?mode=clone&amp;sid=' . $A['sid'];
                    $retval = COM_createLink($icon_arr['copy'], $copyUrl);
                } else {
                    $editUrl = $_CONF['site_admin_url']
                        . '/article.php?mode=edit&amp;editor=' . $editMode
                        . '&amp;sid=' . $A['sid'];
                    $retval = COM_createLink($icon_arr['edit'], $editUrl);
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
                $current_access = DB_getItem($_TABLES['topics'], 'perm_anon', "tid = '" . DB_escapeString($tid) . "'");
                if ($topic_anon < $current_access) {
                    $topic_anon = $current_access;
                }
            }

            if (($A['draft_flag'] == 0) && ($A['unixdate'] < time()) &&
                ($A['perm_anon'] != 0) && ($topic_anon != 0)
            ) {
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

        case 'tid':
            $retval = TOPIC_getTopicAdminColumn('article', $A['sid']);
            break;

        case 'username':
        case 'fullname':
            $retval = COM_getDisplayName($A['uid'], $A['username'], $A['fullname']);
            break;

        default:
            $retval = $fieldValue;
            break;
    }

    return $retval;
}

/**
 * used for the list of feeds in admin/syndication.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @param  string $token
 * @return string
 */
function ADMIN_getListField_syndication($fieldName, $fieldValue, $A, $icon_arr, $token)
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG33;

    switch ($fieldName) {
        case 'edit':
            $retval = COM_createLink($icon_arr['edit'],
                "{$_CONF['site_admin_url']}/syndication.php?mode=edit&amp;fid={$A['fid']}");
            break;

        case 'type':
            if ($A['type'] === 'article') {
                $retval = $LANG33[55];
            } else {
                $retval = ucwords($A['type']);
            }
            break;

        case 'format':
            $retval = str_replace('-', ' ', ucwords($A['format']));
            break;

        case 'updated':
            if ($A['is_enabled'] == 1) {
                list($retval,) = COM_getUserDateTimeFormat($A['date'], 'daytime');
            } else {
                $retval = $LANG_ADMIN['na'];
            }
            break;

        case 'is_enabled':
            $retval = COM_createControl('type-checkbox', array(
                'name' => 'enabledfeeds[]',
                'value' => $A['fid'],
                'onclick' => 'submit()',
                'checked' => ($A['is_enabled'] == 1) ? true : ''
            ));
            $retval .= '<input type="hidden" name="visiblefeeds[]" value="' . $A['fid'] . '"' . XHTML . '>';
            break;

        case 'header_tid':
            if ($A['header_tid'] === 'all') {
                $retval = $LANG33[43];
            } elseif ($A['header_tid'] === 'none') {
                $retval = $LANG33[44];
            } else {
                $retval = DB_getItem($_TABLES['topics'], 'topic',
                    "tid = '{$A['header_tid']}'");
            }
            break;

        case 'filename':
            $url = SYND_getFeedUrl($A['filename']);
            $retval = COM_createLink(basename($A['filename']), $url);
            break;

        default:
            $retval = $fieldValue;
            break;
    }

    return $retval;
}

/**
 * used for the list of plugins in admin/plugins.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @param  string $token
 * @return string
 */
function ADMIN_getListField_plugins($fieldName, $fieldValue, $A, $icon_arr, $token)
{
    global $_CONF, $LANG_ADMIN, $LANG32;

    $retval = '';

    switch ($fieldName) {
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
                ($pi_installed_version == $code_version)
            ) {
                $retval = $pi_installed_version;
            } else {
                $retval = "{$LANG32[37]}: $pi_installed_version,&nbsp;{$LANG32[36]}: $plugin_code_version";
                if ($A['pi_enabled'] == 1) {
                    $retval .= " <b>{$LANG32[38]}</b>";
                    $csrfToken = '&amp;' . CSRF_TOKEN . '=' . $token;
                    $style = 'style="vertical-align: middle;"';
                    $img = $_CONF['layout_url'] . '/images/update.png';
                    $img = "<img $style alt=\"[" . $LANG32[38] . "]\" src=\"$img\"" . XHTML . ">";
                    $url = $_CONF['site_admin_url'] . '/plugins.php?mode=updatethisplugin&amp;pi_name=' . $A['pi_name'] . $csrfToken;
                    $retval .= COM_createLink($img, $url, array('title' => $LANG32[42]));
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
            $csrfToken = '&amp;' . CSRF_TOKEN . '=' . $token;
            $style = "style='vertical-align: middle;'";
            $upimg = $_CONF['layout_url'] . '/images/admin/up.png';
            $dnimg = $_CONF['layout_url'] . '/images/admin/down.png';
            $url = $_CONF['site_admin_url'] . '/plugins.php?mode=change_load_order&amp;pi_name=' . $A['pi_name'] . $csrfToken . '&amp;where=';
            $retval .= COM_createLink("<img $style alt='+' src='$upimg'" . XHTML . ">", $url . 'up', array('title' => $LANG32[44]));
            $retval .= '&nbsp;' . $A['pi_load'] . '&nbsp;';
            $retval .= COM_createLink("<img $style alt='-' src='$dnimg'" . XHTML . ">", $url . 'dn', array('title' => $LANG32[45]));
            break;

        case 'pi_enabled':
            if (!PLG_checkDependencies($A['pi_name'])) {
                $retval = str_replace('<img ', '<img title="' . $LANG32[64] . '" ', $icon_arr['warning']);
            } else {
                $not_present = false;
                if ($A['pi_enabled'] == 1) {
                    $switch = 'enabled';
                    $title = $LANG32[49];
                } else {
                    $switch = 'disabled';
                    $title = $LANG32[48];
                    if (!file_exists($_CONF['path'] . 'plugins/' . $A['pi_name'] . '/functions.inc')) {
                        $not_present = true;
                    }
                }
                if ($not_present) {
                    $retval = str_replace('<img ', '<img title="' . $LANG32[64] . '" ', $icon_arr['unavailable']);
                } else {
                    $sorting = '';
                    $csrfToken2 = '&amp;' . CSRF_TOKEN . '=' . $token;
                    if (!empty($_GET['order']) && !empty($_GET['direction'])) { // Remember how the list was sorted
                        $ord = trim(Geeklog\Input::fGet('order'));
                        $dir = trim(Geeklog\Input::fGet('direction'));
                        $old = trim(Geeklog\Input::fGet('prevorder'));
                        $ord = COM_escHTML($ord);
                        $dir = COM_escHTML($dir);
                        $old = COM_escHTML($old);
                        $sorting = "&amp;order=$ord&amp;direction=$dir&amp;prevorder=$old";
                    }
                    $retval = COM_createLink($icon_arr[$switch], $_CONF['site_admin_url'] .
                        '/plugins.php?mode=toggle&amp;pi_name=' . $A['pi_name'] . $csrfToken2 . $sorting,
                        array('title' => $title)
                    );
                }
            }
            break;

        case 'delete':
            $csrfToken2 = '&amp;' . CSRF_TOKEN . '=' . $token;
            $id = 'uninstall_' . $A['pi_name']; // used by JavaScript
            $message = sprintf($LANG32[47], "\'" . plugin_get_pluginname($A['pi_name']) . "\'"); // used by JavaScript
            $url = $_CONF['site_admin_url'] . '/plugins.php?mode=delete&amp;pi_name=' . $A['pi_name'] . $csrfToken2;
            $link_args = array('title'   => $LANG32[46],
                               'onclick' => "confirm_action('$message', '$url&amp;confirmed=1')",
                               'id'      => $id);
            $retval .= COM_createLink($icon_arr['deleteitem'], $url, $link_args);
            // If javascript is available, we will be using it to get a confirmation from the user. So we need to hide the default link.
            $retval .= '<script type="text/javascript">document.getElementById("' . $id . '").href = "javascript:void(0);";</script>';
            break;

        default:
            $retval = $fieldValue;
            break;
    }

    return $retval;
}

/**
 * used for the lists of submissions and draft stories in admin/moderation.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @return string
 */
function ADMIN_getListField_moderation($fieldName, $fieldValue, $A, $icon_arr)
{
    global $_CONF, $_TABLES, $LANG_ADMIN;

    $type = '';
    if (isset($A['_moderation_type'])) {
        $type = $A['_moderation_type'];
    }

    switch ($fieldName) {
        case 'edit':
            $retval = COM_createLink($icon_arr['edit'], $A['edit']);
            break;

        case 'delete':
            $retval = COM_createControl('type-radio', array(
                'name' => "action[{$A['row']}]",
                'value' => 'delete'
            ));
            break;

        case 'approve':
            $retval = COM_createControl('type-radio', array(
                'name' => "action[{$A['row']}]",
                'value' => 'approve'
            ));
            $retval .= "<input type=\"hidden\" name=\"id[{$A['row']}]\" value=\"{$A[0]}\"" . XHTML . ">";
            break;

        case 'day':
            $retval = strftime($_CONF['daytime'], $A['day']);
            break;

        case 'tid':
            $retval = DB_getItem($_TABLES['topics'], 'topic', "tid = '{$A['tid']}'");
            break;

        case 'uid':
            $name = '';
            if ($A['uid'] == 1) {
                $name = htmlspecialchars(DB_getItem($_TABLES['commentsubmissions'], 'name', "cid = '{$A['id']}'"));
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
                $retval = COM_createControl('type-checkbox', array(
                    'name' => 'publishfuture[]',
                    'value' => $A['uid']
                ));
            } else {
                $retval = $LANG_ADMIN['na'];
            }
            break;

        default:
            if (($fieldName == 4) && (($type === 'story') || ($type === 'story_draft'))) {
                $retval = TOPIC_getTopicAdminColumn('article', $A[0]);
            } elseif (($fieldName == 2) && ($type === 'comment')) {
                $commentText = COM_getTextContent($A['comment']);
                $commentText = htmlspecialchars_decode($commentText, ENT_QUOTES);
                $excerpt = htmlspecialchars(COM_truncate($commentText, 140, '...'), ENT_QUOTES, COM_getEncodingt());
                // try to provide a link to the parent item (e.g. article, poll)
                $info = PLG_getItemInfo($A['type'], $A['sid'], 'title,url');
                if (empty($info) || empty($info[0]) || empty($info[1])) {
                    // if not available, display excerpt from the comment
                    $retval = htmlspecialchars(COM_truncate($commentText, 40, '...'), ENT_QUOTES, COM_getEncodingt());
                    if (strlen($commentText) > 40) {
                        $retval = '<span title="' . $excerpt . '">' . $retval . '</span>';
                    }
                } else {
                    $retval = COM_createLink($info[0], $info[1], array('title' => $excerpt));
                }
            } else {
                $retval = COM_makeClickableLinks(stripslashes($fieldValue));
            }
            break;
    }

    return $retval;
}

/**
 * used for the list of ping services in admin/trackback.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @param  string $token
 * @return string
 */
function ADMIN_getListField_trackback($fieldName, $fieldValue, $A, $icon_arr, $token)
{
    global $_CONF, $LANG_TRB;

    $retval = '';

    switch ($fieldName) {
        case 'edit':
            $retval = COM_createLink($icon_arr['edit'],
                "{$_CONF['site_admin_url']}/trackback.php?mode=editservice&amp;service_id={$A['pid']}");
            break;

        case 'name':
            $retval = COM_createLink($A['name'], $A['site_url']);
            break;

        case 'method':
            if ($A['method'] === 'weblogUpdates.ping') {
                $retval = $LANG_TRB['ping_standard'];
            } elseif ($A['method'] === 'weblogUpdates.extendedPing') {
                $retval = $LANG_TRB['ping_extended'];
            } else {
                $retval = COM_createControl('display-text-warning', array('text' => $LANG_TRB['ping_unknown']));
            }
            break;

        case 'is_enabled':
            $retval = COM_createControl('type-checkbox', array(
                'name' => 'enabledservices[]',
                'value' => $A['pid'],
                'onclick' => 'submit()',
                'checked' => ($A['is_enabled'] == 1) ? true : ''
            ));
            $retval .= '<input type="hidden" name="visibleservices[]" value="' . $A['pid'] . '"' . XHTML . '>';
            break;

        default:
            $retval = $fieldValue;
            break;
    }

    return $retval;
}

/**
 * used in the user editor in admin/user.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @param  string $selected
 * @return string
 */
function ADMIN_getListField_usergroups($fieldname, $fieldvalue, $A, $icon_arr, $selected = '')
{
    global $thisUsersGroups, $_USER_MAINGROUPS, $_CONF;

    $retval = false;

    if(!is_array($thisUsersGroups)) {
        $thisUsersGroups = SEC_getUserGroups();
    }

    if (in_array($A['grp_id'], $thisUsersGroups ) ||
          SEC_groupIsRemoteUserAndHaveAccess($A['grp_id'], $thisUsersGroups)) {
        switch($fieldname) {
        case 'checkbox':
            $checked = '';
            $varChecked = '';
            if (is_array($selected) && in_array($A['grp_id'], $selected)) {
                $checked = ' checked="checked"';
                $varChecked = true;
            }
            if (($A['grp_name'] == 'All Users') ||
                ($A['grp_name'] == 'Logged-in Users') ||
                ($A['grp_name'] == 'Remote Users')) {
                $retval = COM_createControl('type-checkbox', array(
                    'checked' => $varChecked,
                    'disabled' => true
                ));
                if (!empty($checked)) {
                    $retval .= '<input type="hidden" name="groups[]" value="' . $A['grp_id'] . '"' . $checked . XHTML . '>';
                }
            } elseif (!empty($checked) && (! in_array($A['grp_id'], $_USER_MAINGROUPS ))) {
                $retval = COM_createControl('type-checkbox', array(
                    'checked' => $varChecked,
                    'disabled' => true
                ));
            } else {
                $retval = COM_createControl('type-checkbox', array(
                    'name' => 'groups[]',
                    'value' => $A['grp_id'],
                    'checked' => $varChecked,
                ));
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
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @param  string $selected
 * @return string
 */
function ADMIN_getListField_newplugins($fieldName, $fieldValue, $A, $icon_arr, $selected = '')
{
    global $_CONF, $LANG32;

    switch ($fieldName) {
        case 'info_uninstalled':
            $retval = COM_createLink($icon_arr['info'],
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
			
        case 'delete_plugin':
            $csrfToken2 = '&amp;' . CSRF_TOKEN . '=' . $A['token'];
            $id = 'delete_' . $A['pi_name']; // used by JavaScript
            $message = sprintf($LANG32['really_delete_msg'], "\'" . plugin_get_pluginname($A['pi_name']) . "\'"); // used by JavaScript
            $url = $_CONF['site_admin_url'] . '/plugins.php?mode=remove&amp;pi_name=' . $A['pi_name'] . $csrfToken2;
            $link_args = array('title'   => $LANG32['click_to_delete_msg'],
                               'onclick' => "confirm_action('$message', '$url&amp;confirmed=1')",
                               'id'      => $id);
            $retval = COM_createLink($icon_arr['deleteitem'], $url, $link_args);
            // If javascript is available, we will be using it to get a confirmation from the user. So we need to hide the default link.
            $retval .= '<script type="text/javascript">document.getElementById("' . $id . '").href = "javascript:void(0);";</script>';
            break;

        default:
            $retval = $fieldValue;
            break;
    }

    return $retval;
}

/**
 * used for the list of topics in admin/topic.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @param  string $token
 * @return string
 */
function ADMIN_getListField_topics($fieldName, $fieldValue, $A, $icon_arr, $token)
{
    global $_CONF, $LANG_ACCESS, $_TABLES, $LANG27;

    $retval = false;

    $access = SEC_hasAccess($A['owner_id'], $A['group_id'],
        $A['perm_owner'], $A['perm_group'],
        $A['perm_members'], $A['perm_anon']
    );

    switch ($fieldName) {
        case 'edit':
            if ($access == 3) {
                $editUrl = $_CONF['site_admin_url'] . '/topic.php?mode=edit&amp;tid=' . $A['tid'];
                $retval = COM_createLink($icon_arr['edit'], $editUrl);
            }
            break;

        case 'sortnum':
            if ($_CONF['sortmethod'] === 'sortnum' && $access == 3) {
                $style = 'style="vertical-align: middle;"';
                $upImage = $_CONF['layout_url'] . '/images/admin/up.png';
                $downImage = $_CONF['layout_url'] . '/images/admin/down.png';
                $url = $_CONF['site_admin_url'] . '/topic.php?mode=change_sortnum'
                    . '&amp;tid=' . $A['tid']
                    . '&amp;' . CSRF_TOKEN . '=' . $token
                    . '&amp;where=';
                $retval .= COM_createLink("<img $style alt=\"+\" src=\"$upImage\"" . XHTML . ">",
                    $url . 'up', array('title' => $LANG27['move_topic_up'])
                );
                $retval .= '&nbsp;' . $fieldValue . '&nbsp;';
                $retval .= COM_createLink("<img $style alt=\"-\" src=\"$downImage\"" . XHTML . ">",
                    $url . 'dn', array('title' => $LANG27['move_topic_down'])
                );
            } else {
                $retval = $fieldValue;
            }
            break;

        case 'image':
            $retval = '';
            if (!empty($A['imageurl'])) {
                $imageUrl = COM_getTopicImageUrl($A['imageurl']);
                $image_tag = '<img src="' . $imageUrl
                    . '" width="24" height="24" id="topic-' . $A['tid']
                    . '" class="admin-topic-image" alt=""' . XHTML . '>';
                $url = TOPIC_getUrl($A['tid']);
                $retval = COM_createLink($image_tag, $url);
            }
            break;

        case 'topic':
            $default = ($A['is_default'] == 1) ? $LANG27[24] : '';

            $level = -1;
            $tid = $A['tid'];
            while ($tid !== TOPIC_ROOT) {
                $tid = DB_getItem($_TABLES['topics'], 'parent_id', "tid = '$tid'");
                $level++;
            }
            $level *= 15;

            $content = '<span style="margin-left:' . $level . 'px">' . $fieldValue . '</span>';
            $url = TOPIC_getUrl($A['tid']);
            $retval = COM_createLink($content, $url) . $default;
            break;

        case 'access':
            $retval = $LANG_ACCESS['readonly'];
            if ($access == 3) {
                $retval = $LANG_ACCESS['edit'];
            }
            break;

        case 'inherit':
        case 'hidden':
            $yes = empty($LANG27[50]) ? 'Yes' : $LANG27[50];
            $no = empty($LANG27[50]) ? 'No' : $LANG27[51];
            $retval = ($fieldValue == 1) ? $yes : $no;
            break;

        case 'story':
            // Retrieve list of inherited topics
            $tid_list = TOPIC_getChildList($A['tid']);

            // Calculate number of stories in topic, includes any inherited ones
            $sql = "SELECT sid FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta "
                . "WHERE (draft_flag = 0) AND (date <= NOW()) "
                . COM_getPermSQL('AND')
                . "AND ta.type = 'article' AND ta.id = sid "
                . "AND (ta.tid IN({$tid_list}) "
                . "AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$A['tid']}'))) "
                . "GROUP BY sid";

            $result = DB_query($sql);
            $numRows = DB_numRows($result);
            $retval = COM_numberFormat($numRows);
            break;

        default:
            $retval = $fieldValue;
            break;
    }

    return $retval;
}
