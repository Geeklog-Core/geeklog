<?php

/* Reminder: always indent with 4 spaces (no tabs). */                         
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | trackback.php                                                             |
// |                                                                           |
// | Admin functions to send and delete trackback comments.                    |
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
// $Id: trackback.php,v 1.6 2005/01/30 20:01:23 dhaun Exp $

require_once ('../lib-common.php');

/**
* Security check to ensure user even belongs on this page
*/
require_once ('auth.inc.php');

if (!$_CONF['trackback_enabled'] && !$_CONF['pingback_enabled']) {
    echo COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    exit;
}

$display = '';

if (!SEC_hasRights ('story.ping')) {
    $display .= COM_siteHeader ('menu');
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header')); 
    $display .= $MESSAGE[31];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    COM_accessLog("User {$_USER['username']} tried to illegally access the trackback administration screen.");
    echo $display;
    exit;
}

require_once ($_CONF['path_system'] . 'lib-trackback.php');
require_once ($_CONF['path_system'] . 'lib-pingback.php');
require_once ($_CONF['path_system'] . 'lib-story.php');

/**
* Display trackback comment submission form.
*
* @param    string  $target     URL to send the trackback comment to
* @param    string  $url        URL of our entry
* @param    string  $title      title of our entry
* @param    string  $excerpt    excerpt of our entry
* @param    string  $blog       name of our site
* @return   string              HTML for the trackback comment editor
*
*/
function trackback_editor ($target = '', $url = '', $title = '', $excerpt = '', $blog = '')
{
    global $_CONF, $LANG_TRB;

    $retval = '';

    // show preview if we have at least the URL
    if (!empty ($url)) {
        // filter them for the preview
        $p_title = TRB_filterTitle ($title);
        $p_excerpt = TRB_filterExcerpt ($excerpt);
        $p_blog = TRB_filterBlogname ($blog);

        // MT and other weblogs will shorten the excerpt like this
        if (strlen ($p_excerpt) > 255) {
            $p_excerpt = substr ($p_excerpt, 0, 252) . '...';
        }

        $retval .= COM_startBlock ($LANG_TRB['preview']);

        $preview = new Template ($_CONF['path_layout'] . 'trackback');
        $preview->set_file (array ('comment' => 'trackbackcomment.thtml'));
        $comment = TRB_formatComment ($url, $p_title, $p_blog, $p_excerpt);
        $preview->set_var ('formatted_comment', $comment);
        $preview->parse ('output', 'comment');
        $retval .= $preview->finish ($preview->get_var ('output'));

        $retval .= COM_endBlock ();
    }

    if (empty ($url) && empty ($blog)) {
        $blog = htmlspecialchars ($_CONF['site_name']);
    }
    $title = htmlspecialchars ($title);
    $excerpt = htmlspecialchars ($excerpt, ENT_NOQUOTES);

    $retval .= COM_startBlock ($LANG_TRB['editor_title'], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    $template = new Template ($_CONF['path_layout'] . 'admin/trackback');
    $template->set_file (array ('editor' => 'trackbackeditor.thtml'));

    $template->set_var ('site_url', $_CONF['site_url']);
    $template->set_var ('site_admin_url', $_CONF['site_admin_url']);
    $template->set_var ('layout_url', $_CONF['layout_url']);
    $template->set_var ('php_self', $_CONF['site_admin_url']
                                    . '/trackback.php');

    $template->set_var ('lang_trackback_url', $LANG_TRB['trackback_url']);
    $template->set_var ('lang_entry_url', $LANG_TRB['entry_url']);
    $template->set_var ('lang_title', $LANG_TRB['entry_title']);
    $template->set_var ('lang_blog_name', $LANG_TRB['blog_name']);
    $template->set_var ('lang_excerpt', $LANG_TRB['excerpt']);
    $template->set_var ('lang_excerpt_truncated',
                        $LANG_TRB['truncate_warning']);
    $template->set_var ('lang_send', $LANG_TRB['button_send']);
    $template->set_var ('lang_preview', $LANG_TRB['button_preview']);

    $template->set_var ('max_url_length', 255);
    $template->set_var ('target_url', $target);
    $template->set_var ('url', $url);
    $template->set_var ('title', $title);
    $template->set_var ('blog_name', $blog);
    $template->set_var ('excerpt', $excerpt);

    $template->parse ('output', 'editor');
    $retval .= $template->finish ($template->get_var ('output'));

    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

/**
* Deletes a trackback comment. Checks if the current user has proper
* permissions first.
*
* @param    int     $id     ID of the trackback comment to delete
* @return   string          HTML redirect
*
*/
function deleteTrackbackComment ($id)
{
    global $_TABLES;

    $retval = COM_refresh ($_CONF['site_admin_url'] . '/trackback.php?mgs=63');

    $cid = addslashes ($id);
    $result = DB_query ("SELECT sid,type FROM {$_TABLES['trackback']} WHERE cid = '$cid'");
    list ($sid, $type) = DB_fetchArray ($result);

    if ($type == 'article') {
        $url = STORY_getItemInfo ($sid, 'url');
    } else {
        $url = PLG_getItemInfo ($type, $sid, 'url');
    }

    if (TRB_allowDelete ($sid, $type)) {
        TRB_deleteTrackbackComment ($id);
        $msg = 62;
    } else {
        $msg = 63;
    }
    if (strpos ($url, '?') === false) {
        $url .= '?msg=' . $msg;
    } else {
        $url .= '&msg=' . $msg;
    }

    return COM_refresh ($url);
}

/**
* Show an error or warning message
*
* @param    string  $title      block title
* @param    string  $message    the actual message
* @return   string              HTML for the message block
*
*/
function showTrackbackMessage ($title, $message)
{
    $retval = '';

    $retval .= COM_startBlock ($title, '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
            . $message
            . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));

    return $retval;
}

/**
* Send a Pingback to all the links in our entry
*
* @param    string  $type   type of entry we're advertising ('article' = story)
* @param    string  $id     ID of that entry
* @return   string          pingback results
*
*/
function sendPingbacks ($type, $id)
{
    global $_CONF, $LANG_TRB;

    $retval = '';

    if ($type == 'article') {
        list ($url, $text) = STORY_getItemInfo ($id, 'url,description');
    } else {
        list ($url, $text) = PLG_getItemInfo ($type, $id, 'url,description');
    }

    // extract all links from the text
    preg_match_all ("/<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)<\/a>/i", $text,
                    $matches);
    $numlinks = count ($matches[0]);
    if ($numlinks > 0) {
        $links = array ();
        for ($i = 0; $i < $numlinks; $i++) {
            $links[$matches[2][$i]] = $matches[1][$i];
        }
        $links = array_unique ($links);

        $template = new Template ($_CONF['path_layout'] . 'admin/trackback');
        $template->set_file (array ('list' => 'pingbacklist.thtml',
                                    'item' => 'pingbackitem.thtml'));
        $template->set_var ('site_url', $_CONF['site_url']);
        $template->set_var ('site_admin_url', $_CONF['site_admin_url']);
        $template->set_var ('layout_url', $_CONF['layout_url']);
        $template->set_var ('lang_resend', $LANG_TRB['resend']);
        $template->set_var ('lang_results', $LANG_TRB['pingback_results']);

        $counter = 1;
        foreach ($links as $key => $URLtoPing) {
            $result = PNB_sendPingback ($url, $URLtoPing);
            $resend = '';
            if (empty ($result)) {
                $result = '<b>' . $LANG_TRB['pingback_success'] . '</b>';
            } else if ($result != $LANG_TRB['no_pingback_url']) {
                $result = '<span class="warningsmall">' . $result . '</span>';
                // TBD: $resend = '...';
            }
            $parts = parse_url ($URLtoPing);

            $template->set_var ('url_to_ping', $URLtoPing);
            $template->set_var ('link_text', $key);
            $template->set_var ('host_name', $parts['host']);
            $template->set_var ('pingback_result', $result);
            $template->set_var ('resend', $resend);
            $template->set_var ('alternate_row',
                    ($counter % 2) == 0 ? 'row-even' : 'row-odd');
            $template->parse ('pingback_results', 'item', true);
            $counter++;
        }
        $template->parse ('output', 'list');
        $retval .= $template->finish ($template->get_var ('output'));

    } else {
        $retval = $LANG_TRB['no_links_pingback'];
    }

    return $retval;
}

/**
* Ping weblog directory services
*
* @param    string  $type   type of entry we're advertising ('article' = story)
* @param    string  $id     ID of that entry
* @return   string          result of the pings
*
*/
function sendPings ($type, $id)
{
    global $_CONF, $LANG_TRB;

    $retval = '';

    if ($type == 'article') {
        list ($itemurl,$feedurl) = STORY_getItemInfo ($id, 'url,feed');
    } else {
        list ($itemurl,$feedurl) = PLG_getItemInfo ($type, $id, 'url,feed');
    }

    $template = new Template ($_CONF['path_layout'] . 'admin/trackback');
    $template->set_file (array ('list' => 'pinglist.thtml',
                                'item' => 'pingitem.thtml'));
    $template->set_var ('site_url', $_CONF['site_url']);
    $template->set_var ('site_admin_url', $_CONF['site_admin_url']);
    $template->set_var ('layout_url', $_CONF['layout_url']);
    $template->set_var ('lang_resend', $LANG_TRB['resend']);
    $template->set_var ('lang_results', $LANG_TRB['ping_results']);

    $counter = 1;
    foreach ($_CONF['ping_sites'] as $site) {
        $resend = '';
        if ($site['method'] == 'weblogUpdates.ping') {
            $result = PNB_sendPing ($site['ping_url'], $_CONF['site_name'],
                                    $_CONF['site_url'], $itemurl);
        } else if ($site['method'] == 'weblogUpdates.extendedPing') {
            $result = PNB_sendExtendedPing ($site['ping_url'],
                $_CONF['site_name'], $_CONF['site_url'], $itemurl, $feedurl);
        } else {
            $result = $LANG_TRB['unknown_method'] . ': ' . $site['method'];
        }
        if (empty ($result)) {
            $result = '<b>' . $LANG_TRB['ping_success'] . '</b>';
        } else {
            $result = '<span class="warningsmall">' . $result . '</span>';
        }

        $template->set_var ('service_name', $site['name']);
        $template->set_var ('service_url', $site['site_url']);
        $template->set_var ('service_ping_url', $site['ping_url']);
        $template->set_var ('ping_result', $result);
        $template->set_var ('resend', $resend);
        $template->set_var ('alternate_row',
                ($counter % 2) == 0 ? 'row-even' : 'row-odd');
        $template->parse ('ping_results', 'item', true);
        $counter++;
    }
    $template->parse ('output', 'list');
    $retval .= $template->finish ($template->get_var ('output'));

    return $retval;
}

/**
* Prepare a list of all links in a story/item so that we can ask the user
* which one to send the trackback to.
*
* @param    string  $type   type of entry ('article' = story, etc.)
* @param    string  $id     ID of that entry
* @param    string  $text   text of that entry, to get the links from
* @return   string          formatted list of links
*
*/
function prepareAutodetect ($type, $id, $text)
{
    global $_CONF, $LANG_TRB;

    $retval = '';

    $baseurl = $_CONF['site_admin_url']
             . '/trackback.php?mode=autodetect&id=' . $id;
    if ($type != 'article') {
        $baseurl .= '&type' . $type;
    }

    // extract all links from the text
    preg_match_all ("/<a[^>]*href=[\"']([^\"']*)[\"'][^>]*>(.*?)<\/a>/i", $text,
                    $matches);
    $numlinks = count ($matches[0]);
    if ($numlinks > 0) {
        $template = new Template ($_CONF['path_layout'] . 'admin/trackback');
        $template->set_file (array ('list' => 'autodetectlist.thtml',
                                    'item' => 'autodetectitem.thtml'));
        $template->set_var ('site_url', $_CONF['site_url']);
        $template->set_var ('site_admin_url', $_CONF['site_admin_url']);
        $template->set_var ('layout_url', $_CONF['layout_url']);

        $url = $_CONF['site_admin_url'] . '/trackback.php?mode=new&id=' . $id;
        if ($type != 'article') {
            $url .= '&type=' . $type;
        }
        $template->set_var ('lang_trackback_explain',
                            sprintf ($LANG_TRB['trackback_explain'], $url));

        for ($i = 0; $i < $numlinks; $i++) {
            $url = urlencode ($matches[1][$i]);
            $link = $baseurl .= '&url=' . $url;

            $template->set_var ('autodetect_link', $link);
            $template->set_var ('link_text', $matches[2][$i]);
            $template->set_var ('link_url', $matches[1][$i]);
            $template->set_var ('alternate_row',
                    (($i + 1) % 2) == 0 ? 'row-even' : 'row-odd');
            $template->parse ('autodetect_items', 'item', true);
        }
        $template->parse ('output', 'list');
        $retval .= $template->finish ($template->get_var ('output'));
    } else {
        $retval .= $LANG_TRB['no_links_trackback'];
    }

    return $retval;
}

// MAIN
$display = '';

if (isset ($_POST['mode']) && is_array ($_POST['mode'])) {
    $mode = $_POST['mode'];
    if (isset ($mode[0])) {
        $mode = 'send';
    } else if (isset ($mode[1])) {
        $mode = 'preview';
    } else {
        $mode = '';
    }
} else {
    $mode = COM_applyFilter ($_REQUEST['mode']);
}

if ($mode == 'delete') {
    $cid = COM_applyFilter ($_REQUEST['cid'], true);
    if ($cid > 0) {
        $display = deleteTrackbackComment ($cid);
    } else {
        $display = COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    }
} else if ($mode == 'send') {
    $target = COM_applyFilter ($_POST['target']);
    $url = COM_applyFilter ($_POST['url']);
    $title = COM_stripslashes ($_POST['title']);
    $excerpt = COM_stripslashes ($_POST['excerpt']);
    $blog = COM_stripslashes ($_POST['blog_name']);

    if (empty ($target)) {
        $display .= COM_siteHeader ('menu');
        $display .= showTrackbackMessage ($LANG_TRB['target_missing'],
                                          $LANG_TRB['target_required']);
        $display .= trackback_editor ($target, $url, $title, $excerpt, $blog);
    } else if (empty ($url)) {
        $display .= COM_siteHeader ('menu');
        $display .= showTrackbackMessage ($LANG_TRB['url_missing'],
                                          $LANG_TRB['url_required']);
        $display .= trackback_editor ($target, $url, $title, $excerpt, $blog);
    } else {
        // prepare for send
        $send_title = TRB_filterTitle ($title);
        $send_excerpt = TRB_filterExcerpt ($excerpt);
        $send_blog = TRB_filterBlogname ($blog);

        $result = TRB_sendTrackbackPing ($target, $url, $send_title,
                                         $send_excerpt, $send_blog);

        $display .= COM_siteHeader ('menu');
        if ($result === true) {
            $display .= COM_showMessage (64);
            $display .= trackback_editor ();
        } else {
            $message = '<p>' . $LANG_TRB['send_error_details'] . '<br>'
                     . '<span class="warningsmall">'
                     . htmlspecialchars ($result) . '</span></p>';
            $display .= showTrackbackMessage ($LANG_TRB['send_error'], $message);

            // display editor with the same contents again
            $display .= trackback_editor ($target, $url, $title, $excerpt, $blog);
        }
    }
    $display .= COM_siteFooter ();
} else if ($mode == 'new') {
    $type = COM_applyFilter ($_REQUEST['type']);
    if (empty ($type)) {
        $type = 'article';
    }
    $id = COM_applyFilter ($_REQUEST['id']);
    if (!empty ($id)) {
        if ($type == 'article') {
            list ($url, $title, $excerpt) = STORY_getItemInfo ($id,
                                                'url,title,excerpt');
        } else {
            list ($url, $title, $excerpt) = PLG_getItemInfo ($type, $id,
                                                'url,title,excerpt');
        }
        $excerpt = trim (strip_tags ($excerpt));
        $blog = TRB_filterBlogname ($_CONF['site_name']);

        $display .= COM_siteHeader ('menu')
                 . trackback_editor ($target, $url, $title, $excerpt, $blog)
                 . COM_siteFooter ();
    } else {
        $display = COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    }
} else if ($mode == 'pingback') {
    $type = COM_applyFilter ($_REQUEST['type']);
    if (empty ($type)) {
        $type = 'article';
    }
    $id = COM_applyFilter ($_REQUEST['id']);
    if (!empty ($id)) {
        $display .= COM_siteHeader ('menu', $LANG_TRB['pingback'])
                  . COM_startBlock ($LANG_TRB['pingback_results'])
                  . sendPingbacks ($type, $id)
                  . COM_endBlock ()
                  . COM_siteFooter ();
    } else {
        $display = COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    }
} else if ($mode == 'sendall') {
    $id = COM_applyFilter ($_REQUEST['id']);
    if (empty ($id)) {
        echo COM_refresh ($_CONF['site_admin_url'] . '/index.php');
        exit;
    }
    $type = COM_applyFilter ($_REQUEST['type']);
    if (empty ($type)) {
        $type = 'article';
    }

    $pingback_sent  = isset ($_REQUEST['pingback_sent']);
    $ping_sent      = isset ($_REQUEST['ping_sent']);
    $trackback_sent = isset ($_REQUEST['trackback_sent']);

    $pingresult = '';
    if (isset ($_POST['what']) && is_array ($_POST['what'])) {
        $what = $_POST['what'];
        if (isset ($what[0])) {         // Pingback
            $pingresult = sendPingbacks ($type, $id);
            $pingback_sent = true;
        } else if (isset ($what[1])) {  // Ping
            $pingresult = sendPings ($type, $id);
            $ping_sent = true;
        } else if (isset ($what[2])) {  // Trackback
            $url = $_CONF['site_admin_url'] . '/trackback?mode=pretrackback&id='
                 . $id;
            if ($type != 'article') {
                $url .= '&type=' . $type;
            }
            echo COM_refresh ($url);
            exit;
        }
    }

    if ($type == 'article') {
        $title = STORY_getItemInfo ($id, 'title');
    } else {
        $title = PLG_getItemInfo ($type, $id, 'title');
    }

    $display .= COM_siteHeader ('menu', $LANG_TRB['send_pings']);
    $display .= COM_startBlock (sprintf ($LANG_TRB['send_pings_for'], $title));

    $template = new Template ($_CONF['path_layout'] . 'admin/trackback');
    $template->set_file (array ('form' => 'pingform.thtml'));
    $template->set_var ('site_url', $_CONF['site_url']);
    $template->set_var ('site_admin_url', $_CONF['site_admin_url']);
    $template->set_var ('layout_url', $_CONF['layout_url']);
    $template->set_var ('php_self', $_CONF['site_admin_url']
                                    . '/trackback.php');
    $template->set_var ('lang_may_take_a_while', $LANG_TRB['may_take_a_while']);
    $template->set_var ('lang_ping_explain', $LANG_TRB['ping_all_explain']);

    $template->set_var ('ping_results', $pingresult);

    if ($_CONF['pingback_enabled']) {
        if (!$pingback_sent) {
            $template->set_var ('lang_pingback_button',
                                $LANG_TRB['pingback_button']);
            $template->set_var ('lang_pingback_short',
                                $LANG_TRB['pingback_short']);
            $button = '<input type="submit" name="what[0]" value="'
                    . $LANG_TRB['pingback_button'] . '">';
            $template->set_var ('pingback_button', $button);
        }
    } else {
        $template->set_var ('pingback_button', $LANG_TRB['pingback_disabled']);
    }
    if ($_CONF['ping_enabled']) {
        if (!$ping_sent) {
            $template->set_var ('lang_ping_button', $LANG_TRB['ping_button']);
            $template->set_var ('lang_ping_short', $LANG_TRB['ping_short']);
            $button = '<input type="submit" name="what[1]" value="'
                    . $LANG_TRB['ping_button'] . '">';
            $template->set_var ('ping_button', $button);
        }
    } else {
        $template->set_var ('ping_button', $LANG_TRB['ping_disabled']);
    }
    if ($_CONF['trackback_enabled']) {
        if (!$trackback_sent) {
            $template->set_var ('lang_trackback_button',
                                $LANG_TRB['trackback_button']);
            $template->set_var ('lang_trackback_short',
                                $LANG_TRB['trackback_short']);
            $button = '<input type="submit" name="what[2]" value="'
                    . $LANG_TRB['trackback_button'] . '">';
            $template->set_var ('trackback_button', $button);
        }
    } else {
        $template->set_var ('trackback_button', $LANG_TRB['trackback_disabled']);
    }

    $hidden = '';
    if ($pingback_sent) {
        $hidden .= '<input type="hidden" name="pingback_sent" value="1">';
    }
    if ($ping_sent) {
        $hidden .= '<input type="hidden" name="ping_sent" value="1">';
    }
    if ($trackback_sent) {
        $hidden .= '<input type="hidden" name="trackback_sent" value="1">';
    }
    $hidden .= '<input type="hidden" name="id" value="' . $id . '">';
    $hidden .= '<input type="hidden" name="type" value="' . $type . '">';
    $hidden .= '<input type="hidden" name="mode" value="sendall">';
    $template->set_var ('hidden_input_fields', $hidden);

    $template->parse ('output', 'form');
    $display .= $template->finish ($template->get_var ('output'));

    $display .= COM_endBlock ();
    $display .= COM_siteFooter ();
} else if ($mode == 'pretrackback') {
    $id = COM_applyFilter ($_REQUEST['id']);
    if (empty ($id)) {
        echo COM_refresh ($_CONF['site_admin_url'] . '/index.php');
        exit;
    }
    $type = COM_applyFilter ($_REQUEST['type']);
    if (empty ($type)) {
        $type = 'article';
    }

    if ($type == 'article') {
        $fulltext = STORY_getItemInfo ($id, 'description');
    } else {
        $fulltext = PLG_getItemInfo ($type, $id, 'description');
    }

    $display .= COM_siteHeader ('menu', $LANG_TRB['trackback'])
              . COM_startBlock ($LANG_TRB['select_url'])
              . prepareAutodetect ($type, $id, $fulltext)
              . COM_endBlock ()
              . COM_siteFooter ();
} else if ($mode == 'autodetect') {
    $id = COM_applyFilter ($_REQUEST['id']);
    $url = $_REQUEST['url'];
    if (empty ($id) || empty ($url)) {
        echo COM_refresh ($_CONF['site_admin_url'] . '/index.php');
        exit;
    }
    $type = COM_applyFilter ($_REQUEST['type']);
    if (empty ($type)) {
        $type = 'article';
    }

    $trackbackUrl = TRB_detectTrackbackUrl ($url);

    if ($type == 'article') {
        list ($url, $title, $excerpt) = STORY_getItemInfo ($id,
                                                           'url,title,excerpt');
    } else {
        list ($url, $title, $excerpt) = PLG_getItemInfo ($type, $id,
                                                         'url,title,excerpt');
    }
    $excerpt = trim (strip_tags ($excerpt));
    $blog = TRB_filterBlogname ($_CONF['site_name']);

    $display .= COM_siteHeader ('menu', $LANG_TRB['trackback']);
    if ($trackbackUrl === false) {
        $display .= showTrackbackMessage ($LANG_TRB['not_found'],
                                          $LANG_TRB['autodetect_failed']);
    }
    $display .= trackback_editor ($trackbackUrl, $url, $title, $excerpt, $blog)
             . COM_siteFooter ();
} else {
    $display .= COM_siteHeader ('menu');

    if (isset ($_REQUEST['msg'])) {
        $msg = COM_applyFilter ($_REQUEST['msg'], true);
        if ($msg > 0) {
            $display .= COM_showMessage ($msg);
        }
    }

    $target = COM_applyFilter ($_REQUEST['target']);
    $url = COM_applyFilter ($_REQUEST['url']);
    $title = COM_stripslashes ($_REQUEST['title']);
    $excerpt = COM_stripslashes ($_REQUEST['excerpt']);
    $blog = COM_stripslashes ($_REQUEST['blog_name']);

    if (isset ($_REQUEST['id']) && isset ($_REQUEST['type'])) {
        $id = COM_applyFilter ($_REQUEST['id']);
        $type = COM_applyFilter ($_REQUEST['type']);
        if (!empty ($id) && !empty ($type)) {
            if ($type == 'article') {
                list ($newurl, $newtitle, $newexcerpt) =
                        STORY_getItemInfo ($id, 'url,title,excerpt');
            } else {
                list ($newurl, $newtitle, $newexcerpt) =
                        PLG_getItemInfo ($type, $id, 'url,title,excerpt');
            }
            $newexcerpt = trim (strip_tags ($newexcerpt));

            if (empty ($url) && !empty ($newurl)) {
                $url = $newurl;
            }
            if (empty ($title) && !empty ($newtitle)) {
                $title = $newtitle;
            }
            if (empty ($newexcerpt) && !empty ($newexcerpt)) {
                $excerpt = $newexcerpt;
            }

            if (empty ($blog)) {
                $blog = TRB_filterBlogname ($_CONF['site_name']);
            }
        }
    }

    if (($mode == 'preview') && empty ($url)) {
        $display .= showTrackbackMessage ($LANG_TRB['url_missing'],
                                          $LANG_TRB['url_required']);
    }

    $display .= trackback_editor ($target, $url, $title, $excerpt, $blog);

    $display .= COM_siteFooter ();
}

echo $display;

?>
