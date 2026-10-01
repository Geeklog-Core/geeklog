<?php

###############################################################################
# russian.php
# This is the russian language page for the Geeklog Links Plug-in!
#
# Copyright (C) 2006 Volodymyr V. Prokurashko
# vvprok@ukr.net
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

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_LINKS = array(
    10 => 'Присланные',
    14 => 'Ссылка',
    84 => 'Ссылки',
    88 => 'Нет новых ссылок',
    114 => 'Ссылки',
    116 => 'Добавить ссылку',
    117 => 'Сообщить о неработающей ссылке',
    118 => 'Отчёт о неработающей ссылке',
    119 => 'Следующая ссылка отмечена как неработающая: ',
    120 => 'Чтобы изменить ссылку, нажмите здесь: ',
    121 => 'О неработающей ссылке сообщил: ',
    122 => 'Спасибо за сообщение о неработающей ссылке. Администратор исправит проблему как можно скорее',
    123 => 'Спасибо',
    124 => 'Перейти',
    125 => 'Категории',
    126 => 'Вы здесь:',
    'autotag_desc_link' => '[link: id альтернативный заголовок] — отображает ссылку из плагина Links, используя заголовок ссылки. Альтернативный заголовок можно указать при необходимости.',
    'root' => 'Корень'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Ссылок (Кликов) в системе',
    'stats_headline' => '10 самых популярных ссылок',
    'stats_page_title' => 'Ссылки',
    'stats_hits' => 'Хиты',
    'stats_no_hits' => 'На этом сайте нет ссылок, или никто ими не пользовался.'
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
    'results' => 'Результаты из каталога ссылок',
    'title' => 'Заголовок',
    'date' => 'Добавлено',
    'author' => 'Автор',
    'hits' => 'Кликов'
);

###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'Отослать ссылку',
    2 => 'Ссылка',
    3 => 'Категория',
    4 => 'Другое',
    5 => 'Если "Другое", укажите',
    6 => 'Ошибка: Отсутствует категория',
    7 => 'Выбирая "Другое", пожалйста, укажите название категории',
    8 => 'Заголовок',
    9 => 'URL',
    10 => 'Категория',
    11 => 'Входящие ссылки'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Спасибо за присланную на {$_CONF['site_name']} ссылку!  Ссылка отправлена администрацией сайта на одобрение.  В случае одобрения, ссылку будет добавлено в раздел <a href={$_CONF['site_url']}/links/index.php>Ссылки</a>.";
$PLG_links_MESSAGE2 = 'Ваша ссылка успешно добавлена.';
$PLG_links_MESSAGE3 = 'Ссылка успешно удалена.';
$PLG_links_MESSAGE4 = "Спасибо за присланную на {$_CONF['site_name']} ссылку!  Ссылка добавлена в раздел <a href={$_CONF['site_url']}/links/index.php>Ссылки</a>.";
$PLG_links_MESSAGE5 = 'You do not have sufficient access rights to view this category.';
$PLG_links_MESSAGE6 = 'You do not have sufficient rights to edit this category.';
$PLG_links_MESSAGE7 = 'Please enter a Category Name and Description.';
$PLG_links_MESSAGE10 = 'Your category has been successfully saved.';
$PLG_links_MESSAGE11 = 'You are not allowed to set the id of a category to "site" or "user" - these are reserved for internal use.';
$PLG_links_MESSAGE12 = 'You are trying to make a parent category the child of it\'s own subcategory. This would create an orphan category, so please first move the child category or categories up to a higher level.';
$PLG_links_MESSAGE13 = 'The category has been successfully deleted.';
$PLG_links_MESSAGE14 = 'Category contains links and/or categories. Please remove these first.';
$PLG_links_MESSAGE15 = 'You do not have sufficient rights to delete this category.';
$PLG_links_MESSAGE16 = 'No such category exists.';
$PLG_links_MESSAGE17 = 'This category id is already in use.';

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/plugins/links/index.php

$LANG_LINKS_ADMIN = array(
    1 => 'Редактор ссылок',
    2 => 'ID ссылки',
    3 => 'Заголовок',
    4 => 'URL',
    5 => 'Категория',
    6 => '(включая http://)',
    7 => 'Другое',
    8 => 'Клики на ссылку',
    9 => 'Описание',
    10 => 'Вы должны указать заголовок, URL и описание.',
    11 => 'Менеджер ссылок',
    12 => 'Чтобы изменить или удалить ссылку, нажмите значок редактирования рядом с ней. Для создания ссылки или категории используйте «Новая ссылка» или «Новая категория». Для редактирования нескольких категорий выберите «Список категорий».',
    14 => 'Категория ссылки',
    16 => 'Доступ запрещён',
    17 => "Вы попытались доступиться до ссылки с ограниченными правами на просмотр.  Инфрмация об этой попыткой записана.  Пожалуйста, <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">вернитесь к администрированию</a>.",
    20 => 'Если другое, укажите',
    21 => 'сохранить',
    22 => 'отменить',
    23 => 'удалить',
    24 => 'Ссылка не найдена',
    25 => 'Выбранная для редактирования ссылка не найдена.',
    26 => 'Проверить ссылки',
    27 => 'HTTP-статус',
    28 => 'Редактировать категорию',
    29 => 'Введите или измените данные ниже.',
    30 => 'Категория',
    31 => 'Описание',
    32 => 'ID категории',
    33 => 'Тема',
    34 => 'Родительская',
    35 => 'Все',
    40 => 'Редактировать эту категорию',
    41 => 'Создать дочернюю категорию',
    42 => 'Удалить эту категорию',
    43 => 'Категории сайта',
    44 => 'Добавить&nbsp;дочернюю',
    46 => 'Пользователь %s попытался удалить категорию, к которой у него нет доступа',
    50 => 'Список категорий',
    51 => 'Новая ссылка',
    52 => 'Новая категория',
    53 => 'Список ссылок',
    54 => 'Менеджер категорий',
    55 => 'Редактируйте категории ниже. Категорию с вложенными категориями или ссылками удалить нельзя: сначала удалите их или переместите в другую категорию.',
    56 => 'Редактор категорий',
    57 => 'Ещё не проверено',
    58 => 'Проверить сейчас',
    59 => '<p>Чтобы проверить все показанные ссылки, нажмите «Проверить сейчас». В зависимости от количества ссылок это может занять некоторое время.</p>',
    60 => 'Пользователь %s попытался без разрешения изменить категорию %s.',
    61 => 'Ссылки в категории',
    'num_links' => '%s ссылок'
);


$LANG_LINKS_STATUS = array(
    100 => 'Continue',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported',
    999 => 'Connection Timed out'
);

// Localization of the Admin Configuration UI
$LANG_configsections['links'] = array(
    'label' => 'Links',
    'title' => 'Links Configuration'
);

$LANG_confignames['links'] = array(
    'linksloginrequired' => 'Links Login Required?',
    'linksubmission' => 'Enable Submission Queue?',
    'newlinksinterval' => 'New Links Interval',
    'hidenewlinks' => 'Hide New Links?',
    'hidelinksmenu' => 'Hide Links Menu Entry?',
    'linkcols' => 'Categories per Column',
    'linksperpage' => 'Links per Page',
    'show_top10' => 'Show Top 10 Links?',
    'notification' => 'Notification Email?',
    'delete_links' => 'Delete Links with Owner?',
    'aftersave' => 'After Saving Link',
    'show_category_descriptions' => 'Show Category Description?',
    'new_window' => 'Open external links in new window?',
    'recaptcha' => 'reCAPTCHA',
    'recaptcha_score' => 'reCAPTCHA Score',
    'root' => 'ID of Root Category',
    'default_permissions' => 'Link Default Permissions',
    'category_permissions' => 'Category Default Permissions',
    'autotag_permissions_link' => '[link: ] Permissions'
);

$LANG_configsubgroups['links'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['links'] = array(
    'tab_public' => 'Public Links List Settings',
    'tab_admin' => 'Links Admin Settings',
    'tab_permissions' => 'Link Permissions',
    'tab_cpermissions' => 'Category Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['links'] = array(
    'fs_public' => 'Public Links List Settings',
    'fs_admin' => 'Links Admin Settings',
    'fs_permissions' => 'Default Permissions',
    'fs_cpermissions' => 'Category Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['links'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    9 => array('Forward to Linked Site' => 'item', 'Display Admin List' => 'list', 'Display Public List' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('Disabled' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4)
);
