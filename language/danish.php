<?php

###############################################################################
# danish.php
# This is the english language page for GeekLog!
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

$LANG_CHARSET = 'iso-8859-1';

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
    1 => 'Tilf�jet af:',
    2 => 'l�s mere',
    3 => 'kommentarer',
    4 => 'Rediger',
    5 => 'Stem',
    6 => 'Resultater',
    7 => 'Afstemningsresultater',
    8 => 'stemmer',
    9 => 'Adminfuntioner:',
    10 => 'Tilf�jelser',
    11 => 'Historier',
    12 => 'Kasser',
    13 => 'Emner',
    14 => 'Links',
    15 => 'Begivenheder',
    16 => 'Afstemninger',
    17 => 'Brugere',
    18 => 'SQL Foresp�rgsel',
    19 => 'Log ud',
    20 => 'Brugerinformation:',
    21 => 'Brugernavn',
    22 => 'Bruger ID',
    23 => 'Sikkerhedsniveau',
    24 => 'Anonym',
    25 => 'Svar',
    26 => 'F�lgende kommentarer ejes af de/den, som har tilf�jet dem. Hjemmesiden er ikke ansvarlig for hvad de/den har skrevet/sagt.',
    27 => 'Seneste tilf�jelse',
    28 => 'Slet',
    29 => 'Der er ingen kommentarer',
    30 => '�ldre Historier',
    31 => 'Tilladte HTML Tags:',
    32 => 'Fejl, ugyldigt brugernavn',
    33 => 'Fejl, kunne ikke skrive til logfilen',
    34 => 'Fejl',
    35 => 'Log ud',
    36 => 'den',
    37 => 'Ingen bruger historier',
    38 => 'Content Syndication',
    39 => 'Genindl�s',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'G�ster',
    42 => 'Forfattet af:',
    43 => 'Svar p� dette',
    44 => 'Top',
    45 => 'MySQL Fejl Nummer',
    46 => 'MySQL Fejl Besked',
    47 => 'Brugerfunktioner',
    48 => 'Kontoinformation',
    49 => 'Visningspr�ferencer',
    50 => 'Fejl p� SQL statement',
    51 => 'hj�lp',
    52 => 'Ny',
    53 => 'Admin Hjem',
    54 => 'Kunne ikke �bne filen.',
    55 => 'Fejl p�',
    56 => 'Stem',
    57 => 'Password',
    58 => 'Log ind',
    59 => "Har du endnu ikke en konto? Opret en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Ny Brugerkonto</a>",
    60 => 'Tilf�j en kommentar',
    61 => 'Opret en Ny Konto',
    62 => 'ord',
    63 => 'Kommentarpr�ferencer',
    64 => 'Send Artiklen Til en Ven',
    65 => 'Se Printervenlig Version',
    66 => 'Min Kalender',
    67 => 'Velkommen til ',
    68 => 'hjem',
    69 => 'kontakt',
    70 => 's�g',
    71 => 'tilf�j',
    72 => 'links',
    73 => 'tidligere afstemninger',
    74 => 'kalender',
    75 => 'avanceret s�gning',
    76 => 'sidestatistik',
    77 => 'Plugins',
    78 => 'Kommende Begivenheder',
    79 => 'Nyt',
    80 => 'historier i de sidste',
    81 => 'historie i de sidste',
    82 => 'timer',
    83 => 'KOMMENTARER',
    84 => 'LINKS',
    85 => 'sidste 48 timer',
    86 => 'Ingen nye kommentarer',
    87 => 'sidste 2 uger',
    88 => 'Ingen nye links',
    89 => 'Der er ingen kommende begivenheder',
    90 => 'Hjem',
    91 => 'Genererede siden p�',
    92 => 'sekunder',
    93 => 'Copyright',
    94 => 'Alle trademarks og copyrights p� hjemmesiden tilh�rer de respektive ejere.',
    95 => 'Styrket Af',
    96 => 'Grupper',
    97 => 'Ordliste',
    98 => 'Plugins',
    99 => 'HISTORIER',
    100 => 'Ingen nye historier',
    101 => 'Dine Begivenheder',
    102 => 'Sidebegivenheder',
    103 => 'DB Backup',
    104 => 'af',
    105 => 'Email Brugere',
    106 => 'Visninger',
    107 => 'GL Version Test',
    108 => 'Slet Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Kalender',
    2 => 'Desv�rre, der er ingen begivenheder at vise.',
    3 => 'Hvorn�r',
    4 => 'Hvor',
    5 => 'Beskrivelse',
    6 => 'Tilf�j En Begivenhed',
    7 => 'Kommende Begivenheder',
    8 => 'Hvis du tilf�jer denne begivenhed til din kalender, kan du hurtigt f� et overblik over kun de begivenheder du er interesseret i, ved at klikke "Min Kalender" i Brugerkassen.',
    9 => 'Tilf�j til Min Kalender',
    10 => 'Fjern fra Min Kalender',
    11 => "Tilf�jer Begivenhed til {$_USER['username']}'s Kalender",
    12 => 'Begivenhed',
    13 => 'Begynder',
    14 => 'Slutter',
    15 => 'Tilbage til Kalenderen'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Tilf�j en Kommentar',
    2 => 'Tilf�jelsesm�de',
    3 => 'Log ud',
    4 => 'Lav en Konto',
    5 => 'Brugernavn',
    6 => 'Hjemmesiden kr�ver, at du er logget ind, for at kunne tilf�je en kommentar. Log venligst ind! Hvis du endnu ikke har oprettet en konto, kan du anvende nedenst�ende form til at oprette �n.',
    7 => 'Din sidste kommentar var ',
    8 => " sekunder siden. Hjemmesiden kr�ver mindst {$_CONF['commentspeedlimit']} sekunder mellem kommentarer",
    9 => 'Kommentar',
    10 => '',
    11 => 'Tilf�j Kommentar',
    12 => 'Udfyld Titel og Kommentarfelterne, da de er obligatoriske ved tilf�jelse af en kommentar.',
    13 => 'Din Information',
    14 => 'Gennemse',
    15 => '',
    16 => 'Titel',
    17 => 'Fejl',
    18 => 'Vigtigt',
    19 => 'Hold venligst kommentaren indenfor det aktuelle emne.',
    20 => 'Svar p� andres kommentarer istedet for at oprette nye diskussioner.',
    21 => 'L�s �vrige kommentarer f�r du svarer, for at undg� at gentage hvad andre allerede har sagt.',
    22 => 'Brug en tydelig Titel, s� det skinner igennem hvilket emne din kommentar omhandler.',
    23 => 'Din emailadresse bliver IKKE offentliggjort.',
    24 => 'Anonym Bruger'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Brugerprofil for',
    2 => 'Brugernavn',
    3 => 'Fuldt Navn',
    4 => 'Password',
    5 => 'Email',
    6 => 'Hjemmeside',
    7 => 'Biografi',
    8 => 'PGP N�gle',
    9 => 'Gem Information',
    10 => 'Sidste 10 kommentarer af bruger',
    11 => 'Ingen Brugerkommentarer',
    12 => 'Brugerpr�ferencer for',
    13 => 'Send Natligt Udtr�k via Email',
    14 => 'Dette password er tilf�ldigt genereret. Du anbefales at �ndre passwordet omg�ende. For at �ndre dit password, skal du logge ind p� vejlerWEBben og klikke p� kontoinformation i brugerkassen.',
    15 => "Din {$_CONF['site_name']} konto er oprettet. For at kunne bruge den, skal du logge ind med nedenst�ende oplysninger. Gem denne email for fremtidig reference.",
    16 => 'Din Konto Information',
    17 => 'Kontoen eksisterer ikke',
    18 => 'Den angivne emailadresse synes at v�re ugyldig',
    19 => 'Det angivne brugernavn eller emailadressen eksisterer allerede',
    20 => 'Den angivne emailadresse synes at v�re ugyldig',
    21 => 'Fejl',
    22 => "Opret konto p� {$_CONF['site_name']}!",
    23 => "Oprettelse af en konto p� {$_CONF['site_name']} vil give dig mulighed for at tilf�je kommentarer og nyheder/historier i dit eget navn. Hvis du ikke har en konto, vil du kun kunne deltage p� hjemmesiden som Anonym. Den emailadresse du opgiver vil <b><i>aldrig</i></b> blive offentliggjort p� denne side.",
    24 => 'Dit password bliver sendt til den emailadresse du angiver.',
    25 => 'Glemt Dit Password?',
    26 => 'Indtast dit brugernavn og klik p� Email Password, og et nyt password bliver sendt til den emailadresse du har angivet.',
    27 => 'Opret Konto!',
    28 => 'Email Password',
    29 => 'logget ud fra',
    30 => 'logget ind fra',
    31 => 'Denne funktion kr�ver at du er logget ind',
    32 => 'Signatur',
    33 => 'Bliver aldrig vist offentligt',
    34 => 'Dit rigtige navn',
    35 => 'Indtast password for at �ndre det nuv�rende',
    36 => 'Begynder med http://',
    37 => 'Bliver tilf�jet dine kommentarer',
    38 => 'Alt om dig! Alle kan l�se dette',
    39 => 'Din offentlige PGP n�gle',
    40 => 'Ingen Ikoner ved Emner',
    41 => 'Willing to Moderate',
    42 => 'Datoformat',
    43 => 'Maksimum Antal Historier',
    44 => 'Ingen kasser',
    45 => 'Visningspr�ferencer for',
    46 => 'Ekskluderede Emner og Forfattere for',
    47 => 'Kassekonfiguration for',
    48 => 'Emner',
    49 => 'Ingen ikoner i historier',
    50 => 'Afmarker denne hvis du ikke er interesseret',
    51 => 'Kun nyheder og historier',
    52 => 'Standard er 10',
    53 => 'Modtag dagens historier hver nat',
    54 => 'Marker de emner og forfattere du ikke �nsker at se noget fra.',
    55 => 'Hvis du lader disse v�re umarkerede, betyder det at du ser standardvalget af emner/forfattere. Hvis du begynder at markere nogen af disse, skal du markere alle dem du �nsker at se, fordi standardvalget i s� fald bliver ignoreret. Standardvalg vises med <b>fed</b> skrift.',
    56 => 'Forfattere',
    57 => 'Visningsm�de',
    58 => 'Sorteringsr�kkef�lge',
    59 => 'Kommentarbegr�nsning',
    60 => 'Hvordan vil du have kommmentarer vist p� siden?',
    61 => 'Nyeste eller �ldste f�rst?',
    62 => 'Standard er 100',
    63 => 'Dit password er blevet sendt, og skulle snart dukke op p� din emailadresse. F�lg instruktionerne i den modtagne besked',
    64 => 'Kommentarpr�ferencer for',
    65 => 'Pr�v at logge ind igen',
    66 => "Du kan have fejlindtastet dine brugeroplysninger. Pr�v at logge ind igen herunder. Er du en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">ny bruger</a>?",
    67 => 'Oprettet siden',
    68 => 'Husk mig i',
    69 => 'Hvor l�nge skal dine oplysninger huskes efter at du er logget ind?',
    70 => "Konfigurer udseendet og layoutet p� {$_CONF['site_name']}",
    71 => "En af mulighederne p� {$_CONF['site_name']} er at du kan konfigurere indhold, udseende og layout p� siden. For at bruge disse funktioner, skal du f�rst <a href=\"{$_CONF['site_url']}/users.php?mode=new\">oprette en konto</a> p� {$_CONF['site_name']}. Hvis du allerede er oprettet, kan du anvende loginformen til venstre!",
    72 => 'Tema',
    73 => 'Sprog',
    74 => '�ndre denne sides udseende!',
    75 => 'Emailede Emner for',
    76 => 'Hvis du v�lger et eller flere emner fra listen herunder, vil du modtage alle nye historier under det enkelte emne ved dagens afslutning. V�lg de emner som interesserer dig!',
    77 => 'Foto',
    78 => 'Tilf�j et vellignende foto af dig selv!',
    79 => 'Marker her for at slette dette billede',
    80 => 'Login',
    81 => 'Send Email',
    82 => 'Sidste 10 historier af bruger',
    83 => 'Post statistik for bruger',
    84 => 'Antallet af artikler:',
    85 => 'Antallet af kommentarer:',
    86 => 'Find alle poster af',
    87 => 'Dit brugernavn',
    88 => "Someone (possibly you) has requested a new password for your account \"%s\" on {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nIf you really want this action to be taken, please click on the following link:\n\n",
    89 => "If you do not want this action to be taken, simply ignore this message and the request will be disregarded (your password will remain unchanged).\n\n",
    90 => 'You can enter a new password for your account below. Please note that your old password is still valid until you submit this form.',
    91 => '�ndre password',
    92 => 'Indtast nyt password',
    93 => 'Your last request for a new password was %d seconds ago. This site requires at least %d seconds between password requests.',
    94 => 'Slet konto "%s"',
    95 => 'Click the "delete account" button below to remove your account from our database. Please note that any stories and comments you posted under this account will <strong>not</strong> be deleted but show up as being posted by "Anonymous".',
    96 => 'slet konto',
    97 => 'Confirm Account Deletion',
    98 => 'Are you sure you want to delete your account? By doing so, you will not be able to log into this site again (unless you create a new account). If you are sure, click "delete account" again on the form below.',
    99 => 'Private indstillinger for',
    100 => 'Email fra Admin',
    101 => 'Tillad email fra bangM administrator',
    102 => 'Email fra brugere',
    103 => 'Tillad email fra andre brugere',
    104 => 'Vis Online Status',
    105 => 'Vis i Hvem er online blokken'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Der er ingen nyheder at vise',
    2 => 'Der er ingen nyheder i databasen. Enten er der ikke nogen nyheder tilf�jet dette emne, eller ogs� er dine brugerpr�ferencer muligvis for restriktive.',
    3 => "for emnet {$topic}",
    4 => 'Mest sp�ndende lige nu',
    5 => 'N�ste',
    6 => 'Forrige'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'Links',
    2 => 'Der er ingen links.',
    3 => 'Tilf�j Et Link'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'Afstemningen er Gemt',
    2 => 'Din stemme er afgivet og gemt',
    3 => 'Stem',
    4 => 'Afstemninger i Systemet',
    5 => 'Stemmer',
    6 => 'View other poll questions'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Der opstod en fejl under afsendelse af din besked. Pr�v igen.',
    2 => 'Beskeden blev sendt.',
    3 => 'V�r opm�rksom p� at du angiver en gyldig emailadresse i Svar Til feltet.',
    4 => 'Udfyld Dit Navn, Svar Til, Emne og Besked felterne',
    5 => 'Fejl: En s�dan bruger eksisterer ikke.',
    6 => 'Der er sket en fejl.',
    7 => 'Brugerprofil for',
    8 => 'Brugernavn',
    9 => 'Bruger hjemmeside',
    10 => 'Send email til',
    11 => 'Dit Navn:',
    12 => 'Svar Til:',
    13 => 'Emne:',
    14 => 'Besked:',
    15 => 'HTML bliver ikke oversat.',
    16 => 'Send Besked',
    17 => 'Email Denne Historie til en Ven',
    18 => 'Til Navn',
    19 => 'Til Emailadresse',
    20 => 'Fra Navn',
    21 => 'Fra Emailadresse',
    22 => 'Alle felter skal udfyldes',
    23 => "Denne email er sendt til dig fra {$from} ({$fromemail}), fordi vedkommende mener at du m�tte v�re interesseret i denne nyhed/historie fra {$_CONF['site_url']}. Dette er ikke SPAM (reklameemail), og emailadresserne involveret i denne transaktion blev ikke gemt til senere brug.",
    24 => 'Kommenter denne historie p�',
    25 => 'Du skal v�re logget ind for at kunne anvende denne mulighed. Ved at du logger ind, hj�lper det os til at undg� misbrug af systemet',
    26 => 'Denne formular lader dig afsende en email til den valgte bruger. Alle felter skal udfyldes.',
    27 => 'Kort besked',
    28 => "{$from} skrev: {$shortmsg}",
    29 => "Dette er den daglige dosis fra {$_CONF['site_name']} for ",
    30 => ' Daglig Dosis for ',
    31 => 'Titel',
    32 => 'Dato',
    33 => 'L�s den fulde historie p�',
    34 => 'Slutning af Besked',
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Avanceret S�gning',
    2 => 'N�gleord',
    3 => 'Emne',
    4 => 'Alle',
    5 => 'Type',
    6 => 'Historier',
    7 => 'Kommentarer',
    8 => 'Forfattere',
    9 => 'Alle',
    10 => 'S�g',
    11 => 'S�geresultater',
    12 => 'resultater',
    13 => 'S�geresultat: Der var ingen resultat',
    14 => 'Der var ingen resultat for din s�gning p�',
    15 => 'Pr�v igen.',
    16 => 'Titel',
    17 => 'Dato',
    18 => 'Forfatter',
    19 => "S�g hele {$_CONF['site_name']} databasen af nuv�rende og gamle historier.",
    20 => 'Dato',
    21 => 'til',
    22 => '(Datoformat MM-DD-YYYY)',
    23 => 'Hits',
    24 => 'Fandt',
    25 => 'resultater i',
    26 => 'muligheder p�',
    27 => 'sekunder',
    28 => 'Ingen resultater for historier eller kommentarer p� din s�gning',
    29 => 'Historie og Kommentar resultater',
    30 => 'Ingen links passede p� din s�gning',
    31 => 'Denne plugin returnerede ingen resultater',
    32 => 'Begivenhed',
    33 => 'URL',
    34 => 'Sted',
    35 => 'Hele dagen',
    36 => 'Ingen begivenheder passede p� din s�gning',
    37 => 'Begivenhed Resultater',
    38 => 'Link Resultater',
    39 => 'Links',
    40 => 'Begivenheder',
    41 => 'Din foresp�rgsel burde indeholde mindst 3 tegn.',
    42 => 'Anvend venligst et datoformat som YYYY-MM-DD (�r-m�ned-dag).',
    43 => 'exact phrase',
    44 => 'all of these words',
    45 => 'any of these words',
    46 => 'Next',
    47 => 'Previous',
    48 => 'Author',
    49 => 'Date',
    50 => 'Hits',
    51 => 'Link',
    52 => 'Location',
    53 => 'Story Results',
    54 => 'Comment Results',
    55 => 'the phrase',
    56 => 'AND',
    57 => 'OR'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Sidestatistik',
    2 => 'Antal Hits i Systemet',
    3 => 'Historier (Kommentarer) i Systemet',
    4 => 'Afstemninger (Stemmer) i Systemet',
    5 => 'Links (Kliks) i Systemet',
    6 => 'Begivenheder i Systemet',
    7 => 'Top 10 Viste Historier',
    8 => 'Historie Titel',
    9 => 'Visninger',
    10 => 'Der er ikke nogle historie p� dette site eller ogs� er der ingen, som har set dem.',
    11 => 'Top 10 Kommenterede Historier',
    12 => 'Kommentarer',
    13 => 'Der er ikke nogle historier p� dette site eller ogs� er der ikke nogen, der har lavet en kommentar.',
    14 => 'Top 10 Afstemninger',
    15 => 'Sp�rgsm�l',
    16 => 'Stemmer',
    17 => 'Der er ikke nogen afstemninger eller ogs� er der ikke nogen, der har stemt..',
    18 => 'Top 10 Links',
    19 => 'Links',
    20 => 'Hits',
    21 => 'Der er ikke nogen links p� dette site eller ogs� er der ikke, som har klikket p� et.',
    22 => 'Top 10 Emailede Historier',
    23 => 'Emails',
    24 => 'Der er ikke nogen, der har emailet en historie'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Relateret',
    2 => 'Send',
    3 => 'Print',
    4 => 'Muligheder'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "For at tilf�je en {$type} skal du v�re logget ind.",
    2 => 'Log ind',
    3 => 'Ny Bruger',
    4 => 'Tilf�j en Begivenhed',
    5 => 'Tilf�j et Link',
    6 => 'Tilf�j en Historie',
    7 => 'Log ind Kr�vet',
    8 => 'Tilf�j',
    9 => 'N�r du tilf�jer information til brug p� denne hjemmeside, anmoder vi dig om at f�lge disse retningslinier...<ul><li>Udfyld alle felter, det er p�kr�vet<li>Bidrag med n�jagtig viden og information<li>Dobbelttjek alle hjemmesideadresser (URLs)</ul>',
    10 => 'Titel',
    11 => 'Link',
    12 => 'Start Dato',
    13 => 'Slut Dato',
    14 => 'Sted',
    15 => 'Beskrivelse',
    16 => 'Hvis anden, angiv hvilken',
    17 => 'Kategori',
    18 => 'Anden',
    19 => 'L�s F�rst',
    20 => 'Fejl: Manglende Kategori',
    21 => 'Ved valg af "Anden" angiv da venligst et kategorinavn',
    22 => 'Fejl: Manglende Felter',
    23 => 'Udfyld alle felter i formularen. De er alle p�kr�vet.',
    24 => 'Tilf�jelsen er Gemt',
    25 => "Din {$type} tilf�jelse er gemt.",
    26 => 'Fartbegr�nsning',
    27 => 'Brugernavn',
    28 => 'Emne',
    29 => 'Historie',
    30 => 'Din sidste tilf�jelse var ',
    31 => " sekunder siden. Siden kr�ver som minimum {$_CONF['speedlimit']} sekunder mellem tilf�jelser",
    32 => 'Gennemse',
    33 => 'Gennemse Historie',
    34 => 'Log Ud',
    35 => 'HTML er ikke tilladt',
    36 => 'Postm�de',
    37 => "N�r du tilf�jer en begivenhed til {$_CONF['site_name']} bliver den automatisk tilf�jet den overordnede kalender, hvorefter alle brugere kan tilf�je din begivenhed til deres personlige kalender. Denne mulighed er <b>IKKE</b> t�nkt som stedet hvor du skal tilf�je f�dselsdage og andre personlige begivenheder.<br><br>N�r du har tilf�jet begivenheden, bliver den tilsendt en af vore administratorer, og hvis den derefter bliver godkendt, dukker den op i den overordnede kalender.",
    38 => 'Tilf�j Begivenhed Til',
    39 => 'Overordnet Kalender',
    40 => 'Personlig Kalender',
    41 => 'Sluttid',
    42 => 'Starttid',
    43 => 'Hele Dagen',
    44 => 'Adresse Linie 1',
    45 => 'Adresse Linie 2',
    46 => 'By',
    47 => 'Omr�de',
    48 => 'Postnummer',
    49 => 'Begivenhedstype',
    50 => 'Rediger Begivenhedstyper',
    51 => 'Sted',
    52 => 'Slet',
    53 => 'Lav en Konto'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Autorisation P�kr�vet',
    2 => 'Adgang N�gtet! Forkert Log ind Information',
    3 => 'Ugyldig password for bruger',
    4 => 'Brugernavn:',
    5 => 'Password:',
    6 => 'Al adgang til administrative afdelinger af denne hjemmeside bliver logget og gennemset.<br>Denne side er kun til brug for autoriseret personale.',
    7 => 'log ind'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Utilstr�kkelige Admin Rettigheder',
    2 => 'Du har ikke tilstr�kkelige rettigheder til at kunne redigere denne kasse.',
    3 => 'Kasse Editor',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Kasse Titel',
    6 => 'Emne',
    7 => 'Alle',
    8 => 'Kasse Sikkerhedsniveau',
    9 => 'Kasse Orden',
    10 => 'Kasse Type',
    11 => 'Portal Kasse',
    12 => 'Normal Kasse',
    13 => 'Portal Kasse Muligheder',
    14 => 'RDF URL',
    15 => 'Sidste RDF Opdatering',
    16 => 'Normal Kasse Muligheder',
    17 => 'Kasse Indhold',
    18 => 'Udfyld Kasse Titel, Sikkerhedsniveau og Indhold felterne',
    19 => 'Kasse Manager',
    20 => 'Kasse Titel',
    21 => 'Kasse SikNiv',
    22 => 'Kasse Type',
    23 => 'Kasse Orden',
    24 => 'Kasse Emne',
    25 => 'For at redigere eller slette en kasse, klik p� kassen herunder. For at tilf�je en ny kasse, klik p� ny kasse herover.',
    26 => 'Layout Kasse',
    27 => 'PHP Kasse',
    28 => 'PHP Kasse Muligheder',
    29 => 'Kasse Funktioner',
    30 => 'Hvis du vil anvende PHP i en af dine kasser, skal du angive navnet p� funktionen herover. Navnet p� din funktion skal starte med "phpblock_" (f.eks. phpblock_getweather). Hvis funktionen ikke starter med dette, vil funktionen ikke blive fundet. Vi anvender dette for at undg�, at eventuelle hackere af din hjemmeside, kan anvende harmfulde kald til funktioner, som vil v�re skadelige for dit system. Anvend IKKE tomme parantser "()" efter funktionsnavnet. Endelig er det anbefalelsesv�rdigt at du putter al din PHP kode i /path/to/geeklog/system/lib-custom.php. Dette tillader din kode at blive gemt og anvendt selvom du opgraderer til en nyere version af GeekLog.',
    31 => 'Fejl i PHP kasse. Funktionen, , findes ikke.',
    32 => 'Fejl, Manglende Felt(er)',
    33 => 'Du skal indtaste URL adressen til .rdf filen for portal kasser',
    34 => 'Du skal udfylde felterne titel og funtion for PHP kasser',
    35 => 'Du skal udfylde felterne titel og indhold for normale kasser',
    36 => 'Du skal udfylde feltet indhold for layout kasser',
    37 => 'D�rligt PHP kasse funktionsnavn',
    38 => 'Funktioner for PHP kasser skal starte med \'phpblock_\' (f.eks. phpblock_getweather). \'phpblock_\' angivelsen er p�kr�vet af sikkerhedsm�ssige �rsager for at undg� anvendelse af harmfuld kode.',
    39 => 'Side',
    40 => 'Venstre',
    41 => 'H�jre',
    42 => 'Du skal angive kasser�kkef�lge og sikkerhedsniveau for standard GeekLog kasser',
    43 => 'Kun P� Hjemmeside',
    44 => 'Adgang N�gtet',
    45 => "Du fors�ger at f� adgang til en kasse, som du ikke har rettigheder til. Dette fors�g er blevet skrevet til loggen. G� venligst <a href=\"{$_CONF['site_url']}/admin/block.php\">tilbage til kasseadministrationssiden</a> - tak.",
    46 => 'Ny Kasse',
    47 => 'Admin Hjem',
    48 => 'Kasse Navn',
    49 => ' (ingen mellemrum og skal v�re unik)',
    50 => 'Hj�lpefil URL',
    51 => 'inkluder http://',
    52 => 'Hvis du efterlader dette felt tomt, vil hj�lpeikonet for denne kasse ikke vises',
    53 => 'Sl�et til',
    54 => 'gem',
    55 => 'fortryd',
    56 => 'slet',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Begivenhed Editor',
    2 => '',
    3 => 'Begivenhed Titel',
    4 => 'Begivenhed URL',
    5 => 'Begivenhed Start Dato',
    6 => 'Begivenhed Slut Dato',
    7 => 'Begivenhed Sted',
    8 => 'Begivenhed Beskrivelse',
    9 => '(inkluder http://)',
    10 => 'Du skal angive dato/tid, beskrivelse og sted!',
    11 => 'Begivenhed Manager',
    12 => 'For at redigere eller slette en begivenhed klik p� begivenheden herunder. For at oprette en ny begivenhed, klik p� ny begivenhed herover.',
    13 => 'Begivenhed Titel',
    14 => 'Start Dato',
    15 => 'Slut Dato',
    16 => 'Adgang N�gtet',
    17 => "Du pr�ver at f� adgang til en begivenhed, hvilket du ikke har rettigheder til! Dette fors�g er blevet logget. G� tilbage til <a href=\"{$_CONF['site_url']}/admin/event.php\">administrations interfacet</a>.",
    18 => 'Ny Begivenhed',
    19 => 'Admin Hjem',
    20 => 'gem',
    21 => 'fortryd',
    22 => 'slet'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Link Editor',
    2 => '',
    3 => 'Link Titel',
    4 => 'Link URL',
    5 => 'Kategori',
    6 => '(inkluder http://)',
    7 => 'Anden',
    8 => 'Link Hits',
    9 => 'Link Beskrivelse',
    10 => 'Du skal angive Titel, URL og Beskrivelse.',
    11 => 'Link Manager',
    12 => 'For at redigere eller slette et link, klik p� linket herunder. For at oprette et nyt link, klik p� nyt link herover.',
    13 => 'Link Titel',
    14 => 'Link Kategori',
    15 => 'Link URL',
    16 => 'Adgang N�gtet',
    17 => "Du pr�ver at f� adgang til et link, som du ikke har rettigheder til! Dette fors�g er blevet logget. G� tilbage til <a href=\"{$_CONF['site_url']}/admin/event.php\">administrations interfacet</a>.",
    18 => 'Nyt Link',
    19 => 'Admin Hjem',
    20 => 'Hvis Anden, specificer hvilken',
    21 => 'gem',
    22 => 'fortryd',
    23 => 'slet'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Forrige Historier',
    2 => 'N�ste Historier',
    3 => 'M�de',
    4 => 'Postm�de',
    5 => 'Historie Editor',
    6 => 'Der er ingen historier',
    7 => 'Forfatter',
    8 => 'gem',
    9 => 'gennemse',
    10 => 'fortryd',
    11 => 'slet',
    12 => '',
    13 => 'Titel',
    14 => 'Emne',
    15 => 'Dato',
    16 => 'Intro Tekst',
    17 => 'Krop Tekst',
    18 => 'Hits',
    19 => 'Kommentarer',
    20 => '',
    21 => '',
    22 => 'Historie Liste',
    23 => 'For at redigere eller slette en historie, klik p� historiens nummer herunder. For at se en historie, klik p� titlen af den historie du �nsker at se. For at oprette en ny historie, klik p� ny historie herover.',
    24 => '',
    25 => '',
    26 => 'Gennemse Historie',
    27 => '',
    28 => '',
    29 => '',
    30 => 'File Upload Errors',
    31 => 'Udfyld Forfatter, Titel og Intro Tekst felterne',
    32 => 'Fremh�vet',
    33 => 'Der kan kun v�re en fremh�vet historie',
    34 => 'Draft',
    35 => 'Ja',
    36 => 'Nej',
    37 => 'Mere af',
    38 => 'Mere fra',
    39 => 'Emails',
    40 => 'Adgang N�gtet',
    41 => "Du pr�ver at f� adgang til en historie, som du ikke har rettigheder til! Dette fors�g er blevet logget! G� tilbage til <a href=\"{$_CONF['site_url']}/admin/story.php\">administration af historier interfacet</a>.",
    42 => "Du pr�ver at f� adgang til en historie, som du ikke har rettigheder til! Dette fors�g er blevet logget! G� tilbage til <a href=\"{$_CONF['site_url']}/admin/story.php\">administration af historier interfacet</a>.",
    43 => 'Ny Historie',
    44 => 'Admin Hjem',
    45 => 'Access',
    46 => '<b>BEM�RK:</b> Hvis du angiver denne dato til engang i fremtiden, bliver denne historie ikke vist f�r denne dato. Dette inkluderer ogs� at historien ikke medtages i din RDF fil, og bliver samtidig ignoreret af s�gnings og statistik funktionerne.',
    47 => 'Billeder',
    48 => 'billede',
    49 => 'h�jre',
    50 => 'venstre',
    51 => 'To add one of the images you are attaching to this article you need to insert specially formated text.  The specially formated text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your story.<BR><P><B>PREVIEWING</B>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    52 => 'Slet',
    53 => 'blev ikke brugt. Du skal inkludere dette billede i din intro eller krop tekstf�r du kan gemme eventuelle �ndringer',
    54 => 'Vedh�ftede Billeder Blev Ikke Brugt',
    55 => 'F�lgende fejl opstod ved tilf�jelse af din historie. Ret disse f�r gemning',
    56 => 'Vis Emneikon',
    57 => 'View unscaled image'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'M�de',
    2 => 'Indtast et sp�rgsm�l og mindst et svar',
    3 => 'Afstemning Lavet',
    4 => "Afstemning {$qid} gemt",
    5 => 'Rediger Afstemning',
    6 => 'Afstemning ID',
    7 => '(brug ikke mellemrum)',
    8 => 'Vises p� Siden',
    9 => 'Sp�rgsm�l',
    10 => 'Svar/Stemmer',
    11 => "Der er sket en fejl ved hentning af svardata til afstemning {$qid}",
    12 => "Der er sket en fejl ved hentning af sp�rgsm�ldata til afstemning {$qid}",
    13 => 'Lav Afstemning',
    14 => 'gem',
    15 => 'fortryd',
    16 => 'slet',
    17 => 'Indtast afstemnings ID',
    18 => 'Afstemning Liste',
    19 => 'For at redigere eller slette en afstemning, klik p� afstemningen. For at oprette en ny afstemning, klik p� ny afstemning herover.',
    20 => 'Stemmere',
    21 => 'Adgang N�gtet',
    22 => "Du pr�ver at f� adgang til en afstemning, som du ikke har rettigheder til! Dette fors�g er blevet logget! G� tilbage til <a href=\"{$_CONF['site_url']}/admin/poll.php\">afstemnings administrations interfacet</a>.",
    23 => 'Ny Afstemning',
    24 => 'Admin Hjem',
    25 => 'Ja',
    26 => 'Nej'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Emne Redigering',
    2 => 'Emne ID',
    3 => 'Emne Navn',
    4 => 'Emne Billede',
    5 => '(brug ikke mellemrum)',
    6 => 'Sletning af et emne sletter gs� alle historie og kasser associeret med emnet',
    7 => 'Udfyld Emne ID og Emne Navn felterne',
    8 => 'Emne Manager',
    9 => 'For at redigere eller slette et emne, klik p� emnet. For at oprette et nyt emne, klik Nyt Emne knappen herover. Du finder dit adgangsniveau for hvert enkelt emne i paranteser',
    10 => 'Sorteringsr�kkef�lge',
    11 => 'Historier/Sider',
    12 => 'Adgang N�gtet',
    13 => "Du pr�ver at f� adgang til et emne, som du ikke har rettigheder til. Dette fors�g er blevet logget. G� venligst <a href=\"{$_CONF['site_url']}/admin/topic.php\">tilbage til emneredigeringssiden</a>.",
    14 => 'Sorteringsmetode',
    15 => 'alfabetisk',
    16 => 'standard er',
    17 => 'Nyt Emne',
    18 => 'Admin Hjem',
    19 => 'gem',
    20 => 'fortryd',
    21 => 'slet',
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Bruger Editor',
    2 => 'Bruger ID',
    3 => 'Brugernavn',
    4 => 'Fuld Navn',
    5 => 'Password',
    6 => 'Sikkerhedsniveau',
    7 => 'Emailadresse',
    8 => 'Hjemmeside',
    9 => '(brug ikke mellemrum)',
    10 => 'Udfyld Brugernavn, Fuld Navn, Sikkerhedsniveau og Emailadresse felterne',
    11 => 'Bruger Manager',
    12 => 'For at redigere eller slette en bruger, klik p� brugeren herunder. For at oprette en ny bruger, klik p� ny bruger knappen til venstre. Du kan foretage simple s�gninger ved at indtaste dele af et brugernavn, en emailadresse eller det fulde navn (f.eks. *son* or *.edu) i formularen herunder.',
    13 => 'SikNiv',
    14 => 'Registreringsdato',
    15 => 'Ny Bruger',
    16 => 'Admin Hjem',
    17 => 'changepw',
    18 => 'cancel',
    19 => 'slet',
    20 => 'gem',
    21 => 'Brugernavnet eksisterer allerede.',
    22 => 'Fejl',
    23 => 'Batch Add',
    24 => 'Batch Import af Brugere',
    25 => 'You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, username, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!',
    26 => 'S�g',
    27 => 'Resultatbegr�nsning',
    28 => 'Marker her for at slette dette billede',
    29 => 'Sti',
    30 => 'Importer',
    31 => 'Nye Brugere',
    32 => 'Arbejdet er gjort. Importerede $successes og st�dte p� $failures fejl',
    33 => 'tilf�j',
    34 => 'Fejl: Du skal specificere en fil.',
    35 => 'Last Login',
    36 => '(never)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Godkend',
    2 => 'Slet',
    3 => 'Rediger',
    4 => 'Profile',
    10 => 'Titel',
    11 => 'Start Dato',
    12 => 'URL',
    13 => 'Kategori',
    14 => 'Dato',
    15 => 'Emne',
    16 => 'User name',
    17 => 'Full name',
    18 => 'Email',
    34 => 'Kommandocentral',
    35 => 'Historie Tilf�jelser',
    36 => 'Link Tilf�jelser',
    37 => 'Begivenhed Tilf�jelser',
    38 => 'Tilf�j',
    39 => 'Der er ingen tilf�jelser til moderation p� dette tidspunkt',
    40 => 'Bruger Tilf�jelser'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'S�ndag',
    2 => 'Mandag',
    3 => 'Tirsdag',
    4 => 'Onsdag',
    5 => 'Torsdag',
    6 => 'Fredag',
    7 => 'L�rdag',
    8 => 'Tilf�j Begivenhed',
    9 => 'Geeklog Begivenhed',
    10 => 'Begivenheder for',
    11 => 'Overordnet Kalender',
    12 => 'Min Kalender',
    13 => 'Januar',
    14 => 'Februar',
    15 => 'Marts',
    16 => 'April',
    17 => 'Maj',
    18 => 'Juni',
    19 => 'Juli',
    20 => 'August',
    21 => 'September',
    22 => 'Oktober',
    23 => 'November',
    24 => 'December',
    25 => 'Tilbage til ',
    26 => 'Hele Dagen',
    27 => 'Uge',
    28 => 'Personlig Kalender for',
    29 => 'Offentlig Kalender',
    30 => 'slet begivenhed',
    31 => 'Tilf�j',
    32 => 'Begivenhed',
    33 => 'Dato',
    34 => 'Tid',
    35 => 'Tilf�j Hurtig',
    36 => 'Tilf�j',
    37 => 'Desv�rre, den personlige kalenderfunktion er ikke aktiveret p� denne side',
    38 => 'Personlig Begivenhed Editor',
    39 => 'Dag',
    40 => 'Uge',
    41 => 'M�ned'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Email Afsendingsprogram",
    2 => 'Fra',
    3 => 'Svar Til',
    4 => 'Emne',
    5 => 'Krop',
    6 => 'Send Til:',
    7 => 'Alle brugere',
    8 => 'Admin',
    9 => 'Muligheder',
    10 => 'HTML',
    11 => 'Vigtig besked!',
    12 => 'Send',
    13 => 'Reset',
    14 => 'Ignorer bruger indstillinger',
    15 => 'Fejl ved afsendelse til: ',
    16 => 'Besked sendt til: ',
    17 => "<a href={$_CONF['site_url']}/admin/mail.php>Send endnu en besked</a>",
    18 => 'Til',
    19 => 'Bem�rk: Hvis du �nsker at sende en besked til alle sidens oprettede brugere, v�lg da Logged-in Users gruppen fra rullemenuen.',
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href=\"{$_CONF['site_url']}/admin/mail.php\">Send another message</a> or you can <a href=\"{$_CONF['site_url']}/admin/moderation.php\">go back to the administration page</a>.",
    21 => 'Fejl',
    22 => 'Succeser',
    23 => 'Ingen fejl',
    24 => 'Ingen succeser',
    25 => '-- V�lg Gruppe --',
    26 => 'Udfyld venligst alle felterne, og v�lg en brugergruppe fra rullelisten.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href="http://www.geeklog.net" target="_blank">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.',
    2 => 'Plug-in Installation Disclaimer',
    3 => 'Plug-in Installation Form',
    4 => 'Plug-in File',
    5 => 'Plug-in List',
    6 => 'Warning: Plug-in Already Installed!',
    7 => 'The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it',
    8 => 'Plugin Compatibility Check Failed',
    9 => 'This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href="http://www.geeklog.net">Geeklog</a> or get a newer version of the plug-in.',
    10 => '<br><b>There are no plugins currently installed.</b><br><br>',
    11 => 'To modify or delete a plug-in, click on that plug-in\'s number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in\'s website. To install or upgrade a plug-in please consult it\'s documentation.',
    12 => 'no plugin name provided to plugineditor()',
    13 => 'Plugin Editor',
    14 => 'New Plug-in',
    15 => 'Admin Home',
    16 => 'Plug-in Name',
    17 => 'Plug-in Version',
    18 => 'Geeklog Version',
    19 => 'Enabled',
    20 => 'Yes',
    21 => 'No',
    22 => 'Install',
    23 => 'Save',
    24 => 'Cancel',
    25 => 'Delete',
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
    2 => 'save',
    3 => 'delete',
    4 => 'cancel',
    10 => 'Content Syndication',
    11 => 'New Feed',
    12 => 'Admin Home',
    13 => 'To modify or delete a feed, click on the feed\'s title below. To create a new feed, click on New Feed above.',
    14 => 'Title',
    15 => 'Type',
    16 => 'Filename',
    17 => 'Format',
    18 => 'last updated',
    19 => 'Enabled',
    20 => 'Yes',
    21 => 'No',
    22 => '<i>(no feeds)</i>',
    23 => 'all Stories',
    24 => 'Feed Editor',
    25 => 'Feed Title',
    26 => 'Limit',
    27 => 'Length of entries',
    28 => '(0 = no text, 1 = full text, other = limit to that number of chars.)',
    29 => 'Description',
    30 => 'Last Update',
    31 => 'Character Set',
    32 => 'Language',
    33 => 'Contents',
    34 => 'Entries',
    35 => 'Hours',
    36 => 'Select type of feed',
    37 => 'You have at least one plugin installed that supports content syndication. Below you will need to select whether you want to create a Geeklog feed or a feed from one of the plugins.',
    38 => 'Error: Missing Fields',
    39 => 'Please fill in the Feed Title, Description, and Filename.',
    40 => 'Please enter a  number of entries or number of hours.',
    41 => 'Links',
    42 => 'Events'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => 'Dit password er sendt til dig, og skulle snart dukke op. F�lg venligst instruktionerne i emailen',
    2 => "Tak for tilf�jelsen til {$_CONF['site_name']}. Tilf�jelsen venter p� godkendelse. Hvis din tilf�jelse bliver godkendt, bliver din historie tilg�ngelig for alle andre brugere af hjemmesiden.",
    3 => "Tak for tilf�jelsen af et link til {$_CONF['site_name']}. Tilf�jelsen venter p� godkendelse. Hvis dit link bliver godkendt, bliver linket vist p� <a href={$_CONF['site_url']}/links.php>links</a> siden.",
    4 => "Tak for tilf�jelsen af en begivenhed til {$_CONF['site_name']}. Tilf�jelsen venter p� godkendelse. Hvis din begivenhed bliver godkendt, bliver begivenheden vist p� <a href={$_CONF['site_url']}/calendar.php>kalender</a> siden.",
    5 => 'Din kontoinformation er gemt.',
    6 => 'Dine visningspr�ferencer er gemt.',
    7 => 'Dine kommentarpr�ferencer er gemt.',
    8 => 'Du er logget ud fra systemet.',
    9 => 'Din historietilf�jelse er gemt.',
    10 => 'Historien er slettet fra systemet.',
    11 => 'Din kasse er blevet gemt.',
    12 => 'Kassen er blevet slettet.',
    13 => 'Dit emne er blevet gemt.',
    14 => 'Emnet og alle dets relaterede historier og kasser er blevet slettet.',
    15 => 'Dit link er blevet gemt.',
    16 => 'Linket er blevet slettet.',
    17 => 'Din begivenhed er gemt.',
    18 => 'Begivenheden er slettet.',
    19 => 'Din afstemning er blevet gemt.',
    20 => 'Afstemningen er slettet.',
    21 => 'Den nye bruger er blevet oprettet.',
    22 => 'Brugeren er blevet slettet',
    23 => 'Fejl ved tilf�jelse af en begivenhed til din personlige kalender. Der blev ikke tilf�jet et ID.',
    24 => 'Begivenheden er gemt i din kalender',
    25 => 'Kan ikke �bne din personlige kalender f�rend du er logget ind',
    26 => 'Begivenheden blev slettet fra din personlige kalender',
    27 => 'Beskeden er sendt.',
    28 => 'Denne plugin er blevet gemt',
    29 => 'Desv�rre, den personlige kalender er ikke implementeret p� denne side',
    30 => 'Adgang N�gtet',
    31 => 'Desv�rre, du har ikke adgang til siden for administration af historier. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
    32 => 'Desv�rre, du har ikke adgang til siden for administration af emner. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
    33 => 'Desv�rre, du har ikke adgang til siden for administration af kasser. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
    34 => 'Desv�rre, du har ikke adgang til siden for administration af links. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
    35 => 'Desv�rre, du har ikke adgang til siden for administration af begivenheder. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
    36 => 'Desv�rre, du har ikke adgang til siden for administration af afstemninger. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
    37 => 'Desv�rre, du har ikke adgang til siden for administration af brugere. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
    38 => 'Desv�rre, du har ikke adgang til siden for administration af plugins. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
    39 => 'Desv�rre, du har ikke adgang til siden for administration af emails. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
    40 => 'System Besked',
    41 => 'Sorry, you do not have access to the word replacement page.  Please note that all attempts to access unauthorized features are logged',
    42 => 'Dit ord er gemt.',
    43 => 'Ordet er blevet slettet.',
    44 => 'Denne plugin blev installeret!',
    45 => 'Denne plugin er blevet slettet.',
    46 => 'Desv�rre, du har ikke adgang til siden for backup af databasen. Bem�rk at alle fors�g p� at f� tilgang til administrationssider bliver logget',
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
    'access' => 'Adgang',
    'ownerroot' => 'Ejer/Root',
    'group' => 'Gruppe',
    'readonly' => 'Read-Only',
    'accessrights' => 'Adgangsrettigheder',
    'owner' => 'Ejer',
    'grantgrouplabel' => 'Giv overst�ende Gruppe �ndrings rettigheder',
    'permmsg' => 'NOTE: Medlemmer er alle sammen logget ind p� siden. Anonyme er alle de brugere som ikke er logget ind p� siden.',
    'securitygroups' => 'Sikkerheds grupper',
    'editrootmsg' => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF['site_admin_url']}/user.php\">User Administration page</a>.",
    'securitygroupsmsg' => 'Select the checkboxes for the groups you want the user to belong to.',
    'groupeditor' => 'Gruppe editor',
    'description' => 'Beskrivelse',
    'name' => 'Navn',
    'rights' => 'Rettigheder',
    'missingfields' => 'Manglende felter',
    'missingfieldsmsg' => 'Du skal tilf�je navn og beskrivelse for en gruppe',
    'groupmanager' => 'Gruppe manager',
    'newgroupmsg' => 'To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used in the system.',
    'groupname' => 'Gruppe navn',
    'coregroup' => 'Core gruppe',
    'yes' => 'Ja',
    'no' => 'Nej',
    'corerightsdescr' => "This group is a core {$_CONF['site_name']} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
    'groupmsg' => 'Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called \'Rights\'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.',
    'coregroupmsg' => "This group is a core {$_CONF['site_name']} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
    'rightsdescr' => 'A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.',
    'lock' => 'L�s',
    'members' => 'Medlemmer',
    'anonymous' => 'Anonyme',
    'permissions' => 'Rettigheder',
    'permissionskey' => 'R = l�s, E = �ndre, �ndre rettigheder fordre l�se rettigheder',
    'edit' => '�ndre',
    'none' => 'Igrn',
    'accessdenied' => 'Adgang n�gtet',
    'storydenialmsg' => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'eventdenialmsg' => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
    'nogroupsforcoregroup' => 'This group doesn\'t belong to any of the other groups',
    'grouphasnorights' => 'This group doesn\'t have access to any of the administrative features of this site',
    'newgroup' => 'Ny gruppe',
    'adminhome' => 'Admin Home',
    'save' => 'gem',
    'cancel' => 'annuller',
    'delete' => 'slet',
    'canteditroot' => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error',
    'listusers' => 'List Users',
    'listthem' => 'list',
    'usersingroup' => 'Users in group "%s"',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Add',
    'remove' => 'Remove',
    'availmembers' => 'Available Members',
    'groupmembers' => 'Group Members',
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Sidste 10 Backups',
    'do_backup' => 'Backup',
    'backup_successful' => 'Backup af databasen skete med succes.',
    'no_backups' => 'Der er ingen backups i systemet',
    'db_explanation' => 'For at lave en ny backup af dit Geeklog system, skal du klikke p� knappen herunder',
    'not_found' => "Forkert sti eller ogs� er mysqldump v�rkt�jet ikke eksekverbar.<br>Tjek <strong>\$_DB_mysqldump_path</strong> definitionen i filen config.php.<br>Variablen er pt. defineret som: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Mislykkedes: Filest�rrelsen var p� 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} findes ikke, eller er ikke et bibliotek",
    'no_access' => "FEJL: biblioteket {$_CONF['backup_path']} er ikke tilg�ngeligt.",
    'backup_file' => 'Backup fil',
    'size' => 'St�rrelse',
    'bytes' => 'Bytes',
    'total_number' => 'Total number of backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Hjem',
    2 => 'Kontakt',
    3 => 'Tilf�j',
    4 => 'Links',
    5 => 'Afstemninger',
    6 => 'Kalender',
    7 => 'Sidestatistik',
    8 => 'Personificer',
    9 => 'S�g',
    10 => 'avanceret s�gning'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Fejl',
    2 => 'Hmmm, jeg har ledt s�vel oppe som nede for at finde filen <b>%s</b>.',
    3 => "<p>Desv�rre, men filen du eftersp�rger findes ikke. Du er velkommen til selv at lede via <a href=\"{$_CONF['site_url']}\">forsiden</a> eller <a href=\"{$_CONF['site_url']}/search.php\">s�gesiden</a> for at se om du d�r kan finde det du s�ger."
);

###############################################################################

$LANG_LOGIN = array(
    1 => 'Log ind n�dvendig',
    2 => 'Desv�rre, for at f� adgang til dette omr�de, skal du v�re logget ind som bruger p� siden.',
    3 => 'Log ind',
    4 => 'Ny Bruger'
);

?>
