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

// These constants are used by block position (onleft column in blocks table)
// a topic option.
// The global variable $topic should never be one of these. It should be set to
// either a topic id the user has access to or empty (which means all topics).
define("BLOCK_ALL_POSITIONS", -1);
define("BLOCK_NONE_POSITION", 2);
define("BLOCK_LEFT_POSITION", 1);
define("BLOCK_RIGHT_POSITION", 0);

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
 * Set template variables for any additional block locations
 *
 * @param    string   $templatename name of template, e.g. 'header'
 * @param    Template $template     reference of actual template
 * @return   void
 *                                  Note: A plugin should use its name as a prefix for the names of its
 *                                  template variables, e.g. 'block_xxx' and 'lang_block_xxx'.
 */
function plugin_templatesetvars_block($templatename, &$template)
{
    global $_CONF;
    
    // Retrieve custom block position names
    // A template can have more than one template variable assigned to a block location
    // template_variable name should start with blocks_ and be returned in array like:
    /*
    $block_locations[] = array(
        'id'                => 'theme_footer', // Unique string. No other block location (includes Geeklog itself and any other plugins or themes) can share the same id ("left" and "right" are already taken).
        'name'              => 'Text Name of block location',
        'description'       => 'Text description of block location',
        'template_name'     => 'footer',
        'template_variable' => 'blocks_footer'
    );
    */    

    // Include block locations on behalf of the theme, plugins (and there supported themes)
    $block_locations = PLG_getBlockLocations();

    $keys = array_keys(array_column($block_locations, 'template_name'), $templatename);

    // Template could have multiple block template variables so loop through found keys
    foreach($keys as $key) {
        //$template->set_var($block_locations[$key]['template_variable'], '<p><em>Time: ' . time() . '</em></p>', false, true);
        $template->set_var($block_locations[$key]['template_variable'], COM_showBlocks($block_locations[$key]['id']), false, true); // need to insert as non cache variable
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
                . "WHERE name = '$name' AND is_enabled = 1");
            $A = DB_fetchArray($result);
            if (DB_numRows($result) > 0) {

                switch ($autotag['tag']) {
                case 'block':
                    $px = explode(' ', trim($autotag['parm2']));
                    $css_class = "block-autotag";
                    $css_style = "";

                    if (is_array($px)) {
                        foreach ($px as $part) {
                            if (substr($part, 0, 6) == 'class:') {
                                $a = explode(':', $part);
                                // append a class
                                $css_class .= ' ' . $a[1];
                            } elseif (substr($part, 0, 6) == 'width:') {
                                $a = explode(':', $part);
                                // add width style
                                $css_style = ' style="width:' . $a[1] . '"';
                            } else {
                                break;
                            }
                        }
                    }

                    $retval = COM_formatBlock($A, false, true);

                    // COM_formatBlock could return '' if wrong device, etc...
                    if ($retval != '') {
                        // the class block-autotag will always be included with the div
                        $retval = '<div class="' . $css_class . '"' . $css_style . '>' . $retval . '</div>';
                    }

                    break;
                }

                $content = str_replace($autotag['tagstr'], $retval, $content);
            }
        }
    }

    return $content;
}

/**
 * used for the list of blocks in admin/block.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @param  string $token
 * @return string
 */
function ADMIN_getListField_blocks($fieldName, $fieldValue, $A, $icon_arr, $token)
{
    global $_CONF, $LANG_ADMIN, $LANG21, $_IMAGE_TYPE;

    $retval = false;

    $access = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'],
        $A['perm_group'], $A['perm_members'], $A['perm_anon']
    );

    if (($access > 0) && (TOPIC_hasMultiTopicAccess('block', $A['bid']) > 0)) {
        switch ($fieldName) {
            case 'edit':
                if ($access == 3) {
                    $retval = COM_createLink($icon_arr['edit'],
                        "{$_CONF['site_admin_url']}/block.php?mode=edit&amp;bid={$A['bid']}");
                }
                break;

            case 'title':
                $retval = stripslashes($A['title']);
                if (empty($retval)) {
                    $retval = '(' . $A['name'] . ')';
                }
                break;

            case 'device':
                switch ($A['device']) {
                    case Device::ALL:
                        $retval = $LANG_ADMIN['all'];
                        break;

                    case Device::MOBILE:
                        $retval = $LANG_ADMIN['mobile'];
                        break;

                    case Device::COMPUTER:
                        $retval = $LANG_ADMIN['computer'];
                        break;
                    default:
                        $retval = '';
                        break;
                }
                break;

            case 'onleft':
                switch ($A['onleft']) {
                    case BLOCK_NONE_POSITION: 
                        if ($A['onleft'] == BLOCK_NONE_POSITION && empty($A['location'])) {
                            $retval = $LANG21[47];
                        } else {
                            $block_locations = PLG_getBlockLocations();
                            $key = array_search($A['location'], array_column($block_locations, 'id'));
                            if (is_numeric($key)) {
                                $retval = $block_locations[$key]['name'];
                            } else {
                                // Block Position doesn't exist anymore for some reason so set to none
                                $retval = $LANG21[47];
                            }
                        }
                        break;

                    case BLOCK_LEFT_POSITION:
                        $retval = $LANG21[40];
                        break;

                    case BLOCK_RIGHT_POSITION:
                        $retval = $LANG21[41];
                        break;

                    default:
                        $retval = '';
                        break;
                }
                break;

            case 'blockorder':
                if ($A['onleft'] == BLOCK_NONE_POSITION && empty($A['location'])) {
                    $retval .= '';
                } else {
                    $retval .= $A['blockorder'];
                }
                break;

            case 'is_enabled':
                if ($access == 3) {
                    $tcc = COM_newTemplate($_CONF['path_layout'] . 'controls');
                    $tcc->set_file('common', 'common.thtml');
                    $tcc->set_block('common', 'type-checkbox'); 
                    $tcc->set_var('name', 'enabledblocks[]');
                    $tcc->set_var('value', $A['bid']);
                    if ($A['is_enabled'] == 1) {
                        $tcc->set_var('checked', true);
                    } else {
                        $tcc->clear_var('checked');
                    }
                    $tcc->set_var('onclick', "submit()");
                    $retval = $tcc->finish($tcc->parse('common', 'type-checkbox'));                    
                    $retval .= '<input type="hidden" name="visibleblocks[]" value="' . $A['bid'] . '"' . XHTML . '>';
                }
                break;

            case 'move':
                if ($access == 3) {
                    if ($A['onleft'] != BLOCK_NONE_POSITION) {
                        if ($A['onleft'] == 1) {
                            $side = $LANG21[40];
                            $blockControlImage = 'block-right.' . $_IMAGE_TYPE;
                            $moveTitleMsg = $LANG21[59];
                            $switchSide = '1';
                        } else {
                            $blockControlImage = 'block-left.' . $_IMAGE_TYPE;
                            $moveTitleMsg = $LANG21[60];
                            $switchSide = '0';
                        }
                        $csrfToken = '&amp;' . CSRF_TOKEN . '=' . $token;
                        $retval .= "<img src=\"{$_CONF['layout_url']}/images/admin/$blockControlImage\" width=\"45\" height=\"20\" usemap=\"#arrow{$A['bid']}\" alt=\"\"" . XHTML . ">"
                            . "<map id=\"arrow{$A['bid']}\" name=\"arrow{$A['bid']}\">"
                            . "<area coords=\"0,0,12,20\"  title=\"{$LANG21[58]}\" href=\"{$_CONF['site_admin_url']}/block.php?mode=move&amp;bid={$A['bid']}&amp;where=up{$csrfToken}\" alt=\"{$LANG21[58]}\"" . XHTML . ">"
                            . "<area coords=\"13,0,29,20\" title=\"$moveTitleMsg\" href=\"{$_CONF['site_admin_url']}/block.php?mode=move&amp;bid={$A['bid']}&amp;where=$switchSide{$csrfToken}\" alt=\"$moveTitleMsg\"" . XHTML . ">"
                            . "<area coords=\"30,0,43,20\" title=\"{$LANG21[57]}\" href=\"{$_CONF['site_admin_url']}/block.php?mode=move&amp;bid={$A['bid']}&amp;where=dn${csrfToken}\" alt=\"{$LANG21[57]}\"" . XHTML . ">"
                            . "</map>";
                    }
                }
                break;

            case 'topic':
                $retval = TOPIC_getTopicAdminColumn('block', $A['bid']);
                break;

            case 'type':
                if (in_array($fieldValue, array('gldefault', 'normal', 'phpblock', 'portal', 'dynamic'))) {
                    $retval = $LANG21['block_type_' . $fieldValue];
                } else {
                    $retval = $fieldValue;
                }
                break;

            default:
                $retval = $fieldValue;
                break;
        }
    }

    return $retval;
}

/**
 * used for the list of blocks in admin/block.php
 *
 * @param  string $fieldName
 * @param  string $fieldValue
 * @param  array  $A
 * @param  array  $icon_arr
 * @return string
 */
function ADMIN_getListField_dynamicblocks($fieldName, $fieldValue, $A, $icon_arr)
{
    global $LANG21, $_TABLES;

    switch ($fieldName) {
        case 'onleft':
            switch ($A['onleft']) {
                case BLOCK_NONE_POSITION:
                    if ($A['onleft'] == BLOCK_NONE_POSITION && empty($A['location'])) {
                        $retval = $LANG21[47];
                    } else {
                        $block_locations = PLG_getBlockLocations();
                        $key = array_search($A['location'], array_column($block_locations, 'id'));
                        if (is_numeric($key)) {
                            $retval = $block_locations[$key]['name'];
                        } else {
                            // Block Position doesn't exist anymore for some reason so set to none
                            $retval = $LANG21[47];
                        }
                    }
                    break;

                case BLOCK_LEFT_POSITION:
                    $retval = $LANG21[40];
                    break;

                case BLOCK_RIGHT_POSITION:
                    $retval = $LANG21[41];
                    break;

                default:
                    $retval = '';
                    break;
            }
            break;

        case 'title':
            $retval = stripslashes($A['title']);
            if (empty($retval)) {
                $retval = '(' . $A['name'] . ')';
            }
            break;

        case 'is_enabled':
            if ($A['enable'] == 1) {
                $retval = $LANG21[5]; // Yes
            } else {
                $retval = $LANG21[6]; // No
            }
            break;

        case 'topic':
            if ($A['topic_option'] == TOPIC_ALL_OPTION) {
                $retval = $LANG21[7];
            } elseif ($A['topic_option'] == TOPIC_HOMEONLY_OPTION) {
                $retval = $LANG21[43];
            } else {
                $element_num = count($A['topic']);

                if ($element_num == 0) {
                    $retval = $LANG21[47]; // None
                } elseif ($element_num > 1) {
                    $retval = $LANG21[44]; // Multiple
                } else {
                    $retval = DB_getItem($_TABLES['topics'], 'topic', "tid = '{$A['topic'][0]}'");
                }
            }

            break;

        case 'type':
            if (in_array($fieldValue, array('gldefault', 'normal', 'phpblock', 'portal', 'dynamic'))) {
                $retval = $LANG21['block_type_' . $fieldValue];
            } else {
                $retval = $fieldValue;
            }
            break;

        default:
            $retval = $fieldValue;
            break;
    }

    return $retval;
}
