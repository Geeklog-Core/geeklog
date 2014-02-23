<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.9.0                                                             |
// +---------------------------------------------------------------------------+
// | lib-topic.php                                                             |
// |                                                                           |
// | Geeklog syndication library.                                              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2011 by the following authors:                         |
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

// These constants are used by topic assignments table and when the user selects 
// a topic option. 
// The global variable $topic should never be one of these. It should be set to
// either a topic id the user has access to or empty (which means all topics).
define("TOPIC_ALL_OPTION", 'all'); 
define("TOPIC_NONE_OPTION", 'none');
define("TOPIC_HOMEONLY_OPTION", 'homeonly');
define("TOPIC_SELECTED_OPTION", 'selectedtopics');
define("TOPIC_ROOT", 'root');

/**
* Return the topic tree structure in an array.
*

id              ID of topic
parent_id       ID of parent topic
branch_level    Level of branch in tree structure
title           Title of topic
language_id     Language of topic
inherit         If topic inherits objects from child topics 
hidden          If topic is hidden
exclude         If topic is in current users exclude list (1), (0) if not in list
access          Access current user has with topic 
owner_id        ID of the owner of the topic
group_id        ID of group topic belongs to
perm_owner      Permissions the owner has
perm_group      Permissions the group has
perm_members    Permissions logged in members have
perm_anon       Permissions anonymous users have

*
* @return       array      
*
*/

function TOPIC_buildTree($id, $parent = '', $branch_level = -1, $tree_array = array())
{
	global $_TABLES, $_CONF, $_USER, $LANG27;
	
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
        $tree_array[$total_topic]['exclude'] = 0;
        $tree_array[$total_topic]['access'] = 2;  // Read Access 
        $tree_array[$total_topic]['owner_id'] = SEC_getDefaultRootUser();
        $tree_array[$total_topic]['group_id'] = 1;
        $tree_array[$total_topic]['perm_owner'] = 2;
        $tree_array[$total_topic]['perm_group'] = 2;
        $tree_array[$total_topic]['perm_members'] = 2;
        $tree_array[$total_topic]['perm_anon'] = 2;
      
      $branch_level = $branch_level + 1;
	}    
	
    if ($_CONF['sortmethod'] != 'alpha') {
        $sql_sort = " ORDER BY sortnum";
    } else {
        $sql_sort = " ORDER BY topic ASC";
    }
	if ($parent) {
		$sql = "SELECT * FROM {$_TABLES['topics']} WHERE parent_id = '{$id}' " . $sql_sort;
	} else {
		$sql = "SELECT * FROM {$_TABLES['topics']} WHERE tid = '{$id}' " . $sql_sort;
	}

	$result = DB_query ($sql);
    $nrows  = DB_numRows ($result);
    if ($nrows > 0) {
        // Figure out if any excluded topics
        $excluded_tids = '';
        if (!COM_isAnonUser()) { 
            $excluded_tids = DB_getItem($_TABLES['userindex'], 'tids', "uid = '{$_USER['uid']}'");
            if (!empty($excluded_tids)) { 
                $excluded_tids = "'" . str_replace( ' ', "','", $excluded_tids) . "'";
            }
        }
        
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
            $tree_array[$total_topic]['exclude'] = 0;
            if (!empty($excluded_tids)) {
                if (MBYTE_strpos($excluded_tids, $A['tid']) !== false) {
                    $tree_array[$total_topic]['exclude'] = 1;
                }
            }
            $tree_array[$total_topic]['access'] = SEC_hasAccess($A['owner_id'], $A['group_id'], $A['perm_owner'], $A['perm_group'], $A['perm_members'], $A['perm_anon']); // Current User Access
            $tree_array[$total_topic]['owner_id'] = $A['owner_id'];
            $tree_array[$total_topic]['group_id'] = $A['group_id'];
            $tree_array[$total_topic]['perm_owner'] = $A['perm_owner'];
            $tree_array[$total_topic]['perm_group'] = $A['perm_group'];
            $tree_array[$total_topic]['perm_members'] = $A['perm_members'];
            $tree_array[$total_topic]['perm_anon'] = $A['perm_anon'];
            
            
            // See if this topic has any children
            $tree_array = TOPIC_buildTree($tree_array[$total_topic]['id'], true, $branch_level, $tree_array);
        }
    }
    
    return $tree_array;
}

/**
* Return the index of a topic in the TOPICS array that matches the topic id
*
* @param        string      $id      The id of the topic to find the index for
* @return       int      
*
*/
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

/**
* Return a list of child topic ids that the user has access to. 
* Includes the parent topic in the list as well.
*
* @param        string      $id      The id of the parent topic
* @param        int         $uid     user id or 0 = current user
* @return       string      
*
*/
function TOPIC_getChildList($id, $uid = 0)
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
                // Figure out acces to topic 
                if ($uid == 0) {// Current User
                    $specified_user_access = $_TOPICS[$count_topic]['access'];
                } else {
                    $specified_user_access = SEC_hasAccess($_TOPICS[$count_topic]['owner_id'], $_TOPICS[$count_topic]['group_id'], $_TOPICS[$count_topic]['perm_owner'], $_TOPICS[$count_topic]['perm_group'], $_TOPICS[$count_topic]['perm_members'], $_TOPICS[$count_topic]['perm_anon'], $uid);
                }
                
                // Make sure to show topics for proper language and access level only
                if ($specified_user_access > 0 && (($min_branch_level < $_TOPICS[$count_topic]['branch_level']) && (($lang_id == '') || ($lang_id != '' && ($_TOPICS[$count_topic]['language_id'] == $lang_id || $_TOPICS[$count_topic]['language_id'] == ''))))) {
                    
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
* @param    string/array    $tids           Topics Ids to use instead of retrieving from db
* @return   HTML string
*
*/
function TOPIC_getOtherListSelect($type, $id, $selected_ids = array(), $tids = array())
{
    global $_CONF, $LANG27, $_TABLES;

    $retval = '';
    
    if (!is_array($selected_ids)) {
        $selected_ids = array($selected_ids);   
    }

    if (!is_array($tids)) {
        $tids = array($tids);   
    }  
    
    // if topic ids not passed then retrieve from db
    $from_db = false;
    if (empty($tids)) {
        $from_db = true;
    }
        
    
    if ($from_db) {
        // Retrieve Topic options
        $sql = "SELECT ta.tid, t.topic 
            FROM {$_TABLES['topic_assignments']} ta, {$_TABLES['topics']} t 
            WHERE t.tid = ta.tid AND ta.type = '$type' AND ta.id ='$id'
            ORDER BY t.topic ASC";
    } else {
        $sql = "SELECT tid, topic 
            FROM {$_TABLES['topics']}  
            WHERE (tid IN ('" . implode( "','", $tids ) . "')) 
            ORDER BY topic ASC";
    }
    
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
* Creates a <input> checklist for topics
*
* Creates a group of checkbox form fields with given arguments
*
* @param    string          $selected_ids       Value to set to CHECKED
* @param    string          $fieldname          Name to use for the checkbox array
* @param    boolean         $language_specific  If false include all topics for every language
* @param    boolean         $remove_archive     Remove archive topic from list if any
* @return   string                              HTML with Checkbox code
*
*/
function TOPIC_checkList($selected_ids = '', $fieldname = '', $language_specific = false, $remove_archive = false)
{
    global $_TOPICS;

    $retval = '<ul class="checkboxes-list">' . LB;

    if (!empty($selected_ids)) {
        $selected_ids = explode( ' ', $selected_ids );
    } else {
        $selected_ids = array();
    }

    $start_topic = 2;
    $total_topic = count($_TOPICS);
    $branch_level_skip = 0;
    $lang_id = '';
    if ($language_specific) {
        $lang_id = COM_getLanguageId();
    }
    
    // Retrieve Archive Topic if any
    $archive_tid = '';
    if ($remove_archive) {
        $archive_tid = DB_getItem($_TABLES['topics'], 'tid', 'archive_flag = 1');
    }

    for ($count_topic = $start_topic; $count_topic <= $total_topic ; $count_topic++) {
        // Check to see if we need to include id (this is done for stuff like topic edits that cannot include themselves or child as parent
        if ($branch_level_skip >= $_TOPICS[$count_topic]['branch_level']) {
            $branch_level_skip = 0;
        }        

        if ($branch_level_skip == 0) {
            $id =  $_TOPICS[$count_topic]['id'];
            
            // Make sure to show topics for proper language and access level only
            if ($archive_tid != $id && $_TOPICS[$count_topic]['access'] > 0 && (($lang_id == '') || ($lang_id != '' && $_TOPICS[$count_topic]['language_id'] == $lang_id))) {
                $title =  $_TOPICS[$count_topic]['title'];
                $retval .= '<li>'
                        .  str_repeat(
                                '&nbsp;&nbsp;&nbsp;',
                                $_TOPICS[$count_topic]['branch_level'] - $start_topic + 1
                           )
                        .  '<input type="checkbox" id="id-' . $id . '" name="'
                        .  $fieldname . '[]" value="' . $id . '"';

                if (in_array($id, $selected_ids)) {
                    $retval .= ' checked="checked"';
                }

                $retval .= XHTML . '><label for="id-' . $id . '">' . $title . '</label></li>' . LB;
            } else {
                // Cannot pick child as parent so skip
                $branch_level_skip = $_TOPICS[$count_topic]['branch_level'];            
            }
        }
    }

    $retval .= '</ul>' . LB;

    return $retval;
}

/**
* This function creates html options for Topics, for a single or multi select box
*
* @param    string/array    $selected_ids       Topics Ids to mark as selected
* @param    int             $include_root_all   Include Nothing (0) or Root (1) or All (2) or None (4) in list.
* @param    boolean         $language_specific  If false include all topics for every language
* @param    string          $remove_id          Id of topic to not include (includes any children) (used for selection of parent id)
* @param    boolean         $remove_archive     Remove archive topic from list if any
* @param    int             $uid                User id or 0 = current user
* @return   HTML string
*
*/
function TOPIC_getTopicListSelect($selected_ids = array(), $include_root_all = 1, $language_specific = false, $remove_id = '', $remove_archive = false, $uid = 0)
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
    
    // Retrieve Archive Topic if any
    $archive_tid = '';
    if ($remove_archive) {
        $archive_tid = DB_getItem($_TABLES['topics'], 'tid', 'archive_flag = 1');
    }

    for ($count_topic = $start_topic; $count_topic <= $total_topic ; $count_topic++) {
        
        if ($count_topic == 1) {
            // Deal with Root or All and None
            if ($include_root_all == 1) {
                $id =  $_TOPICS[$count_topic]['id'];
                $title =  $_TOPICS[$count_topic]['title'];
                
                $retval .= '<option value="' . $id . '"';
                $retval .= ' title="' . $title . '"';
                if (in_array($id, $selected_ids)) {
                    $retval .= ' selected="selected"';
                }
                $retval .= '>' . $title . '</option>';                
            } else {
                // Check for None
                if ($include_root_all == 4 || $include_root_all == 6) {
                    $id = TOPIC_NONE_OPTION;
                    $title = $LANG21[47];
                    
                    $retval .= '<option value="' . $id . '"';
                    $retval .= ' title="' . $title . '"';
                    if (in_array($id, $selected_ids)) {
                        $retval .= ' selected="selected"';
                    }
                    $retval .= '>' . $title . '</option>';
                }                 
                // Check for All
                if ($include_root_all == 2 || $include_root_all == 6) {
                    $id = TOPIC_ALL_OPTION;
                    $title = $LANG21[7];
                    
                    $retval .= '<option value="' . $id . '"';
                    $retval .= ' title="' . $title . '"';
                    if (in_array($id, $selected_ids)) {
                        $retval .= ' selected="selected"';
                    }
                    $retval .= '>' . $title . '</option>';
                }
            }
        } else {
            // Check to see if we need to include id (this is done for stuff like topic edits that cannot include themselves or child as parent
            if ($branch_level_skip >= $_TOPICS[$count_topic]['branch_level']) {
                $branch_level_skip = 0;
            }        
    
            if ($branch_level_skip == 0) {
                $id =  $_TOPICS[$count_topic]['id'];
                
                if ($uid == 0) {// Current User
                    $specified_user_access = $_TOPICS[$count_topic]['access'];
                } else {
                    $specified_user_access = SEC_hasAccess($_TOPICS[$count_topic]['owner_id'], $_TOPICS[$count_topic]['group_id'], $_TOPICS[$count_topic]['perm_owner'], $_TOPICS[$count_topic]['perm_group'], $_TOPICS[$count_topic]['perm_members'], $_TOPICS[$count_topic]['perm_anon'], $uid);
                }
                
                // Make sure to show topics for proper language and access level only
                if ($archive_tid != $id && $specified_user_access > 0 && $id != $remove_id && (($lang_id == '') || ($lang_id != '' && ($_TOPICS[$count_topic]['language_id'] == $lang_id || $_TOPICS[$count_topic]['language_id'] == '')))) {
                    $title =  $_TOPICS[$count_topic]['title'];
                    
                    $branch_spaces = "";
                    for ($branch_count = $start_topic; $branch_count <= $_TOPICS[$count_topic]['branch_level'] ; $branch_count++) {
                        $branch_spaces .= "&nbsp;&nbsp;&nbsp;";
                    }
                    
                    $retval .= '<option value="' . $id . '"';
                    $retval .= ' title="' . $title . '"';
                    
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
* @param    boolean $title      Return topic ids as well as topic titles
* @return   array               Array of topics
*
*/
function TOPIC_getList($sortcol = 0, $ignorelang = true, $title = true)
{
    global $_TABLES;

    $retval = array();
    
    if ($title) {
        $selection = 'tid, topic';
    } else {
      $selection = 'tid';  
    }
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
* If multiple topics then will return the lowest access level found
* (need to handle 'all' and 'homeonly' as special cases)
*
* @param    string          $type   Type of object to find topic access about. If 'topic' then will check post array for topic selection control 
* @param    string/array    $id     ID of object to check topic access for (not requried if $type is 'topic')
* @param    string/array    $tid    ID of topic to check topic access for (not requried and not used if $type is 'topic')
* @return   int                     returns 3 for read/edit 2 for read only 0 for no access
*
*/
function TOPIC_hasMultiTopicAccess($type, $id = '', $tid = '')
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
            if ($nrows > 0) {
                $tid = $topic_list[0];
            } else {
                $tid = '';
            }
        } else {
            $nrows = 1;
            $tid = $topic_list;
        }
    } else {
        // Retrieve Topic options
        $sql = "SELECT tid FROM {$_TABLES['topic_assignments']} WHERE type = '$type' AND id ='$id'";
        if ($tid != '') {
            $sql .=  " AND tid = '$tid'";
        }
        
        $result = DB_query($sql);
        $A = DB_fetchArray($result);
        $nrows = DB_numRows($result);
        $tid = $A['tid'];
    }
    if ($tid == TOPIC_ALL_OPTION || $tid == TOPIC_HOMEONLY_OPTION) {
        $access = 3;
    } elseif ($tid == '') { // No topic assigned, should not happen
        $access = 0;
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
* Check topic control has selections made
*
* This will return true for selection or false for no selections
*
* @return       boolean  true if selection made
*
*/
function TOPIC_checkTopicSelectionControl()
{
    global $_TABLES;

    $topic_options_hide = 0;
    if (isset ($_POST['topic_options_hide'])) {
        $topic_options_hide = COM_applyFilter($_POST['topic_options_hide'], true);
    }
    if (!$topic_options_hide) {
        $topic_option = TOPIC_ALL_OPTION;
        if (isset ($_POST['topic_option'])) {
            $topic_option = COM_applyFilter($_POST['topic_option']);
        }
    } else {
        $topic_option = TOPIC_SELECTED_OPTION;
    }
    
    $tid = array();
    if (isset ($_POST['tid'])) {
        $tid = $_POST['tid']; // to be sanitized later
    }
    
    // Save Topic Assignments
    if (is_array($tid) && $topic_option == TOPIC_SELECTED_OPTION && !empty($tid)) {
        
    } else {
        if ($topic_option == TOPIC_ALL_OPTION || $topic_option == TOPIC_HOMEONLY_OPTION) {
        } else {
            return false;
        }
    }
    
    return true;        
}
/**
* Saves topic control to db for an object
*
* This will save the selections from the topic control seen on the
* admin screen for GL objects (i.e. stories, blocks, etc)
*
* @param        string     $type        Type of object to display access for
* @param        string     $id          Id of object
* @return       boolean  true if successful else false 
*
*/
function TOPIC_saveTopicSelectionControl($type, $id)
{
    global $_TABLES;

    // Retrieve Archive Topic if any
    $archive_tid = DB_getItem($_TABLES['topics'], 'tid', 'archive_flag = 1');
    
    TOPIC_getDataTopicSelectionControl($topic_option, $tids, $inherit_tids, $default_tid);

    $topic_inherit_hide = 1;
    if (isset ($_POST['topic_inherit_hide'])) {
        $topic_inherit_hide = COM_applyFilter($_POST['topic_inherit_hide'], true);
    }

    $topic_default_hide = 1;
    if (isset ($_POST['topic_default_hide'])) {
        $topic_default_hide = COM_applyFilter($_POST['topic_default_hide'], true);
    }
    
    
    // Save Topic Assignments
    if (is_array($tids) && $topic_option == TOPIC_SELECTED_OPTION && !empty($tids)) {
        DB_delete($_TABLES['topic_assignments'], array('type', 'id'), array($type, $id));
    
        // Check if archive topic selected, if so then archive
        if (in_array($archive_tid, $tids)) {
            DB_save ($_TABLES['topic_assignments'], 'tid,type,id,inherit,tdefault', "'$archive_tid', '$type', '$id', 0 , 1");
        } else {  
            // Check if default in tid array, if not then set first topic as default
             if (!in_array($default_tid, $tids)) {
                 $default_tid = $tids[0];
             }
            $set_default = false;
            foreach ($tids as $value) {
                $value = COM_applyFilter($value);
                
                if ($topic_inherit_hide) {
                    $inherit = 1;
                } else {
                    if (in_array($value, $inherit_tids)) {
                        $inherit = 1;
                    } else {
                        $inherit = 0;
                    }
                }
    
                if ($topic_default_hide) {
                    // Need to set at least one default so set first one if none selected or option hidden
                    if (!$set_default) {
                        $default = 1;
                        $set_default = true;
                    } else {
                        $default = 0;
                    }
                } else {
                    if ($value == $default_tid) {
                        $default = 1;
                    } else {
                        $default = 0;
                    }
                }
                
                DB_save ($_TABLES['topic_assignments'], 'tid,type,id,inherit,tdefault', "'$value', '$type', '$id', $inherit, $default");
            }
        }
    } else {
        if ($topic_option == TOPIC_ALL_OPTION || $topic_option == TOPIC_HOMEONLY_OPTION) {
            DB_delete($_TABLES['topic_assignments'], array('type', 'id'), array($type, $id));
            
            DB_save ($_TABLES['topic_assignments'], 'tid,type,id,inherit,tdefault', "'$topic_option', '$type', '$id', 0 , 0");
        } else {
            return false;
        }
    }
    
    return true;
    
}

/**
* Get Post Data from topic control for an object
*
*
* @param        string     $topic_option    Retrieved topic option selected
* @param        array      $tids            Retrieved topics selected
* @param        array      $inherit_tids    Retrieved inherited topics selected
* @param        string     $default_tid     Retrieved default topic selected
*
*/
function TOPIC_getDataTopicSelectionControl(&$topic_option, &$tids, &$inherit_tids, &$default_tid)
{
    $topic_options_hide = 0;
    if (isset ($_POST['topic_options_hide'])) {
        $topic_options_hide = COM_applyFilter($_POST['topic_options_hide'], true);
    }
    if (!$topic_options_hide) {
        $topic_option = TOPIC_ALL_OPTION;
        if (isset ($_POST['topic_option'])) {
            $topic_option = COM_applyFilter($_POST['topic_option']);
        }
    } else {
        $topic_option = TOPIC_SELECTED_OPTION;
    }
    
    $tids = array();
    if (isset ($_POST['tid'])) {
        $tids = $_POST['tid']; // to be sanitized later
    }

    $inherit_tids = array();
    if (isset ($_POST['inherit_tid'])) {
        $inherit_tids = $_POST['inherit_tid']; // to be sanitized later
    }

    $default_tid = '';
    if (isset ($_POST['default_tid'])) {
        $default_tid = COM_applyFilter($_POST['default_tid']);
    }    
}

/**
* Shows topic control for an object
*
* This will return the HTML needed to create the topic control seen on the
* admin screen for GL objects (i.e. stories, blocks, etc)
*
* @param        string     $type            Type of object to display access for
* @param        string     $id              Id of onject (if '' then load date from control)
* @param        boolean    $show_options    True/False. If true then All and Homepage options will be visible
* @param        boolean    $show_inherit    True/False. If true then inhert selection will be enabled
* @param        boolean    $show_default    True/False. If true then default topic selection will be enabled
* @return       string  needed HTML (table) in HTML 
*
*/
function TOPIC_getTopicSelectionControl($type, $id, $show_options = false, $show_inherit = false, $show_default = false)
{
    global $_CONF, $LANG27, $_TABLES, $topic, $_SCRIPTS;

    $tids = array();
    $inherit_tids = array();
    $default_tid = '';
    // Set Default Topic Option
    $topic_option = TOPIC_SELECTED_OPTION;
    if ($show_options) {
        $topic_option = TOPIC_ALL_OPTION; // Default to all topics so things will work similar to how topics handled before Geeklog 2.0.0
    }

    // Do they have any access to topics first?

    // Retrieve Topic options
    $from_db = true;
    if (empty($type) || empty($id)) {
        $from_db = false;
    }
    if (!$from_db) {
         // see if a selection control variable is_a set. If not then first time for display of control
        if (isset($_POST['topic_options_hide'])) {
            TOPIC_getDataTopicSelectionControl($topic_option, $tids, $inherit_tids, $default_tid);
        } else {
            // Figure out if we set current topic for first display or use default topic
            if ($topic_option == TOPIC_SELECTED_OPTION && empty($tids)) {
                if ($topic == '') {
                    $tids = DB_getItem($_TABLES['topics'], 'tid', 'is_default = 1' . COM_getPermSQL('AND'));
                } else {
                    $tids = $topic;
                }
            }
        }
    } else {
        $sql = "SELECT * FROM {$_TABLES['topic_assignments']} WHERE type = '$type' AND id ='$id'";

        $result = DB_query($sql);
        $B = DB_fetchArray($result);
        $nrows = DB_numRows($result);
        if ($nrows > 0) {
            if ($B['tid'] == TOPIC_ALL_OPTION || $B['tid'] == TOPIC_HOMEONLY_OPTION) {
                $topic_option = $B['tid'];
            } else {
                $topic_option = TOPIC_SELECTED_OPTION;
                $tids = array();
                $tids[] = $B['tid'];
                if ($B['inherit'] == 1) {
                    $inherit_tids[] = $B['tid'];
                }
                if ($B['tdefault'] == 1) {
                    $default_tid = $B['tid'];
                }
                for ($i = 1; $i < $nrows; $i++) {
                    $B = DB_fetchArray($result);
                    $tids[] = $B['tid'];
                    if ($B['inherit'] == 1) {
                        $inherit_tids[] = $B['tid'];
                    }
                    if ($B['tdefault'] == 1) {
                        $default_tid = $B['tid'];
                    }
                }
            }
        } else {
            // Shouldn't happen but prepare
            $show_inherit = false;
            $show_default = false;
        }
    }

    $retval = '';
    $topic_info = $LANG27[40];

    $topic_templates = COM_newTemplate($_CONF['path_layout'] . 'admin/common');
    $topic_templates->set_file(array('editor' => 'edit_topics.thtml'));

    $_SCRIPTS->setJavaScriptLibrary('jquery');
    $_SCRIPTS->setJavascriptFile('topic_control', '/javascript/topic_control.js');

    $topiclist = TOPIC_getTopicListSelect($tids, false);
    if (!$show_options && $topiclist == '') { // If access to no topics return nothing
        return '';
    }

    $topic_hide = false; // If false then topics multi select box will be visible
    $val_hide = 'display:none;';
    if ($topiclist == '') { // Topics do not exist
        $topic_hide = true;
        $topic_templates->set_var('topic_option_hide', $val_hide);
    } else {
        $topic_templates->set_var('topic_options', $topiclist);
    }

    if ($show_options && $topic_option !== TOPIC_SELECTED_OPTION) {
        $topic_hide = true;
    }
    $inherit_hide = true; // If false then inhert topic selection will be visible
    $default_hide = true; // If false then default topic selection will be visible
    if (!$topic_hide) {
        $inherit_hide = $show_inherit ? false : true;
        $default_hide = $show_default ? false : true;
    }

    if ($show_options) {
        $topic_templates->set_var('topic_options_hide', '0');
        $topic_info = $LANG27[41];
        $val_checked = 'checked="checked"';
        $all_checked            = ($topic_option == TOPIC_ALL_OPTION)      ? $val_checked : '';
        $homeonly_checked       = ($topic_option == TOPIC_HOMEONLY_OPTION) ? $val_checked : '';
        $selectedtopics_checked = ($topic_option == TOPIC_SELECTED_OPTION) ? $val_checked : '';
        // if no topics found cannot check so set default
        if ($topic_option == TOPIC_SELECTED_OPTION && $topiclist == '') {
            $all_checked = $val_checked;
            $selectedtopics_checked = '';
        }
        $topic_templates->set_var('all_checked', $val_checked);
        $topic_templates->set_var('homeonly_checked', $homeonly_checked);
        $topic_templates->set_var('selectedtopics_checked', $selectedtopics_checked);
    } else {
        $topic_templates->set_var('options_hide', $val_hide);
        $topic_templates->set_var('topic_options_hide', '1');
    }

    $opt_dummy = '<option value="dummy">dummy</option>';
    $inherit_options = $opt_dummy;
    $topic_inherit_hide = '1';
    if ($show_inherit) {
        $topic_inherit_hide = '0';
        $topic_info .= $LANG27[42];
        if (!empty($inherit_tids)) {
            if ($from_db) {
                $inherit_options = TOPIC_getOtherListSelect($type, $id, $inherit_tids);
            } else {
                $inherit_options = TOPIC_getOtherListSelect($type, $id, $inherit_tids, $tids);
            }
        } else {
            $inherit_hide = true;
        }
    }

    $default_options = $opt_dummy;
    $topic_default_hide = '1';
    if ($show_default) {
        $topic_default_hide = '0';
        $topic_info .= $LANG27[43];
        if (!empty($default_tid)) {
            if ($from_db) {
                $default_options = TOPIC_getOtherListSelect($type, $id, $default_tid);
            } else {
                $default_options = TOPIC_getOtherListSelect($type, $id, $default_tid, $tids);
            }
        } else {
            $default_hide = true;
        }
    }

    $topic_templates->set_var('topic_inherit_hide', $topic_inherit_hide);
    $topic_templates->set_var('inherit_options',    $inherit_options);
    $topic_templates->set_var('topic_default_hide', $topic_default_hide);
    $topic_templates->set_var('default_options',    $default_options);
    $topic_templates->set_var('topic_hide',   $topic_hide   ? $val_hide : '');
    $topic_templates->set_var('inherit_hide', $inherit_hide ? $val_hide : '');
    $topic_templates->set_var('default_hide', $default_hide ? $val_hide : '');
    $topic_templates->set_var('info_hide', '');
    $topic_templates->set_var('topic_info', $topic_info);
    $topic_templates->set_var('lang_all',      $LANG27[38]);
    $topic_templates->set_var('lang_homeonly', $LANG27[39]);
    $topic_templates->set_var('lang_selected', $LANG27[54]);
    $topic_templates->set_var('lang_assigned', $LANG27[55]);
    $topic_templates->set_var('lang_inherit',  $LANG27[44]);
    $topic_templates->set_var('lang_default',  $LANG27[45]);
    $topic_templates->parse('output', 'editor');
    $retval .= $topic_templates->finish($topic_templates->get_var('output'));

    return $retval;
}

/**
* Retrieve topics from selection or retrieve topics for object from db
*
* @param    string          $type   Type of object to find topic access about. If 'topic' then will check post array for topic selection control 
* @param    string/array    $id     ID of block or topic to check if block topic access
* @param    int             $uid    User id (not currently implemented) or 0 = current user or -1 = do not check access
* @return   array                   Returns default topic id or empty string if not found
*
*/
function TOPIC_getTopicIdsForObject($type, $id = '', $uid = -1)
{
    global $_TABLES;
    
    $tids = array();
    
    if ($type == 'topic') {
        if (isset ($_POST['tid'])) {
            $tids = $_POST['tid']; 
            
            foreach ($tids as &$value) {
                $value = COM_applyFilter($value);
            }
            
        }
    } else {
        // Retrieve topic assignments
        if ($uid == 0) {
            $sql = "SELECT ta.tid, t.topic 
                FROM {$_TABLES['topics']} t, {$_TABLES['topic_assignments']} ta 
                WHERE t.tid = ta.tid  
                AND ta.type = '$type' AND ta.id = '$id' 
                " . COM_getPermSQL('AND', 0, 2, 't') . COM_getLangSQL('tid', 'AND', 't')  
                . " ORDER BY tdefault DESC, topic ASC"; 
        } elseif ($uid > 0) {
            // Need to add code to retrieve topics assigments a specified user has access too
            
            
            
            
        } else {
            $sql = "SELECT tid FROM {$_TABLES['topic_assignments']} WHERE type = '$type' AND id ='$id'";
        }
        
        $result = DB_query($sql);
        $nrows = DB_numRows($result);
        for($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);        
            $tids[] = $A['tid'];
        }
    }
    
    return $tids;
}

/**
* Retrieve default topic from selection
*
* @param    string          $type   Type of object to find topic access about. If 'topic' then will check post array for topic selection control 
* @param    string/array    $id     ID of block or topic to check if block topic access
* @return   string                  Returns default topic id or empty string if not found
*
*/
function TOPIC_getTopicDefault($type, $id = '')
{
    global $_TABLES;
    
    $tid = '';
    
    if ($type == 'topic') {
        if (isset($_POST['topic_default_hide'])) {
            if ($_POST['topic_default_hide'] == '0') {
                if (isset($_POST['default_tid'])) {
                    $tid = COM_applyFilter($_POST['default_tid']);
                }
            }
        }
    } else {
        // Retrieve default topic from db
        $sql = "SELECT tid FROM {$_TABLES['topic_assignments']} WHERE type = '$type' AND id ='$id' AND tdefault = 1";
    
        $result = DB_query($sql);
        $A = DB_fetchArray($result);
        $nrows = DB_numRows($result);
        $tid = $A['tid'];
    }
    
    return $tid;
}

/**
* Delete Topic Assignments for a specfic object  
*
* @param    string          $type   Type of object to find topic access about.  
* @param    string/array    $id     ID of object
* @return   nothing
*
*/
function TOPIC_deleteTopicAssignments($type, $id)
{
    global $_TABLES;
    
    DB_delete($_TABLES['topic_assignments'], array('type', 'id'), array($type, $id));
}

/**
* Add Topic Assignments for a specfic object  
*
* @param    string          $type   Type of object to find topic access about.  
* @param    string/array    $id     ID of object
* @return   nothing
*
*/
function TOPIC_addTopicAssignments($type, $id, $tid = '')
{
    global $_TABLES;
    
    if ($tid == '') {
        $tid = TOPIC_ALL_OPTION;
    }
    
    DB_save ($_TABLES['topic_assignments'], 'tid,type,id,inherit,tdefault', "'$tid', '$type', '$id', 0 , 0");
}

/**
* Return Topic list for Admin list Topic Column 
* (need to handle 'all' and 'homeonly' as special cases)
*
* @param    string          $type   Type of object to find topic access about.  
* @param    string/array    $id     ID of object
* @return   string                  Returns topic list
*
*/
function TOPIC_getTopicAdminColumn($type, $id)
{
    global $_TABLES, $LANG21;
    
    $retval = '';
    
    // Retrieve topic assignments
    $sql = "SELECT * FROM {$_TABLES['topic_assignments']} WHERE type = '$type' AND id = '$id'";

    $result = DB_query($sql);
    $A = DB_fetchArray($result);
    $nrows = DB_numRows($result);
    if ($A['tid'] == TOPIC_ALL_OPTION) {
        $retval = $LANG21[7];                
    } elseif ($A['tid'] == TOPIC_HOMEONLY_OPTION) {
        $retval = $LANG21[43];    
    } else {
        if ($nrows == 0) {
            $retval = $LANG21[47]; // None
        } elseif ($nrows > 1) {
            $retval = $LANG21[44]; // Multiple
        } else {
            $retval = DB_getItem($_TABLES['topics'], 'topic', "tid = '{$A['tid']}'");
        }
    }
    
    return $retval;
}

/**
* Figure out the current topic for a plugin. If permissions or language wrong 
* will find default else end with a '' topic (which is all). Needs to be run  
* on page that is affected by the topic after lib-common.php so it can grab 
* topic in url if need be. Also if pass blank $type and $id then return just last topic
*
* @param    string          $type   Type of object to find topic access about.  
* @param    string/array    $id     ID of object
* @return   void
*
*/
function TOPIC_getTopic($type = '', $id = '')
{
    global $_TABLES, $topic;
    
    $find_another = false;
    $found = false;
    
    // Double check
    $topic = COM_applyFilter($topic);
    if ($topic == TOPIC_ALL_OPTION) {
        $topic = ''; // Do not use 'all' option. Nothing is the same thing 
    }
    // See if user has access to view topic
    if ($topic != '') {
        $test_topic = DB_getItem($_TABLES['topics'], 'tid', "tid = '$topic' " . COM_getPermSQL('AND'));
        if (strtolower($topic) != strtolower($test_topic)) {
            $topic = '';
        } else { // Make it equal to the db version since case maybe different
            $topic = $test_topic;
        }    
    }    
    
    // Check and return Previous topic
    if ($topic == '') {
        // Blank could mean all topics or that we do not know topic
        // retrieve previous topic
        $last_topic = SESS_getVariable('topic');
    } else {
        $last_topic = $topic;
    }

    // ***********************************
    // Special Cases
    if ($type == '') { // used by search, submit, etc to find last topic
        $topic = $last_topic;
        $found = true;
    } elseif ($type == 'comment') {
        if ($id != '') {
            // Find comment objects topic
            $sql = "SELECT type, sid 
                FROM {$_TABLES['comments']}  
                WHERE cid = '$id'";
        
            $result = DB_query($sql);
            $nrows = DB_numRows($result);
            if ($nrows > 0) {
                $A = DB_fetchArray($result);
                
                // Found comment object so now reset type and id variables
                $type = $A['type'];
                $id = $A['sid'];

            } else {
                // Could not find comment so set topic to nothing (all)
                $topic = '';
                $found = true;
            }
        } else {
            // If no id then probably a submit form
            $topic = $last_topic;
            $found = true;
        }
    }
    // ***********************************
    
    if (!$found) {
        if ($last_topic != '') {    
            // see if object belongs to topic or any child inherited topics
            $tid_list = TOPIC_getChildList($last_topic);
            
            $sql = "SELECT ta.tid 
                FROM {$_TABLES['topics']} t, {$_TABLES['topic_assignments']} ta 
                WHERE t.tid = ta.tid  
                AND ta.type = '$type' AND ta.id = '$id' 
                AND (ta.tid IN({$tid_list}) AND (ta.inherit = 1 OR (ta.inherit = 0 AND ta.tid = '{$last_topic}')))
                " . COM_getLangSQL('tid', 'AND', 't') . COM_getPermSQL('AND', 0, 2, 't')
                . " ORDER BY tdefault DESC, tid ASC"; // Order by default first and then tid alphabetically since no defined sort order of topics. This needs to be the same as when topics are displayed (index.php)
        
            $result = DB_query($sql);
            $nrows = DB_numRows($result);
            if ($nrows > 0) {
                $A = DB_fetchArray($result);
                $topic = $A['tid']; // Default topic if returned else first topic in order by tid
                
                // Need to check if topic assignment exists for last topic if so make that the topic instead
                while ($A = DB_fetchArray($result)) {
                    if ($last_topic == $A['tid']) {
                        $topic = $A['tid'];
                    }
                } 
            } else {
                $find_another = true;
            }
        } else {
            $find_another = true;
        }
        
        if ($find_another) {
            // Find another topic to set, most likely default
            $sql = "SELECT ta.* 
                FROM {$_TABLES['topics']} t, {$_TABLES['topic_assignments']} ta 
                WHERE t.tid = ta.tid  
                AND ta.type = '$type' AND ta.id = '$id' 
                " . COM_getLangSQL('tid', 'AND', 't') . COM_getPermSQL('AND', 0, 2, 't') . "
                ORDER by ta.tdefault DESC";
        
            $result = DB_query($sql);
            $nrows = DB_numRows($result);
            if ($nrows > 0) {
                $A = DB_fetchArray($result);
                $topic = $A['tid'];
            } else {
                $topic = '';
            }
        }
    }
}

/**
* If found returns one or more html breadcrumb. Used by Topics, Stories and Plugins.
*
* @param    string          $type   Type of object to create breadcrumb trail
* @param    string/array    $id     ID of object
* @return   string                  1 or more breadcrumb trail in html
*
*/
function TOPIC_breadcrumbs($type, $id)
{
    global $_CONF, $_TABLES, $LANG27, $_TOPICS, $topic;

    $breadcrumbs_output = '';

    // see if breadcrumbs is disabled
    if (($_CONF['disable_breadcrumbs_topics'] && $type == 'topic') ||
        ($_CONF['disable_breadcrumbs_articles'] && $type == 'article') ||
        ($_CONF['disable_breadcrumbs_plugins'] && $type != 'topic' && $type != 'article')) {
        return $breadcrumbs_output;
    }

    if ($type == 'topic') {
        $sql = "SELECT tid, topic, parent_id FROM {$_TABLES['topics']} "
             . "WHERE tid = '$id'" . COM_getPermSQL('AND', 0, 2);
    } else {
        // Retrieve all topics assignments that point to this object
        $sql = "SELECT t.tid, t.topic, t.parent_id "
             . "FROM {$_TABLES['topic_assignments']} ta, {$_TABLES['topics']} t "
             . "WHERE ta.type = '$type' AND ta.id = '$id' AND t.tid = ta.tid"
             . COM_getPermSQL('AND', 0, 2, 't');

        if (!$_CONF['multiple_breadcrumbs']) {
            $sql .= " AND ta.tid = '$topic'";
        }
    }
    $result = DB_query($sql);
    if (DB_numRows($result) > 0) {
        $breadcrumb_t = COM_newTemplate($_CONF['path_layout'] . 'breadcrumbs/');
        $breadcrumb_t->set_file(array(
            'breadcrumbs_t'       => 'breadcrumbs.thtml',
            'breadcrumb_child_t'  => 'breadcrumb_child.thtml',
            'breadcrumb_root_t'   => 'breadcrumb_root.thtml',
            'breadcrumb_nolink_t' => 'breadcrumb_nolink.thtml',
            'breadcrumb_t'        => 'breadcrumb.thtml'));
        if (in_array($_CONF['doctype'], array('html5', 'xhtml5'))) {
            $breadcrumb_t->set_var('microdata', true);
        }
        $rootname = $_CONF['breadcrumb_root_site_name'] ?
            $_CONF['site_name'] : $LANG27['breadcrumb_root'];
        $separator = htmlspecialchars($LANG27['breadcrumb_separator']);

        while ($A = DB_fetchArray($result)) {
            $breadcrumb_a = array();
            $breadcrumb_a[] = $A;
            $parent_id = $A['parent_id'];
            while ($parent_id != TOPIC_ROOT) {
                $sql = "SELECT tid, topic, parent_id "
                     . "FROM {$_TABLES['topics']} WHERE tid = '$parent_id'";
                $resultB = DB_query($sql);
                if (DB_numRows($resultB) !== 1) break;
                $B = DB_fetchArray($resultB);
                $breadcrumb_a[] = $B;
                $parent_id = $B['parent_id'];
            }
            $breadcrumb_a[] = array(
                'tid' => TOPIC_ROOT,
                'topic' => $rootname,
                'parent_id' => '');

            $retval = '';
            foreach ($breadcrumb_a as $value) {
                // double check access (users may have access to a subtopic
                // but not a parent topic, this shouldn't really happen though)
                $topic_access = 0;
                $topic_index = TOPIC_getIndex($value['tid']);
                if ($topic_index > 0) {
                    $topic_access = $_TOPICS[$topic_index]['access'];
                }

                if ($topic_access == 0) { // Do not have access to view page
                    $url = '';
                    $use_template = 'breadcrumb_nolink_t';
                } else {
                    $url = $_CONF['site_url'] . '/index.php';
                    if ($value['tid'] != TOPIC_ROOT) {
                        $url .= '?topic=' . $value['tid'];
                    }
                    $use_template = 'breadcrumb_t';
                }
                $breadcrumb_t->set_var('url', $url);
                $breadcrumb_t->set_var('name', $value['topic']);
                $breadcrumb_t->set_var('breadcrumb_child', $retval);
                $breadcrumb_t->set_var('separator', empty($retval) ? '' : $separator);
                if ($value['tid'] == TOPIC_ROOT) {
                    $breadcrumb_t->parse('breadcrumb_root', $use_template);
                    $breadcrumb_t->parse('output', 'breadcrumb_root_t');
                } else {
                    $breadcrumb_t->parse('breadcrumb', $use_template);
                    $breadcrumb_t->parse('output', 'breadcrumb_child_t');
                }

                $retval = $breadcrumb_t->finish($breadcrumb_t->get_var('output'));
            }
            $breadcrumb_t->set_var('breadcrumbs_list', $retval);
            $breadcrumb_t->parse('output', 'breadcrumbs_t');
            $breadcrumbs_output .= $breadcrumb_t->finish($breadcrumb_t->get_var('output'));
        }
    }

    return $breadcrumbs_output;
}

/**
* Checks to see if the topic id given is in the current topic path (bases on current users's access). 
*
* @param    string     $tid         Topic Id to check if in parent path  
* @param    string     $current_tid Current Topic Id (the path to check). If blank then assume actual current topic
* @return   boolean                 False if not found or no access or if no current topic
*
*/
function TOPIC_inPath($tid, $current_tid = '')
{
    global $_TOPICS, $topic;
    
    $found = false;
    
    if ($current_tid == '') {
        $current_tid = $topic;    
    }
    
    if ($current_tid != '') {
        // Let's start at the bottom and work I way up
        $check_tid = $current_tid;
        while ($found == false) {
            if ($check_tid != TOPIC_ROOT) {
                $index = TOPIC_getIndex($check_tid);
                if ($_TOPICS[$index]['access'] > 0 && $index != 0) {
                    if ($check_tid == $tid) {
                        $found = true;    
                    }
                } else {
                    break; // break on no access or not found
                }
                $check_tid = $_TOPICS[$index]['parent_id'];
            } else {
                break; // break on root
            }
        }
    }
    
    return $found;
}

/**
* This function creates an html list of topics the object belongs too or 
* creates a similar list based on topics passed to it
*
* @param    string          $type           Type of object to display access for
* @param    string          $id             Id of onject
* @param    integer         $max            Max number of items returned
* @param    string/array    $tids           Topics Ids to use instead of retrieving from db
* @return   HTML string
*
*/
function TOPIC_relatedTopics($type, $id, $max = 6, $tids = array())
{
    global $_CONF, $LANG27, $_TABLES;

    $retval = '';
    
    if ($max < 0) {
        $max = 6;
    }
    
    if (!is_array($tids)) {
        $tids = array($tids);   
    }  
    
    // if topic ids not passed then retrieve from db
    $from_db = false;
    if (empty($tids)) {
        $from_db = true;
    }
    
    if ($from_db) {
        // Retrieve Topic options
        $sql = "SELECT ta.tid, t.topic 
            FROM {$_TABLES['topic_assignments']} ta, {$_TABLES['topics']} t 
            WHERE t.tid = ta.tid AND ta.type = '$type' AND ta.id ='$id' 
            " . COM_getPermSQL('AND', 0, 2, 't') . COM_getLangSQL('tid', 'AND', 't') . "    
            AND t.tid != '" . TOPIC_ALL_OPTION . "' AND t.tid != '" . TOPIC_HOMEONLY_OPTION . "'";
    } else {
        $sql = "SELECT tid, topic 
            FROM {$_TABLES['topics']} t   
            WHERE (tid IN ('" . implode( "','", $tids ) . "'))"; 
    }
    $sql .= COM_getPermSQL('AND');
    if ($from_db) {
        $sql .= " ORDER BY tdefault DESC, topic ASC";
    } else {
        $sql .= " ORDER BY topic ASC";        
    }
    if ($max > 0) {    
        $sql .= " LIMIT " . $max;
    }
        
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        $topicrelated = COM_newTemplate($_CONF['path_layout']);
        $topicrelated->set_file( array(
            'topicrelated' => 'topicrelated.thtml'
            ));
        $blocks = array('topicitem', 'separator');
        foreach ($blocks as $block) {
            $topicrelated->set_block('topicrelated', $block);
        }             
        
        $topicrelated->set_var('lang_filed_under', $LANG27['filed_under:']);
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $url = $_CONF['site_url'] . '/index.php?topic=' . $A['tid'];
            
            $topicrelated->set_var('topic_url', $url);
            $topicrelated->set_var('topic', $A['topic']);            
            
            $topicrelated->parse('topics', 'topicitem', true);
            if (($i+1) < $nrows) {
                $topicrelated->parse('topics', 'separator', true);
            }
        }
        
        $retval = $topicrelated->finish($topicrelated->parse('topicrelated', 'topicrelated'));
    }    

    return $retval;
}

/**
* This function creates a list of the newest and recently modified items that are related based on 
* the topics passed or that the object belongs too 
*
* @param    string          $type           Type of object to display access for
* @param    string          $id             Id of onject
* @param    integer         $max            Max number of items returned
* @param    integer         $trim           Max length of link text
* @param    string/array    $tids           Topics Ids to use instead of retrieving from db
* @return   HTML string
*
*/
function TOPIC_relatedItems($type, $id, $include_types = array(), $max = 10, $trim = 0, $tids = array())
{
    global $_CONF, $LANG27, $_TABLES;

    $retval = '';
    $related_items = array();
    
    if ($max < 1) {
        $max = 1;
    }
    
    if (!is_array($tids)) {
        $tids = array($tids);   
    }  
    
    // if topic ids not passed then retrieve from db
    $from_db = false;
    if (empty($tids)) {
        $from_db = true;
    }
    
    // Find all topics user has access too
    if ($from_db) {
        // Retrieve Topic options
        $sql = "SELECT ta.tid, t.topic 
            FROM {$_TABLES['topic_assignments']} ta, {$_TABLES['topics']} t 
            WHERE t.tid = ta.tid AND ta.type = '$type' AND ta.id ='$id'  
            AND t.tid != '" . TOPIC_ALL_OPTION . "' AND t.tid != '" . TOPIC_HOMEONLY_OPTION . "'";
    } else {
        $sql = "SELECT tid, topic 
            FROM {$_TABLES['topics']} t   
            WHERE (tid IN ('" . implode( "','", $tids ) . "'))"; 
    }
    $sql .= COM_getPermSQL('AND') . "
        ORDER BY topic ASC LIMIT " . $max;    
    
    $result = DB_query($sql);
    $nrows = DB_numRows($result);
    if ($nrows > 0) {
        $tids = array();
        for ($i = 0; $i < $nrows; $i++) {
            $A = DB_fetchArray($result);
            $tids[] = $A['tid'];
        }
        
        // Now pass the topic ids to the plugins so they return the latest related items
        $related_items = PLG_getRelatedItems($include_types, $tids, $max, $trim);
        
        if (!empty($related_items)) {
            // Sort date so newest is first       
            krsort($related_items);
            
            // Return only max number
            if ($max > 0) {
                $related_items = array_slice($related_items, 0, $max);
            }
        } else {
            // No related items found so and that to the list
            $related_items[] = $LANG27['no_related_items'];
        }
        
    } else {
        // No Topics found, most likely setting an autotag mistake but return a nice message
        $related_items[] = $LANG27['no_related_items'];
    }    

    // Make html list
    $retval = COM_makeList($related_items, 'list-new-plugins');
    
    return $retval;    
}

/*
 * Implement *some* of the Plugin API functions for topics. While topics
 * aren't a plugin (and likely never will be), implementing some of the API
 * functions here will save us from doing special handling elsewhere.
 */
 

/**
* Implements the [topic:] autotag.
*
* @param    string  $op         operation to perform
* @param    string  $content    item (e.g. topic text), including the autotag
* @param    array   $autotag    parameters used in the autotag
* @param    mixed               tag names (for $op='tagname') or formatted content
*
*/

function plugin_autotags_topic($op, $content = '', $autotag = '')
{
    global $_CONF, $_TABLES, $LANG27, $_GROUPS;
    if($op == 'tagname') {
        return array('topic', 'related_topics', 'related_items');
    } 

    elseif (($op == 'permission') || ($op == 'nopermission')) {
        if ($op == 'permission') {
            $flag = true;
        } else {
            $flag = false;
        }
        $tagnames = array();

        if (isset($_GROUPS['Topic Admin'])) {
            $group_id = $_GROUPS['Topic Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id',"grp_name = 'Topic Admin'");
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

        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'description') {
        return array (
            'topic' => $LANG27['autotag_desc_topic'],
            'related_topics' => $LANG27['autotag_desc_related_topics'], 
            'related_items' => $LANG27['autotag_desc_related_items']
            );  
    } elseif ($op == 'parse') {
		if ( $autotag['tag'] != 'topic' && $autotag['tag'] != 'related_topics' && $autotag['tag'] != 'related_items') {
            return $content;
		}
        
        if ($autotag['tag'] == 'topic') {
            $tid = COM_applyFilter($autotag['parm1']);
            if (!empty($tid) && (SEC_hasTopicAccess($tid) > 0)) {
                $tid = DB_escapeString($tid);
                $sql = "SELECT COUNT(*) AS count FROM {$_TABLES['topics']} WHERE tid = '$tid'";
                $result = DB_query($sql);
                $A = DB_fetchArray($result);
                if ($A['count'] == 1) {
                    $url = COM_buildUrl($_CONF['site_url'] . '/index.php?topic=' . $tid);
                    $linktext = $autotag['parm2'];
                    if (empty($linktext)) {
                        $linktext = stripslashes(DB_getItem($_TABLES['topics'], 'topic', "tid = '$tid'"));
                    }
                    $link = COM_createLink($linktext, $url);
                    $content = str_replace($autotag['tagstr'], $link, $content);
                }
            }
        } elseif ($autotag['tag'] == 'related_topics') {
            $id = COM_applyFilter($autotag['parm1']);
            $type = '';
            $max = $_CONF['related_topics_max']; // Article Default
            $tids = array();
            $skip = 0;
            
            $px = explode (' ', trim ($autotag['parm2']));
            if (is_array ($px)) {
                foreach ($px as $part) {
                    if (substr ($part, 0, 5) == 'type:') {
                        $a = explode (':', $part);
                        $type = $a[1];
                        $skip++;
                    } elseif (substr ($part, 0, 4) == 'max:') {
                        $a = explode (':', $part);
                        $max = $a[1];
                        $skip++;
                    } elseif (substr ($part,0, 6) == 'topic:') {
                        $a = explode(':', $part);
                        $tids[] = $a[1]; // Add each topic when found
                        $skip++;
                    } else {
                            break;
                    }
                }
            }             
            
            $related_topics = '';
            if (!empty($type) AND !empty($id)) {
                // Return topics of object
                $related_topics = TOPIC_relatedTopics($type, $id, $max);
            } elseif (!empty($tids)) {
                // Since list of topics specified add id to topic list (since really a topic)
                if (!empty($id)) {
                    $tids[] = $id;
                }
                $related_topics = TOPIC_relatedTopics('', '', $max, $tids);
            }

            if (!empty($related_topics)) {
                $content = str_replace($autotag['tagstr'], $related_topics, $content);
            }
        } elseif ($autotag['tag'] == 'related_items') {
            $id = COM_applyFilter($autotag['parm1']);
            $type = '';
            $max = $_CONF['related_topics_max']; // Article Default
            $trim = 0;
            $include_types = array();
            $tids = array();
            $skip = 0;
            
            $px = explode (' ', trim ($autotag['parm2']));
            if (is_array ($px)) {
                foreach ($px as $part) {
                    if (substr ($part, 0, 5) == 'type:') {
                        $a = explode (':', $part);
                        $type = $a[1];
                        $skip++;
                    } elseif (substr ($part, 0, 4) == 'max:') {
                        $a = explode (':', $part);
                        $max = $a[1];
                        $skip++;
                    } elseif (substr ($part, 0, 5) == 'trim:') {
                        $a = explode (':', $part);
                        $trim = $a[1];
                        $skip++;
                    } elseif (substr ($part,0, 6) == 'topic:') {
                        $a = explode(':', $part);
                        $tids[] = $a[1]; // Add each topic when found
                        $skip++;
                    } elseif (substr ($part,0, 8) == 'include:') {
                        $a = explode(':', $part);
                        $include_types[] = $a[1]; // Add each type when found
                        $skip++;                        
                    } else {
                            break;
                    }
                }
            }             
            
            $related_items = '';
            if (!empty($type) AND !empty($id)) {
                // Return topics of object
                $related_items = TOPIC_relatedItems($type, $id, $include_types, $max, $trim, $tids);
            } elseif (!empty($tids) OR !empty($id)) {
                // Since list of topics specified add id to topic list (since really a topic)
                $tids[] = $id;
                
                $related_items = TOPIC_relatedItems('', '', $include_types, $max, $trim, $tids);
            }

            if (!empty($related_items)) {
                $content = str_replace($autotag['tagstr'], $related_items, $content);
            }            
        }

        return $content;
    }
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

/**
* This function is called when a user's information
* (profile or preferences) has changed.
*
* @param    int     $uid    user id
* @return   void
*
*/
function plugin_user_changed_topic($uid)
{
    global $_CONF;
    
    // Wipe out user's session variable for last_topic_update (if it exists) since their 
    // security may have changed and the topic tree should be updated again
    $cacheInstance = 'topic_tree__' . CACHE_security_hash();
    CACHE_remove_instance($cacheInstance);
}

?>
