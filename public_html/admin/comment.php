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
 * Field function
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $iconArray
 * @param  string $extra
 * @return string
 */
function ADMIN_getListField_comments($fieldName, $fieldValue, $A, $iconArray, $extra = '')
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG03, $_IMAGE_TYPE, $securityToken;

    switch ($fieldName) {
        case 'edit':
            $cid = $A['cid'];
            $fieldValue = '<input type="checkbox" name="cids[]" value="' . $cid . '"' . XHTML . '>';
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
    global $_CONF, $_PLUGINS, $_SCRIPTS, $_TABLES, $_FINPUT, $LANG_ADMIN, $LANG03, $_IMAGE_TYPE, $securityToken;

    require_once $_CONF['path_system'] . 'lib-admin.php';

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
            $_CONF['layout_url'] . '/images/icons/trackback.' . $_IMAGE_TYPE
        );

    // Regular Comments
    $headerArray = array(      # display 'text' and use table field 'field'
        array('text' => '<input type="checkbox" name="select_all" id="select_all"' . XHTML . '>', 'field' => 'edit', 'sort' => false),
        array('text' => 'Type', 'field' => 'type', 'sort' => true),
        array('text' => 'Sid', 'field' => 'sid', 'sort' => true),
        array('text' => 'Date', 'field' => 'date', 'sort' => true),
        array('text' => $LANG_ADMIN['title'], 'field' => 'title', 'sort' => true),
        array('text' => 'Comment', 'field' => 'comment', 'sort' => true),
        array('text' => 'Name', 'field' => 'name', 'sort' => true),
        array('text' => 'Uid', 'field' => 'uid', 'sort' => true),
        array('text' => 'IP Address', 'field' => 'ipaddress', 'sort' => true),
    );

    $defaultSortArray = array('field' => 'date', 'direction' => 'desc');

    $textArray = array(
        'has_extras' => true,
        'title'      => $LANG03[100],
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
        'query_fields'   => array('type', 'sid', 'date', 'title', 'comment', 'name', 'uid', 'ipaddress'),
        'default_filter' => $sqlForType . COM_getPermSql('AND'),
    );

    $filter = getTypeSelector($itemType);
    $options = array();
    $actionSelector = '<select name="bulk_action">' . LB
        . '<option value="bulk_delete">Delete</option>' . LB
        . '<option value="bulk_ban">Ban</option>' . LB
        . '</select>' . LB
        . '<input type="submit" name="submit" value="Execute"' . XHTML . '>';

    $formArray = array(
        'top'    => '',
        'bottom' => $actionSelector,
    );

    $retval .= ADMIN_list(
        'comments', 'ADMIN_getListField_comments', $headerArray, $textArray,
        $queryArray, $defaultSortArray, $filter, $securityToken, $options, $formArray
    );

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
    $_SCRIPTS->setJavaScript('jQuery("#select_all").on("change", function (e) {
        jQuery("input[name=cids\[\]]").checked = e.target.checked;
    });
    ');
    return $retval;
}

/**
 * Delete a comment
 *
 * @return   string          HTML redirect or error message
 */
function deleteComment()
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
 *
 * @param    int $cid id of comment to delete
 * @return   string          HTML redirect or error message
 */
function approveComment($cid = 0)
{
    $cid = intval($cid, 10);
    CMT_approveModeration($cid);
}

// MAIN
$mode = $_FINPUT->get('mode', $_INPUT->post('mode', ''));
$cid = $_FINPUT->get('cid' . $_FINPUT->post('cid', 0));
$cid = intval($cid, 10);

switch ($mode) {
    case $LANG_ADMIN['delete']:
        deleteComment();
        break;

    case $LANG_ADMIN['approve']:
        $content = '';

        if (SEC_checkToken()) {
            $content = approveComment($cid);
        }

        $content .= listComments();
        $display = COM_createHTMLDocument($content, array('pagetitle' => $LANG21[19]));
        break;

    default:// 'cancel' or no mode at all
        $content = COM_showMessageFromParameter()
            . listComments();
        $display = COM_createHTMLDocument($content, array('pagetitle' => $LANG21[19]));
        break;
}

COM_output($display);
