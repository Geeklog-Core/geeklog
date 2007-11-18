<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | lib-webservices.php                                                       |
// |                                                                           |
// | WS-related functions needed in more than one place.                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Authors: Ramnath R Iyer        - rri AT silentyak DOT com                 |
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
// $Id: lib-webservices.php,v 1.17 2007/11/18 09:28:31 dhaun Exp $

if (strpos ($_SERVER['PHP_SELF'], 'lib-webservices.php') !== false) {
    die ('This file can not be used on its own!');
}

$WS_PLUGIN    = '';
$WS_INTROSPECTION = false;
$WS_TEXT = '';
$WS_ATOM_NS = 'http://www.w3.org/2005/Atom';
$WS_APP_NS  = 'http://www.w3.org/2007/app';
$WS_EXTN_NS = 'http://www.geeklog.net';

// Set = true to enable verbose logging (in error.log)
$WS_VERBOSE = false;

if (!isset($WS_DISABLED)) {
    $WS_DISABLED = false;
}

/* Check for PHP5 */
if (PHP_VERSION < 5) {
    $WS_DISABLED = true;
}

/**
 * Displays an error message with the appropriate HTTP error-code
 *
 * @param   string  $error_name     the name of the error
 * @param   string  $error_desc     a short description of the actual error (optional)
 */
function WS_error($error_code, $error_desc = '')
{
    global $WS_VERBOSE;

    header('Content-type: ' . 'text/html' . '; charset=UTF-8');
    switch ($error_code) {
    case PLG_RET_PRECONDITION_FAILED:
        header($_SERVER['SERVER_PROTOCOL'] . ' 412 Precondition Failed');
        break;
    case PLG_RET_PERMISSION_DENIED:
        header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
        break;
    case PLG_RET_AUTH_FAILED:
        header($_SERVER['SERVER_PROTOCOL'] . ' 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="www.geeklog.net"');
        break;
    case PLG_RET_ERROR:
        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
        break;
    }

    if ($WS_VERBOSE) {
        COM_errorLog("WS: Error $error_code ('$error_desc')");
    }

    // Output exact error message here
    echo trim($error_desc);
    exit();
}

/**
 * Dissects the URI and obtains parameters
 *
 * @param   array   $args       the array to store any input parameters
 */
function WS_dissectURI(&$args)
{
    global $WS_PLUGIN, $WS_INTROSPECTION, $WS_VERBOSE;

    $WS_PLUGIN = '';
    $args = array();

    if ($WS_VERBOSE) {
        COM_errorLog("WS: Dissecting URI '" . $_SERVER['QUERY_STRING'] . "'");
    }

    $uri_parts = explode('&', $_SERVER['QUERY_STRING']);
    foreach ($uri_parts as $param) {
        $uri_parts = explode('=', $param);
        $param_key = COM_applyFilter($uri_parts[0]);
        if (count($uri_parts) > 1) {
            $param_val = COM_applyFilter($uri_parts[1]);
        }

        switch ($param_key) {
        case 'introspection':
                $WS_INTROSPECTION = true;
        case 'plugin':
            if (!empty($param_val)) {
                $WS_PLUGIN = $param_val;
            }
            break;
        default:
            if (!empty($param_val)) {
                $args[$param_key] = $param_val;
            }
            break;
        }
    }
}

/**
 * Handles the POST request
 */
function WS_post()
{
    global $WS_PLUGIN, $WS_ATOM_NS, $WS_APP_NS, $WS_EXTN_NS, $WS_VERBOSE,
           $_CONF;

    if ($WS_VERBOSE) {
        COM_errorLog("WS: POST request received");
    }

    WS_dissectURI($args);

    $args['category'] = array();

    WS_xmlToArgs($args);

    /* The default action is submit */
    if (empty($args['action'])) {
        $action = 'submit';
    }

    // @TODO Store array $args
    // object id has already been stored from the URI

    /* Indicates that the method are being called by the webservice */
    $args['gl_svc'] = true;

    // Call PLG_invokeService here
    $ret = PLG_invokeService($WS_PLUGIN, $action, $args, $out, $svc_msg);

    if ($ret == PLG_RET_OK) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
        header('Location: ' . $_CONF['site_url'] . '/webservices/atom/?plugin=' . $WS_PLUGIN . '&id' . '=' . $svc_msg['id']);
        // Output the actual object here
        return;
    }

    WS_error($ret, $svc_msg['error_desc']);
}

/**
 * Handles the PUT request
 */
function WS_put()
{
    global $WS_PLUGIN, $WS_ATOM_NS, $WS_APP_NS, $WS_EXTN_NS, $WS_VERBOSE,
           $_CONF;

    if ($WS_VERBOSE) {
        COM_errorLog("WS: PUT request received");
    }

    WS_dissectURI($args);

    WS_xmlToArgs($args);

    // @TODO Store array $args
    // object id has already been stored from the URI
    /* Indicates that the method are being called by the webservice */
    $args['gl_svc']  = true;
    $args['gl_edit'] = true;
    $args['gl_etag'] = trim($_SERVER['HTTP_IF_MATCH'], '"');

    // Call PLG_invokeService here
    $ret = PLG_invokeService($WS_PLUGIN, 'submit', $args, $out, $svc_msg);

    if ($ret == PLG_RET_OK) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        return;
    }

    WS_error($ret, $svc_msg['error_desc']);
}

/**
 * Handles the GET request
 */
function WS_get()
{
    global $WS_PLUGIN, $WS_INTROSPECTION, $WS_ATOM_NS, $WS_APP_NS, $WS_EXTN_NS,
           $WS_VERBOSE, $_CONF;

    if ($WS_VERBOSE) {
        COM_errorLog("WS: GET request received");
    }

    WS_dissectURI($args);

    if ($WS_INTROSPECTION) {

        header('Content-type: application/atomsvc+xml; charset=UTF-8');

        $atom_uri = $_CONF['site_url'] . '/webservices/atom/';

        /* 'story' is the default plugin */
        if (empty($WS_PLUGIN)) {
            $WS_PLUGIN = 'story';
        }

        $atom_uri .= '?plugin=' . $WS_PLUGIN;

        /* It might be simpler to do this part directly :-/ */

        $atom_doc = new DOMDocument('1.0', 'utf-8');
        $root_elem = $atom_doc->createElementNS($WS_APP_NS, 'app:service');
        $atom_doc->appendChild($root_elem);
        $atom_doc->createAttributeNS($WS_ATOM_NS, 'atom:service');
        $atom_doc->createAttributeNS($WS_EXTN_NS, 'gl:service');

        $workspace = $atom_doc->createElement('app:workspace');
        $root_elem->appendChild($workspace);

        $title = $atom_doc->createElement('atom:title', $_CONF['site_name']);
        $workspace->appendChild($title);

        $collection = $atom_doc->createElement('app:collection');
        $collection->setAttribute('href', $atom_uri);
        $workspace->appendChild($collection);

        $title = $atom_doc->createElement('atom:title', $WS_PLUGIN);
        $collection->appendChild($title);

        $entry = $atom_doc->createElement('app:accept',
                                          'application/atom+xml;type=entry');
        $collection->appendChild($entry);

        $categories = $atom_doc->createElement('app:categories');
        $categories->setAttribute('fixed', 'yes');
        $collection->appendChild($categories);

        $topics = array();
        $msg = array();
        $ret = PLG_invokeService($WS_PLUGIN, 'getTopicList', null, $topics, $msg);
        if ($ret == PLG_RET_OK) {
            foreach ($topics as $t) {
                $topic = $atom_doc->createElement('atom:category');
                $topic->setAttribute('term', htmlentities($t));
                $categories->appendChild($topic);
            }
        }

        WS_write($atom_doc->saveXML());

        return;
    }

    // @TODO Store array $args
    // object id has already been stored from the URI
    /* Indicates that the method is being called by the webservice */
    $args['gl_svc'] = true;

    $ret = PLG_invokeService($WS_PLUGIN, 'get', $args, $out, $svc_msg);

    if ($ret == PLG_RET_OK) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        header('Content-type: application/atom+xml; charset=UTF-8');
        // Output the actual object/objects here

        if (!$svc_msg['gl_feed']) {
            /* This is an entry, not a feed */
            $etag = trim($_SERVER['HTTP_IF_NONE_MATCH'], '"');
            if (!empty($etag) && ($out['updated'] == $etag)) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
                exit();
            } else {
                header('Etag: "' . $out['updated'] . '"');
            }
            $atom_doc = new DOMDocument('1.0', 'utf-8');

            $entry_elem = $atom_doc->createElementNS($WS_ATOM_NS, 'atom:entry');
            $atom_doc->appendChild($entry_elem);
            $atom_doc->createAttributeNS($WS_APP_NS, 'app:entry');
            $atom_doc->createAttributeNS($WS_EXTN_NS, 'gl:entry');

            WS_arrayToEntryXML($out, $svc_msg['output_fields'], $entry_elem, $atom_doc);
            WS_write($atom_doc->saveXML());
        } else {
            /* Output the feed here */
            $atom_doc = new DOMDocument('1.0', 'utf-8');

            $feed_elem = $atom_doc->createElementNS($WS_ATOM_NS, 'atom:feed');
            $atom_doc->appendChild($feed_elem);
            $atom_doc->createAttributeNS($WS_APP_NS, 'app:feed');
            $atom_doc->createAttributeNS($WS_EXTN_NS, 'gl:feed');

            $feed_id = $atom_doc->createElement('atom:id', $_CONF['site_name']);
            $feed_elem->appendChild($feed_id);

            $feed_title = $atom_doc->createElement('atom:title', $_CONF['site_name']);
            $feed_elem->appendChild($feed_title);

            $feed_updated = $atom_doc->createElement('atom:updated', date('c'));
            $feed_elem->appendChild($feed_updated);

            $feed_link = $atom_doc->createElement('atom:link');
            $feed_link->setAttribute('rel', 'self');
            $feed_link->setAttribute('type', 'application/atom+xml');
            $feed_link->setAttribute('href', $_CONF['site_url'] . '/webservices/atom/?plugin=' . htmlentities($WS_PLUGIN));
            $feed_elem->appendChild($feed_link);

            if (!empty($svc_msg['offset'])) {
                $next_link = $atom_doc->createElement('atom:link');
                $next_link->setAttribute('rel', 'next');
                $next_link->setAttribute('type', 'application/atom+xml');
                $next_link->setAttribute('href', $_CONF['site_url'] . '/webservices/atom/?plugin=' . htmlentities($WS_PLUGIN) . '&offset=' . $svc_msg['offset']);
                $feed_elem->appendChild($next_link);
            }

            foreach ($out as $entry_array) {
                $entry_elem = $atom_doc->createElement('atom:entry');
                WS_arrayToEntryXML($entry_array, $svc_msg['output_fields'], $entry_elem, $atom_doc);
                $feed_elem->appendChild($entry_elem);
            }

            WS_write($atom_doc->saveXML());
        }

        return;
    }

    WS_error($ret, $svc_msg['error_desc']);
}

/**
 * Handles the DELETE request
 */
function WS_delete()
{
    global $WS_PLUGIN, $WS_ATOM_NS, $WS_APP_NS, $WS_EXTN_NS, $WS_VERBOSE,
           $_CONF;

    if ($WS_VERBOSE) {
        COM_errorLog("WS: DELETE request received");
    }

    WS_dissectURI($args);

    // @TODO Store array $args
    // object id has already been stored from the URI

    /* Indicates that the method are being called by the webservice */
    $args['gl_svc'] = true;

    $ret = PLG_invokeService($WS_PLUGIN, 'delete', $args, $out, $svc_msg);

    if ($ret == PLG_RET_OK) {
            header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
            return;
    }

    WS_error($ret, $svc_msg['error_desc']);
}

/**
 * Get 'content', depending on the type
 *
 * @param   array      &$args       the array to which the content is to be appended
 * @param   object      $atom_doc   current DOMDocument
 * @param   object      $node       the 'content' node
 * @bugs    I guess we could at least support 'text/plain', 'text/html', etc.
 */
function WS_getContent(&$args, $atom_doc, $node)
{
    $type = (string) $node->getAttribute('type');
    if (empty($type)) {
        $type = 'text';
    }

    switch ($type) {
    case 'text':
        $args['content'] = (string) $node->nodeValue;
        $args['content_type'] = 'text';
        break;

    case 'html':
        $args['content'] = (string) $node->nodeValue;
        $args['content_type'] = 'html';
        break;

    case 'xhtml':
        /* The XHTML div element itself MUST NOT be considered part of the
         * content. -- RFC 4287, 3.1.1.3. XHTML
         */
        $div = $node->firstChild;
        if (($div->nodeName == 'div') || ($div->nodeName == 'xhtml:div')) {
            $args['content'] = '';
            foreach ($div->childNodes as $item) {
                $args['content'] .= $atom_doc->saveXML($item);
            }
            $args['content_type'] = 'html'; // it's all the same to us ...
        }
        break;

    default:
        // we can't handle any other types yet
        break;
    }
}

/**
 * Converts the input XML into an argument array
 *
 * @param   array      &$args       the array to which the arguments are to be appended
 */
function WS_xmlToArgs(&$args)
{
    global $_USER, $WS_EXTN_NS, $WS_ATOM_NS, $WS_APP_NS;

    /* Previous data in args is NOT deleted */

    @$atom_doc = new DOMDocument();
    if (!@$atom_doc->load('php://input')) {
        WS_error(PLG_RET_ERROR, 'Invalid XML document');
    }

    /* Get the entry */
    $entry_element = $atom_doc->getElementsByTagName('entry')->item(0);
    if ($entry_element == null) {
        WS_error(PLG_RET_ERROR, 'Invalid Atom entry');
    }

    /* Get the action, if it exists */
    $action_element = $entry_element->getElementsByTagNameNS($WS_EXTN_NS, 'action')->item(0);
    $action = '';
    if ($action_element != null) {
        $args['action'] = strtolower((string)($action_element->firstChild->data));
    }

    if ($entry_element->hasChildNodes()) {
        $nodes = $entry_element->childNodes;
        $args['category'] = array();
        for ($index = 0; $index < $nodes->length; $index++) {
            $node = $nodes->item($index);

            if (($node->namespaceURI != $WS_ATOM_NS) &&
                ($node->namespaceURI != $WS_APP_NS ) &&
                ($node->namespaceURI != $WS_EXTN_NS)) {
                continue;
            }

            switch ($node->localName) {
            case 'author':
                $author_name_element = $node->getElementsByTagName('name')->item(0);
                if ($author_name_element != null) {
                    $args['author_name'] = (string)($author_name_element->firstChild->nodeValue);
                }
                $author_uid_element = $node->getElementsByTagNameNS($WS_EXTN_NS, 'uid')->item(0);
                if ($author_uid_element != null) {
                    $args['uid'] = (string)($author_uid_element->firstChild->nodeValue);
                }
                break;
            case 'category':
                $args['category'][] = (string)$node->getAttribute('term');
                break;
            case 'updated':
                $args['updated'] = (string)$node->firstChild->nodeValue;
                break;
            case 'content':
                WS_getContent($args, $atom_doc, $node);
                break;
            default:
                if ($node->nodeType == XML_ELEMENT_NODE) {
                    $is_array = 1;
                    $child_nodes = $node->childNodes;
                    if ($child_nodes == null)
                        continue;

                    $args[$node->localName] = array();
                    for ($i = 0; $i < $child_nodes->length; $i++) {
                        $child_node = $child_nodes->item($i);
                        if ($child_node->nodeType == XML_TEXT_NODE) {
                            $args[$node->localName] = $child_node->nodeValue;
                            continue;
                        } elseif ($child_node->nodeType == XML_ELEMENT_NODE) {
                            if ($child_node->firstChild->nodeType == XML_TEXT_NODE) {
                                $args[$node->localName][$node->firstChild->localName] = $child_node->firstChild->nodeValue;
                            }
                        }
                    }
                }
            }
        }

        if (empty($args['updated'])) {
            $args['updated'] = date('c');
        }
        $args['publish_month'] = date('m', strtotime($args['updated']));
        $args['publish_year'] = date('Y', strtotime($args['updated']));
        $args['publish_day'] = date('d', strtotime($args['updated']));
        $args['publish_hour'] = date('H', strtotime($args['updated']));
        $args['publish_minute'] = date('i', strtotime($args['updated']));
        $args['publish_second'] = date('s', strtotime($args['updated']));

        if (isset($args['control'])) {
            foreach ($args['control'] as $key => $value) {
                if ($key == 'draft') {
                    $args['draft_flag'] = ($value == 'yes' ? 1 : 0);
                    break;
                }
            }
        }

        if (empty($args['uid'])) {
            $args['uid'] = $_USER['uid'];
        }
    }
}

/**
 * Converts an array into an XML entry node
 *
 * @param   DOMDocument &$atom_doc  the Atom document to which the entry should be appended
 * @param   array       $arr        the array which is to be converted into XML
 */
function WS_arrayToEntryXML($arr, $extn_elements, &$entry_elem, &$atom_doc)
{
    global $WS_PLUGIN, $WS_ATOM_NS, $WS_APP_NS, $WS_EXTN_NS, $_CONF;

    /* Standard Atom elements */

    $id = $atom_doc->createElement('atom:id', $arr['id']);
    $entry_elem->appendChild($id);

    $updated = $atom_doc->createElement('atom:updated', $arr['updated']);
    $entry_elem->appendChild($updated);

    if (!isset($arr['edited'])) {
        $lasted = $arr['updated'];
    } else {
        $lasted = $arr['edited'];
    }
    $edited = $atom_doc->createElement('app:edited', $lasted);
    $entry_elem->appendChild($edited);

    $title = $atom_doc->createElement('atom:title', $arr['title']);
    $title->setAttribute('type', 'text');
    $entry_elem->appendChild($title);

    foreach ($arr['category'] as $topic) {
        $category = $atom_doc->createElement('atom:category');
        $category->setAttribute('term', $topic);
        $entry_elem->appendChild($category);
    }

    if (!empty($arr['summary'])) {
        $summary = $atom_doc->createElement('atom:summary', $arr['summary']);
        $summary->setAttribute('type', $arr['content_type']);
        $entry_elem->appendChild($summary);
    }

    if (!empty($arr['id'])) {
        $link_self = $atom_doc->createElement('atom:link');
        $link_self->setAttribute('rel', 'edit');
        $link_self->setAttribute('type', 'application/atom+xml');
        $link_self->setAttribute('href', $_CONF['site_url'] . '/webservices/atom/?plugin=' . htmlentities($WS_PLUGIN) . '&id=' . htmlentities($arr['id']));
        $entry_elem->appendChild($link_self);
    }

    $content = $atom_doc->createElement('atom:content', $arr['content']);
    $content->setAttribute('type', $arr['content_type']);
    $entry_elem->appendChild($content);

    $author = $atom_doc->createElement('atom:author');
    $author_name = $atom_doc->createElement('atom:name', $arr['author_name']);
    $author->appendChild($author_name);
    $entry_elem->appendChild($author);

    // if there's a draft flag and it's == 1, export it as <app:draft>
    $draft = 0;
    if (isset($arr['draft_flag']) && ($arr['draft_flag'] == 1)) {
        $draft = 1;
    }
    if ($draft == 1) {
        $control = $atom_doc->createElement('app:control');
        $draft = $atom_doc->createElement('app:draft', 'yes');
        $control->appendChild($draft);
        $entry_elem->appendChild($control);
    }

    // Geeklog-specific elements

    foreach ($extn_elements as $elem) {
        if (is_array($arr[$elem])) {
            $count = 0;
            $extn_elem = $atom_doc->createElement('gl:' . $elem);
            foreach ($arr[$elem] as $param) {
                if (empty($param)) {
                    continue;
                }

                $count += 1;

                $param_elem = $atom_doc->createElement('gl:param', $param);
                $extn_elem->appendChild($param_elem);
            }
            if ($count > 0) {
                $entry_elem->appendChild($extn_elem);
            }
        } else {
            $extn_elem = $atom_doc->createElement('gl:' . $elem, $arr[$elem]);
            if (!empty($arr[$elem])) {
                $entry_elem->appendChild($extn_elem);
            }
        }
    }

    return $entry_elem;
}

/**
 * Authenticates the user if authentication headers are present
 */
function WS_authenticate()
{
    global $_USER, $_GROUPS, $_RIGHTS, $WS_VERBOSE;

    $uid = '';
    
    $status = -1;
    if (isset($_SERVER['PHP_AUTH_USER'])) {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        if ($WS_VERBOSE) {
            COM_errorLog("WS: Attempting to log in user '$username'");
        }

        $status = SEC_authenticate($username, $password, $uid);
    } elseif (!empty($_REQUEST['gl_auth_header'])) {
        /* PHP installed as CGI may not have access to authorization headers of
         * Apache. In that case, use .htaccess to store the auth header as a
         * request variable called gl_auth_digest
         */

        list($auth_type, $auth_data) = explode(' ', $_REQUEST['gl_auth_digest']);
        list($username, $password) = explode(':', base64_decode($auth_data));

        if ($WS_VERBOSE) {
            COM_errorLog("WS: Attempting to log in user '$username' (via gl_auth_header)");
        }

        $status = SEC_authenticate($username, $password, $uid);
    } else {
        if ($WS_VERBOSE) {
            COM_errorLog("WS: No login given");
        }

        return;
    }

    if ($status == USER_ACCOUNT_ACTIVE) {
        $_USER = SESS_getUserDataFromId($uid);
        PLG_loginUser($_USER['uid']);

        if ($WS_VERBOSE) {
            COM_errorLog("WS: User '{$_USER['username']}' ({$_USER['uid']}) successfully logged in");
        }
    } else {
        WS_error(PLG_RET_AUTH_FAILED);
    }

    /**
    * Global array of groups current user belongs to
    */

    if (!COM_isAnonUser()) {
        $_GROUPS = SEC_getUserGroups($_USER['uid']);
    } else {
        $_GROUPS = SEC_getUserGroups(1);
    }

    /**
    * Global array of current user permissions [read,edit]
    */

    $_RIGHTS = explode(',', SEC_getUserPermissions());
}

/**
 * Buffers text for output
 *
 * @param   string      $text       the text to be written
 */
function WS_write($text)
{
    global $WS_TEXT;

    $WS_TEXT .= $text;

}

/**
 * Writes buffered text to output
 */
function WS_writeSync()
{
    global $WS_TEXT;

    echo $WS_TEXT;

}

?>
