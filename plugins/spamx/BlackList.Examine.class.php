<?php
/**
 * File: BlackList.Examine.class.php
 * This is the Personal BlackList Examine class for the Geeklog SpamX Plug-in!
 * 
 * Copyright (C) 2004 by the following authors:
 * Author		Tom Willett		tomw@pigstye.net
 * 
 * Licensed under GNU General Public License
 */

/**
 * Include Abstract Examine Class
 */
require_once($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');

/**
* html_entity_decode is only available as of PHP 4.3.0
*/
if (!function_exists ('html_entity_decode')) {
    require_once ('PHP/Compat.php');

    PHP_Compat::loadFunction ('html_entity_decode');
}

/**
 * Examines Comment according to Personal BLacklist
 * 
 * @author Tom Willett tomw AT pigstye DOT net 
 */

class BlackList extends BaseCommand {
    /**
     * No Constructor Use BaseCommand constructor
     */
    /**
     * Here we do the work
     */
    function execute($comment)
    {
        global $_CONF, $_TABLES, $_USER, $LANG_SX00, $result;

        /**
         * Include Blacklist Data
         */
        $result = DB_query("SELECT * FROM {$_TABLES['spamx']} WHERE name='Personal'", 1);
        $nrows = DB_numRows($result);

        $ans = 0;
        for($i = 1;$i <= $nrows;$i++) {
            $A = DB_fetchArray($result);
            $val = $A['value'];
            if (preg_match("#$val#", html_entity_decode ($comment))) {
                $ans = 1; // quit on first positive match
                SPAMX_log($LANG_SX00['foundspam'] . $val . $LANG_SX00['foundspam2'] . $_USER['uid'] . $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']);
                break;
            } 
        } 
        return $ans;
    } 
} 

?>
