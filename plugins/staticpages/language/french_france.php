<?php

###############################################################################
# french_france.php
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
    'adminhome' => 'Entr�e - admin',
    'staticpages' => 'Pages statiques',
    'staticpageeditor' => '�diteur de pages statiques',
    'writtenby' => '�crit par',
    'date' => 'Derni�re mise � jour',
    'title' => 'Titre',
    'page_title' => 'Titre de la page',
    'content' => 'Contenu',
    'hits' => 'Clicks',
    'staticpagelist' => 'Liste des pages statiques',
    'url' => 'URL',
    'edit' => 'Edit',
    'lastupdated' => 'Derni�re mise � jour',
    'pageformat' => 'Format des pages',
    'leftrightblocks' => 'Blocs � gauche et � droite',
    'blankpage' => 'Nouvelle page vierge',
    'noblocks' => 'Pas de blocs',
    'leftblocks' => 'Blocs � gauche',
    'addtomenu' => 'Ajoutez au menu',
    'label' => 'Libell�',
    'nopages' => 'Il n\'y a pas de pages statiques enregistr�es dans le syst�me pr�sentement',
    'save' => 'sauvegarde',
    'preview' => 'aper�u',
    'delete' => 'effacer',
    'cancel' => 'annuler',
    'access_denied' => 'Acces refus�',
    'access_denied_msg' => 'Vous essayez d\'acc�der ill�galement � l\'une des pages administratives relatives aux pages statiques. Veuillez noter que toutes les tentatives ill�gales en ce sens seront enregistr�es',
    'all_html_allowed' => 'Toutes les balises HTML sont accept�es',
    'results' => 'R�sultats des pages statiques',
    'author' => 'Auteur',
    'no_title_or_content' => 'Vous devez au minimum inscrire quelque chose dans les champs <b>titre</b> et <b>contenu</b>.',
    'no_such_page_anon' => 'Pri�re de vous enregistrer',
    'no_page_access_msg' => "Ce pourrait �tre parce que vous ne vous �tes pas enregistr�, ou inscrit comme membre de {$_CONF['site_name']}. Veuillez <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> vous inscrire comme membre</a> de {$_CONF['site_name']} pour recevoir toutes les permissions n�cessaires",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Avertissement: le code PHP de votre page sera �valu� si vous utilisez cette fonction. Utilisez avec pr�caution !!',
    'exit_msg' => 'Type de sortie: ',
    'exit_info' => 'Activez pour obtenir le message d\'acc�s requis. Gardez non-s�lectionn� pour actionner les v�rifications et les messages de s�curit� normaux.',
    'deny_msg' => 'L\'acc�s � cette page n\'est pas possible. Soit la page � �t� d�plac�e, soit vous n\'avez pas les permissions n�cessaires pour y acc�der.',
    'stats_headline' => 'Top-10 des pages statiques les plus fr�quent�es',
    'stats_page_title' => 'Titre des pages',
    'stats_hits' => 'Clics',
    'stats_no_hits' => 'Il serait possible qu\'il n\'y ait aucune page statique sur ce site, ou alors personne ne les a encore consult�es.',
    'id' => 'Identification',
    'duplicate_id' => 'L\'identification choisie pour cette page est d�j� utilis�e par une autre page. Veuillez en choisir une autre.',
    'instructions' => 'Pour modifier une page statique, cliquez sur son num�ro ci-dessous. Pour voir une page statique, cliquez sur le titre de la page. Pour cr�er une page statique, cliquez sur Ajouter. Cliquez sur [C] pour cr�er une copie de page existante.',
    'centerblock' => 'Block central: ',
    'centerblock_msg' => 'Si vous s�lectionnez cette option, cette page sera affich�e comme un block central.',
    'topic' => 'Cat�gorie: ',
    'position' => 'Position: ',
    'all_topics' => 'Toutes',
    'no_topic' => 'Page d\'accueil seulement',
    'position_top' => 'Haut de la page',
    'position_feat' => 'Apr�s l\'article vedette',
    'position_bottom' => 'Bas de la page',
    'position_entire' => 'Toute la page',
    'head_centerblock' => 'Bloc du centre',
    'centerblock_no' => 'Non',
    'centerblock_top' => 'Haut',
    'centerblock_feat' => 'Article principal',
    'centerblock_bottom' => 'Bas',
    'centerblock_entire' => 'Bloc entier',
    'inblock_msg' => 'Dans un block: ',
    'inblock_info' => 'Si vous s�lectionnez cette option, votre page sera pr�sent�e dans un block avec le titre de la page comme nom du block. Sinon, elle sera pr�sent�e normalement.',
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
    'cache_time' => 'Cache Time',
    'cache_time_desc' => 'This staticpage content will be cached for no longer than this many seconds. If 0 caching is disabled (3600 = 1 hour,  86400 = 1 day). Staticpages with PHP enabled or are a template will not be cached.',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.'
);

$PLG_staticpages_MESSAGE15 = 'Votre commentaire � bien �t� soumis et sera publi� apr�s avoir �t� approuv� par un mod�rateur.';
$PLG_staticpages_MESSAGE19 = 'La page � bien �t� sauvegard�e.';
$PLG_staticpages_MESSAGE20 = 'La page � bien �t� effac�e.';
$PLG_staticpages_MESSAGE21 = 'Cette page n\'existe pas encore. Pour cr�er la page, merci de coml�ter le formulaire ci-dessous. Si vous �tes l� par erreur, cliquer sur le bouton Annuler.';

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
    'sort_menu_by' => 'Trier les entr�es de la navigation par',
    'sort_list_by' => 'Trier la liste Admin par',
    'delete_pages' => 'Supprimer la page avec le propri�taire',
    'in_block' => 'Emballer les pages dans un block',
    'show_hits' => 'Montrer le nombre de Hits?',
    'show_date' => 'Montrer la date de modification',
    'filter_html' => 'Filtrer le HTML',
    'censor' => 'Censurer le contenu',
    'default_permissions' => 'Permissions par d�faut',
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'Apr�s la sauvegarde de la page',
    'atom_max_items' => 'Max. de pages dans le flux des Webservices',
    'meta_tags' => 'Activer les Meta Tags',
    'comment_code' => 'Commentaires par d�faut',
    'draft_flag' => 'Drapeux brouillon par d�faut',
    'disable_breadcrumbs_staticpages' => 'Disable Breadcrumbs',
    'default_cache_time' => 'Default Cache Time',
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
    'sg_main' => 'Param�tres principaux'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Static Pages Main Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_search' => 'Search Results',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Pages statiques param�tres principaux',
    'fs_whatsnew' => 'Block Quoi de neuf',
    'fs_search' => 'R�sultats de la recherche',
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
    5 => array('Cacher' => 'hide', 'Montrer - Utiliser la date de modification' => 'modified', 'Montrer - Utiliser la date de cr�ation' => 'created'),
    9 => array('Aller � la page' => 'item', 'Afficher la liste des pages' => 'list', 'Page d\'accueil' => 'home', 'Panneau d\'administration' => 'admin'),
    12 => array('Pas d\'acces' => 0, 'Lecture seule' => 2, 'Lecture-Ecriture' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Commentaires activ�s' => 0, 'Commentaires d�sactiv�s' => -1)
);

?>
