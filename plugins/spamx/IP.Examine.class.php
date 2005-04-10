<?php

/**
* File: BlackList.Examine.class.php
* This is the Personal BlackList Examine class for the Geeklog Spam-X Plug-in!
*
* Copyright (C) 2004-2005 by the following authors:
* Author        Tom Willett        tomw AT pigstye DOT net
*
* Licensed under GNU General Public License
*
* $Id: IP.Examine.class.php,v 1.5 2005/04/10 10:02:45 dhaun Exp $
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

class IP extends BaseCommand {
    /**
     * No Constructor Use BaseCommand constructor
     */
    /**
     * Here we do the work
     */
    function execute($comment)
    {
        global $_CONF, $_TABLES, $_USER, $LANG_SX00, $result;

        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }

        /**
         * Include Blacklist Data
         */
        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name='IP'", 1);
        $nrows = DB_numRows($result);

        $ans = 0;
        for ($i = 1; $i <= $nrows; $i++) {
            list ($val) = DB_fetchArray ($result);
            if ($val == $_SERVER['REMOTE_ADDR']) {
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
