<?php

###############################################################################
# lang.php
# This is the english language page for the Geeklog Static Page Plug-in!
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
    newpage => 'Nieuwe Pagina',
    adminhome => 'Beheerder Home',
    staticpages => 'Static Pages',
    staticpageeditor => 'Static Page Editor',
    writtenby => 'Geschreven door',
    date => 'Laatst bijgewerkt',
    title => 'Titel',
    content => 'Content',
    hits => 'Treffers',
    staticpagelist => 'Static Page Lijst',
    url => 'URL',
    edit => 'Wijzigen',
    lastupdated => 'Laatst bijgewerkt',
    pageformat => 'Pagina formaat',
    leftrightblocks => 'Linker & Rechter Blokken',
    blankpage => 'Blanco Pagina',
    noblocks => 'Geen Blokken',
    leftblocks => 'Linker Blokken',
    addtomenu => 'Aan menu toevoegen',
    label => 'Label',
    nopages => 'Er zijn nog geen static pages.',
    save => 'opslaan',
    preview => 'preview',
    delete => 'verwijderen',
    cancel => 'annuleren',
    access_denied => 'Geen toegang',
    access_denied_msg => 'U heeft ongeauthoriseerd geprobeerd een van de Static Pages op te roepen. Deze poging is vastgelegd.',
    all_html_allowed => 'HTML is toegestaan',
    results => 'Static Pages Resultaten',
    author => 'Auteur',
    no_title_or_content => 'Gelieve de <b>Titel</b> en <b>Content</b> op te geven.',
    no_such_page_logged_in => 'Helaas. '.$_USER['username'].'..',
    no_such_page_anon => 'Gelieve eerst in te loggen...',
    no_page_access_msg => "Dit kan optreden omdat u niet ingelogd bent, of geen lid bent van {$_CONF["site_name"]}. <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Meldt u aann</a> op {$_CONF["site_name"]} om alle facilteiten te verkrijgen",
    php_msg => 'PHP: ',
    php_warn => 'Pas op !!  PHP code in uw pagina wordt uitgevoerd indien de optie geactiveerd is. Wees hiermee voorzichtig !!',
    exit_msg => 'Exit Type: ',
    exit_info => 'Activeer het Portaal bericht "Login Required". Niet aanvinken voor normale beveiligingsfunkties en berichtgevingen.',
    deny_msg => 'De toegang naar deze pagina is geweigerd. De pagina is verwijderd of verplaatst, of u bent hiervoor niet geauthoriseerd.',
    stats_headline => 'Top Tien Static Pages',
    stats_page_title => 'Pagina Titel',
    stats_hits => 'Treffers',
    stats_no_hits => 'Het lijkt er op dat er geen static pages aanwezig zijn, of dat niemand ze ooit opgevraagd heeft.',
    id => 'ID',
    duplicate_id => 'De ID die u opgeeft voor deze static page is reeds in gebruik. Kies een andere ID.',
    instructions => 'Om een static page te wijzigen of te vewijderen, klik op het nummer van de betreffende pagina hieronder. Om een static page in te zien, klik op de titel van de betreffende pagina. Om een nieuwe static page aan te leggen klik op "Nieuwe Pagina" hierboven. Klik op [C] om een kopie te maken.',
    centerblock => 'Centerblok: ',
    centerblock_msg => 'Indien aangevinkt, wordt deze Static Page weergegeven in het midden van de index pagina.',
    topic => 'Thema: ',
    position => 'Positie: ',
    all_topics => 'All',
    no_topic => 'Alleen Homepage',
    position_top => 'Bovenaan',
    position_feat => 'Na HoofdArtikel',
    position_bottom => 'Onderaan',
    position_entire => 'Gehele Pagina',
    head_centerblock => 'Centerblok',
    centerblock_no => 'Nee',
    centerblock_top => 'Bovenaan',
    centerblock_feat => 'HoofdArtikel',
    centerblock_bottom => 'Onderaan',
    centerblock_entire => 'Gehele pagina'
);

?>
