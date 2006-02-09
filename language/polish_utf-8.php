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

$LANG_CHARSET = 'UTF-8';

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
    5 => 'G³osuj',
    6 => 'Wyniki',
    7 => 'Wyniki Sondy',
    8 => 'g³osów',
    9 => 'Menu Admina:',
    10 => 'Panel Sterowania',
    11 => 'Artyku³y',
    12 => 'Bloki',
    13 => 'Sekcje',
    14 => 'Linki',
    15 => 'Wydarzenia',
    16 => 'Sondy',
    17 => 'U¿ytkownicy',
    18 => 'Zapytanie SQL',
    19 => 'Wyloguj',
    20 => 'Informacje U¿ytkownika:',
    21 => 'Login',
    22 => 'ID U¿ytkownika',
    23 => 'Poziom Zabezpieczeñ',
    24 => 'Gall Anonim',
    25 => 'Komentuj',
    26 => 'Komentarze nale¿± do osób, które je zamie¶ci³y. Nie bierzemy odpowiedzialno¶ci za ich tre¶æ.',
    27 => 'Najnowsze Komentarze',
    28 => 'Kasuj',
    29 => 'Komentarzy Brak.',
    30 => 'Starsze Artyku³y',
    31 => 'Dozwolone Znaczniki HTML:',
    32 => 'B³±d, niew³a¶ciwy login',
    33 => 'B³±d, nie mo¿na zapisaæ w logu',
    34 => 'B³±d',
    35 => 'Wyloguj',
    36 => 'dnia',
    37 => 'Brak artyku³ów u¿ytkownika',
    38 => 'Syndykacja Tre¶ci',
    39 => 'Od¶wie¿',
    40 => 'Masz <tt>register_globals = Off</tt> w pliku <tt>php.ini</tt>. Niestety, Geeklog wymaga <tt>register_globals</tt> aby by³y ustawione na <strong>on</strong>. Proszê zminieæ ustawienia na <strong>on</strong> i restartowaæ serwer www.',
    41 => 'Go¶æ',
    42 => 'Autor:',
    43 => 'Odpowiedz',
    44 => 'G³ówny',
    45 => 'Numer B³êdu MySQL',
    46 => 'Numer Komunikatu B³êdu MySQL',
    47 => 'Menu U¿ytkownika',
    48 => 'Konto - Info',
    49 => 'Osobiste',
    50 => 'B³êdna sk³adnia SQL',
    51 => 'pomoc',
    52 => 'Nowy',
    53 => 'Panel Sterowania',
    54 => 'Nie mo¿na otworzyæ pliku.',
    55 => 'B³±d przy',
    56 => 'G³osuj',
    57 => 'Has³o',
    58 => 'Login',
    59 => "Nie masz jeszcze konta? Za³ó¿ sobie <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Nowy U¿ytkownik</a>",
    60 => 'Komentarze',
    61 => 'Za³ó¿ Konto',
    62 => 's³ów',
    63 => 'Komentarze - Preferencje',
    64 => 'Wy¶lij Znajomemu',
    65 => 'Wersja do Wydruku',
    66 => 'Mój Kalendarz',
    67 => 'Witaj w Serwisie ',
    68 => 'strona g³ówna',
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
    80 => 'artyku³ów w ost.',
    81 => 'artyku³ w ost.',
    82 => 'godz',
    83 => 'KOMENTARZE',
    84 => 'LINKI',
    85 => 'wygasaj± po 48 h',
    86 => 'Brak nowych komentarzy',
    87 => 'wygasaj± po 2 tyg',
    88 => 'Brak nowych linków',
    89 => '¯adnych wydarzeñ w najbli¿szym czasie',
    90 => 'Strona G³ówna',
    91 => 'Strona wygenerowana w ',
    92 => 'sekund',
    93 => 'Prawa Autorskie',
    94 => 'Wszelkie znaki handlowe i prawa autorskie nale¿± do ich w³a¶cicieli.',
    95 => 'Wersja',
    96 => 'Grupy',
    97 => 'Lista S³ów',
    98 => 'Pluginy',
    99 => 'ARTYKU£Y',
    100 => 'Brak nowych artyku³ów',
    101 => 'Twoje Wydarzenia',
    102 => 'Wydarzenia na Serwisie',
    103 => 'Kopie zapasowe bazy',
    104 => 'przez',
    105 => 'Wy¶lij Maila',
    106 => 'Ods³on',
    107 => 'Wersja GL - Test',
    108 => 'Opró¿nij Cache',
    109 => 'Zg³o¶ nadu¿ycie',
    110 => 'Powiadom administratora o tym wpisie',
    111 => 'Wersja PDF',
    112 => 'Zarejestrowani U¿ytkownicy',
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
    123 => 'All HTML is allowed'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Kalendarz Wydarzeñ',
    2 => 'Sorry, brak wydarzeñ.',
    3 => 'Kiedy',
    4 => 'Gdzie',
    5 => 'Opis',
    6 => 'Dodaj Wydarzenie',
    7 => 'Zbli¿aj±ce siê Wydarzenia',
    8 => 'Przez dodanie tego wydarzenie do swojego kalendarza mo¿esz szybko przegl±daæ interesuj±ce ciê wydarzenia klikaj±c "Mój Kalendarz" z poziomu Menu U¿ytkownika.',
    9 => 'Dodaj do Mojego Kalendarza',
    10 => 'Usuñ z Mojego Kalendarza',
    11 => "Dodawanie Wydarzenia do Kalendarza {$_USER['username']}",
    12 => 'Wydarzenie',
    13 => 'Rozpoczêcie',
    14 => 'Zakoñczenie',
    15 => 'Powrót do Kalendarza'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Napisz Komentarz',
    2 => 'Format',
    3 => 'Wyloguj',
    4 => 'Za³ó¿ Konto',
    5 => 'Login',
    6 => 'Aby zamie¶ciæ komentarz nale¿y siê zalogowaæ.  Je¶li nie masz jeszcze konta, za³ó¿ sobie u¿ywaj±c poni¿szego formularza.',
    7 => 'Ostatni komentarz zamie¶ci³e¶ ',
    8 => " sekund temu.  Wymagana jest przerwa równa {$_CONF['commentspeedlimit']} sekund pomiêdzy komentarzami",
    9 => 'Komentarz',
    10 => 'Wy¶lij Raport',
    11 => 'Wy¶lij Komentarz',
    12 => 'Proszê uzupe³niæ pola Tytu³ i Komentarz. Pola te s± wymagane do zamieszczenia komentarza.',
    13 => 'Twoje Informacje',
    14 => 'Podgl±d',
    15 => 'Zg³o¶ t± wiadomo¶æ',
    16 => 'Tytu³',
    17 => 'B³±d',
    18 => 'Wa¿ne Informacje',
    19 => 'Proszê staraæ siê nie odbiegaæ od tematu.',
    20 => 'Proszê raczej odpowiadaæ na zamieszczane komentarze innych u¿ytkowników zamiast rozpoczynania nowych w±tków.',
    21 => 'Aby unikn±æ powtarzania, zanim zamie¶cisz swój komentarz przeczytaj co napisali inni.',
    22 => 'Wpisz temat adekwatny do tre¶ci wiadomo¶ci.',
    23 => 'Twój adres email nie bêdzie ujawniony.',
    24 => 'Gall Anonim',
    25 => 'Czy chcesz zg³osiæ administratorowi ten komentarz?',
    26 => '%s zg³osi³ nastêpuj±cy komentarz:',
    27 => 'Raport nadu¿yæ'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Profil U¿ytkownika',
    2 => 'Login',
    3 => 'Nazwa',
    4 => 'Has³o',
    5 => 'Email',
    6 => 'Strona Domowa',
    7 => 'O Sobie',
    8 => 'Klucz PGP',
    9 => 'Zapisz Informacje',
    10 => 'Ostatnie 10 komentarzy u¿ytkownika',
    11 => 'Brak Komentarzy U¿ytkownika',
    12 => 'Preferencje U¿ytkownika',
    13 => 'Email Nightly Digest',
    14 => 'Has³o jest generowane automatycznie. Zalecana jest szybka zmiana has³a. Aby zmieniæ has³o, nale¿y siê zalogowaæ a nastêpnie klikn±æ na Konto Info w Menu U¿ytkownika.',
    15 => "Twoje {$_CONF['site_name']} konto zosta³o za³o¿one. Zaloguj siê wykorzystuj±c informacje poni¿ej. Proszê zachowaæ tego maila w bezpiecznym miejscu.",
    16 => 'Informacje Dotycz±ce Twojego Konta',
    17 => 'Konto nie istnieje',
    18 => 'Podany adres email nie jest prawid³owy',
    19 => 'Podany login lub adres email ju¿ istnieje',
    20 => 'Podany adres email nie jest prawid³owy',
    21 => 'B³±d',
    22 => "Zarejestruj siê w serwisie {$_CONF['site_name']}!",
    23 => "Konto w serwisie {$_CONF['site_name']} pozwoli ci zamieszczaæ komentarze i inne pozycje w twoim imieniu. Brak konta umo¿liwia tylko zamieszczanie jako anonim. Twój adres email <b><i>nigdy</i></b> nie bêdzie widoczny publicznie.",
    24 => 'Twoje has³o zostanie wys³ane pod podany adres email.',
    25 => 'Zapomnia³e¶/a¶ has³o?',
    26 => 'Wpisz <em>albo</em> swój login <em>albo</em> adres email podany podczas rejestracji i kliknij Prze¶lij Has³o. Instrukcje jak ustawiæ nowe has³o zostan± wys³ane do Ciebie mailem.',
    27 => 'Zarejestruj Siê!',
    28 => 'Prze¶lij Has³o',
    29 => 'wylogowany z adresu',
    30 => 'zalogowany z adresu',
    31 => 'Wybrana funkcja wymaga wcze¶niejszego zalogowania',
    32 => 'Podpis',
    33 => 'Niewidoczne dla publiki',
    34 => 'Twoje prawdziwe imiê',
    35 => 'Wpisz nowe has³o',
    36 => 'Pocz±tek od http://',
    37 => 'Zastosowane do twoich komentarzy',
    38 => 'Wszystko o tobie! Ka¿dy mo¿e to przeczytaæ',
    39 => 'Twój publiczny klucz PGP dla wszystkich',
    40 => 'Bez Ikon Sekcji',
    41 => 'Chêtny/a do Zatwierdzania Materia³ów',
    42 => 'Format Daty',
    43 => 'Artyku³y Max Ilo¶æ',
    44 => 'Bez bloków',
    45 => 'Wygl±d - Ustawienia U¿ytkownika',
    46 => 'Wy³±czone Pozycje U¿ytkownika',
    47 => 'Konfiguracja Bloków z Nowo¶ciami U¿ytkownika',
    48 => 'Sekcje',
    49 => 'Bez ikon w artyku³ach',
    50 => 'Odznacz je¶li nie jeste¶ zainteresowany',
    51 => 'Tylko nowe artyku³y',
    52 => 'Domy¶lnie jest',
    53 => 'Otrzymujesz nowe artyku³y co wieczór',
    54 => 'Zaznacz sekcje i autorów, których nie chcesz ogl±daæ.',
    55 => 'Je¶li nic nie zaznaczysz oznacza to, ¿e akceptujesz domy¶ln± konfiguracjê. Przy zaznaczaniu wybranych bloków domy¶lne ustawienie jest anulowane. Nazwy bloków objêtych domy¶lnym ustawieniem s± pogrubione.',
    56 => 'Autorzy',
    57 => 'Wy¶wietlanie',
    58 => 'Sortowanie wg',
    59 => 'Limit Komentarzy',
    60 => 'Jak chcesz wy¶wietlaæ swoje komentarze?',
    61 => 'Od najnowszych czy od najstarszych?',
    62 => 'Domy¶lnie jest 100',
    63 => "Has³o zosta³o wys³ane i powinno wkrótce do ciebie dotrzeæ. Postêpuj zgodnie ze wskazówkami w wiadomo¶ci. Dziêkujemy za korzystanie z serwisu {$_CONF['site_name']}",
    64 => 'Komentarze - Ustawienia U¿ytkownika',
    65 => 'Spróbuj Zalogowaæ siê Ponownie',
    66 => "Byæ mo¿e login zosta³ b³êdnie wpisany.  Spróbuj zalogowaæ siê ponownie. Czy jeste¶ <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nowym u¿ytkownikiem</a>?",
    67 => 'Cz³onkowstwo Od',
    68 => 'Pamiêtaj Mnie Przez',
    69 => 'Jak d³ugo pamiêtaæ ciê po zalogowaniu?',
    70 => "Dostosuj wygl±d i zawarto¶æ serwisu {$_CONF['site_name']}",
    71 => "Jedn± z extra mo¿liwo¶ci serwisu {$_CONF['site_name']} jest mo¿liwo¶æ dopasowania zawarto¶ci i wygl±du strony.  Aby skorzystaæ z tych udogodnieñ nale¿y siê najpierw <a href=\"{$_CONF['site_url']}/users.php?mode=new\">zarejestrowaæ</a> w serwisie {$_CONF['site_name']}.  Jeste¶ ju¿ cz³onkiem?  Zaloguj siê!",
    72 => 'Pulpit',
    73 => 'Jêzyk',
    74 => 'Zmieñ wygl±d strony!',
    75 => 'Artyku³y Wysy³ane Mailem do',
    76 => 'Je¿eli zaznaczysz jak±¶ sekcjê z poni¿szej listy bêdziesz, pod koniec ka¿dego dnia, otrzymywa³ nowe artyku³y zamieszczone w tej sekcji. Zaznacz sekcje, które ciê interesuj±!',
    77 => 'Zdjêcie',
    78 => 'Dodaj swoje zdjêcie!',
    79 => 'Zaznacz tutaj aby wykasowaæ to zdjêcie',
    80 => 'Logowanie',
    81 => 'Wy¶lij Maila',
    82 => '10 najnowszych artyku³ów u¿ytkownika',
    83 => 'Materia³y zamieszczone przez u¿ytkownika',
    84 => 'Wszystkich artyku³ów:',
    85 => 'Wszystkich komentarzy:',
    86 => 'Znajd¼ wszystkie materia³y zamieszczone przez',
    87 => 'Twój login',
    88 => "Kto¶ (prawdopodobnie Ty) chce uzyskaæ nowe has³o do tego konta \"%s\" w {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nJe¶li chcesz kontynuowaæ proszê kliknij ten link:\n\n",
    89 => "Je¶li nie chcesz kontynuowaæ, zignoruj t± wiadomo¶æ (Twoje has³o pozostanie niezmienione).\n\n",
    90 => 'Poni¿ej mo¿esz wprowadziæ nowe has³o. Pamiêtaj, ¿e stare has³o jest aktywne do czasu przes³ania tego zg³oszenia.',
    91 => 'Ustaw Nowe Has³o',
    92 => 'Wpisz Nowe Has³o',
    93 => 'Twoja ostatnia pro¶ba o zmianê has³a by³a wys³ana %d sekund temu. Wymagana jest przerwa co najmniej %d sekundowa pomiêdzy takimi zg³oszeniami.',
    94 => 'Kasuj Konto "%s"',
    95 => 'Kliknij poni¿szy przycisk "kasuj konto" aby usun±æ swoje konto z bazy danych. Proszê mieæ na uwadze, ¿e wszelkie artyku³y i komentarze, zamieszczone przez Ciebie <strong>nie</strong> zostan± usuniête ale autor zmieni siê na "Gall Anonim".',
    96 => 'kasuj konto',
    97 => 'Potwierd¼ Usuniêcie Konta',
    98 => 'Czy aby napewno chcesz usun±æ swoje konto? Po skasowaniu konta nie bêdzie mo¿na siê ponownie zalogowaæ na tej stronie (chyba, ¿e za³o¿ysz nowe konto). Je¶li tego chcesz kliknij ponownie "kasuj konto" w poni¿szym formularzu.',
    99 => 'Ochrona Prywatno¶ci dla',
    100 => 'Email od Admina',
    101 => 'TAK na emaile od Admina',
    102 => 'Email od U¿ytkowników',
    103 => 'TAK na emaile od innych u¿ytkowników',
    104 => 'Poka¿ Status Online',
    105 => 'Poka¿ w bloku Who\'s Online',
    106 => 'Lokalizacja',
    107 => 'Poka¿ w swoim publicznym profilu',
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
    123 => "Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?"
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Brak Nowo¶ci',
    2 => 'Brak nowych artyku³ów.  Byæ mo¿e nie ma nowych artyku³ów w danej sekcji lub twoje ustawienia s± zbyt limituj±ce.',
    3 => 'dla sekcji %s',
    4 => 'Dzisiejszy Artyku³ Dnia',
    5 => 'Nastêpny',
    6 => 'Poprzedni',
    7 => 'Pierwszy',
    8 => 'Ostatni'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Wyst±pi³ b³±d podczas wysy³ania wiadomo¶ci. Spróbuj ponownie.',
    2 => 'Wiadomo¶æ wys³ano.',
    3 => 'Proszê siê upewniæ, ¿e adres email wpisany w pole Odpowiedz Do jest prawid³owy.',
    4 => 'Proszê siê Przedstawiæ, wpisaæ Odpowiedz Do, Temat i Wiadomo¶æ',
    5 => 'B³±d: Nie ma takiego u¿ytkownika.',
    6 => 'Wyst±pi³ b³±d.',
    7 => 'Profil U¿ytkownika',
    8 => 'U¿ytkownik',
    9 => 'URL U¿ytkownika',
    10 => 'Wy¶lij maila do',
    11 => 'Przedstaw Siê:',
    12 => 'Twój email:',
    13 => 'Temat:',
    14 => 'Wiadomo¶æ:',
    15 => 'Bez znaczników HTML.',
    16 => 'Wy¶lij',
    17 => 'Wy¶lij Znajomemu',
    18 => 'Do (twój znajomy)',
    19 => 'Jego/Jej Adres Email',
    20 => 'Od (Przedstaw siê;-)',
    21 => 'Twój Adres Email',
    22 => 'Nale¿y wype³niæ wszystkie pola',
    23 => "Tego maila wys³a³ %s (%s) z my¶l±, ¿e mo¿e ciê zainteresowaæ poni¿szy artyku³ z serwisu {$_CONF['site_url']}.  To nie jest SPAM a u¿yte adresy email nie zosta³y nigdzie zapisane celem ich pó¼niejszego wykorzystania.",
    24 => 'Skomentuj ten artyku³ tutaj',
    25 => 'Przed u¿yciem tej opcji musisz siê zalogowaæ.  Pozwoli nam to zabezpieczyæ system przed niew³a¶ciwym wykorzystaniem',
    26 => 'Ten formularz umo¿liwia wys³anie maila do wybranego u¿ytkownika.  Wymagane jest wype³nienie wszystkich pól.',
    27 => 'Krótka Wiadomo¶æ',
    28 => '%s napisa³: ',
    29 => "Dzienne zestawienie artyku³ów w Serwisie {$_CONF['site_name']} z dnia ",
    30 => 'Newsletter z dnia ',
    31 => 'Tytu³',
    32 => 'Data',
    33 => 'Ca³y artyku³ dostêpny tutaj ',
    34 => 'Koniec Wiadomo¶ci',
    35 => 'Sorry, ale ten u¿ytkownik nie ¿yczy sobie otrzymywania ¿adnych emaili.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Wyszukiwanie Zaawansowane',
    2 => 'S³owa Kluczowe',
    3 => 'Sekcja',
    4 => 'Wszystko',
    5 => 'Gdzie',
    6 => 'Artyku³y',
    7 => 'Komentarze',
    8 => 'Autorzy',
    9 => 'Wszystko',
    10 => 'Szukaj',
    11 => 'Wyniki',
    12 => 'trafienia',
    13 => 'Wyniki: Brak danych',
    14 => 'Nie znaleziono ¿adnych danych spe³niaj±cych twoje kryteria',
    15 => 'Proszê spróbowaæ ponownie.',
    16 => 'Tytu³',
    17 => 'Data',
    18 => 'Autor',
    19 => "Przeszukuje ca³± bazê artyku³ów i komentarzy {$_CONF['site_name']} ",
    20 => 'Data',
    21 => 'do',
    22 => '(Format Daty RRRR-MM-DD)',
    23 => 'Ods³on',
    24 => 'Znaleziono %d pozycji',
    25 => 'Szukano',
    26 => 'pozycji ',
    27 => 'sekund',
    28 => 'Brak artyku³ów lub komentarzy których szukasz',
    29 => 'Artyku³y i Komentarze - Wyniki',
    30 => 'Brak linków spe³niaj±cych twoje kryteria wyszukiwania',
    31 => 'Nie znaleziono ¿adnych pluginów',
    32 => 'Wydarzenie',
    33 => 'URL',
    34 => 'Lokalizacja',
    35 => 'Ca³y Dzieñ',
    36 => 'Brak wydarzeñ spe³niaj±cych twoje kryteria wyszukiwania',
    37 => 'Wydarzenia - Wyniki',
    38 => 'Linki - Wyniki',
    39 => 'Linki',
    40 => 'Wydarzenia',
    41 => 'Twoje zapytanie powinno zawieraæ co najmniej 3 znaki.',
    42 => 'Proszê u¿ywaæ nastêpuj±cego formatu daty: RRRR-MM-DD (rok-miesi±c-dzieñ).',
    43 => 'z wyra¿eniem',
    44 => 'ze wszystkimi s³owami',
    45 => 'z którymkolwiek ze s³ów',
    46 => 'Dalej',
    47 => 'Wstecz',
    48 => 'Autor',
    49 => 'Data',
    50 => 'Ods³on',
    51 => 'Link',
    52 => 'Lokalizacja',
    53 => 'Artyku³y - Wyniki',
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
    3 => 'Artyku³ów(Komentarzy) w Serwisie',
    4 => 'Sondy(G³osy) w Serwisie',
    5 => 'Linki(Klikniêcia) w Serwisie',
    6 => 'Wydarzenia w Serwisie',
    7 => '10 Najpopularniejszych Artyku³ów',
    8 => 'Tytu³ Artyku³u',
    9 => 'Ods³on',
    10 => 'Wygl±da na to, ¿e w tym serwisie nie ma ¿adnych artyku³ów albo nikt nigdy ¿adnego nie przeczyta³.',
    11 => '10 Najczê¶ciej Komentowanych Artyku³ów',
    12 => 'Komentarzy',
    13 => 'Wygl±da na to, ¿e w tym serwisie nie ma ¿adnych artyku³ów albo nikt nigdy nie skomentowa³ ¿adnego.',
    14 => '10 Najpopularniejszych Sond',
    15 => 'Pytanie Sondy',
    16 => 'G³osów',
    17 => 'Wygl±da na to, ¿e w tym serwisie nie ma ¿adnych sond albo nikt nigdy nie odda³ ¿adnego g³osu.',
    18 => '10 Najpopularniejszych Linków',
    19 => 'Linki',
    20 => 'Wej¶æ',
    21 => 'Wygl±da na to, ¿e w tym serwisie nie ma ¿adnych linków albo nikt nigdy nie klikn±³ na ¿aden z nich.',
    22 => '10 Najczê¶ciej Emaliowanych Artyku³ów',
    23 => 'Emaile',
    24 => 'Wygl±da na to, ¿e nikt nie przes³a³ swoim znajomym ¿adnego artyku³u',
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
    1 => 'Odno¶niki',
    2 => 'Wy¶lij Znajomemu',
    3 => 'Wersja Do Wydruku',
    4 => 'Opcje Artyku³u',
    5 => 'Format PDF'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Aby przes³aæ %s musisz siê wcze¶niej zalogowaæ.',
    2 => 'Login',
    3 => 'Nowy U¿ytkownik',
    4 => 'Prze¶lij Wydarzenie',
    5 => 'Prze¶lij Linka',
    6 => 'Prze¶lij Artyku³',
    7 => 'Wymagany jest Login',
    8 => 'Prze¶lij',
    9 => 'Przy przesy³aniu informacji do tego serwisu, prosimy postêpowaæ wg poni¿szych wskazówek...<ul><li>Nale¿y wype³niæ wszystkie pola<li>Zamie¶ciæ pe³n± i poprawn± informacjê<li>Sprawdziæ dok³adnie podawane adresy</ul>',
    10 => 'Tytu³',
    11 => 'Link',
    12 => 'Data Pocz±tkowa',
    13 => 'Data Koñcowa',
    14 => 'Lokalizacja',
    15 => 'Opis',
    16 => 'Je¶li Inne, podaj jaka',
    17 => 'Kategoria',
    18 => 'Inne',
    19 => 'Przeczytaj Uwa¿nie',
    20 => 'B³±d: Brak Kategorii',
    21 => 'Wybieraj±c "Inne" wpisz nazwê kategorii',
    22 => 'B³±d: Puste Pola',
    23 => 'Wymagane jest wype³nienie wszystkich pól formularza.',
    24 => 'Zapisano',
    25 => 'Twój materia³ %s zosta³ zapisany.',
    26 => 'Limit Czasowy',
    27 => 'Login',
    28 => 'Sekcja',
    29 => 'Artyku³',
    30 => 'Ostatni raz przesy³a³e¶ ',
    31 => " sekund temu.  Wymagane jest co najmniej {$_CONF['speedlimit']} sekund przerwy pomiêdzy zamieszczeniami",
    32 => 'Podgl±d',
    33 => 'Podgl±d Artyku³u',
    34 => 'Wyloguj',
    35 => 'Znaczniki HTML nie s± dozwolone',
    36 => 'Format',
    37 => "Przes³ane wydarzenie do serwisu {$_CONF['site_name']} zostanie umieszczone w Kalendarzu G³ównym, z którego u¿ytkownicy bêd± mieli mo¿liwo¶æ dodawanie wydarzeñ do kalendarzy osobistych. Ta opcja <b>NIE S£U¯Y</b> do przechowywania informacji osobistych takich jak urodziny itp.<br><br>Po przes³aniu wydarzenia, zostanie ono przes³ane do naszych administratorów i po zatwierdzeniu pojawi siê w Kalendarzu G³ównym.",
    38 => 'Dodaj Wydarzenie do',
    39 => 'Kalendarz G³ówny',
    40 => 'Kalendarz Osobisty',
    41 => 'Koniec',
    42 => 'Pocz±tek',
    43 => 'Ca³y Dzieñ',
    44 => 'Adres 1',
    45 => 'Adres 2',
    46 => 'Miasto/Miejscowo¶æ',
    47 => 'Województwo',
    48 => 'Kod Pocztowy',
    49 => 'Kategoria Wydarzenia',
    50 => 'Edytuj Kategorie Wydarzeñ',
    51 => 'Lokalizacja',
    52 => 'Kasuj',
    53 => 'Za³ó¿ Konto'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Wymagana jest Autoryzacja',
    2 => 'Odmowa! Niew³a¶ciwy Login',
    3 => 'Niew³a¶ciwe has³o u¿ytkownika',
    4 => 'Login:',
    5 => 'Has³o:',
    6 => 'Wszelkie próby wej¶cia do segmentów administracyjnych s± logowane i weryfikowane.<br>Dostêp tylko dla osób upowa¿nionych.',
    7 => 'login'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Niewystarczaj±ce Uprawnienia Administracyjne',
    2 => 'Nie masz wystarczaj±cych uprawnieñ do edycji tego bloku.',
    3 => 'Edytor Bloków',
    4 => 'Wyst±pi³ b³±d odczytu (szczegó³y w pliku error.log).',
    5 => 'Tytu³ Bloku',
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
    17 => 'Zawarto¶æ Bloku',
    18 => 'Proszê wpisaæ Tytu³ Bloku, Poziom Zabezpieczenia i pola Zawarto¶ci',
    19 => 'Menad¿er Bloków',
    20 => 'Tytu³ Bloku',
    21 => 'PozZab Bloku',
    22 => 'Rodzaj Bloku',
    23 => 'Numer Bloku',
    24 => 'Sekcja Bloku',
    25 => 'Aby zmodyfikowaæ lub wykasowaæ blok kliknij na blok poni¿ej.  Aby stworzyæ nowy blok kliknij Nowy Blok powy¿ej.',
    26 => 'Blok Schematowy',
    27 => 'Blok PHP',
    28 => 'Opcje Bloku PHP',
    29 => 'Funkcje Bloku',
    30 => 'Je¶li chcesz aby twój blok obs³ugiwa³ kod PHP, wpisz nazwê funkcji powy¿ej.  Nazwa funkcji musi rozpoczynaæ siê prefiksem "phpblock_" (np. phpblock_getweather).  Je¿eli nie bêdzie prefiksu, twoja funkcja NIE zostanie wywo³ana.  Zwi±zane jest to z uniemo¿liwieniem \'wrzucania\' skryptów przez hakerów, które mog± uszkodziæ twój system.  Upewnij siê, ¿e nie ma pustych nawiasów "()" po nazwie funkcji.  Na koniec, zalecamy umieszczenie ca³ego kodu PHP Block w /¶cie¿ka/do/geeklog/system/lib-custom.php.  Pozwoli to na zachowanie wersji kodu bez zmian nawet przy aktualizacji Geekloga.',
    31 => 'B³±d w Bloku PHP.  Funkcja, %s, nie istnieje.',
    32 => 'B³±d. Puste pole(a)',
    33 => 'Musisz wpisaæ URL do pliku .rdf dla bloków portalowych',
    34 => 'Musisz wpisaæ tytu³ i funkcjê bloków PHP',
    35 => 'Musisz wpisaæ tytu³ i zawarto¶æ dla bloków normalnych',
    36 => 'Musisz wpisaæ zawarto¶æ bloków schematowych',
    37 => 'Nieprawid³owa nazwa funkcji bloku PHP',
    38 => 'Funkcje dla Bloków PHP musz± mieæ prefiks \'phpblock_\' (np. phpblock_getweather).  Prefiks \'phpblock_\' ze wzglêdów bezpieczeñstwa aby unikn±æ wykonywanie kodu.',
    39 => 'Strona',
    40 => 'Lewa',
    41 => 'Prawa',
    42 => 'Musisz wpisaæ porz±dek bloku i poziom zabezpieczeñ dla domy¶lnych bloków Geekloga',
    43 => 'Tylko Strona G³ówna',
    44 => 'Odmowa Dostêpu',
    45 => "Próbujesz wyedytowaæ blok, do którego nie masz uprawnieñ.  Ta próba zosta³a zapisana w logu. Proszê <a href=\"{$_CONF['site_admin_url']}/block.php\">wróciæ do ekranu administrowania blokami</a>.",
    46 => 'Nowy Blok',
    47 => 'Panel Sterowania',
    48 => 'Nazwa Bloku',
    49 => ' (nazwa unikalna i bez spacji)',
    50 => 'URL Pliku Pomocy',
    51 => 'uwzglêdnij http://',
    52 => 'Je¶li zostawisz puste, ikona pomocy dla tego bloku siê nie pojawi',
    53 => 'Aktywne',
    54 => 'zapisz',
    55 => 'anuluj',
    56 => 'kasuj',
    57 => 'Przesuñ Blok w Dó³',
    58 => 'Przesuñ Blok w Górê',
    59 => 'Przesuñ blok na prawo',
    60 => 'Przesuñ blok w lewo',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Edytor Wydarzeñ',
    2 => 'Error',
    3 => 'Tytu³ Wydarzenia',
    4 => 'URL Wydarzenia',
    5 => 'Data Pocz±tkowa Wydarzenia',
    6 => 'Data Koñcowa Wydarzenia',
    7 => 'Miejsce Wydarzenia',
    8 => 'Opis Wydarzenia',
    9 => '(uwzglêdnij http://)',
    10 => 'Nale¿y wpisaæ datê, godzinê, tytu³ i opis wydarzenia!',
    11 => 'Menad¿er Wydarzeñ',
    12 => 'Aby zmodyfikowaæ lub wykasowaæ wydarzenie kliknij na dane wydarzenie poni¿ej.  Aby wpisaæ nowe wydarzenie kliknij na Nowe Wydarzenie powy¿ej. Kliknij [C] aby wykonaæ kopiê istniej±cego wydarzenia.',
    13 => 'Tytu³ Wydarzenia',
    14 => 'Data Poczkowa',
    15 => 'Data Koñcowa',
    16 => 'Odmowa Dostêpu',
    17 => "Próbujesz wyedytowaæ wydarzenie, do którego nie masz dostêpu.  Ta próba zosta³a zapisana w logu. Proszê <a href=\"{$_CONF['site_admin_url']}/event.php\">wróciæ do ekranu administrowania wydarzeniami</a>.",
    18 => 'Nowe Wydarzenie',
    19 => 'Panel Sterowania',
    20 => 'zapisz',
    21 => 'anuluj',
    22 => 'kasuj',
    23 => 'Z³a data poczatkowa.',
    24 => 'Z³± data koñcowa.',
    25 => 'Data koñcowa jest wcze¶niejsza od pocz±tkowej.'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Poprzednie Artyku³y',
    2 => 'Nastêpne Artyku³y',
    3 => 'Tryb',
    4 => 'Format',
    5 => 'Edytor Artyku³ów',
    6 => 'Brak artyku³ów w systemie',
    7 => 'Autor',
    8 => 'zapisz',
    9 => 'podgl±d',
    10 => 'anuluj',
    11 => 'kasuj',
    12 => 'ID',
    13 => 'Tytu³',
    14 => 'Sekcja',
    15 => 'Data',
    16 => 'Wstêp',
    17 => 'Czê¶æ G³ówna',
    18 => 'Wej¶æ',
    19 => 'Komentarze',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Lista Artyku³ów',
    23 => 'Aby zmodyfikowaæ lub wykasowaæ artyku³, kliknij na numer danego artyku³u poni¿ej. Aby przegl±dn±æ artyku³ kliknij na tytu³ danego artyku³u. Aby wpisaæ nowy artyku³ kliknij na Nowy Artyku³ powy¿ej.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Podgl±d Artyku³u',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'B³±d Uploadu Pliku',
    31 => 'Proszê wpisaæ Tytu³ i Wstêp',
    32 => 'Artyku³ Dnia',
    33 => 'Artyku³ Dnia mo¿e byæ tylko jeden',
    34 => 'Wersja Robocza',
    35 => 'Tak',
    36 => 'Nie',
    37 => 'Wiêcej autorstwa',
    38 => 'Wiêcej z sekcji',
    39 => 'Emaile',
    40 => 'Odmowa Dostêpu',
    41 => "Próbujesz wyedytowaæ artyku³ do którego nie masz uprawnieñ.  Ta próba zosta³a zapisana w logu.  Mo¿esz podgl±dn±æ artyku³ poni¿ej. Proszê <a href=\"{$_CONF['site_admin_url']}/story.php\">wróciæ do strony administruj±cej artyku³ami.",
    42 => "Próbujesz wyedytowaæ artyku³ do którego nie masz uprawnieñ.  Ta próba zosta³a zapisana w logu.  Proszê <a href=\"{$_CONF['site_admin_url']}/story.php\">wróciæ do strony administruj±cej artyku³ami</a>.",
    43 => 'Nowy Artyku³',
    44 => 'Panel Sterowania',
    45 => 'Dostêp',
    46 => '<b>UWAGA:</b> je¶li przesuniesz datê do przodu, artyku³ nie zostanie opublikowany wcze¶niej. Oznacza to równie¿, ¿e artyku³ nie bêdzie uwzglêdniony w pliku RDF i zostanie pominiêty przy wyszukiwaniu.',
    47 => 'Zdjêcia',
    48 => 'zdjêcie',
    49 => 'prawo',
    50 => 'lewo',
    51 => 'Aby dodaæ jedno ze zdjêæ, które chcesz podpi±æ do tego artyku³u musisz wstawiæ specjalnie sformatowany tekst.  Tekst jest nastêpuj±cy [imageX], [imageX_right] lub [imageX_left] gdzie X to numer obrazka, który za³±czy³e¶.  UWAGA: Musisz u¿ywaæ obrazków, które za³±czasz.  Inaczej nie bêdziesz w stanie zapisaæ swojego artyku³u.<BR><P><B>PODGL¡D</B>: Podgl±d artyku³u z za³±czonymi obrazkami dzia³a najlepiej po uprzednim zapisaniu artyku³u jako kopia ZAMIAST u¿ycia bezpo¶rednio klawisza podgl±d.  U¿ywaj klawisza podgl±d tylko gdy nie podpinasz obrazków.',
    52 => 'Kasuj',
    53 => 'nie zosta³ u¿yty.  Musisz umie¶ciæ ten obrazek we wstêpie lub w g³ównej czê¶ci zanim zapiszsz zmiany',
    54 => 'Za³±czonych Obrazów Nie U¿yto',
    55 => 'Pojawi³y siê nastêpuj±ce b³êdy podczas próby zapisu tego artyku³u.  Proszê je poprawiæ przed ponownym zapisem',
    56 => 'Poka¿ Ikonê Artyku³u',
    57 => 'Poka¿ nieskalowalne zdjêcie',
    58 => 'Zarz±dzanie Artyku³ami',
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
    85 => 'Show All'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Edytor Sekcji',
    2 => 'ID Sekcji',
    3 => 'Nazwa Sekcji',
    4 => 'Ikona Sekcji',
    5 => '(bez spacji)',
    6 => 'Wykasowanie sekcji wykasuje wszystkie artyku³y i bloki z ni± powi±zane',
    7 => 'Proszê wpisaæ ID Sekcji i Nazwê Sekcji',
    8 => 'Menad¿er Sekcji',
    9 => 'Aby zmodyfikowaæ lub wykasowaæ sekcjê, kliknij na dan± sekcjê.  Aby stworzyæ now± sekcjê kliknij na Nowa Sekcja powy¿ej. W nawiasie znajduje siê twój poziom dostêpu do ka¿dej sekcji. Gwiazdka (*) oznacza domy¶ln± sekcjê.',
    10 => 'Sortowanie',
    11 => 'Artyku³ów/Stronê',
    12 => 'Odmowa Dostêpu',
    13 => "Próbujesz wyedytowaæ sekcjê do której nie masz uprawnieñ.  Ta próba zosta³a zapisana w logu. Proszê <a href=\"{$_CONF['site_admin_url']}/topic.php\">wróciæ do ekranu administruj±cego sekcjami</a>.",
    14 => 'Sortuj Wg',
    15 => 'alfabetycznie',
    16 => 'domy¶lnie jest',
    17 => 'Nowa Sekcja',
    18 => 'Panel Sterowania',
    19 => 'zapisz',
    20 => 'anuluj',
    21 => 'kasuj',
    22 => 'Domy¶lnie',
    23 => 'zrób z tego domy¶ln± sekcjê dla przesy³anych artyku³ów',
    24 => '(*)',
    25 => 'Sekcja Archiwalna',
    26 => 'domy¶lna sekcja dla archiwizowanych artyku³ów. Dozwolona jest tylko jedna sekcja.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Edytor U¿ytkowników',
    2 => 'ID U¿ytkownika',
    3 => 'Login',
    4 => 'Pe³na Nazwa',
    5 => 'Has³o',
    6 => 'Poziom Zabezpieczenia',
    7 => 'Adres Email',
    8 => 'Strona Domowa',
    9 => '(bez spacji)',
    10 => 'Proszê wpisaæ Login i Adres Email',
    11 => 'Menad¿er U¿ytkowników',
    12 => 'Aby zmodyfikowaæ lub usun±æ u¿ytkownika, kliknij na odpowiedni login poni¿ej.  Aby za³o¿yæ nowego u¿ytkownika kliknij nowy u¿ytkownik po lewej. Mo¿esz przeszukaæ bazê wpisuj±c czê¶æ loginu, adresu email lub pe³nej nazwy (np. *son* lub *.edu) w poni¿szym formularzu.',
    13 => 'PozZab',
    14 => 'Data Rej.',
    15 => 'Nowy U¿ytkownik',
    16 => 'Panel Sterowania',
    17 => 'zmieñ has³o',
    18 => 'anuluj',
    19 => 'kasuj',
    20 => 'zapisz',
    21 => 'Login ju¿ istnieje.',
    22 => 'B³±d',
    23 => 'Dodanie Grupowe',
    24 => 'Grupowy Import U¿ytkowników',
    25 => 'Mo¿na zaimportowaæ grupowo u¿ytkowników do Geekloga.  Plik tekstowy musi byæ rozdzielany znakami tabulacji oraz musi mieæ nastêpuj±c± strukturê: imiê i nazwisko, login, adres email.  Ka¿dy zaimportowany u¿ytkownik dostanie mailem has³o.  W jednej linii mo¿e wystêpowaæ tylko jeden u¿ytkownik.  Nie zastosowanie do tych instrukcji spowoduje problemy, które mog± wymagaæ rêcznej obróbki dlatego sprawd¼ dwa razy zawarte informacje!',
    26 => 'Szukaj',
    27 => 'Zawê¿ Wyniki',
    28 => 'Zaznacz tutaj aby usun±æ obrazek',
    29 => '¦cie¿ka',
    30 => 'Import',
    31 => 'Nowi U¿ytkownicy',
    32 => 'Przetwarzanie zakoñczone. Zaimportowano %d i napotkano %d b³êdów',
    33 => 'prze¶lij',
    34 => 'B³±d: Musisz podaæ plik do za³adowania.',
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
    47 => 'Edit'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Zatwierd¼',
    2 => 'Kasuj',
    3 => 'Edytuj',
    4 => 'Profil',
    10 => 'Tytu³',
    11 => 'Data Pocz±tkowa',
    12 => 'URL',
    13 => 'Kategoria',
    14 => 'Data',
    15 => 'Sekcja',
    16 => 'Nazwa u¿ytkownika',
    17 => 'Pe³na nazwa u¿ytkownika',
    18 => 'Email',
    34 => 'Panel Sterowania',
    35 => 'Przes³ane Artyku³y',
    36 => 'Przes³ane Linki',
    37 => 'Przes³ane Wydarzenia',
    38 => 'Prze¶lij',
    39 => '¯adnych materia³ów do zatwierdzenia',
    40 => 'Materia³y przes³ane przez u¿ytkownika'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Niedziela',
    2 => 'Poniedzia³ek',
    3 => 'Wtorek',
    4 => '¦roda',
    5 => 'Czwartek',
    6 => 'Pi±tek',
    7 => 'Sobota',
    8 => 'Dodaj Wydarzenie',
    9 => '%s Wydarzenie',
    10 => 'Wydarzenia',
    11 => 'G³ówny Kalendarz',
    12 => 'Mój Kalendarz',
    13 => 'Styczeñ',
    14 => 'Luty',
    15 => 'Marzec',
    16 => 'Kwiecieñ',
    17 => 'Maj',
    18 => 'Czerwiec',
    19 => 'Lipiec',
    20 => 'Sierpieñ',
    21 => 'Wrzesieñ',
    22 => 'Pa¼dziernik',
    23 => 'Listopad',
    24 => 'Grudzieñ',
    25 => 'Powrót do ',
    26 => 'Ca³y Dzieñ',
    27 => 'Tydzieñ',
    28 => 'Kalendarz Osobisty',
    29 => 'Kalendarz Ogólny',
    30 => 'kasuj wydarzenia',
    31 => 'Dodaj',
    32 => 'Wydarzenie',
    33 => 'Data',
    34 => 'Czas',
    35 => 'Szybkie Dodanie',
    36 => 'Wy¶lij',
    37 => 'Sorry, funkcja kalendarz osobisty nie jest dostêpna',
    38 => 'Edytor Osobisty',
    39 => 'Dzieñ',
    40 => 'Tydzieñ',
    41 => 'Miesi±c'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => 'Mail',
    2 => 'Od',
    3 => 'Odpowiedz',
    4 => 'Temat',
    5 => 'Wiadomo¶æ',
    6 => 'Wy¶lij do:',
    7 => 'Wszyscy',
    8 => 'Admin',
    9 => 'Opcje',
    10 => 'HTML',
    11 => 'Pilne!',
    12 => 'Wy¶lij',
    13 => 'Zresetuj',
    14 => 'Ignoruj ustawienia u¿ytkownika',
    15 => 'B³±d podczas wysy³ania do: ',
    16 => 'Wiadomo¶æ wys³ana do: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Wy¶lij nastêpn± wiadomo¶æ</a>",
    18 => 'Do',
    19 => 'UWAGA: je¶li chcesz wys³aæ wiadomo¶æ do wszystkich u¿ytkowników, wybierz Logged-in Users z listy rozwijanej.',
    20 => "Wys³anych <successcount> wiadomo¶ci oraz <failcount> niewys³anych wiadomo¶ci.  Poni¿ej szczegó³y dotycz±ce próby wys³ania ka¿dej wiadomo¶ci.  Mo¿esz równie¿ <a href=\"{$_CONF['site_admin_url']}/mail.php\">Wys³aæ wiadomo¶æ</a> lub mo¿esz <a href=\"{$_CONF['site_admin_url']}/moderation.php\">wróciæ do strony administracyjnej</a>.",
    21 => 'B³±d',
    22 => 'Sukces',
    23 => 'Brak b³êdów',
    24 => 'Bez powodzenia',
    25 => '-- Wybierz Grupê --',
    26 => 'Proszê uzupe³niæ wszystkie pola i wybraæ grupê z listy.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Instalowanie pluginów mo¿e spowodowaæ uszkodzenie twojej instalacji Geekloga jak równie¿ systemu.  Wa¿ne jest aby instalowaæ pluginy ¶ci±gniête z <a href="http://www.geeklog.net" target="_blank">Geeklog Homepage</a> poniewa¿ s± one szczegó³owo przez nas testowane na ró¿nych systemach operacyjnych.  Wa¿ne aby¶ mia³ ¶wiadomo¶æ, ¿e instalacja pluginu wymaga wykonania kilku komend filesystemu, co wi±¿e siê z bezpieczeñstwem systemu, zw³aszcza gdy pluginy pochodz± od osób trzecich.  Pomimo tego ostrze¿enia, nie gwarantujemy sukcesu instalacyjnego ani nie mo¿emy byæ poci±gniêci do odpowiedzialno¶ci za jakiekolwiek szkody wynik³e z instalacji jakiegokolwiek pluginu.  Instalacja na w³asne ryzyko.  Instrukcje dotycz±ce rêcznej instalacji pluginu znajduj± siê w ka¿dym pakiecie z pluginem.',
    2 => 'Umowa Instalacyjna Pluginów',
    3 => 'Plugin Formularz Instalacyjny',
    4 => 'Plugin Plik',
    5 => 'Zainstalowane Pluginy',
    6 => 'Ostrze¿enie: Plugin Ju¿ Zainstalowany!',
    7 => 'Plugin, który próbujesz zainstalowaæ ju¿ istnieje.  Proszê wykasowaæ istniej±cy plugin i zainstalowaæ go ponownie',
    8 => 'Sprawdzanie Kompatybilno¶ci Pluginu Zakoñczone Niepowodzeniem',
    9 => 'Ten plugin wymaga nowszej wersji Geekloga. Albo uaktualnij swoj± kopiê <a href=http://www.geeklog.net>Geekloga</a> albo ¶ci±gnij nowsz± wersjê tego pluginu.',
    10 => '<br><b>Brak zainstalowanych pluginów.</b><br><br>',
    11 => 'Aby zmodyfikowaæ lub wykasowaæ plugin, kliknij na nazwê pluginu. Zobaczysz wiêcej informacji w³±cznie z adresem strony autora. Widoczne s± wersje zainstalowana i wersja kodu. To pomo¿e stwierdziæ czy dany plugin wymaga aktualizacji. Aby zainstalowaæ lub uaktualniæ dany plugin proszê zapoznaæ siê z do³±czon± do niego instrukcj±.',
    12 => 'brak nazwy pluginu dla plugineditor()',
    13 => 'Edytor Pluginów',
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
    30 => 'Skasowaæ Plugin?',
    31 => 'Czy aby na pewno skasowaæ ten plugin?  Ta operacja usunie wszelkie pliki, dane i strukturê u¿ywane przez ten plugin.  Je¶li chcesz kontynuwaæ kliknij kasuj poni¿ej.',
    32 => '<p><b>B³êdny format tagu AutoLink</b></p>',
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
    1 => 'stwórz plik',
    2 => 'zapisz',
    3 => 'kasuj',
    4 => 'anuluj',
    10 => 'Syndykacja Tre¶ci',
    11 => 'Nowy Plik',
    12 => 'Panel Sterowania',
    13 => 'Aby zmodyfikowaæ lub usun±æ plik, kliknij na tytu³ pliku poni¿ej. Aby stworzyæ nowy plik, kliknij Nowy Plik powy¿ej.',
    14 => 'Tytu³',
    15 => 'Rodzaj',
    16 => 'Plik',
    17 => 'Format',
    18 => 'ost. aktualizacja',
    19 => 'Aktywny',
    20 => 'Tak',
    21 => 'Nie',
    22 => '<i>(plików brak)</i>',
    23 => 'Wszystkie Artyku³y',
    24 => 'Edytor Plików',
    25 => 'Tytu³ Pliku',
    26 => 'Limit',
    27 => 'D³ugo¶æ tekstu',
    28 => '(0 = bez tekstu, 1 = pe³ny tekst, inne = ograniczona liczba znaków.)',
    29 => 'Opis',
    30 => 'Ost. Aktualizacja',
    31 => 'Kodowanie',
    32 => 'Jêzyk',
    33 => 'Zawarto¶æ',
    34 => 'Tytu³ów',
    35 => 'Godzin',
    36 => 'Wybierz rodzaj pliku',
    37 => 'Masz zainstalowany co najmniej jeden plugin zarz±dzaj±cy syndykacj± tre¶ci. Poni¿ej nale¿y wybraæ opcjê czy chcesz stworzyæ plik Geeklogowy czy te¿ plik dla jednego z pluginów.',
    38 => 'B³±d: Brakuj±ce Pola',
    39 => 'Wpisz Tytu³ Pliku, Opis i Nazwê Pliku.',
    40 => 'Proszê podaæ liczbê tytu³ów lub czas w godzinach.',
    41 => 'Linki',
    42 => 'Wydarzenia',
    43 => 'All',
    44 => 'None',
    45 => 'Header-link in topic',
    46 => 'Limit Results',
    47 => 'Search',
    48 => 'Edit',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})"
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Has³o zosta³o wys³ane i powiniene¶ go wkrótce otrzymaæ. Postêpuj zgodnie ze wskazówkami w wiadomo¶ci. Dziêkujemy za korzystanie z serwisu {$_CONF['site_name']}",
    2 => "Dziêkujemy za przes³anie artyku³u do {$_CONF['site_name']}.  Otrzymali go nasi pracownicy do zatwierdzenia. Po zatwierdzeniu twój artyku³ bêdzie dostêpny dla innych u¿ytkowników naszego serwisu.",
    3 => "Dziêkujemy za przes³anie linka do {$_CONF['site_name']}.  Otrzymali go nasi pracownicy do zatwierdzenia.  Po zatwierdzeniu twój link bêdzie widoczny w sekcji <a href={$_CONF['site_url']}/links.php>linki</a>.",
    4 => "Dziêkujemy za przes³anie wydarzenia do {$_CONF['site_name']}.  Otrzymali go nasi pracownicy do zatwierdzenia.  Po zatwierdzeniu twoje wydarzenie bêdzie widoczne w sekcji <a href={$_CONF['site_url']}/calendar.php>kalendarz</a>.",
    5 => 'Informacje dotycz±ce twojego konta zosta³y zapisane.',
    6 => 'Twoje preferencje dotycz±ce wygl±du zosta³y zapisane.',
    7 => 'Twoje preferencje dotycz±ce komentarzy zosta³y zapisane.',
    8 => 'Zosta³e¶/a¶ pomy¶lnie wylogowany/a.',
    9 => 'Artyku³ zosta³ zapisany.',
    10 => 'Artyku³ zosta³ wykasowany.',
    11 => 'Blok zosta³ zapisany.',
    12 => 'Blok zosta³ wykasowany.',
    13 => 'Sekcja zosta³a zapisana.',
    14 => 'Sekcja oraz wszystkie artyku³y i bloki z ni± zwi±zane zosta³y wykasowane.',
    15 => 'Link zosta³ zapisany.',
    16 => 'Link zosta³ wykasowany.',
    17 => 'Wydarzenie zosta³o zapisane.',
    18 => 'Wydarzenie zosta³o wykasowane.',
    19 => 'G³osowanie zosta³o zapisane.',
    20 => 'G³osowanie zosta³o wykasowane.',
    21 => 'Nowy u¿ytkownik zosta³ zapisany.',
    22 => 'Nowy u¿ytkownik zosta³ wykasowany.',
    23 => 'Wyst±pi³ b³±d podczas próby dodania wydarzenia do twojego kalendarza. Nie przekazano ID wydarzenia.',
    24 => 'Wydarzenie zosta³o zapisane w twoim kalendarzu',
    25 => 'Kalendarz osobisty dostêpny jest dopiero po zalogowaniu',
    26 => 'Wydarzenie zosta³o usuniête z twojego kalendarza osobistego',
    27 => 'Wiadomo¶æ wys³ano.',
    28 => 'Plugin zosta³ zapisany',
    29 => 'Sorry, kalendarze osobiste s± niedostêpne w tym serwisie',
    30 => 'Odmowa Dostêpu',
    31 => 'Sorry, nie masz dostêpu do strony administruj±cej artyku³ami.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    32 => 'Sorry, nie masz dostêpu do strony administruj±cej sekcjami.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    33 => 'Sorry, nie masz dostêpu do strony administruj±cej blokami.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    34 => 'Sorry, nie masz dostêpu do strony administruj±cej linkami.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    35 => 'Sorry, nie masz dostêpu do strony administruj±cej wydarzeniami.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    36 => 'Sorry, nie masz dostêpu do strony administruj±cej sondami.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    37 => 'Sorry, nie masz dostêpu do strony administruj±cej u¿ytkownikami.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    38 => 'Sorry, nie masz dostêpu do strony administruj±cej pluginami.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    39 => 'Sorry, nie masz dostêpu do strony administruj±cej mailem.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    40 => 'Komunikat Systemowy',
    41 => 'Sorry, nie masz dostêpu do strony edycyjnej zamienników s³ów.  Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    42 => 'S³owo zosta³o zapisane.',
    43 => 'S³owo zosta³o wykasowane.',
    44 => 'Plugin zosta³ zainstalowany!',
    45 => 'Plugin zosta³ wykasowany.',
    46 => 'Sorry, nie masz dostêpu do opcji archiwizowania bazy danych.  Pamiêtaj, ¿e Wszelkie nieautoryzowane próby wej¶cia s± logowane',
    47 => 'Ta opcja dzia³a tylko pod systemem *nixowym. Je¶li masz w³a¶nie taki system operacyjny to cache zosta³ wyczyszczony. Pod Windoz±, musisz poszukaæ plików adodb_*.php i usun±æ je rêcznie.',
    48 => "Dziekujemy za zainteresowanie cz³onkowstwem w {$_CONF['site_name']}. Zweryfikujemy twoje zg³oszenie i po zatwierdzeniu zostanie wys³ane has³o pod podany adres e-mail.",
    49 => 'Twoja grupa zosta³a zapisana.',
    50 => 'Grupa zosta³a wykasowana.',
    51 => 'Ten login juz istnieje. Prosze wybrac inny.',
    52 => 'Podany adres email nie wyglada na prawidlowy.',
    53 => 'Twoje nowe has³o zosta³o przyjête. Proszê zalogowac sie ponizej wpisuj±c nowe has³o.',
    54 => 'Twoja pro¶ba o nowe has³o wygas³a. Proszê spróbowac ponownie poni¿ej.',
    55 => 'Wkrótce powinien dotrzeæ do Ciebie email. Postêpuj zgodnie ze wskazówkami aby ustawiæ nowe has³o dla Twojego konta.',
    56 => 'Podany adres email jest ju¿ u¿ywany.',
    57 => 'Twoje konto zosta³o pomy¶lnie usuniête.',
    58 => 'Plik zosta³ zapisany.',
    59 => 'Plik zosta³ skasowany.',
    60 => 'Plugin zosta³ pomy¶lnie zaktualizowany',
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
    75 => 'Trackbacks must be sent using a POST request.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Dostêp',
    'ownerroot' => 'W³a¶ciciel/Root',
    'group' => 'Grupa',
    'readonly' => 'Tylko-do-Odczytu',
    'accessrights' => 'Prawa Dostêpu',
    'owner' => 'W³a¶ciciel',
    'grantgrouplabel' => 'Udziel Praw do Edycji Powy¿szej Grupie',
    'permmsg' => 'UWAGA: cz³onkowie to wszyscy zalogowani u¿ytkownicy na stronie a anonimowi to wszyscy u¿ytkownicy przegl±daj±cy zawarto¶æ strony bez zalogowania.',
    'securitygroups' => 'Grupy Zabezpieczeñ',
    'editrootmsg' => "Pomimo tego, ¿e jeste¶ User Administrator, nie mo¿esz edytowaæ g³ównego u¿ytkownka. Najpierw sam musisz zostaæ u¿ytkownikiem g³ównym.  Mo¿esz edytowaæ pozosta³ych u¿ytkowników. Wszelkie nie autoryzowane próby edycji u¿ytkowników g³ównych s± logowane.  Powrót do strony Administracja U¿ytkownikami serwisu <a href=\"{$_CONF['site_admin_url']}/user.php\"></a>.",
    'securitygroupsmsg' => 'Zaznacz grupy do których chcesz przypisaæ u¿ytkownika.',
    'groupeditor' => 'Edytor Grup',
    'description' => 'Opis',
    'name' => 'Nazwa',
    'rights' => 'Uprawnienia',
    'missingfields' => 'Brakuj±ce Pola',
    'missingfieldsmsg' => 'Musisz podaæ nazwê i opis grupy',
    'groupmanager' => 'Menad¿er Grup',
    'newgroupmsg' => 'Aby zmodyfikowaæ lub wykasowaæ grupê kliknij na dan± grupê poni¿ej. Aby stworzyæ now± grupê kliknij nowa grupa powy¿ej. Grupy g³ówne nie mog± byæ wykasowane s± u¿ywane przez system.',
    'groupname' => 'Nazwa Grupy',
    'coregroup' => 'Grupa G³ówna',
    'yes' => 'Tak',
    'no' => 'Nie',
    'corerightsdescr' => "Ta grupa jest G³ówn± Grup± strony {$_CONF['site_name']} .  Z tego wzglêdu prawa dla  tej grupy nie mog± byæ edytowane.  Poni¿ej znajduje siê lista do-odczytu praw tej grupy.",
    'groupmsg' => 'Grupy Zabezpieczeñ Groups w tym serwisie s± hierarchiczne.  Poprzez dodanie tej grupy do jakiejkolwiek grupy poni¿ej, tym samym nadasz tej grupie takie same prawa.  Je¿eli to mo¿liwe to zalecamy wykorzystanie poni¿szych grup przy nadawaniu praw jakiejkolwiek grupie.  Je¶li chcesz nadaæ tej grupie specjalne prawa, mo¿esz wybraæ uprawnienia do ró¿nych funkcji serwisu w poni¿szej sekcji \'Uprawnienia\'.  Aby dodaæ t± grupê do którejkolwiek z poni¿szej listy, zaznacz po prostu wybran± grupê(y).',
    'coregroupmsg' => "To jest Grupa g³ówna serisu {$_CONF['site_name']}.  Z tego wzglêdu grupy nale¿±ce do tej kategorii nie mog± byæ edytowane.  Poni¿ej znajduje siê lista, tylko do odczytu, grup z tej kategorii.",
    'rightsdescr' => 'Dostêp grupowy to wybranych uprawnieñ poni¿ej mo¿e byæ nadany bezpo¶rednio danej grupie LUB innej grupie, do której dana grupa nale¿y.  Te z listy poni¿ej bez pola wyboru oznaczaj± uprawnienia tej grupy wynikaj±ce z faktu przynale¿no¶ci do grupy z danym uprawnieniem.  Uprawnienia z polami wyboru mog± zostaæ bezpo¶rednio nadane danej grupie.',
    'lock' => 'Blokada',
    'members' => 'Cz³onkowie',
    'anonymous' => 'Anonim',
    'permissions' => 'Uprawnienia',
    'permissionskey' => 'R = odczyt, E = edycja, prawa do edycji zak³adaj± prawa do odczytu',
    'edit' => 'Edycja',
    'none' => 'Brak',
    'accessdenied' => 'Odmowa Dostêpu',
    'storydenialmsg' => "Brak dostêpu do tego artyku³u.  Prawdopodobnie nie jeste¶ cz³onkiem serwisu {$_CONF['site_name']}.  Zapraszamy do <a href=users.php?mode=new> cz³onkostwa</a> w serwisie {$_CONF['site_name']} aby otrzymaæ pe³ny dostêp!",
    'eventdenialmsg' => "Brak dostêpu do tego wydarzenia.  Prawdopodobnie nie jeste¶ cz³onkiem serwisu {$_CONF['site_name']}.  Zapraszamy do <a href=users.php?mode=new> cz³onkostwa</a> w serwisie {$_CONF['site_name']} aby otrzymaæ pe³ny dostêp!",
    'nogroupsforcoregroup' => 'Grupa nie nale¿y do pozosta³ych grup',
    'grouphasnorights' => 'Grupa nie ma dostêpu do ¿adnych funkcji administracyjnych tego serwisu',
    'newgroup' => 'Nowa Grupa',
    'adminhome' => 'Panel Sterowania',
    'save' => 'zapisz',
    'cancel' => 'anuluj',
    'delete' => 'kasuj',
    'canteditroot' => 'Wyst±pi³a próba edycji grupy G³ównej. Niestety nie nale¿ysz do ¿adnej z grup G³ównych dlatego nie masz dostêpu do tej grupy.  Skontaktuj siê z administratorem systemu je¶li uwa¿asz, ¿e to pomy³ka',
    'listusers' => 'Listuj U¿ytkowników',
    'listthem' => 'listuj',
    'usersingroup' => 'U¿ytkownicy w grupie %s',
    'usergroupadmin' => 'Administracja Grupami U¿ytkowników',
    'add' => 'Dodaj',
    'remove' => 'Usuñ',
    'availmembers' => 'Dostêpni Cz³onkowie',
    'groupmembers' => 'Cz³onkowie Grupy',
    'canteditgroup' => 'Aby wyedytowaæ t± grupê musisz do niej nale¿eæ. Proszê skontaktowaæ siê z administratorem je¶li uwa¿asz, ¿e nast±pi³a pomy³ka.',
    'cantlistgroup' => 'Aby zobaczyæ cz³onków tej grupy, musisz byæ jej cz³onkiem. Skontaktuj siê z administratorem je¶li uwa¿asz, ¿e to jest b³±d.',
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
    'do_backup' => 'Wykonaj Kopiê Zapasow±',
    'backup_successful' => 'Kopia bazy wykonana pomy¶lnie.',
    'db_explanation' => 'Aby wykonaæ now± kopiê zapasow± twojego systemu, kliknij poni¿szy przycisk',
    'not_found' => "Niew³a¶ciwa ¶cie¿ka lub program archiwizuj±cy nie jest wykonywalny.<br>Sprawd¼ <strong>\$_DB_mysqldump_path</strong> ustawienia w config.php.<br>Zmienna jest obecnie ustawiona na: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Wykonanie Kopii Nie Powiod³o Siê: Rozmiar pliku 0 bajtów',
    'path_not_found' => "{$_CONF['backup_path']} nie istnieje lub nie jest katalogiem",
    'no_access' => "B£¡D: Katalog {$_CONF['backup_path']} jest niedostêpny.",
    'backup_file' => 'Plik kopii',
    'size' => 'Rozmiar',
    'bytes' => 'Bajtów',
    'total_number' => 'Wszystkich kopii bezpieczeñstwa: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'G³ówna',
    2 => 'Kontakt',
    3 => 'Napisz Artyku³',
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
    1 => 'B³±d 404',
    2 => 'Kurcze, wszêdzie szuka³em ale nie mogê znale¼æ <b>%s</b>.',
    3 => "<p>Przykro nam ale dany plik nie istnieje. Sprawd¼ <a href=\"{$_CONF['site_url']}/search.php\">stronê z wyszukiwark±</a> aby sprawdziæ czy mo¿na znale¼æ co zgubi³e¶."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Wymagany jest login',
    2 => 'Sorry, aby wej¶æ na te strony musisz byæ zalogowany.',
    3 => 'Login',
    4 => 'Nowy U¿ytkownik'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'Opcja PDF zosta³a wy³±czona',
    2 => 'Dany dokument nie zosta³ wygenerowany. Dokument zosta³ otrzymany ale nie móg³ byæ przetworzony.  Upewnij siê, ¿e przes³ane dokumenty html zosta³y zapisane w standardowym xHTML. Proszê mieæ na uwadze, ¿e skomplikowane dokumenty html-owe mog± zostaæ przetworzone z b³êdem lub w ogóle. Dokument, który próbowa³a¶/e¶ wygenrowaæ mia³ rozmiar 0 bajtów i zosta³ usuniêty. Je¶li uwa¿asz, ¿e Twój dokument powinien zostaæ wygenerowany prawid³owo, prze¶lij go raz jeszcze.',
    3 => 'Nieznany b³±d podczas generowania pliku PDF',
    4 => "Nie okre¶lono ¿adnej strony albo chcesz u¿yæ poni¿szego narzêdzia do generowania PDF-a ad-hoc.  Je¶li uwa¿asz, ¿e strona to b³±d\n          skontaktuj siê z administratorem systemu.  W przeciwnym razie, u¿yj poni¿szego formularza aby wygenerowaæ PDF-a metod± ad-hoc.",
    5 => '£adowanie dokumentu.',
    6 => 'Proszê poczekaæ na za³adowanie dokumentu.',
    7 => 'Kliknij prawym przyciskiem myszy i wybierz \'zapisz element docelowy jako...\' lub \'zapisz link...\' aby zachowaæ kopiê dokumentu na Twoim komputerze.',
    8 => "The path given in the configuration file to the HTMLDoc binary is invalid or this system cannot execute it.  Please contact the site administrator if this problem\n          persists.",
    9 => 'Generator PDF',
    10 => "This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This\n           is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site",
    11 => 'URL',
    12 => 'Generuj PDF!',
    13 => 'Konfiguracja PHP na tym serwerze nie pozwala na u¿ycie URL z komend± fopen().  Administrator systemu musi edytowaæ plik php.ini i ustawiæ allow_url_fopen na On',
    14 => '¯±dany PDF albo nie istnieje albo nie masz do niego uprawnieñ.'
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
    'pb_error_details' => 'Error when sending the pingback:'
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
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array(
    'search' => 'Search',
    'limit_results' => 'Limit Results',
    'submit' => 'Submit',
    'edit' => 'Edit',
    'admin_home' => 'Admin Home',
    'create_new' => 'Create New',
    'enabled' => 'Enabled',
    'title' => 'Title',
    'type' => 'Type',
    'topic' => 'Topic',
    'help_url' => 'Help File URL',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'copy' => 'Copy',
    'no_results' => '- No entries found -',
    'data_error' => 'There was an error processing the subscription data. Please check the data source.'
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