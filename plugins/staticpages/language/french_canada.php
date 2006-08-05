<?php

###############################################################################
# french_canada.php
# This is a french language page for the Geeklog Static Page Plug-in!
# Translation performed by Jean-Francois Allard - jfallard@jfallard.com
# Copyright (c) July 2003
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
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


$LANG_STATIC= array(
    newpage => 'Nouvelle page',
    adminhome => 'Entr�e - admin',
    staticpages => 'Pages statiques',
    staticpageeditor => '�diteur de pages statiques',
    writtenby => '�crit par',
    date => 'Derni�re mise � jour',
    title => 'Titre',
    content => 'Contenu',
    hits => 'Clicks',
    staticpagelist => 'Liste des pages statiques',
    url => 'URL',
    edit => '�dition',
    lastupdated => 'Derni�re mise � jour',
    pageformat => 'Format des pages',
    leftrightblocks => 'Blocs � gauche et � droite',
    blankpage => 'Nouvelle page vierge',
    noblocks => 'Pas de blocs',
    leftblocks => 'Blocs � gauche',
    addtomenu => 'Ajoutez au menu',
    label => 'Libell�',
    nopages => 'Il n\'y a pas de pages statiques enregistr�es dans le syst�me pr�sentement',
    save => 'sauvegarde',
    preview => 'aper�u',
    delete => 'effacer',
    cancel => 'annuler',
    access_denied => 'Acces refus�',
    access_denied_msg => 'Vous essayez d\'acc�der ill�galement � l\'une des pages administratives relatives aux pages statiques. Veuillez noter que toutes les tentatives ill�gales en ce sens seront enregistr�es',
    all_html_allowed => 'Toutes les balises HTML sont accept�es',
    results => 'R�sultats des pages statiques',
    author => 'Auteur',
    no_title_or_content => 'Vous devez au minimum inscrire quelque chose dans les champs <b>titre</b> et <b>contenu</b>.',
    no_such_page_anon => 'Pri�re de vous enregistrer',
    no_page_access_msg => "Ce pourrait �tre parce que vous ne vous �tes pas enregistr�, ou inscrit comme membre de {$_CONF["site_name"]}. Veuillez <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> vous inscrire comme membre</a> de {$_CONF["site_name"]} pour recevoir toutes les permissions n�cessaires",
    php_msg => 'PHP: ',
    php_warn => 'Avertissement: le code PHP de votre page sera �valu� si vous utilisez cette fonction. Utilisez avec pr�caution !!',
    exit_msg => 'Type de sortie: ',
    exit_info => 'Activez pour obtenir le message d\'acc�s requis. Gardez non-s�lectionn� pour actionner les v�rifications et les messages de s�curit� normaux.',
    deny_msg => 'L\'acc�s � cette page est impossible. Soit la page � �t� d�plac�e, soit vous n\'avez pas les permissions n�cessaires.',
    stats_headline => 'Top-10 des pages statiques les plus fr�quent�es',
    stats_page_title => 'Titre des pages',
    stats_hits => 'Clics',
    stats_no_hits => 'Il serait possible qu\'il n\'y ait aucune page statique sur ce site, ou alors personne ne les a encore consult�es.',
    id => 'Identification',
    duplicate_id => 'L\'identification choisie pour cette page est d�j� utilis�e par une autre page. Veuillez en choisir une autre.',
    instructions => 'Pour modifier une page statique, cliquez sur son num�ro ci-dessous. Pour voir une page statique, cliquez sur le titre de la page. Pour cr�er une page statique, cliquez sur Nouvelle page ci-dessous. Cliquez sur [C] pour cr�er une copie de page existante.',
    centerblock => 'Bloc du centre: ',
    centerblock_msg => 'Lorsque s�lectionn�e, cette page statique sera dispos�e comme le bloc central de la page d\'index.',
    topic => 'Sujet: ',
    position => 'Position: ',
    all_topics => 'Tout',
    no_topic => 'Page d\'accueil seulement',
    position_top => 'Haut de page',
    position_feat => 'Apr�s les articles',
    position_bottom => 'Bas de page',
    position_entire => 'Page enti�re',
    head_centerblock => 'Bloc du centre',
    centerblock_no => 'Non',
    centerblock_top => 'Haut',
    centerblock_feat => 'Article principal',
    centerblock_bottom => 'Bas',
    centerblock_entire => 'Bloc entier',
    'inblock_msg' => 'In a block: ',
    'inblock_info' => 'Wrap Static Page in a block.',
    'title_edit' => 'Edit page',
    'title_copy' => 'Make a copy of this page',
    'title_display' => 'Display page',
    'select_php_none' => 'do not execute PHP',
    'select_php_return' => 'execute PHP (return)',
    'select_php_free' => 'execute PHP',
    'php_not_activated' => 'The use of PHP in static pages is not activated. Please see the <a href="' . $_CONF['site_url'] . '/docs/staticpages.html#php">documentation</a> for details.',
    'printable_format' => 'Printable Format'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>
