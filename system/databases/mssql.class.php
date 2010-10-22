<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | mssql.class.php                                                           |
// |                                                                           |
// | mysql database class                                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony AT tonybibbs DOT com                            |
// |          Randy Kolenko, Randy AT nextide DOT ca                           |
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
* This file is the mssql implementation of the Geeklog abstraction layer.
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
    var $_limitRows = array();
    var $_numberOfRowsAskedFor = array();
    var $_lastInsertID=array();
    var $_fastForwardRows=array();
    var $_NoArraylastInsertID='';
    
    
    
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
    * Connects to the Microsoft database server
    *
    * This function connects to the mssql server and returns the connection object
    *
    * @return   object      Returns connection object
    * @access   private
    *
    */
    function _connect()
    {
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Inside database->_connect ***<br" . XHTML . ">");
        }

        // Connect to mssql server
        $this->_db = mssql_connect($this->_host,$this->_user,$this->_pass) or die('Cannnot connect to DB server');

        // Set the database
        @mssql_select_db($this->_name) or die ('Cannot Connect to the database provided.  Please check the db-config.php settings.');

        if (!($this->_db)) {
            if ($this->isVerbose()) {
                $this->_errorlog("\n*** Error in database->_connect ***");
            }

            // damn, got an error.
            $this->dbError();
        }

        if ($this->isVerbose()) {
            $this->_errorlog("\n***leaving database->_connect***<br" . XHTML . ">");
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
            print "\n<br" . XHTML . "><b>Can't run mssql.class.php verbosely because the errorlog "
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

    
    
    function cleanseSQL($originalsql,$skipQuoteReplacement=0){
        $sql=$originalsql;
        
        if(!$skipQuoteReplacement){
            $tempsql=str_replace('\"',"''",$sql);
            $sql=$tempsql;
            }
            
       if(!$skipQuoteReplacement){
            $tempsql=str_replace("\'","''",$sql);
            $sql=$tempsql;
            }
        
        $sql=$this->changeDESCRIBE($sql);
        
        $sql=$sql . " ";
        
        $tempsql=str_replace("`","",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("unix_timestamp","UNIX_TIMESTAMP",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("UNIX_TIMESTAMP","dbo.UNIX_TIMESTAMP",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("date_format","DATE_FORMAT",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("DATE_FORMAT","dbo.DATE_FORMAT",$sql);
        $sql=$tempsql;

        $tempsql=str_replace("from_unixtime","FROM_UNIXTIME",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("FROM_UNIXTIME","dbo.FROM_UNIXTIME",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("dbo.UNIX_TIMESTAMP()","dbo.UNIX_TIMESTAMP('')",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("dbo.FROM_UNIXTIME()","dbo.FROM_UNIXTIME('')",$sql);
        $sql=$tempsql;
        
        //$tempsql=str_replace("dbo.FROM_UNIXTIME(')","dbo.FROM_UNIXTIME('')",$sql);
        //$sql=$tempsql;
        
        $tempsql=$this->cleanse_date_sub($sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("NOW()","getUTCDate()",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("now()","getUTCDate()",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("STRAIGHT_JOIN","",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("straight_join","",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("WHERE 1 ","WHERE 1=1 ",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("where 1 ","where 1=1 ",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("to_days","TO_DAYS",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("TO_DAYS","dbo.TO_DAYS",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("CURDATE()","getDate()",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("'0000-00-00 00:00:00'","NULL",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("'null'","null",$sql);
        $sql=$tempsql;
        
        $tempsql=str_replace("dbo.dbo.","dbo.",$sql);
        $sql=$tempsql;
        
        return $sql;
        }
    
    
    //swaps out the propriatary DESC function in mysql and replaces it with our UDF version
    function changeDESCRIBE($sql){
        $sql=trim($sql);
        $testSQL=strtolower($sql);
        $testSQL=" " . $testSQL;
        $isIn=strpos($testSQL,'describe ');
        if($isIn>0){
            if($sql[strlen($sql)-1]==';'){
                //if the last char is a semi colon, get rid of it
                $sql=str_replace(";","",$sql);
                }
            $testSQL=strtolower($sql);
            $remainder=str_replace("describe ","",$testSQL);
            $remainder=trim($remainder);
            $remainder="select * from dbo.DESCRIBE('" . $remainder . "')";
            return $remainder;
            }
        else{
            return $sql;
            }
        }
    
        
    
    
    /**
    * Executes a query on the server
    *
    * This executes the passed SQL and returns the recordset or errors out
    *
    * @param    string      $sql            SQL to be executed
    * @param    boolean     $ignore_error   If 1 this function supresses any error messages
    * @return   object      Returns results of query
    *
    */
    function dbQuery($sql,$ignore_errors=0,$skipQuoteReplacement=0)
    {
     
        $sql=$this->cleanseSQL($sql,$skipQuoteReplacement);
        //limit detection
        $testSQL=strtolower($sql);
        $mode=0;
        $isIn=strpos($testSQL,' limit ');
            if($isIn>0){
                //there is a LIMIT clause in there
                //lets get its offset as a string to the end of the sql call
                 
                $limitclause=strstr($testSQL,' limit ');
                $testSQL=substr($sql,0,$isIn);
                
                $limitclause=trim($limitclause);
                eregi("limit ([^,]+),(.*)", $limitclause,$arrayStr); 
                
                $left=trim($arrayStr[1]);
                $rightStr=trim($arrayStr[2]);
                
                
                if($rigthStr=='' and $left==''){
                    //this is the case where we have a single limit value
                    //this is IDENTICAL to the usage of the TOP clause
                    $left=strstr($limitclause, ' ');
                    $left=trim($left);
                    $mode=1;
                    
                    
                    }//end if $rightstr...
                else{
                    //left and right have something useful
                    //this means we'll have to do some kind of temp table manipulation.... 
                    $rightStr=str_replace(";","",$rightStr);
                    $mode=2;
                    }//end else
                $sql=$testSQL;
                }
                
        //end limit detection
        

        if ($this->isVerbose()) {
            $this->_errorlog("\n***inside database->dbQuery***<br" . XHTML . ">");
            $this->_errorlog("\n*** sql to execute is $sql ***<br" . XHTML . ">");
        }

        if($mode==0){
           
            }
        elseif($mode==1){//this is a simple limit clause
            $testSQL=strtolower($sql);
            $isIn=strpos($testSQL,' distinct ');
            if($isIn>0){
                $sql=str_replace(" distinct ", " distinct top " . $left . " ", $sql);
                $sql=str_replace(" DISTINCT ", " DISTINCT TOP " . $left . " ", $sql);
                //echo $sql;
                }
            else{
                $sql=str_replace("select ", "select top " . $left . " ", $sql);
                $sql=str_replace("SELECT ", "SELECT TOP " . $left . " ", $sql);
                //echo $sql;
                }
            }
        else{//this is a tough limit clause
            
            }
            
        //check for insert... handle this differently    
        $testSQL=strtolower($sql);
        $testSQL = ' ' . $testSQL;
        $isIn=strpos($testSQL,'insert ');
        $isInsert=0; 
        if($isIn>0){
            //next we have to check if it already ends in a semi colon
            $testSQL=trim($sql);
            $testSQL=$testSQL[strlen($testSQL)-1];
            if($testSQL!=';'){
                $sql .="; select SCOPE_IDENTITY()";
                }
            else{
                $sql .=" select SCOPE_IDENTITY()";
                }
            
            $isInsert=1;
            }
        
        //echo "<pre>" . $sql . "</pre>";
    
        // Run query
        if ($ignore_errors == 1) {
            $result = @mssql_query($sql,$this->_db);
            
        } else {
           
            $result = @mssql_query($sql,$this->_db) or trigger_error($this->dbError($sql) . ' - ' . $sql, E_USER_ERROR);
            if($result==FALSE){
                echo "Query Failed: ";
                echo "<pre>".$this->dbError($sql) . "</pre><hr" . XHTML . ">";
                }
            }
        $this->_totalRowCount=$this->dbNumRows($result);
        if($result!=FALSE && $isInsert==1){
            $insert=$this->dbFetchArray($result);
            $this->array_push_associative($this->_lastInsertID, array("{$result}"=>"{$insert[0]}")) ;
            $this->_NoArraylastInsertID=$insert[0];
            //$this->_lastInsertID=$insert[0];
            }

       $this->_fastForwardRows=0;
        if($result!=FALSE){     
            if($mode==2){
                //got the result set
                //fast forward thru the set
                
                @mssql_data_seek($result,$left-1);
                
                
                
                if(!is_array($this->_limitRows)){
                    $this->_limitRows=array();
                    }
                if (array_key_exists("{$result}",$this->_limitRows)){
                    $this->_limitRows["{$result}"]=$rightStr;
                    }
                else{
                    $this->array_push_associative($this->_limitRows, array("{$result}"=>"{$rightStr}")) ;
                    }
                
                if(!is_array($this->_numberOfRowsAskedFor)){
                    $this->_numberOfRowsAskedFor=array();
                    }
                if (array_key_exists("{$result}",$this->_numberOfRowsAskedFor)){
                    $this->_numberOfRowsAskedFor["{$result}"]="0";
                    }
                else{
                    $this->array_push_associative($this->_numberOfRowsAskedFor, array("{$result}"=>"0")) ;
                    }
                
                if(!is_array($this->_fastForwardRows)){
                    $this->_fastForwardRows=array();
                    }
                if (array_key_exists("{$result}",$this->_fastForwardRows)){
                    $this->_fastForwardRows["{$result}"]=$left;
                    }
                else{
                    $this->array_push_associative($this->_fastForwardRows, array("{$result}"=>"{$left}")) ;
                    }
    
                //$this->array_push_associative($this->_numberOfRowsAskedFor, array("{$result}"=>"0")) ;
                //$this->array_push_associative($this->_fastForwardRows, array("{$result}"=>"{$left}")) ;

                //$this->_numberOfRowsAskedFor = 0;
                //$this->_fastForwardRows=$left;
                }
            return $result;
            }
        else{
            return false;    
            }
               
        
        
        
        }

    /**
    * Saves information to the database
    *
    * This mimicks the Replace Into mysql call to save a record into the
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
            $this->_errorlog("\n*** Inside database->dbSave ***<br" . XHTML . ">");
        }
        $tempFields=$fields;
        $tempFields=str_replace(",","','",$tempFields);
        //this query will return a row or rows of primary keys for this table for which we can determine
        //if the current query requires a delete before its insertion
        $sql="select colName from getPrimaryKey where tableName='{$table}' and colname in ('{$tempFields}')";
        $result=$this->dbQuery($sql);
        $numRows=$this->dbNumRows($result);

        if($numRows>0){ //this is the instance that there is a primary key we know about.. thus, find out the value of the 
                        //primary key in the $values field and see what it equals..  do a delete first using this primary key's value
                        //and THEN do an insert.  otherwise, just do the insert.
                $valsArray=$this->parse_csv_sql_string($values);
                $fieldsArray=$this->parse_csv_sql_string($fields);
                $arrResults=$this->dbFetchArray($result);
                $primaryKeyField=strtolower($arrResults[0]);
               
                while ($colname = current($fieldsArray)) {
                    if ( strtolower($colname) == $primaryKeyField) { //we have a match
                    
                       $sql="delete from {$table} where ". current($fieldsArray) . "='". current($valsArray)  . "'";
                       $this->dbQuery($sql);
                       break;
                        }//end if
                    next($fieldsArray);
                    next($valsArray);
                    }//end while
            }
        //now to just save/insert the new row.
        $values=$this->cleanseSQL($values);
        $values=str_replace("'",'"',$values);
        $sql="EXEC doIndexInsert '{$table}', '{$fields}', '{$values}'";
       
        $result=$this->dbQuery($sql,1);
        mssql_free_result($result);
        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbSave ***<br" . XHTML . ">");
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
            $this->_errorlog("\n*** inside database->dbDelete ***<br" . XHTML . ">");
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
            if (!empty($id) && ( isset($value) || $value != "")) { 
                $sql .= " WHERE $id = '$value'";
            }
        }

        $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** inside database->dbDelete ***<br" . XHTML . ">");
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
            if (!empty($id) && ( isset($value) || $value != "")) { 
                $sql .= " WHERE $id = '$value'";
            }
        }

        if ($this->isVerbose()) {
            $this->_errorlog("dbChange sql = $sql<br" . XHTML . ">");
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
            $this->_errorlog("\n*** Inside database->dbCount ***<br" . XHTML . ">");
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
            if (!empty($id) && ( isset($value) || $value != "")) { 
                $sql .= " WHERE $id = '$value'";
            }
        }

        
        
        
        if ($this->isVerbose()) {
            print "\n*** sql = $sql ***<br" . XHTML . ">";
        }

        $result = $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbCount ***<br" . XHTML . ">");
        }

        return ($this->dbResult($result,0));

    }


    /* Copies a record from one table to another (can be the same table)
    *
    * This will use a INSERT INTO...SELECT FROM to copy a record from one table
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
            $this->_errorlog("\n*** Inside database->dbCopy ***<br" . XHTML . ">");
        }

        $sql = "INSERT INTO $table ($fields) SELECT $values FROM $tablefrom";

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
            if (!empty($id) && ( isset($value) || $value != "")) { 
                $sql .= " WHERE $id = '$value'";
            }
        }

        $this->dbQuery($sql);
        $this->dbDelete($tablefrom,$id,$value);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbCopy ***<br" . XHTML . ">");
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
            $this->_errorlog("\n*** Inside database->dbNumRows ***<br" . XHTML . ">");
        }

        // return only if recordset exists, otherwise 0
        if ($recordset) {
            if ($this->isVerbose()) {
                $this->_errorlog('got ' . @mssql_num_rows($recordset) . ' rows');
                $this->_errorlog("\n*** Inside database->dbNumRows ***<br" . XHTML . ">");
            }
            if( (($this->_fastForwardRows["{$recordset}"]+$this->_limitRows["{$recordset}"])> @mssql_num_rows($recordset)) && $this->_fastForwardRows["{$recordset}"]!=0 ){
                //only return num rows - fast forwarded rows
                
                return @mssql_num_rows($recordset)-$this->_fastForwardRows["{$recordset}"]+1;
                }
            elseif($this->_limitRows["{$recordset}"]>@mssql_num_rows($recordset) || $this->_limitRows["{$recordset}"]==''){
                return @mssql_num_rows($recordset);
                }
            else{
                return $this->_limitRows["{$recordset}"];
                }
            
            
        } else {
            if ($this->isVerbose()) {
                $this->_errorlog("got no rows<br" . XHTML . ">");
                $this->_errorlog("\n*** Inside database->dbNumRows ***<br" . XHTML . ">");
            }
            return 0;
        }
    }

    /**
    * Returns the contents of one cell from a mssql result set
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
            $this->_errorlog("\n*** Inside database->dbResult ***<br" . XHTML . ">");
            if (empty($recordset)) {
                $this->_errorlog("\n*** Passed recordset isn't valid ***<br" . XHTML . ">");
            } else {
                $this->_errorlog("\n*** Everything looks good ***<br" . XHTML . ">");
            }
            $this->_errorlog("\n*** Leaving database->dbResult ***<br" . XHTML . ">");
        }
        return @mssql_result($recordset,$row,$field);
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
        return @mssql_num_fields($recordset);
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
        return @mssql_field_name($recordset,$fnumber);
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
        return @mssql_rows_affected();
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
      $this->_numberOfRowsAskedFor["{$recordset}"] = $this->_numberOfRowsAskedFor["{$recordset}"] +1;
      if( ($this->_limitRows["{$recordset}"]) !=($this->_numberOfRowsAskedFor["{$recordset}"]-1)  || $this->_limitRows["{$recordset}"]=='' || $this->_limitRows["{$recordset}"]==0){
          //echo $this->dbNumRows($recordset) ."-{$this->_numberOfRowsAskedFor["{$recordset}"]}-{$this->_limitRows["{$recordset}"]}<hr" . XHTML . ">";
        return @mssql_fetch_array($recordset);//, $result_type);  
        }
      else{
        return FALSE;  
        }
    
    
    
        
    }

    /**
    * Returns the last ID inserted
    * 
    * Returns the last auto_increment ID generated
    *
    * @param    resource    $link_identifier    identifier for opened link
    * @return   int                             Returns last auto-generated ID
    *
    * please note that this is a dangerous function to use without providing the proper resource identifier
    * your code should ALWAYS call this function with its resource identifier otherwise you'll just pull off the 
    * last insertted ID which MAY or MAY NOT be the one from YOUR specific insert.  You've been warned!
    */
    function dbInsertId($link_identifier ='',$sequence='')
    {
     
       if ($link_identifier ==''){  //wow is this dangerous...  
                                    //this is the LAST insertted ID no matter what.. thus, this may not be your resource's insertted id.. 
                                    //you should, and I'm only telling you this once, ALWAYS USE YOUR RESOURCE IDENTIFIER when calling this function
           return $this->_NoArraylastInsertID;
        }
        else{
            return $this->_lastInsertID["{$link_identifier}"];
        }
    }

    /**
    * this does not have any use in mssql. but kept here for reference
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
        $msg = mssql_get_last_message();
        if (trim($msg)!='') {
            if (substr($msg, 0, 7) == 'Caution') {
                $this->_errorlog('SQL Warning: "' . $msg . '" SQL in question: ' . $sql);
            } else if (substr($msg, 0, 25) == 'The object was renamed to') {
                $this->_errorlog('Object Renamed: "' . $msg . '" SQL in question: ' . $sql);
            } else if (substr($msg, 0, 25) == 'The COLUMN was renamed to') {
                $this->_errorlog('Column Renamed: "' . $msg . '" SQL in question: ' . $sql);
            } else {
                $this->_errorlog($msg . ': ' . $msg . ". SQL in question: $sql");        
                if (true ||$this->_display_error) {
                    return  $msg . ': ' . $sql;
                } else {
                    return 'An SQL error has occurred. Please see error.log for details.';
                }
            }
        }

        return;
    }
    
    
    
    /**
    * returns a sql string that has the pesky date_sub removed from it
    *
    *
    * @param    string      $sql    SQL that needs conversion
    * @return   string      return sql string
    *
    */
    function cleanse_date_sub($sql){      
        $string=$sql;
        $testString=strtolower($string);
        $isIn=strpos($testString,'date_sub');
        
        while($isIn>0){
            $testString=strtolower($string);
            $isIn=strpos($testString,'date_sub');
            if($isIn>0){
                
                $startLoc=strpos($testString,'date_sub');
                $rightStr=ltrim(substr($string,$startLoc+8,strlen($string)));

                //eregi("\((.*),([^\)]+\))", $rightStr,$left); 
                 eregi("\(([^,]+),([^\)]+\))", $rightStr,$left); 
                
              
                 
                $firstParm=$left[1];
                $secondParm=trim($left[2]);

                $secondParm=str_replace("interval","",$secondParm);
                $secondParm=str_replace(")","",$secondParm);
                $left[2]=str_replace(")","",$left[2]);

                $testMode=strpos($string,'date_sub');
                if($testMode>0){
                    $mode=0;
                    }
                else{
                    $mode=1;
                    }
                
                if($mode==0){
                    $replaceString='date_sub(' . $firstParm . ',' . $left[2] . ')';
                    }
                else{
                    $replaceString='DATE_SUB(' . $firstParm . ',' . $left[2] . ')';
                    }
 
                $secondParmArray=split(" ",$secondParm);
                $intervalTime=$secondParmArray[1];
                $typeForInterval=$secondParmArray[2];
                if($intervalTime>0){
                      $intervalTime = '-' . $intervalTime;
                    }
                $replaceWITHString= "dateadd({$typeForInterval},{$intervalTime},{$firstParm})";
 
                $string=str_replace($replaceString,$replaceWITHString,$string);
                
                //$replaceString='DATE_SUB(' . $firstParm . ',' . $left[2] . ')';
                //$string=str_replace($replaceString,$replaceWITHString,$string);
                
                $tempsql=str_replace("now()","getDate()",$string);
                $string=$tempsql;
            }
    
        }
       return $string;
       
    }


    // thanks to php.net for this
    function array_push_associative(&$arr)
    {
        $ret = 0;
        $args = func_get_args();
        foreach ($args as $arg) {
            if (is_array($arg)) {
                foreach ($arg as $key => $value) {
                    @$arr[$key] = $value;
                    $ret++;
                }
            } else {
                @$arr[$arg] = "";
            }
        }

        return $ret;
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

        
        $sql = "BEGIN TRAN";

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

        $sql = 'COMMIT TRAN';

        $this->dbQuery($sql);

        if ($this->isVerbose()) {
            $this->_errorlog("\n*** Leaving database->dbUnlockTable ***");
        }
    }

    
}//end class

?>
