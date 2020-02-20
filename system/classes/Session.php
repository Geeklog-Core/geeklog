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
    const NS_VAR_ONCE = '__o';

    // Default session name
    const DEFAULT_SESSION_NAME = 'GLSESSION';

    // Anonymous user ID
    const ANON_USER_ID = 1;

    /**
     * The flag to show if the class is initialized
     *
     * @var bool
     */
    private static $isInitialized = false;

    /**
     * The flag to show if the debug mode is on
     *
     * @var bool
     */
    private static $isDebug = false;

    /**
     * The flag to show if the session is enabled
     *
     * @var bool
     */
    private static $isEnabled = false;

    /**
     * The flag to show if the session has started
     *
     * @var bool
     */
    private static $isSessionHasStarted = false;

    /**
     * Log function
     *
     * @var callable
     */
    private static $logFunction;

    /**
     * "flash", i.e., one-time session variables
     *
     * @var array
     */
    private static $flashVars = [];

    /**
     * Init the Session class
     *
     * @param  array  $config
     * @return bool   whether the session cookie already exists
     */
    public static function init(array $config)
    {
        if (self::$isDebug) {
            self::log(__METHOD__ . ': started');
        }

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
            ini_set('session.cookie_lifetime', 0); // Set to 0 so cookie is deleted if browser is closed
            // This gc_maxlifetime setting is just to prevent PHP Session handler from deleting the session data file to early on the server.
            // Expired Sessions are only deleted by the PHP garbage collector but it is only started with a probability as it is expensive to run
            // With that session handler, the age of the session data is calculated on the file's last modification date and not the last access date
            // The main date that will expire a session is the Geeklog recorded one in the sessions table and the users session cookie expiry date
            ini_set('session.gc_maxlifetime', $config['cookie_lifetime']);
        }

        // Set debug mode
        self::setDebug(isset($config['debug']) && $config['debug']);

        // Set session cookie parameters
        self::setSessionCookieParameters($config);

        // Set logger
        if (isset($config['logger']) && is_callable($config['logger'])) {
            self::$logFunction = $config['logger'];
        }

        if (isset($config['cookie_disabled']) && $config['cookie_disabled']) {
            return false;
        }

        self::enable();
        if (!self::start()) {
            return false;
        }

        // Initialize the $_SESSION var if this is the first visit to the site
        if (!isset($_SESSION[self::NS_GL]) ||
            !isset($_SESSION[self::NS_GL][self::NS_FLASH_VAR]) ||
            !is_array($_SESSION[self::NS_GL][self::NS_FLASH_VAR]) ||
            !isset($_SESSION[self::NS_GL][self::NS_VAR]) ||
            !is_array($_SESSION[self::NS_GL][self::NS_VAR]) ||
            !isset($_SESSION[self::NS_GL][self::NS_VAR]['uid']) ||
            !is_int($_SESSION[self::NS_GL][self::NS_VAR]['uid']) ||
            ($_SESSION[self::NS_GL][self::NS_VAR]['uid'] < self::ANON_USER_ID) ||
            !isset($_SESSION[self::NS_GL][self::NS_VAR_ONCE]) ||
            !is_array($_SESSION[self::NS_GL][self::NS_VAR_ONCE])
        ) {
            $_SESSION[self::NS_GL] = [
                self::NS_FLASH_VAR => [],
                self::NS_VAR       => [
                    'uid' => self::ANON_USER_ID,
                ],
                self::NS_VAR_ONCE  => [],
            ];
            $retval = false;
        }

        // Move "flash" session vars to the property of the class
        self::$flashVars = $_SESSION[self::NS_GL][self::NS_FLASH_VAR];
        $_SESSION[self::NS_GL][self::NS_FLASH_VAR] = [];

        // Finish initialization
        self::$isInitialized = true;
        if (self::$isDebug) {
            self::log(__METHOD__ . ': finished');
        }

        return $retval;
    }

    /**
     * Set debug mode
     *
     * @param  bool  $switch
     */
    public static function setDebug($switch)
    {
        self::$isDebug = (bool) $switch;
    }

    /**
     * Return if session is enabled
     *
     * @return bool
     */
    public static function isEnabled()
    {
        if (self::$isDebug) {
            self::log(__METHOD__ . ': ' . (self::$isEnabled ? 'true' : 'false'));
        }

        return self::$isEnabled;
    }

    /**
     * Disable session
     */
    public static function disable()
    {
        self::$isEnabled = false;

        if (self::$isDebug) {
            self::log(__METHOD__ . ' was called.');
        }
    }

    /**
     * Enable session
     */
    public static function enable()
    {
        self::$isEnabled = true;

        if (self::$isDebug) {
            self::log(__METHOD__ . ' was called.');
        }
    }

    /**
     * Check if session is enabled and has started normally
     *
     * @return bool
     */
    private static function check()
    {
        $retval = false;
        $msg = '';

        if (self::$isEnabled) {
            if (self::$isSessionHasStarted) {
                if (self::$isDebug) {
                    $msg = 'session is valid.';
                }

                $retval = true;
            } else {
                if (self::$isDebug) {
                    $msg = 'session has not started yet.';
                }
            }
        } else {
            $msg = 'session is disabled.';
        }

        if (self::$isDebug) {
            self::log(__METHOD__ . ': ' . $msg);
        }

        return $retval;
    }

    /**
     * Log an entry
     *
     * @param  string  $entry
     */
    private static function log($entry)
    {
        $f = self::$logFunction;

        if (is_callable($f)) {
            $f($entry);
        }
    }

    /**
     * Start a new session
     *
     * @return  bool  true if session started successfully, false otherwise
     */
    public static function start()
    {
        if (!self::$isEnabled) {
            if (self::$isDebug) {
                self::log(__METHOD__ . ': session is disabled.');
            }

            return false;
        }

        if (self::$isSessionHasStarted) {
            if (self::$isDebug) {
                self::log(__METHOD__ . ': session has already started.');
            }

            return true;
        }

        // Start a new session
        self::$isSessionHasStarted = session_start();
        if (!self::$isSessionHasStarted) {
            self::disable();
            self::log(__METHOD__ . ': Cannot start a new session.  Session was disabled.');
        } else {
            if (self::$isDebug) {
                self::log(__METHOD__ . ': session has successfully started.');
            }
        }

        return self::$isSessionHasStarted;
    }

    /**
     * Close the current session. 
     * Note: No more session variable changes. Used when we need to unlock the session file
     *      for another process to access (like when a user needs to re authenticate using the same session)
     *
     * @return  bool  true on success, false otherwise
     */
    public static function close()
    {
        return session_write_close(); // Write session data and close session (does not destroy)


    }
    /**
     * End the current session
     *
     * @return  bool  true on success, false otherwise
     */
    public static function end()
    {
        if (!self::$isEnabled) {
            if (self::$isDebug) {
                self::log(__METHOD__ . ': session is disabled.');
            }

            return false;
        }

        if (!self::$isSessionHasStarted) {
            if (self::$isDebug) {
                self::log(__METHOD__ . ': session has not started.');
            }

            return true;
        }

        // just had session_write_close before. Apparently need all 3 to be compatible with all browsers
        session_unset(); // Free all session variables
        session_destroy(); // Destroys all data registered to a session
        session_write_close(); // Write session data and end session
        self::$isSessionHasStarted = false;

        if (self::$isDebug) {
            self::log(__METHOD__ . ': session has successfully ended.');
        }

        return true;
    }

    /**
     * Return if the current user is logged in to the site
     *
     * @return bool
     */
    public static function isLoggedIn()
    {
        if (self::check()) {
            $retval = (self::getUid() > self::ANON_USER_ID);
        } else {
            $retval = false;
        }

        // Debug info
        if (self::$isDebug) {
            self::log(__METHOD__ . ': login status = ' . ($retval ? 'true' : 'false'));
        }

        return $retval;
    }

    /**
     * Return the current user id
     *
     * @return int
     */
    public static function getUid()
    {
        if (self::check()) {
            $retval = $_SESSION[self::NS_GL][self::NS_VAR]['uid'];
        } else {
            $retval = self::ANON_USER_ID;
        }

        // Debug info
        if (self::$isDebug) {
            self::log(sprintf(__METHOD__ . ': uid = %d', $retval));
        }

        return $retval;
    }

    /**
     * Set the current user id
     *
     * @param  int  $uid
     * @throws InvalidArgumentException
     */
    public static function setUid($uid)
    {
        if (self::check()) {
            $uid = (int) $uid;
            $msg = 'uid = ' . $uid;

            if ($uid >= self::ANON_USER_ID) {
                $_SESSION[self::NS_GL][self::NS_VAR]['uid'] = $uid;
            } else {
                throw new InvalidArgumentException('User id must be ' . self::ANON_USER_ID . ' or greater.');
            }
        } else {
            $msg = '(skipped)';
        }

        // Debug info
        if (self::$isDebug) {
            self::log(__METHOD__ . ': ' . $msg);
        }
    }

    /**
     * Common method for setting a session variable
     *
     * @param  string  $name
     * @param  mixed   $value
     * @param  string  $type
     */
    private static function setVarCommon($name, $value, $type)
    {
        if (self::check()) {
            if ($type === 'normal') {
                $_SESSION[self::NS_GL][self::NS_VAR][$name] = $value;
            } elseif ($type === 'once') {
                $_SESSION[self::NS_GL][self::NS_VAR_ONCE][$name] = $value;
            } else {
                $_SESSION[self::NS_GL][self::NS_FLASH_VAR][$name] = $value;
            }

            if (is_array($value)) {
                ob_start();
                var_dump($value);
                $value = ob_get_clean();
            }

            $msg = sprintf('name = %s, type = %s, value = %s', $name, $type, $value);
        } else {
            $msg = '(skipped)';
        }

        // Debug info
        if (self::$isDebug) {
            self::log(__METHOD__ . ': ' . $msg);
        }
    }

    /**
     * Set a session variable
     *
     * This method sets a variable which persists between sessions.
     *
     * @param  string  $name
     * @param  mixed   $value
     */
    public static function setVar($name, $value)
    {
        self::setVarCommon($name, $value, 'normal');
    }

    /**
     * Set a "flash" session variable
     *
     * This method sets a variable which will be automatically deleted after the new page is loaded.
     *
     * @param  string  $name
     * @param  mixed   $value
     */
    public static function setFlashVar($name, $value)
    {
        self::setVarCommon($name, $value, 'flash');
    }

    /**
     * Set a one-time session variable
     *
     * This method sets a variable which persists between sessions but will be automatically deleted after it is read
     * once.
     *
     * @param  string  $name
     * @param  mixed   $value
     */
    public static function setVarOnce($name, $value)
    {
        self::setVarCommon($name, $value, 'once');
    }

    /**
     * Common method to get a session variable
     *
     * @param  string  $name
     * @param  mixed   $defaultValue
     * @param  string  $type
     * @return mixed
     */
    private static function getVarCommon($name, $defaultValue = null, $type = 'normal')
    {
        if (self::check()) {
            if ($type === 'normal') {
                $retval = isset($_SESSION[self::NS_GL][self::NS_VAR][$name])
                    ? $_SESSION[self::NS_GL][self::NS_VAR][$name]
                    : $defaultValue;
            } elseif ($type === 'once') {
                $retval = isset($_SESSION[self::NS_GL][self::NS_VAR_ONCE][$name])
                    ? $_SESSION[self::NS_GL][self::NS_VAR_ONCE][$name]
                    : $defaultValue;
                unset($_SESSION[self::NS_GL][self::NS_VAR_ONCE][$name]);
            } else {
                $retval = isset($_SESSION[self::NS_GL][self::NS_FLASH_VAR][$name])
                    ? $_SESSION[self::NS_GL][self::NS_FLASH_VAR][$name]
                    : $defaultValue;
            }
        } else {
            $retval = $defaultValue;
        }

        // Debug info
        if (self::$isDebug) {
            if (is_array($retval)) {
                ob_start();
                var_dump($retval);
                $value = ob_get_clean();
            } else {
                $value = $retval;
            }

            self::log(sprintf(__METHOD__ . ': name = "%s", value = "%s"', $name, $value));
        }

        return $retval;
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
        return self::getVarCommon($name, $defaultValue, 'normal');
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
        return self::getVarCommon($name, $defaultValue, 'flash');
    }

    /**
     * Get a one-time session variable
     *
     * @param  string  $name
     * @param  mixed   $defaultValue
     * @return mixed
     * @see Session::setVarOnce()
     */
    public static function getVarOnce($name, $defaultValue = null)
    {
        return self::getVarCommon($name, $defaultValue, 'once');
    }

    /**
     * Unset a session variable
     *
     * @param  string  $name
     */
    public static function unsetVar($name)
    {
        if (self::check()) {
            unset($_SESSION[self::NS_GL][self::NS_VAR][$name]);
            $msg = sprintf('name = %s', $name);
        } else {
            $msg = '(skipped)';
        }

        // Debug info
        if (self::$isDebug) {
            self::log(__METHOD__ . ': ' . $msg);
        }
    }

    /**
     * Regenerate the session id
     *
     * @return string the new session id
     */
    public static function regenerateId()
    {
        // Debug info
        if (self::$isDebug) {
            self::log(__METHOD__ . ' was called');
        }

        if (self::check()) {
            session_regenerate_id(false);

            return self::getSessionId();
        } else {
            return null;
        }
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

        // Debug info
        if (self::$isDebug) {
            self::log(sprintf(
                __METHOD__ . ': lifetime = %d, path = %s, domain = %s, secure = %s, httponly = %s',
                $args['lifetime'], $args['path'], $args['domain'], ($args['secure'] ? 'true' : 'false'),
                ($args['httponly'] ? 'true' : 'false')
            ));
            self::log(sprintf(__METHOD__ . ': session name = %s', $config['session_name']));
        }
    }

    /**
     * Return the current session id
     *
     * @return string
     */
    public static function getSessionId()
    {
        $retval = self::check() ? session_id() : '';

        // Debug info
        if (self::$isDebug) {
            self::log(sprintf(__METHOD__ . ': session id = %s', $retval));
        }

        return $retval;
    }
}
