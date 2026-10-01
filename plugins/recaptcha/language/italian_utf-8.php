<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/italian_utf-8.php                   |
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
    'msg_error'   => 'Errore: la verifica reCAPTCHA non è valida.',
    'entry_error' => 'È stata inserita una stringa reCAPTCHA non valida in %1s - Indirizzo IP: %2s - Codici di errore: %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'Configurazione reCAPTCHA',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'Chiave sito reCAPTCHA V2',
    'secret_key'           => 'Chiave segreta reCAPTCHA V2',
    'invisible_site_key'   => 'Chiave sito reCAPTCHA invisibile',
    'invisible_secret_key' => 'Chiave segreta reCAPTCHA invisibile',
    'site_key_v3'          => 'Chiave sito reCAPTCHA V3',
    'secret_key_v3'        => 'Chiave segreta reCAPTCHA V3',
    'logging'              => 'Registra i tentativi reCAPTCHA non validi',
    'anonymous_only'       => 'Solo utenti anonimi',
    'remoteusers'          => 'Forza reCAPTCHA per tutti gli utenti remoti',
    'enable_comment'       => 'Abilita protezione commenti',
    'enable_contact'       => 'Abilita protezione modulo contatti',
    'enable_emailstory'    => 'Abilita protezione invio articolo via e-mail',
    'enable_registration'  => 'Abilita protezione registrazione',
    'enable_loginform'     => 'Abilita protezione modulo di accesso',
    'enable_getpassword'   => 'Abilita protezione recupero password',
    'enable_story'         => 'Abilita protezione articoli',
    'score_comment'        => 'Soglia punteggio per commenti',
    'score_contact'        => 'Soglia punteggio per contatti',
    'score_emailstory'     => 'Soglia punteggio per invio articolo via e-mail',
    'score_registration'   => 'Soglia punteggio per registrazione',
    'score_loginform'      => 'Soglia punteggio per accesso',
    'score_getpassword'    => 'Soglia punteggio per recupero password',
    'score_story'          => 'Soglia punteggio per articoli',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => 'Impostazioni principali',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'Impostazioni reCAPTCHA',
    'tab_integration' => 'Integrazione Geeklog',
    'tab_score'       => 'Soglie punteggio',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'Sistema',
    'fs_integration' => 'Integrazione Geeklog',
    'fs_score'       => 'Soglie punteggio',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['Sì' => 1, 'No' => 0],
    2 => ['Disabilitato' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 invisibile' => 2, 'reCAPTCHA V3' => 4],
];
