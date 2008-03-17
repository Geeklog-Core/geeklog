<?php

###############################################################################
# estonian.php
# This is the estonian language page for the Geeklog Polls Plug-in
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2005 Trinity Bays
# trinity93@gmail.com
#
# Estonian translation by Artur R�pp <rtr AT planet DOT ee>
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
    'polls'             => 'K�sitlused',
    'results'           => 'Tulemused',
    'pollresults'       => 'H��letuste tulemused',
    'votes'             => 'H��letust',
    'vote'              => 'H��leta',
    'pastpolls'         => 'Viimased k�sitlused',
    'savedvotetitle'    => 'H��l salvestatud',
    'savedvotemsg'      => 'Sinu h��l on salvestatud. H��letasid k�sitluses:',
    'pollstitle'        => 'Olemas olevad k�sitlused',
    'pollquestions'     => 'Vaata teisi k�sitlusi',
    'stats_top10'       => 'Top 10 k�sitlust',
    'stats_questions'   => 'K�sitluse k�simus',
    'stats_votes'       => 'h��li',
    'stats_none'        => 'N�ib et sellel lehel pole �htegi k�sitlust v�i mitte keegi ei ole veel h��letanud.',
    'stats_summary'     => 'K�sitlusi (vastuseid)',
    'open_poll'         => 'Avatud h��letamiseks'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Laad',
    2 => 'Palun sisesta k�simus ja v�hemalt �ks vastus.',
    3 => 'K�sitlus on loodud',
    4 => "K�sitlus %s on salvestatud",
    5 => 'Toimeta k�sitlust',
    6 => 'K�sitluse ID',
    7 => '(�ra kasuta t�hikuid)',
    8 => 'N�htav avalehel',
    9 => 'K�simus',
    10 => 'vastused/h��letused',
    11 => "Tekkis viga k�sitluse %s vastusteandmete laadimisel",
    12 => "Tekkis viga k�sitluse %s k�simuste laadimisel",
    13 => 'Loo k�sitlus',
    14 => 'salvesta',
    15 => 't�hista',
    16 => 'kustuta',
    17 => 'Sisesta k�sitluse ID',
    18 => 'K�sitluste nimekiri',
    19 => 'K�sitluse toimetamiseks v�i kustutamiseks kl�psa k�sitluse toimetamisikoonil. Uue k�sitluse loomiseks kl�psa "Tee uus" �lal.',
    20 => 'H��letajad',
    21 => 'Ligip��s t�kestatud',
    22 => "Sa proovisid ligi p��seda k�sitlusele, milleks polnud sul �igust. See katse on logitud. 
Palun <a href=\"{$_CONF['site_admin_url']}/poll.php\"> mine tagasi k�sitluste administreerimislehele.</a>",
    23 => 'Uus k�sitlus',
    24 => 'Admin avaleht',
    25 => 'Ja',
    26 => 'Ei',
    27 => 'Toimeta',
    28 => 'Sisesta',
    29 => 'Otsi',
    30 => 'Piira tulemused',
);

 $PLG_polls_MESSAGE19 = 'Sinu k�sitlus on edukalt salvestatud.';
$PLG_polls_MESSAGE20 = 'Sinu k�sitlus on edukalt kustutatud.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
