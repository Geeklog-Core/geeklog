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

include("common.php");
include("custom_code.php");

###############################################################################
# MAIN

site_header("menu");
startblock($LANG10[1]);
print "<table cellpadding=0 cellspacing=1 border=0 width=\"99%\">\n";
$result = dbquery("SELECT value FROM {$CONF["db_prefix"]}vars WHERE name = 'totalhits'");
$A = mysql_fetch_row($result);
print "<tr><td align=left>{$LANG10[2]}</td><td>{$A[0]}</td></tr>\n";
$result = dbquery("SELECT count(*) FROM {$CONF["db_prefix"]}stories WHERE draft_flag = 0");
$A = mysql_fetch_row($result);
$tmp2 = dbcount("comments");
print "<tr><td align=left>{$LANG10[3]}</td><td>{$A[0]}({$tmp2})</td></tr>\n";

	$tmp = dbcount("pollquestions");
	$result = dbquery("SELECT votes FROM {$CONF["db_prefix"]}pollanswers");
	$nrows = mysql_num_rows($result);
	$tmp2 = 0;
	for ($i=0; $i<$nrows; $i++) {
		$A = mysql_fetch_row($result);
		$tmp2 = $tmp2 + $A[0];
	}
	print "<tr><td align=left>{$LANG10[4]}</td><td>{$tmp}({$tmp2})</td></tr>\n"; 

	$tmp = dbcount("links");
	$result = dbquery("SELECT hits FROM {$CONF["db_prefix"]}links");
	$nrows = mysql_num_rows($result);
	$tmp2 = 0;
	for ($i=0; $i<$nrows; $i++) {
		$A = mysql_fetch_row($result);
		$tmp2 = $tmp2 + $A[0];
	}
	print "<tr><td align=left>{$LANG10[5]}</td><td>{$tmp}({$tmp2})</td></tr>\n"; 

	$tmp = dbcount("events");
	print "<tr><td align=left>" . $LANG10[6] . "</td><td>" . $tmp . "</td></tr>\n"; 

	ShowPluginStats(1);
print "</table>\n";
endblock();

$result = dbquery("SELECT sid,title,hits from stories WHERE draft_flag = 0 AND uid > 1 and Hits > 0 ORDER BY Hits desc LIMIT 10");
$nrows  = mysql_num_rows($result);
startblock($LANG10[7]);
if ($nrows>0) {
	print "<table cellpadding=0 cellspacing=1 border=0 width=\"99%\">\n";
	print "<tr align=center><th align=left width=\"100%\">" . $LANG10[8] . "</th><th>" . $LANG10[9] . "</th></tr>";
	for ($i=0;$i<$nrows;$i++) {
		$A      = mysql_fetch_array($result);
		print "<tr align=center>\n";
		print "\t<td align=left><a href=\"article.php?story=" . $A["sid"] . "\">" . $A["title"] . "</a></td>\n";
		print "\t<td>" . $A["hits"] . "</td>\n";
		print "</tr>\n";
		}
        print "</table>\n";
} else {
	print $LANG10[10];
}
endblock();

	$result = dbquery("SELECT sid,title,comments from stories WHERE draft_flag = 0 AND uid > 1 and comments > 0 ORDER BY comments desc LIMIT 10");
	$nrows  = mysql_num_rows($result);
	startblock($LANG10[11]);
	if ($nrows>0) {
		print "<table cellpadding=0 cellspacing=1 border=0 width=\"99%\">\n";
		print "<tr align=center><th align=left width=\"100%\">" . $LANG10[8] . "</th><th>" . $LANG10[12] . "</th></tr>";
		for ($i=0;$i<$nrows;$i++) {
			$A      = mysql_fetch_array($result);	
			print "<tr align=center>\n";
			print "\t<td align=left><a href=\"article.php?story=" . $A["sid"] . "\">" . $A["title"] . "</a></td>\n";
			print "\t<td>" . $A["comments"] . "</td>\n";
			print "</tr>\n";
			}
		print "</table>\n";
	} else {
		print $LANG10[13];
	}
endblock();

$result = dbquery("SELECT sid,title,numemails FROM stories WHERE numemails > 0 ORDER BY numemails desc LIMIT 10");
$nrows = mysql_num_rows($result);
startblock($LANG10[22]);
if ($nrows>0) {
	print "<table cellpadding=0 cellspacing=1 border=0 width=\"99%\">\n";
        print "<tr align=center><th align=left width=\"100%\">" . $LANG10[8] . "</th><th>" . $LANG10[23] . "</th></tr>";
        for ($i=0;$i<$nrows;$i++) {
	        $A      = mysql_fetch_array($result);
                print "<tr align=center>\n";
                print "\t<td align=left><a href=\"article.php?story=" . $A["sid"] . "\">" . $A["title"] . "</a></td>\n";
                print "\t<td>" . $A["numemails"] . "</td>\n";
                print "</tr>\n";
        }
        print "</table>\n";
} else {
        print $LANG10[24];
}
endblock();


	$result = dbquery("SELECT qid,question,voters from pollquestions WHERE voters > 0 ORDER BY voters desc LIMIT 10");
	$nrows  = mysql_num_rows($result);
	startblock($LANG10[14]);
	if ($nrows>0) {
		print "<table cellpadding=0 cellspacing=1 border=0 width=\"99%\">\n";
		print "<tr align=center><th align=left width=\"100%\">" . $LANG10[15] . "</th><th>" . $LANG10[16] . "</th></tr>";
		for ($i=0;$i<$nrows;$i++) {
			$A      = mysql_fetch_array($result);
			print "<tr align=center>\n";
			print "\t<td align=left><a href=\"pollbooth.php?qid=" . $A["qid"] . "\">" . $A["question"] . "</a></td>\n";
			print "\t<td>" . $A["voters"] . "</td>\n";
			print "</tr>\n";
			}
		print "</table>\n";
	} else {
		print $LANG10[17];
	}	
endblock();

	$result = dbquery("SELECT lid,url,title,hits from links WHERE hits > 0 ORDER BY hits desc LIMIT 10");
	$nrows  = mysql_num_rows($result);
	startblock($LANG10[18]);
	if ($nrows>0) {
		print "<table cellpadding=0 cellspacing=1 border=0 width=\"99%\">\n";
		print "<tr align=center><th align=left width=\"100%\">" . $LANG10[19] . "</th><th>" . $LANG10[20] . "</th></tr>";
		for ($i=0;$i<$nrows;$i++) {
			$A      = mysql_fetch_array($result);
			print "<tr align=center>\n";
			print "\t<td align=left><a "; 
			printf("href={$CONF["site_url"]}/portal.php?url=%s&what=link&item=%s>%s</a> </td>\n",
			urlencode($A["url"]),$A["lid"],$A["title"]);
			print "\t<td>" . $A["hits"] . "</td>\n";
			print "</tr>\n";
			}
		print "</table>\n";
	} else {
		print $LANG10[21];
	}	
endblock();

// Now show stats for any plugins that want to be included
ShowPluginStats(2);

site_footer();

?>
