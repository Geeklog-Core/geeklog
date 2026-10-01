<?php

###############################################################################
# italian_utf-8.php
# This is the english language file for the Geeklog Static Page plugin
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
#           XX - file id number
#           YY - phrase id number
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
    'delete' => 'Elimina',
    'cancel' => 'Annulla',
    'access_denied' => 'Accesso Negato',
    'access_denied_msg' => 'Stai tentando di accedere illegalmente all\'Amministrazione Pagine Statiche.  Prego nota che tutti i tentativi di accesso illegali sono registrati',
    'all_html_allowed' => 'Tutto l\'HTML permesso',
    'results' => 'Risultati Pagine Statiche',
    'author' => 'Autore',
    'no_title_or_content' => 'Devi almeno compilare i campi <b>Titolo</b> e <b>Contenuto</b>.',
    'title_error_saving' => 'Errore durante il salvataggio della pagina',
    'template_xml_error' => 'Il markup XML contiene un <em>errore</em>. Questa pagina utilizza un’altra pagina come modello e richiede quindi che le variabili del modello siano definite con markup XML. Consulta il <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Wiki di Geeklog</a> per maggiori informazioni. L’errore deve essere corretto prima di salvare la pagina.',
    'no_such_page_anon' => 'Prego entra nel sito..',
    'no_page_access_msg' => "Questo può dipendere dal fatto che non hai effettuato l'accesso o non sei membro di {$_CONF['site_name']}. <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Registrati</a> su {$_CONF['site_name']} per ottenere l'accesso completo.",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Attenzione: il codice PHP della tua pagina sará valutato se abiliti questa opzione. <br',
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
    'php_not_activated' => 'L\'uso di PHP nelle pagine statiche non è attivato. Consulta la <a href="' . $_CONF['site_url'] . '/docs/english/staticpages.html#php">documentazione</a> per i dettagli.',
    'printable_format' => 'Formato Stampabile',
    'copy' => 'Copia',
    'limit_results' => 'Limita i Risultati della ricerca',
    'search' => 'Ricerca',
	'likes' => 'Mi piace',
    'submit' => 'Invia',
    'no_new_pages' => 'Nessuna nuova pagina',
    'pages' => 'Pagine',
    'comments' => 'Commenti',
    'template' => 'Modello',
    'use_template' => 'Usa modello',
    'template_msg' => 'Se selezionata, questa pagina statica verrà contrassegnata come modello.',
    'none' => 'Nessuno',
    'use_template_msg' => 'Se questa pagina statica non è un modello, puoi assegnarle un modello. Se ne selezioni uno, ricorda che il contenuto della pagina deve rispettare il formato XML corretto. Per maggiori informazioni consulta il <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">Wiki di Geeklog</a>.',    'draft' => 'Bozza',
    'draft_yes' => 'Si',
    'draft_no' => 'No',
    'show_on_page' => 'Mostra nella pagina',
    'show_on_page_disabled' => 'Nota: questa opzione è attualmente disattivata per tutte le pagine nella configurazione delle pagine statiche.',
    'cache_time'        => 'Durata cache',
    'cache_time_desc'   => 'Il contenuto di questa pagina statica verrà memorizzato nella cache al massimo per questo numero di secondi. 0 disattiva la cache, -1 mantiene la cache fino alla successiva modifica della pagina. Le pagine con PHP attivo o usate come modello non vengono memorizzate nella cache. (3600 = 1 ora, 86400 = 1 giorno)',
    'autotag_desc_staticpage' => '[staticpage: id titolo alternativo] - Visualizza un collegamento a una pagina statica usando il titolo della pagina. È possibile specificare un titolo alternativo, ma non è obbligatorio.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id] - Visualizza il contenuto di una pagina statica.',
    'autotag_desc_page' => '[page: id titolo alternativo] - Visualizza un collegamento a una pagina del plugin Pagine statiche usando il titolo della pagina. È possibile specificare un titolo alternativo, ma non è obbligatorio.',
    'autotag_desc_page_content' => '[page_content: id] - Visualizza il contenuto di una pagina del plugin Pagine statiche.',
    'yes' => 'Si',
    'used_by' => 'Questo modello è assegnato a %s pagina/e. Potrebbe essere usato da altre pagine se viene richiamato tramite un autotag in un altro modello.',
    'prev_page' => 'Pagina precedente',
    'next_page' => 'Pagina successiva',
    'parent_page' => 'Pagina principale',
    'page_desc' => 'Impostare una pagina precedente e/o successiva indica la relazione tra le pagine di una serie impaginata. I collegamenti di navigazione non vengono aggiunti automaticamente alla pagina e devono essere inseriti manualmente. NOTA: la pagina principale al momento non viene utilizzata.',
    'num_pages' => '%s pagina/e',
    'search_desc' => 'Controlla se la pagina appare nella ricerca. Il valore predefinito dipende dalla configurazione del plugin e dal tipo di pagina (blocco centrale, uso di un modello o uso di PHP).',
	'likes_desc' => 'Determina se e come il controllo Mi piace viene visualizzato nella pagina. Il valore predefinito dipende dalla configurazione del plugin. Le pagine visualizzate come blocchi centrali non mostrano questo controllo. Le pagine usate come modello non utilizzano questa impostazione.'      
);

$PLG_staticpages_MESSAGE15 = 'Il commento è stato inviato per la revisione e sarà pubblicato dopo l’approvazione di un moderatore.';
$PLG_staticpages_MESSAGE19 = 'La pagina è stata salvata correttamente.';
$PLG_staticpages_MESSAGE20 = 'La pagina è stata eliminata correttamente.';
$PLG_staticpages_MESSAGE21 = 'Questa pagina non esiste ancora. Per crearla, compila il modulo seguente. Se sei qui per errore, fai clic su Annulla.';
$PLG_staticpages_MESSAGE22 = 'Impossibile eliminare la pagina: è un modello attualmente assegnato a una o più pagine statiche.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'L’aggiornamento del plugin non è supportato.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Search options for pages
$LANG_staticpages_search = array(
    0  => 'Esclusa',
    1  => 'Usa valore predefinito',
    2  => 'Inclusa'
);

// Likes options for pages 
// The same values for these options will match values for the config option "likes_pages"
$LANG_staticpages_likes = array(
    -1 => 'Usa valore predefinito',
    0  => 'Disattivato',
    1  => 'Mi piace e Non mi piace',
    2  => 'Solo Mi piace',
);

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Pagine Statiche',
    'title' => 'Configurazione delle Pagine Statiche'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Permettere PHP?',
    'enable_eval_php_save' => 'Analizza PHP al salvataggio della pagina',
    'sort_by' => 'Ordina i Centerblock secondo',
    'sort_menu_by' => 'Ordina gli Elementi del Menu secondo',
    'sort_list_by' => 'Ordina la Lista Ammin secondo',
    'delete_pages' => 'Eliminare le pagine insieme al proprietario?',
    'in_block' => 'Racchiudere le pagine in un blocco?',
    'show_hits' => 'Mostrare Visite?',
    'show_date' => 'Motrare Data?',
    'filter_html' => 'Filtrare HTML?',
    'censor' => 'Censurare il Contenuto?',
    'default_permissions' => 'Autorizzazioni predefinite per pagine',
    'autotag_permissions_staticpage' => 'Permessi [staticpage: ]',
    'autotag_permissions_staticpage_content' => 'Permessi [staticpage_content: ]',
    'aftersave' => 'Dopo Aver Salvato la Pagina',
    'atom_max_items' => 'Numero massimo di pagine nel feed Webservices',
    'meta_tags' => 'Abilita Meta Tags',
	'likes_pages' => 'Mi piace delle pagine',
    'comment_code' => 'Comporatamento Predefinito per Commenti',
    'structured_data_type_default' => 'Tipo predefinito di dati strutturati',
    'draft_flag' => 'Bozza predefinita',
    'disable_breadcrumbs_staticpages' => 'Disattiva breadcrumb',
    'default_cache_time' => 'Durata predefinita della cache',
    'newstaticpagesinterval' => 'Intervallo per Nuove Pagine Statiche',
    'hidenewstaticpages' => 'Nascondi Nuove Pagine Statiche',
    'title_trim_length' => 'Massima Lunghezza del Titolo',
    'includecenterblocks' => 'Includi pagine statiche come blocco centrale',
    'includephp' => 'Includi Pagine Statiche con PHP',
    'includesearch' => 'Mostra Pagine Statiche Nei Risultati Di Ricerca',
    'includesearchcenterblocks' => 'Includi pagine statiche come blocco centrale',
    'includesearchphp' => 'Mostra Pagine Statiche con PHP',
    'includesearchtemplate' => 'Includi pagine statiche usate come modello'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Impostazioni Principali'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Impostazioni principali delle pagine statiche',
    'tab_whatsnew' => 'Blocco Novità',
    'tab_search' => 'Risultati della ricerca',
    'tab_permissions' => 'Permessi predefiniti',
    'tab_autotag_permissions' => 'Permessi di utilizzo degli autotag'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Impostazioni Principali per Pagine Statiche',
    'fs_whatsnew' => 'Blocco Per Novitá',
    'fs_search' => 'Risultati di Ricerca',
    'fs_permissions' => 'Autorizzazioni predefinite',
    'fs_autotag_permissions' => 'Permessi di utilizzo degli autotag'
);

// Note: entries 0, 1, 9, 12, 17, 39, 41 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('Vero' => 1, 'Falso' => 0),
    1 => array('Vero' => TRUE, 'Falso' => FALSE),
    2 => array('Data' => 'date', 'ID pagina' => 'id', 'Titolo' => 'title'),
    3 => array('Data' => 'date', 'ID pagina' => 'id', 'Titolo' => 'title', 'Etichetta' => 'label'),
    4 => array('Data' => 'date', 'ID pagina' => 'id', 'Titolo' => 'title', 'Autore' => 'author'),
    5 => array('Nascondi' => 'hide', 'Mostra - usa data di modifica' => 'modified', 'Mostra - usa data di creazione' => 'created'),
    9 => array('Vai alla pagina' => 'item', 'Mostra elenco' => 'list', 'Mostra home' => 'home', 'Mostra amministrazione' => 'admin'),
    12 => array('Nessun accesso' => 0, 'Sola lettura' => 2, 'Lettura e scrittura' => 3),
    13 => array('Nessun accesso' => 0, 'Usa' => 2),
    17 => array('Commenti abilitati' => 0, 'Commenti disabilitati' => -1),
    39 => array('Nessuno' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting'),
    41 => array('Falso' => 0, 'Mi piace e Non mi piace' => 1, 'Solo Mi piace' => 2)
);
