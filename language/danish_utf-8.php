<?php

###############################################################################
# danish.php
# This is the danish language page for GeekLog!
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
    1 => 'Tilføjet af:',
    2 => 'læs mere',
    3 => 'kommentarer',
    4 => 'Rediger',
    5 => 'Stem',
    6 => 'Resultater',
    7 => 'Afstemningsresultater',
    8 => 'stemmer',
    9 => 'Adminfuntioner:',
    10 => 'Tilføjelser',
    11 => 'Historier',
    12 => 'Kasser',
    13 => 'Emner',
    14 => 'Links',
    15 => 'Begivenheder',
    16 => 'Afstemninger',
    17 => 'Brugere',
    18 => 'SQL Forespørgsel',
    19 => 'Log ud',
    20 => 'Brugerinformation:',
    21 => 'Brugernavn',
    22 => 'Bruger ID',
    23 => 'Sikkerhedsniveau',
    24 => 'Anonym',
    25 => 'Svar',
    26 => 'Følgende kommentarer ejes af de/den, som har tilføjet dem. Hjemmesiden er ikke ansvarlig for hvad de/den har skrevet/sagt.',
    27 => 'Seneste tilføjelse',
    28 => 'Slet',
    29 => 'Der er ingen kommentarer',
    30 => 'Ældre Historier',
    31 => 'Tilladte HTML Tags:',
    32 => 'Fejl, ugyldigt brugernavn',
    33 => 'Fejl, kunne ikke skrive til logfilen',
    34 => 'Fejl',
    35 => 'Log ud',
    36 => 'den',
    37 => 'Ingen bruger historier',
    38 => 'Content Syndication',
    39 => 'Genindlæs',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Gæster',
    42 => 'Forfattet af:',
    43 => 'Svar på dette',
    44 => 'Top',
    45 => 'MySQL Fejl Nummer',
    46 => 'MySQL Fejl Besked',
    47 => 'Brugerfunktioner',
    48 => 'Kontoinformation',
    49 => 'Visningspræferencer',
    50 => 'Fejl på SQL statement',
    51 => 'hjælp',
    52 => 'Ny',
    53 => 'Admin Hjem',
    54 => 'Kunne ikke åbne filen.',
    55 => 'Fejl på',
    56 => 'Stem',
    57 => 'Password',
    58 => 'Log ind',
    59 => "Har du endnu ikke en konto? Opret en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Ny Brugerkonto</a>",
    60 => 'Tilføj en kommentar',
    61 => 'Opret en Ny Konto',
    62 => 'ord',
    63 => 'Kommentarpræferencer',
    64 => 'Send Artiklen Til en Ven',
    65 => 'Se Printervenlig Version',
    66 => 'Min Kalender',
    67 => 'Velkommen til ',
    68 => 'hjem',
    69 => 'kontakt',
    70 => 'søg',
    71 => 'tilføj',
    72 => 'links',
    73 => 'tidligere afstemninger',
    74 => 'kalender',
    75 => 'avanceret søgning',
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
    91 => 'Genererede siden på',
    92 => 'sekunder',
    93 => 'Copyright',
    94 => 'Alle trademarks og copyrights på hjemmesiden tilhører de respektive ejere.',
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
    108 => 'Slet Cache',
    109 => 'Report abuse',
    110 => 'Report this post to the site admin',
    111 => 'View PDF Version',
    112 => 'Registered Users',
    113 => 'Documentation',
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
    1 => 'Tilføj en Kommentar',
    2 => 'Tilføjelsesmåde',
    3 => 'Log ud',
    4 => 'Lav en Konto',
    5 => 'Brugernavn',
    6 => 'Hjemmesiden kræver, at du er logget ind, for at kunne tilføje en kommentar. Log venligst ind! Hvis du endnu ikke har oprettet en konto, kan du anvende nedenstående form til at oprette én.',
    7 => 'Din sidste kommentar var ',
    8 => " sekunder siden. Hjemmesiden kræver mindst {$_CONF['commentspeedlimit']} sekunder mellem kommentarer",
    9 => 'Kommentar',
    10 => 'Send Report',
    11 => 'Tilføj Kommentar',
    12 => 'Udfyld Titel og Kommentarfelterne, da de er obligatoriske ved tilføjelse af en kommentar.',
    13 => 'Din Information',
    14 => 'Gennemse',
    15 => 'Report this post',
    16 => 'Titel',
    17 => 'Fejl',
    18 => 'Vigtigt',
    19 => 'Hold venligst kommentaren indenfor det aktuelle emne.',
    20 => 'Svar på andres kommentarer istedet for at oprette nye diskussioner.',
    21 => 'Læs øvrige kommentarer før du svarer, for at undgå at gentage hvad andre allerede har sagt.',
    22 => 'Brug en tydelig Titel, så det skinner igennem hvilket emne din kommentar omhandler.',
    23 => 'Din emailadresse bliver IKKE offentliggjort.',
    24 => 'Anonym Bruger',
    25 => 'Are you sure you want to report this post to the site admin?',
    26 => '%s reported the following abusive comment post:',
    27 => 'Abuse report'
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
    8 => 'PGP Nøgle',
    9 => 'Gem Information',
    10 => 'Sidste 10 kommentarer af bruger',
    11 => 'Ingen Brugerkommentarer',
    12 => 'Brugerpræferencer for',
    13 => 'Send Natligt Udtræk via Email',
    14 => 'Dette password er tilfældigt genereret. Du anbefales at ændre passwordet omgående. For at ændre dit password, skal du logge ind på vejlerWEBben og klikke på kontoinformation i brugerkassen.',
    15 => "Din {$_CONF['site_name']} konto er oprettet. For at kunne bruge den, skal du logge ind med nedenstående oplysninger. Gem denne email for fremtidig reference.",
    16 => 'Din Konto Information',
    17 => 'Kontoen eksisterer ikke',
    18 => 'Den angivne emailadresse synes at være ugyldig',
    19 => 'Det angivne brugernavn eller emailadressen eksisterer allerede',
    20 => 'Den angivne emailadresse synes at være ugyldig',
    21 => 'Fejl',
    22 => "Opret konto på {$_CONF['site_name']}!",
    23 => "Oprettelse af en konto på {$_CONF['site_name']} vil give dig mulighed for at tilføje kommentarer og nyheder/historier i dit eget navn. Hvis du ikke har en konto, vil du kun kunne deltage på hjemmesiden som Anonym. Den emailadresse du opgiver vil <b><i>aldrig</i></b> blive offentliggjort på denne side.",
    24 => 'Dit password bliver sendt til den emailadresse du angiver.',
    25 => 'Glemt Dit Password?',
    26 => 'Indtast dit brugernavn og klik på Email Password, og et nyt password bliver sendt til den emailadresse du har angivet.',
    27 => 'Opret Konto!',
    28 => 'Email Password',
    29 => 'logget ud fra',
    30 => 'logget ind fra',
    31 => 'Denne funktion kræver at du er logget ind',
    32 => 'Signatur',
    33 => 'Bliver aldrig vist offentligt',
    34 => 'Dit rigtige navn',
    35 => 'Indtast password for at ændre det nuværende',
    36 => 'Begynder med http://',
    37 => 'Bliver tilføjet dine kommentarer',
    38 => 'Alt om dig! Alle kan læse dette',
    39 => 'Din offentlige PGP nøgle',
    40 => 'Ingen Ikoner ved Emner',
    41 => 'Willing to Moderate',
    42 => 'Datoformat',
    43 => 'Maksimum Antal Historier',
    44 => 'Ingen kasser',
    45 => 'Visningspræferencer for',
    46 => 'Ekskluderede Emner og Forfattere for',
    47 => 'Kassekonfiguration for',
    48 => 'Emner',
    49 => 'Ingen ikoner i historier',
    50 => 'Afmarker denne hvis du ikke er interesseret',
    51 => 'Kun nyheder og historier',
    52 => 'Standard er 10',
    53 => 'Modtag dagens historier hver nat',
    54 => 'Marker de emner og forfattere du ikke ønsker at se noget fra.',
    55 => 'Hvis du lader disse være umarkerede, betyder det at du ser standardvalget af emner/forfattere. Hvis du begynder at markere nogen af disse, skal du markere alle dem du ønsker at se, fordi standardvalget i så fald bliver ignoreret. Standardvalg vises med <b>fed</b> skrift.',
    56 => 'Forfattere',
    57 => 'Visningsmåde',
    58 => 'Sorteringsrækkefølge',
    59 => 'Kommentarbegrænsning',
    60 => 'Hvordan vil du have kommmentarer vist på siden?',
    61 => 'Nyeste eller ældste først?',
    62 => 'Standard er 100',
    63 => 'Dit password er blevet sendt, og skulle snart dukke op på din emailadresse. Følg instruktionerne i den modtagne besked',
    64 => 'Kommentarpræferencer for',
    65 => 'Prøv at logge ind igen',
    66 => "Du kan have fejlindtastet dine brugeroplysninger. Prøv at logge ind igen herunder. Er du en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">ny bruger</a>?",
    67 => 'Oprettet siden',
    68 => 'Husk mig i',
    69 => 'Hvor længe skal dine oplysninger huskes efter at du er logget ind?',
    70 => "Konfigurer udseendet og layoutet på {$_CONF['site_name']}",
    71 => "En af mulighederne på {$_CONF['site_name']} er at du kan konfigurere indhold, udseende og layout på siden. For at bruge disse funktioner, skal du først <a href=\"{$_CONF['site_url']}/users.php?mode=new\">oprette en konto</a> på {$_CONF['site_name']}. Hvis du allerede er oprettet, kan du anvende loginformen til venstre!",
    72 => 'Tema',
    73 => 'Sprog',
    74 => 'Ændre denne sides udseende!',
    75 => 'Emailede Emner for',
    76 => 'Hvis du vælger et eller flere emner fra listen herunder, vil du modtage alle nye historier under det enkelte emne ved dagens afslutning. Vælg de emner som interesserer dig!',
    77 => 'Foto',
    78 => 'Tilføj et vellignende foto af dig selv!',
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
    91 => 'Ændre password',
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
    105 => 'Vis i Hvem er online blokken',
    106 => 'Location',
    107 => 'Shown in your public profile',
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
    1 => 'Der er ingen nyheder at vise',
    2 => 'Der er ingen nyheder i databasen. Enten er der ikke nogen nyheder tilføjet dette emne, eller også er dine brugerpræferencer muligvis for restriktive.',
    3 => 'for emnet %s',
    4 => 'Mest spændende lige nu',
    5 => 'Næste',
    6 => 'Forrige',
    7 => 'First',
    8 => 'Last'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Der opstod en fejl under afsendelse af din besked. Prøv igen.',
    2 => 'Beskeden blev sendt.',
    3 => 'Vær opmærksom på at du angiver en gyldig emailadresse i Svar Til feltet.',
    4 => 'Udfyld Dit Navn, Svar Til, Emne og Besked felterne',
    5 => 'Fejl: En sådan bruger eksisterer ikke.',
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
    23 => "Denne email er sendt til dig fra %s (%s), fordi vedkommende mener at du måtte være interesseret i denne nyhed/historie fra {$_CONF['site_url']}. Dette er ikke SPAM (reklameemail), og emailadresserne involveret i denne transaktion blev ikke gemt til senere brug.",
    24 => 'Kommenter denne historie på',
    25 => 'Du skal være logget ind for at kunne anvende denne mulighed. Ved at du logger ind, hjælper det os til at undgå misbrug af systemet',
    26 => 'Denne formular lader dig afsende en email til den valgte bruger. Alle felter skal udfyldes.',
    27 => 'Kort besked',
    28 => '%s skrev: ',
    29 => "Dette er den daglige dosis fra {$_CONF['site_name']} for ",
    30 => ' Daglig Dosis for ',
    31 => 'Titel',
    32 => 'Dato',
    33 => 'Læs den fulde historie på',
    34 => 'Slutning af Besked',
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Avanceret Søgning',
    2 => 'Nøgleord',
    3 => 'Emne',
    4 => 'Alle',
    5 => 'Type',
    6 => 'Historier',
    7 => 'Kommentarer',
    8 => 'Forfattere',
    9 => 'Alle',
    10 => 'Søg',
    11 => 'Søgeresultater',
    12 => 'resultater',
    13 => 'Søgeresultat: Der var ingen resultat',
    14 => 'Der var ingen resultat for din søgning på',
    15 => 'Prøv igen.',
    16 => 'Titel',
    17 => 'Dato',
    18 => 'Forfatter',
    19 => "Søg hele {$_CONF['site_name']} databasen af nuværende og gamle historier.",
    20 => 'Dato',
    21 => 'til',
    22 => '(Datoformat MM-DD-YYYY)',
    23 => 'Hits',
    24 => 'Fandt',
    25 => 'resultater i',
    26 => 'muligheder på',
    27 => 'sekunder',
    28 => 'Ingen resultater for historier eller kommentarer på din søgning',
    29 => 'Historie og Kommentar resultater',
    30 => 'Ingen links passede på din søgning',
    31 => 'Denne plugin returnerede ingen resultater',
    32 => 'Begivenhed',
    33 => 'URL',
    34 => 'Sted',
    35 => 'Hele dagen',
    36 => 'Ingen begivenheder passede på din søgning',
    37 => 'Begivenhed Resultater',
    38 => 'Link Resultater',
    39 => 'Links',
    40 => 'Begivenheder',
    41 => 'Din forespørgsel burde indeholde mindst 3 tegn.',
    42 => 'Anvend venligst et datoformat som YYYY-MM-DD (år-måned-dag).',
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
    57 => 'OR',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
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
    10 => 'Der er ikke nogle historie på dette site eller også er der ingen, som har set dem.',
    11 => 'Top 10 Kommenterede Historier',
    12 => 'Kommentarer',
    13 => 'Der er ikke nogle historier på dette site eller også er der ikke nogen, der har lavet en kommentar.',
    14 => 'Top 10 Afstemninger',
    15 => 'Spørgsmål',
    16 => 'Stemmer',
    17 => 'Der er ikke nogen afstemninger eller også er der ikke nogen, der har stemt..',
    18 => 'Top 10 Links',
    19 => 'Links',
    20 => 'Hits',
    21 => 'Der er ikke nogen links på dette site eller også er der ikke, som har klikket på et.',
    22 => 'Top 10 Emailede Historier',
    23 => 'Emails',
    24 => 'Der er ikke nogen, der har emailet en historie',
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
    1 => 'Relateret',
    2 => 'Send',
    3 => 'Print',
    4 => 'Muligheder',
    5 => 'PDF Story Format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'For at tilføje en %s skal du være logget ind.',
    2 => 'Log ind',
    3 => 'Ny Bruger',
    4 => 'Tilføj en Begivenhed',
    5 => 'Tilføj et Link',
    6 => 'Tilføj en Historie',
    7 => 'Log ind Krævet',
    8 => 'Tilføj',
    9 => 'Når du tilføjer information til brug på denne hjemmeside, anmoder vi dig om at følge disse retningslinier...<ul><li>Udfyld alle felter, det er påkrævet<li>Bidrag med nøjagtig viden og information<li>Dobbelttjek alle hjemmesideadresser (URLs)</ul>',
    10 => 'Titel',
    11 => 'Link',
    12 => 'Start Dato',
    13 => 'Slut Dato',
    14 => 'Sted',
    15 => 'Beskrivelse',
    16 => 'Hvis anden, angiv hvilken',
    17 => 'Kategori',
    18 => 'Anden',
    19 => 'Læs Først',
    20 => 'Fejl: Manglende Kategori',
    21 => 'Ved valg af "Anden" angiv da venligst et kategorinavn',
    22 => 'Fejl: Manglende Felter',
    23 => 'Udfyld alle felter i formularen. De er alle påkrævet.',
    24 => 'Tilføjelsen er Gemt',
    25 => 'Din %s tilføjelse er gemt.',
    26 => 'Fartbegrænsning',
    27 => 'Brugernavn',
    28 => 'Emne',
    29 => 'Historie',
    30 => 'Din sidste tilføjelse var ',
    31 => " sekunder siden. Siden kræver som minimum {$_CONF['speedlimit']} sekunder mellem tilføjelser",
    32 => 'Gennemse',
    33 => 'Gennemse Historie',
    34 => 'Log Ud',
    35 => 'HTML er ikke tilladt',
    36 => 'Postmåde',
    37 => "Når du tilføjer en begivenhed til {$_CONF['site_name']} bliver den automatisk tilføjet den overordnede kalender, hvorefter alle brugere kan tilføje din begivenhed til deres personlige kalender. Denne mulighed er <b>IKKE</b> tænkt som stedet hvor du skal tilføje fødselsdage og andre personlige begivenheder.<br><br>Når du har tilføjet begivenheden, bliver den tilsendt en af vore administratorer, og hvis den derefter bliver godkendt, dukker den op i den overordnede kalender.",
    38 => 'Tilføj Begivenhed Til',
    39 => 'Overordnet Kalender',
    40 => 'Personlig Kalender',
    41 => 'Sluttid',
    42 => 'Starttid',
    43 => 'Hele Dagen',
    44 => 'Adresse Linie 1',
    45 => 'Adresse Linie 2',
    46 => 'By',
    47 => 'Område',
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
    1 => 'Autorisation Påkrævet',
    2 => 'Adgang Nægtet! Forkert Log ind Information',
    3 => 'Ugyldig password for bruger',
    4 => 'Brugernavn:',
    5 => 'Password:',
    6 => 'Al adgang til administrative afdelinger af denne hjemmeside bliver logget og gennemset.<br>Denne side er kun til brug for autoriseret personale.',
    7 => 'log ind'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Utilstrækkelige Admin Rettigheder',
    2 => 'Du har ikke tilstrækkelige rettigheder til at kunne redigere denne kasse.',
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
    25 => 'For at redigere eller slette en kasse, klik på kassen herunder. For at tilføje en ny kasse, klik på ny kasse herover.',
    26 => 'Layout Kasse',
    27 => 'PHP Kasse',
    28 => 'PHP Kasse Muligheder',
    29 => 'Kasse Funktioner',
    30 => 'Hvis du vil anvende PHP i en af dine kasser, skal du angive navnet på funktionen herover. Navnet på din funktion skal starte med "phpblock_" (f.eks. phpblock_getweather). Hvis funktionen ikke starter med dette, vil funktionen ikke blive fundet. Vi anvender dette for at undgå, at eventuelle hackere af din hjemmeside, kan anvende harmfulde kald til funktioner, som vil være skadelige for dit system. Anvend IKKE tomme parantser "()" efter funktionsnavnet. Endelig er det anbefalelsesværdigt at du putter al din PHP kode i /path/to/geeklog/system/lib-custom.php. Dette tillader din kode at blive gemt og anvendt selvom du opgraderer til en nyere version af GeekLog.',
    31 => 'Fejl i PHP kasse. Funktionen, , findes ikke.',
    32 => 'Fejl, Manglende Felt(er)',
    33 => 'Du skal indtaste URL adressen til .rdf filen for portal kasser',
    34 => 'Du skal udfylde felterne titel og funtion for PHP kasser',
    35 => 'Du skal udfylde felterne titel og indhold for normale kasser',
    36 => 'Du skal udfylde feltet indhold for layout kasser',
    37 => 'Dårligt PHP kasse funktionsnavn',
    38 => 'Funktioner for PHP kasser skal starte med \'phpblock_\' (f.eks. phpblock_getweather). \'phpblock_\' angivelsen er påkrævet af sikkerhedsmæssige årsager for at undgå anvendelse af harmfuld kode.',
    39 => 'Side',
    40 => 'Venstre',
    41 => 'Højre',
    42 => 'Du skal angive kasserækkefølge og sikkerhedsniveau for standard GeekLog kasser',
    43 => 'Kun På Hjemmeside',
    44 => 'Adgang Nægtet',
    45 => "Du forsøger at få adgang til en kasse, som du ikke har rettigheder til. Dette forsøg er blevet skrevet til loggen. Gå venligst <a href=\"{$_CONF['site_url']}/admin/block.php\">tilbage til kasseadministrationssiden</a> - tak.",
    46 => 'Ny Kasse',
    47 => 'Admin Hjem',
    48 => 'Kasse Navn',
    49 => ' (ingen mellemrum og skal være unik)',
    50 => 'Hjælpefil URL',
    51 => 'inkluder http://',
    52 => 'Hvis du efterlader dette felt tomt, vil hjælpeikonet for denne kasse ikke vises',
    53 => 'Slået til',
    54 => 'gem',
    55 => 'fortryd',
    56 => 'slet',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side',
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
    1 => 'Forrige Historier',
    2 => 'Næste Historier',
    3 => 'Måde',
    4 => 'Postmåde',
    5 => 'Historie Editor',
    6 => 'Der er ingen historier',
    7 => 'Forfatter',
    8 => 'gem',
    9 => 'gennemse',
    10 => 'fortryd',
    11 => 'slet',
    12 => 'ID',
    13 => 'Titel',
    14 => 'Emne',
    15 => 'Dato',
    16 => 'Intro Tekst',
    17 => 'Krop Tekst',
    18 => 'Hits',
    19 => 'Kommentarer',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Historie Liste',
    23 => 'For at redigere eller slette en historie, klik på historiens nummer herunder. For at se en historie, klik på titlen af den historie du ønsker at se. For at oprette en ny historie, klik på ny historie herover.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Gennemse Historie',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'File Upload Errors',
    31 => 'Udfyld Forfatter, Titel og Intro Tekst felterne',
    32 => 'Fremhævet',
    33 => 'Der kan kun være en fremhævet historie',
    34 => 'Draft',
    35 => 'Ja',
    36 => 'Nej',
    37 => 'Mere af',
    38 => 'Mere fra',
    39 => 'Emails',
    40 => 'Adgang Nægtet',
    41 => "Du prøver at få adgang til en historie, som du ikke har rettigheder til! Dette forsøg er blevet logget! Gå tilbage til <a href=\"{$_CONF['site_url']}/admin/story.php\">administration af historier interfacet</a>.",
    42 => "Du prøver at få adgang til en historie, som du ikke har rettigheder til! Dette forsøg er blevet logget! Gå tilbage til <a href=\"{$_CONF['site_url']}/admin/story.php\">administration af historier interfacet</a>.",
    43 => 'Ny Historie',
    44 => 'Admin Hjem',
    45 => 'Access',
    46 => '<b>BEMÆRK:</b> Hvis du angiver denne dato til engang i fremtiden, bliver denne historie ikke vist før denne dato. Dette inkluderer også at historien ikke medtages i din RDF fil, og bliver samtidig ignoreret af søgnings og statistik funktionerne.',
    47 => 'Billeder',
    48 => 'billede',
    49 => 'højre',
    50 => 'venstre',
    51 => 'To add one of the images you are attaching to this article you need to insert specially formated text.  The specially formated text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your story.<BR><P><B>PREVIEWING</B>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    52 => 'Slet',
    53 => 'blev ikke brugt. Du skal inkludere dette billede i din intro eller krop tekstfør du kan gemme eventuelle ændringer',
    54 => 'Vedhæftede Billeder Blev Ikke Brugt',
    55 => 'Følgende fejl opstod ved tilføjelse af din historie. Ret disse før gemning',
    56 => 'Vis Emneikon',
    57 => 'View unscaled image',
    58 => 'Story Management',
    59 => 'Option',
    60 => 'Enabled',
    61 => 'Auto Archive',
    62 => 'Auto Delete',
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
    1 => 'Emne Redigering',
    2 => 'Emne ID',
    3 => 'Emne Navn',
    4 => 'Emne Billede',
    5 => '(brug ikke mellemrum)',
    6 => 'Sletning af et emne sletter gså alle historie og kasser associeret med emnet',
    7 => 'Udfyld Emne ID og Emne Navn felterne',
    8 => 'Emne Manager',
    9 => 'For at redigere eller slette et emne, klik på emnet. For at oprette et nyt emne, klik Nyt Emne knappen herover. Du finder dit adgangsniveau for hvert enkelt emne i paranteser',
    10 => 'Sorteringsrækkefølge',
    11 => 'Historier/Sider',
    12 => 'Adgang Nægtet',
    13 => "Du prøver at få adgang til et emne, som du ikke har rettigheder til. Dette forsøg er blevet logget. Gå venligst <a href=\"{$_CONF['site_url']}/admin/topic.php\">tilbage til emneredigeringssiden</a>.",
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
    24 => '(*)',
    25 => 'Archive Topic',
    26 => 'make this the default topic for archived stories. Only one topic allowed.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
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
    12 => 'For at redigere eller slette en bruger, klik på brugeren herunder. For at oprette en ny bruger, klik på ny bruger knappen til venstre. Du kan foretage simple søgninger ved at indtaste dele af et brugernavn, en emailadresse eller det fulde navn (f.eks. *son* or *.edu) i formularen herunder.',
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
    26 => 'Søg',
    27 => 'Resultatbegrænsning',
    28 => 'Marker her for at slette dette billede',
    29 => 'Sti',
    30 => 'Importer',
    31 => 'Nye Brugere',
    32 => 'Arbejdet er gjort. Importerede %d og stødte på %d fejl',
    33 => 'tilføj',
    34 => 'Fejl: Du skal specificere en fil.',
    35 => 'Last Login',
    36 => '(never)',
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
    35 => 'Historie Tilføjelser',
    36 => 'Link Tilføjelser',
    37 => 'Begivenhed Tilføjelser',
    38 => 'Tilføj',
    39 => 'Der er ingen tilføjelser til moderation på dette tidspunkt',
    40 => 'Bruger Tilføjelser'
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
    19 => 'Bemærk: Hvis du ønsker at sende en besked til alle sidens oprettede brugere, vælg da Logged-in Users gruppen fra rullemenuen.',
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href=\"{$_CONF['site_url']}/admin/mail.php\">Send another message</a> or you can <a href=\"{$_CONF['site_url']}/admin/moderation.php\">go back to the administration page</a>.",
    21 => 'Fejl',
    22 => 'Succeser',
    23 => 'Ingen fejl',
    24 => 'Ingen succeser',
    25 => '-- Vælg Gruppe --',
    26 => 'Udfyld venligst alle felterne, og vælg en brugergruppe fra rullelisten.'
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
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.',
    32 => '<p><b>Error AutoLink tag not correct format</b></p>',
    33 => 'Code Version',
    34 => 'Update',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
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
    42 => 'Events',
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
    1 => 'Dit password er sendt til dig, og skulle snart dukke op. Følg venligst instruktionerne i emailen',
    2 => "Tak for tilføjelsen til {$_CONF['site_name']}. Tilføjelsen venter på godkendelse. Hvis din tilføjelse bliver godkendt, bliver din historie tilgængelig for alle andre brugere af hjemmesiden.",
    3 => "Tak for tilføjelsen af et link til {$_CONF['site_name']}. Tilføjelsen venter på godkendelse. Hvis dit link bliver godkendt, bliver linket vist på <a href={$_CONF['site_url']}/links.php>links</a> siden.",
    4 => "Tak for tilføjelsen af en begivenhed til {$_CONF['site_name']}. Tilføjelsen venter på godkendelse. Hvis din begivenhed bliver godkendt, bliver begivenheden vist på <a href={$_CONF['site_url']}/calendar.php>kalender</a> siden.",
    5 => 'Din kontoinformation er gemt.',
    6 => 'Dine visningspræferencer er gemt.',
    7 => 'Dine kommentarpræferencer er gemt.',
    8 => 'Du er logget ud fra systemet.',
    9 => 'Din historietilføjelse er gemt.',
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
    23 => 'Fejl ved tilføjelse af en begivenhed til din personlige kalender. Der blev ikke tilføjet et ID.',
    24 => 'Begivenheden er gemt i din kalender',
    25 => 'Kan ikke åbne din personlige kalender førend du er logget ind',
    26 => 'Begivenheden blev slettet fra din personlige kalender',
    27 => 'Beskeden er sendt.',
    28 => 'Denne plugin er blevet gemt',
    29 => 'Desværre, den personlige kalender er ikke implementeret på denne side',
    30 => 'Adgang Nægtet',
    31 => 'Desværre, du har ikke adgang til siden for administration af historier. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
    32 => 'Desværre, du har ikke adgang til siden for administration af emner. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
    33 => 'Desværre, du har ikke adgang til siden for administration af kasser. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
    34 => 'Desværre, du har ikke adgang til siden for administration af links. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
    35 => 'Desværre, du har ikke adgang til siden for administration af begivenheder. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
    36 => 'Desværre, du har ikke adgang til siden for administration af afstemninger. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
    37 => 'Desværre, du har ikke adgang til siden for administration af brugere. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
    38 => 'Desværre, du har ikke adgang til siden for administration af plugins. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
    39 => 'Desværre, du har ikke adgang til siden for administration af emails. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
    40 => 'System Besked',
    41 => 'Sorry, you do not have access to the word replacement page.  Please note that all attempts to access unauthorized features are logged',
    42 => 'Dit ord er gemt.',
    43 => 'Ordet er blevet slettet.',
    44 => 'Denne plugin blev installeret!',
    45 => 'Denne plugin er blevet slettet.',
    46 => 'Desværre, du har ikke adgang til siden for backup af databasen. Bemærk at alle forsøg på at få tilgang til administrationssider bliver logget',
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
    59 => 'The feed has been successfully deleted.',
    60 => 'The plugin was successfully updated',
    61 => 'Plugin %s: Unknown message placeholder',
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
    'access' => 'Adgang',
    'ownerroot' => 'Ejer/Root',
    'group' => 'Gruppe',
    'readonly' => 'Read-Only',
    'accessrights' => 'Adgangsrettigheder',
    'owner' => 'Ejer',
    'grantgrouplabel' => 'Giv overstående Gruppe ændrings rettigheder',
    'permmsg' => 'NOTE: Medlemmer er alle sammen logget ind på siden. Anonyme er alle de brugere som ikke er logget ind på siden.',
    'securitygroups' => 'Sikkerheds grupper',
    'editrootmsg' => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF['site_admin_url']}/user.php\">User Administration page</a>.",
    'securitygroupsmsg' => 'Select the checkboxes for the groups you want the user to belong to.',
    'groupeditor' => 'Gruppe editor',
    'description' => 'Beskrivelse',
    'name' => 'Navn',
    'rights' => 'Rettigheder',
    'missingfields' => 'Manglende felter',
    'missingfieldsmsg' => 'Du skal tilføje navn og beskrivelse for en gruppe',
    'groupmanager' => 'Gruppe manager',
    'newgroupmsg' => 'To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used in the system.',
    'groupname' => 'Gruppe navn',
    'coregroup' => 'Core gruppe',
    'yes' => 'Ja',
    'no' => 'Nej',
    'corerightsdescr' => "This group is a core {$_CONF['site_name']} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
    'groupmsg' => 'Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called \'Rights\'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.',
    'coregroupmsg' => "This group is a core {$_CONF['site_name']} Group.  Therefore the groups that this group belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
    'rightsdescr' => 'A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.',
    'lock' => 'Lås',
    'members' => 'Medlemmer',
    'anonymous' => 'Anonyme',
    'permissions' => 'Rettigheder',
    'permissionskey' => 'R = læs, E = ændre, ændre rettigheder fordre læse rettigheder',
    'edit' => 'Ændre',
    'none' => 'Igrn',
    'accessdenied' => 'Adgang nægtet',
    'storydenialmsg' => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF['site_name']}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF['site_name']} to receive full membership access!",
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
    'canteditgroup' => 'To edit this group, you have to be a member of the group. Please contact the system administrator if you feel this is an error.',
    'cantlistgroup' => 'To see the members of this group, you have to be a member yourself. Please contact the system administrator if you feel this is an error.',
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
    'last_ten_backups' => 'Sidste 10 Backups',
    'do_backup' => 'Backup',
    'backup_successful' => 'Backup af databasen skete med succes.',
    'db_explanation' => 'For at lave en ny backup af dit Geeklog system, skal du klikke på knappen herunder',
    'not_found' => "Forkert sti eller også er mysqldump værktøjet ikke eksekverbar.<br>Tjek <strong>\$_DB_mysqldump_path</strong> definitionen i filen config.php.<br>Variablen er pt. defineret som: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup Mislykkedes: Filestørrelsen var på 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} findes ikke, eller er ikke et bibliotek",
    'no_access' => "FEJL: biblioteket {$_CONF['backup_path']} er ikke tilgængeligt.",
    'backup_file' => 'Backup fil',
    'size' => 'Størrelse',
    'bytes' => 'Bytes',
    'total_number' => 'Total number of backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Hjem',
    2 => 'Kontakt',
    3 => 'Tilføj',
    4 => 'Links',
    5 => 'Afstemninger',
    6 => 'Kalender',
    7 => 'Sidestatistik',
    8 => 'Personificer',
    9 => 'Søg',
    10 => 'avanceret søgning',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Fejl',
    2 => 'Hmmm, jeg har ledt såvel oppe som nede for at finde filen <b>%s</b>.',
    3 => "<p>Desværre, men filen du efterspørger findes ikke. Du er velkommen til selv at lede via <a href=\"{$_CONF['site_url']}\">forsiden</a> eller <a href=\"{$_CONF['site_url']}/search.php\">søgesiden</a> for at se om du dér kan finde det du søger."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Log ind nødvendig',
    2 => 'Desværre, for at få adgang til dette område, skal du være logget ind som bruger på siden.',
    3 => 'Log ind',
    4 => 'Ny Bruger'
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
    1 => 'Januar',
    2 => 'Februar',
    3 => 'Marts',
    4 => 'April',
    5 => 'Maj',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'August',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'December'
);

###############################################################################
# Weekdays

$LANG_WEEK = array(
    1 => 'Søndag',
    2 => 'Mandag',
    3 => 'Tirsdag',
    4 => 'Onsdag',
    5 => 'Torsdag',
    6 => 'Fredag',
    7 => 'Lørdag'
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