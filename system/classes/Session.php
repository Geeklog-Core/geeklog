<?php

namespace Geeklog;

/**
 * Class Session
 *
 * @package Geeklog
 */
abstract class Session
{
    // Index of $_SESSION value
    const GL_NAMESPACE = '__gl';
    const VAR_NAMESPACE = '__v';
    const FLASH_NAMESPACE = '__f';

    /**
     * @var array
     */
    private static $flashVars = [];

    /**
     * @var bool
     */
    private static $isInitialized = false;

    /**
     * Init the Session class
     *
     * @param array $options
     */
    public static function init(array $options = [])
    {
        if (self::$isInitialized) {
            return;
        }

        if (!session_start()) {
            die('Cannot start session.');
        }



        if (isset($_SESSION[self::GL_NAMESPACE][self::FLASH_NAMESPACE])) {
            self::$flashVars = $_SESSION[self::GL_NAMESPACE][self::FLASH_NAMESPACE];
        }

        self::$isInitialized = true;
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
}
