<?php

/**
 * File: config.php
 * This is the config file for the Geeklog Spam-X Plug-in!
 * 
 * Copyright (C) 2004-2005 by the following authors:
 * Author		Tom Willett		tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 * $Id: config.php,v 1.9 2005/08/21 18:56:45 dhaun Exp $
 */

$_SPX_CONF['version'] = '1.0.3';

// Default Spam-X Action
$_SPX_CONF['action'] = 128; // Default is ignore comment

// URL blacklist changes RSS feed (currently only RSS v1.0 is supported)
$_SPX_CONF['rss_url'] = 'http://www.jayallen.org/comment_spam/feeds/blacklist-changes.rdf';

// Entire MT-Blacklist (for inital import)
$_SPX_CONF['mtblacklist_url'] = 'http://www.jayallen.org/comment_spam/blacklist.txt';

// Spam-X URLs
$_SPX_CONF['spamx_rss_url'] = 'http://www.pigstye.net/backend/spamx_users.rdf';
$_SPX_CONF['spamx_submit_url'] = 'http://www.pigstye.net/gplugs/spamx/submit.php';

// address which mail admin module will use
$_SPX_CONF['notification_email'] = $_CONF['site_mail'];

// This sets Spam-X Plugin Table Prefix the same as Geeklog
$_SPX_table_prefix = $_DB_table_prefix;

// DO NOT CHANGE THE STUFF BELOW UNLESS YOU KNOW WHAT YOU ARE DOING
// Add Spam-X Plugin table to $_TABLES array
$_TABLES['spamx'] = $_SPX_table_prefix . 'spamx';

?>
