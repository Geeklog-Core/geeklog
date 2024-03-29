<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | configuration.php                                                         |
// |                                                                           |
// | Loads the administration UI and sends input to config.class               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2020 by the following authors:                         |
// |                                                                           |
// | Authors: Aaron Blankstein  - kantai AT gmail DOT com                      |
// |          Akeda Bagus       - admin AT gedex DOT web DOT id                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
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

use Geeklog\Input;
/**
 * Geeklog common function library
 */
require_once '../lib-common.php';
require_once 'auth.inc.php';

/**
 * Helper function: Provide language dropdown
 * NOTE:     Note that key/value are being swapped!
 *
 * @return   array   Array of (filename, displayname) pairs
 */
function configmanager_select_language_helper()
{
    global $_CONF;

    return array_flip(MBYTE_languageList($_CONF['default_charset']));
}

/**
 * Helper function: Provide themes dropdown
 * NOTE:     Beautifying code duplicated from usersettings.php
 *
 * @return   array   Array of (filename, displayname) pairs
 */
function configmanager_select_theme_helper()
{
    global $LANG04;

    $themes = [];

    $themeInfos = COM_getThemes(true, true, true);
    uasort(
        $themeInfos,
        function ($a, $b) {
            return strcasecmp($a['theme_name'], $b['theme_name']);
        }
    );

    foreach ($themeInfos as $dirName => $themeInfo) {
        $text = sprintf(
            $LANG04['theme_info'],
            $themeInfo['theme_name'], $themeInfo['theme_version'], $themeInfo['theme_gl_version']
        );
        $themes[$text] = $dirName;
    }

    return $themes;
}

/**
 * Helper function: Provide timezone dropdown
 *
 * @return   array   Array of (timezone-long-name, timezone-short-name) pairs
 */
function configmanager_select_timezone_helper()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/timezoneconfig.class.php';

    return array_flip(TimeZoneConfig::listAvailableTimeZones());
}

/**
 * Helper function: Provide dropdown for Permanent Cookie Timeout
 *
 * @return   array   Array of (description, timeout-in-seconds) pairs
 */
function configmanager_select_default_perm_cookie_timeout_helper()
{
    $retval = [];

    foreach (COM_getCookieCodes() as $row) {
        list ($ccValue, $ccDesc) = $row;
        $retval[$ccDesc] = $ccValue;
    }

    return $retval;
}

/**
 * Helper function: Provide advanced editors dropdown
 *
 * @return   array   Array of (filename, displayname) pairs
 */
function configmanager_select_advanced_editor_name_helper()
{
    global $_CONF;

    $editors = [];

    // gets all installed Advanced Editors
    $editorFiles = [];
    $fd = opendir($_CONF['path_editors']);
    clearstatcache();

    while (($dir = @readdir($fd)) == true) {
        if (is_dir($_CONF['path_editors'] . $dir) &&
            $dir <> '.' &&
            $dir <> '..' &&
            $dir <> 'CVS' &&
            substr($dir, 0, 1) <> '.'
        ) {
            $editorFiles[] = $dir;
        }
    }

    usort($editorFiles, 'strcasecmp');

    foreach ($editorFiles as $editor) {
        $name = '';
        if (file_exists($_CONF['path_editors'] . $editor . '/functions.php')) {
            require_once $_CONF['path_editors'] . $editor . '/functions.php';
            $function = 'adveditor_config_' . $editor;
            if (function_exists($function)) {
                $config = $function();
                $name = $config['name'];
            }
        }
        if (empty($name)) {
            $words = explode('_', $editor);
            $bwords = [];

            foreach ($words as $th) {
                if ((strtolower($th[0]) == $th[0]) &&
                    (strtolower($th[1]) == $th[1])
                ) {
                    $bwords[] = ucfirst($th);
                } else {
                    $bwords[] = $th;
                }
            }
            $name = implode(' ', $bwords);
        }
        $editors[$name] = $editor;
    }

    return $editors;
}

/**
 * Custom validation rule for copyrightyear
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_copyrightyear($rule, $ruleParams)
{
    $year = $ruleParams[0]['copyrightyear'];

    return preg_match('/^\d{1,4}\s?\-?\-\d{0,4}$/', $year);
}

/**
 * Custom validation rule for a config option which is an array that if an element exists ir must contain at least some text
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_arrayElementString($rule, $ruleParams)
{
    $ret = false;

    // Make sure at element is not empty
    foreach ($ruleParams[0] as $key => $value) {
        if (!empty($value)) {
            $ret = true;
        }
    }

    return $ret;
}

/**
 * Custom validation rule for a config option which is an array that requires at least 1 element and that all elements contain at least some text
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_arrayLeastOneElementString($rule, $ruleParams)
{
    $ret = false;

    // Array in array so if count less than 2 then no elements in base rule
    if (count($ruleParams) > 2) {
        // Now make sure at element is not empty
        foreach ($ruleParams[0] as $key => $value) {
            if (!empty($value)) {
                $ret = true;
            }
        }
    }

    return $ret;
}

/**
 * Custom validation rule for mail_settings[sendmail_path]
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_mail_settings_sendmail_path($rule, $ruleParams)
{
    $ret = true;

    if (isset($ruleParams[2]['backend']) && $ruleParams[2]['backend'] == 'sendmail') {
        if (isset($ruleParams[0]['mail_settings[sendmail_path]']) &&
            empty($ruleParams[0]['mail_settings[sendmail_path]'])
        ) {
            $ret = false;
        } else if (is_string($ruleParams[0]['mail_settings[sendmail_path]'])) {
            $ret = true;
        }
    }

    return $ret;
}

/**
 * Custom validation rule for Feed Limit
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_rdf_limit($rule, $ruleParams)
{
    $ret = false;

    if (isset($ruleParams[0]['rdf_limit'])) {
        $ret = preg_match('/^[\d]+h?$/i', $ruleParams[0]['rdf_limit']);
    }

    return $ret;
}

/**
 * Custom validation rule for check path existence
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_path($rule, $ruleParams)
{
    $ret = false;

    if (isset($ruleParams[0])) {
        foreach ($ruleParams[0] as $paramName => $paramValue) {
            $ret = is_dir($ruleParams[0][$paramName]);
            break;
        }
    }

    return $ret;
}

/**
 * Custom validation rule for check file existence
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_file($rule, $ruleParams)
{
    $ret = false;

    if (isset($ruleParams[0])) {
        foreach ($ruleParams[0] as $paramName => $paramValue) {
            $ret = file_exists($ruleParams[0][$paramName]);
            break;
        }
    }

    return $ret;
}

/**
 * Custom validation rule for page limits for search
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_search_limits($rule, $ruleParams)
{
    $ret = false;
    if (isset($ruleParams[0]['search_limits'])) {
        $limits = explode(',', $ruleParams[0]['search_limits']);

        $prevLimit = 0;
        foreach ($limits as $limit) {
            if (!is_numeric($limit) || $limit < 0) {
                $ret = false;
                break;
            }

            if ($limit < $prevLimit) {
                $ret = false;
                break;
            }

            $ret = true;
            $prevLimit = $limit;
        }
    }

    return $ret;
}

/**
 * Custom validation rule for number of search results
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_num_search_results($rule, $ruleParams)
{
    global $_CONF;

    $ret = false;
    if (isset($_CONF['search_limits']) &&
        isset($ruleParams[0]['num_search_results'])
    ) {

        $limits = explode(',', $_CONF['search_limits']);

        if (in_array($ruleParams[0]['num_search_results'], $limits)) {
            $ret = true;
        }
    }

    return $ret;
}

/**
 * Custom validation rule for theme
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_theme($rule, $ruleParams)
{
    global $_CONF;

    $ret = false;
    if (isset($_CONF['path_themes']) &&
        isset($ruleParams[0]['theme'])
    ) {
        if (is_dir($_CONF['path_themes'] . DIRECTORY_SEPARATOR . $ruleParams[0]['theme'])) {
            $ret = true;
        }
    }

    return $ret;
}

/**
 * Custom validation rule for path_themes
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_path_themes($rule, $ruleParams)
{
    $ret = false;
    if (isset($ruleParams[0]['path_themes']) && is_dir($ruleParams[0]['path_themes'])) {
        $ret = true;
    }

    if (substr($ruleParams[0]['path_themes'], -1) !== DIRECTORY_SEPARATOR) {
        $ret = false;
    }

    return $ret;
}

/**
 * Custom validation rule for path_to_mogrify
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_path_to_mogrify($rule, $ruleParams)
{
    return isset($ruleParams[0]['path_to_mogrify']) &&
        file_exists($ruleParams[0]['path_to_mogrify']);
}

/**
 * Custom validation rule for path_to_netpbm
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_path_to_netpbm($rule, $ruleParams)
{
    return isset($ruleParams[0]['path_to_netpbm']) &&
        is_dir($ruleParams[0]['path_to_netpbm']);
}

/**
 * Custom validation rule for language
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_language($rule, $ruleParams)
{
    global $_CONF;

    $ret = false;
    $languages = array_flip(MBYTE_languageList($_CONF['default_charset']));
    if (isset($ruleParams[0]['language']) && in_array($ruleParams[0]['language'], $languages)) {
        $ret = true;
    }

    return $ret;
}

/**
 * Custom validation rule for timezone
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_timezone($rule, $ruleParams)
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/timezoneconfig.class.php';
    $timezones = array_flip(TimeZoneConfig::listAvailableTimeZones());

    $ret = false;
    if (isset($ruleParams[0]['timezone']) && in_array($ruleParams[0]['timezone'], $timezones)) {
        $ret = true;
    }

    return $ret;
}

/**
 * Custom validation rule to determine if HTML or PHP tags exist
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_noTags($rule, $ruleParams)
{
    $ret = false;

    if (isset($ruleParams[0])) {
        foreach ($ruleParams[0] as $paramName => $paramValue) {
            if ($ruleParams[0][$paramName] == GLText::stripTags($ruleParams[0][$paramName])) {
                $ret = true;
            }
            break;
        }
    }

    return $ret;
}

/**
 * Custom validation rule for single character
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_single_char($rule, $ruleParams)
{
    $ret = false;

    if (isset($ruleParams[0])) {
        foreach ($ruleParams[0] as $paramName => $paramValue) {
            if (preg_match('/^[\s\w.,;\-]$/i', $paramValue)) {
                $ret = true;
            }
            break;
        }
    }

    return $ret;
}

/**
 * Custom validation rule for hash function
 *
 * @param string $rule       String of rule name
 * @param array  $ruleParams Parameter of validation
 * @return boolean Success
 */
function custom_validation_hash_function($rule, $ruleParams)
{
    $ret = false;

    switch ($ruleParams[0]['pass_alg']) {
        case HashFunction::md5:
            if (function_exists('md5')) $ret = true;
            break;

        case HashFunction::sha1:
            if (function_exists('sha1')) $ret = true;
            break;

        case HashFunction::sha256:
            if (CRYPT_SHA256 == 1) $ret = true;
            break;

        case HashFunction::sha512:
            if (CRYPT_SHA512 == 1) $ret = true;
            break;

        case HashFunction::blowfish:
            if (CRYPT_BLOWFISH == 1) $ret = true;
            break;

        default:
            $ret = false;
    }

    return $ret;
}

// MAIN
$display = '';

$config = config::get_instance();

$default_conf_group = 'Core';
if (!SEC_inGroup('Root')) {
    $default_conf_group = $config->_get_groups();
    if (!empty($default_conf_group)) {
        $default_conf_group = array_values($default_conf_group);
        $default_conf_group = $default_conf_group[0];
    } else {
        COM_output(config::UI_perm_denied());
        exit;
    }
}
$conf_group = Input::fPost('conf_group', $default_conf_group);

if (array_key_exists('set_action', $_POST) && SEC_checkToken()) {
    if ($_POST['set_action'] == 'restore') {
        $config->restore_param(
            Input::post('name'), $conf_group, Input::post('subgroup'), Input::post('tab')
        );
    } elseif ($_POST['set_action'] == 'unset') {
        $config->unset_param(
            Input::post('name'), $conf_group, Input::post('subgroup'), Input::post('tab')
        );
    }

    // notify plugins when config item enabled or disabled
    $config_item[] = Input::post('name');
    PLG_configChange($conf_group, $config_item);

    $subgroup = Input::fPost('subgroup', null);
    $display = $config->get_ui($conf_group, $subgroup);
} elseif (array_key_exists('form_submit', $_POST) && SEC_checkToken()) {
    $result = null;
    if (!array_key_exists('form_reset', $_POST)) {
        if ($conf_group === 'Core') {
            require_once 'configuration_validation.php';
        } else {
            // Retrieve plugin config validation if found
            $filename = $_CONF['path'] . 'plugins/' . $conf_group . '/configuration_validation.php';
            if (file_exists($filename)) {
                require_once $filename;
            }
        }

        $result = $config->updateConfig($_POST, $conf_group);

        // notify plugins
        if (is_array($result) && (count($result) > 0)) {
            PLG_configChange($conf_group, array_keys($result));
        }
    }
    //$display = $config->get_ui($conf_group, $_POST['sub_group'], $result);
    $sub_group = Input::fPost('sub_group', '0');
    $display = $config->get_ui($conf_group, $sub_group, $result);
} else {
    //$display = $config->get_ui($conf_group, array_key_exists('subgroup', $_POST)
    //                                       ?  $_POST['subgroup'] : null);
    if ($conf_group === 'Core') {
        require_once 'configuration_validation.php';
    } else {
        // Retrieve plugin config validation if found
        $filename = $_CONF['path'] . 'plugins/' . $conf_group . '/configuration_validation.php';
        if (file_exists($filename)) {
            require_once $filename;
        }
    }

    $subgroup = Input::fPost('subgroup', null);
    $display = $config->get_ui($conf_group, $subgroup);
}

COM_output($display);
