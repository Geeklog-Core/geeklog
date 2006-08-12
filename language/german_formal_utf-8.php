<?php

###############################################################################
# german_formal_utf-8.php
#
# This is the German language file for Geeklog, addressing the user as "Sie"
# (formal German). See german.php for a language file addressing the user with
# the more informal "Du".
#
# Authors: P. Sack   <psack AT pr-ide DOT de>
#          Dirk Haun <dirk AT haun-online DOT de>
#
# Based on the original english.php, started by Jason Whittenburg.
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
    40 => 'Sie haben <tt>register_globals = Off</tt> in Ihrer <tt>php.ini</tt>. Für Geeklog muss <tt>register_globals</tt> jedoch auf <strong>on</strong> stehen. Bitte ändern Sie dies auf <strong>on</strong> und starten Sie Ihren Webserver neu.',
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
    54 => 'Konnte die Datei nicht öffnen.',
    55 => 'Fehler in',
    56 => 'Abstimmen',
    57 => 'Passwort',
    58 => 'Anmelden',
    59 => "Melden Sie sich jetzt als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">neuer User</a> an.",
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
    71 => 'Beitrag',
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
    113 => 'Dokumentation',
    114 => 'TRACKBACKS',
    115 => 'Keine neuen Trackback-Kommentare',
    116 => 'Trackback',
    117 => 'Verzeichnis',
    118 => 'Fortsetzung auf der nächsten Seite:',
    119 => "<a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">Passwort vergessen?</a>",
    120 => 'Permalink',
    121 => 'Kommentare (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'Alle HTML-Tags sind erlaubt'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => 'Kommentar schreiben',
    2 => 'Format',
    3 => 'Abmelden',
    4 => 'Account anlegen',
    5 => 'Username',
    6 => 'Um einen Kommentar abgeben zu können, müssen Sie angemeldet sein. Wenn Sie noch keinen Account haben, benutzen Sie bitte das Formular um einen anzulegen.',
    7 => 'Ihr letzter Kommentar war vor ',
    8 => " Sekunden. Zwischen zwei Kommentaren müssen aber mindestens {$_CONF['commentspeedlimit']} Sekunden vergangen sein.",
    9 => 'Kommentar',
    10 => 'Beitrag melden',
    11 => 'Kommentar abschicken',
    12 => 'Bitte die Felder Betreff <em>und</em> Kommentar ausfüllen, um einen Kommentar zu diesem Artikel abzugeben.',
    13 => 'Ihre Information',
    14 => 'Vorschau',
    15 => 'Diesen Beitrag melden',
    16 => 'Betreff',
    17 => 'Fehler',
    18 => 'Wichtige Hinweise:',
    19 => 'Bitte geben Sie nur Kommentare ab, die zum Thema gehören.',
    20 => 'Beziehen Sie sich möglichst auf Kommentare anderer Personen statt einen neuen Thread zu eröffnen.',
    21 => 'Lesen Sie bitte die vorhandenen Kommentare bevor Sie Ihren eigenen abgeben, um nicht noch einmal zu schreiben, was schon gesagt wurde.',
    22 => 'Benutzen Sie eine eindeutige Betreffzeile, die den Inhalt Ihres Kommentars zusammenfasst.',
    23 => 'Ihre E-Mail-Adresse wird NICHT veröffentlicht.',
    24 => 'Gast',
    25 => 'Sind Sie sicher, dass Sie diesen Beitrag als möglichen Missbrauch melden wollen?',
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
    14 => 'Dieses Passwort wurde mit einem Zufallsgenerator erzeugt. Es wird empfohlen, das Passwort nach dem Anmelden sofort zu ändern. Um Ihr Passwort zu ändern, melden Sie sich bitte an und wählen dann den Punkt Userprofil ändern im Block Einstellungen.',
    15 => "Ihr Account für {$_CONF['site_name']} wurde erfolgreich angelegt. Um ihn benutzen zu können, melden Sie sich bitte mit den folgenden Informationen an. Diese E-Mail bitte aufheben.",
    16 => 'Ihre Zugangsdaten',
    17 => 'Account existiert nicht',
    18 => 'Die angegebene E-Mail-Adresse scheint keine gültige E-Mail-Adresse zu sein',
    19 => 'Dieser Username oder diese E-Mail-Adresse existieren bereits.',
    20 => 'Die angegebene E-Mail-Adresse scheint keine gültige E-Mail-Adresse zu sein',
    21 => 'Fehler',
    22 => "Anmelden bei {$_CONF['site_name']}!",
    23 => "Indem Sie sich bei {$_CONF['site_name']} anmelden, können Sie Artikel und Kommentare unter Ihrem eigenen Namen veröffentlichen (andernfalls geht das nur anonym). Übrigens wird Ihre E-Mail-Adresse <strong><em>niemals</em></strong> auf dieser Website angezeigt werden.",
    24 => 'Ihr Passwort wird Ihnen an die angegebene E-Mail-Adresse geschickt.',
    25 => 'Passwort vergessen?',
    26 => 'Geben Sie <em>entweder</em> Ihren Usernamen <em>oder</em> die E-Mail-Adresse ein, mit der Sie sich angemeldet haben, und klicken Sie dann auf "Passwort schicken". Eine E-Mail mit einer Anleitung, wie Sie ein neues Passwort eingeben können, wird dann an die gespeicherte E-Mail-Adresse geschickt.',
    27 => 'Jetzt anmelden!',
    28 => 'Passwort schicken',
    29 => 'logged out from',
    30 => 'logged in from',
    31 => 'Um diese Funktion nutzen zu können, muüssen Sie angemeldet sein',
    32 => 'Signatur',
    33 => 'Auf der Site nicht sichtbar!',
    34 => 'Ihr richtiger Name',
    35 => 'Passwort eingeben, um es zu ändern',
    36 => '(mit http://)',
    37 => 'Wird an Ihre Kommentare angefügt',
    38 => 'Alles über Sie - für alle sichtbar',
    39 => 'Ihr PGP-Key, wenn vorhanden',
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
    50 => 'Häkchen entfernen, wenn es Sie nicht interessiert',
    51 => 'Nur die Artikel',
    52 => 'Defaultwert:',
    53 => 'Receive the days stories every night',
    54 => 'Themen und Autoren ankreuzen, die Sie NICHT sehen wollen.',
    55 => 'Wenn Sie hier nichts ankreuzen, wird die Default-Auswahl an Blöcken angezeigt. Sobald Sie anfangen, Blöcke anzukreuzen, werden auch nur noch diejenigen angezeigt, die angekreuzt sind! Die Default-Blöcke sind <b>fett</b> markiert.',
    56 => 'Autoren',
    57 => 'Anzeigemodus',
    58 => 'Sortierreihenfolge',
    59 => 'Kommentarlimit',
    60 => 'Wie sollen Kommentare angezeigt werden?',
    61 => 'Neueste oder älteste zuerst?',
    62 => 'Defaultwert: 100',
    63 => "Ihr Passwort sollte in Kürze per E-Mail eintreffen. Bitte beachten Sie die Hinweise in der E-Mail und Danke für Ihr Interesse an {$_CONF['site_name']}",
    64 => 'Kommentar-Einstellungen für',
    65 => 'Bitte versuchen Sie noch einmal, sich anzumelden',
    66 => "Haben Sie sich vertippt? Bitte versuchen Sie noch einmal, sich hier anzumelden.",
    67 => 'Mitglied seit',
    68 => 'Angemeldet für',
    69 => 'Wie lange soll das System Sie nach dem Anmelden erkennen?',
    70 => "Aussehen und Inhalt von {$_CONF['site_name']} konfigurieren",
    71 => "Zu den Features von {$_CONF['site_name']} gehört, dass Sie selbst festlegen können, welche Artikel Sie angezeigt bekommen. Darüber hinaus können Sie auch das Aussehen der Website verändern. Um in den Genuss dieser Features zu kommen, müssen Sie sich jedoch zuerst bei {$_CONF['site_name']} <a href=\"{$_CONF['site_url']}/users.php?mode=new\">anmelden</a>. Oder sind Sie schon angemeldet? Dann benutzen Sie bitte das Anmeldeformular auf der linken Seite.",
    72 => 'Erscheinungsbild',
    73 => 'Sprache',
    74 => 'Ändern Sie das Aussehen dieser Site',
    75 => 'Artikel per E-Mail für',
    76 => 'Wählen Sie Kategorien aus der folgenden Liste und Sie bekommen einmal pro Tag eine E-Mail mit einer Übersicht aller neuen Artikel in den ausgewählten Kategorien. Sie brauchen nur die Kategorien anzukreuzen, die Sie interessieren.',
    77 => 'Foto',
    78 => 'Ein Bild von Ihnen',
    79 => 'Ankreuzen, um dieses Bild zu löschen:',
    80 => 'Anmelden',
    81 => 'E-Mail schreiben',
    82 => 'Die letzten 10 Artikel von',
    83 => 'Statistik für',
    84 => 'Gesamtanzahl Artikel:',
    85 => 'Gesamtanzahl Kommentare',
    86 => 'Alle Artikel und Kommentare von',
    87 => 'Ihr Username',
    88 => "Jemand (möglicherweise Sie selbst) hat ein neues Passwort für Ihren Account \"%s\" auf {$_CONF['site_name']} <{$_CONF['site_url']}> angefordert.\n\nWenn Sie tatsächlich ein neues Passwort benötigen, klicken Sie bitte auf den folgenden Link:\n\n",
    89 => "Möchten Sie Ihr Passwort nicht ändern, so können Sie diese E-Mail einfach ignorieren (Ihr bisheriges Passwort bleibt dann unverändert gültig).\n\n",
    90 => 'Hier können Sie jetzt ein neues Passwort für Ihren Account eingeben. Ihr altes Passwort bleibt noch solange gültig, bis Sie dieses Formular abschicken.',
    91 => 'Neues Passwort',
    92 => 'Neues Passwort eingeben',
    93 => 'Sie haben zuletzt vor %d Sekunden ein neues Passwort angefordert. Zwischen zwei Passwort-Anforderungen müssen aber mindestens %d Sekunden vergangen sein.',
    94 => 'Account "%s" löschen',
    95 => 'Sie können Ihren Account löschen, indem Sie auf den "Account Löschen"-Button klicken. Artikel und Kommentare, die Sie unter diesem Account geschrieben haben, werden <strong>nicht</strong> gelöscht, werden aber fortan als vom User "Gast" geschrieben erscheinen.',
    96 => 'Account Löschen',
    97 => 'Account Löschen bestätigen',
    98 => 'Sind Sie sicher, dass Sie Ihren Account löschen wollen? Sie werden sich danach nicht mehr einloggen können (es sei denn, Sie legen einen neuen Account an). Wenn Sie sich sicher sind, klicken Sie bitte noch einmal auf "Account Löschen".',
    99 => 'Privatsphäre-Einstellungen für',
    100 => 'E-Mail von Admin',
    101 => 'E-Mails von Site-Admins erlauben',
    102 => 'E-Mail von Usern',
    103 => 'E-Mails von anderen Usern erlauben',
    104 => 'Online-Status zeigen',
    105 => 'Unter "Wer ist online?"',
    106 => 'Wohnort',
    107 => 'Erscheint im öffentlichen Profil',
    108 => 'Neues Passwort bestätigen',
    109 => 'Geben Sie hier das neue Passwort noch einmal ein',
    110 => 'Aktuelles Passwort',
    111 => 'Geben Sie Ihr aktuelles Passwort ein',
    112 => 'Sie haben die erlaubte Anzahl von Anmeldeversuchen überschritten. Bitte versuchen Sie es später noch einmal.',
    113 => 'Anmeldeversuch fehlgeschlagen',
    114 => 'Account gesperrt',
    115 => 'Ihr Account wurde gesperrt. Sie können sich nicht einloggen. Wenden Sie sich bitte an einen Administrator.',
    116 => 'Account noch nicht freigegeben',
    117 => 'Ihr Account muss erst noch von einem Administrator freigegeben werden. Sie können sich erst einloggen, wenn der Account freigegeben wurde.',
    118 => "Ihr Account für {$_CONF['site_name']} wurde jetzt freigeschaltet. Sie können sich jetzt auf der Website unter der unten angegebenen URL anmelden. Benutzen Sie dazu Ihren Usernamen (<username>) und das Passwort, das Sie bereits per E-Mail erhalten haben.",
    119 => 'Wenn Sie Ihr Passwort vergessen haben, können Sie unter der folgenden URL ein neues anfordern:',
    120 => 'Account aktiviert',
    121 => 'Dienst',
    122 => 'Derzeit können sich keine neuen User anmelden.',
    123 => "Sind Sie ein <a href=\"{$_CONF['site_url']}/users.php?mode=new\">neuer User</a>?",
    124 => 'E-Mail bestätigen',
    125 => 'Die E-Mail-Adressen stimmen nicht überein. Bitte in beiden Feldern die gleiche E-Mail-Adresse eintragen!',
    126 => 'Bitte die gleiche Adresse noch einmal eingeben',
    127 => 'Um diese Angaben zu ändern müssen Sie Ihr aktuelles Passwort eingeben.',
    128 => 'Ihr Name',
    129 => 'Passwort &amp; E-Mail',
    130 => 'Informationen über Sie',
    131 => 'Daily Digest Options',
    132 => 'Daily Digest Feature',
    133 => 'Comment Display',
    134 => 'Comment Options',
    135 => '<li>Default mode for how comments will be displayed</li><li>Default order to display comments</li><li>Set maximum number of comments to show - default is 100</li>',
    136 => 'Exclude Topics and Authors',
    137 => 'Filter Story Content',
    138 => 'Misc Settings',
    139 => 'Layout and Language',
    140 => '<li>No Topic Icons if checked will not display the story topic icons</li><li>No boxes if checked will only show the Admin Menu, User Menu and Top<li>Set the maximum number of stories to show per page</li><li>Set your theme and perferred date format</li>',
    141 => 'Privacy Settings',
    142 => 'The default setting is to allow users & admins to email fellow site members and show your status as online. Un-check these options to protect your privacy.',
    143 => 'Filter Block Content',
    144 => 'Show & hide boxes',
    145 => 'Your Public Profile',
    146 => 'Password and email',
    147 => 'Edit your account password, email and autologin feature. You will need to enter the same password or email address twice as a confirmation.',
    148 => 'User Information',
    149 => 'Modify your user information that will be shown to other users.<li>The signature will be added to any comments or forum posts you made</li><li>The BIO is a brief summary of yourself to share</li><li>Share your PGP Key</li>',
    150 => 'Warning: Javascript recommended for enhanced functionality'
);

###############################################################################
# index.php

$LANG05 = array(
    1 => 'Keine Artikel',
    2 => 'Es gibt keine Artikel, die angezeigt werden könnten. Entweder gibt es für diese Kategorie keine Artikel oder Ihre Einstellungen sind zu restriktiv.',
    3 => ' für die Kategorie %s.',
    4 => 'Hauptartikel',
    5 => 'weiter',
    6 => 'zurück',
    7 => 'Anfang',
    8 => 'Ende'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => 'Es gab einen Fehler beim Versenden der Nachricht. Bitte noch einmal versuchen.',
    2 => 'Nachricht wurde verschickt.',
    3 => 'Bitte sicherstellen, dass Sie eine gültige E-Mail-Adresse eingetragen haben.',
    4 => 'Bitte alle Felder ausfüllen: Ihr Name, Ihre E-Mail, Betreff und Nachricht',
    5 => 'Fehler: Username nicht bekannt.',
    6 => 'Es ist ein Fehler aufgetreten.',
    7 => 'Userprofil für',
    8 => 'Username',
    9 => 'User URL',
    10 => 'Eine Mail schicken an',
    11 => 'Ihr Name:',
    12 => 'Ihre E-Mail:',
    13 => 'Betreff:',
    14 => 'Nachricht:',
    15 => 'HTML wird nicht interpretiert.',
    16 => 'Nachricht abschicken',
    17 => 'Artikel an einen Freund schicken',
    18 => 'An (Name)',
    19 => 'An (E-Mail)',
    20 => 'Von (Name)',
    21 => 'Von (E-Mail)',
    22 => 'Alle Felder müssen ausgefüllt werden.',
    23 => "Diese Nachricht wurde Ihnen von %s <%s> geschickt, da er/sie der Meinung war, Sie würden sich vielleicht für diesen Artikel auf {$_CONF['site_url']} interessieren. Dies ist kein Spam und die beteiligten E-Mail-Adressen (Ihre und die des Absenders) werden nicht gespeichert oder wiederverwendet.",
    24 => "Schreiben Sie einen Kommentar zu diesem Artikel:\n",
    25 => 'Sie müssen sich anmelden, um diese Funktion benutzen zu können. Dies ist leider nötig, um den Missbrauch des Systems zu verhindern',
    26 => 'Mit diesem Formular können Sie eine E-Mail an diesen User schicken. Alle Felder müssen ausgefüllt werden.',
    27 => 'Kurze Nachricht',
    28 => '%s schrieb: ',
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
    14 => 'Es gab keine Treffer für Ihre Suche nach',
    15 => 'Bitte noch einmal versuchen.',
    16 => 'Titel',
    17 => 'Datum',
    18 => 'Autor',
    19 => "Durchsuchen Sie die komplette Datenbank von {$_CONF['site_name']} ...",
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
    30 => 'Keine Links für Ihre Suche gefunden',
    31 => 'Dieses Plugin lieferte keine Treffer',
    32 => 'Termin',
    33 => 'URL',
    34 => 'Ort',
    35 => 'Ganztägig',
    36 => 'Keine Termine für Ihre Suche gefunden',
    37 => 'Gefundene Termine',
    38 => 'Gefundene Links',
    39 => 'Links',
    40 => 'Termine',
    41 => 'Ihr Suchbegriff sollte mindestens 3 Zeichen lang sein.',
    42 => 'Das Datum muss im Format JJJJ-MM-TT (Jahr-Monat-Tag) eingegeben werden.',
    43 => 'genaue Wortgruppe',
    44 => 'alle Wörter',
    45 => 'irgendeines der Wörter',
    46 => 'weiter',
    47 => 'zurück',
    48 => 'Autor',
    49 => 'Datum',
    50 => 'Treffer',
    51 => 'Link',
    52 => 'Wohnort',
    53 => 'Gefundene Artikel',
    54 => 'Gefundene Kommentare',
    55 => 'der Wortgruppe',
    56 => '<em>und</em>',
    57 => '<em>oder</em>',
    58 => 'Weitere Ergebnisse &gt;&gt;',
    59 => 'Ergebnisse',
    60 => 'pro Seite',
    61 => 'Suche korrigieren'
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
    8 => 'Artikelüberschrift',
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
    24 => 'Es wurden keine Artikel per E-Mail verschickt.',
    25 => 'Top Ten der Artikel mit Trackback-Kommentaren',
    26 => 'Keine Trackback-Kommentare gefunden.',
    27 => 'Anzahl aktiver User',
    28 => 'Top Ten der Termine',
    29 => 'Event',
    30 => 'Angezeigt',
    31 => 'Es gibt keine Termine oder sie wurden von niemandem gelesen.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => 'Weiterführende Links',
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
    9 => 'Wenn Sie Informationen einreichen möchten, die auf dieser Site veröffentlicht werden sollen, dann bitten wir Sie, folgende Punkte zu beachten:<ul><li>Bitte alle Felder ausfüllen, sie werden benötigt<li>Bitte nur vollständige und exakte Information einreichen<li>URLs vor dem Abschicken unbedingt noch einmal kontrollieren</ul>',
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
    21 => 'Wenn Sie "Andere" auswählen, geben Sie bitte auch eine neue Kategorie ein',
    22 => 'Fehler: Nicht alle Felder ausgefüllt',
    23 => 'Bitte alle Felder des Formulars ausfüllen. Alle Felder werden benötigt.',
    24 => 'Beitrag gespeichert',
    25 => 'Ihr %s-Beitrag wurde gespeichert.',
    26 => 'Speed Limit',
    27 => 'Username',
    28 => 'Kategorie',
    29 => 'Artikel',
    30 => 'Ihr letzter Beitrag war vor ',
    31 => " Sekunden. Zwischen zwei Beiträgen müssen aber mindestens {$_CONF['speedlimit']} Sekunden vergangen sein.",
    32 => 'Vorschau',
    33 => 'Artikelvorschau',
    34 => 'Abmelden',
    35 => 'HTML-Tags sind nicht erlaubt',
    36 => 'Format',
    37 => "Wenn Sie einen Termin bei {$_CONF['site_name']} einreichen, wird er in den Kalender aufgenommen, von wo aus ihn andere User in ihren persönlichen Kalender übernehmen können. Dies ist <b>NICHT</b> dazu gedacht, private Termine und Ereignisse wie etwa Geburtstage zu verwalten.<br><br>Wenn Sie einen Termin einreichen, wird er an die Administratoren weitergeleitet und sobald er von diesen akzeptiert wird, wird er im Kalender erscheinen.",
    38 => 'Termin hinzufügen zu',
    39 => 'Kalender',
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
    2 => 'Sie haben nicht die nötigen Rechte, um diesen Block ändern zu können.',
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
    25 => 'Um einen Block zu ändern oder zu löschen, auf das Ändern-Icon (s.u.) klicken. Um einen neuen Block anzulegen, auf Neu anlegen (s.o.) klicken.',
    26 => 'Layout-Block',
    27 => 'PHP-Block',
    28 => 'PHP-Block: Optionen',
    29 => 'Block-Funktion',
    30 => 'Wenn einer Ihrer Blöcke PHP-Code verwenden soll, geben Sie hier bitte den Namen der Funktion ein. Der Funktionsname muss mit "phpblock_" (z.B. phpblock_getweather) beginnen. Wenn diese Namenskonvention nicht eingehalten wird, wird die Funktion NICHT aufgerufen. Das soll verhindern, dass Hacker evtl. gefährlichen Code einschleusen können. Den Funktionsnamen NICHT mit einem Klammerpaar "()" abschliessen. Ferner wird empfohlen, all Ihren Code für PHP-Blöcke in der Datei /pfad/zu/geeklog/system/lib-custom.php abzulegen. Dort kann der Code auch dann unverändert bleiben, wenn Sie auf eine neuere Geeklog-Version umsteigen.',
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
    42 => 'Für Geeklog-Default-Blöcke muss ein Block-Titel und die Block-Reihenfolge angegeben werden.',
    43 => 'Nur auf der Startseite',
    44 => 'Zugriff verweigert',
    45 => "Sie haben keine Zugriffsrechte für diesen Block. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/block.php\">Zurück zum Administrator-Menü</a>.",
    46 => 'Bewegen',
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
    60 => 'Block auf die linke Seite',
    61 => 'Ohne Titel',
    62 => 'Artikellimit',
    63 => 'Block-Titel nicht erlaubt',
    64 => 'Der Titel kann nicht leer sein und darf kein HTML enthalten!',
    65 => 'Reihenfolge',
    66 => 'Autotags',
    67 => 'Ankreuzen, um Autotags zu interpretieren'
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
    18 => 'Gelesen',
    19 => 'Kommentare',
    20 => 'Ping',
    21 => 'Senden',
    22 => 'Artikelliste',
    23 => 'Auf das Ändern-Icon klicken, um einen Artikel zu ändern oder zu löschen. Um einen Artikel anzusehen, auf dessen Titel klicken. Auf Neu anlegen (s.o.) klicken, um einen neuen Artikel zu schreiben.',
    24 => 'Diese ID wird bereits für einen anderen Artikel benutzt. Bitte wählen Sie eine andere ID.',
    25 => 'Fehler beim Speichern des Artikels',
    26 => 'Artikelvorschau',
    27 => 'Wenn Sie [unscaledX] statt [imageX] verwenden, wird das Bild in Originalgröße eingebunden.',
    28 => '<p><strong>VORSCHAU:</strong> Der Vorschau-Button sollte nur verwendet werden, wenn der Artikel keine Bilder enthält. Bei Artikeln mit Bildern empfiehlt es sich, den Artikel als Entwurf zu markieren, zu speichern und dann von der Liste der Artikel aus zu betrachten.</p>',
    29 => 'Trackbacks',
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
    41 => "Sie haben keine Zugriffsrechte für diesen Artikel. Dieser Zugriffsversuch wurde protokolliert. Sie können sich den Artikel aber ansehen (s.u., Ändern nicht möglich). <a href=\"{$_CONF['site_admin_url']}/story.php\">Zurück zum Administrator-Menü</a>.",
    42 => "Sie haben keine Zugriffsrechte für diesen Artikel. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/story.php\">Zurück zum Administrator-Menü</a>.",
    43 => 'Neuer Artikel',
    44 => 'Admin Home',
    45 => 'Zugriff',
    46 => '<b>HINWEIS:</b> Wenn Sie hier ein Datum in der Zukunft einstellen, wird der Artikel erst veröffentlicht, wenn dieser Zeitpunkt erreicht ist. Bis dahin wird der Artikel auch nicht in der RSS-Datei, der Suche und der Statistik erscheinen.',
    47 => 'Bilder',
    48 => 'image',
    49 => 'right',
    50 => 'left',
    51 => 'Die oben ausgewählten Bilder können in den Artikel eingefügt werden, indem Sie spezielle Platzhalter dafür in den Text einfügen. Diese Platzhalter sind [imageX], [imageX_right] und [imageX_left], wobei statt des X jeweils die Nummer des Bildes eingetragen werden muss.<br>HINWEIS: Es müssen alle ausgewählten Bilder verwendet werden. Andernfalls kann der Artikel nicht gespeichert werden.<br>',
    52 => 'Löschen',
    53 => 'wurde nicht verwendet. Sie müssen dieses Bild im Text des Artikels verwenden oder es löschen bevor Sie Ihre Änderungen sichern können.',
    54 => 'Nicht verwendete Bilder',
    55 => 'Folgende Fehler traten beim Versuch, den Artikel zu speichern, auf. Bitte diese Fehler beheben und den Artikel noch einmal speichern.',
    56 => 'mit Icon',
    57 => 'Bild in Originalgröße',
    58 => 'Artikelverwaltung',
    59 => 'Option',
    60 => 'Aktiviert',
    61 => 'automatisch archivieren',
    62 => 'automatisch löschen',
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
    1 => 'Kategorie-Editor',
    2 => 'Kategorie-ID',
    3 => 'Kategorie-Name',
    4 => 'Kategorie-Bild',
    5 => '(keine Leerzeichen!)',
    6 => 'Löschen einer Kategorie löscht auch alle dazu gehörenden Artikel und Blöcke',
    7 => 'Bitte die Felder Kategorie-ID und Kategorie-Name ausfüllen',
    8 => 'Kategorie-Manager',
    9 => 'Auf eine Kategorie klicken, um sie zu ändern oder zu löschen. Auf Neu anlegen (s.o.) klicken, um eine neue Kategorie anzulegen. Die nötige Zugriffsberechtigung wird in Klammern hinter der Kategorie angegeben. Das Sternchen(*) markiert die Default-Kategorie.',
    10 => 'Sortierreihenfolge',
    11 => 'Artikel/Seite',
    12 => 'Zugriff verweigert',
    13 => "Sie haben keine Zugriffsrechte für diese Kategorie. Dieser Zugriffsversuch wurde protokolliert. <a href=\"{$_CONF['site_admin_url']}/topic.php\">Zurück zum Administrator-Menü</a>.",
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
    26 => 'Zur Archiv-Kategorie machen (nur für eine Kategorie möglich)',
    27 => 'oder ein Icon hochladen',
    28 => 'maximal',
    29 => 'Fehler beim Datei-Upload'
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
    12 => 'Auf das Ändern-Icon klicken, um einen User zu ändern oder zu löschen. Ein neuer User kann mit Neu anlegen (s.o.) angelegt werden.',
    13 => 'SecLev',
    14 => 'Reg. Datum',
    15 => 'Neuer User',
    16 => 'Admin Home',
    17 => '',
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
    36 => '(noch nie)',
    37 => 'UID',
    38 => 'Gruppenliste',
    39 => 'Passwort (nochmal)',
    40 => 'Registriert',
    41 => 'Letzter Login',
    42 => 'Gesperrt',
    43 => 'Erwartet Aktivierung',
    44 => 'Erwartet Autorisierung',
    45 => 'Aktiv',
    46 => 'User-Status',
    47 => 'Ändern'
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
    14 => 'User Einstellungen ignorieren',
    15 => 'Fehler beim Senden an: ',
    16 => 'E-Mail erfolgreich gesendet an: ',
    17 => "<a href=\"{$_CONF['site_admin_url']}/mail.php\">Noch eine Nachricht schreiben</a>",
    18 => 'An',
    19 => 'HINWEIS: Wenn Sie eine Nachricht an alle eingetragenen Benutzer schicken wollen, müssen Sie die Gruppe Logged-in Users auswählen.',
    20 => "<successcount> Nachricht(en) erfolgreich verschickt, bei <failcount> Nachricht(en) traten Fehler auf. Details können der folgenden Liste entnommen werden. Sie k&ouml:nnen jetzt <a href=\"{$_CONF['site_admin_url']}/mail.php\">noch eine Nachricht schicken</a> oder <a href=\"{$_CONF['site_admin_url']}/moderation.php\">zurück zum Admin-Menü gehen</a>.",
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
    1 => 'Installing plugins could possibly cause damage to your Geeklog installation and, possibly, to your system.  It is important that you only install plugins downloaded from the <a href="http://www.geeklog.net">Geeklog Homepage</a> as we thoroughly test all plugins submitted to our site on a variety of operating systems.  It is important that you understand that the plugin installation process will require the execution of a few filesystem commands which could lead to security problems particularly if you use plugins from third party sites.  Even with this warning you are getting, we do not gaurantee the success of any installation nor are we liable for damage caused by installing a Geeklog plugin.  In other words, install at your own risk.  For the wary, directions on how to manually install a plugin is included with each plugin package.',
    2 => 'Plugin-Installation -- Disclaimer',
    3 => 'Plugin-Installationsformular',
    4 => 'Plugin-Datei',
    5 => 'Plugin-Liste',
    6 => 'Warnung: Plugin schon installiert!',
    7 => 'Das Plugin, das Sie installieren wollen, ist schon vorhanden. Bitte löschen Sie es, bevor Sie noch einmal versuchen, es zu installieren',
    8 => 'Plugin-Kompatibilitätstest fehlgeschlagen',
    9 => 'Dieses Plugin benötigt eine neuere Version von Geeklog. Abhilfe schafft ein Update von <a href="http://www.geeklog.net/">Geeklog</a> oder evtl. eine andere Version dieses Plugins.',
    10 => '<br><b>Es sind derzeit keine Plugins installiert.</b><br><br>',
    11 => 'Um ein Plugin zu ändern oder zu löschen, auf das Ändern-Icon klicken. Es werden dann auch weitere Details, inkl. der Homepage des Plugins, angezeigt. Wenn in der Liste (s.u.) zwei Versionsnummern für ein Plugin angezeigt werden, bedeutet das, dass für das Plugin noch ein Update durchgeführt werden muss. Um ein Plugin zu installieren oder aktualisieren bitte auch immer dessen Dokumentation lesen.',
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
    31 => 'Sind Sie sicher, dass Sie dieses Plugin löschen wollen? Dies wird alle Daten und Datenstrukturen löschen, die dieses Plugin benutzt. Wenn Sie sicher sind, dann klicken Sie jetzt bitte noch einmal auf Löschen.',
    32 => '<p><b>Fehler: Ungültiges Format für Autolink.</b></p>',
    33 => 'Code-Version',
    34 => 'Aktualisieren',
    35 => 'Ändern',
    36 => 'Code',
    37 => 'Aktuell',
    38 => 'Bitte aktualisieren!'
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
    13 => 'Um einen Feed zu ändern oder zu löschen, auf das Ändern-Icon (s.u.) klicken. Um einen neuen Feed anzulegen, auf Neu anlegen (s.o.) klicken.',
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
    37 => 'Sie haben (mindestens) ein Plugin installiert, das Content Syndication unterstützt. Bitte wählen Sie zunächst aus, ob Sie einen Feed für Geeklog oder für ein Plugin anlegen wollen.',
    38 => 'Fehler: Nicht alle Felder ausgefüllt',
    39 => 'Bitte die Felder Feed-Titel, Beschreibung und Dateiname ausfüllen.',
    40 => 'Bitte ein Limit (Anzahl Einträge oder Anzahl Stunden) eingeben.',
    41 => 'Links',
    42 => 'Termine',
    43 => 'All',
    44 => 'None',
    45 => 'Feed-Link für Kategorie',
    46 => 'Limit Results',
    47 => 'Suchen',
    48 => 'Ändern',
    49 => 'Feed-Logo',
    50 => "Relativ zur URL dieser Site ({$_CONF['site_url']})",
    51 => 'Der gewählte Dateiname wird bereits von einem anderen Feed verwendet. Bitte wählen Sie einen anderen.',
    52 => 'Fehler: Dateiname existiert schon'
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "Ihr Passwort sollte in Kürze per E-Mail bei Ihnen eintreffen. Bitte beachten Sie die Hinweise in der E-Mail. Danke, dass Sie sich bei {$_CONF['site_name']} angemeldet haben.",
    2 => "Danke für Ihren Beitrag zu {$_CONF['site_name']}. Ihr Artikel wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald auf dieser Website für alle Besucher zu lesen sein.",
    3 => "Danke für Ihren Beitrag zu {$_CONF['site_name']}. Ihr Link wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald unter den <a href=\"{$_CONF['site_url']}/links.php\">Links</a> aufgelistet werden.",
    4 => "Danke für Ihren Beitrag zu {$_CONF['site_name']}. Ihr Termin wurde an unser Team weitergeleitet. Wenn er akzeptiert wird, wird er bald in unserem <a href=\"{$_CONF['site_url']}/calendar.php\">Kalender</a> erscheinen.",
    5 => 'Ihr Userprofil wurde gespeichert.',
    6 => 'Ihre Einstellungen wurden gespeichert.',
    7 => 'Ihre Kommentar-Einstellungen wurden gespeichert.',
    8 => 'Abmeldung erfolgt. Sie sind jetzt nicht mehr angemeldet.',
    9 => 'Ihr Artikel wurde gespeichert.',
    10 => 'Der Artikel wurde gelöscht.',
    11 => 'Ihr Block wurde gespeichert.',
    12 => 'Der Block wurde gelöscht.',
    13 => 'Ihre Kategorie wurde gespeichert.',
    14 => 'Die Kategorie und alle zugehörigen Artikel wurden gelöscht.',
    15 => 'Ihr Link wurde gespeichert.',
    16 => 'Der Link wurde gelöscht.',
    17 => 'Ihr Termin wurde gespeichert.',
    18 => 'Der Termin wurde gelöscht.',
    19 => 'Ihre Umfrage wurde gespeichert.',
    20 => 'Die Umfrage wurde gelöscht.',
    21 => 'Der User wurde gespeichert.',
    22 => 'Der User wurde gelöscht.',
    23 => 'Der Termin konnte nicht in Ihren persönlichen Kalender übernommen werden. Es wurde keine ID übergeben oder der Termin wurde nicht gefunden.',
    24 => 'Der Termin wurde in Ihren Kalender eingetragen.',
    25 => 'Sie müssen angemeldet sein, um auf Ihren persönlichen Kalender zugreifen zu können.',
    26 => 'Der Termin wurde aus Ihrem persönlichen Kalender entfernt',
    27 => 'Nachricht wurde verschickt.',
    28 => 'Das Plugin wurde gespeichert.',
    29 => 'Sorry, persönliche Kalender sind auf dieser Site nicht verfügbar.',
    30 => 'Zugriff verweigert',
    31 => 'Sie haben keinen Zugriff auf die Artikel-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    32 => 'Sie haben keinen Zugriff auf die Kategorie-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werdenprotokolliert.',
    33 => 'Sie haben keinen Zugriff auf die Block-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    34 => 'Sie haben keinen Zugriff auf die Links-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    35 => 'Sie haben keinen Zugriff auf die Termin-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    36 => 'Sie haben keinen Zugriff auf die Umfrage-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    37 => 'Sie haben keinen Zugriff auf die User-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    38 => 'Sie haben keinen Zugriff auf die Plugin-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    39 => 'Sie haben keinen Zugriff auf die E-Mail-Administrationsseite. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    40 => 'System-Nachricht',
    41 => 'Sorry, you do not have access to the word replacement page.  Please not that all attempts to access unauthorized features are logged',
    42 => 'Your word has been successfully saved.',
    43 => 'The word has been successfully deleted.',
    44 => 'Das Plugin wurde erfolgreich installiert.',
    45 => 'Das Plugin wurde gelöscht.',
    46 => 'Sie haben keinen Zugriff auf die Backup-Funktion. Alle Versuche, auf Bereiche ohne entsprechende Berechtigung zuzugreifen, werden protokolliert.',
    47 => 'This functionality only works under *nix.  If you are running *nix as your operating system then your cache has been successfully cleared. If you are on Windows, you will need to search for files name adodb_*.php and remove them manually.',
    48 => "Danke, dass Sie sich bei {$_CONF['site_name']} angemeldet haben. Ihr Aufnahmeantrag wird von unserem Team geprüft. Sobald er akzeptiert wird, werden Sie ein Passwort per E-Mail erhalten.",
    49 => 'Ihre Gruppe wurde gespeichert.',
    50 => 'Die Gruppe wurde gelöscht.',
    51 => 'Dieser Username ist schon vergeben. Bitte wählen Sie einen anderen.',
    52 => 'Die angegebene E-Mail-Adresse scheint nicht gültig zu sein.',
    53 => 'Ihr neues Passwort wurde gespeichert. Bitte melden Sie sich nun mit dem neuen Passwort an.',
    54 => 'Diese Anfrage für ein neues Passwort ist nicht mehr gültig. Bitte fordern Sie erneut ein neues Passwort an.',
    55 => 'Sie sollten in Kürze eine E-Mail erhalten, in der beschrieben wird, wie Sie ein neues Passwort für Ihren Account eingeben können.',
    56 => 'Die angegebene E-Mail-Adresse wird schon für einen anderen Account verwendet.',
    57 => 'Ihr Account wurde gelöscht.',
    58 => 'Der Feed wurde gespeichert.',
    59 => 'Der Feed wurde gelöscht.',
    60 => 'Das Plugin wurde erfolgreich aktualisiert.',
    61 => 'Plugin %s: Unbekannter Text-Platzhalter',
    62 => 'Der Trackback-Kommentar wurde gelöscht.',
    63 => 'Beim Löschen des Trackback-Kommentars trat ein Fehler auf.',
    64 => 'Ihr Trackback-Kommentar wurde erfolgreich verschickt.',
    65 => 'Das Weblog-Verzeichnis wurde gespeichert.',
    66 => 'Das Weblog-Verzeichnis wurde gelöscht.',
    67 => 'Das neue Passwort stimmt nicht mit dem Bestätigungs-Passwort überein!',
    68 => 'Geben Sie bitte Ihr korrektes aktuelles Passwort ein.',
    69 => 'Ihr Account wurde gesperrt!',
    70 => 'Ihr Account wurde noch nicht freigeschaltet.',
    71 => 'Ihr Account wurde bestätigt, muss aber noch freigeschaltet werden.',
    72 => 'Bei der Installation des Plugins trat ein Fehler auf. Siehe error.log für weitere Informationen.',
    73 => 'Bei der Deinstallation des Plugins trat ein Fehler aus. Siehe error.log für weitere Informationen.',
    74 => 'Der Pingback wurde erfolgreich verschickt.',
    75 => 'Trackbacks müssen als POST-Request verschickt werden.',
    76 => 'Wollen Sie diesen Eintrag wirklich löschen?',
    77 => 'HINWEIS:<br>Sie haben UTF-8 als Default-Zeichensatz angegeben. Ihr Webserver unterstützt jedoch kein "multibyte encoding". Installieren Sie bitte die mbstring-Erweiterung für PHP oder benutzen Sie einen anderen Zeichensatz bzw. eine andere Sprache.',
    78 => 'Bitte sicherstellen, dass die angegebene E-Mail-Adresse in beiden Fällen die gleiche ist.',
    79 => 'Diese Funktion ist nicht mehr unter dieser URL verfügbar.',
    80 => 'Das Plugin, das diesen Feed angelegt hat, ist derzeit nicht aktiviert. Dieser Feed kann nicht bearbeitet werden, solange das Plugin deaktiviert ist.',
    81 => 'Haben Sie sich vertippt? Bitte versuchen Sie noch einmal, sich hier anzumelden.',
    82 => 'Sie haben die erlaubte Anzahl von Anmeldeversuchen überschritten. Bitte versuchen Sie es später noch einmal.',
    83 => 'Um Ihr Passwort, Ihre E-Mail-Adresse oder die "Angemeldet für"-Zeit zu ändern müssen Sie Ihr aktuelles Passwort eingeben.'
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
    'editrootmsg' => "Obwohl Sie User-Administrator sind, können Sie die Informationen von Usern in der Root-Gruppe nicht ändern, ohne selbst Mitglied der Root-Gruppe zu sein. Sie können die Informationen aller anderen User bearbeiten, nur nicht die der Mitglieder der Root-Gruppe. Beachten Sie bitte, dass alle derartigen Versuche protokolliert werden. <a href=\"{$_CONF['site_admin_url']}/user.php\">Zurück zur User-Admin-Seite</a>.",
    'securitygroupsmsg' => 'Mit den Checkboxen können Sie festlegen, zu welchen Gruppen dieser User gehört.',
    'groupeditor' => 'Gruppen-Editor',
    'description' => 'Beschreibung',
    'name' => 'Name',
    'rights' => 'Rechte',
    'missingfields' => 'Fehlende Angaben',
    'missingfieldsmsg' => ' Sie müssen den Namen und eine Beschreibung für die Gruppe angeben.',
    'groupmanager' => 'Gruppen-Manager',
    'newgroupmsg' => 'Um eine Gruppe zu ändern oder zu löschen, auf das Ändern-Icon klicken. Neu anlegen (s.o.) legt eine neue Gruppe an. Hinweis: Core-Gruppen können nicht gelöscht werden, da sie vom System benötigt werden.',
    'groupname' => 'Gruppen-Name',
    'coregroup' => 'Core-Gruppe',
    'yes' => 'Ja',
    'no' => 'Nein',
    'corerightsdescr' => "Diese Gruppe ist eine Core-Gruppe auf {$_CONF['site_name']}. Die Rechte dieser Gruppe können daher nicht geändert werden. Das Folgende ist eine (nicht veränderbare) Liste der Rechte dieser Gruppe.",
    'groupmsg' => 'Security-Gruppen auf dieser Site sind hierarchisch organisiert. Wenn Sie diese Gruppe zu einer der folgenden Gruppen hinzufügen, bekommt diese Gruppe die gleichen Rechte wie die unten ausgewählte(n). Wenn möglich, sollten Gruppenrechte durch Auswahl von Gruppen aus dieser Liste vergeben werden. Werden nur einzelne Rechte benötigt, können diese auch aus der Liste der Rechte weiter unten ausgewählt werden. Um diese Gruppe zu einer der folgenden hinzuzufügen, können Sie die gewünschte(n) Gruppe(n) einfach anklicken.',
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
    'storydenialmsg' => "Sie haben nicht die nötigen Rechte, um diesen Artikel zu lesen. Möglicherweise sind Sie kein registrierter User von {$_CONF['site_name']}. Bitte melden Sie sich als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">neuer User</a> von {$_CONF['site_name']} an um vollen Zugriff auf alle Bereiche zu bekommen.",
    'eventdenialmsg' => "Sie haben nicht die nötigen Rechte, um diesen Termin abzurufen. Möglicherweise sind Sie kein registrierter User von {$_CONF['site_name']}. Bitte melden Sie sich als <a href=\"{$_CONF['site_url']}/users.php?mode=new\">neuer User</a> von {$_CONF['site_name']} an um vollen Zugriff auf alle Bereiche zu bekommen.",
    'nogroupsforcoregroup' => 'Diese Gruppe gehört zu keiner anderen Gruppe.',
    'grouphasnorights' => 'Diese Gruppe hat keine Rechte für die Administration der Website',
    'newgroup' => 'Neue Gruppe',
    'adminhome' => 'Admin Home',
    'save' => 'Speichern',
    'cancel' => 'Abbruch',
    'delete' => 'Löschen',
    'canteditroot' => 'Sie haben versucht die Gruppe Root zu ändern, obwohl Sie selbst nicht Mitglied dieser Gruppe sind. Der Zugriff wurde daher verweigert. Wenden Sie sich bitte an den Systemadministrator wenn Sie der Meinung sind, dass das ein Fehler wäre.',
    'listusers' => 'User',
    'listthem' => 'anzeigen',
    'usersingroup' => 'User in Gruppe "%s"',
    'usergroupadmin' => 'Usergruppen-Verwaltung',
    'add' => 'Hinzufügen',
    'remove' => 'Löschen',
    'availmembers' => 'Verfügbare Mitglieder',
    'groupmembers' => 'Mitglieder der Gruppe',
    'canteditgroup' => 'Um diese Gruppe bearbeiten zu können, müssen Sie selbst ein Mitglied der Gruppe sein. Wenden Sie sich bitte an den Systemadministrator wenn Sie der Meinung sind, dass das ein Fehler wäre.',
    'cantlistgroup' => 'Um die Mitglieder dieser Gruppe sehen zu können, müssen Sie selbst ein Mitglied der Gruppe sein. Wenden Sie sich bitte an den Systemadministrator wenn Sie der Meinung sind, dass das ein Fehler wäre.',
    'editgroupmsg' => 'Um die Gruppenmitgliedschaft eines Users zu ändern, den Usernamen anklicken und entsprechend Hinzufügen oder Löschen anklicken. Nur User in der rechten Liste sind Mitglieder der Gruppe. Um die Änderungen zu übernehmen und zur Gruppenliste zurückzukehren, den Button <b>Speichern</b> klicken.',
    'listgroupmsg' => 'Liste aller Mitglieder der Gruppe "<b>%s</b>"',
    'search' => 'Suchen',
    'submit' => 'Abschicken',
    'limitresults' => 'Limit Results',
    'group_id' => 'Gruppen-ID',
    'plugin_access_denied_msg' => 'You are illegally trying access a plugin administration page.  Please note that all attempts to illegally access this page are logged.',
    'groupexists' => 'Gruppenname existiert schon',
    'groupexistsmsg' => 'Es existiert bereits eine Gruppe mit diesem Namen. Gruppennamen müssen eindeutig sein.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => 'Die 10 letzten Backups',
    'do_backup' => 'Backup anlegen',
    'backup_successful' => 'Backup der Datenbank war erfolgreich.',
    'db_explanation' => 'Um ein neues Backup Ihres Geeklog-Systems anzulegen, bitte auf Neu anlegen (s.o.) klicken.',
    'not_found' => "Falscher Pfad oder mysqldump ist nicht ausführbar.<br>Bitte überprüfe die Variable <strong>\$_DB_mysqldump_path</strong> in der config.php.<br>Aktueller Wert der Variablen: <var>{$_DB_mysqldump_path}</var>",
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
    3 => 'Beitrag',
    4 => 'Links',
    5 => 'Umfragen',
    6 => 'Kalender',
    7 => 'Statistik',
    8 => 'Einstellungen',
    9 => 'Suchen',
    10 => 'Erweiterte Suche',
    11 => 'Verzeichnis'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => 'Fehler 404',
    2 => 'Hmm, ich habe alles versucht, aber <b>%s</b> war nicht aufzufinden.',
    3 => "<p>Sorry, diese Seite oder Datei existiert nicht. Sie können es auf der <a href=\"{$_CONF['site_url']}\">Startseite</a> oder mit der <a href=\"{$_CONF['site_url']}/search.php\">Suchfunktion</a> probieren, vielleicht werden Sie ja fündig ..."
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => 'Anmeldung erforderlich',
    2 => 'Sorry, aber um auf diesen Bereich zugreifen zu können, müssen Sie als Benutzer registriert ein.',
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

###############################################################################
# trackback.php

$LANG_TRB = array(
    'trackback' => 'Trackback',
    'from' => 'von',
    'tracked_on' => 'Empfangen am',
    'read_more' => '[mehr]',
    'intro_text' => 'Auf anderen Sites wurde folgendes über \'%s\' geschrieben:',
    'no_comments' => 'Keine Trackback-Kommentare für diesen Eintrag.',
    'this_trackback_url' => 'Trackback-URL für diesen Eintrag:',
    'num_comments' => '%d Trackback-Kommentare',
    'send_trackback' => 'Pings senden',
    'preview' => 'Vorschau',
    'editor_title' => 'Trackback-Kommentar senden',
    'trackback_url' => 'Trackback-URL',
    'entry_url' => 'URL des Eintrags',
    'entry_title' => 'Titel des Eintrags',
    'blog_name' => 'Site-Name',
    'excerpt' => 'Auszug',
    'truncate_warning' => 'Hinweis: Die empfangende Site könnte den Auszug kürzen.',
    'button_send' => 'Abschicken',
    'button_preview' => 'Vorschau',
    'send_error' => 'Fehler',
    'send_error_details' => 'Fehler beim Senden des Trackback-Kommentars:',
    'url_missing' => 'Keine URL für den Eintrag',
    'url_required' => 'Es muss mindestens die URL für den Eintrag angegeben werden.',
    'target_missing' => 'Keine Trackback-URL',
    'target_required' => 'Bitte geben Sie die Trackback-URL ein.',
    'error_socket' => 'Socket konnte nicht geöffnet werden.',
    'error_response' => 'Antwort nicht verstanden.',
    'error_unspecified' => 'Fehler nicht näher spezifiziert.',
    'select_url' => 'Trackback-URL auswählen',
    'not_found' => 'Trackback-URL nicht gefunden',
    'autodetect_failed' => 'Geeklog konnte keine Trackback-URL für den Beitrag finden, zu dem der Kommentar gesendet werden sollte. Bitte geben Sie die Trackback-URL von Hand ein.',
    'trackback_explain' => 'Aus den unten aufgeführten Links können Sie jetzt den Beitrag auswählen, zu dem Ihr Kommentar gesendet werden soll. Geeklog wird versuchen, die Trackback-URL selbst zu ermitteln. Andernfalls können Sie die Trackback-URL aber auch <a href="%s">von Hand eingeben</a>.',
    'no_links_trackback' => 'Keine Links gefunden. Für diesen Beitrag können keine Trackback-Kommentare gesendet werden.',
    'pingback' => 'Pingback',
    'pingback_results' => 'Pingback-Ergebnisse',
    'send_pings' => 'Pings senden',
    'send_pings_for' => 'Pings für "%s" senden',
    'no_links_pingback' => 'Keine Links gefunden. Es wurden keine Pingbacks für diesen Beitrag gesendet.',
    'pingback_success' => 'Pingback gesendet.',
    'no_pingback_url' => 'Keine Pingback-URL gefunden.',
    'resend' => 'Nochmal senden',
    'ping_all_explain' => 'Sie können jetzt einen <a href="http://en.wikipedia.org/wiki/Pingback">Pingback</a> zu den verlinkten Sites senden, einen Ping an Weblog-Verzeichnissesenden, oder einen <a href="http://de.wikipedia.org/wiki/Trackback">Trackback</a>-Kommentar verschicken, wenn Sie über einen Beitrag in einem anderen Weblog geschrieben haben.',
    'pingback_button' => 'Pingback senden',
    'pingback_short' => 'Einen Pingback an alle in diesem Beitrag verlinkten Sites senden.',
    'pingback_disabled' => '(Pingback deaktiviert)',
    'ping_button' => 'Ping senden',
    'ping_short' => 'Weblog-Verzeichnisse "anpingen".',
    'ping_disabled' => '(Ping deaktiviert)',
    'trackback_button' => 'Trackback senden',
    'trackback_short' => 'Einen Trackback-Kommentar senden.',
    'trackback_disabled' => '(Trackback deaktiviert)',
    'may_take_a_while' => 'Hinweis: Das Senden von Pingbacks und Pings kann eine Weile dauern.',
    'ping_results' => 'Ping-Ergebnisse',
    'unknown_method' => 'Unbekannte Ping-Methode',
    'ping_success' => 'Ping gesendet.',
    'error_site_name' => 'Bitte geben Sie den Namen der Site ein.',
    'error_site_url' => 'Bitte geben Sie die URL der Site ein.',
    'error_ping_url' => 'Bitte geben Sie die Ping-URL der Site ein.',
    'no_services' => 'Es sind keine Weblog-Verzeichnisse konfiguriert.',
    'services_headline' => 'Weblog-Verzeichnisse',
    'service_explain' => 'Um ein Weblog-Verzeichnis zu ändern oder zu löschen, auf das Ändern-Icon klicken. Um ein neues Weblog-Verzeichnis einzutragen, auf Neu anlegen (s.o.) klicken.',
    'service' => 'Verzeichnis',
    'ping_method' => 'Ping-Methode',
    'service_website' => 'Website',
    'service_ping_url' => 'Ping-URL',
    'ping_standard' => 'Normaler Ping',
    'ping_extended' => 'Erweiterter Ping',
    'ping_unknown' => '(unbekannte Methode)',
    'edit_service' => 'Weblog-Verzeichnis bearbeiten',
    'trackbacks' => 'Trackbacks',
    'editor_intro' => 'Hier können Sie Ihren Trackback-Kommentar für <a href="%s">%s</a> eingeben.',
    'editor_intro_none' => 'Trackback-Kommentar eingeben.',
    'trackback_note' => 'Um einen Trackback-Kommentar für einen Artikel zu verschicken, benutzen Sie bitte den "' . $LANG24[20] . '"-Eintrag in der Liste der Artikel. Um einen Trackback unabhängig von einem Artikel zu verschicken, bitte <a href="%s">hier klicken</a>.',
    'pingback_explain' => 'Geben Sie eine URL ein, an die der Pingback geschickt werden soll. Der Pingback wird auf die Startseite Ihrer Website verweisen.',
    'pingback_url' => 'Pingback-URL',
    'site_url' => 'Die URL dieser Website',
    'pingback_note' => 'Um einen Pingback für einen Artikel zu verschicken, benutzen Sie bitte den "' . $LANG24[20] . '"-Eintrag in der Liste der Artikel. Um einen Pingback unabhängig von einem Artikel zu verschicken, bitte <a href="%s">hier klicken</a>.',
    'pbtarget_missing' => 'Keine Pingback-URL',
    'pbtarget_required' => 'Geben Sie bitte die Pingback-URL ein',
    'pb_error_details' => 'Fehler beim Senden des Pingbacks:',
    'delete_trackback'   => 'Trackback direkt löschen: '
);

###############################################################################
# directory.php

$LANG_DIR = array(
    'title' => 'Artikelverzeichnis',
    'title_year' => 'Artikelverzeichnis für %d',
    'title_month_year' => 'Artikelverzeichnis für %s %d',
    'nav_top' => 'Zurück zum Artikelverzeichnis',
    'no_articles' => 'Keine Artikel.'
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
    'new_string' => '%n neue %i für die letzten %t %s',
    'new_last' => 'letzte %t %s',
    'minutes' => 'Minuten',
    'hours' => 'Stunden',
    'days' => 'Tage',
    'weeks' => 'Wochen',
    'months' => 'Monate',
    'minute' => 'Minute',
    'hour' => 'Stunde',
    'day' => 'Tag',
    'week' => 'Woche',
    'month' => 'Monat'
);

$LANG_MONTH = array(
    1 => 'Januar',
    2 => 'Februar',
    3 => 'März',
    4 => 'April',
    5 => 'Mai',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'August',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Dezember'
);

$LANG_WEEK = array(
    1 => 'Sonntag',
    2 => 'Montag',
    3 => 'Dienstag',
    4 => 'Mittwoch',
    5 => 'Donnerstag',
    6 => 'Freitag',
    7 => 'Samstag'
);

###############################################################################
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array (
    'search'        => 'Suchen',
    'limit_results' => 'Anzahl Ergebnisse',
    'submit'        => 'Abschicken',
    'edit'          => 'Ändern',
    'admin_home'    => 'Admin Home',
    'create_new'    => 'Neu anlegen',
    'enabled'       => 'Aktiv',
    'title'         => 'Titel',
    'type'          => 'Typ',
    'topic'         => 'Kategorie',
    'help_url'      => 'URL f. Hilfe-Datei',
    'save'          => 'Speichern',
    'cancel'        => 'Abbruch',
    'delete'        => 'Löschen',
    'copy'          => 'Kopieren',
    'no_results'    => '- Keine Einträge gefunden -',
    'data_error'    => 'There was an error processing the subscription data. Please check the data source.',
    'preview'       => 'Vorschau'
);

###############################################################################
# Localisation of the texts for the various drop-down menus that are actually
# stored in the database. If these exist, they override the texts from the
# database.

$LANG_commentcodes = array(
    0   => 'Kommentare erlaubt',
    -1  => 'Keine Kommentare'
);

$LANG_commentmodes = array(
    'flat'      => 'Flach',
    'nested'    => 'Verschachtelt',
    'threaded'  => 'Nach Thema',
    'nocomment' => 'Keine Kommentare'
);

$LANG_cookiecodes = array(
    0       => '(gar nicht)',
    3600    => '1 Stunde',
    7200    => '2 Stunden',
    10800   => '3 Stunden',
    28800   => '8 Stunden',
    86400   => '1 Tag',
    604800  => '1 Woche',
    2678400 => '1 Monat'
);

$LANG_dateformats = array(
    0   => 'Defaulteinstellung'
);

$LANG_featurecodes = array(
    0 => 'Normaler Artikel',
    1 => 'Hauptartikel'
);

$LANG_frontpagecodes = array(
    0 => 'Nur unter der Kategorie',
    1 => 'Auf der Startseite'
);

$LANG_postmodes = array(
    'plaintext' => 'als Text',
    'html'      => 'in HTML'
);

$LANG_sortcodes = array(
    'ASC'  => 'Älteste zuerst',
    'DESC' => 'Neueste zuerst'
);

$LANG_trackbackcodes = array(
    0   => 'Trackbacks erlaubt',
    -1  => 'Keine Trackbacks'
);

?>
