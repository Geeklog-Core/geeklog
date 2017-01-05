<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | calendar.inc                                                              |
// |                                                                           |
// | Update a calendar language file by merging it with english.php            |
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
$ENG_CAL_1 = $LANG_CAL_1;
$ENG_CAL_SEARCH = $_LANG_CAL_SEARCH;
$ENG_CAL_2 = $LANG_CAL_2;
$ENG_CAL_ADMIN = $LANG_CAL_ADMIN;
$ENG_CAL_MESSAGE = $LANG_CAL_MESSAGE;

$ENG_MSG4 = $PLG_calendar_MESSAGE4;
$ENG_MSG17 = $PLG_calendar_MESSAGE17;
$ENG_MSG18 = $PLG_calendar_MESSAGE18;
$ENG_MSG24 = $PLG_calendar_MESSAGE24;
$ENG_MSG26 = $PLG_calendar_MESSAGE26;
$ENG_MSG3001 = $PLG_calendar_MESSAGE3001;

$ENG_configsections['calendar'] = $LANG_configsections['calendar'];
$ENG_confignames['calendar'] = $LANG_confignames['calendar'];
$ENG_configsubgroups['calendar'] = $LANG_configsubgroups['calendar'];
$ENG_tab['calendar'] = $LANG_tab['calendar'];
$ENG_fs['calendar'] = $LANG_fs['calendar'];
$ENG_configselects['calendar'] = $LANG_configselects['calendar'];

// now load the language file we want to update
require_once $langfile;

echo "\nglobal \$LANG32;\n\n";

separator();
echo "# Array Format:\n";
echo "# \$LANGXX[YY]:  \$LANG - variable name\n";
echo "#               XX    - file id number\n";
echo "#               YY    - phrase id number\n";
separator();
echo "\n";
echo "# index.php";

mergeArrays($ENG_CAL_1, $LANG_CAL_1, 'LANG_CAL_1', false);
mergeArrays($ENG_CAL_SEARCH, $_LANG_CAL_SEARCH, '_LANG_CAL_SEARCH', false);

echo "\n";
separator();
echo "# calendar.php (\$LANG30)\n";
mergeArrays($ENG_CAL_2, $LANG_CAL_2, 'LANG_CAL_2', false);

echo "\n";
separator();
echo "# admin/plugins/calendar/index.php, formerly admin/event.php (\$LANG22)\n";
mergeArrays($ENG_CAL_ADMIN, $LANG_CAL_ADMIN, 'LANG_CAL_ADMIN', false);
mergeArrays($ENG_CAL_MESSAGE, $LANG_CAL_MESSAGE, 'LANG_CAL_MESSAGE', false);

echo "\n";

mergeString($ENG_MSG4, $PLG_calendar_MESSAGE4, 'PLG_calendar_MESSAGE4');
mergeString($ENG_MSG17, $PLG_calendar_MESSAGE17, 'PLG_calendar_MESSAGE17');
mergeString($ENG_MSG18, $PLG_calendar_MESSAGE18, 'PLG_calendar_MESSAGE18');
mergeString($ENG_MSG24, $PLG_calendar_MESSAGE24, 'PLG_calendar_MESSAGE24');
mergeString($ENG_MSG26, $PLG_calendar_MESSAGE26, 'PLG_calendar_MESSAGE26');

echo "\n";
echo "// Messages for the plugin upgrade\n";
mergeString($ENG_MSG3001, $PLG_calendar_MESSAGE3001, 'PLG_calendar_MESSAGE3001');
echo "\$PLG_calendar_MESSAGE3002 = \$LANG32[9];\n";

echo "\n";
echo "// Localization of the Admin Configuration UI";

mergeArrays($ENG_configsections['calendar'], $LANG_configsections['calendar'], "LANG_configsections['calendar']", false);
mergeArrays($ENG_confignames['calendar'], $LANG_confignames['calendar'], "LANG_confignames['calendar']", false);
mergeArrays($ENG_configsubgroups['calendar'], $LANG_configsubgroups['calendar'], "LANG_configsubgroups['calendar']", false);
mergeArrays($ENG_tab['calendar'], $LANG_tab['calendar'], "LANG_tab['calendar']", false);
mergeArrays($ENG_fs['calendar'], $LANG_fs['calendar'], "LANG_fs['calendar']", false);
echo "\n";
echo "// Note: entries 0, 1, 6, 9, 12 are the same as in \$LANG_configselects['Core']";
mergeArrays($ENG_configselects['calendar'], $LANG_configselects['calendar'], "LANG_configselects['calendar']", false);
