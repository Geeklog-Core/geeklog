<?php

###############################################################################
# block.php
# This is the admin blocks interface!
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

include("../common.php");
include("../custom_code.php");
include("auth.inc.php");

###############################################################################
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

function editdefaultblock($A) {
	global $USER,$LANG21,$CONF;

	startblock($LANG21[3]);
        print "<form action={$CONF["site_url"]}/admin/block.php method=post>";
        print "<table border=0 cellspacing=0 cellpadding=3 width=\"100%\">";
        print "<tr><td colspan=2><input type=submit value=save name=mode> ";
        print "<input type=submit value=cancel name=mode> ";	
	print "<input type=hidden name=bid value={$A["bid"]}></td></tr>";
	print "<tr><td align=right>{$LANG21[5]}</td><td>{$A["title"]}</td></tr>";
	print "<input type=hidden name=title value=\"{$A["title"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG21[6]}</td><td>all</td></tr>";
	print "<input type=hidden name=tid value=all></td></tr>";
	print "<tr><td align=right>{$LANG21[8]}:</td><td><input type=text size=3 name=seclev value={$A["seclev"]}> 0 - 255</td></tr>";
	print "<tr><td align=right>{$LANG21[39]}:</td><td><SELECT name=onleft>";
        print "<option value=1";
	if ($A["onleft"] == 1) {
		print " SELECTED";
	}
	print ">{$LANG21[40]}</option>";
        print "<option value=0";
	if ($A["onleft"] == 0) {
		print " SELECTED";
	}
	print ">{$LANG21[41]}</option>";
        print "</SELECT>";
	print "<tr><td align=right>{$LANG21[9]}:</td><td><input type=text size=3 name=blockorder value={$A["blockorder"]}> 0 - 255</td></tr>";	
	print "<tr><td align=right>{$LANG21[10]}:</td><td>gldefault</td></tr>";
	print "<input type=hidden name=type value=gldefault>";
	print "</form></table>";
        endblock();
}

###############################################################################
# Displays the edit block form

function editblock($bid="") {
	global $USER,$LANG21,$CONF;
	if (!empty($bid)) {
		$result = dbquery("SELECT * FROM blocks where bid ='$bid'");
		$A = mysql_fetch_array($result);
		if ($USER["seclev"] < $A["seclev"]) {
			accesslog("{$USER["name"]} attempted to edit bid $bid without rights to the block");
			startblock($LANG21[1]);
			print $LANG21[2];
			endblock(); 
			listblocks();
			exit;
		} 
		if ($A["type"] == "gldefault") {
			editdefaultblock($A);
			return;
		}
	} else {
		$A["bid"] = 0;
		$A["blockorder"] = 0;
		$A["seclev"] = $CONF["sec_block"];
	}
	startblock($LANG21[3]);
	print "<form action={$CONF["site_url"]}/admin/block.php method=post>";
	print "<table border=0 cellspacing=0 cellpadding=3 width=\"100%\">";
	print "<tr><td colspan=2><input type=submit value=save name=mode> ";
       	print "<input type=submit value=cancel name=mode> ";
	if ($A["type"] != "layout") 
	{
        	if (!empty($bid))
                	print "<input type=submit value=delete name=mode>";
	}
	print "<input type=hidden name=bid value={$A["bid"]}></td></tr>";
	print "<tr><td align=right>{$LANG21[5]}:</td><td><input type=text size=48 name=title value=\"{$A["title"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG21[6]}:</td><td><select name=tid><option value=all>{$LANG21[7]}</option>";
	print "<option value=homeonly";
	if ($A["tid"] == "homeonly") {
		print " SELECTED";
	}
	print ">$LANG21[43]</option>";
	optionlist("topics","tid,topic",$A["tid"]);
	print "</select></td></tr>";
	print "<tr><td align=right>{$LANG21[8]}:</td><td><input type=text size=3 name=seclev value={$A["seclev"]}> 0 - 255</td></tr>";
	print "<tr><td align=right>{$LANG21[39]}:</td><td><SELECT name=onleft>";
	print "<option value=1";
	if ($A["onleft"] == 1) {
		print " SELECTED";
	}
	print ">{$LANG21[40]}</option>";
	print "<option value=0";
	if ($A["onleft"] == 0) {
		print " SELECTED";
	}
	print ">{$LANG21[41]}</option>";
	print "</SELECT>";	
	print "<tr><td align=right>{$LANG21[9]}:</td><td><input type=text size=3 name=blockorder value={$A["blockorder"]}> 0 - 255</td></tr>";
	print "<tr><td align=right>{$LANG21[10]}:</td><td><select name=type>";
	print "<option value=portal";
		if ($A["type"] == "portal") print " selected";
	print ">{$LANG21[11]}</option>";
	print "<option value=normal";
		if ($A["type"] == "normal") print " selected";
	print ">{$LANG21[12]}</option>";
	print "<option value=layout";
		if ($A["type"] == "layout") print " selected";
	print ">{$LANG21[26]}</option>";
	print "<option value=phpblock";
                if ($A["type"] == "phpblock") print " selected";
        print ">{$LANG21[27]}</option>";
	print "</select></td></tr>";
	print "<tr><td colspan=2><hr></td></tr>";
	print "<tr><td colspan=2><b>{$LANG21[28]}</b></td></tr>";
        print "<tr><td align=right>{$LANG21[29]}:</td><td><input type=text size=50 maxlength=50 name=phpblockfn value=\"{$A["phpblockfn"]}\"></td></tr><tr><td colspan=2>{$LANG21[30]}</td></tr>";
	print "<tr><td colspan=2><hr></td></tr>";
	print "<tr><td colspan=2><b>{$LANG21[13]}</b></td></tr>";
	print "<tr><td align=right>{$LANG21[14]}:</td><td><input type=text size=50 maxlength=96 name=rdfurl value=\"{$A["rdfurl"]}\"></td></tr>";
	print "<tr><td align=right>{$LANG21[15]}:</td><td><input type=text size=19 name=rdfupdated value=\"{$A["rdfupdated"]}\"></td></tr>";
	print "<tr><td colspan=2><hr></td></tr>";
	print "<tr><td colspan=2><b>{$LANG21[16]}</b></td></tr>";
	print "<tr><td align=right valign=top>{$LANG21[17]}:</td><td><textarea name=content cols=50 rows=8 wrap=virtual>{$A["content"]}</textarea></td></tr>";
	print "</form></table>";
	endblock();
}

###############################################################################
# Saves the block to the database

function saveblock($bid,$title,$seclev,$type,$blockorder,$content,$tid,$rdfurl,$rdfupdated,$phpblockfn,$onleft) {
	global $CONF,$LANG21,$LANG01;

	if (($type == "normal" && !empty($title) && !empty($content)) OR ($type == "portal" && !empty($title) && !empty($rdfurl)) OR ($type == "layout" && !empty($content)) OR ($type == "gldefault" && !empty($seclev) && (strlen($blockorder)>0)) OR ($type == "phpblock" && !empty($phpblockfn) && !empty($title))) {
		if ($type == "portal") {
                        $content = "";
                        $phpblockfn = "";
                }
		if ($type == "gldefault") {
			$content = "";
			$rdfurl = "";
			$rdfupdated = "";
			$phpblockfn = "";
		}
                if ($type == "phpblock") {
                        if (!(stristr($phpblockfn,'phpblock_'))) {
                                #this is a BAD function name, must have phpblock_ prefix
                                include('../layout/header.php');
                                startblock($LANG21[37]);
                                print $LANG21[38];
                                endblock();
                                editblock($bid);
                                include('../layout/footer.php');
                                return;
                        }
                        $content = "";
                        $rdfurl = "";
                        $rdfupdated = "";
                }
                if ($type == "normal") {
                        $rdfurl = "";
                        $rdfupdated = "";
                        $phpblockfn = "";
                }
                if ($type == "layout") {
                        $rdfurl = "";
                        $rdfupdated = "";
                        $phpblockfn = "";
                }

		dbsave("blocks","bid,title,seclev,type,blockorder,content,tid,rdfurl,rdfupdated,phpblockfn,onleft","$bid,'$title','$seclev','$type','$blockorder','$content','$tid','$rdfurl','$rdfupdated','$phpblockfn',$onleft","admin/block.php?msg=11");
	} else {
		include("../layout/header.php");
                startblock($LANG21[32]);
                if ($type == "portal") {
                        #portal block is missing fields
                        print $LANG21[33];
                } else if ($type == "phpblock") {
                        #php block is missing field
                        print $LANG21[34];
                } else if ($type == "normal") {
                        #normal block is missing field
                        print $LANG21[35];
                } else if ($type == "gldefault") {
			#default geeklog field missing 
			print $LANG21[42];
		} else {
                        #layout block missing content
                        print $LANG21[36];
                }
                endblock();
                editblock($bid);
                include("../layout/footer.php");
	}
}

###############################################################################
# Displays a list of existing blocks

function listblocks() {
	global $LANG21,$CONF;
	startblock($LANG21[19]);
	adminedit("block",$LANG21[25]);
	print "<table border=0 cellspacing=0 cellpadding=2 width=\"100%\">";
	print "<tr><th align=left>{$LANG21[20]}</th><th>{$LANG21[21]}</th><th>{$LANG21[22]}</th><th>{$LANG21[39]}</th><th>{$LANG21[23]}</th><th>{$LANG21[24]}</th></tr>";
	#$result = dbquery("SELECT bid,title,seclev,type,blockorder,tid,onleft FROM blocks ORDER BY type,title asc");
	$result = dbquery("SELECT * FROM blocks ORDER BY onleft DESC,blockorder");
	$nrows = mysql_num_rows($result);
	for ($i=0;$i<$nrows;$i++) {
		$A = mysql_fetch_array($result);
		if ($A["onleft"] == 1) {
			$side = $LANG21[40];
		} else {
			$side = $LANG21[41];
		}
		if ($A["type"] == "layout") {
			$side = "-";
			$A["blockorder"] = "-";
			$A[4] = "-";
			$A[5] = "-";
		}
		print "<tr align=center><td align=left><a href={$CONF["site_url"]}/admin/block.php?mode=edit&bid={$A[0]}>{$A[1]}</a></td>";
		print "<td>{$A["seclev"]}</td><td>{$A["type"]}</td><td>$side</td><td>{$A["blockorder"]}</td><td>{$A["tid"]}</td></tr>";
	}
	print "</table>";
	endblock();
}

###############################################################################
# MAIN

switch ($mode) {
	case "delete":
		dbdelete("blocks","bid",$bid,"/admin/block.php?msg=12");
		break;
	case "save":
		saveblock($bid,$title,$seclev,$type,$blockorder,$content,$tid,$rdfurl,$rdfupdated,$phpblockfn,$onleft);
		break;
	case "edit":
		include("../layout/header.php");
		editblock($bid);
		include("../layout/footer.php");
		break;
	case "cancel":
	default:
		include("../layout/header.php");
		showmessage($msg);
		listblocks();
		include("../layout/footer.php");
		break;
}

?>
