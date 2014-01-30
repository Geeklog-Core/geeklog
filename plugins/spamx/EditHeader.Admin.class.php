<?php

/**
* File: EditHeader.Admin.class.php
* This is the Edit HTTP Header Module for the Geeklog Spam-X plugin
*
* Copyright (C) 2005-2009 by the following authors:
* Author    Dirk Haun <dirk AT haun-online DOT de>
*
* based on the works of Tom Willett <tomw AT pigstye DOT net>
*
* Licensed under GNU General Public License
*
* @package Spam-X
* @subpackage Modules
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'editheader.admin.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Base Class
*/
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';

/**
* HTTP Header Editor
*
* @package Spam-X
*
*/
class EditHeader extends BaseAdmin
{
    public function __construct()
    {
        global $LANG_SX00;

        $this->moduleName = 'HTTPHeader';
        $this->command    = 'EditHeader';
        $this->titleText  = $LANG_SX00['headerblack'];
        $this->linkText   = $LANG_SX00['edit_http_header_blacklist'];
    }

    protected function getWidget()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $this->csrfToken = SEC_createToken();
        $display = '<hr' . XHTML . '>' . LB
                 . '<p>' . $LANG_SX00['e1'] . '</p>' . LB
                 . $this->getList()
                 . '<p>' . $LANG_SX00['e2'] . '</p>' . LB
                 .  '<form method="post" action="' . $_CONF['site_admin_url']
                 . '/plugins/spamx/index.php?command=EditHeader">' . LB
                 .  '<table border="0" width="100%">' . LB
                 .  '<tr><td align="right"><b>Header:</b></td>' . LB
                 .  '<td><input type="text" size="40" name="header-name"'
                 .  XHTML . '> e.g. <tt>User-Agent</tt></td></tr>' . LB
                 .  '<tr><td align="right"><b>Content:</b></td>' . LB
                 .  '<td><input type="text" size="40" name="header-value"'
                 .  XHTML . '> e.g. <tt>Mozilla</tt></td></tr>' . LB
                 .  '</table>' . LB
                 .  '<p><input type="submit" name="paction" value="'
                 .  $LANG_SX00['addentry'] . '"' . XHTML . '>'
                 .  '<input type="hidden" name="' . CSRF_TOKEN
                 .  '" value="' . $this->csrfToken . '"' . XHTML . '></p>' . LB
                 .  '</form>' . LB;

        return $display;
    }

    public function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $action = $this->getAction();
        $entry  = $this->getEntry();

        if (($action === 'delete') && SEC_checkToken()) {
            $this->deleteEntry($entry);
        } elseif (($action === $LANG_SX00['addentry']) && SEC_checkToken()) {
            $entry = '';
            $name  = COM_applyFilter($_REQUEST['header-name']);
            $n     = explode(':', $name);
            $name  = $n[0];
            $value = $_REQUEST['header-value'];

            if (!empty($name) && !empty($value)) {
                $entry = $name . ': ' . $value;
            }

            $this->addEntry($entry);
        }

        return $this->getWidget();
    }
}

?>
