<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | german.php                                                                |
// |                                                                           |
// | German language file for the Geeklog installation script                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Randy Kolenko     - randy AT nextide DOT ca                      |
// |          Matt West         - matt AT mattdanger DOT net                   |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+

$LANG_CHARSET = 'iso-8859-15';

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANG_NAME[XX]: $LANG - variable name                                     |
// |                 NAME  - where array is used                               |
// |                 XX    - phrase id number                                  |
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+
// install.php

$LANG_INSTALL = array(
    0 => 'Geeklog - Zuverl&auml;ssigkeit eingebaut',
    1 => 'Hilfe zur Installation',
    2 => 'Zuverl&auml;ssigkeit eingebaut',
    3 => 'Geeklog-Installation',
    4 => 'PHP %s ben&ouml;tigt',
    5 => 'Sorry, Geeklog ben&ouml;tigt mindestens PHP %s (Du hast Version ',
    6 => '). Bitte <a href="http://www.php.net/downloads.php">aktualisiere Deine PHP-Installation</a> oder bitte Deinen Hosting-Provider darum.',
    7 => 'Geeklog-Dateien nicht gefunden',
    8 => 'Das Installations-Skript hat einige wichtige Geeklog-Dateien nicht gefunden. Wahrscheinlich hast Du diese in andere Verzeichnisse verschoben. Bitte gib hier die Pfade zu den Dateien und Verzeichnissen an:',
    9 => 'Willkommen und Danke, dass Du Geeklog gew&auml;hlt hast!',
    10 => 'Datei/Verzeichnis',
    11 => 'Zugriffsrechte',
    12 => '&Auml;ndern auf',
    13 => 'Derzeit',
    14 => '',
    15 => 'Der Export von Schlagzeilen (Newsfeeds) ist deaktiviert. Das <code>backend</code>-Verzeichnis wurde nicht &uuml;berpr&uuml;ft.',
    16 => 'Migration',
    17 => 'Userfotos sind deaktiviert. Das <code>userphotos</code>-Verzeichnis wurde nicht &uuml;berpr&uuml;ft.',
    18 => 'Bilder in Artikeln sind deaktiviert. Das <code>articles</code>-Verzeichnis wurde nicht &uuml;berpr&uuml;ft.',
    19 => 'Geeklog setzt voraus, dass bestimmte Dateien und Verzeichnisse f&uuml;r den Webserver schreibbar sind. Es folgt eine Liste der Dateien und Verzeichnisse, die ge&auml;ndert werden m&uuml;ssen.',
    20 => 'Warnung',
    21 => 'Geeklog und Deine Website werden nicht funktionsf&auml;hig sein, solange diese Fehler nicht korrigiert werden. Bitte nimm die notwendigen &Auml;nderungen vor, bevor Du mit der Installation fortf&auml;hrst.',
    22 => 'unbekannt',
    23 => 'Bitte w&auml;hle eine Installationsmethode',
    24 => 'Neuinstallation',
    25 => 'Upgrade',
    26 => 'Nicht modifizierbar:',
    27 => '. Ist die Datei f&uuml;r den Webserver schreibbar?',
    28 => 'siteconfig.php. Ist die Datei f&uuml;r den Webserver schreibbar?',
    29 => 'Geeklog-Site',
    30 => 'Eine weitere Geeklog-Website',
    31 => 'Erforderliche Informationen zum Setup',
    32 => 'Name der Website',
    33 => 'Site-Slogan',
    34 => 'Art der Datenbank',
    35 => 'MySQL',
    36 => 'MySQL mit Support f&uuml;r InnoDB-Tabellen',
    37 => 'Microsoft SQL',
    38 => 'Fehler',
    39 => 'Datenbank-Server',
    40 => 'Name der Datenbank',
    41 => 'Datenbank-Username',
    42 => 'Datenbank-Passwort',
    43 => 'Pr&auml;fix f&uuml;r Tabellen',
    44 => 'Optionale Einstellungen',
    45 => 'URL der Website',
    46 => '(ohne Slash am Ende)',
    47 => 'URL f. "admin"-Verzeichnis',
    48 => 'Website-E-Mail-Adresse',
    49 => '"No Reply"-E-Mail-Adresse',
    50 => 'Installieren',
    51 => 'MySQL %s ben&ouml;tigt',
    52 => 'Sorry, aber Geeklog setzt mindestens MySQL %s voraus (Du hast Version ',
    53 => '). Bitte <a href="http://dev.mysql.com/downloads/mysql/">aktualisiere Deine MySQL-Version</a> oder bitte Deinen Website-Hoster, es f&uuml;r Dich zu erledigen.',
    54 => 'Datenbank-Informationen unvollst&auml;ndig oder nicht korrekt.',
    55 => 'Sorry, aber die Datenbank-Informationen, die Du eingegeben hast, scheinen nicht korrekt zu sein. Bitte klicke auf "Zur&uuml;ck" und versuche es noch einmal.',
    56 => 'Konnte keine Verbindung zum Datenbank-Server herstellen.',
    57 => 'Sorry, das Installations-Skript konnte die angegebene Datenbank nicht finden. Entweder existiert die Datenbank nicht oder Du hast Dich vertippt. Bitte klicke auf "Zur&uuml;ck" und versuche es noch einmal.',
    58 => '. Ist die Datei f&uuml;r den Webserver schreibbar?',
    59 => 'Hinweis',
    60 => 'InnoDB-Tabellen werden von Deiner MySQL-Version nicht unterst&uuml;tzt. Willst Du die Installation ohne InnoDB-Support fortsetzen?',
    61 => 'Zur&uuml;ck',
    62 => 'Weiter',
    63 => 'Eine Geeklog-Datenbank mit diesem Namen existiert bereits. Das Installations-Skript l&auml;sst es nicht zu, eine Neuinstallation &uuml;ber eine existierende Datenbank durchzuf&uuml;hren. Falls dies kein Versehen war, musst Du eine der folgenden Optionen w&auml;hlen:',
    64 => 'L&ouml;sche die Tabellen aus der vorhandenen Datenbank. Oder l&ouml;sche die ganze Datenbank und erzeuge eine neue. Dann kannst Du auf "Wiederholen" klicken.',
    65 => 'F&uuml;hre ein Datenbank-Update (auf eine neuere Geeklog-Version) durch, indem Du unten auf "Upgrade" klickst.',
    66 => 'Wiederholen',
    67 => 'Fehler beim Aufsetzen der Geeklog-Datenbank',
    68 => 'Die Datenbank ist nicht leer. Bitte l&ouml;sche alle Tabellen aus der Datenbank und beginne noch einmal von vorne.',
    69 => 'Geeklog-Upgrade',
    70 => 'Ein wichtiger Hinweis bevor es weiter geht: Du solltest unbedingt ein Backup Deiner Datenbank und Deiner Geeklog-Dateien anlegen. Dieses Installations-Skript wird Deine Geeklog-Datenbank ver&auml;ndern. Wenn etwas schief geht und Du das Update noch einmal durchf&uuml;hren musst, wirst Du ein Backup Deiner alten Datenbank brauchen. Falls also noch nicht geschehen: JETZT EIN BACKUP ANLEGEN!',
    71 => 'Bitte w&auml;hle unten die korrekte Geeklog-Version aus, von der Du aktualisieren willst. Dieses Skript wird dann inkrementelle Updates durchf&uuml;hren (d.h. Du kannst direkt von jeder alten Version auf ',
    72 => ' aktualisieren).',
    73 => 'Beachte bitte, dass dieses Skript keine Beta- oder Release Candidate-Versionen von Geeklog aktualisieren kann.',
    74 => 'Datenbank schon aktuell',
    75 => 'Die Datenbank ist offenbar schon aktuell. Du hast das Update wahrscheinlich schon einmal vorgenommen. Wenn Du es tats&auml;chlich noch einmal durchf&uuml;hren willst, installiere bitte zuerst die Datenbank von einem Backup und probiere es dann noch einmal.',
    76 => 'Geeklog-Version ausw&auml;hlen',
    77 => 'Das Installations-Skript konnte die bisher verwendete Geeklog-Version nicht ermitteln. Bitte w&auml;hle die korrekte Version aus dieser Liste aus:',
    78 => 'Update-Fehler',
    79 => 'Beim Update Deiner Geeklog-Installation trat ein Fehler auf.',
    80 => '&Auml;ndern',
    81 => 'Stop!',
    82 => 'Es ist unbedingt n&ouml;tig, die Zugriffsrechte der unten aufgef&uuml;hrten Dateien zu &auml;ndern. Andernfalls wirst Du Geeklog nicht installieren k&ouml;nnen.',
    83 => 'Fehler bei der Installation',
    84 => 'Der Pfad "',
    85 => '" scheint nicht korrekt zu sein. Bitte gib den Pfad noch einmal ein.',
    86 => 'Sprache',
    87 => 'http://geeklog.info/forum/index.php?forum=1',
    88 => '&Auml;ndere das Verzeichnis und die Dateien darin zu',
    89 => 'Aktuelle Version:',
    90 => 'Leere Datenbank?',
    91 => 'Entweder ist die Datenbank leer oder die Zugangsdaten f&uuml;r die Datenbank sind nicht korrekt. Oder wolltest Du eigentlich eine Neuinstallation durchf&uuml;hren (statt eines Updates)? Bitte noch einmal probieren.',
    92 => 'Benutze UTF-8',
    93 => 'Fertig',
    94 => 'Hier sind einige Hinweise, um den richtigen Pfad zu ermitteln:',
    95 => 'Der komplette Pfad zu dieser Datei (dem Installations-Skript) ist:',
    96 => 'Das Installations-Skript hat nach %s in diesem Verzeichnis gesucht:',
    97 => 'Dateirechte setzen',
    98 => 'F&uuml;r erfahrene User',
    99 => 'Wenn Du per Kommandozeile (SSH) Zugriff auf Deinen Webserver hast, kannst Du einfach das folgende Kommando per Kopieren und Einf&uuml;gen &uuml;bernehmen und ausf&uuml;hren:',
    100 => 'Ung&uuml;ltiger Modus ausgew&auml;hlt',
    101 => 'Schritt',
    102 => 'Konfigurations-Informationen eingeben',
    103 => 'und zus&auml;tzliche Plugins konfigurieren',
    104 => 'Der Pfad f&uuml;r das Admin-Verzeichnis ist nicht korrekt',
    105 => 'Der Pfad, den Du f&uuml;r das Admin-Verzeichnis eingegeben hast, scheint nicht korrekt zu sein. Bitte &uuml;berpr&uuml;fe Deine Eingabe und versuche es dann noch einmal.',
    106 => 'PostgreSQL',
    107 => 'F&uuml;r den produktiven Einsatz wird ein Datenbank-Passwort ben&ouml;tigt!',
    108 => 'Keine Datenbank-Treiber gefunden!',
    109 => 'Emergency Rescue Tool'
);

// +---------------------------------------------------------------------------+
// success.php

$LANG_SUCCESS = array(
    0 => 'Installation erfolgreich',
    1 => 'Installation von Geeklog ',
    2 => ' abgeschlossen!',
    3 => 'Gl&uuml;ckwunsch, Du hast Geeklog erfolgreich ',
    4 => '. Bitte nimm Dir einen Moment Zeit, um die unten stehenden Informationen zu lesen.',
    5 => 'Um Dich in Deine neue Geeklog-Site einzuloggen, benutze bitte diesen Account:',
    6 => 'Username:',
    7 => 'Admin',
    8 => 'Passwort:',
    9 => 'password',
    10 => 'Sicherheitshinweis',
    11 => 'Bitte vergiss nicht, die folgenden ',
    12 => ' Dinge zu tun',
    13 => 'Das Installationsverzeichnis l&ouml;schen oder umbenennen:',
    14 => 'Das Passwort f&uuml;r den Account ',
    15 => '&auml;ndern.',
    16 => 'Die Zugriffsrechte f&uuml;r',
    17 => 'und',
    18 => 'zur&uuml;cksetzen auf',
    19 => '<strong>Note:</strong> Because the security model has been changed, we have created a new account with the rights you need to administer your new site.  The username for this new account is <b>NewAdmin</b> and the password is <b>password</b>',
    20 => 'installiert',
    21 => 'aktualisiert',
    22 => 'migriert'
);

// +---------------------------------------------------------------------------+
// migrate.php

$LANG_MIGRATE = array(
    0 => 'Bei der Migration werden ggfs. Datenbank-Eintr&auml;ge &uuml;berschrieben.',
    1 => 'Vorbereitende Schritte',
    2 => 'Stelle sicher, dass alle bereits installierten Plugins auf den neuen Server kopiert wurden.',
    3 => 'Stelle sicher, dass alle Bilder aus <code>public_html/images/articles/</code>, <code>public_html/images/topics/</code>, und <code>public_html/images/userphotos/</code> auf den neuen Server kopiert wurden.',
    4 => 'Wenn Du von einer Geeklog-Version &auml;lter als <strong>1.5.0</strong> aktualisierst solltest Du sicherstellen, dass alle alten <tt>config.php</tt>-Dateien (von Geeklog und von den Plugins) auf den neuen Server kopiert wurden, damit die alten Einstellungen &uuml;bernommen werden k&ouml;nnen.',
    5 => 'Wenn Du von einer &auml;lteren Geeklog-Version aktualisierst, dann solltest Du Dein Theme noch <em>nicht</em> hochladen. Benutze zuerst das mitgelieferte Theme bis sicher ist, dass die Migration erfolgreich war.',
    6 => 'Backup ausw&auml;hlen',
    7 => 'Datei ausw&auml;hlen...',
    8 => 'Vom backups-Verzeichnis des Webservers',
    9 => 'Von Deinem Computer',
    10 => 'Datei ausw&auml;hlen...',
    11 => 'Keine Backup-Dateien gefunden',
    12 => 'Das Upload-Limit f&uuml;r diesen Webserver ist ',
    13 => '. Wenn Deine Backup-Datei gr&ouml;&szlig;er ist als ',
    14 => ' oder Du eine Zeit&uuml;berschreitung gemeldet bekommst, dann solltest Du die Datei per FTP in das backups-Verzeichnis von Geeklog &uuml;bertragen.',
    15 => 'Dein backups-Verzeichnis ist nicht f&uuml;r den Webserver schreibbar. Korrigiere bitte die Rechte.',
    16 => 'Migration',
    17 => 'Migration vom Backup',
    18 => 'Keine Backup-Datei ausgew&auml;hlt.',
    19 => 'Konnte die Datei ',
    20 => ' nicht speichern unter ',
    21 => 'Die Datei',
    22 => 'existiert schon. Willst Du sie ersetzen?',
    23 => 'Ja',
    24 => 'Nein',
    25 => '',
    26 => 'Migrations-Hinweis: ',
    27 => 'Das ',
    28 => '-Plugin ist nicht vorhanden und wurde deaktiviert. Du kannst es jederzeit nachinstallieren und im Admin-Bereich wieder aktivieren.',
    29 => 'Das Bild "',
    30 => '" aus der "',
    31 => '"-Tabelle wurde hier nicht gefunden: ',
    32 => 'Die Datenbank-Datei enthielt Informationen &uuml;ber eines oder mehrere Plugins die das Migrations-Skript nicht im Verzeichnis',
    33 => 'finden konnte. Die Plugins wurden deaktiviert. Du kannst diese Plugins jederzeit nachinstallieren und im Admin-Bereich wieder aktivieren.',
    34 => 'Die Datenbank-Datei enthielt Informationen &uuml;ber eine oder mehrere Dateien, die das Migrations-Skript nicht im Verzeichnis',
    35 => 'finden konnte. Weitere Informationen dazu findest Du in der Datei <code>error.log</code>.',
    36 => 'Diese Probleme k&ouml;nnen anschlie&szlig;end von Hand korrigiert werden.',
    37 => 'Migration abgeschlossen',
    38 => 'Die Datenbank-Migration wurde erfolgreich abgeschlossen. Es wurden allerdings die folgenden Probleme gefunden:',
    39 => 'Der Pfad f&uuml;r PEAR konnte nicht gesetzt werden. Ohne PEAR k&ouml;nnen leider keine komprimierten Datenbank-Backups importiert werden.',
    40 => 'Das Archiv \'%s\' scheint keine SQL-Dateien zu enthalten.',
    41 => 'Fehler beim extrahieren des Datenbank-Backups \'%s\' aus dem Archiv.',
    42 => 'Backup-Datei \'%s\' nicht (mehr) auffindbar ...',
    43 => 'Import abgebrochen: Die Datei \'%s\' scheint kein Datenbank-Backup zu sein.',
    44 => 'Schwerer Fehler: Datenbank-Import fehlgeschlagen. Keine weitere Aktion ohne manuellen Eingriff m&ouml;glich.',
    45 => 'Version des Datenbank-Backups konnte nicht ermittelt werden. Bitte ein manuelles Update durchf&uuml;hren.',
    46 => '',
    47 => 'Update von Version %s auf Version %s fehlgeschlagen.',
    48 => 'Ein oder mehrere Plugins konnten nicht aktualisiert werden und wurden deaktiviert.',
    49 => 'Aktuellen Datenbank-Inhalt verwenden'
);

// +---------------------------------------------------------------------------+
// install-plugins.php

$LANG_PLUGINS = array(
    1 => 'Plugin-Installation',
    2 => 'Schritt',
    3 => 'Plugins sind Erweiterungen, die sich in Geeklog integrieren und neue Funktionen bereitstellen. In der Geeklog-Distribution sind bereits einige Plugins enthalten, die Du vielleicht mitinstallieren willst.',
    4 => 'Zus&auml;tzliche Plugins k&ouml;nnen auch hier direkt hochgeladen werden.',
    5 => 'Die hochgeladene Datei war nicht mit ZIP oder GZip komprimiert.',
    6 => 'Das hochgeladene Plugin existiert schon!',
    7 => 'Fertig!',
    8 => 'Das %s-Plugin wurde erfolgreich hochgeladen.',
    9 => 'Plugin hochladen',
    10 => 'W&auml;hle eine Plugin-Datei',
    11 => 'Hochladen',
    12 => 'Welche Plugins sollen installiert werden?',
    13 => 'Installieren?',
    14 => 'Plugin',
    15 => 'Version',
    16 => 'Nicht bekannt',
    17 => 'Hinweis',
    18 => 'Dieses Plugin muss im Admin-Men&uuml; unter "Plugins" manuell aktiviert werden.',
    19 => 'Neuladen',
    20 => 'Keine zus&auml;tzlichen Plugins vorhanden, die installiert werden k&ouml;nnten.'
);

// +---------------------------------------------------------------------------+
// bigdump.php

$LANG_BIGDUMP = array(
    0 => 'Start Import',
    1 => ' from ',
    2 => ' into ',
    3 => ' at ',
    4 => 'Can\'t seek into ',
    5 => 'Can\'t open ',
    6 => ' for import.',
    7 => 'UNEXPECTED: Non-numeric values for start and foffset.',
    8 => 'Backup-Datei:',
    9 => 'Can\'t set file pointer behind the end of file.',
    10 => 'Can\'t set file pointer to offset: ',
    11 => 'There is no MySQL extension available in your PHP installation.',
    14 => 'Stopped at the line ',
    15 => '. At this place the current query includes more than ',
    16 => ' dump lines. That can happen if your dump file was created by some tool which doesn\'t place a semicolon followed by a linebreak at the end of each query, or if your dump contains extended inserts. Please read the BigDump FAQs for more information.',
    17 => 'Error at the line ',
    18 => 'Query: ',
    19 => 'MySQL: ',
    20 => 'Can\'t read the file pointer offset.',
    21 => 'Not available for gzipped files',
    22 => 'Fortschritt',
    23 => 'Die Datenbank wurde erfolgreich migriert! Es geht gleich weiter ...',
    24 => 'Waiting ',
    25 => ' milliseconds</b> before starting next session...',
    26 => 'Click here',
    27 => 'to abort the import',
    28 => 'or wait!',
    29 => 'An error occurred.',
    30 => 'Start from the beginning',
    31 => '(DROP the old tables before restarting)'
);

// +---------------------------------------------------------------------------+
// Error Messages

$LANG_ERROR = array(
    0 => 'Die hochgeladene Datei ist gr&ouml;&szlig;er als der max. erlaubte Wert (siehe upload_max_filesize in der php.ini). Lade die Datei stattdessen auf einem anderen Weg hoch, z.B. per FTP.',
    1 => 'Die hochgeladene Datei ist gr&ouml;&szlig;er als der max. erlaubte Werte (siehe MAX_FILE_SIZE im HTML-Formular). Lade die Datei stattdessen auf einem anderen Weg hoch, z.B. per FTP.',
    2 => 'Die hochgeladene Datei wurde nur teilweise &uuml;bertragen.',
    3 => 'Es wurde keine Datei hochgeladen.',
    4 => 'Verzeichnis f&uuml;r tempor&auml;re Dateien nicht gefunden.',
    5 => 'Konnte die Datei nicht abspeichern.',
    6 => 'Hochladen wegen nicht erlaubten Date-Extension abgebrochen.',
    7 => 'Die hochgeladene Datei ist gr&ouml;&szlig;er als der max. erlaubte Wert (siehe post_max_size in der php.ini). Lade die Datei stattdessen auf einem anderen Weg hoch, z.B. per FTP.',
    8 => 'Fehler',
    9 => 'Konnte keine Verbindung zur Datenbank herstellen. Fehler: ',
    10 => '&Uuml;berpr&uuml;fe die Datenbank-Einstellungen bzw. Zugangsdaten'
);

// +---------------------------------------------------------------------------+
// help.php

$LANG_HELP = array(
    0 => 'Hilfe zur Geeklog-Installation',
    'site_name' => 'Der Name Deiner Website.',
    'site_slogan' => 'Ein Motto oder eine kurze Beschreibung Deiner Website.',
    'db_type' => 'Geeklog kann wahlweise auf einer MySQL-, PostgreSQL- oder einer MS SQL-Datenbank installiert werden. Wenn Du nicht sicher bist, welche Option Du w&auml;hlen sollst, kontaktiere bitte Deinen Webhoster.</p><p class="indent"><strong>Hinweis:</strong> InnoDB-Tabellen k&ouml;nnen zu besserer Performance auf (sehr) gro&szlig;en Websites f&uuml;hren, machen den Backup-Prozess aber komplizierter.',
    'db_host' => 'Der Hostname (oder die IP-Adresse) Deines Datenbank-Servers. Typischerweise ist dies "localhost". Wenn Du nicht sicher bist, kontaktiere bitte Deinen Webhoster.',
    'db_name' => 'Der Name Deiner Datenbank. Wenn Du nicht sicher bist was das bedeutet, kontaktiere bitte Deinen Webhoster.',
    'db_user' => 'Der Username Deines Datenbank-Accounts. Wenn Du nicht sicher bist was Du eintragen sollst, kontaktiere bitte Deinen Webhoster.',
    'db_pass' => 'Das Passwort f&uuml;r Deinen Datenbank-Account. Wenn Dir das Passwort nicht bekannt ist, kontaktiere bitte Deinen Webhoster.',
    'db_prefix' => 'Manchmal will man mehrere Kopien von Geeklog in nur einer Datenbank installieren. Damit jede Geeklog-Kopie nur auf ihre eigenen Tabellen zugreift, muss man dann hier einen eindeutigen Pr&auml;fix (z.B. gl1_, gl2_, usw.)  f&uuml;r jede Kopie vergeben.',
    'site_url' => 'Dies muss die korrekte URL Deiner Website sein, d.h. die URL muss dorthin zeigen, wo die Datei <code>index.php</code> von Geeklog liegt (URL ohne abschlie&szlig;enden \'/\' angeben).',
    'site_admin_url' => 'Manche Webhoster verwenden ein vordefiniertes admin-Verzeichnis. In so einem Fall musst Du das admin-Verzeichnis von Geeklog umbenennen (z.B. in "myadmin") und diese URL dann entsprechend anpassen. Bitte nur &auml;ndern, wenn es Probleme beim Zugriff auf den Admin-Bereich von Geeklog gibt.',
    'site_mail' => 'Dies ist die Absender-Adresse f&uuml;r alle E-Mails, die von Geeklog versendet werden. Sie wird auch als Kontakt-Adresse in Newsfeeds verwendet.',
    'noreply_mail' => 'Dies ist die Absender-Adresse f&uuml;r einige automatische E-Mails, die von Geeklog versendet werden, z.B. wenn sich neue User registrieren. Dies sollte entweder die gleiche Adresse wie oben (Website-E-Mail-Adresse) sein oder eine Adresse, die nicht gelesen wird. Letzteres kann sinnvoll sein, um die tats&auml;chliche E-Mail-Adresse vor Spammern zu verbergen.',
    'utf8' => 'Dient zur Auswahl, ob UTF-8 als Zeichensatz f&uuml;r die Website verwendet werden soll. Dies empfiehlt sich vor allem bei mehrsprachigen Websites.',
    'migrate_file' => 'W&auml;hle ein Backup, das migriert werden soll. Dies kann eine Datei in Deinem "backups"-Verzeichnis sein, Du kannst eine Backup-Datei hochladen, oder Du kannst den aktuellen Inhalt der Datenbank migrieren.',
    'plugin_upload' => 'W&auml;hle ein Plugin-Archiv (in den Formaten .zip, .tar.gz oder .tgz format) zum Hochladen und Installieren.'
);

// which texts to use as labels, so they don't have to be translated again
$LANG_LABEL = array(
    'site_name'      => $LANG_INSTALL[32],
    'site_slogan'    => $LANG_INSTALL[33],
    'db_type'        => $LANG_INSTALL[34],
    'db_host'        => $LANG_INSTALL[39],
    'db_name'        => $LANG_INSTALL[40],
    'db_user'        => $LANG_INSTALL[41],
    'db_pass'        => $LANG_INSTALL[42],
    'db_prefix'      => $LANG_INSTALL[43],
    'site_url'       => $LANG_INSTALL[45],
    'site_admin_url' => $LANG_INSTALL[47],
    'site_mail'      => $LANG_INSTALL[48],
    'noreply_mail'   => $LANG_INSTALL[49],
    'utf8'           => $LANG_INSTALL[92],
    'migrate_file'   => $LANG_MIGRATE[6],
    'plugin_upload'  => $LANG_PLUGINS[10]
);

?>
