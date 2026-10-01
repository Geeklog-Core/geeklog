<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/spanish_utf-8.php                   |
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
    'msg_error'   => 'Error: la validación de reCAPTCHA no fue válida.',
    'entry_error' => 'Se introdujo una cadena reCAPTCHA no válida en %1s - Dirección IP: %2s - Códigos de error: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'Configuración de reCAPTCHA',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'Clave de sitio reCAPTCHA V2',
    'secret_key'           => 'Clave secreta reCAPTCHA V2',
    'invisible_site_key'   => 'Clave de sitio de reCAPTCHA invisible',
    'invisible_secret_key' => 'Clave secreta de reCAPTCHA invisible',
    'site_key_v3'          => 'Clave de sitio reCAPTCHA V3',
    'secret_key_v3'        => 'Clave secreta reCAPTCHA V3',
    'logging'              => 'Registrar intentos de reCAPTCHA no válidos',
    'anonymous_only'       => 'Solo usuarios anónimos',
    'remoteusers'          => 'Forzar reCAPTCHA para todos los usuarios remotos',
    'enable_comment'       => 'Activar protección de comentarios',
    'enable_contact'       => 'Activar protección del formulario de contacto',
    'enable_emailstory'    => 'Activar protección del envío de artículos por correo',
    'enable_registration'  => 'Activar protección del registro',
    'enable_loginform'     => 'Activar protección del formulario de acceso',
    'enable_getpassword'   => 'Activar protección del formulario de recuperación de contraseña',
    'enable_story'         => 'Activar protección de artículos',
    'score_comment'        => 'Umbral de puntuación para comentarios',
    'score_contact'        => 'Umbral de puntuación para contacto',
    'score_emailstory'     => 'Umbral de puntuación para envío de artículos por correo',
    'score_registration'   => 'Umbral de puntuación para registro',
    'score_loginform'      => 'Umbral de puntuación para acceso',
    'score_getpassword'    => 'Umbral de puntuación para recuperación de contraseña',
    'score_story'          => 'Umbral de puntuación para artículos',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => 'Configuración principal',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'Configuración de reCAPTCHA',
    'tab_integration' => 'Integración con Geeklog',
    'tab_score'       => 'Umbrales de puntuación',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'Sistema',
    'fs_integration' => 'Integración con Geeklog',
    'fs_score'       => 'Umbrales de puntuación',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['Sí' => 1, 'No' => 0],
    2 => ['Desactivado' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 invisible' => 2, 'reCAPTCHA V3' => 4],
];
