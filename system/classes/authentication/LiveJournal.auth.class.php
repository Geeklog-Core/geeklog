<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | LiveJournal.auth.class.php                                                |
// |                                                                           |
// | Geeklog Distributed Authentication Module.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
// |                                                                           |
// | Authors: Michael Jervis   - mike@fuckingbrit.com                          |
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
// $Id: LiveJournal.auth.class.php,v 1.4 2007/05/26 14:19:04 dhaun Exp $

// PEAR class to handle XML-RPC
require_once ('XML/RPC.php');

class LiveJournal
{
    var $email;
    var $fullname;
    var $homepage;
    
    function authenticate($username, $password)
    {
        /* check it's livejournal.com */
        $email = '';
        $struct = new XML_RPC_Value(
                array('username' => new XML_RPC_Value($username, 'string'),
                          'hpassword' => new XML_RPC_Value(md5($password), 'string')
                  ), 'struct'
                );

        $message = new XML_RPC_Message('LJ.XMLRPC.login');
        $message->addparam($struct);
        $client = new XML_RPC_Client('/interface/xmlrpc', 'www.livejournal.com', 80);
        $result = $client->send($message, 5);
        if ($result && !$result->faultCode()) {
            /* Carefuly noting that no LJ API returns the email address, */
            /* because they suck.                                        */
            return true;
        }
        else {
            return false;
        }
    }
}

?>
