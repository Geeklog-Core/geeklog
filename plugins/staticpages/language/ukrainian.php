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
    'newpage' => 'Нова сторінка',
    'adminhome' => 'Адміністрування',
    'staticpages' => 'Статичні сторінки',
    'staticpageeditor' => 'Редактор статичних сторінок',
    'writtenby' => 'Автор',
    'date' => 'Востаннє оновлено',
    'title' => 'Заголовок',
    'page_title' => 'Page Title',
    'content' => 'Зміст',
    'hits' => 'Хіти',
    'staticpagelist' => 'Список статичних сторінок',
    'url' => 'URL',
    'edit' => 'Редагувати',
    'lastupdated' => 'Востаннє оновлено',
    'pageformat' => 'Формат сторінки',
    'leftrightblocks' => 'Лівий та правий блоки',
    'blankpage' => 'Порожня сторінка',
    'noblocks' => 'Без блоків',
    'leftblocks' => 'Ліві блоки',
    'addtomenu' => 'Додати до меню',
    'label' => 'Мітка',
    'nopages' => 'В системі ще немає статичних сторінок',
    'save' => 'зберегти',
    'preview' => 'перегляд',
    'delete' => 'видалити',
    'cancel' => 'відмінити',
    'access_denied' => 'Доступ заборонено',
    'access_denied_msg' => 'Ви намагаєтесь нелегально отримати доступ до одного з розділів адміністрування статичних сторінок.  Будь ласка, зважте, що всі спроби нелегального доступу до цієї сторінки вносять до протоколу',
    'all_html_allowed' => 'Весь HTML дозволено',
    'results' => 'Результати серед статичних сторінок',
    'author' => 'Автор',
    'no_title_or_content' => 'Вам необхідно принаймні заповнити поля <b>Заголовок</b> та <b>Зміст</b>.',
    'no_such_page_anon' => 'Будь ласка, увійдіть ..',
    'no_page_access_msg' => "Можливо, це трапилось тому, що ви не увійшли, або не є членом {$_CONF['site_name']}. Будь ласка, <a href=\"{$_CONF['site_url']}/users.php?mode=new\"> зареєструйтесь </a>на {$_CONF['site_name']} для отримання повного доступу",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Попередження: PHP код вашої сторінки буде виконано якщо ви активуєте цю опцію. Будьте обережні!!',
    'exit_msg' => 'Тип виходу: ',
    'exit_info' => 'Скористайтесь повідомленням для входу.  Залиште невідміченим для звичайного контролю безпеки та повідомлень.',
    'deny_msg' => 'Доступ до цієї сторінки заборонено. Сторінка або була переміщена/видалена, або у вас немає відповідного доступу.',
    'stats_headline' => '10 найпопулярніших статичних сторінок',
    'stats_page_title' => 'Заголовок сторінки',
    'stats_hits' => 'Хіти',
    'stats_no_hits' => 'На цьому сайті немає статичних сторінок або ніхто їх не відвідував.',
    'id' => 'ID',
    'duplicate_id' => 'Обраний вами ID для цієї сторінки вже використовується. Будь ласка, виберіть інший ID.',
    'instructions' => 'Щоб змінити чи видалити статичну сторінку, натисніть на її іконку редагування нижче. Щоб переглянути сторінку, натисніть на її заголовку. Щоб створити нову статичну сторінку, оберіть Створити нове вгорі. Натисніть іконку копії, щоб скопіювати існуючу сторінку.',
    'centerblock' => 'Центральний блок: ',
    'centerblock_msg' => 'Якщо ви відмітите, ця статична сторінка буде виводитись як центральний блок на головній сторінці.',
    'topic' => 'Тема: ',
    'position' => 'Розміщення: ',
    'all_topics' => 'Всі',
    'no_topic' => 'Лише домашня сторінка',
    'position_top' => 'Вгорі сторінки',
    'position_feat' => 'Після Особливої статті',
    'position_bottom' => 'Внизу сторінки',
    'position_entire' => 'На всю сторінку',
    'head_centerblock' => 'Центральний блок',
    'centerblock_no' => 'Ні',
    'centerblock_top' => 'Верх',
    'centerblock_feat' => 'Особ. стаття',
    'centerblock_bottom' => 'Низ',
    'centerblock_entire' => 'Вся сторінка',
    'inblock_msg' => 'У блоці: ',
    'inblock_info' => 'Помістити статичну сторінку в блок.',
    'title_edit' => 'Редагувати сторінку',
    'title_copy' => 'Копіювати сторінку',
    'title_display' => 'Переглянути сторінку',
    'select_php_none' => 'не виконувати PHP',
    'select_php_return' => 'виконувати PHP (return)',
    'select_php_free' => 'виконувати PHP',
    'php_not_activated' => "Використання PHP у статичних сторінках не активоване. Будь ласка, подивіться в <a href=\"{$_CONF['site_url']}/docs/english/staticpages.html#php\">документацію</a> щодо деталей.",
    'printable_format' => 'Формат для друку',
    'copy' => 'Копіювати',
    'limit_results' => 'Обмежити результати',
    'search' => 'Пошук',
    'submit' => 'Відіслати',
    'no_new_pages' => 'No new pages',
    'pages' => 'Pages',
    'comments' => 'Comments',
    'template' => 'Template',
    'use_template' => 'Use Template',
    'template_msg' => 'When checked, this Static Page will be marked as a template.',
    'none' => 'None',
    'use_template_msg' => 'If this Static Page is not a template, you can assign it to use a template. If a selection is made then remember that the content of this page must follow the proper XML format.',
    'draft' => 'Draft',
    'draft_yes' => 'Yes',
    'draft_no' => 'No',
    'autotag_desc_staticpage' => '[staticpage: id alternate title] - Displays a link to a static page using the static page title as the title. An alternate title may be specified but is not required.',
    'autotag_desc_staticpage_content' => '[staticpage_content: id alternate title] - Displays the contents of a staticpage.'
);

$PLG_staticpages_MESSAGE15 = 'Your comment has been submitted for review and will be published when approved by a moderator.';
$PLG_staticpages_MESSAGE19 = 'Your page has been successfully saved.';
$PLG_staticpages_MESSAGE20 = 'Your page has been successfully deleted.';
$PLG_staticpages_MESSAGE21 = 'This page does not exist yet. To create the page, please fill in the form below. If you are here by mistake, click the Cancel button.';

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
    'sort_list_by' => 'Sort Admin List by',
    'delete_pages' => 'Delete Pages with Owner?',
    'in_block' => 'Wrap Pages in Block?',
    'show_hits' => 'Show Hits?',
    'show_date' => 'Show Date?',
    'filter_html' => 'Filter HTML?',
    'censor' => 'Censor Content?',
    'default_permissions' => 'Page Default Permissions',
    'autotag_permissions_staticpage' => '[staticpage: ] Permissions',
    'autotag_permissions_staticpage_content' => '[staticpage_content: ] Permissions',
    'aftersave' => 'After Saving Page',
    'atom_max_items' => 'Max. Pages in Webservices Feed',
    'meta_tags' => 'Enable Meta Tags',
    'comment_code' => 'Comment Default',
    'draft_flag' => 'Draft Flag Default',
    'newstaticpagesinterval' => 'New Static Page Interval',
    'hidenewstaticpages' => 'Hide New Static Pages',
    'title_trim_length' => 'Title Trim Length',
    'includecenterblocks' => 'Include Center Block Static Pages',
    'includephp' => 'Include Static Pages with PHP',
    'includesearch' => 'Enable Static Pages in Search',
    'includesearchcenterblocks' => 'Include Center Block Static Pages',
    'includesearchphp' => 'Include Static Pages with PHP'
);

$LANG_configsubgroups['staticpages'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['staticpages'] = array(
    'tab_main' => 'Static Pages Main Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_search' => 'Search Results',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions'
);

$LANG_fs['staticpages'] = array(
    'fs_main' => 'Static Pages Main Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_search' => 'Search Results',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions'
);

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['staticpages'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title'),
    3 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Label' => 'label'),
    4 => array('Date' => 'date', 'Page ID' => 'id', 'Title' => 'title', 'Author' => 'author'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to page' => 'item', 'Display List' => 'list', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    17 => array('Comments Enabled' => 0, 'Comments Disabled' => -1)
);

?>
