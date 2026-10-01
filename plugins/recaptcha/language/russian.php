<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/russian.php                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014-2020 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Based on the CAPTCHA Plugin by Ben                                        |
// |                                                - ben AT geeklog DOT fr    |
// | Based on the original CAPTCHA Plugin by Mark R. Evans                     |
// |                                                - mark AT glfusion DOT org |
// | Constructed with the Universal Plugin                                     |
// +---------------------------------------------------------------------------|
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software               |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA|
// |                                                                           |
// +---------------------------------------------------------------------------+

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own!');
}

$LANG_RECAPTCHA = [
    'plugin'      => 'reCAPTCHA',
    'admin'       => 'reCAPTCHA',
    'msg_error'   => 'Ошибка: проверка reCAPTCHA не пройдена.',
    'entry_error' => 'В %1s введена недопустимая строка reCAPTCHA - IP-адрес: %2s - Коды ошибок: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'Настройка reCAPTCHA',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'Ключ сайта reCAPTCHA V2',
    'secret_key'           => 'Секретный ключ reCAPTCHA V2',
    'invisible_site_key'   => 'Ключ сайта невидимой reCAPTCHA',
    'invisible_secret_key' => 'Секретный ключ невидимой reCAPTCHA',
    'site_key_v3'          => 'Ключ сайта reCAPTCHA V3',
    'secret_key_v3'        => 'Секретный ключ reCAPTCHA V3',
    'logging'              => 'Записывать недопустимые попытки reCAPTCHA',
    'anonymous_only'       => 'Только анонимные пользователи',
    'remoteusers'          => 'Принудительно использовать reCAPTCHA для всех удалённых пользователей',
    'enable_comment'       => 'Включить защиту комментариев',
    'enable_contact'       => 'Включить защиту формы контактов',
    'enable_emailstory'    => 'Включить защиту отправки статьи по электронной почте',
    'enable_registration'  => 'Включить защиту регистрации',
    'enable_loginform'     => 'Включить защиту формы входа',
    'enable_getpassword'   => 'Включить защиту формы восстановления пароля',
    'enable_story'         => 'Включить защиту статей',
    'score_comment'        => 'Порог оценки для комментариев',
    'score_contact'        => 'Порог оценки для формы контактов',
    'score_emailstory'     => 'Порог оценки для отправки статьи по почте',
    'score_registration'   => 'Порог оценки для регистрации',
    'score_loginform'      => 'Порог оценки для формы входа',
    'score_getpassword'    => 'Порог оценки для восстановления пароля',
    'score_story'          => 'Порог оценки для статей',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => 'Основные настройки',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'Настройки reCAPTCHA',
    'tab_integration' => 'Интеграция Geeklog',
    'tab_score'       => 'Пороги оценки',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'Система',
    'fs_integration' => 'Интеграция Geeklog',
    'fs_score'       => 'Пороги оценки',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['Да' => 1, 'Нет' => 0],
    2 => ['Отключено' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4],
];
