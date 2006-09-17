<?php

###############################################################################
# polish.php
# This is the Polish language page for GeekLog!
# Special thanks to Robert Stadnik geeklog@geeklog.now.pl for his work on this project
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

$LANG_CHARSET = 'iso-8859-2';

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# lib-common.php

$LANG01 = array(
    1 => 'Autor:',
    2 => 'czytaj dalej',
    3 => 'komentarzy',
    4 => 'Edycja',
    5 => 'G�osuj',
    6 => 'Wyniki',
    7 => 'Wyniki Sondy',
    8 => 'g�os�w',
    9 => 'Menu Admina:',
    10 => 'Panel Sterowania',
    11 => 'Artyku�y',
    12 => 'Bloki',
    13 => 'Sekcje',
    14 => 'Linki',
    15 => 'Wydarzenia',
    16 => 'Sondy',
    17 => 'U�ytkownicy',
    18 => 'Zapytanie SQL',
    19 => 'Wyloguj',
    20 => 'Informacje U�ytkownika:',
    21 => 'Login',
    22 => 'ID U�ytkownika',
    23 => 'Poziom Zabezpiecze�',
    24 => 'Gall Anonim',
    25 => 'Komentuj',
    26 => 'Komentarze nale�� do os�b, kt�re je zamie�ci�y. Nie bierzemy odpowiedzialno�ci za ich tre��.',
    27 => 'Najnowsze Komentarze',
    28 => 'Kasuj',
    29 => 'Komentarzy Brak.',
    30 => 'Starsze Artyku�y',
    31 => 'Dozwolone Znaczniki HTML:',
    32 => 'B��d, niew�a�ciwy login',
    33 => 'B��d, nie mo�na zapisa� w logu',
    34 => 'B��d',
    35 => 'Wyloguj',
    36 => 'dnia',
    37 => 'Brak artyku��w u�ytkownika',
    38 => 'Syndykacja Tre�ci',
    39 => 'Od�wie�',
    40 => 'Masz <tt>register_globals = Off</tt> w pliku <tt>php.ini</tt>. Niestety, Geeklog wymaga <tt>register_globals</tt> aby by�y ustawione na <strong>on</strong>. Prosz� zminie� ustawienia na <strong>on</strong> i restartowa� serwer www.',
    41 => 'Go��',
    42 => 'Autor:',
    43 => 'Odpowiedz',
    44 => 'G��wny',
    45 => 'Numer B��du MySQL',
    46 => 'Numer Komunikatu B��du MySQL',
    47 => 'Menu U�ytkownika',
    48 => 'Konto - Info',
    49 => 'Osobiste',
    50 => 'B��dna sk�adnia SQL',
    51 => 'pomoc',
    52 => 'Nowy',
    53 => 'Panel Sterowania',
    54 => 'Nie mo�na otworzy� pliku.',
    55 => 'B��d przy',
    56 => 'G�osuj',
    57 => 'Has�o',
    58 => 'Login',
    59 => "Nie masz jeszcze konta? Za�� sobie <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Nowy U�ytkownik</a>",
    60 => 'Komentarze',
    61 => 'Za�� Konto',
    62 => 's��w',
    63 => 'Komentarze - Preferencje',
    64 => 'Wy�lij Znajomemu',
    65 => 'Wersja do Wydruku',
    66 => 'M�j Kalendarz',
    67 => 'Witaj w Serwisie ',
    68 => 'strona g��wna',
    69 => 'kontakt',
    70 => 'szukaj',
    71 => 'napisz',
    72 => 'linki',
    73 => 'sonda',
    74 => 'kalendarz',
    75 => 'zaawansowane szukanie',
    76 => 'statystyka',
    77 => 'Pluginy',
    78 => 'Wydarzenia',
    79 => 'Co Nowego',
    80 => 'artyku��w w ost.',
    81 => 'artyku� w ost.',
    82 => 'godz',
    83 => 'KOMENTARZE',
    84 => 'LINKI',
    85 => 'wygasaj� po 48 h',
    86 => 'Brak nowych komentarzy',
    87 => 'wygasaj� po 2 tyg',
    88 => 'Brak nowych link�w',
    89 => '�adnych wydarze� w najbli�szym czasie',
    90 => 'Strona G��wna',
    91 => 'Strona wygenerowana w ',
    92 => 'sekund',
    93 => 'Prawa Autorskie',
    94 => 'Wszelkie znaki handlowe i prawa autorskie nale�� do ich w�a�cicieli.',
    95 => 'Wersja',
    96 => 'Grupy',
    97 => 'Lista S��w',
    98 => 'Pluginy',
    99 => 'ARTYKU�Y',
    100 => 'Brak nowych artyku��w',
    101 => 'Twoje Wydarzenia',
    102 => 'Wydarzenia na Serwisie',
    103 => 'Kopie zapasowe bazy',
    104 => 'przez',
    105 => 'Wy�lij Maila',
    106 => 'Ods�on',
    107 => 'Wersja GL - Test',
    108 => 'Opr�nij Cache',
    109 => 'Zg�o� nadu�ycie',
    110 => 'Powiadom administratora o tym wpisie',
    111 => 'Wersja PDF',
    112 => 'Zarejestrowani U�ytkownicy',
    113 => 'Dokumentacja',
    114 => 'TRACKBACKS',
    115 => 'No new trackback comments',
    116 => 'Trackback',
    117 => 'Directory',
    118 => 'Please continue reading on the next page:',
    119 => "Lost your <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">password</a>?",
    120 => 'Permanent link to this comment',
    121 => 'Comments (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'All HTML is allowed',
    124 => 'Click to delete all checked items',
    125 => 'Are you sure you want to Delete all checked items?',
    126 => 'Select or de-select all items'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Napisz Komentarz',
    2 => 'Format',
    3 => 'Wyloguj',
    4 => 'Za�� Konto',
    5 => 'Login',
    6 => 'Aby zamie�ci� komentarz nale�y si� zalogowa�.  Je�li nie masz jeszcze konta, za�� sobie u�ywaj�c poni�szego formularza.',
    7 => 'Ostatni komentarz zamie�ci�e� ',
    8 => " sekund temu.  Wymagana jest przerwa r�wna {$_CONF['commentspeedlimit']} sekund pomi�dzy komentarzami",
    9 => 'Komentarz',
    10 => 'Wy�lij Raport',
    11 => 'Wy�lij Komentarz',
    12 => 'Prosz� uzupe�ni� pola Tytu� i Komentarz. Pola te s� wymagane do zamieszczenia komentarza.',
    13 => 'Twoje Informacje',
    14 => 'Podgl�d',
    15 => 'Zg�o� t� wiadomo��',
    16 => 'Tytu�',
    17 => 'B��d',
    18 => 'Wa�ne Informacje',
    19 => 'Prosz� stara� si� nie odbiega� od tematu.',
    20 => 'Prosz� raczej odpowiada� na zamieszczane komentarze innych u�ytkownik�w zamiast rozpoczynania nowych w�tk�w.',
    21 => 'Aby unikn�� powtarzania, zanim zamie�cisz sw�j komentarz przeczytaj co napisali inni.',
    22 => 'Wpisz temat adekwatny do tre�ci wiadomo�ci.',
    23 => 'Tw�j adres email nie b�dzie ujawniony.',
    24 => 'Gall Anonim',
    25 => 'Czy chcesz zg�osi� administratorowi ten komentarz?',
    26 => '%s zg�osi� nast�puj�cy komentarz:',
    27 => 'Raport nadu�y�'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Profil U�ytkownika',
    2 => 'Login',
    3 => 'Nazwa',
    4 => 'Has�o',
    5 => 'Email',
    6 => 'Strona Domowa',
    7 => 'O Sobie',
    8 => 'Klucz PGP',
    9 => 'Zapisz Informacje',
    10 => 'Ostatnie 10 komentarzy u�ytkownika',
    11 => 'Brak Komentarzy U�ytkownika',
    12 => 'Preferencje U�ytkownika',
    13 => 'Email Nightly Digest',
    14 => 'Has�o jest generowane automatycznie. Zalecana jest szybka zmiana has�a. Aby zmieni� has�o, nale�y si� zalogowa� a nast�pnie klikn�� na Konto Info w Menu U�ytkownika.',
    15 => "Twoje {$_CONF['site_name']} konto zosta�o za�o�one. Zaloguj si� wykorzystuj�c informacje poni�ej. Prosz� zachowa� tego maila w bezpiecznym miejscu.",
    16 => 'Informacje Dotycz�ce Twojego Konta',
    17 => 'Konto nie istnieje',
    18 => 'Podany adres email nie jest prawid�owy',
    19 => 'Podany login lub adres email ju� istnieje',
    20 => 'Podany adres email nie jest prawid�owy',
    21 => 'B��d',
    22 => "Zarejestruj si� w serwisie {$_CONF['site_name']}!",
    23 => "Konto w serwisie {$_CONF['site_name']} pozwoli ci zamieszcza� komentarze i inne pozycje w twoim imieniu. Brak konta umo�liwia tylko zamieszczanie jako anonim. Tw�j adres email <b><i>nigdy</i></b> nie b�dzie widoczny publicznie.",
    24 => 'Twoje has�o zostanie wys�ane pod podany adres email.',
    25 => 'Zapomnia�e�/a� has�o?',
    26 => 'Wpisz <em>albo</em> sw�j login <em>albo</em> adres email podany podczas rejestracji i kliknij Prze�lij Has�o. Instrukcje jak ustawi� nowe has�o zostan� wys�ane do Ciebie mailem.',
    27 => 'Zarejestruj Si�!',
    28 => 'Prze�lij Has�o',
    29 => 'wylogowany z adresu',
    30 => 'zalogowany z adresu',
    31 => 'Wybrana funkcja wymaga wcze�niejszego zalogowania',
    32 => 'Podpis',
    33 => 'Niewidoczne dla publiki',
    34 => 'Twoje prawdziwe imi�',
    35 => 'Wpisz nowe has�o',
    36 => 'Pocz�tek od http://',
    37 => 'Zastosowane do twoich komentarzy',
    38 => 'Wszystko o tobie! Ka�dy mo�e to przeczyta�',
    39 => 'Tw�j publiczny klucz PGP dla wszystkich',
    40 => 'Bez Ikon Sekcji',
    41 => 'Ch�tny/a do Zatwierdzania Materia��w',
    42 => 'Format Daty',
    43 => 'Artyku�y Max Ilo��',
    44 => 'Bez blok�w',
    45 => 'Wygl�d - Ustawienia U�ytkownika',
    46 => 'Wy��czone Pozycje U�ytkownika',
    47 => 'Konfiguracja Blok�w z Nowo�ciami U�ytkownika',
    48 => 'Sekcje',
    49 => 'Bez ikon w artyku�ach',
    50 => 'Odznacz je�li nie jeste� zainteresowany',
    51 => 'Tylko nowe artyku�y',
    52 => 'Domy�lnie jest',
    53 => 'Otrzymujesz nowe artyku�y co wiecz�r',
    54 => 'Zaznacz sekcje i autor�w, kt�rych nie chcesz ogl�da�.',
    55 => 'Je�li nic nie zaznaczysz oznacza to, �e akceptujesz domy�ln� konfiguracj�. Przy zaznaczaniu wybranych blok�w domy�lne ustawienie jest anulowane. Nazwy blok�w obj�tych domy�lnym ustawieniem s� pogrubione.',
    56 => 'Autorzy',
    57 => 'Wy�wietlanie',
    58 => 'Sortowanie wg',
    59 => 'Limit Komentarzy',
    60 => 'Jak chcesz wy�wietla� swoje komentarze?',
    61 => 'Od najnowszych czy od najstarszych?',
    62 => 'Domy�lnie jest 100',
    63 => "Has�o zosta�o wys�ane i powinno wkr�tce do ciebie dotrze�. Post�puj zgodnie ze wskaz�wkami w wiadomo�ci. Dzi�kujemy za korzystanie z serwisu {$_CONF['site_name']}",
    64 => 'Komentarze - Ustawienia U�ytkownika',
    65 => 'Spr�buj Zalogowa� si� Ponownie',
    66 => "By� mo�e login zosta� b��dnie wpisany.  Spr�buj zalogowa� si� ponownie. Czy jeste� <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nowym u�ytkownikiem</a>?",
    67 => 'Cz�onkowstwo Od',
    68 => 'Pami�taj Mnie Przez',
    69 => 'Jak d�ugo pami�ta� ci� po zalogowaniu?',
    70 => "Dostosuj wygl�d i zawarto�� serwisu {$_CONF['site_name']}",
    71 => "Jedn� z extra mo�liwo�ci serwisu {$_CONF['site_name']} jest mo�liwo�� dopasowania zawarto�ci i wygl�du strony.  Aby skorzysta� z tych udogodnie� nale�y si� najpierw <a href=\"{$_CONF['site_url']}/users.php?mode=new\">zarejestrowa�</a> w serwisie {$_CONF['site_name']}.  Jeste� ju� cz�onkiem?  Zaloguj si�!",
    72 => 'Pulpit',
    73 => 'J�zyk',
    74 => 'Zmie� wygl�d strony!',
    75 => 'Artyku�y Wysy�ane Mailem do',
    76 => 'Je�eli zaznaczysz jak�� sekcj� z poni�szej listy b�dziesz, pod koniec ka�dego dnia, otrzymywa� nowe artyku�y zamieszczone w tej sekcji. Zaznacz sekcje, kt�re ci� interesuj�!',
    77 => 'Zdj�cie',
    78 => 'Dodaj swoje zdj�cie!',
    79 => 'Zaznacz tutaj aby wykasowa� to zdj�cie',
    80 => 'Logowanie',
    81 => 'Wy�lij Maila',
    82 => '10 najnowszych artyku��w u�ytkownika',
    83 => 'Materia�y zamieszczone przez u�ytkownika',
    84 => 'Wszystkich artyku��w:',
    85 => 'Wszystkich komentarzy:',
    86 => 'Znajd� wszystkie materia�y zamieszczone przez',
    87 => 'Tw�j login',
    88 => "Kto� (prawdopodobnie Ty) chce uzyska� nowe has�o do tego konta \"%s\" w {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nJe�li chcesz kontynuowa� prosz� kliknij ten link:\n\n",
    89 => "Je�li nie chcesz kontynuowa�, zignoruj t� wiadomo�� (Twoje has�o pozostanie niezmienione).\n\n",
    90 => 'Poni�ej mo�esz wprowadzi� nowe has�o. Pami�taj, �e stare has�o jest aktywne do czasu przes�ania tego zg�oszenia.',
    91 => 'Ustaw Nowe Has�o',
    92 => 'Wpisz Nowe Has�o',
    93 => 'Twoja ostatnia pro�ba o zmian� has�a by�a wys�ana %d sekund temu. Wymagana jest przerwa co najmniej %d sekundowa pomi�dzy takimi zg�oszeniami.',
    94 => 'Kasuj Konto "%s"',
    95 => 'Kliknij poni�szy przycisk "kasuj konto" aby usun�� swoje konto z bazy danych. Prosz� mie� na uwadze, �e wszelkie artyku�y i komentarze, zamieszczone przez Ciebie <strong>nie</strong> zostan� usuni�te ale autor zmieni si� na "Gall Anonim".',
    96 => 'kasuj konto',
    97 => 'Potwierd� Usuni�cie Konta',
    98 => 'Czy aby napewno chcesz usun�� swoje konto? Po skasowaniu konta nie b�dzie mo�na si� ponownie zalogowa� na tej stronie (chyba, �e za�o�ysz nowe konto). Je�li tego chcesz kliknij ponownie "kasuj konto" w poni�szym formularzu.',
    99 => 'Ochrona Prywatno�ci dla',
    100 => 'Email od Admina',
    101 => 'TAK na emaile od Admina',
    102 => 'Email od U�ytkownik�w',
    103 => 'TAK na emaile od innych u�ytkownik�w',
    104 => 'Poka� Status Online',
    105 => 'Poka� w bloku Who\'s Online',
    106 => 'Lokalizacja',
    107 => 'Poka� w swoim publicznym profilu',
    108 => 'Confirm new password',
    109 => 'Enter the New password again here',
    110 => 'Current Password',
    111 => 'Please enter your Current password',
    112 => 'You have exceeded the number of allowed login attempts.  Please try again later.',
    113 => 'Login Attempt Failed',
    114 => 'Account Disabled',
    115 => 'Your account has been disabled, you may not login. Please contact an Administrator.',
    116 => 'Account Awaiting Activation',
    117 => 'Your account is currently awaiting activation by an administrator. You will not be able to login until your account has been approved.',
    118 => "Your {$_CONF['site_name']} account has now been activated by an administrator. You may now login to the site at the url below using your username (<username>) and password as previously emailed to you.",
    119 => 'If you have forgotten your password, you may request a new one at this url:',
    120 => 'Account Activated',
    121 => 'Service',
    122 => 'Sorry, new user registration is disabled',
    123 => "Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?",
    124 => 'Confirm Email',
    125 => 'You have to enter the same email address in both fields!',
    126 => 'Please repeat for confirmation',
    127 => 'To change any of these settings, you will have to enter your current password.',
    128 => 'Your Name',
    129 => 'Password &amp; Email',
    130 => 'About You',
    131 => 'Daily Digest Options',
    132 => 'Daily Digest Feature',
    133 => 'Comment Display',
    134 => 'Comment Options',
    135 => '<li>Default mode for how comments will be displayed</li><li>Default order to display comments</li><li>Set maximum number of comments to show - default is 100</li>',
    136 => 'Exclude Topics and Authors',
    137 => 'Filter Story Content',
    138 => 'Misc Settings',
    139 => 'Layout and Language',
    140 => '<li>No Topic Icons if checked will not display the story topic icons</li><li>No boxes if checked will only show the Admin Menu, User Menu and Topics<li>Set the maximum number of stories to show per page</li><li>Set your theme and perferred date format</li>',
    141 => 'Privacy Settings',
    142 => 'The default setting is to allow users & admins to email fellow site members and show your status as online. Un-check these options to protect your privacy.',
    143 => 'Filter Block Content',
    144 => 'Show & hide boxes',
    145 => 'Your Public Profile',
    146 => 'Password and email',
    147 => 'Edit your account password, email and autologin feature. You will need to enter the same password or email address twice as a confirmation.',
    148 => 'User Information',
    149 => 'Modify your user information that will be shown to other users.<li>The signature will be added to any comments or forum posts you made</li><li>The BIO is a brief summary of yourself to share</li><li>Share your PGP Key</li>',
    150 => 'Warning: Javascript recommended for enhanced functionality',
    151 => 'Preview',
    152 => 'Username & Password',
    153 => 'Layout & Language',
    154 => 'Content',
    155 => 'Privacy',
    156 => 'Delete Account'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Brak Nowo�ci',
    2 => 'Brak nowych artyku��w.  By� mo�e nie ma nowych artyku��w w danej sekcji lub twoje ustawienia s� zbyt limituj�ce.',
    3 => 'dla sekcji %s',
    4 => 'Dzisiejszy Artyku� Dnia',
    5 => 'Nast�pny',
    6 => 'Poprzedni',
    7 => 'Pierwszy',
    8 => 'Ostatni'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Wyst�pi� b��d podczas wysy�ania wiadomo�ci. Spr�buj ponownie.',
    2 => 'Wiadomo�� wys�ano.',
    3 => 'Prosz� si� upewni�, �e adres email wpisany w pole Odpowiedz Do jest prawid�owy.',
    4 => 'Prosz� si� Przedstawi�, wpisa� Odpowiedz Do, Temat i Wiadomo��',
    5 => 'B��d: Nie ma takiego u�ytkownika.',
    6 => 'Wyst�pi� b��d.',
    7 => 'Profil U�ytkownika',
    8 => 'U�ytkownik',
    9 => 'URL U�ytkownika',
    10 => 'Wy�lij maila do',
    11 => 'Przedstaw Si�:',
    12 => 'Tw�j email:',
    13 => 'Temat:',
    14 => 'Wiadomo��:',
    15 => 'Bez znacznik�w HTML.',
    16 => 'Wy�lij',
    17 => 'Wy�lij Znajomemu',
    18 => 'Do (tw�j znajomy)',
    19 => 'Jego/Jej Adres Email',
    20 => 'Od (Przedstaw si�;-)',
    21 => 'Tw�j Adres Email',
    22 => 'Nale�y wype�ni� wszystkie pola',
    23 => "Tego maila wys�a� %s (%s) z my�l�, �e mo�e ci� zainteresowa� poni�szy artyku� z serwisu {$_CONF['site_url']}.  To nie jest SPAM a u�yte adresy email nie zosta�y nigdzie zapisane celem ich p�niejszego wykorzystania.",
    24 => 'Skomentuj ten artyku� tutaj',
    25 => 'Przed u�yciem tej opcji musisz si� zalogowa�.  Pozwoli nam to zabezpieczy� system przed niew�a�ciwym wykorzystaniem',
    26 => 'Ten formularz umo�liwia wys�anie maila do wybranego u�ytkownika.  Wymagane jest wype�nienie wszystkich p�l.',
    27 => 'Kr�tka Wiadomo��',
    28 => '%s napisa�: ',
    29 => "Dzienne zestawienie artyku��w w Serwisie {$_CONF['site_name']} z dnia ",
    30 => 'Newsletter z dnia ',
    31 => 'Tytu�',
    32 => 'Data',
    33 => 'Ca�y artyku� dost�pny tutaj ',
    34 => 'Koniec Wiadomo�ci',
    35 => 'Sorry, ale ten u�ytkownik nie �yczy sobie otrzymywania �adnych emaili.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Wyszukiwanie Zaawansowane',
    2 => 'S�owa Kluczowe',
    3 => 'Sekcja',
    4 => 'Wszystko',
    5 => 'Gdzie',
    6 => 'Artyku�y',
    7 => 'Komentarze',
    8 => 'Autorzy',
    9 => 'Wszystko',
    10 => 'Szukaj',
    11 => 'Wyniki',
    12 => 'trafienia',
    13 => 'Wyniki: Brak danych',
    14 => 'Nie znaleziono �adnych danych spe�niaj�cych twoje kryteria',
    15 => 'Prosz� spr�bowa� ponownie.',
    16 => 'Tytu�',
    17 => 'Data',
    18 => 'Autor',
    19 => "Przeszukuje ca�� baz� artyku��w i komentarzy {$_CONF['site_name']} ",
    20 => 'Data',
    21 => 'do',
    22 => '(Format Daty RRRR-MM-DD)',
    23 => 'Ods�on',
    24 => 'Znaleziono %d pozycji',
    25 => 'Szukano',
    26 => 'pozycji ',
    27 => 'sekund',
    28 => 'Brak artyku��w lub komentarzy kt�rych szukasz',
    29 => 'Artyku�y i Komentarze - Wyniki',
    30 => 'Brak link�w spe�niaj�cych twoje kryteria wyszukiwania',
    31 => 'Nie znaleziono �adnych plugin�w',
    32 => 'Wydarzenie',
    33 => 'URL',
    34 => 'Lokalizacja',
    35 => 'Ca�y Dzie�',
    36 => 'Brak wydarze� spe�niaj�cych twoje kryteria wyszukiwania',
    37 => 'Wydarzenia - Wyniki',
    38 => 'Linki - Wyniki',
    39 => 'Linki',
    40 => 'Wydarzenia',
    41 => 'Twoje zapytanie powinno zawiera� co najmniej 3 znaki.',
    42 => 'Prosz� u�ywa� nast�puj�cego formatu daty: RRRR-MM-DD (rok-miesi�c-dzie�).',
    43 => 'z wyra�eniem',
    44 => 'ze wszystkimi s�owami',
    45 => 'z kt�rymkolwiek ze s��w',
    46 => 'Dalej',
    47 => 'Wstecz',
    48 => 'Autor',
    49 => 'Data',
    50 => 'Ods�on',
    51 => 'Link',
    52 => 'Lokalizacja',
    53 => 'Artyku�y - Wyniki',
    54 => 'Komentarze - Wyniki',
    55 => 'fraza',
    56 => 'AND',
    57 => 'OR',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Statystyka Serwisu',
    2 => 'Wszystkich Wizyt w Serwisie',
    3 => 'Artyku��w(Komentarzy) w Serwisie',
    4 => 'Sondy(G�osy) w Serwisie',
    5 => 'Linki(Klikni�cia) w Serwisie',
    6 => 'Wydarzenia w Serwisie',
    7 => '10 Najpopularniejszych Artyku��w',
    8 => 'Tytu� Artyku�u',
    9 => 'Ods�on',
    10 => 'Wygl�da na to, �e w tym serwisie nie ma �adnych artyku��w albo nikt nigdy �adnego nie przeczyta�.',
    11 => '10 Najcz�ciej Komentowanych Artyku��w',
    12 => 'Komentarzy',
    13 => 'Wygl�da na to, �e w tym serwisie nie ma �adnych artyku��w albo nikt nigdy nie skomentowa� �adnego.',
    14 => '10 Najpopularniejszych Sond',
    15 => 'Pytanie Sondy',
    16 => 'G�os�w',
    17 => 'Wygl�da na to, �e w tym serwisie nie ma �adnych sond albo nikt nigdy nie odda� �adnego g�osu.',
    18 => '10 Najpopularniejszych Link�w',
    19 => 'Linki',
    20 => 'Wej��',
    21 => 'Wygl�da na to, �e w tym serwisie nie ma �adnych link�w albo nikt nigdy nie klikn�� na �aden z nich.',
    22 => '10 Najcz�ciej Emaliowanych Artyku��w',
    23 => 'Emaile',
    24 => 'Wygl�da na to, �e nikt nie przes�a� swoim znajomym �adnego artyku�u',
    25 => 'Top Ten Trackback Commented Stories',
    26 => 'No trackback comments found.',
    27 => 'Number of active users',
    28 => 'Top Ten Events',
    29 => 'Event',
    30 => 'Hits',
    31 => 'It appears that there are no events on this site or no one has ever clicked on one.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Odno�niki',
    2 => 'Wy�lij Znajomemu',
    3 => 'Wersja Do Wydruku',
    4 => 'Opcje Artyku�u',
    5 => 'Format PDF'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Aby przes�a� %s musisz si� wcze�niej zalogowa�.',
    2 => 'Login',
    3 => 'Nowy U�ytkownik',
    4 => 'Prze�lij Wydarzenie',
    5 => 'Prze�lij Linka',
    6 => 'Prze�lij Artyku�',
    7 => 'Wymagany jest Login',
    8 => 'Prze�lij',
    9 => 'Przy przesy�aniu informacji do tego serwisu, prosimy post�powa� wg poni�szych wskaz�wek...<ul><li>Nale�y wype�ni� wszystkie pola<li>Zamie�ci� pe�n� i poprawn� informacj�<li>Sprawdzi� dok�adnie podawane adresy</ul>',
    10 => 'Tytu�',
    11 => 'Link',
    12 => 'Data Pocz�tkowa',
    13 => 'Data Ko�cowa',
    14 => 'Lokalizacja',
    15 => 'Opis',
    16 => 'Je�li Inne, podaj jaka',
    17 => 'Kategoria',
    18 => 'Inne',
    19 => 'Przeczytaj Uwa�nie',
    20 => 'B��d: Brak Kategorii',
    21 => 'Wybieraj�c "Inne" wpisz nazw� kategorii',
    22 => 'B��d: Puste Pola',
    23 => 'Wymagane jest wype�nienie wszystkich p�l formularza.',
    24 => 'Zapisano',
    25 => 'Tw�j materia� %s zosta� zapisany.',
    26 => 'Limit Czasowy',
    27 => 'Login',
    28 => 'Sekcja',
    29 => 'Artyku�',
    30 => 'Ostatni raz przesy�a�e� ',
    31 => " sekund temu.  Wymagane jest co najmniej {$_CONF['speedlimit']} sekund przerwy pomi�dzy zamieszczeniami",
    32 => 'Podgl�d',
    33 => 'Podgl�d Artyku�u',
    34 => 'Wyloguj',
    35 => 'Znaczniki HTML nie s� dozwolone',
    36 => 'Format',
    37 => "Przes�ane wydarzenie do serwisu {$_CONF['site_name']} zostanie umieszczone w Kalendarzu G��wnym, z kt�rego u�ytkownicy b�d� mieli mo�liwo�� dodawanie wydarze� do kalendarzy osobistych. Ta opcja <b>NIE S�U�Y</b> do przechowywania informacji osobistych takich jak urodziny itp.<br><br>Po przes�aniu wydarzenia, zostanie ono przes�ane do naszych administrator�w i po zatwierdzeniu pojawi si� w Kalendarzu G��wnym.",
    38 => 'Dodaj Wydarzenie do',
    39 => 'Kalendarz G��wny',
    40 => 'Kalendarz Osobisty',
    41 => 'Koniec',
    42 => 'Pocz�tek',
    43 => 'Ca�y Dzie�',
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
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Wymagana jest Autoryzacja',
    2 => 'Odmowa! Niew�a�ciwy Login',
    3 => 'Niew�a�ciwe has�o u�ytkownika',
    4 => 'Login:',
    5 => 'Has�o:',
    6 => 'Wszelkie pr�by wej�cia do segment�w administracyjnych s� logowane i weryfikowane.<br>Dost�p tylko dla os�b upowa�nionych.',
    7 => 'login'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Niewystarczaj�ce Uprawnienia Administracyjne',
    2 => 'Nie masz wystarczaj�cych uprawnie� do edycji tego bloku.',
    3 => 'Edytor Blok�w',
    4 => 'Wyst�pi� b��d odczytu (szczeg�y w pliku error.log).',
    5 => 'Tytu� Bloku',
    6 => 'Sekcja',
    7 => 'Wszystkie',
    8 => 'Poziom Zabezpieczenia Bloku',
    9 => 'Numer Bloku',
    10 => 'Rodzaj Bloku',
    11 => 'Blok Portalowy',
    12 => 'Blok Normalny',
    13 => 'Opcje Bloku Portalowego',
    14 => 'URL pliku RDF',
    15 => 'Ostatnie Uaktualnienie Pliku RDF',
    16 => 'Opcje Bloku Normalnego',
    17 => 'Zawarto�� Bloku',
    18 => 'Prosz� wpisa� Tytu� Bloku, Poziom Zabezpieczenia i pola Zawarto�ci',
    19 => 'Menad�er Blok�w',
    20 => 'Tytu� Bloku',
    21 => 'PozZab Bloku',
    22 => 'Rodzaj Bloku',
    23 => 'Numer Bloku',
    24 => 'Sekcja Bloku',
    25 => 'Aby zmodyfikowa� lub wykasowa� blok kliknij na blok poni�ej.  Aby stworzy� nowy blok kliknij Nowy Blok powy�ej.',
    26 => 'Blok Schematowy',
    27 => 'Blok PHP',
    28 => 'Opcje Bloku PHP',
    29 => 'Funkcje Bloku',
    30 => 'Je�li chcesz aby tw�j blok obs�ugiwa� kod PHP, wpisz nazw� funkcji powy�ej.  Nazwa funkcji musi rozpoczyna� si� prefiksem "phpblock_" (np. phpblock_getweather).  Je�eli nie b�dzie prefiksu, twoja funkcja NIE zostanie wywo�ana.  Zwi�zane jest to z uniemo�liwieniem \'wrzucania\' skrypt�w przez haker�w, kt�re mog� uszkodzi� tw�j system.  Upewnij si�, �e nie ma pustych nawias�w "()" po nazwie funkcji.  Na koniec, zalecamy umieszczenie ca�ego kodu PHP Block w /�cie�ka/do/geeklog/system/lib-custom.php.  Pozwoli to na zachowanie wersji kodu bez zmian nawet przy aktualizacji Geekloga.',
    31 => 'B��d w Bloku PHP.  Funkcja, %s, nie istnieje.',
    32 => 'B��d. Puste pole(a)',
    33 => 'Musisz wpisa� URL do pliku .rdf dla blok�w portalowych',
    34 => 'Musisz wpisa� tytu� i funkcj� blok�w PHP',
    35 => 'Musisz wpisa� tytu� i zawarto�� dla blok�w normalnych',
    36 => 'Musisz wpisa� zawarto�� blok�w schematowych',
    37 => 'Nieprawid�owa nazwa funkcji bloku PHP',
    38 => 'Funkcje dla Blok�w PHP musz� mie� prefiks \'phpblock_\' (np. phpblock_getweather).  Prefiks \'phpblock_\' ze wzgl�d�w bezpiecze�stwa aby unikn�� wykonywanie kodu.',
    39 => 'Strona',
    40 => 'Lewa',
    41 => 'Prawa',
    42 => 'Musisz wpisa� porz�dek bloku i poziom zabezpiecze� dla domy�lnych blok�w Geekloga',
    43 => 'Tylko Strona G��wna',
    44 => 'Odmowa Dost�pu',
    45 => "Pr�bujesz wyedytowa� blok, do kt�rego nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu. Prosz� <a href=\"{$_CONF['site_admin_url']}/block.php\">wr�ci� do ekranu administrowania blokami</a>.",
    46 => 'Nowy Blok',
    47 => 'Panel Sterowania',
    48 => 'Nazwa Bloku',
    49 => ' (nazwa unikalna i bez spacji)',
    50 => 'URL Pliku Pomocy',
    51 => 'uwzgl�dnij http://',
    52 => 'Je�li zostawisz puste, ikona pomocy dla tego bloku si� nie pojawi',
    53 => 'Aktywne',
    54 => 'zapisz',
    55 => 'anuluj',
    56 => 'kasuj',
    57 => 'Przesu� Blok w D�',
    58 => 'Przesu� Blok w G�r�',
    59 => 'Przesu� blok na prawo',
    60 => 'Przesu� blok w lewo',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order',
    66 => 'Autotags',
    67 => 'Check to allow autotags'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Poprzednie Artyku�y',
    2 => 'Nast�pne Artyku�y',
    3 => 'Tryb',
    4 => 'Format',
    5 => 'Edytor Artyku��w',
    6 => 'Brak artyku��w w systemie',
    7 => 'Autor',
    8 => 'zapisz',
    9 => 'podgl�d',
    10 => 'anuluj',
    11 => 'kasuj',
    12 => 'ID',
    13 => 'Tytu�',
    14 => 'Sekcja',
    15 => 'Data',
    16 => 'Wst�p',
    17 => 'Cz�� G��wna',
    18 => 'Wej��',
    19 => 'Komentarze',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Lista Artyku��w',
    23 => 'Aby zmodyfikowa� lub wykasowa� artyku�, kliknij na numer danego artyku�u poni�ej. Aby przegl�dn�� artyku� kliknij na tytu� danego artyku�u. Aby wpisa� nowy artyku� kliknij na Nowy Artyku� powy�ej.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Podgl�d Artyku�u',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'B��d Uploadu Pliku',
    31 => 'Prosz� wpisa� Tytu� i Wst�p',
    32 => 'Artyku� Dnia',
    33 => 'Artyku� Dnia mo�e by� tylko jeden',
    34 => 'Wersja Robocza',
    35 => 'Tak',
    36 => 'Nie',
    37 => 'Wi�cej autorstwa',
    38 => 'Wi�cej z sekcji',
    39 => 'Emaile',
    40 => 'Odmowa Dost�pu',
    41 => "Pr�bujesz wyedytowa� artyku� do kt�rego nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu.  Mo�esz podgl�dn�� artyku� poni�ej. Prosz� <a href=\"{$_CONF['site_admin_url']}/story.php\">wr�ci� do strony administruj�cej artyku�ami.",
    42 => "Pr�bujesz wyedytowa� artyku� do kt�rego nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu.  Prosz� <a href=\"{$_CONF['site_admin_url']}/story.php\">wr�ci� do strony administruj�cej artyku�ami</a>.",
    43 => 'Nowy Artyku�',
    44 => 'Panel Sterowania',
    45 => 'Dost�p',
    46 => '<b>UWAGA:</b> je�li przesuniesz dat� do przodu, artyku� nie zostanie opublikowany wcze�niej. Oznacza to r�wnie�, �e artyku� nie b�dzie uwzgl�dniony w pliku RDF i zostanie pomini�ty przy wyszukiwaniu.',
    47 => 'Zdj�cia',
    48 => 'zdj�cie',
    49 => 'prawo',
    50 => 'lewo',
    51 => 'Aby doda� jedno ze zdj��, kt�re chcesz podpi�� do tego artyku�u musisz wstawi� specjalnie sformatowany tekst.  Tekst jest nast�puj�cy [imageX], [imageX_right] lub [imageX_left] gdzie X to numer obrazka, kt�ry za��czy�e�.  UWAGA: Musisz u�ywa� obrazk�w, kt�re za��czasz.  Inaczej nie b�dziesz w stanie zapisa� swojego artyku�u.<BR><P><B>PODGL�D</B>: Podgl�d artyku�u z za��czonymi obrazkami dzia�a najlepiej po uprzednim zapisaniu artyku�u jako kopia ZAMIAST u�ycia bezpo�rednio klawisza podgl�d.  U�ywaj klawisza podgl�d tylko gdy nie podpinasz obrazk�w.',
    52 => 'Kasuj',
    53 => 'nie zosta� u�yty.  Musisz umie�ci� ten obrazek we wst�pie lub w g��wnej cz�ci zanim zapiszsz zmiany',
    54 => 'Za��czonych Obraz�w Nie U�yto',
    55 => 'Pojawi�y si� nast�puj�ce b��dy podczas pr�by zapisu tego artyku�u.  Prosz� je poprawi� przed ponownym zapisem',
    56 => 'Poka� Ikon� Artyku�u',
    57 => 'Poka� nieskalowalne zdj�cie',
    58 => 'Zarz�dzanie Artyku�ami',
    59 => 'Opcja',
    60 => 'Aktywna',
    61 => 'Auto Archiwizacja',
    62 => 'Auto Kasacja',
    63 => '',
    64 => '',
    65 => '',
    66 => '',
    67 => 'Expand the Content Edit Area size',
    68 => 'Reduce the Content Edit Area size',
    69 => 'Publish Story Date',
    70 => 'Toolbar Selection',
    71 => 'Basic Toolbar',
    72 => 'Common Toolbar',
    73 => 'Advanced Toolbar',
    74 => 'Advanced II Toolbar',
    75 => 'Full Featured',
    76 => 'Publish Options',
    77 => 'Javascript needs to be enabled for Advanced Editor. Option can be disabled in the main site config.php',
    78 => 'Click <a href="%s/story.php?mode=edit&amp;sid=%s&amp;editopt=default">here</a> to use default editor',
    79 => 'Preview',
    80 => 'Editor',
    81 => 'Publish Options',
    82 => 'Images',
    83 => 'Archive Options',
    84 => 'Permissions',
    85 => 'Show All',
    86 => 'Advanced Editor',
    87 => 'Story Stats'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Edytor Sekcji',
    2 => 'ID Sekcji',
    3 => 'Nazwa Sekcji',
    4 => 'Ikona Sekcji',
    5 => '(bez spacji)',
    6 => 'Wykasowanie sekcji wykasuje wszystkie artyku�y i bloki z ni� powi�zane',
    7 => 'Prosz� wpisa� ID Sekcji i Nazw� Sekcji',
    8 => 'Menad�er Sekcji',
    9 => 'Aby zmodyfikowa� lub wykasowa� sekcj�, kliknij na dan� sekcj�.  Aby stworzy� now� sekcj� kliknij na Nowa Sekcja powy�ej. W nawiasie znajduje si� tw�j poziom dost�pu do ka�dej sekcji. Gwiazdka (*) oznacza domy�ln� sekcj�.',
    10 => 'Sortowanie',
    11 => 'Artyku��w/Stron�',
    12 => 'Odmowa Dost�pu',
    13 => "Pr�bujesz wyedytowa� sekcj� do kt�rej nie masz uprawnie�.  Ta pr�ba zosta�a zapisana w logu. Prosz� <a href=\"{$_CONF['site_admin_url']}/topic.php\">wr�ci� do ekranu administruj�cego sekcjami</a>.",
    14 => 'Sortuj Wg',
    15 => 'alfabetycznie',
    16 => 'domy�lnie jest',
    17 => 'Nowa Sekcja',
    18 => 'Panel Sterowania',
    19 => 'zapisz',
    20 => 'anuluj',
    21 => 'kasuj',
    22 => 'Domy�lnie',
    23 => 'zr�b z tego domy�ln� sekcj� dla przesy�anych artyku��w',
    24 => '(*)',
    25 => 'Sekcja Archiwalna',
    26 => 'domy�lna sekcja dla archiwizowanych artyku��w. Dozwolona jest tylko jedna sekcja.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Edytor U�ytkownik�w',
    2 => 'ID U�ytkownika',
    3 => 'Login',
    4 => 'Pe�na Nazwa',
    5 => 'Has�o',
    6 => 'Poziom Zabezpieczenia',
    7 => 'Adres Email',
    8 => 'Strona Domowa',
    9 => '(bez spacji)',
    10 => 'Prosz� wpisa� Login i Adres Email',
    11 => 'Menad�er U�ytkownik�w',
    12 => 'Aby zmodyfikowa� lub usun�� u�ytkownika, kliknij na odpowiedni login poni�ej.  Aby za�o�y� nowego u�ytkownika kliknij nowy u�ytkownik po lewej. Mo�esz przeszuka� baz� wpisuj�c cz�� loginu, adresu email lub pe�nej nazwy (np. *son* lub *.edu) w poni�szym formularzu.',
    13 => 'PozZab',
    14 => 'Data Rej.',
    15 => 'Nowy U�ytkownik',
    16 => 'Panel Sterowania',
    17 => 'zmie� has�o',
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
    32 => 'Przetwarzanie zako�czone. Zaimportowano %d i napotkano %d b��d�w',
    33 => 'prze�lij',
    34 => 'B��d: Musisz poda� plik do za�adowania.',
    35 => 'Ostatni Login',
    36 => '(nigdy)',
    37 => 'UID',
    38 => 'Group Listing',
    39 => 'Password (again)',
    40 => 'Registration Date',
    41 => 'Last login Date',
    42 => 'Banned',
    43 => 'Awaiting Activation',
    44 => 'Awaiting Authorization',
    45 => 'Active',
    46 => 'User Status',
    47 => 'Edit',
    48 => 'Show Admin Groups',
    49 => 'Admin Group',
    50 => 'Check to allow filtering this group as an Admin Use Group',
    51 => 'Online Days',
    52 => '<br>Note: "Online Days" is the number of days between the first registration and the last login.',
    53 => 'registered',
    54 => 'Batch Delete',
    55 => 'This only works if you have <code>$_CONF[\'lastlogin\'] = true;</code> in your config.php',
    56 => 'Please choose the type of user you want to delete and press "Update List". Then, uncheck those from the list you do not want to delete and press "Delete". Please note that you will only delete those that are currently visible in case the list spans over several pages.',
    57 => 'Phantom users',
    58 => 'Short-Time Users',
    59 => 'Old Users',
    60 => 'Users that registered more than ',
    61 => ' months ago, but never logged in.',
    62 => 'Users that registered more than ',
    63 => ' months ago, then logged in within 24 hours, but since then never came back to your site.',
    64 => 'Normal users, who simply did not visit your site since ',
    65 => ' months.',
    66 => 'Update List',
    67 => 'Months since registration',
    68 => 'Online Hours',
    69 => 'Offline Months',
    70 => 'could not be deleted',
    71 => 'sucessfully deleted',
    72 => 'No User selected for deletion',
    73 => 'Are You sure you want to permanently delete ALL selected users?',
    74 => 'Recent Users',
    75 => 'Users that registered in the last ',
    76 => ' months'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Zatwierd�',
    2 => 'Kasuj',
    3 => 'Edytuj',
    4 => 'Profil',
    10 => 'Tytu�',
    11 => 'Data Pocz�tkowa',
    12 => 'URL',
    13 => 'Kategoria',
    14 => 'Data',
    15 => 'Sekcja',
    16 => 'Nazwa u�ytkownika',
    17 => 'Pe�na nazwa u�ytkownika',
    18 => 'Email',
    34 => 'Panel Sterowania',
    35 => 'Przes�ane Artyku�y',
    36 => 'Przes�ane Linki',
    37 => 'Przes�ane Wydarzenia',
    38 => 'Prze�lij',
    39 => '�adnych materia��w do zatwierdzenia',
    40 => 'Materia�y przes�ane przez u�ytkownika'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => 'Mail',
    2 => 'Od',
    3 => 'Odpowiedz',
    4 => 'Temat',
    5 => 'Wiadomo��',
    6 => 'Wy�lij do:',
    7 => 'Wszyscy',
    8 => 'Admin',
    9 => 'Opcje',
    10 => 'HTML',
    11 => 'Pilne!',
    12 => 'Wy�lij',
    13 => 'Zresetuj',
    14 => 'Ignoruj ustawienia u�ytkownika',
    15 => 'B��d podczas wysy�ania do: ',
    16 => 'Wiadomo�� wys�ana do: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Wy�lij nast�pn� wiadomo��</a>",
    18 => 'Do',
    19 => 'UWAGA: je�li chcesz wys�a� wiadomo�� do wszystkich u�ytkownik�w, wybierz Logged-in Users z listy rozwijanej.',
    20 => "Wys�anych <successcount> wiadomo�ci oraz <failcount> niewys�anych wiadomo�ci.  Poni�ej szczeg�y dotycz�ce pr�by wys�ania ka�dej wiadomo�ci.  Mo�esz r�wnie� <a href=\"{$_CONF['site_admin_url']}/mail.php\">Wys�a� wiadomo��</a> lub mo�esz <a href=\"{$_CONF['site_admin_url']}/moderation.php\">wr�ci� do strony administracyjnej</a>.",
    21 => 'B��d',
    22 => 'Sukces',
    23 => 'Brak b��d�w',
    24 => 'Bez powodzenia',
    25 => '-- Wybierz Grup� --',
    26 => 'Prosz� uzupe�ni� wszystkie pola i wybra� grup� z listy.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Instalowanie plugin�w mo�e spowodowa� uszkodzenie twojej instalacji Geekloga jak r�wnie� systemu.  Wa�ne jest aby instalowa� pluginy �ci�gni�te z <a href="http://www.geeklog.net" target="_blank">Geeklog Homepage</a> poniewa� s� one szczeg�owo przez nas testowane na r�nych systemach operacyjnych.  Wa�ne aby� mia� �wiadomo��, �e instalacja pluginu wymaga wykonania kilku komend filesystemu, co wi��e si� z bezpiecze�stwem systemu, zw�aszcza gdy pluginy pochodz� od os�b trzecich.  Pomimo tego ostrze�enia, nie gwarantujemy sukcesu instalacyjnego ani nie mo�emy by� poci�gni�ci do odpowiedzialno�ci za jakiekolwiek szkody wynik�e z instalacji jakiegokolwiek pluginu.  Instalacja na w�asne ryzyko.  Instrukcje dotycz�ce r�cznej instalacji pluginu znajduj� si� w ka�dym pakiecie z pluginem.',
    2 => 'Umowa Instalacyjna Plugin�w',
    3 => 'Plugin Formularz Instalacyjny',
    4 => 'Plugin Plik',
    5 => 'Zainstalowane Pluginy',
    6 => 'Ostrze�enie: Plugin Ju� Zainstalowany!',
    7 => 'Plugin, kt�ry pr�bujesz zainstalowa� ju� istnieje.  Prosz� wykasowa� istniej�cy plugin i zainstalowa� go ponownie',
    8 => 'Sprawdzanie Kompatybilno�ci Pluginu Zako�czone Niepowodzeniem',
    9 => 'Ten plugin wymaga nowszej wersji Geekloga. Albo uaktualnij swoj� kopi� <a href=http://www.geeklog.net>Geekloga</a> albo �ci�gnij nowsz� wersj� tego pluginu.',
    10 => '<br><b>Brak zainstalowanych plugin�w.</b><br><br>',
    11 => 'Aby zmodyfikowa� lub wykasowa� plugin, kliknij na nazw� pluginu. Zobaczysz wi�cej informacji w��cznie z adresem strony autora. Widoczne s� wersje zainstalowana i wersja kodu. To pomo�e stwierdzi� czy dany plugin wymaga aktualizacji. Aby zainstalowa� lub uaktualni� dany plugin prosz� zapozna� si� z do��czon� do niego instrukcj�.',
    12 => 'brak nazwy pluginu dla plugineditor()',
    13 => 'Edytor Plugin�w',
    14 => 'Nowy Plugin',
    15 => 'Panel Sterowania',
    16 => 'Nazwa',
    17 => 'Wersja',
    18 => 'Wersja GL',
    19 => 'Aktywny',
    20 => 'Tak',
    21 => 'Nie',
    22 => 'Instaluj',
    23 => 'Zapisz',
    24 => 'Anuluj',
    25 => 'Kasuj',
    26 => 'Nazwa Pluginu',
    27 => 'Strona Domowa Pluginu',
    28 => 'Wersja Zainstalowana',
    29 => 'Wersja GL',
    30 => 'Skasowa� Plugin?',
    31 => 'Czy aby na pewno skasowa� ten plugin?  Ta operacja usunie wszelkie pliki, dane i struktur� u�ywane przez ten plugin.  Je�li chcesz kontynuwa� kliknij kasuj poni�ej.',
    32 => '<p><b>B��dny format tagu AutoLink</b></p>',
    33 => 'Wersja Kodu',
    34 => 'Aktualizacja',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'stw�rz plik',
    2 => 'zapisz',
    3 => 'kasuj',
    4 => 'anuluj',
    10 => 'Syndykacja Tre�ci',
    11 => 'Nowy Plik',
    12 => 'Panel Sterowania',
    13 => 'Aby zmodyfikowa� lub usun�� plik, kliknij na tytu� pliku poni�ej. Aby stworzy� nowy plik, kliknij Nowy Plik powy�ej.',
    14 => 'Tytu�',
    15 => 'Rodzaj',
    16 => 'Plik',
    17 => 'Format',
    18 => 'ost. aktualizacja',
    19 => 'Aktywny',
    20 => 'Tak',
    21 => 'Nie',
    22 => '<i>(plik�w brak)</i>',
    23 => 'Wszystkie Artyku�y',
    24 => 'Edytor Plik�w',
    25 => 'Tytu� Pliku',
    26 => 'Limit',
    27 => 'D�ugo�� tekstu',
    28 => '(0 = bez tekstu, 1 = pe�ny tekst, inne = ograniczona liczba znak�w.)',
    29 => 'Opis',
    30 => 'Ost. Aktualizacja',
    31 => 'Kodowanie',
    32 => 'J�zyk',
    33 => 'Zawarto��',
    34 => 'Tytu��w',
    35 => 'Godzin',
    36 => 'Wybierz rodzaj pliku',
    37 => 'Masz zainstalowany co najmniej jeden plugin zarz�dzaj�cy syndykacj� tre�ci. Poni�ej nale�y wybra� opcj� czy chcesz stworzy� plik Geeklogowy czy te� plik dla jednego z plugin�w.',
    38 => 'B��d: Brakuj�ce Pola',
    39 => 'Wpisz Tytu� Pliku, Opis i Nazw� Pliku.',
    40 => 'Prosz� poda� liczb� tytu��w lub czas w godzinach.',
    41 => 'Linki',
    42 => 'Wydarzenia',
    43 => 'All',
    44 => 'None',
    45 => 'Header-link in topic',
    46 => 'Limit Results',
    47 => 'Search',
    48 => 'Edit',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})",
    51 => 'The filename you have chosen is already used by another feed. Please choose a different one.',
    52 => 'Error: existing Filename'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Has�o zosta�o wys�ane i powiniene� go wkr�tce otrzyma�. Post�puj zgodnie ze wskaz�wkami w wiadomo�ci. Dzi�kujemy za korzystanie z serwisu {$_CONF['site_name']}",
    2 => "Dzi�kujemy za przes�anie artyku�u do {$_CONF['site_name']}.  Otrzymali go nasi pracownicy do zatwierdzenia. Po zatwierdzeniu tw�j artyku� b�dzie dost�pny dla innych u�ytkownik�w naszego serwisu.",
    3 => "Dzi�kujemy za przes�anie linka do {$_CONF['site_name']}.  Otrzymali go nasi pracownicy do zatwierdzenia.  Po zatwierdzeniu tw�j link b�dzie widoczny w sekcji <a href={$_CONF['site_url']}/links.php>linki</a>.",
    4 => "Dzi�kujemy za przes�anie wydarzenia do {$_CONF['site_name']}.  Otrzymali go nasi pracownicy do zatwierdzenia.  Po zatwierdzeniu twoje wydarzenie b�dzie widoczne w sekcji <a href={$_CONF['site_url']}/calendar.php>kalendarz</a>.",
    5 => 'Informacje dotycz�ce twojego konta zosta�y zapisane.',
    6 => 'Twoje preferencje dotycz�ce wygl�du zosta�y zapisane.',
    7 => 'Twoje preferencje dotycz�ce komentarzy zosta�y zapisane.',
    8 => 'Zosta�e�/a� pomy�lnie wylogowany/a.',
    9 => 'Artyku� zosta� zapisany.',
    10 => 'Artyku� zosta� wykasowany.',
    11 => 'Blok zosta� zapisany.',
    12 => 'Blok zosta� wykasowany.',
    13 => 'Sekcja zosta�a zapisana.',
    14 => 'Sekcja oraz wszystkie artyku�y i bloki z ni� zwi�zane zosta�y wykasowane.',
    15 => 'Link zosta� zapisany.',
    16 => 'Link zosta� wykasowany.',
    17 => 'Wydarzenie zosta�o zapisane.',
    18 => 'Wydarzenie zosta�o wykasowane.',
    19 => 'G�osowanie zosta�o zapisane.',
    20 => 'G�osowanie zosta�o wykasowane.',
    21 => 'Nowy u�ytkownik zosta� zapisany.',
    22 => 'Nowy u�ytkownik zosta� wykasowany.',
    23 => 'Wyst�pi� b��d podczas pr�by dodania wydarzenia do twojego kalendarza. Nie przekazano ID wydarzenia.',
    24 => 'Wydarzenie zosta�o zapisane w twoim kalendarzu',
    25 => 'Kalendarz osobisty dost�pny jest dopiero po zalogowaniu',
    26 => 'Wydarzenie zosta�o usuni�te z twojego kalendarza osobistego',
    27 => 'Wiadomo�� wys�ano.',
    28 => 'Plugin zosta� zapisany',
    29 => 'Sorry, kalendarze osobiste s� niedost�pne w tym serwisie',
    30 => 'Odmowa Dost�pu',
    31 => 'Sorry, nie masz dost�pu do strony administruj�cej artyku�ami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    32 => 'Sorry, nie masz dost�pu do strony administruj�cej sekcjami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    33 => 'Sorry, nie masz dost�pu do strony administruj�cej blokami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    34 => 'Sorry, nie masz dost�pu do strony administruj�cej linkami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    35 => 'Sorry, nie masz dost�pu do strony administruj�cej wydarzeniami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    36 => 'Sorry, nie masz dost�pu do strony administruj�cej sondami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    37 => 'Sorry, nie masz dost�pu do strony administruj�cej u�ytkownikami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    38 => 'Sorry, nie masz dost�pu do strony administruj�cej pluginami.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    39 => 'Sorry, nie masz dost�pu do strony administruj�cej mailem.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    40 => 'Komunikat Systemowy',
    41 => 'Sorry, nie masz dost�pu do strony edycyjnej zamiennik�w s��w.  Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    42 => 'S�owo zosta�o zapisane.',
    43 => 'S�owo zosta�o wykasowane.',
    44 => 'Plugin zosta� zainstalowany!',
    45 => 'Plugin zosta� wykasowany.',
    46 => 'Sorry, nie masz dost�pu do opcji archiwizowania bazy danych.  Pami�taj, �e Wszelkie nieautoryzowane pr�by wej�cia s� logowane',
    47 => 'Ta opcja dzia�a tylko pod systemem *nixowym. Je�li masz w�a�nie taki system operacyjny to cache zosta� wyczyszczony. Pod Windoz�, musisz poszuka� plik�w adodb_*.php i usun�� je r�cznie.',
    48 => "Dziekujemy za zainteresowanie cz�onkowstwem w {$_CONF['site_name']}. Zweryfikujemy twoje zg�oszenie i po zatwierdzeniu zostanie wys�ane has�o pod podany adres e-mail.",
    49 => 'Twoja grupa zosta�a zapisana.',
    50 => 'Grupa zosta�a wykasowana.',
    51 => 'Ten login juz istnieje. Prosze wybrac inny.',
    52 => 'Podany adres email nie wyglada na prawidlowy.',
    53 => 'Twoje nowe has�o zosta�o przyj�te. Prosz� zalogowac sie ponizej wpisuj�c nowe has�o.',
    54 => 'Twoja pro�ba o nowe has�o wygas�a. Prosz� spr�bowac ponownie poni�ej.',
    55 => 'Wkr�tce powinien dotrze� do Ciebie email. Post�puj zgodnie ze wskaz�wkami aby ustawi� nowe has�o dla Twojego konta.',
    56 => 'Podany adres email jest ju� u�ywany.',
    57 => 'Twoje konto zosta�o pomy�lnie usuni�te.',
    58 => 'Plik zosta� zapisany.',
    59 => 'Plik zosta� skasowany.',
    60 => 'Plugin zosta� pomy�lnie zaktualizowany',
    61 => 'Plugin %s: Nieznany komunikat placeholder',
    62 => 'The trackback comment has been deleted.',
    63 => 'An error occurred when deleting the trackback comment.',
    64 => 'Your trackback comment has been successfully sent.',
    65 => 'Weblog directory service successfully saved.',
    66 => 'The weblog directory service has been deleted.',
    67 => 'The new password does not match the confirmation password!',
    68 => 'You have to enter the correct current password.',
    69 => 'Your account has been blocked!',
    70 => 'Your account is awaiting administrator approval.',
    71 => 'Your account has now been confirmed and is awaiting administrator approval.',
    72 => 'An error occured while attempting to install the plugin. See error.log for details.',
    73 => 'An error occured while attempting to uninstall the plugin. See error.log for details.',
    74 => 'The pingback has been successfully sent.',
    75 => 'Trackbacks must be sent using a POST request.',
    76 => 'Do you really want to delete this item?',
    77 => 'WARNING:<br>You have set your default encoding to UTF-8. However, your server does not support multibyte encodings. Please install mbstring functions for PHP or choose a different character set/language.',
    78 => 'Please make sure that the email address and the confirmation email address are the same.',
    79 => 'The page you have been trying to open refers to a function that no longer exists on this site.',
    80 => 'The plugin that created this feed is currently disabled. You will not be able to edit this feed until you re-enable the parent plugin.',
    81 => 'You may have mistyped your login credentials.  Please try logging in again below.',
    82 => 'You have exceeded the number of allowed login attempts.  Please try again later.',
    83 => 'To change your password, email address, or for how long to remember you, please enter your current password.',
    84 => 'To delete your account, please enter your current password.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Dost�p',
    'ownerroot' => 'W�a�ciciel/Root',
    'group' => 'Grupa',
    'readonly' => 'Tylko-do-Odczytu',
    'accessrights' => 'Prawa Dost�pu',
    'owner' => 'W�a�ciciel',
    'grantgrouplabel' => 'Udziel Praw do Edycji Powy�szej Grupie',
    'permmsg' => 'UWAGA: cz�onkowie to wszyscy zalogowani u�ytkownicy na stronie a anonimowi to wszyscy u�ytkownicy przegl�daj�cy zawarto�� strony bez zalogowania.',
    'securitygroups' => 'Grupy Zabezpiecze�',
    'editrootmsg' => "Pomimo tego, �e jeste� User Administrator, nie mo�esz edytowa� g��wnego u�ytkownka. Najpierw sam musisz zosta� u�ytkownikiem g��wnym.  Mo�esz edytowa� pozosta�ych u�ytkownik�w. Wszelkie nie autoryzowane pr�by edycji u�ytkownik�w g��wnych s� logowane.  Powr�t do strony Administracja U�ytkownikami serwisu <a href=\"{$_CONF['site_admin_url']}/user.php\"></a>.",
    'securitygroupsmsg' => 'Zaznacz grupy do kt�rych chcesz przypisa� u�ytkownika.',
    'groupeditor' => 'Edytor Grup',
    'description' => 'Opis',
    'name' => 'Nazwa',
    'rights' => 'Uprawnienia',
    'missingfields' => 'Brakuj�ce Pola',
    'missingfieldsmsg' => 'Musisz poda� nazw� i opis grupy',
    'groupmanager' => 'Menad�er Grup',
    'newgroupmsg' => 'Aby zmodyfikowa� lub wykasowa� grup� kliknij na dan� grup� poni�ej. Aby stworzy� now� grup� kliknij nowa grupa powy�ej. Grupy g��wne nie mog� by� wykasowane s� u�ywane przez system.',
    'groupname' => 'Nazwa Grupy',
    'coregroup' => 'Grupa G��wna',
    'yes' => 'Tak',
    'no' => 'Nie',
    'corerightsdescr' => "Ta grupa jest G��wn� Grup� strony {$_CONF['site_name']} .  Z tego wzgl�du prawa dla  tej grupy nie mog� by� edytowane.  Poni�ej znajduje si� lista do-odczytu praw tej grupy.",
    'groupmsg' => 'Grupy Zabezpiecze� Groups w tym serwisie s� hierarchiczne.  Poprzez dodanie tej grupy do jakiejkolwiek grupy poni�ej, tym samym nadasz tej grupie takie same prawa.  Je�eli to mo�liwe to zalecamy wykorzystanie poni�szych grup przy nadawaniu praw jakiejkolwiek grupie.  Je�li chcesz nada� tej grupie specjalne prawa, mo�esz wybra� uprawnienia do r�nych funkcji serwisu w poni�szej sekcji \'Uprawnienia\'.  Aby doda� t� grup� do kt�rejkolwiek z poni�szej listy, zaznacz po prostu wybran� grup�(y).',
    'coregroupmsg' => "To jest Grupa g��wna serisu {$_CONF['site_name']}.  Z tego wzgl�du grupy nale��ce do tej kategorii nie mog� by� edytowane.  Poni�ej znajduje si� lista, tylko do odczytu, grup z tej kategorii.",
    'rightsdescr' => 'Dost�p grupowy to wybranych uprawnie� poni�ej mo�e by� nadany bezpo�rednio danej grupie LUB innej grupie, do kt�rej dana grupa nale�y.  Te z listy poni�ej bez pola wyboru oznaczaj� uprawnienia tej grupy wynikaj�ce z faktu przynale�no�ci do grupy z danym uprawnieniem.  Uprawnienia z polami wyboru mog� zosta� bezpo�rednio nadane danej grupie.',
    'lock' => 'Blokada',
    'members' => 'Cz�onkowie',
    'anonymous' => 'Anonim',
    'permissions' => 'Uprawnienia',
    'permissionskey' => 'R = odczyt, E = edycja, prawa do edycji zak�adaj� prawa do odczytu',
    'edit' => 'Edycja',
    'none' => 'Brak',
    'accessdenied' => 'Odmowa Dost�pu',
    'storydenialmsg' => "Brak dost�pu do tego artyku�u.  Prawdopodobnie nie jeste� cz�onkiem serwisu {$_CONF['site_name']}.  Zapraszamy do <a href=users.php?mode=new> cz�onkostwa</a> w serwisie {$_CONF['site_name']} aby otrzyma� pe�ny dost�p!",
    'nogroupsforcoregroup' => 'Grupa nie nale�y do pozosta�ych grup',
    'grouphasnorights' => 'Grupa nie ma dost�pu do �adnych funkcji administracyjnych tego serwisu',
    'newgroup' => 'Nowa Grupa',
    'adminhome' => 'Panel Sterowania',
    'save' => 'zapisz',
    'cancel' => 'anuluj',
    'delete' => 'kasuj',
    'canteditroot' => 'Wyst�pi�a pr�ba edycji grupy G��wnej. Niestety nie nale�ysz do �adnej z grup G��wnych dlatego nie masz dost�pu do tej grupy.  Skontaktuj si� z administratorem systemu je�li uwa�asz, �e to pomy�ka',
    'listusers' => 'Listuj U�ytkownik�w',
    'listthem' => 'listuj',
    'usersingroup' => 'U�ytkownicy w grupie %s',
    'usergroupadmin' => 'Administracja Grupami U�ytkownik�w',
    'add' => 'Dodaj',
    'remove' => 'Usu�',
    'availmembers' => 'Dost�pni Cz�onkowie',
    'groupmembers' => 'Cz�onkowie Grupy',
    'canteditgroup' => 'Aby wyedytowa� t� grup� musisz do niej nale�e�. Prosz� skontaktowa� si� z administratorem je�li uwa�asz, �e nast�pi�a pomy�ka.',
    'cantlistgroup' => 'Aby zobaczy� cz�onk�w tej grupy, musisz by� jej cz�onkiem. Skontaktuj si� z administratorem je�li uwa�asz, �e to jest b��d.',
    'editgroupmsg' => 'To modify the group membership, click on the member names(s) and use the add or remove buttons. If the member is a member of the group, their name will appear on the right side only. Once you are complete - press <b>Save</b> to update the group and return to the main group admin page.',
    'listgroupmsg' => 'Listing of all current members in the group: <b>%s</b>',
    'search' => 'Search',
    'submit' => 'Submit',
    'limitresults' => 'Limit Results',
    'group_id' => 'Group ID',
    'plugin_access_denied_msg' => 'You are illegally trying access a plugin administration page.  Please note that all attempts to illegally access this page are logged.',
    'groupexists' => 'Group name already exists',
    'groupexistsmsg' => 'There is already a group with this name. Group names must be unique.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => '10 Kopii Zapasowych',
    'do_backup' => 'Wykonaj Kopi� Zapasow�',
    'backup_successful' => 'Kopia bazy wykonana pomy�lnie.',
    'db_explanation' => 'Aby wykona� now� kopi� zapasow� twojego systemu, kliknij poni�szy przycisk',
    'not_found' => "Niew�a�ciwa �cie�ka lub program archiwizuj�cy nie jest wykonywalny.<br>Sprawd� <strong>\$_DB_mysqldump_path</strong> ustawienia w config.php.<br>Zmienna jest obecnie ustawiona na: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Wykonanie Kopii Nie Powiod�o Si�: Rozmiar pliku 0 bajt�w',
    'path_not_found' => "{$_CONF['backup_path']} nie istnieje lub nie jest katalogiem",
    'no_access' => "B��D: Katalog {$_CONF['backup_path']} jest niedost�pny.",
    'backup_file' => 'Plik kopii',
    'size' => 'Rozmiar',
    'bytes' => 'Bajt�w',
    'total_number' => 'Wszystkich kopii bezpiecze�stwa: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'G��wna',
    2 => 'Kontakt',
    3 => 'Napisz Artyku�',
    4 => 'Linki',
    5 => 'Sonda',
    6 => 'Kalendarz',
    7 => 'Statystyka',
    8 => 'Osobiste',
    9 => 'Szukaj',
    10 => 'zaawansowane szukanie',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'B��d 404',
    2 => 'Kurcze, wsz�dzie szuka�em ale nie mog� znale�� <b>%s</b>.',
    3 => "<p>Przykro nam ale dany plik nie istnieje. Sprawd� <a href=\"{$_CONF['site_url']}/search.php\">stron� z wyszukiwark�</a> aby sprawdzi� czy mo�na znale�� co zgubi�e�."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Wymagany jest login',
    2 => 'Sorry, aby wej�� na te strony musisz by� zalogowany.',
    3 => 'Login',
    4 => 'Nowy U�ytkownik'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'Opcja PDF zosta�a wy��czona',
    2 => 'Dany dokument nie zosta� wygenerowany. Dokument zosta� otrzymany ale nie m�g� by� przetworzony.  Upewnij si�, �e przes�ane dokumenty html zosta�y zapisane w standardowym xHTML. Prosz� mie� na uwadze, �e skomplikowane dokumenty html-owe mog� zosta� przetworzone z b��dem lub w og�le. Dokument, kt�ry pr�bowa�a�/e� wygenrowa� mia� rozmiar 0 bajt�w i zosta� usuni�ty. Je�li uwa�asz, �e Tw�j dokument powinien zosta� wygenerowany prawid�owo, prze�lij go raz jeszcze.',
    3 => 'Nieznany b��d podczas generowania pliku PDF',
    4 => "Nie okre�lono �adnej strony albo chcesz u�y� poni�szego narz�dzia do generowania PDF-a ad-hoc.  Je�li uwa�asz, �e strona to b��d\n          skontaktuj si� z administratorem systemu.  W przeciwnym razie, u�yj poni�szego formularza aby wygenerowa� PDF-a metod� ad-hoc.",
    5 => '�adowanie dokumentu.',
    6 => 'Prosz� poczeka� na za�adowanie dokumentu.',
    7 => 'Kliknij prawym przyciskiem myszy i wybierz \'zapisz element docelowy jako...\' lub \'zapisz link...\' aby zachowa� kopi� dokumentu na Twoim komputerze.',
    8 => "The path given in the configuration file to the HTMLDoc binary is invalid or this system cannot execute it.  Please contact the site administrator if this problem\n          persists.",
    9 => 'Generator PDF',
    10 => "This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This\n           is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site",
    11 => 'URL',
    12 => 'Generuj PDF!',
    13 => 'Konfiguracja PHP na tym serwerze nie pozwala na u�ycie URL z komend� fopen().  Administrator systemu musi edytowa� plik php.ini i ustawi� allow_url_fopen na On',
    14 => '��dany PDF albo nie istnieje albo nie masz do niego uprawnie�.'
);

###############################################################################
# trackback.php

$LANG_TRB = array(
    'trackback' => 'Trackback',
    'from' => 'from',
    'tracked_on' => 'Tracked on',
    'read_more' => '[read more]',
    'intro_text' => 'Here\'s what others have to say about \'%s\':',
    'no_comments' => 'No trackback comments for this entry.',
    'this_trackback_url' => 'Trackback URL for this entry:',
    'num_comments' => '%d trackback comments',
    'send_trackback' => 'Send Pings',
    'preview' => 'Preview',
    'editor_title' => 'Send trackback comment',
    'trackback_url' => 'Trackback URL',
    'entry_url' => 'Entry URL',
    'entry_title' => 'Entry Title',
    'blog_name' => 'Site Name',
    'excerpt' => 'Excerpt',
    'truncate_warning' => 'Note: The receiving site may truncate your excerpt',
    'button_send' => 'Send',
    'button_preview' => 'Preview',
    'send_error' => 'Error',
    'send_error_details' => 'Error when sending trackback comment:',
    'url_missing' => 'No Entry URL',
    'url_required' => 'Please enter at least a URL for the entry.',
    'target_missing' => 'No Trackback URL',
    'target_required' => 'Please enter a trackback URL',
    'error_socket' => 'Could not open socket.',
    'error_response' => 'Response not understood.',
    'error_unspecified' => 'Unspecified error.',
    'select_url' => 'Select Trackback URL',
    'not_found' => 'Trackback URL not found',
    'autodetect_failed' => 'Geeklog could not detect the Trackback URL for the post you want to send your comment to. Please enter it manually below.',
    'trackback_explain' => 'From the links below, please select the URL you want to send your Trackback comment to. Geeklog will then try to determine the correct Trackback URL for that post. Or you can <a href="%s">enter it manually</a> if you know it already.',
    'no_links_trackback' => 'No links found. You can not send a Trackback comment for this entry.',
    'pingback' => 'Pingback',
    'pingback_results' => 'Pingback results',
    'send_pings' => 'Send Pings',
    'send_pings_for' => 'Send Pings for "%s"',
    'no_links_pingback' => 'No links found. No Pingbacks were sent for this entry.',
    'pingback_success' => 'Pingback sent.',
    'no_pingback_url' => 'No pingback URL found.',
    'resend' => 'Resend',
    'ping_all_explain' => 'You can now notify the sites you linked to (<a href="http://en.wikipedia.org/wiki/Pingback">Pingback</a>), advertise that your site has been updated by pinging weblog directory services, or send a <a href="http://en.wikipedia.org/wiki/Trackback">Trackback</a> comment in case you wrote about a post on someone else\'s site.',
    'pingback_button' => 'Send Pingback',
    'pingback_short' => 'Send Pingbacks to all sites linked from this entry.',
    'pingback_disabled' => '(Pingback disabled)',
    'ping_button' => 'Send Ping',
    'ping_short' => 'Ping weblog directory services.',
    'ping_disabled' => '(Ping disabled)',
    'trackback_button' => 'Send Trackback',
    'trackback_short' => 'Send a Trackback comment.',
    'trackback_disabled' => '(Trackback disabled)',
    'may_take_a_while' => 'Please note that sending Pingbacks and Pings may take a while.',
    'ping_results' => 'Ping results',
    'unknown_method' => 'Unknown ping method',
    'ping_success' => 'Ping sent.',
    'error_site_name' => 'Please enter the site\'s name.',
    'error_site_url' => 'Please enter the site\'s URL.',
    'error_ping_url' => 'Please enter a valid Ping URL.',
    'no_services' => 'No weblog directory services configured.',
    'services_headline' => 'Weblog Directory Services',
    'service_explain' => 'To modify or delete a weblog directory service, click on the edit icon of that service below. To add a new weblog directory service, click on "Create New" above.',
    'service' => 'Service',
    'ping_method' => 'Ping method',
    'service_website' => 'Website',
    'service_ping_url' => 'URL to ping',
    'ping_standard' => 'Standard Ping',
    'ping_extended' => 'Extended Ping',
    'ping_unknown' => '(unknown method)',
    'edit_service' => 'Edit Weblog Directory Service',
    'trackbacks' => 'Trackbacks',
    'editor_intro' => 'Prepare your trackback comment for <a href="%s">%s</a>.',
    'editor_intro_none' => 'Prepare your trackback comment.',
    'trackback_note' => 'To send a trackback comment for a story, go to the list of stories and click on "Send Ping" for the story. To send a trackback that is not related to a story, <a href="%s">click here</a>.',
    'pingback_explain' => 'Enter a URL to send the Pingback to. The pingback will point to your site\'s homepage.',
    'pingback_url' => 'Pingback URL',
    'site_url' => 'This site\'s URL',
    'pingback_note' => 'To send a pingback for a story, go to the list of stories and click on "Send Ping" for the story. To send a pingback that is not related to a story, <a href="%s">click here</a>.',
    'pbtarget_missing' => 'No Pingback URL',
    'pbtarget_required' => 'Please enter a pingback URL',
    'pb_error_details' => 'Error when sending the pingback:',
    'delete_trackback' => 'To delete this Trackback click: '
);

###############################################################################
# directory.php

$LANG_DIR = array(
    'title' => 'Article Directory',
    'title_year' => 'Article Directory for %d',
    'title_month_year' => 'Article Directory for %s %d',
    'nav_top' => 'Back to Article Directory',
    'no_articles' => 'No articles.'
);

###############################################################################
# "What's New" Time Strings
# 
# For the first two strings, you can use the following placeholders.
# Order them so it makes sense in your language:
# %i    item, "Stories"
# %n    amount, "2", "20" etc.
# %t    time, "2" (weeks)
# %s    scale, "hrs", "weeks"

$LANG_WHATSNEW = array(
    'new_string' => '%n new %i in the last %t %s',
    'new_last' => 'last %t %s',
    'minutes' => 'minutes',
    'hours' => 'hours',
    'days' => 'days',
    'weeks' => 'weeks',
    'months' => 'months',
    'minute' => 'minute',
    'hour' => 'hour',
    'day' => 'day',
    'week' => 'week',
    'month' => 'month'
);

###############################################################################
# Month names

$LANG_MONTH = array(
    1 => 'Stycze�',
    2 => 'Luty',
    3 => 'Marzec',
    4 => 'Kwiecie�',
    5 => 'Maj',
    6 => 'Czerwiec',
    7 => 'Lipiec',
    8 => 'Sierpie�',
    9 => 'Wrzesie�',
    10 => 'Pa�dziernik',
    11 => 'Listopad',
    12 => 'Grudzie�'
);

###############################################################################
# Weekdays

$LANG_WEEK = array(
    1 => 'Niedziela',
    2 => 'Poniedzia�ek',
    3 => 'Wtorek',
    4 => '�roda',
    5 => 'Czwartek',
    6 => 'Pi�tek',
    7 => 'Sobota'
);

###############################################################################
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array(
    'search' => 'Search',
    'limit_results' => 'Limit Results',
    'submit' => 'Submit',
    'edit' => 'Edit',
    'edit_adv' => 'Adv. Edit',
    'admin_home' => 'Admin Home',
    'create_new' => 'Create New',
    'create_new_adv' => 'Create New (Adv.)',
    'enabled' => 'Enabled',
    'title' => 'Title',
    'type' => 'Type',
    'topic' => 'Topic',
    'help_url' => 'Help File URL',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'delete_sel' => 'Delete selected',
    'copy' => 'Copy',
    'no_results' => '- No entries found -',
    'data_error' => 'There was an error processing the subscription data. Please check the data source.',
    'preview' => 'Preview',
    'records_found' => 'Records found'
);

###############################################################################
# Localisation of the texts for the various drop-down menus that are actually
# stored in the database. If these exist, they override the texts from the
# database.

$LANG_commentcodes = array(
    0 => 'Comments Enabled',
    -1 => 'Comments Disabled'
);


$LANG_commentmodes = array(
    'flat' => 'Flat',
    'nested' => 'Nested',
    'threaded' => 'Threaded',
    'nocomment' => 'No Comments'
);

$LANG_cookiecodes = array(
    0 => '(don\'t)',
    3600 => '1 Hour',
    7200 => '2 Hours',
    10800 => '3 Hours',
    28800 => '8 Hours',
    86400 => '1 Day',
    604800 => '1 Week',
    2678400 => '1 Month'
);

$LANG_dateformats = array(
    0 => 'System Default'
);

$LANG_featurecodes = array(
    0 => 'Not Featured',
    1 => 'Featured'
);

$LANG_frontpagecodes = array(
    0 => 'Show Only in Topic',
    1 => 'Show on Front Page'
);

$LANG_postmodes = array(
    'plaintext' => 'Plain Old Text',
    'html' => 'HTML Formatted'
);

$LANG_sortcodes = array(
    'ASC' => 'Oldest First',
    'DESC' => 'Newest First'
);

$LANG_trackbackcodes = array(
    0 => 'Trackback Enabled',
    -1 => 'Trackback Disabled'
);

?>