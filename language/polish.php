<?php

###############################################################################
# polish.php
# This is the Polish language page for GeekLog!
# Special thanks to Robert Stadnik for his work on this project
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
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

$LANG_CHARSET = "iso-8859-2";

###############################################################################
# Array Format:
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
	1 => "Zamie�ci�:",
	2 => "wi�cej informacji",
	3 => "komentarzy",
	4 => "Edycja",
	5 => "G�osuj",
	6 => "Wyniki",
	7 => "Wyniki Sondy",
	8 => "g�os�w",
	9 => "Menu Admina:",
	10 => "Do Zamieszczenia",
	11 => "Artyku�y",
	12 => "Bloki",
	13 => "Sekcje",
	14 => "Linki",
	15 => "Wydarzenia",
	16 => "Sondy",
	17 => "U�ytkownicy",
	18 => "Zapytanie SQL",
	19 => "Wylogowanie",
	20 => "Informacje U�ytkownika:",
	21 => "Login",
	22 => "ID U�ytkownika",
	23 => "Poziom Zabezpiecze�",
	24 => "Gall Anonim",
	25 => "Odpowiedz",
	26 => "Komentarze nale�� do os�b, kt�re je zamie�ci�y. Nie bierzemy odpowiedzialno�ci za ich tre��.",
	27 => "Najnowsze Komentarze",
	28 => "Kasuj",
	29 => "Komentarzy Brak.",
	30 => "Starsze Artyku�y",
	31 => "Dozwolone Znaczniki HTML:",
	32 => "B��d, niew�a�ciwy login",
	33 => "B��d, nie mo�na zapisa� w logu",
	34 => "B��d",
	35 => "Wylogowanie",
	36 => "on",
	37 => "Brak artyku��w u�ytkownika",
	38 => "",
	39 => "Od�wie�",
	40 => "",
	41 => "Go��",
	42 => "Autor:",
	43 => "Odpowiedz",
	44 => "G��wny",
	45 => "Numer B��du MySQL",
	46 => "Numer Komunikatu B��du MySQL",
	47 => "Menu U�ytkownika",
	48 => "Konto - Info",
	49 => "Wygl�d - Preferencje",
	50 => "B��dna sk�adnia SQL",
	51 => "pomoc",
	52 => "Nowy",
	53 => "Admin Home",
	54 => "Nie mo�na otworzy� pliku.",
	55 => "B��d przy",
	56 => "G�osuj",
	57 => "Has�o",
	58 => "Login",
	59 => "Nie masz jeszcze konta? Za�� sobie <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Nowego U�ytkownika</a>",
	60 => "Skomentuj",
	61 => "Za�� Konto",
	62 => "s��w",
	63 => "Komentarze - Preferencje",
	64 => "Wy�lij Znajomemu",
	65 => "Wersja do Wydruku",
	66 => "M�j Kalendarz",
	67 => "Witaj w Serwisie ",
	68 => "strona g��wna",
	69 => "kontakt",
	70 => "szukaj",
	71 => "zamie��",
	72 => "linki",
	73 => "sonda",
	74 => "kalendarz",
	75 => "wyszukiwanie zaawansowane",
	76 => "statystyka strony",
	77 => "Pluginy",
	78 => "Wydarzenia",
	79 => "Co Nowego",
	80 => "artyku��w w ost.",
	81 => "artyku� w ost.",
	82 => "godz",
	83 => "KOMENTARZE",
	84 => "LINKI",
	85 => "wygasaj� po 48 h",
	86 => "Brak nowych komentarzy",
	87 => "wygasaj� po 2 tyg",
	88 => "Brak nowych link�w",
	89 => "�adnych wydarze� w najbli�szym czasie",
	90 => "Strona G��wna",
	91 => "Strona wygenerowana w ",
	92 => "sekund",
	93 => "Prawa Autorskie",
	94 => "Wszelkie znaki handlowe i prawa autorskie nale�� do ich w�a�cicieli.",
	95 => "Wersja",
	96 => "Grupy",
        97 => "Lista S��w",
	98 => "Pluginy",
	99 => "ARTYKU�Y",
    100 => "Brak nowych artyku��w",
    101 => 'Twoje Wydarzenia',
    102 => 'Wydarzenia na Serwisie',
    103 => 'Kopie zapasowe bazy',
    104 => 'przez',
    105 => 'U�ytkownicy Mailowi',
    106 => 'Ods�on',
    107 => 'Wersja GL - Test',
    108 => 'Opr�nij Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Kalendarz Wydarze�",
	2 => "Sorry, brak wydarze�.",
	3 => "Kiedy",
	4 => "Gdzie",
	5 => "Opis",
	6 => "Dodaj Wydarzenie",
	7 => "Zbli�aj�ce si� Wydarzenia",
	8 => 'Przez dodanie tego wydarzenie do swojego kalendarza mo�esz szybko przegl�da� interesuj�ce ci� wydarzenia klikaj�c "M�j Kalendarz" z poziomu Menu U�ytkownika.',
	9 => "Dodaj do Mojego Kalendarza",
	10 => "Usu� z Mojego Kalendarza",
	11 => "Dodawanie Wydarzenia do Kalendarza {$_USER['username']}",
	12 => "Wydarzenie",
	13 => "Rozpocz�cie",
	14 => "Zako�czenie",
	15 => "Powr�t do Kalendarza"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Zamie�� Komentarz",
	2 => "Format",
	3 => "Wylogowanie",
	4 => "Za�� Konto",
	5 => "Login",
	6 => "Aby zamie�ci� komentarz nale�y si� zalogowa�.  Je�li nie masz jeszcze konta, za�� sobie u�ywaj�c poni�szego formularza.",
	7 => "Ostatni komentarz zamie�ci�e� ",
	8 => " sekund temu.  Wymagana jest przerwa r�wna {$_CONF["commentspeedlimit"]} sekund pomi�dzy komentarzami",
	9 => "Komentarz",
	10 => '',
	11 => "Prze�lij Komentarz",
	12 => "Prosz� uzupe�ni� pola Tytu� i Komentarz. Pola te s� wymagane do zamieszczenia komentarza.",
	13 => "Twoje Informacje",
	14 => "Podgl�d",
	15 => "",
	16 => "Tytu�",
	17 => "B��d",
	18 => 'Wa�ne Informacje',
	19 => 'Prosz� stara� si� nie odbiega� od tematu.',
	20 => 'Prosz� raczej odpowiada� na zamieszczane komentarze innych u�ytkownik�w zamiast rozpoczynania nowych w�tk�w.',
	21 => 'Aby unikn�� powtarzania, zanim zamie�cisz sw�j komentarz przeczytaj co napisali inni.',
	22 => 'Wpisz temat adekwatny do tre�ci wiadomo�ci.',
	23 => 'Tw�j adres email nie b�dzie ujawniony.',
	24 => 'Gall Anonim'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Profil U�ytkownika",
	2 => "Login",
	3 => "Nazwa",
	4 => "Has�o",
	5 => "Email",
	6 => "Strona Domowa",
	7 => "O Sobie",
	8 => "Klucz PGP",
	9 => "Zapisz Informacje",
	10 => "Ostatnie 10 komentarzy u�ytkownika",
	11 => "Brak Komentarzy U�ytkownika",
	12 => "Preferencje U�ytkownika",
	13 => "Email Nightly Digest",
	14 => "Has�o jest generowane automatycznie. Zalecana jest szybka zmiana has�a. Aby zmieni� has�o, nale�y si� zalogowa� a nast�pnie klikn�� na Konto Info w Menu U�ytkownika.",
	15 => "Twoje {$_CONF["site_name"]} konto zosta�o za�o�one. Zaloguj si� wykorzystuj�c informacje poni�ej. Prosz� zachowa� tego maila w bezpiecznym miejscu.",
	16 => "Informacje Dotycz�ce Twojego Konta",
	17 => "Konto nie istnieje",
	18 => "Podany adres email nie jest prawid�owy",
	19 => "Podany login lub adres email ju� istnieje",
	20 => "Podany adres email nie jest prawid�owy",
	21 => "B��d",
	22 => "Zarejestruj si� w serwisie {$_CONF['site_name']}!",
	23 => "Konto w serwisie {$_CONF['site_name']} pozwoli ci zamieszcza� komentarze i inne pozycje w twoim imieniu. Brak konta umo�liwia tylko zamieszczanie jako anonim. Tw�j adres email <b><i>nigdy</i></b> nie b�dzie widoczny publicznie.",
	24 => "Twoje has�o zostanie wys�ane pod podany adres email.",
	25 => "Zapomnia�e�/a� has�o?",
	26 => "Wpisz sw�j login i kliknij Prze�lij Has�o a przes�ane zostanie nowe has�o.",
	27 => "Zarejestruj Si�!",
	28 => "Prze�lij Has�o",
	29 => "wylogowany z adresu",
	30 => "zalogowany z adresu",
	31 => "Wybrana funkcja wymaga wcze�niejszego zalogowania",
	32 => "Podpis",
	33 => "Niewidoczne dla publiki",
	34 => "Twoje prawdziwe imi�",
	35 => "Wpisz nowe has�o",
	36 => "Pocz�tek od http://",
	37 => "Zastosowane do twoich komentarzy",
	38 => "Wszystko o tobie! Ka�dy mo�e to przeczyta�",
	39 => "Tw�j publiczny klucz PGP dla wszystkich",
	40 => "Bez Ikon Sekcji",
	41 => "Ch�tny/a do Zatwierdzania Materia��w",
	42 => "Format Daty",
	43 => "Artyku�y Max Ilo��",
	44 => "Bez blok�w",
	45 => "Wygl�d - Preferencje U�ytkownika",
	46 => "Wy��czone Pozycje U�ytkownika",
	47 => "Konfiguracja Blok�w z Nowo�ciami U�ytkownika",
	48 => "Sekcje",
	49 => "Bez ikon w artyku�ach",
	50 => "Odznacz je�li nie jeste� zainteresowany",
	51 => "Tylko nowe artyku�y",
	52 => "Domy�lnie jest",
	53 => "Otrzymujesz nowe artyku�y co wiecz�r",
	54 => "Zaznacz sekcje i autor�w, kt�rych nie chcesz ogl�da�.",
	55 => "Je�li nic nie zaznaczysz oznacza to, �e akceptujesz domy�ln� konfiguracj�. Przy zaznaczaniu wybranych blok�w domy�lne ustawienie jest anulowane. Nazwy blok�w obj�tych domy�lnym ustawieniem s� pogrubione.",
	56 => "Autorzy",
	57 => "Wy�wietlanie",
	58 => "Sortowanie wg",
	59 => "Limit Komentarzy",
	60 => "Jak chcesz wy�wietla� swoje komentarze?",
	61 => "Od najnowszych czy od najstarszych?",
	62 => "Domy�lnie jest 100",
	63 => "Has�o zosta�o wys�ane i powinno wkr�tce do ciebie dotrze�. Post�puj zgodnie ze wskaz�wkami w wiadomo�ci. Dzi�kujemy za korzystanie z serwisu " . $_CONF["site_name"],
	64 => "Komentarze - Preferencje U�ytkownika",
	65 => "Spr�buj Zalogowa� si� Ponownie",
	66 => "By� mo�e login zosta� b��dnie wpisany.  Spr�buj zalogowa� si� ponownie. Czy jeste� <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nowym u�ytkownikiem</a>?",
	67 => "Cz�onkowstwo Od",
	68 => "Pami�taj Mnie Przez",
	69 => "Jak d�ugo pami�ta� ci� po zalogowaniu?",
	70 => "Dostosuj wygl�d i zawarto�� serwisu {$_CONF['site_name']}",
	71 => "Jedn� z extra mo�liwo�ci serwisu {$_CONF['site_name']} jest mo�liwo�� dopasowania zawarto�ci i wygl�du strony.  Aby skorzysta� z tych udogodnie� nale�y si� najpierw <a href=\"{$_CONF['site_url']}/users.php?mode=new\">zarejestrowa�</a> w serwisie {$_CONF['site_name']}.  Jeste� ju� cz�onkiem?  Zaloguj si�!",
        72 => "Motyw",
        73 => "J�zyk",
	74 => "Zmie� wygl�d strony!",
	75 => "Artyku�y Wysy�ane Mailem do",
	76 => "Je�eli zaznaczysz jak�� sekcj� z poni�szej listy b�dziesz, pod koniec ka�dego dnia, otrzymywa� nowe artyku�y zamieszczone w tej sekcji. Zaznacz sekcje, kt�re ci� interesuj�!",
	77 => "Zdj�cie",
	78 => "Dodaj swoje zdj�cie!",
	79 => "Zaznacz tutaj aby wykasowa� to zdj�cie",
	80 => "Logowanie",
        81 => "Wy�lij Maila",
	82 => '10 najnowszych artyku��w u�ytkownika',
	83 => 'Statystyka zamieszczonych materia��w u�ytkownika',
	84 => 'Wszystkich artyku��w:',
	85 => 'Wszystkich komentarzy:',
	86 => 'Znajd� wszystkie materia�y zamieszczone przez'
			
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Brak Nowo�ci",
	2 => "Brak nowych artyku��w.  By� mo�e nie ma nowych artyku��w w danej sekcji lub twoje ustawienia s� zbyt limituj�ce.",
	3 => "dla sekcji $topic",
	4 => "Dzisiejszy Artyku� Dnia",
	5 => "Nast�pny",
	6 => "Poprzedni"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Linki",
	2 => "Brak link�w.",
	3 => "Dodaj Link"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "G�os Zapisany",
	2 => "Zapisano Tw�j g�os oddany w sondzie ",
	3 => "G�osuj",
	4 => "Sondy w Systemie",
	5 => "G�os�w"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Wyst�pi� b��d podczas wysy�ania wiadomo�ci. Spr�buj ponownie.",
	2 => "Wiadomo�� wys�ano.",
	3 => "Prosz� si� upewni�, �e adres email wpisany w pole Odpowiedz Do jest prawid�owy.",
	4 => "Prosz� si� Przedstawi�, wpisa� Odpowiedz Do, Temat i Wiadomo��",
	5 => "B��d: Nie ma takiego u�ytkownika.",
	6 => "Wyst�pi� b��d.",
	7 => "Profil U�ytkownika",
	8 => "U�ytkownik",
	9 => "URL U�ytkownika",
	10 => "Wy�lij mail do",
	11 => "Przedstaw Si�:",
	12 => "Tw�j email:",
	13 => "Temat:",
	14 => "Wiadomo��:",
	15 => "Bez znacznik�w HTML.",
	16 => "Wy�lij",
	17 => "Wy�lij Znajomemu",
	18 => "Do (tw�j znajomy)",
	19 => "Jego/Jej Adres Email",
	20 => "Od (Przedstaw si�;-)",
	21 => "Tw�j Adres Email",
	22 => "Nale�y wype�ni� wszystkie pola",
	23 => "Tego maila wys�a� $from ($fromemail) z my�l�, �e mo�e ci� zainteresowa� poni�szy artyku� z serwisu {$_CONF["site_url"]}.  To nie jest SPAM a u�yte adresy email nie zosta�y nigdzie zapisane celem ich p�niejszego wykorzystania.",
	24 => "Skomentuj ten artyku� tutaj",
	25 => "Przed u�yciem tej opcji musisz si� zalogowa�.  Pozwoli nam to zabezpieczy� system przed niew�a�ciwym wykorzystaniem",
	26 => "Ten formularz umo�liwia wys�anie maila do wybranego u�ytkownika.  Wymagane jest wype�nienie wszystkich p�l.",
	27 => "Kr�tka Wiadomo��",
	28 => "$from napisa�: $shortmsg",
	29 => "Dzienne zestawienie artyku��w w Serwisie {$_CONF['site_name']} dla ",
	30 => "Codzienny Newsletter dla ",
	31 => "Tytu�",
	32 => "Data",
	33 => "Ca�y artyku� przeczytany ",
	34 => "Koniec Wiadomo�ci"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Wyszukiwanie Zaawansowane",
	2 => "S�owa Kluczowe",
	3 => "Sekcja",
	4 => "Wszystko",
	5 => "Gdzie",
	6 => "Artyku�y",
	7 => "Komentarze",
	8 => "Autorzy",
	9 => "Wszystko",
	10 => "Szukaj",
	11 => "Wyniki",
	12 => "trafienia",
	13 => "Wyniki: Brak danych",
	14 => "Nie znaleziono �adnych danych spe�niaj�cych twoje kryteria",
	15 => "Prosz� spr�bowa� ponownie.",
	16 => "Tytu�",
	17 => "Data",
	18 => "Autor",
	19 => "Przeszukuje ca�� baz� artyku��w i komentarzy {$_CONF["site_name"]} ",
	20 => "Data",
	21 => "do",
	22 => "(Format Daty RRRR-MM-DD)",
	23 => "Trafie�",
	24 => "Znaleziono",
	25 => "trafie� w�r�d",
	26 => "pozycji w ci�gu",
	27 => "sekund",
        28 => 'Brak artyku��w lub komentarzy kt�rych szukasz',
        29 => 'Artyku�y i Komentarze - Wyniki',
	30 => "Brak link�w spe�niaj�cych twoje kryteria wyszukiwania",
	31 => "Nie znaleziono �adnych plugin�w",
	32 => "Wydarzenie",
	33 => "URL",
	34 => "Lokalizacja",
	35 => "Ca�y Dzie�",
	36 => "Brak wydarze� spe�niaj�cych twoje kryteria wyszukiwania",
	37 => "Wydarzenia - Wyniki",
	38 => "Linki - Wyniki",
	39 => "Linki",
	40 => "Wydarzenia",
	41 => 'Twoje zapytanie powinno zawiera� co najmniej 3 znaki.',
	42 => 'Prosz� u�ywa� nast�puj�cego formatu daty: RRRR-MM-DD (rok-miesi�c-dzie�).'

);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Statystyka Serwisu",
	2 => "Wszystkich Wizyt w Serwisie",
	3 => "Artyku��w(Komentarzy) w Serwisie",
	4 => "Sondy(G�osy) w Serwisie",
	5 => "Linki(Klikni�cia) w Serwisie",
	6 => "Wydarzenia w Serwisie",
	7 => "10 Najpopularniejszych Artyku��w",
	8 => "Tytu� Artyku�u",
	9 => "Ods�on",
	10 => "Wygl�da na to, �e w tym serwisie nie ma �adnych artyku��w albo nikt nigdy �adnego nie przeczyta�.",
	11 => "10 Najcz�ciej Komentowanych Artyku��w",
	12 => "Komentarzy",
	13 => "Wygl�da na to, �e w tym serwisie nie ma �adnych artyku��w albo nikt nigdy nie skomentowa� �adnego.",
	14 => "10 Najpopularniejszych Sond",
	15 => "Pytanie Sondy",
	16 => "G�os�w",
	17 => "Wygl�da na to, �e w tym serwisie nie ma �adnych sond albo nikt nigdy nie odda� �adnego g�osu.",
	18 => "10 Najpopularniejszych Link�w",
	19 => "Linki",
	20 => "Wej��",
	21 => "Wygl�da na to, �e w tym serwisie nie ma �adnych link�w albo nikt nigdy nie klikn�� na �aden z nich.",
	22 => "10 Najcz�ciej Emaliowanych Artyku��w",
	23 => "Emaile",
	24 => "Wygl�da na to, �e nikt nie przes�a� swoim znajomym �adnego artyku�u"
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Odno�niki",
	2 => "Wy�lij Znajomemu",
	3 => "Wersja Do Wydruku",
	4 => "Opcje Artyku�u"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Aby przes�a� $type musisz si� wcze�niej zalogowa�.",
	2 => "Login",
	3 => "Nowy U�ytkownik",
	4 => "Prze�lij Wydarzenie",
	5 => "Prze�lij Linka",
	6 => "Prze�lij Artyku�",
	7 => "Wymagany jest Login",
	8 => "Prze�lij",
	9 => "Przy przesy�aniu informacji do tego serwisu, prosimy post�powa� wg poni�szych wskaz�wek...<ul><li>Nale�y wype�ni� wszystkie pola<li>Zamie�ci� pe�n� i poprawn� informacj�<li>Sprawdzi� dok�adnie podawane adresy</ul>",
	10 => "Tytu�",
	11 => "Link",
	12 => "Data Pocz�tkowa",
	13 => "Data Ko�cowa",
	14 => "Lokalizacja",
	15 => "Opis",
	16 => "Je�li Inne, podaj jaka",
	17 => "Kategoria",
	18 => "Inne",
	19 => "Przeczytaj Uwa�nie",
	20 => "B��d: Brak Kategorii",
	21 => "Wybieraj�c \"Inne\" wpisz nazw� kategorii",
	22 => "B��d: Puste Pola",
	23 => "Wymagane jest wype�nienie wszystkich p�l formularza.",
	24 => "Zapisano",
	25 => "Tw�j materia� $type zosta� zapisany.",
	26 => "Limit Czasowy",
	27 => "Login",
	28 => "Sekcja",
	29 => "Artyku�",
	30 => "Ostatni raz przesy�a�e� ",
	31 => " sekund temu.  Wymagane jest co najmniej {$_CONF["speedlimit"]} sekund przerwy pomi�dzy zamieszczeniami",
	32 => "Podgl�d",
	33 => "Podgl�d Artyku�u",
	34 => "Wylogowanie",
	35 => "Znaczniki HTML nie s� dozwolone",
	36 => "Format",
	37 => "Przes�ane wydarzenie do serwisu {$_CONF["site_name"]} zostanie umieszczone w Kalendarzu G��wnym, z kt�rego u�ytkownicy b�d� mieli mo�liwo�� dodawanie wydarze� do kalendarzy osobistych. Ta opcja <b>NIE S�U�Y</b> do przechowywania informacji osobistych takich jak urodziny itp.<br><br>Po przes�aniu wydarzenia, zostanie ono przes�ane do naszych administrator�w i po zatwierdzeniu pojawi si� w Kalendarzu G��wnym.",
        38 => "Dodaj Wydarzenie do",
        39 => "Kalendarz G��wny",
        40 => "Kalendarz Osobisty",
        41 => "Koniec",
        42 => "Pocz�tek",
        43 => "Ca�y Dzie�",
        44 => 'Adres 1',
        45 => 'Adres 2',
        46 => 'Miasto/Miejscowo��',
        47 => 'Wojew�dztwo',
        48 => 'Kod Pocztowy',
        49 => 'Kategoria Wydarzenia',
        50 => 'Edytuj Kategorie Wydarze�',
        51 => 'Lokalizacja',
        52 => 'Kasuj',
	53 => 'Za�� Konto'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Wymagana jest Autoryzacja",
	2 => "Odmowa! Niew�a�ciwy Login",
	3 => "Niew�a�ciwe has�o dla u�ytkownika",
	4 => "Login:",
	5 => "Has�o:",
	6 => "Wszelkie pr�by wej�cia do segment�w administracyjnych s� logowane i weryfikowane.<br>Dost�p tylko dla os�b upowa�nionych.",
	7 => "login"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Niewystarczaj�ce Uprawnienia Administracyjne",
	2 => "Nie masz wystarczaj�cych uprawnie� do edycji tego bloku.",
	3 => "Edytor Blok�w",
	4 => "",
	5 => "Tytu� Bloku",
	6 => "Sekcja",
	7 => "Wszystkie",
	8 => "Poziom Zabezpieczenia Bloku",
	9 => "Numer Bloku",
	10 => "Rodzaj Bloku",
	11 => "Blok Portalowy",
	12 => "Blok Normalny",
	13 => "Opcje Bloku Portalowego",
	14 => "URL pliku RDF",
	15 => "Ostatnie Uaktualnienie Pliku RDF",
	16 => "Opcje Bloku Normalnego",
	17 => "Zawarto�� Bloku",
	18 => "Prosz� wpisa� Tytu� Bloku, Poziom Zabezpieczenia i pola Zawarto�ci",
	19 => "Menad�er Blok�w",
	20 => "Tytu� Bloku",
	21 => "PozZab Bloku",
	22 => "Rodzaj Bloku",
	23 => "Numer Bloku",
	24 => "Sekcja Bloku",
	25 => "Aby zmodyfikowa� lub wykasowa� blok kliknij na blok poni�ej.  Aby stworzy� nowy blok kliknij Nowy Blok powy�ej.",
	26 => "Blok Schematowy",
	27 => "Blok PHP",
        28 => "Opcje Bloku PHP",
        29 => "Funkcje Bloku",
        30 => "Je�li chcesz aby tw�j blok obs�ugiwa� kod PHP, wpisz nazw� funkcji powy�ej.  Nazwa funkcji musi rozpoczyna� si� prefiksem \"phpblock_\" (np. phpblock_getweather).  Je�eli nie b�dzie prefiksu, twoja funkcja NIE zostanie wywo�ana.  Zwi�zane jest to z uniemo�liwieniem 'wrzucania' skrypt�w przez haker�w, kt�re mog� uszkodzi� tw�j system.  Upewnij si�, �e nie ma pustych nawias�w \"()\" po nazwie funkcji.  Na koniec, zalecamy umieszczenie ca�ego kodu PHP Block w /�cie�ka/do/geeklog/system/lib-custom.php.  Pozwoli to na zachowanie wersji kodu bez zmian nawet przy aktualizacji Geekloga.",
        31 => 'B��d w Bloku PHP.  Funkcja, $function, nie istnieje.',
        32 => "B��d. Puste pole(a)",
        33 => "Musisz wpisa� URL do pliku .rdf dla blok�w portalowych",
        34 => "Musisz wpisa� tytu� i funkcj� blok�w PHP",
        35 => "Musisz wpisa� tytu� i zawarto�� dla blok�w normalnych",
        36 => "Musisz wpisa� zawarto�� blok�w schematowych",
        37 => "Nieprawid�owa nazwa funkcji bloku PHP",
        38 => "Funkcje dla Blok�w PHP musz� mie� prefiks 'phpblock_' (np. phpblock_getweather).  Prefiks 'phpblock_' ze wzgl�d�w bezpiecze�stwa aby unikn�� wykonywanie kodu.",
	39 => "Strona",
	40 => "Lewa",
	41 => "Prawa",
	42 => "Musisz wpisa� porz�dek bloku i poziom zabezpiecze� dla domy�lnych blok�w Geekloga",
	43 => "Tylko Strona G��wna",
	44 => "Odmowa Dost�pu",
	45 => "Pr�bujesz wyedytowa� blok, do kt�rego nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu. Prosz� <a href=\"{$_CONF["site_admin_url"]}/block.php\">wr�ci� do ekranu administrowania blokami</a>.",
	46 => 'Nowy Blok',
	47 => 'Admin Home',
    48 => 'Nazwa Bloku',
    49 => ' (nazwa unikalna i bez spacji)',
    50 => 'URL Pliku Pomocy',
    51 => 'uwzgl�dnij http://',
    52 => 'Je�li zostawisz puste, ikona pomocy dla tego bloku si� nie pojawi',
    53 => 'Aktywne',
    54 => 'zapisz',
    55 => 'anuluj',
    56 => 'kasuj'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Edytor Wydarze�",
	2 => "",
	3 => "Tytu� Wydarzenia",
	4 => "URL Wydarzenia",
	5 => "Data Pocz�tkowa Wydarzenia",
	6 => "Data Ko�cowa Wydarzenia",
	7 => "Miejsce Wydarzenia",
	8 => "Opis Wydarzenia",
	9 => "(uwzgl�dnij http://)",
	10 => "Nale�y wype�ni� wszystkie pola w tym formularzu!",
	11 => "Menad�er Wydarze�",
	12 => "Aby zmodyfikowa� lub wykasowa� wydarzenie kliknij na dane wydarzenie poni�ej.  Aby wpisa� nowe wydarzenie kliknij na Nowe Wydarzenie powy�ej.",
	13 => "Tytu� Wydarzenia",
	14 => "Data Poczkowa",
	15 => "Data Ko�cowa",
	16 => "Odmowa Dost�pu",
	17 => "Pr�bujesz wyedytowa� wydarzenie, do kt�rego nie masz dost�pu.  Ta pr�ba zosta�a zapisana w logu. Prosz� <a href=\"{$_CONF["site_admin_url"]}/event.php\">wr�ci� do ekranu administrowania wydarzeniami</a>.",
	18 => 'Nowe Wydarzenie',
	19 => 'Admin Home',
	20 => 'zapisz',
	21 => 'anuluj',
	22 => 'kasuj'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Edytor Link�w",
	2 => "",
	3 => "Tytu� Linka",
	4 => "URL Linka",
	5 => "Kategoria",
	6 => "(uwzgl�dnij http://)",
	7 => "Inne",
	8 => "Link Wej�cia",
	9 => "Opis Linka",
	10 => "Wpisz Tytu�a linka, URL i Opis.",
	11 => "Menad�er Link�w",
	12 => "Aby zmodyfikowa� lub wykasowa� link, kliknij na dany link poni�ej.  Aby wpisa� nowy link kliknij Nowy Link powy�ej.",
	13 => "Tytu� Linka",
	14 => "Kategoria Linka",
	15 => "URL Linka",
	16 => "Odmowa Dost�pu",
	17 => "Pr�bujesz wyedytowa� link, do kt�rego nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu. Prosz� <a href=\"{$_CONF["site_admin_url"]}/link.php\">wr�ci� do ekranu administrowania linkami</a>.",
	18 => 'Nowy Link',
	19 => 'Admin Home',
	20 => 'Je�li inny, podaj jaki',
	21 => 'zapisz',
	22 => 'anuluj',
	23 => 'kasuj'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Poprzednie Artyku�y",
	2 => "Nast�pne Artyku�y",
	3 => "Tryb",
	4 => "Format",
	5 => "Edytor Artyku��w",
	6 => "Brak artyku��w w systemie",
	7 => "Autor",
	8 => "zapisz",
	9 => "podgl�d",
	10 => "anuluj",
	11 => "kasuj",
	12 => "",
	13 => "Tytu�",
	14 => "Sekcja",
	15 => "Data",
	16 => "Wst�p",
	17 => "Cz�� G��wna",
	18 => "Wej��",
	19 => "Komentarze",
	20 => "",
	21 => "",
	22 => "Lista Artyku��w",
	23 => "Aby zmodyfikowa� lub wykasowa� artyku�, kliknij na numer danego artyku�u poni�ej. Aby przegl�dn�� artyku� kliknij na tytu� danego artyku�u. Aby wpisa� nowy artyku� kliknij na Nowy Artyku� powy�ej.",
	24 => "",
	25 => "",
	26 => "Podgl�d Artyku�u",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Prosz� wpisa� Autora, Tytu� i Wst�p",
	32 => "Artyku� Dnia",
	33 => "Artyku� Dnia mo�e by� tylko jeden",
	34 => "Wersja Robocza",
	35 => "Tak",
	36 => "Nie",
	37 => "Wi�cej autorstwa",
	38 => "Wi�cej z sekcji",
	39 => "Emaile",
	40 => "Odmowa Dost�pu",
	41 => "Pr�bujesz wyedytowa� artyku� do kt�rego nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu.  Mo�esz podgl�dn�� artyku� poni�ej. Prosz� <a href=\"{$_CONF["site_admin_url"]}/story.php\">wr�ci� do strony administruj�cej artyku�ami.",
	42 => "Pr�bujesz wyedytowa� artyku� do kt�rego nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu.  Prosz� <a href=\"{$_CONF["site_admin_url"]}/story.php\">wr�ci� do strony administruj�cej artyku�ami</a>.",
	43 => 'Nowy Artyku�',
	44 => 'Centrum Admina',
	45 => 'Dost�p',
	46 => '<b>UWAGA:</b> je�li przesuniesz dat� do przodu, artyku� nie zostanie opublikowany wcze�niej. Oznacza to r�wnie�, �e artyku� nie b�dzie uwzgl�dniony w pliku RDF i zostanie pomini�ty przy wyszukiwaniu.',
	47 => 'Zdj�cia',
	48 => 'zdj�cie',
	49 => 'prawo',
	50 => 'lewo',
	51 => 'Aby doda� jedno ze zdj��, kt�re chcesz podpi�� do tego artyku�u musisz wstawi� specjalnie sformatowany tekst.  Tekst jest nast�puj�cy [zdj�cieX], [zdj�cieX_prawo] lub [zdj�cieX_lewo] gdzie X to numer obrazka, kt�ry za��czy�e�.  UWAGA: Musisz u�ywa� obrazk�w, kt�re za��czasz.  Inaczej nie b�dziesz w stanie zapisa� swojego artyku�u.<BR><P><B>PODGL�D</B>: Podgl�d artyku�u z za��czonymi obrazkami dzia�a najlepiej po uprzednim zapisaniu artyku�u jako kopia ZAMIAST u�ycia bezpo�rednio klawisza podgl�d.  U�ywaj klawisza podgl�d tylko gdy nie podpinasz obrazk�w.',
	52 => 'Kasuj',
	53 => 'nie zosta� u�yty.  Musisz umie�ci� ten obrazek we wst�pie lub w g��wnej cz�ci zanim zapiszsz zmiany',
	54 => 'Za��czonych Obraz�w Nie U�yto',
	55 => 'Pojawi�y si� nast�puj�ce b��dy podczas pr�by zapisu tego artyku�u.  Prosz� je poprawi� przed ponownym zapisem',
	56 => 'Poka� Ikon� Artyku�u'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Tryb",
	2 => "",
	3 => "Sonda Stworzona",
	4 => "Sonda $qid zapisana",
	5 => "Edycja Sondy",
	6 => "ID Sondy",
	7 => "(bez spacji)",
	8 => "Pojawia si� na Stronie G��wnej",
	9 => "Pytanie",
	10 => "Odpowiedzi / G�osy",
	11 => "Wyst�pi� b��d przy pobieraniu odpowiedzi sondy $qid",
	12 => "Wyst�pi� b��d przy pobieraniu pyta� sondy $qid",
	13 => "Stw�rz Sond�",
	14 => "zapisz",
	15 => "anuluj",
	16 => "kasuj",
	17 => "",
	18 => "Lista Sond",
	19 => "Aby zmodyfikowa� lub wykasowa� sond�, kliknij na dan� sond�.  Aby stworzy� now� sond� kliknij Nowa Sonda powy�ej.",
	20 => "G�osuj�cych",
	21 => "Odmowa Dost�pu",
	22 => "Pr�bujesz wyedytowa� sond� do kt�rej nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu. Prosz� <a href=\"{$_CONF["site_admin_url"]}/poll.php\">wr�ci� do strony administruj�cej sondami</a>.",
	23 => 'Nowa Sonda',
	24 => 'Admin Home',
	25 => 'Tak',
	26 => 'Nie'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Edytor Sekcji",
	2 => "ID Sekcji",
	3 => "Nazwa Sekcji",
	4 => "Ikona Sekcji",
	5 => "(bez spacji)",
	6 => "Wykasowanie sekcji wykasuje wszystkie artyku�y i bloki z ni� powi�zane",
	7 => "Prosz� wpisa� ID Sekcji i Nazw� Sekcji",
	8 => "Menad�er Sekcji",
	9 => "Aby zmodyfikowa� lub wykasowa� sekcj�, kliknij na dan� sekcj�.  Aby stworzy� now� sekcj� kliknij na Nowa Sekcja powy�ej. W nawiasie znajduje si� tw�j poziom dost�pu do ka�dej sekcji",
	10=> "Sortowanie",
	11 => "Artyku��w/Stron�",
	12 => "Odmowa Dost�pu",
	13 => "Pr�bujesz wyedytowa� sekcj� do kt�rej nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu. Prosz� <a href=\"{$_CONF["site_admin_url"]}/topic.php\">wr�ci� do ekranu administruj�cego sekcjami</a>.",
	14 => "Sortuj Wg",
	15 => "alfabetycznie",
	16 => "domy�lnie jest",
	17 => "Nowa Sekcja",
	18 => "Admin Home",
	19 => 'zapisz',
        20 => 'anuluj',
        21 => 'kasuj'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Edytor U�ytkownik�w",
	2 => "ID U�ytkownika",
	3 => "Login",
	4 => "Pe�na Nazwa",
	5 => "Has�o",
	6 => "Poziom Zabezpieczenia",
	7 => "Adres Email",
	8 => "Strona Domowa",
	9 => "(bez spacji)",
	10 => "Prosz� wpisa� Login, Pe�n� nazw�, Poziom Zabezpiecze� i Adres Email",
	11 => "Menad�er U�ytkownik�w",
	12 => "Aby zmodyfikowa� lub usun�� u�ytkownika, kliknij na odpowiedni login poni�ej.  Aby za�o�y� nowego u�ytkownika kliknij nowy u�ytkownik po lewej.",
	13 => "PozZab",
	14 => "Data Rej.",
	15 => 'Nowy U�ytkownik',
	16 => 'Admin Home',
	17 => 'zmie� has�o',
	18 => 'anuluj',
	19 => 'kasuj',
	20 => 'zapisz',
	18 => 'anuluj',
	19 => 'kasuj',
	20 => 'zapisz',
        21 => 'Login ju� istnieje.',
	22 => 'B��d',
	23 => 'Dodanie Grupowe',
        24 => 'Grupowy Import U�ytkownik�w',
        25 => 'Mo�na zaimportowa� grupowo u�ytkownik�w do Geekloga.  Plik tekstowy musi by� rozdzielany znakami tabulacji oraz musi mie� nast�puj�c� struktur�: imi� i nazwisko, login, adres email.  Ka�dy zaimportowany u�ytkownik dostanie mailem has�o.  W jednej linii mo�e wyst�powa� tylko jeden u�ytkownik.  Nie zastosowanie do tych instrukcji spowoduje problemy, kt�re mog� wymaga� r�cznej obr�bki dlatego sprawd� dwa razy zawarte informacje!',
        26 => 'Szukaj',
        27 => 'Zaw� Wyniki',
        28 => 'Zaznacz tutaj aby usun�� obrazek',
        29 => '�cie�ka',
        30 => 'Import',
        31 => 'Nowi U�ytkownicy',
        32 => 'Przetwarzanie zako�czone. Zaimportowano $successes i napotkano $failures b��d�w',
        33 => 'prze�lij',
        34 => 'B��d: Musisz poda� plik do za�adowania.'
);


###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Zatwierd�",
	2 => "Kasuj",
	3 => "Edytuj",
	4 => 'Profil',
	10 => "Tytu�",
	11 => "Data Pocz�tkowa",
	12 => "URL",
	13 => "Kategoria",
	14 => "Data",
	15 => "Sekcja",
	16 => 'Nazwa u�ytkownika', 
	17 => 'Pe�na nazwa u�ytkownika',
	18 => 'Email',
	34 => "Panel Sterowania",
	35 => "Przes�ane Materia�y",
	36 => "Przes�ane Linki",
	37 => "Przes�ane Wydarzenia",
	38 => "Prze�lij",
	39 => "�adnych materia��w do zatwierdzenia",
	40 => "Materia�y przes�ane przez u�ytkownika"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Niedziela",
	2 => "Poniedzia�ek",
	3 => "Wtorek",
	4 => "�roda",
	5 => "Czwartek",
	6 => "Pi�tek",
	7 => "Sobota",
	8 => "Dodaj Wydarzenie",
	9 => "Geeklog Event",
	10 => "Wydarzenia",
	11 => "G��wny Kalendarz",
	12 => "M�j Kalendarz",
	13 => "Stycze�",
	14 => "Luty",
	15 => "Marzec",
	16 => "Kwiecie�",
	17 => "Maj",
	18 => "Czerwiec",
	19 => "Lipiec",
	20 => "Sierpie�",
	21 => "Wrzesie�",
	22 => "Pa�dziernik",
	23 => "Listopad",
	24 => "Grudzie�",
	25 => "Powr�t do ",
    26 => "Ca�y Dzie�",
    27 => "Tydzie�",
    28 => "Kalendarz Osobisty",
    29 => "Kalendarz Og�lny",
    30 => "kasuj wydarzenia",
    31 => "Dodaj",
    32 => "Wydarzenie",
    33 => "Data",
    34 => "Czas",
    35 => "Szybkie Dodanie",
    36 => "Wy�lij",
    37 => "Sorry, funkcja kalendarz osobisty nie jest dost�pna",
    38 => "Edytor Osobisty",
    39 => 'Dzie�',
    40 => 'Tydzie�',
    41 => 'Miesi�c'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => "Mail",
 	2 => "Od",
 	3 => "Odpowiedz",
 	4 => "Temat",
 	5 => "Wiadomo��",
 	6 => "Wy�lij do:",
 	7 => "Wszyscy",
 	8 => "Admin",
	9 => "Opcje",
	10 => "HTML",
 	11 => "Pilne!",
 	12 => "Wy�lij",
 	13 => "Zresetuj",
 	14 => "Ignoruj ustawienia u�ytkownika",
 	15 => "B��d podczas wysy�ania do: ",
	16 => "Wiadomo�� wys�ana do: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Wy�lij nast�pn� wiadomo��</a>",
	18 => "Do",
        19 => "UWAGA: je�li chcesz wys�a� wiadomo�� do wszystkich u�ytkownik�w, wybierz Logged-in Users z listy rozwijanej.",
        20 => "Wys�anych <successcount> wiadomo�ci oraz <failcount> niewys�anych wiadomo�ci.  Poni�ej szczeg�y dotycz�ce pr�by wys�ania ka�dej wiadomo�ci.  Mo�esz r�wnie� <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">Wys�a� wiadomo��</a> lub mo�esz <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">wr�ci� do strony administracyjnej</a>.",
        21 => 'B��d',
        22 => 'Sukces',
        23 => 'Brak b��d�w',
        24 => 'Bez powodzenia',
        25 => '-- Wybierz Grup� --',
	26 => "Prosz� uzupe�ni� wszystkie pola i wybra� grup� z listy."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Has�o zosta�o wys�ane i powiniene� go wkr�tce otrzyma�. Post�puj zgodnie ze wskaz�wkami w wiadomo�ci. Dzi�kujemy za korzystanie z serwisu " . $_CONF["site_name"],
	2 => "Dzi�kujemy za przes�anie artyku�u do {$_CONF["site_name"]}.  Otrzymali go nasi pracownicy do zatwierdzenia. Po zatwierdzeniu tw�j artyku� b�dzie dost�pny dla innych u�ytkownik�w naszego serwisu.",
	3 => "Dzi�kujemy za przes�anie linka do {$_CONF["site_name"]}.  Otrzymali go nasi pracownicy do zatwierdzenia.  Po zatwierdzeniu tw�j link b�dzie widoczny w sekcji <a href={$_CONF["site_url"]}/links.php>linki</a>.",
	4 => "Dzi�kujemy za przes�anie wydarzenia do {$_CONF["site_name"]}.  Otrzymali go nasi pracownicy do zatwierdzenia.  Po zatwierdzeniu twoje wydarzenie b�dzie widoczne w sekcji <a href={$_CONF["site_url"]}/calendar.php>kalendarz</a>.",
	5 => "Informacje dotycz�ce twojego konta zosta�y zapisane.",
	6 => "Twoje preferencje dotycz�ce wygl�du zosta�y zapisane.",
	7 => "Twoje preferencje dotycz�ce komentarzy zosta�y zapisane.",
	8 => "Zosta�e�/a� pomy�lnie wylogowany/a.",
	9 => "Artyku� zosta� zapisany.",
	10 => "Artyku� zosta� wykasowany.",
	11 => "Blok zosta� zapisany.",
	12 => "Blok zosta� wykasowany.",
	13 => "Sekcja zosta�a zapisana.",
	14 => "Sekcja oraz wszystkie artyku�y i bloki z ni� zwi�zane zosta�y wykasowane.",
	15 => "Link zosta� zapisany.",
	16 => "Link zosta� wykasowany.",
	17 => "Wydarzenie zosta�o zapisane.",
	18 => "Wydarzenie zosta�o wykasowane.",
	19 => "G�osowanie zosta�o zapisane.",
	20 => "G�osowanie zosta�o wykasowane.",
	21 => "Nowy u�ytkownik zosta� zapisany.",
	22 => "Nowy u�ytkownik zosta� wykasowany.",
	23 => "Wyst�pi� b��d podczas pr�by dodania wydarzenia do twojego kalendarza. Nie przekazano ID wydarzenia.",
	24 => "Wydarzenie zosta�o zapisane w twoim kalendarzu",
	25 => "Kalendarz osobisty dost�pny jest dopiero po zalogowaniu",
	26 => "Wydarzenie zosta�o usuni�te z twojego kalendarza osobistego",
	27 => "Wiadomo�� wys�ano.",
	28 => "Plugin zosta� zapisany",
	29 => "Sorry, kalendarze osobiste s� niedost�pne w tym serwisie",
	30 => "Odmowa Dost�pu",
	31 => "Sorry, nie masz dost�pu do strony administruj�cej artyku�ami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	32 => "Sorry, nie masz dost�pu do strony administruj�cej sekcjami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	33 => "Sorry, nie masz dost�pu do strony administruj�cej blokami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	34 => "Sorry, nie masz dost�pu do strony administruj�cej linkami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	35 => "Sorry, nie masz dost�pu do strony administruj�cej wydarzeniami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	36 => "Sorry, nie masz dost�pu do strony administruj�cej sondami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	37 => "Sorry, nie masz dost�pu do strony administruj�cej u�ytkownikami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	38 => "Sorry, nie masz dost�pu do strony administruj�cej pluginami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	39 => "Sorry, nie masz dost�pu do strony administruj�cej mailem.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	40 => "Komunikat Systemowy",
        41 => "Sorry, nie masz dost�pu do strony edycyjnej zamiennik�w s��w.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
        42 => "S�owo zosta�o zapisane.",
	43 => "S�owo zosta�o wykasowane.",
        44 => 'Plugin zosta� zainstalowany!',
        45 => 'Plugin zosta� wykasowany.',
	46 => "Sorry, nie masz dost�pu do opcji archiwizowania bazy danych.  Pami�taj, �e Wszelkie nieautoryzowane pr�by wej�cia s� logowane",
	47 => "Ta opcja dzia�a tylko pod systemem *nix. Je�li masz w�a�nie taki system operacyjny to cache zosta� wyczyszczony. Pod Windoz�, musisz poszuka� plik�w adodb_*.php i usun�� je r�cznie.",
	48 => 'Dziekujemy za zainteresowanie cz�onkowstwem w ' .$_CONF['site_name'] . '. Zweryfikujemy twoje zg�oszenie i po zatwierdzeniu zostanie wys�ane has�o pod podany adres e-mail.',
	49 => "Twoja grupa zosta�a zapisana.",
        50 => "Grupa zosta�a wykasowana."
);

// for plugins.php

$LANG32 = array (
	1 => "Instalowanie plugin�w mo�e spowodowa� uszkodzenie twojej instalacji Geekloga jak r�wnie� systemu.  Wa�ne jest aby instalowa� pluginy �ci�gni�te z <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> poniewa� s� one szczeg�owo przez nas testowane na r�nych systemach operacyjnych.  Wa�ne aby� mia� �wiadomo��, �e instalacja pluginu wymaga wykonania kilku komend filesystemu, co wi��e si� z bezpiecze�stwem systemu, zw�aszcza gdy pluginy pochodz� od os�b trzecich.  Pomimo tego ostrze�enia, nie gwarantujemy sukcesu instalacyjnego ani nie mo�emy by� poci�gni�ci do odpowiedzialno�ci za jakiekolwiek szkody wynik�e z instalacji jakiegokolwiek pluginu.  Instalacja na w�asne ryzyko.  Instrukcje dotycz�ce r�cznej instalacji pluginu znajduj� si� w ka�dym pakiecie z pluginem.",
	2 => "Umowa Instalacyjna Plugin�w",
	3 => "Plugin Formularz Instalacyjny",
	4 => "Plugin Plik",
	5 => "Plugin Lista",
	6 => "Ostrze�enie: Plugin Ju� Zainstalowany!",
	7 => "Plugin, kt�ry pr�bujesz zainstalowa� ju� istnieje.  Prosz� wykasowa� istniej�cy plugin i zainstalowa� go ponownie",
	8 => "Sprawdzanie Kompatybilno�ci Pluginu Zako�czone Niepowodzeniem",
	9 => "Ten plugin wymaga nowszej wersji Geekloga. Albo uaktualnij swoj� kopi� <a href=http://www.geeklog.net>Geekloga</a> albo �ci�gnij nowsz� wersj� tego pluginu.",
	10 => "<br><b>Brak zainstalowanych plugin�w.</b><br><br>",
	11 => "Aby zmodyfikowa� lub wykasowa� plugin, kliknij na numer pluginu. Wi�cej informacji na temat pluginu: kliknij nazw� pluginu i zostaniesz przekierowany na stron� autora. Aby zainstalowa� lub uaktualni� plugin kliknij na nowy plugin.",
	12 => 'brak nazwy pluginu dla plugineditor()',
	13 => 'Plugin Edytor',
	14 => 'Nowy Plugin',
	15 => 'Admin Home',
	16 => 'Plugin Nazwa',
	17 => 'Plugin Wersja',
	18 => 'Geeklog Wersja',
	19 => 'Aktywny',
	20 => 'Tak',
	21 => 'Nie',
	22 => 'Instaluj',
        23 => 'Zapisz',
        24 => 'Anuluj',
        25 => 'Kasuj',
        26 => 'Plugin Nazwa',
        27 => 'Plugin Strona Domowa',
        28 => 'Plugin Wersja',
        29 => 'Geeklog Wersja',
        30 => 'Skasowa� Plugin?',
        31 => 'Czy aby na pewno skasowa� ten plugin?  Ta operacja usunie wszelkie pliki, dane i struktur� u�ywane przez ten plugin.  Je�li chcesz kontynuwa� kliknij kasuj poni�ej.'
);

$LANG_ACCESS = array(
	access => "Dost�p",
        ownerroot => "W�a�ciciel/Root",
	group => "Grupa",
	readonly => "Tylko-do-Odczytu",
	accessrights => "Prawa Dost�pu",
	owner => "W�a�ciciel",
	grantgrouplabel => "Udziel Praw do Edycji Powy�szej Grupie",
	permmsg => "UWAGA: cz�onkowie to wszyscy zalogowani u�ytkownicy na stronie a anonimowi to wszyscy u�ytkownicy przegl�daj�cy zawarto�� strony bez zalogowania.",
	securitygroups => "Grupy Zabezpiecze�",
	editrootmsg => "Pomimo tego, �e jeste� User Administrator, nie mo�esz edytowa� g��wnego u�ytkownka. Najpierw sam musisz zosta� u�ytkownikiem g��wnym.  Mo�esz edytowa� pozosta�ych u�ytkownik�w. Wszelkie nie autoryzowane pr�by edycji u�ytkownik�w g��wnych s� logowane.  Powr�t do strony Administracja U�ytkownikami serwisu <a href=\"{$_CONF["site_admin_url"]}/user.php\"></a>.",
	securitygroupsmsg => "Zaznacz grupy do kt�rych chcesz przypisa� u�ytkownika.",
	groupeditor => "Edytor Grup",
	description => "Opis",
	name => "Nazwa",
 	rights => "Uprawnienia",
	missingfields => "Brakuj�ce Pola",
	missingfieldsmsg => "Musisz poda� nazw� i opis grupy",
	groupmanager => "Menad�er Grup",
	newgroupmsg => "Aby zmodyfikowa� lub wykasowa� grup� kliknij na dan� grup� poni�ej. Aby stworzy� now� grup� kliknij nowa grupa powy�ej. Grupy g��wne nie mog� by� wykasowane s� u�ywane przez system.",
	groupname => "Nazwa Grupy",
	coregroup => "Grupa G��wna",
	yes => "Tak",
	no => "Nie",
	corerightsdescr => "Ta grupa jest G��wn� Grup� strony {$_CONF["site_name"]} .  Z tego wzgl�du prawa dla  tej grupy nie mog� by� edytowane.  Poni�ej znajduje si� lista do-odczytu praw tej grupy.",
	groupmsg => "Security Groups w tym serwisie s� hierarchiczne.  Poprzez dodanie tej grupy do jakiejkolwiek grupy poni�ej, tym samym nadasz tej grupie takie same prawa.  Je�eli to mo�liwe to zalecamy wykorzystanie poni�szych grup przy nadawaniu praw jakiejkolwiek grupie.  Je�li chcesz nada� tej grupie specjalne prawa, mo�esz wybra� uprawnienia do r�nych funkcji serwisu w poni�szej sekcji 'Uprawnienia'.  Aby doda� t� grup� do kt�rejkolwiek z poni�szej listy, zaznacz po prostu wybran� grup�(y).",
	coregroupmsg => "To jest Grupa g��wna serisu {$_CONF["site_name"]}.  Z tego wzgl�du grupy nale��ce do tej kategorii nie mog� by� edytowane.  Poni�ej znajduje si� lista, tylko do odczytu, grup z tej kategorii.",
	rightsdescr => "Dost�p grupowy to wybranych uprawnie� poni�ej mo�e by� nadany bezpo�rednio danej grupie LUB innej grupie, do kt�rej dana grupa nale�y.  Te z listy poni�ej bez pola wyboru oznaczaj� uprawnienia tej grupy wynikaj�ce z faktu przynale�no�ci do grupy z danym uprawnieniem.  Uprawnienia z polami wyboru mog� zosta� bezpo�rednio nadane danej grupie.",
	lock => "Blokada",
	members => "Cz�onkowie",
	anonymous => "Anonim",
	permissions => "Uprawnienia",
	permissionskey => "R = odczyt, E = edycja, prawa do edycji zak�adaj� prawa do odczytu",
	edit => "Edycja",
	none => "Brak",
	accessdenied => "Odmowa Dost�pu",
	storydenialmsg => "Brak dost�pu do tego artyku�u.  Prawdopodobnie nie jeste� cz�onkiem serwisu {$_CONF["site_name"]}.  Zapraszamy do <a href=users.php?mode=new> cz�onkostwa</a> w serwisie {$_CONF["site_name"]} aby otrzyma� pe�ny dost�p!",
	eventdenialmsg => "Brak dost�pu do tego wydarzenia.  Prawdopodobnie nie jeste� cz�onkiem serwisu {$_CONF["site_name"]}.  Zapraszamy do <a href=users.php?mode=new> cz�onkostwa</a> w serwisie {$_CONF["site_name"]} aby otrzyma� pe�ny dost�p!",
	nogroupsforcoregroup => "Grupa nie nale�y do pozosta�ych grup",
	grouphasnorights => "Grupa nie ma dost�pu do �adnych funkcji administracyjnych tego serwisu",
	newgroup => 'Nowa Grupa',
	adminhome => 'Admin Home',
	save => 'zapisz',
	cancel => 'anuluj',
	delete => 'kasuj',	
	canteditroot => 'Wyst�pi�a pr�ba edycji grupy G��wnej. Niestety nie nale�ysz do �adnej z grup G��wnych dlatego nie masz dost�pu do tej grupy.  Skontaktuj si� z administratorem systemu je�li uwa�asz, �e to pomy�ka'
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Ostatnie 10 Backup�w',
    do_backup => 'Wykonaj Backup',
    backup_successful => 'Backup bazy wykonany pomy�lnie.',
    no_backups => 'Brak backup�w w systemie',
    db_explanation => 'Aby wykona� nowy backup twojego systemu, kliknij poni�szy przycisk',
    not_found => "Niew�a�ciwa �cie�ka lub program archiwizuj�cy nie jest wykonywalny.<br>Sprawd� <strong>\$_DB_mysqldump_path</strong> ustawienia w config.php.<br>Zmienna jest obecnie ustawiona na: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Wykonanie Kopii Nie Powiod�o Si�: Rozmiar pliku 0 bajt�w',
    path_not_found => "{$_CONF['backup_path']} nie istnieje lub nie jest katalogiem",
    no_access => "B��D: Katalog {$_CONF['backup_path']} jest niedost�pny.",
    backup_file => 'Plik kopii',
    size => 'Rozmiar',
    bytes => 'Bajt�w'
);

$LANG_BUTTONS = array(
    1 => "G��wna",
    2 => "Kontakt",
    3 => "Napisz Artyku�",
    4 => "Linki",
    5 => "Sonda",
    6 => "Kalendarz",
    7 => "Statystyka",
    8 => "Osobiste",
    9 => "Szukaj",
    10 => "wyszukiwanie zaawansowane"
);

$LANG_404 = array(
    1 => "B��d 404",
    2 => "Kurcze, wsz�dzie szuka�em ale nie mog� znale�� <b>http://{$HTTP_SERVER_VARS["HTTP_HOST"]}{$HTTP_SERVER_VARS["REQUEST_URI"]}</b>.",
    3 => "<p>Przykro nam ale dany plik nie istnieje. Sprawd� <a href=\"{$_CONF['site_url']}/search.php\">stron� z wyszukiwark�</a> aby sprawdzi� czy mo�na znale�� co zgubi�e�."
);

$LANG_LOGIN = array (
    1 => 'Wymagany jest login',
    2 => 'Sorry, aby wej�� na te strony musisz by� zalogowany.',
    3 => 'Login',
    4 => 'Nowy U�ytkownik'
);

?>
