<?php

/**
 * File: ukrainian.php
 * This is the Ukrainian language page for the Geeklog Spam-X Plug-in!
 * 
 * Copyright (C) 2006 by Vitaliy Biliyenko
 * v.lokki@gmail.com
 * 
 * Licensed under GNU General Public License
 *
 * $Id: ukrainian.php,v 1.7 2008/05/02 15:08:10 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Якщо ви зробите це, тоді інші ',
    'inst2' => 'зможуть переглядати та імпортувати ваш чорний список і ми зможемо створити біль ефективну ',
    'inst3' => 'розподілену базу даних.</p><p>Якщо ви додали свій вебсайт, але більше не хочете, щоб він залишався у списку, ',
    'inst4' => 'надішліть електронного листа <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> щоб розповісти мені. ',
    'inst5' => 'Всі запити буде враховано.',
    'submit' => 'Надіслати',
    'subthis' => 'цю інформацію до центральної бази даних Spam-X',
    'secbut' => 'Ця друга кнопка створює стрічку RDF, щоб інші могли імпортувати ваш список.',
    'sitename' => 'Назва сайту: ',
    'URL' => 'URL списку Spam-X: ',
    'RDF' => 'RDF url: ',
    'impinst1a' => 'Перш ніж використовувати засіб Spam-X comment Spam blocker щоб переглядати та імпортувати персональні чорні списки з інших',
    'impinst1b' => ' сайтів, я прошу вас натиснути наступні дві кнопки. (На останню ви повинні натиснути.)',
    'impinst2' => 'Перша додасть ваш сайт до сайту Gplugs/Spam-X для ведення мастер-списку ',
    'impinst2a' => 'сайтів, що поділяють свої чорні списки. (Увага: якщо у вас є кілька сайтів, ви можете обрати один як ',
    'impinst2b' => 'головний і надати лише його. Це дозволить вам легко оновлювати свої сайти і зменшити розмір списку.) ',
    'impinst2c' => 'Після того, як ви натиснете кнопку Надіслати, натисніть [назад] на вашому браузері, щоб повернутись сюди.',
    'impinst3' => 'Наступні дані буде передано: (виправте їх, якщо є помилки).',
    'availb' => 'Доступні чорні списки',
    'clickv' => 'Натисніть щоб переглянути чорний список',
    'clicki' => 'натисніть щоб імпортувати чорний список',
    'ok' => 'OK',
    'rsscreated' => 'Стрічку RSS створено',
    'add1' => 'Додано ',
    'add2' => ' записів з ',
    'add3' => ' чорного списку.',
    'adminc' => 'Команди адміністрування:',
    'mblack' => 'Мій чорний список:',
    'rlinks' => 'Споріднені посилання:',
    'e3' => 'Щоб додати слова з цензорного списку Geeklog, натисніть кнопку:',
    'addcen' => 'Додати цензорний список',
    'addentry' => 'Додати запис',
    'e1' => 'Щоб вилучити запис, натисніть його.',
    'e2' => 'Щоб додати запис, введіть його у полі і натисніть Додати.  Записи можуть використовувати всі регулярні вирази Perl (Perl Regular Expressions).',
    'pblack' => 'Персональний чорний список Spam-X',
    'sfseblack' => 'Spam-X SFS Email Blacklist',
    'conmod' => 'Налаштувати використання модуля Spam-X',
    'acmod' => 'Модулі дії Spam-X',
    'exmod' => 'Модулі аналізу Spam-X',
    'actmod' => 'Активні модулі',
    'avmod' => 'Доступні модулі',
    'coninst' => '<hr' . XHTML . '>Натисніть активний модуль, щоб прибрати його, натисніть доступний модуль, щоб додати його.<br' . XHTML . '>Модулі виконуються саме в такому порядку.',
    'fsc' => 'Знайдено збіг Spam-коментар ',
    'fsc1' => ' написаний користувачем ',
    'fsc2' => ' з IP-адреси ',
    'uMTlist' => 'Оновити MT-Blacklist',
    'uMTlist2' => ': Додано ',
    'uMTlist3' => ' записів і вилучено ',
    'entries' => ' записів.',
    'uPlist' => 'Оновити персональний чорний список',
    'entriesadded' => 'Записи додано',
    'entriesdeleted' => 'Записи вилучено',
    'viewlog' => 'Переглянути лог Spam-X',
    'clearlog' => 'Очистити лог',
    'logcleared' => '- лог-файл Spam-X очищено',
    'plugin' => 'Модуль',
    'access_denied' => 'Доступ заборонено',
    'access_denied_msg' => 'Лише Кореневі користувачі мають доступ до цієї сторінки.  Ваш логін та IP-адресу записано.',
    'admin' => 'Адміністрування модулів',
    'install_header' => 'Встановити/Вилучити модуль',
    'installed' => 'Модуль встановлено',
    'uninstalled' => 'Модуль не встановлено',
    'install_success' => 'Інсталяція успішна',
    'install_failed' => 'Інсталяція невдала -- перегляньте error.log щодо деталей.',
    'uninstall_msg' => 'Модуль успішно вилучено',
    'install' => 'Встановити',
    'uninstall' => 'Вилучити',
    'warning' => 'Увага! Модуль все ще увімкнено',
    'enabled' => 'Вимкніть модуль перед вилученням.',
    'readme' => 'СТОП! Перш ніж почати інсталяцію прочитайте ',
    'installdoc' => ' документ Install.',
    'spamdeleted' => 'Вилучено Spam-коментар',
    'foundspam' => 'Знайдено збіг Spam-коментар ',
    'foundspam2' => ' написаний користувачем ',
    'foundspam3' => ' з IP-адреси ',
    'deletespam' => 'Вилучити Spam',
    'numtocheck' => 'Кількість коментарів для перевірки',
    'note1' => '<p>Увага: Засіб Масове Вилучення може допомогти вам, якщо ви стали жертвою',
    'note2' => ' спаму коментарів і Spam-X не перехоплює його.  <ul><li>Спочатку знайдіть посилання чи інші ',
    'note3' => 'показники цього спам-коментаря і додайте їх до вашого чорного списку.</li><li>Далі ',
    'note4' => 'поверніться сюди і дайте Spam-X перевірити останні коментарі на спам.</li></ul><p>Коментарі ',
    'note5' => 'перевіряються від новіших до старіших -- перевірка більшої кількості коментарів ',
    'note6' => 'вимагає більше часу.</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Масове Вилучення Spam-коментарів</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Масове Вилучення трекбек-спаму</h1>',
    'comdel' => ' коментарів вилучено.',
    'initial_Pimport' => '<p>Імпорт чорного списку"',
    'initial_import' => 'Початковий імпорт MT-Blacklist',
    'import_success' => '<p>Успішно імпортовано %d записів чорного списку.',
    'import_failure' => '<p><strong>Помилка:</strong> Не знайдено записів.',
    'allow_url_fopen' => '<p>Вибачте, конфігурація вашого вебсервера не дозволяє читати віддалені файли (<code>allow_url_fopen</code> має значення off). Будь-ласка, завантажте чорний список з наступного URL і помістіть його в каталог "data" вашого Geeklog, <tt>%s</tt>, перш ніж пробувати знову:',
    'documentation' => 'Документація модуля Spam-X',
    'emailmsg' => "Новий спам-пост було надіслано на \"%s\"\nUID користувача: \"%s\"\n\nЗміст:\"%s\"",
    'emailsubject' => 'Спам-пост на %s',
    'ipblack' => 'Чорний список IP Spam-X',
    'ipofurlblack' => 'Чорний список IP з URL Spam-X',
    'headerblack' => 'Чорний список HTTP-заголовків Spam-X',
    'headers' => 'Заголовки запиту:',
    'stats_headline' => 'Статистика Spam-X',
    'stats_page_title' => 'Чорний список',
    'stats_entries' => 'Записи',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'Персональний чорний список',
    'stats_ip' => 'Заблоковані IP-адреси',
    'stats_ipofurl' => 'Заблоковано за IP з URL',
    'stats_header' => 'HTTP-заголовки',
    'stats_deleted' => 'Пости, вилучені як спам',
    'invalid_email_or_ip' => 'Invalid e-mail address or IP address has been blocked.',
    'email_ip_spam' => '%s or %s attempted to register but was considered a spammer.',
    'edit_personal_blacklist' => 'Edit Personal Blacklist',
    'mass_delete_spam_comments' => 'Mass Delete Spam Comments',
    'mass_delete_trackback_spam' => 'Mass Delete Trackback Spam',
    'edit_http_header_blacklist' => 'Edit HTTP Header Blacklist',
    'edit_ip_blacklist' => 'Edit IP Blacklist',
    'edit_ip_url_blacklist' => 'Edit IP of URL Blacklist',
    'edit_sfs_blacklist' => 'Edit SFS Email Blacklist',
    'edit_slv_whitelist' => 'Edit SLV Whitelist',
    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'Білий список SLV'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'Знайдено спам, коментар чи повідомлення вилучено.';
$PLG_spamx_MESSAGE8 = 'Знайдено спам. Адміністратору надіслано електронного листа.';

// Messages for the plugin upgrade
$PLG_spamx_MESSAGE3001 = 'Plugin upgrade not supported.';
$PLG_spamx_MESSAGE3002 = $LANG32[9];

// Localization of the Admin Configuration UI
$LANG_configsections['spamx'] = array(
    'label' => 'Spam-X',
    'title' => 'Spam-X Configuration'
);

$LANG_confignames['spamx'] = array(
    'spamx_action' => 'Spam-X Actions',
    'notification_email' => 'Notification Email',
    'logging' => 'Enable Logging',
    'timeout' => 'Timeout',
    'sfs_enabled' => 'Enable SFS',
    'snl_enabled' => 'Enable SNL',
    'snl_num_links' => 'Number of links'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X Main Settings',
    'tab_modules' => 'Modules'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X Main Settings',
    'fs_sfs' => 'Stop Forum Spam (SFS)',
    'fs_snl' => 'Spam Number of Links (SNL)'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false)
);

?>
