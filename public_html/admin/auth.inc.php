<?php

###############################################################################
# auth.php
# This is the admin authentication module.
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

###############################################################################
# MAIN

if (!empty($loginname) && !empty($passwd)) {
	$mypasswd = getpassword($loginname);
} else {
	srand((double)microtime()*1000000);
	$mypasswd = rand();
}

if (!empty($passwd) && $mypasswd == md5($passwd)) {
	$userdata = get_userdata($loginname);
	$USER=$userdata;
	$sessid = new_session($USER[uid], $REMOTE_ADDR, $CONF["session_cookie_timeout"], $CONF["cookie_ip"]);
	set_session_cookie($sessid, $CONF["session_cookie_timeout"], $CONF["cookie_session"], $CONF["cookie_path"], $CONF["cookiedomain"], $CONF["cookiesecure"]);

	// #Now that we handled session cookies, handle longterm cookie

	if (!isset($HTTP_COOKIE_VARS[$CONF["cookie_name"]])) {

		// Either their cookie expired or they are new

		$cooktime = getusercookietimeout();

		if (!empty($cooktime)) {
		
			// They want their cookie to persist for some amount of time so set it now

			setcookie($CONF["cookie_name"],$USER['uid'],time() + $cooktime,$CONF["cookie_path"]);
		}
	}
	if (!hasrights('story.edit,block.edit,topic.edit,link.edit,event.edit,poll.edit,user.edit,plugin.edit','OR')) {
		$display .= refresh($CONF['site_url'] . '/admin/moderation.php');
	} else {
		$display .= refresh($CONF['site_url'] . '/index.php');
	}
} else if (!hasrights('story.edit,block.edit,topic.edit,link.edit,event.edit,poll.edit,user.edit,plugin.edit','OR')) {
	$display .= site_header();

	#print "<br>Input: " . md5($passwd) . "<br>Database: $mypasswd<br>"; 

	$display .= startblock($LANG20[01]);
	
	if (!empty($warn)) {
		$display .= $LANG20[02]
		.'<br><br>'
		.accesslog($LANG20[03]);
	}
	
	$display .= '<form action="'.$PHP_SELF.'" method="POST">'
		.'<table cellspacing="0" cellpadding="0" border="0" width="100%">'.LB
		.'<tr><td align="right">'.$LANG20[04].'</td>'.LB
		.'<td><input type="text" name="loginname" size="16" maxlength="16"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right">'.$LANG20[05].'</td>'.LB
		.'<td><input type="password" name="passwd" size="16" maxlength="16"></td>'
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td colspan="2" align="center" class="warning">'.$LANG20[06].'<input type="hidden" name="warn" value="1">'
		.'<br><input type="submit" name="mode" value="'.$LANG20[07].'"></td>'.LB
		.'</tr>'.LB
		.'</table></form>'
		.endblock()
		.site_footer();
}

echo $display;
?>
