<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | calendar.php                                                              |
// |                                                                           |
// | Geeklog calendar.                                                         |
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
// $Id: calendar.php,v 1.57 2005/12/22 09:01:26 dhaun Exp $

require_once ('lib-common.php');
require_once ($_CONF['path_system'] . 'classes/calendar.class.php');

$display = '';

if (empty ($_USER['username']) &&
    (($_CONF['loginrequired'] == 1) || ($_CONF['calendarloginrequired'] == 1))) {
    $display .= COM_siteHeader('');
    $display .= COM_startBlock ($LANG_LOGIN[1], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $login = new Template($_CONF['path_layout'] . 'submit');
    $login->set_file (array ('login'=>'submitloginrequired.thtml'));
    $login->set_var ('login_message', $LANG_LOGIN[2]);
    $login->set_var ('site_url', $_CONF['site_url']);   
    $login->set_var ('layout_url', $_CONF['layout_url']);   
    $login->set_var ('lang_login', $LANG_LOGIN[3]);
    $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
    $login->parse ('output', 'login');
    $display .= $login->finish ($login->get_var('output'));
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter();
    echo $display;
    exit;
}

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

    $alldaydata = array ();
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        if ($A['allday'] == 1 OR (($A['datestart'] < date('Y-m-d',$cur_time)) AND ($A['dateend'] > date('Y-m-d',$cur_time)))) {
            // This is an all day event
            $alldaydata[$i] = $A;
        } else {
            // This is an event with start/end times
            if ($A['datestart'] < date('Y-m-d', $cur_time) AND $A['dateend'] >= date('Y-m-d', $cur_time)) {
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

function setCalendarLanguage (&$aCalendar)
{
    global $_CONF, $LANG30;

    $lang_days = array ('sunday'    => $LANG30[1],
                        'monday'    => $LANG30[2],
                        'tuesday'   => $LANG30[3],
                        'wednesday' => $LANG30[4],
                        'thursday'  => $LANG30[5],
                        'friday'    => $LANG30[6],
                        'saturday'  => $LANG30[7]);

    $lang_months = array ('january'   => $LANG30[13],
                          'february'  => $LANG30[14],
                          'march'     => $LANG30[15],
                          'april'     => $LANG30[16],
                          'may'       => $LANG30[17],
                          'june'      => $LANG30[18],
                          'july'      => $LANG30[19],
                          'august'    => $LANG30[20],
                          'september' => $LANG30[21],
                          'october'   => $LANG30[22],
                          'november'  => $LANG30[23],
                          'december'  => $LANG30[24]);

    $aCalendar->setLanguage ($lang_days, $lang_months, $_CONF['week_start']);
}

/**
* Returns an abbreviated day's name
*
* Note: This is a workaround, to be replaced with something more sensible
*       in future versions ...
*
* @param    int     $day    1 = Sunday, 2 = Monday, ...
* @return   string          abbreviated day's name (3 characters)
*
* The problem here is that substr may return nonsense for UTF-8 strings, but
* mb_substr may not be available.
*
*/
function shortDaysName ($day)
{
    global $LANG_CHARSET, $LANG30;

    static $mb_enabled;

    if (!isset ($mb_enabled)) {
        $mb_enabled = function_exists ('mb_substr');
    }

    $shortday = '';
    if ($mb_enabled) {
        // when mb_substr is available, use it
        $shortday = mb_substr ($LANG30[$day], 0, 2, $LANG_CHARSET);
    } else if ($LANG_CHARSET == 'utf-8') {
        // no mb_substr, but UTF-8 string: cheat and hope that the locale
        // matches the current language ...
        // Note: May 1st, 2005 was a Sunday
        $shortday = date ('D', mktime (0, 0, 0, 5, $day, 2005));
    } else {
        $shortday = substr ($LANG30[$day], 0, 2);
    }

    return $shortday;
}

function makeDaysHeadline ()
{
    global $_CONF, $LANG30;

    $retval = '<tr><th>';
    if ($_CONF['week_start'] == 'Mon') {
        $retval .= shortDaysName (2) . '</th><th>'
                . shortDaysName (3) . '</th><th>'
                . shortDaysName (4) . '</th><th>'
                . shortDaysName (5) . '</th><th>'
                . shortDaysName (6) . '</th><th>'
                . shortDaysName (7) . '</th><th>'
                . shortDaysName (1) . '</th></tr>';
    } else {
        $retval .= shortDaysName (1) . '</th><th>'
                . shortDaysName (2) . '</th><th>'
                . shortDaysName (3) . '</th><th>'
                . shortDaysName (4) . '</th><th>'
                . shortDaysName (5) . '</th><th>'
                . shortDaysName (6) . '</th><th>'
                . shortDaysName (7) . '</th></tr>';
    }

    return $retval;
}

/**
* Add the 'mode=' parameter to a URL
*
* @param    string  $mode   the mode ('personal' or empty string)
* @param    boolean $more   whether there are more parameters in the URL or not
* @param    string          'mode' parameter for the URL or an empty string
*
*/
function addMode ($mode, $more = true)
{
    $retval = '';

    if (!empty ($mode)) {
        $retval .= 'mode=' . $mode;
        if ($more) {
            $retval .= '&amp;';
        }
    }

    return $retval;
}

/**
* Return link to "delete event" image
*
* Note: Personal events can be deleted if the current user is the owner of the
*       calendar and has _read_ access to them.
*
* @param    string  $mode   'personal' for personal events
* @param    array   $A      event permissions and id
* @return   string          link or empty string
*
*/
function getDeleteImageLink ($mode, $A)
{
    global $_CONF, $LANG22, $LANG30, $_IMAGE_TYPE;

    $retval = '';

    if ($mode == 'personal') {
        if (SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
                $A['perm_group'], $A['perm_members'], $A['perm_anon']) > 0) {

            $retval = '<a href="' . $_CONF['site_url']
                    . '/calendar_event.php?action=deleteevent&amp;eid='
                    . $A['eid'] . '"><img src="' . $_CONF['layout_url']
                    . '/images/icons/delete_event.' . $_IMAGE_TYPE
                    . '" border="0" alt="' . $LANG30[30] . '" title="'
                    . $LANG30[30] . '"></a>';
        }
    } else if (SEC_hasRights ('event.edit')) {
        if (SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
                $A['perm_group'], $A['perm_members'], $A['perm_anon']) == 3) {

            $retval = '<a href="' . $_CONF['site_admin_url']
                    . '/event.php?mode=' . $LANG22[22] . '&amp;eid='
                    . $A['eid'] . '"><img src="' . $_CONF['layout_url']
                    . '/images/icons/delete_event.' . $_IMAGE_TYPE
                    . '" border="0" alt="' . $LANG30[30] . '" title="'
                    . $LANG30[30] . '"></a>';
        }
    }

    return $retval;
}

/**
* Gets a small, text-only version of a calendar
*
* @param    int     $m  Month to display
* @param    int     $y  Year to display
* @return   string      HTML for small calendar
*
*/
function getSmallCalendar ($m, $y, $mode = '')
{
    global $_CONF, $LANG30;

    $retval = '';
    $mycal = new Calendar ();
    setCalendarLanguage ($mycal);
    $mycal->setCalendarMatrix ($m, $y);

    if (!empty ($mode)) {
        $mode = '&amp;mode=' . $mode;
    }

    $retval .= '<table class="smallcal">' . LB 
            . '<tr class="smallcal-headline"><td align="center" colspan="7">'
            . '<a href="' . $_CONF['site_url'] . '/calendar.php?month=' . $m
            . '&amp;year=' . $y . $mode . '">' . $mycal->getMonthName ($m)
            . '</a></td></tr>' . makeDaysHeadline () . LB;

    for ($i = 1; $i <= 6; $i++) {
        if ($i % 2 == 0) {
            $tr = '<tr class="smallcal-week-even">' . LB;
        } else {
            $tr = '<tr class="smallcal-week-odd">' . LB;
        }
        $tr_sent = false;
        for ($j = 1; $j <= 7; $j++) {
            $curday = $mycal->getDayData ($i, $j);
            if (!$tr_sent) {
                if (empty ($curday)) {
                    $retval .= '<tr class="smallcal-week-empty">' . LB;
                } else {
                    $retval .= $tr;
                }
                $tr_sent = true;
            }
            $retval .= '<td align="right"';
            if (!empty ($curday)) {
                if ($j % 2 == 0) {
                    $retval .= ' class="smallcal-day-even">' . LB;
                } else {
                    $retval .= ' class="smallcal-day-odd">' . LB;
                }
                $retval .= $curday->daynumber;
            } else {
                $retval .= ' class="smallcal-day-empty">&nbsp;';
            }
            $retval .= '</td>' . LB;
        }
        $retval .= '</tr>' . LB;
    }

    $retval .= '</table>' . LB;
    
    return $retval;
}

/**
* Builds Quick Add form
*
*/
function getQuickAdd($tpl, $month, $day, $year)
{
    global $LANG30;

    $tpl->set_var ('month_options', COM_getMonthFormOptions ($month));
    $tpl->set_var ('day_options', COM_getDayFormOptions ($day));
    $tpl->set_var ('year_options', COM_getYearFormOptions ($year));

    $cur_hour = date ('H', time ());
    if ($cur_hour >= 12) {
        $tpl->set_var ('am_selected', '');
        $tpl->set_var ('pm_selected', 'selected="selected"');
    } else {
        $tpl->set_var ('am_selected', 'selected="selected"');
        $tpl->set_var ('pm_selected', '');
    }
    if ($cur_hour > 12) {
        $cur_hour = $cur_hour - 12;
    } else if ($cur_hour == 0) {
        $cur_hour = 12;
    }
    $tpl->set_var('hour_options', COM_getHourFormOptions ($cur_hour));

    $tpl->set_var ('lang_event', $LANG30[32]);
    $tpl->set_var ('lang_date', $LANG30[33]);
    $tpl->set_var ('lang_time', $LANG30[34]);
    $tpl->set_var ('lang_add', $LANG30[31]);
    $tpl->set_var ('lang_quickadd', $LANG30[35]);
    $tpl->set_var ('lang_submit', $LANG30[36]);
    $tpl->parse ('quickadd_form', 'quickadd', true);

    return $tpl;
}

/** 
* Returns timestamp for the prior sunday of a given day
*
*/
function getPriorSunday($month, $day, $year) 
{
    $thestamp = mktime(0, 0, 0, $month, $day, $year);
    $newday = $day - date('w', $thestamp);
    $newstamp = mktime(0,0,0,$month,$newday,$year);
    $newday = date('j',$newstamp);
    $newmonth = date('n', $newstamp);
    $newyear = date('Y',$newstamp);

    return array($newmonth, $newday, $newyear);
}

$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}

if ($mode != 'personal') {
    $mode = '';
}

if ($mode == 'personal') {
    $display .= COM_siteHeader ('menu', $LANG12[40]);
} else {
    $display .= COM_siteHeader ('menu', $LANG12[39]);
}

// Set mode back to master if user refreshes screen after their session expires
if (($mode == 'personal') && (!isset ($_USER['uid']) || ($_USER['uid'] <= 1))) {
    $mode = '';
}

if ($mode == 'personal' AND $_CONF['personalcalendars'] == 0) {
    // User is trying to use the personal calendar feature even though it isn't
    // turned on.
    $display .= $LANG30[37];
    $display .= COM_siteFooter();
    echo $display;
    exit;
}

// after this point, we can safely assume that if $mode == 'personal',
// the current user is actually allowed to use this personal calendar

$msg = 0;
if (isset ($_REQUEST['msg'])) {
    $msg = COM_applyFilter ($_REQUEST['msg'], true);
}
if ($msg > 0) {
    $display .= COM_showMessage ($msg);
}

$view = '';
if (isset ($_REQUEST['view'])) {
    $view = COM_applyFilter ($_REQUEST['view']);
}

if (!in_array ($view, array ('month', 'week', 'day'))) {
    $view = '';
}

$year = 0;
if (isset ($_REQUEST['year'])) {
    $year = COM_applyFilter ($_REQUEST['year'], true);
}
$month = 0;
if (isset ($_REQUEST['month'])) {
    $month = COM_applyFilter ($_REQUEST['month'], true);
}
$day = 0;
if (isset ($_REQUEST['day'])) {
    $day = COM_applyFilter ($_REQUEST['day'], true);
}

// Create new calendar object
$cal = new Calendar();

if ($view == 'week' AND (empty($month) AND empty($day) AND empty($year))) {
    list($month, $day, $year) = getPriorSunday(date('m', time()), date('j', time()), date('Y', time()));
} else {
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
    $currentday =  date('j', time());
    if (empty($day)) {
        $day = $currentday;
    }
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

setCalendarLanguage ($cal);

// Build calendar matrix
$cal->setCalendarMatrix ($month, $year);

switch ($view) {
case 'day':
    $cal_templates = new Template($_CONF['path_layout'] . 'calendar/dayview');
    $cal_templates->set_file(array('column'=>'column.thtml','event'=>'singleevent.thtml','dayview'=>'dayview.thtml','quickadd'=>'quickaddform.thtml'));
    $cal_templates->set_var('site_url', $_CONF['site_url']);
    $cal_templates->set_var ('layout_url', $_CONF['layout_url']);
    $cal_templates->set_var('mode', $mode);
    $cal_templates->set_var('lang_day', $LANG30[39]);
    $cal_templates->set_var('lang_week', $LANG30[40]);
    $cal_templates->set_var('lang_month', $LANG30[41]);
    list($wmonth, $wday, $wyear) = getPriorSunday($month, $day, $year);
    $cal_templates->set_var('wmonth', $wmonth);
    $cal_templates->set_var('wday', $wday);
    $cal_templates->set_var('wyear', $wyear);
    $cal_templates->set_var('month',$month);
    $cal_templates->set_var('day', $day);
    $cal_templates->set_var('year',$year);
    $prevstamp = mktime(0, 0, 0,$month, $day - 1, $year);
    $nextstamp = mktime(0, 0, 0,$month, $day + 1, $year);
    $cal_templates->set_var('prevmonth', strftime('%m',$prevstamp));
    $cal_templates->set_var('prevday', strftime('%d',$prevstamp));
    $cal_templates->set_var('prevyear', strftime('%Y',$prevstamp));
    $cal_templates->set_var('nextmonth', strftime('%m',$nextstamp));
    $cal_templates->set_var('nextday', strftime('%d',$nextstamp));
    $cal_templates->set_var('nextyear', strftime('%Y',$nextstamp));

    $cal_templates->set_var('currentday', strftime('%A, %x',mktime(0, 0, 0,$month, $day, $year)));
    if ($mode == 'personal') {
        $cal_templates->set_var('calendar_title', $LANG30[28] . ' ' . $_USER['username']);
        $cal_templates->set_var('calendar_toggle', '[<a href="' . $_CONF['site_url'] . "/calendar.php?view=day&amp;month=$month&amp;day=$day&amp;year=$year\">" . $LANG30[11] . '</a>]');
    } else {
        $cal_templates->set_var('calendar_title', $_CONF['site_name'] . ' ' . $LANG30[29]);
        if (!empty($_USER['uid']) AND $_CONF['personalcalendars'] == 1) {
            $cal_templates->set_var('calendar_toggle', '[<a href="' . $_CONF['site_url'] . "/calendar.php?mode=personal&amp;view=day&amp;month=$month&amp;day=$day&amp;year=$year\">" . $LANG30[12] . '</a>]');
        } else {
            $cal_templates->set_var('calendar_toggle', '');
        }
    }
    $thedate = COM_getUserDateTimeFormat(mktime(0,0,0,$month,$day,$year));
    $cal_templates->set_var('week_num',strftime('%V',$thedate[1]));
    if ($mode == 'personal') {
        $calsql = "SELECT * FROM {$_TABLES['personal_events']} WHERE (uid = {$_USER['uid']}) AND ((allday=1 AND datestart = \"$year-$month-$day\") OR (datestart >= \"$year-$month-$day 00:00:00\" AND datestart <= \"$year-$month-$day 23:59:59\") OR (dateend >= \"$year-$month-$day 00:00:00\" AND dateend <= \"$year-$month-$day 23:59:59\") OR (\"$year-$month-$day\" between datestart and dateend)) ORDER BY datestart,timestart";
    } else {
        $calsql = "SELECT * FROM {$_TABLES['events']} WHERE ((allday=1 AND datestart = \"$year-$month-$day\") OR (datestart >= \"$year-$month-$day 00:00:00\" AND datestart <= \"$year-$month-$day 23:59:59\") OR (dateend >= \"$year-$month-$day 00:00:00\" AND dateend <= \"$year-$month-$day 23:59:59\") OR (\"$year-$month-$day\" between datestart and dateend))" . COM_getPermSql ('AND') . " ORDER BY datestart,timestart";
    }
    $result = DB_query($calsql);
    $nrows = DB_numRows($result);
    list($hourcols, $thedata, $max, $alldaydata) = getDayViewData($result);

    // Get all day events
    if (count ($alldaydata) > 0) {
        for ($i = 1; $i <= count ($alldaydata); $i++) {
            $A = current($alldaydata);
            $cal_templates->set_var ('delete_imagelink',
                                     getDeleteImageLink ($mode, $A));
            $cal_templates->set_var('event_time', $LANG30[26]);
            $cal_templates->set_var('eid', $A['eid']);
            $cal_templates->set_var('event_title',stripslashes($A['title']));
            if ($i < count($alldaydata)) {
                $cal_templates->set_var('br', '<br>');
            } else {
                $cal_templates->set_var('br', '');
            }
            $cal_templates->parse('allday_events','event', true); 
            next($alldaydata);
        }
    } else {
        $cal_templates->set_var('allday_events','&nbsp;');
    }

    //$cal_templates->set_var('first_colspan', $maxcols);
    //$cal_templates->set_var('title_colspan', $maxcols + 1);
    for ($i = 0; $i <= 23; $i++) {
        $numevents = $hourcols[$i];
        if ($numevents > 0) {
            // $colsleft = $maxcols;
            $cal_templates->set_var ('layout_url', $_CONF['layout_url']);
            for ($j = 1; $j <= $numevents; $j++) {
                $A = current ($thedata);
                $cal_templates->set_var ('event_time',
                    strftime ($_CONF['timeonly'], strtotime ($A['datestart']
                            . ' ' . $A['timestart'])) . '-'
                    . strftime ($_CONF['timeonly'], strtotime ($A['dateend']
                            . ' ' . $A['timeend'])));
                $cal_templates->set_var ('delete_imagelink',
                                         getDeleteImageLink ($mode, $A));
                $cal_templates->set_var('eid', $A['eid']);
                $cal_templates->set_var('event_title', stripslashes($A['title']));
                if ($j < $numevents) {
                    $cal_templates->set_var('br', '<br>');
                } else {
                    $cal_templates->set_var('br', '');
                }
                $cal_templates->parse ('event_entry', 'event',
                                       ($j == 1) ? false : true);
                // $colsleft = $colsleft - 1;
                next($thedata);
            }
        } else {
            $cal_templates->set_var('event_entry','&nbsp;');
        }
        $cal_templates->set_var ($i . '_hour',
                strftime ($_CONF['timeonly'], mktime ($i, 0)));
        $cal_templates->parse ($i . '_cols', 'column', true);
    }

    if ($mode == 'personal') {
        $cal_templates = getQuickAdd($cal_templates, $month, $day, $year);
    } else {
        $cal_templates->set_var('quickadd_form','');
    }
    $display .= $cal_templates->parse('output', 'dayview');
    $display .= COM_siteFooter();
    break;

case 'week':
    $cal_templates = new Template($_CONF['path_layout'] . 'calendar');
    $cal_templates->set_file(array('week'=>'weekview/weekview.thtml','events'=>'weekview/events.thtml','quickadd'=>'dayview/quickaddform.thtml'));
    $cal_templates->set_var('site_url', $_CONF['site_url']);
    $cal_templates->set_var ('layout_url', $_CONF['layout_url']);
    $cal_templates->set_var('mode', $mode);
    $cal_templates->set_var('lang_week', $LANG30[27]);
    if ($mode == 'personal') {
        $cal_templates->set_var('calendar_title', $LANG30[28] . ' ' . $_USER['username']);
        $cal_templates->set_var('calendar_toggle', '[<a href="' . $_CONF['site_url'] . "/calendar.php?view=week&amp;month=$month&amp;day=$day&amp;year=$year\">" . $LANG30[11] . '</a>]');
    } else {
        $cal_templates->set_var('calendar_title', $_CONF['site_name'] . ' ' . $LANG30[29]);
        if (!empty($_USER['uid']) AND $_CONF['personalcalendars'] == 1) {
            $cal_templates->set_var('calendar_toggle', '[<a href="' . $_CONF['site_url'] . "/calendar.php?mode=personal&amp;view=week&amp;month=$month&amp;day=$day&amp;year=$year\">" . $LANG30[12] . '</a>]');
        } else {
            $cal_templates->set_var('calendar_toggle', '');
        }
    }
    if ($mode == 'personal') {
        $cal_templates = getQuickAdd($cal_templates, $month, $day, $year);
    } else {
        $cal_templates->set_var('quickadd_form','');
    }
    // Get data for previous week
    $prevstamp = mktime(0,0,0,$month,$day-7,$year);
    $nextstamp = mktime(0,0,0,$month,$day+7,$year);
    $cal_templates->set_var('prevmonth',strftime('%m',$prevstamp));
    $cal_templates->set_var('prevday',date('j',$prevstamp));
    $cal_templates->set_var('prevyear',strftime('%Y',$prevstamp));
    $cal_templates->set_var('nextmonth',strftime('%m',$nextstamp));
    $cal_templates->set_var('nextday',date('j',$nextstamp));
    $cal_templates->set_var('nextyear',strftime('%Y',$nextstamp));
    $cal_templates->set_var ('lang_day', $LANG30[39]);
    $cal_templates->set_var ('lang_week', $LANG30[40]);
    $cal_templates->set_var ('lang_month', $LANG30[41]);
    if ($_CONF['week_start'] == 'Mon') {
        $time_day1 = mktime (0, 0, 0, $month, $day + 1, $year);
        $time_day7 = mktime (0, 0, 0, $month, $day + 7, $year);
        $start_mname = strftime ('%B', $time_day1);
        $eday = strftime ('%e', $time_day7);
        $end_mname = strftime ('%B', $time_day7);
        $end_ynum = strftime ('%Y', $time_day7);
        $date_range = $start_mname . ' ' . strftime ('%e', $time_day1);
    } else {
        $start_mname = strftime ('%B', mktime (0, 0, 0, $month, $day, $year));
        $time_day6 = mktime (0, 0, 0, $month, $day + 6, $year);
        $eday = strftime ('%e', $time_day6);
        $end_mname = strftime ('%B', $time_day6);
        $end_ynum = strftime ('%Y', $time_day6);
        $date_range = $start_mname . ' ' . $day;
    }
    if ($year <> $end_ynum) {
        $date_range .= ', ' . $year . ' - ';
    } else {
        $date_range .= ' - ';
    }
    if ($start_mname <> $end_mname) {
        $date_range .= $end_mname . ' ' . $eday . ', ' . $end_ynum;
    } else {
        $date_range .= $eday . ', ' . $end_ynum;
    }
    $cal_templates->set_var('date_range', $date_range);
    if ($_CONF['week_start'] == 'Mon') {
        $thedate = COM_getUserDateTimeFormat (mktime (0, 0, 0, $month, $day + 1,$year));
    } else {
        $thedate = COM_getUserDateTimeFormat (mktime (0, 0, 0, $month, $day, $year));
    }
    $cal_templates->set_var('week_num',$thedate[1]);
    for ($i = 1; $i <= 7; $i++) {
        if ($_CONF['week_start'] == 'Mon') {
            $dayname = (date ('w', $thedate[1]) == 0)
                     ? $cal->getDayName (7)
                     : $cal->getDayName (date ('w', $thedate[1]));
        } else {
            $dayname = $cal->getDayName (date ('w', $thedate[1]) + 1);
        }
        $monthnum = date('m', $thedate[1]);
        $daynum = date('d', $thedate[1]);
        $yearnum = date('Y', $thedate[1]);
        if ($yearnum . '-' . $monthnum . '-' . $daynum == date('Y-m-d',time())) {
            $cal_templates->set_var('class'.$i,'weekview-curday');
        } else {
            $cal_templates->set_var('class'.$i,'weekview-offday');
        }
        $monthname = $cal->getMonthName($monthnum);
        $cal_templates->set_var ('day' . $i, $dayname . ', <a href="'
            . $_CONF['site_url'] . '/calendar.php?' . addMode ($mode)
            . 'view=day&amp;day=' . $daynum . '&amp;month=' . $monthnum
            . '&amp;year=' . $yearnum . '">' . strftime ('%x', $thedate[1])
            . '</a>');
        $cal_templates->set_var ('langlink_addevent' . $i, '<a href="'
            . $_CONF['site_url'] . '/submit.php?type=event&amp;'
            . addMode ($mode) . 'day=' . $daynum . '&amp;month=' . $monthnum
            . '&amp;year=' . $yearnum . '">' . $LANG30[8] . '</a>');
        if ($mode == 'personal') {
            $calsql = "SELECT * FROM {$_TABLES['personal_events']} WHERE (uid = {$_USER['uid']}) AND ((allday=1 AND datestart = \"$yearnum-$monthnum-$daynum\") OR (datestart >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND datestart <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (dateend >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND dateend <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (\"$yearnum-$monthnum-$daynum\" between datestart and dateend)) ORDER BY datestart,timestart";
        } else {
            $calsql = "SELECT * FROM {$_TABLES['events']} WHERE ((allday=1 AND datestart = \"$yearnum-$monthnum-$daynum\") OR (datestart >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND datestart <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (dateend >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND dateend <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (\"$yearnum-$monthnum-$daynum\" between datestart and dateend))" . COM_getPermSql ('AND') . " ORDER BY datestart,timestart";
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
            $cal_templates->set_var ('event_title_and_link', '<a href="'
                . $_CONF['site_url'] . '/calendar_event.php?' . addMode ($mode)
                . 'eid=' . $A['eid'] . '">' . stripslashes($A['title'])
                . '</a>');
            // Provide delete event link if user has access
            $cal_templates->set_var ('delete_imagelink',
                                     getDeleteImageLink ($mode, $A));
            $cal_templates->parse ('events_day' . $i, 'events', true);
        }
        if ($nrows == 0) {
            $cal_templates->set_var('event_starttime','&nbsp;');
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

default: // month view
// Load templates
$cal_templates = new Template($_CONF['path_layout'] . 'calendar');
$cal_templates->set_file (array (
        'calendar'    => 'calendar.thtml',
        'week'        => 'calendarweek.thtml',
        'day'         => 'calendarday.thtml',
        'event'       => 'calendarevent.thtml',
        'mastercal'   => 'mastercalendaroption.thtml',
        'personalcal' => 'personalcalendaroption.thtml',
        'addevent'    => 'addeventoption.thtml'
        ));

$cal_templates->set_var ('site_url', $_CONF['site_url']);
$cal_templates->set_var ('layout_url', $_CONF['layout_url']);
$cal_templates->set_var ('mode', $mode);
if ($mode == 'personal') {
    $cal_templates->set_var ('start_block', COM_startBlock ($LANG30[12]));
    $cal_templates->set_var ('end_block', COM_endBlock ());
} else {
    $cal_templates->set_var ('start_block', COM_startBlock ($LANG30[11]));
    $cal_templates->set_var ('end_block', COM_endBlock ());
}

$smallcal_prev = getSmallCalendar ($prevmonth, $prevyear, $mode);
$cal_templates->set_var ('previous_months_calendar', $smallcal_prev);
$cal_templates->set_var ('previous_months_cal',
                         '<font size="-2">' . LB . $smallcal_prev . '</font>');

$smallcal_next = getSmallCalendar ($nextmonth, $nextyear, $mode);
$cal_templates->set_var ('next_months_calendar', $smallcal_next);
$cal_templates->set_var ('next_months_cal',
                         '<font size="-2">' . LB . $smallcal_next . '</font>');

$cal_templates->set_var('cal_prevmo_num', $prevmonth);
$cal_templates->set_var('cal_prevyr_num', $prevyear);
$cal_templates->set_var('cal_month_and_year', $cal->getMonthName($month) . ' ' . $year);
$cal_templates->set_var('cal_nextmo_num', $nextmonth);
$cal_templates->set_var('cal_nextyr_num', $nextyear);

if ($_CONF['week_start'] == 'Mon') {
    $cal_templates->set_var('lang_sunday', $LANG30[2]);
    $cal_templates->set_var('lang_monday', $LANG30[3]);
    $cal_templates->set_var('lang_tuesday', $LANG30[4]);
    $cal_templates->set_var('lang_wednesday', $LANG30[5]);
    $cal_templates->set_var('lang_thursday', $LANG30[6]);
    $cal_templates->set_var('lang_friday', $LANG30[7]);
    $cal_templates->set_var('lang_saturday', $LANG30[1]);
} else {
    $cal_templates->set_var('lang_sunday', $LANG30[1]);
    $cal_templates->set_var('lang_monday', $LANG30[2]);
    $cal_templates->set_var('lang_tuesday', $LANG30[3]);
    $cal_templates->set_var('lang_wednesday', $LANG30[4]);
    $cal_templates->set_var('lang_thursday', $LANG30[5]);
    $cal_templates->set_var('lang_friday', $LANG30[6]);
    $cal_templates->set_var('lang_saturday', $LANG30[7]);
}

$cal_templates->set_var('lang_january', $LANG30[13]);
if ($month == 1) $cal_templates->set_var('selected_jan','selected="selected"');
$cal_templates->set_var('lang_february', $LANG30[14]);
if ($month == 2) $cal_templates->set_var('selected_feb','selected="selected"');
$cal_templates->set_var('lang_march', $LANG30[15]);
if ($month == 3) $cal_templates->set_var('selected_mar','selected="selected"');
$cal_templates->set_var('lang_april', $LANG30[16]);
if ($month == 4) $cal_templates->set_var('selected_apr','selected="selected"');
$cal_templates->set_var('lang_may', $LANG30[17]);
if ($month == 5) $cal_templates->set_var('selected_may','selected="selected"');
$cal_templates->set_var('lang_june', $LANG30[18]);
if ($month == 6) $cal_templates->set_var('selected_jun','selected="selected"');
$cal_templates->set_var('lang_july', $LANG30[19]);
if ($month == 7) $cal_templates->set_var('selected_jul','selected="selected"');
$cal_templates->set_var('lang_august', $LANG30[20]);
if ($month == 8) $cal_templates->set_var('selected_aug','selected="selected"');
$cal_templates->set_var('lang_september', $LANG30[21]);
if ($month == 9) $cal_templates->set_var('selected_sep','selected="selected"');
$cal_templates->set_var('lang_october', $LANG30[22]);
if ($month == 10) $cal_templates->set_var('selected_oct','selected="selected"');
$cal_templates->set_var('lang_november', $LANG30[23]);
if ($month == 11) $cal_templates->set_var('selected_nov','selected="selected"');
$cal_templates->set_var('lang_december', $LANG30[24]);
if ($month == 12) $cal_templates->set_var('selected_dec','selected="selected"');

$cal_templates->set_var('lang_day', $LANG30[39]);
$cal_templates->set_var('lang_week', $LANG30[40]);
$cal_templates->set_var('lang_month', $LANG30[41]);

if ($mode == 'personal') {
    $cal_templates->set_var ('calendar_title',
                             $LANG30[28] . ' ' . $_USER['username']);
} else {
    $cal_templates->set_var ('calendar_title',
                             $_CONF['site_name'] . ' ' . $LANG30[29]);
}

$yroptions = '';
for ($y = $currentyear - 5; $y <= $currentyear + 5; $y++) {
    $yroptions .= '<option value="' . $y . '"';
    if ($y == $year) {
        $yroptions .= ' selected="selected"';
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
                $cal_templates->set_var('cal_day_style', 'cal-oldday'); 
            } else {
                if ($currentyear == $year && $currentmonth == $month && $currentday == $curday->daynumber) {
                    $cal_templates->set_var('cal_day_style','cal-today');
                } else {
                    $cal_templates->set_var('cal_day_style', 'cal-futureday');
                }
            }

            if (strlen($curday->daynumber) == 1) {
                $curday->daynumber = '0' . $curday->daynumber;
            }

            $cal_templates->set_var ('cal_day_anchortags', '<a href="'
                . $_CONF['site_url'] . '/calendar.php?view=day&amp;'
                . addMode ($mode) . 'day=' . $curday->daynumber. '&amp;month='
                . $month . '&amp;year=' . $year . '" class="cal-date">'
                . $curday->daynumber. '</a><hr>');

            if ($mode == 'personal') {
                if (strlen($month) == 1) {
                    $month = '0' . $month;
                }
                $calsql = "SELECT * FROM {$_TABLES['personal_events']} WHERE (uid = {$_USER['uid']}) AND ((datestart >= \"$year-$month-$curday->daynumber 00:00:00\" AND datestart <= \"$year-$month-$curday->daynumber 23:59:59\") OR (dateend >= \"$year-$month-$curday->daynumber 00:00:00\" AND dateend <= \"$year-$month-$curday->daynumber 23:59:59\") OR (\"$year-$month-$curday->daynumber\" between datestart and dateend)) ORDER BY datestart,timestart";
            } else {
                if (strlen($month) == 1) {
                    $month = '0' . $month;
                }
                $calsql = "SELECT * FROM {$_TABLES['events']} WHERE ((datestart >= \"$year-$month-$curday->daynumber 00:00:00\" AND datestart <= \"$year-$month-$curday->daynumber 23:59:59\") OR (dateend >= \"$year-$month-$curday->daynumber 00:00:00\" AND dateend <= \"$year-$month-$curday->daynumber 23:59:59\") OR (\"$year-$month-$curday->daynumber\" between datestart and dateend))" . COM_getPermSql ('AND') . " ORDER BY datestart,timestart";
            }

            $query2 = DB_query($calsql);
            $q2_numrows = DB_numRows($query2);

            if ($q2_numrows > 0) {
                $entries = '';
                for ($z = 1; $z <= $q2_numrows; $z++) {
                    $results = DB_fetchArray ($query2);
                    if ($results['title']) {
                        $cal_templates->set_var ('cal_day_entries', '');
                        $entries .= '<a href="' . $_CONF['site_url']
                            . '/calendar_event.php?' . addMode ($mode)
                            . 'eid=' . $results['eid'] . '" class="cal-event">'
                            . stripslashes ($results['title']) . '</a><hr>';
                    }
                }
                for ($z = $z; $z <= 4; $z++) {
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
                    $cal_templates->set_var('cal_day_style','cal-nullday');
                    $cal_templates->set_var('cal_day_anchortags', '');
                    $cal_templates->set_var('cal_day_entries','&nbsp;');
                    if ($k < 7) $cal_templates->parse('cal_days', 'day', true);
                }
                // for looping to stop...we are done now
                $i = 7;
                $j = 8;
            } else {
                // Print empty box for any days in the first week that occur
                // before the first day
                $cal_templates->set_var('cal_day_style','cal-nullday');
                $cal_templates->set_var('cal_day_anchortags', '');
                $cal_templates->set_var('cal_day_entries','&nbsp;');
            }
        }
        $cal_templates->parse('cal_days','day',true);
    }
    list($wmonth, $wday, $wyear) = getPriorSunday($month, $wday, $year);
    $cal_templates->set_var('wmonth', $wmonth);
    $cal_templates->set_var('wday', $wday);
    $cal_templates->set_var('wyear', $wyear);
    $cal_templates->parse('cal_week', 'week',true);
    $cal_templates->set_var('cal_days','');

    // check if we need to render the following week at all
    if ($i < 6) {
        $data = $cal->getDayData ($i + 1, 1);
        if (empty ($data)) {
            break;     
        }
    }
}

if ($mode == 'personal') {
    $cal_templates->set_var('lang_mastercal', $LANG30[25] . $LANG30[11]);
    $cal_templates->parse('master_calendar_option','mastercal',true); 
} else {
    if (isset ($_USER['uid']) && ($_USER['uid'] > 1) &&
            ($_CONF['personalcalendars'] == 1)) {
        $cal_templates->set_var('lang_mycalendar', $LANG30[12]);
        $cal_templates->parse('personal_calendar_option','personalcal',true); 
    } else {
        $cal_templates->set_var('personal_calendar_option','&nbsp;');
    }
}
$cal_templates->set_var('lang_addevent', $LANG30[8]);
$cal_templates->set_var('lang_cal_curmo', $LANG30[12 + $currentmonth]);
$cal_templates->set_var('cal_curmo_num', $currentmonth);
$cal_templates->set_var('cal_curyr_num', $currentyear);
$cal_templates->set_var('lang_cal_displaymo', $LANG30[12 + $month]);
$cal_templates->set_var('cal_displaymo_num', $month);
$cal_templates->set_var('cal_displayyr_num', $year);
$cal_templates->parse('add_event_option','addevent',true);

$cal_templates->parse('output','calendar');
$display .= $cal_templates->finish($cal_templates->get_var('output'));

$display .= COM_siteFooter();
break;

} // end switch	

echo $display;

?>
