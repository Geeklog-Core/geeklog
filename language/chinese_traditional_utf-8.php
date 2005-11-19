<?php

###############################################################################
# chinese_traditional_utf-8.php
#
# Last Modified: 2004-10-26
# Version: 1.3.10
#
# This is the Chinese Traditional (UTF-8) language set for GeekLog 1.3.10
#
# Copyright (C) 2003 Samuel M. Stone
# sam@stonemicro.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

$LANG_CHARSET = 'UTF-8';

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

###############################################################################
# USER PHRASES - These are file phrases used in end user scripts
###############################################################################

###############################################################################
# lib-common.php

$LANG01 = array(
    1 => '作者︰',
    2 => '讀整文',
    3 => '個評論',
    4 => '編輯',
    5 => '投票',
    6 => '結果',
    7 => '投票結果',
    8 => '投票',
    9 => '管理者功能︰',
    10 => '提交物',
    11 => '文章',
    12 => '組件',
    13 => '主題',
    14 => '連結',
    15 => '事件',
    16 => '投票',
    17 => '用戶',
    18 => 'SQL 質問',
    19 => '退出',
    20 => '用戶訊息︰',
    21 => '用戶名',
    22 => '用戶識別號',
    23 => '安全等級',
    24 => '匿名',
    25 => '回復',
    26 => '以下評論只屬張貼者個人觀點。',
    27 => '最近發表的',
    28 => '刪除',
    29 => '沒有評論。',
    30 => '舊的文章',
    31 => '允許的 HTML 標記:',
    32 => '錯誤，無效的用戶名',
    33 => '錯誤，不能寫系統日誌;',
    34 => '錯誤',
    35 => '退出',
    36 => '於',
    37 => '沒有文章',
    38 => '內容辛迪加',
    39 => '使新',
    40 => '你的伺服器的 <tt>php.ini</tt> 裏設定為 <tt>register_globals = Off</tt>. 可是此軟體需要將 <tt>register_globals</tt> 設定成 <strong>on</strong>. 所以在你繼續以前，必須將它設定為<strong>on</strong>，然後重新開機.',
    41 => '客人',
    42 => '作者:',
    43 => '回復這個',
    44 => '父母',
    45 => 'MySQL 錯誤號碼',
    46 => 'MySQL 錯誤訊息',
    47 => '用戶功能',
    48 => '帳戶訊息',
    49 => '風格選擇',
    50 => '錯誤的 SQL statement',
    51 => '幫助',
    52 => '新',
    53 => '管理者首頁',
    54 => '不能打開檔。',
    55 => '錯處',
    56 => '投票',
    57 => '密碼',
    58 => '登入',
    59 => "沒有帳戶？<a href=\"{$_CONF['site_url']}/users.php?mode=new\">在此登記</a>",
    60 => '發表評論',
    61 => '新增帳戶',
    62 => '字',
    63 => '評論設定',
    64 => '把文章電郵給朋友',
    65 => '觀看可列印的版本',
    66 => '我的日曆',
    67 => '歡迎來到',
    68 => '首頁',
    69 => '聯絡',
    70 => '搜尋',
    71 => '投稿',
    72 => '網路資源',
    73 => '投票中心',
    74 => '日曆',
    75 => '進階搜索',
    76 => '本站統計資料',
    77 => '插件',
    78 => '即將發生的事',
    79 => '新鮮的東西',
    80 => '個新文章(',
    81 => '新的文章(',
    82 => ' 小時內)',
    83 => '評論',
    84 => '連結',
    85 => '最近四十八小時',
    86 => '沒有新的評論',
    87 => '最近兩個星期',
    88 => '沒有新的連結',
    89 => '沒有事發生',
    90 => '首頁',
    91 => '載入這頁用了',
    92 => '秒',
    93 => '版權',
    94 => '此網站所有的商標和版權屬於他們各自的所有者.',
    95 => '動力於',
    96 => '小組',
    97 => '字詞單',
    98 => '插件',
    99 => '文章',
    100 => '沒有新的文章',
    101 => '你的事件',
    102 => '本站的事件',
    103 => '資料庫備份',
    104 => '由',
    105 => '寄給用戶',
    106 => '觀看',
    107 => 'GL 版本測試',
    108 => '清除緩衝貯存區',
    109 => '報告濫用',
    110 => '報告此濫登文給網站管理員',
    111 => '看PDF 版本',
    112 => '登記用戶',
    113 => '使用說明',
    114 => 'TRACKBACKS',
    115 => 'No new trackback comments',
    116 => 'Trackback',
    117 => 'Directory',
    118 => 'Please continue reading on the next page:',
    119 => "Lost your <a href=\"{$_CONF['site_url']}/users.php?mode=getpassword\">password</a>?",
    120 => 'Permanent link to this comment',
    121 => 'Comments (%d)',
    122 => 'Trackbacks (%d)',
    123 => 'All HTML is allowed'
);

###############################################################################
# calendar.php

$LANG02 = array(
    1 => '事件日曆',
    2 => '抱歉，沒有事件。',
    3 => '時',
    4 => '地',
    5 => '事',
    6 => '新增事件',
    7 => '即將發生的事',
    8 => '在將這事加進你的日曆之後，你可點擊 "我的日曆" 來觀看',
    9 => '加進我的日曆',
    10 => '從我的日曆中去除',
    11 => "把這事加進 {$_USER['username']} 的日曆",
    12 => '事件',
    13 => '開始',
    14 => '結束',
    15 => '回到日曆'
);

###############################################################################
# comment.php

$LANG03 = array(
    1 => '發表評論',
    2 => '發表方式',
    3 => '退出',
    4 => '新增帳戶',
    5 => '用戶名',
    6 => '本站需要登入才可發表評論，請登入。如果你沒有帳戶，請使用下面的表格登記。',
    7 => '你最後發表的評論是在 ',
    8 => " 秒之前。本站限定至少 {$_CONF['commentspeedlimit']} 秒後才可再發表評論",
    9 => '評論',
    10 => '送出報告',
    11 => '發表評論',
    12 => '請填寫標題注評論欄',
    13 => '供你參考',
    14 => '預覽',
    15 => '報告這篇濫登文',
    16 => '標題',
    17 => '錯誤',
    18 => '重要的東西',
    19 => '請儘量不要離題。',
    20 => '盡可能回復別人的評論，而不是開新的評論。',
    21 => '為避免重複，發表評論之前請先讀別人所寫的。',
    22 => '請儘量用簡潔的標題。',
    23 => '我們不會公開你的電郵地址。',
    24 => '匿名用戶',
    25 => '你肯定想要報告此濫登文給網站管理員否?',
    26 => '%s 報告以下濫登的評論:',
    27 => '濫用報告'
);

###############################################################################
# users.php

$LANG04 = array(
    1 => '用戶概況',
    2 => '用戶名',
    3 => '全名',
    4 => '密碼',
    5 => '電子郵件',
    6 => '首頁',
    7 => '小傳',
    8 => 'PGP 鑰匙',
    9 => '保存設定',
    10 => '給用戶的最後十個評論',
    11 => '沒有評論',
    12 => '用戶設定',
    13 => '每夜電郵文摘',
    14 => '這是個隨機的密碼，請儘快更改。要更改密碼請先登入系統，然後點擊帳戶訊息。',
    15 => "你在 {$_CONF['site_name']} 的帳戶已建立了。請使用以下訊息登入系統並保留這郵件作日後參考。",
    16 => '你的帳戶訊息',
    17 => '帳戶並不存在',
    18 => '你提供的不是一個有效的的電郵',
    19 => '用戶名或電郵已經存在',
    20 => '提供的不是一個有效的的電郵',
    21 => '錯誤',
    22 => "登記用 {$_CONF['site_name']} ！",
    23 => "在 {$_CONF['site_name']} 登記的用戶可享有的會員好處。他們可以用自己的名字發表評論和存取本站的資源。請注意本站<b><i>絕不會</i></b>公開用戶的電郵。",
    24 => '你的密碼將被送到你輸入的電郵信箱',
    25 => '忘記了你的密碼嗎？',
    26 => '請你輸入的用戶名和點擊電郵密碼，我們會發送一個新的密碼到你的電郵信箱。',
    27 => '現在就登記！',
    28 => '電郵密碼',
    29 => '退出時',
    30 => '登入時',
    31 => '需要登入才可用',
    32 => '署名',
    33 => '絕不會公開',
    34 => '這是你的真名',
    35 => '要改變請輸入密碼',
    36 => '開始是 http://',
    37 => '將會附加在你發表的評論上',
    38 => '你的簡介',
    39 => '你的公共 PGP 鑰匙',
    40 => '沒有主題圖示',
    41 => '願意主持',
    42 => '日期格式',
    43 => '文章限度',
    44 => '沒有組件',
    45 => '顯示設定',
    46 => '不包括的',
    47 => '新元件配置為',
    48 => '主題',
    49 => '文章裏沒有圖像',
    50 => '不要打鉤如果你不感興趣',
    51 => '只是新文章',
    52 => '預設值是',
    53 => '每晚接收當日的文章',
    54 => '打鉤如果你不看這些主題或作者。',
    55 => '如果你沒有選擇，這意味你要用預設的組件。如果你選擇元件，所有預設的箱將被忽略。預設的東西會用粗筆劃顯示。',
    56 => '作者',
    57 => '顯示方式',
    58 => '排序方式',
    59 => '評論限制(個)',
    60 => '可顯示你的評論嗎？',
    61 => '最新或最舊的先？',
    62 => '預設是100',
    63 => '密碼已被發送，你會很快收到的。',
    64 => '評論設定',
    65 => '請嘗試再登入',
    66 => "你可能打錯了，請嘗試再登入。你是否<a href=\"{$_CONF['site_url']}/users.php?mode=new\">新用戶</a>？",
    67 => '成員自',
    68 => '記住我為',
    69 => '在登入以後，我們應該記住你多久？',
    70 => "定做 {$_CONF['site_name']} 的佈局和內容",
    71 => "一個 {$_CONF['site_name']} 的主要特點是你可以定做自己的佈局和內容，但是你必須是本站的會員。<a href=\"{$_CONF['site_url']}/users.php?mode=new\">在此登記</a>。如果你已經是登記，請使用左邊的區域登入。",
    72 => '題材',
    73 => '語言',
    74 => '改變本站外表',
    75 => '主題已電郵給',
    76 => '請只選擇你感興趣的主題，因為所有當日新張貼的文章將會電郵到你的信箱。',
    77 => '相片',
    78 => '你自己的圖片',
    79 => '要刪除圖片，在這裏打鉤',
    80 => '登入',
    81 => '發送電子郵件',
    82 => '用戶最近發表的十個文章為',
    83 => '用戶發表統計',
    84 => '文章總數︰',
    85 => '評論總數︰',
    86 => '尋找所有發表過的文章︰',
    87 => '你的登入名',
    88 => "有人(也許是你)要了新密碼 \"%s\" 於 {$_CONF['site_name']}, <{$_CONF['site_url']}>.\n\n若你真的要這樣作, 請你點擊以下聯結:\n\n",
    89 => "你若不想要這樣作, 請忽視這資訊。這項事就將會被拋棄，而你的密碼就保持原有.\n\n",
    90 => '你可在下面輸入一個新的密碼。請注意你的舊密碼任然有效直到你將此表提交。',
    91 => '設定新密碼',
    92 => '輸入新密碼',
    93 => '你在 %d 秒鐘前剛要了一個新密碼. 此站規定最少要 %d 秒鐘以後才可再次要求新密碼。',
    94 => '將用戶 \'%s\' 刪除',
    95 => '單據下面的 \'刪除用戶\' 便將你在我們資料庫裏的用戶。請注意，你以其用戶所登載過的文章和評論不會刪除，可是會以無名作者的身份顯示。',
    96 => '刪除用戶',
    97 => '確定用戶刪除',
    98 => '你肯定要刪除你的用戶嗎? 其後你就不在能使用此站,除非你重新設定新用戶. 若你肯定的話請再次單據下面的 “刪除用戶”.',
    99 => '隱私選項於',
    100 => '管理員來信',
    101 => '准許管理員來信',
    102 => '用戶來信',
    103 => '准許其他用戶來信',
    104 => '顯示聯機狀況',
    105 => '讓在“誰在聯機”元件裏顯示',
    106 => '位置',
    107 => '顯示在你的公開簡介',
    108 => 'Confirm new password',
    109 => 'Enter the New password again here',
    110 => 'Current Password',
    111 => 'Please enter your Current password',
    112 => 'You have exceeded the number of allowed login attempts.  Please try again later.',
    113 => 'Login Attempt Failed',
    114 => 'Account Disabled',
    115 => 'Your account has been disabled, you may not login. Please contact an Administrator.',
    116 => 'Account Awaiting Activation',
    117 => 'Your account is currently awaiting activation by an administrator. You will not be able to login until your account has been approved.',
    118 => "Your {$_CONF['site_name']} account has now been activated by an administrator. You may now login to the site at the url below using your username (<username>) and password as previously emailed to you.",
    119 => 'If you have forgotten your password, you may request a new one at this url:',
    120 => 'Account Activated',
    121 => 'Service',
    122 => 'Sorry, new user registration is disabled',
    123 => "Are you a <a href=\"{$_CONF['site_url']}/users.php?mode=new\">new user</a>?"
);

###############################################################################
# index.php

$LANG05 = array(
    1 => '沒有新聞可顯示',
    2 => '沒有新文章可顯示。',
    3 => '這也許是真的沒有新主題或是你的 %s 設定得太過限制性。',
    4 => '今天頭條',
    5 => '下頁',
    6 => '上頁',
    7 => '第一',
    8 => '最終'
);

###############################################################################
# profiles.php

$LANG08 = array(
    1 => '發送電子郵件時發生錯誤。請再嘗試。',
    2 => '電郵已送出。',
    3 => '請確定你在回復欄有一個可用的電子郵件位址。',
    4 => '請填寫你的名字、回復欄、主題和內容',
    5 => '錯誤：沒有這用戶。',
    6 => '發生錯誤。',
    7 => '用戶資料',
    8 => '用戶名',
    9 => '用戶名的 URL',
    10 => '發送郵件到',
    11 => '你的名字：',
    12 => '回復到：',
    13 => '主題：',
    14 => '內容：',
    15 => 'HTML 不會被翻譯。',
    16 => '發送郵件',
    17 => '把文章電郵給朋友',
    18 => '收件人名字',
    19 => '收件人電郵',
    20 => '寄件人名字',
    21 => '寄件人電郵',
    22 => '所有欄都要填寫',
    23 => "這電子郵件是由 %s (%s) 寄給你的，他認為你也許對這篇在 {$_CONF['site_url']} 的文章感興趣。這不是垃圾郵件(SPAM)，你的電郵位址也不會被紀錄。",
    24 => '關於這個文章的評論在',
    25 => '為幫助我們防止系統被濫用，你必須登入。',
    26 => '這個表格允許你送電子郵件到你選擇的用戶中。請填寫所有的欄位。',
    27 => '短信',
    28 => '%s 寫道：',
    29 => "來自於 {$_CONF['site_name']} 的每日文摘，給予：",
    30 => ' 每日的時事通訊，給予：',
    31 => '標題',
    32 => '日期',
    33 => '完整的文章在：',
    34 => '電郵結束',
    35 => '對不起，此用戶不願意收電信.'
);

###############################################################################
# search.php

$LANG09 = array(
    1 => '進階搜尋',
    2 => '關鍵字',
    3 => '主題',
    4 => '所有',
    5 => '類型',
    6 => '文章',
    7 => '評論',
    8 => '作者',
    9 => '所有',
    10 => '搜尋',
    11 => '搜尋結果',
    12 => '相配',
    13 => '搜尋結果：沒有相配的',
    14 => '沒有你尋找的東西︰',
    15 => '請再嘗試',
    16 => '主題',
    17 => '日期',
    18 => '作者',
    19 => "搜尋整個 {$_CONF['site_name']} 的新舊文章資料庫",
    20 => '日期',
    21 => '到',
    22 => '(日期格式 年-月-日 YYYY-MM-DD)',
    23 => '採樣數',
    24 => '找到',
    25 => '個相配在',
    26 => '個項目中，共用了',
    27 => '秒',
    28 => '沒有你所尋找的文章或評論',
    29 => '文章和評論的結果',
    30 => '沒有你所尋找的連結',
    31 => '沒有你所尋找的插件',
    32 => '事件',
    33 => 'URL',
    34 => '地點',
    35 => '所有日子',
    36 => '沒有你所尋找的事件',
    37 => '事件的結果',
    38 => '連結的結果',
    39 => '連結',
    40 => '事件',
    41 => '搜尋的關鍵字最少要有三個字。',
    42 => '請使用 YYYY-MM-DD (年-月-日) 日期格式。',
    43 => '整個短語',
    44 => '所有字詞',
    45 => '其中任何字詞',
    46 => '以下',
    47 => '以上',
    48 => '作者',
    49 => '日期',
    50 => '採樣數',
    51 => '聯結',
    52 => '位置',
    53 => '文章結果',
    54 => '評論結果',
    55 => '句子',
    56 => '和',
    57 => '或',
    58 => 'More results &gt;&gt;',
    59 => 'Results',
    60 => 'per page',
    61 => 'Refine search'
);

###############################################################################
# stats.php

$LANG10 = array(
    1 => '本站統計資料',
    2 => '系統點擊總數',
    3 => '文章(評論)總數',
    4 => '投票(獲得投票)總數',
    5 => '連結(點擊)總數',
    6 => '事件總數',
    7 => '最多觀看的十個文章',
    8 => '文章標題',
    9 => '觀看',
    10 => '看來本站沒有文章或是沒人觀看過本站的文章。',
    11 => '最多評論的十個文章',
    12 => '評論',
    13 => '看來本站沒有文章或是沒人評論過本站的文章。',
    14 => '最多人投票的十個選舉',
    15 => '投票標題',
    16 => '投票',
    17 => '看來本站沒有投票或是沒人投過票。',
    18 => '最多人點擊的十個連結',
    19 => '連結',
    20 => '點擊',
    21 => '看來本站沒有連結或是沒人點擊過本站的連結。',
    22 => '最多人寄出的十個文章',
    23 => '電郵',
    24 => '看來沒人寄出過本站的文章',
    25 => 'Top Ten Trackback Commented Stories',
    26 => 'No trackback comments found.',
    27 => 'Number of active users',
    28 => 'Top Ten Events',
    29 => 'Event',
    30 => 'Hits',
    31 => 'It appears that there are no events on this site or no one has ever clicked on one.'
);

###############################################################################
# article.php

$LANG11 = array(
    1 => '有什麽是相關的',
    2 => '寄文章給朋友',
    3 => '可印的文章格式',
    4 => '文章選項',
    5 => 'PDF 文章版本'
);

###############################################################################
# submit.php

$LANG12 = array(
    1 => '你需要登入才可發表 %s ',
    2 => '登入',
    3 => '新用戶',
    4 => '發表一件事',
    5 => '發表一個連結',
    6 => '發表一個文章',
    7 => '你需要登入',
    8 => '發表',
    9 => '在本站發表東西時請跟隨以下建議...<ul><li>填寫所有的欄<li>提供完全和準確的訊息<li>再三檢查那些 URLs</ul>',
    10 => '標題',
    11 => '連結',
    12 => '開始日期',
    13 => '結束日期',
    14 => '地點',
    15 => '描述',
    16 => '如果是其他，請指定',
    17 => '類別',
    18 => '其他',
    19 => '讀這先',
    20 => '錯誤：缺少類別',
    21 => '當選擇"其他"請提供一個類別名',
    22 => '錯誤：缺少欄位',
    23 => '請填寫所有的欄位',
    24 => '你發表的已被保存了',
    25 => '你的 %s 已被保存了',
    26 => '限速',
    27 => '用戶名',
    28 => '主題',
    29 => '文章',
    30 => '你最後發表的是',
    31 => " 秒之前。本站限定至少 {$_CONF['speedlimit']} 秒後才可再發表",
    32 => '預覽',
    33 => '文章 預覽',
    34 => '退出',
    35 => '不准許 HTML 標記',
    36 => '發表模式',
    37 => "加事件到 {$_CONF['site_name']} 會將你的事件加到主日曆中，其他的用戶可隨意地把它加進自己的個人日曆。請<b>不要</b>把你的個人事件譬如生日和周年紀念加進去。<br><br>只要管理員批准你的事件它將出現在主日曆上。",
    38 => '加事件到',
    39 => '主日曆',
    40 => '個人日曆',
    41 => '結束時間',
    42 => '開始時間',
    43 => '整日的事件',
    44 => '地址 1',
    45 => '地址 2',
    46 => '城市/市鎮',
    47 => '州',
    48 => '郵遞區號',
    49 => '事件類型',
    50 => '編輯事件類型',
    51 => '地點',
    52 => '刪除',
    53 => '新加帳戶'
);

###############################################################################
# ADMIN PHRASES - These are file phrases used in admin scripts
###############################################################################

###############################################################################
# admin/auth.inc.php

$LANG20 = array(
    1 => '要求認證',
    2 => '拒絕！不正確的登入資料',
    3 => '無效的密碼',
    4 => '用戶名：',
    5 => '密碼：',
    6 => '這頁只供授權人員使用。<br>所有存取將被記錄和檢查。',
    7 => '登入'
);

###############################################################################
# admin/block.php

$LANG21 = array(
    1 => '權力不足',
    2 => '你沒有權去編輯這個元件。',
    3 => '組件編輯器',
    4 => '讀取此文流時發現錯誤，請在你的錯誤記錄檔案 error.log 裏看細節.',
    5 => '組件標題',
    6 => '主題',
    7 => '所有',
    8 => '元件安全水平',
    9 => '組件次序',
    10 => '組件類型',
    11 => '入口組件',
    12 => '正常元件',
    13 => '入口元件選項',
    14 => '文流 RDF 的 URL',
    15 => '最後的文流 RDF 更新',
    16 => '正常元件選項',
    17 => '元件內容',
    18 => '請填寫元件的標題和內容。',
    19 => '組件管理員',
    20 => '組件標題',
    21 => '元件安全水平',
    22 => '組件類型',
    23 => '組件次序',
    24 => '元件主題',
    25 => '點擊下面的組件可修改或刪除它，點擊上面的新元件可創造一個新的。',
    26 => '版面組件',
    27 => 'PHP 組件',
    28 => 'PHP 元件選項',
    29 => '元件函數',
    30 => '如果你想用自己的 PHP 函數元件，請在上面輸入函數的名字。為防止執行任性的編碼，PHP 元件函數名必須以 "phpblock_" 作開始 (e.g. phpblock_getweather)。請不要把空的圓括號 "()" 放在函數後。最後，建議你把所有的 PHP 組件放在 /path/to/geeklog/system/lib-custom.php 裏以方便系統升級。',
    31 => 'PHP 元件錯誤︰函數 %s 並不存在。',
    32 => '錯誤︰缺少欄位元。',
    33 => '在入口元件你必須把 URL 輸入到 .rdf 檔案',
    34 => '在 PHP 元件你必須輸入主題和函數',
    35 => '在正常元件你必須輸入主題和內容',
    36 => '在版面元件你必須輸入內容',
    37 => '不適當的 PHP 元件函數名',
    38 => '為防止執行任性的編碼，PHP 元件函數名必須以 "phpblock_" 作開始 (e.g. phpblock_getweather)。',
    39 => '放在那邊',
    40 => '左',
    41 => '右',
    42 => '在本系統的預設元件你必須輸入元件標題和次序',
    43 => '只可是首頁',
    44 => '存取被拒絕',
    45 => "企圖存取不允許的元件已被記錄。請<a href=\"{$_CONF['site_admin_url']}/block.php\">反回組件管理員晝面</a>。",
    46 => '新組件',
    47 => '管理員首頁',
    48 => '組件名',
    49 => ' (不可有空隔和必須是唯一的)',
    50 => '求助文件的 URL',
    51 => '包括 http://',
    52 => '如果這裏留白，元件的求助檔圖示將不被顯示',
    53 => '使有效',
    54 => '保存',
    55 => '取消',
    56 => '刪除',
    57 => '下移組件',
    58 => '上移組件',
    59 => '移組件到右邊',
    60 => '移組件到左邊',
    61 => 'No Title',
    62 => 'Article Limit',
    63 => 'Bad Block Title',
    64 => 'Your Title must not be empty and cannot contain HTML!',
    65 => 'Order'
);

###############################################################################
# admin/event.php

$LANG22 = array(
    1 => '事件編輯器',
    2 => 'Error',
    3 => '事件標題',
    4 => '事件 URL',
    5 => '事件開始日期',
    6 => '事件結束日期',
    7 => '事件地點',
    8 => '事件描述',
    9 => '(包括 http://)',
    10 => '你必須提供日期時間、事件主題、與事件描述！',
    11 => '事件管理員',
    12 => '點擊下面的事件可修改或刪除它，點擊上面的新事件可創造一個新的。',
    13 => '事件標題',
    14 => '開始日期',
    15 => '結束日期',
    16 => '存取被拒絕',
    17 => "企圖存取不允許的事件已被記錄。請<a href=\"{$_CONF['site_admin_url']}/event.php\">反回事件管理員晝面</a>。",
    18 => '新事件',
    19 => '管理員首頁',
    20 => '保存',
    21 => '取消',
    22 => '刪除',
    23 => '錯誤的開始日期.',
    24 => '錯誤的結束日期.',
    25 => '結束日期在開始日期前.'
);

###############################################################################
# admin/story.php

$LANG24 = array(
    1 => '上篇文章',
    2 => '下篇文章',
    3 => '模式',
    4 => '發表模式',
    5 => '文章編輯器',
    6 => '沒有文章',
    7 => '作者',
    8 => '保存',
    9 => '預覽',
    10 => '取消',
    11 => '刪除',
    12 => 'ID',
    13 => '標題',
    14 => '主題',
    15 => '日期',
    16 => '文章簡介',
    17 => '文章內容',
    18 => '點擊次數',
    19 => '評論',
    20 => 'Ping',
    21 => 'Send Ping',
    22 => '文章清單',
    23 => '點擊下面的文章編號可修改或刪除它，點擊下面的文章標題可觀看它，點擊上面的新文章可創造一個新的。',
    24 => '你選的用戶名以有人在用。請用另一個用戶名。',
    25 => 'Error when saving story',
    26 => '文章預覽',
    27 => 'If you use [unscaledX] instead of [imageX], the image will be inserted at its original dimensions.',
    28 => '<p><b>PREVIEWING</b>: Previewing a story with images attached is best done by saving the article as a draft INSTEAD OF hitting the preview button.  Use the preview button only when images are not attached.',
    29 => 'Trackbacks',
    30 => '上載錯誤',
    31 => '你需要提供作者、標題和文章簡介！',
    32 => '頭條的',
    33 => '只可有一個頭條文章',
    34 => '草稿',
    35 => '是',
    36 => '否',
    37 => '更多來自於',
    38 => '更多發表於',
    39 => '電郵',
    40 => '存取被拒絕',
    41 => "企圖存取不允許的文章已被記錄。你可以以唯讀模式觀看下面文章。看完後請<a href=\"{$_CONF['site_admin_url']}/story.php\">反回文章管理員晝面</a>。",
    42 => "企圖存取不允許的文章已被記錄。請<a href=\"{$_CONF['site_admin_url']}/story.php\">反回文章管理員晝面</a>。",
    43 => '新文章',
    44 => '管理員首頁',
    45 => '存取權',
    46 => '<b>注意︰</b>如果你把日期改成將來，在那個日期前這篇文章將不會被發表。並且 意味著這篇文章不會包括在你的 RDF 標題內，在搜尋和統計頁中會被忽略。',
    47 => '圖像',
    48 => '圖像',
    49 => '右',
    50 => '左',
    51 => '請用特別格式的文字([imageX]、[imageX_right] 或 [imageX_left])來插入圖像， X 是你附加圖像的編號。注意︰你只可使用你附加的圖像否則你將無法保存你的文章。<BR><P><B>預覽</B>︰最佳預覽文章的方法是把文章保存成草稿而不是直擊預覽按鈕。只有沒有附加圖像時才用預覽按鈕。',
    52 => '刪除',
    53 => '沒有被使用。保存前，你必須把這個圖像包含在文章簡介或文章內容中。',
    54 => '附加圖像未被使用',
    55 => '保存你的文章時發生以下錯誤。請改正這些錯誤再保存',
    56 => '顯示主題圖示',
    57 => '看沒味縮小的圖像',
    58 => '文章管理',
    59 => '選項',
    60 => '已啟動',
    61 => '自動保存',
    62 => '自動刪除',
    63 => '',
    64 => '',
    65 => '',
    66 => '',
    67 => 'Expand the Content Edit Area size',
    68 => 'Reduce the Content Edit Area size',
    69 => 'Publish Story Date',
    70 => 'Toolbar Selection',
    71 => 'Basic Toolbar',
    72 => 'Common Toolbar',
    73 => 'Advanced Toolbar',
    74 => 'Advanced II Toolbar',
    75 => 'Full Featured'
);

###############################################################################
# admin/topic.php

$LANG27 = array(
    1 => '主題編輯器',
    2 => '主題編號',
    3 => '主題名',
    4 => '主題圖像',
    5 => '(不可有空隔)',
    6 => '刪除主題會同時刪除所有有關的文章和組件！',
    7 => '你需要提供主題編號和主題名！',
    8 => '主題管理員',
    9 => '點擊下面的主題可修改或刪除它，點擊上面的新主題可創造一個新的。在括弧裏你將發現你的存取級別。',
    10 => '排序次序',
    11 => '文章 / 頁',
    12 => '存取被拒絕',
    13 => "企圖存取不允許的主題已被記錄。請<a href=\"{$_CONF['site_admin_url']}/topic.php\">反回主題管理員晝面</a>.",
    14 => '排序方法',
    15 => '按字母排序',
    16 => '預設是',
    17 => '新主題',
    18 => '管理員首頁',
    19 => '保存',
    20 => '取消',
    21 => '刪除',
    22 => '預設',
    23 => '用此主題作為新稿的預設主體',
    24 => '(*)',
    25 => '保存檔的題目',
    26 => '用此題目作保存檔的默認題目。只准許一個題目。',
    27 => 'Or Upload Topic Icon',
    28 => 'Maximum',
    29 => 'File Upload Errors'
);

###############################################################################
# admin/user.php

$LANG28 = array(
    1 => '用戶編輯器',
    2 => '用戶編號',
    3 => '用戶名',
    4 => '全名',
    5 => '密碼',
    6 => '安全級別',
    7 => '電郵地址',
    8 => '首頁',
    9 => '(不可有空隔)',
    10 => '你需要提供用戶名、全名、安全級別和電郵地址。',
    11 => '用戶管理員',
    12 => '點擊下面的用戶可修改或刪除它，點擊上面的新用戶可創造一個新的。在下面的表格中輸入部份的用戶名、電郵位址或全名 (e.g.*son* or *.edu) ，可做簡單的尋找。',
    13 => '安全級別',
    14 => '登記日',
    15 => '新用戶',
    16 => '管理員首頁',
    17 => '改密碼',
    18 => '取消',
    19 => '刪除',
    20 => '保存',
    21 => '用戶名已經存在',
    22 => '錯誤',
    23 => '大量增加',
    24 => '大量輸入用戶',
    25 => '你可一次過輸入大量的用戶到 Geeklog 。輸入檔案必須是一個用 tab 分隔的文字檔案，欄位元的順序是︰全名、用戶名、電郵地址。每一個被輸入的用戶將會收到一個以電子郵件發送的隨機密碼。檔案中每一行是一個用戶。沒遵守這些要求將造成問題，也許需要手動作業，請再三檢查你檔案！',
    26 => '尋找',
    27 => '結果範圍',
    28 => '在這裏打鉤可刪除這張圖片',
    29 => '路徑',
    30 => '輸入',
    31 => '新用戶',
    32 => '處理完成。輸入了 %d 個；%d 個失敗',
    33 => '遞交',
    34 => '錯誤︰你必須指定上載檔案。',
    35 => '最後一次登入',
    36 => '(從未)',
    37 => 'UID',
    38 => 'Group Listing',
    39 => 'Password (again)',
    40 => 'Registration Date',
    41 => 'Last login Date',
    42 => 'Banned',
    43 => 'Awaiting Activation',
    44 => 'Awaiting Authorization',
    45 => 'Active',
    46 => 'User Status',
    47 => 'Edit'
);

###############################################################################
# admin/moderation.php

$LANG29 = array(
    1 => '批准',
    2 => '刪除',
    3 => '編輯',
    4 => '簡要描述',
    10 => '標題',
    11 => '開始日期',
    12 => 'URL',
    13 => '類別',
    14 => '日期',
    15 => '主題',
    16 => '用戶名',
    17 => '全名',
    18 => '電子郵件',
    34 => '命令和控制',
    35 => '已遞交的文章',
    36 => '已遞交的連結',
    37 => '已遞交的事件',
    38 => '遞交',
    39 => '此時沒有遞交的東西',
    40 => '申請的用戶'
);

###############################################################################
# calendar.php

$LANG30 = array(
    1 => 'Sunday',
    2 => 'Monday',
    3 => 'Tuesday',
    4 => 'Wednesday',
    5 => 'Thursday',
    6 => 'Friday',
    7 => 'Saturday',
    8 => '新增事件',
    9 => 'Geeklog 事件',
    10 => '事件給',
    11 => '主日曆',
    12 => '我的日曆',
    13 => '一月',
    14 => '二月',
    15 => '三月',
    16 => '四月',
    17 => '五月',
    18 => '六月',
    19 => '七月',
    20 => '八月',
    21 => '九月',
    22 => '十月',
    23 => '十一月',
    24 => '十二月',
    25 => '回到',
    26 => '整日',
    27 => '星期',
    28 => '個人日曆︰',
    29 => '公眾日曆',
    30 => '刪除事件',
    31 => '新增',
    32 => '事件',
    33 => '星期',
    34 => '時間',
    35 => '迅速增加',
    36 => '遞交',
    37 => '抱歉，本站並不提供個人日曆。',
    38 => '個人事件編輯器',
    39 => '日',
    40 => '周',
    41 => '月'
);

###############################################################################
# admin/mail.php

$LANG31 = array(
    1 => "{$_CONF['site_name']} 郵件程式",
    2 => '寄件人',
    3 => '回復到',
    4 => '主題',
    5 => '內容',
    6 => '收件人︰',
    7 => '所有用戶',
    8 => '管理員',
    9 => '選項',
    10 => 'HTML',
    11 => '迫切的訊息！',
    12 => '發送',
    13 => '重設',
    14 => '忽略用戶設定',
    15 => '錯誤，當發送到︰',
    16 => '訊息已發送到︰',
    17 => "<a href={$_CONF['site_admin_url']}/mail.php>發送其他信件</a>",
    18 => '收件人',
    19 => '注意︰如果你希望發送訊息到本站所有的成員，請在小組選擇欄位中選擇 Logged-in Users group。',
    20 => "已發送 <successcount> 個訊息，有 <failcount> 個不能發送。發送的細節在下面。如不想看細節，你可<a href=\"{$_CONF['site_admin_url']}/mail.php\">發送其他訊息</a> 或 <a href=\"{$_CONF['site_admin_url']}/moderation.php\">反回管理員首頁</a>。",
    21 => '失敗',
    22 => '成功 ',
    23 => '全部成功 ',
    24 => '全部失敗',
    25 => '-- 請選小組 --',
    26 => '請填寫所有表格上的欄位元和選擇一個小組。'
);

###############################################################################
# admin/plugins.php

$LANG32 = array(
    1 => '安裝插件能損壞你的主系統。 必需要特別小心。 最好不要安裝任何你不瞭解的插件。',
    2 => '插件安裝聲明',
    3 => '插件安裝表格',
    4 => '插件檔案',
    5 => '插件清單',
    6 => '警告︰插件已經被安裝過！',
    7 => '你想安裝的插件已經存在，請先把它刪除再安裝。',
    8 => '插件不能通過相容性校驗。',
    9 => '這插件要求一個更新版本的 Geeklog. 你可以升級你的<a href="http://www.geeklog.net">Geeklog</a>或是另找一個適合的版本。',
    10 => '<br><b>沒有安裝的插件。</b><br><br>',
    11 => '若想修改或刪除插件，點擊以下插件的名稱。這會顯示插件的詳細內容和製作者的網站。安裝的版本和從代碼中來的版本都會顯出來。這會讓你知道此插件是否應該更新。若要安裝或升級插件請諮詢它的說明文件。',
    12 => 'plugineditor() 找不到插件名',
    13 => '插件編輯器',
    14 => '新插件',
    15 => '管理員首頁',
    16 => '插件名字',
    17 => '插件版本',
    18 => 'Geeklog 版本',
    19 => '使有效',
    20 => '是',
    21 => '否',
    22 => '安裝',
    23 => '保存',
    24 => '取消',
    25 => '刪除',
    26 => '插件名',
    27 => '插件首頁',
    28 => '已安裝的插件版本',
    29 => 'Geeklog 版本',
    30 => '刪除插件？',
    31 => '你肯定要刪除這個插件嗎？這麽會刪除所有有關這插件的檔、資料和資料結構。如果你肯定的，請再點擊下面表格中的刪除鈕。',
    32 => '<p><b>Error AutoLink tag not correct format</b></p>',
    33 => '代碼版本',
    34 => '更新',
    35 => 'Edit',
    36 => 'Code',
    37 => 'Data',
    38 => 'Update!'
);

###############################################################################
# admin/syndication.php

$LANG33 = array(
    1 => '建立文流',
    2 => '保存',
    3 => '刪除',
    4 => '取消',
    10 => '內容辛迪加',
    11 => '新文流',
    12 => '管理處首頁',
    13 => '若要修改或刪除一個文流, 再一下主題上點擊. 若要建立新的文流, 點擊以上的新文流.',
    14 => '標題',
    15 => '種類',
    16 => '檔案名',
    17 => '格式',
    18 => '最後一次更新',
    19 => '啟動',
    20 => '是',
    21 => '否',
    22 => '<i>(無文流)</i>',
    23 => '所有文章',
    24 => '文流編輯',
    25 => '文流標題',
    26 => '限定',
    27 => '條目長度',
    28 => '(0 = 無內文, 1 = 整文, other = 限定於此字數.)',
    29 => '說明',
    30 => '最後一次更新',
    31 => '字元集',
    32 => '語言',
    33 => '內容',
    34 => '條目',
    35 => '小時',
    36 => '選擇文流種類',
    37 => '你有最少一個安裝了的插件能配合內容辛迪加.一下你需要選擇你是否要建立一個主系統文流或插件文流.',
    38 => '錯誤: 缺少資訊',
    39 => '請填入文流標題, 說明, 和檔案名.',
    40 => '請輸入條目數目或小時數目.',
    41 => '連結',
    42 => '事件',
    43 => 'All',
    44 => 'None',
    45 => 'Header-link in topic',
    46 => 'Limit Results',
    47 => 'Search',
    48 => 'Edit',
    49 => 'Feed Logo',
    50 => "Relative to site url ({$_CONF['site_url']})"
);

###############################################################################
# confirmation and error messages

$MESSAGE = array(
    1 => "我們已電郵了你的密碼到你的電郵信箱，請跟隨郵件中的指示。多謝使用 {$_CONF['site_name']}",
    2 => "多謝遞交你的文章到 {$_CONF['site_name']} 。只要經過我們員工的核對，你的文章將出現在我們的綱頁上。",
    3 => "多謝遞交連結到 {$_CONF['site_name']} 。只要經過我們員工的核對，你的連結將出現在我們的綱頁上。",
    4 => "多謝遞交事件到 {$_CONF['site_name']} 。只要經過我們員工的核對，你的事件將出現在我們的<a href={$_CONF['site_url']}/calendar.php>日曆</a>上。",
    5 => '你的帳戶設定已被保存了。',
    6 => '你的個人設定已被保存了。',
    7 => '你的評論介面設定已被保存了。',
    8 => '你已退出。',
    9 => '你的文章已被保存了。',
    10 => '你的文章已被刪除了。',
    11 => '你的組件已被保存了。',
    12 => '你的組件已被刪除了。',
    13 => '你的主題已被保存了。',
    14 => '你的主題和所有相關的文章已被刪除了。',
    15 => '你的連結已被保存了。',
    16 => '你的連結已被刪除了。',
    17 => '你的事件已被保存了。',
    18 => '你的事件已被刪除了。',
    19 => '你的投票已被保存了。',
    20 => '你的投票已被刪除了。',
    21 => '用戶已被保存了。',
    22 => '用戶已被刪除了。',
    23 => '增加事件到你的日歷時發生錯誤，缺少了事件編號。',
    24 => '事件已增加到你的日曆中。',
    25 => '你要登入才可開啟你的個人日曆。',
    26 => '事件已從你的日曆中移除。',
    27 => '資訊已發送。',
    28 => '插件已被保存了。',
    29 => '抱歉，本站並不提供個人日曆。',
    30 => '存取被拒絕',
    31 => '抱歉，你不能進入文章管理的首頁。請注意你的企圖已被記錄。',
    32 => '抱歉，你不能進入主題管理的首頁。請注意你的企圖已被記錄。',
    33 => '抱歉，你不能進入組件管理的首頁。請注意你的企圖已被記錄。',
    34 => '抱歉，你不能進入連結管理的首頁。請注意你的企圖已被記錄。',
    35 => '抱歉，你不能進入事件管理的首頁。請注意你的企圖已被記錄。',
    36 => '抱歉，你不能進入投票管理的首頁。請注意你的企圖已被記錄。',
    37 => '抱歉，你不能進入用戶管理的首頁。請注意你的企圖已被記錄。',
    38 => '抱歉，你不能進入 Plug-in 管理的首頁。請注意你的企圖已被記錄。',
    39 => '抱歉，你不能進入電郵管理的首頁。請注意你的企圖已被記錄。',
    40 => '系統訊息',
    41 => '抱歉，你不能進入字詞替換的首頁。請注意你的企圖已被記錄。',
    42 => '你的字詞已被保存了。',
    43 => '你的字詞已被刪除了。',
    44 => '插件已被安裝了。',
    45 => '插件已被刪除了。',
    46 => '抱歉，你不能進入資料庫備份程式。請注意你的企圖已被記錄。',
    47 => '這只適用於 *nix 如果你的作業系統是 *nix，那麽你的緩衝器已被清除了。如果你的作業系統是 Windows，你要手動尋找檔命名為 adodb _ *.php 的檔案並把它們除去。',
    48 => "感謝你申請成為 {$_CONF['site_name']} 的會員。只要經過我們員工的核對，我們會把密碼寄到你所登記的電郵中。",
    49 => '你的小組已被保存了。',
    50 => '小組已被刪除了。',
    51 => '此用戶名已有人在用。請選擇另一個。',
    52 => '你給的電信位址不像是有效。',
    53 => '你的新密碼已被接受。現在以下請用你的新密碼來登入.',
    54 => '你要求新密碼的期限以過。請在下面從新要求。',
    55 => '已經給你寄了一封電信。請照此信的說明來設定新密碼。',
    56 => '你供給的電信位址已有別的用戶在使用。',
    57 => '你的用戶已經成功地刪除了。',
    58 => '你的文流已成功的保存了.',
    59 => '你的文流已成功的刪除了.',
    60 => '插件已經更新成功',
    61 => '插件 %s: 不知名的資訊占位元符',
    62 => 'The trackback comment has been deleted.',
    63 => 'An error occurred when deleting the trackback comment.',
    64 => 'Your trackback comment has been successfully sent.',
    65 => 'Weblog directory service successfully saved.',
    66 => 'The weblog directory service has been deleted.',
    67 => 'The new password does not match the confirmation password!',
    68 => 'You have to enter the correct current password.',
    69 => 'Your account has been blocked!',
    70 => 'Your account is awaiting administrator approval.',
    71 => 'Your account has now been confirmed and is awaiting administrator approval.',
    72 => 'An error occured while attempting to install the plugin. See error.log for details.',
    73 => 'An error occured while attempting to uninstall the plugin. See error.log for details.',
    74 => 'The pingback has been successfully sent.',
    75 => 'Trackbacks must be sent using a POST request.'
);

###############################################################################

$LANG_ACCESS = array(
    'access' => '存取',
    'ownerroot' => '所有者/Root',
    'group' => '小組',
    'readonly' => '唯讀',
    'accessrights' => '存取權',
    'owner' => '所有者',
    'grantgrouplabel' => '給予之上小組編輯權利',
    'permmsg' => '注意︰會員是指所有註冊和登入的用戶；而匿名是指所有非註冊的流覽者或沒有登入的用戶。',
    'securitygroups' => '安全小組',
    'editrootmsg' => "即使你是用戶管理員；但你不能編輯 root 用戶。你能編輯所有的用戶除了 root 用戶。請注意所有企圖非法地編輯 root 用戶的動作已被記錄。請回到<a href=\"{$_CONF['site_admin_url']}/user.php\">用戶管理頁</a>去。",
    'securitygroupsmsg' => '選擇這位用戶屬於的小組。',
    'groupeditor' => '小組編輯器',
    'description' => '描述',
    'name' => '名字',
    'rights' => '許可權',
    'missingfields' => '缺少欄位',
    'missingfieldsmsg' => '你必須提供小組的名字和描述',
    'groupmanager' => '小組管理員',
    'newgroupmsg' => '點擊下面的小組可修改或刪除它，點擊上面的新小組可創造一個新的。請注意所核心小組不能被刪除。',
    'groupname' => '組名',
    'coregroup' => '核心小組',
    'yes' => '是',
    'no' => '否',
    'corerightsdescr' => "這個小組的許可權不能被編輯，因為這是個 {$_CONF['site_name']} 的核心小組。以下是這小組的許可權清單(唯讀的)。",
    'groupmsg' => '安全小組在這綱站是有等級制度的。當增加這個小組到另一組別，這個小組將得到那組別的許可權。請盡可能小組加下列的組別去。如果這小組需要特別的許可權，你可以在以下的"權利"區域中挑選。要把小組加到組別去，你只需要在組別旁邊的挑選盒打鉤。',
    'coregroupmsg' => "因為這是個 {$_CONF['site_name']} 的核心小組，這個小組的許可權不能被編輯。以下是這小組的組別清單(唯讀的)。",
    'rightsdescr' => '小組的許可權可以是來自於小組本身或是這小組所屬的組別。以下的許可權中如沒有檢驗盒即代表這許可權是來自於小組所屬的組別；如有檢驗盒即代表你可以直接把許可權給予這小組。',
    'lock' => '鎖住',
    'members' => '成員',
    'anonymous' => '匿名',
    'permissions' => '許可權',
    'permissionskey' => 'R = 唯讀， E = 編輯，有編輯權即有唯讀權',
    'edit' => '編輯',
    'none' => '沒有',
    'accessdenied' => '存取被拒絕',
    'storydenialmsg' => "因未被批准，你不可以觀看這個文章。這是可能是因為你並不是 {$_CONF['site_name']} 的會員。請<a href=users.php?mode=new>成為會員</a>。",
    'eventdenialmsg' => "因未被批准，你不可以觀看這個事件。這是可能是因為你並不是 {$_CONF['site_name']} 的會員。請<a href=users.php?mode=new>成為會員</a>。",
    'nogroupsforcoregroup' => '這小組不屬於任何其他的小組',
    'grouphasnorights' => ' 這小組沒有管理權。',
    'newgroup' => '新小組',
    'adminhome' => '管理員首頁',
    'save' => '保存',
    'cancel' => '取消',
    'delete' => '刪除',
    'canteditroot' => '因為你不屬於 Root 小組，所以你對 Root 小組的修改被拒絕了。如有問題請與系統管理員聯繫。',
    'listusers' => '列出用戶',
    'listthem' => '列出',
    'usersingroup' => '屬於 "%s" 小組的用戶',
    'usergroupadmin' => '用戶小組管理',
    'add' => '加入',
    'remove' => '免除',
    'availmembers' => '可用的成員',
    'groupmembers' => '小組成員',
    'canteditgroup' => '若要修改此小組, 你必要時這個小組的成員. 若你認為這是錯誤, 請你聯絡系統管理員.',
    'cantlistgroup' => '要看此小組的會員，你必須是此小組的會員。你若認為這是錯誤，請聯絡系統管理員。',
    'editgroupmsg' => 'To modify the group membership, click on the member names(s) and use the add or remove buttons. If the member is a member of the group, their name will appear on the right side only. Once you are complete - press <b>Save</b> to update the group and return to the main group admin page.',
    'listgroupmsg' => 'Listing of all current members in the group: <b>%s</b>',
    'search' => 'Search',
    'submit' => 'Submit',
    'limitresults' => 'Limit Results',
    'group_id' => 'Group ID',
    'plugin_access_denied_msg' => 'You are illegally trying access a plugin administration page.  Please note that all attempts to illegally access this page are logged.',
    'groupexists' => 'Group name already exists',
    'groupexistsmsg' => 'There is already a group with this name. Group names must be unique.'
);

###############################################################################
# admin/database.php

$LANG_DB_BACKUP = array(
    'last_ten_backups' => '最後十個備份',
    'do_backup' => '做備份',
    'backup_successful' => '資料庫備份完成。',
    'db_explanation' => '要做新的 Geeklog 備份，點擊以下的按鈕',
    'not_found' => "不正確的路徑或 mysqldump 程式不可執行。<br>檢查<strong>{$_DB_mysqldump_path}</strong>定義在 config.php.<br>變數現在被定義為︰<var>{$_DB_mysqldump_path}</var>",
    'zero_size' => '備份失敗︰檔案是 0 大小',
    'path_not_found' => "{$_CONF['backup_path']} 不存在或不是目錄",
    'no_access' => "錯誤︰目錄 {$_CONF['backup_path']} ，不能存取。",
    'backup_file' => '備份檔案',
    'size' => '大小',
    'bytes' => '位元組',
    'total_number' => '總備份次數: %d'
);

###############################################################################

$LANG_BUTTONS = array(
    1 => '首頁',
    2 => '聯絡',
    3 => '投稿',
    4 => '連結',
    5 => '投票',
    6 => '日曆',
    7 => '本站統計資料',
    8 => '個人化',
    9 => '搜索',
    10 => '進階搜尋',
    11 => 'Directory'
);

###############################################################################
# 404.php

$LANG_404 = array(
    1 => '404 錯誤',
    2 => '咦，我到處都看過了但找不到<b>%s</b>.',
    3 => "<p>很抱歉，但你要求的檔不存在。請檢查<a href=\"{$_CONF['site_url']}\">主頁</a>或<a href=\"{$_CONF['site_url']}/search.php\">搜索頁</a>看看能發現什麽。"
);

###############################################################################
# login form

$LANG_LOGIN = array(
    1 => '要求登入',
    2 => '抱歉，要求登入才可存取這個區域。',
    3 => '登入',
    4 => '新用戶'
);

###############################################################################
# pdfgenerator.php

$LANG_PDF = array(
    1 => 'PDF 版本的作用已被禁止',
    2 => '所提供的檔沒有呈遞。檔已收到，但是無法處理。請肯定你所提交的檔是 html 格式的檔寫於 xHTML 的標準。請注意過分複雜的 html 檔也可能無法正確呈遞。你的檔提交的結果是 0 bytes 而且已被刪除。你若肯定你的檔應該順利的呈遞，其再次提交。',
    3 => '不知名的PDF 檔製作錯誤。',
    4 => '沒提供頁數資料或你要用以下的特別 PDF 製作工具。若你認為你所得到的這頁是錯誤。 請聯絡系統管理員。要不然，你可用以下的表格來特別製作 PDF。',
    5 => '正在裝置你的檔。',
    6 => '你的檔被裝置時請等待。',
    7 => '你可用右擊以下的按鈕，然後選 \'save target...\' or \'save link location...\' 來存續你的檔的一個拷貝。',
    8 => '在配置檔案裏的 HTMLDoc二進位檔案路徑有錯誤，或此系統無法執行此檔案。若此問題繼續發生，請聯絡網站管理員。',
    9 => 'PDF 製作器',
    10 => '這是特別的 PDF 製作工具。它會將任何 URL 轉換成 PDF 版本。請注意，有些網頁不會正確的被這工具處理成功。這是 HTMLDoc PDF 製作工具的有限之處，而這樣的錯誤不需要報告給此網站的管理員。',
    11 => 'URL',
    12 => '製作 PDF!',
    13 => '此伺服器的 PHP 配置不准許 fopen() 命令用在 URL 上。 系統管理員必須先修改  php.ini 檔案，然後設定 allow_url_fopen 到 On',
    14 => '你要求的 PDF 不存在或你在非法的入取一個檔案。'
);

###############################################################################
# trackback.php

$LANG_TRB = array(
    'trackback' => 'Trackback',
    'from' => 'from',
    'tracked_on' => 'Tracked on',
    'read_more' => '[read more]',
    'intro_text' => 'Here\'s what others have to say about \'%s\':',
    'no_comments' => 'No trackback comments for this entry.',
    'this_trackback_url' => 'Trackback URL for this entry:',
    'num_comments' => '%d trackback comments',
    'send_trackback' => 'Send Pings',
    'preview' => 'Preview',
    'editor_title' => 'Send trackback comment',
    'trackback_url' => 'Trackback URL',
    'entry_url' => 'Entry URL',
    'entry_title' => 'Entry Title',
    'blog_name' => 'Site Name',
    'excerpt' => 'Excerpt',
    'truncate_warning' => 'Note: The receiving site may truncate your excerpt',
    'button_send' => 'Send',
    'button_preview' => 'Preview',
    'send_error' => 'Error',
    'send_error_details' => 'Error when sending trackback comment:',
    'url_missing' => 'No Entry URL',
    'url_required' => 'Please enter at least a URL for the entry.',
    'target_missing' => 'No Trackback URL',
    'target_required' => 'Please enter a trackback URL',
    'error_socket' => 'Could not open socket.',
    'error_response' => 'Response not understood.',
    'error_unspecified' => 'Unspecified error.',
    'select_url' => 'Select Trackback URL',
    'not_found' => 'Trackback URL not found',
    'autodetect_failed' => 'Geeklog could not detect the Trackback URL for the post you want to send your comment to. Please enter it manually below.',
    'trackback_explain' => 'From the links below, please select the URL you want to send your Trackback comment to. Geeklog will then try to determine the correct Trackback URL for that post. Or you can <a href="%s">enter it manually</a> if you know it already.',
    'no_links_trackback' => 'No links found. You can not send a Trackback comment for this entry.',
    'pingback' => 'Pingback',
    'pingback_results' => 'Pingback results',
    'send_pings' => 'Send Pings',
    'send_pings_for' => 'Send Pings for "%s"',
    'no_links_pingback' => 'No links found. No Pingbacks were sent for this entry.',
    'pingback_success' => 'Pingback sent.',
    'no_pingback_url' => 'No pingback URL found.',
    'resend' => 'Resend',
    'ping_all_explain' => 'You can now notify the sites you linked to (<a href="http://en.wikipedia.org/wiki/Pingback">Pingback</a>), advertise that your site has been updated by pinging weblog directory services, or send a <a href="http://en.wikipedia.org/wiki/Trackback">Trackback</a> comment in case you wrote about a post on someone else\'s site.',
    'pingback_button' => 'Send Pingback',
    'pingback_short' => 'Send Pingbacks to all sites linked from this entry.',
    'pingback_disabled' => '(Pingback disabled)',
    'ping_button' => 'Send Ping',
    'ping_short' => 'Ping weblog directory services.',
    'ping_disabled' => '(Ping disabled)',
    'trackback_button' => 'Send Trackback',
    'trackback_short' => 'Send a Trackback comment.',
    'trackback_disabled' => '(Trackback disabled)',
    'may_take_a_while' => 'Please note that sending Pingbacks and Pings may take a while.',
    'ping_results' => 'Ping results',
    'unknown_method' => 'Unknown ping method',
    'ping_success' => 'Ping sent.',
    'error_site_name' => 'Please enter the site\'s name.',
    'error_site_url' => 'Please enter the site\'s URL.',
    'error_ping_url' => 'Please enter a valid Ping URL.',
    'no_services' => 'No weblog directory services configured.',
    'services_headline' => 'Weblog Directory Services',
    'service_explain' => 'To modify or delete a weblog directory service, click on the edit icon of that service below. To add a new weblog directory service, click on "Create New" above.',
    'service' => 'Service',
    'ping_method' => 'Ping method',
    'service_website' => 'Website',
    'service_ping_url' => 'URL to ping',
    'ping_standard' => 'Standard Ping',
    'ping_extended' => 'Extended Ping',
    'ping_unknown' => '(unknown method)',
    'edit_service' => 'Edit Weblog Directory Service',
    'trackbacks' => 'Trackbacks',
    'editor_intro' => 'Prepare your trackback comment for <a href="%s">%s</a>.',
    'editor_intro_none' => 'Prepare your trackback comment.',
    'trackback_note' => 'To send a trackback comment for a story, go to the list of stories and click on "Send Ping" for the story. To send a trackback that is not related to a story, <a href="%s">click here</a>.',
    'pingback_explain' => 'Enter a URL to send the Pingback to. The pingback will point to your site\'s homepage.',
    'pingback_url' => 'Pingback URL',
    'site_url' => 'This site\'s URL',
    'pingback_note' => 'To send a pingback for a story, go to the list of stories and click on "Send Ping" for the story. To send a pingback that is not related to a story, <a href="%s">click here</a>.',
    'pbtarget_missing' => 'No Pingback URL',
    'pbtarget_required' => 'Please enter a pingback URL',
    'pb_error_details' => 'Error when sending the pingback:'
);

###############################################################################
# directory.php

$LANG_DIR = array(
    'title' => 'Article Directory',
    'title_year' => 'Article Directory for %d',
    'title_month_year' => 'Article Directory for %s %d',
    'nav_top' => 'Back to Article Directory',
    'no_articles' => 'No articles.'
);

###############################################################################
# "What's New" Time Strings
# 
# For the first two strings, you can use the following placeholders.
# Order them so it makes sense in your language:
# %i    item, "Stories"
# %n    amount, "2", "20" etc.
# %t    time, "2" (weeks)
# %s    scale, "hrs", "weeks"

$LANG_WHATSNEW = array(
    'new_string' => '%n new %i in the last %t %s',
    'new_last' => 'last %t %s',
    'minutes' => 'minutes',
    'hours' => 'hours',
    'days' => 'days',
    'weeks' => 'weeks',
    'months' => 'months',
    'minute' => 'minute',
    'hour' => 'hour',
    'day' => 'day',
    'week' => 'week',
    'month' => 'month'
);

###############################################################################
# Admin - Strings
# 
# These are some standard strings used by core functions as well as plugins to
# display administration lists and edit pages

$LANG_ADMIN = array(
    'search' => 'Search',
    'limit_results' => 'Limit Results',
    'submit' => 'Submit',
    'edit' => 'Edit',
    'admin_home' => 'Admin Home',
    'create_new' => 'Create New',
    'enabled' => 'Enabled',
    'title' => 'Title',
    'type' => 'Type',
    'topic' => 'Topic',
    'help_url' => 'Help File URL',
    'save' => 'Save',
    'cancel' => 'Cancel',
    'delete' => 'Delete',
    'copy' => 'Copy',
    'no_results' => '- No entries found -',
    'data_error' => 'There was an error processing the subscription data. Please check the data source.'
);

###############################################################################
# Localisation of the texts for the various drop-down menus that are actually
# stored in the database. If these exist, they override the texts from the
# database.

$LANG_commentcodes = array(
    0 => 'Comments Enabled',
    -1 => 'Comments Disabled'
);


$LANG_commentmodes = array(
    'flat' => 'Flat',
    'nested' => 'Nested',
    'threaded' => 'Threaded',
    'nocomment' => 'No Comments'
);

$LANG_cookiecodes = array(
    0 => '(don\'t)',
    3600 => '1 Hour',
    7200 => '2 Hours',
    10800 => '3 Hours',
    28800 => '8 Hours',
    86400 => '1 Day',
    604800 => '1 Week',
    2678400 => '1 Month'
);

$LANG_dateformats = array(
    0 => 'System Default'
);

$LANG_featurecodes = array(
    0 => 'Not Featured',
    1 => 'Featured'
);

$LANG_frontpagecodes = array(
    0 => 'Show Only in Topic',
    1 => 'Show on Front Page'
);

$LANG_postmodes = array(
    'plaintext' => 'Plain Old Text',
    'html' => 'HTML Formatted'
);

$LANG_sortcodes = array(
    'ASC' => 'Oldest First',
    'DESC' => 'Newest First'
);

$LANG_trackbackcodes = array(
    0 => 'Trackback Enabled',
    -1 => 'Trackback Disabled'
);

?>