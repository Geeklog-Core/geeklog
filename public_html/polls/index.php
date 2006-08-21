<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 1.1                                                          |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Display poll results and past polls.                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
// $Id: index.php,v 1.20 2006/08/21 11:38:31 dhaun Exp $

require_once ('../lib-common.php');

// number of polls to list per page
define ('POLLS_PER_PAGE', 50);

/**
* Saves a user's vote
*
* Saves the users vote, if allowed for the poll $qid.
* NOTE: all data comes from form post
*
* @param    string   $qid   poll id
* @param    int      $aid   selected answer
* @return   string   HTML for poll results
*
*/
function pollsave($qid = '', $aid = 0) 
{
    global $_TABLES, $LANG_POLLS;

    $retval = '';

    if (POLLS_ipAlreadyVoted ($qid)) {
        exit;
    }

    DB_change($_TABLES['pollquestions'],'voters',"voters + 1",'qid',$qid,'',true);
    $id[1] = 'qid';
    $value[1] = $qid;
    $id[2] = 'aid';
    $value[2] = $aid;
    // This call to DB-change will properly supress the insertion of quoes around $value in the sql
    DB_change($_TABLES['pollanswers'],'votes',"votes + 1",$id,$value, '', true);
    // This always does an insert so no need to provide key_field and key_value args
    DB_save($_TABLES['pollvoters'],'ipaddress,date,qid',"'{$_SERVER['REMOTE_ADDR']}'," . time() . ",'$qid'");
    $retval .= COM_startBlock ($LANG_POLLS['savedvotetitle'], '',
                       COM_getBlockTemplate ('_msg_block', 'header'))
        . $LANG_POLLS['savedvotemsg'] . ' "'
        . DB_getItem ($_TABLES['pollquestions'], 'question', "qid = '{$qid}'")
        . '"'
        . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
        . POLLS_pollResults($qid);

    return $retval;
}

/**     
* Shows all polls in system
*       
* List all the polls on the system if no $qid is provided
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
                        array('text' => $LANG25[9], 'field' => 'question', 'sort' => true),
                        array('text' => $LANG25[20], 'field' => 'voters', 'sort' => true),
                        array('text' => $LANG25[3], 'field' => 'unixdate', 'sort' => true),
                        array('text' => $LANG_POLLS['open_poll'], 'field' => 'display', 'sort' => true)
        );

        $defsort_arr = array('field' => 'unixdate', 'direction' => 'desc');

        $menu_arr = array ();

        $text_arr = array('has_menu' =>  false,
                          'title' => $LANG_POLLS['pollstitle'], 'instructions' => "",
                          'icon' => '', 'form_url' => '');

        $query_arr = array('table' => 'pollquestions',
                           'sql' => $sql = "SELECT *,UNIX_TIMESTAMP(date) AS unixdate, display FROM {$_TABLES['pollquestions']} WHERE 1=1",
                           'query_fields' => array('question'),
                           'default_filter' => COM_getPermSQL (),
                           'query' => '',
                           'query_limit' => 0);

        $retval .= ADMIN_list ('polls', 'plugin_getListField_polls',
                   $header_arr, $text_arr, $query_arr, $menu_arr, $defsort_arr);
    }

    return $retval;
}

// MAIN
//
// no qid will load a list of polls
// no aid will let you vote on the select poll
// an aid greater than 0 will save a vote for that answer on the selected poll
// an aid of -1 will display the select poll

$display = '';

if (isset ($_POST['reply']) && ($_POST['reply'] == $LANG01[25])) {
    $display .= COM_refresh ($_CONF['site_url'] . '/comment.php?sid='
             . $_POST['qid'] . '&pid=' . $_POST['pid']
             . '&type=' . $_POST['type']);
    echo $display;
    exit;			
}

$qid = 0;
$aid = -1;
if (isset ($_POST['qid'])) {
    $qid = COM_applyFilter ($_POST['qid']);
    if (isset ($_POST['aid'])) {
        $aid = COM_applyFilter ($_POST['aid'], true);
    }
} else {
    if (isset ($_GET['qid'])) {
        $qid = COM_applyFilter ($_GET['qid']);
    }
    if (isset ($_GET['aid'])) {
        $aid = COM_applyFilter ($_GET['aid'], true);
        if ($aid > 0) { // you can't vote with a GET request
            $aid = -1;
        }
    }
}
$order = '';
if (isset ($_REQUEST['order'])) {
    $order = COM_applyFilter ($_REQUEST['order']);
}
$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}

if (empty($qid)) {
    $display .= COM_siteHeader ('menu', $LANG_POLLS['pollstitle'])
             . polllist (); 
} else if ($aid == 0) {
    $display .= COM_siteHeader();
    if (!isset ($_COOKIE[$qid]) && !POLLS_ipAlreadyVoted ($qid)) {
        $display .= POLLS_pollVote ($qid);
    } else {
        $display .= POLLS_pollResults ($qid, 400, $order, $mode);
    }
} else if (($aid > 0) && ($aid <= $_PO_CONF['maxanswers']) &&
        !isset ($_COOKIE[$qid])) {
    setcookie ($qid, $aid, time() + $_PO_CONF['pollcookietime'],
               $_CONF['cookie_path'], $_CONF['cookiedomain'],
               $_CONF['cookiesecure']);
    $display .= COM_siteHeader() . pollsave($qid, $aid);
} else {
    $question = DB_query ("SELECT question FROM {$_TABLES['pollquestions']} WHERE qid='$qid'" . COM_getPermSql ('AND'));
    $Q = DB_fetchArray ($question);
    if (empty ($Q['question'])) {
        $display .= COM_siteHeader ('menu', $LANG_POLLS['pollstitle'])
                 . polllist ();
    } else {
        $display .= COM_siteHeader ('menu', $Q['question'])
                 . POLLS_pollResults ($qid, 400, $order, $mode);
    }
}
$display .= COM_siteFooter();

echo $display;

?>
