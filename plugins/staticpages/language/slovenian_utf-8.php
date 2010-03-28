<?php

###############################################################################
# slovenian.php-saved as for version 1.4.1
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
    'adminhome' => 'Upravnikova stran',
    'staticpages' => 'Statične strani',
    'staticpageeditor' => 'Urejevalnik statičnih strani',
    'writtenby' => 'Napisal:',
    'date' => 'Nazadnje posodobljeno',
    'title' => 'Naslov',
    'page_title' => 'Page Title',
    'content' => 'Vsebina',
    'hits' => 'Zadetkov',
    'staticpagelist' => 'Seznam statičnih strani',
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
    'nopages' => 'V sistemu še ni statičnih strani',
    'save' => 'shrani',
    'preview' => 'predogled',
    'delete' => 'izbriši',
    'cancel' => 'prekliči',
    'access_denied' => 'Dostop zavrnjen',
    'access_denied_msg' => 'Nedovoljeno poskušaš dostopiti do ene od upravniških statičnih strani.  Vsi poskusi nedovoljenega dostopa na to stran se beležijo.',
    'all_html_allowed' => 'Dovoljen je ves HTML',
    'results' => 'Rezultati statičnih strani',
    'author' => 'Avtor',
    'no_title_or_content' => 'Izpolniti moraš vsaj polji <b>Naslov</b> in <b>Vsebina</b>.',
    'no_such_page_anon' => 'Prosim, prijavi se.',
    'no_page_access_msg' => "To je morda zato, ker nisi prijavljen/a ali pa nisi član spletne strani {$_CONF['site_name']}. Za popoln članski dostop <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> postani član</a> spletne strani {$_CONF['site_name']} .",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Opozorilo: Koda PHP na tvoji strani bo procesirana, če omogočiš to možnost. Uporabljaj previdno!',
    'exit_msg' => 'Vrsta izhoda: ',
    'exit_info' => 'Omogoči za Zahtevano prijavno sporočilo. Za  navadno varnostno preverjanje pusti okence prazno.',
    'deny_msg' => 'Dostop do te strani je zavrnjen. Morda je bila stran premaknjena/odstranjena ali pa nimaš zadostnih dovoljenj.',
    'stats_headline' => 'Najboljših 10 statičnih strani',
    'stats_page_title' => 'Naslov strani',
    'stats_hits' => 'Zadetki',
    'stats_no_hits' => 'Izgleda, da na tem mestu ni statičnih strani ali pa še nikoli ni nihče nobene pogledal.',
    'id' => 'ID',
    'duplicate_id' => 'Za to statično stran izbrani ID je že v rabi. Izberi prosim drug ID.',
    'instructions' => 'Za spreminjanje ali izbris statične strani klikni na njeno ikono za urejanje spodaj. Za ogled statične strani klikni na naslov tiste, ki jo hočeš pogledati. Za ustvarjenje nove statične strani klikni na "Ustvari novo" zgoraj. Za ustvarjenje kopije že obstoječe statične strani klikni na ikono za kopiranje.',
    'centerblock' => 'Osrednji blok: ',
    'centerblock_msg' => 'Če potrdiš, bo ta statična stran prikazana kot osrednji blok na glavni strani.',
    'topic' => 'Rubrika: ',
    'position' => 'Položaj: ',
    'all_topics' => 'Vse',
    'no_topic' => 'Samo domača stran',
    'position_top' => 'Vrh strani',
    'position_feat' => 'Za udarnim člankom',
    'position_bottom' => 'Dno strani',
    'position_entire' => 'Cela stran',
    'head_centerblock' => 'Osrednji blok',
    'centerblock_no' => 'Ne',
    'centerblock_top' => 'Zgoraj',
    'centerblock_feat' => 'Udarni članek',
    'centerblock_bottom' => 'Spodaj',
    'centerblock_entire' => 'Celotna stran',
    'inblock_msg' => 'V bloku: ',
    'inblock_info' => 'Če potrdiš, bo ta statična stran prikazana v okvirju (bloku).',
    'title_edit' => 'Uredi stran',
    'title_copy' => 'Naredi kopijo te strani',
    'title_display' => 'Prikaži stran',
    'select_php_none' => 'ne izvedi PHP',
    'select_php_return' => 'izvedi PHP (return)',
    'select_php_free' => 'izvedi PHP',
    'php_not_activated' => "Uporaba PHP-ja na statičnih straneh ni vključena. Za podrobnosti glej <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">dokumentacijo</a>.",
    'printable_format' => 'Oblika za natis',
    'copy' => 'Kopiraj',
    'limit_results' => 'Omeji rezultate',
    'search' => 'Išči',
    'submit' => 'Oddaj',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages',
    'comments' => 'Comments',
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Static Pages',
    'title' => 'Static Pages Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Allow PHP?',
    'sort_by' => 'Sort Centerblocks by',
    'sort_menu_by' => 'Sort Menu Entries by',
    'sort_list_by' => 'Sort Admin List by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'draft_flag' => 'Draft Flag Default',
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
    'sg_main' => 'Main Settings'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    4 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Author' => 'author'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1)
);

?>
