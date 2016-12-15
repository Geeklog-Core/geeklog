<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | polls.inc                                                                 |
// |                                                                           |
// | Update a polls language file by merging it with english.php               |
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
$ENG_POLLS = $LANG_POLLS;
$ENG_LANG25 = $LANG25;

$ENG_MSG15 = $PLG_polls_MESSAGE15;
$ENG_MSG19 = $PLG_polls_MESSAGE19;
$ENG_MSG20 = $PLG_polls_MESSAGE20;
$ENG_MSG3001 = $PLG_polls_MESSAGE3001;

$ENG_configsections['polls'] = $LANG_configsections['polls'];
$ENG_confignames['polls'] = $LANG_confignames['polls'];
$ENG_configsubgroups['polls'] = $LANG_configsubgroups['polls'];
$ENG_tab['polls'] = $LANG_tab['polls'];
$ENG_fs['polls'] = $LANG_fs['polls'];
$ENG_configselects['polls'] = $LANG_configselects['polls'];

// now load the language file we want to update
require_once $langfile;

echo "\nglobal \$LANG32;\n\n";

separator();
echo "# Array Format:\n";
echo "# \$LANGXX[YY]:  \$LANG - variable name\n";
echo "#               XX    - file id number\n";
echo "#               YY    - phrase id number\n";
separator();

mergeArrays($ENG_POLLS, $LANG_POLLS, 'LANG_POLLS', false);

echo "\n";
mergeArrays($ENG_LANG25, $LANG25, 'LANG25', "admin/plugins/polls/index.php");

mergeString($ENG_MSG15, $PLG_polls_MESSAGE15, 'PLG_polls_MESSAGE15');
mergeString($ENG_MSG19, $PLG_polls_MESSAGE19, 'PLG_polls_MESSAGE19');
mergeString($ENG_MSG20, $PLG_polls_MESSAGE20, 'PLG_polls_MESSAGE20');

echo "\n";
echo "// Messages for the plugin upgrade\n";
mergeString($ENG_MSG3001, $PLG_polls_MESSAGE3001, 'PLG_polls_MESSAGE3001');
echo "\$PLG_polls_MESSAGE3002 = \$LANG32[9];\n";

echo "\n";
echo "// Localization of the Admin Configuration UI";

mergeArrays($ENG_configsections['polls'], $LANG_configsections['polls'], "LANG_configsections['polls']", false);
mergeArrays($ENG_confignames['polls'], $LANG_confignames['polls'], "LANG_confignames['polls']", false);
mergeArrays($ENG_configsubgroups['polls'], $LANG_configsubgroups['polls'], "LANG_configsubgroups['polls']", false);
mergeArrays($ENG_tab['polls'], $LANG_tab['polls'], "LANG_tab['polls']", false);
mergeArrays($ENG_fs['polls'], $LANG_fs['polls'], "LANG_fs['polls']", false);
echo "\n";
echo "// Note: entries 0, 1, and 12 are the same as in \$LANG_configselects['Core']";
mergeArrays($ENG_configselects['polls'], $LANG_configselects['polls'], "LANG_configselects['polls']", false);
