<?php

/**
* Configuration and helper class for PHPUnit tests
*/
class Tst
{
    const DS = DIRECTORY_SEPARATOR;

    // Default language
    const LANGUAGE = 'english';

    // Default theme
    const THEME = 'modern_curve';

    // Geeklog version
    const VERSION = '2.2.0';

    // Database settings
    const DB_TYPE = 'mysql';
    const DB_HOST = 'localhost';
    const DB_USER = 'root';
    const DB_PASS = '';
    const DB_DATABASE = 'geeklog';
    const DB_PREFIX = 'gl_';

    /**
     * Permissions for suite. Each flag represents a feature that can be enabled.
     * 1 - Suite allows read operations (e.g: logs can be loaded in GUI)
     * 2 - Suite allows write operations (e.g: tests can be run, but no results viewed)
     * 3 - GUI is enabled
     */
    public static $access = array(1, 2, 3);

    /**
     * Message to display when feature is disabled in GUI
     */
    public static $disabledMessage = 'Sorry, this feature has been disabled.';

    /**
     * /path/to/public_html root
     */
    public static $public;

    /**
     * path/to/geeklog/root
     */
    public static $root;

    /**
     * path/to/tests
     */
    public static $tests;

    /**
     * Initialize the class
     */
    public static function init()
    {
        self::$root = dirname(__DIR__) . self::DS;
        self::$public = self::$root . self::DS . 'public_html' . self::DS;
        self::$tests = __DIR__ . self::DS;
    }

    /**
     * Return true if access level matches parameter provided, else returns false
     * e.g: if a function should have an enabled GUI and write privileges enabled to be used,
     * we would put the function inside 'if(Tst::access(array(2,3))) {'.
     *
     * @param    array $roles Roles to be checked
     * @param    int   $exit  (Optional) Whether to exit on failure
     * @return   bool         Returns true if all roles are allowed
     */
    public static function access($roles, $exit = 0)
    {
        $retval = true;

        foreach ($roles as $k => $role) {
            if (!in_array($role, self::$access)) {
                $retval = false;
                break;
            }
        }

        if (!$retval && $exit == 1) {
            exit();
        } else {
            return $retval;
        }
    }

    /**
     * Load a system library located in the system directory
     *
     * @param  string $name
     */
    public static function loadLibrary($name)
    {
        $name = strtolower($name);

        if (strpos($name, 'lib-') !== 0) {
            $name = 'lib-' . $name;
        }

        if (strpos($name, '.php') === false) {
            $name .= '.php';
        }

        if ($name === 'lib-common.php') {
            ob_start();
            /** @noinspection PhpIncludeInspection */
            @include_once self::$public . $name;
            @ob_end_clean();
        } else {
            $path = self::$root . 'system/' . $name ;
            /** @noinspection PhpIncludeInspection */
            @include_once $path;
        }
    }

    /**
     * Create a site configuration file
     *
     * @return bool
     */
    public static function createSiteConfigFile()
    {
        $version = self::VERSION;
        $content = <<<PHP
<?php

/*
 * Geeklog site configuration
 *
 * You should not need to edit this file. See the installation instructions
 * for details.
 *
 */

if (strpos(strtolower(\$_SERVER['PHP_SELF']), 'siteconfig.php') !== false) {
    die('This file can not be used on its own!');
}

global \$_CONF;

// To disable your site quickly, simply set this flag to false
\$_CONF['site_enabled'] = true;

// If you have errors on your site, can't login, or can't get to the
// config UI, then you can comment this in to set the root debug option
// on and get detailed error messages. You can set this to 'force' (which the
// Config UI won't allow you to do) to override hiding of password and cookie
// items in the debug trace.
//\$_CONF['rootdebug'] = true;

/**
 * Developer mode
 *
 * If you set this mode to true, detailed information will be displayed and/or logged.
 *
 * @var boolean
 * @since 2.1.2
 */
// \$_CONF['developer_mode'] = true;

\$_CONF['path'] = dirname(__DIR__) . '/';
\$_CONF['path_system'] = \$_CONF['path'] . 'system/';

\$_CONF['default_charset'] = 'utf-8';

\$_CONF_FCK['imagelibrary'] = '/images/library';

// Useful Stuff

if (!defined('LB')) {
  define('LB',"\n");
}
if (!defined('VERSION')) {
  define('VERSION', '{$version}');
}
PHP;

        return (@file_put_contents(self::$public . 'siteconfig.php', $content) !== false);
    }

    /**
     * Remove site configuration file
     *
     * @return bool
     */
    public static function removeSiteConfigFile()
    {
        return @unlink(self::$public . 'siteconfig.php');
    }

    /**
     * Create a database configuration file
     *
     * @param  string $type
     * @param  string $host
     * @param  string $database
     * @param  string $user
     * @param  string $pass
     * @param  string $prefix
     * @return bool
     */
    public static function createDbConfigFile($type = null, $host = null, $database = null, $user = null, $pass = null, $prefix = null)
    {
        if ($type === null) {
            $type = self::DB_TYPE;
        }

        if ($host === null) {
            $host = self::DB_HOST;
        }

        if ($database === null) {
            $database = self::DB_DATABASE;
        }

        if ($user === null) {
            $user = self::DB_USER;
        }

        if ($pass === null) {
            $pass = self::DB_PASS;
        }

        if ($prefix === null) {
            $prefix = self::DB_PREFIX;
        }

        $content = <<<PHP
<?php

/*
 * Geeklog database configuration
 *
 * You should not need to edit this file. See the installation instructions
 * for details.
 *
 */

if (strpos(strtolower(\$_SERVER['PHP_SELF']), 'db-config.php') !== false) {
    die('This file can not be used on its own!');
}

global \$_DB_host, \$_DB_name, \$_DB_user, \$_DB_pass, \$_DB_table_prefix, \$_DB_dbms;

\$_DB_host = '{$host}';
\$_DB_name = '{$database}';
\$_DB_user = '{$user}';
\$_DB_pass = '{$pass}';
\$_DB_table_prefix = '{$prefix}';
\$_DB_dbms = '{$type}';
PHP;

        return (@file_put_contents(self::$root . 'db-config.php', $content) !== false);
    }

    /**
     * Remove database configuration file
     *
     * @return bool
     */
    public static function removeDbConfigFile()
    {
        return @unlink(self::$root . 'db-config.php');
    }
}
