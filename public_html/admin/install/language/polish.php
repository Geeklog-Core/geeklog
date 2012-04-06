<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | polish.php                                                                |
// |                                                                           |
// | Polish language file for the Geeklog installation script                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
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

$LANG_CHARSET = 'ISO-8859-2';

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANG_NAME[XX]: $LANG - variable name                                     |
// |                 NAME  - where array is used                               |
// |                 XX    - phrase id number                                  |
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+
// install.php

$LANG_INSTALL = array(
    0 => 'Geeklog - The secure CMS.',
    1 => 'Instalacja Pomoc',
    2 => 'The secure CMS.',
    3 => 'Geeklog - Instalacja',
    4 => 'Wymagane PHP %s',
    5 => 'Sorry, ale Geeklog wymaga do uruchomienia co najmniej PHP %s (wersja zainstalowana to ',
    6 => '). Proszê <a href="http://www.php.net/downloads.php">uaktualniæ wersjê PHP</a> lub zg³osiæ to do swojego providera hostingu.',
    7 => 'Nie mo¿na zlokalizowaæ plików Geeklog-a',
    8 => 'The installation script was unable to locate critical Geeklog files. This is probably because you have moved them from their default location. Please specify the paths to the files and directories below:',
    9 => 'Witamy i dziêkujemy za wybranie Geeklog-a!',
    10 => 'File/Directory',
    11 => 'Permissions',
    12 => 'Change to',
    13 => 'Currently',
    14 => '',
    15 => 'Export of Geeklog headlines is switched off. The <code>backend</code> directory was not tested',
    16 => 'Migrate',
    17 => 'User photos are disabled. The <code>userphotos</code> directory was not tested',
    18 => 'Images in articles are disabled. The <code>articles</code> directory was not tested',
    19 => 'Geeklog requires certain files and directories to be writeable by the web server. Below is a list of which files and directories need to be changed.',
    20 => 'Ostrze¿enie!',
    21 => 'Your Geeklog and site will not work properly until the errors listed above are corrected. Not following this step is the #1 reason why people receive errors when they first try to use Geeklog. Please make the necessary changes before you continue.',
    22 => 'unknown',
    23 => 'Wybierz rodzaj instalacji:',
    24 => 'Nowa',
    25 => 'Aktualizacja',
    26 => 'Unable to modify',
    27 => '. Did you make sure the file is writable by the web server?',
    28 => 'siteconfig.php. Did you make sure the file is writable by the web server?',
    29 => 'Geeklog Site',
    30 => 'Another Nifty Geeklog Site',
    31 => 'Wymagane Informacje do Konfiguracji',
    32 => 'Nazwa Strony',
    33 => 'Slogan',
    34 => 'Rodzaj Bazy Danych',
    35 => 'MySQL',
    36 => 'MySQL ze wsparciem Table InnoDB',
    37 => 'Microsoft SQL',
    38 => 'Error',
    39 => 'Database Hostname',
    40 => 'Nazwa Bazy Danych',
    41 => 'U¿ytkownik Bazy Danych',
    42 => 'Has³o do Bazy Danych',
    43 => 'Prefix Tabeli w Bazie Danych',
    44 => 'Ustawienia Opcjonalne',
    45 => 'Adres URL strony',
    46 => '(Bez koñcowego slasha)',
    47 => '¦cie¿ka do katalogu administratora',
    48 => 'Adres email strony',
    49 => 'Bezzwrotny adres email strony',
    50 => 'Instaluj',
    51 => 'Wymagana baza MySQL %s',
    52 => 'Sorry, but Geeklog requires at least MySQL %s to run (you have version ',
    53 => '). Please <a href="http://dev.mysql.com/downloads/mysql/">upgrade your MySQL</a> install or ask your hosting service to do it for you.',
    54 => 'Ba³êdne informacje o bazie danych',
    55 => 'Sorry, but the database information you entered does not appear to be correct. Please go back and try again.',
    56 => 'Could not connect to database',
    57 => 'Sorry, but the installer could not find the database you specified. Either the database does not exist or you misspelled the name. Please go back and try again.',
    58 => '. Did you make sure the file is writable by the web server?',
    59 => 'Notice:',
    60 => 'InnoDB tables are not supported by your version of MySQL. Would you like to continue the installation without InnoDB support?',
    61 => 'Back',
    62 => 'Continue',
    63 => 'An installed Geeklog database already exists. The installer will not allow you to run a fresh install on an existing Geeklog database. To continue you must do one of the following:',
    64 => 'Delete the tables from the existing database. Or simply drop the database and recreate it. Then click "Retry" below.',
    65 => 'Perform an upgrade on your database (to a newer Geeklog version) by selecting the "Upgrade" option below.',
    66 => 'Spróbuj ponownie',
    67 => 'Error Setting up the Geeklog Database',
    68 => 'The database is not empty. Please drop all tables in the database and start again.',
    69 => 'Aktualizacja Geeklog-a',
    70 => 'Before we get started it is important that you back up your database and the current Geeklog files. This installation script will alter your Geeklog database so if something goes wrong and you need to restart the upgrade process, you will need a backup of your original database. YOU HAVE BEEN WARNED!',
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
    83 => 'B³±d Podczas Instalacji',
    84 => '¦cie¿ka "',
    85 => '" jest b³êdna. Wróæ i srpóbuj ponownie.',
    86 => 'Jêzyk',
    87 => 'http://www.geeklog.net/forum/index.php?forum=1',
    88 => 'Change directory and containing files to',
    89 => 'Wersja Obecna:',
    90 => 'Opró¿niæ bazê danych?',
    91 => 'It appears that either your database is empty or the database credentials you entered are incorrect. Or maybe you wanted to perform a New Install (instead of an Upgrade)? Please go back and try again.',
    92 => 'U¿yj kodowania UTF-8',
    93 => 'Success',
    94 => 'Here are some hints to find the correct path:',
    95 => 'The complete path to this file (the install script) is:',
    96 => 'The installer was looking for %s in:',
    97 => 'Set File Permissions',
    98 => 'Advanced Users',
    99 => 'If you have command line (SSH) access to your web server then you can simply copy and paste the following command into your shell:',
    100 => 'Invalid mode specified',
    101 => 'Step',
    102 => 'Enter configuration information',
    103 => 'and configure additional plugins',
    104 => 'Incorrect Admin Directory Path',
    105 => 'Sorry, but the admin directory path you entered does not appear to be correct. Please go back and try again.',
    106 => 'PostgreSQL',
    107 => 'Database Password is required for production environments.',
    108 => 'No Database Drivers found!',
    109 => 'Emergency Rescue Tool'
);

// +---------------------------------------------------------------------------+
// success.php

$LANG_SUCCESS = array(
    0 => 'Instalacja zakoñczona',
    1 => 'Instalacja Geeklog-a ',
    2 => ' zakoñczona!',
    3 => 'Gratulacje, pomy¶lnie ',
    4 => ' Geeklog-a. Proszê po¶wiêciæ chwilê na przeczytanie informacji poni¿ej.',
    5 => 'Aby zalogowaæ siê proszê u¿yæ nastêpuj±cego konta:',
    6 => 'U¿ytkownik:',
    7 => 'Admin',
    8 => 'Has³o:',
    9 => 'password',
    10 => 'UWAGA!',
    11 => 'Nie zapomnij o ',
    12 => 'rzeczach',
    13 => 'Usuñ lub zmieñ nazwê katalogu z plikami instalacyjnymi,',
    14 => 'Zmieñ has³o dla konta',
    15 => '.',
    16 => 'Zmieñ atrybuty dostêpu do plików ',
    17 => 'i',
    18 => 'z powrotem na',
    19 => '<strong>Note:</strong> Because the security model has been changed, we have created a new account with the rights you need to administer your new site.  The username for this new account is <b>NewAdmin</b> and the password is <b>password</b>',
    20 => 'zainstalowano',
    21 => 'aktualizowano',
    22 => 'migrated'
);

// +---------------------------------------------------------------------------+
// migrate.php

$LANG_MIGRATE = array(
    0 => 'The migration process will overwrite any existing database information.',
    1 => 'Before Proceding',
    2 => 'Be sure any previously installed plugins have been copied to your new server.',
    3 => 'Be sure any images from <code>public_html/images/articles/</code>, <code>public_html/images/topics/</code>, and <code>public_html/images/userphotos/</code>, have been copied to your new server.',
    4 => 'If you\'re upgrading from a Geeklog version older than <strong>1.5.0</strong>, then make sure to copy over all your old <tt>config.php</tt> files so that the migration can pick up your settings.',
    5 => 'If you\'re upgrading to a new Geeklog version, then don\'t upload your theme just yet. Use the included default theme until you can be sure your migrated site works properly.',
    6 => 'Select an existing backup',
    7 => 'Choose file...',
    8 => 'From the server\'s backups directory',
    9 => 'From your computer',
    10 => 'Choose file...',
    11 => 'No backup files found.',
    12 => 'The upload limit for this server is ',
    13 => '. If your backup file is larger than ',
    14 => ' or if you experience a timeout, then you should upload the file to Geeklog\'s backups directory via FTP.',
    15 => 'Your backups directory is not writable by the web server. Permissions need to be 777.',
    16 => 'Migrate',
    17 => 'Migrate From Backup',
    18 => 'No backup file was selected',
    19 => 'Could not save ',
    20 => ' to ',
    21 => 'The file',
    22 => 'already exists. Would you like to replace it?',
    23 => 'Yes',
    24 => 'No',
    25 => '',
    26 => 'Migration notice: ',
    27 => 'The "',
    28 => '" plugin is missing and has been disabled. You can install and reactivate it at any time from the administration section.',
    29 => 'The image "',
    30 => '" listed in the "',
    31 => '" table could not be found in ',
    32 => 'The database file contained information for one or more plugins that the migration script could not locate in your',
    33 => 'directory. The plugins have been deactivated. You can install and reactivate them at any time from the administration section.',
    34 => 'The database file contained information for one or more files that the migration script could not locate in your',
    35 => 'directory. Check <code>error.log</code> for more details.',
    36 => 'You can correct these any time.',
    37 => 'Migration Complete',
    38 => 'The migration process has completed. However, the installation script found the following issues:',
    39 => 'Failed to set PEAR include path. Sorry, can\'t handle compressed database backups without PEAR.',
    40 => 'The archive \'%s\' does not appear to contain any SQL files.',
    41 => 'Error extracting database backup \'%s\' from compressed backup file.',
    42 => 'Backup file \'%s\' just vanished ...',
    43 => 'Import aborted: The file \'%s\' does not appear to be an SQL dump.',
    44 => 'Fatal error: Database import seems to have failed. Don\'t know how to continue.',
    45 => 'Could not identify database version. Please perform a manual update.',
    46 => '',
    47 => 'Database upgrade from version %s to version %s failed.',
    48 => 'One or more plugins could not be updated and had to be disabled.',
    49 => 'Use current database content'
);

// +---------------------------------------------------------------------------+
// install-plugins.php

$LANG_PLUGINS = array(
    1 => 'Plugin Installation',
    2 => 'Step',
    3 => 'Geeklog plugins are addon components that provide new functionality and leverage the internal services of Geeklog. By default, Geeklog includes a few useful plugins that you may want to install.',
    4 => 'You can also choose to upload additional plugins.',
    5 => 'The file you uploaded was not a ZIP or GZip compressed plugin file.',
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
    8 => 'Processing file:',
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
    22 => 'Progress',
    23 => 'The database migration completed successfully! You will be forwarded momentarily.',
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
    0 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini. Please upload your backup file using another method, such as FTP.',
    1 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form. Please upload your backup file using another method, such as FTP.',
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

// +---------------------------------------------------------------------------+
// help.php

$LANG_HELP = array(
    0 => 'Geeklog Wsparcie Instalacji',
    'site_name' => 'Nazwa Twojej Strony.',
    'site_slogan' => 'Prosty opis Twojej strony.',
    'db_type' => 'Geeklog can be installed using either a MySQL, PostgreSQL or Microsoft SQL database. If you are not sure which option to select contact your hosting provider.</p><p class="indent"><strong>Note:</strong> InnoDB Tables may improve performance on (very) large sites, but they also make database backups more complicated.',
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
    'migrate_file' => 'Choose the backup file you want to migrate. This can either be an exisiting file in your "backups" directory or you can upload a file from your computer. Alternatively, you can also migrate the current contents of the database.',
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
