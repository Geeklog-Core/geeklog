<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-database.php                                                          |
// | Geeklog database library.                                                 |
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

// Database connection parameters
$_DB_dbms           = '{dbms}';
$_DB_host           = '{dbhost}';
$_DB_name           = '{dbname}';
$_DB_user           = '{dbuser}';
$_DB_pass           = '{dbpass}';
$_DB_table_prefix   = '{dbprefix}'; // e.g. 'gl_'

// +---------------------------------------------------------------------------+
// | Table definitions, these are used by the install program to create the    |
// | database schema.  If you don't like the tables names, change them PRIOR   |
// | to running the install after running the install program DO NOT TOUCH     |
// | these. You have been warned!  Also, these variables are used in the core  |
// | Geeklog code                                                              |
// +---------------------------------------------------------------------------+

$_TABLES['access']              = '{cfg_tbl_access}';
$_TABLES['blocks']              = '{cfg_tbl_blocks}';
$_TABLES['commentcodes']        = '{cfg_tbl_commentcodes}';
$_TABLES['commentmodes']        = '{cfg_tbl_commentmodes}';
$_TABLES['comments']            = '{cfg_tbl_comments}';
$_TABLES['commentspeedlimit']   = '{cfg_tbl_commentspeedlimit}';
$_TABLES['cookiecodes']         = '{cfg_tbl_cookiecodes}';
$_TABLES['dateformats']         = '{cfg_tbl_dateformats}';
$_TABLES['events']              = '{cfg_tbl_events}';
$_TABLES['eventsubmission']     = '{cfg_tbl_eventsubmission}';
$_TABLES['featurecodes']        = '{cfg_tbl_featurecodes}';
$_TABLES['features']            = '{cfg_tbl_features}';
$_TABLES['frontpagecodes']      = '{cfg_tbl_frontpagecodes}';
$_TABLES['group_assignments']   = '{cfg_tbl_group_assignments}';
$_TABLES['groups']              = '{cfg_tbl_groups}';
$_TABLES['links']               = '{cfg_tbl_links}';
$_TABLES['linksubmission']      = '{cfg_tbl_linksubmission}';
$_TABLES['maillist']            = '{cfg_tbl_maillist}';
$_TABLES['personal_events']     = '{cfg_tbl_personal_events}';
$_TABLES['plugins']             = '{cfg_tbl_plugins}';
$_TABLES['pollanswers']         = '{cfg_tbl_pollanswers}';
$_TABLES['pollquestions']       = '{cfg_tbl_pollquestions}';
$_TABLES['pollvoters']          = '{cfg_tbl_pollvoters}';
$_TABLES['postmodes']           = '{cfg_tbl_postmodes}';
$_TABLES['sessions']            = '{cfg_tbl_sessions}';
$_TABLES['sortcodes']           = '{cfg_tbl_sortcodes}';
$_TABLES['statuscodes']         = '{cfg_tbl_statuscodes}';
$_TABLES['stories']             = '{cfg_tbl_stories}';
$_TABLES['storysubmission']     = '{cfg_tbl_storysubmission}';
$_TABLES['submitspeedlimit']    = '{cfg_tbl_submitspeedlimit}';
$_TABLES['topics']              = '{cfg_tbl_topics}';
$_TABLES['tzcodes']             = '{cfg_tbl_tzcodes}';
$_TABLES['usercomment']         = '{cfg_tbl_usercomment}';
$_TABLES['userevent']           = '{cfg_tbl_userevent}';
$_TABLES['userindex']           = '{cfg_tbl_userindex}';
$_TABLES['userinfo']            = '{cfg_tbl_userinfo}';
$_TABLES['userprefs']           = '{cfg_tbl_userprefs}';
$_TABLES['users']               = '{cfg_tbl_users}';
$_TABLES['vars']                = '{cfg_tbl_vars}';
$_TABLES['wordlist']            = '{cfg_tbl_wordlist}';

// +---------------------------------------------------------------------------+
// | DO NOT TOUCH ANYTHING BELOW HERE                                          |
// +---------------------------------------------------------------------------+

// Include appropriate DBMS object
include_once($_CONF['path_system'] . 'databases/'. $_DB_dbms . '.class.php');

// Instantiate the database object
$_DB = new database($_DB_host,$_DB_name,$_DB_user,$_DB_pass,'COM_errorLog');

// +---------------------------------------------------------------------------+
// | These are the library functions.  In all cases they turn around and make  |
// | calls to the DBMS specific functions.  These ARE to be used directly in   |
// | the code...do NOT use the $_DB methods directly
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
* @flag		boolean		true or false
*
*/
function DB_setdebug($flag)
{
    global $_DB;

    $_DB->setVerbose($flag);
}

/**
* Executes a query on the db server 
*
* This executes the passed SQL and returns the recordset or errors out
*
* @sql          string  SQL to be executed
* @ignore_error int     If 1 this function supresses any error messages
*
*/
function DB_query($sql, $ignore_errors=0)
{
    global $_DB;
    
    return $_DB->dbQuery($sql,$ignore_errors);
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
* @return_page  string  URL to send user to when done
*
*/
function DB_save($table,$fields,$values,$return_page='') 
{
    global $_DB,$_TABLES,$_CONF;

    $_DB->dbSave($table,$fields,$values);

    if ($table == $_TABLES['stories']) {
       COM_exportRDF();
       COM_olderStuff();
    }

    if (!empty($return_page)) {
       print COM_refresh($_CONF['site_url'] . "/$return_page");
    }

}

/**
* Deletes data from the database
*
* This will delete some data from the given table where id = value
*
* @table        string          Table to delete data from
* @id           array|string    field name(s) to use in where clause
* @value        array|string   	value(s) to use in where clause 
*
*/
function DB_delete($table,$id,$value,$return_page='')
{
    global $_DB,$_TABLES,$_CONF;

    $_DB->dbDelete($table,$id,$value);

    if ($table == $_TABLES['stories']) {
        COM_exportRDF();
        COM_olderStuff();
    }

    if (!empty($return_page)) {
        print COM_refresh($_CONF['site_url'] . "/$return_page");
    }

}

/**
* Gets a single item from the database
*
* @table        string        Table to get item from
* @what         string        field name to get
* @selection    string        Where clause to use in SQL
*
*/
function DB_getItem($table,$what,$selection='') 
{
    if (!empty($selection)) {
        $result = DB_query("SELECT $what FROM $table WHERE $selection");
    } else {
        $result = DB_query("SELECT $what FROM $table");
    }
    $ITEM = DB_fetchArray($result);
    return $ITEM[0];
}

/**
* Changes records in a table
*
* This will change the data in the given table that meet the given criteria and will
* redirect user to another page if told to do so
*
* @table        string          Table to perform change on
* @item_to_set  string          field name to set 
* @value_to_set string          Value to set abovle field to 
* @id           array|string    field name(s) to use in where clause 
* @value        array|string    Value(s) to use in where clause
* @return_page	string          page to send user to when done with change
*
*/
function DB_change($table,$item_to_set,$value_to_set,$id='',$value='',$return_page='',$supress_quotes=false) 
{
    global $_DB,$_TABLES,$_CONF;

    $_DB->dbChange($table,$item_to_set,$value_to_set,$id,$value,$supress_quotes);

    if ($table == $_TABLES['stories']) {
        COM_exportRDF();
        COM_olderStuff();
    }

    if (!empty($return_page)) {
        print COM_refresh($_CONF['site_url'] . "/$return_page");
    }
}

/**
* Changes records in a table
*
* This will change the data in the given table that meet the 
* given criteria and will redirect user to another page if 
* told to do so
*
* @table        string          Table to perform count on
* @id           array|string    field name(s) to use in where clause
* @value        array|string    Value(s) to use in where clause
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
* @table        string          Table to insert record into
* @fields       string          Comma delmited list of fields to copy over
* @values       string          Values to store in database field
* @tablefrom    string          Table to get record from
* @id           array|string   	Field name(s) to use in where clause 
* @value        array|string    Value(s) to use in where clause
* @return_page  string          Page to send user to when done
*
*/
function DB_copy($table,$fields,$values,$tablefrom,$id,$value,$return_page='') 
{
    global $_DB,$_TABLES,$_CONF;

    $_DB->dbCopy($table,$fields,$values,$tablefrom,$id,$value);

    if ($table == $_TABLES['stories']) {
        COM_exportRDF();
        COM_olderStuff();
    }

    if (!empty($return_page)) {
        print COM_refresh($_CONF['site_url'] . "/$return_page");
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
function DB_numRows($recordset)
{
    global $_DB;

    return $_DB->dbNumRows($recordset);
}

/**
* Retrieves the number of rows in a recordset
*
* This returns the number of rows in a recordset
*
* @recordset    object      The recordset to operate one
* @row          int         row to get data from
* @field        string      field to return
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
* @recordset    object     The recordset to operate on
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
* @recordset object     The recordset to operate on
* @fnumber      int     field number to return the name of
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
* @recordset object     The recordset to operate on
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
* @recordset    object  The recordset to operate on
*
*/
function DB_fetchArray($recordset)
{
    global $_DB;

    return $_DB->dbFetchArray($recordset);
}

/**
* Returns the last ID inserted
*
* Returns the last auto_increment ID generated for recordset
*
* @recordset    object  Recorset to operate on
*/
function DB_insertId($recordset='')
{
    global $_DB;

    return $_DB->dbInsertId($recordset);
}

/**
* returns a database error string
*
* Returns an database error message
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
*/
function DB_createDatabaseStructures() 
{
    global $_DB;

    return $_DB->dbCreateStructures();
}

/**
* Executes the sql upgrade script(s)
*
* @current_gl_version       string      version of geeklog to upgrade from
*
*/
function DB_doDatabaseUpgrade($current_gl_version) 
{
    global $_DB;

    return $_DB->dbDoDatabaseUpgrade($current_gl_version);
}

?>
