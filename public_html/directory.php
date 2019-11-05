<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
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

use Geeklog\Input;

require_once 'lib-common.php';

// configuration option:
// List stories for the current month on top of the overview page
// (if set = true)
$conf_list_current_month = false;

// name of this script
define('THIS_SCRIPT', basename(__FILE__));

$display = '';

if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) || ($_CONF['directoryloginrequired'] == 1))) {
    $display = COM_createHTMLDocument(
        SEC_loginRequiredForm(),
        array('pagetitle' => $LANG_DIR['title'],)
    );
    COM_output($display);
    exit;
}

clearstatcache();

/**
 * Helper function: Calculate last day of a given month
 *
 * @param    int $month Month
 * @param    int $year  Year
 * @return   int        Number of days in that month
 */
function DIR_lastDayOfMonth($month, $year)
{
    $month = (int) $month;
    $year = (int) $year;

    if (in_array($month, array(1, 3, 5, 7, 8, 10, 12))) {
        $retval = 31;
    } elseif (in_array($month, array(4, 6, 9, 11))) {
        $retval = 30;
    } else {
        $retval = 28;

        if ((($year % 4) === 0) && ((($year % 100) !== 0) || (($year % 400) === 0))) {
            $retval = 29;
        }
    }

    return $retval;
}


/**
 * Build link to a month's page
 *
 * @param    string $dir_topic current topic
 * @param    int    $year      year to link to
 * @param    int    $month     month to link to
 * @param    int    $count     number of stories for that month (may be 0)
 * @return   string            month name + count, as link or plain text
 */
function DIR_monthLink($dir_topic, $year, $month, $count)
{
    global $_CONF, $LANG_MONTH;

    $retval = $LANG_MONTH[$month] . ' (' . COM_numberFormat($count) . ')' . PHP_EOL;

    if ($count > 0) {
        $month_url = COM_buildURL(
            $_CONF['site_url'] . '/' . THIS_SCRIPT . '?'
            . http_build_query(array(
                'topic' => $dir_topic,
                'year'  => $year,
                'month' => $month,
            ))
        );
        $retval = COM_createLink($retval, $month_url);
    }

    $retval .= PHP_EOL;

    return $retval;
}

/**
 * Display navigation bar
 *
 * @param    string $dir_topic current topic
 * @param    int    $year      current year
 * @param    int    $month     current month (or 0 for year view pages)
 * @return   string            navigation bar with prev, next, and "up" links
 */
function DIR_navBar($dir_topic, $year, $month = 0)
{
    global $_CONF, $_TABLES, $LANG05, $LANG_DIR;

    $retval = '';

    $prevMonth = $nextMonth = $month;

    if ($month == 0) {
        $prevYear = $year - 1;
        $nextYear = $year + 1;
    } else {
        $prevYear = $year;
        $prevMonth = $month - 1;
        if ($prevMonth == 0) {
            $prevMonth = 12;
            $prevYear--;
        }
        $nextYear = $year;
        $nextMonth = $month + 1;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }
    }

    $result = DB_query("SELECT MIN(EXTRACT(Year from date)) AS year FROM {$_TABLES['stories']}");
    $A = DB_fetchArray($result);
    if ($prevYear < $A['year']) {
        $prevYear = 0;
    }

    $currentTime = time();
    $currentYear = date('Y', $currentTime);
    if ($nextYear > $currentYear) {
        $nextYear = 0;
    }
    if (($month > 0) && ($nextYear > 0) && ($nextYear >= $currentYear)) {
        $currentMonth = date('n', $currentTime);
        if ($nextMonth > $currentMonth) {
            $nextYear = 0;
        }
    }

    if ($prevYear > 0) {
        $args = array(
            'topic' => $dir_topic,
            'year'  => $prevYear,
        );

        if ($month > 0) {
            $args['month'] = $prevMonth;
        }
        $url = COM_buildURL(
            $_CONF['site_url'] . '/' . THIS_SCRIPT . '?' . http_build_query($args)
        );
        $retval .= COM_createLink($LANG05[6], COM_buildURL($url));
    } else {
        $retval .= $LANG05[6];
    }

    $retval .= ' | ';

    $url = COM_buildURL($_CONF['site_url'] . '/' . THIS_SCRIPT);
    if ($dir_topic !== TOPIC_ALL_OPTION) {
        $url = COM_buildURL(
            $_CONF['site_url'] . '/' . THIS_SCRIPT . '?' . http_build_query(array('topic' => $dir_topic))
        );
    }

    $retval .= COM_createLink($LANG_DIR['nav_top'], $url);

    $retval .= ' | ';

    if ($nextYear > 0) {
        $args = array(
            'topic' => $dir_topic,
            'year'  => $nextYear,
        );

        if ($month > 0) {
            $args['month'] = $nextMonth;
        }

        $url = COM_buildURL(
            $_CONF['site_url'] . '/' . THIS_SCRIPT . '?' . http_build_query($args)
        );

        $retval .= COM_createLink($LANG05[5], COM_buildURL($url));
    } else {
        $retval .= $LANG05[5];
    }

    return $retval;
}

/**
 * Display month view
 *
 * @param    Template $template  reference of the template
 * @param    string   $dir_topic current topic
 * @param    int      $year      year to display
 * @param    int      $month     month to display
 * @return   string              list of articles for the given month
 */
function DIR_displayMonth($template, $dir_topic, $year, $month)
{
    global $_CONF, $_TABLES, $LANG_DIR;

    $retval = '';

    $start = sprintf('%04d-%02d-01 00:00:00', $year, $month);
    $lastDay = DIR_lastDayOfMonth($month, $year);
    $end = sprintf('%04d-%02d-%02d 23:59:59', $year, $month, $lastDay);

    $sql = array();
    $sql['mysql'] = "SELECT sid,title,UNIX_TIMESTAMP(date) AS day,DATE_FORMAT(date, '%e') AS mday
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE (date >= '$start') AND (date <= '$end') AND (draft_flag = 0) AND (date <= NOW())
        AND ta.type = 'article' AND ta.id = sid ";

    $sql['pgsql'] = "SELECT sid,title,UNIX_TIMESTAMP(date) AS day,EXTRACT(day from date) AS mday
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE (date >= '$start') AND (date <= '$end') AND (draft_flag = 0) AND (date <= NOW())
        AND ta.type = 'article' AND ta.id = sid ";

    if ($dir_topic !== TOPIC_ALL_OPTION) {
        // Retrieve list of inherited topics
        $tid_list = TOPIC_getChildList($dir_topic);
        $sql['mysql'] .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic}')))";
        $sql['pgsql'] .= " AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic}')))";
    } else {
        $sql['mysql'] .= COM_getTopicSQL('AND', 0, 'ta');
        $sql['pgsql'] .= COM_getTopicSQL('AND', 0, 'ta');
    }
    $sql['mysql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY sid, title, date ORDER BY date ASC";
    $sql['pgsql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY sid, title, date ORDER BY date ASC";

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    if ($numRows > 0) {
        $entries = array();
        $mday = 0;

        for ($i = 0; $i < $numRows; $i++) {
            $A = DB_fetchArray($result);

            if ($mday != $A['mday']) {
                if (count($entries) > 0) {
                    $retval .= COM_makeList($entries, PLG_getThemeItem('article-css-list-directory', 'article'));
                    $entries = array();
                }

                list($day, ) = COM_getUserDateTimeFormat($A['day'], 'shortdate');

                $template->set_var('section_title', $day);
                $retval .= $template->parse('title', 'section-title') . PHP_EOL;

                $mday = $A['mday'];
            }

            $url = COM_buildURL($_CONF['site_url'] . '/article.php?story=' . $A['sid']);
            $entries[] = COM_createLink(stripslashes($A['title']), $url);
        }

        if (count($entries) > 0) {
            $retval .= COM_makeList($entries, PLG_getThemeItem('article-css-list-directory', 'article'));
        }
    } else {
        $retval .= $template->parse('message', 'no-articles') . PHP_EOL;
    }

    $retval .= PHP_EOL;

    return $retval;
}

/**
 * Display year view
 *
 * @param    Template $template  reference of the template
 * @param    string   $dir_topic current topic
 * @param    int      $year      year to display
 * @return   string                list of months (+ number of stories) for given year
 */
function DIR_displayYear($template, $dir_topic, $year)
{
    global $_TABLES, $LANG_DIR;

    $retval = '';

    $currentTime = time();
    $currentYear = date('Y', $currentTime);
    $currentMonth = date('m', $currentTime);

    $start = sprintf('%04d-01-01 00:00:00', $year);
    $end = sprintf('%04d-12-31 23:59:59', $year);

    $monthSql = array();
    $monthSql['mysql'] = "SELECT MONTH(s.date) AS month, COUNT(DISTINCT s.sid) AS cnt
        FROM {$_TABLES['stories']} s, {$_TABLES['topic_assignments']} ta
        WHERE (s.date >= '$start') AND (s.date <= '$end') AND (s.draft_flag = 0) AND (s.date <= NOW())
        AND ta.type = 'article' AND ta.id = s.sid ";

    $monthSql['pgsql'] = "SELECT EXTRACT(Month from date) AS month,COUNT(DISTINCT sid) AS cnt
        FROM {$_TABLES['stories']} , {$_TABLES['topic_assignments']} ta
        WHERE (date >= '$start') AND (date <= '$end') AND (draft_flag = 0) AND (date <= NOW())
        AND ta.type = 'article' AND ta.id = sid ";

    if ($dir_topic !== TOPIC_ALL_OPTION) {
        $monthSql['mysql'] .= " AND (";
        $monthSql['pgsql'] .= " AND (";

        // Retrieve list of inherited topics
        $tid_list = TOPIC_getChildList($dir_topic); // function will always return a topic id (as the one passed will be returned)
        $dir_topic_escaped = DB_escapeString($dir_topic);

        $monthSql['mysql'] .= "ta.tid IN({$tid_list}) AND ";
        $monthSql['pgsql'] .= "ta.tid IN({$tid_list}) AND ";

        $monthSql['mysql'] .= "(ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic_escaped}')))";
        $monthSql['pgsql'] .= "(ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$dir_topic_escaped}')))";
    } else {
        $monthSql['mysql'] .= COM_getTopicSQL('AND', 0, 'ta');
        $monthSql['pgsql'] .= COM_getTopicSQL('AND', 0, 'ta');
    }
    $monthSql['mysql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY date ORDER BY date ASC";
    $monthSql['pgsql'] .= COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND') . " GROUP BY date ORDER BY DATE ASC";

    $mResult = DB_query($monthSql);
    $numMonths = DB_numRows($mResult);

    // The above query returns records with duplicate months.  So, let's sort them out.
    if ($numMonths > 0) {
        $numArticles = array_fill(1, 12, 0);

        while (($M = DB_fetchArray($mResult, false)) !== false) {
            $month = (int) $M['month'];
            $cnt = (int) $M['cnt'];
            $numArticles[$month] += $cnt;
        }

        $items = array();
        $lastMonth = ($year == $currentYear) ? $currentMonth : 12;

        for ($month = 1; $month <= $lastMonth; $month++) {
            $items[] = DIR_monthLink($dir_topic, $year, $month, $numArticles[$month]);
        }

        $retval .= COM_makeList($items, PLG_getThemeItem('article-css-list-directory', 'article'));
    } else {
        $retval .= $template->parse('message', 'no-articles') . PHP_EOL;
    }

    $retval .= PHP_EOL;

    return $retval;
}

/**
 * Display main view (list of years)
 * Displays an overview of all the years and months, starting with the first
 * year for which a story has been posted. Can optionally display a list of
 * the stories for the current month at the top of the page.
 *
 * @param    Template $template  reference of the template
 * @param    string   $dir_topic current topic
 * @return   string              list of all the years in the db
 */
function DIR_displayAll($template, $dir_topic)
{
    global $_TABLES, $LANG_DIR;

    $retval = '';

    $yearSql = array(
        'mysql' =>
            "SELECT DISTINCT YEAR(date) AS year
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE (draft_flag = 0) AND (date <= NOW())
        AND ta.type = 'article' AND ta.id = sid "
            . COM_getTopicSQL('AND', 0, 'ta') . COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND')
            . " GROUP BY date ORDER BY date DESC",

        'pgsql' =>
            "SELECT EXTRACT(YEAR from date) AS year
        FROM {$_TABLES['stories']}, {$_TABLES['topic_assignments']} ta
        WHERE (draft_flag = 0) AND (date <= NOW())
        AND ta.type = 'article' AND ta.id = sid "
            . COM_getTopicSQL('AND', 0, 'ta') . COM_getPermSql('AND') . COM_getLangSQL('sid', 'AND')
            . " GROUP BY year ORDER BY year DESC",
    );
    $yResult = DB_query($yearSql);
    $years = array();

    while (($A = DB_fetchArray($yResult, false))) {
        $years[] = $A['year'];
    }

    if (count($years) > 0) {
        foreach ($years as $year) {
            $template->set_var('section_title', $year);
            $retval .= $template->parse('title', 'section-title') . PHP_EOL;

            $retval .= DIR_displayYear($template, $dir_topic, $year);
        }
    } else {
        $retval .= $template->parse('message', 'no-articles') . PHP_EOL;
    }

    return $retval;
}

/**
 * Return a canonical link
 *
 * @param    string $dir_topic current topic or 'all'
 * @param    int    $year      current year
 * @param    int    $month     current month
 * @return   string          <link rel="canonical"> tag
 */
function DIR_canonicalLink($dir_topic, $year = 0, $month = 0)
{
    global $_CONF;

    $script = $_CONF['site_url'] . '/' . THIS_SCRIPT;
    $args = array(
        'topic' => $dir_topic,
    );

    if (($year != 0) && ($month != 0)) {
        $args['year'] = $year;
        $args['month'] = $month;
    } elseif ($year != 0) {
        $args['year'] = $year;
    } elseif ($dir_topic === TOPIC_ALL_OPTION) {
        unset($args['topic']);
    }

    if (count($args) > 0) {
        $url = COM_buildURL($script . '?' . http_build_query($args));
    } else {
        $url = COM_buildURL($script);
    }

    return '<link rel="canonical" href="' . $url . '"' . XHTML . '>' . PHP_EOL;
}

// MAIN
$display = '';

if (isset($_POST['topic'], $_POST['year'], $_POST['month'])) {
    $dir_topic = Input::post('topic');
    $year = (int) Input::post('year');
    $month = (int) Input::post('month');
} else {
    COM_setArgNames(array('topic', 'year', 'month'));
    $dir_topic = COM_getArgument('topic');
    $year = (int) COM_getArgument('year');
    $month = (int) COM_getArgument('month');
}

$dir_topic = COM_applyFilter($dir_topic);
if (empty($dir_topic)) {
    $dir_topic = TOPIC_ALL_OPTION;
}

// Topic stuff already set in lib-common but need to double check if URL_Write is_a enabled
// Set topic for rest of site
$dir_topic = TOPIC_setTopic($dir_topic);
if (empty($dir_topic)) {
    $dir_topic = TOPIC_ALL_OPTION;
}

if ($year < 0) {
    $year = 0;
}
$month = COM_applyFilter($month, true);
if (($month < 1) || ($month > 12)) {
    $month = 0;
}

$dir_topicName = '';
if ($dir_topic !== TOPIC_ALL_OPTION) {
    $dir_topicName = DB_getItem($_TABLES['topics'], 'topic', "tid = '" . DB_escapeString($dir_topic) . "'");
}

$template = null;
$template = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout']));
$template->set_file('t_directory', 'directory.thtml');
$template->set_block('t_directory', 'section-title');
$template->set_block('t_directory', 'no-articles');
$template->set_var('lang_no_articles', $LANG_DIR['no_articles']);

if (($year != 0) && ($month != 0)) {
    $title = sprintf($LANG_DIR['title_month_year'], $LANG_MONTH[$month], $year);
    if ($dir_topic !== TOPIC_ALL_OPTION) {
        $title .= ': ' . $dir_topicName;
    }

    $headerCode = DIR_canonicalLink($dir_topic, $year, $month);
    $directory = DIR_displayMonth($template, $dir_topic, $year, $month);
    $page_navigation = DIR_navBar($dir_topic, $year, $month);
    $block_title = $LANG_MONTH[$month] . ' ' . $year;
    $val_year = $year;
    $val_month = $month;
} elseif ($year != 0) {
    $title = sprintf($LANG_DIR['title_year'], $year);
    if ($dir_topic !== TOPIC_ALL_OPTION) {
        $title .= ': ' . $dir_topicName;
    }
    $headerCode = DIR_canonicalLink($dir_topic, $year);
    $directory = DIR_displayYear($template, $dir_topic, $year);
    $page_navigation = DIR_navBar($dir_topic, $year);
    $block_title = $year;
    $val_year = $year;
    $val_month = 0;
} else {
    $title = $LANG_DIR['title'];
    if ($dir_topic !== TOPIC_ALL_OPTION) {
        $title .= ': ' . $dir_topicName;
    }
    $headerCode = DIR_canonicalLink($dir_topic);
    $directory = DIR_displayAll($template, $dir_topic);
    $page_navigation = '';
    $block_title = $LANG_DIR['title'];
    $val_year = 0;
    $val_month = 0;

    if ($conf_list_current_month) {
        $currentTime = time();
        $currentYear = date('Y', $currentTime);
        $currentMonth = date('n', $currentTime);
        $thisMonth = COM_startBlock($LANG_MONTH[$currentMonth])
            . DIR_displayMonth($template, $dir_topic,
                $currentYear, $currentMonth)
            . COM_endBlock();
        $template->set_var('current_month', $thisMonth);
    }
}

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

$display = COM_createHTMLDocument(
    $display,
    array(
        'pagetitle'  => $title,
        'headercode' => $headerCode,
    )
);

COM_output($display);
