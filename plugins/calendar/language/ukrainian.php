<?php

###############################################################################
# ukrainian.php
# This is the ukrainian language page for the Geeklog Calendar Plug-in!
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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

# index.php
$LANG_CAL_1 = array(
    1 => 'Календар подій',
    2 => 'Вибачте, немає подій для відображення.',
    3 => 'Коли',
    4 => 'Де',
    5 => 'Опис',
    6 => 'Додати подію',
    7 => 'Майбутні події',
    8 => 'Додавши цю подію до свого календаря, ви можете швидко переглянути лише ті події, які вас цікавлять, натиснувши "Мій календар" у Функціях користувача.',
    9 => 'Додати до мого календаря',
    10 => 'Вилучити з мого календаря',
    11 => 'Додаємо подію до календаря %s',
    12 => 'Подія',
    13 => 'Початок',
    14 => 'Кінець',
    15 => 'Назад до календаря',
    16 => 'Календар',
    17 => 'Дата початку',
    18 => 'Дата закінчення',
    19 => 'Надсилання до календаря',
    20 => 'Назва',
    21 => 'Дата початку',
    22 => 'URL',
    23 => 'Ваші події',
    24 => 'Загальні події',
    25 => 'Немає майбутніх подій',
    26 => 'Надіслати подію',
    27 => "Якщо ви надішлете подію на {$_CONF['site_name']}, її буде додано до головного календаря, де користувачі зможуть за бажанням додати її до свого персонального календаря. Ця функція <b>НЕ</b> для зберігання ваших особистих подій, таких як дні народження та річниці.<br" . XHTML . "><br" . XHTML . ">Коли ви надішлете подію, її буде подано на розгляд адміністраторам, і у разі схвалення ваша подія з'явиться у головному календарі.",
    28 => 'Назва',
    29 => 'Час початку',
    30 => 'Час закінчення',
    31 => 'Подія на увесь день',
    32 => 'Адреса, перший рядок',
    33 => 'Адреса, другий рядок',
    34 => 'Місто/Село',
    35 => 'Область',
    36 => 'Індекс',
    37 => 'Тип події',
    38 => 'Редагувати типи подій',
    39 => 'Розташування',
    40 => 'Додати подію до',
    41 => 'Головного календаря',
    42 => 'Особистого календаря',
    43 => 'Посилання',
    44 => 'HTML теги заборонено',
    45 => 'Надіслати',
    46 => 'Події в системі',
    47 => '10 найпопулярніших подій',
    48 => 'Перегляди',
    49 => 'На сайті ще немає подій, або ж ніхто ще їх не переглядав.',
    50 => 'Події',
    51 => 'Вилучити',
    'autotag_desc_event' => '[event: id alternate title] - Displays a link to an Event Link from the Calendar using the Event Title as the title. An alternate title may be specified but is not required.'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Результати з календаря',
    'title' => 'Назва',
    'date_time' => 'Дата і час',
    'location' => 'Розташування',
    'description' => 'Опис'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Додати особисту подію',
    9 => 'Подія %s',
    10 => 'Події для',
    11 => 'Головний календар',
    12 => 'Мій календар',
    25 => 'Назад до ',
    26 => 'Увесь день',
    27 => 'Тиждень',
    28 => 'Особистий календар для',
    29 => 'Публічний календар',
    30 => 'вилучити подію',
    31 => 'Додати',
    32 => 'Подія',
    33 => 'Дата',
    34 => 'Час',
    35 => 'Швидко додати',
    36 => 'Надіслати',
    37 => 'Вибачте, персональні календарі на цьому сайті заборонені',
    38 => 'Редактор особистої події',
    39 => 'День',
    40 => 'Тиждень',
    41 => 'Місяць',
    42 => 'Додати головну подію',
    43 => 'Надіслані події'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Редактор подій',
    2 => 'Помилка',
    3 => 'Режим публікації',
    4 => 'URL події',
    5 => 'Дата початку події',
    6 => 'Дата закінчення події',
    7 => 'Розташування події',
    8 => 'Опис події',
    9 => '(включаючи http://)',
    10 => 'Ви маєте ввести дати/час, назву події та опис',
    11 => 'Менеджер календаря',
    12 => 'Щоб змінити чи вилучити подію, натисніть її іконку редагування нижче.  Щоб створити нову подію, натисніть "Створити нове" вгорі. Натисніть іконку копіювання, щоб створити копію існуючої події.',
    13 => 'Автор',
    14 => 'Дата початку',
    15 => 'Дата закінчення',
    16 => '',
    17 => "Ви намагаєтесь отримати доступ до події, до якої у вас немає прав.  Цю спробу записано. Будь-ласка, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">поверніться до адміністрування подій</a>.",
    18 => '',
    19 => '',
    20 => 'зберегти',
    21 => 'скасувати',
    22 => 'вилучити',
    23 => 'Неправильна дата початку.',
    24 => 'Неправильна дата закінчення.',
    25 => 'Дата закінчення передує даті початку.',
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
    'save' => 'Вашу подію успішно збережено.',
    'delete' => 'Подію успішно вилучено.',
    'private' => 'Подію успішно збережено до вашого календаря.',
    'login' => 'Неможливо відкрити ваш особистий календар, доки ви не ввійдете до системи',
    'removed' => 'Подію успішно вилучено з вашого особистого календаря',
    'noprivate' => 'Вибачте, персональні календарі на цьому сайті заборонені',
    'unauth' => 'Вибачте, але у вас немає доступу до сторінки адміністрування подій. Будь-ласка, зайважте, що всі спробу несанкціонованого доступу записуються.'
);

$PLG_calendar_MESSAGE4 = "Дякуємо за надсилання події на {$_CONF['site_name']}.  Її передано на схвалення нашому персоналу.  У разі схвалення, вашу подію можна буде побачити тут, в нашому <a href=\"{$_CONF['site_url']}/calendar/index.php\">календарі</a>.";
$PLG_calendar_MESSAGE17 = 'Вашу подію успішно збережено.';
$PLG_calendar_MESSAGE18 = 'Подію успішно вилучено.';
$PLG_calendar_MESSAGE24 = 'Подію успішно збережено до вашого календаря.';
$PLG_calendar_MESSAGE26 = 'Подію успішно вилучено.';

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
    'autotag_permissions_event' => '[event: ] Permissions',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Topic',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['calendar'] = array(
    'tab_main' => 'General Calendar Settings',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_events_block' => 'Events Block'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'TOPIC_ALL_OPTION', 'Homepage Only' => 'TOPIC_HOMEONLY_OPTION', 'Select Topics' => 'TOPIC_SELECTED_OPTION')
);

?>
