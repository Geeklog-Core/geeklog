<?php

###############################################################################
# ukrainian.php
# This is the ukrainian language page for the Geeklog Links Plug-in!
#
# Copyright (C) 2006 Vitaliy Biliyenko
# v.lokki@gmail.com
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
# $Id: ukrainian_utf-8.php,v 1.4 2008/04/13 11:59:08 dhaun Exp $

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
###############################################################################

$LANG_LINKS = array(
    10 => 'Надіслане',
    14 => 'Посилання',
    84 => 'Посилання',
    88 => 'Немає свіжих посилань',
    114 => 'Веб ресурси',
    116 => 'Додати посилання'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Лінків (Кліків) у системі',
    'stats_headline' => '10 найпопулярніших лінків',
    'stats_page_title' => 'Посилання',
    'stats_hits' => 'Хіти',
    'stats_no_hits' => 'На цьому сайті немає посилань, або ще ніхто ними не користувався.',
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
 'results' => 'Результати з посилань',
 'title' => 'Заголовок',
 'date' => 'Додано',
 'author' => 'Автор',
 'hits' => 'Кліків'
);
###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'Надіслати посилання',
    2 => 'Посилання',
    3 => 'Категорія',
    4 => 'Інше',
    5 => 'Якщо інше, зазначте',
    6 => 'Помилка: Відсутня категорія',
    7 => 'Обираючи "Інше", будь-ласка, вкажіть назву категорії',
    8 => 'Заголовок',
    9 => 'URL',
    10 => 'Категорія',
    11 => 'Надіслані посилання'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Дякуємо за надіслане на {$_CONF['site_name']} посилання.  Його передано нашому персоналу для схвалення.  У разі схвалення його буде додано до розділу <a href={$_CONF['site_url']}/links/index.php>Веб ресурси</a>.";
$PLG_links_MESSAGE2 = 'Ваше посилання успішно збережено.';
$PLG_links_MESSAGE3 = 'Посилання успішно вилучено.';
$PLG_links_MESSAGE4 = "Дякуємо за надіслане на {$_CONF['site_name']} посилання.  Його додано до розділу <a href={$_CONF['site_url']}/links/index.php>Веб ресурси</a>.";

// Messages for the plugin upgrade
$PLG_links_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php

$LANG_LINKS_ADMIN = array(
    1 => 'Редактор посилань',
    2 => 'ID посилання',
    3 => 'Заголовок',
    4 => 'URL',
    5 => 'Категорія',
    6 => '(включаючи http://)',
    7 => 'Інше',
    8 => 'Хіти посилання',
    9 => 'Опис',
    10 => 'Ви повинні вказати заголовок, URL та опис.',
    11 => 'Менеджер посилань',
    12 => 'Щоб змінити чи видалити посилання, натисніть його іконку редагування нижче.  Щоб створити нове посилання, оберіть "Створити нове" вгорі.',
    14 => 'Категорія посилання',
    16 => 'Доступ заборонено',
    17 => "Ви намагались отримати доступ до посилання, до якого у вас немає прав.  Цю спробу записано. Будь-ласка, <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">поверніться до адміністрування</a>.",
    20 => 'Якщо інше, зазначте',
    21 => 'зберегти',
    22 => 'скасувати',
    23 => 'вилучити'
);

?>
