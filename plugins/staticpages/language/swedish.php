<?php

###############################################################################
# lang.php
# This is the swedish language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
# Copyright (C) 2003 Markus Berg
# kelvin@lysator.liu.se
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
    newpage => 'Ny sida',
    adminhome => 'Administratörsmeny',
    staticpages => 'Statiska sidor',
    staticpageeditor => 'Redigera statisk sida',
    writtenby => 'Skriven av',
    date => 'Senast uppdaterad',
    title => 'Titel',
    content => 'Innehåll',
    hits => 'Träffar',
    staticpagelist => 'Lista över statiska sidor',
    url => 'URL',
    edit => 'Editera',
    lastupdated => 'Senast uppdaterad',
    pageformat => 'Sidformat',
    leftrightblocks => 'Vänster- och högerblock',
    blankpage => 'Tom sida',
    noblocks => 'Inga block',
    leftblocks => 'Vänsterblock',
    addtomenu => 'Lägg till i meny',
    label => 'Etikett',
    nopages => 'Inga statiska sidor än ännu inlagda i systemet',
    save => 'spara',
    preview => 'förhandsgranska',
    delete => 'radera',
    cancel => 'avbryt',
    access_denied => 'Åtkomst nekas',
    access_denied_msg => 'Du försöker få tillgång till en administrationssida för de statiska sidorna.  Detta äger du inte rätt att göra.  Alla dylika försök loggas.',
    all_html_allowed => 'All HTML tillåten',
    results => 'Statiska sidor resultat',
    author => 'Författare',
    no_title_or_content => 'Du måste åtminstone fylla i <b>titel-</b> och <b>innehålls</b>fälten.',
    no_such_page_logged_in => 'Sorry '.$_USER['username'].'..',
    no_such_page_anon => 'Du måste logga in..',
    no_page_access_msg => "Detta kan bero på att du inte är inloggad, eller att du inte ärmedlem i {$_CONF["site_name"]}.  <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Bli medlem</a> i {$_CONF["site_name"]} för att få åtkomst till medlemssidorna",
    php_msg => 'PHP: ',
    php_warn => 'Varning: PHP-kod i din sida kommer att exekveras om du aktiverar detta.  Använd med försiktighet !!',
    exit_msg => 'Avslutstyp: ',
    exit_info => 'Aktivera för "inloggning krävs"-meddelande.  Avaktivera för normal säkerhetskontroll och meddelande.',
    deny_msg => 'Åtkomst till denna sida nekas.  Antingen har sidan flyttats/raderats, eller så äger du inte rättigheter att se den.',
    stats_headline => 'Topp tio statiska sidor',
    stats_page_title => 'Titel',
    stats_hits => 'Träffar',
    stats_no_hits => 'Inga statiska sidor existerar på den här sajten, eller så har inga av dom lästs.',
    id => 'ID',
    duplicate_id => 'Det ID du valt för denna sida används redan.  Välj ett nytt ID.',
    instructions => 'Klicka på den statiska sidans nummer nedan för att modifiera eller radera den.  Klicka på sidans titel för att se sidan.  Klicka på ny sida ovan för att skapa en ny statisk sida.  Klicka på [C] för att kopiera en sida.',
    centerblock => 'Centerblock: ',
    centerblock_msg => 'När detta är aktiverat kommer denna statiska sida att visas i centerblocket på indexsidan.',
    topic => 'Ämne: ',
    position => 'Position: ',
    all_topics => 'Alla',
    no_topic => 'Endast hemsidan',
    position_top => 'Högst upp på sidan',
    position_feat => 'Efter huvudartikeln',
    position_bottom => 'Längst ner på sidan',
    position_entire => 'Hela sidan',
    head_centerblock => 'Centerblock',
    centerblock_no => 'Nej',
    centerblock_top => 'Högst upp',
    centerblock_feat => 'Huvudartikel',
    centerblock_bottom => 'Längst ner',
    centerblock_entire => 'Hela sidan'
);

?>
