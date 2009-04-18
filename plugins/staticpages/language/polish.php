<?php

###############################################################################
# polish.php
# This is the Polish language page for the Geeklog Static Page Plug-in!
# Translation by Robert Stadnik robert_stadnik@wp.pl
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
    'newpage' => 'Nowa Strona',
    'adminhome' => 'Centrum Admina',
    'staticpages' => 'Strony Statyczne',
    'staticpageeditor' => 'Edytor Stron Statycznych',
    'writtenby' => 'Autor',
    'date' => 'Ostatnia Aktualizacja',
    'title' => 'Tytu�',
    'content' => 'Zawarto��',
    'hits' => 'Ods�on',
    'staticpagelist' => 'Lista Stron Statycznych',
    'url' => 'URL',
    'edit' => 'Edycja',
    'lastupdated' => 'Ostatnia Aktualizacja',
    'pageformat' => 'Format Strony',
    'leftrightblocks' => 'Lewe & Prawe Bloki',
    'blankpage' => 'Nowe Okno',
    'noblocks' => 'Bez Blok�w',
    'leftblocks' => 'Lewe Bloki',
    'addtomenu' => 'Dodaj Do Menu',
    'label' => 'Etykieta',
    'nopages' => 'Brak stron statycznych w systemie',
    'save' => 'zapisz',
    'preview' => 'podgl�d',
    'delete' => 'kasuj',
    'cancel' => 'anuluj',
    'access_denied' => 'Odmowa Dost�pu',
    'access_denied_msg' => 'Pr�bujesz nielegalnie  dosta� si� do panelu administruj�cego Stronami Statycznymi.  Prosz� mie� na uwadze, �e wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    'all_html_allowed' => 'Wszystkie Znaczniki HTML s� dozwolone',
    'results' => 'Wyniki Dla Stron Statycznych',
    'author' => 'Autor',
    'no_title_or_content' => 'Musisz wype�ni� co najmniej pola <b>Tytu�</b> i <b>Zawarto��</b>.',
    'no_such_page_anon' => 'Prosze si� zalogowa�..',
    'no_page_access_msg' => "Mo�e to by� spowodowane tym, �e nie jeste� zalogowana/-y lub zarejestrowanan/-y w Serwisie {$_CONF['site_name']}. Prosz� <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> zarejestrowa� si�</a> of {$_CONF['site_name']} aby otrzyma� przywileje u�ytkownik�w zarejestrowanych",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Uwaga: je�li aktywujesz t� opcj� to kod PHP zawarty w Twojej stronie zostanie zweryfikowany. U�ywaj ostro�nie !!',
    'exit_msg' => 'Rodzaj Wyj�cia: ',
    'exit_info' => 'Aktywuj na potrzeby komunikatu Wymagany Login.  Zostaw puste dla normalnego testu zabezpiecze� i komunikatu.',
    'deny_msg' => 'Brak dost�pu do tej strony. Albo strona zosta�a przeniesiona/usuni�ta albo nie masz wystarczaj�cych uprawnie�.',
    'stats_headline' => '10 Najpopularniejszych Stron Statycznych',
    'stats_page_title' => 'Tytu� Strony',
    'stats_hits' => 'Ods�on',
    'stats_no_hits' => 'Wygl�da na to, �e nie ma �adnych stron statycznych albo nikt ich do tej pory nie ogl�da�.',
    'id' => 'ID',
    'duplicate_id' => 'Wybrane ID dla danej strony jest ju� w u�yciu. Prosz� wpisa� inne ID.',
    'instructions' => 'Aby zmodyfikowa� lub usun�� stron� statyczn�, kliknij na numer strony poni�ej. Aby podgl�dn�� stron� statyczn�, kliknij na tytu� strony. Aby stworzy� now� stron� kliknij Nowa Strona powy�ej. Kliknij [C] aby skopiowa� istniej�c� stron�.',
    'centerblock' => 'Blok �rodkowy: ',
    'centerblock_msg' => 'W przypadku zaznaczenia, dana Strona Statyczna b�dzie widoczna jako blok �rodkowy na stronie g��wnej.',
    'topic' => 'Sekcja: ',
    'position' => 'Pozycja: ',
    'all_topics' => 'Wszystkie',
    'no_topic' => 'Tylko Strona G��wna',
    'position_top' => 'G�ra Strony',
    'position_feat' => 'Po Artykule Dnia',
    'position_bottom' => 'D� Strony',
    'position_entire' => 'Ca�a Strona',
    'head_centerblock' => 'Blok �rodkowy',
    'centerblock_no' => 'Nie',
    'centerblock_top' => 'G�ra',
    'centerblock_feat' => 'Strona Dnia',
    'centerblock_bottom' => 'D�',
    'centerblock_entire' => 'Ca�a Strona',
    'inblock_msg' => 'W bloku: ',
    'inblock_info' => 'Zawijaj Stron� Statyczn� w bloku.',
    'title_edit' => 'Edycja strony',
    'title_copy' => 'Utw�rz kopi� tej strony',
    'title_display' => 'Poka� stron�',
    'select_php_none' => 'nie wykonuj kodu PHP',
    'select_php_return' => 'wykonaj kod PHP (enter)',
    'select_php_free' => 'wykonaj kod PHP',
    'php_not_activated' => "U�ywanie PHP w stronie statycznej nie jest aktywne. Sprawd� szczeg�y w <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">dokumentacji</a>.",
    'printable_format' => 'Printable Format',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit'
);

$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';

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
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
