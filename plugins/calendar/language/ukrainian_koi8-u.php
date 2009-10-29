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
    1 => 'Календар под╕й',
    2 => 'Вибачте, нема╓ под╕й для в╕дображення.',
    3 => 'Коли',
    4 => 'Де',
    5 => 'Опис',
    6 => 'Додати под╕ю',
    7 => 'Майбутн╕ под╕╖',
    8 => 'Додавши цю под╕ю до свого календаря, ви можете швидко переглянути лише т╕ под╕╖, як╕ вас ц╕кавлять, натиснувши "М╕й календар" у Функц╕ях користувача.',
    9 => 'Додати до мого календаря',
    10 => 'Вилучити з мого календаря',
    11 => 'Дода╓мо под╕ю до календаря %s',
    12 => 'Под╕я',
    13 => 'Початок',
    14 => 'К╕нець',
    15 => 'Назад до календаря',
    16 => 'Календар',
    17 => 'Дата початку',
    18 => 'Дата зак╕нчення',
    19 => 'Надсилання до календаря',
    20 => 'Назва',
    21 => 'Дата початку',
    22 => 'URL',
    23 => 'Ваш╕ под╕╖',
    24 => 'Загальн╕ под╕╖',
    25 => 'Нема╓ майбутн╕х под╕й',
    26 => 'Над╕слати под╕ю',
    27 => "Якщо ви над╕шлете под╕ю на {$_CONF['site_name']}, ╖╖ буде додано до головного календаря, де користувач╕ зможуть за бажанням додати ╖╖ до свого персонального календаря. Ця функц╕я <b>НЕ</b> для збер╕гання ваших особистих под╕й, таких як дн╕ народження та р╕чниц╕.<br" . XHTML . "><br" . XHTML . ">Коли ви над╕шлете под╕ю, ╖╖ буде подано на розгляд адм╕н╕страторам, ╕ у раз╕ схвалення ваша под╕я з'явиться у головному календар╕.",
    28 => 'Назва',
    29 => 'Час початку',
    30 => 'Час зак╕нчення',
    31 => 'Под╕я на увесь день',
    32 => 'Адреса, перший рядок',
    33 => 'Адреса, другий рядок',
    34 => 'М╕сто/Село',
    35 => 'Область',
    36 => '╤ндекс',
    37 => 'Тип под╕╖',
    38 => 'Редагувати типи под╕й',
    39 => 'Розташування',
    40 => 'Додати под╕ю до',
    41 => 'Головного календаря',
    42 => 'Особистого календаря',
    43 => 'Посилання',
    44 => 'HTML теги заборонено',
    45 => 'Над╕слати',
    46 => 'Под╕╖ в систем╕',
    47 => '10 найпопулярн╕ших под╕й',
    48 => 'Перегляди',
    49 => 'На сайт╕ ще нема╓ под╕й, або ж н╕хто ще ╖х не переглядав.',
    50 => 'Под╕╖',
    51 => 'Вилучити'
);

$_LANG_CAL_SEARCH = array(
    'results' => 'Результати з календаря',
    'title' => 'Назва',
    'date_time' => 'Дата ╕ час',
    'location' => 'Розташування',
    'description' => 'Опис'
);

###############################################################################
# calendar.php ($LANG30)

$LANG_CAL_2 = array(
    8 => 'Додати особисту под╕ю',
    9 => 'Под╕я %s',
    10 => 'Под╕╖ для',
    11 => 'Головний календар',
    12 => 'М╕й календар',
    25 => 'Назад до ',
    26 => 'Увесь день',
    27 => 'Тиждень',
    28 => 'Особистий календар для',
    29 => 'Публ╕чний календар',
    30 => 'вилучити под╕ю',
    31 => 'Додати',
    32 => 'Под╕я',
    33 => 'Дата',
    34 => 'Час',
    35 => 'Швидко додати',
    36 => 'Над╕слати',
    37 => 'Вибачте, персональн╕ календар╕ на цьому сайт╕ заборонен╕',
    38 => 'Редактор особисто╖ под╕╖',
    39 => 'День',
    40 => 'Тиждень',
    41 => 'М╕сяць',
    42 => 'Додати головну под╕ю',
    43 => 'Над╕слан╕ под╕╖'
);

###############################################################################
# admin/plugins/calendar/index.php, formerly admin/event.php ($LANG22)

$LANG_CAL_ADMIN = array(
    1 => 'Редактор под╕й',
    2 => 'Помилка',
    3 => 'Режим публ╕кац╕╖',
    4 => 'URL под╕╖',
    5 => 'Дата початку под╕╖',
    6 => 'Дата зак╕нчення под╕╖',
    7 => 'Розташування под╕╖',
    8 => 'Опис под╕╖',
    9 => '(включаючи http://)',
    10 => 'Ви ма╓те ввести дати/час, назву под╕╖ та опис',
    11 => 'Менеджер календаря',
    12 => 'Щоб зм╕нити чи вилучити под╕ю, натисн╕ть ╖╖ ╕конку редагування нижче.  Щоб створити нову под╕ю, натисн╕ть "Створити нове" вгор╕. Натисн╕ть ╕конку коп╕ювання, щоб створити коп╕ю ╕снуючо╖ под╕╖.',
    13 => 'Автор',
    14 => 'Дата початку',
    15 => 'Дата зак╕нчення',
    16 => '',
    17 => "Ви намага╓тесь отримати доступ до под╕╖, до яко╖ у вас нема╓ прав.  Цю спробу записано. Будь-ласка, <a href=\"{$_CONF['site_admin_url']}/plugins/calendar/index.php\">поверн╕ться до адм╕н╕стрування под╕й</a>.",
    18 => '',
    19 => '',
    20 => 'зберегти',
    21 => 'скасувати',
    22 => 'вилучити',
    23 => 'Неправильна дата початку.',
    24 => 'Неправильна дата зак╕нчення.',
    25 => 'Дата зак╕нчення переду╓ дат╕ початку.',
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
    'save' => 'Вашу под╕ю усп╕шно збережено.',
    'delete' => 'Под╕ю усп╕шно вилучено.',
    'private' => 'Под╕ю усп╕шно збережено до вашого календаря.',
    'login' => 'Неможливо в╕дкрити ваш особистий календар, доки ви не вв╕йдете до системи',
    'removed' => 'Под╕ю усп╕шно вилучено з вашого особистого календаря',
    'noprivate' => 'Вибачте, персональн╕ календар╕ на цьому сайт╕ заборонен╕',
    'unauth' => 'Вибачте, але у вас нема╓ доступу до стор╕нки адм╕н╕стрування под╕й. Будь-ласка, зайважте, що вс╕ спробу несанкц╕онованого доступу записуються.'
);

$PLG_calendar_MESSAGE4 = "Дяку╓мо за надсилання под╕╖ на {$_CONF['site_name']}.  ╥╖ передано на схвалення нашому персоналу.  У раз╕ схвалення, вашу под╕ю можна буде побачити тут, в нашому <a href=\"{$_CONF['site_url']}/calendar/index.php\">календар╕</a>.";
$PLG_calendar_MESSAGE17 = 'Вашу под╕ю усп╕шно збережено.';
$PLG_calendar_MESSAGE18 = 'Под╕ю усп╕шно вилучено.';
$PLG_calendar_MESSAGE24 = 'Под╕ю усп╕шно збережено до вашого календаря.';
$PLG_calendar_MESSAGE26 = 'Под╕ю усп╕шно вилучено.';

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
    'default_permissions' => 'Event Default Permissions'
);

$LANG_configsubgroups['calendar'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['calendar'] = array(
    'fs_main' => 'General Calendar Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 6, 9, 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['calendar'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    6 => array('12' => 12, '24' => 24),
    9 => array('Forward to Event' => 'item', 'Display Admin List' => 'list', 'Display Calendar' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
