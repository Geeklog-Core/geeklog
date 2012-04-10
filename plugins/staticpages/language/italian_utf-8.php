<?php

###############################################################################
# italian.php
# This is the Italian language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs tony@tonybibbs.com
# Copyright (C) 2005 magomarcelo magomarcelo@gmail.com magomarcelo.blogspot.com
# Copyright (C) 2010 Rouslan Placella - rouslan {at} placella {dot} com
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
    'page_title' => 'Titolo della pagina',
    'content' => 'Contenuto',
    'hits' => 'Visite',
    'staticpagelist' => 'Lista Pagine Statiche',
    'url' => 'URL',
    'edit' => 'Modifica',
    'lastupdated' => 'Ultimo Agg.',
    'pageformat' => 'Formato Pag.',
    'leftrightblocks' => 'Blocchi a Sinistra e Destra',
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
    'php_warn' => 'Attenzione: il codice PHP della tua pagina sará valutato se abiliti questa opzione. <br' . XHTML . '><strong>Usare con cautela !!</strong>',
    'exit_msg' => 'Tipo Uscita: ',
    'exit_info' => 'Abilita per Richiesta Messaggio di Login.  Lascia deselezionato per il normale controllo di sicurezza e messaggio.',
    'deny_msg' => 'Accesso a questa pagina negato.  Puó essere che questa pagina é stata spostata/rimossa o che non hai i permessi sufficiente per visulaizzarla.',
    'stats_headline' => 'Top 10 Pagine Statiche',
    'stats_page_title' => 'Titolo Pagina',
    'stats_hits' => 'Visite',
    'stats_no_hits' => 'Sembra che non ci siano pagine statiche in questo sito o che nessuno ne ha ancora visualizzata una.',
    'id' => 'ID',
    'duplicate_id' => 'L\'ID che hai selezionato per questa pagina statica é giá in uso. Prego seleziona un\'altro ID.',
    'instructions' => 'Per modificare o eliminare una pagina statica, clicca sul numero della pagina sotto. Per visualizzare una pagina statica, clicca sul titolo della pagina che desideri vedere. Per creare una nuova pagina statica clicca su [ Nuova Pagina ] sopra. Clicca su [C] per creare una copia di una pagina esistente.',
    'centerblock' => 'BloccoCentrale: ',
    'centerblock_msg' => 'Quando selezionato, questa Pagina Statica sará visualizzata come un blocco centrale nella pagina index.',
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
    'php_not_activated' => "L'uso di PHP nelle pagine statiche é disattivato. Prego vedi la <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">documentazione</a> per dettagli.",
    'printable_format' => 'Formato Stampabile',
    'copy' => 'Copia',
    'limit_results' => 'Limita i Risultati della ricerca',
    'search' => 'Ricerca',
    'submit' => 'Invia',
    'no_new_pages' => 'Nessuna nuova pagina',
    'pages' => 'Pagine',
    'comments' => 'Commenti',
    'template' => 'Template',
    'use_template' => 'Use Template',
    'template_msg' => 'When checked, this Static Page will be marked as a template.',
    'none' => 'None',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => 'Bozza',
    'draft_yes' => 'Si',
    'draft_no' => 'No',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.'
);

$PLG_staticpages_MESSAGE15 = 'Il suo commento é stato ricevuto e sará pubblicato appena approvato da un moderatore.';
$PLG_staticpages_MESSAGE19 = 'La sua pagina é stata salvata.';
$PLG_staticpages_MESSAGE20 = 'La pagina é stata eliminata.';
$PLG_staticpages_MESSAGE21 = 'Questa pagina non esiste. Compila la scheda sottostante per creare la pagina. Premi \'annulla\' se sei capitato su questa pagina a causa di un errore.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'L\'aggiornamento di plugin non é supportato.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Pagine Statiche',
    'title' => 'Configurazione delle Pagine Statiche'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Permettere PHP?',
    'sort_by' => 'Ordina i Centerblock secondo',
    'sort_menu_by' => 'Ordina gli Elementi del Menu secondo',
    'sort_list_by' => 'Ordina la Lista Ammin secondo',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Mostrare Visite?',
    'show_date' => 'Motrare Data?',
    'filter_html' => 'Filtrare HTML?',
    'censor' => 'Censurare il Contenuto?',
    'default_permissions' => 'Autorizzazioni predefinite per pagine',
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'Dopo Aver Salvato la Pagina',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Abilita Meta Tags',
    'comment_code' => 'Comporatamento Predefinito per Commenti',
    'draft_flag' => 'Draft Flag Default',
    'disable_breadcrumbs_staticpages' => 'Disable Breadcrumbs',
    'newstaticpagesinterval' => 'Intervallo per Nuove Pagine Statiche',
    'hidenewstaticpages' => 'Nascondi Nuove Pagine Statiche',
    'title_trim_length' => 'Massima Lunghezza del Titolo',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Includi Pagine Statiche con PHP',
    'includesearch' => 'Mostra Pagine Statiche Nei Risultati Di Ricerca',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Mostra Pagine Statiche con PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Impostazioni Principali'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Static Pages Main Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_search' => 'Search Results',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Impostazioni Principali per Pagine Statiche',
    'fs_whatsnew' => 'Blocco Per Novitá',
    'fs_search' => 'Risultati di Ricerca',
    'fs_permissions' => 'Autorizzazioni predefinite',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('Vero' => 1, 'Falso' => 0),
    1 => array('Vero' => true, 'Falso' => false),
    2 => array('Data' => 'date', 'ID Pagina' => 'id', 'Titolo' => 'title'),
    3 => array('Data' => 'date', 'ID Pagina' => 'id', 'Titolo' => 'title', 'Label' => 'label'),
    4 => array('Data' => 'date', 'ID Pagina' => 'id', 'Titolo' => 'title', 'Autore' => 'author'),
    5 => array('Nascondi' => 'hide', 'Mostra - Usa Data dell\'ultima modifica' => 'modified', 'Mostra - Usa Data  creazione' => 'created'),
    9 => array('Mostra Pagina' => 'item', 'Mostra Lista' => 'list', 'Mostra Home' => 'home', 'Mostra Ammin' => 'admin'),
    12 => array('Nessun Accesso' => 0, 'Solo Lettura' => 2, 'Lettura e Scrittura' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Commenti Abilitati' => 0, 'Commenti Disabilitati' => -1)
);

?>
