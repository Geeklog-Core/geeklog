<?php

###############################################################################
# russian_utf-8.php
# This is the english language file for the Geeklog Static Page plugin
#
# Copyright (C) 2001 Tony Bibbs
# tony@tonybibbs.com
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
#           XX - file id number
#           YY - phrase id number
###############################################################################

$LANG_STATIC = array(
    'newpage' => 'Новая страница',
    'adminhome' => 'Главная администратора',
    'staticpages' => 'Статические страницы',
    'staticpageeditor' => 'Редактор статических страниц',
    'writtenby' => 'Автор',
    'date' => 'Последнее обновление',
    'title' => 'Заголовок',
    'page_title' => 'Заголовок страницы',
    'content' => 'Содержимое',
    'hits' => 'Просмотры',
    'staticpagelist' => 'Список статических страниц',
    'url' => 'URL',
    'edit' => 'Редактировать',
    'lastupdated' => 'Последнее обновление',
    'pageformat' => 'Формат страницы',
    'leftrightblocks' => 'Левые и правые блоки',
    'blankpage' => 'Пустая страница',
    'noblocks' => 'Без блоков',
    'leftblocks' => 'Левые блоки',
    'addtomenu' => 'Добавить в меню',
    'label' => 'Метка',
    'nopages' => 'В системе пока нет статических страниц',
    'save' => 'Сохранить',
    'preview' => 'Предпросмотр',
    'delete' => 'Удалить',
    'cancel' => 'Отмена',
    'access_denied' => 'Доступ закрыт',
    'access_denied_msg' => 'Вы пытаетесь получить несанкционированный доступ к одной из страниц администрирования статических страниц. Все такие попытки регистрируются.',
    'all_html_allowed' => 'Разрешён весь HTML',
    'results' => 'Результаты по страницам',
    'author' => 'Автор',
    'no_title_or_content' => 'Необходимо заполнить как минимум поля <b>Заголовок</b> и <b>Содержимое</b>, а также выбрать <b>Тему</b>.',
    'title_error_saving' => 'Ошибка при сохранении страницы',
    'template_xml_error' => 'В XML-разметке обнаружена <em>ошибка</em>. Эта страница настроена на использование другой страницы в качестве шаблона, поэтому переменные шаблона должны быть определены с помощью XML-разметки. Подробнее см. в <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">вики Geeklog</a>. Ошибку необходимо исправить перед сохранением страницы.',
    'no_such_page_anon' => 'Пожалуйста, войдите.',
    'no_page_access_msg' => 'Возможно, вы не вошли в систему или не являетесь участником {$_CONF[\'site_name\']}. Чтобы получить полный доступ, пожалуйста, <a href="{$_CONF[\'site_url\']}/users.php?mode=new">зарегистрируйтесь на {$_CONF[\'site_name\']}</a>.',
    'php_msg' => 'PHP: ',
    'php_warn' => 'Предупреждение: если включить эту опцию, PHP-код на странице будет выполнен. Используйте с осторожностью!',
    'exit_msg' => 'Тип выхода: ',
    'exit_info' => 'Включите для сообщения о необходимости входа. Оставьте выключенным для обычной проверки безопасности и сообщения.',
    'deny_msg' => 'Доступ к этой странице запрещён. Страница могла быть перемещена или удалена, либо у вас недостаточно прав.',
    'stats_headline' => 'Десять самых популярных страниц',
    'stats_page_title' => 'Заголовок страницы',
    'stats_hits' => 'Просмотры',
    'stats_no_hits' => 'Похоже, на сайте нет статических страниц или их ещё никто не просматривал.',
    'id' => 'ID',
    'duplicate_id' => 'Выбранный идентификатор статической страницы уже используется. Выберите другой ID.',
    'instructions' => 'Чтобы изменить или удалить статическую страницу, нажмите значок редактирования рядом с ней. Чтобы открыть страницу, нажмите её заголовок. Чтобы создать новую статическую страницу, нажмите «Создать». Значок копирования создаёт копию существующей страницы. Права на редактирование и чтение зависят как от прав самой страницы, так и от минимальных прав на назначенную ей тему.',
    'centerblock' => 'Центральный блок: ',
    'centerblock_msg' => 'Если отмечено, статическая страница будет отображаться как центральный блок на главной странице назначенных ей тем.',
    'topic' => 'Раздел',
    'position' => 'Позиция: ',
    'all_topics' => 'Все',
    'no_topic' => 'Только главная страница',
    'position_top' => 'Вверху страницы',
    'position_feat' => 'После избранной статьи',
    'position_bottom' => 'Внизу страницы',
    'position_entire' => 'Вся страница',
    'head_centerblock' => 'Центральный блок',
    'centerblock_no' => 'Нет',
    'centerblock_top' => 'Сверху',
    'centerblock_feat' => 'Избранная статья',
    'centerblock_bottom' => 'Снизу',
    'centerblock_entire' => 'Вся страница',
    'inblock_msg' => 'В блоке: ',
    'inblock_info' => 'Отображать статическую страницу внутри блока.',
    'title_edit' => 'Редактировать страницу',
    'title_copy' => 'Создать копию этой страницы',
    'title_display' => 'Показать страницу',
    'select_php_none' => 'не выполнять PHP',
    'select_php_return' => 'выполнить PHP (return)',
    'select_php_free' => 'выполнить PHP',
    'php_not_activated' => 'Использование PHP на статических страницах не активировано. Подробности см. в <a href="' . $_CONF['site_url'] . '/docs/english/staticpages.html#php">документации</a>.',
    'printable_format' => 'Версия для печати',
    'copy' => 'Копировать',
    'limit_results' => 'Ограничить результаты',
    'search' => 'Поиск',
	'likes' => 'Отметки «Нравится»',
    'submit' => 'Принять',
    'no_new_pages' => 'Нет новых страниц',
    'pages' => 'Страницы',
    'comments' => 'Комментарии',
    'template' => 'Шаблон',
    'use_template' => 'Использовать шаблон',
    'template_msg' => 'Если отмечено, эта статическая страница будет помечена как шаблон.',
    'none' => 'Нет',
    'use_template_msg' => 'Если эта статическая страница не является шаблоном, ей можно назначить шаблон. При выборе шаблона содержимое страницы должно соответствовать правильному формату XML. Подробнее см. в <a href="http://wiki.geeklog.net/Static_Pages_Plugin#Template_Static_Pages" target="_blank">вики Geeklog</a>.',    'draft' => 'Черновик',
    'draft_yes' => 'Да',
    'draft_no' => 'Нет',
    'show_on_page' => 'Показывать на странице',
    'show_on_page_disabled' => 'Примечание: эта опция сейчас отключена для всех страниц в настройках статических страниц.',
    'cache_time'        => 'Время кэширования',
    'cache_time_desc'   => 'Содержимое статической страницы будет храниться в кэше не дольше указанного количества секунд. 0 отключает кэширование, -1 хранит кэш до следующего редактирования страницы. Страницы с PHP и страницы-шаблоны не кэшируются. (3600 = 1 час, 86400 = 1 день)',
    'autotag_desc_staticpage' => '[staticpage: id альтернативный заголовок] - Показывает ссылку на статическую страницу, используя её заголовок. Альтернативный заголовок необязателен.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id] - Показывает содержимое статической страницы.',
    'autotag_desc_page' => '[page: id альтернативный заголовок] - Показывает ссылку на страницу из плагина Статические страницы, используя её заголовок. Альтернативный заголовок необязателен.',
    'autotag_desc_page_content' => '[page_content: id] - Показывает содержимое страницы из плагина Статические страницы.',
    'yes' => 'Да',
    'used_by' => 'Этот шаблон назначен %s странице(ам). Он может использоваться большим числом страниц, если вызывается через autotag в другом шаблоне.',
    'prev_page' => 'Предыдущая страница',
    'next_page' => 'Следующая страница',
    'parent_page' => 'Родительская страница',
    'page_desc' => 'Указание предыдущей и/или следующей страницы задаёт связь между страницами в постраничной серии. Ссылки навигации автоматически на страницу не добавляются — их нужно добавить самостоятельно. ПРИМЕЧАНИЕ: родительская страница в настоящее время не используется.',
    'num_pages' => '%s стр.',
    'search_desc' => 'Определяет, появляется ли страница в результатах поиска. Значение по умолчанию зависит от настроек плагина и типа страницы (центральный блок, использование шаблона или PHP).',
	'likes_desc' => 'Определяет, отображается ли на странице управление отметками «Нравится» и каким образом. Значение по умолчанию зависит от настроек плагина. Страницы, показанные как центральные блоки, не отображают этот элемент. Страницы-шаблоны эту настройку не используют.'      
);

$PLG_staticpages_MESSAGE15 = 'Ваш комментарий отправлен на проверку и будет опубликован после одобрения модератором.';
$PLG_staticpages_MESSAGE19 = 'Страница успешно сохранена.';
$PLG_staticpages_MESSAGE20 = 'Страница успешно удалена.';
$PLG_staticpages_MESSAGE21 = 'Эта страница ещё не существует. Чтобы создать её, заполните форму ниже. Если вы попали сюда по ошибке, нажмите «Отмена».';
$PLG_staticpages_MESSAGE22 = 'Страницу удалить нельзя: это шаблон, который в настоящее время назначен одной или нескольким статическим страницам.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Обновление плагина не поддерживается.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Search options for pages
$LANG_staticpages_search = array(
    0  => 'Исключено',
    1  => 'Использовать значение по умолчанию',
    2  => 'Включено'
);

// Likes options for pages 
// The same values for these options will match values for the config option "likes_pages"
$LANG_staticpages_likes = array(
    -1 => 'Использовать значение по умолчанию',
    0  => 'Отключено',
    1  => 'Нравится и Не нравится',
    2  => 'Только Нравится',
);

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Статические страницы',
    'title' => 'Настройка статических страниц'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Разрешить PHP?',
    'enable_eval_php_save' => 'Разбирать PHP при сохранении страницы',
    'sort_by' => 'Сортировать центральные блоки по',
    'sort_menu_by' => 'Сортировать пункты меню по',
    'sort_list_by' => 'Сортировать список администрирования по',
    'delete_pages' => 'Удалять страницы вместе с владельцем?',
    'in_block' => 'Показывать страницы внутри блока?',
    'show_hits' => 'Показывать просмотры?',
    'show_date' => 'Показывать дату?',
    'filter_html' => 'Фильтровать HTML?',
    'censor' => 'Фильтровать содержимое?',
    'default_permissions' => 'Права страницы по умолчанию',
    'autotag_permissions_staticpage' => 'Права [staticpage: ]',
    'autotag_permissions_staticpage_content' => 'Права [staticpage_content: ]',
    'aftersave' => 'После сохранения страницы',
    'atom_max_items' => 'Макс. страниц в ленте веб-сервисов',
    'meta_tags' => 'Включить метатеги',
    'likes_pages' => 'Отметки «Нравится» для страниц',
    'comment_code' => 'Комментарии по умолчанию',
    'structured_data_type_default' => 'Тип структурированных данных по умолчанию',
    'draft_flag' => 'Черновик по умолчанию',
    'disable_breadcrumbs_staticpages' => 'Отключить хлебные крошки',
    'default_cache_time' => 'Время кэша по умолчанию',
    'newstaticpagesinterval' => 'Интервал новых статических страниц',
    'hidenewstaticpages' => 'Новые статические страницы',
    'title_trim_length' => 'Максимальная длина заголовка',
    'includecenterblocks' => 'Включать статические страницы-центральные блоки',
    'includephp' => 'Включать статические страницы с PHP',
    'includesearch' => 'Включать статические страницы в поиск',
    'includesearchcenterblocks' => 'Включать статические страницы-центральные блоки',
    'includesearchphp' => 'Включать статические страницы с PHP',
    'includesearchtemplate' => 'Включать статические страницы-шаблоны'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Основные настройки'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Основные настройки статических страниц',
    'tab_whatsnew' => 'Блок «Что нового»',
    'tab_search' => 'Результаты поиска',
    'tab_permissions' => 'Права по умолчанию',
    'tab_autotag_permissions' => 'Права использования автотегов'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Основные настройки статических страниц',
    'fs_whatsnew' => 'Блок «Что нового»',
    'fs_search' => 'Результаты поиска',
    'fs_permissions' => 'Права по умолчанию',
    'fs_autotag_permissions' => 'Права использования автотегов'
);

// Note: entries 0, 1, 9, 12, 17, 39, 41 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('Истина' => 1, 'Ложь' => 0),
    1 => array('Истина' => TRUE, 'Ложь' => FALSE),
    2 => array('Дата' => 'date', 'ID страницы' => 'id', 'Заголовок' => 'title'),
    3 => array('Дата' => 'date', 'ID страницы' => 'id', 'Заголовок' => 'title', 'Метка' => 'label'),
    4 => array('Дата' => 'date', 'ID страницы' => 'id', 'Заголовок' => 'title', 'Автор' => 'author'),
    5 => array('Скрыть' => 'hide', 'Показать — дата изменения' => 'modified', 'Показать — дата создания' => 'created'),
    9 => array('Перейти к странице' => 'item', 'Показать список' => 'list', 'Показать главную' => 'home', 'Показать администрирование' => 'admin'),
    12 => array('Нет доступа' => 0, 'Только чтение' => 2, 'Чтение и запись' => 3),
    13 => array('Нет доступа' => 0, 'Использовать' => 2),
    17 => array('Комментарии включены' => 0, 'Комментарии отключены' => -1),
    39 => array('Нет' => '', 'WebPage' => 'core-webpage', 'Article' => 'core-article', 'NewsArticle' => 'core-newsarticle', 'BlogPosting' => 'core-blogposting'),
    41 => array('Ложь' => 0, 'Нравится и Не нравится' => 1, 'Только Нравится' => 2)
);
