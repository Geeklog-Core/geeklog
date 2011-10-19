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
      $tree_array[$total_topic]['access'] = 2;  // Read Access
      
      $branch_level = $branch_level + 1;
	}    
	
    if ($_CONF['sortmethod'] != 'alpha') {
        $sql_sort = " ORDER BY sortnum";
    } else {
        $sql_sort = " ORDER BY topic ASC";
    }
	if ($parent) {
		// $sql = "SELECT * FROM {$_TABLES['topics']} WHERE parent_id = '{$id}' " . COM_getPermSQL ('AND') . $sql_sort;
		$sql = "SELECT * FROM {$_TABLES['topics']} WHERE parent_id = '{$id}' " . $sql_sort;
	} else {
		//$sql = "SELECT * FROM {$_TABLES['topics']} WHERE tid = '{$id}' " . COM_getPermSQL ('AND') . $sql_sort;
		$sql = "SELECT * FROM {$_TABLES['topics']} WHERE tid = '{$id}' " . $sql_sort;
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
            $tree_array[$total_topic]['access'] = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']);
            
            // See if this topic has any children
            $tree_array = TOPIC_buildTree($tree_array[$total_topic]['id'], true, $branch_level, $tree_array);
        }
    }
    
    return $tree_array;
}

function TOPIC_getIndex($id)
{
	global $_TOPICS;
	
	$index = 0;
	
	// Find id in $_TOPICS
    $total_topic = count($_TOPICS);
    for ($count_topic = 1; $count_topic <= $total_topic ; $count_topic++) {
        if ($_TOPICS[$count_topic]['id'] == $id) {
            $index = $count_topic;
            break;
        }
    }
    
    return $index;
}

function TOPIC_getChildList($id)
{
	global $_TOPICS;
	
	$retval = '';

    $start_topic = TOPIC_getIndex($id);
    $total_topic = count($_TOPICS);
    
    if ($start_topic > 0) {
        $retval = "'{$_TOPICS[$start_topic]['id']}'";
    
        $min_branch_level = $_TOPICS[$start_topic]['branch_level'];
        $start_topic++;
        $branch_level_skip = 0;
        $lang_id = COM_getLanguageId(); 

        for ($count_topic = $start_topic; $count_topic <= $total_topic ; $count_topic++) {
            if ($branch_level_skip >= $_TOPICS[$count_topic]['branch_level']) {
                $branch_level_skip = 0;
            }        
            
            if ($branch_level_skip == 0) {
                // Make sure to show topics for proper language and access level only
                if ($_TOPICS[$count_topic]['access'] > 0 && (($min_branch_level < $_TOPICS[$count_topic]['branch_level']) && (($lang_id == '') || ($lang_id != '' && ($_TOPICS[$count_topic]['language_id'] == $lang_id || $_TOPICS[$count_topic]['language_id'] == ''))))) {
                    
                    if ($_TOPICS[$count_topic]['inherit'] == 1) {
                        $retval .= ", '" . $_TOPICS[$count_topic]['id'] . "'";
                    } else {
                        // Nothing inherited beyond this point for this branch id
                        $branch_level_skip = $_TOPICS[$count_topic]['branch_level'];
                    }
                } else {
                    // Nothing inherited beyond this point because of language or access beyond passed id
                    $branch_level_skip = $_TOPICS[$count_topic]['branch_level'];
                }
            }
        }
	}
        
	return $retval;
}

/**
* This function creates html options for Inherited and default Topics
*
* @param    string          $type           Type of object to display access for
* @param    string          $id             Id of onject
* @param    string/array    $selected_ids   Topics Ids to mark as selected
* @return   HTML string
*
*/
function TOPIC_getOtherListSelect ($type, $id, $selected_ids = array())
{
    global $_CONF, $LANG27, $_TABLES;

    $retval = '';
    
    if (!is_array($selected_ids)) {
        $selected_ids = array($selected_ids);   
    }    
        
    // Retrieve Topic options
    $sql['mysql'] = "SELECT ta.*, t.topic 
        FROM {$_TABLES['topic_assignments']} ta, {$_TABLES['topics']} t 
        WHERE t.tid = ta.tid AND ta.type = '$type' AND ta.id ='$id'
        ORDER BY t.topic ASC";

    $result = DB_query($sql);
    $B = DB_fetchArray($result);
    $nrows = DB_numRows($result);
    if ($B['tid'] == TOPIC_ALL_OPTION || $B['tid'] == TOPIC_HOMEONLY_OPTION) {
        // Function shouldn't be used in this case
    } else {
        $retval .= '<option value="' . $B['tid'] . '"';
        
        if (in_array($B['tid'], $selected_ids)) {
            $retval .= ' selected="selected"';
        }
        
        $retval .= '>' . $B['topic'] . '</option>';
        
        for ($i = 1; $i < $nrows; $i++) {
            $B = DB_fetchArray($result);
            $retval .= '<option value="' . $B['tid'] . '"';
            
            if (in_array($B['tid'], $selected_ids)) {
                $retval .= ' selected="selected"';
            }
            
            $retval .= '>' . $B['topic'] . '</option>';

        }
    }    

    return $retval;
}

/**
* This function creates html options for Topics, for a single or multi select box
*
* @param    string/array    $selected_ids       Topics Ids to mark as selected
* @param    boolean         $include_root_all   Include Nothing (0) or Root (1) or All (2) in list. 
* @param    string          $remove_id          Id of topic to not include (includes any children) (used for selection of parent id)
* @return   HTML string
*
*/
function TOPIC_getTopicListSelect ($selected_ids = array(), $include_root_all = 1, $language_specific = false, $remove_id = '')
{
    global $_TOPICS, $_TABLES, $LANG21;

    $retval = '';
    
    if (!is_array($selected_ids)) {
        $selected_ids = array($selected_ids);   
    }
    if ($include_root_all > 0) {
        $start_topic = 1;
    } else {
        $start_topic = 2;
    }
    $total_topic = count($_TOPICS);
    $branch_level_skip = 0;
    $lang_id = '';
    if ($language_specific) {
        $lang_id = COM_getLanguageId();
    }

    for ($count_topic = $start_topic; $count_topic <= $total_topic ; $count_topic++) {
        
        if ($count_topic == 1) {
            // Deal with Root or All
            if ($include_root_all == 1) {
                $id =  $_TOPICS[$count_topic]['id'];
                $title =  $_TOPICS[$count_topic]['title'];
                
            } else {
                $id = TOPIC_ALL_OPTION;
                $title = $LANG21[7];
            }
            $retval .= '<option value="' . $id . '"';
            
            if (in_array($id, $selected_ids)) {
                $retval .= ' selected="selected"';
            }
            
            $retval .= '>' . $title . '</option>';
        } else {
            // Check to see if we need to include id (this is done for stuff like topic edits that cannot include themselves or child as parent
            if ($branch_level_skip >= $_TOPICS[$count_topic]['branch_level']) {
                $branch_level_skip = 0;
            }        
    
            if ($branch_level_skip == 0) {
                $id =  $_TOPICS[$count_topic]['id'];
                
                if ($_TOPICS[$count_topic]['access'] > 0 && $id != $remove_id && (($lang_id == '') || ($lang_id != '' && $_TOPICS[$count_topic]['language_id'] == $lang_id))) {
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
function TOPIC_getList($sortcol = 0, $ignorelang = true)
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
* Check for topic access from a list of topics or for an object 
* (need to handle 'all' and 'homeonly' as special cases)
*
* @param    string          $type   Type of object to find topic access about. If 'topic' then will check post array for topic selection control 
* @param    string/array    $id     ID of block or topic to check if block topic access
* @param    boolean         $flag   True if topic id(s)
* @return   int                     returns 3 for read/edit 2 for read only 0 for no access
*
*/
function TOPIC_hasMultiTopicAccess($type, $id = '')
{
    global $_TABLES;
    
    $access = 0;
    
    if ($type == 'topic') {
        // Figure out if user has access to topic list
        $topic_option = TOPIC_ALL_OPTION;
        if (isset ($_POST['topic_option'])) {
            $topic_option = COM_applyFilter($_POST['topic_option']);
        }
        $id = array();
        if (isset ($_POST['tid'])) {
            $id = $_POST['tid']; // to be sanitized later
        }        
        
        if ($topic_option == TOPIC_ALL_OPTION || $topic_option == TOPIC_HOMEONLY_OPTION) {
            $topic_list = $topic_option;
        } else {
            $topic_list = $id;
        }         
        
        if (is_array($topic_list)) {
            $nrows = count($topic_list);
            $tid = $topic_list[0];
        } else {
            $nrows = 1;
            $tid = $topic_list;
        }
    } else {
        // Retrieve Topic options
        $sql = "SELECT tid FROM {$_TABLES['topic_assignments']} WHERE type = '$type' AND id ='$id'";
    
        $result = DB_query($sql);
        $A = DB_fetchArray($result);
        $nrows = DB_numRows($result);
        $tid = $A['tid'];
    }
    if ($tid == TOPIC_ALL_OPTION || $tid == TOPIC_HOMEONLY_OPTION) {
        $access = 3;
    } elseif ($tid == '') { // No topic assigned, Can happen if topic gets deleted
        $access = 3;
    } else {
        $access = SEC_hasTopicAccess ($tid);
        for ($i = 1; $i < $nrows; $i++) {
            if ($type == 'topic') {
                $tid = $id[$i];
            } else {
                $A = DB_fetchArray($result);
                $tid = $A['tid'];
            }
            $current_access = SEC_hasTopicAccess($tid);
            if ($access > $current_access) {
                $access = $current_access;
            }
        }
    }
    
    return $access;
}

/**
* Shows topic control for an object
*
* This will return the HTML needed to create the topic control seen on the
* admin screen for GL objects (i.e. stories, blocks, etc)
*
* @param        string     $type        Type of object to display access for
* @param        string     $id          Id of onject
* @return       string  needed HTML (table) in HTML 
*
*/
function TOPIC_saveTopicSelectionControl ($type, $id)
{
    global $_TABLES;

    
    $topic_options_hide = 1;
    if (isset ($_POST['topic_options_hide'])) {
        $topic_options_hide = COM_applyFilter($_POST['topic_options_hide'], true);
    }
    $topic_option = TOPIC_ALL_OPTION;
    if (isset ($_POST['topic_option'])) {
        $topic_option = COM_applyFilter($_POST['topic_option']);
    }
    $tid = array();
    if (isset ($_POST['tid'])) {
        $tid = $_POST['tid']; // to be sanitized later
    }
    
    $topic_inherit_hide = 1;
    if (isset ($_POST['topic_inherit_hide'])) {
        $topic_inherit_hide = COM_applyFilter($_POST['topic_inherit_hide'], true);
    }
    $inherit_tid = array();
    if (isset ($_POST['inherit_tid'])) {
        $inherit_tid = $_POST['inherit_tid']; // to be sanitized later
    }
    
    $topic_default_hide = 1;
    if (isset ($_POST['topic_default_hide'])) {
        $topic_default_hide = COM_applyFilter($_POST['topic_default_hide'], true);
    }
    $default_tid = '';
    if (isset ($_POST['default_tid'])) {
        $default_tid = COM_applyFilter($_POST['default_tid']);
    }
    
    // Save Topic Assignments
    DB_delete($_TABLES['topic_assignments'], array('type', 'id'), array($type, $id));
    if (is_array($tid) && $topic_option == TOPIC_SELECTED_OPTION) {
        foreach ($tid as $value) {
            $value = COM_applyFilter($value);
            
            if ($topic_inherit_hide) {
                $inherit = 1;
            } else {
                if (in_array($value, $inherit_tid)) {
                    $inherit = 1;
                } else {
                    $inherit = 0;
                }
            }

            if ($topic_default_hide) {
                $default = 0;
            } else {
                if ($value == $default_tid) {
                    $default = 1;
                } else {
                    $default = 0;
                }
            }
            
            DB_save ($_TABLES['topic_assignments'], 'tid,type,id,inherit,tdefault', "'$value', '$type', '$id', $inherit, $default");
        }
    } else {
        if ($topic_option == TOPIC_ALL_OPTION || $topic_option == TOPIC_HOMEONLY_OPTION) {
            DB_save ($_TABLES['topic_assignments'], 'tid,type,id,inherit,tdefault', "'$topic_option', '$type', '$id', 0 , 0");
        }
    }      
    
}
/**
* Shows topic control for an object
*
* This will return the HTML needed to create the topic control seen on the
* admin screen for GL objects (i.e. stories, blocks, etc)
*
* @param        string     $type            Type of object to display access for
* @param        string     $id              Id of onject
* @param        boolean    $show_options    True/False. If true then All and Homepage options will be visible
* @param        boolean    $show_inherit    True/False. If true then inhert selection will be enabled
* @param        boolean    $show_default    True/False. If true then default topic selection will be enabled
* @return       string  needed HTML (table) in HTML 
*
*/
function TOPIC_getTopicSelectionControl ($type, $id, $show_options = false, $show_inherit = false, $show_default = false)
{
    global $_CONF, $LANG27, $_TABLES;
    
    $tid = array();
    $inherit = array();
    $default = '';
    
    // Retrieve Topic options
    $sql['mysql'] = "SELECT * FROM {$_TABLES['topic_assignments']} WHERE type = '$type' AND id ='$id'";

    $result = DB_query($sql);
    $B = DB_fetchArray($result);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        if ($B['tid'] == TOPIC_ALL_OPTION || $B['tid'] == TOPIC_HOMEONLY_OPTION) {
            $topic_option = $B['tid'];
            $A['tid'] ='';
        } else {
            $topic_option = TOPIC_SELECTED_OPTION;
            $tid = array();
            $tid[] = $B['tid'];
            if ($B['inherit'] == 1) {
                $inherit[] = $B['tid'];
            }
            if ($B['tdefault'] == 1) {
                $default = $B['tid'];
            }        
            for ($i = 1; $i < $nrows; $i++) {
                $B = DB_fetchArray($result);
                $tid[] = $B['tid'];
                if ($B['inherit'] == 1) {
                    $inherit[] = $B['tid'];
                }
                if ($B['tdefault'] == 1) {
                    $default = $B['tid'];
                }
            }
        }
    } else {
     $show_inherit = false;
     $show_default = false;
    }

    $retval = '';
    $topic_info = $LANG27[40];

    $topic_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/common');
    $topic_templates->set_file(array('editor' => 'edit_topics.thtml'));
    
    if ($show_options) {
        $topic_templates->set_var('lang_all', $LANG27[38]);
        $topic_templates->set_var('lang_homeonly', $LANG27[39]);        
        $topic_templates->set_var('topic_options_hide', '0');
        $topic_info = $LANG27[41];
        if ($topic_option == TOPIC_ALL_OPTION) {
            $topic_templates->set_var('all_checked', 'checked');
            $topic_templates->set_var('homeonly_checked', '');
            $topic_templates->set_var('selectedtopics_checked', '');
            
            $show_inherit = false;
            $show_default = false;            
        } elseif ($topic_option == TOPIC_HOMEONLY_OPTION) {
            $topic_templates->set_var('all_checked', '');
            $topic_templates->set_var('homeonly_checked', 'checked');
            $topic_templates->set_var('selectedtopics_checked', '');

            $show_inherit = false;
            $show_default = false;            
        } else{
            $topic_templates->set_var('all_checked', '');
            $topic_templates->set_var('homeonly_checked', '');
            $topic_templates->set_var('selectedtopics_checked', 'checked');
        }
    } else {
        $topic_templates->set_var('options_hide', 'display: none;');
        $topic_templates->set_var('topic_options_hide', '1');
    }
    
    $topic_templates->set_var('topic_options', TOPIC_getTopicListSelect($tid, false));
    
    if ($show_inherit) {
        $topic_templates->set_var('lang_inherit', $LANG27[44]);
        $topic_templates->set_var('topic_inherit_hide', '0');
        $topic_info .= $LANG27[42];
        $topic_templates->set_var('inherit_options', TOPIC_getOtherListSelect($type, $id, $inherit));
    } else {
        $topic_templates->set_var('inherit_hide', 'display: none;');
        $topic_templates->set_var('topic_inherit_hide', '1');
    }
    
    if ($show_default) {
        $topic_templates->set_var('lang_default', $LANG27[45]);
        $topic_templates->set_var('topic_default_hide', '0');
        $topic_info .= $LANG27[43];
        $topic_templates->set_var('inherit_options', TOPIC_getOtherListSelect($type, $id, $default));
    } else {
        $topic_templates->set_var('default_hide', 'display: none;');
        $topic_templates->set_var('topic_default_hide', '1');
    }

    $topic_templates->set_var('topic_info', $topic_info);
    
    $topic_templates->parse('output', 'editor');
    $retval .= $topic_templates->finish($topic_templates->get_var('output'));

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