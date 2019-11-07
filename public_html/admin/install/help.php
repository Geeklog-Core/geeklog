<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | help.php                                                                  |
// |                                                                           |
// | Support for Geeklog installation script.                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Matt West         - matt AT mattdanger DOT net                   |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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

if (!defined('GL_INSTALL_ACTIVE')) {
    define('GL_INSTALL_ACTIVE', true);
}

if (!defined('BASE_FILE')) {
    define(
        'BASE_FILE',
        str_replace('\\', '/', str_replace(basename(__FILE__), 'index.php', __FILE__))
    );
}

if (!defined('PATH_INSTALL')) {
    define('PATH_INSTALL', __DIR__ . '/');
}

if (!defined('PATH_LAYOUT')) {
    define('PATH_LAYOUT', PATH_INSTALL . 'layout');
}

require_once './classes/micro_template.class.php';
require_once './classes/installer.class.php';
$installer = new Installer();

$language = $installer->get('language', Installer::DEFAULT_LANGUAGE);
if (!file_exists(PATH_INSTALL . 'language/' . $language . '.php')) {
    $language = Installer::DEFAULT_LANGUAGE;
}
require_once PATH_INSTALL . 'language/' . $language . '.php';

$label = '';
if (isset($_GET['label'])) {
    $label = preg_replace('/[^a-z0-9_]/', '', $_GET['label']);
}

$content = '<h1>' . $LANG_HELP[0] . '</h1>' . PHP_EOL;

foreach ($LANG_LABEL as $key => $labeltext) {
    $content .= '
            <div' . ($label == $key
                ? ' class="help_highlight" id="' . $key . '"'
                : ' class="help_normal"') . '>
            <h2><a name="' . $key . '">' . $labeltext . '</a></h2>
            <p class="indent">' . $LANG_HELP[$key] . '</p>
            </div>' . PHP_EOL;
}

$installer->display($content);
