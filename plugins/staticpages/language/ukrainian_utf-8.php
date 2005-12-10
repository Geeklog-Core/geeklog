<?php

###############################################################################
# ukrainian.php
# This is the ukrainian language page for the Geeklog Static Page Plug-in!
#
# Copyright (C) 2005 Yaroslav Fedevych
# jaroslaw@nospam.kiev.ua
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
    'adminhome' => 'Домівка адміністратора',
    'staticpages' => 'Статичні сторінки',
    'staticpageeditor' => 'Редактор статичних сторінок',
    'writtenby' => 'Написав(-ла)',
    'date' => 'Востаннє поновлено',
    'title' => 'Назва',
    'content' => 'Вміст',
    'hits' => 'Звертань',
    'staticpagelist' => 'Перелік статичних сторінок',
    'url' => 'URL',
    'edit' => 'Редагувати',
    'lastupdated' => 'Востаннє поновлено',
    'pageformat' => 'Формат сторінки',
    'leftrightblocks' => 'Лівий та правий блоки',
    'blankpage' => 'Чиста сторінка',
    'noblocks' => 'Без блоків',
    'leftblocks' => 'Блоки ліворуч',
    'addtomenu' => 'Додати до меню',
    'label' => 'Мітка',
    'nopages' => 'В системі ще немає статичних сторінок',
    'save' => 'зберегти',
    'preview' => 'попередній перегляд',
    'delete' => 'вилучити',
    'cancel' => 'скасувати',
    'access_denied' => 'В доступі відмовлено',
    'access_denied_msg' => 'Ви намагаєтесь незаконно отримати доступ до сторінок адміністрування статичних сторінок. Будь ласка, зауважте, що всі такі спроби протоколюються',
    'all_html_allowed' => 'Дозволено весь HTML',
    'results' => 'Результати для статичних сторінок',
    'author' => 'Автор',
    'no_title_or_content' => 'Ви повинні заповнити щонайменше поля <b>Назва</b> та <b>Вміст</b>.',
    'no_such_page_logged_in' => 'Пробачте, '.$_USER['username'].'..',
    'no_such_page_anon' => 'Будь ласка, пройдіть реєстрацію..',
    'no_page_access_msg' => "Це могло бути через те, що ви не зареєструвались у системі, або не є учасником {$_CONF['site_name']}. Будь ласка, <a href=\"{$_CONF['site_url']}/users.php?mode=new\">запишіться як учасник</a> {$_CONF['site_name']} для отримання повного членського доступу",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Увага: код PHP у вашій сторінці обчислюватиметься, якщо ви ввімкнете цю опцію. Використовуйте з обережністю !!',
    'exit_msg' => 'Тип виходу: ',
    'exit_info' => 'Увімкніть для повідомлення про необхідність реєстрації. Залишіть невідміченим для звичайної перевірки безпеки й повідомлення.',
    'deny_msg' => 'В доступі до цієї сторінки відмовлено. Або сторінку перемістили/вилучили, або ж у вас недостатньо для цього дозволів.',
    'stats_headline' => 'Десятка найпопулярніших статичних сторінок',
    'stats_page_title' => 'Назва сторінки',
    'stats_hits' => 'Звернень',
    'stats_no_hits' => 'Схоже, статичних сторінок на цьому сайті немає, або ж ніхто їх не переглядав.',
    'id' => 'Ідентифікатор',
    'duplicate_id' => 'Ви обрали для цієї статичної сторінки ідентифікатор, що вже використовується. Будь ласка, виберіть якийсь інакший.',
    'instructions' => 'Для виправлення чи вилучення статичної сторінки клацніть нижче на її номері. Для перегляду статичної сторінки клацніть на її назві. Для створення сторінки клацніть &laquo;Нова сторінка&raquo; вище. Клацніть [C] для створення копії вже наявної сторінки.',
    'centerblock' => 'Центральний блок: ',
    'centerblock_msg' => 'Якщо відмітити, ця статична сторінка показуватиметься як центральний блок на головній сторінці.',
    'topic' => 'Тема: ',
    'position' => 'Розташування: ',
    'all_topics' => 'Всі',
    'no_topic' => 'Лише домівка',
    'position_top' => 'Верхівка сторінки',
    'position_feat' => 'Після вираної статті',
    'position_bottom' => 'Низ сторінки',
    'position_entire' => 'Вся сторінка',
    'head_centerblock' => 'Центральний блок',
    'centerblock_no' => 'Немає',
    'centerblock_top' => 'Верхівка',
    'centerblock_feat' => 'Вибрана стаття',
    'centerblock_bottom' => 'Низ',
    'centerblock_entire' => 'Ціла сторінка',
    'inblock_msg' => 'В блоці: ',
    'inblock_info' => 'Загорнути статичну сторінку в блок.',
    'title_edit' => 'Виправити сторінку',
    'title_copy' => 'Зробити копію цієї сторінки',
    'title_display' => 'Показувати сторінку',
    'select_php_none' => 'не виконувати PHP',
    'select_php_return' => 'виконати PHP (з поверненням)',
    'select_php_free' => 'виконати PHP',
    'php_not_activated' => 'Використання PHP на статичних сторінках не активовано. За подробицями дивіться, будь ласка, <a href="' . $_CONF['site_url'] . '/docs/staticpages.html#php">документацію</a>.',
    'printable_format' => 'Формат для друку',
    'edit' => 'Edit',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit'
);

?>
