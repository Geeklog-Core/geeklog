<?php

/**
 * File: EditSFS.Admin.class.php
 * This is the Edit Personal Blacklist Module for the glFusion Spam-X plugin
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'editsfs.admin.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Base Class
*/
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';

/**
 * Personal SFS (StopForumSPAM) List Editor
 *
 * @package Spam-X
 *
 */
class EditSFS extends BaseAdmin
{
    public function __construct()
    {
        global $LANG_SX00;

        $this->moduleName = 'email';
        $this->command    = 'EditSFS';
        $this->titleText  = $LANG_SX00['sfseblack'];
        $this->linkText   = $LANG_SX00['edit_sfs_blacklist'];
    }
}

?>
