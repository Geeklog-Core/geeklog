<?php

/**
* File: config.php
* This is the config file for the Geeklog SpamX Plug-in!
*
* Copyright (C) 2004 by the following authors:
*
* @ Author		Tom Willett		tomw@pigstye.net
*
* Licensed under GNU General Public License
*
*/

$_SPX_CONF['version'] = '1.0.1';

// URL blacklist changes RSS feed (currently only RSS v1.0 is supported)
$_SPX_CONF['rss_url'] = 'http://www.jayallen.org/comment_spam/feeds/blacklist-changes.rdf';

// Entire MT-Blacklist (for inital import)
$_SPX_CONF['mtblacklist_url'] = 'http://www.jayallen.org/comment_spam/blacklist.txt';

// SpamX urls
$_SPX_CONF['spamx_rss_url'] = 'http://www.pigstye.net/backend/spamx_users.rdf';
$_SPX_CONF['spamx_submit_url'] = 'http://www.pigstye.net/gplugs/spamx/submit.php';

// address which mail admin module will use
$_SPX_CONF['notification_email'] = $_CONF['site_mail'];

// This sets Ban Plugin Table Prefix the Same as Geeklog
$_SPX_table_prefix = $_DB_table_prefix;

// DO NOT CHANGE THE STUFF BELOW UNLESS YOU KNOW WHAT YOU ARE DOING
// Add SpamX Plugin table to $_TABLES array
$_TABLES['spamx']      = $_SPX_table_prefix . 'spamx';

?>
