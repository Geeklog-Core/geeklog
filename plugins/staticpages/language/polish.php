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
    'page_title' => 'Page Title',
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
    'title_error_saving' => 'Error Saving Page',
    'template_xml_error' => 'You have an <em>error in your XML markup</em>. This page is set to use another page as a template and therefore requires template variables to be defined using XML markup. Please see our <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Geeklog Wiki</a> for more information on how to do this as it must be corrected before the page can be saved.',
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
    'page_desc' => 'Setting a previous and/or next page will add HTML link elements rel="next" and rel="prev" to the header to indicate the relationship between pages in a paginated series. Actual page navigation links are not added to the page. You have to add these yourself. NOTE: Parent page is currently not being used.',
    'num_pages' => '%s Page(s)',
    'search_desc' => 'Control if page appears in search. Default depends on setting in Configuration and depends on page type (if it is a Center Block, Uses a Template, or Uses PHP).'
);

$LANG_staticpages_search = array(
    0 => 'Excluded',
    1 => 'Use Default',
    2 => 'Included'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';
$PLG_staticpages_MESSAGE22 = 'You could not delete the page. It is a template staticpage and it is currently assigned to 1 or more staticpages.';

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
    'enable_eval_php_save' => 'Parse PHP on Save of Page',
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
    'structured_data_type_default' => 'Structured Data Type Default',
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
    'includesearchphp' => 'Include Static Pages with PHP',
    'includesearchtemplate' => 'Include Template Static Pages'
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
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1),
    39 => array('None' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting')
);
