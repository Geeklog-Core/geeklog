<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 2.0                                                     |
// +---------------------------------------------------------------------------+
// | russian_utf-8.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2020 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// +---------------------------------------------------------------------------|
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
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own.');
}

global $LANG32;

$LANG_XMLSMAP = array(
    'plugin' => 'XMLSitemap',
    'admin' => 'Администрирование XMLSitemap',
    'description' => 'Обычно все файлы sitemap автоматически обновляются при добавлении, изменении или удалении элемента. Если возникла проблема, обновите файлы sitemap вручную кнопкой ниже.',
    'filename' => 'Имя файла',
    'updated' => 'Обновлено',
    'not_saved' => 'Не сохранено',
    'update_now' => 'Обновить все файлы sitemap сейчас!',
    'update_success' => 'Все файлы sitemap успешно обновлены.',
    'update_fail' => 'Не удалось обновить файлы sitemap. Подробности смотрите в "error.log".',
);

$LANG_configsections['xmlsitemap'] = array('label' => 'XMLSitemap', 'title' => 'Настройка XMLSitemap');

$LANG_confignames['xmlsitemap'] = array(
    'sitemap_file' => 'Имя файла sitemap',
    'mobile_sitemap_file' => 'Имя файла мобильной sitemap',
    'include_homepage' => 'Главная страница в sitemap',
    'types' => 'Содержимое sitemap',
    'lastmod' => 'Типы содержимого с элементом lastmod',
    'priorities' => 'Приоритет',
    'frequencies' => 'Частота',
    'ping_google' => 'Отправлять ping в Google',
    'indexnow' => 'Включить IndexNow',
    'indexnow_key' => 'Ключ IndexNow',
    'indexnow_key_location' => 'Расположение ключа IndexNow',
    'news_sitemap_file' => 'Имя файла новостной sitemap',
    'news_sitemap_topics' => 'Включать статьи из этих тем',
    'news_sitemap_age' => 'Максимальный возраст статей',
);

$LANG_configsubgroups['xmlsitemap'] = array('sg_main' => 'Основные настройки');

$LANG_tab['xmlsitemap'] = array(
    'tab_main' => 'Основные настройки XMLSitemap',
    'tab_pri' => 'Приоритет',
    'tab_freq' => 'Частота обновления',
    'tab_ping' => 'Ping',
    'tab_news' => 'Новостная sitemap',
);

$LANG_fs['xmlsitemap'] = array(
    'fs_main' => 'Основные настройки XMLSitemap',
    'fs_pri' => 'Приоритет (по умолчанию = 0,5, минимум = 0,0, максимум = 1,0)',
    'fs_freq' => 'Частота обновления',
    'fs_ping' => 'Отправлять ping при изменении',
    'fs_news' => 'Настройки новостной sitemap',
);

$LANG_configselects['xmlsitemap'] = array(
    0 => array('Да' => 1, 'Нет' => 0),
    1 => array('Да' => TRUE, 'Нет' => FALSE),
    9 => array('Перейти на страницу' => 'item', 'Показать список' => 'list', 'Показать главную' => 'home', 'Показать администрирование' => 'admin'),
    12 => array('Нет доступа' => 0, 'Только чтение' => 2, 'Чтение и запись' => 3),
    20 => array('всегда' => 'always', 'ежечасно' => 'hourly', 'ежедневно' => 'daily', 'еженедельно' => 'weekly', 'ежемесячно' => 'monthly', 'ежегодно' => 'yearly', 'никогда' => 'never', 'скрыто' => 'hidden'),
);
