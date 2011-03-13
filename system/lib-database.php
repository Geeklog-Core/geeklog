<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | lib-database.php                                                          |
// |                                                                           |
// | Geeklog database library.                                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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
* This is the high-level database layer for Geeklog (for the low-level stuff,
* see the system/databases directory).
*
* NOTE: As of Geeklog 1.3.5 you should not have to edit this file any more.
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-database.php') !== false) {
    die('This file can not be used on its own!');
}

// +---------------------------------------------------------------------------+
// | Table definitions, these are used by the install program to create the    |
// | database schema.  If you don't like the tables names, change them PRIOR   |
// | to running the install after running the install program DO NOT TOUCH     |
// | these. You have been warned!  Also, these variables are used in the core  |
// | Geeklog code                                                              |
// +---------------------------------------------------------------------------+

$_TABLES['access']              = $_DB_table_prefix . 'access';
$_TABLES['article_images']      = $_DB_table_prefix . 'article_images';
$_TABLES['blocks']              = $_DB_table_prefix . 'blocks';
$_TABLES['commentcodes']        = $_DB_table_prefix . 'commentcodes';
$_TABLES['commentedits']        = $_DB_table_prefix . 'commentedits';
$_TABLES['commentmodes']        = $_DB_table_prefix . 'commentmodes';
$_TABLES['commentnotifications']= $_DB_table_prefix . 'commentnotifications';
$_TABLES['comments']            = $_DB_table_prefix . 'comments';
$_TABLES['commentsubmissions']  = $_DB_table_prefix . 'commentsubmissions';
$_TABLES['conf_values']         = $_DB_table_prefix . 'conf_values';
$_TABLES['cookiecodes']         = $_DB_table_prefix . 'cookiecodes';
$_TABLES['dateformats']         = $_DB_table_prefix . 'dateformats';
$_TABLES['featurecodes']        = $_DB_table_prefix . 'featurecodes';
$_TABLES['features']            = $_DB_table_prefix . 'features';
$_TABLES['frontpagecodes']      = $_DB_table_prefix . 'frontpagecodes';
$_TABLES['group_assignments']   = $_DB_table_prefix . 'group_assignments';
$_TABLES['groups']              = $_DB_table_prefix . 'groups';
$_TABLES['maillist']            = $_DB_table_prefix . 'maillist';
$_TABLES['pingservice']         = $_DB_table_prefix . 'pingservice';
$_TABLES['plugins']             = $_DB_table_prefix . 'plugins';
$_TABLES['postmodes']           = $_DB_table_prefix . 'postmodes';
$_TABLES['sessions']            = $_DB_table_prefix . 'sessions';
$_TABLES['sortcodes']           = $_DB_table_prefix . 'sortcodes';
$_TABLES['speedlimit']          = $_DB_table_prefix . 'speedlimit';
$_TABLES['statuscodes']         = $_DB_table_prefix . 'statuscodes';
$_TABLES['stories']             = $_DB_table_prefix . 'stories';
$_TABLES['storysubmission']     = $_DB_table_prefix . 'storysubmission';
$_TABLES['syndication']         = $_DB_table_prefix . 'syndication';
$_TABLES['tokens']              = $_DB_table_prefix . 'tokens';
$_TABLES['topics']              = $_DB_table_prefix . 'topics';
$_TABLES['trackback']           = $_DB_table_prefix . 'trackback';
$_TABLES['trackbackcodes']      = $_DB_table_prefix . 'trackbackcodes';
$_TABLES['usercomment']         = $_DB_table_prefix . 'usercomment';
$_TABLES['userindex']           = $_DB_table_prefix . 'userindex';
$_TABLES['userinfo']            = $_DB_table_prefix . 'userinfo';
$_TABLES['userprefs']           = $_DB_table_prefix . 'userprefs';
$_TABLES['users']               = $_DB_table_prefix . 'users';
$_TABLES['vars']                = $_DB_table_prefix . 'vars';


// Tables used by the bundled plugins

// Calendar plugin
$_TABLES['events']              = $_DB_table_prefix . 'events';
$_TABLES['eventsubmission']     = $_DB_table_prefix . 'eventsubmission';
$_TABLES['personal_events']     = $_DB_table_prefix . 'personal_events';

// Links plugin
$_TABLES['linkcategories']      = $_DB_table_prefix . 'linkcategories';
$_TABLES['links']               = $_DB_table_prefix . 'links';
$_TABLES['linksubmission']      = $_DB_table_prefix . 'linksubmission';

// Polls plugin
$_TABLES['pollanswers']         = $_DB_table_prefix . 'pollanswers';
$_TABLES['pollquestions']       = $_DB_table_prefix . 'pollquestions';
$_TABLES['polltopics']          = $_DB_table_prefix . 'polltopics';
$_TABLES['pollvoters']          = $_DB_table_prefix . 'pollvoters';

// Spam-X plugin
$_TABLES['spamx']               = $_DB_table_prefix . 'spamx';

// Static Pages plugin
$_TABLES['staticpage']          = $_DB_table_prefix . 'staticpage';


// These tables aren't used by Geeklog any more, but the table names are still
// needed when upgrading from old versions
$_TABLES['commentspeedlimit']   = $_DB_table_prefix . 'commentspeedlimit';
$_TABLES['submitspeedlimit']    = $_DB_table_prefix . 'submitspeedlimit';
$_TABLES['tzcodes']             = $_DB_table_prefix . 'tzcodes';
$_TABLES['userevent']           = $_DB_table_prefix . 'userevent';


// +---------------------------------------------------------------------------+
// | DO NOT TOUCH ANYTHING BELOW HERE                                          |
// +---------------------------------------------------------------------------+

/**
* Include appropriate DBMS object
*
*/
require_once $_CONF['path_system'] . 'databases/'. $_DB_dbms . '.class.php';

// Instantiate the database object
$_DB = new database($_DB_host, $_DB_name, $_DB_user, $_DB_pass, 'COM_errorLog',
                    $_CONF['default_charset']);
if (isset($_CONF['rootdebug']) && $_CONF['rootdebug']) {
    DB_displayError(true);
}

// +---------------------------------------------------------------------------+
// | These are the library functions.  In all cases they turn around and make  |
// | calls to the DBMS specific functions.  These ARE to be used directly in   |
// | the code...do NOT use the $_DB methods directly                           |
// +---------------------------------------------------------------------------+

/**
* Turns debug mode on for the database library
*
* Setting this to true will cause the database code to print out
* various debug messages.  Setting it to false will supress the
* messages (is false by default). NOTE: Gl developers have put many
* useful debug messages into the mysql implementation of this.  If
* you are using something other than MySQL and if the GL team did
* not write it then you may or may not get something useful by turning
* this on.
*
* @param        boolean     $flag       true or false
*
*/
function DB_setDebug($flag)
{
    global $_DB;

    $_DB->setVerbose($flag);
}

/** Setting this on will return the SQL error message.
* Default is to not display or return the SQL error but
* to record it in the error.log file
*
* @param        boolean     $flag       true or false
*/
function DB_displayError($flag)
{
    global $_DB;

    $_DB->setDisplayError($flag);
}

/**
* Executes a query on the db server
*
* This executes the passed SQL and returns the recordset or errors out
*
* @param    mixed   $sql            String or array of strings of SQL to be executed
* @param    int     $ignore_errors  If 1 this function supresses any error messages
* @return   object  Returns results from query
*
*/
function DB_query ($sql, $ignore_errors = 0)
{
    global $_DB, $_DB_dbms;

    if (is_array ($sql)) {
        if (isset ($sql[$_DB_dbms])) {
            $sql = $sql[$_DB_dbms];
        } else {
            $errmsg = "No SQL request given for DB '$_DB_dbms', only got these:";
            foreach ($sql as $db => $request) {
                $errmsg .= LB . $db . ': ' . $request;
            }
            $result = COM_errorLog ($errmsg, 3);
            die ($result);
        }
    }

    return $_DB->dbQuery ($sql, $ignore_errors);
}

/**
* Saves information to the database
*
* This will use a REPLACE INTO to save a record into the
* database. NOTE: this function is going to change in the near future
* to remove dependency of REPLACE INTO. Please use DB_query if you can
*
* @param        string      $table          The table to save to
* @param        string      $fields         Comma demlimited list of fields to save
* @param        string      $values         Values to save to the database table
* @param        string      $return_page    URL to send user to when done
*
*/
function DB_save($table,$fields,$values,$return_page='')
{
    global $_DB,$_TABLES,$_CONF;

    $_DB->dbSave($table,$fields,$values);

    if (!empty($return_page)) {
       print COM_refresh("$return_page");
    }

}

/**
* Deletes data from the database
*
* This will delete some data from the given table where id = value
*
* @param        string              $table          Table to delete data from
* @param        array|string        $id             field name(s) to use in where clause
* @param        array|string        $value          value(s) to use in where clause
* @param        string              $return_page    page to send user to when done
*
*/
function DB_delete($table,$id,$value,$return_page='')
{
    global $_DB,$_TABLES,$_CONF;

    $_DB->dbDelete($table,$id,$value);

    if (!empty($return_page)) {
        print COM_refresh("$return_page");
    }

}

/**
* Gets a single item from the database
*
* @param        string      $table      Table to get item from
* @param        string      $what       field name to get
* @param        string      $selection  Where clause to use in SQL
* @return       mixed       Returns value sought
*
*/
function DB_getItem($table,$what,$selection='')
{
    if (!empty($selection)) {
        $result = DB_query("SELECT $what FROM $table WHERE $selection");
    } else {
        $result = DB_query("SELECT $what FROM $table");
    }
    $ITEM = DB_fetchArray($result, true);
    return $ITEM[0];
}

/**
* Changes records in a table
*
* This will change the data in the given table that meet the given criteria and will
* redirect user to another page if told to do so
*
* @param        string          $table              Table to perform change on
* @param        string          $item_to_set        field name to set
* @param        string          $value_to_set       Value to set abovle field to
* @param        array|string    $id                 field name(s) to use in where clause
* @param        array|string    $value              Value(s) to use in where clause
* @param        string          $return_page        page to send user to when done with change
* @param        boolean         $supress_quotes     whether or not to use single quotes in where clause
*
*/
function DB_change($table,$item_to_set,$value_to_set,$id='',$value='',$return_page='',$supress_quotes=false)
{
    global $_DB,$_TABLES,$_CONF;

    $_DB->dbChange($table,$item_to_set,$value_to_set,$id,$value,$supress_quotes);

    if (!empty($return_page)) {
        print COM_refresh("$return_page");
    }
}

/**
* Count records in a table
*
* This will return the number of records which meet the given criteria in the
* given table.
*
* @param        string              $table      Table to perform count on
* @param        array|string        $id         field name(s) to use in where clause
* @param        array|string        $value      Value(s) to use in where clause
* @return       int     Returns row count from generated SQL
*
*/
function DB_count($table,$id='',$value='')
{
    global $_DB;

    return $_DB->dbCount($table,$id,$value);
}

/**
* Copies a record from one table to another (can be the same table)
*
* This will use a REPLACE INTO...SELECT FROM to copy a record from one table
* to another table.  They can be the same table.
*
* @param        string          $table          Table to insert record into
* @param        string          $fields         Comma delmited list of fields to copy over
* @param        string          $values         Values to store in database field
* @param        string          $tablefrom      Table to get record from
* @param        array|string    $id             Field name(s) to use in where clause
* @param        array|string    $value          Value(s) to use in where clause
* @param        string          $return_page    Page to send user to when done
*
*/
function DB_copy($table,$fields,$values,$tablefrom,$id,$value,$return_page='')
{
    global $_DB,$_TABLES,$_CONF;

    $_DB->dbCopy($table,$fields,$values,$tablefrom,$id,$value);

    if (!empty($return_page)) {
        print COM_refresh("$return_page");
    }
}

/**
* Retrieves the number of rows in a recordset
*
* This returns the number of rows in a recordset
*
* @param        object     $recordset      The recordset to operate one
* @return       int         Returns number of rows returned by a previously executed query
*
*/
function DB_numRows($recordset)
{
    global $_DB;

    return $_DB->dbNumRows($recordset);
}

/**
* Retrieves the contents of a field
*
* This returns the contents of a field from a result set
*
* @param        object      $recordset      The recordset to operate on
* @param        int         $row            row to get data from
* @param        string      $field          field to return
* @return       (depends on the contents of the field)
*
*/
function DB_result($recordset,$row,$field)
{
    global $_DB;

    return $_DB->dbResult($recordset,$row,$field);
}

/**
* Retrieves the number of fields in a recordset
*
* This returns the number of fields in a recordset
*
* @param        object     $recordset       The recordset to operate on
* @return       int         Returns the number fields in a result set
*
*/
function DB_numFields($recordset)
{
    global $_DB;

    return $_DB->dbNumFields($recordset);
}

/**
* Retrieves returns the field name for a field
*
* Returns the field name for a given field number
*
* @param        object      $recordset      The recordset to operate on
* @param        int         $fnumber        field number to return the name of
* @return       string      Returns name of specified field
*
*/
function DB_fieldName($recordset,$fnumber)
{
    global $_DB;

    return $_DB->dbFieldName($recordset,$fnumber);
}

/**
* Retrieves returns the number of effected rows for last query
*
* Retrieves returns the number of effected rows for last query
*
* @param        object      $recordset      The recordset to operate on
* @return       int         returns numbe of rows affected by previously executed query
*
*/
function DB_affectedRows($recordset)
{
    global $_DB;

    return $_DB->dbAffectedRows($recordset);
}

/**
* Retrieves record from a recordset
*
* Gets the next record in a recordset and returns in array
*
* @param        object      $recordset      The recordset to operate on
* @param        boolean     $both           get both assoc and numeric indices
* @return       Array      Returns data for a record in an array
*
*/
function DB_fetchArray($recordset, $both = true)
{
    global $_DB;

    return $_DB->dbFetchArray($recordset, $both);
}

/**
* Returns the last ID inserted
*
* Returns the last auto_increment ID generated
*
* @param    resources   $link_identifier    identifier for opened link
* @return   int                             Returns the last ID auto-generated
*
*/
function DB_insertId($link_identifier = '',$sequence='')
{
    global $_DB;

    return $_DB->dbInsertId($link_identifier,$sequence);
}

/**
* returns a database error string
*
* Returns an database error message
*
* @return   string  Returns database error message
*
*/
function DB_error()
{
    global $_DB;

    return $_DB->dbError();
}

/**
* Creates database structures for fresh installation
*
* This may not be used by Geeklog currently
*
* @return   boolean     returns true on success otherwise false
*
*/
function DB_createDatabaseStructures()
{
    global $_DB;

    return $_DB->dbCreateStructures();
}

/**
* Executes the sql upgrade script(s)
*
* @param        string      $current_gl_version     version of geeklog to upgrade from
* @return       boolean     returns true on success otherwise false
*
*/
function DB_doDatabaseUpgrade($current_gl_version)
{
    global $_DB;

    return $_DB->dbDoDatabaseUpgrade($current_gl_version);
}

/**
* Lock a table
*
* Locks a table for write operations
*
* @param    string      $table      Table to lock
* @return   void
* @see DB_unlockTable
*
*/
function DB_lockTable($table)
{
    global $_DB;

    $_DB->dbLockTable($table);
}

/**
* Unlock a table
*
* Unlocks a table after DB_lockTable
*
* @param    string      $table      Table to unlock
* @return   void
* @see DB_lockTable
*
*/
function DB_unlockTable($table)
{
    global $_DB;

    $_DB->dbUnlockTable($table);
}

/**
 * Check if a table exists
 *
 * @param   string $table   Table name
 * @return  boolean         True if table exists, false if it does not
 *
 */
function DB_checkTableExists($table)
{
    global $_TABLES, $_DB_dbms;

    $exists = false;

    if ($_DB_dbms == 'mysql') {
        $result = DB_query ("SHOW TABLES LIKE '{$_TABLES[$table]}'");
        if (DB_numRows ($result) > 0) {
            $exists = true;
        }
    } elseif ($_DB_dbms == 'mssql') {
        $result = DB_query("SELECT 1 FROM sysobjects WHERE name='{$_TABLES[$table]}' AND xtype='U'");
        if (DB_numRows ($result) > 0) {
            $exists = true;
        }
    }
    elseif ($_DB_dbms == 'pgsql') {
        $result = DB_query("select check_table('{$_TABLES[$table]}', 'public');");
        $row=DB_fetchArray($result);
        if(!empty($row[0])){
            $exists = true;
        }
    }

    return $exists;
}

/**
* Parse a CSV-like SQL string, as used by DB_save
*
* This function will help parse the CVS-like strings that are used by DB_save.
* Those are specific to MySQL and have to be handled separately by other DBs.
*
* Since nothing can do this properly, I had to write it myself.
* Trick is that a string csv may have a comma within a delimited csv field
* which explode can't handle.
*
* @param    string  $csv    The string to parse
* @return   array           parsed string contents
* @author   Randy Kolenko
* @see      DB_save
* @internal to be used by the DB drivers only
*
*/
function DBINT_parseCsvSqlString($csv)
{
    $len = strlen($csv);
    $mode = 0;  // mode=0 for non string, mode=1 for string
    $retArray = array();
    $thisValue = '';
    for ($x = 0; $x < $len; $x++) {
        // loop thru the string
        if ($csv[$x] == "'") {
            if ($x != 0) {
                if ($csv[$x-1] != "\\") {
                    /**
                    * this means that the preceeding char is not escape..
                    * thus this is either the end of a mode 1 or the beginning
                    * of a mode 1
                    */
                    if ($mode == 1) {
                        $mode = 0;
                        // this means that we are done this string value
                        // don't add this character to the string
                    } else {
                        $mode = 1;
                        // don't add this character to the string....
                    }
                } else {
                    //this is a character to add.....
                    $thisValue = $thisValue . $csv[$x];
                }
            } else {
                // x==0
                $mode = 1;
            }
        } elseif ($csv[$x] == ",") {
            if ($mode == 1) {
                // this means that the comma falls INSIDE of a string.
                // its a keeper
                $thisValue = $thisValue . $csv[$x];
            } else {
                // this is the dilineation between fields.. pop this value
                array_push($retArray, $thisValue);
                $thisValue = '';
                $mode = 0;
            }
        } else {
            // just add it!
            $thisValue = $thisValue . $csv[$x];
        }
    }
    array_push($retArray, $thisValue);

    return $retArray;
}

/**
* @return     string     the version of the database server
*/

function DB_getVersion()
{
    global $_DB;

    return $_DB->dbGetVersion();
}


?>
