<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | story.php                                                                 |
// | Geeklog story administration page.                                        |
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
// $Id: story.php,v 1.16 2001/10/17 23:35:48 tony_bibbs Exp $

include('../lib-common.php');
include('auth.inc.php');

// Set this to true if you want to have this code output debug messages to 
// the error log
$_STORY_VERBOSE = false;

$display = '';

if (!SEC_hasRights('story.edit')) {
    $display .= site_header('menu');
    $display .= $display .= COM_startBlock($MESSAGE[30]); 
    $display .= $MESSAGE[31];
    $display .= $display .= COM_endBlock();
    $display .= site_footer();
    COM_errorLog("User {$_USER['username']} tried to illegally access the story administration screen",1);
    echo $display;
    exit;
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

# Displays the Story Editor
/**
* Shows story editor
*
* Displays the story entry form
*
* @sid		string		ID of story to edit
* @mode		string		??
*/
function storyeditor($sid, $mode = '') 
{
    global $_TABLES, $HTTP_POST_VARS, $_USER, $_CONF, $LANG24, $LANG_ACCESS;

    $display = '';

    if (!empty($sid) && $mode == "edit") {
        $result = DB_query("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['stories']} WHERE sid = '$sid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access == 2) {
            $display .= COM_startBlock($LANG24[40]);
            $display .= $LANG24[41];
            $display .= COM_endBlock();
            $display .= COM_article($A,n);
            return;
        } else if ($access == 0) {
            $display .= COM_startBlock($LANG24[40]);
            $display .= $LANG24[42];
            $display .= COM_endBlock();
            return;
        }
    } elseif (!empty($sid) && $mode == "editsubmission") {
        $result = DB_query("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['storysubmission']} WHERE sid = '$sid'");
        $A = DB_fetchArray($result);
        $A["commentcode"] = 0;
        $A["featured"] = 0;
        $A["statuscode"] = 0;
        $A['owner_id'] = $_USER['uid'];
        $A['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Story Admin'");
        $A['perm_owner'] = 3;
        $A['perm_group'] = 3;
        $A['perm_members'] = 2;
        $A['perm_anon'] = 2;
        $access = 3;
    } elseif ($mode == "edit") {
        $A["sid"] = COM_makesid();
        $A['uid'] = $_USER['uid'];
        $A["unixdate"] = time();
        $A["commentcode"] = 0;
        $A["statuscode"] = 0;
        $A["featured"] = 0;
        $A['owner_id'] = $_USER['uid'];
        $A['group_id'] = DB_getItem($_TABLES['groups'],'grp_id',"grp_name = 'Story Admin'");
        $A['perm_owner'] = 3;
        $A['perm_group'] = 3;
        $A['perm_members'] = 2;
        $A['perm_anon'] = 2;
        $access = 3;
    } else {
        $A = $HTTP_POST_VARS;
        if ($A["postmode"] == "html") {
            $A["introtext"] = COM_checkHTML(COM_checkWords($A["introtext"]));
            $A["bodytext"] = COM_checkHTML(COM_checkWords($A["bodytext"]));
        } else {
            $A["introtext"] = htmlspecialchars(COM_checkWords($A["introtext"]));
            $A["bodytext"] = htmlspecialchars(COM_checkWords($A["bodytext"]));
        }
        $A['title'] = strip_tags($A['title']);
    }
    if (!empty($A['title'])) {
        $display .= COM_startBlock($LANG24[26]);
        $display .= COM_article($A,"n");
        $display .= COM_endBlock();
    }
    $display .= COM_startBlock($LANG24[5]);
    $display .= '<form action="' . $_CONF['site_url'] . '/admin/story.php" method="post">';
    $display .= '<table border="0" cellspacing="0" cellpadding="3" width="100%">';
    $display .= '<tr><td colspan="2"><input type="submit" value=save name=mode> ';
    $display .= '<input type="submit" value="preview" name="mode"> ';
    $display .= '<input type="submit" value="cancel" name="mode"> ';
    if ($access == 3) {
        $display .= '<input type="submit" value="delete" name="mode"> ';
    }
    if ($A['type'] == 'editsubmission' || $mode == 'editsubmission') {
        $display .= '<input type="hidden" name="type" value="submission">';
    }
    $display .= "<tr></td>";
    $display .= '<tr><td align="right">' . $LANG24[7] . ':</td><td>' . DB_getItem("users","username","uid = {$A['uid']}") 
        . '<input type="hidden" name="uid" value=' . $A['uid'] . '></td></tr>';

    // user access info
    $display .= '<tr><td colspan="2"><hr><td></tr>';
    $display .= '<tr><td colspan="2"><b>' . $LANG_ACCESS[accessrights] . '<b></td></tr>';
    $display .= '<tr><td align="right">' . $LANG_ACCESS[owner] . ':</td><td>' 
        . DB_getItem($_TABLES['users'],'username',"uid = {$A['owner_id']}");
    $display .= '<input type="hidden" name="owner_id" value="' . $A['owner_id'] . '"></td></tr>';
    $display .= '<tr><td align="right">' . $LANG_ACCESS[group] . ':</td><td>';
    $usergroups = SEC_getUserGroups();
    if ($access == 3) {
        $display .= '<SELECT name="group_id">';
        for ($i = 0; $i < count($usergroups); $i++) {
            $display .= '<option value="' . $usergroups[key($usergroups)] . '"';
            if ($A['group_id'] == $usergroups[key($usergroups)]) {
                $display .= ' SELECTED';
            }
            $display .= '>' . key($usergroups) . '</option>';
            next($usergroups);
        }
        $display .= '</SELECT>';
    } else {
        // they can't set the group then
        $display .= DB_getItem($_TABLES['groups'],'grp_name',"grp_id = {$A['group_id']}");
        $display .= '<input type="hidden" name="group_id" value="' . $A['group_id'] . '">';
    }
    $display .= '</td><tr><tr><td colspan="2"><b>' . $LANG_ACCESS[permissions] . '</b>:</td></tr><tr><td colspan="2">';
    $display .= '</td><tr><tr><td colspan="2">' . $LANG_ACCESS[permissionskey] . '</td></tr><tr><td colspan="2">';
    $display .= SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
    $display .= '</td></tr>';
    // $display .= "></td></tr>";
    $display .= '<tr><td colspan="2">' . $LANG_ACCESS[permmsg] . '<td></tr>';
    $display .= '<tr><td colspan="2"><hr><td></tr>';
    $curtime = COM_getUserDateTimeFormat($A['unixdate']);
    $display .= '<tr><td align="right">' . $LANG24[15] . ':</td><td>' . $curtime[0] . '<input type="hidden" name="unixdate" value="' . $A['unixdate'] . '"></td></tr>';
    // $display .= "<tr><td align="right">{$LANG24[15]}:</td><td>". strftime($_CONF["date"],$A["unixdate"]) . "<input type="hidden" name=unixdate value={$A["unixdate"]}></td></tr>";
    $display .= '<tr><td align="right">' . $LANG24[13] . ':</td><td><input type="text" size="48" maxlength="255" name="title" value="' . stripslashes($A['title']) . '"></td></tr>';
    $display .= '<tr><td align="right">' . $LANG24[14] . ':</td><td><select name="tid">';
    $display .= COM_optionList($_TABLES['topics'],'tid,topic',$A["tid"]);
    $display .= '</select></td></tr>';
    $display .= '<tr><td align="right">' . $LANG24[34] . ':</td><td><input type="checkbox" name="draft_flag"';
    if ($A["draft_flag"] == 1) {
        $display .= ' checked';
    }
    $display .= '></td></tr>';
    $display .= '<tr><td align="right">' . $LANG24[3] . ':</td><td><select name="statuscode">';
    $display .= COM_optionList($_TABLES['statuscodes'],'code,name',$A["statuscode"]);
    $display .= '</select> <select name="commentcode">';
    $display .= COM_optionList($_TABLES['commentcodes'],'code,name',$A["commentcode"]);
    $display .= '</select> <select name="featured">';
    $display .= COM_optionList($_TABLES['featurecodes'],'code,name',$A["featured"]);
    $display .= '</select> <select name="frontpage">';
    $display .= COM_optionList($_TABLES['frontpagecodes'],'code,name',1);
    $display .= '</select></td></tr>';
    $display .= '<tr><td valign="top" align="right">' . $LANG24[16] 
        . ':</td><td><textarea name="introtext" cols="50" rows="6" wrap="virtual">' . stripslashes($A['introtext']) 
        . '</textarea></td></tr>';
    $display .= '<tr><td valign="top" align="right">' . $LANG24[17] 
        . ':</td><td><textarea name="bodytext" cols="50" rows="8" wrap="virtual">' . stripslashes($A['bodytext']) 
        . '</textarea></td></tr>';
    $display .= '<tr valign="top"><td align="right"><b>' . $LANG24[4] . ':</b></td><td><select name="postmode">';
    $display .= COM_optionList($_TABLES['postmodes'],'code,name',$A["postmode"]);
    $display .= '</select><br>';
    $dispaly .= COM_allowedHTML();
    $display .= '</td></tr>' . LB;
    $display .= '<tr><td align="right">' . $LANG24[18] 
        . ':</td><td><input type="hidden" name="hits" value="' . $A['hits'] . '">' . $A['hits'] . '</td></tr>';
    $display .= '<tr><td align="right">' . $LANG24[19] . ':</td><td>' . $A['comments'] 
        . '<input type="hidden" name="comments" value="' . $A['comments'] . '"></td></tr>';
    $display .= '<tr><td align="right">' . $LANG24[39] . ':</td><td>' . $A['numemails'] 
        . '<input type="hidden" name="numemails" value="' . $A['numemails'] . '"></td></tr>';
    $display .= '<input type="hidden" name="sid" value="' . $A['sid'] . '"></td></tr>';
    $display .= '</table>';
    $display .= COM_endBlock();
	$display .= '</form>';

    return $display;
}

/**
* List all stories in the system
*
* This lists all the stories in the database
*
* @page     int     Page to show user
*
*/
function liststories($page="1") 
{
    global $_TABLES, $LANG24, $_CONF, $LANG_ACCESS;

    $display = '';

    $display .= COM_startBlock($LANG24[22]);
    $display .= COM_adminEdit('story',$LANG24[23]);

    if (empty($page)) {
        $page = 1;
    }

    $limit = (50 * $page) - 50;
    $result = DB_query("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$_CONF['db_prefix']}stories ORDER BY date DESC LIMIT $limit,50");
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        $display .= '<table cellpadding="0" cellspacing="3" border="0" width="100%">' . LB;
        $display .= '<tr><th align="left">#</th><th align="left">' . $LANG24[13] . '</th><th>' . $LANG_ACCESS[access] 
            . '</th><th>' . $LANG24[34] . '</th><th>' . $LANG24[7] . '</th><th>' . $LANG24[15] . '</th><th>' 
            . $LANG24[14] . '</th><th>' . $LANG24[32] . '</th></tr>';
        for ($i = 1; $i <= $nrows; $i++) {
            $scount = (50 * $page) - 50 + $i;
            $A = DB_fetchArray($result);
            $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
            if ($access > 0) {
                if ($access == 3) {
                    $access = $LANG_ACCESS[edit];
                } else {
                    $access = $LANG_ACCESS[readonly];
                }
            } else {
                $access = $LANG_ACCESS[none];
            }
            $curtime = COM_getUserDateTimeFormat($A['unixdate']);
            $display .= '<tr align="center"><td align="left"><a href="' . $_CONF['site_url'] 
                . '/admin/story.php?mode=edit&sid=' . $A['sid'] . '">' . $scount . '</a></td>';
            $display .= '<td align="left"><a href="' . $_CONF['site_url'] . '/article.php?story=' . $A['sid'] . '">' 
                . stripslashes($A['title']) . '</a></td>';
            $display .= '<td align="center">' . $access . '</td>';
            if ($A['draft_flag'] == 1) {
                $display .= '<td>' . $LANG24[35] . '</td>';
            } else {
                $display .= '<td>' . $LANG24[36] . '</td>';
            }
            $display .= '<td>' . DB_getItem($_TABLES['users'],'username',"uid = {$A['uid']}") . '</td>';
            // $display .="<td>" . strftime("%x %X",$A["unixdate"]) . "</td>";
            $display .= '<td>' . $curtime[0] . '</td>';
            $display .= '<td>' . $A['tid'] . '</td><td>';
            if ($A['featured'] == 1) {
                $display .= $LANG24[35] . '</td></tr>';
            } else {
                $display .= $LANG24[36] . '</td></tr>';
            }
        }
        $display .= '<tr><td colspan="6">';
        if (DB_count($_TABLES['stories']) > 50) {
            $prevpage = $page - 1;
            $nextpage = $page + 1;
            if ($pagestart >= 50) {
                $display .= '<a href="' . $_CONF['site_url'] . '/admin/story.php?mode=list&page=' 
                    . $prevpage . '">' . $LANG24[1] . '</a> ';
            }
            if ($pagestart <= (DB_count($_TABLES['stories']) - 50)) {
                $display .= '<a href="' . $_CONF['site_url'] . '/admin/story.php?mode=list&page='
                    . $nextpage . '">' . $LANG24[2] . '</a> ';
            }
        }
        $display .= '</td></tr></table>' . LB;
    }
    $display .= COM_endBlock();

    return $display;
}

###############################################################################
# Saves a story to the database
/** 
* Saves story to database
*
* @type         string      ??
* @sid          string      ID of story to save
* @uid          string      ID of user that wrote the story
* @tid          string      Topic ID story belongs to
* @title        string      Title of story
* @introtext    string      Introduction text
* @bodytext     string      Text of body
* @hits         int         Number of times story has been viewed
* @unixdate     string      Date story was originally saved
* @comments     int         Number of user comments made to this story
* @featured     int         Flag on whether or not this is a featured article
* @commentcode  string      Indicates if comments are allowed to be made to article
* @statuscode   string      Status of the story
* @postmode     string      Is this HTML or plain text?
* @frontpage    string      Flag indicates if story will appear on front page and topic or just topic
* @draft_flag   string      Flag indicates if story is a draft or not
* @numemails    int         Number of times this story has been emailed to someone
* @owner_id     int         ID of owner (not necessarily the author)
* @group_id     int         ID of group story belongs to
* @perm_owner   int         Permissions the owner has on story
* @perm_group   int         Permissions the group has on story
* @perm_member  int         Permissions members have on story
* @perm_anon    int         Permissions anonymous users have on story
*
*/
function submitstory($type="",$sid,$uid,$tid,$title,$introtext,$bodytext,$hits,$unixdate,$comments,$featured,$commentcode,$statuscode,$postmode,$frontpage,$draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon) 
{
    global $_TABLES, $_CONF, $LANG24;
    if (!empty($title) && !empty($introtext)) {
        if (empty($hits)) {
            $hits = 0;
        }

        if ($draft_flag == "on") {
            $draft_flag = 1;
        } else {
            $draft_flag = 0;
        }

        // Convert array values to numeric permission values
        list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);

        if ($featured == "1") {
            // there can only be one non-draft featured story
            if ($draft_flag == 0) {
                DB_change($_TABLES['stories'],'featured','0','featured','1','draft_flag','0');
            }

            // if set to featured force to show on front page
            $frontpage = 1;
        }

        if (empty($numemails)) {
            $numemails = 0;
        }

        $date = date("Y-m-d H:i:s",$unixdate);

        // Get the related URLs
        $fulltext = "$introtext $bodytext";
        $check = " ";
        while($check != $reg[0]) {
            $check = $reg[0];

            // this gets any links from the article
            eregi("<a([^<]|(<[^/])|(</[^a])|(</a[^>]))*</a>",$fulltext,$reg);

            // this gets what is between <a href=...> and </a>
            preg_match("/<a href=([^\]]+)>([^\]]+)<\/a>/",stripslashes($reg[0]),$url_text);
            if (empty($url_text[1])) {
                preg_match("/<A HREF=([^\]]+)>([^\]]+)<\/A>/",stripslashes($reg[0]),$url_text);
            }
			
            $orig = $reg[0]; 

            //if links is too long, shorten it and add ... at the end
            if (strlen($url_text[2]) > 26) {
                $new_text = substr($url_text[2],0,26) . '...';
                // NOTE, this assumes there is no space between > and url_text[1]
                $reg[0] = str_replace(">".$url_text[2],">".$new_text,$reg[0]);
            }	

            if(stristr($fulltext,"<img ")) {
                // this is a linked images tag, ignore
                $reg[0] = '';
            }

            if ($reg[0] != '') {
                $fulltext = str_replace($orig,'',$fulltext);
            }

            if ($check != $reg[0]) {
                // Only write if we are dealing with something other than an image 
                if(!(stristr($reg[0],"<img "))) { 
                    $related .= "<li>" . stripslashes($reg[0]);
                }
            }
        }

        $author = DB_getItem($_TABLES['users'],'username',"uid = $uid");
        $topic = DB_getItem($_TABLES['topics'],'topic',"tid = '$tid'");

        if ($_CONF["contributedbyline"] == 1) {
            $related .= "<li><a href={$_CONF['site_url']}/search.php?mode=search&type=stories&author=$uid>{$LANG24[37]} $author</a>\n";
        }

        $related .= "<li><a href={$_CONF['site_url']}/search.php?mode=search&type=stories&topic=$tid>{$LANG24[38]} $topic</a>\n";
        $related = addslashes(COM_checkHTML(COM_checkWords($related)));

        // Clean up the text
        if ($postmode == "html") {
            $introtext = addslashes(COM_checkHTML(COM_checkWords($introtext)));
            $bodytext = addslashes(COM_checkHTML(COM_checkWords($bodytext)));
        } else {
            $introtext = addslashes(htmlspecialchars(COM_checkWords($introtext)));
            $bodytext = addslashes(htmlspecialchars(COM_checkWords($bodytext)));
        }
        $title = addslashes(htmlspecialchars(strip_tags(COM_checkWords($title))));
        $comments = DB_count($_TABLES['comments'],'sid',$sid);

        // If this is done as part of moderation stuff then delete the submission
        if ($type = 'submission') {
            DB_delete($_TABLES['storysubmission'],'sid',$sid);
        }
        DB_save($_TABLES['stories'],'sid,uid,tid,title,introtext,bodytext,hits,date,comments,related,featured,commentcode,statuscode,postmode,frontpage,draft_flag,numemails,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',"$sid,$uid,'$tid','$title','$introtext','$bodytext',$hits,'$date','$comments','$related',$featured,'$commentcode','$statuscode','$postmode','$frontpage',$draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon", '/admin/story.php?msg=9');

    } else {
        $display .= site_header("menu");
        $display .= COM_errorLog($LANG24[31],2);
        $display .= storyeditor($sid);
        $display .= site_footer();
        echo $display;
        exit;
    }
}

// MAIN

$display = '';

switch ($mode) {
case 'delete':
    if ($type == 'submission') {
        DB_delete($_TABLES['storysubmission'],'sid',$sid,"/admin/moderation.php");
    } else {
        DB_delete($_TABLES['stories'],'sid',$sid,"/admin/story.php?msg=10");
    }
    break;
case 'preview':
    $display .= site_header('menu');
    $display .= storyeditor($sid,$mode);
    $display .= site_footer();
    echo $display;
    break;
case 'edit':
    $display .= site_header("menu");
    $display .= storyeditor($sid,$mode);
    $display .= site_footer();
    echo $display;
    break;
case 'editsubmission':
    $display .= site_header("menu");
    $display .= storyeditor($id,$mode);
    $display .= site_footer();
    echo $display;
    break;
case 'save':
    submitstory($type,$sid,$uid,$tid,$title,$introtext,$bodytext,$hits,$unixdate,$comments,$featured,$commentcode,$statuscode,$postmode,$frontpage, $draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
    break;
case 'cancel':
default:
    $display .= site_header("menu");
    $display .= COM_showMessage($msg);
    $display .= liststories($page);
    $display .= site_footer();
    echo $display;
	break;
}

?>
