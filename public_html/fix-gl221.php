<?php

require_once 'lib-common.php';

global $_CONF, $_GROUPS, $_TABLES, $MESSAGE, $_USER;

// For Root users only
if (!SEC_inGroup('Root')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_errorLog("Someone has tried to access a custom Geeklog Database Upgrade Routine {$_SERVER["SCRIPT_NAME"]} without proper permissions.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . $_SERVER['REMOTE_ADDR'],1);
    COM_output($display);
    exit;
}

COM_errorLog("Someone has run a custom Geeklog Database Upgrade Routine {$_SERVER["SCRIPT_NAME"]}  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . $_SERVER['REMOTE_ADDR'],1);

$display = '<h1>Custom Development Database Update</h1>';
$display .= '<p>Fix for Config Settings</p>';
$display .= "<p><strong>Starting Process</strong></p>";

$display .= "<p><em>WORKING</em></p>";




/*	
require_once $_CONF['path_system'] . 'classes/config.class.php';
$c = config::get_instance();
$me = 'Core';
// Add Structured Data Autotag usuage permissions
$c->add('autotag_permissions_structureddata', array(2, 2, 0, 0), '@select', 7, 41, 28, 1930, TRUE, $me, 37);


// Add `structureddata.autotag` feature
$sql = "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr, ft_gl_core) VALUES ('structureddata.autotag', 'Can use the Structured Data Autotag', 1)";
DB_query($sql, 1);
$ftId = DB_insertId();

// Get `Story Admin` group id
$grpId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Story Admin'");

// Give `structureddata.autotag` feature to `Story Admin` group
$sql = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$ftId}, {$grpId}) ";
DB_query($sql, 1);


// Give "structureddata.autotag" feature to Static Page Admin
$staticPageAdminId = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin' ");
DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ({$ftId}, {$staticPageAdminId}) ");
*/

global $_TABLES;

// Calculate number of pages for articles (that have [page_break] in body text)
$sql = "SELECT sid, bodytext FROM {$_TABLES['stories']} WHERE bodytext != ''";
$result = DB_query($sql);
$numRows = DB_numRows($result);
for ($i = 0; $i < $numRows; $i++) {
	$A = DB_fetchArray($result);

	$numpages = (count(explode('[page_break]', $A['bodytext'])));

	// Save new name
	DB_query("UPDATE {$_TABLES['stories']} SET numpages = $numpages WHERE sid = '" . DB_escapeString($A['sid']) . "'");
}



COM_errorLog("Finished Upgrade Routine Successfully.");
$display .= "<p><strong>Finished Process</strong></p>";

CTL_clearCache();

$display .= '<p>The Geeklog Custom Development Database Update has completed.</p>
			 <p><em>Important:</em> Remember to delete the script file <code>' . $_SERVER["SCRIPT_NAME"] . '</code> once this process has run successfully.</p>
             <p>Please visit the <a href="https://www.geeklog.net/forum/" target="_blank">Geeklog Support Forums</a> if you have any questions or run into any problems.</p>';

$display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[40]));
COM_output($display);
