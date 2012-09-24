<?php

###############################################################################
# french_france.php
#
# This is the French language file for the Geeklog Polls plugin
# Last update by ::Ben http://geeklog.fr May 10 2010
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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_POLLS = array(
    'polls' => 'Sondages',
    'poll' => 'Poll',
    'results' => 'Résultats',
    'pollresults' => 'Résultat des sondages',
    'votes' => 'votes',
    'voters' => 'voters',
    'vote' => 'Vote',
    'pastpolls' => 'Sondages anciens',
    'savedvotetitle' => 'Vote sauvegardé',
    'savedvotemsg' => 'Votre vote à été enregistré',
    'pollstitle' => 'Sondages dans le système',
    'polltopics' => 'Autres sondages',
    'stats_top10' => 'Top-10 des sondages',
    'stats_topics' => 'Titre du sondage',
    'stats_votes' => 'Votes',
    'stats_none' => 'Il n\'y a aucun sondage actif en ce moment, ou personne n\'a encore voté.',
    'stats_summary' => 'Sondages (réponses) dans sur le site',
    'open_poll' => 'Ouvert au vote',
    'answer_all' => 'Merci de répondre à toutes les questions du sondage',
    'not_saved' => 'Le résultat n\'a pas été sauvegardé',
    'upgrade1' => 'Vous avez installez une nouvelle version du plugin polls. Merci',
    'upgrade2' => 'd\'upgrader',
    'editinstructions' => 'Saisir l\'identifiant du sondage (ID), et au moins une question et deux réponses.',
    'pollclosed' => 'Ce sondage est terminé.',
    'pollhidden' => 'Vous avez déjà voté. Les résultats seront disponible lorsque le sondage sera terminé.',
    'start_poll' => 'Commencer le sondage',
    'no_new_polls' => 'Pas de nouveau sondage',
    'autotag_desc_poll' => '[poll: id alternate title] - Displays a link to a poll using the Poll Topic as the title. An alternate title may be specified but is not required.',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] - Displays a poll for voting. Class and showall not required. Class specifies the css class and Showall if set to 1, shows all questions',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] - Displays the poll results. Class not required. Class specifies the css class.',
    'deny_msg' => 'L\'accès à ce sondage n\'est pas possible. Soit il a été déplacé, soit vous n\'avez pas les permissions suffisantes pour y accéder.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Mode',
    2 => 'Merci de saisir un titre, une question et deux réponses.',
    3 => 'Sondage créé',
    4 => 'Sondage %s sauvé',
    5 => 'Edité le sondage',
    6 => 'ID du sondage',
    7 => '(Ne pas utiliser d\'espace)',
    8 => 'Apparait dans le block Sondages',
    9 => 'Titre',
    10 => 'Réponses / Votes / Remarque',
    11 => 'Il y a eut une erreur lors de la saisie de la réponse au sondage %s',
    12 => 'Il y a eut une erreur lors de la saisie de la question du sondage %s',
    13 => 'Créer un sondage',
    14 => 'Sauvegarder',
    15 => 'Annuler',
    16 => 'Effacer',
    17 => 'Merci de saisir une ID pour ce sondage',
    18 => 'Liste des sondages',
    19 => 'Pour modifier ou effacer un sondage, cliquer sur l\'icon editer dus osndage. Pour créer un nouveau sondage, cliquer sur Nouveau au dessus.',
    20 => 'Votants',
    21 => 'Accès refusé',
    22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/poll.php\">go back to the poll administration screen</a>.",
    23 => 'Nouveau sondage',
    24 => 'Admin Home',
    25 => 'Oui',
    26 => 'Non',
    27 => 'Editer',
    28 => 'Envoyer',
    29 => 'Recherche',
    30 => 'Limiter les réesultats',
    31 => 'Question',
    32 => 'To remove this question from the poll, remove its question text',
    33 => 'Open for voting',
    34 => 'Titre du sondage:',
    35 => 'Ce sondage à',
    36 => 'questions supplémentaires.',
    37 => 'Cacher les résultats pendant que le sondage est ouvert',
    38 => 'Pendant que le sondage est ouvert, seuls le propriétaire et l\'administrateur root peuvent voir les résultats',
    39 => 'The topic will only be displayed if there is more than 1 question.',
    40 => 'Voir toutes les réponses à ce sondage'
);

$PLG_polls_MESSAGE15 = 'Votre commentaire à été soumis à validation et sera publié après avoir été approuvé par un modérateur';
$PLG_polls_MESSAGE19 = 'Vos sondages ont été sauvegardés avec succès.';
$PLG_polls_MESSAGE20 = 'Votre sondage à été effacé avec succès.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'Sondages',
    'title' => 'Configuration des sondages'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'Login requis pour accès aux sondages',
    'hidepollsmenu' => 'Cacher les sondages de la navigation',
    'maxquestions' => 'Max. de questions par sondage',
    'maxanswers' => 'Max. d\'options par question',
    'answerorder' => 'Trier les résultats...',
    'pollcookietime' => 'Voter Cookie du votant valide pour',
    'polladdresstime' => 'Adresse IP du votant valide pour',
    'delete_polls' => 'Supprimer le sondage avec le propriétaire',
    'aftersave' => 'Après la sauvegarde du sondage',
    'default_permissions' => 'Permissions par défaut du sondage',
    'autotag_permissions_poll' => '[poll: ] Permissions',
    'autotag_permissions_poll_vote' => '[poll_vote: ] Permissions',
    'autotag_permissions_poll_result' => '[poll_result: ] Permissions',
    'newpollsinterval' => 'Interval des nouveaux sondages',
    'hidenewpolls' => 'Nouveaux sondages',
    'title_trim_length' => 'Couper la longueur du titre',
    'meta_tags' => 'Activé les Meta Tags',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Principaux paramètres'
);

$LANG_tab['polls'] = array(
    'tab_main' => 'General Polls Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_poll_block' => 'Poll Block'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'Sondages paramètres généraux',
    'fs_whatsnew' => 'Block Quoi de neuf',
    'fs_permissions' => 'Permissions par défault',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('Oui' => 1, 'Non' => 0),
    1 => array('Oui' => true, 'Non' => false),
    2 => array('Conserver l\'ordre saisi' => 'submitorder', 'Par nombre de votes' => 'voteorder'),
    5 => array('Cacher' => 'hide', 'Montrer - Utiliser la date modification' => 'modified', 'Montrer - Utiliser la date de création' => 'created'),
    9 => array('Afficher le sondage' => 'item', 'Montrer la liste admin' => 'list', 'Montrer la liste publique' => 'plugin', 'Accueil' => 'home', 'Montrer panneau Admin' => 'admin'),
    12 => array('Pas d\'accès' => 0, 'Lecture seule' => 2, 'Lecture-Ecriture' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
