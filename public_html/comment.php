<?php
###############################################################################
# comment.php
# This is the comment posting script.
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
# Displays the comment form
function commentform($uid,$save,$anon,$title,$comment,$sid,$pid='0',$type,$mode,$postmode) {
	global $HTTP_POST_VARS,$REMOTE_ADDR,$CONF,$LANG03,$USER;
	
	if ($CONF["loginrequired2"] == 1 && empty($USER['username'])) {
		$retval .= refresh("{$CONF['site_url']}/users.php?msg=".urlencode($LANG03[6]));
	} else {
		dbquery("DELETE FROM {$CONF['db_prefix']}commentspeedlimit WHERE date < unix_timestamp() - {$CONF["speedlimit2"]}");
		$id = dbcount("commentspeedlimit","ipaddress",$REMOTE_ADDR);
		if ($id > 0) {
			$result = dbquery("SELECT date FROM {$CONF['db_prefix']}commentspeedlimit WHERE ipaddress = '$REMOTE_ADDR'");
			$A = mysql_fetch_row($result);
			$last = time() - $A[0];
			
			$retval .= startblock('Speed Limit')
				.$LANG03[7]
				.$last
				.$LANG03[8]
				.endblock();
		} else {
			if ($mode == $LANG03[14] && !empty($title) && !empty($comment) ) {
				if ($postmode == 'html') {
					$comment = stripslashes(checkhtml(checkwords($comment)));
				} else {
					$comment = stripslashes(htmlspecialchars(checkwords($comment)));
				}
				$title = strip_tags(checkwords($title));
				$HTTP_POST_VARS['title'] = $title;
				$HTTP_POST_VARS['comment'] = $comment;
				
				$retval .= startcomment($LANG03[14])
					.comment($HTTP_POST_VARS,1,$type)
					.endblock();
			} else if ($mode == $LANG03[14]) {
				$retval .= startblock($LANG03[17])
					.$LANG03[12]
					.endblock();
				$mode = 'error';
			}
			if (!empty($USER['uid']) && empty($comment)) {
				$result = dbquery("SELECT sig FROM {$CONF['db_prefix']}users WHERE uid = '{$USER['uid']}'");
				$U = mysql_fetch_row($result);
				if (!empty($U["sig"])) {
					$comment = LB.LB.LB.'-----'.LB.$U[0];
				}
				$A['postmode'] = 'html';
			}
			
			$retval .= startblock($LANG03[1])
				.'<form action="'.$CONF['site_url'].'/comment.php" method="POST">'
				.'<table cellspacing="0" cellpadding="3" border="0" width="100%">'.LB
				.'<tr>'.LB
				.'<td align="right"><b>'.$LANG03[5].':</b></td>'.LB
				.'<td><input type="hidden" name="sid" value="'.$sid.'">'
				.'<input type="hidden" name="pid" value="'.$pid.'">'
				.'<input type="hidden" name="type" value="'.$type.'">';
				
			if (!empty($USER['username'])) {
				$retval .= '<input type="hidden" name="uid" value="'.$USER['uid'].'">'.$USER['username'].' [ <a href="'.$CONF['site_url'].'/users.php?mode=logout">'.$LANG03[03].'</a> ]</td>'.LB
					.'</tr>'.LB;
			} else {
				$retval .= '<input type="hidden" name="uid" value="1"><a href="'.$CONF['site_url'].'/users.php?mode=new">'.$LANG03[04].'</a></td>'.LB
				.'</tr>'.LB;
			}
			
			$retval .= '<tr>'.LB
				.'<td align="right"><b>'.$LANG03[16].':</b></td>'.LB
				.'<td><input type="text" name="title" size="32" value="'.stripslashes($title).'" maxlength="96"></td>'.LB
				.'</tr>'.LB
				.'<tr>'.LB
				.'<td align="right" valign="top"><b>'.$LANG03[9].':</b></td>'.LB
				.'<td><textarea name="comment" wrap="physical" rows="10" cols="60">'.$comment.'</textarea></td>'.LB
				.'</tr>'.LB
				.'<tr valign="top">'.LB
				.'<td align="right"><b>'.$LANG03[2].':</b></td>'.LB
				.'<td><select name="postmode">'
				.optionlist('postmodes','code,name',$postmode)
				.'</select><br>'.allowedhtml().'</td>'.LB
				.'</tr>'.LB
				.'<tr>'.LB
				.'<td colspan="2"><hr></td>'.LB
				.'</tr>'.LB
				.'<tr>'.LB
				.'<td colspan="2">'.$LANG03[10].'<br>'
				.'<input type="submit" name="mode" value="'.$LANG03[14].'">';
				
			if ($mode == $LANG03[14]) {
				$retval .= '<input type="submit" name="mode" value="'.$LANG03[11].'">';
			}
			
			$retval .= '</td>'.LB
				.'</tr>'.LB
				.'</table></form>'
				.endblock();
		}
	}
	
	return $retval;
}

###############################################################################
# Saves the comment

function savecomment($uid,$save,$anon,$title,$comment,$sid,$pid,$type,$postmode) {
	global $CONF,$LANG03,$REMOTE_ADDR; 

	dbsave('commentspeedlimit','ipaddress, date',"'$REMOTE_ADDR',unix_timestamp()");

	// Clean 'em up a bit!

	if ($postmode == 'html') {
		$comment = addslashes(checkhtml(checkwords($comment)));
	} else {
		$comment = addslashes(htmlspecialchars(checkwords($comment)));
	} 

	$title = addslashes(strip_tags(checkwords($title)));

	if (!empty($title) && !empty($comment)) {
		dbsave("comments","sid,uid,comment,date,title,pid","'$sid',$uid,'$comment',now(),'$title',$pid");
		
		// See if plugin will handle this
		
		HandlePluginComment($type,$sid);
		
		// If we reach here then no plugin issued a refresh() so continue

		$comments = dbcount('comments','sid',$sid);
		
		if ($type == 1) {
			if ($comments > 0) {
				dbchange('stories','comments',$comments,'sid',$sid);
			}			
			$retval .= refresh("{$CONF['site_url']}/pollbooth.php?qid=$sid");
		} else {
			dbchange('stories','comments',$comments,'sid',$sid);
			$retval .= refresh("{$CONF['site_url']}/article.php?story=$sid");
		}
	} else {
		$retval .= site_header()
			.errorlog ($LANG03[12],2)
			.commentform($sid,$poll)
			.site_footer();
	}
	
	return $retval;
}

###############################################################################
# deletes the comment

function deletecomment($cid,$sid,$type) {
	global $CONF;

	if (!empty($cid) && !empty($sid)) {
		$result = dbquery("SELECT pid FROM {$CONF['db_prefix']}comments WHERE cid = $cid");
		$A = mysql_fetch_array($result);

		dbchange('comments','pid',$A['pid'],'pid',$cid);
		dbdelete('comments','cid',$cid);

		$comments = dbcount("comments","sid",$sid);

		if ($type == 1) {
			if ($comments > 0) {
				dbchange('stories','comments',$comments,'sid',$sid);
			}			
			$retval .= refresh("{$CONF['site_url']}/pollbooth.php?qid=$sid");
		} else {
			dbchange('stories','comments',$comments,'sid',$sid);
			$retval .= refresh("{$CONF['site_url']}/article.php?story=$sid");	 
		}
	}
	
	return $retval;
}

###############################################################################
# MAIN
switch ($mode) {
	case $LANG03[14]: //Preview
		$display .= site_header()
			.commentform($uid,$save,$anon,$title,$comment,$sid,$pid,$type,$mode,$postmode)
			.site_footer();
		break;
	case $LANG03[11]: //Submit Comment
		$display .= savecomment($uid,$save,$anon,$title,$comment,$sid,$pid,$type,$postmode);
		break;
	case $LANG01[28]: //Delete
		$display .= deletecomment($cid,$sid,$type);
		break;
	case display:
		$display .= site_header()
			.usercomments($sid,$title,$type,$order,'threaded',$pid)
			.site_footer();
		break;
	default:
		if (!empty($sid)) {
			$display .= site_header()
				.commentform("","","",$title,"",$sid,$pid,$type,$mode,$postmode)
				.site_footer();
		} else {
			// This could still be a plugin wanting comments
			if (strlen($type) > 0) {
				if (PluginCommentForm('','','',$title,'',$sid,$pid,$type,$mode,$postmode)) {
					//Good, it was handled...break
					break;
				}
			} else {
				// must be a mistake at this point
				$display .= refresh("{$CONF['site_url']}/index.php");
			}
		}
}

echo $display;
?>
