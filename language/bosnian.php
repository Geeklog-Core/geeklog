<?php

###############################################################################
# bosnian.php
# This is the bosnian language page for GeekLog!
# Special thanks to me and no one else for work on this project :)
#
# Copyright (C) 2004 Kenan 'bX' Hodzic
# buxus_85@hotmail.com
#       www.bx.net
#
# Iako prevod nije dovrsen kompletno, ili ako korisnici naidju na greske
# molimo da imaju razumjevanja.
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
    2 => 'opsirnije',
    3 => 'komentar(a)',
    4 => 'Edituj',
    5 => 'Anketa',
    6 => 'Rezultati',
    7 => 'Rezultati ankete',
    8 => 'glasova',
    9 => 'Za Administratora:',
    10 => 'Zahtjevi',
    11 => 'Tekstovi',
    12 => 'Blokovi',
    13 => 'Teme',
    14 => 'Linkovi',
    15 => 'Dogadjanja',
    16 => 'Ankete',
    17 => 'Korisnici',
    18 => 'SQL upit',
    19 => 'Odjava',
    20 => 'Korisnicke postavke:',
    21 => 'Korisnicko ime',
    22 => 'Korisnicki ID',
    23 => 'Sigurnosna razina',
    24 => 'Anonimus',
    25 => 'Odgovori',
    26 => 'Sljedeæi komentari su vlasnistvo onog koji ih je napisao. Mi nismo odgovorni na bilo koji nacin u vezi onoga sto autor u njima kaze.',
    27 => 'Najnoviji tekst',
    28 => 'Obrisati',
    29 => 'Nema korisnickih komentara.',
    30 => 'Stariji tekstovi',
    31 => 'Dozvoljeni HTML kodovi:',
    32 => 'Greska, neispravno korisnicko ime',
    33 => 'Greska, ne mogu pisati u log fajlove',
    34 => 'Greska',
    35 => 'Odjava',
    36 => 'on',
    37 => 'Nema korisnickih tekstova',
    38 => 'Razmjena sadrzaja',
    39 => 'Osvjezi',
    40 => 'Imate <tt>register_globals = Off</tt> u vasem <tt>php.ini</tt>. Site zahtjeva da <tt>register_globals</tt> bude <strong>on</strong>. Prije nego sto nastavite, molim postavite to na <strong>on</strong> i restartajte web server.',
    41 => 'Gosti',
    42 => 'Autor:',
    43 => 'Odgovorite na ovo',
    44 => 'Parent',
    45 => 'MySQL greska broj',
    46 => 'MySQL poruka greske',
    47 => 'Korisnici',
    48 => 'Korisnicke postavke',
    49 => 'Postavke racuna',
    50 => 'Error with SQL statement',
    51 => 'pomoc',
    52 => 'Novi',
    53 => 'Administracija',
    54 => 'Ne mogu otvoriti datoteku.',
    55 => 'Greska na',
    56 => 'Glasaj',
    57 => 'Lozinka',
    58 => 'Prijava',
    59 => "Nemate jos korisnicki racun? Kreirajte ga besplatno <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Ovdje</a>",
    60 => 'Posaljite komentar',
    61 => 'Kreiraj Novi Korisnicki racun',
    62 => 'rijeci',
    63 => 'Postavke komentara',
    64 => 'Posalji tekst mailom.',
    65 => 'Pogledaj verziju za printanje',
    66 => 'Moj Kalendar',
    67 => ' ',
    68 => 'pocetna stranica',
    69 => 'kontakt',
    70 => 'trazi',
    71 => 'contribute',
    72 => 'web izvori',
    73 => 'stari glasovi',
    74 => 'kalendar',
    75 => 'poboljsana pretraga',
    76 => 'statistika web stranice',
    77 => 'Pluginovi',
    78 => 'Nadolazeca dogadjanja',
    79 => 'Sta je novo',
    80 => 'tekst(ovi) u posljednih',
    81 => 'tekst(ova) u zadnjih',
    82 => 'sati',
    83 => 'KOMENTARI',
    84 => 'LINKOVI',
    85 => 'posljednih 48 sati',
    86 => 'Nema novih komentara',
    87 => 'posljednje 2 sedmice',
    88 => 'Nema novih linkova',
    89 => 'Nema nadolazecih dogadjanja',
    90 => 'Pocetna stranica',
    91 => 'Stranica generisana za',
    92 => 'sekundi',
    93 => 'Copyright',
    94 => 'Svi zastitni znakovi i autorska prava su vlasnistvo njihovih navedenih vlasnika',
    95 => 'Koristeni software',
    96 => 'Korisnicke grupe',
    97 => 'Lista rijeci',
    98 => 'Dodatni software',
    99 => 'TEKSTOVI',
    100 => 'Nema novih tekstova',
    101 => 'Vasa dogadjanja',
    102 => 'Dogadjanja stranice',
    103 => 'DB Backups',
    104 => 'od',
    105 => 'Salji email',
    106 => 'Pregledano',
    107 => 'Test',
    108 => 'Brisi Cache',
    109 => 'Report abuse',
    110 => 'Report this post to the site admin',
    111 => 'View PDF Version',
    112 => 'Registered Users',
    113 => 'Documentation'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Kalendar dogadjaja',
    2 => 'Zao nam je, trenutno nema nikakvih dogadjanja.',
    3 => 'Kada',
    4 => 'Gdje',
    5 => 'Opis',
    6 => 'Dodaj dogadjaj',
    7 => 'Nadolazeca dogadjanja',
    8 => 'Dodavanjem ovog dogadjanja vasem kalendaru, mozete brzo pregledati samo ona dogadjanja koja vas interesiraju pritiskom na  "Moj kalendar" u korisnickim funkcijama.',
    9 => 'Dodaj u Moj kalendar',
    10 => 'Makni iz Moj kalendar',
    11 => "Dodaj dogadjaj u {$_USER['username']} kalendar",
    12 => 'Dogadjaji',
    13 => 'Pocetak',
    14 => 'Kraj',
    15 => 'Natrag na kalendar'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Posaljite komentar',
    2 => 'Postavke slanja',
    3 => 'Odjava',
    4 => 'Kreirajte korisnicki racun',
    5 => 'Korisnicko ime',
    6 => 'Stranica zahtjeva, da bi poslali komentar, da budete prijavljeni. Molimo prijavite se. Ako nemate korisnicki racun mozete ga napraviti besplatno.',
    7 => 'Vas posljedni komentar je ',
    8 => " sekundi.  Stranice zahtjevaju da prodje vise od {$_CONF['commentspeedlimit']} sekundi medju slanjem komentara",
    9 => 'Komentar',
    10 => 'Send Report',
    11 => 'Salji komentar',
    12 => 'Molim popunite Naziv teksta i Komentar da bi bilo poslano, jer je to neophodno za slanje.',
    13 => 'Vase informacije',
    14 => 'Pregled',
    15 => 'Report this post',
    16 => 'Naslov',
    17 => 'Greska',
    18 => 'Vazno',
    19 => 'Molimo Vas da se vasi komentari pridrzavaju teme.',
    20 => 'Molimo Vas da odgovarate na vec objavljene komentare umjesto da zapocinjete nove teme.',
    21 => 'Prije nego posaljete komentar, molim procitajte komentare ostalih korisnika da bi se izbjeglo ponavljanje.',
    22 => 'Koristite jednostavni naziv teksta da bi bilo jasno o cemu je rijec u va¹em tekstu.',
    23 => 'Vas email nece biti javno dostupan.',
    24 => 'Anonimni korisnik',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Korisnicki profil za',
    2 => 'Korisnicko ime',
    3 => 'Puno ime',
    4 => 'Lozinka',
    5 => 'Email',
    6 => 'Web stranica',
    7 => 'Bio',
    8 => 'PGP kljuc',
    9 => 'Snimi informacije',
    10 => 'Posljednih 10 komentara od korisnika',
    11 => 'Nema korisnickih komentara',
    12 => 'Korisnicke preference za',
    13 => 'Email zabiljeske',
    14 => 'Ova lozinka je kreirana slucajnim izborom. Preporucljivo je promjeniti ovu lozinku sto prije prema vasim zeljama. Da biste promijenili lozinku, logirajte se i pritisnite na Korisnicke informacije u Korisnickom meniu.',
    15 => "Vas {$_CONF['site_name']} racun je uspjesno kreiran. Da biste ga mogli koristiti, morate se loginovati koristeci vase informacije. Molimo sacuvaj ovaj mail za buduce reference.",
    16 => 'Informacije o vasem korisnickom racunu',
    17 => 'Korisnicki racun ne postoji',
    18 => 'Upisana email addresa nije validna.',
    19 => 'Korisnicko ime ili email adresa koju ste unijeli vec postoji u bazi.',
    20 => 'Email adresu koju ste unijeli ne mozemo prihvatiti jer nije odgovarajuce forme',
    21 => 'Greska',
    22 => "Registriran na {$_CONF['site_name']}!",
    23 => "Kreiranjem korisnickog racuna imat cete samo prednosti na {$_CONF['site_name']} i moci cete koristiti neke funkcije koje obicni korisnici nemogu. Ako nemate racun, sve sto uradite bit ce zabiljezeno kao anoniman korisnik. Molimo zabiljezite da vas email <b><i>nikada</i></b> nece biti javno prikazan na ovom siteu.",
    24 => 'Lozinka ce biti poslana na email adresu koju ste unijeli.',
    25 => 'Zabopravili ste lozinku?',
    26 => 'Ukucajte <em>vas</em> username <em>ili</em> email addresu koju ste koristili za registraciju i kliknite Email Password. Instrukcije za kako cete postaviti novu lozinku ce biti poslate sa porukom na vas mail.',
    27 => 'Registriraj se sada!',
    28 => 'Lozinka poslana emailom',
    29 => 'forma za odjavu',
    30 => 'forma za prijavu',
    31 => 'Izabrane funkcije zahtjevaju od vas da budete rijavljeni kao clan.',
    32 => 'Potpis',
    33 => 'Nikad ne prikazuj javno',
    34 => 'Ovo je tvoje pravo ime',
    35 => 'Unesite novu lozinku za promjenu',
    36 => 'Pocinje sa http://',
    37 => 'Bit ce dodano na vase komentare',
    38 => 'Sve o vama! Svi to mogu citati',
    39 => 'Vas javni PGP kljuc',
    40 => 'Tema nema ikonu',
    41 => 'Zelite biti moderator',
    42 => 'Format datuma',
    43 => 'Maksimalno tekstova',
    44 => 'Nema boxova',
    45 => 'Postavke prikazivanja za',
    46 => 'Djelovi za izvrsavanje za',
    47 => 'Konfiguracija vijesti za',
    48 => 'Teme',
    49 => 'Nema ikone u tekstu',
    50 => 'Odznacite ovo ako niste zainteresirani',
    51 => 'Samo novi tekstovi',
    52 => 'Obicni je',
    53 => 'Primi nove vijesti svaku noc',
    54 => 'Oznaci boxove za naslove i autore koje ne zelis vidjeti.',
    55 => 'Ako ovo ostavite kako jeste, to znaci da hocete obicne selekcije boxova. Ako pocnete birati boxove, zapamtite da postavite sve one koje zelite zato jer ce obicna postavka biti zanemarena. Obicne postavke su prikazene podebljane.',
    56 => 'Autori',
    57 => 'Nacin prikazivanja',
    58 => 'Sortiraj po',
    59 => 'Limit komentara',
    60 => 'Kako zelite da se vasi komentari prikazuju?',
    61 => 'Noviji ili stariji prvo?',
    62 => 'Obicni je 100',
    63 => "Vasa lozinka vam je poslana putem emaila i trebali biste je primiti svakog momenta. Molimo pratite instrukcije koje ste dobili u poruci i zahvaljujemo vam za prijavu na {$_CONF['site_name']}",
    64 => 'Preference komentara ca',
    65 => 'Pokusajte ponoviti prijavu',
    66 => "Vjerovatno ste pogresno unijeli korisnicko ime ili lozinku. Pokusajte se ponovo prijaviti. Jeste li <a href=\"{$_CONF['site_url']}/users.php?mode=new\">novi korisnik</a>?",
    67 => 'Clan od',
    68 => 'Pamti me',
    69 => 'Koliko dugo da vas pamtimo od prijave?',
    70 => "Postavi izgled sitea {$_CONF['site_name']}",
    71 => "Jedna od velikih prednosti {$_CONF['site_name']} Je ta sto mozete promjeniti izgled site po vasoj volji. Da biste to mogli uciniti morate se prvo <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrovati</a> na {$_CONF['site_name']}. Ako ste vec clan, koristite vase podatke i prijavite se!",
    72 => 'Tema',
    73 => 'Jezik',
    74 => 'Promijeni izgled sitea!',
    75 => 'Emaileovane vijesti za',
    76 => 'Ako selektujete vrstu vijeste iz liste ispod, primit cete svaku novu pricu vezanu za tu vrstu vijest na kraju svakog dana. Izaberi jedino onu vrstu vijesti koje ti se svidjaju!',
    77 => 'Fotografija',
    78 => 'Dodaj vlastitu fotografiju!',
    79 => 'Oznaci ovdje za brisanje fotografije',
    80 => 'Prijava',
    81 => 'Salji email',
    82 => 'Posljednih 10 tekstova od korisnika',
    83 => 'Statistika slanja tekstova i komentara od korisnika',
    84 => 'Ukupan broj tekstova:',
    85 => 'Ukupan broj komentara:',
    86 => 'Pronadji sve tekstove od',
    87 => 'Vase korisnicko ime',
    88 => "Neko (vjerovatno vi) je zatrazio novu lozinku za vas korisnicki racun \"%s\" na {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nAko ste to zaista htjeli molim kliknite na ovaj link za potvrdu:\n\n",
    89 => "Ako ne zelite to napraviti, jednostavno ignorirajte poruku (lozinka ce ostati nepromijenjena).\n\n",
    90 => 'Mozete ukucati novu lozinku za vas racun ispod. Molimo zabiljezite da ja vasa stara lozinka idalje validna dok ne posaljete novu.',
    91 => 'Postavi novu lozinku',
    92 => 'Unesi novu lozinku',
    93 => 'Vas poslijenji zahtjev za novom lozinkom je bio prije %d sekundi. Ovaj site zahtjeva barem %d sekundi izmedju zahtjeva za lozinku.',
    94 => 'Obrisi korisnicki racun "%s"',
    95 => 'Pritisni "Obrisi korisnicki racun" dugme ispod da biste izbrisali svoj racun iz nase baze podataka. Molimo zabiljezite da bilo koja vijest ili komentar poslata sa vase strane pod ovim korisnickim racunom <strong>nece</strong> biti izbrisana, nego prikazana kao da ju je poslao "Anonymous".',
    96 => 'obrisite korisnicki racun',
    97 => 'Potvrdi brisanje korisnickog racuna',
    98 => 'Dali ste sigurni da zelite izbrisati vas racun? Ako to zelite uraditi necete vise moci koristiti ovaj site kako ste prije mogli (ukoliko ne kreirate novi racun). Ako ste sigurni da to zelite uraditi ritisnite "obrisi korisnicki racun".',
    99 => 'Opcije privatnosti za ',
    100 => 'Email od administratora',
    101 => 'Dozvoli mailove od webmastera',
    102 => 'Email od korisnika',
    103 => 'Dozvoli primanje emailova od korisnika',
    104 => 'Prikazi online status',
    105 => 'Pokazi ko je online u bloku',
    106 => 'Location',
    107 => 'Shown in your public profile'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Nema novosti za prikazivanje.',
    2 => 'Nema novih vijesti za prikazati. Mozda nema novih vijesti za ovu vrstu ili je do necega drugog :)',
    3 => ' za temu %s',
    4 => 'Danasnji vazniji tekstovi',
    5 => 'Iduci',
    6 => 'Prijasnji',
    7 => 'First',
    8 => 'Last'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'Linkovi',
    2 => 'Nema linkova za prikazati.',
    3 => 'Dodaj link'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'Glas spasen',
    2 => 'Vas glas je zapisan.',
    3 => 'Glas',
    4 => 'Anketa na stranicama',
    5 => 'Glasova',
    6 => 'Pogledajte ostale ankete'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Prilikom slanja dogodila se greska. Molimo pokusajte ponovo.',
    2 => 'Poruka je uspjesno poslana.',
    3 => 'Molimo osigurajte da koristite validnu email adresu u Primalac formi.',
    4 => 'Molimo popunite polja: Vase ime, Primalac, Naziv maila i Poruku',
    5 => 'Greska: Korisnik ne postoji.',
    6 => 'Pojavila se greska.',
    7 => 'Korisnicki profil za',
    8 => 'Korisnicko ime',
    9 => 'Korisnicki URL',
    10 => 'Salji email',
    11 => 'Vase ime:',
    12 => 'Primalac:',
    13 => 'Naziv maila:',
    14 => 'Poruka:',
    15 => 'HTML kod nece biti prikazan.',
    16 => 'Salji poruku',
    17 => 'Posalji tekst emailom',
    18 => 'Saljete (kome)',
    19 => 'Na email adresu',
    20 => 'Od',
    21 => 'Od email adrese',
    22 => 'Potrebno je sve popuniti',
    23 => "Ovaj email vam je poslan od %s sa %s zato jer je mislio da ce vas zanimati tekst s web stranice {$_CONF['site_url']}.  Ovo NIJE SPAM, i vase email adrese nisu sacuvane i nece se koristiti za daljnju upotrebu.",
    24 => 'Komentar za ovu vijest na',
    25 => 'Morate biti prijavljeni da bi mogli koristiti ovu postavku.',
    26 => 'Ovaj formular vam dozvoljava slanje emailova odredjenim korisnicima. Potrebno je popuniti sve podatke.',
    27 => 'Kratka poruka',
    28 => '%s pise: ',
    29 => "Ovo su dnevne obavijesti sa {$_CONF['site_name']} za ",
    30 => ' Dnevne obavijesti za ',
    31 => 'Naziv',
    32 => 'Datum',
    33 => 'Procitaj punu vijest na',
    34 => 'Kraj poruke',
    35 => 'Zao mi je, korisnik ne dozvoljava primanje nikakvih poruka.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Napredno pretrazivanje',
    2 => 'Kljucne rijeci',
    3 => 'Naslovi',
    4 => 'Svi',
    5 => 'Vrsta',
    6 => 'Tekstovi',
    7 => 'Komentari',
    8 => 'Autori',
    9 => 'Svi',
    10 => 'Pretrazivanje',
    11 => 'Rezultati pretrazivanja',
    12 => 'odgovara',
    13 => 'Rezultati pretrazivanja: Nema rezultata',
    14 => 'Nema rezultata koji odgovaraju vasem upitu',
    15 => 'Molim pokusajte ponovo.',
    16 => 'Naslov',
    17 => 'Datum',
    18 => 'Autor',
    19 => "Pretrazite bazu podataka web stranice {$_CONF['site_name']} trenutacnih i starijih tekstova",
    20 => 'Datum',
    21 => 'do',
    22 => '(Format datuma GGGG-MM-DD)',
    23 => 'Pregleda',
    24 => 'Pronadjeno %d rezultata',
    25 => 'Trazeno za',
    26 => 'upita ',
    27 => 'sekundi',
    28 => 'Nema odgovarajucih tekstova ili komentara prema vasem upitu',
    29 => 'Rezultati tekstova i komentara',
    30 => 'Nema linkova koji odgovaraju vasem upitu',
    31 => 'Ovaj ponovni plug-in nije nista pronasao',
    32 => 'Dogadjaj',
    33 => 'URL',
    34 => 'Lokacija',
    35 => 'Cijeli dan',
    36 => 'Nema dogadjaja koji odgovaraju vasem upitu',
    37 => 'Rezultati dogadjaja',
    38 => 'Rezultati linkova',
    39 => 'Linkovi',
    40 => 'Dogadjaji',
    41 => 'Vas upit mora sadrzavati vise od 3 znaka.',
    42 => 'Molim koristite format datuma GGGG-MM-DD (godina-mjesec-dan).',
    43 => 'tacan izraz',
    44 => 'sve rijeci',
    45 => 'bilo koja od ovih rijeci',
    46 => 'Iduci',
    47 => 'Prijasnji',
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
    6 => 'Dogadjaja na stranicama',
    7 => 'Prvih deset procitanih tekstova',
    8 => 'Naslov teksta',
    9 => 'pregledano',
    10 => 'Na stranicama nema niti jednog teksta ili niti jedan tekst nije procitan.',
    11 => 'Prvih deset komentiranih tekstova',
    12 => 'Komentari',
    13 => 'Na stranicama nema niti jednog poslanog teksta ili teksta na kojem ima komentara.',
    14 => 'Prvih deset anketa',
    15 => 'Pitanje ankete',
    16 => 'Glasova',
    17 => 'Trenutacno na siteu nema anketa na kojima ima glasova.',
    18 => 'Prvih deset posjecenih linkova',
    19 => 'Linkovi',
    20 => 'Hits',
    21 => 'Na stranicama nema niti jednog linka ili nema linka na koji je kliknuto bar jedanput.',
    22 => 'Prvih deset tekstova poslanih emailom',
    23 => 'Emailovi',
    24 => 'Niko nije poslao tekst emailom s ovih stranica.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Linkovi u tekstu',
    2 => 'Posalji tekst emailom',
    3 => 'Tekst za printanje',
    4 => 'Opcije teksta',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Za prijavljivanje %s potrebno je biti ulogiran.',
    2 => 'Prijava',
    3 => 'Novi korisnik',
    4 => 'Posaljite info o dogadjaju',
    5 => 'Posaljite Link',
    6 => 'Posaljite tekst',
    7 => 'Login je potreban',
    8 => 'Potvrdi',
    9 => 'Kada saljete potrebne informacije na ovaj site pitamo dali pratite slijedece sugestije suggestions...<ul><li>Popuni sva polja, ona su obavezna<li>Omoguci kompletne i tacne informacije<li>Dva puta provjeti ove URLove</ul>',
    10 => 'Naziv',
    11 => 'Link',
    12 => 'Pocinje dana',
    13 => 'Zavrsava dana',
    14 => 'Lokacija',
    15 => 'Opis',
    16 => 'Ako je drugo, molim precizirajte',
    17 => 'Kategorija',
    18 => 'Ostalo',
    19 => 'Procitaj prvo',
    20 => 'Greska: Nedostaje kategorija',
    21 => 'Kada odaberete "Ostalo" molim upisite i novi naziv kategorije.',
    22 => 'Greska: Popunite sva polja',
    23 => 'Molimo popunite sva polja. Sva polja su obavezna.',
    24 => 'Submisia spasena',
    25 => 'Vasa %s submisia je uspjesno spasena.',
    26 => 'Ogranicena brzina',
    27 => 'Korisnicko ime',
    28 => 'Topic',
    29 => 'Tekst',
    30 => 'Vasa poslijednja submisia bila je prije ',
    31 => " sekunda. Ovaj site zahtjeva barem {$_CONF['speedlimit']} sekundi izmedju submisia",
    32 => 'Pregledaj',
    33 => 'Pregledaj tekst',
    34 => 'Odjava',
    35 => 'HTML kodovi nisu dozvoljeni',
    36 => 'Nacin slanja',
    37 => "Slanje dogadjaja na {$_CONF['site_name']} ce postaviti vas dogadjaj na glavni kalendar gdje ce korisnici moci dodati vas dogadjaj na njihov vlastiti kalendatr. Ovo <b>NE</b> znaci da mozete postavljati vase vlastite dogadjaje kao sto su rodjendan ili bilo kakva godisnjica.<br><br>Kada jednom posaljete vas dogadjaj on ce automatski biti poslat vasim administratorima i u slucaju njegovog odobravanja, vas dogadjaj ce se pojaviti na glavnom kalendaru.",
    38 => 'Dodaj dogadjaj na',
    39 => 'Glavni Kalendar',
    40 => 'Vlastiti Kalendar',
    41 => 'Vrijeme zavrsetka',
    42 => 'Vrijeme pocetka',
    43 => 'Svakodnevni dogadjaji',
    44 => 'Adresa 1',
    45 => 'Adresa 2',
    46 => 'Grad',
    47 => 'Drzava',
    48 => 'Zip kod',
    49 => 'Ti dogadjaja',
    50 => 'Uredi tipove dogadjaja',
    51 => 'Lokacija',
    52 => 'Izbrisi',
    53 => 'Kreiraj racun'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Autorizacija potrebna',
    2 => 'Odbijeno! Neispravne prijavne informacije.',
    3 => 'Neispravna lozinka za korisnika',
    4 => 'Korisnièko ime:',
    5 => 'lozinka:',
    6 => 'Svaki pokusaj pristupanja administratorskom dijelu bit æe logiran i provjeren.<br>Ovi djelovi su SAMO za OVLA©TENE osobe Svaka zloporaba æe biti sankcionirana.',
    7 => 'prijava'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Neispravna Administracijska prava',
    2 => 'Nemate potrebna prava da biste uredili ovaj Blok.',
    3 => 'Blok Editor',
    4 => 'Pojavio se problem citajuci ovaj dio (pogledaj error.log za detalje).',
    5 => 'Naziv Bloka',
    6 => 'Naziv',
    7 => 'Svi',
    8 => 'Sigurnosni nivo Bloka',
    9 => 'Zadatak Bloka',
    10 => 'Tip Bloka',
    11 => 'Portalni Blok',
    12 => 'Normalni Blok',
    13 => 'Opcije Portalnog Bloka',
    14 => 'RSS URL',
    15 => 'Poslijednji RSS Update',
    16 => 'Opcije Normalnog Bloka',
    17 => 'Sadrzaj Bloka',
    18 => 'Molimo popunite Naziv Bloka i polja sa sadrzajem',
    19 => 'Blok Menadzer',
    20 => 'Naziv Bloka',
    21 => 'Specijalni nivo Bloka',
    22 => 'Tip Bloka',
    23 => 'Zadatak Bloka',
    24 => 'Naziv Bloka',
    25 => 'Da biste modifikovali Blok ili ga izbrisali, kliknite dole na zeljeni link. Da biste napravili novi Blok, pritisnite na novi blok iznad.',
    26 => 'Izgled Bloka',
    27 => 'PHP Blok',
    28 => 'Opcije PHP Bloka',
    29 => 'Funkcije Bloka',
    30 => 'Ako zelite da imate jedan svoj Blok koristi PHP kod, upisi ime funkcije iznad. Ime tvoje funkcije mora poceti sa prefiksom "phpblock_" (npr. phpblock_getweather). Ako nema ovaj prefiks, tvoja funkcija NECE biti pozvana. Ovo radimo radi toga da bismo zadrzali ljude (HACKERI) koji su mozda uspjeli upasti u vas proces insllacije mjenjajuci neke funkcije i pozivajuci se na njih i koje mogu biti stetne za vas sistem. Budite sigurni da negdje ne ostavite prazne zagrade "()" poslije vaseg imena funkcije. Na poslijetku, preporucljivo je da smjestite sve svoje PHP kodove Blokova u /path/to/geeklog/system/lib-custom.php. To ce omoguciti kodu da ostane sa tobom i na mjestu i kada nadogradis svoju verziju Geekloga.',
    31 => 'Greska u PHP Bloku. Funkcija, %s, ne postoji.',
    32 => 'Greska, nedostaje/u polje/a',
    33 => 'Moras navesti URL za pristup RSS fileu za portalni blok',
    34 => 'Moras navesti naziv i funkciju za PHP blokove',
    35 => 'Moras upisati naziv i sadrzaj za normalne blokove',
    36 => 'Moras upisati sadrzaj za izgled blokova',
    37 => 'Lose ime funkcije PHP bloka',
    38 => 'Funkcije za PHP Blokove moraju imati prefiks \'phpblock_\' (npr. phpblock_getweather). Prefiks \'phpblock_\' je potreban iz sigurnosnih razloga da bi zastitio dio koda za izvrsavanje.',
    39 => 'Strana',
    40 => 'Lijevo',
    41 => 'Desno',
    42 => 'Moras navesti Ime Bloka i Namjenu Bloka za obicne Geeklog blokove.',
    43 => 'Jedino na pocetnoj strani(Home/index)',
    44 => 'Pristup odbijen',
    45 => "Pokusavas pristupati bloku za koji nemas prava pristupa. Ovaj pokusaj pristupa je zabiljezen. Molimo <a href=\"{$_CONF['site_admin_url']}/block.php\">vratite se nazad</a>.",
    46 => 'Novi Block',
    47 => 'Administracija',
    48 => 'Naziv Bloka',
    49 => ' (nema odvajanja i mora biti jedinstven)',
    50 => 'Help File URL',
    51 => 'ukljucujuci http://',
    52 => 'Ako ostavite ovo praznim help ikona za ovaj blok se nece prikazati',
    53 => 'Omoguci',
    54 => 'spasi',
    55 => 'odustani',
    56 => 'izbrisi',
    57 => 'Pomjeri Blok dole',
    58 => 'Pomjeri Blok gore',
    59 => 'Prebaci Blok na desnu stranu',
    60 => 'Prebaci Blok na lijevu stranu'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Editiranje dogaðaja',
    2 => 'Error',
    3 => 'Naziv dogadjaja',
    4 => 'URL dogadjaja',
    5 => 'Datum opcetka dogadjaja',
    6 => 'Datum zavrsetka dogadjaja',
    7 => 'Lokacija dogadjaja',
    8 => 'Opis dogadjaja',
    9 => '(ukljucujuci http://)',
    10 => 'Moras omoguciti datum/vrijeme, opis i lokaciju dogadjaja!',
    11 => 'Menadzer dogadjaja',
    12 => 'Da biste uredili ili dodali dogadjaj, kliknite dole na zeljeni link. Da biste kreirali novi dogadjaj kliknite iznad na novi dogadjaj. Pritisnite na [C] da biste kreirali ili napravili postojeci dogadjaj.',
    13 => 'Naziv dogadjaja',
    14 => 'Pocetak (datum)',
    15 => 'Kraj (datum)',
    16 => 'Pristup Odbijen',
    17 => "Pokusavas pristupati dogadjaju za koji nemas prava pristupa. Ovaj pokusaj pristupa je zabiljezen. Molimo <a href=\"{$_CONF['site_admin_url']}/event.php\">vratite se nazad</a>.",
    18 => 'Novi dogadjaj',
    19 => 'Admin Home',
    20 => 'snimi',
    21 => 'ponisti',
    22 => 'obrisi',
    23 => 'Bad start date.',
    24 => 'Bad end date.',
    25 => 'End date is before start date.'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Uredjivanje linkova',
    2 => '',
    3 => 'Naziv linka',
    4 => 'URL linka',
    5 => 'Kategorija',
    6 => '(ukljucujuci http://)',
    7 => 'Nova kategorija',
    8 => 'Link Klik',
    9 => 'Opis linka',
    10 => 'Potrebno je unijeti Naziv linka, URL i Opis.',
    11 => 'Link Menadzer',
    12 => 'Ako zelite modificirati ili obrisati link, kliknite dole na zeljeni link. Ako zelite dodati novi link kliknite iznad na Novi link.',
    13 => 'Naziv linka',
    14 => 'Kategorija linka',
    15 => 'URL linka',
    16 => 'Pristup odbijen',
    17 => "Pokusavas pristupati linku za koji nemas prava pristupa. Ovaj pokusaj pristupa je zabiljezen. Molimo <a href=\"{$_CONF['site_admin_url']}/link.php\">vratite se nazad</a>.",
    18 => 'Novi link',
    19 => 'Administracija',
    20 => 'Ako je Nova kategorija, molimo unesite naziv nove kategorije.',
    21 => 'snimi',
    22 => 'ponisti',
    23 => 'obrisi'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Prethodni tekst',
    2 => 'Iduci tekst',
    3 => 'Mode',
    4 => 'Postavke slanja',
    5 => 'Editiranje teksta',
    6 => 'Nema teksta u sistemu.',
    7 => 'Autor',
    8 => 'snimi',
    9 => 'pregled',
    10 => 'ponisti',
    11 => 'obrisi',
    12 => 'ID',
    13 => 'Naslov',
    14 => 'Tema',
    15 => 'Datum',
    16 => 'Uvodni tekst',
    17 => 'Tijelo teksta',
    18 => 'Posjeta',
    19 => 'Komentari',
    20 => '',
    21 => '',
    22 => 'Popis tekstova',
    23 => 'Da biste uredili ili izbrisali vijest, pritisnite an broj vijesti ispod. Da biste pregledali vijest, pritisnite na naziv vijesti koju zelite pregledati. Ako zelite napisati novu vijest izaberite opciju nova vijest iznad.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => '',
    26 => 'Pregled teksta',
    27 => '',
    28 => '',
    29 => '',
    30 => 'Greska u uploadanju datoteke',
    31 => 'Molimo popunite polja sa Nazivom i Uvodnim tekstom',
    32 => 'Featured',
    33 => 'There can only be one featured story',
    34 => 'Draft',
    35 => 'Da',
    36 => 'Ne',
    37 => 'Vise od',
    38 => 'Vise sa',
    39 => 'Emailovi',
    40 => 'Pristup odbijen',
    41 => "Pokusavas pristupati vijesti za koju nemas prava pristupa. Ovaj pokusaj pristupa je zabiljezen. Mozete pogledati vijest u dijelu read-only ispod. Molimo <a href=\"{$_CONF['site_admin_url']}/story.php\">vratite se nazad</a> kada zavrsite.",
    42 => "Pokusavas pristupati vijesti za koju nemas prava pristupa. Ovaj pokusaj pristupa je zabiljezen. Molimo <a href=\"{$_CONF['site_admin_url']}/story.php\">vratite se nazad</a>.",
    43 => 'Novi tekst',
    44 => 'Admin Home',
    45 => 'Pristup',
    46 => '<b>ZABILJESKA:</b> ako uredite ovaj datum da se prikaze u buducnosti, ova vijest se nece objaviti sve do tog datuma. To takodje znaci da ta vijest nece biti ukljucena u vas RSS headline feed i biti ce ignorirana u stranicama za pretrazivanje i statickim stranicama.',
    47 => 'Slike',
    48 => 'slika',
    49 => 'desno',
    50 => 'lijevo',
    51 => 'Da biste dodali jednu od vasih slika odredjenoj vijesti morate ubaciti specijano formirani tekst. Taj tekst izgleda ovako [imageX], [imageX_right] ili [imageX_left] gdje je X broj slike koju ste ubacili. ZABILJESKA: Morate koristiti sliku koju ste vec odabrali za tu vijest. Ako to ne ucinite necete moci spasiti vasu vijest.<BR><P><B>PREGLED</B>: Pregled price sa ubacenom slikom je najbolje kada se prvo spasi slika kao draft umjesto pritiska dugmeta preview. Koristite dugme preview jedino kada u tekst nije ukljucena slika.',
    52 => 'Obrisi',
    53 => 'nije koristena. Morate ukljuciti ovu sliku u intro ili body prije nego spasite vase izmjene',
    54 => 'Ukljucene slike nisu koristene',
    55 => 'The following errors occured while trying to save your story.  Please correct these errors before saving',
    56 => 'Prikazi ikonu teme',
    57 => 'View unscaled image',
    58 => 'Story Management',
    59 => 'Option',
    60 => 'Enabled',
    61 => 'Auto Archive',
    62 => 'Auto Delete'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'Mod',
    2 => 'Molimo unesite pitanje i najmanje dva odgovora..',
    3 => 'Anketa kreirana',
    4 => 'Ankete %s snimljena',
    5 => 'Uredjivanje ankete',
    6 => 'ID Ankete',
    7 => '(ne koristite prazan prostor)',
    8 => 'Prikazi na pocetnoj strani',
    9 => 'Pitanje ankete',
    10 => 'Odgovora / Glasova',
    11 => 'Pojavila se greska prilikom prikupljanja odgovora iz ankete %s',
    12 => 'Pojavila se greska prilikom prikupljanja pitanja iz ankete %s',
    13 => 'Kreirajte anketu.',
    14 => 'snimi',
    15 => 'ponisti',
    16 => 'obrisi',
    17 => 'Molim unesite ID ankete.',
    18 => 'Lista anketa',
    19 => 'Da biste uredili ili izbrisali anketu pritisnite na tu anketu. Ako zelite napraviti novu anketu pritisnite na nova anketa iznad.',
    20 => 'Glasaci',
    21 => 'Pristup odbijen',
    22 => "Pokusali ste pristupiti anketi ali nemate potrebna odobrenja. Ovaj pokusaj je logiran. Molimo <a href=\"{$_CONF['site_admin_url']}/poll.php\">vratite se natrag</a>.",
    23 => 'Nova anketa',
    24 => 'Administracija',
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
    10 => 'Sortirano po',
    11 => 'Stories/Page',
    12 => 'Pristup odbijen.',
    13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF['site_admin_url']}/topic.php\">go back to the topic administration screen</a>.",
    14 => 'Metode sortiranja',
    15 => 'abecedno',
    16 => 'default is',
    17 => 'Nova tema',
    18 => 'Admin Home',
    19 => 'snimi',
    20 => 'ponisti',
    21 => 'obrisi',
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)',
    25 => 'Archive Topic',
    26 => 'make this the default topic for archived stories. Only one topic allowed.'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Korisnicko uredjivanje',
    2 => 'Korisnicki ID',
    3 => 'Korisnicko ime',
    4 => 'Ime i prezime',
    5 => 'Lozinka',
    6 => 'Sigurnosna razina',
    7 => 'Email adresa',
    8 => 'Pocetna stranica',
    9 => '(ne koristite prazan prostor)',
    10 => 'Please fill in the Username and Email Address fields',
    11 => 'Uredjivanje korisnika',
    12 => 'To modify or delete a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a username, email address or fullname (e.g. *son* or *.edu) in the form below.',
    13 => 'Sigurnosna razina',
    14 => 'Datum registracije',
    15 => 'Novi korisnik',
    16 => 'Administracija',
    17 => 'promijeni lozinku',
    18 => 'ponisti',
    19 => 'obrisi',
    20 => 'snimi',
    21 => 'The username you tried saving already exists.',
    22 => 'Greska',
    23 => 'Batch Add',
    24 => 'Batch Import of Users',
    25 => 'You can import a batch of users into Geeklog.  The import file must be a tab-delimited text file and must have the fields in the following order: full name, username, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'Trazi',
    27 => 'Limit Results',
    28 => 'Oznacite ovdje da bi obrisali sliku.',
    29 => 'Path',
    30 => 'Uvezi',
    31 => 'Novi korisnici',
    32 => 'Done processing. Imported %d and encountered %d failures',
    33 => 'potvrdi',
    34 => 'Error: You must specify a file to upload.',
    35 => 'Zadnji put prijavljen',
    36 => '(nikada)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Prihvati',
    2 => 'Obrisi',
    3 => 'Azuriraj',
    4 => 'Profil',
    10 => 'Naziv',
    11 => 'Pocinje dana',
    12 => 'URL',
    13 => 'Kategorija',
    14 => 'Datum',
    15 => 'Tema',
    16 => 'User name',
    17 => 'Full name',
    18 => 'Email',
    34 => 'Command and Control',
    35 => 'Zahtjev za postavljanje teksta.',
    36 => 'Zahtjev za postavljanje linka.',
    37 => 'Zahtjev za postavljanje dogadjaja.',
    38 => 'Potvrdi',
    39 => 'Trenutacno nema zahtjeva za administraciju-',
    40 => 'Zahtjev za reg. novih korisnika'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Nedelja',
    2 => 'Ponedeljak',
    3 => 'Utorak',
    4 => 'Srijeda',
    5 => 'Cetvrtak',
    6 => 'Petak',
    7 => 'Subota',
    8 => 'Dodaj dogaðaj',
    9 => '%s Event',
    10 => 'Events for',
    11 => 'Master Calendar',
    12 => 'Moj kalendar',
    13 => 'Januar',
    14 => 'Februar',
    15 => 'Mart',
    16 => 'April',
    17 => 'Maj',
    18 => 'Juni',
    19 => 'Juli',
    20 => 'August',
    21 => 'Septembar',
    22 => 'Oktobar',
    23 => 'Novembar',
    24 => 'Decembar',
    25 => 'Natrag na ',
    26 => 'Cijeli dan',
    27 => 'Sedmica',
    28 => 'Osobni kalendar za',
    29 => 'Javni kalendar',
    30 => 'obrisi dogadjaj',
    31 => 'Dodaj',
    32 => 'Dogadjaj',
    33 => 'Datum',
    34 => 'Vrijeme',
    35 => 'Brzo dodavanje',
    36 => 'Potvrdi',
    37 => 'Zao mi je. Mogucnost uporabe osobnog kalendara na ovim stranicama nije dozvoljena.',
    38 => 'Osobni editor dogadjaja',
    39 => 'Dan',
    40 => 'Sedmica',
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
    6 => 'Salji:',
    7 => 'Svi korisnici',
    8 => 'Admin',
    9 => 'Opcije',
    10 => 'HTML',
    11 => 'Hitno!',
    12 => 'Salji',
    13 => 'Ponisti',
    14 => 'Ignoriraj postavke korisnika',
    15 => 'Greska kad saljem: ',
    16 => 'Uspjesno je poslana poruka za: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Salji jos poruka</a>",
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
    14 => 'Novi plugin',
    15 => 'Administracija',
    16 => 'Plug-in Name',
    17 => 'Plug-in Version',
    18 => 'Geeklog Version',
    19 => 'Enabled',
    20 => 'Da',
    21 => 'Ne',
    22 => 'Instaliraj',
    23 => 'Snimi',
    24 => 'Ponisti',
    25 => 'Obrisi',
    26 => 'Ime plugina',
    27 => 'Web stranica plugina',
    28 => 'Verzija plugina',
    29 => 'Geeklog Version',
    30 => 'Obrisati plugin?',
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.',
    32 => '<p><b>Error AutoLink tag not correct format</b></p>',
    33 => 'Code Version',
    34 => 'Update'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'create feed',
    2 => 'snimi',
    3 => 'obrisi',
    4 => 'ponisti',
    10 => 'Razmjena sadrzaja',
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
    38 => 'Greska: Nepotpun unos',
    39 => 'Please fill in the Feed Title, Description, and Filename.',
    40 => 'Please enter a  number of entries or number of hours.',
    41 => 'Linkovi',
    42 => 'Dogadjanja'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Vasa lozinka vam je poslana emailom. Molimo slijedite upute u tekstu i zahvaljujemo vam sto koristite {$_CONF['site_name']}",
    2 => "Hvala sto ste poslali tekst na {$_CONF['site_name']}. Tekst ce prvo biti procitan od strane admina. Ako tekst bude prihvacen uskoro ce biti javno dostupan na nasim stranicama.",
    3 => "Hvala sto ste poslali link na {$_CONF['site_name']}. Link ce prvo biti provjeren od admina. Ukoliko bude prihvacen bit æe dostupan u sekciji <a href={$_CONF['site_url']}/links.php>Linkovi</a>.",
    4 => "Hvala sto ste poslali dogadjaj na {$_CONF['site_name']}. Nakon sto ga administratori odobre bit ce javno dostupan u <a href={$_CONF['site_url']}/calendar.php>kalendaru</a>.",
    5 => 'Your account information has been successfully saved.',
    6 => 'Vase preference su uspjesno spasene.',
    7 => 'Vase komentatorske preference su uspjesno spasene.',
    8 => 'Uspjesno ste odjavljeni.',
    9 => 'Vas tekst je uspjesno snimljen.',
    10 => 'Tekst je uspjesno obrisan.',
    11 => 'Vas blok je uspjesno spasen.',
    12 => 'Blok je uspjesno izbrisan.',
    13 => 'Vasa Vrsta vijesti je uspjesno spasena.',
    14 => 'Vrsta vijesti i sve price i blokovi su uspjesno izbrisani.',
    15 => 'Vas link je uspjesno poslat.',
    16 => 'Link je uspjesno obrisan.',
    17 => 'Vas dogadjaj je uspjesno snimljen.',
    18 => 'Dogadjaj je obrisan.',
    19 => 'Vasa anketa je uspjesno spasena.',
    20 => 'Anketa uspjesno izbrisana.',
    21 => 'Korisnik uspjesno pohranjen u bazu podataka.',
    22 => 'Korisnik uspjesno izbrisan.',
    23 => 'Pojavila se greska prilikom upisa dogadjaja u vas kalendar. ID doagadjaja prosao.',
    24 => 'Dogadjaj je uspjesno spasen na vas kalendar',
    25 => 'Nije dozvoljeno kreiranje vlastitog kalendara bez prijavljivanja',
    26 => 'Dogadjaj je uspje¹no maknut iz vaseg osobnog kalendara',
    27 => 'Poruka je uspjesno poslana.',
    28 => 'Plug-in je uspjesno spasen',
    29 => 'Zao mi je, osobni kalendar nije dozvoljen na ovim stranicama.',
    30 => 'Pristup odbijen',
    31 => 'Zao nam je, nemate pristup administraciskoj stranici za Vijesti. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    32 => 'Zao nam je, nemate pristup administraciskoj stranici za Naslove. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    33 => 'Zao nam je, nemate pristup administraciskoj stranici za Blokove. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    34 => 'Zao nam je, nemate pristup administraciskoj stranici za Linkove. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    35 => 'Zao nam je, nemate pristup administraciskoj stranici za Dogadjaje. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    36 => 'Zao nam je, nemate pristup administraciskoj stranici za Ankete. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    37 => 'Zao nam je, nemate pristup administraciskoj stranici za Korisnike. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    38 => 'Zao nam je, nemate pristup administraciskoj stranici za Plug-inove. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    39 => 'Zao nam je, nemate pristup administraciskoj stranici za Mailove. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    40 => 'Poruka sistema',
    41 => 'Zao nam je, nemate pristup stranicama za promjenu rijeci. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    42 => 'Vasa rijec uspjesno spasena.',
    43 => 'Rijec uspjesno izbirsana.',
    44 => 'Plug-in uspjesno instaliran!',
    45 => 'Plug-in uspjesno izbrisan.',
    46 => 'Zao nam je, nemate pristup bazi podataka za backup. Molimo zabiljezite da su svi pokusaji pristupa neovlastenim dijelovaime sitea zabiljezeni',
    47 => 'Ove funkcije rade samo pod *nix. Ako koristite *nix kao vas operativni sistem onda je vas kod uspjesno ociscen. Ako koristite Windows, trebat cete traziti fileove po imenu adodb_*.php i ukloniti ih manuelno.',
    48 => "Zahvaljujemo vam sto ste postali clan {$_CONF['site_name']}. Nas tim ce pregledati i ocjeniti vas zahtjev. Ako bude prihvacen vasa lozinka ce vam biti poslata na vas mail.",
    49 => 'Vasa grupa je uspjesno spasena.',
    50 => 'Grupa je uspjesno izbrisana.',
    51 => 'Ovaj username je vec u upotrebi. Molimo izaberite drugi.',
    52 => 'Izgleda da email adresa koju ste poslali nije validna.',
    53 => 'Vasa nova lozinka je prihvacena. Molimo koristite vasu novu lozinku da bi se prijavili ispod.',
    54 => 'Vas zahtjev za novom lozinkom je istekao. Pokusajte ponovo ispod.',
    55 => 'An email has been sent to you and should arrive momentarily. Please follow the directions in the message to set a new password for your account.',
    56 => 'Ovaj email je vec u upotrebi za drugi racun.',
    57 => 'Vas racun je uspjesno izbrisan.',
    58 => 'Your feed has been successfully saved.',
    59 => 'The feed has been successfully deleted.',
    60 => 'The plugin was successfully updated',
    61 => 'Plugin %s: Unknown message placeholder'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Pristup',
    'ownerroot' => 'Vlasnik/Administrator',
    'group' => 'Grupa',
    'readonly' => 'Samo citanje',
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
    'missingfields' => 'Polja koja nedostaju',
    'missingfieldsmsg' => 'You must supply the name and a description for a group',
    'groupmanager' => 'Sef grupe',
    'newgroupmsg' => 'To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used in the system.',
    'groupname' => 'Ime grupe',
    'coregroup' => 'Sistemska grupa',
    'yes' => 'Da',
    'no' => 'Ne',
    'corerightsdescr' => "This group is a core {$_CONF['site_name']} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
    'groupmsg' => 'Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called \'Rights\'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.',
    'coregroupmsg' => "This group is a core {$_CONF['site_name']} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
    'rightsdescr' => 'A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.',
    'lock' => 'Zakljucaj',
    'members' => 'Clanovi',
    'anonymous' => 'Anonimac',
    'permissions' => 'Prava',
    'permissionskey' => 'R = cita, E = Editira, pravo editiranja ukljucuje i pravo citanja',
    'edit' => 'Edituj',
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
    'delete' => 'izbrisi',
    'canteditroot' => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error.',
    'listusers' => 'Lista korisnika',
    'listthem' => 'lista',
    'usersingroup' => 'Korisnici u grupi "%s"',
    'usergroupadmin' => 'Administrator korisnicke grupe',
    'add' => 'Dodaj',
    'remove' => 'Makni',
    'availmembers' => 'Aktivni clanovi',
    'groupmembers' => 'Clanovi grupe',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.',
    'cantlistgroup' => 'To see the members of this group, you have to be a member yourself. Please contact the system administrator if you feel this is an error.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Posljednih 10 backupova.',
    'do_backup' => 'Napravi sigurnosnu kopiju',
    'backup_successful' => 'Backup baze podataka je uspjesno napravljen.',
    'no_backups' => 'Nema backupova.',
    'db_explanation' => 'Da bi napravili sigurnosu kopiju kliknite ovdje dole.',
    'not_found' => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Failed: Filesize was 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} nepostoji ili nije direktorij",
    'no_access' => "GRESKA: Direktorij {$_CONF['backup_path']} nije dostupan.",
    'backup_file' => 'Backup file',
    'size' => 'Velicina',
    'bytes' => 'Bytes',
    'total_number' => 'Ukupan broj sigurnosnih backupova: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Pocetna stranica',
    2 => 'Kontakt',
    3 => 'Posaljite Vijest',
    4 => 'Linkovi',
    5 => 'Ankete',
    6 => 'Kalendar',
    7 => 'Statistika stranice',
    8 => 'Personalizacija',
    9 => 'Pretraga',
    10 => 'napredna pretraga'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Error',
    2 => 'Oj, gledao sam svugdje, ali nigdje nemogu naci <b>%s</b>.',
    3 => "<p>Zao nam je, ali file koji ste trazili ne postoji. Mozda cete vise srece imati sa <a href=\"{$_CONF['site_url']}\">glavnom stranicom</a> ili sa <a href=\"{$_CONF['site_url']}/search.php\">pretragom</a> da biste nasli ono sto ste zijanili :)."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Potrebna prijava',
    2 => 'Zao mi je. Da bi pristupili ovdje morate biti registrirani korisnik..',
    3 => 'Prijava',
    4 => 'Novi korisnik'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'The PDF feature has been disabled',
    2 => 'The document provided was not rendered. The document was received but could not be processed.  Please make sure to submit only html formatted documents that have been written to the xHTML standard. Please note that overly complex html documents may not render correctly or at all.The document resulting from your attempt was 0 bytes in length, and has been deleted. If you\'re sure that your document should render fine, please re-submit it.',
    3 => 'Unknown error during PDF generation',
    4 => "No page data was given or you want to use the ad-hoc PDF generation tool below.  If you think you are getting this page\n          in error then please contact the system administrator.  Otherwise, you may use the form below to generate PDF's in an ad-hoc fashion.",
    5 => 'Loading your document.',
    6 => 'Please wait while your document is loaded.',
    7 => 'You may right click the button below and choose \'save target...\' or \'save link location...\' to save a copy of your document.',
    8 => "The path given in the configuration file to the HTMLDoc binary is invalid or this system cannot execute it.  Please contact the site administrator if this problem\n          persists.",
    9 => 'PDF Generator',
    10 => "This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This\n           is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site",
    11 => 'URL',
    12 => 'Generate PDF!',
    13 => 'The PHP configuration on this server does not allow URLs to be used with the fopen() command.  The system administrator must edit the php.ini file and set allow_url_fopen to On',
    14 => 'The PDF you requested either does not exist or you tried to illegally access a file.'
);

?>