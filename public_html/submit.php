<?php
###############################################################################
# submit.php
# This is the page to contribute stories on.
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
# This is the submission it is modular to allow us to write as little as
# possible.  It takes a type and formats a form for the user.  Currently the
# types are link, story and event.  If no type is provided, Story is assumed.
function submissionform($type="story") {
	global $CONF,$LANG12,$REMOTE_ADDR,$USER;
	
	dbquery("DELETE FROM {$CONF['db_prefix']}submitspeedlimit WHERE date < unix_timestamp() - {$CONF["speedlimit"]}");
	$id = dbcount("submitspeedlimit","ipaddress",$REMOTE_ADDR);
	if ($id > 0) {
		$result = dbquery("SELECT date FROM {$CONF['db_prefix']}submitspeedlimit WHERE ipaddress = '$REMOTE_ADDR'");
		$A = mysql_fetch_row($result);
		$last = time() - $A[0];
		$retval .= startblock($LANG12[26])
			.$LANG12[30]
			.$last
			.$LANG12[31]
			.endblock();
	} else {
		if ($CONF['loginrequired'] == 1 && empty($USER['username'])) {
			$retval .= startblock($LANG12[7])
				.$LANG12[1]
				.'<br>[ <a href="'.$CONF['site_url'].'">'.$LANG12[2].'</a> | <a href="'.$CONF['site_url'].'/users.php">'.$LANG12[3].'</a> ]';
			return $retval;
		} else {
			$retval .= startblock($LANG12[19])
				.$LANG12[9]
				.endblock();
				
			switch ($type) {
				case 'link':
					$retval .= submitlink();
					break;
				case 'event':
					$retval .= submitevent();
					break;
				default:
					if ((strlen($type) > 0) && ($type <> 'story')) {
						$retval .= SubmitPlugin($type);
						break;
					} 
					$retval .= submitstory();
					break;
			}
		}
	}

	return $retval;
}

###############################################################################
# These are the submission widgets
function submitevent() {
	global $CONF,$LANG12;
	$retval .= '';
	
	$retval .= startblock($LANG12[4],'submitevent.html')
		.print $LANG12[37]
		.'<form action="'.$CONF['site_url'].'/submit.php" method="post">'
		.'<table border="0" cellspacing="0" cellpadding="3">'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[10].':</b></td>'.LB
		.'<td><input type="text" size="36" maxlength="96" name="title"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[11].':</b></td>'.LB
		.'<td><input type="text" size="36" maxlength="96" name="url" value="http://"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[12].':</b></td>'.LB
		.'<td><input type="text" size="10" maxlength="10" name="datestart" value="yyyy-mm-dd"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[13].':</b></td>'.LB
		.'<td><input type="text" size="10" maxlength="10" name="dateend" value="yyyy-mm-dd"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[14].':</b></td>'.LB
		.'<td><textarea name="location" cols=45 rows=3 wrap=virtual></textarea></td></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[15].':</b></td>'.LB
		.'<td><textarea name="description" cols="45" rows="6" wrap="virtual"></textarea></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="center" colspan="2">'.$LANG12[35].'</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="center" colspan="2"><input type="hidden" name="mode" value="'.$LANG12[8].'">'
		.'<input type="hidden" name="type" value="event"><input type="submit" value="'.$LANG12[8].'"></td>'.LB
		.'</tr>'.LB
		.'</table></form>'
		.endblock();
		
	return $retval;
}

function submitlink() {
	global $CONF,$LANG12;
	
	$retval .= startblock($LANG12[5],'submitlink.html')
		.'<form action="'.$CONF['site_url'].'/submit.php" method="post">'
		.'<table border="0" cellspacing="0" cellpadding="3">'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[10].':</b></td>'.LB
		.'<td><input type="text" size="36" maxlength="96" name="title"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[11].':</b></td>'.LB
		.'<td><input type="text" size="36" maxlength="96" name="url" value="http://"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[17].':</b></td>'.LB
		.'<td><select name="categorydd">'.LB;
		
	$result = dbquery("SELECT DISTINCT category FROM {$CONF['db_prefix']}links");
	$nrows = mysql_num_rows($result);
	if ($nrows > 0) {
		for ($i=0; $i<$nrows; $i++) {
			$category = mysql_result($result,$i);
			$retval .= '<option value="$category">'.$category.'</option>'.LB;
		}
	}
	
	$retval .= '<option>'.$LANG12[18].'</option>'.LB
		.'</select>'
		.' <b>'.$LANG12[16].':</b> <input type="text" name="category" size="12" maxlength="32"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[15].':</b></td>'.LB
		.'<td><textarea name="description" cols="45" rows="6" wrap="virtual"></textarea></td>'.LB
		.'</tr>'.LB
		.'<tr><td align="center" colspan="2">'.$LANG12[35].'</td></tr>'.LB
		.'<tr><td align="center" colspan="2"><input type="hidden" name="mode" value="'.$LANG12[8].'">'
		.'<input type="hidden" name="type" value="link"><input type="submit" value="'.$LANG12[8].'"></td>'.LB
		.'</tr>'.LB
		.'</table></form>'
		.endblock();
	
	return $retval;
}

function submitstory() {
	global $HTTP_POST_VARS,$CONF,$LANG12,$USER;

	if ($HTTP_POST_VARS["mode"] == $LANG12[32]) {
		$A = $HTTP_POST_VARS;
	} else {
		$A['sid'] = makesid();
		$A['uid'] = $USER['uid'];
		$A['unixdate'] = time();
	}
	
	if (!empty($A['title'])) {
		if ($A['postmode'] == 'html') {
			$A['introtext'] = addslashes(checkhtml(checkwords($A['introtext'])));
		} else {
			$A['introtext'] = htmlspecialchars(checkwords($A['introtext']));
		}
		$A['title'] = stripslashes($A['title']);
		$retval .= startblock($LANG12[32])
			.article($A,'n')
			.endblock();
	}
	
	$retval .= startblock($LANG12[6],'submitstory.html')
		.'<form action="'.$CONF['site_url'].'/submit.php" method="post">'
		.'<table border="0" cellspacing="0" cellpadding="3">'.LB;
		
	if (!empty($USER['username'])) {
		$retval .= '<tr>'.LB
			.'<td align="right"><b>'.$LANG12[27].':</b></td>'.LB
			.'<td>'.$USER['username'].' [ <a href="'.$CONF['site_url'].'/users.php?mode=logout">'.$LANG12[34].'</a> ]</td>'.LB
			.'</tr>'.LB;
	} else {
		$retval .= '<tr>'.LB
			.'<td align="right"><b>'.$LANG12[27].':</b></td>'.LB
			.'<td>[ <a href="'.$CONF['site_url'].'/users.php">Log In</a> | <a href="'.$CONF['site_url'].'/users.php?mode=new">Create Account</a> ]</td>'.LB
			.'</tr>'.LB;
	}
	
	$retval .= '<tr>'
		.'<td align="right"><b>'.$LANG12[10].':</b></td>'.LB
		.'<td><input type="text" size="36" maxlength="96" name="title" value="'.$A['title'].'"></td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="right"><b>'.$LANG12[28].':</b></td>'.LB
		.'<td><select name=tid>'.LB
		.optionlist('topics','tid,topic',$A['tid'])
		.'</select></td>'.LB
		.'</tr>'.LB
		.'<tr valign="top">'.LB
		.'<td align="right"><b>'.$LANG12[29].':</b></td>'.LD
		.'<td><textarea name="introtext" cols="45" rows="12" wrap="virtual">'.stripslashes($A['introtext']).'</textarea></td>'.LB
		.'</tr>'.LB
		.'<tr valign="top">'.LB
		.'<td align="right"><b>'.$LANG12[36].':</b></td>'.LB
		.'<td><select name="postmode">'
		.optionlist('postmodes','code,name',$A['postmode'])
		.'</select><br>'.allowedhtml().'</td>'.LB
		.'</tr>'.LB
		.'<tr>'.LB
		.'<td align="center" colspan="2"><input type="hidden" name="type" value=story>'
		.'<input type="hidden" name="uid" value="'.$A['uid'].'">'
		.'<input type="hidden" name="sid" value="'.$A['sid'].'">'
		.'<input type="hidden" name="date" value="'.$A['unixdate'].'">';
		
	if ($A['mode'] == $LANG12[32]) {
		$retval .= '<input name="mode" type="submit" value="'.$LANG12[8].'">';
	}
	
	$retval .= ' <input name="mode" type="submit" value="'.$LANG12[32].'"></td>'.LB
		.'</tr>'.LB
		.'</table></form>'
		.endblock();
		
	return $retval;
}

function savesubmission($type,$A) {
	global $LANG12,$USER,$REMOTE_ADDR;
	
	dbsave("submitspeedlimit","ipaddress, date","'$REMOTE_ADDR',unix_timestamp()");
	switch ($type) {
		case 'link':
			if (!empty($A['title']) && !empty($A['description']) && !empty($A['url'])) {
				if ($A['categorydd'] != $LANG12[18] && !empty($A['categorydd'])) {
					$A['category'] = $A['categorydd'];
				} else if ($A['categorydd'] != $LANG12[18]) {
					$retval .= startblock($LANG12[20])
						.$LANG12[21]
						.endblock()
						.submissionform($type);
					
					return $retval;
				}
				$A['description'] = addslashes(htmlspecialchars(checkwords($A['description'])));
				$A['title'] = addslashes(strip_tags(checkwords($A['title'])));
				$A['lid'] = makesid();
				$result = dbsave('linksubmission','lid,category,url,description,title',"{$A["lid"]},'{$A["category"]}','{$A["url"]}','{$A["description"]}','{$A['title']}'","index.php?msg=3");
			} else {
				$retval .= startblock($LANG12[22])
					.$LANG12[23]
					.endblock()
					.submissionform($type);

				return $retval; 
			}
			break;
		case "event":
			if (!empty($A['title']) && !empty($A["description"])) {
				$A["description"] = addslashes(htmlspecialchars(checkwords($A["description"])));
				$A['title'] = addslashes(strip_tags(checkwords($A['title'])));
				$A["eid"] = makesid();
				$result = dbsave('eventsubmission','eid,title,url,datestart,dateend,location,description',"{$A["eid"]},'{$A['title']}','{$A["url"]}','{$A["datestart"]}','{$A["dateend"]}','{$A["location"]}','{$A["description"]}'","index.php?msg=4");
			} else {
				$retval .= startblock($LANG12[22])
					.$LANG12[23]
					.endblock()
					.submissionform($type);
				
				return $retval;
			}
			break;
		default:
			if ((strlen($type) > 0) && ($type <> 'story')) {
				// see if this is a submission that needs to be handled by a plugin
				if (SavePluginSubmission($type, $A)) {
					// great, it worked, lets get out of here
					break;
				} else {
					// something went wrong, exit
					$retval .= errorlog ("could not save your submission.  Bad type: $type");
					return $retval;
				}
			}			
			if (!empty($A['title']) && !empty($A['introtext'])) {
				if ($A['postmode'] == 'html') {
					$A['introtext'] = addslashes(checkhtml(checkwords($A['introtext'])));
				} else {
					$A['introtext'] = addslashes(htmlspecialchars(checkwords($A['introtext'])));
				}
				$A['title'] = addslashes(strip_tags(checkwords($A['title'])));
				$A['sid'] = makesid();
				if (empty($USER['uid'])) { 
					$USER['uid'] = 1;
				}					
				dbsave('storysubmission',"sid,tid,uid,title,introtext,date,postmode","{$A["sid"]},'{$A["tid"]}',{$USER['uid']},'{$A['title']}','{$A["introtext"]}',NOW(),'{$A["postmode"]}'","index.php?msg=2");
			} else {
				$retval .= startblock($LANG12[22])
					.$LANG12[23]
					.endblock()
					.submissionform($type);
					
				return $retval;
			}
			break;
	}
	return $retval;
}

###############################################################################
# MAIN

	$display .= site_header();
	
	if ($mode == $LANG12[8]) { 
		$display .= savesubmission($type,$HTTP_POST_VARS);
	} else { 
		$display .= submissionform($type); 
	}
	
	$display .= site_footer();	
	
	echo $display;
?>
