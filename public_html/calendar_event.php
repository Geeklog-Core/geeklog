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
// $Id: calendar_event.php,v 1.7 2001/10/29 17:35:49 tony_bibbs Exp $

include_once('lib-common.php');
include_once($_CONF['path_system'] . 'classes/calendar.class.php');

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
    global $_USER, $LANG02, $_CONF, $_TABLES;
	
    $retval .= COM_startBlock($LANG02[11]);
    $eventsql = "SELECT *, datestart AS start, dateend AS end FROM {$_TABLES['events']} WHERE eid='$eid'";
    $result = DB_query($eventsql);
    $nrows = DB_numRows($result);
    if ($nrows == 1) {
        $A = DB_fetchArray($result);
        $cal_template = new Template($_CONF['path_layout'] . 'calendar');
        $cal_template->set_file(array('addevent'=>'addevent.thtml'));
        $cal_template->set_var('intro_msg', $LANG02[8]);
        $cal_template->set_var('lang_event', $LANG02[12]);
        $cal_template->set_var('event_title',$A['title']);

        if (!empty($A['url'])) {
            $cal_template->set_var('event_begin_anchortag', '<a href="' . $A['url'] . ' target="_blank">');
            $cal_template->set_var('event_end_anchortag', '</a>');
        } else {
            $cal_template->set_var('event_begin_anchortag', '');
            $cal_template->set_var('event_end_anchortag', '');
        }

        $cal_template->set_var('lang_starts', $LANG02[13]);
        $cal_template->set_var('event_start', $A['start']);
        $cal_template->set_var('lang_ends', $LANG02[14]);
        $cal_template->set_var('event_end', $A['end']);
        $cal_template->set_var('lang_where',$LANG02[4]);
        $cal_template->set_var('event_location', $A['location']);
        $cal_template->set_var('lang_description', $LANG02[5]);
        $cal_template->set_var('event_description', $A['description']);
        $cal_template->set_var('event_id', $eid);
        $cal_template->set_var('lang_addtomycalendar', $LANG02[9]);
        $cal_template->parse('output','addevent'); 	
        $retval .= $cal_template->finish($cal_template->get_var('output'));
    } else {
        $retval .= COM_showMessage(23);
    }	
	
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
    return COM_refresh("{$_CONF['site_url']}/calendar.php?msg=24");
}

// MAIN

$display = '';

switch ($mode) {
case 'addevent':
    $display .= COM_siteHeader();

    if (!empty($eid)) {
        $display .= adduserevent($eid);
    } else {
        $display .= COM_showMessage(23);
    }   

    $display .= COM_endBlock() . COM_siteFooter();
    break;
case 'saveuserevent':
    if (!empty($eid)) {
        $display .= saveuserevent($eid,$remind,$emailreminder);
    } else {
        $display .= COM_siteHeader();
        $display .= COM_showMessage(23);
        $display .= COM_siteFooter();
    }
    break;
case 'deleteevent':
    DB_query("delete from userevent where uid={$_USER['uid']} and eid='$eid'");
    $display .= COM_refresh($_CONF['site_url'] . '/calendar.php?msg=26');
    break;
default:
    $display .= COM_siteHeader('menu');
    if (!empty($eid)) {
        $display .= COM_startBlock($LANG30[9]);
        $datesql = "SELECT *,datestart AS start,dateend AS end FROM {$_TABLES['events']} WHERE eid = '$eid'";
    } else {
        $display .= COM_startBlock($LANG30[10] . " $month/$day/$year");
        $thedate= $year . "-". $month . "-" . $day;
        $datesql = "SELECT *,datestart AS start,dateend AS end FROM {$_TABLES['events']} WHERE \"$thedate\" BETWEEN datestart and dateend ORDER BY datestart asc,title";
    }
    $cal_templates = new Template($_CONF['path_layout'] . 'calendar');
    $cal_templates->set_file(array('events'=>'events.thtml'
                                    ,'details'=>'eventdetails.thtml'
                                    ,'addremove'=>'addremoveevent.thtml'));
    $cal_templates->set_var('lang_addevent', $LANG02[6]);
    $cal_templates->set_var('lang_backtocalendar', 'Back to Calendar');

    $result = DB_query($datesql);
    $nrows = DB_numRows($result);
    if ($nrows==0) {
        $cal_templates->set_var('lang_month','');
        $cal_templates->set_var('event_year','');
        $cal_templates->set_var('event_details','');
        $cal_templates->parse('output','events');
        $display .= $cal_templates->finish($cal_templates->get_var('output'));
        $display .= $LANG02[1];
    } else {
        $cal = new Calendar();

        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
                if (strftime("%B",strtotime($A["start"])) != $currentmonth) {
                    $str_month = $cal->getMonthName(strftime('%m',strtotime($A['start'])));
                    $cal_templates->set_var('lang_month', $str_month);
                    $cal_templates->set_var('event_year', strftime('%Y',strtotime($A['start'])));
                    //$display .= '<br><h1>' . strftime("%B %Y",strtotime($A["start"])) . '</h1>' . LB;
                    $currentmonth = strftime("%B",strtotime($A["start"]));
                }
                $cal_templates->set_var('event_title', $A['title']);
                $cal_templates->set_var('site_url', $_CONF['site_url']);
                if (!empty($A['url'])) {
                    $cal_templates->set_var('event_begin_anchortag', '<a href="'.$A['url'].'">');
                    $cal_templates->set_var('event_title', $A['title']);
                    $cal_templates->set_var('event_end_anchortag', '</a>');
                } else {
                    $cal_templates->set_var('event_begin_anchortag', '');
                    $cal_templates->set_var('event_title', $A['title']);
                    $cal_templates->set_var('event_end_anchortag', '');
                }


                if (!empty($_USER['uid'])) {
                    $tmpresult = DB_query("SELECT * FROM {$_TABLES["userevent"]} WHERE eid='{$A["eid"]}' AND uid={$_USER['uid']}");
                    $tmpnrows = DB_numRows($tmpresult);
                    if ($tmpnrows > 0) {
                        $cal_templates->set_var('addremove_begin_anchortag','<a href="'
                            . $_CONF['site_url'] . '/calendar_event.php?eid=' . $A['eid'] . '&mode=deleteevent">');
                        $cal_templates->set_var('lang_addremovefromcal',$LANG02[10]);
                        $cal_templates->set_var('addremove_end_anchortag', '</a>');
                    } else {
                        $cal_templates->set_var('addremove_begin_anchortag','<a href="'
                            . $_CONF['site_url'] . '/calendar_event.php?eid=' . $A['eid'] . '&mode=addevent">');
                        $cal_templates->set_var('lang_addremovefromcal',$LANG02[9]);
                        $cal_templates->set_var('addremove_end_anchortag', '</a>');
                    }
                    $cal_templates->parse('addremove_event','addremove',true);
                }
                $cal_templates->set_var('lang_when', $LANG02[3]);
                $cal_templates->set_var('event_start', strftime("%A %e",strtotime($A["start"])));
                $cal_templates->set_var('event_end', '- ' . strftime("%A %d",strtotime($A["end"])));
                $cal_templates->set_var('lang_where', $LANG02[4]);
                $cal_templates->set_var('event_location', $A['location']);
                $cal_templates->set_var('lang_description', $LANG02[5]);
                $cal_templates->set_var('event_description', $A['description']);
                $cal_templates->parse('event_details', 'details', true); 
                $cal_templates->parse('output','events');
                $display .= $cal_templates->finish($cal_templates->get_var('output')); 
            } else {
                $display .= '<br><b>'.$LANG_ACCESS['accessdenied'].'</b>'
                    .'<p>'.$LANG_ACCESS['eventdenialmsg'];
            }
        } 
    }
	
    $display .= COM_endBlock() . COM_siteFooter();
		
} // end switch

echo $display

?>
