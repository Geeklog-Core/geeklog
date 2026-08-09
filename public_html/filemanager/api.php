<?php

/* Geeklog-controlled JSON endpoint for the native Media Library. */

global $_USER;

require_once dirname(__DIR__) . '/lib-common.php';
require_once $_CONF['path_system'] . 'classes/Media/MediaValidator.php';
require_once $_CONF['path_system'] . 'classes/Media/MediaStorage.php';
require_once $_CONF['path_system'] . 'classes/Media/MediaLibrary.php';

use Geeklog\Media\MediaLibrary;
use Geeklog\Session;

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');

function mediaResponse($payload, $status = 200)
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_SLASHES);
    exit;
}
function mediaRequestValue($name, $default = '')
{
    if (isset($_POST[$name]) && is_string($_POST[$name])) {
        return $_POST[$name];
    }
    if (isset($_GET[$name]) && is_string($_GET[$name])) {
        return $_GET[$name];
    }
    return $default;
}

/**
 * Issue the next one-time Geeklog token for the Media Library page URL.
 * SEC_createToken() binds tokens to the current API URL, while Geeklog's token
 * validator expects the browser Referer (the Media Library page), so the token
 * row has to be created for that already-validated Referer explicitly.
 */
function mediaCreateTokenForReferer()
{
    global $_CONF, $_TABLES, $_USER;

    $uid = isset($_USER['uid']) ? (int) $_USER['uid'] : 1;
    $referer = isset($_SERVER['HTTP_REFERER']) ? (string) $_SERVER['HTTP_REFERER'] : '';
    if ($uid <= 1 || $referer === '') {
        throw new RuntimeException('A new security token could not be created.');
    }

    $refererParts = parse_url($referer);
    $siteParts = parse_url($_CONF['site_url']);
    if (!is_array($refererParts) || !is_array($siteParts)
        || !isset($refererParts['scheme'], $refererParts['host'], $refererParts['path'])
        || !isset($siteParts['scheme'], $siteParts['host'])) {
        throw new RuntimeException('The Media Library request origin is invalid.');
    }
    $expectedPath = rtrim(isset($siteParts['path']) ? $siteParts['path'] : '', '/')
        . '/filemanager/index.php';
    $defaultPort = strtolower($siteParts['scheme']) === 'https' ? 443 : 80;
    $refererPort = isset($refererParts['port']) ? (int) $refererParts['port'] : $defaultPort;
    $sitePort = isset($siteParts['port']) ? (int) $siteParts['port'] : $defaultPort;
    if (strcasecmp($refererParts['scheme'], $siteParts['scheme']) !== 0
        || strcasecmp($refererParts['host'], $siteParts['host']) !== 0
        || $refererPort !== $sitePort
        || $refererParts['path'] !== $expectedPath) {
        throw new RuntimeException('The Media Library request origin is invalid.');
    }

    $token = md5($uid . $referer . uniqid((string) mt_rand(), true));
    $escapedReferer = DB_escapeString($referer);
    DB_query("DELETE FROM {$_TABLES['tokens']} WHERE owner_id = '{$uid}' AND urlfor = '{$escapedReferer}'");
    DB_query("INSERT INTO {$_TABLES['tokens']} (token, created, owner_id, urlfor, ttl) "
        . "VALUES ('{$token}', NOW(), {$uid}, '{$escapedReferer}', 1200)");
    Session::setVar('uid_to_check', $uid);

    return $token;
}

try {
    $nextToken = null;
    $library = MediaLibrary::fromGeeklog();
    $action = strtolower(mediaRequestValue('action', 'list'));
    $type = ucfirst(strtolower(mediaRequestValue('type', 'File')));
    if (!in_array($type, ['Image', 'File', 'Media', 'Root'], true)) {
        throw new RuntimeException('Invalid media type.');
    }

    if ($action === 'list') {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            mediaResponse(['ok' => false, 'error' => 'Method not allowed.'], 405);
        }
        mediaResponse([
            'ok' => true,
            'data' => $library->storage()->listDirectory(mediaRequestValue('path'), $type),
            'csrfToken' => mediaCreateTokenForReferer(),
        ]);
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        mediaResponse(['ok' => false, 'error' => 'Method not allowed.'], 405);
    }
    if (!$library->canWrite()) {
        throw new RuntimeException('The Media Library is in browse-only mode.');
    }
    // SEC_checkToken() renders an HTML reauthentication page on failure. API
    // clients require a JSON response, so use Geeklog's underlying validator.
    if (!SECINT_checkToken()) {
        COM_accessLog("User {$_USER['username']} failed a Media Library CSRF check.");
        COM_errorLog("Media Library CSRF validation failed for user {$_USER['username']}.");
        mediaResponse(['ok' => false, 'error' => 'The security token is invalid or expired.'], 403);
    }
    $nextToken = mediaCreateTokenForReferer();

    switch ($action) {
        case 'upload':
            if (!isset($_FILES['upload']) || !is_array($_FILES['upload'])) {
                throw new RuntimeException('No upload was received.');
            }
            $library->storage()->upload(mediaRequestValue('path'), $_FILES['upload'], $type);
            break;

        case 'mkdir':
            if (!$library->canCreateDirectory()) {
                mediaResponse(['ok' => false, 'error' => 'You cannot create folders.'], 403);
            }
            $library->storage()->createDirectory(mediaRequestValue('path'), mediaRequestValue('name'));
            break;

        case 'rename':
            $library->storage()->renameItem(
                mediaRequestValue('path'),
                mediaRequestValue('name'),
                $type
            );
            break;

        case 'delete':
            $library->storage()->deleteItem(mediaRequestValue('path'));
            break;

        default:
            mediaResponse(['ok' => false, 'error' => 'Unknown action.'], 400);
    }

    mediaResponse(['ok' => true, 'csrfToken' => $nextToken]);
} catch (RuntimeException $e) {
    $actionForLog = isset($action) ? $action : 'initialization';
    $usernameForLog = isset($_USER['username']) ? $_USER['username'] : '(unknown)';
    COM_errorLog("Media Library {$actionForLog} failed for user {$usernameForLog}: " . $e->getMessage());
    $response = ['ok' => false, 'error' => $e->getMessage()];
    if (!empty($nextToken)) {
        $response['csrfToken'] = $nextToken;
    }
    mediaResponse($response, 400);
} catch (Throwable $e) {
    COM_errorLog('Media Library request failed: ' . $e->getMessage());
    $response = ['ok' => false, 'error' => 'The Media Library could not complete the request.'];
    if (!empty($nextToken)) {
        $response['csrfToken'] = $nextToken;
    }
    mediaResponse($response, 500);
}
