<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | calendar_event.php                                                        |
// | Shows details of an event or events                                       |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
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
// $Id: calendar_event.php,v 1.6 2001/10/17 23:35:47 tony_bibbs Exp $

include_once('lib-common.php');

/**
* Adds an event to the user's calendar
*
* The user has asked that an event be added to their personal
* calendar.  Show a confirmation screen. NOTE: at this time 
* user's can't add their own personal events (i.e. birthdays, etc)
*
* @eid      string      event ID to add to user's calendar
*
*/
function adduserevent($eid) 
{
    global $_USER, $LANG02;
	
    $retval .= COM_startBlock("Adding Event to {$_USER['username']}'s Calendar");
    $eventsql = "SELECT *, datestart AS start, dateend AS end FROM {$_CONF['db_prefix']}events where eid='$eid'";
    $result = DB_query($eventsql);
    $nrows = DB_numRows($result);
    if ($nrows == 1) {
        $A = DB_fetchArray($result);
        $retval .= '<table border="0">' . LB
            . '<tr>' . LB . '<td colspan="2">' . $LANG02[8] . '</td>' . LB . '</tr>' . LB
            . '<tr valign="top">' . LB
            . '<td><b>Event:</b></td>' . LB
            . '<td><a href="' . $A["url"] . ' target="_new">' . $A['title'] . '</a></td>' . LB
            . '</tr>' . LB
            . '<tr valign="top">' . LB 
            . '<td><b>Starts:</b></td>' . LB 
            . '<td>' . $A['start'] . '</td>' . LB
            . '</tr>' . LB
            . '<tr valign="top">' . LB
            . '<td><b>Ends:</b></td>' . LB
            . '<td>' . $A['end'] . '</td>' . LB
            . '</tr>' . LB
            . '<tr valign="top">' . LB
            . '<td><b>Location:</b></td>' . LB
            . '<td>' . $A['location'] . '</td>' . LB
            . '</tr>' . LB
            . '<tr valign="top">' . LB
            .'<td><b>Description:</b></td>' . LB
            .'<td>' . $A['description'] . '</td>' . LB
            .'</tr>' . LB
            .'</table>' . LB;
    } else {
        $retval .= COM_showMessage(23);
        return $retval;
    }	
    $retval .= '<form name="userevent" method="post" action="'.$_CONF['site_url'].'/calendar_event.php">'
        . '<input type="hidden" name="mode" value="saveuserevent">'
        . '<input type="hidden" name="eid" value="' . $eid . '">'
        . '<input type="submit" value="' . $LANG02[9] . '"></form>';
		
    return $retval;
}

/**
* Save an event to user's personal calendar
*
* User has seen the confirmation screen and they still want to
* add this event to their calendar.  Actually save it now
*
* @eid              string      ID of event to save
* @reminder         string      Not used yet, for future functionality
* @emailreminder    string      Not used yet, for future functionality
*/
function saveuserevent($eid, $reminder, $emailreminder) 
{
    global $_TABLES, $MESSAGE, $_USER;

    /* Below code is for future functionality
    if (strlen($emailreminder) == 0) {
	    $emailreminder = 0;
    } else {
        $emailreminder = 1; 
    }
    */
	
    $savesql = "Insert into {$_TABLES["userevent"]} (uid, eid) values ('{$_USER['uid']}', '{$eid}')";
    DB_query($savesql);
    return $COM_refresh("{$_CONF['site_url']}/calendar.php?msg=24");
}

// MAIN

$display = '';

switch ($mode) {
case 'addevent':
    $display .= site_header();

    if (!empty($eid)) {
        $display .= adduserevent($eid);
    } else {
        $display .= COM_showMessage(23);
    }   

    $display .= COM_endBlock() . site_footer();
    break;
case 'saveuserevent':
    if (!empty($eid)) {
        $display .= saveuserevent($eid,$remind,$emailreminder);
    } else {
        $display .= COM_showMessage(23);
    }
    break;
case 'deleteevent':
    DB_query("delete from userevent where uid={$_USER['uid']} and eid='$eid'");
    $display .= COM_refresh($_CONF['site_url'] . '/calendar.php?msg=26');
    break;
default:
    $display .= site_header('menu');
    if (!empty($eid)) {
        $display .= COM_startBlock($LANG30[9]);
        $datesql = "SELECT *,datestart AS start,dateend AS end FROM {$_TABLES['events']} WHERE eid = '$eid'";
    } else {
        $display .= COM_startBlock($LANG30[10] . " $month/$day/$year");
        $thedate= $year . "-". $month . "-" . $day;
        $datesql = "SELECT *,datestart AS start,dateend AS end FROM {$_TABLES['events']} WHERE \"$thedate\" BETWEEN datestart and dateend ORDER BY datestart asc,title";
    }
    $display .= "[ <a href={$_CONF['site_url']}/submit.php?type=event>{$LANG02[6]}</a> ][ <a href={$_CONF['site_url']}/calendar.php>Back to Calendar</a> ]<br>";
    $result = DB_query($datesql);
    $nrows = DB_numRows($result);
    if ($nrows==0) {
        $display .= $LANG02[1];
    } else {
        for($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
                if (strftime("%B",strtotime($A["start"])) != $currentmonth) {
                    $display .= '<br><h1>' . strftime("%B %Y",strtotime($A["start"])) . '</h1>' . LB;
                    $currentmonth = strftime("%B",strtotime($A["start"]));
                }
                $display .= '<table cellspacing="0" cellpadding="3" border="0" width="100%">' . LB
                    .'<tr><td colspan="2"><h2><a href="'.$A['url'].'">'.$A['title'].'</a>&nbsp;';
						
                if (!empty($_USER['uid'])) {
                    $tmpresult = DB_query("SELECT * FROM {$_TABLES["userevent"]} WHERE eid='{$A["eid"]}' AND uid={$_USER['uid']}");
                    $tmpnrows = DB_numRows($tmpresult);
                    if ($tmpnrows > 0) {
                        $display .= '<font size="-2">[<a href="'.$_CONF['site_url'].'/calendar_event.php?eid='.$A['eid'].'&mode=deleteevent">'.$LANG02[10].'</a>]</font></h2></td></tr>' . LB;
                    } else {
                        $display .= '<font size="-2">[<a href="'.$_CONF['site_url'].'/calendar_event.php?eid='.$A['eid'].'&mode=addevent">'.$LANG02[9].'</a>]</font></h2></td></tr>' . LB;
                    }
                }
                $display .= '<tr valign="top"><td align="right"><b>'.$LANG02[3].'</b></td><td width="100%">'.strftime("%A %e",strtotime($A["start"])).' - '.strftime("%A %d",strtotime($A["end"])).'</td></tr>' . LB
                    .'<tr valign="top"><td align="right"><b>'.$LANG02[4].'</b></td><td width="100%">'.$A['location'].'</td></tr>' . LB
                    .'<tr valign="top"><td align="right"><b>'.$LANG02[5].'</b></td><td width="100%">'.$A['description'].'</td></tr>' . LB
                    .'</table>';
            } else {
                $display .= '<br><b>'.$LANG_ACCESS['accessdenied'].'</b>'
                    .'<p>'.$LANG_ACCESS['eventdenialmsg'];
            }
        } 
    }
	
    $display .= COM_endBlock() . site_footer();
		
} // end switch

echo $display

?>
