<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | pollbooth.php                                                            |
// | This is the pollbooth page.                                               |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
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
// $Id: pollbooth.php,v 1.5 2001/10/17 23:35:47 tony_bibbs Exp $

include_once('lib-common.php');

/**
* Saves a user's vote
*
* Saves the users vote, if allowed for the poll $qid.  NOTE
* all data comes from form post
*
*/
function pollsave() 
{
    global $_TABLES, $qid, $aid, $db, $REMOTE_ADDR, $LANG07;
	
    DB_change($_TABLES['pollquestions'],'voters','voters + 1','qid',$qid);
    DB_change($_TABLES['pollanswers'],'votes','votes + 1','qid',$qid,'aid',$aid);
    DB_save($_TABLES['COM_pollVoters'],'ipaddress, date, qid',"'$REMOTE_ADDR',unix_timestamp(),'$qid'");
    $retval .= COM_startBlock($LANG07[1])
        . $LANG07[2] . ' ' . $qid
        . COM_endBlock()
        . COM_pollResults($qid);

    return $retval;
}

/**
* Shows all polls in system
*
* List all the polls on the system if no $qid is provided
*
*/
function polllist() 
{
    global $_TABLES, $_CONF, $LANG07;
	
    $result = DB_query("SELECT qid FROM {$_TABLES['pollquestions']}");
    $nrows = DB_numRows($result);
    $counter = 0;
	
    $retval .= '<table border="0" cellspacing="0" cellpadding="2" width="100%">'.LB
        .'<tr align="center" valign="top">'.LB;
		
    for ($i = 1; $i <= $nrows; $i++) {
        if ($counter == 3) {
            $retval .= '</tr><tr align="center" valign="top">';
            $counter = 1;
        } else {
            $counter = $counter + 1;
        }
        $retval .= '<td>';
        $Q = DB_fetchArray($result);
	COM_errorLog("pollResults HTML:\n " . COM_pollResults($Q['qid'],'119'),1);
        $retval .= COM_pollResults($Q['qid'],'119')
            .'[ <a href="'.$_CONF['site_url'].'/pollbooth.php?qid='.$Q['qid'].'">'.$LANG07[3].'</a> ]</td>'.LB;
    }
    $retval .= '</table>'.LB;
	
	return $retval;
}

// MAIN
//
// no qid will load a list of polls
// no aid will let you vote on the select poll
// an aid greater than 0 will save a vote for that answer on the selected poll
// an aid of -1 will display the select poll

if ($reply == $LANG01[25]) {
	$display .= COM_refresh("{$_CONF['site_url']}/comment.php?sid=$qid&pid=$pid&type=$type");
	echo $display;
	exit;			
}
if (empty($qid)) {
	$display .= site_header() . polllist();
} else if (empty($aid)) {
	$display .= site_header();
	if (empty($HTTP_COOKIE_VARS[$qid])) {
		$display .= COM_pollVote($qid);
	} else {
		$display .= COM_pollResults($qid,400,$order,$mode);
	}
} else if ($aid  > 0  and empty($HTTP_COOKIE_VARS[$qid])) {
	setcookie($qid,$aid,time()+$_CONF['pollcookietime']);
	$display .= site_header()
		.pollsave();
} else {
	$display .= site_header()
		.COM_pollResults($qid,400,$order,$mode);
}
$display .= site_footer();
echo $display;
?>
