<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | german.php                                                                |
// |                                                                           |
// | German language file for the Geeklog installation script                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2008 by the following authors:                         |
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
//
// $Id: german.php,v 1.5 2008/05/01 08:46:22 dhaun Exp $

// +---------------------------------------------------------------------------+

$LANG_CHARSET = 'iso-8859-15';

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANG_NAME[XX]:  $LANG - variable name                                    |
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
    4 => 'PHP 4.1.0 required',
    5 => 'Sorry, but Geeklog requires at least PHP 4.1.0 to run (you have version ',
    6 => '). Please <a href="http://www.php.net/downloads.php">upgrade your PHP</a> install or ask your hosting service to do it for you.',
    7 => 'Unable to locate Geeklog files',
    8 => 'The installation script was unable to locate critical Geeklog files. This is probably because you have moved them from their default location. Please specify the paths to the files and directories below:',
    9 => 'Willkommen und Danke, dass Du Geeklog gew�hlt hast!',
    10 => 'File/Directory',
    11 => 'Permissions',
    12 => 'Change to',
    13 => 'Currently',
    14 => 'Change directory to',
    15 => 'Export of Geeklog headlines is switched off. The <code>backend</code> directory was not tested',
    17 => 'User photos are disabled. The <code>userphotos</code> directory was not tested',
    18 => 'Images in articles are disabled. The <code>articles</code> directory was not tested',
    19 => 'Geeklog requires certain files and directories to be writeable by the web server. Below is a list of which files and directories need to be changed.',
    20 => 'Warning!',
    21 => 'Your Geeklog and site will not work properly until the errors listed above are corrected. Please make the necessary changes before you continue.',
    22 => 'unkown',
    23 => 'Bitte w�hle eine Installationsmethode:',
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
    38 => 'InnoDB-Tabellen k�nnen zu besserer Performance auf (sehr) gro�en Websites f�hren, machen den Backup-Prozess aber komplizierter.',
    39 => 'Datenbank-Server',
    40 => 'Name der Datenbank',
    41 => 'Datenbank-Username',
    42 => 'Datenbank-Passwort',
    43 => 'Pr�fix f�r Tabellen',
    44 => 'Optionale Einstellungen',
    45 => 'URL der Website',
    46 => '(ohne Slash am Ende)',
    47 => 'Pfad f�r das "admin"-Verzeichnis',
    48 => 'Website-Email-Adresse',
    49 => '"No Reply"-Email-Adresse',
    50 => 'Installieren',
    51 => 'MySQL 3.23.2 ben�tigt',
    52 => 'Sorry, but Geeklog requires at least MySQL 3.23.2 to run (you have version ',
    53 => '). Please <a href="http://dev.mysql.com/downloads/mysql/">upgrade your MySQL</a> install or ask your hosting service to do it for you.',
    54 => 'Incorrect database information',
    55 => 'Sorry, but the database information you entered does not appear to be correct. Please go back and try again.',
    56 => 'Could not connect to database',
    57 => 'Sorry, but the installer could not find the database you specified. Either the database does not exist or you misspelled the name. Please go back and try again.',
    58 => '. Did you make sure the file is write-able by the web server?',
    59 => 'Notice:',
    60 => 'InnoDB tables are not supported by your version of MySQL. Would you like to continue the installation without InnoDB support?',
    61 => 'zur�ck',
    62 => 'weiter',
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
    82 => 'It is critical that you change permissions on the files listed below. Geeklog will not be able to be installed until you do so.',
    83 => 'Installation Error',
    84 => 'The path "',
    85 => '" does not appear to be correct. Please go back and try again.',
    86 => 'Sprache',
    87 => 'http://geeklog.info/forum/index.php?forum=1',
    88 => 'Change directory and containing files to',
    89 => 'Aktuelle Version:',
    90 => 'Empty database?',
    91 => 'It appears that either your database is empty or the database credentials you entered are incorrect. Or maybe you wanted to perform a New Install (instead of an Upgrade)? Please go back and try again.',
    92 => 'Benutze UTF-8'
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
    21 => 'aktualisiert'
);

// +---------------------------------------------------------------------------+
// help.php

$LANG_HELP = array(
    0 => 'Geeklog Installation Support',
    1 => 'Site name',
    2 => 'Slogan',
    3 => 'Database type',
    4 => 'Hostname',
    5 => 'Name',
    6 => 'Username',
    7 => 'Password',
    8 => 'Prefix',
    9 => 'Site URL',
    10 => 'Admin Directory Url',
    11 => 'Site Email',
    12 => 'Site No-Reply'
);

?>
