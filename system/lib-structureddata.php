<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-structureddata.php                                                    |
// |                                                                           |
// | Geeklog structured data library.                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2019 by the following authors:                         |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// set to true to enable debug output in error.log
$_STRUCTUREDDATA_DEBUG = COM_isEnableDeveloperModeLog('structureddata');

/**
 * Implements the [structureddata:] autotag.
 *
 * @param    string $op      operation to perform
 * @param    string $content item (e.g. topic text), including the autotag
 * @param    array  $autotag parameters used in the autotag
 * @param           mixed               tag names (for $op='tagname') or formatted content
 */

function plugin_autotags_structureddata($op, $content = '', $autotag = '', $parameters = array())
{
    global $_CONF, $_TABLES, $LANG_STRUCT_DATA, $_GROUPS, $_STRUCT_DATA;
    if ($op == 'tagname') {
        return array('structureddata');
    } elseif (($op == 'permission') || ($op == 'nopermission')) {
        if ($op == 'permission') {
            $flag = true;
            $tagnames[] = 'structureddata';
        } else {
            $flag = false;
        }
        $tagnames = array();

        /*
        if (isset($_GROUPS['Topic Admin'])) {
            $group_id = $_GROUPS['Topic Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Topic Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();

        if (COM_getPermTag($owner_id, $group_id, $_CONF['autotag_permissions_topic'][0], $_CONF['autotag_permissions_topic'][1], $_CONF['autotag_permissions_topic'][2], $_CONF['autotag_permissions_topic'][3]) == $flag) {
            $tagnames[] = 'topic';
        }

        if (COM_getPermTag($owner_id, $group_id, $_CONF['autotag_permissions_related_topics'][0], $_CONF['autotag_permissions_related_topics'][1], $_CONF['autotag_permissions_related_topics'][2], $_CONF['autotag_permissions_related_topics'][3]) == $flag) {
            $tagnames[] = 'related_topics';
        }

        if (COM_getPermTag($owner_id, $group_id, $_CONF['autotag_permissions_related_items'][0], $_CONF['autotag_permissions_related_items'][1], $_CONF['autotag_permissions_related_items'][2], $_CONF['autotag_permissions_related_items'][3]) == $flag) {
            $tagnames[] = 'related_items';
        }
        */
        //$tagnames[] = 'structureddata';

        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'closetag') {
        return array(
            'structureddata'
        );        
    } elseif ($op == 'description') {
        return array(
            'structureddata'          => $LANG_STRUCT_DATA['autotag_desc_structureddata']
        );
    } elseif ($op == 'parse') {
        if ($autotag['tag'] != 'structureddata') {
            return $content;
        }

        if ($autotag['tag'] == 'structureddata') {
            $p1 = COM_applyFilter($autotag['parm1']);
            
            // [structureddata:id parameter:description]This is what the description parameter will be set too.[/structureddata]
            $p2 = explode(' ', trim($autotag['parm2']));
            $parameter = '';

            // Always need parm3 (autotag with a close tag)
            if (isset($autotag['parm3'])) {
                $p3 = $autotag['parm3'];
                
                $type = "";
                $width = "";
                $height = "";
                
                if (is_array($p2)) {
                    foreach ($p2 as $part) {
                        if (substr($part, 0, 10) == 'parameter:') {
                            $a = explode(':', $part);
                            $parameter = $a[1];
                        } elseif (substr($part, 0, 5) == 'type:') {
                            $a = explode(':', $part);
                            $type = $a[1];                        
                        } elseif (substr($part, 0, 6) == 'width:') {
                            $a = explode(':', $part);
                            $width = (int)$a[1];
                        } elseif (substr($part, 0, 7) == 'height:') {
                            $a = explode(':', $part);
                            $height = (int)$a[1];                        
                        } else {
                            break;
                        }
                    }
                }

                // Figure out content type and id (depends on how autotag is used)
                
                // If type is missing then assume type and id are passed via function. p1 then would be parameter
                // If type is passed via autotag then assume p1 is id
                if (empty($type)) {
                    $parameter = $p1;
                    if (isset($parameters['type']) && isset($parameters['id'])) {
                        $type = $parameters['type'];
                        $id = $parameters['id'];
                    }
                } else {
                    $id = $p1;
                }
                
                if (!empty($type) && !empty($id)) {
                    switch (strtolower($parameter)) {
                        case 'author':
                            $_STRUCT_DATA->set_author_item($type, $id, $p3);
                            
                            break;
                        case 'image':
                            $_STRUCT_DATA->set_image_item($type, $id, $p3, $width, $height);
                            
                            break;
                        default:
                            // assume standard
                            $_STRUCT_DATA->set_param_item($type, $id, $parameter, $p3);
                            
                            break;
                    }
                }
            }
        }
        
        // Replace autotag with empty string
        $content = str_replace($autotag['tagstr'], '', $content);

        return $content;
    }
}

