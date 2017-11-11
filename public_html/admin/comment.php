<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | comment.php                                                               |
// |                                                                           |
// | Geeklog block administration.                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Vincent Furia     - vinny01 AT users DOT sourceforge DOT net     |
// |          Jared Wenerd      - wenerd87 AT gmail DOT com                    |
// |          Kenji ITO         - mystralkk AT gmail DOT com                   |
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
 * Comment administration page: Moderate, edit, delete, comments for your Geeklog site.
 */

define('SUFFIX_COMMENTS', '_comments');
define('SUFFIX_COMMENT_SUBMISSIONS', '_submissions');
define('COMMENT_MAX_LENGTH', 60);

// Geeklog common function library
require_once '../lib-common.php';

// Security check to ensure user even belongs on this page
require_once './auth.inc.php';

if (!SEC_hasRights('comment.moderate')) {
    $content = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($content, array('pagetitle' => $MESSAGE[30]));
    COM_accessLog("User {$_USER['username']} tried to illegally access the block administration screen");
    COM_output($display);
    exit;
}

// Include system libraries
require_once $_CONF['path_system'] . 'lib-admin.php';
require_once $_CONF['path_system'] . 'lib-article.php';
require_once $_CONF['path_system'] . 'lib-comment.php';

/**
 * Return comment IDs being selected in the list
 *
 * @param  string $suffix
 * @return array of int
 */
function getCommentIds($suffix)
{
    $commentIds = \Geeklog\Input::fPost('cids' . $suffix, array());

    if (count($commentIds) > 0) {
        $commentIds = array_map('intval', $commentIds);
    }

    return $commentIds;
}

/**
 * Field function
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $iconArray
 * @param  string $suffix
 * @return string
 * @throws Exception
 */
function ADMIN_getListField_comments($fieldName, $fieldValue, $A, $iconArray, $suffix)
{
    global $_CONF, $LANG01, $LANG_STATIC, $LANG_POLLS;
    static $encoding = null;

    if ($encoding === null) {
        $encoding = COM_getEncodingt();
    }

    $commentId = $A['cid'];

    switch ($fieldName) {
        case 'selector':
            $fieldValue = '<input type="checkbox" name="cids' . $suffix . '[]" value="' . $commentId . '"' . XHTML . '>';
            break;

        case 'edit':
            if ($suffix === SUFFIX_COMMENTS) {
                $link = $_CONF['site_url'] . '/comment.php?mode=edit&amp;cid='
                    . htmlspecialchars($commentId, ENT_QUOTES, $encoding)
                    . '&amp;sid=' . $A['sid'] . '&amp;type=' . $A['type'];
            } else {
                $link = $_CONF['site_url'] . '/comment.php?mode=editsubmission&amp;cid='
                    . htmlspecialchars($commentId, ENT_QUOTES, $encoding);
            }

            $fieldValue = '<a href="' . $link . '" title="' . $LANG01[4] . '">' . $iconArray['edit'] . '</a>';
            break;

        case 'type':
            switch ($fieldValue) {
                case 'article':
                    $fieldValue = $LANG01[11];
                    break;

                default:
                    $fieldValue = ucfirst($fieldValue);
                    break;
            }
            break;

        case 'sid':
            $result = PLG_getItemInfo($A['type'], $fieldValue, 'title,url');
            if (is_array($result) && isset($result[0], $result[1])) {
                list ($title, $url) = $result;
                $fieldValue = '<a href="' . $url . '">' . htmlspecialchars($title, ENT_QUOTES, $encoding) . '</a>';
            } elseif (is_array(0) && isset($result[1])) {
                list ($title) = $result;
                $fieldValue = htmlspecialchars($title, ENT_QUOTES, $encoding);
            } else {
                $fieldValue = '';
            }
            
            break;

        case 'title':
            $fieldValue = '<a href="' . $_CONF['site_url'] . '/comment.php?mode=view&amp;cid='
                . htmlspecialchars($commentId, ENT_QUOTES, $encoding) . '">'
                . htmlspecialchars($fieldValue, ENT_QUOTES, $encoding) . '</a>';
            break;

        case 'comment':
            $fieldValue = COM_truncate(GLText::stripTags($fieldValue), COMMENT_MAX_LENGTH, '...');
            break;

        case 'uid':
            $userId = intval($fieldValue, 10);
            $userName = trim($A['name']);
            $fieldValue = COM_getDisplayName($userId, $userName);
            $fieldValue = htmlspecialchars($fieldValue, ENT_QUOTES, $encoding);

            if ($userId > 1) {
                $fieldValue = '<a href="' . $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $userId . '">' . $fieldValue . '</a>';
            }

            break;

        case 'ipaddress':
            $forDisplay = htmlspecialchars($fieldValue, ENT_QUOTES, $encoding);

            if (SPAMX_isIPBanned($fieldValue)) {
                $fieldValue = '<span style="color: red;">' . $forDisplay . '</span>';
            } else {
                $fieldValue = $forDisplay;
            }

            break;

        default:
            break;
    }

    return $fieldValue;
}

/**
 * Return a selector to filter item type
 *
 * @param string $itemType
 * @return string
 */
function getTypeSelector($itemType)
{
    global $_PLUGINS, $LANG_ADMIN, $LANG09, $LANG_STATIC, $LANG_POLLS;

    $retval = $LANG_ADMIN['type']
        . ': <select name="item_type" style="width: 125px;" onchange="this.form.submit()">' . LB;

    $selected = ($itemType === 'all') ? ' selected="selected"' : '';
    $retval .= '<option value="all"' . $selected . '>' . $LANG09[4] . '</option>' . LB;

    $selected = ($itemType === 'article') ? ' selected="selected"' : '';
    $retval .= '<option value="article"' . $selected . '>' . $LANG09[6] . '</option>' . LB;
    
   // Add enabled plugins that use comments
    foreach ($_PLUGINS as $pi_name) {
        $function = 'plugin_displaycomment_' . $pi_name;
        if (function_exists($function)) {
            // Since can display comments assume it uses comment system
            $selected = ($itemType === $pi_name) ? ' selected="selected"' : '';
        $retval .= '<option value="' . $pi_name . '"' . $selected . '>' . ucfirst($pi_name) . '</option>' . LB;
        }
    }    

    $retval .= '</select>' . LB;

    return $retval;
}

/**
 * Build a comment list
 *
 * @param  string $suffix
 * @param  string $tableName
 * @param  string $securityToken
 * @return string
 */
function ADMIN_buildCommentList($suffix, $tableName, $securityToken)
{
    global $_CONF, $_PLUGINS, $_TABLES, $LANG_ADMIN, $LANG01, $LANG03, $LANG28, $LANG29;

    $headerArray = array(
        array(
            'text'  => '<input type="checkbox" name="select_all' . $suffix . '" id="select_all' . $suffix . '"' . XHTML . '>',
            'field' => 'selector',
            'sort'  => false,
        ),
        array(
            'text'  => $LANG01[4],
            'field' => 'edit',
            'sort'  => false,
        ),
        array(
            'text'  => $LANG_ADMIN['type'],
            'field' => 'type',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG29[36],
            'field' => 'sid',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG29[14],
            'field' => 'date',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG_ADMIN['title'],
            'field' => 'title',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG03[9],
            'field' => 'comment',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG28[3],
            'field' => 'uid',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG03[105],
            'field' => 'ipaddress',
            'sort'  => true,
        ),
    );

    $defaultSortArray = array('field' => 'date', 'direction' => 'desc');
    $textArray = array(
        'has_extras' => true,
        'title'      => ($suffix === SUFFIX_COMMENTS ? $LANG03[101] : $LANG29[41]),
        'form_url'   => $_CONF['site_admin_url'] . '/comment.php',
    );

    $itemType = \Geeklog\Input::fPost('item_type', '');

    if (($itemType !== 'article') && ($itemType !== 'all') && !in_array($itemType, $_PLUGINS)) {
        $itemType = '';
    }

    if (empty($itemType) || ($itemType === 'all')) {
        $sqlForType = '';
    } else {
        $sqlForType = " AND (type = '" . DB_escapeString($itemType) . "') ";
    }

    $queryArray = array(
        'table'          => $tableName,
        'sql'            => "SELECT * FROM " . $_TABLES[$tableName] . " WHERE (1 = 1) ",
        'query_fields'   => array('type', 'sid', 'date', 'title', 'comment', 'uid', 'ipaddress'),
        'default_filter' => $sqlForType . COM_getPermSql('AND'),
    );

    $filter = getTypeSelector($itemType);
    $options = array();
    $actionSelector = '<select name="bulk_action' . $suffix . '" id="bulk_action' . $suffix . '">' . LB
        . '<option value="do_nothing">' . $LANG03[102] . '</option>' . LB;

    if ($suffix === SUFFIX_COMMENT_SUBMISSIONS) {
        $actionSelector .= '<option value="bulk_approve">' . $LANG29[1] . '</option>' . LB;
    }

    $actionSelector .= '<option value="bulk_delete">' . $LANG29[2] . '</option>' . LB
        . '<option value="bulk_ban_user">' . $LANG03[103] . '</option>' . LB;

    if (in_array('spamx', $_PLUGINS)) {
        $actionSelector .= '<option value="bulk_ban_ip_address">' . $LANG03[104] . '</option>' . LB;
    }

    $actionSelector .= '</select>' . LB
        . '<input type="submit" name="submit" id="bulk_action_submit' . $suffix . '" value="'
        . $LANG_ADMIN['submit'] . '"' . XHTML . '>' . LB
        . '<input type="hidden" name="list" value="' . $suffix . '"' . XHTML . '>' . LB;
    $securityTokenTag = '<input type="hidden" name="' . CSRF_TOKEN . '" value="'
        . $securityToken . '"' . XHTML . '>' . LB;
    $formArray = array(
        'top'    => '',
        'bottom' => $actionSelector . $securityTokenTag,
    );

    $commentList = ADMIN_list(
        'comments', 'ADMIN_getListField_comments', $headerArray, $textArray,
        $queryArray, $defaultSortArray, $filter, $suffix, $options, $formArray
    );

    return $commentList;
}

/**
 * Display two lists of comments, ordinary comments and submissions
 *
 * @return   string  HTML for the two lists
 */
function listComments()
{
    global $_CONF, $_SCRIPTS, $LANG_ADMIN, $LANG03, $_IMAGE_TYPE;

    // Create a security token to be used in both lists
    $securityToken = SEC_createToken();

    // Writing the menu on top
    $menu_arr = array(
        array(
            'url'  => $_CONF['site_admin_url'],
            'text' => $LANG_ADMIN['admin_home'],
        ),
    );
    $retval = COM_startBlock($LANG03[100], '', COM_getBlockTemplate('_admin_block', 'header'))
        . ADMIN_createMenu(
            $menu_arr,
            $LANG03[106],
            $_CONF['layout_url'] . '/images/icons/comment.' . $_IMAGE_TYPE
        )
        . ADMIN_buildCommentList(SUFFIX_COMMENT_SUBMISSIONS, 'commentsubmissions', $securityToken)
        . ADMIN_buildCommentList(SUFFIX_COMMENTS, 'comments', $securityToken)
        . COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
    $_SCRIPTS->setJavaScriptFile('comment', '/javascript/comment.js', true);

    return $retval;
}

/**
 * Delete a comment
 *
 * @param   string $suffix
 */
function deleteComments($suffix)
{
    global $_CONF, $_TABLES, $_USER;

    $commentIds = getCommentIds($suffix);

    if (SEC_checkToken()) {
        if (count($commentIds) > 0) {
            foreach ($commentIds as $commentId) {
                if ($commentId <= 0) {
                    COM_errorLog("Attempted to delete a nonexistent comment (cid = {$commentId})");
                } else {
                    if ($suffix === SUFFIX_COMMENTS) {
                        $sql = "SELECT sid, type FROM {$_TABLES['comments']} WHERE cid = " . DB_escapeString($commentId);
                        $result = DB_query($sql);

                        if (!DB_error()) {
                            $A = DB_fetchArray($result, false);

                            if (is_array($A) && (count($A) > 0)) {
                                $sid = $A['sid'];
                                $type = $A['type'];

                                if (CMT_deleteComment($commentId, $sid, $type) > 0) {
                                    COM_errorLog("Attempted to delete a nonexistent comment (cid = {$commentId})");
                                }
                            }
                        }
                    } elseif ($suffix === SUFFIX_COMMENT_SUBMISSIONS) {
                        $sql = "DELETE FROM {$_TABLES['commentsubmissions']} "
                            . "WHERE cid = " . DB_escapeString($commentId);
                        DB_query($sql);
                    }
                }
            }

            COM_redirect($_CONF['site_admin_url'] . '/comment.php?msg=140');
        }
    } else {
        COM_accessLog("User {$_USER['username']} tried to delete comments (cid = " . implode(', ', $commentIds) . ") and failed CSRF checks.");
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    }
}

/**
 * Approve a comment
 *
 * @param  string $suffix
 */
function approveComments($suffix)
{
    global $_CONF, $_USER;

    $commentIds = getCommentIds($suffix);

    if (SEC_checkToken()) {
        if (count($commentIds) > 0) {
            foreach ($commentIds as $commentId) {
                CMT_approveModeration($commentId);
            }
        }

        COM_redirect($_CONF['site_admin_url'] . '/comment.php?msg=142');
    } else {
        COM_accessLog("User {$_USER['username']} tried to approve comments (cid = " . implode(', ', $commentIds) . ") and failed CSRF checks.");
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    }
}

/**
 * Ban users
 *
 * @param  string $suffix
 */
function banUsers($suffix)
{
    global $_CONF, $_TABLES, $_USER;

    $getCommentIds = getCommentIds($suffix);

    if (SEC_checkToken()) {
        if (count($getCommentIds) > 0) {
            $currentUserId = $_USER['uid'];
            $sql = "SELECT DISTINCT uid FROM {$_TABLES['comments']} "
                . "WHERE (uid <> 1) AND (uid <> {$currentUserId}) AND "
                . " (cid IN (" . implode(',', $getCommentIds) . "))";
            $result = DB_query($sql);
            $userIds = array();

            while (($A = DB_fetchArray($result, false)) !== false) {
                $userIds[] = $A['uid'];
            }

            if (count($userIds) > 0) {
                $sql = "UPDATE {$_TABLES['users']} SET status = " . USER_ACCOUNT_DISABLED
                    . " WHERE (uid IN (" . implode(',', $userIds) . "))";
                DB_query($sql);
                COM_redirect($_CONF['site_admin_url'] . '/comment.php?msg=143');
            }
        }
    } else {
        COM_accessLog("User {$_USER['username']} tried to ban users and failed CSRF checks.");
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    }
}

/**
 * Ban IP Addresses being selected with the Spamx plugin
 *
 * @param  string $suffix
 */
function banIpAddresses($suffix)
{
    global $_CONF, $_PLUGINS, $_TABLES, $_USER;

    if (SEC_checkToken()) {
        if (!in_array('spamx', $_PLUGINS)) {
            COM_errorLog(__FUNCTION__ . ': Spamx plugin is not installed or disabled.');
            COM_redirect($_CONF['site_admin_url'] . '/index.php');
        }

        $getCommentIds = getCommentIds($suffix);

        if (count($getCommentIds) > 0) {
            $sql = "SELECT DISTINCT ipaddress FROM {$_TABLES['comments']} "
                . "WHERE (ipaddress NOT LIKE '192.168.%') AND (ipaddress <> '::1') AND "
                . " (cid IN (" . implode(',', $getCommentIds) . "))";
            $result = DB_query($sql);

            if (!DB_error()) {
                $ipAddresses = array();

                while (($A = DB_fetchArray($result, false)) !== false) {
                    $ipAddresses[] = $A['ipaddress'];
                }

                SPAMX_registerBannedIPs($ipAddresses);
            }

            COM_redirect($_CONF['site_admin_url'] . '/comment.php?msg=144');
        }
    } else {
        COM_accessLog("User {$_USER['username']} tried to ban IP addresses and failed CSRF checks.");
        COM_redirect($_CONF['site_admin_url'] . '/index.php');
    }
}

// MAIN
$list = \Geeklog\Input::fPost('list', '');

if ($list === SUFFIX_COMMENTS) {
    $suffix = SUFFIX_COMMENTS;
} elseif ($list === SUFFIX_COMMENT_SUBMISSIONS) {
    $suffix = SUFFIX_COMMENT_SUBMISSIONS;
} else {
    $suffix = '';
}

$action = \Geeklog\Input::fPost('bulk_action' . $suffix, '');

switch ($action) {
    case 'bulk_approve':
        approveComments($suffix);
        break;

    case 'bulk_delete':
        deleteComments($suffix);
        break;

    case 'bulk_ban_user':
        banUsers($suffix);
        break;

    case 'bulk_ban_ip_address':
        banIpAddresses($suffix);
        break;

    default:
        // Do nothing here
        break;
}

$content = COM_showMessageFromParameter() . listComments();
$display = COM_createHTMLDocument($content, array('pagetitle' => $LANG03[100]));
COM_output($display);
