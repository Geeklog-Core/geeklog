<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | links.php                                                                 |
// | This is the links page                                                    |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |          Mark Limburg     - mlimburg@dingoblue.net.au                     |
// |          Jason Wittenburg - jwhitten@securitygeeks.com                    |
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
// $Id: links.php,v 1.7 2001/10/17 23:35:47 tony_bibbs Exp $

include_once('lib-common.php');

// MAIN

$display .= site_header()
    .COM_startBlock($LANG06[1])
    .'[ <a href="'.$_CONF['site_url'].'/submit.php?type=link">'.$LANG06[3].'</a> ]';
	
$result = DB_query("SELECT * from links ORDER BY category asc,title");
$nrows = DB_numRows($result);
if ($nrows==0) {
    $display .= $LANG06[2].'<br>';
} else {
    for($i=0;$i<$nrows;$i++) {
        $A	= DB_fetchArray($result);
        if (SEC_hasAccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
            if ($A['category']!=$currentcat) {
                $display .= sprintf("<h3>%s</h3>\n<ul>",$A['category']);
            }
            $display .= '<li><b><a target="_new" '
                .sprintf("href=\"{$_CONF['site_url']}/portal.php?url=%s&what=link&item=%s\">%s</a></b> (%s)"
                ,urlencode($A['url']),$A['lid'],$A['title'],$A['hits'])
                .'<br>'.stripslashes($A['description']).'</li>'.LB;
				
            $currentcat	= $A['category'];
        }
    } 
    $display .= '</ul>'.LB;
}

$display .= '<br>' . COM_endBlock() . site_footer();

echo $display;

?>
