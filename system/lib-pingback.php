<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | lib-pingback.php                                                          |
// |                                                                           |
// | Functions needed to handle pingbacks.                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2005 by the following authors:                              |
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
// $Id: lib-pingback.php,v 1.3 2005/01/30 13:51:09 dhaun Exp $

if (eregi ('lib-trackback.php', $_SERVER['PHP_SELF'])) {
    die ('This file can not be used on its own.');
}

// PEAR class to handle XML-RPC
require_once ('XML/RPC.php');

/**
* Get the HEAD response for a URL
*
* @param    string  $targeturl  URL to get the HEAD from
* @return   string              the HEAD response as one string or false
*
*/
function PNB_getHead ($targeturl)
{
    $target = parse_url ($targeturl);
    if (!empty ($target['query'])) {
        $target['query'] = '?' . $target['query'];
    }
    if (empty ($target['port']) || !is_numeric ($target['port'])) {
        $target['port'] = 80;
    }
                                                                                
    $sock = fsockopen ($target['host'], $target['port']);
    if (!is_resource ($sock)) {
        COM_errorLog ('Pingback: Could not connect to ' . $targeturl);
                                                                                
        return false;
    }

    fputs ($sock, 'HEAD ' . $target['path'] . $target['query'] . " HTTP/1.1\n");
    fputs ($sock, 'Host: ' . $target['host'] . "\n");
    fputs ($sock, "Connection: close\n\n");

    $res = '';
    while (!feof ($sock)) {
        $res .= fgets ($sock, 128);
    }
                                                                                
    fclose($sock);

    return $res;
}

/**
* Get the Pingback URL for a given URL
*
* Note: Only checks for the 'X-Pingback:' header.
*
* @param    string  $url    URL to get the Pingback URL for
* @return   string          Pingback URL or empty string
*
*/
function PNB_getPingbackUrl ($url)
{
    $retval = '';

    $head = PNB_getHead ($url);
    if (!empty ($head)) {
        $header = explode ("\n", $head);
        foreach ($header as $h) {
            $parts = explode (' ', $h);
            if (strcasecmp ($parts[0], 'X-Pingback:') == 0) {
                $retval = trim ($parts[1]);
                break;
            }
        }
    }

    // if we don't get the URL from the header, we could now try to read
    // the page and extract it from a <link rel="pingback"> tag, but use
    // of those is discouraged anyway ...

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

?>
