<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | topic.php                                                                 |
// |                                                                           |
// | Geeklog topic administration page.                                        |
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
* Topic administration page: Create, edit, delete topics.
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

$display = '';

if (!SEC_hasRights('topic.edit')) {
    $display .= COM_siteHeader('menu', $MESSAGE[30])
             . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
             . COM_siteFooter();
    COM_accessLog("User {$_USER['username']} tried to illegally access the topic administration screen.");
    COM_output($display);
    exit;
}

// Uncomment the line below if you need to debug the HTTP variables being passed
// to the script.  This will sometimes cause errors but it will allow you to see
// the data being passed in a POST operation
// echo COM_debug($_POST);

/**
* Show topic administration form
*
* @param    string  tid     ID of topic to edit
* @return   string          HTML for the topic editor
*
*/
function edittopic ($tid = '')
{
    global $_CONF, $_GROUPS, $_TABLES, $_USER, $LANG04, $LANG27, $LANG_ACCESS,
           $LANG_ADMIN, $MESSAGE;

    $retval = '';

    if (empty($tid)) {
        // new topic - set defaults
        $A = array();
        $A['tid'] = '';
        $A['topic'] = '';
        $A['sortnum'] = 0;
        $A['limitnews'] = ''; // leave empty!
        $A['is_default'] = 0;
        $A['archive_flag'] = 0;
    } else {
        $result = DB_query("SELECT * FROM {$_TABLES['topics']} WHERE tid ='$tid'");
        $A = DB_fetchArray($result);
        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);
        if ($access == 0 OR $access == 2) {
            $retval .= COM_showMessageText($LANG27[13], $LANG27[12]);
            COM_accessLog("User {$_USER['username']} tried to illegally create or edit topic $tid.");
            return $retval;
        }
    }

    $token = SEC_createToken();

    $retval .= COM_startBlock ($LANG27[1], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
    $retval .= SEC_getTokenExpiryNotice($token);
    if (!is_array ($A) || empty ($A['owner_id'])) {
        $A['owner_id'] = $_USER['uid'];

        // this is the one instance where we default the group
        // most topics should belong to the Topic Admin group
        if (isset ($_GROUPS['Topic Admin'])) {
            $A['group_id'] = $_GROUPS['Topic Admin'];
        } else {
            $A['group_id'] = SEC_getFeatureGroup ('topic.edit');
        }
        SEC_setDefaultPermissions ($A, $_CONF['default_permissions_topic']);
        $access = 3;
    }
    $topic_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/topic');
    $topic_templates->set_file('editor','topiceditor.thtml');
    if (!empty($tid) && SEC_hasRights('topic.edit')) {
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s' . XHTML . '>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $topic_templates->set_var('delete_option',
                                  sprintf($delbutton, $jsconfirm));
        $topic_templates->set_var('delete_option_no_confirmation',
                                  sprintf($delbutton, ''));
        $topic_templates->set_var('warning_msg', $LANG27[6]);
    }
    $topic_templates->set_var('lang_topicid', $LANG27[2]);
    $topic_templates->set_var('topic_id', $A['tid']);
    $topic_templates->set_var('lang_donotusespaces', $LANG27[5]);
    $topic_templates->set_var('lang_accessrights',$LANG_ACCESS['accessrights']);
    $topic_templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $ownername = COM_getDisplayName ($A['owner_id']);
    $topic_templates->set_var('owner_username', DB_getItem ($_TABLES['users'],
                              'username', "uid = {$A['owner_id']}"));
    $topic_templates->set_var('owner_name', $ownername);
    $topic_templates->set_var('owner', $ownername);
    $topic_templates->set_var('owner_id', $A['owner_id']);
    $topic_templates->set_var('lang_group', $LANG_ACCESS['group']);
    $topic_templates->set_var('lang_save', $LANG_ADMIN['save']);
    $topic_templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $topic_templates->set_var('group_dropdown',
                              SEC_getGroupDropdown ($A['group_id'], $access));
    $topic_templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $topic_templates->set_var('lang_permissions_key', $LANG_ACCESS['permissionskey']);
    $topic_templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $topic_templates->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
    $topic_templates->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);
    $topic_templates->set_var('permissions_editor', SEC_getPermissionsHTML($A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']));

    // show sort order only if they specified sortnum as the sort method
    if ($_CONF['sortmethod'] <> 'alpha') {
        $topic_templates->set_var('lang_sortorder', $LANG27[10]);
        if ($A['sortnum'] == 0) {
            $A['sortnum'] = '';
        }
        $topic_templates->set_var('sort_order', '<input type="text" size="3" maxlength="3" name="sortnum" value="' . $A['sortnum'] . '"' . XHTML . '>');
    } else {
        $topic_templates->set_var('lang_sortorder', $LANG27[14]);
        $topic_templates->set_var('sort_order', $LANG27[15]);
    }
    $topic_templates->set_var('lang_storiesperpage', $LANG27[11]);
    if ($A['limitnews'] == 0) {
        $topic_templates->set_var('story_limit', '');
    } else {
        $topic_templates->set_var('story_limit', $A['limitnews']);
    }
    $topic_templates->set_var('default_limit', $_CONF['limitnews']);
    $topic_templates->set_var('lang_defaultis', $LANG27[16]);
    $topic_templates->set_var('lang_topicname', $LANG27[3]);
    $topic_templates->set_var('topic_name', stripslashes ($A['topic']));
    if (empty($A['tid'])) {
        $A['imageurl'] = '/images/topics/';
    }
    $topic_templates->set_var('lang_topicimage', $LANG27[4]);
    $topic_templates->set_var('lang_uploadimage', $LANG27[27]);
    $topic_templates->set_var('lang_maxsize', $LANG27[28]);
    $topic_templates->set_var('icon_dimensions',
        $_CONF['max_topicicon_width'] . ' x ' . $_CONF['max_topicicon_height']);
    $topic_templates->set_var('max_url_length', 255);
    $topic_templates->set_var('image_url', $A['imageurl']);

    if (empty($_CONF['image_lib'])) {
        $scaling = $LANG04[162];
    } else {
        $scaling = $LANG04[161];
    }
    $topic_templates->set_var('icon_max_dimensions',
        sprintf($LANG04[160], $_CONF['max_topicicon_width'],
                              $_CONF['max_topicicon_height'],
                              $_CONF['max_topicicon_size'], $scaling));

    $topic_templates->set_var('lang_metadescription',
                              $LANG_ADMIN['meta_description']);
    $topic_templates->set_var('lang_metakeywords',
                              $LANG_ADMIN['meta_keywords']);
    if (! empty($A['meta_description'])) {
        $topic_templates->set_var('meta_description', $A['meta_description']);
    }
    if (! empty($A['meta_keywords'])) {
        $topic_templates->set_var('meta_keywords', $A['meta_keywords']);
    }
    if ($_CONF['meta_tags'] > 0) {
        $topic_templates->set_var('hide_meta', '');
    } else {
        $topic_templates->set_var('hide_meta', ' style="display:none;"');
    }

    $topic_templates->set_var ('lang_defaulttopic', $LANG27[22]);
    $topic_templates->set_var ('lang_defaulttext', $LANG27[23]);
    if ($A['is_default'] == 1) {
        $topic_templates->set_var ('default_checked', 'checked="checked"');
    } else {
        $topic_templates->set_var ('default_checked', '');
    }

    $topic_templates->set_var ('lang_archivetopic', $LANG27[25]);
    $topic_templates->set_var ('lang_archivetext', $LANG27[26]);
    $topic_templates->set_var ('archive_disabled', '');
    if ($A['archive_flag'] == 1) {
        $topic_templates->set_var ('archive_checked', 'checked="checked"');
    } else {
        $topic_templates->set_var ('archive_checked', '');
        // Only 1 topic can be the archive topic - so check if there already is one
        if (DB_count($_TABLES['topics'], 'archive_flag', '1') > 0) {
            $topic_templates->set_var ('archive_disabled', 'disabled');
        }
    }

    if (empty($tid)) {
        $num_stories = $LANG_ADMIN['na'];
    } else {
        $nresult = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE tid = '" . addslashes($tid) . "'" . COM_getPermSql('AND'));
        $N = DB_fetchArray( $nresult );
        $num_stories = COM_numberFormat($N['count']);
    }

    $topic_templates->set_var('lang_num_stories', $LANG27[30]);
    $topic_templates->set_var('num_stories', $num_stories);
    $topic_templates->set_var('gltoken_name', CSRF_TOKEN);
    $topic_templates->set_var('gltoken', $token);
    $topic_templates->parse('output', 'editor');
    $retval .= $topic_templates->finish($topic_templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Change a topic's ID in various places
*
* @param    string  $tid        new Topic ID
* @parem    string  $old_tid    current Topic ID
* @return   void
*
*/
function changetopicid($tid, $old_tid)
{
    global $_TABLES;

    DB_change($_TABLES['blocks'], 'tid', $tid, 'tid', $old_tid);
    DB_change($_TABLES['stories'], 'tid', $tid, 'tid', $old_tid);
    DB_change($_TABLES['storysubmission'], 'tid', $tid, 'tid', $old_tid);
    DB_change($_TABLES['syndication'], 'header_tid', $tid,
                                       'header_tid', $old_tid);

    $result = DB_query("SELECT uid,tids,etids FROM {$_TABLES['userindex']} WHERE tids LIKE '%{$old_tid}%' OR etids LIKE '%{$old_tid}%'");
    $num_users = DB_numRows($result);
    for ($i = 0; $i < $num_users; $i++) {
        $changed = false;
        list($uid, $tids, $etids) = DB_fetchArray($result);
        // check list of excluded topics
        $t = explode(' ', $tids);
        if (count($t) > 0) {
            $found = array_search($old_tid, $t);
            if ($found !== false) {
                $t[$found] = $tid;
                $tids = implode(' ', $t);
                $changed = true;
            }
        }

        // check topics for the Daily Digest
        if (! empty($etids) && ($etids != '-')) {
            $e = explode(' ', $etids);
            if (count($e) > 0) {
                $found = array_search($old_tid, $e);
                if ($found !== false) {
                    $e[$found] = $tid;
                    $etids = implode(' ', $e);
                    $changed = true;
                }
            }
        }

        if ($changed) {
            // etids can be both NULL and "", so special handling required
            if ($etids === null) {
                DB_change($_TABLES['userindex'], 'tids', $tids, 'uid', $uid);
            } else {
                DB_query("UPDATE {$_TABLES['userindex']} SET tids = '{$tids}', etids = '{$etids}' WHERE uid = $uid");
            }
        }
    }
}

/**
* Save topic to the database
*
* @param    string  $tid            Topic ID
* @param    string  $topic          Name of topic (what the user sees)
* @param    string  $imageurl       (partial) URL to topic image
* @param    string  $meta_description    Topic meta description
* @param    string  $meta_keywords       Topic meta keywords
* @param    int     $sortnum        number for sort order in "Topics" block
* @param    int     $limitnews      number of stories per page for this topic
* @param    int     $owner_id       ID of owner
* @param    int     $group_id       ID of group topic belongs to
* @param    int     $perm_owner     Permissions the owner has
* @param    int     $perm_group     Permissions the group has
* @param    int     $perm_member    Permissions members have
* @param    int     $perm_anon      Permissions anonymous users have
* @param    string  $is_default     'on' if this is the default topic
* @param    string  $is_archive     'on' if this is the archive topic
* @return   string                  HTML redirect or error message
*/
function savetopic($tid,$topic,$imageurl,$meta_description,$meta_keywords,$sortnum,$limitnews,$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon,$is_default,$is_archive)
{
    global $_CONF, $_TABLES, $LANG27, $MESSAGE;

    $retval = '';

    // Convert array values to numeric permission values
    list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);

    $tid = COM_sanitizeID($tid);

    $access = 0;
    if (DB_count ($_TABLES['topics'], 'tid', $tid) > 0) {
        $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['topics']} WHERE tid = '{$tid}'");
        $A = DB_fetchArray ($result);
        $access = SEC_hasAccess ($A['owner_id'], $A['group_id'],
                $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                $A['perm_anon']);
    } else {
        $access = SEC_hasAccess ($owner_id, $group_id, $perm_owner, $perm_group,
                $perm_members, $perm_anon);
    }
    if (($access < 3) || !SEC_inGroup($group_id)) {
        $retval .= COM_siteHeader('menu', $MESSAGE[30])
                . COM_showMessageText($MESSAGE[29], $MESSAGE[30])
                . COM_siteFooter();
        COM_accessLog("User {$_USER['username']} tried to illegally create or edit topic $tid.");
    } elseif (!empty($tid) && !empty($topic)) {
        if ($imageurl == '/images/topics/') {
            $imageurl = '';
        }
        $topic = addslashes($topic);
        $meta_description = addslashes(strip_tags($meta_description));
        $meta_keywords = addslashes(strip_tags($meta_keywords));

        if ($is_default == 'on') {
            $is_default = 1;
            DB_query ("UPDATE {$_TABLES['topics']} SET is_default = 0 WHERE is_default = 1");
        } else {
            $is_default = 0;
        }

        $is_archive = ($is_archive == 'on') ? 1 : 0;

        $archivetid = DB_getItem ($_TABLES['topics'], 'tid', "archive_flag=1");
        if ($is_archive) {
            // $tid is the archive topic
            // - if it wasn't already, mark all its stories "archived" now
            if ($archivetid != $tid) {
                DB_query ("UPDATE {$_TABLES['stories']} SET featured = 0, frontpage = 0, statuscode = " . STORY_ARCHIVE_ON_EXPIRE . " WHERE tid = '$tid'");
                DB_query ("UPDATE {$_TABLES['topics']} SET archive_flag = 0 WHERE archive_flag = 1");
            }
        } else {
            // $tid is not the archive topic
            // - if it was until now, reset the "archived" status of its stories
            if ($archivetid == $tid) {
                DB_query ("UPDATE {$_TABLES['stories']} SET statuscode = 0 WHERE tid = '$tid'");
                DB_query ("UPDATE {$_TABLES['topics']} SET archive_flag = 0 WHERE archive_flag = 1");
            }
        }
	
        if (isset($_POST['old_tid'])) {
            $old_tid = COM_applyFilter($_POST['old_tid']);
            if (! empty($old_tid)) {
                $old_tid = COM_sanitizeID($old_tid);
                changetopicid($tid, $old_tid);

                $old_tid = addslashes($old_tid);
                DB_delete($_TABLES['topics'], 'tid', $old_tid);
            }
        }

        DB_save($_TABLES['topics'],'tid, topic, imageurl, meta_description, meta_keywords, sortnum, limitnews, is_default, archive_flag, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon',"'$tid', '$topic', '$imageurl', '$meta_description', '$meta_keywords','$sortnum','$limitnews',$is_default,'$is_archive',$owner_id,$group_id,$perm_owner,$perm_group,$perm_members,$perm_anon");

        if ($old_tid != $tid) {
            PLG_itemSaved($tid, 'topic', $old_tid);
        } else {
            PLG_itemSaved($tid, 'topic');
        }
        // update feed(s) and Older Stories block
        COM_rdfUpToDateCheck('article', $tid);
        COM_olderStuff();

        $retval = COM_refresh ($_CONF['site_admin_url'] . '/topic.php?msg=13');
    } else {
        $retval .= COM_siteHeader('menu', $LANG27[1]);
        $retval .= COM_errorLog($LANG27[7], 2);
        $retval .= COM_siteFooter();
    }

    return $retval;
}

/**
* Displays a list of topics
*
* Lists all the topics and their icons.
*
* @return   string      HTML for the topic list
*
*/
function listtopics()
{
    global $_CONF, $_TABLES, $LANG27, $LANG_ACCESS, $LANG_ADMIN;

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

    $retval = '';

    $retval .= COM_startBlock ($LANG27[8], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $topic_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/topic');
    $topic_templates->set_file(array('list'=>'topiclist.thtml', 'item'=>'listitem.thtml'));
    $topic_templates->set_var('lang_newtopic', $LANG_ADMIN['create_new']);
    $topic_templates->set_var('lang_adminhome', $LANG27[18]);
    $topic_templates->set_var('lang_instructions', $LANG27[9]);
    $topic_templates->set_var('begin_row', '<tr align="center" valign="bottom">');

    $result = DB_query("SELECT * FROM {$_TABLES['topics']}");
    $nrows = DB_numRows($result);
    $counter = 1;

    $menu_arr = array (
        array('url' => $_CONF['site_admin_url'] . '/topic.php?mode=edit',
              'text' => $LANG_ADMIN['create_new']),
        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']));
    $menu = ADMIN_createMenu(
        $menu_arr,
        $LANG27[9],
        $_CONF['layout_url'] . "/images/icons/topic.png"
    );
    $topic_templates->set_var('top_menu', $menu);

    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray($result);

        $access = SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']);

        if ($access > 0) {
            if ($access == 3) {
                $access = $LANG_ACCESS['edit'];
            } else {
                $access = $LANG_ACCESS['readonly'];
            }

            $topic_templates->set_var('topic_id', $A['tid']);
            $topic_templates->set_var('topic_name', stripslashes ($A['topic']));
            $topic_templates->set_var('topic_access', $access);
            if ($A['is_default'] == 1) {
                $topic_templates->set_var ('default_topic', $LANG27[24]);
            } else {
                $topic_templates->set_var ('default_topic', '');
            }
            if (empty ($A['imageurl'])) {
                $topic_templates->set_var ('image_tag', '');
            } else {
                $imageurl = COM_getTopicImageUrl ($A['imageurl']);
                $topic_templates->set_var ('image_tag', '<img src="' . $imageurl
                                           . '" alt=""' . XHTML . '>');
            }
            if ($counter == 5) {
                $counter = 1;
                $topic_templates->set_var('end_row','</tr>');
                $topic_templates->parse('list_row','item',true);
                $topic_templates->set_var('begin_row','<tr align="center" valign="bottom">');
            } else {
                if ($i == $nrows - 1) {
                    $topic_templates->set_var('end_row','</tr>');
                } else {
                    $topic_templates->set_var('end_row','');
                }

                $topic_templates->parse('list_row','item',true);
                $topic_templates->set_var('begin_row','');
                $counter = $counter + 1;
            }
        }
    }
    $topic_templates->parse('output', 'list');
    $retval .= $topic_templates->finish($topic_templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Delete a topic
*
* @param    string  $tid    Topic ID
* @return   string          HTML redirect
*
*/
function deleteTopic ($tid)
{
    global $_CONF, $_TABLES, $_USER;

    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['topics']} WHERE tid ='$tid'");
    $A = DB_fetchArray ($result);
    $access = SEC_hasAccess ($A['owner_id'], $A['group_id'], $A['perm_owner'],
            $A['perm_group'], $A['perm_members'], $A['perm_anon']);
    if ($access < 3) {
        COM_accessLog ("User {$_USER['username']} tried to illegally delete topic $tid.");
        return COM_refresh ($_CONF['site_admin_url'] . '/topic.php');
    }

    // don't delete topic blocks - assign them to 'all' and disable them
    DB_query ("UPDATE {$_TABLES['blocks']} SET tid = 'all', is_enabled = 0 WHERE tid = '$tid'");

    // same with feeds
    DB_query ("UPDATE {$_TABLES['syndication']} SET topic = '::all', is_enabled = 0 WHERE topic = '$tid'");

    // delete comments, trackbacks, images associated with stories in this topic
    $result = DB_query ("SELECT sid FROM {$_TABLES['stories']} WHERE tid = '$tid'");
    $numStories = DB_numRows($result);
    for ($i = 0; $i < $numStories; $i++) {
        $A = DB_fetchArray($result);
        STORY_deleteImages($A['sid']);
        DB_delete($_TABLES['comments'], array('sid', 'type'),
                                        array($A['sid'], 'article'));
        DB_delete($_TABLES['trackback'], array('sid', 'type'),
                                         array($A['sid'], 'article'));
    }

    // delete these
    DB_delete($_TABLES['stories'], 'tid', $tid);
    DB_delete($_TABLES['storysubmission'], 'tid', $tid);
    DB_delete($_TABLES['topics'], 'tid', $tid);

    // update feed(s) and Older Stories block
    COM_rdfUpToDateCheck('article');
    COM_olderStuff();

    return COM_refresh ($_CONF['site_admin_url'] . '/topic.php?msg=14');
}

/**
* Upload new topic icon, replaces previous icon if one exists
*
* @param    string  tid     ID of topic to prepend to filename
* @return   string          filename of new photo (empty = no new photo)
*
*/
function handleIconUpload($tid)
{
    global $_CONF, $_TABLES, $LANG27;

    require_once ($_CONF['path_system'] . 'classes/upload.class.php');

    $upload = new upload();
    if (!empty ($_CONF['image_lib'])) {
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
        $upload->setAutomaticResize (true);
        if (isset ($_CONF['debug_image_upload']) &&
                $_CONF['debug_image_upload']) {
            $upload->setLogFile ($_CONF['path'] . 'logs/error.log');
            $upload->setDebug (true);
        }
        if (isset($_CONF['jpeg_quality'])) {
            $upload->setJpegQuality($_CONF['jpeg_quality']);
        }
    }
    $upload->setAllowedMimeTypes (array ('image/gif'   => '.gif',
                                         'image/jpeg'  => '.jpg,.jpeg',
                                         'image/pjpeg' => '.jpg,.jpeg',
                                         'image/x-png' => '.png',
                                         'image/png'   => '.png'
                                 )      );
    if (!$upload->setPath ($_CONF['path_images'] . 'topics')) {
        $display = COM_siteHeader('menu', $LANG27[29])
                 . COM_showMessageText($upload->printErrors(false), $LANG27[29])
                 . COM_siteFooter();
        COM_output($display);
        exit; // don't return
    }

    $filename = '';

    // see if user wants to upload a (new) icon
    $newicon = $_FILES['newicon'];
    if (!empty ($newicon['name'])) {
        $pos = strrpos ($newicon['name'], '.') + 1;
        $fextension = substr ($newicon['name'], $pos);
        $filename = 'topic_' . $tid . '.' . $fextension;
    }

    // do the upload
    if (!empty ($filename)) {
        $upload->setFileNames ($filename);
        $upload->setPerms ('0644');
        if (($_CONF['max_topicicon_width'] > 0) &&
            ($_CONF['max_topicicon_height'] > 0)) {
            $upload->setMaxDimensions ($_CONF['max_topicicon_width'],
                                       $_CONF['max_topicicon_height']);
        } else {
            $upload->setMaxDimensions ($_CONF['max_image_width'],
                                       $_CONF['max_image_height']);
        }
        if ($_CONF['max_topicicon_size'] > 0) {
            $upload->setMaxFileSize($_CONF['max_topicicon_size']);
        } else {
            $upload->setMaxFileSize($_CONF['max_image_size']);
        }
        $upload->uploadFiles ();

        if ($upload->areErrors ()) {
            $display = COM_siteHeader('menu', $LANG27[29])
                     . COM_showMessageText($upload->printErrors(false),
                                           $LANG27[29])
                     . COM_siteFooter();
            COM_output($display);
            exit; // don't return
        }
        if (strpos($_CONF['path_images'], $_CONF['path_html']) === 0) {
            $filename = substr($_CONF['path_images'],
                               strlen($_CONF['path_html']) - 1)
                      . 'topics/' . $filename;
        } else {
            /**
            * Not really used when the 'path_images' is outside of the webroot.
            * Let's at least extract the name of the images directory then.
            */
            $images = 'images';
            $parts = explode('/', $_CONF['path_images']);
            if (count($parts) > 1) {
                $cnt = count($parts);
                // e.g. from /path/to/myimages/ would extract "myimages"
                if (empty($parts[$cnt - 1]) && !empty($parts[$cnt - 2])) {
                    $images = $parts[$cnt - 2];
                }
                $filename = '/' . $images . '/topics/' . $filename;
            }
        }
    }

    return $filename;
}


// MAIN
$display = '';

$mode = '';
if (isset ($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

if (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) {
    $tid = COM_applyFilter ($_POST['tid']);
    if (!isset ($tid) || empty ($tid)) {
        COM_errorLog ('Attempted to delete topic tid=' . $tid);
        $display .= COM_refresh ($_CONF['site_admin_url'] . '/topic.php');
    } elseif (SEC_checkToken()) {
        $display .= deleteTopic($tid);
    } else {
        COM_accessLog("User {$_USER['username']} tried to illegally delete topic $tid and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
    }
} elseif (($mode == $LANG_ADMIN['save']) && !empty($LANG_ADMIN['save']) && SEC_checkToken()) {

    if (empty ($_FILES['newicon']['name'])){
        $imageurl = COM_applyFilter ($_POST['imageurl']);
    } else {
        $imageurl = handleIconUpload($_POST['tid']);
        $imageurl = COM_applyFilter ($imageurl);
    }
    $is_default = '';
    if (isset($_POST['is_default'])) {
        $is_default = $_POST['is_default'];
    }
    $is_archive = '';
    if (isset($_POST['is_archive'])) {
        $is_archive = $_POST['is_archive'];
    }
    $sortnum = 0;
    if (isset($_POST['sortnum'])) {
        $sortnum = COM_applyFilter($_POST['sortnum'], true);
    }
    $display .= savetopic(COM_applyFilter($_POST['tid']), $_POST['topic'],
                          $imageurl, $_POST['meta_description'],
                          $_POST['meta_keywords'], $sortnum,
                          COM_applyFilter($_POST['limitnews'], true),
                          COM_applyFilter($_POST['owner_id'], true),
                          COM_applyFilter($_POST['group_id'], true),
                          $_POST['perm_owner'], $_POST['perm_group'],
                          $_POST['perm_members'], $_POST['perm_anon'],
                          $is_default, $is_archive);
} elseif ($mode == 'edit') {
    $display .= COM_siteHeader('menu', $LANG27[1]);
    $tid = '';
    if (isset($_GET['tid'])) {
        $tid = COM_applyFilter($_GET['tid']);
    }
    $display .= edittopic($tid);
    $display .= COM_siteFooter();
} else { // 'cancel' or no mode at all
    $display .= COM_siteHeader('menu', $LANG27[8]);
    $display .= COM_showMessageFromParameter();
    $display .= listtopics();
    $display .= COM_siteFooter();
}

COM_output($display);

?>
