<?php

/**
* File: EditHeader.Admin.class.php
* This is the Edit HTTP Header Module for the Geeklog Spam-X plugin
*
* Copyright (C) 2005-2006 by the following authors:
* Author    Dirk Haun <dirk AT haun-online DOT de>
*
* based on the works of Tom Willett <tomw AT pigstye DOT net>
*
* Licensed under GNU General Public License
*
* $Id: EditHeader.Admin.class.php,v 1.7 2007/02/08 01:42:16 ospiess Exp $
*/

if (strpos ($_SERVER['PHP_SELF'], 'EditHeader.Admin.class.php') !== false) {
    die ('This file can not be used on its own!');
}

/**
* HTTP Header Editor
*/

require_once($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');

class EditHeader extends BaseAdmin {
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

        if ($action == 'delete') {
            $entry = $_GET['entry'];
            if (!empty ($entry)) {
                $dbentry = addslashes ($entry);
                $result = DB_query ("DELETE FROM {$_TABLES['spamx']} WHERE name='HTTPHeader' AND value='$dbentry'");
            }
        } elseif ($action == $LANG_SX00['addentry']) {
            $entry = '';
            $name = COM_applyFilter ($_REQUEST['header-name']);
            $n = explode (':', $name);
            $name = $n[0];
            $value = $_REQUEST['header-value'];

            if (!empty ($name) && !empty ($value)) {
                $entry = $name . ': ' . $value;
            }

            $dbentry = addslashes ($entry);
            if (!empty ($entry)) {
                $result = DB_query ("INSERT INTO {$_TABLES['spamx']} VALUES ('HTTPHeader','$dbentry')");
            }
        }

        $display = '<hr><p><b>';
        $display .= $LANG_SX00['headerblack'];
        $display .= '</b></p><ul>';
        $result = DB_query ("SELECT value FROM {$_TABLES['spamx']} WHERE name='HTTPHeader' ORDER BY value");
        $nrows = DB_numRows ($result);
        for ($i = 0; $i < $nrows; $i++) {
            list($e) = DB_fetchArray ($result);

            $display .= '<li>'. COM_createLink($e , $_CONF['site_admin_url']
                . '/plugins/spamx/index.php?command=EditHeader&amp;action=delete&amp;entry='
                . urlencode ($e)) . '</li>';
        }
        $display .= '</ul><p>' . $LANG_SX00['e1'] . '</p>';
        $display .= '<p>' . $LANG_SX00['e2'] . '</p>';

        $display .= '<form method="POST" action="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=EditHeader">';
        $display .= '<table border="0" width="100%">' . LB;
        $display .= '<tr><td align="right"><b>Header:</b></td>' . LB;
        $display .= '<td><input type="text" size="40" name="header-name"> e.g. <tt>User-Agent</tt></td></tr>' . LB;
        $display .= '<tr><td align="right"><b>Content:</b></td>' . LB;
        $display .= '<td><input type="text" size="40" name="header-value"> e.g. <tt>Mozilla</tt></td></tr>' . LB;
        $display .= '</table>' . LB;
        $display .= '<p><input type="Submit" name="paction" value="' . $LANG_SX00['addentry'] . '"></p>';
        $display .= '</form>';
        return $display;
    }

    function link()
    {
        return "Edit HTTP Header Blacklist";
    }
}

?>
