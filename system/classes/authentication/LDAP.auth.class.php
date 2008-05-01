<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | LDAP.auth.class.php                                                       |
// |                                                                           |
// | Geeklog Distributed Authentication Module.                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008 by the following authors:                              |
// |                                                                           |
// | Authors: Jessica Blank   - jessica.blank AT mtvnmix DOT com               |
// |                            under contract to MTV Networks                 |
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
// $Id: LDAP.auth.class.php,v 1.1 2008/05/01 19:27:48 dhaun Exp $

/**
 * LDAP Remote Authentication class
 *
 * Be sure to edit system/classes/authentication/ldap/config.php first!
 *
 */

class LDAP
{
    function ascii2hex($ascii)
    {
        /* Adapted from function courtesy kuukelekuu at gmail dot com,
         * from http://www.thescripts.com/forum/thread519762.html
         */
        $hex = '';

        for ($i = 0; $i < strlen($ascii); $i++) {
            $byte = strtolower(dechex(ord($ascii{$i})));
            $byte = str_repeat('0', 2 - strlen($byte)) . $byte;
            $hex .= $byte;
        }

        return $hex;
    }

    function authenticate($username, $password)
    {
        global $_CONF;

        require_once $_CONF['path']
                     . 'system/classes/authentication/ldap/config.php';

        $link_identifier = ldap_connect($_LDAP_CONF['servers'][$_LDAP_CONF['server_num']]['host']);

        if ($link_identifier === false) {
            COM_errorLog("Can't connect to LDAP server "
                . $_LDAP_CONF['servers'][$_LDAP_CONF['server_num']]['host']);
            return false;
        } else {
            ldap_set_option($link_identifier, LDAP_OPT_PROTOCOL_VERSION, 3);

            $connected = @ldap_bind($link_identifier,
                $_LDAP_CONF['servers'][$_LDAP_CONF['server_num']]['bind_dn'],
                $_LDAP_CONF['servers'][$_LDAP_CONF['server_num']]['password']);
            if (!$connected) {
                COM_errorLog("Can't bind to LDAP directory: "
                             . ldap_error($link_identifier));
                return false;
            }
        }

        $filter = "uid=$username";
        $search_result = ldap_search($link_identifier, $_LDAP_CONF['branch'],
                                     $filter);
        $A = ldap_get_entries($link_identifier, $search_result);
        if ($A['count'] < 1) {
            return false; // The username was not found in the LDAP database.
        } else {
            /* By default, we assume passwords are crypted with traditional
             * DES crypt().
             */
            $crypt_method = 'des';
            $correct_cyphertext = $A[0]['userpassword'][0];

            if (preg_match("/^\{(crypt|des)\}(.*)$/i", $correct_cyphertext,
                    $tmpmatches)) {
                /* Yes, I know, we're being redundant -- in the interest of
                 * being verbose. This is just in case we ever change the
                 * defaults.
                 */
                $crypt_method = 'des';
                $correct_cyphertext = $tmpmatches[2];
            } else {
                if (preg_match("/^\{md5\}(.*)$/i", $correct_cyphertext,
                        $tmpmatches)) {
                    $crypt_method = 'md5'; // MD5 hash, no salt.
                    $correct_cyphertext = $tmpmatches[1];
                } else {
                    if (preg_match("/^{SMD5}(.*)$/i", $correct_cyphertext,
                            $tmpmatches)) {
                        $crypt_method = 'smd5'; // MD5 hash, with salt.
                        $orig_cyphertext = $tmpmatches[1];
                        $salted_hash = base64_decode($orig_cyphertext);
                        $salt = substr($salted_hash,16);
                        $without_salt = explode($salt, $salted_hash);
                        $correct_cyphertext = $this->ascii2hex($without_salt[0]);
                    } else { // assume no encryption
                        $crypt_method = '';
                        $correct_cyphertext = $password;
                    }
                }
            }

            switch ($crypt_method) {
            case 'md5':
                if (preg_match("/^\$/", $correct_cyphertext)) {
                    // passwd/style-shadow MD5, starting with '$'
	                $password_cyphertext = crypt($password);
                } else {
                    // hexadecimal MD5
	                $password_cyphertext = md5($password);
                }
                break;

            case 'smd5';
                // $salt was set above.
                $password_cyphertext = md5($password . $salt);
                break;

            case 'crypt':
            case 'des':
                $password_cyphertext = crypt($password,
                                             substr($correct_cyphertext, 0, 2));
                break;

            default: // no encryption at all!
                 $password_cyphertext = $password;
                 break;
            }

            if ($password_cyphertext == $correct_cyphertext) {
                // Set some variables pulled from the LDAP server...
                $this->fullname = $A[0]['cn'][0];
                $this->email    = $A[0]['mail'][0];

                return true; // Password given was CORRECT!
            } else {
                return false; // Password given was NOT correct.
            }
        }
    }
}

?>
