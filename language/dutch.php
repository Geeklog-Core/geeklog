<?php

###############################################################################
# dutch.php
#
# This is a complete dutch language page for GeekLog!
# Please contact Ko <ko@depree.nl> if you think anything
# important is missing ...
#
# Ported to level 1.3.8 by W. Niemans <niemans@pbsolo.nl>
# Ported to level 1.3.10 by Ko de Pree <ko@depree.nl>
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
    1 => 'Bijdrage van:',
    2 => 'lees verder',
    3 => 'reacties',
    4 => 'Wijzigen',
    5 => 'Stem',
    6 => 'Tussenstand',
    7 => 'Peilingsuitslag',
    8 => 'stemmen',
    9 => 'Beheerdersmenu:',
    10 => 'Ter beoordeling',
    11 => 'Artikelen',
    12 => 'Blokken',
    13 => 'Thema\'s',
    14 => 'Links',
    15 => 'Evenementen',
    16 => 'Peilingen',
    17 => 'Gebruikers',
    18 => 'SQL Query',
    19 => 'Uitloggen',
    20 => 'Mijn credits',
    21 => 'Gebruikersnaam',
    22 => 'Gebruikers ID',
    23 => 'Beveiligingsniveau',
    24 => 'Anoniem',
    25 => 'Reageer',
    26 => 'Reacties zijn voor verantwoording van degene die ze heeft geplaatst. Dit portaal is niet verantwoordelijk voor de inhoud.',
    27 => 'Laatste plaatsingen',
    28 => 'Verwijderen',
    29 => 'Geen reacties.',
    30 => 'Oudere artikelen',
    31 => 'Toegestane HTML Tags:',
    32 => 'Fout: ongeldige gebruikersnaam',
    33 => 'Fout: kan niet naar logbestand schrijven',
    34 => 'Fout',
    35 => 'Uitloggen',
    36 => 'aan',
    37 => 'Geen artikelen',
    38 => 'Content Syndication',
    39 => 'vernieuwen',
    40 => 'De instelling <tt>register_globals = Off</tt> is aanwezig in <tt>php.ini</tt>. Geeklog echter vereist dat <tt>register_globals</tt> ingesteld is op <strong>on</strong>. Voordat u verder gaat, gelieve dit op <strong>on</strong> in te stellen en herstart uw web server.',
    41 => 'Gast(en)',
    42 => 'Geschreven door:',
    43 => 'Hierop reageren',
    44 => 'Parent',
    45 => 'MySQL foutnummer',
    46 => 'MySQL foutmelding',
    47 => 'Gebruikersmenu',
    48 => 'Account informatie',
    49 => 'Voorkeuren',
    50 => 'Fout in SQL statement',
    51 => 'help',
    52 => 'Nieuw',
    53 => 'Beheerder Home',
    54 => 'Kan bestand niet openen.',
    55 => 'Fout in',
    56 => 'Stem',
    57 => 'Wachtwoord',
    58 => 'Inloggen',
    59 => "Heeft u nog geen account? <br> Meld u dan <strong>nu</strong> aan als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nieuwe gebruiker</a>",
    60 => 'Geef commentaar',
    61 => 'Aanmelden nieuw account',
    62 => 'woorden',
    63 => 'Artikel weergave',
    64 => 'Email artikel naar collega',
    65 => 'afdruk versie',
    66 => 'Mijn Kalender',
    67 => 'Welkom bij ',
    68 => 'home',
    69 => 'contact',
    70 => 'zoeken',
    71 => 'uw Bijdrage',
    72 => 'Links',
    73 => 'Opinie\'s',
    74 => 'Kalender',
    75 => 'gericht Zoeken',
    76 => 'Statistieken',
    77 => 'Plugins',
    78 => 'Komende evenementen',
    79 => 'Wat is nieuw',
    80 => 'artikelen in de laatste',
    81 => 'artikel in de laatste',
    82 => 'uren',
    83 => 'REACTIES',
    84 => 'LINKS',
    85 => 'afgelopen 48 uur',
    86 => 'Geen nieuwe reacties',
    87 => 'afgelopen 2 weken',
    88 => 'Geen recente nieuwe links',
    89 => 'Er zijn geen komende evenementen',
    90 => 'Home',
    91 => 'Deze pagina is aangemaakt in',
    92 => 'seconden',
    93 => 'Copyright',
    94 => 'Alle merknamen en copyrights op deze pagina zijn eigendom van hun respectievelijke eigenaren.',
    95 => 'Bemotord met',
    96 => 'Groepen',
    97 => 'Woorden lijst',
    98 => 'plugins',
    99 => 'ARTIKELEN',
    100 => 'Geen nieuwe artikelen',
    101 => 'Uw evenementen',
    102 => 'Evenementen',
    103 => 'DB Backups',
    104 => 'door',
    105 => 'Email gebruikers',
    106 => 'Opgevraagd',
    107 => 'GL Versie Test',
    108 => 'Leeg Cache',
    109 => 'Rapporteer misbruik',
    110 => 'Rapporteer dit bericht aan de sitebeheerder',
    111 => 'Bekijk de PDF-versie',
    112 => 'Geregistreerde gebruikers',
    113 => 'Documentatie',
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
    1 => 'Verstuur een reactie',
    2 => 'Opmaak',
    3 => 'Uitloggen',
    4 => 'Aanmelden account',
    5 => 'Gebruikersnaam',
    6 => 'Het portaal vereist dat u bent ingelogd om een reactie te versturen: log in a.u.b. Echter, indien u geen account heeft, kunt u het onderstaande formulier gebruiken om u aan te melden.',
    7 => 'Uw laatste reactie was ',
    8 => " seconden geleden. Een beveiliging vereist tenminste {$_CONF['commentspeedlimit']} seconden tussen reacties",
    9 => 'Reactie',
    10 => 'Send Report',
    11 => 'Verstuur reactie',
    12 => 'Vul a.u.b. de velden bij \'Titel\' en \'Reactie\' in. Deze zijn noodzakelijk voor het versturen van een reactie.',
    13 => 'Uw informatie',
    14 => 'Preview',
    15 => 'Rapporteer dit bericht',
    16 => 'Titel',
    17 => 'Fout',
    18 => 'Niet vergeten',
    19 => 'Houdt u a.u.b. bij het onderwerp.',
    20 => 'Probeer eerst op reactie\'s van anderen te reageren i.p.v. een nieuwe \'Thread\' te starten.',
    21 => 'Lees ook de andere berichten voordat u uw bericht gaat versturen. Dit, om te voorkomen dat vele identieke berichten ontstaan.',
    22 => 'Gebruik een helder onderwerp, dat uw bericht juist omschrijft.',
    23 => 'Uw email adres zal NIET worden weergegeven.',
    24 => 'Anonieme gebruiker',
    25 => 'Weet u zeker dat u dit bericht wilt rapporteren aan de sitebeheerder?',
    26 => '%s heeft de volgende commentaren met misbruik gerapporteerd:',
    27 => 'Misbruikrapport'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Profiel van',
    2 => 'GebruikersNaam',
    3 => 'Volledige Naam',
    4 => 'Wachtwoord',
    5 => 'Emailadres',
    6 => 'Homepage',
    7 => 'Bio/CV',
    8 => 'PGP Code',
    9 => 'Bewaar Informatie',
    10 => 'Laatste 10 reacties van gebruiker',
    11 => 'Geen reacties',
    12 => 'Voorkeuren voor',
    13 => 'Email\'s nachts verwerken',
    14 => 'Dit wachtwoord is gegenereerd door een zgn. randomizer. Het wordt aanbevolen om dit wachtwoord meteen te wijzigen. Om het wachtwoord te wijzigen, log in en klik op \'Account informatie\' van het \'Gebruikersmenu\'.',
    15 => "Uw {$_CONF['site_name']} account is aangemaakt. Om er gebruik van te maken, dient u in te loggen met gebruik van de onderstaande informatie. Bewaar dit bericht a.u.b. voor gebruik in de toekomst.",
    16 => 'Uw account informatie',
    17 => 'Account bestaat niet',
    18 => 'Het email adres lijkt geen bestaand adres',
    19 => 'De gebruikersnaam of het email adres is al in gebruik',
    20 => 'Het email adres lijkt geen juist email adres',
    21 => 'Fout aangetroffen',
    22 => "Aanmelding bij {$_CONF['site_name']}",
    23 => "Door het aanvragen van een account profiteert u van alle voordelen van {$_CONF['site_name']} portaal lidmaadschap en geeft u de mogelijkheid reacties en artikelen onder uw eigen naam te plaatsen. Indien u niet registreert, is dit alleen anoniem mogelijk. Let op, uw email adres zal <strong><i>nooit</i></strong> publiekelijk worden weergegeven op het portaal.",
    24 => 'Uw wachtwoord wordt verstuurd naar het email adres dat u invoert.',
    25 => 'Wachtwoord vergeten?',
    26 => 'Vul uw gebruikersnaam in en klik op \'Email wachtwoord\' en een nieuw wachtwoord wordt verstuurd naar het opgeslagen email adres. Indien u uw gebruikersnaam niet meer weet, kunt u ook volstaan met het invullen van uw emailadres.',
    27 => 'Registreer Nu!',
    28 => 'Email wachtwoord',
    29 => 'Uitgelogd van',
    30 => 'Ingelogd van',
    31 => 'De Functie die u wilt gebruiken, is alleen beschikbaar indien u bent ingelogd',
    32 => 'Ondertekening',
    33 => 'Nooit publiekelijk weergeven',
    34 => 'Dit is uw *echte* naam',
    35 => 'Vul wachtwoord in om deze te mogen wijzigen',
    36 => 'Begint met http://',
    37 => 'Toevoegen bij uw reacties',
    38 => 'Het is aan U! Iedereen kan dit lezen',
    39 => 'Uw openbare PGP key ',
    40 => 'Geen iconen voor Thema\'s tonen',
    41 => 'Beschikbaar voor moderator',
    42 => 'Datum formaat',
    43 => 'Maximum artikelen',
    44 => 'Geen blokken',
    45 => 'Toon voorkeuren voor',
    46 => 'Uitgesloten \'Items\' voor',
    47 => 'Nieuws blok instelling voor',
    48 => 'Thema\'s',
    49 => 'Geen iconen in artikelen',
    50 => 'Afvinken indien u geen interesse heeft',
    51 => 'Alleen de nieuwe artikelen',
    52 => 'Standaard is 10',
    53 => 'Ontvang de artikelen van overdag elke nacht',
    54 => 'Vink de thema\'s en auteurs aan die NIET wilt zien.',
    55 => 'Als u ze allemaal heeft afgevinkt, betekent dit dat u de standaard selektie wilt zien. Als u begint te selekteren, selekteer dan alles dat u wilt zien, omdat de standaardinstellingen worden genegeerd. Standaardinstellingen worden vet weergegeven.',
    56 => 'Auteurs',
    57 => 'Weergave',
    58 => 'Sorteer volgorde',
    59 => 'Reactie limiet',
    60 => 'Hoe wilt u dat reacties worden weergegeven?',
    61 => 'Nieuwste of oudste eerst?',
    62 => 'Standaard is 100',
    63 => "Uw wachtwoord is naar u verstuurd en zou op dit moment moeten arriveren. Volg a.u.b. de aanwijzingen in het bericht. Het wordt gewaardeerd, dat u gebruik maakt van {$_CONF['site_name']}",
    64 => 'Voorkeurinstellingen voor Reacties van',
    65 => 'Probeer opnieuw in te loggen',
    66 => "U heeft misschien een tikfout gemaakt bij het inloggen. Probeer het hieronder opnieuw. Bent u een <a href=\'{$_CONF['site_url']}/users.php?mode=new\'>nieuwe gebruiker</a>?",
    67 => 'Aangemeld sinds',
    68 => 'Mijn gegevens onthouden',
    69 => 'Hoe lang mogen we u onthouden nadat u bent ingelogd?',
    70 => "Pas de layout en inhoud aan van {$_CONF['site_name']}",
    71 => "Een mogelijkheid van {$_CONF['site_name']} is dat u de inhoud en de layout van wat u ontvangt kan aanpassen. Om van deze voorzieningen gebruik te maken dient u zich eerst te <a href=\'{$_CONF['site_url']}/users.php?mode=new\'>registeren</a> bij {$_CONF['site_name']}. Bent u al geregistreerd? Gebruik dan het login formulier, links om in te loggen!",
    72 => 'Skin',
    73 => 'Taal',
    74 => 'Pas het portaal aan uw wensen aan!',
    75 => 'Email thema\'s voor',
    76 => 'Indien u een thema uit de onderstaande lijst selecteert, ontvang u alle artikelen die hierin wordt geplaatst aan het eind van de dag thuis. Kies alleen de thema\'s waarin u bent geïnteresseerd!',
    77 => 'Foto',
    78 => 'Voeg een afbeelding toe van u zelf!',
    79 => 'Aanvinken om uw afbeelding te verwijderen',
    80 => 'Inloggen',
    81 => 'Verstuur email',
    82 => 'Laatste 10 artikelen van gebruiker',
    83 => 'Statistiek Plaatsingen van gebruiker',
    84 => 'Totaal aantal artikelen:',
    85 => 'Totaal aantal commentaren/reacties:',
    86 => 'Vindt alle bijdragen van',
    87 => 'Uw login naam',
    88 => "Iemand (waarschijnlijk uzelf) heeft een nieuw wachtwoord voor uw account -> %s <- aangevraagd bij {$_CONF['site_name']}, <{$_CONF['site_url']}>. Indien u daadwerkelijk een nieuw wachtwoord wilt ingeven, klik dan op de volgende link: ",
    89 => 'Indien u hier niet mee accoord gaat kunt u dit bericht negeren; de aanvraag wordt weer verwijderd (uw huidige wachtwoord blijft geldig).',
    90 => 'Gelieve een nieuw wachtwoord voor uw account hieronder in te vullen. Bemerk dat uw huidige wachtwoord nog steeds geldig is totdat dit formulier verstuurd is.',
    91 => 'Geef nieuw wachtwoord op',
    92 => 'Toets nieuw wachtwoord',
    93 => 'Uw laatste aanvraag voor een nieuw wachtwoord is %d seconden geleden. Het portaal vereist dat er minimaal %d seconden tussen dergelijke aanvragen verstrijken.',
    94 => 'Verwijder Account \'%s\'',
    95 => 'Klik op \'Verwijder Account\' hieronder om uw account uit de database te verwijderen. Merk op dat uw gepubliceerde artikelen en uw geplaatste reacties <strong>niet</strong> verwijderd worden, maar getoond worden als \'Anonymous\'.',
    96 => 'verwijder account',
    97 => 'Bevestig het verwijderen van uw Account',
    98 => 'Weet u zeker dat uw account verwijderd moet worden? U bent daarna niet meer in staat in te loggen op dit portaal (tenzij u zelf weer aanmeldt). Indien de gevolgen u duidelijk zijn, klik dan nogmaals op \'verwijder account\' in het formulier hieronder.',
    99 => 'Privacy Opties voor',
    100 => 'Email van Beheerder',
    101 => 'Accepteer email van beheerder(s)',
    102 => 'Email van Gebruikers',
    103 => 'Accepteer email van andere gebruikers',
    104 => 'Toon Online Status',
    105 => 'Vermeld me in het blok Who\'s Online',
    106 => 'Lokatie',
    107 => 'Zichtbaar in uw openbaar profiel',
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
    1 => 'Geen Nieuws om weer te geven',
    2 => 'Er zijn geen nieuwe artikelen om weer te geven. Er is misschien geen nieuws onder dit thema, of u bent hier niet voor geautoriseerd.',
    3 => 'voor thema %s',
    4 => 'Hoofdartikel',
    5 => 'Volgende',
    6 => 'Vorige',
    7 => 'Eerste',
    8 => 'Laatste'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Er is een fout opgetreden bij het verzenden van het bericht. Probeer het opnieuw.',
    2 => 'Bericht met succes verzonden.',
    3 => 'Controleer of het juiste email adres is ingevuld in het veld \'Antwoord naar\'.',
    4 => 'Vul de velden in: uw naam, antwoord naar, onderwerp, en bericht',
    5 => 'Fout: deze gebruiker bestaat niet.',
    6 => 'Er is een fout opgetreden.',
    7 => 'Profiel van',
    8 => 'Gebruiker Naam',
    9 => 'Gebruiker URL',
    10 => 'Stuur email naar',
    11 => 'Uw naam:',
    12 => 'Antwoord naar:',
    13 => 'Onderwerp:',
    14 => 'Bericht:',
    15 => 'HTML wordt niet geconverteerd.',
    16 => 'Bericht versturen',
    17 => 'Email artikel naar collega',
    18 => 'Naam naar',
    19 => 'Email adres naar',
    20 => 'Naam van',
    21 => 'Email adres van',
    22 => 'Alle velden zijn vereist',
    23 => "Deze email is verstuurd door %s at %s om u op de hoogte te brengen van dit artikel van {$_CONF['site_url']}. Dit is geen SPAM en de email adressen in dit bericht zijn NERGENS anders opgeslagen.",
    24 => 'Reageer op dit artikel bij',
    25 => 'U moet ingelogd zijn, om van deze mogelijkheid gebruik te kunnen maken. Doordat u ingelogd bent, kan worden voorkomen dat er misbruik van het portaal wordt gemaakt',
    26 => 'Dit formulier geeft u de mogelijkheid om een email naar de geselekteerde gebruiker te sturen. Alle velden zijn vereist.',
    27 => 'Kort bericht',
    28 => '%s schreef: ',
    29 => "Dit is het dagelijks overzicht van {$_CONF['site_name']} voor ",
    30 => ' Dagelijkse nieuwsbrief voor ',
    31 => 'Titel',
    32 => 'Datum',
    33 => 'Lees het volledige artikel bij',
    34 => 'Eind van het Bericht',
    35 => 'Helaas, deze gebruiker accepteert geen email.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Gericht Zoeken',
    2 => 'Trefwoorden',
    3 => 'Thema',
    4 => 'Alle',
    5 => 'Type',
    6 => 'Artikelen',
    7 => 'Reacties',
    8 => 'Auteurs',
    9 => 'Alle',
    10 => 'Zoek',
    11 => 'Zoek resultaten',
    12 => 'gevonden',
    13 => 'Zoek resultaten: niets gevonden',
    14 => 'Er is niets gevonden bij het zoeken naar',
    15 => 'Probeer opnieuw.',
    16 => 'Titel',
    17 => 'Datum',
    18 => 'Auteur',
    19 => "Zoek in de gehele {$_CONF['site_name']} database van nieuwe en oude artikelen",
    20 => 'Datum',
    21 => 'tot',
    22 => '(Datum Formaat JJJJ-MM-DD)',
    23 => 'Hits',
    24 => 'Gevonden',
    25 => 'gevonden voor',
    26 => 'items in',
    27 => 'seconden',
    28 => 'Geen artikel of reactie komt overeen met uw zoekopdracht',
    29 => 'Artikel en reactie resultaten',
    30 => 'Geen link komt overeen met uw zoekopdracht',
    31 => 'Deze plugin gaf geen resultaat',
    32 => 'Evenement',
    33 => 'URL',
    34 => 'Locatie',
    35 => 'Gehele Dag',
    36 => 'Geen evenement komt overeen met uw zoekopdracht',
    37 => 'Evenement Resultaat',
    38 => 'Link Resultaat',
    39 => 'Links',
    40 => 'Evenementen',
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
    57 => 'OF',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Portaal statistieken',
    2 => 'Totaal aantal treffers in het portaal',
    3 => 'Aantal Artikelen (Reacties) in het portaal',
    4 => 'Aantal Peilingen (Stemmen) in het portaal',
    5 => 'Aantal Links (Klikken) in het portaal',
    6 => 'Aantal Evenementen in het portaal',
    7 => 'Top Tien opgevraagde artikelen',
    8 => 'Artikel titel',
    9 => 'Opgevraagd',
    10 => 'Het lijkt erop dat er geen artikelen op deze site staan, of ze zijn nooit opgevraagd.',
    11 => 'Top Tien Artikelen met meeste reacties',
    12 => 'Reacties',
    13 => 'Het lijkt erop dat er geen artikelen op deze site staan, of er is nooit op gereageerd.',
    14 => 'Top Tien Peilingen',
    15 => 'Peiling vragen',
    16 => 'Stemmen',
    17 => 'Het lijkt erop dat er geen peilingen op deze site staan, of er is nog nooit gestemd.',
    18 => 'Top Tien Links',
    19 => 'Links',
    20 => 'Hits',
    21 => 'Het lijkt erop dat er geen links op deze site staan, of ze zijn nooit aangeklikt.',
    22 => 'Top Tien Artikelen via email',
    23 => 'Emails',
    24 => 'Het lijkt erop dat er geen artikelen op deze site staan, of niemand is er op geabonneerd',
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
    1 => 'Gerelateerd',
    2 => 'Email artikel naar collega',
    3 => 'Afdrukversie artikel',
    4 => 'Artikel opties',
    5 => 'PDF formaat'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Om een %s voor te stellen, is het vereist om als gebruiker te zijn ingelogd.',
    2 => 'Inloggen',
    3 => 'Nieuwe gebruiker',
    4 => 'Stel een Evenement voor',
    5 => 'Stel een Link voor',
    6 => 'Stel een Artikel voor',
    7 => 'Inloggen is vereist',
    8 => 'Voorstellen',
    9 => 'Indien u informatie voorstelt voor gebruik op dit portaal, vordt u verzocht om de volgende suggesties te volgen...<ul><li>Vul alle velden in. Deze zijn vereist.</li><li>Lever complete en accurate informatie.</li><li>Controleer de op te geven URLs dubbel.</li></ul>Dank u wel.',
    10 => 'Titel',
    11 => 'Link',
    12 => 'Start Datum',
    13 => 'Eind Datum',
    14 => 'Locatie',
    15 => 'Omschrijving',
    16 => 'Indien anders, specificeer a.u.b.',
    17 => 'Categorie',
    18 => 'Anders',
    19 => 'Lees dit eerst',
    20 => 'Fout: Geen Categorie ingevuld',
    21 => 'Indien \'Anders\' geselekteerd: lever dan een ook een categorie naam',
    22 => 'Fout: niet alle velden Ingevuld',
    23 => 'Vul alle velden van het formulier in. Alle velden zijn vereist.',
    24 => 'Voorstel opgeslagen',
    25 => 'Uw %s voorstel is succesvol opgeslagen.',
    26 => 'Snelheids limiet',
    27 => 'Gebruikersnaam',
    28 => 'Thema',
    29 => 'Artikel',
    30 => 'Uw laatste bijdrage was ',
    31 => " seconden geleden. Het portaal vereist ten minste {$_CONF['speedlimit']} seconden tussen twee voorstellen voor plaatsing",
    32 => 'Preview',
    33 => 'Artikel preview',
    34 => 'Uitloggen',
    35 => 'HTML tags zijn niet toegestaan',
    36 => 'Opmaak',
    37 => "Een voorstel voor plaatsing van een evenement op het {$_CONF['site_name']}, wordt in de hoofdkalender geplaatst. De gebruikers hebben de optie om deze aan hun persoonlijke kalender toe te voegen. Deze voorziening is <strong>NIET</strong> bedoeld voor persoonlijke evenementen, zoals verjaardagen en jubilea.<br><br>Als u een voorstel voor een evenement doet, wordt deze eerst verstuurt naar een beheerder en indien goedgekeurd, verschijnt deze in de hoofdkalender.",
    38 => 'Evenement toevoegen aan',
    39 => 'Hoofdkalender',
    40 => 'Persoonlijke Kalender',
    41 => 'Eind Tijd',
    42 => 'Begin Tijd',
    43 => 'Gehele Dag',
    44 => 'Adres regel 1',
    45 => 'Adres regel 2',
    46 => 'Plaats',
    47 => 'Provincie',
    48 => 'Postcode',
    49 => 'Evenement Type',
    50 => 'Wijzig Evenement Types',
    51 => 'Locatie',
    52 => 'Verwijderen',
    53 => 'Aanmelden account'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'autorisatie is vereist',
    2 => 'Geweigerd! Incorrecte Login informatie',
    3 => 'Geen juist wachtwoord voor gebruiker',
    4 => 'Gebruikersnaam:',
    5 => 'Wachtwoord:',
    6 => 'Alle toegang tot administratieve functies van het portaal wordt vastgelegd en later bekeken.<br>Deze pagina is alleen voor geautoriseerde gebruikers.',
    7 => 'inloggen'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Onvoldoende rechten',
    2 => 'U bent niet geautoriseerd om dit blok te wijzigen.',
    3 => 'Blok Editor',
    4 => 'Er was een probleem met het lezen van deze feed (kijk in de error.log voor meer informatie).',
    5 => 'Blok titel',
    6 => 'Thema',
    7 => 'Overal',
    8 => 'Blok beveiligingsniveau',
    9 => 'Blok volgorde',
    10 => 'Blok Type',
    11 => 'Portaal Blok',
    12 => 'Normaal Blok',
    13 => 'Portaal Blok opties',
    14 => 'RDF URL',
    15 => 'Laatste RDF Update',
    16 => 'Normaal Blok opties',
    17 => 'Blok Inhoud',
    18 => 'Vult u a.u.b. de velden in bij \'Blok Titel\' en \'Inhoud\'',
    19 => 'Blok Manager',
    20 => 'Blok Titel',
    21 => 'Beveiliginsniveau',
    22 => 'Blok Type',
    23 => 'Blok Volgorde',
    24 => 'Blok Thema',
    25 => 'Om een blok te wijzigen of te verwijderen, klikt u op dat blok hieronder. Om een nieuw blok aan te maken klikt u op \'nieuw blok\' hierboven.',
    26 => 'Layout Blok',
    27 => 'PHP Blok',
    28 => 'PHP Blok opties',
    29 => 'Blok Menu',
    30 => 'Indien u PHP code wenst te gebruiken in een van de blokken, vul dan de naam van de php-funktie hierboven in. Deze naam moet beginnen met de prefix \'phpblock_\' (e.g. phpblock_hello_world). Zonder deze prefix wordt de funktie NIET aangeroepen. Dit is een beveiligingsmaatregel om niet zomaar willekeurige kode te moeten accepteren, die wellicht de integriteit kunnen schaden.<br>Zorg er ook voor dat er \'lege haakjes\' \'()\' staan achter de funktienaam in de broncode.<br>Tenslotte: het wordt aanbevolen dat alle PHP-blok-code in /pad/naar/geeklog/system/lib-custom.php wordt opgenomen. Bij nieuwe versies blijft de code gehandhaafd.',
    31 => 'Fout in PHP Blok. Funktie, %s, bestaat niet.',
    32 => 'Fout: niet alle velden doorgegeven.',
    33 => 'Er wordt een URL gevraagd voor het .rdf bestand (portaal blokken)',
    34 => 'Gelieve de titel en de funktie voor PHP blokken op te geven.',
    35 => 'Gelieve de titel en de inhoud op te geven (normale blokken)',
    36 => 'Gelieve de inhoud op te geven (layout blokken)',
    37 => 'Ongeldige PHP blok funktienaam',
    38 => 'Funktie voor PHP blokken moeten de prefix \'phpblock_\' (e.g. phpblock_hello_world) bevatten. Deze prefix is vereist ter beveiliging: het voorkomt de uitvoering van willekeurige PHP-code.',
    39 => 'Zijde',
    40 => 'Links',
    41 => 'Rechts',
    42 => 'Gelieve de bloktitel en de blokvolgorde op te geven (standaard blokken).',
    43 => 'Alleen Homepagina',
    44 => 'Geen toegang',
    45 => "U heeft geprobeerd een blok op te roepen zonder geldige autorisatie. De poging is vastgelegd. <a href=\'{$_CONF['site_url']}/admin/block.php\'>Terug naar de blok administratie pagina</a>.",
    46 => 'Nieuw blok',
    47 => 'Beheerder Home',
    48 => 'Blok Naam',
    49 => ' (zonder spaties en verplicht unieke naam)',
    50 => 'Help File URL',
    51 => 'inclusief http://',
    52 => 'Indien u dit niet invult, verschijnt er geen help icon in dit blok.',
    53 => 'Opname Toestaan',
    54 => 'opslaan',
    55 => 'annuleren',
    56 => 'verwijderen',
    57 => 'Verplaats blok naar beneden',
    58 => 'Verplaats blok naar boven',
    59 => 'Verplaats blok naar de rechterzijde',
    60 => 'Verplaats blok naar de linkerzijde',
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
    1 => 'Vorige Artikelen',
    2 => 'Volgende Artikelen',
    3 => 'Opties',
    4 => 'Opmaak',
    5 => 'Artikel Editor',
    6 => 'Er bestaan (nog) geen Artikelen in het portaal',
    7 => 'Auteur',
    8 => 'opslaan',
    9 => 'preview',
    10 => 'annuleren',
    11 => 'verwijderen',
    12 => 'ID',
    13 => 'Titel',
    14 => 'Thema',
    15 => 'Datum',
    16 => 'Introductie Tekst',
    17 => 'Body Tekst',
    18 => 'Treffers',
    19 => 'Opmerkingen',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Artikel Lijst',
    23 => 'Om een Artikel te wijzigen of te verwijderen, klik op het betreffende artikelnummer hieronder. Om een artikel op te roepen, klik op de titel van het betreffende Artikel. Om een nieuw Artikel aan te leggen, klik op \'Nieuw Artikel\' hierboven.',
    24 => 'De ID die u voor dit artikel heeft gekozen is reeds in gebruik. Kies een andere ID a.u.b.',
    25 => 'Error when saving story',
    26 => 'Artikel Preview',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'Er zijn File Upload Fouten',
    31 => 'Gelieve de Auteur, Titel en Introductie Tekst te vermelden.',
    32 => 'HoofdArtikel',
    33 => 'Er kan slechts een enkel HoofdArtikel actief zijn !!',
    34 => 'Draft',
    35 => 'Ja',
    36 => 'Nee',
    37 => 'Meer door..',
    38 => 'Meer van..',
    39 => 'Emails',
    40 => 'Geen toegang',
    41 => "U heeft geprobeerd een artikel op te roepen zonder geldige autorisatie. De poging is vastgelegd. Het Artikel is hieronder weergegeven. <a href=\'{$_CONF['site_url']}/admin/story.php\'>Terug naar de artikel administratie pagina</a>.",
    42 => "U heeft geprobeerd een artikel op te roepen zonder geldige autorisatie. De poging is vastgelegd. <a href=\'{$_CONF['site_url']}/admin/story.php\'>Terug naar de artikel administratie pagina</a>.",
    43 => 'Nieuw Artikel',
    44 => 'Beheerder Home',
    45 => 'Toegang',
    46 => '<strong>NOTE:</strong> indien de datum in de toekomst ligt, wordt het Artikel pas op die datum gepubliceerd. Dat houdt tevens in dat het artikel niet in de RDF headline feed opgenomen wordt en dat de zoek funktie het buiten beschouwing laat. Er zijn dan ook geen statistieken.',
    47 => 'Beelden',
    48 => 'beeld',
    49 => 'rechts',
    50 => 'links',
    51 => 'Om de beelden die hier ingesloten zijn, in het Artikel op te nemen is speciaal geformatteerde tekst nodig. Kies uit: [imageX], [imageX_right] or [imageX_left] en vervang de X door het nummer van het beeld dat u bijsluit. NOTE: Bijgesloten beelden MOETEN gebruikt worden. Indien u dat vergeet kan het Artikel niet opgeslagen worden.<br><p><strong>PREVIEW</strong>: Het is gemakkelijker een Preview van een Artikel met beelden op te roepen NADAT het opgeslagen is in draft-vorm, IN PLAATS VAN direkt de preview knop aan te klikken. Gebruik de preview knop alleen indien er geen beelden bijgesloten zijn.',
    52 => 'Verwijderen',
    53 => 'werd niet vermeld. Dit beeld MOET opgenomen worden in de introductie of Body voordat uw werk opgeslagen kan worden.',
    54 => 'Bijgesloten beelden zijn niet opgenomen in tekst',
    55 => 'De hierna volgende problemen zijn opgetreden bij het opslaan van uw artikel. Gelieve deze op te lossen en daarna opnieuw op te slaan.',
    56 => 'Toon Thema Icon',
    57 => 'Toon beeld in originele grootte',
    58 => 'Story Management',
    59 => 'Optie',
    60 => 'Toegestaan',
    61 => 'Auto archiveren',
    62 => 'Auto verwijderen',
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
    1 => 'Thema Editor',
    2 => 'Thema ID',
    3 => 'Thema Naam',
    4 => 'Thema Beeld',
    5 => '(zonder spaties)',
    6 => 'Het verwijderen van een Thema is recursief. Alle bijbehorende Artikelen en Blokken worden tevens verwijderd',
    7 => 'Gelieve het Thema ID en de Thema Naam in te vullen.',
    8 => 'Thema Manager',
    9 => 'Om een Thema te wijzigen of te verwijderen, klik op het betreffende Thema. Uw toegangsniveau voor ieder Thema staat daar tussen haakjes.<br>Om een nieuw Thema aan te leggen, klik op \'Nieuw Thema\' hierboven.',
    10 => 'Sorteer Volgorde',
    11 => 'Artikelen/Pagina',
    12 => 'Geen toegang',
    13 => "U heeft geprobeerd een Thema op te roepen zonder geldige autorisatie. De poging is vastgelegd. <a href=\'{$_CONF['site_url']}/admin/topic.php\'>Terug naar de Thema administratie pagina</a>.",
    14 => 'Sorteer Methode',
    15 => 'alfabetisch',
    16 => 'standaard is',
    17 => 'Nieuw Thema',
    18 => 'Beheerder Home',
    19 => 'opslaan',
    20 => 'annuleren',
    21 => 'verwijderen',
    22 => 'Standaard',
    23 => 'Verhef dit thema tot standaard voor nieuwe artikelen',
    24 => '(*)',
    25 => 'Archief Topic',
    26 => 'maak hiervan uw standaard topic voor gearchiveerde artikelen. Slechts 1 topic is toegestaan.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Gebruiker Editor',
    2 => 'Gebruiker ID',
    3 => 'Gebruiker Naam',
    4 => 'Volledige Naam',
    5 => 'Wachtwoord',
    6 => 'Toegangs Niveau',
    7 => 'Email adres',
    8 => 'Homepagina',
    9 => '(zonder spaties)',
    10 => 'Gelieve de Gebruiker Naam, Volledige naam, toegangsniveau en emailadres in te vullen.',
    11 => 'Gebruiker Manager',
    12 => 'Om een Gebruiker te wijzigen of te verwijderen, klik op de betreffende Gebruiker hieronder. Om een nieuwe Gebruiker aan te leggen, klik op \'Nieuwe Gebruiker\' hierboven. Er kan eenvoudig gezocht worden op delen van een Gebruiker Naam, email adres of van de Volledige naam (e.g.*sen* or *.nl).',
    13 => 'ToegangsNiveau',
    14 => 'Reg. Datum',
    15 => 'Nieuwe Gebruiker',
    16 => 'Beheerder Home',
    17 => 'wachtwoord wijzigen',
    18 => 'annuleren',
    19 => 'verwijderen',
    20 => 'opslaan',
    21 => 'De gebruikernaam bestaat reeds.',
    22 => 'Fout',
    23 => 'In Batch Toevoegen',
    24 => 'Batch Import van Gebruikers',
    25 => 'Een batch met gebruikers kan geimporteerd worden. Het import bestand is dan een tab-delimited tekst bestand en heeft de velden in de volgende layout: Volledige Naam, gebruikersnaam, email adres. Aan elke zo toegevoegde Gebruiker wordt daarna een email verstuurd met een willekeurig wachtwoord. Slechts een enkele Gebruiker per regel! Het niet volgen van deze instructies veroorzaakt problemen die uitsluitend met handwerk opgelost kunnen worden. Dubbelcheck de invullingen !!',
    26 => 'Zoek',
    27 => 'Limiteer Resultaten',
    28 => 'Vink aan om dit beeld te verwijderen',
    29 => 'Pad',
    30 => 'Import',
    31 => 'Nieuwe Gebruiker',
    32 => 'Klaar met verwerken. %d geimporteerd en %d geweigerd',
    33 => 'submit',
    34 => 'Fout: specificeer een bestand voor upload.',
    35 => 'Laatste Login',
    36 => '(nooit)',
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
    1 => 'Goedkeuren',
    2 => 'Verwijderen',
    3 => 'Wijzigen',
    4 => 'Profiel',
    10 => 'Titel',
    11 => 'Start Datum',
    12 => 'URL',
    13 => 'Categorie',
    14 => 'Datum',
    15 => 'Thema',
    16 => 'Gebruiker naam',
    17 => 'Volledige naam',
    18 => 'Email',
    34 => 'Moderator Menu',
    35 => 'Voorgedragen Artikel(en)',
    36 => 'Voorgedragen Link(s)',
    37 => 'Voorgedragen Evenement(en)',
    38 => 'Submit',
    39 => 'Er is niets te modereren op dit moment',
    40 => 'Nieuwe Gebruiker(s)'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Email faciliteit",
    2 => 'Van',
    3 => 'Antwoord aan',
    4 => 'Onderwerp',
    5 => 'Inhoud',
    6 => 'Verstuur naar:',
    7 => 'Alle gebruikers',
    8 => 'Beheerder',
    9 => 'Opties',
    10 => 'HTML',
    11 => 'Belangrijk bericht!',
    12 => 'Verstuur',
    13 => 'Herstel',
    14 => 'Instellingen van de gebruiker negeren',
    15 => 'Probleem tijdens verzending naar: ',
    16 => 'Bericht met succes gezonden naar: ',
    17 => "<a href=\'{$_CONF['site_url']}/admin/mail.php\'>Stuur nog een bericht</a>",
    18 => 'To',
    19 => 'NOTE: Indien u een bericht wilt sturen aan alle portaal leden, kies dan de \'Logged-in\' groep.',
    20 => "<successcount> berichten verstuurd en <failcount> fouten. Onderstaand vindt u de details van elk bericht ter controle. U kunt nu ook <a href=\'{$_CONF['site_url']}/admin/mail.php\'>nog een bericht versturen</a> of <a href=\'{$_CONF['site_url']}/admin/moderation.php\'>terug gaan naar de administratie pagina</a>.",
    21 => 'Fouten',
    22 => 'Succes',
    23 => 'Geen fouten',
    24 => 'Niets verstuurd',
    25 => '-- Selekteer Group --',
    26 => 'Gelieve alle velden van het formulier in te vullen en tevens een groep gebruikers te kiezen.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Het installeren van plugins kan het portaal als geheel beschadigen en, mogelijk ook, de achterliggende databases. Het is zeer belangrijk dat u alleen plugins van <a href="http://www.geeklog.net">Geeklog Homepage</a> instaleerd, omdat deze degelijk getest zijn. Het is ook belangrijk dat u inziet dat de installatie enige \'onveilige\' commando\'s bevat die kunnen leiden tot beveiligingsproblemen. Dit vergt bijzondere aandacht voor plugins van derden. Zelfs indien u deze waarschuwing ter harte neemt, kan de veiligheid en correctheid van de installatieprocedure niet gegarandeerd worden. De verantwoordelijkheid ligt exclusief bij U! Anders gezegd: installeer op eigen risico. Wees voorzichtig en lees de installatievoorschriften die bij elke plugin meekomen. Tenslotte: volg deze op.',
    2 => 'plugin Installatie Disclaimer',
    3 => 'plugin Installatie Formulier',
    4 => 'plugin File',
    5 => 'plugin Lijst',
    6 => 'Waarschuwing: Deze plugin is al Actief!',
    7 => 'De plugin die u probeert te installeren is er al. gelieve eerst deze plugin te verwijderen voordat u de installatie opnieuw probeert.',
    8 => 'Plugin Compatibility Check Failed',
    9 => 'Deze plugin vereist een latere versie van Geeklog. Gelieve deze versie van <a href=http://www.geeklog.net>Geeklog</a> te upgraden of een nieuwere versie op te halen van deze plugin.',
    10 => '<br><strong>Er zijn geen plugins actief op dit moment.</strong><br><br>',
    11 => 'Om een plugin te wijzigen of te verwijderen, klik op het nummer van deze plugin\'s hieronder. Dit laat u de detailles zien, inclusief de website van de auteur. Tevens worden de versies van de plugins getoond. Dit helpt u bij de vraag of plugin\'s ge-upgrade moeten worden. Raadpleeg de documentatie voordat u een plugin installeert of upgrade. Om een introductie over deze plugin op te vragen, klik op de naam van de plugin, dit brengt u naar de website van de plugin.',
    12 => 'geen Naam voor de plugin gevonden door de plugineditor()',
    13 => 'Plugin Editor',
    14 => 'Nieuwe plugin',
    15 => 'Beheerder Home',
    16 => 'plugin Naam',
    17 => 'plugin Versie',
    18 => 'Geeklog Versie',
    19 => 'Toestaan',
    20 => 'Ja',
    21 => 'Nee',
    22 => 'Installeer',
    23 => 'Bewaar',
    24 => 'annuleren',
    25 => 'Verwijderen',
    26 => 'plugin Naam',
    27 => 'plugin Homepage',
    28 => 'Geïnstalleerde Versie',
    29 => 'Geeklog Versie',
    30 => 'plugin Verwijderen?',
    31 => 'Weet u het zeker dat deze plugin verwijderd mag worden? Let op! Hiermee worden tevens alle bestanden, data en structuren verwijderd die deze plugin gebruikt. Alleen als u zeker bent, klikt u nogmaals op \'Verwijderen\' in het formulier hieronder.',
    32 => '<p><b>Fout, AutoLinktag heeft niet het juiste formaat</b></p>',
    33 => 'Codeversie',
    34 => 'Vernieuw',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'aanmaken feed',
    2 => 'opslaan',
    3 => 'verwijderen',
    4 => 'annuleren',
    10 => 'Content Syndication',
    11 => 'Nieuwe Feed',
    12 => 'Beheerder Home',
    13 => 'Om een feed te wijzigen of te verwijderen, klikt u op de feed\'s tiel hieronder. Om een nieuwe feed aan te maken, klikt u op \'Nieuwe Feed\' hierboven.',
    14 => 'Titel',
    15 => 'Type',
    16 => 'Bestandsnaam',
    17 => 'Formaat',
    18 => 'laatste wijziging',
    19 => 'Actief',
    20 => 'Ja',
    21 => 'Nee',
    22 => '<i>(geen feeds)</i>',
    23 => 'alle Artikelen',
    24 => 'Feed Editor',
    25 => 'Feed Titel',
    26 => 'Limiet',
    27 => 'Lengte van de entries',
    28 => '(0 = geen tekst, 1 = alle tekst, anders = maximaal aanal karakters.)',
    29 => 'Beschrijving',
    30 => 'Laatste Wijziging',
    31 => 'Karakter Set',
    32 => 'Taal',
    33 => 'Inhoud',
    34 => 'Entries',
    35 => 'Uren',
    36 => 'Selecteer type van feed',
    37 => 'Er is minstens een plugin actief die content syndication ondersteunt. Het is nodig dat u hieronder aangeeft of er sprake is van een Geeklog feed of van een feed uit een van de plugins.',
    38 => 'Fout: Niet alles ingevuld',
    39 => 'Gelieve de \'Feed Titel\', \'beschrijving\', en \'Filename\' in te vullen.',
    40 => 'Gelieve het \'aantal entries\' of \'aantal uren\' op te geven.',
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
    1 => "Uw wachtwoord is naar u verstuurd, en kan elk moment in uw inbox arriveren. Volg a.u.b. de instructies in het bericht, en we bedanken u voor het gebruik maken van {$_CONF['site_name']}",
    2 => "Bedankt voor uw bijdrage aan {$_CONF['site_name']}. Het is aan een beheerder aangeboden voor plaatsing. Indien geschikt bevonden, wordt het geplaatst op het portaal.",
    3 => "Bedankt voor uw bijdrage aan {$_CONF['site_name']}. Het is aan een beheerder aangeboden voor plaatsing. Indien geschikt bevonden, zal uw link geplaatst worden in het <a href={$_CONF['site_url']}/links.php>links</a> gedeelte.",
    4 => "Bedankt voor uw bijdrage aan {$_CONF['site_name']}. Het is aan een beheerder aangeboden voor plaatsing. Indien geschikt bevonden, zal uw evenement geplaatst worden in het <a href={$_CONF['site_url']}/calendar.php>Kalender</a> gedeelte.",
    5 => 'Uw account informatie is opgeslagen.',
    6 => 'Uw voorkeuren zijn opgeslagen.',
    7 => 'Uw instellingen voor commentaar/reactie zijn opgeslagen.',
    8 => 'U bent met succes uitgelogd.',
    9 => 'Het artikel is opgeslagen.',
    10 => 'Het artikel is verwijderd.',
    11 => 'Het blok is opgeslagen.',
    12 => 'Het blok is verwijderd.',
    13 => 'Het thema is opgeslagen.',
    14 => 'Het thema, en al de bijbehorende artikelen zijn verwijderd.',
    15 => 'De link is opgeslagen.',
    16 => 'De link is verwijderd.',
    17 => 'Het evenement is opgeslagen.',
    18 => 'Het evenement is verwijderd.',
    19 => 'Uw peiling is opgeslagen.',
    20 => 'Uw peiling is verwijderd.',
    21 => 'De gebruiker is opgeslagen.',
    22 => 'De gebruiker is verwijderd',
    23 => 'Er is een fout opgetreden bij het toevoegen van een evenement aan uw kalender. Er is geen evenement id aangemaakt.',
    24 => 'Het evenement is toegevoegd aan uw kalender',
    25 => 'U kan uw persoonlijke kalender pas openen als u bent ingelogd',
    26 => 'Het evenement is verwijderd van uw persoonlijke kalender',
    27 => 'Bericht verstuurd.',
    28 => 'De plugin is opgeslagen',
    29 => 'Helaas, persoonlijke kalenders zijn niet geactiveerd op dit portaal',
    30 => 'Toegang Geweigerd',
    31 => 'Helaas, u heeft geen toegang tot de artikel administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    32 => 'Helaas, u heeft geen toegang tot de thema administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    33 => 'Helaas, u heeft geen toegang tot de blok administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    34 => 'Helaas, u heeft geen toegang tot de links administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    35 => 'Helaas, u heeft geen toegang tot de evenementen administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    36 => 'Helaas, u heeft geen toegang tot de peilingen administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    37 => 'Helaas, u heeft geen toegang tot de gebruiker administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    38 => 'Helaas, u heeft geen toegang tot de plugin administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    39 => 'Helaas, u heeft geen toegang tot de email administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    40 => 'Portaal Bericht',
    41 => 'Helaas, u heeft geen toegang tot de woordvervang administratie pagina. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    42 => 'Het woord is opgeslagen.',
    43 => 'Het woord is verwijderd.',
    44 => 'De plugin is ingevoegd!',
    45 => 'De plugin is verwijderd.',
    46 => 'Helaas, u heeft geen toegang tot Database Backup Utility. Let op: alle pogingen om ongeautoriseerd toegang te krijgen tot beveiligde funkties worden vastgelegd',
    47 => 'Deze funktie werkt allen onder *nix. Indien u *nix gebruikt als besturingsysteem dan is uw cache geleegd. Indien u Windows gebruikt, moet u zoeken naar bestanden als adodb_*.php en deze handmatig verwijderen.',
    48 => "Bedankt voor uw aanvraag voor een gebruikersaccount van {$_CONF['site_name']}. De beheerders zullen uw aanvraag in behandeling nemen. Indien goedgekeurd, wordt uw wachtwoord naar het email adres verstuurd dat u net heeft ingevuld.",
    49 => 'De groep is opgeslagen.',
    50 => 'De groep is verwijderd.',
    51 => 'Deze gebruikersnaam is al in gebruik. Kies a.u.b. een andere.',
    52 => 'Het opgegeven email adres lijkt niet geldig te zijn.',
    53 => 'Het nieuwe wachtwoord is geaccepteerd. Gelieve hieronder opnieuw in te loggen, a.u.b.',
    54 => 'De aanvraag voor een nieuw wachtwoord is verjaard. Gelieve dit hieronder opnieuw aan te vragen.',
    55 => 'Een email is naar u verstuurd en zal in korte tijd bij u binnenkomen. Gelieve de instructies in dat bericht op te volgen.',
    56 => 'Het opgegeven email adres is reeds in gebruik bij een ander account. Dit is beveiligd.',
    57 => 'Uw account is met succes verwijderd.',
    58 => 'Uw feed is met succes opgeslagen.',
    59 => 'De feed is met succes verwijderd.',
    60 => 'De plugin is met succes ge-update',
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
    'access' => 'Toegang',
    'ownerroot' => 'Owner/Root',
    'group' => 'Group',
    'readonly' => 'Read-Only',
    'accessrights' => 'Toegangs Rechten',
    'owner' => 'Owner',
    'grantgrouplabel' => 'Grant Above Group Edit Rights',
    'permmsg' => 'NOTE: \'Members\': dit zijn alle ingelogde Gebruikers van het portaal -- \'Anonymous\': dit zijn alle niet-ingelogde bezoekers.',
    'securitygroups' => 'Security Groups',
    'editrootmsg' => "Ondanks dat u een gebruikersBeheerder bent, kunt u een zgn. 'root user' niet wijzigen. Daarvoor moet u eerst als een zgn. 'root user' ingelogd zijn. U kunt wel alle andere gebruikers wijzigen. Alle pogingen om een zgn. 'root user' ongeautoriseerd te wijzigen, worden vastgelegd. Gelieve terug te gaan naar de <a href=\"{$_CONF['site_admin_url']}/user.php\">Gebruiker Administratie pagina</a>.",
    'securitygroupsmsg' => 'Vink de groep(en) waarin de gebruiker opgenomen wordt.',
    'groupeditor' => 'Group Editor',
    'description' => 'Beschrijving',
    'name' => 'Naam',
    'rights' => 'Rechten',
    'missingfields' => 'Niet alles ingevuld',
    'missingfieldsmsg' => 'Een naam en beschrijving is verplicht voor een groep.',
    'groupmanager' => 'Group Manager',
    'newgroupmsg' => 'Om een groep te wijzigen of te verwijderen, klik op die groep hieronder. Om een nieuwe groep aan te leggen, klik op \'Nieuwe Groep\' hierboven. Let op! Zgn. \'core groups\' kunnen niet verwijderd worden omdat deze in de software een functie hebben.',
    'groupname' => 'Group Naam',
    'coregroup' => 'Core Group',
    'yes' => 'Ja',
    'no' => 'Nee',
    'corerightsdescr' => "Deze groep is een zgn. {$_CONF['site_name']} \'Core Group\'. De rechten van de groep kunnen niet gewijzigd worden. Hieronder is een overzicht opgenomen van de rechten voor deze groep.",
    'groupmsg' => '\'Security Groups\' werken hierarchisch. Door het toevoegen aan andere groep(en), wordt deze groep dezelfde rechten toegekend. Het wordt aanbevolen, waar mogelijk, deze faciliteit te gebruiken. Indien u deze groep een speciale samenstelling wilt geven, kunt u de individuele rechten daarvoor in het gedeelte hieronder (extra) aanvinken, onder het hoofd \'Rechten\'. Om rechten van een andere groep aan deze groep toe te voegen, kunt u volstaan met het aanvinken van deze andere groep(en).',
    'coregroupmsg' => "Deze groep is een zgn. {$_CONF['site_name']} \'Core Group\'. De groepen die hieraan toegevoegd zijn, kunnen daarom niet gewijzigd worden. Hieronder is een overzicht opgenomen van dergelijke groepen.",
    'rightsdescr' => 'Een groepsrecht voor een bepaalde faciliteit (zie hieronder) kan direct toegekend worden *OF* aan een andere groep waaraan deze groep eerder is toegevoegd. Wat u hieronder kunt zien aan het ontbreken van een vink-mogelijkheid, zijn de rechten van een andere groep, waaraan deze groep eerder is toegevoegd (en daarmee deze rechten verkreeg). De rechten die u kunt vinken kunt u direct toekennen aan - of afmelden voor - deze groep.',
    'lock' => 'Lock',
    'members' => 'Members',
    'anonymous' => 'Anonymous',
    'permissions' => 'Permissies',
    'permissionskey' => 'R = Read, E = Edit, wijzigingsrechten veronderstellen ook leesrechten',
    'edit' => 'Wijzigen',
    'none' => 'Geen',
    'accessdenied' => 'Geen toegang',
    'storydenialmsg' => "Dit artikel is niet toegankelijk voor u. Dit kan veroorzaakt worden doordat u niet aangemeld bent bij {$_CONF['site_name']}. Gelieve uzelve <a href=users.php?mode=new> aan te melden </a> bij {$_CONF['site_name']} voor soorgelijke toegangsrechten.",
    'nogroupsforcoregroup' => 'Deze groep heeft geen relatie met enige andere groep !!',
    'grouphasnorights' => 'Deze groep kan geen administratieve functies op het portaal oproepen en/of uitvoeren.',
    'newgroup' => 'Nieuwe Groep',
    'adminhome' => 'Beheerder Home',
    'save' => 'opslaan',
    'cancel' => 'annuleren',
    'delete' => 'verwijderen',
    'canteditroot' => 'U probeert de zgn. \'Root group\' te wijzigen, maar u behoort daar niet toe: de toegang is nu geweigerd. Gelieve contact op te nemen met de Beheerder indien u dit niet terecht vindt.',
    'listusers' => 'Overzicht Gebruikers',
    'listthem' => 'lijst',
    'usersingroup' => 'Gebruikers in groep %s',
    'usergroupadmin' => 'Gebruikersgroep administratie',
    'add' => 'Voeg toe',
    'remove' => 'Verwijder',
    'availmembers' => 'Beschikbare leden',
    'groupmembers' => 'Groepsleden',
    'canteditgroup' => 'Om deze groep te kunnen wijzigen dient u zelf een lid van deze groep te zijn. Neem a.u.b. contact op met de beheerder als u denk dat niet correct is.',
    'cantlistgroup' => 'Om de leden van deze groep te kunnen zien dient u zelf een lid van deze groep te zijn. Neem a.u.b. contact op met de beheerder als u denk dat niet correct is.',
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
    'last_ten_backups' => 'Laatste 10 Back-ups',
    'do_backup' => 'Maak een Backup',
    'backup_successful' => 'Database backup met succes uitgevoerd.',
    'db_explanation' => 'Om een nieuwe backup van het portaal te (laten) maken, klik op de knop hieronder',
    'not_found' => "Incorrect pad of mysqldump utility is niet uitvoerbaar.<br>Controleer de definitie voor <strong>\$_DB_mysqldump_path</strong> in config.php.<br>De variabele is momenteel opgenomen als: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup mislukt: bestandsgrootte was 0 bytes',
    'path_not_found' => "{$_CONF['backup_path']} bestaat niet of is geen directory",
    'no_access' => "FOUT: Directory {$_CONF['backup_path']} is niet benaderbaar.",
    'backup_file' => 'Backup bestand',
    'size' => 'Grootte',
    'bytes' => 'Bytes',
    'total_number' => 'Totaal aantal backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Home',
    2 => 'Kontakt',
    3 => 'Publiceren',
    4 => 'Links',
    5 => 'Peilingen',
    6 => 'Kalender',
    7 => 'Portaal Stats',
    8 => 'Persoonlijk',
    9 => 'Zoek',
    10 => 'gericht zoeken',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 fout',
    2 => 'Helaas, er is overal gezocht en <strong>%s</strong> toch niet gevonden.',
    3 => "<p>Helaas, het bestand dat u opvraagt bestaat niet (meer). Kijkt u gerust nog eens op de <a href=\'{$_CONF['site_url']}\'>voorpagina</a> of de <a href=\'{$_CONF['site_url']}/search.php\'>zoek pagina</a>. Misschien vindt u het daar."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Login vereist',
    2 => 'Voor dit gedeelte is een login als Gebruiker vereist.',
    3 => 'Login',
    4 => 'Nieuwe Gebruiker'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'De PDF-optie is geblokkeerd',
    2 => 'Het aangeleverde document is niet verwerkt. Het document is wel ontvangen, maar kon niet worden omgezet. Verzend alleen html-documenten die zijn geschreven volgens de xHTML standaard. Besef a.u.b. dat al te complexe html-documenten niet goed  - of zelfs helemaal niet -  worden verwerkt. Het document dat na uw poging is aangemaakt was 0 bytes in grootte en is verwijderd. Als u er zeker van bent dat uw document goed verwerkt zou moeten worden, probeert u het dan opnieuw te verzenden.',
    3 => 'Onbekende fout tijdens de aanmaak van het PDF document',
    4 => "No page data was given or you want to use the ad-hoc PDF generation tool below.  If you think you are getting this page\n          in error then please contact the system administrator.  Otherwise, you may use the form below to generate PDF's in an ad-hoc fashion.",
    5 => 'Uw document wordt geladen.',
    6 => 'Wacht a.u.b. terwijl uw document wordt geladen.',
    7 => 'U kunt de rechts-klikken op de onderstaande knop en kiezen voor \'opslaan doel...\' of \'opslaan link lokatie...\' om een copy van uw document te bewaren.',
    8 => "Het pad naar de HTMLDoc binary in het configuratiebestand is ongeldig of kan niet worden uitgevoerd.  Neem a.u.b. contact op met de beheerder als het probleem\n         zich blijft voordoen.",
    9 => 'PDF Generator',
    10 => "Dit is de Ad-hoc PDF Generation tool. Deze zal proberen om uw bestand te converteren.  Besef a.u.b. dat sommige webpaginas niet goed verwerkt kunnen worden.  Dit\n           is een beperking van de HTMLDoc PDF generation tool en zulke fouten kunnen worden gemeld aan de beheerder van deze site",
    11 => 'URL',
    12 => 'Genereer PDF!',
    13 => 'De PHP configuratie op deze server staat het gebruik van URLs met het fopen() commando niet toe.  De systeembeheerder moet het php.ini bestand aanpassen en het allow_url_fopen zetten op: On',
    14 => 'De PDF die u heeft opgevraagd bestaat niet of u heeft geen toegang tot dit bestand.'
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
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maart',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Augustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'December'
);

###############################################################################
# Weekdays

$LANG_WEEK = array(
    1 => 'Zondag',
    2 => 'Maandag',
    3 => 'Dinsdag',
    4 => 'Woensdag',
    5 => 'Donderdag',
    6 => 'Vrijdag',
    7 => 'Zaterdag'
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