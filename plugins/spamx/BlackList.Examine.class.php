<?php

/**
 * File: BlackList.Examine.class.php
 * This is the Personal BlackList Examine class for the Geeklog Spam-X plugin
 * 
 * Copyright (C) 2004-2006 by the following authors:
 * Author   Tom Willett     tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 * @package Spam-X
 * @subpackage Modules
 */

if (strpos(strtolower($_SERVER['PHP_SELF']), 'blacklist.examine.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Include Abstract Examine Class
 */
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Examines Comment according to Personal BLacklist
 * 
 * @author Tom Willett tomw AT pigstye DOT net 
 * @package Spam-X
 *
 */
class BlackList extends BaseCommand {
    /**
     * No Constructor Use BaseCommand constructor
     */
    /**
     * Here we do the work
     */
    function execute ($comment)
    {
        global $_CONF, $_TABLES, $_USER, $LANG_SX00;

        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }

        /**
         * Include Blacklist Data
         */
        $result = DB_query ("SELECT value FROM {$_TABLES['spamx']} WHERE name='Personal'", 1);
        $nrows = DB_numRows ($result);

        // named entities
        $comment = html_entity_decode ($comment);
        // decimal notation
        $comment = preg_replace ('/&#(\d+);/me', "chr(\\1)", $comment);
        // hex notation
        $comment = preg_replace ('/&#x([a-f0-9]+);/mei', "chr(0x\\1)", $comment);
        $ans = 0;
        for ($i = 1; $i <= $nrows; $i++) {
            list ($val) = DB_fetchArray ($result);
            $val = str_replace ('#', '\\#', $val);
            if (preg_match ("#$val#i", $comment)) {
                $ans = 1; // quit on first positive match
                SPAMX_log ($LANG_SX00['foundspam'] . $val .
                           $LANG_SX00['foundspam2'] . $uid .
                           $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']);
                break;
            }
        }
        return $ans;
    }
}

?>
