<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/language/french_canada_utf-8.php             |
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
    'msg_error'   => 'Erreur : la validation reCAPTCHA a échoué.',
    'entry_error' => 'Une chaîne reCAPTCHA non valide a été saisie dans %1s - Adresse IP : %2s - Codes d’erreur : %3s',    // %1s = $type, %2s = $ip, %3s = $errorCode
];

// Localization of the Admin Configuration UI
$LANG_configsections['recaptcha'] = [
    'label' => 'reCAPTCHA',
    'title' => 'Configuration de reCAPTCHA',
];

$LANG_confignames['recaptcha'] = [
    'site_key'             => 'Clé de site reCAPTCHA V2',
    'secret_key'           => 'Clé secrète reCAPTCHA V2',
    'invisible_site_key'   => 'Clé de site reCAPTCHA invisible',
    'invisible_secret_key' => 'Clé secrète reCAPTCHA invisible',
    'site_key_v3'          => 'Clé de site reCAPTCHA V3',
    'secret_key_v3'        => 'Clé secrète reCAPTCHA V3',
    'logging'              => 'Journaliser les tentatives reCAPTCHA non valides',
    'anonymous_only'       => 'Utilisateurs anonymes seulement',
    'remoteusers'          => 'Forcer reCAPTCHA pour tous les utilisateurs distants',
    'enable_comment'       => 'Activer la protection des commentaires',
    'enable_contact'       => 'Activer la protection du formulaire de contact',
    'enable_emailstory'    => 'Activer la protection de l’envoi d’un article par courriel',
    'enable_registration'  => 'Activer la protection de l’inscription',
    'enable_loginform'     => 'Activer la protection du formulaire de connexion',
    'enable_getpassword'   => 'Activer la protection du formulaire de récupération du mot de passe',
    'enable_story'         => 'Activer la protection des articles',
    'score_comment'        => 'Seuil de score pour les commentaires',
    'score_contact'        => 'Seuil de score pour le formulaire de contact',
    'score_emailstory'     => 'Seuil de score pour l’envoi d’un article par courriel',
    'score_registration'   => 'Seuil de score pour l’inscription',
    'score_loginform'      => 'Seuil de score pour le formulaire de connexion',
    'score_getpassword'    => 'Seuil de score pour la récupération du mot de passe',
    'score_story'          => 'Seuil de score pour les articles',
];

$LANG_configsubgroups['recaptcha'] = [
    'sg_main' => 'Paramètres principaux',
];

$LANG_tab['recaptcha'] = [
    'tab_general'     => 'Paramètres reCAPTCHA',
    'tab_integration' => 'Intégration Geeklog',
    'tab_score'       => 'Seuils de score',
];

$LANG_fs['recaptcha'] = [
    'fs_system'      => 'Système',
    'fs_integration' => 'Intégration Geeklog',
    'fs_score'       => 'Seuils de score',
];

// Note: entries 0, 1, 9, and 12 are the same as in $LANG_configselects['Core']
$LANG_configselects['recaptcha'] = [
    0 => ['Oui' => 1, 'Non' => 0],
    2 => ['Désactivé' => 0, 'reCAPTCHA V2' => 1, 'reCAPTCHA V2 invisible' => 2, 'reCAPTCHA V3' => 4],
];
