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
// $Id: calendar.php,v 1.9 2001/12/06 21:52:03 tony_bibbs Exp $

include('lib-common.php');
include($_CONF['path_system'] . 'classes/calendar.class.php');

function getDayViewData($result, $cur_time = '')
{
    $max = 0;

    // If no date/time passed used current timestamp
    if (empty($cur_time)) {
        $cur_time = time();
    }

    // Initialize array
    $hourcols = array();
    for ($i = 0; $i <= 23; $i++) {
        $hourcols[$i] = 0;
    }

    // Get data and increment counters
    $thedata = array();
    $nrows = DB_numRows($result);
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        if ($A['allday'] == 1 OR (($A['datestart'] < date('Y-m-d',$cur_time)) AND ($A['dateend'] > date('Y-m-d',$cur_time)))) {
            // This is an all day event
            $alldaydata[$i] = $A;
        } else {
            // This is an event with start/end times
            if ($A['datestart'] < date('Y-m-d', $cur_time)) {
                $starthour = '00';
            } else {
                $starthour = date('G', strtotime($A['datestart'] . ' ' . $A['timestart']));
            }
            $endhour = date('G', strtotime($A['dateend'] . ' ' . $A['timeend']));
            if (date('i', strtotime($A['dateend'] . ' ' . $A['timeend'])) == '00') {
                $endhour = $endhour - 1; 
            }
            
            $hourcols[$starthour] = $hourcols[$starthour] + 1;
            if ($hourcols[$starthour] > $max) {
                $max = $hourcols[$starthour];
            }
            $thedata[$i] = $A;
        }
    }
    return array($hourcols, $thedata, $max, $alldaydata);

}

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
if (empty($day)) {
    $day = $currentday;
}

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

$cal->setLanguage($lang_days, $lang_months);

// Build calendar matrix
$cal->setCalendarMatrix($month,$year);

switch ($view) {
case 'day':
    $cal_templates = new Template($_CONF['path_layout'] . 'calendar/dayview');
    $cal_templates->set_file(array('column'=>'column.thtml','event'=>'singleevent.thtml','dayview'=>'dayview.thtml'));
    $cal_templates->set_var('site_url', $_CONF['site_url']);
    $cal_templates->set_var('mode', $mode);
    $cal_templates->set_var('lang_week', $LANG30[27]);
    $cal_templates->set_var('month',$month);
    $cal_templates->set_var('day', $day);
    $cal_templates->set_var('year',$year);
    if ($mode == 'personal') {
        $cal_templates->set_var('calendar_title', $LANG30[28] . ' ' . $_USER['username']);
    } else {
        $cal_templates->set_var('calendar_title', $_CONF['site_name'] . ' ' . $LANG30[29]);
    }
    $thedate = COM_getUserDateTimeFormat(mktime(0,0,0,$month,$day,$year));
    $cal_templates->set_var('week_num',strftime('%U',$thedate[1]));
    if ($mode == 'personal') {
        $calsql = "SELECT * FROM {$_TABLES["personal_events"]} WHERE (uid = {$_USER["uid"]}) AND ((allday=1 AND datestart = \"$year-$month-$day\") OR (datestart >= \"$year-$month-$day 00:00:00\" AND datestart <= \"$year-$month-$day 23:59:59\") OR (dateend >= \"$year-$month-$day 00:00:00\" AND dateend <= \"$year-$month-$day 23:59:59\") OR (\"$year-$month-$day\" between datestart and dateend)) ORDER BY datestart";
    } else {
        $calsql = "SELECT * FROM {$_TABLES["events"]} WHERE ((allday=1 AND datestart = \"$year-$month-$day\") OR (datestart >= \"$year-$month-$day 00:00:00\" AND datestart <= \"$year-$month-$day 23:59:59\") OR (dateend >= \"$year-$month-$day 00:00:00\" AND dateend <= \"$year-$month-$day 23:59:59\") OR (\"$year-$month-$day\" between datestart and dateend)) ORDER BY datestart";
    }
    $result = DB_query($calsql);
    $nrows = DB_numRows($result);
    list($hourcols, $thedata, $max, $alldaydata) = getDayViewData($result);
/*
    for ($i = 0; $i <= 23; $i++) {
        print "hourcols[$i] = {$hourcols[$i]} \n";
    }
    print "nrows = $nrows \n";
    exit;
*/

    // Get all day events
    if (count($alldaydata) > 0) {
        for ($i = 1; $i <= count($alldaydata); $i++) {
            $A = current($alldaydata);
            $cal_templates->set_var('event_time', $LANG30[26]);
            $cal_templates->set_var('eid', $A['eid']);
            $cal_templates->set_var('event_title',stripslashes($A['title']));
            $cal_templates->parse('allday_event','event', true); 
            next($alldaydata);
        }
    } else {
        $cal_templates->set_var('allday_events','&nbsp;');
    }

    //$cal_templates->set_var('first_colspan', $maxcols);
    //$cal_templates->set_var('title_colspan', $maxcols + 1);
    for ($i = 0; $i <= 23; $i++) {
        if ($hourcols[$i] > 0) {
        } else {
        $cal_templates->set_var('event_entry','&nbsp;');
        //$cal_templates->parse($i . '_cols','column',true);
        //$cal_templates->parse($i . '_cols','column');
        }
        if ($nrows > 0) {
            $numevents = current($hourcols);
        }
        //$colsleft = $maxcols;
        $cal_templates->set_var('layout_url', $_CONF['layout_url']);
        for ($j = 1; $j <= $numevents; $j++) {
            $A = current($thedata);
            $cal_templates->set_var('event_time', date('g:ia',strtotime($A['datestart'].' '.$A['timestart'])) . '-'. date('g:ia',strtotime($A['dateend'].' '.$A['timeend'])));
            $cal_templates->set_var('lang_deleteevent', $LANG30[30]);
            $cal_templates->set_var('eid', $A['eid']);
                $cal_templates->set_var('event_title', stripslashes($A['title']));
            if ($j < $numevents) {
                $cal_templates->set_var('br', '<br>');
            } else {
                $cal_templates->set_var('br', '');
            }
            $cal_templates->parse('event_entry','event',true);
            $colsleft = $colsleft - 1;
            next($thedata);
        } 
        $cal_templates->parse($i.'_cols','column',true);
        if ($nrows > 0) {
            next($hourcols);
        } 
    }
    $display .= $cal_templates->parse('output', 'dayview');
    $display .= COM_siteFooter();

    break;
case 'week':
    $cal_templates = new Template($_CONF['path_layout'] . 'calendar/weekview');
    $cal_templates->set_file(array('week'=>'weekview.thtml','events'=>'events.thtml'));
    $cal_templates->set_var('site_url', $_CONF['site_url']);
    $cal_templates->set_var('mode', $mode);
    $cal_templates->set_var('lang_week', $LANG30[27]);
    if ($mode == 'personal') {
        $cal_templates->set_var('calendar_title', $LANG30[28] . ' ' . $_USER['username']);
    } else {
        $cal_templates->set_var('calendar_title', $_CONF['site_name'] . ' ' . $LANG30[29]);
    }
    $thedate = COM_getUserDateTimeFormat(mktime(0,0,0,$month,$day,$year));
    $cal_templates->set_var('week_num',$thedate[1]);
    for ($i = 1; $i <= 7; $i++) {
        $dayname = $cal->getDayName(date('w',$thedate[1]) + 1);
        $monthnum = date('n', $thedate[1]);
        $daynum = date('j', $thedate[1]);
        $yearnum = date('Y', $thedate[1]);
        if ($yearnum . '-' . $monthnum . '-' . $daynum == date('Y-m-d',time())) {
            $cal_templates->set_var('class'.$i,'weekview_curday');
        } else {
            $cal_templates->set_var('class'.$i,'weekview_offday');
        }
        $monthname = $cal->getMonthName($monthnum);
        $cal_templates->set_var('day'.$i,$dayname . ", <a href=\"{$_CONF['site_url']}/calendar.php?mode=$mode&view=day&day=$daynum&month=$monthnum&year=$yearnum\">" . $monthname . ' ' . $daynum . ', ' . $yearnum . '</a>');
        $cal_templates->set_var('langlink_addevent'.$i, '<a href="' . $_CONF['site_url'] . "/submit.php?type=event&mode=$mode&day=$daynum&month=$monthnum&year=$yearnum" . '">' . $LANG30[8] . '</a>');
        if ($mode == 'personal') {
            $calsql = "SELECT * FROM {$_TABLES["personal_events"]} WHERE (uid = {$_USER["uid"]}) AND ((allday=1 AND datestart = \"$yearnum-$monthnum-$daynum\") OR (datestart >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND datestart <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (dateend >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND dateend <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (\"$yearnum-$monthnum-$daynum\" between datestart and dateend)) ORDER BY datestart";
        } else {
            $calsql = "SELECT * FROM {$_TABLES["events"]} WHERE ((allday=1 AND datestart = \"$yearnum-$monthnum-$daynum\") OR (datestart >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND datestart <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (dateend >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND dateend <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (\"$yearnum-$monthnum-$daynum\" between datestart and dateend)) ORDER BY datestart";
        }
        $result = DB_query($calsql);
        $nrows = DB_numRows($result);
        for ($j = 1; $j <= $nrows; $j++) {
            $A = DB_fetchArray($result);
            if ($A['allday'] == 1) {
                $cal_templates->set_var('event_starttime', $LANG30[26]);
                $cal_templates->set_var('event_endtime','');
            } else {
                $startstamp = strtotime($A['datestart'] . ' ' . $A['timestart']);
                $endstamp = strtotime($A['dateend'] . ' ' . $A['timeend']);
                $startday = date('d',$startstamp);
                $startmonth = date('n',$startstamp);
                $endday = date('d', $endstamp);
                $endmonth = date('n',$endstamp);
                if (($startmonth == $monthnum && $daynum > $startday) OR ($startmonth <> $monthnum)) {
                    $starttime = date('n/j g:i a',$startstamp);
                } else { 
                    $starttime = date('g:i a', $startstamp); 
                }
                if (($endmonth == $monthnum && $daynum < $endday) OR ($endmonth <> $monthnum)) {
                    $endtime = date('n/j g:i a', $endstamp);
                } else { 
                    $endtime = date('g:i a', $endstamp); 
                }
                $cal_templates->set_var('event_starttime', $starttime);
                $cal_templates->set_var('event_endtime', ' - ' . $endtime);
            }
            $cal_templates->set_var('event_title_and_link', '<a href="' . $_CONF['site_url'] . '/calendar_event.php?mode=' . $mode . '&eid=' . $A['eid'] . '">' . stripslashes($A['title']) . '</a>');
            $cal_templates->set_var('delete_imagelink','<a href="' . $_CONF['site_url'] . '/calendar_event.php?action=deleteevent&eid=' . $A['eid'] . '"><img alt="' . $LANG30[30] . '" border="0" src="' . $_CONF['layout_url'] . '/images/icons/delete_event.gif"></a>');
            $cal_templates->parse('events_day'.$i,'events',true);
            
        }
        if ($nrows == 0) {
            $cal_templates->set_var('event_starttime','&nbsp');
            $cal_templates->set_var('event_endtime','');
            $cal_templates->set_var('event_title_and_link','');
            $cal_templates->set_var('delete_imagelink','');
            $cal_templates->parse('events_day'.$i,'events',true);
        }
        // Go to next day
        $thedate = COM_getUserDateTimeFormat(mktime(0,0,0,$monthnum, $daynum + 1, $yearnum));
    }
    $display .= $cal_templates->parse('output','week');
    $display .= COM_siteFooter();
    break;
default:
// Load templates
$cal_templates = new Template($_CONF['path_layout'] . 'calendar');
$cal_templates->set_file(array('calendar'=>'calendar.thtml',
                                'week' => 'calendarweek.thtml',
                                'day' => 'calendarday.thtml',
                                'event' => 'calendarevent.thtml',
				'mastercal'=>'mastercalendaroption.thtml',
				'personalcal'=>'personalcalendaroption.thtml',
				'addevent'=>'addeventoption.thtml'));

$cal_templates->set_var('site_url', $_CONF['site_url']);
$cal_templates->set_var('mode', $mode);
$cal_templates->set_var('previous_months_cal',getSmallCalendar($prevmonth, $prevyear, $mode));
$cal_templates->set_var('next_months_cal',getSmallCalendar($nextmonth, $nextyear, $mode));
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
    $wday = '';
    for ($j = 1; $j <= 7; $j++) {
        $curday = $cal->getDayData($i, $j);
        if (!empty($curday)) {
            // Cache first actual day of the week to build week view link
            if (empty($wday)) {
                $wday = $curday->daynumber;
            }
            if (($currentyear > $year) OR
                ($currentmonth > $month && $currentyear == $year) OR
                ($currentmonth == $month && $currentday > $curday->daynumber && $currentyear == $year)) {
                $cal_templates->set_var('cal_day_style', 'cal_oldday'); 
            } else {
                if ($currentyear == $year && $currentmonth == $month && $currentday == $curday->daynumber) {
                    $cal_templates->set_var('cal_day_style','cal_today');
                } else {
                    $cal_templates->set_var('cal_day_style', 'cal_futureday');
                }
            }

            if (strlen($curday->daynumber) == 1) {
                $curday->daynumber = '0' . $curday->daynumber;
            }

            $cal_templates->set_var('cal_day_anchortags', '<a href="/calendar.php?view=day&mode=' . $mode . '&day=' . $curday->daynumber. '&month=' . $month
                . '&year=' . $year . '" class="cal_date">' . $curday->daynumber. '</a><hr>');

            // NEED TO CHANGE TO GET ENTRIES
            if ($mode == 'personal') {
                //$calsql = "SELECT {$_TABLES["events"]}.* FROM {$_TABLES["events"]}, {$_TABLES["userevent"]} WHERE ({$_TABLES["events"]}.eid = {$_TABLES["userevent"]}.eid) AND ({$_TABLES["userevent"]}.uid = {$_USER["uid"]}) AND ((datestart >= \"$year-$month-$curday->daynumber 00:00:00\" AND datestart <= \"$year-$month-$curday->daynumber 23:59:59\") OR (dateend >= \"$year-$month-$curday->daynumber 00:00:00\" AND dateend <= \"$year-$month-$curday->daynumber 23:59:59\") OR (\"$year-$month-$curday->daynumber\" between datestart and dateend)) ORDER BY datestart";
                $calsql = "SELECT * FROM {$_TABLES["personal_events"]} WHERE (uid = {$_USER["uid"]}) AND ((datestart >= \"$year-$month-$curday->daynumber 00:00:00\" AND datestart <= \"$year-$month-$curday->daynumber 23:59:59\") OR (dateend >= \"$year-$month-$curday->daynumber 00:00:00\" AND dateend <= \"$year-$month-$curday->daynumber 23:59:59\") OR (\"$year-$month-$curday->daynumber\" between datestart and dateend)) ORDER BY datestart";
            } else {
                $calsql = "SELECT * FROM {$_TABLES["events"]} WHERE (datestart >= \"$year-$month-$curday->daynumber 00:00:00\" AND datestart <= \"$year-$month-$curday->daynumber 23:59:59\") OR (dateend >= \"$year-$month-$curday->daynumber 00:00:00\" AND dateend <= \"$year-$month-$curday->daynumber 23:59:59\") OR (\"$year-$month-$curday->daynumber\" between datestart and dateend) ORDER BY datestart";
            }
            
            $query2 = DB_query($calsql);
            $q2_numrows = DB_numRows($query2);

            if ($q2_numrows > 0) {
                $entries = '';
                for ($z = 1; $z <= $q2_numrows; $z++) {
                    $results = DB_fetchArray($query2);
                    if (SEC_hasAccess($results['owner_id'],$results['group_id'],$results['perm_owner'],$results['perm_group'],$results['perm_members'],$results['perm_anon']) > 0) {
                        if ($results['title']) {
                            $cal_templates->set_var('cal_day_entries','');
                            $entries .= '<a href="calendar_event.php?mode=' . $mode . '&eid=' . $results['eid'] . '" class="cal_event">' 
                                . stripslashes($results['title']) . '</a><hr>';
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
    $cal_templates->set_var('wmonth', $month);
    $cal_templates->set_var('wday', $wday);
    $cal_templates->set_var('wyear', $year);
    $cal_templates->parse('cal_week', 'week',true);
    $cal_templates->set_var('cal_days','');
}

if ($mode == 'personal') {
    $cal_templates->set_var('lang_mastercal', $LANG30[25] . $LANG30[11]);
    $cal_templates->parse('master_calendar_option','mastercal',true); 
} else {
    if ($_USER['uid'] > 1) {
        $cal_templates->set_var('lang_mycalendar', $LANG30[12]);
        $cal_templates->parse('personal_calendar_option','personalcal',true); 
    } else {
        $cal_templates->set_var('personal_calendar_option','&nbsp;');
    }
}
$cal_templates->set_var('lang_addevent', $LANG30[8]);
$cal_templates->set_var('cal_curmo_num', $currentmonth);
$cal_templates->set_var('cal_curyr_num', $currentyear);
$cal_templates->parse('add_event_option','addevent',true);

$cal_templates->parse('output','calendar');
$display .= $cal_templates->finish($cal_templates->get_var('output'));
	
$display .= COM_siteFooter();
break;

} // end switch	

echo $display;

?>
