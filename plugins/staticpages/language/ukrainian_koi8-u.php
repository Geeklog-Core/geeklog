<?php

###############################################################################
# ukrainian.php
# This is the ukrainian language page for the Geeklog Static Page Plug-in!
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

$LANG_STATIC = array(
    'newpage' => 'Нова стор╕нка',
    'adminhome' => 'Адм╕н╕стрування',
    'staticpages' => 'Статичн╕ стор╕нки',
    'staticpageeditor' => 'Редактор статичних стор╕нок',
    'writtenby' => 'Автор',
    'date' => 'Востанн╓ оновлено',
    'title' => 'Заголовок',
    'content' => 'Зм╕ст',
    'hits' => 'Х╕ти',
    'staticpagelist' => 'Список статичних стор╕нок',
    'url' => 'URL',
    'edit' => 'Редагувати',
    'lastupdated' => 'Востанн╓ оновлено',
    'pageformat' => 'Формат стор╕нки',
    'leftrightblocks' => 'Л╕вий та правий блоки',
    'blankpage' => 'Порожня стор╕нка',
    'noblocks' => 'Без блок╕в',
    'leftblocks' => 'Л╕в╕ блоки',
    'addtomenu' => 'Додати до меню',
    'label' => 'М╕тка',
    'nopages' => 'В систем╕ ще нема╓ статичних стор╕нок',
    'save' => 'зберегти',
    'preview' => 'перегляд',
    'delete' => 'видалити',
    'cancel' => 'в╕дм╕нити',
    'access_denied' => 'Доступ заборонено',
    'access_denied_msg' => 'Ви намага╓тесь нелегально отримати доступ до одного з розд╕л╕в адм╕н╕стрування статичних стор╕нок.  Будь ласка, зважте, що вс╕ спроби нелегального доступу до ц╕╓╖ стор╕нки вносять до протоколу',
    'all_html_allowed' => 'Весь HTML дозволено',
    'results' => 'Результати серед статичних стор╕нок',
    'author' => 'Автор',
    'no_title_or_content' => 'Вам необх╕дно принаймн╕ заповнити поля <b>Заголовок</b> та <b>Зм╕ст</b>.',
    'no_such_page_anon' => 'Будь ласка, ув╕йд╕ть ..',
    'no_page_access_msg' => "Можливо, це трапилось тому, що ви не ув╕йшли, або не ╓ членом {$_CONF['site_name']}. Будь ласка, <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> заре╓струйтесь </a>на {$_CONF['site_name']} для отримання повного доступу",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Попередження: PHP код вашо╖ стор╕нки буде виконано якщо ви активу╓те цю опц╕ю. Будьте обережн╕!!',
    'exit_msg' => 'Тип виходу: ',
    'exit_info' => 'Скористайтесь пов╕домленням для входу.  Залиште нев╕дм╕ченим для звичайного контролю безпеки та пов╕домлень.',
    'deny_msg' => 'Доступ до ц╕╓╖ стор╕нки заборонено. Стор╕нка або була перем╕щена/видалена, або у вас нема╓ в╕дпов╕дного доступу.',
    'stats_headline' => '10 найпопулярн╕ших статичних стор╕нок',
    'stats_page_title' => 'Заголовок стор╕нки',
    'stats_hits' => 'Х╕ти',
    'stats_no_hits' => 'На цьому сайт╕ нема╓ статичних стор╕нок або н╕хто ╖х не в╕дв╕дував.',
    'id' => 'ID',
    'duplicate_id' => 'Обраний вами ID для ц╕╓╖ стор╕нки вже використову╓ться. Будь ласка, вибер╕ть ╕нший ID.',
    'instructions' => 'Щоб зм╕нити чи видалити статичну стор╕нку, натисн╕ть на ╖╖ ╕конку редагування нижче. Щоб переглянути стор╕нку, натисн╕ть на ╖╖ заголовку. Щоб створити нову статичну стор╕нку, обер╕ть Створити нове вгор╕. Натисн╕ть ╕конку коп╕╖, щоб скоп╕ювати ╕снуючу стор╕нку.',
    'centerblock' => 'Центральний блок: ',
    'centerblock_msg' => 'Якщо ви в╕дм╕тите, ця статична стор╕нка буде виводитись як центральний блок на головн╕й стор╕нц╕.',
    'topic' => 'Тема: ',
    'position' => 'Розм╕щення: ',
    'all_topics' => 'Вс╕',
    'no_topic' => 'Лише домашня стор╕нка',
    'position_top' => 'Вгор╕ стор╕нки',
    'position_feat' => 'П╕сля Особливо╖ статт╕',
    'position_bottom' => 'Внизу стор╕нки',
    'position_entire' => 'На всю стор╕нку',
    'head_centerblock' => 'Центральний блок',
    'centerblock_no' => 'Н╕',
    'centerblock_top' => 'Верх',
    'centerblock_feat' => 'Особ. стаття',
    'centerblock_bottom' => 'Низ',
    'centerblock_entire' => 'Вся стор╕нка',
    'inblock_msg' => 'У блоц╕: ',
    'inblock_info' => 'Пом╕стити статичну стор╕нку в блок.',
    'title_edit' => 'Редагувати стор╕нку',
    'title_copy' => 'Коп╕ювати стор╕нку',
    'title_display' => 'Переглянути стор╕нку',
    'select_php_none' => 'не виконувати PHP',
    'select_php_return' => 'виконувати PHP (return)',
    'select_php_free' => 'виконувати PHP',
    'php_not_activated' => "Використання PHP у статичних стор╕нках не активоване. Будь ласка, подив╕ться в <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">документац╕ю</a> щодо деталей.",
    'printable_format' => 'Формат для друку',
    'copy' => 'Коп╕ювати',
    'limit_results' => 'Обмежити результати',
    'search' => 'Пошук',
    'submit' => 'В╕д╕слати'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['staticpages'] = array(
    'label' => 'Static Pages',
    'title' => 'Static Pages Configuration'
);

$LANG_confignames['staticpages'] = array(
    'allow_php' => 'Allow PHP?',
    'sort_by' => 'Sort Centerblocks by',
    'sort_menu_by' => 'Sort Menu Entries by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_permissions' => 'Default Permissions'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3)
);

?>
