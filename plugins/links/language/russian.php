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

###############################################################################
# Array Format:
# $LANGXX[YY]:    $LANG - variable name
#              XX - file id number
#            YY - phrase id number
###############################################################################


$LANG_LINKS= array(
    10 => 'Присланные',
    14 => 'Ссылка',
    84 => 'Ссылки',
    88 => 'Нет новых ссылок',
    114 => 'Ссылки',
    116 => 'Добавить ссылку'
);

###############################################################################
# for stats

$LANG_LINKS_STATS = array(
    'links' => 'Ссылок (Кликов) в системе',
    'stats_headline' => '10 самых популярных ссылок',
    'stats_page_title' => 'Ссылки',
    'stats_hits' => 'Хиты',
    'stats_no_hits' => 'На этом сайте нет ссылок, или никто ими не пользовался.',
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

// Messages for the plugin upgrade
$PLG_links_MESSAGE3002 = $LANG32[9];

###############################################################################
# admin/link.php

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
    12 => 'Что бы изменить или удалить ссылку, нажмите на иконку редактирования, которая находиться ниже.  Что бы создать новую ссылку, выберете "Создать новую" вверху.',
    14 => 'Категория ссылки',
    16 => 'Доступ запрещён',
    17 => "Вы попытались доступиться до ссылки с ограниченными правами на просмотр.  Инфрмация об этой попыткой записана.  Пожалуйста, <a href=\"{$_CONF['site_admin_url']}/plugins/links/index.php\">вернитесь к администрированию</a>.",
    20 => 'Если другое, укажите',
    21 => 'сохранить',
    22 => 'отменить',
    23 => 'удалить'
);

?>
