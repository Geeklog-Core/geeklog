<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap 2.0                                                            |
// +---------------------------------------------------------------------------+
// | configuration_validation.php                                              |
// |                                                                           |
// | List of validation rules for the Links plugin configurations              |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2020 by the following authors:                         |
// |                                                                           |
// | Authors: Akeda Bagus       - admin AT gedex DOT web DOT id                |
// |          Tom Homer         - tomhomer AT gmail DOT com                    |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// XML Sitemap Main Settings
$_CONF_VALIDATE['xmlsitemap']['sitemap_file'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['xmlsitemap']['mobile_sitemap_file'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['include_homepage']['include_homepage']   = ['rule' => 'boolean'];

// Priority

// Update frequency
$_CONF_VALIDATE['xmlsitemap']['frequencies[article]'] = [
    'rule' => ['inList', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never', 'hidden'], true]
];
$_CONF_VALIDATE['xmlsitemap']['frequencies[calendar]'] = [
    'rule' => ['inList', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never', 'hidden'], true]
];
$_CONF_VALIDATE['xmlsitemap']['frequencies[polls]'] = [
    'rule' => ['inList', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never', 'hidden'], true]
];
$_CONF_VALIDATE['xmlsitemap']['frequencies[staticpages]'] = [
    'rule' => ['inList', ['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never', 'hidden'], true]
];

// Ping target
$_CONF_VALIDATE['xmlsitemap']['ping_google'] = ['rule' => 'boolean'];

// IndexNow
$_CONF_VALIDATE['xmlsitemap']['indexnow']   = ['rule' => 'boolean'];
$_CONF_VALIDATE['xmlsitemap']['indexnow_key'] = ['rule' => 'alphaNumericOrEmpty'];
$_CONF_VALIDATE['xmlsitemap']['indexnow_key_location'] = ['rule' => 'urlOrEmpty',
    'message' => isset($LANG_VALIDATION['alphaNumericOrEmpty']) ?
        $LANG_VALIDATION['alphaNumericOrEmpty'] : $LANG_VALIDATION['default']];

// News Sitemap
$_CONF_VALIDATE['xmlsitemap']['news_sitemap_file'] = ['rule' => 'notEmpty'];
$_CONF_VALIDATE['xmlsitemap']['news_sitemap_age'] = ['rule' => 'numeric'];
