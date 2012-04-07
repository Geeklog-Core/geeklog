<?php

###############################################################################
# russian.php
# This is the russian language page for the Geeklog Calendar Plug-in!
#
# Copyright (C) 2006 Alexander Yurchenko
# archy@gala.net
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

# index.php
$LANG_CAL_1 = array(
    1 => 'Календарь событий',
    2 => 'Извините, нет событий для отображения.',
    3 => 'Когда',
    4 => 'Где',
    5 => 'Описание',
    6 => 'Добавить событие',
    7 => 'Будущие события',
    8 => 'Добавив это событие в свой календарь, ви сможете быстро просмотреть только те события, которые Вас интересуют, нажав "Мой календарь" в Функциях пользователя.',
    9 => 'Добавить в мой календать',
    10 => 'Удалить из моего календаря',
    11 => 'Добавляем событие в календарь %s',
    12 => 'Событие',
    13 => 'Начало',
    14 => 'Конец',
    15 => 'Назад в календарь',
    16 => 'Календарь',
    17 => 'Дата начала',
    18 => 'Дата окончания',
    19 => 'Ссылка к календарю',
    20 => 'Название',
    21 => 'Дата начала',
    22 => 'URL',
    23 => 'Ваши события',
    24 => 'Глобальные события',
    25 => 'Нет будущих событий',
    26 => 'Отослать событие',
    27 => "Если вы отошлёте событие на {$_CONF['site_name']}, оно будет добавлено в главный календарь, где пользователи смогут, по желанию, добавить его в свои персональные календари. Эта функция <b>НЕ</b> для сберигания Ваших личных событий, таких как дни роджения и годовщины!<br" . XHTML . "><br" . XHTML . ">Когда Вы отошлёте событие, оно будет отправлено на рассмотрение администраторам, и, в случае одобрения, Ваше событие появится в главном календаре.",
    28 => 'Название',
    29 => 'Время начала',
    30 => 'Время окончания',
    31 => 'Событие на весь день',
    32 => 'Адрес, первый ряд',
    33 => 'Адрес, второй ряд',
    34 => 'Город/Село',
    35 => 'Область',
    36 => 'Индекс',
    37 => 'Тип события',
    38 => 'Редактировать типы событий',
    39 => 'Розмещение',
    40 => 'Добавить событие к',
    41 => 'Главному календарю',
    42 => 'Личному календарю',
    43 => 'Ссылки',
    44 => 'HTML теги запрещены',
    45 => 'Отослать',
    46 => 'События в системе',
    47 => '10 самых популярных событий',
    48 => 'Просмотров',
    49 => 'На сайте пока нет событий, или их ещё никто не просматривал.',
    50 => 'События',
    51 => 'Удалить',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Результаты из Календаря',
    'title' => 'Название',
    'date_time' => 'Дата и время',
    'location' => 'Размещение',
    'description' => 'Описание'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Добавить персональное событие',
    9 => 'Событие %s',
    10 => 'События для',
    11 => 'Главный календарь',
    12 => 'Мой календарь',
    25 => 'Назад к ',
    26 => 'Весь день',
    27 => 'Неделя',
    28 => 'Личный календарь для',
    29 => 'Публичный календарь',
    30 => 'удалить событие',
    31 => 'Добавить',
    32 => 'Событие',
    33 => 'Дата',
    34 => 'Время',
    35 => 'Добавить быстро',
    36 => 'Отослать',
    37 => 'Извините, персональные календари на этом сайте запрещены',
    38 => 'Редактор персонального события',
    39 => 'День',
    40 => 'Неделя',
    41 => 'Месяц',
    42 => 'Добавить главное событие',
    43 => 'Отосланные события'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Редактор событий',
    2 => 'Ошибка',
    3 => 'Режим публикации',
    4 => 'URL события',
    5 => 'Дата начала события',
    6 => 'Дата окончания события',
    7 => 'Размещение события',
    8 => 'Описание события',
    9 => '(включая http://)',
    10 => 'Вы должны ввести дату/время, название события и описание',
    11 => 'Менеджер календаря',
    12 => 'Чтобы изменить или удалить событие, нажмите на его иконку редактирования ниже.  Чтобы создать новое событие, нажмите "Создать новое" сверху. Нажмите на иконку копирования, чтобы создать копию существующего события (и отредактируйте его потом).',
    13 => 'Автор',
    14 => 'Дата начала',
    15 => 'Дата окончания',
    16 => '',
    17 => "Вы пытаетесь получить доступ к событию, к которому у Вас нет прав. Эта попытка запротоколирована. Пожалуйста, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">вернитесь к администрированию событий</a>.",
    18 => '',
    19 => '',
    20 => 'сохранить',
    21 => 'отменить',
    22 => 'удалить',
    23 => 'Неправильная дата начала.',
    24 => 'Неправильная дата окончания.',
    25 => 'Дата окончания предшествует дате начала. Перепутали?',
    26 => 'Delete old entries',
    27 => 'These are the events that are older than ',
    28 => ' months. Please click on the trashcan Icon on the bottom to delete them, or select a different timespan:<br' . XHTML . '>Find all entries that are older than ',
    29 => ' months.',
    30 => 'Update List',
    31 => 'Are You sure you want to permanently delete ALL selected users?',
    32 => 'List all',
    33 => 'No events selected for deletion',
    34 => 'Event ID',
    35 => 'could not be deleted',
    36 => 'Sucessfully deleted'
);

$LANG_CAL_MESSAGE = array(
    'save' => 'Ваше событие успешно сохранено.',
    'delete' => 'Событие успешно удалено.',
    'private' => 'Событие успешно сохранено в Ваш календарь.',
    'login' => 'Невозможно открыть Ваш персональный календарь, пока Вы не войдёте в систему',
    'removed' => 'Событие успешно удалено из Вашего персонального календаря',
    'noprivate' => 'Извините, персональные календари на этом сайте запрещены',
    'unauth' => 'Извините, но у вас нет доступа к странице администрирования событий. Пожалуйста, учтите, что все попытки несанкционированного доступа записываются.'
);

$PLG_calendar_MESSAGE4 = "Благодарим за отправку события в {$_CONF['site_name']}. Оно отправлено на рассмотрение нашому персоналу. У случае одобрения, ваше событие можно будет увидеть тут, в нашем <a href=\"{$_CONF['site_url']}/calendar/index.php\">календаре</a>.";
$PLG_calendar_MESSAGE17 = 'Ваше событие успешно сохранено.';
$PLG_calendar_MESSAGE18 = 'Событие успешно удалено.';
$PLG_calendar_MESSAGE24 = 'Событие успешно сохранено в Ваш календарь.';
$PLG_calendar_MESSAGE26 = 'Событие успешно удалено.';

// Messages for the plugin upgrade
$PLG_calendar_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_calendar_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['calendar'] = array(
    'label' => 'Calendar',
    'title' => 'Calendar Configuration'
);

$LANG_confignames['calendar'] = array(
    'calendarloginrequired' => 'Calendar Login Required?',
    'hidecalendarmenu' => 'Hide Calendar Menu Entry?',
    'personalcalendars' => 'Enable Personal Calendars?',
    'eventsubmission' => 'Enable Submission Queue?',
    'showupcomingevents' => 'Show upcoming Events?',
    'upcomingeventsrange' => 'Upcoming Events Range',
    'event_types' => 'Event Types',
    'hour_mode' => 'Hour Mode',
    'notification' => 'Notification Email?',
    'delete_event' => 'Delete Events with Owner?',
    'aftersave' => 'After Saving Event',
    'default_permissions' => 'Event Default Permissions',
    'autotag_permissions_event' => '[event: ] Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'General Calendar Settings',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2)
);

?>
