<?php

/**
 * File: chinese_simplified_utf-8.php
 * This is the Simplified Chinese language file for the Geeklog Spam-X plugin
 *
 * Copyright (C) 2004-2017 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 *
 * Licensed under GNU General Public License
 */

global $LANG32;

$LANG_SX00 = array (
    'inst1' => '<p>如果这样做，其他人将可以 ',
    'inst2' => '查看并导入您的个人黑名单，我们也能建立更有效的 ',
    'inst3' => '分布式数据库。</p><p>如果您已提交网站，但不希望网站继续保留在列表中，',
    'inst4' => '请发送邮件到 <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> 告知。',
    'inst5' => '所有请求都会得到处理。',
    'submit' => '提交',
    'subthis' => '将此信息提交到 Spam-X 中央数据库',
    'secbut' => '第二个按钮会创建 RDF 源，以便其他人导入您的列表。',
    'sitename' => '网站名称：',
    'URL' => 'Spam-X 列表 URL：',
    'RDF' => 'RDF URL：',
    'impinst1a' => '在使用 Spam-X 评论垃圾信息拦截功能查看和导入其他',
    'impinst1b' => '网站的个人黑名单之前，请点击下面两个按钮。（最后一个按钮必须点击。）',
    'impinst2' => '第一个按钮会将您的网站提交到 Gplugs/Spam-X，以便加入共享黑名单的',
    'impinst2a' => '网站主列表。（注意：如果您有多个网站，可以指定其中一个为',
    'impinst2b' => '主站点并只提交它的名称。这样可以更方便地更新各站点，并保持列表较小。）',
    'impinst2c' => '点击“提交”后，请使用浏览器的［返回］回到此页面。',
    'impinst3' => '将发送以下值（如有错误可以修改）。',
    'availb' => '可用黑名单',
    'clickv' => '点击查看黑名单',
    'clicki' => '点击导入黑名单',
    'ok' => 'OK',
    'rsscreated' => 'RSS 源已创建',
    'add1' => '已添加 ',
    'add2' => ' 个条目，来源：',
    'add3' => " 的黑名单。",
    'adminc' => 'Spam-X 插件管理。',
    'mblack' => '我的黑名单：',
    'rlinks' => '相关链接：',
    'e3' => '要添加 Geeklog 屏蔽词列表中的词，请点击按钮：',
    'addcen' => '添加屏蔽词列表',
    'addentry' => '添加条目',
    'e1' => '点击条目即可删除。',
    'e2' => '要添加条目，请在输入框中输入并点击“添加”。条目可以使用完整的 Perl 正则表达式。',
    'pblack' => 'Spam-X 个人黑名单',
    'sfseblack' => 'Spam-X SFS 邮件黑名单',
    'conmod' => '配置 Spam-X 模块使用方式',
    'acmod' => 'Spam-X 操作模块',
    'exmod' => 'Spam-X 检查模块',
    'actmod' => '已启用模块',
    'avmod' => '可用模块',
    'coninst' => '<hr' . XHTML . '>点击已启用模块可将其移除，点击可用模块可将其添加。<br' . XHTML . '>模块按显示顺序执行。',
    'fsc' => '发现匹配的垃圾内容：',
    'fsc1' => '，发布用户：',
    'fsc2' => '，来源 IP：',
    'uMTlist' => '更新 MT-Blacklist',
    'uMTlist2' => '：已添加 ',
    'uMTlist3' => ' 个条目，已删除 ',
    'entries' => ' 个条目。',
    'uPlist' => '更新个人黑名单',
    'entriesadded' => '已添加条目',
    'entriesdeleted' => '已删除条目',
    'viewlog' => '查看 Spam-X 日志',
    'clearlog' => '清空日志文件',
    'logcleared' => '- Spam-X 日志文件已清空',
    'plugin' => '插件',
    'action' => '操作',
    'access_denied' => '拒绝访问',
    'access_denied_msg' => '只有 Root 用户可以访问此页面。您的用户名和 IP 已被记录。',
    'admin' => '插件管理',
    'install_header' => '安装/卸载插件',
    'installed' => '插件已安装',
    'uninstalled' => '插件未安装',
    'install_success' => '安装成功',
    'install_failed' => '安装失败——请查看错误日志了解原因。',
    'uninstall_msg' => '插件已成功卸载',
    'install' => '安装',
    'uninstall' => '卸载',
    'warning' => '警告！插件仍处于启用状态',
    'enabled' => '卸载前请先禁用插件。',
    'readme' => '注意！点击安装前请先阅读',
    'installdoc' => '安装文档。',
    'spamdeleted' => '已删除垃圾内容',
    'foundspam' => '发现匹配的垃圾内容：',
    'foundspam2' => '，发布用户：',
    'foundspam3' => '，来源 IP：',
    'deletespam' => '删除垃圾内容',
    'numtocheck' => '要检查的评论数量',
    'note1'     => '<p>注意：当您遭遇',
    'note2'     => '评论垃圾信息且 Spam-X 未能识别时，可使用批量删除。</p><ul><li>先找到该垃圾评论中的链接或其他',
    'note3'     => '识别特征，并将其添加到个人黑名单。</li><li>然后',
    'note4'     => '返回此处，让 Spam-X 检查最新评论是否为垃圾信息。</li></ul><p>评论',
    'note5'     => '会从最新到最旧依次检查——检查更多评论',
    'note6'     => '需要更长时间。</p>',
    'masshead'  => '批量删除垃圾评论',
    'masstb' => '批量删除 Trackback 垃圾信息',
    'comdel'    => ' 条评论已删除。',
    'initial_Pimport' => '<p>导入个人黑名单"',
    'initial_import' => '首次导入 MT-Blacklist',
    'import_success' => '<p>已成功导入 %d 个黑名单条目。',
    'import_failure' => '<p><strong>错误：</strong>未找到条目。',
    'allow_url_fopen' => '<p>抱歉，您的 Web 服务器配置不允许读取远程文件（<code>allow_url_fopen</code> 已关闭）。请从以下 URL 下载黑名单，并将其上传到 Geeklog 的 "data" 目录 <span style="font-family: monospace;">%s</span>，然后重试：',
    'documentation' => 'Spam-X 插件文档',
    'emailmsg' => "在 \"%s\" 收到新的垃圾内容\n用户 UID：\"%s\"\n\n内容：\"%s\"",
    'emailsubject' => '%s 上的垃圾内容',
    'ipblack' => 'Spam-X IP 黑名单',
    'ipofurlblack' => 'Spam-X URL IP 黑名单',
    'headerblack' => 'Spam-X HTTP 标头黑名单',
    'headers' => '请求标头：',
    'edit' => '编辑',
    'view' => '查看',
    'value' => '值',
    'counter' => '计数器',

    'stats_headline' => 'Spam-X 统计',
    'stats_page_title' => '黑名单',
    'stats_entries' => '条目',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => '个人黑名单',
    'stats_ip' => '已阻止的 IP',
    'stats_ipofurl' => '因 URL 的 IP 被阻止',
    'stats_header' => 'HTTP 标头',
    'stats_deleted' => '作为垃圾信息删除的内容',

    'invalid_email_or_ip'   => '无效的电子邮件地址或 IP 地址已被阻止。',
    'email_ip_spam' => '%s 或 %s 尝试注册，但被判定为垃圾信息发送者。',
    'edit_personal_blacklist' => '编辑个人黑名单',
    'mass_delete_spam_comments' => '批量删除垃圾评论',
    'mass_delete_trackback_spam' => '批量删除 Trackback 垃圾信息',
    'edit_http_header_blacklist' => '编辑 HTTP 标头黑名单',
    'edit_ip_blacklist' => '编辑 IP 黑名单',
    'edit_ip_url_blacklist' => '编辑 URL IP 黑名单',
    'edit_sfs_blacklist' => '编辑 SFS 邮件黑名单',
    'edit_slv_whitelist' => '编辑 SLV 白名单',

    'plugin_name' => 'Spam-X'
);


/* Define Messages that are shown when Spam-X module action is taken */
$PLG_spamx_MESSAGE128 = '检测到垃圾信息。内容已删除。';
$PLG_spamx_MESSAGE8   = '检测到垃圾信息。已向管理员发送邮件。';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = '不支持插件升级。';
$PLG_spamx_MESSAGE3002 = $LANG32[9];


// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X 配置'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Spam-X 操作',
    'notification_email' => '通知邮箱',
    'logging' => '启用日志记录',
    'timeout' => '超时',
    'max_age' => '记录最长保留时间',
    'records_delete' => '要删除的记录类型',
    'sfs_enabled' => '启用 SFS',
    'sfs_confidence' => '置信度阈值',
    'snl_enabled' => '启用 SNL',
    'snl_num_links' => '链接数量',
    'akismet_enabled' => '启用 Akismet',
    'akismet_api_key' => 'API 密钥',
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => '主要设置'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X 主要设置',
    'tab_modules' => '模块'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X 主要设置',
    'fs_sfs' => '停止论坛垃圾信息（SFS）',
    'fs_snl' => '垃圾信息链接数量（SNL）',
    'fs_akismet' => 'Akismet',
);

$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => TRUE, 'False' => FALSE)
);
