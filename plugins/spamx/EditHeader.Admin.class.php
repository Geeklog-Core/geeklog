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
class EditHeader extends BaseAdmin {
    /**
     * Constructor
     */
    function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $action = '';
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } elseif (isset($_POST['paction'])) {
            $action = $_POST['paction'];
        }

        if (($action == 'delete') && SEC_checkToken()) {
            $entry = $_GET['entry'];
            if (!empty($entry)) {
                $dbentry = addslashes($entry);
                DB_delete($_TABLES['spamx'], array('name', 'value'),
                                             array('HTTPHeader', $dbentry));
            }
        } elseif (($action == $LANG_SX00['addentry']) && SEC_checkToken()) {
            $entry = '';
            $name = COM_applyFilter($_REQUEST['header-name']);
            $n = explode(':', $name);
            $name = $n[0];
            $value = $_REQUEST['header-value'];

            if (!empty($name) && !empty($value)) {
                $entry = $name . ': ' . $value;
            }

            $dbentry = addslashes($entry);
            if (!empty($entry)) {
                $result = DB_query("INSERT INTO {$_TABLES['spamx']} VALUES ('HTTPHeader','$dbentry')");
            }
        }

        $token = SEC_createToken();
        $display = '<hr' . XHTML . '>' . LB . '<p><b>';
        $display .= $LANG_SX00['headerblack'];
        $display .= '</b></p>' . LB . '<ul>' . LB;
        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name='HTTPHeader' ORDER BY value");
        $nrows = DB_numRows($result);
        for ($i = 0; $i < $nrows; $i++) {
            list($e) = DB_fetchArray($result);

            $display .= '<li>'. COM_createLink(htmlspecialchars($e),
                $_CONF['site_admin_url']
                . '/plugins/spamx/index.php?command=EditHeader&amp;action=delete&amp;entry=' . urlencode($e) . '&amp;' . CSRF_TOKEN . '=' . $token) . '</li>' . LB;
        }
        $display .= '</ul>' . LB . '<p>' . $LANG_SX00['e1'] . '</p>' . LB;
        $display .= '<p>' . $LANG_SX00['e2'] . '</p>' . LB;

        $display .= '<form method="post" action="' . $_CONF['site_admin_url']
                 . '/plugins/spamx/index.php?command=EditHeader">' . LB;
        $display .= '<table border="0" width="100%">' . LB;
        $display .= '<tr><td align="right"><b>Header:</b></td>' . LB;
        $display .= '<td><input type="text" size="40" name="header-name"'
                 . XHTML . '> e.g. <tt>User-Agent</tt></td></tr>' . LB;
        $display .= '<tr><td align="right"><b>Content:</b></td>' . LB;
        $display .= '<td><input type="text" size="40" name="header-value"'
                 . XHTML . '> e.g. <tt>Mozilla</tt></td></tr>' . LB;
        $display .= '</table>' . LB;
        $display .= '<p><input type="submit" name="paction" value="'
                 . $LANG_SX00['addentry'] . '"' . XHTML . '></p>';
        $display .= '<input type="hidden" name="' . CSRF_TOKEN
                 . "\" value=\"{$token}\"" . XHTML . '>' . LB;
        $display .= '</form>' . LB;

        return $display;
    }

    function link()
    {
        return "Edit HTTP Header Blacklist";
    }
}

?>
