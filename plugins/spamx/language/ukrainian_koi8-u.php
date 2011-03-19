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
 * $Id: ukrainian_koi8-u.php,v 1.8 2008/05/02 15:08:10 dhaun Exp $
 */

global $LANG32;

$LANG_SX00 = array(
    'inst1' => '<p>Якщо ви зробите це, тод╕ ╕нш╕ ',
    'inst2' => 'зможуть переглядати та ╕мпортувати ваш чорний список ╕ ми зможемо створити б╕ль ефективну ',
    'inst3' => 'розпод╕лену базу даних.</p><p>Якщо ви додали св╕й вебсайт, але б╕льше не хочете, щоб в╕н залишався у списку, ',
    'inst4' => 'над╕шл╕ть електронного листа <a href="mailto:spamx@pigstye.net">spamx@pigstye.net</a> щоб розпов╕сти мен╕. ',
    'inst5' => 'Вс╕ запити буде враховано.',
    'submit' => 'Над╕слати',
    'subthis' => 'цю ╕нформац╕ю до центрально╖ бази даних Spam-X',
    'secbut' => 'Ця друга кнопка створю╓ стр╕чку RDF, щоб ╕нш╕ могли ╕мпортувати ваш список.',
    'sitename' => 'Назва сайту: ',
    'URL' => 'URL списку Spam-X: ',
    'RDF' => 'RDF url: ',
    'impinst1a' => 'Перш н╕ж використовувати зас╕б Spam-X comment Spam blocker щоб переглядати та ╕мпортувати персональн╕ чорн╕ списки з ╕нших',
    'impinst1b' => ' сайт╕в, я прошу вас натиснути наступн╕ дв╕ кнопки. (На останню ви повинн╕ натиснути.)',
    'impinst2' => 'Перша додасть ваш сайт до сайту Gplugs/Spam-X для ведення мастер-списку ',
    'impinst2a' => 'сайт╕в, що под╕ляють сво╖ чорн╕ списки. (Увага: якщо у вас ╓ к╕лька сайт╕в, ви можете обрати один як ',
    'impinst2b' => 'головний ╕ надати лише його. Це дозволить вам легко оновлювати сво╖ сайти ╕ зменшити розм╕р списку.) ',
    'impinst2c' => 'П╕сля того, як ви натиснете кнопку Над╕слати, натисн╕ть [назад] на вашому браузер╕, щоб повернутись сюди.',
    'impinst3' => 'Наступн╕ дан╕ буде передано: (виправте ╖х, якщо ╓ помилки).',
    'availb' => 'Доступн╕ чорн╕ списки',
    'clickv' => 'Натисн╕ть щоб переглянути чорний список',
    'clicki' => 'натисн╕ть щоб ╕мпортувати чорний список',
    'ok' => 'OK',
    'rsscreated' => 'Стр╕чку RSS створено',
    'add1' => 'Додано ',
    'add2' => ' запис╕в з ',
    'add3' => ' чорного списку.',
    'adminc' => 'Команди адм╕н╕стрування:',
    'mblack' => 'М╕й чорний список:',
    'rlinks' => 'Спор╕днен╕ посилання:',
    'e3' => 'Щоб додати слова з цензорного списку Geeklog, натисн╕ть кнопку:',
    'addcen' => 'Додати цензорний список',
    'addentry' => 'Додати запис',
    'e1' => 'Щоб вилучити запис, натисн╕ть його.',
    'e2' => 'Щоб додати запис, введ╕ть його у пол╕ ╕ натисн╕ть Додати.  Записи можуть використовувати вс╕ регулярн╕ вирази Perl (Perl Regular Expressions).',
    'pblack' => 'Персональний чорний список Spam-X',
    'conmod' => 'Налаштувати використання модуля Spam-X',
    'acmod' => 'Модул╕ д╕╖ Spam-X',
    'exmod' => 'Модул╕ анал╕зу Spam-X',
    'actmod' => 'Активн╕ модул╕',
    'avmod' => 'Доступн╕ модул╕',
    'coninst' => '<hr' . XHTML . '>Натисн╕ть активний модуль, щоб прибрати його, натисн╕ть доступний модуль, щоб додати його.<br' . XHTML . '>Модул╕ виконуються саме в такому порядку.',
    'fsc' => 'Знайдено зб╕г Spam-коментар ',
    'fsc1' => ' написаний користувачем ',
    'fsc2' => ' з IP-адреси ',
    'uMTlist' => 'Оновити MT-Blacklist',
    'uMTlist2' => ': Додано ',
    'uMTlist3' => ' запис╕в ╕ вилучено ',
    'entries' => ' запис╕в.',
    'uPlist' => 'Оновити персональний чорний список',
    'entriesadded' => 'Записи додано',
    'entriesdeleted' => 'Записи вилучено',
    'viewlog' => 'Переглянути лог Spam-X',
    'clearlog' => 'Очистити лог',
    'logcleared' => '- лог-файл Spam-X очищено',
    'plugin' => 'Модуль',
    'access_denied' => 'Доступ заборонено',
    'access_denied_msg' => 'Лише Коренев╕ користувач╕ мають доступ до ц╕╓╖ стор╕нки.  Ваш лог╕н та IP-адресу записано.',
    'admin' => 'Адм╕н╕стрування модул╕в',
    'install_header' => 'Встановити/Вилучити модуль',
    'installed' => 'Модуль встановлено',
    'uninstalled' => 'Модуль не встановлено',
    'install_success' => '╤нсталяц╕я усп╕шна',
    'install_failed' => '╤нсталяц╕я невдала -- перегляньте error.log щодо деталей.',
    'uninstall_msg' => 'Модуль усп╕шно вилучено',
    'install' => 'Встановити',
    'uninstall' => 'Вилучити',
    'warning' => 'Увага! Модуль все ще ув╕мкнено',
    'enabled' => 'Вимкн╕ть модуль перед вилученням.',
    'readme' => 'СТОП! Перш н╕ж почати ╕нсталяц╕ю прочитайте ',
    'installdoc' => ' документ Install.',
    'spamdeleted' => 'Вилучено Spam-коментар',
    'foundspam' => 'Знайдено зб╕г Spam-коментар ',
    'foundspam2' => ' написаний користувачем ',
    'foundspam3' => ' з IP-адреси ',
    'deletespam' => 'Вилучити Spam',
    'numtocheck' => 'К╕льк╕сть коментар╕в для перев╕рки',
    'note1' => '<p>Увага: Зас╕б Масове Вилучення може допомогти вам, якщо ви стали жертвою',
    'note2' => ' спаму коментар╕в ╕ Spam-X не перехоплю╓ його.  <ul><li>Спочатку знайд╕ть посилання чи ╕нш╕ ',
    'note3' => 'показники цього спам-коментаря ╕ додайте ╖х до вашого чорного списку.</li><li>Дал╕ ',
    'note4' => 'поверн╕ться сюди ╕ дайте Spam-X перев╕рити останн╕ коментар╕ на спам.</li></ul><p>Коментар╕ ',
    'note5' => 'перев╕ряються в╕д нов╕ших до стар╕ших -- перев╕рка б╕льшо╖ к╕лькост╕ коментар╕в ',
    'note6' => 'вимага╓ б╕льше часу.</p>',
    'masshead' => '<hr' . XHTML . '><h1 align="center">Масове Вилучення Spam-коментар╕в</h1>',
    'masstb' => '<hr' . XHTML . '><h1 align="center">Масове Вилучення трекбек-спаму</h1>',
    'comdel' => ' коментар╕в вилучено.',
    'initial_Pimport' => '<p>╤мпорт чорного списку"',
    'initial_import' => 'Початковий ╕мпорт MT-Blacklist',
    'import_success' => '<p>Усп╕шно ╕мпортовано %d запис╕в чорного списку.',
    'import_failure' => '<p><strong>Помилка:</strong> Не знайдено запис╕в.',
    'allow_url_fopen' => '<p>Вибачте, конф╕гурац╕я вашого вебсервера не дозволя╓ читати в╕ддален╕ файли (<code>allow_url_fopen</code> ма╓ значення off). Будь-ласка, завантажте чорний список з наступного URL ╕ пом╕ст╕ть його в каталог "data" вашого Geeklog, <tt>%s</tt>, перш н╕ж пробувати знову:',
    'documentation' => 'Документац╕я модуля Spam-X',
    'emailmsg' => "Новий спам-пост було над╕слано на \"%s\"\nUID користувача: \"%s\"\n\nЗм╕ст:\"%s\"",
    'emailsubject' => 'Спам-пост на %s',
    'ipblack' => 'Чорний список IP Spam-X',
    'ipofurlblack' => 'Чорний список IP з URL Spam-X',
    'headerblack' => 'Чорний список HTTP-заголовк╕в Spam-X',
    'headers' => 'Заголовки запиту:',
    'stats_headline' => 'Статистика Spam-X',
    'stats_page_title' => 'Чорний список',
    'stats_entries' => 'Записи',
    'stats_mtblacklist' => 'MT-Blacklist',
    'stats_pblacklist' => 'Персональний чорний список',
    'stats_ip' => 'Заблокован╕ IP-адреси',
    'stats_ipofurl' => 'Заблоковано за IP з URL',
    'stats_header' => 'HTTP-заголовки',
    'stats_deleted' => 'Пости, вилучен╕ як спам',
    'plugin_name' => 'Spam-X',
    'slvwhitelist' => 'Б╕лий список SLV'
);

// Define Messages that are shown when Spam-X module action is taken
$PLG_spamx_MESSAGE128 = 'Знайдено спам, коментар чи пов╕домлення вилучено.';
$PLG_spamx_MESSAGE8 = 'Знайдено спам. Адм╕н╕стратору над╕слано електронного листа.';

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
    'timeout' => 'Timeout'
);

$LANG_configsubgroups['spamx'] = array(
    'sg_main' => 'Main Settings'
);

$LANG_tab['spamx'] = array(
    'tab_main' => 'Spam-X Main Settings'
);

$LANG_fs['spamx'] = array(
    'fs_main' => 'Spam-X Main Settings'
);

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['spamx'] = array(
    0 => array('True' => 1, 'False' => 0),
    1 => array('True' => true, 'False' => false)
);

?>
