<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | router.php                                                                |
// |                                                                           |
// | Geeklog URL routing administration.                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2016-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - mystralkk AT gmail DOT com                   |
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
 * URL routing administration page: Create, edit, delete routing rules
 * for your Geeklog site.
 */

use Geeklog\Input;

// Geeklog common function library
require_once '../lib-common.php';

// Security check to ensure user even belongs on this page
require_once './auth.inc.php';

if (!SEC_inGroup('Root')) {
    $content = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument(
        $content,
        array('pagetitle' => $MESSAGE[30])
    );
    COM_accessLog("User {$_USER['username']} tried to illegally access the URL routing administration screen");
    COM_output($display);
    exit;
}

/**
 * Shows the URL routing editor
 * This will show a URL routing edit form.
 *
 * @param    int $rid ID of URL routing rule to edit
 * @return   string          HTML for URL routing editor
 */
function getRouteEditor($rid = 0)
{
    global $_CONF, $_TABLES, $LANG_ROUTER, $LANG_ADMIN, $MESSAGE, $securityToken;

    $retval = '';

    $A = array(
        'rid'         => $rid,
        'method'      => Router::HTTP_REQUEST_GET,
        'rule'        => '',
        'route'       => '',
        'status_code' => Router::DEFAULT_STATUS_CODE,
        'priority'    => Router::DEFAULT_PRIORITY,
        'enabled'     => 1
    );
    $rid = intval($rid, 10);

    if ($rid > 0) {
        if (DB_count($_TABLES['routes'], 'rid', $rid) == 1) {
            $sql = "SELECT * FROM {$_TABLES['routes']} WHERE rid =" . DB_escapeString($rid);
            $result = DB_query($sql);
            $A = DB_fetchArray($result);
        } else {
            // Non-existent route
            $rid = 0;
            $A['rid'] = $rid;
        }
    }

    $T = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'admin/router'));
    $T->set_file('editor', 'routereditor.thtml');
    $routerStart = COM_startBlock($LANG_ROUTER[10], '', COM_getBlockTemplate('_admin_block', 'header'))
        . LB . SEC_getTokenExpiryNotice($securityToken);
    $T->set_var('start_router_editor', $routerStart);

    if ($rid > 0) {
        $T->set_var('allow_delete', true);
    }
    
    if ($A['enabled'] == 1) {
        $enabled = 'checked="checked"';
    } else {
        $enabled = '';
    }
    
    $T->set_var(array(
        'rid'          => $A['rid'],
        'method'       => $A['method'],
        'rule'         => $A['rule'],
        'route'        => $A['route'],
        'status_code'  => $A['status_code'],
        'priority'     => $A['priority'],
        'enabled'     => $enabled,
        'gltoken_name' => CSRF_TOKEN,
        'gltoken'      => $securityToken,
    ));

    $A['method'] = (int) $A['method'];
    $T->set_var(array(
        'get_selected'    => ($A['method'] === Router::HTTP_REQUEST_GET ? ' selected="selected"' : ''),
        'post_selected'   => ($A['method'] === Router::HTTP_REQUEST_POST ? ' selected="selected"' : ''),
        'put_selected'    => ($A['method'] === Router::HTTP_REQUEST_PUT ? ' selected="selected"' : ''),
        'delete_selected' => ($A['method'] === Router::HTTP_REQUEST_DELETE ? ' selected="selected"' : ''),
        'head_selected'   => ($A['method'] === Router::HTTP_REQUEST_HEAD ? ' selected="selected"' : ''),
    ));

    $A['status_code'] = (int) $A['status_code'];
    $T->set_var(array(
        'status200_selected' => ($A['status_code'] === 200 ? ' selected="selected"' : ''),
        'status300_selected' => ($A['status_code'] === 300 ? ' selected="selected"' : ''),
        'status301_selected' => ($A['status_code'] === 301 ? ' selected="selected"' : ''),
        'status302_selected' => ($A['status_code'] === 302 ? ' selected="selected"' : ''),
        'status303_selected' => ($A['status_code'] === 303 ? ' selected="selected"' : ''),
        'status304_selected' => ($A['status_code'] === 304 ? ' selected="selected"' : ''),
        'status305_selected' => ($A['status_code'] === 305 ? ' selected="selected"' : ''),
        'status307_selected' => ($A['status_code'] === 307 ? ' selected="selected"' : ''),
        'status308_selected' => ($A['status_code'] === 308 ? ' selected="selected"' : ''),
    ));
    $T->set_var(array(
        'lang_router_rid'         => $LANG_ROUTER[3],
        'lang_router_method'      => $LANG_ROUTER[4],
        'lang_router_rule'        => $LANG_ROUTER[5],
        'lang_router_route'       => $LANG_ROUTER[6],
        'lang_router_status_code' => $LANG_ROUTER[21],
        'lang_router_priority'    => $LANG_ROUTER[7],
        'lang_enabled'            => $LANG_ROUTER[22],
        'lang_router_notice'      => $LANG_ROUTER[20],
        'lang_save'               => $LANG_ADMIN['save'],
        'lang_cancel'             => $LANG_ADMIN['cancel'],
        'lang_delete'             => $LANG_ADMIN['delete'],
        'confirm_message'         => $MESSAGE[76],
    ));

    $T->set_var(
        'end_block',
        COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'))
    );
    $T->parse('output', 'editor');
    $retval .= $T->finish($T->get_var('output'));
    CTL_clearCache();

    return $retval;
}

/**
 * Field function
 *
 * @param string $fieldName
 * @param string $fieldValue
 * @param array  $A
 * @param array  $iconArray
 * @param string $extra
 * @return string
 * @throws InvalidArgumentException
 */
function ADMIN_getListFieldRoutes($fieldName, $fieldValue, $A, $iconArray, $extra = '')
{
    global $_CONF, $LANG_ROUTER, $_IMAGE_TYPE, $securityToken;

    switch ($fieldName) {
        case 'rid':
            $fieldValue = '<a href="' . $_CONF['site_admin_url'] . '/router.php?mode=edit&amp;rid=' . $fieldValue . '">'
                . $iconArray['edit'] . '</a>';
            break;

        case 'method':
            switch (intval($fieldValue, 10)) {
                case Router::HTTP_REQUEST_GET:
                    $fieldValue = 'GET';
                    break;

                case Router::HTTP_REQUEST_POST:
                    $fieldValue = 'POST';
                    break;

                case Router::HTTP_REQUEST_PUT:
                    $fieldValue = 'PUT';
                    break;

                case Router::HTTP_REQUEST_DELETE:
                    $fieldValue = 'DELETE';
                    break;

                case Router::HTTP_REQUEST_HEAD:
                    $fieldValue = 'HEAD';
                    break;

                default:
                    throw new InvalidArgumentException(__FUNCTION__ . ': unknown method "' . $fieldValue . '" was given');
            }

            break;

        case 'rule':
            break;

        case 'route':
            break;

        case 'status_code':
            break;

        case 'priority':
            $rid = $A['rid'];
            $baseUrl = $_CONF['site_admin_url'] . '/router.php?mode=move&amp;rid=' . $rid . '&amp;'
                . CSRF_TOKEN . '=' . $securityToken;
            $fieldValue = '<a href="' . $baseUrl . '&amp;dir=up" title="' . $LANG_ROUTER[8] . '">'
                . '<img src="' . $_CONF['layout_url'] . '/images/admin/up.' . $_IMAGE_TYPE . '" alt="' . $LANG_ROUTER[8] . '"'
                . XHTML . '></a>'
                . $fieldValue
                . '<a href="' . $baseUrl . '&amp;dir=down" title="' . $LANG_ROUTER[9] . '">'
                . '<img src="' . $_CONF['layout_url'] . '/images/admin/down.' . $_IMAGE_TYPE . '" alt="' . $LANG_ROUTER[9] . '"'
                . XHTML . '></a>';
            break;
            
        case 'enabled':
            $fieldValue = COM_createControl('type-checkbox', array(
                'name' => 'enabledroutes[]',
                'value' => $A['rid'],
                'checked' => ($A['enabled'] == 1) ? true : '',
                'onclick' => 'submit()'
            ));
            $fieldValue .= '<input type="hidden" name="visibleroutes[]" value="' . $A['rid'] . '"' . XHTML . '>';        
            break;
            
        default:
            throw new InvalidArgumentException(__FUNCTION__ . ': unknown field name "' . $fieldName . '" was given');
    }

    return $fieldValue;
}

/**
 * Display a list of routes
 *
 * @return   string  HTML for the list
 */
function listRoutes()
{
    global $_CONF, $_TABLES, $LANG_ADMIN, $LANG_ROUTER, $_IMAGE_TYPE, $securityToken;

    require_once $_CONF['path_system'] . 'lib-admin.php';

    // Writing the menu on top
    $menu_arr = array(
        array(
            'url'  => $_CONF['site_admin_url'] . '/router.php?mode=edit&amp;rid=0',
            'text' => $LANG_ADMIN['create_new'],
        ),
        array(
            'url'  => $_CONF['site_admin_url'],
            'text' => $LANG_ADMIN['admin_home'],
        ),
    );

    $notice = $LANG_ROUTER[11];

    if (!isset($_CONF['url_rewrite']) || empty($_CONF['url_rewrite'])) {
        $notice .= ' ' . $LANG_ROUTER[18];
    }

    if (!isset($_CONF['url_routing']) || ($_CONF['url_routing'] == Router::ROUTING_DISABLED)) {
        $notice .= ' ' . $LANG_ROUTER[19];
    }

    $help_url = COM_getDocumentUrl('docs', "config.html");
    $help_url .= "#url-routing";
    
    $retval = COM_startBlock($LANG_ROUTER[2], $help_url, COM_getBlockTemplate('_admin_block', 'header'))
        . ADMIN_createMenu(
            $menu_arr,
            $notice,
            $_CONF['layout_url'] . '/images/icons/router.' . $_IMAGE_TYPE
        );

    $headerArray = array(      # display 'text' and use table field 'field'
        array(
            'text'  => $LANG_ADMIN['edit'],
            'field' => 'rid',
            'sort'  => false,
        ),
        array(
            'text'  => $LANG_ROUTER[4],
            'field' => 'method',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG_ROUTER[5],
            'field' => 'rule',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG_ROUTER[6],
            'field' => 'route',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG_ROUTER[21],
            'field' => 'status_code',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG_ROUTER[7],
            'field' => 'priority',
            'sort'  => true,
        ),
        array(
            'text'  => $LANG_ROUTER[22],
            'field' => 'enabled',
            'sort'  => true,
        )        
    );

    $defaultSortArray = array(
        'field'     => 'priority',
        'direction' => 'asc',
    );

    $textArray = array(
        'has_extras' => false,
        'title'      => $LANG_ROUTER[1],
        'form_url'   => $_CONF['site_admin_url'] . '/router.php',
    );

    $queryArray = array(
        'table'          => 'routes',
        'sql'            => "SELECT * FROM {$_TABLES['routes']} WHERE (1 = 1) ",
        'query_fields'   => array('rule', 'route', 'status_code', 'priority', 'enabled'),
        'default_filter' => COM_getPermSql('AND'),
    );
    
    $formArray = array(
        'top'    => '<input type="hidden" name="' . CSRF_TOKEN . '" value="'
            . $securityToken . '"' . XHTML . '>',
        'bottom' => '<input type="hidden" name="routeenabler" value="1"'
            . XHTML . '>',
    );    

    $retval .= ADMIN_list(
        'routes', 'ADMIN_getListFieldRoutes', $headerArray, $textArray,
        $queryArray, $defaultSortArray, '', $securityToken, '', $formArray
    );

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

/**
 * Save a route into database
 *
 * @param  int    $rid
 * @param  int    $method
 * @param  string $rule
 * @param  string $route
 * @param  int    $statusCode
 * @param  int    $priority
 * @return string
 */
function saveRoute($rid, $method, $rule, $route, $statusCode, $priority, $enabled)
{
    global $_CONF, $_TABLES, $MESSAGE, $LANG_ROUTER;

    $messageText = '';

    $rid = intval($rid, 10);
    $method = intval($method, 10);
    $rule = trim($rule);
    $route = trim($route);
    $statusCode = (int) trim($statusCode);
    $priority = intval($priority, 10);

    if (($method < Router::HTTP_REQUEST_GET) || ($method > Router::HTTP_REQUEST_HEAD)) {
        $messageText = $LANG_ROUTER[12];
    } elseif ($rule === '') {
        $messageText = $LANG_ROUTER[13];
    } elseif ($route === '') {
        $messageText = $LANG_ROUTER[14];
    } elseif (substr_count($rule, '@') !== substr_count($route, '@')) {
        $messageText = $LANG_ROUTER[15];
    }

    // If a rule doesn't begin with a slash, then add one silently
    if (strpos($rule, '/') !== 0) {
        $rule = '/' . $rule;
    }

    // If a rule starts with "/index.php", then remove it silently
    if (stripos($rule, '/index.php') === 0) {
        $rule = preg_replace('|^/index\.php|i', '', $rule);
    }

    // If a route doesn't begin with a slash, then add one silently
    if (strpos($route, '/') !== 0) {
        $route = '/' . $route;
    }

    // If a route starts with "/index.php/", then make it an error to prevent the script
    // from going an infinite loop
    if (stripos($route, '/index.php/') === 0) {
        $messageText = $LANG_ROUTER[16];
    }

    // Replace &amp; with &
    $rule = str_ireplace('&amp;', '&', $rule);
    $route = str_ireplace('&amp;', '&', $route);

    // Check if placeholders are the same
    $numPlaceHoldersInRule = preg_match_all(Router::PLACEHOLDER_MATCH, $rule, $matchesRule, PREG_SET_ORDER);
    $numPlaceHoldersInRoute = preg_match_all(Router::PLACEHOLDER_MATCH, $route, $matchesRoute, PREG_SET_ORDER);

    if ($numPlaceHoldersInRule === $numPlaceHoldersInRoute) {
        if ($numPlaceHoldersInRule > 0) {
            array_shift($matchesRule);
            array_shift($matchesRoute);

            foreach ($matchesRule as $r) {
                if (!in_array($r, $matchesRoute)) {
                    $messageText = $LANG_ROUTER[15];
                    break;
                }
            }
        }
    } else {
        $messageText = $LANG_ROUTER[15];
    }

    // If HTTP status code is out of range, then fix it silently
    if (($statusCode < 200) || ($statusCode > 308)) {
        $statusCode = Router::DEFAULT_STATUS_CODE;
    }

    // If priority is out of range, then fix it silently
    if (($priority < 1) || ($priority > 65535)) {
        $priority = Router::DEFAULT_PRIORITY;
    }
    
    if ($enabled === 'on') {
        $enabled = 1;
    } else {
        $enabled = 0;
    }
        
//    $A['is_enabled'] = ($_POST['is_enabled'] == 'on') ? 1 : 0;

    if ($messageText !== '') {
        $content = COM_showMessageText($messageText, $MESSAGE[122]) . getRouteEditor($rid);
        $retval = COM_createHTMLDocument(
            $content,
            array(
                'pagetitle' => $MESSAGE[122],
            )
        );

        return $retval;
    }

    // Save data into database
    $rid = DB_escapeString($rid);
    $method = DB_escapeString($method);
    $rule = DB_escapeString($rule);
    $route = DB_escapeString($route);
    $statusCode = DB_escapeString($statusCode);
    $priority = DB_escapeString($priority);

    $count = intval(DB_count($_TABLES['routes'], 'rid', $rid), 10);

    if ($count === 0) {
        $sql = "INSERT INTO {$_TABLES['routes']} (rid, method, rule, route, status_code, priority, enabled) "
            . "VALUES (NULL, {$method}, '{$rule}', '{$route}', {$statusCode}, {$priority}, {$enabled})";
    } else {
        $sql = "UPDATE {$_TABLES['routes']} "
            . "SET method = {$method}, rule = '{$rule}', route = '{$route}', status_code = {$statusCode}, priority = {$priority}, enabled = {$enabled} "
            . "WHERE rid = {$rid} ";
    }

    for ($i = 0; $i < 5; $i++) {
        DB_query($sql);

        if (!DB_error()) {
            reorderRoutes();
            COM_redirect($_CONF['site_admin_url'] . '/router.php?msg=121');
        }

        // Retry
    }

    $content = COM_showMessageText($LANG_ROUTER[17], DB_error()) . getRouteEditor($rid);
    $retval = COM_createHTMLDocument(
        $content,
        array(
            'pagetitle' => $MESSAGE[122],
        )
    );

    return $retval;
}

/**
 * Re-orders all routes in increments of 10
 */
function reorderRoutes()
{
    global $_TABLES;

    $sql = "SELECT rid FROM {$_TABLES['routes']} ORDER BY priority";
    $result = DB_query($sql);
    $rids = array();

    while (($A = DB_fetchArray($result, false)) !== false) {
        $rids[] = intval($A['rid'], 10);
    }

    $priority = 100;
    $step = 10;

    foreach ($rids as $rid) {
        $sql = "UPDATE {$_TABLES['routes']} SET priority = " . DB_escapeString($priority)
            . " WHERE rid = " . DB_escapeString($rid);
        DB_query($sql);
        $priority += $step;
    }

    // Clear the cache once reordered so any updated urls can be refreshed
    // reorderRoutes is called by save and delete so it covers those instances as well
    CTL_clearCache();
}

/**
 * Move a route UP or Down
 *
 * @param int $rid
 */
function moveRoute($rid)
{
    global $_TABLES;

    $rid = intval($rid, 10);
    $direction = Input::fGet('dir', '');

    // if the router id exists
    if (DB_count($_TABLES['routes'], 'rid', $rid)) {
        $rid = DB_escapeString($rid);

        if ($direction === 'up') {
            $sql = "UPDATE {$_TABLES['routes']} SET priority = priority - 11 WHERE rid = " . $rid;
            DB_query($sql);
            reorderRoutes();
        } elseif ($direction === 'down') {
            $sql = "UPDATE {$_TABLES['routes']} SET priority = priority + 11 WHERE rid = " . $rid;
            DB_query($sql);
            reorderRoutes();
        }
    } else {
        COM_errorLog("block admin error: Attempt to move an non-existing route id: {$rid}");
    }
}

/**
 * Enable and Disable routes
 *
 * @param    array $enabledRoutes array containing ids of enabled routes
 * @param    array $visibleRoutes array containing ids of visible routes
 * @return   void
 */
function changeRouteStatus($enabledRoutes, $visibleRoutes)
{
    global $_TABLES;

    $disabled = array_diff($visibleRoutes, $enabledRoutes);

    // disable routes
    $in = implode(',', $disabled);
    if (!empty($in)) {
        $sql = "UPDATE {$_TABLES['routes']} SET enabled = 0 WHERE rid IN ($in)";
        DB_query($sql);
    }

    // enable routes
    $in = implode(',', $enabledRoutes);
    if (!empty($in)) {
        $sql = "UPDATE {$_TABLES['routes']} SET enabled = 1 WHERE rid IN ($in)";
        DB_query($sql);
    }
}

/**
 * Delete a route
 *
 * @param    int $rid id of block to delete
 */
function deleteRoute($rid)
{
    global $_CONF, $_TABLES;

    $rid = intval($rid, 10);
    DB_delete($_TABLES['routes'], 'rid', $rid);
    reorderRoutes();
    COM_redirect($_CONF['site_admin_url'] . '/router.php?msg=123');
}

// MAIN
$display = '';

$mode = Input::fGet('mode', Input::fPost('mode', ''));
$rid = Input::fGet('rid', Input::fPost('rid', 0));
$rid = intval($rid, 10);

if (isset($_POST['routeenabler']) && SEC_checkToken()) {
    $enabledRoutes = Geeklog\Input::post('enabledroutes', array());
    $visibleRoutes = Geeklog\Input::post('visibleroutes', array());
    changeRouteStatus($enabledRoutes, $visibleRoutes);
}

$securityToken = SEC_createToken();

switch ($mode) {
    case $LANG_ADMIN['delete']:
        if ($rid === 0) {
            COM_errorLog('Attempted to delete route, rid empty or null, value =' . $rid);
            COM_redirect($_CONF['site_admin_url'] . '/router.php');
        } elseif (SEC_checkToken()) {
            deleteRoute($rid);
        } else {
            COM_accessLog("User {$_USER['username']} tried to illegally delete route {$rid} and failed CSRF checks.");
            COM_redirect($_CONF['site_admin_url'] . '/index.php');
        }

        break;

    case $LANG_ADMIN['save']:
        if (!SEC_checkToken()) {
            COM_accessLog("User {$_USER['username']} tried to illegally save route {$rid} and failed CSRF checks.");
            COM_redirect($_CONF['site_admin_url'] . '/index.php');
        }

        $method = Input::fPost('method', '');
        $rule = Input::post('rule', '');
        $route = Input::post('route', '');
        $statusCode = (int) Input::fPost('status_code', 302);
        $priority = Input::fPost('priority', Router::DEFAULT_PRIORITY);
        $enabled = Input::fPost('enabled', '');
        $display = saveRoute($rid, $method, $rule, $route, $statusCode, $priority, $enabled);
        break;

    case 'edit':
        $content = getRouteEditor($rid);
        $display = COM_createHTMLDocument($content, array('pagetitle' => $LANG_ROUTER[2]));
        break;

    case 'move':
        if (SEC_checkToken()) {
            moveRoute($rid);
        }

        $content = listRoutes();
        $display = COM_createHTMLDocument($content, array('pagetitle' => $LANG_ROUTER[2]));
        break;

    default:  // 'cancel' or no mode at all
        $content = COM_showMessageFromParameter() . listRoutes();
        $display = COM_createHTMLDocument($content, array('pagetitle' => $LANG_ROUTER[2]));
}

COM_output($display);
