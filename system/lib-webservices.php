<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | lib-webservices.php                                                       |
// |                                                                           |
// | WS-related functions needed in more than one place.                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Ramnath R Iyer        - rri AT silentyak DOT com                 |
// |          Dirk Haun             - dirk AT haun-online DOT de               |
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
* Implementation of the Webservices functions for the Atom Publishing Protocol
* (AtomPub).
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-webservices.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Namespaces
*/
define('WS_ATOM_NS', 'http://www.w3.org/2005/Atom');
define('WS_APP_NS',  'http://www.w3.org/2007/app');
define('WS_APP_NS2', 'http://purl.org/atom/app#');
define('WS_EXTN_NS', 'http://www.geeklog.net/xmlns/app/gl');

$WS_PLUGIN    = '';
$WS_INTROSPECTION = false;
$WS_TEXT = '';

// Set = true to enable verbose logging (in error.log)
$WS_VERBOSE = false;


/**
 * Displays an error message with the appropriate HTTP error-code
 *
 * @param   string  $error_code     the name of the error
 * @param   string  $error_desc     a short description of the actual error (optional)
 */
function WS_error($error_code, $error_desc = '')
{
    global $_CONF, $WS_VERBOSE;

    header('Content-type: text/plain');
    switch ($error_code) {
    case PLG_RET_PRECONDITION_FAILED:
        header($_SERVER['SERVER_PROTOCOL'] . ' 412 Precondition Failed');
        if (empty($error_desc)) {
            $error_desc = 'Precondition Failed';
        }
        break;
    case PLG_RET_PERMISSION_DENIED:
        header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
        if (empty($error_desc)) {
            $error_desc = 'Forbidden';
        }
        break;
    case PLG_RET_AUTH_FAILED:
        $realm = preg_replace('/[^a-zA-Z0-9\-_\. ]/', '', $_CONF['site_name']);
        header($_SERVER['SERVER_PROTOCOL'] . ' 401 Unauthorized');
        header('WWW-Authenticate: Basic realm="' . $realm . '"');
        if (empty($error_desc)) {
            $error_desc = 'Unauthorized';
        }
        break;
    case PLG_RET_ERROR:
        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
        if (empty($error_desc)) {
            $error_desc = 'Bad Request';
        }
        break;
    }

    if (empty($error_desc)) {
        $error_desc = 'Error';
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
 * @param   array   &$args       the array to store any input parameters
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
    global $_CONF, $WS_PLUGIN, $WS_VERBOSE;

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

    // provide convenient access to the 'Slug:' header, if available
    if (isset($_SERVER['HTTP_SLUG'])) {
        $args['slug'] = $_SERVER['HTTP_SLUG'];
    } else {
        $args['slug'] = '';
    }

    // Call PLG_invokeService here
    $ret = PLG_invokeService($WS_PLUGIN, $action, $args, $out, $svc_msg);

    if ($ret == PLG_RET_OK) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 201 Created');
        header('Location: ' . $_CONF['site_url'] . '/webservices/atom/?plugin=' . $WS_PLUGIN . '&id' . '=' . $svc_msg['id']);

        /* While RFC 5023 only states that the server SHOULD return the created
         * entry, some clients (e.g. Tim Bray's APE) seem to insist on it.
         * So let's see what we can do ...
         */
        $getargs = array();
        $getargs['gl_svc'] = true;
        $getargs['id'] = $svc_msg['id'];

        $ret = PLG_invokeService($WS_PLUGIN, 'get', $getargs, $out, $svc_msg);
        if ($ret == PLG_RET_OK) {
            $atom_doc = new DOMDocument('1.0', 'utf-8');

            $entry_elem = $atom_doc->createElementNS(WS_ATOM_NS, 'atom:entry');
            $atom_doc->appendChild($entry_elem);
            $atom_doc->createAttributeNS(WS_APP_NS, 'app:entry');
            $atom_doc->createAttributeNS(WS_EXTN_NS, 'gl:entry');

            WS_arrayToEntryXML($out, $svc_msg['output_fields'], $entry_elem, $atom_doc);
            WS_write($atom_doc->saveXML());
        }

        return;
    }

    WS_error($ret, $svc_msg['error_desc']);
}

/**
 * Handles the PUT request
 */
function WS_put()
{
    global $_CONF, $WS_PLUGIN, $WS_VERBOSE;

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
    $args['gl_etag'] = '';
    if (isset($_SERVER['HTTP_IF_MATCH'])) {
        $args['gl_etag'] = trim($_SERVER['HTTP_IF_MATCH'], '"');
    }

    // Call PLG_invokeService here
    $ret = PLG_invokeService($WS_PLUGIN, 'submit', $args, $out, $svc_msg);

    if ($ret == PLG_RET_OK) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
        return;
    }

    if (!isset($svc_msg['error_desc'])) {
        $svc_msg['error_desc'] = '';
    }

    WS_error($ret, $svc_msg['error_desc']);
}

/**
 * Handles the GET request
 */
function WS_get()
{
    global $_CONF, $WS_PLUGIN, $WS_INTROSPECTION, $WS_VERBOSE, $_PLUGINS;

    if ($WS_VERBOSE) {
        COM_errorLog("WS: GET request received");
    }
    
    WS_dissectURI($args);

    if ($WS_INTROSPECTION) {

        header('Content-type: application/atomsvc+xml; charset=UTF-8');

        $atom_uri = $_CONF['site_url'] . '/webservices/atom/';

        /* Determine which plugins have webservices enabled */
        $_ws_plugins = array();

        /* Handle the story 'plugin' separately */
        if (PLG_wsEnabled('story')) {
            $_ws_plugins[] = 'story';
        }

        if (is_array($_PLUGINS)) {
            foreach ($_PLUGINS as $pi) {
                if (PLG_wsEnabled($pi)) {
                    $_ws_plugins[] = $pi;
                }
            }
        }

        /* It might be simpler to do this part directly :-/ */

        $atom_doc = new DOMDocument('1.0', 'utf-8');
        $root_elem = $atom_doc->createElementNS(WS_APP_NS, 'app:service');
        $atom_doc->appendChild($root_elem);
        $atom_doc->createAttributeNS(WS_ATOM_NS, 'atom:service');
        $atom_doc->createAttributeNS(WS_EXTN_NS, 'gl:service');

        $workspace = $atom_doc->createElement('app:workspace');
        $root_elem->appendChild($workspace);

        $title = $atom_doc->createElement('atom:title', $_CONF['site_name']);
        $workspace->appendChild($title);

        foreach ($_ws_plugins as $ws_plugin) {
            $atom_uri_for_plugin = $atom_uri . '?plugin=' . $ws_plugin;

            $collection = $atom_doc->createElement('app:collection');
            $collection->setAttribute('href', $atom_uri_for_plugin);
            $workspace->appendChild($collection);

            $title = $atom_doc->createElement('atom:title', $ws_plugin);
            $collection->appendChild($title);

            $entry = $atom_doc->createElement('app:accept', 'application/atom+xml;type=entry');
            $collection->appendChild($entry);

            $categories = $atom_doc->createElement('app:categories');
            $categories->setAttribute('fixed', 'yes');
            $collection->appendChild($categories);

            $topics = array();
            $msg = array();
            $ret = PLG_invokeService($ws_plugin, 'getTopicList', null, $topics, $msg);
            if ($ret == PLG_RET_OK) {
                foreach ($topics as $t) {
                    $topic = $atom_doc->createElement('atom:category');
                    $topic->setAttribute('term', htmlentities($t));
                    $categories->appendChild($topic);
                }
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
            $etag = '';
            if (isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
                $etag = trim($_SERVER['HTTP_IF_NONE_MATCH'], '"');
            }
            if (!empty($etag) && ($out['updated'] == $etag)) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
                exit();
            } else {
                header('Etag: "' . $out['updated'] . '"');
            }
            $atom_doc = new DOMDocument('1.0', 'utf-8');

            $entry_elem = $atom_doc->createElementNS(WS_ATOM_NS, 'atom:entry');
            $atom_doc->appendChild($entry_elem);
            $atom_doc->createAttributeNS(WS_APP_NS, 'app:entry');
            $atom_doc->createAttributeNS(WS_EXTN_NS, 'gl:entry');

            WS_arrayToEntryXML($out, $svc_msg['output_fields'], $entry_elem, $atom_doc);
            WS_write($atom_doc->saveXML());
        } else {
            /* Output the feed here */
            $atom_doc = new DOMDocument('1.0', 'utf-8');

            $feed_elem = $atom_doc->createElementNS(WS_ATOM_NS, 'atom:feed');
            $atom_doc->appendChild($feed_elem);
            $atom_doc->createAttributeNS(WS_APP_NS, 'app:feed');
            $atom_doc->createAttributeNS(WS_EXTN_NS, 'gl:feed');

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
    global $_CONF, $WS_PLUGIN, $WS_VERBOSE;

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
 * @todo    I guess we could at least support 'text/plain', 'text/html', etc.
 */
function WS_getContent(&$args, $atom_doc, $node)
{
    $type = (string) $node->getAttribute('type');
    if (empty($type)) {
        $type = 'text';
    }

    switch ($type) {
    case 'text':
    case 'text/plain':
        $args['content'] = (string) $node->nodeValue;
        $args['content_type'] = 'text';
        break;

    case 'html':
    case 'text/html':
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
        } elseif ($div->nodeType == XML_TEXT_NODE) {
            // hack for Yulup which sometimes sends Text nodes within the XHTML
            $args['content'] = trim((string) $node->nodeValue);
            $args['content_type'] = 'html';
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
    global $_USER;

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
    $action_element = $entry_element->getElementsByTagNameNS(WS_EXTN_NS, 'action')->item(0);
    $action = '';
    if ($action_element != null) {
        $args['action'] = strtolower((string)($action_element->firstChild->data));
    }

    if ($entry_element->hasChildNodes()) {
        $nodes = $entry_element->childNodes;
        $args['category'] = array();
        for ($index = 0; $index < $nodes->length; $index++) {
            $node = $nodes->item($index);

            if (($node->namespaceURI != WS_ATOM_NS) &&
                ($node->namespaceURI != WS_APP_NS) &&
                ($node->namespaceURI != WS_APP_NS2) &&
                ($node->namespaceURI != WS_EXTN_NS)) {
                continue;
            }

            switch ($node->localName) {
            case 'author':
                $author_name_element = $node->getElementsByTagName('name')->item(0);
                if ($author_name_element != null) {
                    $args['author_name'] = (string)($author_name_element->firstChild->nodeValue);
                }
                $author_uid_element = $node->getElementsByTagNameNS(WS_EXTN_NS, 'uid')->item(0);
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
            case 'edited':
                $args['edited'] = (string)$node->firstChild->nodeValue;
                break;
            case 'published':
                $args['published'] = (string)$node->firstChild->nodeValue;
                break;
            case 'content':
                WS_getContent($args, $atom_doc, $node);
                break;
            case 'control':
                if ($node->nodeType == XML_ELEMENT_NODE) {
                    $child_nodes = $node->childNodes;
                    if ($child_nodes == null) {
                        continue;
                    }
                    $args[$node->localName] = array();
                    for ($i = 0; $i < $child_nodes->length; $i++) {
                        $child_node = $child_nodes->item($i);
                        if ($child_node->nodeType == XML_ELEMENT_NODE) {
                            if ($child_node->firstChild->nodeType == XML_TEXT_NODE) {
                                $args[$node->localName][$child_node->localName]
                                        = $child_node->firstChild->nodeValue;
                                break;
                            }
                        }
                    }
                }
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
                        } elseif ($child_node->nodeType == XML_CDATA_SECTION_NODE) {
                            $args[$node->localName] = $child_node->nodeValue;
                        }
                    }
                }
            }
        }

        $timestamp = date('c');
        if (!empty($args['published'])) {
            $timestamp = $args['published'];
        } elseif (!empty($args['updated'])) {
            $timestamp = $args['updated'];
        } elseif (!empty($args['edited'])) {
            $timestamp = $args['edited'];
        }
        $args['publish_month'] = date('m', strtotime($timestamp));
        $args['publish_year'] = date('Y', strtotime($timestamp));
        $args['publish_day'] = date('d', strtotime($timestamp));
        $args['publish_hour'] = date('H', strtotime($timestamp));
        $args['publish_minute'] = date('i', strtotime($timestamp));
        $args['publish_second'] = date('s', strtotime($timestamp));

        if (isset($args['control']) && is_array($args['control'])) {
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
 * @param   array       $arr        the array which is to be converted into XML
 * @param   array       $extn_elements Geeklog-specific extension elements
 * @param   object      &$entry_elem   entry to append to
 * @param   DOMDocument &$atom_doc  the Atom document to which the entry should be appended
 */
function WS_arrayToEntryXML($arr, $extn_elements, &$entry_elem, &$atom_doc)
{
    global $_CONF, $WS_PLUGIN;

    /* Standard Atom elements */

    $id = $atom_doc->createElement('atom:id', $arr['id']);
    $entry_elem->appendChild($id);

    if (!empty($arr['published'])) {
        $published = $atom_doc->createElement('atom:published', $arr['published']);
        $entry_elem->appendChild($published);
    }

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

        if (isset($arr[$elem])) {
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
    }

    return $entry_elem;
}

/**
 * Authenticates the user if authentication headers are present
 *
 * Our handling of the speedlimit here requires some explanation ...
 * Atompub clients will usually try to do everything without logging in first.
 * Since that would mean that we can't provide feeds for drafts, items with
 * special permissions, etc. we ask them to log in (PLG_RET_AUTH_FAILED).
 * That, however, means that every request from an Atompub client will count
 * as one failed login attempt. So doing a couple of requests in quick
 * succession will surely get the client blocked. Therefore
 * - a request without any login credentials counts as one failed login attempt
 * - a request with wrong login credentials counts as two failed login attempts
 * - if, after a successful login, we have only one failed attempt on record,
 *   we reset the speedlimit
 * This still ensures that
 * - repeated failed logins (without or with invalid credentials) will cause the
 *   client to be blocked eventually
 * - this can not be used for dictionary attacks
 *
 */
function WS_authenticate()
{
    global $_CONF, $_TABLES, $_USER, $_GROUPS, $_RIGHTS, $WS_VERBOSE;

    $uid = '';
    $username = '';
    $password = '';

    $status = -1;

    if (isset($_SERVER['PHP_AUTH_USER'])) {
        $username = COM_applyBasicFilter($_SERVER['PHP_AUTH_USER']);
        $password = $_SERVER['PHP_AUTH_PW'];

        if ($WS_VERBOSE) {
            COM_errorLog("WS: Attempting to log in user '$username'");
        }

/** this does not work! *******************************************************

    } elseif (!empty($_SERVER['HTTP_X_WSSE']) &&
            (strpos($_SERVER['HTTP_X_WSSE'], 'UsernameToken') !== false)) {

        // this is loosely based on a code snippet taken from Elgg (elgg.org)

        $wsse = str_replace('UsernameToken', '', $_SERVER['HTTP_X_WSSE']);
        $wsse = explode(',', $wsse);

        $username = '';
        $pwdigest = '';
        $created = '';
        $nonce = '';

        foreach ($wsse as $element) {
            $element = explode('=', $element);
            $key = array_shift($element);
            if (count($element) == 1) {
                $val = $element[0];
            } else {
                $val = implode('=', $element);
            }
            $key = trim($key);
            $val = trim($val, "\x22\x27");
            if ($key == 'Username') {
                $username = COM_applyBasicFilter($val);
            } elseif ($key == 'PasswordDigest') {
                $pwdigest = $val;
            } elseif ($key == 'Created') {
                $created = $val;
            } elseif ($key == 'Nonce') {
                $nonce = $val;
            }
        }

        if (!empty($username) && !empty($pwdigest) && !empty($created) &&
                !empty($nonce)) {

            $uname = addslashes($username);
            $pwd = DB_getItem($_TABLES['users'], 'passwd',
                              "username = '$uname'");
            // ... and here we would need the _unencrypted_ password

            if (!empty($pwd)) {
                $mydigest = pack('H*', sha1($nonce . $created . $pwd));
                $mydigest = base64_encode($mydigest);

                if ($pwdigest == $mydigest) {
                    $password = $pwd;
                }   
            }   
        }

        if ($WS_VERBOSE) {
            COM_errorLog("WS: Attempting to log in user '$username' (via WSSE)");
        }

******************************************************************************/

    } elseif (!empty($_SERVER['REMOTE_USER'])) {
        /* PHP installed as CGI may not have access to authorization headers of
         * Apache. In that case, use .htaccess to store the auth header as
         * explained at
         * http://wiki.geeklog.net/wiki/index.php/Webservices_API#Authentication
         */

        list($auth_type, $auth_data) = explode(' ', $_SERVER['REMOTE_USER']);
        list($username, $password) = explode(':', base64_decode($auth_data));
        $username = COM_applyBasicFilter($username);

        if ($WS_VERBOSE) {
            COM_errorLog("WS: Attempting to log in user '$username' (via \$_SERVER['REMOTE_USER'])");
        }
    } else {
        if ($WS_VERBOSE) {
            COM_errorLog("WS: No login given");
        }

        // fallthrough (see below)
    }

    COM_clearSpeedlimit($_CONF['login_speedlimit'], 'wsauth');
    if (COM_checkSpeedlimit('wsauth', $_CONF['login_attempts']) > 0) {
        WS_error(PLG_RET_PERMISSION_DENIED, 'Speed Limit exceeded');
    }

    if (!empty($username) && !empty($password)) {
        if ($_CONF['user_login_method']['3rdparty']) {
            // remote users will have to use username@servicename
            $u = explode('@', $username);
            if (count($u) > 1) {
                $sv = $u[count($u) - 1];
                if (!empty($sv)) {
                    $modules = SEC_collectRemoteAuthenticationModules();
                    foreach ($modules as $smod) {
                        if (strcasecmp($sv, $smod) == 0) {
                            array_pop($u); // drop the service name
                            $uname = implode('@', $u);
                            $status = SEC_remoteAuthentication($uname,
                                                    $password, $smod, $uid);
                            break;
                        }
                    }
                }
            }
        }
        if (($status == -1) && $_CONF['user_login_method']['standard']) {
            $status = SEC_authenticate($username, $password, $uid);
        }
    }

    if ($status == USER_ACCOUNT_ACTIVE) {

        $_USER = SESS_getUserDataFromId($uid);
        PLG_loginUser($_USER['uid']);

        // Global array of groups current user belongs to
        $_GROUPS = SEC_getUserGroups($_USER['uid']);

        // Global array of current user permissions [read,edit]
        $_RIGHTS = explode(',', SEC_getUserPermissions());

        if ($_CONF['restrict_webservices']) {
            if (!SEC_hasRights('webservices.atompub')) {
                COM_updateSpeedlimit('wsauth');

                if ($WS_VERBOSE) {
                    COM_errorLog("WS: User '{$_USER['username']}' ({$_USER['uid']}) does not have permission to use the webservices");
                }

                // reset user, groups, and rights, just in case ...
                $_USER   = array();
                $_GROUPS = array();
                $_RIGHTS = array();

                WS_error(PLG_RET_AUTH_FAILED);
            }
        }

        if ($WS_VERBOSE) {
            COM_errorLog("WS: User '{$_USER['username']}' ({$_USER['uid']}) successfully logged in");
        }

        // if there were less than 2 failed login attempts, reset speedlimit
        if (COM_checkSpeedlimit('wsauth', 2) == 0) {
            if ($WS_VERBOSE) {
                COM_errorLog("WS: Successful login - resetting speedlimit");
            }
            COM_resetSpeedlimit('wsauth');
        }
    } else {
        COM_updateSpeedlimit('wsauth');
        if (!empty($username) && !empty($password)) {
            COM_updateSpeedlimit('wsauth');

            if ($WS_VERBOSE) {
                COM_errorLog("WS: Wrong login credentials - counting as 2 failed attempts");
            }
        } elseif ($WS_VERBOSE) { 
            COM_errorLog("WS: Empty login credentials - counting as 1 failed attempt");
        }
        WS_error(PLG_RET_AUTH_FAILED);
    }
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

/**
 * Create a new ID, preferrably from a provided 'Slug:' header
 *
 * For more information on the 'Slug:' header, see RFC 5023, section 9.7
 *
 * @param    string  $slug           Content of the 'Slug:' header
 * @param    int     $max_length     max. length of the created ID
 * @return   string                  new ID
 * @link     http://tools.ietf.org/html/rfc5023#section-9.7
 * 
 */
function WS_makeId($slug = '', $max_length = 40)
{
    $sid = COM_makeSid();

    if (strpos($slug, '%') !== false) {
        // we'll end up removing most of the %-encoded characters anyway ...
        $slug = '';
    }

    $slug = trim($slug);
    if (!empty($slug)) {
        // make it more ID-like
        $slug = str_replace(' ', '-', $slug);
        $slug = strtolower($slug);

        $id = COM_sanitizeID($slug . '-' . $sid);
        if (strlen($id) > $max_length) {
            // 'slug-sid' would make for nicer IDs but if we have to shorten
            // them, they're probably not unique any more. So swap order.
            $id = $sid . '-' . $slug;
        }
    } else {
        $id = $sid;
    }

    return substr(COM_sanitizeID($id), 0, $max_length);
}

?>
