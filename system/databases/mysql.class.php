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
// $Id: mysql.class.php,v 1.1 2001/10/17 23:20:47 tony_bibbs Exp $

class database {

    // PRIVATE PROPERTIES
    var $_host;
    var $_name;
    var $_user;
    var $_pass;
    var $_verbose;
    var $_errorlog_fn;

    // PRIVATE METHODS

    /**
    * Logs messages
    *
    * Logs messages by calling the function held in $_errorlog_fn
    *
    * @msg        string        Message to log
    *
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
    */
    function _connect()
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->_connect ***<br>");
        }

        // Connect to MySQL server
        $conn = mysql_connect($this->_host,$this->_user,$this->_pass) or die('Cannnot connect to DB server');

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
    * @dbhost        string        Database host
    * @dbname        string        Name of database
    * @dbuser        string        User to make connection as
    * @pass          string        Password for dbuser
    * @errorlogfn    string        Name of the errorlog function
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
    * @flag     boolean     true or false
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
    * @functionname        string        Function name
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
    * @sql  string  SQL to be executed
    * @ignore_error int     If 1 this function supresses any error messages
    *
    */
    function dbQuery($sql,$ignore_errors=0)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n***inside database->dbQuery***<br>");
            $this->_errorlog("\n*** sql to execute is $sql ***<br>");
        }

        // Connect to database server
        $db = $this->_connect();

        // Run query
        $result = @mysql_query($sql,$db) or die($this->dbError($sql));

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
    * This will use a REPLACE INTO to save a record into the
    * database
    *
    * @table        string  The table to save to
    * @fields       string  Comma demlimited list of fields to save
    * @values       string  Values to save to the database table
    * @return       string  URL to send user to when done
    *
    */
    function dbSave($table,$fields,$values)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbSave ***<BR>");
        }

        $sql = "REPLACE INTO $table ($fields) VALUES ($values)";

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
    * @table        string          Table to delete data from
    * @id           array|string    field name(s) to include in where clause
    * @value        array|string    field value(s) corresponding to field names
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

        if ($this->isVerbose()) {
            #print "dbDelete sql = $sql<BR>";
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
    * @table        string          Table to perform change on
    * @item_to_set  string          field name of unique ID field for table
    * @value_to_set string          Value for id
    * @id           array|string    additional field name used in where clause
    * @value        array|string    Value for id2
    *
    */
    function dbChange($table,$item_to_set,$value_to_set,$id,$value)
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside dbChange ***");
        }

        $sql = "UPDATE $table SET $item_to_set = '$value_to_set'";

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
    * Returns the number of records for a query that meets the given criteria
    *
    * This will build a SELECT count(*) statement with the given criteria and
    * return the result
    *
    * @table        string          Table to perform count on
    * @id           array|string    field name(s) of fields to use in where clause
    * @value        array|string    Value(s) to use in where clause
    *
    */
    function dbCount($table,$id='',$value='')
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->dbCount ***<br>");
        }

        $sql = "SELECT COUNT(*) FROM $table";

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

        if ($this->isVerbose()) {
            print "\n*** sql = $sql ***<br>";
        }

        $result = $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbCount ***<BR>");
        }

        return ($this->dbResult($result,0));

    }

    /**
    * Copies a record from one table to another (can be the same table)
    *
    * This will use a REPLACE INTO...SELECT FROM to copy a record from one table
    * to another table.  They can be the same table.
    *
    * @table        string          Table to insert record into
    * @fields       string          Comma delmited list of fields to copy over
    * @values       string          Values to store in database fields
    * @tablefrom    string          Table to get record from
    * @id           array|string    field name(s) to use in where clause
    * @value        array|string    Value(s) to use in where clause
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
    * @recordset object     The recordset to operate one
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
    * @recordset object     The recordset to operate one
    * @row  int     row to get data from
    * @field        string  field to return
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
    * @recordset object     The recordset to operate on
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
    * @recordset object     The recordset to operate on
    * @fnumber      int     field number to return the name of
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
    * @recordset object     The recordset to operate on
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
    * @recordset    object  The recordset to operate on
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
    * @recordset    object  Recorset to operate on
    */
    function dbInsertId($recordset)
    {
        return @mysql_insert_id($recordset);
    }

    /**
    * returns a database error string
    *
    * Returns an database error message
    *
    * @sql        string        SQL that may have caused the error
    *
    */
    function dbError($sql='')
    {
        if (mysql_errno()) {
            $this->_errorlog(@mysql_errno() . ': ' . @mysql_error() . " SQL in question: $sql");        
            return  @mysql_errno . ': ' . @mysql_error();
        }
	
	return;
    }

}

?>
