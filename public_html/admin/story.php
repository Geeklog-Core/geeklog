<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | story.php                                                                 |
// |                                                                           |
// | Geeklog story administration page.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2003 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony@tonybibbs.com                           |
// |          Mark Limburg      - mlimburg@users.sourceforge.net               |
// |          Jason Whittenburg - jwhitten@securitygeeks.com                   |
// |          Dirk Haun         - dirk@haun-online.de                          |
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
// $Id: story.php,v 1.99 2003/07/25 10:08:55 dhaun Exp $

/**
* This is the Geeklog story administration page.
*
* @author   Jason Whittenburg
* @author   Tony Bibbs <tony@tonybibbs.com>
*
*/

/**
* Geeklog commong function library
*/
require_once('../lib-common.php');
/**
* Security check to ensure user even belongs on this page
*/
require_once('auth.inc.php');

// Set this to true if you want to have this code output debug messages to 
// the error log
$_STORY_VERBOSE = false;

$display = '';

if (!SEC_hasRights('story.edit')) {
    $display .= COM_siteHeader ('menu');
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header')); 
    $display .= $MESSAGE[31];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
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
* @param    string      $sid    ID of story to edit
* @param    string      $mode   ??
* @return   string      HTML for story editor
*
*/
function storyeditor($sid = '', $mode = '') 
{
    global $_TABLES, $HTTP_POST_VARS, $_USER, $_CONF, $LANG24, $LANG_ACCESS;

    $display = '';

    if (!empty($sid) && $mode == 'edit') {
        $result = DB_query("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['stories']} WHERE sid = '$sid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        $access = min ($access, SEC_hasTopicAccess ($A['tid']));
        if ($access == 2) {
            $display .= COM_startBlock($LANG24[40], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
            $display .= $LANG24[41];
            $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            $display .= COM_article($A,n);
            return $display;
        } else if ($access == 0) {
            $display .= COM_startBlock($LANG24[40], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
            $display .= $LANG24[42];
            $display .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
            return $display;
        }
    } elseif (!empty($sid) && $mode == "editsubmission") {
        $result = DB_query("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['storysubmission']} WHERE sid = '$sid'");
        if (DB_numRows ($result) > 0) {
            $A = DB_fetchArray($result);
            $A['show_topic_icon'] = 1;
            $A['commentcode'] = $_CONF['comment_code'];
            $A['featured'] = 0;
            $A['statuscode'] = 0;
            $A['owner_id'] = $A['uid'];
            $result = DB_query ("SELECT group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['topics']} WHERE tid = '{$A['tid']}'");
            $T = DB_fetchArray ($result);
            $A['group_id'] = $T['group_id'];
            $A['perm_owner'] = $T['perm_owner'];
            $A['perm_group'] = $T['perm_group'];
            $A['perm_members'] = $T['perm_members'];
            $A['perm_anon'] = $T['perm_anon'];
            $access = 3;
            $A['title'] = htmlspecialchars ($A['title']);
        } else {
            // that submission doesn't seem to be there any more (may have been
            // handled by another Admin) - take us back to the moderation page
            return COM_refresh ($_CONF['site_admin_url'] . '/moderation.php');
        }
    } elseif ($mode == "edit") {
        $A['sid'] = COM_makesid();
        $A['show_topic_icon'] = 1;
        $A['uid'] = $_USER['uid'];
        $A['unixdate'] = time();
        $A['commentcode'] = $_CONF['comment_code'];
        $A['postmode'] = $_CONF['postmode'];
        $A['statuscode'] = 0;
        $A['featured'] = 0;
        $A['owner_id'] = $_USER['uid'];
        $A['group_id'] = DB_getItem ($_TABLES['groups'], 'grp_id',
                                     "grp_name = 'Story Admin'");
        $A['perm_owner'] = 3;
        $A['perm_group'] = 2;
        $A['perm_members'] = 2;
        $A['perm_anon'] = 2;
        $access = 3;
    } else {
        $A = $HTTP_POST_VARS;
        if (empty ($A['ampm'])) {
            $A['ampm'] = $A['publish_ampm'];
        }
        if ($A['draft_flag'] == 'on') {
            $A['draft_flag'] = 1;
        } else {
            $A['draft_flag'] = 0;
        }
        if ($A['show_topic_icon'] == 'on') {
            $A['show_topic_icon'] = 1;
        } else {
            $A['show_topic_icon'] = 0;
        }
        
        // Convert array values to numeric permission values
        list($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) = SEC_getPermissionValues($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($A["postmode"] == "html") {
            $A["introtext"] = COM_checkHTML(COM_checkWords($A["introtext"]));
            $A["bodytext"] = COM_checkHTML(COM_checkWords($A["bodytext"]));
            $A["title"] = COM_checkHTML(htmlspecialchars(COM_checkWords($A["title"])));
        } else {
            $A["introtext"] = htmlspecialchars(COM_checkWords($A["introtext"]));
            $A["bodytext"] = htmlspecialchars(COM_checkWords($A["bodytext"]));
            $A["title"] = htmlspecialchars(COM_checkWords($A["title"]));
        }
        $A['title'] = strip_tags($A['title']);
    }

    // Load HTML templates
    $story_templates = new Template($_CONF['path_layout'] . 'admin/story');
    if (($_CONF['advanced_editor'] == 1) && file_exists ($_CONF['path_layout'] . 'admin/story/storyeditor_advanced.thtml')) {
        $story_templates->set_file(array('editor'=>'storyeditor_advanced.thtml'));
    } else {
        $story_templates->set_file(array('editor'=>'storyeditor.thtml'));
    }
    $story_templates->set_var('site_url', $_CONF['site_url']);
    $story_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $story_templates->set_var('layout_url', $_CONF['layout_url']);

    if (empty($A['unixdate'])) {
        $publish_hour = $A['publish_hour'];
        if ($publish_hour == 12) {
            if ($A['ampm'] == 'am') {
                $publish_hour = 0;
            }
        } else if ($A['ampm'] == 'pm') {
            $publish_hour += 12;
        }
        $A['unixdate'] = strtotime($A['publish_year'] . '-' . $A['publish_month'] . '-' . $A['publish_day']
            . ' ' . $publish_hour . ':' . $A['publish_minute'] . ':00');
    }

    if (!empty($A['title'])) {
        $display .= COM_startBlock ($LANG24[26], '',
                            COM_getBlockTemplate ('_admin_block', 'header'));
        $A['day'] = $A['unixdate'];
        if (empty ($A['hits'])) {
            $A['hits'] = 0;
        }
        $display .= COM_article($A,"n");
        $display .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
    }

    $display .= COM_startBlock ($LANG24[5], '',
                        COM_getBlockTemplate ('_admin_block', 'header'));

    if ($access == 3) {
        $story_templates->set_var ('delete_option',
            '<input type="submit" value="' . $LANG24[11] . '" name="mode">');
    }
    if ($A['type'] == 'editsubmission' || $mode == 'editsubmission') {
        $story_templates->set_var ('submission_option',
                '<input type="hidden" name="type" value="submission">');
    }
    $story_templates->set_var('lang_author', $LANG24[7]);
    $story_templates->set_var ('story_author', DB_getItem ($_TABLES['users'],
                               'username', "uid = {$A['uid']}"));
    $story_templates->set_var('story_uid', $A['uid']);

    // user access info
    $story_templates->set_var('lang_accessrights',$LANG_ACCESS['accessrights']);
    $story_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $story_templates->set_var ('owner_username', DB_getItem ($_TABLES['users'],
                               'username', "uid = {$A['owner_id']}"));
    $story_templates->set_var('owner_id', $A['owner_id']);
    $story_templates->set_var('lang_group', $LANG_ACCESS['group']);

    $usergroups = SEC_getUserGroups();
    if ($access == 3) {
        $groupdd .= '<select name="group_id">';
        for ($i = 0; $i < count($usergroups); $i++) {
            $groupdd .= '<option value="' . $usergroups[key($usergroups)] . '"';
            if ($A['group_id'] == $usergroups[key($usergroups)]) {
                $groupdd .= ' selected="selected"';
            }
            $groupdd .= '>' . key($usergroups) . '</option>';
            next($usergroups);
        }
        $groupdd .= '</select>';
    } else {
        // they can't set the group then
        $groupdd .= DB_getItem ($_TABLES['groups'], 'grp_name',
                                "grp_id = {$A['group_id']}");
        $groupdd .= '<input type="hidden" name="group_id" value="'
                 . $A['group_id'] . '">';
    }
    $story_templates->set_var('group_dropdown', $groupdd);
    $story_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $story_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $story_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));
    $story_templates->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
    $curtime = COM_getUserDateTimeFormat($A['unixdate']);
    $story_templates->set_var('lang_date', $LANG24[15]);
    $publish_month = date('m', $A['unixdate']);
    $publish_day = date('d', $A['unixdate']);
    $publish_year = date('Y', $A['unixdate']);
    $publish_hour = date('H', $A['unixdate']);
    $publish_minute = date('i', $A['unixdate']);
    $publish_second = date('s', $A['unixdate']);
    $story_templates->set_var('publish_second', $publish_second);
    $publish_ampm = '';
    if ($publish_hour >= 12) {
        if ($publish_hour > 12) {
            $publish_hour = $publish_hour - 12;
        }
        $ampm = 'pm';
    } else {
        $ampm = 'am';
    }
    if ($ampm == 'pm') {
        $story_templates->set_var ('publishpm_selected', 'selected="selected"');
    } else {
        $story_templates->set_var ('publisham_selected', 'selected="selected"');
    }
    $month_options = COM_getMonthFormOptions($publish_month);
    $story_templates->set_var('publish_month_options', $month_options);
    
    $day_options = COM_getDayFormOptions($publish_day);
    $story_templates->set_var('publish_day_options', $day_options);

    $year_options = COM_getYearFormOptions($publish_year);
    $story_templates->set_var('publish_year_options', $year_options);

    $hour_options = COM_getHourFormOptions($publish_hour);
    $story_templates->set_var('publish_hour_options', $hour_options);   

    $minute_options = COM_getMinuteOptions($publish_minute);
    $story_templates->set_var('publish_minute_options', $minute_options);

    $story_templates->set_var('publish_date_explanation', $LANG24[46]);

    $story_templates->set_var('story_unixstamp', $A['unixdate']); 
    $story_templates->set_var('lang_title', $LANG24[13]);
    if ($A['postmode'] == 'plaintext') {
        $A['title'] = str_replace('$','&#36;',$A['title']);
    }
    
    $A['title'] = str_replace('{','&#123;',$A['title']);
    $A['title'] = str_replace('}','&#125;',$A['title']);
    $A['title'] = str_replace('"','&quot;',$A['title']);
    $story_templates->set_var('story_title', stripslashes ($A['title']));
    $story_templates->set_var('lang_topic', $LANG24[14]);
    if (empty ($A['tid'])) {
        $A['tid'] = DB_getItem ($_TABLES['topics'], 'tid', 'is_default = 1' . COM_getPermSQL ('AND'));
    }
    $story_templates->set_var ('topic_options', COM_topicList ('tid,topic', $A['tid']));
    $story_templates->set_var('lang_show_topic_icon', $LANG24[56]);
    if ($A['show_topic_icon'] == 1) {
        $story_templates->set_var('show_topic_icon_checked', 'checked="checked"');
    } else {
        $story_templates->set_var('show_topic_icon_checked', '');
    }
    $story_templates->set_var('lang_draft', $LANG24[34]);
    if ($A['draft_flag'] == 1) {
        $story_templates->set_var('is_checked', 'checked="checked"');
    }
    $story_templates->set_var('lang_mode', $LANG24[3]);
    $story_templates->set_var('status_options', COM_optionList($_TABLES['statuscodes'],'code,name',$A['statuscode']));
    $story_templates->set_var('comment_options', COM_optionList($_TABLES['commentcodes'],'code,name',$A['commentcode']));
    $story_templates->set_var('featured_options', COM_optionList($_TABLES['featurecodes'],'code,name',$A['featured']));
    $story_templates->set_var('frontpage_options', COM_optionList($_TABLES['frontpagecodes'],'code,name',$A['frontpage']));
    list($newintro, $newbody) = replace_images($A['sid'], stripslashes($A['introtext']), stripslashes($A['bodytext']));
    
    $story_templates->set_var('lang_introtext', $LANG24[16]);
    if ($A['postmode'] == 'plaintext') {
        $newintro = str_replace('$','&#36;',$newintro);
    } else {
        // Insert [code] and [/code] if needed
        $newintro = str_replace('<pre><code>','[code]',$newintro);
        $newbody = str_replace('<pre><code>','[code]',$newbody);
        $newintro = str_replace('</code></pre>','[/code]',$newintro);
        $newbody = str_replace('</code></pre>','[/code]',$newbody);
    }
    $newintro = str_replace('{','&#123;',$newintro);
    $newintro = str_replace('}','&#125;',$newintro);
    $story_templates->set_var('story_introtext', $newintro);
    $story_templates->set_var('lang_bodytext', $LANG24[17]);
    if ($A['postmode'] == 'plaintext') {
        $newbody = str_replace('$','&#36;',$newbody);
    }
    
    $newbody = str_replace('{','&#123;',$newbody);
    $newbody = str_replace('}','&#125;',$newbody);
    $story_templates->set_var('story_bodytext', $newbody);
    $story_templates->set_var('lang_postmode', $LANG24[4]);
    $story_templates->set_var('post_options', COM_optionList($_TABLES['postmodes'],'code,name',$A['postmode']));
    $story_templates->set_var('lang_allowed_html', COM_allowedHTML());
    $fileinputs = '';
    $saved_images = '';
    if ($_CONF['maximagesperarticle'] > 0) {
        $story_templates->set_var('lang_images', $LANG24[47]);
        $icount = DB_count($_TABLES['article_images'],'ai_sid', $A['sid']);
        if ($icount > 0) {
            $result_articles = DB_query("SELECT * FROM {$_TABLES['article_images']} WHERE ai_sid = '{$A['sid']}'");
            for ($z = 1; $z <= $icount; $z++) {
                $I = DB_fetchArray($result_articles);
                $saved_images .= $z . ') <a href="' . $_CONF['site_url'] . '/images/articles/' . $I['ai_filename'] . '" target="_blank">' . $I['ai_filename'] . '</a>';
                $saved_images .= '&nbsp;&nbsp;&nbsp;' . $LANG24[52] . ': <input type="checkbox" name="delete[' .$I['ai_img_num'] . ']"><br>';
            }
        }
        
        $newallowed = $_CONF['maximagesperarticle'] - $icount;
        for ($z = $icount + 1; $z <= $_CONF['maximagesperarticle']; $z++) {
            $fileinputs .= $z . ') <input type="file" name="file' . $z . '">';
            if ($z < $_CONF['maximagesperarticle']) {
                $fileinputs .= '<br>';
            }
        }
        $fileinputs .= '<br>' . $LANG24[51] . '<br>';
    }
    $story_templates->set_var('saved_images', $saved_images);
    $story_templates->set_var('image_form_elements', $fileinputs);
    $story_templates->set_var('lang_hits', $LANG24[18]);
    $story_templates->set_var('story_hits', $A['hits']);
    $story_templates->set_var('lang_comments', $LANG24[19]);
    $story_templates->set_var('story_comments', $A['comments']);
    $story_templates->set_var('lang_emails', $LANG24[39]); 
    $story_templates->set_var('story_emails', $A['numemails']);
    $story_templates->set_var('story_id', $A['sid']);
    $story_templates->set_var('lang_save', $LANG24[8]); 
    $story_templates->set_var('lang_preview', $LANG24[9]); 
    $story_templates->set_var('lang_cancel', $LANG24[10]); 
    $story_templates->set_var('lang_delete', $LANG24[11]); 
    $story_templates->parse('output','editor');
    $display .= $story_templates->finish($story_templates->get_var('output'));
    $display .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $display;
}

/**
* List all stories in the system
*
* This lists all the stories in the database
*
* @param    int     $page   Page to show user
* @return   string  HTML for story listing
*
*/
function liststories($page = 1) 
{
    global $_TABLES, $LANG24, $_CONF, $LANG_ACCESS, $_USER, $_GROUPS;

    $display = '';

    $display .= COM_startBlock ($LANG24[22], '',
                        COM_getBlockTemplate ('_admin_block', 'header'));
    $story_templates = new Template($_CONF['path_layout'] . 'admin/story');
    $story_templates->set_file (array ('list' => 'liststories.thtml',
                                       'row' => 'listitem.thtml'));

    $story_templates->set_var('layout_url', $_CONF['layout_url']);
    $story_templates->set_var('site_url', $_CONF['site_url']);
    $story_templates->set_var('site_admin_url', $_CONF['site_admin_url']);
    $story_templates->set_var('lang_newstory', $LANG24[43]);
    $story_templates->set_var('lang_adminhome', $LANG24[44]);
    $story_templates->set_var('lang_instructions', $LANG24[23]);
    $story_templates->set_var('lang_title', $LANG24[13]);
    $story_templates->set_var('lang_access', $LANG_ACCESS['access']);
    $story_templates->set_var('lang_draft', $LANG24[34]);
    $story_templates->set_var('lang_author', $LANG24[7]);
    $story_templates->set_var('lang_date', $LANG24[15]);
    $story_templates->set_var('lang_topic', $LANG24[14]);
    $story_templates->set_var('lang_featured', $LANG24[32]); 

    if (empty($page)) {
        $page = 1;
    }

    $excludetopics = '';
    $topicsql = "SELECT tid FROM {$_TABLES['topics']}" . COM_getPermSQL ();
    $tresult = DB_query ($topicsql);
    $trows = DB_numRows ($tresult);     
    if ($trows > 0) {
        $tids = array ();
        for ($i = 0; $i < $trows; $i++) {
            $T = DB_fetchArray ($tresult);
            $tids[] = $T['tid'];
        }
        if (sizeof ($tids) > 0) {
            $excludetopics = " WHERE (tid IN ('" . implode ("','", $tids) . "'))";
        }
    }

    $limit = (50 * $page) - 50;
    $result = DB_query("SELECT *,UNIX_TIMESTAMP(date) AS unixdate FROM {$_TABLES['stories']} " . $excludetopics . "ORDER BY date DESC LIMIT $limit,50");
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        for ($i = 1; $i <= $nrows; $i++) {
            $scount = (50 * $page) - 50 + $i;
            $A = DB_fetchArray($result);
            $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
            if ($access > 0) {
                if ($access == 3) {
                    $access = $LANG_ACCESS['edit'];
                } else {
                    $access = $LANG_ACCESS['readonly'];
                }
            } else {
                $access = $LANG_ACCESS['none'];
            }
            $curtime = COM_getUserDateTimeFormat($A['unixdate']);
            $story_templates->set_var('story_id', $A['sid']);
            $story_templates->set_var('row_num', $scount);
            $A['title'] = str_replace('$', '&#36;', $A['title']);
            $story_templates->set_var('story_title', stripslashes($A['title']));
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
        $nresult = DB_query ("SELECT COUNT(*) AS count FROM {$_TABLES['stories']}" . $excludetopics);
        $N = DB_fetchArray ($nresult);
        $numstories = $N['count'];
        if ($numstories > 50) {
            $prevpage = $page - 1;
            $nextpage = $page + 1;
            $pagestart = ($page - 1) * 50;
            if ($pagestart >= 50) {
                $story_templates->set_var ('previouspage_link', '<a href="'
                    . $_CONF['site_admin_url']
                    . '/story.php?mode=list&amp;page=' . $prevpage . '">'
                    . $LANG24[1] . '</a> ');
            } else {
                $story_templates->set_var('previouspage_link','');
            }
            if ($pagestart <= ($numstories - 50)) {
                $story_templates->set_var ('nextpage_link', '<a href="'
                    . $_CONF['site_admin_url']
                    . '/story.php?mode=list&amp;page=' . $nextpage . '">'
                    . $LANG24[2] . '</a> ');
            } else {
	        $story_templates->set_var('nextpage_link','');
            }
            $baseurl = $_CONF['site_admin_url'] . '/story.php?mode=list';
            $numpages = ceil ($numstories / 50);
            $story_templates->set_var ('google_paging',
                    COM_printPageNavigation ($baseurl, $page, $numpages));
        } else {
            $story_templates->set_var ('previouspage_link' ,'');
            $story_templates->set_var ('nextpage_link' ,'');
            $story_templates->set_var ('google_paging' ,'');
        }

    } else {
        // There are no news items
        $story_templates->set_var ('storylist_item', '<tr><td colspan="8">'
                . $LANG24[6] . '</td></tr>');
        $story_templates->set_var ('previouspage_link', '');
        $story_templates->set_var ('nextpage_link', '');
        $story_templates->set_var ('google_paging' ,'');
    }
    $display .= $story_templates->parse('output','list');
    $display .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $display;
}

/**
* This replaces all article image HTML in intro and body with
* GL special syntax
*
* @param    string      $sid    ID for story to parse
* @param    string      $intro  Intro text
* @param    string      $body   Body text
* @return   string      processed text
*
*/
function replace_images($sid, $intro, $body)
{
    global $_TABLES, $_CONF, $LANG24;
    
    $result = DB_query("SELECT * FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' ORDER BY ai_img_num");
    $nrows = DB_numRows($result);
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        $dimensions = GetImageSize($_CONF['path_html'] . 'images/articles/' . $A['ai_filename']);
        if (!empty($dimensions[0]) AND !empty($dimensions[1])) {
            $sizeattributes = 'width="' . $dimensions[0] . '" height="' . $dimensions[1] . '" ';
        } else {
            $sizeattributes = '';
        }

        $lLinkPrefix = '';      
        $lLinkSuffix = '';
        if ($_CONF['keep_unscaled_image'] == 1) {
            $lFilename_large = substr_replace ($A['ai_filename'], '_original.',
                    strrpos ($A['ai_filename'], '.'), 1);
            $lFilename_large_complete = $_CONF['path_html'] . 'images/articles/'
                                      . $lFilename_large;
            $lFilename_large_URL = $_CONF['site_url'] . '/images/articles/'
                                 . $lFilename_large;
            if (file_exists ($lFilename_large_complete)) {
                $lLinkPrefix = '<a href="' . $lFilename_large_URL
                             . '" title="' . $LANG24[57] . '">';
                $lLinkSuffix = '</a>';
            }
        }

        $norm = $lLinkPrefix . '<img ' . $sizeattributes . 'src="' . $_CONF['site_url'] . '/images/articles/' . $A['ai_filename'] . '" alt="">' . $lLinkSuffix;
        $left = $lLinkPrefix . '<img ' . $sizeattributes . 'align="left" src="' . $_CONF['site_url'] . '/images/articles/' . $A['ai_filename'] . '" alt="">' . $lLinkSuffix;
        $right = $lLinkPrefix . '<img ' . $sizeattributes . 'align="right" src="' . $_CONF['site_url'] . '/images/articles/' . $A['ai_filename'] . '" alt="">' . $lLinkSuffix;
        $fulltext = $intro . ' ' . $body;
        $count = substr_count($fulltext, $norm) + substr_count($fulltext, $left) + substr_count($fulltext, $right);
        $intro = str_replace($norm, '[' . $LANG24[48] . $i . ']', $intro);
        $body = str_replace($norm, '[' . $LANG24[48] . $i . ']', $body);
        $intro = str_replace($left, '[' . $LANG24[48] . $i . '_' . $LANG24[50] . ']', $intro);
        $body = str_replace($left, '[' . $LANG24[48] . $i . '_' . $LANG24[50] . ']', $body);
        $intro = str_replace($right, '[' . $LANG24[48] . $i . '_' . $LANG24[49] . ']', $intro);
        $body = str_replace($right, '[' . $LANG24[48] . $i . '_' . $LANG24[49] . ']', $body);
    }
    return array($intro, $body);
}
    
/**
* Replaces simple image syntax with actual HTML in the intro and body.  If errors occur
* it will return all errors in $error
*
* @param    string      $sid    ID for story to parse
* @param    string      $intro  Intro text
* @param    string      $body   Body text
* @return   string      Processed text
*
*/
function insert_images($sid, $intro, $body)
{
    global $_TABLES, $_CONF, $LANG24;
    
    $result = DB_query("SELECT * FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' ORDER BY ai_img_num");
    $nrows = DB_numRows($result);
    $errors = array();
    
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        $dimensions = GetImageSize($_CONF['path_html'] . 'images/articles/' . $A['ai_filename']);
        if (!empty($dimensions[0]) AND !empty($dimensions[1])) {
            $sizeattributes = 'width="' . $dimensions[0] . '" height="' . $dimensions[1] . '" ';
        } else {
            $sizeattributes = '';
        }

        $lLinkPrefix = '';
        $lLinkSuffix = '';
        if ($_CONF['keep_unscaled_image'] == 1) {
            $lFilename_large = substr_replace ($A['ai_filename'], '_original.',
                    strrpos ($A['ai_filename'], '.'), 1);
            $lFilename_large_complete = $_CONF['path_html'] . 'images/articles/'
                                      . $lFilename_large;
            $lFilename_large_URL = $_CONF['site_url'] . '/images/articles/'
                                 . $lFilename_large;
            if (file_exists ($lFilename_large_complete)) {
                $lLinkPrefix = '<a href="' . $lFilename_large_URL
                             . '" title="' . $LANG24[57] . '">';   
                $lLinkSuffix = '</a>';
            }
        }

        $norm = '[' . $LANG24[48] . $i . ']';
        $left = '[' . $LANG24[48] . $i . '_' . $LANG24[50] . ']';
        $right = '[' . $LANG24[48] . $i . '_' . $LANG24[49] . ']';
        $fulltext = $intro . ' ' . $body;
        $icount = substr_count($fulltext, $norm) + substr_count($fulltext, $left) + substr_count($fulltext, $right);
        if ($icount == 0) {
            // There is an image that wasn't used, create an error
            $errors[] = $LANG24[48] . " #$i, {$A['ai_filename']}, " . $LANG24[53];
        } else {
            // Only parse if we haven't encountered any error to this point
            if (count($errors) == 0) {
                $intro = str_replace($norm, $lLinkPrefix . '<img ' . $sizeattributes . 'src="' . $_CONF['site_url'] . '/images/articles/' . $A['ai_filename'] . '" alt="">' . $lLinkSuffix, $intro);
                $body = str_replace($norm, $lLinkPrefix . '<img ' . $sizeattributes . 'src="' . $_CONF['site_url'] . '/images/articles/' . $A['ai_filename'] . '" alt="">' . $lLinkSuffix, $body);
                $intro = str_replace($left, $lLinkPrefix . '<img ' . $sizeattributes . 'align="left" src="' . $_CONF['site_url'] . '/images/articles/' . $A['ai_filename'] . '" alt="">' . $lLinkSuffix, $intro);
                $body = str_replace($left, $lLinkPrefix . '<img ' . $sizeattributes . 'align="left" src="' . $_CONF['site_url'] . '/images/articles/' . $A['ai_filename'] . '" alt="">' . $lLinkSuffix, $body);
                $intro = str_replace($right, $lLinkPrefix . '<img ' . $sizeattributes . 'align="right" src="' . $_CONF['site_url'] . '/images/articles/' . $A['ai_filename'] . '" alt="">' . $lLinkSuffix, $intro);
                $body = str_replace($right, $lLinkPrefix . '<img ' . $sizeattributes . 'align="right" src="' . $_CONF['site_url'] . '/images/articles/' . $A['ai_filename'] . '" alt="">' . $lLinkSuffix, $body);
            }
        }
    }

    return array($errors, $intro, $body);
}

/** 
* Saves story to database
*
* @param    string      $type           story submission or (new) story
* @param    string      $sid            ID of story to save
* @param    int         $uid            ID of user that wrote the story
* @param    string      $tid            Topic ID story belongs to
* @param    string      $title          Title of story
* @param    string      $introtext      Introduction text
* @param    string      $bodytext       Text of body
* @param    int         $hits           Number of times story has been viewed
* @param    string      $unixdate       Date story was originally saved
* @param    int         $comments       Number of user comments made to this story
* @param    int         $featured       Flag on whether or not this is a featured article
* @param    string      $commentcode    Indicates if comments are allowed to be made to article
* @param    string      $statuscode     Status of the story
* @param    string      $postmode       Is this HTML or plain text?
* @param    string      $frontpage      Flag indicates if story will appear on front page and topic or just topic
* @param    int         $draft_flag     Flag indicates if story is a draft or not
* @param    int         $numemails      Number of times this story has been emailed to someone
* @param    int         $owner_id       ID of owner (not necessarily the author)
* @param    int         $group_id       ID of group story belongs to
* @param    int         $perm_owner     Permissions the owner has on story
* @param    int         $perm_group     Permissions the group has on story
* @param    int         $perm_member    Permissions members have on story
* @param    int         $perm_anon      Permissions anonymous users have on story
* @param    int         $delete         String array of attached images to delete from article
*
*/
function submitstory($type='',$sid,$uid,$tid,$title,$introtext,$bodytext,$hits,$unixdate,$comments,$featured,$commentcode,$statuscode,$postmode,$frontpage,$draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$delete,$show_topic_icon) 
{
    global $_TABLES, $_CONF, $_USER, $LANG24, $MESSAGE, $HTTP_POST_FILES;

    // Convert array values to numeric permission values
    list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);

    $access = 0;
    if (DB_count ($_TABLES['stories'], 'sid', $sid) > 0) {
        $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '{$sid}'");
        $A = DB_fetchArray ($result);
        $access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
                $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                $A['perm_anon']);
    } else {
        $access = SEC_hasAccess ($owner_id, $group_id, $perm_owner, $perm_group,
                $perm_members, $perm_anon);
    }
    if (($access < 3) || (SEC_hasTopicAccess ($tid) < 2) || !SEC_inGroup ($group_id)) {
        $display .= COM_siteHeader ('menu');
        $display .= COM_startBlock ($MESSAGE[30], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $display .= $MESSAGE[31];
        $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $display .= COM_siteFooter ();
        COM_errorLog("User {$_USER['username']} tried to illegally submit or edit story $sid",1);
        echo $display;
        exit;
    } elseif (!empty($title) && !empty($introtext)) {
        $date = date("Y-m-d H:i:s",$unixdate);

        if (empty($hits)) {
            $hits = 0;
        }

        // Get draft flag value
        if ($draft_flag == 'on') {
            $draft_flag = 1;
        } else {
            $draft_flag = 0;

            // OK, if this story was already in the database and the user
            // changed this from a draft to an actual story then update the
            // date to be now
            if (DB_count($_TABLES['stories'],'sid',$sid) == 1) {
                if (DB_getItem($_TABLES['stories'],'draft_flag',"sid = '$sid'") == 1) {
                    $unixdate = time();
                }
            }
        }

        if ($featured == '1') {
            // there can only be one non-draft featured story
            if ($draft_flag == 0 AND $unixdate <= time()) {
                $id[1] = 'featured';
                $values[1] = 1;
                $id[2] = 'draft_flag';
                $values[2] = 0;
                DB_change($_TABLES['stories'],'featured','0',$id,$values);
            }

            // if set to featured force to show on front page
            $frontpage = 1;
        }

        if (empty($numemails)) {
            $numemails = 0;
        }
        
        if ($show_topic_icon == 'on') {
            $show_topic_icon = 1;
        } else {
            $show_topic_icon = 0;
        }
        
        // Get the related URLs
        $related = addslashes (COM_whatsRelated ("$introtext $bodytext", $uid, $tid));

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

        // Delete any images if needed
        for ($i = 1; $i <= count($delete); $i++) {
            $ai_filename = DB_getItem ($_TABLES['article_images'],'ai_filename',                    "ai_sid = '$sid' AND ai_img_num = " . key ($delete));
            $curfile = $_CONF['path_html'] . 'images/articles/' . $ai_filename;
            if (!@unlink($curfile)) {
                echo COM_errorLog("Unable to delete image $curfile. Please check file permissions");
            }

            // remove unscaled image, if it exists
            $lFilename_large = substr_replace ($ai_filename, '_original.',
                    strrpos ($ai_filename, '.'), 1);
            $lFilename_large_complete = $_CONF['path_html'] . 'images/articles/'
                                      . $lFilename_large;
            if (file_exists ($lFilename_large_complete)) {
                if (!@unlink ($lFilename_large_complete)) {
                    echo COM_errorLog ('Unable to remove the following image from the article: ' . $lFilename_large_complete);
                }
            }

            DB_query("DELETE FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' AND ai_img_num = " . key($delete));
            next($delete);
        }

        // OK, let's upload any pictures with the article
        if (DB_count($_TABLES['article_images'], 'ai_sid', $sid) > 0) {
            $index_start = DB_getItem($_TABLES['article_images'],'max(ai_img_num)',"ai_sid = '$sid'") + 1;
        } else {
            $index_start = 1;
        }

        if (count($HTTP_POST_FILES) > 0 AND $_CONF['maximagesperarticle'] > 0) {
            require_once($_CONF['path_system'] . 'classes/upload.class.php');
            $upload = new upload();

            $upload->setDebug(true);
            $upload->setMaxFileUploads ($_CONF['maximagesperarticle']);
            if (!empty($_CONF['image_lib'])) {
                if ($_CONF['image_lib'] == 'imagemagick') {
                    // Using imagemagick
                    $upload->setMogrifyPath ($_CONF['path_to_mogrify']);
                } else {
                    // must be using netPBM
                    $upload->_pathToNetPBM= $_CONF['path_to_netpbm'];
                }    
                $upload->setAutomaticResize(true);
                if ($_CONF['keep_unscaled_image'] == 1) {
                    $upload->keepOriginalImage (true);
                } else {
                    $upload->keepOriginalImage (false);
                }
            }
            $upload->setAllowedMimeTypes(array('image/gif'=>'.gif','image/jpeg'=>'.jpg,.jpeg','image/pjpeg'=>'.jpg,.jpeg','image/x-png'=>'.png','image/png'=>'.png'));
            if (!$upload->setPath($_CONF['path_html'] . 'images/articles')) {
                print 'File Upload Errors:<br>' . $upload->printErrors();
                exit;
            }

            // NOTE: if $_CONF['path_to_mogrify'] is set, the call below will
            // force any images bigger than the passed dimensions to be resized.
            // If mogrify is not set, any images larger than these dimensions
            // will get validation errors
            $upload->setMaxDimensions($_CONF['max_image_width'], $_CONF['max_image_height']);
            $upload->setMaxFileSize($_CONF['max_image_size']); // size in bytes, 1048576 = 1MB

            // Set file permissions on file after it gets uploaded (number is in octal)
            $upload->setPerms('0644');
            $filenames = array();
            $end_index = $index_start + $upload->numFiles() - 1;
            for ($z = $index_start; $z <= $end_index; $z++) {
                $curfile = current($HTTP_POST_FILES);
                if (!empty($curfile['name'])) {
                    $pos = strrpos($curfile['name'],'.') + 1;
                    $fextension = substr($curfile['name'], $pos);
                    $filenames[] = $sid . '_' . $z . '.' . $fextension;
                }
                next($HTTP_POST_FILES);
            }
            $upload->setFileNames($filenames);
            reset($HTTP_POST_FILES);
            $upload->setDebug(true);
            $upload->uploadFiles();

            if ($upload->areErrors()) {
                $retval = COM_siteHeader('menu');
                $retval .= COM_startBlock ($LANG24[30], '',
                               COM_getBlockTemplate ('_msg_block', 'header'));
                $retval .= $upload->printErrors(false);
                $retval .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
                $retval .= COM_siteFooter('true');
                echo $retval;
                exit; 
            }

            reset($filenames);
            for ($z = $index_start; $z <= $end_index; $z++) {
                DB_query("INSERT INTO {$_TABLES['article_images']} (ai_sid, ai_img_num, ai_filename) VALUES ('$sid', $z, '" . current($filenames) . "')");
                next($filenames);
            }
        }

        if ($_CONF['maximagesperarticle'] > 0) {
            list($errors, $introtext, $bodytext) = insert_images($sid, $introtext, $bodytext);
            if (count($errors) > 0) {
                $display = COM_siteHeader ('menu');
                $display .= COM_startBlock ($LANG24[54], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
                $display .= $LANG24[55] . '<p>';
                for ($i = 1; $i <= count($errors); $i++) {
                    $display .= current($errors) . '<br>';
                    next($errors);
                }
                $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
                $display .= storyeditor($sid);
                $display .= COM_siteFooter();
                echo $display;
                exit;
            }
        }

        if ($type == 'submission') {
            $return_to = $_CONF['site_admin_url'] . '/moderation.php?msg=9';
        } else {
            $return_to = $_CONF['site_admin_url'] . '/story.php?msg=9';
        }
        DB_save($_TABLES['stories'],'sid,uid,tid,title,introtext,bodytext,hits,date,comments,related,featured,commentcode,statuscode,postmode,frontpage,draft_flag,numemails,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,show_topic_icon',"$sid,$uid,'$tid','$title','$introtext','$bodytext',$hits,'$date','$comments','$related',$featured,'$commentcode','$statuscode','$postmode','$frontpage',$draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$show_topic_icon", $return_to);

        // If this is done as part of moderation stuff then delete the submission
        if ($type == 'submission') {
            DB_delete($_TABLES['storysubmission'],'sid',$sid);
        }
    } else {
        $display .= COM_siteHeader('menu');
        $display .= COM_errorLog($LANG24[31],2);
        $display .= storyeditor($sid);
        $display .= COM_siteFooter();
        echo $display;
        exit;
    }
}

/**
* Delete a story from the database.
*
* @param    string   $sid   id of story to delete
* @return   string          HTML for a redirect to admin/story.php
*
*/
function deletestory ($sid)
{
    global $_TABLES, $_CONF;

    $result = DB_query ("SELECT ai_filename FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid'");
    $nrows = DB_numRows ($result);
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray ($result);
        $filename = $_CONF['path_html'] . 'images/articles/' . $A['ai_filename'];
        if (!@unlink ($filename)) {
            // log the problem but don't abort the script
            echo COM_errorLog ('Unable to remove the following image from the article: ' . $filename);
        }

        // remove unscaled image, if it exists
        $lFilename_large = substr_replace ($A['ai_filename'], '_original.',
                                           strrpos ($A['ai_filename'], '.'), 1);
        $lFilename_large_complete = $_CONF['path_html'] . 'images/articles/'
                                  . $lFilename_large;
        if (file_exists ($lFilename_large_complete)) {
            if (!@unlink ($lFilename_large_complete)) {
                // again, log the problem but don't abort the script
                echo COM_errorLog ('Unable to remove the following image from the article: ' . $lFilename_large_complete);
            }
        }
    }
    DB_delete ($_TABLES['article_images'], 'ai_sid', $sid);
    DB_delete ($_TABLES['comments'], 'sid', $sid);
    DB_delete ($_TABLES['stories'], 'sid', $sid);

    // update RSS feed and Older Stories block
    COM_exportRDF ();
    COM_olderStuff ();

    return COM_refresh ($_CONF['site_admin_url'] . '/story.php?msg=10');
}

// MAIN

$display = '';
if (($mode == $LANG24[11]) && !empty ($LANG24[11])) { // delete
    if (!isset ($sid) || empty ($sid) || ($sid == 0)) {
        COM_errorLog ('Attempted to delete story sid=' . $sid);
        echo COM_refresh ($_CONF['site_admin_url'] . '/story.php');
    } else if ($type == 'submission') {
        DB_delete ($_TABLES['storysubmission'], 'sid', $sid,
                   $_CONF['site_admin_url'] . '/moderation.php');
    } else {
        echo deletestory ($sid);
    }
} else if (($mode == $LANG24[9]) && !empty ($LANG24[9])) { // preview
    $display .= COM_siteHeader('menu');
    $display .= storyeditor($sid,$mode);
    $display .= COM_siteFooter();
    echo $display;
} else if ($mode == 'edit') {
    $display .= COM_siteHeader('menu');
    $display .= storyeditor($sid,$mode);
    $display .= COM_siteFooter();
    echo $display;
} else if ($mode == 'editsubmission') {
    $display .= COM_siteHeader('menu');
    $display .= storyeditor($id,$mode);
    $display .= COM_siteFooter();
    echo $display;
} else if (($mode == $LANG24[8]) && !empty ($LANG24[8])) { // save
    if ($publish_ampm == 'pm') {
        if ($publish_hour < 12) {
            $publish_hour = $publish_hour + 12;
        }
    }
    if ($publish_ampm == 'am' AND $publish_hour == 12) {
        $publish_hour = '00';
    }
    $unixdate = strtotime("$publish_month/$publish_day/$publish_year $publish_hour:$publish_minute:$publish_second");
    submitstory($type,$sid,$uid,$tid,$title,$introtext,$bodytext,$hits,$unixdate,$comments,$featured,$commentcode,$statuscode,$postmode,$frontpage, $draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$delete,$show_topic_icon);
} else { // 'cancel' or no mode at all
    if (($mode == $LANG24[10]) && !empty ($LANG24[10]) &&
            ($type == 'submission')) {
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/moderation.php');
    } else {
        $display .= COM_siteHeader('menu');
        $display .= COM_showMessage($msg);
        $display .= liststories($page);
        $display .= COM_siteFooter();
    }
    echo $display;
}

?>
