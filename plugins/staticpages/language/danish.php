<?php

###############################################################################
# danish.php
# This is the danish language page for the Geeklog Static Page Plug-in!
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
	usealtheader => "Brug Alt. Header",
	url => "URL",
	edit => "Rediger",
	lastupdated => "Sidst Opdateret",
	pageformat => "Side Format",
	leftrightblocks => "Venstre & H�jre Kasser",
	blankpage => "Blank Side",
	noblocks => "Ingen Kasser",
	leftblocks => "Venstre Kasser",
    addtomenu => 'Tilf�j til Menu',
    label => 'Titel',
    nopages => 'Der er ingen faste sider i systemet endnu',
    save => 'gem',
    preview => 'gennemse',
    delete => 'slet',
    cancel => 'fortryd',
    access_denied => 'Adgang N�gtet',
    access_denied_msg => 'Du fors�ger at f� adgang til Fast Side administrationssiderne. Dette fors�g er blevet logget',
    installation_complete => 'Installation Komplet',
    installation_complete_msg => 'Datastrukturen for Fast Side Plugin for GeekLog er med succes installeret i databasen! Hvis du f�r behov for at afinstallere denne plugin, l�s da venligst README filen som fulgte med denne plugin.',
    installation_failed => 'Installationen Mislykkedes',
    installation_failed_msg => 'Installationen af Fast Side Plugin mislykkedes. L�s venligst din GeekLog error.log fil for at diagnosticere problemet',
    system_locked => 'System L�st',
    system_locked_msg => 'Fst Side Plugin er allerede installeret, og er l�st. Hvis du vil afinstallere denne plugin, l�s da venligst README filen som fulgte med denne plugin',
    uninstall_complete => 'Afinstallation Komplet',
    uninstall_complete_msg => 'Datastrukturen for Fast Side Plugin er med succes fjernet fra din GeekLog database.',
    uninstall_failed => 'Afinstallationen Mislykkedes',
    uninstall_failed_msg => 'Afinstallationen af Fast Side Plugin mislykkedes. L�s venligst din GeekLog error.log fil for at diagnosticere problemet',
    all_html_allowed => 'Alle HTML koder er tilladte',
    results => 'Fast Side Resultat',
    author => 'Forfatter',
	no_such_page_logged_in => 'Desv�rre '.$_USER['username'].'..',
	no_such_page_anon => 'Log venligst ind..',
	no_page_access_msg => "Dette kan skyldes at du ikke er logget ind, eller ikke er oprettet som bruger af {$_CONF["site_name"]}. Bliv venligst <a href=\"{$_CONF['site_url']}/users.php?mode=new\">oprettet som bruger</a> af {$_CONF["site_name"]} for at f� fuld brugeradgang",
	upgrade_completed => 'Opgradering til version 1.2 skete med succes',
	upgrade_completed_msg => 'Din Fast Side Plugin er opgraderet. Nyd det!',
	upgrade_failed => 'Desv�rre, opgraderingen til version 1.2 mislykkedes',
	upgrade_failed_msg => 'Det er sket en fejl under fors�get p� at opgradere din Fast Side Plugin. L�s venligst din GeekLog error.log fil for at diagnosticere problemet',
	php_checkbox_checked => '<tr><td align="right"><b>PHP:</b></td><td><input type="checkbox" name="sp_php" value="1" checked> Er der PHP p� denne side? (brug ikke PHP medmindre det er n�dvendigt)</td></tr><tr><td colspan="2"><hr></td></tr>',
	php_checkbox_unchecked => '<tr><td align="right"><b>PHP:</b></td><td><input type="checkbox" name="sp_php" value="1"> PHP kode p� din side vil blive tolket korrekt. Brug kun med omtanke!</td></tr><tr><td colspan="2"><hr></td></tr>',
    pos_label => 'Pos: ',
    search_keywords_label => 'S�gen�gleord:',
    search_keywords_msg => 'NB: Hvis en side er standard HTML (ikke PHP), vil b�de \'Indhold\' & \'S�gen�gleord\' blive gennems�gt. Hvis en side er med PHP kode, vil kun \'S�gen�gleord\' blive gennems�gt.'
);

?>