<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-database.php                                                          |
// |                                                                           |
// | Geeklog database library.                                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2021 by the following authors:                         |
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
 * NOTE: As of Geeklog 1.3.5 you should not have to edit this file any more.
 */

use Geeklog\Database\DbMysql;
use Geeklog\Database\DbMysqli;
use Geeklog\Database\DbPgsql;

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

global $_CONF, $_DB, $_TABLES, $_DB_dbms, $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix, $_DB_charset;

// +---------------------------------------------------------------------------+
// | Table definitions, these are used by the install program to create the    |
// | database schema.  If you don't like the tables names, change them PRIOR   |
// | to running the install after running the install program DO NOT TOUCH     |
// | these. You have been warned!  Also, these variables are used in the core  |
// | Geeklog code                                                              |
// +---------------------------------------------------------------------------+

$_TABLES['access'] = $_DB_table_prefix . 'access';
$_TABLES['article_images'] = $_DB_table_prefix . 'article_images';
$_TABLES['backup_codes'] = $_DB_table_prefix . 'backup_codes';
$_TABLES['blocks'] = $_DB_table_prefix . 'blocks';
$_TABLES['commentedits'] = $_DB_table_prefix . 'commentedits';
$_TABLES['commentnotifications'] = $_DB_table_prefix . 'commentnotifications';
$_TABLES['comments'] = $_DB_table_prefix . 'comments';
$_TABLES['commentsubmissions'] = $_DB_table_prefix . 'commentsubmissions';
$_TABLES['conf_values'] = $_DB_table_prefix . 'conf_values';
$_TABLES['cookiecodes'] = $_DB_table_prefix . 'cookiecodes';
$_TABLES['dateformats'] = $_DB_table_prefix . 'dateformats';
$_TABLES['features'] = $_DB_table_prefix . 'features';
$_TABLES['group_assignments'] = $_DB_table_prefix . 'group_assignments';
$_TABLES['groups'] = $_DB_table_prefix . 'groups';
$_TABLES['ip_addresses'] = $_DB_table_prefix . 'ip_addresses';
$_TABLES['language_items'] = $_DB_table_prefix . 'language_items';
$_TABLES['likes'] = $_DB_table_prefix . 'likes'; // As of Geeklog 2.2.1
$_TABLES['maillist'] = $_DB_table_prefix . 'maillist';
$_TABLES['pingservice'] = $_DB_table_prefix . 'pingservice';
$_TABLES['plugins'] = $_DB_table_prefix . 'plugins';
$_TABLES['routes'] = $_DB_table_prefix . 'routes';
$_TABLES['sessions'] = $_DB_table_prefix . 'sessions';
$_TABLES['speedlimit'] = $_DB_table_prefix . 'speedlimit';
$_TABLES['stories'] = $_DB_table_prefix . 'stories';
$_TABLES['storysubmission'] = $_DB_table_prefix . 'storysubmission';
$_TABLES['syndication'] = $_DB_table_prefix . 'syndication';
$_TABLES['tokens'] = $_DB_table_prefix . 'tokens';
$_TABLES['topic_assignments'] = $_DB_table_prefix . 'topic_assignments';
$_TABLES['topics'] = $_DB_table_prefix . 'topics';
$_TABLES['trackback'] = $_DB_table_prefix . 'trackback';
$_TABLES['usercomment'] = $_DB_table_prefix . 'usercomment';
$_TABLES['userindex'] = $_DB_table_prefix . 'userindex';
$_TABLES['userinfo'] = $_DB_table_prefix . 'userinfo';
$_TABLES['userprefs'] = $_DB_table_prefix . 'userprefs';
$_TABLES['userautologin'] = $_DB_table_prefix . 'userautologin';
$_TABLES['users'] = $_DB_table_prefix . 'users';
$_TABLES['vars'] = $_DB_table_prefix . 'vars';

// The tables were dropped as of Geeklog 2.2.0, but are used as part of code
$_TABLES['commentcodes'] = $_DB_table_prefix . 'commentcodes';
$_TABLES['commentmodes'] = $_DB_table_prefix . 'commentmodes';
$_TABLES['featurecodes'] = $_DB_table_prefix . 'featurecodes';
$_TABLES['frontpagecodes'] = $_DB_table_prefix . 'frontpagecodes';
$_TABLES['postmodes'] = $_DB_table_prefix . 'postmodes';
$_TABLES['sortcodes'] = $_DB_table_prefix . 'sortcodes';
$_TABLES['statuscodes'] = $_DB_table_prefix . 'statuscodes';
$_TABLES['trackbackcodes'] = $_DB_table_prefix . 'trackbackcodes';

// Tables used by the bundled plugins

// Calendar plugin
$_TABLES['events'] = $_DB_table_prefix . 'events';
$_TABLES['eventsubmission'] = $_DB_table_prefix . 'eventsubmission';
$_TABLES['personal_events'] = $_DB_table_prefix . 'personal_events';

// Links plugin
$_TABLES['linkcategories'] = $_DB_table_prefix . 'linkcategories';
$_TABLES['links'] = $_DB_table_prefix . 'links';
$_TABLES['linksubmission'] = $_DB_table_prefix . 'linksubmission';

// Polls plugin
$_TABLES['pollanswers'] = $_DB_table_prefix . 'pollanswers';
$_TABLES['pollquestions'] = $_DB_table_prefix . 'pollquestions';
$_TABLES['polltopics'] = $_DB_table_prefix . 'polltopics';
$_TABLES['pollvoters'] = $_DB_table_prefix . 'pollvoters';

// Spam-X plugin
$_TABLES['spamx'] = $_DB_table_prefix . 'spamx';

// Static Pages plugin
$_TABLES['staticpage'] = $_DB_table_prefix . 'staticpage';

// These tables aren't used by Geeklog any more, but the table names are still
// needed when upgrading from old versions
$_TABLES['commentspeedlimit'] = $_DB_table_prefix . 'commentspeedlimit';
$_TABLES['submitspeedlimit'] = $_DB_table_prefix . 'submitspeedlimit';
$_TABLES['tzcodes'] = $_DB_table_prefix . 'tzcodes';
$_TABLES['userevent'] = $_DB_table_prefix . 'userevent';

// +---------------------------------------------------------------------------+
// | DO NOT TOUCH ANYTHING BELOW HERE                                          |
// +---------------------------------------------------------------------------+

// Set the appropriate database character set
if (empty($_DB_charset)) {
    $_DB_charset = $_CONF['default_charset'];
}

if (!class_exists('Geeklog\\Autoload')) {
    include_once __DIR__ . '/classes/Autoload.php';
    Geeklog\Autoload::initialize();
}

if ($_DB_dbms === 'mysql') {
    if (class_exists('MySQLi')) {
        $_DB = new Geeklog\Database\DbMysqli($_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix, 'COM_errorLog', $_DB_charset);
    } else {
        $_DB = new Geeklog\Database\DbMysql($_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix, 'COM_errorLog', $_DB_charset);
    }
} elseif ($_DB_dbms === 'pgsql') {
    $_DB = new Geeklog\Database\DbPgsql($_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix, 'COM_errorLog', $_DB_charset);
} else {
    throw new InvalidArgumentException(sprintf('Unknown database driver "%s" was specified', $_DB_dbms));
}

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
 * Setting this to true will cause the database code to print out
 * various debug messages.  Setting it to false will supress the
 * messages (is false by default). NOTE: Gl developers have put many
 * useful debug messages into the mysql implementation of this.  If
 * you are using something other than MySQL and if the GL team did
 * not write it then you may or may not get something useful by turning
 * this on.
 *
 * @param        boolean $flag true or false
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
 * @param        boolean $flag true or false
 */
function DB_displayError($flag)
{
    global $_DB;

    $_DB->setDisplayError($flag);
}

/**
 * Executes a query on the db server
 * This executes the passed SQL and returns the recordset or errors out
 *
 * @param    mixed       $sql           String or array of strings of SQL to be executed
 * @param    int         $ignore_errors If 1 this function supresses any error messages
 * @return   object|bool                Returns results from query
 */
function DB_query($sql, $ignore_errors = 0)
{
    global $_DB, $_DB_dbms;

    if (is_array($sql)) {
        if (isset ($sql[$_DB_dbms])) {
            $sql = $sql[$_DB_dbms];
        } else {
            $errmsg = "No SQL request given for DB '{$_DB_dbms}', only got these:";
            foreach ($sql as $db => $request) {
                $errmsg .= PHP_EOL . $db . ': ' . $request;
            }
            $result = COM_errorLog($errmsg, 3);
            die ($result);
        }
    }

    return $_DB->dbQuery($sql, $ignore_errors);
}

/**
 * Saves information to the database
 * This will use a REPLACE INTO to save a record into the
 * database. NOTE: this function is going to change in the near future
 * to remove dependency of REPLACE INTO. Please use DB_query if you can
 *
 * @param        string $table       The table to save to
 * @param        string $fields      Comma delimited list of fields to save
 * @param        string $values      Values to save to the database table
 * @param        string $return_page URL to send user to when done
 */
function DB_save($table, $fields, $values, $return_page = '')
{
    global $_DB;

    $_DB->dbSave($table, $fields, $values);

    if (!empty($return_page)) {
        COM_redirect("$return_page");
    }
}

/**
 * Deletes data from the database
 * This will delete some data from the given table where id = value
 *
 * @param        string       $table       Table to delete data from
 * @param        array|string $id          field name(s) to use in where clause
 * @param        array|string $value       value(s) to use in where clause
 * @param        string       $return_page page to send user to when done
 */
function DB_delete($table, $id, $value, $return_page = '')
{
    global $_DB;

    $_DB->dbDelete($table, $id, $value);

    if (!empty($return_page)) {
        COM_redirect("$return_page");
    }
}

/**
 * Gets a single item from the database
 *
 * @param        string $table        Table to get item from
 * @param        string $what         field name to get
 * @param        string $selection    Where clause to use in SQL
 * @param        mixed  $defaultValue will be returned when there is no row in the dataset
 * @return       mixed                Returns value sought
 * @note         $defaultValue argument since Geeklog 2,2,1
 */
function DB_getItem($table, $what, $selection = '', $defaultValue = false)
{
    if (!empty($selection)) {
        $result = DB_query("SELECT {$what} FROM {$table} WHERE {$selection}");
    } else {
        $result = DB_query("SELECT {$what} FROM {$table}");
    }
    $ITEM = DB_fetchArray($result, true);

    return (is_array($ITEM) && (count($ITEM) > 0)) ? $ITEM[0] : $defaultValue;
}

/**
 * Changes records in a table
 * This will change the data in the given table that meet the given criteria and will
 * redirect user to another page if told to do so
 *
 * @param        string       $table           Table to perform change on
 * @param        string       $item_to_set     field name to set
 * @param        string       $value_to_set    Value to set above field to
 * @param        array|string $id              field name(s) to use in where clause
 * @param        array|string $value           Value(s) to use in where clause
 * @param        string       $return_page     page to send user to when done with change
 * @param        boolean      $suppress_quotes whether or not to use single quotes in where clause
 */
function DB_change($table, $item_to_set, $value_to_set, $id = '', $value = '', $return_page = '', $suppress_quotes = false)
{
    global $_DB;

    $_DB->dbChange($table, $item_to_set, $value_to_set, $id, $value, $suppress_quotes);

    if (!empty($return_page)) {
        COM_redirect($return_page);
    }
}

/**
 * Count records in a table
 * This will return the number of records which meet the given criteria in the
 * given table.
 *
 * @param        string       $table Table to perform count on
 * @param        array|string $id    field name(s) to use in where clause
 * @param        array|string $value Value(s) to use in where clause
 * @return       int     Returns row count from generated SQL
 */
function DB_count($table, $id = '', $value = '')
{
    global $_DB;

    return $_DB->dbCount($table, $id, $value);
}

/**
 * Copies a record from one table to another (can be the same table)
 * This will use a REPLACE INTO...SELECT FROM to copy a record from one table
 * to another table.  They can be the same table.
 *
 * @param        string       $table       Table to insert record into
 * @param        string       $fields      Comma delimited list of fields to copy over
 * @param        string       $values      Values to store in database field
 * @param        string       $tableFrom   Table to get record from
 * @param        array|string $id          Field name(s) to use in where clause
 * @param        array|string $value       Value(s) to use in where clause
 * @param        string       $return_page Page to send user to when done
 */
function DB_copy($table, $fields, $values, $tableFrom, $id, $value, $return_page = '')
{
    global $_DB;

    $_DB->dbCopy($table, $fields, $values, $tableFrom, $id, $value);

    if (!empty($return_page)) {
        COM_redirect("$return_page");
    }
}

/**
 * Retrieves the number of rows in a record set
 * This returns the number of rows in a record set
 *
 * @param        mixed $recordSet The record set to operate one
 * @return       int         Returns number of rows returned by a previously executed query
 */
function DB_numRows($recordSet)
{
    global $_DB;

    return $_DB->dbNumRows($recordSet);
}

/**
 * Retrieves the contents of a field
 * This returns the contents of a field from a result set
 *
 * @param        mixed  $recordSet The record set to operate on
 * @param        int    $row       row to get data from
 * @param        string $field     field to return
 * @return       mixed (depends on the contents of the field)
 */
function DB_result($recordSet, $row, $field)
{
    global $_DB;

    return $_DB->dbResult($recordSet, $row, $field);
}

/**
 * Retrieves the number of fields in a record set
 * This returns the number of fields in a record set
 *
 * @param        mixed $recordSet The record set to operate on
 * @return       int         Returns the number fields in a result set
 */
function DB_numFields($recordSet)
{
    global $_DB;

    return $_DB->dbNumFields($recordSet);
}

/**
 * Retrieves returns the field name for a field
 * Returns the field name for a given field number
 *
 * @param        mixed $recordSet   The record set to operate on
 * @param        int   $fieldNumber field number to return the name of
 * @return       string      Returns name of specified field
 */
function DB_fieldName($recordSet, $fieldNumber)
{
    global $_DB;

    return $_DB->dbFieldName($recordSet, $fieldNumber);
}

/**
 * Retrieves returns the number of effected rows for last query
 * Retrieves returns the number of effected rows for last query
 *
 * @param        mixed $recordSet The record set to operate on
 * @return       int         returns number of rows affected by previously executed query
 */
function DB_affectedRows($recordSet)
{
    global $_DB;

    return $_DB->dbAffectedRows($recordSet);
}

/**
 * Retrieves record from a record set
 * Gets the next record in a record set and returns in array
 *
 * @param        mixed   $recordSet The record set to operate on
 * @param        boolean $both      get both assoc and numeric indices
 * @return       array      Returns data for a record in an array
 */
function DB_fetchArray($recordSet, $both = true)
{
    global $_DB;

    return $_DB->dbFetchArray($recordSet, $both);
}

/**
 * Returns the last ID inserted
 * Returns the last auto_increment ID generated
 *
 * @param    resource $link_identifier identifier for opened link
 * @param    string   $sequence        sequence for PostgreSQL
 * @return   mixed                     Returns the last ID auto-generated
 */
function DB_insertId($link_identifier = null, $sequence = '')
{
    global $_DB;

    return $_DB->dbInsertId($link_identifier, $sequence);
}

/**
 * returns a database error string
 * Returns an database error message
 *
 * @return   string  Returns database error message
 */
function DB_error()
{
    global $_DB;

    return $_DB->dbError();
}

/**
 * Creates database structures for fresh installation
 * This may not be used by Geeklog currently
 *
 * @return   boolean     returns true on success otherwise false
 */
function DB_createDatabaseStructures()
{
    global $_DB;

    return $_DB->dbCreateStructures();
}

/**
 * Executes the sql upgrade script(s)
 *
 * @param        string $current_gl_version version of geeklog to upgrade from
 * @return       boolean     returns true on success otherwise false
 */
function DB_doDatabaseUpgrade($current_gl_version)
{
    global $_DB;

    return $_DB->dbDoDatabaseUpgrade($current_gl_version);
}

/**
 * Lock a table/tables
 * Locks a table/tables for write operations
 *
 * @param    string|string[] $table Table to lock
 * @see DB_unlockTable
 */
function DB_lockTable($table)
{
    global $_DB;

    $_DB->dbLockTable($table);
}

/**
 * Unlock a table/tables
 * Unlocks a table/tables after DB_lockTable
 *
 * @param    string|string[] $table Table to unlock
 * @see DB_lockTable
 */
function DB_unlockTable($table)
{
    global $_DB;

    $_DB->dbUnlockTable($table);
}

/**
 * Check if a table exists
 *
 * @param   string $table Table name
 * @return  boolean         True if table exists, false if it does not
 */
function DB_checkTableExists($table)
{
    global $_DB;

    return $_DB->dbTableExists($table);
}

/**
 * Parse a CSV-like SQL string, as used by DB_save
 * This function will help parse the CVS-like strings that are used by DB_save.
 * Those are specific to MySQL and have to be handled separately by other DBs.
 * Since nothing can do this properly, I had to write it myself.
 * Trick is that a string csv may have a comma within a delimited csv field
 * which explode can't handle.
 *
 * @param    string $csv The string to parse
 * @return   array           parsed string contents
 * @author   Randy Kolenko
 * @see      DB_save
 * @internal to be used by the DB drivers only
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
                if ($csv[$x - 1] != "\\") {
                    /**
                     * this means that the preceding char is not escape..
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
        } elseif ($csv[$x] == ',') {
            if ($mode == 1) {
                // this means that the comma falls INSIDE of a string.
                // its a keeper
                $thisValue = $thisValue . $csv[$x];
            } else {
                // this is the delineation between fields.. pop this value
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
 * Return database version
 *
 * @return  string the version of the database server
 */
function DB_getVersion()
{
    global $_DB;

    return $_DB->dbGetVersion();
}

/**
 * Escapes a string so that it can be safely used in a query
 *
 * @param   string $str a string to be escaped
 * @return  string
 */
function DB_escapeString($str)
{
    global $_DB;

    return $_DB->dbEscapeString($str);
}

/**
 * @param int $mode use one of Database::MYSQL_SQL_MODE_xxx constant
 */
function DB_setMysqlSqlMode($mode)
{
    global $_DB, $_DB_dbms;

    if ($_DB_dbms === 'mysql') {
        $_DB->setSqlMode($mode);
    }
}

/**
 * Return if database server (only MySQL) supports InnoDB engine
 *
 * @return bool
 */
function DB_isInnoDb()
{
    global $_DB, $_DB_dbms;

    if ($_DB_dbms === 'mysql') {
        return $_DB->isInnoDb();
    } else {
        return false;
    }
}

/**
 * Start a new transaction
 *
 * @return bool true on success, false otherwise
 */
function DB_beginTransaction()
{
    global $_DB;

    return $_DB->dbStartTransaction();
}

/**
 * Commit the current transaction
 *
 * @return bool true on success, false otherwise
 */
function DB_commit()
{
    global $_DB;

    return $_DB->dbCommit();
}

/**
 * Rollback the current transaction
 *
 * @return bool true on success, false otherwise
 */
function DB_rollBack()
{
    global $_DB;

    return $_DB->dbRollback();
}

/**
 * Return if InnoDB storage engine is supported
 *
 * @return bool
 */
function DB_innoDbSupported()
{
    global $_DB_dbms, $_DB;

    if ($_DB_dbms === 'mysql') {
        return $_DB->isInnodbSupported();
    } else {
        return false;
    }
}

/**
 * Return a list of tables used for the Geeklog installation
 *
 * @return string[]
 * @since  Geeklog 2.2.2
 */
function DB_getAllTables()
{
    global $_DB;

    return $_DB->dbGetAllTables();
}

/**
 * Return the structure of a table given
 *
 * @param  string  $tableName
 * @return string
 * @since  Geeklog 2.2.2
 */
function DB_getTableStructure($tableName)
{
    global $_DB;

    return $_DB->dbGetTableStructure($tableName);
}

/**
 * Escape an identifier like a database name or a table name
 *
 * @param  string  $identifier
 * @return string
 * @since  Geeklog 2.2.2
 */
function DB_escapeIdentifier($identifier)
{
    global $_DB;

    return $_DB->dbEscapeIdentifier($identifier);
}
