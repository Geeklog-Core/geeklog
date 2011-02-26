<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | chinese_traditional_utf-8.php                                             |
// |                                                                           |
// | Chinese language file for the Geeklog installation script                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                   |
// |          Mark Limburg       - mlimburg AT users DOT sourceforge DOT net   |
// |          Jason Whittenburg  - jwhitten AT securitygeeks DOT com           |
// |          Dirk Haun          - dirk AT haun-online DOT de                  |
// |          Randy Kolenko      - randy AT nextide DOT ca                     |
// |          Matt West          - matt AT mattdanger DOT net                  |
// |          Samuel Maung Stone - sam AT stonemicro DOT com                   |
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

// +---------------------------------------------------------------------------+
// | Array Format:                                                             |
// | $LANG_NAME[XX]: $LANG - variable name                                     |
// |                 NAME  - where array is used                               |
// |                 XX    - phrase id number                                  |
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+
// install.php

$LANG_INSTALL = array(
    0 => '志樂 – 終極網志系統',
    1 => '安裝支助',
    2 => '終極網志系統',
    3 => '志樂安裝',
    4 => '需要PHP %s',
    5 => '抱歉, 志樂要求最少 PHP %s 來操作(你有的是',
    6 => '). 請 <a href="http://www.php.net/downloads.php">升級PHP</a> 安裝 或請你的網站服務員幫你安裝.',
    7 => '找不到志樂檔案',
    8 => '安裝系統無法找到關鍵的志樂檔案. 也許你將它們搬移過. 請指定所需檔案和目錄的路徑:',
    9 => '歡迎你！並謝謝你選擇志樂!',
    10 => '檔案/目錄',
    11 => '許可設定',
    12 => '改為',
    13 => '目前',
    14 => '',
    15 => '輸出志樂標題功能已關閉. <code>backend</code> 目錄沒被測試',
    16 => 'Migrate',
    17 => '用戶照片功能關閉. The <code>userphotos</code> 目錄沒被測試',
    18 => '文章圖像功能關閉. The <code>articles</code> 目錄沒被測試',
    19 => '志樂需要某些檔案和目錄能讓伺服器寫入. 以下列出必須更改的檔案和目錄.',
    20 => '注意!',
    21 => '你的志樂和網站將不能正常運作直到你解決以上問題. 不隨從這步驟便是運用志樂時出錯誤的第一個原因. 請作必要的更改後再繼續.',
    22 => '不知',
    23 => '選你的安裝方法:',
    24 => '新安裝',
    25 => '升級',
    26 => '無法更改',
    27 => '. 你有否肯定你的檔案能被伺服器寫入嗎?',
    28 => 'siteconfig.php. 你有否肯定你的檔案能被伺服器寫入嗎?',
    29 => '志樂網站',
    30 => '另一個俏皮的志樂網站',
    31 => '所需的設定資料',
    32 => '網站名',
    33 => '網站標語',
    34 => '數據種類',
    35 => 'MySQL',
    36 => 'MySQL 和InnoDB Table 支助',
    37 => 'Microsoft SQL',
    38 => 'Error',
    39 => '資料庫主機名',
    40 => '資料庫名',
    41 => '資料庫用戶名',
    42 => '資料庫密碼',
    43 => '資料庫表格首碼',
    44 => '隨意設定',
    45 => '網站 URL',
    46 => '(沒有後隨的一丿slash)',
    47 => '管理員目錄路徑',
    48 => '網站電郵',
    49 => '網站的 不可回信的電郵',
    50 => '安裝',
    51 => '需要 MySQL %s',
    52 => '抱歉, 志樂需要最少 MySQL %s 來操作 (你有的是 ',
    53 => '). 請 <a href="http://dev.mysql.com/downloads/mysql/">升級你的MySQL</a> 安裝 或請你的網站主機服務員幫你升級.',
    54 => '錯誤的資料庫資料',
    55 => '抱歉, 資料庫資料好像不準確. 請回去再試一次.',
    56 => '無法連接到資料庫',
    57 => '抱歉，安裝系統無法找到你指定的資料庫. 可能資料庫不存在或你寫錯資料庫名字. 請回去再試.',
    58 => '. 你有否肯定檔案能夠被伺服器寫入嗎?',
    59 => '注:',
    60 => '你的 MySQL 版本不支援 InnoDB表格. 你想繼續不用 InnoDB 來安裝嗎?',
    61 => '回頭',
    62 => '繼續',
    63 => '有一個志樂資料庫已經存在. 此安裝系統不許可在現存的資料庫裏做新的志樂安裝. 想繼續的話你必須要選擇一下的一個項目:',
    64 => '刪除資料庫的表格. 或刪除整個資料庫而從新建立一個新的資料庫. 然後選擇以下的 "重試".',
    65 => '要執行資料庫升級 (到一個新的志樂版本) 選擇一下的 "升級".',
    66 => '重試',
    67 => '志樂資料庫設定有錯誤',
    68 => '資料庫不是空的. 請刪除資料庫的表格後再試.',
    69 => '升級志樂',
    70 => '開始前請做目前志樂的資料庫備份. 此安裝系統會改變你的志樂資料庫，故萬一出了差錯你需要原有的資料庫來恢復網站。你已被警告!',
    71 => '請再下肯定你選擇了準確的志樂版本. 這程式會升級你的志樂版本 (i.e. 你可從任何版本升級到 ',
    72 => ').',
    73 => '請注意這程式不會升級任何貝它beta，或測試release candidate 志樂版本。',
    74 => '資料庫已經是最新的!',
    75 => '看來你的資料庫已經是最新的. 也許你曾經升級過. 若你想再升級, 請從新安裝原來備份的資料庫來重試.',
    76 => '選擇你現有的志樂版本',
    77 => '安裝系統無法確定你目前的志樂版本, 請在下列選擇:',
    78 => '升級錯誤',
    79 => '志樂升級除了錯誤.',
    80 => '更改',
    81 => '停止!',
    82 => '下列檔案的寫入許可設定是關鍵的. 在你處理這問題以前志樂不回安裝.',
    83 => '安裝錯誤',
    84 => '路徑 "',
    85 => '" 好像不對. 請回去重試.',
    86 => '語言',
    87 => 'http://www.geeklog.net/forum/index.php?forum=1',
    88 => '更改目錄和所屬檔案為',
    89 => '目前版本:',
    90 => '空的資料庫?',
    91 => '看來你的資料庫是空的或你提供的資料庫資料有錯誤. 或你想重新安裝 (而不是升級)? 請回去再試.',
    92 => '用 UTF-8',
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
    108 => 'No Database Drivers found!'
);

// +---------------------------------------------------------------------------+
// success.php

$LANG_SUCCESS = array(
    0 => '安裝完成',
    1 => '志樂安裝 ',
    2 => ' 完成!',
    3 => '恭喜, 你已成功的 ',
    4 => ' 志樂。 請用一分鐘時間閱讀以下的資訊.',
    5 => '要登入你的新志樂網站, 請用這個帳戶:',
    6 => '用戶名:',
    7 => 'Admin',
    8 => '密碼:',
    9 => 'password',
    10 => '安全警告',
    11 => '不要忘記',
    12 => '項目',
    13 => '刪除或改名 install 目錄,',
    14 => '更改',
    15 => '帳戶密碼.',
    16 => '設定許可於',
    17 => '和',
    18 => '回到',
    19 => '<strong>注意:</strong> 因為安全模式已改變, 我們已建立了新的帳戶讓你管理你的新網站.  這新的帳戶名是 <b>NewAdmin</b> 和密碼是 <b>password</b>',
    20 => '安裝',
    21 => '升級',
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
    0 => '志樂安裝支助',
    'site_name' => '你的網站名.',
    'site_slogan' => '簡單的描述你的網站.',
    'db_type' => '志樂可用 MySQL 或 Microsoft SQL 資料庫安裝. 若你不肯定你的選擇，請問你的主機服務員.</p><p class="indent"><strong>注:</strong> InnoDB 表格也許會在巨大的網站上提升效果, 但它會使資料庫備份次序更加複雜.',
    'db_host' => '你的資料庫的網路名 (或 IP 位址). 這通常是 "localhost". 若你不肯定，請問你的主機服務員.',
    'db_name' => '你的資料庫名稱. 若你不肯定，請問你的主機服務員.',
    'db_user' => '你的資料庫用戶名. 若你不肯定，請問你的主機服務員.',
    'db_pass' => '你的資料庫用戶密碼. 若你不肯定，請問你的主機服務員.',
    'db_prefix' => '有些人想在同一個資料庫裏安裝數個志樂網站. 為了讓每一個志樂正確的運行他們必須有獨特的表格首碼 (例如： gl1_, gl2_, etc).',
    'site_url' => '肯定這是你的網站的正確 URL, 就是志樂的 <code>index.php</code> 檔案存在處 (沒有後面的一丿).',
    'site_admin_url' => '有些主機服務者預先設定管理目錄 admin. 在這樣的情況下，你要將志樂的 admin 目錄改名，例如： "myadmin" 而且更改一下的 URL. 現暫時不必改，等到你發現進入 admin菜當是遇到問題.',
    'site_mail' => '這是所有志樂寄出的電郵的回信位址和在辛迪加的聯絡資訊.',
    'noreply_mail' => '這是系統電郵的寄信者位址用於用戶登記時等等. 這應當是跟網站電郵同樣或一個無法回信的位址避免冒名者借著網站登記來錄取你的地址. 若這電郵不跟上面一樣, 建議你加一個資訊在你寄出的電郵裏.',
    'utf8' => '指示你是否要用 UTF-8 為你網站的默認字形檔. 這在多言語的網站上會有幫助.',
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
