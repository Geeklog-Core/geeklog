<?php

###############################################################################
# italian.php
#
# This is the Italian language file for the Geeklog Calendar Plugin
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

# index.php
$LANG_CAL_1 = array(
    1 => 'Calendario di Eventi',
    2 => 'Nessun evento da mostrare.',
    3 => 'Quando',
    4 => 'Dove',
    5 => 'Descrizione',
    6 => 'Aggiungi un Evento',
    7 => 'Eventi Futuri',
    8 => 'Dopo aver aggiunto questo evento al tuo calendario, potrai visualizzare gli eventi nei quali sei interessato cliccando su "Calendario Personale" nell\'area User Functions.',
    9 => 'Aggiungi al Mio Calendario',
    10 => 'Rimuovi dal Mio Calendario',
    11 => 'L\'Evento é stato Aggiunto al Calendario di %s',
    12 => 'Evento',
    13 => 'Inizio',
    14 => 'Fine',
    15 => 'Vai al Calendario',
    16 => 'Calendario',
    17 => 'Data dell\'inizio',
    18 => 'Data della fine',
    19 => 'Inserimenti nel Calendario',
    20 => 'Titolo',
    21 => 'Data dell\'inizio',
    22 => 'Indirizzo',
    23 => 'I Tuoi Eventi',
    24 => 'Gli Eventi del Sito',
    25 => 'Nessun Evento nel Futuro',
    26 => 'Aggiungi un Evento',
    27 => "Un evento aggiunto a {$_CONF['site_name']} verrá salvato sul calendario principale, dove gli altri utenti potranno aggiungerlo al loro calendario personale. Questa funzione <b>NON</a> é adatta per salvare eventi personali come anniversari o compleanni.<br" . XHTML . "><br" . XHTML . ">Dopo l'inserimento, il tuo evento verrá inviato agli amministratori del sito, e se ritenuto valido, sará pubblicato sul calendario principale.",
    28 => 'Titolo',
    29 => 'Ora della fine',
    30 => 'Ora dell\'inizio',
    31 => 'Tutto il giorno',
    32 => 'Indirizzo',
    33 => 'Indirizzo',
    34 => 'Cittá/Paese',
    35 => 'Provincia',
    36 => 'C.A.P.',
    37 => 'Tipo di Evento',
    38 => 'Modifica Tipi di Eventi',
    39 => 'Localitá',
    40 => 'Aggiungi evento a',
    41 => 'Calendario Principale',
    42 => 'Calendario Personale',
    43 => 'Collegamento',
    44 => 'l\'uso dei tag HTML non é consentito',
    45 => 'Salva',
    46 => 'Eventi nel sistema',
    47 => 'Top 10 Eventi',
    48 => 'Visite',
    49 => 'Sembra che non ci siano eventi su questo sito o nessuno ne ha mai visitato uno.',
    50 => 'Eventi',
    51 => 'Rimuovi',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Risultati dal Calendario',
    'title' => 'Titolo',
    'date_time' => 'Data e Ora',
    'location' => 'Localitá',
    'description' => 'Descrizione'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Aggiungi Evento Personale',
    9 => '%s Evento',
    10 => 'Eventi per',
    11 => 'Calendario Principale',
    12 => 'Calendario Personale',
    25 => 'Vai a ',
    26 => 'Tutto il giorno',
    27 => 'Settimana',
    28 => 'Calendario Personale per',
    29 => 'Calendario Pubblico',
    30 => 'rimuovi evento',
    31 => 'Aggiungi',
    32 => 'Evento',
    33 => 'Data',
    34 => 'Ora',
    35 => 'Quick Add',
    36 => 'Salva',
    37 => 'Il suo calendario personale non é abilitato su questo sito',
    38 => 'Editor di Eventi Personali',
    39 => 'Giorno',
    40 => 'Settimana',
    41 => 'Mese',
    42 => 'Aggiungi Evento al Calendario Principale',
    43 => 'Inserimenti degli Eventi'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Editor di Eventi',
    2 => 'Errore',
    3 => 'Modalitá di inserimento',
    4 => 'URL dell\'evento',
    5 => 'Data dell\'inizio dell\'evento',
    6 => 'Data della fine dell\'evento',
    7 => 'Localitá dell\'evento',
    8 => 'Descrizione dell\'evento',
    9 => '(includi http://)',
    10 => 'Sono necessari le data/ore, titolo ed una descrizione',
    11 => 'Calendar Manager',
    12 => 'Per modificare or rimuove un evento, clicca sulla corrispondente icona nella lista in basso. Per creare un nuovo evento clicca su "Nuovo". Clicca sulla icona di copia per duplicare un evento.',
    13 => 'Autore',
    14 => 'Data dell\'inizio',
    15 => 'Data della Fine',
    16 => '',
    17 => "Stai cercando di accedere ad un evento per il quale non hai permesso.  Questo tentativo é stato registrato. <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">Ritorna all'area amministrativa degli eventi.</a>",
    18 => '',
    19 => '',
    20 => 'salva',
    21 => 'cancella',
    22 => 'rimuovi',
    23 => 'Data dell\'inizio invalida.',
    24 => 'Data della fine invalida.',
    25 => 'Data della fine prima della data dell\'inizio.',
    26 => 'Rimuovi Eventi Vecchi',
    27 => 'Questi eventi sono pi vecchi di ',
    28 => ' mesi. Clicca sull\'icona del cestino in basso per rimuoverli o seleziona un altro periodo:<br' . XHTML . '>Trova tutti gli eventi piú vecchi di ',
    29 => ' mesi.',
    30 => 'Aggiorna la lista',
    31 => 'Sei sicuro di voler rimuovere TUTTI gli utenti selezionati permanentemente?',
    32 => 'Mostra tutti',
    33 => 'Nessun evento selezionato per la rimozione',
    34 => 'ID dell\'Evento',
    35 => 'non rimosso',
    36 => 'Rimosso con successo'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'Il tuo evento é stato salvato con successo.',
    'delete' => 'Il tuo evento é stato rimosso con successo.',
    'private' => 'L\'evento é stato salvate nel tuo calendario',
    'login' => 'Non é possibile accedere al suo calendario personale prima che hai effettuato il login',
    'removed' => 'Il tuo evento é stato rimosso con successo dal tuo calendario personale.',
    'noprivate' => 'I calendari personale non sono abilitati su questo sito',
    'unauth' => 'Non hai accesso alla pagina di amministrazione degli eventi. Note che tutti i tentativi di accesso non autorizzati sono salvati'
);

$PLG_calendar_MESSAGE4 = "Grazie per aver inviato un evento a {$_CONF['site_name']}. L'evento é stato inviato al nostro staff per l'approvazione. Se approvato, il tuo evento sará disponibile per la visualizzazione nel nostro <a href=\"{$_CONF['site_url']}/calendar/index.php\">calendario</a>.";
$PLG_calendar_MESSAGE17 = 'Il tuo evento é stato salvato con successo.';
$PLG_calendar_MESSAGE18 = 'L\'evento é stato rimosso con successo.';
$PLG_calendar_MESSAGE24 = 'L\'evento é stato salvate nel tuo calendario.';
$PLG_calendar_MESSAGE26 = 'L\'evento é stato rimosso con successo.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'L\'Aggiornamento delle estensioni non é supportato.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendario',
    'title' => 'Impostazioni del Calendario'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Login Necessario per il Calendar?',
    'hidecalendarmenu' => 'Nascondere Calendario dal Menu?',
    'personalcalendars' => 'Abilitare Calendari Personali?',
    'eventsubmission' => 'Abilitare la Coda per Inserimenti?',
    'showupcomingevents' => 'Mostare Eventi Futuri?',
    'upcomingeventsrange' => 'Intervallo per eventi futuri',
    'event_types' => 'Tipi di Eventi',
    'hour_mode' => 'Tipo di Orario',
    'notification' => 'Notifica via Email?',
    'delete_event' => 'Rimuovere gli Eventi se l\'Utente che li ha create é rimosso?',
    'aftersave' => 'Dopo aver Salvato l\'Evento',
    'default_permissions' => 'Permessi Predefiniti per Eventi',
    'autotag_permissions_event' => '[event: ] Permessi',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Impostazioni Principali'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'General Calendar Settings',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_events_block' => 'Events Block'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'Impostazioni Predefinite per il Calendario',
    'fs_permissions' => 'Permessi Predefiniti',
    'fs_autotag_permissions' => 'Permessi Predefiniti per Autotag',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('Vero' => 1, 'Falso' => 0),
    1 => array('Vero' => true, 'Falso' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Vai a pagina' => 'item', 'Mostra Lista' => 'list', 'Mostra Home' => 'home', 'Mostra Admin' => 'admin'),
    12 => array('Nessun Accesso' => 0, 'Sola lettura' => 2, 'Lettura e Scrittura' => 3),
    13 => array('Nessun Accesso' => 0, 'Utilizzo' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
