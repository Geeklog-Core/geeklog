<?php

###############################################################################
# German_Unicode.php
#
# This is the German language file for Geeklog, addressing the user as "Du"
# (informal German). See german_formal.php for a language file addressing the
# user with the formal "Sie".
#
# Author: Dirk Haun <dirk@haun-online.de>
#
# Based on the original english.php, started by Jason Whittenburg.
#
# Converted to Unicode (UTF-8) by Samuel Stone <sam@stonemicro.com>
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
    1 => 'Beitrag von:',
    2 => '(mehr)',
    3 => 'Kommentar(e)',
    4 => 'Ändern',
    5 => 'Umfrage',
    6 => 'Ergebnisse',
    7 => 'Umfrage-Ergebnisse',
    8 => 'Stimmen',
    9 => 'Admin-Funktionen:',
    10 => 'Beiträge',
    11 => 'Artikel',
    12 => 'Blöcke',
    13 => 'Kategorien',
    14 => 'Links',
    15 => 'Termine',
    16 => 'Umfragen',
    17 => 'User',
    18 => 'SQL-Query',
    19 => 'Abmelden',
    20 => 'User-Information:',
    21 => 'Username',
    22 => 'User-ID',
    23 => 'Security Level',
    24 => 'Gast',
    25 => 'Antwort',
    26 => 'Die folgenden Kommentare geben Meinungen von Lesern wieder und entsprechen nicht notwendigerweise der Meinung der Betreiber dieser Site. Die Betreiber behalten sich die Löschung von Kommentaren vor.',
    27 => 'Letzter Beitrag',
    28 => 'Löschen',
    29 => 'Keine Kommentare.',
    30 => 'Ältere Artikel',
    31 => 'Erlaubte HTML-Tags: ',
    32 => 'Fehler: Ungültiger Username',
    33 => 'Fehler: Konnte nicht ins Logfile schreiben',
    34 => 'Fehler',
    35 => 'Abmelden',
    36 => 'am',
    37 => 'Keine Artikel.',
    38 => 'Content Syndication',
    39 => 'Neuladen',
    40 => 'Du hast <tt>register_globals = Off</tt> in Deiner <tt>php.ini</tt>. Für Geeklog muss <tt>register_globals</tt> jedoch auf <strong>on</strong> stehen. Bitte ändere dies auf <strong>on</strong> und starte Deinen Webserver neu.',
    41 => 'Gäste',
    42 => 'Autor:',
    43 => 'Antwort schreiben',
    44 => 'vorherige',
    45 => 'MySQL Fehlernummer',
    46 => 'MySQL Fehlermeldung',
    47 => 'Anmelden',
    48 => 'Userprofil ändern',
    49 => 'Einstellungen',
    50 => 'Fehler im SQL-Befehl',
    51 => 'Hilfe',
    52 => 'Neu',
    53 => 'Admin-Home',
    54 => 'Konnte die Datei nicht öffnen:',
    55 => 'Fehler,',
    56 => 'Abstimmen',
    57 => 'Passwort',
    58 => 'Anmelden',
    59 => "Noch nicht registriert? Melde Dich jetzt als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">neuer User</a> an",
    60 => 'Kommentar schreiben',
    61 => 'Neuen Account anlegen',
    62 => 'Wörter',
    63 => 'Kommentar-Einstellungen',
    64 => 'Artikel an einen Freund schicken',
    65 => 'Druckfähige Version anzeigen',
    66 => 'Mein Kalender',
    67 => 'Willkommen bei ',
    68 => 'Home',
    69 => 'Kontakt',
    70 => 'Suchen',
    71 => 'Mitmachen',
    72 => 'Links',
    73 => 'Umfragen',
    74 => 'Kalender',
    75 => 'Erweiterte Suche',
    76 => 'Statistik',
    77 => 'Plugins',
    78 => 'Anstehende Termine',
    79 => 'Was ist neu',
    80 => 'Artikel in den letzten',
    81 => 'Artikel in den letzten',
    82 => 'Stunden',
    83 => 'KOMMENTARE',
    84 => 'LINKS',
    85 => 'der letzten 48 Stunden',
    86 => 'Keine neuen Kommentare',
    87 => 'der letzten 2 Wochen',
    88 => 'Keine neuen Links',
    89 => 'Es stehen keine Termine an',
    90 => 'Home',
    91 => 'Seite erzeugt in',
    92 => 'Sekunden',
    93 => 'Copyright',
    94 => 'All trademarks and copyrights on this page are owned by their respective owners.',
    95 => 'Powered By',
    96 => 'Gruppen',
    97 => 'Wortliste',
    98 => 'Plugins',
    99 => 'ARTIKEL',
    100 => 'Keine neuen Artikel',
    101 => 'Meine Termine',
    102 => 'Allgemeine Termine',
    103 => 'DB Backups',
    104 => 'von',
    105 => 'Mail an User',
    106 => 'Angezeigt',
    107 => 'Update verfügbar?',
    108 => 'Cache löschen',
    109 => 'Beitrag melden',
    110 => 'Site-Admin auf diesen Beitrag hinweisen',
    111 => 'Als PDF anzeigen',
    112 => 'Registrierte User',
    113 => 'Dokumentation'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => 'Terminkalender',
    2 => 'Sorry, es gibt keine Termine anzuzeigen.',
    3 => 'Wann',
    4 => 'Wo',
    5 => 'Beschreibung',
    6 => 'Termin hinzufügen',
    7 => 'Anstehende Termine',
    8 => 'Wenn Du diesen Termin zu Deinem Kalender hinzufügst, kannst Du Dir schneller einen Überblick über die Termine verschaffen, die Dich interessieren, indem Du einfach auf "Mein Kalender" klickst.',
    9 => 'Zu Meinem Kalender hinzufügen',
    10 => 'Aus Meinem Kalender entfernen',
    11 => "Termin wird zum Kalender von {$_USER['username']} hinzugefügt",
    12 => 'Termin',
    13 => 'Beginnt',
    14 => 'Endet',
    15 => 'Zurück zum Kalender'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Kommentar schreiben',
    2 => 'Format',
    3 => 'Abmelden',
    4 => 'Account anlegen',
    5 => 'Username',
    6 => 'Um einen Kommentar abgeben zu können, musst Du angemeldet sein. Wenn Du noch keinen Account hast, benutze bitte das Formular um einen anzulegen.',
    7 => 'Dein letzter Kommentar war vor ',
    8 => " Sekunden. Zwischen zwei Kommentaren müssen aber mindestens {$_CONF['commentspeedlimit']} Sekunden vergangen sein.",
    9 => 'Kommentar',
    10 => 'Send Report',
    11 => 'Kommentar abschicken',
    12 => 'Bitte die Felder Betreff <em>und</em> Kommentar ausfüllen, um einen Kommentar zu diesem Artikel abzugeben.',
    13 => 'Deine Information',
    14 => 'Vorschau',
    15 => 'Report this post',
    16 => 'Betreff',
    17 => 'Fehler',
    18 => 'Wichtige Hinweise:',
    19 => 'Bitte gib nur Kommentare ab, die zum Thema gehören.',
    20 => 'Beziehe Dich möglichst auf Kommentare anderer Personen statt einen neuen Thread zu eröffnen.',
    21 => 'Lies bitte die vorhandenen Kommentare bevor Du Deinen eigenen abgibst, um nicht noch einmal zu schreiben, was schon gesagt wurde.',
    22 => 'Benutze eine eindeutige Betreffzeile, die den Inhalt Deines Kommentars zusammenfasst.',
    23 => 'Deine E-Mail-Adresse wird NICHT veröffentlicht.',
    24 => 'Gast',
    25 => 'Bist Du sicher, dass Du diesen Beitrag als möglichen Missbrauch melden willst?',
    26 => '%s meldete den folgenden Beitrag als möglichen Missbrauch:',
    27 => 'Hinweis auf Missbrauch'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => 'Userprofil für',
    2 => 'Username',
    3 => 'Name',
    4 => 'Passwort',
    5 => 'E-Mail',
    6 => 'Homepage',
    7 => 'Biographie',
    8 => 'PGP-Key',
    9 => 'Speichern',
    10 => 'Die letzten 10 Kommentare von',
    11 => 'Keine Kommentare',
    12 => 'User-Einstellungen für',
    13 => 'E-Mail Nightly Digest',
    14 => 'Dieses Passwort wurde mit einem Zufallsgenerator erzeugt. Es wird empfohlen, das Passwort nach dem Anmelden sofort zu ändern. Um Dein Passwort zu ändern, melde Dich bitte an und wähle dann den Punkt Userprofil ändern im Block Einstellungen.',
    15 => "Dein Account für {$_CONF['site_name']} wurde erfolgreich angelegt. Um ihn benutzen zu können, melde Dich bitte mit den folgenden Informationen an. Diese E-Mail bitte aufheben.",
    16 => 'Deine Zugangsdaten',
    17 => 'Account existiert nicht',
    18 => 'Die angegebene E-Mail-Adresse scheint keine gültige E-Mail-Adresse zu sein',
    19 => 'Dieser Username oder diese E-Mail-Adresse existieren bereits.',
    20 => 'Die angegebene E-Mail-Adresse scheint keine gültige E-Mail-Adresse zu sein',
    21 => 'Fehler',
    22 => "Anmelden bei {$_CONF['site_name']}!",
    23 => "Indem Du Dich bei {$_CONF['site_name']} anmeldest, kannst Du Artikel und Kommentare unter Deinem eigenen Namen veröffentlichen (andernfalls geht das nur anonym). Übrigens wird Deine E-Mail-Adresse <strong><em>niemals</em></strong> auf dieser Website angezeigt werden.",
    24 => 'Dein Passwort wird Dir an die angegebene E-Mail-Adresse geschickt.',
    25 => 'Passwort vergessen?',
    26 => 'Gib <em>entweder</em> Deinen Usernamen <em>oder</em> die E-Mail-Adresse ein, mit der Du Dich angemeldet hast, und klicke auf Passwort schicken. Eine E-Mail mit einer Anleitung, wie Du ein neues Passwort eingeben kannst, wird dann an die gespeicherte E-Mail-Adresse geschickt.',
    27 => 'Jetzt anmelden!',
    28 => 'Passwort schicken',
    29 => 'logged out from',
    30 => 'logged in from',
    31 => 'Um diese Funktion nutzen zu können, musst Du angemeldet sein',
    32 => 'Signatur',
    33 => 'Auf der Site nicht sichtbar!',
    34 => 'Dein richtiger Name',
    35 => 'Passwort eingeben, um es zu ändern',
    36 => '(mit http://)',
    37 => 'Wird an Deine Kommentare angefügt',
    38 => 'Alles über Dich - für alle sichtbar',
    39 => 'Dein PGP-Key, so vorhanden',
    40 => 'Kategorien ohne Icons',
    41 => 'Bereit zu Moderieren',
    42 => 'Datumsformat',
    43 => 'Artikel pro Seite',
    44 => 'Keine Blöcke',
    45 => 'Anzeige-Einstellungen für',
    46 => 'Nicht anzeigen für',
    47 => 'Block-Einstellungen für',
    48 => 'Kategorien',
    49 => 'Keine Icons in Artikeln',
    50 => 'Häkchen entfernen, wenn es Dich nicht interessiert',
    51 => 'Nur die Artikel',
    52 => 'Defaultwert:',
    53 => 'Receive the days stories every night',
    54 => 'Themen und Autoren auswählen, die Du NICHT sehen willst.',
    55 => 'Wenn Du hier nichts ankreuzt, wird die Default-Auswahl an Blöcken angezeigt. Sobald Du anfängst, Blöcke anzukreuzen, werden auch nur noch diejenigen angezeigt, die angekreuzt sind! Die Default-Blöcke sind <b>fett</b> markiert.',
    56 => 'Autoren',
    57 => 'Anzeigemodus',
    58 => 'Sortierreihenfolge',
    59 => 'Kommentarlimit',
    60 => 'Wie sollen Kommentare angezeigt werden?',
    61 => 'Neueste oder älteste zuerst?',
    62 => 'Defaultwert: 100',
    63 => "Dein Passwort sollte in Kürze per E-Mail eintreffen. Bitte beachte die Hinweise in der E-Mail und Danke für Dein Interesse an {$_CONF['site_name']}",
    64 => 'Kommentar-Einstellungen für',
    65 => 'Bitte noch einmal versuchen, Dich anzumelden',
    66 => "Hast Du Dich vertippt? Bitte versuch noch einmal, Dich hier anzumelden. Oder möchtest Du Dich <a href=\"{$_CONF['site_url']}/users.php?mode=new\">als neuer User registrieren</a>?",
    67 => 'Mitglied seit',
    68 => 'Angemeldet für',
    69 => 'Wie lange soll das System Dich nach dem Anmelden erkennen?',
    70 => "Aussehen und Inhalt von {$_CONF['site_name']} konfigurieren",
    71 => "Zu den Features von {$_CONF['site_name']} gehört, dass Du selbst festlegen kannst, welche Artikel Du angezeigt bekommst. Darüber hinaus kannst Du auch das Aussehen der Website verändern. Um in den Genuss dieser Features zu kommen, musst Du Dich jedoch zuerst bei {$_CONF['site_name']} <a href=\"{$_CONF['site_url']}/users.php?mode=new\">anmelden</a>. Oder bist Du schon angemeldet? Dann benutze bitte das Anmeldeformular auf der linken Seite.",
    72 => 'Erscheinungsbild',
    73 => 'Sprache',
    74 => 'Ändere das Aussehen dieser Site',
    75 => 'Artikel per E-Mail für',
    76 => 'Wähle Kategorien aus der folgenden Liste und Du bekommst einmal pro Tag eine E-Mail mit einer Übersicht aller neuen Artikel in den ausgewählten Kategorien. Du brauchst nur die Kategorien anzukreuzen, die Dich interessieren.',
    77 => 'Foto',
    78 => 'Ein Bild von Dir',
    79 => 'Ankreuzen, um dieses Bild zu löschen:',
    80 => 'Anmelden',
    81 => 'E-Mail schreiben',
    82 => 'Die letzten 10 Artikel von',
    83 => 'Statistik für',
    84 => 'Gesamtanzahl Artikel:',
    85 => 'Gesamtanzahl Kommentare',
    86 => 'Alle Artikel und Kommentare von',
    87 => 'Dein Username',
    88 => "Jemand (möglicherweise Du selbst) hat ein neues Passwort für Deinen Account \"%s\" auf {$_CONF['site_name']} <{$_CONF['site_url']}> angefordert.\n\nWenn Du tatsächlich ein neues Passwort benötigst, klicke bitte auf den folgenden Link:\n\n",
    89 => "Möchtest Du Dein Passwort nicht ändern, so kannst Du diese E-Mail einfach ignorieren (Dein bisheriges Passwort bleibt dann unverändert gültig).\n\n",
    90 => 'Du kannst hier jetzt ein neues Passwort für Deinen Account eingeben. Dein altes Passwort bleibt noch solange gültig, bis Du dieses Formular abschickst.',
    91 => 'Neues Passwort',
    92 => 'Neues Passwort eingeben',
    93 => 'Du hast zuletzt vor %d Sekunden ein neues Passwort angefordert. Zwischen zwei Passwort-Anforderungen müssen aber mindestens %d Sekunden vergangen sein.',
    94 => 'Lösche Account "%s"',
    95 => 'Du kannst Deinen Account löschen, indem Du auf den "Account Löschen"-Button klickst. Artikel und Kommentare, die Du unter diesem Account geschrieben hast, werden <strong>nicht</strong> gelöscht, werden aber fortan als vom User "Gast" geschrieben erscheinen.',
    96 => 'Account Löschen',
    97 => 'Account Löschen bestätigen',
    98 => 'Bist Du sicher, dass Du Deinen Account löschen willst? Du wirst Dich danach nicht mehr einloggen können (es sei denn, Du legst einen neuen Account an). Wenn Du Dir sicher bist, klicke bitte noch einmal auf "Account Löschen".',
    99 => 'Privatsphäre-Einstellungen für',
    100 => 'E-Mail von Admin',
    101 => 'Erlaube E-Mails von Site-Admins',
    102 => 'E-Mail von Usern',
    103 => 'Erlaube E-Mails von anderen Usern',
    104 => 'Online-Status zeigen',
    105 => 'Unter "Wer ist online?"',
    106 => 'Wohnort',
    107 => 'Erscheint im öffentlichen Profil'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Keine Artikel',
    2 => 'Es gibt keine Artikel, die angezeigt werden könnten. Entweder gibt es für diese Kategorie keine Artikel oder Deine Einstellungen sind zu restriktiv',
    3 => ' für die Kategorie %s.',
    4 => 'Hauptartikel',
    5 => 'weiter',
    6 => 'zurück',
    7 => 'Anfang',
    8 => 'Ende'
);

###############################################################################
# links.php

$LANG06 = array(
    1 => 'Links',
    2 => 'Es gibt keine Links anzuzeigen.',
    3 => 'Link hinzufügen'
);

###############################################################################
# pollbooth.php

$LANG07 = array(
    1 => 'Stimme gespeichert',
    2 => 'Deine Stimme wurde für die Umfrage gespeichert: ',
    3 => 'Stimme',
    4 => 'Umfragen im System',
    5 => 'Stimme(n)',
    6 => 'Ältere Umfragen'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Es gab einen Fehler beim Versenden der Nachricht. Bitte noch einmal versuchen.',
    2 => 'Nachricht wurde verschickt.',
    3 => 'Bitte sicherstellen, dass Du eine gültige E-Mail-Adresse eingetragen hast.',
    4 => 'Bitte alle Felder ausfüllen: Dein Name, Deine E-Mail, Betreff und Nachricht',
    5 => 'Fehler: Username nicht bekannt.',
    6 => 'Es ist ein Fehler aufgetreten.',
    7 => 'Userprofil für',
    8 => 'Username',
    9 => 'User URL',
    10 => 'Eine Mail schicken an',
    11 => 'Dein Name:',
    12 => 'Deine E-Mail:',
    13 => 'Betreff:',
    14 => 'Nachricht:',
    15 => 'HTML wird nicht interpretiert.',
    16 => 'Abschicken',
    17 => 'Artikel an einen Freund schicken',
    18 => 'An (Name)',
    19 => 'An (E-Mail)',
    20 => 'Von (Name)',
    21 => 'Von (E-Mail)',
    22 => 'Alle Felder müssen ausgefüllt werden.',
    23 => "Diese Nachricht wurde Ihnen von %s <%s> geschickt, da er/sie der Meinung war, Sie würden sich vielleicht für diesen Artikel auf <{$_CONF['site_url']}> interessieren. Dies ist kein SPAM und die beteiligten E-Mail-Adressen (Ihre und die des Absenders) wurden nicht gespeichert.",
    24 => 'Schreiben Sie einen Kommentar zu diesem Artikel:',
    25 => 'Du musst Dich anmelden, um diese Funktion benutzen zu können. Dies ist leider nötig, um den Missbrauch des Systems zu verhindern',
    26 => 'Mit diesem Formular kannst Du eine E-Mail an diesen User schicken. Alle Felder müssen ausgefüllt werden.',
    27 => 'Kurze Nachricht',
    28 => 'Anmerkung von %s: ',
    29 => "Dies sind die neuen Artikel auf {$_CONF['site_name']} vom ",
    30 => ' - Neue Artikel vom ',
    31 => 'Titel',
    32 => 'Datum',
    33 => 'Kompletter Artikel unter',
    34 => 'Ende dieser Nachricht',
    35 => 'Sorry, dieser User möchte keine E-Mails bekommen.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => 'Erweiterte Suche',
    2 => 'Suchbegriffe',
    3 => 'Kategorie',
    4 => 'Alle',
    5 => 'Art',
    6 => 'Artikel',
    7 => 'Kommentare',
    8 => 'Autoren',
    9 => 'Alle',
    10 => 'Suchen',
    11 => 'Suchergebnisse',
    12 => 'Treffer',
    13 => 'Erweiterte Suche: Keine Treffer',
    14 => 'Es gab keine Treffer für Deine Suche nach',
    15 => 'Bitte noch einmal versuchen.',
    16 => 'Titel',
    17 => 'Datum',
    18 => 'Autor',
    19 => "Durchsuche die komplette Datenbank von {$_CONF['site_name']} ...",
    20 => 'Datum',
    21 => 'bis',
    22 => '(Datumsformat: JJJJ-MM-TT)',
    23 => 'Treffer',
    24 => '%d Einträge gefunden',
    25 => 'Gesucht wurde nach',
    26 => 'Beiträgen in',
    27 => 'Sekunden.',
    28 => 'Keine Treffer unter den Artikeln und Kommentaren.',
    29 => 'Gefundene Artikel und Kommentare',
    30 => 'Keine Links für Deine Suche gefunden',
    31 => 'Dieses Plugin lieferte keine Treffer',
    32 => 'Termin',
    33 => 'URL',
    34 => 'Ort',
    35 => 'Ganztägig',
    36 => 'Keine Termine für Deine Suche gefunden',
    37 => 'Gefundene Termine',
    38 => 'Gefundene Links',
    39 => 'Links',
    40 => 'Termine',
    41 => 'Dein Suchbegriff sollte mindestens 3 Zeichen lang sein.',
    42 => 'Das Datum muss im Format JJJJ-MM-TT (Jahr-Monat-Tag) eingegeben werden.',
    43 => 'genaue Wortgruppe',
    44 => 'alle Wörter',
    45 => 'irgendeines der Wörter',
    46 => 'weiter',
    47 => 'zurück'
    48 => 'Autor',
    49 => 'Datum',
    50 => 'Treffer',
    51 => 'Link',
    52 => 'Wohnort',
    53 => 'Gefundene Artikel',
    54 => 'Gefundene Kommentare',
    55 => 'der Wortgruppe',
    56 => '<em>und</em>',
    57 => '<em>oder</em>'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => 'Site-Statistik',
    2 => 'Gesamtzahl der Seitenabrufe',
    3 => 'Anzahl Artikel (Kommentare)',
    4 => 'Anzahl Umfragen (Stimmen)',
    5 => 'Anzahl Links (Klicks)',
    6 => 'Anzahl Termine',
    7 => 'Top Ten der Artikel',
    8 => 'Artikel-Überschrift',
    9 => 'Angezeigt',
    10 => 'Es gibt keine Artikel oder sie wurden von niemandem gelesen.',
    11 => 'Top Ten der meistkommentierten Artikel',
    12 => 'Kommentare',
    13 => 'Es gibt keine Artikel oder es wurden keine Kommentare dazu abgegeben.',
    14 => 'Top Ten der Umfragen',
    15 => 'Thema der Umfrage',
    16 => 'Stimmen',
    17 => 'Es gibt keine Umfragen oder es wurden keine Stimmen abgegeben.',
    18 => 'Top Ten der Links',
    19 => 'Links',
    20 => 'Angeklickt',
    21 => 'Es gibt keine Links oder sie wurden von niemandem angeklickt.',
    22 => 'Top Ten der verschickten Artikel',
    23 => 'E-Mails',
    24 => 'Es wurden keine Artikel per E-Mail verschickt.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Zum Thema',
    2 => 'An einen Freund schicken',
    3 => 'Druckfähige Version',
    4 => 'Optionen',
    5 => 'Als PDF'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => 'To submit a %s you are required to be logged in as a user.',
    2 => 'Anmelden',
    3 => 'Neuer User',
    4 => 'Einen Termin einreichen',
    5 => 'Einen Link einreichen',
    6 => 'Einen Artikel einreichen',
    7 => 'Anmeldung erforderlich',
    8 => 'Abschicken',
    9 => 'Wenn Du Informationen einreichen möchtest, die auf dieser Site veröffentlicht werden sollen, dann bitten wir Dich, folgende Punkte zu beachten:<ul><li>Bitte alle Felder ausfüllen, sie werden benötigt<li>Bitte nur vollständige und exakte Informationen einreichen<li>URLs vor dem Abschicken unbedingt noch einmal kontrollieren</ul>',
    10 => 'Titel',
    11 => 'Link',
    12 => 'Startdatum',
    13 => 'Enddatum',
    14 => 'Ort',
    15 => 'Beschreibung',
    16 => 'oder andere Kategorie',
    17 => 'Kategorie',
    18 => 'Andere',
    19 => 'Bitte lesen',
    20 => 'Fehler: Kategorie fehlt',
    21 => 'Wenn Du "Andere" auswählst, gib bitte auch eine neue Kategorie ein',
    22 => 'Fehler: Nicht alle Felder ausgefüllt',
    23 => 'Bitte alle Felder des Formulars ausfüllen. Alle Felder werden benötigt.',
    24 => 'Beitrag gespeichert',
    25 => 'Dein %s-Beitrag wurde gespeichert.',
    26 => 'Speed Limit',
    27 => 'Username',
    28 => 'Kategorie',
    29 => 'Artikel',
    30 => 'Dein letzter Beitrag war vor ',
    31 => " Sekunden. Zwischen zwei Beiträgen müssen aber mindestens {$_CONF['speedlimit']} Sekunden vergangen sein.",
    32 => 'Vorschau',
    33 => 'Artikelvorschau',
    34 => 'Abmelden',
    35 => 'HTML-Tags sind nicht erlaubt',
    36 => 'Format',
    37 => "Wenn Du einen Termin bei {$_CONF['site_name']} einreichst, wird er in den Master-Kalender aufgenommen, von wo aus ihn andere User in ihren persönlichen Kalender übernehmen können. Dies ist <b>NICHT</b> dazu gedacht, private Termine und Ereignisse wie etwa Geburtstage zu verwalten.<br><br>Wenn Du einen Termin einreichst, wird er an die Administratoren weitergeleitet und sobald er von diesen akzeptiert wird, wird er im Master-Kalender erscheinen.",
    38 => 'Termin hinzufügen zu',
    39 => 'Master-Kalender',
    40 => 'Persönlicher Kalender',
    41 => 'Endzeit',
    42 => 'Startzeit',
    43 => 'Ganztägiger Termin',
    44 => 'Addresse, Zeile 1',
    45 => 'Addresse, Zeile 2',
    46 => 'Stadt',
    47 => 'Bundesland',
    48 => 'Postleitzahl',
    49 => 'Art des Termins',
    50 => 'Edit Termin Types',
    51 => 'Ort',
    52 => 'Löschen',
    53 => 'Account anlegen'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => 'Bitte authentifizieren!',
    2 => 'Zugriff verweigert! Login-Information ungültig',
    3 => 'Ungültiges Passwort für User',
    4 => 'Username:',
    5 => 'Passwort:',
    6 => 'Zugriffe auf die Administrationsseiten dieser Website werden aufgezeichnet und kontrolliert.<br>Diese Seiten sind nur für befugte Personen zugänglich.',
    7 => 'einloggen'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => 'Ungenügende Rechte',
    2 => 'Du hast nicht die nötigen Rechte, um diesen Block ändern zu können.',
    3 => 'Block-Editor',
    4 => 'Beim Lesen dieses Feeds trat ein Fehler auf (die Datei error.log enthält nähere Informationen).',
    5 => 'Block-Titel',
    6 => 'Kategorie',
    7 => 'Alle',
    8 => 'Block-Sicherheitsstufe',
    9 => 'Reihenfolge',
    10 => 'Block-Typ',
    11 => 'Portal-Block',
    12 => 'Normaler Block',
    13 => 'Portal-Block: Optionen',
    14 => 'RSS-URL',
    15 => 'Letztes Update',
    16 => 'Normaler Block: Optionen',
    17 => 'Inhalt',
    18 => 'Bitte ausfüllen: Block-Titel, Sicherheitsstufe und Inhalt',
    19 => 'Block-Manager',
    20 => 'Titel',
    21 => 'Block-Sichh.',
    22 => 'Typ',
    23 => 'Reihenfolge',
    24 => 'Kategorie',
    25 => 'Um einen Block zu ändern oder löschen, auf den Block (s.u.) klicken. Um einen neuen Block anzulegen, auf Neuer Block (s.o.) klicken.',
    26 => 'Layout-Block',
    27 => 'PHP-Block',
    28 => 'PHP-Block: Optionen',
    29 => 'Block-Funktion',
    30 => 'Wenn einer Deiner Blöcke PHP-Code verwenden soll, gib hier bitte den Namen der Funktion ein. Der Funktionsname muss mit "phpblock_" (z.B. phpblock_getweather) beginnen. Wenn sie diese Namenskonvention nicht einhält, wird die Funktion NICHT aufgerufen. Das soll verhindern, dass Hacker evtl. gefährlichen Code einschleusen können. Den Funktionsnamen NICHT mit einem Klammerpaar "()" abschliessen. Ferner wird empfohlen, all Deinen Code für PHP-Blöcke in der Datei /pfad/zu/geeklog/system/lib-custom.php abzulegen. Dort kann der Code auch dann unverändert bleiben, wenn Du auf eine neuere Geeklog-Version umsteigst.',
    31 => 'Fehler in PHP-Block: Funktion %s existiert nicht.',
    32 => 'Fehler: Nicht alle Felder ausgefüllt',
    33 => 'Für Portal-Blöcke muss ein Titel und eine URL zur RSS-Datei angegeben werden.',
    34 => 'Für PHP-Blöcke muss ein Titel und der Funktionsname eingegeben werden.',
    35 => 'Für normale Blöcke muss ein Titel und der Inhalt eingegeben werden.',
    36 => 'Für Layout-Blöcke muss der Inhalt eingegeben werden.',
    37 => 'Ungültiger Funktionsname für einen PHP-Block',
    38 => 'Funktionen für PHP-Blöcke müssen mit \'phpblock_\' beginnen (z.B. phpblock_getweather). Der \'phpblock_\'-Teil wird aus Sicherheitsgründen vorausgesetzt, um das Ausführen von beliebigem Code zu verhindern.',
    39 => 'Seite',
    40 => 'links',
    41 => 'rechts',
    42 => 'Für Geeklog-Default-Blöcke muss ein Block-Title und die Block-Reihenfolge angegeben werden.',
    43 => 'Nur auf der Startseite',
    44 => 'Zugriff verweigert',
    45 => "Du hast keine Zugriffsrechte für diesen Block. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/block.php\">Zurück zum Administrator-Menü</a>.",
    46 => 'Neuer Block',
    47 => 'Admin Home',
    48 => 'Block-Name',
    49 => ' (keine Leerzeichen, muss eindeutig sein)',
    50 => 'URL zur Hilfe',
    51 => '(mit http://)',
    52 => 'Wenn das Feld leer ist, wird kein Hilfe-Icon zu diesem Block angezeigt.',
    53 => 'Aktiv',
    54 => 'Speichern',
    55 => 'Abbruch',
    56 => 'Löschen',
    57 => 'Block nach unten',
    58 => 'Block nach oben',
    59 => 'Block auf die rechte Seite',
    60 => 'Block auf die linke Seite'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => 'Termin-Editor',
    2 => 'Error',
    3 => 'Titel',
    4 => 'URL',
    5 => 'Startdatum',
    6 => 'Enddatum',
    7 => 'Ort',
    8 => 'Beschreibung',
    9 => '(mit http://)',
    10 => 'Es müssen mindestens Datum und Uhrzeit, Titel und Beschreibung angegeben werden!',
    11 => 'Termin-Manager',
    12 => 'Auf einen Termin klicken, um ihn zu ändern oder löschen. Mit Neuer Termin (s.o.) wird ein neuer Termin angelegt. [C] erzeugt eine Kopie eines vorhandenen Termins.',
    13 => 'Titel',
    14 => 'Startdatum',
    15 => 'Enddatum',
    16 => 'Zugriff verweigert',
    17 => "Du hast keine Zugriffsrechte für diesen Termin. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/event.php\">Zurück zum Administrator-Menü</a>.",
    18 => 'Neuer Termin',
    19 => 'Admin Home',
    20 => 'Speichern',
    21 => 'Abbruch',
    22 => 'Löschen',
    23 => 'Ungültiges Startdatum.',
    24 => 'Ungültiges Enddatum.',
    25 => 'Enddatum ist vor dem Startdatum.'
);

###############################################################################
# admin/link.php

$LANG23 = array(
    1 => 'Link-Editor',
    2 => '',
    3 => 'Titel',
    4 => 'URL',
    5 => 'Kategorie',
    6 => '(mit http://)',
    7 => 'Andere',
    8 => 'Treffer',
    9 => 'Beschreibung',
    10 => 'Du musst einen Titel, eine URL und eine Beschreibung für den Link angeben.',
    11 => 'Link-Manager',
    12 => 'Auf den Link-Titel klicken, um einen Link zu ändern oder zu löschen. Mit Neuer Link (s.o.) kann ein neuer Link angelegt werden.',
    13 => 'Titel',
    14 => 'Kategorie',
    15 => 'URL',
    16 => 'Zugriff verweigert',
    17 => "Du hast keine Zugriffsrechte für diesen Link. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/link.php\">Zurück zum Administrator-Menü</a>.",
    18 => 'Neuer Link',
    19 => 'Admin Home',
    20 => 'Andere bitte eingeben',
    21 => 'Speichern',
    22 => 'Abbruch',
    23 => 'Löschen'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => 'Vorherige Artikel',
    2 => 'Nächste Artikel',
    3 => 'Modus',
    4 => 'Format',
    5 => 'Artikel-Editor',
    6 => 'Es sind keine Artikel vorhanden.',
    7 => 'Autor',
    8 => 'Speichern',
    9 => 'Vorschau',
    10 => 'Abbruch',
    11 => 'Löschen',
    12 => 'ID',
    13 => 'Titel',
    14 => 'Kategorie',
    15 => 'Datum',
    16 => 'Einleitung',
    17 => 'Haupttext',
    18 => 'Treffer',
    19 => 'Kommentare',
    20 => '',
    21 => '',
    22 => 'Artikel-Liste',
    23 => 'Auf die Nummer klicken, um einen Artikel zu ändern oder zu löschen. Um einen Artikel anzusehen, auf dessen Titel klicken. Auf Neuer Artikel (s.o.) klicken, um einen neuen Artikel zu schreiben.',
    24 => 'The ID you chose for this story is already in use. Please use another ID.',
    25 => '',
    26 => 'Artikel-Vorschau',
    27 => '',
    28 => '',
    29 => '',
    30 => 'Fehler beim Datei-Upload',
    31 => 'Bitte mindestens die Felder Titel und Einleitung ausfüllen',
    32 => 'Hauptartikel',
    33 => 'Es kann nur einen Hauptartikel geben',
    34 => 'Entwurf',
    35 => 'Ja',
    36 => 'Nein',
    37 => 'Mehr von',
    38 => 'Mehr aus',
    39 => 'E-Mails',
    40 => 'Zugriff verweigert',
    41 => "Du hast keine Zugriffsrechte für diesen Artikel. Dieser Zugriffsversuch wurde protokolliert. Du kannst Dir den Artikel aber ansehen (s.u., Ändern nicht möglich). <a href=\"{$_CONF['site_admin_url']}/story.php\">Zurück zum Administrator-Menü</a>.",
    42 => "Du hast keine Zugriffsrechte für diesen Artikel. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/story.php\">Zurück zum Administrator-Menü</a>.",
    43 => 'Neuer Artikel',
    44 => 'Admin Home',
    45 => 'Zugriff',
    46 => '<b>HINWEIS:</b> Wenn Du hier ein Datum in der Zukunft einstellst, wird der Artikel erst veröffentlicht, wenn dieser Zeitpunkt erreicht ist. Bis dahin wird der Artikel auch nicht in der RSS-Datei, der Suche und der Statistik erscheinen.',
    47 => 'Bilder',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => '<p>Die oben ausgewählten Bilder können im Artikel verwendet werden, indem dafür spezielle Platzhalter in den Text eingefügt werden. Diese Platzhalter sind [imageX], [imageX_right] und [imageX_left], wobei statt des X jeweils die Nummer des Bildes eingetragen werden muss.<br>HINWEIS: Es müssen alle ausgewählten Bilder verwendet werden. Andernfalls kann der Artikel nicht gespeichert werden.</p><p><strong>VORSCHAU:</strong> Der Vorschau-Button sollte nur verwendet werden, wenn der Artikel keine Bilder enthält. Bei Artikeln mit Bildern empfiehlt es sich, den Artikel als Entwurf zu markieren, zu speichern und dann von der Liste der Artikel aus zu betrachten.</p>',
    52 => 'Löschen',
    53 => 'wurde nicht verwendet. Du musst dieses Bild im Text des Artikels verwenden oder es löschen bevor Du Deine Änderungen sichern kannst.',
    54 => 'Nicht verwendete Bilder',
    55 => 'Folgende Fehler traten beim Versuch, den Artikel zu speichern, auf. Bitte diese Fehler beheben und den Artikel noch einmal speichern.',
    56 => 'mit Icon',
    57 => 'Bild in Originalgröße',
    58 => 'Artikel-Verwaltung',
    59 => 'Option',
    60 => 'Aktiviert',
    61 => 'automatisch archivieren',
    62 => 'automatisch löschen'
);

###############################################################################
# admin/poll.php

$LANG25 = array(
    1 => 'Modus',
    2 => 'Bitte eine Frage und mindestens eine Antwort eingeben.',
    3 => 'angelegt',
    4 => 'Umfrage %s wurde gespeichert',
    5 => 'Umfrage editieren',
    6 => 'Umfrage-ID',
    7 => '(keine Leerzeichen!)',
    8 => 'Erscheint auf der Startseite',
    9 => 'Frage',
    10 => 'Antworten / Stimmen',
    11 => 'Beim Abrufen der Stimmen von Umfrage %s trat ein Fehler auf.',
    12 => 'Beim Abrufen der Fragen von Umfrage %s trat ein Fehler auf.',
    13 => 'Umfrage anlegen',
    14 => 'Speichern',
    15 => 'Abbruch',
    16 => 'Löschen',
    17 => 'Bitte eine Umfrage-ID eingeben.',
    18 => 'Liste der Umfragen',
    19 => 'Um eine Umfrage zu ändern oder löschen, auf die Umfrage klicken. Mit Neue Umfrage (s.o.) wird eine neue Umfrage angelegt.',
    20 => 'Stimmen',
    21 => 'Zugriff verweigert',
    22 => "Du hast keine Zugriffsrechte für diese Umfrage. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/poll.php\">Zurück zum Administrator-Menü</a>.",
    23 => 'Neue Umfrage',
    24 => 'Admin Home',
    25 => 'Ja',
    26 => 'Nein'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => 'Kategorie-Editor',
    2 => 'Kategorie-ID',
    3 => 'Kategorie-Name',
    4 => 'Kategorie-Bild',
    5 => '(keine Leerzeichen!)',
    6 => 'Löschen einer Kategorie löscht auch alle dazu gehörenden Artikel und Blöcke',
    7 => 'Bitte die Felder Kategorie-ID und Kategorie-Name ausfüllen',
    8 => 'Kategorie-Manager',
    9 => 'Auf eine Kategorie klicken, um sie zu ändern oder löschen. Auf Neue Kategorie (s.o.) klicken, um eine neue Kategorie anzulegen. Die nötige Zugriffsberechtigung wird in Klammern hinter der Kategorie angegeben. Das Sternchen(*) markiert die Default-Kategorie.',
    10 => 'Sortierreihenfolge',
    11 => 'Artikel/Seite',
    12 => 'Zugriff verweigert',
    13 => "Du hast keine Zugriffsrechte für diese Kategorie. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/topic.php\">Zurück zum Administrator-Menü</a>.",
    14 => 'Sortiermethode',
    15 => 'alphabetisch',
    16 => 'Default:',
    17 => 'Neue Kategorie',
    18 => 'Admin Home',
    19 => 'Speichern',
    20 => 'Abbruch',
    21 => 'Löschen',
    22 => 'Default',
    23 => 'Zur Default-Kategorie für neue Artikel machen',
    24 => '(*)',
    25 => 'Archiv-Kategorie',
    26 => 'Zur Archiv-Kategorie machen (nur für eine Kategorie möglich).'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => 'User-Editor',
    2 => 'User-ID',
    3 => 'Username',
    4 => 'Name',
    5 => 'Passwort',
    6 => 'Security Level',
    7 => 'E-Mail-Adresse',
    8 => 'Homepage',
    9 => '(keine Leerzeichen!)',
    10 => 'Bitte die Felder Username und E-Mail-Adresse ausfüllen.',
    11 => 'User-Manager',
    12 => 'Auf den Usernamen klicken, um einen User zu ändern oder zu löschen. Ein neuer User kann mit dem Button Neuer User angelegt werden. Es gibt auch eine einfache Suchfunktion, mit der nach Teilen von Usernamen, E-Mail-Adressen oder richtigen Namen gesucht werden kann (z.B. *son* oder *.de).',
    13 => 'SecLev',
    14 => 'Reg. Datum',
    15 => 'Neuer User',
    16 => 'Admin Home',
    17 => 'pw ändern',
    18 => 'Abbruch',
    19 => 'Löschen',
    20 => 'Speichern',
    21 => 'Dieser Username existiert bereits.',
    22 => 'Fehler',
    23 => 'Import',
    24 => 'Mehrfach-Import von Usern',
    25 => 'Hier können Userdaten aus einer Datei in Geeklog importiert werden. Die Import-Datei muss ein Textfile sein, bei dem die Datensätze durch Tabs getrennt sind. Zudem müssen die Felder in der Reihenfolge Richtiger Name - Username - E-Mail-Adresse vorliegen. Jeder so importierte User bekommt eine E-Mail mit einem Zufallspasswort zugeschickt. Pro Zeile darf nur ein User stehen. Wenn sich die Importdatei nicht an dieses Format hält, kann es zu Problemen kommen, die nur in mühseliger Handarbeit behoben werden können. Also die Einträge lieber zweimal überprüfen ...',
    26 => 'Suche',
    27 => 'Anzahl Treffer',
    28 => 'Ankreuzen, um dieses Bild zu löschen:',
    29 => 'Pfad',
    30 => 'Importieren',
    31 => 'Neue User',
    32 => 'Datei bearbeitet. %d User wurden importiert, dabei traten %d Fehler auf.',
    33 => 'Abschicken',
    34 => 'Fehler: Keine Datei zum Upload angegeben.',
    35 => 'Letzter Login',
    36 => '(noch nie)'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => 'Akzeptieren',
    2 => 'Löschen',
    3 => 'Editieren',
    4 => 'Profil',
    10 => 'Titel',
    11 => 'Startdatum',
    12 => 'URL',
    13 => 'Kategorie',
    14 => 'Datum',
    15 => 'Kategorie',
    16 => 'Username',
    17 => 'Name',
    18 => 'E-Mail',
    34 => 'Kommandozentrale',
    35 => 'Beiträge: Artikel',
    36 => 'Beiträge: Links',
    37 => 'Beiträge: Termine',
    38 => 'Abschicken',
    39 => 'Derzeit gibt es keine Beiträge zu moderieren.',
    40 => 'Neue User'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Sonntag',
    2 => 'Montag',
    3 => 'Dienstag',
    4 => 'Mittwoch',
    5 => 'Donnerstag',
    6 => 'Freitag',
    7 => 'Samstag',
    8 => 'Neuer Termin',
    9 => 'Termin',
    10 => 'Termine am',
    11 => 'Master-Kalender',
    12 => 'Mein Kalender',
    13 => 'Januar',
    14 => 'Februar',
    15 => 'März',
    16 => 'April',
    17 => 'Mai',
    18 => 'Juni',
    19 => 'Juli',
    20 => 'August',
    21 => 'September',
    22 => 'Oktober',
    23 => 'November',
    24 => 'Dezember',
    25 => 'Zurück zum ',
    26 => 'ganztägig',
    27 => 'Woche',
    28 => 'Persönlicher Kalender für',
    29 => 'Öffentlicher Kalender',
    30 => 'Termin löschen',
    31 => 'Hinzufügen',
    32 => 'Termin',
    33 => 'Datum',
    34 => 'Uhrzeit',
    35 => 'Neuer Termin',
    36 => 'Submit',
    37 => 'Sorry, der persönliche Kalender ist auf dieser Site nicht verfügbar.',
    38 => 'Persönlicher Termin-Editor',
    39 => 'Tag',
    40 => 'Woche',
    41 => 'Monat'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} Mail Utility",
    2 => 'Von',
    3 => 'Reply-to',
    4 => 'Betreff',
    5 => 'Text',
    6 => 'Senden',
    7 => 'Alle User',
    8 => 'Admin',
    9 => 'Optionen',
    10 => 'HTML',
    11 => 'Wichtige Nachricht!',
    12 => 'Abschicken',
    13 => 'Reset',
    14 => 'User-Einstellungen ignorieren',
    15 => 'Fehler beim Senden an: ',
    16 => 'E-Mail erfolgreich gesendet an: ',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>Noch eine Nachricht schreiben</a>",
    18 => 'An',
    19 => 'HINWEIS: Wenn Du eine Nachricht an alle eingetragenen Benutzer schicken willst, musst Du die Gruppe Logged-in Users auswählen.',
    20 => "<successcount> Nachricht(en) erfolgreich verschickt, bei <failcount> Nachricht(en) traten Fehler auf. Details können der folgenden Liste entnommen werden. Du kannst jetzt <a href=\"{$_CONF['site_admin_url']}/mail.php\">noch eine Nachricht schicken</a> oder <a href=\"{$_CONF['site_admin_url']}/moderation.php\">zurück zum Admin-Menü gehen</a>.",
    21 => 'Fehler',
    22 => 'Erfolgreich',
    23 => 'Keine Fehler',
    24 => 'Keine erfolgreich',
    25 => '-- Gruppe wählen --',
    26 => 'Um eine E-Mail verschicken zu können, müssen alle Felder ausgefüllt und eine Gruppe von Benutzern aus dem Drop-Down-Menü ausgewählt werden.'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => 'Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href="http://www.geeklog.net/">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.',
    2 => 'Plugin-Installation -- Disclaimer',
    3 => 'Plugin-Installationsformular',
    4 => 'Plugin-Datei',
    5 => 'Plugin-Liste',
    6 => 'Warnung: Plugin schon installiert!',
    7 => 'Das Plugin, das Du installieren willst, ist schon vorhanden. Bitte lösche es, bevor Du noch einmal versuchst, es zu installieren',
    8 => 'Plugin-Kompatibilitätstest fehlgeschlagen',
    9 => 'Dieses Plugin benötigt eine neuere Version von Geeklog. Abhilfe schafft ein Update von <a href="http://www.geeklog.net/">Geeklog</a> oder evtl. eine andere Version dieses Plugins.',
    10 => '<br><b>Es sind derzeit keine Plugins installiert.</b><br><br>',
    11 => 'Um ein Plugin zu ändern oder löschen, auf die Nummer des Plugins klicken. Wenn Du auf den Namen des Plugins klickst, wird die Homepage des Plugins aufgerufen. Um ein Plugin zu installieren oder aktualisieren bitte dessen Dokumentation lesen.',
    12 => '(kein Name angegeben)',
    13 => 'Plugin-Editor',
    14 => 'Neues Plugin',
    15 => 'Admin Home',
    16 => 'Name des Plugins',
    17 => 'Plugin-Version',
    18 => 'Geeklog-Version',
    19 => 'Aktiv',
    20 => 'Ja',
    21 => 'Nein',
    22 => 'Installieren',
    23 => 'Speichern',
    24 => 'Abbruch',
    25 => 'Löschen',
    26 => 'Name des Plugins',
    27 => 'Plugin-Homepage',
    28 => 'Plugin-Version',
    29 => 'Geeklog-Version',
    30 => 'Plugin löschen?',
    31 => 'Bist Du sicher, dass Du dieses Plugin löschen willst? Dies wird alle Daten und Datenstrukturen löschen, die dieses Plugin benutzt. Wenn Du sicher bist, dann klicke jetzt bitte noch einmal auf Löschen.',
    32 => '<p><b>Fehler: Ungültiges Format für Autolink.</b></p>',
    33 => 'Code-Version',
    34 => 'Aktualisieren'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => 'Feed anlegen',
    2 => 'Speichern',
    3 => 'Löschen',
    4 => 'Abbruch',
    10 => 'Content Syndication',
    11 => 'Neuer Feed',
    12 => 'Admin Home',
    13 => 'Um einen Feed zu ändern oder zu löschen, auf den Titel des Feeds (s.u.) klicken. Um einen neuen Feed anzulegen, auf Neuer Feed (s.o.) klicken.',
    14 => 'Titel',
    15 => 'Art',
    16 => 'Dateiname',
    17 => 'Format',
    18 => 'letztes Update',
    19 => 'Aktiv',
    20 => 'Ja',
    21 => 'Nein',
    22 => '<i>(keine Feeds)</i>',
    23 => 'alle Artikel',
    24 => 'Feed-Editor',
    25 => 'Feed-Titel',
    26 => 'Limit',
    27 => 'Länge d. Einträge',
    28 => '(0 = ohne Text, 1 = kompletter Text, anderer Wert = nur so viele Zeichen)',
    29 => 'Beschreibung',
    30 => 'Letztes Update',
    31 => 'Zeichensatz',
    32 => 'Sprache',
    33 => 'Inhalt',
    34 => 'Einträge',
    35 => 'Stunden',
    36 => 'Art des Feeds festlegen',
    37 => 'Du hast (mindestens) ein Plugin installiert, das Content Syndication unterstützt. Bitte wähle zunächst aus, ob Du einen Feed für Geeklog oder für ein Plugin anlegen willst.',
    38 => 'Fehler: Nicht alle Felder ausgefüllt',
    39 => 'Bitte die Felder Feed-Titel, Beschreibung und Dateiname ausfüllen.',
    40 => 'Bitte ein Limit (Anzahl Einträge oder Anzahl Stunden) eingeben.',
    41 => 'Links',
    42 => 'Termine'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Dein Passwort sollte in Kürze per E-Mail bei Dir eintreffen. Bitte beachte die Hinweise in der E-Mail. Danke, dass Du Dich bei {$_CONF['site_name']} angemeldet hast.",
    2 => "Danke für Deinen Beitrag zu {$_CONF['site_name']}. Dein Artikel wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald auf dieser Website für alle Besucher zu lesen sein.",
    3 => "Danke für Deinen Beitrag zu {$_CONF['site_name']}. Dein Link wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald unter den <a href=\"{$_CONF['site_url']}/links.php\">Links</a> aufgelistet werden.",
    4 => "Danke für Deinen Beitrag zu {$_CONF['site_name']}. Dein Termin wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald in unserem <a href=\"{$_CONF['site_url']}/calendar.php\">Kalender</a> erscheinen.",
    5 => 'Dein User-Profil wurde gespeichert.',
    6 => 'Deine Einstellungen wurden gespeichert.',
    7 => 'Deine Kommentar-Einstellungen wurden gespeichert.',
    8 => 'Abmeldung erfolgt. Du bist jetzt nicht mehr angemeldet.',
    9 => 'Dein Artikel wurde gespeichert.',
    10 => 'Der Artikel wurde gelöscht.',
    11 => 'Dein Block wurde gespeichert.',
    12 => 'Der Block wurde gelöscht.',
    13 => 'Deine Kategorie wurde gespeichert.',
    14 => 'Die Kategorie und alle zugehörigen Artikel wurden gelöscht.',
    15 => 'Dein Link wurde gespeichert.',
    16 => 'Der Link wurde gelöscht.',
    17 => 'Dein Termin wurde gespeichert.',
    18 => 'Der Termin wurde gelöscht.',
    19 => 'Deine Umfrage wurde gespeichert.',
    20 => 'Die Umfrage wurde gelöscht.',
    21 => 'Der User wurde gespeichert.',
    22 => 'Der User wurde gelöscht.',
    23 => 'Der Termin konnte nicht in Deinen persönlichen Kalender übernommen werden. Es wurde keine ID übergeben oder der Termin wurde nicht gefunden.',
    24 => 'Der Termin wurde in Deinen Kalender eingetragen.',
    25 => 'Du musst angemeldet sein, um auf Deinen persönlichen Kalender zugreifen zu können.',
    26 => 'Der Termin wurde aus Deinem persönlichen Kalender entfernt',
    27 => 'Nachricht wurde verschickt.',
    28 => 'Das Plugin wurde gespeichert.',
    29 => 'Sorry, persönliche Kalender sind auf dieser Site nicht verfügbar.',
    30 => 'Zugriff verweigert',
    31 => 'Du hast keinen Zugriff auf diese Artikel-Administrationsseite. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    32 => 'Du hast keinen Zugriff auf diese Kategorie-Administrationsseite. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    33 => 'Du hast keinen Zugriff auf diese Block-Administrationsseite. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    34 => 'Du hast keinen Zugriff auf diese Links-Administrationsseite. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    35 => 'Du hast keinen Zugriff auf diese Termin-Administrationsseite. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    36 => 'Du hast keinen Zugriff auf diese Umfrage-Administrationsseite. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    37 => 'Du hast keinen Zugriff auf diese User-Administrationsseite. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    38 => 'Du hast keinen Zugriff auf diese Plugin-Administrationsseite. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    39 => 'Du hast keinen Zugriff auf diese E-Mail-Administrationsseite. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    40 => 'System-Nachricht',
    41 => 'Sorry, you do not have access to the word replacement page.  Please not that all attempts to access unauthorized features are logged',
    42 => 'Your word has been successfully saved.',
    43 => 'The word has been successfully deleted.',
    44 => 'Das Plugin wurde erfolgreich installiert.',
    45 => 'Das Plugin wurde gelöscht.',
    46 => 'Du hast keinen Zugriff auf die Backup-Funktion. Alle Versuche, auf Features ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    47 => 'This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.',
    48 => "Danke, dass Du dich bei {$_CONF['site_name']} angemeldet hast. Dein Aufnahmeantrag wird von unserem Team geprüft. Sobald er akzeptiert wird, wirst Du Dein Passwort per E-Mail erhalten.",
    49 => 'Deine Gruppe wurde gespeichert.',
    50 => 'Die Gruppe wurde gelöscht.',
    51 => 'Dieser Username ist schon vergeben. Bitte wähle einen anderen.',
    52 => 'Die angegebene E-Mail-Adresse scheint nicht gültig zu sein.',
    53 => 'Dein neues Passwort wurde gespeichert. Bitte melde Dich nun mit dem neuen Passwort an.',
    54 => 'Diese Anfrage für ein neues Passwort ist nicht mehr gültig. Bitte fordere erneut ein neues Passwort an.',
    55 => 'Du solltest in Kürze eine E-Mail erhalten, in der beschrieben wird, wie Du ein neues Passwort für Deinen Account eingeben kannst.',
    56 => 'Die angegebene E-Mail-Adresse wird schon für einen anderen Account verwendet.',
    57 => 'Dein Account wurde gelöscht.',
    58 => 'Der Feed wurde gespeichert.',
    59 => 'Der Feed wurde gelöscht.',
    60 => 'Das Plugin wurde erfolgreich aktualisiert.',
    61 => 'Plugin %s: Unbekannter Text-Platzhalter'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => 'Zugriff',
    'ownerroot' => 'Eigent./Root',
    'group' => 'Gruppe',
    'readonly' => 'Nur Lesen',
    'accessrights' => 'Zugriffsrechte',
    'owner' => 'Eigent.',
    'grantgrouplabel' => 'Grant Above Group Edit Rights',
    'permmsg' => 'Hinweis: Mitglieder meint alle eingeloggten Mitglieder und Gast steht für alle nicht eingeloggten Besucher.',
    'securitygroups' => 'Security-Gruppen',
    'editrootmsg' => "Obwohl Du ein User-Administrator bist, kannst Du die Informationen von Usern in der Root-Gruppe nicht ändern, ohne selbst Mitglied der Root-Gruppe zu sein. Du kannst die Informationen aller anderen User bearbeiten, nur nicht die der Mitglieder der Root-Gruppe. Beachte bitte, dass alle derartigen Versuche protokolliert werden. <a href=\"{$_CONF['site_admin_url']}/user.php\">Zurück zur User-Admin-Seite</a>.",
    'securitygroupsmsg' => 'Mit den Checkboxen kannst Du festlegen, zu welchen Gruppen dieser User gehört.',
    'groupeditor' => 'Gruppen-Editor',
    'description' => 'Beschreibung',
    'name' => 'Name',
    'rights' => 'Rechte',
    'missingfields' => 'Fehlende Angaben',
    'missingfieldsmsg' => 'Du musst den Namen und eine Beschreibung für die Gruppe angeben.',
    'groupmanager' => 'Gruppen-Manager',
    'newgroupmsg' => 'Um eine Gruppe zu ändern oder löschen, einfach auf den Namen der Gruppe klicken. Neue Gruppe (s.o.) legt eine neue Gruppe an. Hinweis: Core-Gruppen können nicht gelöscht werden, da sie vom System benötigt werden.',
    'groupname' => 'Gruppen-Name',
    'coregroup' => 'Core-Gruppe',
    'yes' => 'Ja',
    'no' => 'Nein',
    'corerightsdescr' => "Diese Gruppe ist eine Core-Gruppe auf {$_CONF['site_name']}. Die Rechte dieser Gruppe können daher nicht geändert werden. Das Folgende ist eine (nicht veränderbare) Liste der Rechte dieser Gruppe.",
    'groupmsg' => 'Security-Gruppen auf dieser Site sind hierarchisch organisiert. Wenn Du diese Gruppe zu einer der folgenden Gruppen hinzufügst, bekommt diese Gruppe die gleichen Rechte wie die unten ausgewählte(n). Wenn möglich, sollten Gruppenrechte durch Auswahl von Gruppen aus dieser Liste vergeben werden. Werden nur einzelne Rechte benötigt, können diese auch aus der Liste der Rechte weiter unten ausgewählt werden. Um diese Gruppe zu einer der folgenden hinzuzufügen, kannst Du die gewünschte(n) Gruppe(n) einfach anklicken.',
    'coregroupmsg' => "Diese Gruppe ist eine Core-Gruppe auf {$_CONF['site_name']}. Die Rechte dieser Gruppe können daher nicht geändert werden. Das Folgende ist eine (nicht veränderbare) Liste der Gruppen, zu der diese Gruppe gehört.",
    'rightsdescr' => 'Die folgenden Rechte können an eine Gruppe entweder direkt (durch Auswählen) oder indirekt vergeben werden (wenn die Gruppe zu einer anderen Gruppe gehört, die diese Rechte hat). Die im Folgenden aufgeführten Rechte ohne Checkbox sind indirekte Rechte, die von einer anderen Gruppe geerbt wurden, zu der die aktuelle Gruppe gehört. Alle anderen Rechte können hier direkt vergeben werden.',
    'lock' => 'Lock',
    'members' => 'Mitglieder',
    'anonymous' => 'Gast',
    'permissions' => 'Rechte',
    'permissionskey' => 'R = lesen, E = editieren, Editier-Rechte setzen Lese-Rechte voraus',
    'edit' => 'Edit',
    'none' => 'None',
    'accessdenied' => 'Zugriff verweigert',
    'storydenialmsg' => "Du hast nicht die nötigen Rechte, um diesen Artikel zu lesen. Möglicherweise bist Du kein registrierter User von {$_CONF['site_name']}. Bitte melde Dich als <a href=\"users.php?mode=new\">neuer User</a> von {$_CONF['site_name']} an um vollen Zugriff auf alle Bereiche zu bekommen.",
    'eventdenialmsg' => "Du hast nicht die nötigen Rechte, um diesen Termin abzurufen. Möglicherweise bist Du kein registrierter User von {$_CONF['site_name']}. Bitte melde Dich als <a href=\"users.php?mode=new\">neuer User</a> von {$_CONF['site_name']} an um vollen Zugriff auf alle Bereiche zu bekommen.",
    'nogroupsforcoregroup' => 'Diese Gruppe gehört zu keiner anderen Gruppe.',
    'grouphasnorights' => 'Diese Gruppe hat keine Rechte für die Administration der Website',
    'newgroup' => 'Neue Gruppe',
    'adminhome' => 'Admin Home',
    'save' => 'Speichern',
    'cancel' => 'Abbruch',
    'delete' => 'Löschen',
    'canteditroot' => 'Du hast versucht die Gruppe Root zu ändern, obwohl Du selbst nicht Mitglied dieser Gruppe bist. Der Zugriff wurde daher verweigert. Wende Dich bitte an den Systemadministrator wenn Du der Meinung bist, dass das ein Fehler wäre.',
    'listusers' => 'User',
    'listthem' => 'anzeigen',
    'usersingroup' => 'User in Gruppe "%s"',
    'usergroupadmin' => 'Usergruppen-Verwaltung',
    'add' => 'Hinzufügen',
    'remove' => 'Löschen',
    'availmembers' => 'Verfügbare Mitglieder',
    'groupmembers' => 'Mitglieder der Gruppe',
    'canteditgroup' => 'Um diese Gruppe bearbeiten zu können, musst Du selbst ein Mitglied der Gruppe sein. Wende Dich bitte an den Systemadministrator wenn Du der Meinung bist, dass das ein Fehler wäre.',
    'cantlistgroup' => 'Um die Mitglieder dieser Gruppe sehen zu können, musst Du selbst ein Mitglied der Gruppe sein. Wende Dich bitte an den Systemadministrator wenn Du der Meinung bist, dass das ein Fehler wäre.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Die 10 letzten Backups',
    'do_backup' => 'Backup anlegen',
    'backup_successful' => 'Backup der Datenbank war erfolgreich.',
    'no_backups' => 'Keine Backups im System',
    'db_explanation' => 'Um ein neues Backup Deines Geeklog-Systems anzulegen, einfach auf den folgenden Button klicken',
    'not_found' => "Falscher Pfad oder mysqldump ist nicht ausführbar.<br>Bitte überprüfe die Variable <strong>{$_DB_mysqldump_path}</strong> in der config.php.<br>Aktueller Wert der Variablen: <var>{$_DB_mysqldump_path}</var>",
    'zero_size' => 'Backup fehlgeschlagen: Datei ist 0 Bytes groß.',
    'path_not_found' => "{$_CONF['backup_path']} existiert nicht oder ist kein Verzeichnis.",
    'no_access' => "Fehler: Konnte nicht auf das Verzeichnis {$_CONF['backup_path']} zugreifen.",
    'backup_file' => 'Backup-Datei',
    'size' => 'Größe',
    'bytes' => 'Bytes',
    'total_number' => 'Gesamtanzahl Backups: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => 'Home',
    2 => 'Kontakt',
    3 => 'Mitmachen',
    4 => 'Links',
    5 => 'Umfragen',
    6 => 'Kalender',
    7 => 'Statistik',
    8 => 'Einstellungen',
    9 => 'Suchen',
    10 => 'Erweiterte Suche'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Fehler 404',
    2 => 'Hmm, ich habe alles versucht, aber <b>%s</b> war nicht aufzufinden.',
    3 => "<p>Sorry, diese Seite oder Datei existiert nicht. Du könntest es auf der <a href=\"{$_CONF['site_url']}\">Startseite</a> oder mit der <a href=\"{$_CONF['site_url']}/search.php\">Suchfunktion</a> probieren, vielleicht wirst Du ja fündig ..."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Anmeldung erforderlich',
    2 => 'Sorry, aber um auf diesen Bereich zugreifen zu können, musst Du als Benutzer angemeldet sein.',
    3 => 'Anmelden',
    4 => 'Neuer User'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'The PDF feature has been disabled',
    2 => 'The document provided was not rendered. The document was received but could not be processed.  Please make sure to submit only html formatted documents that have been written to the xHTML standard. Please note that overly complex html documents may not render correctly or at all.The document resulting from your attempt was 0 bytes in length, and has been deleted. If you\'re sure that your document should render fine, please re-submit it.',
    3 => 'Unknown error during PDF generation',
    4 => "No page data was given or you want to use the ad-hoc PDF generation tool below.  If you think you are getting this page\n          in error then please contact the system administrator.  Otherwise, you may use the form below to generate PDF's in an ad-hoc fashion.",
    5 => 'Loading your document.',
    6 => 'Please wait while your document is loaded.',
    7 => 'You may right click the button below and choose \'save target...\' or \'save link location...\' to save a copy of your document.',
    8 => "The path given in the configuration file to the HTMLDoc binary is invalid or this system cannot execute it.  Please contact the site administrator if this problem\n          persists.",
    9 => 'PDF Generator',
    10 => "This is the Ad-hoc PDF Generation tool. It will attempt to convert any URL you give into a PDF.  Please note that some web pages will not render properly with this feature.  This\n           is a limitation of the HTMLDoc PDF generation tool and such errors should not be reported to the administrators of this site",
    11 => 'URL',
    12 => 'Generate PDF!',
    13 => 'The PHP configuration on this server does not allow URLs to be used with the fopen() command.  The system administrator must edit the php.ini file and set allow_url_fopen to On',
    14 => 'The PDF you requested either does not exist or you tried to illegally access a file.'
);

?>
