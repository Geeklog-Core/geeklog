<?php

###############################################################################
# italian.php
#
# This is the Italian language file for the Geeklog Polls Plugin
#
# Copyright (C) 2011 Rouslan Placella rouslan {at} placella {dot} com
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

$LANG_POLLS = array(
    'polls' => 'Sondaggi',
    'poll' => 'Poll',
    'results' => 'Risultati',
    'pollresults' => 'Risultati dei Sondaggi',
    'votes' => 'voti',
    'voters' => 'voters',
    'vote' => 'Vota',
    'pastpolls' => 'Vecchi Sondaggi',
    'savedvotetitle' => 'Voto Salvato',
    'savedvotemsg' => 'Il tuo voto é stato salvato per il sondaggio',
    'pollstitle' => 'Sondaggi nel Sistema',
    'polltopics' => 'Altri sondaggi',
    'stats_top10' => 'Top 10 Sondaggi',
    'stats_topics' => 'Tema',
    'stats_votes' => 'Voti',
    'stats_none' => 'Sembra non ci siano sondaggi o nessuno ha votato.',
    'stats_summary' => 'Sondaggi (Voti) nel sistema',
    'open_poll' => 'Aperto',
    'answer_all' => 'Rispondi alle domande rimanenti',
    'not_saved' => 'Risultato non salvato',
    'upgrade1' => 'Hai installato una nuova version dell\'estenzione Sondaggi. Prego',
    'upgrade2' => 'aggiorna',
    'editinstructions' => 'Devi includere un ID, almeno una domanda ed almeno due risposte per domanda.',
    'pollclosed' => 'Questo condaggio é chiuso.',
    'pollhidden' => 'Hai gia votato. I risultati di questo sondaggio verranno solo mostrati quando il sondaggio sará chiuso.',
    'start_poll' => 'Comincia Sondaggio',
    'no_new_polls' => 'Nessun nuovo sondaggio',
    'autotag_desc_poll' => '[poll: id alternate title] - Displays a link to a poll using the Poll Topic as the title. An alternate title may be specified but is not required.',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] - Displays a poll for voting. Class and showall not required. Class specifies the css class and Showall if set to 1, shows all questions',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] - Displays the poll results. Class not required. Class specifies the css class.',
    'deny_msg' => 'Accesso al sondaggio negato.  É possibile che il sondaggio é stato spostato/rimosso o che non hai i permessi necessari.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Modo',
    2 => 'Devi includere un Tema, almeno una domanda ed almeno due risposte per domanda.',
    3 => 'Sondaggio Creato',
    4 => 'Sondaggio %s salvato',
    5 => 'Modifica Sondaggio',
    6 => 'ID del Sondaggio',
    7 => '(niente spazi)',
    8 => 'Mostra sul Blocco dei Sondaggi',
    9 => 'Tema',
    10 => 'Risposte / Voti / Note',
    11 => 'Si é verificato un errore durente la richiesta dei dati di risposte al riguardo del sondaggio %s',
    12 => 'Si é verificato un errore durente la richiesta dei dati delle domande al riguardo del sondaggio %s',
    13 => 'Crea Sondaggio',
    14 => 'salva',
    15 => 'cancella',
    16 => 'rimuovi',
    17 => 'Inserisci l\'ID di un sondaggio',
    18 => 'Lista dei Sondaggio',
    19 => 'To modify or delete a poll, click on the edit icon of the poll.  To create a new poll, click on "Create New" above.',
    20 => 'Utenti che hanno votato',
    21 => 'Accesso Negato',
    22 => "Stai cercando di accedere ad un sondaggio per il quale non hai permesso.  Questo tentativo é stato registrato. <a href=\"{$_CONF['site_admin_url']}/poll.php\">Ritorna all'area amministrativa dei sondaggi.</a>",
    23 => 'Nuovo Sondaggio',
    24 => 'Ammin Home',
    25 => 'Si',
    26 => 'No',
    27 => 'Modifica',
    28 => 'Invia',
    29 => 'Ricerca',
    30 => 'Limita Risultati',
    31 => 'Domanda',
    32 => 'Per rimuovere questa domanda dal sondaggio, rimuovi il suo testo',
    33 => 'Aperto',
    34 => 'Tema del Sondaggio:',
    35 => 'Questo Sondaggio ha',
    36 => 'altre domande.',
    37 => 'Nascondi risultati mentre il sondaggio é aperto',
    38 => 'Mentre il sondaggio é aperto solo il proprietario e l\'utente root possono vedere i risultati',
    39 => 'Il tema verrá visualizzato se ci sará piú di una domanda.',
    40 => 'Visualizza tutte le risposte a questo sondaggio'
);

$PLG_polls_MESSAGE15 = 'Il tuo commento é stato salvato e verrá pubblicato appena approvato da un moderatore.';
$PLG_polls_MESSAGE19 = 'Il tuo sondaggio é stato salvato con successo.';
$PLG_polls_MESSAGE20 = 'Il tuo sondaggio é stato rimosso con successo.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'L\'aggiornamento di Estensioni non é supportato.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'Sondaggi',
    'title' => 'Configurazione degli Sondaggi'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'Login Necessario per Sondaggi?',
    'hidepollsmenu' => 'Nascondi Sondaggi dal Menu?',
    'maxquestions' => 'Max. Domande per Sondaggio',
    'maxanswers' => 'Max. Opzioni per Domanda',
    'answerorder' => 'Ordina Resultati ...',
    'pollcookietime' => 'Cookie dell\'utente valido per',
    'polladdresstime' => 'Indirizzo IP dell\'utente valido per',
    'delete_polls' => 'Rimuovere i Sondaggi se l\'Utente che li ha creato é rimosso?',
    'aftersave' => 'Dopo aver Salvato il Sondaggio',
    'default_permissions' => 'Permessi Predefiniti per Sondaggi',
    'autotag_permissions_poll' => '[poll: ] Permissions',
    'autotag_permissions_poll_vote' => '[poll_vote: ] Permissions',
    'autotag_permissions_poll_result' => '[poll_result: ] Permissions',
    'newpollsinterval' => 'Intervallo per Nuovi Sondaggi',
    'hidenewpolls' => 'Nuovi Sondaggi',
    'title_trim_length' => 'Limita Lunghezza del Titolo',
    'meta_tags' => 'Abilita Meta Tags',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Impostazioni Principali'
);

$LANG_tab['polls'] = array(
    'tab_main' => 'General Polls Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_poll_block' => 'Poll Block'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'Impostazioni Generali per Sondaggi',
    'fs_whatsnew' => 'Blocco What\'s New',
    'fs_permissions' => 'Permessi Predefiniti',
    'fs_autotag_permissions' => 'Permessi Predefiniti per Autotag',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('Vero' => 1, 'Falso' => 0),
    1 => array('Vero' => true, 'Falso' => false),
    2 => array('Come salvati' => 'submitorder', 'In Base ai Voti' => 'voteorder'),
    5 => array('Nascondi' => 'hide', 'Mostra - Usa la data di ultima modifica' => 'modified', 'Mostra - Usa la data di creazione' => 'created'),
    9 => array('Vai al Sondaggio' => 'item', 'Mostra Lista Ammin' => 'list', 'Mostra Lista Pubblica' => 'plugin', 'Mostra Home' => 'home', 'Mostra Ammin' => 'admin'),
    12 => array('Nessun Accesso' => 0, 'Sola Lettura' => 2, 'Lettura e Scrittura' => 3),
    13 => array('Nessun Accesso' => 0, 'Utilizzo' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
