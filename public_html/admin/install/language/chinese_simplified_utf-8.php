<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | chinese_simplified_utf-8.php                                              |
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
    0 => '志乐 – 终极网志系统',
    1 => '安装支助',
    2 => '终极网志系统',
    3 => '志乐安装',
    4 => '需要PHP %s',
    5 => '抱歉, 志乐要求最少 PHP %s 来操作(你有的是',
    6 => '). 请 <a href="http://www.php.net/downloads.php">升级PHP</a> 安装 或请你的网站服务员帮你安装.',
    7 => '找不到志乐档案',
    8 => '安装系统无法找到关键的志乐档案. 也许你将它们搬移过. 请指定所需档案和目录的路径:',
    9 => '欢迎你！并谢谢你选择志乐!',
    10 => '档案/目录',
    11 => '许可设定',
    12 => '改为',
    13 => '目前',
    14 => '',
    15 => '输出志乐标题功能已关闭. <code>backend</code> 目录没被测试',
    16 => 'Migrate',
    17 => '用户照片功能关闭. The <code>userphotos</code> 目录没被测试',
    18 => '文章图像功能关闭. The <code>articles</code> 目录没被测试',
    19 => '志乐需要某些档案和目录能让服务器写入. 以下列出必须更改的档案和目录.',
    20 => '注意!',
    21 => '你的志乐和网站将不能正常运作直到你解决以上问题. 不随从这步骤便是运用志乐时出错误的第一个原因. 请作必要的更改后再继续.',
    22 => '不知',
    23 => '选你的安装方法:',
    24 => '新安装',
    25 => '升级',
    26 => '无法更改',
    27 => '. 你有否肯定你的档案能被服务器写入吗?',
    28 => 'siteconfig.php. 你有否肯定你的档案能被服务器写入吗?',
    29 => '志乐网站',
    30 => '另一个俏皮的志乐网站',
    31 => '所需的设定资料',
    32 => '网站名',
    33 => '网站标语',
    34 => '数据种类',
    35 => 'MySQL',
    36 => 'MySQL 和InnoDB Table 支助',
    37 => 'Microsoft SQL',
    38 => 'Error',
    39 => '数据库主机名',
    40 => '数据库名',
    41 => '数据库用户名',
    42 => '数据库密码',
    43 => '数据库表格前缀',
    44 => '随意设定',
    45 => '网站 URL',
    46 => '(没有后随的一丿slash)',
    47 => '管理员目录路径',
    48 => '网站电邮',
    49 => '网站的 不可回信的电邮',
    50 => '安装',
    51 => '需要 MySQL %s',
    52 => '抱歉, 志乐需要最少 MySQL %s 来操作 (你有的是 ',
    53 => '). 请 <a href="http://dev.mysql.com/downloads/mysql/">升级你的MySQL</a> 安装 或请你的网站主机服务员帮你升级.',
    54 => '错误的数据库资料',
    55 => '抱歉, 数据库资料好像不准确. 请回去再试一次.',
    56 => '无法连接到数据库',
    57 => '抱歉，安装系统无法找到你指定的数据库. 可能数据库不存在或你写错数据库名字. 请回去再试.',
    58 => '. 你有否肯定档案能够被服务器写入吗?',
    59 => '注:',
    60 => '你的 MySQL 版本不支持 InnoDB表格. 你想继续不用 InnoDB 来安装吗?',
    61 => '回头',
    62 => '继续',
    63 => '有一个志乐数据库已经存在. 此安装系统不许可在现存的数据库里做新的志乐安装. 想继续的话你必须要选择一下的一个项目:',
    64 => '删除数据库的表格. 或删除整个数据库而从新建立一个新的数据库. 然后选择以下的 "重试".',
    65 => '要执行数据库升级 (到一个新的志乐版本) 选择一下的 "升级".',
    66 => '重试',
    67 => '志乐数据库设定有错误',
    68 => '数据库不是空的. 请删除数据库的表格后再试.',
    69 => '升级志乐',
    70 => '开始前请做目前志乐的数据库备份. 此安装系统会改变你的志乐数据库，故万一出了差错你需要原有的数据库来恢复网站。你已被警告!',
    71 => '请再下肯定你选择了准确的志乐版本. 这程序会升级你的志乐版本 (i.e. 你可从任何版本升级到 ',
    72 => ').',
    73 => '请注意这程序不会升级任何贝它beta，或测试release candidate 志乐版本。',
    74 => '数据库已经是最新的!',
    75 => '看来你的数据库已经是最新的. 也许你曾经升级过. 若你想再升级, 请从新安装原来备份的数据库来重试.',
    76 => '选择你现有的志乐版本',
    77 => '安装系统无法确定你目前的志乐版本, 请在下列选择:',
    78 => '升级错误',
    79 => '志乐升级除了错误.',
    80 => '更改',
    81 => '停止!',
    82 => '下列档案的写入许可设定是关键的. 在你处理这问题以前志乐不回安装.',
    83 => '安装错误',
    84 => '路径 "',
    85 => '" 好像不对. 请回去重试.',
    86 => '语言',
    87 => 'http://www.geeklog.net/forum/index.php?forum=1',
    88 => '更改目录和所属档案为',
    89 => '目前版本:',
    90 => '空的数据库?',
    91 => '看来你的数据库是空的或你提供的数据库资料有错误. 或你想重新安装 (而不是升级)? 请回去再试.',
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
    0 => '安装完成',
    1 => '志乐安装 ',
    2 => ' 完成!',
    3 => '恭喜, 你已成功的 ',
    4 => ' 志乐。 请用一分钟时间阅读以下的信息.',
    5 => '要登入你的新志乐网站, 请用这个账户:',
    6 => '用户名:',
    7 => 'Admin',
    8 => '密码:',
    9 => 'password',
    10 => '安全警告',
    11 => '不要忘记',
    12 => '项目',
    13 => '删除或改名 install 目录,',
    14 => '更改',
    15 => '账户密码.',
    16 => '设定许可于',
    17 => '和',
    18 => '回到',
    19 => '<strong>注意:</strong> 因为安全模式已改变, 我们已建立了新的账户让你管理你的新网站.  这新的账户名是 <b>NewAdmin</b> 和密码是 <b>password</b>',
    20 => '安装',
    21 => '升级',
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
    0 => '志乐安装支助',
    'site_name' => '你的网站名.',
    'site_slogan' => '简单的描述你的网站.',
    'db_type' => '志乐可用 MySQL 或 Microsoft SQL 数据库安装. 若你不肯定你的选择，请问你的主机服务员.</p><p class="indent"><strong>注:</strong> InnoDB 表格也许会在巨大的网站上提升效果, 但它会使数据库备份次序更加复杂.',
    'db_host' => '你的数据库的网络名 (或 IP 地址). 这通常是 "localhost". 若你不肯定，请问你的主机服务员.',
    'db_name' => '你的数据库名称. 若你不肯定，请问你的主机服务员.',
    'db_user' => '你的数据库用户名. 若你不肯定，请问你的主机服务员.',
    'db_pass' => '你的数据库用户密码. 若你不肯定，请问你的主机服务员.',
    'db_prefix' => '有些人想在同一个数据库里安装数个志乐网站. 为了让每一个志乐正确的运行他们必须有独特的表格前缀 (例如： gl1_, gl2_, etc).',
    'site_url' => '肯定这是你的网站的正确 URL, 就是志乐的 <code>index.php</code> 档案存在处 (没有后面的一丿).',
    'site_admin_url' => '有些主机服务者预先设定管理目录 admin. 在这样的情况下，你要将志乐的 admin 目录改名，例如： "myadmin" 而且更改一下的 URL. 现暂时不必改，等到你发现进入 admin菜当是遇到问题.',
    'site_mail' => '这是所有志乐寄出的电邮的回信地址和在辛迪加的联络信息.',
    'noreply_mail' => '这是系统电邮的寄信者地址用于用户登记时等等. 这应当是跟网站电邮同样或一个无法回信的地址避免冒名者借着网站登记来录取你的地址. 若这电邮不跟上面一样, 建议你加一个信息在你寄出的电邮里.',
    'utf8' => '指示你是否要用 UTF-8 为你网站的默认字库. 这在多言语的网站上会有帮助.',
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
