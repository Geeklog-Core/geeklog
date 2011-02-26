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
    117 => 'Signaler un lien cass�',
    118 => 'Papport de lien cass�',
    119 => 'Le lien suivant est signal� cass� : ',
    120 => 'Pour �diter le lien, cliquez ici : ',
    121 => 'Le liens cass� � �t� signal� par : ',
    122 => 'Merci d\'avoir signaler ce lien cass�. L\'administrateur essaiera de corriger le probl�me le plus t�t possible.',
    123 => 'Merci',
    124 => 'Go',
    125 => 'Cat�gories',
    126 => 'Vous �tes ici :',
    'autotag_desc_link' => '[link: id alternate title] - Displays a link to a Link from the Links Plugin using the Link Title as the title. An alternate title may be specified but is not required.',
    'root' => 'Accueil'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Liens enregistr�s (nombre de clicks)',
    'stats_headline' => 'Liens les plus visit�s',
    'stats_page_title' => 'Liens',
    'stats_hits' => 'Clics',
    'stats_no_hits' => 'Il semblerait qu\'il n\'y a pas encore de lien ou que personne n\'ai cliqu� dessus.'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => 'R�sultat des liens',
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
    10 => 'Cat�gorie',
    11 => 'Liens soumis'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Merci de soumettre un lien sur {$_CONF['site_name']}.  Votre demande est en cours d\'approbation. Une fois approuv�e votre soumission sera affich&eacute;e dans la <a href={$_CONF['site_url']}/links/index.php>section des liens</a>.";
$PLG_links_MESSAGE2 = 'Lien sauvegard&eacute; avec succ�s.';
$PLG_links_MESSAGE3 = 'Lien effac&eacute; avec succ�s.';
$PLG_links_MESSAGE4 = "Merci de soumettre un lien sur {$_CONF['site_name']}. Il appara�t d&eacute;sormais � la <a href={$_CONF['site_url']}/links/index.php>section des liens</a>.";
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
    5 => 'Cat�gorie',
    6 => '(inclus http://)',
    7 => 'Autre',
    8 => 'Nombre de clics',
    9 => 'Description',
    10 => 'Vous devez saisir un titre, une URL et une description.',
    11 => 'Manager des liens',
    12 => 'To modify or delete a link, click on that link\'s edit icon below.  To create a new link or a new category, click on "New link" or "New category" above. To edit multiple categories, click on "List categories" above.',
    14 => 'Cat�gories',
    16 => 'Acc�s refus�',
    17 => "Vous essayez d'acc�der � un lien sur lequel vous n'avez pas de droit. Cette tentative est enregistr�e. Merci de <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">retourner � l'interface d'administration</a>.",
    20 => 'Si autre, sp�cifier',
    21 => 'Sauvegarder',
    22 => 'Annuler',
    23 => 'Effacer',
    24 => 'Lien non trouv�',
    25 => 'Le lien que vous avez choisi ne peut �tre trouv�.',
    26 => 'Validez les liens',
    27 => 'HTTP Status',
    28 => 'Editer la cat�gorie',
    29 => 'Saisir ou �diter les d�tails ci-dessous.',
    30 => 'Cat�gorie',
    31 => 'Description',
    32 => 'Cat�gorie ID',
    33 => 'Cat�gorie (articles)',
    34 => 'Parent',
    35 => 'Tous',
    40 => 'Editer cette cat�gorie',
    41 => 'Cr�er une cat�gorie fille',
    42 => 'Effacer cette cat�gorie',
    43 => 'Site categories',
    44 => 'Ajouter&nbsp;descendant',
    46 => 'Le membre %s � essay� d\'effacer une cat�gorie � laquelle il n\'a pas acc�s.',
    50 => 'Liste des cat�gories',
    51 => 'Nouveau lien',
    52 => 'Nouvelle cat�gorie',
    53 => 'Liste des liens',
    54 => 'Manager des cat�gories',
    55 => 'Editer les cat�gories ci-dessous. Noter que vous ne pouvez supprimer une cat�gorie qui contient une autre cat�gorie ou des liens - Vous devez les supprimer en premier, ou les d�placer dans une autre cat�gorie.',
    56 => 'Editeur de Cat�gorie',
    57 => 'Pas encore valide',
    58 => 'Valider maintenant',
    59 => '<p>Pour valider tous les liens affich�s, merci de cliquer sur le lien "Valider maintenant" ci-dessous. Notez que cela peut prendre un peu de temps en fonction du nombre de liens.</p>',
    60 => 'Le membre %s a essay� ill�galement d\'�titer la cat�gorie %s.',
    61 => 'Liens daans la cat�gorie'
);


$LANG_LINKS_STATUS = array(
    100 => 'Continuer',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Cr��',
    202 => 'Accept�',
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
    'linksloginrequired' => 'Faut il se connecter pour acc�der aux liens?',
    'linksubmission' => 'Activer la file d\'attente pour les nouveaux liens soumis?',
    'newlinksinterval' => 'Intervale pour les nouveaux liens dans le block Quoi de Neuf',
    'hidenewlinks' => 'Cacher les nouveau liens dans le block Quoi de Neuf?',
    'hidelinksmenu' => 'Cacher les lLiens dans la barre de navigation?',
    'linkcols' => 'Nombre de Cat�gorie par ligne',
    'linksperpage' => 'Nombre de liens par page',
    'show_top10' => 'Monterr le Top 10 des liens?',
    'notification' => 'Notification par Email?',
    'delete_links' => 'Supprimer les liens avec leur propri�taire?',
    'aftersave' => 'Apr�s la sauvegarde du lien',
    'show_category_descriptions' => 'Afficher la description de la cat�gorie?',
    'new_window' => 'Ouvrir les liens externes dans une nouvelle fen�tre?',
    'root' => 'ID de la cat�gorie Root',
    'default_permissions' => 'Permissions par d�faut des liens',
    'category_permissions' => 'Permissions par d�faut des cat�gories',
    'autotag_permissions_link' => '[link: ] Permissions'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'Param�tres principaux'
);

$LANG_tab['links'] = array(
    'tab_public' => 'Public Links List Settings',
    'tab_admin' => 'Links Admin Settings',
    'tab_permissions' => 'Link Permissions',
    'tab_cpermissions' => 'Category Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['links'] = array(
    'fs_public' => 'Param�tres de la liste publique des liens',
    'fs_admin' => 'Param�tres administrateur des liens',
    'fs_permissions' => 'Permissions des liens',
    'fs_cpermissions' => 'Permissions des cat�gories',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('Oui' => 1, 'Non' => 0),
    1 => array('Oui' => true, 'Non' => false),
    9 => array('Afficher le lien' => 'item', 'Afficher la liste administrateur' => 'list', 'Afficher la liste publique' => 'plugin', 'Afficher page d\'accueil' => 'home', 'Afficher l\'interface Admin' => 'admin'),
    12 => array('Pas d\'acc�s' => 0, 'Lecture seule' => 2, 'Lecture-Ecriture' => 3),
    13 => array('No access' => 0, 'Use' => 2)
);

?>
