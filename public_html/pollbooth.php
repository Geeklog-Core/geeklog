<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | pollbooth.php                                                            |
// |                                                                           |
// | This is the pollbooth page.                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
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
// $Id: pollbooth.php,v 1.24 2004/08/05 12:54:46 dhaun Exp $

require_once('lib-common.php');

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
    global $_TABLES, $LANG07, $REMOTE_ADDR;

    $pcount = DB_count ($_TABLES['pollvoters'], array ('ipaddress', 'qid' ),
                        array ($REMOTE_ADDR, $qid));
    if ($pcount > 0) {
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
    DB_save($_TABLES['pollvoters'],'ipaddress,date,qid',"'$REMOTE_ADDR'," . time() . ",'$qid'");
    $retval .= COM_startBlock ($LANG07[1], '',
                       COM_getBlockTemplate ('_msg_block', 'header'))
        . $LANG07[2] . ' "'
        . DB_getItem ($_TABLES['pollquestions'], 'question', "qid = '{$qid}'")
        . '"'
        . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
        . COM_pollResults($qid);

    return $retval;
}

/**
* Shows all polls in system
*
* List all the polls on the system if no $qid is provided
*
* @return   string  HTML for poll listing
*
*/
function polllist() 
{
    global $_TABLES, $_CONF, $_USER, $_GROUPS, $LANG07, $LANG10, $LANG_LOGIN;

    if (empty ($_USER['username']) &&
        (($_CONF['loginrequired'] == 1) || ($_CONF['pollsloginrequired'] == 1))) {
        $retval = COM_startBlock ($LANG_LOGIN[1], '',
                          COM_getBlockTemplate ('_msg_block', 'header'));
        $login = new Template($_CONF['path_layout'] . 'submit'); 
        $login->set_file (array ('login'=>'submitloginrequired.thtml'));
        $login->set_var ('login_message', $LANG_LOGIN[2]);
        $login->set_var ('site_url', $_CONF['site_url']);
        $login->set_var ('lang_login', $LANG_LOGIN[3]);
        $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
        $login->parse ('output', 'login');
        $retval .= $login->finish ($login->get_var('output'));
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    } else {
        $sql = "SELECT qid,question,voters FROM {$_TABLES['pollquestions']}"
             . COM_getPermSQL ();
        $result = DB_query($sql);
        $nrows = DB_numRows($result);
        $retval = COM_startBlock($LANG07[4]);
        if ($nrows > 0) {
            $pollitem = new Template($_CONF['path_layout'] . 'pollbooth');
            $pollitem->set_file('pollitem', 'polllist.thtml');
            for ($i = 1; $i <= $nrows; $i++) {
                $Q = DB_fetchArray($result);
                $pollitem->set_var('item_num', $i);
                $pollitem->set_var('poll_url', $_CONF['site_url'].'/pollbooth.php?qid=' . $Q['qid'] . '&amp;aid=-1');
                $pollitem->set_var('poll_question', stripslashes($Q['question']));
                $pollitem->set_var('poll_votes', $Q['voters']);
                $pollitem->set_var('lang_votes', $LANG07[5]);
                if ($i == $nrows) {
                    $pollitem->set_var('ending_br', '<br><br>');
                } else {
                    $pollitem->set_var('ending_br', '');
                }
                $pollitem->parse('output', 'pollitem');
                $retval .= $pollitem->finish($pollitem->get_var('output'));
            }
        } else {
            $retval .= $LANG10[17];
        }
        $retval .= COM_endBlock();
    }

    return $retval;
}

// MAIN
//
// no qid will load a list of polls
// no aid will let you vote on the select poll
// an aid greater than 0 will save a vote for that answer on the selected poll
// an aid of -1 will display the select poll

if ($reply == $LANG01[25]) {
    $display .= COM_refresh($_CONF['site_url'] . "/comment.php?sid=$qid&pid=$pid&type=$type");
    echo $display;
    exit;			
}

if (isset ($HTTP_POST_VARS['qid'])) {
    $qid = COM_applyFilter ($HTTP_POST_VARS['qid']);
    $aid = COM_applyFilter ($HTTP_POST_VARS['aid'], true);
} else {
    $qid = COM_applyFilter ($HTTP_GET_VARS['qid']);
    $aid = COM_applyFilter ($HTTP_GET_VARS['aid']);
    if ($aid > 0) { // you can't vote with a GET request
        $aid = -1;
    }
}
if (isset ($HTTP_POST_VARS['order'])) {
    $order = COM_applyFilter ($HTTP_POST_VARS['order']);
} else {
    $order = COM_applyFilter ($HTTP_GET_VARS['order']);
}
if (isset ($HTTP_POST_VARS['mode'])) {
    $mode = COM_applyFilter ($HTTP_POST_VARS['mode']);
} else {
    $mode = COM_applyFilter ($HTTP_GET_VARS['mode']);
}

if (empty($qid)) {
    $_CONF['pagetitle'] = $LANG07[4];
    $display .= COM_siteHeader() . polllist();
} else if ($aid == 0) {
    $display .= COM_siteHeader();
    if (empty($HTTP_COOKIE_VARS[$qid])) {
        $display .= COM_pollVote($qid);
    } else {
        $display .= COM_pollResults($qid,400,$order,$mode);
    }
} else if (($aid > 0) && ($aid <= $_CONF['maxanswers']) &&
        empty($HTTP_COOKIE_VARS[$qid])) {
    setcookie ($qid, $aid, time() + $_CONF['pollcookietime'],
               $_CONF['cookie_path'], $_CONF['cookiedomain'],
               $_CONF['cookiesecure']);
    $display .= COM_siteHeader() . pollsave($qid, $aid);
} else {
    $display .= COM_siteHeader()
             . COM_pollResults($qid,400,$order,$mode);
}
$display .= COM_siteFooter();

echo $display;

?>
