<?php

/**
 * File: EditBlackList.Admin.class.php
 * This is the Edit Personal Blacklist Module for the Geeklog Spam-X plugin
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'editblacklist.admin.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Base Class
*/
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';

/**
 * Personal Black List Editor
 *
 * @package Spam-X
 *
 */
class EditBlackList extends BaseAdmin
{
    public function __construct()
    {
        global $LANG_SX00;

        $this->moduleName = 'Personal';
        $this->command    = 'EditBlackList';
        $this->titleText  = $LANG_SX00['pblack'];
        $this->linkText   = $LANG_SX00['edit_personal_blacklist'];
    }

    public function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $action = $this->getAction();
        $entry  = $this->getEntry();

        if (!empty($action) && SEC_checkToken()) {
            switch ($action) {
                case 'delete':
                    $this->deleteEntry($entry);
                    break;

                case $LANG_SX00['addentry']:
                    $this->addEntry($entry, true);
                    break;

                case $LANG_SX00['addcen']:
                    foreach ($_CONF['censorlist'] as $entry) {
                        $this->addEntry($entry, true);
                    }

                    break;

                case 'mass_delete':
                    if (isset($_POST['delitem'])) {
                        $this->deleteSelectedEntries($_POST['delitem']);
                    }

                    break;
            }
        }

        return $this->getWidget();
    }
}

?>
