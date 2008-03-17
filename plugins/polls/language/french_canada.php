<?php

###############################################################################
# french_canada.php
#
# This is the Canadian French language file for the Geeklog Polls plugin
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
    'polls'             => 'sondages',
    'results'           => 'R�sultats',
    'pollresults'       => 'R�sultat des sondages',
    'votes'             => 'votes',
    'vote'              => 'Vote',
    'pastpolls'         => 'Sondages anciens',
    'savedvotetitle'    => 'Vote sauvegard�',
    'savedvotemsg'      => 'Votre vote � �t� enregistr�',
    'pollstitle'        => 'Sondages dans le syst�me',
    'pollquestions'     => 'Voyez les autres questions sond�es',
    'stats_top10'       => 'Top-10 des sondages',
    'stats_questions'   => 'Questions des sondages',
    'stats_votes'       => 'Votes',
    'stats_none'        => 'Il appert qu\'il n\'y a aucun sondage actif en ce moment, ou que personne n\'ait vot� � ce jour.',
    'stats_summary'     => 'Sondages (r�ponses) dans le syst�me',
    'open_poll'         => 'Ouvert au vote'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Mode',
    2 => 'Merci d\'inscrire une question et au moins une r�ponse.',
    3 => 'Sondage cr��',
    4 => "%s sondage(s) sauvegard�(s)",
    5 => '�ditez le sondage',
    6 => 'Num�ro de sondage',
    7 => '(n\'utilisez pas d\'espacements)',
    8 => 'Appara�t sur la page d\'accueil',
    9 => 'Question',
    10 => 'R�ponses / Votes',
    11 => "Erreur : nous n\'avons pu r�cup�rer les r�ponses du sondage %s",
    12 => "Erreur : nous n\'avons pu r�cup�rer les questions du sondage %s",
    13 => 'Cr�ez un sondage',
    14 => 'sauvegardez',
    15 => 'annulez',
    16 => 'effacez',
    17 => 'Inscrivez un num�ro de sondage',
    18 => 'Liste des sondages',
    19 => 'Cliquez sur l\'ic�ne pour modifier un sondage.  Cliquez sur "Cr�er" pour un nouveau sondage.',
    20 => 'Voteurs',
    21 => 'Acc�s refus�',
    22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/poll.php\">go back to the poll administration screen</a>.",
    23 => 'Nouveau sondage',
    24 => 'Admin Home',
    25 => 'Oui',
    26 => 'Non',
    27 => '�diter',
    28 => 'Soumettre',
    29 => 'Rechercher',
    30 => 'Limite des r�sultats',
);

$PLG_polls_MESSAGE19 = 'Vos sondages ont �t� sauvegard�s avec succ�s.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
