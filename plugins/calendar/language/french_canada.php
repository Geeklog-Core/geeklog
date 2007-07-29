<?php

###############################################################################
# english.php
# This is the english language page for the Geeklog Calendar Plug-in!
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

# index.php
$LANG_CAL_1 = array(
    1 => 'Calendrier',
    2 => 'Désolé, il n\'y a rien à l\'horaire.',
    3 => 'Quand',
    4 => 'Où',
    5 => 'Description',
    6 => 'Ajout',
    7 => 'À venir',
    8 => 'Ajoutez cet évènement à votre calendrier personnel et accédez à vos évènements privés via la fonction calendrier de votre zone membre.',
    9 => 'Ajoutez à mon calendrier',
    10 => 'Retirez de mon calendrier',
    11 => "Ajoutez au calendrier de %s",
    12 => 'Évènement',
    13 => 'Début',
    14 => 'Fin',
    15 => 'De retour au calendrier',
    16 => 'Calendrier',
    17 => 'Date de début',
    18 => 'Date de fin',
    19 => 'Soumissions',
    20 => 'Titre',
    21 => 'Date de départ',
    22 => 'URL',
    23 => 'Vos évènements',
    24 => 'Les évènements du site',
    25 => 'Il n\'y a aucun évènement à venir',
    26 => 'Soumettre un évènement',
    27 => "En soumettant un évènement à {$_CONF['site_name']}, vous acceptez que celui-ci soit vu par tous les usagers du site. Cette fonction est interdite aux envois de type personnels.<br><br>La soumission apparaîtra au calendrier général une fois approuvé par l\'administrateur du site.",
    28 => 'Titre',
    29 => 'Heure du début',
    30 => 'Heure de la fin',
    31 => 'Toute la journée',
    32 => 'Adresse 1',
    33 => 'Adresse 2',
    34 => 'Ville',
    35 => 'Région',
    36 => 'Code postal',
    37 => 'Type',
    38 => 'Éditez les types',
    39 => 'Endroit',
    40 => 'Ajoutez à',
    41 => 'calendrier général',
    42 => 'calendrier personnel',
    43 => 'Lien',
    44 => 'HTML non-permis',
    45 => 'Envoyez',
    46 => 'Évènements dans le système',
    47 => 'Le top10',
    48 => 'Hits',
    49 => 'Pas d\'évènements en perspective, ou vous n\'avez pas cliqué sur un évènement.',
    50 => 'Évènements',
    51 => 'Effacer'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Résultats',
    'title' => 'Titre',
    'date_time' => 'Date et heure',
    'location' => 'Endroit',
    'description' => 'Description'

);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Choisissez',
    9 => '%s Event',
    10 => 'Évènement pour',
    11 => 'le calendrier général',
    12 => 'mon calendrier',
    25 => 'Retour à ',
    26 => 'Toute la journée',
    27 => 'Semaine',
    28 => 'Calendrier perso de',
    29 => 'Calendrier général',
    30 => 'effacez',
    31 => 'Ajoutez',
    32 => 'Évènement',
    33 => 'Date',
    34 => 'Heure',
    35 => 'Ajout rapide',
    36 => 'Soumettre',
    37 => 'Désolé, cette fonction n\'est pas activée sur ce site',
    38 => 'Éditeur personnel',
    39 => 'Jour',
    40 => 'Semaine',
    41 => 'Mois',
    42 => 'Ajoutez un évènement général',
    43 => 'Soumission des évènements',
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Éditeur',
    2 => 'Erreur',
    3 => 'Mode Post',
    4 => 'URL',
    5 => 'Date de départ',
    6 => 'Date de fin',
    7 => 'Endroit',
    8 => 'Description',
    9 => '(inclure http://)',
    10 => 'Vous devez compléter tous les champs',
    11 => 'Calendar Manager',
    12 => 'To modify or delete an event, click on that event\'s edit icon below.  To create a new event, click on "Create New" above. Click on the copy icon to create a copy of an existing event.',
    13 => 'Auteur',
    14 => 'Date de départ',
    15 => 'Date de fin',
    16 => '',
    17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">go back to the event administration screen</a>.",
    18 => '',
    19 => '',
    20 => 'sauvegarder',
    21 => 'annuler',
    22 => 'effacer',
    23 => 'Mauvaise date de départ.',
    24 => 'Mauvaise date de fin.',
    25 => 'La fin précède le départ.'
);

$LANG_CAL_MESSAGE = array(
    'save'      => 'Évènement ajouté avec succès.',
    'delete'    => 'Évènement effacé avec succès.',
    'private'   => 'Évènement sauvegardé à votre calendrier',
    'login'     => 'Cannot open your personal calendar until you login',
    'removed'   => 'Event was successfully removed from your personal calendar',
    'noprivate' => 'Désolé, les calendriers persos ne sont pas admis sur ce site',
    'unauth'    => 'Sorry, you do not have access to the event administration page.  Please note that all attempts to access unauthorized features are logged',
);

$PLG_calendar_MESSAGE4  = "Merci de soumettre un évènement à {$_CONF['site_name']}.  Vous pourrez le visualisé sur le <a href=\"{$_CONF['site_url']}/calendar/index.php\">calendrier</a> une fois approuvé.";
$PLG_calendar_MESSAGE17 = 'Évènement sauvegardé avec succès.';
$PLG_calendar_MESSAGE18 = 'Évènement effacé avec succès.';
$PLG_calendar_MESSAGE24 = 'Évènement sauvegardé sur votre calendrier.';
$PLG_calendar_MESSAGE26 = 'Évènement effacé avec succès.';

?>
