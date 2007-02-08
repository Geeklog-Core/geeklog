<?php

/**
 * File: EditBlackList.Admin.class.php
 * This is the Edit Personal Blacklist Module for the Geeklog Spam-X plugin
 *
 * Copyright (C) 2004-2006 by the following authors:
 * Author   Tom Willett     tomw AT pigstye DOT net
 *          Dirk Haun       dirk AT haun-online DOT de
 *
 * Licensed under GNU General Public License
 *
 * $Id: EditBlackList.Admin.class.php,v 1.9 2007/02/08 01:42:16 ospiess Exp $
 */

if (strpos ($_SERVER['PHP_SELF'], 'EditBlackList.Admin.class.php') !== false) {
    die ('This file can not be used on its own!');
}

/**
 * Personal Black List Editor
 */

require_once ($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');

class EditBlackList extends BaseAdmin {
    /**
     * Constructor
     */
    function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $action = '';
        if (isset ($_GET['action'])) {
            $action = COM_applyFilter ($_GET['action']);
        } else if (isset ($_POST['paction'])) {
            $action = COM_applyFilter ($_POST['paction']);
        }

        $entry = '';
        if (isset ($_GET['entry'])) {
            $entry = COM_stripslashes ($_GET['entry']);
        } else if (isset ($_POST['pentry'])) {
            $entry = COM_stripslashes ($_POST['pentry']);
        }

        if ($action == 'delete') {
            $entry = addslashes ($entry);
            $result = DB_query ("DELETE FROM {$_TABLES['spamx']} WHERE name = 'Personal' AND value = '$entry'");
        } elseif ($action == $LANG_SX00['addentry']) {
            if (!empty ($entry)) {
                $entry = addslashes ($entry);
                $result = DB_query ("INSERT INTO {$_TABLES['spamx']} VALUES ('Personal', '$entry')");
            }
        } elseif ($action == $LANG_SX00['addcen']) {
            foreach ($_CONF['censorlist'] as $entry) {
                $entry = addslashes ($entry);
                $result = DB_query ("INSERT INTO {$_TABLES['spamx']} VALUES ('Personal', '$entry')");
            }
        }

        $display = '<hr>' . LB . '<p><b>';
        $display .= $LANG_SX00['pblack'];
        $display .= '</b></p>' . LB . '<ul>' . LB;
        $result = DB_query ("SELECT value FROM {$_TABLES['spamx']} WHERE name = 'Personal'");
        $nrows = DB_numRows ($result);
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray ($result);
            $e = $A['value'];
            $display .= '<li>' . COM_createLink(htmlspecialchars ($e),
                $_CONF['site_admin_url']
                . '/plugins/spamx/index.php?command=EditBlackList&amp;action=delete&amp;entry='
                . urlencode ($e)) . '</li>' . LB;
        }
        $display .= '</ul>' . LB . '<p>' . $LANG_SX00['e1'] . '</p>' . LB;
        $display .= '<p>' . $LANG_SX00['e2'] . '</p>' . LB;
        $display .= '<form method="POST" action="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=EditBlackList">' . LB;
        $display .= '<fieldset><input type="text" size="30" name="pentry">&nbsp;&nbsp;&nbsp;';
        $display .= '<input type="submit" name="paction" value="' . $LANG_SX00['addentry'] . '">' . LB;
        $display .= '<p>' . $LANG_SX00['e3'] . '&nbsp&nbsp&nbsp';
        $display .= '<input type="submit" name="paction" value="' . $LANG_SX00['addcen'] . '">' . LB;
        $display .= '</fieldset></form>' . LB;

        return $display;
    }

    function link()
    {
        return 'Edit Personal Blacklist';
    }
}

?>
