<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Calendar Plugin 1.1                                                       |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Geeklog calendar plugin                                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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

require_once '../lib-common.php';

if (!in_array('calendar', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

require_once $_CONF['path_system'] . 'classes/calendar.class.php';

$display = '';

if (COM_isAnonUser() &&
    (($_CONF['loginrequired'] == 1) || ($_CA_CONF['calendarloginrequired'] == 1))) {
    $display .= COM_siteHeader('menu', $LANG_CAL_1[41]);
    $display .= SEC_loginRequiredForm();
    $display .= COM_siteFooter();
    COM_output($display);
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
    global $_CONF, $LANG_WEEK, $LANG_MONTH;

    $lang_days = array ('sunday'    => $LANG_WEEK[1],
                        'monday'    => $LANG_WEEK[2],
                        'tuesday'   => $LANG_WEEK[3],
                        'wednesday' => $LANG_WEEK[4],
                        'thursday'  => $LANG_WEEK[5],
                        'friday'    => $LANG_WEEK[6],
                        'saturday'  => $LANG_WEEK[7]);

    $lang_months = array ('january'   => $LANG_MONTH[1],
                          'february'  => $LANG_MONTH[2],
                          'march'     => $LANG_MONTH[3],
                          'april'     => $LANG_MONTH[4],
                          'may'       => $LANG_MONTH[5],
                          'june'      => $LANG_MONTH[6],
                          'july'      => $LANG_MONTH[7],
                          'august'    => $LANG_MONTH[8],
                          'september' => $LANG_MONTH[9],
                          'october'   => $LANG_MONTH[10],
                          'november'  => $LANG_MONTH[11],
                          'december'  => $LANG_MONTH[12]);

    $aCalendar->setLanguage ($lang_days, $lang_months, $_CONF['week_start']);
}

/**
* Returns an abbreviated day's name
*
* @param    int     $day    1 = Sunday, 2 = Monday, ...
* @return   string          abbreviated day's name (2 characters)
*
*
*/
function shortDaysName ($day)
{
    global $LANG_WEEK;

    return MBYTE_substr ($LANG_WEEK[$day], 0, 2);
}

function makeDaysHeadline ()
{
    global $_CONF;

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
* @param    string  $token  security token
* @return   string          link or empty string
*
*/
function getDeleteImageLink($mode, $A, $token)
{
    global $_CONF, $LANG_ADMIN, $LANG_CAL_2, $_IMAGE_TYPE;

    $retval = '';
    $img = '<img src="' . $_CONF['site_url']
        . '/calendar/images/delete_event.' . $_IMAGE_TYPE
        . '" alt="' . $LANG_CAL_2[30] . '" title="'
        . $LANG_CAL_2[30] . '"' . XHTML . '>';

    if ($mode == 'personal') {
        if (SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'],
                $A['perm_group'], $A['perm_members'], $A['perm_anon']) > 0) {
            $retval = COM_createLink($img, $_CONF['site_url']
                    . '/calendar/event.php?action=deleteevent&amp;eid='
                    . $A['eid'] . '&amp;' . CSRF_TOKEN . '=' . $token);
        }
    } else if (SEC_hasRights('calendar.edit')) {
        if (SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'],
                $A['perm_group'], $A['perm_members'], $A['perm_anon']) == 3) {
            $retval = COM_createLink($img, $_CONF['site_admin_url']
                    . '/plugins/calendar/index.php?mode='
                    . $LANG_ADMIN['delete'] . '&amp;eid=' . $A['eid'] . '&amp;'
                    . CSRF_TOKEN . '=' . $token);
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
    global $_CONF;

    $retval = '';
    $mycal = new Calendar ();
    setCalendarLanguage ($mycal);
    $mycal->setCalendarMatrix ($m, $y);

    if (!empty ($mode)) {
        $mode = '&amp;mode=' . $mode;
    }

    $retval .= '<table class="smallcal">' . LB
            . '<tr class="smallcal-headline"><td align="center" colspan="7">'
            . COM_createLink($mycal->getMonthName ($m), $_CONF['site_url']
                . '/calendar/index.php?month=' . $m . '&amp;year=' . $y . $mode)
            . '</td></tr>' . makeDaysHeadline () . LB;

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
function getQuickAdd($tpl, $month, $day, $year, $token)
{
    global $_CA_CONF, $LANG_CAL_2;

    $tpl->set_var('month_options', COM_getMonthFormOptions($month));
    $tpl->set_var('day_options', COM_getDayFormOptions($day));
    $tpl->set_var('year_options', COM_getYearFormOptions($year));

    $cur_hour = date('H', time ());
    if ($cur_hour >= 12) {
        $ampm = 'pm';
    } else {
        $ampm = 'am';
    }
    $cur_hour_24 = $cur_hour % 24;
    if ($cur_hour > 12) {
        $cur_hour = $cur_hour - 12;
    } else if ($cur_hour == 0) {
        $cur_hour = 12;
    }
    if (isset($_CA_CONF['hour_mode']) && ($_CA_CONF['hour_mode'] == 24)) {
        $tpl->set_var('hour_mode', 24);
        $tpl->set_var('hour_options',
                      COM_getHourFormOptions($cur_hour_24, 24));
    } else {
        $tpl->set_var('hour_mode', 12);
        $tpl->set_var('hour_options', COM_getHourFormOptions($cur_hour));
    }
    $tpl->set_var('startampm_selection',
                  COM_getAmPmFormSelection('start_ampm', $ampm));
    $cur_min = intval(date('i') / 15) * 15;
    $tpl->set_var('minute_options', COM_getMinuteFormOptions($cur_min, 15));

    $tpl->set_var('lang_event', $LANG_CAL_2[32]);
    $tpl->set_var('lang_date', $LANG_CAL_2[33]);
    $tpl->set_var('lang_time', $LANG_CAL_2[34]);
    $tpl->set_var('lang_add', $LANG_CAL_2[31]);
    $tpl->set_var('lang_quickadd', $LANG_CAL_2[35]);
    $tpl->set_var('lang_submit', $LANG_CAL_2[36]);
    $tpl->set_var('gltoken_name', CSRF_TOKEN);
    $tpl->set_var('gltoken', $token);
    $tpl->parse('quickadd_form', 'quickadd', true);

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

// MAIN
$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}

if ($mode != 'personal' && $mode != 'quickadd') {
    $mode = '';
}

if ($mode == 'personal') {
    $display .= COM_siteHeader ('menu', $LANG_CAL_1[42]);
} else {
    $display .= COM_siteHeader ('menu', $LANG_CAL_1[41]);
}

// Set mode back to master if user refreshes screen after their session expires
if (($mode == 'personal') && COM_isAnonUser()) {
    $mode = '';
}

if ($mode == 'personal' AND $_CA_CONF['personalcalendars'] == 0) {
    // User is trying to use the personal calendar feature even though it isn't
    // turned on.
    $display .= $LANG_CAL_2[37];
    $display .= COM_siteFooter();
    COM_output($display);
    exit;
}

// after this point, we can safely assume that if $mode == 'personal',
// the current user is actually allowed to use this personal calendar

$msg = 0;
if (isset ($_REQUEST['msg'])) {
    $msg = COM_applyFilter ($_REQUEST['msg'], true);
}
if ($msg > 0) {
    $display .= COM_showMessage ($msg, 'calendar');
}

$view = '';
if (isset ($_REQUEST['view'])) {
    $view = COM_applyFilter ($_REQUEST['view']);
}

if (!in_array ($view, array ('month', 'week', 'day', 'addentry', 'savepersonal'))) {
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

$token = '';
if ((($view == 'day') || ($view == 'week')) &&
        (($mode == 'personal') || SEC_hasRights('calendar.edit'))) {
    $token = SEC_createToken();
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
    $cal_templates = COM_newTemplate($_CONF['path'] . 'plugins/calendar/templates/dayview');
    $cal_templates->set_file(array('column'=>'column.thtml',
                                   'event'=>'singleevent.thtml',
                                   'dayview'=>'dayview.thtml',
                                   'quickadd'=>'quickaddform.thtml'));
    $cal_templates->set_var('mode', $mode);
    $cal_templates->set_var('lang_day', $LANG_CAL_2[39]);
    $cal_templates->set_var('lang_week', $LANG_CAL_2[40]);
    $cal_templates->set_var('lang_month', $LANG_CAL_2[41]);
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
        $cal_templates->set_var('calendar_title', '[' . $LANG_CAL_2[28] . ' ' . COM_getDisplayName());
        $cal_templates->set_var('calendar_toggle', '|&nbsp;'
            . COM_createLink($LANG_CAL_2[11], $_CONF['site_url']
                . "/calendar/index.php?view=day&amp;month=$month&amp;day=$day&amp;year=$year") . ']'
        );
    } else {
        $cal_templates->set_var('calendar_title', '[' . $_CONF['site_name'] . ' ' . $LANG_CAL_2[29]);
        if (!COM_isAnonUser() AND $_CA_CONF['personalcalendars'] == 1) {
            $cal_templates->set_var('calendar_toggle', '|&nbsp;'
                . COM_createLink($LANG_CAL_2[12], $_CONF['site_url']
                    . "/calendar/index.php?mode=personal&amp;view=day&amp;month=$month&amp;day=$day&amp;year=$year") . ']'
            );
        } else {
            $cal_templates->set_var('calendar_toggle', ']');
        }
    }
    $thedate = COM_getUserDateTimeFormat(mktime(0,0,0,$month,$day,$year));
    $cal_templates->set_var('week_num',strftime('%V',$thedate[1]));
    if ($mode == 'personal') {
        $calsql = "SELECT eid,title,datestart,dateend,timestart,timeend,allday,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['personal_events']} "
                . "WHERE (uid = {$_USER['uid']}) "
                . "AND ((allday=1 AND datestart = '$year-$month-$day') "
                . "OR (datestart >= '$year-$month-$day 00:00:00' AND datestart <= '$year-$month-$day 23:59:59') "
                . "OR (dateend >= '$year-$month-$day 00:00:00' AND dateend <= '$year-$month-$day 23:59:59') "
                . "OR ('$year-$month-$day' BETWEEN datestart AND dateend)) "
                . "ORDER BY datestart,timestart";
    } else {
        $calsql = "SELECT eid,title,datestart,dateend,timestart,timeend,allday,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['events']} WHERE ((allday=1 "
                . "AND datestart = '$year-$month-$day') "
                . "OR (datestart >= '$year-$month-$day 00:00:00' AND datestart <= '$year-$month-$day 23:59:59') "
                . "OR (dateend >= '$year-$month-$day 00:00:00' AND dateend <= '$year-$month-$day 23:59:59') "
                . "OR ('$year-$month-$day' BETWEEN datestart AND dateend))" . COM_getPermSql ('AND')
                . " ORDER BY datestart,timestart";
    }
    $result = DB_query($calsql);
    $nrows = DB_numRows($result);
    list($hourcols, $thedata, $max, $alldaydata) = getDayViewData($result);

    // Get all day events
    $alldaycount = count($alldaydata);
    if ($alldaycount > 0) {
        for ($i = 1; $i <= $alldaycount; $i++) {
            $A = current($alldaydata);
            $cal_templates->set_var('delete_imagelink',
                                    getDeleteImageLink($mode, $A, $token));
            $cal_templates->set_var('event_time', $LANG_CAL_2[26]);
            $cal_templates->set_var('eid', $A['eid']);
            $cal_templates->set_var('event_title', stripslashes($A['title']));
            if ($i < $alldaycount) {
                $cal_templates->set_var('br', '<br' . XHTML . '>');
            } else {
                $cal_templates->set_var('br', '');
            }
            $cal_templates->parse('allday_events', 'event', true);
            next($alldaydata);
        }
    } else {
        $cal_templates->set_var('allday_events', '&nbsp;');
    }

    //$cal_templates->set_var('first_colspan', $maxcols);
    //$cal_templates->set_var('title_colspan', $maxcols + 1);
    for ($i = 0; $i <= 23; $i++) {
        $numevents = $hourcols[$i];
        if ($numevents > 0) {
            // $colsleft = $maxcols;
            for ($j = 1; $j <= $numevents; $j++) {
                $A = current ($thedata);
                $cal_templates->set_var ('event_time',
                    strftime ($_CONF['timeonly'], strtotime ($A['datestart']
                            . ' ' . $A['timestart'])) . '-'
                    . strftime ($_CONF['timeonly'], strtotime ($A['dateend']
                            . ' ' . $A['timeend'])));
                $cal_templates->set_var('delete_imagelink',
                                        getDeleteImageLink($mode, $A, $token));
                $cal_templates->set_var('eid', $A['eid']);
                $cal_templates->set_var('event_title', stripslashes($A['title']));
                if ($j < $numevents) {
                    $cal_templates->set_var('br', '<br' . XHTML . '>');
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
        $cal_templates = getQuickAdd($cal_templates, $month, $day, $year, $token);
    } else {
        $cal_templates->set_var('quickadd_form','');
    }
    $display .= $cal_templates->parse('output', 'dayview');
    $display .= COM_siteFooter();
    break;

case 'week':
    $cal_templates = COM_newTemplate($_CONF['path'] . 'plugins/calendar/templates');
    $cal_templates->set_file(array('week'=>'weekview/weekview.thtml',
                                   'events'=>'weekview/events.thtml',
                                   'quickadd'=>'dayview/quickaddform.thtml'));
    $cal_templates->set_var('mode', $mode);
    $cal_templates->set_var('lang_week', $LANG_CAL_2[27]);
    if ($mode == 'personal') {
        $cal_templates->set_var('calendar_title', '[' . $LANG_CAL_2[28] . ' ' . COM_getDisplayName());
        $cal_templates->set_var('calendar_toggle', '|&nbsp;'
            . COM_createLink($LANG_CAL_2[11], $_CONF['site_url']
                . "/calendar/index.php?view=week&amp;month=$month&amp;day=$day&amp;year=$year") . ']'
        );
    } else {
        $cal_templates->set_var('calendar_title', '[' . $_CONF['site_name'] . ' ' . $LANG_CAL_2[29]);
        if (!COM_isAnonUser() AND $_CA_CONF['personalcalendars'] == 1) {
            $cal_templates->set_var('calendar_toggle', '|&nbsp;'
                . COM_createLink($LANG_CAL_2[12], $_CONF['site_url']
                    . "/calendar/index.php?mode=personal&amp;view=week&amp;month=$month&amp;day=$day&amp;year=$year") . ']'
            );
        } else {
            $cal_templates->set_var('calendar_toggle', ']');
        }
    }
    if ($mode == 'personal') {
        $cal_templates = getQuickAdd($cal_templates, $month, $day, $year, $token);
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
    $cal_templates->set_var ('lang_day', $LANG_CAL_2[39]);
    $cal_templates->set_var ('lang_week', $LANG_CAL_2[40]);
    $cal_templates->set_var ('lang_month', $LANG_CAL_2[41]);
    if ($_CONF['week_start'] == 'Mon') {
        $time_day1 = mktime (0, 0, 0, $month, $day + 1, $year);
        $time_day7 = mktime (0, 0, 0, $month, $day + 7, $year);
        $start_mname = strftime ('%B', $time_day1);
        // Check for Windows to find and replace the %e 
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $eday = strftime ('%#d', $time_day7);
        } else {          
            $eday = strftime ('%e', $time_day7);
        }
        $end_mname = strftime ('%B', $time_day7);
        $end_ynum = strftime ('%Y', $time_day7);
        $date_range = $start_mname . ' ' . strftime ('%e', $time_day1);
    } else {
        $start_mname = strftime ('%B', mktime (0, 0, 0, $month, $day, $year));
        $time_day6 = mktime (0, 0, 0, $month, $day + 6, $year);
        // Check for Windows to find and replace the %e 
        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $eday = strftime ('%#d', $time_day6);
        } else {        
            $eday = strftime ('%e', $time_day6);
        }
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
        $cal_templates->set_var ('day' . $i, $dayname . ', '
            . COM_createLink( strftime ('%x', $thedate[1]),
            $_CONF['site_url'] . '/calendar/index.php?' . addMode ($mode)
            . "view=day&amp;day$daynum&amp;month=$monthnum&amp;year=$yearnum")
        );
        if ($mode == 'personal') {
            $add_str =  $LANG_CAL_2[8];
        } else {
            $add_str =  $LANG_CAL_2[42];
        }

        $cal_templates->set_var ('langlink_addevent' . $i,
            COM_createLink($add_str, $_CONF['site_url'] . '/submit.php?type=calendar&amp;'
            . addMode ($mode) . "day=$daynum&amp;month=$monthnum&amp;year=$yearnum")
        );
        if ($mode == 'personal') {
            $calsql = "SELECT eid,title,datestart,dateend,timestart,timeend,allday,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['personal_events']} WHERE (uid = {$_USER['uid']}) AND ((allday=1 AND datestart = \"$yearnum-$monthnum-$daynum\") OR (datestart >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND datestart <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (dateend >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND dateend <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (\"$yearnum-$monthnum-$daynum\" BETWEEN datestart AND dateend)) ORDER BY datestart,timestart";
        } else {
            $calsql = "SELECT eid,title,datestart,dateend,timestart,timeend,allday,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['events']} WHERE ((allday=1 AND datestart = \"$yearnum-$monthnum-$daynum\") OR (datestart >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND datestart <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (dateend >= \"$yearnum-$monthnum-$daynum 00:00:00\" AND dateend <= \"$yearnum-$monthnum-$daynum 23:59:59\") OR (\"$yearnum-$monthnum-$daynum\" BETWEEN datestart AND dateend))" . COM_getPermSql ('AND') . " ORDER BY datestart,timestart";
        }
        $result = DB_query($calsql);
        $nrows = DB_numRows($result);
        for ($j = 1; $j <= $nrows; $j++) {
            $A = DB_fetchArray($result);
            if ($A['allday'] == 1) {
                $cal_templates->set_var('event_starttime', $LANG_CAL_2[26]);
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
            $cal_templates->set_var ('event_title_and_link',
                COM_createLink(stripslashes($A['title']), $_CONF['site_url']
                    . '/calendar/event.php?' . addMode ($mode)
                . 'eid=' . $A['eid'])
            );
            // Provide delete event link if user has access
            $cal_templates->set_var('delete_imagelink',
                                    getDeleteImageLink($mode, $A, $token));
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

case 'addentry':
     $display .= plugin_submit_calendar($mode);
     $display .= COM_siteFooter();
    break;

case 'savepersonal':
    if (SEC_checkToken()) {
        $display = plugin_savesubmission_calendar($_POST);
    } else {
        $display = COM_refresh($_CONF['site_url'] . '/calendar/index.php');
    }
    break;

default: // month view
// Load templates

$cal_templates = COM_newTemplate($_CONF['path'] . 'plugins/calendar/templates');
$cal_templates->set_file (array (
        'calendar'    => 'calendar.thtml',
        'week'        => 'calendarweek.thtml',
        'day'         => 'calendarday.thtml',
        'event'       => 'calendarevent.thtml',
        'mastercal'   => 'mastercalendaroption.thtml',
        'personalcal' => 'personalcalendaroption.thtml',
        'addevent'    => 'addeventoption.thtml'
        ));

$cal_templates->set_var ('mode', $mode);
if ($mode == 'personal') {
    $cal_templates->set_var ('start_block', COM_startBlock ($LANG_CAL_2[12]));
    $cal_templates->set_var ('end_block', COM_endBlock ());
} else {
    $cal_templates->set_var ('start_block', COM_startBlock ($LANG_CAL_2[11]));
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
    $cal_templates->set_var('lang_sunday', $LANG_WEEK[2]);
    $cal_templates->set_var('lang_monday', $LANG_WEEK[3]);
    $cal_templates->set_var('lang_tuesday', $LANG_WEEK[4]);
    $cal_templates->set_var('lang_wednesday', $LANG_WEEK[5]);
    $cal_templates->set_var('lang_thursday', $LANG_WEEK[6]);
    $cal_templates->set_var('lang_friday', $LANG_WEEK[7]);
    $cal_templates->set_var('lang_saturday', $LANG_WEEK[1]);
} else {
    $cal_templates->set_var('lang_sunday', $LANG_WEEK[1]);
    $cal_templates->set_var('lang_monday', $LANG_WEEK[2]);
    $cal_templates->set_var('lang_tuesday', $LANG_WEEK[3]);
    $cal_templates->set_var('lang_wednesday', $LANG_WEEK[4]);
    $cal_templates->set_var('lang_thursday', $LANG_WEEK[5]);
    $cal_templates->set_var('lang_friday', $LANG_WEEK[6]);
    $cal_templates->set_var('lang_saturday', $LANG_WEEK[7]);
}

$cal_templates->set_var('lang_january', $LANG_MONTH[1]);
if ($month == 1) $cal_templates->set_var('selected_jan','selected="selected"');
$cal_templates->set_var('lang_february', $LANG_MONTH[2]);
if ($month == 2) $cal_templates->set_var('selected_feb','selected="selected"');
$cal_templates->set_var('lang_march', $LANG_MONTH[3]);
if ($month == 3) $cal_templates->set_var('selected_mar','selected="selected"');
$cal_templates->set_var('lang_april', $LANG_MONTH[4]);
if ($month == 4) $cal_templates->set_var('selected_apr','selected="selected"');
$cal_templates->set_var('lang_may', $LANG_MONTH[5]);
if ($month == 5) $cal_templates->set_var('selected_may','selected="selected"');
$cal_templates->set_var('lang_june', $LANG_MONTH[6]);
if ($month == 6) $cal_templates->set_var('selected_jun','selected="selected"');
$cal_templates->set_var('lang_july', $LANG_MONTH[7]);
if ($month == 7) $cal_templates->set_var('selected_jul','selected="selected"');
$cal_templates->set_var('lang_august', $LANG_MONTH[8]);
if ($month == 8) $cal_templates->set_var('selected_aug','selected="selected"');
$cal_templates->set_var('lang_september', $LANG_MONTH[9]);
if ($month == 9) $cal_templates->set_var('selected_sep','selected="selected"');
$cal_templates->set_var('lang_october', $LANG_MONTH[10]);
if ($month == 10) $cal_templates->set_var('selected_oct','selected="selected"');
$cal_templates->set_var('lang_november', $LANG_MONTH[11]);
if ($month == 11) $cal_templates->set_var('selected_nov','selected="selected"');
$cal_templates->set_var('lang_december', $LANG_MONTH[12]);
if ($month == 12) $cal_templates->set_var('selected_dec','selected="selected"');

$cal_templates->set_var('lang_day', $LANG_CAL_2[39]);
$cal_templates->set_var('lang_week', $LANG_CAL_2[40]);
$cal_templates->set_var('lang_month', $LANG_CAL_2[41]);

if ($mode == 'personal') {
    $cal_templates->set_var ('calendar_title',
                             $LANG_CAL_2[28] . ' ' . COM_getDisplayName());
} else {
    $cal_templates->set_var ('calendar_title',
                             $_CONF['site_name'] . ' ' . $LANG_CAL_2[29]);
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

            $cal_templates->set_var ('cal_day_anchortags',
                COM_createLink($curday->daynumber, $_CONF['site_url']
                    . '/calendar/index.php?view=day&amp;' . addMode ($mode)
                    . 'day=' . $curday->daynumber . "&amp;month=$month&amp;year=$year",
                    array('class'=>'cal-date'))
                . '<hr' . XHTML . '>'
            );

            if (strlen($month) == 1) {
                $month = '0' . $month;
            }

            if ($mode == 'personal') {
                $calsql_tbl = $_TABLES['personal_events'];
                $calsql_filt = "AND (uid = {$_USER['uid']})";
            } else {
                $calsql_tbl = $_TABLES['events'];
                $calsql_filt = COM_getPermSql ('AND');
            }

            $calsql = "SELECT eid,title,datestart,dateend,timestart,timeend,allday,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM $calsql_tbl WHERE "
                    . "((datestart >= '$year-$month-$curday->daynumber 00:00:00' "
                    . "AND datestart <= '$year-$month-$curday->daynumber 23:59:59') "
                    . "OR (dateend >= '$year-$month-$curday->daynumber 00:00:00' "
                    . "AND dateend <= '$year-$month-$curday->daynumber 23:59:59') "
                    . "OR ('$year-$month-$curday->daynumber' BETWEEN datestart AND dateend))"
                    . $calsql_filt . " ORDER BY datestart,timestart";

            $query2 = DB_query($calsql);
            $q2_numrows = DB_numRows($query2);

            if ($q2_numrows > 0) {
                $entries = '';
                for ($z = 1; $z <= $q2_numrows; $z++) {
                    $results = DB_fetchArray ($query2);
                    if ($results['title']) {
                        $cal_templates->set_var ('cal_day_entries', '');
                        $entries .=
                            COM_createLink(
                                stripslashes ($results['title']),
                                $_CONF['site_url'] . '/calendar/event.php?' . addMode ($mode)
                                . 'eid=' . $results['eid'],
                                array('class'=>'cal-event'))
                            . '<hr' . XHTML . '>';
                    }
                }
                for ($z = $z; $z <= 4; $z++) {
                    $entries .= '<br' . XHTML . '>';
                }

                $cal_templates->set_var('event_anchortags', $entries);

            } else {
                if ($q2_numrows < 4) {
                    for ($t=0; $t < (4 - $q2_numrows); $t++) {
                        $cal_templates->set_var('cal_day_entries','<br' . XHTML . '><br' . XHTML . '><br' . XHTML . '><br' . XHTML . '>');
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
    $cal_templates->set_var('lang_mastercal', $LANG_CAL_2[25] . $LANG_CAL_2[11]);
    $cal_templates->parse('master_calendar_option','mastercal',true);
} else {
    if (!COM_isAnonUser() && ($_CA_CONF['personalcalendars'] == 1)) {
        $cal_templates->set_var('lang_mycalendar', $LANG_CAL_2[12]);
        $cal_templates->parse('personal_calendar_option','personalcal',true);
    } else {
        $cal_templates->set_var('personal_calendar_option','&nbsp;');
    }
}


$cal_templates->set_var('lang_cal_curmo', $LANG_MONTH[$currentmonth + 0]);
$cal_templates->set_var('cal_curmo_num', $currentmonth);
$cal_templates->set_var('cal_curyr_num', $currentyear);
$cal_templates->set_var('lang_cal_displaymo', $LANG_MONTH[$month + 0]);
$cal_templates->set_var('cal_displaymo_num', $month);
$cal_templates->set_var('cal_displayyr_num', $year);
if ($mode == 'personal') {
    $cal_templates->set_var('lang_addevent', $LANG_CAL_2[8]);
    $cal_templates->set_var('addevent_formurl', '/calendar/index.php');
} else {
    $cal_templates->set_var('lang_addevent', $LANG_CAL_2[42]);
    $cal_templates->set_var('addevent_formurl', '/submit.php?type=calendar');
}
$cal_templates->parse('add_event_option','addevent',true);
$cal_templates->parse('output','calendar');
$display .= $cal_templates->finish($cal_templates->get_var('output'));

$display .= COM_siteFooter();
break;

} // end switch

COM_output($display);

?>
