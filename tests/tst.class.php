<?php

/**
* Configuration for PHPUnit tests
*/
class Tst
{
    // Default language
    const LANGUAGE = 'english';

    // Default theme
    const THEME = 'modern_curve';

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
    public static $public = __DIR__ . '/../public_html/';

    /**
     * path/to/geeklog/root
     */
    public static $root = __DIR__ . '/../';

    /**
     * path/to/tests
     */
    public static $tests = __DIR__ . '/../tests/';

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
        } else {
            $path = self::$root . 'system/' . $name ;
            /** @noinspection PhpIncludeInspection */
            @include_once $path;
        }
    }
}
