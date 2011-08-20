<?php

/**
* File: SNL.Action.class.php
* This is the Spam Number of Links Action class for the Geeklog Spam-X plugin
*
* Copyright  (C) 2006 Tom Homer	 - WebSiteMaster AT cogeco DOT com   
*
* Licensed under the GNU General Public License
*
* 
*/

if (strpos ($_SERVER['PHP_SELF'], 'SNLreport.Action.class.php') !== false) {
    die ('This file can not be used on its own!');
}

/**
* Include Base Classes
*/
require_once ($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');
require_once ($_CONF['path'] . 'plugins/spamx/' . 'SNLbase.class.php');

/**
* Check posts for Links
*
* Due to the way Spam-X works, the SNL Examine class may not have been
* triggered (when some other module detected the spam first). SNL needs to
* see all links used in spam posts, though, to accurately detect spam. So
* this class ensures that SNL sees spam detected by other Spam-X modules, too.
*

* based in large part on the works of Dirk Haun, Tom Willet (Spam-X) and Russ Jones (SLV)
*/

class SNLreport extends BaseCommand {
    /**
     * Constructor
     * Numbers are always binary digits and added together to make call
     */
    function SNLreport()
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

        if (isset ($GLOBALS['SNL_triggered']) && $GLOBALS['SNL_triggered']) {
            // the Examine class already reported these to SNL
            return 1;
        }

        $SNL = new SNLbase();
        $SNL->CheckForSpam ($comment);

        return 1;
    }
}

?>
