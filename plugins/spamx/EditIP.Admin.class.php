<?php

/**
* File: EditIP.Admin.class.php
* This is the Edit IPBlacklist Module for the Geeklog Spam-X plugin
*
* Copyright (C) 2004-2009 by the following authors:
* Author   Tom Willett     tomw AT pigstye DOT net
*          Dirk Haun       dirk AT haun-online DOT de
*
* Licensed under GNU General Public License
*
* @package Spam-X
* @subpackage Modules
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'editip.admin.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Base Class
*/
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';

/**
* IP Black List Editor
*
* @package Spam-X
*
*/
class EditIP extends BaseAdmin
{
    public function __construct()
    {
        global $LANG_SX00;

        $this->moduleName = 'IP';
        $this->command    = 'EditIP';
        $this->titleText  = $LANG_SX00['ipblack'];
        $this->linkText   = $LANG_SX00['edit_ip_blacklist'];
    }
}

?>
