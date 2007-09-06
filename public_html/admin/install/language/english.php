<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | english.php                                                               |
// |                                                                           |
// | English language file for the Geeklog installation script                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2007 by the following authors:                         |
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
// $Id: english.php,v 1.5 2007/09/06 06:52:12 mwest Exp $

// +---------------------------------------------------------------------------+

$LANG_CHARSET = 'iso-8859-1';

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANG_NAME[XX]: $LANG - variable name                                    |
// |                 NAME  - where array is used                               |
// |                 XX    - phrase id number                                  |
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+
// install.php

$LANG_INSTALL = array(
    0 => 'Geeklog - The Ultimate Weblog System',
    1 => 'Installation Support',
    2 => 'The Ultimate Weblog System',
    3 => 'Geeklog Installation',
    4 => 'PHP 4.1.0 required',
    5 => 'Sorry, but Geeklog requires at least PHP 4.1.0 to run (you have version ',
    6 => '). Please <a href="http://www.php.net/downloads.php">upgrade your PHP</a> install or ask your hosting service to do it for you.',
    7 => 'Unable to locate Geeklog files',
    8 => 'The installation script was unable to locate critical Geeklog files. This is probably because you have moved them from their default location. Please specify the paths to the files and directories below:',
    9 => 'Welcome and thank you for choosing Geeklog!',
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
    23 => 'Choose your installation method:',
    24 => 'New Install',
    25 => 'Upgrade',
    26 => 'Unable to modify',
    27 => '. Did you make sure the file is write-able by the web server?',
    28 => 'siteconfig.php. Did you make sure the file is write-able by the web server?',
    29 => 'Geeklog Site',
    30 => 'Another Nifty Geeklog Site',
    31 => 'Required Configuration Information',
    32 => 'Site Name',
    33 => 'Site Slogan',
    34 => 'Database Type',
    35 => 'MySQL',
    36 => 'MySQL with InnoDB Table support',
    37 => 'Microsoft SQL',
    38 => 'InnoDB Tables may improve performance on (very) large sites, but they also make database backups more complicated.',
    39 => 'Database Hostname',
    40 => 'Database Name',
    41 => 'Database Username',
    42 => 'Database Password',
    43 => 'Database Prefix',
    44 => 'Optional Configurations',
    45 => 'Site URL',
    46 => '(No trailing slash)',
    47 => 'Admin Directory Path',
    48 => 'Site Email',
    49 => 'Site No-Reply Email',
    50 => 'Install',
    51 => 'MySQL 3.23.2 required',
    52 => 'Sorry, but Geeklog requires at least MySQL 3.23.2 to run (you have version ',
    53 => '). Please <a href="http://dev.mysql.com/downloads/mysql/">upgrade your MySQL</a> install or ask your hosting service to do it for you.',
    54 => 'Incorrect database information',
    55 => 'Sorry, but the database information you entered does not appear to be correct. Please go back and try again.',
    56 => 'Could not connect to database',
    57 => 'Sorry, but the installer could not find the database you specified. Either the database does not exist or you misspelled the name. Please go back and try again.',
    58 => '. Did you make sure the file is write-able by the web server?',
    59 => 'Notice:',
    60 => 'InnoDB tables are not supported by your version of MySQL. Would you like to continue the installation without InnoDB support?',
    61 => 'Back',
    62 => 'Continue',
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
    80 => 'Change',
    81 => 'Stop!',
    82 => 'It is critical that you change permissions on the files listed below. Geeklog will not be able to be installed until you do so.',
    83 => 'Installation Error',
    84 => 'The path "',
    85 => '" does not appear to be correct. Please go back and try again.',
    86 => 'Language',
    87 => 'http://www.geeklog.net/forum/index.php?forum=1',
    88 => 'Change directory and containing files to'
);

// +---------------------------------------------------------------------------+
// success.php

$LANG_SUCCESS = array(
    0 => 'Installation complete',
    1 => 'Installation of Geeklog ',
    2 => ' complete!',
    3 => 'Congratulations, you have successfully ',
    4 => ' Geeklog. Please take a minute to read the information displayed below.',
    5 => 'To log into your new Geeklog site, please use this account:',
    6 => 'Username:',
    7 => 'Admin',
    8 => 'Password:',
    9 => 'password',
    10 => 'Security Warning',
    11 => 'Don\'t forget to do',
    12 => 'things',
    13 => 'Remove or rename the install directory,',
    14 => 'Change the',
    15 => 'account password.',
    16 => 'Set permissions on',
    17 => 'and',
    18 => 'back to',
    19 => '<strong>Note:</strong> Because the security model has been changed, we have created a new account with the rights you need to administer your new site.  The username for this new account is <b>NewAdmin</b> and the password is <b>password</b>',    
);

// +---------------------------------------------------------------------------+
// help.php (TBD)

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
