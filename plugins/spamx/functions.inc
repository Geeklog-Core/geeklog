<?php
/**
* File: functions.inc
* This is the functions.inc for the Geeklog SpamX Plug-in!
*
* Copyright (C) 2004 by the following authors:
*
* @ Author		Tom Willett		tomw@pigstye.net
*
* Licensed under GNU General Public License
*
*/

/**
* Language file Include
*/
$langfile = $_CONF['path'] . 'plugins/spamx/language/' . $_CONF['language'] . '.php';

if (file_exists ($langfile)) 
{
    include_once ($langfile);
}
else 
{
    include_once ($_CONF['path'] . 'plugins/spamx/language/english.php');
}

/*
* Include spamx config files
*/
require_once ($_CONF['path'] . 'plugins/spamx/config.php');

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
* Universal Plugin:  Uncomment and fill in variables;
* 
* @return    array   Associative array of menu items to be added to menu
*
*/
function plugin_getmenuitems_spamx()
{
    return array();
}

/**
* Check to see if this Plugin uses comments
*
* Geeklog is checking to see if this plugin supports comments, tell it no!
* NOTE: to support comments you must use the same date/time based ID for your
* widget.  In other words, to make primary keys for your plugin you should call
* makesid().  Comments are keyed off of that...it is a limitation on how geeklog
* does comments.
*
* @return   boolean true or false
*
*/
function plugin_commentsupport_spamx() 
{
    return false;
}

/**
* Shows the statistics for the plugin on stats.php.  If
* $showsitestats is 1 then we are to only print the overall stats in the 'site
* statistics' box otherwise we show the detailed stats for the plugin
*
* Universal Plugin:  Modify/uncomment use it
*
* @param    int showsitestate   Flag to let us know which stats to get
* @return   string  returns formatted HTML to insert in stats page
*
*/
function plugin_showstats_spamx($showsitestats) 
{
    $retval='';
    return $retval;
}

/**
* This will put an option for the plugin in the command and control block on moderation.php
*
* Add the plugin name, icon and link to the command and control block in moderation.php
*
* @return   array   Array containing (plugin name, admin url, url of plugin icon)
*
*/
function plugin_cclabel_spamx() 
{
    global $_CONF, $LANG_SX00;

    $retval = array();
    if (SEC_hasRights('spamx.admin')) {
        $retval = array($LANG_SX00['plugin_name'],
                        $_CONF['site_admin_url'] . '/plugins/spamx/index.php',
                        $_CONF['site_admin_url'] . '/plugins/spamx/images/spamx.gif');
    }

    return $retval;
}

/**
* Returns the administrative option for this plugin
*
* Adds the plugin to the Admin menu
*
* Universal Plugin:  Modify/Uncomment use it
*
* @return   array   Array containing (plugin name, plugin admin url, # of items in plugin or '')
*
*/
function plugin_getadminoption_spamx() 
{
    global $_CONF, $LANG_SX00;

    if (SEC_hasRights('spamx.admin')) {
        return array($LANG_SX00['plugin_name'],
                     $_CONF['site_admin_url'] . '/plugins/spamx/index.php', 0);
    }
}


/**
* Actual Plugin Functions here.
*
*/

/**
*Replacement for savecomment function in comment.php
*
*/

function plugin_commentPreSave_spamx($uid, $title, $comment, $sid, $pid, $type, $postmode, $extra=null, $extra2=null)
{
	global $_TABLES, $_CONF;

	// Set up Spamx_Action and SpamX_Examine arrays
	$result=DB_query("SELECT * FROM {$_TABLES['spamx']} WHERE name='Action'");
	$nrows = DB_numRows($result);
	for ($i=1;$i<=$nrows;$i++) {
		$A=DB_fetchArray($result);
		$Spamx_Action[]=$A['value'];
	}
    $result=DB_query("SELECT * FROM {$_TABLES['spamx']} WHERE name='Examine'");
    $nrows = DB_numRows($result);
    for ($i=1;$i<=$nrows;$i++) {
        $A=DB_fetchArray($result);
        $Spamx_Examine[]=$A['value'];
    }   
 
   	if ($extra == null) {
		$commnt = array(
			'uid'     => $uid,
			'title'   => $title,
			'comment' => $comment,
			'sid'     => $sid,
			'pid'     => $pid,
		   	'type'    => $type,
			'postmode'=> $postmode);
	} else {
		$commnt = array(
			'uid'     => $uid,
			'title'   => $sid,
			'comment' => $pid,
			'sid'     => $type,
			'pid'     => $postmode,
		   	'type'    => $extra,
			'postmode'=> $extra2);
	}

	$res=0;
    foreach ($Spamx_Examine as $Examine) {
		$filename = $Examine . '.Examine.class.php';
        if (file_exists($_CONF['path'] . 'plugins/spamx/' . $filename)) {
			require_once $_CONF['path'] . 'plugins/spamx/' . $filename;
			$EX = new $Examine;
			$EX->init($commnt);
			$res = $EX->execute();
			$commnt = $EX->getComment();
			if ($res == 1) {
				break;
			}
		}
	}
	if ($res == 1) {
		foreach($Spamx_Action as $Action) {
			$filename = $Action . '.Action.class.php';
			if (file_exists($_CONF['path'] . 'plugins/spamx/' . $filename)) {
				require_once($_CONF['path'] . 'plugins/spamx/' . $filename);
				$AC = new $Action;
       	        $AC->init($commnt);
				$AC->execute();	
				$commnt=$AC->getComment();
			}
		}
		return $AC->result();
	}
	return false;
}

/**
* Logs message to spamx.log
*
* This will print a message to the spamx log
*
* @logentry        string      $string         Message to write to log
*
*/

$_SPAMX_log_flg = true;		// Set to false to turn of logging

function SPAMX_log( $logentry )
{
    global $_CONF, $LANG01, $_SPAMX_log_flg;
    
    if ($_SPAMX_log_flg == true) {
	$timestamp = strftime( "%c" );
	$logfile = $_CONF['path_log'] . 'spamx.log';
           
    	if( !$file = fopen( $logfile, "a" ))
    	{
        	COM_errorLog($LANG01[33] . $logfile . ' (' . $timestamp . ')',1);
    	}
               
    	fputs( $file, "$timestamp - $logentry \n" );
    }          
    return $retval;
}

/**
* Filter parameters passed per GET (URL) or POST.
*
* @param    string    $parameter   the parameter to test
* @param    boolean   $isnumeric   true if $parameter is supposed to be numeric
* @return   string    the filtered parameter (may now be empty or 0)
* Borrowed from geeklog 1.3.9
*/
function SPAMX_applyFilter( $parameter, $isnumeric = false )
{
    global $HTTP_SERVER_VARS;

    $log_manipulation = false; // set to true to log when the filter applied

    $p = COM_stripslashes( $parameter );
    $p = strip_tags( $p );
    $p = COM_killJS( $p ); // doesn't help a lot right now, but still ...

    if( $isnumeric )
    {
        // Note: PHP's is_numeric() accepts values like 4e4 as numeric
        if( !is_numeric( $p ) || ( preg_match( '/^([0-9]+)$/', $p ) == 0 ))
        {
            $p = 0;
        }
    }
    else
    {
        $p = preg_replace( '/\/\*.*/', '', $p );
        $pa = explode( "'", $p );
        $pa = explode( '"', $pa[0] );
        $pa = explode( '`', $pa[0] );
        $pa = explode( ';', $pa[0] );
        $pa = explode( '\\', $pa[0] );
        $p = $pa[0];
    }

    if( $log_manipulation )
    {
        if( strcmp( $p, $parameter ) != 0 )
        {
            COM_errorLog( "Filter applied: >> $parameter << filtered to $p [IP {$HTTP_SERVER_VARS['REMOTE_ADDR']}]", 1);
        }
    }

    return $p;
}
                                        

/**
* Removes the datastructures for this plugin from the Geeklog database.
* This routine will get called from the Plugin install program if user select De-Install or if Delete is used in the Plugin Editor.
* The Plugin Installer will also call this routine upon and install error to remove anything it has created.
* The Plugin installer will pass the optional parameter which will then double check that plugin has first been disabled. 
* 
* For this plugin, this routine will also remove the Block definition.
* 
* Returns True if all Plugin related data is removed without error
*
* @param    string   $installCheck     Defult is blank but if set, check if plugin is disabled first
* 
* @return   boolean True if successful false otherwise
*
*/  
function plugin_uninstall_spamx($installCheck='')
{
    global $_TABLES, $LANG_SX00;

    $pi_name     = 'spamx';
    $FEATURES    = array ('spamx.admin', 'spamx.view');
    $admin_group = 'spamx Admin';

    // Check and see if plugin is still enabled - if so display warning and exit
    if ($installCheck != '' && DB_getItem($_TABLES['plugins'],'pi_enabled', 'pi_name = "' .$pi_name. '"')) {
	    COM_errorLog("Plugin is installed and enabled. Disable first if you want to de-install it",1);
		$display .= COM_startBlock($LANG_SX00['warning']);
		$display .= $LANG_SX00['enabled'];
		$display .= COM_endBlock();
		echo $display;
		return false;
		exit;
	}

	// Ok to proceed and delete plugin

    // Unregister the plugin with Geeklog
    COM_errorLog('Attempting to unregister the spamx plugin from Geeklog',1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'spamx'",1);

    // Remove Security for this plugin
    $grp_id = DB_getItem ($_TABLES['groups'], 'grp_id', "grp_name = '{$admin_group}'");

    COM_errorLog("Removing $pi_name Admin Group", 1);
    DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id",1);
    DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = '{$pi_name}_gid'");
    COM_errorLog("Removing root users from admin of $pi_name");
    DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id",1);

    // Remove all the associated features -- access rights
    foreach ($FEATURES as $feature) {
        COM_errorLog("Removing $feature feature and rights to it",1);
        $feat_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = '$feature'");
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $feat_id",1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $feat_id",1);
    }
 
    COM_errorLog ('Dropping ' . $_TABLES['spamx'] . ' table.', 1);
    DB_query ("DROP TABLE {$_TABLES['spamx']}");

    COM_errorLog('...success',1);
    return true;
}

?>
