<?php

###############################################################################
# italian.php
# This is the Italian language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 magomarcelo magomarcelo@gmail.com magomarcelo.blogspot.com
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
    'newpage' => 'Nuova Pagina',
    'adminhome' => 'Home Amministrazione',
    'staticpages' => 'Pagine Statiche',
    'staticpageeditor' => 'Editor Pagine Statiche',
    'writtenby' => 'Scritto da',
    'date' => 'Ultimo Agg.',
    'title' => 'Titolo',
    'page_title' => 'Page Title',
    'content' => 'Contenuto',
    'hits' => 'Visite',
    'staticpagelist' => 'Lista Pagine Statiche',
    'url' => 'URL',
    'edit' => 'Modifica',
    'lastupdated' => 'Ultimo Agg.',
    'pageformat' => 'Formato Pag.',
    'leftrightblocks' => 'Blocchi a Sinistra & Destra',
    'blankpage' => 'Pagina Vuota',
    'noblocks' => 'Nessun Blocco',
    'leftblocks' => 'Blocchi a Sinistra',
    'addtomenu' => 'Agg. al Menu',
    'label' => 'Etichetta',
    'nopages' => 'Nessuna pagina statica al momento nel sistema',
    'save' => 'Salva',
    'preview' => 'Anteprima',
    'delete' => 'Cancella',
    'cancel' => 'Elimina',
    'access_denied' => 'Accesso Negato',
    'access_denied_msg' => 'Stai tentando di accedere illegalmente all\'Amministrazione Pagine Statiche.  Prego nota che tutti i tentativi di accesso illegali sono registrati',
    'all_html_allowed' => 'Tutto l\'HTML permesso',
    'results' => 'Risultati Pagine Statiche',
    'author' => 'Autore',
    'no_title_or_content' => 'Devi almeno compilare i campi <b>Titolo</b> e <b>Contenuto</b>.',
    'no_such_page_anon' => 'Prego entra nel sito..',
    'no_page_access_msg' => "Questo potrebbe indicare che tu non sei entrato nel sito, o non sei un membro di {$_CONF['site_name']}. Prego <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> diventa un membro</a> di {$_CONF['site_name']} per ricevere pieno accesso al sito",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Attenzione: il codice PHP della tua pagina sar&agrave; valutato se abiliti questa opzione. <br' . XHTML . '><strong>Usare con cautela !!</strong>',
    'exit_msg' => 'Tipo Uscita: ',
    'exit_info' => 'Abilita per Richiesta Messaggio di Login.  Lascia deselezionato per il normale controllo di sicurezza e messaggio.',
    'deny_msg' => 'Accesso a questa pagina negato.  Pu&ograve; essere che questa pagina &egrave; stata spostata/rimossa o che non hai i permessi sufficiente per visulaizzarla.',
    'stats_headline' => 'Top 10 Pagine Statiche',
    'stats_page_title' => 'Titolo Pagina',
    'stats_hits' => 'Visite',
    'stats_no_hits' => 'Sembra che non ci siano pagine statiche in questo sito o che nessuno ne ha ancora visualizzata una.',
    'id' => 'ID',
    'duplicate_id' => 'L\'ID che hai selezionato per questa pagina statica &egrave; gi&agrave; in uso. Prego seleziona un\'altro ID.',
    'instructions' => 'Per modificare o eliminare una pagina statica, clicca sul numero della pagina sotto. Per visualizzare una pagina statica, clicca sul titolo della pagina che desideri vedere. Per creare una nuova pagina statica clicca su [ Nuova Pagina ] sopra. Clicca su [C] per creare una copia di una pagina esistente.',
    'centerblock' => 'BloccoCentrale: ',
    'centerblock_msg' => 'Quando selezionato, questa Pagina Statica sar&agrave; visualizzata come un blocco centrale nella pagina index.',
    'topic' => 'Argomento: ',
    'position' => 'Posizione: ',
    'all_topics' => 'Tutte',
    'no_topic' => 'Solo Homepage',
    'position_top' => 'Capo Pagina',
    'position_feat' => 'Dopo Articolo Evidenziato',
    'position_bottom' => 'Fine Pagina',
    'position_entire' => 'Pagina Intera',
    'head_centerblock' => 'BloccoCentrale',
    'centerblock_no' => 'No',
    'centerblock_top' => 'Capo Pag.',
    'centerblock_feat' => 'Art. Evidenz.',
    'centerblock_bottom' => 'Fine Pag.',
    'centerblock_entire' => 'Intera Pagina',
    'inblock_msg' => 'In un blocco: ',
    'inblock_info' => 'Racchiudi Pagina Statica in un blocco.',
    'title_edit' => 'Modifica Pagina',
    'title_copy' => 'Duplica questa pagina',
    'title_display' => 'Visualizza pagina',
    'select_php_none' => 'non eseguire PHP',
    'select_php_return' => 'esegui PHP (return)',
    'select_php_free' => 'esegui PHP',
    'php_not_activated' => "L'uso di PHP nelle pagine statiche &egrave; disattivato. Prego vedi la <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">documentazione</a> per dettagli.",
    'printable_format' => 'Formato Stampabile',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit',
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
