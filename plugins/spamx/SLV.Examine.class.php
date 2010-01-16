<?php

/**
* File: SLV.Examine.class.php
* This is the Spam Link Verification Examine class for the Geeklog Spam-X plugin
*
* Copyright (C) 2006 by the following authors:
* Author        Dirk Haun       dirk AT haun-online DOT de
*
* Licensed under the GNU General Public License
*
* @package Spam-X
* @subpackage Modules
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'slv.examine.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Base Classes
*/
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';
require_once $_CONF['path'] . 'plugins/spamx/' . 'SLVbase.class.php';

/**
* Sends posts to SLV (linksleeve.org) for examination
*
* @author Dirk Haun     dirk AT haun-online DOT de
* based on the works of Tom Willet (Spam-X) and Russ Jones (SLV)
* @package Spam-X
*
*/
class SLV extends BaseCommand {
    /**
     * No Constructor Use BaseCommand constructor
     */

    /**
     * Here we do the work
     */
    function execute ($comment)
    {
        global $_USER, $LANG_SX00;

        $ans = 0;

        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }

        $slv = new SLVbase();
        if ($slv->CheckForSpam ($comment)) {
            $ans = 1;
            SPAMX_log ($LANG_SX00['foundspam'] . 'Spam Link Verification (SLV)'.
                       $LANG_SX00['foundspam2'] . $uid .
                       $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']);
        }

        // tell the Action module that we've already been triggered
        $GLOBALS['slv_triggered'] = true;

        return $ans;
    }
}

?>
