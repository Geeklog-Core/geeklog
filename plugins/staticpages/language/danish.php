<?php

###############################################################################
# danish.php
# This is the danish language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Translation   Steen Brølling  
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
    newpage => "Ny Side",
    adminhome => "Admin Hjem",
    staticpages => "Faste Sider",
    staticpageeditor => "Faste Sider Redigering",
    writtenby => "Skrevet af",
    date => "Seneste Opdatering",
    title => "Titel",
    content => "Indhold",
    hits => "Hits",
    staticpagelist => "Faste Sider Liste",
    url => "URL",
    edit => "Rediger",
    lastupdated => "Sidst Opdateret",
    pageformat => "Side Format",
    leftrightblocks => "Venstre & Højre Kasser",
    blankpage => "Blank Side",
    noblocks => "Ingen Kasser",
    leftblocks => "Venstre Kasser",
    addtomenu => 'Tilføj til Menu',
    label => 'Titel',
    nopages => 'Der er ingen faste sider i systemet endnu',
    save => 'gem',
    preview => 'gennemse',
    delete => 'slet',
    cancel => 'fortryd',
    access_denied => 'Adgang Nægtet',
    access_denied_msg => 'Du forsøger at få adgang til Fast Side administrationssiderne. Dette forsøg er blevet logget',
    all_html_allowed => 'Alle HTML koder er tilladte',
    results => 'Fast Side Resultat',
    author => 'Forfatter',
    no_title_or_content => 'You must at least fill in the <b>Title</b> and <b>Content</b> fields.',
    no_such_page_logged_in => 'Desværre '.$_USER['username'].'..',
    no_such_page_anon => 'Log venligst ind..',
    no_page_access_msg => "Dette kan skyldes at du ikke er logget ind, eller ikke er oprettet som bruger af {$_CONF["site_name"]}. Bliv venligst <a href=\"{$_CONF['site_url']}/users.php?mode=new\">oprettet som bruger</a> af {$_CONF["site_name"]} for at få fuld brugeradgang",
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
