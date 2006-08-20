<?php

/**
* File: EditIPofURL.Admin.class.php
* This is the Edit IPBlacklist Module for the Geeklog Spam-X plugin
*
* Copyright (C) 2004-2006 by the following authors:
* Author    Tom Willett     tomw AT pigstye DOT net
*           Dirk Haun       dirk AT haun-online DOT de
*
* Licensed under GNU General Public License
*
* $Id: EditIPofURL.Admin.class.php,v 1.4 2006/08/20 16:42:32 dhaun Exp $
*/

if (strpos ($_SERVER['PHP_SELF'], 'EditIPofURL.Admin.class.php') !== false) {
    die ('This file can not be used on its own!');
}

/**
* IP of URL Black List Editor
*/

require_once ($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');

class EditIPofUrl extends BaseAdmin {
    /**
     * Constructor
     */
    function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        require_once ($_CONF['path'] . 'plugins/spamx/rss.inc.php');

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
            $result = DB_query ("DELETE FROM {$_TABLES['spamx']} WHERE name = 'IPofUrl' AND value = '$entry'");
        } elseif ($action == $LANG_SX00['addentry']) {
            if (!empty ($entry)) {
                $entry = addslashes ($entry);
                $result = DB_query ("INSERT INTO {$_TABLES['spamx']} VALUES ('IPofUrl', '$entry')");
            }
        }

        $display = '<hr>' . LB . '<p><b>';
        $display .= $LANG_SX00['ipofurlblack'];
        $display .= '</b></p>' . LB . '<ul>' . LB;
        $result = DB_query ("SELECT value FROM {$_TABLES['spamx']} WHERE name = 'IPofUrl'");
        $nrows = DB_numRows ($result);
        for ($i = 0; $i < $nrows; $i++) {
            list($e) = DB_fetchArray ($result);
            $display .= '<li><a href="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=EditIPofUrl&amp;action=delete&amp;entry=' . urlencode ($e) . '">' . htmlspecialchars ($e) . '</a></li>' . LB;
        }
        $display .= '</ul>' . LB . '<p>' . $LANG_SX00['e1'] . '</p>' . LB;
        $display .= '<p>' . $LANG_SX00['e2'] . '</p>' . LB;
        $display .= '<form method="POST" action="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=EditIPofUrl">';
        $display .= '<input type="text" size ="30" name="pentry">&nbsp;&nbsp;&nbsp;';
        $display .= '<input type="submit" name="paction" value="' . $LANG_SX00['addentry'] . '">' . LB;
        $display .= '</form>' . LB;

        return $display;
    }

    function link()
    {
        return 'Edit IP of URL Blacklist';
    }
}

?>
