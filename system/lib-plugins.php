<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-plugins.php                                                           |
// | This file implements plugin support.                                      |
// |                                                                           |
// | This is the file where you should put all of your custom code.  When      |
// | possible you should not alter lib-common.php but, instead, put code here. |
// | This will make upgrading to future versions of Geeklog easier for you     |
// | because you will always be gauranteed that the Geeklog developers will    |
// | NOT add code to this file. NOTE: we have already gone through the trouble |
// | of making sure that we always include this file when lib-common.php is    |
// | included some place so you will have access to lib-common.php.  It        |
// | follows then that you should not include lib-common.php in this file      |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
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
// $Id: lib-plugins.php,v 1.1 2001/10/17 23:20:47 tony_bibbs Exp $

/**
* Calls a function for all enabled plugins
*
* This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* @function     string          holds name of function to call
* @args         array           arguments to send to function
*
*/
function PLG_callFunctionForAllPlugins($function_name) 
{
    global $_TABLES;

    $result = DB_query("SELECT * FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
    $nrows = DB_numRows($result);
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        $function = $function_name . $A['pi_name'];
        if (function_exists($function)) {
            return $function();
        }
    }
}

/**
* Calls a function for a single plugin
*
* This is a generic function used by some of the other API functions to
* call a function for a specific plugin and, optionally pass parameters.
* This function can handle up to 5 arguments and if more exist it will
* try to pass the entire args array to the function.
*
* @function         string      holds name of function to call
* @args             array       arguments to send to function
*
*/
function PLG_callFunctionForOnePlugin($function, $args='') 
{
    if (function_exists($function)) {
        // great, function exists, run it
        switch (count($args)) {
        case 0:
            return $function();
            break;
        case 1:
            return $function($args[1]);
            break;
        case 2: 
            return $function($args[1], $args[2]);
            break;
        case 3:
            return $function($args[1], $args[2], $args[3]);
            break;
        case 4:
            return $function($args[1], $args[2], $args[3], $args[4]);
            break;
        case 5:
            return $function($args[1], $args[2], $args[3], $args[4], $args[5]);
            break;
        default:
            return $function($args);
            break;	
		}
    } else {
        return false;
    }
}

/**
* Checks to see if user is a plugin moderator
*
* Geeklog is asking if the user is a moderator for any installed plugins.
*
*/
function IsPluginModerator() 
{
    return PLG_callFunctionForAllPlugins('plugin_ismoderator_');
}

#if plugin developer decides they want to customize the blocks on the left hand side then 
function AddPluginLeftColumns($type) {
	global $_CONF;
	
	if (!empty($type)) {
		$retval .= LB.'<td class="featureblock" valign="top" width="150 rowspan="2">'
			.PLG_callFunctionForOnePlugin('plugin_leftcol_' . $type).LB
			.'img src="'.$_CONF['site_url'].'/images/speck.gif" width="150" height="1"></td>'.LB
			.'<!-- spacer block -->'.LB
			.'<td width="1"><img src="'.$_CONF['site_url'].'/images/speck.gif" width="1" height="1"></td>'.LB;
	}
	
	return $retval;
}
# Gives plugins a chance to print their menu items in header
function PrintPluginHeaderMenuItems() {
	return PLG_callFunctionForAllPlugins('plugin_printheadermenuitem_');
}

function DoPluginCommentSupportCheck($type) {
	return PLG_callFunctionForOnePlugin('plugin_commentsupport_' . $type);
}

function HandlePluginComment($type, $id) {
	$args[1] = $id;
	PLG_callFunctionForOnePlugin('plugin_commentsave_' . $type, $args);
}
/***********************************************************************
* FUNCTION: ShowPluginStats
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: $showsitestats - flag indicated type of stats to return 
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* The way this function works is very specific to how Geeklog shows it's
* statistics.  On stats.php, there is the top box which gives overall
* statistics for Geeklog and then there are blocks below it that give
* more specific statistics for various components of Geeklog.  If 
* $showsitestats is 1 then the plugins is to return the overall stats
* for the plugin.  If $showsitestats is 0 then it will return the plugin
* specific stats
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function ShowPluginStats($showsitestats) {
	$result = DB_query("SELECT * FROM {$_CONF['db_prefix']}plugins WHERE pi_enabled = 1");
	$nrows = DB_numRows($result);
	for ($i = 1; $i <= $nrows; $i++) {
		$A = DB_fetchArray($result);
		$function = 'plugin_showstats_' . $A['pi_name'];
		if (function_exists($function)) {
			//great, stats function is there, call it
			$function($showsitestats);
		} // no else because this is not a required API function
	}
}
/***********************************************************************
* FUNCTION: DoPluginSearches 
* 
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: $query - what the user searched for
*	     $datestart - beginning of date range to search for
*	     $dateend   - ending date range to search for
* 	     $topic	- the topic the user searched within 
*	     $author    - only return results for this person
*
* RETURNS:   $nrows_plugins - the number of matching rows
*	     $total_plugins - total number of rows serached 
*	     $result_plugins - two dim. array of results
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* This function gives each plugin the opportunity to do their search
* and return their results.  Results comeback in an array of HTML 
* formatted table rows that can be quickly printed by search.php 
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function DoPluginSearches($query, $datestart, $dateend, $topic, $author) {
	$result = DB_query("SELECT * FROM {$_CONF['db_prefix']}plugins WHERE pi_enabled = 1");
	$nrows = DB_numRows($result);
	$nrows_plugins = 0;
	$total_plugins = 0;
	for ($i = 1; $i <= $nrows; $i++) {
		$A = DB_fetchArray($result);
		$function = 'plugin_dopluginsearch_' . $A['pi_name'];
		if (function_exists($function)) {
			list($nrows,$total, $result_plugins[$i]) = $function ($query, $datestart, $dateend, $topic, $author);
			$nrows_plugins = $nrows_plugins + $nrows;
			$total_plugins = $total_plugins + $total;
		} // no else because implementation of this API function not required
	}
	return array($nrows_plugins, $total_plugins, $result_plugins);
}
/***********************************************************************
* FUNCTION: GetPluginSearchTypes
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: (none)
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* This function gives each plugin the opportunity to put a value(s) in
* the 'Type' drop down box on the search.php page so that their plugin
* can be incorporated into searches.
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function GetPluginSearchTypes() {
	return PLG_callFunctionForAllPlugins('plugin_getsearchtypes_');
}
/***********************************************************************
* FUNCTION: GetPluginSubmissionCounts
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: (none)
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* Asks each plugin to report any submissions they may have in their
* submission queue
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function GetPluginSubmissionCounts() {
	$result = DB_query("SELECT * FROM {$_CONF['db_prefix']}plugins WHERE pi_enabled = 1");
        $nrows = DB_numRows($result);
	$num = 0;
        for ($i = 1; $i <= $nrows; $i++) {
                $A = DB_fetchArray($result);
                $function = 'plugin_submissioncount_' . $A['pi_name'];
                if (function_exists($function)) {
                        $num = $num + $function();
                }
        }
	return $num;
}
/***********************************************************************
* FUNCTION: HandlePluginAdminEdit
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: (none)
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* This function shows the admin edits at the top of 
* /admin/plugins/<pluginname>/<pluginpage>.php
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function HandlePluginAdminEdit($type) {
	return PLG_callFunctionForOnePlugin('plugin_adminedit_' . $type);
}
/***********************************************************************
* FUNCTION: ShowPluginAdminOption
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: (none)
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* This function will show any plugin adminstrative options in the
* admin functions block on every page (assuming the user is an admin
* and is logged in).  NOTE: the plugin is responsible for it's own
* security.
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function ShowPluginUserOptions() {
	return PLG_callFunctionForAllPlugins('plugin_showuseroption_');
}
/***********************************************************************
* FUNCTION: ShowPluginAdminOption
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: (none)
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* This function will show any plugin adminstrative options in the
* admin functions block on every page (assuming the user is an admin
* and is logged in).  NOTE: the plugin is responsible for it's own
* security. 
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function ShowPluginAdminOptions() {
	return PLG_callFunctionForAllPlugins('plugin_showadminoption_');
}
/***********************************************************************
* FUNCTION: DoPluginModerationApprove
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: $type - used to figure out which plugin to work with
*            $id - used to identify the record to approve
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* This function is responsible for calling
* plugin_moderationapproves_photos which approves an item from the
* submission queue for a plugin.
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function DoPluginModerationApprove($type, $id) {
	$args[1] = $id;
	return PLG_callFunctionForOnePlugin('plugin_moderationapprove_' . $type, $args);
}
/***********************************************************************
* FUNCTION: DoPluginModerationDelete
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: $type - used to figure out which plugin to work with
*            $id - used to identify the record for which to delete
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* This function is responsible for calling 
* plugin_moderationdelete_photos which deletes an item from the
* submission queue for a plugin.  
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function DoPluginModerationDelete($type, $id) {
	$args[1] = $id;
	return PLG_callFunctionForOnePlugin('plugin_moderationdelete_' . $type, $args);
}
/***********************************************************************
* FUNCTION: SavePluginSubmission 
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: $type - used to figure out which plugin to work with
*	     $A - holds data to save 
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are 
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your syste.
*
* This function calls the plugin_savesubmission_<pluginname> to save
* a user submission
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function SavePluginSubmission($type, $A) {
	$args[1] = $A;
	return PLG_callFunctionForOnePlugin('plugin_savesubmission_' . $type, $args);
}
/***********************************************************************
* FUNCTION: ShowPluginModerationOptions
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: (none)
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are 
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your syste.
*
* This function shows the option for all plugins at the top of the 
* command and control center.
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function ShowPluginModerationOptions() {
	global $_CONF;
	
	
	$result = DB_query("SELECT * FROM {$_CONF['db_prefix']}plugins WHERE pi_enabled = 1");
	$nrows = DB_numRows($result);
	for ($i = 1; $i <= $nrows; $i++) {
		$A = DB_fetchArray($result);
		$function = 'plugin_cclabel_' . $A['pi_name'];
		if (function_exists($function)) {
			list($img, $label) = $function();
			$retval .= '<td width="11%"><a href="'.$_CONF['base'].'/admin/plugins/'.$A['pi_name'].'/'.$A['pi_name'].'.php"><img src="'.$img.'" border="0" alt=""><br>'
				.$label
				.'</a></td>'.LB;
		}
	}
	return $retval;
}
/***********************************************************************
* FUNCTION: ShowPluginModerationLists
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: (none)
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your syste.
*
* This function starts the chain of calls needed to show any submissions
* needing moderation for the plugins.
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function ShowPluginModerationLists() {
	global $_CONF;
	
	
	$result = DB_query("SELECT * FROM {$_CONF['db_prefix']}plugins WHERE pi_enabled = 1");
	$nrows = DB_numRows($result);
	for ($i = 1; $i <=$nrows; $i++) {
		$A = DB_fetchArray($result);
		$retval .= itemlist($A['pi_name']);
	}
	
	return $retval;
}
/***********************************************************************
* FUNCTION: GetPluginModerationValues
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: (none)
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your syste.
*
* This function is responsible for setting the plugin-specific values
* needed by moderation.php to approve stuff.
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function GetPluginModerationValues($type) {
	return PLG_callFunctionForOnePlugin('plugin_moderationvalues_' . $type);
}
/***********************************************************************
* FUNCTION: SubmitPlugin
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: $type - used to identify the plugin to show the submit form 
* for
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your syste.
*
* This function is resonsible for calling plugin_submit_<pluginname> so
* that the submission form for the plugin is displayed.
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function SubmitPlugin($type) {
	return PLG_callFunctionForOnePlugin('plugin_submit_' . $type);
}
?>
