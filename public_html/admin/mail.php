<?php
###############################################################################
# /admin/mail.php
# This is the admin index page that does nothing more that login you in.
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
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
if (!hasrights('user.mail')) {
        site_header('menu');
        startblock($MESSAGE[30]);
        print $MESSAGE[39];
        endblock();
        site_footer();
        errorlog("User {$USER['username']} tried to illegally access the poll administration screen",1);
        exit;
}

//error_reporting(15);
if (isset($mail)) {
 	if ($fra=="" || $fraepost=="" || $subject=="" || $message=="" || $sendtil=="") {
  		echo $LANG31[2];
  		exit;
	}
	/* Header information */
	$headers = "From: $fra <$fraepost>\n";
	$headers .= "X-Sender: <$fraepost>\n"; 
	$headers .= "X-Mailer: PHP\n"; // mailer
	// Urgent message!
	if (isset($priority)) {
 		$headers .= "X-Priority: 1\n"; 
	}
	$headers .= "Return-Path: <$fraepost>\n";  // Return path for errors
	/* If you want to send html mail */
	if (isset($html)) { 
 		$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Mime type 
	}
	/* and now mail it */
	if (!isset($overstyr)) {
 		$sql = "SELECT username,fullname,email,emailstories  FROM {$CONF['db_prefix']}users,{$CONF['db_prefix']}userprefs WHERE users.uid > 1";
 		$sql .= " AND users.uid = userprefs.uid AND userprefs.emailstories = 1";
	}
	if (isset($overstyr)) {
 		$sql = "SELECT username,fullname,email  FROM {$CONF['db_prefix']}users WHERE uid > 1";
	}
 
	$sendttil = "";
	$result = dbquery("$sql");
	$nrows = mysql_num_rows($result);
	for ($i=0;$i<$nrows;$i++) {
 		$A = mysql_fetch_array($result);
 
		$til = "";
		if (!isset($A["fullname"])) {
  			$til .= $A["username"];
 		} else {
  			$til .= "{$A["fullname"]}";
 		}
 		$til .= "<";
 		$til .= $A["email"];
 		$til .= ">";
 		$sendttil .= $til . "<BR>";
 		//echo "<B>Til</B> ".$til."<BR><B>Tittel</B> $subject<BR><B>Beskjed</B> $message<BR><B>Header</B>".$headers."<BR><BR>";
 
 		if (!mail("$til","$subject","$message","$headers")) {
  			echo " <b> $til</b>";
 		}
	}
}
global $CONF,$LANG31;
site_header("menu");
if (isset($sendttil)){
 	startblock($LANG31[16]);
    	echo $sendttil;
	print "<br><br>" . $LANG31[17] . "<br>";
    	endblock();
} else {
echo "
<form method=POST action=mail.php>
<input type="hidden" name=mail value=mail>";
 startblock("$LANG31[1]"); 
 echo "
  <table border="0" cellpadding="0" cellspaceing=0>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspaceing=0>
          <tr>
	    <td align="right">$LANG31[2]:</td>
            <td><input type=text name=fra value=\"$CONF[sitename]\" size=20></td>
	  </tr>
	  <tr>
             <td align="right">$LANG31[3]:</td>
	     <td><input type=text name=fraepost value=\"$CONF[sitemail]\" size=20></td>
          </tr>
          <tr>
            <td >$LANG31[4]:</td>
            <td ><input type=text name=subject size=20></td>
          </tr>
          <tr>
            <td >$LANG31[5]:</td>
            <td ><textarea rows=12 name=message cols=44></textarea></td>
          </tr>
        </table>
      </td>
      <td width=42% valign="top" ><BR><BR><BR><BR>
        <table border="0" cellpadding="0" cellspaceing=0 bgcolor=lightgrey>
          <tr>
            <th colspan="2">$LANG31[6]</td>
            </tr>
          <tr>
            <td >$LANG31[7]</td>
            <td ><INPUT type=radio name=sendtil value=alle></td>
          </tr>
	  <tr>
            <td>$LANG31[8]</td>
            <td ><INPUT type=radio name=sendtil value=adm></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td >&nbsp;</td>
          </tr>
          <tr>
            <th colspan="2">$LANG31[9]</td>
            </tr> 
          <tr>
            <td>$LANG31[10]</td>
            <td ><INPUT type=checkbox name=html value=ON></td>
          </tr>
          
          <tr>
            <td>$LANG31[11]</td>
            <td ><INPUT type=checkbox name=priority value=ON></td>
          </tr>
          <tr>
            <td>$LANG31[14]</td>
            <td ><INPUT type=checkbox name=overstyr value=ON></td>
          </tr>          
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <p align="center"><input type="submit" value=$LANG31[12] ><input type=reset value=\"$LANG31[13]\"></td>
      <td width=42% valign="top">&nbsp;</td>
    </tr>
  </table>";
endblock();
echo "</form>";
}  
site_footer();
?>
