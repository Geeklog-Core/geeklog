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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'EditBlackList.Admin.class.php') !== false) {
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
class EditBlackList extends BaseAdmin {
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

        $entry = '';
        if (isset($_GET['entry'])) {
            $entry = COM_stripslashes($_GET['entry']);
        } elseif (isset($_POST['pentry'])) {
            $entry = COM_stripslashes($_POST['pentry']);
        }

        if (($action == 'delete') && SEC_checkToken()) {
            $entry = addslashes($entry);
            DB_delete($_TABLES['spamx'], array('name', 'value'),
                                         array('Personal', $entry));
        } elseif (($action == $LANG_SX00['addentry']) && SEC_checkToken()) {
            if (!empty($entry)) {
                $entry = addslashes($entry);
                $result = DB_query("INSERT INTO {$_TABLES['spamx']} VALUES ('Personal', '$entry')");
            }
        } elseif (($action == $LANG_SX00['addcen']) && SEC_checkToken()) {
            foreach ($_CONF['censorlist'] as $entry) {
                $entry = addslashes($entry);
                $result = DB_query("INSERT INTO {$_TABLES['spamx']} VALUES ('Personal', '$entry')");
            }
        }

        $token = SEC_createToken();
        $display = '<hr' . XHTML . '>' . LB . '<p><b>';
        $display .= $LANG_SX00['pblack'];
        $display .= '</b></p>' . LB . '<ul>' . LB;
        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name = 'Personal'");
        $nrows = DB_numRows($result);
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $e = $A['value'];
            $display .= '<li>' . COM_createLink(htmlspecialchars($e),
                $_CONF['site_admin_url']
                . '/plugins/spamx/index.php?command=EditBlackList&amp;action=delete&amp;entry=' . urlencode($e) . '&amp;' . CSRF_TOKEN . '=' . $token) . '</li>' . LB;
        }
        $display .= '</ul>' . LB . '<p>' . $LANG_SX00['e1'] . '</p>' . LB;
        $display .= '<p>' . $LANG_SX00['e2'] . '</p>' . LB;
        $display .= '<form method="post" action="' . $_CONF['site_admin_url']
                 . '/plugins/spamx/index.php?command=EditBlackList">' . LB;
        $display .= '<div><input type="text" size="30" name="pentry"' . XHTML
                 . '>&nbsp;&nbsp;&nbsp;';
        $display .= '<input type="submit" name="paction" value="'
                 . $LANG_SX00['addentry'] . '"' . XHTML . '>' . LB;
        $display .= '<p>' . $LANG_SX00['e3'] . '</p>&nbsp;&nbsp;&nbsp;';
        $display .= '<input type="submit" name="paction" value="'
                 . $LANG_SX00['addcen'] . '"' . XHTML . '>' . LB;
        $display .= '<input type="hidden" name="' . CSRF_TOKEN
                 . "\" value=\"{$token}\"" . XHTML . '>' . LB;
        $display .= '</div></form>' . LB;

        return $display;
    }

    function link()
    {
        return 'Edit Personal Blacklist';
    }
}

?>
