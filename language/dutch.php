<?php

###############################################################################
# dutch.php
#
# This is an almost complete dutch language page for GeekLog!
# Please contact Fred <Fred@sc-dtk.nl> if you think anything
# important is missing ...
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
    1 => "Bijdrage van:",
    2 => "lees verder",
    3 => "reacties",
    4 => "Wijzig",
    5 => "Stem",
    6 => "Resultaat",
    7 => "Peilingstussenstand",
    8 => "stemmen",
    9 => "Beheerdersmenu:",
    10 => "Ter beoordeling",
    11 => "Artikelen",
    12 => "Blokken",
    13 => "Onderwerpen",
    14 => "Links",
    15 => "Evenementen",
    16 => "Peilingen",
    17 => "Gebruikers",
    18 => "SQL Query",
    19 => "Uitloggen",
    20 => "Gebruikers informatie:",
    21 => "Gebruikersnaam",
    22 => "Gebruikers ID",
    23 => "Beveiligingsniveau",
    24 => "Anoniem",
    25 => "Beantwoorden",
    26 => "De volgende reacties zijn voor verantwoording van degene die ze heeft geplaatst. Dit portaal is niet verantwoordelijk voor de inhoud.",
    27 => "Laatste plaatsingen",
    28 => "Verwijderen",
    29 => "Geen reacties.",
    30 => "Oudere artikelen",
    31 => "Toegestane HTML Tags:",
    32 => "Fout, ongeldige gebruikersnaam",
    33 => "Fout, kan niet naar logbestand schrijven",
    34 => "Fout",
    35 => "Uitloggen",
    36 => "aan",
    37 => "Geen artikelen",
    38 => "",
    39 => "Vernieuwen",
    40 => "",
    41 => "Gast(en)",
    42 => "Geschreven door:",
    43 => "Beantwoord",
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
    59 => "Heeft u nog geen account?  Meld u dan nu aan als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nieuwe gebruiker</a>",
    60 => "Verstuur een reactie",
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
    71 => "bijdrage",
    72 => "web latijn",
    73 => "vorige opinie peilingen",
    74 => "Kalender",
    75 => "geavanceerd zoeken",
    76 => "portaal statistieken",
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
    2 => "Sorry er zijn geen evenementen om weer te geven.",
    3 => "Wanneer",
    4 => "Waar",
    5 => "Omschrijving",
    6 => "Voeg evenement Toe",
    7 => "Komende evenementen",
    8 => "Door dit evenement aan uw kalender toe te voegen, kunt u snel de evenementen zien waarin u geïnteresseerd bent door op 'Mijn Kalender' te klikken in het Gebruikersmenu.",
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
    2 => "Manier van versturen",
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
    20 => "Probeer eerst op reactie's van anderen te reageren i.p.v. een 'Thread' te starten.",
    21 => "Lees ook de andere berichten voordat u uw bericht gaat versturen. Dit, om te voorkomen dat vele identieke berichten ontstaan.",
    22 => "Gebruik een helder onderwerp, dat uw bericht juist omschrijft.",
    23 => "Uw email adres zal NIET worden weergegeven.",
    24 => "Anonieme gebruiker"
);

###############################################################################
# users.php

$LANG04 = array(
    1 => "Gebruikers profiel voor",
    2 => "GebruikersNaam",
    3 => "Volledige Naam",
    4 => "Wachtwoord",
    5 => "Emailadres",
    6 => "Homepage",
    7 => "Bio",
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
    34 => "Dit is uw echte naam",
    35 => "Vul wachtwoord in om deze te wijzigen",
    36 => "Begint met http://",
    37 => "Toevoegen bij uw reacties",
    38 => "Het is aan U! Iedereeen kan dit lezen",
    39 => "Uw openbare PGP key ",
    40 => "Geen icons voor onderwerpen",
    41 => "Beschikbaar voor moderator",
    42 => "Datum formaat",
    43 => "Maximum artikelen",
    44 => "Geen blokken",
    45 => "Toon voorkeuren voor",
    46 => "Uitgesloten 'Items' voor",
    47 => "Nieuws blok instelling voor",
    48 => "Onderwerpen",
    49 => "Geen icons in artikelen",
    50 => "Afvinken indien u geen interesse heeft",
    51 => "Alleen de nieuwe artikelen",
    52 => "Standaard is 10",
    53 => "Ontvang de artikelen van overdag elke nacht",
    54 => "Vink de onderwerpen en auteurs aan die NIET wilt zien.",
    55 => "Als u ze allemaal heeft afgevinkt, betekent dit dat u de standaard selektie wilt zien. Als u begint te selekteren, selekteer dan alles dat u wilt zien, omdat de standaardinstellingen worden genegeerd. Standaardinstellingen worden vet weergegeven.",
    56 => "Auteurs",
    57 => "Weergave manier",
    58 => "Sorteer volgorde",
    59 => "Reactie limiet",
    60 => "Hoe wilt u dat reacties worden weergegeven?",
    61 => "Nieuwste of oudste eerst?",
    62 => "Standaard is 100",
    63 => "Uw wachtwoord is naar u verstuurd, en zou op dit moment moeten arriveren. Volg a.u.b. de aanwijzingen in het bericht. Het wordt gewaardeerd, dat u gebruik maakt van " . $_CONF["site_name"],
    64 => "Reactie Voorkeurinstellingen van",
    65 => "Probeer opnieuw in te loggen",
    66 => "U heeft mischien een tikfout gemaakt bij het inloggen. Probeer het hieronder opnieuw. Bent u een <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nieuwe gebruiker</a>?",
    67 => "Aangemeld sinds",
    68 => "Onthou mijn gegevens",
    69 => "Hoe lang kunnen we u onthouden nadat u bent ingelogd?",
    70 => "Pas de layout en inhoud aan van {$_CONF['site_name']}",
    71 => "Een mogelijkheid van {$_CONF['site_name']} is dat u de inhoud en de layout van wat u ontvangt kan aanpassen. Om van deze voorzieningen gebruik te maken dient u zich eerst te <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registeren</a> bij {$_CONF['site_name']}. Bent u al geregistreerd? Gebruik dan het login formulier, links om in te loggen!",
    72 => "Theme",
    73 => "Taal",
    74 => "Pas het portaal aan uw wensen aan!",
    75 => "Email onderwerpen voor",
    76 => "Indien u een Onderwerp uit de onderstaande lijst selecteert, ontvangt u elk artikel dat hier wordt geplaatst aan het eind van de dag thuis gestuurd. Kies alleen de onderwerpen waarin u bent geïnteresseerd!",
    77 => "Foto",
    78 => "Voeg een afbeelding toe van u zelf!",
    79 => "Aanvinken om uw afbeelding te verwijderen",
    80 => "Inloggen",
    81 => "Verstuur email",
    82 => 'Laatste 10 artikelen van gebruiker',
    83 => 'Plaatsing statistieken van gebruiker',
    84 => 'Totaal aantal artikelen:',
    85 => 'Totaal aantal commentaren/reacties:',
    86 => 'Vindt alle bijdragen van'

);

###############################################################################
# index.php

$LANG05 = array(
    1 => "Geen Nieuws om weer te geven",
    2 => "Er zijn geen nieuwe artikelen om weer te geven. Er is mischien geen nieuws voor dit onderwerp, of u bent hier niet voor geauthoriseerd.",
    3 => "voor onderwerp $topic",
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
    5 => "Stemmen"
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => "Er is een fout opgetreden bij het verzenden van het bericht. Probeer het opnieuw.",
    2 => "Bericht met succes verzonden.",
    3 => "Controleer of het juiste email adres is ingevuld in het veld 'Antwoord naar'.",
    4 => "Vul de velden in: uw naam, beantwoord-aan, onderwerp, en bericht",
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
    34 => "Eind van het Bericht"
);

###############################################################################
# search.php

$LANG09 = array(
    1 => "Geavanceerd Zoeken",
    2 => "Trefwoorden",
    3 => "Onderwerp",
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
    21 => "naar",
    22 => "(Datum Formaat YYYY-MM-DD)",
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
    41 => 'Uw zoekopdracht moet uit tenminste 3 tekens bestaan.',
    42 => 'Gebruik het datum formaat YYYY-MM-DD (jaar-maand-dag).'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => "Portaal statistieken",
    2 => "Totaal aantal treffers in het portaal",
    3 => "Artikelen(Reacties) in het portaal",
    4 => "Peilingen(Stemmen) in het portaal",
    5 => "Links(Klikken) in het portaal",
    6 => "Evenementen in het portaal",
    7 => "Top Tien opgevraagde artikelen",
    8 => "Artikel titel",
    9 => "Opgevraagd",
    10 => "Het lijkt erop dat er geen artikelen op deze site staan, of niemand heeft ze ooit opgevraagd.",
    11 => "Top Tien Artikelen met meeste reacties",
    12 => "Reacties",
    13 => "Het lijkt erop dat er geen artikelen op deze site staan, of niemand heeft er ooit op gereageerd.",
    14 => "Top Tien Peilingen",
    15 => "Peiling vragen",
    16 => "Stemmen",
    17 => "Het lijkt erop dat er geen peilingen op deze site staan, of niemand heeft ooit gestemd.",
    18 => "Top Tien Links",
    19 => "Links",
    20 => "Hits",
    21 => "Het lijkt erop dat er geen links op deze site staan, of niemand heeft er ooit een aangeklikt.",
    22 => "Top Tien Artikelen via email",
    23 => "Emails",
    24 => "Het lijkt erop dat er geen artikelen op deze site staan, of niemand is er op geabonneerd"
);

###############################################################################
# article.php

$LANG11 = array(
    1 => "Wat is gerelateerd",
    2 => "Email artikel naar collega",
    3 => "Afdrukbaar artikel formaat",
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
    9 => "Indien u informatie voorstelt voor gebruik op dit portaal, vragen we de volgende suggesties te volgen...<ul><li>Vul alle velden in. deze zijn vereist<li>Lever complete en accurate informatie<li>Controleer deze URLs dubbel</ul>",
    10 => "Titel",
    11 => "Link",
    12 => "Start Datum",
    13 => "Eind Datum",
    14 => "Locatie",
    15 => "Omschrijving",
    16 => "Indien ander, specificeer a.u.b.",
    17 => "Categorie",
    18 => "Ander",
    19 => "Lees dit eerst",
    20 => "Fout: Geen Categorie ingvuld",
    21 => "Indien 'Ander' geselekteerd: lever dan een ook een categorie naam",
    22 => "Fout: niet alle velden Ingevuld",
    23 => "Vul alle velden van het formulier in. Alle velden zijn vereist.",
    24 => "Voorstel opgeslagen",
    25 => "Uw $type voorstel is succesvol opgeslagen.",
    26 => "Snelheids limiet",
    27 => "Gebruikersnaam",
    28 => "Onderwerp",
    29 => "Artikel",
    30 => "Uw laatste bijdrage was ",
    31 => " seconden geleden. Deze site vereist ten minste {$_CONF["speedlimit"]} seconden tussen twee voorstellen voor plaatsing",
    32 => "Preview",
    33 => "Artikel preview",
    34 => "Uitloggen",
    35 => "HTML tags zijn niet toegestaan",
    36 => "Manier van plaatsen",
    37 => "Een voorstel voor plaatsing van een evenement op {$_CONF["site_name"]}, plaatst deze in de hoofdkalender waar gebruikers de optie hebben om deze aan hun persoonlijke kalender toe te voegen. Deze voorziening is <b>NIET</b> bedoeld voor persoonlijke evenementen, zoals verjaardagen en jubilea.<br><br>Als u een voorstel voor een evenement doet, wordt deze verstuurt naar een beheerder en indien goedgekeurd, verschijnt deze in de hoofdkalender.",
    38 => "Voeg Evenement toe aan",
    39 => "Hoofdkalender",
    40 => "Persoonlijke Kalender",
    41 => "Eind Tijd",
    42 => "Start Tijd",
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
    6 => "Alle toegang tot administratieve functies van het portaal worden vastgelegd en later bekeken.<br>Deze pagina is alleen voor geautoriseerde gebruikers.",
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
    6 => "Onderwerp",
    7 => "Alles",
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
    21 => "Blok Beveiliginsniveau",
    22 => "Blok Type",
    23 => "Blok Volgorde",
    24 => "Blok Onderwerp",
    25 => "Om een blok te wijzigen of te verwijderen, klikt u op dat blok hier onder. Om een nieuw blok aan te maken klikt u op 'nieuw blok' hier boven.",
    26 => "Layout Blok",
    27 => "PHP Blok",
      28 => "PHP Blok opties",
      29 => "Blok Menu",
      30 => "Indien u PHP code wenst te gebruiken in een van de blokken, vul dan de naam van de funktion in hier boven. Deze naam moet starten met prefix 'phpblock_' (e.g. phpblock_hello_world). Zonder deze prefix wordt de funktie NIET aangeroepen. Dit is een beveiligingsmaatregel om niet zomaar willekeurige kode te moeten accepteren, die wellicht de integriteit kunnen schaden. Zorg er ook voor dat er 'lege haakjes' \"()\" staan achter de funktienaam. Tenslotte: het wordt aanbevolen dat alle PHP-blok-code in /path/to/geeklog/system/lib-custom.php wordt opgenomen. Bij nieuwe versies blijft deze plaats intact.",
      31 => "Fout in PHP Blok. Funktie, $function, bestaat niet.",
      32 => "Fout: niet alle velden doorgegeven.",
      33 => "Er wordt een URL gevraagd voor het .rdf bestand (portaal blokken)",
      34 => "Gelieve de titel en de funktie voor PHP blokken op te geven.",
      35 => "Gelieve de titel en de inhoud op te geven (normale blokken)",
      36 => "Gelieve de inhoud op te geven (layout blokken)",
      37 => "Ongeldige PHP blok funktienaam",
      38 => "Funktie voor PHP blokken moeten de prefeix 'phpblock_' (e.g. phpblock_hello_world) bevatten. Deze prefix is vereist ter beveiliging: het voorkomt de uitvoering van willekeurige PHP-code.",
    39 => "Zijde",
    40 => "Links",
    41 => "Rechts",
    42 => "Gelieve de blokvolgorde en het beveiligingsniveau op te geven (standaard blokken).",
    43 => "Alleen Homepagina",
    44 => "Geen toegang",
    45 => "U heeft geprobeerd een blok op te roepen zonder geldige authorisatie. De poging is vastgelegd. <a href=\"{$_CONF["site_url"]}/admin/block.php\">Terug naar de blok administratie pagina</a>.",
    46 => "Nieuw blok",
    47 => "Beheerder Home",
      48 => "Blok Name",
      49 => " (geen spaties en verplicht unieke naam)",
      50 => "Help File URL",
      51 => "include http://",
      52 => "Indien u dit niet invult, verschijnt er geen help icon in dit blok.",
      53 => "Toegestaan",
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
    5 => "Evenement Start Datum",
    6 => "Evenement Einde Datum",
    7 => "Evenement Locatie",
    8 => "Evenement Beschrijving",
    9 => "(include http://)",
    10 => "Gelieve de datums/tijden te vermelden alsmede de velden in te vullen bij Beschrijving en Locatie!",
    11 => "Evenement Manager",
    12 => "Om een evenement te wijzigen of te verwijderen, klik dan op dat evenement hier onder. Om een evenement aan te maken, klik dan op 'Nieuw Evenement' hier boven.",
    13 => "Event Titel",
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
    12 => "Om een link te wijzen, klik op die link hier onder. Om een nieuwe link aant maken, klik op 'Nieuwe Link' hierboven.",
    13 => "Link Titel",
    14 => "Link Categorie",
    15 => "Link URL",
    16 => "Geen toegang",
    17 => "U heeft geprobeerd een link op te roepen zonder geldige authorisatie. De poging is vastgelegd. <a href=\"{$_CONF["site_url"]}/admin/link.php\">Terug naar de link administratie pagina</a>.",
    18 => "Nieuww Link",
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
    3 => "Manier",
    4 => "Manier van plaatsen",
    5 => "Artikel Editor",
    6 => "Er bestaan (nog) geen Artikelen in het portaal",
    7 => "Auteur",
    8 => "opslaan",
    9 => "preview",
    10 => "annuleren",
    11 => "verwijderen",
    12 => "",
    13 => "Titel",
    14 => "Onderwerp",
    15 => "Datum",
    16 => "Introductie Tekst",
    17 => "Body Tekst",
    18 => "Treffers",
    19 => "Opmerkingen",
    20 => "",
    21 => "",
    22 => "Artikel Lijst",
    23 => "Om een Artikel te wijzigen of te verwijderen, klik op het betreffende artikelnummer hier onder. Om een artikel op te roepen, klik op de titel van het betreffende Artikel. Om een nieuw Artikel aan te maken, klik op 'Nieuw Artikel' hier boven.",
    24 => "",
    25 => "",
    26 => "Artikel Preview",
    27 => "",
    28 => "",
    29 => "",
    30 => "",
    31 => "Gelieve de Auteur, Titel en Introductie Tekst te vermelden.",
    32 => "HoofdArtikel",
    33 => "Er kan slechts een enkel HoofdArtikel zijn !!",
    34 => "Draft",
    35 => "Ja",
    36 => "Nee",
    37 => "More by",
    38 => "More from",
    39 => "Emails",
    40 => "Geen toegang",
    41 => "U heeft geprobeerd een artikel op te roepen zonder geldige authorisatie. De poging is vastgelegd. Het Artikel is hier onder weergegeven. <a href=\"{$_CONF["site_url"]}/admin/story.php\">Terug naar de artikel administratie pagina</a>.",
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
    54 => "Bijgesloten beelden niet opgenomen in tekst",
    55 => "De hierna volgende problemen zijn opgetreden bij het opslaan van uw artikel. Gelieve deze op te lossen en daarna opnieuw op te slaan.",
    56 => "Toon Onderwerp Icon"
);

###############################################################################
# poll.php

$LANG25 = array(
    1 => "Manier",
    2 => "",
    3 => "Peiling aangemaakt",
    4 => "Peiling $qid opgeslagen",
    5 => "Wijzig Peiling",
    6 => "Peiling ID",
    7 => "(geen spaties)",
    8 => "Verschijnt op Homepagina",
    9 => "Vraag",
    10 => "Antwoorden / Stemmen",
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
    1 => "Onderwerp Editor",
    2 => "Onderwerp ID",
    3 => "Onderwerp Naam",
    4 => "Onderwerp Beeld",
    5 => "(zonder spaties)",
    6 => "Het verwijderen van een Onderwerp is recursief. Alle bijbehorende Artikelen en Blokken worden tevens verwijderd",
    7 => "Gelieve het Onderwerp ID en de Onderwerp Naam in te vullen.",
    8 => "Onderwerp Manager",
    9 => "Om een Onderwerp te wijzigen of te verwijderen, klik op het betreffende Onderwerp. Om een nieuw Onderwerp aan te lkeggen, klik op 'Nieuw Onderwerp' links. Uw toegangsniveau voor ieder Onderwerp staat daar tussen haakjes.",
    10=> "Sorteer Volgorde",
    11 => "Artikelen/Pagina",
    12 => "Geen toegang",
    13 => "U heeft geprobeerd een Onderwerp op te roepen zonder geldige authorisatie. De poging is vastgelegd. <a href=\"{$_CONF["site_url"]}/admin/topic.php\">Terug naar de Onderwerp administratie pagina</a>.",
    23 => "Nieuwe Peiling",
    14 => "Sorteer Methode",
    15 => "alphabetisch",
    16 => "standaard is",
    17 => "Nieuw Onderwerp",
    18 => "Beheerder Home",
    19 => 'opslaan',
    20 => 'annuleren',
    21 => 'verwijderen'
);

###############################################################################
# user.php

$LANG28 = array(
    1 => "Gebruiker Editor",
    2 => "Gebruiker ID",
    3 => "Gebruiker Naam",
    4 => "Volledige Naam",
    5 => "Password",
    6 => "Toegangs Niveau",
    7 => "Email adres",
    8 => "Homepagina",
    9 => "(zonder spaties)",
    10 => "Gelieve de Gebruiker Naam, Volledige naam, toegangsniveau en emailadres in te vullen.",
    11 => "Gebruiker Manager",
    12 => "Om een Gebruiker te wijzigen of te verwijderen, klik op de betreffende Gebruiker hier onder. Om een nieuwe Gebruiker aan te maken, klik op 'Nieuwe Gebruiker' links. Er kan eenvoudig gezocht worden op delen van een Gebruiker Naam, email adres of van de Volledige naam (e.g.*sen* or *.nl).",
    13 => "ToegangsNiveau",
    14 => "Reg. Datum",
    15 => "Nieuwe Gebruiker",
    16 => "Beheerder Home",
    17 => "password wijzigen",
    18 => "annuleren",
    19 => "verwijderen",
    20 => "opslaan",
    18 => "annuleren",
    19 => "verwijderen",
    20 => "opslaan",
    21 => "De gebruikernaam bestaat reeds.",
    22 => "Fout",
    23 => "Batch Toevoegen",
    24 => "Batch Import van Gebruikers",
    25 => "Een batch met gebruikers kan geimporteerd worden. Het import bestand is dan een tab-delimited tekst bestand en heeft de velden in de volgende layout: Volledige Naam, gebruikersnaam, email adres. Aan elke zo toegevoegde Gebruiker wordt daarna een email verstuurd met een willekeurig password. Slechts een enkel Gebruiker per regel! Het niet volgen van deze instructies veroorzaakt problemen die uitsluitend met handwerk opgelost kunnen worden. Dubbelcheck de invullingen !!",
    26 => "Zoek",
    27 => "Limiteer Resultaten",
    28 => "Vink aan om dit beeld te verwijderen",
    29 => 'Path',
    30 => 'Import',
    31 => 'Nieuwe Gebruiker',
    32 => 'Klaar met verwerken. $successes geimporteerd en $failures geweigerd',
    33 => 'submit',
    34 => 'Fout: specificeer een bestand voor upload.'
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
    15 => "Onderwerp",
    16 => 'Gebruiker naam',
    17 => 'Volledige naam',
    18 => 'Email',
    34 => "Command and Control",
    35 => "Artikel Submissions",
    36 => "Link Submissions",
    37 => "Evenement Submissions",
    38 => "Submit",
    39 => "Er is niets te modereren op dit moment",
    40 => "Gebruiker Submissions"
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
    37 => "Sorry, de persoonlijke kalender optie is niet beschikbaar op het portaal",
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
    14 => "Ignore user settings",
    15 => "Error when sending to: ",
    16 => "Successfully sent messages to: ",
    17 => "<a href=" . $_CONF["site_url"] . "/admin/mail.php>Send another message</a>",
    18 => "To",
    19 => "NOTE: if you wish to send a message to all site members, select the Logged-in Users group from the drop down.",
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages. If you need them, the details of each message attempts is below. Otherwise you can <a href=\"" . $_CONF['site_url'] . "/admin/mail.php\">Send another message</a> or you can <a href=\"" . $_CONF['site_url'] . "/admin/moderation.php\">go back to the administration page</a>.",
    21 => "Failures",
    22 => "Successes",
    23 => "No failures",
    24 => "No successes",
    25 => '-- Select Group --',
    26 => "Please fill in all the fields on the form and select a group of users from the drop down."
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
    9 => "Uw artikel is opgeslagen.",
    10 => "Uw artikel is verwijderd.",
    11 => "Uw blok is opgeslagen.",
    12 => "Uw blok is verwijderd.",
    13 => "Uw onderwerp is opgeslagen.",
    14 => "Uw onderwerp, en al de bijbehorende artikelen zijn verwijderd.",
    15 => "Uw link is opgeslagen.",
    16 => "Uw link is verwijderd.",
    17 => "Uw evenement is opgeslagen.",
    18 => "Uw evenement is verwijderd.",
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
    29 => "Sorry, persoonlijke kalenders zijn niet geactiveerd op dit portaal",
    30 => "Toegang Geweigerd",
    31 => "Sorry, u heeft geen toegang tot de artikel administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    32 => "Sorry, u heeft geen toegang tot de onderwerpen administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    33 => "Sorry, u heeft geen toegang tot de blok administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    34 => "Sorry, u heeft geen toegang tot de links administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    35 => "Sorry, u heeft geen toegang tot de evenementen administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    36 => "Sorry, u heeft geen toegang tot de peilingen administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    37 => "Sorry, u heeft geen toegang tot de gebruiker administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    38 => "Sorry, u heeft geen toegang tot de plug-in administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    39 => "Sorry, u heeft geen toegang tot de email administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
    40 => "Portaal Bericht",
      41 => "Sorry, u heeft geen toegang tot de woordvervang administratie pagina. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
      42 => "Het woord is opgeslagen.",
    43 => "Het woord is verwijderd.",
      44 => "De plug-in is ingevoegd!",
      45 => "De plug-in is verwijderd.",
      46 => "Sorry, u heeft geen toegang tot Database Backup Utility. Let op: alle pogingen om ongeauthoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd",
      47 => "Deze funktie werkt allen onder *nix. Indien u *nix gebruikt als besturingsysteem dan is uw cache geleegd. Indien u Windows gebruikt, moet u zoeken naar bestanden als adodb_*.php en deze handmatig verwijderen.",
      48 => 'Bedankt voor uw aanvraag voor een gebruikersaccount van ' . $_CONF['site_name'] . '. De beheerders zullen uw aanvraag balloteren. Indien goedgekeurd, wordt uw wachtwoord naar het email adres verstuurd dat u net heeft ingevuld.',
      49 => "De groep is opgeslagen.",
      50 => "De groep is verwijderd."
);

// for plugins.php

$LANG32 = array (
    1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system. It is important that you only install plugins downloaded from the <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems. It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites. Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin. In other words, install at your own risk. For the wary, directions on how to manually install a plugin is included with each plugin package.",
    2 => "Plug-in Installation Disclaimer",
    3 => "Plug-in Installation Form",
    4 => "Plug-in File",
    5 => "Plug-in List",
    6 => "Warning: Plug-in Already Installed!",
    7 => "The plug-in you are trying to install already exists. Please delete the plugin before re-installing it",
    8 => "Plugin Compatibility Check Failed",
    9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=http://www.geeklog.net>Geeklog</a> or get a newer version of the plug-in.",
    10 => "<br><b>There are no plugins currently installed.</b><br><br>",
    11 => "To modify or delete a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in click on new plug-in above.",
    12 => "no plugin name provided to plugineditor()",
    13 => "Plugin Editor",
    14 => "New Plug-in",
    15 => "Admin Home",
    16 => "Plug-in Name",
    17 => "Plug-in Version",
    18 => "Geeklog Version",
    19 => "Enabled",
    20 => "Yes",
    21 => "No",
    22 => "Install",
    23 => "Save",
    24 => "Cancel",
    25 => "Delete",
    26 => "Plug-in Name",
    27 => "Plug-in Homepage",
    28 => "Plug-in Version",
    29 => "Geeklog Version",
    30 => "Delete Plug-in?",
    31 => "Are you sure you want to delete this plug-in?  By doing so you will remove all the files, data and data structures that this plug-in uses. If you are sure, click delete again on the form below."
);

$LANG_ACCESS = array(
    access => "Access",
      ownerroot => "Owner/Root",
      group => "Group",
      readonly => "Read-Only",
    accessrights => "Access Rights",
    owner => "Owner",
    grantgrouplabel => "Grant Above Group Edit Rights",
    permmsg => "NOTE: members is all logged in members of the site and anonymous is all users browsing the site that aren't logged in.",
    securitygroups => "Security Groups",
    editrootmsg => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself. You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged. Please go back to the <a href=\"{$_CONF["site_admin_url"]}/user.php\">User Administration page</a>.",
    securitygroupsmsg => "Select the checkboxes for the groups you want the user to belong to.",
    groupeditor => "Group Editor",
    description => "Description",
    name => "Name",
    rights => "Rights",
    missingfields => "Missing Fields",
    missingfieldsmsg => "You must supply the name and a description for a group",
    groupmanager => "Group Manager",
    newgroupmsg => "To modify or delete a group, click on that group below. To create a new group click new group above. Please note that core groups cannot be deleted because they are used in the system.",
    groupname => "Group Name",
    coregroup => "Core Group",
    yes => "Yes",
    no => "No",
    corerightsdescr => "This group is a core {$_CONF["site_name"]} Group. Therefore the rights for this group cannot be edited. Below is a read-only list of the rights this group has access to.",
    groupmsg => "Security Groups on this site are hierarchical. By adding this group to any of the groups below you will giving this group the same rights that those groups have. Where possible it is encouraged you use the groups below to give rights to a group. If you need this group to have custom rights then you can select the rights to various site features in the section below called 'Rights'. To add this group to any of the ones below simply check the box next to the group(s) that you want.",
    coregroupmsg => "This group is a core {$_CONF["site_name"]} Group. Therefore the groups that this groups belongs to cannot be edited. Below is a read-only list of the groups this group belongs to.",
    rightsdescr => "A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of. The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right. The rights with checkboxes below are rights that can be given directly to this group.",
    lock => "Lock",
    members => "Members",
    anonymous => "Anonymous",
    permissions => "Permissions",
    permissionskey => "R = read, E = edit, edit rights assume read rights",
    edit => "Edit",
    none => "None",
    accessdenied => "Access Denied",
    storydenialmsg => "You do not have access to view this story. This could be because you aren't a member of {$_CONF["site_name"]}. Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
    eventdenialmsg => "You do not have access to view this event. This could be because you aren't a member of {$_CONF["site_name"]}. Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
    nogroupsforcoregroup => "This group doesn't belong to any of the other groups",
    grouphasnorights => "This group doesn't have access to any of the administrative features of this site",
    newgroup => "New Group",
    adminhome => "Admin Home",
    save => "save",
    cancel => "cancel",
      delete => "delete",
    canteditroot => "You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied. Please contact the system administrator if you feel this is an error"    
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Word Replacment editor",
    wordid => "Word ID",
    intro => "To modify or delete a word, click on that word. To create a new word replacement click the new word button to the left.",
    wordmanager => "Word Manager",
    word => "Word",
    replacmentword => "Replacment Word",
    newword => "New Word"
);

$LANG_DB_BACKUP = array(
    last_ten_backups => 'Last 10 Back-ups',
    do_backup => 'Do Backup',
    backup_successful => 'Database back up was successful.',
    no_backups => 'No backups in the system',
    db_explanation => 'To create a new backup of your Geeklog system, hit the button below',
    not_found => "Incorrect path or mysqldump utility not executable.<br>Check <strong>\$_DB_mysqldump_path</strong> definition in config.php.<br>Variable currently defined as: <var>{$_DB_mysqldump_path}</var>",
    zero_size => 'Backup Failed: Filesize was 0 bytes',
    path_not_found => "{$_CONF['backup_path']} does not exist or is not a directory",
    no_access => "ERROR: Directory {$_CONF['backup_path']} is not accessible.",
    backup_file => 'Backup file',
    size => 'Size',
    bytes => 'Bytes'
);

$LANG_BUTTONS = array(
    1 => "Home",
    2 => "Kontakt",
    3 => "Publiseer",
    4 => "Links",
    5 => "Peilingen",
    6 => "Kalendar",
    7 => "Portaal Stats",
    8 => "Personaliseer",
    9 => "Zoek",
    10 => "geavanceerd zoeken"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "Gee, I've looked everywhere but I can not find <b>%s</b>.",
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

$LANG_LOGIN = array (
    1 => 'Login vereist',
    2 => 'Voor dit gedeelte is een login als Gebruiker vereist.',
    3 => 'Login',
    4 => 'Nieuwe Gebruiker'
);

?>
