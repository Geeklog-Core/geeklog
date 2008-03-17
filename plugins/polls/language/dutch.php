<?php

###############################################################################
# dutch.php
# This is the Dutch language file for the Geeklog Polls plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => 'Peilingen',
    'results'           => 'Resultaten',
    'pollresults'       => 'Peiling Resultaten',
    'votes'             => 'stemmen',
    'vote'              => 'Stem',
    'pastpolls'         => 'Oudere peilingen',
    'savedvotetitle'    => 'Stem opgeslagen',
    'savedvotemsg'      => 'Uw stem is in de peling opgenomen',
    'pollstitle'        => 'Peilingen in systeem',
    'pollquestions'     => 'Bekijke andere peilingen',
    'stats_top10'       => 'Top Tien Peilingen',
    'stats_questions'   => 'Peiling vraag',
    'stats_votes'       => 'Stemmen',
    'stats_none'        => 'Er zijn geen peilingen aanwezig of er is nog niet op gestemd.',
    'stats_summary'     => 'Peilingen (resultaten) in het systeem',
    'open_poll'         => 'Open voor stemmen'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Modus',
    2 => 'Geef een vraag en tenminsten 1 antwoord op.',
    3 => 'Peiling aangemaakt',
    4 => "Peiling %s bewaard",
    5 => 'Edit peiling',
    6 => 'Peiling ID',
    7 => '(zonder spaties)',
    8 => 'Verschijnt op Homepage',
    9 => 'Vraag',
    10 => 'Antwoorden / Stemmen',
    11 => "Er is een fout opgettreden tijdens het verkrijgen van de antwoorden van peiling %s",
    12 => "Er is een fout opgettreden tijdens het verkrijgen van de stemmen van peiling %s",
    13 => 'Maak peiling',
    14 => 'bewaar',
    15 => 'annuleer',
    16 => 'verwijder',
    17 => 'Geef AUB een peiling ID op',
    18 => 'Peiling lijst',
    19 => 'Om een peiling te veranderen of te verwijderen, klik op het Edit icoon naast de peiling. Om een nieuwe peiling te maken, klik op "Maak peiling" hierboven.',
    20 => 'Stemmers',
    21 => 'Toegang geweigerd',
    22 => "U probeert een peiling waar u geen toegang toe heeft te bewerken.  Deze poging is vastgelegd. Ga AUB terug naar de <a href=\"{$_CONF['site_admin_url']}/poll.php\">peiling editor</a>.",
    23 => 'Nieuwe Peiling',
    24 => 'Admin Home',
    25 => 'Ja',
    26 => 'Nee',
    27 => 'Wijzig',
    28 => 'Verzend',
    29 => 'Zoek',
    30 => 'Limiteer resultaten',
);

$PLG_polls_MESSAGE19 = 'Your poll has been successfully saved.';
$PLG_polls_MESSAGE20 = 'Your poll has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
