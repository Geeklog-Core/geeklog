<?php

###############################################################################
# french_france_utf-8.php
# This is a french language page for the Geeklog Static Page Plug-in!
# Last update ::Ben http://geeklog.fr May 10 2010 Copyright (c) July 2003 Jean-Francois Allard - jfallard@jfallard.com
#
# Copyright (C) 2001 Tony Bibbs tony@tonybibbs.com
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

$LANG_STATIC = array(
    'newpage' => 'Nouvelle page',
    'adminhome' => 'Entrée - admin',
    'staticpages' => 'Pages statiques',
    'staticpageeditor' => 'Éditeur de pages statiques',
    'writtenby' => 'Écrit par',
    'date' => 'Dernière mise à jour',
    'title' => 'Titre',
    'page_title' => 'Titre de la page',
    'content' => 'Contenu',
    'hits' => 'Clicks',
    'staticpagelist' => 'Liste des pages statiques',
    'url' => 'URL',
    'edit' => 'Edit',
    'lastupdated' => 'Dernière mise à jour',
    'pageformat' => 'Format des pages',
    'leftrightblocks' => 'Blocs à gauche et à droite',
    'blankpage' => 'Nouvelle page vierge',
    'noblocks' => 'Pas de blocs',
    'leftblocks' => 'Blocs à gauche',
    'addtomenu' => 'Ajoutez au menu',
    'label' => 'Libellé',
    'nopages' => 'Il n\'y a pas de pages statiques enregistrées dans le système présentement',
    'save' => 'sauvegarde',
    'preview' => 'aperçu',
    'delete' => 'effacer',
    'cancel' => 'annuler',
    'access_denied' => 'Acces refusé',
    'access_denied_msg' => 'Vous essayez d\'accéder illégalement à l\'une des pages administratives relatives aux pages statiques. Veuillez noter que toutes les tentatives illégales en ce sens seront enregistrées',
    'all_html_allowed' => 'Toutes les balises HTML sont acceptées',
    'results' => 'Résultats des pages statiques',
    'author' => 'Auteur',
    'no_title_or_content' => 'Vous devez au minimum inscrire quelque chose dans les champs <b>titre</b> et <b>contenu</b>.',
    'no_such_page_anon' => 'Prière de vous enregistrer',
    'no_page_access_msg' => "Ce pourrait être parce que vous ne vous êtes pas enregistré, ou inscrit comme membre de {$_CONF['site_name']}. Veuillez <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> vous inscrire comme membre</a> de {$_CONF['site_name']} pour recevoir toutes les permissions nécessaires",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Avertissement: le code PHP de votre page sera évalué si vous utilisez cette fonction. Utilisez avec précaution !!',
    'exit_msg' => 'Type de sortie: ',
    'exit_info' => 'Activez pour obtenir le message d\'accès requis. Gardez non-sélectionné pour actionner les vérifications et les messages de sécurité normaux.',
    'deny_msg' => 'L\'accès à cette page n\'est pas possible. Soit la page à été déplacée, soit vous n\'avez pas les permissions nécessaires pour y accéder.',
    'stats_headline' => 'Top-10 des pages statiques les plus fréquentées',
    'stats_page_title' => 'Titre des pages',
    'stats_hits' => 'Clics',
    'stats_no_hits' => 'Il serait possible qu\'il n\'y ait aucune page statique sur ce site, ou alors personne ne les a encore consultées.',
    'id' => 'Identification',
    'duplicate_id' => 'L\'identification choisie pour cette page est déjà utilisée par une autre page. Veuillez en choisir une autre.',
    'instructions' => 'Pour modifier une page statique, cliquez sur son numéro ci-dessous. Pour voir une page statique, cliquez sur le titre de la page. Pour créer une page statique, cliquez sur Ajouter. Cliquez sur [C] pour créer une copie de page existante.',
    'centerblock' => 'Block central: ',
    'centerblock_msg' => 'Si vous sélectionnez cette option, cette page sera affichée comme un block central.',
    'topic' => 'Catégorie: ',
    'position' => 'Position: ',
    'all_topics' => 'Toutes',
    'no_topic' => 'Page d\'accueil seulement',
    'position_top' => 'Haut de la page',
    'position_feat' => 'Après l\'article vedette',
    'position_bottom' => 'Bas de la page',
    'position_entire' => 'Toute la page',
    'head_centerblock' => 'Bloc du centre',
    'centerblock_no' => 'Non',
    'centerblock_top' => 'Haut',
    'centerblock_feat' => 'Article principal',
    'centerblock_bottom' => 'Bas',
    'centerblock_entire' => 'Bloc entier',
    'inblock_msg' => 'Dans un block: ',
    'inblock_info' => 'Si vous sélectionnez cette option, votre page sera présentée dans un block avec le titre de la page comme nom du block. Sinon, elle sera présentée normalement.',
    'title_edit' => 'Edit page',
    'title_copy' => 'Make a copy of this page',
    'title_display' => 'Display page',
    'select_php_none' => 'do not execute PHP',
    'select_php_return' => 'execute PHP (return)',
    'select_php_free' => 'execute PHP',
    'php_not_activated' => "The use of PHP in static pages is not activated. Please see the <a href=\"{$_CONF['site_url']}/docs/staticpages.html#php\">documentation</a> for details.",
    'printable_format' => 'Printable Format',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit',
    'no_new_pages' => 'Pas de nouvelle page',
    'pages' => 'Pages',
    'comments' => 'Commentaires',
    'template' => 'Template',
    'use_template' => 'Use Template',
    'template_msg' => 'When checked, this Static Page will be marked as a template.',
    'none' => 'None',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => 'Brouillon',
    'draft_yes' => 'Oui',
    'draft_no' => 'Non',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.'
);

$PLG_staticpages_MESSAGE15 = 'Votre commentaire à bien été soumis et sera publié après avoir été approuvé par un modérateur.';
$PLG_staticpages_MESSAGE19 = 'La page à bien été sauvegardée.';
$PLG_staticpages_MESSAGE20 = 'La page à bien été effacée.';
$PLG_staticpages_MESSAGE21 = 'Cette page n\'existe pas encore. Pour créer la page, merci de comléter le formulaire ci-dessous. Si vous êtes là par erreur, cliquer sur le bouton Annuler.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Pages statiques',
    'title' => 'Pages statiques - Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Permettre le PHP',
    'sort_by' => 'Trier les blocks du centre par',
    'sort_menu_by' => 'Trier les entrées de la navigation par',
    'sort_list_by' => 'Trier la liste Admin par',
    'delete_pages' => 'Supprimer la page avec le propriétaire',
    'in_block' => 'Emballer les pages dans un block',
    'show_hits' => 'Montrer le nombre de Hits?',
    'show_date' => 'Montrer la date de modification',
    'filter_html' => 'Filtrer le HTML',
    'censor' => 'Censurer le contenu',
    'default_permissions' => 'Permissions par défaut',
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'Après la sauvegarde de la page',
    'atom_max_items' => 'Max. de pages dans le flux des Webservices',
    'meta_tags' => 'Activer les Meta Tags',
    'comment_code' => 'Commentaires par défaut',
    'draft_flag' => 'Drapeux brouillon par défaut',
    'newstaticpagesinterval' => 'Interval des nouvelles pages statiques',
    'hidenewstaticpages' => 'Cacher les nouvelles pages statiques',
    'title_trim_length' => 'Couper la longueur des titres',
    'includecenterblocks' => 'Inclure les pages statiques block central',
    'includephp' => 'Inclure les pages statiques avec du PHP',
    'includesearch' => 'Activer les pages statiques dans la recherche',
    'includesearchcenterblocks' => 'Inclure les pages statiques block central dans la recherche',
    'includesearchphp' => 'Inclure les pages statiques avec du PHP dans la recherche'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Paramètres principaux'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Static Pages Main Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_search' => 'Search Results',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Pages statiques paramètres principaux',
    'fs_whatsnew' => 'Block Quoi de neuf',
    'fs_search' => 'Résultats de la recherche',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('Oui' => 1, 'Non' => 0),
    1 => array('Oui' => true, 'Non' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Titre' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Titre' => 'title', 'Label' => 'label'),
    4 => array('Date' => 'date', 'Page ID' => 'id', 'Titre' => 'title', 'Auteur' => 'author'),
    5 => array('Cacher' => 'hide', 'Montrer - Utiliser la date de modification' => 'modified', 'Montrer - Utiliser la date de création' => 'created'),
    9 => array('Aller à la page' => 'item', 'Afficher la liste des pages' => 'list', 'Page d\'accueil' => 'home', 'Panneau d\'administration' => 'admin'),
    12 => array('Pas d\'acces' => 0, 'Lecture seule' => 2, 'Lecture-Ecriture' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Commentaires activés' => 0, 'Commentaires désactivés' => -1)
);

?>
