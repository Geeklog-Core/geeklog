<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | stats.php                                                                 |
// | Geeklog system statistics page.                                           |
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
// $Id: stats.php,v 1.6 2001/10/17 23:35:47 tony_bibbs Exp $

include_once('lib-common.php');

// MAIN

$display .= site_header() . COM_startBlock($LANG10[1]);
		
// Base Statistics
	
$display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">' . LB;
$result = DB_query("SELECT value FROM {$_TABLES['vars']} WHERE name = 'totalhits'");
$A = DB_fetchArray($result);
$display .= '<tr>' . LB
    . '<td>' . $LANG10[2] . '</td>' . LB
    . '<td align="right">' . $A['value'] . '</td>' . LB
    .'</tr>' . LB;
$result = DB_query("SELECT count(*) FROM {$_TABLES['stories']} WHERE draft_flag = 0");
$A = DB_fetchArray($result);
$tmp2 = DB_count('comments');
$display .= '<tr>' . LB
    . '<td>' . $LANG10[3] . '</td>' . LB
    . '<td align="right">' . $A[0] . ' (' . $tmp2 . ')</td>' . LB
    . '</tr>' . LB;
$tmp = DB_count('pollquestions');
$result = DB_query("SELECT votes FROM {$_TABLES['pollanswers']}");
$nrows = DB_numRows($result);
$tmp2 = 0;
for ($i = 0; $i < $nrows; $i++) {
    $A = DB_fetchArray($result);
    $tmp2 = $tmp2 + $A[0];
}
	
$display .= '<tr>' . LB
    . '<td>' . $LANG10[4] . '</td>' . LB
    . '<td align="right">' . $tmp . ' (' . $tmp2 . ')</td>' . LB
    . '</tr>' . LB;
$tmp = DB_count("links");
$result = DB_query("SELECT hits FROM {$_TABLES['links']}");
$nrows = DB_numRows($result);
$tmp2 = 0;
for ($i = 0; $i < $nrows; $i++) {
	$A = DB_fetchArray($result);
	$tmp2 = $tmp2 + $A[0];
}
	
$display .= '<tr>' . LB
    . '<td>' . $LANG10[5] . '</td>' . LB
    . '<td align="right">' . $tmp . ' (' . $tmp2 . ')</td>' . LB
    . '</tr>' . LB;
$tmp = DB_count('events');
	
$display .= '<tr>' . LB
    . '<td>' . $LANG10[6] . '</td>' . LB
    . '<td align="right">' . $tmp . '</td>' . LB
    . '</tr>' . LB;
$display .= ShowPluginStats(1)
    . '</table>' . LB
    . COM_endBlock();
// Top Ten Viewed Stories
		
$result = DB_query("SELECT sid,title,hits FROM {$_TABLES["stories"]} WHERE draft_flag = 0 AND uid > 1 and Hits > 0 ORDER BY Hits desc LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[7]);
if ($nrows > 0) {
    $display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">' . LB
        . '<tr>' . LB
        . '<td width="100%"><b>' . $LANG10[8] . '</b></td>'
        . '<td align="right"><b>' . $LANG10[9] . '</b></td>' . LB
        . '</tr>' . LB;
			
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $display .= '<tr>' . LB
            . '<td><a href="article.php?story=' . $A['sid'] . '">' . $A['title'] . '</a></td>' . LB
            . '<td align="right">' . $A['hits'] . '</td>' . LB
            . '</tr>' . LB;
    }
    $display .= '</table>' . LB;
} else {
    $display .= $LANG10[10];
}
	
$display .= COM_endBlock();
	
// Top Ten Commented Stories
	
$result = DB_query("SELECT sid,title,comments from stories WHERE draft_flag = 0 AND uid > 1 and comments > 0 ORDER BY comments desc LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[11]);
if ($nrows > 0) {
    $display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">' . LB
        . '<tr>' . LB
        . '<td width="100%"><b>' . $LANG10[8] . '</b></td>' . LB
        . '<td align="right"><b>' . $LANG10[12] . '</b></td>' . LB
        . '</tr>' . LB;
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);	
        $display .= '<tr>' . LB
            . '<td><a href="article.php?story=' . $A['sid'] . '">' . $A['title'] . '</a></td>' . LB
            . '<td align="right">' . $A['comments'] . '</td>' . LB
            . '</tr>' . LB;
    }
    $display .= '</table>' . LB;
} else {
    $display .= $LANG10[13];
}
$display .= COM_endBlock();
	
// Top Ten Emailed Stories
	
$result = DB_query("SELECT sid,title,numemails FROM {$_TABLES["stories"]} WHERE numemails > 0 ORDER BY numemails desc LIMIT 10");
$nrows = DB_numRows($result);
$display .= COM_startBlock($LANG10[22]);
	
if ($nrows > 0) {
    $display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">' . LB
        . '<tr>' . LB
        . '<td width="100%"><b>' . $LANG10[8] . '</b></td>' . LB
        . '<td align="right"><b>' . $LANG10[23] . '</b></td>' . LB
        . '</tr>' . LB;
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $display .= '<tr>' . LB
        . '<td><a href="article.php?story=' . $A['sid'] . '">' . $A['title'] . '</a></td>' . LB
        . '<td align="right">' . $A['numemails'] . '</td>' . LB
        . '</tr>' . LB;
    }
    $display .= '</table>' . LB;
} else {
    $display .= $LANG10[24];
}
$display .= COM_endBlock();
	
// Top Ten Polls
	
$result = DB_query("SELECT qid,question,voters from pollquestions WHERE voters > 0 ORDER BY voters desc LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[14]);
if ($nrows>0) {
    $display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">' . LB
        . '<tr>' . LB
        . '<td width="100%"><b>' . $LANG10[15] . '</b></td>' . LB
        . '<td align="right"><b>' . $LANG10[16]  . '</b></td>' . LB
        . '</tr>' . LB;
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $display .= '<tr>' . LB
            . '<td><a href="pollbooth.php?qid=' . $A['qid'] . '">' . $A['question'] . '</a></td>' . LB
            . '<td align="right">' . $A['voters'] . '</td>' . LB
            . '</tr>' . LB;
    }
    $display .= '</table>' . LB;
} else {
    $display .= $LANG10[17];
}	

$display .= COM_endBlock();
	
// Top Ten Links
$result = DB_query("SELECT lid,url,title,hits from links WHERE hits > 0 ORDER BY hits desc LIMIT 10");
$nrows  = DB_numRows($result);
$display .= COM_startBlock($LANG10[18]);
if ($nrows > 0) {
    $display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">' . LB
        . '<tr>' . LB
        . '<td width="100%"><b>' . $LANG10[19] . '</b></td>' . LB
        . '<td align="right"><b>' . $LANG10[20] . '</b></td>' . LB
        . '</tr>' . LB;
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);
        $display .= '<tr>' . LB
            . '<td><a '
            . sprintf("href={$_CONF['site_url']}/portal.php?url=%s&what=link&item=%s>%s</a> </td>". LB
                ,urlencode($A["url"]),$A["lid"],$A['title'])
            .'<td align="right">' . $A['hits'] . '</td>' . LB
				. '</tr>' . LB;
    }
    $display .= '</table>' . LB;
} else {
    $display .= $LANG10[21];
}	
$display .= COM_endBlock();
	
// Now show stats for any plugins that want to be included
$display .= ShowPluginStats(2);
$display .= site_footer();
	
echo $display;

?>
