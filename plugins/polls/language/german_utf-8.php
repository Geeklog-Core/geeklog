<?php

###############################################################################
# german_utf-8.php
#
# This is the German language file for the Geeklog Polls Plugin
#
# Copyright (C) 2005 Dirk Haun
# dirk AT haun-online DOT de
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
# $Id: german_utf-8.php,v 1.6 2008/03/17 21:12:54 dhaun Exp $

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

$LANG_POLLS = array(
    'polls'             => 'Umfragen',
    'results'           => 'Ergebnisse',
    'pollresults'       => 'Umfrage-Ergebnisse',
    'votes'             => 'Stimmen',
    'vote'              => 'Abstimmen',
    'pastpolls'         => 'Ältere Umfragen',
    'savedvotetitle'    => 'Stimme gespeichert',
    'savedvotemsg'      => 'Deine Stimme wurde für die Umfrage gespeichert: ',
    'pollstitle'        => 'Umfragen im System',
    'pollquestions'     => 'Ältere Umfragen ansehen',
    'stats_top10'       => 'Top Ten der Umfragen',
    'stats_questions'   => 'Thema der Umfrage',
    'stats_votes'       => 'Stimmen',
    'stats_none'        => 'Es gibt keine Umfragen oder es wurden keine Stimmen abgegeben.',
    'stats_summary'     => 'Anzahl Umfragen (Stimmen)',
    'open_poll'         => 'Abstimmen möglich'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Modus',
    2 => 'Bitte eine Frage und mindestens eine Antwort eingeben.',
    3 => 'Gestartet',
    4 => 'Umfrage %s wurde gespeichert',
    5 => 'Umfrage editieren',
    6 => 'Umfrage-ID',
    7 => '(keine Leerzeichen!)',
    8 => 'Auf der Startseite',
    9 => 'Thema',
    10 => 'Antworten / Stimmen / Anmerkung',
    11 => 'Beim Abrufen der Stimmen von Umfrage %s trat ein Fehler auf.',
    12 => 'Beim Abrufen der Fragen von Umfrage %s trat ein Fehler auf.',
    13 => 'Umfrage anlegen',
    14 => 'Speichern',
    15 => 'Abbruch',
    16 => 'Löschen',
    17 => 'Bitte eine Umfrage-ID eingeben.',
    18 => 'Liste der Umfragen',
    19 => 'Um eine Umfrage zu ändern oder zu löschen, auf das Ändern-Icon klicken. Mit Neu anlegen (s.o.) wird eine neue Umfrage angelegt.',
    20 => 'Stimmen',
    21 => 'Zugriff verweigert',
    22 => "Du hast keine Zugriffsrechte für diese Umfrage. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/plugins/polls/index.php\">Zurück zum Administrator-Menü</a>.",
    23 => 'Neue Umfrage',
    24 => 'Admin Home',
    25 => 'Ja',
    26 => 'Nein',
    27 => 'Ändern',
    28 => 'Abschicken',
    29 => 'Suchen',
    30 => 'Anzahl Ergebnisse'
);

$PLG_polls_MESSAGE19 = 'Deine Umfrage wurde gespeichert.';
$PLG_polls_MESSAGE20 = 'Deine Umfrage wurde gelöscht.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
