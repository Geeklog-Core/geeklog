<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// |                                                                           |
// | LDAP configuration file.                                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008 by the following authors:                              |
// |                                                                           |
// | Authors: Jessica Blank     - jessica.blank AT mtvnmix DOT com             |
// |                              under contract to MTV Networks               |
// |          Evan Rappaport    - evan.rappaport AT mtvi DOT com               |
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
// $Id: config.php,v 1.1 2008/05/01 19:27:48 dhaun Exp $

global $_LDAP_CONF;

$_LDAP_CONF['version']            = '1.0.0'; // Module Version


// LDAP Settings

// Basic LDAP variables
$_LDAP_CONF['user_ou'] = "People";
$_LDAP_CONF['group_ou'] = "Group";
$_LDAP_CONF['branch'] = "dc=mydc,dc=com";
$_LDAP_CONF['user_branch'] = "ou={$_LDAP_CONF['user_ou']}," . $_LDAP_CONF['branch'];
$_LDAP_CONF['user_attributes'] = array("uid","cn","ou","objectClass","shadowLastChange","loginShell","uidnumber","gidNumber","homeDirectory","gecos","userPassword","givenName","sn","mail");

// LDAP server configuration
$_LDAP_CONF['servers'][0]['bind_dn'] = "cn=mycn,ou=LDAPusers,dc=mydc,dc=com";
$_LDAP_CONF['servers'][0]['password'] = "mypassword";
$_LDAP_CONF['servers'][0]['host'] = "localhost";

// (put additional servers here; example given below)
// $_LDAP_CONF['servers'][1]['bind_dn'] = 'cn=foo,ou=people,dc=corp,dc=com';
// $_LDAP_CONF['servers'][1]['password'] = 'joshua';
// $_LDAP_CONF['servers'][1]['host'] = 'ldap.example.com';

// LDAP server selection

/**
 * If you wanted to set up some complex logic to determine which
 * LDAP server is in use, this is where it would go.
 * We have provided the basic infrastructure for multiple LDAP servers;
 * the rest is left as an exercise for the user.
 */
$_LDAP_CONF['server_num'] = 0;


// Default user settings
$_LDAP_CONF['user_defaults']['ou'] = $_LDAP_CONF['user_ou'];
$_LDAP_CONF['user_defaults']['objectClass'] = array("account","posixAccount","top","shadowAccount","person","organizationalPerson","inetOrgPerson");
$_LDAP_CONF['user_defaults']['shadowLastChange'] = "0";
$_LDAP_CONF['user_defaults']['loginShell'] = "/etc/ftponly";

?>
