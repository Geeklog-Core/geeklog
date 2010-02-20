<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | pingback.php                                                              |
// |                                                                           |
// | Handle pingbacks for stories and plugins.                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2005-2009 by the following authors:                         |
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

require_once 'lib-common.php';

// once received, we're handling pingbacks like trackbacks,
// so we use the trackback library even when trackback may be disabled
require_once $_CONF['path_system'] . 'lib-pingback.php';
require_once $_CONF['path_system'] . 'lib-trackback.php';

// PEAR class to handle XML-RPC
require_once 'XML/RPC/Server.php';

// Note: Error messages are hard-coded in English since there is no way of
// knowing which language the sender of the pingback may prefer.
$PNB_ERROR = array (
    'success'     => 'Thank you.', // success message; not an error ...
    'skipped'     => '(skipped)',  // not an error
    'spam'        => 'Spam detected.',
    'speedlimit'  => 'Your last pingback was %d seconds ago. This site requires at least %d seconds between pingbacks.',
    'disabled'    => 'Pingback is disabled.',
    'uri_invalid' => 'Invalid targetURI.',
    'no_access'   => 'Access denied.',
    'multiple'    => 'Multiple posts not allowed.'
);


/**
* Handle a pingback for an entry.
*
* Also takes care of the speedlimit and spam. Assumes that the caller of this
* function has already checked permissions!
*
* @param    string  $id     ID of entry that got pinged
* @param    string  $type   type of that entry ('article' for stories, etc.)
* @param    string  $url    URL of the page that pinged us
* @param    string  $oururl URL that got pinged on our site
* @return   object          XML-RPC response
*
*/
function PNB_handlePingback ($id, $type, $url, $oururl)
{
    global $_CONF, $_TABLES, $PNB_ERROR;

    require_once 'HTTP/Request.php';

    if (!isset ($_CONF['check_trackback_link'])) {
        $_CONF['check_trackback_link'] = 2;
    }

    // handle pingbacks to articles on our own site
    $skip_speedlimit = false;
    if ($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']) {
        if (!isset ($_CONF['pingback_self'])) {
            $_CONF['pingback_self'] = 0; // default: skip self-pingbacks
        }

        if ($_CONF['pingback_self'] == 0) {
            return new XML_RPC_Response (new XML_RPC_Value ($PNB_ERROR['skipped']));
        } else if ($_CONF['pingback_self'] == 2) {
            $skip_speedlimit = true;
        }
    }

    COM_clearSpeedlimit ($_CONF['commentspeedlimit'], 'pingback');
    if (!$skip_speedlimit) {
        $last = COM_checkSpeedlimit ('pingback');
        if ($last > 0) {
            return new XML_RPC_Response (0, 49,
                    sprintf ($PNB_ERROR['speedlimit'], $last,
                             $_CONF['commentspeedlimit']));
        }
    }

    // update speed limit in any case
    COM_updateSpeedlimit ('pingback');

    if ($_SERVER['REMOTE_ADDR'] != $_SERVER['SERVER_ADDR']) {
        if ($_CONF['check_trackback_link'] & 4) {
            $parts = parse_url ($url);
            if (empty ($parts['host'])) {
                TRB_logRejected ('Pingback: No valid URL', $url);
                return new XML_RPC_Response (0, 33, $PNB_ERROR['uri_invalid']);
            } else {
                $ip = gethostbyname ($parts['host']);
                if ($ip != $_SERVER['REMOTE_ADDR']) {
                    TRB_logRejected ('Pingback: IP address mismatch', $url);
                    return new XML_RPC_Response (0, 49, $PNB_ERROR['spam']);
                }
            }
        }
    }

    // See if we can read the page linking to us and extract at least
    // the page's title out of it ...
    $title = '';
    $excerpt = '';
    $req = new HTTP_Request ($url);
    $req->addHeader ('User-Agent', 'Geeklog/' . VERSION);
    $response = $req->sendRequest ();
    if (PEAR::isError ($response)) {
        if ($_CONF['check_trackback_link'] & 3) {
            // we were supposed to check for backlinks but didn't get the page
            COM_errorLog ("Pingback verification: " . $response->getMessage()
                          . " when requesting $url");
            return new XML_RPC_Response (0, 33, $PNB_ERROR['uri_invalid']);
        }
        // else: silently ignore errors - we'll simply do without the title
    } else {
        if ($req->getResponseCode () == 200) {
            $body = $req->getResponseBody ();

            if ($_CONF['check_trackback_link'] & 3) {
                if (!TRB_containsBacklink ($body, $oururl)) {
                    TRB_logRejected ('Pingback: No link to us', $url);
                    $comment = TRB_formatComment ($url);
                    PLG_spamAction ($comment, $_CONF['spamx']);

                    return new XML_RPC_Response (0, 49, $PNB_ERROR['spam']);
                }
            }

            preg_match (':<title>(.*)</title>:i', $body, $content);
            if (empty ($content[1])) {
                $title = ''; // no title found
            } else {
                $title = trim (COM_undoSpecialChars ($content[1]));
            }

            if ($_CONF['pingback_excerpt']) {

                // Check which character set the site that sent the Pingback
                // is using
                $charset = 'ISO-8859-1'; // default, see RFC 2616, 3.7.1
                $ctype = $req->getResponseHeader('Content-Type');
                if (!empty($ctype)) {
                    // e.g. text/html; charset=utf-8
                    $c = explode(';', $ctype);
                    foreach ($c as $ct) {
                        $ch = explode('=', trim($ct));
                        if (count($ch) == 2) {
                            if(trim($ch[0]) == 'charset') {
                                $charset = trim($ch[1]);
                                break;
                            }
                        }
                    }
                }

                if (!empty($charset) &&
                        (strcasecmp($charset, COM_getCharset()) != 0)) {

                    if (function_exists('mb_convert_encoding')) {
                        $body = @mb_convert_encoding($body, COM_getCharset(),
                                                     $charset);
                    } elseif (function_exists('iconv')) {
                        $body = @iconv($charset, COM_getCharset(), $body);
                    }
                    // else: tough luck ...
                }

                $excerpt = PNB_makeExcerpt($body, $oururl);
            }

            // we could also run the rest of the other site's page
            // through the spam filter here ...
        } else if ($_CONF['check_trackback_link'] & 3) {
            COM_errorLog ("Pingback verification: Got HTTP response code "
                          . $req->getResponseCode ()
                          . " when requesting $url");
            return new XML_RPC_Response (0, 33, $PNB_ERROR['uri_invalid']);
        }
        // else: silently ignore errors - we'll simply do without the title
    }

    // check for spam first
    $saved = TRB_checkForSpam ($url, $title, '', $excerpt);

    if ($saved == TRB_SAVE_SPAM) {
        return new XML_RPC_Response (0, 49, $PNB_ERROR['spam']);
    }

    // save as a trackback comment
    $saved = TRB_saveTrackbackComment ($id, $type, $url, $title, '', $excerpt);

    if ($saved == TRB_SAVE_REJECT) {
        return new XML_RPC_Response (0, 49, $PNB_ERROR['multiple']);
    }

    if (isset ($_CONF['notification']) &&
            in_array ('pingback', $_CONF['notification'])) {                  
        TRB_sendNotificationEmail ($saved, 'pingback');                               
    }

    return new XML_RPC_Response (new XML_RPC_Value ($PNB_ERROR['success']));
}

/**
* Check if the targetURI really points to us
*
* @param    string  $url    targetURI, a URL on our site
* @return   boolean         true = is a URL on our site
*
*/
function PNB_validURL ($url)
{
    global $_CONF;

    $retval = false;

    if (substr ($url, 0, strlen ($_CONF['site_url'])) == $_CONF['site_url']) {
        $retval = true;
    }

    return $retval;
}

/**
* Try to determine what has been pinged
*
* Checks if the URL contains 'article.php' for articles. Otherwise tries to
* figure out if a plugin's page has been pinged.
*
* @param    string  $url    targetURI, a URL on our site
* @return   string          'article' or plugin name or empty string for error
*
*/
function PNB_getType ($url)
{
    global $_CONF, $_TABLES;

    $retval = '';

    $part = substr ($url, strlen ($_CONF['site_url']) + 1);
    if (substr ($part, 0, strlen ('article.php')) == 'article.php') {
        $retval = 'article';
    } else {
        $parts = explode ('/', $part);
        if (strpos ($parts[0], '?') === false) {
            $plugin = addslashes ($parts[0]);
            if (DB_getItem ($_TABLES['plugins'], 'pi_enabled',
                            "pi_name = '$plugin'") == 1) {
                $retval = $parts[0];
            }
        }
    }

    return $retval;
}

/**
* Extract story ID (sid) from the URL
*
* Accepts rewritten and old-style URLs. Also checks permissions.
*
* @param    string  $url    targetURI, a URL on our site
* @return   string          story ID or empty string for error
*
*/
function PNB_getSid ($url)
{
    global $_CONF, $_TABLES;

    $retval = '';

    $sid = '';
    $params = substr ($url, strlen ($_CONF['site_url'] . '/article.php'));
    if (substr ($params, 0, 1) == '?') { // old-style URL
        $pos = strpos ($params, 'story=');
        if ($pos !== false) {
            $part = substr ($params, $pos + strlen ('story='));
            $parts = explode ('&', $part);
            $sid = $parts[0];
        }
    } else if (substr ($params, 0, 1) == '/') { // rewritten URL
        $parts = explode ('/', substr ($params, 1));
        $sid = $parts[0];
    }
    if (!empty ($sid)) {
        $parts = explode ('#', $sid);
        $sid = $parts[0];
    }

    // okay, so we have a SID - but are they allowed to access the story?
    if (!empty ($sid)) {
        $testsid = addslashes ($sid);
        $result = DB_query ("SELECT trackbackcode FROM {$_TABLES['stories']} WHERE sid = '$testsid'" . COM_getPermSql ('AND') . COM_getTopicSql ('AND'));
        if (DB_numRows ($result) == 1) {
            $A = DB_fetchArray ($result);
            if ($A['trackbackcode'] == 0) {
                $retval = $sid;
            }
        }
    }

    return $retval;
}

/**
* We've received a pingback - handle it ...
*
* @param    object  $params     parameters of the pingback XML-RPC call
* @return   object              XML-RPC response
*
*/
function PNB_receivePing ($params)
{
    global $_CONF, $_TABLES, $PNB_ERROR;

    if (!$_CONF['pingback_enabled']) {
        return new XML_RPC_Response (0, 33, $PNB_ERROR['disabled']);
    }

    $s = $params->getParam (0);
    $p1 = $s->scalarval (); // the page linking to us

    if (is_array ($p1)) {
        // WordPress sends the 2 URIs as an array ...
        $sourceURI = $p1[0]->scalarval ();
        $targetURI = $p1[1]->scalarval ();
    } else {
        $sourceURI = $p1;

        $s = $params->getParam (1);
        $targetURI = $s->scalarval (); // the page being linked to (on our site)
    }

    if (!PNB_validURL ($targetURI)) {
        return new XML_RPC_Response (0, 33, $PNB_ERROR['uri_invalid']);
    }

    $type = PNB_getType ($targetURI);
    if (empty ($type)) {
        return new XML_RPC_Response (0, 33, $PNB_ERROR['uri_invalid']);
    }

    if ($type == 'article') {
        $id = PNB_getSid ($targetURI);
    } else {
        $id = PLG_handlePingComment ($type, $targetURI, 'acceptByURI');
    }
    if (empty ($id)) {
        return new XML_RPC_Response (0, 49, $PNB_ERROR['no_access']);
    }

    return PNB_handlePingback ($id, $type, $sourceURI, $targetURI);
}


// MAIN

// fire up the XML-RPC server - it does all the work for us
$s = new XML_RPC_Server ( array (
        'pingback.ping' => array ('function'  => 'PNB_receivePing')
     ));

?>
