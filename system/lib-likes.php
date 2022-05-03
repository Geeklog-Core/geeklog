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
 * Constants used for storing Likes actions
 */

define('LIKES_ACTION_NONE', 0); // Also considered a delete by PLG_itemLike
define('LIKES_ACTION_LIKE', 1);
define('LIKES_ACTION_DISLIKE', 2);
define('LIKES_ACTION_UNLIKE', 3);
define('LIKES_ACTION_UNDISLIKE', 4);

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
	if ($num_likes > 0) {
		$likes_templates->set_var('lang_num_of_likes', LIKES_numberTooltip($type, $sub_type, $item_id, LIKES_ACTION_LIKE));
	}
    if ($dislike) {
        $likes_templates->set_var('num_of_dislikes', LIKES_formatNum($num_dislikes));
		if ($num_dislikes > 0) {
			$likes_templates->set_var('lang_num_of_dislikes', LIKES_numberTooltip($type, $sub_type, $item_id, LIKES_ACTION_DISLIKE));		
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
    }

	if ($_LIKES_DEBUG) {
		COM_errorLog("Likes Previous Action Detected = $prev_action for type '$type' with id '$item_id' for user id $uid", 1);
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
            $sql = DB_query(
                "SELECT L.seq FROM {$_TABLES['likes']} AS L "
                . "LEFT JOIN {$_TABLES['ip_addresses']} AS i "
                . "ON L.seq = i.seq "
                . "WHERE L.type = '$escType' AND L.subtype='$escSubType' AND L.id = '$escItemId' AND L.uid = 1 AND i.ipaddress = '$escIp'"
            );
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
    global $_TABLES, $_CONF, $_CA_CONF, $LANG_CAL_1;

    $retval = array();

	/*
    $owner_id = SEC_getDefaultRootUser();

    // Check permissions first
    if (SEC_hasAccess($owner_id, $_CA_CONF['block_group_id'], $_CA_CONF['block_permissions'][0], $_CA_CONF['block_permissions'][1], $_CA_CONF['block_permissions'][2], $_CA_CONF['block_permissions'][3])) {
        if (($side == 'left' && $_CA_CONF['block_isleft'] == 1) || ($side == 'right' && $_CA_CONF['block_isleft'] == 0)) {
            $retval[] = array(
                'plugin'         => $LANG_CAL_1[16],
                'name'           => 'events',
                'title'          => $LANG_CAL_1[50],
                'type'           => 'dynamic',
                'onleft'         => $_CA_CONF['block_isleft'],
                'blockorder'     => $_CA_CONF['block_order'],
                'allow_autotags' => false,
                'help'           => '',
                'enable'         => $_CA_CONF['block_enable'],
                'topic_option'   => $_CA_CONF['block_topic_option'],
                'topic'          => $_CA_CONF['block_topic'],
                'inherit'        => array(),
            );
        }
    }
	*/

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
    global $_TABLES, $_CONF, $CONF_FORUM, $LANG_GF01, $FORUM_CSS;

    $retval = array();
	return $retval;
	/*
	// Needs to be cached
	$cacheInstance = 'likes__likesblock_' . CACHE_security_hash() . '_' . $_CONF['theme'];
	$retval = CACHE_check_instance($cacheInstance);
	if ($retval) {
		return $retval;
	}	
	*/

	// Likes Block
	// Last X Seconds
	// Show Likes and/or Dislikes
	// Show only for users that can see Likes
	// Show for only content that has likes enabled
	// SHow newest first
	
	// Read access to content like is for?
	// loop through the list and then check permissions with something like PLG_getItemInfo so caching would be required.
	
	// Figure out cutoff date
	// 1 day = 86400
	// 1 week = 604800
	// 4 weeks = 2419200
	// 12 weeks = 7257600
	$_CONF['likes_block_include_time'] = 7257600;
	$_CONF['likes_block_max_items'] = 10;

	$likesDate = DateTime::createFromFormat('U.u', microtime(true));
	$likesDate->sub(new DateInterval('PT' . $_CONF['likes_block_include_time'] . 'S')); // minus number of seconds
	$includeLikesDate = $likesDate->format("Y-m-d H:i:s"); 
	
	$display  = '';
	$options = [];

	
	// We do not know permissions of items being returned that has likes (or if likes enabled for item) so cannot limit number of rows since some items may not have read permissions for user
	$sql = "SELECT COUNT(lid) actioncount, type, subtype, id, MAX(created) latestdate FROM {$_TABLES['likes']} 
		WHERE action = " . LIKES_ACTION_LIKE ." 
		AND created > '{$includeLikesDate}'
		GROUP BY type, subtype, id
		ORDER BY latestdate  DESC";
	
	$result = DB_Query($sql);
	$nrows = DB_numRows($result);

	$listCount = 0;
	for ($i = 0; $i < $nrows; $i++) {
		$A = DB_fetchArray($result);
		
		$options['sub_type'] = $A['subtype'];
		$info = PLG_getItemInfo($A['type'], $A['id'], 'url,title,likes', 0, $options);
		
		// If info returned then user has permission to view item
		// If the item type, subtype, id have likes currently enabled
		if (!empty($info[2]) && $info[2] > 0) {
			$display .= '<a href="' . $info[0] . '">' . $info[1] . "</a> - {$A['actioncount']} - {$A['latestdate']}<br>";
			
			++$listCount;
			if ($listCount == $_CONF['likes_block_max_items']) {
				break;
			}
		} else {
			// User does not have read access to item or doesn't support PLG_getItemInfo
			$display .= "{$A['type']} {$A['id']} - {$A['actioncount']} - {$A['latestdate']}<br>";
		}
	}
	

	// CACHE_create_instance($cacheInstance, $display);

	
	$retval[] = array('name'           => 'likes_most',
					  'type'           => 'dynamic',
					  'onleft'         => true,
					  'title'          => 'Likes Block',
					  'blockorder'     => 2,
					  'content'        => $display,
					  'allow_autotags' => false,
					  'convert_newlines' => false,
					  'css_id' 		   => 'gl-blockLikes', // Used to jump to block position
					  'help'           => '');	
	
	
	return $retval;
}
