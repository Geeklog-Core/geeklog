<?php

###############################################################################
# norwegian.php, based on
# english.php
# This is the norwegian language page for GeekLog!
#
# Translator   : Torfinn Ingolfsen <tingo@start.no>
# Date started : 2003-03-10
# Last updated : 2003-06-08
# Date finished: 2003-03-30
# History:
# 2003-06-08	Corrected LANG22[15], capitalize first word
# 2003-04-02	Corrected capitalization of MESSAGE[48].
# 2003-03-30	Translated the last (and final) part
# 2003-03-23	Translated down to and including LANG23 (link.php)
# 2003-03-18	First half of the file translated
# 2003-03-10	Translation started
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
    1 => 'Gitt av:',
    2 => 'les mer',
    3 => 'kommentarer',
    4 => 'Rediger',
    5 => 'stem',
    6 => 'Resultater',
    7 => 'stemmeresultater',
    8 => 'stemmer',
    9 => 'Admin Funksjoner:',
    10 => 'Innlegg',
    11 => 'Artikler',
    12 => 'Blokker',
    13 => 'Emner',
    14 => 'Lenker',
    15 => 'Begivenheter',
    16 => 'Avstemning',
    17 => 'Brukere',
    18 => 'SQL Sp�rring',
    19 => 'Logg Ut',
    20 => 'Brukerinformasjon:',
    21 => 'Brukernavn',
    22 => 'Bruker ID',
    23 => 'Sikkerhetsniv�',
    24 => 'Anonym',
    25 => 'Svar',
    26 => 'De f�lgende kommentarer eies av den som skrev dem. Dette nettstedet er ikke ansvarlig for innholdet.',
    27 => 'Nyeste Innlegg',
    28 => 'Slett',
    29 => 'ingen kommentarer.',
    30 => 'Eldre Artikler',
    31 => 'Lovlige HTML tagger:',
    32 => 'Feil, ugyldig brukernavn',
    33 => 'Feil, kunne ikke skrive til loggfilen',
    34 => 'Feil',
    35 => 'Logg ut',
    36 => 'p�',
    37 => 'Ingen artikler fra brukere',
    38 => 'Content Syndication',
    39 => 'Gjenoppfrisk',
    40 => 'You have <tt>register_globals = Off</tt> in your <tt>php.ini</tt>. However, Geeklog requires <tt>register_globals</tt> to be <strong>on</strong>. Before you continue, please set it to <strong>on</strong> and restart your web server.',
    41 => 'Gjestebrukere',
    42 => 'Skrevet av:',
    43 => 'Svar p� denne',
    44 => 'Opphav',
    45 => 'MySQL Feil Nummer',
    46 => 'MySQL Feilmelding',
    47 => 'Brukerfunksjoner',
    48 => 'Kontoinformasjon',
    49 => 'Visningsvalg',
    50 => 'Feil i SQL setning',
    51 => 'hjelp',
    52 => 'Ny',
    53 => 'Admin Hovedside',
    54 => 'Kunne ikke �pne filen.',
    55 => 'Feil p�',
    56 => 'stem',
    57 => 'Passord',
    58 => 'Logg inn',
    59 => "Er du ikke bruker enn�? Registrer deg som en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Ny bruker</a>",
    60 => 'Skriv en kommentar',
    61 => 'Opprett Ny Konto',
    62 => 'ord',
    63 => 'Kommentarvalg',
    64 => 'Email Artikkelen Til en Venn',
    65 => 'Utskriftsvennlig Versjon',
    66 => 'Min Kalender',
    67 => 'Velkommen til ',
    68 => 'hjem',
    69 => 'kontakt',
    70 => 's�k',
    71 => 'bidra',
    72 => 'lenker',
    73 => 'tidligere avstemninger',
    74 => 'kalender',
    75 => 'avansert s�k',
    76 => 'nettsted statistikk',
    77 => 'Plugins',
    78 => 'Kommende Begivenheter',
    79 => 'Nytt',
    80 => 'artikler de siste',
    81 => 'historie de siste',
    82 => 'timer',
    83 => 'KOMMENTARER',
    84 => 'LENKER',
    85 => 'siste 48 timer',
    86 => 'ingen nye kommentarer',
    87 => 'siste 2 uker',
    88 => 'ingen nye lenker',
    89 => 'Det er ingen kommende begivenheter',
    90 => 'Hjem',
    91 => 'Side generert p�',
    92 => 'sekunder',
    93 => 'Opphavsrett',
    94 => 'Alle varemerker og opphavsrett p� denne siden tilh�rer de respektive eiere.',
    95 => 'Drevet Av',
    96 => 'Grupper',
    97 => 'Ordliste',
    98 => 'Plug-ins',
    99 => 'ARTIKLER',
    100 => 'ingen nye artikler',
    101 => 'Dine Begivenheter',
    102 => 'Nettstedets Begivenheter',
    103 => 'DB Backups',
    104 => 'av',
    105 => 'Email brukere',
    106 => 'Visninger',
    107 => 'GL Version Test',
    108 => 'T�m Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Kalender',
    2 => 'Beklager, det er ingen begivenheter � vise.',
    3 => 'N�r',
    4 => 'Hvor',
    5 => 'Beskrivelse',
    6 => 'Legg Til En Begivenhet',
    7 => 'Kommende Begivenheter',
    8 => 'Ved � legge denne begivenheten til din kalender, kan du raskt f� et overblikk over kun\nde begivenheter du er interessert i, ved � trykke p� "Min Kalender" i Brukermenyen',
    9 => 'Legg Til Min Kalender',
    10 => 'Fjern fra Min Kalender',
    11 => "Legger til Begivenhet til {$_USER['username']}'s Kalender",
    12 => 'Begivenhet',
    13 => 'Starter',
    14 => 'Slutter',
    15 => 'tilbake til Kalender'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Skriv en Kommentar',
    2 => 'Skrivemodus',
    3 => 'Logg ut',
    4 => 'Lag ny Konto',
    5 => 'Brukernavn',
    6 => 'Dette nettstedet krever at du er logget inn for � kunne skrive kommentarer, vennligst logg inn. Hvis du ikke er registrert fra f�r, bruk skjemaet under for � registrere deg som ny bruker.',
    7 => 'Din siste kommentar var ',
    8 => " sekunder siden. Dette nettstedet krever minst {$_CONF['commentspeedlimit']} sekunder mellom kommentarer",
    9 => 'kommentar',
    10 => '',
    11 => 'Post kommentar',
    12 => 'vennligst fyll ut Tittel- og Kommentarfeltene, de er obligatoriske for � poste en kommentar.',
    13 => 'Din Informasjon',
    14 => 'Forh�ndsvisning',
    15 => '',
    16 => 'Overskrift',
    17 => 'Feil',
    18 => 'Viktig',
    19 => 'Fors�k � holde deg til emnet n�r du skriver kommentarer.',
    20 => 'Svar p� andres kommentarer istedet for � opprette nye diskusjonstr�der.',
    21 => 'Les �vrige kommentarer f�r du poster din egen, for � unng� gjentakelse av det som allerede er blitt sagt.',
    22 => 'Bruk en tydelig overskrift som forteller hva kommentaren din handler om.',
    23 => 'Emailadressen din blir IKKE offentliggjort.',
    24 => 'Anonym Bruker'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Brukerprofil for',
    2 => 'Brukernavn',
    3 => 'Fullt Navn',
    4 => 'Passord',
    5 => 'Email',
    6 => 'Hjemmeside',
    7 => 'Biografi',
    8 => 'PGP n�kkel',
    9 => 'Lagre Informasjon',
    10 => 'Siste 10 kommentarer av bruker',
    11 => 'Brukeren har ikke skrevet noen kommentarer',
    12 => 'Brukervalg for',
    13 => 'Email Nattlig Sammendrag',
    14 => 'Dette er et tilfeldig generert passord. Du anbefales � endre passordet omg�ende. For � endre passordet, logg inn og velg Kontoinformasjon fra Brukermenyen.',
    15 => "Din {$_CONF['site_name']} er opprettet. For � bruke den m� du logge inn med nedenst�ende opplysninger. Vennligst ta vare p� denne mailen for fremtidig referanse.",
    16 => 'din Kontoinformasjon',
    17 => 'Kontoen eksisterer ikke',
    18 => 'Oppgitt emailadresse synes � v�re ugyldig',
    19 => 'Oppgitt brukernavn eller emailadresse finnes fra f�r',
    20 => 'Oppgitt emailadresse synes � v�re ugyldig',
    21 => 'Feil',
    22 => "Opprett konto p� {$_CONF['site_name']}!",
    23 => "Ved � opprette en konto p� {$_CONF['site_name']} vil du f� mulighet til � skrive artikler og kommentarer i dit eget navn. hvis du ikke har en konto, vil du kun delta som anonym. emailadressendu oppgir vil <b><i>aldri</i></b> bli offentlig vist p� dette nettstedet.",
    24 => 'Passordet ditt blir sendt til den emailadressen du oppgir.',
    25 => 'Har du glemt passordet ditt?',
    26 => 'skriv inn brukernavnet ditt og trykk p� Email Passord, og et nytt passord blir sendt til mailadressen som er registrert for brukeren din.',
    27 => 'Opprett Konto N�!',
    28 => 'Email Passord',
    29 => 'logged out from',
    30 => 'logged in from',
    31 => 'Denne funksjonen krever at du er logget inn',
    32 => 'Signatur',
    33 => 'Blir aldri vist offentlig',
    34 => 'Ditt egentlige navn',
    35 => 'Skriv inn passord for � endre det',
    36 => 'Begynner med http://',
    37 => 'Legges til dine kommentarer',
    38 => 'Alt om deg! Alle kan lese dette',
    39 => 'Din offentlige PGP n�kkel',
    40 => 'Ingen Emneikoner',
    41 => 'Willing to Moderate',
    42 => 'Datoformat',
    43 => 'Maksimum Antall Artikler',
    44 => 'Ingen Rammer',
    45 => 'Visningsvalg for',
    46 => 'Ekskluderte Emner og Forfattere for',
    47 => 'Konfigurasjon av nyhetsbokser for',
    48 => 'Emner',
    49 => 'ingen ikoner i artikler',
    50 => 'fjern avkryssing hvis du ikke er interessert',
    51 => 'Kun nyheter og artikler',
    52 => 'Standardverdien er',
    53 => 'Motta dagens artikler hver natt',
    54 => 'Kryss av for de emner og forfattere du ikke �nsker � se.',
    55 => 'Dersom ingen er avkrysset, s� f�r du standardvalget. Hvis dy begynner � krysse av bokser, husk � krysse av for alle du �nsker � se, fordi standardvalget blir ignorert. Standardvalg vises med <b>uthevet</b> skrift.',
    56 => 'Forfattere',
    57 => 'Visningsmodus',
    58 => 'Rekkef�lge for sortering',
    59 => 'Kommentarbegrensning',
    60 => 'Hvordan vil du ha kommentarene vist?',
    61 => 'Nyeste eller eldste f�rst?',
    62 => 'Standardverdi er 100',
    63 => "Passordet ditt er sendt, og vil snart dukke opp i mailboksen din. Vennligst f�lg instruksjonen i meldingen du mottar. Vi takker for at du bruker {$_CONF['site_name']}",
    64 => 'Kommentarvalg for',
    65 => 'Fors�k � logge inn p� nytt',
    66 => "Du har kanskje skrevet brukernavn eller passord feil. Fors�k � logge inn igjewn under. er du en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">ny bruker</a>?",
    67 => 'Medlem Siden',
    68 => 'Husk meg i',
    69 => 'Hvor lenge skal vi huske deg etter at du er logget inn?',
    70 => "Tilpass utseendet og innholdet p� {$_CONF['site_name']}",
    71 => "En av mulighetene p� {$_CONF['site_name']} er at du kan tilpasse innhold, utseeende og layout slik at det passer deg. for � kunne bruke disse funksjonene m� du f�rst registrere deg som  <a href=\"{$_CONF['site_url']}/users.php?mode=new\">bruker</a> p� {$_CONF['site_name']}. Er du allerede registrert? Da bruker du loginskjemaet til venstre for � logge inn!",
    72 => 'Tema',
    73 => 'Spr�k',
    74 => 'Endre utseendet p� dette nettstedet!',
    75 => 'Emailede Emner for',
    76 => 'Hvis du velger et eller flere emner fra listen under, s� vil du motta alle nye artikler for det enkelte emne ved dagens slutt. Velg kun emner som interesserer deg!',
    77 => 'Foto',
    78 => 'Legg inn et bilde av deg selv!',
    79 => 'Kryss av here for � slette dette bildet',
    80 => 'Login',
    81 => 'Send Email',
    82 => 'Siste 10 artikler av bruker',
    83 => 'Skrivestatistikk for bruker',
    84 => 'Totalt antall artikler:',
    85 => 'Totalt antall kommentarer:',
    86 => 'Finn alt skrevet av',
    87 => 'Your login name',
    88 => "Someone (possibly you) has requested a new password for your account \"%s\" on {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nIf you really want this action to be taken, please click on the following link:\n\n",
    89 => "If you do not want this action to be taken, simply ignore this message and the request will be disregarded (your password will remain unchanged).\n\n",
    90 => 'You can enter a new password for your account below. Please note that your old password is still valid until you submit this form.',
    91 => 'Set New Password',
    92 => 'Enter New Password',
    93 => 'Your last request for a new password was %d seconds ago. This site requires at least %d seconds between password requests.',
    94 => 'Delete Account "%s"',
    95 => 'Click the "delete account" button below to remove your account from our database. Please note that any stories and comments you posted under this account will <strong>not</strong> be deleted but show up as being posted by "Anonymous".',
    96 => 'delete account',
    97 => 'Confirm Account Deletion',
    98 => 'Are you sure you want to delete your account? By doing so, you will not be able to log into this site again (unless you create a new account). If you are sure, click "delete account" again on the form below.',
    99 => 'Privacy Options for',
    100 => 'Email from Admin',
    101 => 'Allow email from Site Admins',
    102 => 'Email from Users',
    103 => 'Allow email from other users',
    104 => 'Show Online Status',
    105 => 'Show up in Who\'s Online block'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Det er ingen nyheter � vise',
    2 => 'Det er ingen artikler � vise. Enten er det ingen nyheter for dette emne, eller s� er dine brukervalg for restriktive',
    3 => " for emne {$topic}",
    4 => 'Dagens Hovedoppslag',
    5 => 'Neste',
    6 => 'Forrige'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'Lenker',
    2 => 'Det er ingen lenker � vise.',
    3 => 'Legg Til En Lenke'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'Stemme Lagret',
    2 => 'Din stemme er avgitt',
    3 => 'Stem',
    4 => 'Avstemninger i systemet',
    5 => 'Stemmer',
    6 => 'View other poll questions'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'det oppsto en feil under utsendelse av din melding. Vennligst fors�k p� nytt.',
    2 => 'Meldingen ble sendt.',
    3 => 'Vennligst sjekk at du bruker en gyldig emailadressei Svar Til feltet.',
    4 => 'Vennligst fyll ut feltene Ditt Navn, Svar Til, Emne og  Melding',
    5 => 'Feil: Bruker finnes ikke.',
    6 => 'En feil oppsto.',
    7 => 'Brukerprofil for',
    8 => 'Brukernavn',
    9 => 'Bruker URL',
    10 => 'Send email til',
    11 => 'Ditt navn:',
    12 => 'Svar Til:',
    13 => 'Emne:',
    14 => 'Melding:',
    15 => 'HTML blir ikke oversatt.',
    16 => 'Send Melding',
    17 => 'Email denne artikkelen til en venn',
    18 => 'Til Navn',
    19 => 'Til Emailadresse',
    20 => 'Fra Navn',
    21 => 'Fra Emailadresse',
    22 => 'Alle felter m� fylles ut',
    23 => "Denne emailen er sendt til deg av {$from} ({$fromemail}) fordi vedkommende mener at du kunne v�re interessert i denne artikkelen fra {$_CONF['site_url']}. Dette er ikke SPAM (s�ppelpost) og mailadressene som ble brukt i denne transaksjonen er ikke lagret for senere bruk.",
    24 => 'Kommenter denne artikkelen p�',
    25 => 'Du m� v�re logget inn for � bruke denne funksjonen. Kravet om innlogging hjelper til med � hindre misbruk av systemet',
    26 => 'Dette skjemaet lar deg sende en email til valgt bruker. Alle felter m� fylles ut.',
    27 => 'Kort melding',
    28 => "{$from} skrev: {$shortmsg}",
    29 => "Dette er det daglige sammendraget fra {$_CONF['site_name']} for ",
    30 => ' Daglig Nyhetsbrev for ',
    31 => 'Overskrift',
    32 => 'Dato',
    33 => 'les hele artikkelen p�',
    34 => 'Slutt p� Melding',
    35 => 'Sorry, this user prefers not to receive any emails.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Avansert S�k',
    2 => 'N�kkelord',
    3 => 'Emne',
    4 => 'Alle',
    5 => 'Type',
    6 => 'Artikler',
    7 => 'Kommentarer',
    8 => 'Forfattere',
    9 => 'Alle',
    10 => 'S�k',
    11 => 'S�keresultater',
    12 => 'resultater',
    13 => 'S�keresultat: Ingen samsvar',
    14 => 'Det var ingen resultater som svarte til ditt s�k etter',
    15 => 'Pr�v igjen.',
    16 => 'emne',
    17 => 'Dato',
    18 => 'Forfatter',
    19 => "S�k i hele {$_CONF['site_name']} databasen av n�v�rende og gamle artikler",
    20 => 'Dato',
    21 => 'til',
    22 => '(Datoformat YYYY-MM-DD)',
    23 => 'Treff',
    24 => 'Fant',
    25 => 'treff av',
    26 => 'mulige p�',
    27 => 'sekunder',
    28 => 'Ingen treff i artikler eller kommentarer for ditt s�k',
    29 => 'Resultater fra Artikler og Kommentarer',
    30 => 'Ingen lenker svarte til ditt s�k',
    31 => 'This plug-in returned no matches',
    32 => 'Begivenhet',
    33 => 'URL',
    34 => 'Sted',
    35 => 'Hele dagen',
    36 => 'Ingen begivenheter svarte til ditt s�k',
    37 => 'Resultater fra Begivenheter',
    38 => 'Resultater fra Lenker',
    39 => 'Lenker',
    40 => 'Begivenheter',
    41 => 'S�kestrengen din m� inneholde minst 3 tegn.',
    42 => 'Datoer m� angis p� formatet YYYY-MM-DD (�r-m�ned-dag).',
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
    1 => 'Statistikk for nettstedet',
    2 => 'Totalt antall treff i systemet',
    3 => 'Artikler(kommentarer) i systemet',
    4 => 'Avstemninger(Svar) i systemet',
    5 => 'Lenker(klikk) i systemet',
    6 => 'Begivenheter i systemet',
    7 => 'Topp Ti Viste Artikler',
    8 => 'Overskrift',
    9 => 'Vist',
    10 => 'Det virker som om det ikke er noen artikler p� dette nettstedet, eller at ingen har lest dem.',
    11 => 'Topp Ti kommenterte Artikler',
    12 => 'Kommentarer',
    13 => 'Det virker som om det ikke er noen artikler p� dette nettstedet, eller at ingen har kommentert dem.',
    14 => 'Topp Ti Avstemninger',
    15 => 'Sp�rsm�l',
    16 => 'stemmer',
    17 => 'Det virker som om det ikke er noen avstemninger p� dette nettstedet, eller at ingen har stemt.',
    18 => 'Topp Ti Lenker',
    19 => 'Lenke',
    20 => 'Treff',
    21 => 'Det virker som om det ikke er noen lenker p� dette nettstedet, eller at ingen har klikket p� dem.',
    22 => 'Topp Ti Artikler sendt via Email',
    23 => 'Emails',
    24 => 'Det virker som om ingen har emailet en artikkel p� dette nettstedet'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Relatert',
    2 => 'Send  artikkelen til en venn',
    3 => 'utskriftsvennlig format',
    4 => 'Valg'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "Du m� v�re logget inn for � poste en {$type}.",
    2 => 'Logg inn',
    3 => 'Ny bruker',
    4 => 'Post en begivenhet',
    5 => 'Post en lenke',
    6 => 'Post en artikkel',
    7 => 'Innlogging kreves',
    8 => 'Post',
    9 => 'N�r du poster informasjon p� dette nettstedet ber vi om at du f�lger disse retningslinjene...<ul><li>Alle feltene m� fylles ut<li>Gi n�yaktige og komplette opplysninger<li>Dobbeltsjekk URLer</ul>',
    10 => 'Overskrift',
    11 => 'Lenke',
    12 => 'Start Dato',
    13 => 'Slutt Dato',
    14 => 'Sted',
    15 => 'Beskrivelse',
    16 => 'Hvis Annen, vennligst angi',
    17 => 'Kategori',
    18 => 'Annen',
    19 => 'Les f�rst',
    20 => 'Feil: kategori mangler',
    21 => 'Hvis du velger "Annen" vennligst angi et navn p� kategorien',
    22 => 'Feil: felt mangler',
    23 => 'Vennligst fyll inn alle feltene.  Alle felt er p�krevd.',
    24 => 'Posting lagret',
    25 => "Din posting av en {$type} er lagret.",
    26 => 'Fartsgrense',
    27 => 'Brukernavn',
    28 => 'Emne',
    29 => 'Artikkel',
    30 => 'din siste posting var ',
    31 => " sekunder siden.  Dette nettstedet krever minst {$_CONF['speedlimit']} sekunder mellom postinger",
    32 => 'Forh�ndsvisning',
    33 => 'Forh�ndsvis Artikkel',
    34 => 'Logg ut',
    35 => 'HTML tagger er ulovlig',
    36 => 'Posting Modus',
    37 => "N�r en begivenhet postes til {$_CONF['site_name']} s� havner den p� hovedkalenderen, og andre brukere kan velge � legge den til sin personlige  kalender. Kalenderen er <b>IKKE</b> beregnet for � lagre personlige begivenheter som f�dselsdager, jubileum osv.<br><br>N�r en begivenhet er postet blir den sendt til v�re redakt�rer, og hvis den blir godkjent havner den p� hovedkalenderen.",
    38 => 'Legg Begivenhet Til',
    39 => 'Hoved Kalender',
    40 => 'Personlig Kalender',
    41 => 'Slutt Tid',
    42 => 'Start Tid',
    43 => 'Heldags Begivenhet',
    44 => 'Adresselinje 1',
    45 => 'Adresselinje 2',
    46 => 'By/Sted',
    47 => 'Stat',
    48 => 'Postnummer',
    49 => 'Begivenhet Type',
    50 => 'Rediger Begivenhetstyper',
    51 => 'Sted',
    52 => 'Slett',
    53 => 'Lag Konto'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Autentisering kreves',
    2 => 'Avvist! Ugyldig brukernavn eller passord',
    3 => 'Ugyldig passord for bruker',
    4 => 'Brukernavn:',
    5 => 'Passord:',
    6 => 'All tilgang til administrative deler av nettstedet blir logget og gransket.<br>Denne siden er kun autorisert personell.',
    7 => 'logg inn'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Utilstrekkelige Admin Rettigheter',
    2 => 'Du har ikke n�dvendige rettigheter for � redigere denne blokken.',
    3 => 'Blokk Editor',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Blokk Overskrift',
    6 => 'Emne',
    7 => 'Alle',
    8 => 'Blokk Sikkerhetsniv�',
    9 => 'Blokk Rekkef�lge',
    10 => 'Blokk Type',
    11 => 'Portal Blokk',
    12 => 'Normal Blokk',
    13 => 'Portal Blokk Opsjoner',
    14 => 'RDF URL',
    15 => 'Siste RDF Oppdatering',
    16 => 'Normal Blokk Opsjoner',
    17 => 'Blokk Innhold',
    18 => 'Vennligst fyll ut feltene Overskrift, Sikkerhetsniv� og innhold ',
    19 => 'Blokk Bestyrer',
    20 => 'Blokk Overskrift',
    21 => 'Blokk Sikkerhetsniv�',
    22 => 'Blokk Type',
    23 => 'Blokk Rekkef�lge',
    24 => 'Blokk Emne',
    25 => 'For � endre eller slette en blokk, klikk p� blokkoverskriften under.  For � lage en ny blokk klikk p� "Ny Blokk" ovenfor.',
    26 => 'Layout Blokk',
    27 => 'PHP Blokk',
    28 => 'PHP Blokk Opsjoner',
    29 => 'Blokk Funksjon',
    30 => 'Hvis du vil bruke PHP kode i en blokk, skriv inn navnet p� funksjonen over.  Navnet p� funksjonen m� starte med prefikset "phpblock_" (feks. phpblock_getweather).  Dersom navnet ikke har dette prefikset, s� vil funksjonen IKKE bli kalt.  Vi gj�r dette for � forhindre hackere fra � bruke vilk�rlige funksjoner (som kan skade systemet), dersom de skulle klare � gj�re innbrudd i Geeklog installasjonen din. forsikre deg om at det ike er tomme paranteser "()" etter navnet p� funksjonen. Til slutt anbefaler vi at du legger all kode til PHP Blokker i /path/to/geeklog/system/lib-custom.php.  Da unng�r du at koden blir overskrevet ved oppgraderinger av Geeklog.',
    31 => 'Feil i PHP Blokk. Funksjonen $function eksisterer ikke.',
    32 => 'Feil Felt(er) mangler',
    33 => 'Du m� skrive inn URLen til .rdf filen for portal blokker',
    34 => 'Du m� skrive inn overskrift og funksjon for PHP blokker',
    35 => 'Du m� skrive inn overskrift og innhold for normale blokker',
    36 => 'Du m� skrive inn the content for layout blocks',
    37 => 'Ulovlig funksjonsnavn p� PHP blokk',
    38 => 'Funksjoner for PHP Blokker m� ha prefikset \'phpblock_\' (feks. phpblock_getweather). Prefikset \'phpblock_\' kreves av sikkerhetsmesige �rsaker for � forhindre kj�ring av vilk�rlig kode..',
    39 => 'Side',
    40 => 'Venstre',
    41 => 'H�yre',
    42 => 'du m� skrive inn rekkef�lge og sikkerhetsniv� for Geeklog standard blokker',
    43 => 'Kun hjemmeside',
    44 => 'Adgang Nektet',
    45 => "Du fors�ker � f� tilgang til en blokk som du ikke har rettigheter til. Fors�ket er logget. Vennligst <a href=\"{$_CONF['site_admin_url']}/block.php\">g� tilbake til administrasjonsiden for blokker</a>.",
    46 => 'Ny Blokk',
    47 => 'Admin Hovedside',
    48 => 'Blokk Navn',
    49 => ' (uten mellomrom og m� v�re unikt)',
    50 => 'URL til hjelpefil',
    51 => 'ta med http://',
    52 => 'hvis du lar denne v�re tom, s� vises ikke hjelpeikonet for denne blokken',
    53 => 'Aktivisert',
    54 => 'lagre',
    55 => 'avbryt',
    56 => 'slett',
    57 => 'Move Block Down',
    58 => 'Move Block Up',
    59 => 'Move block to the right side',
    60 => 'Move block to the left side'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Begivenhet Editor',
    2 => '',
    3 => 'Begivenhet Overskrift',
    4 => 'Begivenhet URL',
    5 => 'Begivenhet Start Dato',
    6 => 'Begivenhet slutt Dato',
    7 => 'Begivenhet sted',
    8 => 'Begivenhet Beskrivelse',
    9 => '(ta med http://)',
    10 => 'Du m� ta med dato og tid, beskrivelse og sted!',
    11 => 'Begivenhet Bestyrer',
    12 => 'For � endre eller slette en begivenhet, klikk p� begivenheten under. For � lage en ny begivenhet klikk p� Ny Begivenhet ovenfor.',
    13 => 'Begivenhet Overskrift',
    14 => 'Start Dato',
    15 => 'Slutt Dato',
    16 => 'Adgang Nektet',
    17 => "Du fors�ker � f� tilgang til en begivenhet som du ikke har rettigheter til. Fors�ket er logget. Vennligst <a href=\"{$_CONF['site_admin_url']}/event.php\">g� tilbake til administrasjonsiden for begivenheter</a>.",
    18 => 'Ny Begivenhet',
    19 => 'Admin Hovedside',
    20 => 'lagre',
    21 => 'avbryt',
    22 => 'slett'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Lenke Editor',
    2 => '',
    3 => 'Lenke Overskrift',
    4 => 'Lenke URL',
    5 => 'Kategori',
    6 => '(ta med http://)',
    7 => 'Annen',
    8 => 'Lenke Treff',
    9 => 'Lenke Beskrivelse',
    10 => 'Du m� ta med Overskrift, URL og Beskrivelse.',
    11 => 'Lenke Administrasjon',
    12 => 'for � endre eller slette en lenke, klikk p� lenken under. For �  lage en ny lenke klikk p� Ny Lenke ovenfor.',
    13 => 'Lenke Overskrift',
    14 => 'Lenke Kategori',
    15 => 'Lenke URL',
    16 => 'Adgang Nektet',
    17 => "Du fors�ker � f� tilgang til en lenke som du ikke har rettigheter til. Fors�ket er logget. Vennligst <a href=\"{$_CONF['site_admin_url']}/link.php\">g� tilbake til administrasjonsiden for lenker</a>.",
    18 => 'Ny Lenke',
    19 => 'Admin Hovedside',
    20 => 'hvis Annen, angi',
    21 => 'lagre',
    22 => 'avbryt',
    23 => 'slett'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Forrige artikler',
    2 => 'Neste artikler',
    3 => 'Modus',
    4 => 'Posting Modus',
    5 => 'Artikkel Editor',
    6 => 'Det er ingen artikler i systemet',
    7 => 'Forfatter',
    8 => 'lagre',
    9 => 'forh�ndsvis',
    10 => 'avbryt',
    11 => 'slett',
    12 => '',
    13 => 'Tittel',
    14 => 'Emne',
    15 => 'Dato',
    16 => 'Introduksjonstekst',
    17 => 'Hovedtekst',
    18 => 'Treff',
    19 => 'Kommentarer',
    20 => '',
    21 => '',
    22 => 'Artikkel Liste',
    23 => 'For � redigere eller slette en artikkel, klikk p� artikkelnummeret under. For � se en artikkel, klikk p� tittelen til artikkelen du �nsker � se. For � lage en ny artikkel klikk p� Ny Artikkel over.',
    24 => '',
    25 => '',
    26 => 'Artikkel forh�ndsvisning',
    27 => '',
    28 => '',
    29 => '',
    30 => 'File Upload Errors',
    31 => 'Vennligst fyll ut feltene Forfatter, Tittel og introduksjonstekst',
    32 => 'Hovedoppslag',
    33 => 'Det kan kun v�re ett hovedoppslag',
    34 => 'Kladd',
    35 => 'Ja',
    36 => 'Nei',
    37 => 'Mer av',
    38 => 'Mer fra',
    39 => 'Emails',
    40 => 'Adgang Nektet',
    41 => "Du fors�ker � redigere en artikkel du ikke har adgang til. Fors�ket er logget. Du kan lese artikkelen under. Vennligst <a href=\"{$_CONF['site_admin_url']}/story.php\">g� tilbake til artikkeladministrasjon</a> n�r du er ferdig.",
    42 => "Du fors�ker � se en artikkel du ikke har adgang til. Fors�ket er logget. Vennligst <a href=\"{$_CONF['site_admin_url']}/story.php\">g� tilbake til artikkeladministrasjon</a>.",
    43 => 'Ny Artikkel',
    44 => 'Admin Hovedside',
    45 => 'Adgang',
    46 => '<b>MERK:</b> hvis du endrer datoen til � v�re i fremtiden, s� vil artikkelen ikke bli publisert f�r datoen intreffer. Det betyr ogs� at artikkelen ikke blir inkludert i RDF oversikten din, og at den blir ignorert av s�ke- og statistikksidene.',
    47 => 'Bilder',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => 'For � bruke et av bildene du har lagt ved denne artikkelen m� du sette inn en bestemt kode i artikkelen.  Koden er  [imageX], [imageX_right] (h�yre) eller [imageX_left] (venstre) og X nummeret p� bildet du har lagt ved. MERK: Du <b>m�</b> bruke alle bildene du legger ved. Hvis ikke f�r du ikke lagret artikkelen.<BR><P><B>Forh�ndsvisning</B>: Forh�ndsvisning av e artikkel med bilder gj�res best ved � lagre artikkelen som en kladd, IKKE ved bruk av knappen for forh�ndsvisning. Bruk knappen for forh�ndsvisning kun p� artikler uten bilder.',
    52 => 'Slett',
    53 => 'ble ikke brukt. Du m� bruke dette bildet i introduksjonen eller i hovedteksten f�r du kan lagre endringer.',
    54 => 'Vedlagte bilder ikke brukt',
    55 => 'f�lgende feil oppsto under fors�k p� � lagre artikkelen din. Vennligst rett opp disse feilene f�r du lagrer',
    56 => 'Vis Emneikon',
    57 => 'View unscaled image'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'Modus',
    2 => 'Please enter a question and at least one answer.',
    3 => 'Avstemning opprettet',
    4 => "Avstemning {$qid} lagret",
    5 => 'Rediger Avstemning',
    6 => 'Avstemning ID',
    7 => '(ikke bruk mellomrom)',
    8 => 'Vises p� hovedside',
    9 => 'Sp�rsm�l',
    10 => 'Svar / Stemmer',
    11 => "En feil oppsto under henting av svardata for avstemningen {$qid}",
    12 => "En feil oppsto under henting av sp�rsm�lsdata for avstemningen {$qid}",
    13 => 'Lag Avstemning',
    14 => 'lagre',
    15 => 'avbryt',
    16 => 'slett',
    17 => 'Please enter a Poll ID',
    18 => 'Avstemning Liste',
    19 => 'For � redigere eller slette en avstemning, klikk p� den. For � lage en ny avstemning klikk p� ny avstemning over.',
    20 => 'Velgere',
    21 => 'Adgang Nektet',
    22 => "Du fors�ker � n� en avstemning som du ikke har rettigheter til. fors�ket er logget. Vennligst <a href=\"{$_CONF['site_admin_url']}/poll.php\">g� tilbake til avstemningsadministrasjon</a>.",
    23 => 'Ny Avstemning',
    24 => 'Admin Hovedside',
    25 => 'Ja',
    26 => 'Nei'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Emne Editor',
    2 => 'Emne ID',
    3 => 'Emne Navn',
    4 => 'Emne Bilde',
    5 => '(ikke bruk mellomrom)',
    6 => 'Sletting av et emne vil ogs� slette alle artikler og blokker som h�rer til emnet',
    7 => 'Vennligst fyll ut feltene Emne ID og Emne Navn',
    8 => 'Emne Administrasjon',
    9 => 'For � redigere eller slette et emne, klikk p� emnet. For � lage et nytt emne klikk p� knappen Nytt Emne til venstre. Adgangsniv�et ditt for hvert emne st�r i parantes',
    10 => 'Sorteringsrekkef�lge',
    11 => 'Artikler/Side',
    12 => 'Adgang Nektet',
    13 => "Du fors�ker � n� et emne du ikke har rettigheter til. Fors�ket er logget. Vennligst <a href=\"{$_CONF['site_admin_url']}/topic.php\">g� tilbake til emneadministrasjon</a>.",
    14 => 'Sorteringsm�te',
    15 => 'alfabetisk',
    16 => 'standard er',
    17 => 'Nytt Emne',
    18 => 'Admin Hovedside',
    19 => 'lagre',
    20 => 'avbryt',
    21 => 'slett',
    22 => 'Default',
    23 => 'make this the default topic for new story submissions',
    24 => '(*)'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Bruker Editor',
    2 => 'Bruker ID',
    3 => 'Brukernavn',
    4 => 'Fullt Navn',
    5 => 'Passord',
    6 => 'Sikkerhetsniv�',
    7 => 'Email Adresse',
    8 => 'Hjemmeside',
    9 => '(ikke bruk mellomrom)',
    10 => 'Vennligst fyll ut feltene Brukernavn, Fullt Navn, Sikkerhetsniv� og Email Adresse',
    11 => 'Bruker Administrasjon',
    12 => 'For � endre eller slette en bruker, klikk p� brukeren under. For � lage en ny  bruker klikk p� Ny Bruker til venstre. Du kan foreta enkle s�k ved � skrive inn deler av brukernavn, email adresse eller fullt navn (feks.*sen* or *.no) i s�kefeltet under.',
    13 => 'SecLev',
    14 => 'Reg. Dato',
    15 => 'Ny Bruker',
    16 => 'Admin Hovedside',
    17 => 'EndrePassord',
    18 => 'avbryt',
    19 => 'slett',
    20 => 'lagre',
    21 => 'Brukernavnet du fors�ke � lagre finnes allerede.',
    22 => 'Feil',
    23 => 'Masseimport',
    24 => 'Masseimportering av brukere',
    25 => 'Du kan importere en liste med brukere inn i Geeklog. Importfilen m� v�re en tekstfil med felter adskilt med tab-tegn. Feltene m� v�re i f�lgende rekkef�lge: fullt navn, brukernavn, email adresse. Det m� v�re kun en bruker per linje. Hver bruker du importerer vil f� tilsendt en email med et tilfeldig passord. Dersom du ikke f�lger disse reglene vil det oppst� problemer som kan kreve manuelt arbeid, s� det l�nner seg � dobbeltsjekke importfilen!',
    26 => 'S�k',
    27 => 'Max Resultater',
    28 => 'Kryss av her for � slette dette bildet',
    29 => 'Sti',
    30 => 'Importer',
    31 => 'Nye Brukere',
    32 => 'Prosessering ferdig. Importerte $successes og $failures feil oppsto',
    33 => 'start',
    34 => 'Feil: Du m� angi en importfil.',
    35 => 'Last Login',
    36 => '(never)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Godkjenn',
    2 => 'Slett',
    3 => 'Rediger',
    4 => 'Profil',
    10 => 'Tittel',
    11 => 'Start Dato',
    12 => 'URL',
    13 => 'Kategori',
    14 => 'Dato',
    15 => 'Emne',
    16 => 'Brukernavn',
    17 => 'Fullt navn',
    18 => 'Email',
    34 => 'Kommando og Kontroll',
    35 => 'Artikkel innlegg',
    36 => 'Lenke innlegg',
    37 => 'Begivenhet innlegg',
    38 => 'Send inn',
    39 => 'Det er ingen innlegg � vurdere n�',
    40 => 'Bruker innlegg'
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
    8 => 'Legg til Begivenhet',
    9 => 'Geeklog Begivenhet',
    10 => 'Begivenheter for',
    11 => 'Master Kalender',
    12 => 'Min Kalender',
    13 => 'Januar',
    14 => 'Februar',
    15 => 'Mars',
    16 => 'April',
    17 => 'Mai',
    18 => 'Juni',
    19 => 'Juli',
    20 => 'August',
    21 => 'September',
    22 => 'Oktober',
    23 => 'November',
    24 => 'Desember',
    25 => 'Tilbake til ',
    26 => 'Hele Dagen',
    27 => 'uke',
    28 => 'Personlig Kalender for',
    29 => 'offentlig Kalender',
    30 => 'slett begivenhet',
    31 => 'Legg til',
    32 => 'Begivenhet',
    33 => 'Dato',
    34 => 'Tid',
    35 => 'Hurtig Legg til',
    36 => 'Send inn',
    37 => 'Beklager, personlige kalendere kan ikke benyttes p� dette nettstedet',
    38 => 'Personlig Begivenhet Editor',
    39 => 'Dag',
    40 => 'Uke',
    41 => 'M�ned'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Mail verkt�y",
    2 => 'Fra',
    3 => 'Svar-til',
    4 => 'Emne',
    5 => 'Innhold',
    6 => 'Send til:',
    7 => 'Alle brukere',
    8 => 'Admin',
    9 => 'Opsjoner',
    10 => 'HTML',
    11 => 'Viktig melding!',
    12 => 'Send',
    13 => 'Reset',
    14 => 'Ignorer brukerinstillinger',
    15 => 'Feil ved sending til: ',
    16 => 'Meldinger ble sendt til: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Send another message</a>",
    18 => 'Til',
    19 => 'MERK: hvis du vil sende en melding til alle medlemmene, velg gruppen innloggede brukere fra nedtrekksmenyen.',
    20 => "<successcount> meldinger ble sendt og <failcount> meldinger feilet.  Detaljene for meldingene som feilet er nedenfor hvis du trenger dem. i motsatt fall kan du  <a href=\"{$_CONF['site_admin_url']}/mail.php\">sende en melding til</a> eller <a href=\"{$_CONF['site_admin_url']}/moderation.php\">g� tilbake til administrasjonssiden</a>.",
    21 => 'Feil',
    22 => 'Vellykkede',
    23 => 'Ingen feil',
    24 => 'Ingen vellykkede',
    25 => '-- Velg Gruppe --',
    26 => 'Vennligst fyll ut alle feltene i skjemaet og  velg en gruppe brukere fra nedtrekksmenyen.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Installasjon av plugins medf�rer en mulighet for skade p�Geeklog installasjonen din og, muligens ogs� systemet ditt. Det er viktig at du kun installerer plugins hentet fra <a href="http://www.geeklog.net" target="_blank">Geeklogs nettsted</a>. Vi tester alle plugins vi mottar grundig p� mange forskjellige operativsystemer. Viktig: installasjon av en plugin krever utf�relse av noen f� systemkommandoer som kan medf�re sikkerhetsproblemer s�rlig hvis du bruker plugins fra andre nettsteder. NB! Denne advarselen medf�rer ingen garanti for at installasjonen av en plugin vil g� smertefritt, ei heller tar vi ansvar for eventuell skade som f�lge av en installasjon. Med andre ord, installer p� egen risiko. For den forsiktige s� f�lger det instruksjoner for manuell installasjon med hver plugin.',
    2 => 'Advarsel for Plug-in Installasjon',
    3 => 'Plug-in Installasjonsskjema',
    4 => 'Plug-in Fil',
    5 => 'Plug-in Liste',
    6 => 'Advarsel: Plug-in er allerede installert!',
    7 => 'Den plug-in du fors�ker � installere finnes allerede. Vennligst slett plug-in f�r du reinstallerer den',
    8 => 'Plugin kompatibilitetssjekk feilet',
    9 => 'Denne plug-in krever en nyere versjon av Geeklog. Du m� enten oppgradere <a href="http://www.geeklog.net">Geeklog</a> eller bruke en nyere versjon av denne plug-in.',
    10 => '<br><b>Ingen plug-in er installert.</b><br><br>',
    11 => 'For � redigere eller slette en plug-in, klikk p� tallet til plug-in under. For � l�re mer om en plug-in, klikk p� plug-in navnet og du g�r til websiden til den plug-in. For � installere eller oppgradere en plug-in vennligst les dokumentasjonen for den aktuelle plug-in.',
    12 => 'plugineditor() kalt uten et plugin navn',
    13 => 'Plugin Editor',
    14 => 'Ny Plug-in',
    15 => 'Admin Hovedside',
    16 => 'Plug-in Navn',
    17 => 'Plug-in Versjon',
    18 => 'Geeklog Versjon',
    19 => 'Aktivisert',
    20 => 'Ja',
    21 => 'Nei',
    22 => 'Installer',
    23 => 'Lagre',
    24 => 'Avbryt',
    25 => 'Slett',
    26 => 'Plug-in Navn',
    27 => 'Plug-in Hjemmeside',
    28 => 'Plug-in Versjon',
    29 => 'Geeklog Versjon',
    30 => 'Slett Plug-in?',
    31 => 'Er du sikker p� at du vil slette denne plug-in? Alle data og datastrukturer som brukes av denne plug-in vil ogs� bli slettet. hvis du er sikker, klikk slett igjen nedenfor.'
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
    1 => "Passordet ditt er sendt p� mail og du vil motta det hvert �yeblikk. Vennligst f�lg instruksjonene i meldingen. Takk for at du bruker {$_CONF['site_name']}",
    2 => "Takk for at du sendte inn artikkelen din til {$_CONF['site_name']}. Den er oversendt til v�r stab for godkjenning. Hvis artikkelen din blir godkjent s�p vil den bli publisert p� nettstedet v�rt slik at andre kan lese den.",
    3 => "Takk for at du sendte inn en lenke til {$_CONF['site_name']}. Den er oversendt til v�r stab for godkjenning. Hvis lenken din blir godkjent vil den vises blant v�re <a href={$_CONF['site_url']}/links.php>lenker</a>.",
    4 => "Takk for at du sendte inn en begivenhet til {$_CONF['site_name']}.  Den er oversendt til v�r stab for godkjenning. Hvis den blir godkjent vil begivenheten din vises i <a href={$_CONF['site_url']}/calendar.php>kalenderen</a>.",
    5 => 'Kontoinformasjonen din ble lagret.',
    6 => 'Dine visningsvalg ble lagret.',
    7 => 'Dine kommentarvalg ble lagret.',
    8 => 'Du er logget ut.',
    9 => 'Din artikkel ble lagret.',
    10 => 'Artikkelen ble slettet.',
    11 => 'Blokken din ble lagret.',
    12 => 'Blokken ble slettet.',
    13 => 'Ditt emne ble lagret.',
    14 => 'Emnet og alle tilh�rende artikler og blokker ble slettet.',
    15 => 'Din lenke ble lagret.',
    16 => 'Lenken ble slettet.',
    17 => 'Din begivenhet ble lagret.',
    18 => 'Begivenheten ble slettet.',
    19 => 'Avstemningen din ble lagret.',
    20 => 'Avstemningen ble slettet.',
    21 => 'Den nye brukeren ble lagret.',
    22 => 'Brukeren ble slettet',
    23 => 'Feil under fors�k p� � legge en begivenhet til kalenderen din. Begivenheten hadde ingen ID.',
    24 => 'Begivenheten ble lagret til kalenderen din',
    25 => 'din personlige kalender kan ikke �pnes f�r du logger inn',
    26 => 'Begivenheten ble fjernet fra din personlige kalender',
    27 => 'Meldingen ble sendt.',
    28 => 'Plug-in ble lagret',
    29 => 'Beklager, personlige kalendere kan ikke benyttes p� dette nettstedet',
    30 => 'Adgang Nektet',
    31 => 'Beklager, du har ikke adgang til artikkel administrasjon. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    32 => 'Beklager, du har ikke adgang til emne administrasjon. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    33 => 'Beklager, du har ikke adgang til blokk administrasjon. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    34 => 'Beklager, du har ikke adgang til lenke administrasjon. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    35 => 'Beklager, du har ikke adgang til begivenhet administrasjon. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    36 => 'Beklager, du har ikke adgang til avstemning administrasjon. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    37 => 'Beklager, du har ikke adgang til bruker administrasjon. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    38 => 'Beklager, du har ikke adgang til plugin administrasjon. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    39 => 'Beklager, du har ikke adgang til mail administrasjon. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    40 => 'Systemmelding',
    41 => 'Beklager, du har ikke tilgang til siden for � administrere ordskifte. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    42 => 'Ordet ditt ble lagret.',
    43 => 'ordet ble slettet.',
    44 => 'Plug-in installert!',
    45 => 'Plug-in slettet.',
    46 => 'Beklager, du har ikke tilgang til sikkerhetskopiering av databasen. Vennligst legg merke til at alle fors�k p� uautorisert tilgang blir logget',
    47 => 'Denne funksjonen virker kun under *nix. Hvis operativsystemet du kj�rer p� er *nix s� er din cache t�mt. Hvis du kj�rer p� windows m� du s�ke etter filer som heter adodb_*.php og slette dem manuelt.',
    48 => "Takk for din s�knad om medlemsskap hos {$_CONF['site_name']}. Teamet v�rt vil vurdere s�knaden din. Hvis s�knaden din blir godkjent, blir passordet ditt sendt til mailadressen du nettopp oppga.",
    49 => 'Gruppen ble lagret.',
    50 => 'Gruppen ble slettet.',
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
    'ownerroot' => 'Eier/Root',
    'group' => 'Gruppe',
    'readonly' => 'Kun-lese',
    'accessrights' => 'Adgangsrettigheter',
    'owner' => 'eier',
    'grantgrouplabel' => 'Gi ovenst�ende gruppe redigeringsrettigheter',
    'permmsg' => 'MERK: medlemmer er alle innloggede medlemmer av nettstedet og anonyme er alle brukere p� nettstedet som ikke er logget inn.',
    'securitygroups' => 'Sikkerhetsgrupper',
    'editrootmsg' => "Selv om du er en Brukeradministrator, s� kan du ikke redigere en root bruker uten at du selv er en root bruker. Du kan redigere alle andre brukere unntatt root brukere. Vennligst legg merke til at alle fors�k p� ulovlig redigering av root brukere blir logget. Vennligst g� tilbake til <a href=\"{$_CONF['site_admin_url']}/user.php\">Bruker administrasjon</a>.",
    'securitygroupsmsg' => 'Kryss av for gruppene du vil at brukeren skal tilh�re.',
    'groupeditor' => 'Gruppe Editor',
    'description' => 'Beskrivelse',
    'name' => 'Navn',
    'rights' => 'Rettigheter',
    'missingfields' => 'Manglende felter',
    'missingfieldsmsg' => 'Du m� angi et navn og en beskrivelse for en gruppe',
    'groupmanager' => 'Gruppe Administrasjon',
    'newgroupmsg' => 'For � endre eller slette en gruppe, klikk p� gruppen under. For � lage en ny gruppe klikk p� ny gruppe ovenfor. Legg merke til at core grupper ikke kan slettes fordi de brukes av systemet.',
    'groupname' => 'Gruppenavn',
    'coregroup' => 'Core gruppe',
    'yes' => 'Ja',
    'no' => 'Nei',
    'corerightsdescr' => "Dette er en core {$_CONF['site_name']} gruppe. Rettighetene for denne gruppen kan ikke redigeres. Nedenfor er en liste over de rettigheter denne gruppen har.",
    'groupmsg' => 'Sikkerhetsgrupper p� dette nettstedet er hierarkiske.  Hvis du legger denne gruppen til en av gruppene under gir du denne gruppen samme rettigheter som de gruppene har. Det anbefales at du bruker gruppene under for � gi rettigheter til en gruppe s� langt det er mulig. dersom denne gruppen trenger mer spesifikke rettigheter s� kan du velge disse fra \'Rettigheter\' nedenfor. For � legge denne gruppen til en av de andre gruppene under, kryss av for de gruppene du �nsker.',
    'coregroupmsg' => "Dette er en core {$_CONF['site_name']} gruppe. Gruppene som denne gruppen h�rer til kan ikke redigeres. Under er en liste over grupper som denne gruppen h�rer til.",
    'rightsdescr' => 'En rettighet kan gis direkte til gruppen, ELLER til en annen gruppe som denne gruppen er medlem av. Rettighetene under som ikke er avkrysset er de som denne gruppen har f�tt som medlem av en annen gruppe. Rettighetene som er avkryyset er rettigheter som er gitt direkte til denne gruppen.',
    'lock' => 'L�s',
    'members' => 'Medlemmer',
    'anonymous' => 'Anonym',
    'permissions' => 'Rettigheter',
    'permissionskey' => 'R = lese, E = rediger, redigeringsrettighet medf�rer leserettighet',
    'edit' => 'Rediger',
    'none' => 'Ingen',
    'accessdenied' => 'Adgang Nektet',
    'storydenialmsg' => "Du har ikke adgang til � se denne artikkelen. Dette kan skyldes at du ikke er medlem av {$_CONF['site_name']}. Vennligst <a href=users.php?mode=new> bli medlem</a> av {$_CONF['site_name']} for � oppn� full tilgang!",
    'eventdenialmsg' => "Du har ikke adgang til � se denne begivenheten. Dette kan skyldes at du ikke er medlem av {$_CONF['site_name']}.  Vennligst <a href=users.php?mode=new> bli medlem</a> av {$_CONF['site_name']} for � oppn� full tilgang!",
    'nogroupsforcoregroup' => 'Denne gruppen h�rer ikke til noen av de andre gruppene',
    'grouphasnorights' => 'Denne gruppen har ikke tilgang til administrative funksjoner p� dette nettstedet',
    'newgroup' => 'Ny Gruppe',
    'adminhome' => 'Admin Hovedside',
    'save' => 'lagre',
    'cancel' => 'avbryt',
    'delete' => 'slett',
    'canteditroot' => 'Du har fors�kt � redigere Root gruppen uten selv � v�re medlem av Root gruppen, tilgangen er derfor nektet. Vennligst kontakt administratoren til nettstedet hvis du mener dette er en feil',
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
    'last_ten_backups' => 'Siste 10 Backups',
    'do_backup' => 'Ta Backup',
    'backup_successful' => 'Backup av databasen var vellykket.',
    'no_backups' => 'Ingen backups i systemet',
    'db_explanation' => 'For � ta en backup av ditt Geeklog system, klikk knappen nedenfor',
    'not_found' => "Feil sti eller mysqldump er ikke kj�rbar.<br>Sjekk <strong>\$_DB_mysqldump_path</strong> definisjonen i config.php.<br>Variabelen er n� satt til: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup feilet: st�rrelsen p� backupfilen var 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} finnes ikke eller er ikke en katalog",
    'no_access' => "FEIL: Katalogen {$_CONF['backup_path']} er ikke tilgjengelig.",
    'backup_file' => 'Backup fil',
    'size' => 'St�rrelse',
    'bytes' => 'Bytes',
    'total_number' => 'Total number of backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Hjem',
    2 => 'Kontakt',
    3 => 'Bli Publisert',
    4 => 'Lenker',
    5 => 'Avstemninger',
    6 => 'Kalender',
    7 => 'Nettsted statistikk',
    8 => 'Personaliser',
    9 => 'S�k',
    10 => 'avansert s�k'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Error',
    2 => 'J�ss, jeg har sett overalt men kan ikke finne <b>%s</b>.',
    3 => "<p>vi beklager, men filen du har bedt om finnes ikke. Sjekk gjerne <a href=\"{$_CONF['site_url']}\">hovedsiden</a> eller <a href=\"{$_CONF['site_url']}/search.php\">s�kesiden</a> for � se om du finner det du har mistet."
);

###############################################################################

$LANG_LOGIN = array(
    1 => 'Innlogging p�krevd',
    2 => 'Beklager, du m� v�re innlogget for � f� adgang til dette omr�det.',
    3 => 'Logg inn',
    4 => 'Ny Bruker'
);

?>
