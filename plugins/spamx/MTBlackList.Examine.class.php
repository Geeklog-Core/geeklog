<?php
/**
 * File: MTBlackList.Examine.class.php
 * This module examines comments for entries on the MT-Blacklist for the Geeklog SpamX Plug-in!
 * 
 * Copyright (C) 2004 by the following authors:
 * Author		Tom Willett		tomw@pigstye.net
 * 
 * Licensed under GNU General Public License
 * 
 * The MT-Blacklist is maintained by Jay Allen
 * http://www.jayallen.org/comment_spam/
 */

/**
 * Include Abstract Examine Class
 */
require_once($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');

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
    function execute($comment)
    {
        global $_CONF, $_USER, $_TABLES, $_SERVER, $LANG_SX00;

        /**
         * Include Blacklist Data
         */
        $result = DB_Query("SELECT * FROM {$_TABLES['spamx']} WHERE name='MTBlacklist'", 1);
        $nrows = DB_numRows($result);

        $ans = 0; //Found Flag
        for ($i = 1;$i <= $nrows;$i++) {
            $A = DB_fetchArray($result);
            $val = $A['value'];
            if (@preg_match("#$val#", $comment)) {
                $ans = 1; // quit on first positive match
                SPAMX_log($LANG_SX00['fsc'] . $val . $LANG_SX00['fsc1'] . $_USER['uid'] . $LANG_SX00['fsc2'] . $_SERVER['REMOTE_ADDR']);
                break;
            } 
        } 
        return $ans;
    } 
} 

?>
