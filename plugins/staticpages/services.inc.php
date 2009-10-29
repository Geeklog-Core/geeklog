<?php

// Reminder: always indent with 4 spaces (no tabs). 
// +---------------------------------------------------------------------------+
// | Static Pages Plugin 1.6                                                   |
// +---------------------------------------------------------------------------+
// | services.inc.php                                                          |
// |                                                                           |
// | This file implements the services provided by the 'Static Pages' plugin.  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'services.inc.php') !== false) {
    die('This file can not be used on its own.');
}

/**
* Max. length of the ID for a static page.
* This must be kept in sync with the actual size of 'sp_id' in the db.
*/
define('STATICPAGE_MAX_ID_LENGTH', 40);

/**
 * Submit static page. The page is updated if it exists, or a new one is created
 *
 * @param   array   args     Contains all the data provided by the client
 * @param   string  &output  OUTPUT parameter containing the returned text
 * @param   string  &svc_msg OUTPUT parameter containing any service messages
 * @return  int		     Response code as defined in lib-plugins.php
 */
function service_submit_staticpages($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $_USER, $LANG_ACCESS, $LANG12, $LANG_STATIC,
           $LANG_LOGIN, $_GROUPS, $_SP_CONF;

    if (version_compare(PHP_VERSION, '5.0.0', '>=') &&
            (! $_CONF['disable_webservices'])) {
        require_once $_CONF['path_system'] . '/lib-webservices.php';
    }

    $output = '';

    if (!SEC_hasRights('staticpages.edit')) {
        $output = COM_siteHeader('menu', $LANG_STATIC['access_denied']);
        $output .= COM_startBlock($LANG_STATIC['access_denied'], '',
                                  COM_getBlockTemplate('_msg_block', 'header'));
        $output .= $LANG_STATIC['access_denied_msg'];
        $output .= COM_endBlock(COM_getBlockTemplate('_msg_block', 'footer'));
        $output .= COM_siteFooter();

        return PLG_RET_AUTH_FAILED;
    }

    // TEST CODE
    /*
    foreach ($args as $k => $v) {
        if (!is_array($v)) {
            echo "$k => $v\r\n";
        } else {
            echo "$k => $v\r\n";
            foreach ($v as $k1 => $v1) {
                echo "        $k1 => $v1\r\n";
            }
        }
    }
    exit ();
    */
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

    if (!isset($args['sp_uid'])) {
        $args['sp_uid'] = $_USER['uid'];
    }

    if (empty($args['sp_title']) && !empty($args['title'])) {
        $args['sp_title'] = $args['title'];
    }

    if (empty($args['sp_content']) && !empty($args['content'])) {
        $args['sp_content'] = $args['content'];
    }

    if (isset($args['category']) && is_array($args['category']) &&
            !empty($args['category'][0])) {
        $args['sp_tid'] = $args['category'][0];
    }

    if (!isset($args['owner_id'])) {
        $args['owner_id'] = $_USER['uid'];
    }

    if (empty($args['group_id'])) {
        $args['group_id'] = SEC_getFeatureGroup('staticpages.edit', $_USER['uid']);
    }

    $args['sp_id'] = COM_sanitizeID($args['sp_id']);
    if (!$gl_edit) {
        if (strlen($args['sp_id']) > STATICPAGE_MAX_ID_LENGTH) {
            $slug = '';
            if (isset($args['slug'])) {
                $slug = $args['slug'];
            }
            if (function_exists('WS_makeId')) {
                $args['sp_id'] = WS_makeId($slug, STATICPAGE_MAX_ID_LENGTH);
            } else {
                $args['sp_id'] = COM_makeSid();
            }
        }
    }

    // Apply filters to the parameters passed by the webservice 
    if ($args['gl_svc']) {
        $par_str = array('mode', 'sp_id', 'sp_old_id', 'sp_tid', 'sp_format',
                         'postmode');
        $par_num = array('sp_uid', 'sp_hits', 'owner_id', 'group_id',
                         'sp_where', 'sp_php', 'commentcode');

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

    if(empty($args['sp_format'])) {
        $args['sp_format'] = 'allblocks';
    }

    if (empty($args['sp_tid'])) {
        $args['sp_tid'] = 'all';
    }

    if (($args['sp_where'] < 0) || ($args['sp_where'] > 3)) {
        $args['sp_where'] = 0;
    }

    if (($args['sp_php'] < 0) || ($args['sp_php'] > 2)) {
        $args['sp_php'] = 0;
    }

    if (($args['commentcode'] < -1) || ($args['commentcode'] > 1)) {
        $args['commentcode'] = $_CONF['comment_code'];
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
        } else if (($args['sp_onmenu'] == 'on') && empty($args['sp_label'])) {
            $svc_msg['error_desc'] = 'Menu label missing';
            return PLG_RET_ERROR;
        }

        if (empty($args['sp_content'])) {
            $svc_msg['error_desc'] = 'No content';
            return PLG_RET_ERROR;
        }

        if (empty($args['sp_inblock']) && ($_SP_CONF['in_block'] == '1')) {
            $args['sp_inblock'] = 'on';
        }

        if (empty($args['sp_centerblock'])) {
            $args['sp_centerblock'] = '';
        }
    }

    // END: Staticpages defaults 

    $sp_id = $args['sp_id'];
    $sp_uid = $args['sp_uid'];
    $sp_title = $args['sp_title'];
    $sp_content = $args['sp_content'];
    $sp_hits = $args['sp_hits'];
    $sp_format = $args['sp_format'];
    $sp_onmenu = $args['sp_onmenu'];
    $sp_label = '';
    if (!empty($args['sp_label'])) {
        $sp_label = $args['sp_label'];
    }
    $meta_description = $args['meta_description'];
    $meta_keywords = $args['meta_keywords'];    
    $commentcode = $args['commentcode'];
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
    $sp_help = '';
    if (!empty($args['sp_help'])) {
        $sp_help = $args['sp_help'];
    }
    $sp_tid = $args['sp_tid'];
    $sp_where = $args['sp_where'];
    $sp_inblock = $args['sp_inblock'];
    $postmode = $args['postmode'];

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

    // Check for unique page ID
    $duplicate_id = false;
    $delete_old_page = false;
    if (DB_count ($_TABLES['staticpage'], 'sp_id', $sp_id) > 0) {
        if ($sp_id != $sp_old_id) {
            $duplicate_id = true;
        }
    } elseif (!empty ($sp_old_id)) {
        if ($sp_id != $sp_old_id) {
            $delete_old_page = true;
        }
    }

    if ($duplicate_id) {
        $output .= COM_siteHeader ('menu', $LANG_STATIC['staticpageeditor']);
        $output .= COM_errorLog ($LANG_STATIC['duplicate_id'], 2);
        if (!$args['gl_svc']) {
            $output .= staticpageeditor ($sp_id);
        }
        $output .= COM_siteFooter ();
        $svc_msg['error_desc'] = 'Duplicate ID';
        return PLG_RET_ERROR;
    } elseif (!empty ($sp_title) && !empty ($sp_content)) {
        if (empty ($sp_hits)) {
            $sp_hits = 0;
        }

        if ($sp_onmenu == 'on') {
            $sp_onmenu = 1;
        } else {
            $sp_onmenu = 0;
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

        // Clean up the text
        if ($_SP_CONF['censor'] == 1) {
            $sp_content = COM_checkWords ($sp_content);
            $sp_title = COM_checkWords ($sp_title);
        }
        if ($_SP_CONF['filter_html'] == 1) {
            $sp_content = COM_checkHTML($sp_content, 'staticpages.edit');
        }
        $sp_title = strip_tags ($sp_title);
        $sp_label = strip_tags ($sp_label);

        $meta_description = strip_tags ($meta_description);
        $meta_keywords = strip_tags ($meta_keywords);

        $sp_content = addslashes ($sp_content);
        $sp_title = addslashes ($sp_title);
        $sp_label = addslashes ($sp_label);
        $meta_description = addslashes ($meta_description);
        $meta_keywords = addslashes ($meta_keywords);        

        // If user does not have php edit perms, then set php flag to 0.
        if (($_SP_CONF['allow_php'] != 1) || !SEC_hasRights ('staticpages.PHP')) {
            $sp_php = 0;
        }

        // make sure there's only one "entire page" static page per topic
        if (($sp_centerblock == 1) && ($sp_where == 0)) {
            $sql = "UPDATE {$_TABLES['staticpage']} SET sp_centerblock = 0 WHERE sp_centerblock = 1 AND sp_where = 0 AND sp_tid = '$sp_tid'";

            // if we're in a multi-language setup, we need to allow one "entire
            // page" centerblock for 'all' or 'none' per language
            if ((!empty($_CONF['languages']) &&
                    !empty($_CONF['language_files'])) &&
                    (($sp_tid == 'all') || ($sp_tid == 'none'))) {
                $ids = explode('_', $sp_id);
                if (count($ids) > 1) {
                    $lang_id = array_pop($ids);

                    $sql .= " AND sp_id LIKE '%\\_$lang_id'";
                }
            }

            DB_query($sql);
        }

        $formats = array ('allblocks', 'blankpage', 'leftblocks', 'noblocks');
        if (!in_array ($sp_format, $formats)) {
            $sp_format = 'allblocks';
        }

        if (!$args['gl_svc']) {
            list($perm_owner,$perm_group,$perm_members,$perm_anon) = SEC_getPermissionValues($perm_owner,$perm_group,$perm_members,$perm_anon);
        }

        DB_save ($_TABLES['staticpage'], 'sp_id,sp_uid,sp_title,sp_content,sp_date,sp_hits,sp_format,sp_onmenu,sp_label,commentcode,meta_description,meta_keywords,owner_id,group_id,'
                .'perm_owner,perm_group,perm_members,perm_anon,sp_php,sp_nf,sp_centerblock,sp_help,sp_tid,sp_where,sp_inblock,postmode',
                "'$sp_id',$sp_uid,'$sp_title','$sp_content',NOW(),$sp_hits,'$sp_format',$sp_onmenu,'$sp_label','$commentcode','$meta_description','$meta_keywords',$owner_id,$group_id,"
                        ."$perm_owner,$perm_group,$perm_members,$perm_anon,'$sp_php','$sp_nf',$sp_centerblock,'$sp_help','$sp_tid',$sp_where,"
                        ."'$sp_inblock','$postmode'");

        if ($delete_old_page && !empty ($sp_old_id)) {
            DB_delete ($_TABLES['staticpage'], 'sp_id', $sp_old_id);
        }

        if (empty($sp_old_id) || ($sp_id == $sp_old_id)) {
            PLG_itemSaved($sp_id, 'staticpages');
        } else {
            DB_change($_TABLES['comments'], 'sid', addslashes($sp_id),
                      array('sid', 'type'),
                      array(addslashes($sp_old_id), 'staticpages'));
            PLG_itemSaved($sp_id, 'staticpages', $sp_old_id);
        }

        $url = COM_buildURL($_CONF['site_url'] . '/staticpages/index.php?page='
                            . $sp_id);
        $output .= PLG_afterSaveSwitch($_SP_CONF['aftersave'], $url,
                                       'staticpages', 19);

        $svc_msg['id'] = $sp_id;
        return PLG_RET_OK;
    } else {
        $output .= COM_siteHeader ('menu', $LANG_STATIC['staticpageeditor']);
        $output .= COM_errorLog ($LANG_STATIC['no_title_or_content'], 2);
        if (!$args['gl_svc']) {
            $output .= staticpageeditor ($sp_id);
        }
        $output .= COM_siteFooter ();
        return PLG_RET_ERROR;
    }
}

/**
 * Delete an existing static page
 *
 * @param   array   args    Contains all the data provided by the client
 * @param   string  &output OUTPUT parameter containing the returned text
 * @param   string  &svc_msg OUTPUT parameter containing any service messages
 * @return  int		    Response code as defined in lib-plugins.php
 */
function service_delete_staticpages($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $_USER, $LANG_ACCESS, $LANG12, $LANG_STATIC,
           $LANG_LOGIN;

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

    if (!SEC_hasRights ('staticpages.delete')) {
        $output = COM_siteHeader ('menu', $LANG_STATIC['access_denied']);
        $output .= COM_startBlock ($LANG_STATIC['access_denied'], '',
                                    COM_getBlockTemplate ('_msg_block', 'header'));
        $output .= $LANG_STATIC['access_denied_msg'];
        $output .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $output .= COM_siteFooter ();
        if ($_USER['uid'] > 1) {
            return PLG_RET_PERMISSION_DENIED;
        } else {
            return PLG_RET_AUTH_FAILED;
        }
    }

    DB_delete($_TABLES['staticpage'], 'sp_id', $sp_id);
    DB_delete($_TABLES['comments'], array('sid',  'type'),
                                    array($sp_id, 'staticpages'));

    PLG_itemDeleted($sp_id, 'staticpages');

    return PLG_RET_OK;
}

/**
 * Get an existing static page
 *
 * @param   array   args    Contains all the data provided by the client
 * @param   string  &output OUTPUT parameter containing the returned text
 * @param   string  &svc_msg OUTPUT parameter containing any service messages
 * @return  int		    Response code as defined in lib-plugins.php
 */
function service_get_staticpages($args, &$output, &$svc_msg)
{
    global $_CONF, $_TABLES, $LANG_ACCESS, $LANG12, $LANG_STATIC, $LANG_LOGIN, $_SP_CONF;

    $output = '';

    $svc_msg['output_fields'] = array(
                                    'sp_hits',
                                    'sp_format',
                                    'owner_id',
                                    'group_id',
                                    'perm_owner',
                                    'perm_group',
                                    'perm_members',
                                    'perm_anon',
                                    'sp_help',
                                    'sp_php',
                                    'sp_inblock',
                                    'commentcode'
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
        $perms = SP_getPerms ();
        if (!empty ($perms)) {
            $perms = ' AND ' . $perms;
        }
        $sql = array();
        $sql['mysql'] = "SELECT sp_title,sp_content,sp_hits,sp_date,sp_format,"
                      . "commentcode,meta_description,meta_keywords,owner_id,"
                      . "group_id,perm_owner,perm_group,"
                      . "perm_members,perm_anon,sp_tid,sp_help,sp_php,"
                      . "sp_inblock FROM {$_TABLES['staticpage']} "
                      . "WHERE (sp_id = '$page')" . $perms;
        $sql['mssql'] = "SELECT sp_title,"
                      . "CAST(sp_content AS text) AS sp_content,sp_hits,"
                      . "sp_date,sp_format,commentcode,"
                      . "CAST(meta_description AS text) AS meta_description,"
                      . "CAST(meta_keywords AS text) AS meta_keywords,"
                      . "owner_id,group_id,perm_owner,perm_group,perm_members,"
                      . "perm_anon,sp_tid,sp_help,sp_php,sp_inblock "
                      . "FROM {$_TABLES['staticpage']} WHERE (sp_id = '$page')"
                      . $perms;
        $result = DB_query ($sql);
        $count = DB_numRows ($result);

        if ($count == 0 || $count > 1) {
            $error = 1;
        }

        if (!($error)) {
            $output = DB_fetchArray ($result, false);

            // WE ASSUME $output doesn't have any confidential fields 

        } else { // an error occured (page not found, access denied, ...)
            if (empty ($page)) {
                $failflg = 0;
            } else {
                $failflg = DB_getItem ($_TABLES['staticpage'], 'sp_nf', "sp_id='$page'");
            }
            if ($failflg) {
                if ($mode !== 'autotag') {
                    $output = COM_siteHeader ('menu');
                }
                $output .= COM_startBlock ($LANG_LOGIN[1], '',
                                        COM_getBlockTemplate ('_msg_block', 'header'));
                $login = new Template ($_CONF['path_layout'] . 'submit');
                $login->set_file (array ('login' => 'submitloginrequired.thtml'));
                $login->set_var ('login_message', $LANG_LOGIN[2]);
                $login->set_var ('site_url', $_CONF['site_url']);
                $login->set_var ('lang_login', $LANG_LOGIN[3]);
                $login->set_var ('lang_newuser', $LANG_LOGIN[4]);
                $login->parse ('output', 'login');
                $output .= $login->finish ($login->get_var ('output'));
                $output .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
                if ($mode !== 'autotag') {
                    $output .= COM_siteFooter (true);
                }
            } else {
                if ($mode !== 'autotag') {
                    $output = COM_siteHeader ('menu');
                }
                $output .= COM_startBlock ($LANG_ACCESS['accessdenied'], '',
                                        COM_getBlockTemplate ('_msg_block', 'header'));
                $output .= $LANG_STATIC['deny_msg'];
                $output .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
                if ($mode !== 'autotag') {
                    $output .= COM_siteFooter (true);
                }
            }

            return PLG_RET_ERROR;
        }

        if ($args['gl_svc']) {
            // This date format is PHP 5 only,
            // but only the web-service uses the value
            $output['published']    = date('c', strtotime($output['sp_date']));
            $output['updated']      = date('c', strtotime($output['sp_date']));
            $output['id']           = $page;
            $output['title']        = $output['sp_title'];
            $output['category']     = array($output['sp_tid']);
            $output['content']      = $output['sp_content'];
            $output['content_type'] = 'html';

            $owner_data = SESS_getUserDataFromId($output['owner_id']);

            $output['author_name']  = $owner_data['username'];

            $output['link_edit'] = $page;
        }
    } else {
        $output = array();

        $mode = '';
        if (isset($args['mode'])) {
            $mode = $args['mode'];
        }

        $perms = SP_getPerms();
        if (!empty ($perms)) {
            $perms = ' WHERE ' . $perms;
        }

        $offset = 0;
        if (isset($args['offset'])) {
            $offset = COM_applyBasicFilter($args['offset'], true);
        }
        $max_items = $_SP_CONF['atom_max_items'] + 1;

        $limit = " LIMIT $offset, $max_items";
        $order = " ORDER BY sp_date DESC";
        $sql = array();
        $sql['mysql'] = "SELECT sp_id,sp_title,sp_content,sp_hits,sp_date,sp_format,meta_description,meta_keywords,owner_id,"
                ."group_id,perm_owner,perm_group,perm_members,perm_anon,sp_tid,sp_help,sp_php,"
                ."sp_inblock FROM {$_TABLES['staticpage']}" . $perms . $order . $limit;
        $sql['mssql'] = "SELECT sp_id,sp_title,CAST(sp_content AS text) AS sp_content,sp_hits,"
                ."sp_date,sp_format,CAST(meta_description AS text) AS meta_description,CAST(meta_keywords AS text) AS meta_keywords,owner_id,group_id,perm_owner,perm_group,perm_members,"
                ."perm_anon,sp_tid,sp_help,sp_php,sp_inblock FROM {$_TABLES['staticpage']}"
                . $perms . $order . $limit;
        $result = DB_query ($sql);

        $count = 0;
        while (($output_item = DB_fetchArray ($result, false)) !== false) {
            // WE ASSUME $output doesn't have any confidential fields 

            $count += 1;
            if ($count == $max_items) {
                $svc_msg['offset'] = $offset + $_SP_CONF['atom_max_items'];
                break;
            }

            if($args['gl_svc']) {
                // This date format is PHP 5 only, but only the web-service uses the value 
                $output_item['published']    = date('c', strtotime($output_item['sp_date']));
                $output_item['updated']      = date('c', strtotime($output_item['sp_date']));
                $output_item['id']           = $output_item['sp_id'];
                $output_item['title']        = $output_item['sp_title'];
                $output_item['category']     = array($output_item['sp_tid']);
                $output_item['content']      = $output_item['sp_content'];
                $output_item['content_type'] = 'html';

                $owner_data = SESS_getUserDataFromId($output_item['owner_id']);

                $output_item['author_name']  = $owner_data['username'];
            }
            $output[] = $output_item;
        }
    }

    return PLG_RET_OK;
}

/**
 * Get all the topics available
 *
 * @param   array   args    Contains all the data provided by the client
 * @param   string  &output OUTPUT parameter containing the returned text
 * @return  int         Response code as defined in lib-plugins.php
 */
function service_getTopicList_staticpages($args, &$output, &$svc_msg)
{
    //$output = COM_topicArray('tid');
    $output[] = 'all';
    $output[] = 'none';

    return PLG_RET_OK;
}

?>
