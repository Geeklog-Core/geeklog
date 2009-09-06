<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | german.php                                                                |
// |                                                                           |
// | German language file for the Geeklog installation script                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Randy Kolenko     - randy AT nextide DOT ca
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
    15 => 'Export of Geeklog headlines is switched off. The <code>backend</code> directory was not tested',
    16 => 'Migration',
    17 => 'User photos are disabled. The <code>userphotos</code> directory was not tested',
    18 => 'Images in articles are disabled. The <code>articles</code> directory was not tested',
    19 => 'Geeklog setzt voraus, dass bestimmte Dateien und Verzeichnisse f&uuml;r den Webserver schreibbar sind. Es folgt eine Liste der Dateien und Verzeichnisse, die ge&auml;ndert werden m&uuml;ssen.',
    20 => 'Warnung',
    21 => 'Geeklog und Deine Website werden nicht funktionsf&auml;hig sein, solange diese Fehler nicht korrigiert werden. Bitte nimm die notwendigen &Auml;nderungen vor, bevor Du mit der Installation fortf&auml;hrst.',
    22 => 'unbekannt',
    23 => 'Bitte w&auml;hle eine Installationsmethode',
    24 => 'Neuinstallation',
    25 => 'Upgrade',
    26 => 'Unable to modify',
    27 => '. Did you make sure the file is write-able by the web server?',
    28 => 'siteconfig.php. Did you make sure the file is write-able by the web server?',
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
    48 => 'Website-Email-Adresse',
    49 => '"No Reply"-Email-Adresse',
    50 => 'Installieren',
    51 => 'MySQL %s ben&ouml;tigt',
    52 => 'Sorry, aber Geeklog setzt mindestens MySQL %s voraus (Du hast Version ',
    53 => '). Bitte <a href="http://dev.mysql.com/downloads/mysql/">aktualisiere Deine MySQL-Version</a> oder bitte Deinen Website-Hoster, es f&uuml;r Dich zu erledigen.',
    54 => 'Datenbank-Informationen unvollst&auml;ndig oder nicht korrekt.',
    55 => 'Sorry, aber die Datenbank-Informationen, die Du eingegeben hast, scheinen nicht korrekt zu sein. Bitte klicke auf "Zur&uuml;ck" und versuche es noch einmal.',
    56 => 'Konnte keine Verbindung zum Datenbank-Server herstellen.',
    57 => 'Sorry, but the installer could not find the database you specified. Either the database does not exist or you misspelled the name. Please go back and try again.',
    58 => '. Did you make sure the file is write-able by the web server?',
    59 => 'Hinweis',
    60 => 'InnoDB tables are not supported by your version of MySQL. Would you like to continue the installation without InnoDB support?',
    61 => 'Zur&uuml;ck',
    62 => 'Weiter',
    63 => 'An installed Geeklog database already exists. The installer will not allow you to run a fresh install on an existing Geeklog database. To continue you must do one of the following:',
    64 => 'Delete the tables from the existing database. Or simply drop the database and recreate it. Then click "Retry" below.',
    65 => 'Perform an upgrade on your database (to a newer Geeklog version) by selecting the "Upgrade" option below.',
    66 => 'Retry',
    67 => 'Error Setting up the Geeklog Database',
    68 => 'The database is not empty. Please drop all tables in the database and start again.',
    69 => 'Upgrading Geeklog',
    70 => 'Before we get started it is important that you back up your database current Geeklog files. This installation script will alter your Geeklog database so if something goes wrong and you need to restart the upgrade process, you will need a backup of your original database. YOU HAVE BEEN WARNED!',
    71 => 'Please make sure to select the correct Geeklog version you are coming from below. This script will do incremental upgrades after this version (i.e. you can upgrade directly from any old version to ',
    72 => ').',
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
    97 => 'Set File Permissions',
    98 => 'Advanced Users',
    99 => 'If you have command line (SSH) access to your web server then you can simple copy and paste the following command into your shell:',
    100 => 'Invalid mode specified',
    101 => 'Schritt',
    102 => 'Konfigurations-Informationen eingeben',
    103 => 'und zus&auml;tzliche Plugins konfigurieren',
    104 => 'Der Pfad f&uuml;r das Admin-Verzeichnis ist nicht korrekt',
    105 => 'Der Pfad, den Du f&uuml;r das Admin-Verzeichnis eingegeben hast, scheint nicht korrekt zu sein. Bitte &uuml;berpr&uuml;fe Deine Eingabe und versuche es dann noch einmal.'
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
    12 => 'The upload limit for this server is ',
    13 => '. If your backup file is larger than ',
    14 => ' or if you experience a timeout, then you should upload the file to Geeklog\'s backups directory via FTP.',
    15 => 'Your backups directory is not writable by the web server. Permissions need to be 777.',
    16 => 'Migration',
    17 => 'Migration vom Backup',
    18 => 'Keine Backup-Datei ausgew&auml;hlt.',
    19 => 'Could not save ',
    20 => ' to ',
    21 => 'Die Datei',
    22 => 'existiert schon. Willst Du sie ersetzen?',
    23 => 'Ja',
    24 => 'Nein',
    25 => 'The version of Geeklog you chose to migrate from is out of date.',
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
    11 => 'Stopped at the line ',
    12 => '. At this place the current query is from csv file, but ',
    13 => ' was not set.',
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
    0 => 'Geeklog Installation Support',
    'site_name' => 'The name of your website.',
    'site_slogan' => 'A simple description of your website.',
    'db_type' => 'Geeklog can be installed using either a MySQL or Microsoft SQL database. If you are not sure which option to select contact your hosting provider.</p><p class="indent"><strong>Hinweis:</strong> InnoDB-Tabellen k&ouml;nnen zu besserer Performance auf (sehr) gro&szlig;en Websites f&uuml;hren, machen den Backup-Prozess aber komplizierter.',
    'db_host' => 'The network name (or IP address) of your database server. This is typically "localhost". If you are not sure contact your hosting provider.',
    'db_name' => 'The name of your database. If you are not sure what this is contact your hosting provider.',
    'db_user' => 'Your database user account. If you are not sure what this is contact your hosting provider.',
    'db_pass' => 'Your database account password. If you are not sure what this is contact your hosting provider.',
    'db_prefix' => 'Some users want to install multiple copies of Geeklog on the same database. In order for each copy of Geeklog to function correctly it must have its own unique table prefix (i.e. gl1_, gl2_, etc).',
    'site_url' => 'Make sure this is the correct URL to your site, i.e. to where Geeklog\'s <code>index.php</code> file resides (no trailing slash).',
    'site_admin_url' => 'Some hosting services have a preconfigured admin directory. In that case, you need to rename Geeklog\'s admin directory to something like "myadmin" and change the following URL as well. Leave as is until you experience any problems accessing Geeklog\'s admin menu.',
    'site_mail' => 'This is the return address for all email sent by Geeklog and contact info displayed in syndication feeds.',
    'noreply_mail' => 'This is the sender\'s address of emails sent by the system when users register, etc. This should be either the same as Site Email or a bouncing address to prevent spammers from getting your email address by registering on the site. If this is NOT the same as above, there will be a message in sent messages that replying to those emails is recommended.',
    'utf8' => 'Indicate whether to use UTF-8 as the default character set for your site. Recommended especially for multi-lingual setups.',
    'migrate_file' => 'Choose the backup file you want to migrate. This can either be an exisiting file in your "backups" directory or you can upload a file from your computer.',
    'plugin_upload' => 'Choose a plugin archive (in .zip, .tar.gz, or .tgz format) to upload and install.'
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
