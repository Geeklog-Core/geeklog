<?php

###############################################################################
# lang.php
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


$LANG_STATIC= array(
    newpage => "Nová stránka",
    adminhome => "Administrace",
    staticpages => "Statické stránky",
    staticpageeditor => "Editor statických stránek",
    writtenby => "Vlo¾eno",
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
    noblocks => "Bez blokù",
    leftblocks => "Bloky nalevo",
    addtomenu => 'Pøidat do menu',
    label => 'Název polo¾ky',
    nopages => '®ádné stránky zde nejsou',
    save => 'ulo¾it',
    preview => 'preview',
    delete => 'smazat',
    cancel => 'zru¹it akci',
    access_denied => 'Pøístup odepøen',
    access_denied_msg => 'Pokou¹íte se editovat statické stránky - na to nemáte dostateèná práva.  Tento pokus byl zaznamenán.',
    all_html_allowed => 'HTML tagy povoleny',
    results => 'Statické stránky - ',
    author => 'Autor',
    no_title_or_content => 'Musíte vyplnit alespoò pole <b>Titulek</b> a <b>Obsah</b>.',
    no_such_page_logged_in => 'Sorry '.$_USER['username'].'..',
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
    centerblock_entire => 'Entire Page'
);

?>
