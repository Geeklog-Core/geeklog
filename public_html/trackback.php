<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | trackback.php                                                             |
// |                                                                           |
// | Handle trackback pings for stories and plugins.                           |
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
// $Id: trackback.php,v 1.2 2005/01/18 13:15:52 dhaun Exp $

require_once ('lib-common.php');
require_once ($_CONF['path_system'] . 'lib-trackback.php');

// Note: Error messages are hard-coded in English since there is no way of
// knowing which language the sender of the trackback ping may prefer.
$TRB_ERROR = array (
    'not_enabled'       => 'Trackback not enabled.',
    'illegal_request'   => 'Illegal request.',
    'no_access'         => 'You do not have access to this entry.'
);

if (!$_CONF['trackback_enabled']) {
    TRB_sendTrackbackResponse (1, $TRB_ERROR['not_enabled']);
    exit;
}

/**
* Send a notification email when a new trackback comment has been posted
*
* FIXME: Currently always picks the latest comment for ($id, $type).
*        This may not always be the comment that was just posted ...
*
* @param    string  $id         ID of the entry the comment was posted to
* @param    string  $type       type of that entry ('article' = story, etc.)
* @return   void
*
*/
function sendNotification ($id, $type)
{
    global $_CONF, $_TABLES, $LANG03, $LANG08, $LANG09, $LANG29, $LANG_TRB;

    $trbtype = addslashes ($type);
    $result = DB_query ("SELECT title,excerpt,url,blog,ipaddress FROM {$_TABLES['trackback']} WHERE (type = '$trbtype') ORDER BY date DESC LIMIT 1");
    $A = DB_fetchArray ($result);

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
        list ($commenturl, $dummy1, $dummy2)
                = PLG_handleTrackbackComment ($type, $id, 'info');
    }

    $mailbody .= $LANG08[33] . ' <' . $commenturl . ">\n\n";

    $mailbody .= "\n------------------------------\n";
    $mailbody .= "\n$LANG08[34]\n";
    $mailbody .= "\n------------------------------\n";

    $mailsubject = $_CONF['site_name'] . ' ' . $LANG_TRB['trackback'];

    COM_mail ($_CONF['site_mail'], $mailsubject, $mailbody);
}

COM_setArgNames (array ('id', 'type'));
$id = COM_applyFilter (COM_getArgument ('id'));
$type = COM_applyFilter (COM_getArgument ('type'));

// Trackback pings using GET requests are deprecated but we still support them
if (empty ($id)) {
    $id = COM_applyFilter ($_REQUEST['id']);
    $type = COM_applyFilter ($_REQUEST['type']);
}

if (empty ($id)) {
    TRB_sendTrackbackResponse (1, $TRB_ERROR['illegal_request']);
    exit;
}

if (empty ($type)) {
    $type = 'article';
}

if ($type == 'article') {
    // check if they have access to this story
    $sid = addslashes ($id);
    $result = DB_query("SELECT COUNT(*) AS count FROM {$_TABLES['stories']} WHERE (sid = '$sid') AND (date <= NOW()) AND (draft_flag = 0)" . COM_getPermSql ('AND') . COM_getTopicSql ('AND'));
    $A = DB_fetchArray ($result);
    if ($A['count'] == 1) {
        if (TRB_handleTrackbackPing ($id, $type)) {
            if (isset ($_CONF['notification']) &&
                    in_array ('trackback', $_CONF['notification'])) {
                sendNotification ($id, $type);
            }
        }
        exit;
    } else {
        TRB_sendTrackbackResponse (1, $TRB_ERROR['no_access']);
        exit;
    }
} else if (PLG_acceptTrackbackPing ($type, $id) === true) {
    if (TRB_handleTrackbackPing ($id, $type)) {
        if (isset ($_CONF['notification']) &&
                in_array ('trackback', $_CONF['notification'])) {
            sendNotification ($id, $type);
        }
    }
    exit;
} else {
    TRB_sendTrackbackResponse (1, $TRB_ERROR['no_access']);
    exit;
}

?>
