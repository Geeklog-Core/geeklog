<?php

###############################################################################
# ukrainian.php
# This is the ukrainian language page for the Geeklog Polls Plug-in!
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

global $LANG32;

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => 'Опитування',
    'results'           => 'Результати',
    'pollresults'       => 'Результати опитування',
    'votes'             => 'голосів',
    'vote'              => 'Голосувати',
    'pastpolls'         => 'Минулі опитування',
    'savedvotetitle'    => 'Голос збережено',
    'savedvotemsg'      => 'Ваш голос у опитуванні враховано',
    'pollstitle'        => 'Опитування в системі',
    'pollquestions'     => 'Переглянути інші опитування',
    'stats_top10'       => '10 найпопулярніших опитувань',
    'stats_questions'   => 'Запитання опитування',
    'stats_votes'       => 'Голосів',
    'stats_none'        => 'На цьому сайті немає опитувань, або ще ніхто в них не голосував.',
    'stats_summary'     => 'Опитувань (Голосів) у системі',
    'open_poll'         => 'Відкритий для голосування'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Режим',
    2 => 'Будь-ласка, введіть запитання і хоча б одну відповідь.',
    3 => 'Опитування створено',
    4 => "Опитування %s збережено",
    5 => 'Редагувати опитування',
    6 => 'ID опитування',
    7 => '(не використовувати проміжки)',
    8 => 'Виводити на головній сторінці',
    9 => 'Запитання',
    10 => 'Відповіді / Голоси',
    11 => "Під час видобування даних про відповіді опитування %s виникла помилка",
    12 => "Під час видобування даних про запитання опитування %s виникла помилка",
    13 => 'Створити опитування',
    14 => 'зберегти',
    15 => 'скасувати',
    16 => 'вилучити',
    17 => 'Будь-ласка, введіть ID опитування',
    18 => 'Список опитувань',
    19 => 'Щоб змінити чи вилучити опитування, натисніть його іконку редагування нижче.  Щоб створити нове опитування, оберіть "Створити нове" вгорі.',
    20 => 'Проголосувало',
    21 => 'Доступ заборонено',
    22 => "Ви намагались отримати доступ до опитування, до якого у вас немає прав.  Цю спробу записано. Будь-ласка, <a href=\"{$_CONF['site_admin_url']}/poll.php\">поверніться до адміністрування</a>.",
    23 => 'Нове опитування',
    24 => 'Адміністрування',
    25 => 'Так',
    26 => 'Ні',
    27 => 'Редагувати',
    28 => 'Надіслати',
    29 => 'Пошук',
    30 => 'Обмежити результати',
);

$PLG_polls_MESSAGE19 = 'Ваше опитування успішно збережено.';
$PLG_polls_MESSAGE20 = 'Ваше опитування успішно вилучено.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
