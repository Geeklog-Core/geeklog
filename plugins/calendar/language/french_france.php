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
    2 => 'D�sol�, il n\'y a aucun �v�nement.',
    3 => 'Quand',
    4 => 'O�',
    5 => 'Description',
    6 => 'Ajouter un �v�nement',
    7 => 'A venir',
    8 => 'Ajoutez cet �v�nement � votre calendrier personnel et acc�dez � vos �v�nements priv�s via la fonction calendrier de votre espace membre.',
    9 => 'Ajoutez � mon calendrier',
    10 => 'Retirez de mon calendrier',
    11 => 'Ajoutez au calendrier de %s',
    12 => '�v�nement',
    13 => 'D�but',
    14 => 'Fin',
    15 => 'Retour au calendrier',
    16 => 'Calendrier',
    17 => 'Date de d�but',
    18 => 'Date de fin',
    19 => 'Soumissions d\'�v�nements',
    20 => 'Titre',
    21 => 'Date de d�but',
    22 => 'URL',
    23 => 'Vos �v�nements',
    24 => 'Les �v�nements du site',
    25 => 'Il n\'y a aucun �v�nement � venir',
    26 => 'Soumettre un �v�nement',
    27 => "En soumettant un �v�nement � {$_CONF['site_name']}, vous acceptez que celui-ci soit vu par tous les usagers du site.<br" . XHTML . "><br" . XHTML . ">La soumission appara�tra au calendrier g�n�ral une fois approuv� par l\'administrateur du site.",
    28 => 'Titre',
    29 => 'Heure fin',
    30 => 'Heure d�but',
    31 => 'Toute la journ�e',
    32 => 'Adresse 1',
    33 => 'Adresse 2',
    34 => 'Ville',
    35 => 'R�gion',
    36 => 'Code postal',
    37 => 'Type',
    38 => '�ditez les types',
    39 => 'Lieu',
    40 => 'Ajoutez �',
    41 => 'calendrier g�n�ral',
    42 => 'calendrier personnel',
    43 => 'Lien',
    44 => 'HTML non-permis',
    45 => 'Envoyez',
    46 => '�v�nements dans le syst�me',
    47 => 'Les 10 �v�nements les plus consult�s',
    48 => 'Hits',
    49 => 'Il semblerait qu\'il n\'y est aucun �v�nement sur ce site ou que personne ne les ai d�couverts.',
    50 => '�v�nements',
    51 => 'Effacer',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'R�sultats',
    'title' => 'Titre',
    'date_time' => 'Date et heure',
    'location' => 'Lieu',
    'description' => 'Description'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => '+ �v�nement personnel',
    9 => '%s Event',
    10 => '�v�nement pour',
    11 => 'Calendrier g�n�ral',
    12 => 'Mon calendrier',
    25 => 'Back to ',
    26 => 'Toute la journ�e',
    27 => 'Semaine',
    28 => 'Calendrier perso de',
    29 => 'Calendrier g�n�ral',
    30 => 'Effacez',
    31 => 'Ajoutez',
    32 => '�v�nement',
    33 => 'Date',
    34 => 'Heure',
    35 => 'Ajout rapide',
    36 => 'Soumettre',
    37 => 'D�sol�, cette fonction n\'est pas activ�e sur ce site',
    38 => '�diteur personnel',
    39 => 'Jour',
    40 => 'Semaine',
    41 => 'Mois',
    42 => 'Ajouter un �v�nement',
    43 => 'Soumission des �v�nements'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => '�diteur',
    2 => 'Erreur',
    3 => 'Mode',
    4 => 'URL',
    5 => 'D�but',
    6 => 'Fin',
    7 => 'Endroit',
    8 => 'Description',
    9 => '(inclure http://)',
    10 => 'Vous devez compl�ter tous les champs',
    11 => 'Gestionaire du calendrier',
    12 => 'Pour modifier ou supprimer un �v�nement, cliquez sur l\'icon d\'�dition ci-dessous.  Pour cr�er un nouvel �v�nement, cliquez sur "Ajouter" ci-dessus. Cliquez sur l\'icon copie pour cr�er une copie d\'un �v�nement existant.',
    13 => 'Auteur',
    14 => 'Date de d�but',
    15 => 'Date de fin',
    16 => '',
    17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">go back to the event administration screen</a>.",
    18 => '',
    19 => '',
    20 => 'Sauvegarder',
    21 => 'Annuler',
    22 => 'Effacer',
    23 => 'Mauvaise date de d�but.',
    24 => 'Mauvaise date de fin.',
    25 => 'La date de fin est ant�rieure � la date de d�but.',
    26 => 'Supprimer les anciennes dates',
    27 => 'Voici les �v�nements plus anciens que ',
    28 => ' mois. Cochez les �v�nements souhait�s et cliquez sur l\'icon corbeille en bas de page pour les supprimer, ou s�lectionnez un autre laps de temps :<br' . XHTML . '>Trouver tous les �v�nement plus vieux que ',
    29 => ' mois.',
    30 => 'Mettre � jour la liste',
    31 => 'Etes-vous s�re de vouloir supprimer tous les utilisateurs s�lectionn�s ?',
    32 => 'Tout lister',
    33 => 'Aucun �v�nement s�lectionner pour la suppression',
    34 => 'ID de l\�v�nement',
    35 => 'ne peut pas �tre effacer',
    36 => 'effacer avec succ�s'
);

$LANG_CAL_MESSAGE = array(
    'save' => '�v�nement ajout� avec succ�s.',
    'delete' => '�v�nement effac� avec succ�s.',
    'private' => '�v�nement sauvegard� � votre calendrier',
    'login' => 'Impossible d\'ouvrir votre calendrier personnel tant que vous n\�tes pas connect�',
    'removed' => 'L\�v�nement � �t� retir� de votre calendrier personnel',
    'noprivate' => 'D�sol�, les calendriers personnels ne sont pas admis sur ce site',
    'unauth' => 'D�sol�, vous n\'avez pas acc�s � l\'administration du calendrier. Toute les tentatives non autoris�es sont enregistr�es'
);

$PLG_calendar_MESSAGE4 = "Merci d\'avoir soumis un �v�nement � {$_CONF['site_name']}.  Vous pourrez le visualis� sur le <a href=\"{$_CONF['site_url']}/calendar/index.php\">calendrier</a> une fois qui sera approuv�.";
$PLG_calendar_MESSAGE17 = '�v�nement sauvegard� avec succ�s.';
$PLG_calendar_MESSAGE18 = '�v�nement effac� avec succ�s.';
$PLG_calendar_MESSAGE24 = '�v�nement sauvegard� sur votre calendrier.';
$PLG_calendar_MESSAGE26 = '�v�nement effac� avec succ�s.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendrier',
    'title' => 'Calendrier - Configuration'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Connexion n�cessaire pour acc�der au calendrier',
    'hidecalendarmenu' => 'Cacher le calendrier dans la barre de navigation',
    'personalcalendars' => 'Activer les calendriers personnels',
    'eventsubmission' => 'Activer la soumission',
    'showupcomingevents' => 'Montrer les �v�nement � venir',
    'upcomingeventsrange' => 'P�riode des �v�nements � venir',
    'event_types' => 'Types d\'�v�nement',
    'hour_mode' => 'Mode horaire',
    'notification' => 'Notification par email',
    'delete_event' => 'Supprimer les �v�nements avec leur propri�taire',
    'aftersave' => 'Apr�s la sauvegarde d\un �v�nement',
    'default_permissions' => 'Permissions par d�faut des �v�nements',
    'autotag_permissions_event' => '[event: ] Permissions',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Param�tres principaux'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'General Calendar Settings',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_events_block' => 'Events Block'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'Param�tres g�n�raux du calendrier',
    'fs_permissions' => 'Permissions par d�faut',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('Oui' => 1, 'Non' => 0),
    1 => array('Oui' => true, 'Non' => false),
    6 => array('12H' => 12, '24H' => 24),
    9 => array('Afficher l\'�v�nement' => 'item', 'Afficher la liste administrateur' => 'list', 'Afficher le calendrier' => 'plugin', 'Afficher la page d\'acceuil' => 'home', 'Afficher le panneau administratif' => 'admin'),
    12 => array('Aucun acc�s' => 0, 'Lecture seule' => 2, 'Lecture-Ecriture' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => TOPIC_ALL_OPTION, 'Homepage Only' => TOPIC_HOMEONLY_OPTION, 'Select Topics' => TOPIC_SELECTED_OPTION)
);

?>
