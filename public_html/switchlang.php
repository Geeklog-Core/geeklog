<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | switchlang.php                                                            |
// |                                                                           |
// | Switch the user's language                                                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006 by the following authors:                              |
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
// $Id: switchlang.php,v 1.1 2006/03/07 14:56:04 dhaun Exp $

require_once ('lib-common.php');

/**
* Switch language in a URL.
*
* @param    string  $url        current URL
* @param    string  $newlang    new language to switch to
* @param    string  $oldlang    old, i.e. current language
* @return   string              new URL after the language switch
*
*/
function switch_language ($url, $newlang, $oldlang)
{
    global $_CONF;

    $retval = '';

    if (empty ($newlang) || empty ($oldlang) ||
            (strlen ($newlang) != strlen ($oldlang))) {
        return $url;
    }

    $lang_len = strlen ($oldlang);
    if ((strpos ($url, '&') === false)  && $_CONF['url_rewrite']) {
        // for "rewritten" URLs we assume that the first parameter after
        // the script name is the ID, e.g. /article.php/story-id-here_en
        $changed = false;
        $p = explode ('/', $url);
        for ($i = 0; $i < count ($p); $i++) {
            if (substr ($p[$i], -4) == '.php') {
                // found the script name - assume next parameter is the ID
                if (isset ($p[$i + 1])) {
                    if (substr ($p[$i + 1], -($lang_len + 1)) == '_' . $oldlang) {
                        $p[$i + 1] = substr_replace ($p[$i + 1], $newlang,
                                                     -$lang_len);
                        $changed = true;
                    }
                }
                break;
            }
        }
        if ($changed) {
            // merge the pieces back together
            $url = implode ('/', $p);
        }

        $retval = $url;
    } else { // URL contains '&'
        $url = split ('&', $url);
        $extra_vars = '&' . $url[1];
        $url = $url[0];

        if (substr ($url, -($lang_len + 1)) == '_' . $oldlang) {
            $url = substr_replace ($url, $newlang, -$lang_len);
        }

        $retval = $url . $extra_vars;
    }

    return $retval;
}


// MAIN
$ret_url = '';
if (isset ($_SERVER['HTTP_REFERER'])) {
    if (strpos ($_SERVER['HTTP_REFERER'], $_CONF['site_url']) !== false) {
        $ret_url = $_SERVER['HTTP_REFERER'];
    }
}

// if not allowed, just ignore and return
if ($_CONF['allow_user_language'] == 1) {

    COM_setArgNames (array ('lang'));

    $lang = strtolower (COM_applyFilter (COM_getArgument ('lang')));
    $lang = preg_replace( '/[^a-z0-9\-_]/', '', $lang );
    $oldlang = COM_getLanguageId ();

    // do we really have a new language to switch to?
    if (!empty ($lang) && array_key_exists ($lang, $_CONF['language_files'])) {

        // does such a language file exist?
        $langfile = $_CONF['language_files'][$lang];
        if (is_file ($_CONF['path_language'] . $langfile . '.php')) {

            // Set the language cookie.
            // Mainly used for the anonymous user so the rest of this session
            // will remain in their selected language
            setcookie ($_CONF['cookie_language'], $langfile, time() + 31536000,
                       $_CONF['cookie_path'], $_CONF['cookiedomain'],
                       $_CONF['cookiesecure']);

            // if user is not anonymous, store the preference in the database
            if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
                DB_query ("UPDATE {$_TABLES['users']} SET language = '{$langfile}' WHERE uid = {$_USER['uid']}");
            }
        }
    }

    // Change the language ID if needed
    if (!empty ($ret_url) && !empty ($lang) && !empty ($oldlang)) {
        $ret_url = switch_language ($ret_url, $lang, $oldlang);
    }
}

// if the user didn't come from our site, send them to our index page
if (empty ($ret_url)) {
    $ret_url = $_CONF['site_url'] . '/';
}

header ("Location: $ret_url");

?>
