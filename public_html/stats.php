<?php
###############################################################################
# stats.php
# This is the stats page, you always wanted one, you know it!
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################
	include('lib-common.php');
	###############################################################################
# MAIN
	$display .= site_header()
		.startblock($LANG10[1]);
		
	// Base Statistics
	
	$display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">'.LB;
	$result = dbquery("SELECT value FROM {$CONF['db_prefix']}vars WHERE name = 'totalhits'");
	$A = mysql_fetch_row($result);
	$display .= '<tr>'.LB
		.'<td>'.$LANG10[2].'</td>'.LB
		.'<td align="right">'.$A[0].'</td>'.LB
		.'</tr>'.LB;
	$result = dbquery("SELECT count(*) FROM {$CONF['db_prefix']}stories WHERE draft_flag = 0");
	$A = mysql_fetch_row($result);
	$tmp2 = dbcount('comments');
	$display .= '<tr>'.LB
		.'<td>'.$LANG10[3].'</td>'.LB
		.'<td align="right">'.$A[0].' ('.$tmp2.')</td>'.LB
		.'</tr>'.LB;
	$tmp = dbcount('pollquestions');
	$result = dbquery("SELECT votes FROM {$CONF['db_prefix']}pollanswers");
	$nrows = mysql_num_rows($result);
	$tmp2 = 0;
	for ($i=0; $i<$nrows; $i++) {
		$A = mysql_fetch_row($result);
		$tmp2 = $tmp2 + $A[0];
	}
	
	$display .= '<tr>'.LB
		.'<td>'.$LANG10[4].'</td>'.LB
		.'<td align="right">'.$tmp.' ('.$tmp2.')</td>'.LB
		.'</tr>'.LB;
	$tmp = dbcount("links");
	$result = dbquery("SELECT hits FROM {$CONF['db_prefix']}links");
	$nrows = mysql_num_rows($result);
	$tmp2 = 0;
	for ($i=0; $i<$nrows; $i++) {
		$A = mysql_fetch_row($result);
		$tmp2 = $tmp2 + $A[0];
	}
	
	$display .= '<tr>'.LB
		.'<td>'.$LANG10[5].'</td>'.LB
		.'<td align="right">'.$tmp.' ('.$tmp2.')</td>'.LB
		.'</tr>'.LB;
	$tmp = dbcount('events');
	
	$display .= '<tr>'.LB
		.'<td>'.$LANG10[6].'</td>'.LB
		.'<td align="right">'.$tmp.'</td>'.LB
		.'</tr>'.LB;
	$display .= ShowPluginStats(1)
		.'</table>'.LB
		.endblock();
	// Top Ten Viewed Stories
		
	$result = dbquery("SELECT sid,title,hits FROM stories WHERE {$CONF['db_prefix']}draft_flag = 0 AND uid > 1 and Hits > 0 ORDER BY Hits desc LIMIT 10");
	$nrows  = mysql_num_rows($result);
	$display .= startblock($LANG10[7]);
	if ($nrows>0) {
		$display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">'.LB
			.'<tr>'.LB
			.'<td width="100%"><b>'.$LANG10[8].'</b></td>'
			.'<td align="right"><b>'.$LANG10[9].'</b></td>'.LB
			.'</tr>'.LB;
			
	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
		$display .= '<tr>'.LB
			.'<td><a href="article.php?story='.$A['sid'].'">'.$A['title'].'</a></td>'.LB
			.'<td align="right">'.$A['hits'].'</td>'.LB
			.'</tr>'.LB;
		}
        $display .= '</table>'.LB;
	} else {
		$display .= $LANG10[10];
	}
	
	$display .= endblock();
	// Top Ten Commented Stories
	
	$result = dbquery("SELECT sid,title,comments from stories WHERE draft_flag = 0 AND uid > 1 and comments > 0 ORDER BY comments desc LIMIT 10");
	$nrows  = mysql_num_rows($result);
	$display .= startblock($LANG10[11]);
	if ($nrows>0) {
		$display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">'.LB
			.'<tr>'.LB
			.'<td width="100%"><b>'.$LANG10[8].'</b></td>'.LB
			.'<td align="right"><b>'.$LANG10[12].'</b></td>'.LB
			.'</tr>'.LB;
		for ($i=0;$i<$nrows;$i++) {
			$A = mysql_fetch_array($result);	
			$display .= '<tr>'.LB
				.'<td><a href="article.php?story='.$A['sid'].'">'.$A['title'].'</a></td>'.LB
				.'<td align="right">'.$A['comments'].'</td>'.LB
				.'</tr>'.LB;
			}
		$display .= '</table>'.LB;
	} else {
		$display .= $LANG10[13];
	}
	$display .= endblock();
	// Top Ten Emailed Stories
	
	$result = dbquery("SELECT sid,title,numemails FROM stories WHERE numemails > 0 ORDER BY numemails desc LIMIT 10");
	$nrows = mysql_num_rows($result);
	$display .= startblock($LANG10[22]);
	
	if ($nrows>0) {
		$display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">'.LB
			.'<tr>'.LB
			.'<td width="100%"><b>'.$LANG10[8].'</b></td>'.LB
			.'<td align="right"><b>'.$LANG10[23].'</b></td>'.LB
			.'</tr>'.LB;
        for ($i=0;$i<$nrows;$i++) {
			$A = mysql_fetch_array($result);
			$display .= '<tr>'.LB
				.'<td><a href="article.php?story='.$A['sid'].'">'.$A['title'].'</a></td>'.LB
				.'<td align="right">'.$A['numemails'].'</td>'.LB
				.'</tr>'.LB;
   	    }
       	$display .= '</table>'.LB;
	} else {
        $display .= $LANG10[24];
	}
	$display .= endblock();
	// Top Ten Polls
	
	$result = dbquery("SELECT qid,question,voters from pollquestions WHERE voters > 0 ORDER BY voters desc LIMIT 10");
	$nrows  = mysql_num_rows($result);
	$display .= startblock($LANG10[14]);
	if ($nrows>0) {
		$display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">'.LB
			.'<tr>'.LB
			.'<td width="100%"><b>'.$LANG10[15].'</b></td>'.LB
			.'<td align="right"><b>'.$LANG10[16] .'</b></td>'.LB
			.'</tr>'.LB;
		for ($i=0;$i<$nrows;$i++) {
			$A = mysql_fetch_array($result);
			$display .= '<tr>'.LB
				.'<td><a href="pollbooth.php?qid='.$A['qid'].'">'.$A['question'].'</a></td>'.LB
				.'<td align="right">'.$A['voters'].'</td>'.LB
				.'</tr>'.LB;
			}
		$display .= '</table>'.LB;
	} else {
		$display .= $LANG10[17];
	}	
	$display .= endblock();
	// Top Ten Links
	
	$result = dbquery("SELECT lid,url,title,hits from links WHERE hits > 0 ORDER BY hits desc LIMIT 10");
	$nrows  = mysql_num_rows($result);
	$display .= startblock($LANG10[18]);
	if ($nrows>0) {
		$display .= '<table cellpadding="0" cellspacing="1" border="0" width="99%">'.LB
			.'<tr>'.LB
			.'<td width="100%"><b>'.$LANG10[19].'</b></td>'.LB
			.'<td align="right"><b>'.$LANG10[20].'</b></td>'.LB
			.'</tr>'.LB;
		for ($i=0;$i<$nrows;$i++) {
			$A = mysql_fetch_array($result);
			$display .= '<tr>'.LB
				.'<td><a '
				.sprintf("href={$CONF['site_url']}/portal.php?url=%s&what=link&item=%s>%s</a> </td>".LB
					,urlencode($A["url"]),$A["lid"],$A['title'])
				.'<td align="right">'.$A['hits'].'</td>'.LB
				.'</tr>'.LB;
			}
		$display .= '</table>'.LB;
	} else {
		$display .= $LANG10[21];
	}	
	$display .= endblock();
	// Now show stats for any plugins that want to be included
	$display .= ShowPluginStats(2);
	$display .=site_footer();
	
	echo $display;
?>
