<?php

namespace Geeklog;

/**
 * Class Session
 *
 * @package Geeklog
 */
abstract class Session
{
    // Index of $_SESSION array
    const GL_NAMESPACE = '__gl';
    const VAR_NAMESPACE = '__v';
    const FLASH_NAMESPACE = '__f';

    // Lifespan of the session in seconds
    const LIFE_SPAN = 60 * 60 * 2;

    // Anonymous user id
    const ANON_USER_ID = 1;

    /**
     * "flash", i.e., one-time session variables
     *
     * @var array
     */
    private static $flashVars = [];

    /**
     * The flag to show if the class is initialized
     *
     * @var bool
     */
    private static $isInitialized = false;

    /**
     * Init the Session class
     */
    public static function init()
    {
        global $_CONF;

        if (self::$isInitialized) {
            return;
        }

        // Set PHP settings
        if (version_compare(PHP_VERSION, '5.5.2', '>=')) {
            ini_set('session.use_strict_mode', 1);
        }

        ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session.save_path', $_CONF['path'] . 'data/session');

        // Start a new session
        if (!session_start()) {
            die(__METHOD__ . ': Cannot start session.');
        }

        // Check if the user is new
        if (!isset($_SESSION[self::GL_NAMESPACE])
            || ($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['uid'] < self::ANON_USER_ID)
            || self::isExpires()) {
            $_SESSION[self::GL_NAMESPACE] = [
                self::FLASH_NAMESPACE => [],
                self::VAR_NAMESPACE   => [
                    'uid' => self::ANON_USER_ID,
                ],
            ];
        }

        // Move "flash" session vars to the property of the class
        if (isset($_SESSION[self::GL_NAMESPACE][self::FLASH_NAMESPACE])
            && is_array($_SESSION[self::GL_NAMESPACE][self::FLASH_NAMESPACE])) {
            self::$flashVars = $_SESSION[self::GL_NAMESPACE][self::FLASH_NAMESPACE];
        }
        $_SESSION[self::GL_NAMESPACE][self::FLASH_NAMESPACE] = [];

        // Update life span
        $_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['expiresAt'] = time() + self::LIFE_SPAN;

        // Finished initialization
        self::$isInitialized = true;
    }

    /**
     * Return if the current session has expired
     *
     * @return bool
     */
    public static function isExpires()
    {
        return isset($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['expiresAt'])
            && is_int($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['expiresAt'])
            && ($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['expiresAt']) < time();
    }

    /**
     * Return if the current user is anonymous
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        return ($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['uid'] > self::ANON_USER_ID);
    }

    /**
     * Return the current user id
     *
     * @return int
     */
    public static function getUid()
    {
        return (int) $_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['uid'];
    }

    /**
     * Set the current user id
     *
     * @param  int $uid
     * @throws \InvalidArgumentException
     */
    public static function setUid($uid)
    {
        $uid = (int) $uid;

        if ($uid >= self::ANON_USER_ID) {
            $_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['uid'] = $uid;
            self::regenerate();
        } else {
            throw new \InvalidArgumentException('User id must be ' . self::ANON_USER_ID . ' or greater.');
        }
    }

    /**
     * Set a session value
     *
     * @param  string $name
     * @param  mixed  $value
     */
    public static function set($name, $value)
    {
        $_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE][$name] = $value;
    }

    /**
     * Set a "flash" session value
     *
     * @param  string $name
     * @param  mixed  $value
     */
    public static function setFlash($name, $value)
    {
        $_SESSION[self::GL_NAMESPACE][self::FLASH_NAMESPACE][$name] = $value;
    }

    /**
     * Get a session value
     *
     * @param  string $name
     * @param  mixed  $defaultValue
     * @return mixed
     */
    public static function get($name, $defaultValue = null)
    {
        return isset($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE][$name])
            ? $_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE][$name]
            : $defaultValue;
    }

    /**
     * Get a "flash" session value
     *
     * @param  string $name
     * @param  mixed  $defaultValue
     * @return mixed
     */
    public static function getFlash($name, $defaultValue = null)
    {
        return isset(self::$flashVars[$name]) ? self::$flashVars[$name] : $defaultValue;
    }

    /**
     * Regenerate the session id
     */
    public static function regenerate()
    {
        session_regenerate_id(false);
    }
}
