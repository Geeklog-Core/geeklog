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
        $sql = "SELECT * FROM {$_TABLES['routes']} WHERE method = {$method} ORDER BY priority ";
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

            if (preg_match_all('|/(@[a-z][0-9a-z_.-]*)|i', $rule, $matches, PREG_SET_ORDER)) {
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
                    COM_errorLog(__METHOD__ . ': matched with regx "' . $rule . '"');
                }

                header('Location: ' . $route);
            } else {
                if (strcasecmp($rule, $pathInfo) === 0) {
                    if ($routingType === self::ROUTING_WITH_INDEX_PHP) {
                        $route = $_CONF['site_url'] . $route;
                    }

                    if (self::$debug) {
                        COM_errorLog(__METHOD__ . ': matched with simple comparison "' . $rule . '"');
                    }

                    header('Location: ' . $route);
                }
            }
        }

        return false;
    }
}
