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
// $Id: trackback.php,v 1.3 2005/01/29 09:02:11 dhaun Exp $

require_once ('../lib-common.php');

/**
* Security check to ensure user even belongs on this page
*/
require_once ('auth.inc.php');

if (!$_CONF['trackback_enabled']) {
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
* Get information for an entry
*
* Retrieves the information (URL, title, excerpt) for an entry, so that we
* can populate the input fields in the trackback comment editor.
*
* @param    string  $sid    ID of the entry
* @param    string  $type   type of the entry ('article' = story)
* @retrun   array           array (URL, title, excerpt)
*
*/
function getinfo ($sid, $type = 'article')
{
    global $_CONF, $_TABLES;

    if ($type == 'article') {
        $story = addslashes ($sid);
        $result = DB_query ("SELECT title, introtext FROM {$_TABLES['stories']} WHERE (sid = '$story') AND (draft_flag = 0) AND (date <= NOW())" . COM_getPermSql ('AND') . COM_getTopicSql ('AND'));
        list ($title, $excerpt) = DB_fetchArray ($result);

        if (!empty ($title) && !empty ($excerpt)) {
            $url = COM_buildUrl ($_CONF['site_url'] . '/article.php?story='
                                 . $sid);
            return array ($url,
                          stripslashes ($title),
                          TRB_filterExcerpt ($excerpt));
        }
    } else {
        return PLG_handleTrackbackComment ($type, $sid, 'info');
    }

    return array ('', '', '');
}

/**
* Deletes a trackback comment. Checks if the current user has proper
* permissions first.
*
* @param    int     $id     ID of the trackback comment to delete
* @return   bool            true = success, false = failure
*
*/
function deleteTrackbackComment ($id)
{
    global $_TABLES;

    $deleted = false;

    $cid = addslashes ($id);
    $result = DB_query ("SELECT sid,type FROM {$_TABLES['trackback']} WHERE cid = '$cid'");
    list ($sid, $type) = DB_fetchArray ($result);

    if (TRB_allowDelete ($sid, $type)) {
        TRB_deleteTrackbackComment ($id);
        $deleted = true;
    }

    return $deleted;
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
        if (deleteTrackbackComment ($cid)) {
            $display = COM_refresh ($_CONF['site_admin_url']
                                    . '/trackback.php?msg=62');
        } else {
            $display = COM_refresh ($_CONF['site_admin_url']
                                    . '/trackback.php?msg=63');
        }
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
        list ($url, $title, $excerpt) = getinfo ($id, $type);
        $blog = TRB_filterBlogname ($_CONF['site_name']);

        $display .= COM_siteHeader ('menu')
                 . trackback_editor ($target, $url, $title, $excerpt, $blog)
                 . COM_siteFooter ();
    } else {
        $display = COM_refresh ($_CONF['site_admin_url'] . '/index.php');
    }
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
            list ($newurl, $newtitle, $newexcerpt) = getinfo ($id, $type);

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
