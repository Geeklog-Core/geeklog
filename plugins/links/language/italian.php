<?php

###############################################################################
# italian.php
#
# This is the Italian language file for the Geeklog Links Plugin
#
# Copyright (C) 2010 Rouslan Placella rouslan {at} placella {dot} com
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

$LANG_LINKS = array(
    10 => 'Inserimenti',
    14 => 'Collegamenti',
    84 => 'Collegamenti',
    88 => 'Nessun Collegamento Recente',
    114 => 'Collegamenti',
    116 => 'Crea un Collegamento',
    117 => 'Segnala Collegamento non Funzionante',
    118 => 'Segnalazione Collegamento non Funzionante',
    119 => 'Il Seguente Collegamento é Stato Segnalato Come Non Funzionante: ',
    120 => 'Clicca Qui Per Modificare il Collegamento: ',
    121 => 'Il Collegamento Non Funzionante é Stato Segnalato Da: ',
    122 => 'Grazie Per Aver Segnalato Questo Collegamento. L\'amministratore correggerá questo problema al piú presto possibile',
    123 => 'Grazie',
    124 => 'Invia',
    125 => 'Categorie',
    126 => 'Sei qui:',
    'autotag_desc_link' => '[link: id alternate title] - Displays a link to a Link from the Links Plugin using the Link Title as the title. An alternate title may be specified but is not required.',
    'root' => 'Categoria Principale'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Collegamenti (Visite) nel sistema',
    'stats_headline' => 'Top 10 Collegamenti',
    'stats_page_title' => 'Collegamenti',
    'stats_hits' => 'Visite',
    'stats_no_hits' => 'Sembra che non ci siano collegamenti in questo sito o che nessuno ne ha ancora utilizzato uno.'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => 'Risultati (Collegamenti)',
    'title' => 'Titolo',
    'date' => 'Data Dell\'Inserimento',
    'author' => 'Inserito Da',
    'hits' => 'Visite'
);

###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'Inserisci un Collegamento',
    2 => 'Collegamento',
    3 => 'Categoria',
    4 => 'Altro',
    5 => 'Se Altro, specifica',
    6 => 'Errore: Nessuna Categoria',
    7 => 'Specifica il nome di una categorie, se "Altro" é stato selezionato.',
    8 => 'Titolo',
    9 => 'Indirizzo',
    10 => 'Categoria',
    11 => 'Inserimenti di Collegamenti'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Grazie per l'invio del collegamento a {$_CONF['site_name']}.  Presto sará esaminato da uno dei amministratori.  Se approvato, verrá visualizzato in <a href={$_CONF['site_url']}/links/index.php>questa</a> sezione.";
$PLG_links_MESSAGE2 = 'Il tuo collegamento é stato salvato.';
$PLG_links_MESSAGE3 = 'Il collegamento é stato eliminato.';
$PLG_links_MESSAGE4 = "Grazie per l'invio del collegamento a {$_CONF['site_name']}.  é ora disponibile in <a href={$_CONF['site_url']}/links/index.php>questa</a> sezione.";
$PLG_links_MESSAGE5 = 'Non hai le necessarie autorizzazioni per visualizzare questa categoria.';
$PLG_links_MESSAGE6 = 'Non hai le necessarie autorizzazioni per modificare questa categoria.';
$PLG_links_MESSAGE7 = 'Specifica il nome per la Categoria ed una Descrizione.';
$PLG_links_MESSAGE10 = 'La tua categoria é stata salvata.';
$PLG_links_MESSAGE11 = 'Gli id "site" or "user" sono riservati per uso interno. Scegli un altro id.';
$PLG_links_MESSAGE12 = 'Stai cercando di spostare una categoria nella sua stessa categoria dipendente. Questo non é permesso. Prego sposta le categorie dipendenti ad un livello superiore e riprova.';
$PLG_links_MESSAGE13 = 'La categoria é stata eliminata.';
$PLG_links_MESSAGE14 = 'Questa categoria contiene altre categorie e/o collegamenti. Elimina questi elementi o spostali in un altra categoria';
$PLG_links_MESSAGE15 = 'Non hai le necessarie autorizzazioni per eliminare questa categoria.';
$PLG_links_MESSAGE16 = 'Questa categoria non esiste.';
$PLG_links_MESSAGE17 = 'Questo id é giá utilizzato da un altra categoria.';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'L\'aggiornamento delle Estensioni plugin non é supportato.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

$LANG_LINKS_ADMIN = array(
    1 => 'Editor Collegamenti',
    2 => 'ID del Collegamento',
    3 => 'Titolo del Collegamento',
    4 => 'Indirizzo del Collegamento',
    5 => 'Categoria',
    6 => '(includi http://)',
    7 => 'Altro',
    8 => 'Visite del Collegamento',
    9 => 'Descrizione del Collegamento',
    10 => 'Il Titolo, Indirizzo e la Descrizione Sono Necessari per Salvare il Collegamento.',
    11 => 'Manager Collegamenti',
    12 => 'Per modificare o eliminare un collegamento, clicca sull\'icona di modifica sottostante. Per creare un nuovo collegamento o categoria, clicca su "Nuovo Collegamento" o "Nuova Categoria". Per modificare piú di una categoria, clicca su "Mostra Categorie".',
    14 => 'Categoria del Collegamento',
    16 => 'Accesso Negato',
    17 => "Hai cercato di accedere ad un collegamento per il quale non hai le necessarie autorizzazioni. Questo tentativo é stato salvato. <a href\"{$_CONF['site_admin_url']}/plugins/links/index.php\">Ritorna alo scermo amministrativo dei collegamenti</a>.",
    20 => 'Se altro, specifica',
    21 => 'salva',
    22 => 'annulla',
    23 => 'elimina',
    24 => 'Collegamento non trovato',
    25 => 'Il collegamento che hai selezionato non é stato trovato.',
    26 => 'Controlla Collegamenti',
    27 => 'Risposta HTTP',
    28 => 'Modifica categoria',
    29 => 'Inserisci o modifica i dettagli sottostanti.',
    30 => 'Categoria',
    31 => 'Descrizione',
    32 => 'ID della Categoria',
    33 => 'Argomento',
    34 => 'Parent',
    35 => 'Tutti',
    40 => 'Modifica questa categoria',
    41 => 'Crea categoria dipendente',
    42 => 'Elimina questa categoria',
    43 => 'Categorie del sito',
    44 => 'Aggiungi&nbsp;dipendente',
    46 => 'Utente %s ha cercato di eliminare una categoria per la quale non ha le necessarie autorizzazioni',
    50 => 'Mostra categorie',
    51 => 'Nuovo Collegamento',
    52 => 'Nuova Categoria',
    53 => 'Mostra Collegamenti',
    54 => 'Manager Categorie',
    55 => 'Modifica le categorie sottostanti. Nota che non é possibile eliminare una categoria che contiene altre categorie o collegamenti - prima é necessario eliminare questi elementi o spostarli in un altra categoria',
    56 => 'Editor Categorie',
    57 => 'Non controllato',
    58 => 'Controlla Collegamenti',
    59 => '<p>Per controllare tutti i collegamenti, clicca su "Controlla Collegamenti". Nota che questa operazione potrebbe richiedere del tempo a seconda del numero di collegamenti visualizzati.</p>',
    60 => 'Utente %s ha cercato di modificare la categoria %s senza le necessarie autorizzazioni.',
    61 => 'Collegamenti Nella Categoria'
);


$LANG_LINKS_STATUS = array(
    100 => 'Continua',
    101 => 'Commutazione Protocolli',
    200 => 'OK',
    201 => 'Creato',
    202 => 'Accettato',
    203 => 'Informazione Non Autorevole',
    204 => 'Nessun Contenuto',
    205 => 'Reimposta Contenuto',
    206 => 'Contenuto Parziale',
    300 => 'Multiple Choices',
    301 => 'Spostato Permanentemente',
    302 => 'Oggetto Spostato',
    303 => 'See Other',
    304 => 'Non Modificato',
    305 => 'Utilizza un Proxy',
    307 => 'Reindirizzamento Temporaneo',
    400 => 'Richiesta Errata',
    401 => 'Accesso Negato',
    402 => 'Pagamento Necessario',
    403 => 'Operazione Non Consentita',
    404 => 'Oggetto Non Trovato',
    405 => 'Metodo Non Consentito',
    406 => 'Non Consentito',
    407 => 'Autenticazione Proxy Necessaria',
    408 => 'Richiesta Scaduta',
    409 => 'Conflitto',
    410 => 'Gone',
    411 => 'Lunghezza richiesta',
    412 => 'Condizione preliminare non riuscita',
    413 => 'Entitá della richiesta troppo grande',
    414 => 'L\'indirizzo della richiest é troppo lungo',
    415 => 'Unsupported Media Type',
    416 => 'L\'Intervallo Richiesto non é valido',
    417 => 'Expectation Failed',
    500 => 'Errore interno del server',
    501 => 'Valori di intestazione specificano una configurazione non è implementata',
    502 => 'Gateway non valido',
    503 => 'Servizio non disponibile',
    504 => 'Gateway Timeout',
    505 => 'Versione HTTP Non Supportata',
    999 => 'Connessione Scaduta'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => 'Collegamenti',
    'title' => 'Configurazione dei Collegamenti'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => 'Login Necessario?',
    'linksubmission' => 'Mettere Inserimenti in Coda?',
    'newlinksinterval' => 'Intervallo per Nuovi Collegamenti',
    'hidenewlinks' => 'Nascondere Nuovi Collegamenti?',
    'hidelinksmenu' => 'Nascondere Collegamenti nel Menu?',
    'linkcols' => 'Categorie per Colunna',
    'linksperpage' => 'Collegamenti per Pagina',
    'show_top10' => 'Mostrare la "Top 10" dei Collegamenti?',
    'notification' => 'Notifiche via Email?',
    'delete_links' => 'Eliminare Collegamenti con il Proprietario?',
    'aftersave' => 'Dopo Aver Salvato il Collegamento',
    'show_category_descriptions' => 'Mostrare la Descrizoine della Categoria?',
    'new_window' => 'Aprire Collegamenti in una Nuova Finestra?',
    'root' => 'ID della Categoria Principale',
    'default_permissions' => 'Permessi Predefiniti per i Collegamenti',
    'category_permissions' => 'Permessi Predefiniti per le Categorie',
    'autotag_permissions_link' => '[link: ] Permissions'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'Impostazioni Principali'
);

$LANG_tab['links'] = array(
    'tab_public' => 'Public Links List Settings',
    'tab_admin' => 'Links Admin Settings',
    'tab_permissions' => 'Link Permissions',
    'tab_cpermissions' => 'Category Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['links'] = array(
    'fs_public' => 'Impostazioni per la Lista dei Collegamenti Pubblici',
    'fs_admin' => 'Impostazioni Amministrative',
    'fs_permissions' => 'Impostazioni dei Permessi',
    'fs_cpermissions' => 'Impostazioni delle Categorie',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('Vero' => 1, 'Falso' => 0),
    1 => array('Vero' => true, 'Falso' => false),
    9 => array('Mostra Pagina' => 'item', 'Mostra Lista' => 'list', 'Mostra Home' => 'home', 'Mostra Ammin' => 'admin'),
    12 => array('Nessun Accesso' => 0, 'Solo Lettura' => 2, 'Lettura e Scrittura' => 3),
    13 => array('Nessun Accesso' => 0, 'Utilizzo' => 2)
);

?>
