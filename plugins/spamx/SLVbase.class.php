<?php

/**
* File: SLVbase.class.php
* Spam Link Verification (SLV) Base Class
*
* Copyright (C) 2006 by the following authors:
* Author        Dirk Haun       dirk AT haun-online DOT de
*
* Licensed under the GNU General Public License
*
* $Id: SLVbase.class.php,v 1.1 2006/08/27 09:30:19 dhaun Exp $
*/

if (strpos ($_SERVER['PHP_SELF'], 'SLVbase.class.php') !== false) {
    die ('This file can not be used on its own!');
}

/**
* Sends posts to SLV (linksleeve.org) for examination
*
* @author Dirk Haun     dirk AT haun-online DOT de
*
* based on the works of Tom Willet (Spam-X) and Russ Jones (SLV)
*/

class SLVbase {

    var $_debug = false;

    var $_verbose = false;

    /**
    * Constructor
    */
    function SLVbase()
    {
        $this->_debug = false;
        $this->_verbose = false;
    }

    /**
    * Check for spam links
    *
    * @param    string  $post   post to check for spam
    * @return   boolean         true = spam found, false = no spam
    *
    * Note: Also returns 'false' in case of problems communicating with SLV.
    *       Error messages are logged in Geeklog's error.log
    *
    */
    function CheckForSpam ($post)
    {
        require_once ('XML/RPC.php');

        $retval = false;

        if (empty ($post)) {
            return $retval;
        }

        $links = $this->prepareLinks ($post);
        if (empty ($links)) {
            return $retval;
        }

        if ($this->_verbose) {
            SPAMX_log ("Sending to SLV: $links");
        }

        $params = array (new XML_RPC_Value ($links, 'string'));
        $msg = new XML_RPC_Message ('slv', $params);
        $cli = new XML_RPC_Client ('/slv.php', 'http://www.linksleeve.org');

        if ($this->_debug) {
            $client->setDebug (1);
        }

        $resp = $cli->send ($msg);
        if (!$resp) {
            COM_errorLog ('Error communicating with SLV: ' . $cli->errstr
                          . '; Message was ' . $msg->serialize());
        } else if ($resp->faultCode ()) {
            COM_errorLog ('Error communicating with SLV. Fault code: '
                          . $resp->faultCode() . ', Fault reason: '
                          . $resp->faultString() . '; Message was '
                          . $msg->serialize());
        } else {
            $val = $resp->value();
            // note that SLV returns '1' for acceptable posts and '0' for spam
            if ($val->scalarval() != '1') {
                $retval = true;
                SPAMX_log ("SLV: spam detected");
            } else if ($this->_verbose) {
                SPAMX_log ("SLV: no spam detected");
            }
        }

        return $retval;
    }

    /**
    * Extract links
    *
    * Extracts all the links from a post; expects HTML links, i.e. <a> tags
    *
    * @param    string  $comment    The post to check
    * @return   string              All the URLs in the post, sep. by linefeeds
    *
    */
    function getLinks ($comment)
    {
        global $_CONF;

        $links = '';

        preg_match_all( "/<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)<\/a>/i",
                        $comment, $matches );
        for ($i = 0; $i < count ($matches[0]); $i++) {
            $url = $matches[1][$i];
            if (strpos ($url, $_CONF['site_url']) === 0) {
                // skip links to our own site
                continue;
            } else {
                $links .= $url . "\n";
            }
        }

        return $links;
    }

    /**
    * Extract only the links from the post
    *
    * SLV has a problem with non-ASCII character sets, so we feed it the URLs
    * only. We also remove all URLs containing our site's URL.
    *
    * Since we don't know if the post is in HTML or plain ASCII, we run it
    * through getLinks() twice.
    *
    * @param    string  $comment    The post to check
    * @return   string              All the URLs in the post, sep. by linefeeds
    *
    */
    function prepareLinks ($comment)
    {
        // some spam posts have extra backslashes
        $comment = stripslashes ($comment);

        // some spammers have yet to realize that we're not supporting BBcode
        // but since we want the URLs, convert it here ...
        $comment = preg_replace ('/\[url=([^\]]*)\]/i', '<a href="\1">',
                                 $comment);
        $comment = str_replace (array ('[/url]', '[/URL]'),
                                array ('</a>',   '</a>'  ), $comment);

        // get all links from <a href="..."> tags
        $links = $this->getLinks ($comment);

        // strip all HTML, then get all the plain text links
        $comment = COM_makeClickableLinks (strip_tags ($comment));
        $links .= $this->getLinks ($comment);

        return $links;
    }
}

?>
