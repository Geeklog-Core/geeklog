<?php

###############################################################################
# plugins.php
# This is the file that implements plugin support for Geeklog
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

/***********************************************************************
* FUNCTION: CallFunctionForAllPlugins
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: $function - string holding name of function to call
*            $args     - array of arguments to send to function
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* This is a generic function used by some of the other API functions to
* call a function for all plugins.
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function CallFunctionForAllPlugins($function_name) {
	$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}plugins WHERE pi_enabled = 1");
        $nrows = mysql_num_rows($result);
        for ($i = 1; $i <= $nrows; $i++) {
                $A = mysql_fetch_array($result);
                $function = $function_name . $A['pi_name'];
                if (function_exists($function)) {
                        $function();
		}
        }
}

/***********************************************************************
* FUNCTION: CallFunctionForOnePlugin
*
* AUTHOR: Tony Bibbs
* DATE: 07/08/2001
*
* ARGUMENTS: $function - string holding name of function to call
*	     $args     - array of arguments to send to function
*
* RETURNS: (none)
*
* DESCRIPTION: This is part of the plugin request broker.  These are
* generic functions used to call plugin specific code for further
* processing.  This code should never be modified lest you want to risk
* having no Geeklog plugins work on your system.
*
* This is a generic function used by some of the other API functions to
* call a function for a specific plugin and, optionally pass parameters.
* This function can handle up to 5 arguments and if more exist it will
* try to pass the entire args array to the function.  
*
************************************************************************
* MODIFICATION HISTORY
*
* Author        Date            Description
* -----         ----            -----------
***********************************************************************/
function CallFunctionForOnePlugin($function, $args="") {
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

#if plugin developer decides they want to customize the blocks on the left hand side then 
function AddPluginLeftColumns($type) {
	global $CONF;

	if (empty($type)) {
		#either this was an error OR done intentionally, bail gracefully
		return;
	}
	print "\n<td class=featureblock valign=top width=150 rowspan=2>";
	CallFunctionForOnePlugin('plugin_leftcol_' . $type);
	print "\n<IMG SRC={$CONF["site_url"]}/images/speck.gif width=150 height=1></td>";
	print "\n<!-- spacer block -->";
	print "\n<td width=1><IMG SRC={$CONF["site_url"]}/images/speck.gif width=1 height=1></td>"; 
	return;
}

# Gives plugins a chance to print their menu items in header
function PrintPluginHeaderMenuItems() {
	return CallFunctionForAllPlugins('plugin_printheadermenuitem_');
}

function DoPluginCommentSupportCheck($type) {
	return CallFunctionForOnePlugin('plugin_commentsupport_' . $type);
}

function HandlePluginComment($type, $id) {
	$args[1] = $id;
	CallFunctionForOnePlugin('plugin_commentsave_' . $type, $args);
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
	$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}plugins WHERE pi_enabled = 1");
	$nrows = mysql_num_rows($result);
	for ($i = 1; $i <= $nrows; $i++) {
		$A = mysql_fetch_array($result);
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
	$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}plugins WHERE pi_enabled = 1");
	$nrows = mysql_num_rows($result);
	$nrows_plugins = 0;
	$total_plugins = 0;
	for ($i = 1; $i <= $nrows; $i++) {
		$A = mysql_fetch_array($result);
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
	return CallFunctionForAllPlugins('plugin_getsearchtypes_');
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
	$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}plugins WHERE pi_enabled = 1");
        $nrows = mysql_num_rows($result);
	$num = 0;
        for ($i = 1; $i <= $nrows; $i++) {
                $A = mysql_fetch_array($result);
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
	return CallFunctionForOnePlugin('plugin_adminedit_' . $type);
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
	return CallFunctionForAllPlugins('plugin_showuseroption_');
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
	return CallFunctionForAllPlugins('plugin_showadminoption_');
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
	return CallFunctionForOnePlugin('plugin_moderationapprove_' . $type, $args);
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
	return CallFunctionForOnePlugin('plugin_moderationdelete_' . $type, $args);
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
	return CallFunctionForOnePlugin('plugin_savesubmission_' . $type, $args);
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
	global $CONF;
	$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}plugins WHERE pi_enabled = 1");
	$nrows = mysql_num_rows($result);
	for ($i = 1; $i <= $nrows; $i++) {
		$A = mysql_fetch_array($result);
		$function = 'plugin_cclabel_' . $A['pi_name'];
		if (function_exists($function)) {
			list($img, $label) = $function();
			print "<td width=11%><a href={$CONF['base']}/admin/plugins/{$A['pi_name']}/{$A['pi_name']}.php><img src=$img border=0><br>$label</a></td>";
		}
	}
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
	global $CONF;
	$result = dbquery("SELECT * FROM {$CONF["db_prefix"]}plugins WHERE pi_enabled = 1");
	$nrows = mysql_num_rows($result);
	for ($i = 1; $i <=$nrows; $i++) {
		$A = mysql_fetch_array($result);
		itemlist($A['pi_name']);
	}
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
	return CallFunctionForOnePlugin('plugin_moderationvalues_' . $type);
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
	return CallFunctionForOnePlugin('plugin_submit_' . $type);
}
?>
