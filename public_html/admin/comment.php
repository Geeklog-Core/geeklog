<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | comment.php                                                               |
// |                                                                           |
// | Geeklog block administration.                                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2012 by the following authors:                         |
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

// Comment library
require_once $_CONF['path_system'] . 'lib-comment.php';

/**
 * Return comment IDs being selected in the list
 *
 * @return array of int
 */
function getCids() {
    global $_FINPUT;

    $cids = $_FINPUT->post('cids', array());

    if (count($cids) > 0) {
        $cids = array_map('intval', $cids);
    }

    return $cids;
}

/**
 * Field function
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $iconArray
 * @param  string $extra
 * @return string
 * @throws Exception
 */
function ADMIN_getListField_comments($fieldName, $fieldValue, $A, $iconArray, $extra = '')
{
    global $_CONF, $LANG01, $LANG_STATIC, $LANG_POLLS;
    static $encoding = null;

    if ($encoding === null) {
        $encoding = COM_getEncodingt();
    }

    if (!in_array($A['type'], array('article', 'staticpages', 'polls'))) {
        throw new Exception(__FUNCTION__ . ': unknown type "' . $A['type'] . '" was given');
    }

    switch ($fieldName) {
        case 'selector':
            $cid = $A['cid'];
            $fieldValue = '<input type="checkbox" name="cids[]" value="' . $cid . '"' . XHTML . '>';
            break;

        case 'edit':
            $cid = $A['cid'];
            $fieldValue = '<a href="' . $_CONF['site_url']
                . '/comment.php?mode=editsubmission&amp;cid='
                . htmlspecialchars($cid, ENT_QUOTES, $encoding) . '" title="' . $LANG01[4] . '">'
                . $iconArray['edit'] . '</a>';
            break;

        case 'type':
            switch ($fieldValue) {
                case 'article':
                    $fieldValue = $LANG01[11];
                    break;

                case 'staticpages':
                    $fieldValue = $LANG_STATIC['staticpages'];
                    break;

                case 'polls':
                    $fieldValue = $LANG_POLLS['poll'];
                    break;
            }
            break;

        case 'sid':
            $what = 'title,url';

            switch ($A['type']) {
                case 'article':
                    list($title, $url) = plugin_getiteminfo_story($fieldValue, $what);
                    break;

                case 'staticpages':
                    list($title, $url) = plugin_getiteminfo_staticpages($fieldValue, $what);
                    break;

                case 'polls':
                    list($title, $url) = plugin_getiteminfo_polls($fieldValue, $what);
                    break;
            }

            $fieldValue = '<a href="' . $url . '">' . htmlspecialchars($title, ENT_QUOTES, $encoding) . '</a>';
            break;

        case 'title':
            $fieldValue = '<a href="' . $_CONF['site_url'] . '/comment.php?mode=view&amp;cid=' . $A['cid'] . '">'
                . htmlspecialchars($fieldValue, ENT_QUOTES, $encoding) . '</a>';
            break;

        case 'comment':
//            $fieldValue = htmlspecialchars($fieldValue, ENT_QUOTES, $encoding);
            break;

        case 'uid':
            $uid = intval($fieldValue, 10);
            $userName = trim($A['name']);
            $fieldValue = COM_getDisplayName($uid, $userName);
            $fieldValue = htmlspecialchars($fieldValue, ENT_QUOTES, $encoding);

            if ($uid > 1) {
                $fieldValue = '<a href="' . $_CONF['site_url']
                    . '/users.php?mode=profile&amp;uid=' . $uid . '">' . $fieldValue . '</a>';
            }

            break;

        case 'ipaddress':
            $fieldValue = htmlspecialchars($fieldValue, ENT_QUOTES, $encoding);
            break;

        default:
            break;
    }

    return $fieldValue;
}

/**
 * Field function
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $iconArray
 * @param  string $extra
 * @return string
 * @throws Exception
 */
function ADMIN_getListField_commentSubmissions($fieldName, $fieldValue, $A, $iconArray, $extra = '')
{
    return ADMIN_getListField_comments($fieldName, $fieldValue, $A, $iconArray, $extra);
}

/**
 * Return a selector to filter item type
 *
 * @param string $itemType
 * @return string
 */
function getTypeSelector($itemType)
{
    global $_PLUGINS, $_FINPUT, $LANG_ADMIN, $LANG09, $LANG_STATIC, $LANG_POLLS;

    $retval = $LANG_ADMIN['type']
        . ': <select name="item_type" style="width: 125px;" onchange="this.form.submit()">' . LB;

    $selected = ($itemType === 'all') ? ' selected="selected"' : '';
    $retval .= '<option value="all"' . $selected . '>' . $LANG09[4] . '</option>' . LB;

    $selected = ($itemType === 'article') ? ' selected="selected"' : '';
    $retval .= '<option value="article"' . $selected . '>' . $LANG09[6] . '</option>' . LB;

    if (in_array('staticpages', $_PLUGINS)) {
        $selected = ($itemType === 'staticpages') ? ' selected="selected"' : '';
        $retval .= '<option value="staticpages"' . $selected . '>' . $LANG_STATIC['staticpages'] . '</option>' . LB;
    }

    if (in_array('polls', $_PLUGINS)) {
        $selected = ($itemType === 'polls') ? ' selected="selected"' : '';
        $retval .= '<option value="polls"' . $selected . '>' . $LANG_POLLS['polls'] . '</option>' . LB;
    }

    $retval .= '</select>' . LB;

    return $retval;
}

/**
 * Display two lists of comments, ordinary comments and submissions
 *
 * @return   string  HTML for the two lists
 */
function listComments()
{
    global $_CONF, $_PLUGINS, $_SCRIPTS, $_TABLES, $_FINPUT, $LANG_ADMIN, $LANG01, $LANG03, $LANG28, $LANG29, $_IMAGE_TYPE, $securityToken;

    require_once $_CONF['path_system'] . 'lib-admin.php';
    require_once $_CONF['path_system'] . 'lib-story.php';

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
            $LANG03[100],
            $_CONF['layout_url'] . '/images/icons/comment.' . $_IMAGE_TYPE
        );

    // Regular Comments
    $headerArray = array(      # display 'text' and use table field 'field'
        array(
            'text'  => '<input type="checkbox" name="select_all" id="select_all"' . XHTML . '>',
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
        'title'      => $LANG03[101],
        'form_url'   => $_CONF['site_admin_url'] . '/comment.php',
    );

    $itemType = $_FINPUT->post('item_type', '');

    switch ($itemType) {
        case 'article':
        case 'all':
            break;

        case 'staticpages':
            if (!in_array('staticpages', $_PLUGINS)) {
                $itemType = '';
            }
            break;

        case 'polls':
            if (!in_array('polls', $_PLUGINS)) {
                $itemType = '';
            }
            break;

        default:
            $itemType = '';
            break;
    }

    if (($itemType === '') || ($itemType === 'all')) {
        $sqlForType = '';
    } else {
        $sqlForType = " AND (type = '" . DB_escapeString($itemType) . "') ";
    }

    $queryArray = array(
        'table'          => 'comments',
        'sql'            => "SELECT * FROM {$_TABLES['comments']} WHERE (1 = 1) ",
        'query_fields'   => array('type', 'sid', 'date', 'title', 'comment', 'uid', 'ipaddress'),
        'default_filter' => $sqlForType . COM_getPermSql('AND'),
    );

    $filter = getTypeSelector($itemType);
    $options = array();
    $actionSelector = '<select name="bulk_action" id="bulk_action">' . LB
        . '<option value="do_nothing">' . $LANG03[102] . '</option>' . LB
        . '<option value="bulk_approve">' . $LANG29[1] . '</option>' . LB
        . '<option value="bulk_delete">' . $LANG29[2] . '</option>' . LB
        . '<option value="bulk_ban_user">' . $LANG03[103] . '</option>' . LB;

    if (in_array('spamx', $_PLUGINS)) {
        $actionSelector .= '<option value="bulk_ban_ip_address">' . $LANG03[104] . '</option>' . LB;
    }

    $actionSelector .= '</select>' . LB
        . '<input type="submit" name="submit" id="bulk_action_submit" value="'
        . $LANG_ADMIN['submit'] . '"' . XHTML . '>' . LB;
    $securityTokenTag = '<input type="hidden" name="' . CSRF_TOKEN . '" value="'
        . $securityToken . '"' . XHTML . '>' . LB;
    $formArray = array(
        'top'    => '',
        'bottom' => $actionSelector . $securityTokenTag,
    );

    $commentList = ADMIN_list(
        'comments', 'ADMIN_getListField_comments', $headerArray, $textArray,
        $queryArray, $defaultSortArray, $filter, $securityToken, $options, $formArray
    );

    // Comment submissions
    $textArray = array(
        'has_extras' => true,
        'title'      => $LANG29[41],
        'form_url'   => $_CONF['site_admin_url'] . '/comment.php',
    );

    $queryArray = array(
        'table'          => 'commentsubmissions',
        'sql'            => "SELECT * FROM {$_TABLES['commentsubmissions']} WHERE (1 = 1) ",
        'query_fields'   => array('type', 'sid', 'date', 'title', 'comment', 'uid', 'ipaddress'),
        'default_filter' => $sqlForType . COM_getPermSql('AND'),
    );

    $submissionList = ADMIN_list(
        'comments', 'ADMIN_getListField_commentSubmissions', $headerArray, $textArray,
        $queryArray, $defaultSortArray, $filter, $securityToken, $options, $formArray
    );

    $retval .= $submissionList . $commentList
        . COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
    $_SCRIPTS->setJavaScriptFile('comment', '/javascript/comment.js', true);

    return $retval;
}

/**
 * Delete a comment
 *
 * @return   string          HTML redirect or error message
 */
function deleteComments()
{
    global $_CONF, $_TABLES, $_USER, $_FINPUT, $LANG03;

    $cid = $_FINPUT->get('cid', $_FINPUT->post('cid', 0));
    $cid = intval($cid, 10);
    $sid = $_FINPUT->post('sid', '');
    $type = $_FINPUT->post('type', '');

    $retval = '';

    if (($cid <= 0) || ($sid === '') || ($type === '')) {
        COM_errorLog("Attempted to delete a nonexistent comment (cid = {$cid})");
        $retval = COM_refresh($_CONF['site_admin_url'] . '/comment.php');
    } elseif (!SEC_checkToken()) {
        COM_accessLog("User {$_USER['username']} tried to delete comment (cid = {$cid}) and failed CSRF checks.");
        $retval = COM_refresh($_CONF['site_admin_url'] . '/index.php');
    } else {
        if (DB_count($_TABLES['comments'], array('cid', 'sid', 'type'), array($cid, $sid, $type)) == 1) {
            $result = CMT_deleteComment($cid, $sid, $type);

            if ($result == 0) {
                $retval = COM_refresh($_CONF['site_admin_url'] . '/comment.php?msg=130');
            }
        } else {
            // Failed to delete a comment
            $retval = $LANG03[101];
        }
    }

    return $retval;
}

/**
 * Approve a comment
 */
function approveComments()
{
    $cids = getCids();

    if (count($cids) > 0) {
        foreach ($cids as $cid) {
            CMT_approveModeration($cid);
        }
    }
}

/**
 * Ban users
 */
function banUsers() {
    global $_TABLES, $_USER;

    $cids = getCids();

    if (count($cids) > 0) {
        $currentUid = $_USER['uid'];
        $sql = "SELECT uid FROM {$_TABLES['comments']} "
            . "WHERE (uid <> 1) AND (uid <> {$currentUid}) AND "
            . " (cid IN (" . implode(',', $cids) . "))";
        $result = DB_query($sql);
        $uids = array();

        while (($A = DB_fetchArray($result, false)) !== false) {
            $uids[] = $A['uid'];
        }

        if (count($uids) > 0) {
            $sql = "UPDATE {$_TABLES['users']} SET status = " . USER_ACCOUNT_DISABLED
                . " WHERE (uid IN (" . implode(',', $uids) . "))";
            DB_query($sql);
        }
    }
}

/**
 * Ban IP Addresses being selected with the Spamx plugin
 *
 * @return bool  true = success, false = otherwise
 */
function banIpAddresses() {
    global $_PLUGINS, $_TABLES;

    $retval = false;

    if (!in_array('spamx', $_PLUGINS)) {
        COM_errorLog(__FUNCTION__ . ': Spmax plugin is not installed or disabled.');
        return $retval;
    }

    $cids = getCids();

    if (count($cids) > 0) {
        $sql = "SELECT DISTINCT ipaddress FROM {$_TABLES['comments']} "
            . "WHERE (ipaddress NOT LIKE '192.168.%') AND (ipaddress <> '::1') AND "
            . " (cid IN (" . implode(',', $cids) . "))";
        $result = DB_query($sql);

        if (!DB_error()) {
            $ipAddresses = array();

            while (($A = DB_fetchArray($result, false)) !== false) {
                $ipAddresses[] = $A['ipaddress'];
            }

            foreach ($ipAddresses as $ipAddress) {
                $sql = "INSERT INTO {$_TABLES['spamx']} (name, value) "
                    . "VALUES ('IP', '" .  DB_escapeString($ipAddress) . "')";
                DB_query($sql);
            }

            $retval = true;
        }
    }

    return $retval;
}

// MAIN
$action = $_FINPUT->post('bulk_action', '');

switch ($action) {
    case 'bulk_approve':
        approveComments();
        break;

    case 'bulk_delete':
        deleteComments();
        break;

    case 'bulk_ban_user':
        banUsers();
        break;

    case 'bulk_ban_ip_address':
        banIpAddresses();
        break;

    default:
        // Do nothing here
        break;
}

$content = COM_showMessageFromParameter() . listComments();
$display = COM_createHTMLDocument($content, array('pagetitle' => $LANG03[100]));
COM_output($display);
