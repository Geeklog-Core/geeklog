<?php

/**
* File: SLVwhitelist.Admin.class.php
* This is the SLV Whitelist Module for the Geeklog Spam-X plugin
*
* Copyright (C) 2004-2010 by the following authors:
* Author   Tom Willett     tomw AT pigstye DOT net
*          Dirk Haun       dirk AT haun-online DOT de
*
* Licensed under GNU General Public License
*
* @package Spam-X
* @subpackage Modules
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'slvwhitelist.admin.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Base Class
*/
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';

/**
* SLV Whitelist Editor
*
* @package Spam-X
*
*/
class SLVwhitelist extends BaseAdmin
{
    public function __construct()
    {
        global $LANG_SX00;

        $this->moduleName = 'SLVwhitelist';
        $this->command    = 'SLVwhitelist';
        $this->titleText  = $LANG_SX00['slvwhitelist'];
        $this->linkText   = $LANG_SX00['edit_slv_whitelist'];
    }
}

?>
