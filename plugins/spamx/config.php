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

// URL blacklist changes RSS feed (currently only RSS v1.0 is supported)
$rss_url = 'http://www.jayallen.org/comment_spam/feeds/blacklist-changes.rdf';

// Spamx urls
$rss_spamx_url = 'http://www.pigstye.net/backend/spamx_users.rdf';
$spamx_submit_url = 'http://www.pigstye.net/gplugs/spamx/submit.php';

// address which mail admin module will use
$spamx_notification_email = $_CONF['site_mail'];

// This sets Ban Plugin Table Prefix the Same as Geeklog
$_BAN_table_prefix = $_DB_table_prefix;

// DO NOT CHANGE THE STUFF BELOW UNLESS YOU KNOW WHAT YOU ARE DOING
// Add Spamx Plugin table to $_TABLES array
$_TABLES['spamx']      = $_BAN_table_prefix . 'spamx';
?>