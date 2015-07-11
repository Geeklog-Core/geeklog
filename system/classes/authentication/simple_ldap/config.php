<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | config.php                                                                |
// |                                                                           |
// | LDAP configuration file.                                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2015 by the following authors:                         |
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

global $_SIMPLE_LDAP_CONF;

// LDAP Settings
// this example uses localhost as LDAP server
// and hostname.homeunix.org possible DynDNS definition
$_SIMPLE_LDAP_CONF['ldap_host'] = 'localhost';
$_SIMPLE_LDAP_CONF['base_dn']   = 'dc=hostname,dc=homeunix,dc=org';
