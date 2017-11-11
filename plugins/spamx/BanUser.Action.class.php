<?php

/**
 * File: BanUser.Action.class.php
 * This is the Ban User Action for the Geeklog Spam-X plugin
 * Copyright (C) 2012-2017 by the following authors:
 * Author   Dirk Haun       dirk AT haun-online DOT net
 * based on earlier works by Tom Willett
 * Licensed under GNU General Public License
 *
 * @package    Spam-X
 * @subpackage Modules
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// Include Abstract Action Class
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Action Class which bans the user if the spam was detected on usersettings.php
 *
 * @package Spam-X
 */
class BanUser extends BaseCommand
{
    /**
     * BanUser constructor
     * Numbers are always binary digits and added together to make call
     */
    public function __construct()
    {
        $this->actionCode = PLG_SPAM_ACTION_DELETE;
    }

    /**
     * Execute
     *
     * @param  string $comment
     * @return int
     */
    public function execute($comment)
    {
        global $result, $_CONF, $_TABLES, $LANG_SX00, $_USER;

        $url = COM_getCurrentURL();

        if (strpos($url, 'usersettings.php') !== false) {
            $this->result = PLG_SPAM_ACTION_DELETE;
            DB_change($_TABLES['users'], 'status', USER_ACCOUNT_DISABLED, 'uid', $_USER['uid']);
            SPAMX_log("User {$_USER['username']} banned for profile spam.");
        }

        return 1;
    }
} 
