<?php

###############################################################################
# dutch.php
# This is the Dutch language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
#
# Ported to level 1.3.10 by: Ko de Pree <ko@depree.nl>
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
    'newpage' => 'Nieuwe Pagina',
    'adminhome' => 'Beheerder Home',
    'staticpages' => 'Static Pages',
    'staticpageeditor' => 'Static Page Editor',
    'writtenby' => 'Geschreven door',
    'date' => 'Laatst bijgewerkt',
    'title' => 'Titel',
    'page_title' => 'Page Title',
    'content' => 'Inhoud',
    'hits' => 'Treffers',
    'staticpagelist' => 'Static Page Lijst',
    'url' => 'URL',
    'edit' => 'Wijzigen',
    'lastupdated' => 'Laatst bijgewerkt',
    'pageformat' => 'Pagina formaat',
    'leftrightblocks' => 'Linker & Rechter Blokken',
    'blankpage' => 'Blanco Pagina',
    'noblocks' => 'Geen Blokken',
    'leftblocks' => 'Linker Blokken',
    'addtomenu' => 'Aan menu toevoegen',
    'label' => 'Label',
    'nopages' => 'Er zijn nog geen static pages.',
    'save' => 'opslaan',
    'preview' => 'preview',
    'delete' => 'verwijderen',
    'cancel' => 'annuleren',
    'access_denied' => 'Geen toegang',
    'access_denied_msg' => 'U heeft ongeautoriseerd geprobeerd een van de Static Pages op te roepen. Deze poging is vastgelegd.',
    'all_html_allowed' => 'HTML is toegestaan',
    'results' => 'Static Pages Resultaten',
    'author' => 'Auteur',
    'no_title_or_content' => 'Gelieve de <b>Titel</b> en <b>Content</b> op te geven.',
    'no_such_page_anon' => 'Gelieve eerst in te loggen...',
    'no_page_access_msg' => "Dit kan optreden omdat u niet ingelogd bent, of geen lid bent van {$_CONF['site_name']}. <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Meldt u aann</a> op {$_CONF['site_name']} om alle faciliteiten te verkrijgen",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Pas op !!  PHP code in uw pagina wordt uitgevoerd indien de optie geactiveerd is. Wees hiermee voorzichtig !!',
    'exit_msg' => 'Exit Type: ',
    'exit_info' => 'Activeer het Portaal bericht "Login Required". Niet aanvinken voor normale beveiligingsfunkties en berichtgevingen.',
    'deny_msg' => 'De toegang naar deze pagina is geweigerd. De pagina is verwijderd of verplaatst, of u bent hiervoor niet geautoriseerd.',
    'stats_headline' => 'Top Tien Static Pages',
    'stats_page_title' => 'Pagina Titel',
    'stats_hits' => 'Treffers',
    'stats_no_hits' => 'Het lijkt er op dat er geen static pages aanwezig zijn, of dat niemand ze ooit opgevraagd heeft.',
    'id' => 'ID',
    'duplicate_id' => 'De ID die u opgeeft voor deze static page is reeds in gebruik. Kies een andere ID.',
    'instructions' => 'Om een static page te wijzigen of te vewijderen, klik op het nummer van de betreffende pagina hieronder. Om een static page in te zien, klik op de titel van de betreffende pagina. Om een nieuwe static page aan te leggen klik op "Nieuwe Pagina" hierboven. Klik op [C] om een kopie te maken.',
    'centerblock' => 'Centerblok: ',
    'centerblock_msg' => 'Indien aangevinkt, wordt deze Static Page weergegeven in het midden van de index pagina.',
    'topic' => 'Thema: ',
    'position' => 'Positie: ',
    'all_topics' => 'All',
    'no_topic' => 'Alleen Homepage',
    'position_top' => 'Bovenaan',
    'position_feat' => 'Na HoofdArtikel',
    'position_bottom' => 'Onderaan',
    'position_entire' => 'Gehele Pagina',
    'head_centerblock' => 'Centerblok',
    'centerblock_no' => 'Nee',
    'centerblock_top' => 'Bovenaan',
    'centerblock_feat' => 'HoofdArtikel',
    'centerblock_bottom' => 'Onderaan',
    'centerblock_entire' => 'Gehele pagina',
    'inblock_msg' => 'In een blok: ',
    'inblock_info' => 'Geef de Static Page weer als een blok.',
    'title_edit' => 'Wijzig pagina',
    'title_copy' => 'Maak een copy van deze pagina',
    'title_display' => 'Laat de pagina zien',
    'select_php_none' => 'maak het uitvoeren van PHP onmogelijk',
    'select_php_return' => 'uitvoeren van PHP (return)',
    'select_php_free' => 'voer PHP uit',
    'php_not_activated' => "Het gebruik van PHP in Static Pages is niet geactiveerd. Bekijk de <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">documentatie</a> voor meer bijzonderheden.",
    'printable_format' => 'Printbare versie',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages',
    'comments' => 'Comments',
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Static Pages',
    'title' => 'Static Pages Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Allow PHP?',
    'sort_by' => 'Sort Centerblocks by',
    'sort_menu_by' => 'Sort Menu Entries by',
    'sort_list_by' => 'Sort Admin List by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'draft_flag' => 'Draft Flag Default',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    4 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Author' => 'author'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1)
);

?>
