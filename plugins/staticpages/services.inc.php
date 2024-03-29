<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.7                                                   |
// +---------------------------------------------------------------------------+
// | services.inc.php                                                          |
// |                                                                           |
// | This file implements the services provided by the 'Static Pages' plugin.  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Tom Willett      - twillett AT users DOT sourceforge DOT net     |
// |          Blaine Lang      - langmail AT sympatico DOT ca                  |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
// |          Ramnath R Iyer   - rri AT silentyak DOT com                      |
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
 * Functions related to the webservices and the internal plugin API
 *
 * @package StaticPages
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

/**
 * Max. length of the ID for a static page.
 * This must be kept in sync with the actual size of 'sp_id' in the db.
 */
define('STATICPAGE_MAX_ID_LENGTH', 128);

/**
 * Submit static page. The page is updated if it exists, or a new one is created
 *
 * @param   array  $args    Contains all the data provided by the client
 * @param   string $output  OUTPUT parameter containing the returned text
 * @param   array  $svc_msg OUTPUT parameter containing any service messages
 * @return  int             Response code as defined in lib-plugins.php
 */
function service_submit_staticpages($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $_USER, $LANG_ACCESS, $LANG01, $LANG12, $LANG_STATIC,
           $_GROUPS, $_SP_CONF, $_STRUCT_DATA, $LANG_structureddatatypes;

    if (!$_CONF['disable_webservices']) {
        require_once $_CONF['path_system'] . 'lib-webservices.php';
    }

    $output = '';

    if (!SEC_hasRights('staticpages.edit')) {
        $output .= COM_showMessageText($LANG_STATIC['access_denied_msg'], $LANG_STATIC['access_denied']);
        $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG_STATIC['access_denied']));

        return PLG_RET_AUTH_FAILED;
    }

    if (COM_isDemoMode()) {
        $output .= COM_showMessageText($LANG_ACCESS['demo_mode_denied_msg'], $LANG_ACCESS['accessdenied']);
        $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG_ACCESS['accessdenied']));

        return PLG_RET_AUTH_FAILED;
    }

    $gl_edit = false;
    if (isset($args['gl_edit'])) {
        $gl_edit = $args['gl_edit'];
    }
    if ($gl_edit) {
        // This is EDIT mode, so there should be an sp_old_id
        if (empty($args['sp_old_id'])) {
            if (!empty($args['id'])) {
                $args['sp_old_id'] = $args['id'];
            } else {
                return PLG_RET_ERROR;
            }

            if (empty($args['sp_id'])) {
                $args['sp_id'] = $args['sp_old_id'];
            }
        }
    } else {
        if (empty($args['sp_id']) && !empty($args['id'])) {
            $args['sp_id'] = $args['id'];
        }
    }

    if (empty($args['sp_title']) && !empty($args['title'])) {
        $args['sp_title'] = $args['title'];
    }

    if (empty($args['sp_content']) && !empty($args['content'])) {
        $args['sp_content'] = $args['content'];
    }

    if (!isset($args['owner_id'])) {
        $args['owner_id'] = $_USER['uid'];
    }

    if (empty($args['group_id'])) {
        $args['group_id'] = SEC_getFeatureGroup('staticpages.edit', $_USER['uid']);
    }

    $args['sp_id'] = COM_sanitizeID($args['sp_id'], true, true);
    if (!$gl_edit) {
        if (strlen($args['sp_id']) > STATICPAGE_MAX_ID_LENGTH) {
            $slug = '';
            if (isset($args['slug'])) {
                $slug = $args['slug'];
            }
            if (function_exists('WS_makeId')) {
                $args['sp_id'] = WS_makeId($slug, STATICPAGE_MAX_ID_LENGTH);
            } else {
                $args['sp_id'] = COM_makeSid(true);
            }
        }
    }

    // Apply filters to the parameters passed by the webservice
    if ($args['gl_svc']) {
        $par_str = array(
            'mode', 'sp_id', 'sp_old_id', 'sp_format', 'postmode',
        );
        $par_num = array(
            'sp_hits', 'owner_id', 'group_id', 'sp_where', 'sp_php', 'commentcode', 'structured_data_type',
        );

        foreach ($par_str as $str) {
            if (isset($args[$str])) {
                $args[$str] = COM_applyBasicFilter($args[$str]);
            } else {
                $args[$str] = '';
            }
        }

        foreach ($par_num as $num) {
            if (isset($args[$num])) {
                $args[$num] = COM_applyBasicFilter($args[$num], true);
            } else {
                $args[$num] = 0;
            }
        }
    }

    // START: Staticpages defaults
    if (empty($args['sp_format'])) {
        $args['sp_format'] = 'allblocks';
    }

    if (($args['sp_where'] < 0) || ($args['sp_where'] > 3)) {
        $args['sp_where'] = 0;
    }

    if (($args['sp_php'] < 0) || ($args['sp_php'] > 2)) {
        $args['sp_php'] = 0;
    }

    if (($args['commentcode'] < -1) || ($args['commentcode'] > 1)) {
        $args['commentcode'] = $_SP_CONF['comment_code'];
    }

    if (($args['search'] < 0) || ($args['search'] > 2)) {
        $args['search'] = 1; // Default setting
    }
	
    if (($args['likes'] < -1) || ($args['likes'] > 2)) {
        $args['likes'] = -1; // Default setting
    }	

    // Only Core Structured Data Types supported
    if (!isset($LANG_structureddatatypes[$args['structured_data_type']])) {
		if ($_SP_CONF['structured_data_type_default'] != 'none') {
			$args['structured_data_type'] = $_SP_CONF['structured_data_type_default'];
		} else {
			// If default 'none' then store as a empty string in db
			$args['structured_data_type'] = '';
		}
	} elseif ($args['structured_data_type'] == 'none') {
		// If select passes 'none' then store as a empty string in db
		$args['structured_data_type'] = '';
	}

    // This will never be set by the page editor
    if (!isset($args['page_data'])) {
        $args['page_data'] = '';
    }

    if ($args['gl_svc']) {
        // Permissions
        if (!isset($args['perm_owner'])) {
            $args['perm_owner'] = $_SP_CONF['default_permissions'][0];
        } else {
            $args['perm_owner'] = COM_applyBasicFilter($args['perm_owner'], true);
        }
        if (!isset($args['perm_group'])) {
            $args['perm_group'] = $_SP_CONF['default_permissions'][1];
        } else {
            $args['perm_group'] = COM_applyBasicFilter($args['perm_group'], true);
        }
        if (!isset($args['perm_members'])) {
            $args['perm_members'] = $_SP_CONF['default_permissions'][2];
        } else {
            $args['perm_members'] = COM_applyBasicFilter($args['perm_members'], true);
        }
        if (!isset($args['perm_anon'])) {
            $args['perm_anon'] = $_SP_CONF['default_permissions'][3];
        } else {
            $args['perm_anon'] = COM_applyBasicFilter($args['perm_anon'], true);
        }

        if (!isset($args['sp_onmenu'])) {
            $args['sp_onmenu'] = '';
        } elseif (($args['sp_onmenu'] == 'on') && empty($args['sp_label'])) {
            $svc_msg['error_desc'] = 'Menu label missing';

            return PLG_RET_ERROR;
        }

        if (empty($args['sp_content'])) {
            $svc_msg['error_desc'] = 'No content';

            return PLG_RET_ERROR;
        }

        if (!TOPIC_checkTopicSelectionControl()) {
            $svc_msg['error_desc'] = 'No topic selected.';

            return PLG_RET_ERROR;
        }

        if (!TOPIC_hasMultiTopicAccess('topic') < 3) {
            $svc_msg['error_desc'] = 'Do not have access to one or more of selected topics.';

            return PLG_RET_ERROR;
        }

        if (empty($args['sp_inblock']) && ($_SP_CONF['in_block'] == '1')) {
            $args['sp_inblock'] = 'on';
        }

        if (empty($args['sp_centerblock'])) {
            $args['sp_centerblock'] = '';
        }

        if (empty($args['draft_flag']) && ($_SP_CONF['draft_flag'] == '1')) {
            $args['draft_flag'] = 'on';
        }

        if (empty($args['cache_time'])) {
            $args['cache_time'] = $_SP_CONF['default_cache_time'];;
        }

        if (empty($args['template_flag'])) {
            $args['template_flag'] = '';
        }

        if (empty($args['template_id'])) {
            $args['template_id'] = '';
        }

        if (empty($args['sp_prev'])) {
            $args['sp_prev'] = '';
        }

        if (empty($args['sp_next'])) {
            $args['sp_next'] = '';
        }

        if (empty($args['sp_parent'])) {
            $args['sp_parent'] = '';
        }
    }
    // END: Staticpages defaults

    $sp_id = $args['sp_id'];
    $sp_title = $args['sp_title'];
    $sp_page_title = $args['sp_page_title'];
    $sp_content = $args['sp_content'];
    $sp_hits = $args['sp_hits'];
    $sp_format = $args['sp_format'];
    $sp_onmenu = $args['sp_onmenu'];
    $sp_onhits = $args['sp_onhits'];
    $sp_onlastupdate = $args['sp_onlastupdate'];
    $sp_label = '';
    if (!empty($args['sp_label'])) {
        $sp_label = $args['sp_label'];
    } else {
        // If empty but menu on then use title as default
        if ($sp_onmenu == 'on') {
            $sp_label = $sp_title;
        }
    }
    $meta_description = $args['meta_description'];
    $meta_keywords = $args['meta_keywords'];
    $commentcode = $args['commentcode'];
    $structured_data_type = $args['structured_data_type'];
    $owner_id = $args['owner_id'];
    $group_id = $args['group_id'];
    $perm_owner = $args['perm_owner'];
    $perm_group = $args['perm_group'];
    $perm_members = $args['perm_members'];
    $perm_anon = $args['perm_anon'];
    $sp_php = $args['sp_php'];
    $sp_nf = '';
    if (!empty($args['sp_nf'])) {
        $sp_nf = $args['sp_nf'];
    }
    $sp_old_id = $args['sp_old_id'];
    $sp_centerblock = $args['sp_centerblock'];
    $draft_flag = $args['draft_flag'];
    $search = $args['search'];
	$likes = $args['likes'];
    $cache_time = $args['cache_time'];
    $template_flag = $args['template_flag'];
    $template_id = $args['template_id'];
    $page_data = $args['page_data'];
    $sp_help = '';
    if (!empty($args['sp_help'])) {
        $sp_help = $args['sp_help'];
    }
    $sp_where = $args['sp_where'];
    $sp_inblock = $args['sp_inblock'];
    $postmode = $args['postmode'];
    $sp_prev = $args['sp_prev'];
    $sp_next = $args['sp_next'];
    $sp_parent = $args['sp_parent'];

    if ($gl_edit && !empty($args['gl_etag'])) {
        // First load the original staticpage to check if it has been modified
        $o = array();
        $s = array();
        $r = service_get_staticpages(array('sp_id' => $sp_old_id, 'gl_svc' => true), $o, $s);

        if ($r == PLG_RET_OK) {
            if ($args['gl_etag'] != $o['updated']) {
                $svc_msg['error_desc'] = 'A more recent version of the staticpage is available';

                return PLG_RET_PRECONDITION_FAILED;
            }
        } else {
            $svc_msg['error_desc'] = 'The requested staticpage no longer exists';

            return PLG_RET_ERROR;
        }
    }

    if ($template_id != '') {
        // Since this page uses a template it is xml full of template variables
        // Lets make sure it is formatted correctly
        // Suppress warnings on loading xml document so we can fail gracefully if need be
        libxml_use_internal_errors(true);
        // Load xml staticpage document
        $xmlObject = simplexml_load_string($sp_content);
        if ($xmlObject === false) {
            // Error happened when try to load data so xml not setup correctly
            $output .= COM_showMessageText($LANG_STATIC['template_xml_error'], $LANG_STATIC['title_error_saving']);
            if (!$args['gl_svc']) {
                $output .= staticpageeditor($sp_id);
            }
            $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG_STATIC['staticpageeditor']));

            $svc_msg['error_desc'] = 'The staticpage xml is not formatted correctly for template variables';

            return PLG_RET_ERROR;
        }
    }

    // Check PHP Parsing if enabled and correct PHP version
    if ($_SP_CONF['enable_eval_php_save'] && $_SP_CONF['allow_php'] == 1 && SEC_hasRights('staticpages.PHP') && $sp_php != 0) {
        if (version_compare(PHP_VERSION, '7.0.0', '>=')) {
            // Use $sp_content instead of $page_data since the switch has not been made yet.
            $retarray = COM_handleEval($sp_content, $sp_php);

            if (!$retarray['success']) {
                // Error happened when try to load data so xml not setup correctly
                $output .= COM_showMessageText(sprintf($LANG01['parse_php_error'], $retarray['error']), $LANG_STATIC['title_error_saving']);
                if (!$args['gl_svc']) {
                    $output .= staticpageeditor($sp_id);
                }
                $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG_STATIC['staticpageeditor']));

                $svc_msg['error_desc'] = 'The PHP in the staticpage has parsing errors';

                return PLG_RET_ERROR;
            }
        }
    }

    // Check for unique page ID
    $duplicate_id = false;
    $delete_old_page = false;
    if (DB_count($_TABLES['staticpage'], 'sp_id', $sp_id) > 0) {
        if ($sp_id != $sp_old_id) {
            $duplicate_id = true;
        }
    } elseif (!empty($sp_old_id)) {
        if ($sp_id != $sp_old_id) {
            $delete_old_page = true;
        }
    }

    if ($duplicate_id) {
        $output .= COM_showMessageText($LANG_STATIC['duplicate_id'], $LANG_STATIC['title_error_saving']);
        if (!$args['gl_svc']) {
            $output .= staticpageeditor($sp_id);
        }
        $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG_STATIC['staticpageeditor']));
        $svc_msg['error_desc'] = 'Duplicate ID';

        return PLG_RET_ERROR;
    } elseif (!empty($sp_title) && !empty($sp_content) && TOPIC_checkTopicSelectionControl() && TOPIC_hasMultiTopicAccess('topic') == 3) {
        if (empty($sp_hits)) {
            $sp_hits = 0;
        }

        if ($sp_onmenu == 'on') {
            $sp_onmenu = 1;
        } else {
            $sp_onmenu = 0;
        }
        if ($sp_onhits == 'on') {
            $sp_onhits = 1;
        } else {
            $sp_onhits = 0;
        }
        if ($sp_onlastupdate == 'on') {
            $sp_onlastupdate = 1;
        } else {
            $sp_onlastupdate = 0;
        }
        if ($sp_nf == 'on') {
            $sp_nf = 1;
        } else {
            $sp_nf = 0;
        }
        if ($sp_centerblock == 'on') {
            $sp_centerblock = 1;
        } else {
            $sp_centerblock = 0;
        }
        if ($sp_inblock == 'on') {
            $sp_inblock = 1;
        } else {
            $sp_inblock = 0;
        }
        if ($draft_flag == 'on') {
            $draft_flag = 1;
        } else {
            $draft_flag = 0;
        }
        if ($template_flag == 'on') {
            $template_flag = 1;
        } else {
            $template_flag = 0;
        }

        // Check if previous page, next page and parent page exist respective;y
        $sp_prev = COM_sanitizeID($sp_prev, false);
        if (($sp_prev !== '') && !staticPageIdExists($sp_prev)) {
            $sp_prev = '';
        }

        $sp_next = COM_sanitizeID($sp_next, false);
        if (($sp_next !== '') && !staticPageIdExists($sp_next)) {
            $sp_next = '';
        }

        $sp_parent = COM_sanitizeID($sp_parent, false);
        if (($sp_parent !== '') && !staticPageIdExists($sp_parent)) {
            $sp_parent = '';
        }

        // Remove any autotags the user doesn't have permission to use
        $sp_content = PLG_replaceTags($sp_content, '', true);
        // Clean up the text
        if ($_SP_CONF['censor'] == 1) {
            $sp_content = COM_checkWords($sp_content);
            $sp_title = COM_checkWords($sp_title);
        }
        if ($_SP_CONF['filter_html'] == 1) {
            $sp_content = COM_checkHTML($sp_content, 'staticpages.edit');
        }
        $sp_content = GLText::remove4byteUtf8Chars($sp_content);

        $sp_title = GLText::stripTags($sp_title);
        $sp_title = GLText::remove4byteUtf8Chars($sp_title);
        $sp_page_title = GLText::stripTags($sp_page_title);
        $sp_page_title = GLText::remove4byteUtf8Chars($sp_page_title);
        $sp_label = GLText::stripTags($sp_label);
        $sp_label = GLText::remove4byteUtf8Chars($sp_label);

        $meta_description = GLText::stripTags($meta_description);
        $meta_description = GLText::remove4byteUtf8Chars($meta_description);
        $meta_keywords = GLText::stripTags($meta_keywords);
        $meta_keywords = GLText::remove4byteUtf8Chars($meta_keywords);
        $sp_help = GLText::remove4byteUtf8Chars($sp_help);

        $sp_content = DB_escapeString($sp_content);
        $sp_title = DB_escapeString($sp_title);
        $sp_page_title = DB_escapeString($sp_page_title);
        $sp_label = DB_escapeString($sp_label);
        $meta_description = DB_escapeString($meta_description);
        $meta_keywords = DB_escapeString($meta_keywords);
        $sp_help = DB_escapeString($sp_help);
        $sp_prev = DB_escapeString($sp_prev);
        $sp_next = DB_escapeString($sp_next);
        $sp_parent = DB_escapeString($sp_parent);

        // If user does not have php edit perms, then set php flag to 0.
        if (($_SP_CONF['allow_php'] != 1) || !SEC_hasRights('staticpages.PHP')) {
            $sp_php = 0;
        }

        if ($cache_time < -1) {
            $cache_time = $_SP_CONF['default_cache_time'];
        }

        // If marked as a template then set id to nothing and other default settings
        $page_data = '';
        if ($template_flag == 1) {
            $template_id = '';

            $sp_onmenu = 0;
            $sp_onhits = 0;
            $sp_onlastupdate = 0;
            $sp_label = "";
            $sp_centerblock = 0;
            $sp_php = 0;
            $cache_time = 0;
            $sp_inblock = 0;
            $sp_nf = 0;

            $sp_hits = 0;
            $meta_description = "";
            $meta_keywords = "";
            $structured_data_type = "";
            $search = 0; // Disabled but shouldn't happen anyways
			$likes = 0; // Disabled but shouldn't happen anyways

            // Switch sp_content to page_data since template
            $page_data = $sp_content;
            $sp_content = ''; // Nothing needed here since not searched
        } else {
            // See if it was a template before, if so and option changed, remove use from other pages
            if (DB_getItem($_TABLES['staticpage'], 'template_flag', "sp_id = '$sp_old_id'") == 1) {
                $sql = "UPDATE {$_TABLES['staticpage']} SET template_id = '' WHERE template_id = '$sp_old_id'";
                $result = DB_query($sql);
            }

            if ($template_id != '') {
                // If using a template, make sure php disabled
                $sp_php = 0;

                // Double check template id exists and is still a template
                $perms = SP_getPerms();
                if (!empty($perms)) {
                    $perms = ' AND ' . $perms;
                }
                if (DB_getItem($_TABLES['staticpage'], 'COUNT(sp_id)', ("sp_id = '$template_id' AND template_flag = 1 AND (draft_flag = 0)" . $perms)) == 0) {
                    $template_id = '';
                } else {
                    // Switch sp_content to page_data
                    $page_data = $sp_content;
                    $sp_content = ''; // After save this will be updated to include cached copy of page for search
                }
            }
        }

        if ($sp_php) {
            // Switch sp_content to page_data
            $page_data = $sp_content;
            $sp_content = ''; // After save this will be updated to include cached copy of page for search
        }

        // make sure there's only one "entire page" static page per topic
        if (($sp_centerblock == 1) && ($sp_where == 0)) {
            // Retrieve Topic data
            TOPIC_getDataTopicSelectionControl($topic_option, $tids, $inherit_tids, $default_tid);

            $sql = "UPDATE {$_TABLES['staticpage']},{$_TABLES['topic_assignments']} ta SET sp_centerblock = 0
                WHERE (sp_centerblock = 1) AND (sp_where = 0) AND (draft_flag = 0)
                 AND ta.type = 'staticpages' AND ta.id = sp_id ";

            if ($topic_option == TOPIC_ALL_OPTION || $topic_option == TOPIC_HOMEONLY_OPTION) {
                $sql .= " AND (ta.tid = '$topic_option')";
            } else {
                $sql .= " AND (ta.tid IN ('" . implode("','", $tids) . "'))";
            }

            // if we're in a multi-language setup, we need to allow one "entire
            // page" centerblock for 'all' or 'none' per language
            if ((!empty($_CONF['languages']) && !empty($_CONF['language_files'])) && (($topic_option == TOPIC_ALL_OPTION || $topic_option == TOPIC_HOMEONLY_OPTION))) {
                $ids = explode('_', $sp_id);
                if (count($ids) > 1) {
                    $lang_id = array_pop($ids);

                    $sql .= " AND ta.tid LIKE '%\\_$lang_id'";
                }
            }

            DB_query($sql);
        }

        $formats = array('allblocks', 'blankpage', 'leftblocks', 'noblocks');
        if (!in_array($sp_format, $formats)) {
            $sp_format = 'allblocks';
        }

        if (!$args['gl_svc']) {
            list($perm_owner, $perm_group, $perm_members, $perm_anon) = SEC_getPermissionValues($perm_owner, $perm_group, $perm_members, $perm_anon);
        }

        // Retrieve created date
        $dateCreated = DB_getItem($_TABLES['staticpage'], 'created', "sp_id = '$sp_id'");
        if ($dateCreated == '') {
            $dateCreated = date('Y-m-d H:i:s');
        }

        DB_save($_TABLES['staticpage'], 'sp_id,sp_title,sp_page_title, sp_content,created,modified,sp_hits,sp_format,sp_onmenu,sp_onhits,sp_onlastupdate,sp_label,commentcode,structured_data_type,meta_description,meta_keywords,template_flag,template_id,page_data,draft_flag,search,likes,cache_time'
        . ',owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon,sp_php,sp_nf,sp_centerblock,sp_help,sp_where,sp_inblock,postmode,sp_prev,sp_next,sp_parent',
            "'$sp_id','$sp_title','$sp_page_title','$sp_content','$dateCreated',NOW(),$sp_hits,'$sp_format',$sp_onmenu,$sp_onhits,$sp_onlastupdate,'$sp_label','$commentcode','$structured_data_type','$meta_description','$meta_keywords',$template_flag,'$template_id','$page_data',$draft_flag,$search,$likes,$cache_time,$owner_id,$group_id,"
            . "$perm_owner,$perm_group,$perm_members,$perm_anon,'$sp_php','$sp_nf',$sp_centerblock,'$sp_help',$sp_where,"
            . "'$sp_inblock','$postmode', '{$sp_prev}', '{$sp_next}', '{$sp_parent}'");
        TOPIC_saveTopicSelectionControl('staticpages', $sp_id);

        if ($delete_old_page && !empty($sp_old_id)) {
            // If a template and the id changed, update any staticpages that use it
            if ($template_flag == 1) {
                $sql = "UPDATE {$_TABLES['staticpage']} SET template_id = '$sp_id' WHERE template_id = '$sp_old_id'";
                $result = DB_query($sql);
            }

            // Delete Topic Assignments for this old staticpage since we just created new ones
            TOPIC_deleteTopicAssignments('staticpages', $sp_old_id);

            DB_delete($_TABLES['staticpage'], 'sp_id', $sp_old_id);
        }

        if (empty($sp_old_id) || ($sp_id == $sp_old_id)) {
            if (!$template_flag) {
                PLG_itemSaved($sp_id, 'staticpages');

                // Clear Cache
                $cacheInstance = 'staticpage__' . $sp_id . '__';
                CACHE_remove_instance($cacheInstance);
                $_STRUCT_DATA->clear_cachedScript('staticpages', $sp_id);
            } else {
                // If template then have to notify of all pages that use this template that a change to the page happened
                $sql = "SELECT sp_id FROM {$_TABLES['staticpage']} WHERE template_id = '{$sp_id}'";
                $result = DB_query($sql);
                while ($A = DB_fetchArray($result)) {
                    PLG_itemSaved($A['sp_id'], 'staticpages');

                    // Clear Cache
                    $cacheInstance = 'staticpage__' . $A['sp_id'] . '__';
                    CACHE_remove_instance($cacheInstance);
                    $_STRUCT_DATA->clear_cachedScript('staticpages', $A['sp_id']);
                }
            }
        } else {
            DB_change($_TABLES['comments'], 'sid', DB_escapeString($sp_id),
                array('sid', 'type'),
                array(DB_escapeString($sp_old_id), 'staticpages'));
            if (!$template_flag) {
                PLG_itemSaved($sp_id, 'staticpages', $sp_old_id);

                // Clear Cache
                $cacheInstance = 'staticpage__' . $sp_old_id . '__';
                CACHE_remove_instance($cacheInstance);
                $_STRUCT_DATA->clear_cachedScript('staticpages', $sp_old_id);
            } else {
                // If template then have to notify of all pages that use this template that a change to the page happened
                $sql = "SELECT sp_id FROM {$_TABLES['staticpage']} WHERE template_id = '{$sp_id}'";
                $result = DB_query($sql);
                while ($A = DB_fetchArray($result)) {
                    PLG_itemSaved($A['sp_id'], 'staticpages');

                    // Clear Cache
                    $cacheInstance = 'staticpage__' . $A['sp_id'] . '__';
                    CACHE_remove_instance($cacheInstance);
                    $_STRUCT_DATA->clear_cachedScript('staticpages', $A['sp_id']);
                }
            }
        }

        // If uses a template or PHP then save cache copy in DB used for search (needs to be done after save)
        // Currently generating page view based on current user. Should really be saving at lowest viewable user permission but currently not possible
        // Only if search not excluded
        if (!$draft_flag AND $search > 0) {
            if ($template_id != '' OR $sp_php > 0) {
                // Return whatever an autotag would return and cache it in content column
                $search_sp_content = SP_returnStaticpage($sp_id, 'autotag');
                $search_sp_content = DB_escapeString($search_sp_content);
                $sql = "UPDATE {$_TABLES['staticpage']} SET sp_content = '$search_sp_content' WHERE sp_id = '$sp_id'";
                $result = DB_query($sql);
            } elseif ($template_flag) {
                // This is a template that has possible changed so now must reset search cache for all pages that use this template
                // If template then have to notify of all pages that use this template that a change to the page happened
                $sql = "SELECT sp_id FROM {$_TABLES['staticpage']} WHERE template_id = '{$sp_id}'";
                $result = DB_query($sql);
                while ($A = DB_fetchArray($result)) {
                    $search_sp_content = SP_returnStaticpage($A['sp_id'], 'autotag');
                    $search_sp_content = DB_escapeString($search_sp_content);
                    $sql = "UPDATE {$_TABLES['staticpage']} SET sp_content = '$search_sp_content' WHERE sp_id = '{$A['sp_id']}'";
                    $resultB = DB_query($sql);
                }
            }
        }

        $url = COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page=' . $sp_id);
        $output .= PLG_afterSaveSwitch($_SP_CONF['aftersave'], $url, 'staticpages', 19);
        $svc_msg['id'] = $sp_id;

        return PLG_RET_OK;
    } else {
        $output .= COM_showMessageText($LANG_STATIC['no_title_or_content'], $LANG_STATIC['title_error_saving']);
        if (!$args['gl_svc']) {
            $output .= staticpageeditor($sp_id);
        }
        $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG_STATIC['staticpageeditor']));

        return PLG_RET_ERROR;
    }
}

/**
 * Delete an existing static page
 *
 * @param   array   $args      Contains all the data provided by the client
 * @param   string  &$output   OUTPUT parameter containing the returned text
 * @param   string  &$svc_msg  OUTPUT parameter containing any service messages
 * @return  int                Response code as defined in lib-plugins.php
 */
function service_delete_staticpages($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $_USER, $LANG_ACCESS, $LANG12, $LANG_STATIC, $_STRUCT_DATA;

    $output = COM_refresh($_CONF['site_admin_url']
        . '/plugins/staticpages/index.php?msg=20');

    if (empty($args['sp_id']) && !empty($args['id']))
        $args['sp_id'] = $args['id'];

    // Apply filters to the parameters passed by the webservice

    if ($args['gl_svc']) {
        $args['sp_id'] = COM_applyBasicFilter($args['sp_id']);
        $args['mode'] = COM_applyBasicFilter($args['mode']);
    }

    $sp_id = $args['sp_id'];

    if (!SEC_hasRights('staticpages.delete')) {
        $output = COM_showMessageText($LANG_STATIC['access_denied_msg'], $LANG_STATIC['access_denied']);
        $output = COM_createHTMLDocument($output, array('pagetitle' => $LANG_STATIC['access_denied']));
        if ($_USER['uid'] > 1) {
            return PLG_RET_PERMISSION_DENIED;
        } else {
            return PLG_RET_AUTH_FAILED;
        }
    }

    /*
    // If a staticpage template, remove any use of the file
    if (DB_getItem($_TABLES['staticpage'], 'template_flag', "sp_id = '$sp_id'") == 1) {
        $sql = "UPDATE {$_TABLES['staticpage']} SET template_id = '' WHERE template_id = '$sp_id'";
        $result = DB_query($sql);
    }
    */
    // If a staticpage template and being used by another page cancel
    if (DB_getItem($_TABLES['staticpage'], 'template_flag', "sp_id = '$sp_id'") == 1) {
        if (DB_COUNT($_TABLES['staticpage'], 'template_id', "$sp_id") > 0) {
            $output = COM_refresh($_CONF['site_admin_url'] . '/plugins/staticpages/index.php?msg=22');
            return PLG_RET_PERMISSION_DENIED;
        }
    }

    // Remove deleted page from previous, next, or parent of other pages
    DB_query("UPDATE {$_TABLES['staticpage']} SET sp_prev = '' WHERE sp_prev = '$sp_id'");
    DB_query("UPDATE {$_TABLES['staticpage']} SET sp_next = '' WHERE sp_next = '$sp_id'");
    DB_query("UPDATE {$_TABLES['staticpage']} SET sp_parent = '' WHERE sp_parent = '$sp_id'");

    // Delete page
    DB_delete($_TABLES['staticpage'], 'sp_id', $sp_id);
	
	CMT_deleteComment('', $sp_id, STATICPAGES_PLUGIN_NAME, false);

    TOPIC_deleteTopicAssignments('staticpages', $sp_id);

    PLG_itemDeleted($sp_id, 'staticpages');

    // Clear Cache
    $cacheInstance = 'staticpage__' . $sp_id . '__';
    CACHE_remove_instance($cacheInstance);
    $_STRUCT_DATA->clear_cachedScript('staticpages', $sp_id);

    return PLG_RET_OK;
}

/**
 * Get an existing static page
 *
 * @param   array   $args      Contains all the data provided by the client
 * @param   string  &$output   OUTPUT parameter containing the returned text
 * @param   string  &$svc_msg  OUTPUT parameter containing any service messages
 * @return  int                Response code as defined in lib-plugins.php
 */
function service_get_staticpages($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $LANG_ACCESS, $LANG12, $LANG_STATIC, $_SP_CONF, $_USER;

    $output = '';

    $svc_msg['output_fields'] = array(
        'sp_hits',
        'sp_onhits',
        'sp_onlastupdate',
        'sp_format',
        'draft_flag',
        'search',
		'likes',
        'cache_time',
        'owner_id',
        'group_id',
        'perm_owner',
        'perm_group',
        'perm_members',
        'perm_anon',
        'sp_help',
        'sp_php',
        'sp_inblock',
        'commentcode',
        'structured_data_type',
        'sp_prev',
        'sp_next',
        'sp_parent',
    );

    if (empty($args['sp_id']) && !empty($args['id'])) {
        $args['sp_id'] = $args['id'];
    }

    if ($args['gl_svc']) {
        if (isset($args['sp_id'])) {
            $args['sp_id'] = COM_applyBasicFilter($args['sp_id']);
        }
        if (isset($args['mode'])) {
            $args['mode'] = COM_applyBasicFilter($args['mode']);
        }

        if (empty($args['sp_id'])) {
            $svc_msg['gl_feed'] = true;
        } else {
            $svc_msg['gl_feed'] = false;
        }
    } else {
        $svc_msg['gl_feed'] = false;
    }

    if (!$svc_msg['gl_feed']) {
        $page = '';
        if (isset($args['sp_id'])) {
            $page = $args['sp_id'];
        }
        $mode = '';
        if (isset($args['mode'])) {
            $mode = $args['mode'];
        }

        $error = 0;

        if ($page == '') {
            $error = 1;
        }
        $perms = SP_getPerms();
        if (!SEC_hasRights('staticpages.edit')) {
            if (!empty($perms)) {
                $perms .= ' AND';
            }
            $perms .= '(draft_flag = 0)';
        }
        if (!empty($perms)) {
            $perms = ' AND ' . $perms;
        }

        // Topic Permissions
        $topic_perms = COM_getTopicSQL('', 0, 'ta');
        if ($topic_perms != '') {
            $topic_perms = " AND (" . $topic_perms . "";

            if (COM_onFrontpage()) {
                $topic_perms .= " OR (ta.tid = '" . TOPIC_HOMEONLY_OPTION . "' OR ta.tid = '" . TOPIC_ALL_OPTION . "'))";
            } else {
                // $topic_perms .= " OR ta.tid = '" . TOPIC_ALL_OPTION . "')";
                $topic_perms .= " OR (ta.tid = '" . TOPIC_HOMEONLY_OPTION . "' OR ta.tid = '" . TOPIC_ALL_OPTION . "'))";
            }
        }
        $topic_perms .= " GROUP BY sp_id, sp_title, sp_page_title, sp_content, sp_onhits, sp_onlastupdate, sp_hits, "
            . "created, modified, sp_format, commentcode, structured_data_type, meta_description, meta_keywords, template_flag, template_id, page_data, "
            . "draft_flag, search, likes, owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon, sp_help, sp_php, "
            . "sp_inblock, cache_time, sp_prev, sp_next, sp_parent";

        $sql = <<<SQL
SELECT sp_id, sp_title, sp_page_title, sp_content, sp_onhits, sp_onlastupdate, sp_hits, created, modified, sp_format,
        commentcode, structured_data_type, meta_description, meta_keywords, template_flag, template_id, page_data, draft_flag, search, likes, 
        owner_id, group_id, perm_owner, perm_group, perm_members, perm_anon,
        sp_help, sp_php, sp_inblock, cache_time, sp_prev, sp_next, sp_parent
  FROM {$_TABLES['staticpage']}, {$_TABLES['topic_assignments']} ta
  WHERE (sp_id = '{$page}') {$perms} AND (ta.type = 'staticpages') AND (ta.id = sp_id) {$topic_perms}
SQL;
        $result = DB_query($sql);
        $count = DB_numRows($result);

        if ($count == 0 || $count > 1) {
            $error = 1;
        }

        if (!($error)) {
            $output = DB_fetchArray($result, false);
            $page = $output['sp_id']; // reset page id so case mimics id perfectly since this affects the cache file and canonical link

            // WE ASSUME $output doesn't have any confidential fields
            // Generate output now (only if not grabbing a template since template is combined with variables first and then generated)
            if (!isset($args['template'])) {
                $output['sp_content'] = SP_render_content($output);
            }
        } else { // an error occurred (page not found, access denied, ...)
			if (empty($page)) {
				$failflg = 0;
			} else {
				$failflg = DB_getItem($_TABLES['staticpage'], 'sp_nf', "sp_id = '$page'");
			}
			if ($failflg) {
				$output .= SEC_loginRequiredForm();
				if ($mode !== 'autotag') {
					// Is user already logged in
					if (COM_isAnonUser()) {
						// Okay anonymous user ask to login
						// Retrieve required info to display login page
						$sql = "SELECT sp_title, sp_page_title, sp_format FROM {$_TABLES['staticpage']} WHERE sp_id = '$page'";
						$resultA = DB_query($sql);
						$A = DB_fetchArray($resultA);

						if ($A['sp_format'] === 'allblocks' || $A['sp_format'] === 'leftblocks') {
							$what = 'menu';
						} else {
							$what = 'none';
						}

						$page_title = stripslashes($A['sp_page_title']);
						if (empty($page_title)) {
							$page_title = stripslashes($A['sp_title']);
						}

						if (($A['sp_format'] == 'allblocks')) {
							$rightblock = true;
						} elseif (($A['sp_format'] == 'leftblocks') || ($A['sp_format'] == 'noblocks')) {
							$rightblock = false;
						} else {
							$rightblock = -1;
						}

						$output = COM_createHTMLDocument($output, array('what' => $what, 'pagetitle' => $page_title, 'rightblock' => $rightblock));
					} else {
						// then he has no access and let him know
						$output = COM_showMessageText($LANG_STATIC['deny_msg'], $LANG_STATIC['access_denied']);
						$output = COM_createHTMLDocument($output, array('pagetitle' => $LANG_STATIC['access_denied']));
					}
				}
			} else {
				if ($mode !== 'autotag') {
					COM_handle404();
				}
			}

            return PLG_RET_ERROR;
        }

        if ($args['gl_svc']) {
            // This date format is PHP 5 only,
            // but only the web-service uses the value
            $output['published'] = date('c', strtotime($output['created']));
            $output['updated'] = date('c', strtotime($output['modified']));
            $output['id'] = $page;
            $output['title'] = $output['sp_title'];
            $output['page_title'] = $output['sp_page_title'];
            $output['category'] = TOPIC_getTopicIdsForObject('staticpages', $page);
            $output['content'] = $output['sp_content'];
            $output['content_type'] = 'html';

            $owner_data = SESS_getUserDataFromId($output['owner_id']);
            $output['author_name'] = $owner_data['username'];
            $output['link_edit'] = $page;
        }
    } else {
        $output = array();

        $mode = '';
        if (isset($args['mode'])) {
            $mode = $args['mode'];
        }

        $perms = SP_getPerms();
        if (!empty($perms)) {
            $perms = ' WHERE ' . $perms;
        }

        $offset = 0;
        if (isset($args['offset'])) {
            $offset = COM_applyBasicFilter($args['offset'], true);
        }
        $max_items = $_SP_CONF['atom_max_items'] + 1;

        $limit = " LIMIT $offset, $max_items";
        $order = " ORDER BY modified DESC";
        $sql = array();
        $sql['mysql'] = "SELECT sp_id,sp_title,sp_page_title,sp_content,sp_hits,created,modified,sp_format,meta_description,meta_keywords,template_flag,template_id,page_data,draft_flag,search,likes,owner_id,"
            . "group_id,perm_owner,perm_group,perm_members,perm_anon,sp_help,sp_php,sp_inblock,cache_time,structured_data_type "
            . " FROM {$_TABLES['staticpage']}" . $perms . $order . $limit;
        $sql['pgsql'] = "SELECT sp_id,sp_title,sp_page_title,sp_content,sp_hits,created,modified,sp_format,meta_description,meta_keywords,template_flag,template_id,page_data,draft_flag,search,likes,owner_id,"
            . "group_id,perm_owner,perm_group,perm_members,perm_anon,sp_help,sp_php,sp_inblock,cache_time,structured_data_type "
            . "FROM {$_TABLES['staticpage']}" . $perms . $order . $limit;
        $result = DB_query($sql);

        $count = 0;
        while (($output_item = DB_fetchArray($result, false)) !== false) {
            // WE ASSUME $output doesn't have any confidential fields

            $count++;
            if ($count == $max_items) {
                $svc_msg['offset'] = $offset + $_SP_CONF['atom_max_items'];
                break;
            }

            if ($args['gl_svc']) {
                // This date format is PHP 5 only, but only the web-service uses the value
                $output_item['published'] = date('c', strtotime($output_item['created']));
                $output_item['updated'] = date('c', strtotime($output_item['modified']));
                $output_item['id'] = $output_item['sp_id'];
                $output_item['title'] = $output_item['sp_title'];
                $output_item['page_title'] = $output_item['sp_page_title'];
                $output_item['category'] = TOPIC_getTopicIdsForObject('staticpages', $output_item['sp_id']);
                $output['content'] = SP_render_content($output);
                $output_item['content_type'] = 'html';

                $owner_data = SESS_getUserDataFromId($output_item['owner_id']);

                $output_item['author_name'] = $owner_data['username'];
            }
            $output[] = $output_item;
        }
    }

    return PLG_RET_OK;
}

/**
 * Get all the topics available
 *
 * @param   array  $args     Contains all the data provided by the client
 * @param   string &$output  OUTPUT parameter containing the returned text
 * @param   string &$svc_msg
 * @return  int              Response code as defined in lib-plugins.php
 */
function service_getTopicList_staticpages($args, &$output, &$svc_msg)
{
    $output = COM_topicArray('tid');
    $output[] = 'all';
    $output[] = 'none';

    return PLG_RET_OK;
}
