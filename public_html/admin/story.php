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
// $Id: story.php,v 1.22 2001/12/17 16:30:14 tony_bibbs Exp $

include('../lib-common.php');
include('auth.inc.php');

// Set this to true if you want to have this code output debug messages to 
// the error log
$_STORY_VERBOSE = false;

$display = '';

if (!SEC_hasRights('story.edit')) {
    $display .= COM_siteHeader('menu');
    $display .= COM_startBlock($MESSAGE[30]); 
    $display .= $MESSAGE[31];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    COM_errorLog("User {$_USER['username']} tried to illegally access the story administration screen",1);
    echo $display;
    exit;
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);

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
        // Convert array values to numeric permission values
        list($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) = SEC_getPermissionValues($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);

        if ($A["postmode"] == "html") {
            $A["introtext"] = COM_checkHTML(COM_checkWords($A["introtext"]));
            $A["bodytext"] = COM_checkHTML(COM_checkWords($A["bodytext"]));
        } else {
            $A["introtext"] = htmlspecialchars(COM_checkWords($A["introtext"]));
            $A["bodytext"] = htmlspecialchars(COM_checkWords($A["bodytext"]));
        }
        $A['title'] = strip_tags($A['title']);
    }

    // Load HTML templates
    $story_templates = new Template($_CONF['path_layout'] . 'admin/story');
    $story_templates->set_file(array('editor'=>'storyeditor.thtml'));
    $story_templates->set_var('site_url', $_CONF['site_url']);
    if (!empty($A['title'])) {
        $display .= COM_startBlock($LANG24[26]);
        $display .= COM_article($A,"n");
        $display .= COM_endBlock();
    }

    $display .= COM_startBlock($LANG24[5]);

    if ($access == 3) {
        $story_templates->set_var('delete_option', '<input type="submit" value="delete" name="mode">');
    }
    if ($A['type'] == 'editsubmission' || $mode == 'editsubmission') {
        $story_templates->set_var('submission_option', '<input type="hidden" name="type" value="submission">');
    }
    $story_templates->set_var('lang_author', $LANG24[7]);
    $story_templates->set_var('story_author', DB_getItem($_TABLES['users'],'username',"uid = {$A['uid']}"));
    $story_templates->set_var('story_uid', $A['uid']);

    // user access info
    $story_templates->set_var('lang_accessrights', $LANG_ACCESS[accessrights]);
    $story_templates->set_var('lang_owner', $LANG_ACCESS[owner]);
    $story_templates->set_var('owner_id', $A['owner_id']);
    $story_templates->set_var('lang_group', $LANG_ACCESS[group]);

    $usergroups = SEC_getUserGroups();
    if ($access == 3) {
        $groupdd .= '<SELECT name="group_id">';
        for ($i = 0; $i < count($usergroups); $i++) {
            $groupdd .= '<option value="' . $usergroups[key($usergroups)] . '"';
            if ($A['group_id'] == $usergroups[key($usergroups)]) {
                $groupdd .= ' SELECTED';
            }
            $groupdd .= '>' . key($usergroups) . '</option>';
            next($usergroups);
        }
        $groupdd .= '</SELECT>';
    } else {
        // they can't set the group then
        $groupdd .= DB_getItem($_TABLES['groups'],'grp_name',"grp_id = {$A['group_id']}");
        $groupdd .= '<input type="hidden" name="group_id" value="' . $A['group_id'] . '">';
    }
    $story_templates->set_var('group_dropdown', $groupdd);
    $story_templates->set_var('lang_permissions', $LANG_ACCESS[permissions]);
    $story_templates->set_var('lang_perm_key', $LANG_ACCESS[permissionskey]);
    $story_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $story_templates->set_var('permissions_msg', $LANG_ACCESS[permmsg]);
    $curtime = COM_getUserDateTimeFormat($A['unixdate']);
    $story_templates->set_var('lang_date', $LANG24[15]);
    $story_templates->set_var('story_date', $curtime[0]);
    $story_templates->set_var('story_unixstamp', $A['unixdate']); 
    $story_templates->set_var('lang_title', $LANG24[13]);
    $story_templates->set_var('story_title', stripslashes($A['title']));
    $story_templates->set_var('lang_topic', $LANG24[14]);
    $story_templates->set_var('topic_options', COM_optionList($_TABLES['topics'],'tid,topic',$A["tid"]));
    $story_templates->set_var('lang_draft', $LANG24[34]);
    if ($A['draft_flag'] == 1) {
        $story_templates->set_var('is_checked', 'CHECKED');
    }
    $story_templates->set_var('lang_mode', $LANG24[3]);
    $story_templates->set_var('status_options', COM_optionList($_TABLES['statuscodes'],'code,name',$A['statuscode']));
    $story_templates->set_var('comment_options', COM_optionList($_TABLES['commentcodes'],'code,name',$A['commentcode']));
    $story_templates->set_var('featured_options', COM_optionList($_TABLES['featurecodes'],'code,name',$A['featured']));
    $story_templates->set_var('frontpage_options', COM_optionList($_TABLES['frontpagecodes'],'code,name',1));
    $story_templates->set_var('lang_introtext', $LANG24[16]);
    $story_templates->set_var('story_introtext', stripslashes($A['introtext']));
    $story_templates->set_var('lang_bodytext', $LANG24[17]);
    $story_templates->set_var('story_bodytext', stripslashes($A['bodytext']));
    $story_templates->set_var('lang_postmode', $LANG24[4]);
    $story_templates->set_var('post_options', COM_optionList($_TABLES['postmodes'],'code,name',$A['postmode']));
    $story_templates->set_var('lang_allowed_html', COM_allowedHTML());
    $story_templates->set_var('lang_hits', $LANG24[18]);
    $story_templates->set_var('story_hits', $A['hits']);
    $story_templates->set_var('lang_comments', $LANG24[19]);
    $story_templates->set_var('story_comments', $A['comments']);
    $story_templates->set_var('lang_emails', $LANG24[39]); 
    $story_templates->set_var('story_emails', $A['numemails']);
    $story_templates->set_var('story_id', $A['sid']);
    $story_templates->parse('output','editor');
    $display .= $story_templates->finish($story_templates->get_var('output'));
    $display .= COM_endBlock();

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
    $story_templates = new Template($_CONF['path_layout'] . 'admin/story');
    $story_templates->set_file(array('list'=>'liststories.thtml','row'=>'listitem.thtml'));

    $story_templates->set_var('layout_url', $_CONF['layout_url']);
    $story_templates->set_var('site_url', $_CONF['site_url']);
    $story_templates->set_var('lang_newstory', $LANG24[43]);
    $story_templates->set_var('lang_adminhome', $LANG24[44]);
    $story_templates->set_var('lang_instructions', $LANG24[23]);
    $story_templates->set_var('lang_title', $LANG24[13]);
    $story_templates->set_var('lang_access', $LANG_ACCESS[access]);
    $story_templates->set_var('lang_draft', $LANG24[34]);
    $story_templates->set_var('lang_author', $LANG24[7]);
    $story_templates->set_var('lang_date', $LANG24[15]);
    $story_templates->set_var('lang_topic', $LANG24[14]);
    $story_templates->set_var('lang_featured', $LANG24[32]); 

    if (empty($page)) {
        $page = 1;
    }

    $limit = (50 * $page) - 50;
    $result = DB_query("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['stories']} ORDER BY date DESC LIMIT $limit,50");
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
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
            $story_templates->set_var('story_id', $A['sid']);
            $story_templates->set_var('row_num', $scount);
            $story_templates->set_var('story_title', $A['title']);
            $story_templates->set_var('story_access', $access);
            if ($A['draft_flag'] == 1) {
                $story_templates->set_var('story_draft', $LANG24[35]);
            } else {
                $story_templates->set_var('story_draft', $LANG24[36]);
            }
            $story_templates->set_var('story_author', DB_getItem($_TABLES['users'],'username',"uid = {$A['uid']}"));
            $story_templates->set_var('story_date', $curtime[0]);
            $story_templates->set_var('story_topic', $A['tid']);
            if ($A['featured'] == 1) {
                $story_templates->set_var('story_feature', $LANG24[35]);
            } else {
                $story_templates->set_var('story_feature', $LANG24[36]);
            }
            $story_templates->parse('storylist_item','row',true);
        }

        // Print prev/next page links if needed

        if (DB_count($_TABLES['stories']) > 50) {
            $prevpage = $page - 1;
            $nextpage = $page + 1;
            if ($pagestart >= 50) {
                $story_templates->set_var('previouspage_link', '<a href="' . $_CONF['site_url'] . '/admin/story.php?mode=list&page='
                    . $prevpage . '">' . $LANG24[1] . '</a> ');
            } else {
	        $story_templates->set_var('previouspage_link','');
            }
            if ($pagestart <= (DB_count($_TABLES['stories']) - 50)) {
                $story_templates->set_var('nextpage_link', '<a href="' . $_CONF['site_url'] . '/admin/story.php?mode=list&page='
                    . $nextpage . '">' . $LANG24[2] . '</a> ');
            } else {
	        $story_templates->set_var('nextpage_link','');
            }
        } else {
	    $story_templates->set_var('previouspage_link','');
	    $story_templates->set_var('nextpage_link','');
        }
           

    } else {
        // There are no news items
        $story_templates->set_var('storylist_item','<tr><td colspan="7">There are no stories in the system</td></tr>');
	$story_templates->set_var('previouspage_link','');
	$story_templates->set_var('nextpage_link','');
	
    }
    $display .= $story_templates->parse('output','list');
    $display .= COM_endBlock();

    return $display;
}

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

        // Get draft flag value
        if ($draft_flag == "on") {
            $draft_flag = 1;
        } else {
            $draft_flag = 0;

            // OK, if this story was already in the database and the user changed this from a draft
            // to an actual story then update the date to be now
            if (DB_count($_TABLES['stories'],'sid',$sid) == 1) {
                if (DB_getItem($_TABLES['stories'],'draft_flag',"sid = '$sid'") == 1) {
                    $unixdate = time();
                }
            }
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
        DB_save($_TABLES['stories'],'sid,uid,tid,title,introtext,bodytext,hits,date,comments,related,featured,commentcode,statuscode,postmode,frontpage,draft_flag,numemails,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon',"$sid,$uid,'$tid','$title','$introtext','$bodytext',$hits,'$date','$comments','$related',$featured,'$commentcode','$statuscode','$postmode','$frontpage',$draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon", 'admin/story.php?msg=9');

    } else {
        $display .= COM_siteHeader('menu');
        $display .= COM_errorLog($LANG24[31],2);
        $display .= storyeditor($sid);
        $display .= COM_siteFooter();
        echo $display;
        exit;
    }
}

// MAIN

$display = '';

switch ($mode) {
case 'delete':
    if ($type == 'submission') {
        DB_delete($_TABLES['storysubmission'],'sid',$sid,"admin/moderation.php");
    } else {
        DB_delete($_TABLES['stories'],'sid',$sid,"admin/story.php?msg=10");
    }
    break;
case 'preview':
    $display .= COM_siteHeader('menu');
    $display .= storyeditor($sid,$mode);
    $display .= COM_siteFooter();
    echo $display;
    break;
case 'edit':
    $display .= COM_siteHeader('menu');
    $display .= storyeditor($sid,$mode);
    $display .= COM_siteFooter();
    echo $display;
    break;
case 'editsubmission':
    $display .= COM_siteHeader('menu');
    $display .= storyeditor($id,$mode);
    $display .= COM_siteFooter();
    echo $display;
    break;
case 'save':
    submitstory($type,$sid,$uid,$tid,$title,$introtext,$bodytext,$hits,$unixdate,$comments,$featured,$commentcode,$statuscode,$postmode,$frontpage, $draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon);
    break;
case 'cancel':
default:
    $display .= COM_siteHeader('menu');
    $display .= COM_showMessage($msg);
    $display .= liststories($page);
    $display .= COM_siteFooter();
    echo $display;
	break;
}

?>
