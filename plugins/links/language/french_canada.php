<?php

###############################################################################
# french_canada.php
#
# This is the Canadian French language file for the Geeklog Links plugin
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
# $Id: french_canada.php,v 1.3 2008/04/13 11:59:08 dhaun Exp $

/** 
 * This is the english language page for the Geeklog links Plug-in! 
 * 
 * @package Links
 * @subpackage Language
 * @filesource
 * @version 1.0
 * @since GL 1.4.0
 * @copyright Copyright &copy; 2005
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License 
 * @author Trinity Bays <trinity93@gmail.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 * 
 */

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

/**
* the link plugin's lang array
* 
* @global array $LANG_LINKS 
*/
$LANG_LINKS = array(
    10 => 'Soumissions',
    14 => 'liens',
    84 => 'LIENS',
    88 => 'Pas de liens récents',
    114 => 'liens',
    116 => 'Ajoutez un lien'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => 'Liens en mémoire',
    'stats_headline' => 'Top-10 des liens',
    'stats_page_title' => 'Liens',
    'stats_hits' => 'Clics',
    'stats_no_hits' => 'Il appert qu\'il n\'existe aucun lien, ou que personne n\'a cliqué sur le lien.',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => 'Résultat des liens',
 'title' => 'Titre',
 'date' => 'Date d\'ajout',
 'author' => 'Soumis par',
 'hits' => 'Clics'
);
###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => 'Soumettez un lien',
    2 => 'Lien',
    3 => 'Catégorie',
    4 => 'Autre',
    5 => 'Spécifiez autre',
    6 => 'Erreur : catégorie manquante',
    7 => 'Lorsque vous sélectionnez "Autre", merci d\'aussi inscrire une catégorie correspondante',
    8 => 'Titre',
    9 => 'URL',
    10 => 'Catégorie',
    11 => 'Liens soumis'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Merci de soumettre un lien vers {$_CONF['site_name']}.  Votre demande est en cours d\'approbation. Lorsque qu\'approuvé, votre soumission sera affichée dans la <a href={$_CONF['site_url']}/links/index.php>section des liens</a>.";
$PLG_links_MESSAGE2 = 'Lien sauvegardé avec succès.';
$PLG_links_MESSAGE3 = 'Lien effacé avec succès.';
$PLG_links_MESSAGE4 = "Merci de soumettre un lien vers {$_CONF['site_name']}. Il apparaît désormais à la <a href={$_CONF['site_url']}/links/index.php>section des liens</a>.";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php
/**
* the link plugin's lang admin array
* 
* @global array $LANG_LINKS_ADMIN 
*/
$LANG_LINKS_ADMIN = array(
    1 => 'Link Editor',
    2 => 'Link ID',
    3 => 'Link Title',
    4 => 'Link URL',
    5 => 'Category',
    6 => '(include http://)',
    7 => 'Other',
    8 => 'Link Hits',
    9 => 'Link Description',
    10 => 'You need to provide a link Title, URL and Description.',
    11 => 'Link Manager',
    12 => 'To modify or delete a link, click on that link\'s edit icon below.  To create a new link, click on "Create New" above.',
    14 => 'Link Category',
    16 => 'Access Denied',
    17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">go back to the link administration screen</a>.",
    20 => 'If other, specify',
    21 => 'save',
    22 => 'cancel',
    23 => 'delete'
);

?>
