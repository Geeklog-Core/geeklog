<?php

namespace Geeklog;

use InvalidArgumentException;

/**
 * Class Session
 *
 * @package Geeklog
 */
abstract class Session
{
    // Indices of $_SESSION array
    const NS_GL = '__gl';
    const NS_FLASH_VAR = '__f';
    const NS_VAR = '__v';

    // Default session name
    const DEFAULT_SESSION_NAME = 'GLSESSION';

    // Anonymous user ID
    const ANON_USER_ID = 1;

    /**
     * "flash", i.e., one-time session variables
     *
     * @var array
     */
    private static $flashVars = array();

    /**
     * The flag to show if the class is initialized
     *
     * @var bool
     */
    private static $isInitialized = false;

    /**
     * Init the Session class
     *
     * @param  array  $config
     * @return bool   whether the session cookie already exists
     */
    public static function init(array $config)
    {
        $retval = true;

        if (self::$isInitialized) {
            return $retval;
        }

        // Make PHP session settings safer
        if (is_callable('ini_set')) {
            if (version_compare(PHP_VERSION, '5.5.2', '>=')) {
                ini_set('session.use_strict_mode', 1);

                if (version_compare(PHP_VERSION, '7.1.0', '>=')) {
                    ini_set('session.sid_length', 40);
                    ini_set('session.sid_bits_per_character', 5);

                    if (version_compare(PHP_VERSION, '7.3.0', '>=')) {
                        ini_set('session.cookie_samesite', 'Lax');
                    }
                }
            }

            ini_set('session.use_cookies', 1);
            ini_set('session.use_only_cookies', 1);
            ini_set('session.use_trans_sid', 0);
            ini_set('session.cache_limiter', 'nocache');
            ini_set('session.cookie_lifetime', 0);
        }

        // Set session cookie parameters
        self::setSessionCookieParameters($config);

        // Start a new session
        if (!session_start()) {
            die(__METHOD__ . ': Cannot start session.');
        }

        // Initialize the $_SESSION var if this is the first visit to the site
        if (!isset($_SESSION[self::NS_GL]) ||
            !isset($_SESSION[self::NS_GL][self::NS_FLASH_VAR]) ||
            !is_array($_SESSION[self::NS_GL][self::NS_FLASH_VAR]) ||
            !isset($_SESSION[self::NS_GL][self::NS_VAR]) ||
            !is_array($_SESSION[self::NS_GL][self::NS_VAR]) ||
            !isset($_SESSION[self::NS_GL][self::NS_VAR]['uid']) ||
            !is_int($_SESSION[self::NS_GL][self::NS_VAR]['uid']) ||
            ($_SESSION[self::NS_GL][self::NS_VAR]['uid'] < self::ANON_USER_ID)
        ) {
            $_SESSION[self::NS_GL] = array(
                self::NS_FLASH_VAR => array(),
                self::NS_VAR       => array(
                    'uid' => self::ANON_USER_ID,
                ),
            );
            $retval = false;
        }

        // Move "flash" session vars to the property of the class
        self::$flashVars = $_SESSION[self::NS_GL][self::NS_FLASH_VAR];
        $_SESSION[self::NS_GL][self::NS_FLASH_VAR] = array();

        // Finish initialization
        self::$isInitialized = true;

        return $retval;
    }

    /**
     * Return if the current user is logged in to the site
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        return (self::getUid() > self::ANON_USER_ID);
    }

    /**
     * Return the current user id
     *
     * @return int
     */
    public static function getUid()
    {
        return $_SESSION[self::NS_GL][self::NS_VAR]['uid'];
    }

    /**
     * Set the current user id
     *
     * @param  int  $uid
     * @throws InvalidArgumentException
     */
    public static function setUid($uid)
    {
        $uid = (int) $uid;

        if ($uid >= self::ANON_USER_ID) {
            $_SESSION[self::NS_GL][self::NS_VAR]['uid'] = $uid;
        } else {
            throw new InvalidArgumentException('User id must be ' . self::ANON_USER_ID . ' or greater.');
        }
    }

    /**
     * Set a session variable
     *
     * @param  string  $name
     * @param  mixed   $value
     */
    public static function setVar($name, $value)
    {
        $_SESSION[self::NS_GL][self::NS_VAR][$name] = $value;
    }

    /**
     * Set a "flash" session variable
     *
     * @param  string  $name
     * @param  mixed   $value
     */
    public static function setFlashVar($name, $value)
    {
        $_SESSION[self::NS_GL][self::NS_FLASH_VAR][$name] = $value;
    }

    /**
     * Get a session variable
     *
     * @param  string  $name
     * @param  mixed   $defaultValue
     * @return mixed
     */
    public static function getVar($name, $defaultValue = null)
    {
        return isset($_SESSION[self::NS_GL][self::NS_VAR][$name])
            ? $_SESSION[self::NS_GL][self::NS_VAR][$name]
            : $defaultValue;
    }

    /**
     * Get a "flash" session variable
     *
     * @param  string  $name
     * @param  mixed   $defaultValue
     * @return mixed
     */
    public static function getFlashVar($name, $defaultValue = null)
    {
        return isset(self::$flashVars[$name]) ? self::$flashVars[$name] : $defaultValue;
    }

    /**
     * Regenerate the session id
     *
     * @return string the new session id
     */
    public static function regenerateId()
    {
        session_regenerate_id(false);

        return self::getSessionId();
    }

    /**
     * Set session cookie parameters
     *
     * @param  array  $config
     */
    private static function setSessionCookieParameters(array $config)
    {
        $args = session_get_cookie_params();

        // Override 'lifetime'
        $args['lifetime'] = 0;

        if (isset($config['cookie_path']) && (strlen($config['cookie_path']) > 0)) {
            $args['path'] = $config['cookie_path'];
        }

        if (isset($config['cookie_domain']) && (strlen($config['cookie_domain']) > 0)) {
            $args['domain'] = $config['cookie_domain'];
        }

        if (isset($config['cookie_secure']) && (is_bool($config['cookie_secure']) || is_int($config['cookie_secure']))) {
            $args['secure'] = (bool) $config['cookie_secure'];
        }

        if (!isset($config['session_name']) || preg_match('/\A[0-9]+\z/', $config['session_name'])) {
            $config['session_name'] = self::DEFAULT_SESSION_NAME;
        } else {
            $config['session_name'] = str_replace('_', '', $config['session_name']);
            $config['session_name'] = strtoupper($config['session_name']);
        }

        $args['httponly'] = true;
        session_set_cookie_params($args['lifetime'], $args['path'], $args['domain'], $args['secure'], $args['httponly']);
        session_name($config['session_name']);
    }

    /**
     * Return the current session id
     *
     * @return string
     */
    public static function getSessionId()
    {
        return session_id();
    }
}
