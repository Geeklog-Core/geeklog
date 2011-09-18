<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | mysql.class.php                                                           |
// |                                                                           |
// | mysql database class                                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
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

/**
* This file is the mysql implementation of the Geeklog abstraction layer.
* Unfortunately the Geeklog abstraction layer isn't 100% abstract because a few
* key functions use MySQL's REPLACE INTO syntax which is not a SQL standard.
* This issue will need to be resolved some time ...
*
*/
class database {

    // PRIVATE PROPERTIES
    
    /**
    * @access private
    */
    var $_host = '';
    /**
    * @access private
    */
    var $_name = '';
    /**
    * @access private
    */
    var $_user = '';
    /**
    * @access private
    */
    var $_pass = '';
    /**
    * @access private
    */
    var $_db = '';
    /**
    * @access private
    */
    var $_verbose = false;
    /**
    * @access private
    */
    var $_display_error = false;
    /**
    * @access private
    */
    var $_errorlog_fn = '';
    /**
    * @access private
    */
    var $_charset = '';
    /**
    * @access private
    */
    var $_mysql_version = 0;

    // PRIVATE METHODS

    /**
    * Logs messages
    *
    * Logs messages by calling the function held in $_errorlog_fn
    *
    * @param    string      $msg        Message to log
    * @access   private
    */
    function _errorlog($msg)
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
    *
    */
    function _connect()
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->_connect ***");
        }

        // Connect to MySQL server
        $this->_db = mysql_connect($this->_host,$this->_user,$this->_pass) or die('Cannot connect to DB server');

        if ($this->_mysql_version == 0) {
            $v = mysql_get_server_info ();
            preg_match ('/^([0-9]+).([0-9]+).([0-9]+)/', $v, $match);
            $v = (intval ($match[1]) * 10000) + (intval ($match[2]) * 100)
               + intval ($match[3]);
            $this->_mysql_version = $v;
        }

        // Set the database
        @mysql_select_db($this->_name) or die('error selecting database');

        if (!($this->_db)) {
            if ($this->isVerbose()) {
                $this->_errorlog("\n*** Error in database->_connect ***");
            }

            // damn, got an error.
            $this->dbError();
        }

        if ($this->_charset == 'utf-8') {
            if (($this->_mysql_version >= 50007) &&
                    function_exists('mysql_set_charset')) {
                @mysql_set_charset('utf8', $this->_db);
            } else {
                @mysql_query ("SET NAMES 'utf8'", $this->_db);
            }
        }

        if ($this->isVerbose()) {
            $this->_errorlog("\n***leaving database->_connect***");
        }
    }

    // PUBLIC METHODS

    /**
    * constructor for database
    *
    * This initializes an instance of the database object
    *
    * @param        string      $dbhost     Database host
    * @param        string      $dbname     Name of database
    * @param        sring       $dbuser     User to make connection as
    * @param        string      $pass       Password for dbuser
    * @param        string      $errorlogfn Name of the errorlog function
    * @param        string      $charset    character set to use
    *
    */
    function database($dbhost,$dbname,$dbuser,$dbpass,$errorlogfn='',$charset='')
    {
        $this->_host = $dbhost;
        $this->_name = $dbname;
        $this->_user = $dbuser;
        $this->_pass = $dbpass;
        $this->_verbose = false;
        $this->_errorlog_fn = $errorlogfn;
        $this->_charset = strtolower($charset);
        $this->_mysql_version = 0;

        $this->_connect();
    }

    /**
    * Turns debug mode on
    *
    * Set this to true to see debug messages
    *
    * @param    boolean     $flag   true or false
    *
    */
    function setVerbose($flag)
    {
        $this->_verbose = $flag;
    }

    /**
    * Turns detailed error reporting on
    *
    * If set to true, this will display detailed error messages on the site.
    * Otherwise, it will only that state an error occurred without going into
    * details. The complete error message (including the offending SQL request)
    * is always available from error.log.
    *
    * @param    boolean     $flag   true or false
    *
    */
    function setDisplayError($flag)
    {
        $this->_display_error = $flag;
    }

    /**
    * Checks to see if debug mode is on
    *
    * Returns value of $_verbose
    *
    * @return   boolean     true if in verbose mode otherwise false
    *
    */
    function isVerbose()
    {
        if ($this->_verbose && (empty($this->_errorlog_fn) || !function_exists($this->_errorlog_fn))) {
            print "\n<br" . XHTML . "><b>Can't run mysql.class.php verbosely because the errorlog "
                . "function wasn't set or doesn't exist</b><br" . XHTML . ">\n";
            return false;
        }

        return $this->_verbose;
    }

    /**
    * Sets the function this class should call to log debug messages
    *
    * @param        string      $functionname   Function name
    *
    */
    function setErrorFunction($functionname)
    {
        $this->_errorlog_fn = $functionname;
    }

    /**
    * Executes a query on the MySQL server
    *
    * This executes the passed SQL and returns the recordset or errors out
    *
    * @param    string      $sql            SQL to be executed
    * @param    boolean     $ignore_error   If 1 this function supresses any error messages
    * @return   object      Returns results of query
    *
    */
    function dbQuery($sql,$ignore_errors=0)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n***inside database->dbQuery***");
            $this->_errorlog("\n*** sql to execute is $sql ***");
        }

        // Run query
        if ($ignore_errors == 1) {
            $result = @mysql_query($sql,$this->_db);
        } else {
            $result = @mysql_query($sql,$this->_db) or trigger_error($this->dbError($sql), E_USER_ERROR);
        }

        // If OK, return otherwise echo error
        if (mysql_errno() == 0 && !empty($result)) {
            if ($this->isVerbose()) {
                $this->_errorlog("\n***sql ran just fine***");
                $this->_errorlog("\n*** Leaving database->dbQuery ***");
            }
            return $result;

        } else {
            // callee may want to supress printing of errors
            if ($ignore_errors == 1) return false;

            if ($this->isVerbose()) {
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
    *
    */
    function dbSave($table,$fields,$values)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbSave ***");
        }

        $sql = "REPLACE INTO $table ($fields) VALUES ($values)";

        $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbSave ***");
        }
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
    * @return   boolean     Returns true on success otherwise false
    *
    */
    function dbDelete($table,$id,$value)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** inside database->dbDelete ***");
        }

        $sql = "DELETE FROM $table";

        if (is_array($id) || is_array($value)) {
            $num_ids = count($id);
            if (is_array($id) && is_array($value) && $num_ids == count($value)) {
                // they are arrays, traverse them and build sql
                $sql .= ' WHERE ';
                for ($i = 1; $i <= $num_ids; $i++) {
                    if ($i == $num_ids) {
                        $sql .= current($id) . " = '" . current($value) . "'";
                    } else {
                        $sql .= current($id) . " = '" . current($value) . "' AND ";
                    }
                    next($id);
                    next($value);
                }
            } else {
                // error, they both have to be arrays and of the
                // same size
                return false;
            }
        } else {
            // just regular string values, build sql
            if (!empty($id) && ( isset($value) || $value != "")) { 
                $sql .= " WHERE $id = '$value'";
            }
        }

        $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** inside database->dbDelete ***");
        }

        return true;
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
    * @param    boolean         $supress_quotes if false it will not use '<value>' in where clause
    * @return   boolean     Returns true on success otherwise false
    *
    */
    function dbChange($table,$item_to_set,$value_to_set,$id,$value, $supress_quotes=false)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside dbChange ***");
        }

        if ($supress_quotes) {
            $sql = "UPDATE $table SET $item_to_set = $value_to_set";
        } else {
            $sql = "UPDATE $table SET $item_to_set = '$value_to_set'";
        } 

        if (is_array($id) || is_array($value)) {
            $num_ids = count($id);
            if (is_array($id) && is_array($value) && $num_ids == count($value)) {
                // they are arrays, traverse them and build sql
                $sql .= ' WHERE ';
                for ($i = 1; $i <= $num_ids; $i++) {
                    if ($i == $num_ids) {
                        $sql .= current($id) . " = '" . current($value) . "'";
                    } else {
                        $sql .= current($id) . " = '" . current($value) . "' AND ";
                    }
                    next($id);
                    next($value);
                }
            } else {
                // error, they both have to be arrays and of the
                // same size
                return false;
            }
        } else {
            // These are regular strings, build sql
            if (!empty($id) && ( isset($value) || $value != "")) { 
                $sql .= " WHERE $id = '$value'";
            }
        }

        if ($this->isVerbose()) {
            $this->_errorlog("dbChange sql = $sql");
        }

        $this->dbQuery($sql);

        if ($this->isVerbose()) {
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
    * @return   boolean     returns count on success otherwise false
    *
    */
    function dbCount($table,$id='',$value='')
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbCount ***");
        }

        $sql = "SELECT COUNT(*) FROM $table";

        if (is_array($id) || is_array($value)) {
            $num_ids = count($id);
            if (is_array($id) && is_array($value) && $num_ids == count($value)) {
                // they are arrays, traverse them and build sql
                $sql .= ' WHERE ';
                for ($i = 1; $i <= $num_ids; $i++) {
                    if ($i == $num_ids) {
                        $sql .= current($id) . " = '" . current($value) . "'";
                    } else {
                        $sql .= current($id) . " = '" . current($value) . "' AND ";
                    }
                    next($id);
                    next($value);
                }
            } else {
                // error, they both have to be arrays and of the
                // same size
                return false;
            }
        } else {
            if (!empty($id) && ( isset($value) || $value != "")) { 
                $sql .= " WHERE $id = '$value'";
            }
        }

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** sql = $sql ***");
        }

        $result = $this->dbQuery($sql);

        if ($this->isVerbose()) {
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
    * @return   boolean     Returns true on success otherwise false
    *
    */
    function dbCopy($table,$fields,$values,$tablefrom,$id,$value)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbCopy ***");
        }

        $sql = "REPLACE INTO $table ($fields) SELECT $values FROM $tablefrom";

        if (is_array($id) || is_array($value)) {
            $num_ids = count($id);
            if (is_array($id) && is_array($value) && $num_ids == count($value)) {
                // they are arrays, traverse them and build sql
                $sql .= ' WHERE ';
                for ($i = 1; $i <= $num_ids; $i++) {
                    if ($i == $num_ids) {
                        $sql .= current($id) . " = '" . current($value) . "'";
                    } else {
                        $sql .= current($id) . " = '" . current($value) . "' AND ";
                    }
                    next($id);
                    next($value);
                }
            } else {
                // error, they both have to be arrays and of the
                // same size
                return false;
            }
        } else {
            if (!empty($id) && ( isset($value) || $value != "")) { 
                $sql .= " WHERE $id = '$value'";
            }
        }

        $this->dbQuery($sql);
        $this->dbDelete($tablefrom,$id,$value);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbCopy ***");
        }

    }

    /**
    * Retrieves the number of rows in a recordset
    *
    * This returns the number of rows in a recordset
    *
    * @param    object      $recordset      The recordset to operate one
    * @return   int         Returns number of rows otherwise false (0)
    *
    */
    function dbNumRows($recordset)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbNumRows ***");
        }

        // return only if recordset exists, otherwise 0
        if ($recordset) {
            if ($this->isVerbose()) {
                $this->_errorlog('got ' . @mysql_numrows($recordset) . ' rows');
                $this->_errorlog("\n*** Inside database->dbNumRows ***");
            }
            return @mysql_numrows($recordset);
        } else {
            if ($this->isVerbose()) {
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
    *
    */
    function dbResult($recordset,$row,$field=0)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbResult ***");
            if (empty($recordset)) {
                $this->_errorlog("\n*** Passed recordset isn't valid ***");
            } else {
                $this->_errorlog("\n*** Everything looks good ***");
            }
            $this->_errorlog("\n*** Leaving database->dbResult ***");
        }
        return @mysql_result($recordset,$row,$field);
    }

    /**
    * Retrieves the number of fields in a recordset
    *
    * This returns the number of fields in a recordset
    *
    * @param    object      $recordset      The recordset to operate on
    * @return   int     Returns number of rows from query
    *
    */
    function dbNumFields($recordset)
    {
        return @mysql_numfields($recordset);
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
    function dbFieldName($recordset,$fnumber)
    {
        return @mysql_fieldname($recordset,$fnumber);
    }

    /**
    * Retrieves returns the number of effected rows for last query
    *
    * Retrieves returns the number of effected rows for last query
    *
    * @param    object      $recordset      The recordset to operate on
    * @return   int     Number of rows affected by last query
    *
    */
    function dbAffectedRows($recordset)
    {
        return @mysql_affected_rows();
    }

    /**
    * Retrieves record from a recordset
    *
    * Gets the next record in a recordset and returns in array
    *
    * @param    object      $recordset  The recordset to operate on
    * @param    boolean     $both       get both assoc and numeric indices
    * @return   array       Returns data array of current row from recordset
    *
    */
    function dbFetchArray($recordset, $both = false)
    {
        if ($both) {
            $result_type = MYSQL_BOTH;
        } else {
            $result_type = MYSQL_ASSOC;
        }
        return @mysql_fetch_array($recordset, $result_type);
    }

    /**
    * Returns the last ID inserted
    *
    * Returns the last auto_increment ID generated
    *
    * @param    resource    $link_identifier    identifier for opened link
    * @return   int                             Returns last auto-generated ID
    *
    */
    function dbInsertId($link_identifier = '',$sequence='')
    {
        if (empty($link_identifier)) {
            return @mysql_insert_id();
        } else {
            return @mysql_insert_id($link_identifier);
        }
    }

    /**
    * returns a database error string
    *
    * Returns an database error message
    *
    * @param    string      $sql    SQL that may have caused the error
    * @return   string      Text for error message
    *
    */
    function dbError($sql='')
    {
        if (mysql_errno()) {
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
                $this->_errorlog(@mysql_errno() . ': ' . @mysql_error() . ". SQL in question: $sql");
            } else {
                $this->_errorlog(@mysql_errno() . ': ' . @mysql_error() . " in $fn. SQL in question: $sql");
            }
            if ($this->_display_error) {
                return  @mysql_errno() . ': ' . @mysql_error();
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
    *
    */
    function dbLockTable($table)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbLockTable ***");
        }

        $sql = "LOCK TABLES $table WRITE";

        $this->dbQuery($sql);

        if ($this->isVerbose()) {
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
    *
    */
    function dbUnlockTable($table)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbUnlockTable ***");
        }

        $sql = 'UNLOCK TABLES';

        $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbUnlockTable ***");
        }
    }

    /**
    * @return     string     the version of the database application
    */
    function dbGetVersion()
    {
        return @mysql_get_server_info();
    }

}

?>
