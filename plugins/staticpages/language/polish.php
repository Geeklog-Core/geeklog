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
	title => "Tytu³",
	content => "Zawarto¶æ",
	hits => "Ods³on",
	staticpagelist => "Lista Stron Statycznych",
	usealtheader => "U¿yj Alt. Nag³ówka",
	url => "URL",
	edit => "Edycja",
	lastupdated => "Ostatnia Aktualizacja",
	pageformat => "Format Strony",
	leftrightblocks => "Lewe & Prawe Bloki",
	blankpage => "Nowe Okno",
	noblocks => "Bez Bloków",
	leftblocks => "Lewe Bloki",
    addtomenu => 'Dodaj Do Menu',
    label => 'Etykieta',
    nopages => 'Brak stron statycznych w systemie',
    save => 'zapisz',
    preview => 'podgl±d',
    delete => 'kasuj',
    cancel => 'anuluj',
    access_denied => 'Odmowa Dostêpu',
    access_denied_msg => 'Próbujesz nielegalnie  dostaæ siê do panelu administruj±cego Stronami Statycznymi.  Proszê mieæ na uwadze, ¿e wszelkie nieutoryzowane próby wej¶cia s± logowane',
    installation_complete => 'Instalacja Zakoñczona',
    installation_complete_msg => 'Dane na potrzeby pluginu Static Pages zosta³y pomy¶lnie zainstalowane w Twojej bazie!  Je¿eli kiedykolwiek zaistnieje potrzeba odinstalowania tego pluginu, proszê przeczytaæ dokument README dostarczony razem z tym pluginem.',
    installation_failed => 'Instalacja Nie Powiod³a Siê',
    installation_failed_msg => 'Instalacja pluginu Static Pages nie powiod³a siê. Proszê sprawdziæ w pliku erroor.log komunikat b³êdu',
    system_locked => 'System Zablokowany',
    system_locked_msg => 'Plugin Static Pages jest ju¿ zainstalowany i zablokowany.  Je¶li próbujesz odinstalowaæ plugin, proszê przeczytaæ dokument README',
    uninstall_complete => 'Odinstalowanie Zakoñczone',
    uninstall_complete_msg => 'Dane na potrzeby pluginu Static Pages zosta³y pomy¶lnie usuniête z Twojej bazy.',
    uninstall_failed => 'Odinstalowanie Nie Powiod³o Siê',
    uninstall_failed_msg => 'Odinstalowanie pluginu Static Pages nie powiod³o siê. Proszê sprawdziæ w pliku erroor.log komunikat b³êdu',
    all_html_allowed => 'Wszystkie Znaczniki HTML s± dozwolone',
    results => 'Wyniki Dla Stron Statycznych',
    author => 'Autor',
	no_such_page_logged_in => 'Sorry '.$_USER['username'].'..',
	no_such_page_anon => 'Prosze siê zalogowaæ..',
	no_page_access_msg => "Mo¿e to byæ spowodowane tym, ¿e nie jeste¶ zalogowana/-y lub zarejestrowanan/-y w Serwisie {$_CONF["site_name"]}. Proszê <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> zarejestrowaæ siê</a> of {$_CONF["site_name"]} aby otrzymaæ przywileje u¿ytkowników zarejestrowanych",
	upgrade_completed => 'Aktualizacja do wersji 1.2 zakoñczona pomy¶lnie',
	upgrade_completed_msg => 'Twój plugin Static Pages zosta³ uaktualniony. Niech ci dobrze s³u¿y!',
	upgrade_failed => 'Sorry Aktualizacja do wersji 1.2 nie powiod³a siê',
	upgrade_failed_msg => 'Pojawi³ siê b³±d podczas aktualizacji pluginu Static Pages.  Proszê sprawdziæ w pliku erroor.log komunikat b³êdu',
	php_checkbox_checked => '<tr><td align="right"><b>PHP:</b></td><td><input type="checkbox" name="sp_php" value="1" checked> Czy kod strony zawiera PHP ? (Nie u¿ywaj chyba, ¿e musisz.)</td></tr><tr><td colspan="2"><hr></td></tr>',
	php_checkbox_unchecked => '<tr><td align="right"><b>PHP:</b></td><td><input type="checkbox" name="sp_php" value="1"> Kod PHP twojej strony zostanie sprawdzony. U¿ywaj tej opcji ostro¿nie !!</td></tr><tr><td colspan="2"><hr></td></tr>',
    pos_label => 'Poz: ',
    search_keywords_label => 'S³owa Kluczowe:',
    search_keywords_msg => 'UWAGA: Je¶li strona to standardowy html (nie php), WSZYSTKIE pola \'Zawarto¶æ\' & \'S³owa Kluczowe\' s± przeszukiwane. Je¶li strona ma uaktywniony php, TYLKO pole \'S³owa Kluczowe\' jest przeszukiwane.'
);

?>
