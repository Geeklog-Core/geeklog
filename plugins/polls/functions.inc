<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 1.0                                                          |
// +---------------------------------------------------------------------------+
// | functions.inc                                                             |
// |                                                                           |
// | This file does two things: 1) it implements the necessary Geeklog Plugin  |
// | API method and 2) implements all the common code needed by the Polls      |
// | plugin' PHP files.                                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
//
// $Id: functions.inc,v 1.41 2006/03/12 16:31:45 dhaun Exp $

$langfile = $_CONF['path'] . 'plugins/polls/language/'
          . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    require_once ($langfile);
} else {
    require_once ($_CONF['path'] . 'plugins/polls/language/english.php');
}

require_once ($_CONF['path'] . 'plugins/polls/config.php');


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
* Geeklog is checking to see if this plugin supports comments, tell it yes.
*
* NOTE: to support comments you must used the same date/time based ID for your
* widget.  In other words, to make primary keys for your plugin you should call
* makesid().  Comments are keyed off of that...it is a limitation on how Geeklog
* does comments.
*
*/
function plugin_commentsupport_polls()
{
    // polls will use comments
    return true;
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

    $commentcode = DB_getItem ($_TABLES['pollquestions'], 'commentcode',
                               "qid = '$id'");
    if ($commentcode < 0) {
        return COM_refresh ($_CONF['site_url'] . '/index.php');
    }

    $ret = CMT_saveComment ($title, $comment, $id, $pid, 'polls', $postmode);
    if ($ret > 0) { // failure //FIXME: some failures should not return to comment form
        $retval .= COM_siteHeader()
            . CMT_commentForm ($_USER['uid'], $title, $comment, $id, $pid,
                    'polls', $LANG03[14], $postmode)
            . COM_siteFooter();
    } else { // success
        $retval = COM_refresh ($_CONF['site_url']
                                . "/polls/index.php?qid=$id&aid=-1");
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
    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid = '{$id}'");
    $A = DB_fetchArray ($result);

    if ($has_editPermissions && SEC_hasAccess ($A['owner_id'],
            $A['group_id'], $A['perm_owner'], $A['perm_group'],
            $A['perm_members'], $A['perm_anon']) == 3) {
        CMT_deleteComment($cid, $id, 'polls');
        $retval .= COM_refresh ($_CONF['site_url']
                                 . "/polls/index.php?qid=$id&aid=-1");
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

    $result = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['pollquestions']}" . COM_getPermSQL ());
    $A = DB_fetchArray($result);
    $total_polls = $A['count'];

    $result = DB_query ("SELECT qid FROM {$_TABLES['pollquestions']}" . COM_getPermSQL ());
    $nrows = DB_numRows ($result);
    if ($nrows > 0) {
        $questions = '';
        for ($i = 1; $i <= $nrows; $i++) {
            $A = DB_fetchArray($result);
            if ($i > 1) {
                $questions .= ',';
            }
            $questions .= "'" . $A['qid'] . "'";
        }
        $result = DB_query ("SELECT SUM(votes) FROM {$_TABLES['pollanswers']} WHERE qid IN ({$questions})");
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

    $result = DB_query ("SELECT qid,question,voters from {$_TABLES['pollquestions']} WHERE (voters > 0)" . COM_getPermSQL ('AND') . " ORDER BY voters DESC LIMIT 10");
    $nrows  = DB_numRows ($result);

    if ($nrows > 0) {
        $header_arr = array(
            array('text'         => $LANG_POLLS['stats_questions'],
                  'field'        => 'qid',
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
            $url = $_CONF['site_url'] . '/polls/index.php?qid=' . $A['qid']
                 . '&amp;aid=-1';
            $qid = '<a href="' . $url . '">' . $A['question'] . '</a>';
            $voters = COM_NumberFormat ($A['voters']);
            $data_arr[] = array ('qid' => $qid, 'voters' => $voters);
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
        $result = DB_query ("SELECT COUNT(*) AS cnt FROM {$_TABLES['pollquestions']}" . COM_getPermSQL ());
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

    if (DB_count ($_TABLES['pollquestions'], "owner_id = $uid") == 0) {
        // there are no polls owned by this user
        return;
    }

    if ($_PO_CONF['delete_polls'] == 1) {
        // delete the polls
        $result = DB_query ("SELECT qid FROM {$_TABLES['pollquestions']} WHERE owner_id = $uid");
        $numPolls = DB_numRows ($result);
        for ($i = 0; $i < $numPolls; $i++) {
            list($qid) = DB_fetchArray ($result);
            DB_delete ($_TABLES['pollanswers'], 'qid', $qid);
            DB_delete ($_TABLES['pollvoters'], 'qid', $qid);
            DB_query ("DELETE FROM {$_TABLES['comments']} WHERE sid = '$qid' AND type = 'polls'");
        }
        DB_delete ($_TABLES['pollquestions'], 'owner_id', $uid);
    } else {
        // assign ownership to a user from the Root group
        $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id',
                                 "grp_name = 'Root'");
        $result = DB_query ("SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1");
        list($rootuser) = DB_fetchArray ($result);

        DB_query ("UPDATE {$_TABLES['pollquestions']} SET owner_id = $rootuser WHERE owner_id = $uid");
    }
}

/**
* Return the current version of code.
* Used in the Plugin Editor to show the registered version and code version
*/
function plugin_chkVersion_polls()
{
    global $_PO_CONF;

    return $_PO_CONF['version'];
}


/**
* Removes the datastructures for this plugin from the Geeklog database
*
* This may get called by the install routine to undo anything done to this
* point.  To do that, $steps will have a list of steps to undo
*
* @steps   Array    Holds all the steps that have been completed by the install
*
*/
function plugin_uninstall_polls($steps = '')
{
    global $_TABLES;

    // Uninstalls the polls plugin

    if (empty($steps) OR $steps['createtable'] == 1) {
        // Remove the pollquestions and pollanswers tables
        COM_errorLog('Dropping polls answers table',1);
        DB_query("DROP TABLE {$_TABLES['pollanswers']}");
        COM_errorLog('...success',1);
        COM_errorLog('Dropping polls questions table',1);
        DB_query("DROP TABLE {$_TABLES['pollquestions']}");
        COM_errorLog('...success',1);
        COM_errorLog('Dropping pollvoters table',1);
        DB_query("DROP TABLE {$_TABLES['pollvoters']}");
        COM_errorLog('...success',1);
    }

    // Remove polls block
    DB_delete ($_TABLES['blocks'], array ('type',     'phpblockfn'),
                                   array ('phpblock', 'phpblock_polls'));

    // Remove security for this plugin

    // Remove the polls admin group
    $grp_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Polls Admin'");

    if (empty($steps) OR $steps['insertgroup'] == 1) {
        COM_errorLog('Attempting to remove the Polls Admin Group', 1);
        DB_query("DELETE FROM {$_TABLES['groups']} WHERE grp_id = $grp_id");
        COM_errorLog('...success',1);
    }

    // Remove related features
    $edit_id = DB_getItem($_TABLES['features'], 'ft_id', "ft_name = 'polls.edit'");

    if (empty($steps) OR $steps['addededittogroup'] == 1) {
        // Remove access to those features
        COM_errorLog('Attempting to remove rights to polls.edit from all groups',1);
        DB_query("DELETE FROM {$_TABLES['access']} WHERE acc_ft_id = $edit_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['addedrootuserstogroup'] == 1) {
        // Remove root users from the group
        COM_errorLog('Attempting to remove root users from admin of polls pages');
        DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = $grp_id");
        COM_errorLog('...success',1);
    }

    if (empty($steps) OR $steps['insertedfeatureedit'] == 1) {
        COM_errorLog('Attempting to remove the polls.edit feature',1);
        DB_query("DELETE FROM {$_TABLES['features']} WHERE ft_id = $edit_id");
        COM_errorLog('...success',1);
    }

    // Unregister the plugin with Geeklog
    // Always attempt to remove these entries or lib-common.php would still
    // try and read our functions.inc file ...
    COM_errorLog('Attempting to unregister the polls plugin from Geeklog',1);
    DB_query("DELETE FROM {$_TABLES['plugins']} WHERE pi_name = 'polls'");
    COM_errorLog('...success',1);

    COM_errorLog('leaving plugin_uninstall_polls',1);

    return true;
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
* Shows an HTML formatted poll for the given question ID
*
* @param      string      $qid      ID for poll question
* @see function COM_pollResults
* @see function COM_showPoll
* @return       string  HTML Formatted Poll
*
*/

function POLLS_pollVote( $qid )
{
    global $_CONF, $_TABLES, $LANG_POLLS, $LANG01;

    $retval = '';

    $question = DB_query( "SELECT question,voters,commentcode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid='$qid'" );
    $Q = DB_fetchArray( $question );

    if( SEC_hasAccess( $Q['owner_id'], $Q['group_id'], $Q['perm_owner'], $Q['perm_group'], $Q['perm_members'], $Q['perm_anon'] ) == 0 )
    {
        return $retval;
    }

    $nquestion = DB_numRows( $question );
    $fields = array( 'ipaddress', 'qid' );
    $values = array( $_SERVER['REMOTE_ADDR'], $qid );
    $id = DB_count( $_TABLES['pollvoters'], $fields, $values );

    if( empty( $_COOKIE[$qid] ) && $id == 0 )
    {
        if( $nquestion == 1 )
        {
            $answers = DB_query( "SELECT answer,aid FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY aid" );
            $nanswers = DB_numRows( $answers );

            if( $nanswers > 0 )
            {
                $poll = new Template( $_CONF['path'] . 'plugins/polls/templates/' );
                $poll->set_file( array( 'panswer' => 'pollanswer.thtml',
                                        'block' => 'pollblock.thtml',
                                        'comments' => 'pollcomments.thtml' ));
                $poll->set_var( 'site_url', $_CONF['site_url'] );
                $poll->set_var( 'layout_url', $_CONF['layout_url'] );

                $poll->set_var( 'poll_question', $Q['question'] );
                $poll->set_var( 'poll_id', $qid );
                $poll->set_var( 'num_votes', COM_numberFormat( $Q['voters'] ));
                $poll->set_var( 'poll_vote_url', $_CONF['site_url']
                        . '/polls/index.php');
                $poll->set_var( 'poll_results_url', $_CONF['site_url']
                        . '/polls/index.php?qid=' . $qid . '&amp;aid=-1');

                $poll->set_var( 'lang_vote', $LANG_POLLS['vote'] );
                $poll->set_var( 'lang_votes', $LANG_POLLS['votes'] );
                $poll->set_var( 'lang_results', $LANG_POLLS['results'] );

                for( $i = 1; $i <= $nanswers; $i++ )
                {
                    $A = DB_fetchArray( $answers );
                    $poll->set_var( 'answer_id', $A['aid'] );
                    $poll->set_var( 'answer_text', $A['answer'] );
                    $poll->parse( 'poll_answers', 'panswer', true );
                }

                if( $Q['commentcode'] >= 0 )
                {
                    $poll->set_var( 'num_comments',
                            COM_numberFormat( DB_count( $_TABLES['comments'],
                                                        'sid', $qid )));
                    $poll->set_var( 'lang_comments', $LANG01[3] );
                    $poll->set_var( 'poll_comments_url', $_CONF['site_url'] .
                        '/polls/index.php?qid=' . $qid . '&amp;aid=-1#comments');
                    $poll->parse( 'poll_comments', 'comments', true );
                }
                else
                {
                    $poll->set_var( 'poll_comments', '' );
                    $poll->set_var( 'poll_comments_url', '' );
                }

                $retval =  $poll->finish( $poll->parse( 'output', 'block' )) . LB;
            }
        }
    }
    else
    {
        $retval .= POLLS_pollResults( $qid );
    }

    return $retval;
}

/**
* This shows a poll
*
* This will determine if a user needs to see the poll form OR the poll
* result.
*
* @param        int        $sise       Size in pixels of poll results
* @param        string     $qid        Question ID to show (optional)
* @see function COM_pollVote
* @see function COM_pollResults
* @return    String  HTML Formated string of Poll
*
*/

function POLLS_showPoll( $size, $qid='' )
{
    global $_CONF, $_PO_CONF, $_TABLES;

    $retval = '';

    DB_query( "DELETE FROM {$_TABLES['pollvoters']} WHERE date < unix_timestamp() - {$_PO_CONF['polladdresstime']}" );

    if( !empty( $qid ))
    {
        $pcount = DB_count( $_TABLES['pollvoters'], array( 'ipaddress', 'qid' ),
                            array( $_SERVER['REMOTE_ADDR'], $qid ));

        if( empty( $_COOKIE[$qid]) && $pcount == 0 )
        {
            $retval .= POLLS_pollVote( $qid );
        }
        else
        {
            $retval .= POLLS_pollResults( $qid, $size );
        }
    }
    else
    {
        $result = DB_query( "SELECT qid from {$_TABLES['pollquestions']} WHERE display = 1 ORDER BY date DESC" );
        $nrows = DB_numRows( $result );
        
        $title = DB_getItem( $_TABLES['blocks'], 'title', "name='poll_block'" );

        if( $nrows > 0 )
        {
            for( $i = 1; $i <= $nrows; $i++ )
            {
                $Q = DB_fetchArray( $result );
                $qid = $Q['qid'];
                $id = array( 'ipaddress', 'qid' );
                $value = array( $_SERVER['REMOTE_ADDR'], $qid );
                $pcount = DB_count( $_TABLES['pollvoters'], $id, $value );

                if( $size < 120 ) // assume we're in the poll block
                {
                    if ( $i > 1 )
                    {
                        $retval .= COM_startBlock( $title, '',
                             COM_getBlockTemplate( 'poll_block', 'header' ));
                    }

                             # $_CONF['path'] . 'plugins/polls/templates/
                }
                else // assume we're in polls/index.php
                {
                    $retval .= COM_startBlock( $title );
                }

                if( !isset( $_COOKIE[$qid]) && $pcount == 0)
                {
                    $retval .= POLLS_pollVote( $qid );
                }
                else
                {
                    $retval .= POLLS_pollResults( $qid, $size );
                }
                
                if( $size < 120 )
                {
                    if ( $i < $nrows )
                    {
                        $retval .= COM_endBlock( COM_getBlockTemplate( 
                             'poll_block', 'footer' ));
                    }
                }
                else
                {
                    $retval .= COM_endBlock();
                }
                
            }
        }
    }

    return $retval;
}

/**
* Shows the results of a poll
*
* Shows the poll results for a given poll question
*
* @param        string      $qid        ID for poll question to show
* @param        int         $scale      Size in pixels to scale formatted results to
* @param        string      $order      'ASC' or 'DESC' for Comment ordering (SQL statment ordering)
* @param        string      $mode       Comment Mode possible values 'nocomment', 'flat', 'nested', 'threaded'
* @see COM_pollVote
* @see COM_showPoll
* @return     string   HTML Formated Poll Results
*
*/
function POLLS_pollResults( $qid, $scale=400, $order='', $mode='' )
{
    global $_CONF, $_TABLES, $_PO_CONF, $LANG01, $LANG_POLLS, $_COM_VERBOSE;

    $retval = '';

    $question = DB_query( "SELECT question,voters,commentcode,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['pollquestions']} WHERE qid='$qid'" );
    $Q = DB_fetchArray( $question );

    if( SEC_hasAccess( $Q['owner_id'], $Q['group_id'], $Q['perm_owner'], $Q['perm_group'], $Q['perm_members'], $Q['perm_anon']) == 0 )
    {
        return $retval;
    }

    $nquestion = DB_numRows( $question );
    if( $nquestion == 1 )
    {
        if( $_PO_CONF['answerorder'] == 'voteorder' )
        {
            $answers = DB_query( "SELECT votes,answer FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY votes DESC" );
        }
        else
        {
            $answers = DB_query( "SELECT votes,answer FROM {$_TABLES['pollanswers']} WHERE qid='$qid' ORDER BY aid" );
        }

        $nanswers = DB_numRows( $answers );

        if( $_COM_VERBOSE )
        {
            COM_errorLog( "got $answers answers in COM_pollResults", 1 );
        }

        if( $nanswers > 0 )
        {

            $poll = new Template( $_CONF['path'] . 'plugins/polls/templates/' );
            $poll->set_file( array( 'result' => 'pollresult.thtml',
                                    'comments' => 'pollcomments.thtml',
                                    'votes_bar' => 'pollvotes_bar.thtml',
                                    'votes_num' => 'pollvotes_num.thtml' ));
            $poll->set_var( 'site_url', $_CONF['site_url'] );
            $poll->set_var( 'layout_url', $_CONF['layout_url'] );

            $poll->set_var( 'poll_question', $Q['question'] );
            $poll->set_var( 'poll_id', $qid );
            $poll->set_var( 'num_votes', COM_numberFormat( $Q['voters'] ));

            $poll->set_var( 'lang_votes', $LANG_POLLS['votes'] );

            for( $i = 1; $i <= $nanswers; $i++ )
            {
                $A = DB_fetchArray( $answers );

                if( $Q['voters'] == 0 )
                {
                    $percent = 0;
                }
                else
                {
                    $percent = $A['votes'] / $Q['voters'];
                }

                $poll->set_var( 'answer_text', $A['answer'] );
                $poll->set_var( 'answer_counter', $i );
                $poll->set_var( 'answer_odd', (( $i - 1 ) % 2 ));
                $poll->set_var( 'answer_num', COM_numberFormat( $A['votes'] ));
                $poll->set_var( 'answer_percent',
                                sprintf( '%.2f', $percent * 100 ));
                if( $scale < 120 )
                {
                    $poll->parse( 'poll_votes', 'votes_num', true );
                }
                else
                {
                    $width = $percent * $scale;
                    $poll->set_var( 'bar_width', $width );
                    $poll->parse( 'poll_votes', 'votes_bar', true );
                }
            }

            if( $Q['commentcode'] >= 0 )
            {
                $poll->set_var( 'num_comments',
                        COM_numberFormat( DB_count( $_TABLES['comments'],
                                                    'sid', $qid )));
                $poll->set_var( 'lang_comments', $LANG01[3] );
                $poll->set_var( 'poll_comments_url', $_CONF['site_url'] .
                        '/polls/index.php?qid=' . $qid . '&amp;aid=-1#comments');
                $poll->parse( 'poll_comments', 'comments', true );
            }
            else
            {
                $poll->set_var( 'poll_comments_url', '' );
                $poll->set_var( 'poll_comments', '' );
            }

            $poll->set_var( 'lang_pollquestions', $LANG_POLLS['pollquestions'] );

            $retval .= $poll->finish( $poll->parse( 'output', 'result' ));

            if( $scale > 399 && $Q['commentcode'] >= 0 )
            {
                $delete_option = ( SEC_hasRights( 'polls.edit' ) &&
                    SEC_hasAccess( $Q['owner_id'], $Q['group_id'],
                    $Q['perm_owner'], $Q['perm_group'], $Q['perm_members'],
                    $Q['perm_anon'] ) == 3 ? true : false );
                require_once $_CONF['path_system'] . 'lib-comment.php';
                $retval .= CMT_userComments( $qid, $Q['question'], 'polls',
                                             $order, $mode, 0, 1, false, $delete_option );
            }
        }
    }

    return $retval;
}


function phpblock_polls()
{
    $retval = POLLS_showPoll( 60 );

    return $retval;
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
* @param   string  $order  'ASC' or 'DSC' or blank                            
* @param   string  $format 'threaded', 'nested', or 'flat'                    
* @param   int     $page   Page number of comments to display                 
* @param   boolean $view   True to view comment (by cid), false to display (by $pid)
* @return  mixed   results of calling the plugin_displaycomment_ function     
*/
function plugin_displaycomment_polls ($id, $cid, $title, $order, $format, $page, $view)
{
    global $_TABLES, $LANG_ACCESS;

    $retval = '';

    $sql = "SELECT COUNT(*) AS count, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon FROM {$_TABLES['pollquestions']} WHERE (qid = '$id')" . COM_getPermSQL('AND') . ' GROUP BY qid';
    $result = DB_query ($sql);
    $A = DB_fetchArray ($result);
    $allowed = $A['count'];

    if ($allowed == 1) {
        $delete_option = (SEC_hasRights ('polls.edit') &&
                (SEC_hasAccess ($A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon']) == 3));
        $retval .= CMT_userComments ($id, $title, 'polls', $order, $format,
                                     $cid, $page, $view, $delete_option);
    } else {
        $retval .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                        COM_getBlockTemplate ('_msg_block', 'header'))
                . $LANG_ACCESS['storydenialmsg']
                . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    }

    return $retval;
}

function plugin_getListField_polls($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF, $LANG25, $LANG_ACCESS;

    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
                             $A['perm_owner'], $A['perm_group'],
                             $A['perm_members'], $A['perm_anon']);
    if ($access > 0) {
        switch($fieldname) {
            case 'edit':
                if ($access == 3) {
                    $retval = "<a href=\"{$_CONF['site_admin_url']}/plugins/polls/index.php?mode=edit&amp;qid={$A['qid']}\">{$icon_arr['edit']}</a>";
                }
                break;
            case 'unixdate':
                $retval = strftime ($_CONF['daytime'], $A['unixdate']);
                break;
            case 'question':
                $retval = "<a href=\"{$_CONF['site_url']}/polls/index.php?qid={$A['qid']}&aid=-1\">$fieldvalue</a>";
                break;
            case 'access':
                if ($access == 3) {
                    $access = $LANG_ACCESS['edit'];
                } else {
                    $access = $LANG_ACCESS['readonly'];
                }
                $retval = $access;
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


?>
