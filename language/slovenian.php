<?php

###############################################################################
# english.php
# This is the english language page for GeekLog!
# Special thanks to Mischa Polivanov for his work on this project
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
	1 => "Piûe:",
	2 => "beri dalje",
	3 => "komentarjev.",
	4 => "uredi",
	5 => "Anketa",
	6 => "rezultati",
	7 => "Rezultati ankete",
	8 => "glasov<br>",
	9 => "Administracijske funkcije:",
	10 => "éakajoa vsebina",
	11 => "élanki",
	12 => "Bloki/okvirji",
	13 => "Teme",
	14 => "Povezave",
	15 => "Dogodki",
	16 => "Ankete",
	17 => "Uporabniki",
	18 => "SQL poizvedovanje",
	19 => "Izhod iz sistema",
	20 => "Podatki o uporabniku:",
	21 => "Uporabniûko ime",
	22 => "Uporabniûki ID",
	23 => "Varnostni nivo",
	24 => "Anonimni uporabnik",
	25 => "Odgovori",
	26 => "Za komentarje so odgovorni njihovi avtorji. Avtorji spletne strani na komentarje obiskovalcev nimamo nobenega vpliva.",
	27 => "Zadnjikrat komentirano",
	28 => "Izbriûi",
	29 => "Ni komentarjev.",
	30 => "Starejûi lanki",
	31 => "Dovoljeni HTML ukazi:",
	32 => "Napaka, neveljavno uporabniûko ime",
	33 => "Napaka, ne morem shranjevati v log datoteko",
	34 => "Napaka",
	35 => "Izhod iz sistema",
	36 => "dne",
	37 => "Ni lankov",
	38 => "",
	39 => "Osveõi",
	40 => "",
	41 => "Gostje",
	42 => "Prispeval/a:",
	43 => "Odgovori na To",
	44 => "Parent",
	45 => "MySQL ûtevilka napake",
	46 => "MySQL sporoilo o napaki",
	47 => "Prijava uporabnika",
	48 => "Podatki o uporabniûkem raunu",
	49 => "Nastavitve strani",
	50 => "Napaka v SQL ukazu",
	51 => "pomo",
	52 => "Novo",
	53 => "Administratorske strani",
	54 => "Ne morem odpreti datoteke",
	55 => "Napaka na",
	56 => "Glasuj",
	57 => "Geslo",
	58 => "Prijava",
	59 => "Niste registriran uporabnik?  <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Registrirajte se</a>.",
	60 => "Dodaj komentar",
	61 => "Nov uporabnik",
	62 => "besed",
	63 => "Nastavitve komentarjev",
	64 => "Poûlji lanek prijatelju po e-poûti",
	65 => "Stran prijazna za tisk",
	66 => "Osebni koledar",
	67 => "Dobrodoûli na ",
	68 => "domov",
	69 => "kontakt",
	70 => "iûi",
	71 => "contribute",
	72 => "spletni vir",
	73 => "pretekle ankete",
	74 => "koledar",
	75 => "napredno iskanje",
	76 => "statistika spletne strani",
	77 => "Prikljueni moduli",
	78 => "Dogodki",
	79 => "Kaj je novega",
	80 => "élankov v zadnjih",
	81 => "élanek v zadnjih ",
	82 => "urah",
	83 => "KOMENTARJI BRALCEV<br>",
	84 => "POVEZAVE<br>",
	85 => "v zadnjih 48 urah",
	86 => "ni novih komentarjev",
	87 => "v zadnjih 2 tednih",
	88 => "ni novih povezav",
	89 => "Trenutno ni nobenih prihajajoih dogodkov.",
	90 => "Na osnovno stran",
	91 => "Spletna stran zgenerirana v",
	92 => "sekundah",
	93 => "Copyright",
	94 => "All our code belongs to you.",
	95 => "Powered By",
	96 => "Uporabniûke skupine",
    97 => "Seznam besed",
	98 => "Prikljuni moduli",
	99 => "éLANKI",
    100 => "Ni novih lankov",
    101 => 'Vaûi dogodki',
    102 => 'Najavljeno je:',
    103 => 'DB Backups',
    104 => 'by',
    105 => 'Mail Users',
    106 => 'Ogledov',
    107 => 'GL Version Test',
    108 => 'Clear Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Koledar dogodkov",
	2 => "Trenutno ni v koledar vpisanega nobenega dogodka.",
	3 => "Kdaj",
	4 => "Kje",
	5 => "Opis",
	6 => "Dodaj dogodek",
	7 => "Prihajajoi dogodki",
	8 => 'Ko boste dodali nov dogodek v vaû osebni koledar, ga lahko te dogodke pregledate s klikom na "Osebni koledar" v meniju "Osebne nastavitve".',
	9 => "Dodaj v Osebni koledar",
	10 => "Odstrani iz Osebnega koledarja",
	11 => "Dodajanje dogodka v Osebni koledar uporabnika {$_USER['username']}",
	12 => "Dogodek",
	13 => "Zaetek dogodka",
	14 => "Konec dogodka",
	15 => "nazaj na koledar"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Poûiljanje komentarja",
	2 => "Oblika besedila",
	3 => "Odjava",
	4 => "Registrirajte se",
	5 => "Uporabniûko ime",
	6 => "ée õelite posredovati komentar se morate registrirati. ée ûe nimate svojega uporabniûkega imena in gesla, kliknite spodaj.",
	7 => "Vaû zadnji komentar je bil pred",
	8 => " sekundami.  Med posameznimi komentarji bralcev mora pretei vsaj {$_CONF["commentspeedlimit"]} sekund",
	9 => "Komentar",
	10 => '',
	11 => "Poûlji komentar",
	12 => "ée õelite posredovati komentar, vpiûite vaûe ime, e-mail naslov, naslov komentarja in vsebino komentarja.",
	13 => "Vaûe informacije",
	14 => "Predogled",
	15 => "",
	16 => "Naslov",
	17 => "Napaka",
	18 => 'Pomembno',
	19 => 'Prosimo da se skuûate drõati teme objavljenega lanka.',
	20 => 'Zaõeleno je argumentiranje vaûih trditev.',
	21 => 'Preberite komentarje ostalih - morda je kdo õe napisal kaj kar nameravate napisati tudi vi.',
	22 => 'Pazite na pravilno slovnico in se izogibajte õalitvam drugih.',
	23 => 'Vaû e-mail naslov ne bo javno objavljen.',
	24 => 'Anonimni uporabnik'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Uporabnik",
	2 => "Uporabniûko ime",
	3 => "Ime",
	4 => "Geslo",
	5 => "Elektronski naslov",
	6 => "Spletna stran",
	7 => "Opis",
	8 => "PGP javni klju",
	9 => "Shrani podatke",
	10 => "Zadnjih 10 komentarjev uporabnika",
	11 => "Uporabnik ni prispeval nobenih komentarjev",
	12 => "Uporabniûke nastavitve za",
	13 => "Email Nightly Digest",
	14 => "Geslo se generira nakljuno. Priporoamo vam, da geslo takoj spremenite. To storite s klikom na Informacije o raunu v  meniju Osebne nastavitve. Za spremembe osebnih nastavitev se morate prijaviti v sistem.",
	15 => "Vaû uporabniûki raun na spletni strani je bil uspeûno vzpostavljen. ée ga õelite uporabljati, se morate prijaviti s spodnjimi podatki. Svetujemo vam da podatke o vaûem uporabniûkem raunu shranite.",
	16 => "Informacije o vaûem uporabniûkem raunu",
	17 => "Uporabniûki raun ne obstaja",
	18 => "Vneûeni e-mail naslov ni veljaven",
	19 => "Vneûeno uporabniûko ime ali e-mail naslov sta õe uporabljena na tem sistemu",
	20 => "Vneûeni e-mail naslov ni veljaven",
	21 => "Napaka",
	22 => "Registracija {$_CONF['site_name']}!",
	23 => "Registracija vam omogoa lanstvo na naûi spletni strani{$_CONF['site_name']}. To pomeni da boste lahko objavljali komentarje, poûiljali svoje lanke, dostopali in dodajali zapiske in bili deleõni vseh pomembnih informacij. ée se ne registrirate, boste na spletni strani lahko sodelovali le kot anonimni uporabnik. <font color=red>Elektronski naslovi registriranih uporabnikov <b><i>ne bodo javno objavljeni</i></b>.",
	24 => "Geslo vam bomo poslali na e-mail naslov, ki ste ga vnesli.",
	25 => "Ste pozabili geslo?",
	26 => "Vnesite uporabniûko ime in kliknite spodnji gumb. Geslo vam bomo sporoili na registrirani e-mail naslov.",
	27 => "Registrirajte se!",
	28 => "Poûlji geslo na e-mail naslov",
	29 => "odjava",
	30 => "prijava",
	31 => "Za izvedbo te funkcije se morate prijaviti",
	32 => "Podpis",
	33 => "Never publicly displayed",
	34 => "Vaûe pravo ime",
	35 => "Vpiûi spremenjeno geslo",
	36 => "Zaneû z http://",
	37 => "Nastavitve komentarjev",
	38 => "To lahko prebere vsakdo",
	39 => "PGP javni klju?",
	40 => "Brez ikone teme",
	41 => "Willing to Moderate",
	42 => "Format datuma",
	43 => "Maximum Stories",
	44 => "Brez okvirjev",
	45 => "Prikaõi preference za",
	46 => "Izkljueni deli",
	47 => "News box Configuration for",
	48 => "Teme",
	49 => "Brez ikon v lankih",
	50 => "ée vas ne zanima, odznaite",
	51 => "Samo novi lanki",
	52 => "Privzeta nastavitev je 10",
	53 => "Receive the days stories every night",
	54 => "Oznai teme in avtorje, katerih prispevki vas ne zanimajo",
	55 => "ée pustite prazno, se bodo ohranile privzete nastavitve. ée zanete izbirati bloke/okvirje, se bodo prikazali samo tisti, ki ste jih izbrali (brez privzetih). Privzete nastavitve so <B> povdarjene</B>.",
	56 => "Avtorji",
	57 => "Nain prikaza",
	58 => "Uredi po",
	59 => "Omejitve komentarja",
	60 => "Kakûen nain izpisa õelite za svoje komentarje",
	61 => "Najprej novi ali stari?",
	62 => "Prevzeta vrednost je 100",
	63 => "Geslo je bilo poslano na vaû e-mail naslov. Sledite navodilom, ki jih boste dobili. Hvala ker uporabljate spletno stran " . $_CONF["site_name"],
	64 => "Comment Preferences for",
	65 => "Poizkusite se ponovno prijaviti",
	66 => "Morda ste se zmotili pri vnosu svojega uporabniûkega imena ali gesla? Poizkusite se ponovno prijaviti. Ste morda ûe neregistriran uporabnik - v tem primeru se <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrirajte</a>.",
	67 => "Uporabnik od",
	68 => "Spomni me na",
	69 => "How long should we remember you after logging in?",
	70 => "Priredi izgled spletne strani {$_CONF['site_name']}",
	71 => "Ena od posebnosti spletne strani{$_CONF['site_name']} je popolna moõnost prilagajanja izgleda posameznemu uporabniku.  ée õelite uporabiti to moõnost se morate najprej <a href=\"{$_CONF['site_url']}/users.php?mode=new\">prijaviti</a> na {$_CONF['site_name']}.  Ali ste õe postali registrirani uporabnik?  Prijavite se!",
    72 => "Tema",
    73 => "Jezik",
    74 => "Spremeni izgled strani!",
	75 => "Teme po e-mailu",
	76 => "Nove lanke iz izbranih podroij boste ob koncu vsakega dneva prejeli po e-mailu. Izberite teme, ki vas zanimajo!",
	77 => "Slika",
	78 => "Dodaj svojo sliko!",
    79 => "Izbriûi izbrano sliko",
      80 => "Vpis",
    81 => "Poûlji Email",
    82 => 'Zadnjih 10 lankov uporabnika',
    83 => 'Statistika objavljanja uporabnika',
    84 => 'Skupno ûtevilo lankov:',
    85 => 'Skupno ûtevilo komentarjev:',
    86 => 'Najdi vse objave uporabnika'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Podroje je trenutno prazno",
	2 => "Trenutno v tem tematskem podroju ni nobenega lanka, ali pa so vaûe uporabniûke nastavitve takûne da nimate dostopa do tega podroja",
	3 => ".",
	4 => "Danaûji udarni lanek",
	5 => "naslednja stran",
	6 => "prejûnja stran"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Zanimive povezave",
	2 => "V bazo podatkov ni vpisana nobena povezava.",
	3 => "Predlagaj povezavo"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Anketa shranjena",
	2 => "Vaû glas je bil shranjen",
	3 => "Glasuj",
	4 => "Seznam anket na spletni strani",
	5 => "glasov"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Napaka!!! Poskusite znova.",
	2 => "Sporoilo je bilo poslano",
	3 => "Uporabite pravi e-mail naslov!",
	4 => "Izpolnite polja: Ime, e-mail za odgovor, Zadeva in vpiûite sporoilo",
	5 => "Napaka. Neznan uporabnik!",
	6 => "Upsss... Napaka ;-).",
	7 => "Uporabnik",
	8 => "Uporabniûko ime",
	9 => "URL naslov",
	10 => "e-mail naslov",
	11 => "Ime:",
	12 => "e-mail za odgovor:",
	13 => "Zadeva:",
	14 => "Sporoilo:",
	15 => "HTML ukazi ne bodo upoûtevani (HTML will not be translated).",
	16 => "Poûlji sporoilo",
	17 => "Poûlji lanek prijatelju po e-mailu",
	18 => "Ime prijatelja",
	19 => "Elektronski naslov prijatelja",
	20 => "Vaûe ime",
	21 => "Vaû e-mail naslov",
	22 => "Izpolniti je potrebno vsa polja!",
	23 => "To sporoilo vam je poslal naû obiskovalec $from ($fromemail). Upravitelji spletne strani {$_CONF["site_url"]} od koder je bilo sporoilo poslano, vaûih podatkov nismo shranili v nobeno bazo podatkov.",
	24 => "élanek se nahaja na spletnem naslovu: ",
	25 => "ée õelite poslati lanek po e-poûti, se morate predhodno registrirati. Registracija je potrebna da prepreimo morebitne zlorabe sistema.",
	26 => "S pomojo tega obrazca boste poslali e-mail izbranemu uporabniku. Izpolniti je potrebno vsa polja!",
	27 => "Kratko spremno sporoilo",
	28 => "Obiskovalec $from je napisal sledee spremno sporoilo: $shortmsg",
	29 => "Dnevni pregled strani {$_CONF['site_name']} za ",
	30 => "Dnevne novice za",
	31 => "Naslov",
	32 => "Datum",
	33 => "Celotno besedilo:",
    34 => "Konec sporoila"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Napredno iskanje",
	2 => "Kljune besede",
	3 => "Tematsko podroje",
	4 => "vse",
	5 => "Nasvet",
	6 => "élanki",
	7 => "komentarji bralcev",
	8 => "Avtorji",
	9 => "vse",
	10 => "Iûi",
	11 => "Rezultati iskanja",
	12 => "zadetki",
	13 => "Iskanje med lanki: ni zadetkov",
	14 => "Za iskalni pojem",
	15 => "ni nobenega zadetka. Prosimo poizkusite ponovno.",
	16 => "Naslov",
	17 => "datum",
	18 => "avtor",
	19 => "Iskalnik celotne baze podatkov (vsi lanki in vsi komentarji bralcev)",
	20 => "Datum",
	21 => "do",
	22 => "(format datuma YYYY-MM-DD)",
	23 => "Ét. zadetkov",
	24 => "Najdenih je",
	25 => "zadetkov med",
	26 => "prispevki. Iskanje je trajalo",
	27 => "sekund.",
    28 => "Za vpisani iskalni pogoj ni bilo najdenega nobenega lanka niti nobenega komentarja",
    29 => "Rezultati iskanja",
    30 => "Nobena povezava ne ustreza vaûemu iskalnemu pogoju. Poizkusite znova!",
	31 => "Ni zadetkov za ta plug-in. Poizkusite znova!",
	32 => "Dogodek",
    33 => "URL",
    34 => "Lokacia",
    35 => "Celodnevno dogajanje",
    36 => "Noben dogodek ne ustreza vaûemu iskalnemu pogoju. Poizkusite znova!",
    37 => "Rezultati za dogodke",
    38 => "Rezultati za povezave",
    39 => "Povezave",
    40 => "Dogodki"
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Statistike spletne strani",
	2 => "Étevilo vseh obiskov strani",
	3 => "Étevilo objavljenih lankov (komentarjev)",
	4 => "Étevilo anket (odgovorov)",
	5 => "Étevilo povezav (obiskov)",
	6 => "Étevilo napovedanih dogodkov",
	7 => "Deset najbolj branih lankov",
	8 => "Naslov lanka",
	9 => "Ét. ogledov",
	10 => "Na spletni strani ni objavljenih lankov, ali pa nihe ni prebral nobenega lanka.",
	11 => "Deset najbolj komentiranih lankov",
	12 => "Ét. komentarjev",
	13 => "Na spletni strani ni objavljenih komentarjev, ali pa nihe ni objavil nobenega komentarja.",
	14 => "Deset najbolj obiskanih anket",
	15 => "Anketno vpraûanje",
	16 => "Ét. glasov",
	17 => "Na spletni strani ni objavljena nobena anketa, ali pa nihe ni glasoval pri nobeni anketi.",
	18 => "Deset najbolj obiskanih povezav",
	19 => "Povezave",
	20 => "Ét. ogledov",
	21 => "Na spletni strani ni objavljena nobena povezava ali pa nihe ni obiskal nobene povezave.",
	22 => "Deset najbolj po e-mailu posredovanih lankov",
	23 => "Ét. posredovanj",
	24 => "Nihe ni posredoval nobenega lanka po e-mailu."
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Sorodne povezave",
	2 => "Poûlji lanek po e-poûti",
	3 => "Stran prijazna za tisk",
	4 => "Dodatne moõnosti"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "ée õelite objaviti $type se morate prijaviti. Ée niste registrirani uporabnik? <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> Registrirajte se</a>.",
	2 => "Prijava",
	3 => "Nov uporabnik",
	4 => "Poûlji dogodek",
	5 => "Poûlji povezavo",
	6 => "élanek",
	7 => "Potrebno se je prijaviti!",
	8 => "Poûlji",
	9 => "Pri poûiljanju informacij se drõite naslednjih priporoil:<ul><li>izpolnite vsa polja,<li>poskrbite da bo informacija, ki jo poûiljate tona in ustrezna,<li>pazite na slovnico,<li>preverite da delujejo vse povezave,<li><font color=red>prosimo da poûiljate <b>samo lanke</b>, komentarje vpisujte pod posamezen lanek, za sploûne debate ali mnenja pa uporabite forum.</font></ul>",
	10 => "Naslov",
	11 => "Povezava",
	12 => "Datum zaetka",
	13 => "Datum zakljuka",
	14 => "Lokacija",
	15 => "Opis",
	16 => "ée 'drugo', vpiûi ime",
	17 => "Kategorija",
	18 => "Drugo",
	19 => "Prosimo, preberite",
	20 => "Napaka: ni doloena kategorija",
	21 => "Kadar izberete \"Drugo\" vpiûite tudi ime kategorije",
	22 => "Napaka: niso izpolnjena vsa polja",
	23 => "Prosimo izpolnite vsa polja obrazca.",
	24 => "Shranjeno!",
	25 => "Vaû $type prispevek je bil shranjen.",
	26 => "Omejitev hitrosti",
	27 => "Uporabniûko ime",
	28 => "Tematsko podroje",
	29 => "Vsebina lanka",
	30 => "Vaûa zadnja objava je bila poslana pred ",
	31 => " sekundami. Nastavitve te spletne strani pa zahtevajo da med dvema objavama istega avtorja mine vsaj {$_CONF["speedlimit"]} sekund",
	32 => "Predogled",
	33 => "Predogled lanka",
	34 => "izhod",
	35 => "HTML ukazi ne bodo upoûtevani",
	36 => "Oblika besedila",
	37 => "Dogodek bo dodan na skupni koledar, od koder ga registrirani uporabniki lahko dodajo na svoj osebni koledar. Ta aplikacija zato <b>NI</b> namenjena shranjevanju osebnih dogodkov (obletnice, rojstni dnevi, zabave...) e nas ne mislite nanje povabiti ;-)<br><br>Preden bo dogodek objavljen na skupnem koledarju dogodkov, ga bo pregledal administrator!",
    38 => "Dodaj dogodek v",
    39 => "Skupni koledar",
    40 => "Osebni koledar",
    41 => "éas zakljuka",
    42 => "éas zaetka",
    43 => "Celodnevni dogodek",
    44 => 'Naslov 1',
    45 => 'Naslov 2',
    46 => 'Mesto',
    47 => 'Drõava',
    48 => 'Poûtna ûtevilka',
    49 => 'Tip dogodka',
    50 => 'Uredi tipe dogodkov',
    51 => 'Lokacija',
    52 => 'Odstrani',
        53 => 'Naredi raun'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Obvezna prijava",
	2 => "Dostop zavrnjen! Vnesli ste napane podatke.",
	3 => "Napano geslo za uporabnika",
	4 => "Uporabniûko ime:",
	5 => "Geslo:",
	6 => "Vsi dostopi do administracijske strani se beleõijo.<br>Ta del spletne strani lahko uporabljajo samo pooblaûene osebe.<p>",
	7 => "prijava"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Ups... ne bo ûlo. Nimate zahtevanih administratorskih pravic ;-)",
	2 => "Za urejanje tega bloka/okvirja nimate zahtevanih administratorskih pravic",
	3 => "Urejanje blokov/okvirjev",
	4 => "",
	5 => "Ime bloka/okvirja",
	6 => "Tema",
	7 => "Vse",
	8 => "Varnostna raven bloka/okvirja ",
	9 => "Pravila bloka/okvirja ",
	10 => "Tip bloka/okvirja ",
	11 => "Blok/okvir na portalu",
	12 => "Obiajni blok/okvir",
	13 => "Nastavitve bloka/okvirja na portalu",
	14 => "RDF URL",
	15 => "Zadnja RDF osveõitev",
	16 => "Nastavitve obiajnega bloka/okvirja ",
	17 => "Komentar",
	18 => "Vnesite ime, varnostno raven in vsebino bloka/okvirja ",
	19 => "Administracija bloka/okvirja ",
	20 => "Ime bloka/okvirja ",
	21 => "Varnostna raven",
	22 => "Tip bloka/okvirja ",
	23 => "Pravila bloka/okvirja ",
	24 => "Tema bloka/okvirja ",
	25 => "Izberite blok/okvir ki ga õelite urediti ali odstraniti. ée õelite ustvariti nov blok/okvir, kliknite zgoraj.",
	26 => "Izgled",
	27 => "PHP blok/okvir",
    28 => "Nastavitve PHP bloka/okvirja",
    29 => "Funkcije bloka/okvirja",
    30 => "If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix \"phpblock_\" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis \"()\" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.",
    31 => "Napaka v PHP bloku/okvirju.  Funkcija $function, ne obstaja.",
    32 => "Napaka. Manjkajoi podatki",
    33 => "Vnesite URL naslov v datoteko .rdf za blok na portalu",
    34 => "Vnesite naslov in funkcijo PHP bloka/okvirja",
    35 => "Vnesite naslov in vsebino bloka/okvirja",
    36 => "Vnesite vsebino in izberite izgled bloka/okvirja",
    37 => "Napano ime funkcije PHP bloka/okvirja",
    38 => "Funkcije PHP bloka/okvirja morajo imeti predpono 'phpblock_' (npr. phpblock_imefunkcije).  Predpona 'phpblock_' je potrebna zaradi varnosti!",
	39 => "Stran",
	40 => "Levo",
	41 => "Desno",
	42 => "Vnesite nastavitve za privzete GeekLog bloke/okvirje",
	43 => "Samo domaa stran",
	44 => "Dostop zavrnjen",
	45 => "Do tega bloka/okvirja nimate dostopa. Vaû poskus je bil zabeleõen v bazo podatkov! Prosimo, vrnite se na <a href=\"{$_CONF["site_url"]}/admin/block.php\"> stran za administracijo</a>!",
	46 => 'Nov blok/okvir',
	47 => 'Administratorske strani',
    48 => 'Ime bloka/okvirja',
    49 => ' (Presledki niso dovoljeni. Imena blokov/okvirjev ne smejo biti podvojena',
    50 => 'URL za pomo',
    51 => 'Zaneû z http://',
    52 => 'ée pustite prazno, se ikona za pomo ne bo izpisala!',
    53 => "Omogoeno",
    54 => 'Shrani',
    55 => 'Preklii',
    56 => 'Izbriûi'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Urejanje dogodkov",
	2 => "",
	3 => "Naslov dogodka",
	4 => "URL dogodka",
	5 => "Zaetek dogodka",
	6 => "Zakljuek dogodka",
	7 => "Kraj dogodka",
	8 => "Opis dogodka",
	9 => "(Zaneû z http://)",
	10 => "Izpolniti morate vsa polja!",
	11 => "Urejevalnik dogodkov",
	12 => "Izberite dogodek, ki ga õelite urediti ali odstraniti. ée õelite ustvariti nov dogodek, kliknite na nov dogodek zgoraj.",
	13 => "Naslov dogodka",
	14 => "Zaetek",
	15 => "Konec",
	16 => "Dostop zavrnjen",
	17 => "Do tega dogodka nimate dostopa. Vaû poskus je bil zabeleõen v bazo podatkov. Prosimo, vrnite se na <a href=\"{$_CONF["site_url"]}/admin/event.php\"> urejanje dogodkov</a>!",
	18 => 'Nov dogodek',
	19 => 'Administratorske strani',
    20 => 'Shrani',
    21 => 'Preklii',
    22 => 'Izbriûi'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Urejanje povezav",
	2 => "",
	3 => "Naslo povezave",
	4 => "URL",
	5 => "Kategorija",
	6 => "(Zaneû z http://)",
	7 => "Drugo",
	8 => "Zadetki povezave",
	9 => "Opis povezave",
	10 => "Vnesti morate Naslov povezave, URL in opis.",
	11 => "Urejevalnik povezav",
	12 => "Izberite povezavo, ki ga õelite urediti ali odstraniti. ée õelite ustvariti novo povezavo, kliknite zgoraj.",
	13 => "Naslov povezave",
	14 => "Kategorija",
	15 => "URL",
	16 => "Dostop zavrnjen!",
	17 => "Do te povezave nimate dostopa. Vaû poskus je bil zabeleõen v bazo podatkov. Prosimo, vrnite se na <a href=\"{$_CONF["site_url"]}/admin/link.php\"> urejanje povezav</a>.",
	18 => 'Nova povezava',
	19 => 'Administratorske strani',
	20 => 'ée drugo, kaj',
    21 => 'Shrani',
    22 => 'Preklii',
    23 => 'Izbriûi'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Prejûnji lanki",
	2 => "Naslednji lanki",
	3 => "Nastavitve lanka",
	4 => "Oblikovanje lanka",
	5 => "Urejanje lanka",
	6 => "Ni lankov v sistemu",
	7 => "Avtor",
	8 => "Shrani",
	9 => "Predogled",
	10 => "Preklii",
	11 => "Izbriûi",
	12 => "",
	13 => "Naslov",
	14 => "tematsko podroje",
	15 => "datum",
	16 => "Uvodno besedilo",
	17 => "Razûirjeno besedilo",
	18 => "Ét. branj",
	19 => "Komentarjev",
	20 => "",
	21 => "",
	22 => "Seznam lankov",
	23 => "ée õelite spreminjati ali izbrisati lanek, kliknite na njegovo ûtevilko. ée õelite lanek pregledati, kliknite na njegov naslov. ée õelite objaviti nov lanek, kliknite na zgornjo povezavo.",
	24 => "",
	25 => "",
	26 => "Predogled lanka",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Prosimo vpiûite avtorja, naslov in uvodno besedilo",
	32 => "Udarni lanek",
	33 => "Udarni lanek je lahko smo eden",
	34 => "Draft",
	35 => "Da",
	36 => "Ne",
	37 => "Ve od avtorja",
	38 => "Ve iz podroja",
	39 => "Ét. posredovanj po e-mailu",
	40 => "Dostop zavrnjen",
	41 => "Poizkuûate dostopati do lanka do katerega nimate dostopa. Ta poizkus neveljavnega dostopa je bil zabeleõen in shranjen. lanek lahko samo preberete, ne morete pa ga urejati. ée õelite lahko vstopite <a href=\"{$_CONF["site_url"]}/admin/story.php\"> na administracijo lanka</a>.",
	42 => "Poizkuûate dostopati do lanka do katerega nimate dostopa. Ta poizkus neveljavnega dostopa je bil zabeleõen in shranjen. ée õelite lahko vstopite <a href=\"{$_CONF["site_url"]}/admin/story.php\">na administracijo lankov</a>.",
	43 => 'Nov lanek',
	44 => 'Administracijska stran',
	45 => 'Dostop',
	46 => "<b>POZOR:</b> vaû prispevek ne bo objavljen do izbranega datuma.Do tega datuma tudi na bo v vaûem RDF in ne bo vkljun v iskalnik.",
    47 => 'Slike',
    48 => 'slika',
    49 => 'desno',
    50 => 'levo',
    51 => "Sliko vstavite v lanek s posebnim ukazom [slikaX], [slikaX_desno] or [slikaX_levo], kjer je X ûtevilka slike v prilogi. POZOR: uporabite lahko samo slike iz priloge. V nasprotnem primeru lanka ne bo mogoe objaviti. <BR><P><B>PREDOGLED</B>: Predogled lanka s slikami najenostavneje opraviter tako, da lanek shranite kot draft in ne uporabite gumba Predogled. Funkcija Predogled deluje deluje le, e lanek brez slik.",
    52 => "Odstrani",
    53 => "ni bila uporabljena. Sliko morate pred shranjevanjem vkljuiti v uvod ali med besedilo lanka.",
    54 => "Priloõene slike niso bile uporabljene",
    55 => "Napaka pri shranjevanju lanka. Prosimo popravite napake na spodnjem seznamu:",
    56 => "Prikaõi ikono teme"
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Nain",
	2 => "",
	3 => "Ustvarjena anketa",
	4 => "Anketa $qid shranjena",
	5 => "Urejanje anketa",
	6 => "ID ankete",
	7 => "(ne uporabljajte presledkov)",
	8 => "Objavi anketo",
	9 => "Vpraûanje",
	10 => "Odgovorov / Glasov",
	11 => "Napaka pri odgovoru na anketo $qid",
	12 => "Napaka pri vpraûanju na anketo $qid",
	13 => "Ustvari anketo",
    14 => 'Shrani',
    15 => 'Preklii',
    16 => 'Izbriûi',
	17 => "",
	18 => "Seznam anket",
	19 => "Izberite anketo, ki jo õelite urediti ali odstraniti. ée õelite ustvariti novo anketo, kliknite zgoraj.",
	20 => "Glasov",
	21 => "Prepovedan dostop!",
	22 => "Do te povezave nimate dostopa. Vaû poskus je bil zabeleõen in shranjen. Prosimo, vrnite se na <a href=\"{$_CONF["site_url"]}/admin/poll.php\"> administracijo anket.</a>.",
	23 => 'Nova anketa',
	24 => 'Administratorske strani',
	25 => 'Da',
	26 => 'Ne'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Urejanje tem",
	2 => "ID teme",
	3 => "Naslov teme",
	4 => "Slika teme",
	5 => "(ne uporabljajte presledkov)",
	6 => "ée odstranite temo odstranite tudi vse lanke in bloke/okvirje ki so z njo povezani",
	7 => "Izpolnite ID teme in naslov teme.",
	8 => "Urejevalnik tem",
	9 => "Izberite temo, ki ga õelite urediti ali odstraniti. ée õelite ustvariti novo temo, kliknite zgoraj.",
	10=> "Uredi po",
	11 => "élankov/Strani",
	12 => "Dostop zavrnjen!",
	13 => "Do te teme nimate dostopa. Vaû poskus je bil zabeleõen in shranjen. Prosimo, vrnite se na <a href=\"{$_CONF["site_url"]}/admin/topic.php\"> administracijo tem</a>!",
	14 => "Uredi po",
	15 => "abecedi",
	16 => "privzeto",
	17 => "Nova tema",
	18 => "Administratorske strani",
	    19 => 'Shrani',
    20 => 'Preklii',
    21 => 'Izbriûi'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Urejanje uporabnika",
	2 => "ID uporabnika",
	3 => "uporabniûko ime",
	4 => "ime uporabnika",
	5 => "Geslo",
	6 => "Varnostni nivo",
	7 => "e-mail naslov",
	8 => "Vaûa spletna stran",
	9 => "(ne uporabljajte presledkov)",
	10 => "Prosimo vpiûite uporabniûko ime, ime uporabnika, varnostni nivo in e-mail naslov uporabnika.",
	11 => "Administracija uporabnikov",
	12 => "ée õelite spremeniti ali izbrisati uporabnika, kliknite na njegovo uporabniûko ime. ée õelite ustvariti novega uporabnika pa kliknite gumb Nov uporabnik.",
	13 => "Varnostni nivo",
	14 => "Datum registracije",
	15 => 'nov uporabnik',
	16 => 'Administratorske strani',
	17 => 'spremeni geslo',
	18 => 'prekini',
	19 => 'izbriûi',
	20 => 'shrani',
	18 => 'prekini',
	19 => 'izbriûi',
	20 => 'shrani',
    21 => 'Uporabniûko ime, ki ga õelite hraniti õe obstaja.',
    22 => 'Napaka',
    23 => 'Batch Add',
    24 => 'Batch Import of Users',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, username, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => "Iûi",
    27 => "Omejitve iskanja",
    28 => "Izbriûi sliko",
        29 => 'Pot',
    30 => 'Uvozi',
    31 => 'Novi uporabniki',
    32 => 'Konano. Uvoõeno $successes in $failures napak',
    33 => 'poûlji',
    34 => 'Napaka: Moraû doloiti datoteko.'
);


###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Objavi",
	2 => "Izbriûi",
	3 => "Uredi",
    4 => 'Profil',
    10 => "Naslov",
    11 => "Datum zaetka",
    12 => "URL",
    13 => "Kategorija",
    14 => "Datum",
    15 => "Tema",
    16 => 'Uporabniûko ime',
    17 => 'Popolno ime',
    18 => 'E-mail',
	34 => "Administratorske strani",
	35 => "éakajoi lanki",
	36 => "éakajoe povezave",
	37 => "éakajoi dogodki",
	38 => "Potrdi",
	39 => "Trenutno v tem podroju ni nobene akajoe vsebine.",
    40 => "Uporabniki so poslali"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "nedelja",
	2 => "ponedeljek",
	3 => "torek",
	4 => "sreda",
	5 => "etrtek",
	6 => "petek",
	7 => "sobota",
	8 => "Dodaj dogodek",
	9 => "Dogodek",
	10 => "Dogodki za",
	11 => "Skupni koledar",
	12 => "Osebni koledar",
	13 => "januar",
	14 => "februar",
	15 => "marec",
	16 => "april",
	17 => "maj",
	18 => "junij",
	19 => "julij",
	20 => "avgust",
	21 => "september",
	22 => "oktober",
	23 => "november",
	24 => "december",
	25 => "Nazaj na ",
    26 => "Ves dan",
    27 => "teden",
    28 => "Osebni koledar za uporabnika",
    29 => "Skupni koledar",
    30 => "izbriûi dogodek",
    31 => "Dodaj",
    32 => "Dogodek",
    33 => "Datum",
    34 => "éas",
    35 => "Hitro dodajanje",
    36 => "Poûlji",
    37 => "Úal ta spletna stran ne omogoa upravljanja osebnih koledarjev",
    38 => "Urejanje osebnega koledarja",
        39 => 'Dan',
    40 => 'Teden',
    41 => 'Mesec'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
 	1 => 
 	$_CONF['site_name'] . " Mail Utility",
 	2 => "Od:",
 	3 => "Naslov za odgovor:",
 	4 => "Zadeva:",
 	5 => "Sporoilo:",
 	6 => "Naslov:",
 	7 => "Vsem uporabnikom",
 	8 => "Admin",
	9 => "Nastavitve",
	10 => "HTML",
 	11 => "Nujno sporoilo!",
 	12 => "Poûlji",
 	13 => "Zbriûi",
 	14 => "Prezri uporabniûke nastavitve",
 	15 => "Napaka pri poûiljanju: ",
	16 => "Sporoilo je bilo uspeûno poslano na naslov: ",
	17 => "<a href=" . $_CONF["site_url"] . "/admin/mail.php>Poûlji novo sporoilo</a>",
	18 => "Za:",
    19 => "POZOR: e õelite poslati sporoilo vsem uporabnikom strani, izberite skupino Prijavljeni uporabniki iz menija Uporabniki",
    20 => "Uspeûno poslana sporoila: <successcount>;<BR>Neuspeûno poslana sporoila: <failcount>. Podrobnosti o neuspeûno poslanih sporoilh najdete spodaj.<BR><BR>Úelite poslati ûe kakûno <a href=\"" . $_CONF['site_url'] . "/admin/mail.php\">sporoilo</a>? <BR><BR>Nazaj na <a href=\"" . $_CONF['site_url'] . "/admin/moderation.php\">administratorkse strani</a>.",
    21 => "Neuspeûno poslana sporoila",
    22 => "Uspeûno poslana sporoila",
    23 => "Nobenega neuspeûno poslanega sporoila",
    24 => "Nobenega uspeûno poslanega sporoila",
    25 => '-- Izberi skupino --',
    26 => "Prosim izpolni vsa polja v obrazcu in izberi skupino uporabnikov iz menija."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Geslo smo vam poslali na vaû e-mail naslov. Elektronsko sporoilo vsebuje tudi vsa ustrezna navodila.",
	2 => "Za poslani lanek se vam najlepûe zahvaljujemo. Pred objavo ga bo pregledal eden izmed urednikov. ée bo odobren, bo objavljen na spletni strani.",
	3 => "Za poslano povezavo se vam najlepûe zahvaljujemo. Pred objavo jo bo pregledal eden izmed urednikov. ée bo odobrena, bo objavljena na strani <a href={$_CONF["site_url"]}/links.php>povezav</a>.",
	4 => "Za poslani dogodek se vam najlepûe zahvaljujemo. Pred objavo ga bo pregledal eden izmed urednikov. ée bo odobren, bo objavljen v <a href={$_CONF["site_url"]}/calendar.php>koledarju dogodkov</a>.",
	5 => "Podatki o vaûem uporabniûkem raunu so bili shranjeni.",
	6 => "Nastavitve vaûega zaslona so bile uspeûno shranjene.",
	7 => "Vaûe nastavitve komentarjev so bile uspeûno shranjene.",
	8 => "Odjava je bila uspeûna.",
	9 => "lanek je bil uspeûno shranjen.",
	10 => "lanek je bil izbrisan.",
	11 => "Vaûi bloki/okvirji so bili uspeûno shranjeni.",
	12 => "Blok/okvir je bil izbrisan.",
	13 => "Tematsko podroje je bilo uspeûno shranjeno.",
	14 => "Tematsko podroje skupaj z vsemi lanki v njem z je bilo izbrisano.",
	15 => "Povezava je bila uspeûno shranjena v bazo povezav.",
	16 => "Povezava je bila izbrisana.",
	17 => "Dogodek je bil uspeûno shranjen v bazo dogodkov.",
	18 => "Dogodek je bil izbrisan.",
	19 => "Anketa je bila uspeûno shranjena.",
	20 => "Anketa je bila izbrisana.",
	21 => "Uporabniûke nastavitve za novega uporabnika so bile uspeûno shranjene.",
	22 => "Uporabnik je bil izbrisan.",
	23 => "Napaka pri dodajanju dogodka v koledar dogodkov. Vnesite ID dogodka.",
	24 => "Dogodek je bil uspeûno shranjen v vaû koledar dogodkov",
	25 => "Dostop do osebnega koledarja je mogo le e ste prijavljeni.",
	26 => "Dogodek je bil odstranjen iz vaûega osebnega koledarja dogodkov",
	27 => "Sporoilo je bilo poslano.",
	28 => "Plug-in je bil uspeûno shranjen",
	29 => "Úal ta stran ne podpira osebnega koledarja.",
	30 => "Dostop zavrnjen",
	31 => "Úal nimate dostopa do administracije lankov. Vsi poizkusi nedovoljenega dostopa se beleõijo!",
	32 => "Úal nimate dostopa do administracije tematskih podroij. Vsi poizkusi nedovoljenega dostopa se beleõijo!",
	33 => "Úal nimate dostopa do administracije blokov/okvirjev. Vsi poizkusi nedovoljenega dostopa se beleõijo!",
	34 => "Úal nimate dostopa do administracije povezav. Vsi poizkusi nedovoljenega dostopa se beleõijo1",
	35 => "Úal nimate dostopa do administracije dogodkov. Vsi poizkusi nedovoljenega dostopa se beleõijo!",
	36 => "Úal nimate dostopa do administracije anket. Vsi poizkusi nedovoljenega dostopa se beleõijo!",
	37 => "Úal nimate dostopa do administracije uporabnikov. Vsi poizkusi nedovoljenega dostopa se beleõijo!",
	38 => "Úal nimate dostopa do administracije prikljunih modulov. Vsi poizkusi nedovoljenega dostopa se beleõijo!",
	39 => "Úal nimate dostopa do administracije elektronske poûte. Vsi poizkusi nedovoljenega dostopa se beleõijo!",
	40 => "Sistemsko sporoilo",
    41 => "Sorry, you do not have access to the word replacement page. Vsi poizkusi nedovoljenega dostopa se beleõijo!",
    42 => "Your word has been successfully saved.",
	43 => "The word has been successfully deleted.",
    44 => 'Plug-in je bil uspeûno nameûen!',
    45 => 'Plug-in je bil odstranjen.',
    46 => "Úal nimate dostopa do DB backup. Vsak poskus nedovoljenega dostopa se beleõi",
    47 => "This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.",
    48 => 'Hvala ker ste se prijavili za lanstvo v ' . $_CONF['site_name'] . '. Naûe osebje vam bo sporoilo odgovor v kratkem. ée boste sprejeti, vam bomo poslali vaûe geslo email naslov, ki te ga ravnokar napisali.',
    49 => "Skupina je bila uspeûno shranjena.",
    50 => "Skupina je bila uspeûno izbrisana."
);



###########################
#
#
#ko klele sm prûu naprej je bolj kot ne angleûki text




// for plugins.php

$LANG32 = array (
	1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=\"http://geeklog.sourceforge.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
	2 => "Plug-in Installation Disclaimer",
	3 => "Plug-in Installation Form",
	4 => "Plug-in File",
	5 => "Plug-in List",
	6 => "Opozorilo: Plug-in je õe nameûen!",
	7 => "The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it",
	8 => "Plugin Compatibility Check Failed",
	9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=http://www.geeklog.org>Geeklog</a> or get a newer version of the plug-in.",
	10 => "<br><b>There are no plugins currently installed.</b><br><br>",
	11 => "To modify or delete a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in click on New plug-in above.",
	12 => 'no plugin name provided to plugineditor()',
	13 => 'Plugin Editor',
	14 => 'Nov Plug-in',
	15 => 'Administratorske strani',
	16 => 'Ime Plug-ina',
	17 => 'Verzija Plug-in',
	18 => 'Verzija Geekloga',
	19 => 'Omogoen',
	20 => 'Da',
	21 => 'Ne',
	22 => 'Namesti',
    23 => 'Shrani',
    24 => 'Preklii',
    25 => 'Odstrani',
    26 => 'Ime Plug-ina',
    27 => 'Plug-in Homepage',
    28 => 'Verzija Plug-in',
    29 => 'Verzija Geekloga',
    30 => 'Odstrani Plug-in?',
    31 => 'Ali ste prepriani da õelite odstraniti ta plug-in?  S tem bodo iz baze izbrisani tudi vsi podatki, ki jih uporablja ta plug-in.'
);

$LANG_ACCESS = array(
	access => "Dostop",
    ownerroot => "Owner/Root",
    group => "Skupina",
    readonly => "Read-Only",
	accessrights => "Pravice dostopa",
	owner => "Owner",
	grantgrouplabel => "Grant Above Group Edit Rights",
	permmsg => "OBVESTILO: uporabniki so vsi prijavljeni lani, anonimni uporabniki in vsi trenutni neprijavljeni obiskovalci strani.",
	securitygroups => "Varnostne skupine",
	editrootmsg => "éeprav ste administrator, ne morete spreminjati nastavitev root uporabnika, e sami niste root uporabnik. Lahko pa urejate nastavitve vseh ostalih uporabnikov. Vsi poizkusi nedovoljenega dostopa se beleõijo. Vrnite se na <a href=\"{$_CONF["site_url"]}/admin/users.php\">Administratorske strani</a>.",
	securitygroupsmsg => "Izberite skupine, katerim naj pripada uporabnik",
	groupeditor => "Urejanje skupin",
	description => "Opis",
	name => "Ime",
 	rights => "Pravice",
	missingfields => "Manjkajoa polja",
	missingfieldsmsg => "Vpiûite ime in opis skupine!",
	groupmanager => "Administracija skupin",
	newgroupmsg => "Izberite skupinpo, ki jo õeleite odstraniti skupino ali spremeniti njene nastavitve. ée õelite oblikovati novo skupino, kliknite na Nova skupina zgoraj! Osnovnih skupin ni mogoe odstraniti!",
	groupname => "Ime skupine",
	coregroup => "Osnovna skupina",
	yes => "Da",
	no => "Ne",
	corerightsdescr => "Ta skupina je osnovna skupina {$_CONF["site_name"]}. Pravice te skupine ne morejo biti spremenjene. Pravice, ki pripadajo tej skupini so na spodnjem seznamu!",
	groupmsg => "Varnost skupin na tej strnai je urejena hierarhino. Vsaka podskupina ima enake pravice kot njena nadskupina. Zato je priporoljiva uporaba podskupin. ée skupina potrebuje posebne pravice, jih izberite v meniju 'Pravice'.",
	coregroupmsg => "Ta skupina je osnovna skupina strani {$_CONF["site_name"]}. Nastavitve skupin, ki ji pripadajo zato ne morejo biti spremenjene. Spodnji seznam vsebuje imena skupin, ki ji pripadajo.",
	rightsdescr => "Pravice, ki jih doloite skupini, so avtomatsko dodeljene tudi vsem njenim podskupinam. Pravice lahko dodajate tako, da jih izberete iz spodnjega seznama. ée doloena pravica nima 'checkboxa' pomeni, da ji je ta pravica dodeljena, ker je podskupina neke druge skupine.",
	lock => "Zakleni",
	members => "lanov",
	anonymous => "Anonimni uporabnik",
	permissions => "Pravice",
	permissionskey => "R = read, E = edit, edit rights assume read rights",
	edit => "Uredi",
	none => "Noben",
	accessdenied => "Dostop zavrnjen!",
	storydenialmsg => "Úal nimate dostopa do tega lanka. Morda zato, ker niste registrirani uporabnik {$_CONF["site_name"]}? <a href=users.php?mode=New> Registrirajte se!</a> in dobili boste popoln dostop do strani {$_CONF["site_name"]}",
	eventdenialmsg => "Úal nimate dostopa do tega dogodka. Morda zato, ker niste registrirani uporabnik {$_CONF["site_name"]}? <a href=users.php?mode=New> Registrirajte se!</a> in dobili boste popoln dostop do strani {$_CONF["site_name"]}",
	nogroupsforcoregroup => "Ta skupina ne pripada nobeni od preostalih skupin",
	grouphasnorights => "Ta skupina nima nobenih administratorskih pravic.",
	Newgroup => 'Nova Skupina',
	adminhome => 'Administratorske strani',
	save => 'Shrani',
	cancel => 'Preklii',
	delete => 'Izbriûi',
	canteditroot => 'Poizkusili ste urejati nastavitve glavne skupine. Ker niste lan glavne skupine je vaû dostop zavrnjen. ée mislite, da je to napaka, kontatkirajte administratorja sistema.'
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Word Replacment editor",
    wordid => "Word ID",
    intro => "To modify or delete a word, click on that word.  To create a new word replacement click the New word button to the left.",
    wordmanager => "Word Manager",
    word => "Word",
    replacmentword => "Replacment Word",
    Newword => "New Word"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => "Zadnjih 10 backupov",
    do_backup => 'Naredi backup',
    backup_successful => 'Bravo. Baza podatkov se je uspeûno bekapirala ;-).',
    no_backups => 'Sistem nima backupa',
    db_explanation => "ée õelite narediti backup vaûega Geeklog sistema, kliknite gumb spodaj",
    not_found => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Backup Failed: Filesize was 0 bytes',
    path_not_found => "{$_CONF['backup_path']} does not exist or is not a directory",
    no_access => "ERROR: Directory {$_CONF['backup_path']} is not accessible.",
    backup_file => 'Backup file',
    size => 'Size',
    bytes => 'Bytes'
);

$LANG_BUTTONS = array(
    1 => "Domov",
    2 => "Kontakt",
    3 => "Objavi",
    4 => "Povezave",
    5 => "Ankete",
    6 => "Koledar",
    7 => "Statistika strani",
    8 => "Osebne nastavitve",
    9 => "Iûi",
    10 => "Napredno iskanje"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "Gee, I've looked everywhere but I can not find <b>http://{$HTTP_SERVER_VARS["HTTP_HOST"]}{$HTTP_SERVER_VARS["REQUEST_URI"]}</b>.",
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

$LANG_LOGIN = array (
    1 => 'Login required',
    2 => 'Sorry, to access this area you need to be logged in as a user.',
    3 => 'Login',
    4 => 'New User'
);

?>
