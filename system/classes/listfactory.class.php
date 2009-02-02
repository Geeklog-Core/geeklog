<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | listfactory.class.php                                                     |
// |                                                                           |
// | This class allows personalised lists or tables to be easily generated     |
// | from arrays or SQL statements. It will also supports the sorting and      |
// | paging of results.                                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Sami Barakat     - s.m.barakat AT gmail DOT com                  |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'listfactory.class.php') !== false) {
    die('This file can not be used on its own.');
}

/* Example Use

    // Initiate an instance of the class with the URL of the current page
    $url = $_SERVER['PHP_SELF'];
    $obj = new ListFactory($url);

    // Set up some hidden fields that will be used to help format the data later on
    $obj->setField('ID', 'id', false);

    // Set up the fields that will be seen by the user
    $obj->setField(
        '#',            // Title of the field
        ROW_NUMBER,     // The field identifier can be either:
                        //   ROW_NUMBER - The number of each row will be displayed
                        //   SQL_TITLE  - The title given the the SQL query will be displayed
                        //   <string>   - SQL column name
        true,           // Enables the field
        true,           // The field can be sorted
        '<b>%d.</b>'    // Formats the data
    );
    $obj->setField('Type', SQL_TITLE, true, true, '<b>%s</b>');
    $obj->setField('Title', 'title');
    $obj->setField('Text', 'text');
    $obj->setField('Date', 'date');

    // Set the default field to sort by
    $obj->setDefaultSort('date');

    // Set the style of output
    $obj->setStyle('table');

    // Sets the call back function to add any extra formatting to the fields
    $obj->setRowFunction('test_list_func');

    // Set up some queries to execute
    $sql = 'SELECT sid AS id, title, introtext AS text, date FROM stories';
    $obj->setQuery(
        'Story', // The name given to the query which will be displayed in the SQL_TITLE field (optional)
        'story',
        $sql,    // The SQL string without the LIMIT or ORDER BY clauses. Notice the column names match the field identifiers
        5        // The rank of the query, 5 highest = more results, 1 lowest = least results
    );
    $sql = 'SELECT cid AS id, title, comment AS text, date FROM comments';
    $obj->setQuery('Comment', 'comment', $sql, 2);

    // Append some extra rows to the output
    // Note: the array must match the field identifier names stated previously
    $extra_row = array(
        'id' => -1,
        SQL_TITLE => 'Extra Row',
        'title' => 'An extra row example',
        'text' => 'With some really really really long text.....<b>and HTML</b>',
        'date' => '2008-07-08 03:00:00'
    );
    // Add the extra row, notice it is not automatically passed to the row function
    $obj->addResult($extra_row);

    // Prints out the list
    $results = $obj->ExecuteQueries();
    $title = 'Test ListFactory';
    $text = 'Showing %d - %d of %d results.';
    $retval = $obj->getFormattedOutput($results, $title, $text);
    echo $retval;

    // This function is called by the ListFactory to provide furthur formatting of the results.
    function test_list_func($preSort, $row)
    {
        if ($preSort)
        {
            // extract any further information from the results.
            // such as converting user ID's to user names
        }
        else
        {
            // Create a link from the title and id
            $row['title'] = '<a href="http://www.geeklog.net/list_test.php?id='.$row['id'].'">'.$row['title'].'</a>';

            // Shorten the text and strip any HTML tags
            $row['text'] = substr(strip_tags($row['text']), 0, 20);
        }

        // Return the reformatted row
        return $row;
    }

*/

/**
* Geeklog List Factory Class
*
* @author Sami Barakat <s.m.barakat AT gmail DOT com>
*
*/
class ListFactory {

    // PRIVATE VARIABLES
    var $_fields = array();
    var $_query_arr = array();
    var $_total_rank = 0;
    var $_sort_arr = array();
    var $_def_sort_arr = array();
    var $_page = 1;
    var $_per_page = 0;
    var $_page_limits = array();
    var $_function = '';
    var $_class_instance = null;
    var $_preset_rows = array();
    var $_page_url = '';
    var $_style = 'table';

    /**
    * Constructor
    *
    * Sets up private url variable and defines the
    * SQL_TITLE, SQL_NAME and ROW_NUMBER constants.
    *
    * @access public
    * @param string $url The URL of the page the table appears on
    * @param array $limits The avaliable page limits
    * @param integer $per_page The default number or rows per page
    *
    */
    function ListFactory( $url, $limits = '10,15,20,25,30,35', $per_page = 20 )
    {
        $url .= (strpos($url,'?') === false ? '?' : '&amp;');
        $this->_page_url = $url;
        $this->_style = 'table';
        $this->_per_page = $per_page;

        if (is_string($limits)) {
            $this->_page_limits = explode(',', $limits);
        } else if (is_array($limits)) {
            $this->_page_limits = $limits;
        } else {
            $this->_page_limits = array(10, 15, 20, 25, 30, 35);
        }

        define('SQL_TITLE', 0);
        define('SQL_NAME', 1);
        define('ROW_NUMBER', 2);
    }

    /**
    * Determins which set of templates to load when formatting the output
    *
    * @access public
    * @param string $style Either 'table' or 'inline'
    *
    */
    function setStyle( $style )
    {
        $this->_style = $style;
    }

    /**
    * Sets a field in the list.
    *
    * Note: ROW_NUMBER cannot be sorted
    *
    * @access public
    * @param string $title The title of the field which is displayed to the user
    * @param string $name The local name given to the field
    * @param boolean $display True if the field is to be displayed to the user otherwise false
    * @param boolean $sort True if the field can be sorted otherwise false
    * @param string $format The format string with one type specifier
    *
    */
    function setField( $title, $name, $display = true, $sort = true, $format = '%s' )
    {
        if ($name === ROW_NUMBER) {
            $sort = false;
        }
        $this->_fields[] = array('title' => $title, 'name' => $name, 'display' => $display, 'sort' => $sort, 'format' => $format);
    }

    /**
    * Sets the SQL query that will generate rows
    *
    * @access public
    * @param string $title The text that's displayed to the user
    * @param string $name The local name given to the query
    * @param string $sql The SQL string without the ORDER BY or LIMIT clauses
    * @param integer $rank The rating that determins how many results will be returned
    *
    */
    function setQuery( $title, $name, $sql, $rank )
    {
        $this->_query_arr[] = array('title' => $title, 'name' => $name, 'sql' => $sql, 'rank' => $rank);
        $this->_total_rank += $rank;
    }

    /**
    * Sets the callback function that gets called when formatting a row
    *
    * @access public
    * @param string $function The name given to a call back function that can format the results
    * @param object $inst The instance of the class that contains the function
    *
    */
    function setRowFunction( $function, $inst = null )
    {
        $this->_function = $function;
        $this->_class_instance = $inst;
    }

    /**
    * Sets the default sort field
    *
    * @access public
    * @param string $field The field name to sort
    * @param string $direction 'asc' for ascending order and 'desc' for descending order
    *
    */
    function setDefaultSort( $field, $direction = 'desc' )
    {
        $this->_def_sort_arr = array('field' => $field, 'direction' => $direction);
    }

    /**
    * Appends a result to the list
    *
    * @access public
    * @param array $result An single result that will be appended to the rest
    *
    */
    function addResult( $result )
    {
        $this->_preset_rows[] = $result;
    }

    /**
    * Gets the total number of results from a query
    *
    * @access private
    * @param string $sql The query
    * @return integer Total number of rows
    *
    */
    function _numRows( $sql )
    {
        if (is_array($sql))
        {
            $sql['mysql'] = preg_replace('/SELECT.*FROM/is', 'SELECT COUNT(*) FROM', $sql['mysql']);
            $sql['mssql'] = preg_replace('/SELECT.*FROM/is', 'SELECT COUNT(*) FROM', $sql['mssql']);
        }
        else
        {
            $sql = preg_replace('/SELECT.*FROM/is', 'SELECT COUNT(*) FROM', $sql);
        }
        $result = DB_query($sql);
        $num_rows = DB_numRows($result);
        if ($num_rows <= 1)
        {
            $B = DB_fetchArray($result, true);
            $num_rows = $B[0];
        }
        return $num_rows ? $num_rows : 0;
    }

    /**
    * Calculates the offset and limits for each query based on
    * the number of rows to be displayed per query per page.
    *
    * @access private
    * @param array $totals The total number of results per query
    * @return array The offsets and limits for a given page
    *
    */
    function _getLimits( $totals )
    {
        $order = range(0, count($totals)-1);
        array_multisort($totals, $order);

        for ($p = 0; $p < $this->_page; $p++)
        {
            $extra = 0;
            for ($q = 0; $q < count($totals); $q++)
            {
                $fin[$q]['offset'] = $fin[$q]['offset'] + $fin[$q]['limit'];
                $extra_pp = $extra + $totals[$q]['pp'];
                if ($extra_pp - $totals[$q]['total'] >= 0)
                {
                    $fin[$q]['limit'] = $totals[$q]['total'];
                    $extra = $extra_pp - $totals[$q]['total'];
                    $totals[$q]['total'] = 0;
                }
                else if ($totals[$q]['total'] - $extra_pp >= 0)
                {
                    $fin[$q]['limit'] = $extra_pp;
                    $totals[$q]['total'] = $totals[$q]['total'] - $extra_pp;
                    $extra = 0;
                }
                else
                {
                    $fin[$q]['limit'] = $totals[$q]['pp'];
                    $totals[$q]['total'] = $totals[$q]['total'] - $totals[$q]['pp'];
                }
            }
            array_multisort($totals, $order, $fin);
        }

        array_multisort($order, $fin);

        return $fin;
    }

    /**
    * Executes pre set queries
    *
    * @access public
    * @return array The results found
    *
    */
    function ExecuteQueries()
    {
        // Get the details for sorting the list
        $this->_sort_arr['field'] = isset($_REQUEST['order']) ? COM_applyFilter($_REQUEST['order']) : $this->_def_sort_arr['field'];
        $this->_sort_arr['direction'] = isset($_REQUEST['direction']) ? COM_applyFilter($_REQUEST['direction']) : $this->_def_sort_arr['direction'];
        if (is_numeric($this->_sort_arr['field']))
        {
            $ord = $this->_def_sort_arr['field'];
            $this->_sort_arr['field'] = SQL_TITLE;
        }
        else
        {
            $ord = $this->_sort_arr['field'];
        }
        $order_sql = ' ORDER BY ' . $ord . ' ' . strtoupper($this->_sort_arr['direction']);

        $this->_page = isset($_REQUEST['page']) ? COM_applyFilter($_REQUEST['page'], true) : 1;
        if (isset($_REQUEST['results'])) {
            $this->_per_page = COM_applyFilter($_REQUEST['results'], true);
        }

        // Calculate the limits for each query
        $this->_total_found = count($this->_preset_rows);
        $num_query_results = $this->_per_page - $this->_total_found;
        $pp_total = $this->_total_found;
        $limits = array();
        for ($i = 0; $i < count($this->_query_arr); $i++)
        {
            $limits[$i]['total'] = $this->_numRows($this->_query_arr[$i]['sql']);
            $limits[$i]['pp'] = round(($this->_query_arr[$i]['rank'] / $this->_total_rank) * $num_query_results);
            $this->_total_found += $limits[$i]['total'];
            $pp_total += $limits[$i]['pp'];
        }
        if ($pp_total < $this->_per_page) {
            $limits[0]['pp'] += $this->_per_page - $pp_total;
        } else if ($this->_per_page < $pp_total) {
            $limits[0]['pp'] -= $pp_total - $this->_per_page;
        }
        $limits = $this->_getLimits($limits);

        // Execute each query in turn
        $rows_arr = $this->_preset_rows;
        for ($i = 0; $i < count($this->_query_arr); $i++)
        {
            if ($limits[$i]['limit'] == 0) {
                continue;
            }
            $limit_sql = " LIMIT {$limits[$i]['offset']},{$limits[$i]['limit']}";

            if (is_array($this->_query_arr[$i]['sql']))
            {
                $this->_query_arr[$i]['sql']['mysql'] .= $order_sql . $limit_sql;
                $this->_query_arr[$i]['sql']['mssql'] .= $order_sql . $limit_sql;
            }
            else
            {
                $this->_query_arr[$i]['sql'] .= $order_sql . $limit_sql;
            }

            $result = DB_query($this->_query_arr[$i]['sql']);

            while ($A = DB_fetchArray($result))
            {
                $col = array();
                $col[SQL_TITLE] = $this->_query_arr[$i]['title'];
                $col[SQL_NAME] = $this->_query_arr[$i]['name'];

                foreach ($this->_fields as $field)
                {
                    if (!is_numeric($field['name'])) {
                        $col[ $field['name'] ] = $A[ $field['name'] ];
                    }
                }

                // Need to call the format function before and after
                // sorting the results.
                $function = $this->_function;
                if ($function != '')
                {
                    if (function_exists($function)) {
                        $col = $function(true, $col);
                    } else if ($this->_class_instance != null) {
                        $col = $this->_class_instance->$function(true, $col);
                    }
                }

                $rows_arr[] = $col;
            }
        }

        // Sort the final array
        $direction = $this->_sort_arr['direction'] == 'asc' ? SORT_ASC : SORT_DESC;
        $column = array();
        foreach ($rows_arr as $sortarray) {
            $column[] = strip_tags($sortarray[ $this->_sort_arr['field'] ]);
        }
        array_multisort($column, $direction, $rows_arr);

        return $rows_arr;
    }

    /**
    * Generates the HTML code based on the preset style
    *
    * @access public
    * @param array $rows_arr The rows to display in the list
    * @param string $title The title of the list
    * @param string $list_top HTML that will appear before the list is printed
    * @param string $list_bottom HTML that will appear after the list is printed
    * @param boolean $show_sort True to enable column sorting, false to disable
    * @param boolean $show_limit True to show page limits, false to hide
    * @return string HTML output
    *
    */
    function getFormattedOutput( $rows_arr, $title, $list_top = '', $list_bottom = '', $show_sort = true, $show_limit = true )
    {
        global $_CONF, $_IMAGE_TYPE, $LANG_ADMIN, $LANG09;

        // get all template fields.
        $list_templates = new Template($_CONF['path_layout'] . 'lists/' . $this->_style);
        $list_templates->set_file (array (
            'list' => 'list.thtml',
            'limit' => 'page_limit.thtml',
            'sort' => 'page_sort.thtml',
            'row' => 'item_row.thtml',
            'field' => 'item_field.thtml'
        ));

        // insert std. values into the template
        $list_templates->set_var('xhtml', XHTML);
        $list_templates->set_var('site_url', $_CONF['site_url']);
        $list_templates->set_var('layout_url', $_CONF['layout_url']);

        if (count($rows_arr) == 0)
        {
            $list_templates->set_var('show_sort', 'display:none;');
            $list_templates->set_var('show_limit', 'display:none;');
            $list_templates->set_var('message', $LANG_ADMIN['no_results']);
            $list_templates->set_var('list_top', $list_top);
            $list_templates->set_var('list_bottom', $list_bottom);
            $list_templates->parse('output', 'list');

            // No results to show so quickly print a message and exit
            $retval = '';
            if (!empty($title)) {
                $retval .= COM_startBlock($title, $help_url, COM_getBlockTemplate('_admin_block', 'header'));
            }
            $retval .= $list_templates->finish($list_templates->get_var('output'));
            if (!empty($title)) {
                $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
            }

            return $retval;
        }

        $subtag = " onmouseover=\"this.style.cursor='pointer';\"" .
                    " onclick=\"window.location.href='{$this->_page_url}";

        // Draw the page limit select box
        if ($show_limit)
        {
            foreach ($this->_page_limits as $key => $val)
            {
                $text = is_numeric($key) ? sprintf($LANG09[67], $val) : $key;
                $subtags = $subtag."results=$val';\"";
                $selected = $this->_per_page == $val ? ' selected="selected"' : '';

                $list_templates->set_var('limit_text', $text);
                $list_templates->set_var('limit_subtags', $subtags);
                $list_templates->set_var('limit_selected', $selected);
                $list_templates->parse('page_limit', 'limit', true);
            }
        }
        else
        {
            $list_templates->set_var('show_limit', 'display:none;');
        }

        // Create how to display the sort field
        if ($this->_style == 'table')
        {
            $arrow = $this->_sort_arr['direction'] == 'asc' ? 'bararrowdown' : 'bararrowup';
            $sort_selected = "{$_CONF['layout_url']}/images/$arrow.$_IMAGE_TYPE";
            $sort_selected = ' &nbsp;' . COM_createImage($sort_selected, $arrow);
            $sort_text = '';
        }
        else
        {
            $sort_selected = ' selected="selected"';
            $sort_text = $LANG09[68].' ';
            if (!$show_sort) {
                $list_templates->set_var('show_sort', 'display:none;');
            }
        }

        // Draw the sorting select box/table headings
        foreach ($this->_fields as $field)
        {
            if ($field['display'] == true && $field['title'] != '')
            {
                $text = $sort_text . $field['title'];
                $subtags = '';
                $selected = '';
                if ($show_sort && $field['sort'] != false)
                {
                    $direction = $this->_def_sort_arr['direction'];

                    // Show the sort arrow
                    if ($this->_sort_arr['field'] === $field['name'])
                    {
                        $selected = $sort_selected;
                        $direction = $this->_sort_arr['direction'] == 'asc' ? 'desc' : 'asc';
                    }

                    $subtags = $subtag."order={$field['name']}&amp;direction=$direction';\"";
                }

                // Write field
                $list_templates->set_var('sort_text', $text);
                $list_templates->set_var('sort_subtags', $subtags);
                $list_templates->set_var('sort_selected', $selected);
                $list_templates->parse('page_sort', 'sort', true);
            }
        }

        $offset = ($this->_page-1) * $this->_per_page;

        $list_templates->set_var('show_message', 'display:none;');

        // Run through all the results
        $r = 1;
        foreach ($rows_arr as $row)
        {
            $function = $this->_function;
            if ($function != '')
            {
                if (function_exists($function)) {
                    $row = $function(false, $row);
                } else if ($this->_class_instance != null) {
                    $row = $this->_class_instance->$function(false, $row);
                }
            }

            foreach ($this->_fields as $field)
            {
                if ($field['display'] == true)
                {
                    $fieldvalue = '';
                    if ($field['name'] == ROW_NUMBER) {
                        $fieldvalue = $r + $offset;
                    } else if (!empty($row[ $field['name'] ])) {
                        $fieldvalue = $row[ $field['name'] ];
                    }

                    $fieldvalue = sprintf($field['format'], $fieldvalue, $field['title']);

                    // Write field
                    $list_templates->set_var('field_text', $fieldvalue);
                    $list_templates->parse('item_field', 'field', true);
                }
            }

            // Write row
            $r++;
            $list_templates->set_var('cssid', ($r % 2) + 1);
            $list_templates->parse('item_row', 'row', true);
            $list_templates->clear_var('item_field');
        }

        // Print page numbers
        $page_url = $this->_page_url . 'order=' . $this->_sort_arr['field'] . '&amp;direction=' . $this->_sort_arr['direction'] . '&amp;results=' . $this->_per_page;
        $num_pages = ceil($this->_total_found / $this->_per_page);
        if ($num_pages > 1) {
            $list_templates->set_var('google_paging', COM_printPageNavigation($page_url, $this->_page, $num_pages, 'page=', false, '', ''));
        } else {
            $list_templates->set_var('google_paging', '');
        }

        $list_top = sprintf($list_top, $offset+1, $r+$offset-1, $this->_total_found);
        $list_templates->set_var('list_top', $list_top);
        $list_templates->set_var('list_bottom', $list_bottom);

        $list_templates->parse('output', 'list');

        // Do the actual output
        $retval = '';

        if (!empty($title)) {
            $retval .= COM_startBlock($title, $help_url, COM_getBlockTemplate('_admin_block', 'header'));
        }

        $retval .= $list_templates->finish($list_templates->get_var('output'));

        if (!empty($title)) {
            $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
        }

        return $retval;
    }
}

?>
