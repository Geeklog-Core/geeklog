<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6.1                                                             |
// +---------------------------------------------------------------------------+
// | searchcriteria.class.php                                                  |
// |                                                                           |
// | This class acts as a container which allows data to be passed between the |
// | search engine and plugins.                                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Sami Barakat, s.m.barakat AT gmail DOT com                       |
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

class SearchCriteria {

    // PRIVATE PROPERTIES
    var $_sql = '';
    var $_ftsql = '';
    var $_pluginLabel;
    var $_pluginName;
    var $_rank;
    var $_url_rewrite;
    var $_append_query;
    var $_results = array();
    var $_callback_func = '';
    var $_total_results = 0;

    // CONSTRUCTOR
    function SearchCriteria( $pluginName, $pluginLabel )
    {
        $this->_pluginName = $pluginName;
        $this->_pluginLabel = $pluginLabel;
        $this->_rank = 3;
        $this->_url_rewrite = false;
        $this->_append_query = true;
        $this->_total_results = 0;
    }

    // GENERAL METHODS
    function getName()
    {
        return $this->_pluginName;
    }

    function getLabel()
    {
        return $this->_pluginLabel;
    }

    function setRank( $rank )
    {
        $this->_rank = $rank;
    }

    function setURLRewrite( $url_rewrite )
    {
        $this->_url_rewrite = $url_rewrite;
    }

    function setAppendQuery( $append_query )
    {
        $this->_append_query = $append_query;
    }

    function setResults( $result_arr )
    {
        $this->_results = $result_arr;
    }

    function getRank()
    {
        return $this->_rank;
    }

    function UrlRewriteEnable()
    {
        return $this->_url_rewrite;
    }

    function AppendQueryEnable()
    {
        return $this->_append_query;
    }

    function getResults()
    {
        return $this->_results;
    }

    // CALLBACK METHODS
    function setCallback( $func )
    {
        $this->_callback_func = $func;
    }

    function getCallback()
    {
        return $this->_callback_func;
    }

    function setTotal( $total_results )
    {
        $this->_total_results = $total_results;
    }

    function getTotal()
    {
        return $this->_total_results;
    }

    // SQL METHODS
    function setSQL( $sql )
    {
        $this->_sql = $sql;
    }

    function setFTSQL( $ftsql )
    {
        $this->_ftsql = $ftsql;
    }

    function getSQL()
    {
        return $this->_sql;
    }

    function getFTSQL()
    {
        global $_DB_dbms;

        // When only one SQL statment is set we assume it is for MySQL
        if ($this->_ftsql != '' && (is_string($this->_ftsql) && $_DB_dbms == 'mysql') || is_array($this->_ftsql)) {
            return $this->_ftsql;
        } else {
            return '';
        }
    }

    function buildSearchSQL( $keyType, $query, $columns, $sql = '' )
    {
        if ($keyType == 'all')
        {
            // must contain ALL of the keywords
            $words = explode(' ', $query);
            $sep = 'AND';

            $ftwords['mysql'] = '+' . str_replace(' ', ' +', $query);
            $ftwords['mssql'] = '"' . str_replace(' ', '" AND "', $query) . '"';
            $ftwords['pgsql'] = '"' . str_replace(' ', '" AND "', $query) . '"';

        }
        else if ($keyType == 'any')
        {
            // must contain ANY of the keywords
            $words = explode(' ', $query);
            $sep = 'OR ';
            $ftwords['mysql'] = $query;
            $ftwords['pgsql'] = $query;
            $ftwords['mssql'] = '"' . str_replace(' ', '" OR "', $query) . '"';
        }
        else
        {
            // do an exact phrase search (default)
            $words = array($query);
            $sep = '   ';

            // Puttings quotes around a single word in mysql really slows things down
            if (strpos($query, ' ') !== false) {
                $ftwords['mysql'] = '"' . $query . '"';
            } else {
                $ftwords['mysql'] = $query;
            }
            $ftwords['mssql'] = '"' . $query . '"';
            $ftwords['pgsql'] = '"' . $query . '"';
        }

        $titles = (isset($_GET['title']) && isset($columns['title'])) ? true : false;

        if ($titles) {
            $strcol = $columns['title'];
        } else {
            $strcol = implode(',', $columns);
        }

        $ftsql['mysql'] = $sql . "AND MATCH($strcol) AGAINST ('{$ftwords['mysql']}' IN BOOLEAN MODE)";
        $ftsql['mssql'] = $sql . "AND CONTAINS(($strcol), '{$ftwords['mssql']}')";

        $tmp = 'AND (';
        foreach ($words AS $word)
        {
            $word = trim($word);
            $tmp .= '(';

            if ($titles) {
                $tmp .= $columns['title'] . " LIKE '%$word%' OR ";
            } else {
                foreach ($columns AS $col) {
                    $tmp .= "$col LIKE '%$word%' OR ";
                }
            }
            $tmp = substr($tmp, 0, -4) . ") $sep ";
        }
        $sql .= substr($tmp, 0, -5) . ') ';

        return array($sql,$ftsql);
    }

    function getDateRangeSQL( $type = 'WHERE', $column, $datestart, $dateend )
    {
        if (!empty($datestart) && !empty($dateend))
        {
            $delim = substr($datestart, 4, 1);
            if (!empty($delim))
            {
                $DS = explode($delim, $datestart);
                $DE = explode($delim, $dateend);
                $startdate = mktime(0,0,0,$DS[1],$DS[2],$DS[0]);
                $enddate = mktime(23,59,59,$DE[1],$DE[2],$DE[0]);
                return " $type (UNIX_TIMESTAMP($column) BETWEEN '$startdate' AND '$enddate') ";
            }
        }

        return '';
    }
}

?>
