<?php

###############################################################################
# slovenian_utf-8.php as for version 1.4.1
# This is the english language page for the Geeklog Static Page Plug-in!
# language file for geeklog version 1.4.1 beta by mb
# gape@gape.org ; za pripombe, predloge ipd ... piši na email
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
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
    'newpage' => 'Nova stran',
    'adminhome' => 'Skrbnikova stran',
    'staticpages' => 'Statiène strani',
    'staticpageeditor' => 'Urejevalnik statiènih strani',
    'writtenby' => 'Napisal:',
    'date' => 'Nazadnje posodobljeno',
    'title' => 'Naslov',
    'page_title' => 'Naslov strani',
    'content' => 'Vsebina',
    'hits' => 'Zadetkov',
    'staticpagelist' => 'Seznam statiènih strani',
    'url' => 'URL',
    'edit' => 'Uredi',
    'lastupdated' => 'Nazadnje posodobljeno',
    'pageformat' => 'Oblika strani',
    'leftrightblocks' => 'Levi & desni bloki',
    'blankpage' => 'Prazna stran',
    'noblocks' => 'Ni blokov',
    'leftblocks' => 'Levi blok',
    'addtomenu' => 'Dodaj v meni',
    'label' => 'Nalepka',
    'nopages' => 'V sistemu še ni statiènih strani',
    'save' => 'shrani',
    'preview' => 'predogled',
    'delete' => 'izbriši',
    'cancel' => 'preklièi',
    'access_denied' => 'Dostop zavrnjen',
    'access_denied_msg' => 'Nedovoljeno poskušaš dostopiti do ene od skrbniških statiènih strani. Vsi poskusi nedovoljenega dostopa na se beležijo.',
    'all_html_allowed' => 'Dovoljen je ves HTML',
    'results' => 'Rezultati statiènih strani',
    'author' => 'Avtor',
    'no_title_or_content' => 'Izpolniti moraš vsaj polji <b>Naslov</b> in <b>Vsebina</b>.',
    'no_such_page_anon' => 'Prosim, prijavi se.',
    'no_page_access_msg' => "To je morda zato, ker nisi prijavljen/a ali pa sploh nisi èlan spletne strani {$_CONF['site_name']}. Za popoln èlanski dostop <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> postani èlan</a> spletne strani {$_CONF['site_name']} .",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Opozorilo: Koda PHP na tvoji strani bo procesirana, èe omogoèiš to možnost. Uporabljaj previdno!',
    'exit_msg' => 'Vrsta izhoda: ',
    'exit_info' => 'Omogoèi za Zahtevano prijavno sporoèilo. Za  navadno varnostno preverjanje pusti okence prazno.',
    'deny_msg' => 'Dostop do te strani je zavrnjen. Morda je bila stran premaknjena/odstranjena ali pa nimaš zadostnih dovoljenj.',
    'stats_headline' => 'Najboljših 10 statiènih strani',
    'stats_page_title' => 'Naslov strani',
    'stats_hits' => 'Zadetki',
    'stats_no_hits' => 'Izgleda, da na tem mestu ni statiènih strani ali pa še nikoli ni nihèe nobene pogledal.',
    'id' => 'ID',
    'duplicate_id' => 'Za to statièno stran izbrani ID je že v rabi. Izberi prosim drug ID.',
    'instructions' => 'Za spreminjanje ali izbris statiène strani klikni na njeno ikono za urejanje spodaj. Za ogled statiène strani klikni na naslov tiste, ki jo hoèeš pogledati. Za ustvarjenje nove statiène strani klikni na "Ustvari novo" zgoraj. Za ustvarjenje kopije že obstojeèe statiène strani klikni na ikono za kopiranje.',
    'centerblock' => 'Osrednji blok: ',
    'centerblock_msg' => 'Èe potrdiš, bo ta statièna stran prikazana kot osrednji blok na glavni strani.',
    'topic' => 'Rubrika: ',
    'position' => 'Položaj: ',
    'all_topics' => 'Vse',
    'no_topic' => 'Samo vstopna stran',
    'position_top' => 'Vrh strani',
    'position_feat' => 'Za udarnim èlankom',
    'position_bottom' => 'Dno strani',
    'position_entire' => 'Cela stran',
    'head_centerblock' => 'Osrednji blok',
    'centerblock_no' => 'Ne',
    'centerblock_top' => 'Zgoraj',
    'centerblock_feat' => 'Udarni èlanek',
    'centerblock_bottom' => 'Spodaj',
    'centerblock_entire' => 'Celotna stran',
    'inblock_msg' => 'V bloku: ',
    'inblock_info' => 'Èe potrdiš, bo ta statièna stran prikazana v okvirju (bloku).',
    'title_edit' => 'Uredi stran',
    'title_copy' => 'Naredi kopijo te strani',
    'title_display' => 'Prikaži stran',
    'select_php_none' => 'ne izvedi PHP',
    'select_php_return' => 'izvedi PHP (return)',
    'select_php_free' => 'izvedi PHP',
    'php_not_activated' => "Uporaba PHP-ja na statiènih straneh ni vkljuèena. Za podrobnosti glej <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">dokumentacijo</a>.",
    'printable_format' => 'Oblika za natis',
    'copy' => 'Kopiraj',
    'limit_results' => 'Omeji rezultate',
    'search' => 'Išèi',
    'submit' => 'Oddaj',
    'no_new_pages' => 'Ni novih strani',
    'pages' => 'Strani',
    'comments' => 'Komentarji',
    'template' => 'Template',
    'use_template' => 'Use Template',
    'template_msg' => 'When checked, this Static Page will be marked as a template.',
    'none' => 'None',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => 'Osnutek',
    'draft_yes' => 'Da',
    'draft_no' => 'Ne',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.'
);

$PLG_staticpages_MESSAGE15 = 'Komentar je oddan v pregled in bo objavljen, ko ga odobri urednik.';
$PLG_staticpages_MESSAGE19 = 'Stran je uspešno shranjena.';
$PLG_staticpages_MESSAGE20 = 'Stran je uspešno izbrisana.';
$PLG_staticpages_MESSAGE21 = 'Ta stran še ne obstaja. Za ustvarjenje strani prosim izpolni spodnji formular. Èe si tu po pomoti, klikni gumb Preklièi/Cancel.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Nadgradnja vtiènika ni podprta.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Statiène strani',
    'title' => 'Konfiguracija statiènih strani'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Dovoli PHP?',
    'sort_by' => 'Osrednje bloke razvrsti po',
    'sort_menu_by' => 'Menijske vpise razvrsti po',
    'sort_list_by' => 'Skrbnikov seznam razvrsti po',
    'delete_pages' => 'Izbriši strani skupaj z lastnikom?',
    'in_block' => 'Uokviri stran v blok?',
    'show_hits' => 'Prikaži zadetke?',
    'show_date' => 'Prikaži datum?',
    'filter_html' => 'Filtriraj HTML?',
    'censor' => 'Cenzuriraj vsebino?',
    'default_permissions' => 'Prednastavljene pravice strani',
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'Po shranitvi strani',
    'atom_max_items' => 'Najveè strani v feed-u spletnih storitev',
    'meta_tags' => 'Omogoèi Meta Tags',
    'comment_code' => 'Prednastavljeni komentarji',
    'draft_flag' => 'Prednastavljena kot osnutek',
    'disable_breadcrumbs_staticpages' => 'Disable Breadcrumbs',
    'newstaticpagesinterval' => 'Interval nove statiène strani',
    'hidenewstaticpages' => 'Skrij nove statiène strani',
    'title_trim_length' => 'Krajšanje dolžine naslova',
    'includecenterblocks' => 'Vkljuèi statiène strani osrednjega bloka',
    'includephp' => 'Vkljuèi statiène strani s PHP',
    'includesearch' => 'Omogoèi statiène strani pri iskanju',
    'includesearchcenterblocks' => 'Vkljuèi statiène strani osrednjega bloka',
    'includesearchphp' => 'Vkljuèi statiène strani s PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Glavne nastavitve'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Static Pages Main Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_search' => 'Search Results',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Splošne nastavitve statiènih strani',
    'fs_whatsnew' => 'Blok Kaj je novega',
    'fs_search' => 'Rezultati iskanja',
    'fs_permissions' => 'Prednastavljene pravice',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('Da' => 1, 'Ne' => 0),
    1 => array('Da' => 'velja', 'Ne' => 'ne velja'),
    2 => array('Datum' => 'date', 'ID strani' => 'id', 'Naslov' => 'title'),
    3 => array('Datum' => 'date', 'ID strani' => 'id', 'Naslov' => 'title', 'Nalepka' => 'label'),
    4 => array('Datum' => 'date', 'ID strani' => 'id', 'Naslov' => 'title', 'Avtor' => 'author'),
    5 => array('Skrij' => 'hide', 'Prikaži - uporabi spremenjeni datum' => 'modified', 'Prikaži - uporabi ustvarjeni datum' => 'created'),
    9 => array('Naprej na stran' => 'item', 'Prikaži seznam' => 'list', 'Prikaži vstopno stran' => 'home', 'Prikaži skrbnikovo stran' => 'admin'),
    12 => array('Ni dostopa' => 0, 'Samo za branje' => 2, 'Branje-pisanje' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Komentarji omogoèeni' => 0, 'Komentarji onemogoèeni' => -1)
);

?>
