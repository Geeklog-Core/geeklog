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
    const FLASH_VAR_NAMESPACE = '__f';

    // Default lifespan of the session in seconds
    const DEFAULT_LIFE_SPAN = 7200; // 60 * 60 * 2;

    // Anonymous user ID
    const ANON_USER_ID = 1;

    /**
     * User ID
     *
     * @var int
     */
    private static $uid = 1;

    /**
     * Lifespan of the session
     *
     * @var int
     */
    private static $lifeSpan = self::DEFAULT_LIFE_SPAN;

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
     * @param array $config
     */
    public static function init(array $config)
    {
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

        if (isset($config['session_dir']) && is_readable($config['session_dir']) && is_dir($config['session_dir'])) {
            ini_set('session.save_path', $config['session_dir']);
        }

        // Start a new session
        if (!session_start()) {
            die(__METHOD__ . ': Cannot start session.');
        }

        // Check if the user is new
        if (!isset($_SESSION[self::GL_NAMESPACE])
            || !isset($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE])
            || !is_array($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE])
            || !isset($_SESSION[self::GL_NAMESPACE][self::FLASH_VAR_NAMESPACE])
            || !is_array($_SESSION[self::GL_NAMESPACE][self::FLASH_VAR_NAMESPACE])
            || !isset($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['uid'])
            || ($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['uid'] < self::ANON_USER_ID)
            || !isset($_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['expiresAt'])
            || self::isExpires()) {
            $_SESSION[self::GL_NAMESPACE] = array(
                self::FLASH_VAR_NAMESPACE => array(),
                self::VAR_NAMESPACE       => array(
                    'uid' => self::ANON_USER_ID,
                ),
            );
        }

        // Get user ID from session
        self::$uid = $_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['uid'];

        // Move "flash" session vars to the property of the class
        self::$flashVars = $_SESSION[self::GL_NAMESPACE][self::FLASH_VAR_NAMESPACE];
        $_SESSION[self::GL_NAMESPACE][self::FLASH_VAR_NAMESPACE] = array();

        // Update life span
        self::setLifeSpan(self::$lifeSpan);

        // Finished initialization
        self::$isInitialized = true;
    }

    /**
     * Return if the current session has already expired
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
     * Return if the current user is logged in to the site
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        return (self::$uid > self::ANON_USER_ID);
    }

    /**
     * Return the current user id
     *
     * @return int
     */
    public static function getUid()
    {
        return self::$uid;
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
        $_SESSION[self::GL_NAMESPACE][self::FLASH_VAR_NAMESPACE][$name] = $value;
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

    /**
     * Set session lifespan
     *
     * @param int $lifeSpan
     */
    public static function setLifeSpan($lifeSpan)
    {
        $lifeSpan = (int) $lifeSpan;
        if ($lifeSpan < 0) {
            $lifeSpan = 0;
        }
        self::$lifeSpan = $lifeSpan;

        $_SESSION[self::GL_NAMESPACE][self::VAR_NAMESPACE]['expiresAt'] = time() + self::$lifeSpan;
        $args = session_get_cookie_params();
        $args['lifetime'] = self::$lifeSpan;
        session_set_cookie_params($args['lifetime'], $args['path'], $args['domain'], $args['secure'], $args['httponly']);
    }
}
