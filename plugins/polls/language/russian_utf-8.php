<?php

###############################################################################
# russian_utf-8.php
# This is the russian language file for the Geeklog Polls plugin
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
# $LANGXX[YY]:  $LANG - variable name
#               XX    - file id number
#               YY    - phrase id number
###############################################################################

$LANG_POLLS = array(
    'polls' => 'Опросы',
    'poll' => 'Опрос',
    'results' => 'Результаты',
    'pollresults' => 'Результаты опроса',
    'votes' => 'голосов',
    'voters' => 'проголосовавшие',
    'vote' => 'Голосовать',
    'pastpolls' => 'Прошлые опросы',
    'savedvotetitle' => 'Голос сохранено',
    'savedvotemsg' => 'Ваш голос в опросе был учтён',
    'pollstitle' => 'Опросы',
    'polltopics' => 'Другие опросы',
    'stats_top10' => '10 популярнейших опросов',
    'stats_topics' => 'Тема опроса',
    'stats_votes' => 'ГОлосов',
    'stats_none' => 'На этом сайте нет опросов, или ещё никто в них не голосовал.',
    'stats_summary' => 'Опросов (Голосов) в системе',
    'open_poll' => 'Открытый для голосования',
    'answer_all' => 'Ответьте на все оставшиеся вопросы',
    'not_saved' => 'Результат не сохранён',
    'upgrade1' => 'Вы установили новую версию плагина Polls. Пожалуйста',
    'upgrade2' => 'обновите',
    'editinstructions' => 'Укажите ID опроса, хотя бы один вопрос и два варианта ответа.',
    'pollclosed' => 'Этот опрос закрыт для голосования.',
    'pollhidden' => 'Вы уже проголосовали. Результаты будут показаны после завершения голосования.',
    'start_poll' => 'Начать опрос',
    'no_new_polls' => 'Нет новых опросов',
    'autotag_desc_poll' => '[poll: id альтернативный заголовок] — показывает ссылку на опрос, используя его тему как заголовок. Альтернативный заголовок необязателен.',
    'autotag_desc_poll_vote' => '[poll_vote: id class:poll-autotag showall:1] — показывает опрос для голосования. class и showall необязательны. class задаёт CSS-класс, showall:1 показывает все вопросы.',
    'autotag_desc_poll_result' => '[poll_result: id class:poll-autotag] — показывает результаты опроса. class необязателен и задаёт CSS-класс.',
    'deny_msg' => 'Доступ к этому опросу запрещён. Возможно, опрос был перемещён или удалён, либо у вас недостаточно прав.'
);

###############################################################################
# admin/plugins/polls/index.php

$LANG25 = array(
    1 => 'Режим',
    2 => 'Введите тему, хотя бы один вопрос и один вариант ответа.',
    3 => 'Опрос создан',
    4 => 'Опрос %s сохранён',
    5 => 'Редактировать опрос',
    6 => 'ID опроса',
    7 => '(без пробелов)',
    8 => 'Показывать в блоке опросов',
    9 => 'Тема',
    10 => 'Ответы / Голоса / Примечание',
    11 => 'Ошибка получения данных ответов для опроса %s',
    12 => 'Ошибка получения данных вопросов для опроса %s',
    13 => 'Создать опрос',
    14 => 'сохранить',
    15 => 'отмена',
    16 => 'удалить',
    17 => 'Введите ID опроса',
    18 => 'Список опросов',
    19 => 'Чтобы изменить или удалить опрос, нажмите значок редактирования. Для создания нового опроса нажмите «Создать новый».',
    20 => 'Проголосовавшие',
    21 => 'Доступ запрещён',
    22 => "Вы пытаетесь открыть опрос, к которому у вас нет доступа. Эта попытка зарегистрирована. <a href=\"{$_CONF['site_admin_url']}/poll.php\">Вернуться к администрированию опросов</a>.",
    23 => 'Новый опрос',
    24 => 'Главная администратора',
    25 => 'Да',
    26 => 'Нет',
    27 => 'Редактировать',
    28 => 'Отправить',
    29 => 'Поиск',
    30 => 'Ограничить результаты',
    31 => 'Вопрос',
    32 => 'Чтобы удалить вопрос из опроса, удалите его текст',
    33 => 'Открыт для голосования',
    34 => 'Тема опроса:',
    35 => 'В этом опросе',
    36 => 'дополнительных вопросов.',
    37 => 'Скрывать результаты, пока опрос открыт',
    38 => 'Пока опрос открыт, результаты видны только владельцу и root',
    39 => 'Тема будет показана только если вопросов больше одного.',
    40 => 'Показать все ответы этого опроса',
    1001 => 'Разрешить несколько ответов',
    1002 => 'Описание',
    1003 => 'Описание'
);

$PLG_polls_MESSAGE15 = 'Ваш комментарий отправлен на проверку и будет опубликован после одобрения модератором.';
$PLG_polls_MESSAGE19 = 'Ваш опрос успешно сохранён.';
$PLG_polls_MESSAGE20 = 'Your poll has been successfully deleted.';

// Messages for the plugin upgrade
$PLG_polls_MESSAGE3001 = 'Обновление плагина не поддерживается.';
$PLG_polls_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['polls'] = array(
    'label' => 'Polls',
    'title' => 'Polls Configuration'
);

$LANG_confignames['polls'] = array(
    'pollsloginrequired' => 'Polls Login Required?',
    'hidepollsmenu' => 'Hide Polls Menu Entry?',
    'maxquestions' => 'Max. Questions per Poll',
    'maxanswers' => 'Max. Options per Question',
    'answerorder' => 'Sort Results ...',
    'pollcookietime' => 'Voter Cookie valid for',
    'polladdresstime' => 'Voter IP Address valid for',
    'delete_polls' => 'Delete Polls with Owner?',
    'aftersave' => 'After Saving Poll',
    'default_permissions' => 'Poll Default Permissions',
    'autotag_permissions_poll' => '[poll: ] Permissions',
    'autotag_permissions_poll_vote' => '[poll_vote: ] Permissions',
    'autotag_permissions_poll_result' => '[poll_result: ] Permissions',
    'newpollsinterval' => 'New Polls Interval',
    'hidenewpolls' => 'New Polls',
    'title_trim_length' => 'Title Trim Length',
    'meta_tags' => 'Enable Meta Tags',
    'likes_polls' => 'Poll Likes',
    'block_enable' => 'Enabled',
    'block_isleft' => 'Display Block on Left',
    'block_order' => 'Block Order',
    'block_topic_option' => 'Topic Options',
    'block_topic' => 'Тема',
    'block_group_id' => 'Group',
    'block_permissions' => 'Permissions'
);

$LANG_configsubgroups['polls'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['polls'] = array(
    'tab_main' => 'General Polls Settings',
    'tab_whatsnew' => 'What\'s New Block',
    'tab_permissions' => 'Default Permissions',
    'tab_autotag_permissions' => 'Autotag Usage Permissions',
    'tab_poll_block' => 'Poll Block'
);

$LANG_fs['polls'] = array(
    'fs_main' => 'General Polls Settings',
    'fs_whatsnew' => 'What\'s New Block',
    'fs_permissions' => 'Default Permissions',
    'fs_autotag_permissions' => 'Autotag Usage Permissions',
    'fs_block_settings' => 'Block Settings',
    'fs_block_permissions' => 'Block Permissions'
);

// Note: entries 0, 1, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['polls'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false),
    2 => array('As Submitted' => 'submitorder', 'By Votes' => 'voteorder'),
    5 => array('Hide' => 'hide', 'Show - Use Modified Date' => 'modified', 'Show - Use Created Date' => 'created'),
    9 => array('Forward to Poll' => 'item', 'Display Admin List' => 'list', 'Display Public List' => 'plugin', 'Display Home' => 'home', 'Display Admin' => 'admin'),
    12 => array('No access' => 0, 'Read-Only' => 2, 'Read-Write' => 3),
    13 => array('No access' => 0, 'Use' => 2),
    14 => array('No access' => 0, 'Read-Only' => 2),
    15 => array('All' => 'all', 'Homepage Only' => 'homeonly', 'Select Topics' => 'selectedtopics'),
    41 => array('False' => 0, 'Likes and Dislikes' => 1, 'Likes Only' => 2)
);
