<?php
/**
* File: BlackList.Examine.class.php
* This is the Personal BlackList Examine class for the Geeklog SpamX Plug-in!
*
* Copyright (C) 2004 by the following authors:
* Author        Tom Willett        tomw@pigstye.net
*
* Licensed under GNU General Public License
*/

/**
* Include Abstract Examine Class
*/
require_once($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');

/**
* Examines Comment according to Personal BLacklist
*
* @author Tom Willett tomw AT pigstye DOT net
*/

class IPofUrl extends BaseCommand {
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
         * Check for IP of url in blacklist
         */
        /*
        * regex to find urls $2 = fqd
        */
        $regx = '(ftp|http|file)://([^/\\s]+)';
        $num = preg_match_all("#{$regx}#",$comment,$urls);

        $result = DB_query("SELECT * FROM {$_TABLES['spamx']} WHERE name='IPofUrl'", 1);
        $nrows = DB_numRows($result);

        $ans = 0;
        for($j = 1;$j <= $nrows;$j++) {
            $A = DB_fetchArray($result);
            $val = $A['value'];
            for ($i=0;$i<$num;$i++) {
              $ip = gethostbyname($urls[2][$i]);
              if ($val == $ip) {
                $ans = 1; // quit on first positive match
                SPAMX_log($LANG_SX00['foundspam'] . $urls[2][$i] . $LANG_SX00['foundspam2'] . $_USER['uid'] . $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']);
                break;
              }
            }
            if ($ans == 1) {
              break;
            }
        }
        return $ans;
    }
}

?>