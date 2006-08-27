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
 * $Id: config.php,v 1.17 2006/08/27 09:30:19 dhaun Exp $
 */

$_SPX_CONF['version'] = '1.1.0';

// Default Spam-X Action
$_SPX_CONF['action'] = 128; // Default is to ignore (delete) the post

// address which mail admin module will use
$_SPX_CONF['notification_email'] = $_CONF['site_mail'];

// if set to = true, skip spam check for members of the "spamx Admin" group
$_SPX_CONF['admin_override'] = false;

// enable / disable logging to spamx.log
$_SPX_CONF['logging'] = true;


// DO NOT CHANGE THE STUFF BELOW UNLESS YOU KNOW WHAT YOU ARE DOING

// This sets Spam-X Plugin Table Prefix the same as Geeklog
$_SPX_table_prefix = $_DB_table_prefix;

// Add Spam-X Plugin table to $_TABLES array
$_TABLES['spamx'] = $_SPX_table_prefix . 'spamx';

?>
