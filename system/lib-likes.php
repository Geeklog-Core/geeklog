<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +--------------------------------------------------------------------------+
// | Geeklog 2.2                                                              |
// +--------------------------------------------------------------------------+
// | lib-likes.php                                                            |
// |                                                                          |
// | Likes System                                                             |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2020 by the following authors:                             |
// |                                                                          |
// | Tom Homer              tomhomer AT gmail DOT com                         |
// |                                                                          |
// | Copyright (C) 2008-2018 by the following authors:                        |
// |                                                                          |
// | Mark R. Evans          mark AT glfusion DOT org                          |
// |                                                                          |
// | Based on prior work by:                                                  |
// | Copyright (C) 2006,2007, 2008 by the following authors:                  |
// | Authors:                                                                 |
// | Ryan Masuga, masugadesign.com  - ryan@masugadesign.com                   |
// | Masuga Design                                                            |
// |http://masugadesign.com/the-lab/scripts/unobtrusive-ajax-star-rating-bar  |
// | Komodo Media (http://komodomedia.com)                                    |
// | Climax Designs (http://slim.climaxdesigns.com/)                          |
// | Ben Nolan (http://bennolan.com/behaviour/) for Behavio(u)r!              |
// |                                                                          |
// | Homepage for this script:                                                |
// |http://www.masugadesign.com/the-lab/scripts/unobtrusive-ajax-star-rating-bar/
// +--------------------------------------------------------------------------+
// | This (Unobtusive) AJAX Rating Bar script is licensed under the           |
// | Creative Commons Attribution 3.0 License                                 |
// |  http://creativecommons.org/licenses/by/3.0/                             |
// |                                                                          |
// | What that means is: Use these files however you want, but don't          |
// | redistribute without the proper credits, please. I'd appreciate hearing  |
// | from you if you're using this script.                                    |
// |                                                                          |
// | Suggestions or improvements welcome - they only serve to make the script |
// | better.                                                                  |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | Licensed under a Creative Commons Attribution 3.0 License.               |
// | http://creativecommons.org/licenses/by/3.0/                              |
// |                                                                          |
// +--------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// set to true to enable debug output in error.log
$_LIKES_DEBUG = COM_isEnableDeveloperModeLog('like');

/**
 * Related Plugin Library functions
 */
// PLG_typeLikesEnabled, PLG_canUserLike, PLG_itemLike, PLG_getItemLikeURL

// Plugins that support this must also support PLG_getItemInfo and returning url (based on permissions)

/**
 * Constants used for storing Likes actions in DB table
 */
define('LIKES_ACTION_NONE', 0); // Also considered a delete by PLG_itemLike
define('LIKES_ACTION_LIKE', 1);
define('LIKES_ACTION_DISLIKE', 2);
define('LIKES_ACTION_UNLIKE', 3);
define('LIKES_ACTION_UNDISLIKE', 4);

/**
 * Constants used for Likes Block
 */
const LIKES_BLOCK_DISPLAY_LIKE = 1;
const LIKES_BLOCK_DISPLAY_DISLIKE = 2;
const LIKES_BLOCK_DISPLAY_ALL = 3;

/**
* Returns the Likes Control
*
* @param        string      $type               plugin name
* @param        string      $sub_type           Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        string      $item_id            item id WARNING must be no larger that 128 characters
* @param        int         $likes_setting      if 2 dislikes will not be displayed
* @param        string      $message            language string of message to pass to user
* @return       string      html of the likes control
*
*/
function LIKES_control($type, $sub_type, $item_id, $likes_setting, $message = '') {
    global $_USER, $_CONF, $LANG_LIKES, $_SCRIPTS;

    // Figure out if dislike is enabled or not
    $dislike = true;
    if ($likes_setting == 2) {
        $dislike = false;
    }

    list($num_likes, $num_dislikes) = LIKES_getLikes($type, $sub_type, $item_id);

    // Find likes control template file to use
    if ($type != 'article' OR $type != 'comment') {
        // See if plugin has own likes control template file
        $likestemplatefilepath = CTL_plugin_themeFindFile($type, 'controls', 'likes.thtml', false, false);
        if (!empty($likestemplatefilepath)) {
            $likes_templates = COM_newTemplate($likestemplatefilepath);
        } else {
            $likes_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'controls'));
        }
    } else {
        $likes_templates = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'controls'));
    }
    $likes_templates->set_file('likes_control', 'likes.thtml');

    // Multiple likes on same page no need to try and set scripts again
    if (!defined('GL-LIKES-SET')) {
        define('GL-LIKES-SET', true);

        $_SCRIPTS->setJavaScriptLibrary('jquery');
        $_SCRIPTS->setJavascriptFile('likes_control', '/javascript/likes_control.js');
    }

    $likes_templates->set_var('item_type', $type);
    $likes_templates->set_var('item_sub_type', $sub_type);
    $likes_templates->set_var('item_id', $item_id);

    $uid = isset($_USER['uid']) ? $_USER['uid'] : 1;
    $ip = \Geeklog\IP::getIPAddress();

    $action_enabled = PLG_canUserLike($type, $sub_type, $item_id, $uid, $ip);

    $likes_templates->set_var('dislike_enabled', $dislike);
    $likes_templates->set_var('action_enabled', $action_enabled);

    if ($action_enabled) {
        $prev_action = LIKES_hasAction($type, $sub_type, $item_id, $uid, $ip);
        if ($prev_action == LIKES_ACTION_LIKE) {
            $likes_templates->set_var('user_liked', true);
            $likes_templates->set_var('lang_like_action', $LANG_LIKES['unlike']);
            if ($dislike) {
                $likes_templates->set_var('lang_dislike_action', $LANG_LIKES['i_dislike_this']);
            }
        } else {
            $likes_templates->set_var('user_liked', false);
            $likes_templates->set_var('lang_like_action', $LANG_LIKES['i_like_this']);

            if ($dislike AND ($prev_action == LIKES_ACTION_DISLIKE)) {
                $likes_templates->set_var('user_disliked', true);
                $likes_templates->set_var('lang_dislike_action', $LANG_LIKES['undislike']);
            } elseif ($dislike) {
                $likes_templates->set_var('user_disliked', false);
                $likes_templates->set_var('lang_dislike_action', $LANG_LIKES['i_dislike_this']);
            }
        }
    } else {
        $likes_templates->set_var('lang_like_action', $LANG_LIKES['likes']);
        $likes_templates->set_var('lang_dislike_action', $LANG_LIKES['dislikes']);
    }

    // Debug
    //$message .= " t=".$type." st=".$sub_type." i=".$item_id." u=".$uid." a=".$action_enabled;

    $likes_templates->set_var('lang_message', $message);

    $likes_templates->set_var('num_of_likes', LIKES_formatNum($num_likes));
	if ($num_likes > 0 && $_CONF['likes_users_listed'] > 0) {
		$htmlToolTip = LIKES_numberTooltip($type, $sub_type, $item_id, LIKES_ACTION_LIKE);
		
		$likes_templates->set_var('gl_tooltip_num_of_likes', COM_getTooltip(LIKES_formatNum($num_likes), $htmlToolTip));
		$likes_templates->set_var('lang_num_of_likes', $htmlToolTip);
	}
    if ($dislike) {
        $likes_templates->set_var('num_of_dislikes', LIKES_formatNum($num_dislikes));
		if ($num_dislikes > 0 && $_CONF['likes_users_listed'] > 0) {
			$htmlToolTip = LIKES_numberTooltip($type, $sub_type, $item_id, LIKES_ACTION_DISLIKE);
			
			$likes_templates->set_var('gl_tooltip_num_of_dislikes', COM_getTooltip(LIKES_formatNum($num_dislikes), $htmlToolTip));
			$likes_templates->set_var('lang_num_of_dislikes', $htmlToolTip);		
		}
    }

    $likes_templates->parse('output', 'likes_control');
    $retval = $likes_templates->finish($likes_templates->get_var('output'));

    return $retval;
}

/**
* Returns the likes/dislikes number tooltip
*
* @param        string      $type               plugin name
* @param        string      $sub_type           Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        string      $item_id            item id WARNING must be no larger that 128 characters
* @param        int     $action    LIKES_ACTION_LIKE or LIKES_ACTION_DISLIKE
* @return       string     tooltip text for Likes or Dislikes number
*
*/
function LIKES_numberTooltip($type, $sub_type, $item_id, $action)
{
	global $_CONF, $LANG_LIKES, $_TABLES;

	if (!($action == LIKES_ACTION_LIKE || $action == LIKES_ACTION_DISLIKE) 
		|| (!isset($_CONF['likes_users_listed']) || $_CONF['likes_users_listed'] == 0)) {
		return '';
	}
	
    $sql = "SELECT uid FROM {$_TABLES['likes']} WHERE type='" . DB_escapeString($type) . "' AND subtype='" . DB_escapeString($sub_type) . "' AND id='" . DB_escapeString($item_id) . "' AND uid = 1 AND action = " . $action;
    $result = DB_query($sql);
    $num_anon_likes = DB_numRows($result);	
	
    $sql = "SELECT uid FROM {$_TABLES['likes']} WHERE type='" . DB_escapeString($type) . "' AND subtype='" . DB_escapeString($sub_type) . "' AND id='" . DB_escapeString($item_id) . "' AND uid > 1 AND action = " . $action . " ORDER BY created DESC";
    $result = DB_query($sql);
	$num_user_likes = DB_numRows($result);
	$user_list = '';
	$user_count = 0;
	$num_more_users = 0;	
		
    while (($A = DB_fetchArray($result, false)) != false) {
		$user_count++;
		$user_list .= sprintf($LANG_LIKES['username_in_likes_list'], COM_getDisplayName($A['uid']));
		if ($user_count == $_CONF['likes_users_listed']) {
			$num_more_users = $num_user_likes - $user_count;
			// Only stop if greater than 1 more else just go through it one more time
			if (($user_count + 1) < $num_user_likes) {
				break;
			}
		}
	}	
	
	if ($action == LIKES_ACTION_LIKE) {
		$lang_num_of_likes = $LANG_LIKES['liked_by'];
	} else {
		$lang_num_of_likes = $LANG_LIKES['disliked_by'];
	}
	
	if ($num_anon_likes == 1) {
		$lang_num_of_likes .= $LANG_LIKES['one_anon_users'];
	} elseif ($num_anon_likes > 1) {
		$lang_num_of_likes .= sprintf($LANG_LIKES['num_anon_users'], $num_anon_likes);
	}
	
	$lang_num_of_likes .= $user_list;
	
	if (($user_count + 1) < $num_user_likes) {
		$lang_num_of_likes .= sprintf($LANG_LIKES['num_more_users'], $num_more_users);
	}	

	return $lang_num_of_likes;

}

/**
* Returns the likes number in a rounded format over 1000
*
* @param        int     $num    number to format
* @return       int     the formated number
*
*/
function LIKES_formatNum($num)
{
    $units = array('', 'K', 'M', 'B', 'T');
    for ($i = 0; $num >= 1000; $i++) {
        $num /= 1000;
    }
    return round($num, 1) . $units[$i];
}


/**
* Returns the likes data for an item.
*
* @param        string      $type     plugin name
* @param        string      $sub_type Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        string      $item_id  item id
* @return       array       an array of number of likes and dislikes
*
*/
function LIKES_getLikes($type, $sub_type, $item_id)
{
    global $_TABLES;

    $sql = "SELECT action FROM {$_TABLES['likes']} WHERE type='" . DB_escapeString($type) . "' AND subtype='" . DB_escapeString($sub_type) . "' AND id='" . DB_escapeString($item_id) . "' AND action = " . LIKES_ACTION_LIKE;
    $result = DB_query($sql);
    $num_likes = DB_numRows($result);

    $sql = "SELECT action FROM {$_TABLES['likes']} WHERE type='" . DB_escapeString($type) . "' AND subtype='" . DB_escapeString($sub_type) . "' AND id='" . DB_escapeString($item_id) . "' AND action = " . LIKES_ACTION_DISLIKE;
    $result = DB_query($sql);
    $num_dislikes = DB_numRows($result);

    return array($num_likes, $num_dislikes);
}

/**
* Check if user or IP has already liked/disliked an item
*
* @param        string      $type     plugin name
* @param        string      $sub_type Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        string      $item_id  item id
* @param        int         $uid      user id
* @param        string      $ip       IP address of user
* @return       string      Empty if not voted else returns "like" or "dislike"
*
*/
function LIKES_hasAction($type, $sub_type, $item_id, $uid, $ip)
{
    global $_TABLES, $_LIKES_DEBUG;

    $prev_action = LIKES_ACTION_NONE;

    if ($uid == 1) {
        $sql = "SELECT L.action FROM {$_TABLES['likes']} AS L "
            . "LEFT JOIN {$_TABLES['ip_addresses']} AS i "
            . "ON L.seq = i.seq "
            . "WHERE L.uid=1 AND i.ipaddress='".DB_escapeString($ip)."' AND L.type='".DB_escapeString($type)."' AND L.subtype='" . DB_escapeString($sub_type) . "' AND L.id='".DB_escapeString($item_id)."'";
    } else {
        //$sql = "SELECT action FROM {$_TABLES['likes']} WHERE (uid=$uid OR ipaddress='".DB_escapeString($ip)."') AND type='".DB_escapeString($type)."' AND id='".DB_escapeString($item_id)."'";
        //$sql = "SELECT action FROM {$_TABLES['likes']} WHERE (uid=$uid OR (uid=1 AND ipaddress='".DB_escapeString($ip)."')) AND type='".DB_escapeString($type)."' AND id='".DB_escapeString($item_id)."'";
        $sql = "SELECT action FROM {$_TABLES['likes']} WHERE uid=$uid AND type='".DB_escapeString($type)."' AND subtype='" . DB_escapeString($sub_type) . "' AND id='".DB_escapeString($item_id)."'";
    }

    $result = DB_query($sql);
    if (DB_numRows($result) > 0) {
        $A = DB_fetchArray($result);
        $prev_action = $A['action'];
		
		if ($_LIKES_DEBUG) {
			COM_errorLog("Likes Previous Action Detected = $prev_action for type '$type' and sub type '$sub_type' with id '$item_id' for user id $uid", 1);
		}
    }

    return $prev_action;
}

/**
* Removes all likes actions for an item
*
* @param        string      $type     plugin name
* @param        string      $sub_type Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        string      $item_id  item id
* @return       void
*
*/
function LIKES_deleteActions($type, $sub_type, $item_id)
{
    global $_TABLES;

    DB_delete($_TABLES['likes'], array('type', 'subtype', 'id'), array($type, $sub_type, $item_id));

    PLG_itemLike($type, $sub_type, $item_id, LIKES_ACTION_NONE);
}


/**
* Add a new like action to an item
*
* @param        string      $type     plugin name
* @param        string      $sub_type Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        string      $item_id  item id
* @param        int         $action   like action sent by user
* @param        int         $prev_action
* @param        int         $uid      user id of voter
* @param        string      $ip       IP address of voter
* @return       array       an array with the new overall number of likes and dislikes.
*
*/
function LIKES_addAction($type, $sub_type, $item_id, $action, $prev_action, $uid, $ip)
{
    global $_TABLES;

    // Assume all previous checks done on passed in variables including if $action and $past_action are compatible with each other
	
    // Delete any previous action if exist
    if ($prev_action != LIKES_ACTION_NONE) {
        $escType = DB_escapeString($type);
        $escSubType = DB_escapeString($sub_type);
        $escItemId = DB_escapeString($item_id);
        $escIp = DB_escapeString($ip);

        if ($uid > 1) {
            $sql = "DELETE FROM {$_TABLES['likes']} WHERE type = '$escType' AND subtype='$escSubType' AND id = '$escItemId' AND uid = $uid";
            DB_query($sql);
        } else {
            $sql = "SELECT L.seq FROM {$_TABLES['likes']} AS L 
                LEFT JOIN {$_TABLES['ip_addresses']} AS i 
                ON L.seq = i.seq 
                WHERE L.type = '$escType' AND L.subtype='$escSubType' AND L.id = '$escItemId' AND L.uid = 1 AND i.ipaddress = '$escIp'";
            $result = DB_query($sql);
            $A = DB_fetchArray($result, false);

            if (is_array($A) && isset($A['seq'])) {
                $seq = (int) $A['seq'];
                \Geeklog\IP::deleteIpAddressBySeq($seq);
                DB_query("DELETE FROM {$_TABLES['likes']} WHERE seq = $seq");
            }
        }

        $sql = "DELETE FROM {$_TABLES['likes']} WHERE type = '$escType' AND subtype='$escSubType' AND id = '$escItemId' ";
    }

    // Now Insert new action if like or dislike
    if ($action == LIKES_ACTION_LIKE OR $action == LIKES_ACTION_DISLIKE) {
        $seq = \Geeklog\IP::getSeq($ip);
        $sql = "INSERT INTO {$_TABLES['likes']} (type, subtype, id, uid, seq, action, created) " .
               "VALUES ('" . DB_escapeString($type) . "', '" . DB_escapeString($sub_type) . "', '" . DB_escapeString($item_id) . "', " . $uid . ", '" . $seq . "', " . $action . ", CURRENT_TIMESTAMP);";

        DB_query($sql);
    }

    // Let plugin know about like action
    PLG_itemLike($type, $sub_type, $item_id, $action);

    // Get new counts and return
    return LIKES_getLikes($type, $sub_type, $item_id);
}

/**
* Move like actions from an old to a new item id
*
* @param        string      $type     plugin name
* @param        string      $sub_type Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        string      $old_item_id  Original item id
* @param        string      $new_item_id  New item id
* @return       void
*
*/
function LIKES_moveActions($type, $sub_type, $old_item_id, $new_item_id)
{
    global $_TABLES;

    if (empty($sub_type)) {
        DB_change($_TABLES['likes'], 'id', DB_escapeString($new_item_id),
            array('id', 'type'),
            array(DB_escapeString($old_item_id), $type));
    } else {
        DB_change($_TABLES['likes'], 'id', DB_escapeString($new_item_id),
            array('id', 'type', 'sub_type'),
            array(DB_escapeString($old_item_id), $type, $sub_type));
    }
}

/**
* Return number of likes or dislikes for a type, sub type, and id(s)
*
* @param        int         $action   like or dislike action
* @param        string      $type     plugin name
* @param        string      $sub_type Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        array       $item_ids  item id
* @return       int         the new overall number of likes and dislikes.
*
*/
function LIKES_getStats($action, $type = '', $sub_type = '', $item_ids = array())
{
    global $_TABLES;

    if ($action == LIKES_ACTION_LIKE OR $action == LIKES_ACTION_DISLIKE) {
        $sql = "SELECT action FROM {$_TABLES['likes']} WHERE action = $action";
        if (!empty($type)) {
            $sql .= " AND type = '" . DB_escapeString($type) . "'";

            if (!empty($sub_type)) {
                $sql .= " AND subtype = '" . DB_escapeString($sub_type) . "'";

                if (is_array($item_ids)) {
                    $sql .= " AND id IN (" . implode("','", $item_ids)  . ")";
                }
            }
        }
        $result = DB_query($sql);

        return DB_numRows($result);
    } else {
        return 0;
    }
}

/**
 * Returns the likes block. To be used with the Block Editor
 * Returns the HTML that includes a list of likes and/or disliked items
 *
 * @param       array 	$A  	Array of elements containing the row of data for this block
 * @param		string 	$args 	Contains whatever text you place between the two parentheses
 * @return  	string  HTML formatted block containing liked items.
 */
function phpblock_likes($A, $args)
{
	$function = 'LIKES_displayLikesBlock';

	$argsArray = explode(',', $args);
	if (isset($args)) {
		$retval = call_user_func_array($function,$argsArray);
	} else {
		$retval = $function();
	}
	
	if (isset($likesBlock['name'])) {
		return $retval['html'];
	}
	
}

/**
* Returns the Likes Block
*
* @param        int      	$displayAction  LIKES_BLOCK_DISPLAY_LIKE or LIKES_BLOCK_DISPLAY_DISLIKE or LIKES_BLOCK_DISPLAY_ALL
* @param        string      $type     		plugin name
* @param        string      $sub_type 		Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        string      $item_id  item id
* @param        int         $includeTime    Last X seconds to include
* @param        int      	$maxItems       Max items to show in block
* @param        int      	$cacheTime      Cache block for X secionds. 0 = do not cache
* @return       array      	$retval['name'], $retval['title'], $retval['html']
*
*/
function LIKES_displayLikesBlock($displayAction = null, $type = '', $subtype = '', $includeTime = null, $maxItems = null, $cacheTime = null, $newLine = null, $titleLength = null, $configOnly = false)
{
    global $_TABLES, $_CONF, $LANG_LIKES;

	if (is_null($includeTime)) {
		$includeTime = $_CONF['likes_block_include_time'];
	}	
	if (is_null($maxItems)) {
		$maxItems = $_CONF['likes_block_max_items'];
	}
	if (is_null($cacheTime)) {
		$cacheTime = $_CONF['likes_block_cache_time'];
	}
	if (is_null($newLine)) {
		$newLine = $_CONF['likes_block_likes_new_line'];
	}
	if (is_null($titleLength)) {
		$titleLength = $_CONF['likes_block_title_trim_length'];
	}

	$display  = '';
	$useCache = false;
	$retval = [];
	
	// Figure out if likes system actually enabled for user (anonymous or regular user)
	if (!$_CONF['likes_enabled'] || (COM_isAnonUser() && $_CONF['likes_enabled'] == 2)) {
		return $retval;
	}	

	// Check if enabled and get label
	if (!empty($type)) {
		if (PLG_typeLikesEnabled($type, $subtype)) {
			$likesLabel = PLG_typeLikesLabel($type, $subtype);
		} else {
			// Type doesn't exist or is not enabled
			return $retval;
		}
	}	
	
	// Figure out language labels for block based on different settings
    switch ($displayAction) {
        case LIKES_BLOCK_DISPLAY_DISLIKE: 
            $sql_action = " AND action = " . LIKES_ACTION_DISLIKE ." ";
            
			$lang_action_time_span = $LANG_LIKES['dislikes_time_span'];
			if ($includeTime > 0) {
				if (!empty($likesLabel)) {
					$lang_block_title = sprintf($LANG_LIKES['whats_recently_disliked_type'], $likesLabel);
				} else {
					$lang_block_title = $LANG_LIKES['whats_recently_disliked'];
				}
			} else {
				if (!empty($likesLabel)) {
					$lang_block_title = sprintf($LANG_LIKES['whats_disliked_type'], $likesLabel);
				} else {
					$lang_block_title = $LANG_LIKES['whats_disliked'];
				}
			}
			if ($includeTime > 0) {
				$lang_no_items = $LANG_LIKES['no_disliked_items_in_time_limit'];
			} else {
				$lang_no_items = $LANG_LIKES['no_disliked_items'];
			}			
			
			break;
        case LIKES_BLOCK_DISPLAY_ALL:  
			$sql_action = "";
			
			$lang_action_time_span = $LANG_LIKES['all_time_span'];
			if ($includeTime > 0) {
				if (!empty($likesLabel)) {
					$lang_block_title = sprintf($LANG_LIKES['whats_recently_popular_type'], $likesLabel);
				} else {
					$lang_block_title = $LANG_LIKES['whats_recently_popular'];
				}
				
			} else {
				if (!empty($likesLabel)) {
					$lang_block_title = sprintf($LANG_LIKES['whats_popular_type'], $likesLabel);
				} else {
					$lang_block_title = $LANG_LIKES['whats_popular'];
				}
			}
			if ($includeTime > 0) {
				$lang_no_items = $LANG_LIKES['no_action_items_in_time_limit'];
			} else {
				$lang_no_items = $LANG_LIKES['no_action_items'];
			}	
			
            break;
		case LIKES_BLOCK_DISPLAY_LIKE: 
        default:
			$displayAction = LIKES_BLOCK_DISPLAY_LIKE; // Just in case it is using default 
		
			$sql_action = " AND action = " . LIKES_ACTION_LIKE ." ";
			
			$lang_action_time_span = $LANG_LIKES['likes_time_span'];
			if ($includeTime > 0) {
				if (!empty($likesLabel)) {
					$lang_block_title = sprintf($LANG_LIKES['whats_recently_liked_type'], $likesLabel);
				} else {
					$lang_block_title = $LANG_LIKES['whats_recently_liked'];
				}
			} else {
				if (!empty($likesLabel)) {
					$lang_block_title = sprintf($LANG_LIKES['whats_liked_type'], $likesLabel);
				} else {
					$lang_block_title = $LANG_LIKES['whats_liked'];
				}
			}
			if ($includeTime > 0) {
				$lang_no_items = $LANG_LIKES['no_liked_items_in_time_limit'];
			} else {
				$lang_no_items = $LANG_LIKES['no_liked_items'];
			}				
            
            break;
    }
	
	$blockname = "likesblock";
	$blockname .= '__' . $displayAction;
	if (!empty($type)) {
		$blockname .= '_' . $type;
		if (!empty($subtype)) {
			$blockname .= '_' . $subtype;
		}		
	}
	$retval['name'] = $blockname;
	
	$retval['title'] = $lang_block_title;
	if ($configOnly) {
		// Just need name and title
		return $retval;
	}

	// Build or get from cache HTML for block
    if ($cacheTime > 0) {
        $cacheInstance = $blockname . '__' . CACHE_security_hash() . '__' . $_CONF['theme'];
        $display = CACHE_check_instance($cacheInstance);
        if ($display) {
            $lu = CACHE_get_instance_update($cacheInstance);
            $now = time();
            if (($now - $lu) < $cacheTime) {
                $useCache = true;
            }
        }
    }

	if (!$useCache) {
		$display  = ''; // reset display incase has old cached data
		$t = COM_newTemplate(CTL_core_templatePath($_CONF['path_layout'] . 'blocks/'));
		$t->set_file(array('likesblock' => 'likes.thtml'));	
		$t->set_block('likesblock', 'item');
		
		if ($includeTime > 0) {
			$t->set_var('lang_action_time_span', COM_formatTimeString($lang_action_time_span, $includeTime));
		}

		$likesDate = DateTime::createFromFormat('U.u', microtime(true));
		$likesDate->setTimeZone(new DateTimeZone(TimeZoneConfig::getTimezone()));
		$likesDate->sub(new DateInterval('PT' . $includeTime . 'S')); // minus number of seconds
		$includeLikesDate = $likesDate->format("Y-m-d H:i:s"); 
		
		$options = [];

		$sql_daterange = "";
		if ($includeTime > 0) {
			$sql_daterange = " AND created > '{$includeLikesDate}'";
		}
		
		$sql_type = "";
		if (!empty($type)) {
			$sql_type = " AND type = '{$type}' AND subtype = '{$subtype}'";
		}		
		
		// We do not know permissions of items being returned that has likes (or if likes enabled for item) so cannot limit number of rows since some items may not have read permissions for user
		$sql = "SELECT COUNT(lid) actioncount, type, subtype, id, MAX(created) latestdate FROM {$_TABLES['likes']} 
			WHERE 1=1 
			{$sql_type}
			{$sql_action}
			{$sql_daterange}
			GROUP BY type, subtype, id 
			ORDER BY actioncount DESC, latestdate  DESC";

		$result = DB_Query($sql);
		$nrows = DB_numRows($result);

		$listCount = 0;
		$likeItems = array();
		for ($i = 0; $i < $nrows; $i++) {
			$A = DB_fetchArray($result);
			
			// Some items may not be set depending on current permissions set
			// Ie at some point dislikes allowed but currently disabled so do not want to display old ones
			$itemSet = false;
			
			$options['sub_type'] = $A['subtype'];
			$info = PLG_getItemInfo($A['type'], $A['id'], 'url,title,likes', 0, $options);
			
			// If info returned then user has permission to view item
			// If the item type, subtype, id have likes currently enabled
			if (!empty($info[2]) && $info[2] > 0) {
				switch ($displayAction) {
					case LIKES_BLOCK_DISPLAY_DISLIKE: 
						if ($info[2] == 1) {
							// Likes and dislikes enabled for this item
							$t->set_var('item-dislikes', $A['actioncount']);
							$itemSet = true;
						}
						
						break;
					case LIKES_BLOCK_DISPLAY_ALL: 
						$sql_id = " type = '{$A['type']}' AND subtype = '{$A['subtype']}' AND id = '{$A['id']}'";
						
						$sql_action = " AND action = " . LIKES_ACTION_DISLIKE ." ";						
						$dislikeCount = DB_getItem($_TABLES['likes'], 'COUNT(lid) dislikecount', $sql_id . $sql_action .$sql_daterange);
					
						$sql_action = " AND action = " . LIKES_ACTION_LIKE ." ";
						$likeCount = DB_getItem($_TABLES['likes'], 'COUNT(lid) likecount', $sql_id . $sql_action . $sql_daterange);
						
						if ($info[2] == 1) {
							// Likes and Dislikes allowed for items
							$t->set_var('item-dislikes', $dislikeCount);						
							$t->set_var('item-likes', $likeCount);
							$itemSet = true;
						} elseif ($info[2] == 2) {
							// Only Likes
							if ($likeCount > 0) {
								$t->set_var('item-likes', $likeCount);
								$t->set_var('item-dislikes', '');
								$itemSet = true;
							}
						}
						
						break;
					case LIKES_BLOCK_DISPLAY_LIKE:
					default:
						$t->set_var('item-likes', $A['actioncount']);
						$itemSet = true;
						
						break;
				}
				if ($itemSet) {
					$t->set_var('item-link', $info[0]);
					$t->set_var('item-title', $info[1]);
					$t->set_var('item-title-trimmed', COM_truncate($info[1], $titleLength, '...'));
					if ($newLine) {
						$t->set_var('likes-new-line', true);
					}
					
					if ($includeTime > 0) {
						$t->set_var('lang_num_of_likes_in_time_limit', $LANG_LIKES['num_likes_in_time_limit']);
						$t->set_var('lang_num_of_dislikes_in_time_limit', $LANG_LIKES['num_dislikes_in_time_limit']);
					} else {
						$t->set_var('lang_num_of_likes_in_time_limit', $LANG_LIKES['num_likes_total']);
						$t->set_var('lang_num_of_dislikes_in_time_limit', $LANG_LIKES['num_dislikes_total']);
					}

					$t->parse('items', 'item', true);
					
					++$listCount;
					if ($listCount == $maxItems) {
						break;
					}
				}
			} else {
				// User does not have read access to item or doesn't support PLG_getItemInfo
				// $display .= "{$A['type']} {$A['id']} - {$A['actioncount']} - {$A['latestdate']}<br>";
			}
		}

		if ($listCount == 0) {
			$t->set_var('lang_no_items', $lang_no_items);
		}
		
		$display .= $t->parse('output', 'likesblock');
		
		if ($cacheTime > 0) {
			CACHE_create_instance($cacheInstance, $display);
		}
	}

	$retval['html'] = $display;
	
	return $retval;
}

/**
 * Gets config information for dynamic blocks from plugins
 * Returns data for blocks on a given side and, potentially, for
 * a given topic.
 *
 * @param    string $side  Side to get blocks for (right or left for now)
 * @param    string $topic Only get blocks for this topic
 * @return   array           array of block data
 * @link     http://wiki.geeklog.net/index.php/Dynamic_Blocks
 */
function plugin_getBlocksConfig_likes($side, $topic = '')
{
    global $_TABLES, $_CONF, $LANG_LIKES;

    $retval = array();

    $owner_id = SEC_getDefaultRootUser();

	// Check permissions first
    if (SEC_hasAccess($owner_id, $_CONF['likes_block_group_id'], $_CONF['likes_block_permissions'][0], $_CONF['likes_block_permissions'][1], $_CONF['likes_block_permissions'][2], $_CONF['likes_block_permissions'][3])) {
        if (($side == 'left' && $_CONF['likes_block_isleft'] == 1) || ($side == 'right' && $_CONF['likes_block_isleft'] == 0)) {
			
			// Get Title and Name of Block
			$likesBlock = LIKES_displayLikesBlock($_CONF['likes_block_displayed_actions'], $_CONF['likes_block_type'], $_CONF['likes_block_subtype'], $_CONF['likes_block_include_time'], $_CONF['likes_block_max_items'], $_CONF['likes_block_cache_time'],$_CONF['likes_block_likes_new_line'], $_CONF['likes_block_title_trim_length'], true);
			
			if (isset($likesBlock['name'])) {
				$retval[] = array(
					'plugin'         => $LANG_LIKES['likes'],
					'name'           => $likesBlock['name'],
					'title'          => $likesBlock['title'],
					'type'           => 'dynamic',
					'onleft'         => $_CONF['likes_block_isleft'],
					'blockorder'     => $_CONF['likes_block_order'],
					'allow_autotags' => false,
					'help'           => '',
					'enable'         => $_CONF['likes_block_isleft'],
					'topic_option'   => $_CONF['likes_block_topic_option'],
					'topic'          => $_CONF['likes_block_topic'],
					'inherit'        => array(),
				);
			}
        }
    }

    return $retval;
}

/**
* Gets Geeklog blocks from plugins
*
* Returns data for blocks on a given side and, potentially, for
* a given topic.
*
* @param    string  $side   Side to get blocks for (right or left for now)
* @param    string  $topic  Only get blocks for this topic
* @return   array           array of block data
* @link     http://wiki.geeklog.net/index.php/Dynamic_Blocks
*
*/
function plugin_getBlocks_likes($side, $topic = '')
{
    global $_CONF;
	
    $retval = array();

    $owner_id = SEC_getDefaultRootUser();

    // Check permissions first
    if ($_CONF['likes_block_enable'] && SEC_hasAccess($owner_id, $_CONF['likes_block_group_id'], $_CONF['likes_block_permissions'][0], $_CONF['likes_block_permissions'][1], $_CONF['likes_block_permissions'][2], $_CONF['likes_block_permissions'][3])) {
        // Check if right topic
        if (($_CONF['likes_block_topic_option'] == TOPIC_ALL_OPTION) || ($_CONF['likes_block_topic_option'] == TOPIC_HOMEONLY_OPTION && COM_onFrontpage()) || ($_CONF['likes_block_topic_option'] == TOPIC_SELECTED_OPTION && in_array($topic, $_CONF['likes_block_topic']))) {
            if (($side == 'left' && $_CONF['likes_block_isleft'] == 1) || ($side == 'right' && $_CONF['likes_block_isleft'] == 0)) {
                // Create a block
                $likesBlock = LIKES_displayLikesBlock($_CONF['likes_block_displayed_actions'], $_CONF['likes_block_type'], $_CONF['likes_block_subtype'], $_CONF['likes_block_include_time'], $_CONF['likes_block_max_items'], $_CONF['likes_block_cache_time'], $_CONF['likes_block_likes_new_line'], $_CONF['likes_block_title_trim_length']);

				if (isset($likesBlock['name'])) {
					$retval[] = array(
						'name'           => $likesBlock['name'],
						'type'           => 'dynamic',
						'onleft'         => $_CONF['likes_block_isleft'],
						'title'          => $likesBlock['title'],
						'blockorder'     => $_CONF['likes_block_order'],
						'content'        => $likesBlock['html'],
						'allow_autotags' => false,
						'convert_newlines' => false,
						'help'           => '',
						'css_id'         => 'event_block',  // since GL 2.2.0
						'css_classes'    => '',             // since GL 2.2.0
					);
				}
            }
        }
    }

    return $retval;	
}
	
/**
 * Config Manager function
 *
 * @return   array   Array of (groud id, group name) pairs
 */
function configmanager_select_likes_block_group_id_helper()
{
    return SEC_getUserGroups();
}

/**
 * Config Manager function
 *
 * @return   array   Array of (topic id, topic name) pairs
 */
function configmanager_select_likes_block_topic_helper()
{
    return array_flip(TOPIC_getList());
}

/**
 * Likes Autotags
 * [likes_block:aid action:aid wrapper:wid class:likes-autotag type: subtype: time:604800 max:10 cache:3600 line:1 length:20]
 * 	- Displays the Likes block. No attributes are required. If attribute not specified then default in configuration used. 
 * 	- action = 1 (likes only), 2 (dislikes only), or 3 (both) 
 * 	- wrapper = 0 (no wrapper), 1 (block wrapper with title), div wrapper with css class), or both
 * 	- class = Specifies the css class used by the div wrapper if enabled else default likes-autotag will be used 
 * 	- type = Either empty (for all types) or include 1 supported like type. For example 'article' or 'comment'
 * 	- subtype = Specify a sub type of type if needed
 * 	- time = Display items that are this many seconds old. 0 will display all items
 * 	- max = Maximum number of items to display
 * 	- cache = Cached for no longer than this many seconds. If 0 caching is disabled
 * 	- line = Display likes icons on new line
 * 	- length = Trim item title length to this many characters
 *
 * @param  string $op
 * @param  string $content
 * @param  array $autotag
 * @return array|string
 */
function plugin_autotags_likes($op, $content = '', $autotag = array())
{
    global $_CONF, $_TABLES, $_GROUPS, $LANG_LIKES;

    if ($op === 'tagname') {
        return array('likes_block');
    } elseif ($op === 'permission' || $op === 'nopermission') {
        if ($op == 'permission') {
            $flag = true;
        } else {
            $flag = false;
        }
        $tagnames = array();

        if (isset($_GROUPS['Blocks Admin'])) {
            $group_id = $_GROUPS['Blocks Admin'];
        } else {
            $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Blocks Admin'");
        }
        $owner_id = SEC_getDefaultRootUser();

        if (COM_getPermTag($owner_id, $group_id, $_CONF['autotag_permissions_likes_block'][0], $_CONF['autotag_permissions_likes_block'][1], $_CONF['autotag_permissions_likes_block'][2], $_CONF['autotag_permissions_likes_block'][3]) == $flag) {
            $tagnames[] = 'likes_block';
        }

        if (count($tagnames) > 0) {
            return $tagnames;
        }
    } elseif ($op == 'description') {
        return array(
            'likes_block' => $LANG_LIKES['autotag_desc_likes_block']
        );
    } elseif ($op == 'parse') {
		switch ($autotag['tag']) {
			case 'likes_block':
				// Setup defaults
				$displayAction = null; 
				$type = ''; 
				$subtype = '';
				$includeTime = null;
				$maxItems = null;
				$newLine = null;
				$titleLength = null;
				$cacheTime = null;

				// 0 = Nothing
				// 1 = blockheader-child
				// 2 = div wrapper with css class
				// 3 = both
				$wrapper = 3;
				
				$css_class = "likes-autotag";
				
				$parm1 = COM_applyFilter($autotag['parm1']);
				if (is_numeric($parm1) && $parm1 >= 1 && $parm1 <= 3) {
					$displayAction = $parm1;
				}
				
				$px = explode(' ', trim($autotag['parm2']));

				if (is_array($px)) {
					foreach ($px as $part) {
						if (substr($part, 0, 6) == 'class:') {
							$a = explode(':', $part);
							if (!empty($a[1])) {
								$css_class = $a[1];
							}
						} elseif (substr($part, 0, 8) == 'wrapper:') {
							$a = explode(':', $part);
							if (is_numeric($a[1]) && $a[1] >= 0 && $a[1] <= 3) {
								$wrapper = $a[1];
							}							
						} elseif (substr($part, 0, 7) == 'action:') {
							$a = explode(':', $part);
							if (is_numeric($a[1]) && $a[1] >= 1 && $a[1] <= 3) {
								$displayAction = $a[1];
							}
						} elseif (substr($part, 0, 5) == 'type:') {
							$a = explode(':', $part);
							if (!empty($a[1])) {
								$type = $a[1];
							}
						} elseif (substr($part, 0, 8) == 'subtype:') {
							$a = explode(':', $part);
							if (!empty($a[1])) {
								$subtype = $a[1];
							}
						} elseif (substr($part, 0, 5) == 'time:') {
							$a = explode(':', $part);
							if (is_numeric($a[1])) {
								$includeTime = $a[1];
							}
						} elseif (substr($part, 0, 4) == 'max:') {
							$a = explode(':', $part);
							if (is_numeric($a[1])) {
								$maxItems = $a[1];
							}
						} elseif (substr($part, 0, 6) == 'cache:') {
							$a = explode(':', $part);
							if (is_numeric($a[1])) {
								$cacheTime = $a[1];
							}
						} elseif (substr($part, 0, 5) == 'line:') {
							$a = explode(':', $part);
							if (is_numeric($a[1]) && $a[1]) {
								$newLine = true;
							}
						} elseif (substr($part, 0, 7) == 'length:') {
							$a = explode(':', $part);
							if (is_numeric($a[1]) && $a[1] >= 0) {
								$titleLength = $a[1];
							}							
						} else {
							break;
						}
					}
				}

				$retval = LIKES_displayLikesBlock($displayAction, $type, $subtype, $includeTime, $maxItems, $cacheTime, $newLine, $titleLength, false);
				
				if (!empty($retval['title'])) {
					if ($wrapper == 1 || $wrapper == 3) {
						$retval['html'] = COM_startBlock($retval['title'], '', 'blockheader-child.thtml')
							. $retval['html'] . 
							COM_endBlock('blockfooter-child.thtml');
					}

					if ($wrapper >= 2) {
						$retval['html'] = '<div class="' . $css_class . '">' . $retval['html'] . '</div>';
					}
					
					$content = str_replace($autotag['tagstr'], $retval['html'], $content);
				}
				
				break;
		}

		
    }

    return $content;
}

/**
 * A user is about to be deleted. Update ownership of any likes owned
 * by that user or delete them.
 *
 * @param   int $uid User id of deleted user
 */
function plugin_user_delete_likes($uid)
{
    global $_TABLES, $_CONF;
	
    if (DB_count($_TABLES['likes'], 'uid', $uid) == 0) {
        // there are no likes owned by this user
        return;
    }

    DB_query("UPDATE {$_TABLES['likes']} SET uid = 1 WHERE uid = $uid");
}

/**
 * Callback function when an item was deleted
 *
 * @param    string  $id        ID of item being deleted
 * @param    string  $type      type of item ('article', 'staticpages', ...)
 * @param    string  $sub_type  (unused) sub type of item (since Geeklog 2.2.2)
 * @see      PLG_itemDeleted
 */
function plugin_itemdeleted_likes($id, $type, $sub_type)
{
	// Lets make sure all likes are delete for item (we don't know if item even supports likes)
	// This should already be done when item is deleted
	LIKES_deleteActions($type, $sub_type, $id);
}

