<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | japanese_utf-8.php                                                        |
// |                                                                           |
// | Japanese language file for the Geeklog installation script                |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs        - tony AT tonybibbs DOT com                    |
// |          Mark Limburg      - mlimburg AT users DOT sourceforge DOT net    |
// |          Jason Whittenburg - jwhitten AT securitygeeks DOT com            |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// |          Randy Kolenko     - randy AT nextide DOT ca                      |
// |          Matt West         - matt AT mattdanger DOT net                   |
// |          Geeklog.jp group  - info AT geeklog DOT jp                       |
// |          mystral-kk        - geeklog AT mystral-kk DOT net                |
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
    0 => 'Geeklog - The Ultimate Weblog System',
    1 => 'インストールで困ったら，こちらのサイトへ',
    2 => 'The Ultimate Weblog System',
    3 => 'Geeklogのインストール',
    4 => 'PHP 4.1.0が必要です',
    5 => '残念ですが，Geeklogをインストールするには最低でもPHP 4.1.0が必要です(現在のバージョンは ',
    6 => ')。自分で<a href="http://www.php.net/downloads.php">PHPをバージョンアップする</a>か，ホスティング会社に依頼してください。',
    7 => 'Geeklogのファイルがどこにあるかわかりません',
    8 => 'Geeklogの重要なファイルがどこにあるかわかりません。たぶん，デフォルトの位置から移動させているためでしょう。下のテキストボックスにファイルのパスを入力してください。:',
    9 => 'Geeklogへようこそ!　Geeklogを選んでいただき，ありがとうございます。',
    10 => 'ファイル/ディレクトリ',
    11 => 'パーミッション',
    12 => '推奨値',
    13 => '現在',
    14 => 'ディレクトリの変更先',
    15 => 'Geeklogのヘッドライン(RSS)が無効になっています。<code>backend</code>ディレクトリのテストを行いませんでした。',
    16 => 'Migrate',
    17 => 'ユーザ写真が無効になっています。<code>userphotos</code>ディレクトリのテストを行いませんでした。',
    18 => '記事に画像を添付する機能が無効になっています。<code>articles</code>ディレクトリのテストを行いませんでした。',
    19 => 'Geeklogでは，いくつかのファイルとディレクトリがWebサーバから書き込める必要があります。以下は，変更する必要のあるファイルとディレクトリの一覧です。',
    20 => '警告!',
    21 => '上記のエラーが解消されるまで，あなたのGeeklogサイトは正常に動作しないでしょう。先へ進む前に，必要な変更を行ってください。',
    22 => '不明',
    23 => 'インストールの種類を選択してください:',
    24 => '新規インストール',
    25 => 'アップグレード',
    26 => '変更できませんでした：',
    27 => '。ファイルはWebサーバから書き込みできますか?',
    28 => 'siteconfig.php。このファイルはWebサーバから書き込みできますか?',
    29 => 'Geeklog Site',
    30 => 'Another Nifty Geeklog Site',
    31 => '必須の設定情報',
    32 => 'サイト名',
    33 => 'サイトのスローガン',
    34 => 'データベースの種類',
    35 => 'MySQL',
    36 => 'MySQL（InnoDBテーブルをサポート）',
    37 => 'Microsoft SQL',
    38 => '',
    39 => 'データベースのホスト名',
    40 => 'データベース名',
    41 => 'データベースのユーザ名',
    42 => 'データベースのパスワード',
    43 => 'データベースの接頭子',
    44 => 'オプションの設定',
    45 => 'サイトのURL',
    46 => '(最後にスラッシュをつけない)',
    47 => 'Adminディレクトリのパス',
    48 => 'サイトのEmail',
    49 => 'サイトのNo-Reply Email',
    50 => 'インストール',
    51 => '少なくともMySQL 3.23.2が必要です',
    52 => '残念ですが，Geeklogをインストールするには最低でもMySQL 3.23.2が必要です(現在のバージョンは ',
    53 => ')。自分で<a href="http://dev.mysql.com/downloads/mysql/">MySQLをアップグレードする</a>か，ホスティング会社に依頼してください。',
    54 => 'データベース情報が不正確です',
    55 => '残念ですが，入力したデータベース情報が不正確なようです。戻ってやり直してください。',
    56 => 'データベースに接続できません',
    57 => '残念ですが，指定されているデータベースが見つかりません。データベースが存在しないか，綴り（大文字小文字）が違うのでしょう。戻ってやり直してください。',
    58 => '。このファイルはWebサーバから書き込みできますか?',
    59 => '情報:',
    60 => 'お使いのMySQLのバージョンではInnoDBテーブルはサポートされていません。InnoDBサポートなしで，インストールを続けますか?',
    61 => '戻る',
    62 => '続ける',
    63 => 'インストール済みのGeeklogのデータベースが既に存在しています。既存のGeeklogデータベースを上書きして新規インストールを行うことはできません。続けるには，次のどれかを行ってください:',
    64 => '1. 既存のデータベースからテーブルを削除する。2. データベースを削除してから作成し直す。その後，下の"再試行"をクリックしてください。',
    65 => '下の"アップグレード"オプションを選択することで，(Geeklogの新バージョンへ)データベースのアップグレードを行います。',
    66 => '再試行',
    67 => 'Geeklogのデータベースを設定中にエラーが発生しました', 
    68 => 'データベースが空ではありません。データベース中のテーブルを全て削除してから，やり直してください。',
    69 => 'Geeklogをアップグレード',
    70 => '始める前に現在のGeeklogのデータベースのバックアップを行ってください。インストール・スクリプトはGeeklogのデータベースを変更するので，失敗してアップグレードをやり直すには，オリジナルのデータベースのバックアップが必要になります。警告しましたよ!',
    71 => '現在のGeeklogのバージョンを下で正確に選択してください。インストール・スクリプトは入力されたバージョンから少しずつアップグレードしていきます（つまり，任意の古いバージョンから次のバージョンへアップグレードできます: ',
    72 => '）。',
    73 => 'インストール・スクリプトはGeeklogのベータ版やリリース候補(RC)版からのアップグレードは行いません。',
    74 => 'データベースは既に最新の状態になっています!',
    75 => 'データベースは既に最新の状態になっているようです。以前，アップグレードを実行したことがあるのでしょう。ふたたびアップグレードを実行する必要があるなら，データベースのバックアップから復元を行ってからにしてください。',
    76 => '現在のGeeklogのバージョンを選択してください',
    77 => 'インストーラは現在のGeeklogのバージョンを判定できませんでした。下のリストから選択してください:',
    78 => 'アップグレードエラー',
    79 => 'Geeklogをアップグレード中にエラーが発生しました。',
    80 => '変更',
    81 => 'ちょっと待って!',
    82 => '下に列挙されたファイルのパーミッションを必ず変更する必要があります。変更するまでGeeklogをインストールできません。',
    83 => 'インストールエラー',
    84 => 'パス "',
    85 => '" は正しくありません。戻ってやり直してください。',
    86 => '言語',
    87 => 'http://www.geeklog.net/forum/index.php?forum=1',
    88 => '以下のファイルを含むディレクトリに変更してください：',
    89 => '現在のバージョン:',
    90 => 'データベースは空?',
    91 => 'データベースが空のままか，入力してデータベースの情報が不正確なようです。ひょっとすると，アップグレードではなく，新規インストールするつもりだったのではないでしょうか?　戻ってやり直してください。',
    92 => 'UTF-8を使用する',
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
    0 => 'インストール完了',
    1 => 'Geeklog ',
    2 => ' のインストールが完了しました!',
    3 => 'おめでとうございます。Geeklogの',
    4 => 'に成功しました。少し時間をさいて，下に表示されている情報をご覧ください。',
    5 => '新しいGeeklogサイトにログインするには，次のアカウントを使用してください:',
    6 => 'ユーザ名:',
    7 => 'Admin',
    8 => 'パスワード:',
    9 => 'password',
    10 => 'セキュリティ警告',
    11 => '次の',
    12 => 'つのことを忘れずに行ってください:',
    13 => 'installディレクトリを削除ないし，リネームする: ',
    14 => '',
    15 => 'アカウントのパスワードを変更する',
    16 => '',
    17 => 'と',
    18 => 'のパーミッションを次のものに変更する: ',
    19 => '<strong>情報:</strong> セキュリティモデルを変更したので，新しいサイトの管理を行うのに必要な権限を持ったアカウントを作成しました。ユーザ名は <strong>NewAdmin</strong> で，パスワードは <strong>password</strong> です。',
    20 => 'インストールされました',
    21 => 'アップグレードされました'
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
    0 => 'インストールヘルプ',
    'site_name' => 'サイト名を入力します。後から変更することもできます。',
    'site_slogan' => 'サイトのスローガンを入力します。後から変更することもできます。',
    'db_type' => 'データベースの種類を入力します。MySQL, MySQL(InnoDB), Microsoft SQL Serverの中から選びます。</p><p class="indent"><strong>注意:</strong> 大規模なサイトでは，InnoDBテーブルを使用すれば，パフォーマンスが改善されるかもしれませんが，バックアップを行うのが難しくなります。',
    'db_host' => 'ホスト名を入力します。',
    'db_name' => 'データベース名を入力します。',
    'db_user' => 'データベースのユーザ名（アカウント）を入力します。',
    'db_pass' => 'パスワードを入力します。',
    'db_prefix' => 'テーブル名の接頭子を入力します。データベース内に他にテーブルがなければ，既定値を変更する必要はありません。',
    'site_url' => 'サイトのURLを入力します。',
    'site_admin_url' => 'AdminディレクトリのURLを入力します。',
    'site_mail' => 'サイト管理者のEmailアドレスを入力します。',
    'noreply_mail' => 'サイト管理者のNo-Reply Email（返信を受け付けないEmailアドレス）を入力します。',
    'utf8' => 'サイトのデフォルト言語としてUTF-8を使用するかどうかを指示します。多言語サイトを作成するなら，チェックを入れることをお勧めします。',
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
