<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | directory.php                                                             |
// |                                                                           |
// | Directory of all the stories on a Geeklog site.                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004-2005 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun         - dirk AT haun-online DOT de                   |
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
// $Id: directory.php,v 1.2 2005/01/17 12:42:05 dhaun Exp $

require_once ('lib-common.php');

// configuration option:
// List stories for the current month on top of the overview page
// (if set = true)
$conf_list_current_month = false;

// name of this script
define ('THIS_SCRIPT', 'directory.php');

$display = '';

if (empty ($_USER['username']) && (($_CONF['loginrequired'] == 1) ||
                                   ($_CONF['directoryloginrequired'] == 1))) {
    $display = COM_siteHeader ('menu', $LANG_DIR['title']);
    $display .= COM_startBlock ($LANG_LOGIN[1], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $login = new Template ($_CONF['path_layout'] . 'submit');
    $login->set_file (array ('login' => 'submitloginrequired.thtml'));
    $login->set_var ('site_url', $_CONF['site_url']);
    $login->set_var ('layout_url', $_CONF['layout_url']);
    $login->set_var ('login_message', $LANG_LOGIN[2]);
    $login->set_var ('lang_login', $LANG_LOGIN[3]);
    $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
    $login->parse ('output', 'login');
    $display .= $login->finish ($login->get_var ('output'));
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    echo $display; 
    exit;
}

/**
* Display a topic selection drop-down menu
*
* @param    string  $topic          current topic
* @param    int     $year           current year
* @param    int     $month          current month
* @param    bool    $standalone     true: don't display form inline
*
*/
function DIR_topicList ($topic = 'all', $year = 0, $month = 0, $standalone = false)
{
    global $_CONF, $LANG21;

    $retval = '';

    $url = $_CONF['site_url'] . '/' . THIS_SCRIPT;
    $retval .= '<form action="' . $url . '" method="POST"';
    if (!$standalone) {
        $retval .= ' style="display:inline; float:right"' . LB;
    }
    $retval .= '>' . LB;
    $retval .= '<select name="topic" onchange="this.form.submit()">' . LB;
    $retval .= '<option value="all"';
    if ($topic == 'all') {
        $retval .= ' selected="selected"';
    }
    $retval .= '>' . $LANG21[7] . '</option>' . LB;
    $retval .= COM_topicList ('tid,topic', $topic);
    $retval .= '</select>' . LB;
    $retval .= '<input type="hidden" name="year" value="' . $year . '">';
    $retval .= '<input type="hidden" name="month" value="' . $month . '">';
    $retval .= '</form>' . $LB;

    return $retval;
}

/**
* Build link to a month's page
*
* @param    string  $topic  current topic
* @param    int     $year   year to link to
* @param    int     $month  month to link to
* @param    int     $count  number of stories for that month (may be 0)
* @return   string          month name + count, as link or plain text
*
*/
function DIR_monthLink ($topic, $year, $month, $count)
{
    global $_CONF, $LANG30;

    $retval = '';

    if ($count > 0) {
        $retval .= '<a href="' . COM_buildUrl ($_CONF['site_url'] . '/'
                . THIS_SCRIPT . '?topic=' . urlencode ($topic) . '&amp;year='
                . $year . '&amp;month=' . $month) . '">';
    }

    $retval .= $LANG30[$month + 12] . ' (' . $count . ')' . LB;

    if ($count > 0) {
        $retval .= '</a>';
    }

    $retval .= LB;

    return $retval;
}

/**
* Display navigation bar
*
* @param    string  $topic  current topic
* @param    int     $year   current year
* @param    int     $month  current month (or 0 for year view pages)
* @return   string          navigation bar with prev, next, and "up" links
*
*/
function DIR_navBar ($topic, $year, $month = 0)
{
    global $_CONF, $_TABLES, $LANG05, $LANG_DIR;

    $retval = '';

    $retval .= '<div class="pagenav">';

    if ($month == 0) {
        $prevyear = $year - 1;
        $nextyear = $year + 1;
    } else {
        $prevyear = $year;
        $prevmonth = $month - 1;
        if ($prevmonth == 0) {
            $prevmonth = 12;
            $prevyear--;
        }
        $nextyear = $year;
        $nextmonth = $month + 1;
        if ($nextmonth > 12) {
            $nextmonth = 1;
            $nextyear++;
        }
    }

    $result = DB_query ("SELECT MIN(YEAR(date)) AS year FROM {$_TABLES['stories']}");
    $A = DB_fetchArray ($result);
    if ($prevyear < $A['year']) {
        $prevyear = 0;
    }

    $currentyear = date ('Y', time ());
    if ($nextyear > $currentyear) {
        $nextyear = 0;
    }

    if ($prevyear > 0) {
        $url = $_CONF['site_url'] . '/' . THIS_SCRIPT . '?topic='
             . urlencode ($topic) . '&amp;year=' . $prevyear;
        if ($month > 0) {
            $url .= '&amp;month=' . $prevmonth;
        }
        $retval .= '<a href="' . COM_buildUrl ($url) . '">' . $LANG05[6]
                . '</a>';
    } else {
        $retval .= $LANG05[6];
    }

    $retval .= ' | ';

    $url = $_CONF['site_url'] . '/' . THIS_SCRIPT;
    if ($topic != 'all') {
        $url = COM_buildUrl ($url . '?topic=' . urlencode ($topic));
    }
    $retval .= '<a href="' . $url . '">' . $LANG_DIR['nav_top'] . '</a>';

    $retval .= ' | ';

    if ($nextyear > 0) {
        $url = $_CONF['site_url'] . '/' . THIS_SCRIPT . '?topic='
             . urlencode ($topic) . '&amp;year=' . $nextyear;
        if ($month > 0) {
            $url .= '&amp;month=' . $nextmonth;
        }
        $retval .= '<a href="' . COM_buildUrl ($url) . '">' . $LANG05[5]
                . '</a>';
    } else {
        $retval .= $LANG05[5];
    }

    $retval .= '</div>' . LB;

    return $retval;
}

/**
* Display month view
*
* @param    string  $topic  current topic
* @param    int     $year   year to display
* @param    int     $month  month to display
* @param    bool    $main   true: display view on its own page
* @return   string          list of articles for the given month
*
*/
function DIR_displayMonth ($topic, $year, $month, $main = false)
{
    global $_CONF, $_TABLES, $LANG30, $LANG_DIR;

    $retval = '';

    if ($main) {
        $retval .= '<div><h1 style="display:inline">' . $LANG30[$month + 12]
                . ' ' . $year . '</h1> ' . DIR_topicList ($topic, $year, $month)
                . '</div>' . LB;
    } else {
        $retval .= '<h1>' . $LANG30[$month + 12] . ' ' . $year . '</h1>' . LB;
    }

    $start = sprintf ('%04d-%02d-01 00:00:00', $year, $month);
    $end   = sprintf ('%04d-%02d-31 23:59:59', $year, $month);

    $sql = "SELECT sid,title,UNIX_TIMESTAMP(date) AS day,DAYOFMONTH(date) AS mday FROM {$_TABLES['stories']} WHERE (date >= '$start') AND (date <= '$end') AND (draft_flag = 0) AND (date <= NOW())";
    if ($topic != 'all') {
        $sql .= " AND (tid = '$topic')";
    }
    $sql .= COM_getTopicSql ('AND') . COM_getPermSql ('AND') . " ORDER BY date ASC";

    $result = DB_query ($sql);
    $numrows = DB_numRows ($result);

    if ($numrows > 0) {
        $entries = array ();
        $mday = 0;

        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray ($result);

            if ($mday != $A['mday']) {
                if (sizeof ($entries) > 0) {
                    $retval .= COM_makeList ($entries);
                    $entries = array ();
                }

                $curtime = COM_getUserDateTimeFormat ($A['day']);
                $day = $curtime[0];

                $day = strftime ($_CONF['shortdate'], $A['day']);

                $retval .= '<h2>' . $day . '</h2>' . LB;

                $mday = $A['mday'];
            }

            $url = COM_buildUrl ($_CONF['site_url'] . '/article.php?story='
                                 . $A['sid']);
            $entries[] = '<a href="' . $url . '">' . stripslashes ($A['title'])
                       . '</a>';
        }

        if (sizeof ($entries) > 0) {
            $retval .= COM_makeList ($entries);
        }

    } else {
        $retval .= '<p>' . $LANG_DIR['no_articles'] . '</p>';
    }

    $retval .= LB;

    return $retval;
}

/**
* Display year view
*
* @param    string  $topic  current topic
* @param    int     $year   year to display
* @param    bool    $main   true: display view on its own page
* @return   string          list of months (+ number of stories) for given year
*
*/
function DIR_displayYear ($topic, $year, $main = false) 
{
    global $_CONF, $_TABLES, $LANG30, $LANG_DIR;

    $retval = '';

    if ($main) {
        $retval .= '<div><h1 style="display:inline">' . $year . '</h1> '
                . DIR_topicList ($topic, $year) . '</div>' . LB;
    } else {
        $retval .= '<h2>' . $year . '</h2>' . LB;
    }

    $currentyear = date ('Y', time ());
    $currentmonth = date ('m', time ());

    $start = sprintf ('%04d-01-01 00:00:00', $year);
    $end   = sprintf ('%04d-12-31 23:59:59', $year);

    $monthsql = "SELECT DISTINCT MONTH(date) AS month,COUNT(*) AS count FROM {$_TABLES['stories']} WHERE (date >= '$start') AND (date <= '$end') AND (draft_flag = 0) AND (date <= NOW())";
    if ($topic != 'all') {
        $monthsql .= " AND (tid = '$topic')";
    }
    $monthsql .= COM_getTopicSql ('AND') . COM_getPermSql ('AND') . " GROUP BY MONTH(date) ORDER BY date ASC";

    $mresult = DB_query ($monthsql);
    $nummonths = DB_numRows ($mresult);

    if ($nummonths > 0) {
        $retval .= '<ul>' . LB;
        $lastm = 1;
        for ($j = 0; $j < $nummonths; $j++) {
            $M = DB_fetchArray ($mresult);

            for (; $lastm < $M['month']; $lastm++) {
                $retval .= '<li>' . DIR_monthLink ($topic, $year, $lastm, 0)
                        . '</li>';
            }
            $lastm = $M['month'] + 1;

            $retval .= '<li>' . DIR_monthLink ($topic, $year, $M['month'],
                                               $M['count']) . '</li>';
        }

        if ($year == $currentyear) {
            $fillm = $currentmonth;
        } else {
            $fillm = 12;
        }

        if ($lastm < $fillm) {
            for (; $lastm <= $fillm; $lastm++) {
                $retval .= '<li>' . DIR_monthLink ($topic, $year, $lastm, 0)
                        . '</li>';
            }
        }

        $retval .= '</ul>' . LB;
    } else {
        $retval .= '<p>' . $LANG_DIR['no_articles'] . '</p>';
    }

    $retval .= LB;

    return $retval;
}

/**
* Display main view (list of years)
*
* Displays an overview of all the years and months, starting with the first
* year for which a story has been posted. Can optionally display a list of
* the stories for the current month at the top of the page.
*
* @param    string  $topic                  current topic
* @param    bool    $list_current_month     true = list stories f. current month
* @return   string                          list of all the years in the db
*
*/
function DIR_displayAll ($topic, $list_current_month = false)
{
    global $_TABLES, $LANG_DIR;

    $retval = '';

    if ($list_current_month) {
        $currentyear = date ('Y', time ());
        $currentmonth = date ('m', time ());

        $retval .= DIR_displayMonth ($topic, $currentyear, $currentmonth);

        $retval .= '<hr>' . LB;
    }

    $retval .= '<div><h1 style="display:inline">' . $LANG_DIR['title']
            . '</h1> ' . DIR_topicList ($topic) . '</div>' . LB;

    $yearsql = "SELECT DISTINCT YEAR(date) AS year FROM {$_TABLES['stories']} WHERE (draft_flag = 0) AND (date <= NOW())" . COM_getTopicSql ('AND') . COM_getPermSql ('AND')  . " GROUP BY YEAR(date) ORDER BY date DESC";

    $yresult = DB_query ($yearsql);
    $numyears = DB_numRows ($yresult);

    for ($i = 0; $i < $numyears; $i++) {
        $Y = DB_fetchArray ($yresult);

        $retval .= DIR_displayYear ($topic, $Y['year']);
    }

    return $retval;
}

// MAIN
$display = '';

if (isset ($_POST['topic']) && isset ($_POST['year']) && isset ($_POST['month'])) {
    $topic = $_POST['topic'];
    $year = $_POST['year'];
    $month = $_POST['month'];
} else {
    COM_setArgNames (array ('topic', 'year', 'month'));
    $topic = COM_getArgument ('topic');
    $year = COM_getArgument ('year');
    $month = COM_getArgument ('month');
}

$topic = COM_applyFilter ($topic);
if (empty ($topic)) {
    $topic = 'all';
}
$year = COM_applyFilter ($year, true);
if ($year < 0) {
    $year = 0;
}
$month = COM_applyFilter ($month, true);
if (($month < 1) || ($month > 12)) {
    $month = 0;
}

if (($year != 0) && ($month != 0)) {
    $title = sprintf ($LANG_DIR['title_month_year'],
                      $LANG30[$month + 12], $year);
    $display .= COM_siteHeader ('menu', $title);
    $display .= DIR_displayMonth ($topic, $year, $month, true);
    $display .= DIR_navBar ($topic, $year, $month);
} else if ($year != 0) {
    $title = sprintf ($LANG_DIR['title_year'], $year);
    $display .= COM_siteHeader ('menu', $title);
    $display .= DIR_displayYear ($topic, $year, true);
    $display .= DIR_navBar ($topic, $year);
} else {
    $display .= COM_siteHeader ('menu', $LANG_DIR['title']);
    $display .= DIR_displayAll ($topic, $conf_list_current_month);
}

$display .= COM_siteFooter (true);

echo $display;

?>
