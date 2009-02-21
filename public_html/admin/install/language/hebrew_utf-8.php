<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | hebrew_utf-8.php                                                          |
// |                                                                           |
// | Hebrew language file for the Geeklog installation script                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2009                                                   |
// | http://lior.weissbrod.com                                                 |
// | Version 1.5#1                                                             |
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

$LANG_CHARSET = 'utf-8';
$LANG_DIRECTION = 'rtl';

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANG_NAME[XX]: $LANG - variable name                                     |
// |                 NAME  - where array is used                               |
// |                 XX    - phrase id number                                  |
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+
// install.php

$LANG_INSTALL = array(
    0 => 'Geeklog - The Ultimate Weblog System',
    1 => 'תמיכת התקנה',
    2 => 'The Ultimate Weblog System',
    3 => 'התקנת Geeklog',
    4 => 'דרוש PHP 4.3.0',
    5 => 'מצטערים, אבל Geeklog דורש לפחות PHP 4.3.0 בשביל לרוץ (לכם יש גירסה ',
    6 => '). אנא <a href="http://www.php.net/downloads.php">שדרגו את גירסת ה-PHP שלכם</a> או בקשו ממארחי השרת שלכם לעשות זאת בשבילכם.',
    7 => 'לא אותרו הקבצים של Geeklog',
    8 => 'קובץ ההתקנה לא הצליח לאתר את הקבצים החשובים של Geeklog. זה כנראה מפני שהיזזתם אותם ממיקום ברירת המחדל שלהם. אנא ציינו את הנתיבים לקבצים ולספריות להלן:',
    9 => 'ברוכים הבאים ותודה לכם שבחרתם Geeklog!',
    10 => 'קובץ/ספרייה',
    11 => 'הרשאות',
    12 => 'שנו ל',
    13 => 'כרגע',
    14 => 'שנו את הספרייה ל',
    15 => 'ייצוא הכותרות ב-Geeklog מכובה. ספריית ה-<code>backend</code> לא נבדקה',
    16 => 'Migrate',
    17 => 'התמונות של המשתמשים מנוטרלים. ספריית ה-<code>userphotos</code> לא נבדקה',
    18 => 'התמונות במאמרים מנוטרלים. ספריית ה-<code>articles</code> לא נבדקה',
    19 => 'Geeklog צריך שקבצים וספריות מסוימות יהיו ניתנים לכתיבה על ידי השרת. להלן רשימת הקבצים והספריות שצריכים להשתנות.',
    20 => 'אזהרה!',
    21 => 'המערכת לניהול תוכן והאתר לא יעבדו כמו שצריך עד שיתוקנו הבעיות המצוינות לעיל. כישלון בקיום הצעד הזה הוא הסיבה מספר אחת שאנשים מקבלים שגיאות כשהם מנסים בפעם הראשונה להריץ את Geeklog. אנא בצעו את השינויים הדרושים לפני שהנכם ממשיכים.',
    22 => 'לא ידוע',
    23 => 'ביחרו את שיטת ההתקנה שלכם:',
    24 => 'התקנה חדשה',
    25 => 'שידרוג',
    26 => 'השינוי לא מצליח',
    27 => '. האם וידאתם שהקובץ ניתן לכתיבה על ידי השרת?',
    28 => 'siteconfig.php. האם וידאתם שהקובץ ניתן לכתיבה על ידי השרת?',
    29 => 'אתר Geeklog',
    30 => 'עוד אתר מעניין של Geeklog',
    31 => 'מידע הגדרות הכרחיות',
    32 => 'שם האתר',
    33 => 'סלוגן האתר',
    34 => 'סוג מאגר המידע',
    35 => 'MySQL',
    36 => 'MySQL עם תמיכה בטבלת InnoDB',
    37 => 'Microsoft SQL',
    38 => '',
    39 => 'שם השרת של מאגר המידע',
    40 => 'שם מאגר המידע',
    41 => 'שם המשתמש של מאגר המידע',
    42 => 'הסיסמה למאגר המידע',
    43 => 'תחילית הטבלאות במאגר המידע',
    44 => 'הגדרות אופציונליות',
    45 => 'כתובת האתר',
    46 => '(ללא לוכסן בסוף)',
    47 => 'נתיב ספריית ה-admin',
    48 => 'כתובת האימייל של האתר',
    49 => 'כתובת האימייל של No-Reply',
    50 => 'התקנה',
    51 => 'נדרש MySQL 3.23.2',
    52 => 'מצטערים, אך Geeklog דורש לפחות MySQL 3.23.2 כדי לרוץ (לכם יש גירסה ',
    53 => '). אנא <a href="http://dev.mysql.com/downloads/mysql/">שדרגו את גירסת ה-MySQL שלכם</a> או בקשו ממארחי השרת שלכם לעשות זאת בשבילכם.',
    54 => 'מידע מאגר המידע אינו נכון',
    55 => 'מצטערים, אך מידע מאגר המידע שציינתם נראה שגוי. אנא חיזרו ונסו שוב.',
    56 => 'החיבור למאגר המידע נכשל',
    57 => 'מצטערים, אך ההתקנה לא הצליחה למצוא את מאגר המידע שציינתם. מאגר המידע אינו קיים או ששגיתם באיות שמו. אנא חיזרו ונסו שוב.',
    58 => '. האם וידאתם שהקובץ ניתן לכתיבה על ידי השרת?',
    59 => 'הערה:',
    60 => 'טבלאות InnoDB אינן נתמכות על ידי גירסת ה-MySQL שלכם. האם תרצו להמשיך את ההתקנה ללא תמיכה ב-InnoDB?',
    61 => 'חזרה',
    62 => 'המשך',
    63 => 'כבר מותקן מאגר מידע של Geeklog. ההתקנה לא תאפשר לכם להריץ התקנה חדשה על מאגר מידע Geeklog קיים. כדי להמשיך הנכם חייבים לעשות אחד מהדברים הבאים:',
    64 => 'מיחקו את הטבלאות ממאגר המידע הקיים. או פשוט מיחקו את מאגר המידע וצרו אותו צחדש. ליחצו על "נסיון חוזר" שלהלן.',
    65 => 'בצעו שידרוג למאגר מידע (לגירסת Geeklog חדשה) על ידי בחירת אופציית השידרוג שלהלן.',
    66 => 'נסיון חוזר',
    67 => 'שגיאה בהקמת מאגר המידע של Geeklog', 
    68 => 'מאגר המידע אינו ריק. אנא מיחקו את כל הטבלאות במאגר המידע והתחילו מחדש.',
    69 => 'שידרוג Geeklog',
    70 => 'לפני שנתחיל חשוב שתגבו את מאגר המידע של Geeklog הנוכחי שלכם. ההתקנה תשנה את מאגר המידע של Geeklog כך שאם משהו ישתבש ותאולצו להתחיל מחדש את תהליך השידרוג, תצטרכו גיבוי של מאגר המידע המקורי. *ראו הוזהרתם!*',
    71 => 'אנא ודאו שבחרתם את הגירסה הנכונה של Geeklog שאותה תרצו לשדרג. ההתקנה משדרגת בשלבים לפי כל גרסה החל מהגירסה שבחרתם (כלומר תוכלו לשדרג ישירות מכל גירסה ישנה היישר אל ',
    72 => ').',
    73 => 'אנא שימו לב שההתקנה לא תשדרג שום גרסת בטה או גרסה מועמדת לשיחרור של Geeklog.',
    74 => 'מאגר המידע כבר מעודכן!',
    75 => 'נראה שמאגר המידע שלכם כבר מעודכן. כנראה שהרצתם כבר שדרוג. אם אתם צריכים להריץ את השידרוג מחדש, אנא התקינו מחדש את גיבוי מאגר המידע שלכם ונסו שוב.',
    76 => 'בחירת גרסת ה-Geeklog הנוכחית שלכם',
    77 => 'ההתקנה לא הצליחה לזהות את הגירסה הנוכחית שלכם של Geeklog, אנא ביחרו אותה מהרשימה שלהלן:',
    78 => 'תקלה בשידרוג',
    79 => 'חלה תקלה בזמן השידרוג של התקנת Geeklog שלכם.',
    80 => 'שינוי',
    81 => 'הפסק!',
    82 => 'חשוב מאוד שתשנו את הרשאות הקבצים הרשומים להלן. Geeklog לא יצליח לעבור התקנה עד שתעשו זאת.',
    83 => 'תקלה בהתקנה',
    84 => 'הנתיב "',
    85 => '" נראה שאינו נכון. אנא חיזרו ונסו שוב.',
    86 => 'שפה',
    87 => 'http://www.geeklog.net/forum/index.php?forum=1',
    88 => 'שינוי הספרייה והקבצים שבה ל',
    89 => 'גירסה נוכחית:',
    90 => 'מאגר מידע ריק?',
    91 => 'נראה שמאגר המידע שלכם ריק או שהגדרות ההזדהות שציינתם בשבילו אינן נכונות. או שאולי התכוונתם לבצע התקנה חדשה (ולא שידרוג)? אנא חיזרו ונסו שוב.',
    92 => 'שימוש ב-UTF-8',
    93 => 'Success',
    94 => 'Here are some hints to find the correct path:',
    95 => 'The complete path to this file (the install script) is:',
    96 => 'The installer was looking for %s in:',
    97 => 'Set File Permissions',
    98 => 'Advanced Users',
    99 => 'If you have command line (SSH) access to your web server then you can simple copy and paste the following command into your shell:',
    100 => 'Invalid mode specified',
    101 => 'Step',
    102 => 'Enter configuration information',
    103 => 'and configure additional plugins',
    104 => 'Incorrect Admin Directory Path',
    105 => 'Sorry, but the admin directory path you entered does not appear to be correct. Please go back and try again.'
);

// +---------------------------------------------------------------------------+
// success.php

$LANG_SUCCESS = array(
    0 => 'ההתקנה הושלמה',
    1 => 'ההתקנה של Geeklog ',
    2 => ' הושלמה!',
    3 => 'כל הכבוד, הצלחתם ',
    4 => ' Geeklog. אנא קחו רגע כדי לקרוא את המידע המצוין להלן.',
    5 => 'כדי להזדהות באתר ה-Geeklog החדש שלכם, אנא השתמשו בחשבון זה:',
    6 => 'שם משתמש:',
    7 => 'Admin',
    8 => 'סיסמה:',
    9 => 'password',
    10 => 'אזהרת אבטחה',
    11 => 'אל תשכחו לבצע',
    12 => 'דברים',
    13 => 'להסיר או לשנות את שם ספריית ההתקנה,',
    14 => 'לשנות ל-',
    15 => 'את סיסמת החשבון.',
    16 => 'לשנות את ההרשאות של',
    17 => 'וגם של',
    18 => 'בחזרה ל:',
    19 => '<strong>שימו לב:</strong> עקב כך ששונה מודל האבטחה, יצרנו חשבון חדש עם ההרשאות שהנכם זקוקים להן כדי לנהל את אתרכם החדש.  שם המשתמש של חשבון חדש זה הוא <b>NewAdmin</b> והסיסמה היא <b>password</b>',
    20 => 'להתקין את',
    21 => 'לשדרג את'
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
    25 => 'The version of Geeklog you chose to migrate from is out of date.',
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
    39 => "Failed to set PEAR include path. Sorry, can't handle compressed database backups without PEAR.",
    40 => "The archive '%s' does not appear to contain any SQL files.",
    41 => "Error extracting database backup '%s' from compressed backup file.",
    42 => "Backup file '%s' just vanished ...",
    43 => "Import aborted: The file '%s' does not appear to be an SQL dump.",
    44 => "Fatal error: Database import seems to have failed. Don't know how to continue.",
    45 => "Could not identify database version. Please perform a manual update.",
    46 => '', // TBD
    47 => 'Database upgrade from version %s to version %s failed.',
    48 => 'One or more plugins could not be updated and had to be disabled.'
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

// +---------------------------------------------------------------------------+
// help.php

$LANG_HELP = array(
    0 => 'תמיכה בהתקנת Geeklog',
    'site_name' => 'שם האתר שלכם.',
    'site_slogan' => 'תיאור פשוט של האתר שלכם.',
    'db_type' => 'Geeklog יכול להיות מותקן בעזרת שימוש ב-MySQL או Microsoft SQL database. אם אינכם בטוחים איזו אופצייה לבחור עליכם ליצור קשר עם מארחי השרת שלכם.</p><p class="indent"><strong>שימו לב:</strong> טבלאות InnoDB עשויות לשפר את הביצועים באתרים (מאוד) גדולים, אך גם להפוך את גיבויי מאגר המידע ליותר מסובכים.',
    'db_host' => 'שם הרשת (או כתובת ה-IP) של שרת מאגר המידע שלכם. בדרך כלל זהו "localhost". אם אינכם בטוחים צרו קשר אם מארחי השרת שלכם.',
    'db_name' => 'שם מאגר המידע שלכם. אם אינכם בטוחים מהו צרו קשר עם מארחי השרת שלכם.',
    'db_user' => 'שם המשתמש של מאגר המידע שלכם. אם אינכם בטוחים מהו צרו קשר עם מארחי השרת שלכם.',
    'db_pass' => 'סיסמת מאגר המידע שלכם. אם אינכם בטוחים מהי צרו קשר עם מארחי השרת שלכם.',
    'db_prefix' => 'חלק מהמשתמשים מעוניינים להתקין העתקים מרובים של Geeklog על אותו מאגר מידע. כדי שכל עותק של Geeklog יוכל לתפקד כמו שצריך הוא חייב שתהיה לו תחילית טבלה ייחודית (כלומר gl1_, gl2_, וכדומה).',
    'site_url' => 'ודאו שזוהי הכתובת הנכונה של האתר שלכם. כלומר, איפה שהקובץ של Geeklog בשם <code>index.php</code> נמצא (ללא לוכסן בסוף).',
    'site_admin_url' => 'לחלק ממארחי השרתים יש ספריית ניהול מוגדרת מראש. במקרה זה, תצטרכו לשנות את שם ספריית ה-admin של Geeklog למשהו כמו "myadmin" ולשנות את הכתובת שלהלן בהתאם. אל תעשו זאת אלא אם תיתקלו בבעיות כשתנסו לגשת לתפריט הניהול של Geeklog.',
    'site_mail' => 'זוהי הכתובת החוזרת בכל הודעות האימייל שישלחו מ-Geeklog ובמידע צרו קשר שמוצג בהזנות סינדיקציה.',
    'noreply_mail' => 'זוהי כתובת השולח של הודעות אימייל שנשלחות על ידי המערכת כשמשתמשים נרשמים וכדומה. היא צריכה להיות זהה לכתובת האימייל של האתר או להיות כתובת שלא מקבלת הודעות כדי למנוע מספאמרים להשיג את כתובת האימייל שלכם על ידי הרשמה לאתר. אם היא לא זהה לכתובת הרגילה, תהיה הודעה בהודעות שישלחו שלא מומלץ לענות להן.',
    'utf8' => 'ציינו האם להשתמש ב-UTF-8 בתור קידוד ברירת המחדל של האתר שלכם. מומלץ בעיקר להתקנות רב לשוניות.',
    'migrate_file' => 'Choose the backup file you want to migrate. This can either be an exisiting file in your "backups" directory or you can upload a file from your computer.',
    'plugin_upload' => 'Choose a plugin archive (in .zip, .tar.gz, or .tgz format) to upload and install.'
);

// which texts to use as labels, so they don't have to be tranlated again
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
