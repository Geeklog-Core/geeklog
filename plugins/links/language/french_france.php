<?php

###############################################################################
# french_france.php
#
# This is the french language page for the Geeklog links Plug-in!
# Last update by ::Ben http://geeklog.fr May 10 2010 
# Copyright (C) 2001 Tony Bibbs
# tony AT tonybibbs DOT com
# Copyright (C) 2005 Trinity Bays
# trinity93 AT gmail DOT com
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

$LANG_LINKS = array(
    10 => 'Soumissions',
    14 => 'Liens',
    84 => 'LIENS',
    88 => 'Pas de liens r&eacute;cents',
    114 => 'Liens',
    116 => 'Ajoutez un lien',
    117 => 'Signaler un lien cassé',
    118 => 'Papport de lien cassé',
    119 => 'Le lien suivant est signalé cassé : ',
    120 => 'Pour éditer le lien, cliquez ici : ',
    121 => 'Le liens cassé à été signalé par : ',
    122 => 'Merci d\'avoir signaler ce lien cassé. L\'administrateur essaiera de corriger le problème le plus tôt possible.',
    123 => 'Merci',
    124 => 'Go',
    125 => 'Catégories',
    126 => 'Vous êtes ici :',
    'root' => 'Accueil'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Liens enregistrés (nombre de clicks)',
    'stats_headline' => 'Liens les plus visités',
    'stats_page_title' => 'Liens',
    'stats_hits' => 'Clics',
    'stats_no_hits' => 'Il semblerait qu\'il n\'y a pas encore de lien ou que personne n\'ai cliqué dessus.'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => 'Résultat des liens',
    'title' => 'Titre',
    'date' => 'Date d\'ajout',
    'author' => 'Soumis par',
    'hits' => 'Clics'
);

###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'Soumettez un lien',
    2 => 'Lien',
    3 => 'Cat&eacute;gorie',
    4 => 'Autre',
    5 => 'Sp&eacute;cifiez autre',
    6 => 'Erreur : cat&eacute;gorie manquante',
    7 => 'Lorsque vous s&eacute;lectionnez "Autre", merci d\'aussi inscrire une cat&eacute;gorie correspondante',
    8 => 'Titre',
    9 => 'URL',
    10 => 'Catégorie',
    11 => 'Liens soumis'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Merci de soumettre un lien sur {$_CONF['site_name']}.  Votre demande est en cours d\'approbation. Une fois approuvée votre soumission sera affich&eacute;e dans la <a href={$_CONF['site_url']}/links/index.php>section des liens</a>.";
$PLG_links_MESSAGE2 = 'Lien sauvegard&eacute; avec succès.';
$PLG_links_MESSAGE3 = 'Lien effac&eacute; avec succès.';
$PLG_links_MESSAGE4 = "Merci de soumettre un lien sur {$_CONF['site_name']}. Il apparaît d&eacute;sormais à la <a href={$_CONF['site_url']}/links/index.php>section des liens</a>.";
$PLG_links_MESSAGE5 = 'You do not have sufficient access rights to view this category.';
$PLG_links_MESSAGE6 = 'You do not have sufficient rights to edit this category.';
$PLG_links_MESSAGE7 = 'Please enter a Category Name and Description.';
$PLG_links_MESSAGE10 = 'Your category has been successfully saved.';
$PLG_links_MESSAGE11 = 'You are not allowed to set the id of a category to "site" or "user" - these are reserved for internal use.';
$PLG_links_MESSAGE12 = 'You are trying to make a parent category the child of it\'s own subcategory. This would create an orphan category, so please first move the child category or categories up to a higher level.';
$PLG_links_MESSAGE13 = 'The category has been successfully deleted.';
$PLG_links_MESSAGE14 = 'Category contains links and/or categories. Please remove these first.';
$PLG_links_MESSAGE15 = 'You do not have sufficient rights to delete this category.';
$PLG_links_MESSAGE16 = 'No such category exists.';
$PLG_links_MESSAGE17 = 'This category id is already in use.';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

$LANG_LINKS_ADMIN = array(
    1 => 'Editeur de lien',
    2 => 'ID',
    3 => 'Titre',
    4 => 'URL',
    5 => 'Catégorie',
    6 => '(inclus http://)',
    7 => 'Autre',
    8 => 'Nombre de clics',
    9 => 'Description',
    10 => 'Vous devez saisir un titre, une URL et une description.',
    11 => 'Manager des liens',
    12 => 'Pour modifier ou effacer un lien, cliquez sur l\'icone du lien ci-dessous.  Pour créer un nouveau lien ou une nouvelle catégorie, cliquez sur "Nouveau lien" ou "Nouvelle catégorie" ci-dessus. Pour éditer des catégories multiples, cliquez sur "editez des catégories" ci-dessous.',
    14 => 'Catégories',
    16 => 'Accès refusé',
    17 => "Vous essayez d'accéder à un lien sur lequel vous n'avez pas de droit. Cette tentative est enregistrée. Merci de <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">retourner à l'interface d'administration</a>.",
    20 => 'Si autre, spécifier',
    21 => 'Sauvegarder',
    22 => 'Annuler',
    23 => 'Effacer',
    24 => 'Lien non trouvé',
    25 => 'Le lien que vous avez choisi ne peut être trouvé.',
    26 => 'Validez les liens',
    27 => 'HTML Status',
    28 => 'Editer la catégorie',
    29 => 'Saisir ou éditer les détails ci-dessous.',
    30 => 'Catégorie',
    31 => 'Description',
    32 => 'Catégorie ID',
    33 => 'Catégorie (articles)',
    34 => 'Parent',
    35 => 'Tous',
    40 => 'Editer cette catégorie',
    41 => 'Créer une catégorie fille',
    42 => 'Effacer cette catégorie',
    43 => 'Site categories',
    44 => 'Ajouter&nbsp;descendant',
    46 => 'Le membre %s à essayé d\'effacer une catégorie à laquelle il n\'a pas accès.',
    50 => 'Liste des catégories',
    51 => 'Nouveau lien',
    52 => 'Nouvelle catégorie',
    53 => 'Liste des liens',
    54 => 'Manager des catégories',
    55 => 'Editer les catégories ci-dessous. Noter que vous ne pouvez supprimer une catégorie qui contient une autre catégorie ou des liens - Vous devez les supprimer en premier, ou les déplacer dans une autre catégorie.',
    56 => 'Editeur de Catégorie',
    57 => 'Pas encore valide',
    58 => 'Valider maintenant',
    59 => '<p>Pour valider tous les liens affichés, merci de cliquer sur le lien "Valider maintenant" ci-dessous. Notez que cela peut prendre un peu de temps en fonction du nombre de liens.</p>',
    60 => 'Le membre %s a essayé illégalement d\'étiter la catégorie %s.',
    61 => 'Liens daans la catégorie'
);


$LANG_LINKS_STATUS = array(
    100 => 'Continuer',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Créé',
    202 => 'Accepté',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    999 => 'Connection Timed out'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => 'Liens',
    'title' => 'Configuration | Liens'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => 'Faut il se connecter pour accéder aux liens?',
    'linksubmission' => 'Activer la file d\'attente pour les nouveaux liens soumis?',
    'newlinksinterval' => 'Intervale pour les nouveaux liens dans le block Quoi de Neuf',
    'hidenewlinks' => 'Cacher les nouveau liens dans le block Quoi de Neuf?',
    'hidelinksmenu' => 'Cacher les lLiens dans la barre de navigation?',
    'linkcols' => 'Nombre de Catégorie par ligne',
    'linksperpage' => 'Nombre de liens par page',
    'show_top10' => 'Monterr le Top 10 des liens?',
    'notification' => 'Notification par Email?',
    'delete_links' => 'Supprimer les liens avec leur propriétaire?',
    'aftersave' => 'Après la sauvegarde du lien',
    'show_category_descriptions' => 'Afficher la description de la catégorie?',
    'new_window' => 'Ouvrir les liens externes dans une nouvelle fenêtre?',
    'root' => 'ID de la catégorie Root',
    'default_permissions' => 'Permissions par défaut des liens',
    'category_permissions' => 'Permissions par défaut des catégories'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'Paramètres principaux'
);

$LANG_fs['links'] = array(
    'fs_public' => 'Paramètres de la liste publique des liens',
    'fs_admin' => 'Paramètres administrateur des liens',
    'fs_permissions' => 'Permissions des liens',
    'fs_cpermissions' => 'Permissions des catégories'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('Oui' => 1, 'Non' => 0),
    1 => array('Oui' => true, 'Non' => false),
    9 => array('Afficher le lien' => 'item', 'Afficher la liste administrateur' => 'list', 'Afficher la liste publique' => 'plugin', 'Afficher page d\'accueil' => 'home', 'Afficher l\'interface Admin' => 'admin'),
    12 => array('Pas d\'accès' => 0, 'Lecture seule' => 2, 'Lecture-Ecriture' => 3)
);

?>
