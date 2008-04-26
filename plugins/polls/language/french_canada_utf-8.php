<?php

###############################################################################
# french_canada_utf-8.php
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

global $LANG32;

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => 'sondages',
    'results'           => 'Résultats',
    'pollresults'       => 'Résultat des sondages',
    'votes'             => 'votes',
    'vote'              => 'Vote',
    'pastpolls'         => 'Sondages anciens',
    'savedvotetitle'    => 'Vote sauvegardé',
    'savedvotemsg'      => 'Votre vote à été enregistré',
    'pollstitle'        => 'Sondages dans le système',
    'pollquestions'     => 'Voyez les autres questions sondées',
    'stats_top10'       => 'Top-10 des sondages',
    'stats_questions'   => 'Questions des sondages',
    'stats_votes'       => 'Votes',
    'stats_none'        => 'Il appert qu\'il n\'y a aucun sondage actif en ce moment, ou que personne n\'ait voté à ce jour.',
    'stats_summary'     => 'Sondages (réponses) dans le système',
    'open_poll'         => 'Ouvert au vote'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Mode',
    2 => 'Merci d\'inscrire une question et au moins une réponse.',
    3 => 'Sondage créé',
    4 => "%s sondage(s) sauvegardé(s)",
    5 => 'Éditez le sondage',
    6 => 'Numéro de sondage',
    7 => '(n\'utilisez pas d\'espacements)',
    8 => 'Apparaît sur la page d\'accueil',
    9 => 'Question',
    10 => 'Réponses / Votes',
    11 => "Erreur : nous n\'avons pu récupérer les réponses du sondage %s",
    12 => "Erreur : nous n\'avons pu récupérer les questions du sondage %s",
    13 => 'Créez un sondage',
    14 => 'sauvegardez',
    15 => 'annulez',
    16 => 'effacez',
    17 => 'Inscrivez un numéro de sondage',
    18 => 'Liste des sondages',
    19 => 'Cliquez sur l\'icône pour modifier un sondage.  Cliquez sur "Créer" pour un nouveau sondage.',
    20 => 'Voteurs',
    21 => 'Accès refusé',
    22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/poll.php\">go back to the poll administration screen</a>.",
    23 => 'Nouveau sondage',
    24 => 'Admin Home',
    25 => 'Oui',
    26 => 'Non',
    27 => 'Éditer',
    28 => 'Soumettre',
    29 => 'Rechercher',
    30 => 'Limite des résultats',
);

$PLG_polls_MESSAGE19 = 'Vos sondages ont été sauvegardés avec succès.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
