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
    1 => "Door:",
    2 => "lees verder",
    3 => "reacties",
    4 => "Wijzig",
    5 => "Stem",
    6 => "Resultaat",
    7 => "Stem Resultaat",
    8 => "stemmen",
    9 => "Beheerders Funkties:",
    10 => "Ter Beoordeling",
    11 => "Artikelen",
    12 => "Blokken",
    13 => "Onderwerpen",
    14 => "Links",
    15 => "Evenementen",
    16 => "Peilingen",
    17 => "Gebruikers",
    18 => "SQL Query",
    19 => "Uitloggen",
    20 => "Gebruikers Informatie:",
    21 => "Gebruikersnaam",
    22 => "Gebruikers ID",
    23 => "Beveiligings Level",
    24 => "Anoniem",
    25 => "Beantwoord",
    26 => "Voor de volgende reacties zijn voor verantwoording van degene die deze plaatst. Deze site is niet verantwoordelijk voor wat deze inhouden.",
    27 => "Laatste plaatsingen",
    28 => "Verwijder",
    29 => "Geen reacties.",
    30 => "Oudere Verslagen",
    31 => "Toegestane HTML Tags:",
    32 => "Fout, ongeldige gebruikersnaam",
    33 => "Fout, kon niet naar logbestand schrijven",
    34 => "Fout",
    35 => "Uitloggen",
    36 => "aan",
    37 => "Geen gebruiker verhalen",
    38 => "",
    39 => "Vernieuw",
    40 => "",
    41 => "Gast(en)",
    42 => "Geschreven door:",
    43 => "Beantwoord",
    44 => "Parent",
    45 => "MySQL Error Number",
    46 => "MySQL Error Message",
    47 => "Gebruikers Funkties",
    48 => "Account Informatie",
    49 => "Beeld instellingen",
    50 => "Fout in SQL statement",
    51 => "help",
    52 => "Nieuw",
    53 => "Beheerder Home",
    54 => "Kon bestand niet openen.",
    55 => "Fout in",
    56 => "Stem",
    57 => "Wachtwoord",
    58 => "Inloggen",
    59 => "Heeft u nog geen account?  Meld u dan nu aan als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Nieuwe Gebruiker</a>",
    60 => "Verstuur een reactie",
    61 => "Creëer een Nieuw Account",
    62 => "woorden",
    63 => "Artikel weergave",
    64 => "Mail Artikel naar Vriend(in)",
    65 => "Bekijk afdruk versie",
    66 => "Mijn Kalender",
    67 => "Welkom bij ",
    68 => "home",
    69 => "contact",
    70 => "zoeken",
    71 => "bijdrage",
    72 => "web bronnen",
    73 => "vorige opinie peilingen",
    74 => "Kalender",
    75 => "geavanceerd zoeken",
    76 => "site statistieken",
    77 => "Plugins",
    78 => "Aankomende Evenementen",
    79 => "Wat is Nieuw",
    80 => "artikelen in de laatste",
    81 => "artikel in de laatste",
    82 => "uren",
    83 => "REACTIES",
    84 => "LINKS",
    85 => "laatste 48 uur",
    86 => "Geen nieuwe reacties",
    87 => "laatste 2 weken",
    88 => "Geen recente nieuwe links",
    89 => "Er zijn geen aankomende evenmenten",
    90 => "Home",
    91 => "Deze pagina is Gecreëerd in",
    92 => "seconden",
    93 => "Copyright",
    94 => "Alle merknamen en copyrights op deze pagina zijn eigendom van hun respectievelijke eigenaren.",
    95 => "Aangedreven door",
    96 => "Groepen",
      97 => "Woorden Lijst",
    98 => "Plug-ins",
    99 => "ARTIKELEN",
      100 => "Geen nieuwe artikelen",
      101 => "Jouw Evenementen",
      102 => "Site Evenementen",
      103 => "DB Backups",
      104 => "door",
      105 => "Mail Gebruikers",
      106 => "Bekeken",
      107 => "GL Versie Test",
      108 => "Leeg Cache"
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => "Evenenmenten Kalender",
    2 => "Sorry er zijn geen evenementen om weer te geven.",
    3 => "Wanneer",
    4 => "Waar",
    5 => "Omschrijving",
    6 => "Voeg Evenement Toe",
    7 => "Aankomende Evenementen",
    8 => "Door dit evenement aan uw kalender toe te voegen, kunt u snel de evenementen zien waarin u geïnteresseerd bent door op Mijn Kalender te klikken onder Gebruikers Funkties.",
    9 => "Voeg toe aan Mijn Kalender",
    10 => "Verwijder van Mijn Kalender",
    11 => "Voeg evenment toe aan {$_USER['username']}'s Kalender",
    12 => "Evenement",
    13 => "Begint",
    14 => "Eindigt",
      15 => "Terug naar Kalender"
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => "Verstuur een Reactie",
    2 => "Post Mode",
    3 => "Uitloggen",
    4 => "Creëer Account",
    5 => "Gebruikersnaam",
    6 => "Deze site vereist dat u bent ingelogd om een reactie te versturen, log in aub.  Indien u geen account heeft, kunt u het onderstaande formulier gebruiken om er één te creëeren.",
    7 => "Uw laatste reactie was ",
    8 => " seconden geleden.  Deze site vereist tenminste {$_CONF["commentspeedlimit"]} seconden tussen reacties",
    9 => "Reactie",
    10 => "",
    11 => "Verstuur Reactie",
    12 => "Vul aub de Titel en Reactie velden in, deze zijn noodzakelijk voor het versturen van een reactie.",
    13 => "Uw Informatie",
    14 => "Preview",
    15 => "",
    16 => "Titel",
    17 => "Fout",
    18 => "Belangrijke Zaken",
    19 => "Houdt u aub bij het onderwerp.",
    20 => "Probeer op andere mensen hun reactie's te reageren ipv een Thread te starten.",
    21 => "Lees eerst de andere berichten voor het versturen van je eigen, om te voorkomen van duplikaat vorming.",
    22 => "Gebruik een helder onderwerp, dat uw bericht juist omschrijft.",
    23 => "Uw email adres zal NIET worden weergegeven.",
    24 => "Anonieme Gebruiker"
);

###############################################################################
# users.php

$LANG04 = array(
    1 => "Gebruikers Profiel voor",
    2 => "GebruikersNaam",
    3 => "Volledige Naam",
    4 => "Wachtwoord",
    5 => "Email",
    6 => "Homepage",
    7 => "Bio",
    8 => "PGP Code",
    9 => "Bewaar Informatie",
    10 => "Laatste 10 reacties van gebruiker",
    11 => "Geen Gebruikers Reacties",
    12 => "Gebruikders Instellingen voor",
    13 => "Email 's Nachts Verwerken",
    14 => "Dit wachtwoord is gegenereerd door een randomizer. Het is aanbevolen  om het wachtwoord meteen te wijzigen. Om het wachtwoord te wijzigen, log in en klik op Account Information van het Gebruiker funktie menu..",
    15 => "Uw {$_CONF["site_name"]} account is aangemaakt. Om er gebruik van te maken, dient u in te loggen met gebruik van de onderstaande informatie. Bewaar dit bericht aub voor gebruik in de toekomst.",
    16 => "Uw Account Informatie",
    17 => "Account bestaat niet",
    18 => "Het email adres lijkt geen bestaand adres",
    19 => "De gebruikersnaam of email adres is al in gebruik",
    20 => "Het email adres lijkt geen juist email adres",
    21 => "Fout",
    22 => "Registreer bij {$_CONF['site_name']}!",
    23 => "Door het aanmaken van een gebruiker account profiteert u van alle voordelen van {$_CONF['site_name']} site lidmaadschap en geeft u de mogelijkheid reacties en artikelen onder uw eigen naam te plaatsen. Indien u niet registreert, is dit alleen anoniem mogelijk. Let op, uw email adres zal <b><i>nooit</i></b> publiekelijk worden weergegeven op deze site.",
    24 => "Uw wachtwoord wordt verstuurd naar het email adres dat u invoert.",
    25 => "Bent u uw Wachtwoord vergeten?",
    26 => "Vul uw gebruikersnaam in en klik op Email Wachtwoord en een nieuw wachtwoord wordt verstuurd naar het opgeslagen email adres.",
    27 => "Registreer Nu!",
    28 => "Email Wachtwoord",
    29 => "Uitgelogd van",
    30 => "Ingelog van",
    31 => "De Fucktie die wilt gebruiken, is alleen beschikbaar indien u bent ingelogd",
    32 => "Handtekening",
    33 => "Nooit publiekelijk weergeven",
    34 => "Dit is uw echte naam",
    35 => "Vul wachtwoord in om deze te wijzigen",
    36 => "Begint met http://",
    37 => "Toevoegen bij uw reacties",
    38 => "Het is aan U! Iedereeen kan dit lezen",
    39 => "Uw openbare PGP key ",
    40 => "Geen Onderwerp Icons",
    41 => "Beschikbaar voor Moderate",
    42 => "Datum Formaat",
    43 => "Maximum Artikelen",
    44 => "Geen boxen",
    45 => "Geef instellingen voor",
    46 => "Uitgesloten Items voor",
    47 => "Nieuws box Configuratie voor",
    48 => "Onderwerpen",
    49 => "Geen icons in artikelen",
    50 => "Dit Uitvinken indien u niet geïnterreseerd bent",
    51 => "Alleen de nieuwe artikelen",
    52 => "Standaard is 10",
    53 => "Ontvang de artikelen van overdag elke nacht",
    54 => "Vink de box aan van de onderwerpen en auteurs, die niet wilt zien.",
    55 => "Als u ze allemaal heeft uitgevinkt, betekent dit dat u de standaard selektie van boxen wilt zien. Als u begint te selekteren, selekteer dan alle boxen die u wilt zien, omdat de standaardinstellingen worden genegeerd. Standaardinstellingen worden vet weergegeven.",
    56 => "Auteurs",
    57 => "Weergave Mode",
    58 => "Sorteer Volgorde",
    59 => "Reactie Limiet",
    60 => "Hoe wilt dat de reactie worden weergegeven?",
    61 => "Nieuwste of oudste eerst?",
    62 => "Standaard is 100",
    63 => "Uw wachtwoord is naar u geëmaild, en zou op dit moment moeten arriveren. Volg aub de aanwijzingen in het bericht, en we bedanken u, dat u gebruik maakt van " . $_CONF["site_name"],
    64 => "Reactie Voorkeurinstellingen van",
    65 => "Probeer opnieuw in te loggen",
    66 => "U heeft mischien een tikfout gemaakt bij het inloggen.  Probeer het hieronder opnieuw. Bent u een <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nieuwe gebruiker</a>?",
    67 => "Lid Sinds",
    68 => "Onthoudt mij",
    69 => "Hoe lang moeten we u onthouden nadat u bent ingelogd?",
    70 => "Pas de layout en inhoud aan van {$_CONF['site_name']}",
    71 => "Eén van de prachtige mogelijkheden van {$_CONF['site_name']} is dat u de inhoud en de layout van wat u ontvangt kan aanpassen. Om van deze voorzieningen gebruik te maken dient u zich eerst te <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registeren</a> bij {$_CONF['site_name']}.  Bent u al geregistreerd? Gebruik dan het login formulier, links om in te loggen!",
    72 => "Thema",
    73 => "Taal",
    74 => "Pas deze site aan uw wensen aan!",
    75 => "Email Onderwerpen voor",
    76 => "Indien u een Onderwerp uit de onderstaande lijst selecteerd, ontvang u elk artikel dat hier in is gepost aan het eind van de dag thuis gestuurd.  Kies alleen de onderwerpen waarin u bent geïnteresseerd!",
    77 => "Foto",
    78 => "Voeg een Afbeelding toe van u zelf!",
    79 => "Vink dit aan om uw afbeelding te verwijderen",
    80 => "Inloggen",
    81 => "Verstuur Email",
    82 => 'Laatste 10 verhalena van gebruiker',
    83 => 'Post statistieken van gebruiker',
    84 => 'Totaal aantal artikelen:',
    85 => 'Totaal aantal commentaren/reacties:',
    86 => 'Vindt alle bijdragen van'

);

###############################################################################
# index.php

$LANG05 = array(
    1 => "Geen Nieuws om weer te geven",
    2 => "Er zijn geen nieuwe artikelen om weer te geven.  Er is mischien geen nieuws voor dit onderwerp, of u bent hier niet voor geauthoriseerd.",
    3 => "voor onderwerp $topic",
    4 => "Hoofdartikel",
    5 => "Volgende",
    6 => "Vorige"
);

###############################################################################
# links.php

$LANG06 = array(
    1 => "Web Bronnen",
    2 => "Er zijn geen nieuwe Links om weer te geven.",
    3 => "Voeg een Link toe"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => "Stem opgeslagen",
    2 => "Uw stem voor de peiling is opgeslagen",
    3 => "Stem",
    4 => "Peilingen in Systeem",
    5 => "Stemmen"
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => "Er is een Fout opgetreden bij het verzenden van het bericht. Probeer het opnieuw.",
    2 => "Bericht met succes verzonden.",
    3 => "Controleer of het juiste email adres is in gevuld in het beantwoord aan veld.",
    4 => "Vul in de Uw Naam, Beantwoordt aan, Onderwerp, en Bericht velden",
    5 => "Fout: Deze gebruiker bestaat niet.",
    6 => "Er is een fout opgetreden.",
    7 => "Gebruiker Profiel voor",
    8 => "Gebruiker Naam",
    9 => "Gebruiker URL",
    10 => "Zendt mail naar",
    11 => "Uw Naam:",
    12 => "Beantwoord aan:",
    13 => "Onderwerp:",
    14 => "Bericht:",
    15 => "HTML wordt niet geconverteerd.",
    16 => "Bericht Verzenden",
    17 => "Mail Artikel naar Vriend(in)",
    18 => "Naar Naam",
    19 => "Naar Email Adres",
    20 => "Van Naam",
    21 => "Van Email Adres",
    22 => "Alle velden zijn vereist",
    23 => "Deze email is verzonden door $from at $fromemail omdat men dacht dat u geïnterresseerd bent in dit artikel van {$_CONF["site_url"]}.  This is not SPAM and the email addresses involved in this transaction were not saved to a list or stored for later use.",
    24 => "Reageer op dit Artikel bij",
    25 => "U moet ingelogd zijn, om van deze mogelijkheid gebruik te kunnen maken.  Doordat u ingelogd bent, helpt het ons te voorkomen dat er misbruik van het systeem wordt gemaakt",
    26 => "Dit formulier geeft u de mogelijkheid om een email naar de geselekteerde gebruiker te sturen.  Alle velden zijn vereist.",
    27 => "Kort bericht",
    28 => "$from schreef: $shortmsg",
    29 => "Dit is het dagelijks overzicht van {$_CONF['site_name']} voor ",
    30 => " Dagelijkse Niewsbrief voor ",
    31 => "Titel",
    32 => "Datum",
    33 => "Lees het volledige artikel bij",
    34 => "Eind van het Bericht"
);

###############################################################################
# search.php

$LANG09 = array(
    1 => "Geavanceerd Zoeken",
    2 => "Sleutel Woorden",
    3 => "Onderwerp",
    4 => "Alle",
    5 => "Type",
    6 => "Artikelen",
    7 => "Reacties",
    8 => "Auteurs",
    9 => "Alle",
    10 => "Zoek",
    11 => "Zoek Resultaten",
    12 => "gevonden",
    13 => "Zoek Resultaten: Niets gevonden",
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
    29 => "Artikel en Reactie Resultaten",
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
    1 => "Site Statistieken",
    2 => "Totaal aantal Hits in het Systeem",
    3 => "Artikelen(Reacties) in het Systeem",
    4 => "Peilingen(Stemmen) in het Systeem",
    5 => "Links(Klikken) in het Systeem",
    6 => "Evenementen in het Systeem",
    7 => "Top Tien Bekeken Artikelen",
    8 => "Artikel Titel",
    9 => "Bekeken",
    10 => "Het lijkt erop dat er geen artikelen op deze site staan, of niemand heeft ze ooit bekeken.",
    11 => "Top Tien Meest Gereageerde Artikelen",
    12 => "Reacties",
    13 => "Het lijkt erop dat er geen artikelen op deze site staan, of niemand heeft er ooit op gereageerd.",
    14 => "Top Tien Peilingen",
    15 => "Peiling Vragen",
    16 => "Stemmen",
    17 => "Het lijkt erop dat er geen peilingen op deze site staan, of niemand heeft ooit gestemd.",
    18 => "Top Tien Links",
    19 => "Links",
    20 => "Hits",
    21 => "Het lijkt erop dat er geen links op deze site staan, of niemand heeft er ooit één aangeklikt.",
    22 => "Top Tien Geëmailde Artikelen",
    23 => "Emails",
    24 => "Het lijkt erop dat er geen artikelen op deze site staan, of niemand heeft ze ooit geëmaild"
);

###############################################################################
# article.php

$LANG11 = array(
    1 => "Wat is Gerelateerd",
    2 => "Mail Artikel naar Vriend(in)",
    3 => "Afdrukbaar Artikel Formaat",
    4 => "Artikel Opties"
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => "Om een $type voor te stellen, is het vereist om als gebruiker te zijn ingelogd.",
    2 => "Inloggen",
    3 => "Nieuwe Gebruiker",
    4 => "Stel een Evenement voor",
    5 => "Stel een Link voor",
    6 => "Stel een Artikel voor",
    7 => "Inloggen is Vereist",
    8 => "Voorstellen",
    9 => "Indien u informatie voorstelt voor gebruik op deze site, vragen we de volgende suggesties te volgen...<ul><li>Vul alle velden in. deze zijn vereist<li>Lever complete en accurate informatie<li>Controleer deze URLs dubbel</ul>",
    10 => "Titel",
    11 => "Link",
    12 => "Start Datum",
    13 => "Eind Datum",
    14 => "Locatie",
    15 => "Omschrijving",
    16 => "Indien ander, specificeer aub",
    17 => "Categorie",
    18 => "Ander",
    19 => "Lees dit eerst",
    20 => "Fout: Geen Categorie ingvuld",
    21 => "Indien \"Ander\" geselekteerd, lever dan een ook een categorie naam",
    22 => "Fout: Niet alle velden Ingevuld",
    23 => "Vul alle velden van het formulier in. Alle velden zijn vereist.",
    24 => "Voorstel Opgeslagen",
    25 => "Uw $type voorstel is succesvol opgeslagen.",
    26 => "Snelheids Limiet",
    27 => "Gebruikersnaam",
    28 => "Onderwerp",
    29 => "Artikel",
    30 => "Uw laatste bijdrage was ",
    31 => " seconden geleden.  Deze site vereist ten minste {$_CONF["speedlimit"]} seconden tussen twee voorstellen voor plaatsing",
    32 => "Preview",
    33 => "Artikel Preview",
    34 => "Uitloggen",
    35 => "HTML tags zijn niet toegestaan",
    36 => "Post Mode",
    37 => "Een voorstel voor plaatsing van een evenement op {$_CONF["site_name"]} zet hem in de hoofdkalender waar gebruikers de optie hebben om deze aan hun persoonlijke kalender toe te voegen. Deze voorziening is <b>NIET</b> bedoeld voor persoonlijke evenementen, zoals verjaardagen en jubilea.<br><br>Als u een voorstel voor een evenement doet, wordt deze verstuurt naar onze beheerders en indien goedgekeurd, verschijnt deze in de hoofdkalender.",
    38 => "Voeg Evenement toe Aan",
    39 => "Hoofdkalender",
    40 => "Persoonlijke Kalender",
    41 => "Eind Tijd",
    42 => "Start Tijd",
    43 => "Gehele Dag Evenement",
    44 => "Adres Regel 1",
    45 => "Adres Regel 2",
    46 => "Plaats",
    47 => "Provincie",
    48 => "Postcode",
    49 => "Evenement Type",
    50 => "Wijzig Evenement Types",
    51 => "Locatie",
    52 => "Verwijder",
    53 => 'Maak Account aan'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
    1 => "Authorisatie Vereist",
    2 => "Geweigerd! Incorrecte in Log Informatie",
    3 => "Geen juist wachtwoord voor gebruiker",
    4 => "Gebruikersnaam:",
    5 => "Wachtwoord:",
    6 => "Alle toegang tot administratieve functies van deze web worden gelogged en bekeken.<br>Deze pagina is alleen voor geautoriseerde gebruikers.",
    7 => "inloggen"
);

###############################################################################
# block.php

$LANG21 = array(
    1 => "Insufficient Admin Rights",
    2 => "You do not have the necessary rights to edit this block.",
    3 => "Block Editor",
    4 => "",
    5 => "Block Title",
    6 => "Topic",
    7 => "All",
    8 => "Block Security Level",
    9 => "Block Order",
    10 => "Block Type",
    11 => "Portal Block",
    12 => "Normal Block",
    13 => "Portal Block Options",
    14 => "RDF URL",
    15 => "Last RDF Update",
    16 => "Normal Block Options",
    17 => "Block Content",
    18 => "Please fill in the Block Title, Security Level and Content fields",
    19 => "Block Manager",
    20 => "Block Title",
    21 => "Block SecLev",
    22 => "Block Type",
    23 => "Block Order",
    24 => "Block Topic",
    25 => "To modify or delete a block, click on that block below.  To create a new block click on new block above.",
    26 => "Layout Block",
    27 => "PHP Block",
      28 => "PHP Block Options",
      29 => "Block Function",
      30 => "If you would like to have one of your blocks use PHP code, enter the name of the function above.  Your function name must start with the prefix \"phpblock_\" (e.g. phpblock_getweather).  If it does not have this prefix, your function will NOT be called.  We do this to keep people who may have hacked your Geeklog installation from putting arbitrary function calls that may be harmful to your system.  Be sure not to put empty parenthisis \"()\" after your function name.  Finally, it is recommended that you put all your PHP Block code in /path/to/geeklog/system/lib-custom.php.  That will allow the code to stay with you even when you upgrade to a newer version of Geeklog.",
      31 => "Error in PHP Block.  Function, $function, does not exist.",
      32 => "Error Missing Field(s)",
      33 => "You must enter the URL to the .rdf file for portal blocks",
      34 => "You must enter the title and the function for PHP blocks",
      35 => "You must enter the title and the content for normal blocks",
      36 => "You must enter the content for layout blocks",
      37 => "Bad PHP block function name",
      38 => "Functions for PHP Blocks must have the prefix 'phpblock_' (e.g. phpblock_getweather).  The 'phpblock_' prefix is required for security reasons to prevent the execution of arbitrary code.",
    39 => "Side",
    40 => "Left",
    41 => "Right",
    42 => "You must enter the blockorder and security level for Geeklog default blocks",
    43 => "Homepage Only",
    44 => "Access Denied",
    45 => "You are trying to access a block that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/block.php\">go back to the block administration screen</a>.",
    46 => "New Block",
    47 => "Admin Home",
      48 => "Block Name",
      49 => " (no spaces and must be unique)",
      50 => "Help File URL",
      51 => "include http://",
      52 => "If you leave this blank the help icon for this block will not be displayed",
      53 => "Enabled",
      54 => "save",
      55 => "cancel",
      56 => "delete"

);

###############################################################################
# event.php

$LANG22 = array(
    1 => "Event Editor",
    2 => "",
    3 => "Event Title",
    4 => "Event URL",
    5 => "Event Start Date",
    6 => "Event End Date",
    7 => "Event Location",
    8 => "Event Description",
    9 => "(include http://)",
    10 => "You must provide the dates/times, description and event location!",
    11 => "Event Manager",
    12 => "To modify or delete a event, click on that event below.  To create a new event click on new event above.",
    13 => "Event Title",
    14 => "Start Date",
    15 => "End Date",
    16 => "Access Denied",
    17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/event.php\">go back to the event administration screen</a>.",
    18 => "New Event",
    19 => "Admin Home",
    20 => 'save',
    21 => 'cancel',
    22 => 'delete'

);

###############################################################################
# link.php

$LANG23 = array(
    1 => "Link Editor",
    2 => "",
    3 => "Link Title",
    4 => "Link URL",
    5 => "Category",
    6 => "(include http://)",
    7 => "Other",
    8 => "Link Hits",
    9 => "Link Description",
    10 => "You need to provide a link Title, URL and Description.",
    11 => "Link Manager",
    12 => "To modify or delete a link, click on that link below.  To create a new link click new link above.",
    13 => "Link Title",
    14 => "Link Category",
    15 => "Link URL",
    16 => "Access Denied",
    17 => "You are trying to access a link that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/link.php\">go back to the link administration screen</a>.",
    18 => "New Link",
    19 => "Admin Home",
    20 => "If other, specify",
    21 => 'save',
    22 => 'cancel',
    23 => 'delete'

);

###############################################################################
# story.php

$LANG24 = array(
    1 => "Previous Stories",
    2 => "Next Stories",
    3 => "Mode",
    4 => "Post Mode",
    5 => "Story Editor",
    6 => "There are no stories in the system",
    7 => "Author",
    8 => "save",
    9 => "preview",
    10 => "cancel",
    11 => "delete",
    12 => "",
    13 => "Title",
    14 => "Topic",
    15 => "Date",
    16 => "Intro Text",
    17 => "Body Text",
    18 => "Hits",
    19 => "Comments",
    20 => "",
    21 => "",
    22 => "Story List",
    23 => "To modify or delete a story, click on that story's number below. To view a story, click on the title of the story you wish to view. To create a new story click on new story above.",
    24 => "",
    25 => "",
    26 => "Story Preview",
    27 => "",
    28 => "",
    29 => "",
    30 => "",
    31 => "Please fill in the Author, Title and Intro Text fields",
    32 => "Featured",
    33 => "There can only be one featured story",
    34 => "Draft",
    35 => "Yes",
    36 => "No",
    37 => "More by",
    38 => "More from",
    39 => "Emails",
    40 => "Access Denied",
    41 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF["site_url"]}/admin/story.php\">go back to the story administration screen</a> when you are done.",
    42 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF["site_url"]}/admin/story.php\">go back to the story administration screen</a>.",
    43 => "New Story",
    44 => "Admin Home",
    45 => "Access",
    46 => "<b>NOTE:</b> if you modify this date to be in the future, this article will not be published until that date.  That also means the story will not be included in your RDF headline feed and it will be ignored by the search and statistics pages.",
    47 => "Images",
    48 => "image",
    49 => "right",
    50 => "left",
    51 => "To add one of the images you are attaching to this article you need to insert specially formated text.  The specially formated text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your story.<BR><P><B>PREVIEWING</B>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.",
    52 => "Delete",
    53 => "was not used.  You must include this image in the intro or body before you can save your changes",
    54 => "Attached Images Not Used",
    55 => "The following errors occured while trying to save your story.  Please correct these errors before saving",
    56 => "Show Topic Icon"
);

###############################################################################
# poll.php

$LANG25 = array(
    1 => "Mode",
    2 => "",
    3 => "Poll Created",
    4 => "Poll $qid saved",
    5 => "Edit Poll",
    6 => "Poll ID",
    7 => "(do not use spaces)",
    8 => "Appears on Homepage",
    9 => "Question",
    10 => "Answers / Votes",
    11 => "There was an error getting poll answer data about the poll $qid",
    12 => "There was an error getting poll question data about the poll $qid",
    13 => "Create Poll",
    14 => "save",
    15 => "cancel",
    16 => "delete",
    17 => "",
    18 => "Poll List",
    19 => "To modify or delete a poll, click on that poll.  To create a new poll click on new poll above.",
    20 => "Voters",
    21 => "Access Denied",
    22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/poll.php\">go back to the poll administration screen</a>.",
    23 => "New Poll",
    24 => "Admin Home",
    25 => "Yes",
    26 => "No"
);

###############################################################################
# topic.php

$LANG27 = array(
    1 => "Topic Editor",
    2 => "Topic ID",
    3 => "Topic Name",
    4 => "Topic Image",
    5 => "(do not use spaces)",
    6 => "Deleting a topic deletes all stories and blocks associated with it",
    7 => "Please fill in the Topic ID and Topic Name fields",
    8 => "Topic Manager",
    9 => "To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left. You will find your access level for each topic in parenthesis",
    10=> "Sort Order",
    11 => "Stories/Page",
    12 => "Access Denied",
    13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/topic.php\">go back to the topic administration screen</a>.",
    14 => "Sort Method",
    15 => "alphabetical",
    16 => "default is",
    17 => "New Topic",
    18 => "Admin Home",
    19 => 'save',
    20 => 'cancel',
    21 => 'delete'
);

###############################################################################
# user.php

$LANG28 = array(
    1 => "User Editor",
    2 => "User ID",
    3 => "User Name",
    4 => "Full Name",
    5 => "Password",
    6 => "Security Level",
    7 => "Email Address",
    8 => "Homepage",
    9 => "(do not use spaces)",
    10 => "Please fill in the Username, Full name, Security Level and Email Address fields",
    11 => "User Manager",
    12 => "To modify or delete a user, click on that user below.  To create a new user click the new user button to the left. You can do simple searches by entering parts of a username,email address or fullname (e.g.*son* or *.edu) in the form below.",
    13 => "SecLev",
    14 => "Reg. Date",
    15 => "New User",
    16 => "Admin Home",
    17 => "changepw",
    18 => "cancel",
    19 => "delete",
    20 => "save",
    18 => "cancel",
    19 => "delete",
    20 => "save",
    21 => "The username you tried saving already exists.",
    22 => "Error",
    23 => "Batch Add",
    24 => "Batch Import of Users",
    25 => "You can import a batch of users into Geeklog.  The import file must a tab-delimited text file and must have the fields in the following order: full name, username, email address.  Each user you import will be emailed with a random password.  You must have one user entered per line.  Failure to follow these instructions will cause problems that may require manual work so double check your entries!",
    26 => "Search",
    27 => "Limit Results",
    28 => "Check here to delete this picture",
    29 => 'Path',
    30 => 'Import',
    31 => 'New Users',
    32 => 'Done processing. Imported $successes and encountered $failures failures',
    33 => 'submit',
    34 => 'Error: You must specify a file to upload.'
);


###############################################################################
# moderation.php

$LANG29 = array(
    1 => "Approve",
    2 => "Delete",
    3 => "Edit",
    4 => 'Profile',
    10 => "Title",
    11 => "Start Date",
    12 => "URL",
    13 => "Category",
    14 => "Date",
    15 => "Topic",
    16 => 'User name',
    17 => 'Full name',
    18 => 'Email',
    34 => "Command and Control",
    35 => "Story Submissions",
    36 => "Link Submissions",
    37 => "Event Submissions",
    38 => "Submit",
    39 => "There are no submissions to moderate at this time",
    40 => "User Submissions"
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
    9 => "Site evenement",
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
    29 => "Publieke Kaalender",
    30 => "verwijder evenement",
    31 => "Voeg Toe",
    32 => "Evenement",
    33 => "Datum",
    34 => "Tijd",
    35 => "Snel Toevoegen",
    36 => "Voorstellen",
    37 => "Sorry, de persoonlijke kalender optie is niet beschikbaar op deze site",
    38 => "Persoonlijke Evenementen Editor",
    39 => 'Dag',
    40 => 'Week',
    41 => 'Maand'

);

###############################################################################
# admin/mail.php
$LANG31 = array(
    1 => $_CONF['site_name'] . " Mail Utility",
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
    20 => "Successfully sent <successcount> messages and unsuccessfully sent <failcount> messages.  If you need them, the details of each message attempts is below.  Otherwise you can <a href=\"" . $_CONF['site_url'] . "/admin/mail.php\">Send another message</a> or you can <a href=\"" . $_CONF['site_url'] . "/admin/moderation.php\">go back to the administration page</a>.",
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
    1 => "Uw wachtwoord is naar u ge-emaild, en kan elk moment in mailbox arriveren. Volg aub de instructies in het bericht, en we bedanken u voor het gebruik maken van " . $_CONF["site_name"],
    2 => "Bedankt voor uw bijdrage aan {$_CONF["site_name"]}.  Het is aan geboden aan de beheerders voor plaatsing. Indien geschikt bevonden, wordt het geplaatst op deze site.",
    3 => "Bedankt voor uw bijdrage aan {$_CONF["site_name"]}.  Het is aan geboden aan de beheerders voor plaatsing. Indien geschikt bevonden, zal uw link geplaatst worden in de <a href={$_CONF["site_url"]}/links.php>links</a> sectie.",
    4 => "Bedankt voor uw bijdrage aan {$_CONF["site_name"]}.  Het is aan geboden aan de beheerders voor plaatsing. Indien geschikt bevonden, zal uw evenement geplaatst worden in de <a href={$_CONF["site_url"]}/calendar.php>Kalendar</a> sectie.",
    5 => "Uw account informatie is opgeslagen.",
    6 => "Uw beeldinstellingen zijn opgeslagen.",
    7 => "Uw commentaar/reactie instellingen zijn opgeslagen.",
    8 => "U bent met succes uit gelogd.",
    9 => "Uw verhaal is opgeslagen.",
    10 => "Uw verhaal is verwijderd.",
    11 => "Uw blok is opgeslagen.",
    12 => "Uw blok is verwijderd.",
    13 => "Uw onderwerp is opgeslagen.",
    14 => "Uw onderwerp, en al zijn artikelen zijn verwijderd.",
    15 => "Uw link is opgeslagen.",
    16 => "Uw link is verwijderd.",
    17 => "Uw evenement is opgeslagen.",
    18 => "Uw evenement is verwijderd.",
    19 => "Uw peiling is opgeslagen.",
    20 => "Uw peiling is verwijderd.",
    21 => "De nieuwe gebruiker is opgeslagen.",
    22 => "De gebruiker is verwijderd",
    23 => "Er is een fout opgetreden bij het toevoegen van een evenement aan uw kalender. Er is geen evenement id aangemaat.",
    24 => "Het evenement is toegevoegd aan uw kalender",
    25 => "Kan uw persoonlijke kalender pas openen als u bent ingelogd",
    26 => "Het evenement is verwijderd van uw persoonlijke kalender",
    27 => "Bericht verstuurd.",
    28 => "De plug-in is opgeslagen",
    29 => "Sorry, persoonlijke kalenders zijn niet geactiveerd op deze site",
    30 => "Toegang Geweigerd",
    31 => "Sorry, u heeft geen toegang tot de artikel/verhaal administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen.",
    32 => "Sorry, u heeft geen toegang tot de onderwerpen administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
    33 => "Sorry, u heeft geen toegang tot de blok administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
    34 => "Sorry, u heeft geen toegang tot de links administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
    35 => "Sorry, u heeft geen toegang tot de evenementen administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
    36 => "Sorry, u heeft geen toegang tot de peilingen administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
    37 => "Sorry, u heeft geen toegang tot de gebruiker administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
    38 => "Sorry, u heeft geen toegang tot de plug-in administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
    39 => "Sorry, u heeft geen toegang tot de mail administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
    40 => "System Bericht",
      41 => "Sorry, u heeft geen toegang tot de woordvervang administratie pagina.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
      42 => "Het woord is opgeslagen.",
    43 => "Het woord is verwijderd.",
      44 => "De plug-in is geïnstalleerd!",
      45 => "De plug-in is verwijderd.",
      46 => "Sorry, u heeft geen toegang tot Database Backup Utility.  Let op alle pogingen om toegang te krijgen tot niet geauthoriseerde funkties worden opgeslagen",
      47 => "Deze funktie werkt allen onder *nix.  Indien u *nix gebruikt als besturingsysteem dan is uw cache geleegd. Indien u Windows gebruikt, moet u zoeken naar bestanden als adodb_*.php en handmatig verwijderen.",
      48 => 'Bedankt voor uw aanvraag voor een gebruikersaccount van ' . $_CONF['site_name'] . '. De beheerders zullen uw aanvraag bekijken. Indien goedgekeurd, wordt uw wachtwoord naar het email adres verstuurd dat u net heeft ingevuld.',
      49 => "De groep is opgeslagen.",
      50 => "De groep is verwijderd."
);

// for plugins.php

$LANG32 = array (
    1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=\"http://www.geeklog.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
    2 => "Plug-in Installation Disclaimer",
    3 => "Plug-in Installation Form",
    4 => "Plug-in File",
    5 => "Plug-in List",
    6 => "Warning: Plug-in Already Installed!",
    7 => "The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it",
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
    31 => "Are you sure you want to delete this plug-in?  By doing so you will remove all the files, data and data structures that this plug-in uses.  If you are sure, click delete again on the form below."
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
    editrootmsg => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF["site_admin_url"]}/user.php\">User Administration page</a>.",
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
    corerightsdescr => "This group is a core {$_CONF["site_name"]} Group.  Therefore the rights for this group cannot be edited.  Below is a read-only list of the rights this group has access to.",
    groupmsg => "Security Groups on this site are hierarchical.  By adding this group to any of the groups below you will giving this group the same rights that those groups have.  Where possible it is encouraged you use the groups below to give rights to a group.  If you need this group to have custom rights then you can select the rights to various site features in the section below called 'Rights'.  To add this group to any of the ones below simply check the box next to the group(s) that you want.",
    coregroupmsg => "This group is a core {$_CONF["site_name"]} Group.  Therefore the groups that this groups belongs to cannot be edited.  Below is a read-only list of the groups this group belongs to.",
    rightsdescr => "A groups access to a certain right below can be given directly to the group OR to a different group that this group is a part of.  The ones you see below without a checkbox are the rights that have been given to this group because it belongs to another group with that right.  The rights with checkboxes below are rights that can be given directly to this group.",
    lock => "Lock",
    members => "Members",
    anonymous => "Anonymous",
    permissions => "Permissions",
    permissionskey => "R = read, E = edit, edit rights assume read rights",
    edit => "Edit",
    none => "None",
    accessdenied => "Access Denied",
    storydenialmsg => "You do not have access to view this story.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
    eventdenialmsg => "You do not have access to view this event.  This could be because you aren't a member of {$_CONF["site_name"]}.  Please <a href=users.php?mode=new> become a member</a> of {$_CONF["site_name"]} to receive full membership access!",
    nogroupsforcoregroup => "This group doesn't belong to any of the other groups",
    grouphasnorights => "This group doesn't have access to any of the administrative features of this site",
    newgroup => "New Group",
    adminhome => "Admin Home",
    save => "save",
    cancel => "cancel",
      delete => "delete",
    canteditroot => "You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error"    
);

#admin/word.php
$LANG_WORDS = array(
    editor => "Word Replacment editor",
    wordid => "Word ID",
    intro => "To modify or delete a word, click on that word.  To create a new word replacement click the new word button to the left.",
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
    1 => "Thùs",
    2 => "Kontakt",
    3 => "Publiseer",
    4 => "Links",
    5 => "Peilingen",
    6 => "Kalendar",
    7 => "Site Stats",
    8 => "Personaliseer",
    9 => "Zoek",
    10 => "geadanceerd zoeken"
);

$LANG_404 = array(
    1 => "404 Error",
    2 => "Gee, I've looked everywhere but I can not find <b>%s</b>.",
    3 => "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href=\"{$_CONF['site_url']}\">main page</a> or the <a href=\"{$_CONF['site_url']}/search.php\">search page</a> to see if you can find what you lost."
);

$LANG_LOGIN = array (
    1 => 'Login required',
    2 => 'Sorry, to access this area you need to be logged in as a user.',
    3 => 'Login',
    4 => 'New User'
);

?>
