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
	
    if ($_CONF['commentsloginrequired'] == 1 && empty($_USER['username'])) {
        $retval .= COM_refresh($_CONF['site_url'] . '/users.php?msg=' . urlencode($LANG03[6]));
    } else {
        DB_query("DELETE FROM {$_TABLES['commentspeedlimit']} WHERE date < unix_timestamp() - {$_CONF['commentspeedlimit']}");

        $id = DB_count($_TABLES['commentspeedlimit'], 'ipaddress', $REMOTE_ADDR);

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
				
                $retval .= COM_startComment($LANG03[14])
                    . COM_comment($HTTP_POST_VARS,1,$type)
                    . '</td></tr></table></td></tr></table>';
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
            }
	    if (empty($postmode)) {
	        $postmode = $_CONF['postmode'];
	    }
	       
            $comment_template = new Template($_CONF['path_layout'] . 'comment');
            $comment_template->set_file('form','commentform.thtml');
            $comment_template->set_var('site_url', $_CONF['site_url']);
            $comment_template->set_var('start_block_postacomment', COM_startBlock($LANG03[1]));
            $comment_template->set_var('lang_username', $LANG03[5]);
            $comment_template->set_var('sid', $sid);
            $comment_template->set_var('pid', $pid);
            $comment_template->set_var('type', $type);
	
            if (!empty($_USER['username'])) {
                $comment_template->set_var('uid', $_USER['uid']);
                $comment_template->set_var('username', $_USER['username']);
                $comment_template->set_var('action_url', $_CONF['site_url'] . '/users.php?mode=logout');
                $comment_template->set_var('lang_logoutorcreateaccount', $LANG03[03]);
            } else {
                $comment_template->set_var('uid', 1);
                $comment_template->set_var('username', $LANG03[24]);
                $comment_template->set_var('action_url', $_CONF['site_url'] . '/users.php?mode=new'); 
                $comment_template->set_var('lang_logoutorcreateaccount', $LANG03[04]);
            }
		
            $comment_template->set_var('lang_title', $LANG03[16]);
            $comment_template->set_var('title', stripslashes($title));
            $comment_template->set_var('lang_comment', $LANG03[9]);
            $comment_template->set_var('comment', $comment);
            $comment_template->set_var('lang_postmode', $LANG03[2]);
            $comment_template->set_var('postmode_options', COM_optionList($_TABLES['postmodes'],'code,name',$postmode));
            $comment_template->set_var('allowed_html', COM_allowedHTML());
            $comment_template->set_var('lang_importantstuff', $LANG03[18]);
            $comment_template->set_var('lang_instr_line1', $LANG03[19]);	
            $comment_template->set_var('lang_instr_line2', $LANG03[20]);	
            $comment_template->set_var('lang_instr_line3', $LANG03[21]);	
            $comment_template->set_var('lang_instr_line4', $LANG03[22]);	
            $comment_template->set_var('lang_instr_line5', $LANG03[23]);	
            $comment_template->set_var('lang_preview', $LANG03[14]);
            
            if ($mode == $LANG03[14]) {
                $comment_template->set_var('save_option', '<input type="submit" name="mode" value="' . $LANG03[11] . '">');
            }

		    $comment_template->set_var('end_block', COM_endBlock());	
            $comment_template->parse('output', 'form');
            $retval .= $comment_template->finish($comment_template->get_var('output'));
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
		PLG_handlePluginComment($type,$sid);
		
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
        $retval .= COM_siteHeader()
            . COM_errorLog($LANG03[12],2)
            . commentform($sid,$poll)
            . COM_siteFooter();
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
    $display .= COM_siteHeader()
        . commentform($uid,$save,$anon,$title,$comment,$sid,$pid,$type,$mode,$postmode)
        . COM_siteFooter(); 
    break;
case $LANG03[11]: //Submit Comment
    $display .= savecomment($uid,$save,$anon,$title,$comment,$sid,$pid,$type,$postmode);
    break;
case $LANG01[28]: //Delete
    $display .= deletecomment($cid,$sid,$type);
    break;
case display:
    $display .= COM_siteHeader()
        . COM_userComments($sid,$title,$type,$order,'threaded',$pid)
        . COM_siteFooter();
    break;
default:
    if (!empty($sid)) {
        $display .= COM_siteHeader()
            . commentform('','','',$title,'',$sid,$pid,$type,$mode,$postmode)
            . COM_siteFooter();
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
