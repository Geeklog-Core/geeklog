<?php

// NOTE:  This is not a complete German file.  Please feel free to use this as a
// starting point and submit a complete one to the Geeklog developers!

###############################################################################
# german.php
# This is an *incomplete* german language page for GeekLog.
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
	15 => "Events",
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
	72 => "Web-Resourcen",
	73 => "Alte Umfragen",
	74 => "Kalender",
	75 => "Erweiterte Suche",
	76 => "Site-Statistik",
	77 => "Plugins",
	78 => "Anstehende Events",
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
	89 => "Es stehen keine Events an",
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
    101 => 'Meine Events',
    102 => 'Site-Events'
);

###############################################################################
# calendar.php

$LANG02 = array(
	1 => "Event-Kalender",
	2 => "Sorry, es gibt keine Events anzuzeigen.",
	3 => "Wann",
	4 => "Wo",
	5 => "Beschreibung",
	6 => "Event hinzuf&uuml;gen",
	7 => "Anstehende Events",
	8 => 'By adding this event to your calendar you can quickly view only the events you are interested in by clicking "Mein Kalender" from the User Functions area.',
	9 => "Zu Meinem Kalender hinzuf&uuml;gen",
	10 => "Aus Meinem Kalender entfernen",
	11 => "Event wird zum Kalender von {$_USER['username']} hinzugef&uuml;gt",
	12 => "Event",
	13 => "Beginnt",
	14 => "Endet"
);

###############################################################################
# comment.php

$LANG03 = array(
	1 => "Kommentar schreiben",
	2 => "Post Mode",
	3 => "Abmelden",
	4 => "Account anlegen",
	5 => "Username",
	6 => "Um einen Kommentar abgeben zu k&ouml;nnen, musst Du angemeldet sein. Wenn Du noch keinen Account hast, benutze bitte das Formular um einen anzulegen.",
	7 => "Dein letzter Kommentar war vor ",
	8 => " Sekunden. Zwischen zwei Kommentaren m&uuml;ssen aber mindestenst {$_CONF["commentspeedlimit"]} Sekunden vergangen sein",
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
	18 => "Die angegebene E-Mail-Adresse scheint keine g&uuml;tige E-Mail-Adresse zu sein",
	19 => "Dieser Username oder diese E-Mail-Adresse existieren bereits.",
	20 => "Die angegebene E-Mail-Adresse scheint keine g&uuml;tige E-Mail-Adresse zu sein",
	21 => "Fehler",
	22 => "Anmelden bei {$_CONF['site_name']}!",
	23 => "Creating a user account will give you all the benefits of {$_CONF['site_name']} membership and it will allow you to post comments and submit items as yourself. If you don't have an account, you will only be able to post anonymously. Please note that your email address will <b><i>never</i></b> be publicly displayed on this site.",
	24 => "Dein Passwort wird Dir an die angegeben E-Mail-Adresse geschickt.",
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
	44 => "Keine Boxen",
	45 => "Anzeige-Einstellungen f&uuml;r",
	46 => "Excluded Items for",
	47 => "News box Configuration for",
	48 => "Kategorien",
	49 => "Keine Icons in Artikeln",
	50 => "H&auml;kchen entfernen, wenn es Dich nicht interessiert",
	51 => "Just the news stories",
	52 => "Defaultwert: 10",
	53 => "Receive the days stories every night",
	54 => "Themen und Autoren ankreuzen, die Du NICHT sehen willst.",
	55 => "If you leave these all unchecked, it means you want the default selection of boxes. If you start selecting boxes, remember to set all of them that you want because the default selection will be ignored. Default entries are displayed in bold.",
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
	71 => "One of the great features of {$_CONF['site_name']} is you can customize the content you get and you can change the overall layout of this site.  In order to take advantage of these greate features you must first <a href=\"{$_CONF['site_url']}/users.php?mode=new\">register</a> with {$_CONF['site_name']}.  Are you already a member?  The use the login form to the left to log in!",
    72 => "Erscheinungsbild",
    73 => "Sprache"
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
	1 => "Web-Resourcen",
	2 => "Es gibt keine Resourcen anzuzeigen.",
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
	1 => "There was an error sending your message. Please try again.",
	2 => "Message sent successfully.",
	3 => "Please make sure you use a valid email address in the Reply To field.",
	4 => "Please fill in the Your Name, Reply To, Subject and Message fields",
	5 => "Error: No such user.",
	6 => "There was an error.",
	7 => "Userprofil f&uuml;r",
	8 => "Username",
	9 => "User URL",
	10 => "Send mail to",
	11 => "Your Name:",
	12 => "Reply To:",
	13 => "Subject:",
	14 => "Message:",
	15 => "HTML will not be translated.",
	16 => "Send Message",
	17 => "Artikel an einen Freund schicken",
	18 => "To Name",
	19 => "To E-Mail Address",
	20 => "From Name",
	21 => "From E-Mail Address",
	22 => "All fields are required",
	23 => "This email was sent to you by $from at $fromemail because they thought you might be interested it this article from {$_CONF["site_url"]}.  This is not SPAM and the email addresses involved in this transaction were not saved to a list or stored for later use.",
	24 => "Comment on this story at",
	25 => "You must be logged in to user this feature.  By having you log in, it helps us prevent misuse of the system",
	26 => "This form will allow you to send an email to the selected user.  All fields are required.",
	27 => "Short message",
	28 => "$from wrote: $shortmsg"
);

###############################################################################
# search.php

$LANG09 = array(
	1 => "Erweiterte Suche",
	2 => "Key Words",
	3 => "Kategorie",
	4 => "All",
	5 => "Type",
	6 => "Stories",
	7 => "Comments",
	8 => "Authors",
	9 => "All",
	10 => "Search",
	11 => "Search Results",
	12 => "matches",
	13 => "Story Search Result: No matches",
	14 => "There were no matches for your search on",
	15 => "Please try again.",
	16 => "Title",
	17 => "Date",
	18 => "Author",
	19 => "Search the entire {$_CONF["site_name"]} database of current and past news stories",
	20 => "Date",
	21 => "to",
	22 => "(Date Format MM-DD-YYYY)",
	23 => "Hits",
	24 => "Found",
	25 => "matches for",
	26 => "items in",
	27 => "seconds",
    28 => 'No story or comment matches for your search',
    29 => 'Story and Comment Results'
);

###############################################################################
# stats.php

$LANG10 = array(
	1 => "Site-Statistik",
	2 => "Total Hits to the System",
	3 => "Artikel (Kommentare) im System",
	4 => "Umfragen (Stimmen) im System",
	5 => "Links (Klicks) im System",
	6 => "Events im System",
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
	1 => "Verwandte Kategorien",
	2 => "Artikel an einen Freund schicken",
	3 => "Druckf&auml;hige Version",
	4 => "Story Options"
);

###############################################################################
# submit.php

$LANG12 = array(
	1 => "To submit a $type you are required to be logged in as a user.",
	2 => "Login",
	3 => "Neuer User",
	4 => "Einen Event einreichen",
	5 => "Einen Link einreichen",
	6 => "Einen Artikel einreichen",
	7 => "Login is Required",
	8 => "Abschicken",
	9 => "Wenn Du Informationen einreichen m&ouml;chtest, die auf dieser Site benutzt werden soll, dann bitten wir Dich, folgende Punkte zu beachten:<ul><li>Bitte alle Felder ausf&uuml;llen, sie werden ben&ouml;tigt<li>Bitte nur vollst&auml;ndige und exakte Information einreichen<li>URLs vor dem Abschicken unbedingt noch einmal kontrollieren ...</ul>",
	10 => "Titel",
	11 => "Link",
	12 => "Startdatum",
	13 => "Enddatum",
	14 => "Ort",
	15 => "Beschreibung",
	16 => "If other, please specify",
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
	36 => "Post Mode",
	37 => "Submitting an event to {$_CONF["site_name"]} will put your event on the master calendar where users can optionally add your event to their personal calendar. This feature is <b>NOT</b> meant to store your personal events such as birthdays and anniversaries.<br><br>Once you submit your event it will be sent to our administrators and if approved, your event will appear on the master calendar.",
    38 => "Add Event To",
    39 => "Master-Kalender",
    40 => "Pers&ouml;nlicher Kalender",
    41 => "Endzeit",
    42 => "Startzeit",
    43 => "Ganzt&auml;giger Event",
    44 => 'Addresse, Zeile 1',
    45 => 'Address, Zeile 2',
    46 => 'Stadt',
    47 => 'Bundesland',
    48 => 'Postleitzahl',
    49 => 'Art des Events',
    50 => 'Edit Event Types',
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
    52 => 'Wenn das Feld leer ist, wird kein Hilfe-Icon zu diesem Block angezeigt.'
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
	10 => "You need to fill in all fields in this form!",
	11 => "Event Manager",
	12 => "To modify or delete a event, click on that event below.  To create a new event click on new event above.",
	13 => "Event Title",
	14 => "Start Date",
	15 => "End Date",
	16 => "Access Denied",
	17 => "You are trying to access an event that you don't have rights to.  This attempt has been logged. Please <a href=\"{$_CONF["site_url"]}/admin/event.php\">go back to the event administration screen</a>.",
	18 => 'New Event',
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
	4 => "Post Mode",
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
	37 => "More by",
	38 => "More from",
	39 => "E-Mails",
	40 => "Access Denied",
	41 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  You may view the article in read-only below. Please <a href=\"{$_CONF["site_url"]}/admin/story.php\">go back to the story administration screen</a> when you are done.",
	42 => "You are trying to access a story that you don't have rights to.  This attempt has been logged.  Please <a href=\"{$_CONF["site_url"]}/admin/story.php\">go back to the story administration screen</a>.",
	43 => 'New Story',
	44 => 'Admin Home',
	45 => 'Access'
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
	12 => "Auf den Usernamen klicken, um einen User zu &auml;ndern oder zu l&ouml;schen. Ein neuer User kann mit dem Button Neuer User angelegt werden.",
	13 => "SecLev",
	14 => "Reg. Datum",
	15 => 'Neuer User',
	16 => 'Admin Home',
	17 => 'pw &auml;ndern',
	18 => 'Abbruch',
	19 => 'L&ouml;schen',
	20 => 'Speichern',
	18 => 'Abbruch',
	19 => 'L&ouml;schen',
	20 => 'Speichern',
    21 => 'Dieser Username existiert bereits.',
    22 => 'Fehler'
);


###############################################################################
# moderation.php

$LANG29 = array(
	1 => "Akzeptieren",
	2 => "L&ouml;schen",
	3 => "Editieren",
	34 => "Command and Control",
	35 => "Story Submissions",
	36 => "Link Submissions",
	37 => "Event Submissions",
	38 => "Submit",
	39 => "There are no submissions to moderate at this time"
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
	8 => "Add Event",
	9 => "Geeklog Event",
	10 => "Events for",
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
	25 => "Zur&uuml;ck zu ",
    26 => "All Day",
    27 => "Woche",
    28 => "Pers&ouml;nlicher Kalender f&uuml;r",
    29 => "&Ouml;ffentlicher Kalender",
    30 => "Event l&ouml;schen",
    31 => "Add",
    32 => "Event",
    33 => "Datum",
    34 => "Uhrzeit",
    35 => "Quick Add",
    36 => "Submit",
    37 => "Sorry, the personal calendar feature is not enabled on this site",
    38 => "Personal Event Editor"
);

###############################################################################
# admin/mail.php
$LANG31 = array(
 	1 => "Mail",
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
	17 => "<a href=" . $_CONF["site_url"] . "/admin/mail.php>Send another message</a>"
);


###############################################################################
# confirmation and error messages

$MESSAGE = array (
	1 => "Your password has been emailed to you and should arrive momentarily. Please follow the directions in the message and we thank-you for using " . $_CONF["site_name"],
	2 => "Thank-you for submitting your story to {$_CONF["site_name"]}.  It has been submitted to our staff for approval. If approved, your story will be available for others to read on our site.",
	3 => "Thank-you for submitting a link to {$_CONF["site_name"]}.  It has been submitted to our staff for approval.  If approved, your link will be seen in the <a href={$_CONF["site_url"]}/links.php>links</a> section.",
	4 => "Thank-you for submitting an event to {$_CONF["site_name"]}.  It has been submitted to our staff for approval.  If approved, your event will be seen in our <a href={$_CONF["site_url"]}/calendar.php>calendar</a> section.",
	5 => "Your account information has been successfully saved.",
	6 => "Your display preferences have been successfully saved.",
	7 => "Your comment preferences have been successfully saved.",
	8 => "You have been successfully logged out.",
	9 => "Your story has been successfully saved.",
	10 => "The story has been successfully deleted.",
	11 => "Your block has been successfully saved.",
	12 => "The block has been successfully deleted.",
	13 => "Your topic has been successfully saved.",
	14 => "The topic and all it's stories an blocks have been successfully deleted.",
	15 => "Your link has been successfully saved.",
	16 => "The link has been successfully deleted.",
	17 => "Your event has been successfully saved.",
	18 => "The event has been successfully deleted.",
	19 => "Your poll has been successfully saved.",
	20 => "The poll has been successfully deleted.",
	21 => "The new user has been successfully saved.",
	22 => "The user has been successfully deleted",
	23 => "Error trying to add an event to your calendar. There was no event id passed.",
	24 => "The event has been saved to your calendar",
	25 => "Cannot open your personal calendar until you login",
	26 => "Event was successfully removed from your personal calendar",
	27 => "Message successfully sent.",
	28 => "The plug-in has been successfully saved",
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
	40 => "System Message",
    41 => "Sorry, you do not have access to the word replacement page.  Please not that all attempts to access unauthorized features are logged",
    42 => "Your word has been successfully saved.",
	43 => "The word has been successfully deleted.",
    44 => 'The plug-in was successfully installed!',
    45 => 'The plug-in was successfully deleted.'
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
?>
