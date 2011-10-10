<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.9.0                                                             |
// +---------------------------------------------------------------------------+
// | lib-topic.php                                                             |
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

if (strpos(strtolower($_SERVER['PHP_SELF']), 'lib-topic.php') !== false) {
    die('This file can not be used on its own!');
}

// set to true to enable debug output in error.log
$_TOPIC_DEBUG = false;

define("TOPIC_ALL_OPTION", 'all');
define("TOPIC_HOMEONLY_OPTION", 'homeonly');
define("TOPIC_SELECTED_OPTION", 'selectedtopics');
define("TOPIC_ROOT", 'root');









function TOPIC_buildTree($id, $parent = '', $branch_level = -1, $tree_array = array())
{
	global $_TABLES, $_CONF, $LANG27;
	
	$branch_level = $branch_level + 1;
	
	$total_topic = count($tree_array) + 1;
	
	if ($id == TOPIC_ROOT) { // Root
      $tree_array[$total_topic]['id'] = TOPIC_ROOT;
      $tree_array[$total_topic]['parent_id'] = '';
      $tree_array[$total_topic]['branch_level'] = $branch_level;
      $tree_array[$total_topic]['title'] = $LANG27[37];
      $tree_array[$total_topic]['language_id'] = '';
      $tree_array[$total_topic]['inherit'] = 1;
      $tree_array[$total_topic]['hidden'] = 0;	
      
      $branch_level = $branch_level + 1;
	}    
	
    if ($_CONF['sortmethod'] != 'alpha') {
        $sql_sort = " ORDER BY sortnum";
    } else {
        $sql_sort = " ORDER BY topic ASC";
    }
	if ($parent) {
		$sql = "SELECT * FROM {$_TABLES['topics']} WHERE parent_id = '{$id}' " . $sql_lang . COM_getPermSQL ('AND') . $sql_sort;
	} else {
		$sql = "SELECT * FROM {$_TABLES['topics']} WHERE tid = '{$id}' " . $sql_lang . COM_getPermSQL ('AND') . $sql_sort;
	}

	$result = DB_query ($sql);
    $nrows  = DB_numRows ($result);
    if ($nrows > 0) {
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray ($result);
            $total_topic = count($tree_array)+ 1;
            
            $tree_array[$total_topic]['id'] = $A['tid'];
            $tree_array[$total_topic]['parent_id'] = $A['parent_id'];
            $tree_array[$total_topic]['branch_level'] = $branch_level;
            $tree_array[$total_topic]['title'] = stripslashes($A['topic']);
            $tree_array[$total_topic]['language_id'] = COM_getLanguageIdForObject($A['tid']); // figure out language if need be
            $tree_array[$total_topic]['inherit'] = $A['inherit'];
            $tree_array[$total_topic]['hidden'] = $A['hidden'];    
            
            // See if this topic has any children
            $tree_array = TOPIC_buildTree($tree_array[$total_topic]['id'], true, $branch_level, $tree_array);
        }
    }
    
    return $tree_array;
}

/**
* This function creates a html options for Topics, for a single or multi select box
*
* @param    string/array    $selected_ids   Topics Ids to mark as selected
* @param    boolean         $include_root   Include Root in list
* @param    string          $remove_id      Id of topic to not include (includes any children)
* @return   HTML string
*
*/
function TOPIC_getListSelect ($selected_ids = array(), $include_root = true, $remove_id = '')
{
    global $_TOPICS, $_TABLES, $LANG_CAT;

    $retval = '';
    
    if (!is_array($selected_ids)) {
        $selected_ids = array($selected_ids);   
    }
    if ($include_root) {
        $start_topic = 1;
    } else {
        $start_topic = 2;
    }
    $total_topic = count($_TOPICS);
    $branch_level_skip = 0;

    for ($count_topic = $start_topic; $count_topic <= $total_topic ; $count_topic++) {

        // Check to see if we need to include id (this is done for stuff like topic edits that cannot include themselves or child as parent
        if ($branch_level_skip >= $_TOPICS[$count_topic]['branch_level']) {
            $branch_level_skip = 0;
        }        

        if ($branch_level_skip == 0) {
            $id =  $_TOPICS[$count_topic]['id'];
            
            if ($id != $remove_id) {
                $title =  $_TOPICS[$count_topic]['title'];
                
                $branch_spaces = "";
                for ($branch_count = $start_topic; $branch_count <= $_TOPICS[$count_topic]['branch_level'] ; $branch_count++) {
                    $branch_spaces .= "&nbsp;&nbsp;&nbsp;";
                }
                
                $retval .= '<option value="' . $id . '"';
                
                if (in_array($id, $selected_ids)) {
                    $retval .= ' selected="selected"';
                }
                
                $retval .= '>' . $branch_spaces . $title . '</option>';
            } else {
                // Cannot pick child as parent so skip
                $branch_level_skip = $_TOPICS[$count_topic]['branch_level'];            
            }
        }
    }    
    
    return $retval;
}

/**
* Return a list of topics in an array
*
* @param    int     $sortcol    Which field to sort option list by 0 (value) or 1 (label)
* @param    boolean $ignorelang Whether to return all topics (true) or only the ones for the current language (false)
* @return   array               Array of topics
*
*/
function TOPIC_getList($sortcol = 0, $ignorelang = false)
{
    global $_TABLES;

    $retval = array();
    
    $selection = 'tid, topic';
    $id = 'tid';
    $table = $_TABLES['topics'];
        
    $tmp = str_replace('DISTINCT ', '', $selection);
    $select_set = explode(',', $tmp);

    $sql = "SELECT $selection FROM $table";
    if ($ignorelang) {
        $sql .= COM_getPermSQL();
    } else {
        $permsql = COM_getPermSQL();
        if (empty($permsql)) {
            $sql .= COM_getLangSQL($id);
        } else {
            $sql .= $permsql . COM_getLangSQL($id, 'AND');
        }
    }
    $sql .=  " ORDER BY $select_set[$sortcol]";

    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if (count($select_set) > 1) {
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result, true);
            $retval[$A[0]] = stripslashes($A[1]);
        }
    } else {
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result, true);
            $retval[] = $A[0];
        }
    }

    return $retval;
}

/**
* This function is called to inform plugins when a group's information has
* changed or a new group has been created.
*
* @param    int     $grp_id     Group ID
* @param    string  $mode       type of change: 'new', 'edit', or 'delete'
* @return   void
*
*/
function plugin_group_changed_topic($grp_id, $mode)
{
    global $_TABLES, $_GROUPS;
    
    if ($mode == 'delete') {
        // Change any deleted group ids to Topic Admin if exist, if does not change to root group
        $new_group_id = 0;
        if (isset($_GROUPS['Topic Admin'])) {
            $new_group_id = $_GROUPS['Topic Admin'];
        } else {
            $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Topic Admin'");
            if ($new_group_id == 0) {
                if (isset($_GROUPS['Root'])) {
                    $new_group_id = $_GROUPS['Root'];
                } else {
                    $new_group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Root'");
                }
            }
        }    
        
        // Update Topic with new group id
        $sql = "UPDATE {$_TABLES['topics']} SET group_id = $new_group_id WHERE group_id = $grp_id";        
        $result = DB_query($sql);
   }
}

?>