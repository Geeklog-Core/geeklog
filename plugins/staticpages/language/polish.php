<?php

###############################################################################
# lang.php
# This is the polish language page for the Geeklog Static Page Plug-in!
# Translation by Robert Stadnik rstadnik@poczta.wp.pl
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
    newpage => "Nowa Strona",
    adminhome => "Centrum Admina",
    staticpages => "Strony Statyczne",
    staticpageeditor => "Edytor Stron Statycznych",
    writtenby => "Autor",
    date => "Ostatnia Aktualizacja",
    title => "Tytu�",
    content => "Zawarto��",
    hits => "Ods�on",
    staticpagelist => "Lista Stron Statycznych",
    url => "URL",
    edit => "Edycja",
    lastupdated => "Ostatnia Aktualizacja",
    pageformat => "Format Strony",
    leftrightblocks => "Lewe & Prawe Bloki",
    blankpage => "Nowe Okno",
    noblocks => "Bez Blok�w",
    leftblocks => "Lewe Bloki",
    addtomenu => 'Dodaj Do Menu',
    label => 'Etykieta',
    nopages => 'Brak stron statycznych w systemie',
    save => 'zapisz',
    preview => 'podgl�d',
    delete => 'kasuj',
    cancel => 'anuluj',
    access_denied => 'Odmowa Dost�pu',
    access_denied_msg => 'Pr�bujesz nielegalnie  dosta� si� do panelu administruj�cego Stronami Statycznymi.  Prosz� mie� na uwadze, �e wszelkie nieutoryzowane pr�by wej�cia s� logowane',
    all_html_allowed => 'Wszystkie Znaczniki HTML s� dozwolone',
    results => 'Wyniki Dla Stron Statycznych',
    author => 'Autor',
    no_title_or_content => 'You must at least fill in the <b>Title</b> and <b>Content</b> fields.',
    no_such_page_logged_in => 'Sorry '.$_USER['username'].'..',
    no_such_page_anon => 'Prosze si� zalogowa�..',
    no_page_access_msg => "Mo�e to by� spowodowane tym, �e nie jeste� zalogowana/-y lub zarejestrowanan/-y w Serwisie {$_CONF["site_name"]}. Prosz� <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> zarejestrowa� si�</a> of {$_CONF["site_name"]} aby otrzyma� przywileje u�ytkownik�w zarejestrowanych",
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
