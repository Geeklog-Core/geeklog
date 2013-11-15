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
    'title' => 'Tytuł',
    'page_title' => 'Page Title',
    'content' => 'Zawartość',
    'hits' => 'Odsłon',
    'staticpagelist' => 'Lista Stron Statycznych',
    'url' => 'URL',
    'edit' => 'Edycja',
    'lastupdated' => 'Ostatnia Aktualizacja',
    'pageformat' => 'Format Strony',
    'leftrightblocks' => 'Lewe & Prawe Bloki',
    'blankpage' => 'Nowe Okno',
    'noblocks' => 'Bez Bloków',
    'leftblocks' => 'Lewe Bloki',
    'addtomenu' => 'Dodaj Do Menu',
    'label' => 'Etykieta',
    'nopages' => 'Brak stron statycznych w systemie',
    'save' => 'zapisz',
    'preview' => 'podgląd',
    'delete' => 'kasuj',
    'cancel' => 'anuluj',
    'access_denied' => 'Odmowa Dostępu',
    'access_denied_msg' => 'Próbujesz nielegalnie  dostać się do panelu administrującego Stronami Statycznymi.  Proszę mieć na uwadze, że wszelkie nieautoryzowane próby wejścia są logowane',
    'all_html_allowed' => 'Wszystkie Znaczniki HTML są dozwolone',
    'results' => 'Wyniki Dla Stron Statycznych',
    'author' => 'Autor',
    'no_title_or_content' => 'Musisz wypełnić co najmniej pola <b>Tytuł</b> i <b>Zawartość</b>.',
    'no_such_page_anon' => 'Prosze się zalogować..',
    'no_page_access_msg' => "Może to być spowodowane tym, że nie jesteś zalogowana/-y lub zarejestrowanan/-y w Serwisie {$_CONF['site_name']}. Proszę <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> zarejestrować się</a> of {$_CONF['site_name']} aby otrzymać przywileje użytkowników zarejestrowanych",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Uwaga: jeśli aktywujesz tę opcję to kod PHP zawarty w Twojej stronie zostanie zweryfikowany. Używaj ostrożnie !!',
    'exit_msg' => 'Rodzaj Wyjścia: ',
    'exit_info' => 'Aktywuj na potrzeby komunikatu Wymagany Login.  Zostaw puste dla normalnego testu zabezpieczeń i komunikatu.',
    'deny_msg' => 'Brak dostępu do tej strony. Albo strona została przeniesiona/usunięta albo nie masz wystarczających uprawnień.',
    'stats_headline' => '10 Najpopularniejszych Stron Statycznych',
    'stats_page_title' => 'Tytuł Strony',
    'stats_hits' => 'Odsłon',
    'stats_no_hits' => 'Wygląda na to, że nie ma żadnych stron statycznych albo nikt ich do tej pory nie oglądał.',
    'id' => 'ID',
    'duplicate_id' => 'Wybrane ID dla danej strony jest już w użyciu. Proszę wpisać inne ID.',
    'instructions' => 'Aby zmodyfikować lub usunąć stronę statyczną, kliknij na numer strony poniżej. Aby podglądnąć stronę statyczną, kliknij na tytuł strony. Aby stworzyć nową stronę kliknij Nowa Strona powyżej. Kliknij [C] aby skopiować istniejącą stronę.',
    'centerblock' => 'Blok Środkowy: ',
    'centerblock_msg' => 'W przypadku zaznaczenia, dana Strona Statyczna będzie widoczna jako blok środkowy na stronie głównej.',
    'topic' => 'Sekcja: ',
    'position' => 'Pozycja: ',
    'all_topics' => 'Wszystkie',
    'no_topic' => 'Tylko Strona Główna',
    'position_top' => 'Góra Strony',
    'position_feat' => 'Po Artykule Dnia',
    'position_bottom' => 'Dół Strony',
    'position_entire' => 'Cała Strona',
    'head_centerblock' => 'Blok Środkowy',
    'centerblock_no' => 'Nie',
    'centerblock_top' => 'Góra',
    'centerblock_feat' => 'Strona Dnia',
    'centerblock_bottom' => 'Dół',
    'centerblock_entire' => 'Cała Strona',
    'inblock_msg' => 'W bloku: ',
    'inblock_info' => 'Zawijaj Stronę Statyczną w bloku.',
    'title_edit' => 'Edycja strony',
    'title_copy' => 'Utwórz kopię tej strony',
    'title_display' => 'Pokaż stronę',
    'select_php_none' => 'nie wykonuj kodu PHP',
    'select_php_return' => 'wykonaj kod PHP (enter)',
    'select_php_free' => 'wykonaj kod PHP',
    'php_not_activated' => "Używanie PHP w stronie statycznej nie jest aktywne. Sprawdź szczegóły w <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">dokumentacji</a>.",
    'printable_format' => 'Printable Format',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages',
    'comments' => 'Comments',
    'template' => 'Template',
    'use_template' => 'Use Template',
    'template_msg' => 'When checked, this Static Page will be marked as a template.',
    'none' => 'None',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No',
    'cache_time' => 'Cache Time',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled (3600 = 1 hour,  86400 = 1 day). Staticpages with PHP enabled or are a template will not be cached.',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.'
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
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'draft_flag' => 'Draft Flag Default',
    'disable_breadcrumbs_staticpages' => 'Disable Breadcrumbs',
    'default_cache_time' => 'Default Cache Time',
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

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Static Pages Main Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_search' => 'Search Results',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
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
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1)
);

?>
