<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4.1                                                             |
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
// $Id: lib-mbyte.php,v 1.13 2006/05/20 08:17:16 dhaun Exp $


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

function MBYTE_strpos($hay, $needle, $offset = NULL) {
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

function MBYTE_strtolower($str) {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }  
	if ($mb_enabled) {
		$result = mb_strtolower($str, 'utf-8');
	} else {
		$result = strtolower($str);
	}
	return $result;
}

function MBYTE_eregi($pattern, $str, $regs = NULL) {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }  
	if ($mb_enabled) {
		$result = mb_eregi($pattern, $str, $regs);
	} else {
		$result = eregi($pattern, $str, $regs);
	}
	return $result;
}

function MBYTE_eregi_replace($pattern, $replace, $str) {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }  
	if ($mb_enabled) {
		$result = mb_eregi_replace($pattern, $replace, $str);
	} else {
		$result = eregi_replace($pattern, $replace, $str);
	}
	return $result;
}

/** those are currently not needed in GL, left here if needed later
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
} 

function MBYTE_strtoupper($str) {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }  
	if ($mb_enabled) {
		$result = mb_strtoupper($str, 'utf-8');
	} else {
		$result = strtoupper($str);
	}
	return $result;
}

function MBYTE_strrpos($hay, $needle, $offset='') {
    static $mb_enabled;
    if (!isset($mb_enabled)) {
        $mb_enabled = MBYTE_checkEnabled();
    }  
	if ($mb_enabled) {
		$result = mb_strrpos($hay, $needle, $offset, 'utf-8');
	} else {
		$result = strrpos($hay, $needle, $offset);
	}
	return $result;
}
 
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
} 

*/


/**
mb_decode_mimeheader -- Decode string in MIME header field
mb_decode_numericentity --  Decode HTML numeric string reference to character
mb_encode_mimeheader -- Encode string for MIME header
mb_encode_numericentity --  Encode character to HTML numeric string reference
mb_ereg_match --  Regular expression match for multibyte string
mb_ereg_search_getpos --  Returns start point for next regular expression match
mb_ereg_search_getregs --  Retrieve the result from the last multibyte regular expression match
mb_ereg_search_init --  Setup string and regular expression for multibyte regular expression match
mb_ereg_search_pos --  Return position and length of matched part of multibyte regular expression for predefined multibyte string
mb_ereg_search_regs --  Returns the matched part of multibyte regular expression
mb_ereg_search_setpos --  Set start point of next regular expression match
mb_ereg_search --  Multibyte regular expression match for predefined multibyte string
mb_parse_str --  Parse GET/POST/COOKIE data and set global variable
mb_split -- Split multibyte string using regular expression
mb_strcut -- Get part of string
mb_strimwidth -- Get truncated string with specified width
mb_strrpos --  Find position of last occurrence of a string in a string
mb_strwidth -- Return width of string
mb_substitute_character -- Set/Get substitution character
mb_substr_count -- Count the number of substring occurrences
*/



?>
