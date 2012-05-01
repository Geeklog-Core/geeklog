<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | mysqli.class.php                                                          |
// |                                                                           |
// | mysql database class with MySQLi extension                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
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

/**
* This file is the mysql implementation of the Geeklog abstraction layer.
* Unfortunately the Geeklog abstraction layer isn't 100% abstract because a few
* key functions use MySQL's REPLACE INTO syntax which is not a SQL standard.
* This issue will need to be resolved some time ...
*/
class database
{
    private $_host = '';
    private $_name = '';
    private $_user = '';
    private $_pass = '';
    private $_db = '';
    private $_verbose = FALSE;
    private $_display_error = FALSE;
    private $_errorlog_fn = '';
    private $_charset = '';
    private $_mysql_version = 0;

    /**
    * Logs messages
    *
    * Logs messages by calling the function held in $_errorlog_fn
    *
    * @param    string      $msg        Message to log
    * @access   private
    */
    private function _errorlog($msg)
    {
        $function = $this->_errorlog_fn;

        if (function_exists($function)) {
            $function($msg);
        }
    }

    /**
    * Connects to the MySQL database server
    *
    * This function connects to the MySQL server and returns the connection object
    *
    * @return   object      Returns connection object
    * @access   private
    */
    private function _connect()
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** Inside database->_connect ***");
        }

        // Connect to MySQL server
        $this->_db = new MySQLi($this->_host, $this->_user, $this->_pass) OR die('Cannot connect to DB server');
        $this->_mysql_version = $this->_db->server_version;

        // Set the database
        $this->_db->select_db($this->_name) OR die('error selecting database');

        if (!($this->_db)) {
            if ($this->_verbose) {
                $this->_errorlog("\n*** Error in database->_connect ***");
            }

            // damn, got an error.
            $this->dbError();
        }

        if ($this->_mysql_version >= 40100) {
            if ($this->_charset === 'utf-8') {
                $result = FALSE;

                if (method_exists($this->_db, 'set_charset')) {
                    $result = $this->_db->set_charset('utf8');
                }

                if (!$result) {
                    @$this->_db->query("SET NAMES 'utf8'");
                }
            }
        }

        if ($this->_verbose) {
            $this->_errorlog("\n***leaving database->_connect***");
        }
    }

    /**
    * constructor for database class
    *
    * This initializes an instance of the database object
    *
    * @param        string      $dbhost     Database host
    * @param        string      $dbname     Name of database
    * @param        sring       $dbuser     User to make connection as
    * @param        string      $pass       Password for dbuser
    * @param        string      $errorlogfn Name of the errorlog function
    * @param        string      $charset    character set to use
    */
    public function __construct($dbhost, $dbname, $dbuser, $dbpass, $errorlogfn = '',
        $charset = '')
    {
        $this->_host = $dbhost;
        $this->_name = $dbname;
        $this->_user = $dbuser;
        $this->_pass = $dbpass;
        $this->_verbose = FALSE;
        $this->_errorlog_fn = $errorlogfn;
        $this->_charset = strtolower($charset);
        $this->_mysql_version = 0;

        $this->_connect();
    }

    public function __destruct()
    {
        @$this->_db->close();
        $this->_db = NULL;
    }

    /**
    * Turns debug mode on
    *
    * Set this to TRUE to see debug messages
    *
    * @param    boolean     $flag
    */
    public function setVerbose($flag)
    {
        $this->_verbose = (bool) $flag;
    }

    /**
    * Turns detailed error reporting on
    *
    * If set to TRUE, this will display detailed error messages on the site.
    * Otherwise, it will only that state an error occurred without going into
    * details. The complete error message (including the offending SQL request)
    * is always available from error.log.
    *
    * @param    boolean     $flag
    */
    public function setDisplayError($flag)
    {
        $this->_display_error = (bool) $flag;
    }

    /**
    * Checks to see if debug mode is on
    *
    * Returns value of $_verbose
    *
    * @return   boolean     TRUE if in verbose mode otherwise FALSE
    */
    public function isVerbose()
    {
        if ($this->_verbose
         AND (empty($this->_errorlog_fn) OR !function_exists($this->_errorlog_fn))) {
            echo "\n<br" . XHTML . "><b>Can't run mysqli.class.php verbosely because the errorlog "
                . "function wasn't set or doesn't exist</b><br" . XHTML . ">\n";
            return FALSE;
        }

        return $this->_verbose;
    }

    /**
    * Sets the function this class should call to log debug messages
    *
    * @param        string      $functionname   Function name
    */
    public function setErrorFunction($functionname)
    {
        $this->_errorlog_fn = $functionname;
    }

    /**
    * Executes a query on the MySQL server
    *
    * This executes the passed SQL and returns the recordset or errors out
    *
    * @param    string      $sql            SQL to be executed
    * @param    boolean     $ignore_error   If 1 this function supresses any
    *                                       error messages
    * @return   object      Returns results of query
    */
    public function dbQuery($sql, $ignore_errors=0)
    {
        if ($this->_verbose) {
            $this->_errorlog("\n***inside database->dbQuery***");
            $this->_errorlog("\n*** sql to execute is $sql ***");
        }

        // Run query
        if ($ignore_errors == 1) {
            $result = @$this->_db->query($sql);
        } else {
            $result = @$this->_db->query($sql) OR trigger_error($this->dbError($sql), E_USER_ERROR);
        }

        // If OK, return otherwise echo error
        if ($this->_db->errno == 0 AND ($result !== FALSE)) {
            if ($this->_verbose) {
                $this->_errorlog("\n***sql ran just fine***");
                $this->_errorlog("\n*** Leaving database->dbQuery ***");
            }

            return $result;
        } else {
            // callee may want to supress printing of errors
            if ($ignore_errors == 1) {
                return FALSE;
            }

            if ($this->_verbose) {
                $this->_errorlog("\n***sql caused an error***");
                $this->_errorlog("\n*** Leaving database->dbQuery ***");
            }
        }
    }

    /**
    * Saves information to the database
    *
    * This will use a REPLACE INTO to save a record into the
    * database
    *
    * @param    string      $table      The table to save to
    * @param    string      $fields     string  Comma demlimited list of fields to save
    * @param    string      $values     Values to save to the database table
    */
    public function dbSave($table, $fields, $values)
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** Inside database->dbSave ***");
        }

        $sql = "REPLACE INTO $table ($fields) VALUES ($values)";

        $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorlog("\n*** Leaving database->dbSave ***");
        }
    }

    /**
    * Builds a pair of a column name and a value that can be used as a part of an SQL
    *
    * @param   scalar/array  $id
    * @param   scalar/array  $value
    * @return  mixed         string = column_name-value pair(s), FALSE = error
    */
    private function _buildIdValuePair($id, $value)
    {
        $retval = '';

        if (is_array($id) OR is_array($value)) {
            $num_ids = count($id);

            if (is_array($id) AND is_array($value) AND ($num_ids === count($value))) {
                // they are arrays, traverse them and build sql
                $retval .= ' WHERE ';

                for ($i = 1; $i <= $num_ids; $i ++) {
                    $retval .= current($id) . " = '"
                            .  $this->dbEscape(current($value)) . "'";
                    if ($i !== $num_ids) {
                        $retval .= " AND ";
                    }

                    next($id);
                    next($value);
                }
            } else {
                // error, they both have to be arrays and of the same size
                $retval = FALSE;
            }
        } else {
            // just regular string values, build sql
            if (!empty($id) AND (isset($value) OR ($value != ''))) { 
                $retval .= " WHERE $id = '$value'";
            }
        }

        return $retval;
    }

    /**
    * Deletes data from the database
    *
    * This will delete some data from the given table where id = value.  If
    * id and value are arrays then it will traverse the arrays setting
    * $id[curval] = $value[curval].
    *
    * @param    string          $table      Table to delete data from
    * @param    array|string    $id         field name(s) to include in where clause
    * @param    array|string    $value      field value(s) corresponding to field names
    * @return   boolean     Returns TRUE on success otherwise FALSE
    */
    public function dbDelete($table, $id, $value)
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** inside database->dbDelete ***");
        }

        $sql = "DELETE FROM $table";
        $id_and_value = $this->_buildIdValuePair($id, $value);

        if ($id_and_value === FALSE) {
            return FALSE;
        } else {
            $sql .= $id_and_value;
        }

        $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorlog("\n*** inside database->dbDelete ***");
        }

        return TRUE;
    }

    /**
    * Changes records in a table
    *
    * This will change the data in the given table that meet the given criteria and will
    * redirect user to another page if told to do so
    *
    * @param    string          $table          Table to perform change on
    * @param    string          $item_to_set    field name of unique ID field for table
    * @param    string          $value_to_set   Value for id
    * @param    array|string    $id             additional field name used in where clause
    * @param    array|string    $value          additional values used in where clause
    * @param    boolean         $supress_quotes if FALSE it will not use '<value>' in where clause
    * @return   boolean     Returns TRUE on success otherwise FALSE
    */
    public function dbChange($table, $item_to_set, $value_to_set, $id, $value,
        $supress_quotes = FALSE)
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** Inside dbChange ***");
        }

        if ($supress_quotes) {
            $sql = "UPDATE $table SET $item_to_set = $value_to_set";
        } else {
            $sql = "UPDATE $table SET $item_to_set = '$value_to_set'";
        } 

        $id_and_value = $this->_buildIdValuePair($id, $value);

        if ($id_and_value === FALSE) {
            return FALSE;
        } else {
            $sql .= $id_and_value;
        }

        if ($this->_verbose) {
            $this->_errorlog("dbChange sql = $sql");
        }

        $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorlog("\n*** Leaving database->dbChange ***");
        }
    }

    /**
    * Returns the number of records for a query that meets the given criteria
    *
    * This will build a SELECT count(*) statement with the given criteria and
    * return the result
    *
    * @param    string          $table  Table to perform count on
    * @param    array|string    $id     field name(s) of fields to use in where clause
    * @param    array|string    $value  Value(s) to use in where clause
    * @return   boolean     returns count on success otherwise FALSE
    *
    */
    public function dbCount($table, $id = '', $value = '')
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** Inside database->dbCount ***");
        }

        $sql = "SELECT COUNT(*) FROM $table";
        $id_and_value = $this->_buildIdValuePair($id, $value);

        if ($id_and_value === FALSE) {
            return FALSE;
        } else {
            $sql .= $id_and_value;
        }

        if ($this->_verbose) {
            $this->_errorlog("\n*** sql = $sql ***");
        }

        $result = $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorlog("\n*** Leaving database->dbCount ***");
        }

        return ($this->dbResult($result,0));
    }

    /**
    * Copies a record from one table to another (can be the same table)
    *
    * This will use a REPLACE INTO...SELECT FROM to copy a record from one table
    * to another table.  They can be the same table.
    *
    * @param    string          $table      Table to insert record into
    * @param    string          $fields     Comma delmited list of fields to copy over
    * @param    string          $values     Values to store in database fields
    * @param    string          $tablefrom  Table to get record from
    * @param    array|string    $id         field name(s) to use in where clause
    * @param    array|string    $value      Value(s) to use in where clause
    * @return   boolean     Returns TRUE on success otherwise FALSE
    */
    public function dbCopy($table, $fields, $values, $tablefrom, $id, $value)
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** Inside database->dbCopy ***");
        }

        $sql = "REPLACE INTO $table ($fields) SELECT $values FROM $tablefrom";
        $id_and_value = $this->_buildIdValuePair($id, $value);

        if ($id_and_value === FALSE) {
            return FALSE;
        } else {
            $sql .= $id_and_value;
        }

        $this->dbQuery($sql);
        $this->dbDelete($tablefrom,$id,$value);

        if ($this->_verbose) {
            $this->_errorlog("\n*** Leaving database->dbCopy ***");
        }
    }

    /**
    * Retrieves the number of rows in a recordset
    *
    * This returns the number of rows in a recordset
    *
    * @param    object      $recordset      The recordset to operate one
    * @return   int         Returns number of rows otherwise FALSE (0)
    */
    public function dbNumRows($recordset)
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** Inside database->dbNumRows ***");
        }

        // return only if recordset exists, otherwise 0
        if (strcasecmp(get_class($recordset), 'MySQLi_Result') === 0) {
            if ($this->_verbose) {
                $this->_errorlog('got ' . $recordset->num_rows . ' rows');
                $this->_errorlog("\n*** Inside database->dbNumRows ***");
            }

            return $recordset->num_rows;
        } else {
            if ($this->_verbose) {
                $this->_errorlog("got no rows");
                $this->_errorlog("\n*** Inside database->dbNumRows ***");
            }

            return 0;
        }
    }

    /**
    * Returns the contents of one cell from a MySQL result set
    *
    * @param    object      $recordset      The recordset to operate on
    * @param    int         $row            row to get data from
    * @param    string      $field          field to return
    * @return   (depends on field content)
    */
    public function dbResult($recordset, $row, $field = 0)
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** Inside database->dbResult ***");
            if (empty($recordset)) {
                $this->_errorlog("\n*** Passed recordset isn't valid ***");
            } else {
                $this->_errorlog("\n*** Everything looks good ***");
            }
            $this->_errorlog("\n*** Leaving database->dbResult ***");
        }

        $retval = '';

        if ($recordset->data_seek($row)) {
            $row = $recordset->fetch_row();

            if (($row !== NULL) AND ($field < count($row))) {
                $retval = $row[$field];
            }
        }

        return $retval;
    }

    /**
    * Retrieves the number of fields in a recordset
    *
    * This returns the number of fields in a recordset
    *
    * @param   MySQLi_Result object   $recordset      The recordset to operate on
    * @return  int     Returns number of rows from query
    */
    public function dbNumFields($recordset)
    {
        return $recordset->field_count;
    }

    /**
    * Retrieves returns the field name for a field
    *
    * Returns the field name for a given field number
    *
    * @param    object      $recordset      The recordset to operate on
    * @param    int         $fnumber        field number to return the name of
    * @return   string      Returns name of specified field
    *
    */
    public function dbFieldName($recordset,$fnumber)
    {
        $result = $recordset->fetch_field_direct($fnumber);

        return ($result === FALSE) ? '' : $result->name;
    }

    /**
    * Retrieves returns the number of effected rows for last query
    *
    * Retrieves returns the number of effected rows for last query
    *
    * @param    object      $recordset      The recordset to operate on
    * @return   int     Number of rows affected by last query
    */
    public function dbAffectedRows($recordset)
    {
        return $this->_db->affected_rows;
    }

    /**
    * Retrieves record from a recordset
    *
    * Gets the next record in a recordset and returns in array
    *
    * @param    object      $recordset  The recordset to operate on
    * @param    boolean     $both       get both assoc and numeric indices
    * @return   array       Returns data array of current row from recordset
    */
    public function dbFetchArray($recordset, $both = FALSE)
    {
        if ($both) {
            $result_type = MYSQLI_BOTH;
        } else {
            $result_type = MYSQLI_ASSOC;
        }

        $result = $recordset->fetch_array($result_type);

        return ($result === NULL) ? false : $result;
    }

    /**
    * Returns the last ID inserted
    *
    * Returns the last auto_increment ID generated
    *
    * @param    resource    $link_identifier    identifier for opened link
    * @return   int                             Returns last auto-generated ID
    */
    public function dbInsertId($link_identifier = '', $sequence = '')
    {
        return $this->_db->insert_id;
    }

    /**
    * returns a database error string
    *
    * Returns an database error message
    *
    * @param    string      $sql    SQL that may have caused the error
    * @return   string      Text for error message
    */
    public function dbError($sql = '')
    {
        if ($this->_db->errno) {
            $fn = '';
            $btr = debug_backtrace();
            if (! empty($btr)) {
                for ($i = 0; $i < 100; $i++) {
                    $b = $btr[$i];
                    if ($b['function'] == 'DB_query') {
                        if (!empty($b['file']) && !empty($b['line'])) {
                            $fn = $b['file'] . ':' . $b['line'];
                        }
                        break;
                    }
                }
            }
            if (empty($fn)) {
                $this->_errorlog($this->_db->errno . ': ' . $this->_db->error . ". SQL in question: $sql");
            } else {
                $this->_errorlog($this->_db->errno . ': ' . $this->_db->error . " in $fn. SQL in question: $sql");
            }

            if ($this->_display_error) {
                return  $this->_db->errno . ': ' . $this->_db->error;
            } else {
                return 'An SQL error has occurred. Please see error.log for details.';
            }
        }

        return;
    }

    /**
    * Lock a table
    *
    * Locks a table for write operations
    *
    * @param    string      $table      Table to lock
    * @return   void
    * @see dbUnlockTable
    */
    public function dbLockTable($table)
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** Inside database->dbLockTable ***");
        }

        $sql = "LOCK TABLES $table WRITE";

        $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorlog("\n*** Leaving database->dbLockTable ***");
        }
    }

    /**
    * Unlock a table
    *
    * Unlocks a table after a dbLockTable (actually, unlocks all tables)
    *
    * @param    string      $table      Table to unlock (ignored)
    * @return   void
    * @see dbLockTable
    */
    public function dbUnlockTable($table)
    {
        if ($this->_verbose) {
            $this->_errorlog("\n*** Inside database->dbUnlockTable ***");
        }

        $sql = 'UNLOCK TABLES';

        $this->dbQuery($sql);

        if ($this->_verbose) {
            $this->_errorlog("\n*** Leaving database->dbUnlockTable ***");
        }
    }

    /**
    * @return     string     the version of the database application
    */
    public function dbGetVersion()
    {
        return $this->_db->server_info;
    }

    public function dbEscape($value, $is_numeric = FALSE)
    {
        if (!$is_numeric) {
            $value = $this->_db->escape_string($value);
        }

        return $value;
    }

    public function dbStartTransaction()
    {
        return $this->_db->autocommit(FALSE);
    }

    public function dbCommit()
    {
        return $this->_db->commit();
    }

    public function dbRollback()
    {
        return $this->_db->rollback();
    }
}

?>
