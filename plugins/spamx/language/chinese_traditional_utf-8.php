<?php

/**
 * File: chinese_traditional_utf-8.php
 * This is the Traditional Chinese language file for the Geeklog Spam-X plugin
 *
 * Copyright (C) 2004-2017 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 *
 * Licensed under GNU General Public License
 */

global $LANG32;

$LANG_SX00 = array (
    'inst1' => '<p>如果这样做，其他人将可以 ',
    'inst2' => '檢視并匯入您的個人黑名單，我们也能建立更有效的 ',
    'inst3' => '分散式資料庫。</p><p>如果您已提交網站，但不希望網站繼續保留在清單中，',
    'inst4' => '請傳送郵件到 <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> 告知。',
    'inst5' => '所有請求都會得到處理。',
    'submit' => '提交',
    'subthis' => '将此信息提交到 Spam-X 中央資料庫',
    'secbut' => '第二個按钮會建立 RDF 源，以便其他人匯入您的清單。',
    'sitename' => '網站名称：',
    'URL' => 'Spam-X 清單 URL：',
    'RDF' => 'RDF URL：',
    'impinst1a' => '在使用 Spam-X 留言垃圾訊息拦截功能檢視和匯入其他',
    'impinst1b' => '網站的個人黑名單之前，請点擊下面两個按钮。（最後一個按钮必须点擊。）',
    'impinst2' => '第一個按钮會将您的網站提交到 Gplugs/Spam-X，以便加入共享黑名單的',
    'impinst2a' => '網站主清單。（注意：如果您有多個網站，可以指定其中一個為',
    'impinst2b' => '主站点并只提交它的名称。这样可以更方便地更新各站点，并保持清單较小。）',
    'impinst2c' => '点擊“提交”後，請使用浏覽器的［返回］回到此頁面。',
    'impinst3' => '将傳送以下值（如有錯誤可以修改）。',
    'availb' => '可用黑名單',
    'clickv' => '点擊檢視黑名單',
    'clicki' => '点擊匯入黑名單',
    'ok' => 'OK',
    'rsscreated' => 'RSS 來源已建立',
    'add1' => '已新增 ',
    'add2' => ' 個項目，來源：',
    'add3' => " 的黑名單。",
    'adminc' => 'Spam-X 外掛管理。',
    'mblack' => '我的黑名單：',
    'rlinks' => '相關連結：',
    'e3' => '要新增 Geeklog 封鎖詞清單中的词，請点擊按钮：',
    'addcen' => '新增封鎖詞清單',
    'addentry' => '新增項目',
    'e1' => '点擊項目即可刪除。',
    'e2' => '要新增項目，請在输入框中输入并点擊“新增”。項目可以使用完整的 Perl 正则表达式。',
    'pblack' => 'Spam-X 個人黑名單',
    'sfseblack' => 'Spam-X SFS 郵件黑名單',
    'conmod' => '設定 Spam-X 模組使用方式',
    'acmod' => 'Spam-X 操作模組',
    'exmod' => 'Spam-X 檢查模組',
    'actmod' => '已啟用模組',
    'avmod' => '可用模組',
    'coninst' => '<hr' . XHTML . '>点擊已啟用模組可将其移除，点擊可用模組可将其新增。<br' . XHTML . '>模組按顯示順序执行。',
    'fsc' => '發现匹配的垃圾內容：',
    'fsc1' => '，發布使用者：',
    'fsc2' => '，來源 IP：',
    'uMTlist' => '更新 MT-Blacklist',
    'uMTlist2' => '：已新增 ',
    'uMTlist3' => ' 個項目，已刪除 ',
    'entries' => ' 個項目。',
    'uPlist' => '更新個人黑名單',
    'entriesadded' => '已新增項目',
    'entriesdeleted' => '已刪除項目',
    'viewlog' => '檢視 Spam-X 日誌',
    'clearlog' => '清空日誌文件',
    'logcleared' => '- Spam-X 日誌文件已清空',
    'plugin' => '外掛',
    'action' => '操作',
    'access_denied' => '拒絕存取',
    'access_denied_msg' => '只有 Root 使用者可以访问此頁面。您的使用者名和 IP 已被記錄。',
    'admin' => '外掛管理',
    'install_header' => '安裝/解除安裝外掛',
    'installed' => '外掛已安裝',
    'uninstalled' => '外掛未安裝',
    'install_success' => '安裝成功',
    'install_failed' => '安裝失敗——請檢視錯誤日誌了解原因。',
    'uninstall_msg' => '外掛已成功解除安裝',
    'install' => '安裝',
    'uninstall' => '解除安裝',
    'warning' => '警告！外掛仍處于啟用状态',
    'enabled' => '解除安裝前請先停用外掛。',
    'readme' => '注意！点擊安裝前請先阅讀',
    'installdoc' => '安裝文档。',
    'spamdeleted' => '已刪除垃圾內容',
    'foundspam' => '發现匹配的垃圾內容：',
    'foundspam2' => '，發布使用者：',
    'foundspam3' => '，來源 IP：',
    'deletespam' => '刪除垃圾內容',
    'numtocheck' => '要檢查的留言數量',
    'note1'     => '<p>注意：当您遭遇',
    'note2'     => '留言垃圾訊息且 Spam-X 未能识别時，可使用批量刪除。</p><ul><li>先找到该垃圾留言中的連結或其他',
    'note3'     => '识别特征，并将其新增到個人黑名單。</li><li>然後',
    'note4'     => '返回此處，让 Spam-X 檢查最新留言是否為垃圾訊息。</li></ul><p>留言',
    'note5'     => '會從最新到最旧依次檢查——檢查更多留言',
    'note6'     => '需要更長時間。</p>',
    'masshead'  => '批量刪除垃圾留言',
    'masstb' => '批量刪除 Trackback 垃圾訊息',
    'comdel'    => ' 條留言已刪除。',
    'initial_Pimport' => '<p>匯入個人黑名單"',
    'initial_import' => '首次匯入 MT-Blacklist',
    'import_success' => '<p>已成功匯入 %d 個黑名單項目。',
    'import_failure' => '<p><strong>錯誤：</strong>未找到項目。',
    'allow_url_fopen' => '<p>抱歉，您的 Web 伺服器設定不允许讀取遠端檔案（<code>allow_url_fopen</code> 已關闭）。請從以下 URL 下載黑名單，并将其上傳到 Geeklog 的 "data" 目錄 <span style="font-family: monospace;">%s</span>，然後重试：',
    'documentation' => 'Spam-X 外掛文档',
    'emailmsg' => "在 \"%s\" 收到新的垃圾訊息\n使用者 UID：\"%s\"\n\n內容：\"%s\"",
    'emailsubject' => '%s 上的垃圾內容',
    'ipblack' => 'Spam-X IP 黑名單',
    'ipofurlblack' => 'Spam-X URL IP 黑名單',
    'headerblack' => 'Spam-X HTTP 標頭黑名單',
    'headers' => '請求標頭：',
    'edit' => '編輯',
    'view' => '檢視',
    'value' => '值',
    'counter' => '計數器',

    'stats_headline' => 'Spam-X 統計',
    'stats_page_title' => '黑名單',
    'stats_entries' => '項目',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => '個人黑名單',
    'stats_ip' => '已封鎖的 IP',
    'stats_ipofurl' => '因 URL 的 IP 被封鎖',
    'stats_header' => 'HTTP 標頭',
    'stats_deleted' => '作為垃圾訊息刪除的內容',

    'invalid_email_or_ip'   => '無效的電子郵件地址或 IP 地址已被封鎖。',
    'email_ip_spam' => '%s 或 %s 嘗試註冊，但被判定為垃圾訊息傳送者。',
    'edit_personal_blacklist' => '編輯個人黑名單',
    'mass_delete_spam_comments' => '批量刪除垃圾留言',
    'mass_delete_trackback_spam' => '批量刪除 Trackback 垃圾訊息',
    'edit_http_header_blacklist' => '編輯 HTTP 標頭黑名單',
    'edit_ip_blacklist' => '編輯 IP 黑名單',
    'edit_ip_url_blacklist' => '編輯 URL IP 黑名單',
    'edit_sfs_blacklist' => '編輯 SFS 郵件黑名單',
    'edit_slv_whitelist' => '編輯 SLV 白名單',

    'plugin_name' => 'Spam-X'
);


/* Define Messages that are shown when Spam-X module action is taken */
$PLG_spamx_MESSAGE128 = '偵測到垃圾訊息。內容已刪除。';
$PLG_spamx_MESSAGE8   = '偵測到垃圾訊息。已向管理員傳送郵件。';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = '不支持外掛升级。';
$PLG_spamx_MESSAGE3002 = $LANG32[9];


// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X 設定'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Spam-X 操作',
    'notification_email' => '通知郵箱',
    'logging' => '啟用日誌記錄',
    'timeout' => '超時',
    'max_age' => '記錄最長保留時間',
    'records_delete' => '要刪除的記錄類型',
    'sfs_enabled' => '啟用 SFS',
    'sfs_confidence' => '置信度阈值',
    'snl_enabled' => '啟用 SNL',
    'snl_num_links' => '連結數量',
    'akismet_enabled' => '啟用 Akismet',
    'akismet_api_key' => 'API 金鑰',
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => '主要設定'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X 主要設定',
    'tab_modules' => '模組'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X 主要設定',
    'fs_sfs' => '停止论坛垃圾訊息（SFS）',
    'fs_snl' => '垃圾訊息連結數量（SNL）',
    'fs_akismet' => 'Akismet',
);

$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => TRUE, 'False' => FALSE)
);
