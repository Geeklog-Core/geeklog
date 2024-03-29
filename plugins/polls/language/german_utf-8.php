<?php

###############################################################################
# german_utf-8.php
#
# This is the German language file for the Geeklog Polls Plugin
# addressing the user as "Du" (informal German).
#
# Authors: Dirk Haun <dirk AT haun-online DOT de>
#          Markus Wollschläger
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
    'polls' => 'Umfragen',
    'poll' => 'Poll',
    'results' => 'Ergebnisse',
    'pollresults' => 'Umfrage-Ergebnisse',
    'votes' => 'Stimmen',
    'voters' => 'voters',
    'vote' => 'Abstimmen',
    'pastpolls' => 'Ältere Umfragen',
    'savedvotetitle' => 'Stimme gespeichert',
    'savedvotemsg' => 'Stimme wurde für die Umfrage gespeichert: ',
    'pollstitle' => 'Umfragen im System',
    'polltopics' => 'Andere Umfragen',
    'stats_top10' => 'Top Ten der Umfragen',
    'stats_topics' => 'Umfragekategorie',
    'stats_votes' => 'Stimmen',
    'stats_none' => 'Es gibt keine Umfragen oder es wurden keine Stimmen abgegeben.',
    'stats_summary' => 'Anzahl Umfragen (Stimmen)',
    'open_poll' => 'Abstimmen möglich',
    'answer_all' => 'Bitte alle übrigen Fragen beantworten',
    'not_saved' => 'Ergebnis nicht gespeichert',
    'upgrade1' => 'Neue Version des Umfrage-Plugins installiert. Bitte',
    'upgrade2' => 'upgraden',
    'editinstructions' => 'Bitte für die Umfrage-ID mindestens eine Frage und zwei Antworten eintragen.',
    'pollclosed' => 'Diese Umfrage ist abgeschlossen.',
    'pollhidden' => 'Du hast schon abgestimmt. Die Ergebnisse dieser Umfrage werden veröffentlicht, sobald sie abgeschlossen ist.',
    'start_poll' => 'Zur Umfrage',
    'no_new_polls' => 'Keine neuen Umfragen',
    'autotag_desc_poll' => '[poll: id alternate title] - Displays a link to a poll using the Poll Topic as the title. An alternate title may be specified but is not required.',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] - Displays a poll for voting. Class and showall not required. Class specifies the css class and Showall if set to 1, shows all questions',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] - Displays the poll results. Class not required. Class specifies the css class.',
    'deny_msg' => 'Zugang zu dieser Umfrage nicht gestattet.  Entweder wurde diese Umfrage entfernt oder es fehlen die nötigen Zugriffsrechte.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Kommentaranzeige',
    2 => 'Bitte eine Kategorie, mindestens eine Frage und eine Antwort für die Frage eintragen.',
    3 => 'Umfrage erstellt',
    4 => 'Umfrage %s gespeichert',
    5 => 'Umfrage editieren',
    6 => 'Umfrage-ID',
    7 => '(keine Leerzeichen benutzen)',
    8 => 'Erscheint im Umfrageblock',
    9 => 'Kategorie',
    10 => 'Antworten / Abstimmungen / Bemerkungen',
    11 => 'There was an error getting Umfrage answer data about the poll %s',
    12 => 'There was an error getting Umfrage question data about the poll %s',
    13 => 'Umfrage erstellen',
    14 => 'speichern',
    15 => 'abbrechen',
    16 => 'löschen',
    17 => 'Bitte Umfrage-ID eingeben',
    18 => 'Liste der Umfragen',
    19 => 'Um eine Umfrage zu editieren oder zu löschen, auf das Edit-Icon klicken.  Um eine neue Umfrage zu eröffnen, bitte auf "Neu anlegen" oben klicken.',
    20 => 'Abstimmende',
    21 => 'Kein Zugang',
    22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/poll.php\">go back to the poll administration screen</a>.",
    23 => 'Neue Umfrage',
    24 => 'Schaltzentrale',
    25 => 'Ja',
    26 => 'Nein',
    27 => 'Editieren',
    28 => 'Senden',
    29 => 'Suchen',
    30 => 'Ergebnisse eingrenzen',
    31 => 'Frage',
    32 => 'Um diese Frage aus der Umfrage zu entfernen, den Fragetext löschen.',
    33 => 'Umfrage läuft',
    34 => 'Umfrage-Kategorie:',
    35 => 'Diese Umfrage hat noch ',
    36 => 'Fragen.',
    37 => 'Ergebnisse ausblenden wenn Umfrage läuft',
    38 => 'Während diese Umfrage läuft, können nur der Eigentümer &amp; Root die Ergebnisse sehen.',
    39 => 'Die Kategorie wird nur angezeigt, wenn sie mehr als eine Frage enthält.',
    40 => 'Alle Antworten zu dieser Umfrage ansehen',
    1001 => 'Allow multiple answers',
    1002 => 'Description',
    1003 => 'Description'
);

$PLG_polls_MESSAGE15 = 'Der Kommentar wurde gespeichert, muss aber noch von einem Moderator freigegeben werden.';
$PLG_polls_MESSAGE19 = 'Umfrage wurde gespeichert.';
$PLG_polls_MESSAGE20 = 'Umfrage wurde gelöscht.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'Umfragen',
    'title' => 'Umfragekonfiguration'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'Anmelden zur Einsicht nötig?',
    'hidepollsmenu' => 'Menüeintrag ausblenden?',
    'maxquestions' => 'Max. Fragen pro Umfrage',
    'maxanswers' => 'Max. Möglichkeiten pro Frage',
    'answerorder' => 'Ergebnisse sortieren ...',
    'pollcookietime' => 'Cookie des Abstimmenden gültig für',
    'polladdresstime' => 'IP-Adresse des Abstimmenden gültig für',
    'delete_polls' => 'Umfragen mit User löschen?',
    'aftersave' => 'Nach speichern der Umfrage',
    'default_permissions' => 'Grundeinstellungen Umfragen',
    'autotag_permissions_poll' => '[poll: ] Permissions',
    'autotag_permissions_poll_vote' => '[poll_vote: ] Permissions',
    'autotag_permissions_poll_result' => '[poll_result: ] Permissions',
    'newpollsinterval' => 'Zeitabstand neue Umfragen',
    'hidenewpolls' => 'Neue Umfragen',
    'title_trim_length' => 'Titel abschneiden nach',
    'meta_tags' => 'Meta-Tags verwenden',
    'likes_polls' => 'Poll Likes',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Hauptbereich'
);

$LANG_tab['polls'] = array(
    'tab_main' => 'General Polls Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_poll_block' => 'Poll Block'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'Allgemeine Umfrageeinstellungen',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_permissions' => 'Grundeinstellungen Rechte',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('Ja' => 1, 'Nein' => 0),
    1 => array('Ja' => true, 'Nein' => false),
    2 => array('Wie eingereicht' => 'submitorder', 'Nach Abstimmung' => 'voteorder'),
    5 => array('Verbergen' => 'hide', 'Anzeigen - Modifiziertes Datum benutzen' => 'modified', 'Anzeigen - Datum der Erstellung benutzen' => 'created'),
    9 => array('Zur Umfrage weiterleiten' => 'item', 'Admin Liste anzeigen' => 'list', 'Öffentliche Liste anzeigen' => 'plugin', 'Startseite' => 'home', 'Schaltzentrale' => 'admin'),
    12 => array('Kein Zugang' => 0, 'Nur lesen' => 2, 'Lesen-Schreiben' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'all', 'Homepage Only' => 'homeonly', 'Select Topics' => 'selectedtopics'),
    41 => array('False' => 0, 'Likes and Dislikes' => 1, 'Likes Only' => 2)
);
