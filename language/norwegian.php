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

$LANG_CHARSET = "iso-8859-1";

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
	1 => "Gitt av:",
	2 => "les mer",
	3 => "kommentarer",
	4 => "Rediger",
	5 => "stem",
	6 => "Resultater",
	7 => "stemmeresultater",
	8 => "stemmer",
	9 => "Admin Funksjoner:",
	10 => "Innlegg",
	11 => "Artikler",
	12 => "Blokker",
	13 => "Emner",
	14 => "Lenker",
	15 => "Begivenheter",
	16 => "Avstemning",
	17 => "Brukere",
	18 => "SQL Spørring",
	19 => "Logg Ut",
	20 => "Brukerinformasjon:",
	21 => "Brukernavn",
	22 => "Bruker ID",
	23 => "Sikkerhetsnivå",
	24 => "Anonym",
	25 => "Svar",
	26 => "De følgende kommentarer eies av den som skrev dem. Dette nettstedet er ikke ansvarlig for innholdet.",
	27 => "Nyeste Innlegg",
	28 => "Slett",
	29 => "ingen kommentarer.",
	30 => "Eldre Artikler",
	31 => "Lovlige HTML tagger:",
	32 => "Feil, ugyldig brukernavn",
	33 => "Feil, kunne ikke skrive til loggfilen",
	34 => "Feil",
	35 => "Logg ut",
	36 => "på",
	37 => "Ingen artikler fra brukere",
	38 => "",
	39 => "Gjenoppfrisk",
	40 => "",
	41 => "Gjestebrukere",
	42 => "Skrevet av:",
	43 => "Svar på denne",
	44 => "Opphav",
	45 => "MySQL Feil Nummer",
	46 => "MySQL Feilmelding",
	47 => "Brukerfunksjoner",
	48 => "Kontoinformasjon",
	49 => "Visningsvalg",
	50 => "Feil i SQL setning",
	51 => "hjelp",
	52 => "Ny",
	53 => "Admin Hovedside",
	54 => "Kunne ikke åpne filen.",
	55 => "Feil på",
	56 => "stem",
	57 => "Passord",
	58 => "Logg inn",
	59 => "Er du ikke bruker ennå? Registrer deg som en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Ny bruker</a>",
	60 => "Skriv en kommentar",
	61 => "Opprett Ny Konto",
	62 => "ord",
	63 => "Kommentarvalg",
	64 => "Email Artikkelen Til en Venn",
	65 => "Utskriftsvennlig Versjon",
	66 => "Min Kalender",
	67 => "Velkommen til ",
	68 => "hjem",
	69 => "kontakt",
	70 => "søk",
	71 => "bidra",
	72 => "lenker",
	73 => "tidligere avstemninger",
	74 => "kalender",
	75 => "avansert søk",
	76 => "nettsted statistikk",
	77 => "Plugins",
	78 => "Kommende Begivenheter",
	79 => "Nytt",
	80 => "artikler de siste",
	81 => "historie de siste",
	82 => "timer",
	83 => "KOMMENTARER",
	84 => "LENKER",
	85 => "siste 48 timer",
	86 => "ingen nye kommentarer",
	87 => "siste 2 uker",
	88 => "ingen nye lenker",
	89 => "Det er ingen kommende begivenheter",
	90 => "Hjem",
	91 => "Side generert på",
	92 => "sekunder",
	93 => "Opphavsrett",
	94 => "Alle varemerker og opphavsrett på denne siden tilhører de respektive eiere.",
	95 => "Drevet Av",
	96 => "Grupper",
        97 => "Ordliste",
	98 => "Plug-ins",
	99 => "ARTIKLER",
    100 => "ingen nye artikler",
    101 => 'Dine Begivenheter',
    102 => 'Nettstedets Begivenheter',
    103 => 'DB Backups',
    104 => 'av',
    105 => 'Email brukere',
    106 => 'Visninger',
    107 => 'GL Version Test',
    108 => 'Tøm Cache'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Kalender",
	2 => "Beklager, det er ingen begivenheter å vise.",
	3 => "Når",
	4 => "Hvor",
	5 => "Beskrivelse",
	6 => "Legg Til En Begivenhet",
	7 => "Kommende Begivenheter",
	8 => 'Ved å legge denne begivenheten til din kalender, kan du raskt få et overblikk over kun
de begivenheter du er interessert i, ved å trykke på "Min Kalender" i Brukermenyen', 	9 => "Legg Til Min Kalender",
	10 => "Fjern fra Min Kalender",
	11 => "Legger til Begivenhet til {$_USER['username']}'s Kalender",
	12 => "Begivenhet",
	13 => "Starter",
	14 => "Slutter",
        15 => "tilbake til Kalender"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Skriv en Kommentar",
	2 => "Skrivemodus",
	3 => "Logg ut",
	4 => "Lag ny Konto",
	5 => "Brukernavn",
	6 => "Dette nettstedet krever at du er logget inn for å kunne skrive kommentarer, vennligst logg inn. Hvis du ikke er registrert fra før, bruk skjemaet under for å registrere deg som ny bruker.",	7 => "Din siste kommentar var ",
	8 => " sekunder siden. Dette nettstedet krever minst {$_CONF["commentspeedlimit"]} sekunder mellom kommentarer",
	9 => "kommentar",
	10 => '',
	11 => "Post kommentar",
	12 => "vennligst fyll ut Tittel- og Kommentarfeltene, de er obligatoriske for å poste en kommentar.",
 	13 => "Din Informasjon",
	14 => "Forhåndsvisning",
	15 => "",
	16 => "Overskrift",
	17 => "Feil",
	18 => 'Viktig',
	19 => 'Forsøk å holde deg til emnet når du skriver kommentarer.',
	20 => 'Svar på andres kommentarer istedet for å opprette nye diskusjonstråder.',
	21 => 'Les øvrige kommentarer før du poster din egen, for å unngå gjentakelse av det som allerede er blitt sagt.',
	22 => 'Bruk en tydelig overskrift som forteller hva kommentaren din handler om.',
	23 => 'Emailadressen din blir IKKE offentliggjort.',
	24 => 'Anonym Bruker'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Brukerprofil for",
	2 => "Brukernavn",
	3 => "Fullt Navn",
	4 => "Passord",
	5 => "Email",
	6 => "Hjemmeside",
	7 => "Biografi",
	8 => "PGP nøkkel",
	9 => "Lagre Informasjon",
	10 => "Siste 10 kommentarer av bruker",
	11 => "Brukeren har ikke skrevet noen kommentarer",
	12 => "Brukervalg for",
	13 => "Email Nattlig Sammendrag",
	14 => "Dette er et tilfeldig generert passord. Du anbefales å endre passordet omgående. For å endre passordet, logg inn og velg Kontoinformasjon fra Brukermenyen.",
	15 => "Din {$_CONF["site_name"]} er opprettet. For å bruke den må du logge inn med nedenstående opplysninger. Vennligst ta vare på denne mailen for fremtidig referanse.",
	16 => "din Kontoinformasjon",
	17 => "Kontoen eksisterer ikke",
	18 => "Oppgitt emailadresse synes å være ugyldig",
	19 => "Oppgitt brukernavn eller emailadresse finnes fra før",
	20 => "Oppgitt emailadresse synes å være ugyldig",
	21 => "Feil",
	22 => "Opprett konto på {$_CONF['site_name']}!",
	23 => "Ved å opprette en konto på {$_CONF['site_name']} vil du få mulighet til å skrive artikler og kommentarer i dit eget navn. hvis du ikke har en konto, vil du kun delta som anonym. emailadressendu oppgir vil <b><i>aldri</i></b> bli offentlig vist på dette nettstedet.",
	24 => "Passordet ditt blir sendt til den emailadressen du oppgir.",
	25 => "Har du glemt passordet ditt?",
	26 => "skriv inn brukernavnet ditt og trykk på Email Passord, og et nytt passord blir sendt til mailadressen som er registrert for brukeren din.",
	27 => "Opprett Konto Nå!",
	28 => "Email Passord",
	29 => "logged out from",
	30 => "logged in from",
	31 => "Denne funksjonen krever at du er logget inn",
	32 => "Signatur",
	33 => "Blir aldri vist offentlig",
	34 => "Ditt egentlige navn",
	35 => "Skriv inn passord for å endre det",
	36 => "Begynner med http://",
	37 => "Legges til dine kommentarer",
	38 => "Alt om deg! Alle kan lese dette",
	39 => "Din offentlige PGP nøkkel",
	40 => "Ingen Emneikoner",
	41 => "Willing to Moderate",
	42 => "Datoformat",
	43 => "Maksimum Antall Artikler",
	44 => "Ingen Rammer",
	45 => "Visningsvalg for",
	46 => "Ekskluderte Emner og Forfattere for",
	47 => "Konfigurasjon av nyhetsbokser for",
	48 => "Emner",
	49 => "ingen ikoner i artikler",
	50 => "fjern avkryssing hvis du ikke er interessert",
	51 => "Kun nyheter og artikler",
	52 => "Standardverdien er",
	53 => "Motta dagens artikler hver natt",
	54 => "Kryss av for de emner og forfattere du ikke ønsker å se.",
	55 => "Dersom ingen er avkrysset, så får du standardvalget. Hvis dy begynner å krysse av bokser, husk å krysse av for alle du ønsker å se, fordi standardvalget blir ignorert. Standardvalg vises med <b>uthevet</b> skrift.",
	56 => "Forfattere",
	57 => "Visningsmodus",
	58 => "Rekkefølge for sortering",
	59 => "Kommentarbegrensning",
	60 => "Hvordan vil du ha kommentarene vist?",
	61 => "Nyeste eller eldste først?",
	62 => "Standardverdi er 100",
	63 => "Passordet ditt er sendt, og vil snart dukke opp i mailboksen din. Vennligst følg instruksjonen i meldingen du mottar. Vi takker for at du bruker " . $_CONF["site_name"],
	64 => "Kommentarvalg for",
	65 => "Forsøk å logge inn på nytt",
	66 => "Du har kanskje skrevet brukernavn eller passord feil. Forsøk å logge inn igjewn under. er du en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">ny bruker</a>?",
	67 => "Medlem Siden",
	68 => "Husk meg i",
	69 => "Hvor lenge skal vi huske deg etter at du er logget inn?",
	70 => "Tilpass utseendet og innholdet på {$_CONF['site_name']}",
	71 => "En av mulighetene på {$_CONF['site_name']} er at du kan tilpasse innhold, utseeende og layout slik at det passer deg. for å kunne bruke disse funksjonene må du først registrere deg som  <a href=\"{$_CONF['site_url']}/users.php?mode=new\">bruker</a> på {$_CONF['site_name']}. Er du allerede registrert? Da bruker du loginskjemaet til venstre for å logge inn!",
    72 => "Tema",
    73 => "Språk",
    74 => "Endre utseendet på dette nettstedet!",
    75 => "Emailede Emner for",
    76 => "Hvis du velger et eller flere emner fra listen under, så vil du motta alle nye artikler for det enkelte emne ved dagens slutt. Velg kun emner som interesserer deg!",
    77 => "Foto",
    78 => "Legg inn et bilde av deg selv!",
    79 => "Kryss av here for å slette dette bildet",
    80 => "Login",
    81 => "Send Email",
    82 => 'Siste 10 artikler av bruker',
    83 => 'Skrivestatistikk for bruker',
    84 => 'Totalt antall artikler:',
    85 => 'Totalt antall kommentarer:',
    86 => 'Finn alt skrevet av'
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Det er ingen nyheter å vise",
	2 => "Det er ingen artikler å vise. Enten er det ingen nyheter for dette emne, eller så er dine brukervalg for restriktive",
	3 => " for emne $topic",
	4 => "Dagens Hovedoppslag",
	5 => "Neste",
	6 => "Forrige"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Lenker",
	2 => "Det er ingen lenker å vise.",
	3 => "Legg Til En Lenke"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Stemme Lagret",
	2 => "Din stemme er avgitt",
	3 => "Stem",
	4 => "Avstemninger i systemet",
	5 => "Stemmer"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "det oppsto en feil under utsendelse av din melding. Vennligst forsøk på nytt.",
	2 => "Meldingen ble sendt.",
	3 => "Vennligst sjekk at du bruker en gyldig emailadressei Svar Til feltet.",
	4 => "Vennligst fyll ut feltene Ditt Navn, Svar Til, Emne og  Melding",
	5 => "Feil: Bruker finnes ikke.",
	6 => "En feil oppsto.",
	7 => "Brukerprofil for",
	8 => "Brukernavn",
	9 => "Bruker URL",
	10 => "Send email til",
	11 => "Ditt navn:",
	12 => "Svar Til:",
	13 => "Emne:",
	14 => "Melding:",
	15 => "HTML blir ikke oversatt.",
	16 => "Send Melding",
	17 => "Email denne artikkelen til en venn",
	18 => "Til Navn",
	19 => "Til Emailadresse",
	20 => "Fra Navn",
	21 => "Fra Emailadresse",
	22 => "Alle felter må fylles ut",
	23 => "Denne emailen er sendt til deg av $from ($fromemail) fordi vedkommende mener at du kunne være interessert i denne artikkelen fra {$_CONF["site_url"]}. Dette er ikke SPAM (søppelpost) og mailadressene som ble brukt i denne transaksjonen er ikke lagret for senere bruk.",
	24 => "Kommenter denne artikkelen på",
	25 => "Du må være logget inn for å bruke denne funksjonen. Kravet om innlogging hjelper til med å hindre misbruk av systemet",
	26 => "Dette skjemaet lar deg sende en email til valgt bruker. Alle felter må fylles ut.",
	27 => "Kort melding",
	28 => "$from skrev: $shortmsg",
    29 => "Dette er det daglige sammendraget fra {$_CONF['site_name']} for ",
    30 => " Daglig Nyhetsbrev for ",
    31 => "Overskrift",
    32 => "Dato",
    33 => "les hele artikkelen på",
    34 => "Slutt på Melding"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Avansert Søk",
	2 => "Nøkkelord",
	3 => "Emne",
	4 => "Alle",
	5 => "Type",
	6 => "Artikler",
	7 => "Kommentarer",
	8 => "Forfattere",
	9 => "Alle",
	10 => "Søk",
	11 => "Søkeresultater",
	12 => "resultater",
	13 => "Søkeresultat: Ingen samsvar",
	14 => "Det var ingen resultater som svarte til ditt søk etter",
	15 => "Prøv igjen.",
	16 => "emne",
	17 => "Dato",
	18 => "Forfatter",
	19 => "Søk i hele {$_CONF["site_name"]} databasen av nåværende og gamle artikler",
	20 => "Dato",
	21 => "til",
	22 => "(Datoformat YYYY-MM-DD)",
	23 => "Treff",
	24 => "Fant",
	25 => "treff av",
	26 => "mulige på",
	27 => "sekunder",
    28 => 'Ingen treff i artikler eller kommentarer for ditt søk',
    29 => 'Resultater fra Artikler og Kommentarer',
    30 => 'Ingen lenker svarte til ditt søk',
    31 => 'This plug-in returned no matches',
    32 => 'Begivenhet',
    33 => 'URL',
    34 => 'Sted',
    35 => 'Hele dagen',
    36 => 'Ingen begivenheter svarte til ditt søk',
    37 => 'Resultater fra Begivenheter',
    38 => 'Resultater fra Lenker',
    39 => 'Lenker',
    40 => 'Begivenheter',
    41 => 'Søkestrengen din må inneholde minst 3 tegn.',
    42 => 'Datoer må angis på formatet YYYY-MM-DD (år-måned-dag).'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Statistikk for nettstedet",
	2 => "Totalt antall treff i systemet",
	3 => "Artikler(kommentarer) i systemet",
	4 => "Avstemninger(Svar) i systemet",
	5 => "Lenker(klikk) i systemet",
	6 => "Begivenheter i systemet",
	7 => "Topp Ti Viste Artikler",
	8 => "Overskrift",
	9 => "Vist",
	10 => "Det virker som om det ikke er noen artikler på dette nettstedet, eller at ingen har lest dem.",
	11 => "Topp Ti kommenterte Artikler",
	12 => "Kommentarer",
	13 => "Det virker som om det ikke er noen artikler på dette nettstedet, eller at ingen har kommentert dem.",
	14 => "Topp Ti Avstemninger",
	15 => "Spørsmål",
	16 => "stemmer",
	17 => "Det virker som om det ikke er noen avstemninger på dette nettstedet, eller at ingen har stemt.",
	18 => "Topp Ti Lenker",
	19 => "Lenke",
	20 => "Treff",
	21 => "Det virker som om det ikke er noen lenker på dette nettstedet, eller at ingen har klikket på dem.",
	22 => "Topp Ti Artikler sendt via Email",
	23 => "Emails",
	24 => "Det virker som om ingen har emailet en artikkel på dette nettstedet"
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Relatert",
	2 => "Send  artikkelen til en venn",
	3 => "utskriftsvennlig format",
	4 => "Valg"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "Du må være logget inn for å poste en $type.",
	2 => "Logg inn",
	3 => "Ny bruker",
	4 => "Post en begivenhet",
	5 => "Post en lenke",
	6 => "Post en artikkel",
	7 => "Innlogging kreves",
	8 => "Post",
	9 => "Når du poster informasjon på dette nettstedet ber vi om at du følger disse retningslinjene...<ul><li>Alle feltene må fylles ut<li>Gi nøyaktige og komplette opplysninger<li>Dobbeltsjekk URLer</ul>",
	10 => "Overskrift",
	11 => "Lenke",
	12 => "Start Dato",
	13 => "Slutt Dato",
	14 => "Sted",
	15 => "Beskrivelse",
	16 => "Hvis Annen, vennligst angi",
	17 => "Kategori",
	18 => "Annen",
	19 => "Les først",
	20 => "Feil: kategori mangler",
	21 => "Hvis du velger \"Annen\" vennligst angi et navn på kategorien",
	22 => "Feil: felt mangler",
	23 => "Vennligst fyll inn alle feltene.  Alle felt er påkrevd.",
	24 => "Posting lagret",
	25 => "Din posting av en $type er lagret.",
	26 => "Fartsgrense",
	27 => "Brukernavn",
	28 => "Emne",
	29 => "Artikkel",
	30 => "din siste posting var ",
	31 => " sekunder siden.  Dette nettstedet krever minst {$_CONF["speedlimit"]} sekunder mellom postinger",
	32 => "Forhåndsvisning",
	33 => "Forhåndsvis Artikkel",
	34 => "Logg ut",
	35 => "HTML tagger er ulovlig",
	36 => "Posting Modus",
	37 => "Når en begivenhet postes til {$_CONF["site_name"]} så havner den på hovedkalenderen, og andre brukere kan velge å legge den til sin personlige  kalender. Kalenderen er <b>IKKE</b> beregnet for å lagre personlige begivenheter som fødselsdager, jubileum osv.<br><br>Når en begivenhet er postet blir den sendt til våre redaktører, og hvis den blir godkjent havner den på hovedkalenderen.",
    38 => "Legg Begivenhet Til",
    39 => "Hoved Kalender",
    40 => "Personlig Kalender",
    41 => "Slutt Tid",
    42 => "Start Tid",
    43 => "Heldags Begivenhet",
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
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Autentisering kreves",
	2 => "Avvist! Ugyldig brukernavn eller passord",
	3 => "Ugyldig passord for bruker",
	4 => "Brukernavn:",
	5 => "Passord:",
	6 => "All tilgang til administrative deler av nettstedet blir logget og gransket.<br>Denne siden er kun autorisert personell.",
	7 => "logg inn"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Utilstrekkelige Admin Rettigheter",
	2 => "Du har ikke nødvendige rettigheter for å redigere denne blokken.",
	3 => "Blokk Editor",
	4 => "",
	5 => "Blokk Overskrift",
	6 => "Emne",
	7 => "Alle",
	8 => "Blokk Sikkerhetsnivå",
	9 => "Blokk Rekkefølge",
	10 => "Blokk Type",
	11 => "Portal Blokk",
	12 => "Normal Blokk",
	13 => "Portal Blokk Opsjoner",
	14 => "RDF URL",
	15 => "Siste RDF Oppdatering",
	16 => "Normal Blokk Opsjoner",
	17 => "Blokk Innhold",
	18 => "Vennligst fyll ut feltene Overskrift, Sikkerhetsnivå og innhold ",
	19 => "Blokk Bestyrer",
	20 => "Blokk Overskrift",
	21 => "Blokk Sikkerhetsnivå",
	22 => "Blokk Type",
	23 => "Blokk Rekkefølge",
	24 => "Blokk Emne",
	25 => "For å endre eller slette en blokk, klikk på blokkoverskriften under.  For å lage en ny blokk klikk på \"Ny Blokk\" ovenfor.",
	26 => "Layout Blokk",
	27 => "PHP Blokk",
    28 => "PHP Blokk Opsjoner",
    29 => "Blokk Funksjon",
    30 => "Hvis du vil bruke PHP kode i en blokk, skriv inn navnet på funksjonen over.  Navnet på funksjonen må starte med prefikset \"phpblock_\" (feks. phpblock_getweather).  Dersom navnet ikke har dette prefikset, så vil funksjonen IKKE bli kalt.  Vi gjør dette for å forhindre hackere fra å bruke vilkårlige funksjoner (som kan skade systemet), dersom de skulle klare å gjøre innbrudd i Geeklog installasjonen din. forsikre deg om at det ike er tomme paranteser \"()\" etter navnet på funksjonen. Til slutt anbefaler vi at du legger all kode til PHP Blokker i /path/to/geeklog/system/lib-custom.php.  Da unngår du at koden blir overskrevet ved oppgraderinger av Geeklog.",
    31 => 'Feil i PHP Blokk. Funksjonen $function eksisterer ikke.',
    32 => "Feil Felt(er) mangler",
    33 => "Du må skrive inn URLen til .rdf filen for portal blokker",
    34 => "Du må skrive inn overskrift og funksjon for PHP blokker",
    35 => "Du må skrive inn overskrift og innhold for normale blokker",
    36 => "Du må skrive inn the content for layout blocks",
    37 => "Ulovlig funksjonsnavn på PHP blokk",
    38 => "Funksjoner for PHP Blokker må ha prefikset 'phpblock_' (feks. phpblock_getweather). Prefikset 'phpblock_' kreves av sikkerhetsmesige årsaker for å forhindre kjøring av vilkårlig kode..",
	39 => "Side",
	40 => "Venstre",
	41 => "Høyre",
	42 => "du må skrive inn rekkefølge og sikkerhetsnivå for Geeklog standard blokker",
	43 => "Kun hjemmeside",
	44 => "Adgang Nektet",
	45 => "Du forsøker å få tilgang til en blokk som du ikke har rettigheter til. Forsøket er logget. Vennligst <a href=\"{$_CONF["site_admin_url"]}/block.php\">gå tilbake til administrasjonsiden for blokker</a>.",
	46 => 'Ny Blokk',
	47 => 'Admin Hovedside',
    48 => 'Blokk Navn',
    49 => ' (uten mellomrom og må være unikt)',
    50 => 'URL til hjelpefil',
    51 => 'ta med http://',
    52 => 'hvis du lar denne være tom, så vises ikke hjelpeikonet for denne blokken',
    53 => 'Aktivisert',
    54 => 'lagre',
    55 => 'avbryt',
    56 => 'slett'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Begivenhet Editor",
	2 => "",
	3 => "Begivenhet Overskrift",
	4 => "Begivenhet URL",
	5 => "Begivenhet Start Dato",
	6 => "Begivenhet slutt Dato",
	7 => "Begivenhet sted",
	8 => "Begivenhet Beskrivelse",
	9 => "(ta med http://)",
	10 => "Du må ta med dato og tid, beskrivelse og sted!",
	11 => "Begivenhet Bestyrer",
	12 => "For å endre eller slette en begivenhet, klikk på begivenheten under. For å lage en ny begivenhet klikk på Ny Begivenhet ovenfor.",
	13 => "Begivenhet Overskrift",
	14 => "Start Dato",
	15 => "Slutt Dato",
	16 => "Adgang Nektet",
	17 => "Du forsøker å få tilgang til en begivenhet som du ikke har rettigheter til. Forsøket er logget. Vennligst <a href=\"{$_CONF["site_admin_url"]}/event.php\">gå tilbake til administrasjonsiden for begivenheter</a>.",
	18 => 'Ny Begivenhet',
	19 => 'Admin Hovedside',
    20 => 'lagre',
    21 => 'avbryt',
    22 => 'slett'
);

###############################################################################
# link.php

$LANG23 = array(
	1 => "Lenke Editor",
	2 => "",
	3 => "Lenke Overskrift",
	4 => "Lenke URL",
	5 => "Kategori",
	6 => "(ta med http://)",
	7 => "Annen",
	8 => "Lenke Treff",
	9 => "Lenke Beskrivelse",
	10 => "Du må ta med Overskrift, URL og Beskrivelse.",
	11 => "Lenke Administrasjon",
	12 => "for å endre eller slette en lenke, klikk på lenken under. For å  lage en ny lenke klikk på Ny Lenke ovenfor.",
	13 => "Lenke Overskrift",
	14 => "Lenke Kategori",
	15 => "Lenke URL",
	16 => "Adgang Nektet",
	17 => "Du forsøker å få tilgang til en lenke som du ikke har rettigheter til. Forsøket er logget. Vennligst <a href=\"{$_CONF["site_admin_url"]}/link.php\">gå tilbake til administrasjonsiden for lenker</a>.",
	18 => 'Ny Lenke',
	19 => 'Admin Hovedside',
	20 => 'hvis Annen, angi',
    21 => 'lagre',
    22 => 'avbryt',
    23 => 'slett'
);

###############################################################################
# story.php
#
# NOTE: string no. 48 is the "imagex" tag, don't translate it!
#	string no. 49 & 50 are also markers, don't translate them!

$LANG24 = array(
	1 => "Forrige artikler",
	2 => "Neste artikler",
	3 => "Modus",
	4 => "Posting Modus",
	5 => "Artikkel Editor",
	6 => "Det er ingen artikler i systemet",
	7 => "Forfatter",
	8 => "lagre",
	9 => "forhåndsvis",
	10 => "avbryt",
	11 => "slett",
	12 => "",
	13 => "Tittel",
	14 => "Emne",
	15 => "Dato",
	16 => "Introduksjonstekst",
	17 => "Hovedtekst",
	18 => "Treff",
	19 => "Kommentarer",
	20 => "",
	21 => "",
	22 => "Artikkel Liste",
	23 => "For å redigere eller slette en artikkel, klikk på artikkelnummeret under. For å se en artikkel, klikk på tittelen til artikkelen du ønsker å se. For å lage en ny artikkel klikk på Ny Artikkel over.",
	24 => "",
	25 => "",
	26 => "Artikkel forhåndsvisning",
	27 => "",
	28 => "",
	29 => "",
	30 => "",
	31 => "Vennligst fyll ut feltene Forfatter, Tittel og introduksjonstekst",
	32 => "Hovedoppslag",
	33 => "Det kan kun være ett hovedoppslag",
	34 => "Kladd",
	35 => "Ja",
	36 => "Nei",
	37 => "Mer av",
	38 => "Mer fra",
	39 => "Emails",
	40 => "Adgang Nektet",
	41 => "Du forsøker å redigere en artikkel du ikke har adgang til. Forsøket er logget. Du kan lese artikkelen under. Vennligst <a href=\"{$_CONF["site_admin_url"]}/story.php\">gå tilbake til artikkeladministrasjon</a> når du er ferdig.",
	42 => "Du forsøker å se en artikkel du ikke har adgang til. Forsøket er logget. Vennligst <a href=\"{$_CONF["site_admin_url"]}/story.php\">gå tilbake til artikkeladministrasjon</a>.",
	43 => 'Ny Artikkel',
	44 => 'Admin Hovedside',
	45 => 'Adgang',
    46 => '<b>MERK:</b> hvis du endrer datoen til å være i fremtiden, så vil artikkelen ikke bli publisert før datoen intreffer. Det betyr også at artikkelen ikke blir inkludert i RDF oversikten din, og at den blir ignorert av søke- og statistikksidene.',
    47 => 'Bilder',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => 'For å bruke et av bildene du har lagt ved denne artikkelen må du sette inn en bestemt kode i artikkelen.  Koden er  [imageX], [imageX_right] (høyre) eller [imageX_left] (venstre) og X nummeret på bildet du har lagt ved. MERK: Du <b>må</b> bruke alle bildene du legger ved. Hvis ikke får du ikke lagret artikkelen.<BR><P><B>Forhåndsvisning</B>: Forhåndsvisning av e artikkel med bilder gjøres best ved å lagre artikkelen som en kladd, IKKE ved bruk av knappen for forhåndsvisning. Bruk knappen for forhåndsvisning kun på artikler uten bilder.',
    52 => 'Slett',
    53 => 'ble ikke brukt. Du må bruke dette bildet i introduksjonen eller i hovedteksten før du kan lagre endringer.',
    54 => 'Vedlagte bilder ikke brukt',
    55 => 'følgende feil oppsto under forsøk på å lagre artikkelen din. Vennligst rett opp disse feilene før du lagrer',
    56 => 'Vis Emneikon'
);

###############################################################################
# poll.php

$LANG25 = array(
	1 => "Modus",
	2 => "",
	3 => "Avstemning opprettet",
	4 => "Avstemning $qid lagret",
	5 => "Rediger Avstemning",
	6 => "Avstemning ID",
	7 => "(ikke bruk mellomrom)",
	8 => "Vises på hovedside",
	9 => "Spørsmål",
	10 => "Svar / Stemmer",
	11 => "En feil oppsto under henting av svardata for avstemningen $qid",
	12 => "En feil oppsto under henting av spørsmålsdata for avstemningen $qid",
	13 => "Lag Avstemning",
	14 => "lagre",
	15 => "avbryt",
	16 => "slett",
	17 => "",
	18 => "Avstemning Liste",
	19 => "For å redigere eller slette en avstemning, klikk på den. For å lage en ny avstemning klikk på ny avstemning over.",
	20 => "Velgere",
	21 => "Adgang Nektet",
	22 => "Du forsøker å nå en avstemning som du ikke har rettigheter til. forsøket er logget. Vennligst <a href=\"{$_CONF["site_admin_url"]}/poll.php\">gå tilbake til avstemningsadministrasjon</a>.",
	23 => 'Ny Avstemning',
	24 => 'Admin Hovedside',
	25 => 'Ja',
	26 => 'Nei'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Emne Editor",
	2 => "Emne ID",
	3 => "Emne Navn",
	4 => "Emne Bilde",
	5 => "(ikke bruk mellomrom)",
	6 => "Sletting av et emne vil også slette alle artikler og blokker som hører til emnet",
	7 => "Vennligst fyll ut feltene Emne ID og Emne Navn",
	8 => "Emne Administrasjon",
	9 => "For å redigere eller slette et emne, klikk på emnet. For å lage et nytt emne klikk på knappen Nytt Emne til venstre. Adgangsnivået ditt for hvert emne står i parantes",
	10=> "Sorteringsrekkefølge",
	11 => "Artikler/Side",
	12 => "Adgang Nektet",
	13 => "Du forsøker å nå et emne du ikke har rettigheter til. Forsøket er logget. Vennligst <a href=\"{$_CONF["site_admin_url"]}/topic.php\">gå tilbake til emneadministrasjon</a>.",
	14 => "Sorteringsmåte",
	15 => "alfabetisk",
	16 => "standard er",
	17 => "Nytt Emne",
	18 => "Admin Hovedside",
    19 => 'lagre',
    20 => 'avbryt',
    21 => 'slett'
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "Bruker Editor",
	2 => "Bruker ID",
	3 => "Brukernavn",
	4 => "Fullt Navn",
	5 => "Passord",
	6 => "Sikkerhetsnivå",
	7 => "Email Adresse",
	8 => "Hjemmeside",
	9 => "(ikke bruk mellomrom)",
	10 => "Vennligst fyll ut feltene Brukernavn, Fullt Navn, Sikkerhetsnivå og Email Adresse",
	11 => "Bruker Administrasjon",
	12 => "For å endre eller slette en bruker, klikk på brukeren under. For å lage en ny  bruker klikk på Ny Bruker til venstre. Du kan foreta enkle søk ved å skrive inn deler av brukernavn, email adresse eller fullt navn (feks.*sen* or *.no) i søkefeltet under.",
	13 => "SecLev",
	14 => "Reg. Dato",
	15 => 'Ny Bruker',
	16 => 'Admin Hovedside',
	17 => 'EndrePassord',
	18 => 'avbryt',
	19 => 'slett',
	20 => 'lagre',
	18 => 'avbryt',
	19 => 'slett',
	20 => 'lagre',
    21 => 'Brukernavnet du forsøke å lagre finnes allerede.',
    22 => 'Feil',
    23 => 'Masseimport',
    24 => 'Masseimportering av brukere',
    25 => 'Du kan importere en liste med brukere inn i Geeklog. Importfilen må være en tekstfil med felter adskilt med tab-tegn. Feltene må være i følgende rekkefølge: fullt navn, brukernavn, email adresse. Det må være kun en bruker per linje. Hver bruker du importerer vil få tilsendt en email med et tilfeldig passord. Dersom du ikke følger disse reglene vil det oppstå problemer som kan kreve manuelt arbeid, så det lønner seg å dobbeltsjekke importfilen!',
    26 => 'Søk',
    27 => 'Max Resultater',
    28 => 'Kryss av her for å slette dette bildet',
    29 => 'Sti',
    30 => 'Importer',
    31 => 'Nye Brukere',
    32 => 'Prosessering ferdig. Importerte $successes og $failures feil oppsto',
    33 => 'start',
    34 => 'Feil: Du må angi en importfil.'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Godkjenn",
    2 => "Slett",
    3 => "Rediger",
    4 => 'Profil',
    10 => "Tittel",
    11 => "Start Dato",
    12 => "URL",
    13 => "Kategori",
    14 => "Dato",
    15 => "Emne",
    16 => 'Brukernavn',
    17 => 'Fullt navn',
    18 => 'Email',
    34 => "Kommando og Kontroll",
    35 => "Artikkel innlegg",
    36 => "Lenke innlegg",
    37 => "Begivenhet innlegg",
    38 => "Send inn",
    39 => "Det er ingen innlegg å vurdere nå",
    40 => "Bruker innlegg"
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Søndag",
	2 => "Mandag",
	3 => "Tirsdag",
	4 => "Onsdag",
	5 => "Torsdag",
	6 => "Fredag",
	7 => "Lørdag",
	8 => "Legg til Begivenhet",
	9 => "Geeklog Begivenhet",
	10 => "Begivenheter for",
	11 => "Master Kalender",
	12 => "Min Kalender",
	13 => "Januar",
	14 => "Februar",
	15 => "Mars",
	16 => "April",
	17 => "Mai",
	18 => "Juni",
	19 => "Juli",
	20 => "August",
	21 => "September",
	22 => "Oktober",
	23 => "November",
	24 => "Desember",
	25 => "Tilbake til ",
    26 => "Hele Dagen",
    27 => "uke",
    28 => "Personlig Kalender for",
    29 => "offentlig Kalender",
    30 => "slett begivenhet",
    31 => "Legg til",
    32 => "Begivenhet",
    33 => "Dato",
    34 => "Tid",
    35 => "Hurtig Legg til",
    36 => "Send inn",
    37 => "Beklager, personlige kalendere kan ikke benyttes på dette nettstedet",
    38 => "Personlig Begivenhet Editor",
    39 => 'Dag',
    40 => 'Uke',
    41 => 'Måned'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => $_CONF['site_name'] . " Mail verktøy",
 	2 => "Fra",
 	3 => "Svar-til",
 	4 => "Emne",
 	5 => "Innhold",
 	6 => "Send til:",
 	7 => "Alle brukere",
 	8 => "Admin",
	9 => "Opsjoner",
	10 => "HTML",
 	11 => "Viktig melding!",
 	12 => "Send",
 	13 => "Reset",
 	14 => "Ignorer brukerinstillinger",
 	15 => "Feil ved sending til: ",
	16 => "Meldinger ble sendt til: ",
	17 => "<a href=" . $_CONF["site_admin_url"] . "/mail.php>Send another message</a>",
    18 => "Til",
    19 => "MERK: hvis du vil sende en melding til alle medlemmene, velg gruppen innloggede brukere fra nedtrekksmenyen.",
    20 => "<successcount> meldinger ble sendt og <failcount> meldinger feilet.  Detaljene for meldingene som feilet er nedenfor hvis du trenger dem. i motsatt fall kan du  <a href=\"" . $_CONF['site_admin_url'] . "/mail.php\">sende en melding til</a> eller <a href=\"" . $_CONF['site_admin_url'] . "/moderation.php\">gå tilbake til administrasjonssiden</a>.",
    21 => 'Feil',
    22 => 'Vellykkede',
    23 => 'Ingen feil',
    24 => 'Ingen vellykkede',
    25 => '-- Velg Gruppe --',
    26 => "Vennligst fyll ut alle feltene i skjemaet og  velg en gruppe brukere fra nedtrekksmenyen."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Passordet ditt er sendt på mail og du vil motta det hvert øyeblikk. Vennligst følg instruksjonene i meldingen. Takk for at du bruker " . $_CONF["site_name"],
	2 => "Takk for at du sendte inn artikkelen din til {$_CONF["site_name"]}. Den er oversendt til vår stab for godkjenning. Hvis artikkelen din blir godkjent såp vil den bli publisert på nettstedet vårt slik at andre kan lese den.",
	3 => "Takk for at du sendte inn en lenke til {$_CONF["site_name"]}. Den er oversendt til vår stab for godkjenning. Hvis lenken din blir godkjent vil den vises blant våre <a href={$_CONF["site_url"]}/links.php>lenker</a>.",
	4 => "Takk for at du sendte inn en begivenhet til {$_CONF["site_name"]}.  Den er oversendt til vår stab for godkjenning. Hvis den blir godkjent vil begivenheten din vises i <a href={$_CONF["site_url"]}/calendar.php>kalenderen</a>.",
	5 => "Kontoinformasjonen din ble lagret.",
	6 => "Dine visningsvalg ble lagret.",
	7 => "Dine kommentarvalg ble lagret.",
	8 => "Du er logget ut.",
	9 => "Din artikkel ble lagret.",
	10 => "Artikkelen ble slettet.",
	11 => "Blokken din ble lagret.",
	12 => "Blokken ble slettet.",
	13 => "Ditt emne ble lagret.",
	14 => "Emnet og alle tilhørende artikler og blokker ble slettet.",
	15 => "Din lenke ble lagret.",
	16 => "Lenken ble slettet.",
	17 => "Din begivenhet ble lagret.",
	18 => "Begivenheten ble slettet.",
	19 => "Avstemningen din ble lagret.",
	20 => "Avstemningen ble slettet.",
	21 => "Den nye brukeren ble lagret.",
	22 => "Brukeren ble slettet",
	23 => "Feil under forsøk på å legge en begivenhet til kalenderen din. Begivenheten hadde ingen ID.",
	24 => "Begivenheten ble lagret til kalenderen din",
	25 => "din personlige kalender kan ikke åpnes før du logger inn",
	26 => "Begivenheten ble fjernet fra din personlige kalender",
	27 => "Meldingen ble sendt.",
	28 => "Plug-in ble lagret",
	29 => "Beklager, personlige kalendere kan ikke benyttes på dette nettstedet",
	30 => "Adgang Nektet",
	31 => "Beklager, du har ikke adgang til artikkel administrasjon. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
	32 => "Beklager, du har ikke adgang til emne administrasjon. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
	33 => "Beklager, du har ikke adgang til blokk administrasjon. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
	34 => "Beklager, du har ikke adgang til lenke administrasjon. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
	35 => "Beklager, du har ikke adgang til begivenhet administrasjon. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
	36 => "Beklager, du har ikke adgang til avstemning administrasjon. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
	37 => "Beklager, du har ikke adgang til bruker administrasjon. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
	38 => "Beklager, du har ikke adgang til plugin administrasjon. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
	39 => "Beklager, du har ikke adgang til mail administrasjon. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
	40 => "Systemmelding",
    41 => "Beklager, du har ikke tilgang til siden for å administrere ordskifte. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
    42 => "Ordet ditt ble lagret.",
	43 => "ordet ble slettet.",
    44 => 'Plug-in installert!',
    45 => 'Plug-in slettet.',
    46 => "Beklager, du har ikke tilgang til sikkerhetskopiering av databasen. Vennligst legg merke til at alle forsøk på uautorisert tilgang blir logget",
    47 => "Denne funksjonen virker kun under *nix. Hvis operativsystemet du kjører på er *nix så er din cache tømt. Hvis du kjører på windows må du søke etter filer som heter adodb_*.php og slette dem manuelt.",
    48 => 'Takk for din søknad om medlemsskap hos ' . $_CONF['site_name'] . '. Teamet vårt vil vurdere søknaden din. Hvis søknaden din blir godkjent, blir passordet ditt sendt til mailadressen du nettopp oppga.',
    49 => "Gruppen ble lagret.",
    50 => "Gruppen ble slettet."
);

// for plugins.php

$LANG32 = array (
	1 => "Installasjon av plugins medfører en mulighet for skade påGeeklog installasjonen din og, muligens også systemet ditt. Det er viktig at du kun installerer plugins hentet fra <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklogs nettsted</a>. Vi tester alle plugins vi mottar grundig på mange forskjellige operativsystemer. Viktig: installasjon av en plugin krever utførelse av noen få systemkommandoer som kan medføre sikkerhetsproblemer særlig hvis du bruker plugins fra andre nettsteder. NB! Denne advarselen medfører ingen garanti for at installasjonen av en plugin vil gå smertefritt, ei heller tar vi ansvar for eventuell skade som følge av en installasjon. Med andre ord, installer på egen risiko. For den forsiktige så følger det instruksjoner for manuell installasjon med hver plugin.",
	2 => "Advarsel for Plug-in Installasjon",
	3 => "Plug-in Installasjonsskjema",
	4 => "Plug-in Fil",
	5 => "Plug-in Liste",
	6 => "Advarsel: Plug-in er allerede installert!",
	7 => "Den plug-in du forsøker å installere finnes allerede. Vennligst slett plug-in før du reinstallerer den",
	8 => "Plugin kompatibilitetssjekk feilet",
	9 => "Denne plug-in krever en nyere versjon av Geeklog. Du må enten oppgradere <a href=\"http://www.geeklog.net\">Geeklog</a> eller bruke en nyere versjon av denne plug-in.",
	10 => "<br><b>Ingen plug-in er installert.</b><br><br>",
	11 => "For å redigere eller slette en plug-in, klikk på tallet til plug-in under. For å lære mer om en plug-in, klikk på plug-in navnet og du går til websiden til den plug-in. For å installere eller oppgradere en plug-in vennligst les dokumentasjonen for den aktuelle plug-in.",
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
    31 => 'Er du sikker på at du vil slette denne plug-in? Alle data og datastrukturer som brukes av denne plug-in vil også bli slettet. hvis du er sikker, klikk slett igjen nedenfor.'
);

$LANG_ACCESS = array(
	access => "Adgang",
    ownerroot => "Eier/Root",
    group => "Gruppe",
    readonly => "Kun-lese",
	accessrights => "Adgangsrettigheter",
	owner => "eier",
	grantgrouplabel => "Gi ovenstående gruppe redigeringsrettigheter",
	permmsg => "MERK: medlemmer er alle innloggede medlemmer av nettstedet og anonyme er alle brukere på nettstedet som ikke er logget inn.",
	securitygroups => "Sikkerhetsgrupper",
	editrootmsg => "Selv om du er en Brukeradministrator, så kan du ikke redigere en root bruker uten at du selv er en root bruker. Du kan redigere alle andre brukere unntatt root brukere. Vennligst legg merke til at alle forsøk på ulovlig redigering av root brukere blir logget. Vennligst gå tilbake til <a href=\"{$_CONF["site_admin_url"]}/user.php\">Bruker administrasjon</a>.",
	securitygroupsmsg => "Kryss av for gruppene du vil at brukeren skal tilhøre.",
	groupeditor => "Gruppe Editor",
	description => "Beskrivelse",
	name => "Navn",
 	rights => "Rettigheter",
	missingfields => "Manglende felter",
	missingfieldsmsg => "Du må angi et navn og en beskrivelse for en gruppe",
	groupmanager => "Gruppe Administrasjon",
	newgroupmsg => "For å endre eller slette en gruppe, klikk på gruppen under. For å lage en ny gruppe klikk på ny gruppe ovenfor. Legg merke til at core grupper ikke kan slettes fordi de brukes av systemet.",
	groupname => "Gruppenavn",
	coregroup => "Core gruppe",
	yes => "Ja",
	no => "Nei",
	corerightsdescr => "Dette er en core {$_CONF["site_name"]} gruppe. Rettighetene for denne gruppen kan ikke redigeres. Nedenfor er en liste over de rettigheter denne gruppen har.",
	groupmsg => "Sikkerhetsgrupper på dette nettstedet er hierarkiske.  Hvis du legger denne gruppen til en av gruppene under gir du denne gruppen samme rettigheter som de gruppene har. Det anbefales at du bruker gruppene under for å gi rettigheter til en gruppe så langt det er mulig. dersom denne gruppen trenger mer spesifikke rettigheter så kan du velge disse fra 'Rettigheter' nedenfor. For å legge denne gruppen til en av de andre gruppene under, kryss av for de gruppene du ønsker.",
	coregroupmsg => "Dette er en core {$_CONF["site_name"]} gruppe. Gruppene som denne gruppen hører til kan ikke redigeres. Under er en liste over grupper som denne gruppen hører til.",
	rightsdescr => "En rettighet kan gis direkte til gruppen, ELLER til en annen gruppe som denne gruppen er medlem av. Rettighetene under som ikke er avkrysset er de som denne gruppen har fått som medlem av en annen gruppe. Rettighetene som er avkryyset er rettigheter som er gitt direkte til denne gruppen.",
	lock => "Lås",
	members => "Medlemmer",
	anonymous => "Anonym",
	permissions => "Rettigheter",
	permissionskey => "R = lese, E = rediger, redigeringsrettighet medfører leserettighet",
	edit => "Rediger",
	none => "Ingen",
	accessdenied => "Adgang Nektet",
	storydenialmsg => "Du har ikke adgang til å se denne artikkelen. Dette kan skyldes at du ikke er medlem av {$_CONF["site_name"]}. Vennligst <a href=users.php?mode=new> bli medlem</a> av {$_CONF["site_name"]} for å oppnå full tilgang!",
	eventdenialmsg => "Du har ikke adgang til å se denne begivenheten. Dette kan skyldes at du ikke er medlem av {$_CONF["site_name"]}.  Vennligst <a href=users.php?mode=new> bli medlem</a> av {$_CONF["site_name"]} for å oppnå full tilgang!",
	nogroupsforcoregroup => "Denne gruppen hører ikke til noen av de andre gruppene",
	grouphasnorights => "Denne gruppen har ikke tilgang til administrative funksjoner på dette nettstedet",
	newgroup => 'Ny Gruppe',
	adminhome => 'Admin Hovedside',
	save => 'lagre',
	cancel => 'avbryt',
	delete => 'slett',
	canteditroot => 'Du har forsøkt å redigere Root gruppen uten selv å være medlem av Root gruppen, tilgangen er derfor nektet. Vennligst kontakt administratoren til nettstedet hvis du mener dette er en feil'	
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Ord utskiftning editor",
    wordid => "Ord ID",
    intro => "For å redigere eller slette, klikk på ordet. For å opprette et nytt ord klikk på knappen Nytt Ord til venstre.",
    wordmanager => "Ord Administrasjon",
    word => "Ord",
    replacmentword => "Erstatningsord",
    newword => "Nytt Ord"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Siste 10 Backups',
    do_backup => 'Ta Backup',
    backup_successful => 'Backup av databasen var vellykket.',
    no_backups => 'Ingen backups i systemet',
    db_explanation => 'For å ta en backup av ditt Geeklog system, klikk knappen nedenfor',
    not_found => "Feil sti eller mysqldump er ikke kjørbar.<br>Sjekk <strong>\$_DB_mysqldump_path</strong> definisjonen i config.php.<br>Variabelen er nå satt til: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Backup feilet: størrelsen på backupfilen var 0 bytes',
    path_not_found => "{$_CONF['backup_path']} finnes ikke eller er ikke en katalog",
    no_access => "FEIL: Katalogen {$_CONF['backup_path']} er ikke tilgjengelig.",
    backup_file => 'Backup fil',
    size => 'Størrelse',
    bytes => 'Bytes'
);

$LANG_BUTTONS = array(
    1 => "Hjem",
    2 => "Kontakt",
    3 => "Bli Publisert",
    4 => "Lenker",
    5 => "Avstemninger",
    6 => "Kalender",
    7 => "Nettsted statistikk",
    8 => "Personaliser",
    9 => "Søk",
    10 => "avansert søk"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "Jøss, jeg har sett overalt men kan ikke finne <b>%s</b>.",
    3 => "<p>vi beklager, men filen du har bedt om finnes ikke. Sjekk gjerne <a href=\"{$_CONF['site_url']}\">hovedsiden</a> eller <a href=\"{$_CONF['site_url']}/search.php\">søkesiden</a> for å se om du finner det du har mistet."
);

$LANG_LOGIN = array (
    1 => 'Innlogging påkrevd',
    2 => 'Beklager, du må være innlogget for å få adgang til dette området.',
    3 => 'Logg inn',
    4 => 'Ny Bruker'
);

?>
