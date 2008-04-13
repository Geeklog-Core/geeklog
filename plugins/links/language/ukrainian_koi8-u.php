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
# $Id: ukrainian_koi8-u.php,v 1.4 2008/04/13 11:59:08 dhaun Exp $

global $LANG32;

###############################################################################
# Array Format:
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
###############################################################################

$LANG_LINKS = array(
    10 => 'Над╕слане',
    14 => 'Посилання',
    84 => 'Посилання',
    88 => 'Нема╓ св╕жих посилань',
    114 => 'Веб ресурси',
    116 => 'Додати посилання'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Л╕нк╕в (Кл╕к╕в) у систем╕',
    'stats_headline' => '10 найпопулярн╕ших л╕нк╕в',
    'stats_page_title' => 'Посилання',
    'stats_hits' => 'Х╕ти',
    'stats_no_hits' => 'На цьому сайт╕ нема╓ посилань, або ще н╕хто ними не користувався.',
);

###############################################################################
# for the search

$LANG_LINKS_SEARCH = array(
 'results' => 'Результати з посилань',
 'title' => 'Заголовок',
 'date' => 'Додано',
 'author' => 'Автор',
 'hits' => 'Кл╕к╕в'
);
###############################################################################
# for the submission form

$LANG_LINKS_SUBMIT = array(
    1 => 'Над╕слати посилання',
    2 => 'Посилання',
    3 => 'Категор╕я',
    4 => '╤нше',
    5 => 'Якщо ╕нше, зазначте',
    6 => 'Помилка: В╕дсутня категор╕я',
    7 => 'Обираючи "╤нше", будь-ласка, вкаж╕ть назву категор╕╖',
    8 => 'Заголовок',
    9 => 'URL',
    10 => 'Категор╕я',
    11 => 'Над╕слан╕ посилання'
);

###############################################################################
# Messages for COM_showMessage the submission form

$PLG_links_MESSAGE1 = "Дяку╓мо за над╕слане на {$_CONF['site_name']} посилання.  Його передано нашому персоналу для схвалення.  У раз╕ схвалення його буде додано до розд╕лу <a href={$_CONF['site_url']}/links/index.php>Веб ресурси</a>.";
$PLG_links_MESSAGE2 = 'Ваше посилання усп╕шно збережено.';
$PLG_links_MESSAGE3 = 'Посилання усп╕шно вилучено.';
$PLG_links_MESSAGE4 = "Дяку╓мо за над╕слане на {$_CONF['site_name']} посилання.  Його додано до розд╕лу <a href={$_CONF['site_url']}/links/index.php>Веб ресурси</a>.";

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
    5 => 'Категор╕я',
    6 => '(включаючи http://)',
    7 => '╤нше',
    8 => 'Х╕ти посилання',
    9 => 'Опис',
    10 => 'Ви повинн╕ вказати заголовок, URL та опис.',
    11 => 'Менеджер посилань',
    12 => 'Щоб зм╕нити чи видалити посилання, натисн╕ть його ╕конку редагування нижче.  Щоб створити нове посилання, обер╕ть "Створити нове" вгор╕.',
    14 => 'Категор╕я посилання',
    16 => 'Доступ заборонено',
    17 => "Ви намагались отримати доступ до посилання, до якого у вас нема╓ прав.  Цю спробу записано. Будь-ласка, <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">поверн╕ться до адм╕н╕стрування</a>.",
    20 => 'Якщо ╕нше, зазначте',
    21 => 'зберегти',
    22 => 'скасувати',
    23 => 'вилучити'
);

?>
