<?php

/**
* File: IPofUrl.Examine.class.php
* This is the Personal BlackList Examine class for the Geeklog Spam-X plugin
*
* Copyright (C) 2004-2006 by the following authors:
* Author        Tom Willett        tomw AT pigstye DOT net
*
* Licensed under GNU General Public License
*
* @package Spam-X
* @subpackage Modules
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'ipofurl.examine.class.php') !== false) {
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
*
* @package Spam-X
*
*/
class IPofUrl extends BaseCommand
{
    /**
     * Here we do the work
     */
    public function execute($comment)
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $uid = $this->getUid();

        /**
         * Check for IP of url in blacklist
         */
        /*
        * regex to find urls $2 = fqd
        */
        $regx = '(ftp|http|file)://([^/\\s]+)';
        $num = preg_match_all("#{$regx}#", html_entity_decode($comment), $urls);

        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name='IPofUrl'", 1);
        $nrows = DB_numRows($result);

        $ans = PLG_SPAM_NOT_FOUND;

        for ($j = 1; $j <= $nrows; $j++) {
            list ($val) = DB_fetchArray($result);

            for ($i = 0; $i < $num; $i++) {
                $ip = gethostbyname($urls[2][$i]);

                if ($val == $ip) {
                    $ans = PLG_SPAM_FOUND;	// quit on first positive match
                    $this->updateStat('IPofUrl', $val);
                    SPAMX_log($LANG_SX00['foundspam'] . $urls[2][$i] .
                              $LANG_SX00['foundspam2'] . $uid .
                              $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']);
                    break;
                }
            }

            if ($ans == PLG_SPAM_FOUND) {
                break;
            }
        }

        return $ans;
    }
}

?>
