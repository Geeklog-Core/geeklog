<?php

###############################################################################
# swedish.php
# This is the swedish language page for GeekLog!
# Translation by: Markus Berg <kelvin@lysator.liu.se>
#
# Credits from original english.php:
#
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

$LANG_CHARSET = "iso-8859-1";

###############################################################################
# Array Format:
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
    1 => "Skrivet av:",
    2 => "l�s mer",
    3 => "kommentar(er)",
    4 => "Redigera",
    5 => "R�sta",
    6 => "Resultat",
    7 => "R�stresultat",
    8 => "r�ster",
    9 => "Administrat�rsfunktioner:",
    10 => "Bidrag",
    11 => "Artiklar",
    12 => "Block",
    13 => "�mnen",
    14 => "L�nkar",
    15 => "Aktiviteter",
    16 => "Omr�stningar",
    17 => "Anv�ndare",
    18 => "SQL Query",
    19 => "Logga ut",
    20 => "Anv�ndarinformation:",
    21 => "Anv�ndarnamn",
    22 => "Anv�ndarnamn",
    23 => "S�kerhetsniv�",
    24 => "Anonym",
    25 => "Skriv ett inl�gg",
    26 => "F�ljande inl�gg �gs av de personer som gjort dem.  Denna sajt tar inget ansvar f�r det som s�gs.",
    27 => "Senaste kommentar",
    28 => "Radera",
    29 => "Inga kommentarer.",
    30 => "�ldre artiklar",
    31 => "Till�ten HTML:",
    32 => "Error, felaktigt anv�ndarnamn",
    33 => "Error, kunde inte skriva till logfilen",
    34 => "Error",
    35 => "Logga ut",
    36 => "p�",
    37 => "Inga artiklar",
    38 => "",
    39 => "Uppdatera",
    40 => "",
    41 => "G�ster",
    42 => "Skrivet av:",
    43 => "Svara p� detta",
    44 => "Upp",
    45 => "MySQL Error Number",
    46 => "MySQL Error Message",
    47 => "Anv�ndarfunktioner",
    48 => "Kontoinformation",
    49 => "Artikelinst�llningar",
    50 => "Error with SQL statement",
    51 => "hj�lp",
    52 => "Ny",
    53 => "Administrat�rsmeny",
    54 => "Kunde inte �ppna filen.",
    55 => "Error at",
    56 => "R�sta",
    57 => "L�senord",
    58 => "Logga in",
    59 => "Har du inget konto?  <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Anm�l dig h�r!</a>",
    60 => "Diskutera...",
    61 => "Skapa nytt konto",
    62 => "ord",
    63 => "Kommentarsinst.",
    64 => "ePosta artikel till n�gon",
    65 => "Version f�r utskrift",
    66 => "Min kalender",
    67 => "V�lkommen till ",
    68 => "hem",
    69 => "kontakt",
    70 => "s�k",
    71 => "skriv artikel",
    72 => "internetl�nkar",
    73 => "tidigare omr�stningar",
    74 => "kalender",
    75 => "detaljerad s�kning",
    76 => "statistik",
    77 => "Plugin",
    78 => "Kommande aktiviteter",
    79 => "Nytt p� sajten",
    80 => "artiklar de senaste",
    81 => "artikel de senaste",
    82 => "timmarna",
    83 => "KOMMENTARER",
    84 => "L�NKAR",
    85 => "senaste 48 hrs",
    86 => "Inga nya kommentarer",
    87 => "senaste tv� veckorna",
    88 => "Inga nya l�nkar",
    89 => "Det finns inga kommande aktiviteter",
    90 => "Hem",
    91 => "Skapade denna sida p�",
    92 => "sekunder",
    93 => "Copyright",
    94 => "Alla varum�rken och copyright p� denna sida �gs av deras respektive �gare.",
    95 => "Powered By",
    96 => "Grupper",
    97 => "Ordlista",
    98 => "Insticksmodul",
    99 => "ARTIKLAR",
    100 => "Inga nya artiklar",
    101 => 'Dina aktiviteter',
    102 => 'Sajtaktiviteter',
    103 => 'DB backup',
    104 => 'av',
    105 => 'ePosta anv�ndare',
    106 => 'visningar',
    107 => 'GL versionstest',
    108 => 'Radera buffert'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => "Aktivitetskalender",
    2 => "Det finns tyv�rr inga aktiviteter att visa.",
    3 => "N�r",
    4 => "Var",
    5 => "Beskrivning",
    6 => "Ny aktivitet",
    7 => "Kommande aktiviteter",
    8 => 'Genom att l�gga till denna aktivitet till din kalender s� kan du snabbt se enbart de '
        . 'aktiviteter du �r intresserad av genom att klicka p� "Min kalender" fr�n anv�ndarfunktionsmenyn.',
    9 => "L�gg till i min kalender",
    10 => "Radera fr�n min kalender",
    11 => "L�gger till aktivitet i {$_USER['username']}:s kalender",
    12 => "Aktivitet",
    13 => "Startar",
    14 => "Slutar",
    15 => "Tillbaka till kalendern"
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => "Skriv en kommentar",
    2 => "Kommentarsl�ge",
    3 => "Logga ut",
    4 => "Skapa ett konto",
    5 => "Anv�ndarnamn",
    6 => "F�r att skriva en kommentar p� denna sajt m�ste man ha ett konto.  Om du inte har ett "
        . "konto s� kan du anv�nda formul�ret nedan f�r att skapa ett.",
    7 => "Din senaste kommentar var ",
    8 => " sekunder sedan.  P� denna sajt m�ste man v�nta minst {$_CONF["commentspeedlimit"]} "
        . "sekunder mellan kommentarer",
    9 => "Kommentar",
    10 => '',
    11 => "Skicka in kommentar",
    12 => "Du m�ste fylla i Titel- Kommentarsf�lten.",
    13 => "Din information",
    14 => "F�rhandsgranska",
    15 => "",
    16 => "Titel",
    17 => "Error",
    18 => 'Att t�nka p�',
    19 => 'F�rs�k h�lla kommentarerna till �mnet.',
    20 => 'F�rs�k svara p� andra personers kommentarer ist�llet f�r att starta nya diskussioner.',
    21 => 'L�s andra personers kommentarer innan du g�r ditt inl�gg f�r att f�rhindra upprepning av '
        . 'det som redan sagts.',
    22 => 'Anv�nd en tydlig �renderad som beskriver vad ditt inl�gg handlar om.',
    23 => 'Din ePostadress kommer INTE att vara publik.',
    24 => 'Anonym anv�ndare'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => "Anv�ndarprofil f�r",
    2 => "Anv�ndarnamn",
    3 => "F�r- och efternamn",
    4 => "L�senord",
    5 => "ePost",
    6 => "Hemsida",
    7 => "Personlig information",
    8 => "PGP-nyckel",
    9 => "Spara information",
    10 => "De tio senaste kommentarerna f�r anv�ndare",
    11 => "Inga anv�ndarkommentarer",
    12 => "Anv�ndarinst�llningar f�r",
    13 => "ePosta nattlig sammanst�llning",
    14 => "Detta l�senord genereras av en slumpgenerator.  Du rekommenderas att byta detta "
        . "l�senord genast.  F�r att byta l�senord loggar man in och klickar p� Kontoinformation "
        . "fr�n Anv�ndarfunktionsmenyn.",
    15 => "Ditt {$_CONF["site_name"]} konto �r nu skapat.  F�r att anv�nda det m�ste du logga in "
        . "med hj�lp av informationen nedan.  Spara detta mail f�r framtida bruk.",
    16 => "Din kontoinformation",
    17 => "Konto existerar inte",
    18 => "ePostadressen du l�mnat verkar inte vara en �kta ePostadress",
    19 => "Anv�ndarnamnet eller ePostadressen existerar redan",
    20 => "ePostadressen du l�mnat verkar inte vara en �kta ePostadress",
    21 => "Error",
    22 => "Registrera med {$_CONF['site_name']}!",
    23 => "N�r du skapar ett anv�ndarkonto kommer du att f� ta del av {$_CONF['site_name']}:s f�rdelar och du kommer att f� m�jlighet att "
        . "posta kommentarer och skicka in artiklar som dig sj�lv.  Om man inte har ett konto s� kan man bara medverka anonymt.  L�gg m�rke "
        . "till att din ePostadress <B>aldrig</B> kommer att visas offentligt p� denna sajt.",
    24 => "Ditt l�senord kommer att skickas till den ePostadress du anger.",
    25 => "Har du gl�mt ditt l�senord?",
    26 => "Ange ditt anv�ndarnamn och klicka p� ePosta l�senord s� kommer ett nytt l�senord att skickas till den ePostadress vi har i v�rt register.",
    27 => "Registrera nu!",
    28 => "ePosta l�senord",
    29 => "loggade ut fr�n",
    30 => "loggade in fr�n",
    31 => "F�r att anv�nda denna funktion m�ste du vara inloggad",
    32 => "Signatur",
    33 => "Aldrig offentlig",
    34 => "Detta �r ditt f�r- och efternamn",
    35 => "Ange l�senord f�r att �ndra det",
    36 => "B�rjar med http://",
    37 => "L�ggs till dina kommentarer",
    38 => "Det handlar om dig!  Alla kan l�sa detta",
    39 => "Din publika PGP-nyckel att dela ut",
    40 => "Inga �mnesikoner",
    41 => "Beredd att moderera",
    42 => "Datumformat",
    43 => "Maximalt antal artiklar",
    44 => "Inga block",
    45 => "Artikelinst�llningar f�r",
    46 => "Exkluderade saker f�r",
    47 => "Konfiguration av nyhetsblock f�r",
    48 => "�mnen",
    49 => "Inga ikoner i artiklar",
    50 => "Klicka ur detta om du inte �r intresserad",
    51 => "Bara artiklarna",
    52 => "Sk�nsv�rdet �r",
    53 => "Skicka mig dagens artiklar varje kv�ll",
    54 => "Klicka i boxarna f�r de �mnen och f�rfattare vars artiklar du inte vill se.",
    55 => "Om du l�mnar dessa tomma betyder det att du vill ha standardupps�ttningen med boxar.  Om du b�rjar v�lja s� m�ste du v�lja alla de som du vill se, "
        . "eftersom standardvalet d�rmed f�rsvinner.  Standardboxarna �r markerade med fetstil.",
    56 => "F�rfattare",
    57 => "Visningsl�ge",
    58 => "Sorteringsordning",
    59 => "Kommentarsbegr�nsning",
    60 => "Hur vill du att kommentarer ska visas?",
    61 => "Nyaste eller �ldsta f�rst?",
    62 => "Standardv�rdet �r 100",
    63 => "Ditt l�senord �r nu ePostat till dig och det b�r anl�nda inom kort.  V�nligen f�lj instruktionerna d�ri.  Tack f�r att du anv�nder " 
        . $_CONF["site_name"],
    64 => "Kommentarsinst�llningar f�r",
    65 => "F�rs�k att logga in igen",
    66 => "Det �r m�jligt att du har skrivit fel.  F�rs�k logga in igen.  �r du en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">ny anv�ndare</a>?",
    67 => "Medlem sedan",
    68 => "Kom ih�g mig i",
    69 => "Hur l�nge ska vi komma ih�g dig fr�n det att du loggar in?",
    70 => "Personliga inst�llningar f�r utseende och inneh�ll av {$_CONF['site_name']}",
    71 => "En av de b�sta funktionerna i {$_CONF['site_name']} �r att du kan g�ra personliga inst�llningar f�r det inneh�ll du vill se och du kan "
        . "f�r�ndra utseendet p� sajten.  F�r att ta tillvara p� dessa funktioner m�ste du f�rst "
        . "<a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrera</a> med {$_CONF['site_name']}.  Redan medlem?  Anv�nd i s� fall "
        . "inloggningsrutan till v�nster f�r att logga in!",
    72 => "Utseende",
    73 => "Spr�k",
    74 => "F�r�ndra sajtens utseende!",
    75 => "ePostade �mnen f�r",
    76 => "Om du v�ljer ett �mne fr�n listan nedan s� kommer du att f� alla nya artiklar fr�n det �mnet mailat till dig varje kv�ll.  V�lj bara de "
        . "�mnen som intresserar dig!",
    77 => "Foto",
    78 => "L�gg till ett fotografi p� dig sj�lv!",
    79 => "Klicka i h�r f�r att radera denna bild",
    80 => "Logga in",
    81 => "Skicka ePost",
    82 => 'Senaste tio artiklar f�r anv�ndare',
    83 => 'Kommentarsstatistik f�r anv�ndare',
    84 => 'Totalt antal artiklar:',
    85 => 'Totalt antal kommentarer:',
    86 => 'Finn alla inl�gg av'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => "Det finns inga nyheter",
    2 => "Det finns inga artiklar att visa.  Antingen finns det inga artiklar, eller s� �r dina artikelinst�llningar f�r restriktiva.",
    3 => " i �mnet $topic",
    4 => "Dagens huvudartikel",
    5 => "N�sta",
    6 => "F�reg�ende"
);

###############################################################################
# links.php

$LANG06 = array(
    1 => "Internetl�nkar",
    2 => "Det finns inga l�nkar att visa.",
    3 => "Skicka in l�nk"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => "R�st sparad",
    2 => "Din r�st har nu sparats",
    3 => "R�st",
    4 => "Omr�stningar i systemet",
    5 => "R�ster"
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => "Det blev alldeles fel n�r vi skulle skicka ditt meddelande.  F�rs�k igen.",
    2 => "Meddelande skickat.",
    3 => "Verifiera att det st�r en riktig ePostadress i svarsf�ltet.",
    4 => "Fyll i namn-, svarsadress-, �rende- och meddelandef�ltet",
    5 => "Error: Anv�ndare existerar inte.",
    6 => "Nu blev det fel.",
    7 => "Anv�ndarprofil f�r",
    8 => "Anv�ndarnamn",
    9 => "Anv�ndarl�nk",
    10 => "Skicka mail till",
    11 => "Ditt namn:",
    12 => "Svarsadress:",
    13 => "�rende:",
    14 => "Meddelande:",
    15 => "HTML kommer inte att �vers�ttas.",
    16 => "Skicka meddelande",
    17 => "ePosta artikel till n�gon",
    18 => "Till namn",
    19 => "Till ePostadress",
    20 => "Fr�n namn",
    21 => "Fr�n ePostadress",
    22 => "Alla f�lt m�ste fyllas i",
    23 => "Detta brev har skickats till dig fr�n $from ($fromemail) f�r att de trodde att du kunde vara intresserad av denna artikel "
        . "fr�n {$_CONF["site_url"]}.  Detta �r inte SPAM  och den inblandade ePostadresserna inblandade i detta har inte sparats.",
    24 => "Kommentera denna artikel p�",
    25 => "F�r att anv�nda denna funktion m�ste du vara inloggad.  Genom att kr�va inloggning f�rhindrar vi missbruk av detta system",
    26 => "Detta formul�r l�ter dig s�nda ePost till den valda anv�ndare.  Alla f�lt m�ste fyllas i.",
    27 => "Kort meddelande",
    28 => "$from skrev: $shortmsg",
    29 => "Detta �r den dagliga sammanst�llningen fr�n {$_CONF['site_name']} f�r ",
    30 => " Dagligt nyhetsbrev f�r ",
    31 => "Titel",
    32 => "Datum",
    33 => "L�s hela artikeln p�",
    34 => "Slut p� meddelandet"
);

###############################################################################
# search.php

$LANG09 = array(
    1 => "Detaljerad s�kning",
    2 => "Nyckelord",
    3 => "�mne",
    4 => "Samtliga",
    5 => "Typ",
    6 => "Artiklar",
    7 => "Kommentarer",
    8 => "F�rfattare",
    9 => "Samtliga",
    10 => "S�k",
    11 => "S�kresultat",
    12 => "tr�ffar",
    13 => "S�kresultat:  inga tr�ffar",
    14 => "Det fanns inga tr�ffar f�r din s�kning p�",
    15 => "F�rs�k igen.",
    16 => "Titel",
    17 => "Datum",
    18 => "F�rfattare",
    19 => "S�k igenom {$_CONF["site_name"]} kompletta databas med nuvarande �ldre artiklar",
    20 => "Datum",
    21 => "till",
    22 => "(Datumformat ����-MM-DD)",
    23 => "Tr�ffar",
    24 => "Funnet",
    25 => "tr�ffar p�",
    26 => "saker i",
    27 => "sekunder",
    28 => 'Ingen artikel eller kommentar matchar din s�kning',
    29 => 'Artikel- och kommentarsresultat',
    30 => 'Inga l�nkar matchade din s�kning',
    31 => 'Denna insticksmodul gav inga tr�ffar',
    32 => 'Aktivitet',
    33 => 'L�nk',
    34 => 'Plats',
    35 => 'Hela dagen',
    36 => 'Inga aktiviteter matchade din s�kning',
    37 => 'Aktivitetsresultat',
    38 => 'L�nkresultat',
    39 => 'L�nkar',
    40 => 'Aktiviteter',
    41 => 'Du m�ste s�ka p� minst tre tecken..',
    42 => 'Du m�ste anv�nda datumformatet ����-MM-DD (�r-m�nad-dag).'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => "Site Statistics",
    2 => "Total Hits to the System",
    3 => "Stories(Comments) in the System",
    4 => "Polls(Answers) in the System",
    5 => "Links(Clicks) in the System",
    6 => "Events in the System",
    7 => "Top Ten Viewed Stories",
    8 => "Story Title",
    9 => "Views",
    10 => "It appears that there are no stories on this site or no one has ever viewed them.",
    11 => "Top Ten Commented Stories",
    12 => "Comments",
    13 => "It appears that there are no stories on this site or no one has ever posted a comment on them.",
    14 => "Top Ten Polls",
    15 => "Poll Question",
    16 => "Votes",
    17 => "It appears that there are no polls on this site or no one has ever voted.",
    18 => "Top Ten Links",
    19 => "Links",
    20 => "Hits",
    21 => "It appears that there are no links on this site or no one has ever clicked on one.",
    22 => "Top Ten Emailed Stories",
    23 => "Emails",
    24 => "It appears that no one has emailed a story on this site"
);

###############################################################################
# article.php

$LANG11 = array(
    1 => "Besl�ktad info",
    2 => "ePosta artikel till n�gon",
    3 => "Skriv ut artikel",
    4 => "Artikelalternativ"
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "Man m�ste vara inloggad f�r att skicka in en $type.",
    2 => "Logga in",
    3 => "Ny anv�ndare",
    4 => "Skicka in en aktivitet",
    5 => "Skicka in en l�nk",
    6 => "Skicka in en artikel",
    7 => "Inloggning kr�vs",
    8 => "Skicka",
    9 => "N�r du skriver en artikel till den h�r sajten s� �r det bra om du f�ljer dessa r�d: "
        . "<UL><LI>Samtliga f�lt m�ste fyllas i<LI>Informationen ska vara korrekt"
        . "<LI>Kontrollera alla l�nkar en extra g�ng</UL>\n",
    10 => "Titel",
    11 => "L�nk",
    12 => "Startdatum",
    13 => "Slutdatum",
    14 => "Plats",
    15 => "Beskrivning",
    16 => "Om \"Annan\", specificera",
    17 => "Kategori",
    18 => "Annan",
    19 => "L�s f�rst",
    20 => "Error: Kategori saknas",
    21 => "Du m�ste ange en ny kategori n�r du v�ljer \"Annan\"",
    22 => "Error: F�lt saknas",
    23 => "Fyll i samtliga f�lt i formul�ret.",
    24 => "Sparad",
    25 => "$type har sparats.",
    26 => "Hastighetsbegr�nsning",
    27 => "Anv�ndarnamn",
    28 => "�mne",
    29 => "Artikel",
    30 => "Du skickade in en artikel f�r ",
    31 => " sekunder sedan.  Du m�ste v�nta minst {$_CONF["speedlimit"]} sekunder mellan artiklar",
    32 => "F�rhandsgranska",
    33 => "F�rhandsgranska artikel",
    34 => "Logga ut",
    35 => "HTML-taggar �r inte till�tna",
    36 => "Artikeltyp",
    37 => "N�r du skickar en aktivitet till {$_CONF["site_name"]} s� hamnar den i den centrala kalendern.  "
        . "Denna funktion �r inte till f�r att lagra personlig information som f�delsedagar eller "
        . "namnsdagar.<BR><BR>N�r du s�nder aktiviteten s� skickas den till en administrat�r "
        . "som, om den blir godk�nd, l�gger upp den p� den centrala kalendern.",
    38 => "L�gg aktivitet till",
    39 => "Central kalender",
    40 => "Personlig kalender",
    41 => "Sluttid",
    42 => "Starttid",
    43 => "Heldagsaktivitet",
    44 => 'Adressrad 1',
    45 => 'Adressrad 2',
    46 => 'Stad',
    47 => 'Stat',
    48 => 'Postnummer',
    49 => 'Aktivitet',
    50 => 'Redigera aktivitetstyper',
    51 => 'Plats',
    52 => 'Radera',
    53 => 'Skapa konto'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
    1 => "Authenticering kr�vs",
    2 => "Felaktig inloggningsinformation",
    3 => "Felaktigt l�senord f�r anv�ndare",
    4 => "Anv�ndarnamn:",
    5 => "L�senord:",
    6 => "All tillg�ng till administrativa delar av denna webbsajt loggas och kontrolleras.<BR>"
        . "Denna sida �r bara till f�r beh�rig personal.",
    7 => "logga in"
);

###############################################################################
# block.php

$LANG21 = array(
    1 => "Otillr�ckliga aministrat�rsr�ttigheter",
    2 => "Du har inte tillr�ckliga r�ttigheter f�r att redigera detta block.",
    3 => "Blockeditor",
    4 => "",
    5 => "Blocktitel",
    6 => "�mne",
    7 => "Samtliga",
    8 => "Block s�kerhetsniv�",
    9 => "Blockordning",
    10 => "Blocktyp",
    11 => "Portalblock",
    12 => "Normalt block",
    13 => "Portalblocksinst�llningar",
    14 => "RDF-l�nk",
    15 => "Senaste RDF-uppdatering",
    16 => "Normalblocksinst�llningar",
    17 => "Blockinneh�ll",
    18 => "Ange Blocktitel, s�kerhetsniv� och inneh�ll",
    19 => "Blockadministrat�r",
    20 => "Blocktitel",
    21 => "Blocks�k.niv�",
    22 => "Blocktyp",
    23 => "Blockordning",
    24 => "Block�mne",
    25 => "Klicka p� ett block nedan f�r att f�r�ndra eller radera det.  Klicka p� \"Nytt block\" "
        . "ovan f�r att skapa ett nytt block.",
    26 => "Layoutblock",
    27 => "PHP-block",
    28 => "PHP-blockinst�llningar",
    29 => "Blockfunktion",
    30 => "Om du vill anv�nda PHP-kod i ditt block, ange namnet p� funktionen ovan.  Din funktion "
        . "m�ste b�rja med prefixet \"phpblock_\" (t.ex. phpblock_getweather).  Om det inte har "
        . "detta prefix kommer funktionen inte att kallas.  Detta g�rs f�r att f�rhindra "
        . "personer som eventuellt har hackat din Geeklog-installation fr�n att exekvera valfri "
        . "kod som kan skada ditt system.  S�tt inte tomma parenteser \"()\" efter ditt "
        . "funktionsnamn.  Slutligen rekommenderas du att l�gga alla dina PHP-block i "
        . "/path/to/geeklog/system/lib-custom.php.  D� kommer koden att vara kvar �ven n�r du "
        . "uppdaterar till en ny version av GeekLog.",
    31 => 'Fel i PHP-block.  Funktionen \"$function\" existerar inte.',
    32 => "Fel: F�lt saknas",
    33 => "Du m�ste ange l�nken till .rdf-filen f�r portalblock",
    34 => "Du m�ste ange titel och funktion av PHP-block",
    35 => "Du m�ste ange titel och inneh�ll f�r normala block",
    36 => "Du m�ste ange inneh�ll f�r layout-block",
    37 => "Felaktigt funktionsnamn i PHP-blocket",
    38 => "Funktioner f�r PHP-block m�ste ha prefixet 'phpblock_' (ex. phpblock_getweather).  "
        . "Detta �r en s�kerhetsfunktion som f�rhindrar eventuella crackare att exekvera godtycklig "
        . "kod p� din server.",
    39 => "Sida",
    40 => "V�nster",
    41 => "H�ger",
    42 => "Du m�ste ange blockordning och s�kerhetsniv� f�r Geeklog:s standardblock",
    43 => "Endast hemsidan",
    44 => "�tkomst nekad",
    45 => "Du �ger inte tillg�ng till detta block.  Denna incident har loggats.  G� tillbaka till "
        . "<a href=\"{$_CONF["site_admin_url"]}/block.php\">blockadministrationen</a>.",
    46 => 'Nytt block',
    47 => 'Administrat�rsmeny',
    48 => 'Blocknamn',
    49 => ' (inga mellanslag och namnet m�ste vara unikt)',
    50 => 'Hj�lpl�nk',
    51 => 'inkludera http://',
    52 => 'Om detta f�lt l�mnas tomt s� kommer inte hj�lpikonen f�r detta block att visas',
    53 => 'Aktiverad',
    54 => 'spara',
    55 => '�ngra',
    56 => 'radera'
);

###############################################################################
# event.php

$LANG22 = array(
    1 => "Aktivitetseditor",
    2 => "",
    3 => "Aktivitet",
    4 => "Aktivitetsl�nk",
    5 => "Startdatum f�r aktivitet",
    6 => "Slutdatum f�r aktivitet",
    7 => "Plats",
    8 => "Aktivitetsbeskrivning",
    9 => "(inkludera http://)",
    10 => "Du m�ste ange datum/tider, beskrivning och plats!",
    11 => "Aktivitetsadministrat�r",
    12 => "Klicka p� en aktivitet f�r att f�r�ndra eller radera den.  Klicka p� \"Ny aktivitet\" "
        . "ovan f�r att skapa en ny aktivtet.",
    13 => "Aktivitet",
    14 => "Startdatum",
    15 => "Slutdatum",
    16 => "�tkomst nekad",
    17 => "Du �ger inte tillg�ng till denna aktivitet.  Denna incident har loggats.  G� tillbaka "
        . "till <a href=\"{$_CONF["site_admin_url"]}/event.php\">aktivitetsadministrationen</a>.",
    18 => 'Ny aktivitet',
    19 => 'Administrat�rsmeny',
    20 => 'spara',
    21 => '�ngra',
    22 => 'radera'
);

###############################################################################
# link.php

$LANG23 = array(
    1 => "L�nkeditor",
    2 => "",
    3 => "L�nktitel",
    4 => "L�nk",
    5 => "Kategori",
    6 => "(inkludera http://)",
    7 => "annan",
    8 => "L�nktr�ffar",
    9 => "L�nkbeskrivning",
    10 => "Du m�ste ange en l�nktitel, URL och beskrivning.",
    11 => "L�nkadministrat�r",
    12 => "Klicka p� l�nken f�r att f�r�ndra eller radera den.  Klicka p� \"Ny l�nk\" ovan "
        . "f�r att skapa en ny l�nk.",
    13 => "L�nktitel",
    14 => "L�nkkategori",
    15 => "L�nk",
    16 => "�tkomst nekad",
    17 => "Du �ger inte tillg�ng till denna l�nk.  Denna incident har loggats.  G� tillbaka till "
        . "<a href=\"{$_CONF["site_admin_url"]}/link.php\">l�nkadministrationen</a>.",
    18 => 'Ny l�nk',
    19 => 'Administrat�rsmeny',
    20 => 'om "annan", specificera',
    21 => 'spara',
    22 => '�ngra',
    23 => 'radera'
);

###############################################################################
# story.php

$LANG24 = array(
    1 => "Tidigare artiklar",
    2 => "Senare artiklar",
    3 => "L�ge",
    4 => "Skrivl�ge",
    5 => "Artikeleditor",
    6 => "Det finns inga artiklar i systemet",
    7 => "F�rfattare",
    8 => "spara",
    9 => "f�rhandsgranska",
    10 => "�ngra",
    11 => "radera",
    12 => "",
    13 => "Titel",
    14 => "�mne",
    15 => "Datum",
    16 => "Ingress",
    17 => "Br�dtext",
    18 => "Tr�ffar",
    19 => "Kommentarer",
    20 => "",
    21 => "",
    22 => "Artikellista",
    23 => "Klicka p� en artikels nummer nedan f�r att redigera eller radera den.  Klicka p� en "
        . "artikels titel f�r att l�sa den artikeln.  Klicka p� \"ny artikel\" ovan f�r att "
        . "skriva en ny artikel.",
    24 => "",
    25 => "",
    26 => "F�rhandsgranska artikel",
    27 => "",
    28 => "",
    29 => "",
    30 => "",
    31 => "Du m�ste ange f�rfattare, titel och ingress",
    32 => "Huvudartikel",
    33 => "Det kan bara finnas en huvudartikel",
    34 => "Utkast",
    35 => "Ja",
    36 => "Nej",
    37 => "Mer av",
    38 => "Mer fr�n",
    39 => "ePost",
    40 => "�tkomst nekad",
    41 => "Du �ger inte �tkomst till denna artikel.  Denna incident har loggats.  Du kan l�sa "
        . "artikeln nedan.  G� tillbaka till "
        . "<a href=\"{$_CONF["site_admin_url"]}/story.php\">artikeladministrationen</a> "
        . "n�r du �r klar.",
    42 => "Du �ger inte �tkomst till denna artikel.  Denna incident har loggats.  G� tillbaka till "
        . "<a href=\"{$_CONF["site_admin_url"]}/story.php\">artikeladministrationen</a>.",
    43 => 'Ny artikel',
    44 => 'Administrat�rsmeny',
    45 => 'Tillg�ng',
    46 => '<b>OBS:</b> om du anger ett framtida datum s� kommer inte artikeln att publiceras '
        . 'f�rr�n det datumet.  Det inneb�r ocks� att artikeln inte kommer att synas i din '
        . 'RDF-export och inte heller i s�k- eller statistiksidorna.',
    47 => 'Bilder',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => '<P>F�r att anv�nda bilderna du bifogar h�r m�ste du l�gga till specialtaggar i din artikel. '
        . 'Specialtaggarna �r [imageX], [imageX_right] eller [imageX_left] d�r X �r bildens nummer.  '
        . 'OBS: Du m�ste anv�nda alla bilder du bifogar.  Om du inte g�r det s� kommer du inte kunna '
        . 'spara din artikel.</P>'
        . '<P><B>F�rhandsgranskning</B>: F�r att f�rhandsgranska en artikel med bifogade bilder m�ste '
        . 'du lagra den som utkast ist�llet f�r att anv�nda "F�rhandsgranskning".  Anv�nd bara '
        . '"F�rhandsgranskning" n�r artikeln saknar bilder.</P>',
    52 => 'Radera',
    53 => 'anv�ndes inte.  Du m�ste inkludera denna bild i ingressen eller br�dtexten innan du kan '
        . 'spara dina �ndringar',
    54 => 'Bifogade bilder anv�ndes inte',
    55 => 'Det blev fel n�r din artikel skulle sparas.  R�tta till dessa fel innan du sparar',
    56 => 'Visa �mnesikon'
);

###############################################################################
# poll.php

$LANG25 = array(
    1 => "L�ge",
    2 => "",
    3 => "Omr�stning skapades",
    4 => "Omr�stning $qid sparad",
    5 => "Redigera omr�stning",
    6 => "Omr�stnings-ID",
    7 => "(anv�nd inte mellanslag)",
    8 => "Visas p� hemsidan",
    9 => "Fr�ga",
    10 => "Svar / R�ster",
    11 => "Det blev fel n�r data ang�ende omr�stning $qid h�mtades",
    12 => "Det blev fel n�r fr�gedata ang�ende omr�stning $qid h�mtades",
    13 => "Skapa omr�stning",
    14 => "spara",
    15 => "�ngra",
    16 => "radera",
    17 => "",
    18 => "Omr�stningslista",
    19 => "Klicka p� en omr�stning f�r att �ndra eller radera den.  Klicka p� \"Ny omr�stning\" ovan "
        . "f�r att skapa en ny omr�stning.",
    20 => "R�stande",
    21 => "�tkomst nekad",
    22 => "Du �ger inte tillg�ng till denna omr�stning.  Denna incident har loggats.  G� tillbaka till "
        . "<a href=\"{$_CONF["site_admin_url"]}/poll.php\">omr�stningsadministrationen</a>.",
    23 => 'Ny omr�stning',
    24 => 'Administrat�rsmeny',
    25 => 'Ja',
    26 => 'Nej'
);

###############################################################################
# topic.php

$LANG27 = array(
    1 => "�mneseditor",
    2 => "�mnes-ID",
    3 => "�mnesnamn",
    4 => "�mnesikon",
    5 => "(anv�nd inte mellanslag)",
    6 => "Om man raderar ett �mne s� raderas alla artiklar och block som �r associerade med detta �mne",
    7 => "Ange �mnes-ID och �mnesnamn",
    8 => "�mnesadministrat�r",
    9 => "Klicka p� ett �mne f�r att redigera eller radera det �mnet.  Klicka p� \"Nytt �mne\" ovan "
        . "f�r att skapa ett nytt �mne.  Dina accessr�ttigheter st�r inom parentes",
    10=> "Sorteringsordning",
    11 => "Artiklar/sida",
    12 => "�tkomst nekad",
    13 => "Du �ger inte tillg�ng till detta �mne.  Denna incident har loggats.  G� tillbaka till "
        . "<a href=\"{$_CONF["site_admin_url"]}/topic.php\">�mnesadministrationen</a>.",
    14 => "Sorteringsmetod",
    15 => "alfabetisk",
    16 => "sk�nsv�rdet �r",
    17 => "Nytt �mne",
    18 => "Administrat�rsmeny",
    19 => 'spara',
    20 => '�ngra',
    21 => 'radera'
);

###############################################################################
# user.php

$LANG28 = array(
    1 => "Anv�ndareditor",
    2 => "Anv�ndar-ID",
    3 => "Anv�ndarnamn",
    4 => "F�r- och efternamn",
    5 => "L�senord",
    6 => "S�kerhetsniv�",
    7 => "ePostadress",
    8 => "Hemsida",
    9 => "(anv�nd inte mellanslag)",
    10 => "Du m�ste ange anv�ndarnamn, f�r- och efternamn, s�kerhetsniv� samt ePostadress",
    11 => "Anv�ndaradministrat�r",
    12 => "Klicka p� en anv�ndare f�r att redigera eller radera den.  Klicka p� \"Ny anv�ndare\" "
        . "ovan f�r att skapa en ny anv�ndare.  Du kan genomf�ra enkla s�kningar genom att ange "
        . "delar av ett anv�ndarnamn, ePostadress eller f�r- eller efternamn i s�kformul�ret nedan.",
    13 => "S�kniv�",
    14 => "Reg.datum",
    15 => 'Ny anv�ndare',
    16 => 'Administrat�rsmeny',
    17 => 'byt l�senord',
    18 => '�ngra',
    19 => 'radera',
    20 => 'spara',
    18 => '�ngra',
    19 => 'radera',
    20 => 'spara',
    21 => 'Det anv�ndarnamnet existerar redan.',
    22 => 'Fel',
    23 => 'L�gg till i klump',
    24 => 'Klumpimportering av anv�ndare',
    25 => 'Du kan importera en klump anv�ndare till Geeklog.  Importfilen m�ste vara en '
        . 'tab-separerad textfil inneh�llande f�ljande f�lt: f�r- och efternamn, anv�ndarnamn '
        . 'ePostadress.  Varje anv�ndare du importerar kommer att f� ett slumpm�ssigt l�senord '
        . 'via ePost.  Du m�ste ange en anv�ndare per rad.  Om du inte f�ljer dessa instruktioner '
        . 's� kan det bli strul som bara kan r�ttas till manuellt.  Var med andra ord mycket '
        . 'noggrann!',
    26 => 'S�k',
    27 => 'Begr�nsa tr�ffar',
    28 => 'Klicka h�r f�r att radera denna bild',
    29 => 'S�kv�g',
    30 => 'Importera',
    31 => 'Nya anv�ndare',
    32 => 'Klart!  Import klar av $successes anv�ndare.  $failures misslyckades',
    33 => 'skicka',
    34 => 'Fel:  Du m�ste ange en fil att skicka.'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Godk�nn",
    2 => "Radera",
    3 => "Redigera",
    4 => 'Profil',
    10 => "Titel",
    11 => "Startdatum",
    12 => "L�nk",
    13 => "Kategori",
    14 => "Datum",
    15 => "�mne",
    16 => 'Anv�ndarnamn',
    17 => 'F�r- och efternamn',
    18 => 'ePost',
    34 => "Kontrollpanel",
    35 => "Nya artiklar",
    36 => "Nya l�nkar",
    37 => "Nya aktiviteter",
    38 => "Skicka",
    39 => "F�r tillf�llet finns det inga bidrag att ta st�llning till",
    40 => "Nya anv�ndare"
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => "s�ndag",
    2 => "m�ndag",
    3 => "tisdag",
    4 => "onsdag",
    5 => "torsdag",
    6 => "fredag",
    7 => "l�rdag",
    8 => "Ny aktivitet",
    9 => "Geeklog-aktivitet",
    10 => "Aktiviteter f�r",
    11 => "Huvudkalender",
    12 => "Min kalender",
    13 => "januari",
    14 => "februari",
    15 => "mars",
    16 => "april",
    17 => "maj",
    18 => "juni",
    19 => "juli",
    20 => "augusti",
    21 => "september",
    22 => "oktober",
    23 => "november",
    24 => "december",
    25 => "Tillbaka till ",
    26 => "Hela dagen",
    27 => "Vecka",
    28 => "Personlig kalender f�r",
    29 => "Publik kalender",
    30 => "radera aktivitet",
    31 => "L�gg till",
    32 => "Aktivitet",
    33 => "Datum",
    34 => "Tid",
    35 => "Snabbokning",
    36 => "Godk�nn",
    37 => "Den personliga kalendern �r inte aktiverad p� denna sajt.",
    38 => "Personlig aktivitetseditor",
    39 => 'Dag',
    40 => 'Vecka',
    41 => 'M�nad'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
     1 => $_CONF['site_name'] . " Mail Utility",
     2 => "Fr�n",
     3 => "Svar till",
     4 => "�rende",
     5 => "Inneh�ll",
     6 => "Skicka till:",
     7 => "Alla anv�ndare",
     8 => "Administrat�r",
    9 => "Inst�llningar",
    10 => "HTML",
     11 => "Viktigt meddelande!",
     12 => "Skicka",
     13 => "Reset",
     14 => "Ignorera anv�ndarinst�llningar",
     15 => "Fel vid ePostande till: ",
    16 => "Skickade ePost till: ",
    17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Skicka ytterligare ePost</a>",
    18 => "Till",
    19 => "OBS: V�lj \"Inloggade anv�ndare\" fr�n rullgardinsmenyn f�r att skicka ePost "
        . "till samtliga sajtmedlemmar.",
    20 => "Skickade <successcount> meddelanden och misslyckades att skicka <failcount> stycken.  "
        . "Om du �r intresserad s� finns detaljerna f�r varje meddelande nedan.  Annars kan du "
        . "<a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">s�nda ytterligare ePost</a> "
        . "eller g� tillbaka till "
        . "<a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">administrat�rsmenyn</a>.",
    21 => 'Misslyckad s�ndning',
    22 => 'Lyckad s�ndning',
    23 => 'Inga misslyckanden',
    24 => 'Inga meddelande s�nda',
    25 => '-- V�lj grupp --',
    26 => "Ange alla f�lt i formul�ret och v�lj en grupp fr�n rullgardinsmenyn."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
    1 => "Ditt l�senord har ePostats till dig och borde ankomma inom kort.  F�lj instruktionerna "
        . "i meddelandet.  Tack f�r att du anv�nder " . $_CONF["site_name"],
    2 => "Tack f�r att du skickat din artikel till {$_CONF["site_name"]}.  Den har nu skickats till "
        . "v�r personal f�r godk�nnande.  Om den godk�nns s� kommer din artikel att publiceras "
        . "p� v�r sajt.",
    3 => "Tack f�r att du skickat en l�nk till {$_CONF["site_name"]}.  Den har nu skickats till "
        . "v�r personal f�r godk�nnande.  Om den godk�nns s� kommer din l�nk att publiceras bland "
        . "v�ra �vriga <a href={$_CONF["site_url"]}/links.php>internetl�nkar</a>.",
    4 => "Tack f�r att du skickat en aktivitet till {$_CONF["site_name"]}.  Den har nu skickats till "
        . "v�r personal f�r godk�nnande.  Om den godk�nns s� kommer din aktivitet att synas i "
        . "v�r <a href={$_CONF["site_url"]}/calendar.php>kalender</a>.",
    5 => "Din kontoinformation har lagrats.",
    6 => "Dina artikelinst�llningar har lagrats.",
    7 => "Dina kommentarsinst�llningar har lagrats.",
    8 => "Du �r nu utloggad.",
    9 => "Artikel sparad.",
    10 => "Artikel raderad.",
    11 => "Ditt block har nu sparats.",
    12 => "Blocket har raderats.",
    13 => "Ditt �mne har nu sparats.",
    14 => "�mnet och alla dess artiklar och block har nu raderats.",
    15 => "Din l�nk har nu sparats.",
    16 => "L�nken har raderats.",
    17 => "Din aktivitet har sparats.",
    18 => "Aktiviteten raderad.",
    19 => "Din omr�stning har nu sparats.",
    20 => "Omr�stningen raderad.",
    21 => "Den nya anv�ndaren har nu sparats.",
    22 => "Anv�ndaren har raderats",
    23 => "Det blev fel n�r aktiviteten skulle sparast till din kalender.  Det saknas ett aktivitets-ID.",
    24 => "Aktiviteten har sparats till din kalender",
    25 => "Du m�ste vara inloggad f�r att komma �t din personliga kalender",
    26 => "Aktiviteten raderad fr�n din personliga kalender",
    27 => "Meddelande skickat.",
    28 => "Insticksmodulen har sparats",
    29 => "Personliga kalendrar �r inte aktiverade p� denna sajt",
    30 => "�tkomst nekad",
    31 => "Du �ger inte tillg�ng till artikeladministrationen.  Denna incident har loggats.",
    32 => "Du �ger inte tillg�ng till �mnesadministrationen.  Denna incident har loggats.",
    33 => "Du �ger inte tillg�ng till blockadministrationen.  Denna incident har loggats.",
    34 => "Du �ger inte tillg�ng till l�nkadministrationen.  Denna incident har loggats.",
    35 => "Du �ger inte tillg�ng till aktivitetsadministrationen.  Denna incident har loggats.",
    36 => "Du �ger inte tillg�ng till omr�stningsadministrationen.  Denna incident har loggats.",
    37 => "Du �ger inte tillg�ng till anv�ndaradministrationen.  Denna incident har loggats.",
    38 => "Du �ger inte tillg�ng till insticksmodulsadministrationen.  Denna incident har loggats.",
    39 => "Du �ger inte tillg�ng till ePostadministrationen.  Denna incident har loggats.",
    40 => "Systemmeddelande",
    41 => "Du �ger inte tillg�ng till ordbytesadministrationen.  Denna incident har loggats.",
    42 => "Ditt ord har sparats.",
    43 => "Ordet har raderats.",
    44 => 'Insticksmodulen installerad!',
    45 => 'Insticksmodulen raderad.',
    46 => "Du �ger inte tillg�ng till databasbackupsadministrationen.  Denna incident har loggats.",
    47 => "Denna funktion fungerar bara p� *nix.  Om du anv�nder *nix som ditt operativsystem "
        . "s� har din buffert raderats.  Om du anv�nder Windows s� m�ste du s�ka efter filer som "
        . "heter adodb_*.php och radera dom manuellt.",
    48 => 'Tack f�r att du ans�kt om medlemsskap i ' . $_CONF['site_name'] . '. V�rt team kommer '
        . 'att se �ver din ans�kan och om den godk�nns s� kommer du att f� ett l�senord via ePost.',
    49 => "Din grupp har sparats.",
    50 => "Gruppen har raderats."
);

// for plugins.php

$LANG32 = array (
    1 => "Att installera en insticksmodul kan skada din Geeklog-installation och m�jligtvis �ven "
        . "ditt system.  Det �r viktigt att du bara installerar instickmoduler som du laddat hem fr�n "
        . "<a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog:s hemsida</a> "
        . "eftersom vi testar alla v�ra insticksmoduler p� ett flertal operativsystem.  Det �r "
        . "viktigt att du f�rst�r att installationsprocessen kr�ver att ett f�tal filsystemskommandon "
        . "kommer att exekveras.  Detta <EM>kan</EM> leda till s�kerhetsproblem -- s�rskilt om "
        . "insticksmodulen kommer fr�n en tredje part.  Trots denna varning kan vi inte "
        . "garantera n�gon installation.  Vi kan inte heller h�llas skadest�ndsskyldiga f�r "
        . "eventuell skada som installationen av insticksmodulen kan orsaka.  Med andra ord: "
        . "installera p� egen risk!  F�r den f�rsiktige finns det manuella installationsinstruktioner "
        . "med varje insticksmodul.",
    2 => "Insticksmodul installationsvarning",
    3 => "Insticksmodul installationsformul�r",
    4 => "Insticksmodulsfil",
    5 => "Insticksmodulslista",
    6 => "Varning:  insticksmodul redan installerad!",
    7 => "Insticksmodulen du f�rs�ker installera existerar redan.  Radera insticksmodulen innan du "
        . "f�rs�ker installera den igen",
    8 => "Kompatibilitetstest f�r insticksmodul misslyckades",
    9 => "Denna insticksmodul kr�ver en nyare version av Geeklog.  Du m�ste antingen uppgradera din  "
        . "<a href=\"http://www.geeklog.net\">Geeklog-installation</a> eller h�mta en nyare "
        . "version av insticksmodulen.",
    10 => "<br><b>Inga insticksmoduler �r installerade.</b><br><br>",
    11 => "Klicka p� insticksmodulens nummer f�r att modifiera eller radera den.  "
        . "Klicka p� namnet p� en insticksmodul f�r att bli l�nkad till dess hemsida och f� mer "
        . "information.  L�s insticksmodulens manual om du vill ha information om hur man installerar "
        . "eller uppgraderar den.",
    12 => 'inget namn p� insticksmodul skickades till plugineditor()',
    13 => 'Insticksmodulseditor',
    14 => 'Ny insticksmodul',
    15 => 'Administrat�rsmeny',
    16 => 'Namn p� insticksmodul',
    17 => 'Version p� insticksmodul',
    18 => 'Geeklog-version',
    19 => 'Aktiverad',
    20 => 'Ja',
    21 => 'Nej',
    22 => 'Installera',
    23 => 'Spara',
    24 => '�ngra',
    25 => 'Radera',
    26 => 'Namn p� insticksmodul',
    27 => 'Insticksmodulens hemsida',
    28 => 'Version p� insticksmodul',
    29 => 'Geeklog-version',
    30 => 'Radera insticksmodul?',
    31 => '�r du s�ker p� att du vill radera denna insticksmodu?  Om du g�r det s� kommer du att '
        . 'radera alla filer, data, och datastrukturer som denna insticksmodul anv�nder.  '
        . 'Om du �r s�ker, klicka "radera" igen nedan.'
);

$LANG_ACCESS = array(
    access => "R�ttigheter",
    ownerroot => "�gare/root",
    group => "Grupp",
    readonly => "Endast l�s",
    accessrights => "R�ttigheter",
    owner => "�gare",
    grantgrouplabel => "Ge ovanst�ende grupp redigeringsr�ttigheter",
    permmsg => "OBS: \"medlemmar\" �r alla inloggade sajtmedlemmar och \"anonym\" �r alla anv�ndare "
        . "som l�ser sajten utan att ha loggat in.",
    securitygroups => "S�kerhetsgrupper",
    editrootmsg => "Trots att du �r en anv�ndaradministrat�r s� kan du inte �ndra root-kontot utan "
        . "att vara root sj�lv.  Du kan �ndra alla anv�ndare f�rutom root-anv�ndare.  Denna "
        . "incident har loggats.  G� tillbaka till "
        . "<a href=\"{$_CONF["site_admin_url"]}/user.php\">anv�ndaradministrationen</a>.",
    securitygroupsmsg => "Kryssa i vilka grupper anv�ndare ska vara med i.",
    groupeditor => "Gruppeditor",
    description => "Beskrivning",
    name => "Namn",
     rights => "R�ttigheter",
    missingfields => "F�lt saknas",
    missingfieldsmsg => "Du m�ste ange ett namn och en beskrivning p� gruppen",
    groupmanager => "Gruppadministrat�r",
    newgroupmsg => "Klicka p� en grupp f�r att �ndra eller radera den.  Klicka p� \"Ny grupp\" ovan "
        . "f�r att skapa en ny grupp.  Notera att k�rngrupper inte kan raderas p� grund av att de "
        . "kr�vs f�r att systemet ska fungera.",
    groupname => "Gruppnamn",
    coregroup => "K�rngrupp",
    yes => "Ja",
    no => "Nej",
    corerightsdescr => "Detta �r en k�rngrupp och dess r�ttigheter kan inte modifieras.  "
        . "Nedan finns en lista �ver de r�ttigheter denna grupp har tillg�ng till.",
    groupmsg => "S�kerhetsgrupper p� denna sajt �r hierarkiskt organiserade.  Genom att l�gga "
        . "denna grupp i n�gon annan grupp s� kommer den att �rva de r�ttigheter de grupperna �ger.  "
        . "D�r det �r m�jligt rekommenderas du anv�nda de listade grupperna f�r att ge r�ttigheter "
        . "till en grupp.  Om din grupp beh�ver skr�ddarsydda r�ttigheter s� kan du v�lja vilka "
        . "specifika sajtegenskaper du vill delegera via rutan nedan.  F�r att g�ra denna grupp till "
        . "medlem av n�gon annan grupp s� �r det bara att markera vilken/vilka via kryssrutorna nedan.",
    coregroupmsg => "Detta �r en k�rngrupp och de grupper som denna grupp tillh�r kan inte modifieras.  "
        . "Nedan finns en lista �ver vilka grupper denna grupp tillh�r.",
    rightsdescr => "De egenskaper en grupp �ger kan antingen specificeras nedan eller genom att ge "
        . "de egenskaperna till en grupp som den aktuella gruppen tillh�r.  De egenskaper nedan "
        . "som saknar kryssrutor �r egenskaper som �rvts fr�n n�gon av de grupper som den aktuella "
        . "gruppen �r med i.  De egenskaper som har kryssrutor kan delegeras direkt till denna grupp.",
    lock => "L�s",
    members => "Medlemmar",
    anonymous => "Anonym",
    permissions => "R�ttigheter",
    permissionskey => "R = l�s, E = �ndra, r�ttighet att �ndra inneb�r automatiskt l�sr�ttigheter",
    edit => "Modifiera",
    none => "Ingen",
    accessdenied => "�tkomst nekad",
    storydenialmsg => "Du �ger inga r�ttigheter att l�sa denna artikel.  Det kan bero p� att du inte �r "
        . "medlem i {$_CONF["site_name"]}.  Du kan <a href=users.php?mode=new>skapa ett konto</a> "
        . "f�r att f� tillg�ng till allt inneh�ll p� sajten!",
    eventdenialmsg => "Du �ger inga r�ttigheter att l�sa denna aktivitet.  Det kan bero p� att du inte "
        . "�r medlem i {$_CONF["site_name"]}.  Du kan <a href=users.php?mode=new>skapa ett konto</a> "
        . "f�r att f� tillg�ng till allt inneh�ll p� sajten!",
    nogroupsforcoregroup => "Denna grupp �r inte medlem i n�gon annan grupp",
    grouphasnorights => "Denna grupp �ger inte tillg�ng till n�gra administrativa funktioner p� denna sajt",
    newgroup => 'Ny grupp',
    adminhome => 'Administrat�rsmeny',
    save => 'spara',
    cancel => '�ngra',
    delete => 'radera',
    canteditroot => 'Du har f�rs�kt att modifiera Root-gruppen, men du �r inte medlem i Root-gruppen.  '
        . 'Kontakta systemadministrat�ren om du anser att detta �r fel'    
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Ordutbyteseditor",
    wordid => "Ord-ID",
    intro => "Klicka p� ett ord f�r att modifiera eller radera det.  Klicka p� \"Nytt ord\" till "
        . "v�nster f�r att skapa ett nytt ordbyte.",
    wordmanager => "Ordadministrat�r",
    word => "Ord",
    replacmentword => "Utbytesord",
    newword => "Nytt ord"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Senaste tio backuperna',
    do_backup => 'Starta backup',
    backup_successful => 'Databasbackup genomf�rd.',
    no_backups => 'Inga backuper finns lagrade i systemet',
    db_explanation => 'Klicka nedan f�r att skapa en ny backup av ditt Geeklog-system',
    not_found => "Felaktig s�kv�g eller s� �r inte mysqldump-programmet exekverbart.<BR>"
        . "Kontrollera <strong>\$_DB_mysqldump_path</strong>-definitionen i config.php.<BR>"
        . "Variabeln �r f�r n�rvarande definierad som: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Backup misslyckades:  filstorleken �r noll',
    path_not_found => "{$_CONF['backup_path']} existerar inte eller �r inte en katalog",
    no_access => "FEL: Katalogen {$_CONF['backup_path']} �r inte tillg�nglig.",
    backup_file => 'Backupfil',
    size => 'Storlek',
    bytes => 'Byte'
);

$LANG_BUTTONS = array(
    1 => "Aktuellt",
    2 => "Kontaktinfo",
    3 => "Skriv artikel",
    4 => "L�nkar",
    5 => "Omr�stningar",
    6 => "Kalender",
    7 => "Statistik",
    8 => "Personliga inst�llningar",
    9 => "S�k",
    10 => "detaljerad s�kning"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "J�sses,  jag har letat �verallt, men jag kan inte hitta "
        . "<b>%s</b>.",
    3 => "<p>Vi beklagar, men filen du s�ker existerar inte.  Leta g�rna p� v�r "
        . "<a href=\"{$_CONF['site_url']}\">f�rstasida</a> eller anv�nd "
        . "<a href=\"{$_CONF['site_url']}/search.php\">s�ksidan</a> f�r att f�rs�ka lokalisera "
        . "det du s�ker."
);

$LANG_LOGIN = array (
    1 => 'Inloggning kr�vs',
    2 => 'F�r att komma �t denna sida s� m�ste du vara inloggad.',
    3 => 'Logga in',
    4 => 'Ny anv�ndare'
);

?>
