<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | chinese_simplified_utf-8.php                                              |
// |                                                                           |
// | Chinese language file for the Geeklog installation script                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2022 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                   |
// |          Mark Limburg       - mlimburg AT users DOT sourceforge DOT net   |
// |          Jason Whittenburg  - jwhitten AT securitygeeks DOT com           |
// |          Dirk Haun          - dirk AT haun-online DOT de                  |
// |          Randy Kolenko      - randy AT nextide DOT ca                     |
// |          Matt West          - matt AT mattdanger DOT net                  |
// |          Samuel Maung Stone - sam AT stonemicro DOT com                   |
// |          Tom Homer          - tomhomer AT gmail DOT com                   |
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
    87 => 'https://www.geeklog.net/forum/index.php?forum=1',
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
    103 => '',
    104 => 'Incorrect Admin Directory Path',
    105 => 'Sorry, but the admin directory path you entered does not appear to be correct. Please go back and try again.',
    106 => 'PostgreSQL',
    107 => 'Database Password is required for production environments.',
    108 => 'No Database Drivers found!',
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
    22 => 'migrated',
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
    0 => 'The migration process will overwrite any existing database information.',
    1 => 'Before Proceeding',
    2 => 'Be sure any previously installed plugins have been copied to your new server.',
    3 => 'Be sure any images from <code>public_html/images/articles/</code>, <code>public_html/images/topics/</code>, and <code>public_html/images/userphotos/</code>, have been copied to your new server.',
    4 => 'If you\'re upgrading from a Geeklog version older than <strong>1.5.0</strong>, then make sure to copy over all your old <code>config.php</code> files so that the migration can pick up your settings.',
    5 => 'If you\'re upgrading to a new Geeklog version during your migration and your current theme is not packaged with Geeklog, <em>then don\'t upload your theme just yet unless you are sure it supports this version of Geeklog</em>. Use the included default theme "%s" until you can be sure your migrated site works properly.',
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
    39 => 'Zlib extension is not loaded. Sorry, can\'t handle compressed database backups.',
    40 => 'The archive "%1$s" does not appear to contain any SQL files.  To retry, click on <a href="%2$s\">this</a>',
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
    10 => 'Check your database settings',
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
    'site_name' => '你的网站名.',
    'site_slogan' => '简单的描述你的网站.',
    'db_type' => 'Geeklog can be installed using either a MySQL or PostgreSQL database. If you are not sure which option to select contact your hosting provider.<br><br><strong>Note</strong> InnoDB Tables may improve performance on (very) large sites, but they also make database backups more complicated.',
    'db_host' => '你的数据库的网络名 (或 IP 地址). 这通常是 "localhost". 若你不肯定，请问你的主机服务员.',
    'db_name' => '你的数据库名称. 若你不肯定，请问你的主机服务员.',
    'db_user' => '你的数据库用户名. 若你不肯定，请问你的主机服务员.',
    'db_pass' => '你的数据库用户密码. 若你不肯定，请问你的主机服务员.',
    'db_prefix' => '有些人想在同一个数据库里安装数个志乐网站. 为了让每一个志乐正确的运行他们必须有独特的表格前缀 (例如： gl1_, gl2_, etc).',
    'site_url' => '肯定这是你的网站的正确 URL, 就是志乐的 <code>index.php</code> 档案存在处 (没有后面的一丿).',
    'site_admin_url' => '有些主机服务者预先设定管理目录 admin. 在这样的情况下，你要将志乐的 admin 目录改名，例如： "myadmin" 而且更改一下的 URL. 现暂时不必改，等到你发现进入 admin菜当是遇到问题.',
    'site_mail' => '这是所有志乐寄出的电邮的回信地址和在辛迪加的联络信息.',
    'noreply_mail' => '这是系统电邮的寄信者地址用于用户登记时等等. 这应当是跟网站电邮同样或一个无法回信的地址避免冒名者借着网站登记来录取你的地址. 若这电邮不跟上面一样, 建议你加一个信息在你寄出的电邮里.',
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
    'migrate_file' => 'Choose the backup file you want to migrate. This can either be an existing file in your "backups" directory or you can upload a file from your computer. Alternatively, you can also migrate the current contents of the database.',
    'plugin_upload' => 'Choose a plugin archive (in .zip, .tar.gz, or .tgz format) to upload and install.'
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
