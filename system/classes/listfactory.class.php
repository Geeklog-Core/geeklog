<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | listfactory.class.php                                                     |
// |                                                                           |
// | This class allows personalised lists or tables to be easily generated     |
// | from arrays or SQL statements. It will also supports the sorting and      |
// | paging of results.                                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Sami Barakat     - sami AT sbarakat DOT co DOT uk                |
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
        LF_ROW_NUMBER,  // The field identifier can be either:
                        //   LF_ROW_NUMBER - The number of each row will be displayed
                        //   LF_SOURCE_TITLE  - The title given the the SQL query will be displayed
                        //   <string>   - SQL column name
        true,           // Enables the field
        true,           // The field can be sorted
        '<b>%d.</b>'    // Formats the data
    );
    $obj->setField('Type', LF_SOURCE_TITLE, true, true, '<b>%s</b>');
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
        'Story', // The name given to the query which will be displayed in the LF_SOURCE_TITLE field (optional)
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
        LF_SOURCE_TITLE => 'Extra Row',
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
            // such as converting user ID's to usernames
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
* @author Sami Barakat, s.m.barakat AT gmail DOT com
*
*/
class ListFactory {

    // PRIVATE VARIABLES
    var $_fields = array();
    var $_sources_arr = array();
    var $_total_rank = 0;
    var $_sort_arr = array();
    var $_def_sort_arr = array();
    var $_page = 1;
    var $_per_page = 0;
    var $_page_limits = array();
    var $_function = '';
    var $_preset_rows = array();
    var $_page_url = '';
    var $_style = 'table';

    /**
    * Constructor
    *
    * Sets up private url variable and defines the
    * LF_SOURCE_TITLE, LF_SOURCE_NAME and LF_ROW_NUMBER constants.
    *
    * @access public
    * @param string $url The URL of the page the table appears on
    * @param array $limits The avaliable page limits
    * @param int $per_page The default number or rows per page
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

        define('LF_SOURCE_TITLE', 0);
        define('LF_SOURCE_NAME', 1);
        define('LF_ROW_NUMBER', 2);
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
    * Note: LF_ROW_NUMBER cannot be sorted
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
        if ($name === LF_ROW_NUMBER) {
            $sort = false;
        }
        $this->_fields[] = array(
            'title' => $title,
            'name' => $name,
            'display' => $display,
            'sort' => $sort,
            'format' => $format
        );
    }

    /**
    * Sets the SQL query that will generate rows
    *
    * @access public
    * @param string $title The text that's displayed to the user
    * @param string $name The local name given to the query
    * @param string $sql The SQL string without the ORDER BY or LIMIT clauses
    * @param int $rank The rating that determins how many results will be returned
    *
    */
    function setQuery( $title, $name, $sql, $rank )
    {
        $this->_sources_arr[] = array(
            'type' => 'sql',
            'title' => $title,
            'name' => $name,
            'sql' => $sql,
            'rank' => $rank
        );
        $this->_total_rank += $rank;
    }

    /**
    * Sets a callback function that provides another source for results.
    *
    * The function will be passed two parameters, $offset and $limit,
    * which will determine how many results are requested. The callback
    * function should then return a multidimensional array containing
    * the results. This provides an alternative to the setQuery()
    * function as results can be sourced from anywhere.
    *
    * @access public
    * @param string $title The text that's displayed to the user
    * @param string $name The local name given to the query
    * @param string $function Any callable function, method or lambda
    * @param int $rank The rating that determins how many results will be returned
    * @param int $total The total number of results that are avaliable
    *
    */
    function setCallback( $title, $name, $callback, $rank, $total )
    {
        $this->_sources_arr[] = array(
            'type' => 'callback',
            'title' => $title,
            'name' => $name,
            'func' => $callback,
            'rank' => $rank,
            'total' => $total
        );
        $this->_total_rank += $rank;
    }

    /**
    * Sets the callback function thats called on every row for styling
    * or formatting.
    *
    * @access public
    * @param callback $function Any callable function, method or lambda
    *
    */
    function setRowFunction( $callback )
    {
        $this->_function = $callback;
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
    * Appends a single result to the list
    *
    * @access public
    * @param array $result A single result that will be appended to the rest
    *
    */
    function addResult( $result )
    {
        $this->_preset_rows[] = $result;
    }

    /**
    * Appends several results to the list
    *
    * @access public
    * @param array $result An array of result that will be appended to the rest
    *
    */
    function addResultArray( $arr )
    {
        $this->_preset_rows = array_merge($this->_preset_rows, $arr);
    }

    /**
    * Gets the total number of results from source item, either an sql
    * query or a callback function.
    *
    * @access private
    * @param array $source The source we are currently working with
    * @return int Total number of rows
    *
    */
    function _getTotal( $source )
    {
        if ($source['type'] == 'callback') {
            return $source['total'];
        }
        else {
            $sql = $source['sql'];
        }

        if (is_array($sql)) {
            $sql['mysql'] = preg_replace('/SELECT.*?FROM/is', 'SELECT COUNT(*) FROM', $sql['mysql']);
            $sql['mssql'] = preg_replace('/SELECT.*?FROM/is', 'SELECT COUNT(*) FROM', $sql['mssql']);
            $sql['pgsql'] = preg_replace('/SELECT.*?FROM/is', 'SELECT COUNT(*) FROM', $sql['pgsql']);
        }
        else {
            $sql = preg_replace('/SELECT.*?FROM/is', 'SELECT COUNT(*) FROM', $sql);
        }
        $result = DB_query($sql);
        $num_rows = DB_numRows($result);
        if ($num_rows <= 1) {
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
        $fin = array('total' => 0, 'offset' => 0, 'limit' => 0);
        $fin = array_fill(0, count($totals), $fin);

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
    * Applies styling to each row and adds extra meta details that are
    * used else where in the ListFactory.
    *
    * @access private
    * @param array $row_arr A single results row
    * @param array $source The source we are currently working with
    * @return array The row with styling applied and extra meta details
    *
    */
    function _fillrow( $row_arr, $source )
    {
        $col = array();
        $col[LF_SOURCE_TITLE] = $source['title'];
        $col[LF_SOURCE_NAME] = $source['name'];

        foreach ($this->_fields as $field)
        {
            if (!is_numeric($field['name']) && $field['name'][0] != '_') {
                if (empty($row_arr[ $field['name'] ])) {
                    $col[ $field['name'] ] = 'LF_NULL';
                } else {
                    $col[ $field['name'] ] = $row_arr[ $field['name'] ];
                }
            }
        }

        // Need to call the format function before and after
        // sorting the results.
        if (is_callable($this->_function)) {
            $col = call_user_func_array($this->_function, array(true, $col));
        }

        return $col;
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
        // Set to default sort, we will check the passed param in the next bit
        $this->_sort_arr['field'] = $this->_def_sort_arr['field'];

        if (isset($_GET['order'])) {
            // Loop though the order fields and find a match against $_GET param
            foreach ($this->_fields as $field) {
                if ($field['sort'] == true && strcmp($field['name'], $_GET['order']) == 0) {
                    $this->_sort_arr['field'] = $field['name']; // Use a trusted value
                    break;
                }
            }
        }

        if (isset($_GET['direction'])) {
            $this->_sort_arr['direction'] = $_GET['direction'] == 'asc' ? 'asc' : 'desc';
        } else {
            $this->_sort_arr['direction'] = $this->_def_sort_arr['direction'];
        }

        if (is_numeric($this->_sort_arr['field'])) {
            $ord = $this->_def_sort_arr['field'];
            $this->_sort_arr['field'] = LF_SOURCE_TITLE;
        } else {
            $ord = $this->_sort_arr['field'];
        }
        $order_sql = ' ORDER BY ' . $ord . ' ' . strtoupper($this->_sort_arr['direction']);

        $this->_page = isset($_GET['page']) ? COM_applyFilter($_GET['page'], true) : 1;
        if (isset($_GET['results'])) {
            $this->_per_page = COM_applyFilter($_GET['results'], true);
        }

        $rows_arr = $this->_preset_rows;
        $this->_total_found = count($this->_preset_rows);

        // When the preset rows exceed per_page bail early
        if ($this->_total_found > $this->_per_page) {
            return array_slice($rows_arr, 0, $this->_per_page);
        }

        // Calculate the limits for each query
        $num_query_results = $this->_per_page - $this->_total_found;
        $pp_total = $this->_total_found;
        $limits = array();
        $num = count($this->_sources_arr);
        for ($i = 0; $i < $num; $i++) {
            $limits[$i]['total'] = $this->_getTotal($this->_sources_arr[$i]);
            $limits[$i]['pp'] = round(($this->_sources_arr[$i]['rank'] / $this->_total_rank) * $num_query_results);
            $this->_total_found += $limits[$i]['total'];
            $pp_total += $limits[$i]['pp'];
        }
        if ($num == 0) {
            $limits[0]['total'] = 0;
            $limits[0]['pp'] = 0;
        }
        if ($pp_total < $this->_per_page) {
            $limits[0]['pp'] += $this->_per_page - $pp_total;
        } else if ($this->_per_page < $pp_total) {
            $limits[0]['pp'] -= $pp_total - $this->_per_page;
        }
        $limits = $this->_getLimits($limits);

        // Retrieve the results from each source in turn
        for ($i = 0; $i < count($this->_sources_arr); $i++)
        {
            if ($limits[$i]['limit'] <= 0) {
                continue;
            }

            // This is a callback function
            if ($this->_sources_arr[$i]['type'] == 'callback')
            {
                if (is_callable($this->_sources_arr[$i]['func']))
                {
                    $callback_rows = call_user_func_array(
                        $this->_sources_arr[$i]['func'],
                        array($limits[$i]['offset'],
                        $limits[$i]['limit'])
                    );

                    foreach ($callback_rows as $row) {
                        $rows_arr[] = $this->_fillrow($row, $this->_sources_arr[$i]);
                    }
                } else {
                    COM_errorLog('ListFactory: A callback function was set for "'.
                        $this->_sources_arr[$i]['name'].'", but it could not be found.');
                }
                continue;
            }

            // This is an SQL query, so execute it and format the results
            $limit_sql = " LIMIT {$limits[$i]['offset']},{$limits[$i]['limit']}";

            if (is_array($this->_sources_arr[$i]['sql'])) {
                $this->_sources_arr[$i]['sql']['mysql'] .= $order_sql . $limit_sql;
                $this->_sources_arr[$i]['sql']['mssql'] .= $order_sql . $limit_sql;
            } else {
                $this->_sources_arr[$i]['sql'] .= $order_sql . $limit_sql;
            }

            $result = DB_query($this->_sources_arr[$i]['sql']);
            while ($A = DB_fetchArray($result)) {
                $rows_arr[] = $this->_fillrow($A, $this->_sources_arr[$i]);
            }
        }

        // Sort the final array
        $direction = $this->_sort_arr['direction'] == 'asc' ? SORT_ASC : SORT_DESC;
        $column = array();
        foreach ($rows_arr as $sortarray) {
            $c = strip_tags($sortarray[ $this->_sort_arr['field'] ]);
            $column[] = $c == 'LF_NULL' ? '0' : $c;
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
        $list_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
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
                $retval .= COM_startBlock($title, '', COM_getBlockTemplate('_admin_block', 'header'));
            }
            $retval .= $list_templates->finish($list_templates->get_var('output'));
            if (!empty($title)) {
                $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
            }

            return $retval;
        }

        // Draw the page limit select box
        if ($show_limit)
        {
            foreach ($this->_page_limits as $key => $val)
            {
                $text = is_numeric($key) ? sprintf($LANG09[67], $val) : $key;
                $href = $this->_page_url . "order={$this->_sort_arr['field']}&amp;" .
                            "direction={$this->_sort_arr['direction']}&amp;results=$val";

                // Prevent displaying too many limit items
                if ($this->_total_found <= $val)
                {
                    // If this is the last item, chances are its going to be selected
                    $selected = $this->_per_page >= $val ? ' selected="selected"' : '';
                    $list_templates->set_var('limit_href', $href);
                    $list_templates->set_var('limit_text', $text);
                    $list_templates->set_var('limit_selected', $selected);
                    $list_templates->parse('page_limit', 'limit', true);

                    break;
                }

                $selected = $this->_per_page == $val ? ' selected="selected"' : '';
                $list_templates->set_var('limit_text', $text);
                $list_templates->set_var('limit_href', $href);
                $list_templates->set_var('limit_selected', $selected);
                $list_templates->parse('page_limit', 'limit', true);
            }
            if (empty($text)) {
                $list_templates->set_var('show_limit', 'display:none;');
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
            $sort_selected = '';
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
                $href = '';
                $selected = '';

                if ($this->_style == 'inline' && $show_sort && $field['sort'] != false)
                {
                    $direction = $this->_def_sort_arr['direction'];

                    // Show the sort arrow
                    if ($this->_sort_arr['field'] === $field['name'])
                    {
                        // Add drop down item for current sort order
                        if ($this->_sort_arr['direction'] == 'asc') {
                            $list_templates->set_var('sort_text',
                                    $text . ' (' . $LANG09[71] . ')');
                        } else {
                            $list_templates->set_var('sort_text',
                                    $text . ' (' . $LANG09[72] . ')');
                        }
                        $list_templates->set_var('sort_href', '');
                        $list_templates->set_var('sort_selected', ' selected="selected"');
                        $list_templates->parse('page_sort', 'sort', true);

                        // Set up the sort order for the opposite direction
                        $direction = $this->_sort_arr['direction'] == 'asc' ? 'desc' : 'asc';
                        if ($direction == 'asc') {
                            $text .= ' (' . $LANG09[71] . ')';
                        } else {
                            $text .= ' (' . $LANG09[72] . ')';
                        }
                    }
                    $href = $this->_page_url . "results={$this->_per_page}&amp;" .
                                "order={$field['name']}&amp;direction=$direction";

                    // Write field
                    $list_templates->set_var('sort_text', $text);
                    $list_templates->set_var('sort_href', $href);
                    $list_templates->set_var('sort_selected', '');
                    $list_templates->parse('page_sort', 'sort', true);
                }
                else if ($this->_style == 'table')
                {
                    $direction = $this->_sort_arr['direction'] == 'asc' ? 'desc' : 'asc';
                    $href = $this->_page_url . "results={$this->_per_page}&amp;" .
                        "order={$field['name']}&amp;direction=$direction";

                    if ($show_sort && $field['sort'] != false)
                    {
                        $text = "<a href=\"$href\">$text</a>";

                        if ($this->_sort_arr['field'] === $field['name']) {
                            $selected = $sort_selected;
                        }
                    }

                    // Write field
                    $list_templates->set_var('sort_text', $text);
                    $list_templates->set_var('sort_href', $href);
                    $list_templates->set_var('sort_selected', $selected);
                    $list_templates->parse('page_sort', 'sort', true);
                }
            }
        }

        $offset = ($this->_page-1) * $this->_per_page;

        $list_templates->set_var('show_message', 'display:none;');

        // Run through all the results
        $r = 1;
        foreach ($rows_arr as $row)
        {
            if (is_callable($this->_function)) {
                $row = call_user_func_array($this->_function, array(false, $row));
            }

            foreach ($this->_fields as $field)
            {
                if ($field['display'] == true)
                {
                    $fieldvalue = '';
                    if ($field['name'] == LF_ROW_NUMBER) {
                        $fieldvalue = $r + $offset;
                    } else if (!empty($row[ $field['name'] ])) {
                        $fieldvalue = $row[ $field['name'] ];
                    }

                    if ($fieldvalue != 'LF_NULL') {
                        $fieldvalue = sprintf($field['format'], $fieldvalue, $field['title']);

                        // Write field
                        $list_templates->set_var('field_text', $fieldvalue);
                        $list_templates->parse('item_field', 'field', true);
                    } else {
                        // Write an empty field
                        $list_templates->set_var('field_text', ' ');
                        $list_templates->parse('item_field', 'field', true);
                    }
                }
            }

            // Write row
            $r++;
            $list_templates->set_var('cssid', ($r % 2) + 1);
            $list_templates->parse('item_row', 'row', true);
            $list_templates->clear_var('item_field');
        }

        // Print page numbers
        $page_url = $this->_page_url.'order='.$this->_sort_arr['field'] .
                '&amp;direction='.$this->_sort_arr['direction'].'&amp;results='.$this->_per_page;
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
            $retval .= COM_startBlock($title, '', COM_getBlockTemplate('_admin_block', 'header'));
        }

        $retval .= $list_templates->finish($list_templates->get_var('output'));

        if (!empty($title)) {
            $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
        }

        return $retval;
    }
}

?>
