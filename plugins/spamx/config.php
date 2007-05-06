<?php

/**
 * File: config.php
 * This is the config file for the Geeklog Spam-X plugin
 * 
 * Copyright (C) 2004-2006 by the following authors:
 * Author		Tom Willett		tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 * $Id: config.php,v 1.20 2007/05/06 08:09:16 mjervis Exp $
 */

$_SPX_CONF['version'] = '1.1.1';

// Default Spam-X Action
$_SPX_CONF['action'] = 128; // Default is to ignore (delete) the post

// address which mail admin module will use
$_SPX_CONF['notification_email'] = $_CONF['site_mail'];

// if set to = true, skip spam check for members of the "spamx Admin" group
$_SPX_CONF['admin_override'] = false;

// enable / disable logging to spamx.log
$_SPX_CONF['logging'] = true;

// timeout for contacting external services, e.g. SLV
$_SPX_CONF['timeout'] = 5; // in seconds

/*
 * The following settings all relate to the ProjectHoneyPot.org http:BL
 * examine module. In order to use this, you *MUST* register with
 * ProjectHoneyPot. You *MUST* install a Honey Pot. You *MUST* accept the
 * terms of use of the http:BL and acquire your own http:BL access key.
 */
$_SPX_CONF['http_bl_enable'] = true; // Whether or not to use the http:BL, true or false.
// You can get your access key from: http://www.projecthoneypot.org/httpbl_configure.php
// regardless of http_bl_enable, if you don't have a key, this won't work.
$_SPX_CONF['http_bl_access_key'] = 'NOT.CONFIGURED.RIGHT';
// Whether or not to use TCP (Virtual Circuits) instead of UDP. If set to false,
// UDP will be used unless TCP is required. TCP is required for questions or
// responses greater than 512 bytes.
$_SPX_CONF['http_bl_use_tcp'] = true; 
// DNS Servers to use, in my development environment, I found that the examine
// failed without configuring this. Must be an array of IP addresses, or false:
$_SPX_CONF['http_bl_dns_servers'] = false;
// example of array with dummy values: $_SPX_CONF['http_bl_dns_servers'] = array('ip1','ip2');


// DO NOT CHANGE THE STUFF BELOW UNLESS YOU KNOW WHAT YOU ARE DOING

// This sets Spam-X Plugin Table Prefix the same as Geeklog
$_SPX_table_prefix = $_DB_table_prefix;

// Add Spam-X Plugin table to $_TABLES array
$_TABLES['spamx'] = $_SPX_table_prefix . 'spamx';

?>
