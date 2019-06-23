<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +--------------------------------------------------------------------------+
// | Geeklog 2.2                                                              |
// +--------------------------------------------------------------------------+
// | likes.php                                                                |
// |                                                                          |
// | This page handles a Likes action (including the 'AJAX' response)         |
// | Javascript enabled.                                                      |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2019 by the following authors:                             |
// |                                                                          |
// | Tom Homer              tomhomer AT gmail DOT com                         |
// |                                                                          |
// | Copyright (C) 2006-2018 by the following authors:                        |
// |                                                                          |
// | Mark R. Evans          mark AT glfusion DOT org                          |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2006,2007,2008 by the following authors:                   |
// |                                                                          |
// | Authors:                                                                 |
// | Ryan Masuga, masugadesign.com  - ryan@masugadesign.com                   |
// | Masuga Design                                                            |
// |http://masugadesign.com/the-lab/scripts/unobtrusive-ajax-star-rating-bar/ |
// | Komodo Media (http://komodomedia.com)                                    |
// | Climax Designs (http://slim.climaxdesigns.com/)                          |
// | Ben Nolan (http://bennolan.com/behaviour/) for Behavio(u)r!              |
// |                                                                          |
// | Homepage for this script:                                                |
// |http://www.masugadesign.com/the-lab/scripts/unobtrusive-ajax-star-rating-bar/
// +--------------------------------------------------------------------------+
// |                                                                          |
// | Licensed under a Creative Commons Attribution 3.0 License.               |
// | http://creativecommons.org/licenses/by/3.0/                              |
// |                                                                          |
// +--------------------------------------------------------------------------+

require_once 'lib-common.php';

if ( !isset($_CONF['likes_speedlimit']) ) {
    $_CONF['likes_speedlimit'] = 20;
}

// Figure out if ajax call using likes_control.js or call directly from a page
// Call directly from page only would happen if user has javascript disabled (so not likely)
// If not ajax call then just basic functionality of adding action or not and returning to same page
// If not ajax, no messages return good or bad (ie vote message,if speed limit reached, etc...)
// Reason is it is difficult to parse referer to add for example &msg (especially if Rewrite, etc...)
$ajax_call = Geeklog\Input::fGetOrPost('a', '');
if ($ajax_call == "1") {
    $ajax_call = true;
} else {
    $ajax_call = false;    
}
if ($ajax_call) {
    header("Cache-Control: no-cache");
    header("Pragma: nocache");
}

$status = 0;
$type  = Geeklog\Input::fGetOrPost('type', '');
$sub_type  = Geeklog\Input::fGetOrPost('subtype', '');
$id  = Geeklog\Input::fGetOrPost('id', '');
$action  = Geeklog\Input::fGetOrPost('action', '');
$ip         = $_SERVER['REMOTE_ADDR'];
$ratingdate = time();
$uid        = isset($_USER['uid']) ? $_USER['uid'] : 1;

if (!$ajax_call) {
    // validate the referer here - just to be safe....
    $referer = isset($_SERVER['HTTP_REFERER']) ? COM_sanitizeUrl($_SERVER['HTTP_REFERER']) : $_CONF['site_url'];
    if ( $referer == '' ) {
        $referer = $_CONF['site_url'];
    } else {
        // jump down to like user clicked
        $referer .= '#likes-' . $type . '-' . $sub_type . '-' . $id;
    }

    $sLength = strlen($_CONF['site_url']);
    if ( substr($referer,0,$sLength) != $_CONF['site_url'] ) {
        $referer = $_CONF['site_url'];
    }
}

// Confirm a proper type (plugin) is sent (not if you can like it though)
$all_plugins = array_merge($_PLUGINS, array('article', 'comment'));
if (!in_array($type, $all_plugins)) {
    die('no type specified');
}

$likes_setting = PLG_typeLikesEnabled($type, $sub_type);
if (!($likes_setting == 1 OR $likes_setting == 2)) {
    die('likes system not enabled for type');
}

// Confirm a proper action sent
switch ($action) {
    case LIKES_ACTION_LIKE:
    case LIKES_ACTION_UNLIKE:
        break;
    case LIKES_ACTION_DISLIKE:
    case LIKES_ACTION_UNDISLIKE:
        if ($likes_setting == 1) {
            break;
        }
    default:
        die("Sorry, likes system action appears to be invalid or disabled."); // kill the script because normal users will never see this.
}

$action_enabled = PLG_canUserLike($type, $sub_type, $id, $uid, $ip);
if ($action_enabled) {
    // look up the item in our database....
    list($num_likes, $num_dislikes) = LIKES_getLikes($type, $sub_type, $id);

    // Find out if user has voted and what that is (like or dislike)
    $prev_action = LIKES_hasAction($type, $sub_type, $id, $uid, $ip);
    
    // Figure out valid actions
    if (($prev_action == LIKES_ACTION_NONE) AND ($action == LIKES_ACTION_LIKE OR $action == LIKES_ACTION_DISLIKE)) {
        // If user no vote then action like or dislike
    } elseif ($prev_action == LIKES_ACTION_LIKE AND ($action == LIKES_ACTION_UNLIKE OR $action == LIKES_ACTION_DISLIKE)) {
        // If user already liked then action can either unlike or dislike
    } elseif ($prev_action == LIKES_ACTION_DISLIKE AND ($action == LIKES_ACTION_UNDISLIKE OR $action == LIKES_ACTION_LIKE)) {
        // If user already disliked then action can either undislike or like
    } else {
        $status = 1;
    }

    COM_clearSpeedlimit($_CONF['likes_speedlimit'],'likes');
    $last = COM_checkSpeedlimit ('likes');
    if ( $last > 0 ) {
        $speedlimiterror = 1;
        $status = 2;
    } else {
        $speedlimiterror = 0;
    }
  
    if ($status == 0) { // if everything looks good then perform action
        list($num_likes, $num_dislikes) = LIKES_addAction($type, $sub_type, $id, $action, $prev_action, $uid, $ip);
        COM_updateSpeedlimit ('likes');
    }
} else {
    if ($ajax_call) {
        list($num_likes, $num_dislikes) = LIKES_getLikes($type, $sub_type, $id);
        
        $status = 3;
    }
}

if ($ajax_call) {
    $data_type = 0; // 0 = returns likes control, 1 = launches a javascript alert with a passed message
    $data = '';
    if ( $status == 1 ) {
        // current likes action is either already recorded or is not possible (ie user trying to undislike and item that has been liked by the user)
        $data_type = 1;
        if ($uid == 1) {
            $data = $LANG_LIKES['likes_ip_error'];
        } else {
            $data = $LANG_LIKES['likes_uid_error'];
        }
    } elseif ( $status == 2 ) {
        $data_type = 1;
        $data = sprintf($LANG_LIKES['likes_speedlimit'], $last, $_CONF['likes_speedlimit']); 
    } elseif ( $status == 3 ) {
        // no permission for action or you already own the item
        $data_type = 1;
        $data = $LANG_LIKES['own_item_error'];
    } else {
        $message = '';
        if ($action == LIKES_ACTION_LIKE OR $action == LIKES_ACTION_DISLIKE) {
            $message = $LANG_LIKES['thanks_for_action'];
        }    
        
        $data = LIKES_control($type, $sub_type, $id, $likes_setting, $message);
    }

    $retval = array(
        'data_type' => $data_type,
        'data'      => $data
    );
    echo json_encode($retval);
    exit(0);
} else {
    header("Location: " . $referer); // go back to the page we came from
    exit;
}

?>