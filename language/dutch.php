<?php

###############################################################################
# dutch.php
#
# This is a complete dutch language page for GeekLog!
# Please contact Fred <Fred@sc-dtk.nl> if you think anything
# important is missing ...
#
# Ported to level 1.3.8 by W. Niemans <niemans@pbsolo.nl>
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
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
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
#                    XX - file id number
#                    YY - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# common.php

$LANG01 = array(
    1 => "Bijdrage van:",
    2 => "lees verder",
    3 => "reacties",
    4 => "Wijzigen",
    5 => "Stem",
    6 => "Tussenstand",
    7 => "Peilingsuitslag",
    8 => "stemmen",
    9 => "Beheerdersmenu:",
    10 => "Ter beoordeling",
    11 => "Artikelen",
    12 => "Blokken",
    13 => "Thema's",
    14 => "Links",
    15 => "Evenementen",
    16 => "Peilingen",
    17 => "Gebruikers",
    18 => "SQL Query",
    19 => "Uitloggen",
    20 => "Uw gegevens:",
    21 => "Gebruikersnaam",
    22 => "Gebruikers ID",
    23 => "Beveiligingsniveau",
    24 => "Anoniem",
    25 => "Reageer",
    26 => "De volgende reacties zijn voor verantwoording van degene die ze heeft geplaatst. Dit portaal is niet verantwoordelijk voor de inhoud.",
    27 => "Laatste plaatsingen",
    28 => "Verwijderen",
    29 => "Geen reacties.",
    30 => "Oudere artikelen",
    31 => "Toegestane HTML Tags:",
    32 => "Fout: ongeldige gebruikersnaam",
    33 => "Fout: kan niet naar logbestand schrijven",
    34 => "Fout",
    35 => "Uitloggen",
    36 => "aan",
    37 => "Geen artikelen",
    38 => "",
    39 => "vernieuwen",
    40 => "",
    41 => "Gast(en)",
    42 => "Geschreven door:",
    43 => "Hierop reageren",
    44 => "Parent",
    45 => "MySQL Error Number",
    46 => "MySQL Error Message",
    47 => "Gebruikersmenu",
    48 => "Account informatie",
    49 => "Voorkeuren",
    50 => "Fout in SQL statement",
    51 => "help",
    52 => "Nieuw",
    53 => "Beheerder Home",
    54 => "Kan bestand niet openen.",
    55 => "Fout in",
    56 => "Stem",
    57 => "Wachtwoord",
    58 => "Inloggen",
    59 => "Heeft u nog geen account? <br> Meld u dan <b>nu</b> aan als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nieuwe gebruiker</a>",
    60 => "Geef commentaar",
    61 => "Aanmelden nieuw account",
    62 => "woorden",
    63 => "Artikel weergave",
    64 => "Email artikel naar collega",
    65 => "afdruk versie",
    66 => "Mijn Kalender",
    67 => "Welkom bij ",
    68 => "home",
    69 => "contact",
    70 => "zoeken",
    71 => "uw Bijdrage",
    72 => "Web Latijn",
    73 => "Opinie's",
    74 => "Kalender",
    75 => "gericht Zoeken",
    76 => "Statistieken",
    77 => "Plugins",
    78 => "Komende evenementen",
    79 => "Wat is nieuw",
    80 => "artikelen in de laatste",
    81 => "artikel in de laatste",
    82 => "uren",
    83 => "REACTIES",
    84 => "LINKS",
    85 => "afgelopen 48 uur",
    86 => "Geen nieuwe reacties",
    87 => "afgelopen 2 weken",
    88 => "Geen recente nieuwe links",
    89 => "Er zijn geen komende evenementen",
    90 => "Home",
    91 => "Deze pagina is aangemaakt in",
    92 => "seconden",
    93 => "Copyright",
    94 => "Alle merknamen en copyrights op deze pagina zijn eigendom van hun respectievelijke eigenaren.",
    95 => "Bemotord met",
    96 => "Groepen",
    97 => "Woorden lijst",
    98 => "Plug-ins",
    99 => "ARTIKELEN",
    100 => "Geen nieuwe artikelen",
    101 => "Uw evenementen",
    102 => "Portaal evenementen",
    103 => "DB Backups",
    104 => "door",
    105 => "Email gebruikers",
    106 => "Opgevraagd",
    107 => "GL Versie Test",
    108 => "Leeg Cache"
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => "Evenementen Kalender",
    2 => "Helaas. Er zijn geen evenementen om weer te geven.",
    3 => "Wanneer",
    4 => "Waar",
    5 => "Omschrijving",
    6 => "Voeg evenement toe",
    7 => "Komende evenementen",
    8 => "Door evenementen aan <b>uw</b> kalender toe te voegen, kunt u de voor u interessante evenementen verzamelen en snel inzien door op 'Mijn Kalender' te klikken in het Gebruikersmenu.",
    9 => "Voeg toe aan 'Mijn Kalender'",
    10 => "Verwijder van 'Mijn Kalender'",
    11 => "Voeg evenment toe aan {$_USER['username']}'s Kalender",
    12 => "Evenement",
    13 => "Begint",
    14 => "Eindigt",
    15 => "Terug naar Kalender"
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => "Verstuur een reactie",
    2 => "Opmaak",
    3 => "Uitloggen",
    4 => "Aanmelden account",
    5 => "Gebruikersnaam",
    6 => "Het portaal vereist dat u bent ingelogd om een reactie te versturen: log in a.u.b. Echter, indien u geen account heeft, kunt u het onderstaande formulier gebruiken om u aan te melden.",
    7 => "Uw laatste reactie was ",
    8 => " seconden geleden. Een beveiliging vereist tenminste {$_CONF["commentspeedlimit"]} seconden tussen reacties",
    9 => "Reactie",
    10 => "",
    11 => "Verstuur reactie",
    12 => "Vul a.u.b. de velden bij 'Titel' en 'Reactie' in. Deze zijn noodzakelijk voor het versturen van een reactie.",
    13 => "Uw informatie",
    14 => "Preview",
    15 => "",
    16 => "Titel",
    17 => "Fout",
    18 => "Niet vergeten",
    19 => "Houdt u a.u.b. bij het onderwerp.",
    20 => "Probeer eerst op reactie's van anderen te reageren i.p.v. een nieuwe 'Thread' te starten.",
    21 => "Lees ook de andere berichten voordat u uw bericht gaat versturen. Dit, om te voorkomen dat vele identieke berichten ontstaan.",
    22 => "Gebruik een helder onderwerp, dat uw bericht juist omschrijft.",
    23 => "Uw email adres zal NIET worden weergegeven.",
    24 => "Anonieme gebruiker"
);

###############################################################################
# users.php

$LANG04 = array(
    1 => "Gebruikersprofiel voor",
    2 => "GebruikersNaam",
    3 => "Volledige Naam",
    4 => "Wachtwoord",
    5 => "Emailadres",
    6 => "Homepage",
    7 => "Bio/CV",
    8 => "PGP Code",
    9 => "Bewaar Informatie",
    10 => "Laatste 10 reacties van gebruiker",
    11 => "Geen reacties",
    12 => "Voorkeuren voor",
    13 => "Email 's nachts verwerken",
    14 => "Dit wachtwoord is gegenereerd door een zgn. randomizer. Het wordt aanbevolen om dit wachtwoord meteen te wijzigen. Om het wachtwoord te wijzigen, log in en klik op 'Account informatie' van het 'Gebruikersmenu'.",
    15 => "Uw {$_CONF["site_name"]} account is aangemaakt. Om er gebruik van te maken, dient u in te loggen met gebruik van de onderstaande informatie. Bewaar dit bericht a.u.b. voor gebruik in de toekomst.",
    16 => "Uw account informatie",
    17 => "Account bestaat niet",
    18 => "Het email adres lijkt geen bestaand adres",
    19 => "De gebruikersnaam of email adres is al in gebruik",
    20 => "Het email adres lijkt geen juist email adres",
    21 => "Fout",
    22 => "Registreren bij {$_CONF['site_name']}!",
    23 => "Door het aanmaken van een account profiteert u van alle voordelen van {$_CONF['site_name']} portaal lidmaadschap en geeft u de mogelijkheid reacties en artikelen onder uw eigen naam te plaatsen. Indien u niet registreert, is dit alleen anoniem mogelijk. Let op, uw email adres zal <b><i>nooit</i></b> publiekelijk worden weergegeven op het portaal.",
    24 => "Uw wachtwoord wordt verstuurd naar het email adres dat u invoert.",
    25 => "Wachtwoord vergeten?",
    26 => "Vul uw gebruikersnaam in en klik op 'Email wachtwoord' en een nieuw wachtwoord wordt verstuurd naar het opgeslagen email adres.",
    27 => "Registreer Nu!",
    28 => "Email wachtwoord",
    29 => "Uitgelogd van",
    30 => "Ingelogd van",
    31 => "De Functie die wilt gebruiken, is alleen beschikbaar indien u bent ingelogd",
    32 => "Ondertekening",
    33 => "Nooit publiekelijk weergeven",
    34 => "Dit is uw *echte* naam",
    35 => "Vul wachtwoord in om deze te mogen wijzigen",
    36 => "Begint met http://",
    37 => "Toevoegen bij uw reacties",
    38 => "Het is aan U! Iedereeen kan dit lezen",
    39 => "Uw openbare PGP key ",
    40 => "Geen iconen voor Thema's tonen",
    41 => "Beschikbaar voor moderator",
    42 => "Datum formaat",
    43 => "Maximum artikelen",
    44 => "Geen blokken",
    45 => "Toon voorkeuren voor",
    46 => "Uitgesloten 'Items' voor",
    47 => "Nieuws blok instelling voor",
    48 => "Thema's",
    49 => "Geen iconen in artikelen",
    50 => "Afvinken indien u geen interesse heeft",
    51 => "Alleen de nieuwe artikelen",
    52 => "Standaard is 10",
    53 => "Ontvang de artikelen van overdag elke nacht",
    54 => "Vink de thema's en auteurs aan die NIET wilt zien.",
    55 => "Als u ze allemaal heeft afgevinkt, betekent dit dat u de standaard selektie wilt zien. Als u begint te selekteren, selekteer dan alles dat u wilt zien, omdat de standaardinstellingen worden genegeerd. Standaardinstellingen worden vet weergegeven.",
    56 => "Auteurs",
    57 => "Weergave",
    58 => "Sorteer volgorde",
    59 => "Reactie limiet",
    60 => "Hoe wilt u dat reacties worden weergegeven?",
    61 => "Nieuwste of oudste eerst?",
    62 => "Standaard is 100",
    63 => "Uw wachtwoord is naar u verstuurd, en zou op dit moment moeten arriveren. Volg a.u.b. de aanwijzingen in het bericht. Het wordt gewaardeerd, dat u gebruik maakt van " . $_CONF["site_name"],
    64 => "Voorkeurinstellingen voor Reacties van",
    65 => "Probeer opnieuw in te loggen",
    66 => "U heeft mischien een tikfout gemaakt bij het inloggen. Probeer het hieronder opnieuw. Bent u een <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nieuwe gebruiker</a>?",
    67 => "Aangemeld sinds",
    68 => "Mijn gegevens onthouden",
    69 => "Hoe lang mogen we u onthouden nadat u bent ingelogd?",
    70 => "Pas de layout en inhoud aan van {$_CONF['site_name']}",
    71 => "Een mogelijkheid van {$_CONF['site_name']} is dat u de inhoud en de layout van wat u ontvangt kan aanpassen. Om van deze voorzieningen gebruik te maken dient u zich eerst te <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registeren</a> bij {$_CONF['site_name']}. Bent u al geregistreerd? Gebruik dan het login formulier, links om in te loggen!",
    72 => "Skin",
    73 => "Taal",
    74 => "Pas het portaal aan uw wensen aan!",
    75 => "Email thema's voor",
    76 => "Indien u een thema uit de onderstaande lijst selecteert, ontvangt u elk artikel dat hier wordt geplaatst aan het eind van de dag thuis gestuurd. Kies alleen de thema's waarin u bent geïnteresseerd!",
    77 => "Foto",
    78 => "Voeg een afbeelding toe van u zelf!",
    79 => "Aanvinken om uw afbeelding te verwijderen",
    80 => "Inloggen",
    81 => "Verstuur email",
    82 => 'Laatste 10 artikelen van gebruiker',
    83 => 'Statistiek Plaatsingen van gebruiker',
    84 => 'Totaal aantal artikelen:',
    85 => 'Totaal aantal commentaren/reacties:',
    86 => 'Vindt alle bijdragen van',
    87 => 'Uw login naam',
    88 => 'Iemand (waarschijnlijk uzelf) heeft een nieuw wachtwoord voor uw account "%s" aangevraagd op ' . $_CONF['site_name'] . ', <' . $_CONF['site_url'] . ">.\n\nIndien u dit daadwerkelijk wilt, klik dan op de volgende link:\n\n",
    89 => "Indien u hier niet mee accoord gaat kunt u dit bericht negeren; de aanvraag wordt weer verwijderd (uw huidige wachtwoord blijft geldig).\n\n",
    90 => 'Gelieve een nieuw wachtwoord voor uw account hieronder in te vullen. Bemerk dat uw huidige wachtwoord nog steeds geldig is totdat dit formulier verstuurd is.',
    91 => 'Geef nieuw wachtwoord op',
    92 => 'Toets nieuw wachtwoord',
    93 => 'Uw laatste aanvraag voor een nieuw wachtwoord is %d seconden geleden. Het portaal vereist dat er minimaal %d seconden tussen dergelijke aanvragen verstrijken.',
    94 => 'Verwijder Account "%s"',
    95 => 'Klik op "Verwijder Account" hieronder om uw account uit de database te verwijderen. Merk op dat uw gepubliceerde artikelen en uw geplaatste reacties <strong>niet</strong> verwijderd worden, maar getoond worden als "Anonymous".',
    96 => 'verwijder account',
    97 => 'Bevestig het verwijderen van uw Account',
    98 => 'Weet u zeker dat uw account verwijderd moet worden? U bent daarna niet meer in staat in te loggen op dit portaal (tenzij u zelf weer aanmeldt). Indien de gevolgen u duidelijk zijn, klik dan nogmaals op "verwijder account" in het formulier hieronder.',
    99 => 'Privacy Opties voor',
    100 => 'Email van Beheerder',
    101 => 'Accepteer email van beheerder(s)',
    102 => 'Email van Gebruikers',
    103 => 'Accepteer email van andere gebruikers',
    104 => 'Toon Online Status',
    105 => 'Vermeld me in het blok Who\'s Online'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => "Geen Nieuws om weer te geven",
    2 => "Er zijn geen nieuwe artikelen om weer te geven. Er is mischien geen nieuws onder dit thema, of u bent hier niet voor geauthoriseerd.",
    3 => "voor thema $topic",
    4 => "Hoofdartikel",
    5 => "Volgende",
    6 => "Vorige"
);

###############################################################################
# links.php

$LANG06 = array(
    1 => "Web Latijn",
    2 => "Er zijn geen nieuwe Links om weer te geven.",
    3 => "Voeg een Link toe"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => "Stem opgeslagen",
    2 => "Uw stem voor de peiling is opgeslagen",
    3 => "Stem",
    4 => "Peilingen in het portaal",
    5 => "Stemmen",
    6 => "Toon andere peilingen"
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => "Er is een fout opgetreden bij het verzenden van het bericht. Probeer het opnieuw.",
    2 => "Bericht met succes verzonden.",
    3 => "Controleer of het juiste email adres is ingevuld in het veld 'Antwoord naar'.",
    4 => "Vul de velden in: uw naam, antwoord naar, onderwerp, en bericht",
    5 => "Fout: deze gebruiker bestaat niet.",
    6 => "Er is een fout opgetreden.",
    7 => "Gebruikersprofiel voor",
    8 => "Gebruiker Naam",
    9 => "Gebruiker URL",
    10 => "Stuur email naar",
    11 => "Uw naam:",
    12 => "Antwoord naar:",
    13 => "Onderwerp:",
    14 => "Bericht:",
    15 => "HTML wordt niet geconverteerd.",
    16 => "Bericht versturen",
    17 => "Email artikel naar collega",
    18 => "Naam naar",
    19 => "Email adres naar",
    20 => "Naam van",
    21 => "Email adres van",
    22 => "Alle velden zijn vereist",
    23 => "Deze email is verstuurd door $from at $fromemail om u op de hoogte te brengen van dit artikel van {$_CONF["site_url"]}. Dit is geen SPAM en de email adressen in dit bericht zijn NIET nergens anders opgeslagen dan in dit bericht zelf.",
    24 => "Reageer op dit artikel bij",
    25 => "U moet ingelogd zijn, om van deze mogelijkheid gebruik te kunnen maken. Doordat u ingelogd bent, kan worden voorkomen dat er misbruik van het portaal wordt gemaakt",
    26 => "Dit formulier geeft u de mogelijkheid om een email naar de geselekteerde gebruiker te sturen. Alle velden zijn vereist.",
    27 => "Kort bericht",
    28 => "$from schreef: $shortmsg",
    29 => "Dit is het dagelijks overzicht van {$_CONF['site_name']} voor ",
    30 => " Dagelijkse niewsbrief voor ",
    31 => "Titel",
    32 => "Datum",
    33 => "Lees het volledige artikel bij",
    34 => "Eind van het Bericht",
    35 => 'Helaas. Deze gebruiker accepteert geen email.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => "Gericht Zoeken",
    2 => "Trefwoorden",
    3 => "Thema",
    4 => "Alle",
    5 => "Type",
    6 => "Artikelen",
    7 => "Reacties",
    8 => "Auteurs",
    9 => "Alle",
    10 => "Zoek",
    11 => "Zoek resultaten",
    12 => "gevonden",
    13 => "Zoek resultaten: niets gevonden",
    14 => "Er is niets gevonden bij het zoeken naar",
    15 => "Probeer opnieuw.",
    16 => "Titel",
    17 => "Datum",
    18 => "Auteur",
    19 => "Zoek in de gehele {$_CONF["site_name"]} database van nieuwe en oude artikelen",
    20 => "Datum",
    21 => "tot",
    22 => "(Datum Formaat JJJJ-MM-DD)",
    23 => "Hits",
    24 => "Gevonden",
    25 => "gevonden voor",
    26 => "items in",
    27 => "seconden",
    28 => "Geen artikel of reactie komt overeen met uw zoekopdracht",
    29 => "Artikel en reactie resultaten",
    30 => "Geen link komt overeen met uw zoekopdracht",
    31 => "Deze plug-in gaf geen resultaat",
    32 => "Evenement",
    33 => "URL",
    34 => "Locatie",
    35 => "Gehele Dag",
    36 => "Geen evenement komt overeen met uw zoekopdracht",
    37 => "Evenement Resultaat",
    38 => "Link Resultaat",
    39 => "Links",
    40 => "Evenementen",
    41 => 'het trefwoord dient minimaal 3 tekens te bevatten.',
    42 => 'Gelieve een datum op te geven in het formaat JJJJ-MM-DD (jaar-maand-dag).',
    43 => 'exacte zinsnede',
    44 => 'alle woorden',
    45 => 'enig woord',
    46 => 'Volgende',
    47 => 'Vorige',
    48 => 'Auteur',
    49 => 'Datum',
    50 => 'Treffers',
    51 => 'Link',
    52 => 'Locatie',
    53 => 'Artikel Resultaten',
    54 => 'Reactie Resultaten',
    55 => 'de zoekterm',
    56 => 'EN',
    57 => 'OF'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => "Portaal statistieken",
    2 => "Totaal aantal treffers in het portaal",
    3 => "Artikelen (Reacties) in het portaal",
    4 => "Peilingen (Stemmen) in het portaal",
    5 => "Links (Klikken) in het portaal",
    6 => "Evenementen in het portaal",
    7 => "Top Tien opgevraagde artikelen",
    8 => "Artikel titel",
    9 => "Opgevraagd",
    10 => "Het lijkt erop dat er geen artikelen op deze site staan, of ze zijn nooit opgevraagd.",
    11 => "Top Tien Artikelen met meeste reacties",
    12 => "Reacties",
    13 => "Het lijkt erop dat er geen artikelen op deze site staan, of er is nooit op gereageerd.",
    14 => "Top Tien Peilingen",
    15 => "Peiling vragen",
    16 => "Stemmen",
    17 => "Het lijkt erop dat er geen peilingen op deze site staan, of er is nog nooit gestemd.",
    18 => "Top Tien Links",
    19 => "Links",
    20 => "Hits",
    21 => "Het lijkt erop dat er geen links op deze site staan, of ze zijn nooit aangeklikt.",
    22 => "Top Tien Artikelen via email",
    23 => "Emails",
    24 => "Het lijkt erop dat er geen artikelen op deze site staan, of niemand is er op geabonneerd"
);

###############################################################################
# article.php

$LANG11 = array(
    1 => "Gerelateerd",
    2 => "Email artikel naar collega",
    3 => "Afdrukversie artikel",
    4 => "Artikel opties"
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "Om een $type voor te stellen, is het vereist om als gebruiker te zijn ingelogd.",
    2 => "Inloggen",
    3 => "Nieuwe gebruiker",
    4 => "Stel een Evenement voor",
    5 => "Stel een Link voor",
    6 => "Stel een Artikel voor",
    7 => "Inloggen is vereist",
    8 => "Voorstellen",
    9 => "Indien u informatie voorstelt voor gebruik op dit portaal, vragen we de volgende suggesties te volgen...<ul><li>Vul alle velden in. Deze zijn vereist.</li><li>Lever complete en accurate informatie</li><li>Controleer deze URLs dubbel</li></ul>",
    10 => "Titel",
    11 => "Link",
    12 => "Start Datum",
    13 => "Eind Datum",
    14 => "Locatie",
    15 => "Omschrijving",
    16 => "Indien anders, specificeer a.u.b.",
    17 => "Categorie",
    18 => "Anders",
    19 => "Lees dit eerst",
    20 => "Fout: Geen Categorie ingevuld",
    21 => "Indien 'Anders' geselekteerd: lever dan een ook een categorie naam",
    22 => "Fout: niet alle velden Ingevuld",
    23 => "Vul alle velden van het formulier in. Alle velden zijn vereist.",
    24 => "Voorstel opgeslagen",
    25 => "Uw $type voorstel is succesvol opgeslagen.",
    26 => "Snelheids limiet",
    27 => "Gebruikersnaam",
    28 => "Thema",
    29 => "Artikel",
    30 => "Uw laatste bijdrage was ",
    31 => " seconden geleden. Het portaal vereist ten minste {$_CONF["speedlimit"]} seconden tussen twee voorstellen voor plaatsing",
    32 => "Preview",
    33 => "Artikel preview",
    34 => "Uitloggen",
    35 => "HTML tags zijn niet toegestaan",
    36 => "Opmaak",
    37 => "Een voorstel voor plaatsing van een evenement op {$_CONF["site_name"]}, plaatst deze in de hoofdkalender waar gebruikers de optie hebben om deze aan hun persoonlijke kalender toe te voegen. Deze voorziening is <b>NIET</b> bedoeld voor persoonlijke evenementen, zoals verjaardagen en jubilea.<br><br>Als u een voorstel voor een evenement doet, wordt deze verstuurt naar een beheerder en indien goedgekeurd, verschijnt deze in de hoofdkalender.",
    38 => "Voeg Evenement toe aan",
    39 => "Hoofdkalender",
    40 => "Persoonlijke Kalender",
    41 => "Eind Tijd",
    42 => "Begin Tijd",
    43 => "Gehele Dag",
    44 => "Adres regel 1",
    45 => "Adres regel 2",
    46 => "Plaats",
    47 => "Provincie",
    48 => "Postcode",
    49 => "Evenement Type",
    50 => "Wijzig Evenement Types",
    51 => "Locatie",
    52 => "Verwijderen",
    53 => 'Aanmelden account'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
    1 => "Authorisatie is vereist",
    2 => "Geweigerd! Incorrecte Login informatie",
    3 => "Geen juist wachtwoord voor gebruiker",
    4 => "Gebruikersnaam:",
    5 => "Wachtwoord:",
    6 => "Alle toegang tot administratieve functies van het portaal wordt vastgelegd en later bekeken.<br>Deze pagina is alleen voor geautoriseerde gebruikers.",
    7 => "inloggen"
);

###############################################################################
# block.php

$LANG21 = array(
    1 => "Onvoldoende rechten",
    2 => "U bent niet geauthoriseerd om dit blok te wijzigen.",
    3 => "Blok Editor",
    4 => "",
    5 => "Blok titel",
    6 => "Thema",
    7 => "Overal",
    8 => "Blok beveiligingsniveau",
    9 => "Blok volgorde",
    10 => "Blok Type",
    11 => "Portaal Blok",
    12 => "Normaal Blok",
    13 => "Portaal Blok opties",
    14 => "RDF URL",
    15 => "Laatste RDF Update",
    16 => "Normaal Blok opties",
    17 => "Blok Inhoud",
    18 => "Vult u a.u.b. de velden in bij 'Blok Titel', 'beveiliginsniveau' en 'Inhoud'",
    19 => "Blok Manager",
    20 => "Blok Titel",
    21 => "Beveiliginsniveau",
    22 => "Blok Type",
    23 => "Blok Volgorde",
    24 => "Blok Thema",
    25 => "Om een blok te wijzigen of te verwijderen, klikt u op dat blok hieronder. Om een nieuw blok aan te maken klikt u op 'nieuw blok' hierboven.",
    26 => "Layout Blok",
    27 => "PHP Blok",
    28 => "PHP Blok opties",
    29 => "Blok Menu",
    30 => "Indien u PHP code wenst te gebruiken in een van de blokken, vul dan de naam van de php-funktie hierboven in. Deze naam moet beginnen met de prefix 'phpblock_' (e.g. phpblock_hello_world). Zonder deze prefix wordt de funktie NIET aangeroepen. Dit is een beveiligingsmaatregel om niet zomaar willekeurige kode te moeten accepteren, die wellicht de integriteit kunnen schaden.<br>Zorg er ook voor dat er 'lege haakjes' \"()\" staan achter de funktienaam.<br>Tenslotte: het wordt aanbevolen dat alle PHP-blok-code in /pad/naar/geeklog/system/lib-custom.php wordt opgenomen. Bij nieuwe versies blijft de code gehandhaafd.",
    31 => "Fout in PHP Blok. Funktie, $function, bestaat niet.",
    32 => "Fout: niet alle velden doorgegeven.",
    33 => "Er wordt een URL gevraagd voor het .rdf bestand (portaal blokken)",
    34 => "Gelieve de titel en de funktie voor PHP blokken op te geven.",
    35 => "Gelieve de titel en de inhoud op te geven (normale blokken)",
    36 => "Gelieve de inhoud op te geven (layout blokken)",
    37 => "Ongeldige PHP blok funktienaam",
    38 => "Funktie voor PHP blokken moeten de prefix 'phpblock_' (e.g. phpblock_hello_world) bevatten. Deze prefix is vereist ter beveiliging: het voorkomt de uitvoering van willekeurige PHP-code.",
    39 => "Zijde",
    40 => "Links",
    41 => "Rechts",
    42 => "Gelieve de blokvolgorde en het beveiligingsniveau op te geven (standaard blokken).",
    43 => "Alleen Homepagina",
    44 => "Geen toegang",
    45 => "U heeft geprobeerd een blok op te roepen zonder geldige authorisatie. De poging is vastgelegd. <a href=\"{$_CONF["site_url"]}/admin/block.php\">Terug naar de blok administratie pagina</a>.",
    46 => "Nieuw blok",
    47 => "Beheerder Home",
    48 => "Blok Naam",
    49 => " (zonder spaties en verplicht unieke naam)",
    50 => "Help File URL",
    51 => "include http://",
    52 => "Indien u dit niet invult, verschijnt er geen help icon in dit blok.",
    53 => "Opname Toestaan",
    54 => "opslaan",
    55 => "annuleren",
    56 => "verwijderen"
);

###############################################################################
# event.php

$LANG22 = array(
    1 => "Evenement Editor",
    2 => "",
    3 => "Evenement Titel",
    4 => "Evenement URL",
    5 => "Start Datum",
    6 => "Eind Datum",
    7 => "Evenement Locatie",
    8 => "Evenement Beschrijving",
    9 => "(include http://)",
    10 => "Gelieve de datums/tijden te vermelden alsmede de velden in te vullen bij Beschrijving en Locatie!",
    11 => "Evenement Manager",
    12 => "Om een evenement te wijzigen of te verwijderen, klik dan op dat evenement hieronder. Om een evenement aan te maken, klik dan op 'Nieuw Evenement' hierboven.",
    13 => "Evenement Titel",
    14 => "Start Datum",
    15 => "Einde Datum",
    16 => "Geen toegang",
    17 => "U heeft geprobeerd een evenement op te roepen zonder geldige authorisatie. De poging is vastgelegd. <a href=\"{$_CONF["site_url"]}/admin/event.php\">Terug naar de evenement administratie pagina</a>.",
    18 => "Nieuw Evenement",
    19 => "Beheerder Home",
    20 => 'opslaan',
    21 => 'annuleren',
    22 => 'verwijderen'
);

###############################################################################
# link.php

$LANG23 = array(
    1 => "Link Editor",
    2 => "",
    3 => "Link Titel",
    4 => "Link URL",
    5 => "Categorie",
    6 => "(include http://)",
    7 => "Anders",
    8 => "Link Treffers",
    9 => "Link Beschrijving",
    10 => "Gelieve een link Titel, URL and Beschrijving op te geven.",
    11 => "Link Manager",
    12 => "Om een link te wijzigen, klik op die link hieronder. Om een nieuwe link aan te leggen, klik op 'Nieuwe Link' hierboven.",
    13 => "Link Titel",
    14 => "Link Categorie",
    15 => "Link URL",
    16 => "Geen toegang",
    17 => "U heeft geprobeerd een link op te roepen zonder geldige authorisatie. De poging is vastgelegd. <a href=\"{$_CONF["site_url"]}/admin/link.php\">Terug naar de link administratie pagina</a>.",
    18 => "Nieuwe Link",
    19 => "Beheerder Home",
    20 => "Indien u kiest voor 'Anders', a.u.b. specificeren",
    21 => 'opslaan',
    22 => 'annuleren',
    23 => 'verwijderen'
);

###############################################################################
# story.php

$LANG24 = array(
    1 => "Vorige Artikelen",
    2 => "Volgende Artikelen",
    3 => "Opties",
    4 => "Opmaak",
    5 => "Artikel Editor",
    6 => "Er bestaan (nog) geen Artikelen in het portaal",
    7 => "Auteur",
    8 => "opslaan",
    9 => "preview",
    10 => "annuleren",
    11 => "verwijderen",
    12 => "",
    13 => "Titel",
    14 => "Thema",
    15 => "Datum",
    16 => "Introductie Tekst",
    17 => "Body Tekst",
    18 => "Treffers",
    19 => "Opmerkingen",
    20 => "",
    21 => "",
    22 => "Artikel Lijst",
    23 => "Om een Artikel te wijzigen of te verwijderen, klik op het betreffende artikelnummer hieronder. Om een artikel op te roepen, klik op de titel van het betreffende Artikel. Om een nieuw Artikel aan te leggen, klik op 'Nieuw Artikel' hierboven.",
    24 => "",
    25 => "",
    26 => "Artikel Preview",
    27 => "",
    28 => "",
    29 => "",
    30 => "",
    31 => "Gelieve de Auteur, Titel en Introductie Tekst te vermelden.",
    32 => "HoofdArtikel",
    33 => "Er kan slechts een enkel HoofdArtikel actief zijn !!",
    34 => "Draft",
    35 => "Ja",
    36 => "Nee",
    37 => "Meer door..",
    38 => "Meer van..",
    39 => "Emails",
    40 => "Geen toegang",
    41 => "U heeft geprobeerd een artikel op te roepen zonder geldige authorisatie. De poging is vastgelegd. Het Artikel is hieronder weergegeven. <a href=\"{$_CONF["site_url"]}/admin/story.php\">Terug naar de artikel administratie pagina</a>.",
    42 => "U heeft geprobeerd een artikel op te roepen zonder geldige authorisatie. De poging is vastgelegd. <a href=\"{$_CONF["site_url"]}/admin/story.php\">Terug naar de artikel administratie pagina</a>.",
    43 => "Nieuw Artikel",
    44 => "Beheerder Home",
    45 => "Toegang",
    46 => "<b>NOTE:</b> indien de datum in de toekomst ligt, wordt het Artikel pas op die datum gepubliceerd. Dat houdt tevens in dat het artikel niet in de RDF headline feed opgenomen wordt en dat de zoek funktie het buiten beschouwing laat. Er zijn dan ook geen statistieken.",
    47 => "Beelden",
    48 => "beeld",
    49 => "rechts",
    50 => "links",
    51 => "Om de beelden die hier ingesloten zijn, in het Artikel op te nemen is speciaal geformatteerde tekst nodig. Kies uit: [imageX], [imageX_right] or [imageX_left] en vervang de X door het nummer van het beeld dat u bijsluit. NOTE: Bijgesloten beelden MOETEN gebruikt worden. Indien u dat vergeet kan het Artikel niet opgeslagen worden.<BR><P><B>PREVIEW</B>: Het is gemakkelijker een Preview van een Artikel met beelden op te roepen NADAT het opgeslagen is in draft-vorm, IN PLAATS VAN direkt de preview knop aan te klikken. Gebruik de preview knop alleen indien er geen beelden bijgesloten zijn.",
    52 => "Verwijderen",
    53 => "werd niet vermeld. Dit beeld MOET opgenomen worden in de introductie of Body voordat uw werk opgeslagen kan worden.",
    54 => "Bijgesloten beelden zijn niet opgenomen in tekst",
    55 => "De hierna volgende problemen zijn opgetreden bij het opslaan van uw artikel. Gelieve deze op te lossen en daarna opnieuw op te slaan.",
    56 => "Toon Thema Icon",
    57 => 'Toon beeld in originele grootte'
);

###############################################################################
# poll.php

$LANG25 = array(
    1 => "Opties",
    2 => "",
    3 => "Peiling aangemaakt",
    4 => "Peiling $qid opgeslagen",
    5 => "Wijzigen Peiling",
    6 => "Peiling ID",
    7 => "(zonder spaties)",
    8 => "Verschijnt op Homepagina",
    9 => "Vraag",
    10 => "Reacties / Stemmen",
    11 => "Er is een probleem opgetreden met de Peiling database $qid (poll answer data)",
    12 => "Er is een probleem opgetreden met de Peiling database $qid (poll question data)",
    13 => "Peiling aanmaken",
    14 => "opslaan",
    15 => "annuleren",
    16 => "verwijderen",
    17 => "",
    18 => "Peiling Lijst",
    19 => "Om een Peilig te wijzigen of te verwijderen, klik op de betreffende Peiling. Om een nieuwe peiling aan te leggen, klik op 'Nieuwe Peiling' hierboven.",
    20 => "Stemmers",
    21 => "Geen toegang",
    22 => "U heeft geprobeerd een peiling op te roepen zonder geldige authorisatie. De poging is vastgelegd. <a href=\"{$_CONF["site_url"]}/admin/poll.php\">Terug naar de peiling administratie pagina</a>.",
    23 => "Nieuwe Peiling",
    24 => "Beheerder Home",
    25 => "Ja",
    26 => "Nee"
);

###############################################################################
# topic.php

$LANG27 = array(
    1 => "Thema Editor",
    2 => "Thema ID",
    3 => "Thema Naam",
    4 => "Thema Beeld",
    5 => "(zonder spaties)",
    6 => "Het verwijderen van een Thema is recursief. Alle bijbehorende Artikelen en Blokken worden tevens verwijderd",
    7 => "Gelieve het Thema ID en de Thema Naam in te vullen.",
    8 => "Thema Manager",
    9 => "Om een Thema te wijzigen of te verwijderen, klik op het betreffende Thema. Uw toegangsniveau voor ieder Thema staat daar tussen haakjes.<br>Om een nieuw Thema aan te leggen, klik op 'Nieuw Thema' hierboven.",
    10=> "Sorteer Volgorde",
    11 => "Artikelen/Pagina",
    12 => "Geen toegang",
    13 => "U heeft geprobeerd een Thema op te roepen zonder geldige authorisatie. De poging is vastgelegd. <a href=\"{$_CONF["site_url"]}/admin/topic.php\">Terug naar de Thema administratie pagina</a>.",
    14 => "Sorteer Methode",
    15 => "alphabetisch",
    16 => "standaard is",
    17 => "Nieuw Thema",
    18 => "Beheerder Home",
    19 => 'opslaan',
    20 => 'annuleren',
    21 => 'verwijderen',
    22 => 'Standaard',
    23 => 'Verhef dit thema tot standaard voor nieuwe artikelen',
    24 => '(*)'
);

###############################################################################
# user.php

$LANG28 = array(
    1 => "Gebruiker Editor",
    2 => "Gebruiker ID",
    3 => "Gebruiker Naam",
    4 => "Volledige Naam",
    5 => "Wachtwoord",
    6 => "Toegangs Niveau",
    7 => "Email adres",
    8 => "Homepagina",
    9 => "(zonder spaties)",
    10 => "Gelieve de Gebruiker Naam, Volledige naam, toegangsniveau en emailadres in te vullen.",
    11 => "Gebruiker Manager",
    12 => "Om een Gebruiker te wijzigen of te verwijderen, klik op de betreffende Gebruiker hieronder. Om een nieuwe Gebruiker aan te leggen, klik op 'Nieuwe Gebruiker' hierboven. Er kan eenvoudig gezocht worden op delen van een Gebruiker Naam, email adres of van de Volledige naam (e.g.*sen* or *.nl).",
    13 => "ToegangsNiveau",
    14 => "Reg. Datum",
    15 => "Nieuwe Gebruiker",
    16 => "Beheerder Home",
    17 => "wachtwoord wijzigen",
    18 => "annuleren",
    19 => "verwijderen",
    20 => "opslaan",
    21 => "De gebruikernaam bestaat reeds.",
    22 => "Fout",
    23 => "In Batch Toevoegen",
    24 => "Batch Import van Gebruikers",
    25 => "Een batch met gebruikers kan geimporteerd worden. Het import bestand is dan een tab-delimited tekst bestand en heeft de velden in de volgende layout: Volledige Naam, gebruikersnaam, email adres. Aan elke zo toegevoegde Gebruiker wordt daarna een email verstuurd met een willekeurig wachtwoord. Slechts een enkel Gebruiker per regel! Het niet volgen van deze instructies veroorzaakt problemen die uitsluitend met handwerk opgelost kunnen worden. Dubbelcheck de invullingen !!",
    26 => "Zoek",
    27 => "Limiteer Resultaten",
    28 => "Vink aan om dit beeld te verwijderen",
    29 => 'Pad',
    30 => 'Import',
    31 => 'Nieuwe Gebruiker',
    32 => 'Klaar met verwerken. $successes geimporteerd en $failures geweigerd',
    33 => 'submit',
    34 => 'Fout: specificeer een bestand voor upload.',
    35 => 'Laatste Login',
    36 => '(nooit)'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Goedkeuren",
    2 => "Verwijderen",
    3 => "Wijzigen",
    4 => 'Profiel',
    10 => "Titel",
    11 => "Start Datum",
    12 => "URL",
    13 => "Categorie",
    14 => "Datum",
    15 => "Thema",
    16 => 'Gebruiker naam',
    17 => 'Volledige naam',
    18 => 'Email',
    34 => "Moderator Menu",
    35 => "Voorgedragen Artikel(en)",
    36 => "Voorgedragen Link(s)",
    37 => "Voorgedragen Evenement(en)",
    38 => "Submit",
    39 => "Er is niets te modereren op dit moment",
    40 => "Voorgedragen Gebruiker(s)"
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => "Zondag",
    2 => "Maandag",
    3 => "Dinsdag",
    4 => "Woensdag",
    5 => "Donderdag",
    6 => "Vrijdag",
    7 => "Zaterdag",
    8 => "Evenement Toevoegen",
    9 => "Portaal evenement",
    10 => "Evenementen voor",
    11 => "Hoofdkalender",
    12 => "Mijn Kalender",
    13 => "Januari",
    14 => "Februari",
    15 => "Maart",
    16 => "April",
    17 => "Mei",
    18 => "Juni",
    19 => "Juli",
    20 => "Augustus",
    21 => "September",
    22 => "Oktober",
    23 => "November",
    24 => "December",
    25 => "Terug naar",
    26 => "Gehele Dag",
    27 => "Week",
    28 => "Persoonlijke Kalender voor",
    29 => "Publieke Kalender",
    30 => "verwijder evenement",
    31 => "Voeg toe",
    32 => "Evenement",
    33 => "Datum",
    34 => "Tijd",
    35 => "Snel toevoegen",
    36 => "Voorstellen",
    37 => "Helaas. De persoonlijke kalender optie is niet beschikbaar op het portaal",
    38 => "Persoonlijke Evenementen Editor",
    39 => 'Dag',
    40 => 'Week',
    41 => 'Maand'
);

###############################################################################
# admin/mail.php
$LANG31 = array(
    1 => $_CONF['site_name'] . " Email Utility",
    2 => "From",
    3 => "Reply-to",
    4 => "Subject",
    5 => "Body",
    6 => "Send to:",
    7 => "All users",
    8 => "Admin",
    9 => "Options",
    10 => "HTML",
    11 => "Urgent message!",
    12 => "Send",
    13 => "Reset",
    14 => "Instellingen van de gebruiker negeren",
    15 => "Probleem tijdens verzending naar: ",
    16 => "Bericht met succes gezonden naar: ",
    17 => "<a href=" . $_CONF["site_url"] . "/admin/mail.php>Stuur nog een bericht</a>",
    18 => "To",
    19 => "NOTE: Indien u een bericht wilt sturen aan alle portaal leden, kies dan de 'Logged-in' groep.",
    20 => "<successcount> berichten verstuurd en <failcount> fouten. Onderstaand vindt u de details van elk bericht ter contrle. U kunt nu ook <a href=\"" . $_CONF['site_url'] . "/admin/mail.php\">nog een bericht versturen</a> of <a href=\"" . $_CONF['site_url'] . "/admin/moderation.php\">terug gaan naar de administratie pagina</a>.",
    21 => "Fouten",
    22 => "Succes",
    23 => "Geen fouten",
    24 => "Niets verstuurd",
    25 => '-- Selekteer Group --',
    26 => "Gelieve alle velden van het formulier in te vullen en tevens een groep gebruikers te kiezen."
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
    1 => "Uw wachtwoord is naar u verstuurd, en kan elk moment in uw inbox arriveren. Volg a.u.b. de instructies in het bericht, en we bedanken u voor het gebruik maken van " . $_CONF["site_name"],
    2 => "Bedankt voor uw bijdrage aan {$_CONF["site_name"]}. Het is aan een beheerder aangeboden voor plaatsing. Indien geschikt bevonden, wordt het geplaatst op het portaal.",
    3 => "Bedankt voor uw bijdrage aan {$_CONF["site_name"]}. Het is aan een beheerder aangeboden voor plaatsing. Indien geschikt bevonden, zal uw link geplaatst worden in het <a href={$_CONF["site_url"]}/links.php>links</a> gedeelte.",
    4 => "Bedankt voor uw bijdrage aan {$_CONF["site_name"]}. Het is aan een beheerder aangeboden voor plaatsing. Indien geschikt bevonden, zal uw evenement geplaatst worden in het <a href={$_CONF["site_url"]}/calendar.php>Kalendar</a> gedeelte.",
    5 => "Uw account informatie is opgeslagen.",
    6 => "Uw voorkeuren zijn opgeslagen.",
    7 => "Uw instellingen voor commentaar/reactie zijn opgeslagen.",
    8 => "U bent met succes uitgelogd.",
    9 => "Het artikel is opgeslagen.",
    10 => "Het artikel is verwijderd.",
    11 => "Het blok is opgeslagen.",
    12 => "Het blok is verwijderd.",
    13 => "Het thema is opgeslagen.",
    14 => "Het thema, en al de bijbehorende artikelen zijn verwijderd.",
    15 => "De link is opgeslagen.",
    16 => "De link is verwijderd.",
    17 => "Het evenement is opgeslagen.",
    18 => "Het evenement is verwijderd.",
    19 => "Uw peiling is opgeslagen.",
    20 => "Uw peiling is verwijderd.",
    21 => "De nieuwe gebruiker is opgeslagen.",
    22 => "De gebruiker is verwijderd",
    23 => "Er is een fout opgetreden bij het toevoegen van een evenement aan uw kalender. Er is geen evenement id aangemaakt.",
    24 => "Het evenement is toegevoegd aan uw kalender",
    25 => "U kan uw persoonlijke kalender pas openen als u bent ingelogd",
    26 => "Het evenement is verwijderd van uw persoonlijke kalender",
    27 => "Bericht verstuurd.",
    28 => "De plug-in is opgeslagen",
    29 => "Helaas. Persoonlijke kalenders zijn niet geactiveerd op dit portaal",
    30 => "Toegang Geweigerd",
    31 => "Helaas. U heeft geen toegang tot de artikel administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    32 => "Helaas. U heeft geen toegang tot de thema administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    33 => "Helaas. U heeft geen toegang tot de blok administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    34 => "Helaas. U heeft geen toegang tot de links administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    35 => "Helaas. U heeft geen toegang tot de evenementen administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    36 => "Helaas. U heeft geen toegang tot de peilingen administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    37 => "Helaas. U heeft geen toegang tot de gebruiker administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    38 => "Helaas. U heeft geen toegang tot de plug-in administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    39 => "Helaas. U heeft geen toegang tot de email administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    40 => "Portaal Bericht",
    41 => "Helaas. U heeft geen toegang tot de woordvervang administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    42 => "Het woord is opgeslagen.",
    43 => "Het woord is verwijderd.",
    44 => "De plug-in is ingevoegd!",
    45 => "De plug-in is verwijderd.",
    46 => "Helaas. U heeft geen toegang tot Database Backup Utility. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    47 => "Deze funktie werkt allen onder *nix. Indien u *nix gebruikt als besturingsysteem dan is uw cache geleegd. Indien u Windows gebruikt, moet u zoeken naar bestanden als adodb_*.php en deze handmatig verwijderen.",
    48 => 'Bedankt voor uw aanvraag voor een gebruikersaccount van ' . $_CONF['site_name'] . '. De beheerders zullen uw aanvraag balloteren. Indien goedgekeurd, wordt uw wachtwoord naar het email adres verstuurd dat u net heeft ingevuld.',
    49 => "De groep is opgeslagen.",
    50 => "De groep is verwijderd.",
    51 => 'Deze gebruikersnaam is al in gebruik. Kies a.u.b. een andere.',
    52 => 'Het opgegeven email adres lijkt niet geldig te zijn.',
    53 => 'Het nieuwe wachtwoord is geaccepteerd. Gelieve hieronder opnieuw in te loggen, a.u.b.',
    54 => 'De aanvraag voor een nieuw wachtwoord is verjaard. Gelieve dit hieronder opnieuw aan te vragen.',
    55 => 'Een email is naar u verstuurd en zal in korte tijd bij u binnenkomen. Gelieve de instructies in dat bericht op te volgen.',
    56 => 'Het opgegeven email adres is reeds in gebruik bij een ander account. Dit is beveiligd.',
    57 => 'Uw account is met succes verwijderd.'
);

// for plugins.php

$LANG32 = array (
    1 => "Het installeren van plugins kan het portaal als geheel beschadigen en, mogelijk ook, de achterliggende databases. Het is zeer belangrijk dat u alleen plugins van <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> instaleerd, omdat deze degelijk getest zijn. Het is ook belangrijk dat u inziet dat de installatie enige 'onveilige' commando's bevat die kunnen leiden tot beveiligingsproblemen. Dit vergt byzondere aandacht voor plugins van derden. Zelfs indien u deze waarschuwing ter harte neemt, kan de veiligheid en correctheid van de installatieprocedure niet gegarandeerd worden. De verantwoordelijkheid ligt exclusief bij U! Anders gezegd: installeer op eigen risico. Wees voorzichtig en lees de installatievoorschriften die bij elke plugin meekomen. Tenslotte: volg deze op.",
    2 => "Plug-in Installatie Disclaimer",
    3 => "Plug-in Installatie Formulier",
    4 => "Plug-in File",
    5 => "Plug-in List",
    6 => "Waarschuwing: Deze Plug-in is al Actief!",
    7 => "De plug-in die u probeert te installeren is er al. gelieve eerst deze plugin te verwijderen voordat u de installatie opnieuw probeert.",
    8 => "Plugin Compatibility Check Failed",
    9 => "Deze plugin vereist een latere versie van Geeklog. Gelieve deze versie van <a href=http://www.geeklog.net>Geeklog</a> te upgraden of een nieuwere versie op te halen van deze plug-in.",
    10 => "<br><b>Er zijn geen plugins actief op dit moment.</b><br><br>",
    11 => "Om een plug-in te wijzigen of te verwijderen, klik op het numer van deze plug-in's hieronder. Om een introductie over deze plug-in op te vragen, klik op de naam van de plug-in: dit brengt u naar de website van de  plug-in. Om een plug-in te installeren of te upgraden, klik op 'Nieuwe Plug-in' hierboven.",
    12 => "geen Naam voor de plug-in gevonden door de plugineditor()",
    13 => "Plugin Editor",
    14 => "Nieuwe Plug-in",
    15 => "Beheerder Home",
    16 => "Plug-in Naam",
    17 => "Plug-in Versie",
    18 => "Geeklog Versie",
    19 => "Toestaan",
    20 => "Ja",
    21 => "Nee",
    22 => "Installeer",
    23 => "Save",
    24 => "annuleren",
    25 => "Verwijderen",
    26 => "Plug-in Naam",
    27 => "Plug-in Homepage",
    28 => "Plug-in Versie",
    29 => "Geeklog Versie",
    30 => "Plug-in Verwijderen?",
    31 => "Weet u het zeker dat deze plug-in verwijderd mag worden? Let op! Hiermee worden tevens alle bestanden, data en structuren verwijderd die deze plug-in gebruikt. Alleen als u zeker bent, klikt u nogmaals op 'Verwijderen' in het formulier hieronder."
);

$LANG_ACCESS = array(
    access => "Access",
    ownerroot => "Owner/Root",
    group => "Group",
    readonly => "Read-Only",
    accessrights => "Toegangs Rechten",
    owner => "Owner",
    grantgrouplabel => "Grant Above Group Edit Rights",
    permmsg => "NOTE: 'Members': dit zijn alle ingelogde Gebruikers van het portaal -- 'Anonymous': dit zijn alle niet-ingelogde bezoekers.",
    securitygroups => "Security Groups",
    editrootmsg => "Ondanks dat u een gebruikersBeheerder bent, kunt u een zgn. 'root user' niet wijzigen. Daarvoor moet u eerst als een zgn. 'root user' ingelogd zijn. U kunt wel alle andere gebruikers wijzigen. Alle pogingen om een zgn. 'root users' ongeauthoriseerd te wijzigen, worden vastgelegd. gelieve terug te gaan naar de <a href=\"{$_CONF["site_admin_url"]}/user.php\">Gebruiker Administratie pagina</a>.",
    securitygroupsmsg => "Vink de groep(en) waarin de gebruiker opgenomen wordt.",
    groupeditor => "Group Editor",
    description => "Beschrijving",
    name => "Naam",
    rights => "Rechten",
    missingfields => "Niet alles ingevuld",
    missingfieldsmsg => "Een Naam en beschrijving is verplicht voor een groep.",
    groupmanager => "Group Manager",
    newgroupmsg => "Om een groep te wijzigen of te verwijderen, klik op die groep hieronder. Om een nieuwe groep aan te leggen, klik op 'Nieuwe Groep' hierboven. Let op! Zgn. 'core groups' kunnen niet verwijderd worden omdat dez in de software een functie hebben.",
    groupname => "Group Naam",
    coregroup => "Core Group",
    yes => "Ja",
    no => "Nee",
    corerightsdescr => "Deze groep is een zgn. {$_CONF["site_name"]} 'Core Group'. De rechten van de groep kunnen niet gewijzigd worden. Hieronder is een overzicht opgenomen van de rechten voor deze groep.",
    groupmsg => "'Security Groups' werken hierarchisch. Door het toevoegen aan andere groep(en), wordt deze groep dezelfde rechten toegekend. Het wordt aanbevolen, waar mogelijk, deze faciliteit te gebruiken. Indien u deze groep een speciale samenstelling wilt geven, kunt u de individuele rechten daarvoor in het gedeelte hieronder (extra) aanvinken, onder het hoofd 'Rechten'. Om rechten van een andere groep aan deze groep toe te voegen, kunt u volstaan met het aanvinken van deze andere groep(en).",
    coregroupmsg => "Deze groep is een zgn. {$_CONF["site_name"]} 'Core Group'. De groepen die hieraan toegevoegd zijn, kunnen daarom niet gewijzigd worden. Hieronder is een overzicht opgenomen van dergelijke groepen.",
    rightsdescr => "Een groepsrecht voor een bepaalde faciliteit (zie hieronder) kan direct toegekend worden *OF* aan een andere groep waaraan deze groep eerder is toegevoegd. Wat u hieronder kunt zien aan het ontbreken van een vink-mogelijkheid, zijn de rechten van een andere groep, waaraan deze groep eerder is toegevoegd (en daarmee deze rechten verkreeg). De recten die u kunt vinken kunt u direct toekennen aan - of afmelden voor - deze groep.",
    lock => "Lock",
    members => "Members",
    anonymous => "Anonymous",
    permissions => "Permissions",
    permissionskey => "R = read, E = edit, edit rights assume read rights",
    edit => "Wijzigen",
    none => "None",
    accessdenied => "Geen toegang",
    storydenialmsg => "Dit artikel is niet toegankelijk voor u. Dit kan veroorzaakt worden doordat u niet aangemeld bent bij {$_CONF["site_name"]}. Gelieve uzelve <a href=users.php?mode=new> aan te melden </a> bij {$_CONF["site_name"]} voor soorgelijke toegangsrechten.",
    eventdenialmsg => "Dit evenement is niet toegankelijk voor u. Dit kan veroorzaakt worden doordat u niet aangemeld bent bij {$_CONF["site_name"]}. Gelieve uzelve <a href=users.php?mode=new> aan te melden </a> bij {$_CONF["site_name"]} voor soorgelijke toegangsrechten.",
    nogroupsforcoregroup => "Deze groep heeft geen relatie met enig andere groep !!",
    grouphasnorights => "Deze groep kan geen administratieve functies op het portaal oproepen en/of uitvoeren.",
    newgroup => "Nieuwe Groep",
    adminhome => "Beheerder Home",
    save => "opslaan",
    cancel => "annuleren",
    delete => "verwijderen",
    canteditroot => "U probeert de zgn. 'Root group' te wijzigen, maar u behoort daar niet toe: de toegang is nu geweigerd. Gelieve contact op te nemen met de Beheerder indien u dit niet terecht vindt.",
    listusers => 'Overzicht Gebruikers',
    listthem => 'lijst',
    usersingroup => 'Gebruikers in groep %s'
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Word Replacement editor",
    wordid => "Word ID",
    intro => "Om een woord te wijzigen of te verwijderen, klik dan op dat woord. Om een nieuw woord aan te leggen, klik op 'Nieuw Woord' hierboven.",
    wordmanager => "Word Manager",
    word => "Woord",
    replacmentword => "Vervangen met",
    newword => "Nieuw Woord"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Laatste 10 Back-ups',
    do_backup => 'Maak een Backup',
    backup_successful => 'Database backup met succes uitgevoerd.',
    no_backups => 'Geen backups aanwezig',
    db_explanation => 'Om een nieuwe backup van het portaal te (laten) maken, klik op de knop hieronder',
    not_found => "Incorrect pad of mysqldump utility is niet uitvoerbaar.<br>Controleer  de definitei voor <strong>\$_DB_mysqldump_path</strong> in config.php.<br>De variabele is momenteel opgenomen als: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Backup stukgelopen: Filesize was 0 bytes',
    path_not_found => "{$_CONF['backup_path']} bestaat niet of is geen directory",
    no_access => "FOUT: Directory {$_CONF['backup_path']} is niet benaderbaar.",
    backup_file => 'Backup file',
    size => 'Size',
    bytes => 'Bytes',
    total_number => 'Totaal aantal backups: %d'
);

$LANG_BUTTONS = array(
    1 => "Home",
    2 => "Kontakt",
    3 => "Publiceren",
    4 => "Links",
    5 => "Peilingen",
    6 => "Kalendar",
    7 => "Portaal Stats",
    8 => "Persoonlijk",
    9 => "Zoek",
    10 => "gericht zoeken"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "Ach, overal gezicht en toch <b>%s</b> niet gevonden.",
    3 => "<p>Helaas, maar het bestand dat u opvraagt bestaat niet (meer). Kijkt u gerust nog eens op de <a href=\"{$_CONF['site_url']}\">voorpagina</a> of de <a href=\"{$_CONF['site_url']}/search.php\">zoek pagina</a>. Misschien vindt u het daar."
);

$LANG_LOGIN = array (
    1 => 'Login vereist',
    2 => 'Voor dit gedeelte is een login als Gebruiker vereist.',
    3 => 'Login',
    4 => 'Nieuwe Gebruiker'
);

?>
