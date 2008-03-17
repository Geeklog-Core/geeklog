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

###############################################################################
# Array Format: 
# $LANGXX[YY]:	$LANG - variable name
#		  	XX - file id number
#			YY - phrase id number
###############################################################################


$LANG_STATIC= array(
    'newpage' => 'Нова сторінка',
    'adminhome' => 'Адміністрування',
    'staticpages' => 'Статичні сторінки',
    'staticpageeditor' => 'Редактор статичних сторінок',
    'writtenby' => 'Автор',
    'date' => 'Востаннє оновлено',
    'title' => 'Заголовок',
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
    'php_not_activated' => 'Використання PHP у статичних сторінках не активоване. Будь ласка, подивіться в <a href="' . $_CONF['site_url'] . '/docs/staticpages.html#php">документацію</a> щодо деталей.',
    'printable_format' => 'Формат для друку',
	'edit' => 'Редагувати',
    'copy' => 'Копіювати',
    'limit_results' => 'Обмежити результати',
    'search' => 'Пошук',
    'submit' => 'Відіслати'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>
