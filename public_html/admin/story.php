<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | story.php                                                                 |
// |                                                                           |
// | Geeklog story administration page.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
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
// $Id: story.php,v 1.126 2004/08/16 10:44:45 dhaun Exp $

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
require_once ('../lib-common.php');
require_once ($_CONF['path_system'] . 'lib-story.php');

/**
* Security check to ensure user even belongs on this page
*/
require_once ('auth.inc.php');

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
    COM_accessLog("User {$_USER['username']} tried to illegally access the story administration screen.");
    echo $display;
    exit;
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($HTTP_POST_VARS);


/**
* Returns a list of all users and their user ids, wrapped in <option> tags.
*
* @param    int     uid     current user (to be displayed as selected)
* @return   string          string with <option> tags, to be wrapped in <select>
*
*/
function userlist ($uid = 0)
{
    global $_TABLES;

    $retval = '';

    $result = DB_query ("SELECT uid,username FROM {$_TABLES['users']} WHERE uid > 1 ORDER BY username");

    while ($A = DB_fetchArray ($result)) {
        $retval .= '<option value="' . $A['uid'] . '"';
        if ($uid == $A['uid']) {
            $retval .= ' selected="selected"';
        }
        $retval .= '>' . $A['username'] . '</option>' . LB;
    }

    return $retval;
}

/**
* Shows story editor
*
* Displays the story entry form
*
* @param    string      $sid    ID of story to edit
* @param    string      $mode   mode: preview, 'edit', 'editsubmission'
* @return   string      HTML for story editor
*
*/
function storyeditor($sid = '', $mode = '') 
{
    global $_TABLES, $HTTP_POST_VARS, $_USER, $_CONF, $LANG24, $LANG_ACCESS;

    $display = '';

    if (!empty($sid) && $mode == 'edit') {
        $result = DB_query ("SELECT STRAIGHT_JOIN s.*, UNIX_TIMESTAMP(s.date) as unixdate, "
         . "u.username, u.fullname, u.photo, t.topic, t.imageurl, UNIX_TIMESTAMP(s.expire) AS expiredate "
         . "FROM {$_TABLES['stories']} as s, {$_TABLES['users']} as u, {$_TABLES['topics']} as t "
         . "WHERE (s.uid = u.uid) AND (s.tid = t.tid) AND (sid = '$sid')");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        $access = min ($access, SEC_hasTopicAccess ($A['tid']));
        if ($access == 2) {
            $display .= COM_startBlock($LANG24[40], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
            $display .= $LANG24[41];
            $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
            $display .= STORY_renderArticle ($A, 'n');
            COM_accessLog("User {$_USER['username']} tried to illegally edit story $sid.");
            return $display;
        } else if ($access == 0) {
            $display .= COM_startBlock($LANG24[40], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
            $display .= $LANG24[42];
            $display .= COM_endBlock(COM_getBlockTemplate ('_msg_block', 'footer'));
            COM_accessLog("User {$_USER['username']} tried to illegally access story $sid.");
            return $display;
        }
    } elseif (!empty($sid) && $mode == 'editsubmission') {
        $result = DB_query ("SELECT STRAIGHT_JOIN s.*, UNIX_TIMESTAMP(s.date) as unixdate, "
         . "u.username, u.fullname, u.photo, t.topic, t.imageurl, t.group_id, "
         . "t.perm_owner, t.perm_group, t.perm_members, t.perm_anon "
         . "FROM {$_TABLES['storysubmission']} as s, {$_TABLES['users']} as u, {$_TABLES['topics']} as t "
         . "WHERE (s.uid = u.uid) AND (s.tid = t.tid) AND (sid = '$sid')");
        if (DB_numRows ($result) > 0) {
            $A = DB_fetchArray($result);
            $A['show_topic_icon'] = 1;
            $A['commentcode'] = $_CONF['comment_code'];
            $A['featured'] = 0;
            $A['statuscode'] = 0;
            $A['owner_id'] = $A['uid'];
            $access = 3;
            $A['title'] = htmlspecialchars ($A['title']);
        } else {
            // that submission doesn't seem to be there any more (may have been
            // handled by another Admin) - take us back to the moderation page
            return COM_refresh ($_CONF['site_admin_url'] . '/moderation.php');
        }
    } elseif ($mode == 'edit') {
        $A['sid'] = COM_makesid();
        $A['show_topic_icon'] = 1;
        $A['uid'] = $_USER['uid'];
        $A['unixdate'] = time();
        $A['expiredate'] = time();
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
        $res = DB_query("SELECT username, fullname, photo FROM {$_TABLES['users']} WHERE uid = {$A['uid']}");
        $A += DB_fetchArray($res);
        $res = DB_query("SELECT topic, imageurl FROM {$_TABLES['topics']} WHERE tid = '{$A['tid']}'");
        $A += DB_fetchArray($res);
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
        if ($A['postmode'] == 'html') {
            $A['introtext'] = COM_checkHTML(COM_checkWords($A['introtext']));
            $A['bodytext'] = COM_checkHTML(COM_checkWords($A['bodytext']));
            $A['title'] = COM_checkHTML(htmlspecialchars(COM_checkWords($A['title'])));
        } else {
            $A['introtext'] = htmlspecialchars(COM_checkWords($A['introtext']));
            $A['bodytext'] = htmlspecialchars(COM_checkWords($A['bodytext']));
            $A['title'] = htmlspecialchars(COM_checkWords($A['title']));
        }
        $A['title'] = strip_tags($A['title']);
    }

    // Load HTML templates
    $story_templates = new Template($_CONF['path_layout'] . 'admin/story');
    if (isset ($_CONF['advanced_editor']) && ($_CONF['advanced_editor'] == 1) && file_exists ($_CONF['path_layout'] . 'admin/story/storyeditor_advanced.thtml')) {
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
        $display .= STORY_renderArticle ($A, 'n');
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
    $groupdd = '';
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
    /* Auto Story Arhive or Delete Feature */
    if ($A['expiredate'] == 0) {
        $A['expiredate'] = time();
    }
    $expire_month = date('m', $A['expiredate']);
    $expire_day = date('d', $A['expiredate']);
    $expire_year = date('Y', $A['expiredate']);
    $expire_hour = date('H', $A['expiredate']);
    $expire_minute = date('i', $A['expiredate']);
    $expire_second = date('s', $A['expiredate']);
    $story_templates->set_var('expire_second', $expire_second);
    $expire_ampm = '';
    if ($expire_hour >= 12) {
        if ($expire_hour > 12) {
            $expire_hour = $expire_hour - 12;
        }
        $ampm = 'pm';
    } else {
        $ampm = 'am';
    }
    if ($ampm == 'pm') {
        $story_templates->set_var ('expirepm_selected', 'selected="selected"');
    } else {
        $story_templates->set_var ('expiream_selected', 'selected="selected"');
    }
    $month_options = COM_getMonthFormOptions($expire_month);
    $story_templates->set_var('expire_month_options', $month_options);
    $day_options = COM_getDayFormOptions($expire_day);
    $story_templates->set_var('expire_day_options', $day_options);
    $year_options = COM_getYearFormOptions($expire_year);
    $story_templates->set_var('expire_year_options', $year_options);
    $hour_options = COM_getHourFormOptions($expire_hour);
    $story_templates->set_var('expire_hour_options', $hour_options);   
    $minute_options = COM_getMinuteOptions($expire_minute);
    $story_templates->set_var('expire_minute_options', $minute_options);
    $story_templates->set_var('expire_date_explanation', $LANG24[46]);
    $story_templates->set_var('story_unixstamp', $A['expiredate']); 
    if ($A['statuscode'] == STORY_ARCHIVE_ON_EXPIRE) {
        $story_templates->set_var('is_checked2', 'checked="checked"');
        $story_templates->set_var('is_checked3', 'checked="checked"');
    } elseif ($A['statuscode'] == STORY_DELETE_ON_EXPIRE) {
        $story_templates->set_var('is_checked2', 'checked="checked"');
        $story_templates->set_var('is_checked4', 'checked="checked"');
    } else {
        $story_templates->set_var('showarchivedisabled', true);
    }
    $story_templates->set_var('lang_archivetitle', $LANG24[58]);
    $story_templates->set_var('lang_option', $LANG24[59]);
    $story_templates->set_var('lang_enabled', $LANG24[60]);
    $story_templates->set_var('lang_optionarchive', $LANG24[61]);
    $story_templates->set_var('lang_optiondelete', $LANG24[62]);
    $story_templates->set_var('lang_title', $LANG24[13]);
    if ($A['postmode'] == 'plaintext') {
        $A['title'] = str_replace ('$', '&#36;', $A['title']);
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
                $saved_images .= $z . ') <a href="' . $_CONF['site_url'] . '/images/articles/' . $I['ai_filename'] . '">' . $I['ai_filename'] . '</a>';
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
    global $_TABLES, $LANG24, $_CONF, $LANG_ACCESS, $LANG09, $_USER, $_GROUPS,$HTTP_POST_VARS,$HTTP_GET_VARS;

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

    if (!empty ($HTTP_GET_VARS['tid'])) {
        $current_topic = $HTTP_GET_VARS['tid'];
    } elseif (!empty ($HTTP_POST_VARS['tid'])) {
        $current_topic = $HTTP_POST_VARS['tid'];
    } else {
        $current_topic = $LANG09[9];
    }
    if (empty($page)) {
        $page = 1;
    }

    if ($current_topic == $LANG09[9]) {
        $excludetopics = '';
        $seltopics = '';
        $topicsql = "SELECT tid,topic FROM {$_TABLES['topics']}" . COM_getPermSQL ();
        $tresult = DB_query( $topicsql );
        $trows = DB_numRows( $tresult );     
        if( $trows > 0 )
        {
            $excludetopics .= ' WHERE (';
            for( $i = 1; $i <= $trows; $i++ )  {
                $T = DB_fetchArray ($tresult);
                if ($i > 1)  {
                    $excludetopics .= ' OR ';
                }
                $excludetopics .= "tid = '{$T['tid']}'";
                $seltopics .= '<option value="' .$T['tid']. '"';
                if ($current_topic == "{$T['tid']}") {
                    $seltopics .= ' selected="selected"';
                }
                $seltopics .= '>' . $T['topic'] . '</option>' . LB;
            }
            $excludetopics .= ') ';
        } 
    } else {
        $excludetopics = " WHERE tid = '$current_topic' ";
        $seltopics = COM_topicList ('tid,topic', $current_topic);
    }

    $alltopics = '<option value="' .$LANG09[9]. '"';
    if ($current_topic == $LANG09[9]) {
        $alltopics .= ' selected="selected"';
    }
    $alltopics .= '>' .$LANG09[9]. '</option>' . LB;
    $story_templates->set_var ('topic_selection', '<select name="tid" style="width: 125px" onchange="this.form.submit()">' . $alltopics . $seltopics . '</select>');

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
                    if (SEC_hasTopicAccess ($A['tid']) == 3) {
                        $access = $LANG_ACCESS['edit'];
                    } else {
                        $access = $LANG_ACCESS['readonly'];
                    }
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
            $story_templates->set_var('story_date', strftime($_CONF['shortdate'], $curtime[1]));
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
            $baseurl = $_CONF['site_admin_url'] . '/story.php?mode=list&amp;tid=' .$current_topic;
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
    global $_CONF, $_TABLES, $LANG24;

    $stdImageLoc = true;
    if (!strstr($_CONF['path_images'], $_CONF['path_html'])) {
        $stdImageLoc = false;
    }
    $result = DB_query("SELECT ai_filename FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' ORDER BY ai_img_num");
    $nrows = DB_numRows($result);
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);

        $imageX       = '[image' . $i . ']';
        $imageX_left  = '[image' . $i . '_left]';
        $imageX_right = '[image' . $i . '_right]';

        $dimensions = GetImageSize($_CONF['path_images'] . 'articles/' . $A['ai_filename']);
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
            $lFilename_large_complete = $_CONF['path_images'] . 'articles/'
                                      . $lFilename_large;
            if ($stdImageLoc) {
                $imgpath = substr ($_CONF['path_images'],
                                   strlen ($_CONF['path_html']));
                $lFilename_large_URL = $_CONF['site_url'] . '/' . $imgpath
                                     . 'articles/' . $lFilename_large;
            } else {
                $lFilename_large_URL = $_CONF['site_url']
                    . '/getimage.php?mode=show&amp;image=' . $lFilename_large;
            }
            if (file_exists ($lFilename_large_complete)) {
                $lLinkPrefix = '<a href="' . $lFilename_large_URL
                             . '" title="' . $LANG24[57] . '">';
                $lLinkSuffix = '</a>';
            }
        }

        if ($stdImageLoc) {
            $imgpath = substr ($_CONF['path_images'],
                               strlen ($_CONF['path_html']));
            $imgSrc = $_CONF['site_url'] . '/' . $imgpath . 'articles/'
                    . $A['ai_filename'];
        } else {
            $imgSrc = $_CONF['site_url']
                . '/getimage.php?mode=articles&amp;image=' . $A['ai_filename'];
        }
        $norm = $lLinkPrefix . '<img ' . $sizeattributes . 'src="' . $imgSrc . '" alt="">' . $lLinkSuffix;
        $left = $lLinkPrefix . '<img ' . $sizeattributes . 'align="left" src="' . $imgSrc . '" alt="">' . $lLinkSuffix;
        $right = $lLinkPrefix . '<img ' . $sizeattributes . 'align="right" src="' . $imgSrc . '" alt="">' . $lLinkSuffix;
        $fulltext = $intro . ' ' . $body;
        $count = substr_count($fulltext, $norm) + substr_count($fulltext, $left) + substr_count($fulltext, $right);
        $intro = str_replace ($norm,  $imageX,       $intro);
        $body  = str_replace ($norm,  $imageX,       $body);
        $intro = str_replace ($left,  $imageX_left,  $intro);
        $body  = str_replace ($left,  $imageX_left,  $body);
        $intro = str_replace ($right, $imageX_right, $intro);
        $body  = str_replace ($right, $imageX_right, $body);
    }

    return array($intro, $body);
}

/**
* Replaces simple image syntax with actual HTML in the intro and body.
* If errors occur it will return all errors in $error
*
* @param    string      $sid    ID for story to parse
* @param    string      $intro  Intro text
* @param    string      $body   Body text
* @return   string      Processed text
*
*/
function insert_images($sid, $intro, $body)
{
    global $_CONF, $_TABLES, $LANG24;

    $result = DB_query("SELECT ai_filename FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' ORDER BY ai_img_num");
    $nrows = DB_numRows($result);
    $errors = array();
    $stdImageLoc = true;
    if (!strstr($_CONF['path_images'], $_CONF['path_html'])) {
        $stdImageLoc = false;
    }
    for ($i = 1; $i <= $nrows; $i++) {
        $A = DB_fetchArray($result);
        $dimensions = GetImageSize($_CONF['path_images'] . 'articles/' . $A['ai_filename']);
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
            $lFilename_large_complete = $_CONF['path_images'] . 'articles/'
                                      . $lFilename_large;
            if ($stdImageLoc) {
                $imgpath = substr ($_CONF['path_images'],
                                   strlen ($_CONF['path_html']));
                $lFilename_large_URL = $_CONF['site_url'] . '/' . $imgpath
                                     . 'articles/' . $lFilename_large;
            } else {
                $lFilename_large_URL = $_CONF['site_url']
                    . '/getimage.php?mode=show&amp;image=' . $lFilename_large;
            }
            if (file_exists ($lFilename_large_complete)) {
                $lLinkPrefix = '<a href="' . $lFilename_large_URL
                             . '" title="' . $LANG24[57] . '">';   
                $lLinkSuffix = '</a>';
            }
        }

        $norm  = '[image' . $i . ']';
        $left  = '[image' . $i . '_left]';
        $right = '[image' . $i . '_right]';

        $fulltext = $intro . ' ' . $body;
        $icount = substr_count($fulltext, $norm) + substr_count($fulltext, $left) + substr_count($fulltext, $right);
        if ($icount == 0) {
            // There is an image that wasn't used, create an error
            $errors[] = $LANG24[48] . " #$i, {$A['ai_filename']}, " . $LANG24[53];
        } else {
            // Only parse if we haven't encountered any error to this point
            if (count($errors) == 0) {
                if ($stdImageLoc) {
                    $imgpath = substr ($_CONF['path_images'],
                                       strlen ($_CONF['path_html']));
                    $imgSrc = $_CONF['site_url'] . '/' . $imgpath . 'articles/'
                            . $A['ai_filename'];
                } else {
                    $imgSrc = $_CONF['site_url'] . '/getimage.php?mode=articles&amp;image=' . $A['ai_filename'];
                }
                $intro = str_replace($norm, $lLinkPrefix . '<img ' . $sizeattributes . 'src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $intro);
                $body = str_replace($norm, $lLinkPrefix . '<img ' . $sizeattributes . 'src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $body);
                $intro = str_replace($left, $lLinkPrefix . '<img ' . $sizeattributes . 'align="left" src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $intro);
                $body = str_replace($left, $lLinkPrefix . '<img ' . $sizeattributes . 'align="left" src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $body);
                $intro = str_replace($right, $lLinkPrefix . '<img ' . $sizeattributes . 'align="right" src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $intro);
                $body = str_replace($right, $lLinkPrefix . '<img ' . $sizeattributes . 'align="right" src="' . $imgSrc . '" alt="">' . $lLinkSuffix, $body);
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
function submitstory($type='',$sid,$uid,$tid,$title,$introtext,$bodytext,$hits,$unixdate,$expiredate,$comments,$featured,$commentcode,$statuscode,$postmode,$frontpage,$draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$delete,$show_topic_icon) 
{
    global $_CONF, $_TABLES, $_USER, $LANG24, $MESSAGE, $HTTP_POST_FILES;

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
        COM_accessLog("User {$_USER['username']} tried to illegally submit or edit story $sid.");
        echo $display;
        exit;
    } elseif (!empty($title) && !empty($introtext)) {
        $date = date ('Y-m-d H:i:s', $unixdate);
        $expire = date ('Y-m-d H:i:s', $expiredate);

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
        $related = addslashes (STORY_whatsRelated ("$introtext $bodytext", $uid, $tid));

        // Clean up the text
        if ($postmode == 'html') {
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
            $ai_filename = DB_getItem ($_TABLES['article_images'],'ai_filename', "ai_sid = '$sid' AND ai_img_num = " . key ($delete));
            STORY_deleteImage ($ai_filename);

            DB_query ("DELETE FROM {$_TABLES['article_images']} WHERE ai_sid = '$sid' AND ai_img_num = " . key ($delete));
            next ($delete);
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
                } elseif ($_CONF['image_lib'] == 'netpbm') {
                    // using netPBM
                    $upload->setNetPBM ($_CONF['path_to_netpbm']);
                } elseif ($_CONF['image_lib'] == 'gdlib') {
                    // using the GD library
                    $upload->setGDLib ();
                }
                $upload->setAutomaticResize(true);
                if (isset ($_CONF['debug_image_upload']) && $_CONF['debug_image_upload']) {
                    $upload->setLogFile ($_CONF['path'] . 'logs/error.log');
                    $upload->setDebug (true);
                }
                if ($_CONF['keep_unscaled_image'] == 1) {
                    $upload->keepOriginalImage (true);
                } else {
                    $upload->keepOriginalImage (false);
                }
            }
            $upload->setAllowedMimeTypes(array('image/gif'=>'.gif','image/jpeg'=>'.jpg,.jpeg','image/pjpeg'=>'.jpg,.jpeg','image/x-png'=>'.png','image/png'=>'.png'));
            if (!$upload->setPath($_CONF['path_images'] . 'articles')) {
                $display = COM_siteHeader ('menu');
                $display .= COM_startBlock ($LANG24[30], '', COM_getBlockTemplate ('_msg_block', 'header'));
                $display .= $upload->printErrors (false);
                $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
                $display .= COM_siteFooter ();
                echo $display;
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
                $retval .= COM_siteFooter();
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

        DB_save ($_TABLES['stories'], 'sid,uid,tid,title,introtext,bodytext,hits,date,comments,related,featured,commentcode,statuscode,expire,postmode,frontpage,draft_flag,numemails,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,show_topic_icon', "$sid,$uid,'$tid','$title','$introtext','$bodytext',$hits,FROM_UNIXTIME($unixdate),'$comments','$related',$featured,'$commentcode','$statuscode','$expire','$postmode','$frontpage',$draft_flag,$numemails,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$show_topic_icon");

        // If this is done as part of the moderation then delete the submission
        DB_delete ($_TABLES['storysubmission'], 'sid', $sid);

        // update feed(s) and Older Stories block
        COM_rdfUpToDateCheck ();
        COM_olderStuff ();

        if ($type == 'submission') {
            echo COM_refresh ($_CONF['site_admin_url'] . '/moderation.php?msg=9');
        } else {
            echo COM_refresh ($_CONF['site_admin_url'] . '/story.php?msg=9');
        }
        exit;
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
    global $_CONF, $_TABLES, $_USER;

    $result = DB_query ("SELECT tid,owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'");
    $A = DB_fetchArray ($result);
    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
            $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    $access = min ($access, SEC_hasTopicAccess ($A['tid']));
    if ($access < 3) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete story $sid.");
        return COM_refresh ($_CONF['site_admin_url'] . '/story.php');
    }

    STORY_deleteImages ($sid);
    DB_delete ($_TABLES['comments'], 'sid', $sid);
    DB_delete ($_TABLES['stories'], 'sid', $sid);

    // update RSS feed and Older Stories block
    COM_rdfUpToDateCheck ();
    COM_olderStuff ();

    return COM_refresh ($_CONF['site_admin_url'] . '/story.php?msg=10');
}

// MAIN
$mode = '';
if (isset ($HTTP_POST_VARS['mode'])) {
    $mode = COM_applyFilter ($HTTP_POST_VARS['mode']);
} else if (isset ($HTTP_GET_VARS['mode'])) {
    $mode = COM_applyFilter ($HTTP_GET_VARS['mode']);
}

$display = '';
if (($mode == $LANG24[11]) && !empty ($LANG24[11])) { // delete
    $sid = COM_applyFilter ($HTTP_POST_VARS['sid']);
    $type = COM_applyFilter ($HTTP_POST_VARS['type']);
    if (!isset ($sid) || empty ($sid) || ($sid == 0)) {
        COM_errorLog ('Attempted to delete story sid=' . $sid);
        echo COM_refresh ($_CONF['site_admin_url'] . '/story.php');
    } else if ($type == 'submission') {
        $tid = DB_getItem ($_TABLES['storysubmission'], 'tid', "sid = '$sid'");
        if (SEC_hasTopicAccess ($tid) < 3) {
            COM_accessLog ("User {$_USER['username']} tried to illegally delete story submission $sid.");
            echo COM_refresh ($_CONF['site_admin_url'] . '/index.php');
        } else {
            DB_delete ($_TABLES['storysubmission'], 'sid', $sid,
                       $_CONF['site_admin_url'] . '/moderation.php');
        }
    } else {
        echo deletestory ($sid);
    }
} else if (($mode == $LANG24[9]) && !empty ($LANG24[9])) { // preview
    $display .= COM_siteHeader('menu');
    $display .= storyeditor (COM_applyFilter ($HTTP_POST_VARS['sid']), $mode);
    $display .= COM_siteFooter();
    echo $display;
} else if ($mode == 'edit') {
    $display .= COM_siteHeader('menu');
    $display .= storyeditor (COM_applyFilter ($HTTP_GET_VARS['sid']), $mode);
    $display .= COM_siteFooter();
    echo $display;
} else if ($mode == 'editsubmission') {
    $display .= COM_siteHeader('menu');
    $display .= storyeditor (COM_applyFilter ($HTTP_GET_VARS['id']), $mode);
    $display .= COM_siteFooter();
    echo $display;
} else if (($mode == $LANG24[8]) && !empty ($LANG24[8])) { // save
    $publish_ampm = COM_applyFilter ($HTTP_POST_VARS['publish_ampm']);
    $publish_hour = COM_applyFilter ($HTTP_POST_VARS['publish_hour'], true);
    $publish_minute = COM_applyFilter ($HTTP_POST_VARS['publish_minute'], true);
    $publish_second = COM_applyFilter ($HTTP_POST_VARS['publish_second'], true);
    if ($publish_ampm == 'pm') {
        if ($publish_hour < 12) {
            $publish_hour = $publish_hour + 12;
        }
    }
    if ($publish_ampm == 'am' AND $publish_hour == 12) {
        $publish_hour = '00';
    }
    $publish_year = COM_applyFilter ($HTTP_POST_VARS['publish_year'], true);
    $publish_month = COM_applyFilter ($HTTP_POST_VARS['publish_month'], true);
    $publish_day = COM_applyFilter ($HTTP_POST_VARS['publish_day'], true);
    $archiveflag = COM_applyFilter ($HTTP_POST_VARS['archiveflag'], true);

    $unixdate = strtotime("$publish_month/$publish_day/$publish_year $publish_hour:$publish_minute:$publish_second");
    if ($archiveflag != 1) {
        $statuscode = 0;
    }

    $expire_ampm = COM_applyFilter ($HTTP_POST_VARS['expire_ampm']);
    $expire_hour = COM_applyFilter ($HTTP_POST_VARS['expire_hour'], true);
    $expire_minute = COM_applyFilter ($HTTP_POST_VARS['expire_minute'], true);
    $expire_second = COM_applyFilter ($HTTP_POST_VARS['expire_second'], true);
    $expire_year = COM_applyFilter ($HTTP_POST_VARS['expire_year'], true);
    $expire_month = COM_applyFilter ($HTTP_POST_VARS['expire_month'], true);
    $expire_day = COM_applyFilter ($HTTP_POST_VARS['expire_day'], true);

    if (isset($expire_hour))  {
        if ($expire_ampm == 'pm') {
            if ($expire_hour < 12) {
                $expire_hour = $expire_hour + 12;
            }
        }
        if ($expire_ampm == 'am' AND $expire_hour == 12) {
            $expire_hour = '00';
        }
        $expiredate = strtotime("$expire_month/$expire_day/$expire_year $expire_hour:$expire_minute:$expire_second");
    } else {
        $expiredate = time();
    }
    $uid = COM_applyFilter ($HTTP_POST_VARS['uid'], true);

    submitstory (COM_applyFilter ($HTTP_POST_VARS['type']),
                 COM_applyFilter ($HTTP_POST_VARS['sid']), $uid,
                 COM_applyFilter ($HTTP_POST_VARS['tid']),
                 $HTTP_POST_VARS['title'],
                 $HTTP_POST_VARS['introtext'], $HTTP_POST_VARS['bodytext'],
                 COM_applyFilter ($HTTP_POST_VARS['hits'], true), $unixdate,$expiredate,
                 COM_applyFilter ($HTTP_POST_VARS['comments'], true),
                 COM_applyFilter ($HTTP_POST_VARS['featured'], true),
                 COM_applyFilter ($HTTP_POST_VARS['commentcode']),
                 COM_applyFilter ($HTTP_POST_VARS['statuscode']),
                 COM_applyFilter ($HTTP_POST_VARS['postmode']),
                 COM_applyFilter ($HTTP_POST_VARS['frontpage']),
                 COM_applyFilter ($HTTP_POST_VARS['draft_flag']),
                 COM_applyFilter ($HTTP_POST_VARS['numemails'], true),
                 COM_applyFilter ($HTTP_POST_VARS['owner_id'], true),
                 COM_applyFilter ($HTTP_POST_VARS['group_id'], true),
                 $HTTP_POST_VARS['perm_owner'], $HTTP_POST_VARS['perm_group'],
                 $HTTP_POST_VARS['perm_members'], $HTTP_POST_VARS['perm_anon'],
                 $HTTP_POST_VARS['delete'],
                 COM_applyFilter ($HTTP_POST_VARS['show_topic_icon']));
} else { // 'cancel' or no mode at all
    $type = COM_applyFilter ($HTTP_POST_VARS['type']);
    if (($mode == $LANG24[10]) && !empty ($LANG24[10]) &&
            ($type == 'submission')) {
        $display = COM_refresh ($_CONF['site_admin_url'] . '/moderation.php');
    } else {
        $display .= COM_siteHeader('menu');
        $display .= COM_showMessage (COM_applyFilter ($HTTP_GET_VARS['msg'],
                                                      true));
        $display .= liststories (COM_applyFilter ($HTTP_GET_VARS['page'], true));
        $display .= COM_siteFooter();
    }
    echo $display;
}

?>
