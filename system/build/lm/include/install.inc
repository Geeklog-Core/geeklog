<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | install.inc                                                               |
// |                                                                           |
// | Update a language file for the install script                             |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2012 by the following authors:                         |
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
$ENG_INSTALL = $LANG_INSTALL;
$ENG_SUCCESS = $LANG_SUCCESS;
$ENG_MIGRATE = $LANG_MIGRATE;
$ENG_PLUGINS = $LANG_PLUGINS;
$ENG_BIGDUMP = $LANG_BIGDUMP;
$ENG_ERROR = $LANG_ERROR;
$ENG_HELP = $LANG_HELP;
$ENG_RESCUE = $LANG_RESCUE;

// now load the language file we want to update
require_once $langfile;

echo "\n";
separatorThin();
echo "\n";
echo '$LANG_CHARSET = \'' . $LANG_CHARSET . "';\n";
if (!empty($LANG_DIRECTION) && ($LANG_DIRECTION != 'ltr')) {
    echo '$LANG_DIRECTION = \'' . $LANG_DIRECTION . "';\n";
}
echo "\n";

separatorThin();
echo "// | Array Format:                                                             |\n";
echo "// | \$LANG_NAME[XX]: \$LANG - variable name                                     |\n";
echo "// |                 NAME  - where array is used                               |\n";
echo "// |                 XX    - phrase id number                                  |\n";
separatorThin();
echo "\n";

separatorThin();
echo "// install.php\n";
mergeArrays($ENG_INSTALL, $LANG_INSTALL, 'LANG_INSTALL', false);
echo "\n";

separatorThin();
echo "// success.php\n";
mergeArrays($ENG_SUCCESS, $LANG_SUCCESS, 'LANG_SUCCESS', false);
echo "\n";

separatorThin();
echo "// migration\n";
mergeArrays($ENG_MIGRATE, $LANG_MIGRATE, 'LANG_MIGRATE', false);
echo "\n";

separatorThin();
echo "// install-plugins.php\n";
mergeArrays($ENG_PLUGINS, $LANG_PLUGINS, 'LANG_PLUGINS', false);
echo "\n";

separatorThin();
echo "// bigdump.php\n";
mergeArrays($ENG_BIGDUMP, $LANG_BIGDUMP, 'LANG_BIGDUMP', false);
echo "\n";

separatorThin();
echo "// Error Messages\n";
mergeArrays($ENG_ERROR, $LANG_ERROR, 'LANG_ERROR', false);
echo "\n";

separatorThin();
echo "// help.php\n";
mergeArrays($ENG_HELP, $LANG_HELP, 'LANG_HELP', false);
echo "\n";

separatorThin();
echo "// rescue.php\n";
mergeArrays($ENG_RESCUE, $LANG_RESCUE, 'LANG_RESCUE', false);

// hard-code this here (for now)
$label = '
// which texts to use as labels, so they don\'t have to be translated again
$LANG_LABEL = array(
    \'site_name\'      => $LANG_INSTALL[32],
    \'site_slogan\'    => $LANG_INSTALL[33],
    \'db_type\'        => $LANG_INSTALL[34],
    \'db_host\'        => $LANG_INSTALL[39],
    \'db_name\'        => $LANG_INSTALL[40],
    \'db_user\'        => $LANG_INSTALL[41],
    \'db_pass\'        => $LANG_INSTALL[42],
    \'db_prefix\'      => $LANG_INSTALL[43],
    \'site_url\'       => $LANG_INSTALL[45],
    \'site_admin_url\' => $LANG_INSTALL[47],
    \'site_mail\'      => $LANG_INSTALL[48],
    \'noreply_mail\'   => $LANG_INSTALL[49],
    \'utf8\'           => $LANG_INSTALL[92],
	\'charactersets\'  => $LANG_INSTALL[123],
    \'migrate_file\'   => $LANG_MIGRATE[6],
    \'plugin_upload\'  => $LANG_PLUGINS[10]
);';

echo "$label\n";
