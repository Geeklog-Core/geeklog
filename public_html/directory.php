<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | directory.php                                                             |
// |                                                                           |
// | Directory of all the stories on a Geeklog site.                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004-2010 by the following authors:                         |
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

/**
* Geeklog common function library
*/
require_once 'lib-common.php';

// configuration option:
// List stories for the current month on top of the overview page
// (if set = true)
$conf_list_current_month = false;

// name of this script
define ('THIS_SCRIPT', 'directory.php');

$display = '';

if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
                         ($_CONF['directoryloginrequired'] == 1))) {
    $display = COM_createHTMLDocument(SEC_loginRequiredForm(), array('pagetitle' => $LANG_DIR['title']));
    
    COM_output($display);
    exit;
}

/**
* Helper function: Calculate last day of a given month
*
* @param    int     $month  Month
* @param    int     $year   Year
* @return   int             Number of days in that month
* @todo     Bug: Will fail from 2038 onwards ...
*
* "The last day of any given month can be expressed as the "0" day
* of the next month", http://www.php.net/manual/en/function.mktime.php
*
*/
function DIR_lastDayOfMonth ($month, $year)
{
    $month++;
    if ($month > 12) {
        $month = 1;
        $year++;
    }

    $lastday = mktime (0, 0, 0, $month, 0, $year);

    return intval(strftime('%d', $lastday));
}

/**
* Display a topic selection drop-down menu
*
* @param    string  $topic          current topic
* @param    int     $year           current year
* @param    int     $month          current month
* @param    boolean $standalone     true: don't display form inline
*
*/
function DIR_topicList ($topic = 'all', $year = 0, $month = 0, $standalone = false)
{
    global $_CONF, $LANG21;

    $retval = '';

    $url = $_CONF['site_url'] . '/' . THIS_SCRIPT;
    $retval .= '<form action="' . $url . '" method="post"';
    if (!$standalone) {
        $retval .= ' style="display:inline; float:right"' . LB;
    }
    $retval .= '><div>' . LB;
    $retval .= '<select name="topic" onchange="this.form.submit()">' . LB;
    $retval .= TOPIC_getTopicListSelect($topic, 2, true);
    $retval .= '</select>' . LB;
    $retval .= '<input type="hidden" name="year" value="' . $year . '"' . XHTML . '>';
    $retval .= '<input type="hidden" name="month" value="' . $month . '"' . XHTML . '>';
    $retval .= '</div></form>' . LB;

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
    global $_CONF, $LANG_MONTH;

    $retval = $LANG_MONTH[$month] . ' (' . COM_numberFormat ($count) . ')' . LB;

    if ($count > 0) {
        $month_url = COM_buildUrl ($_CONF['site_url'] . '/'
            . THIS_SCRIPT . '?topic=' . urlencode ($topic) . '&amp;year='
            . $year . '&amp;month=' . $month);
        $retval =  COM_createLink ($retval, $month_url);
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

    $result = DB_query ("SELECT MIN(EXTRACT(Year from date)) AS year FROM {$_TABLES['stories']}");
    $A = DB_fetchArray ($result);
    if ($prevyear < $A['year']) {
        $prevyear = 0;
    }

    $currentyear = date('Y', time());
    if ($nextyear > $currentyear) {
        $nextyear = 0;
    }
    if (($month > 0) && ($nextyear > 0) && ($nextyear >= $currentyear)) {
        $currentmonth = date('n', time());
        if ($nextmonth > $currentmonth) {
            $nextyear = 0;
        }
    }

    if ($prevyear > 0) {
        $url = $_CONF['site_url'] . '/' . THIS_SCRIPT . '?topic='
             . urlencode ($topic) . '&amp;year=' . $prevyear;
        if ($month > 0) {
            $url .= '&amp;month=' . $prevmonth;
        }
        $retval .= COM_createLink($LANG05[6], COM_buildUrl ($url));
    } else {
        $retval .= $LANG05[6];
    }

    $retval .= ' | ';

    $url = $_CONF['site_url'] . '/' . THIS_SCRIPT;
    if ($topic != 'all') {
        $url = COM_buildUrl ($url . '?topic=' . urlencode ($topic));
    }

    $retval .= COM_createLink($LANG_DIR['nav_top'] , $url);

    $retval .= ' | ';

    if ($nextyear > 0) {
        $url = $_CONF['site_url'] . '/' . THIS_SCRIPT . '?topic='
             . urlencode ($topic) . '&amp;year=' . $nextyear;
        if ($month > 0) {
            $url .= '&amp;month=' . $nextmonth;
        }
        $retval .= COM_createLink($LANG05[5], COM_buildUrl ($url));
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
* @param    boolean $main   true: display view on its own page
* @return   string          list of articles for the given month
*
*/
function DIR_displayMonth ($topic, $year, $month, $main = false)
{
    global $_CONF, $_TABLES, $LANG_MONTH, $LANG_DIR;

    $retval = '';

    if ($main) {
        $retval .= '<div><h1 style="display:inline">' . $LANG_MONTH[$month]
                . ' ' . $year . '</h1> ' . DIR_topicList ($topic, $year, $month)
                . '</div>' . LB;
    } else {
        $retval .= '<h1>' . $LANG_MONTH[$month] . ' ' . $year . '</h1>' . LB;
    }

    $start = sprintf ('%04d-%02d-01 00:00:00', $year, $month);
    $lastday = DIR_lastDayOfMonth ($month, $year);
    $end   = sprintf ('%04d-%02d-%02d 23:59:59', $year, $month, $lastday);

    $sql = array();
    $sql['mysql'] = "SELECT sid,title,UNIX_TIMESTAMP(date) AS day,DATE_FORMAT(date, '%e') AS mday 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta  
        WHERE (date >= '$start') AND (date <= '$end') AND (draft_flag = 0) AND (date <= NOW()) 
        AND ta.type = 'article' AND ta.id = sid ";
        
    $sql['mssql'] = $sql['mysql'];
    
    $sql['pgsql'] = "SELECT sid,title,UNIX_TIMESTAMP(date) AS day,EXTRACT(day from date) AS mday 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
        WHERE (date >= '$start') AND (date <= '$end') AND (draft_flag = 0) AND (date <= NOW()) 
        AND ta.type = 'article' AND ta.id = sid ";
    
    if ($topic != 'all') {
        $sql['mysql'] .= " AND ta.tid = '$topic'";
        $sql['mssql'] = $sql['mysql'];
        $sql['pgsql'] .= " AND ta.tid = '$topic'";
    }
    $sql['mysql'] .= COM_getTopicSql ('AND', 0, 'ta') . COM_getPermSql ('AND')
         . COM_getLangSQL ('sid', 'AND') . " GROUP BY sid ORDER BY date ASC";
    $sql['mssql'] .= COM_getTopicSql ('AND', 0, 'ta') . COM_getPermSql ('AND')
         . COM_getLangSQL ('sid', 'AND') . " GROUP BY sid ORDER BY date ASC";    
    $sql['pgsql'] .= COM_getTopicSql ('AND', 0, 'ta') . COM_getPermSql ('AND')
         . COM_getLangSQL ('sid', 'AND') . " GROUP BY sid ORDER BY date ASC";

    $result = DB_query ($sql);
    $numrows = DB_numRows ($result);

    if ($numrows > 0) {
        $entries = array ();
        $mday = 0;

        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray ($result);

            if ($mday != $A['mday']) {
                if (count($entries) > 0) {
                    $retval .= COM_makeList ($entries);
                    $entries = array ();
                }

                $day = strftime ($_CONF['shortdate'], $A['day']);

                $retval .= '<h2>' . $day . '</h2>' . LB;

                $mday = $A['mday'];
            }

            $url = COM_buildUrl ($_CONF['site_url'] . '/article.php?story='
                                 . $A['sid']);
            $entries[] = COM_createLink(stripslashes ($A['title']), $url);
        }

        if (count($entries) > 0) {
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
* @param    boolean $main   true: display view on its own page
* @return   string          list of months (+ number of stories) for given year
*
*/
function DIR_displayYear ($topic, $year, $main = false)
{
    global $_CONF, $_TABLES, $LANG_MONTH, $LANG_DIR;

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

    $monthsql = array();
    $monthsql['mysql'] = "SELECT DISTINCT MONTH(s.date) AS month, COUNT(DISTINCT s.sid) AS count 
        FROM {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta   
        WHERE (s.date >= '$start') AND (s.date <= '$end') AND (s.draft_flag = 0) AND (s.date <= NOW()) 
        AND ta.type = 'article' AND ta.id = s.sid ";
        
    $monthsql['mssql'] = "SELECT MONTH(date) AS month,COUNT(DISTINCT sid) AS count 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta  
        WHERE (date >= '$start') AND (date <= '$end') AND (draft_flag = 0) AND (date <= NOW()) 
        AND ta.type = 'article' AND ta.id = sid ";
        
    $monthsql['pgsql'] = "SELECT EXTRACT(Month from date) AS month,COUNT(DISTINCT sid) AS count 
        FROM {$_TABLES['stories']} , {$_TABLES['topic_assignments']} ta 
        WHERE (date >= '$start') AND (date <= '$end') AND (draft_flag = 0) AND (date <= NOW()) 
        AND ta.type = 'article' AND ta.id = sid ";
    
    if ($topic != 'all') {
        $monthsql['mysql'] .= " AND ta.tid = '$topic'";
        $monthsql['mssql'] .= " AND ta.tid = '$topic'";
        $monthsql['pgsql'] .= " AND ta.tid = '$topic'";
    }
    $monthsql['mysql'] .= COM_getTopicSql ('AND', 0, 'ta') . COM_getPermSql ('AND')
              . COM_getLangSQL ('sid', 'AND');
    $monthsql['mssql'] .= COM_getTopicSql ('AND', 0, 'ta') . COM_getPermSql ('AND')
              . COM_getLangSQL ('sid', 'AND');
    $monthsql['pgsql'] .= COM_getTopicSql ('AND', 0, 'ta') . COM_getPermSql ('AND')
              . COM_getLangSQL ('sid', 'AND');

    $msql = array();
    $msql['mysql'] = $monthsql['mysql'] . " GROUP BY MONTH(date) ORDER BY date ASC";
    $msql['mssql'] = $monthsql['mssql'] . " GROUP BY MONTH(date) ORDER BY month(date) ASC";
    $msql['pgsql'] = $monthsql['pgsql'] . " GROUP BY month,date ORDER BY DATE ASC";

    $mresult = DB_query ($msql);
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

        if ($lastm <= $fillm) {
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
* @param    boolean $list_current_month     true = list stories f. current month
* @return   string                          list of all the years in the db
*
*/
function DIR_displayAll ($topic, $list_current_month = false)
{
    global $_TABLES, $LANG_DIR;

    $retval = '';

    if ($list_current_month) {
        $currentyear = date ('Y', time ());
        $currentmonth = date ('n', time ());

        $retval .= DIR_displayMonth ($topic, $currentyear, $currentmonth);

        $retval .= '<hr' . XHTML . '>' . LB;
    }

    $retval .= '<div><h1 style="display:inline">' . $LANG_DIR['title']
            . '</h1> ' . DIR_topicList ($topic) . '</div>' . LB;

    $yearsql = array();
    $yearsql['mysql'] = "SELECT DISTINCT YEAR(date) AS year,date 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
        WHERE (draft_flag = 0) AND (date <= NOW())  
        AND ta.type = 'article' AND ta.id = sid 
        " . COM_getTopicSql ('AND', 0, 'ta') . COM_getPermSql ('AND')  . COM_getLangSQL ('sid', 'AND');
    
    $yearsql['mssql'] = "SELECT YEAR(date) AS year 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
        WHERE (draft_flag = 0) AND (date <= NOW()) 
        AND ta.type = 'article' AND ta.id = sid 
        " . COM_getTopicSql ('AND', 0, 'ta') . COM_getPermSql ('AND')  . COM_getLangSQL ('sid', 'AND');
    
    $yearsql['pgsql'] = "SELECT EXTRACT( YEAR from date) AS year 
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta 
        WHERE (draft_flag = 0) AND (date <= NOW()) 
        AND ta.type = 'article' AND ta.id = sid  
        " . COM_getTopicSql ('AND', 0, 'ta') . COM_getPermSql ('AND')  . COM_getLangSQL ('sid', 'AND');
    
    $ysql = array();
    $ysql['mysql'] = $yearsql['mysql'] . " GROUP BY YEAR(date) ORDER BY date DESC";
    $ysql['mssql'] = $yearsql['mssql'] . " GROUP BY YEAR(date) ORDER BY YEAR(date) DESC";
    $ysql['pgsql'] = $yearsql['pgsql'] . " GROUP BY year,date ORDER BY year DESC";

    $yresult = DB_query ($ysql);
    $numyears = DB_numRows ($yresult);
    if ($numyears > 0) {
        for ($i = 0; $i < $numyears; $i++) {
            $Y = DB_fetchArray ($yresult);
    
            $retval .= DIR_displayYear ($topic, $Y['year']);
        }
    } else {
        $retval .= '<p>' . $LANG_DIR['no_articles'] . '</p>';
    }    

    return $retval;
}

/**
* Return a canonical link
*
* @param    string  $topic  current topic or 'all'
* @param    int     $year   current year
* @param    int     $month  current month
* @return   string          <link rel="canonical"> tag
*
*/
function DIR_canonicalLink($topic, $year = 0, $month = 0)
{
    global $_CONF;

    $script = $_CONF['site_url'] . '/' . THIS_SCRIPT;

    $tp = '?topic=' . urlencode($topic);
    $parts = '';
    if (($year != 0) && ($month != 0)) {
        $parts .= "&amp;year=$year&amp;month=$month";
    } elseif ($year != 0) {
        $parts .= "&amp;year=$year";
    } elseif ($topic == 'all') {
        $tp = '';
    }
    $url = COM_buildUrl($script . $tp . $parts);

    return '<link rel="canonical" href="' . $url . '"' . XHTML . '>' . LB;
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

$topicName = '';
if ($topic != 'all') {
    $topicName = DB_getItem($_TABLES['topics'], 'topic',
                            "tid = '" . addslashes($topic) . "'");
}
if (($year != 0) && ($month != 0)) {
    $title = sprintf ($LANG_DIR['title_month_year'],
                      $LANG_MONTH[$month], $year);
    if ($topic != 'all') {
        $title .= ': ' . $topicName;
    }
    $display = DIR_displayMonth ($topic, $year, $month, true);
    $display .= DIR_navBar ($topic, $year, $month);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $title, 'headercode' => DIR_canonicalLink($topic, $year, $month)));
} else if ($year != 0) {
    $title = sprintf ($LANG_DIR['title_year'], $year);
    if ($topic != 'all') {
        $title .= ': ' . $topicName;
    }
    $display = DIR_displayYear($topic, $year, true);
    $display .= DIR_navBar($topic, $year);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $title, 'headercode' => DIR_canonicalLink($topic, $year)));
} else {
    $title = $LANG_DIR['title'];
    if ($topic != 'all') {
        $title .= ': ' . $topicName;
    }
    $display = DIR_displayAll($topic, $conf_list_current_month);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $title, 'headercode' => DIR_canonicalLink($topic)));
}

COM_output($display);

?>
