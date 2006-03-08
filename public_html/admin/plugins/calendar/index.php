<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog event administration page.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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
// $Id: index.php,v 1.1 2006/03/08 13:23:26 ospiess Exp $

require_once ('../../../lib-common.php');
require_once ('../../auth.inc.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// COM_debug($_POST);

$display = '';

// Ensure user even has the rights to access this page
if (!SEC_hasRights('event.edit')) {
    $display .= COM_siteHeader('menu');
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[35];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter();

    // Log attempt to error.log
    COM_accessLog("User {$_USER['username']} tried to illegally access the event administration screen.");

    echo $display;

    exit;
}

// MAIN
$mode = '';
if (isset($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

if (($mode == $LANG_CAL_ADMIN[22]) && !empty ($LANG_CAL_ADMIN[22])) { // delete
    $eid = COM_applyFilter ($_REQUEST['eid']);
    if (!isset ($eid) || empty ($eid) || ($eid == 0)) {
        COM_errorLog ('Attempted to delete event eid=\''
                      . $_REQUEST['eid'] . "'");
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/plugins/calendar/index.php');
    } else {
        $display .= CALENDAR_deleteEvent ($eid);
    }
} else if (($mode == $LANG_CAL_ADMIN[20]) && !empty ($LANG_CAL_ADMIN[20])) { // save
    $display .= CALENDAR_saveevent (COM_applyFilter ($_POST['eid']),
            $_POST['title'], $_POST['event_type'],
            $_POST['url'], $_POST['allday'],
            $_POST['start_month'], $_POST['start_day'],
            $_POST['start_year'], $_POST['start_hour'],
            $_POST['start_minute'], $_POST['start_ampm'],
            $_POST['end_month'], $_POST['end_day'],
            $_POST['end_year'], $_POST['end_hour'],
            $_POST['end_minute'], $_POST['end_ampm'],
            $_POST['location'], $_POST['address1'],
            $_POST['address2'], $_POST['city'],
            $_POST['state'], $_POST['zipcode'],
            $_POST['description'], $_POST['postmode'] ,
            $_POST['owner_id'], $_POST['group_id'],
            $_POST['perm_owner'], $_POST['perm_group'],
            $_POST['perm_members'], $_POST['perm_anon'], $mode);
} else if ($mode == 'editsubmission') {
    $id = COM_applyFilter ($_REQUEST['id']);
    $result = DB_query ("SELECT * FROM {$_TABLES['eventsubmission']} WHERE eid ='$id'");
    $A = DB_fetchArray ($result);
    $display .= COM_siteHeader ('menu');
    $display .= CALENDAR_editevent ($mode, $A);
    $display .= COM_siteFooter ();
} else if ($mode == 'clone') {
    $eid = COM_applyFilter ($_REQUEST['eid']);
    $result = DB_query ("SELECT * FROM {$_TABLES['events']} WHERE eid ='$eid'");
    $A = DB_fetchArray ($result);
    $A['eid'] = COM_makesid ();
    $A['owner_id'] = $_USER['uid'];
    $display .= COM_siteHeader ('menu');
    $display .= CALENDAR_editevent ($mode, $A);
    $display .= COM_siteFooter ();
} else if ($mode == 'edit') {
    $eid = COM_applyFilter ($_REQUEST['eid']);
    if (empty ($eid)) {
        $A = array ();
        $A['datestart'] = COM_applyFilter ($_REQUEST['datestart']);
        $A['timestart'] = COM_applyFilter ($_REQUEST['timestart']);
    } else {
        $result = DB_query ("SELECT * FROM {$_TABLES['events']} WHERE eid ='$eid'");
        $A = DB_fetchArray ($result);
    }
    $display .= COM_siteHeader ('menu', $LANG_CAL_ADMIN[1]);
    $display .= CALENDAR_editevent ($mode, $A);
    $display .= COM_siteFooter ();
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader ('menu', $LANG_CAL_ADMIN[11]);
    if (isset ($_REQUEST['msg'])) {
        $display .= COM_showMessage (COM_applyFilter ($_REQUEST['msg'],
                                                      true));
    }
    $display .= CALENDAR_listevents();
    $display .= COM_siteFooter ();
}

echo $display;

?>
