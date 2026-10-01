<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/german_utf-8.php                    |
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
    'msg_error'   => 'Fehler: Die reCAPTCHA-Prüfung war ungültig.',
    'entry_error' => 'In %1s wurde eine ungültige reCAPTCHA-Zeichenfolge eingegeben - IP-Adresse: %2s - Fehlercodes: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'reCAPTCHA-Konfiguration',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'reCAPTCHA V2 Site-Schlüssel',
    'secret_key'           => 'reCAPTCHA V2 Geheimschlüssel',
    'invisible_site_key'   => 'Invisible reCAPTCHA Site-Schlüssel',
    'invisible_secret_key' => 'Invisible reCAPTCHA Geheimschlüssel',
    'site_key_v3'          => 'reCAPTCHA V3 Site-Schlüssel',
    'secret_key_v3'        => 'reCAPTCHA V3 Geheimschlüssel',
    'logging'              => 'Ungültige reCAPTCHA-Versuche protokollieren',
    'anonymous_only'       => 'Nur anonyme Benutzer',
    'remoteusers'          => 'reCAPTCHA für alle Remote-Benutzer erzwingen',
    'enable_comment'       => 'Schutz für Kommentare aktivieren',
    'enable_contact'       => 'Schutz für Kontaktformular aktivieren',
    'enable_emailstory'    => 'Schutz für Artikel per E-Mail aktivieren',
    'enable_registration'  => 'Schutz für Registrierung aktivieren',
    'enable_loginform'     => 'Schutz für Anmeldeformular aktivieren',
    'enable_getpassword'   => 'Schutz für Passwortanforderung aktivieren',
    'enable_story'         => 'Schutz für Artikel aktivieren',
    'score_comment'        => 'Schwellenwert für Kommentare',
    'score_contact'        => 'Schwellenwert für Kontaktformular',
    'score_emailstory'     => 'Schwellenwert für Artikel per E-Mail',
    'score_registration'   => 'Schwellenwert für Registrierung',
    'score_loginform'      => 'Schwellenwert für Anmeldeformular',
    'score_getpassword'    => 'Schwellenwert für Passwortanforderung',
    'score_story'          => 'Schwellenwert für Artikel',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => 'Haupteinstellungen',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'reCAPTCHA-Einstellungen',
    'tab_integration' => 'Geeklog-Integration',
    'tab_score'       => 'Schwellenwerte',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'System',
    'fs_integration' => 'Geeklog-Integration',
    'fs_score'       => 'Schwellenwerte',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['Ja' => 1, 'Nein' => 0],
    2 => ['Deaktiviert' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 Invisible' => 2, 'reCAPTCHA V3' => 4],
];
