<?php

###############################################################################
# czech.php
# This is the cz language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2002 hermes_trismegistos
# hermes_trismegistos@hermetik.net
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
#
# $LANG_CHARSET = "iso-8859-2";
#
###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

global $LANG32;

$LANG_STATIC= array(
    newpage => "Nová stránka",
    adminhome => "Administrace",
    staticpages => "Statické stránky",
    staticpageeditor => "Editor statických stránek",
    writtenby => "Vloženo",
    date => "Poslední aktualizace",
    title => "Titulek",
    content => "Obsah",
    hits => "Klicknutí",
    staticpagelist => "Výpis statických stránek",
    url => "URL",
    edit => "Editovat",
    lastupdated => "Poslední aktualizace",
    pageformat => "Formát stránky",
    leftrightblocks => "Bloky nalevo a napravo",
    blankpage => "Prázdná stránka",
    noblocks => "Bez bloků",
    leftblocks => "Bloky nalevo",
    addtomenu => 'Přidat do menu',
    label => 'Název položky',
    nopages => 'Žádné stránky zde nejsou',
    save => 'uložit',
    preview => 'preview',
    delete => 'smazat',
    cancel => 'zrušit akci',
    access_denied => 'Přístup odepřen',
    access_denied_msg => 'Pokoušíte se editovat statické stránky - na to nemáte dostatečná práva.  Tento pokus byl zaznamenán.',
    all_html_allowed => 'HTML tagy povoleny',
    results => 'Statické stránky - ',
    author => 'Autor',
    no_title_or_content => 'Musíte vyplnit alespoň pole <b>Titulek</b> a <b>Obsah</b>.',
    no_such_page_anon => 'Please log in..',
    no_page_access_msg => "This could be because you're not logged in, or not a member of {$_CONF["site_name"]}. Please <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> become a member</a> of {$_CONF["site_name"]} to receive full membership access",
    php_msg => 'PHP: ',
    php_warn => 'Warning: PHP code in your page will be evaluated if you enable this option. Use with caution !!',
    exit_msg => 'Exit Type: ',
    exit_info => 'Enable for Login Required Message.  Leave unchecked for normal security check and message.',
    deny_msg => 'Access to this page is denied.  Either the page has been moved/removed or you do not have sufficient permissions.',
    stats_headline => 'Top Ten Static Pages',
    stats_page_title => 'Page Title',
    stats_hits => 'Hits',
    stats_no_hits => 'It appears that there are no static pages on this site or no one has ever viewed them.',
    id => 'ID',
    duplicate_id => 'The ID you chose for this static page is already in use. Please select another ID.',
    instructions => "To modify or delete a static page, click on that page's number below. To view a static page, click on the title of the page you wish to view. To create a new static page click on new page above. Click on [C] to create a copy of an existing page.",
    centerblock => 'Centerblock: ',
    centerblock_msg => 'When checked, this Static Page will be displayed as a center block on the index page.',
    topic => 'Topic: ',
    position => 'Position: ',
    all_topics => 'All',
    no_topic => 'Homepage Only',
    position_top => 'Top Of Page',
    position_feat => 'After Featured Story',
    position_bottom => 'Bottom Of Page',
    position_entire => 'Entire Page',
    head_centerblock => 'Centerblock',
    centerblock_no => 'No',
    centerblock_top => 'Top',
    centerblock_feat => 'Feat. Story',
    centerblock_bottom => 'Bottom',
    centerblock_entire => 'Entire Page',
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
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>
