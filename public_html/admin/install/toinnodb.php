<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | toinnodb.php                                                              |
// |                                                                           |
// | Change Geeklog tables from MyISAM to InnoDB.                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004 by the following authors:                              |
// |                                                                           |
// | Authors: Dirk Haun - dirk@haun-online.de                                  |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
// $Id: toinnodb.php,v 1.1 2004/08/14 09:05:11 dhaun Exp $

require_once ('../../lib-common.php');

// bail if user isn't a root user
if (!SEC_inGroup ('Root')) {
    $display = COM_siteHeader ('menu');
    $display .= COM_startBlock ($MESSAGE[30], '',
                    COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $LANG20[6];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter ();
    COM_accessLog ("User {$_USER['username']} tried to illegally access the optimize database screen.");
    echo $display;
    exit;
}

/**
* Check for InnoDB table support (usually as of MySQL 4.0, but may be
* available in earlier versions, e.g. "Max" or custom builds).
*
* @return   true = InnoDB tables supported, false = not supported
*
*/
function innodb_supported ()
{
    $result = DB_query ("SHOW VARIABLES LIKE 'have_innodb'");
    $A = DB_fetchArray ($result, true);

    if (strcasecmp ($A[1], 'yes') == 0) {
        $retval = true;
    } else {
        $retval = false;
    }

    return $retval;
}


// MAIN

echo COM_siteHeader ('menu');
echo COM_startBlock ('Changing tables to InnoDB');

if (innodb_supported ()) {

    echo '<p>This may take a while ...</p>' . LB;
    flush ();

    $opt_time = new timerobject ();
    $opt_time->startTimer ();

    $result = DB_query ("SHOW TABLES");
    $numTables = DB_numRows ($result);
    for ($i = 0; $i < $numTables; $i++) {
        $A = DB_fetchArray ($result, true);
        if (in_array ($A[0], $_TABLES)) {
            DB_query ("ALTER TABLE $A[0] TYPE=InnoDB");
        }
    }

    $exectime = $opt_time->stopTimer ();

    echo '<p>Changing ' . sizeof ($_TABLES) . ' tables to InnoDB took '
         . $exectime . ' seconds.<p>' . LB;

} else {

    echo '<p>Sorry, your database does not support InnoDB tables.</p>' . LB;

}

echo COM_endBlock ();
echo COM_siteFooter ();

?>
