<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | article.php                                                               |
// | Shows articles in various formats.                                        |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony@tonybibbs.com                                   |
// |          Jason Whitttenburg, jwhitten@securitygeeks.com		       |
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
// $Id: article.php,v 1.11 2001/10/17 23:35:47 tony_bibbs Exp $

include_once('lib-common.php');

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

	$display .= refresh("{$_CONF['site_url']}/comment.php?sid=$story&pid=$pid&type=$type");
}

$result = DB_query("SELECT count(*) as count FROM {$_TABLES['stories']} WHERE sid = '$story'");
$A = DB_fetchArray($result);

if ($A['count'] > 0) {
	if ($reply == $LANG01[25]) {
		refresh("{$_CONF['site_url']}/comment.php?sid=$story&pid=$pid&type=$type");
	} else if ($mode == "print") {
		$result = DB_query("SELECT *,unix_timestamp(date) AS day from stories WHERE sid = '$story'");
		$A = DB_fetchArray($result);
		$access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
		if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) == 0) {	
			$display .= site_header('menu')
				.COM_startBlock($LANG_ACCESS[accessdenied])
				.$LANG_ACCESS[storydenialmsg]
				.COM_endBlock()
				.site_footer();
			return;
			
			// PLEASE NOTE
			//
			// THIS CODE WILL NEED TO BE ADDRESSED!  
			// CANNOT RETURN VALUE!  NOWHERE TO RETURN TO!
			
		}
		
		$display .= '<html><title>'.$_CONF['site_name'].' : '.stripslashes($A['title']).'</title><body>'.LB
			.'<h1>'.stripslashes($A['title'])."</h1>'.LB
			.'<h3>".strftime($_CONF['date'],$A['day']).LB;
		if ($_CONF['contributedbyline'] == 1) {
			print '<br>'.$LANG01[1].' '.DB_getItem($_TABLES['users'],'username',"uid = '{$A['uid']}'");
		}
		$display .= '</h3>'.LB
			.'<p>'.nl2br(stripslashes($A['introtext'])).'</p>'.LB
			.'<p>'.nl2br(stripslashes($A['bodytext'])).'</p>'.LB
			.'<p><a href="'.$_CONF['site_url'].'/article.php?story=$story#comments">'.DB_count($_TABLES['comments'],'sid',$A['sid']).' '.$LANG01[3].'</a>'.LB
			.'<hr>'.LB
			.'<p>'.$_CONF['site_name'].'<br>'.LB
			.'<a href="'.$_CONF['site_url'].'/article.php?story=$story">'.$_CONF['site_url'].'/article.php?story=$story</a></p>'.LB
			.'</body>'.LB
			.'</html>';
	} else {
		// Set page title
		
		$_CONF["pagetitle"] = stripslashes($A['title']);
		$display .= site_header('menu');
		$result = DB_query("SELECT *,unix_timestamp(date) AS day FROM {$_TABLES["stories"]} WHERE sid = '$story'");
		$A = DB_fetchArray($result);
		$access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) == 0) {
			$display .= COM_startBlock($LANG_ACCESS[accessdenied])
				.$LANG_ACCESS[storydenialmsg]
				.COM_endBlock()
				.site_footer();
				return;
		}
		DB_change($_TABLES['stories'],'hits','hits + 1','sid',$story);
		$sql = "SELECT *,unix_timestamp(date) AS day FROM {$_TABLES['stories']} WHERE sid = '$story' ";
		$result = DB_query($sql);
		$A = DB_fetchArray($result);
		# Display whats related any polls configured for this page
		
		$display .= '<table border="0" align="right">'.LB
			.'<tr>'.LB
			.'<td><img src="'.$_CONF['site_url'].'/images/speck.gif" height="1" width="10"></td>'.LB
			.'<td valign="top">'
			.COM_startBlock($LANG11[1])
			.nl2br($A['related'])
			.COM_endBlock()
			.COM_startBlock($LANG11[4])
			.'<li><a href="'.$_CONF['site_url'].'/profiles.php?sid='.$story.'&what=emailstory">'.$LANG11[2].'</a></li>'.LB
			.'<li><a href="'.$_CONF['site_url'].'/article.php?story='.$story.'&mode=print">'.$LANG11[3].'</a></li>'.LB
			.COM_endBlock();
		if (DB_count($_TABLES['pollquestions'],'qid',$story) > 0) {
			$display .= COM_showPoll(80,$story);
		}
		
		$display .= '<br><img src="'.$_CONF['site_url'].'/images/speck.gif" width="180" height="1"></td>'.LB
			.'</tr>'.LB
			.'</table>'.LB
			. COM_article($A,'n');
		# Display the comments, if there are any ..
		
		if ($A['commentcode'] >= 0) {
			$display .= '<br>'.LB
				.COM_userComments($story,$A['title'],'article',$order,$mode);
		}
		$display .= site_footer();
	}
} else {
	$display .= refresh($_CONF['site_url'].'/index.php');
}
echo $display;

?>
