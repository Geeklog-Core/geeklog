<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | mysql.class.php                                                           |
// | mysql database class                                                      |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony@tonybibbs.com                                   |
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
//
// $Id: mysql.class.php,v 1.9 2002/05/21 15:37:58 tony_bibbs Exp $

/**
* This file is the mysql implementation of the Geeklog abstraction layer.  Unfortunately
* the Geeklog abstraction layer isn't 100% abstract because a key few functions use
* MySQL's REPLACE INTO syntax which is not a SQL standard.  Those issue will be resolved
* in the near future
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
    var $_verbose = false;
    /**
    * @access private
    */
    var $_errorlog_fn = '';
    /**
    * @access private
    */
    var $_numQueries = 0;

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
            $this->_errorlog("\n*** Inside database->_connect ***<br>");
        }

        // Connect to MySQL server
        $conn = mysql_pconnect($this->_host,$this->_user,$this->_pass) or die('Cannnot connect to DB server');

        // Set the database
        @mysql_select_db($this->_name) or die('error selecting database');

        if (!$conn) {
            if ($this->isVerbose()) {
                $this->_errorlog("\n*** Error in database->_connect ***");
            }

            // damn, got an error.
            $this->dbError();
        }

        if ($this->isVerbose()) {
            $this->_errorlog("\n***leaving database->_connect***<br>");
        }

        // return connection object
        return $conn;
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
    *
    */
    function database($dbhost,$dbname,$dbuser,$dbpass,$errorlogfn='')
    {
        $this->_host = $dbhost;
        $this->_name = $dbname;
        $this->_user = $dbuser;
        $this->_pass = $dbpass;
        $this->_verbose = false;
        $this->_errorlog_fn = $errorlogfn;
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
            print "\n<BR><B>Can't run mysql.class.php verbosely because the errorlog "
                . "function wasn't set or doesn't exist<BR>\n";
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
    * Returns the number of queries executed so far
    *
    * @return   int     Number of queries executed
    *
    */
    function dbNumQueries()
    {
        return $this->_numQueries;
    }
    
    /**
    * Executes a query on the MySQL server
    *
    * This executes the passed SQL and returns the recordset or errors out
    *
    * @param    string      $sql            SQL to be executed
    * @param    boolean     $ignore_error   If 1 this function supresses any error messages
    * @param    int         $ttl            Time-to-live (caching feature, not used in this library)
    * @return   object      Returns results of query
    *
    */
    function dbQuery($sql,$ignore_errors=0,$ttl=0)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n***inside database->dbQuery***<br>");
            $this->_errorlog("\n*** sql to execute is $sql ***<br>");
        }

        // Connect to database server
        $db = $this->_connect();

        $this->_numQueries++;
        
        // Run query
        if ($ignore_errors == 1) {
            $result = @mysql_query($sql,$db);
        } else {
            $result = @mysql_query($sql,$db) or die($this->dbError($sql));
        }

        // If OK, return otherwise echo error
        if (mysql_errno() == 0 && !empty($result)) {
            if ($this->isVerbose()) {
                $this->_errorlog("\n***sql ran just fine***<BR>");
                $this->_errorlog("\n*** Leaving database->dbQuery ***<BR>");
            }
            return $result;

        } else {
            // callee may want to supress printing of errors
            if ($ignore_errors == 1) return false;

            if ($this->isVerbose()) {
                $this->_errorlog("\n***sql caused an error***<br>");
                $this->_errorlog("\n*** Leaving database->dbQuery ***<BR>");
            }
        }
    }

    /**
    * Saves information to the database
    *
    * This will use $key_field and $key_value to see if an UPDATE or INSERT
    * statement is needed.  This does support concatenated keys
    *
    * @param    string          $table      The table to save to
    * @param    string          $fields     string  Comma demlimited list of fields to save
    * @param    string          $values     Values to save to the database table
    * @param    string|array    $key_field  string or string array of all key fields
    * @param    string|array    $key_value  string or string array of all key values
    *
    */
    function dbSave($table, $fields, $values, $key_field = '', $key_value = '')
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbSave ***<BR>");
        }
        
        if (DB_count($table,$key_field, $key_value,0) > 0) {
            $farray = explode(',',$fields);
            $varray = explode(',',$values);
            $sql = "UPDATE $table SET ";
            for ($i = 0; $i <= count($farray); $i++) {
                $sql .= current($farray) . '=' . current($varray);
                if ($i < count($farray)) {
                    $sql .= ',';
                }
                next($farray);
                next($varray);
            }
            $where_clause = '';
            if (is_array($key_field)) {
                for ($i = 1; $i <= count($key_field); $i++) {
                    $where_clause .= current($key_field) . '=' . current($key_value);
                    if ($i < count($key_field)) {
                        $where_clause .= ' AND ';
                    }
                    next($key_field);
                    next($key_value);
                }
            }
            $sql .= " WHERE $where_clause";
        } else {
            
            $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        }
                
        $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbSave ***<BR>");
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
            $this->_errorlog("\n*** inside database->dbDelete ***<BR>");
        }

        $sql = "DELETE FROM $table";

        if (is_array($id) || is_array($value)) {
            if (is_array($id) && is_array($value) && count($id) == count($value)) {
                // they are arrays, traverse them and build sql
                $sql .= ' WHERE ';
                for ($i = 1; $i <= count($id); $i++) {
                    if ($i == count($id)) {
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
            if (!empty($id) && !empty($value)) {
                $sql .= " WHERE $id = '$value'";
            }
        }

        $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** inside database->dbDelete ***<BR>");
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
            if (is_array($id) && is_array($value) && count($id) == count($value)) {
                // they are arrays, traverse them and build sql
                $sql .= ' WHERE ';
                for ($i = 1; $i <= count($id); $i++) {
                    if ($i == count($id)) {
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
            if (!empty($id) && !empty($value)) {
                $sql .= " WHERE $id = '$value'";
            }
        }

        if ($this->isVerbose()) {
            $this->_errorlog("dbChange sql = $sql<BR>");
        }

        $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbChange ***");
        }

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
            $this->_errorlog("\n*** Inside database->dbCopy ***<BR>");
        }

        $sql = "REPLACE INTO $table ($fields) SELECT $values FROM $tablefrom";

        if (is_array($id) || is_array($value)) {
            if (is_array($id) && is_array($value) && count($id) == count($value)) {
                // they are arrays, traverse them and build sql
                $sql .= ' WHERE ';
                for ($i = 1; $i <= count($id); $i++) {
                    if ($i == count($id)) {
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
            if (!empty($id) && !empty($value)) {
                $sql .= " WHERE $id = '$value'";
            }
        }

        $this->dbQuery($sql);
        $this->dbDelete($tablefrom,$id,$value);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbCopy ***<BR>");
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
            $this->_errorlog("\n*** Inside database->dbNumRows ***<BR>");
        }

        // return only if recordset exists, otherwise 0
        if ($recordset) {
            if ($this->isVerbose()) {
                $this->_errorlog('got ' . @mysql_numrows($recordset) . ' rows');
                $this->_errorlog("\n*** Inside database->dbNumRows ***<BR>");
            }
            return @mysql_numrows($recordset);
        } else {
            if ($this->isVerbose()) {
                $this->_errorlog("got no rows<BR>");
                $this->_errorlog("\n*** Inside database->dbNumRows ***<BR>");
            }
            return 0;
        }
    }

    /**
    * Retrieves the number of rows in a recordset
    *
    * This returns the number of rows in a recordset
    *
    * @param    object      $recordset      The recordset to operate one
    * @param    int         $row            row to get data from
    * @param    string      $field          field to return
    * @return   int
    *
    */
    function dbResult($recordset,$row,$field=0)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbResult ***<BR>");
            if (empty($recordset)) {
                $this->_errorlog("\n*** Passed recordset isn't valid ***<br>");
            } else {
                $this->_errorlog("\n*** Everything looks good ***<br>");
            }
            $this->_errorlog("\n*** Leaving database->dbResult ***<br>");
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
    * @return   array       Returns data array of current row from recordset
    *
    */
    function dbFetchArray($recordset)
    {
        return @mysql_fetch_array($recordset);
    }

    /**
    * Returns the last ID inserted
    *
    * Returns the last auto_increment ID generated for recordset
    *
    * @param    object      $recordset      Recorset to operate on
    * @return   int     Returns last auto-generated ID
    *
    */
    function dbInsertId($recordset='')
    {
        if (empty($recordset)) {
            return @mysql_insert_id();
        } else {
            return @mysql_insert_id($recordset);
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
            $this->_errorlog(@mysql_errno() . ': ' . @mysql_error() . " SQL in question: $sql");        
            return  @mysql_errno() . ': ' . @mysql_error();
        }
	
	return;
    }
}

?>