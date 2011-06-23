<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | story.php                                                                 |
// |                                                                           |
// | Geeklog story administration page.                                        |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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

/**
* This is the Geeklog story administration page.
*
* @author   Jason Whittenburg
* @author   Tony Bibbs, tony AT tonybibbs DOT com
*
*/

/**
* Geeklog common function library
*/
require_once '../lib-common.php';

/**
* Security check to ensure user even belongs on this page
*/
require_once 'auth.inc.php';

/**
* Geeklog story function library
*/
require_once $_CONF['path_system'] . 'lib-story.php';

// Set this to true if you want to have this code output debug messages to
// the error log
$_STORY_VERBOSE = false;

$display = '';

if (!SEC_hasRights('story.edit')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the story administration screen.");
    COM_output($display);
    exit;
}


// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// debug($_POST);


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
* Provide list of stories
*
* @param    string  $current_topic  (optional) currently selected topic
* @return   string                  HTML for the list of stories
*
*/
function liststories($current_topic = '')
{
    global $_CONF, $_TABLES, $_IMAGE_TYPE,
           $LANG09, $LANG_ADMIN, $LANG_ACCESS, $LANG24;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    $retval = '';

    if (empty($current_topic)) {
        $current_topic = $LANG09[9];
    }

    if ($current_topic == $LANG09[9]) { // "All"
        $excludetopics = '';
        $seltopics = '';
        $topicsql = "SELECT tid,topic FROM {$_TABLES['topics']}"
                  . COM_getPermSQL ();
        $tresult = DB_query($topicsql);
        $trows = DB_numRows($tresult);
        if ($trows > 0) {
            $exclude = array();
            for ($i = 0; $i < $trows; $i++)  {
                $T = DB_fetchArray($tresult);
                $exclude[] = $T['tid'];
                $seltopics .= '<option value="' . $T['tid'] . '"';
                if ($current_topic == $T['tid']) {
                    $seltopics .= ' selected="selected"';
                }
                $seltopics .= '>' . $T['topic'] . '</option>' . LB;
            }
            $excludetopics = " (tid IN ('" . implode( "','", $exclude ) . "')) ";
        } else {
            $retval .= COM_showMessage(101);
            return $retval;
        }
    } else {
        $excludetopics = " tid = '$current_topic' ";
        $seltopics = COM_topicList('tid,topic', $current_topic, 1, true);
        if (empty($seltopics)) {
            $retval .= COM_showMessage(101);
            return $retval;
        }
    }

    $alltopics = '<option value="' .$LANG09[9]. '"';
    if ($current_topic == $LANG09[9]) {
        $alltopics .= ' selected="selected"';
    }
    $alltopics .= '>' .$LANG09[9]. '</option>' . LB;
    $filter = $LANG_ADMIN['topic']
        . ': <select name="tid" style="width: 125px" onchange="this.form.submit()">'
        . $alltopics . $seltopics . '</select>';

    $header_arr = array(
        array('text' => $LANG_ADMIN['edit'], 'field' => 'edit', 'sort' => false),
        array('text' => $LANG_ADMIN['copy'], 'field' => 'copy', 'sort' => false),
        array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
        array('text' => $LANG_ACCESS['access'], 'field' => 'access', 'sort' => false),
        array('text' => $LANG24[34], 'field' => 'draft_flag', 'sort' => true)
    );
    if ($_CONF['show_fullname'] == 1) {
        $header_arr[] = array('text' => $LANG24[7], 'field' => 'fullname', 'sort' => true); // author
    } else {
        $header_arr[] = array('text' => $LANG24[7], 'field' => 'username', 'sort' => true); // author
    }
    $header_arr[] = array('text' => $LANG24[15], 'field' => 'unixdate', 'sort' => true); // date
    $header_arr[] = array('text' => $LANG_ADMIN['topic'], 'field' => 'tid', 'sort' => true);
    $header_arr[] = array('text' => $LANG24[32], 'field' => 'featured', 'sort' => true);

    if (SEC_hasRights ('story.ping') && ($_CONF['trackback_enabled'] ||
            $_CONF['pingback_enabled'] || $_CONF['ping_enabled'])) {
        $header_arr[] = array('text' => $LANG24[20], 'field' => 'ping', 'sort' => false);
    }

    $defsort_arr = array('field' => 'unixdate', 'direction' => 'desc');

    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'] . '/story.php?mode=edit',
              'text' => $LANG_ADMIN['create_new'])
    );

    $menu_arr[] = array('url' => $_CONF['site_admin_url'],
                        'text' => $LANG_ADMIN['admin_home']);

    $retval .= COM_startBlock($LANG24[22], '',
                              COM_getBlockTemplate('_admin_block', 'header'));

    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG24[23],
        $_CONF['layout_url'] . '/images/icons/story.' . $_IMAGE_TYPE
    );
    $text_arr = array(
        'has_extras' => true,
        'form_url'   => $_CONF['site_admin_url'] . '/story.php'
    );

    $sql = "SELECT {$_TABLES['stories']}.*, {$_TABLES['users']}.username, {$_TABLES['users']}.fullname, "
          ."UNIX_TIMESTAMP(date) AS unixdate  FROM {$_TABLES['stories']} "
          ."LEFT JOIN {$_TABLES['users']} ON {$_TABLES['stories']}.uid={$_TABLES['users']}.uid "
          ."WHERE 1=1 ";

    if (!empty ($excludetopics)) {
        $excludetopics = 'AND ' . $excludetopics;
    }
    $query_arr = array(
        'table' => 'stories',
        'sql' => $sql,
        'query_fields' => array('title', 'introtext', 'bodytext', 'sid', 'tid'),
        'default_filter' => $excludetopics . COM_getPermSQL('AND')
    );

    $retval .= ADMIN_list('story', 'ADMIN_getListField_stories', $header_arr,
                          $text_arr, $query_arr, $defsort_arr, $filter);
    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
* Shows story editor
*
* Displays the story entry form
*
* @param    string      $sid            ID of story to edit
* @param    string      $mode           'preview', 'edit', 'editsubmission', 'clone'
* @param    string      $errormsg       a message to display on top of the page
* @param    string      $currenttopic   topic selection for drop-down menu
* @return   string      HTML for story editor
*
*/
function storyeditor($sid = '', $mode = '', $errormsg = '', $currenttopic = '')
{
    global $_CONF, $_TABLES, $_USER, $LANG24, $LANG_ACCESS, $LANG_ADMIN,
           $MESSAGE, $_SCRIPTS;

    $display = '';

    if (!isset ($_CONF['hour_mode'])) {
        $_CONF['hour_mode'] = 12;
    }

    if (!empty($errormsg)) {
        $display .= COM_showMessageText($errormsg, $LANG24[25]);
    }

    if (!empty ($currenttopic)) {
        $allowed = DB_getItem ($_TABLES['topics'], 'tid',
                                "tid = '" . addslashes ($currenttopic) . "'" .
                                COM_getTopicSql ('AND'));

        if ($allowed != $currenttopic) {
            $currenttopic = '';
        }
    }

    $story = new Story();
    if ($mode == 'preview') {
        // Handle Magic GPC Garbage:
        while (list($key, $value) = each($_POST)) {
            if (!is_array($value)) {
                $_POST[$key] = COM_stripslashes($value);
            } else {
                while (list($subkey, $subvalue) = each($value)) {
                    $value[$subkey] = COM_stripslashes($subvalue);
                }
            }
        }
        $result = $story->loadFromArgsArray($_POST);

        // in preview mode, we now need to re-insert the images
        if ($_CONF['maximagesperarticle'] > 0) {
            $errors = $story->insertImages();
            if (count($errors) > 0) {
                $msg = $LANG24[55] . LB . '<ul>' . LB;
                foreach ($errors as $err) {
                    $msg .= '<li>' . $err . '</li>' . LB;
                }
                $msg .= '</ul>' . LB;
                $display .= COM_showMessageText($msg, $LANG24[54]);
            }
        }
    } else {
        $result = $story->loadFromDatabase($sid, $mode);
    }

    if (($result == STORY_PERMISSION_DENIED) ||
            ($result == STORY_NO_ACCESS_PARAMS)) {
        $display .= COM_showMessageText($LANG24[42],
                                        $LANG_ACCESS['accessdenied']);
        COM_accessLog("User {$_USER['username']} tried to illegally access story $sid.");
        return $display;
    } elseif (($result == STORY_EDIT_DENIED) ||
            ($result == STORY_EXISTING_NO_EDIT_PERMISSION)) {
        $display .= COM_showMessageText($LANG24[41],
                                        $LANG_ACCESS['accessdenied']);
        $display .= STORY_renderArticle ($story, 'p');
        COM_accessLog("User {$_USER['username']} tried to illegally edit story $sid.");
        return $display;
    } elseif ($result == STORY_INVALID_SID) {
        if ($mode == 'editsubmission') {
            // that submission doesn't seem to be there any more (may have been
            // handled by another Admin) - take us back to the moderation page
            return COM_refresh($_CONF['site_admin_url'] . '/moderation.php');
        } else {
            return COM_refresh($_CONF['site_admin_url'] . '/story.php');
        }
    } elseif ($result == STORY_DUPLICATE_SID) {
        $display .= COM_showMessageText($LANG24[24]);
    }

    // Load HTML templates
    $story_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/story');
    if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
        $story_templates->set_file(array('editor'=>'storyeditor_advanced.thtml'));
        $advanced_editormode = true;
        $story_templates->set_var ('change_editormode', 'onchange="change_editmode(this);"');

        require_once $_CONF['path_system'] . 'classes/navbar.class.php';
        $story_templates->set_var ('show_preview', 'none');
        $story_templates->set_var ('lang_expandhelp', $LANG24[67]);
        $story_templates->set_var ('lang_reducehelp', $LANG24[68]);
        $story_templates->set_var ('lang_publishdate', $LANG24[69]);
        $story_templates->set_var ('lang_toolbar', $LANG24[70]);
        $story_templates->set_var ('toolbar1', $LANG24[71]);
        $story_templates->set_var ('toolbar2', $LANG24[72]);
        $story_templates->set_var ('toolbar3', $LANG24[73]);
        $story_templates->set_var ('toolbar4', $LANG24[74]);
        $story_templates->set_var ('toolbar5', $LANG24[75]);

        if ($story->EditElements('advanced_editor_mode') == 1 OR $story->EditElements('postmode') == 'adveditor') {
            $story_templates->set_var ('show_texteditor', 'none');
            $story_templates->set_var ('show_htmleditor', '');
        } else {
            $story_templates->set_var ('show_texteditor', '');
            $story_templates->set_var ('show_htmleditor', 'none');
        }
    } else {
        $story_templates->set_file(array('editor' => 'storyeditor.thtml'));
        $advanced_editormode = false;
    }
     $story_templates->set_var('hour_mode',      $_CONF['hour_mode']);

    if ($story->hasContent()) {
        $previewContent = STORY_renderArticle($story, 'p');
        if ($advanced_editormode AND $previewContent != '' ) {
            $story_templates->set_var('preview_content', $previewContent);
        } elseif ($previewContent != '') {
            $display .= COM_startBlock ($LANG24[26], '',
                            COM_getBlockTemplate ('_admin_block', 'header'));
            $display .= $previewContent;
            $display .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
        }
    }

    if ($advanced_editormode) {
        $navbar = new navbar;
        if (!empty ($previewContent)) {
            $navbar->add_menuitem($LANG24[79],'showhideEditorDiv("preview",0);return false;',true);
            $navbar->add_menuitem($LANG24[80],'showhideEditorDiv("editor",1);return false;',true);
            $navbar->add_menuitem($LANG24[81],'showhideEditorDiv("publish",2);return false;',true);
            $navbar->add_menuitem($LANG24[82],'showhideEditorDiv("images",3);return false;',true);
            $navbar->add_menuitem($LANG24[83],'showhideEditorDiv("archive",4);return false;',true);
            $navbar->add_menuitem($LANG24[84],'showhideEditorDiv("perms",5);return false;',true);
            $navbar->add_menuitem($LANG24[85],'showhideEditorDiv("all",6);return false;',true);
        }  else {
            $navbar->add_menuitem($LANG24[80],'showhideEditorDiv("editor",0);return false;',true);
            $navbar->add_menuitem($LANG24[81],'showhideEditorDiv("publish",1);return false;',true);
            $navbar->add_menuitem($LANG24[82],'showhideEditorDiv("images",2);return false;',true);
            $navbar->add_menuitem($LANG24[83],'showhideEditorDiv("archive",3);return false;',true);
            $navbar->add_menuitem($LANG24[84],'showhideEditorDiv("perms",4);return false;',true);
            $navbar->add_menuitem($LANG24[85],'showhideEditorDiv("all",5);return false;',true);
        }
        if ($mode == 'preview') {
            $story_templates->set_var ('show_preview', '');
            $story_templates->set_var ('show_htmleditor', 'none');
            $story_templates->set_var ('show_texteditor', 'none');
            $story_templates->set_var ('show_submitoptions', 'none');
            $navbar->set_selected($LANG24[79]);
        } else {
            $navbar->set_selected($LANG24[80]);
        }
        $story_templates->set_var ('navbar', $navbar->generate() );
    }

    $oldsid = $story->EditElements('originalSid');
    if (!empty ($oldsid) && $mode != 'clone') {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s' . XHTML . '>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $story_templates->set_var ('delete_option',
                                   sprintf ($delbutton, $jsconfirm));
        $story_templates->set_var ('delete_option_no_confirmation',
                                   sprintf ($delbutton, ''));
    }
    if (($mode == 'editsubmission') || ($story->type == 'submission')) {
        $story_templates->set_var ('submission_option',
                '<input type="hidden" name="type" value="submission"' . XHTML . '>');
    }
    $story_templates->set_var ('lang_author', $LANG24[7]);
    $storyauthor = COM_getDisplayName ($story->EditElements('uid'));
    $story_templates->set_var ('story_author', $storyauthor);
    $story_templates->set_var ('author', $storyauthor);
    $story_templates->set_var ('story_uid', $story->EditElements('uid'));

    // user access info
    $story_templates->set_var('lang_accessrights',$LANG_ACCESS['accessrights']);
    $story_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $ownername = COM_getDisplayName ($story->EditElements('owner_id'));
    $story_templates->set_var( 'owner_username', DB_getItem ($_TABLES['users'],
                              'username', 'uid = ' .
                              $story->EditElements( 'owner_id' ) ) );
    $story_templates->set_var('owner_name', $ownername);
    $story_templates->set_var('owner', $ownername);
    $story_templates->set_var('owner_id', $story->EditElements('owner_id'));
    $story_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $story_templates->set_var('group_dropdown',
                              SEC_getGroupDropdown ($story->EditElements('group_id'), 3));
    $story_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $story_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $story_templates->set_var('permissions_editor', SEC_getPermissionsHTML(
        $story->EditElements('perm_owner'),$story->EditElements('perm_group'),
        $story->EditElements('perm_members'),$story->EditElements('perm_anon')));
    $story_templates->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
    $story_templates->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);
    $curtime = COM_getUserDateTimeFormat($story->EditElements('date'));
    $story_templates->set_var('lang_date', $LANG24[15]);

    $story_templates->set_var('publish_second', $story->EditElements('publish_second'));

    $publish_ampm = '';
    $publish_hour = $story->EditElements('publish_hour');
    if ($publish_hour >= 12) {
        if ($publish_hour > 12) {
            $publish_hour = $publish_hour - 12;
        }
        $ampm = 'pm';
    } else {
        $ampm = 'am';
    }
    $ampm_select = COM_getAmPmFormSelection ('publish_ampm', $ampm);
    $story_templates->set_var ('publishampm_selection', $ampm_select);

    $month_options = COM_getMonthFormOptions($story->EditElements('publish_month'));
    $story_templates->set_var('publish_month_options', $month_options);

    $day_options = COM_getDayFormOptions($story->EditElements('publish_day'));
    $story_templates->set_var('publish_day_options', $day_options);

    $year_options = COM_getYearFormOptions($story->EditElements('publish_year'));
    $story_templates->set_var('publish_year_options', $year_options);

    if ($_CONF['hour_mode'] == 24) {
        $hour_options = COM_getHourFormOptions ($story->EditElements('publish_hour'), 24);
    } else {
        $hour_options = COM_getHourFormOptions ($publish_hour);
    }
    $story_templates->set_var('publish_hour_options', $hour_options);

    $minute_options = COM_getMinuteFormOptions($story->EditElements('publish_minute'));
    $story_templates->set_var('publish_minute_options', $minute_options);

    $story_templates->set_var('publish_date_explanation', $LANG24[46]);
    $story_templates->set_var('story_unixstamp', $story->EditElements('unixdate'));

    $story_templates->set_var('expire_second', $story->EditElements('expire_second'));

    $expire_ampm = '';
    $expire_hour = $story->EditElements('expire_hour');
    if ($expire_hour >= 12) {
        if ($expire_hour > 12) {
            $expire_hour = $expire_hour - 12;
        }
        $ampm = 'pm';
    } else {
        $ampm = 'am';
    }
    $ampm_select = COM_getAmPmFormSelection ('expire_ampm', $ampm);
    if (empty ($ampm_select)) {
        // have a hidden field to 24 hour mode to prevent JavaScript errors
        $ampm_select = '<input type="hidden" name="expire_ampm" value=""' . XHTML . '>';
    }
    $story_templates->set_var ('expireampm_selection', $ampm_select);

    $month_options = COM_getMonthFormOptions($story->EditElements('expire_month'));
    $story_templates->set_var('expire_month_options', $month_options);

    $day_options = COM_getDayFormOptions($story->EditElements('expire_day'));
    $story_templates->set_var('expire_day_options', $day_options);

    $year_options = COM_getYearFormOptions($story->EditElements('expire_year'));
    $story_templates->set_var('expire_year_options', $year_options);

    if ($_CONF['hour_mode'] == 24) {
        $hour_options = COM_getHourFormOptions ($story->EditElements('expire_hour'), 24);
    } else {
        $hour_options = COM_getHourFormOptions ($expire_hour);
    }
    $story_templates->set_var('expire_hour_options', $hour_options);

    $minute_options = COM_getMinuteFormOptions($story->EditElements('expire_minute'));
    $story_templates->set_var('expire_minute_options', $minute_options);

    $story_templates->set_var('expire_date_explanation', $LANG24[46]);
    $story_templates->set_var('story_unixstamp', $story->EditElements('expirestamp'));

    $atopic = DB_getItem($_TABLES['topics'], 'tid', "archive_flag = 1");
    $have_archive_topic = (empty($atopic) ? false : true);

    if ($story->EditElements('statuscode') == STORY_ARCHIVE_ON_EXPIRE) {
        $story_templates->set_var('is_checked2', 'checked="checked"');
        $story_templates->set_var('is_checked3', 'checked="checked"');
        $js_showarchivedisabled = 'false';
        $have_archive_topic = true; // force display of auto archive option
    } elseif ($story->EditElements('statuscode') == STORY_DELETE_ON_EXPIRE) {
        $story_templates->set_var('is_checked2', 'checked="checked"');
        $story_templates->set_var('is_checked4', 'checked="checked"');
        if (! $have_archive_topic) {
            $story_templates->set_var('is_checked3', 'style="display:none;"');
        }
        $js_showarchivedisabled = 'false';
    } else {
        if (! $have_archive_topic) {
            $story_templates->set_var('is_checked3', 'style="display:none;"');
        }
        $js_showarchivedisabled = 'true';
    }
    $story_templates->set_var('lang_archivetitle', $LANG24[58]);
    $story_templates->set_var('lang_option', $LANG24[59]);
    $story_templates->set_var('lang_enabled', $LANG_ADMIN['enabled']);
    $story_templates->set_var('lang_story_stats', $LANG24[87]);
    if ($have_archive_topic) {
        $story_templates->set_var('lang_optionarchive', $LANG24[61]);
    } else {
        $story_templates->set_var('lang_optionarchive', '');
    }
    $story_templates->set_var('lang_optiondelete', $LANG24[62]);
    $story_templates->set_var('lang_title', $LANG_ADMIN['title']);
    $story_templates->set_var('story_title', $story->EditElements('title'));
    $story_templates->set_var('lang_page_title', $LANG_ADMIN['page_title']);
    $story_templates->set_var('page_title' , $story->EditElements('page_title'));
    $story_templates->set_var('lang_metadescription', $LANG_ADMIN['meta_description']);
    $story_templates->set_var('meta_description', $story->EditElements('meta_description'));
    $story_templates->set_var('lang_metakeywords', $LANG_ADMIN['meta_keywords']);
    $story_templates->set_var('meta_keywords', $story->EditElements('meta_keywords'));
    if ($_CONF['meta_tags'] > 0) {
        $story_templates->set_var('hide_meta', '');
    } else {
        $story_templates->set_var('hide_meta', ' style="display:none;"');
    }
    $story_templates->set_var('lang_topic', $LANG_ADMIN['topic']);
    if(empty($currenttopic) && ($story->EditElements('tid') == '')) {
        $story->setTid(DB_getItem($_TABLES['topics'], 'tid',
                                  'is_default = 1' . COM_getPermSQL('AND')));
    } elseif ($story->EditElements('tid') == '') {
        $story->setTid($currenttopic);
    }

    $tlist = COM_topicList('tid,topic', $story->EditElements('tid'), 1, true);
    if (empty($tlist)) {
        $display .= COM_showMessage(101);
        return $display;
    }
    $story_templates->set_var('topic_options', $tlist);
    $story_templates->set_var('lang_show_topic_icon', $LANG24[56]);
    if ($story->EditElements('show_topic_icon') == 1) {
        $story_templates->set_var('show_topic_icon_checked', 'checked="checked"');
    } else {
        $story_templates->set_var('show_topic_icon_checked', '');
    }
    $story_templates->set_var('lang_draft', $LANG24[34]);
    if ($story->EditElements('draft_flag')) {
        $story_templates->set_var('is_checked', 'checked="checked"');
    }
    $story_templates->set_var ('lang_mode', $LANG24[3]);
    $story_templates->set_var ('status_options',
            COM_optionList ($_TABLES['statuscodes'], 'code,name',
                            $story->EditElements('statuscode')));
    $story_templates->set_var ('comment_options',
            COM_optionList ($_TABLES['commentcodes'], 'code,name',
                            $story->EditElements('commentcode')));
    $story_templates->set_var ('trackback_options',
            COM_optionList ($_TABLES['trackbackcodes'], 'code,name',
                            $story->EditElements('trackbackcode')));
    // comment expire
    $story_templates->set_var('lang_cmt_disable', $LANG24[63]);
    if ($story->EditElements('cmt_close')) {
        $story_templates->set_var('is_checked5', 'checked="checked"');
        $js_showcmtclosedisabled = 'false';
    } else {
        $js_showcmtclosedisabled = 'true';
    }

    $month_options = COM_getMonthFormOptions($story->EditElements('cmt_close_month'));
    $story_templates->set_var('cmt_close_month_options', $month_options);

    $day_options = COM_getDayFormOptions($story->EditElements('cmt_close_day'));
    $story_templates->set_var('cmt_close_day_options', $day_options);

    // ensure that the year dropdown includes the close year
    $endtm = mktime(0, 0, 0, date('m'),
                date('d') + $_CONF['article_comment_close_days'], date('Y'));
    $yoffset = date('Y', $endtm) - date('Y');
    $close_year = $story->EditElements('cmt_close_year');
    if ($yoffset < -1) {
        $year_options = COM_getYearFormOptions($close_year, $yoffset);
    } elseif ($yoffset > 5) {
        $year_options = COM_getYearFormOptions($close_year, -1, $yoffset);
    } else {
        $year_options = COM_getYearFormOptions($close_year);
    }
    $story_templates->set_var('cmt_close_year_options', $year_options);

    $cmt_close_ampm = '';
    $cmt_close_hour = $story->EditElements('cmt_close_hour');
    //correct hour
    if ($cmt_close_hour >= 12) {
        if ($cmt_close_hour > 12) {
            $cmt_close_hour = $cmt_close_hour - 12;
        }
        $ampm = 'pm';
    } else {
        $ampm = 'am';
    }
    $ampm_select = COM_getAmPmFormSelection ('cmt_close_ampm', $ampm);
    if (empty ($ampm_select)) {
        // have a hidden field to 24 hour mode to prevent JavaScript errors
        $ampm_select = '<input type="hidden" name="cmt_close_ampm" value=""' . XHTML . '>';
    }
    $story_templates->set_var ('cmt_close_ampm_selection', $ampm_select);

    if ($_CONF['hour_mode'] == 24) {
        $hour_options = COM_getHourFormOptions ($story->EditElements('cmt_close_hour'), 24);
    } else {
        $hour_options = COM_getHourFormOptions ($cmt_close_hour);
    }
    $story_templates->set_var('cmt_close_hour_options', $hour_options);

    $minute_options = COM_getMinuteFormOptions($story->EditElements('cmt_close_minute'));
    $story_templates->set_var('cmt_close_minute_options', $minute_options);

    $story_templates->set_var('cmt_close_second', $story->EditElements('cmt_close_second'));

    if (($_CONF['onlyrootfeatures'] == 1 && SEC_inGroup('Root'))
        or ($_CONF['onlyrootfeatures'] !== 1)) {
        $featured_options = "<select name=\"featured\">" . LB
                          . COM_optionList ($_TABLES['featurecodes'], 'code,name', $story->EditElements('featured'))
                          . "</select>" . LB;
    } else {
        $featured_options = "<input type=\"hidden\" name=\"featured\" value=\"0\"" . XHTML . ">";
    }
    $story_templates->set_var ('featured_options',$featured_options);
    $story_templates->set_var ('frontpage_options',
            COM_optionList ($_TABLES['frontpagecodes'], 'code,name',
                            $story->EditElements('frontpage')));

    $story_templates->set_var('story_introtext', $story->EditElements('introtext'));

    $story_templates->set_var('story_bodytext', $story->EditElements('bodytext'));
    $story_templates->set_var('lang_introtext', $LANG24[16]);
    $story_templates->set_var('lang_bodytext', $LANG24[17]);
    $story_templates->set_var('lang_postmode', $LANG24[4]);
    $story_templates->set_var('lang_publishoptions',$LANG24[76]);
    $story_templates->set_var('noscript', COM_getNoScript(false, $LANG24[77], sprintf($LANG24[78],$_CONF['site_admin_url'], $sid)));
    
    $post_options = COM_optionList($_TABLES['postmodes'],'code,name',$story->EditElements('postmode'));

    // If Advanced Mode - add post option and set default if editing story created with Advanced Editor
    if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
        if ($story->EditElements('advanced_editor_mode') == 1 OR $story->EditElements('postmode') == 'adveditor') {
            $post_options .= '<option value="adveditor" selected="selected">'.$LANG24[86].'</option>';
        } else {
            $post_options .= '<option value="adveditor">'.$LANG24[86].'</option>';
        }
    }
    if ($_CONF['wikitext_editor']) {
        if ($story->EditElements('postmode') == 'wikitext') {
            $post_options .= '<option value="wikitext" selected="selected">'.$LANG24[88].'</option>';
        } else {
            $post_options .= '<option value="wikitext">'.$LANG24[88].'</option>';
        }
    }
    $story_templates->set_var('post_options',$post_options );
    $story_templates->set_var('lang_allowed_html',
                              COM_allowedHTML('story.edit'));
    $fileinputs = '';
    $saved_images = '';
    if ($_CONF['maximagesperarticle'] > 0) {
        $story_templates->set_var('lang_images', $LANG24[47]);
        $icount = DB_count($_TABLES['article_images'],'ai_sid', $story->getSid());
        if ($icount > 0) {
            $result_articles = DB_query("SELECT * FROM {$_TABLES['article_images']} WHERE ai_sid = '".$story->getSid()."'");
            for ($z = 1; $z <= $icount; $z++) {
                $I = DB_fetchArray($result_articles);
                $saved_images .= $z . ') '
                    . COM_createLink($I['ai_filename'],
                        $_CONF['site_url'] . '/images/articles/' . $I['ai_filename'])
                    . '&nbsp;&nbsp;&nbsp;' . $LANG_ADMIN['delete']
                    . ': <input type="checkbox" name="delete[' .$I['ai_img_num']
                    . ']"' . XHTML . '><br' . XHTML . '>';
            }
        }

        $newallowed = $_CONF['maximagesperarticle'] - $icount;
        for ($z = $icount + 1; $z <= $_CONF['maximagesperarticle']; $z++) {
            $fileinputs .= $z . ') <input type="file" dir="ltr" name="file'
                        . $z . '"' . XHTML . '>';
            if ($z < $_CONF['maximagesperarticle']) {
                $fileinputs .= '<br' . XHTML . '>';
            }
        }
        $fileinputs .= '<br' . XHTML . '>' . $LANG24[51];
        if ($_CONF['allow_user_scaling'] == 1) {
            $fileinputs .= $LANG24[27];
        }
        $fileinputs .= $LANG24[28] . '<br' . XHTML . '>';
    }
    
    // *****************************************    
    // Add JavaScript
    if (!$advanced_editormode) {
        $js = '<script type="text/javascript">
        //<![CDATA[
        function enablearchive(obj) {
            var f = obj.form;           // all elements have their parent form in "form"
            var disable = obj.checked;  // Disable when checked
            if (f.elements["archiveflag"].checked==true && f.elements["storycode11"].checked==false) {
                f.elements["storycode10"].checked=true;
            }
            f.elements["storycode10"].disabled=!disable;
            f.elements["storycode11"].disabled=!disable;
            f.elements["expire_month"].disabled=!disable;
            f.elements["expire_day"].disabled=!disable;
            f.elements["expire_year"].disabled=!disable;
            f.elements["expire_hour"].disabled=!disable;
            f.elements["expire_minute"].disabled=!disable;
            f.elements["expire_ampm"].disabled=!disable;
        }
            
            function enablecmtclose(obj) {
            var f = obj.form;           // all elements have their parent form in "form"
            var disable = obj.checked;  // Disable when checked
        
            f.elements["cmt_close_month"].disabled=!disable;
            f.elements["cmt_close_day"].disabled=!disable;
            f.elements["cmt_close_year"].disabled=!disable;
            f.elements["cmt_close_hour"].disabled=!disable;
            f.elements["cmt_close_minute"].disabled=!disable;
            f.elements["cmt_close_ampm"].disabled=!disable;
            
        }
        //]]>
        </script>' . LB;
    } else {
        $js = '<script type="text/javascript">
            // Setup editor path for FCKeditor JS Functions
            geeklogEditorBasePath = "' . $_CONF['site_url'] . '/fckeditor/";
        </script>' . LB;

        $js .= '<!-- Hide the Advanced Editor as Javascript is required. If JS is enabled then the JS below will un-hide it -->
        <script type="text/javascript">
            document.getElementById("advanced_editor").style.display=""
        </script>';     
        
        $_SCRIPTS->setJavaScriptFile('advanced_editor', '/javascript/advanced_editor.js');
        $_SCRIPTS->setJavaScriptFile('storyeditor_fckeditor', '/javascript/storyeditor_fckeditor.js');        
    }
    
    $js .= '<script type="text/javascript">
    <!-- This code will only be executed by a browser that supports Javascript -->
    var jstest = ' . $js_showarchivedisabled . ';
    var jstest2 = ' . $js_showcmtclosedisabled . ';
    if (jstest) {
        document.frmstory.expire_month.disabled=true;
        document.frmstory.expire_day.disabled=true;
        document.frmstory.expire_year.disabled=true;
        document.frmstory.expire_hour.disabled=true;
        document.frmstory.expire_minute.disabled=true;
        document.frmstory.expire_ampm.disabled=true;
        document.frmstory.storycode10.disabled=true;
        document.frmstory.storycode11.disabled=true;
    }
    if (jstest2) {
        document.frmstory.cmt_close_month.disabled=true;
        document.frmstory.cmt_close_day.disabled=true;
        document.frmstory.cmt_close_year.disabled=true;
        document.frmstory.cmt_close_hour.disabled=true;
        document.frmstory.cmt_close_minute.disabled=true;
        document.frmstory.cmt_close_ampm.disabled=true;
    }
    </script>';    
    
    $_SCRIPTS->setJavaScript($js);
    
    // *****************************************
    
    $story_templates->set_var('saved_images', $saved_images);
    $story_templates->set_var('image_form_elements', $fileinputs);
    $story_templates->set_var('lang_hits', $LANG24[18]);
    $story_templates->set_var('story_hits', $story->EditElements('hits'));
    $story_templates->set_var('lang_comments', $LANG24[19]);
    $story_templates->set_var('story_comments', $story->EditElements('comments'));
    $story_templates->set_var('lang_trackbacks', $LANG24[29]);
    $story_templates->set_var('story_trackbacks', $story->EditElements('trackbacks'));
    $story_templates->set_var('lang_emails', $LANG24[39]);
    $story_templates->set_var('story_emails', $story->EditElements('numemails'));
    if ($mode == 'clone') {
        $story_templates->set_var('story_id', COM_makesid());
    } else {
        $story_templates->set_var('story_id', $story->getSid());
        $story_templates->set_var('old_story_id', $story->EditElements('originalSid'));
    }
    $story_templates->set_var('lang_sid', $LANG24[12]);
    $story_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $story_templates->set_var('lang_preview', $LANG_ADMIN['preview']);
    $story_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $story_templates->set_var('lang_delete', $LANG_ADMIN['delete']);
    $story_templates->set_var('gltoken_name', CSRF_TOKEN);
    $token = SEC_createToken();
    $story_templates->set_var('gltoken', $token);
    $story_templates->parse('output','editor');

    $display .= COM_startBlock($LANG24[5], '',
                        COM_getBlockTemplate('_admin_block', 'header'));
    $display .= SEC_getTokenExpiryNotice($token, $LANG24[91]);

    $display .= $story_templates->finish($story_templates->get_var('output'));
    $display .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $display;
}

/**
* Saves story to database
*
* @param    string      $type           story submission or (new) story
* @param    string      $sid            ID of story to save
* @param    int         $uid            ID of user that wrote the story
* @param    string      $tid            Topic ID story belongs to
* @param    string      $title          Title of story
* @param    string      $page_title     Title of the page
* @param    string      $introtext      Introduction text
* @param    string      $bodytext       Text of body
* @param    int         $hits           Number of times story has been viewed
* @param    string      $unixdate       Date story was originally saved
* @param    int         $featured       Flag on whether or not this is a featured article
* @param    string      $commentcode    Indicates if comments are allowed to be made to article
* @param    string      $trackbackcode  Indicates if trackbacks are allowed to be made to article
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
function submitstory($type='')
{
    $output = '';

    $args = &$_POST;

    // Handle Magic GPC Garbage:
    while (list($key, $value) = each($args)) {
        if (!is_array($value)) {
            $args[$key] = COM_stripslashes($value);
        } else {
            while (list($subkey, $subvalue) = each($value)) {
                $value[$subkey] = COM_stripslashes($subvalue);
            }
        }
    }

    /* ANY FURTHER PROCESSING on POST variables - COM_stripslashes etc.
     * Do it HERE on $args */

    PLG_invokeService('story', 'submit', $args, $output, $svc_msg);
    echo $output;
}

// MAIN
$mode = '';
if (isset($_REQUEST['mode'])){
    $mode = COM_applyFilter ($_REQUEST['mode']);
}

if (isset($_REQUEST['editopt'])){
    $editopt = COM_applyFilter ($_REQUEST['editopt']);
    if ($editopt == 'default') {
        $_CONF['advanced_editor'] = false;
    }
}

$display = '';
if (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) {
    $sid = COM_applyFilter ($_POST['sid']);
    $type = '';
    if (isset ($_POST['type'])) {
        $type = COM_applyFilter ($_POST['type']);
    }
    if (!isset ($sid) || empty ($sid)) {
        COM_errorLog ('Attempted to delete story sid=' . $sid);
        echo COM_refresh ($_CONF['site_admin_url'] . '/story.php');
    } else if ($type == 'submission') {
        $tid = DB_getItem ($_TABLES['storysubmission'], 'tid', "sid = '$sid'");
        if (SEC_hasTopicAccess ($tid) < 3) {
            COM_accessLog ("User {$_USER['username']} tried to illegally delete story submission $sid.");
            echo COM_refresh ($_CONF['site_admin_url'] . '/index.php');
        } else if (SEC_checkToken()) {
            DB_delete ($_TABLES['storysubmission'], 'sid', $sid,
                       $_CONF['site_admin_url'] . '/moderation.php');
        } else {
            COM_accessLog ("User {$_USER['username']} tried to illegally delete story submission $sid and failed CSRF checks.");
            echo COM_refresh ($_CONF['site_admin_url'] . '/index.php');
        }
    } else if (SEC_checkToken()) {
        echo STORY_deleteStory ($sid);
    } else {
        COM_accessLog ("User {$_USER['username']} tried to delete story and failed CSRF checks $sid.");
        echo COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    }
} else if (($mode == $LANG_ADMIN['preview']) && !empty ($LANG_ADMIN['preview'])) {
    $display .= COM_siteHeader('menu', $LANG24[5]);
    $display .= storyeditor(COM_applyFilter($_POST['sid']), 'preview', '', '');
    $display .= COM_siteFooter();
    COM_output($display);
} elseif (($mode == 'edit') || ($mode == 'clone')) {
    $display .= COM_siteHeader('menu', $LANG24[5]);
    $sid = '';
    if (isset ($_GET['sid'])) {
        $sid = COM_applyFilter ($_GET['sid']);
    }
    $topic = '';
    if (isset ($_GET['topic'])) {
        $topic = COM_applyFilter ($_GET['topic']);
    }
    $display .= storyeditor($sid, $mode, '', $topic);
    $display .= COM_siteFooter();
    COM_output($display);
} else if ($mode == 'editsubmission') {
    $display .= COM_siteHeader('menu', $LANG24[5]);
    $display .= storyeditor (COM_applyFilter ($_GET['id']), $mode);
    $display .= COM_siteFooter();
    COM_output($display);
} else if (($mode == $LANG_ADMIN['save']) && !empty ($LANG_ADMIN['save']) && SEC_checkToken()) {
    submitstory ();
} else { // 'cancel' or no mode at all
    $type = '';
    if (isset($_POST['type'])) {
        $type = COM_applyFilter($_POST['type']);
    }
    if (($mode == $LANG24[10]) && !empty($LANG24[10]) &&
            ($type == 'submission')) {
        $display = COM_refresh($_CONF['site_admin_url'] . '/moderation.php');
    } else {
        $current_topic = '';
        if (empty($mode)) {
            if (!empty ($_GET['tid'])) {
                $current_topic = COM_applyFilter($_GET['tid']);
            } elseif (!empty ($_POST['tid'])) {
                $current_topic = COM_applyFilter($_POST['tid']);
            }
        }
        $display .= COM_siteHeader('menu', $LANG24[22]);
        $display .= COM_showMessageFromParameter();
        $display .= liststories($current_topic);
        $display .= COM_siteFooter();
    }
    COM_output($display);
}

?>
