<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
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

class SearchCriteria
{
    /**
     * @var string
     */
    private $sql = '';

    /**
     * @var string|array
     */
    private $ftSQL = '';

    /**
     * @var string
     */
    private $pluginLabel;

    /**
     * @var string
     */
    private $pluginName;

    /**
     * @var int
     */
    private $_rank;

    /**
     * @var bool
     */
    private $urlRewrite;

    /**
     * @var bool
     */
    private $appendQuery;

    /**
     * @var array
     */
    private $_results = array();

    /**
     * @var callable
     */
    private $callBackFunc = null;

    /**
     * @var int
     */
    private $totalResults = 0;

    /**
     * SearchCriteria constructor.
     *
     * @param  string $pluginName
     * @param  string $pluginLabel
     */
    public function __construct($pluginName, $pluginLabel)
    {
        $this->pluginName = $pluginName;
        $this->pluginLabel = $pluginLabel;
        $this->setRank(3);
        $this->setURLRewrite(false);
        $this->setAppendQuery(true);
        $this->totalResults = 0;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->pluginName;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->pluginLabel;
    }

    /**
     * @param  int $rank
     */
    public function setRank($rank)
    {
        $this->_rank = (int) $rank;
    }

    /**
     * @param  bool $url_rewrite
     */
    public function setURLRewrite($url_rewrite)
    {
        $this->urlRewrite = (bool) $url_rewrite;
    }

    /**
     * @return bool
     */
    public function isURLRewrite()
    {
        return $this->urlRewrite;
    }

    /**
     * @param  bool $append_query
     */
    public function setAppendQuery($append_query)
    {
        $this->appendQuery = (bool) $append_query;
    }

    /**
     * @return bool
     */
    public function isAppendQuery()
    {
        return $this->appendQuery;
    }

    /**
     * @param  array $result_arr
     */
    public function setResults(array $result_arr)
    {
        $this->_results = $result_arr;
    }

    /**
     * @return int
     */
    public function getRank()
    {
        return $this->_rank;
    }

    /**
     * @return array
     */
    public function getResults()
    {
        return $this->_results;
    }

    public function setCallback($func)
    {
        if (is_callable($func)) {
            $this->callBackFunc = $func;
        }
    }

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callBackFunc;
    }

    /**
     * @param  int $total_results
     */
    public function setTotal($total_results)
    {
        $this->totalResults = (int) $total_results;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->totalResults;
    }

    /**
     * @param  string $sql
     */
    public function setSQL($sql)
    {
        $this->sql = $sql;
    }

    /**
     * @param  string|array $ftSQL
     */
    public function setFtSQL($ftSQL)
    {
        $this->ftSQL = $ftSQL;
    }

    /**
     * @return string
     */
    public function getSQL()
    {
        return $this->sql;
    }

    /**
     * @return string|array
     */
    public function getFtSQL()
    {
        global $_DB_dbms;

        // When only one SQL statement is set we assume it is for MySQL
        if ($this->ftSQL != '' && (is_string($this->ftSQL) && $_DB_dbms === 'mysql') || is_array($this->ftSQL)) {
            return $this->ftSQL;
        } else {
            return '';
        }
    }

    /**
     * @param  string $keyType
     * @param  string $query
     * @param  array  $columns
     * @param  string $sql
     * @return array
     */
    public function buildSearchSQL($keyType, $query, $columns, $sql = '')
    {
        // Make sure query has at least 1 letter
        // if (!empty(trim($query))) { // Doesn't work in PHP 5.3
        if (strlen(trim($query)) > 0) {
            if ($keyType === 'all') {
                // must contain ALL of the keywords
                $words = array_unique(explode(' ', $query));
                $words = array_filter($words); // filter out empty strings
                $sep = 'AND';

                $ftWords['mysql'] = '+' . str_replace(' ', ' +', $query);
                $ftWords['pgsql'] = '"' . str_replace(' ', '" AND "', $query) . '"';
            } elseif ($keyType === 'any') {
                // must contain ANY of the keywords
                $words = array_unique(explode(' ', $query));
                $words = array_filter($words); // filter out empty strings
                $sep = 'OR ';
                $ftWords['mysql'] = $query;
                $ftWords['pgsql'] = $query;
            } else {
                // do an exact phrase search (default)
                $words = array($query);
                $sep = '   ';

                // Putting quotes around a single word in mysql really slows things down
                if (strpos($query, ' ') !== false) {
                    $ftWords['mysql'] = '"' . $query . '"';
                } else {
                    $ftWords['mysql'] = $query;
                }
                $ftWords['pgsql'] = '"' . $query . '"';
            }

            $titles = isset($_GET['title'], $columns['title']);

            if ($titles) {
                $strCol = $columns['title'];
            } else {
                $strCol = implode(',', $columns);
            }

            $ftSQL['mysql'] = $sql . "AND MATCH($strCol) AGAINST ('{$ftWords['mysql']}' IN BOOLEAN MODE)";

            $tmp = 'AND (';
            foreach ($words as $word) {
                $word = trim($word);
                $tmp .= '(';

                if ($titles) {
                    $tmp .= $columns['title'] . " LIKE '%$word%' OR ";
                } else {
                    foreach ($columns as $col) {
                        $tmp .= "$col LIKE '%$word%' OR ";
                    }
                }
                $tmp = substr($tmp, 0, -4) . ") $sep ";
            }

            $sql .= substr($tmp, 0, -5) . ') ';
        } else {
            $ftSQL['mysql'] = $sql;
        }

        return array($sql, $ftSQL);
    }

    public function getDateRangeSQL($type = 'WHERE', $column, $dateStart, $dateEnd)
    {
        if (!empty($dateStart) || !empty($dateEnd)) {
            // Do some date checking and fill in missing dates
            $delimiter = '-';
            if (empty($dateStart) || (strtotime($dateStart) == false)) {
                $dateStart = "0000-00-00";
            } else {
                $dateStart = date('Y-m-d', strtotime($dateStart));
            }
            if (empty($dateEnd) || (strtotime($dateEnd) == false)) {
                $dateEnd = date('Y-m-d');
            } else {
                $dateEnd = date('Y-m-d', strtotime($dateEnd));
            }

            $DS = explode($delimiter, $dateStart);
            $DE = explode($delimiter, $dateEnd);
            $startDate = mktime(0, 0, 0, $DS[1], $DS[2], $DS[0]);
            $endDate = mktime(23, 59, 59, $DE[1], $DE[2], $DE[0]);

            return " $type (UNIX_TIMESTAMP($column) BETWEEN '$startDate' AND '$endDate') ";
        }

        return '';
    }
}
