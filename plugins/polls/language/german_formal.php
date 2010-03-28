<?php

###############################################################################
# german_formal.php
#
# This is the German language file for the Geeklog Polls Plugin,
# addressing the user as "Sie" (formal German).
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
    'results' => 'Ergebnisse',
    'pollresults' => 'Umfrage-Ergebnisse',
    'votes' => 'Stimmen',
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
    'pollhidden' => 'Sie haben schon abgestimmt. Die Ergebnisse dieser Umfrage werden veröffentlicht, sobald sie abgeschlossen ist.',
    'start_poll' => 'Zur Umfrage',
    'no_new_polls' => 'No new polls',
    'deny_msg' => 'Access to this poll is denied.  Either the poll has been moved/removed or you do not have sufficient permissions.'
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
    40 => 'Alle Antworten zu dieser Umfrage ansehen'
);

$PLG_polls_MESSAGE15 = 'Ihr Kommentar wurde gespeichert, muss aber noch von einem Moderator freigegeben werden.';
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
    'pollsloginrequired' => 'Zur Einsicht einloggen nötig?',
    'hidepollsmenu' => 'Menüeintrag ausblenden?',
    'maxquestions' => 'Max. Fragen pro Umfrage',
    'maxanswers' => 'Max. Möglichkeiten pro Frage',
    'answerorder' => 'Ergebnisse sortieren ...',
    'pollcookietime' => 'Voter Cookie gültig für',
    'polladdresstime' => 'Voter IP-Adresse gültig für',
    'delete_polls' => 'Umfragen mit User löschen?',
    'aftersave' => 'Nach speichern der Umfrage',
    'default_permissions' => 'Grundeinstellungen Umfragen',
    'newpollsinterval' => 'New Polls Interval',
    'hidenewpolls' => 'New Polls',
    'title_trim_length' => 'Title Trim Length',
    'meta_tags' => 'Meta-Tags verwenden'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Hauptbereich'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'Allgemeine Umfrageeinstellungen',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_permissions' => 'Grundeinstellungen Rechte'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('Ja' => 1, 'Nein' => 0),
    1 => array('Ja' => true, 'Nein' => false),
    2 => array('Wie eingereicht' => 'submitorder', 'Nach Abstimmung' => 'voteorder'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Zur Umfrage weiterleiten' => 'item', 'Admin Liste anzeigen' => 'list', 'Öffentliche Liste anzeigen' => 'plugin', 'Startseite anzeigen' => 'home', 'Schaltzentrale' => 'admin'),
    12 => array('Kein Zugang' => 0, 'Nur lesen' => 2, 'Lesen-Schreiben' => 3)
);

?>
