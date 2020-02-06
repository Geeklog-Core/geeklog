<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Display poll results and past polls.                                      |
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

/**
 * Display poll results and past polls
 *
 * @package    Polls
 * @subpackage public_html
 */

/**
 * Geeklog common function library
 */
require_once '../lib-common.php';

if (!in_array('polls', $_PLUGINS)) {
    COM_handle404();
    exit;
}


/**
 * Shows all polls in system
 * List all the polls on the system if no $pid is provided
 *
 * @return   string          HTML for poll listing
 */
function polllist()
{
    global $_CONF, $_TABLES, $_PO_CONF, $LANG25, $LANG_POLLS;

    $retval = '';

    if (COM_isAnonUser() && (($_CONF['loginrequired'] == 1) ||
            ($_PO_CONF['pollsloginrequired'] == 1))
    ) {
        $retval .= SEC_loginRequiredForm();
    } else {
        require_once($_CONF['path_system'] . 'lib-admin.php');
        $header_arr = array(    // display 'text' and use table field 'field'
            array('text' => $LANG25[9], 'field' => 'topic', 'sort' => true),
            array('text' => $LANG25[20], 'field' => 'voters', 'sort' => true),
            array('text' => $LANG25[3], 'field' => 'unixdate', 'sort' => true),
            array('text' => $LANG_POLLS['open_poll'], 'field' => 'is_open', 'sort' => true),
        );

        $defsort_arr = array('field' => 'unixdate', 'direction' => 'desc');

        $text_arr = array(
            'has_menu' => false,
            'title'    => $LANG_POLLS['pollstitle'], 'instructions' => "",
            'icon'     => '',
            'form_url' => $_CONF['site_url'] . '/polls/index.php',
        );

        $query_arr = array(
            'table'          => 'polltopics',
            'sql'            => $sql = "SELECT *, UNIX_TIMESTAMP(created) AS unixdate, display FROM {$_TABLES['polltopics']} WHERE 1=1 ",
            'query_fields'   => array('topic'),
            'default_filter' => COM_getPermSQL(),
            'query'          => '',
            'query_limit'    => 0,
        );

        $retval .= ADMIN_list('polls', 'plugin_getListField_polls', $header_arr, $text_arr, $query_arr, $defsort_arr);
    }

    return $retval;
}

// MAIN
//
// no pid will load a list of polls
// no aid will let you vote on the select poll
// an aid greater than 0 will save a vote for that answer on the selected poll
// an aid of -1 will display the select poll

$display = '';

if (Geeklog\Input::post('reply') == $LANG01[25]) {
    COM_redirect(
        $_CONF['site_url'] . '/comment.php?'
        . http_build_query(array(
            'sid'  => Geeklog\Input::post('pid'),
            'pid'  => Geeklog\Input::post('pid'),
            'type' => Geeklog\Input::post('type'),
        ))
    );
}
//var_dump($_POST);die();
$pid = 0;
$aid = 0;
if (isset($_REQUEST['pid'])) {
    $pid = Geeklog\Input::fRequest('pid');
    if (isset($_GET['aid'])) {
        $aid = -1; // only for showing results instead of questions
    } elseif (isset($_POST['aid'])) {
        $aid = Geeklog\Input::post('aid');
    }
}

$order = Geeklog\Input::fRequest('order', '');
//$mode = Geeklog\Input::fRequest('mode', '');
$mode = Geeklog\Input::fRequest('mode', Geeklog\Input::fRequest('format', ''));
$page = (int) Geeklog\Input::fRequest('cpage', 1);
$msg = (int) Geeklog\Input::fRequest('msg', 0);

if (!empty($pid)) {
    $questions_sql = "SELECT question,qid FROM {$_TABLES['pollquestions']} "
        . "WHERE pid = '" . DB_escapeString($pid) . "' ORDER BY qid";
    $questions = DB_query($questions_sql);
    $nquestions = DB_numRows($questions);
}
if (empty($pid)) {
    if ($msg > 0) {
        $display .= COM_showMessage($msg, 'polls');
    }
    $display .= polllist();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_POLLS['pollstitle']));
} elseif ((isset($_POST['aid']) && is_array($_POST['aid']) && (count($_POST['aid']) == $nquestions)) && !isset($_COOKIE['poll-' . $pid])) {
    $aids = '';
    foreach ($aid as $answer) {
        $aids .= $answer[0] . '-';
    }
    $aids = substr($aids, 0, -1);

    setcookie(
        'poll-' . $pid, $aids, time() + $_PO_CONF['pollcookietime'], $_CONF['cookie_path'],
        $_CONF['cookiedomain'], $_CONF['cookiesecure']
    );
    $display .= POLLS_pollsave($pid, $aid);
    $display = COM_createHTMLDocument($display);
} elseif (!empty($pid)) {
    $result = DB_query(
        "SELECT topic, meta_description, meta_keywords FROM {$_TABLES['polltopics']} "
        . "WHERE pid = '" . DB_escapeString($pid) . "' " . COM_getPermSQL('AND'));
    $A = DB_fetchArray($result);

    $polltopic = $A['topic'];
    if (empty($polltopic)) {
        // poll doesn't exist or user doesn't have access
        COM_handle404($_CONF['site_url'] . '/polls/index.php');
    } else {
        // Meta Tags
        $headercode = '';

        if ($_PO_CONF['meta_tags'] > 0) {
            $headercode = LB . PLG_getMetaTags(
                    'poll', $pid,
                    array(
                        array(
                            'name'    => 'description',
                            'content' => stripslashes($A['meta_description']),
                        ),
                        array(
                            'name'    => 'keywords',
                            'content' => stripslashes($A['meta_keywords']),
                        ),
                    )
                );
        }

        if ($msg > 0) {
            $display .= COM_showMessage($msg, 'polls');
        }
        if (isset($_POST['aid'])) {
            $display .= COM_showMessageText($LANG_POLLS['answer_all'] . ' "' . $polltopic . '"', $LANG_POLLS['not_saved']);
        }
        if (DB_getItem($_TABLES['polltopics'], 'is_open', "pid = '" . DB_escapeString($pid) . "'") != 1) {
            $aid = -1; // poll closed - show result
        }
        if (!isset($_COOKIE['poll-' . $pid])
            && !POLLS_ipAlreadyVoted($pid)
            && $aid != -1
        ) {
            $display .= POLLS_pollVote($pid, true, 0, $order, $mode, $page);
        } else {
            $display .= POLLS_pollResults($pid, 100, $order, $mode, $page);
        }
        $display = COM_createHTMLDocument($display, array('pagetitle' => $polltopic, 'headercode' => $headercode));
    }
} else {
    $display .= polllist();
    $display = COM_createHTMLDocument($display, array('pagetitle' => $LANG_POLLS['pollstitle']));
}

COM_output($display);
