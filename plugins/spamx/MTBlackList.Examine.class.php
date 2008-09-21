<?php

/**
 * File: MTBlackList.Examine.class.php
 * This module examines comments for entries on the MT-Blacklist
 * for the Geeklog Spam-X plugin
 * 
 * Copyright (C) 2004-2006 by the following authors:
 * Author   Tom Willett     tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 * 
 * The MT-Blacklist was maintained by Jay Allen
 * http://www.jayallen.org/comment_spam/
 *
 * $Id: MTBlackList.Examine.class.php,v 1.12 2008/09/21 08:37:08 dhaun Exp $
 */

if (strpos(strtolower($_SERVER['PHP_SELF']), 'MTBlackList.Examine.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Include Abstract Examine Class
 */
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
* html_entity_decode is only available as of PHP 4.3.0
*/
if (!function_exists ('html_entity_decode')) {
    require_once ('PHP/Compat.php');

    PHP_Compat::loadFunction ('html_entity_decode');
}

/**
 * Examines Comment according to MT-BLacklist
 * 
 * @author Tom Willett tomw AT pigstye DOT net 
 */

class MTBlackList extends BaseCommand {
    /**
     * No Constructor Use BaseCommand constructor
     */
    /**
     * Here we do the work
     */
    function execute ($comment)
    {
        global $_CONF, $_USER, $_TABLES, $LANG_SX00;

        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }

        /**
         * Include Blacklist Data
         */
        $result = DB_Query ("SELECT value FROM {$_TABLES['spamx']} WHERE name = 'MTBlacklist'", 1);
        $nrows = DB_numRows ($result);

        // named entities
        $comment = html_entity_decode ($comment);
        // decimal notation
        $comment = preg_replace ('/&#(\d+);/me', "chr(\\1)", $comment);
        // hex notation
        $comment = preg_replace ('/&#x([a-f0-9]+);/mei', "chr(0x\\1)", $comment);
        $ans = 0; // Found Flag
        for ($i = 1; $i <= $nrows; $i++) {
            list ($val) = DB_fetchArray ($result);
            if (@preg_match ("#$val#i", $comment)) {
                $ans = 1; // quit on first positive match
                SPAMX_log ($LANG_SX00['fsc'] . $val . $LANG_SX00['fsc1'] .
                           $uid . $LANG_SX00['fsc2'] . $_SERVER['REMOTE_ADDR']);
                break;
            } 
        } 
        return $ans;
    } 
} 

?>
