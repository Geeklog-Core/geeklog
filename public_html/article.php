<?php
###############################################################################
# article.php
# This is the article page that brings it to life!
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
# Uncomment the line below if you need to debug the HTTP variables being passed
# to the script.  This will sometimes cause errors but it will allow you to see
# the data being passed in a POST operation

#debug($HTTP_POST_VARS);

###############################################################################
# MAIN
# First see if we have a plugin that may be trying to use the Geeklog comment engine

if (DoPluginCommentSupportCheck($type)) {

	// Yes, this is a plugin wanting to be commented on...do it

	$display .= refresh("{$CONF['site_url']}/comment.php?sid=$story&pid=$pid&type=$type");
}

$result = dbquery("SELECT count(*) as count FROM {$CONF['db_prefix']}stories WHERE sid = '$story'");
$A = mysql_fetch_array($result);

if ($A['count'] > 0) {
	if ($reply == $LANG01[25]) {
		refresh("{$CONF['site_url']}/comment.php?sid=$story&pid=$pid&type=$type");
	} else if ($mode == "print") {
		$result = dbquery("SELECT *,unix_timestamp(date) AS day from stories WHERE sid = '$story'");
		$A = mysql_fetch_array($result);
		$access = hasaccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
		if (hasaccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) == 0) {	
			$display .= site_header('menu')
				.startblock($LANG_ACCESS[accessdenied])
				.$LANG_ACCESS[storydenialmsg]
				.endblock()
				.site_footer();
			return;
			
			// PLEASE NOTE
			//
			// THIS CODE WILL NEED TO BE ADDRESSED!  
			// CANNOT RETURN VALUE!  NOWHERE TO RETURN TO!
			
		}
		
		$display .= '<html><title>'.$CONF['site_name'].' : '.stripslashes($A['title']).'</title><body>'.LB
			.'<h1>'.stripslashes($A['title'])."</h1>'.LB
			.'<h3>".strftime($CONF['date'],$A['day']).LB;
		if ($CONF['contributedbyline'] == 1) {
			print '<br>'.$LANG01[1].' '.getitem('users','username',"uid = '{$A['uid']}'");
		}
		$display .= '</h3>'.LB
			.'<p>'.nl2br(stripslashes($A['introtext'])).'</p>'.LB
			.'<p>'.nl2br(stripslashes($A['bodytext'])).'</p>'.LB
			.'<p><a href="'.$CONF['site_url'].'/article.php?story=$story#comments">'.dbcount('comments','sid',$A['sid']).' '.$LANG01[3].'</a>'.LB
			.'<hr>'.LB
			.'<p>'.$CONF['site_name'].'<br>'.LB
			.'<a href="'.$CONF['site_url'].'/article.php?story=$story">'.$CONF['site_url'].'/article.php?story=$story</a></p>'.LB
			.'</body>'.LB
			.'</html>';
	} else {
		// Set page title
		
		$CONF["pagetitle"] = stripslashes($A['title']);
		$display .= site_header('menu');
		$result = dbquery("SELECT *,unix_timestamp(date) AS day from stories WHERE sid = '$story'");
		$A = mysql_fetch_array($result);
		$access = hasaccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if (hasaccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) == 0) {
			$display .= startblock($LANG_ACCESS[accessdenied])
				.$LANG_ACCESS[storydenialmsg]
				.endblock()
				.site_footer();
				return;
		}
		dbchange('stories','hits','hits + 1','sid',$story);
		$sql = "SELECT *,unix_timestamp(date) AS day from {$CONF['db_prefix']}stories WHERE sid = '$story' ";
		$result = dbquery($sql);
		$A = mysql_fetch_array($result);
		# Display whats related any polls configured for this page
		
		$display .= '<table border="0" align="right">'.LB
			.'<tr>'.LB
			.'<td><img src="'.$CONF['site_url'].'/images/speck.gif" height="1" width="10"></td>'.LB
			.'<td valign="top">'
			.startblock($LANG11[1])
			.nl2br($A['related'])
			.endblock()
			.startblock($LANG11[4])
			.'<li><a href="'.$CONF['site_url'].'/profiles.php?sid='.$story.'&what=emailstory">'.$LANG11[2].'</a></li>'.LB
			.'<li><a href="'.$CONF['site_url'].'/article.php?story='.$story.'&mode=print">'.$LANG11[3].'</a></li>'.LB
			.endblock();
		if (dbcount("pollquestions","qid",$story) > 0) {
			$display .= showpoll(80,$story);
		}
		
		$display .= '<br><img src="'.$CONF['site_url'].'/images/speck.gif" width="180" height="1"></td>'.LB
			.'</tr>'.LB
			.'</table>'.LB
			.article($A,'n');
		# Display the comments, if there are any ..
		
		if ($A['commentcode'] >= 0) {
			$display .= '<br>'.LB
				.usercomments($story,$A['title'],'article',$order,$mode);
		}
		$display .= site_footer();
	}
} else {
	$display .= refresh($CONF['site_url'].'/index.php');
}
echo $display;
?>
