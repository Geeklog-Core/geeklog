<?php

###############################################################################
# russian.php
# This is the russian language page for the Geeklog Polls Plug-in!
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
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_POLLS = array(
    'polls'             => 'Опросы',
    'results'           => 'Результаты',
    'pollresults'       => 'Результаты опроса',
    'votes'             => 'голосов',
    'vote'              => 'Голосовать',
    'pastpolls'         => 'Прошлые опросы',
    'savedvotetitle'    => 'Голос сохранено',
    'savedvotemsg'      => 'Ваш голос в опросе был учтён',
    'pollstitle'        => 'Опросы',
    'pollquestions'     => 'Перейти к другим опросам',
    'stats_top10'       => '10 популярнейших опросов',
    'stats_questions'   => 'Вопросы',
    'stats_votes'       => 'ГОлосов',
    'stats_none'        => 'На этом сайте нет опросов, или ещё никто в них не голосовал.',
    'stats_summary'     => 'Опросов (Голосов) в системе',
    'open_poll'         => 'Открытый для голосования'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Режим',
    2 => 'Пожалуйста, введите вопрос и хотя бы один ответ.',
    3 => 'Опрос создан',
    4 => "Опрос %s сохранено",
    5 => 'Редактировать опрос',
    6 => 'ID опроса',
    7 => '(не использовать пробелы)',
    8 => 'Показывать на главной странице',
    9 => 'Вопрос',
    10 => 'Ответы / Голоса',
    11 => "Во время доступа к данным об ответах опроса %s произошла ошибка",
    12 => "Во время доступа к данным о вопросе опроса %s произошла ошибка",
    13 => 'Создать опрос',
    14 => 'сохранить',
    15 => 'отменить',
    16 => 'удалить',
    17 => 'Пожалуйста, введите ID опроса',
    18 => 'Список опросов',
    19 => 'Что бы изменить или удалить опрос, нажмите его иконку редактирования, которая находиться ниже.  Что бы создать новый опрос, выберете "Создать новый" выше.',
    20 => 'Проголосовало',
    21 => 'Доступ запрещён',
    22 => "Вы пытаетесь получить доступ к опросу с ограниченными правами доступа.  Эту попытку записано. Пожалуйста, <a href=\"{$_CONF['site_admin_url']}/poll.php\">вернитесь к администрированиюa>.",
    23 => 'Новый опрос',
    24 => 'Администрирование',
    25 => 'Да',
    26 => 'Нет',
    27 => 'Редактировать',
    28 => 'Послать',
    29 => 'Поиск',
    30 => 'Ограничить результаты',
);

$PLG_polls_MESSAGE19 = 'Ваш опрос успешно сохранён.';
$PLG_polls_MESSAGE20 = 'Your poll has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

?>
