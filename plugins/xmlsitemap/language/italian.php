<?php

###############################################################################
# italian.php
#
# This is the Italian language file for the Geeklog XmlSitemap Plugin
#
# Copyright (C) 2011 Rouslan Placella rouslan {at} placella {dot} com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

global $LANG32;

$LANG_XMLSMAP = array(
    'plugin' => 'XMLSitemap',
    'admin' => 'Amministrazione XMLSitemap'
);

// Localization of the Admin Configuration UI
$LANG_configsections['xmlsitemap'] = array(
    'label' => 'XMLSitemap',
    'title' => 'Configurazione XMLSitemap'
);

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'Nome del file per Sitemap',
    'mobile_sitemap_file' => 'Nome del file per Sitemap per Dispositivi Mobili',
    'types' => 'Contenuto di sitemap',
    'exclude' => 'Estensioni da escludere dal Sitemap',
    'priorities' => '',
    'frequencies' => ''
);

$LANG_configsubgroups['xmlsitemap'] = array(
    'sg_main' => 'Impostazioni Principali'
);

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'XMLSitemap Main Settings',
    'tab_pri' => 'Priority',
    'tab_freq' => 'Update frequency'
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'Impostazioni Principali di XMLSitemap',
    'fs_pri' => 'Prioritá (predefinita = 0.5, minima = 0.0, massima = 1.0)',
    'fs_freq' => 'Aggiornamento'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['xmlsitemap'] = array(
    0 => array('Vero' => 1, 'Falso' => 0),
    1 => array('Vero' => true, 'Falso' => false),
    9 => array('Vai a pagina' => 'item', 'Mostra Lista' => 'list', 'Mostra Home' => 'home', 'Mostra Admin' => 'admin'),
    12 => array('Nessun Accesso' => 0, 'Sola lettura' => 2, 'Lettura e Scrittura' => 3),
    20 => array('sempre' => 'always', 'ogni ora' => 'hourly', 'giornaliero' => 'daily', 'settimanale' => 'weekly', 'mensile' => 'monthly', 'annuale' => 'yearly', 'mai' => 'never')
);

?>
