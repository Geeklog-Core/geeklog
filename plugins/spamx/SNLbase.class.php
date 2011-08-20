<?php

/**
* File: SNLbase.class.php
* Spam Number of Links (SNL) Base Class
*
* Copyright  (C) 2006 Tom Homer	 - WebSiteMaster AT cogeco DOT com   
*
* Licensed under the GNU General Public License
*
*
*/

if (strpos ($_SERVER['PHP_SELF'], 'SNLbase.class.php') !== false) {
    die ('This file can not be used on its own!');
}

/**
* Checks number of links in post.
*
* based in large part on the works of Dirk Haun, Tom Willet (Spam-X) and Russ Jones (SLV)
*/

class SNLbase {

    var $_debug = false;

    var $_verbose = false;

    /**
    * Constructor
    */
    function SNLbase()
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
    * Note: Also returns 'false' in case of problems communicating with SNL.
    *       Error messages are logged in Geeklog's error.log
    *
    */
    function CheckForSpam ($post)
    {
        global $_SPX_CONF;
        
        $retval = false;
        
        if (!isset ($_SPX_CONF['snl_enabled'])) {
            $_SPX_CONF['snl_enabled'] = false;
        }
        
        if (empty ($post) || !$_SPX_CONF['snl_enabled']) {
            return $retval;
        }

        $links = $this->prepareLinks ($post);
        if (empty ($links)) {
            return $retval;
        }
        
        if (!isset ($_SPX_CONF['snl_num_links'])) {
            $_SPX_CONF['snl_num_links'] = 5;
        }
        
        if ($links > $_SPX_CONF['snl_num_links']) {
            $retval = true;
            SPAMX_log ("SNL: spam detected, found " . $links . " links.");
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

        preg_match_all( "/<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)<\/a>/i", $comment, $matches );
        for ($i = 0; $i < count ($matches[0]); $i++) {
            $url = $matches[1][$i];
            if (strpos ($url, $_CONF['site_url']) === 0) {
                // skip links to our own site
                continue;
            } else {
                // $links .= $url . "\n";
                $links = $links + 1;
            }
        }

        return $links;
    }

    /**
    * Extract only the links from the post
    *
    * SNL has a problem with non-ASCII character sets, so we feed it the URLs
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
        $links = $links + $this->getLinks ($comment);

        return $links;
    }
}

?>
