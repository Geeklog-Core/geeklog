<?php

###############################################################################
# croatian_utf-8.php
# This is the croatian language page for GeekLog!
# Special thanks to Mischa Polivanov for his work on this project
#
# Copyright (C) 2004 Roberto 'druid' Bilic
# spphr@spph.org
#
# Converted to UTF-8 by Samuel M. Stone <sam@stonemicro.com>
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
#
# NAPOMENA:
# U config.php morate charset takoðer podesiti iso-8859-2 da bi vam ispravno
# prikazivalo hrvatska slova.
#
# Ukoliko primjetite da ne¹to nije dobro prevedeno, ili da ima bolja rijeè
# javite na spprh@spph.org pa budemo to ispravili
#
# U prevaðanju sudjelovali: Kristina Jordan, Roberto Biliæ
#
# File je preveden za potrebe sitea www.spph.org ali se mo¾e i drugdje
# BESPLATNO koristiti u skladu s GNU/GPL licencom.
#
###############################################################################

$LANG_CHARSET = 'utf-8';

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
    2 => 'proèitaj vi¹e',
    3 => 'komentar(a)',
    4 => 'Editiraj',
    5 => 'Anketa',
    6 => 'Rezultati',
    7 => 'Rezultati ankete',
    8 => 'glasova',
    9 => 'Administracijske Funkcije:',
    10 => 'Submissions',
    11 => 'Tekstovi',
    12 => 'Blokovi',
    13 => 'Teme',
    14 => 'Linkovi',
    15 => 'Dogaðanja',
    16 => 'Ankete',
    17 => 'Korisnici',
    18 => 'SQL upit',
    19 => 'Odjava',
    20 => 'Korisnièke postavke:',
    21 => 'Korisnièko ime',
    22 => 'Korisnièki ID',
    23 => 'Sigurnosna razina',
    24 => 'Anonimac',
    25 => 'Odgovori',
    26 => 'Sljedeæi komentari su vlasni¹tvo onog koji ih je napisao. Web site nije odgovoran na bilo koji naèin u vezi onoga ¹to autor u njima ka¾e.',
    27 => 'Najnoviji tekst',
    28 => 'Obrisati',
    29 => 'Nema korisnièkih komentara.',
    30 => 'Stariji tekstovi',
    31 => 'Dozvoljeni HTML kodovi:',
    32 => 'Gre¹ka, neispravno korisnièko ime',
    33 => 'Gre¹ka, ne mogu pisati u log fajlove',
    34 => 'Gre¹ka',
    35 => 'Odjava',
    36 => 'on',
    37 => 'Nema korisnièkih tekstova',
    38 => 'Content Syndication',
    39 => 'Osvje¾i',
    40 => 'Imate <tt>register_globals = Off</tt> u va¹em <tt>php.ini</tt>. Site zahtjeva da <tt>register_globals</tt> bude <strong>on</strong>. Prije nego ¹to nastavite, molim postavite to na <strong>on</strong> i restartajte web server.',
    41 => 'Gosti',
    42 => 'Autor:',
    43 => 'Odgovorite na ovo',
    44 => 'Parent',
    45 => 'MySQL gre¹ka broj',
    46 => 'MySQL poruka gre¹ke',
    47 => 'Korisnièke funkcije',
    48 => 'Korisnièke postavke',
    49 => 'Postavke raèuna',
    50 => 'Error with SQL statement',
    51 => 'pomoæ',
    52 => 'Novi',
    53 => 'Admin poèetna stranica',
    54 => 'Ne mogu otvoriti datoteku.',
    55 => 'Gre¹ka na',
    56 => 'Glasaj',
    57 => 'Zaporka',
    58 => 'Prijava',
    59 => "Nemate jo¹ korisnièki raèun? Kreirajte ga besplatno <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Ovdje</a>",
    60 => 'Po¹aljite komentar',
    61 => 'Kreiraj Novi Korisnièki raèun',
    62 => 'rijeèi',
    63 => 'Postavke komentara',
    64 => 'Po¹alji tekst mailom.',
    65 => 'Pogledaj verziju za printanje',
    66 => 'Moj Kalendar',
    67 => 'Dobrodo¹li na stranice ',
    68 => 'poèetna stranica',
    69 => 'kontakt',
    70 => 'tra¾i',
    71 => 'contribute',
    72 => 'web izvori',
    73 => 'stari glasovi',
    74 => 'kalendar',
    75 => 'napredna tra¾ilica',
    76 => 'statistika web stranice',
    77 => 'Plugins',
    78 => 'Nadolazeæa dogaðanja',
    79 => '©to je novo',
    80 => 'tekstovi u posljednih',
    81 => 'tekstova u zadnjih',
    82 => 'sati',
    83 => 'KOMENTARI',
    84 => 'LINKOVI',
    85 => 'posljednih 48 sati',
    86 => 'Nema novih komentara',
    87 => 'posljedna 2 tjedna',
    88 => 'Nema novih linkova',
    89 => 'Nema nadolazeæih dogaðanja',
    90 => 'Poèetna stranica',
    91 => 'Ova stranica je napravljena u',
    92 => 'sekundi',
    93 => 'Copyright',
    94 => 'Svi za¹titni znakovi i autorska prava su vlasni¹tvo njihovih navedenih vlasnika',
    95 => 'Kori¹teni software',
    96 => 'Korisnièke grupe',
    97 => 'Lista rijeèi',
    98 => 'Dodatni software',
    99 => 'TEKSTOVI',
    100 => 'Nema novih tekstova',
    101 => 'Va¹a dogaðanja',
    102 => 'Dogaðanja stranice',
    103 => 'DB Backups',
    104 => 'od',
    105 => '©alji email',
    106 => 'Pregledano',
    107 => 'Test',
    108 => 'Bri¹i Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Kalendar dogaðaja',
    2 => '®ao nam je, trenutno nema nikakvih dogaðanja.',
    3 => 'Kada',
    4 => 'Gdje',
    5 => 'Opis',
    6 => 'Dodaj dogaðaj',
    7 => 'Nadolazeæa dogaðanja',
    8 => 'Dodavanjem ovog dogaðanja va¹em kalendaru, mo¾ete brzo pregledati samo ona dogaðanja koja vas interesiraju pritiskom na  "Moj kalendar" u korisnièkim funkcijama.',
    9 => 'Dodaj u Moj kalendar',
    10 => 'Makni iz Moj kalendar',
    11 => "Dodaj dogaðaj u {$_USER['username']} kalendar",
    12 => 'Dogaðaji',
    13 => 'Poèetak',
    14 => 'Kraj',
    15 => 'Natrag na kalendar'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Po¹aljite komentar',
    2 => 'Postavke slanja',
    3 => 'Odjava',
    4 => 'Kreirajte korisnièki raèun',
    5 => 'Korisnièko ime',
    6 => 'Stranica zahtjeva, da bi poslali komentar, da budete prijavljeni. Molimo prijavite se.  Ako nemate korisnièki raèun mo¾ete ga napraviti besplatno.',
    7 => 'Va¹ posljedni komentar je ',
    8 => " sekundi.  Stranice zahtjevaju da proðe vi¹e od {$_CONF['commentspeedlimit']} sekundi meðu slanjem komentara",
    9 => 'Komentar',
    10 => '',
    11 => '©alji komentar',
    12 => 'Molim popunite Naziv teksta i Komentar da bi bilo poslano, jer je to neophodno za slanje.',
    13 => 'Va¹e informacije',
    14 => 'Pregled',
    15 => '',
    16 => 'Naslov',
    17 => 'Gre¹ka',
    18 => 'Va¾no',
    19 => 'Molimo Vas da se va¹i komentari pridr¾avaju teme.',
    20 => 'Molimo Vas da odgovarate na vec objavljene komentare umjesto da zapocinjete nove teme.',
    21 => 'Prije nego po¹aljete komentar, molim proèitajte komentare ostalih korisnika da bi se izbjeglo ponavljanje.',
    22 => 'Koristite jednostavni naziv teksta da bi bilo jasno o èemu je rijeæ u va¹em tekstu.',
    23 => 'Va¹ email neèe biti javno dostupan.',
    24 => 'Anonimni korisnik'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Korisnièki profil za',
    2 => 'Korisnièko ime',
    3 => 'Puno ime',
    4 => 'Zaporka',
    5 => 'Email',
    6 => 'Web stranica',
    7 => 'Bio',
    8 => 'PGP kljuè',
    9 => 'Snimi informacije',
    10 => 'Posljednih 10 komentara od korisnika',
    11 => 'No User Comments',
    12 => 'User Preferences for',
    13 => 'Email Nightly Digest',
    14 => 'This password is generated by a randomizer. It is recommended that you change this password immediately. To change your password, log in and then click Account Information from the User Functions menu.',
    15 => "Your {$_CONF['site_name']} account has been created successfully. To be able to use it, you must login using the information below. Please save this mail for further reference.",
    16 => 'Informacije o va¹em korisnièkom raèunu',
    17 => 'Korisnièki raèun ne postoji',
    18 => 'The email address provided does not appear to be a valid email address',
    19 => 'Korisnièko ime ili email adresa koju ste unijeli veè postoji u bazi.',
    20 => 'Email adresu koju ste unijeli ne mo¾emo prihvatiti jer nije odgovarajuæe forme',
    21 => 'Gre¹ka',
    22 => "Registriran na {$_CONF['site_name']}!",
    23 => "Creating a user account will give you all the benefits of {$_CONF['site_name']} membership and it will allow you to post comments and submit items as yourself. If you don't have an account, you will only be able to post anonymously. Please note that your email address will <b><i>never</i></b> be publicly displayed on this site.",
    24 => 'Zaporka æe biti poslana na email adresu koju ste unijeli.',
    25 => 'Zabopravili ste zaporku?',
    26 => 'Enter <em>either</em> your username <em>or</em> the email address you used to register and click Email Password. Instructions on how to set a new password will be mailed to the email address on record.',
    27 => 'Registriraj se sada!',
    28 => 'Zaporka poslana emailom',
    29 => 'logged out from',
    30 => 'logged in from',
    31 => 'The function you have selected requires you to be logged in',
    32 => 'Potpis',
    33 => 'Nikad ne prikazuj javno',
    34 => 'Ovo je tvoje pravo ime',
    35 => 'Unesite novu zaporku za promjenu',
    36 => 'Poèinje sa http://',
    37 => 'Bit æe dodano na va¹e komentare',
    38 => 'Sve o vama! Svi to mogu èitati',
    39 => 'Va¹ javni PGP kljuè',
    40 => 'Tema nema ikonu',
    41 => 'Willing to Moderate',
    42 => 'Format datuma',
    43 => 'Maksimalno tekstova',
    44 => 'No boxes',
    45 => 'Postavke prikazivanja za',
    46 => 'Excluded Items for',
    47 => 'News box Configuration for',
    48 => 'Teme',
    49 => 'Nema ikone u tekstu',
    50 => 'Odznaèite ovo ako niste zainteresirani',
    51 => 'Samo novi tekstovi',
    52 => 'The default is',
    53 => 'Receive the days stories every night',
    54 => 'Check the boxes for the topics and authors you don\'t want to see.',
    55 => 'If you leave these all unchecked, it means you want the default selection of boxes. If you start selecting boxes, remember to set all of them that you want because the default selection will be ignored. Default entries are displayed in bold.',
    56 => 'Autori',
    57 => 'Display Mode',
    58 => 'Sortiraj po',
    59 => 'Limit komentara',
    60 => 'How do you like your comments displayed?',
    61 => 'Noviji ili stariji prvo?',
    62 => 'The default is 100',
    63 => "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using {$_CONF['site_name']}",
    64 => 'Comment Preferences for',
    65 => 'Poku¹ajte ponoviti prijavu',
    66 => "Vjerojatno ste pogresno unijeli korisnièko ime ili zaporku.  Poku¹ajte se ponovo prijaviti. Jeste li <a href=\"{$_CONF['site_url']}/users.php?mode=new\">novi korisnik</a>?",
    67 => 'Èlan od',
    68 => 'Pamti me',
    69 => 'Koliko dugo da vas pamtimo od prijave?',
    70 => "Customize the layout and content of {$_CONF['site_name']}",
    71 => "One of the great features of {$_CONF['site_name']} is you can customize the content you get and you can change the overall layout of this site.  In order to take advantage of these great features you must first <a href=\"{$_CONF['site_url']}/users.php?mode=new\">register</a> with {$_CONF['site_name']}.  Are you already a member?  Then use the login form to the left to log in!",
    72 => 'Tema',
    73 => 'Jezik',
    74 => 'Change what this site looks like!',
    75 => 'Emailed Topics for',
    76 => 'If you select a topic from the list below you will receive any new stories posted to that topic at the end of each day.  Choose only the topics that interest you!',
    77 => 'Fotografija',
    78 => 'Dodaj vlastitu fotografiju!',
    79 => 'Oznaèi ovdje za brisanje fotografije',
    80 => 'Prijava',
    81 => '©alji email',
    82 => 'Posljednih 10 tekstova od korisnika',
    83 => 'Statistika slanja tekstova i komentara od korisnika',
    84 => 'Ukupan broj tekstova:',
    85 => 'Ukupan broj komentara:',
    86 => 'Pronaði sve tekstove od',
    87 => 'Tvoje korisnièko ime',
    88 => "Netko (vjerojatno vi) je zatra¾io novu zaporku za va¹ korisnièki raèun \"%s\" na {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nAko ste to zaista htjeli molim kliknite na ovaj link za potvrdu:\n\n",
    89 => "Ako ne ¾elite to napraviti, jednostavno ignorirajte poruku (zaporka æe ostati nepromijenjena).\n\n",
    90 => 'You can enter a new password for your account below. Please note that your old password is still valid until you submit this form.',
    91 => 'Postavi novu zaporku',
    92 => 'Unesi novu zaporku',
    93 => 'Your last request for a new password was %d seconds ago. This site requires at least %d seconds between password requests.',
    94 => 'Obri¹i korisnièki raèun "%s"',
    95 => 'Click the "delete account" button below to remove your account from our database. Please note that any stories and comments you posted under this account will <strong>not</strong> be deleted but show up as being posted by "Anonymous".',
    96 => 'obri¹ite korisnièki raèun',
    97 => 'Potvrdi brisanje korisnièkog raèuna',
    98 => 'Are you sure you want to delete your account? By doing so, you will not be able to log into this site again (unless you create a new account). If you are sure, click "delete account" again on the form below.',
    99 => 'Opcije privatnosti za ',
    100 => 'Email od administratora',
    101 => 'Dozvoli mailove od webmastera',
    102 => 'Email od korisnika',
    103 => 'Dozvoli primanje emailova od administratora',
    104 => 'Prika¾i online status',
    105 => 'Poka¾i tko je online u bloku'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Nema novosti za prikazivanje.',
    2 => 'There are no news stories to display.  There may be no news for this topic or your user preferences may be too restrictive',
    3 => " za temu {$topic}",
    4 => 'Dana¹nji va¾niji tekstovi',
    5 => 'Iduæi',
    6 => 'Prija¹nji'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'Web izvori',
    2 => 'Nema linkova za prikazati.',
    3 => 'Dodaj link'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'Va¹ glas je uspje¹no zaprimljen',
    2 => 'Va¹ glas je poslan u abketu.',
    3 => 'Glas',
    4 => 'Anketa na stranicama',
    5 => 'Glasa',
    6 => 'Pogledajte ostale ankete'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Prilikom slanja dogodila se gre¹ka. Molimo poku¹ajte ponovo.',
    2 => 'Poruka je uspje¹no poslana.',
    3 => 'Please make sure you use a valid email address in the Reply To field.',
    4 => 'Please fill in the Your Name, Reply To, Subject and Message fields',
    5 => 'Gre¹ka: Korisnik ne postoji.',
    6 => 'There was an error.',
    7 => 'Korisnièki profil za',
    8 => 'Korisnièko ime',
    9 => 'Korisnièki URL',
    10 => '©alji email',
    11 => 'Va¹e ime:',
    12 => '©aljete (kome):',
    13 => 'Naziv maila:',
    14 => 'Poruka:',
    15 => 'HTML kod neæe biti prikazan.',
    16 => '©alji poruku',
    17 => 'Po¹alji tekst emailom',
    18 => '©aljete (kome)',
    19 => 'Na email adresu',
    20 => 'Od',
    21 => 'Od email adrese',
    22 => 'Potrebno je sve popuniti',
    23 => "Ovaj email vam je poslan od {$from} sa {$fromemail} zato jer je mislio da æe vas zanimati tekst s web stranice {$_CONF['site_url']}.  Ovo NIJE SPAM, i va¹e email adrese nisu saèuvane i neæe se koristiti za daljnju uporabu.",
    24 => 'Comment on this story at',
    25 => 'Morate biti prijavljeni da bi mogli koristiti ovaj.  By having you log in, it helps us prevent misuse of the system',
    26 => 'Ovaj formular vam dozvoljava slanje emailova odreðenim korisnicima. Potrebno je popuniti sve podatke.',
    27 => 'Kratka poruka',
    28 => "{$from} pi¹e: {$shortmsg}",
    29 => "Ovo su dnevne obavijesti sa {$_CONF['site_name']} za ",
    30 => ' Dnevne obavijesti za ',
    31 => 'Naziv',
    32 => 'Datum',
    33 => 'Read the full article at',
    34 => 'Kraj poruke',
    35 => '®ao mi je, korisnik ne dozvoljava primanje nikakvih poruka.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Napredno pretra¾ivanje',
    2 => 'Kljuène rijeèi',
    3 => 'Naslovi',
    4 => 'Svi',
    5 => 'Vrsta',
    6 => 'Tekstovi',
    7 => 'Komentari',
    8 => 'Autori',
    9 => 'Svi',
    10 => 'Pretra¾ivanje',
    11 => 'Rezultati pretra¾ivanja',
    12 => 'odgovara',
    13 => 'Rezultati pretra¾ivanja: Nema rezultata',
    14 => 'Nema rezultata koji odgovaraju va¹em upitu',
    15 => 'Molim poku¹ajte ponovo.',
    16 => 'Naslov',
    17 => 'Datum',
    18 => 'Autor',
    19 => "Pretra¾ite bazu podataka web stranice {$_CONF['site_name']} trenutaènih i starijih tekstova",
    20 => 'Datum',
    21 => 'do',
    22 => '(Format datuma GGGG-MM-DD)',
    23 => 'Pregleda',
    24 => 'Pronaðeno %d rezultata',
    25 => 'Tra¾eno za',
    26 => 'upita ',
    27 => 'sekundi',
    28 => 'Nema odgovarajuèih tekstova ili komentara prema va¹em upitu',
    29 => 'Rezultati tekstova i komentara',
    30 => 'Nema linkova koji odgovaraju va¹em upitu',
    31 => 'This plug-in returned no matches',
    32 => 'Dogaðaj',
    33 => 'URL',
    34 => 'Lokacija',
    35 => 'Cijeli dan',
    36 => 'No events matched your search',
    37 => 'Rezultati dogaðaja',
    38 => 'Rezultati linkova',
    39 => 'Linkovi',
    40 => 'Dogaðaji',
    41 => 'Your query string should have at least 3 characters.',
    42 => 'Molim koristite format datuma GGGG-MM-DD (godina-mjesec-dan).',
    43 => 'toèan izraz',
    44 => 'sve rijeèi',
    45 => 'bilo koja od ovih rijeèi',
    46 => 'Iduæi',
    47 => 'Prija¹nji',
    48 => 'Autor',
    49 => 'Datum',
    50 => 'Hits',
    51 => 'Link',
    52 => 'Lokacija',
    53 => 'Rezultati tekstova',
    54 => 'Rezultati komentara',
    55 => 'izraz(e)',
    56 => 'I',
    57 => 'ILI'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Statistika stranica',
    2 => 'Ukupno posjeta na stranice',
    3 => 'Tekstova(Komentara) na stranicama',
    4 => 'Anketa(Odgovora) na stranicama',
    5 => 'Linkova(Klikova) na stranicama',
    6 => 'Dogaðaja na stranicama',
    7 => 'Prvih deset proèitanih tekstova',
    8 => 'Naslov teksta',
    9 => 'pregledano',
    10 => 'Na stranicama nema niti jednog teksta ili niti jedan tekst nije proèitan.',
    11 => 'Prvih deset komentiranih tekstova',
    12 => 'Komentari',
    13 => 'Na stranicama nema niti jednog poslanog teksta ili teksta na kojem ima komentara.',
    14 => 'Prvih deset anketa',
    15 => 'Pitanje ankete',
    16 => 'Glasova',
    17 => 'Trenutaèno na siteu nema anketa na kojima ima glasova.',
    18 => 'Prvih deset posjeèenih linkova',
    19 => 'Linkovi',
    20 => 'Hits',
    21 => 'Na stranicama nema niti jednog linka ili nema linka na koji je kliknuto bar jedanput.',
    22 => 'Prvih deset prièa poslanih emailom',
    23 => 'Emailovi',
    24 => 'Nitko nije poslao tekst emailom s ovih stranica.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'What\'s Related',
    2 => 'Po¹alji tekst emailom',
    3 => 'Tekst za printanje',
    4 => 'Opcije teksta'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "To submit a {$type} you are required to be logged in as a user.",
    2 => 'Prijava',
    3 => 'Novi korisnik',
    4 => 'Submit a Event',
    5 => 'Submit a Link',
    6 => 'Submit a Story',
    7 => 'Login is Required',
    8 => 'Submit',
    9 => 'When submitting information for use on this site we ask that you follow the following suggestions...<ul><li>Fill in all the fields, they\'re required<li>Provide complete and accurate information<li>Double check those URLs</ul>',
    10 => 'Naziv',
    11 => 'Link',
    12 => 'Poèinje dana',
    13 => 'Zavr¹ava dana',
    14 => 'Lokacija',
    15 => 'Opis',
    16 => 'Ako je drugo, molim precizirajte',
    17 => 'Kategorija',
    18 => 'Ostalo',
    19 => 'Proèitaj prvo',
    20 => 'Gre¹ka: Nedostaje kategorija',
    21 => 'Kada odaberete "Ostalo" molim upi¹ite i novi naziv kategorije.',
    22 => 'Error: Missing Fields',
    23 => 'Please fill in all the fields on the form.  All fields are required.',
    24 => 'Submission Saved',
    25 => "Your {$type} submission has been saved successfully.",
    26 => 'Speed Limit',
    27 => 'Korisnièko ime',
    28 => 'Topic',
    29 => 'Tekst',
    30 => 'Your last submission was ',
    31 => " seconds ago.  This site requires at least {$_CONF['speedlimit']} seconds between submissions",
    32 => 'Pregledaj',
    33 => 'Pregledaj tekst',
    34 => 'Odjava',
    35 => 'HTML kodovi nisu dozvoljeni',
    36 => 'Post Mode',
    37 => "Submitting an event to {$_CONF['site_name']} will put your event on the master calendar where users can optionally add your event to their personal calendar. This feature is <b>NOT</b> meant to store your personal events such as birthdays and anniversaries.<br><br>Once you submit your event it will be sent to our administrators and if approved, your event will appear on the master calendar.",
    38 => 'Add Event To',
    39 => 'Master Calendar',
    40 => 'Personal Calendar',
    41 => 'End Time',
    42 => 'Start Time',
    43 => 'All Day Event',
    44 => 'Address Line 1',
    45 => 'Address Line 2',
    46 => 'City/Town',
    47 => 'State',
    48 => 'Zip Code',
    49 => 'Event Type',
    50 => 'Edit Event Types',
    51 => 'Location',
    52 => 'Delete',
    53 => 'Create Account'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Autorizacija potrebna',
    2 => 'Odbijeno! Neispravne prijavne informacije.',
    3 => 'Neispravna zaporka za korisnika',
    4 => 'Korisnièko ime:',
    5 => 'Zaporka:',
    6 => 'Svaki pokusaj pristupanja administratorskom dijelu bit æe logiran i provjeren.<br>Ovi djelovi su SAMO za OVLA©TENE osobe Svaka zloporaba æe biti sankcionirana.',
    7 => 'prijava'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Neispravna Administracijska prava',
    2 => 'You do not have the necessary rights to edit this block.',
    3 => 'Block Editor',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Block Title',
    6 => 'Topic',
    7 => 'Svi',
    8 => 'Block Security Level',
    9 => 'Block Order',
    10 => 'Block Type',
    11 => 'Portal Block',
    12 => 'Normal Block',
    13 => 'Portal Block Options',
    14 => 'RSS URL',
    15 => 'Last RSS Update',
    16 => 'Normal Block Options',
    17 => 'Block Content',
    18 => 'Please fill in the Block Title and Content fields',
    19 => 'Block Manager',
    20 => 'Block Title',
    21 => 'Block SecLev',
    22 => 'Block Type',
    23 => 'Block Order',
    24 => 'Block Topic',
    25 => 'To modify or delete a block, click on that block below.  To create a new block click on new block above.',
    26 => 'Layout Block',
    27 => 'PHP Block',
    28 => 'PHP Block Options',
    29 => 'Block Function',
    30 => 'If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix "phpblock_" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthesis "()" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.',
    31 => 'Error in PHP Block.  Function, %s, does not exist.',
    32 => 'Error Missing Field(s)',
    33 => 'You must enter the URL to the RSS file for portal blocks',
    34 => 'You must enter the title and the function for PHP blocks',
    35 => 'You must enter the title and the content for normal blocks',
    36 => 'You must enter the content for layout blocks',
    37 => 'Bad PHP block function name',
    38 => 'Functions for PHP Blocks must have the prefix \'phpblock_\' (e.g. phpblock_getweather).  The \'phpblock_\' prefix is required for security reasons to prevent the execution of arbitrary code.',
    39 => 'Side',
    40 => 'Left',
    41 => 'Right',
    42 => 'You must enter the block title and block order for Geeklog default blocks.',
    43 => 'Homepage Only',
    44 => 'Access Denied',
    45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/block.php\">go back to the block administration screen</a>.",
    46 => 'New Block',
    47 => 'Admin Home',
    48 => 'Block Name',
    49 => ' (no spaces and must be unique)',
    50 => 'Help File URL',
    51 => 'include http://',
    52 => 'If you leave this blank the help icon for this block will not be displayed',
    53 => 'Enabled',
    54 => 'save',
    55 => 'cancel',
    56 => 'delete',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Event Editor',
    2 => '',
    3 => 'Event Title',
    4 => 'Event URL',
    5 => 'Event Start Date',
    6 => 'Event End Date',
    7 => 'Event Location',
    8 => 'Event Description',
    9 => '(include http://)',
    10 => 'You must provide the dates/times, description and event location!',
    11 => 'Event Manager',
    12 => 'To modify or delete an event, click on that event below.  To create a new event click on new event above. Click on [C] to create a copy of an existing event.',
    13 => 'Event Title',
    14 => 'Start Date',
    15 => 'End Date',
    16 => 'Access Denied',
    17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/event.php\">go back to the event administration screen</a>.",
    18 => 'New Event',
    19 => 'Admin Home',
    20 => 'save',
    21 => 'cancel',
    22 => 'delete'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Link Editor',
    2 => '',
    3 => 'Link Title',
    4 => 'Link URL',
    5 => 'Category',
    6 => '(include http://)',
    7 => 'Other',
    8 => 'Link Hits',
    9 => 'Link Description',
    10 => 'You need to provide a link Title, URL and Description.',
    11 => 'Link Manager',
    12 => 'To modify or delete a link, click on that link below.  To create a new link click new link above.',
    13 => 'Link Title',
    14 => 'Link Category',
    15 => 'Link URL',
    16 => 'Access Denied',
    17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/link.php\">go back to the link administration screen</a>.",
    18 => 'New Link',
    19 => 'Admin Home',
    20 => 'If other, specify',
    21 => 'save',
    22 => 'cancel',
    23 => 'delete'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Prethodni tekst',
    2 => 'Iduæi tekst',
    3 => 'Mode',
    4 => 'Postavke slanja',
    5 => 'Editiranje teksta',
    6 => 'Nema teksta u sistemu.',
    7 => 'Autor',
    8 => 'snimi',
    9 => 'preview',
    10 => 'poni¹ti',
    11 => 'obri¹i',
    12 => '',
    13 => 'Naslov',
    14 => 'Tema',
    15 => 'Datum',
    16 => 'Intro Text',
    17 => 'Body Text',
    18 => 'Posjeta',
    19 => 'Komentari',
    20 => '',
    21 => '',
    22 => 'Popis tekstova',
    23 => 'To modify or delete a story, click on that story\'s number below. To view a story, click on the title of the story you wish to view. To create a new story click on new story above.',
    24 => '',
    25 => '',
    26 => 'Story Preview',
    27 => '',
    28 => '',
    29 => '',
    30 => 'Gre¹ka u uploadanju datoteke',
    31 => 'Please fill in the Title and Intro Text fields',
    32 => 'Featured',
    33 => 'There can only be one featured story',
    34 => 'Draft',
    35 => 'Da',
    36 => 'Ne',
    37 => 'Vi¹e od',
    38 => 'More from',
    39 => 'Emailovi',
    40 => 'Pristup odbijen',
    41 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF['site_admin_url']}/story.php\">go back to the story administration screen</a> when you are done.",
    42 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF['site_admin_url']}/story.php\">go back to the story administration screen</a>.",
    43 => 'New Story',
    44 => 'Admin Home',
    45 => 'Pristup',
    46 => '<b>NOTE:</b> if you modify this date to be in the future, this article will not be published until that date.  That also means the story will not be included in your RSS headline feed and it will be ignored by the search and statistics pages.',
    47 => 'Slike',
    48 => 'slika',
    49 => 'desno',
    50 => 'lijevo',
    51 => 'To add one of the images you are attaching to this article you need to insert specially formatted text.  The specially formatted text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your story.<BR><P><B>PREVIEWING</B>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    52 => 'Obri¹i',
    53 => 'was not used.  You must include this image in the intro or body before you can save your changes',
    54 => 'Attached Images Not Used',
    55 => 'The following errors occured while trying to save your story.  Please correct these errors before saving',
    56 => 'Prika¾i ikonu teme',
    57 => 'View unscaled image'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'Mode',
    2 => 'Please enter a question and at least one answer.',
    3 => 'Poll Created',
    4 => "Poll {$qid} saved",
    5 => 'Edit Poll',
    6 => 'Poll ID',
    7 => '(do not use spaces)',
    8 => 'Appears on Homepage',
    9 => 'Question',
    10 => 'Answers / Votes',
    11 => "There was an error getting poll answer data about the poll {$qid}",
    12 => "There was an error getting poll question data about the poll {$qid}",
    13 => 'Create Poll',
    14 => 'snimi',
    15 => 'poni¹ti',
    16 => 'obri¹i',
    17 => 'Please enter a Poll ID',
    18 => 'Poll List',
    19 => 'To modify or delete a poll, click on that poll.  To create a new poll click on new poll above.',
    20 => 'Voters',
    21 => 'Access Denied',
    22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/poll.php\">go back to the poll administration screen</a>.",
    23 => 'New Poll',
    24 => 'Admin Home',
    25 => 'Da',
    26 => 'Ne'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Topic Editor',
    2 => 'Topic ID',
    3 => 'Topic Name',
    4 => 'Topic Image',
    5 => '(do not use spaces)',
    6 => 'Deleting a topic deletes all stories and blocks associated with it',
    7 => 'Please fill in the Topic ID and Topic Name fields',
    8 => 'Topic Manager',
    9 => 'To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left. You will find your access level for each topic in parenthesis. The asterisk(*) denotes the default topic.',
    10 => 'Sort Order',
    11 => 'Stories/Page',
    12 => 'Access Denied',
    13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/topic.php\">go back to the topic administration screen</a>.",
    14 => 'Sort Method',
    15 => 'alphabetical',
    16 => 'default is',
    17 => 'New Topic',
    18 => 'Admin Home',
    19 => 'save',
    20 => 'cancel',
    21 => 'delete',
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Korisnièko ureðivanje',
    2 => 'Korisnièki ID',
    3 => 'Korisnièko ime',
    4 => 'Ime i prezime',
    5 => 'Zaporka',
    6 => 'Sigurnosna razina',
    7 => 'Email adresa',
    8 => 'Poèetna stranica',
    9 => '(ne koristite prazan prostor)',
    10 => 'Please fill in the Username and Email Address fields',
    11 => 'Ureðivanje korisnika',
    12 => 'To modify or delete a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a username, email address or fullname (e.g. *son* or *.edu) in the form below.',
    13 => 'Sigurnosna razina',
    14 => 'Datum registracije',
    15 => 'Novi korisnik',
    16 => 'Administracija',
    17 => 'promijeni zaporku',
    18 => 'poni¹ti',
    19 => 'obri¹i',
    20 => 'snimi',
    21 => 'The username you tried saving already exists.',
    22 => 'Gre¹ka',
    23 => 'Batch Add',
    24 => 'Batch Import of Users',
    25 => 'You can import a batch of users into Geeklog.  The import file must be a tab-delimited text file and must have the fields in the following order: full name, username, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'Tra¾i',
    27 => 'Limit Results',
    28 => 'Oznaèite ovdje da bi obrisali sliku.',
    29 => 'Path',
    30 => 'Uvezi',
    31 => 'Novi korisnici',
    32 => 'Done processing. Imported $successes and encountered $failures failures',
    33 => 'potvrdi',
    34 => 'Error: You must specify a file to upload.',
    35 => 'Zadnji put prijavljen',
    36 => '(nikada)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Approve',
    2 => 'Delete',
    3 => 'Edit',
    4 => 'Profile',
    10 => 'Title',
    11 => 'Start Date',
    12 => 'URL',
    13 => 'Category',
    14 => 'Date',
    15 => 'Topic',
    16 => 'User name',
    17 => 'Full name',
    18 => 'Email',
    34 => 'Command and Control',
    35 => 'Story Submissions',
    36 => 'Link Submissions',
    37 => 'Event Submissions',
    38 => 'Submit',
    39 => 'There are no submissions to moderate at this time',
    40 => 'User Submissions'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Nedelja',
    2 => 'Ponedeljak',
    3 => 'Utorak',
    4 => 'Srijeda',
    5 => 'Èetvrtak',
    6 => 'Petak',
    7 => 'Subota',
    8 => 'Dodaj dogaðaj',
    9 => '%s Event',
    10 => 'Events for',
    11 => 'Master Calendar',
    12 => 'Moj kalendar',
    13 => 'Sijeèanj',
    14 => 'Veljaèa',
    15 => 'O¾ujak',
    16 => 'Travanj',
    17 => 'Svibanj',
    18 => 'Lipanj',
    19 => 'Srpanj',
    20 => 'Kolovoz',
    21 => 'Rujan',
    22 => 'Listopad',
    23 => 'Studeni',
    24 => 'Prosinac',
    25 => 'Natrag na ',
    26 => 'Cijeli dan',
    27 => 'Tjedan',
    28 => 'Osobni kalendar za',
    29 => 'Public Calendar',
    30 => 'delete event',
    31 => 'Dodaj',
    32 => 'Event',
    33 => 'Datum',
    34 => 'Vrijeme',
    35 => 'Brzo dodavanje',
    36 => 'Potvrdi',
    37 => 'Sorry, the personal calendar feature is not enabled on this site',
    38 => 'Personal Event Editor',
    39 => 'Dan',
    40 => 'Tjedan',
    41 => 'Mjesec'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Mail postavke",
    2 => 'Od',
    3 => 'Za',
    4 => 'Tema',
    5 => 'Tijelo teksta',
    6 => '©alji:',
    7 => 'Svi korisnici',
    8 => 'Admin',
    9 => 'Opcije',
    10 => 'HTML',
    11 => 'Hitno!',
    12 => '©alji',
    13 => 'Poni¹ti',
    14 => 'Ignoriraj postavke korisnika',
    15 => 'Gre¹ka kad ¹aljem: ',
    16 => 'Uspje¹no je poslana poruka za: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>©alji jo¹ poruka</a>",
    18 => 'Za',
    19 => 'NOTE: if you wish to send a message to all site members, select the Logged-in Users group from the drop down.',
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href=\"{$_CONF['site_admin_url']}/mail.php\">Send another message</a> or you can <a href=\"{$_CONF['site_admin_url']}/moderation.php\">go back to the administration page</a>.",
    21 => 'Failures',
    22 => 'Successes',
    23 => 'No failures',
    24 => 'No successes',
    25 => '-- Odaberite grupu --',
    26 => 'Please fill in all the fields on the form and select a group of users from the drop down.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href="http://www.geeklog.net">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.',
    2 => 'Plug-in Installation Disclaimer',
    3 => 'Plug-in Installation Form',
    4 => 'Plug-in File',
    5 => 'Plug-in List',
    6 => 'Warning: Plug-in Already Installed!',
    7 => 'The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it',
    8 => 'Plugin Compatibility Check Failed',
    9 => 'This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href="http://www.geeklog.net">Geeklog</a> or get a newer version of the plug-in.',
    10 => '<br><b>There are no plugins currently installed.</b><br><br>',
    11 => 'To modify or delete a plug-in, click on that plug-in\'s number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in\'s website. To install or upgrade a plug-in please consult its documentation.',
    12 => 'no plugin name provided to plugineditor()',
    13 => 'Plugin Editor',
    14 => 'New Plug-in',
    15 => 'Admin Home',
    16 => 'Plug-in Name',
    17 => 'Plug-in Version',
    18 => 'Geeklog Version',
    19 => 'Enabled',
    20 => 'Da',
    21 => 'Ne',
    22 => 'Instaliraj',
    23 => 'Snimi',
    24 => 'Poni¹ti',
    25 => 'Obri¹i',
    26 => 'Plug-in Name',
    27 => 'Plug-in Homepage',
    28 => 'Plug-in Version',
    29 => 'Geeklog Version',
    30 => 'Delete Plug-in?',
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'create feed',
    2 => 'snimi',
    3 => 'obri¹i',
    4 => 'poni¹ti',
    10 => 'Content Syndication',
    11 => 'New Feed',
    12 => 'Administracija',
    13 => 'To modify or delete a feed, click on the feed\'s title below. To create a new feed, click on New Feed above.',
    14 => 'Naslov',
    15 => 'Vrsta',
    16 => 'Ime datoteke',
    17 => 'Format',
    18 => 'zadnja obnova',
    19 => 'Enabled',
    20 => 'Da',
    21 => 'Ne',
    22 => '<i>(no feeds)</i>',
    23 => 'all Stories',
    24 => 'Feed Editor',
    25 => 'Feed Title',
    26 => 'Ogranièenje',
    27 => 'Length of entries',
    28 => '(0 = nema teksta, 1 = puni tekst, ostalo = ogranièen broj znakova.)',
    29 => 'Opis',
    30 => 'Zadnja obnova',
    31 => 'Character Set',
    32 => 'Jezik',
    33 => 'Contents',
    34 => 'Entries',
    35 => 'Sati',
    36 => 'Select type of feed',
    37 => 'You have at least one plugin installed that supports content syndication. Below you will need to select whether you want to create a Geeklog feed or a feed from one of the plugins.',
    38 => 'Gre¹ka: Nepotpun unos',
    39 => 'Please fill in the Feed Title, Description, and Filename.',
    40 => 'Please enter a  number of entries or number of hours.',
    41 => 'Linkovi',
    42 => 'Dogaðanja'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Va¹a zaporka vam je poslana emailom. Molimo slijedite upute u tekstu i zahvaljujemo vam ¹to koristite {$_CONF['site_name']}",
    2 => "Hvala ¹to ste poslali tekst na {$_CONF['site_name']}. Tekst æe prvo biti proèitan od strane admina. Ako tekst bude prihvaèen uskoro æe biti javno dostupan na na¹im stranicama.",
    3 => "Hvala ¹to ste poslali link na {$_CONF['site_name']}. Link æe prvo biti provjeren od admina. Ukoliko bude prihvaèen bit æe dostupan u sekciji <a href={$_CONF['site_url']}/links.php>Linkovi</a>.",
    4 => "Thank-you for submitting an event to {$_CONF['site_name']}.  It has been submitted to our staff for approval.  If approved, your event will be seen in our <a href={$_CONF['site_url']}/calendar.php>calendar</a> section.",
    5 => 'Your account information has been successfully saved.',
    6 => 'Your preferences have been successfully saved.',
    7 => 'Your comment preferences have been successfully saved.',
    8 => 'Uspje¹no ste odjavljeni.',
    9 => 'Va¹ tekst je uspje¹no snimljen.',
    10 => 'Tekst je uspje¹no obrisan.',
    11 => 'Your block has been successfully saved.',
    12 => 'The block has been successfully deleted.',
    13 => 'Your topic has been successfully saved.',
    14 => 'The topic and all its stories and blocks have been successfully deleted.',
    15 => 'Va¹ link je uspje¹no zaprimljen.',
    16 => 'Link je uspje¹no obrisan.',
    17 => 'Va¹ dogaðaj je uspje¹no snimljen.',
    18 => 'Dogaðaj je obrisan.',
    19 => 'Your poll has been successfully saved.',
    20 => 'The poll has been successfully deleted.',
    21 => 'The user has been successfully saved.',
    22 => 'The user has been successfully deleted.',
    23 => 'Error trying to add an event to your calendar. There was no event id passed.',
    24 => 'The event has been saved to your calendar',
    25 => 'Nije dozvoljeno kreiranje vlastitog kalendara bez prijavljivanja',
    26 => 'Dogaðaj je uspje¹no maknut iz va¹eg osobnog kalendara',
    27 => 'Poruka je uspje¹no poslana.',
    28 => 'The plug-in has been successfully saved',
    29 => '®ao mi je, osobni kalendar nije dozvoljen na ovim stranicama.',
    30 => 'Pristup odbijen',
    31 => 'Sorry, you do not have access to the story administration page.  Please note that all attempts to access unauthorized features are logged',
    32 => 'Sorry, you do not have access to the topic administration page.  Please note that all attempts to access unauthorized features are logged',
    33 => 'Sorry, you do not have access to the block administration page.  Please note that all attempts to access unauthorized features are logged',
    34 => 'Sorry, you do not have access to the link administration page.  Please note that all attempts to access unauthorized features are logged',
    35 => 'Sorry, you do not have access to the event administration page.  Please note that all attempts to access unauthorized features are logged',
    36 => 'Sorry, you do not have access to the poll administration page.  Please note that all attempts to access unauthorized features are logged',
    37 => 'Sorry, you do not have access to the user administration page.  Please note that all attempts to access unauthorized features are logged',
    38 => 'Sorry, you do not have access to the plugin administration page.  Please note that all attempts to access unauthorized features are logged',
    39 => 'Sorry, you do not have access to the mail administration page.  Please note that all attempts to access unauthorized features are logged',
    40 => 'Poruka sistema',
    41 => 'Sorry, you do not have access to the word replacement page.  Please note that all attempts to access unauthorized features are logged',
    42 => 'Your word has been successfully saved.',
    43 => 'The word has been successfully deleted.',
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.',
    46 => 'Sorry, you do not have access to the database backup utility.  Please note that all attempts to access unauthorized features are logged',
    47 => 'This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.',
    48 => "Thank you for applying for a membership with {$_CONF['site_name']}. Our team will review your application. If approved, your password will be emailed to you at the email address you just entered.",
    49 => 'Your group has been successfully saved.',
    50 => 'The group has been successfully deleted.',
    51 => 'This username is already in use. Please choose another one.',
    52 => 'The email address provided does not appear to be a valid email address.',
    53 => 'Your new password has been accepted. Please use your new password below to log in now.',
    54 => 'Your request for a new password has expired. Please try again below.',
    55 => 'An email has been sent to you and should arrive momentarily. Please follow the directions in the message to set a new password for your account.',
    56 => 'The email address provided is already in use for another account.',
    57 => 'Your account has been successfully deleted.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Pristup',
    'ownerroot' => 'Vlasnik/Administrator',
    'group' => 'Grupa',
    'readonly' => 'Samo èitanje',
    'accessrights' => 'Prava pristupa',
    'owner' => 'Vlasnik',
    'grantgrouplabel' => 'Grant Above Group Edit Rights',
    'permmsg' => 'NOTE: members is all logged in members of the site and anonymous is all users browsing the site that aren\'t logged in.',
    'securitygroups' => 'Security Groups',
    'editrootmsg' => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF['site_admin_url']}/user.php\">User Administration page</a>.",
    'securitygroupsmsg' => 'Select the checkboxes for the groups you want the user to belong to.',
    'groupeditor' => 'Group Editor',
    'description' => 'Opis',
    'name' => 'Ime',
    'rights' => 'Prava',
    'missingfields' => 'Missing Fields',
    'missingfieldsmsg' => 'You must supply the name and a description for a group',
    'groupmanager' => '©ef grupe',
    'newgroupmsg' => 'To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used in the system.',
    'groupname' => 'Ime grupe',
    'coregroup' => 'Sistemska grupa',
    'yes' => 'Da',
    'no' => 'Ne',
    'corerightsdescr' => "This group is a core {$_CONF['site_name']} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
    'groupmsg' => 'Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called \'Rights\'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.',
    'coregroupmsg' => "This group is a core {$_CONF['site_name']} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
    'rightsdescr' => 'A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.',
    'lock' => 'Lock',
    'members' => 'èlanovi',
    'anonymous' => 'Anonimac',
    'permissions' => 'Prava',
    'permissionskey' => 'R = Èita, E = Editira, pravo editiranja ukljuèuje i pravo èitanja',
    'edit' => 'Edit',
    'none' => 'None',
    'accessdenied' => 'Pristup odbijen',
    'storydenialmsg' => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'eventdenialmsg' => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'nogroupsforcoregroup' => 'This group doesn\'t belong to any of the other groups',
    'grouphasnorights' => 'This group doesn\'t have access to any of the administrative features of this site',
    'newgroup' => 'Nova Grupa',
    'adminhome' => 'Admin Home',
    'save' => 'snimi',
    'cancel' => 'odustani',
    'delete' => 'izbri¹i',
    'canteditroot' => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error.',
    'listusers' => 'List Users',
    'listthem' => 'list',
    'usersingroup' => 'Users in group "%s"',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Dodaj',
    'remove' => 'Makni',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Last 10 Back-ups',
    'do_backup' => 'Do Backup',
    'backup_successful' => 'Database back up was successful.',
    'no_backups' => 'No backups in the system',
    'db_explanation' => 'To create a new backup of your Geeklog system, hit the button below',
    'not_found' => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Failed: Filesize was 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} does not exist or is not a directory",
    'no_access' => "ERROR: Directory {$_CONF['backup_path']} is not accessible.",
    'backup_file' => 'Backup file',
    'size' => 'Velièina',
    'bytes' => 'Bytes',
    'total_number' => 'Ukupan broj sigurnosnih backupova: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Poèetna stranica',
    2 => 'Kontakt',
    3 => 'Po¹aljite Tekst',
    4 => 'Linkovi',
    5 => 'Polls',
    6 => 'Kalendar',
    7 => 'Statistika stranice',
    8 => 'Personalizacija',
    9 => 'Tra¾ilica',
    10 => 'napredna tra¾ilica'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Error',
    2 => 'Gee, I\'ve looked everywhere but I can not find <b>%s</b>.',
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

###############################################################################

$LANG_LOGIN = array(
    1 => 'Potrebna prijava',
    2 => 'Sorry, to access this area you need to be logged in as a user.',
    3 => 'Prijava',
    4 => 'Novi korisnik'
);
?>
