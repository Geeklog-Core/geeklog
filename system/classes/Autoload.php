<?php

namespace Geeklog;

/**
 * Class Autoload
 *
 * @package Geeklog
 */
class Autoload
{
    /**
     * @var bool
     */
    private static $initialized = false;

    /**
     * Load a class
     *
     * @param  string $className
     */
    public static function load($className)
    {
        if (!self::$initialized) {
            self::initialize();
        }

        if (class_exists($className, false)) {
            return;
        }

        if (strpos($className, 'Geeklog\\') === 0) {
            // New classes under \Geeklog namespace
            $className = str_replace('Geeklog\\', '', $className);
            $className = ucfirst($className);
            $path = __DIR__ . DIRECTORY_SEPARATOR . $className . '.php';

            if (file_exists($path)) {
                /** @noinspection PhpIncludeInspection */
                include $path;

                if (method_exists($className, 'init')) {
                    $className::init();
                }
            }
        } else {
            // Legacy Geeklog classes
            $path = __DIR__ . DIRECTORY_SEPARATOR . strtolower($className) . '.class.php';

            if (file_exists($path)) {
                /** @noinspection PhpIncludeInspection */
                include $path;
            } else {
                if (stripos($className, 'timerobject') === 0) {
                    include __DIR__ . '/timer.class.php';
                } elseif (stripos($className, 'XML_RPC_Server') === 0) {
                    include __DIR__ . '/XML/RPC/Server.php';
                } elseif (stripos($className, 'XML_RPC_') === 0) {
                    include __DIR__ . '/XML/RPC.php';
                } elseif (stripos($className, 'Date_TimeZone') === 0) {
                    include __DIR__ . '/Date/TimeZone.php';
                }
            }
        }
    }

    /**
     * Initialize autoloader
     */
    public static function initialize()
    {
        if (!self::$initialized) {
            require_once __DIR__ . '/../vendor/autoload.php';
            spl_autoload_register('Geeklog\\Autoload::load', true, true);
            self::$initialized = true;
        }
    }

    /**
     * Register an autoloader
     *
     * @param  callable $autoLoader
     * @param  bool     $throw
     * @param  bool     $prepend
     * @throws \InvalidArgumentException
     */
    public static function register($autoLoader, $throw = true, $prepend = false)
    {
        if (!self::$initialized) {
            self::initialize();
        }

        if (!is_callable($autoLoader)) {
            throw new \InvalidArgumentException(__METHOD__ . ': $autoLoader must be callable');
        }

        if (!spl_autoload_register($autoLoader, $throw, $prepend)) {
            throw new \InvalidArgumentException(__METHOD__ . ': could not register the autoloader function');
        }
    }
}
