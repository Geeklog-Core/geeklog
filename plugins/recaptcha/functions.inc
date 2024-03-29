<?php

// +---------------------------------------------------------------------------+
// | reCAPTCHA Plugin for Geeklog - The Ultimate Weblog                        |
// +---------------------------------------------------------------------------+
// | geeklog/plugins/recaptcha/functions.inc                                   |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014-2020 mystral-kk - geeklog AT mystral-kk DOT net        |
// |                                                                           |
// | Based on the CAPTCHA Plugin by Ben                                        |
// |                                                - ben AT geeklog DOT fr    |
// | Based on the original CAPTCHA Plugin by Mark R. Evans                     |
// |                                                - mark AT glfusion DOT org |
// | Constructed with the Universal Plugin                                     |
// +---------------------------------------------------------------------------+
// |                                                                           |
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
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

use Geeklog\Log;
use ReCaptcha\ReCaptcha;
use ReCaptcha\RequestMethod\CurlPost;
use ReCaptcha\RequestMethod\Post;
use ReCaptcha\RequestMethod\SocketPost;

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file cannot be used on its own.');
}

// Language file Include
$langFile = __DIR__ . '/language/' . $_CONF['language'] . '.php';
clearstatcache();

if (file_exists($langFile)) {
    include_once $langFile;
} else {
    include_once __DIR__ . '/language/english.php';
}

// Loads the plugin configuration
global $_RECAPTCHA_CONF;

require_once __DIR__ . '/config.php';
RECAPTCHA_loadConfig();

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementations                                        |
// +---------------------------------------------------------------------------+

/**
 * Return a URL to icon
 *
 * @return string
 */
function plugin_geticon_recaptcha()
{
    global $_CONF;

    return $_CONF['site_admin_url'] . '/plugins/recaptcha/images/recaptcha.png';
}

/**
 * Puts an option for the plugin in the command and control block on moderation.php
 *
 * @return array Array containing (plugin name, admin url, url of plugin icon)
 */
function plugin_cclabel_recaptcha()
{
    global $_CONF;

    if (SEC_hasRights('recaptcha.edit')) {
        $pi_name = RECAPTCHA_str('admin');

        if (!RECAPTCHA_isRecaptchaV2Enabled() && !RECAPTCHA_isRecaptchaV2InvisibleEnabled()) {
            $pi_name = COM_createControl('display-text-warning', ['text' => $pi_name]);
        }

        $admin_url = $_CONF['site_admin_url'] . '/plugins/recaptcha/index.php';
        $icon_url = plugin_geticon_recaptcha();

        return [$pi_name, $admin_url, $icon_url];
    } else {
        return [];
    }
}

/**
 * Returns the administrative option for this plugin
 *
 * @return array Array containing (plugin name, plugin admin url, # of items in plugin)
 */
function plugin_getadminoption_recaptcha()
{
    global $_CONF;

    if (SEC_hasRights('recaptcha.edit')) {
        $pi_name = RECAPTCHA_str('admin');

        if (!RECAPTCHA_isRecaptchaV2Enabled() && !RECAPTCHA_isRecaptchaV2InvisibleEnabled()) {
            $pi_name = COM_createControl('display-text-warning', ['text' => $pi_name]);
        }

        $admin_url = $_CONF['site_admin_url'] . '/plugins/recaptcha/index.php';
        $num_items = 0;

        return [$pi_name, $admin_url, $num_items];
    } else {
        return [];
    }
}

/**
 * Returns the version for this plugin
 *
 * @return string plugin version no
 */
function plugin_chkVersion_recaptcha()
{
    global $_RECAPTCHA_CONF;

    return $_RECAPTCHA_CONF['pi_version'];
}

/**
 * Upgrades the plugin
 *
 * @return bool true (= success)
 */
function plugin_upgrade_recaptcha()
{
    global $_CONF, $_TABLES, $_RECAPTCHA_CONF;

    require_once __DIR__ . '/autoinstall.php';

    // Retrieve other plugin info like min geeklog version and homepage
    $inst_parms = plugin_autoinstall_recaptcha('recaptcha');

    $pluginVersionInDb = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'recaptcha'");
    $originalPluginVersionInDb = $pluginVersionInDb;

    // Does upgrading
    while (version_compare($pluginVersionInDb, $_RECAPTCHA_CONF['pi_version'], '<')) {
        switch ($pluginVersionInDb) {
            case '1.0.0':
            case '1.0.1':
            case '1.1.0':
            case '1.1.1':
            case '1.1.2':
            case '1.1.3':
            case '1.1.4':
            case '1.1.5':
                require_once __DIR__ . '/install_updates.php';
                recaptcha_update_ConfValues_1_1_5();
                $pluginVersionInDb = '1.1.6';
                break;

            case '1.1.6':
                require_once __DIR__ . '/install_updates.php';
                recaptcha_update_ConfValues_1_1_6();
                $pluginVersionInDb = '1.2.0';
                break;

            case '1.2.0':
                require_once __DIR__ . '/install_updates.php';
                recaptcha_update_ConfValues_1_2_0();
                $pluginVersionInDb = '1.2.1';
                break;

            case '1.2.1':
            case '1.2.2':
                require_once __DIR__ . '/install_updates.php';
                recaptcha_update_ConfValues_1_2_2();
                $pluginVersionInDb = '1.2.4';
                break;

            default:
                $pluginVersionInDb = $_RECAPTCHA_CONF['pi_version'];
                break;
        }
    }

    // update plugin version number and other info
    DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_RECAPTCHA_CONF['pi_version']}', pi_gl_version = '{$inst_parms['info']['pi_gl_version']}', pi_homepage = '{$inst_parms['info']['pi_homepage']}' WHERE pi_name = 'recaptcha'");
    COM_errorLog("Updated recaptcha plugin from v{$originalPluginVersionInDb} to v{$_RECAPTCHA_CONF['pi_version']}", 1);

    return true;
}

/**
 * Automatic uninstall function for plugins
 *
 * @return array
 */
function plugin_autouninstall_recaptcha()
{
    global $_RECAPTCHA_CONF;

    return [
        'tables'     => [],
        'groups'     => ['reCAPTCHA Admin'],
        'features'   => ['recaptcha.edit'],
        'php_blocks' => [],
        'vars'       => [],
    ];
}

/**
 * Return the URL to a given document
 *
 * @param  string  $file
 * @return string
 */
function plugin_getdocumentationurl_recaptcha($file)
{
    global $_CONF;

    $lang = COM_getLanguageName();
    $path = $_CONF['path_html'] . 'admin/plugins/recaptcha/docs/' . $lang . '/' . $file . '.html';
    clearstatcache();

    if (!file_exists($path)) {
        $lang = 'english';
    }

    return $_CONF['site_admin_url'] . '/plugins/recaptcha/docs/' . $lang . '/' . $file . '.html';
}

/**
 * Provides text for a Configuration tooltip
 *
 * @param  string  $id  Id of config value
 * @return mixed      Text to use regular tooltip, null to use config tooltip hack, or empty string
 *                      when not available
 */
function plugin_getconfigtooltip_recaptcha($id)
{
    // Use config tooltip hack where tooltip is read from the config documentation
    return null;
}

/**
 * Callback function to add HTML text for reCAPTCHA
 *
 * @param  string    $type
 * @param  Template  $template  a reference to a Template class object
 */
function plugin_templatesetvars_recaptcha($type, Template $template)
{
    global $_RECAPTCHA_CONF, $_SCRIPTS, $_CONF, $_USER;
    static $pluginInfo = null;
    static $firstTime = true; // Allows items to be set only once

    if ($pluginInfo === null) {
        $pluginInfo = PLG_collectRecaptchaInfo();
    }

    if (!array_key_exists($type, $pluginInfo) || !RECAPTCHA_requireCaptcha($type)) {
        return;
    }

    $info = $pluginInfo[$type];

    // Set to notify templates in case situation arises that the captcha should not be displayed
    // (for example the Login Block)
    $template->set_var('captcha_required', true);

    $formId = $info['form_id'];
    $js_onSubmit = '';
    if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
        if (isset($info['js_onsubmit_advanced_editor']) && !empty($info['js_onsubmit_advanced_editor'])) {
            $js_onSubmit = $info['js_onsubmit_advanced_editor'];
        }
    } else {
        if (isset($info['js_onsubmit']) && !empty($info['js_onsubmit'])) {
            $js_onSubmit = $info['js_onsubmit'];
        }
    }

    if ($info['version'] == RECAPTCHA_SUPPORT_V2_INVISIBLE) {
        $code = <<<JS
var onFormSubmit = function () {
    var gForm = document.getElementById('{$formId}');
    if (!gForm) {
        gForm = document.getElementById('{$formId}_advanced');
    }

	{$js_onSubmit}

    if (gForm) {
        gForm.submit();
    }
};
JS;
        $_SCRIPTS->setJavaScript($code, false, false);
    }

    // Only need to set this once
    if ($firstTime) {
        if ($info['version'] == RECAPTCHA_SUPPORT_V3) {
            // reCAPTCHA V3
            $_SCRIPTS->setJavaScriptFile(
                'recaptcha_v3',
                'https://www.google.com/recaptcha/api.js?render=' . $_RECAPTCHA_CONF['site_key_v3'],
                false,
                100,
                false
            );
            $code = <<<JS
grecaptcha.ready(function() {
    var resp = document.getElementById('g-recaptcha-response');

    if (resp) {
        var gForm = document.getElementById("{$formId}");
        
        if (!gForm) {
            gForm = document.getElementById("{$formId}_advanced");
        }
    
        if (gForm) {
            // Add an event listener to the form we want to add reCAPTCHA to
            gForm.addEventListener('submit', function(event) {
                // Prevent the form from being submitted
                event.preventDefault();
            
                // Get a token from reCAPTCHA service
                grecaptcha.execute('{$_RECAPTCHA_CONF['site_key_v3']}', { action: '{$info['action']}' })
                    .then(function(token) {
                        var gForm = document.getElementById("{$formId}");
                        
                        if (!gForm) {
                            gForm = document.getElementById("{$formId}_advanced");
                        }

                        // Set the token to <input> tag with its id being 'g-recaptcha-response' 
                        var resp = document.getElementById('g-recaptcha-response');
                        resp.value = token;
    
                        {$js_onSubmit}

                        // Submit the form and send data to the web server    
                        gForm.submit();
                    });
            }, false);
        }
    }
});
JS;
            $_SCRIPTS->setJavaScript($code, false, true);
        } else {
            // reCAPTCHA V2 checkbox and invisible
            $_SCRIPTS->setJavaScriptFile(
                'recaptcha',
                'https://www.google.com/recaptcha/api.js?hl=' . COM_getLangIso639Code(),
                false,
                100,
                false
            );
        }

        $firstTime = false;
    }

    $captcha = '';
    $invisibleCaptcha = '';
    $recaptcha_v3 = '';

    if (($info['version'] == RECAPTCHA_SUPPORT_V2_INVISIBLE)) {
        $invisibleCaptcha = sprintf(
            ' data-sitekey="%s" data-callback="%s"',
            RECAPTCHA_esc($_RECAPTCHA_CONF['invisible_site_key']), 'onFormSubmit'
        );
    } elseif ($info['version'] == RECAPTCHA_SUPPORT_V2) {
        $captcha = sprintf(
            '<div class="g-recaptcha" data-sitekey="%s"></div>',
            RECAPTCHA_esc($_RECAPTCHA_CONF['site_key'])
        );
    } elseif ($info['version'] == RECAPTCHA_SUPPORT_V3) {
        $recaptcha_v3 = '<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="">';
    }

    $template->set_var([
        'captcha'             => $captcha,
        'invisible_recaptcha' => $invisibleCaptcha,
        'recaptcha_v3'        => $recaptcha_v3
    ]);
}

/**
 * Callback function to check the code entered by a user
 *
 * @param  int     $uid       (not used in this function)
 * @param  string  $title     (not used in this function)
 * @param  string  $comment   (not used in this function)
 * @param  string  $sid       (not used in this function)
 * @param  int     $pid       (not used in this function)
 * @param  string  $type      (not used in this function)
 * @param  string  $postMode  (not used in this function)
 * @return string empty = success
 */
function plugin_commentPreSave_recaptcha($uid, $title, $comment, $sid, $pid, $type, $postMode)
{
    return plugin_itemPreSave_recaptcha('comment', '');
}

/**
 * Callback function to check the action the user takes
 *
 * @param  string  $type  item type
 * @param  string  $content
 * @return string empty on success, otherwise an error message
 */
function plugin_itemPreSave_recaptcha($type, $content = '')
{
    $response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    return RECAPTCHA_verify($type, $response);
}

/**
 * Writes an entry into a log file
 *
 * @param  string  $logEntry
 * @param  int     $override
 */
function RECAPTCHA_errorLog($logEntry, $override = 0)
{
    global $_CONF, $_RECAPTCHA_CONF;

    if (!isset($_RECAPTCHA_CONF['logging'])) {
        $_RECAPTCHA_CONF['logging'] = 0;
    }

    if (($_RECAPTCHA_CONF['logging'] != 1) && ($override == 0)) {
        return;
    }

    if (!empty($logEntry)) {
        Log::recaptcha($logEntry);
    }
}

/**
 * Loads config info with config.class.php
 */
function RECAPTCHA_loadConfig()
{
    global $_RECAPTCHA_CONF, $_RECAPTCHA_DEFAULT, $_TABLES;

    $config = config::get_instance();

    if ($config->group_exists('recaptcha')) {
        $_RECAPTCHA_CONF = array_merge($_RECAPTCHA_CONF, $config->get_config('recaptcha'));
    } else {
        COM_errorLog(__FUNCTION__ . ': cannot load configuration.  Using default settings instead');
        require_once __DIR__ . '/install_defaults.php';
        $_RECAPTCHA_CONF = $_RECAPTCHA_DEFAULT;
    }

    // Silently update the plugin
    $pi_version = DB_getItem($_TABLES['plugins'], 'pi_version', "pi_name = 'recaptcha'");

    if (version_compare($pi_version, $_RECAPTCHA_CONF['pi_version'], '<')) {
        plugin_upgrade_recaptcha();
    }
}

/**
 * Returns a string escaped for HTML output
 *
 * @param  string  $str
 * @return string
 */
function RECAPTCHA_esc($str)
{
    global $_CONF;

    static $encoding = null;

    if ($encoding === null) {
        $encoding = is_callable('COM_getCharset')
            ? COM_getCharset()
            : $_CONF['default_charset'];
    }

    if (version_compare(PHP_VERSION, '5.2.3') >= 0) {
        return htmlspecialchars($str, ENT_QUOTES, $encoding, false);
    } else {
        return str_replace(
            ['&amp;&amp;', '&amp;&lt;', '&amp;&gt;', '&amp;&quot;', '&amp;&#039;'],
            ['&amp;', '&lt:', '&gt;', '&quot;', '&#039;'],
            htmlspecialchars($str, ENT_QUOTES, $encoding)
        );
    }
}

/**
 * Return a lang var
 *
 * @param  string  $index
 * @param  bool    $noEsc
 * @return string
 */
function RECAPTCHA_str($index, $noEsc = false)
{
    global $LANG_RECAPTCHA;

    if (isset($LANG_RECAPTCHA[$index])) {
        return $noEsc ? $LANG_RECAPTCHA[$index] : RECAPTCHA_esc($LANG_RECAPTCHA[$index]);
    } else {
        COM_errorLog(__FUNCTION__ . ': undefined index: "' . $index . '"');

        return '(undefined)';
    }
}

/**
 * Returns if the current type of item requires reCAPTCHA
 *
 * @param  string  $type  item type
 * @return bool   true = requires reCAPTCHA, false otherwise
 * @throws InvalidArgumentException
 */
function RECAPTCHA_requireCaptcha($type)
{
    global $_RECAPTCHA_CONF, $_USER;
    static $pluginInfo = null;

    if ($pluginInfo === null) {
        $pluginInfo = PLG_collectRecaptchaInfo();
    }

    // This item is not supported
    if (!array_key_exists($type, $pluginInfo)) {
        return false;
    }

    switch ($pluginInfo[$type]['version']) {
        case RECAPTCHA_NO_SUPPORT:
            // This item does not support reCAPTCHA
            return false;

        case RECAPTCHA_SUPPORT_V2:
            if (!RECAPTCHA_isRecaptchaV2Enabled()) {
                return false;
            }
            break;

        case RECAPTCHA_SUPPORT_V2_INVISIBLE:
            if (!RECAPTCHA_isRecaptchaV2InvisibleEnabled()) {
                return false;
            }
            break;

        case RECAPTCHA_SUPPORT_V3:
            if (!RECAPTCHA_isRecaptchaV3Enabled()) {
                return false;
            }
            break;

        default:
            throw new InvalidArgumentException(__METHOD__ . ': unknown reCAPTCHA version: ' . $pluginInfo[$type]['which']);
    }

    if (!isset($_USER['uid'])) {
        $_USER['uid'] = 1;
    }

    if (($_RECAPTCHA_CONF['anonymous_only'] && ($_USER['uid'] < 2)) ||
        ($_RECAPTCHA_CONF['anonymous_only'] == 0) ||
        (($_RECAPTCHA_CONF['remoteusers'] == 1) && SEC_inGroup('Remote Users'))) {
        return true;
    }

    return false;
}

/**
 * Returns if reCAPTCHA V2 keys are set
 *
 * @return bool true = OK
 */
function RECAPTCHA_isRecaptchaV2Enabled()
{
    global $_RECAPTCHA_CONF;

    return ($_RECAPTCHA_CONF['secret_key'] !== '') && ($_RECAPTCHA_CONF['site_key'] !== '');
}

/**
 * Returns if reCAPTCHA V2 Invisible keys are set
 *
 * @return bool true = OK
 */
function RECAPTCHA_isRecaptchaV2InvisibleEnabled()
{
    global $_RECAPTCHA_CONF;

    return ($_RECAPTCHA_CONF['invisible_site_key'] !== '') && ($_RECAPTCHA_CONF['invisible_secret_key'] !== '');
}

/**
 * Returns if reCAPTCHA V3 keys are set
 *
 * @return bool true = OK
 */
function RECAPTCHA_isRecaptchaV3Enabled()
{
    global $_RECAPTCHA_CONF;

    return ($_RECAPTCHA_CONF['site_key_v3'] !== '') && ($_RECAPTCHA_CONF['secret_key_v3'] !== '');
}

/**
 * Return IP address
 *
 * @return string
 */
function RECAPTCHA_getIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = \Geeklog\IP::getIPAddress();
    }

    return $ip;
}

/**
 * Verify a token
 *
 * @param  string  $type  item type
 * @param  string  $token
 * @return string         empty on success, an error message otherwise
 */
function RECAPTCHA_verify($type, $token)
{
    global $_RECAPTCHA_CONF, $LANG_RECAPTCHA;
    static $pluginInfo = null;

    if ($pluginInfo === null) {
        $pluginInfo = PLG_collectRecaptchaInfo();
    }

    if (!RECAPTCHA_requireCaptcha($type)) {
        return '';
    }

    $info = $pluginInfo[$type];

    if ($info['version'] == RECAPTCHA_SUPPORT_V2) {
        $secretKey = $_RECAPTCHA_CONF['secret_key'];
    } elseif ($info['version'] == RECAPTCHA_SUPPORT_V2_INVISIBLE) {
        $secretKey = $_RECAPTCHA_CONF['invisible_secret_key'];
    } elseif ($info['version'] == RECAPTCHA_SUPPORT_V3) {
        $secretKey = $_RECAPTCHA_CONF['secret_key_v3'];
    } else {
        $msg = __FUNCTION__ . ': unknown reCAPTCHA type: ' . $info['version'];
        Log::error($msg);

        return $msg;
    }

    if (is_callable('curl_init')) {
        $recaptcha = new ReCaptcha($secretKey, new CurlPost());
    } elseif (@ini_get('allow_url_fopen')) {
        $recaptcha = new ReCaptcha($secretKey, new Post());
    } else {
        $recaptcha = new ReCaptcha($secretKey, new SocketPost());
    }

    // reCAPTCHA V3 supports 'action' and 'score'
    if ($info['version'] == RECAPTCHA_SUPPORT_V3) {
        $recaptcha
            ->setExpectedAction($info['action'])
            ->setScoreThreshold($info['score_threshold']);
    }

    $response = $recaptcha->verify($token, RECAPTCHA_getIP());

    if ($response->isSuccess()) {
        // @todo in case of V3, we should check if $response->getAction() === $info['action']
        return '';
    } else {
        $msg = implode(', ', $response->getErrorCodes());

        if ($_RECAPTCHA_CONF['logging']) {
            $entry = sprintf(
                RECAPTCHA_str('entry_error', true),
                $type,
                \Geeklog\IP::getIPAddress(),
                $msg
            );
            $entry = RECAPTCHA_esc($entry);
            RECAPTCHA_errorLog($entry);
        }

        /*
        Error code reference for recaptcha V2 https://developers.google.com/recaptcha/docs/verify
        Error code 	Description
        missing-input-secret 	The secret parameter is missing.
        invalid-input-secret 	The secret parameter is invalid or malformed.
        missing-input-response 	The response parameter is missing. - User didn't do anything with the recaptcha
        invalid-input-response 	The response parameter is invalid or malformed.
        bad-request             The request is invalid or malformed.
        */
        switch ($msg) {
            case 'missing-input-response':
                $msg = $LANG_RECAPTCHA['msg_error'];
                break;

            default:
                break;

        }

        return $msg;
    }
}

/**
 * Return the info asked by PLG_collectRecaptchaInfo().
 *
 * This function returns core-related parts.  Other plugins reply through plugin_supportsRecaptcha_xxx().
 *
 * @return  array of type => [
 *              'type'                        => type                    // required, passed as the 1st parameter to
 *              plugin_templatesetvars_xxx()
 *              'version'                     => reCAPTCHA version,      // required: RECAPTCHA_NO_SUPPORT(0),
 *              RECAPTCHA_SUPPORT_V2(1), RECAPTCHA_SUPPORT_V2_INVISIBLE(2), RECAPTCHA_SUPPORT_V3(4)
 *              'form_id'                     => form id,                // required only for reCAPTCHA V2 Invisible
 *              'js_onsubmit'                 => On Submit JavaScript,   // Used only for reCAPTCHA V2 Invisible if
 *              needed
 *              'js_onsubmit_advanced_editor' => On Submit JavaScript when advanced editor enabled, // Used only for
 *              reCAPTCHA V2 Invisible if needed
 *              'action'                      => action                  // Used only for reCAPTCHA V3
 *              'score_threshold'             => score threshold         // Used only for reCAPTCHA V3
 *           ]
 */
function plugin_supportsRecaptcha_recaptcha()
{
    global $_RECAPTCHA_CONF;

    return [
        [
            'type'                        => 'comment',
            'version'                     => $_RECAPTCHA_CONF['enable_comment'],
            'form_id'                     => 'commentform',
            'js_onsubmit'                 => '',
            'js_onsubmit_advanced_editor' => 'set_postcontent();',
            'action'                      => 'comment',
            'score_threshold'             => $_RECAPTCHA_CONF['score_comment'],
        ],
        [
            'type'            => 'contact',
            'version'         => $_RECAPTCHA_CONF['enable_contact'],
            'form_id'         => 'contactuserform',
            'action'          => 'contact',
            'score_threshold' => $_RECAPTCHA_CONF['score_contact'],
        ],
        [
            'type'            => 'emailstory',
            'version'         => $_RECAPTCHA_CONF['enable_emailstory'],
            'form_id'         => 'contactauthorform',
            'action'          => 'email',
            'score_threshold' => $_RECAPTCHA_CONF['score_emailstory'],
        ],
        [
            'type'            => 'registration',
            'version'         => $_RECAPTCHA_CONF['enable_registration'],
            'form_id'         => 'registrationform',
            'action'          => 'registration',
            'score_threshold' => $_RECAPTCHA_CONF['score_registration'],
        ],
        [
            'type'            => 'getpassword',
            'version'         => $_RECAPTCHA_CONF['enable_getpassword'],
            'form_id'         => 'getpasswordform',
            'action'          => 'getpassword',
            'score_threshold' => $_RECAPTCHA_CONF['score_getpassword'],
        ],
        [
            'type'            => 'loginform',
            'version'         => $_RECAPTCHA_CONF['enable_loginform'],
            'form_id'         => 'userloginform',
            'action'          => 'login',
            'score_threshold' => $_RECAPTCHA_CONF['score_loginform'],
        ],
        [
            'type'                        => 'story',
            'version'                     => $_RECAPTCHA_CONF['enable_story'],
            'form_id'                     => 'submitstory',
            'js_onsubmit'                 => '',
            'js_onsubmit_advanced_editor' => 'set_postcontent();',
            'action'                      => 'submit/story',
            'score_threshold'             => $_RECAPTCHA_CONF['score_story'],
        ],
    ];
}
