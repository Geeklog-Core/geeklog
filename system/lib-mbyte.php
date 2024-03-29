<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | lib-mbyte.php                                                             |
// |                                                                           |
// | function collection to handle mutli-byte related issues                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2022 by the following authors:                         |
// |                                                                           |
// | Authors: Oliver Spiesshofer - oliver AT spiesshofer DOT com               |
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

use Geeklog\LocaleData;

if (stripos($_SERVER['PHP_SELF'], 'lib-mbyte.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Return an array of dropdowns to select a language
 *
 * @param  string  $charset           the default charset of your site, e.g. $_CONF['default_charset']
 * @param  bool    $multilanguage     true in case of a multi-language site
 * @return array                      an array of ['language_file_name' => 'language name']
 * @note   This function is supposed to display only language files in selection dropdowns that are utf-8
 */
function MBYTE_languageList($charset = 'utf-8', $multilanguage = false)
{
    global $_CONF;

    $localeData = new LocaleData();

    return $localeData->getLanguageList(
        $_CONF['path_language'],
        $charset,
        $multilanguage,
        (empty($_CONF['language_files']) ? [] : $_CONF['language_files'])
    );
}

// replacement functions for UTF-8 functions
// $test, $enabled parameters only relevant for the PHPUnit test suite
function MBYTE_checkEnabled($test = '', $enabled = true)
{
    // Always return true, since Geeklog requires PHP's mbstring extension now
    return true;
}


function MBYTE_strlen($str)
{
    return mb_strlen($str);
}

function MBYTE_substr($str, $start, $length = null)
{
    return ($length === null)
        ? mb_substr($str, $start)
        : mb_substr($str, $start, $length);
}

function MBYTE_strpos($haystack, $needle, $offset = null)
{
    return ($offset === null)
        ? mb_strpos($haystack, $needle)
        : mb_strpos($haystack, $needle, $offset);	
}

function MBYTE_strrpos($haystack, $needle, $offset = null)
{
    return ($offset === null)
        ? mb_strrpos($haystack, $needle)
        : mb_strrpos($haystack, $needle, $offset);
}

function MBYTE_strtolower($str)
{
    return mb_strtolower($str);
}

function MBYTE_eregi($pattern, $str, &$regs = null)
{
    return mb_eregi($pattern, $str, $regs);
}

function MBYTE_eregi_replace($pattern, $replace, $str)
{
    return mb_eregi_replace($pattern, $replace, $str);
}

/**
 * @since Geeklog-2.1.1
 */
function MBYTE_stripos($haystack, $needle, $offset = null)
{
    return mb_stripos($haystack, $needle, $offset);
}

/**
 * @since Geeklog-2.1.1
 */
function MBYTE_strtoupper($str)
{
    return mb_strtoupper($str);
}

/**
 * @since Geeklog-2.1.1
 */
function MBYTE_substr_count($haystack, $needle)
{
    return mb_substr_count($haystack, $needle);
}

/** those are currently not needed in GL, left here if needed later
 *
 * function MBYTE_mail($to, $subj, $mess, $header = NULL, $param = NULL)
 * {
 * static $mb_enabled;
 *
 * if (!isset($mb_enabled)) {
 * $mb_enabled = MBYTE_checkEnabled();
 * }
 * if ($mb_enabled) {
 * if (mb_language('uni')) {
 * $result = mb_send_mail($to, $subj, $mess, $header, $param);
 * } else {
 * $result = false;
 * }
 * } else {
 * $result = mail($to, $subj, $mess, $header, $param);
 * }
 * return $result;
 * }
 */


/**
 * mb_decode_mimeheader -- Decode string in MIME header field
 * mb_decode_numericentity --  Decode HTML numeric string reference to character
 * mb_encode_mimeheader -- Encode string for MIME header
 * mb_encode_numericentity --  Encode character to HTML numeric string reference
 * mb_ereg_match --  Regular expression match for multibyte string
 * mb_ereg_search_getpos --  Returns start point for next regular expression match
 * mb_ereg_search_getregs --  Retrieve the result from the last multibyte regular expression match
 * mb_ereg_search_init --  Setup string and regular expression for multibyte regular expression match
 * mb_ereg_search_pos --  Return position and length of matched part of multibyte regular expression for predefined
 * multibyte string mb_ereg_search_regs --  Returns the matched part of multibyte regular expression
 * mb_ereg_search_setpos --  Set start point of next regular expression match mb_ereg_search --  Multibyte regular
 * expression match for predefined multibyte string mb_parse_str --  Parse GET/POST/COOKIE data and set global variable
 * mb_split -- Split multibyte string using regular expression mb_strcut -- Get part of string mb_strimwidth -- Get
 * truncated string with specified width mb_strrpos --  Find position of last occurrence of a string in a string
 * mb_strwidth -- Return width of string mb_substitute_character -- Set/Get substitution character
 */

// Now, Geeklog requires PHP's mbstring extension
mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');
mb_regex_set_options('l');      // The longest (= greedy) match
