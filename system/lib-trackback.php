<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | lib-trackback.php                                                         |
// |                                                                           |
// | Functions needed to handle trackback comments.                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2005-2006 by the following authors:                         |
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
// $Id: lib-trackback.php,v 1.21 2006/01/08 11:20:44 dhaun Exp $

if (eregi ('lib-trackback.php', $_SERVER['PHP_SELF'])) {
    die ('This file can not be used on its own.');
}

// result codes for TRB_saveTrackbackComment
define ('TRB_SAVE_OK',      0);
define ('TRB_SAVE_SPAM',   -1);
define ('TRB_SAVE_REJECT', -2);

/**
* Send a trackback response message
*
* @param    int     $error          0 = OK, 1 = an error occured
* @param    string  $errormsg       the error message (ignored for $error == 0)
* @param    int     $http_status    optional HTTP status code
* @param    string  $http_text      optional HTTP status code text
* @return   void
*
*/
function TRB_sendTrackbackResponse ($error, $errormsg = '', $http_status = 200, $http_text = "OK")
{
    $display = '<?xml version="1.0" encoding="iso-8859-1"?>' . LB
             . '<response>' . LB
             . '<error>' . $error . '</error>' . LB;
    if (($error != 0) && !empty ($errormsg)) {
        // we're creating XML, so encode these ...
        $errormsg = str_replace (array ('<',    '>',    "'"),
                                 array ('&lt;', '&gt;', '&apos;'), $errormsg);
        $display .= '<message>' . $errormsg . '</message>' . LB;
    }
    $display .= '</response>';

    if ($http_status != 200)
    {
        header ("HTTP/1.1 $http_status $http_text");
        header ("Status: $http_status $http_text");
    }
    header ('Content-Type: text/xml');
    echo $display;
}

/**
* Creates a piece of RDF pointing out the trackback URL
*
* Note: When putting this in an HTML page, it may be advisable to enclose it
*       in HTML comments, i.e. <!-- ... -->
*
* @param    string  $article_url    URL of our entry
* @param    string  $title          title of that entry
* @param    string  $trackback_url  trackback URL for our entry
* @return   string                  RDF code with our information embedded
*
*/
function TRB_trackbackRdf ($article_url, $title, $trackback_url)
{
    // we're creating XML, so encode these ...
    $title = str_replace (array ('<',    '>',    "'"),
                          array ('&lt;', '&gt;', '&apos;'), $title);

    $retval = '<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"' . LB
            . '         xmlns:trackback="http://madskills.com/public/xml/rss/module/trackback/"' . LB
            . '         xmlns:dc="http://purl.org/dc/elements/1.1/">' . LB;
    $retval .= '<rdf:Description' . LB
            .  '    rdf:about="' . $article_url . '"' . LB
            .  '    trackback:ping="' . $trackback_url . '"' .LB
            .  '    dc:title="' . $title . '"' . LB
            .  '    dc:identifier="' . $article_url . '" />' . LB;
    $retval .= '</rdf:RDF>';

    return $retval;
}

/**
* Returns the trackback URL for an entry
*
* Note: Trackback pings default to stories, so we leave off the type if it
*       is 'article' to create shorter URLs.
*
* @param    string  $id     the entry's ID
* @param    string  $type   type of the entry ('article' = story, etc.)
* @return   string          trackback URL for that entry
*
*/
function TRB_makeTrackbackUrl ($id, $type = 'article')
{
    global $_CONF;

    $url = $_CONF['site_url'] . '/trackback.php?id=' . $id;
    if (!empty ($type) && ($type != 'article')) {
        $url .= '&amp;type=' . $type;
    }

    return COM_buildUrl ($url);
}

/**
* Filter the title for a trackback comment we've received
*
* @param    string  $title  title of the comment
* @return   string          filtered title
*
*/
function TRB_filterTitle ($title)
{
    return htmlspecialchars (COM_checkWords (strip_tags (COM_stripslashes ($title))));
}

/**
* Filter the blog name for a trackback comment we've received
*
* @param    string  $blogname   blog name for the comment
* @return   string              filtered blog name
*
*/
function TRB_filterBlogname ($blogname)
{
    return htmlspecialchars (COM_checkWords (strip_tags (COM_stripslashes ($blogname))));
}

/**
* Filter the excerpt of a trackback comment we've received
*
* Note: Does not truncate the excerpt.
*
* @param    string  $excerpt    excerpt of the trackback comment
* @return   string              filtered excerpt
*
*/
function TRB_filterExcerpt ($excerpt)
{
    return COM_checkWords (strip_tags (COM_stripslashes ($excerpt)));
}

/**
* Check if the current user is allowed to delete trackback comments.
*
* @param    string  $sid    ID of the parent object of the comment
* @param    string  $type   type of the parent object ('article' = story, etc.)
* @return   bool            true = user can delete the comment, false = nope
*
*/
function TRB_allowDelete ($sid, $type)
{
    global $_TABLES;

    $allowed = false;

    if ($type == 'article') {
        $sid = addslashes ($sid);
        $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'" . COM_getPermSql ('AND', 0, 3) . COM_getTopicSql ('AND'));
        $A = DB_fetchArray ($result);

        if (SEC_hasRights ('story.edit') && (SEC_hasAccess ($A['owner_id'],
                    $A['group_id'], $A['perm_owner'], $A['perm_group'],
                    $A['perm_members'], $A['perm_anon']) == 3)) {
            $allowed = true;
        } else {
            $allowed = false;
        }
    } else {
        $allowed = PLG_handlePingComment ($type, $sid, 'delete');
    }

    return $allowed;
}

/**
* Check a trackback / pingback for spam
*
* @param    string  $url        URL of the trackback comment
* @param    string  $title      title of the comment (set to $url if empty)
* @param    string  $blog       name of the blog that sent the comment
* @param    string  $excerpt    excerpt from the comment
* @return   int                 TRB_SAVE_OK or TRB_SAVE_SPAM
*
*/
function TRB_checkForSpam ($url, $title = '', $blog = '', $excerpt = '')
{
    global $_CONF;

    $comment = TRB_formatComment ($url, $title, $blog, $excerpt);
    $result = PLG_checkforSpam ($comment, $_CONF['spamx']);

    if ($result > 0) {
        return TRB_SAVE_SPAM;
    }

    return TRB_SAVE_OK;
}

/**
* Save a trackback (or pingback) comment.
*
* Also filters parameters and handles multiple trackbacks from the same source.
*
* Note: Spam check should have been done before calling this function.
*
* @param    string  $sid        entry id
* @param    string  $type       type of entry ('article' = story, etc.)
* @param    string  $url        URL of the trackback comment
* @param    string  $title      title of the comment (set to $url if empty)
* @param    string  $blog       name of the blog that sent the comment
* @param    string  $excerpt    excerpt from the comment
* @return   int                 < 0: error, > 0: ID of the trackback comment
*
*/
function TRB_saveTrackbackComment ($sid, $type, $url, $title = '', $blog = '', $excerpt = '')
{
    global $_CONF, $_TABLES;

    $url = COM_applyFilter ($url);
    $title = TRB_filterTitle ($title);
    $blog = TRB_filterBlogname ($blog_name);
    $excerpt = TRB_filterExcerpt ($excerpt);

    // MT does that, so follow its example ...
    if (strlen ($excerpt) > 255) {
        $excerpt = substr ($excerpt, 0, 252) . '...';
    }

    $title   = str_replace (array ('$',     '{',      '}'),
                            array ('&#36;', '&#123;', '&#126;'), $title);
    $excerpt = str_replace (array ('$',     '{',      '}'),
                            array ('&#36;', '&#123;', '&#126;'), $excerpt);
    $blog    = str_replace (array ('$',     '{',      '}'),
                            array ('&#36;', '&#123;', '&#126;'), $blog);

    $url     = addslashes ($url);
    $title   = addslashes ($title);
    $blog    = addslashes ($blog);
    $excerpt = addslashes ($excerpt);

    if ($_CONF['multiple_trackbacks'] == 0) {
        // multiple trackbacks not allowed - check if we have this one already
        if (DB_count ($_TABLES['trackback'], array ('url', 'sid', 'type'),
                      array ($url, $sid, $type)) >= 1) {
            return TRB_SAVE_REJECT;
        }
    } else if ($_CONF['multiple_trackbacks'] == 1) {
        // delete any earlier trackbacks from the same URL
        DB_delete ($_TABLES['trackback'], array ('url', 'sid', 'type'),
                   array ($url, $sid, $type));
    } // else: multiple trackbacks allowed

    DB_save ($_TABLES['trackback'], 'sid,url,title,blog,excerpt,date,type,ipaddress',
             "'$sid','$url','$title','$blog','$excerpt',NOW(),'$type','{$_SERVER['REMOTE_ADDR']}'");

    $comment_id = DB_insertId ();

    if ($type == 'article') {
        DB_query ("UPDATE {$_TABLES['stories']} SET trackbacks = trackbacks + 1 WHERE (sid = '$sid')");
    }

    return $comment_id;
}

/**
* Delete a trackback comment
*
* Note: Permission checks have to be done by the caller.
*
* @param    int     $cid    ID of the trackback comment
* @return   void
*
*/
function TRB_deleteTrackbackComment ($cid)
{
    global $_TABLES;

    $cid = addslashes ($cid);
    DB_delete ($_TABLES['trackback'], 'cid', $cid);
}

/**
* Format one trackback comment for display
*
* Note: $excerpt is not truncated - this should have been done elsewhere
*
* @param    string      $url        URL of the trackback comment
* @param    string      $title      title of the comment (set to $url if empty)
* @param    string      $blog       name of the blog that sent the comment
* @param    string      $excerpt    excerpt from the comment
* @param    timestamp   $date       date and time when the comment was sent
* @param    bool        $delete_option  whether to display a link to delete the trackback comment
* @param    string      $cid        id of this trackback comment
* @param    string      $ipaddress  IP address the comment was sent from
* @return   string                  HTML of the formatted trackback comment
*
*/
function TRB_formatComment ($url, $title = '', $blog = '', $excerpt = '', $date = 0, $delete_option = false, $cid = '', $ipaddress = '')
{
    global $_CONF, $LANG01, $LANG_TRB;

    if (empty ($title)) {
        $title = $url;
    }

    if ($date == 0) {
        $date = time ();
    }
    $curtime = COM_getUserDateTimeFormat ($date);

    $template = new Template ($_CONF['path_layout'] . 'trackback');
    $template->set_file (array ('comment' => 'formattedcomment.thtml'));
    $template->set_var ('site_url', $_CONF['site_url']);
    $template->set_var ('layout_url', $_CONF['layout_url']);

    $template->set_var ('lang_from', $LANG_TRB['from']);
    $template->set_var ('lang_tracked_on', $LANG_TRB['tracked_on']);
    $template->set_var ('lang_readmore', $LANG_TRB['read_more']);

    $anchor = '<a href="' . $url . '">';
    $readmore = $anchor . $LANG_TRB['read_more'] . '</a>';

    $template->set_var ('readmore_link', $readmore);
    $template->set_var ('start_readmore_anchortag', $anchor);
    $template->set_var ('end_readmore_anchortag', '</a>');

    $template->set_var ('trackback_url', $url);
    $template->set_var ('trackback_title', $title);
    $template->set_var ('trackback_blog_name', $blog);
    $template->set_var ('trackback_date', $curtime[0]);

    if (empty ($blog)) {
        $template->set_var ('trackback_from_blog_name', '');
    } else {
        $template->set_var ('trackback_from_blog_name', $LANG_TRB['from'] . ' '
                                                        . $blog);
    }
    if (empty ($excerpt)) {
        $template->set_var ('trackback_excerpt', '');
        $template->set_var ('trackback_excerpt_readmore', '');
        $template->set_var ('excerpt_br', '');
    } else {
        $template->set_var ('trackback_excerpt', $excerpt);
        $template->set_var ('trackback_excerpt_readmore',
                            $excerpt . ' ' . $readmore);
        $template->set_var ('excerpt_br', '<br>');
    }

    $deloption = '';
    if ($delete_option) {
        $deloption .= '[ ';
        $deloption .= '<a href="' . $_CONF['site_admin_url']
                   . '/trackback.php?mode=delete&amp;cid=' . $cid . '">'
                   . $LANG01[28] . '</a>';
        if (!empty ($ipaddress)) {
            if (empty ($_CONF['ip_lookup'])) {
                $deloption .= ' | ' . $ipaddress;
            } else {
                $iplookup = str_replace ('*', $ipaddress, $_CONF['ip_lookup']);
                $deloption .= ' | <a href="' . $iplookup . '">' . $ipaddress
                           . '</a>';
            }
        }
        $deloption .= ' ]';
    }
    $template->set_var ('delete_option', $deloption);

    $template->parse ('output', 'comment');
    return $template->finish ($template->get_var ('output'));
}

/**
* Handles a trackback ping for an entry.
*
* Also takes care of the speedlimit and spam. Assumes that the caller of this
* function has already checked permissions!
*
* Note: Error messages are XML-formatted and echo'd out directly, as they
*       are supposed to be processed by some sort of software.
*
* @param    string  $sid    ID of entry that got pinged
* @param    string  $type   type of that entry ('article' for stories, etc.)
* @return   bool            true = success, false = an error occured
*
*/
function TRB_handleTrackbackPing ($sid, $type = 'article')
{
    global $_CONF, $_TABLES;

    // Note: Error messages are hard-coded in English since there is no way of
    // knowing which language the sender of the trackback ping may prefer.
    $TRB_ERROR = array (
        'no_url'     => 'No URL given.',
        'rejected'   => 'Multiple posts not allowed.',
        'spam'       => 'Spam detected.',
        'speedlimit' => 'Your last trackback comment was %d seconds ago. This site requires at least %d seconds between trackback comments.'
    );

    if (isset ($_POST['url'])) { // a URL is mandatory ...

        // the speed limit applies to trackback comments, too
        COM_clearSpeedlimit ($_CONF['commentspeedlimit'], 'trackback');
        $last = COM_checkSpeedlimit ('trackback');
        if ($last > 0) {
            TRB_sendTrackbackResponse (1, sprintf ($TRB_ERROR['speedlimit'],
                                       $last, $_CONF['commentspeedlimit']),
                                       403, 'Forbidden');

            return false;
        }

        // do spam check on the unfiltered post
        $result = TRB_checkForSpam ($_POST['url'], $_POST['title'],
                                    $_POST['blog_name'], $_POST['excerpt']);

        // update speed limit in any case
        COM_updateSpeedlimit ('trackback');

        if ($result == TRB_SAVE_SPAM) {
            TRB_sendTrackbackResponse (1, $TRB_ERROR['spam'], 403, 'Forbidden');

            return false;
        }

        $saved = TRB_saveTrackbackComment ($sid, $type, $_POST['url'],
                    $_POST['title'], $_POST['blog_name'], $_POST['excerpt']);

        if ($saved == TRB_SAVE_REJECT) {
            TRB_sendTrackbackResponse (1, $TRB_ERROR['rejected']);

            return false;
        }

        if (isset ($_CONF['notification']) &&
                in_array ('trackback', $_CONF['notification'])) {
            TRB_sendNotificationEmail ($saved, 'trackback');
        }

        TRB_sendTrackbackResponse (0);

        return true;
    } else {
        TRB_sendTrackbackResponse (1, $TRB_ERROR['no_url']);
    }

    return false;
}

/**
* Render all the trackback comments for a specific entry
*
* @param    string  $sid            entry id
* @param    string  $type           type of entry ('article' = story, etc.)
* @param    string  $title          the entry's title
* @param    string  $permalink      link to the entry
* @param    string  trackback_url   trackback URL for this entry
* @return   string                  HTML (formatted list of trackback comments)
*
*/
function TRB_renderTrackbackComments ($sid, $type, $title, $permalink, $trackback_url = '')
{
    global $_CONF, $_TABLES, $LANG_TRB;

    $link_and_title = '<a href="' . $permalink . '">' . $title . '</a>';
    if (empty ($trackback_url)) {
        $trackback_url = TRB_makeTrackbackUrl ($sid, $type);
    }

    $template = new Template ($_CONF['path_layout'] . 'trackback');
    $template->set_file (array ('trackback' => 'trackback.thtml',
                                'comment'   => 'trackbackcomment.thtml'));
    $template->set_var ('site_url', $_CONF['site_url']);
    $template->set_var ('layout_url', $_CONF['layout_url']);

    $template->set_var ('lang_trackback', $LANG_TRB['trackback']);
    $template->set_var ('lang_trackback_url', $LANG_TRB['this_trackback_url']);

    $template->set_var ('permalink', $permalink);
    $template->set_var ('permalink_and_title', $link_and_title);
    $template->set_var ('trackback_url', $trackback_url);

    $result = DB_query ("SELECT cid,url,title,blog,excerpt,ipaddress,UNIX_TIMESTAMP(date) AS day FROM {$_TABLES['trackback']} WHERE sid = '$sid' AND type = '$type' ORDER BY date");
    $numrows = DB_numRows ($result);

    $template->set_var ('trackback_comment_count', $numrows);
    $num_comments = sprintf ($LANG_TRB['num_comments'], $numrows);
    $template->set_var ('trackback_comment_text', $num_comments);
    if ($numrows == 0) {
        $template->set_var ('lang_trackback_comments',
                            $LANG_TRB['no_comments']);
        $template->set_var ('lang_trackback_comments_no_link',
                            $LANG_TRB['no_comments']);
    } else {
        $template->set_var ('lang_trackback_comments',
                            sprintf ($LANG_TRB['intro_text'], $link_and_title));
        $template->set_var ('lang_trackback_comments_no_link',
                            sprintf ($LANG_TRB['intro_text'], $title));
    }

    $delete_option = TRB_allowDelete ($sid, $type);

    for ($i = 0; $i < $numrows; $i++) {
        $A = DB_fetchArray ($result);
        $comment = TRB_formatComment ($A['url'], $A['title'], $A['blog'],
                        $A['excerpt'], $A['day'], $delete_option, $A['cid'],
                        $A['ipaddress']);
        $template->set_var ('formatted_comment', $comment);
        $template->parse ('trackback_comments', 'comment', true);
    }
    $template->parse ('output', 'trackback');

    return $template->finish ($template->get_var ('output'));
}

/**
* Send a trackback ping
*
* Based on a code snippet by Jannis Hermanns,
* http://www.jannis.to/programming/trackback.html
*
* @param    string  $targeturl  URL to ping
* @param    string  $url        URL of our entry
* @param    string  $title      title of our entry
* @param    string  $excerpt    text excerpt from our entry
* @param    string  $blog       name of our Geeklog site
* @return   mixed               true = success, otherwise: error message
*
*/
function TRB_sendTrackbackPing ($targeturl, $url, $title, $excerpt, $blog = '')
{
    global $_CONF, $LANG_TRB, $LANG_CHARSET;

    if (empty ($blog)) {
        $blog = $_CONF['site_name'];
    }

    $target = parse_url ($targeturl);
    if (!empty ($target['query'])) {
        $target['query'] = '?' . $target['query'];
    }
    if (!is_numeric ($target['port'])) {
        $target['port'] = 80;
    }

    $sock = fsockopen ($target['host'], $target['port']);
    if (!is_resource ($sock)) {
        COM_errorLog ('Trackback: Could not connect to ' . $targeturl);

        return $LANG_TRB['error_socket'];
    }

    $toSend = 'url=' . rawurlencode ($url) . '&title=' . rawurlencode ($title)
            . '&blog_name=' . rawurlencode ($blog) . '&excerpt='
            . rawurlencode ($excerpt);

    if (empty ($LANG_CHARSET)) {
        $charset = $_CONF['default_charset'];

        if (empty ($charset)) {
            $charset = 'iso-8859-1';
        }
    } else {
        $charset = $LANG_CHARSET;
    }

    fputs ($sock, 'POST ' . $target['path'] . $target['query'] . " HTTP/1.1\r\n");
    fputs ($sock, 'Host: ' . $target['host'] . "\r\n");
    fputs ($sock, 'Content-type: application/x-www-form-urlencoded; charset='
                  . $charset . "\r\n");
    fputs ($sock, 'Content-length: ' . strlen ($toSend) . "\r\n");
    fputs ($sock, 'User-Agent: GeekLog ' . VERSION . "\r\n");
    fputs ($sock, "Connection: close\r\n\r\n");
    fputs ($sock, $toSend);

    $res = '';
    while (!feof ($sock)) {
        $res .= fgets ($sock, 128);
    }

    fclose($sock);

    // firing up the XML parser for this would be overkill ...
    $r1 = strpos ($res, '<error>');
    $r2 = strpos ($res, '</error>');
    if (($r1 === false) || ($r2 === false)) {
        return $LANG_TRB['error_response'];
    }
    $r1 += strlen ('<error>');
    $e = trim (substr ($res, $r1, $r2 - $r1));

    if ($e != 0) {
        $r1 = strpos ($res, '<message>');
        $r2 = strpos ($res, '</message>');
        $r1 += strlen ('<message>');
        if (($r1 === false) || ($r2 === false)) {
            return $LANG_TRB['error_unspecified'];
        }
        $m = trim (substr ($res, $r1, $r2 - $r1));

        return $m;
    }

    return true;
}

/**
* Attempt to auto-detect the Trackback URL of a post.
*
* @param    string  $url    URL of post with embedded RDF for the Trackback URL
* @return   mixed           Trackback URL, or false on error
*
* Note: The RDF, if found, is only parsed using a regular expression. Using
*       the XML parser may be more successful on some occassions ...
*
*/
function TRB_detectTrackbackUrl ($url)
{
    require_once ('HTTP/Request.php');

    $retval = false;

    $req =& new HTTP_Request ($url);
    $req->setMethod (HTTP_REQUEST_METHOD_GET);
    $req->addHeader ('User-Agent', 'GeekLog ' . VERSION);

    $response = $req->sendRequest ();
    if (PEAR::isError ($response)) {
        COM_errorLog ('TRB_detectTrackbackUrl: ' . $response->getMessage());

        return false;
    }

    $page = $req->getResponseBody ();

    // search for the RDF first
    $startpos = strpos ($page, '<rdf:RDF ');
    if ($startpos !== false) {
        $endpos = strpos ($page, '</rdf:RDF>', $startpos);

        $endpos += strlen ('</rdf:RDF>');
        $rdf = substr ($page, $startpos, $endpos - $startpos);

        // Okay, we COULD fire up the XML parser now. But then again ...
        if (preg_match ('/trackback:ping="(.*)"/', $rdf, $matches) == 1) {
            if (!empty ($matches[1])) {
                $retval = $matches[1];
            }
        }
    }

    // no luck with the RDF? try searching for a rel="trackback" link
    if ($retval === false) {
        // remove all linefeeds first to help the regexp below
        $page = preg_replace( "/(\015\012)|(\015)|(\012)/", '', $page);

        preg_match_all( "/<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)<\/a>/i", $page, $matches );
COM_errorLog("links found: " . count ($matches[0]));
        for ($i = 0; $i < count ($matches[0]); $i++) {
            $link = $matches[0][$i];
COM_errorLog($link);
            if (strpos ($link, 'rel="trackback"') !== false) {
                $retval = $matches[1][$i];
                break;
            }
        }
    }

    return $retval;
}

/**
* Send a notification email when a new trackback comment has been posted
*
* @param    int     $cid    ID of the trackback comment
* @param    string  $what   type of notification: 'trackback' or 'pingback'
* @return   void
*
*/
function TRB_sendNotificationEmail ($cid, $what = 'trackback')
{
    global $_CONF, $_TABLES, $LANG03, $LANG08, $LANG09, $LANG29, $LANG_TRB;

    $cid = addslashes ($cid);
    $result = DB_query ("SELECT sid,type,title,excerpt,url,blog,ipaddress FROM {$_TABLES['trackback']} WHERE (cid = '$cid')");
    $A = DB_fetchArray ($result);
    $type = $A['type'];
    $id = $A['sid'];

    $mailbody = '';
    if (!empty ($A['title'])) {
        $mailbody .= $LANG03[16] . ': ' . $A['title'] . "\n";
    }
    $mailbody .= $LANG_TRB['blog_name'] . ': ';
    if (!empty ($A['blog'])) {
        $mailbody .= $A['blog'] . ' ';
    }
    $mailbody .= '(' . $A['ipaddress'] . ")\n";
    $mailbody .= $LANG29[12] . ': ' . $A['url'] . "\n";

    if ($type != 'article') {
        $mailbody .= $LANG09[5] . ': ' . $type . "\n";
    }

    if (!empty ($A['excerpt'])) {
        // the excerpt is max. 255 characters long anyway, so we add it
        // in its entirety
        $mailbody .= $A['excerpt'] . "\n\n";
    }

    if ($type == 'article') {
        $commenturl = COM_buildUrl ($_CONF['site_url'] . '/article.php?story='
                                    . $id) . '#trackback';
    } else {
        $commenturl = PLG_getItemInfo ($type, $id, 'url');
    }

    $mailbody .= $LANG08[33] . ' <' . $commenturl . ">\n\n";

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    if ($what == 'pingback') {
        $mailsubject = $_CONF['site_name'] . ' ' . $LANG_TRB['pingback'];
    } else {
        $mailsubject = $_CONF['site_name'] . ' ' . $LANG_TRB['trackback'];
    }

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

?>
