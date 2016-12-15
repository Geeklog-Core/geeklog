<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | links.inc                                                                 |
// |                                                                           |
// | Update a links language file by merging it with english.php               |
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
$ENG_LINKS = $LANG_LINKS;
$ENG_STATS = $LANG_LINKS_STATS;
$ENG_SEARCH = $LANG_LINKS_SEARCH;
$ENG_SUBMIT = $LANG_LINKS_SUBMIT;
$ENG_ADMIN = $LANG_LINKS_ADMIN;
$ENG_STATUS = $LANG_LINKS_STATUS;

$ENG_MSG1 = $PLG_links_MESSAGE1;
$ENG_MSG2 = $PLG_links_MESSAGE2;
$ENG_MSG3 = $PLG_links_MESSAGE3;
$ENG_MSG4 = $PLG_links_MESSAGE4;
$ENG_MSG5 = $PLG_links_MESSAGE5;
$ENG_MSG6 = $PLG_links_MESSAGE6;
$ENG_MSG7 = $PLG_links_MESSAGE7;
$ENG_MSG10 = $PLG_links_MESSAGE10;
$ENG_MSG11 = $PLG_links_MESSAGE11;
$ENG_MSG12 = $PLG_links_MESSAGE12;
$ENG_MSG13 = $PLG_links_MESSAGE13;
$ENG_MSG14 = $PLG_links_MESSAGE14;
$ENG_MSG15 = $PLG_links_MESSAGE15;
$ENG_MSG16 = $PLG_links_MESSAGE16;
$ENG_MSG17 = $PLG_links_MESSAGE17;
$ENG_MSG3001 = $PLG_links_MESSAGE3001;

$ENG_configsections['links'] = $LANG_configsections['links'];
$ENG_confignames['links'] = $LANG_confignames['links'];
$ENG_configsubgroups['links'] = $LANG_configsubgroups['links'];
$ENG_tab['links'] = $LANG_tab['links'];
$ENG_fs['links'] = $LANG_fs['links'];
$ENG_configselects['links'] = $LANG_configselects['links'];

// now load the language file we want to update
require_once $langfile;

echo "\nglobal \$LANG32;\n\n";

separator();
echo "# Array Format:\n";
echo "# \$LANGXX[YY]:  \$LANG - variable name\n";
echo "#               XX    - file id number\n";
echo "#               YY    - phrase id number\n";
separator();

mergeArrays($ENG_LINKS, $LANG_LINKS, 'LANG_LINKS', false);
echo "\n";
mergeArrays($ENG_STATS, $LANG_LINKS_STATS, 'LANG_LINKS_STATS', "for stats");
mergeArrays($ENG_SEARCH, $LANG_LINKS_SEARCH, 'LANG_LINKS_SEARCH', "for the search");
mergeArrays($ENG_SUBMIT, $LANG_LINKS_SUBMIT, 'LANG_LINKS_SUBMIT', "for the submission form");

separator();
echo "# Messages for COM_showMessage the submission form\n\n";

mergeString($ENG_MSG1, $PLG_links_MESSAGE1, 'PLG_links_MESSAGE1');
mergeString($ENG_MSG2, $PLG_links_MESSAGE2, 'PLG_links_MESSAGE2');
mergeString($ENG_MSG3, $PLG_links_MESSAGE3, 'PLG_links_MESSAGE3');
mergeString($ENG_MSG4, $PLG_links_MESSAGE4, 'PLG_links_MESSAGE4');
mergeString($ENG_MSG5, $PLG_links_MESSAGE5, 'PLG_links_MESSAGE5');
mergeString($ENG_MSG6, $PLG_links_MESSAGE6, 'PLG_links_MESSAGE6');
mergeString($ENG_MSG7, $PLG_links_MESSAGE7, 'PLG_links_MESSAGE7');

mergeString($ENG_MSG10, $PLG_links_MESSAGE10, 'PLG_links_MESSAGE10');
mergeString($ENG_MSG11, $PLG_links_MESSAGE11, 'PLG_links_MESSAGE11');
mergeString($ENG_MSG12, $PLG_links_MESSAGE12, 'PLG_links_MESSAGE12');
mergeString($ENG_MSG13, $PLG_links_MESSAGE13, 'PLG_links_MESSAGE13');
mergeString($ENG_MSG14, $PLG_links_MESSAGE14, 'PLG_links_MESSAGE14');
mergeString($ENG_MSG15, $PLG_links_MESSAGE15, 'PLG_links_MESSAGE15');
mergeString($ENG_MSG16, $PLG_links_MESSAGE16, 'PLG_links_MESSAGE16');
mergeString($ENG_MSG17, $PLG_links_MESSAGE17, 'PLG_links_MESSAGE17');

echo "\n";
echo "// Messages for the plugin upgrade\n";
mergeString($ENG_MSG3001, $PLG_links_MESSAGE3001, 'PLG_links_MESSAGE3001');
echo "\$PLG_links_MESSAGE3002 = \$LANG32[9];\n";

echo "\n";
mergeArrays($ENG_ADMIN, $LANG_LINKS_ADMIN, 'LANG_LINKS_ADMIN', "admin/plugins/links/index.php");
mergeArrays($ENG_STATUS, $LANG_LINKS_STATUS, 'LANG_LINKS_STATUS', false);

echo "\n";
echo "// Localization of the Admin Configuration UI";

mergeArrays($ENG_configsections['links'], $LANG_configsections['links'], "LANG_configsections['links']", false);
mergeArrays($ENG_confignames['links'], $LANG_confignames['links'], "LANG_confignames['links']", false);
mergeArrays($ENG_configsubgroups['links'], $LANG_configsubgroups['links'], "LANG_configsubgroups['links']", false);
mergeArrays($ENG_tab['links'], $LANG_tab['links'], "LANG_tab['links']", false);
mergeArrays($ENG_fs['links'], $LANG_fs['links'], "LANG_fs['links']", false);
echo "\n";
echo "// Note: entries 0, 1, and 12 are the same as in \$LANG_configselects['Core']";
mergeArrays($ENG_configselects['links'], $LANG_configselects['links'], "LANG_configselects['links']", false);
