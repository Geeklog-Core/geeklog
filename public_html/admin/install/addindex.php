<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | addindex.php                                                              |
// | Add index field to Geeklog tables.                                        |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002 by the following authors:                              |
// |                                                                           |
// | Authors: Dirk Haun        - dirk@haun-online.de                           |
// | with the help of Jeffrey Schoolcraft, Marc von Ahn, and Rob Griffiths     |
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
// $Id: addindex.php,v 1.2 2002/12/28 20:10:06 dhaun Exp $


// Add missing indexes to Geeklog tables
//
// Date        Version  Author
// ----        -------  ------
//  2002-10-22  0.1      Dirk Haun <dirk@haun-online.de>
//              Initial version
//  2002-11-24  0.2      Dirk Haun <dirk@haun-online.de>
//              Added key names for the indexes, added authentication check

require_once('../../lib-common.php');

if (!SEC_inGroup ('Root')) {
    COM_errorLog ("Access denied to {$PHP_SELF} for user {$_USER['username']}, IP=" . $HTTP_SERVER_VARS['REMOTE_ADDR']);
    $display = COM_siteHeader('menu');
    $display .= COM_startBlock($LANG20[1]);
    $display .= $LANG20[6];
    $display .= COM_endBlock();
    $display .= COM_siteFooter();
    echo $display;
    exit;
}

// $_DEBUG = 1;

// list according to Jeff's post on geeklog-devel (2002-10-14)
// plus stories.hits (Rob Griffiths) plus group_assignments.ug_uid
// <http://www.geeklog.net/article.php?story=20021011151827972>

$index['comments']          = "cid,type,sid,date,uid";
$index['stories']           = "sid,tid,date,uid,frontpage,featured,hits";
$index['blocks']            = "bid,is_enabled,tid,type";
$index['events']            = "eid,datestart,dateend,event_type";
$index['links']             = "lid,category,date";
$index['pollquestions']     = "qid,date,display,commentcode,statuscode";
$index['staticpage']        = "sp_id,sp_uid,sp_date,sp_onmenu";
$index['userindex']         = "uid,noboxes,maxstories";
$index['group_assignments'] = "ug_main_grp_id,ug_uid";


echo COM_siteHeader('menu');
echo COM_startBlock("Updating indexes ...");

foreach ($index as $table=>$fields) {

    $idx = explode (",", $fields);

    echo "<p>Table: {$_TABLES[$table]}</p>";

    if ($_DEBUG) {
        echo "<p>Wanted: ";
        foreach ($idx as $id) {
            echo "$id, ";
        }
        echo "</p>";
    }

    $result = DB_query ("show index from {$_TABLES[$table]}");
    $nrows = DB_numRows ($result);
    $exidx = array ();
    for ($i = 0; $i < $nrows; $i++) {
        $A = DB_fetchArray ($result);
        $exidx[] = $A['Column_name'];
    }
    $newidx = array_diff ($idx, $exidx);

    if ($_DEBUG) {
        echo "<p>Existing: ";
        foreach ($exidx as $ex) {
            echo "$ex, ";
        }
        echo "</p>";
    }

    if ($_DEBUG) {
        echo "<p>Need to add: ";
        foreach ($newidx as $ne) {
            echo "$ne, ";
        }
        echo "</p>";
    }

    if (sizeof ($newidx) > 0) {
        echo "<p>Adding indexes ...<br>";
        foreach ($newidx as $ne) {
            $idxname = $table . '_' . $ne;
            echo "Adding index \"$idxname\"";
            flush ();

            $idxtimer = new timerobject ();
            $idxtimer->setPercision (4);
            $idxtimer->startTimer ();

            DB_query("ALTER TABLE {$_TABLES[$table]} ADD INDEX $idxname ($ne)");

            $idxtime = $idxtimer->stopTimer ();
            $idxtimer->setPercision (4);
            echo " in $idxtime seconds<br>";
        }
        echo "Done!</p>";
    } else {
        echo "<p>No index to add for table {$_TABLES[$table]}</p>";
    }

    echo "<hr>";
}

echo COM_endBlock();
echo COM_siteFooter();

?>
