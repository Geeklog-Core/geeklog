<?php

/**
 * Class Router
 */
class Router
{
    // HTTP request types
    const HTTP_REQUEST_GET = 1;
    const HTTP_REQUEST_POST = 2;
    const HTTP_REQUEST_PUT = 3;
    const HTTP_REQUEST_DELETE = 4;
    const HTTP_REQUEST_HEAD = 5;

    // Routing types
    const ROUTING_DISABLED = 0;
    const ROUTING_WITH_INDEX_PHP = 1;
    const ROUTING_WITHOUT_INDEX_PHP = 2;

    // Placeholder pattern
    const PATTERN_PLACEHOLDER = '|(@[a-zA-Z][0-9a-zA-Z_-]*)|';

    /**
     * @var bool
     */
    private static $debug = false;

    /**
     * Set debug mode
     *
     * @param bool $switch
     */
    public static function setDebug($switch)
    {
        self::$debug = (bool) $switch;
    }

    /**
     * Dispatch the client
     *
     * @return bool when not dispatched
     */
    public static function dispatch()
    {
        global $_CONF, $_TABLES;

        // URL rewrite is disabled
        if (!$_CONF['url_rewrite']) {
            return false;
        }

        // URL routing is not supported
        if (!isset($_CONF['url_routing'])) {
            return false;
        }

        $routingType = intval($_CONF['url_routing'], 10);

        // URL routing is disabled
        if ($routingType === self::ROUTING_DISABLED) {
            return false;
        } elseif (self::$debug) {
            COM_errorLog(__METHOD__ . ': routing type = ' . $routingType);
        }

        // $_SERVER['PATH_INFO'] is unavailable
        if (!isset($_SERVER['PATH_INFO']) || empty($_SERVER['PATH_INFO'])) {
            return false;
        }

        $pathInfo = COM_applyBasicFilter($_SERVER['PATH_INFO']);

        if (self::$debug) {
            COM_errorLog(__METHOD__ . ': PATH_INFO = ' . $pathInfo);
        }

        // Get request type
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $method = self::HTTP_REQUEST_GET;
                break;

            case 'POST':
                $method = self::HTTP_REQUEST_POST;
                break;

            case 'PUT':
                $method = self::HTTP_REQUEST_PUT;
                break;

            case 'DELETE':
                $method = self::HTTP_REQUEST_DELETE;
                break;

            case 'HEAD':
                $method = self::HTTP_REQUEST_HEAD;
                break;

            default:    // Unsupported method
                COM_errorLog(__METHOD__ . ': unknown HTTP request method "' . $_SERVER['REQUEST_METHOD'] . '" was supplied');

                return false;
        }

        // Get routing rules and routes from database
        $sql = "SELECT * FROM {$_TABLES['routes']} WHERE method = " . DB_escapeString($method) . " ORDER BY priority ";
        $result = DB_query($sql);

        if (DB_error()) {
            COM_errorLog(__METHOD__ . ': ' . DB_error());

            return false;
        }

        while (($A = DB_fetchArray($result, false)) !== false) {
            $rule = $A['rule'];
            $route = $A['route'];

            if (self::$debug) {
                COM_errorLog(__METHOD__ . ': rule = ' . $rule);
                COM_errorLog(__METHOD__ . ': route = ' . $route);
            }

            // Try simple comparison without placeholders
            if (strcasecmp($rule, $pathInfo) === 0) {
                if ($routingType === self::ROUTING_WITH_INDEX_PHP) {
                    $route = $_CONF['site_url'] . $route;
                }

                if (self::$debug) {
                    COM_errorLog(__METHOD__ . ': matched with simple comparison rule "' . $A['rule'] . '"');
                }

                header('Location: ' . $route);
            }

            // Try comparison with placeholders
            if (preg_match_all(self::PATTERN_PLACEHOLDER, $rule, $matches, PREG_SET_ORDER)) {
                $placeHolders = array();

                // Replace placeholders in a rule with ones for regular expressions
                foreach ($matches as $match) {
                    $placeHolders[] = $match[1];
                    $rule = str_ireplace($match[1], '([^/]+)', $rule);
                }

                $rule = '|' . $rule . '|i';

                if (!preg_match($rule, $pathInfo, $matches)) {
                    continue;
                }

                array_shift($matches);

                if (count($placeHolders) !== count($matches)) {
                    continue;
                }

                foreach ($matches as $match) {
                    $match = urlencode($match);
                    $placeHolder = array_shift($placeHolders);
                    $route = str_ireplace($placeHolder, $match, $route);
                }

                if ($routingType === self::ROUTING_WITH_INDEX_PHP) {
                    $route = $_CONF['site_url'] . $route;
                }

                if (self::$debug) {
                    COM_errorLog(__METHOD__ . ': matched with regular expression rule "' . $A['rule'] . '"');
                }

                header('Location: ' . $route);
            }
        }

        return false;
    }

    /**
     * Convert a URL
     * e.g. [SITE_URL]/article.php?story=welcome -> [SITE_URL]/index.php/article/welcome or [SITE_URL]/article/welcome
     *
     * @param  string $url
     * @param  int    $requestMethod
     * @return string
     */
    public static function convertUrl($url, $requestMethod = self::HTTP_REQUEST_GET)
    {
        global $_CONF, $_TABLES;

        // URL rewrite is disabled
        if (!$_CONF['url_rewrite']) {
            return $url;
        }

        // URL routing is not supported
        if (!isset($_CONF['url_routing'])) {
            return $url;
        }

        $routingType = intval($_CONF['url_routing'], 10);

        // URL routing is disabled
        if ($routingType === self::ROUTING_DISABLED) {
            return $url;
        } elseif (self::$debug) {
            COM_errorLog(__METHOD__ . ': routing type = ' . $routingType);
        }

        // Strip $url of $_CONF['site_url']
        $url = str_ireplace($_CONF['site_url'], '', $url);

        // Check for $requestMethod
        $requestMethod = intval($requestMethod, 10);

        if (($requestMethod < self::HTTP_REQUEST_GET) || ($requestMethod > self::HTTP_REQUEST_HEAD)) {
            COM_errorLog(__METHOD__ . ': unknown request method "' . $requestMethod . '" was given');

            return $url;
        }

        // Get routing rules and routes from database
        $sql = "SELECT * FROM {$_TABLES['routes']} WHERE method = " . DB_escapeString($requestMethod) . " ORDER BY priority ";
        $result = DB_query($sql);

        if (DB_error()) {
            COM_errorLog(__METHOD__ . ': ' . DB_error());

            return $url;
        }

        while (($A = DB_fetchArray($result, false)) !== false) {
            $rule = $A['rule'];
            $route = $A['route'];

            if (self::$debug) {
                COM_errorLog(__METHOD__ . ': rule = ' . $rule);
                COM_errorLog(__METHOD__ . ': route = ' . $route);
            }

            // Try simple comparison without placeholders
            if (strcasecmp($route, $url) === 0) {
                $retval = $rule;

                if ($routingType === self::ROUTING_WITH_INDEX_PHP) {
                    $retval = '/index.php' . $retval;
                }

                $retval = $_CONF['site_url'] . $retval;

                if (self::$debug) {
                    COM_errorLog(__METHOD__ . ': matched with simple comparison route "' . $A['route'] . '"');
                }

                return $retval;
            }

            // Try comparison with placeholders
            if (preg_match_all(self::PATTERN_PLACEHOLDER, $route, $matches, PREG_SET_ORDER)) {
                $placeHolders = array();

                // Replace placeholders in a route with ones for regular expressions
                foreach ($matches as $match) {
                    $placeHolders[] = $match[1];
                    $route = str_ireplace($match[1], '([^/]+)', $route);
                }

                // Escape a period and a question mark so that they can safely be used in a regular expression
                $route = str_replace(array('.', '?'), array('\.', '\?'), $route);
                $route = '|' . $route . '|';

                if (!preg_match($route, $url, $matches)) {
                    continue;
                }

                array_shift($matches);

                if (count($placeHolders) !== count($matches)) {
                    continue;
                }

                foreach ($matches as $match) {
                    $match = urlencode($match);
                    $placeHolder = array_shift($placeHolders);
                    $rule = str_ireplace($placeHolder, $match, $rule);
                }

                $retval = $rule;

                if ($routingType === self::ROUTING_WITH_INDEX_PHP) {
                    $retval = '/index.php' . $retval;
                }

                $retval = $_CONF['site_url'] . $retval;

                if (self::$debug) {
                    COM_errorLog(__METHOD__ . ': matched with regular expression rule "' . $A['route'] . '"');
                }

                return $retval;
            }
        }

        return $url;
    }
}
