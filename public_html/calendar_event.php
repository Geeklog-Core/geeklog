<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | calendar_event.php                                                        |
// | Shows details of an event or events                                       |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
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
// $Id: calendar_event.php,v 1.25 2003/06/16 09:11:22 dhaun Exp $

require_once('lib-common.php');
require_once($_CONF['path_system'] . 'classes/calendar.class.php');

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
    $eventsql = "SELECT *, datestart AS start, dateend AS end, timestart, timeend, allday FROM {$_TABLES['events']} WHERE eid='$eid'";
    $result = DB_query($eventsql);
    $nrows = DB_numRows($result);
    if ($nrows == 1) {
        $A = DB_fetchArray($result);
        $cal_template = new Template($_CONF['path_layout'] . 'calendar');
        $cal_template->set_file(array('addevent'=>'addevent.thtml'));
        $cal_template->set_var('site_url', $_CONF['site_url']);
        $cal_template->set_var('intro_msg', $LANG02[8]);
        $cal_template->set_var('lang_event', $LANG02[12]);
        $cal_template->set_var('event_title',stripslashes($A['title']));

        if (!empty($A['url'])) {
            $cal_template->set_var('event_begin_anchortag', '<a href="' . $A['url'] . '" target="_blank">');
            $cal_template->set_var('event_end_anchortag', '</a>');
        } else {
            $cal_template->set_var('event_begin_anchortag', '');
            $cal_template->set_var('event_end_anchortag', '');
        }

        $cal_template->set_var('lang_starts', $LANG02[13]);
        $cal_template->set_var('lang_ends', $LANG02[14]);

        $thestart = COM_getUserDateTimeFormat($A['start'] . ' ' . $A['timestart']);
        $theend = COM_getUserDateTimeFormat($A['end'] . ' ' . $A['timeend']);
        if ($A['allday'] == 0) {
            $cal_template->set_var('event_start', $thestart[0]);
            $cal_template->set_var('event_end', $theend[0]);
        } else {
            $cal_template->set_var('event_start', strftime($_CONF['shortdate'], $thestart[1]));
            $cal_template->set_var('event_end', strftime($_CONF['shortdate'], $theend[1]));
        }

        $cal_template->set_var('lang_where',$LANG02[4]);
        $location = stripslashes($A['location']) . '<br>'
		. stripslashes ($A['address1']) . '<br>'
		. stripslashes ($A['address2']) . '<br>'
		. stripslashes ($A['city']) . ', ' . $A['state'] . ' ' . $A['zipcode'];
        //$cal_template->set_var('event_location', $A['location']);
        $cal_template->set_var('event_location', $location);
        $cal_template->set_var('lang_description', $LANG02[5]);
        $cal_template->set_var('event_description', stripslashes ($A['description']));
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
function saveuserevent($eid, $reminder, $emailreminder, $mode) 
{
    global $_TABLES, $MESSAGE, $_USER, $_CONF;

    /* Below code is for future functionality
    if (strlen($emailreminder) == 0) {
	    $emailreminder = 0;
    } else {
        $emailreminder = 1; 
    }
    */

/*	
    $savesql = "Insert into {$_TABLES["userevent"]} (uid, eid) values ('{$_USER['uid']}', '{$eid}')";
    DB_query($savesql);
*/

    $savesql = "INSERT INTO {$_TABLES['personal_events']} (eid,uid,title,event_type,datestart,dateend,allday,address1,address2,city,state,zipcode,url,description,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon) SELECT eid," . $_USER['uid'] . ",title,event_type,datestart,dateend,allday,address1,address2,city,state,zipcode,url,description,group_id,owner_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['events']} WHERE eid = '{$eid}'";

    DB_query($savesql);

    return COM_refresh("{$_CONF['site_url']}/calendar.php?mode=$mode&amp;msg=24");
}

/**
* Allows user to edit a personal calendar event
*
* @A        array       Record to display
*
*/
function editpersonalevent($A)
{
    global $_CONF, $LANG12, $_STATES;

    $cal_templates = new Template($_CONF['path_layout'] . 'calendar');
    $cal_templates->set_file('form','editpersonalevent.thtml');
    $cal_templates->set_var('site_url', $_CONF['site_url']);
    $cal_templates->set_var('lang_title', $LANG12[10]);
    $cal_templates->set_var('event_title', stripslashes ($A['title']));
    $cal_templates->set_var('lang_eventtype', $LANG12[49]);
    $etypes = explode(',',$_CONF['event_types']);
    $type_options = '';
    for ($i = 1; $i <= count($etypes); $i++) {
        $type_options .= '<option value="' . current($etypes) . '"';
        if (current($etypes) == $A['event_type']) {
            $type_options .= ' selected="selected"';
        }
        $type_options .= '>' . current($etypes) . '</option>';
        next($etypes);
    }
    $cal_templates->set_var('type_options', $type_options);

    // Handle start date/time
    $cal_templates->set_var('lang_startdate', $LANG12[12]);
    $cal_templates->set_var('lang_starttime', $LANG12[42]);
    $A['startdate'] = $A['datestart'] . ' ' . $A['timestart'];
    $month_options = '';
    for ($i = 1; $i <= 12; $i++) {
        $month_options .= '<option value="' . $i . '"';
        if ($i == date('n',strtotime($A['startdate']))) {
            $month_options .= ' selected="SELECTED"';
        }
        $month_options .= '>' . $i . '</option>';
    }
    $cal_templates->set_var('startmonth_options', $month_options);

    $day_options = '';
    for ($i = 1; $i <= 31; $i++) {
        $day_options .= '<option value="' . $i . '"';
        if ($i == date('j',strtotime($A['startdate']))) {
            $day_options .= ' selected="SELECTED"';
        }
        $day_options .= '>' . $i . '</option>';
    }
    $cal_templates->set_var('startday_options', $day_options);

    $year_options = '';
    for ($i = date('Y',strtotime($A['startdate'])); $i <= (date('Y',time()) + 5); $i++) {
        $year_options .= '<option value="' .$i .'"';
        if ($i == date('Y',strtotime($A['startdate']))) {
            $year_options .= ' selected="SELECTED"';
        }
        $year_options .= '>' . $i . '</option>';
    }
    $cal_templates->set_var('startyear_options', $year_options);

    $hour_options = '';
    for ($i = 1; $i <= 12; $i++) {
        $hour_options .= '<option value="' . $i . '"';
        if ($i == date('g',strtotime($A['startdate']))) {
            $hour_options .= ' selected="SELECTED"';
        }
        $hour_options .= '>' . $i . '</option>';
    }
    $cal_templates->set_var('starthour_options', $hour_options);

    $startmin = date('i',strtotime($A['startdate']));
    $cal_templates->set_var('start00_selected','');
    $cal_templates->set_var('start15_selected','');
    $cal_templates->set_var('start30_selected','');
    $cal_templates->set_var('start45_selected','');
    $cal_templates->set_var('start' . $startmin . '_selected', 'selected="SELECTED"');
    if (date('a',strtotime($A['startdate'])) == 'am') {
        $cal_templates->set_var('startam_selected', 'selected="SELECTED"');
        $cal_templates->set_var('startpm_selected', '');
    } else {
        $cal_templates->set_var('startam_selected', '');
        $cal_templates->set_var('startpm_selected', 'selected="SELECTED"');
    }

    // Handle end date/time
    $cal_templates->set_var('lang_enddate', $LANG12[13]);
    $cal_templates->set_var('lang_endtime', $LANG12[41]);
    $A['enddate'] = $A['dateend'] . ' ' . $A['timeend'];
    $month_options = '';
    for ($i = 1; $i <= 12; $i++) {
        $month_options .= '<option value="' . $i . '"';
        if ($i == date('n',strtotime($A['enddate']))) {
            $month_options .= ' selected="SELECTED"';
        }
        $month_options .= '>' . $i . '</option>';
    }
    $cal_templates->set_var('endmonth_options', $month_options);

    $day_options = '';
    for ($i = 1; $i <= 31; $i++) {
        $day_options .= '<option value="' . $i . '"';
        if ($i == date('j',strtotime($A['enddate']))) {
            $day_options .= ' selected="SELECTED"';
        }
        $day_options .= '>' . $i . '</option>';
    }
    $cal_templates->set_var('endday_options', $day_options);

    $year_options = '';
    for ($i = date('Y',strtotime($A['enddate'])); $i <= (date('Y',time()) + 5); $i++) {
        $year_options .= '<option value="' .$i .'"';
        if ($i == date('Y',strtotime($A['enddate']))) {
            $year_options .= ' selected="SELECTED"';
        }
        $year_options .= '>' . $i . '</option>';
    }
    $cal_templates->set_var('endyear_options', $year_options);

    $hour_options = '';
    for ($i = 0; $i <= 11; $i++) {
        if ($i == 0) {
            $i = 12;
        }
        $hour_options .= '<option value="' . $i . '"';
        if ($i == date('g',strtotime($A['enddate']))) {
            $hour_options .= ' selected="SELECTED"';
        }
        $hour_options .= '>' . $i . '</option>';
        if ($i == 12) { 
            $i = 0;
        } 
    }
    $cal_templates->set_var('endhour_options', $hour_options);

    $endmin = date('i',strtotime($A['enddate']));
    $cal_templates->set_var('end00_selected','');
    $cal_templates->set_var('end15_selected','');
    $cal_templates->set_var('end30_selected','');
    $cal_templates->set_var('end45_selected','');
    $cal_templates->set_var('end' . $endmin . '_selected', 'selected="SELECTED"');
    if (date('a',strtotime($A['enddate'])) == 'am') {
        $cal_templates->set_var('endam_selected', 'selected="SELECTED"');
        $cal_templates->set_var('endpm_selected', '');
    } else {
        $cal_templates->set_var('endam_selected', '');
        $cal_templates->set_var('endpm_selected', 'selected="SELECTED"');
    }

    $cal_templates->set_var('lang_alldayevent',$LANG12[43]);
    if ($A['allday'] == 1) {
        $cal_templates->set_var('allday_checked', 'checked="CHECKED"');
    } else { 
        $cal_templates->set_var('allday_checked', '');
    }

    $cal_templates->set_var('lang_location',$LANG12[14]);
    $cal_templates->set_var('event_location', stripslashes ($A['location']));

    $cal_templates->set_var('lang_addressline1', $LANG12[44]);
    $cal_templates->set_var('event_address1', stripslashes ($A['address1']));
    $cal_templates->set_var('lang_addressline2', $LANG12[45]);
    $cal_templates->set_var('event_address2', stripslashes ($A['address2']));

    $cal_templates->set_var('lang_city', $LANG12[46]);
    $cal_templates->set_var('event_city', stripslashes ($A['city']));

    $state_options = '';
    reset($_STATES);
    for ($i = 1; $i <= count($_STATES); $i++) {
        $state_options .= '<option value="' . key($_STATES) . '"';
        if ($A['state'] == key($_STATES)) {
            $state_options .= ' selected="SELECTED"';
        }
        $state_options .= '>' . current($_STATES) . '</option>';
        next($_STATES);
    }
    $cal_templates->set_var('lang_state', $LANG12[47]);
    $cal_templates->set_var('state_options', $state_options);

    $cal_templates->set_var('lang_zipcode', $LANG12[48]);
    $cal_templates->set_var('event_zipcode', $A['zipcode']);

    $cal_templates->set_var('lang_link', $LANG12[11]);
    $cal_templates->set_var('event_url', $A['url']);

    $cal_templates->set_var('lang_description', $LANG12[15]);
    $cal_templates->set_var('event_description', stripslashes ($A['description']));

    $cal_templates->set_var('lang_htmlnotallowed', $LANG12[35]);
    $cal_templates->set_var('lang_submit', $LANG12[8]);
    $cal_templates->set_var('lang_delete', $LANG12[52]);
    $cal_templates->set_var('eid', $A['eid']);
    $cal_templates->set_var('uid', $A['uid']);

    return $cal_templates->parse('output','form'); 
}

function setCalendarLanguage (&$aCalendar) {
    global $LANG30;

    $lang_days = array('sunday'=>$LANG30[1],
                        'monday'=>$LANG30[2],
                        'tuesday'=>$LANG30[3],
                        'wednesday'=>$LANG30[4],
                        'thursday'=>$LANG30[5],
                        'friday'=>$LANG30[6],
                        'saturday'=>$LANG30[7]);
    $lang_months = array('january'=>$LANG30[13],
                         'february'=>$LANG30[14],
                         'march'=>$LANG30[15],
                         'april'=>$LANG30[16],
                         'may'=>$LANG30[17],
                         'june'=>$LANG30[18],
                         'july'=>$LANG30[19],
                         'august'=>$LANG30[20],
                         'september'=>$LANG30[21],
                         'october'=>$LANG30[22],
                         'november'=>$LANG30[23],
                         'december'=>$LANG30[24]);
    $aCalendar->setLanguage($lang_days, $lang_months);
}   


// MAIN

$display = '';

switch ($action) {
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
        $display .= saveuserevent($eid,$remind,$emailreminder,$mode);
    } else {
        $display .= COM_siteHeader();
        $display .= COM_showMessage(23);
        $display .= COM_siteFooter();
    }
    break;
case 'deleteevent':
    DB_query("DELETE FROM {$_TABLES['personal_events']} WHERE uid={$_USER['uid']} AND eid='$eid'");
    $display .= COM_refresh($_CONF['site_url'] . '/calendar.php?mode=personal&amp;msg=26');
    break;
default:
    if (!empty($eid)) {
        if ($mode == 'personal' AND DB_count($_TABLES['events'],'eid',$eid) == 0) {
            $display .= COM_siteHeader('menu');
            $display .= COM_startBlock($LANG30[38]);
            $datesql = "SELECT * FROM {$_TABLES['personal_events']} WHERE eid = '$eid'";
            $result = DB_query($datesql);
            $A = DB_fetchArray($result);
            $display .= editpersonalevent($A);
            $display .= COM_endBlock();
            $display .= COM_siteFooter();
            break;
        } else {
            $display .= COM_siteHeader('menu');
            if (strpos ($LANG30[9], '%') === false) {
                $display .= COM_startBlock ($LANG30[9]);
            } else {
                $display .= COM_startBlock (sprintf ($LANG30[9],
                                                     $_CONF['site_name']));
            }
            $datesql = "SELECT *,datestart AS start,dateend AS end FROM {$_TABLES['events']} WHERE eid = '$eid'";
        }
    } else {
        $display .= COM_startBlock($LANG30[10] . " $month/$day/$year");
        $thedate= $year . "-". $month . "-" . $day;
        $datesql = "SELECT *,datestart AS start,dateend AS end FROM {$_TABLES['events']} WHERE \"$thedate\" BETWEEN DATE_FORMAT(datestart,'%Y-%m-%d') and DATE_FORMAT(dateend,'%Y-%m-%d') ORDER BY datestart asc,title";
    }
    $cal_templates = new Template($_CONF['path_layout'] . 'calendar');
    $cal_templates->set_file(array(
        'events'=>'events.thtml',
        'details'=>'eventdetails.thtml',
        'addremove'=>'addremoveevent.thtml'
        ));
        
    $cal_templates->set_var('lang_addevent', $LANG02[6]);
    $cal_templates->set_var('lang_backtocalendar', $LANG02[15]);

    $result = DB_query($datesql);
    $nrows = DB_numRows($result);
    if ($nrows == 0) {
        $cal_templates->set_var('lang_month','');
        $cal_templates->set_var('event_year','');
        $cal_templates->set_var('event_details','');
        $cal_templates->set_var('site_url', $_CONF['site_url']);
        $cal_templates->parse('output','events');
        $display .= $cal_templates->finish($cal_templates->get_var('output'));
        $display .= $LANG02[1];
    } else {
        $cal = new Calendar();
        setCalendarLanguage ($cal);

        for ($i = 1; $i <= $nrows; $i++) {
            $A = DB_fetchArray($result);
            if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
                if (strftime("%B",strtotime($A["start"])) != $currentmonth) {
                    $str_month = $cal->getMonthName(strftime('%m',strtotime($A['start'])));
                    $cal_templates->set_var('lang_month', $str_month);
                    $cal_templates->set_var('event_year', strftime('%Y',strtotime($A['start'])));
                    //$display .= '<br><h1>' . strftime("%B %Y",strtotime($A["start"])) . '</h1>' . LB;
                    $currentmonth = strftime("%B",strtotime($A["start"]));
                }
                $cal_templates->set_var('event_title', stripslashes($A['title']));
                $cal_templates->set_var('site_url', $_CONF['site_url']);
                if (!empty($A['url'])) {
                    $cal_templates->set_var('event_begin_anchortag', '<a href="'.$A['url'].'">');
                    $cal_templates->set_var('event_title', stripslashes($A['title']));
                    $cal_templates->set_var('event_end_anchortag', '</a>');
                } else {
                    $cal_templates->set_var('event_begin_anchortag', '');
                    $cal_templates->set_var('event_title', stripslashes($A['title']));
                    $cal_templates->set_var('event_end_anchortag', '');
                }


                if (!empty($_USER['uid']) AND $_CONF['personalcalendars'] == 1) {
                    $tmpresult = DB_query("SELECT * FROM {$_TABLES["personal_events"]} WHERE eid='{$A["eid"]}' AND uid={$_USER['uid']}");
                    $tmpnrows = DB_numRows($tmpresult);
                    if ($tmpnrows > 0) {
                        $cal_templates->set_var('addremove_begin_anchortag','<a href="'
                            . $_CONF['site_url'] . '/calendar_event.php?eid=' . $A['eid'] . '&amp;mode=' . $mode . '&amp;action=deleteevent">');
                        $cal_templates->set_var('lang_addremovefromcal',$LANG02[10]);
                        $cal_templates->set_var('addremove_end_anchortag', '</a>');
                    } else {
                        $cal_templates->set_var('addremove_begin_anchortag','<a href="'
                            . $_CONF['site_url'] . '/calendar_event.php?eid=' . $A['eid'] . '&amp;mode=' . $mode . '&amp;action=addevent">');
                        $cal_templates->set_var('lang_addremovefromcal',$LANG02[9]);
                        $cal_templates->set_var('addremove_end_anchortag', '</a>');
                    }
                    $cal_templates->parse('addremove_event','addremove');
                }
                $cal_templates->set_var('lang_when', $LANG02[3]);
                if ($A['allday'] == 0 OR ($A['allday'] == 1 AND $A['start'] <> $A['end'])) {
                    $thedatetime = COM_getUserDateTimeFormat($A['start'] . ' ' . $A['timestart']);
                    $cal_templates->set_var('event_start', $thedatetime[0]);

                    if( $A['start'] == $A['end'] )
                    {
                        $thedatetime[0] = strftime( $_CONF['timeonly'], strtotime($A['dateend'].' '.$A['timeend']) );
                    }
                    else
                    {
                        $thedatetime = COM_getUserDateTimeFormat($A['end'] . ' ' . $A['timeend']);
                    }
                    

                    $cal_templates->set_var('event_end', $thedatetime[0]);

                    
                    
                } else {
                    $thedatetime = strftime("%A, " . $_CONF['shortdate'],strtotime($A['start']));
                    $cal_templates->set_var('event_start', $thedatetime);
                    $cal_templates->set_var('event_end', $LANG30[26]);
                }
                $cal_templates->set_var('lang_where', $LANG02[4]);
                if (!empty($A['address1'])) {
                    $cal_templates->set_var('event_address1', stripslashes ($A['address1']));
                } else {
                    $cal_templates->set_var('event_address1','');
                }
                if (!empty($A['address2'])) {
                    $cal_templates->set_var('br1', '<br>');
                    $cal_templates->set_var('event_address2', stripslashes ($A['address2']));
                } else {
                    $cal_templates->set_var('br1', '');
                    $cal_templates->set_var('event_address2','');
                }
                if (empty($A['city']) && empty($A['state']) && empty($A['zip'])) {
                    $cal_templates->set_var('br2','');
                } else {
                    $cal_templates->set_var('br2','<br>');
                }
                $cal_templates->set_var('event_city', stripslashes($A['city']));
                if (empty($A['state']) or ($A['state'] == '--')) 
                {
                    $cal_templates->set_var('event_state', '');
                }
                else
                {
                    $cal_templates->set_var('event_state', ', ' . $A['state']);
                }
                $cal_templates->set_var('event_zip', $A['zipcode']);
                if (!empty ($A['location']) && (!empty ($A['address1']) ||
                    !empty ($A['address2']) || !empty ($A['city']) ||
                    !empty ($A['state']) || !empty($A['zip']))) {
                    $cal_templates->set_var ('br0', '<br>');
                } else {
                    $cal_templates->set_var ('br0', '');
                }
                $cal_templates->set_var('event_location', stripslashes ($A['location']));
                $cal_templates->set_var('lang_description', $LANG02[5]);
                $cal_templates->set_var('event_description', stripslashes ($A['description']));
                $cal_templates->parse('event_details', 'details', true); 
                //$cal_templates->parse('output','events');
                //$display .= $cal_templates->finish($cal_templates->get_var('output')); 
            } else {
                //$display .= '<br><b>'.$LANG_ACCESS['accessdenied'].'</b>'
                //    .'<p>'.$LANG_ACCESS['eventdenialmsg'] . COM_endBlock() . COM_siteFooter();
            }
        } 
    }
    $cal_templates->parse('output','events');
    $display .= $cal_templates->finish($cal_templates->get_var('output')); 

    $display .= COM_endBlock() . COM_siteFooter();

} // end switch

echo $display

?>
