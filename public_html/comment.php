<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-common.php                                                            |
// | Geeklog common library.                                                   |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
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
// $Id

include_once('lib-common.php');

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

/**
* Displays the comment form
*
* @uid          int         User ID
* @save         string      ??
* @anon         string      Indicates if this is posted anonymously
* @title        string      Title of comment
* @sid          string      ID of object comment belongs to
* @pid          string      ??
* @type         string      ??
* @mode         string      ??
* @postmode     string      Indicates if comment is plain text or HTML
*
*/
function commentform($uid,$save,$anon,$title,$comment,$sid,$pid='0',$type,$mode,$postmode) 
{
    global $_TABLES, $HTTP_POST_VARS, $REMOTE_ADDR, $_CONF, $LANG03, $_USER;
	
    if ($_CONF["loginrequired2"] == 1 && empty($_USER['username'])) {
        $retval .= COM_refresh("{$_CONF['site_url']}/users.php?msg=" . urlencode($LANG03[6]));
    } else {
        DB_query("DELETE FROM {$_TABLES['commentspeedlimit']} WHERE date < unix_timestamp() - {$_CONF["speedlimit2"]}");

        $id = DB_count($_TABLES['commentspeedlimit'],'ipaddress',$REMOTE_ADDR);

        if ($id > 0) {
            $result = DB_query("SELECT date FROM {$_TABLES['commentspeedlimit']} WHERE ipaddress = '$REMOTE_ADDR'");
            $A = DB_fetchArray($result);
            $last = time() - $A[0];
			
            $retval .= COM_startBlock('Speed Limit')
                . $LANG03[7]
                . $last
                . $LANG03[8]
                . COM_endBlock();
        } else {
            if ($mode == $LANG03[14] && !empty($title) && !empty($comment) ) {
                if ($postmode == 'html') {
                    $comment = stripslashes(COM_checkHTML(COM_checkWords($comment)));
                } else {
                    $comment = stripslashes(htmlspecialchars(COM_checkWords($comment)));
                }
                $title = strip_tags(COM_checkWords($title));
                $HTTP_POST_VARS['title'] = $title;
                $HTTP_POST_VARS['comment'] = $comment;
				
                $retval .= startcomment($LANG03[14])
                    . comment($HTTP_POST_VARS,1,$type)
                    . COM_endBlock();
            } else if ($mode == $LANG03[14]) {
                $retval .= COM_startBlock($LANG03[17])
                    . $LANG03[12]
                    . COM_endBlock();
                $mode = 'error';
            }
            if (!empty($_USER['uid']) && empty($comment)) {
                $result = DB_query("SELECT sig FROM {$_TABLES['users']} WHERE uid = '{$_USER['uid']}'");
                $U = DB_fetchArray($result);
                if (!empty($U["sig"])) {
                    $comment = LB . LB . LB . '-----' . LB . $U[0];
                }
                $A['postmode'] = 'html';
            }
			
            $retval .= COM_startBlock($LANG03[1])
                . '<form action="' . $_CONF['site_url'] . '/comment.php" method="POST">'
                . '<table cellspacing="0" cellpadding="3" border="0" width="100%">' . LB
                . '<tr>' . LB
                . '<td align="right"><b>' . $LANG03[5] . ':</b></td>' . LB
                . '<td><input type="hidden" name="sid" value="' . $sid . '">'
                . '<input type="hidden" name="pid" value="' . $pid . '">'
                . '<input type="hidden" name="type" value="' . $type . '">';
				
            if (!empty($_USER['username'])) {
                $retval .= '<input type="hidden" name="uid" value="' . $_USER['uid'] . '">' 
                    . $_USER['username'] . ' [ <a href="' . $_CONF['site_url'] . '/users.php?mode=logout">'
                    . $LANG03[03] . '</a> ]</td>' . LB
                    . '</tr>' . LB;
            } else {
                $retval .= '<input type="hidden" name="uid" value="1"><a href="' . $_CONF['site_url'] 
                    . '/users.php?mode=new">' . $LANG03[04] . '</a></td>' . LB
                . '</tr>' . LB;
            }
			
            $retval .= '<tr>' . LB
                . '<td align="right"><b>' . $LANG03[16] . ':</b></td>' . LB
                . '<td><input type="text" name="title" size="32" value="' . stripslashes($title)
                . '" maxlength="96"></td>' . LB
                . '</tr>' . LB
                . '<tr>' . LB
                . '<td align="right" valign="top"><b>' . $LANG03[9] . ':</b></td>' . LB
                . '<td><textarea name="comment" wrap="physical" rows="10" cols="60">' . $comment . '</textarea></td>' . LB
                . '</tr>' . LB
                . '<tr valign="top">' . LB
                . '<td align="right"><b>' . $LANG03[2] . ':</b></td>' . LB
                . '<td><select name="postmode">'
                . COM_optionList($_TABLES['postmodes'],'code,name',$postmode)
                . '</select><br>' . COM_allowedHTML() . '</td>' . LB
                . '</tr>' . LB
                . '<tr>' . LB
                . '<td colspan="2"><hr></td>' . LB
                . '</tr>'.LB
                . '<tr>'.LB
                . '<td colspan="2">' . $LANG03[10] . '<br>'
                . '<input type="submit" name="mode" value="' . $LANG03[14] . '">';

            if ($mode == $LANG03[14]) {
                $retval .= '<input type="submit" name="mode" value="' . $LANG03[11] . '">';
            }
			
            $retval .= '</td>' . LB
                . '</tr>' . LB
                . '</table></form>'
                . COM_endBlock();
        }
    }
	
    return $retval;
}

/**
* Save a comment
*
* @uid          string      User ID of user making the comment
* @save         string      ??
* @anon         string      Indicates an anonymous post
* @title        string      Title of comment
* @comment      string      Test of comment
* @sid          string      ID of object receiving comment
* @pid          string      ??
* @type         string      ??
* @postmode     string      Indicates if text is HTML or plain text
*
*/
function savecomment($uid,$save,$anon,$title,$comment,$sid,$pid,$type,$postmode) 
{
    global $_TABLES, $_CONF, $LANG03, $REMOTE_ADDR; 

    DB_save($_TABLES['commentspeedlimit'],'ipaddress, date',"'$REMOTE_ADDR',unix_timestamp()");

    // Clean 'em up a bit!
    if ($postmode == 'html') {
        $comment = addslashes(COM_checkHTML(COM_checkWords($comment)));
    } else {
        $comment = addslashes(htmlspecialchars(COM_checkWords($comment)));
    } 

    $title = addslashes(strip_tags(COM_checkWords($title)));

    if (!empty($title) && !empty($comment)) {
        DB_save($_TABLES['comments'],'sid,uid,comment,date,title,pid',"'$sid',$uid,'$comment',now(),'$title',$pid");
		
        // See if plugin will handle this
		HandlePluginComment($type,$sid);
		
        // If we reach here then no plugin issued a COM_refresh() so continue

        $comments = DB_count($_TABLES['comments'],'sid',$sid);
		
        if ($type == 1) {
            if ($comments > 0) {
                DB_change($_TABLES['stories'],'comments',$comments,'sid',$sid);
            }			
            $retval .= COM_refresh("{$_CONF['site_url']}/pollbooth.php?qid=$sid");
        } else {
            DB_change($_TABLES['stories'],'comments',$comments,'sid',$sid);
            $retval .= COM_refresh("{$_CONF['site_url']}/article.php?story=$sid");
        }
    } else {
        $retval .= site_header()
            . COM_errorLog($LANG03[12],2)
            . commentform($sid,$poll)
            . site_footer();
    }
	
	return $retval;
}

/**
* Deletes a given comment
*
* @cid          string      Comment ID
* @sid          string      ID of object comment belongs to
* @type         string      ??
*
*/
function deletecomment($cid,$sid,$type) 
{
    global $_TABLES, $_CONF;

    if (!empty($cid) && !empty($sid)) {
        $result = DB_query("SELECT pid FROM {$_TABLES['comments']} WHERE cid = $cid");
        $A = DB_fetchArray($result);

        DB_change($_TABLES['comments'],'pid',$A['pid'],'pid',$cid);
        DB_delete($_TABLES['comments'],'cid',$cid);

        $comments = DB_count($_TABLES['comments'],'sid',$sid);

        if ($type == 1) {
            if ($comments > 0) {
                DB_change($_TABLES['stories'],'comments',$comments,'sid',$sid);
            }			
            $retval .= COM_refresh("{$_CONF['site_url']}/pollbooth.php?qid=$sid");
        } else {
            DB_change($_TABLES['stories'],'comments',$comments,'sid',$sid);
            $retval .= COM_refresh("{$_CONF['site_url']}/article.php?story=$sid");	 
        }
    }
	
    return $retval;
}

// MAIN
switch ($mode) {
case $LANG03[14]: //Preview
    $display .= site_header()
        . commentform($uid,$save,$anon,$title,$comment,$sid,$pid,$type,$mode,$postmode)
        . site_footer(); 
    break;
case $LANG03[11]: //Submit Comment
    $display .= savecomment($uid,$save,$anon,$title,$comment,$sid,$pid,$type,$postmode);
    break;
case $LANG01[28]: //Delete
    $display .= deletecomment($cid,$sid,$type);
    break;
case display:
    $display .= site_header()
        . COM_userComments($sid,$title,$type,$order,'threaded',$pid)
        . site_footer();
    break;
default:
    if (!empty($sid)) {
        $display .= site_header()
            . commentform('','','',$title,'',$sid,$pid,$type,$mode,$postmode)
            . site_footer();
    } else {
        // This could still be a plugin wanting comments
        if (strlen($type) > 0) {
            if (PluginCommentForm('','','',$title,'',$sid,$pid,$type,$mode,$postmode)) {
		        //Good, it was handled...break
                break;
            }
        } else {
            // must be a mistake at this point
            $display .= COM_refresh("{$_CONF['site_url']}/index.php");
        }
    }
}

echo $display;

?>
