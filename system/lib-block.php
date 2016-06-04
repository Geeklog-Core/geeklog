<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.9.0                                                             |
// +---------------------------------------------------------------------------+
// | lib-block.php                                                             |
// |                                                                           |
// | Geeklog syndication library.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tom Homer        - tomhomer AT gmail DOT com                     |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-block.php') !== false) {
    die('This file can not be used on its own!');
}

// set to true to enable debug output in error.log
$_BLOCK_DEBUG = false;

/*
 * Implement *some* of the Plugin API functions for blocks. While blocks
 * aren't a plugin (and likely never will be), implementing some of the API
 * functions here will save us from doing special handling elsewhere.
 */

/**
* This function is called to inform plugins when a group's information has
* changed or a new group has been created.
*
* @param    int     $grp_id     Group ID
* @param    string  $mode       type of change: 'new', 'edit', or 'delete'
* @return   void
*
*/
function plugin_group_changed_block($grp_id, $mode)
{
    global $_TABLES, $_GROUPS;

    if ($mode == 'delete') {
        // Change any deleted group ids to Block Admin if exist, if does not change to root group
        $new_group_id = 0;
        if (isset($_GROUPS['Block Admin'])) {
            $new_group_id = $_GROUPS['Block Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Block Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }

        // Update Block with new group id
        $sql = "UPDATE {$_TABLES['blocks']} SET group_id = $new_group_id WHERE group_id = $grp_id";
        $result = DB_query($sql);
   }
}

/**
* Implements the [block:] autotag.
*
* @param    string  $op         operation to perform
* @param    string  $content    item (e.g. block text), including the autotag
* @param    array   $autotag    parameters used in the autotag
* @param    mixed               tag names (for $op='tagname') or formatted content
*
*/
function plugin_autotags_block($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES, $LANG21, $_GROUPS;

    if ($op == 'tagname') {
        return array('block');
    } elseif ($op == 'permission' || $op == 'nopermission') {
        if ($op == 'permission') {
            $flag = true;
        } else {
            $flag = false;
        }
        $tagnames = array();

        if (isset($_GROUPS['Block Admin'])) {
            $group_id = $_GROUPS['Block Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id',
                                   "grp_name = 'Block Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();

        if (COM_getPermTag($owner_id, $group_id,
            $_CONF['autotag_permissions_block'][0],
            $_CONF['autotag_permissions_block'][1],
            $_CONF['autotag_permissions_block'][2],
            $_CONF['autotag_permissions_block'][3]) == $flag) {
            $tagnames[] = 'block';
        }

        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'description') {
        return array (
            'block' => $LANG21['autotag_desc_block']
            );
    } elseif ($op == 'parse') {
        $name = COM_applyFilter($autotag['parm1']);
        if (!empty($name)) {
            $result = DB_query("SELECT * "
                . "FROM {$_TABLES['blocks']} "
                . "WHERE name = '$name'");
            $A = DB_fetchArray($result);
            if (DB_numRows($result) > 0) {

                switch ($autotag['tag']) {
                case 'block':
                    $px = explode(' ', trim($autotag['parm2']));
                    $css_class = "block-autotag";

                    if (is_array($px)) {
                        foreach ($px as $part) {
                            if (substr($part, 0, 6) == 'class:') {
                                $a = explode(':', $part);
                                // append a class
                                $css_class .= ' ' . $a[1];
                            } else {
                                break;
                            }
                        }
                    }

                    $retval = COM_formatBlock($A, false, true);

                    // the class block-autotag will always be included with the div
                    $retval = '<div class="' . $css_class . '">' . $retval . '</div>';

                    break;
                }

                $content = str_replace($autotag['tagstr'], $retval, $content);
            }
        }
    }

    return $content;
}
