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
    $display = COM_createHTMLDocument(SEC_loginRequiredForm(),
        array('pagetitle' => $LANG_DIR['title']));
    COM_output($display);
    exit;
}

$theme = isset($_USER['theme']) ? $_USER['theme'] : $_CONF['theme'];
clearstatcache();
define ('TEMPLATE_EXISTS', file_exists($_CONF['path_themes']
    . $theme . '/directory.thtml'));

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
function DIR_lastDayOfMonth($month, $year)
{
    $month++;
    if ($month > 12) {
        $month = 1;
        $year++;
    }

    $lastday = mktime(0, 0, 0, $month, 0, $year);

    return intval(strftime('%d', $lastday));
}

/**
* Display a topic selection drop-down menu
*
* @param    string  $dir_topic  current topic
* @param    int     $year       current year
* @param    int     $month      current month
* @return   string              HTML string of drop-down menu
*
*/
function DIR_topicList($dir_topic = 'all', $year = 0, $month = 0)
{
    global $_CONF, $LANG21;

    $retval = '';

    $retval .= '<form class="floatright" action="';
    $retval .= $_CONF['site_url'] . '/' . THIS_SCRIPT;
    $retval .= '" method="post" style="margin:0"><div>' . LB;
    $retval .= '<select name="topic" onchange="this.form.submit()">' . LB;
    $retval .= TOPIC_getTopicListSelect($dir_topic, 2, true) . LB;
    $retval .= '</select>' . LB;
    $retval .= '<input type="hidden" name="year" value="' . $year . '"' . XHTML . '>' . LB;
    $retval .= '<input type="hidden" name="month" value="' . $month . '"' . XHTML . '>' . LB;
    $retval .= '</div></form>' . LB;

    return $retval;
}

/**
* Build link to a month's page
*
* @param    string  $dir_topic  current topic
* @param    int     $year   year to link to
* @param    int     $month  month to link to
* @param    int     $count  number of stories for that month (may be 0)
* @return   string          month name + count, as link or plain text
*
*/
function DIR_monthLink($dir_topic, $year, $month, $count)
{
    global $_CONF, $LANG_MONTH;

    $retval = $LANG_MONTH[$month] . ' (' . COM_numberFormat ($count) . ')' . LB;

    if ($count > 0) {
        $month_url = COM_buildUrl($_CONF['site_url'] . '/'
            . THIS_SCRIPT . '?topic=' . urlencode ($dir_topic) . '&amp;year='
            . $year . '&amp;month=' . $month);
        $retval =  COM_createLink($retval, $month_url);
    }

    $retval .= LB;

    return $retval;
}

/**
* Display navigation bar
*
* @param    string  $dir_topic  current topic
* @param    int     $year   current year
* @param    int     $month  current month (or 0 for year view pages)
* @return   string          navigation bar with prev, next, and "up" links
*
*/
function DIR_navBar($dir_topic, $year, $month = 0)
{
    global $_CONF, $_TABLES, $LANG05, $LANG_DIR;

    $retval = '';

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

    $result = DB_query("SELECT MIN(EXTRACT(Year from date)) AS year FROM {$_TABLES['stories']}");
    $A = DB_fetchArray($result);
    if ($prevyear < $A['year']) {
        $prevyear = 0;
    }

    $currenttime = time();
    $currentyear = date('Y', $currenttime);
    if ($nextyear > $currentyear) {
        $nextyear = 0;
    }
    if (($month > 0) && ($nextyear > 0) && ($nextyear >= $currentyear)) {
        $currentmonth = date('n', $currenttime);
        if ($nextmonth > $currentmonth) {
            $nextyear = 0;
        }
    }

    if ($prevyear > 0) {
        $url = $_CONF['site_url'] . '/' . THIS_SCRIPT . '?topic='
             . urlencode($dir_topic) . '&amp;year=' . $prevyear;
        if ($month > 0) {
            $url .= '&amp;month=' . $prevmonth;
        }
        $retval .= COM_createLink($LANG05[6], COM_buildUrl($url));
    } else {
        $retval .= $LANG05[6];
    }

    $retval .= ' | ';

    $url = $_CONF['site_url'] . '/' . THIS_SCRIPT;
    if ($dir_topic != 'all') {
        $url = COM_buildUrl($url . '?topic=' . urlencode($dir_topic));
    }

    $retval .= COM_createLink($LANG_DIR['nav_top'] , $url);

    $retval .= ' | ';

    if ($nextyear > 0) {
        $url = $_CONF['site_url'] . '/' . THIS_SCRIPT . '?topic='
             . urlencode($dir_topic) . '&amp;year=' . $nextyear;
        if ($month > 0) {
            $url .= '&amp;month=' . $nextmonth;
        }
        $retval .= COM_createLink($LANG05[5], COM_buildUrl($url));
    } else {
        $retval .= $LANG05[5];
    }

    return $retval;
}

/**
* Display month view
*
* @param    ref    &$template   reference of the template
* @param    string  $dir_topic  current topic
* @param    int     $year   year to display
* @param    int     $month  month to display
* @return   string          list of articles for the given month
*
*/
function DIR_displayMonth(&$template, $dir_topic, $year, $month)
{
    global $_CONF, $_TABLES, $LANG_MONTH, $LANG_DIR;

    $retval = '';

    $start = sprintf('%04d-%02d-01 00:00:00', $year, $month);
    $lastday = DIR_lastDayOfMonth($month, $year);
    $end   = sprintf('%04d-%02d-%02d 23:59:59', $year, $month, $lastday);
    
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

    if ($dir_topic != 'all') {
        // Retrieve list of inherited topics
        $tid_list = TOPIC_getChildList($dir_topic);        
        $sql['mysql'] .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic}')))";
        $sql['mssql'] .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic}')))";
        $sql['pgsql'] .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic}')))";
    } else {
        $sql['mysql'] .= COM_getTopicSql('AND', 0, 'ta');   
        $sql['mssql'] .= COM_getTopicSql('AND', 0, 'ta');  
        $sql['pgsql'] .= COM_getTopicSql('AND', 0, 'ta');         
    }
    $sql['mysql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY sid ORDER BY date ASC";
    $sql['mssql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY sid ORDER BY date ASC";
    $sql['pgsql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY sid ORDER BY date ASC";

    $result = DB_query($sql);
    $numrows = DB_numRows($result);

    if ($numrows > 0) {
        $entries = array();
        $mday = 0;

        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray($result);

            if ($mday != $A['mday']) {
                if (count($entries) > 0) {
                    $retval .= COM_makeList($entries);
                    $entries = array();
                }

                $day = strftime($_CONF['shortdate'], $A['day']);

                if (TEMPLATE_EXISTS) {
                    $template->set_var('section_title', $day);
                    $retval .= $template->parse('title', 'section-title') . LB;
                } else {
                    $retval .= '<h3>' . $day . '</h3>' . LB;
                }

                $mday = $A['mday'];
            }

            $url = COM_buildUrl($_CONF['site_url'] . '/article.php?story='
                                . $A['sid']);
            $entries[] = COM_createLink(stripslashes($A['title']), $url);
        }

        if (count($entries) > 0) {
            $retval .= COM_makeList($entries);
        }

    } else {
        if (TEMPLATE_EXISTS) {
            $retval .= $template->parse('message', 'no-articles') . LB;
        } else {
            $retval .= '<p>' . $LANG_DIR['no_articles'] . '</p>' . LB;
        }
    }

    $retval .= LB;

    return $retval;
}

/**
* Display year view
*
* @param    ref    &$template   reference of the template
* @param    string  $dir_topic  current topic
* @param    int     $year   year to display
* @return   string          list of months (+ number of stories) for given year
*
*/
function DIR_displayYear(&$template, $dir_topic, $year)
{
    global $_CONF, $_TABLES, $LANG_MONTH, $LANG_DIR;

    $retval = '';

    $currenttime = time();
    $currentyear  = date('Y', $currenttime);
    $currentmonth = date('m', $currenttime);

    $start = sprintf('%04d-01-01 00:00:00', $year);
    $end   = sprintf('%04d-12-31 23:59:59', $year);

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
    
    if ($dir_topic != 'all') {
        // Retrieve list of inherited topics
        $tid_list = TOPIC_getChildList($dir_topic);        
        $monthsql['mysql'] .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic}')))";
        $monthsql['mssql'] .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic}')))";
        $monthsql['pgsql'] .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic}')))";
    } else {
        $monthsql['mysql'] .= COM_getTopicSql('AND', 0, 'ta');   
        $monthsql['mssql'] .= COM_getTopicSql('AND', 0, 'ta');  
        $monthsql['pgsql'] .= COM_getTopicSql('AND', 0, 'ta');         
    }
    $monthsql['mysql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY MONTH(date) ORDER BY date ASC";
    $monthsql['mssql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY MONTH(date) ORDER BY month(date) ASC";
    $monthsql['pgsql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY month,date ORDER BY DATE ASC";    

    $mresult = DB_query($monthsql);
    $nummonths = DB_numRows($mresult);

    if ($nummonths > 0) {
        $items = array();
        $lastm = 1;
        for ($j = 0; $j < $nummonths; $j++) {
            $M = DB_fetchArray($mresult);

            for (; $lastm < $M['month']; $lastm++) {
                $items[] = DIR_monthLink($dir_topic, $year, $lastm, 0);
            }
            $lastm = $M['month'] + 1;

            $items[] = DIR_monthLink($dir_topic, $year, $M['month'], $M['count']);
        }

        if ($year == $currentyear) {
            $fillm = $currentmonth;
        } else {
            $fillm = 12;
        }

        if ($lastm <= $fillm) {
            for (; $lastm <= $fillm; $lastm++) {
                $items[] = DIR_monthLink($dir_topic, $year, $lastm, 0);
            }
        }
        $retval .= COM_makeList($items);
    } else {
        if (TEMPLATE_EXISTS) {
            $retval .= $template->parse('message', 'no-articles') . LB;
        } else {
            $retval .= '<p>' . $LANG_DIR['no_articles'] . '</p>' . LB;
        }
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
* @param    ref    &$template  reference of the template
* @param    string  $dir_topic current topic
* @return   string             list of all the years in the db
*
*/
function DIR_displayAll(&$template, $dir_topic)
{
    global $_TABLES, $LANG_DIR;

    $retval = '';

    $yearsql = array();
    $yearsql['mysql'] = "SELECT DISTINCT YEAR(date) AS year,date
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE (draft_flag = 0) AND (date <= NOW())
        AND ta.type = 'article' AND ta.id = sid
        " . COM_getTopicSql('AND', 0, 'ta') . COM_getPermSql('AND')  . COM_getLangSQL('sid', 'AND');

    $yearsql['mssql'] = "SELECT YEAR(date) AS year
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE (draft_flag = 0) AND (date <= NOW())
        AND ta.type = 'article' AND ta.id = sid
        " . COM_getTopicSql('AND', 0, 'ta') . COM_getPermSql('AND')  . COM_getLangSQL('sid', 'AND');

    $yearsql['pgsql'] = "SELECT EXTRACT( YEAR from date) AS year
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE (draft_flag = 0) AND (date <= NOW())
        AND ta.type = 'article' AND ta.id = sid
        " . COM_getTopicSql('AND', 0, 'ta') . COM_getPermSql('AND')  . COM_getLangSQL('sid', 'AND');

    $ysql = array();
    $ysql['mysql'] = $yearsql['mysql'] . " GROUP BY YEAR(date) ORDER BY date DESC";
    $ysql['mssql'] = $yearsql['mssql'] . " GROUP BY YEAR(date) ORDER BY YEAR(date) DESC";
    $ysql['pgsql'] = $yearsql['pgsql'] . " GROUP BY year,date ORDER BY year DESC";

    $yresult = DB_query($ysql);
    $numyears = DB_numRows($yresult);
    if ($numyears > 0) {
        for ($i = 0; $i < $numyears; $i++) {
            $Y = DB_fetchArray($yresult);

            if (TEMPLATE_EXISTS) {
                $template->set_var('section_title', $Y['year']);
                $retval .= $template->parse('title', 'section-title') . LB;
            } else {
                $retval .= '<h3>' . $Y['year'] . '</h3>' . LB;
            }

            $retval .= DIR_displayYear($template, $dir_topic, $Y['year']);
        }
    } else {
        if (TEMPLATE_EXISTS) {
            $retval .= $template->parse('message', 'no-articles') . LB;
        } else {
            $retval .= '<p>' . $LANG_DIR['no_articles'] . '</p>' . LB;
        }
    }

    return $retval;
}

/**
* Return a canonical link
*
* @param    string  $dir_topic  current topic or 'all'
* @param    int     $year   current year
* @param    int     $month  current month
* @return   string          <link rel="canonical"> tag
*
*/
function DIR_canonicalLink($dir_topic, $year = 0, $month = 0)
{
    global $_CONF;

    $script = $_CONF['site_url'] . '/' . THIS_SCRIPT;

    $tp = '?topic=' . urlencode($dir_topic);
    $parts = '';
    if (($year != 0) && ($month != 0)) {
        $parts .= "&amp;year=$year&amp;month=$month";
    } elseif ($year != 0) {
        $parts .= "&amp;year=$year";
    } elseif ($dir_topic == 'all') {
        $tp = '';
    }
    $url = COM_buildUrl($script . $tp . $parts);

    return '<link rel="canonical" href="' . $url . '"' . XHTML . '>' . LB;
}

// MAIN
$display = '';

if (isset($_POST['topic']) && isset($_POST['year']) && isset($_POST['month'])) {
    $dir_topic = $_POST['topic'];
    $year = $_POST['year'];
    $month = $_POST['month'];
} else {
    COM_setArgNames(array('topic', 'year', 'month'));
    $dir_topic = COM_getArgument('topic');
    $year = COM_getArgument('year');
    $month = COM_getArgument('month');
}

$dir_topic = COM_applyFilter($dir_topic);
if (empty($dir_topic)) {
    $dir_topic = 'all';
}

// Topic stuff already set in lib-common but need to double check if URL_Write is_a enabled
//Set topic for rest of site
if ($dir_topic == 'all') {
    $topic = '';
} else {
    $topic = $dir_topic;
}
// See if user has access to view topic.
if ($topic != '') {
    $test_topic = DB_getItem($_TABLES['topics'], 'tid', "tid = '$topic' " . COM_getPermSQL('AND'));
    if (strtolower($topic) != strtolower($test_topic)) {
        $topic = '';
        $dir_topic = 'all';
    } else {
        $topic = $test_topic;
        $dir_topic = $test_topic;
    }
}

$year = COM_applyFilter($year, true);
if ($year < 0) {
    $year = 0;
}
$month = COM_applyFilter($month, true);
if (($month < 1) || ($month > 12)) {
    $month = 0;
}

$dir_topicName = '';
if ($dir_topic != 'all') {
    $dir_topicName = DB_getItem($_TABLES['topics'], 'topic',
                            "tid = '" . DB_escapeString($dir_topic) . "'");
}

$template = NULL;
if (TEMPLATE_EXISTS) {
    $template = COM_newTemplate($_CONF['path_layout']);
    $template->set_file('t_directory', 'directory.thtml');
    $template->set_block('t_directory', 'section-title');
    $template->set_block('t_directory', 'no-articles');
    $template->set_var('lang_no_articles', $LANG_DIR['no_articles']);
}

if (($year != 0) && ($month != 0)) {
    $title = sprintf ($LANG_DIR['title_month_year'],
                      $LANG_MONTH[$month], $year);
    if ($dir_topic != 'all') {
        $title .= ': ' . $dir_topicName;
    }
    $headercode = DIR_canonicalLink($dir_topic, $year, $month);
    $directory = DIR_displayMonth($template, $dir_topic, $year, $month);
    $page_navigation = DIR_navBar($dir_topic, $year, $month);
    $block_title = $LANG_MONTH[$month] . ' ' . $year;
    $val_year = $year;
    $val_month = $month;

} else if ($year != 0) {
    $title = sprintf($LANG_DIR['title_year'], $year);
    if ($dir_topic != 'all') {
        $title .= ': ' . $dir_topicName;
    }
    $headercode = DIR_canonicalLink($dir_topic, $year);
    $directory = DIR_displayYear($template, $dir_topic, $year);
    $page_navigation = DIR_navBar($dir_topic, $year);
    $block_title = $year;
    $val_year = $year;
    $val_month = 0;

} else {
    $title = $LANG_DIR['title'];
    if ($dir_topic != 'all') {
        $title .= ': ' . $dir_topicName;
    }
    $headercode = DIR_canonicalLink($dir_topic);
    $directory = DIR_displayAll($template, $dir_topic);
    $page_navigation = '';
    $block_title = $LANG_DIR['title'];
    $val_year = 0;
    $val_month = 0;

    if ($conf_list_current_month) {
        $currenttime = time();
        $currentyear  = date('Y', $currenttime);
        $currentmonth = date('n', $currenttime);
        $thismonth = COM_startBlock($LANG_MONTH[$currentmonth])
                   . DIR_displayMonth($template, $dir_topic,
                         $currentyear, $currentmonth)
                   . COM_endBlock();
        if (TEMPLATE_EXISTS) {
            $template->set_var('current_month', $thismonth);
        } else {
            $display .= $thismonth;
        }
    }
}

if (TEMPLATE_EXISTS) {
    $topic_list = TOPIC_getTopicListSelect($dir_topic, 2, true);
    $template->set_var(array(
        'url'             => $_CONF['site_url'] . '/' . THIS_SCRIPT,
        'topic_list'      => $topic_list,
        'blockheader'     => COM_startBlock($block_title),
        'val_year'        => $val_year,
        'val_month'       => $val_month,
        'directory'       => $directory,
        'page_navigation' => $page_navigation,
        'blockfooter'     => COM_endBlock(),
    ));
    $template->parse('output', 't_directory');
    $display .= $template->finish($template->get_var('output'));
} else {
    $display .= COM_startBlock($block_title);
    $display .= DIR_topicList($dir_topic, $val_year, $val_month) . LB;
    $display .= $directory;
    $display .= '<div class="pagenav">' . $page_navigation . '</div>' . LB;
    $display .= COM_endBlock();
}

$display = COM_createHTMLDocument($display, array('pagetitle' => $title,
    'headercode' => $headercode));
COM_output($display);

?>
