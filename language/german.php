<?php

###############################################################################
# german.php
#
# This is an *incomplete* german language file for GeekLog.
# Please contact Dirk Haun <dirk@haun-online.de> if you want to help
# in making it complete ...
#
# Credits from the original english.php file:
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
	1 => "Beitrag von:",
	2 => "(mehr)",
	3 => "Kommentar(e)",
	4 => "&Auml;ndern",
	5 => "Umfrage",
	6 => "Ergebnisse",
	7 => "Umfrage-Ergebnisse",
	8 => "Stimmen",
	9 => "Admin-Funktionen:",
	10 => "Beitr&auml;ge",
	11 => "Artikel",
	12 => "Bl&ouml;cke",
	13 => "Kategorien",
	14 => "Links",
	15 => "Termine",
	16 => "Umfragen",
	17 => "User",
	18 => "SQL-Query",
	19 => "Abmelden",
	20 => "User-Information:",
	21 => "Username",
	22 => "User-ID",
	23 => "Security Level",
	24 => "Anonymous",
	25 => "Antwort",
	26 => "Die folgenden Kommentare geben Meinungen von Lesern wieder und entsprechen nicht notwendigerweise der Meinung der Betreiber dieser Site. Die Betreiber behalten sich die L&ouml;schung von Kommentaren vor.",
	27 => "Letzter Beitrag",
	28 => "L&ouml;schen",
	29 => "Keine Kommentare.",
	30 => "&Auml;ltere Artikel",
	31 => "Erlaubte HTML-Tags:",
	32 => "Fehler: Ung&uuml;ltiger Username",
	33 => "Fehler: Konnte nicht ins Logfile schreiben",
	34 => "Fehler",
	35 => "Abmelden",
	36 => "um",
	37 => "",
	38 => "",
	39 => "Neuladen",
	40 => "",
	41 => "",
	42 => "Autor:",
	43 => "Antwort schreiben",
	44 => "vorherige",
	45 => "MySQL Fehlernummer",
	46 => "MySQL Fehlermeldung",
	47 => "User-Funktionen",
	48 => "Userprofil &auml;ndern",
	49 => "Anzeige-Einstellungen",
	50 => "Fehler im SQL-Befehl",
	51 => "Hilfe",
	52 => "Neu",
	53 => "Admin-Home",
	54 => "Konnte die Datei nicht &ouml;ffnen.",
	55 => "Fehler in",
	56 => "Abstimmen",
	57 => "Passwort",
	58 => "Login",
	59 => "Noch nicht registriert? Melde Dich jetzt als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">neuer User</a> an",
	60 => "Kommentar schreiben",
	61 => "Neuen Account anlegen",
	62 => "W&ouml;rter",
	63 => "Kommentar-Einstellungen",
	64 => "Artikel an einen Freund schicken",
	65 => "Druckf&auml;hige Version anzeigen",
	66 => "Mein Kalender",
	67 => "Willkommen bei ",
	68 => "Home",
	69 => "Kontakt",
	70 => "Suchen",
	71 => "Mitmachen",
	72 => "Links",
	73 => "Alte Umfragen",
	74 => "Kalender",
	75 => "Erweiterte Suche",
	76 => "Site-Statistik",
	77 => "Plugins",
	78 => "Anstehende Termine",
	79 => "Was ist neu",
	80 => "Artikel in den letzten",
	81 => "Artikel in den letzten",
	82 => "Stunden",
	83 => "KOMMENTARE",
	84 => "LINKS",
	85 => "der letzten 48 Stunden",
	86 => "Keine neuen Kommentare",
	87 => "der letzten 2 Wochen",
	88 => "Keine neuen Links",
	89 => "Es stehen keine Termine an",
	90 => "Home",
	91 => "Seite erzeugt in",
	92 => "Sekunden",
	93 => "Copyright",
	94 => "All trademarks and copyrights on this page are owned by their respective owners.",
	95 => "Powered By",
	96 => "Gruppen",
        97 => "Wortliste",
	98 => "Plug-ins",
	99 => "ARTIKEL",
    100 => "Keine neuen Artikel",
    101 => 'Meine Termine',
    102 => 'Allgemeine Termine',
    103 => 'DB Backups',
    104 => 'von',
    105 => 'Mail Users'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Terminkalender",
	2 => "Sorry, es gibt keine Termine anzuzeigen.",
	3 => "Wann",
	4 => "Wo",
	5 => "Beschreibung",
	6 => "Termin hinzuf&uuml;gen",
	7 => "Anstehende Termine",
	8 => 'Wenn Du diesen Termin zu Deinem Kalender hinzuf&uuml;gst, kannst Du Dir schneller einen &Uuml;berlick &uuml;ber die Termine verschaffen, die Dich interessieren, indem Du einfach auf "Mein Kalender" klickst.',
	9 => "Zu Meinem Kalender hinzuf&uuml;gen",
	10 => "Aus Meinem Kalender entfernen",
	11 => "Termin wird zum Kalender von {$_USER['username']} hinzugef&uuml;gt",
	12 => "Termin",
	13 => "Beginnt",
	14 => "Endet",
        15 => "Zur&uuml;ck zum Kalender"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Kommentar schreiben",
	2 => "Modus",
	3 => "Abmelden",
	4 => "Account anlegen",
	5 => "Username",
	6 => "Um einen Kommentar abgeben zu k&ouml;nnen, musst Du angemeldet sein. Wenn Du noch keinen Account hast, benutze bitte das Formular um einen anzulegen.",
	7 => "Dein letzter Kommentar war vor ",
	8 => " Sekunden. Zwischen zwei Kommentaren m&uuml;ssen aber mindestens {$_CONF["commentspeedlimit"]} Sekunden vergangen sein",
	9 => "Kommentar",
	10 => '',
	11 => "Kommentar abschicken",
	12 => "Bitte f&uuml;lle die folgenden Felder aus, um einen Kommentar abzugeben: Name, E-Mail, Betreff und Kommentar.",
	13 => "Deine Information",
	14 => "Vorschau",
	15 => "",
	16 => "Betreff",
	17 => "Fehler",
	18 => 'Wichtige Hinweise:',
	19 => 'Bitte gib nur Kommentare ab, die zum Thema geh&ouml;ren.',
	20 => 'Beziehe Dich m&ouml;glichst auf Kommentare anderer Personen statt einen neuen Thread zu er&ouml;ffnen.',
	21 => 'Lies bitte die vorhandenen Kommentare bevor Du Deinen eigenen abgibst, um nicht noch einmal zu schreiben, was schon gesagt wurde.',
	22 => 'Benutze eine eindeutige Betreffzeile, die den Inhalt Deines Kommentars zusammenfasst.',
	23 => 'Deine E-Mail-Adresse wird NICHT ver&ouml;ffentlicht.',
	24 => 'Anonymer User'
);

###############################################################################
# users.php

$LANG04 = array(
	1 => "Userprofil f&uuml;r",
	2 => "Username",
	3 => "Name",
	4 => "Passwort",
	5 => "E-Mail",
	6 => "Homepage",
	7 => "Bio",
	8 => "PGP-Key",
	9 => "Speichern",
	10 => "Die letzten 10 Kommentare von",
	11 => "Keine Kommentare",
	12 => "User-Einstellungen f&uuml;r",
	13 => "E-Mail Nightly Digest",
	14 => "Dieses Passwort wurde mit einem Zufallsgenerator erzeugt. Es wird empfohlen, das Passwort nach dem Anmelden sofort zu aendern. Um Dein Passwort zu aendern, melde Dich bitte an und waehle dann den Punkt Userprofil aendern im User Block.",
	15 => "Dein Account fuer {$_CONF["site_name"]} wurde erfolgreich angelegt. Um ihn benutzen zu koennen, melde Dich bitte mit den folgenden Informationen an. Diese E-Mail bitte aufheben.",
	16 => "Deine Zugangsdaten",
	17 => "Account existiert nicht",
	18 => "Die angegebene E-Mail-Adresse scheint keine g&uuml;ltige E-Mail-Adresse zu sein",
	19 => "Dieser Username oder diese E-Mail-Adresse existieren bereits.",
	20 => "Die angegebene E-Mail-Adresse scheint keine g&uuml;ltige E-Mail-Adresse zu sein",
	21 => "Fehler",
	22 => "Anmelden bei {$_CONF['site_name']}!",
	23 => "Indem Du Dich bei {$_CONF['site_name']} anmeldest, kannst Du Artikel und Kommentare unter Deinem eigenen Namen ver&ouml;ffentlichen (andernfalls geht das nur anonym). &Uuml;brigens wird Deine E-Mail-Adresse <strong><em>niemals</em></strong> auf dieser Website angezeigt werden.",
	24 => "Dein Passwort wird Dir an die angegebene E-Mail-Adresse geschickt.",
	25 => "Passwort vergessen?",
	26 => "Gib Deinen Usernamen ein und klicke auf Passwort schicken. Ein neues Passwort wird dann an die gespeicherte E-Mail-Adresse geschickt.",
	27 => "Jetzt anmelden!",
	28 => "Passwort schicken",
	29 => "logged out from",
	30 => "logged in from",
	31 => "Um diese Funktion nutzen zu k&ouml;nnen, musst Du angemeldet sein",
	32 => "Signatur",
	33 => "Auf der Site nicht sichtbar!",
	34 => "Dein richtiger Name",
	35 => "Passwort eingeben, um es zu &auml;ndern",
	36 => "Beginnt mit http://",
	37 => "Wird an Deine Kommentare angef&uuml;gt",
	38 => "Alles &uuml;ber Dich - f&uuml;r alle sichtbar",
	39 => "Dein PGP-Key, wenn vorhanden",
	40 => "Kategorien ohne Icons",
	41 => "Bereit zu Moderieren",
	42 => "Datumsformat",
	43 => "Max. Anzahl Artikel",
	44 => "Keine Bl&ouml;cke",
	45 => "Anzeige-Einstellungen f&uuml;r",
	46 => "Nicht anzeigen f&uuml;r",
	47 => "Block-Einstellungen f&uuml;r",
	48 => "Kategorien",
	49 => "Keine Icons in Artikeln",
	50 => "H&auml;kchen entfernen, wenn es Dich nicht interessiert",
	51 => "Nur die Artikel",
	52 => "Defaultwert: 10",
	53 => "Receive the days stories every night",
	54 => "Themen und Autoren ankreuzen, die Du NICHT sehen willst.",
	55 => "Wenn Du hier nichts ankreuzt, wird die Default-Auswahl an Bl&ouml;cken angezeigt. Sobald Du anf&auml;ngst, Bl&ouml;cke anzukreuzen, werden auch nur noch diejenigen angezeigt, die angekreuzt sind! Die Default-Bl&ouml;cke sind <b>fett</b> markiert.",
	56 => "Autoren",
	57 => "Anzeigemodus",
	58 => "Sortierreihenfolge",
	59 => "Kommentarlimit",
	60 => "Wie sollen Kommentare angezeigt werden?",
	61 => "Neueste oder &auml;lteste zuerst?",
	62 => "Defaultwert: 100",
	63 => "Dein Passwort sollte in K&uuml;rze per E-Mail eintreffen. Bitte beachte die Hinweise in der E-Mail und Danke f&uuml;r Dein Interesse an " . $_CONF["site_name"],
	64 => "Kommentar-Einstellungen f&uuml;r",
	65 => "Bitte noch einmal versuchen, Dich anzumelden",
	66 => "Hast Du Dich vertippt? Bitte versuch noch einmal, Dich hier anzumelden. Oder m&ouml;chtest Du Dich als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">neuer User anmelden</a>?",
	67 => "Mitglied seit",
	68 => "Angemeldet f&uuml;r",
	69 => "Wie lange soll das System Dich nach dem Anmelden erkennen?",
	70 => "Aussehen und Inhalt von {$_CONF['site_name']} konfigurieren",
	71 => "One of the great features of {$_CONF['site_name']} is you can customize the content you get and you can change the overall layout of this site.  In order to take advantage of these great features you must first <a href=\"{$_CONF['site_url']}/users.php?mode=new\">register</a> with {$_CONF['site_name']}.  Are you already a member?  Then use the login form to the left to log in!",
    72 => "Erscheinungsbild",
    73 => "Sprache",
    74 => "&Auml;ndere das Aussehen dieser Site",
    75 => "Artikel per E-Mail f&uuml;r",
    76 => "W&auml;hle Kategorien aus der folgenden Liste und Du bekommst einmal pro Tag eine E-Mail mit einer &Uuml;bersicht aller neuen Artikel in den ausgew&auml;hlten Kategorien. Du brauchst nur die Kategorien anzukreuzen, die Dich interessieren."
);

###############################################################################
# index.php

$LANG05 = array(
	1 => "Keine Artikel",
	2 => "Es gibt keine Artikel, die angezeigt werden k&ouml;nnten. Entweder gibt es f&uuml;r diese Kategorie keine Artikel oder Deine Einstellungen sind zu restriktiv",
	3 => " f&uuml;r die Kategorie $topic.",
	4 => "Hauptartikel",
	5 => "N&auml;chster",
	6 => "Vorheriger"
);

###############################################################################
# links.php

$LANG06 = array(
	1 => "Links",
	2 => "Es gibt keine Links anzuzeigen.",
	3 => "Link hinzuf&uuml;gen"
);

###############################################################################
# pollbooth.php

$LANG07 = array(
	1 => "Stimme gespeichert",
	2 => "Deine Stimme wurde f&uuml;r die Umfrage gespeichert: ",
	3 => "Stimme",
	4 => "Umfragen im System",
	5 => "Stimme(n)"
);

###############################################################################
# profiles.php

$LANG08 = array(
	1 => "Es gab einen Fehler beim Versenden der Nachricht. Bitte noch einmal versuchen.",
	2 => "Nachricht wurde verschickt.",
	3 => "Bitte sicherstellen, dass Du eine g&uuml;ltige E-Mail-Adresse eingetragen hast.",
	4 => "Bitte alle Felder ausf&uuml;llen: Dein Name, Deine E-Mail, Betreff und Nachricht",
	5 => "Fehler: Username nicht bekannt.",
	6 => "Es ist ein Fehler aufgetreten.",
	7 => "Userprofil f&uuml;r",
	8 => "Username",
	9 => "User URL",
	10 => "Eine Mail schicken an",
	11 => "Dein Name:",
	12 => "Deine E-Mail:",
	13 => "Betreff:",
	14 => "Nachricht:",
	15 => "HTML wird nicht interpretiert.",
	16 => "Nachricht abschicken",
	17 => "Artikel an einen Freund schicken",
	18 => "An (Name)",
	19 => "An (E-Mail)",
	20 => "Von (Name)",
	21 => "Von (E-Mail)",
	22 => "Alle Felder m&uuml;ssen ausgef&uuml;llt werden.",
	23 => "Diese Nachricht wurde Ihnen von $from <$fromemail> geschickt, da er/sie der Meinung war, Sie wuerden sich vielleicht fuer diesen Artikel auf {$_CONF["site_url"]} interessieren. Dies ist kein SPAM und die beteiligten E-Mail-Adressen (Ihre und die des Absenders) werden nicht gespeichert oder wiederverwendet.\n",
	24 => "Schreiben Sie einen Kommentar zu diesem Artikel:\n",
	25 => "Die musst Dich anmelden, um diese Funktion benutzen zu k&ouml;nnen. Dies ist leider n&ouml;tig, um den Missbrauch des Systems zu verhindern",
	26 => "Mit diesem Formular kannst Du eine E-Mail an diesen User schicken. Alle Felder m&uuml;ssen ausgef&uuml;llt werden.",
	27 => "Kurze Nachricht",
	28 => "$from schrieb: $shortmsg",
    29 => "Dies sind die neuen Artikel auf {$_CONF['site_name']} vom ",
    30 => " - Neue Artikel vom ",
    31 => "Titel",
    32 => "Datum",
    33 => "Kompletter Artikel unter",
    34 => "Ende dieser Nachricht"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Erweiterte Suche",
	2 => "Suchbegriffe",
	3 => "Kategorie",
	4 => "Alle",
	5 => "Art",
	6 => "Artikel",
	7 => "Kommentare",
	8 => "Autoren",
	9 => "Alle",
	10 => "Suchen",
	11 => "Suchergebnisse",
	12 => "Treffer",
	13 => "Erweiterte Suche: Keine Treffer",
	14 => "Es gab keine Treffer f&uuml;r Deine Suche nach",
	15 => ". Bitte noch einmal versuchen.",
	16 => "Titel",
	17 => "Datum",
	18 => "Autor",
	19 => "Suchen in der kompletten Datenbank aus alten und neuen Artikeln auf {$_CONF["site_name"]}",
	20 => "Datum",
	21 => "bis",
	22 => "(Datumsformat: MM-TT-JJJJ)",
	23 => "Treffer",
	24 => "Gefunden:",
	25 => "Treffer aus",
	26 => "Beitr&auml;gen in",
	27 => "Sekunden.",
    28 => 'Keine Treffer unter den Artikeln und Kommentaren.',
    29 => 'Gefundene Artikel und Kommentare'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Site-Statistik",
	2 => "Gesamtzahl der Seitenabrufe",
	3 => "Artikel (Kommentare) im System",
	4 => "Umfragen (Stimmen) im System",
	5 => "Links (Klicks) im System",
	6 => "Termine im System",
	7 => "Top Ten der Artikel",
	8 => "Artikel-&Uuml;berschrift",
	9 => "angezeigt",
	10 => "Es gibt keine Artikel oder sie wurden von niemandem gelesen.",
	11 => "Top Ten der Kommentare",
	12 => "Kommentare",
	13 => "Es gibt keine Artikel oder es wurden keine Kommentare dazu abgegeben.",
	14 => "Top Ten der Umfragen",
	15 => "Thema der Umfrage",
	16 => "Stimmen",
	17 => "Es gibt keine Umfragen oder es wurden keine Stimmen abgegeben.",
	18 => "Top Ten der Links",
	19 => "Links",
	20 => "Angeklickt",
	21 => "Es gibt keine Links oder sie wurden von niemandem angeklickt.",
	22 => "Top Ten der verschickten Artikel",
	23 => "E-Mails",
	24 => "Es wurden keine Artikel per E-Mail verschickt."
);

###############################################################################
# article.php

$LANG11 = array(
	1 => "Weiterf&uuml;hrende Links",
	2 => "Artikel an einen Freund schicken",
	3 => "Druckf&auml;hige Version",
	4 => "Artikel-Optionen"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "To submit a $type you are required to be logged in as a user.",
	2 => "Login",
	3 => "Neuer User",
	4 => "Einen Termin einreichen",
	5 => "Einen Link einreichen",
	6 => "Einen Artikel einreichen",
	7 => "Login is Required",
	8 => "Abschicken",
	9 => "Wenn Du Informationen einreichen m&ouml;chtest, die auf dieser Site ver&ouml;ffentlicht werden sollen, dann bitten wir Dich, folgende Punkte zu beachten:<ul><li>Bitte alle Felder ausf&uuml;llen, sie werden ben&ouml;tigt<li>Bitte nur vollst&auml;ndige und exakte Information einreichen<li>URLs vor dem Abschicken unbedingt noch einmal kontrollieren ...</ul>",
	10 => "Titel",
	11 => "Link",
	12 => "Startdatum",
	13 => "Enddatum",
	14 => "Ort",
	15 => "Beschreibung",
	16 => "oder andere Kategorie",
	17 => "Kategorie",
	18 => "Other",
	19 => "Bitte lesen",
	20 => "Fehler: Kategorie fehlt",
	21 => "When selecting \"Other\" please also provide a category name",
	22 => "Fehler: Nicht alle Felder ausgef&uuml;llt",
	23 => "Bitte alle Felder des Formulars ausf&uuml;llen. Alle Felder werden ben&ouml;tigt.",
	24 => "Beitrag gespeichert",
	25 => "Dein $type-Beitrag wurde gespeichert.",
	26 => "Speed Limit",
	27 => "Username",
	28 => "Kategorie",
	29 => "Artikel",
	30 => "Dein letzter Beitrag war vor ",
	31 => " Sekunden. Zwischen zwei Betr&auml;gen m&uuml;ssen aber mindestens {$_CONF["speedlimit"]} Sekunden vergangen sein.",
	32 => "Vorschau",
	33 => "Artikelvorschau",
	34 => "Abmelden",
	35 => "HTML-Tags sind nicht erlaubt",
	36 => "Modus",
	37 => "Wenn Du einen Termin bei {$_CONF["site_name"]} einreichst, wird er in den Master-Kalender aufgenommen, von wo aus ihn andere User in ihren pers&ouml;nlichen Kalender &uuml;bernehmen k&ouml;nnen. Dies ist <b>NICHT</b> dazu gedacht, private Termine und Ereignisse wie etwa Geburtstage zu verwalten.<br><br>Wenn Du einen Termin einreichst, wird er an die Administratoren weitergeleitet und sobald er von diesen akzeptiert wird, wird er im Master-Kalender erscheinen.",
    38 => "Termin hinzuf&uuml;gen zu",
    39 => "Master-Kalender",
    40 => "Pers&ouml;nlicher Kalender",
    41 => "Endzeit",
    42 => "Startzeit",
    43 => "Ganzt&auml;giger Termin",
    44 => 'Addresse, Zeile 1',
    45 => 'Addresse, Zeile 2',
    46 => 'Stadt',
    47 => 'Bundesland',
    48 => 'Postleitzahl',
    49 => 'Art des Termins',
    50 => 'Edit Termin Types',
    51 => 'Ort',
    52 => 'L&ouml;schen'
);


###############################################################################
# ADMIN PHRASES - These are file phrases used in end admin scripts
###############################################################################

###############################################################################
# auth.inc.php

$LANG20 = array(
	1 => "Authentication Required",
	2 => "Denied! Incorrect Login Information",
	3 => "Invalid password for user",
	4 => "Username:",
	5 => "Passwort:",
	6 => "All access to administrative portions of this web site are logged and reviewed.<br>This page is for the use of authorized personnel only.",
	7 => "login"
);

###############################################################################
# block.php

$LANG21 = array(
	1 => "Ungen&uuml;gende Rechte",
	2 => "Du hast nicht die n&ouml;tigen Rechte, um diesen Block &auml;ndern zu k&ouml;nnen.",
	3 => "Block-Editor",
	4 => "",
	5 => "Block-Titel",
	6 => "Kategorie",
	7 => "Alle",
	8 => "Block-Sicherheitsstufe",
	9 => "Reihenfolge",
	10 => "Block-Typ",
	11 => "Portal-Block",
	12 => "Normaler Block",
	13 => "Portal-Block: Optionen",
	14 => "RDF-URL",
	15 => "Letztes Update",
	16 => "Normaler Block: Optionen",
	17 => "Inhalt",
	18 => "Bitte ausf&uuml;llen: Block-Titel, Sicherheitsstufe und Inhalt",
	19 => "Block-Manager",
	20 => "Titel",
	21 => "Block-Sichh.",
	22 => "Typ",
	23 => "Reihenfolge",
	24 => "Kategorie",
	25 => "Um einen Block zu &auml;ndern oder l&ouml;schen, auf den Block (s.u.) klicken. Um einen neuen Block anzulegen, auf Neuer Block (s.o.) klicken.",
	26 => "Layout-Block",
	27 => "PHP-Block",
        28 => "PHP-Block: Optionen",
        29 => "Block-Funktion",
        30 => "Wenn einer Deiner Bl&ouml;cke PHP-Code verwenden soll, gib hier bitte den Namen der Funktion ein. Der Funktionsname muss mit \"phpblock_\" (z.B. phpblock_getweather) beginnen. Wenn sie diese Namenskonvention nicht einh&auml;lt, wird die Funktion NICHT aufgerufen. Das soll verhindern, dass Hacker evtl. gef&auml;hrlichen Code einschleusen k&ouml;nnen. Den Funktionsnamen NICHT mit einem Klammerpaar \"()\" abschliessen. Ferner wird empfohlen, all Deinen Code f&uuml;r PHP-Bl&ouml;cke in der Datei /pfad/zu/geeklog/system/lib-custom.php abzulegen. Dort kann der Code auch dann unver&auml;ndert bleiben, wenn Du auf eine neuere Geeklog-Version umsteigst.",
        31 => "Fehler in PHP-Block: Funktion $function existiert nicht.",
        32 => "Fehler: Feld(er) fehlt/fehlen",
        33 => "F&uuml;r Portal-Bl&ouml;cke muss eine URL f&uuml;r zur .rdf-Datei eingegeben werden",
        34 => "F&uuml;r PHP-Blo&ouml;cke muss ein Titel und der Funktionsname eingegeben werden",
        35 => "F&uuml;r normale Bl&ouml;cke muss ein Titel und der Inhalt eingegeben werden",
        36 => "F&uuml; Layout-Bl&ouml;cke muss der Inhalt eingegeben werden",
        37 => "Ung&uuml;ltiger Funktionsname f&uuml;r einen PHP-Block",
        38 => "Funktionen f&uuml; PHP-Bl&ouml;cke m&uuml;ssen mit 'phpblock_' beginnen (z.B.. phpblock_getweather). Der 'phpblock_'-Teil wird aus Sicherheitsgr&uuml;nden vorausgesetzt, um das Ausf&uuml;hren von beliebigem Code zu verhindern.",
	39 => "Seite",
	40 => "links",
	41 => "rechts",
	42 => "F&uuml;r Geeklog-Default-Bl&ouml;cke muss eine Block-Reihenfolge und eine Sicherheitsstufe angegeben werden",
	43 => "Nur auf der Startseite",
	44 => "Zugriff verweigert",
	45 => "Du hast keine Zugriffsrechte f&uuml;r diesen Block. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF["site_url"]}/admin/block.php\">Zur&uuml;ck zum Administrator-Men&uuml;</a>.",
	46 => 'Neuer Block',
	47 => 'Admin Home',
    48 => 'Block-Name',
    49 => ' (keine Leerzeichen, muss eindeutig sein)',
    50 => 'URL zur Hilfe',
    51 => 'http:// voranstellen',
    52 => 'Wenn das Feld leer ist, wird kein Hilfe-Icon zu diesem Block angezeigt.',
    53 => 'Enabled'
);

###############################################################################
# event.php

$LANG22 = array(
	1 => "Termin-Editor",
	2 => "",
	3 => "Titel",
	4 => "URL",
	5 => "Startdatum",
	6 => "Enddatum",
	7 => "Ort",
	8 => "Beschreibung",
	9 => "(mit http://)",
	10 => "You need to fill in all fields in this form!",
	11 => "Termin-Manager",
	12 => "To modify or delete a event, click on that event below.  To create a new event click on new event above.",
	13 => "Titel",
	14 => "Startdatum",
	15 => "Enddatum",
	16 => "Access Denied",
	17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/event.php\">go back to the event administration screen</a>.",
	18 => 'Neuer Termin',
	19 => 'Admin Home'
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
	18 => 'New Link',
	19 => 'Admin Home',
	20 => 'If other, specify'
);

###############################################################################
# story.php

$LANG24 = array(
	1 => "Previous Stories",
	2 => "Next Stories",
	3 => "Mode",
	4 => "Modus",
	5 => "Story Editor",
	6 => "",
	7 => "Author",
	8 => "",
	9 => "",
	10 => "",
	11 => "",
	12 => "",
	13 => "Title",
	14 => "Kategorie",
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
	37 => "Mehr von",
	38 => "Mehr aus",
	39 => "E-Mails",
	40 => "Access Denied",
	41 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF["site_url"]}/admin/story.php\">go back to the story administration screen</a> when you are done.",
	42 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF["site_url"]}/admin/story.php\">go back to the story administration screen</a>.",
	43 => 'New Story',
	44 => 'Admin Home',
	45 => 'Access',
    46 => '<b>NOTE:</b> if you modify this date to be in the future, this article will not be published until that date.  That also means the story will not be included in your RDF headline feed and it will be ignored by the search and statistics pages.',
    47 => 'Images',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => 'To add one of the images you are attaching to this article you need to insert specially formated text.  The specially formated text is [imageX], [imageX_right] or [imageX_left] where X is the number of the image you have attached.  NOTE: You must use the images you attach.  If you do not you will be unable to save your story.',
    52 => 'Delete',
    53 => 'was not used.  You must include this image in the intro or body before you can save your changes',
    54 => 'Attached Images Not Used',
    55 => 'The following errors occured while trying to save your story.  Please correct these errors before saving'
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
	7 => "(keine Leerzeichen!)",
	8 => "Appears on Homepage",
	9 => "Question",
	10 => "Answers / Votes",
	11 => "There was an error getting poll answer data about the poll $qid",
	12 => "There was an error getting poll question data about the poll $qid",
	13 => "Create Poll",
	14 => "",
	15 => "",
	16 => "",
	17 => "",
	18 => "Poll List",
	19 => "To modify or delete a poll, click on that poll.  To create a new poll click on new poll above.",
	20 => "Voters",
	21 => "Access Denied",
	22 => "You are trying to access a poll that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/poll.php\">go back to the poll administration screen</a>.",
	23 => 'New Poll',
	24 => 'Admin Home',
	25 => 'Yes',
	26 => 'No'
);

###############################################################################
# topic.php

$LANG27 = array(
	1 => "Kategorie-Editor",
	2 => "Kategorie-ID",
	3 => "Kategorie-Name",
	4 => "Kategorie-Bild",
	5 => "(keine Leerzeichen!)",
	6 => "L&ouml;schen einer Kategorie l&ouml;scht auch alle dazu geh&ouml;renden Artikel und Bl&ouml;cke",
	7 => "Bitte die Felder Kategorie-ID und Kategorie-Name ausf&uuml;llen",
	8 => "Kategorie-Manager",
	9 => "To modify or delete a topic, click on that topic.  To create a new topic click the new topic button to the left. You will find you access level for each topic in parenthesis",
	10=> "Sortierreihenfolge",
	11 => "Artikel/Seite",
	12 => "Zugriff verweigert",
	13 => "You are trying to access a topic that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/topic.php\">go back to the topic administration screen</a>.",
	14 => "Sortiermethode",
	15 => "alphabetisch",
	16 => "Default:",
	17 => "Neue Kategorie",
	18 => "Admin Home"
);

###############################################################################
# user.php

$LANG28 = array(
	1 => "User-Editor",
	2 => "User-ID",
	3 => "Username",
	4 => "Name",
	5 => "Passwort",
	6 => "Security Level",
	7 => "E-Mail-Adresse",
	8 => "Homepage",
	9 => "(keine Leerzeichen!)",
	10 => "Bitte die Felder Username, Name, Security Level und E-Mail-Adresse ausf&uuml;llen",
	11 => "User-Manager",
	12 => "Auf den Usernamen klicken, um einen User zu &auml;ndern oder zu l&ouml;schen. Ein neuer User kann mit dem Button Neuer User angelegt werden. Es gibt auch eine einfache Suchfunktion, mit der nach Teilen von Usernamen, E-Mail-Adressen oder richtigen Namen gesucht werden kann (z.B. *son* oder *.de).",
	13 => "SecLev",
	14 => "Reg. Datum",
	15 => 'Neuer User',
	16 => 'Admin Home',
	17 => 'pw aendern',
	18 => 'Abbruch',
	19 => 'Loeschen',
	20 => 'Speichern',
	18 => 'Abbruch',
	19 => 'Loeschen',
	20 => 'Speichern',
    21 => 'Dieser Username existiert bereits.',
    22 => 'Fehler',
    23 => 'Import',
    24 => 'Mehrfach-Import von Usern',
    25 => 'Hier k&ouml;nnen Userdaten aus einer Datei in Geeklog importiert werden. Die Import-Datei muss ein Textfile sein, bei dem die Datens&auml;tze durch Tabs getrennt sind. Zudem m&uuml;ssen die Felder in der Reihenfolge Richtiger Name - Username - E-Mail-Adresse vorliegen. Jeder so importierte User bekommt eine E-Mail mit einem Zufallspasswort zugeschickt. Pro Zeile darf nur ein User stehen. Wenn sich die Importdatei nicht an dieses Format h&auml;lt, kann es zu Problemen kommen, die nur in m&uuml;hseliger Handarbeit behoben werden k&ouml;nnen. Also die Eintr&auml;ge lieber zweimal &uuml;berpr&uuml;fen ...',
    26 => 'Suche',
    27 => 'Anzahl Treffer'
);


###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Akzeptieren",
	2 => "L&ouml;schen",
	3 => "Editieren",
	34 => "Kommandozentrale",
	35 => "Beitr&auml;ge: Artikel",
	36 => "Beitr&auml;ge: Links",
	37 => "Beitr&auml;ge: Termine",
	38 => "Abschicken",
	39 => "Derzeit gibt es keine Beitr&auml;ge zu moderieren."
);

###############################################################################
# calendar.php

$LANG30 = array(
	1 => "Sonntag",
	2 => "Montag",
	3 => "Dienstag",
	4 => "Mittwoch",
	5 => "Donnerstag",
	6 => "Freitag",
	7 => "Samstag",
	8 => "Neuer Termin",
	9 => "Geeklog-Termin",
	10 => "Termine f&uuml;r",
	11 => "Master-Kalender",
	12 => "Mein Kalender",
	13 => "Januar",
	14 => "Februar",
	15 => "M&auml;rz",
	16 => "April",
	17 => "Mai",
	18 => "Juni",
	19 => "Juli",
	20 => "August",
	21 => "September",
	22 => "Oktober",
	23 => "November",
	24 => "Dezember",
	25 => "Zur&uuml;ck zum ",
    26 => "All Day",
    27 => "Woche",
    28 => "Pers&ouml;nlicher Kalender f&uuml;r",
    29 => "&Ouml;ffentlicher Kalender",
    30 => "Termin l&ouml;schen",
    31 => "Add",
    32 => "Termin",
    33 => "Datum",
    34 => "Uhrzeit",
    35 => "Quick Add",
    36 => "Submit",
    37 => "Sorry, the personal calendar feature is not enabled on this site",
    38 => "Pers&ouml;nlicher Termin-Editor"
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
  21 => 'Failures',
  22 => 'Successes',
  23 => 'No failures',
  24 => 'No successes'
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Dein Passwort sollte in K&uuml;rze per E-Mail bei Dir eintreffen. Bitte beachte die Hinweise in der E-Mail. Danke, dass Du Dich bei " . $_CONF["site_name"] . " angemeldet hast.",
	2 => "Danke f&uuml;r Deinen Beitrag zu {$_CONF["site_name"]}. Dein Artikel wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald auf dieser Website f&uuml;r alle Besucher zu lesen sein.",
	3 => "Danke f&uuml;r Deinen Beitrag zu {$_CONF["site_name"]}. Dein Link wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald unter den <a href=\"{$_CONF["site_url"]}/links.php\">Links</a> aufgelistet werden.",
	4 => "Danke f&uuml;r Deinen Beitrag zu {$_CONF["site_name"]}. Dein Termin wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald in unserem <a href=\"{$_CONF["site_url"]}/calendar.php\">Kalender</a> erscheinen.",
	5 => "Dein User-Profil wurde gespeichert.",
	6 => "Deine Anzeige-Einstellungen wurden gespeichert.",
	7 => "Deine Kommentar-Einstellungen wurden gespeichert.",
	8 => "Abmeldung erfolgt. Du bist jetzt nicht mehr angemeldet.",
	9 => "Dein Artikel wurde gespeichert.",
	10 => "Der Artikel wurde gel&ouml;scht.",
	11 => "Dein Block wurde gespeichert.",
	12 => "Der Block wurde gel&ouml;scht.",
	13 => "Deine Kategorie wurde gespeichert.",
	14 => "The topic and all it's stories an blocks have been successfully deleted.",
	15 => "Dein Link wurde gespeichert.",
	16 => "Der Link wurde gel&ouml;scht.",
	17 => "Dein Termin wurde gespeichert.",
	18 => "Der Termin wurde gel&ouml;scht.",
	19 => "Deine Umfrage wurde gespeichert.",
	20 => "Die Umfrage wurde gel&ouml;scht.",
	21 => "Der neue User wurde angelegt.",
	22 => "Der User wurde gel&ouml;scht.",
	23 => "Error trying to add an event to your calendar. There was no event id passed.",
	24 => "Der Termin wurde in Deinen Kalender eingetragen.",
	25 => "Cannot open your personal calendar until you login",
	26 => "Der Termin wurde aus Deinem pers&ouml;nlichen Kalender entfernt",
	27 => "Nachricht wurde verschickt.",
	28 => "Das Plugin wurde gespeichert.",
	29 => "Sorry, personal calendars are not enabled on this site",
	30 => "Access Denied",
	31 => "Sorry, you do not have access to the story administration page.  Please note that all attempts to access unauthorized features are logged",
	32 => "Sorry, you do not have access to the topic administration page.  Please note that all attempts to access unauthorized features are logged",
	33 => "Sorry, you do not have access to the block administration page.  Please note that all attempts to access unauthorized features are logged",
	34 => "Sorry, you do not have access to the link administration page.  Please note that all attempts to access unauthorized features are logged",
	35 => "Sorry, you do not have access to the event administration page.  Please note that all attempts to access unauthorized features are logged",
	36 => "Sorry, you do not have access to the poll administration page.  Please note that all attempts to access unauthorized features are logged",
	37 => "Sorry, you do not have access to the user administration page.  Please note that all attempts to access unauthorized features are logged",
	38 => "Sorry, you do not have access to the plugin administration page.  Please note that all attempts to access unauthorized features are logged",
	39 => "Sorry, you do not have access to the mail administration page.  Please note that all attempts to access unauthorized features are logged",
	40 => "System-Nachricht",
    41 => "Sorry, you do not have access to the word replacement page.  Please not that all attempts to access unauthorized features are logged",
    42 => "Your word has been successfully saved.",
	43 => "The word has been successfully deleted.",
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.',
    46 => "Sorry, you do not have access to the database backup utility.  Please note that all attempts to access unauthorized features are logged"
);

// for plugins.php

$LANG32 = array (
	1 => "Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href=\"http://geeklog.sourceforge.net\" target=\"_blank\">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.",
	2 => "Plug-in Installation Disclaimer",
	3 => "Plug-in Installation Form",
	4 => "Plug-in File",
	5 => "Plug-in List",
	6 => "Warning: Plug-in Already Installed!",
	7 => "The plug-in you are trying to install already exists.  Please delete the plugin before re-installing it",
	8 => "Plugin Compatibility Check Failed",
	9 => "This plugin requires a newer version of Geeklog. Either upgrade your copy of <a href=http://www.geeklog.org>Geeklog</a> or get a newer version of the plug-in.",
	10 => "<br><b>There are no plugins currently installed.</b><br><br>",
	11 => "To modify or delete a plug-in, click on that plug-in's number below. To learn more about a plug-in, click the plug-in name and you will be directed to that plug-in's website. To install or upgrade a plug-in click on new plug-in above.",
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
    31 => 'Are you sure you want to delete this plug-in?  By doing so you will remove all the files, data and data structures that this plug-in uses.  If you are sure, click delete again on the form below.'
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
	editrootmsg => "Even though you are a User Administrator, you can't edit a root user without first being a root user yourself.  You can edit all other users except root users. Please note that all attempts to illegally edit root users are logged.  Please go back to the <a href=\"{$_CONF["site_url"]}/admin/users.php\">User Administration page</a>.",
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
	newgroup => 'New Group',
	adminhome => 'Admin Home',
	save => 'save',
	cancel => 'cancel',
	canteditroot => 'You have tried to edit the Root group but you are not in the Root group yourself therefore your access to this group is denied.  Please contact the system administrator if you feel this is an error'	
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
    db_explanation => 'To create a new backup of your Geeklog system, hit the button below'
);

?>
