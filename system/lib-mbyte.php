<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | lib-multibyte.php                                                         |
// |                                                                           |
// | function collection to handle mutli-byte related issues                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2006 by the following authors:                         |
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
//
// $Id: lib-mbyte.php,v 1.6 2006/05/15 06:21:49 ospiess Exp $


// This function is supposed to display only language files in selection drop-
// downs that are utf-8
function MBYTE_languageList() { 
  	global $_CONF;

    $language = array ();
    $fd = opendir ($_CONF['path_language']);
    
    while (($file = @readdir ($fd)) !== false) {
        if ((substr ($file, 0, 1) != '.') && preg_match ('/\.php$/i', $file)
                && is_file ($_CONF['path_language'] . $file)
                && (strstr($file, '_utf-8'))) {
            clearstatcache ();
            $file = str_replace ('.php', '', $file);
            $uscore = strpos ($file, '_');
            if ($uscore === false) {
                $lngname = ucfirst ($file);
            } else {
                $lngname = ucfirst (substr ($file, 0, $uscore));
                $lngadd = substr ($file, $uscore + 1);
                $lngadd = str_replace ('_', ', ', $lngadd);
                $word = explode (' ', $lngadd);
                $lngadd = '';
                foreach ($word as $w) {
                    if (preg_match ('/[0-9]+/', $w)) {
                        $lngadd .= strtoupper ($w) . ' ';
                    } else {
                        $lngadd .= ucfirst ($w) . ' ';
                    }
                }
                $lngname .= ' (' . trim ($lngadd) . ')';
            }
			$language[$file] = $lngname; 
        }
    }
    asort ($language);
  	return $language;
}

// replacement functions for UTF-8 functions
function MBYTE_checkEnabled() {
    static $mb_enabled;
    if (function_exists( 'mb_substr' )) {
        $mb_enabled = true;
    } else {
        $mb_enabled = false;
    }
    return $mb_enabled;
}


function MBYTE_strlen($str) {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }
	if ($mb_enabled) {
		$result = mb_strlen($str, 'utf-8');
	} else {
		$result = strlen($str);
	}
	return $result;	
}

function MBYTE_substr($str, $start, $length = NULL) {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }
	if ($mb_enabled) {
		$result = mb_substr($str, $start, $length, 'utf-8');
	} else {
		$result = substr($str, $start, $length);
	}
	return $result;	
}

/** this one is currently not needed in GL, left here if needed later
function MBYTE_substr_count($hay, $needle) {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }
	if ($mb_enabled) {
		$result = mb_substr_count($hay, $needle, 'utf-8');
	} else {
		$result = substr_count($hay, $needle);
	}
	return $result;
} */

function MBYTE_strpos($hay, $needle, $offset='') {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }  
	if ($mb_enabled) {
		$result = mb_strpos($hay, $needle, $offset, 'utf-8');
	} else {
		$result = strpos($hay, $needle, $offset);
	}
	return $result;
}

/** Not needed either? Mail is handled by PEAR 
function MBYTE_mail($to, $subj, $mess, $header = NULL, $param = NULL) {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }
	if ($mb_enabled) {
	  	if (mb_language('uni')) {
			$result = mb_send_mail($to, $subj, $mess, $header, $param);
		} else {
			$result = false;
		}
	} else {
		$result = mail($to, $subj, $mess, $header, $param);
	}
	return $result;
} **/


/**
mb_convert_case -- Perform case folding on a string
mb_decode_mimeheader -- Decode string in MIME header field
mb_decode_numericentity --  Decode HTML numeric string reference to character
mb_encode_mimeheader -- Encode string for MIME header
mb_encode_numericentity --  Encode character to HTML numeric string reference
mb_ereg_match --  Regular expression match for multibyte string
mb_ereg_replace -- Replace regular expression with multibyte support
mb_ereg_search_getpos --  Returns start point for next regular expression match
mb_ereg_search_getregs --  Retrieve the result from the last multibyte regular expression match
mb_ereg_search_init --  Setup string and regular expression for multibyte regular expression match
mb_ereg_search_pos --  Return position and length of matched part of multibyte regular expression for predefined multibyte string
mb_ereg_search_regs --  Returns the matched part of multibyte regular expression
mb_ereg_search_setpos --  Set start point of next regular expression match
mb_ereg_search --  Multibyte regular expression match for predefined multibyte string
mb_ereg -- Regular expression match with multibyte support
mb_eregi_replace --  Replace regular expression with multibyte support ignoring case
mb_eregi --  Regular expression match ignoring case with multibyte support
mb_get_info -- Get internal settings of mbstring
mb_list_encodings --  Returns an array of all supported encodings
mb_parse_str --  Parse GET/POST/COOKIE data and set global variable
mb_split -- Split multibyte string using regular expression
mb_strcut -- Get part of string
mb_strimwidth -- Get truncated string with specified width
mb_strpos --  Find position of first occurrence of string in a string
mb_strrpos --  Find position of last occurrence of a string in a string
mb_strtolower -- Make a string lowercase
mb_strtoupper -- Make a string uppercase
mb_strwidth -- Return width of string
mb_substitute_character -- Set/Get substitution character
mb_substr_count -- Count the number of substring occurrences

*/



?>