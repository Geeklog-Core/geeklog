<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | input.class.php                                                           |
// |                                                                           |
// | This file deals with input variables.                                     |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2015 by the following authors:                              |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

class GL_Input
{
    /**
     * @var    boolean    the current value of magic_quotes_gpc
     */
    private $magicQuotes = false;

    /**
     * @var    boolean    whether to apply basic filter
     */
    private $applyFilter = false;

    /**
     * Constructor
     *
     * Check the current value of magic_quotes_gpc
     *
     * @param    boolean    $useFilter    whether to apply basic filter to a returned value
     */
    public function __construct($useFilter = false)
    {
        $this->magicQuotes = (boolean) get_magic_quotes_gpc();
        $this->applyFilter = (boolean) $useFilter && is_callable('COM_applyBasicFilter');
    }

    /**
     * Remove an added slash if necessary
     *
     * @param     array|string    $value
     * @return    array|string
     */
    private function common($value)
    {
        if ($this->magicQuotes) {
            return is_array($value) ? array_map(__METHOD__, $value) : stripslashes($value);
        } else {
            return $value;
        }
    }

    /**
     * Apply basic filter if necessary
     *
     * @param     $value
     * @return    string
     */
    private function filter($value)
    {
        return $this->applyFilter ? COM_applyBasicFilter($value) : $value;
    }

    /**
     * Return the value of $_GET variable
     *
     * @param    string          $name            an index of $_GET
     * @param    string|array    $defaultValue
     * @return   array|null|string
     */
    public function get($name, $defaultValue = null)
    {
        return isset($_GET[$name]) ? $this->filter($this->common($_GET[$name])) : $defaultValue;
    }

    /**
     * Return the value of $_POST variable
     *
     * @param    string          $name            an index of $_POST
     * @param    string|array    $defaultValue
     * @return   array|null|string
     */
    public function post($name, $defaultValue = null)
    {
        return isset($_POST[$name]) ? $this->filter($this->common($_POST[$name])) : $defaultValue;
    }

    /**
     * Return the value of $_COOKIE variable
     *
     * @param    string          $name            an index of $_COOKIE
     * @param    string|array    $defaultValue
     * @return   array|null|string
     */
    public function cookie($name, $defaultValue = null)
    {
        return isset($_COOKIE[$name]) ? $this->filter($this->common($_COOKIE[$name])) : $defaultValue;
    }

    /**
     * Return the value of $_SERVER variable
     *
     * @param    string          $name            an index of $_SERVER
     * @param    string|array    $defaultValue
     * @return   array|null|string
     */
    public function server($name, $defaultValue = null)
    {
        return isset($_SERVER[$name]) ? $this->filter($_SERVER[$name]) : $defaultValue;
    }

    /**
     * Return the value of $_FILES variable
     *
     * @param    string          $name            an index of $_FILES
     * @param    string|array    $defaultValue
     * @return   array|null|string
     */
    public function files($name, $defaultValue = null)
    {
        return isset($_FILES[$name]) ? $this->filter($_FILES[$name]) : $defaultValue;
    }

    /**
     * Return the value of $_ENV variable
     *
     * @param    string          $name            an index of $_ENV
     * @param    string|array    $defaultValue
     * @return   array|null|string
     */
    public function env($name, $defaultValue = null)
    {
        return isset($_ENV[$name]) ? $this->filter($_ENV[$name]) : $defaultValue;
    }

    /**
     * Return the value of $_REQUEST variable
     *
     * @param    string          $name            an index of $_REQUEST
     * @param    string|array    $defaultValue
     * @return   array|null|string
     */
    public function request($name, $defaultValue = null)
    {
        return isset($_REQUEST[$name]) ? $this->filter($this->common($_REQUEST[$name])) : $defaultValue;
    }

    /**
     * Return the value of $_SESSION variable
     *
     * @param    string          $name            an index of $_SESSION
     * @param    string|array    $defaultValue
     * @return   array|null|string
     * @throws   Exception
     */
    public function session($name, $defaultValue = null)
    {
        if (session_id() === '') {
            throw new Exception('Session has not started yet');
        }

        return isset($_SESSION[$name]) ? $this->filter($_SESSION[$name]) : $defaultValue;
    }

    /**
     * Return the value of $_GET or $_POST variable depending on the current request method
     *
     * @param    string          $name            an index of $_GET or $_POST
     * @param    string|array    $defaultValue
     * @return   array|null|string
     */
    public function req($name, $defaultValue = null)
    {
        return ($this->server('REQUEST_METHOD', 'GET') === 'POST')
            ? $this->post($name, $defaultValue)
            : $this->get($name, $defaultValue);
    }
}
