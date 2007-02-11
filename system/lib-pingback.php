<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | lib-pingback.php                                                          |
// |                                                                           |
// | Functions needed to handle pingbacks.                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2005-2007 by the following authors:                         |
// |                                                                           |
// | Author: Dirk Haun - dirk AT haun-online DOT de                            |
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
// $Id: lib-pingback.php,v 1.9 2007/02/11 19:55:58 dhaun Exp $

if (strpos ($_SERVER['PHP_SELF'], 'lib-pingback.php') !== false) {
    die ('This file can not be used on its own!');
}

// PEAR class to handle XML-RPC
require_once ('XML/RPC.php');

/**
* Get the Pingback URL for a given URL
*
* @param    string  $url    URL to get the Pingback URL for
* @return   string          Pingback URL or empty string
*
*/
function PNB_getPingbackUrl($url)
{
    require_once 'HTTP/Request.php';

    $retval = '';

    $req = new HTTP_Request($url);
    $req->setMethod(HTTP_REQUEST_METHOD_HEAD);
    $req->addHeader('User-Agent', 'GeekLog/' . VERSION);

    $response = $req->sendRequest();
    if (PEAR::isError($response)) {
        COM_errorLog('Pingback (HEAD): ' . $response->getMessage());
        return false;
    } else {
        $retval = $req->getResponseHeader('X-Pingback');
    }

    if (empty($retval)) {
        // search for <link rel="pingback">
        $req = new HTTP_Request($url);
        $req->setMethod(HTTP_REQUEST_METHOD_GET);
        $req->addHeader('User-Agent', 'GeekLog/' . VERSION);

        $response = $req->sendRequest();
        if (PEAR::isError($response)) {
            COM_errorLog('Pingback (GET): ' . $response->getMessage());
            return false;
        } elseif ($req->getResponseCode() == 200) {
            $body = $req->getResponseBody();

            // only search for the first match - it doesn't make sense to have
            // more than one pingback URL
            $found = preg_match("/<link rel=\"pingback\"[^>]*href=[\"']([^\"']*)[\"'][^>]*>/i", $body, $matches);
            if (($found === 1) && !empty($matches[1])) {
                $url = str_replace('&amp;', '&', $matches[1]);
                $retval = urldecode($url);
            }
        } else {
            COM_errorLog('Pingback (GET): Got HTTP response code '
                         . $req->getResponseCode() . " when requesting $url");
            return false;
        }
    }

    return $retval;
}

/**
* Send a Pingback
*
* @param    string  $sourceURI  URL of an entry on our site
* @param    string  $targetURI  an entry on someone else's site
* @return   string              empty string on success or error message
*
*/
function PNB_sendPingback ($sourceURI, $targetURI)
{
    global $LANG_TRB;

    $retval = '';

    $pingback = PNB_getPingbackUrl ($targetURI);
    if (empty ($pingback)) {
        return $LANG_TRB['no_pingback_url'];
    }

    $parts = parse_url ($pingback);
    if (empty ($parts['port'])) {
        if (strcasecmp ($parts['scheme'], 'https') == 0) {
            $parts['port'] = 443;
        } else {
            $parts['port'] = 80;
        }
    }
    if (!empty ($parts['query'])) {
        $parts['path'] .= '?' . $parts['query'];
    }
    $client = new XML_RPC_Client ($parts['path'], $parts['host'], $parts['port']);
    //$client->setDebug (1);

    $msg = new XML_RPC_Message ('pingback.ping',
            array (new XML_RPC_Value ($sourceURI, 'string'),
                   new XML_RPC_Value ($targetURI, 'string')));

    $response = $client->send ($msg, 0, $parts['scheme']);
    if ($response == 0) {
        $retval = $client->errstring;
    } else if ($response->faultCode () != 0) {
        $retval = $response->faultString ();
    }

    return $retval;
}

/**
* Send a standard ping to a weblog directory service
*
* The "classic" ping, originally invented for weblogs.com
*
* @param    string  $url            URL to ping
* @param    string  $blogname       name of our site
* @param    string  $blogurl        URL of our site
* @param    string  $changedurl     URL of the changed / new entry
* @return   string                  empty string on success of error message
*
*/
function PNB_sendPing ($url, $blogname, $blogurl, $changedurl)
{
    $parts = parse_url ($url);
    if (empty ($parts['port'])) {
        if (strcasecmp ($parts['scheme'], 'https') == 0) {
            $parts['port'] = 443;
        } else {
            $parts['port'] = 80;
        }
    }
    $client = new XML_RPC_Client ($parts['path'], $parts['host'], $parts['port']);
    //$client->setDebug (1);

    $msg = new XML_RPC_Message ('weblogUpdates.ping',
            array (new XML_RPC_Value ($blogname, 'string'),
                   new XML_RPC_Value ($blogurl, 'string'),
                   new XML_RPC_Value ($changedurl, 'string')));

    $response = $client->send ($msg, 0, $parts['scheme']);
    if ($response == 0) {
        $retval = $client->errstring;
    } else if ($response->faultCode () != 0) {
        $retval = $response->faultString ();
    }

    return $retval;
}

/**
* Send an extended ping to a weblog directory service
*
* Supported e.g. by blo.gs
*
* @param    string  $url            URL to ping
* @param    string  $blogname       name of our site
* @param    string  $blogurl        URL of our site
* @param    string  $changedurl     URL of the changed / new entry
* @param    string  $feedurl        URL of a feed for our site
* @return   string                  empty string on success of error message
*
*/
function PNB_sendExtendedPing ($url, $blogname, $blogurl, $changedurl, $feedurl)
{
    $parts = parse_url ($url);
    if (empty ($parts['port'])) {
        if (strcasecmp ($parts['scheme'], 'https') == 0) {
            $parts['port'] = 443;
        } else {
            $parts['port'] = 80;
        }
    }
    $client = new XML_RPC_Client ($parts['path'], $parts['host'], $parts['port']);
    //$client->setDebug (1);

    $msg = new XML_RPC_Message ('weblogUpdates.extendedPing',
            array (new XML_RPC_Value ($blogname, 'string'),
                   new XML_RPC_Value ($blogurl, 'string'),
                   new XML_RPC_Value ($changedurl, 'string'),
                   new XML_RPC_Value ($feedurl, 'string')));

    $response = $client->send ($msg, 0, $parts['scheme']);
    if ($response == 0) {
        $retval = $client->errstring;
    } else if ($response->faultCode () != 0) {
        $retval = $response->faultString ();
    }

    return $retval;
}

?>
