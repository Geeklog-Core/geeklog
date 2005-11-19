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
    1 => 'Skrivet av:',
    2 => 'läs mer',
    3 => 'kommentar(er)',
    4 => 'Redigera',
    5 => 'Rösta',
    6 => 'Resultat',
    7 => 'Röstresultat',
    8 => 'röster',
    9 => 'Administratörsfunktioner:',
    10 => 'Bidrag',
    11 => 'Artiklar',
    12 => 'Block',
    13 => 'Ämnen',
    14 => 'Länkar',
    15 => 'Aktiviteter',
    16 => 'Omröstningar',
    17 => 'Användare',
    18 => 'SQL Query',
    19 => 'Logga ut',
    20 => 'Användarinformation:',
    21 => 'Användarnamn',
    22 => 'Användarnamn',
    23 => 'Säkerhetsnivå',
    24 => 'Anonym',
    25 => 'Skriv ett inlägg',
    26 => 'Följande inlägg ägs av de personer som gjort dem.  Denna sajt tar inget ansvar för det som sägs.',
    27 => 'Senaste kommentar',
    28 => 'Radera',
    29 => 'Inga kommentarer.',
    30 => 'Äldre artiklar',
    31 => 'Tillåten HTML:',
    32 => 'Error, felaktigt användarnamn',
    33 => 'Error, kunde inte skriva till logfilen',
    34 => 'Error',
    35 => 'Logga ut',
    36 => 'på',
    37 => 'Inga artiklar',
    38 => 'Content Syndication',
    39 => 'Uppdatera',
    40 => 'Du har <tt>register_globals = Off</tt> i din <tt>php.ini</tt>. Geeklog kräver att <tt>register_globals</tt> är påslaget. Innan du fortsätter så måste du sätta det till <strong>on</strong> och starta om din webbserver.',
    41 => 'Gäster',
    42 => 'Skrivet av:',
    43 => 'Svara på detta',
    44 => 'Upp',
    45 => 'MySQL Error Number',
    46 => 'MySQL felmeddelande',
    47 => 'Användarfunktioner',
    48 => 'Kontoinformation',
    49 => 'Inställningar',
    50 => 'Fel i SQL-förfrågan',
    51 => 'hjälp',
    52 => 'Ny',
    53 => 'Administratörsmeny',
    54 => 'Kunde inte öppna filen.',
    55 => 'Fel vid',
    56 => 'Rösta',
    57 => 'Lösenord',
    58 => 'Logga in',
    59 => "Har du inget konto?  <a href=\"{$_CONF['site_url']}/users.php?mode=new\">Anmäl dig här!</a>",
    60 => 'Diskutera...',
    61 => 'Skapa nytt konto',
    62 => 'ord',
    63 => 'Kommentarsinst.',
    64 => 'Eposta artikel till någon',
    65 => 'Version för utskrift',
    66 => 'Min kalender',
    67 => 'Välkommen till ',
    68 => 'hem',
    69 => 'kontakt',
    70 => 'sök',
    71 => 'skriv artikel',
    72 => 'internetlänkar',
    73 => 'tidigare omröstningar',
    74 => 'kalender',
    75 => 'detaljerad sökning',
    76 => 'statistik',
    77 => 'Plugin',
    78 => 'Kommande aktiviteter',
    79 => 'Nytt på sajten',
    80 => 'artiklar de senaste',
    81 => 'artikel de senaste',
    82 => 'timmarna',
    83 => 'KOMMENTARER',
    84 => 'LÄNKAR',
    85 => 'senaste 48 hrs',
    86 => 'Inga nya kommentarer',
    87 => 'senaste två veckorna',
    88 => 'Inga nya länkar',
    89 => 'Det finns inga kommande aktiviteter',
    90 => 'Hem',
    91 => 'Skapade denna sida på',
    92 => 'sekunder',
    93 => 'Copyright',
    94 => 'Alla varumärken och copyright på denna sida ägs av deras respektive ägare.',
    95 => 'Powered By',
    96 => 'Grupper',
    97 => 'Ordlista',
    98 => 'Insticksmodul',
    99 => 'ARTIKLAR',
    100 => 'Inga nya artiklar',
    101 => 'Dina aktiviteter',
    102 => 'Sajtaktiviteter',
    103 => 'DB backup',
    104 => 'av',
    105 => 'Eposta användare',
    106 => 'visningar',
    107 => 'GL versionstest',
    108 => 'Radera buffert',
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
    123 => 'All HTML is allowed'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Aktivitetskalender',
    2 => 'Det finns tyvärr inga aktiviteter att visa.',
    3 => 'När',
    4 => 'Var',
    5 => 'Beskrivning',
    6 => 'Ny aktivitet',
    7 => 'Kommande aktiviteter',
    8 => 'Genom att lägga till denna aktivitet till din kalender så kan du snabbt se enbart de aktiviteter du är intresserad av genom att klicka på "Min kalender" från användarfunktionsmenyn.',
    9 => 'Lägg till i min kalender',
    10 => 'Radera från min kalender',
    11 => "Lägger till aktivitet i {$_USER['username']}:s kalender",
    12 => 'Aktivitet',
    13 => 'Startar',
    14 => 'Slutar',
    15 => 'Tillbaka till kalendern'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Skriv en kommentar',
    2 => 'Kommentarsläge',
    3 => 'Logga ut',
    4 => 'Skapa ett konto',
    5 => 'Användarnamn',
    6 => 'För att skriva en kommentar på denna sajt måste man ha ett konto.  Om du inte har ett konto så kan du använda formuläret nedan för att skapa ett.',
    7 => 'Din senaste kommentar var ',
    8 => " sekunder sedan.  På denna sajt måste man vänta minst {$_CONF['commentspeedlimit']} sekunder mellan kommentarer",
    9 => 'Kommentar',
    10 => 'Send Report',
    11 => 'Skicka in kommentar',
    12 => 'Du måste fylla i Titel- Kommentarsfälten.',
    13 => 'Din information',
    14 => 'Förhandsgranska',
    15 => 'Report this post',
    16 => 'Titel',
    17 => 'Error',
    18 => 'Att tänka på',
    19 => 'Försök hålla kommentarerna till ämnet.',
    20 => 'Försök svara på andra personers kommentarer istället för att starta nya diskussioner.',
    21 => 'Läs andra personers kommentarer innan du gör ditt inlägg för att förhindra upprepning av det som redan sagts.',
    22 => 'Använd en tydlig ärenderad som beskriver vad ditt inlägg handlar om.',
    23 => 'Din epostadress kommer INTE att vara publik.',
    24 => 'Anonym användare',
    25 => 'Är du säker på att du vill rapportera detta inlägg till sajtadministratören?',
    26 => '%s har rapporterat följande inlägg:',
    27 => 'Anmäl missbruk'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Användarprofil för',
    2 => 'Användarnamn',
    3 => 'För- och efternamn',
    4 => 'Lösenord',
    5 => 'Epost',
    6 => 'Hemsida',
    7 => 'Personlig information',
    8 => 'PGP-nyckel',
    9 => 'Spara information',
    10 => 'De tio senaste kommentarerna för användare',
    11 => 'Inga användarkommentarer',
    12 => 'Användarinställningar för',
    13 => 'Eposta nattlig sammanställning',
    14 => 'Detta lösenord genereras av en slumpgenerator.  Du rekommenderas att omedelbart byta detta lösenord.  För att byta lösenord loggar man in och klickar på Kontoinformation från Användarfunktionsmenyn.',
    15 => "Ditt {$_CONF['site_name']} konto är nu skapat.  För att använda det måste du logga in med hjälp av informationen nedan.  Spara detta mail för framtida bruk.",
    16 => 'Din kontoinformation',
    17 => 'Konto existerar inte',
    18 => 'Den angivna epostadressen verkar inte vara giltig',
    19 => 'Användarnamnet eller epostadressen existerar redan',
    20 => 'Den angivna epostadressen verkar inte vara giltig',
    21 => 'Error',
    22 => "Registrera med {$_CONF['site_name']}!",
    23 => "När du skapar ett användarkonto kommer du att få ta del av {$_CONF['site_name']}:s fördelar och du kommer att få möjlighet att posta kommentarer och skicka in artiklar som dig själv.  Om man inte har ett konto så kan man bara medverka anonymt.  Lägg märke till att din epostadress <B>aldrig</B> kommer att visas offentligt på denna sajt.",
    24 => 'Ditt lösenord kommer att skickas till den epostadress du anger.',
    25 => 'Har du glömt ditt lösenord?',
    26 => 'Ange ditt användarnamn <em>eller</em> din registrerade epostadress och klicka på "Eposta lösenord" så kommer ett nytt lösenord att skickas till den epostadress vi har i vårt register.',
    27 => 'Registrera nu!',
    28 => 'Eposta lösenord',
    29 => 'loggade ut från',
    30 => 'loggade in från',
    31 => 'För att använda denna funktion måste du vara inloggad',
    32 => 'Signatur',
    33 => 'Aldrig offentlig',
    34 => 'Detta är ditt för- och efternamn',
    35 => 'Ange lösenord för att ändra det',
    36 => 'Börjar med http://',
    37 => 'Läggs till dina kommentarer',
    38 => 'Det handlar om dig!  Alla kan läsa detta',
    39 => 'Din publika PGP-nyckel att dela ut',
    40 => 'Inga ämnesikoner',
    41 => 'Beredd att moderera',
    42 => 'Datumformat',
    43 => 'Maximalt antal artiklar',
    44 => 'Inga block',
    45 => 'Artikelinställningar för',
    46 => 'Exkluderade saker för',
    47 => 'Konfiguration av nyhetsblock för',
    48 => 'Ämnen',
    49 => 'Inga ikoner i artiklar',
    50 => 'Klicka ur detta om du inte är intresserad',
    51 => 'Bara artiklarna',
    52 => 'Skönsvärdet är',
    53 => 'Skicka mig dagens artiklar varje kväll',
    54 => 'Klicka i boxarna för de ämnen och författare vars artiklar du inte vill se.',
    55 => 'Om du lämnar dessa tomma betyder det att du vill ha standarduppsättningen med boxar.  Om du börjar välja så måste du välja alla de som du vill se, eftersom standardvalet därmed försvinner.  Standardboxarna är markerade med fetstil.',
    56 => 'Författare',
    57 => 'Visningsläge',
    58 => 'Sorteringsordning',
    59 => 'Kommentarsbegränsning',
    60 => 'Hur vill du att kommentarer ska visas?',
    61 => 'Nyaste eller äldsta först?',
    62 => 'Standardvärdet är 100',
    63 => "Ditt lösenord är nu epostat till dig och det bör anlända inom kort.  Vänligen följ instruktionerna däri.  Tack för att du använder {$_CONF['site_name']}",
    64 => 'Kommentarsinställningar för',
    65 => 'Försök att logga in igen',
    66 => "Det är möjligt att du har skrivit fel.  Försök logga in igen.  Är du en <a href=\"{$_CONF['site_url']}/users.php?mode=new\">ny användare</a>?",
    67 => 'Medlem sedan',
    68 => 'Kom ihåg mig i',
    69 => 'Hur länge ska vi komma ihåg dig från det att du loggar in?',
    70 => "Personliga inställningar för utseende och innehåll av {$_CONF['site_name']}",
    71 => "En av de bästa funktionerna i {$_CONF['site_name']} är att du kan göra personliga inställningar för det innehåll du vill se och du kan förändra utseendet på sajten.  För att ta tillvara på dessa funktioner måste du först <a href=\"{$_CONF['site_url']}/users.php?mode=new\">registrera</a> med {$_CONF['site_name']}.  Redan medlem?  Använd i så fall inloggningsrutan till vänster för att logga in!",
    72 => 'Utseende',
    73 => 'Språk',
    74 => 'Förändra sajtens utseende!',
    75 => 'Epostade ämnen för',
    76 => 'Om du väljer ett ämne från listan nedan så kommer du att få alla nya artiklar från det ämnet mailat till dig varje kväll.  Välj bara de ämnen som intresserar dig!',
    77 => 'Foto',
    78 => 'Lägg till ett fotografi på dig själv!',
    79 => 'Klicka i här för att radera denna bild',
    80 => 'Logga in',
    81 => 'Skicka epost',
    82 => 'Senaste tio artiklar för användare',
    83 => 'Kommentarsstatistik för användare',
    84 => 'Totalt antal artiklar:',
    85 => 'Totalt antal kommentarer:',
    86 => 'Finn alla inlägg av',
    87 => 'Ditt användarnamn',
    88 => "Någon (kanske du) har begärt ett nytt lösenord för ditt konto \"%s\" på {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\nKlicka på följande länk om du verkligen vill nollställa ditt lösenord:\n\n",
    89 => "Om du inte vill göra detta så är det bara att ignorera detta mail (ditt lösenord kommer att vara oförändrat).\n\n",
    90 => 'Ange ett nytt lösenord för ditt konto.  Märk att ditt gamla lösenord är giltigt tills du skickat in detta formulär.',
    91 => 'Sätt nytt lösenord',
    92 => 'Ange nytt lösenord',
    93 => 'Din senaste lösenordsbegäran var för %d sekunder sedan.  Denna sajt kräver minst %d sekunder mellan lösenordsförfrågningar.',
    94 => 'Radera konto "%s"',
    95 => 'Klicka på "radera konto" knappen nedan för att radera ditt konto från vår databas. Notera att alla artiklar och kommentarer du postat från detta konto inte kommer att raderas, utan kommer istället att tillskrivas användaren "Anonymous".',
    96 => 'radera konto',
    97 => 'Bekräfta kontoradering',
    98 => 'Är du säker på att du vill radera ditt konto?  Genom att radera ditt konto så kommer du inte längre att kunna logga in på denna sajt (såvida du inte först skapar ett nytt konto).  Klicka på "radera konto" i formuläret nedan för att bekräfta.',
    99 => 'Sekretessinställningar för',
    100 => 'Epost från Admin',
    101 => 'Tillåt epost från sajtadministratörer',
    102 => 'Epost från användare',
    103 => 'Tillåt epost från andra användare',
    104 => 'Visa online-status',
    105 => 'Jag vill synas i \'Vem är här\'-blocket',
    106 => 'Plats',
    107 => 'Visas i din publika profil',
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
    123 => "Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?"
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Det finns inga nyheter',
    2 => 'Det finns inga artiklar att visa.  Antingen finns det inga artiklar, eller så är dina artikelinställningar för restriktiva.',
    3 => ' i ämnet %s',
    4 => 'Dagens huvudartikel',
    5 => 'Nästa',
    6 => 'Föregående',
    7 => 'Första',
    8 => 'Sista'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Det blev alldeles fel när vi skulle skicka ditt meddelande.  Försök igen.',
    2 => 'Meddelande skickat.',
    3 => 'Verifiera att det står en riktig epostadress i svarsfältet.',
    4 => 'Fyll i namn-, svarsadress-, ärende- och meddelandefältet',
    5 => 'Error: Användare existerar inte.',
    6 => 'Nu blev det fel.',
    7 => 'Användarprofil för',
    8 => 'Användarnamn',
    9 => 'Användarlänk',
    10 => 'Skicka mail till',
    11 => 'Ditt namn:',
    12 => 'Svarsadress:',
    13 => 'Ärende:',
    14 => 'Meddelande:',
    15 => 'HTML kommer inte att översättas.',
    16 => 'Skicka meddelande',
    17 => 'Eposta artikel till någon',
    18 => 'Till namn',
    19 => 'Till epostadress',
    20 => 'Från namn',
    21 => 'Från epostadress',
    22 => 'Alla fält måste fyllas i',
    23 => "Detta brev har skickats till dig från %s (%s) för att de trodde att du kunde vara intresserad av denna artikel från {$_CONF['site_url']}.  Detta är inte SPAM  och epostadresserna inblandade i detta har inte sparats.",
    24 => 'Kommentera denna artikel på',
    25 => 'För att använda denna funktion måste du vara inloggad.  Genom att kräva inloggning förhindrar vi missbruk av detta system',
    26 => 'Detta formulär låter dig sända epost till den valda användare.  Alla fält måste fyllas i.',
    27 => 'Kort meddelande',
    28 => '%s skrev: ',
    29 => "Detta är den dagliga sammanställningen från {$_CONF['site_name']} för ",
    30 => ' Dagligt nyhetsbrev för ',
    31 => 'Titel',
    32 => 'Datum',
    33 => 'Läs hela artikeln på',
    34 => 'Slut på meddelandet',
    35 => 'Beklagar, men denna användare vill inte ta emot någon epost.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Detaljerad sökning',
    2 => 'Nyckelord',
    3 => 'Ämne',
    4 => 'Samtliga',
    5 => 'Typ',
    6 => 'Artiklar',
    7 => 'Kommentarer',
    8 => 'Författare',
    9 => 'Samtliga',
    10 => 'Sök',
    11 => 'Sökresultat',
    12 => 'träffar',
    13 => 'Sökresultat:  inga träffar',
    14 => 'Det fanns inga träffar för din sökning på',
    15 => 'Försök igen.',
    16 => 'Titel',
    17 => 'Datum',
    18 => 'Författare',
    19 => "Sök igenom {$_CONF['site_name']} kompletta databas med nuvarande äldre artiklar",
    20 => 'Datum',
    21 => 'till',
    22 => '(Datumformat ÅÅÅÅ-MM-DD)',
    23 => 'Visningar',
    24 => 'Fann %d post(er)',
    25 => 'Sökte efter',
    26 => 'post(er) ',
    27 => 'sekunder',
    28 => 'Ingen artikel eller kommentar matchar din sökning',
    29 => 'Artikel- och kommentarsresultat',
    30 => 'Inga länkar matchade din sökning',
    31 => 'Denna insticksmodul gav inga träffar',
    32 => 'Aktivitet',
    33 => 'Länk',
    34 => 'Plats',
    35 => 'Hela dagen',
    36 => 'Inga aktiviteter matchade din sökning',
    37 => 'Aktivitetsresultat',
    38 => 'Länkresultat',
    39 => 'Länkar',
    40 => 'Aktiviteter',
    41 => 'Du måste söka på minst tre tecken..',
    42 => 'Du måste använda datumformatet ÅÅÅÅ-MM-DD (år-månad-dag).',
    43 => 'exakt fras',
    44 => 'alla dessa ord',
    45 => 'något av dessa ord',
    46 => 'Nästa',
    47 => 'Föregående',
    48 => 'Författare',
    49 => 'Datum',
    50 => 'Träffar',
    51 => 'Länk',
    52 => 'Plats',
    53 => 'Artikelresultat',
    54 => 'Kommentarsresultat',
    55 => 'frasen',
    56 => 'OCH',
    57 => 'ELLER',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Sajtstatistik',
    2 => 'Totalt antal träffar på sajten',
    3 => 'Artiklar(kommentarer) på sajten',
    4 => 'Omröstningar(svar) på sajten',
    5 => 'Länkar(träffar) på sajten',
    6 => 'Aktiviteter i sajtkalendern',
    7 => 'De tio mest lästa artiklarna',
    8 => 'Artikeltitel',
    9 => 'Visningar',
    10 => 'Det verkar inte finnas några artiklar på den här sajten, eller så har ingen av dom blivit lästa.',
    11 => 'De tio mest kommenterade artiklarna',
    12 => 'Kommentarer',
    13 => 'Det verkar inte finnas några artiklar på den här sajten, eller så har ingen av dom blivit kommenterade.',
    14 => 'De tio största omröstningarna',
    15 => 'Omröstningsfråga',
    16 => 'Röster',
    17 => 'Det verkar inte finnas några omröstningar på den här sajten, eller så har ingen röstat.',
    18 => 'Tio populäraste länkarna',
    19 => 'Länkar',
    20 => 'Träffar',
    21 => 'Det verkar inte finnas några länkar på sajten, eller så har ingen av dom blivit klickade.',
    22 => 'De tio mest epostade artiklarna',
    23 => 'gånger',
    24 => 'Det verkar inte som om någon har epostat någon artikel från den här sajten',
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
    1 => 'Besläktad info',
    2 => 'Eposta artikel till någon',
    3 => 'Skriv ut artikel',
    4 => 'Artikelalternativ',
    5 => 'Artikel i PDF-format'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'Man måste vara inloggad för att skicka in en %s.',
    2 => 'Logga in',
    3 => 'Ny användare',
    4 => 'Skicka in en aktivitet',
    5 => 'Skicka in en länk',
    6 => 'Skicka in en artikel',
    7 => 'Inloggning krävs',
    8 => 'Skicka',
    9 => "När du skriver en artikel till den här sajten så är det bra om du följer dessa råd: <UL><LI>Samtliga fält måste fyllas i<LI>Informationen ska vara korrekt<LI>Kontrollera alla länkar en extra gång</UL>\n",
    10 => 'Titel',
    11 => 'Länk',
    12 => 'Startdatum',
    13 => 'Slutdatum',
    14 => 'Plats',
    15 => 'Beskrivning',
    16 => 'Om "Annan", specificera',
    17 => 'Kategori',
    18 => 'Annan',
    19 => 'Läs först',
    20 => 'Error: Kategori saknas',
    21 => 'Du måste ange en ny kategori när du väljer "Annan"',
    22 => 'Error: Fält saknas',
    23 => 'Fyll i samtliga fält i formuläret.',
    24 => 'Sparad',
    25 => '%s har sparats.',
    26 => 'Hastighetsbegränsning',
    27 => 'Användarnamn',
    28 => 'Ämne',
    29 => 'Artikel',
    30 => 'Du skickade in en artikel för ',
    31 => " sekunder sedan.  Du måste vänta minst {$_CONF['speedlimit']} sekunder mellan artiklar",
    32 => 'Förhandsgranska',
    33 => 'Förhandsgranska artikel',
    34 => 'Logga ut',
    35 => 'HTML-taggar är inte tillåtna',
    36 => 'Artikeltyp',
    37 => "När du skickar en aktivitet till {$_CONF['site_name']} så hamnar den i den centrala kalendern. Denna funktion är inte till för att lagra personlig information som födelsedagar eller namnsdagar.<BR><BR>När du sänder aktiviteten så skickas den till en administratör som, om den blir godkänd, lägger upp den på den centrala kalendern.",
    38 => 'Lägg aktivitet till',
    39 => 'Central kalender',
    40 => 'Personlig kalender',
    41 => 'Sluttid',
    42 => 'Starttid',
    43 => 'Heldagsaktivitet',
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
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Autentisering krävs',
    2 => 'Felaktig inloggningsinformation',
    3 => 'Felaktigt lösenord för användare',
    4 => 'Användarnamn:',
    5 => 'Lösenord:',
    6 => 'All tillgång till administrativa delar av denna webbsajt loggas och kontrolleras.<br />Denna sida är bara till för behörig personal.',
    7 => 'logga in'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Otillräckliga aministratörsrättigheter',
    2 => 'Du har inte tillräckliga rättigheter för att redigera detta block.',
    3 => 'Blockeditor',
    4 => 'There was a problem reading this feed (see error.log for details).',
    5 => 'Blocktitel',
    6 => 'Ämne',
    7 => 'Samtliga',
    8 => 'Block säkerhetsnivå',
    9 => 'Blockordning',
    10 => 'Blocktyp',
    11 => 'Portalblock',
    12 => 'Normalt block',
    13 => 'Portalblocksinställningar',
    14 => 'RDF-länk',
    15 => 'Senaste RDF-uppdatering',
    16 => 'Normalblocksinställningar',
    17 => 'Blockinnehåll',
    18 => 'Ange Blocktitel, säkerhetsnivå och innehåll',
    19 => 'Blockadministratör',
    20 => 'Blocktitel',
    21 => 'Blocksäk.nivå',
    22 => 'Blocktyp',
    23 => 'Blockordning',
    24 => 'Blockämne',
    25 => 'Klicka på ett block nedan för att förändra eller radera det.  Klicka på "Nytt block" ovan för att skapa ett nytt block.',
    26 => 'Layoutblock',
    27 => 'PHP-block',
    28 => 'PHP-blockinställningar',
    29 => 'Blockfunktion',
    30 => 'Om du vill använda PHP-kod i ditt block, ange namnet på funktionen ovan.  Din funktion måste börja med prefixet "phpblock_" (t.ex. phpblock_getweather).  Om det inte har detta prefix kommer funktionen inte att kallas.  Detta görs för att förhindra personer som eventuellt har hackat din Geeklog-installation från att exekvera godtycklig kod som kan skada ditt system.  Sätt inte tomma parenteser "()" efter ditt funktionsnamn.  Slutligen rekommenderas du att lägga alla dina PHP-block i /path/to/geeklog/system/lib-custom.php.  Då kommer koden att vara kvar även när du uppdaterar till en ny version av GeekLog.',
    31 => 'Fel i PHP-block.  Funktionen \"%s\" existerar inte.',
    32 => 'Fel: Fält saknas',
    33 => 'Du måste ange länken till .rdf-filen för portalblock',
    34 => 'Du måste ange titel och funktion av PHP-block',
    35 => 'Du måste ange titel och innehåll för normala block',
    36 => 'Du måste ange innehåll för layout-block',
    37 => 'Felaktigt funktionsnamn i PHP-blocket',
    38 => 'Funktioner för PHP-block måste ha prefixet \'phpblock_\' (ex. phpblock_getweather).  Detta är en säkerhetsfunktion som förhindrar eventuella crackare att exekvera godtycklig kod på din server.',
    39 => 'Sida',
    40 => 'Vänster',
    41 => 'Höger',
    42 => 'Du måste ange blockordning och säkerhetsnivå för Geeklog:s standardblock',
    43 => 'Endast hemsidan',
    44 => 'Åtkomst nekad',
    45 => "Du äger inte tillgång till detta block.  Denna incident har loggats.  Gå tillbaka till <a href=\"{$_CONF['site_admin_url']}/block.php\">blockadministrationen</a>.",
    46 => 'Nytt block',
    47 => 'Administratörsmeny',
    48 => 'Blocknamn',
    49 => ' (inga mellanslag och namnet måste vara unikt)',
    50 => 'Hjälplänk',
    51 => 'inkludera http://',
    52 => 'Om detta fält lämnas tomt så kommer inte hjälpikonen för detta block att visas',
    53 => 'Aktiverad',
    54 => 'spara',
    55 => 'ångra',
    56 => 'radera',
    57 => 'Flytta block neråt',
    58 => 'Flytta block uppåt',
    59 => 'Flytta block till höger sida',
    60 => 'Flytta block till vänster sida',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Aktivitetseditor',
    2 => 'Error',
    3 => 'Aktivitet',
    4 => 'Aktivitetslänk',
    5 => 'Startdatum för aktivitet',
    6 => 'Slutdatum för aktivitet',
    7 => 'Plats',
    8 => 'Aktivitetsbeskrivning',
    9 => '(inkludera http://)',
    10 => 'Du måste ange datum/tider, aktivitetstitel och beskrivning!',
    11 => 'Aktivitetsadministratör',
    12 => 'Klicka på en aktivitet för att förändra eller radera den.  Klicka på "Ny aktivitet" ovan för att skapa en ny aktivitet.  Klicka på [C] för att kopiera en aktivitet.',
    13 => 'Aktivitet',
    14 => 'Startdatum',
    15 => 'Slutdatum',
    16 => 'Åtkomst nekad',
    17 => "Du äger inte tillgång till denna aktivitet.  Denna incident har loggats.  Gå tillbaka till <a href=\"{$_CONF['site_admin_url']}/event.php\">aktivitetsadministrationen</a>.",
    18 => 'Ny aktivitet',
    19 => 'Administratörsmeny',
    20 => 'spara',
    21 => 'ångra',
    22 => 'radera',
    23 => 'Felaktigt startdatum.',
    24 => 'Felaktigt slutdatum.',
    25 => 'Slutdatum är före startdatum, ju.'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Tidigare artiklar',
    2 => 'Senare artiklar',
    3 => 'Läge',
    4 => 'Skrivläge',
    5 => 'Artikeleditor',
    6 => 'Det finns inga artiklar i systemet',
    7 => 'Författare',
    8 => 'spara',
    9 => 'förhandsgranska',
    10 => 'ångra',
    11 => 'radera',
    12 => 'ID',
    13 => 'Titel',
    14 => 'Ämne',
    15 => 'Datum',
    16 => 'Ingress',
    17 => 'Brödtext',
    18 => 'Träffar',
    19 => 'Kommentarer',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => 'Artikellista',
    23 => 'Klicka på en artikels nummer nedan för att redigera eller radera den.  Klicka på en artikels titel för att läsa den artikeln.  Klicka på "ny artikel" ovan för att skriva en ny artikel.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => 'Error when saving story',
    26 => 'Förhandsgranska artikel',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => 'Uppladdningsfel',
    31 => 'Du måste ange titel och ingress',
    32 => 'Huvudartikel',
    33 => 'Det kan bara finnas en huvudartikel',
    34 => 'Utkast',
    35 => 'Ja',
    36 => 'Nej',
    37 => 'Mer av',
    38 => 'Mer från',
    39 => 'Epost',
    40 => 'Åtkomst nekad',
    41 => "Du äger inte åtkomst till denna artikel.  Denna incident har loggats.  Du kan läsa artikeln nedan.  Gå tillbaka till <a href=\"{$_CONF['site_admin_url']}/story.php\">artikeladministrationen</a> när du är klar.",
    42 => "Du äger inte åtkomst till denna artikel.  Denna incident har loggats.  Gå tillbaka till <a href=\"{$_CONF['site_admin_url']}/story.php\">artikeladministrationen</a>.",
    43 => 'Ny artikel',
    44 => 'Administratörsmeny',
    45 => 'Tillgång',
    46 => '<b>OBS:</b> om du anger ett framtida datum så kommer inte artikeln att publiceras förrän det datumet.  Det innebär också att artikeln inte kommer att synas i din RDF-export och inte heller i sök- eller statistiksidorna.',
    47 => 'Bilder',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => '<P>För att använda bilderna du bifogar här måste du lägga till specialtaggar i din artikel. Specialtaggarna är [imageX], [imageX_right] eller [imageX_left] där X är bildens nummer.  OBS: Du måste använda alla bilder du bifogar.  Om du inte gör det så kommer du inte kunna spara din artikel.</P><P><B>Förhandsgranskning</B>: För att förhandsgranska en artikel med bifogade bilder måste du lagra den som utkast istället för att använda "Förhandsgranskning".  Använd bara "Förhandsgranskning" när artikeln saknar bilder.</P>',
    52 => 'Radera',
    53 => 'användes inte.  Du måste inkludera denna bild i ingressen eller brödtexten innan du kan spara dina ändringar',
    54 => 'Bifogade bilder användes inte',
    55 => 'Det blev fel när din artikel skulle sparas.  Rätta till dessa fel innan du sparar',
    56 => 'Visa ämnesikon',
    57 => 'Visa oskalad bild',
    58 => 'Artikeladministration',
    59 => 'Val',
    60 => 'Aktiverat',
    61 => 'Automatisk arkivering',
    62 => 'Automatisk radering',
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
    75 => 'Full Featured'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Ämneseditor',
    2 => 'Ämnes-ID',
    3 => 'Ämnesnamn',
    4 => 'Ämnesikon',
    5 => '(använd inte mellanslag)',
    6 => 'Om man raderar ett ämne så raderas alla artiklar och block som är associerade med detta ämne',
    7 => 'Ange ämnes-ID och ämnesnamn',
    8 => 'Ämnesadministratör',
    9 => 'Klicka på ett ämne för att redigera eller radera det ämnet.  Klicka på "Nytt ämne" ovan för att skapa ett nytt ämne.  Dina accessrättigheter står inom parentes.  Asterisken (*) anger standardvärdet.',
    10 => 'Sorteringsordning',
    11 => 'Artiklar/sida',
    12 => 'Åtkomst nekad',
    13 => "Du äger inte tillgång till detta ämne.  Denna incident har loggats.  Gå tillbaka till <a href=\"{$_CONF['site_admin_url']}/topic.php\">ämnesadministrationen</a>.",
    14 => 'Sorteringsmetod',
    15 => 'alfabetisk',
    16 => 'standardvärdet är',
    17 => 'Nytt ämne',
    18 => 'Administratörsmeny',
    19 => 'spara',
    20 => 'ångra',
    21 => 'radera',
    22 => 'skönsvärde',
    23 => 'Gör detta ämne till standardvärde för nya artiklar',
    24 => '(*)',
    25 => 'Arkivera ämne',
    26 => 'gör detta ämne till skönsvärde för alla arkiverade artiklar.  Bara ett ämne tillåts.',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'Användareditor',
    2 => 'Användar-ID',
    3 => 'Användarnamn',
    4 => 'För- och efternamn',
    5 => 'Lösenord',
    6 => 'Säkerhetsnivå',
    7 => 'Epostadress',
    8 => 'Hemsida',
    9 => '(använd inte mellanslag)',
    10 => 'Du måste ange användarnamn och epostadress',
    11 => 'Användaradministratör',
    12 => 'Klicka på en användare för att redigera eller radera den.  Klicka på "Ny användare" ovan för att skapa en ny användare.  Du kan genomföra enkla sökningar genom att ange delar av ett användarnamn, epostadress eller för- eller efternamn i sökformuläret nedan.',
    13 => 'Säknivå',
    14 => 'Reg.datum',
    15 => 'Ny användare',
    16 => 'Administratörsmeny',
    17 => 'byt lösenord',
    18 => 'ångra',
    19 => 'radera',
    20 => 'spara',
    21 => 'Det användarnamnet existerar redan.',
    22 => 'Fel',
    23 => 'Lägg till i klump',
    24 => 'Klumpimportering av användare',
    25 => 'Du kan importera en klump användare till Geeklog.  Importfilen måste vara en tab-separerad textfil innehållande följande fält: för- och efternamn, användarnamn epostadress.  Varje användare du importerar kommer att få ett slumpmässigt lösenord via epost.  Du måste ange en användare per rad.  Om du inte följer dessa instruktioner så kan det bli strul som bara kan rättas till manuellt.  Var med andra ord mycket noggrann!',
    26 => 'Sök',
    27 => 'Begränsa träffar',
    28 => 'Klicka här för att radera denna bild',
    29 => 'Sökväg',
    30 => 'Importera',
    31 => 'Nya användare',
    32 => 'Klart!  Import klar av %d användare.  %d misslyckades',
    33 => 'skicka',
    34 => 'Fel:  Du måste ange en fil att skicka.',
    35 => 'Senaste inloggning',
    36 => '(aldrig)',
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
    47 => 'Edit'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Godkänn',
    2 => 'Radera',
    3 => 'Redigera',
    4 => 'Profil',
    10 => 'Titel',
    11 => 'Startdatum',
    12 => 'Länk',
    13 => 'Kategori',
    14 => 'Datum',
    15 => 'Ämne',
    16 => 'Användarnamn',
    17 => 'För- och efternamn',
    18 => 'Epost',
    34 => 'Kontrollpanel',
    35 => 'Nya artiklar',
    36 => 'Nya länkar',
    37 => 'Nya aktiviteter',
    38 => 'Skicka',
    39 => 'För tillfället finns det inga bidrag att ta ställning till',
    40 => 'Nya användare'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'söndag',
    2 => 'måndag',
    3 => 'tisdag',
    4 => 'onsdag',
    5 => 'torsdag',
    6 => 'fredag',
    7 => 'lördag',
    8 => 'Ny aktivitet',
    9 => '%s-aktivitet',
    10 => 'Aktiviteter för',
    11 => 'Huvudkalender',
    12 => 'Min kalender',
    13 => 'januari',
    14 => 'februari',
    15 => 'mars',
    16 => 'april',
    17 => 'maj',
    18 => 'juni',
    19 => 'juli',
    20 => 'augusti',
    21 => 'september',
    22 => 'oktober',
    23 => 'november',
    24 => 'december',
    25 => 'Tillbaka till ',
    26 => 'Hela dagen',
    27 => 'Vecka',
    28 => 'Personlig kalender för',
    29 => 'Publik kalender',
    30 => 'radera aktivitet',
    31 => 'Lägg till',
    32 => 'Aktivitet',
    33 => 'Datum',
    34 => 'Tid',
    35 => 'Snabbokning',
    36 => 'Godkänn',
    37 => 'Den personliga kalendern är inte aktiverad på denna sajt.',
    38 => 'Personlig aktivitetseditor',
    39 => 'Dag',
    40 => 'Vecka',
    41 => 'Månad'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Mail Utility",
    2 => 'Från',
    3 => 'Svar till',
    4 => 'Ärende',
    5 => 'Innehåll',
    6 => 'Skicka till:',
    7 => 'Alla användare',
    8 => 'Administratör',
    9 => 'Inställningar',
    10 => 'HTML',
    11 => 'Viktigt meddelande!',
    12 => 'Skicka',
    13 => 'Reset',
    14 => 'Ignorera användarinställningar',
    15 => 'Fel vid epostande till: ',
    16 => 'Skickade epost till: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Skicka ytterligare epost</a>",
    18 => 'Till',
    19 => 'OBS: Välj "Inloggade användare" från rullgardinsmenyn för att skicka epost till samtliga sajtmedlemmar.',
    20 => "Skickade <successcount> meddelanden och misslyckades att skicka <failcount> stycken.  Om du är intresserad så finns detaljerna för varje meddelande nedan.  Annars kan du <a href=\"{$_CONF['site_admin_url']}/mail.php\">sända ytterligare epost</a> eller gå tillbaka till <a href=\"{$_CONF['site_admin_url']}/moderation.php\">administratörsmenyn</a>.",
    21 => 'Misslyckad sändning',
    22 => 'Lyckad sändning',
    23 => 'Inga misslyckanden',
    24 => 'Inga meddelande sända',
    25 => '-- Välj grupp --',
    26 => 'Ange alla fält i formuläret och välj en grupp från rullgardinsmenyn.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Att installera en insticksmodul kan skada din Geeklog-installation och möjligtvis även ditt system.  Det är viktigt att du bara installerar instickmoduler som du laddat hem från <a href="http://www.geeklog.net" target="_blank">Geeklog:s hemsida</a> eftersom vi testar alla våra insticksmoduler på ett flertal operativsystem.  Det är viktigt att du förstår att installationsprocessen kräver att ett fåtal filsystemskommandon kommer att exekveras.  Detta <EM>kan</EM> leda till säkerhetsproblem -- särskilt om insticksmodulen kommer från en tredje part.  Trots denna varning kan vi inte garantera någon installation.  Vi kan inte heller hållas skadeståndsskyldiga för eventuell skada som installationen av insticksmodulen kan orsaka.  Med andra ord: installera på egen risk!  För den försiktige finns det manuella installationsinstruktioner med varje insticksmodul.',
    2 => 'Insticksmodul installationsvarning',
    3 => 'Insticksmodul installationsformulär',
    4 => 'Insticksmodulsfil',
    5 => 'Insticksmodulslista',
    6 => 'Varning:  insticksmodul redan installerad!',
    7 => 'Insticksmodulen du försöker installera existerar redan.  Radera insticksmodulen innan du försöker installera den igen',
    8 => 'Kompatibilitetstest för insticksmodul misslyckades',
    9 => 'Denna insticksmodul kräver en nyare version av Geeklog.  Du måste antingen uppgradera din <a href="http://www.geeklog.net">Geeklog-installation</a> eller hämta en nyare version av insticksmodulen.',
    10 => '<br><b>Inga insticksmoduler är installerade.</b><br><br>',
    11 => 'Klicka på insticksmodulens namn för att få information om den modulen, inklusive en länk till insticksmodulens webbsajt.  Både den installerade versionen och versionen som insticksmodulen själv rapporterar kommer att visas.  Detta hjälper dig att se om en insticksmodul behöver uppgraderas.  Läs insticksmodulens manual om du vill ha information om hur man installerar eller uppgraderar den.',
    12 => 'inget namn på insticksmodul skickades till plugineditor()',
    13 => 'Insticksmodulseditor',
    14 => 'Ny insticksmodul',
    15 => 'Administratörsmeny',
    16 => 'Namn på insticksmodul',
    17 => 'Version på insticksmodul',
    18 => 'Geeklog-version',
    19 => 'Aktiverad',
    20 => 'Ja',
    21 => 'Nej',
    22 => 'Installera',
    23 => 'Spara',
    24 => 'Ångra',
    25 => 'Radera',
    26 => 'Namn på insticksmodul',
    27 => 'Insticksmodulens hemsida',
    28 => 'Installerad version',
    29 => 'Geeklog-version',
    30 => 'Radera insticksmodul?',
    31 => 'Är du säker på att du vill radera denna insticksmodu?  Om du gör det så kommer du att radera alla filer, data, och datastrukturer som denna insticksmodul använder.  Om du är säker, klicka "radera" igen nedan.',
    32 => '<p><b>Error AutoLink märkord har inte korrekt format</b></p>',
    33 => 'Kodversion',
    34 => 'Uppdatera',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'skapa kanal',
    2 => 'spara',
    3 => 'radera',
    4 => 'avbryt',
    10 => 'Innehållsprenumeration',
    11 => 'Ny kanal',
    12 => 'Administratörsmeny',
    13 => 'För att ändra eller radera en kanal måste du klicka på dess länk nedan.  För att skapa en ny kanal så måste du klicka på "Ny kanal" ovan.',
    14 => 'Titel',
    15 => 'Typ',
    16 => 'Filnamn',
    17 => 'Format',
    18 => 'senast uppdaterad',
    19 => 'Aktiverad',
    20 => 'Ja',
    21 => 'Nej',
    22 => '<i>(inga kanaler)</i>',
    23 => 'alla artiklar',
    24 => 'Redigerar kanaler',
    25 => 'Kanaltitel',
    26 => 'Gräns',
    27 => 'Storlek på inlägg',
    28 => '(0 = ingen text, 1 = hela texten, annat = begränsat till angivet antal tecken.)',
    29 => 'Beskrivning',
    30 => 'Senaste uppdatering',
    31 => 'Teckenuppsättning',
    32 => 'Språk',
    33 => 'Innehåll',
    34 => 'Inlägg',
    35 => 'Timmar',
    36 => 'Kanaltyp',
    37 => 'Du har åtminstone en insticksmodul som stöder innehållskanaler.  Nedan måste du välja om du vill skapa en Geeklog-kanal eller en kanal från en av insticksmodulerna.',
    38 => 'Error: Fält saknas',
    39 => 'Fyll i Kanaltitel, beskrivning och filnamn.',
    40 => 'Fyll antingen i antal inlägg eller ett antal timmar.',
    41 => 'Länkar',
    42 => 'Aktiviteter',
    43 => 'All',
    44 => 'None',
    45 => 'Header-link in topic',
    46 => 'Limit Results',
    47 => 'Search',
    48 => 'Edit',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})"
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Ditt lösenord har epostats till dig och borde ankomma inom kort.  Följ instruktionerna i meddelandet.  Tack för att du använder {$_CONF['site_name']}",
    2 => "Tack för att du skickat din artikel till {$_CONF['site_name']}.  Den har nu skickats till vår personal för godkännande.  Om den godkänns så kommer din artikel att publiceras på vår sajt.",
    3 => "Tack för att du skickat en länk till {$_CONF['site_name']}.  Den har nu skickats till vår personal för godkännande.  Om den godkänns så kommer din länk att publiceras bland våra övriga <a href={$_CONF['site_url']}/links.php>internetlänkar</a>.",
    4 => "Tack för att du skickat en aktivitet till {$_CONF['site_name']}.  Den har nu skickats till vår personal för godkännande.  Om den godkänns så kommer din aktivitet att synas i vår <a href={$_CONF['site_url']}/calendar.php>kalender</a>.",
    5 => 'Din kontoinformation har lagrats.',
    6 => 'Dina artikelinställningar har lagrats.',
    7 => 'Dina kommentarsinställningar har lagrats.',
    8 => 'Du är nu utloggad.',
    9 => 'Artikel sparad.',
    10 => 'Artikel raderad.',
    11 => 'Ditt block har nu sparats.',
    12 => 'Blocket har raderats.',
    13 => 'Ditt ämne har nu sparats.',
    14 => 'Ämnet och alla dess artiklar och block har nu raderats.',
    15 => 'Din länk har nu sparats.',
    16 => 'Länken har raderats.',
    17 => 'Din aktivitet har sparats.',
    18 => 'Aktiviteten raderad.',
    19 => 'Din omröstning har nu sparats.',
    20 => 'Omröstningen raderad.',
    21 => 'Den nya användaren har nu sparats.',
    22 => 'Användaren har raderats',
    23 => 'Det blev fel när aktiviteten skulle sparast till din kalender.  Det saknas ett aktivitets-ID.',
    24 => 'Aktiviteten har sparats till din kalender',
    25 => 'Du måste vara inloggad för att komma åt din personliga kalender',
    26 => 'Aktiviteten raderad från din personliga kalender',
    27 => 'Meddelande skickat.',
    28 => 'Insticksmodulen har sparats',
    29 => 'Personliga kalendrar är inte aktiverade på denna sajt',
    30 => 'Åtkomst nekad',
    31 => 'Du äger inte tillgång till artikeladministrationen.  Denna incident har loggats.',
    32 => 'Du äger inte tillgång till ämnesadministrationen.  Denna incident har loggats.',
    33 => 'Du äger inte tillgång till blockadministrationen.  Denna incident har loggats.',
    34 => 'Du äger inte tillgång till länkadministrationen.  Denna incident har loggats.',
    35 => 'Du äger inte tillgång till aktivitetsadministrationen.  Denna incident har loggats.',
    36 => 'Du äger inte tillgång till omröstningsadministrationen.  Denna incident har loggats.',
    37 => 'Du äger inte tillgång till användaradministrationen.  Denna incident har loggats.',
    38 => 'Du äger inte tillgång till insticksmodulsadministrationen.  Denna incident har loggats.',
    39 => 'Du äger inte tillgång till epostadministrationen.  Denna incident har loggats.',
    40 => 'Systemmeddelande',
    41 => 'Du äger inte tillgång till ordbytesadministrationen.  Denna incident har loggats.',
    42 => 'Ditt ord har sparats.',
    43 => 'Ordet har raderats.',
    44 => 'Insticksmodulen installerad!',
    45 => 'Insticksmodulen raderad.',
    46 => 'Du äger inte tillgång till databasbackupsadministrationen.  Denna incident har loggats.',
    47 => 'Denna funktion fungerar bara på *nix.  Om du använder *nix som ditt operativsystem så har din buffert raderats.  Om du använder Windows så måste du söka efter filer som heter adodb_*.php och radera dom manuellt.',
    48 => "Tack för att du ansökt om medlemsskap i {$_CONF['site_name']}. Vårt team kommer att se över din ansökan och om den godkänns så kommer du att få ett lösenord via epost.",
    49 => 'Din grupp har sparats.',
    50 => 'Gruppen har raderats.',
    51 => 'Detta användarnamn används redan.  Välj ett annat.',
    52 => 'Den angivna epostadressen verkar inte vara giltig.',
    53 => 'Ditt nya lösenord är nu lagrat.  Använd ditt nya lösenord för att logga in nu.',
    54 => 'Tiden för din lösenordsbegäran har gått ut.  Försök igen nedan.',
    55 => 'Ett meddelande har nu skickats till dig via epost och borde anlända inom kort.  Följ instruktionerna i det meddelandet för att sätta ett nytt lösenord på ditt konto.',
    56 => 'Epostadressen du angivit används redan av ett annat konto.',
    57 => 'Ditt konto har raderats.',
    58 => 'Din kanal har lagrats.',
    59 => 'Kanalen har raderats.',
    60 => 'Insticksmodulen har uppdaterats',
    61 => 'Insticksmodul %s: Okänt meddelande',
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
    75 => 'Trackbacks must be sent using a POST request.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Rättigheter',
    'ownerroot' => 'Ägare/root',
    'group' => 'Grupp',
    'readonly' => 'Endast läs',
    'accessrights' => 'Rättigheter',
    'owner' => 'Ägare',
    'grantgrouplabel' => 'Ge ovanstående grupp redigeringsrättigheter',
    'permmsg' => 'OBS: "medlemmar" är alla inloggade sajtmedlemmar och "anonym" är alla användare som läser sajten utan att ha loggat in.',
    'securitygroups' => 'Säkerhetsgrupper',
    'editrootmsg' => "Trots att du är en användaradministratör så kan du inte ändra root-kontot utan att vara root själv.  Du kan ändra alla användare förutom root-användare.  Denna incident har loggats.  Gå tillbaka till <a href=\"{$_CONF['site_admin_url']}/user.php\">användaradministrationen</a>.",
    'securitygroupsmsg' => 'Kryssa i vilka grupper användare ska vara med i.',
    'groupeditor' => 'Gruppeditor',
    'description' => 'Beskrivning',
    'name' => 'Namn',
    'rights' => 'Rättigheter',
    'missingfields' => 'Fält saknas',
    'missingfieldsmsg' => 'Du måste ange ett namn och en beskrivning på gruppen',
    'groupmanager' => 'Gruppadministratör',
    'newgroupmsg' => 'Klicka på en grupp för att ändra eller radera den.  Klicka på "Ny grupp" ovan för att skapa en ny grupp.  Notera att kärngrupper inte kan raderas på grund av att de krävs för att systemet ska fungera.',
    'groupname' => 'Gruppnamn',
    'coregroup' => 'Kärngrupp',
    'yes' => 'Ja',
    'no' => 'Nej',
    'corerightsdescr' => 'Detta är en kärngrupp och dess rättigheter kan inte modifieras.  Nedan finns en lista över de rättigheter denna grupp har tillgång till.',
    'groupmsg' => 'Säkerhetsgrupper på denna sajt är hierarkiskt organiserade.  Genom att lägga denna grupp i någon annan grupp så kommer den att ärva de rättigheter de grupperna äger.  Där det är möjligt rekommenderas du använda de listade grupperna för att ge rättigheter till en grupp.  Om din grupp behöver skräddarsydda rättigheter så kan du välja vilka specifika sajtegenskaper du vill delegera via rutan nedan.  För att göra denna grupp till medlem av någon annan grupp så är det bara att markera vilken/vilka via kryssrutorna nedan.',
    'coregroupmsg' => 'Detta är en kärngrupp och de grupper som denna grupp tillhör kan inte modifieras.  Nedan finns en lista över vilka grupper denna grupp tillhör.',
    'rightsdescr' => 'De egenskaper en grupp äger kan antingen specificeras nedan eller genom att ge de egenskaperna till en grupp som den aktuella gruppen tillhör.  De egenskaper nedan som saknar kryssrutor är egenskaper som ärvts från någon av de grupper som den aktuella gruppen är med i.  De egenskaper som har kryssrutor kan delegeras direkt till denna grupp.',
    'lock' => 'Lås',
    'members' => 'Medlemmar',
    'anonymous' => 'Anonym',
    'permissions' => 'Rättigheter',
    'permissionskey' => 'R = läs, E = ändra, rättighet att ändra innebär automatiskt läsrättigheter',
    'edit' => 'Modifiera',
    'none' => 'Ingen',
    'accessdenied' => 'Åtkomst nekad',
    'storydenialmsg' => "Du äger inga rättigheter att läsa denna artikel.  Det kan bero på att du inte är medlem i {$_CONF['site_name']}.  Du kan <a href=users.php?mode=new>skapa ett konto</a> för att få tillgång till allt innehåll på sajten!",
    'eventdenialmsg' => "Du äger inga rättigheter att läsa denna aktivitet.  Det kan bero på att du inte är medlem i {$_CONF['site_name']}.  Du kan <a href=users.php?mode=new>skapa ett konto</a> för att få tillgång till allt innehåll på sajten!",
    'nogroupsforcoregroup' => 'Denna grupp är inte medlem i någon annan grupp',
    'grouphasnorights' => 'Denna grupp äger inte tillgång till några administrativa funktioner på denna sajt',
    'newgroup' => 'Ny grupp',
    'adminhome' => 'Administratörsmeny',
    'save' => 'spara',
    'cancel' => 'ångra',
    'delete' => 'radera',
    'canteditroot' => 'Du har försökt att modifiera Root-gruppen.  Detta har nekats på grund av att du själv inte är medlem i Root-gruppen.  Kontakta systemadministratören om du anser att detta är fel',
    'listusers' => 'Lista användare',
    'listthem' => 'lista',
    'usersingroup' => 'Användare i grupp %s',
    'usergroupadmin' => 'User Group Administration',
    'add' => 'Lägg till',
    'remove' => 'Radera',
    'availmembers' => 'Tillgängliga medlemmar',
    'groupmembers' => 'Gruppmedlemmar',
    'canteditgroup' => 'Du måste vara medlem i denna grupp för att få redigera den.  Kontakta din systemadministratör om du anser att detta meddelande är felaktigt.',
    'cantlistgroup' => 'Du måste vara medlem i denna grupp för att få se dess medlemmar.  Kontakta din systemadministratör om du anser att detta meddelande är felaktigt.',
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
    'last_ten_backups' => 'Senaste tio säkerhetskopiorna',
    'do_backup' => 'Starta säkerhetskopiering',
    'backup_successful' => 'Databasbackup genomförd.',
    'db_explanation' => 'Klicka nedan för att skapa en säkerhetskopia av ditt Geeklog-system',
    'not_found' => "Felaktig sökväg eller så är inte mysqldump-programmet exekverbart.<BR>Kontrollera <strong>\$_DB_mysqldump_path</strong>-definitionen i config.php.<BR>Variabeln är för närvarande definierad som: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Säkerhetskopiering misslyckades:  filstorleken är noll',
    'path_not_found' => "{$_CONF['backup_path']} existerar inte eller är inte en katalog",
    'no_access' => "FEL: Katalogen {$_CONF['backup_path']} är inte tillgänglig.",
    'backup_file' => 'Backupfil',
    'size' => 'Storlek',
    'bytes' => 'Byte',
    'total_number' => 'Totalt antal säkerhetskopior: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Aktuellt',
    2 => 'Kontaktinfo',
    3 => 'Skriv artikel',
    4 => 'Länkar',
    5 => 'Omröstningar',
    6 => 'Kalender',
    7 => 'Statistik',
    8 => 'Personliga inställningar',
    9 => 'Sök',
    10 => 'detaljerad sökning',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 Error',
    2 => 'Jösses,  jag har letat överallt, men jag kan inte hitta <b>%s</b>.',
    3 => "<p>Vi beklagar, men filen du söker existerar inte.  Leta gärna på vår <a href=\"{$_CONF['site_url']}\">förstasida</a> eller använd <a href=\"{$_CONF['site_url']}/search.php\">söksidan</a> för att försöka lokalisera det du söker."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Inloggning krävs',
    2 => 'För att komma åt denna sida så måste du vara inloggad.',
    3 => 'Logga in',
    4 => 'Ny användare'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'PDF-funktionen är avstängd',
    2 => 'Dokumentet kunde inte renderas.  Dokumentet kunde hämtas, men kunde inte renderas.  Var noga med att bara skicka in html-formatterade dokument som är skrivna enligt xHTML.  Notera att komplexa dokument kanske inte kan renderas korrekt, eller över huvud taget.  Ditt renderade dokumentet var 0 byte stort och har raderats.  Om du är övertygad om att ditt dokument borde kunna renderas, så bör du skicka in det igen.',
    3 => 'Okänt fel vid PDF-generering',
    4 => 'Inget siddata gavs, eller så vill du använda ad-hoc PDF-genereringsverktyget nedan.  Om du anser att du inte borde få detta felmeddelande så bör du kontakta systemadministratören.  Annars kan du prova att använda formuläret nedan för att generera PDF-filer med mer handpåläggning.',
    5 => 'Laddar ditt dokument.',
    6 => 'Vänta medan ditt dokument laddas.',
    7 => 'Du kan högerklicka på knappen nedan och välja \'spara mål...\' eller \'spara länk...\' för att spara en kopia av ditt dokument.',
    8 => 'Den angivna sökvägen till HTMLDoc-binären är felaktig, eller så kan det här systemet inte exekvera den.  Kontakta systemadministratören om detta fel kvarstår.',
    9 => 'PDF-generator',
    10 => 'Detta är Ad-hoc PDF-generering.  Verktyget kommer att försöka konvertera valfri URL till en PDF.  Tänk på att vissa sidor inte renderas ordentligt med den här funktionen, men detta är en begränsning av HTMLDoc PDF-genereringsverktyget, och dessa felmeddelanden bör inte rapporteras till systemadministratörerna på denna sajt',
    11 => 'URL',
    12 => 'Generera PDF!',
    13 => 'PHP-konfigurationen på den här servern tillåter inte öppning av URL:er med fopen()-kommandot.  Systemadministratören måste redigera php.ini-filen och aktivera allow_url_fopen',
    14 => 'PDF-filen du begärde existerar inte, eller så försökte du hämta en fil som du inte har tillgång till.'
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
    'pb_error_details' => 'Error when sending the pingback:'
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
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array(
    'search' => 'Search',
    'limit_results' => 'Limit Results',
    'submit' => 'Submit',
    'edit' => 'Edit',
    'admin_home' => 'Admin Home',
    'create_new' => 'Create New',
    'enabled' => 'Enabled',
    'title' => 'Title',
    'type' => 'Type',
    'topic' => 'Topic',
    'help_url' => 'Help File URL',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'copy' => 'Copy',
    'no_results' => '- No entries found -',
    'data_error' => 'There was an error processing the subscription data. Please check the data source.'
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