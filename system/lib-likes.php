<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +--------------------------------------------------------------------------+
// | Geeklog 2.2                                                              |
// +--------------------------------------------------------------------------+
// | lib-likes.php                                                            |
// |                                                                          |
// | Likes System                                                             |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2019 by the following authors:                             |
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

/**
 * Related Plugin Library functions
 */
// PLG_typeLikesEnabled, PLG_canUserLike, PLG_itemLike

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
* @param        string      $id                 item id
* @param        int         $likes_setting      if 2 dislikes will not be displayed
* @param        string      $message            language string of message to pass to user
* @return       string      html of the likes control
*
*/
function LIKES_control($type, $sub_type = '', $id, $likes_setting, $message = '') {
    global $_USER, $_CONF, $LANG_LIKES, $_SCRIPTS;

    // Figure out if dislike is enabled or not
    $dislike = true;
    if ($likes_setting == 2) {
        $dislike = false;
    }

    list($num_likes, $num_dislikes) = LIKES_getLikes($type, $sub_type, $id);

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
    $likes_templates->set_var('item_id', $id);

    $uid = isset($_USER['uid']) ? $_USER['uid'] : 1;
    $ip = $_SERVER['REMOTE_ADDR'];

    $action_enabled = PLG_canUserLike($type, $sub_type, $id, $uid, $ip);

    $likes_templates->set_var('dislike_enabled', $dislike);
    $likes_templates->set_var('action_enabled', $action_enabled);

    if ($action_enabled) {
        $prev_action = LIKES_hasAction($type, $sub_type, $id, $uid, $ip);
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
    //$message .= " t=".$type." st=".$sub_type." i=".$id." u=".$uid." a=".$action_enabled;

    $likes_templates->set_var('lang_message', $message);

    $likes_templates->set_var('num_of_likes', LIKES_formatNum($num_likes));
    if ($dislike) {
        $likes_templates->set_var('num_of_dislikes', LIKES_formatNum($num_dislikes));
    }

    $likes_templates->parse('output', 'likes_control');
    $retval = $likes_templates->finish($likes_templates->get_var('output'));

    return $retval;
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
function LIKES_getLikes($type, $sub_type = '', $item_id)
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
function LIKES_hasAction($type, $sub_type = '', $item_id, $uid, $ip)
{
    global $_TABLES;

    $prev_action = LIKES_ACTION_NONE;

    if ($uid == 1) {
        $sql = "SELECT action FROM {$_TABLES['likes']} WHERE uid=1 AND ipaddress='".DB_escapeString($ip)."' AND type='".DB_escapeString($type)."' AND subtype='" . DB_escapeString($sub_type) . "' AND id='".DB_escapeString($item_id)."'";
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

    return $prev_action;
}

/**
* Removes all likes actions for an item
*
* @param        string      $type     plugin name
* @param        string      $sub_type Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        string      $item_id  item id
* @return       none
*
*/
function LIKES_deleteActions($type, $sub_type = '', $item_id)
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
* @param        int         $uid      user id of voter
* @param        string      $ip       IP address of voter
* @return       array       an array with the new overall number of likes and dislikes.
*
*/
function LIKES_addAction($type, $sub_type = '', $item_id, $action, $prev_action, $uid, $ip)
{
    global $_TABLES;

    // Assume all previous checks done on passed in variables including if $action and $past_action are compatible with each other

    // Delete any previous action if exist
    if ($prev_action != LIKES_ACTION_NONE) {
        $sql = "DELETE FROM {$_TABLES['likes']} WHERE type = '" . DB_escapeString($type) . "' AND subtype='" . DB_escapeString($sub_type) . "' AND id = '" . DB_escapeString($item_id) . "' ";
        if ($uid > 1) {
            $sql .= "AND uid = " . $uid;
        } else {
            $sql .= "AND uid = 1 AND ipaddress = '" . DB_escapeString($ip) ."'";
        }

        DB_query($sql);
    }

    // Now Insert new action if like or dislike
    if ($action == LIKES_ACTION_LIKE OR $action == LIKES_ACTION_DISLIKE) {
        $sql = "INSERT INTO {$_TABLES['likes']} (type, subtype, id, uid, ipaddress, action, created) " .
               "VALUES ('" . DB_escapeString($type) . "', '" . DB_escapeString($sub_type) . "', '" . DB_escapeString($item_id) . "', " . $uid . ", '" . DB_escapeString($ip) . "', " . $action . ", CURRENT_TIMESTAMP);";

        DB_query($sql);
    }

    // Let plugin know about like action
    PLG_itemLike($type, $sub_type, $item_id, $action);

    // Get new counts and return
    return LIKES_getLikes($type, $sub_type, $item_id);
}

/**
* Return number of likes or dislikes for a type, sub type, and id(s)
*
* @param        int         $action   like or dislike action
* @param        string      $type     plugin name
* @param        string      $sub_type Sub type of plugin to allow plugins to have likes for more than one type of item (not required)
* @param        array       $item_ids  item id
* @param        int         $uid      user id of voter
* @param        string      $ip       IP address of voter
* @return       array       an array with the new overall number of likes and dislikes.
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
