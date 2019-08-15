<?php

global $_CONF;

use Geeklog\Autoload;

require_once __DIR__ . '/tst.class.php';
Tst::init();

if (!is_callable('COM_deprecatedLog')) {
    /**
     * Writes a deprecated warning message in Geeklog error log file (only in root debug mode)
     *
     * @param   string $deprecated_object  Name of depreciated function, class, etc..
     * @param   string $deprecated_version Version of Geeklog that object was depreciated in
     * @param   string $removed_version    Planned version of Geeklog object will be removed
     * @param   string $new_object         New object developer should be using instead
     * @return
     * @since   since v2.1.2
     */
    function COM_deprecatedLog($deprecated_object, $deprecated_version, $removed_version, $new_object = '')
    {
//        global $_CONF;
//
//        // Only show deprecated calls in developer mode
//        if (isset($_CONF['developer_mode']) && ($_CONF['developer_mode'] === true)) {
//
//            $log_msg = sprintf(
//                'Deprecated Warning - %1$s has been deprecated since Geeklog %2$s. This object will be removed in Geeklog %3$s.',
//                $deprecated_object, $deprecated_version, $removed_version
//            );
//
//            if (!empty($new_object)) {
//                $log_msg .= sprintf(' Use %1$s instead.', $new_object);
//            }
//
//            COM_errorLog($log_msg, 1);
//        }
    }
}

if (!is_callable('COM_isDeveloperMode')) {
    /**
     * Return if developer mode is set
     *
     * @since  v2.2.0
     * @return bool   true = developer mode on, false otherwise
     */
    function COM_isDeveloperMode()
    {
        global $_CONF;

        return isset($_CONF['developer_mode']) && ($_CONF['developer_mode'] === true);
    }
}

if (!is_callable('COM_isEnableDeveloperModeLog')) {
    /**
     * Return if we should enable the detailed logging of some kind in developer mode
     *
     * @param  string $type
     * @since  v2.2.0
     * @return bool true = detailed logging is enabled, false otherwise
     */
    function COM_isEnableDeveloperModeLog($type)
    {
        global $_CONF;

        $type = strtolower($type);
        $retval = COM_isDeveloperMode() &&
            isset($_CONF['developer_mode_log'], $_CONF['developer_mode_log'][$type]) &&
            $_CONF['developer_mode_log'][$type];

        return $retval;
    }

}

// To disable your site quickly, simply set this flag to false
$_CONF['site_enabled'] = true;

// If you have errors on your site, can't login, or can't get to the
// config UI, then you can comment this in to set the root debug option
// on and get detailed error messages. You can set this to 'force' (which the
// Config UI won't allow you to do) to override hiding of password and cookie
// items in the debug trace.
$_CONF['rootdebug'] = false;

/**
 * Developer mode
 *
 * If you set this mode to true, detailed information will be displayed and/or logged.
 *
 * @var boolean
 * @since 2.1.2
 */
// $_CONF['developer_mode'] = true;

$_CONF['path'] = Tst::$root;
$_CONF['path_system'] = $_CONF['path'] . 'system/';
$_CONF['default_charset'] = 'utf-8';
$_CONF_FCK['imagelibrary'] = '/images/library';

// Useful Stuff
if (!defined('LB')) {
    define('LB',"\n");
}
if (!defined('VERSION')) {
    define('VERSION', Tst::VERSION);
}

require_once $_CONF['path_system'] . 'classes/Autoload.php';
Autoload::initialize();
