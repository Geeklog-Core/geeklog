<?php

###############################################################################
# slovenian.php-saved as for version 1.4.1
# This is the english language page for the Geeklog Static Page Plug-in!
# language file for geeklog version 1.4.1 beta by mb
# gape@gape.org ; za pripombe, predloge ipd ... pi�i na email
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
    'staticpages' => 'Statiene strani',
    'staticpageeditor' => 'Urejevalnik statienih strani',
    'writtenby' => 'Napisal:',
    'date' => 'Nazadnje posodobljeno',
    'title' => 'Naslov',
    'page_title' => 'Naslov strani',
    'content' => 'Vsebina',
    'hits' => 'Zadetkov',
    'staticpagelist' => 'Seznam statienih strani',
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
    'nopages' => 'V sistemu �e ni statienih strani',
    'save' => 'shrani',
    'preview' => 'predogled',
    'delete' => 'izbri�i',
    'cancel' => 'prekliei',
    'access_denied' => 'Dostop zavrnjen',
    'access_denied_msg' => 'Nedovoljeno posku�a� dostopiti do ene od skrbni�kih statienih strani. Vsi poskusi nedovoljenega dostopa na se bele�ijo.',
    'all_html_allowed' => 'Dovoljen je ves HTML',
    'results' => 'Rezultati statienih strani',
    'author' => 'Avtor',
    'no_title_or_content' => 'Izpolniti mora� vsaj polji <b>Naslov</b> in <b>Vsebina</b>.',
    'title_error_saving' => 'Error Saving Page',
    'template_xml_error' => 'You have an <em>error in your XML markup</em>. This page is set to use another page as a template and therefore requires template variables to be defined using XML markup. Please see our <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog Wiki</a> for more information on how to do this as it must be corrected before the page can be saved.',
    'no_such_page_anon' => 'Prosim, prijavi se.',
    'no_page_access_msg' => "To je morda zato, ker nisi prijavljen/a ali pa sploh nisi elan spletne strani {$_CONF['site_name']}. Za popoln elanski dostop <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> postani elan</a> spletne strani {$_CONF['site_name']} .",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Opozorilo: Koda PHP na tvoji strani bo procesirana, ee omogoei� to mo�nost. Uporabljaj previdno!',
    'exit_msg' => 'Vrsta izhoda: ',
    'exit_info' => 'Omogoei za Zahtevano prijavno sporoeilo. Za  navadno varnostno preverjanje pusti okence prazno.',
    'deny_msg' => 'Dostop do te strani je zavrnjen. Morda je bila stran premaknjena/odstranjena ali pa nima� zadostnih dovoljenj.',
    'stats_headline' => 'Najbolj�ih 10 statienih strani',
    'stats_page_title' => 'Naslov strani',
    'stats_hits' => 'Zadetki',
    'stats_no_hits' => 'Izgleda, da na tem mestu ni statienih strani ali pa �e nikoli ni nihee nobene pogledal.',
    'id' => 'ID',
    'duplicate_id' => 'Za to statieno stran izbrani ID je �e v rabi. Izberi prosim drug ID.',
    'instructions' => 'Za spreminjanje ali izbris statiene strani klikni na njeno ikono za urejanje spodaj. Za ogled statiene strani klikni na naslov tiste, ki jo hoee� pogledati. Za ustvarjenje nove statiene strani klikni na "Ustvari novo" zgoraj. Za ustvarjenje kopije �e obstojeee statiene strani klikni na ikono za kopiranje.',
    'centerblock' => 'Osrednji blok: ',
    'centerblock_msg' => 'Ee potrdi�, bo ta statiena stran prikazana kot osrednji blok na glavni strani.',
    'topic' => 'Rubrika: ',
    'position' => 'Polo�aj: ',
    'all_topics' => 'Vse',
    'no_topic' => 'Samo vstopna stran',
    'position_top' => 'Vrh strani',
    'position_feat' => 'Za udarnim elankom',
    'position_bottom' => 'Dno strani',
    'position_entire' => 'Cela stran',
    'head_centerblock' => 'Osrednji blok',
    'centerblock_no' => 'Ne',
    'centerblock_top' => 'Zgoraj',
    'centerblock_feat' => 'Udarni elanek',
    'centerblock_bottom' => 'Spodaj',
    'centerblock_entire' => 'Celotna stran',
    'inblock_msg' => 'V bloku: ',
    'inblock_info' => 'Ee potrdi�, bo ta statiena stran prikazana v okvirju (bloku).',
    'title_edit' => 'Uredi stran',
    'title_copy' => 'Naredi kopijo te strani',
    'title_display' => 'Prika�i stran',
    'select_php_none' => 'ne izvedi PHP',
    'select_php_return' => 'izvedi PHP (return)',
    'select_php_free' => 'izvedi PHP',
    'php_not_activated' => "Uporaba PHP-ja na statienih straneh ni vkljueena. Za podrobnosti glej <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">dokumentacijo</a>.",
    'printable_format' => 'Oblika za natis',
    'copy' => 'Kopiraj',
    'limit_results' => 'Omeji rezultate',
    'search' => 'I�ei',
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
    'show_on_page' => 'Show on Page',
    'show_on_page_disabled' => 'Note: This is currently disabled for all pages in the Staticpage Configuration.',
    'cache_time' => 'Cache Time',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled (3600 = 1 hour,  86400 = 1 day). Staticpages with PHP enabled or are a template will not be cached.',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.',
    'autotag_desc_page' => '[page: id alternate title] - Displays a link to a page (from the Static Page plugin) using the page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_page_content' => '[page_content: id] - Displays the contents of a page. (from Static Page plugin)',
    'yes' => 'Yes',
    'used_by' => 'This template is assigned to %s page(s). It is possible this template is used more than specified here if the template is being retrieved via an autotag in another template.',
    'prev_page' => 'Previous page',
    'next_page' => 'Next page',
    'parent_page' => 'Parent page',
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel=�next� and rel=�prev� to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s Page(s)',
    'search_desc' => 'Control if page appears in search. Default depends on setting in Configuration and depends on page type (if it is a Center Block, Uses a Template, or Uses PHP).'
);

$LANG_staticpages_search = array(
    0 => 'Excluded',
    1 => 'Use Default',
    2 => 'Included'
);

$PLG_staticpages_MESSAGE15 = 'Komentar je oddan v pregled in bo objavljen, ko ga odobri urednik.';
$PLG_staticpages_MESSAGE19 = 'Stran je uspe�no shranjena.';
$PLG_staticpages_MESSAGE20 = 'Stran je uspe�no izbrisana.';
$PLG_staticpages_MESSAGE21 = 'Ta stran �e ne obstaja. Za ustvarjenje strani prosim izpolni spodnji formular. Ee si tu po pomoti, klikni gumb Prekliei/Cancel.';
$PLG_staticpages_MESSAGE22 = 'You could not delete the page. It is a template staticpage and it is currently assigned to 1 or more staticpages.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Nadgradnja vtienika ni podprta.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Statiene strani',
    'title' => 'Konfiguracija statienih strani'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Dovoli PHP?',
    'enable_eval_php_save' => 'Parse PHP on Save of Page',
    'sort_by' => 'Osrednje bloke razvrsti po',
    'sort_menu_by' => 'Menijske vpise razvrsti po',
    'sort_list_by' => 'Skrbnikov seznam razvrsti po',
    'delete_pages' => 'Izbri�i strani skupaj z lastnikom?',
    'in_block' => 'Uokviri stran v blok?',
    'show_hits' => 'Prika�i zadetke?',
    'show_date' => 'Prika�i datum?',
    'filter_html' => 'Filtriraj HTML?',
    'censor' => 'Cenzuriraj vsebino?',
    'default_permissions' => 'Prednastavljene pravice strani',
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'Po shranitvi strani',
    'atom_max_items' => 'Najvee strani v feed-u spletnih storitev',
    'meta_tags' => 'Omogoei Meta Tags',
    'comment_code' => 'Prednastavljeni komentarji',
    'structured_data_type_default' => 'Structured Data Type Default',
    'draft_flag' => 'Prednastavljena kot osnutek',
    'disable_breadcrumbs_staticpages' => 'Disable Breadcrumbs',
    'default_cache_time' => 'Default Cache Time',
    'newstaticpagesinterval' => 'Interval nove statiene strani',
    'hidenewstaticpages' => 'Skrij nove statiene strani',
    'title_trim_length' => 'Kraj�anje dol�ine naslova',
    'includecenterblocks' => 'Vkljuei statiene strani osrednjega bloka',
    'includephp' => 'Vkljuei statiene strani s PHP',
    'includesearch' => 'Omogoei statiene strani pri iskanju',
    'includesearchcenterblocks' => 'Vkljuei statiene strani osrednjega bloka',
    'includesearchphp' => 'Vkljuei statiene strani s PHP',
    'includesearchtemplate' => 'Include Template Static Pages'
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
    'fs_main' => 'Splo�ne nastavitve statienih strani',
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
    5 => array('Skrij' => 'hide', 'Prika�i - uporabi spremenjeni datum' => 'modified', 'Prika�i - uporabi ustvarjeni datum' => 'created'),
    9 => array('Naprej na stran' => 'item', 'Prika�i seznam' => 'list', 'Prika�i vstopno stran' => 'home', 'Prika�i skrbnikovo stran' => 'admin'),
    12 => array('Ni dostopa' => 0, 'Samo za branje' => 2, 'Branje-pisanje' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Komentarji omogoeeni' => 0, 'Komentarji onemogoeeni' => -1),
    39 => array('None' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting')
);
