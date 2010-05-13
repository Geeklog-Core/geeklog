<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin                                                         |
// +---------------------------------------------------------------------------+
// | french_france.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// | Last update ::Ben http://geeklog.fr May 10 2010                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// +---------------------------------------------------------------------------|
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------|

global $LANG32;

$LANG_XMLSMAP = array(
    'plugin' => 'XMLSitemap',
    'admin' => 'XMLSitemap Admin'
);

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = array(
    'label' => 'XMLSitemap',
    'title' => 'Configuration de XMLSitemap'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'Nom du fichier Sitemap',
    'mobile_sitemap_file' => 'Nom du fichier Sitemap Mobile',
    'types' => 'Contenu du sitemap',
    'exclude' => 'Plugins à exclure du sitemap',
    'priorities' => '',
    'frequencies' => ''
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'Paramètres principaux'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'XMLSitemap paramètres principaux',
    'fs_pri' => 'Priorité (defaut = 0.5, basse = 0.0, haute = 1.0)',
    'fs_freq' => 'Fréquence de mise à jour'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('Vrai' => 1, 'Faux' => 0),
    1 => array('Vrai' => true, 'Faux' => false),
    9 => array('Tranférer à la page' => 'item', 'Afficher la liste' => 'list', 'Afficher page d\'accueil' => 'home', 'Afficher page d\'administration' => 'admin'),
    12 => array('Pas d\'accès' => 0, 'Lecture seule' => 2, 'Lecture Ecriture' => 3),
    20 => array('toujours' => 'always', 'Toutes les heures' => 'hourly', 'Quotidienne' => 'daily', 'Hebdomadaire' => 'weekly', 'mensuelle' => 'monthly', 'annuelle' => 'yearly', 'jamais' => 'never')
);

?>
