<?php
###############################################################################
# words.php
# This is the word replacement interface!
#
# Copyright (C) 2001 Tane Piper
# tane@zopegeeks.org
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
include("../lib-common.php");
include("../custom_code.php");
include("auth.inc.php");
#Make sure user is root
if (!ingroup('Root')) {
	site_header('menu');
        startblock($MESSAGE[30]);
        print $MESSAGE[41];
        endblock();
        site_footer();
        errorlog("User {$USER['username']} tried to illegally access the poll administration screen",1);
        exit;
}

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation
#debug($HTTP_POST_VARS);
###############################################################################
# Displays the topic editor
function editword($wid="") {
	global $CONF,$LANG_WORDS;
    $result = dbquery("SELECT * FROM {$CONF['db_prefix']}wordlist where wid ='$wid'");
	$A = mysql_fetch_array($result);
    	if (empty($wid))
               $wid = $A["wid"];
	startblock($LANG_WORDS[editor]);
    print "<form action={$CONF['site_url']}/admin/word.php method=post>";
	print "<table border="0" cellspacing="0" cellpadding=2 width="100%">";
	print "<tr><td colspan="2"><input type="submit" value=save name=mode> ";
	if (!empty($wid)) print "<input type="submit" value=delete name=mode>";
	print "<tr></td>";
	print "<tr><td align="right">{$LANG_WORDS[newword]}:</td><td><input type=text size=20 name=word value=\"{$A["word"]}\"></td></tr>";
  	print "<tr><td align="right">{$LANG_WORDS[replacmentword]}:</td><td><input type=text size=20 name=replaceword value=\"{$A["replaceword"]}\"></td></tr>";
    print "</form>";
endblock();
}

###############################################################################
# Saves $grp_id to the database
function saveword($word,$replaceword) {
	global $CONF,$LANG_WORDS;
 	if (!empty($word) && !empty($replaceword)) {
		#Convert array values to numeric permission values
        $result = mysql_query("SELECT * FROM wordlist");
        $num_rows = mysql_num_rows($result);
        $wid = $num_rows + 1;
		dbsave("wordlist","wid, word, replaceword","'$wid', '$word', '$replaceword'","admin/word.php?msg=42");
	} else {
		site_header('menu');
		errorlog($LANG27[7],2);
		editword($wid);
		site_footer();
	}
}

###############################################################################
# Displays a list of topics
function listgroups() {
	global $CONF,$LANG_WORDS;
        startblock($LANG_WORDS[wordmanager]);
        adminedit("word",$LANG_WORDS[intro]);
        print "<table border="0" cellspacing="0" cellpadding=2 width="100%">";
        print "<tr><th align="left">{$LANG_WORDS[wordid]}</th><th>{$LANG_WORDS[word]}</th><th>{$LANG_WORDS[replacmentword]}</th></tr>";
        $result = dbquery("SELECT * FROM {$CONF['db_prefix']}wordlist");
        $nrows = mysql_num_rows($result);
        for ($i=0;$i<$nrows;$i++) {
                $A = mysql_fetch_array($result);
                  print "<tr align="center"><td align="left"><a href={$CONF['site_url']}/admin/word.php?mode=edit&wid={$A["wid"]}>" . $A["wid"] . "</a></td>";
                  print "<td>" . $A["word"] . "</td><td>" . $A["replaceword"] . "</td></tr>";
        }
        print "</table></form>";
        endblock();
}

###############################################################################
# MAIN
switch ($mode) {
	case "delete":
		dbdelete("wordlist","wid",$wid,"/admin/word.php?msg=43");
		break;
	case "save":
		saveword($word,$replaceword);
		break;
	case "edit":
		site_header("menu");
		editword($wid);
		site_footer();
		break;
	case "cancel":
	default:
		site_header("menu");
		showmessage($msg);
		listgroups();
		site_footer();
		break;
}
?>
