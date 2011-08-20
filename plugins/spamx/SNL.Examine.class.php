<?php

/**
* File: SNL.Examine.class.php
* This is the Spam Number of Links Examine class for the Geeklog Spam-X plugin
*
* Copyright  (C) 2006 Tom Homer	 - WebSiteMaster AT cogeco DOT com     
*
* Licensed under the GNU General Public License
*
*
*/

if (strpos ($_SERVER['PHP_SELF'], 'SNL.Examine.class.php') !== false) {
    die ('This file can not be used on its own!');
}

/**
* Include Base Classes
*/
require_once ($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');
require_once ($_CONF['path'] . 'plugins/spamx/' . 'SNLbase.class.php');

/**
* Checks number of links in post.
*
* based in large part on the works of Dirk Haun, Tom Willet (Spam-X) and Russ Jones (SLV)
*/

class SNL extends BaseCommand {
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

        $SNL = new SNLbase();
        if ($SNL->CheckForSpam ($comment)) {
            $ans = 1;
            SPAMX_log ($LANG_SX00['foundspam'] . 'Spam Number of Links (SNL)'.
                       $LANG_SX00['foundspam2'] . $uid .
                       $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']);
        }

        // tell the Action module that we've already been triggered
        $GLOBALS['SNL_triggered'] = true;

        return $ans;
    }
}

?>
