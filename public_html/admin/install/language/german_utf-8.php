<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | german.php                                                                |
// |                                                                           |
// | German language file for the Geeklog installation script                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2022 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Randy Kolenko     - randy AT nextide DOT ca                      |
// |          Matt West         - matt AT mattdanger DOT net                   |
// |          Tom Homer         - tomhomer AT gmail DOT com                    |
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
    87 => 'https://www.geeklog.net/forum/index.php?forum=1',
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
    103 => '',
    104 => 'Der Pfad f&uuml;r das Admin-Verzeichnis ist nicht korrekt',
    105 => 'Der Pfad, den Du f&uuml;r das Admin-Verzeichnis eingegeben hast, scheint nicht korrekt zu sein. Bitte &uuml;berpr&uuml;fe Deine Eingabe und versuche es dann noch einmal.',
    106 => 'PostgreSQL',
    107 => 'F&uuml;r den produktiven Einsatz wird ein Datenbank-Passwort ben&ouml;tigt!',
    108 => 'Keine Datenbank-Treiber gefunden!',
    109 => 'Emergency Rescue Tool',
    110 => 'The permissions seem to be correct but the install script still cannot write to the Geeklog directory. If you happen to be on SELinux, make sure the httpd process has write permissions for the same, try this out:',
    111 => 'Geeklog Version',
    112 => 'Install (includes all plugins)',
    113 => 'Install (then select plugins to install)',
    114 => 'Only plugins that support being auto installed will be installed (all core plugins do). The plugins that don\'t support this can be installed via the Plugins Administration from the Geeklog Command & Control.',
    115 => 'Upgrade',
    116 => 'Clicking the "Upgrade" button will upgrade Geeklog to the latest version including all core plugins (if required).',
    117 => 'Cancel',
    118 => 'Change Language',
    119 => 'Copyright © 2020 <a href="https://www.geeklog.net/">Geeklog</a>',
    120 => '(Make sure your current database collation supports UTF-8. See <a href="help.php#charactersets">Help for more information</a>.)',
    121 => 'Home',
    122 => 'Help',
    123 => 'Character Sets and Database Collations'
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
    22 => 'migriert',
    23 => 'Would you like to delete all the files and directories used during the installation?',
    24 => 'Yes, please.',
    25 => 'No, thanks.  I will manually delete them afterwards.',
    26 => 'Remember, if you have disabled your site in <code>public_html/siteconfig.php</code>, you will need to reenable it again before you can use your site.',
    27 => 'Successfully upgraded all plugins.',
    28 => 'Failed to upgrade some plugins.  They are disabled now.'
);

// +---------------------------------------------------------------------------+
// migration

$LANG_MIGRATE = array(
    0 => 'Bei der Migration werden ggfs. Datenbank-Eintr&auml;ge &uuml;berschrieben.',
    1 => 'Vorbereitende Schritte',
    2 => 'Stelle sicher, dass alle bereits installierten Plugins auf den neuen Server kopiert wurden.',
    3 => 'Stelle sicher, dass alle Bilder aus <code>public_html/images/articles/</code>, <code>public_html/images/topics/</code>, und <code>public_html/images/userphotos/</code> auf den neuen Server kopiert wurden.',
    4 => 'Wenn Du von einer Geeklog-Version &auml;lter als <strong>1.5.0</strong> aktualisierst solltest Du sicherstellen, dass alle alten <code>config.php</code>-Dateien (von Geeklog und von den Plugins) auf den neuen Server kopiert wurden, damit die alten Einstellungen &uuml;bernommen werden k&ouml;nnen.',
    5 => 'If you\'re upgrading to a new Geeklog version during your migration and your current theme is not packaged with Geeklog, <em>then don\'t upload your theme just yet unless you are sure it supports this version of Geeklog</em>. Use the included default theme "%s" until you can be sure your migrated site works properly.',
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
    39 => 'Zlib extension is not loaded. Sorry, can\'t handle compressed database backups.',
    40 => 'Das Archiv "%1$s" scheint keine SQL-Dateien zu enthalten. Um es erneut zu versuchen, klicken Sie auf <a href="%2$s\"> hier.</a> ',
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
    10 => '&Uuml;berpr&uuml;fe die Datenbank-Einstellungen bzw. Zugangsdaten',
    11 => 'Warning',
    12 => 'Information',
    13 => '<p>The Geeklog install has detected that you are upgrading from <strong>Geeklog v%s to v%s</strong>.</p><p>Listed here are notices, warnings and/or any errors detected by the Geeklog Install. These messages are listed by the Geeklog version in case your site is several versions behind.</p><p><strong>Please read all of these important messages carefully</strong> as they pertain to your upgrade and may have additional instructions for your to follow after the upgrade or, may suggest you perform some action before the upgrade. If an <em>Error message</em> exists then you will not be able to proceed until you fix the problem.</p><p>You will find a prompt at the bottom of this page to either continue (if there are no errors) or bo back to the home install page.</p>',
    14 => 'Upgrade Notices',
    15 => 'Topic IDs and Names max length have changed from 128 to 75. This may cause issues when topic ids are truncated (if id is larger than 75 characters) during the upgrade. Please double check your topic ids that are larger than 75 characters will be unique when the max length is changed.',
    16 => 'Topic IDs and Names have changed from 128 to 75. It has been detected you need to modify 1 or more topic ids before this upgrade can proceed.',
    17 => 'Professional Theme support has been dropped from Geeklog. If you are currently using the Professional theme or Professional_css theme from Geeklog 2.1.1 or older your website may not function properly.',
    18 => 'Comment Signatures',
    19 => "Comment Signatures before Geeklog 2.2.0 where stored with the comment. Now they are added when the comment is viewed. For backwards compatibility the upgrade will remove all comment signatures stored directly
    with the comment  (so comment signatures will not display twice).",
    20 => 'Plugin Compatibility',
    21 => 'Geeklog internally has undergone some changes which may affect compatibility of some older plugins which have not been updated in a while. Please make sure all the plugins you have installed have been updated to the latest version before upgrading Geeklog to v2.2.0.<br><br>If you still wish to upgrade Geeklog to v2.2.0 and you are not sure about a plugin please post a question about it on our <a href="https://www.geeklog.net/forum/index.php?forum=2" target="_blank">Geeklog Forum</a>. Else, you can also disable or uninstall the plugin and then perform the Geeklog upgrade.<br><br>If you do perform the upgrade and run into problems you can then use the <a href="/admin/rescue.php">Geeklog Emergency Rescue Tool</a> to disable the plugin with the issue.',
    22 => 'Default Security Group Assignments',
    23 => 'User security group assignments for groups "Root" and "All Users" will be fixed along with the security group assignments for the "Admin" (2) user. The "Admin" user had duplicate permissions in some cases and these will be removed after this upgrade.<br><br>Please Note: The issue that caused duplicate permissions has been fixed but it does mean any user that you may have edited in the Admin User Editor before Geeklog v2.2.1 may have been affected. This only really affects permissions when you have security groups within security groups. While these permissions at the time of saving the user are correct if you modified security groups since then these users may still have access to groups they may have been removed from now. As each site is setup differently, the only way to fix this is for the Admin to review each user manually and confirm their security privileges.',
    24 => 'FCKEditor Removed',
    25 => 'The Advanced Editor FCKEditor has been removed from Geeklog since development for it has been stopped. If your Geeklog website is currently set to use the FCKEditor it will be updated to use the editor which currently ships with Geeklog called the CKEditor.',
    26 => 'Google+ OAuth Login',
    27 => 'The <a href="https://support.google.com/plus/answer/9195133" target="_blank">Google+ service shut down on April 2, 2019</a>. As of Geeklog v2.2.1 we will move from the Google+ OAuth authentication method and scope to the Google OAuth authentication method and scope. Because of this change and depending on when you created your Google API keys, you may need to update these keys in the Geeklog configuration or users who use this login method may receive an error.<br><br>Geeklog now offers the option to convert remote accounts to local accounts. If you have any remote accounts (like Google OAuth, Facebook OAuth, OpenID, etc..) you want to convert, edit the user account from the User Manager and then check off the "convert from remote to a local account" option and click on save. At this point the account will be converted to a local account and a random password will be generated. If the account has an email address and the status is set to "Active" an email will be automatically sent to the user about how to access their account. If not, you will manually have to fill in this information and let the user know how they can access their local account.',
    28 => 'Duplicate Usernames & Usernames with Trailing Spaces',
    29 => 'In some cases through remote accounts blank or duplicate usernames (some may have had trailing spaces) could be created. Blank username accounts are the results of remote account login errors so they will be deleted. Accounts that have duplicate names (could include local accounts) will have their accounts renamed. Some local account users may need to use the "Forget Your Password" to retrieve their new username.<br><br>Please note: This issue is a very rare occurrence and can only happen if you have remote user accounts. Most users will be unaffected.',
    30 => 'Submitted Articles with Incorrect Permissions',
    31 => 'Since Geeklog v2.0.0 the default article permissions and the Story Admin Group where not used for the default permissions when a submitted article was approved or brought up in the Article Editor. Instead the Topic Admin group and the default topic permissions for the article was used. This has now been fixed but you must manually go through and check any previously submitted articles and update their permissions if needed.<br><br>If you want all articles to belong to the Story Admin group set using your current article default permissions this can be easily done. Please check out the <a href="https://www.geeklog.net/forum/viewtopic.php?showtopic=97115" target="_blank">Geeklog Support Forum</a> for more information.',
    32 => 'Static Pages Search Results Fix',
    33 => 'If you use Static Pages with PHP or templates, the search results returned by Geeklog could show any code embedded in the page. This has now been fixed as all pages that use these features will now save a cached copy of the final executed page. This cached page is generated on the save of the page in the editor and (if page cache enabled) when a new cached file of the page is made. This means that all users that have access to the page will use the same search cache.  If autotags, PHP, or the is device_mobile template variable is used by the page this may generate different contents depending on the user. Since the search cache is only one view of the page it will be the one searched. Therefore what the search result returns may be slightly different than what the user will see when they visit the page. Please take this short coming into consideration when using template and php pages and having the "Include in Search" config option set to true (config options includesearchphp and/or includesearchtemplate).<br><br>Unfortunately, updating this search cache during the install is not possible as runtime errors could occur (if for example the page needs something that the installer cannot access) and will interrupt the install. <em>Therefore after the upgrade, before these pages search cache can be created and searched on, you must: Pages that are not cached must be saved again, Pages that use the page cache must be visited or saved again. <strong>These pages will not appear in the search results until this is done.</strong></em><br><br>For an automated script to perform this process automatically after the upgrade is complete, please check out the <a href="https://www.geeklog.net/forum/viewtopic.php?showtopic=97222" target="_blank">Geeklog Support Forum</a> for more information.',
    34 => 'Database Character Set Required',
    35 => 'Your Database Character Set has not been defined for your MySQL or PostgreSQL database. Please edit the dbconfig.php file and update the $_DB_charset variable with the appropriate database character set for your database collation and server.<br><br>Remember your Database Character Set must also be compatible with your Sites Default Character Set (which is defined in the siteconfig.php file located in the public_html directory). For more information on the different languages, character sets, and database collations for MySQL and PostgreSQL (including a table with what each should be based on your sites language), see the <a href="/docs/english/install.html" target="_blank">Geeklog install documentation</a>.'
);

// +---------------------------------------------------------------------------+
// help.php

$LANG_HELP = array(
    0 => 'Geeklog Installation Help',
    'description' => '<p>This help page explains what each field means that you may be asked to input for new Geeklog installs and migrating your Geeklog site to a new domain.</p><p>If you run into problems with installing, upgrading, or migrating your Geeklog site, please review the <a href="/docs/english/install.html">Geeklog Installation Docs</a>. For any additional questions or problems you may have, please visit the <a href="https://www.geeklog.net/forum/index.php?forum=1">Geeklog Install Support Forum</a> to read up on similar issues and post your own topic.</p>',
    'site_name' => 'Der Name Deiner Website.',
    'site_slogan' => 'Ein Motto oder eine kurze Beschreibung Deiner Website.',
    'db_type' => 'Geeklog can be installed using either a MySQL or PostgreSQL database. If you are not sure which option to select contact your hosting provider.<br><br><strong>Note</strong> InnoDB Tables may improve performance on (very) large sites, but they also make database backups more complicated.',
    'db_host' => 'Der Hostname (oder die IP-Adresse) Deines Datenbank-Servers. Typischerweise ist dies "localhost". Wenn Du nicht sicher bist, kontaktiere bitte Deinen Webhoster.',
    'db_name' => 'Der Name Deiner Datenbank. Wenn Du nicht sicher bist was das bedeutet, kontaktiere bitte Deinen Webhoster.',
    'db_user' => 'Der Username Deines Datenbank-Accounts. Wenn Du nicht sicher bist was Du eintragen sollst, kontaktiere bitte Deinen Webhoster.',
    'db_pass' => 'Das Passwort f&uuml;r Deinen Datenbank-Account. Wenn Dir das Passwort nicht bekannt ist, kontaktiere bitte Deinen Webhoster.',
    'db_prefix' => 'Manchmal will man mehrere Kopien von Geeklog in nur einer Datenbank installieren. Damit jede Geeklog-Kopie nur auf ihre eigenen Tabellen zugreift, muss man dann hier einen eindeutigen Pr&auml;fix (z.B. gl1_, gl2_, usw.)  f&uuml;r jede Kopie vergeben.',
    'site_url' => 'Dies muss die korrekte URL Deiner Website sein, d.h. die URL muss dorthin zeigen, wo die Datei <code>index.php</code> von Geeklog liegt (URL ohne abschlie&szlig;enden \'/\' angeben).',
    'site_admin_url' => 'Manche Webhoster verwenden ein vordefiniertes admin-Verzeichnis. In so einem Fall musst Du das admin-Verzeichnis von Geeklog umbenennen (z.B. in "myadmin") und diese URL dann entsprechend anpassen. Bitte nur &auml;ndern, wenn es Probleme beim Zugriff auf den Admin-Bereich von Geeklog gibt.',
    'site_mail' => 'Dies ist die Absender-Adresse f&uuml;r alle E-Mails, die von Geeklog versendet werden. Sie wird auch als Kontakt-Adresse in Newsfeeds verwendet.',
    'noreply_mail' => 'Dies ist die Absender-Adresse f&uuml;r einige automatische E-Mails, die von Geeklog versendet werden, z.B. wenn sich neue User registrieren. Dies sollte entweder die gleiche Adresse wie oben (Website-E-Mail-Adresse) sein oder eine Adresse, die nicht gelesen wird. Letzteres kann sinnvoll sein, um die tats&auml;chliche E-Mail-Adresse vor Spammern zu verbergen.',
    'utf8' => 'Indicate whether to use UTF-8 as the default character set for your site (unless your database collation is already UTF-8 then the UTF-8 character sets will be used automatically). Recommended for multi-lingual setups and required for emoji support.<br><br>This will set the database character set to UTF-8. If you have <strong>checked</strong> this setting, make sure your database collation is compatible with the character set (for MySQL usually this is either <strong>utf8_general_ci</strong> or, if you wish to support emojis <strong>utf8mb4_general_ci</strong>). <em>Checking this will not change the collation of your database, this must be done manually before you proceed with the install.</em><br><br>The Geeklog site English Language default character set is \'iso-8859-1\' (Latin-1) which is compatible with the database character set of \'latin1\' (latin1_swedish_ci) for MySQL. For new installs changing the language of the install may change the character sets used. Some of these are older legacy encoding standards that supports a limited number of languages. If you leave \'Use UTF-8\' unchecked your installs default language selection character set will be used.',
    'charactersets' => "Here are the Language character sets supported by the Geeklog Install along with their corresponding database character sets and recommended database collations. More information on character sets and database collations can be found in the <a href=\"/docs/english/install.html\">Geeklog Installation Docs</a>.
    <div class=\"uk-overflow-auto\">
    <table class=\"uk-table uk-table-striped\">
        <thead>
            <tr>
                <th>Language</th><th>Site Language Character Set</th><th>MySQL DB Character Set</th><th>MySQL DB Collation</th><th>PostgreSQL DB Character Set</th><th>PostgreSQL DB Collation</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>English</td><td>iso-8859-1</td><td>latin1</td><td>latin1_swedish_ci</td><td>LATIN1</td><td>?</td>
            </tr>
            <tr>
                <td>English (UTF-8)</td><td>utf-8</td><td>utf8/utf8mb4</td><td>utf8_general_ci/utf8mb4_general_ci</td><td>UTF8</td><td>en_US.UTF-8</td>
            </tr>
            <tr>
                <td>Japanese</td><td>utf-8</td><td>utf8</td><td>utf8_general_ci/utf8mb4_general_ci</td><td>UTF8</td><td>ja_JP.UTF-8</td>
            </tr>
            <tr>
                <td>German</td><td>iso-8859-15</td><td>latin1</td><td>latin1_swedish_ci</td><td>LATIN9</td><td>?</td>
            </tr>
            <tr>
                <td>Hebrew</td><td>utf-8</td><td>utf8</td><td>utf8_general_ci/utf8mb4_general_ci</td><td>UTF8</td><td>he_IL.UTF-8</td>
            </tr>
            <tr>
                <td>Polish</td><td>iso-8859-2</td><td>latin2</td><td>latin2_general_ci</td><td>LATIN2</td><td>?</td>
            </tr>
            <tr>
                <td>Simplified Chinese</td><td>utf-8</td><td>utf8</td><td>utf8_general_ci/utf8mb4_general_ci</td><td>UTF8</td><td>zh_CN.UTF-8</td>
            </tr>
            <tr>
                <td>Traditional Chinese</td><td>utf-8</td><td>utf8</td><td>utf8_general_ci/utf8mb4_general_ci</td><td>UTF8</td><td>zh_TW.UTF-8</td>
            </tr>
        </tbody>
    </table>
    </div>",
    'migrate_file' => 'W&auml;hle ein Backup, das migriert werden soll. Dies kann eine Datei in Deinem "backups"-Verzeichnis sein, Du kannst eine Backup-Datei hochladen, oder Du kannst den aktuellen Inhalt der Datenbank migrieren.',
    'plugin_upload' => 'W&auml;hle ein Plugin-Archiv (in den Formaten .zip, .tar.gz oder .tgz format) zum Hochladen und Installieren.'
);

// +---------------------------------------------------------------------------+
// rescue.php

$LANG_RESCUE = array(
    0 => 'Login successful',
    1 => 'Geeklog Emergency Rescue Tool',
    2 => 'Geeklog Install',
    3 => 'Geeklog Emergency Rescue Tool',
    4 => 'Do not forget to <strong>delete this {{SELF}} file once you are done!</strong>  If other users guess the password, they can seriously harm your geeklog installation!',
    5 => 'Status',
    6 => 'You are attempting to access a secure section.  You can\'t proceed until you pass the security check.',
    7 => 'In order to verify you, we require you to enter your database password.  This is the password that is stored in geeklog\'s db-config.php',
    8 => 'Password',
    9 => 'Verify Me',
    10 => 'Password incorrect!',
    11 => 'enabling ',
    12 => 'disabling ',
    13 => 'success ',
    14 => 'error ',
    15 => 'There was an error updating configs',
    16 => 'Updating configs completed successfully',
    17 => 'There was an error updating your password',
    18 => 'Geeklog password request',
    19 => 'Requested Password',
    20 => 'Someone (hopefully you) has accessed the emergency password request form and a new password:"%s" for your account "%s" on %s, has been generated.',
    21 => 'If it was not you, please check the security of your site. Make sure to remove the Emergency Rescue Form /admin/rescue.php',
    22 => 'New password has been sent to the recorded email address',
    23 => 'There was an error sending email with the subject: ',
    24 => 'PHP Information',
    25 => 'Return to main screen',
    26 => 'System Information',
    27 => 'PHP version',
    28 => 'Geeklog version',
    29 => 'Options',
    30 => 'If you happen to install a plugin or addon that brings down your geeklog site, you can remedy the problem with the options below.',
    31 => 'Enable/Disable Plugins',
    32 => 'Enable/Disable Blocks',
    33 => 'Edit Select $_CONF Values',
    34 => 'Reset Admin Password',
    35 => 'Here you can enable/disable any plugin that is currently installed on your geeklog website.',
    36 => 'Select a plugin',
    37 => 'Enable',
    38 => 'Disable',
    39 => 'Here you can enable/disable any block (except dynamic) that is currently installed on your geeklog website.',
    40 => 'Select a block',
    41 => 'Go',
    42 => 'You can edit some key $_CONF options.',
    43 => 'Here you can reset your geeklog root/admin password.',
    44 => 'Email my password',
    45 => 'Geeklog appears not to be installed or the install did not complete properly as core information is missing in the Geeklog database. Therefore this rescue tool cannot be used.'
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
	'charactersets'  => $LANG_INSTALL[123],
    'migrate_file'   => $LANG_MIGRATE[6],
    'plugin_upload'  => $LANG_PLUGINS[10]
);
