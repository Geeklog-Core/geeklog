<?php

###############################################################################
# slovenian.php - version 1.4.1
# This is the slovenian language page for the Geeklog Polls Plug-in!
# language file for geeklog version 1.4.1 beta by mb
# gape@gape.org ; za pripombe, predloge ipd ... piši na email
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

global $LANG32;

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => 'Ankete',
    'results'           => 'Rezultati',
    'pollresults'       => 'Rezultati anket',
    'votes'             => 'glasov',
    'vote'              => 'Glasuj',
    'pastpolls'         => 'Pretekle ankete',
    'savedvotetitle'    => 'Glas shranjen',
    'savedvotemsg'      => 'Tvoj glas je shranjen za anketo.',
    'pollstitle'        => 'Ankete v sistemu',
    'pollquestions'     => 'Poglej druga anketna vprašanja.',
    'stats_top10'       => 'Najboljših 10 anket',
    'stats_questions'   => 'Vprašanje ankete',
    'stats_votes'       => 'Glasovi',
    'stats_none'        => 'Izgleda, da na tem mestu ni anket ali pa še nikoli ni nihèe glasoval.',
    'stats_summary'     => 'Ankete (odgovori) v sistemu',
    'open_poll'         => 'Odprto za glasovanje'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Naèin',
    2 => 'Vpišite vprašanje in vsaj en odgovor.',
    3 => 'Anketa ustvarjena',
    4 => "Anketa %s shranjena",
    5 => 'Uredi anketo',
    6 => 'ID ankete',
    7 => '(ne uporabljaj presledkov)',
    8 => 'Pojavi se na domaèi strani',
    9 => 'Vprašanje',
    10 => 'Odgovori / Glasovi / Pripombe',
    11 => "Med pridobivanjem podatkov o odgovoru pri anketi %s je prišlo do napake",
    12 => "Med pridobivanjem podatkov o vprašanju pri anketi %s je prišlo do napake",
    13 => 'Ustvari anketo',
    14 => 'shrani',
    15 => 'preklièi',
    16 => 'izbriši',
    17 => 'Vnesi prosim ID ankete',
    18 => 'Seznam anket',
    19 => 'Za spreminjanje ali izbris ankete klikni na njeno ikono za urejanje. Za ustvarjenje nove ankete klikni na "Ustvari novo" zgoraj.',
    20 => 'Glasovalci',
    21 => 'Dostop zavrnjen',
    22 => "Poskušaš dostopiti do ankete, za katero nimaš pravic. Ta poskus je bil zabeležen. Prosim <a href=\"{$_CONF['site_admin_url']}/poll.php\">pojdi nazaj na zaslon za upravljanje anket</a>.",
    23 => 'Nova anketa',
    24 => 'Upravnikova stran',
    25 => 'Da',
    26 => 'Ne',
    27 => 'Uredi',
    28 => 'Oddaj',
    29 => 'Išèi',
    30 => 'Omeji rezultate',
);

$PLG_polls_MESSAGE19 = 'Tvoja anketa je uspešno shranjena.';
$PLG_polls_MESSAGE20 = 'Tvoja anketa je uspešno izbrisana.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
