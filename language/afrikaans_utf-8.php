<?php

###############################################################################
# afrikaans.php
# Hierdie is die Afrikaanse taallêer vir Geeklog 1.4
# Opgestel deur Renier Maritz epos:renier@gigaskills.co.za
#
# Kopiereg (C) 2000 Jason Whittenburg
# jwhitten AT securitygeeks DOT com
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

$LANG_CHARSET = 'utf-8';

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
    1 => 'Geskryf deur:',
    2 => 'lees verder',
    3 => 'kommentaar',
    4 => 'Wysig',
    5 => 'Stem',
    6 => 'Resultaat',
    7 => 'Peiling resultate',
    8 => 'stemme',
    9 => 'Admin Funksies:',
    10 => 'Bydraes',
    11 => 'Artikels',
    12 => 'Blokke',
    13 => 'Onderwerpe',
    14 => 'Skakels',
    15 => 'Gebeure',
    16 => 'Peilings',
    17 => 'Gebruikers',
    18 => 'SQL Query',
    19 => 'Teken Uit',
    20 => 'Gebruikersinligting:',
    21 => 'Gebruikernaam',
    22 => 'Gebruiker ID',
    23 => 'Sekuriteitsvlak',
    24 => 'Anoniem',
    25 => 'Antwoord',
    26 => 'Die volgende kommentaar is die eiendom van wie dit ookal gepos het.  Hierdie werf is geensins verantwoordelik vir wat daar ges&ecirc; word nie.',
    27 => 'Mees Onlangse Plasing',
    28 => 'Verwyder',
    29 => 'Geen gebruiker kommentaar.',
    30 => 'Ouer Artikels',
    31 => 'Toegelate HTML Etikette:',
    32 => 'Fout, ongeldige gebruikernaam',
    33 => 'Fout, kon nie na die log l&ecirc;er skryf nie',
    34 => 'Fout',
    35 => 'Teken Uit',
    36 => 'aan',
    37 => 'Geen gebruiker artikels',
    38 => 'Inhoud Sindikasie',
    39 => 'Herlaai',
    40 => 'Jou <tt>register_globals = Off</tt> in jou <tt>php.ini</tt>. Geekolog vereis egter dat <tt>register_globals</tt> <strong>aan</strong> is. Voordat jy verder gaan, stel dit na <strong>on</strong> en herlaai jou webblaaier.',
    41 => 'Besoekers',
    42 => 'Geskryf deur:',
    43 => 'Antwoord hierop',
    44 => 'Stam',
    45 => 'MySQL Foutnommer',
    46 => 'MySQL Foutboodskap',
    47 => 'Gebruikersfunksies',
    48 => 'Rekeninginligting',
    49 => 'Voorkeure',
    50 => 'Fout in SQL stelling',
    51 => 'help',
    52 => 'Nuut',
    53 => 'Admin Tuiste',
    54 => 'Kon die l&ecirc;er nie oopmaak nie.',
    55 => 'Fout by',
    56 => 'Stem',
    57 => 'Wagwoord',
    58 => 'Teken in',
    59 => "Nog nie 'n rekening? Registreer dan as 'n <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Nuwe Gebruiker</a>",
    60 => 'Lewer kommentaar',
    61 => 'Skep Nuwe Rekening',
    62 => 'woorde',
    63 => 'Kommentaar Voorkeure',
    64 => 'Epos Artikel aan \'n Vriend',
    65 => 'Vertoon Drukbare Weergawe',
    66 => 'My Kalender',
    67 => 'Welkom by',
    68 => 'Tuisblad',
    69 => 'Kontak',
    70 => 'Soek',
    71 => 'Skryf iets',
    72 => 'Web Hulpmiddele',
    73 => 'Ou Peilings',
    74 => 'Kalender',
    75 => 'Gevorderde Soektog',
    76 => 'Werfstatistieke',
    77 => 'Proppies',
    78 => 'Opkomende Gebeure',
    79 => 'Wat\'s Nuut',
    80 => 'artikels in laaste',
    81 => 'artikel in laaste',
    82 => 'ure',
    83 => 'KOMMENTARE',
    84 => 'SKAKELS',
    85 => 'laaste 48 uur',
    86 => 'Geen nuwe kommentaar',
    87 => 'laaste 2 weke',
    88 => 'Geen onlangse nuwe skakels',
    89 => 'Daar is geen opkomende gebeure',
    90 => 'Tuisblad',
    91 => 'Hierdie blad geskep in',
    92 => 'sekondes',
    93 => 'Kopiereg',
    94 => 'Alle handelsmerke en kopieregte op hierdie blad word deur hulle onderskeie eienaars besit.',
    95 => 'Aangedryf Deur',
    96 => 'Groepe',
    97 => 'Woordelys',
    98 => 'Proppies',
    99 => 'ARTIKELS',
    100 => 'Geen nuwe artikels',
    101 => 'Jou Gebeure',
    102 => 'Werfgebeure',
    103 => 'DB Rugsteuning',
    104 => 'deur',
    105 => 'EPOS aan Gebruikers',
    106 => 'Besigtigings:',
    107 => 'GL Weergawe Toets',
    108 => 'Vee Kas skoon',
    109 => 'Meld misbruik aan',
    110 => 'Rapporteer hierdie plasing aan die werfadmin',
    111 => 'Vertoon PDF Weergawe',
    112 => 'Geregistreerde Gebruikers',
    113 => 'Dokumentasie',
    114 => 'TRACKBACKS',
    115 => 'Geen nuwe trackback kommentaar',
    116 => 'Trackback',
    117 => 'Gids',
    118 => 'Lees asseblief verder op die volgende bladsy:',
    119 => "Jou <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">wagwoord</a> vergeet?",
    120 => 'Permanente skakel na hierdie kommentaar',
    121 => 'Kommentaar (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'Alle HTML word toegelaat',
    124 => 'Click to delete all checked items',
    125 => 'Are you sure you want to Delete all checked items?',
    126 => 'Select or de-select all items'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Lewer Kommentaar',
    2 => 'Plasingmodus',
    3 => 'Teken Uit',
    4 => 'Skep Rekening',
    5 => 'Gebruikernaam',
    6 => 'Hierdie werf vereis dat jy ingeteken moet wees om kommentaar te kan lewer, teken asseblief in.  As jy nie \'n rekening het nie kan jy die vorm hier onder gebruik om een te skep.',
    7 => 'Jou laast kommentaar was ',
    8 => " sekondes gelede.  Hierdie werf vereis dat ten minstne {$_CONF['commentspeedlimit']} sekondes tussen kommentare verstryk.",
    9 => 'Kommentaar',
    10 => 'Stuur Verslag',
    11 => 'Stuur Kommentaar',
    12 => 'Vul asseblief die Titel en Kommentaar velde in, dit is \'n vereiste.',
    13 => 'Jou Inligting',
    14 => 'Voorskou',
    15 => 'Rapporteer hierdie plasing',
    16 => 'Titel',
    17 => 'Fout',
    18 => 'Belangrike Goed',
    19 => 'Die plasing moet verkieslik met die onderwerp verband hou.',
    20 => 'Probeer eerder om kommentaar te lewer eerder as om \'n nuwe artikel te begin oor dieselfde besprekingsonderwerp.',
    21 => 'Lees ander mense se boodskappe voordat jy jou eie plaas om te verhoed dat jy herhaal wat reeds ges&ecirc; is.',
    22 => 'Gebruik \'n duidelike onderwerp wat beskryf waaroor jou boodskap gaan.',
    23 => 'Jou epos adres sal NIE geopenbaar word nie.',
    24 => 'Anonieme Gebruiker',
    25 => 'Is jy seker dat jy hierdie plasing aan die werf admin wil rapporteer?',
    26 => '%s het die volgende beledigende plasing of misbruik gerapporteer:',
    27 => 'Misbruikverslag'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Gebruikersprofiel van',
    2 => 'Gebruikernaam',
    3 => 'Volle Naam',
    4 => 'Nuwe Wagwoord',
    5 => 'Epos',
    6 => 'Tuisblad',
    7 => 'Bio',
    8 => 'PGP Sleutel',
    9 => 'Stoor Inligting',
    10 => 'Laaste 10 kommentare van gebruiker',
    11 => 'Geen Gebruikerkommentaar',
    12 => 'Gebruikersvoorkeure van',
    13 => 'Epos Nagtelike Opsomming',
    14 => 'Hierdie wagwoord word deur \'n lukraak algoritme saamgestel. Daar word aanbeveel dat jy dit onmiddelik verander.  Om jou wagwoord te verander moet jy inteken en dan op Rekeninginligting kliek by die Gebruikersfunksies keusebalk.',
    15 => "Jou {$_CONF['site_name']} rekening is suksesvol opgestel. Om dit te kan gebruik moet jy inteken deur die onderstaande inligting te gebruik.  Stoor hierdie epos vir latere verwysing.",
    16 => 'Jou Rekeninginligting',
    17 => 'Rekening bestaan nie',
    18 => 'Die epos adres wat verskaf is blyk nie \'n geldige een te wees nie',
    19 => 'Die gebruikernaam of epos adres wat verskaf is bestaan reeds',
    20 => 'Die epos adres verskaf blyk nie \'n geldige adres te wees nie',
    21 => 'Fout',
    22 => "Registreer by {$_CONF['site_name']}!",
    23 => "Die skep van 'n gebruikersrekening sal jou al die voordele gee van lidmaatskap by {$_CONF['site_name']} en sal jou in staat stel om kommentaar te plaas asook om artikels self te skep. As jy nie 'n rekening het nie, sal jy slegs anonieme plasing kan maak. Neem asseblief kennis dat jou epos adres <b><i>nooit</i></b> op hierdie werf geopenbaar sal word nie.",
    24 => 'Jou wagwoord sal na die eposadres wat jy verskaf gestuur word.',
    25 => 'Het jy jou Wagwoord vergeet?',
    26 => 'Sleutel <em>of</em> jou gebruikernaam <em>of</em> die epos adres wat jy gebruik het om mee te registreer en kliek Epos Wagwoord. Instruksies oor hoe om \'n nuwe wagwoord in te stel sal aan die betrokke epos adres op rekord gestuur word.',
    27 => 'Registreer Nou!',
    28 => 'Epos Wagwoord',
    29 => 'uitgeteken vanuit',
    30 => 'ingeteken vanuit',
    31 => 'Die funksie wat jy gekies het vereis dat jy inteken',
    32 => 'Handtekening',
    33 => 'Nooit vertoon',
    34 => 'Dit is jou regte naam',
    35 => 'Sleutel wagwoord in om dit te verander',
    36 => 'Begin met http://',
    37 => 'Aangeheg by jou kommentaar',
    38 => 'Dit gaan alles oor jou!  Enigeen kan dit lees',
    39 => 'Jou publieke PGP sleutel om te deel',
    40 => 'Geen Onderwerp Ikone',
    41 => 'Gewillig om te Modereer',
    42 => 'Datumformaat',
    43 => 'Maksimum Artikels',
    44 => 'Geen bokse',
    45 => 'Vertoon Voorkeure vir',
    46 => 'Uitgeslote Items vir',
    47 => 'Nuwe boks Konfigurasie vir',
    48 => 'Onderwerpe',
    49 => 'Geen ikone in artikels',
    50 => 'Verwyder merk as jy nie hierin belangstel nie',
    51 => 'Slegs die nuusartikels',
    52 => 'Die standaard is',
    53 => 'Ontvang die dag se stories elke nag',
    54 => 'Merk die boksies vir die onderwerpe en skrywers wat jy nie wil sien nie.',
    55 => 'As jy almal ongemerk laat beteken dit dat jy die standaard keuse van bokse wil sien. As jy bokse merk onthou om almal wat jy wil sien te merk aangesien die standaard keuses ge&iuml;gnoreer gaan word.  Standaard items word in drukskrif aangedui.',
    56 => 'Skrywers',
    57 => 'Vertoonmodus',
    58 => 'Sorteer Volgorde',
    59 => 'Kommentaar Limiet',
    60 => 'Hoe wil jy h&ecirc; dat jou kommentaar vertoon word?',
    61 => 'Nuutste of oudstes eerste?',
    62 => 'Die standaard is 100',
    63 => "Jou wagwoord is aan jou gestuur per epos en behoort kortliks by jou uit te kom. Volg asseblief die aanwysings in die boodskap en dankie dat jy {$_CONF['site_name']} gebruik",
    64 => 'Kommentaarvoorkeure van',
    65 => 'Probeer weer Inteken',
    66 => 'Jy het moontlik jou besonderhede verkeerd ingesleutel.  Probeer asseblief weer om hieronder in te teken.',
    67 => 'Lid Sedert',
    68 => 'Onthou My vir',
    69 => 'Hoe lank moet ons jou onthou na jy ingeteken het? Tydsverloop waarop jy kan terugkom sonder om weer in te teken',
    70 => "Verander die uitleg en inhoud van {$_CONF['site_name']} na jou sin",
    71 => "Een van die beste kenmerke van {$_CONF['site_name']} is dat jy die inhoud wat jy ontvang en die uitleg van die werf kan maak pas by jou eie sin.  Om van hierdie kenmerke gebruik te kan maak moet jy eers <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registreer</a> by {$_CONF['site_name']}.  Is jy reeds 'n lid?  Gebruik dan die intekenvorm aan die linkerkant om in te teken!",
    72 => 'Tema',
    73 => 'Taal',
    74 => 'Verander hoe die werf vertoon!',
    75 => 'Onderwerpe Gepos aan',
    76 => 'As jy \'n onderwerp hieronder kies sal jy enige nuwe stories wat by daardie onderwerp gevoeg word aan die einde van elke dag ontvang.  Kies slegs die onderwerpe wat jou intereseer!',
    77 => 'Foto',
    78 => 'Sit \'n foto van jouself op!',
    79 => 'Merk hier om die foto te verwyder',
    80 => 'Teken in',
    81 => 'Stuur Epos',
    82 => 'Laaste 10 artikel vir gebruiker',
    83 => 'Plasingstatistiek van gebruiker',
    84 => 'Totale aantal artikels:',
    85 => 'Totale aantal kommentare:',
    86 => 'Vind alle plasings deur',
    87 => 'Jou gebruikernaam',
    88 => "Iemand (moontlik jy) het versoek dat 'n nuwe wagwoord geskep word vir jou rekening \"%s\" op {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nAs jy dit werklik wou doen, kliek op die volgende skakel:\n\n",
    89 => "As jy dit nie wil doen nie, ignoreer eenvoudig hierdie boodskap en die versoek sal ge&iuml;gnoreer word (jou wagwoord sal dan onveranderd bly).\n\n",
    90 => 'Jy kan \'n nuwe wagwoord vir jou rekening hieronder insleutel. Neem asseblief kennis dat jou ou wagwoord steeds geldig bly totdat jy hierdie vorm instuur.',
    91 => 'Stel Nuwe Wagwoord',
    92 => 'Sleutel Nuwe Wagwoord in',
    93 => 'Jou laaste versoek vir \'n nuwe wagwoord was %d sekondes gelede. Hierdie werf vereis dat ten minste %d sekondes verstryk tussen wagwoordversoeke.',
    94 => 'Verwyder Rekening "%s"',
    95 => 'Kliek die "verwyder rekening" knop hieronder om jou rekening van ons databasis te verwyder.  Neem kennis dat enige artikels en kommentaar onder hierdie rekening bygedra <strong>nie</strong> verwyder sal word nie maar gemerk sal word as deur "Anoniem" gepos.',
    96 => 'verwyder rekening',
    97 => 'Bevestig Verwydering van Rekening',
    98 => 'Is jy seker dat jy jou rekening wil verwyder? Deur dit te doen sal jy nie meer op hierdie werf kan inteken nie (tensy jy \'n nuwe rekening skep). As jy seker is, kliek weer op "verwyder rekening" op die vorm hieronder.',
    99 => 'Privaatheidsopsis vir',
    100 => 'Epos van Admin',
    101 => 'Laat epos van Werf Admin toe',
    102 => 'Epos van Gebruikers',
    103 => 'Laat epos toe vanaf onder gebruikers',
    104 => 'Vertoon Aanlyn Status',
    105 => 'Vertoon in die Wie\'s Aanlyn blok',
    106 => 'Ligging',
    107 => 'Vertoon in jou openbare profiel',
    108 => 'Bevestig nuwe wagwoord',
    109 => 'Sleutel die Nuwe wagwoord weer hier in',
    110 => 'Huidige Wagwoord',
    111 => 'Sleutel asseblief jou Huidige wagwoord in',
    112 => 'Jy het die toelaatbare getal intekenpogings oorskry.  Probeer asseblief weer later.',
    113 => 'Intekenpoging  het Misluk',
    114 => 'Rekening Gedeaktiveer',
    115 => 'Jou rekening is gedeatkiveer, jy mag nie inteken nie. Kontak die Administrateur.',
    116 => 'Rekening Wag op Aktivering',
    117 => 'Jou rekening is tans gelys vir aktivering deur die administrateur. Jy sal nie kan inteken alvorens jou rekening goedgekeur is nie.',
    118 => "Jou {$_CONF['site_name']} rekening is nou geaktiveer deur \'n administrateur. Jy mag nou inteken op die werf by die url hieronder deur jou gebruikernaam en wagwoord te gebruik soos voorheen aan jou ge-epos.",
    119 => 'As jy jou wagwoord vergeet het, kan jy \\'n nuwe een aanvra by die volgende url:',
    120 => 'Rekening Geaktiveer',
    121 => 'Diens',
    122 => 'Jammer, nuwe gebruiker registrasie is gedeaktiveer',
    123 => "Is jy 'n <a href=\"{$_CONF['site_url']}/users.php?mode=new\">nuwe gebruiker</a>?",
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
    1 => 'Geen Nuus om te Vertoon',
    2 => 'Daar is geen nuwe nuusartikels om te vertoon nie.  Daar mag dalk geen nuusartikels vir hierdie onderwerp wees nie of jou gebruikersvoorkeure mag dalk te beperkend wees.',
    3 => ' vir onderwerp %s',
    4 => 'Artikel van die Dag',
    5 => 'Volgende',
    6 => 'Vorige',
    7 => 'Eerste',
    8 => 'Laaste'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Daar was \'n fout tydens die stuur van jou boodskap. Probeer asseblief weer.',
    2 => 'Boodskap suksesvol gestuur.',
    3 => 'Maak asseblief seker dat jy \'n geldige epos adres in die Antwoord Na veld ingevul het.',
    4 => 'Vul asseblief jou Naam, Antwoord Aan, Onderwerp en Boodskapvelde in',
    5 => 'Fout: Geen sodanige gebruiker.',
    6 => 'Daar was \'n fout.',
    7 => 'Gebruikersprofiel vir',
    8 => 'Gebruikernaam',
    9 => 'Gebruiker URL',
    10 => 'Stuur epos aan',
    11 => 'Jou Naam:',
    12 => 'Antwoord Na:',
    13 => 'Onderwerp:',
    14 => 'Boodskap:',
    15 => 'HTML word nie vertaal nie.',
    16 => 'Stuur Boodskap',
    17 => 'Epos Artikel aan \'n Vriend',
    18 => 'Aan Naam',
    19 => 'Na Epos Adres',
    20 => 'Van Naam',
    21 => 'Van Epos Adres',
    22 => 'Alle velde word vereis',
    23 => "Hierdie epos is aan jou gestuur deur %s by %s omdat hulle gedink het dat jy dalk mag belangstel in hierdie artikel op {$_CONF['site_url']}.  Hierdie is nie gemorspos nie en die epos adres van die ontvanger is nie op 'n lys gestoor vir latere gebruik nie.",
    24 => 'Kommentaar op hierdie artikel by',
    25 => 'Jy moet ingetekn wees om hierdie kenmerk te benut.  Deur jou te laat inteken vermy ons misbruik van die stelsel',
    26 => 'Hierdie vorm sal jou toelaat om \'n epos aan die gekose gebruiker te stuur.  Alle velde word vereis.',
    27 => 'Kort boodskap',
    28 => '%s het geskryf: ',
    29 => "Hierdie is die daaglikse opsomming van {$_CONF['site_name']} vir ",
    30 => ' Daaglikse Nuusbrief vir ',
    31 => 'Titel',
    32 => 'Datum',
    33 => 'Lees die volledige artikel by',
    34 => 'Einde van Boodskap',
    35 => 'Jammer, hierdie gebruiker verkies om nie epos te ontvang nie.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Gevorderde Soektog',
    2 => 'Sleutelwoorde',
    3 => 'Onderwerp',
    4 => 'Almal',
    5 => 'Tipe',
    6 => 'Artikels',
    7 => 'Kommentaar',
    8 => 'Skrywers',
    9 => 'Almal',
    10 => 'Soek',
    11 => 'Soekresultate',
    12 => 'passende artikels',
    13 => 'Soekresultate: Geen passende artikels',
    14 => 'Geen artikels het by jou sleutelwoorde gepas nie',
    15 => 'Probeer asseblief weer.',
    16 => 'Titel',
    17 => 'Datum',
    18 => 'Skrywer',
    19 => "Deursoek die hele {$_CONF['site_name']} databasis vir huidige en ouer artikels",
    20 => 'Datum',
    21 => 'tot',
    22 => '(Datum Formaat YYYY-MM-DD)',
    23 => 'Besigtigings',
    24 => '%d items gevind',
    25 => 'Gesoek vir',
    26 => 'items ',
    27 => 'sekondes',
    28 => 'Geen artikel of kommentaar pas by jou soeknavraag nie',
    29 => 'Artikel- en Kommentaarresultate',
    30 => 'Geen skakels pas by jou soektog nie',
    31 => 'Hierdie proppie het geen passende resultaat gelewer nie',
    32 => 'Gebeure',
    33 => 'URL',
    34 => 'Ligging',
    35 => 'Heeldag',
    36 => 'Geen gebeure het by jou soeknavraag gepas nie',
    37 => 'Gebeureresultate',
    38 => 'Skakelresultate',
    39 => 'Skakels',
    40 => 'Gebeure',
    41 => 'Jou soeknavraag moet ten minste 3 karakters bevat.',
    42 => 'Gebruik asseblief \'n datum wat as sulks geformatteer is YYYY-MM-DD (jaar-maand-dag).',
    43 => 'presiese sinsnede',
    44 => 'al hierdie woorde',
    45 => 'enige van hierdie woorde',
    46 => 'Volgende',
    47 => 'Vorige',
    48 => 'Skrywer',
    49 => 'Datum',
    50 => 'Kere aangevra',
    51 => 'Skakels',
    52 => 'Ligging',
    53 => 'Artikelresultate',
    54 => 'Kommentaarresultate',
    55 => 'die sinsnede',
    56 => 'EN',
    57 => 'OF',
    58 => 'Meer resultate &gt;&gt;',
    59 => 'Resultate',
    60 => 'per bladsy',
    61 => 'Verfyn soektog'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Werfstatistiek',
    2 => 'Totale kere Aangevra vanaf die stelsel',
    3 => 'Artikels (Kommentare) in die stelsel',
    4 => '',
    5 => '',
    6 => 'Gebeure in die stelsel',
    7 => 'Top Tien Artikels volgens besigtigings',
    8 => 'Titel van Artikel',
    9 => 'Besigtigings',
    10 => 'Dit wil voorkom asof daar geen sntories op hierdie werf is nie of dalk het niemand hulle nog besigtig nie.',
    11 => 'Top Tien Artikels volgens getal Kommentare gelewer',
    12 => 'Kommentaar',
    13 => 'Dit wil voorkom asof daar geen artikels op die werf is nie of dalk het niemand nog kommentaar op hulle gelewer nie.',
    14 => '',
    15 => '',
    16 => '',
    17 => '',
    18 => '',
    19 => '',
    20 => '',
    21 => 'Dit wil voorkom asof daar geen skakels op die werf is nie of dalk het niemand nog ooit daarop gekliek nie.',
    22 => 'Top Tien Artikel volgens getal per Epos aangestuur',
    23 => 'Eposse',
    24 => 'Dit wil voorkom asof niemand nog \'n storie per epos aangestuur het op hierdie werf nie',
    25 => 'Top Tien Trackback Kommentaar Artikels',
    26 => 'Geen trackback kommentaar gevind.',
    27 => 'Aantal aktiewe gebruikers',
    28 => 'Top Tien Gebeurtenisse',
    29 => 'Gebeurtenis',
    30 => 'Kere Aangevra',
    31 => 'Dit wil voorkom asof daar geen gebeure op die werf geplaas is nie of dalk het niemand nog op een gekliek het nie.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Verwante Artikels',
    2 => 'Epos Artikel aan \'n Vriend',
    3 => 'Drukbare artikelformaat',
    4 => 'Artikelopsies',
    5 => 'PDF Artikelformaat'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Om \'n %s te plaas word daar vereis dat jy as gebruiker ingeteken is.',
    2 => 'Teken in',
    3 => 'Nuwe Gebruiker',
    4 => 'Sit Gebeurtenis by',
    5 => '',
    6 => 'Plaas \'n Artikel',
    7 => 'Intekening word Vereis',
    8 => 'Stuur',
    9 => 'Wanneer jy inligting verskaf vir gebruik op hierdie werf versoek ons dat jy die volgende riglyne volg...<ul><li>Vul al die velde in aangesien dit vereis word<li>Verskaf volledig en akkurate inligting<li>Gaan die URL\'le deeglik na</ul>',
    10 => 'Titel',
    11 => 'Skakel',
    12 => 'Begindatum',
    13 => 'Einddatum',
    14 => 'Ligging',
    15 => 'Beskrywing',
    16 => '',
    17 => '',
    18 => '',
    19 => 'Lees eers hier',
    20 => '',
    21 => '',
    22 => 'Fout: Vermiste Velde',
    23 => 'Vul asseblief al die velde op die vorm in.  Alle velde word vereis.',
    24 => 'Bydrae Gestoor',
    25 => 'U %s bydrae is suksesvol gestoor.',
    26 => 'Spoedbeperking',
    27 => 'Gebruikernaam',
    28 => 'Onderwerp',
    29 => 'Artikel',
    30 => 'Jou laaste bydrae was ',
    31 => " sekondes gelede.  Hierdie werf vereis dat ten minste {$_CONF['speedlimit']} sekondes tussen voorleggings verstryk",
    32 => 'Voorskou',
    33 => 'Artikel Voorskou',
    34 => 'Teken Uit',
    35 => 'HTML tags word nie toegelaat nie',
    36 => 'Post Modus',
    37 => "Die voorlegging van 'n gebeurtenis aan {$_CONF['site_name']} sal jou gebeurtenis op die hoofkalender plaas waar gebruikers die keuse het om jou gebeurtenis op hulle eie persoonlike kalender te plaas. Hierdie funksie is <b>NIE</b> bedoel om jou persoonlike gebeure te plaas nie.<br><br>Wanneer jy jou gebeurtenis voorl&ecirc; word dit aan ons administrateurs voorgel&ecirc; en indien hulle dit goedkeur sal jou gebeurtenis op die hoofkalender verskyn.",
    38 => 'Voeg Gebeurtenis By',
    39 => 'Hoofkalender',
    40 => 'Persoonlike Kalender',
    41 => 'Eindtyd',
    42 => 'Begintyd',
    43 => 'Heeldag Gebeurtenis',
    44 => 'Adreslyn 1',
    45 => 'Adreslyn 2',
    46 => 'Stad/Dorp',
    47 => 'Provinsie',
    48 => 'Poskode',
    49 => 'Gebeurtenistipe',
    50 => 'Wysig Gebeurtenistipes',
    51 => 'Ligging',
    52 => 'Verwyder',
    53 => 'Skep Rekening'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Bevestiging van ID Vereis',
    2 => 'Geweier! Ongeldige Intekeninligting',
    3 => 'Ongeldige wagwoord vir gebruiker',
    4 => 'Gebruikernaam:',
    5 => 'Wagwoord:',
    6 => 'Alle toegang tot administratiewe gedeeltes van hierdie werf word aangeteken en hersien.<br>Hierdie bladsy is allenlik vir die gebruik van regmatige personeel.',
    7 => 'teken in'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Onvoldoende Adminregte',
    2 => 'Jy het nie voldoende regte om hierdie blok te wysig nie.',
    3 => 'Blokverwerker',
    4 => 'Daar was \'n probleem met die lees van hierdie voer (sien error.log vir besonderhede).',
    5 => '',
    6 => '',
    7 => 'Almal',
    8 => 'Blok Beveiligingsvlak',
    9 => 'Blok Volgorde',
    10 => '',
    11 => 'Portaalblok',
    12 => 'Normale Blok',
    13 => 'Portaalblok Opsies',
    14 => 'RSS URL',
    15 => 'Laaste RSS Opdatering',
    16 => 'Normale Blok Opsies',
    17 => 'Blokinhoud',
    18 => 'Vul asseblief die Blok se titel- en inhoudvelde in',
    19 => 'Blokbestuurder',
    20 => '',
    21 => 'Blok SecLev',
    22 => '',
    23 => 'Blok Volgorde',
    24 => '',
    25 => 'Om \'n blok te wysig of verwyder, kliek op daardie blok se wysig ikoon hieronder.  Om \'n nuwe blok te skep, kliek op "Maak Nuwe" hierbo. Om \'n blok te skuif, kliek op die pyltjies op of die [R] en [L] bokse.',
    26 => 'Uitlegblok',
    27 => 'PHP-Blok',
    28 => 'PHP-Blok Opsies',
    29 => 'Blokfunksie',
    30 => 'As jy sou wou h&ecirc; dat een van jou blokke PHP-kode gebruik, tik die naam van die funksie hierbo in.  Jou funksie moet begin met die voorvoegsel "phpblock_" (bv. phpblock_kryweer).  As dit nie hierdie voorvoegsel het nie, sal jou funksie nie uitgevoer word nie.  Ons doen dit om te keer dat mense wat dalk onregmatige toegang tot jou stelsel se installasie verkry het daarvan te weerhou om willekeurig kode uit te voer wat skadelik mag wees vir jou stelsel.  Maak seker dat jy le&euml; hakies "()" agter jou funksie naam bysit.  Verder word jy ook aangeraai dat jy al jou PHP-Blok kode in /pad/na/geeklog/system/lib-custom.php stoor.  Dit sal dit vir jou moontlik maak om jou kode te behou al gradeer jy na \'n nuwe weergawe van Geeklog op.',
    31 => 'Fout in PHP-Blok. Funksie, %s, bestaan nie.',
    32 => 'Fout Vermiste Veld(e)',
    33 => 'Jy moet die URL na die RSS l&ecirc;er vir portaalblokke insleutel',
    34 => 'Jy moet die titel en funksie vir PHP-blokke insleutel',
    35 => 'Jy moet die titel en inhoud vir normale blokke invoer',
    36 => 'Jy moet die inhoed vir uitlegblokke invoer',
    37 => 'Ongeldige PHP-blok funksienaam',
    38 => 'Funksies vir PHP Blokke moet die voorvoegsel \'phpblock_\' (bv. phpblock_kryweer) hê.  Die \'phpblock_\' voorvoegsel word vereis vir veiligheisredes om die arbitr&ecirc;re uitvoer van kode te verhoed.',
    39 => 'Kant',
    40 => 'Links',
    41 => 'Regs',
    42 => 'U moet die bloktitel en blokvolgorde insleutel vir Geeklog se standaardblokke.',
    43 => 'Slegs Tuisblad',
    44 => '',
    45 => "U probeer om toegang tot 'n blok te verkry waartoe u nie regte het nie.  Hierdie poging is aangeteken. Gaan terug na die <a href=\"{$_CONF['site_admin_url']}/block.php\">blokadministrasieskerm</a>.",
    46 => 'Skuif',
    47 => '',
    48 => 'Bloknaam',
    49 => ' (geen spasies en moet uniek wees)',
    50 => '',
    51 => 'sluit http:// in',
    52 => 'As jy hierdie leeg los sal die hulp-ikoon vir hierdie blok nie vertoon word nie',
    53 => 'Geaktiveer',
    54 => 'stoor',
    55 => 'kanselleer',
    56 => 'verwyder',
    57 => 'Skuif Blok Ondertoe',
    58 => 'Skuif Blok Boontoe',
    59 => 'Skuif blok na die regterkant',
    60 => 'Skuif blok na die linkerkant',
    61 => 'Geen Titel',
    62 => 'Artikel Limiet',
    63 => 'Ongeldige Bloktitel',
    64 => 'Jou Titel mag nie leeg wees of HTML bevat nie!',
    65 => 'Volgorde',
    66 => 'Autotags',
    67 => 'Check to allow autotags'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Vorige Artikels',
    2 => 'Volgende Artikels',
    3 => 'Modus',
    4 => 'Post Modus',
    5 => 'Artikel Redigeerder',
    6 => 'Daar is geen artikels in die stelsel nie',
    7 => 'Skrywer',
    8 => 'stoor',
    9 => 'voorskou',
    10 => 'kanselleer',
    11 => 'verwyder',
    12 => 'ID',
    13 => '',
    14 => '',
    15 => 'Datum',
    16 => 'Inleidende Teks',
    17 => 'Inhoud',
    18 => 'Besigtig',
    19 => 'Kommentaar',
    20 => 'Pieng',
    21 => 'Stuur Pieng',
    22 => 'Artikellys',
    23 => 'Om \'n artikel uit te vee, kliek op die artikel se wysig ikoon hieronder. Om \'n artikel ten volle te vertoon, kliek op die titel van die artikel wat jy wil lees.  Om \'n nuwe artikel te skep, kliek op "Skryf iets" hierbo.',
    24 => 'Die ID wat jy vir die artikel gekies het is reeds in gebruik. Gebruik asb \'n ander ID.',
    25 => 'Fout tydens stoor van artikel',
    26 => 'Artikelvoorskou',
    27 => 'As jy [unscaledX] in plaas van [imageX] gebruik sal die beeld op sy oorspronklike grootte geplaas word.',
    28 => '<p><b>VOORSKOU</b>: Die voorskou van \'n artikel met prente daarin kan beter gedoen word deur die artikel as \'n draft te stoor eerder as om die voorskou knop te kliek.  Gebruik die voorskou slegs as daar geen prente ingesluit is by die artikel nie.',
    29 => 'Trackbacks',
    30 => 'Foute tydens oplaai van l&ecirc;ers',
    31 => 'Vul asseblief die Titel en Inleiding teksvelde in',
    32 => 'Uitgeligte Artikel',
    33 => 'Slegs een artikel kan uitgelig word',
    34 => 'Draft',
    35 => 'Ja',
    36 => 'Nee',
    37 => 'Meer deur',
    38 => 'Meer van',
    39 => 'Eposse',
    40 => '',
    41 => "U probeer om toegang tot 'n artikel te verkry waartoe u nie regte het nie.  Hierdie poging is aangeteken.  U kan die artikel in lees-alleen formaat hieronder besigtig. Gaan <a href=\"{$_CONF['site_admin_url']}/story.php\">asseblief terug na artikel administrasieskerm</a> as u klaar is.",
    42 => "U probeer om toegang tot \'n storie te verkry waartoe u nie regte het nie.  Hierdie poging is aangeteken.  Gaan asseblief <a href=\"{$_CONF['site_admin_url']}/story.php\">terug na die artikel administrasieskerm</a>.",
    43 => '',
    44 => '',
    45 => '',
    46 => '<b>LET WEL:</b> as u hierdie datum na \'n toekomstige datum wysig, sal die artikel eers op daardie datum gepubliseer word.  Dit beteken ook dat die artikel nie in jou RSS nuusvoer ingesluit sal word nie en deur die soekfunksie en statistiese bladsye ge&iuml;gnoreer sal word.',
    47 => 'Beelde',
    48 => 'beeld',
    49 => 'regs',
    50 => 'links',
    51 => 'Om een van die beelde wat jy by die artikel aanheg in die artikel te laat vertoon moet jy spesiale teks gebruik.  Die formaat van die spesiale teks is [imageX], [imageX_right] of [imageX_left] waar X die nommer is van die beeld/prent wat jy aangeheg het.  LET WEL: Jy moet die beelde gebruik wat jy aanheg gebruik.  As jy dit nie doen nie sal jy nie jou artikel kan stoor nie.<br>',
    52 => '',
    53 => 'is nie gebruik nie.  Jy moet hierdie beeld in die Inleiding of Kern van jou teks insluit alvorens jy jou veranderinge kan stoor',
    54 => 'Aangehegte Beelde nie Gebruik',
    55 => 'Die volgende foute het voorgekom tydens die poging om u storie te stoor.  Stel hierdie foute reg alvorens u probeer stoor',
    56 => 'Wys Onderwerp Ikoon',
    57 => 'Vertoon Ongeskaalde Beeld',
    58 => 'Argief Opsies',
    59 => 'Opsie',
    60 => '',
    61 => 'Outo-argief',
    62 => 'Outo-verwydering',
    63 => '',
    64 => '',
    65 => '',
    66 => '',
    67 => 'Maak die Inhoud skryfarea groter',
    68 => 'Maak die Inhoud skryfarea kleiner',
    69 => 'Publikasie Datum vir Artikel',
    70 => 'Kies Keusebalk',
    71 => 'Basiese Keusebalk',
    72 => 'Gewone Keusebalk',
    73 => 'Gevorderde Keusebalk',
    74 => 'Gevorderde II Keusebalk',
    75 => 'Volkeuse',
    76 => 'Opsies vir Publikasie',
    77 => 'Javascript moet geaktiveer wees vir die Gevorderde Skryfblok. Opsie kan in die hoofwerf config.php buite werking gestel word',
    78 => 'Kliek <a href="%s/story.php?mode=edit&sid=%s&editopt=default">hier</a> om die Standaard Skryfblok te gebruik',
    79 => 'Voorskou',
    80 => 'Skryfblok',
    81 => 'Publikasievoorkeure',
    82 => 'Beelde',
    83 => 'Argiefvoorkeure',
    84 => 'Regte',
    85 => 'Wys Alles',
    86 => 'Advanced Editor',
    87 => 'Story Stats'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Onderwerpbestuur',
    2 => 'Onderwerp ID',
    3 => 'Onderwerpnaam',
    4 => 'Onderwerpbeeld',
    5 => '(moenie spasies gebruik nie)',
    6 => 'Die verwydering van \'n onderwerp verwyder alle verbonde artikels en blokke daarmee saam',
    7 => 'Vul asseblief die Onderwerp ID- en Naamvelde in',
    8 => 'Onderwerpbestuur',
    9 => 'Om \'n onderwerp te wysig of te verwyder kliek op daardie onderwerp.  Om \'n nuwe onderwerp te skep, kliek op "Skep Nuwe" hierbo. Jy sal jou toegangsvlak vir elke onderwerp in hakies sien. Die sterretjie(*) verwys na die standaard onderwerp.',
    10 => 'Sorteer Volgorde',
    11 => 'Artikels/Bladsy',
    12 => 'Toegang Geweier',
    13 => "U probeer om toegang tot 'n onderwerp te verkry waartoe u nie regte het nie.  Hierdie poging is aangeteken. Gaan asseblief <a href=\"{$_CONF['site_admin_url']}/topic.php\">terug na die onderwerpbestuurskerm</a>.",
    14 => 'Sorteer Metode',
    15 => 'alfabeties',
    16 => 'standaard is',
    17 => 'Nuwe Onderwerp',
    18 => 'Admin Tuisblad',
    19 => 'stoor',
    20 => 'kanselleer',
    21 => 'verwyder',
    22 => 'Standaard',
    23 => 'maak hierdie die standaard onderwerp vir nuwe artikel bydraes',
    24 => '(*)',
    25 => 'Argief Onderwerp',
    26 => 'maak hierdie die standaard onderwerp vir die artikelargief. Slegs een onderwerp toegelaat.',
    27 => 'of Laai Onderwerp Ikoon',
    28 => 'Maksimum',
    29 => 'L&ecirc;er Oplaai Foute'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Gebruikersbestuur',
    2 => 'Gebruiker ID',
    3 => 'Gebruikersnaam',
    4 => 'Volle Naam',
    5 => 'Wagwoord',
    6 => 'Sekuriteitsvlak',
    7 => 'Epos-adres',
    8 => 'Tuisblad',
    9 => '(moenie spasies gebruik nie)',
    10 => 'Vul asseblief die Gebruikersnaam en Epos-adresvelde in',
    11 => 'Gebruikersbestuur',
    12 => 'Om \'n gebruiker te wysig of te verwyder, kliek op daardie gebruiker se wysig ikoon hieronder. Om \'n gebruiker se besonderhede te vertoon, kliek op die gebruikersnaam wat u wil bekyk. Om \'n nuwe gebruiker te skep, kliek op "Skep Nuwe" hierbo. U kan eenvoudige soektogte doen deur dele van die gebruikersnaam, epos-adres of volle naam (bv. *son* or *.edu) in die onderstaande vorm in te tik.',
    13 => 'Sekvlak',
    14 => 'Reg. Datum',
    15 => '',
    16 => '',
    17 => '',
    18 => '',
    19 => '',
    20 => 'stoor',
    21 => 'Die gebruikersnaam wat u probeer stoor het bestaan reeds.',
    22 => 'Fout',
    23 => 'Lysbyvoeging',
    24 => 'Voer Lys van Gebruikers in',
    25 => 'Jy kan \'n lys van gebruikers in Geeklog invoer.  Die invoerl&ecirc;er moet \'n tab-geskeide teksl&ecirc;er wees en moet die velde in die volgende volgorde h&ecirc;: volle naam, gebruikersnaam, epos-adres,.  Aan elke gebruiker wat jy so invoer sal \'n lukraak geskepte wagwoord gepos word.  Daar moet slegs een gebruiker per lyn verskyn.  As jy in gebreke bly om die aanwysings te volg kan baie probleme veroorsaak word wat baie werk kan verg om die inskrywings weer na te gaan!',
    26 => '',
    27 => '',
    28 => 'Merk hier om die prent te verwyder',
    29 => 'Pad',
    30 => 'Voer in',
    31 => 'Nuwe Gebruikers',
    32 => 'Verwerking voltooi. %d ingevoer met %d foute',
    33 => 'stuur',
    34 => 'Fout: Jy moet \'n l&ecirc;er spesifiseer om op te laai.',
    35 => 'Laaste Intekening',
    36 => '(nooit)',
    37 => 'GID',
    38 => 'Groepslys',
    39 => 'Wagwoord (weereens)',
    40 => 'Registrasie Datum',
    41 => 'Laaste Intekendatum',
    42 => 'Verban',
    43 => 'Wag op Aktivering',
    44 => 'Wag op Goedkeuring',
    45 => 'Aktief',
    46 => 'Gebruikerstatus',
    47 => 'Wysig',
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
    1 => 'Keur goed',
    2 => 'Verwyder',
    3 => 'Wysig',
    4 => 'Profiel',
    10 => 'Titel',
    11 => 'Begindatum',
    12 => 'URL',
    13 => 'Bydraes',
    14 => 'Datum',
    15 => 'Onderwerp',
    16 => 'Gebruikersnaam',
    17 => 'Volle naam',
    18 => 'Epos',
    34 => 'Bestuur en Beheer',
    35 => 'Artikel Bydraes',
    36 => '',
    37 => 'Gebeure Bydraes',
    38 => 'Stuur',
    39 => 'Daar is geen bydraes op hierdie tydstip wat aksie vereis nie',
    40 => 'Gebruikersbydraes'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Mail Utility",
    2 => 'Vanaf',
    3 => 'Antwoord na',
    4 => 'Onderwerp',
    5 => 'Hoofdeel',
    6 => 'Stuur na:',
    7 => 'Alle gebruikers',
    8 => 'Admin',
    9 => 'Opsies',
    10 => 'HTML',
    11 => 'Dringende Boodskap!',
    12 => 'Stuur',
    13 => 'Herstel',
    14 => 'Ignoreer gebruikersverstellings',
    15 => 'Fout tydens poging om te stuur na: ',
    16 => 'Boodskappe suksesvol gestuur na: ',
    17 => "<a href=\"{$_CONF['site_admin_url']}/mail.php\">Stuur 'n ander boodskap</a>",
    18 => 'Aan',
    19 => 'LET WEL: as u \'n boodskap aan alle werflede wil stuur, kies die Logged-in Users groep in die keuselys.',
    20 => "<successcount> Boodskappe is suksesvol gestuur en <failcount> pogings het misluk.  Die besonderhede van elke poging is hieronder gelys indien jy dit sou benodig.  Andersins kan u <a href=\"{$_CONF['site_admin_url']}/mail.php\">\'n ander boodskap stuur</a> of u kan <a href=\"{$_CONF['site_admin_url']}/moderation.php\">terugkeer na die administrasieblad</a>.",
    21 => 'Mislukkings',
    22 => 'Suksesse',
    23 => 'Geen mislukkings',
    24 => 'Geen suksesse',
    25 => '-- Kies Groep --',
    26 => 'Vul asseblief al die velde op die onderstaande vorm in en kies \'n groep gebruikers uit die keuselys.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Die installasie van proppe kan moontlik skade aan u Geeklog installasie verrig en dalk selfs aan u stelsel.  Dit is daarom belangrik dat u slegs proppe installeer wat afgelaai is vanaf die <a href="http://www.geeklog.net">Geeklog Tuisblad</a> aangesien ons alle proppe wat aaan ons gestuur word deeglik toets op \'n verkseidenheid bedryfstelsels.  Dit is belangrik dat u daarop let dat die prop installasieproses die uitvoer van \'n l&ecirc;erstelsel bevele vereis wat kan aanleiding gee tot sekuriteitsprobleme veral as u proppe vanaf derdeparty werwe gebruik.  Selfs met die waarskuwing kan ons nie die sukses aldan mislukking van enige installasie waarborg nie en aanvaar ons nie verantwoordelikheid vir skade wat veroorsaak word deur die installasie van \'n Geeklog prop nie.  Met ander woorde, u installeer op eie verantwoordelikheid.  Vir die versigtiges is aanwysings ingesluit oor hoe om \'n prop handmatig te installeer ook by elke proppakket ingesluit.',
    2 => 'Prop Installasie Vrywaring',
    3 => 'Prop Installasie Vorm',
    4 => 'Propl&ecirc;er',
    5 => 'Proplys',
    6 => 'Waarskuwing: Prop reeds ge&iuml;nstalleer!',
    7 => 'Die prop wat u probeer installeer bestaan reeds.  Verwyder asseblief die prop alvorens u dit herinstalleer',
    8 => 'Prop Versoenbaarheidstoets het Misluk',
    9 => 'Hierdie prop vereis \'n nuwer weergawe van Geeklog. Gradeer of u kopie van <a href="http://www.geeklog.net">Geeklog</a> op of kry \'n nuwer weergawe van die prop.',
    10 => '<br><b>Daar is tans geen proppe ge&iuml;nstalleer nie.</b><br><br>',
    11 => 'Om \'n prop te wysig of te verwyder,  kliek op daardie prop se ikoon hieronder. Dit sal die prop se besonderhede vertoon, insluitend die samesteller se webwerf.  Beide die ge&iuml;nstalleerde weergawe en die weergawe wat vanaf die prop se eie kode teruggestuur is, word vertoon.  Dit sal u in staat stel om vas te stel of die prop opgegradeer moet word.  Vir aanwysings oor hoe om \'n prop te installeer of op te gradeer raadpleeg daardie prop se dokumentasie.',
    12 => 'geen propnaam is aan plugineditor() verskaf nie',
    13 => 'Propbestuurder',
    14 => 'Nuwe Prop',
    15 => 'Admin Tuiste',
    16 => 'Propnaam',
    17 => 'Prop weergawe',
    18 => 'Geeklog Weergawe',
    19 => 'Aktief',
    20 => 'Ja',
    21 => 'Nee',
    22 => 'Installeer',
    23 => 'Stoor',
    24 => 'Kanselleer',
    25 => 'Verwyder',
    26 => 'Propnaam',
    27 => 'Prop Tuisblad',
    28 => 'Ge&iuml;nstalleerde Weergawe',
    29 => 'Geeklog Weergawe',
    30 => 'Verwyder Prop?',
    31 => 'Is u seker dat u hierdie prop wil verwyder?  Deur dit te doen verwyder u al die data en datastrukture wat deur hierdie prop gebruik word.  As u seker is, kliek dan weer op verwyder in die onderstaande vorm.',
    32 => '<p><b>Fout AutoLink tag nie in korrekte formaat</b></p>',
    33 => 'Kode Weergawe',
    34 => 'Opdateer',
    35 => 'Wysig',
    36 => 'Kode',
    37 => 'Data',
    38 => 'Opdateer!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'skep nuusvoer',
    2 => 'stoor',
    3 => 'verwyder',
    4 => 'kanselleer',
    10 => 'Inhoud Sindikasie',
    11 => 'Nuwe Nuusvoer',
    12 => 'Admin Tuiste',
    13 => 'Om \'n nuusvoer te wysig of te verwyder kliek op die nuusvoer se wysig ikoon hieronder. Om \'n nuwe voer te skep kliek op "Skep Nuwe" hierbo.',
    14 => 'Titel',
    15 => 'Soort',
    16 => 'L&ecirc;ernaam',
    17 => 'Formaat',
    18 => 'Laaste opdatering',
    19 => 'Aktief',
    20 => 'Ja',
    21 => 'Nee',
    22 => '<i>(geen nuusvoere)</i>',
    23 => 'alle Artikels',
    24 => 'Nuusvoerbestuurder',
    25 => 'Nuusvoertitel',
    26 => 'Limiet',
    27 => 'Lengte van inskrywings',
    28 => '(0 = geen teks, 1 = volledige teks, ander = beperk tot die aantal karakters)',
    29 => 'Beskrywing',
    30 => 'Laaste Opdatering',
    31 => 'Karakterstel',
    32 => 'Taal',
    33 => 'Inhoud',
    34 => 'Inskrywings',
    35 => 'Ure',
    36 => 'Kies jou soort nuusvoer',
    37 => 'U het ten minste een prop ge&iuml;nstalleer wat inhoudsindikasie ondersteun. Hieronder moet u kies of u \'n Geeklog nuusvoer wil h&ecirc; of \'n voer vanaf een van die proppe.',
    38 => 'Fout: Vermiste Velde',
    39 => 'Vul asseblief die Nuusvoer se Titel, Beskrywing en L&ecirc;ernaam in.',
    40 => 'Vul asseblief die aantal inskrywings of aantal ure in.',
    41 => 'Stuur',
    42 => 'Gebeure',
    43 => 'Alles',
    44 => 'Geen',
    45 => 'Opskrifskakel in onderwerp',
    46 => 'Beperk Resultate',
    47 => 'Soek',
    48 => 'Wysig',
    49 => 'Nuusvoer Logo',
    50 => "Relatief tot werf se url ({$_CONF['site_url']})",
    51 => 'The filename you have chosen is already used by another feed. Please choose a different one.',
    52 => 'Error: existing Filename'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "U wagwoord is aan u gepos en u behoort dit binnekort te ontvang. Volg asseblief die aanwysings in die boodskap.  Dankie dat u {$_CONF['site_name']} gebruik.",
    2 => "Dankie vir die artikel wat u voorgel&ecirc; het vir plasing op {$_CONF['site_name']}.  Dit sal ter goedkeuring aan ons personeel voorgel&ecirc; word. Indien dit goedgekeur word, sal u artikel beskikbaar wees sodat ander dit op ons werf kan lees.",
    3 => '',
    4 => "Dankie vir die gebeurtenis wat u vir plasing op {$_CONF['site_name']} voorgel&ecirc; het.  Dit sal ter goedkeuring aan ons personeel voorgel&ecirc; word.  Indien dit goedgekeur word, sal u gebeurtenis in ons <a href=\"{$_CONF['site_url']}/calendar.php\">kalender</a> verskyn.",
    5 => 'U rekeninginligting is suksesvol gestoor.',
    6 => 'U voorkeure is suksesvol gestoor.',
    7 => 'U kommentaarvoorkeure is suksesvol gestoor.',
    8 => 'U is suksesvol uitgeteken.',
    9 => 'U artikel is suksesvol gestoor.',
    10 => 'Die artikel is suksesvol verwyder.',
    11 => 'U blok is suksesvol gestoor.',
    12 => 'Die blok is suksesvol verwyder.',
    13 => 'U onderwerp is suksesvol gestoor.',
    14 => 'Die onderwerp en al sy artikels en blokke is suksesvol verwyder.',
    15 => '',
    16 => '',
    17 => 'U gebeurtenis is suksesvol gestoor.',
    18 => 'Die gebeurtenis is suksesvol verwyder.',
    19 => 'U peiling is suksesvol gestoor.',
    20 => 'Die peiling is suksesvol verwyder.',
    21 => 'Die gebruiker is suksesvol gestoor.',
    22 => 'Die gebruiker is suksesvol verwyder.',
    23 => '\'n Fout het voorgekom tydens die byvoeg van \'n gebeurtenis op u kalender.  Geen gebeurtenis id is aangestuur.',
    24 => 'Die gebeurtenis is in u kalender gestoor',
    25 => 'Kan nie u persoonlike kalender oopmaak alvorens u inteken nie',
    26 => 'Gebeurtenis is suksesvol verwyder vanuit u persoonlike kalender',
    27 => 'Boodskap suksesvol gestuur.',
    28 => 'Die proppie is suksesvol gestoor',
    29 => 'Jammer, die persoonlike kalenderfunksie is nie op hierdie werf geaktiveer nie',
    30 => 'Toegang geweier',
    31 => 'Jammer, u het nie toegang tot die artikel adminblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    32 => 'Jammer, u het nie toegang tot die onderwerp adminblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    33 => 'Jammer, u het nie toegang tot die blok adminblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    34 => 'Jammer, u het nie toegang tot die skakel adminblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    35 => 'Jammer, u het nie toegang tot die gebeure adminblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    36 => 'Jammer, u het nie toegang tot die peiling adminblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    37 => 'Jammer, u het nie toegang tot die gebruiker adminblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    38 => 'Jammer, u het nie toegang tot die prop adminblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    39 => 'Jammer, u het nie toegang tot die epos adminblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    40 => 'Stelselboodskap',
    41 => 'Jammer, u het nie toegang to die woordvervangingsblad nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    42 => 'U woord is suksesvol gestoor.',
    43 => 'Die woord is suksesvol verwyder.',
    44 => 'Die prop is suksesvol gestoor!',
    45 => 'Die prop is suksesvol verwyder.',
    46 => 'Jammer, u het nie toegang tot die databasis rugsteunfunksie nie.  Neem kennis dat alle pogings tot ongemagtigde toegang aangeteken word',
    47 => 'Hierdie funksie werk slegs onder *nix stelsels.  Indien u wel \'n *nix bedryfstelsel gebruik is u kasgeheue suksesvol skoongevee. As u op Windows werk, moet u na l&ecirc;ers soek met die naam adodb_*.php en hulle handmatig verwyder.',
    48 => "Dankie vir u aansoek vir lidmaatskap tot {$_CONF['site_name']}. Ons span sal u aansoek nagaan.  Indien goedgekeur, sal u wagwoord gestuur word aan die epos adres wat u verskaf het.",
    49 => 'U groep is suksesvol gestoor.',
    50 => 'Die groep is suksesvol verwyder.',
    51 => 'Hierdie gebruikersnaam is reeds in gebruik.  Kies asseblief \'n ander een.',
    52 => 'Die epos adres deur u verskaf blyk nie \'n geldige epos adres te wees nie.',
    53 => 'U nuwe wagwoord is aanvaar.  Gebruik u nuwe wagwoord hieronder om nou in te teken.',
    54 => 'U versoek vir \'n nuwe wagwoord het verval.  Probeer weer hieronder.',
    55 => '\'n Epos is aan u gestuur en behoort u binnekort te bereik.  Volg asseblief die aanwysings in die boodskap om \'n nuwe wagwoord vir u rekening op te stel.',
    56 => 'Die epos-adres verskaf is reeds in gebruik vir \'n ander rekening.',
    57 => 'U rekening is suksesvol verwyder.',
    58 => 'U nuusvoer is suksesvol gestoor.',
    59 => 'Die nuusvoer is suksesvol verwyder.',
    60 => 'Die prop is suksesvol opgedateer',
    61 => 'Prop %s: Onbekende boodskap plekhouer',
    62 => 'Die terugspoor kommentaar is verwyder.',
    63 => '\'n Fout het voorgekom tydens die verwydering van die terugspoorkommentaar.',
    64 => 'U terugspoorkommentaar is suksesvol gestuur.',
    65 => 'Boernaal gidsdiens suksesvol gestoor.',
    66 => 'Die boernaal gidsdiens is suksesvol verwyder.',
    67 => 'Die nuwe wagwoord stem nie met die bevestigingswagwoord ooreen nie!',
    68 => 'U moet die korrekte huidige wagwoord insleutel.',
    69 => 'U rekening is geblokeer!',
    70 => 'U rekening is nog hangende goedkeuring deur die administrateur.',
    71 => 'U rekening is bevestig en aktivering is nog hangende goedkeuring deur die administrateur.',
    72 => '\'n Fout het voorgekom tydens die poging om die prop te installeer.  Sien error.log vir besonderhede.',
    73 => '\'n Fout het voorgekom met die poging om die prop te verwyder.  Sien error.log vir besonderhede.',
    74 => 'Die skakelkennisgewing is suksesvol gestuur.',
    75 => 'Terugsporings moet gestuur word deur die POST versoek.',
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
    'ownerroot' => 'Eienaar/Root',
    'group' => 'Groep',
    'readonly' => 'Lees-Alleen',
    'accessrights' => 'Toegangsregte',
    'owner' => 'Eienaar',
    'grantgrouplabel' => 'Gee Bogenoemde Groep Wysigingsregte',
    'permmsg' => 'Let Wel: lede is al die ingetekende lede van die werf en anoniem is alle gebruikers wat die werf lees sonder om in te teken.',
    'securitygroups' => 'Sekuriteitsgroepe',
    'editrootmsg' => "Selfs al is u 'n Administrateur, kan u nie 'n kerngebruiker wysig sonder om self 'n kerngebruiker te wees nie.  U kan alle ander gebruikers wysig buiten die kerngebruikers. Let wel dat alle pogings om kerngebruikers onregmatig te wysig aangeteken word.  Gaan asseblief terug na die <a href=\"{$_CONF['site_admin_url']}/user.php\">Gebruiker Adminblad</a>.",
    'securitygroupsmsg' => 'Merk die keuseboksies vir die groep waaraan u die gebruiker wil toewys.',
    'groupeditor' => 'Groepbestuur',
    'description' => 'Beskrywing',
    'name' => 'Naam',
    'rights' => 'Regte',
    'missingfields' => 'Vermiste velde',
    'missingfieldsmsg' => 'U moet die naam en beskrywing van die groep verskaf',
    'groupmanager' => 'Groepbestuurder',
    'newgroupmsg' => 'Om \'n groep te wysig of te verwyder kliek op daardie groep se wysig ikoon hieronder. Om \'n nuwe groep te skep kliek op "Skep Nuwe" hierbo. Let asseblief daarop dat kerngroepe nie verwyder kan word nie omdat hulle deur die stelsel gebruik word.',
    'groupname' => 'Groepnaam',
    'coregroup' => 'Kerngroep',
    'yes' => 'Ja',
    'no' => 'Nee',
    'corerightsdescr' => "Hierdie groep is 'n kerngroep van {$_CONF['site_name']}.  Daarom kan die regte vir hierdie groep nie gewysig word nie.  Hieronder is 'n lees-alleen lys van die regte waartoe hierdie groep toegang het.",
    'groupmsg' => 'Sekuriteitsgroepe op hierdie werf is hi&euml;rargies.  Deur hierdie groep by enige van die ander groepe hieronder te voeg sal u hierdie groep dieselfde regte gee wat daardie groep het.  Waar moontlik word u aangemoedig om die onderstaande groepe te gebruik om regte aan \'n groep toe te ken.  As u pasgemaakte regte aan \'n groep wil toeken kan u die regte tot die verskeie werf-funksies in die afdeling genaamd \'Regte\' kies.  Om hierdie groep by enige van die onderstaandes te voeg merk u eenvoudig die boksie langs die groep(e) wat u verlang.',
    'coregroupmsg' => "Hierdie groep is 'n kerngroep van {$_CONF['site_name']}.  Daarom sal die groepe wat aan hierdie groep behoort nie gewysig kan word nie.  Hieronder is 'n lees-alleen lys van die groepe waaraan hierdie groep behoort.",
    'rightsdescr' => '\'n Groep se toegang tot sekere regte hieronder aangetoon kan direk aan die groep toegeken word OF aan \'n ander groep waarvan hierdie groep \'n lid is.  Diegene wat u hieronder sien sonder \'n keuseblok is die regte wat aan hierdie groep toegeken is uit hoofde van sy lidmaatskap aan \'n ander groep met daardie regte.  Die regte hieronder met keusebokse daarlangsaan is regte wat direk aan hierdie groep toegeken kan word.',
    'lock' => 'Sluit',
    'members' => 'Lede',
    'anonymous' => 'Anoniem',
    'permissions' => 'Regte',
    'permissionskey' => 'R = Lees, E = Wysig, wysigingsregte impliseer leesregte is toegeken',
    'edit' => 'Wysig',
    'none' => 'Geen',
    'accessdenied' => 'Toegang Geweier',
    'storydenialmsg' => "U het nie toegang tot hierdie artikel nie.  Dit kan wees omdat u nie 'n lid van {$_CONF['site_name']} is nie.  Registreer asseblief <a href=\"{$_CONF['site_url']}/users.php?mode=new\">as 'n lid</a> of {$_CONF['site_name']} om volle ledetoegang  te verkry!",
    'nogroupsforcoregroup' => 'Hierdie groep behoort nie aan enige ander groep nie',
    'grouphasnorights' => 'Hierdie groep het nie toegang tot enige van die administratiewe funksies van hierdie werf nie',
    'newgroup' => 'Nuwe Groep',
    'adminhome' => 'Admin Tuisblad',
    'save' => 'stoor',
    'cancel' => 'kanselleer',
    'delete' => 'verwyder',
    'canteditroot' => 'U het probeer om die kerngroep te wysig maar u is nie \'n lid van die kerngroep nie, daarom word u toegang tot die groep geweier.  Kontak die stelseladministrateur as u voel dat dit \'n fout is.',
    'listusers' => 'Lede',
    'listthem' => 'lys',
    'usersingroup' => 'Gebruikers in groep "%s"',
    'usergroupadmin' => 'Gebruikersgroep Administrasie',
    'add' => 'Sit by',
    'remove' => 'Verwyder',
    'availmembers' => 'Beskikbare Lede',
    'groupmembers' => 'Groepslede',
    'canteditgroup' => 'Om hierdie groep te wysig, moet u \'n lid van die groep wees.  Kontak asseblief die stelseladministrateur as u voel dat dit \'n fout is.',
    'cantlistgroup' => 'Om die lede van hierdie groep te besigtig, moet u self \'n lid wees. Kontak asseblief die stelseladministrateur as u voel dat dit \'n fout is.',
    'editgroupmsg' => 'Om die ledelys van die groep te wysig kliek op die lidnaam/name en gebruik die Sit by of Verwyder knop. As die lede aan die groep behoort sal hul name sleg aan die regterkant verskyn. Wanneer u klaar is - druk <b>Stoor</b> om die groep op datum te bring en dan terug te keer na die hoof groep adminblad.',
    'listgroupmsg' => 'Lys van alle huidige lede in die groep: <b>%s</b>',
    'search' => 'Soektog',
    'submit' => 'Stuur',
    'limitresults' => 'Beperk Resultate',
    'group_id' => 'Groep ID',
    'plugin_access_denied_msg' => 'U probeer onregmatiglik om toegang tot \'n prop se administrasieblad te verkry.  Let wel alle pogings tot onregmatige toegang tot hierdie blad word aangeteken.',
    'groupexists' => 'Groepnaam bestaan reeds',
    'groupexistsmsg' => 'Daar is reeds \'n groep met hierdie naam.  Groepname moet uniek wees.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Laaste 10 Rugsteunings',
    'do_backup' => 'Voer Rugsteun uit',
    'backup_successful' => 'Databasis rugsteuning was suksesvol.',
    'db_explanation' => 'Om \'n nuwe rugsteunkopie van u werf se databasis te skep kliek op "Skep Nuwe" hierbo.',
    'not_found' => "Foutiewe pad of mysqldump program is nie uitvoerbaar nie.<br>Gaan die <strong>\$_DB_mysqldump_path</strong> definisie in config.php na.<br>Veranderlike is tans gedefinie&euml;r as: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Rugsteuning het Misluk: L&ecirc;ergrootte was 0 grepe',
    'path_not_found' => "{$_CONF['backup_path']} bestaan nie of is nie 'n gids (directory) nie",
    'no_access' => "Fout: Gids (directory) {$_CONF['backup_path']} is nie toeganklik nie.",
    'backup_file' => 'Rugsteunl&ecirc;er',
    'size' => 'Grootte',
    'bytes' => 'Grepe',
    'total_number' => 'Totale aantal rugsteunings: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Tuisblad',
    2 => 'Kontak',
    3 => 'Publiseer u Werk',
    4 => 'Skakels',
    5 => 'Peilings',
    6 => 'Kalender',
    7 => 'Werfstatistieke',
    8 => 'Verpersoonlik',
    9 => 'Soektog',
    10 => 'gevorderde soektog',
    11 => 'Gids'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Fout',
    2 => 'Gits, ek het oral gesoek maar kan nie <b>%s</b> opspoor nie.',
    3 => "<p>Ons is jammer, maar die l&ecirc;er wat u versoek het bestaan nie. Gaan gerus die <a href=\"{$_CONF['site_url']}\">tuisblad</a> of die <a href=\"{$_CONF['site_url']}/search.php\">soekblad</a> na om te sien of u dit wat u verloor het kan opspoor."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Intekening word vereis',
    2 => 'Jammer, om toegang to hierdie blad te verkry moet u as gebruiker ingeteken wees.',
    3 => 'Intekening',
    4 => 'Nuwe Gebruiker'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'Die PDF funksie is gedeaktiveer',
    2 => 'Die verskafde dokument is nie vertaal nie.  Die dokument is ontvang maar kon nie verwerk word nie.  Maak seker dat u slegs html formaat dokument voorl&ecirc; wat aan die xHTML standaard voldoen. Neem kennis dat onnodig komplekse html dokumente nie noodwendig korrek of enigsins vertaal sal word nie. Die dokument uit u poging was 0 grepe in lengte en is verwyder. As u seker is dat u dokument behoorlik vertaal behoort te word, stuur dit weereens.',
    3 => 'Onbekende fout tydens skep van PDF',
    4 => 'Geen bladsy is verskaf of u wil dalk die ad-hoc PDF funksie hieronder gebruik.  As u glo dat u verkeerdelik die blad gekry het, kontak die stelseladministrateur.  Andersins kan u die onderstaande vorm gebruik om die PDF op \'n ad-hoc wyse te skep.',
    5 => 'Besig om u dokument te laai.',
    6 => 'Wag asseblief terwyl u dokument gelaai word.',
    7 => 'U kan met regterknop op die onderstaande knop kliek en dan kies \'save target...\' of \'save link location...\' om \'n kopie van u dokument te stoor.',
    8 => 'Die gegewe pad wat in die konfigurasie l&ecirc;er van die HTMLDoc program is ongeldig of di&eacute; stelsel kan dit nie uitvoer nie.  Kontak die werfadministrateur as die probleem voortduur.',
    9 => 'PDF-Skrywer',
    10 => 'Hierdie is die Ad-hoc PDF-skrywer hulpmiddel. Dit sal poog om enige URL wat u verskaf na \'n PDF om te skakel.  Neem kennis dat sommige web-bladsye nie korrek vertaal sal word met hierdie funksie nie.  Dit is \'n beperking van die HTMLDoc PDF-skrywer program en sulke foute moet dus nie aan die administrateur van die werf gerapporteer word nie',
    11 => 'URL',
    12 => 'Skryf PDF!',
    13 => 'Die PHP konfigurasie op hierde bediener laat nie toe dat URL\'le gebruik word met die fopen() bevel nie.  Die stelseladministrateur moet die php.ini l&ecirc;er wysig en die set allow_url_fopen veranderlike na On toe stel',
    14 => 'Die PDF wat u versoek het bestaan nie of u het probeer om onregmatiglik toegang tot \'n l&ecirc;er te verkry.'
);

###############################################################################
# trackback.php

$LANG_TRB = array(
    'trackback' => 'Terugspoor',
    'from' => 'vanaf',
    'tracked_on' => 'Gespoor op',
    'read_more' => '[lees verder]',
    'intro_text' => 'Hier is wat ander oor \'%s\' te s&ecirc; gehad het:',
    'no_comments' => 'Geen terugspoorkommentaar vir hierdie inskrywing nie.',
    'this_trackback_url' => 'Terugspoor URL vir hierdie inskrywing:',
    'num_comments' => '%d terugspoorkommentare',
    'send_trackback' => 'Stuur Skakelkennisgewings',
    'preview' => 'Voorskou',
    'editor_title' => 'Stuur terugspoorkommentaar',
    'trackback_url' => 'Terugspoor URL',
    'entry_url' => 'Inskrywing URL',
    'entry_title' => 'Inskrywing Titel',
    'blog_name' => 'Werfnaam',
    'excerpt' => 'Uittreksel',
    'truncate_warning' => 'Let wel: Die werf wat ontvang kan dalk u uittreksel kortknip',
    'button_send' => 'Stuur',
    'button_preview' => 'Voorskou',
    'send_error' => 'Fout',
    'send_error_details' => 'Fout tydens stuur van terugspoorkommentaar:',
    'url_missing' => 'Geen Inskrywing URL',
    'url_required' => 'Verskaf asseblief ten minste \'n URL vir die inskrywing.',
    'target_missing' => 'Geen Terugspoor URL',
    'target_required' => 'Sleutel asseblief \'n terugspoor URL in',
    'error_socket' => 'Kon nie socket oopmaak nie.',
    'error_response' => 'Terugvoer nie verstaan.',
    'error_unspecified' => 'Onbekende fout.',
    'select_url' => 'Kies Terugspoor URL',
    'not_found' => 'Terugspoor URL nie gevind',
    'autodetect_failed' => 'Geeklog kon nie die Terugspoor URL opspoor vir die inskrywing waarna u, u kommentaar wil stuur nie.  Sleutel dit asseblief per hand hieronder in.',
    'trackback_explain' => 'Kies asseblief uit die skakels hieronder die URL waarheen u, u Terugspoorkommentaar wil stuur. Geeklog sal dan poog om die korrekte Terugspoor URL vir daardie inskrywing op te spoor. Of u kan <a href="%s">dit met die hand insleutel</a> as u dit reeds ken.',
    'no_links_trackback' => 'Geen skakels opgespoor nie.  U kan nie \'n Terugspoorkommentaar vir hierdie inskrywing stuur nie.',
    'pingback' => 'Skakelkennisgewing',
    'pingback_results' => 'Skakelkennisgewing resultate',
    'send_pings' => 'Stuur Skakelkennisgewings',
    'send_pings_for' => 'Stuur Skakelkennisgewing vir "%s"',
    'no_links_pingback' => 'Geen skakels opgespoor.  Geen Skakelkennisgewing is vir hierdie inskrywing gestuur nie.',
    'pingback_success' => 'Skakelkennisgewing gestuur.',
    'no_pingback_url' => 'Geen skakelkennisgewing URL gevind.',
    'resend' => 'Stuur weer',
    'ping_all_explain' => 'U kan nou werwe waarna u skakel daarvan in kennis stel deur (<a href="http://af.wikipedia.org/wiki/Skakelkennisgewing">Skakelkennisgewing</a>), adverteer dat u werf opgedateer is deur boernaalgids dienste te raadpleeg of \'n <a href="http://af.wikipedia.org/wiki/Terugspoorkommentaar">Terugspoorkommentaar</a> te stuur in geval u kommentaar gelewer het op \'n inskrywing op iemand anders se werf.',
    'pingback_button' => 'Stuur Skakelkennisgewing',
    'pingback_short' => 'Stuur Skakelkennisgewing na al die werwe wat waarna in hierdie inskrywing geskakel word.',
    'pingback_disabled' => '(Skakelkennisgewings gedeaktiveer)',
    'ping_button' => 'Stuur Kennisgewing',
    'ping_short' => 'Stel boernaalgids dienste in kennis.',
    'ping_disabled' => '(Kennisgewing  gedeaktiveer)',
    'trackback_button' => 'Stuur Terugsporing',
    'trackback_short' => 'Stuur \'n Terugspoorkommentaar.',
    'trackback_disabled' => '(Terugspoor gedeaktiveer)',
    'may_take_a_while' => 'Neem kennis dat Skakelkennisgewings en Kennisgewings \'n tydjie mag neem.',
    'ping_results' => 'Kennisgewingresultate',
    'unknown_method' => 'Onbekende kennisgewingmetode',
    'ping_success' => 'Kennisgewing gestuur.',
    'error_site_name' => 'Sleutel die werf se naam in.',
    'error_site_url' => 'Sleutel die werf se URL in.',
    'error_ping_url' => 'Sleutel \'n geldige Kennisgewing URL in.',
    'no_services' => 'Geen boernaalgidsdiens is opgestel nie.',
    'services_headline' => 'Boernaalgidsdienste',
    'service_explain' => 'Om \'n boernaalgidsdiens te wysig of te verwyder kliek op die wysig ikoon van daardie diens hieronder. Om \'n nuwe boernaal diensgids by te voeg, kliek op "Skep Nuwe" hierbo.',
    'service' => 'Diens',
    'ping_method' => 'Kennisgewingsmetode',
    'service_website' => 'Webwerf',
    'service_ping_url' => 'URL om in kennis te stel',
    'ping_standard' => 'Standaard Kennisgewing',
    'ping_extended' => 'Uitgebreide Kennisgewing',
    'ping_unknown' => '(onbekende metode)',
    'edit_service' => 'Wysig Boernaalgidsdiens',
    'trackbacks' => 'Terugsporings',
    'editor_intro' => 'Berei u terugspoorkommentaar vir <a href="%s">%s</a> voor.',
    'editor_intro_none' => 'Berei u terugspoorkommentaar voor.',
    'trackback_note' => 'Om \'n terugspoorkommentaar vir \'n artikel te stuur, gaan na die lys van artikels en kliek op "Stuur Pieng" vir die artikel. Om \'n terugspoor te stuur wat nie verband hou met \'n artikel nie, <a href="%s">kliek hier</a>.',
    'pingback_explain' => 'Sleutel \'n URL in waarna die Skakelkennisgewing gestuur moet word.  Die kennisgewing sal sal na u werf se tuisblad verwys.',
    'pingback_url' => 'Skakelkennisgewing URL',
    'site_url' => 'Hierdie werf se URL',
    'pingback_note' => 'Om \'n skakelkennisgewing vir \'n artikel te stuur gaan na die lys van artikels en kliek op stories en kliek op "Stuur Pieng" vir die artikel. Om \'n skakelkennisgewing te stuur wat nie verband hou met \'n artikel nie, <a href="%s">kliek hier</a>.',
    'pbtarget_missing' => 'Geen Skakelkennisgewing URL',
    'pbtarget_required' => 'Sleutel asseblief \'n skakelkennisgewing URL in',
    'pb_error_details' => 'Fout tydens stuur van skakelkennisgewing:',
    'delete_trackback' => 'To delete this Trackback click: '
);

###############################################################################
# directory.php

$LANG_DIR = array(
    'title' => 'Artikelgids',
    'title_year' => 'Artikelgids vir  %d',
    'title_month_year' => 'Artikelgids vir %s %d',
    'nav_top' => 'Terug na die Artikelgids',
    'no_articles' => 'Geen Artikels.'
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
    'new_string' => '%n nuwe %i in die laaste %t %s',
    'new_last' => 'laaste %t %s',
    'minutes' => 'minute',
    'hours' => 'ure',
    'days' => 'dae',
    'weeks' => 'weke',
    'months' => 'maande',
    'minute' => 'minuut',
    'hour' => 'uur',
    'day' => 'dag',
    'week' => 'week',
    'month' => 'maand'
);

###############################################################################
# Month names

$LANG_MONTH = array(
    1 => 'Januarie',
    2 => 'Februarie',
    3 => 'Maart',
    4 => 'April',
    5 => 'Mei',
    6 => 'Junie',
    7 => 'Julie',
    8 => 'Augustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
);

###############################################################################
# Weekdays

$LANG_WEEK = array(
    1 => 'Sondag',
    2 => 'Maandag',
    3 => 'Dinsdag',
    4 => 'Woensdag',
    5 => 'Donderdag',
    6 => 'Vrydag',
    7 => 'Saterdag'
);

###############################################################################
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array(
    'search' => 'Soektog',
    'limit_results' => 'Beperk Resultate',
    'submit' => 'Stuur',
    'edit' => 'Wysig',
    'edit_adv' => 'Adv. Edit',
    'admin_home' => 'Admin Tuisblad',
    'create_new' => 'Skryf iets',
    'create_new_adv' => 'Create New (Adv.)',
    'enabled' => 'Aktief',
    'title' => 'Titel',
    'type' => 'Tipe',
    'topic' => 'Onderwerp',
    'help_url' => 'Hulpl&ecirc;er URL',
    'save' => 'Stoor',
    'cancel' => 'Kanselleer',
    'delete' => 'Verwyder',
    'delete_sel' => 'Delete selected',
    'copy' => 'Kopi&euml;er',
    'no_results' => '- Geen inskrywings opgespoor -',
    'data_error' => 'Daar was \'n fout tydens die verwerking van die intekenlysdata. Gaan asseblief databron na.',
    'preview' => 'Preview',
    'records_found' => 'Records found'
);

###############################################################################
# Localisation of the texts for the various drop-down menus that are actually
# stored in the database. If these exist, they override the texts from the
# database.

$LANG_commentcodes = array(
    0 => 'Kommentaar Aktief',
    -1 => 'Kommentaar Onaktief'
);


$LANG_commentmodes = array(
    'flat' => 'Plat',
    'nested' => 'Genestel',
    'threaded' => 'Geryg',
    'nocomment' => 'Geen Kommentaar'
);

$LANG_cookiecodes = array(
    0 => '(moenie)',
    3600 => '1 Uur',
    7200 => '2 Ure',
    10800 => '3 Ure',
    28800 => '8 Ure',
    86400 => '1 Dag',
    604800 => '1 Week',
    2678400 => '1 Maand'
);

$LANG_dateformats = array(
    0 => 'Stelselstandaard'
);

$LANG_featurecodes = array(
    0 => 'Nie Uitgelig',
    1 => 'Uitgelig'
);

$LANG_frontpagecodes = array(
    0 => 'Wys Slegs in Onderwerp',
    1 => 'Wys op Voorblad'
);

$LANG_postmodes = array(
    'plaintext' => 'Gewone Teks',
    'html' => 'HTML Formaat'
);

$LANG_sortcodes = array(
    'ASC' => 'Oudste Eerste',
    'DESC' => 'Nuutste Eerste'
);

$LANG_trackbackcodes = array(
    0 => 'Terugsporings Aktief',
    -1 => 'Terugsporings Onaktief'
);

?>