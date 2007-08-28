<?php

###############################################################################
# dutch.php
# This is the Dutch language file for the Geeklog Links plugin
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
# $Id: dutch.php,v 1.3 2007/08/28 07:33:30 ospiess Exp $

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
 * @author Trinity Bays <trinity93@steubentech.com>
 * @author Tony Bibbs <tony@tonybibbs.com>
 * @author Tom Willett <twillett@users.sourceforge.net>
 * @author Blaine Lang <langmail@sympatico.ca>
 * @author Dirk Haun <dirk@haun-online.de>
 * 
 */


###############################################################################
# Array Format:
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
###############################################################################
/**
* the link plugin's lang array
* 
* @global array $LANG_LINKS 
*/
$LANG_LINKS= array(
    10 => 'Ingezonden links',
    14 => 'Links',
    84 => 'LINKS',
    88 => 'Geen recente nieuwe links',
    114 => 'Links',
    116 => 'Link toevoegen'
);

###############################################################################
# for stats
/**
* the link plugin's lang stats array
* 
* @global array $LANG_LINKS_STATS
*/
$LANG_LINKS_STATS = array(
    'links' => 'Links (Kliks) in het systeem',
    'stats_headline' => 'Top Tien Links',
    'stats_page_title' => 'Links',
    'stats_hits' => 'Hits',
    'stats_no_hits' => 'Er zijn nog geen links aanwezig of er is nog niet op geklikt.',
);

###############################################################################
# for the search
/**
* the link plugin's lang search array
* 
* @global array $LANG_LINKS_SEARCH 
*/
$LANG_LINKS_SEARCH = array(
 'results' => 'Link resultaten',
 'title' => 'Titel',
 'date' => 'Toegevoegd op',
 'author' => 'Ingezonden door',
 'hits' => 'Kliks'
);
###############################################################################
# for the submission form
/**
* the link plugin's lang submit form array
* 
* @global array $LANG_LINKS_SUBMIT 
*/
$LANG_LINKS_SUBMIT = array(
    1 => 'Link voorstellen',
    2 => 'Link',
    3 => 'Categorie',
    4 => 'Anders',
    5 => 'Indien anders, geef op',
    6 => 'Fout: categorie ontbreekt',
    7 => 'Wanneer "Anders" is geselecteerd geef dan naam van de nieuwe categorie op',
    8 => 'Titel',
    9 => 'URL',
    10 => 'Categorie',
    11 => 'Ingezonden links'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Hartelijk dank voor het voorstellen van uw link op {$_CONF['site_name']}.  De link is voorgesteld aan de beheerder ter goedkeuring. Indien accoord, wordt uw link opgenomen in de  <a href={$_CONF['site_url']}/links/index.php>links</a> directory.";
$PLG_links_MESSAGE2 = 'De link is opgeslagen.';
$PLG_links_MESSAGE3 = 'De link is verwijderd.';
$PLG_links_MESSAGE4 = "Hartelijk dank voor het toevoegen van uw link op {$_CONF['site_name']}.  De link is opgenomen in de <a href={$_CONF['site_url']}/links/index.php>links</a> directory.";

// Messages for the plugin upgrade
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
    3 => 'Link Titel',
    4 => 'Link URL',
    5 => 'Categorie',
    6 => '(inclusief http://)',
    7 => 'Anders',
    8 => 'Link Hits',
    9 => 'Link omschrijving',
    10 => 'U dient een link titel, URL en omschrijving op te geven.',
    11 => 'Link Manager',
    12 => 'Om een link te wijzigen of verwijderen, klik op het Edit icoontje naast de link.  Om een nieuwe link toe te voegen, klik op "Link toevoegen" hierboven.',
    14 => 'Link Categorie',
    16 => 'Toegang geweigerd',
    17 => "U probeert een link waar u geen toegang toe heeft te bewerken.  Deze poging is vastgelegd. Ga AUB terug naar de <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">linkmanager</a>.",
    20 => 'Indien anders, geef op',
    21 => 'opslaan',
    22 => 'annuleer',
    23 => 'verwijder'
);

?>
