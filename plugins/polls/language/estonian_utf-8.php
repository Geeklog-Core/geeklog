<?php

###############################################################################
# estonian_utf-8.php
# This is the estonian language page for the Geeklog Polls Plug-in
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
#
# Estonian translation by Artur Räpp <rtr AT planet DOT ee>
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
    'polls'             => 'Küsitlused',
    'results'           => 'Tulemused',
    'pollresults'       => 'Hääletuste tulemused',
    'votes'             => 'Hääletust',
    'vote'              => 'Hääleta',
    'pastpolls'         => 'Viimased küsitlused',
    'savedvotetitle'    => 'Hääl salvestatud',
    'savedvotemsg'      => 'Sinu hääl on salvestatud. Hääletasid küsitluses:',
    'pollstitle'        => 'Olemas olevad küsitlused',
    'pollquestions'     => 'Vaata teisi küsitlusi',
    'stats_top10'       => 'Top 10 küsitlust',
    'stats_questions'   => 'Küsitluse küsimus',
    'stats_votes'       => 'hääli',
    'stats_none'        => 'Näib et sellel lehel pole ühtegi küsitlust või mitte keegi ei ole veel hääletanud.',
    'stats_summary'     => 'Küsitlusi (vastuseid)',
    'open_poll'         => 'Avatud hääletamiseks'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Laad',
    2 => 'Palun sisesta küsimus ja vähemalt üks vastus.',
    3 => 'Küsitlus on loodud',
    4 => "Küsitlus %s on salvestatud",
    5 => 'Toimeta küsitlust',
    6 => 'Küsitluse ID',
    7 => '(ära kasuta tühikuid)',
    8 => 'Nähtav avalehel',
    9 => 'Küsimus',
    10 => 'vastused/hääletused',
    11 => "Tekkis viga küsitluse %s vastusteandmete laadimisel",
    12 => "Tekkis viga küsitluse %s küsimuste laadimisel",
    13 => 'Loo küsitlus',
    14 => 'salvesta',
    15 => 'tühista',
    16 => 'kustuta',
    17 => 'Sisesta küsitluse ID',
    18 => 'Küsitluste nimekiri',
    19 => 'Küsitluse toimetamiseks või kustutamiseks klõpsa küsitluse toimetamisikoonil. Uue küsitluse loomiseks klõpsa "Tee uus" ülal.',
    20 => 'Hääletajad',
    21 => 'Ligipääs tõkestatud',
    22 => "Sa proovisid ligi pääseda küsitlusele, milleks polnud sul õigust. See katse on logitud. 
Palun <a href=\"{$_CONF['site_admin_url']}/poll.php\"> mine tagasi küsitluste administreerimislehele.</a>",
    23 => 'Uus küsitlus',
    24 => 'Admin avaleht',
    25 => 'Ja',
    26 => 'Ei',
    27 => 'Toimeta',
    28 => 'Sisesta',
    29 => 'Otsi',
    30 => 'Piira tulemused',
);

 $PLG_polls_MESSAGE19 = 'Sinu küsitlus on edukalt salvestatud.';
$PLG_polls_MESSAGE20 = 'Sinu küsitlus on edukalt kustutatud.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
