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
	usealtheader => "U�yj Alt. Nag��wka",
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
    installation_complete => 'Instalacja Zako�czona',
    installation_complete_msg => 'Dane na potrzeby pluginu Static Pages zosta�y pomy�lnie zainstalowane w Twojej bazie!  Je�eli kiedykolwiek zaistnieje potrzeba odinstalowania tego pluginu, prosz� przeczyta� dokument README dostarczony razem z tym pluginem.',
    installation_failed => 'Instalacja Nie Powiod�a Si�',
    installation_failed_msg => 'Instalacja pluginu Static Pages nie powiod�a si�. Prosz� sprawdzi� w pliku erroor.log komunikat b��du',
    system_locked => 'System Zablokowany',
    system_locked_msg => 'Plugin Static Pages jest ju� zainstalowany i zablokowany.  Je�li pr�bujesz odinstalowa� plugin, prosz� przeczyta� dokument README',
    uninstall_complete => 'Odinstalowanie Zako�czone',
    uninstall_complete_msg => 'Dane na potrzeby pluginu Static Pages zosta�y pomy�lnie usuni�te z Twojej bazy.',
    uninstall_failed => 'Odinstalowanie Nie Powiod�o Si�',
    uninstall_failed_msg => 'Odinstalowanie pluginu Static Pages nie powiod�o si�. Prosz� sprawdzi� w pliku erroor.log komunikat b��du',
    all_html_allowed => 'Wszystkie Znaczniki HTML s� dozwolone',
    results => 'Wyniki Dla Stron Statycznych',
    author => 'Autor',
	no_such_page_logged_in => 'Sorry '.$_USER['username'].'..',
	no_such_page_anon => 'Prosze si� zalogowa�..',
	no_page_access_msg => "Mo�e to by� spowodowane tym, �e nie jeste� zalogowana/-y lub zarejestrowanan/-y w Serwisie {$_CONF["site_name"]}. Prosz� <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> zarejestrowa� si�</a> of {$_CONF["site_name"]} aby otrzyma� przywileje u�ytkownik�w zarejestrowanych",
	upgrade_completed => 'Aktualizacja do wersji 1.2 zako�czona pomy�lnie',
	upgrade_completed_msg => 'Tw�j plugin Static Pages zosta� uaktualniony. Niech ci dobrze s�u�y!',
	upgrade_failed => 'Sorry Aktualizacja do wersji 1.2 nie powiod�a si�',
	upgrade_failed_msg => 'Pojawi� si� b��d podczas aktualizacji pluginu Static Pages.  Prosz� sprawdzi� w pliku erroor.log komunikat b��du',
	php_checkbox_checked => '<tr><td align="right"><b>PHP:</b></td><td><input type="checkbox" name="sp_php" value="1" checked> Czy kod strony zawiera PHP ? (Nie u�ywaj chyba, �e musisz.)</td></tr><tr><td colspan="2"><hr></td></tr>',
	php_checkbox_unchecked => '<tr><td align="right"><b>PHP:</b></td><td><input type="checkbox" name="sp_php" value="1"> Kod PHP twojej strony zostanie sprawdzony. U�ywaj tej opcji ostro�nie !!</td></tr><tr><td colspan="2"><hr></td></tr>',
    pos_label => 'Poz: ',
    search_keywords_label => 'S�owa Kluczowe:',
    search_keywords_msg => 'UWAGA: Je�li strona to standardowy html (nie php), WSZYSTKIE pola \'Zawarto��\' & \'S�owa Kluczowe\' s� przeszukiwane. Je�li strona ma uaktywniony php, TYLKO pole \'S�owa Kluczowe\' jest przeszukiwane.'
);

?>
