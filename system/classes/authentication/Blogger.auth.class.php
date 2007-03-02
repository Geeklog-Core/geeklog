<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | Blogger.auth.class.php                                                    |
// |                                                                           |
// | Geeklog Distributed Authentication Module.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2004 by the following authors:                         |
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
// $Id: Blogger.auth.class.php,v 1.6 2007/03/02 08:02:34 mjervis Exp $

// PEAR class to handle XML-RPC
require_once ('XML/RPC.php');

class Blogger
{
    var $email;
    var $fullname;
    var $homepage;

    function authenticate($username, $password)
    {
        $email = '';
        $message = new XML_RPC_Message('blogger.getUserInfo',
                                array(
                                    new XML_RPC_Value('XXXXXXXXXXXX', 'string'),
                                    new XML_RPC_Value($username, 'string'),
                                    new XML_RPC_Value($password, 'string')
                                )
                                                );
        $client = new XML_RPC_Client('/api/', 'www.blogger.com', 80);
        $result = $client->send($message, 5, 'http');
        if ($result && ($result->faultString() == '')) {
            // Get the email address:
            $value = $result->value();
            // Blogger return faultcode = 0 for a login fail.
            // which the lib doesn't handle. Hence horrible stuff.
            $f = $value->structmem('faultString');
            if ($f)
            {
                return false;
            } else {
                $value = $value->structmem('email');
                $this->email = $value->scalarVal();
                return true;
            }
        }
        else {
            return false;
        }
    }
}
