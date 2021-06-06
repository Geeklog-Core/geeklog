<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | DbMysqli.php                                                              |
// |                                                                           |
// | mysql database class with MySQLi extension                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2021 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony AT tonybibbs DOT com                            |
// |          Kenji Ito, geeklog AT mystral-kk DOT net                         |
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

namespace Geeklog\Database;

use InvalidArgumentException;
use Mysqli;
use mysqli_result;

/**
 * This file is the mysql implementation of the Geeklog abstraction layer.
 * Unfortunately the Geeklog abstraction layer isn't 100% abstract because a few
 * key functions use MySQL's REPLACE INTO syntax which is not a SQL standard.
 * This issue will need to be resolved some time ...
 */
class DbMysqli
{
    // Minimum requirement
    const SUPPORTED_MYSQL_VER = '4.1.3';

    // Default database character set
    const DEFAULT_CHARSET = 'latin1';

    // MySQL sql_mode constants
    const MYSQL_SQL_MODE_NONE = 0;    // Prior to MySQL 5.6.6
    const MYSQL_SQL_MODE_566 = 1;
    const MYSQL_SQL_MODE_570 = 2;
    const MYSQL_SQL_MODE_575 = 3;
    const MYSQL_SQL_MODE_577 = 4;
    const MYSQL_SQL_MODE_578 = 5;
    const MYSQL_SQL_MODE_800 = 6;

    /**
     * @var string
     */
    protected $_host = '';

    /**
     * @var string
     */
    protected $_name = '';

    /**
     * @var string
     */
    protected $_user = '';

    /**
     * @var string
     */
    protected $_pass = '';

    /**
     * @var string
     */
    protected $_tablePrefix = '';

    /**
     * @var Mysqli
     */
    private $_db;

    /**
     * @var bool
     */
    protected $_verbose = false;

    /**
     * @var bool
     */
    protected $_display_error = false;

    /**
     * @var string|callable
     */
    protected $_errorlog_fn = '';

    /**
     * @var string
     */
    protected $_charset = '';

    /**
     * @var int
     */
    protected $_mysql_version = 0;

    /**
     * @var bool
     */
    protected $_use_innodb = false;

    /**
     * @var int
     */
    protected $sqlMode = self::MYSQL_SQL_MODE_NONE;

    /**
     * Logs messages
     * Logs messages by calling the function held in $_errorLog_fn
     *
     * @param  string  $msg  Message to log
     * @access   private
     */
    protected function _errorLog($msg)
    {
        call_user_func($this->_errorlog_fn, $msg);
    }

    /**
     * Connects to the MySQL database server
     * This function connects to the MySQL server
     */
    private function _connect()
    {
        global $_TABLES, $use_innodb;

        if ($this->_verbose) {
            $this->_errorLog("\n*** Inside database->_connect ***");
        }

        // Connect to MySQL server
        $this->_db = new Mysqli($this->_host, $this->_user, $this->_pass);

        if (!$this->_db instanceof Mysqli) {
            die('Cannot connect to DB server');
        }

        $this->_mysql_version = $this->_db->server_version;

        // Set the database
        if (!$this->_db->select_db($this->_name)) {
            die('error selecting database');
        }

        if (!$this->_db) {
            if ($this->_verbose) {
                $this->_errorLog("\n*** Error in database->_connect ***");
            }

            // damn, got an error.
            $this->dbError();
        }

        // Set the character set
        $this->setCharset();

        // Checks if db engine is InnoDB.  During the installation
        // $_TABLES['vars'] is not yet created, so we use $use_innodb instead.
        if (isset($use_innodb)) {
            $this->_use_innodb = (bool) $use_innodb;
        } else {
            if ($this->dbTableExists('vars')) {
                $result = $this->dbQuery("SELECT value FROM {$_TABLES['vars']} WHERE (name = 'database_engine')");

                if (($result !== false) && ($this->dbNumRows($result) == 1)) {
                    $A = $this->dbFetchArray($result, false);
                    $this->_use_innodb = (strcasecmp($A['value'], 'InnoDB') === 0);
                }
            }
        }

        if ($this->_verbose) {
            $this->_errorLog("\n***leaving database->_connect***");
        }
    }

    /**
     * Set character set
     *
     * @return bool true on success, false otherwise
     */
    private function setCharset()
    {
        $charset = strtolower($this->_charset);

        if (!in_array($charset, ['utf-8', 'utf8', 'utf8mb4'])) {
            return true;
        }

        if ($charset === 'utf-8') {          // before GL-2.1.2
            $charset = 'utf8';
        } elseif ($charset === 'utf8mb4') { // since GL-2.1.2
            if ($this->_mysql_version < 50503) {
                $charset = 'utf8';
            }
        }

        $this->_charset = $charset;
        $retval = false;

        if (method_exists($this->_db, 'set_charset')) {
            $retval = @$this->_db->set_charset($charset);
        }

        if (!$retval) {
            $retval = @$this->_db->query("SET NAMES '{$this->_charset}'");
        }

        return $retval;
    }

    /**
     * Set MySQL sql_mode
     *
     * @param  int  $mode  one of SQL_MODE_xxx constants
     */
    public function setSqlMode($mode)
    {
        $mode = (int) $mode;

        if (($mode >= self::MYSQL_SQL_MODE_NONE) && ($mode <= self::MYSQL_SQL_MODE_800)) {
            $this->sqlMode = $mode;
        } else {
            throw new InvalidArgumentException(__METHOD__ . ': bad argument was given');
        }
    }

    /**
     * Return sql_mode string the current MySQL server accepts
     *
     * @return string
     */
    protected function getMysqlSqlModeString()
    {
        $sqlModes = [
            self::MYSQL_SQL_MODE_NONE => [],
            self::MYSQL_SQL_MODE_566  => [
                'NO_ENGINE_SUBSTITUTION',
            ],
            self::MYSQL_SQL_MODE_570  => [
                'NO_ENGINE_SUBSTITUTION',
            ],
            self::MYSQL_SQL_MODE_575  => [
                'ONLY_FULL_GROUP_BY', 'STRICT_TRANS_TABLES', 'NO_ENGINE_SUBSTITUTION',
            ],
            self::MYSQL_SQL_MODE_577  => [
                'ONLY_FULL_GROUP_BY', 'STRICT_TRANS_TABLES', 'NO_AUTO_CREATE_USER', 'NO_ENGINE_SUBSTITUTION',
            ],
            self::MYSQL_SQL_MODE_578  => [
                'ONLY_FULL_GROUP_BY', 'STRICT_TRANS_TABLES', 'NO_ZERO_IN_DATE', 'NO_ZERO_DATE',
                'ERROR_FOR_DIVISION_BY_ZERO', 'NO_AUTO_CREATE_USER', 'NO_ENGINE_SUBSTITUTION',
            ],
            self::MYSQL_SQL_MODE_800  => [
                'ONLY_FULL_GROUP_BY', 'STRICT_TRANS_TABLES', 'NO_ZERO_IN_DATE', 'NO_ZERO_DATE',
                'ERROR_FOR_DIVISION_BY_ZERO', 'NO_AUTO_CREATE_USER', 'NO_ENGINE_SUBSTITUTION',
            ],
        ];

        if ($this->_mysql_version < 50606) {
            $currentMode = self::MYSQL_SQL_MODE_NONE;
        } elseif (($this->_mysql_version >= 50606) && ($this->_mysql_version < 50700)) {
            $currentMode = self::MYSQL_SQL_MODE_566;
        } elseif (($this->_mysql_version >= 50700) && ($this->_mysql_version < 50705)) {
            $currentMode = self::MYSQL_SQL_MODE_570;
        } elseif (($this->_mysql_version >= 50705) && ($this->_mysql_version < 50707)) {
            $currentMode = self::MYSQL_SQL_MODE_575;
        } elseif (($this->_mysql_version >= 50707) && ($this->_mysql_version < 50708)) {
            $currentMode = self::MYSQL_SQL_MODE_577;
        } elseif (($this->_mysql_version >= 50708) && ($this->_mysql_version < 80000)) {
            $currentMode = self::MYSQL_SQL_MODE_578;
        } else {
            $currentMode = self::MYSQL_SQL_MODE_800;
        }

        $allowedMode = min($this->sqlMode, $currentMode);

        return implode(', ', $sqlModes[$allowedMode]);
    }

    /**
     * Return if a given table exists in the current database
     *
     * @param  string  $tableName
     * @param  int     $ignoreErrors
     * @return bool
     */
    public function dbTableExists($tableName, $ignoreErrors = 0)
    {
        global $_TABLES;

        $result = $this->dbQuery("SHOW TABLES LIKE '{$_TABLES[$tableName]}'", $ignoreErrors);

        return ($this->dbNumRows($result) > 0);
    }

    /**
     * Return if we can connect to MySQL server with the info given
     *
     * @param  string  $host
     * @param  string  $user
     * @param  string  $pass
     * @param  string  $database
     * @return int     0 = failed to connect, 1 = failed to select database, 2 = succeeded
     */
    public static function tryConnect($host, $user, $pass, $database)
    {
        // Connect to MySQL server
        $conn = new Mysqli($host, $user, $pass);

        if (!$conn instanceof Mysqli) {
            return 0;
        }

        $retval = $conn->select_db($database) ? 2 : 1;
        $conn->close();
        $conn = null;

        return $retval;
    }

    /**
     * constructor for database class
     * This initializes an instance of the database object
     *
     * @param  string  $dbhost       Database host
     * @param  string  $dbname       Name of database
     * @param  string  $dbuser       User to make connection as
     * @param  string  $dbpass       Password for dbuser
     * @param  string  $tablePrefix  Table prefix
     * @param  string  $errorlogfn   Name of the errorlog function
     * @param  string  $charset      Character set to use
     */
    public function __construct($dbhost, $dbname, $dbuser, $dbpass, $tablePrefix, $errorlogfn = '', $charset = '')
    {
        $this->_host = $dbhost;
        $this->_name = $dbname;
        $this->_user = $dbuser;
        $this->_pass = $dbpass;
        $this->_tablePrefix = $tablePrefix;
        $this->_verbose = false;
        $this->setErrorFunction($errorlogfn);
        $this->_charset = strtolower($charset);
        $this->_mysql_version = 0;
        $this->_use_innodb = false;

        $this->_connect();
        $this->_db->query("SET SESSION sql_mode = '" . $this->getMysqlSqlModeString() . "'");
    }

    /**
     * Turns debug mode on
     * Set this to TRUE to see debug messages
     *
     * @param  bool  $flag
     */
    public function setVerbose($flag)
    {
        $this->_verbose = (bool) $flag;
    }

    /**
     * Turns detailed error reporting on
     * If set to TRUE, this will display detailed error messages on the site.
     * Otherwise, it will only that state an error occurred without going into
     * details. The complete error message (including the offending SQL request)
     * is always available from error.log.
     *
     * @param  bool  $flag
     */
    public function setDisplayError($flag)
    {
        $this->_display_error = (bool) $flag;
    }

    /**
     * Checks to see if debug mode is on
     * Returns value of $_verbose
     *
     * @return   bool     TRUE if in verbose mode otherwise FALSE
     */
    public function isVerbose()
    {
        if ($this->_verbose
            && (empty($this->_errorlog_fn) || !function_exists($this->_errorlog_fn))
        ) {
            echo "\n<br" . XHTML . "><b>Can't run mysqli.class.php verbosely because the errorlog "
                . "function wasn't set or doesn't exist</b><br" . XHTML . ">\n";

            return false;
        }

        return $this->_verbose && COM_isEnableDeveloperModeLog('database');
    }

    /**
     * Default logger when COM_errorLog is not available
     *
     * @param  string  $msg
     */
    public function defaultLogger($msg)
    {
        if (is_callable('error_log')) {
            $msg .= PHP_EOL;
            error_log($msg, 0);
        } else {
            if (!headers_sent()) {
                header('Content-Type: text/html; charset=utf-8');
            }

            echo nl2br($msg) . '<br>' . PHP_EOL;
        }
    }

    /**
     * Sets the function this class should call to log debug messages
     *
     * @param  string  $functionName  Function name
     */
    public function setErrorFunction($functionName)
    {
        if (is_callable($functionName)) {
            $this->_errorlog_fn = $functionName;
        } else {
            $this->_errorlog_fn = [$this, 'defaultLogger'];
        }
    }

    /**
     * Fix an SQL statement containing "CREATE TABLE"
     *
     * @param  string  $sql
     * @return string
     */
    protected function fixCreateSQL($sql)
    {
        if (preg_match('/^\s*create\s\s*table\s/i', $sql)) {
            $p = strrpos($sql, ')');

            if ($p !== false) {
                $option = substr($sql, $p + 1);

                if (($option !== '') && ($option !== false)) {
                    // Replaces engine type
                    $sql = substr($sql, 0, $p + 1);
                    $option = rtrim($option, " \t\n\r\0\x0b;");
                    $option = str_ireplace('type', 'ENGINE', $option);

                    if ($this->_use_innodb === true) {
                        $option = str_ireplace('MyISAM', 'InnoDB ROW_FORMAT=DYNAMIC', $option);
                    }
                } else {
                    // Appends engine type
                    $option = ' ENGINE='
                        . (($this->_use_innodb === true) ? 'InnoDB ROW_FORMAT=DYNAMIC' : 'MyISAM');
                }

                // Appends default charset if necessary
                if ((($this->_charset === 'utf8') || ($this->_charset === 'utf8mb4')) &&
                    !preg_match('/DEFAULT\s+(CHARSET|CHARACTER\s+SET)/i', $option)
                ) {
                    $option .= " DEFAULT CHARSET={$this->_charset}";
                }

                $sql .= $option;
            }
        }

        return $sql;
    }

    /**
     * Executes a query on the MySQL server
     * This executes the passed SQL and returns the recordset or errors out
     *
     * @param  string  $sql            SQL to be executed
     * @param  int     $ignore_errors  If 1 this function suppresses any error messages
     * @return   mysqli_result|bool       Returns results of query
     */
    public function dbQuery($sql, $ignore_errors = 0)
    {
        if ($this->_verbose) {
            $this->_errorLog("\n***inside database->dbQuery***");
            $this->_errorLog("\n*** sql to execute is $sql ***");
        }

        $sql = $this->fixCreateSQL($sql);

        // Run query
        if ($ignore_errors) {
            $result = @$this->_db->query($sql);
        } else {
            $result = @$this->_db->query($sql);

            if ($result === false) {
                trigger_error($this->dbError($sql), E_USER_ERROR);
            }
        }

        // If OK, return otherwise echo error
        if ($this->_db->errno == 0 && ($result !== false)) {
            if ($this->_verbose) {
                $this->_errorLog("\n***sql ran just fine***");
                $this->_errorLog("\n*** Leaving database->dbQuery ***");
            }

            return $result;
        } else {
            // callee may want to suppress printing of errors
            if ($ignore_errors) {
                return false;
            }

            // Log errors
            $this->dbError($sql);

            if ($this->_verbose) {
                $this->_errorLog("\n***sql caused an error***");
                $this->_errorLog("\n*** Leaving database->dbQuery ***");
            }

            return false;
        }
    }

    /**
     * Saves information to the database
     * This will use a REPLACE INTO to save a record into the
     * database
     *
     * @param  string  $table   The table to save to
     * @param  string  $fields  string  Comma-delimited list of fields to save
     * @param  string  $values  Values to save to the database table
     */
    public function dbSave($table, $fields, $values)
    {
        if ($this->_verbose) {
            $this->_errorLog("\n*** Inside database->dbSave ***");
        }

        $sql = "REPLACE INTO $table ($fields) VALUES ($values)";
        $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorLog("\n*** Leaving database->dbSave ***");
        }
    }

    /**
     * Builds a pair of a column name and a value that can be used as a part of an SQL
     *
     * @param  mixed|array  $id
     * @param  mixed|array  $value
     * @return  mixed         string = column_name-value pair(s), FALSE = error
     */
    private function _buildIdValuePair($id, $value)
    {
        $retval = '';

        if (is_array($id) || is_array($value)) {
            $num_ids = count($id);

            if (is_array($id) && is_array($value) && ($num_ids === count($value))) {
                // they are arrays, traverse them and build sql
                $retval .= ' WHERE ';

                for ($i = 1; $i <= $num_ids; $i++) {
                    $retval .= current($id) . " = '" . current($value) . "'";
                    if ($i !== $num_ids) {
                        $retval .= " AND ";
                    }

                    next($id);
                    next($value);
                }
            } else {
                // error, they both have to be arrays and of the same size
                $retval = false;
            }
        } else {
            // just regular string values, build sql
            if (!empty($id) && (isset($value) || ($value != ''))) {
                $retval .= " WHERE $id = '$value'";
            }
        }

        return $retval;
    }

    /**
     * Deletes data from the database
     * This will delete some data from the given table where id = value.  If
     * id and value are arrays then it will traverse the arrays setting
     * $id[curval] = $value[curval].
     *
     * @param  string        $table  Table to delete data from
     * @param  array|string  $id     field name(s) to include in where clause
     * @param  array|string  $value  field value(s) corresponding to field names
     * @return   bool     Returns TRUE on success otherwise FALSE
     */
    public function dbDelete($table, $id, $value)
    {
        if ($this->_verbose) {
            $this->_errorLog("\n*** inside database->dbDelete ***");
        }

        $sql = "DELETE FROM {$table}";
        $id_and_value = $this->_buildIdValuePair($id, $value);

        if ($id_and_value === false) {
            return false;
        } else {
            $sql .= $id_and_value;
        }

        $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorLog("\n*** inside database->dbDelete ***");
        }

        return true;
    }

    /**
     * Changes records in a table
     * This will change the data in the given table that meet the given criteria and will
     * redirect user to another page if told to do so
     *
     * @param  string        $table            Table to perform change on
     * @param  string        $item_to_set      field name of unique ID field for table
     * @param  string        $value_to_set     Value for id
     * @param  array|string  $id               additional field name used in where clause
     * @param  array|string  $value            additional values used in where clause
     * @param  bool          $suppress_quotes  if FALSE it will not use '<value>' in where clause
     * @return   bool     Returns TRUE on success otherwise FALSE
     */
    public function dbChange($table, $item_to_set, $value_to_set, $id, $value,
                             $suppress_quotes = false)
    {
        if ($this->_verbose) {
            $this->_errorLog("\n*** Inside dbChange ***");
        }

        if ($suppress_quotes) {
            $sql = "UPDATE $table SET $item_to_set = $value_to_set";
        } else {
            $sql = "UPDATE $table SET $item_to_set = '$value_to_set'";
        }

        $id_and_value = $this->_buildIdValuePair($id, $value);

        if ($id_and_value === false) {
            return false;
        } else {
            $sql .= $id_and_value;
        }

        if ($this->_verbose) {
            $this->_errorLog("dbChange sql = $sql");
        }

        $retval = $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorLog("\n*** Leaving database->dbChange ***");
        }

        return $retval;
    }

    /**
     * Returns the number of records for a query that meets the given criteria
     * This will build a SELECT count(*) statement with the given criteria and
     * return the result
     *
     * @param  string        $table  Table to perform count on
     * @param  array|string  $id     field name(s) of fields to use in where clause
     * @param  array|string  $value  Value(s) to use in where clause
     * @return   int|bool            returns count on success otherwise FALSE
     */
    public function dbCount($table, $id = '', $value = '')
    {
        if ($this->_verbose) {
            $this->_errorLog("\n*** Inside database->dbCount ***");
        }

        $sql = "SELECT COUNT(*) FROM {$table}";
        $id_and_value = $this->_buildIdValuePair($id, $value);

        if ($id_and_value === false) {
            return false;
        } else {
            $sql .= $id_and_value;
        }

        if ($this->_verbose) {
            $this->_errorLog("\n*** sql = $sql ***");
        }

        $result = $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorLog("\n*** Leaving database->dbCount ***");
        }

        return (int) $this->dbResult($result, 0);
    }

    /**
     * Copies a record from one table to another (can be the same table)
     * This will use a REPLACE INTO...SELECT FROM to copy a record from one table
     * to another table.  They can be the same table.
     *
     * @param  string        $table      Table to insert record into
     * @param  string        $fields     Comma delmited list of fields to copy over
     * @param  string        $values     Values to store in database fields
     * @param  string        $tableFrom  Table to get record from
     * @param  array|string  $id         field name(s) to use in where clause
     * @param  array|string  $value      Value(s) to use in where clause
     * @return   bool     Returns TRUE on success otherwise FALSE
     */
    public function dbCopy($table, $fields, $values, $tableFrom, $id, $value)
    {
        if ($this->_verbose) {
            $this->_errorLog("\n*** Inside database->dbCopy ***");
        }

        $sql = "REPLACE INTO $table ($fields) SELECT $values FROM $tableFrom";
        $id_and_value = $this->_buildIdValuePair($id, $value);

        if ($id_and_value === false) {
            return false;
        } else {
            $sql .= $id_and_value;
        }

        $retval = $this->dbQuery($sql);
        $retval = $retval && $this->dbDelete($tableFrom, $id, $value);

        if ($this->_verbose) {
            $this->_errorLog("\n*** Leaving database->dbCopy ***");
        }

        return $retval;
    }

    /**
     * Retrieves the number of rows in a recordset
     * This returns the number of rows in a recordset
     *
     * @param  mysqli_result  $recordSet  The record set to operate one
     * @return   int           Returns number of rows otherwise FALSE (0)
     */
    public function dbNumRows($recordSet)
    {
        if ($this->_verbose) {
            $this->_errorLog("\n*** Inside database->dbNumRows ***");
        }

        // return only if record set exists, otherwise 0
        if ($recordSet instanceof mysqli_result) {
            if ($this->_verbose) {
                $this->_errorLog('got ' . $recordSet->num_rows . ' rows');
                $this->_errorLog("\n*** Inside database->dbNumRows ***");
            }

            return $recordSet->num_rows;
        } else {
            if ($this->_verbose) {
                $this->_errorLog("got no rows");
                $this->_errorLog("\n*** Inside database->dbNumRows ***");
            }

            return 0;
        }
    }

    /**
     * Returns the contents of one cell from a MySQL result set
     *
     * @param  mysqli_result  $recordSet  The recordset to operate on
     * @param  int            $row        row to get data from
     * @param  mixed          $field      field to return
     * @return   mixed (depends on field content)
     */
    public function dbResult($recordSet, $row, $field = 0)
    {
        if ($this->_verbose) {
            $this->_errorLog("\n*** Inside database->dbResult ***");

            if (empty($recordSet)) {
                $this->_errorLog("\n*** Passed recordset isn't valid ***");
            } else {
                $this->_errorLog("\n*** Everything looks good ***");
            }

            $this->_errorLog("\n*** Leaving database->dbResult ***");
        }

        $retval = '';

        if ($recordSet->data_seek($row)) {
            if (is_numeric($field)) {
                $field = intval($field, 10);
                $row = $recordSet->fetch_row();
            } else {
                $row = $recordSet->fetch_assoc();
            }

            if (($row !== null) && isset($row[$field])) {
                $retval = $row[$field];
            }
        }

        return $retval;
    }

    /**
     * Retrieves the number of fields in a recordset
     * This returns the number of fields in a recordset
     *
     * @param  mysqli_result  $recordSet  The recordset to operate on
     * @return  int     Returns number of rows from query
     */
    public function dbNumFields($recordSet)
    {
        return $recordSet->field_count;
    }

    /**
     * Retrieves returns the field name for a field
     * Returns the field name for a given field number
     *
     * @param  mysqli_result  $recordSet    The recordset to operate on
     * @param  int            $fieldNumber  field number to return the name of
     * @return   string      Returns name of specified field
     */
    public function dbFieldName($recordSet, $fieldNumber)
    {
        $result = $recordSet->fetch_field_direct($fieldNumber);

        return ($result === false) ? '' : $result->name;
    }

    /**
     * Retrieves returns the number of effected rows for last query
     * Retrieves returns the number of effected rows for last query
     *
     * @param  mysqli_result  $recordSet  The record set to operate on
     * @return   int     Number of rows affected by last query
     */
    public function dbAffectedRows($recordSet)
    {
        return $this->_db->affected_rows;
    }

    /**
     * Retrieves record from a record set
     * Gets the next record in a record set and returns in array
     *
     * @param  mysqli_result  $recordSet  The record set to operate on
     * @param  bool           $both       get both assoc and numeric indices
     * @return   array|false              Returns data array of current row from record set
     */
    public function dbFetchArray($recordSet, $both = false)
    {
        if ($recordSet instanceof mysqli_result) {
            $result_type = $both ? MYSQLI_BOTH : MYSQLI_ASSOC;
            $result = $recordSet->fetch_array($result_type);

            return ($result === null) ? false : $result;
        } else {
            return false;
        }
    }

    /**
     * Returns the last ID inserted
     * Returns the last auto_increment ID generated
     *
     * @param  resource  $link_identifier  identifier for opened link
     * @param  string    $sequence
     * @return   int                             Returns last auto-generated ID
     */
    public function dbInsertId($link_identifier = null, $sequence = '')
    {
        return $this->_db->insert_id;
    }

    /**
     * returns a database error string
     * Returns an database error message
     *
     * @param  string  $sql  SQL that may have caused the error
     * @return   string      Text for error message
     */
    public function dbError($sql = '')
    {
        if ($this->_db->errno) {
            $fn = '';
            $btr = debug_backtrace();

            if (!empty($btr)) {
                for ($i = 0; $i < 100; $i++) {
                    if (isset($btr[$i])) {
                        $b = $btr[$i];

                        if ($b['function'] == 'DB_query') {
                            if (!empty($b['file']) && !empty($b['line'])) {
                                $fn = $b['file'] . ':' . $b['line'];
                            }
                            break;
                        }
                    } else {
                        break;
                    }
                }
            }

            if (empty($fn)) {
                $this->_errorLog($this->_db->errno . ': ' . $this->_db->error . ". SQL in question: $sql");
            } else {
                $this->_errorLog($this->_db->errno . ': ' . $this->_db->error . " in $fn. SQL in question: $sql");
            }

            if ($this->_display_error) {
                return $this->_db->errno . ': ' . $this->_db->error;
            } else {
                return 'An SQL error has occurred. Please see error.log for details.';
            }
        }

        return '';
    }

    /**
     * Lock a table/tables
     * Locks a table for write operations
     *
     * @param  string|string[]  $table  Table to lock
     * @see dbUnlockTable
     */
    public function dbLockTable($table)
    {
        if ($this->_verbose) {
            $this->_errorLog("\n*** Inside database->dbLockTable ***");
        }

        if (is_string($table)) {
            $sql = "LOCK TABLES {$table} WRITE";
        } else {
            foreach ($table as &$t) {
                $t = $t . ' WRITE';
            }
            unset($t);

            $sql = "LOCK TABLES " . implode(', ', $table);
        }

        $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorLog("\n*** Leaving database->dbLockTable ***");
        }
    }

    /**
     * Unlock a table/tables
     * Unlocks a table/tables after a dbLockTable (actually, unlocks all tables)
     *
     * @param  string  $table  Table to unlock (ignored)
     * @see dbLockTable
     */
    public function dbUnlockTable($table)
    {
        if ($this->_verbose) {
            $this->_errorLog("\n*** Inside database->dbUnlockTable ***");
        }

        $sql = 'UNLOCK TABLES';
        $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorLog("\n*** Leaving database->dbUnlockTable ***");
        }
    }

    /**
     * @return     string     the version of the database application
     */
    public function dbGetVersion()
    {
        return $this->_db->server_info;
    }

    /**
     * Start a new transaction
     *
     * @return bool true on success, false otherwise
     */
    public function dbStartTransaction()
    {
        if ($this->_use_innodb) {
            return $this->_db->autocommit(false);
        } else {
            return false;
        }
    }

    /**
     * Commit the current transaction
     *
     * @return bool true on success, false otherwise
     */
    public function dbCommit()
    {
        if ($this->_use_innodb) {
            return $this->_db->commit();
        } else {
            return false;
        }
    }

    /**
     * Rollback the current transaction
     *
     * @return bool true on success, false otherwise
     */
    public function dbRollBack()
    {
        if ($this->_use_innodb) {
            return $this->_db->rollback();
        } else {
            return false;
        }
    }

    /**
     * Escapes a string so that it can be safely used in a query
     *
     * @param  string  $str  a string to be escaped
     * @return  string
     */
    public function dbEscapeString($str)
    {
        return $this->_db->real_escape_string($str);
    }

    /**
     * Return if the database server supports InnoDB engine
     *
     * @return bool
     */
    public function isInnoDb()
    {
        return $this->_use_innodb;
    }

    /**
     * Check for InnoDB table support (usually as of MySQL 4.0, but may be
     * available in earlier versions, e.g. "Max" or custom builds).
     *
     * @return  bool true = InnoDB tables supported, false = not supported
     */
    public function isInnodbSupported()
    {
        $retval = false;

        $result = $this->dbQuery("SHOW ENGINES");
        $numEngines = $this->dbNumRows($result);

        for ($i = 0; $i < $numEngines; $i++) {
            $A = $this->dbFetchArray($result, false);

            if (strcasecmp($A['Engine'], 'InnoDB') === 0) {
                if ((strcasecmp($A['Support'], 'yes') === 0) ||
                    (strcasecmp($A['Support'], 'default') === 0)
                ) {
                    $retval = true;
                }

                break;
            }
        }

        return $retval;
    }

    /**
     * Return if MySQL server supports utf8mb4 charset
     *
     * @return bool
     */
    public function isUtf8mb4Supported()
    {
        return ($this->_db->server_version > 50503);
    }

    /**
     * Return a list of tables used for the Geeklog installation
     *
     * @return string[]
     */
    public function dbGetAllTables()
    {
        $retval = [];

        $result = $this->dbQuery("SHOW TABLES");

        if ($result !== false) {
            while (($A = $this->dbFetchArray($result)) !== false) {
                $retval[] = $A['Tables_in_' . $this->_name];
            }
        }

        return $retval;
    }

    /**
     * Return the structure of a table given
     *
     * @param  string  $tableName
     * @return string
     */
    public function dbGetTableStructure($tableName)
    {
        $result = $this->dbQuery("SHOW CREATE TABLE $tableName;");

        if (!empty($result)) {
            $A = $this->dbFetchArray($result);

            if (is_array($A) && isset($A['Create Table'])) {
                return $A['Create Table'];
            }
        }

        return '';
    }

    /**
     * Escape an identifier like a database name or a table name
     *
     * @param  string  $identifier
     * @return string
     */
    public function dbEscapeIdentifier($identifier)
    {
        if (!empty($identifier) && ($identifier !== '*')) {
            $identifier = '`' . $identifier . '`';
        }

        return $identifier;
    }

    /**
     * Optimize a table
     *
     * @param  string  $tableName
     * @return bool
     */
    public function dbOptimizeTable($tableName)
    {
        return DB_query("OPTIMIZE TABLE $tableName");
    }
}
