<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-common.php                                                            |
// | Geeklog common library.                                                   |
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
// $Id: calendar.php,v 1.8 2001/11/05 21:24:51 tony_bibbs Exp $

include('lib-common.php');
include($_CONF['path_system'] . 'classes/calendar.class.php');

/**
* Gets a small, text-only version of a calendar
*
* $m        int        Month to display
* $y        int        Year to display
*
*/
function getSmallCalendar($m, $y, $mode='')
{
    $retval = '';
    $mycal = new Calendar();

    $mycal->setCalendarMatrix($m,$y);

    if (!empty($mode)) {
        $mode = '&mode=' . $mode;
    }

    $retval .= '<font size=-2>' . LB . '<table>' . LB 
        . '<tr><td align=center colspan=7><a href="' . $_CONF['site_url'] . '/calendar.php?month=' . $m . '&year=' . $y . $mode . '">' 
        . $mycal->getMonthName($m) . '<a></td></tr>'
        . '<tr><th>S</th><th>M</th><th>T</th><th>W</th><th>Th</th><th>F</th><th>S</th></tr>'.LB;

    for ($i = 1; $i <= 6; $i++) {
        $retval .= '<tr>' . LB;
        for ($j = 1; $j <= 7; $j++) {
            $retval .= '<td>' . LB;
            $curday = $mycal->getDayData($i, $j);
            if (!empty($curday)) {
                $retval .= $curday->daynumber;
            } else {
                if ($i > 1) {
                    $i = 7;
                    $j = 8;
                }
                $retval .= "&nbsp;";
            }
            $retval .= "</td>".LB;
        }
        $retval .= "</tr>".LB;
    }

    $retval .= '</table></font>'.LB;
    
    return $retval;
}
		
$display .= COM_siteHeader('');

// Create new calendar object
$cal = new Calendar();

// Get current month
$currentmonth = date('m', time());
if (empty($month)) {
    $month = $currentmonth;
}

// Get current year
$currentyear = date('Y', time());
if (empty($year)) {
    $year = $currentyear;
}

// Get current day
$currentday =  date("j", time());

// Get previous month and year
$prevmonth = $month - 1;
if ($prevmonth == 0) {
    $prevmonth = 12;
    $prevyear = $year - 1;
} else {
    $prevyear = $year;
}

// Get next month and year
$nextmonth = $month + 1;
if ($nextmonth == 13) {
    $nextmonth = 1;
    $nextyear = $year + 1;
} else {
    $nextyear = $year;
}

$cal->setLanguage('',$lang_months);

// Build calendar matrix
$cal->setCalendarMatrix($month,$year);

// Load templates
$cal_templates = new Template($_CONF['path_layout'] . 'calendar');
$cal_templates->set_file(array('calendar'=>'calendar.thtml',
                                'week' => 'calendarweek.thtml',
                                'day' => 'calendarday.thtml',
                                'event' => 'calendarevent.thtml',
				'mastercal'=>'mastercalendaroption.thtml',
				'personalcal'=>'personalcalendaroption.thtml',
				'addevent'=>'addeventoption.thtml'));

$cal_templates->set_var('previous_months_cal',getSmallCalendar($prevmonth, $prevyear, $mode));
$cal_templates->set_var('next_months_cal',getSmallCalendar($nextmonth, $nextyear));
$cal_templates->set_var('cal_prevmo_num', $prevmonth);
$cal_templates->set_var('cal_prevyr_num', $prevyear);
$cal_templates->set_var('cal_month_and_year', $cal->getMonthName($month) . ' ' . $year);
$cal_templates->set_var('cal_nextmo_num', $nextmonth);
$cal_templates->set_var('cal_nextyr_num', $nextyear);

$cal_templates->set_var('lang_sunday', $LANG30[1]);
$cal_templates->set_var('lang_monday', $LANG30[2]);
$cal_templates->set_var('lang_tuesday', $LANG30[3]);
$cal_templates->set_var('lang_wednesday', $LANG30[4]);
$cal_templates->set_var('lang_thursday', $LANG30[5]);
$cal_templates->set_var('lang_friday', $LANG30[6]);
$cal_templates->set_var('lang_saturday', $LANG30[7]);

$cal_templates->set_var('lang_january', $LANG30[13]);
if ($month == 1) $cal_templates->set_var('selected_jan','SELECTED');
$cal_templates->set_var('lang_february', $LANG30[14]);
if ($month == 2) $cal_templates->set_var('selected_feb','SELECTED');
$cal_templates->set_var('lang_march', $LANG30[15]);
if ($month == 3) $cal_templates->set_var('selected_mar','SELECTED');
$cal_templates->set_var('lang_april', $LANG30[16]);
if ($month == 4) $cal_templates->set_var('selected_apr','SELECTED');
$cal_templates->set_var('lang_may', $LANG30[17]);
if ($month == 5) $cal_templates->set_var('selected_may','SELECTED');
$cal_templates->set_var('lang_june', $LANG30[18]);
if ($month == 6) $cal_templates->set_var('selected_jun','SELECTED');
$cal_templates->set_var('lang_july', $LANG30[19]);
if ($month == 7) $cal_templates->set_var('selected_jul','SELECTED');
$cal_templates->set_var('lang_august', $LANG30[20]);
if ($month == 8) $cal_templates->set_var('selected_aug','SELECTED');
$cal_templates->set_var('lang_september', $LANG30[21]);
if ($month == 9) $cal_templates->set_var('selected_sep','SELECTED');
$cal_templates->set_var('lang_october', $LANG30[22]);
if ($month == 10) $cal_templates->set_var('selected_oct','SELECTED');
$cal_templates->set_var('lang_november', $LANG30[23]);
if ($month == 11) $cal_templates->set_var('selected_nov','SELECTED');
$cal_templates->set_var('lang_december', $LANG30[24]);
if ($month == 12) $cal_templates->set_var('selected_dec','SELECTED');

for ($y = $currentyear - 5; $y <= $currentyear + 5; $y++) {
    $yroptions .= '<option value="' . $y . '" ';
    if ($y == $year) {
        $yroptions .= 'SELECTED';
    }
    $yroptions .= '>' . $y . '</option>'.LB;
}
$cal_templates->set_var('year_options', $yroptions);

for ($i = 1; $i <= 6; $i++) {
    for ($j = 1; $j <= 7; $j++) {
        $curday = $cal->getDayData($i, $j);
        if (!empty($curday)) {
            if (($currentyear > $year) OR
                ($currentmonth > $month && $currentyear == $year) OR
                ($currentmonth == $month && $currentday > $curday->daynumber && $currentyear == $year)) {
                $cal_templates->set_var('cal_day_style', 'cal_oldday'); 
            } else {
                $cal_templates->set_var('cal_day_style', 'cal_newday');
            }

            if (strlen($curday->daynumber) == 1) {
                $curday->daynumber = '0' . $curday->daynumber;
            }

            if ($curday->daynumber == 30) {
                COM_errorLog("30th IS NOT NULL");
            }

            $cal_templates->set_var('cal_day_anchortags', '<a href="/calendar_event.php?day=' . $curday->daynumber. '&month=' . $month
                . '&year=' . $year . '" class="cal_date">' . $curday->daynumber. '</a><hr>');

            // NEED TO CHANGE TO GET ENTRIES
            if ($mode == 'personal') {
                $calsql = "SELECT {$_TABLES["events"]}.* FROM {$_TABLES["events"]}, {$_TABLES["userevent"]} WHERE ({$_TABLES["events"]}.eid = {$_TABLES["userevent"]}.eid) AND ({$_TABLES["userevent"]}.uid = {$_USER["uid"]}) AND ((datestart >= \"$year-$month-$curday->daynumber 00:00:00\" AND datestart <= \"$year-$month-$curday->daynumber 23:59:59\") OR (dateend >= \"$year-$month-$curday->daynumber 00:00:00\" AND dateend <= \"$year-$month-$curday->daynumber 23:59:59\") OR (\"$year-$month-$curday->daynumber\" between datestart and dateend)) ORDER BY datestart";
            } else {
                $calsql = "SELECT * FROM {$_TABLES["events"]} WHERE (datestart >= \"$year-$month-$curday->daynumber 00:00:00\" AND datestart <= \"$year-$month-$curday->daynumber 23:59:59\") OR (dateend >= \"$year-$month-$curday->daynumber 00:00:00\" AND dateend <= \"$year-$month-$curday->daynumber 23:59:59\") OR (\"$year-$month-$curday->daynumber\" between datestart and dateend) ORDER BY datestart";
            }
            
            $query2 = DB_query($calsql);

            $q2_numrows = DB_numRows($query2);

            if ($q2_numrows > 0) {
                for ($z = 1; $z <= $q2_numrows; $z++) {
                    $results = DB_fetchArray($query2);
                    if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
                        if ($results['title']) {
                            $cal_templates->set_var('cal_day_entries','');
                            $entries = '<a href="calendar_event.php?&eid=' . $results['eid'] . '" class="cal_event">' 
                                . $results['title'] . '</a><hr>';
                        }
                    } 
                }
                for ($z=$z;$z<=4;$z++) {
                    $entries .= '<br>';
                }

                $cal_templates->set_var('event_anchortags', $entries);

            } else {
                if ($q2_numrows < 4) {
                    for ($t=0; $t < (4 - $q2_numrows); $t++) {
                        $cal_templates->set_var('cal_day_entries','<br><br><br><br>');
                    }
                }
            }

            $cal_templates->parse('cal_day_entries', 'event', true);
            $cal_templates->set_var('event_anchortags','');
        } else {
            if ($i > 1) {
                // Close out calendar if needed
                for ($k = $j; $k <= 7; $k++) {
                    $cal_templates->set_var('cal_day_style','cal_nullday');
                    $cal_templates->set_var('cal_day_anchortags', '');
                    $cal_templates->set_var('cal_day_entries','&nbsp;');
                    if ($k < 7) $cal_templates->parse('cal_days', 'day', true);
                }
                // for looping to stop...we are done now
                $i = 7;
                $j = 8;
            } else {
                // Print empty box for any day in the first week that occur before the first day
                $cal_templates->set_var('cal_day_style','cal_nullday');
                $cal_templates->set_var('cal_day_anchortags', '');
                $cal_templates->set_var('cal_day_entries','&nbsp;');
            }
        }
        $cal_templates->parse('cal_days','day',true);
    }
    $cal_templates->parse('cal_week', 'week',true);
    $cal_templates->set_var('cal_days','');
}

if ($mode == 'personal') {
    $cal_templates->set_var('lang_mastercal', $LANG30[25] . $LANG30[11]);
    $cal_templates->parse('master_calendar_option','mastercal',true); 
} else {
    $cal_templates->set_var('lang_mycalendar', $LANG30[12]);
    $cal_templates->parse('personal_calendar_option','personalcal',true); 
}
$cal_templates->set_var('lang_addevent', $LANG30[8]);
$cal_templates->set_var('cal_curmo_num', $currentmonth);
$cal_templates->set_var('cal_curyr_num', $currentyear);
$cal_templates->parse('add_event_option','addevent',true);

$cal_templates->parse('output','calendar');
$display .= $cal_templates->finish($cal_templates->get_var('output'));
	
$display .= COM_siteFooter();
	
echo $display;

?>
