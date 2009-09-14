<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Display poll results and past polls.                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
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
* @package Polls
* @subpackage public_html
*/

/**
* Geeklog common function library
*/
require_once '../lib-common.php';

if (!in_array('polls', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}


/**
* Shows all polls in system
*
* List all the polls on the system if no $pid is provided
*
* @return   string          HTML for poll listing
*
*/
function polllist ()
{
    global $_CONF, $_TABLES, $_USER, $_PO_CONF,
           $LANG25, $LANG_LOGIN, $LANG_POLLS;

    $retval = '';

    if (empty ($_USER['username']) && (($_CONF['loginrequired'] == 1) ||
            ($_PO_CONF['pollsloginrequired'] == 1))) {
        $retval = COM_startBlock ($LANG_LOGIN[1], '',
                          COM_getBlockTemplate ('_msg_block', 'header'));
        $login = new Template ($_CONF['path_layout'] . 'submit');
        $login->set_file (array ('login' => 'submitloginrequired.thtml'));
        $login->set_var ( 'xhtml', XHTML );
        $login->set_var ('login_message', $LANG_LOGIN[2]);
        $login->set_var ('site_url', $_CONF['site_url']);
        $login->set_var ('lang_login', $LANG_LOGIN[3]);
        $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
        $login->parse ('output', 'login');
        $retval .= $login->finish ($login->get_var('output'));
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    } else {
        require_once( $_CONF['path_system'] . 'lib-admin.php' );
        $header_arr = array(    // display 'text' and use table field 'field'
                        array('text' => $LANG25[9], 'field' => 'topic', 'sort' => true),
                        array('text' => $LANG25[20], 'field' => 'voters', 'sort' => true),
                        array('text' => $LANG25[3], 'field' => 'unixdate', 'sort' => true),
                        array('text' => $LANG_POLLS['open_poll'], 'field' => 'is_open', 'sort' => true)
        );

        $defsort_arr = array('field' => 'unixdate', 'direction' => 'desc');

        $text_arr = array('has_menu' =>  false,
                          'title' => $LANG_POLLS['pollstitle'], 'instructions' => "",
                          'icon' => '', 'form_url' => '');

        $query_arr = array('table' => 'polltopics',
                           'sql' => $sql = "SELECT *,UNIX_TIMESTAMP(date) AS unixdate, display "
                                . "FROM {$_TABLES['polltopics']} WHERE 1=1",
                           'query_fields' => array('topic'),
                           'default_filter' => COM_getPermSQL (),
                           'query' => '',
                           'query_limit' => 0);

        $retval .= ADMIN_list ('polls', 'plugin_getListField_polls',
                   $header_arr, $text_arr, $query_arr, $defsort_arr);
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

if (isset ($_POST['reply']) && ($_POST['reply'] == $LANG01[25])) {
    $display .= COM_refresh ($_CONF['site_url'] . '/comment.php?sid='
             . $_POST['pid'] . '&pid=' . $_POST['pid']
             . '&type=' . $_POST['type']);
    echo $display;
    exit;
}

$pid = 0;
$aid = 0;
if (isset ($_REQUEST['pid'])) {
    $pid = COM_applyFilter ($_REQUEST['pid']);
    if (isset ($_GET['aid'])) {
        $aid = -1; // only for showing results instead of questions
    } else if (isset ($_POST['aid'])) {
        $aid = $_POST['aid'];
    }
} elseif (isset($_POST['id'])) {       // Refresh from comment tool bar
    $qid = COM_applyFilter ($_POST['id']);
}
$order = '';
if (isset ($_REQUEST['order'])) {
    $order = COM_applyFilter ($_REQUEST['order']);
}
$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}
$msg = 0;
if (isset($_REQUEST['msg'])) {
    $msg = COM_applyFilter($_REQUEST['msg'], true);
}

if (! empty($pid)) {
    $questions_sql = "SELECT question,qid FROM {$_TABLES['pollquestions']} "
    . "WHERE pid='$pid' ORDER BY qid";
    $questions = DB_query($questions_sql);
    $nquestions = DB_numRows($questions);
}
if (empty($pid)) {
    $display .= COM_siteHeader ('menu', $LANG_POLLS['pollstitle']);
    if ($msg > 0) {
        $display .= COM_showMessage($msg, 'polls');
    }
    $display .= polllist ();
} else if ((isset($_POST['aid']) && (count($_POST['aid']) == $nquestions)) && !isset ($_COOKIE['poll-'.$pid])) {
    setcookie ('poll-'.$pid, implode('-',$aid), time() + $_PO_CONF['pollcookietime'],
               $_CONF['cookie_path'], $_CONF['cookiedomain'],
               $_CONF['cookiesecure']);
    $display .= COM_siteHeader() . POLLS_pollsave($pid, $aid);
} elseif (! empty($pid)) {
    $result = DB_query ("SELECT topic, meta_description, meta_keywords FROM {$_TABLES['polltopics']} WHERE pid = '{$pid}'" . COM_getPermSQL('AND'));
    $A = DB_fetchArray ($result);
    
    $topic = $A['topic'];
    if (empty($topic)) {
        // poll doesn't exist or user doesn't have access
        $display .= COM_siteHeader('menu', $LANG_POLLS['pollstitle'])
                 . COM_showMessageText(sprintf($LANG25[12], $pid));
    } else {
        // Meta Tags
        $headercode = '';
        If ($_PO_CONF['meta_tags'] > 0) {
            $meta_description = stripslashes($A['meta_description']);
            $meta_keywords = stripslashes($A['meta_keywords']);            
            $headercode = COM_createMetaTags($meta_description, $meta_keywords);
        }
        
        $display .= COM_siteHeader('menu', $topic, $headercode);
        if ($msg > 0) {
            $display .= COM_showMessage($msg, 'polls');
        }
        if (isset($_POST['aid'])) {
            $display .= COM_startBlock (
                    $LANG_POLLS['not_saved'], '',
                    COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG_POLLS['answer_all'] . ' "' . $topic . '"'
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        }
        if (DB_getItem($_TABLES['polltopics'], 'is_open', "pid = '$pid'") != 1) {
            $aid = -1; // poll closed - show result
        }
        if (!isset ($_COOKIE['poll-'.$pid])
            && !POLLS_ipAlreadyVoted ($pid)
            && $aid != -1
            ) {
            $display .= POLLS_pollVote ($pid);
        } else {
            $display .= POLLS_pollResults ($pid, 400, $order, $mode);
        }
    }
} else {
    $poll_topic = DB_query ("SELECT topic FROM {$_TABLES['polltopics']} WHERE pid='$pid'" . COM_getPermSql ('AND'));
    $Q = DB_fetchArray ($poll_topic);
    if (empty ($Q['topic'])) {
        $display .= COM_siteHeader ('menu', $LANG_POLLS['pollstitle'])
                 . polllist ();
    } else {
        $display .= COM_siteHeader ('menu', $Q['topic'])
                 . POLLS_pollResults ($pid, 400, $order, $mode);
    }
}
$display .= COM_siteFooter();

COM_output($display);

?>
