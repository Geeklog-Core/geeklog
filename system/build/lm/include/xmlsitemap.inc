<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | xmlsitemap.inc                                                            |
// |                                                                           |
// | Update a xmlsitemap language file by merging it with english.php          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2011 by the following authors:                         |
// |                                                                           |
// | Author:  Dirk Haun         - dirk AT haun-online DOT de                   |
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

// save the english text strings
$ENG_XMLSMAP = $LANG_XMLSMAP;

$ENG_configsections['xmlsitemap'] = $LANG_configsections['xmlsitemap'];
$ENG_confignames['xmlsitemap'] = $LANG_confignames['xmlsitemap'];
$ENG_configsubgroups['xmlsitemap'] = $LANG_configsubgroups['xmlsitemap'];
$ENG_tab['xmlsitemap'] = $LANG_tab['xmlsitemap'];
$ENG_fs['xmlsitemap'] = $LANG_fs['xmlsitemap'];
$ENG_configselects['xmlsitemap'] = $LANG_configselects['xmlsitemap'];

// now load the language file we want to update
require_once $langfile;

echo "\nglobal \$LANG32;\n";

mergeArrays($ENG_XMLSMAP, $LANG_XMLSMAP, 'LANG_XMLSMAP', false);

echo "\n";
echo "// Localization of the Admin Configuration UI";

mergeArrays($ENG_configsections['xmlsitemap'], $LANG_configsections['xmlsitemap'], "LANG_configsections['xmlsitemap']", false);
mergeArrays($ENG_confignames['xmlsitemap'], $LANG_confignames['xmlsitemap'], "LANG_confignames['xmlsitemap']", false);
mergeArrays($ENG_configsubgroups['xmlsitemap'], $LANG_configsubgroups['xmlsitemap'], "LANG_configsubgroups['xmlsitemap']", false);
mergeArrays($ENG_tab['xmlsitemap'], $LANG_tab['xmlsitemap'], "LANG_tab['xmlsitemap']", false);
mergeArrays($ENG_fs['xmlsitemap'], $LANG_fs['xmlsitemap'], "LANG_fs['xmlsitemap']", false);
echo "\n";
echo "// Note: entries 0, 1, 9, and 12 are the same as in \$LANG_configselects['Core']";
mergeArrays($ENG_configselects['xmlsitemap'], $LANG_configselects['xmlsitemap'], "LANG_configselects['xmlsitemap']", false);
