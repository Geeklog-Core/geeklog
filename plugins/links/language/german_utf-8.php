<?php

###############################################################################
# german_utf-8.php
#
# This is the German language file for the Geeklog Links Plugin
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
# $Id: german_utf-8.php,v 1.3 2007/08/28 07:33:30 ospiess Exp $

###############################################################################
# Array Format:
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
###############################################################################


$LANG_LINKS= array(
    10 => 'Beiträge',
    14 => 'Links',
    84 => 'LINKS',
    88 => 'Es gibt keine Links anzuzeigen.',
    114 => 'Links',
    116 => 'Link hinzufügen'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Anzahl Links (Klicks)',
    'stats_headline' => 'Top Ten der Links',
    'stats_page_title' => 'Links',
    'stats_hits' => 'Angeklickt',
    'stats_no_hits' => 'Es gibt keine Links oder sie wurden von niemandem angeklickt.'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
 'results' => 'Ergebnisse: Links',
 'title' => 'Titel',
 'date' => 'Hinzugefügt',
 'author' => 'Eingereicht von',
 'hits' => 'Angeklickt'
);

###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'Einen Link einreichen',
    2 => 'Link',
    3 => 'Kategorie',
    4 => 'Andere',
    5 => 'oder neue Kategorie',
    6 => 'Fehler: Kategorie fehlt',
    7 => 'Wenn Du "Andere" auswählst, gib bitte auch eine neue Kategorie ein',
    8 => 'Titel',
    9 => 'URL',
    10 => 'Kategorie',
    11 => 'Beiträge: Links'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Danke für Deinen Beitrag zu {$_CONF['site_name']}. Dein Link wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald unter den <a href=\"{$_CONF['site_url']}/links/index.php\">Links</a> aufgelistet werden.";
$PLG_links_MESSAGE2 = 'Dein Link wurde gespeichert.';
$PLG_links_MESSAGE3 = 'Der Link wurde gelöscht.';
$PLG_links_MESSAGE4 = "Danke für Deinen Link. Du findest ihn nun unter den <a href=\"{$_CONF['site_url']}/links/index.php\">Links</a>.";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php

$LANG_LINKS_ADMIN = array(
    1 => 'Link-Editor',
    2 => 'Link-ID',
    3 => 'Titel',
    4 => 'URL',
    5 => 'Kategorie',
    6 => '(mit http://)',
    7 => 'Andere',
    8 => 'Angeklickt',
    9 => 'Beschreibung',
    10 => 'Du musst einen Titel, eine URL und eine Beschreibung für den Link eben.',
    11 => 'Link-Manager',
    12 => 'Auf das Ändern-Icon klicken, um einen Link zu ändern oder zu löschen.  
Mit Neu anlegen (s.o.) kann ein neuer Link angelegt werden.',
    13 => 'Titel',
    14 => 'Kategorie',
    15 => 'URL',
    16 => 'Zugriff verweigert',
    17 => "Du hast keine Zugriffsrechte für diesen Link. Dieser Zugriffsversuch  wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">Zurück zum  Administrator-Menü</a>.",
    20 => 'Andere bitte eingeben',
    21 => 'Speichern',
    22 => 'Abbruch',
    23 => 'Löschen'
);

?>
