<?php

###############################################################################
# estonian_utf-8.php
# This is the Estonian language file for the Geeklog Static Page plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
#
# Estonian translation by Artur Räpp <rtr AT planet DOT ee>
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

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => 'Uus leht',
    'adminhome' => 'Admin avaleht',
    'staticpages' => 'Staatilised lehed',
    'staticpageeditor' => 'Staatiliste lehtede toimetaja',
    'writtenby' => 'Kirjutas',
    'date' => 'Uuendatud',
    'title' => 'Tiitel',
    'content' => 'Sisu',
    'hits' => 'Klikke',
    'staticpagelist' => 'Staatiliste lehtede nimekiri',
    'url' => 'URL',
    'edit' => 'Toimeta',
    'lastupdated' => 'Uuendatud',
    'pageformat' => 'Lehe kujundus',
    'leftrightblocks' => 'vasak- ja paremblokid',
    'blankpage' => 'tühi leht',
    'noblocks' => 'blokkideta',
    'leftblocks' => 'Vasakblokid',
    'addtomenu' => 'Lisa menüüsse',
    'label' => 'Silt',
    'nopages' => 'Süsteemis pole veel staatilisi lehti',
    'save' => 'salvesta',
    'preview' => 'eelvaade',
    'delete' => 'kustuta',
    'cancel' => 'tühista',
    'access_denied' => 'Ligipääs tõkestatud',
    'access_denied_msg' => 'Sa proovisid ilma vastavate õigusteta ligi pääseda ühele staatiliste lehtede administreerimislehtedest. Pane tähele, et kõik sellised katsed logitakse.',
    'all_html_allowed' => 'Kogu HTML on lubatud',
    'results' => 'Staatiliste lehtede tulemus',
    'author' => 'Autor',
    'no_title_or_content' => 'Sa pead täitma vähemalt <b>tiitli</b> ja <b>sisu</b> väljad.',
    'no_such_page_anon' => 'Palun logi sisse...',
    'no_page_access_msg' => "Põhjuseks võib olla, et sa pole veel sisse loginud või pole veel {$_CONF['site_name']} lehe registreerunud kasutaja. Palun <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> registreeru {$_CONF['site_name']} lehe kasutajaks.</a> Registreerumine annab sulle kõik lehe liikme ligipääsuõigused.",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Hoiatus! Selle valiku sisselülitamisel käivitatakse lehel olevad PHP käsud. Kasuta ettevaatusega!',
    'exit_msg' => 'Tagastuse tüüp',
    'exit_info' => 'Kasuta logimismärkuste jaoks. Tavalise lehe kasutus- ja turvateadete jaoks jäta märge tegemata.',
    'deny_msg' => 'Ligipääs sellele lehele on tõkestatud. Võimalik, et  see leht on kas kustutatud või ümbernimetatud või pole sul piisavalt õigusi.',
    'stats_headline' => 'Staatiliste lehtede top 10',
    'stats_page_title' => 'Lehe tiitel',
    'stats_hits' => 'Klikke',
    'stats_no_hits' => 'Näib, et saidil pole ühtegi staatilist lehte või mitte keegi pole neid vaadanud.',
    'id' => 'ID',
    'duplicate_id' => 'Sisestatud staatilise lehe ID on juba kasutuses. Vali teine ID.',
    'instructions' => 'Staatilise lehe toimetamiseks või kustutamiseks klõpsa allpool staatilise lehe juures olevat toimetamisikooni. Staatilise lehe vaatamiseks klõpsa selle tiitlil. Uue loomiseks klõpsa "Tee uus" ülal. Olemasolevast staatilisest lehest koopia tegemiseks klõpsa kopeerimisikooni.',
    'centerblock' => 'Keskblokk: ',
    'centerblock_msg' => 'Kui märgitud, näidatakse seda staatilist lehte indeks lehel keskblokina.',
    'topic' => 'Rubriik: ',
    'position' => 'Asukoht: ',
    'all_topics' => 'Kõik',
    'no_topic' => 'Ainult avaleht',
    'position_top' => 'Lehe ülaservas',
    'position_feat' => 'Peale pealugu',
    'position_bottom' => 'Lehe allservas',
    'position_entire' => 'Kogu leht',
    'head_centerblock' => 'Keskblokk',
    'centerblock_no' => 'Ei',
    'centerblock_top' => 'Ülal',
    'centerblock_feat' => 'Pealugu',
    'centerblock_bottom' => 'All',
    'centerblock_entire' => 'Kogu',
    'inblock_msg' => 'Blokina:',
    'inblock_info' => 'Paiguta staatiline leht blokki.',
    'title_edit' => 'Toimeta lehte',
    'title_copy' => 'Tee lehest koopia',
    'title_display' => 'Näita leht',
    'select_php_none' => 'ära käivita PHP',
    'select_php_return' => 'käivita PHP (return)',
    'select_php_free' => 'käivita PHP',
    'php_not_activated' => "Staatilistel lehtedel pole PHP kasutamine sisse lülitatud. Täpsemat infot palun vaata <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">dokumentatsioonist.</a>",
    'printable_format' => 'Prinditaval kujul',
    'copy' => 'Koopia',
    'limit_results' => 'Piira tulemused',
    'search' => 'Otsi',
    'submit' => 'Sisesta',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugina uuendamine pole toetatud.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Staatilised lehed',
    'title' => 'Staatiliste lehtede häälestamine'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Luba PHP?',
    'sort_by' => 'Keskblokkide sorteerimisalus',
    'sort_menu_by' => 'Menüüelementide sorteerimisalus',
    'delete_pages' => 'Kustuta lehed, omanikuks?',
    'in_block' => 'Paiguta lehed blokki?',
    'show_hits' => 'Näita klikke?',
    'show_date' => 'Näita aega?',
    'filter_html' => 'Filtreeri HTML-i?',
    'censor' => 'Tsenseeri sisu?',
    'default_permissions' => 'Lehe vaikimisi õigused',
    'aftersave' => 'Pärast lehe salvestamist',
    'atom_max_items' => 'Maks. lehti veebiteenuste lõimes',
    'meta_tags' => 'Enable Meta Tags',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Peaseaded'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Staatiliste  lehtede peaseadistused',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Vaikimisi õigused'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('Jah' => 1, 'Ei' => 0),
    1 => array('Jah' => true, 'Ei' => false),
    2 => array('Aeg' => 'date', 'Lehe ID' => 'id', 'Tiitel' => 'title'),
    3 => array('Aeg' => 'date', 'Lehe ID' => 'id', 'Tiitel' => 'title', 'Silt' => 'label'),
    9 => array('Suuna edasi lehele' => 'item', 'Näita loetelu' => 'list', 'Näita avalehte' => 'home', 'Näita admini lehten' => 'admin'),
    12 => array('Pole ligipääsu' => 0, 'Ainult loetav' => 2, 'Loetav ja muudetav' => 3)
);

?>
