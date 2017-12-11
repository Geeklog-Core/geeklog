<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | switchlang.php                                                            |
// |                                                                           |
// | Switch the user's language                                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun         - dirk AT haun-online DOT de                   |
// |          based on earlier works by Euan McKay and LWC                     |
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
//
// $Id: switchlang.php,v 1.4 2008/09/14 09:17:41 dhaun Exp $

require_once 'lib-common.php';

/**
* Switch language in a URL.
*
* @param    string  $url        current URL
* @param    string  $newLang    new language to switch to
* @param    string  $oldLang    old, i.e. current language
* @return   string              new URL after the language switch
*/
function switch_language($url, $newLang, $oldLang, $itemId, $itemType)
{
    global $_CONF, $_URL;
    
    // See if we need to figure out new URL (ie is url language specific and are any variables missing)
    if (empty($itemType) || empty($itemId) || empty($newLang) || empty($oldLang) || (strlen($newLang) !== strlen($oldLang))) {
        return $url;
    }
    
    $retval = "";
    
    // Technically we don't care about if normal url, rewrite url, or routed url as id will be the same
    // Still not 100% perfect search solution as other variables in string may have the exact same id (though highly unlikely)
    $pos = strrpos($itemId, "_");
    if ($pos) {
        $newItemId = substr($itemId, 0, $pos) . '_' . $newLang;
        
        if ($_CONF['switchlang_homepage']) {
            // Figure out if new item exists or user has access
            $newItemId = PLG_getItemInfo($itemType, $newItemId, 'id'); // if it does the id will be returned
        }
        
        if (!(empty($newItemId))) {
            $retval = str_replace($itemId, $newItemId, $url);
        } else {
            // Doesn't exist so homepage
            $retval = $_CONF['site_url'] . '/';
        }
    } else {
        // Something went wrong so just return original url
        $retval = $url;
    }
    
    return $retval;
}

// MAIN
$ret_url = '';
if (isset($_SERVER['HTTP_REFERER']) &&
    (strpos($_SERVER['HTTP_REFERER'], $_CONF['site_url']) !== false)) {
    $ret_url = $_SERVER['HTTP_REFERER'];
}

// if not allowed, just ignore and return
if ($_CONF['allow_user_language'] == 1) {
    COM_setArgNames(array('lang'));

    $lang = strtolower(COM_applyFilter(COM_getArgument('lang')));
    $lang = preg_replace('/[^a-z0-9\-_]/', '', $lang);
    $oldLang = COM_getLanguageId();
    $itemId = Geeklog\Input::fRequest('itemid', '');
    $itemType = Geeklog\Input::fRequest('itemtype', '');
    
    // do we really have a new language to switch to?
    if (!empty($lang) && array_key_exists($lang, $_CONF['language_files'])) {
        // does such a language file exist?
        $langFile = $_CONF['language_files'][$lang];

        if (is_file($_CONF['path_language'] . $langFile . '.php')) {
            // Set the language cookie.
            // Mainly used for anonymous users so the rest of their session
            // will remain in the selected language
            setcookie(
                $_CONF['cookie_language'], $langFile, time() + 31536000, 
                $_CONF['cookie_path'], $_CONF['cookiedomain'], $_CONF['cookiesecure']
            );

            // if user is not anonymous, store the preference in the database
            if (!COM_isAnonUser()) {
                DB_query("UPDATE {$_TABLES['users']} SET language = '" . DB_escapeString($langFile) . "' WHERE uid = {$_USER['uid']}");
            }
        }
    }

    // Change the language ID if needed
    if (!empty($ret_url) && !empty($lang) && !empty($oldLang)) {
        $ret_url = switch_language($ret_url, $lang, $oldLang, $itemId, $itemType);
    }
}

// if the user didn't come from our site, send them to our index page
if (empty($ret_url)) {
    $ret_url = $_CONF['site_url'] . '/';
}

header("Location: $ret_url");
