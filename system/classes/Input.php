<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | input.class.php                                                           |
// |                                                                           |
// | This file deals with input variables.                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2015-2019 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO        - mystralkk AT gmail DOT com                    |
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

namespace Geeklog;

use Exception;
use GLText;

/**
 * Class Input
 *
 * @package Geeklog
 * @since   v2.1.1
 */
class Input
{
    /**
     * @var bool
     */
    private static $initialized = false;

    /**
     * Initialize the Input class
     */
    public static function init()
    {
        if (!self::$initialized) {
            self::$initialized = true;
        }
    }

    /**
     * Apply a basic filter
     *
     * @param  string|array $var
     * @param  bool         $isNumeric
     * @return string|array
     */
    public static function applyFilter($var, $isNumeric = false)
    {
        if (is_array($var)) {
            return array_map(__METHOD__, $var);
        }

        if (is_callable('COM_applyBasicFilter')) {
            $var = COM_applyBasicFilter($var);
        } else {
            // Simulate COM_applyBasicFilter
            $var = GLText::remove4byteUtf8Chars($var);
            $var = GLText::stripTags($var);

            if (is_callable('COM_killJS')) {
                $var = COM_killJS($var); // doesn't help a lot right now, but still ...
            } else {
                $var = preg_replace('/(\s)+[oO][nN](\w*) ?=/', '\1in\2=', $var);
            }

            if ($isNumeric) {
                // Note: PHP's is_numeric() accepts values like 4e4 as numeric
                if (!is_numeric($var) || (preg_match('/^-?\d+$/', $var) == 0)) {
                    $var = 0;
                }
            } else {
                $var = preg_replace('/\/\*.*/', '', $var);
                $var = explode("'", $var);
                $var = explode('"', $var[0]);
                $var = explode('`', $var[0]);
                $var = explode(';', $var[0]);
                $var = explode(',', $var[0]);
                $var = explode('\\', $var[0]);
                $var = $var[0];
            }
        }

        return $var;
    }

    /**
     * Return the value of $_GET variable
     *
     * @param    string       $name an index of $_GET
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function get($name, $defaultValue = null)
    {
        return isset($_GET[$name]) ? $_GET[$name] : $defaultValue;
    }

    /**
     * Return the value of $_POST variable
     *
     * @param    string       $name an index of $_POST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function post($name, $defaultValue = null)
    {
        return isset($_POST[$name]) ? $_POST[$name] : $defaultValue;
    }

    /**
     * Return the value of $_COOKIE variable
     *
     * @param    string       $name an index of $_COOKIE
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function cookie($name, $defaultValue = null)
    {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $defaultValue;
    }

    /**
     * Return the value of $_SERVER variable
     *
     * @param    string       $name an index of $_SERVER
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function server($name, $defaultValue = null)
    {
        return isset($_SERVER[$name]) ? $_SERVER[$name] : $defaultValue;
    }

    /**
     * Return the value of $_FILES variable
     *
     * @param    string       $name an index of $_FILES
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function files($name, $defaultValue = null)
    {
        return isset($_FILES[$name]) ? $_FILES[$name] : $defaultValue;
    }

    /**
     * Return the value of $_ENV variable
     *
     * @param    string       $name an index of $_ENV
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function env($name, $defaultValue = null)
    {
        return isset($_ENV[$name]) ? $_ENV[$name] : $defaultValue;
    }

    /**
     * Return the value of $_REQUEST variable
     *
     * @param    string       $name an index of $_REQUEST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function request($name, $defaultValue = null)
    {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $defaultValue;
    }

    /**
     * Return the value of $_SESSION variable
     *
     * @param    string       $name an index of $_SESSION
     * @param    string|array $defaultValue
     * @return   array|null|string
     * @throws   Exception
     */
    public static function session($name, $defaultValue = null)
    {
        if (session_id() === '') {
            throw new Exception('Session has not started yet');
        }

        return isset($_SESSION[$name]) ? $_SESSION[$name] : $defaultValue;
    }

    /**
     * Return the value of $_GET or $_POST variable depending on the current request method
     *
     * @param    string       $name an index of $_GET or $_POST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function req($name, $defaultValue = null)
    {
        return (self::server('REQUEST_METHOD', 'GET') === 'POST')
            ? self::post($name, $defaultValue)
            : self::get($name, $defaultValue);
    }

    /**
     * Return the value of $_GET[$name] if it is set.  Otherwise return the value of $_POST[$name]
     *
     * @param    string       $name an index of $_GET or $_POST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function getOrPost($name, $defaultValue = null)
    {
        $retval = self::get($name, null);

        if ($retval === null) {
            $retval = self::post($name, $defaultValue);
        }

        return $retval;
    }

    /**
     * Return the value of $_POST[$name] if it is set.  Otherwise return the value of $_GET[$name]
     *
     * @param    string       $name an index of $_GET or $_POST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function postOrGet($name, $defaultValue = null)
    {
        $retval = self::post($name, null);

        if ($retval === null) {
            $retval = self::get($name, $defaultValue);
        }

        return $retval;
    }

    /**
     * Return the value of $_GET variable
     *
     * @param    string       $name an index of $_GET
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fGet($name, $defaultValue = null)
    {
        return isset($_GET[$name]) ? self::applyFilter(self::get($name)) : $defaultValue;
    }

    /**
     * Return the value of $_POST variable
     *
     * @param    string       $name an index of $_POST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fPost($name, $defaultValue = null)
    {
        return isset($_POST[$name]) ? self::applyFilter(self::post($name)) : $defaultValue;
    }

    /**
     * Return the value of $_COOKIE variable
     *
     * @param    string       $name an index of $_COOKIE
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fCookie($name, $defaultValue = null)
    {
        return isset($_COOKIE[$name]) ? self::applyFilter(self::cookie($name)) : $defaultValue;
    }

    /**
     * Return the value of $_SERVER variable
     *
     * @param    string       $name an index of $_SERVER
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fServer($name, $defaultValue = null)
    {
        return isset($_SERVER[$name]) ? self::applyFilter(self::server($name)) : $defaultValue;
    }

    /**
     * Return the value of $_FILES variable
     *
     * @param    string       $name an index of $_FILES
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fFiles($name, $defaultValue = null)
    {
        return isset($_FILES[$name]) ? self::applyFilter(self::files($name)) : $defaultValue;
    }

    /**
     * Return the value of $_ENV variable
     *
     * @param    string       $name an index of $_ENV
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fEnv($name, $defaultValue = null)
    {
        return isset($_ENV[$name]) ? self::applyFilter(self::env($name)) : $defaultValue;
    }

    /**
     * Return the value of $_REQUEST variable
     *
     * @param    string       $name an index of $_REQUEST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fRequest($name, $defaultValue = null)
    {
        return isset($_REQUEST[$name]) ? self::applyFilter(self::request($name)) : $defaultValue;
    }

    /**
     * Return the value of $_SESSION variable
     *
     * @param    string       $name an index of $_SESSION
     * @param    string|array $defaultValue
     * @return   array|null|string
     * @throws   Exception
     */
    public static function fSession($name, $defaultValue = null)
    {
        if (session_id() === '') {
            throw new Exception('Session has not started yet');
        }

        return isset($_SESSION[$name]) ? self::applyFilter(self::session($name)) : $defaultValue;
    }

    /**
     * Return the value of $_GET or $_POST variable depending on the current request method
     *
     * @param    string       $name an index of $_GET or $_POST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fReq($name, $defaultValue = null)
    {
        return (self::server('REQUEST_METHOD', 'GET') === 'POST')
            ? self::applyFilter(self::post($name, $defaultValue))
            : self::applyFilter(self::get($name, $defaultValue));
    }

    /**
     * Return the value of $_GET[$name] if it is set.  Otherwise return the value of $_POST[$name]
     *
     * @param    string       $name an index of $_GET or $_POST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fGetOrPost($name, $defaultValue = null)
    {
        $retval = self::fGet($name, null);

        if ($retval === null) {
            $retval = self::fPost($name, $defaultValue);
        }

        return $retval;
    }

    /**
     * Return the value of $_POST[$name] if it is set.  Otherwise return the value of $_GET[$name]
     *
     * @param    string       $name an index of $_GET or $_POST
     * @param    string|array $defaultValue
     * @return   array|null|string
     */
    public static function fPostOrGet($name, $defaultValue = null)
    {
        $retval = self::fPost($name, null);

        if ($retval === null) {
            $retval = self::fGet($name, $defaultValue);
        }

        return $retval;
    }
}
