<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | xmlsitemap.php                                                            |
// |                                                                           |
// | Geeklog language administration page.                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2020      by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - mystralkk AT gmail DOT come                  |
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

global $_CONF, $_USER, $LANG_ADMIN;

use Geeklog\Input;

// Geeklog common function library
require_once __DIR__ . '/../../../lib-common.php';

// Security check to ensure user even belongs on this page
require_once __DIR__ . '/../../auth.inc.php';

// Include admin library
require_once $_CONF['path_system'] . 'lib-admin.php';

// Include XMLSitemap class
require_once $_CONF['path'] . 'plugins/xmlsitemap/xmlsitemap.class.php';

// Make sure user has rights to access this page
if (!SEC_hasRights('xmlsitemap.edit')) {
    $content = COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($content, ['pagetitle' => $MESSAGE[30]]);
    COM_accessLog("User {$_USER['username']} tried to illegally access the XMLSitemap administration screen.");
    COM_output($display);
    exit;
}

//===========================
// Main
//===========================

// Update all the sitemap files if necessary
if ((Input::fPost('submit') === 'submit') && SEC_checkToken()) {
    $message = XMLSMAP_update() ? $LANG_XMLSMAP['update_success'] : $LANG_XMLSMAP['update_fail'];
} else {
    $message = '';
}

// Create a view
$editor = COM_newTemplate(CTL_plugin_templatePath('xmlsitemap', 'admin'));
$editor->set_file([
    'admin_editor' => 'index.thtml',
    'row'          => 'row.thtml',
]);

clearstatcache();

foreach (['sitemap_file', 'mobile_sitemap_file', 'news_sitemap_file'] as $item) {
    if (empty($_XMLSMAP_CONF[$item])) {
        continue;
    }

    $fileName = basename($_XMLSMAP_CONF[$item]);
    $path = $_CONF['path_html'] . $fileName;

    if (is_readable($path)) {
        list($updated,) = COM_getUserDateTimeFormat(filemtime($path), 'date');
    } else {
        $updated = $LANG_XMLSMAP['not_saved'];
    }

    $editor->set_var([
        'filename' => $fileName,
        'updated'  => $updated,
    ]);
    $editor->parse('rows', 'row', true);
}

$token = SEC_createToken();
$content = COM_startBlock(
    $LANG_XMLSMAP['admin'], '', COM_getBlockTemplate('_admin_block', 'header')
);
$content .= SEC_getTokenExpiryNotice($token);

$editor->set_var([
    'lang_description' => $LANG_XMLSMAP['description'],
    'lang_filename'    => $LANG_XMLSMAP['filename'],
    'lang_updated'     => $LANG_XMLSMAP['updated'],
    'lang_update_now'  => $LANG_XMLSMAP['update_now'],
    'message'          => $message,
    'rows'             => $editor->finish($editor->get_var('rows')),
    'token_name'       => CSRF_TOKEN,
    'token_value'      => $token,
]);

$editor->parse('output', 'admin_editor');
$content .= $editor->finish($editor->get_var('output'));
$content .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));
$display = COM_createHTMLDocument($content, ['pagetitle' => $LANG_XMLSMAP['admin']]);
COM_output($display);
