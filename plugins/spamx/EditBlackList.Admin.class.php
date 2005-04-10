<?php

/**
 * File: EditBlackList.Admin.class.php
 * This is the Edit Personal Blacklist Module for the Geeklog Spam-X Plug-in!
 * 
 * Copyright (C) 2004-2005 by the following authors:
 * Author		Tom Willett		tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 * $Id: EditBlackList.Admin.class.php,v 1.4 2005/04/10 10:02:44 dhaun Exp $
 */

/**
 * Personal Black List Editor
 */

require_once($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');

class EditBlackList extends BaseAdmin {
    /**
     * Constructor
     */
    function display()
    {
        global $_CONF, $_GET, $_POST, $_TABLES, $LANG_SX00;

        require_once $_CONF['path'] . 'plugins/spamx/rss.inc.php';

        $action = COM_applyFilter($_GET['action']);
        if (empty($action)) {
            $action = COM_applyFilter($_POST['paction']);
        } 

        $entry = COM_applyFilter($_GET['entry']);
        if (empty($entry)) {
            $entry = COM_applyFilter($_POST['pentry']);
        } 

        if ($action == 'delete') {
            $result = DB_query('DELETE FROM ' . $_TABLES['spamx'] . ' where name="Personal" AND value="' . $entry . '"');
        } elseif ($action == $LANG_SX00['addentry']) {
            if ($entry != "") {
                $result = DB_query('INSERT INTO ' . $_TABLES['spamx'] . ' VALUES ("Personal","' . $entry . '")');
            } 
        } elseif ($action == $LANG_SX00['addcen']) {
            foreach($_CONF['censorlist'] as $entry) {
                $result = DB_query('INSERT INTO ' . $_TABLES['spamx'] . ' VALUES ("Personal","' . $entry . '")');
            } 
        } 

        $display = '<hr><p><b>';
        $display .= $LANG_SX00['pblack'];
        $display .= '</b></p><ul>';
        $result = DB_query('SELECT * FROM ' . $_TABLES['spamx'] . ' WHERE name="Personal"');
        $nrows = DB_numRows($result);
        for($i = 1;$i <= $nrows;$i++) {
            $A = DB_fetchArray($result);
            $e = $A['value'];
            $display .= '<li><a href="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=EditBlackList&action=delete&entry=' . urlencode($e) . '">' . $e . '</a></li>';
        } 
        $display .= '</ul><p>' . $LANG_SX00['e1'] . '</p>';
        $display .= '<p>' . $LANG_SX00['e2'] . '</p>';
        $display .= '<form method="post" action="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=EditBlackList">';
        $display .= '<input type="text" size ="30" name="pentry">&nbsp;&nbsp;&nbsp;';
        $display .= '<input type="Submit" name="paction" value="' . $LANG_SX00['addentry'] . '">';
        $display .= '<p>' . $LANG_SX00['e3'] . '&nbsp&nbsp&nbsp';
        $display .= '<input type = "Submit" name="paction" value="' . $LANG_SX00['addcen'] . '">';
        $display .= '</form>';
        return $display;
    } 

    function link()
    {
        return "Edit Personal Blacklist";
    } 
} 

?>
