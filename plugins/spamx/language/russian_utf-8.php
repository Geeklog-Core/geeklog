<?php

/**
 * File: russian.php
 * This is the Russian UTF-8 language page for the Geeklog Spam-X Plug-in!
 * 
 * Copyright (C) 2006 by the following authors:
 * Author        Pavel Kovalenko        rumata AT dragons DOT ru
 * 
 * Licensed under GNU General Public License
 *
 * $Id: russian_utf-8.php,v 1.4 2008/05/02 15:08:10 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Если Вы это сделаете, другие ',
    'inst2' => 'смогут просматривать и импортировать Ваш черный список, что позволит создать более эффективную базу данных.',
    'inst3' => '</p><p>Если Ваш сайт был добавлен и Вы хотите удалить его из списка ',
    'inst4' => 'отправьте уведомление на адрес <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a>. ',
    'inst5' => 'Все запросы принимаются с благодарностью.',
    'submit' => 'Подписать',
    'subthis' => 'отправку информации в центральную базу Spam-X',
    'secbut' => 'Вторая кнопка создает rdf feed, предоставляя возможность импортировать Ваш список.',
    'sitename' => 'Имя сайта: ',
    'URL' => 'URL для списка Spam-X: ',
    'RDF' => 'URL RDF: ',
    'impinst1a' => 'Перед использованием Spam-X отправьте комментарий в отдел блокировки спама для просмотра и импорта других черных списков частных сайтов.',
    'impinst1b' => ' Просьба нажать следующие две кнопки. (Вы нажали последнюю.)',
    'impinst2' => 'Первая выполняет подписку Вашего сайта на сайте Gplugs/Spam-X, после чего его можно добавить в главный список ',
    'impinst2a' => 'сайтов, предоставляющих свои черные списки. (Примечание: если у Вас несколько сайтов, то возможно Вы хотите обозначить один как ',
    'impinst2b' => 'главный и вписать только его название. Это упростит обновление Ваших сайтов и список будет меньше.) ',
    'impinst2c' => 'После нажатаия кнопки \'Подписать\', кликните [назад] в Вашем броузере, чтобы вернуться сюда.',
    'impinst3' => 'Следующие данные будут отправлены: (поправьте их, если они неправильные).',
    'availb' => 'Доступные черные списки',
    'clickv' => 'Нажмите для просмотра черных списков',
    'clicki' => 'Нажмите для импорта черных списков',
    'ok' => 'OK',
    'rsscreated' => 'Созданные RSS Feed',
    'add1' => 'Добавленные ',
    'add2' => ' записи от ',
    'add3' => ' черные списки.',
    'adminc' => 'Команды:',
    'mblack' => 'Мой черный список:',
    'rlinks' => 'Похожие ссылки:',
    'e3' => 'Для добавления слов из Geeklogs CensorList нажмите кнопку:',
    'addcen' => 'Добавить список запрещенных слов',
    'addentry' => 'Добавить запись',
    'e1' => 'Для удаления записи нажмите на нее.',
    'e2' => 'Для добавления записи щелкните по ней и нажмите Добавить. Записи могут использовать полноценные регулярные выражения перл.',
    'pblack' => 'Частный список Spam-X',
    'sfseblack' => 'Чёрный список email SFS Spam-X',
    'conmod' => 'Конфигурация использования Spam-X',
    'acmod' => 'Модули действий Spam-X',
    'exmod' => 'Модули проверки Spam-X',
    'actmod' => 'Действующие модули',
    'avmod' => 'Доступные модули',
    'coninst' => '<hr' . XHTML . '>Для удаления действующего модуля нажмите на него, для добавления нажмите на доступный модуль.<br' . XHTML . '>Модули выполняются по порядку в списке.',
    'fsc' => 'Найден спам комментарий ',
    'fsc1' => ' опубликовано ',
    'fsc2' => ' с IP ',
    'uMTlist' => 'Обновить MT-Blacklist',
    'uMTlist2' => ': добавлено ',
    'uMTlist3' => ' записей и удалено ',
    'entries' => ' записей.',
    'uPlist' => 'Обновить частный черный список',
    'entriesadded' => 'Добавлено записей',
    'entriesdeleted' => 'Удалено записей',
    'viewlog' => 'Просмотр лога Spam-X',
    'clearlog' => 'Очистить файл лога',
    'logcleared' => '- лог Spam-X очищен',
    'plugin' => 'Модуль',
    'action' => 'Действие',
    'access_denied' => 'Доступ запрещен',
    'access_denied_msg' => 'Только администраторы имеют доступ к данной странице.  Ваш логин и IP адрес были зафиксированы.',
    'admin' => 'Управление модулями',
    'install_header' => 'Установить/Отменить модуль',
    'installed' => 'Модуль установлен',
    'uninstalled' => 'Модуль отменен',
    'install_success' => 'Установка прошла успешно',
    'install_failed' => 'Установка провалилась -- смотрите лог ошибок, чтобы выяснить причину.',
    'uninstall_msg' => 'Модуль успешно демонтирован',
    'install' => 'Установить',
    'uninstall' => 'Демонтировать',
    'warning' => 'Внимание! Модуль по-прежнему включен',
    'enabled' => 'Выключить модуль перед демонтажом.',
    'readme' => 'Стоп! Перед установкой внимательно прочтите',
    'installdoc' => ' описание установки.',
    'spamdeleted' => 'Удалить спам комментарий',
    'foundspam' => 'Найден спам комментарий ',
    'foundspam2' => ' опубликовано ',
    'foundspam3' => ' с IP ',
    'deletespam' => 'Удалить спам',
    'numtocheck' => 'Количество комментариев для проверки',
    'note1' => '<p>Примечание: массовое удаление применяется в случае',
    'note2' => ' если во время атаки спам комментариев Spam-X не сработал.  <ul><li>Сначала поищите ссылки на аналогичные идентификации этого спама ',
    'note3' => 'и добавьте в свой черный список.</li><li>Далее ',
    'note4' => 'вернитесь и с помощью Spam-X проверьте последние комментарии.</li></ul>Комментарии ',
    'note5' => 'проверены от самых новых до самых старых -- дальнейшая проверка ',
    'note6' => 'требует большего времени.</p>',
    'masshead' => 'Массовое удаление спам-комментариев',
    'masstb' => 'Массовое удаление спама Trackback',
    'comdel' => ' комментариев удалено.',
    'initial_Pimport' => '<p>импорт черного списка"',
    'initial_import' => 'Начальный импорт MT-Blacklist',
    'import_success' => '<p>Успешно импортировано %d записей черного списка.',
    'import_failure' => '<p><strong>Ошибка:</strong> Записей не найдено.',
    'allow_url_fopen' => '<p>Извините, конфигурация Вашего вебсервера не допускает чтения удаленных файлов, опция (<code>allow_url_fopen</code> выключена). Загрузите список со следующего URL и выгрузите его в каталог данных, <span style="font-family: monospace;">%s</span>, прежде чем попробовать повторить попытку:',
    'documentation' => 'Документация модуля Spam-X',
    'emailmsg' => "Новый спам был записан в \"%s\"\nUID пользователя: \"%s\"\n\nСодержание:\"%s\"",
    'emailsubject' => 'Спам в %s',
    'ipblack' => 'Список Spam-X IP',
    'ipofurlblack' => 'Список Spam-X IP или URL',
    'headerblack' => 'Список Spam-X заголовков HTTP',
    'headers' => 'Запрашиваемые заголовки:',
    'edit' => 'Изменить',
    'view' => 'Просмотр',
    'value' => 'Значение',
    'counter' => 'Счётчик',
    'stats_headline' => 'Статистика Spam-X',
    'stats_page_title' => 'Черный список',
    'stats_entries' => 'Записи',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'Персональный черный список',
    'stats_ip' => 'Заблокированные IP',
    'stats_ipofurl' => 'Блокировка IP или URL',
    'stats_header' => 'Заголовки HTTP',
    'stats_deleted' => 'Сообщения удалены как спам',
    'invalid_email_or_ip' => 'Недопустимый адрес электронной почты или IP-адрес был заблокирован.',
    'email_ip_spam' => '%s или %s пытался зарегистрироваться, но был признан спамером.',
    'edit_personal_blacklist' => 'Изменить личный чёрный список',
    'mass_delete_spam_comments' => 'Массовое удаление спам-комментариев',
    'mass_delete_trackback_spam' => 'Массовое удаление спам-трекбеков',
    'edit_http_header_blacklist' => 'Изменить чёрный список HTTP-заголовков',
    'edit_ip_blacklist' => 'Изменить чёрный список IP',
    'edit_ip_url_blacklist' => 'Изменить чёрный список IP URL',
    'edit_sfs_blacklist' => 'Изменить чёрный список email SFS',
    'edit_slv_whitelist' => 'Изменить белый список SLV',
    'plugin_name' => 'Spam-X'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'Обнаружен спам и сообщение или комментарий удалены.';
$PLG_spamx_MESSAGE8 = 'Обнаружен спам. Администратору отправлено уведомление.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Обновление плагина не поддерживается.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Настройка Spam-X'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Действия Spam-X',
    'notification_email' => 'Email для уведомлений',
    'logging' => 'Включить журналирование',
    'timeout' => 'Тайм-аут',
    'max_age' => 'Максимальный возраст записей',
    'records_delete' => 'Типы записей для удаления',
    'sfs_enabled' => 'Включить SFS',
    'sfs_confidence' => 'Порог доверия',
    'snl_enabled' => 'Включить SNL',
    'snl_num_links' => 'Количество ссылок',
    'akismet_enabled' => 'Включить Akismet',
    'akismet_api_key' => 'Ключ API'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Основные настройки'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Основные настройки Spam-X',
    'tab_modules' => 'Модули'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Основные настройки Spam-X',
    'fs_sfs' => 'Stop Forum Spam (SFS)',
    'fs_snl' => 'Количество спам-ссылок (SNL)',
    'fs_akismet' => 'Akismet'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false)
);
