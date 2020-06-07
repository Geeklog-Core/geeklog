<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | DbMysql.php                                                               |
// |                                                                           |
// | mysql database class                                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2020 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony AT tonybibbs DOT com                            |
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

/**
 * This file is the mysql implementation of the Geeklog abstraction layer.
 * Unfortunately the Geeklog abstraction layer isn't 100% abstract because a few
 * key functions use MySQL's REPLACE INTO syntax which is not a SQL standard.
 * This issue will need to be resolved some time ...
 */
class DbMysql extends DbMysqli
{
    /**
     * @var resource|false
     */
    private $_db = '';

    /**
     * Connects to the MySQL database server
     * This function connects to the MySQL server and returns the connection object
     */
    private function _connect()
    {
        global $_TABLES, $use_innodb;

        if ($this->isVerbose()) {
            $this->_errorLog("\n*** Inside database->_connect ***");
        }

        // Connect to MySQL server
        $this->_db = mysql_connect($this->_host, $this->_user, $this->_pass) or die('Cannot connect to DB server');

        if ($this->_mysql_version == 0) {
            $v = mysql_get_server_info();
            preg_match('/^([0-9]+).([0-9]+).([0-9]+)/', $v, $match);
            $v = (intval($match[1]) * 10000) + (intval($match[2]) * 100)
                + intval($match[3]);
            $this->_mysql_version = $v;
        }

        // Set the database
        @mysql_select_db($this->_name) or die('error selecting database');

        if (!($this->_db)) {
            if ($this->isVerbose()) {
                $this->_errorLog("\n*** Error in database->_connect ***");
            }

            // damn, got an error.
            $this->dbError();
        }

        // Set character set
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

        if ($this->isVerbose()) {
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

        if (!in_array($charset, array('utf-8', 'utf8', 'utf8mb4'))) {
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

        if (($this->_mysql_version >= 50007) && function_exists('mysql_set_charset')) {
            $retval = @mysql_set_charset($charset, $this->_db);

            if (!$retval) {
                $retval = @mysql_query("SET NAMES '{$charset}''");
            }
        } else {
            $retval = @mysql_query("SET NAMES '{$charset}''");
        }

        return $retval;
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
        $conn = @mysql_connect($host, $user, $pass);
        if ($conn === false) {
            return 0;
        }

        $retval = mysql_select_db($database, $conn) ? 2 : 1;
        mysql_close($conn);

        return $retval;
    }

    /**
     * constructor for database
     * This initializes an instance of the database object
     *
     * @param        string $dbhost      Database host
     * @param        string $dbname      Name of database
     * @param        string $dbuser      User to make connection as
     * @param        string $dbpass      Password for dbuser
     * @param        string $tablePrefix Table prefix
     * @param        string $errorlogfn  Name of the errorlog function
     * @param        string $charset     Character set to use
     * @noinspection PhpMissingParentConstructorInspection
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
        mysql_query("SET SESSION sql_mode = '" . $this->getMysqlSqlModeString() . "'", $this->_db);
    }

    /**
     * Executes a query on the MySQL server
     * This executes the passed SQL and returns the recordset or errors out
     *
     * @param    string $sql           SQL to be executed
     * @param    int    $ignore_errors If 1 this function suppresses any error messages
     * @return   resource|bool Returns results of query
     */
    public function dbQuery($sql, $ignore_errors = 0)
    {
        if ($this->isVerbose()) {
            $this->_errorLog("\n***inside database->dbQuery***");
            $this->_errorLog("\n*** sql to execute is $sql ***");
        }

        $sql = $this->fixCreateSQL($sql);

        // Run query
        if ($ignore_errors) {
            $result = @mysql_query($sql, $this->_db);
        } else {
            $result = @mysql_query($sql, $this->_db) or trigger_error($this->dbError($sql), E_USER_ERROR);
        }

        // If OK, return otherwise echo error
        if (mysql_errno() == 0 && !empty($result)) {
            if ($this->isVerbose()) {
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

            if ($this->isVerbose()) {
                $this->_errorLog("\n***sql caused an error***");
                $this->_errorLog("\n*** Leaving database->dbQuery ***");
            }

            return false;
        }
    }

    /**
     * Retrieves the number of rows in a recordset
     * This returns the number of rows in a recordset
     *
     * @param    resource $recordSet The recordset to operate one
     * @return   int         Returns number of rows otherwise false (0)
     */
    public function dbNumRows($recordSet)
    {
        if ($this->isVerbose()) {
            $this->_errorLog("\n*** Inside database->dbNumRows ***");
        }

        // return only if recordset exists, otherwise 0
        if ($recordSet) {
            if ($this->isVerbose()) {
                $this->_errorLog('got ' . @mysql_numrows($recordSet) . ' rows');
                $this->_errorLog("\n*** Inside database->dbNumRows ***");
            }

            return @mysql_numrows($recordSet);
        } else {
            if ($this->isVerbose()) {
                $this->_errorLog("got no rows");
                $this->_errorLog("\n*** Inside database->dbNumRows ***");
            }

            return 0;
        }
    }

    /**
     * Returns the contents of one cell from a MySQL result set
     *
     * @param    resource $recordSet The recordset to operate on
     * @param    int      $row       row to get data from
     * @param    mixed    $field     field to return
     * @return   mixed  (depends on field content)
     */
    public function dbResult($recordSet, $row, $field = 0)
    {
        if ($this->isVerbose()) {
            $this->_errorLog("\n*** Inside database->dbResult ***");

            if (empty($recordSet)) {
                $this->_errorLog("\n*** Passed recordset isn't valid ***");
            } else {
                $this->_errorLog("\n*** Everything looks good ***");
            }

            $this->_errorLog("\n*** Leaving database->dbResult ***");
        }

        return @mysql_result($recordSet, $row, $field);
    }

    /**
     * Retrieves the number of fields in a record set
     * This returns the number of fields in a record set
     *
     * @param    resource $recordSet The record set to operate on
     * @return   int     Returns number of rows from query
     */
    public function dbNumFields($recordSet)
    {
        $retval = @mysql_num_fields($recordSet);

        if ($retval === false) {
            $retval = 0;
        }

        return $retval;
    }

    /**
     * Retrieves returns the field name for a field
     * Returns the field name for a given field number
     *
     * @param    resource $recordSet   The recordset to operate on
     * @param    int      $fieldNumber field number to return the name of
     * @return   string   Returns name of specified field
     */
    public function dbFieldName($recordSet, $fieldNumber)
    {
        return @mysql_field_name($recordSet, (int) $fieldNumber);
    }

    /**
     * Retrieves returns the number of effected rows for last query
     * Retrieves returns the number of effected rows for last query
     *
     * @param    resource $recordSet The recordset to operate on
     * @return   int     Number of rows affected by last query
     */
    public function dbAffectedRows($recordSet)
    {
        return @mysql_affected_rows($this->_db);
    }

    /**
     * Retrieves record from a recordset
     * Gets the next record in a recordset and returns in array
     *
     * @param    resource $recordSet The record set to operate on
     * @param    bool     $both      get both assoc and numeric indices
     * @return   array|false         Returns data array of current row from record set
     */
    public function dbFetchArray($recordSet, $both = false)
    {
        if (is_resource($recordSet)) {
            if ($both) {
                $result_type = MYSQL_BOTH;
            } else {
                $result_type = MYSQL_ASSOC;
            }

            return @mysql_fetch_array($recordSet, $result_type);
        } else {
            return false;
        }
    }

    /**
     * Returns the last ID inserted
     * Returns the last auto_increment ID generated
     *
     * @param    resource $link_identifier identifier for opened link
     * @return   int                             Returns last auto-generated ID
     */
    public function dbInsertId($link_identifier = null, $sequence = '')
    {
        if (empty($link_identifier)) {
            return @mysql_insert_id($this->_db);
        } else {
            return @mysql_insert_id($link_identifier);
        }
    }

    /**
     * returns a database error string
     * Returns an database error message
     *
     * @param    string $sql SQL that may have caused the error
     * @return   string      Text for error message
     */
    public function dbError($sql = '')
    {
        if (mysql_errno()) {
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
                $this->_errorLog(@mysql_errno() . ': ' . @mysql_error() . ". SQL in question: $sql");
            } else {
                $this->_errorLog(@mysql_errno() . ': ' . @mysql_error() . " in $fn. SQL in question: $sql");
            }

            if ($this->_display_error) {
                return @mysql_errno() . ': ' . @mysql_error();
            } else {
                return 'An SQL error has occurred. Please see error.log for details.';
            }
        }

        return '';
    }

    /**
     * @return     string     the version of the database application
     */
    public function dbGetVersion()
    {
        return @mysql_get_server_info();
    }

    /**
     * Start a new transaction
     *
     * @return bool true on success, false otherwise
     */
    public function dbStartTransaction()
    {
        if ($this->_use_innodb) {
            return $this->dbQuery("START TRANSACTION") && $this->dbQuery("BEGIN");
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
            return $this->dbQuery("COMMIT");
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
            return $this->dbQuery("ROLLBACK");
        } else {
            return false;
        }
    }

    /**
     * Escapes a string so that it can be safely used in a query
     *
     * @param   string $str a string to be escaped
     * @return  string
     */
    public function dbEscapeString($str)
    {
        return mysql_real_escape_string($str, $this->_db);
    }
}
