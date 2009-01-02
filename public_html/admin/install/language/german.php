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
    0 => 'Geeklog - Zuverl�ssigkeit eingebaut',
    1 => 'Hilfe zur Installation',
    2 => 'Zuverl�ssigkeit eingebaut',
    3 => 'Geeklog-Installation',
    4 => 'PHP 4.1.0 ben�tigt',
    5 => 'Sorry, Geeklog ben�tigt mindestens PHP 4.1.0 (Du hast Version ',
    6 => '). Bitte <a href="http://www.php.net/downloads.php">aktualisiere Deine PHP-Installation</a> oder bitte Deinen Hosting-Provider darum.',
    7 => 'Geeklog-Dateien nicht gefunden',
    8 => 'Das Installations-Skript hat einige wichtige Geeklog-Dateien nicht gefunden. Wahrscheinlich hast Du diese in andere Verzeichnisse verschoben. Bitte gib hier die Pfade zu den Dateien und Verzeichnissen an:',
    9 => 'Willkommen und Danke, dass Du Geeklog gew�hlt hast!',
    10 => 'Datei/Verzeichnis',
    11 => 'Zugriffsrechte',
    12 => '�ndern auf',
    13 => 'Derzeit',
    14 => 'Change directory to',
    15 => 'Export of Geeklog headlines is switched off. The <code>backend</code> directory was not tested',
    16 => 'Migration',
    17 => 'User photos are disabled. The <code>userphotos</code> directory was not tested',
    18 => 'Images in articles are disabled. The <code>articles</code> directory was not tested',
    19 => 'Geeklog setzt voraus, dass bestimmte Dateien und Verzeichnisse f�r den Webserver schreibbar sind. Es folgt eine Liste der Dateien und Verzeichnisse, die ge�ndert werden m�ssen.',
    20 => 'Warnung',
    21 => 'Geeklog und Deine Website werden nicht funktionsf�hig sein, solange diese Fehler nicht korrigiert werden. Bitte nimm die notwendigen �nderungen vor, bevor Du mit der Installation fortf�hrst.',
    22 => 'unbekannt',
    23 => 'Bitte w�hle eine Installationsmethode',
    24 => 'Neuinstallation',
    25 => 'Upgrade',
    26 => 'Unable to modify',
    27 => '. Did you make sure the file is write-able by the web server?',
    28 => 'siteconfig.php. Did you make sure the file is write-able by the web server?',
    29 => 'Geeklog Site',
    30 => 'Another Nifty Geeklog Site',
    31 => 'Erforderliche Informationen zum Setup',
    32 => 'Name der Website',
    33 => 'Site-Slogan',
    34 => 'Art der Datenbank',
    35 => 'MySQL',
    36 => 'MySQL mit Support f�r InnoDB-Tabellen',
    37 => 'Microsoft SQL',
    38 => '',
    39 => 'Datenbank-Server',
    40 => 'Name der Datenbank',
    41 => 'Datenbank-Username',
    42 => 'Datenbank-Passwort',
    43 => 'Pr�fix f�r Tabellen',
    44 => 'Optionale Einstellungen',
    45 => 'URL der Website',
    46 => '(ohne Slash am Ende)',
    47 => 'URL f. "admin"-Verzeichnis',
    48 => 'Website-Email-Adresse',
    49 => '"No Reply"-Email-Adresse',
    50 => 'Installieren',
    51 => 'MySQL 3.23.2 ben�tigt',
    52 => 'Sorry, but Geeklog requires at least MySQL 3.23.2 to run (you have version ',
    53 => '). Please <a href="http://dev.mysql.com/downloads/mysql/">upgrade your MySQL</a> install or ask your hosting service to do it for you.',
    54 => 'Datenbank-Informationen unvollst�ndig oder nicht korrekt.',
    55 => 'Sorry, but the database information you entered does not appear to be correct. Please go back and try again.',
    56 => 'Konnte keine Verbindung zum Datenbank-Server herstellen.',
    57 => 'Sorry, but the installer could not find the database you specified. Either the database does not exist or you misspelled the name. Please go back and try again.',
    58 => '. Did you make sure the file is write-able by the web server?',
    59 => 'Hinweis',
    60 => 'InnoDB tables are not supported by your version of MySQL. Would you like to continue the installation without InnoDB support?',
    61 => 'Zur�ck',
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
    73 => 'Please note this script will not upgrade any beta or release candidate versions of Geeklog.',
    74 => 'Database already up to date!',
    75 => 'It looks like your database is already up to date. You probably ran the upgrade before. If you need to run the upgrade again, please re-install your database backup and try again.',
    76 => 'Select Your Current Geeklog Version',
    77 => 'The installer was unable to determine your current version of Geeklog, please select it from the list below:',
    78 => 'Upgrade Error',
    79 => 'An error occured while upgrading your Geeklog installation.',
    80 => '�ndern',
    81 => 'Stop!',
    82 => 'Es ist unbedingt n�tig, die Zugriffsrechte der unten aufgef�hrten Dateien zu �ndern. Andernfalls wirst Du Geeklog nicht installieren k�nnen.',
    83 => 'Fehler bei der Installation',
    84 => 'Der Pfad "',
    85 => '" scheint nicht korrekt zu sein. Bitte gib den Pfad noch einmal ein.',
    86 => 'Sprache',
    87 => 'http://geeklog.info/forum/index.php?forum=1',
    88 => 'Change directory and containing files to',
    89 => 'Aktuelle Version:',
    90 => 'Leere Datenbank?',
    91 => 'It appears that either your database is empty or the database credentials you entered are incorrect. Or maybe you wanted to perform a New Install (instead of an Upgrade)? Please go back and try again.',
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
    103 => 'und zus�tzliche Plugins konfigurieren',
    104 => 'Incorrect Admin Directory Path',
    105 => 'Sorry, but the admin directory path you entered does not appear to be correct. Please go back and try again.'
);

// +---------------------------------------------------------------------------+
// success.php

$LANG_SUCCESS = array(
    0 => 'Installation erfolgreich',
    1 => 'Installation von Geeklog ',
    2 => ' abgeschlossen!',
    3 => 'Gl�ckwunsch, Du hast Geeklog erfolgreich ',
    4 => '. Bitte nimm Dir einen Moment Zeit, um die unten stehenden Informationen zu lesen.',
    5 => 'Um Dich in Deine neue Geeklog-Site einzuloggen, benutze bitte diesen Account:',
    6 => 'Username:',
    7 => 'Admin',
    8 => 'Passwort:',
    9 => 'password',
    10 => 'Sicherheitshinweis',
    11 => 'Bitte vergiss nicht, die folgenden ',
    12 => ' Dinge zu tun',
    13 => 'Das Installationsverzeichnis l�schen oder umbenennen:',
    14 => 'Das Passwort f�r den Account ',
    15 => '�ndern.',
    16 => 'Die Zugriffsrechte f�r',
    17 => 'und',
    18 => 'zur�cksetzen auf',
    19 => '<strong>Note:</strong> Because the security model has been changed, we have created a new account with the rights you need to administer your new site.  The username for this new account is <b>NewAdmin</b> and the password is <b>password</b>',
    20 => 'installiert',
    21 => 'aktualisiert',
    22 => 'migriert'
);

// +---------------------------------------------------------------------------+
// help.php

$LANG_HELP = array(
    0 => 'Geeklog Installation Support',
    1 => 'The name of your website.',
    2 => 'A simple description of your website.',
    3 => 'Geeklog can be installed using either a MySQL or Microsoft SQL database. If you are not sure which option to select contact your hosting provider.</p><p class="indent"><strong>Hinweis:</strong> InnoDB-Tabellen k�nnen zu besserer Performance auf (sehr) gro�en Websites f�hren, machen den Backup-Prozess aber komplizierter.',
    4 => 'The network name (or IP address) of your database server. This is typically "localhost". If you are not sure contact your hosting provider.',
    5 => 'The name of your database. If you are not sure what this is contact your hosting provider.',
    6 => 'Your database user account. If you are not sure what this is contact your hosting provider.',
    7 => 'Your database account password. If you are not sure what this is contact your hosting provider.',
    8 => 'Some users want to install multiple copies of Geeklog on the same database. In order for each copy of Geeklog to function correctly it must have its own unique table prefix (i.e. gl1_, gl2_, etc).',
    9 => 'Make sure this is the correct URL to your site, i.e. to where Geeklog\'s <code>index.php</code> file resides (no trailing slash).',
    10 => 'Some hosting services have a preconfigured admin directory. In that case, you need to rename Geeklog\'s admin directory to something like "myadmin" and change the following URL as well. Leave as is until you experience any problems accessing Geeklog\'s admin menu.',
    11 => 'This is the return address for all email sent by Geeklog and contact info displayed in syndication feeds.',
    12 => 'This is the sender\'s address of emails sent by the system when users register, etc. This should be either the same as Site Email or a bouncing address to prevent spammers from getting your email address by registering on the site. If this is NOT the same as above, there will be a message in sent messages that replying to those emails is recommended.',
    13 => 'Indicate whether to use UTF-8 as the default character set for your site. Recommended especially for multi-lingual setups.'
);

// +---------------------------------------------------------------------------+
// migrate.php

$LANG_MIGRATE = array(
    0 => 'The migration process will overwrite any existing database information.',
    1 => 'Before Proceding',
    2 => 'Be sure any previously installed plugins have been copied to your new server.',
    3 => 'Be sure any images from <code>public_html/images/articles/</code>, <code>public_html/images/topics/</code>, and <code>public_html/images/userphotos/</code>, have been copied to your new server.',
    4 => 'If you\'re upgrading to a new Geeklog version, then run the <a href="index.php">install script</a> in upgrade mode first.',
    5 => 'If you\'re upgrading to a new Geeklog version, then don\'t upload your theme just yet. Use the included default theme until you can be sure your migrated site works properly.',
    6 => 'Backup ausw�hlen',
    7 => 'Datei ausw�hlen...',
    8 => 'Vom backups-Verzeichnis des Webservers',
    9 => 'Von Deinem Computer',
    10 => 'Datei ausw�hlen...',
    11 => 'Keine Backup-Dateien gefunden',
    12 => 'The upload limit for this server is ',
    13 => '. If your backup file is larger than ',
    14 => ' or if you experience a timeout, then you should upload the file to Geeklog\'s backups directory via FTP.',
    15 => 'Your backups directory is not writable by the web server. Permissions need to be 777.',
    16 => 'Migration',
    17 => 'Migration vom Backup',
    18 => 'Keine Backup-Datei ausgew�hlt.',
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
    32 => 'The database file contained information for one or more plugins that the migration script could not locate in your',
    33 => 'directory. The plugins have been deactivated. You can install and reactivate them at any time from the administration section.',
    34 => 'The database file contained information for one or more files that the migration script could not locate in your',
    35 => 'directory. Check <code>error.log</code> for more details.',
    36 => 'Diese Probleme k�nnen anschlie�end von Hand korrigiert werden.',
    37 => 'Migration abgeschlossen',
    38 => 'Die Datenbank-Migration wurde erfolgreich abgeschlossen. Es wurden allerdings die folgenden Probleme gefunden:',
    39 => 'Der Pfad f�r PEAR konnte nicht gesetzt werden. Ohne PEAR k�nnen leider keine komprimierten Datenbank-Backups importiert werden.',
    40 => "Das Archiv '%s' scheint keine SQL-Dateien zu enthalten.",
    41 => "Fehler beim extrahieren des Datenbank-Backups '%s' aus dem Archiv.",
    42 => "Backup-Datei '%s' nicht (mehr) auffindbar ...",
    43 => "Import abgebrochen: Die Datei '%s' scheint kein Datenbank-Backup zu sein.",
    44 => 'Schwerer Fehler: Datenbank-Import fehlgeschlagen. Keine weitere Aktion ohne manuellen Eingriff m�glich.',
    45 => 'Version des Datenbank-Backups konnte nicht ermittelt werden. Bitte ein manuelles Update durchf�hren.',
    46 => '', // TBD
    47 => 'Update von Version %s auf Version %s fehlgeschlagen.',
    48 => 'Ein oder mehrere Plugins konnten nicht aktualisiert werden und wurden deaktiviert.'
);

// +---------------------------------------------------------------------------+
// install-plugins.php

$LANG_PLUGINS = array(
    1 => 'Plugin Installation',
    2 => 'Step',
    3 => 'Geeklog plugins are addon components that provide new functionality and leverage the internal services of Geeklog. By default, Geeklog includes a few useful plugins that you may want to install.',
    4 => 'You can also choose to upload additional plugins.',
    5 => 'The file you uploaded was not a GZip compressed plugin file.',
    6 => 'The plugin you uploaded already exists!',
    7 => 'Success!',
    8 => 'The %s plugin was uploaded successfully.',
    9 => 'Upload a plugin',
    10 => 'Select plugin file',
    11 => 'Upload',
    12 => 'Select which plugins to install',
    13 => 'Install?',
    14 => 'Plugin',
    15 => 'Version',
    16 => 'Unknown',
    17 => 'Note',
    18 => 'This plugin requires manual activation from the Plugins admin panel.',
    19 => 'Refresh',
    20 => 'There are no new plugins to install.'
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
// Error messages

$LANG_ERROR = array(
    0 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.' . ' Please upload your backup file using another method, such as FTP.',
    1 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.' . ' Please upload your backup file using another method, such as FTP.',
    2 => 'The uploaded file was only partially uploaded.',
    3 => 'No file was uploaded.',
    4 => 'Missing a temporary folder.',
    5 => 'Failed to write file to disk.',
    6 => 'File upload stopped by extension.',
    7 => 'The uploaded file exceeds the post_max_size directive in your php.ini. Please upload your database file using another method, such as FTP.',
    8 => 'Error',
    9 => 'Failed to connect to the database with the error: ',
    10 => 'Check your database settings'
);

?>
