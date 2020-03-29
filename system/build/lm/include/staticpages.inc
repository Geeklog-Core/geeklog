<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | staticpages.inc                                                           |
// |                                                                           |
// | Update a staticpages language file by merging it with english.php         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2011 by the following authors:                         |
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
$ENG_STATIC = $LANG_STATIC;
$ENG_staticpages_search = $LANG_staticpages_search;

$ENG_MSG15 = $PLG_staticpages_MESSAGE15;
$ENG_MSG19 = $PLG_staticpages_MESSAGE19;
$ENG_MSG20 = $PLG_staticpages_MESSAGE20;
$ENG_MSG21 = $PLG_staticpages_MESSAGE21;
$ENG_MSG22 = $PLG_staticpages_MESSAGE22;
$ENG_MSG3001 = $PLG_staticpages_MESSAGE3001;

$ENG_configsections['staticpages'] = $LANG_configsections['staticpages'];
$ENG_confignames['staticpages'] = $LANG_confignames['staticpages'];
$ENG_configsubgroups['staticpages'] = $LANG_configsubgroups['staticpages'];
$ENG_tab['staticpages'] = $LANG_tab['staticpages'];
$ENG_fs['staticpages'] = $LANG_fs['staticpages'];
$ENG_configselects['staticpages'] = $LANG_configselects['staticpages'];

// now load the language file we want to update
require_once $langfile;

echo "\nglobal \$LANG32;\n\n";

separator();
echo "# Array Format:\n";
echo "# \$LANGXX[YY]:  \$LANG - variable name\n";
echo "#               XX    - file id number\n";
echo "#               YY    - phrase id number\n";
separator();

mergeArrays($ENG_STATIC, $LANG_STATIC, 'LANG_STATIC', false);
mergeArrays($ENG_staticpages_search, $LANG_staticpages_search, 'LANG_staticpages_search', false);

echo "\n";
mergeString($ENG_MSG15, $PLG_staticpages_MESSAGE15, 'PLG_staticpages_MESSAGE15');
mergeString($ENG_MSG19, $PLG_staticpages_MESSAGE19, 'PLG_staticpages_MESSAGE19');
mergeString($ENG_MSG20, $PLG_staticpages_MESSAGE20, 'PLG_staticpages_MESSAGE20');
mergeString($ENG_MSG21, $PLG_staticpages_MESSAGE21, 'PLG_staticpages_MESSAGE21');
mergeString($ENG_MSG22, $PLG_staticpages_MESSAGE22, 'PLG_staticpages_MESSAGE22');

echo "\n";
echo "// Messages for the plugin upgrade\n";
mergeString($ENG_MSG3001, $PLG_staticpages_MESSAGE3001, 'PLG_staticpages_MESSAGE3001');
echo "\$PLG_staticpages_MESSAGE3002 = \$LANG32[9];\n";

echo "\n";
echo "// Localization of the Admin Configuration UI";

mergeArrays($ENG_configsections['staticpages'], $LANG_configsections['staticpages'], "LANG_configsections['staticpages']", false);
mergeArrays($ENG_confignames['staticpages'], $LANG_confignames['staticpages'], "LANG_confignames['staticpages']", false);
mergeArrays($ENG_configsubgroups['staticpages'], $LANG_configsubgroups['staticpages'], "LANG_configsubgroups['staticpages']", false);
mergeArrays($ENG_tab['staticpages'], $LANG_tab['staticpages'], "LANG_tab['staticpages']", false);
mergeArrays($ENG_fs['staticpages'], $LANG_fs['staticpages'], "LANG_fs['staticpages']", false);
echo "\n";
echo "// Note: entries 0, 1, 9, 12, 17 are the same as in \$LANG_configselects['Core']";
mergeArrays($ENG_configselects['staticpages'], $LANG_configselects['staticpages'], "LANG_configselects['staticpages']", false);
