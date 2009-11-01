<?php

/**
* File: SLV.Action.class.php
* This is the Spam Link Verification Action class for the Geeklog Spam-X plugin
*
* Copyright (C) 2006 by the following authors:
* Author        Dirk Haun       dirk AT haun-online DOT de
*
* Licensed under the GNU General Public License
*
* @package Spam-X
* @subpackage Modules
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'slvreport.action.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Base Classes
*/
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';
require_once $_CONF['path'] . 'plugins/spamx/' . 'SLVbase.class.php';

/**
* Sends posts to SLV (linksleeve.org)
*
* Due to the way Spam-X works, the SLV Examine class may not have been
* triggered when some other module detected the spam first. SLV needs to
* see all links used in spam posts, though, to accurately detect spam. So
* this class ensures that SLV sees spam detected by other Spam-X modules, too.
*
* @author Dirk Haun     dirk AT haun-online DOT de
* based on the works of Tom Willet (Spam-X) and Russ Jones (SLV)
* @package Spam-X
*
*/
class SLVreport extends BaseCommand {
    /**
     * Constructor
     * Numbers are always binary digits and added together to make call
     */
    function SLVreport()
    {
        global $num;

        // Actually, this is the code used by the DeleteComment class.
        // We're piggybacking on the delete operation here.
        $num = 128;
    }

    /**
     * Here we do the work
     */
    function execute ($comment)
    {
        global $result;

        $result = 128;

        if (isset ($GLOBALS['slv_triggered']) && $GLOBALS['slv_triggered']) {
            // the Examine class already reported these to SLV
            return 1;
        }

        $slv = new SLVbase();
        $slv->CheckForSpam ($comment);

        return 1;
    }
}

?>
