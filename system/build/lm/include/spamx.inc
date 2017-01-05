<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | spamx.inc                                                                 |
// |                                                                           |
// | Update a spamx language file by merging it with english.php               |
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
$ENG_SX00 = $LANG_SX00;

$ENG_MSG128 = $PLG_spamx_MESSAGE128;
$ENG_MSG8 = $PLG_spamx_MESSAGE8;
$ENG_MSG3001 = $PLG_spamx_MESSAGE3001;

$ENG_configsections['spamx'] = $LANG_configsections['spamx'];
$ENG_confignames['spamx'] = $LANG_confignames['spamx'];
$ENG_configsubgroups['spamx'] = $LANG_configsubgroups['spamx'];
$ENG_tab['spamx'] = $LANG_tab['spamx'];
$ENG_fs['spamx'] = $LANG_fs['spamx'];
$ENG_configselects['spamx'] = $LANG_configselects['spamx'];

// now load the language file we want to update
require_once $langfile;

echo "\nglobal \$LANG32;\n";

mergeArrays($ENG_SX00, $LANG_SX00, 'LANG_SX00', false);

echo "\n";
echo "// Define Messages that are shown when Spam-X module action is taken\n";
mergeString($ENG_MSG128, $PLG_spamx_MESSAGE128, 'PLG_spamx_MESSAGE128');
mergeString($ENG_MSG8, $PLG_spamx_MESSAGE8, 'PLG_spamx_MESSAGE8');

echo "\n";
echo "// Messages for the plugin upgrade\n";
mergeString($ENG_MSG3001, $PLG_spamx_MESSAGE3001, 'PLG_spamx_MESSAGE3001');
echo "\$PLG_spamx_MESSAGE3002 = \$LANG32[9];\n";

echo "\n";
echo "// Localization of the Admin Configuration UI";

mergeArrays($ENG_configsections['spamx'], $LANG_configsections['spamx'], "LANG_configsections['spamx']", false);
mergeArrays($ENG_confignames['spamx'], $LANG_confignames['spamx'], "LANG_confignames['spamx']", false);
mergeArrays($ENG_configsubgroups['spamx'], $LANG_configsubgroups['spamx'], "LANG_configsubgroups['spamx']", false);
mergeArrays($ENG_tab['spamx'], $LANG_tab['spamx'], "LANG_tab['spamx']", false);
mergeArrays($ENG_fs['spamx'], $LANG_fs['spamx'], "LANG_fs['spamx']", false);
echo "\n";
echo "// Note: entries 0, 1, 9, and 12 are the same as in \$LANG_configselects['Core']";
mergeArrays($ENG_configselects['spamx'], $LANG_configselects['spamx'], "LANG_configselects['spamx']", false);
