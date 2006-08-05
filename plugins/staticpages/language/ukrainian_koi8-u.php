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
    'newpage' => 'Нова стор╕нка',
    'adminhome' => 'Дом╕вка адм╕н╕стратора',
    'staticpages' => 'Статичн╕ стор╕нки',
    'staticpageeditor' => 'Редактор статичних стор╕нок',
    'writtenby' => 'Написав(-ла)',
    'date' => 'Востанн╓ поновлено',
    'title' => 'Назва',
    'content' => 'Вм╕ст',
    'hits' => 'Звертань',
    'staticpagelist' => 'Перел╕к статичних стор╕нок',
    'url' => 'URL',
    'edit' => 'Редагувати',
    'lastupdated' => 'Востанн╓ поновлено',
    'pageformat' => 'Формат стор╕нки',
    'leftrightblocks' => 'Л╕вий та правий блоки',
    'blankpage' => 'Чиста стор╕нка',
    'noblocks' => 'Без блок╕в',
    'leftblocks' => 'Блоки л╕воруч',
    'addtomenu' => 'Додати до меню',
    'label' => 'М╕тка',
    'nopages' => 'В систем╕ ще нема╓ статичних стор╕нок',
    'save' => 'зберегти',
    'preview' => 'попередн╕й перегляд',
    'delete' => 'вилучити',
    'cancel' => 'скасувати',
    'access_denied' => 'В доступ╕ в╕дмовлено',
    'access_denied_msg' => 'Ви намага╓тесь незаконно отримати доступ до стор╕нок адм╕н╕стрування статичних стор╕нок. Будь ласка, зауважте, що вс╕ так╕ спроби протоколюються',
    'all_html_allowed' => 'Дозволено весь HTML',
    'results' => 'Результати для статичних стор╕нок',
    'author' => 'Автор',
    'no_title_or_content' => 'Ви повинн╕ заповнити щонайменше поля <b>Назва</b> та <b>Вм╕ст</b>.',
    'no_such_page_anon' => 'Будь ласка, пройд╕ть ре╓страц╕ю..',
    'no_page_access_msg' => "Це могло бути через те, що ви не заре╓струвались у систем╕, або не ╓ учасником {$_CONF['site_name']}. Будь ласка, <a href=\"{$_CONF['site_url']}/users.php?mode=new\">запиш╕ться як учасник</a> {$_CONF['site_name']} для отримання повного членського доступу",
    'php_msg' => 'PHP: ',
    'php_warn' => 'Увага: код PHP у ваш╕й стор╕нц╕ обчислюватиметься, якщо ви вв╕мкнете цю опц╕ю. Використовуйте з обережн╕стю !!',
    'exit_msg' => 'Тип виходу: ',
    'exit_info' => 'Ув╕мкн╕ть для пов╕домлення про необх╕дн╕сть ре╓страц╕╖. Залиш╕ть нев╕дм╕ченим для звичайно╖ перев╕рки безпеки й пов╕домлення.',
    'deny_msg' => 'В доступ╕ до ц╕╓╖ стор╕нки в╕дмовлено. Або стор╕нку перем╕стили/вилучили, або ж у вас недостатньо для цього дозвол╕в.',
    'stats_headline' => 'Десятка найпопулярн╕ших статичних стор╕нок',
    'stats_page_title' => 'Назва стор╕нки',
    'stats_hits' => 'Звернень',
    'stats_no_hits' => 'Схоже, статичних стор╕нок на цьому сайт╕ нема╓, або ж н╕хто ╖х не переглядав.',
    'id' => '╤дентиф╕катор',
    'duplicate_id' => 'Ви обрали для ц╕╓╖ статично╖ стор╕нки ╕дентиф╕катор, що вже використову╓ться. Будь ласка, вибер╕ть якийсь ╕накший.',
    'instructions' => 'Для виправлення чи вилучення статично╖ стор╕нки клацн╕ть нижче на ╖╖ номер╕. Для перегляду статично╖ стор╕нки клацн╕ть на ╖╖ назв╕. Для створення стор╕нки клацн╕ть &laquo;Нова стор╕нка&raquo; вище. Клацн╕ть [C] для створення коп╕╖ вже наявно╖ стор╕нки.',
    'centerblock' => 'Центральний блок: ',
    'centerblock_msg' => 'Якщо в╕дм╕тити, ця статична стор╕нка показуватиметься як центральний блок на головн╕й стор╕нц╕.',
    'topic' => 'Тема: ',
    'position' => 'Розташування: ',
    'all_topics' => 'Вс╕',
    'no_topic' => 'Лише дом╕вка',
    'position_top' => 'Верх╕вка стор╕нки',
    'position_feat' => 'П╕сля вирано╖ статт╕',
    'position_bottom' => 'Низ стор╕нки',
    'position_entire' => 'Вся стор╕нка',
    'head_centerblock' => 'Центральний блок',
    'centerblock_no' => 'Нема╓',
    'centerblock_top' => 'Верх╕вка',
    'centerblock_feat' => 'Вибрана стаття',
    'centerblock_bottom' => 'Низ',
    'centerblock_entire' => 'Ц╕ла стор╕нка',
    'inblock_msg' => 'В блоц╕: ',
    'inblock_info' => 'Загорнути статичну стор╕нку в блок.',
    'title_edit' => 'Виправити стор╕нку',
    'title_copy' => 'Зробити коп╕ю ц╕╓╖ стор╕нки',
    'title_display' => 'Показувати стор╕нку',
    'select_php_none' => 'не виконувати PHP',
    'select_php_return' => 'виконати PHP (з поверненням)',
    'select_php_free' => 'виконати PHP',
    'php_not_activated' => 'Використання PHP на статичних стор╕нках не активовано. За подробицями див╕ться, будь ласка, <a href="' . $_CONF['site_url'] . '/docs/staticpages.html#php">документац╕ю</a>.',
    'printable_format' => 'Формат для друку',
    'edit' => 'Edit',
    'copy' => 'Copy',
    'limit_results' => 'Limit Results',
    'search' => 'Search',
    'submit' => 'Submit'
);

// Messages for the plugin upgrade
$PLG_staticpages_MESSAGE3002 = $LANG32[9];

?>
