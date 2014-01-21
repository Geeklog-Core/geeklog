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
        $this->titleText  = $LANG_SX00['ipblack'];
        $this->linkText   = $LANG_SX00['edit_personal_blacklist'];
    }

    public function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $action = $this->getAction();
        $entry  = $this->getEntry();

        if (($action === 'delete') && SEC_checkToken()) {
            $this->deleteEntry($entry);
        } elseif (($action === $LANG_SX00['addentry']) && SEC_checkToken()) {
            $this->addEntry($entry);
        } elseif (($action === $LANG_SX00['addcen']) && SEC_checkToken()) {
            foreach ($_CONF['censorlist'] as $entry) {
                $entry  = DB_escapeString($entry);
                $result = DB_query("INSERT INTO {$_TABLES['spamx']} VALUES ('{$this->modulename}', '{$entry}', 0)");
            }
        }

        return $this->getWidget();
    }
}

?>
