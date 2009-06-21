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
// $Id: trackback.php,v 1.9 2005/12/17 16:34:28 dhaun Exp $

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

if (isset ($_SERVER['REQUEST_METHOD'])) {
    // Trackbacks are only allowed as POST requests
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header ('Allow: POST');
        COM_displayMessageAndAbort (75, '', 405, 'Method Not Allowed');
    }
}

COM_setArgNames (array ('id', 'type'));
$id = COM_applyFilter (COM_getArgument ('id'));
$type = COM_applyFilter (COM_getArgument ('type'));

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
    $result = DB_query("SELECT trackbackcode FROM {$_TABLES['stories']} WHERE (sid = '$sid') AND (date <= NOW()) AND (draft_flag = 0)" . COM_getPermSql ('AND') . COM_getTopicSql ('AND'));
    if (DB_numRows ($result) == 1) {
        $A = DB_fetchArray ($result);
        if ($A['trackbackcode'] == 0) {
            TRB_handleTrackbackPing ($id, $type);
        } else {
            TRB_sendTrackbackResponse (1, $TRB_ERROR['no_access']);
        }
    } else {
        TRB_sendTrackbackResponse (1, $TRB_ERROR['no_access']);
    }
} else if (PLG_handlePingComment ($type, $id, 'acceptByID') === true) {
    TRB_handleTrackbackPing ($id, $type);
} else {
    TRB_sendTrackbackResponse (1, $TRB_ERROR['no_access']);
}

// no output here

?>
