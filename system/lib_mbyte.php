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
// $Id: lib_mbyte.php,v 1.1 2006/03/28 06:15:11 ospiess Exp $


// This function is supposed to display only language files in selection drop-
// downs that are compatible with the default language encoding
function MBYTE_languageList() { 
  	global $_CONF;
  	 
  	$def_charset = $_CONF['default_charset'];
    $language = array ();
    $fd = opendir ($_CONF['path_language']);
    
    while (($file = @readdir ($fd)) !== false) {

		if ($_CONF['allow_mixed_charsets']) {
			$filter = true;  
		} else {
		  	$filter = strstr($file, $def_charset);
		}	
        if ((substr ($file, 0, 1) != '.') && preg_match ('/\.php$/i', $file)
                && is_file ($_CONF['path_language'] . $file)
				&& ($filter)) {
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

?>