<?php

###############################################################################
# french_france.php
#
# This is the French language file for the Geeklog Calendar plugin
# Last update by ::Ben http://geeklog.fr May 10 2010 
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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Calendrier',
    2 => 'Désolé, il n\'y a aucun événement.',
    3 => 'Quand',
    4 => 'Où',
    5 => 'Description',
    6 => 'Ajouter un événement',
    7 => 'A venir',
    8 => 'Ajoutez cet évènement à votre calendrier personnel et accédez à vos évènements privés via la fonction calendrier de votre espace membre.',
    9 => 'Ajoutez à mon calendrier',
    10 => 'Retirez de mon calendrier',
    11 => 'Ajoutez au calendrier de %s',
    12 => 'Évènement',
    13 => 'Début',
    14 => 'Fin',
    15 => 'Retour au calendrier',
    16 => 'Calendrier',
    17 => 'Date de début',
    18 => 'Date de fin',
    19 => 'Soumissions d\'événements',
    20 => 'Titre',
    21 => 'Date de début',
    22 => 'URL',
    23 => 'Vos événements',
    24 => 'Les événements du site',
    25 => 'Il n\'y a aucun événement à venir',
    26 => 'Soumettre un événement',
    27 => "En soumettant un événement à {$_CONF['site_name']}, vous acceptez que celui-ci soit vu par tous les usagers du site.<br" . XHTML . "><br" . XHTML . ">La soumission apparaîtra au calendrier général une fois approuvé par l\'administrateur du site.",
    28 => 'Titre',
    29 => 'Heure fin',
    30 => 'Heure début',
    31 => 'Toute la journée',
    32 => 'Adresse 1',
    33 => 'Adresse 2',
    34 => 'Ville',
    35 => 'Région',
    36 => 'Code postal',
    37 => 'Type',
    38 => 'Éditez les types',
    39 => 'Lieu',
    40 => 'Ajoutez à',
    41 => 'calendrier général',
    42 => 'calendrier personnel',
    43 => 'Lien',
    44 => 'HTML non-permis',
    45 => 'Envoyez',
    46 => 'Événements dans le système',
    47 => 'Les 10 événements les plus consultés',
    48 => 'Hits',
    49 => 'Il semblerait qu\'il n\'y est aucun événement sur ce site ou que personne ne les ai découverts.',
    50 => 'Événements',
    51 => 'Effacer'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Résultats',
    'title' => 'Titre',
    'date_time' => 'Date et heure',
    'location' => 'Lieu',
    'description' => 'Description'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '+ événement personnel',
    9 => '%s Event',
    10 => 'Évènement pour',
    11 => 'Calendrier général',
    12 => 'Mon calendrier',
    25 => 'Back to ',
    26 => 'Toute la journée',
    27 => 'Semaine',
    28 => 'Calendrier perso de',
    29 => 'Calendrier général',
    30 => 'Effacez',
    31 => 'Ajoutez',
    32 => 'Événement',
    33 => 'Date',
    34 => 'Heure',
    35 => 'Ajout rapide',
    36 => 'Soumettre',
    37 => 'Désolé, cette fonction n\'est pas activée sur ce site',
    38 => 'Éditeur personnel',
    39 => 'Jour',
    40 => 'Semaine',
    41 => 'Mois',
    42 => 'Ajouter un évènement',
    43 => 'Soumission des événements'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Éditeur',
    2 => 'Erreur',
    3 => 'Mode',
    4 => 'URL',
    5 => 'Début',
    6 => 'Fin',
    7 => 'Endroit',
    8 => 'Description',
    9 => '(inclure http://)',
    10 => 'Vous devez compléter tous les champs',
    11 => 'Gestionaire du calendrier',
    12 => 'Pour modifier ou supprimer un évènement, cliquez sur l\'icon d\'édition ci-dessous.  Pour créer un nouvel évènement, cliquez sur "Ajouter" ci-dessus. Cliquez sur l\'icon copie pour créer une copie d\'un évènement existant.',
    13 => 'Auteur',
    14 => 'Date de début',
    15 => 'Date de fin',
    16 => '',
    17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">go back to the event administration screen</a>.",
    18 => '',
    19 => '',
    20 => 'Sauvegarder',
    21 => 'Annuler',
    22 => 'Effacer',
    23 => 'Mauvaise date de début.',
    24 => 'Mauvaise date de fin.',
    25 => 'La date de fin est antérieure à la date de début.',
    26 => 'Supprimer les anciennes dates',
    27 => 'Voici les évènements plus anciens que ',
    28 => ' mois. Cochez les évènements souhaités et cliquez sur l\'icon corbeille en bas de page pour les supprimer, ou sélectionnez un autre laps de temps :<br' . XHTML . '>Trouver tous les évènement plus vieux que ',
    29 => ' mois.',
    30 => 'Mettre à jour la liste',
    31 => 'Etes-vous sûre de vouloir supprimer tous les utilisateurs sélectionnés ?',
    32 => 'Tout lister',
    33 => 'Aucun évènement sélectionner pour la suppression',
    34 => 'ID de l\évènement',
    35 => 'ne peut pas être effacer',
    36 => 'effacer avec succès'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'Événement ajouté avec succès.',
    'delete' => 'Événement effacé avec succès.',
    'private' => 'Événement sauvegardé à votre calendrier',
    'login' => 'Impossible d\'ouvrir votre calendrier personnel tant que vous n\êtes pas connecté',
    'removed' => 'L\événement à été retiré de votre calendrier personnel',
    'noprivate' => 'Désolé, les calendriers personnels ne sont pas admis sur ce site',
    'unauth' => 'Désolé, vous n\'avez pas accès à l\'administration du calendrier. Toute les tentatives non autorisées sont enregistrées'
);

$PLG_calendar_MESSAGE4 = "Merci d\'avoir soumis un évènement à {$_CONF['site_name']}.  Vous pourrez le visualisé sur le <a href=\"{$_CONF['site_url']}/calendar/index.php\">calendrier</a> une fois qui sera approuvé.";
$PLG_calendar_MESSAGE17 = 'Événement sauvegardé avec succès.';
$PLG_calendar_MESSAGE18 = 'Événement effacé avec succès.';
$PLG_calendar_MESSAGE24 = 'Événement sauvegardé sur votre calendrier.';
$PLG_calendar_MESSAGE26 = 'Événement effacé avec succès.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendrier',
    'title' => 'Calendrier - Configuration'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Connexion nécessaire pour accéder au calendrier',
    'hidecalendarmenu' => 'Cacher le calendrier dans la barre de navigation',
    'personalcalendars' => 'Activer les calendriers personnels',
    'eventsubmission' => 'Activer la soumission',
    'showupcomingevents' => 'Montrer les évènement à venir',
    'upcomingeventsrange' => 'Période des évènements à venir',
    'event_types' => 'Types d\'évènement',
    'hour_mode' => 'Mode horaire',
    'notification' => 'Notification par email',
    'delete_event' => 'Supprimer les évènements avec leur propriétaire',
    'aftersave' => 'Après la sauvegarde d\un évènement',
    'default_permissions' => 'Permissions par défaut des évènements'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Paramétres principaux'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'Paramètres généraux du calendrier',
    'fs_permissions' => 'Permissions par défaut'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('Oui' => 1, 'Non' => 0),
    1 => array('Oui' => true, 'Non' => false),
    6 => array('12H' => 12, '24H' => 24),
    9 => array('Afficher l\'évènement' => 'item', 'Afficher la liste administrateur' => 'list', 'Afficher le calendrier' => 'plugin', 'Afficher la page d\'acceuil' => 'home', 'Afficher le panneau administratif' => 'admin'),
    12 => array('Aucun accès' => 0, 'Lecture seule' => 2, 'Lecture-Ecriture' => 3)
);

?>
