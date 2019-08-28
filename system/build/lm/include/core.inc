<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1.0                                                             |
// +---------------------------------------------------------------------------+
// | core.inc                                                                  |
// |                                                                           |
// | Update a core language file by merging it with english.php                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004-2014 by the following authors:                         |
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

/**
* Helper function: Fix URLs in some language files
*
*/
function Core_fix_some_urls(&$access)
{
    if (isset($access['storydenialmsg'])) {
        $access['storydenialmsg'] = str_replace('<a href=users.php?mode=new>',
                    '<a href="{$_CONF[\'site_url\']}/users.php?mode=new">',
                    $access['storydenialmsg']);
    }

    if (isset($access['editrootmsg'])) {
        $access['editrootmsg'] = str_replace('users.php', 'user.php',
                                             $access['editrootmsg']);
    }
}

// save the english text strings
$ENG01 = $LANG01;
// $LANG02 moved to the Calendar plugin as of Geeklog 1.4.1
$ENG03 = $LANG03;
$ENG04 = $LANG04;
$ENGMY = $LANG_MYACCOUNT;
$ENG05 = $LANG05;
// $LANG06 moved to the Links plugin as of Geeklog 1.4.0
// $LANG07 moved to the Polls plugin as of Geeklog 1.4.0
$ENG08 = $LANG08;
$ENG09 = $LANG09;
$ENG10 = $LANG10;
$ENG11 = $LANG11;
$ENG12 = $LANG12;
$ENGLIKES = $LANG_LIKES;

// there are no $LANG13-$LANG19
$ENG20 = $LANG20;
$ENG21 = $LANG21;
// $LANG22 moved to the Calendar plugin as of Geeklog 1.4.1
$ENG23 = $LANG23;
$ENG24 = $LANG24;
// $LANG25 moved to the Polls plugin as of Geeklog 1.4.0
// there is no $LANG26
$ENG27 = $LANG27;
$ENG28 = $LANG28;
$ENG29 = $LANG29;
// $LANG30 moved to the Calendar plugin as of Geeklog 1.4.1
$ENG31 = $LANG31;
$ENG32 = $LANG32;
$ENG33 = $LANG33;

// $LANG_LANG and $LANG_ROUTER since Geeklog 2.1.2
$ENG_LANG = $LANG_LANG;
$ENG_ROUTER = $LANG_ROUTER;

$ENGMS = $MESSAGE;
$ENGAC = $LANG_ACCESS;
$ENGDB = $LANG_DB_BACKUP;
$ENGBT = $LANG_BUTTONS;
$ENG404 = $LANG_404;
$ENGLO = $LANG_LOGIN;
$ENGTB = $LANG_TRB;
$ENGDI = $LANG_DIR;
$ENGSEC = $LANG_SECTEST;
$ENGWN = $LANG_WHATSNEW;
$ENGMO = $LANG_MONTH;
$ENGWK = $LANG_WEEK;
$ENGAD = $LANG_ADMIN;
$ENG_LOGVIEW = $LANG_LOGVIEW;
$ENG_ENVCHECK = $LANG_ENVCHECK;

$ENG_commentcodes = $LANG_commentcodes;
$ENG_commentmodes = $LANG_commentmodes;
$ENG_cookiecodes = $LANG_cookiecodes;
$ENG_dateformats = $LANG_dateformats;
$ENG_featurecodes = $LANG_featurecodes;
$ENG_frontpagecodes = $LANG_frontpagecodes;
$ENG_postmodes = $LANG_postmodes;
$ENG_sortcodes = $LANG_sortcodes;
$ENG_statuscodes = $LANG_statuscodes;
$ENG_trackbackcodes = $LANG_trackbackcodes;
$ENG_structureddatatypes = $LANG_structureddatatypes;
$ENG_STRUCT_DATA = $LANG_STRUCT_DATA;

$ENG_CONFIG = $LANG_CONFIG;
$ENG_configsections['Core'] = $LANG_configsections['Core'];
$ENG_confignames['Core'] = $LANG_confignames['Core'];
$ENG_configsubgroups['Core'] = $LANG_configsubgroups['Core'];
$ENG_fs['Core'] = $LANG_fs['Core'];
$ENG_tab['Core'] = $LANG_tab['Core'];
$ENG_configselects['Core'] = $LANG_configselects['Core'];
$ENGVA = $LANG_VALIDATION;

unset($LANG_MONTH);
unset($LANG_WEEK);

// now load the language file we want to update
require_once $langfile;

// try to rescue translated day and months names

if (!isset ($LANG_WEEK[1]) && isset ($LANG30[1])) {
    $LANG_WEEK = array ();
    for ($i = 1; $i <= 7; $i++) {
        $LANG_WEEK[$i] = $LANG30[$i];
    }
}

if (!isset ($LANG_MONTH[1]) && isset ($LANG30[13])) {
    $LANG_MONTH = array ();
    for ($i = 1; $i <= 12; $i++) {
        $LANG_MONTH[$i] = $LANG30[$i + 12];
    }
}

echo "\n\$LANG_CHARSET = '$LANG_CHARSET';\n";
echo "\n\$LANG_ISO639_1 = '$LANG_ISO639_1';\n";
if (isset ($LANG_DIRECTION)) {
    echo "\$LANG_DIRECTION = '$LANG_DIRECTION';\n\n";
} else {
    echo "\n";
}

separator();
echo "# Array Format:\n";
echo "# \$LANGXX[YY]:  \$LANG - variable name\n";
echo "#               XX    - file id number\n";
echo "#               YY    - phrase id number\n";
separator();
echo "\n";
separator();
echo "# USER PHRASES - These are file phrases used in end user scripts\n";
separator();
echo "\n";

// http://project.geeklog.net/tracking/view.php?id=801
$ENG01[95]  = str_replace('Powered By', 'Powered by', $ENG01[95]);
$LANG01[95] = str_replace('Powered By', 'Powered by', $LANG01[95]);

mergeArrays($ENG01, $LANG01, 'LANG01', 'lib-common.php');
mergeArrays($ENG03, $LANG03, 'LANG03', 'comment.php');
mergeArrays($ENG04, $LANG04, 'LANG04', 'usersettings.php');
mergeArrays($ENGMY,  $LANG_MYACCOUNT, 'LANG_MYACCOUNT', "Customize if need to modify the Tabbed navbar MyAccount panels used.\nArray index key matches preference div id");
mergeArrays($ENG05, $LANG05, 'LANG05', 'index.php');
mergeArrays($ENG08, $LANG08, 'LANG08', 'profiles.php');
mergeArrays($ENG09, $LANG09, 'LANG09', 'search.php');
mergeArrays($ENG10, $LANG10, 'LANG10', 'stats.php');
mergeArrays($ENG11, $LANG11, 'LANG11', 'article.php');
mergeArrays($ENG12, $LANG12, 'LANG12', 'submit.php');
mergeArrays($ENGLIKES, $LANG_LIKES, 'LANG_LIKES', 'LIKES feature since Geeklog 2.2.1');

separator();
echo "# ADMIN PHRASES - These are file phrases used in admin scripts\n";
separator();
echo "\n";

mergeArrays($ENG_LOGVIEW, $LANG_LOGVIEW, 'LANG_LOGVIEW', 'admin/logviewer.php');
mergeArrays($ENG_ENVCHECK, $LANG_ENVCHECK, 'LANG_ENVCHECK', 'admin/envcheck.php - distribution integrity checker');
mergeArrays($ENG20, $LANG20, 'LANG20', 'admin/auth.inc.php');
mergeArrays($ENG21, $LANG21, 'LANG21', 'admin/block.php');
mergeArrays($ENG23, $LANG23, 'LANG23', 'Block Locations');
mergeArrays($ENG24, $LANG24, 'LANG24', 'admin/article.php');
mergeArrays($ENG27, $LANG27, 'LANG27', 'admin/topic.php');
mergeArrays($ENG28, $LANG28, 'LANG28', 'admin/user.php');
mergeArrays($ENG29, $LANG29, 'LANG29', "admin/moderation.php\nadmin/index.php");
mergeArrays($ENG31, $LANG31, 'LANG31', 'admin/mail.php');
mergeArrays($ENG32, $LANG32, 'LANG32', 'admin/plugins.php');
mergeArrays($ENG33, $LANG33, 'LANG33', 'admin/syndication.php');

mergeArrays($ENG_LANG, $LANG_LANG, 'LANG_LANG', 'admin/language.php (since v2.1.2)');
mergeArrays($ENG_ROUTER, $LANG_ROUTER, 'LANG_ROUTER', 'admin/router.php');

mergeArrays($ENGMS,  $MESSAGE, 'MESSAGE', 'confirmation and error messages');
Core_fix_some_urls($LANG_ACCESS);
mergeArrays($ENGAC,  $LANG_ACCESS, 'LANG_ACCESS');
mergeArrays($ENGDB,  $LANG_DB_BACKUP, 'LANG_DB_BACKUP', 'admin/database.php');
mergeArrays($ENGBT,  $LANG_BUTTONS, 'LANG_BUTTONS');
mergeArrays($ENG404, $LANG_404, 'LANG_404', '404.php');
mergeArrays($ENGLO,  $LANG_LOGIN, 'LANG_LOGIN', 'login form');
mergeArrays($ENGTB,  $LANG_TRB, 'LANG_TRB', 'trackback.php');
mergeArrays($ENGDI,  $LANG_DIR, 'LANG_DIR', 'directory.php');
mergeArrays($ENGSEC, $LANG_SECTEST, 'LANG_SECTEST', 'admin/sectest.php');
mergeArrays($ENGWN,  $LANG_WHATSNEW, 'LANG_WHATSNEW', "\"What's New\" Time Strings\n\nThis here determines the order of the sentence \"No new articles in 2 hrs\"\norder it so it makes sense in your language:\n%i    item, \"Articles\"\n%n    amount, \"2\", \"20\" etc\n%t    time, \"2\" (weeks)\n%s    scale, \"hrs\", \"weeks\"");
mergeArrays($ENGMO,  $LANG_MONTH, 'LANG_MONTH', 'Month names');
mergeArrays($ENGWK,  $LANG_WEEK, 'LANG_WEEK', 'Weekdays');
mergeArrays($ENGAD,  $LANG_ADMIN, 'LANG_ADMIN', "Admin - Strings\n\nThese are some standard strings used by core functions as well as plugins to\ndisplay administration lists and edit pages");

echo "# Localisation of the texts for the various drop-down menus that are actually\n# stored in the database. If these exist, they override the texts from the\n# database.\n";

mergeArrays($ENG_commentcodes, $LANG_commentcodes, 'LANG_commentcodes', false);
mergeArrays($ENG_commentmodes, $LANG_commentmodes, 'LANG_commentmodes', false);
mergeArrays($ENG_cookiecodes, $LANG_cookiecodes, 'LANG_cookiecodes', false);
mergeArrays($ENG_dateformats, $LANG_dateformats, 'LANG_dateformats', false);
mergeArrays($ENG_featurecodes, $LANG_featurecodes, 'LANG_featurecodes', false);
mergeArrays($ENG_frontpagecodes, $LANG_frontpagecodes, 'LANG_frontpagecodes', false);
mergeArrays($ENG_postmodes, $LANG_postmodes, 'LANG_postmodes', false);
mergeArrays($ENG_sortcodes, $LANG_sortcodes, 'LANG_sortcodes', false);
mergeArrays($ENG_statuscodes, $LANG_statuscodes, 'LANG_statuscodes', false);
mergeArrays($ENG_trackbackcodes, $LANG_trackbackcodes, 'LANG_trackbackcodes', false);
mergeArrays($ENG_structureddatatypes, $LANG_structureddatatypes, 'LANG_structureddatatypes', false);
mergeArrays($ENG_STRUCT_DATA, $LANG_STRUCT_DATA, 'LANG_STRUCT_DATA', false);

echo "\n";
separator();
echo "# Localization of the Admin Configuration UI\n";

mergeArrays($ENG_CONFIG, $LANG_CONFIG, 'LANG_CONFIG', false);
mergeArrays($ENG_configsections['Core'], $LANG_configsections['Core'], "LANG_configsections['Core']", false);
mergeArrays($ENG_confignames['Core'], $LANG_confignames['Core'], "LANG_confignames['Core']", false);
mergeArrays($ENG_configsubgroups['Core'], $LANG_configsubgroups['Core'], "LANG_configsubgroups['Core']", false);
mergeArrays($ENG_fs['Core'], $LANG_fs['Core'], "LANG_fs['Core']", false);
mergeArrays($ENG_tab['Core'], $LANG_tab['Core'], "LANG_tab['Core']", false);
mergeArrays($ENG_configselects['Core'], $LANG_configselects['Core'], "LANG_configselects['Core']", false);

echo "\n";
mergeArrays($ENGVA,  $LANG_VALIDATION, 'LANG_VALIDATION', "Localization of validation error messages");
