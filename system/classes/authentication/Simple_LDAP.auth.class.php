<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | Simple_LDAP.auth.class.php                                                |
// | based on LDAP.auth.class.php by Jessica Blank                             |
// |                                 jessica.blank AT mtvnmix DOT com          |
// |                                                                           |
// | Geeklog Distributed Authentication Module.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Markus Guske  mg AT guske DOT de                                 |
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

require_once __DIR__ . '/RemoteAuthAbstract.class.php';

/**
 * Simple_LDAP Remote Authentication class
 * BE SURE TO EDIT system/classes/authentication/simple_ldap/config.php first!
 */
class Simple_LDAP extends RemoteAuthAbstract
{
    public function authenticate($username, $password)
    {
        global $_SIMPLE_LDAP_CONF;

        require_once __DIR__ . '/simple_ldap/config.php';

        if (!is_callable('ldap_connect')) {
            COM_errorLog('Simple_LDAP Error: LDAP extension is disabled');

            return false;
        }

        $ldap_connection = ldap_connect($_SIMPLE_LDAP_CONF['ldap_host']);

        if ($ldap_connection === false) {
            COM_errorLog("Simple_LDAP Error: Cannot connect to LDAP server " . $_SIMPLE_LDAP_CONF['ldap_host']);

            return false;
        }

        if (!ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3)) {
            COM_errorLog("Simple_LDAP Error: Cannot set LDAP protocol version to 3");

            return false;
        }

        $ldap_result = ldap_search($ldap_connection, $_SIMPLE_LDAP_CONF['base_dn'], "uid={$username}");

        if ($ldap_result === false) {
            COM_errorLog('Simple_LDAP Error: Search for user ' . $username . ' failed');

            return false;
        }

        $A = ldap_get_entries($ldap_connection, $ldap_result);

        if (($A === false) || ($A['count'] == 0)) {
            COM_errorLog('Simple_LDAP Error: User ' . $username . ' does not exist.');

            return false;
        }

        // Trying to bind against LDAP given username and password
        $ldap_found_user_dn = $A[0]['dn'];
        $ldap_bind = @ldap_bind($ldap_connection, $ldap_found_user_dn, $password);

        if ($ldap_bind === false) {
            COM_errorLog('Simple_LDAP Error: Cannot bind to LDAP directory: ' . ldap_error($ldap_connection));

            return false;
        }

        // Bind successful, get some more infos from LDAP
        $this->fullname = $A[0]['cn'][0];
        $this->email = $A[0]['mail'][0];
        $this->homepage = $A[0]['labeleduri'][0];

        if (ldap_unbind($ldap_connection)) {
            return true;
        } else {
            COM_errorLog('Simple_LDAP Error: Could not unbind from LDAP directory');

            return false;
        }
    }
}
