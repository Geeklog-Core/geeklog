<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the Polls      |
// | plugin' PHP files.                                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Blaine Lang      - langmail AT sympatico DOT ca                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
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
* Implementation of the Plugin API for the Polls plugin
*
* @package Polls
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.inc') !== false) {
    die('This file can not be used on its own.');
}

$plugin_path = $_CONF['path'] . 'plugins/polls/';

/**
* Language file include
*/
$langfile = $plugin_path . 'language/' . $_CONF['language'] . '.php';
if (file_exists($langfile)) {
    require_once $langfile;
} else {
    require_once $plugin_path . 'language/english.php';
}

/**
* Check and see if we need to load the plugin configuration
*/ 
if (!isset($_PO_CONF['pollsloginrequired'])) {
    require_once $_CONF['path_system'] . 'classes/config.class.php';
    
    $po_config = config::get_instance();
    $_PO_CONF = $po_config->get_config('polls');
}


// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
* Returns the items for this plugin that should appear on the main menu
*
* NOTE: this MUST return the url/value pairs in the following format
* $<arrayname>[<label>] = <url>
*
*/
function plugin_getmenuitems_polls ()
{
    global $_CONF, $_USER, $_PO_CONF, $LANG_POLLS;

    $anon = (empty ($_USER['uid']) || ($_USER['uid'] <= 1)) ? true : false;
    if (($_PO_CONF['hidepollsmenu'] == 1) || ($anon &&
                ($_CONF['loginrequired'] || $_PO_CONF['pollsloginrequired']))) {
        return false;
    }

    $menuitems[$LANG_POLLS['polls']] = $_CONF['site_url'] . '/polls/index.php';

    return $menuitems;
}

/**
 * Poll saves a comment
 *
 * @param   string  $type   Plugin to save comment
 * @param   string  $title  comment title
 * @param   string  $comment comment text
 * @param   string  $id     Item id to which $cid belongs
 * @param   int     $pid    comment parent
 * @param   string  $postmode 'html' or 'text'
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_savecomment_polls($title, $comment, $id, $pid, $postmode)
{
    global $_CONF, $_TABLES, $LANG03, $_USER;

    $retval = '';

    $commentcode = DB_getItem ($_TABLES['polltopics'], 'commentcode',
                               "pid = '$id'");
    if ($commentcode != 0) {
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    $ret = CMT_saveComment ($title, $comment, $id, $pid, 'polls', $postmode);
    if ($ret > 0) { // failure //FIXME: some failures should not return to comment form
        $retval .= COM_siteHeader('menu', $LANG03[1])
                . CMT_commentForm ($title, $comment, $id, $pid, 'polls',
                                   $LANG03[14], $postmode)
                . COM_siteFooter();
    } else { // success
        $retval = COM_refresh ($_CONF['site_url']
                                . "/polls/index.php?pid=$id&amp;aid=-1");
    }

    return $retval;
}

/**
 * polls: delete a comment
 *
 * @param   int     $cid    Comment to be deleted
 * @param   string  $id     Item id to which $cid belongs
 * @return  mixed   false for failure, HTML string (redirect?) for success
 */
function plugin_deletecomment_polls($cid, $id)
{
    global $_CONF, $_TABLES, $_USER;

    $retval = '';

    $has_editPermissions = SEC_hasRights ('polls.edit');
    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['polltopics']} WHERE pid = '{$id}'");
    $A = DB_fetchArray ($result);

    if ($has_editPermissions && SEC_hasAccess ($A['owner_id'],
            $A['group_id'], $A['perm_owner'], $A['perm_group'],
            $A['perm_members'], $A['perm_anon']) == 3) {
        CMT_deleteComment($cid, $id, 'polls');
        $retval .= COM_refresh ($_CONF['site_url']
                                 . "/polls/index.php?pid=$id&amp;aid=-1");
    } else {
        COM_errorLog ("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) "
                    . "tried to illegally delete comment $cid from poll $id");
        $retval .= COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    return $retval;
}


/**
* Helper function: count number of polls and total number of votes
*
* @return   array(number of polls, number of votes);
*
*/
function POLLS_countPollsAndVotes ()
{
    global $_TABLES;

    $total_polls = 0;
    $total_answers = 0;

    $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['polltopics']}" . COM_getPermSQL ());
    $A = DB_fetchArray($result);
    $total_polls = $A['count'];

    $result = DB_query ("SELECT pid FROM {$_TABLES['polltopics']}" . COM_getPermSQL ());
    $nrows = DB_numRows ($result);
    if ($nrows > 0) {
        $topics = '';
        for ($i = 1; $i <= $nrows; $i++) {
            $A = DB_fetchArray($result);
            if ($i > 1) {
                $topics .= ',';
            }
            $topics .= "'" . $A['pid'] . "'";
        }
        $result = DB_query ("SELECT SUM(votes) FROM {$_TABLES['pollanswers']} WHERE pid IN ({$topics})");
        $A = DB_fetchArray($result, true);
        $total_answers = $A[0];
    }

    return array ($total_polls, $total_answers);
}

/**
* Shows the statistics for the Polls plugin on stats.php.
* If $showsitestats is 1 then we are to only print the overall stats in the
* 'site statistics box' otherwise we show the detailed stats
*
* @param    int     showsitestate   Flag to let us know which stats to get
*/
function plugin_showstats_polls ($showsitestats)
{
    global $_CONF, $_TABLES, $LANG_POLLS;

    require_once ($_CONF['path_system'] . 'lib-admin.php');

    $retval = '';

    $result = DB_query ("SELECT pid,topic,voters FROM {$_TABLES['polltopics']} WHERE (voters > 0)" . COM_getPermSQL ('AND') . " ORDER BY voters DESC LIMIT 10");
    $nrows  = DB_numRows ($result);

    if ($nrows > 0) {
        $header_arr = array(
            array('text'         => $LANG_POLLS['stats_topics'],
                  'field'        => 'pid',
                  'header_class' => 'stats-header-title'
            ),
            array('text'         => $LANG_POLLS['stats_votes'],
                  'field'        => 'voters',
                  'header_class' => 'stats-header-count',
                  'field_class'  => 'stats-list-count'
            ),
        );
        $data_arr = array();
        $text_arr = array('has_menu' => false,
                          'title'    => $LANG_POLLS['stats_top10'],
        );
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray ($result);
            $url = $_CONF['site_url'] . '/polls/index.php?pid=' . $A['pid']
                 . '&amp;aid=-1';
            $pid = COM_createLink($A['topic'], $url);
            $voters = COM_NumberFormat ($A['voters']);
            $data_arr[] = array ('pid' => $pid, 'voters' => $voters);
        }
        $retval .= ADMIN_simpleList ('', $header_arr, $text_arr, $data_arr);
    } else {
        $retval .= COM_startBlock ($LANG_POLLS['stats_top10']);
        $retval .= $LANG_POLLS['stats_none'];
        $retval .= COM_endBlock ();
    }

    return $retval;
}

/**
* New stats plugin API function for proper integration with the site stats
*
* @return   array(item text, item count);
*
*/
function plugin_statssummary_polls ()
{
    global $LANG_POLLS;

    list($total_polls, $total_answers) = POLLS_countPollsAndVotes ();

    $item_count = COM_numberFormat ($total_polls)
                . ' (' . COM_numberFormat ($total_answers) . ')';

    return array ($LANG_POLLS['stats_summary'], $item_count);
}


/**
* This will put an option for polls in the command and control block on
* moderation.php
*
*/
function plugin_cclabel_polls()
{
    global $_CONF, $LANG_POLLS;

    if (SEC_hasRights ('polls.edit')) {
        return array ($LANG_POLLS['polls'],
                $_CONF['site_admin_url'] . '/plugins/polls/index.php',
                plugin_geticon_polls ());
    }

    return false;
}


/**
* returns the administrative option for this plugin
*
*/
function plugin_getadminoption_polls()
{
    global $_CONF, $_TABLES, $LANG_POLLS;

    if (SEC_hasRights ('polls.edit')) {
        $result = DB_query ("SELECT COUNT(*) AS cnt FROM {$_TABLES['polltopics']}" . COM_getPermSQL ());
        $A = DB_fetchArray ($result);
        $total_pages = $A['cnt'];

        return array ($LANG_POLLS['polls'],
                      $_CONF['site_admin_url'] . '/plugins/polls/index.php',
                      $total_pages);
    }
}


/**
* A user is about to be deleted. Update ownership of any polls owned
* by that user or delete them.
*
* @param   uid   int   User id of deleted user
*
*/
function plugin_user_delete_polls ($uid)
{
    global $_TABLES, $_PO_CONF;

    if (DB_count ($_TABLES['polltopics'], 'owner_id', $uid) == 0) {
        // there are no polls owned by this user
        return;
    }

    if ($_PO_CONF['delete_polls'] == 1) {
        // delete the polls
        $result = DB_query ("SELECT pid FROM {$_TABLES['polltopics']} WHERE owner_id = $uid");
        $numPolls = DB_numRows ($result);
        for ($i = 0; $i < $numPolls; $i++) {
            list($pid) = DB_fetchArray($result);
            DB_delete($_TABLES['pollanswers'], 'pid', $pid);
            DB_delete($_TABLES['pollvoters'], 'pid', $pid);
            DB_delete($_TABLES['comments'], array('sid', 'type'),
                                            array($pid, 'polls'));
        }
        DB_delete($_TABLES['polltopics'], 'owner_id', $uid);
    } else {
        // assign ownership to a user from the Root group
        $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id',
                                 "grp_name = 'Root'");
        $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
        list($rootuser) = DB_fetchArray ($result);

        DB_query ("UPDATE {$_TABLES['polltopics']} SET owner_id = $rootuser WHERE owner_id = $uid");
    }
}

/**
* Return the current version of code.
* Used in the Plugin Editor to show the registered version and code version
*/
function plugin_chkVersion_polls()
{
    global $_CONF;

    require_once $_CONF['path'] . 'plugins/polls/autoinstall.php';          

    $inst_parms = plugin_autoinstall_polls('polls'); 

    return $inst_parms['info']['pi_version'];
}

/**
* Geeklog informs us that we're about to be enabled or disabled
*
* @param    boolean     $enable     true = we're being enabled, false = disabled
* @return   void
*
*/
function plugin_enablestatechange_polls ($enable)
{
    global $_TABLES;

    $is_enabled = $enable ? 1 : 0;

    // toggle Poll block
    DB_query ("UPDATE {$_TABLES['blocks']} SET is_enabled = $is_enabled WHERE (type = 'phpblock') AND (phpblockfn = 'phpblock_polls')");
}

/**
* Automatic uninstall function for plugins
*
* @return   array
*
* This code is automatically uninstalling the plugin.
* It passes an array to the core code function that removes
* tables, groups, features and php blocks from the tables.
* Additionally, this code can perform special actions that cannot be
* foreseen by the core code (interactions with other plugins for example)
*
*/
function plugin_autouninstall_polls ()
{
    $out = array (
        /* give the name of the tables, without $_TABLES[] */
        'tables' => array('pollanswers','polltopics','pollvoters','pollquestions'),
        /* give the full name of the group, as in the db */
        'groups' => array('Polls Admin'),
        /* give the full name of the feature, as in the db */
        'features' => array('polls.edit'),
        /* give the full name of the block, including 'phpblock_', etc */
        'php_blocks' => array('phpblock_polls'),
        /* give all vars with their name */
        'vars'=> array()
    );
    return $out;
}

/**
* Get path for the template files.
*
* @param    string  $path   subdirectory within the base template path
* @return   string          full path to template directory
*
*/
function polls_templatePath ($path = '')
{
    global $_CONF;

    if (empty ($path)) {
        $layout_path = $_CONF['path_layout'] . polls;
    } else {
        $layout_path = $_CONF['path_layout'] . polls . '/' . $path;
    }

    if (is_dir ($layout_path)) {
        $retval = $layout_path;
    } else {
        $retval = $_CONF['path'] . 'plugins/polls/templates';
        if (!empty ($path)) {
            $retval .= '/' . $path;
        }
    }

    return $retval;
}


/**
* Shows a poll form
*
* Shows an HTML formatted poll for the given topic ID
*
* @param      string      $pid      ID for poll topic
* @param      boolean     $showall  Show only the first question in the poll or all?
* @param        int        $displaytype       Possible values 0 = Normal, 1 = In Block, 2 = autotag
* @see function COM_pollResults
* @see function COM_showPoll
* @return       string  HTML Formatted Poll
*
*/
function POLLS_pollVote($pid, $showall = true, $displaytype = 0, $order = '', $mode = '', $page = 1)
{
    global $_CONF, $_TABLES, $_USER, $LANG_POLLS, $LANG01, $LANG25,
           $_IMAGE_TYPE;

    $retval = '';

    $result = DB_query("SELECT topic,voters,commentcode,is_open,hideresults,owner_id "
        . ",group_id,perm_owner,perm_group,perm_anon,perm_members "
        . "FROM {$_TABLES['polltopics']} WHERE pid='$pid'" . COM_getPermSql('AND'));
    $ntopics = DB_numRows($result);

    if ($ntopics == 0) {
        return $retval;
    }

    $P = DB_fetchArray($result);
    
    if ((!isset($_COOKIE[$pid]) && !POLLS_ipAlreadyVoted($pid)) or ($P['is_open'] == 1)) {
        if ($ntopics == 1) {
            $questions_sql = "SELECT question,qid "
                . "FROM {$_TABLES['pollquestions']} "
                . "WHERE pid='$pid' ORDER BY qid";

            $questions = DB_query($questions_sql);
            $nquestions = DB_numRows($questions );

            if ($nquestions > 0) {
                $poll = new Template($_CONF['path']
                                     . 'plugins/polls/templates/');
                $poll->set_file(array('panswer'    => 'pollanswer.thtml',
                                      'block'      => 'pollblock.thtml',
                                      'pquestions' => 'pollquestions.thtml',
                                      'comments'   => 'pollcomments.thtml'));
                $poll->set_var('xhtml', XHTML);
                $poll->set_var('site_url', $_CONF['site_url']);
                $poll->set_var('site_admin_url', $_CONF['site_admin_url']);
                $poll->set_var('layout_url', $_CONF['layout_url']);
                $poll->set_var('poll_id', $pid );
                $poll->set_var('poll_topic', $P['topic'] );
                $poll->set_var('num_votes', COM_numberFormat($P['voters']));
                $poll->set_var('poll_vote_url', $_CONF['site_url']
                                                . '/polls/index.php');
                if (($nquestions == 1) || $showall) {
                    $poll->set_var('lang_vote', $LANG_POLLS['vote']);
                } else {
                    $poll->set_var('lang_vote', $LANG_POLLS['start_poll']);
                }
                $poll->set_var('lang_votes', $LANG_POLLS['votes']);

                $results = '';
                if (($P['is_open'] == 0) || ($P['hideresults'] == 0) ||
                    (($P['hideresults'] == 1) &&
                        (
                        SEC_inGroup('Root') ||
                        (isset($_USER['uid'])
                            && ($_USER['uid'] == $P['owner_id']))
                        ))) {
                    $results = COM_createLink($LANG_POLLS['results'],
                        $_CONF['site_url'] . '/polls/index.php?pid=' . $pid
                        . '&amp;aid=-1');
                }
                $poll->set_var('poll_results', $results);

                $access = SEC_hasAccess($P['owner_id'], $P['group_id'],
                                $P['perm_owner'], $P['perm_group'],
                                $P['perm_members'], $P['perm_anon']);
                if (($access == 3) && SEC_hasRights('polls.edit')) {
                    $editlink = COM_createLink($LANG25[27], $_CONF['site_admin_url']
                        . '/plugins/polls/index.php?mode=edit&amp;pid=' . $pid);
                    $poll->set_var('edit_link', $editlink);
                    $editicon = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
                    $icon_attr = array('title' => $LANG25[27]);
                    $editiconhtml = COM_createImage($editicon, $LANG25[27], $icon_attr);
                    $editlink = COM_createLink($editiconhtml, $_CONF['site_admin_url']
                        . '/plugins/polls/index.php?mode=edit&amp;pid=' . $pid);
                    $poll->set_var('edit_icon', $editlink);
                }

                if (array_key_exists('aid', $_POST)) {
                    $aid = $_POST['aid'];
                } else {
                    $aid = array();
                }

                for ($j = 0; $j < $nquestions; $j++) {
                    $Q = DB_fetchArray($questions);
                    $poll->set_var('poll_question', $Q['question']);
                    $poll->set_var('question_id', $j);

                    $notification = '';
                    $filter = '';
                    if (!$showall) {
                        $nquestions--;
                        if ($nquestions > 0) {
                            $notification = $LANG25[35] . " $nquestions "
                                          . $LANG25[36];
                        }
                        $filter = "AND qid='0'";
                        $nquestions = 1;
                    } else {
                        $filter = "AND qid = '{$Q['qid']}'";
                        $poll->set_var('lang_question_number', " ". ($j+1).":");
                    }
                    $answer_sql = "SELECT answer,aid "
                        . "FROM {$_TABLES['pollanswers']} "
                        . "WHERE pid='$pid'$filter ORDER BY qid, aid";
                    $answers = DB_query($answer_sql);
                    $nanswers = DB_numRows($answers );
                    for($i=0; $i<$nanswers; $i++) {
                        $A = DB_fetchArray($answers );
                        if (($j < count($aid)) && ($aid[$j] == $A['aid'])) {
                            $poll->set_var('selected', ' checked');
                        }
                        $poll->set_var('answer_id', $A['aid']);
                        $poll->set_var('answer_text', $A['answer']);
                        $poll->parse('poll_answers', 'panswer', true);
                        $poll->clear_var('selected');
                    }
                    $poll->parse('poll_questions', 'pquestions', true);
                    $poll->clear_var('poll_answers');
                }
                if ($nquestions > 1) {
                    $poll->set_var('poll_topic', $LANG25['34'] . " " . $P['topic']);
                    $poll->set_var('lang_question', $LANG25[31]);
                }
                $poll->set_var('lang_polltopics', $LANG_POLLS['polltopics']);
                $poll->set_var('poll_notification', $notification);
                if($P['commentcode'] >= 0 ) {
                    $num_comments = DB_count($_TABLES['comments'],
                            array('sid', 'type'), array($pid, 'polls'));
                    $poll->set_var('num_comments',
                            COM_numberFormat($num_comments));
                    $poll->set_var('lang_comments', $LANG01[3]);
                    $poll->set_var('poll_comments_url', $_CONF['site_url'] .
                        '/polls/index.php?pid=' . $pid . '#comments');
                    $poll->parse('poll_comments', 'comments', true);
                } else {
                    $poll->set_var('poll_comments', '');
                    $poll->set_var('poll_comments_url', '');
                }
                $retval =  $poll->finish($poll->parse('output', 'block')) . LB;

                if ($showall && ($P['commentcode'] >= 0 AND $displaytype != 2)) {
                    $delete_option = (SEC_hasRights('polls.edit') &&
                        SEC_hasAccess($P['owner_id'], $P['group_id'],
                        $P['perm_owner'], $P['perm_group'], $P['perm_members'],
                        $P['perm_anon']) == 3 ? true : false);

                    require_once $_CONF['path_system'] . 'lib-comment.php';

                    $retval .= CMT_userComments($pid, $P['topic'], 'polls',
                                                $order, $mode, 0, $page, false,
                                                $delete_option, $P['commentcode']);
                }
            }
        }
    } else {
        $retval .= POLLS_pollResults($pid, 0, '', '', 1, $displaytype);
    }

    return $retval;
}

/**
* This shows a poll
*
* This will determine if a user needs to see the poll form OR the poll result.
*
* @param        int     $size           Size in pixels of poll results
* @param        string  $pid            Poll topic ID to show (optional)
* @param        boolean $showall        Show only the first question or all
* @param        int     $displaytype    Possible values 0 = Normal, 1 = In Block, 2 = autotag 
* @return       string  HTML formatted string of poll
* @see function COM_pollVote
* @see function COM_pollResults
*
*/
function POLLS_showPoll($size, $pid = '', $showall = false, $displaytype = 0)
{
    global $_CONF, $_TABLES, $_PO_CONF, $LANG_POLLS;

    $retval = '';

    DB_query("DELETE FROM {$_TABLES['pollvoters']} WHERE date < UNIX_TIMESTAMP() - {$_PO_CONF['polladdresstime']}");

    if (!empty($pid)) {
        $Q['is_open'] = DB_getItem($_TABLES['polltopics'], 'is_open', "pid = '".$pid."'");

        if (($displaytype == 2) && ($Q['is_open'] == 0)) {
            $retval = '<div class="poll-autotag-message">'
                    . $LANG_POLLS['pollclosed'] . '</div>';
        }        
        if (!isset($_COOKIE['poll-' . $pid]) && !POLLS_ipAlreadyVoted($pid) &&
                ($Q['is_open'] == 1)) {
            $retval .= POLLS_pollVote($pid, $showall, $displaytype);
        } else {
            $retval .= POLLS_pollResults($pid, $size, '', '', 1, $displaytype);
        }
    } else {
        $result = DB_query("SELECT pid,topic,is_open FROM {$_TABLES['polltopics']} WHERE display = 1" . COM_getPermSql('AND') . " ORDER BY created DESC");
        $nrows = DB_numRows($result);

        $title = DB_getItem($_TABLES['blocks'], 'title', "name='poll_block'");

        if ($nrows > 0) {
            for ($i = 1; $i <= $nrows; $i++) {
                $Q = DB_fetchArray($result);
                $pid = $Q['pid'];
                if ($displaytype == 1) { // in the poll block
                    $showall = false;
                } else { // assume we're in polls/index.php
                    $retval .= COM_startBlock($title);
                    $showall = true;
                }

                if (!isset($_COOKIE['poll-' . $pid]) &&
                        !POLLS_ipAlreadyVoted($pid) && ($Q['is_open'] == 1)) {
                    $retval .= POLLS_pollVote($pid, $showall, $displaytype);
                } else {
                    $retval .= POLLS_pollResults($pid, $size, '', '', 1,
                                                 $displaytype);
                }

                if ($displaytype == 1) { // in the poll block
                    if (($i < $nrows) && !empty($retval)) {
                        $retval .= '<div class="poll-divider"></div>';
                    }
                } else {
                    $retval .= COM_endBlock();
                }
            }
        }
    }

    return $retval;
}

/**
* Saves a user's vote
*
* Saves the users vote, if allowed for the poll $pid.
* NOTE: all data comes from form post
*
* @param    string   $pid   poll id
* @param    array    $aid   selected answers
* @return   string   HTML for poll results
*
*/
function POLLS_pollsave($pid, $aid)
{
    global $_TABLES, $LANG_POLLS;

    $retval = '';

    if (POLLS_ipAlreadyVoted ($pid)) {
        exit;
    }

    DB_change($_TABLES['polltopics'],'voters',"voters + 1",'pid',$pid,'',true);
    // This call to DB-change will properly supress the insertion of quotes around $value in the sql
    $answers = count($aid);
    for ($i = 0; $i < $answers; $i++) {
        DB_change(
            $_TABLES['pollanswers'],
            'votes',
            "votes + 1",
            array('pid', 'qid', 'aid'),
            array($pid,  $i,    COM_applyFilter($aid[$i], true)),
            '',
            true
        );
    }

    // This always does an insert so no need to provide key_field and key_value args
    DB_query("INSERT INTO {$_TABLES['pollvoters']} (ipaddress,date,pid) VALUES ('{$_SERVER['REMOTE_ADDR']}'," . time() . ",'$pid')");
    $retval .= COM_startBlock ($LANG_POLLS['savedvotetitle'], '',
                       COM_getBlockTemplate ('_msg_block', 'header'))
        . $LANG_POLLS['savedvotemsg'] . ' "'
        . DB_getItem ($_TABLES['polltopics'], 'topic', "pid = '{$pid}'")
        . '"'
        . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'))
        . POLLS_pollResults($pid);

    return $retval;
}

/**
* Shows the results of a poll
*
* Shows the poll results for a given poll topic
*
* @param        string      $pid        ID for poll topic to show
* @param        int         $scale      Size in pixels to scale formatted results to
* @param        string      $order      'ASC' or 'DESC' for Comment ordering (SQL statment ordering)
* @param        string      $mode       Comment Mode possible values 'nocomment', 'flat', 'nested', 'threaded'
* @param        int        $displaytype       Possible values 0 = Normal, 1 = In Block, 2 = autotag
* @see POLLS_pollVote
* @see POLLS_showPoll
* @return     string   HTML Formated Poll Results
*
*/
function POLLS_pollResults($pid, $scale=400, $order='', $mode='', $page = 1, $displaytype = 0)
{
    global $_CONF, $_TABLES, $_USER, $_IMAGE_TYPE,
           $_PO_CONF, $LANG01, $LANG_POLLS, $_COM_VERBOSE, $LANG25;

    $retval = '';
    $topic_sql = "SELECT topic,voters,is_open,hideresults,commentcode,owner_id,group_id,"
        . "perm_owner,perm_group,perm_members,perm_anon "
        . "FROM {$_TABLES['polltopics']} WHERE pid='$pid'";
    $result = DB_query($topic_sql);
    $P = DB_fetchArray($result);

    if(SEC_hasAccess($P['owner_id'], $P['group_id'], $P['perm_owner'],
        $P['perm_group'], $P['perm_members'], $P['perm_anon']) == 0 ) {
        return $retval;
    }

    if ((
            $P['hideresults'] == 0
        ) || (
            ($P['hideresults'] == 1) && (isset($_USER['uid']) &&
                                         ($_USER['uid'] == $P['owner_id']))
        ) || (
            ($P['hideresults'] == 1) && (SEC_inGroup('Root'))
        )
    ) {
        $retval = '';
    } else {
        if ($displaytype == 2) {
            $retval = '<div class="poll-autotag-message">' . $LANG_POLLS['pollhidden']. "</div>";
        }
        
        return $retval;
    }
    
    $ntopic = DB_numRows($result);
    if ($ntopic == 1) {
        $questions_sql = "SELECT qid,pid,question "
            . "FROM {$_TABLES['pollquestions']} "
            . "WHERE pid='$pid' "
            . "ORDER BY qid";
        $questions = DB_query ($questions_sql);
        $nquestions = DB_numRows($questions);

        if ($_COM_VERBOSE) {
            COM_errorLog("got $questions questions in COM_pollResults", 1 );
        }

        if ($nquestions > 0){
            $poll = new Template($_CONF['path'] . 'plugins/polls/templates/' );
            $poll->set_file(array('result' => 'pollresult.thtml',
                'question' => 'pollquestion.thtml',
                'comments' => 'pollcomments.thtml',
                'votes_bar' => 'pollvotes_bar.thtml',
                'votes_num' => 'pollvotes_num.thtml' ));
            $poll->set_var('xhtml', XHTML);
            $poll->set_var('site_url', $_CONF['site_url']);
            $poll->set_var('site_admin_url', $_CONF['site_admin_url']);
            $poll->set_var('layout_url', $_CONF['layout_url']);
            $poll->set_var('poll_topic', $P['topic']);
            $poll->set_var('poll_id', $pid);
            $poll->set_var('num_votes', COM_numberFormat($P['voters']));
            $poll->set_var('lang_votes', $LANG_POLLS['votes']);
            $access = SEC_hasAccess($P['owner_id'], $P['group_id'],
                            $P['perm_owner'], $P['perm_group'],
                            $P['perm_members'], $P['perm_anon']);
            if (($access == 3) && SEC_hasRights('polls.edit')) {
                $editlink = COM_createLink($LANG25[27], $_CONF['site_admin_url']
                    . '/plugins/polls/index.php?mode=edit&amp;pid=' . $pid );
                $poll->set_var('edit_link', $editlink);
                $editicon = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
                $icon_attr = array('title' => $LANG25[27]);
                $editiconhtml = COM_createImage($editicon, $LANG25[27], $icon_attr);
                $editlink = COM_createLink($editiconhtml, $_CONF['site_admin_url']
                    . '/plugins/polls/index.php?mode=edit&amp;pid=' . $pid );
                $poll->set_var('edit_icon', $editlink);
            }
            if ($_PO_CONF['answerorder'] == 'voteorder'){
                $answerorder = "votes DESC";
            } else {
                $answerorder = "aid";
            }

            for ($j = 0; $j < $nquestions; $j++) {
                $Q = DB_fetchArray($questions);

                if ($nquestions >= 1) {
                    $counter = ($j + 1) . "/$nquestions: " ;
                }
                $poll->set_var('poll_question', $counter . $Q['question']);

                $answer_sql = "SELECT votes,answer,remark "
                    . "FROM {$_TABLES['pollanswers']} "
                    . "WHERE pid='$pid' and qid='{$Q['qid']}' "
                    . "ORDER BY $answerorder";
                $answers = DB_query ($answer_sql);
                $nanswers = DB_numRows($answers);

                $a_summ_sql = "SELECT SUM(votes) as votesumm FROM {$_TABLES['pollanswers']} "
                    . "WHERE pid='$pid' and qid='{$Q['qid']}' "
                    . "GROUP BY qid";
                $a_summ = DB_query ($a_summ_sql);
                $S = DB_fetchArray($a_summ);

                if ($_COM_VERBOSE) {
                    COM_errorLog("got $answers answers in COM_pollResults", 1 );
                }
                for ($i=1; $i<=$nanswers; $i++) {
                    $A = DB_fetchArray($answers);
                    if ($S['votesumm'] == 0) {
                        $percent = 0;
                    } else {
                        $percent = $A['votes'] / $S['votesumm'];
                    }
                    $poll->set_var('cssida', 1);
                    $poll->set_var('cssidb', 2);
                    $poll->set_var('answer_text', $A['answer']);
                    $poll->set_var('remark_text', $A['remark']);
                    $poll->set_var('answer_counter', $i);
                    $poll->set_var('answer_odd', (($i - 1) % 2));
                    $poll->set_var('answer_num', COM_numberFormat($A['votes']));
                    $poll->set_var('answer_percent',
                                    sprintf('%.2f', $percent * 100));
                    if ($scale < 120) {
                        $poll->parse('poll_votes', 'votes_num', true );
                    } else {
                        $width = (int)($percent * $scale);
                        $poll->set_var('bar_width', $width);
                        $poll->parse('poll_votes', 'votes_bar', true);
                    }
                }
                $poll->parse('poll_questions', 'question', true);
                $poll->clear_var('poll_votes');
                if (($scale < 100) && ($j < 1)) {
                    $url = $_CONF['site_url'] . "/polls/index.php?pid=$pid";
                    $poll->set_var('notification', COM_createLink($LANG25[40], $url). "<br" . XHTML . ">");
                    break;
                }
            }

            if($P['commentcode'] >= 0 ) {
                $num_comments = DB_count($_TABLES['comments'],
                        array('sid', 'type' ), array($pid, 'polls' ));
                $poll->set_var('num_comments',
                        COM_numberFormat($num_comments));
                $poll->set_var('lang_comments', $LANG01[3]);
                $poll->set_var('poll_comments_url', $_CONF['site_url'] .
                        '/polls/index.php?pid=' . $pid . '#comments');
                $poll->parse('poll_comments', 'comments', true);
            } else {
                $poll->set_var('poll_comments_url', '');
                $poll->set_var('poll_comments', '');
            }

            $poll->set_var('lang_polltopics', $LANG_POLLS['polltopics'] );

            $retval .= $poll->finish($poll->parse('output', 'result' ));

            if($scale > 399 && $P['commentcode'] >= 0 && $displaytype != 2) {
                $delete_option = (SEC_hasRights('polls.edit') &&
                    SEC_hasAccess($P['owner_id'], $P['group_id'],
                    $P['perm_owner'], $P['perm_group'], $P['perm_members'],
                    $P['perm_anon']) == 3 ? true : false);
                require_once $_CONF['path_system'] . 'lib-comment.php';
                $retval .= CMT_userComments($pid, $P['topic'], 'polls',
                                            $order, $mode, 0, $page, false,
                                            $delete_option, $P['commentcode']);
            }
        }
    }

    return $retval;
}

/**
* Check if we already have a vote from this IP address
*
* @param    string  $pid    Poll ID
* @param    string  $ip     (optional) IP address
* @return   boolean         true: IP already voted; false: didn't
*
*/
function POLLS_ipAlreadyVoted($pid, $ip = '' )
{
    global $_TABLES;

    $retval = false;

    if(empty($ip )) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    if(DB_count($_TABLES['pollvoters'],
                 array('ipaddress', 'pid'),
                 array($ip, $pid)) > 0) {
        $retval = true;
    }

    return $retval;
}

/**
* Display the current poll(s) in a side block
*
* @return   string  HTML for the poll(s) to be displayed (or an empty string)
*
*/
function phpblock_polls()
{
    return POLLS_showPoll(60, '', false, 1);
}


/**
* Returns the URL of the plugin's icon
*
* @return   string      URL of the icon
*
*/
function plugin_geticon_polls ()
{
    global $_CONF;
    return $_CONF['site_url'] . '/polls/images/polls.png';
}

/**
* Plugin should display [a] comment[s]
*
* @param   string  $id     Unique idenifier for item comment belongs to
* @param   int     $cid    Comment id to display (possibly including sub-comments)
* @param   string  $title  Page/comment title
* @param   string  $order  'ASC' or 'DESC' or blank
* @param   string  $format 'threaded', 'nested', or 'flat'
* @param   int     $page   Page number of comments to display
* @param   boolean $view   True to view comment (by cid), false to display (by $pid)
* @return  mixed   results of calling the plugin_displaycomment_ function
*/
function plugin_displaycomment_polls ($id, $cid, $title, $order, $format, $page, $view)
{
    global $_TABLES, $LANG_ACCESS, $LANG_POLLS;

    $retval = '';

    $sql = "SELECT COUNT(*) AS count, commentcode, owner_id, group_id, perm_owner, "
        . "perm_group, perm_members, perm_anon "
        . "FROM {$_TABLES['polltopics']} "
        . "WHERE (pid = '$id')" . COM_getPermSQL('AND')
        . ' GROUP BY pid';
    $result = DB_query ($sql);
    $A = DB_fetchArray ($result);
    $allowed = $A['count'];

    if ($allowed == 1) {
        $delete_option = (SEC_hasRights ('polls.edit') &&
                (SEC_hasAccess ($A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon']) == 3));
        $retval .= CMT_userComments ($id, $title, 'polls', $order, $format,
                                     $cid, $page, $view, $delete_option,
                                     $A['commentcode']);
    } else {
        $retval .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                        COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG_POLLS['deny_msg']
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    return $retval;
}

function plugin_getListField_polls($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG25, $LANG_ACCESS, $_USER;

    $retval = '';

    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
                             $A['perm_owner'], $A['perm_group'],
                             $A['perm_members'], $A['perm_anon']);
    if ($access > 0) {
        switch($fieldname) {
            case 'edit':
                if ($access == 3) {
                    $retval = COM_createLink($icon_arr['edit'],
                        "{$_CONF['site_admin_url']}/plugins/polls/index.php?mode=edit&amp;pid={$A['pid']}");
                }
                break;
            case 'unixdate':
                $retval = strftime ($_CONF['daytime'], $A['unixdate']);
                break;
            case 'topic':
                if (($A['hideresults'] == 0) ||
                    (isset($_USER['uid']) && ($_USER['uid'] == $A['owner_id'])) || SEC_inGroup('Root')) {
                    $retval = COM_createLink($fieldvalue,
                        "{$_CONF['site_url']}/polls/index.php?pid={$A['pid']}");
                } else {
                    $retval = $fieldvalue;
                }
                break;
            case 'access':
                if ($access == 3) {
                    $access = $LANG_ACCESS['edit'];
                } else {
                    $access = $LANG_ACCESS['readonly'];
                }
                $retval = $access;
                break;
            case 'is_open':
                if ($A['is_open'] == 1) {
                    $retval = $LANG25[25];
                } else {
                    $retval = $LANG25[26];
                }
                break;
            case 'display':
                if ($A['display'] == 1) {
                    $retval = $LANG25[25];
                } else {
                    $retval = $LANG25[26];
                }
                break;
            case 'voters':
                $retval = COM_numberFormat ($A['voters']);
                break;
            default:
                $retval = $fieldvalue;
                break;
        }
    } else {
        $retval = false;
    }

    return $retval;
}

/**
* Set template variables
*
* @param    string  $templatename   name of template, e.g. 'header'
* @param    ref     $template       reference of actual template
* @return   void
*
* Note: A plugin should use its name as a prefix for the names of its
* template variables, e.g. 'polls_xxx' and 'lang_polls_xxx'.
* 'button_polls' is an exception, as such a variable existed for header.thtml
* in Geeklog 1.3.11 and earlier, where the Polls were an integral part
* of Geeklog. It is added here for backward-compatibility.
*
*/
function plugin_templatesetvars_polls ($templatename, &$template)
{
    global $LANG_POLLS;

    if (($templatename == 'header') || ($templatename == 'footer')) {
        $template->set_var ('button_polls', $LANG_POLLS['polls']);
    }
}

function plugin_getheadercode_polls()
{
    global $_CONF;

    $str = null;
    $str = LB . '<link rel="stylesheet" type="text/css" href="'
        . $_CONF['site_url'] . '/polls/style.css"' . XHTML . '>';

    return $str;
}

/**
* Update the Polls plugin
*
* @return   int     Number of message to display (true = generic success msg)
*
*/
function plugin_upgrade_polls()
{
    global $_CONF, $_TABLES, $_DB_dbms;

    $installed_version = DB_getItem($_TABLES['plugins'], 'pi_version',
                                    "pi_name = 'polls'");
    $code_version = plugin_chkVersion_polls();
    if ($installed_version == $code_version) {
        // nothing to do
        return true;
    }

    require_once $_CONF['path'] . 'plugins/polls/autoinstall.php';

    if (! plugin_compatible_with_this_version_polls('polls')) {
        return 3002;
    }

    $inst_parms = plugin_autoinstall_polls('polls');
    $pi_gl_version = $inst_parms['info']['pi_gl_version'];

    require_once $_CONF['path'] . 'plugins/polls/sql/'
                                . $_DB_dbms . '_updates.php';

    $current_version = $installed_version;
    $done = false;
    while (! $done) {
        switch ($current_version) {
        case '2.0.1':
            $current_version = '2.0.2';
            break;

        case '2.0.2':
            $current_version = '2.1.0';
            break;

        case '2.1.0':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }
            
            update_ConfValues_2_1_0();            
            
            $current_version = '2.1.1';
            break;

        case '2.1.1':
            if (isset($_UPDATES[$current_version])) {
                $_SQL = $_UPDATES[$current_version];
                foreach ($_SQL as $sql) {
                    DB_query($sql);
                }
            }

            update_ConfValues_2_1_1();
            
            $current_version = '2.1.2';
            break;

        default:
            $done = true;
        }
    }

    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '$code_version', pi_gl_version = '$pi_gl_version' WHERE pi_name = 'polls'");

    return true;
}

/**
* Called during site migration - handle changed URLs or paths
*
* @param    array   $old_conf   contents of the $_CONF array on the old site
* @param    boolean             true on success, otherwise false
*
*/
function plugin_migrate_polls($old_conf)
{
    global $_CONF;

    $tables = array(
        'pollanswers'   => 'aid, answer',
        'pollquestions' => 'qid, question',
        'polltopics'    => 'pid, topic'
    );

    if ($old_conf['site_url'] != $_CONF['site_url']) {
        INST_updateSiteUrl($old_conf['site_url'], $_CONF['site_url'], $tables);
    }

    return true;
}

/**
* Return information for a poll                                                                                                                     
*
* @param    string  $pid        poll ID or '*'
* @param    string  $what       comma-separated list of properties
* @param    int     $uid        user ID or 0 = current user
* @param    array   $options    (reserved for future extensions)
* @return   mixed               string or array of strings with the information
*
*/
function plugin_getiteminfo_polls($pid, $what, $uid = 0, $options = array())
{
    global $_CONF, $_TABLES, $_USER;
    
    // parse $what to see what we need to pull from the database
    $properties = explode(',', $what);
    $fields = array();
    foreach ($properties as $p) {
        switch ($p) {
        case 'date-modified':
            $fields[] = 'UNIX_TIMESTAMP(modified) AS unixdate';
            break;
        case 'id':
            $fields[] = 'pid';
            break;
        case 'title':
            $fields[] = 'topic';
            break;
        case 'url':
            // needed for $pid == '*', but also in case we're only requesting
            // the URL (so that $fields isn't emtpy)
            $fields[] = 'pid';
            $fields[] = 'hideresults';

            break;
        default:
            // nothing to do
            break;
        }
    }

    $fields = array_unique($fields);

    if (count($fields) == 0) {
        $retval = array();

        return $retval;
    }

    // prepare SQL request
    if ($pid == '*') {
        $where = '';
        $permOp = 'WHERE';
    } else {
        $where = " WHERE pid = '" . addslashes($pid) . "'";
        $permOp = 'AND';
    }
    if ($uid > 0) {
        $permSql = COM_getPermSql($permOp, $uid);
    } else {
        $permSql = COM_getPermSql($permOp);
    }
    $sql = "SELECT " . implode(',', $fields)
            . " FROM {$_TABLES['polltopics']}" . $where . $permSql;
    if ($pid != '*') {
        $sql .= ' LIMIT 1';
    }

    $result = DB_query($sql);
    $numRows = DB_numRows($result);

    $retval = array();
    for ($i = 0; $i < $numRows; $i++) {
        $A = DB_fetchArray($result);

        $props = array();
        foreach ($properties as $p) {
            switch ($p) {
            case 'date-modified':
                $props['date-modified'] = $A['unixdate'];
                break;
            case 'id':
                $props['id'] = $A['pid'];
                break;
            case 'title':
                $props['title'] = $A['topic'];
                break;
            case 'url':
                if (empty($A['pid'])) {
                    $props['url'] = $_CONF['site_url']
                                  . '/polls/index.php?pid=' . $pid
                                  . '&amp;aid=-1';
                } else {
                    if (COM_isAnonUser()) {
                        $userid = 1;
                    } else {
                        $userid = $_USER['uid'];
                    }                    
                    // Users who have already voted but cannot see the results cannot view link
                    if ($userid == 2 || ($userid != 2 && !($A['hideresults'] == 1 && (isset($_COOKIE['poll-' . $A['pid']]) || POLLS_ipAlreadyVoted($A['pid']))))) {
                        $props['url'] = $_CONF['site_url']
                                      . '/polls/index.php?pid=' . $A['pid'];
                                      // . '&amp;aid=-1';
                    }
                }
                break;
            default:
                // return empty string for unknown properties
                $props[$p] = '';
                break;
            }
        }

        $mapped = array();
        foreach ($props as $key => $value) {
            if ($pid == '*') {
                if ($value != '') {
                    $mapped[$key] = $value;
                }
            } else {
                $mapped[] = $value;
            }
        }

        if ($pid == '*') {
            $retval[] = $mapped;
        } else {
            $retval = $mapped;
            break;
        }
    }

    if (($pid != '*') && (count($retval) == 1)) {
        $retval = $retval[0];
    }

    return $retval;
}

/**
* Provide URL of a documentation file
*
* @param    string  $file   documentation file being requested, e.g. 'config'
* @return   mixed           URL or false when not available
*
*/
function plugin_getdocumentationurl_polls($file)
{
    global $_CONF;

    static $docurl;

    switch ($file) {
    case 'index':
    case 'config':
        if (isset($docurl)) {
            $retval = $docurl;
        } else {
            $doclang = COM_getLanguageName();
            $docs = 'docs/' . $doclang . '/polls.html';
            if (file_exists($_CONF['path_html'] . $docs)) {
                $retval = $_CONF['site_url'] . '/' . $docs;
            } else {
                $retval = $_CONF['site_url'] . '/docs/english/polls.html';
            }
            $docurl = $retval;
        }
        break;

    default:
        $retval = false;
        break;
    }

    return $retval;
}

/**
* Provide URL and ID for the link to a comment's parent
*
* @return   array   array consisting of the base URL and the ID name
*
*/
function plugin_getcommenturlid_polls()
{
    global $_CONF;

    $tmp = array(
        $_CONF['site_url'] . '/polls/index.php',
        'pid'
    );

    return $tmp;
}

/**
* Poll Autotags
* [poll: pid] - Displays a link to a poll using the Poll Topic as the title. A alternate title may be specified. 
* [poll_vote: pid pid class:poll-autotag showall:1] - Class and showall not required. Class specifies the css class and Showall if set to 1, shows all questions
* [poll_result: pid class:poll-autotag] - Class not required. Class specifies the css class
*
*/
function plugin_autotags_polls($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES;

    if ($op == 'tagname' ) {
        return array('poll_vote', 'poll_result', 'poll');
    } elseif ($op == 'parse') {
        $pid = COM_applyFilter($autotag['parm1']);
        $showall = false;

        switch ($autotag['tag']) {
        case 'poll':
            if (!empty($autotag['parm2'])) {
                $title = COM_applyFilter($autotag['parm2']);
            } else {
                $title = DB_getItem($_TABLES['polltopics'], 'topic',
                                    "pid = '$pid'");
            }

            $retval = COM_createLink($title, $_CONF['site_url']
                            . '/polls/index.php?pid=' . $pid . '&amp;aid=-1');
            break;

        case 'poll_vote':
        case 'poll_result':
            $px = explode(' ', trim($autotag['parm2']));
            $css_class = "poll-autotag";

            if (is_array($px)) {
                foreach ($px as $part) {
                    if (substr($part, 0, 6) == 'class:') {
                        $a = explode(':', $part);
                        $css_class = $a[1];
                    } elseif (substr($part, 0, 8) == 'showall:') {
                        $a = explode(':', $part);
                        $val = $a[1];
                        if ($val == 1) {
                            $showall = true;
                        }
                    } else {
                        break;
                    }
                }
            }

            if ($autotag['tag'] == 'poll_vote') {
                $retval = POLLS_showPoll(0, $pid, $showall, 2);
            } else {
                $retval = POLLS_pollResults($pid, 0,'', '', 1, 2);
            }
            $retval = '<div class="' . $css_class . '">' . $retval . '</div>';
            break;
        }

        $content = str_replace($autotag['tagstr'], $retval, $content);
    }

    return $content;
}

/**
* Return headlines for New Polls section in the What's New block, if enabled
*
* @return   mixed       array(headline, byline), or boolean false if disabled
*
*/
function plugin_whatsnewsupported_polls()
{
    global $_PO_CONF, $LANG_POLLS, $LANG_WHATSNEW;

    if ($_PO_CONF['hidenewpolls'] == 'hide') {
        $retval = false;
    } else {
        $retval = array($LANG_POLLS['polls'],
                        COM_formatTimeString($LANG_WHATSNEW['new_last'],
                                             $_PO_CONF['newpollsinterval'])
                            );
    }

    return $retval;
}

/**
* Return new Polls for the What's New block
*
* @return   string  HTML list of new staticpages
*
*/
function plugin_getwhatsnew_polls()
{
    global $_CONF, $_TABLES, $_PO_CONF, $LANG_POLLS, $_USER;

    $retval = '';
    if ($_PO_CONF['hidenewpolls'] == 'modified') {
        $datecolumn = 'modified';
    } else {
        $datecolumn = 'created';
    }
    $sql = array();
    $sql['mysql'] = "SELECT pid, topic, hideresults 
        FROM {$_TABLES['polltopics']} 
        WHERE ({$datecolumn} >= (DATE_SUB(NOW(), INTERVAL {$_PO_CONF['newpollsinterval']} SECOND))) 
        " . COM_getPermSQL('AND') . " 
        ORDER BY {$datecolumn} DESC LIMIT 15";
        
    $sql['mssql'] = $sql['mysql'];
    
    $sql['pgsql'] = "SELECT  pid, topic, hideresults 
        FROM {$_TABLES['polltopics']} 
        WHERE ({$datecolumn} >= (NOW() - INTERVAL '{$_PO_CONF['newpollsinterval']} SECONDS')) 
        " . COM_getPermSQL('AND') . " 
        ORDER BY {$datecolumn} DESC LIMIT 15";

    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if ($nrows > 0) {
        $newpolls = array();

        for ($x = 0; $x < $nrows; $x++) {
            $A = DB_fetchArray($result);

            // Users who have already voted but cannot see the results cannot view link
            if ($_USER['uid'] == 2 || ($_USER['uid'] != 2 && !($A['hideresults'] == 1 && (isset($_COOKIE['poll-' . $A['pid']]) || POLLS_ipAlreadyVoted($A['pid']))))) {
                $url = $_CONF['site_url'] . '/polls/index.php?pid=' . $A['pid'];
                $title = COM_undoSpecialChars(stripslashes( $A['topic']));
                $titletouse = COM_truncate($title, $_PO_CONF['title_trim_length'],
                                           '...');
                if ($title != $titletouse) {
                    $attr = array('title' => htmlspecialchars($title));
                } else {
                    $attr = array();
                }
                $apoll = str_replace('$', '&#36;', $titletouse);
                $apoll = str_replace(' ', '&nbsp;', $apoll);
    
                $newpolls[] = COM_createLink($apoll, $url, $attr);
            }
        }
        
        if (isset($url)) {
            $retval .= COM_makeList($newpolls, 'list-new-plugins');
        }
    }
    
    if ($nrows == 0 || !isset($url)) {
        $retval .= $LANG_POLLS['no_new_polls'] . '<br' . XHTML . '>' . LB;
    }     

    return $retval;
}

/**
* Return new Polls comments for the What's New block
*
* @param    string  $numreturn  If 0 will return results for What's New Block. 
*                               If > 0 will return last X new comments for User Profile.
* @param    string  $uid        ID of the user to return results for. 0 = all users.
* @return   array list of new comments (dups, type, title, sid, lastdate) or (sid, title, cid, unixdate)
*
*/
function plugin_getwhatsnewcomment_polls($numreturn = 0, $uid = 0)
{
    global $_CONF, $_TABLES;

    $stwhere = '';
    
    if ($uid > 0) {
        $stwhere = " AND ({$_TABLES['comments']}.uid = $uid)";
    }    
    if ($numreturn == 0 ) {
        $sql['mysql'] = "SELECT DISTINCT COUNT(*) AS dups, type, title, sid, max(date) AS lastdate FROM {$_TABLES['comments']}, {$_TABLES['polltopics']} pt"
            . " WHERE (pt.pid = sid) AND (pt.commentcode >= 0)" . COM_getPermSQL('AND', 0, 2, 'pt')
            . " AND (date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newcommentsinterval']} SECOND))) {$stwhere} GROUP BY sid,type, title, sid ORDER BY 5 DESC LIMIT 15";
        $sql['mssql'] = "SELECT DISTINCT COUNT(*) AS dups, type, title, sid, max(date) AS lastdate FROM {$_TABLES['comments']}, {$_TABLES['polltopics']} pt"
            . " WHERE (pt.pid = sid) AND (pt.commentcode >= 0)" . COM_getPermSQL('AND', 0, 2, 'pt')
            . " AND (date >= (DATE_SUB(NOW(), INTERVAL {$_CONF['newcommentsinterval']} SECOND))) {$stwhere} GROUP BY sid,type, title, sid ORDER BY 5 DESC LIMIT 15";
        $sql['pgsql'] = "SELECT DISTINCT COUNT(*) AS dups, type, title, sid, max(date) AS lastdate FROM {$_TABLES['comments']}, {$_TABLES['polltopics']} pt"
            . " WHERE (pt.pid = sid) AND (pt.commentcode >= 0)" . COM_getPermSQL('AND', 0, 2, 'pt')
            . " AND (date >= (NOW()+ INTERVAL '{$_CONF['newcommentsinterval']} SECOND')) {$stwhere} GROUP BY sid,type, title, sid ORDER BY 5 DESC LIMIT 15";
    } else {
        $sql = "SELECT {$_TABLES['comments']}.sid, {$_TABLES['comments']}.title  title, cid, UNIX_TIMESTAMP({$_TABLES['comments']}.date) AS unixdate FROM {$_TABLES['comments']}, {$_TABLES['polltopics']} pt"
            . " WHERE (pt.pid = sid) AND (pt.commentcode >= 0)" . COM_getPermSQL('AND', 0, 2, 'pt')
            . "{$stwhere} ORDER BY unixdate DESC LIMIT $numreturn";
    }
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($x = 0; $x < $nrows; $x++) {
            $A[] = DB_fetchArray($result);    
        }
        
        return $A;
    }
}

?>
