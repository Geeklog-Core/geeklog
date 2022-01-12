<?php

// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | router.class.php                                                          |
// |                                                                           |
// | Geeklog homepage.                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2016-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Kenji ITO         - mystralkk AT gmail DOT com                   |
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
    const PLACEHOLDER_MATCH = '|(@[a-zA-Z][0-9a-zA-Z_]*)|';
    const PLACEHOLDER_REPLACE = '([^/&=?#]+)';

    // Values to escape pattern
    const VALUE_MATCH = '|[^0-9a-zA-Z_%.-]|';

    // Default HTTP status code
    const DEFAULT_STATUS_CODE = 200;

    // Default priority
    const DEFAULT_PRIORITY = 100;
    
    private static $route = '';

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
     * Store converted route so we can grab any variables later
     *
     */    
    public static function getRoute()
    {
        return self::$route;
    }    

    /**
     * Act as a proxy
     *
     * Fetch the content of the target URL and display it on behalf of the original controller
     *
     * @param  string $url
     */
    private static function proxy($url)
    {
        $request = new HTTP_Request2($url);

        // Add the current cookies.  Otherwise, session will be lost.
        foreach ($_COOKIE as $key => $value) {
            try {
                $request->addCookie(urlencode($key), urlencode($value));
            } catch (HTTP_Request2_LogicException $e) {
                COM_errorLog(__METHOD__ . ': invalid cookie detected. name = "' . $key . '" value = "' . $value . '"');
            }
        }

        try {
            $response = $request->send();
            $statusCode = (int) $response->getStatus();

            if ($statusCode === 200) {
                if (!headers_sent()) {
                    header('Content-Type: text/html; charset=' . COM_getCharset(), true, $statusCode);
                }

                echo $response->getBody();
            } elseif (($statusCode >= 300) && ($statusCode < 400)) {
                // e.g. public_html/links/portal.php
                $newLocation = $response->getHeader('Location');
                header('Location: ' . $newLocation, true, $statusCode);
            } else {
                throw new RuntimeException($response->getBody());
            }
        } catch (Exception $e) {
            COM_handle404();
        }

        // Never return to callee
        die();
    }

    /**
     * Dispatch the client based on $_SERVER['PATH_INFO']
     *
     * @return bool when not dispatched
     */
    public static function dispatch()
    {
        global $_CONF, $_TABLES, $LANG_ROUTER;

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
        }

        // Get $_SERVER['PATH_INFO']
        $pathInfo = Url::getPathInfo($_CONF['site_url']);
        if (empty($pathInfo) || ($pathInfo === '/')) {
            return false;
        }

        $pathInfo = COM_applyBasicFilter($pathInfo);
        // Note: For URL Routing with no "Index.php" and when Geeklog site url has a sub directory the rules in the Route Manager
        // need to be updated to include the sub directory in the rule part only (not the route).
        // At some point we should look into striping the sub directory from the pathinfo for this case only instead of having the Admins do 
        // this extra step so that the path and rule will match when needed below in the loop

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
        $sql = "SELECT * FROM {$_TABLES['routes']} WHERE method = " . DB_escapeString($method) . " and enabled = 1 ORDER BY priority ";
        $result = DB_query($sql);

        if (DB_error()) {
            COM_errorLog(__METHOD__ . ': ' . DB_error());

            return false;
        }

        while (($A = DB_fetchArray($result, false)) !== false) {
            $rule = $A['rule'];
            $route = $A['route'];

            // HTTP response code since v2.2.0
            $responseCode = isset($A['status_code']) ? (int) $A['status_code'] : self::DEFAULT_STATUS_CODE;

            // Try simple comparison without placeholders
            if (strcasecmp($rule, $pathInfo) === 0) {
                $route = $_CONF['site_url'] . $route;

                if (self::$debug) {
                    COM_errorLog(__METHOD__ . ': "' . $pathInfo . '"matched with simple comparison rule "' . $A['rule'] . '", converted into "' . $route . '"');
                }

                if ($responseCode === 200) {
                    self::$route = $route; // Store converted route for later to retrieve URL variables
                    $path = preg_replace('/\?.*/', '', $A['route']);
                    // If returning to where router dispatch is called from (like for topic routing), then just return
                    if ($path == '/index.php') {
                        return;
                    } else {
                        // Let's load in the required file
                        require_once $_CONF['path_html'] . $path;
                    }
                    //self::proxy($route); // old way that used a redirect which causes the page to basically load twice. See issue #945
                    die();
                } else {
                    header('Location: ' . $route, $responseCode);
                }

                COM_errorLog(__METHOD__ . ': somehow could not redirect');

                return false;
            }

            // Try comparison with placeholders
            if (preg_match_all(self::PLACEHOLDER_MATCH, $rule, $matches, PREG_SET_ORDER)) {
                // Escape a period and a question mark so that they can safely be used in a regular expression
                $rule = str_replace(array('.', '?'), array('\.', '\?'), $rule);
                $placeHolders = array();

                // Replace placeholders in a rule with ones for regular expressions
                foreach ($matches as $match) {
                    $placeHolders[] = $match[1];
                    $rule = str_replace($match[1], self::PLACEHOLDER_REPLACE, $rule);
                }

                $rule = '|\A' . $rule . '\z|i';

                if (!preg_match($rule, $pathInfo, $values)) {
                    continue;
                }

                array_shift($values);

                foreach ($values as $value) {
                    if (preg_match(self::VALUE_MATCH, $value)) {
                        $value = urlencode($value);
                    }

                    $placeHolder = array_shift($placeHolders);
                    $route = str_replace($placeHolder, $value, $route);
                }

                if ((strpos($route, '@') !== false) && self::$debug) {
                    COM_errorLog(
                        sprintf(
                            '%s: %s. Rule (rid = %d) = %s, Route = %s',
                            __METHOD__, @$LANG_ROUTER[15], $A['rid'], $A['rule'], $A['route']
                        )
                    );
                    continue;
                }

                $route = $_CONF['site_url'] . $route;

                if (self::$debug) {
                    COM_errorLog(__METHOD__ . ': "' . $pathInfo . '" matched with regular expression rule "' . $A['rule'] . '", converted into "' . $route . '"');
                }

                if ($responseCode === 200) {
                    self::$route = $route; // Store converted route for later to retrieve URL variables
                    $path = preg_replace('/\?.*/', '', $A['route']);
                    // If returning to where router dispatch is called from (like for topic routing), then just return
                    if ($path == '/index.php') {
                        return;
                    } else {
                        // Lets load in the required file
                        require_once $_CONF['path_html'] . $path;
                    }
                    //self::proxy($route); // old way that used a redirect which causes the page to basically load twice. See issue #945
                    die();
                } else {
                    header('Location: ' . $route, $responseCode);
                }
            }
        }

        // when URL routing is enabled but no rules for topics have matched the pathinfo,
        // redirect to [site_url]/index.php/topic/{topic_id}
        if (stripos($pathInfo, '/topic/') === 0) {
            $url = $_CONF['site_url'] . '/index.php?topic=' . substr($pathInfo, strlen('/topic/'));
            header('Location: ' . $url);
        }

        return false;
    }

    /**
     * Convert a URL
     *
     * e.g. [SITE_URL]/article.php?story=welcome
     *   -> [SITE_URL]/index.php/article/welcome or [SITE_URL]/article/welcome
     *
     * @param  string $url
     * @param  int    $requestMethod
     * @return string
     */
    public static function convertUrl($url, $requestMethod = self::HTTP_REQUEST_GET)
    {
        global $_CONF, $_TABLES, $LANG_ROUTER;

        $originalUrl = $url;

        // URL rewriting is disabled
        if (!$_CONF['url_rewrite']) {
            return $originalUrl;
        }

        // URL routing is not supported
        if (!isset($_CONF['url_routing'])) {
            return $originalUrl;
        }

        $routingType = intval($_CONF['url_routing'], 10);

        // URL routing is disabled
        if ($routingType === self::ROUTING_DISABLED) {
            return $originalUrl;
        }

        // Strip $url of $_CONF['site_url']
        $url = str_ireplace($_CONF['site_url'], '', $url);

        // Check for $requestMethod
        $requestMethod = intval($requestMethod, 10);

        if (($requestMethod < self::HTTP_REQUEST_GET) || ($requestMethod > self::HTTP_REQUEST_HEAD)) {
            COM_errorLog(__METHOD__ . ': unknown request method "' . $requestMethod . '" was given');

            return $originalUrl;
        }

        // Get routing rules and routes from database
        $sql = "SELECT * FROM {$_TABLES['routes']} WHERE method = " . DB_escapeString($requestMethod) . " AND enabled = 1 ORDER BY priority ";
        $result = DB_query($sql);

        if (DB_error()) {
            COM_errorLog(__METHOD__ . ': ' . DB_error());

            return $originalUrl;
        }

        $url = str_replace('&amp;', '&', $url);
        $path = $url;

        while (($A = DB_fetchArray($result, false)) !== false) {
            $url = $path;
            $rule = $A['rule'];
            $route = $A['route'];

            // Try simple comparison without placeholders
            if (strcasecmp($route, $url) === 0) {
                if ((int) $A['status_code'] !== 200) {
                    continue;
                }

                $retval = $rule;
                $retval = str_replace('&', '&amp;', $retval);

                if ($routingType === self::ROUTING_WITH_INDEX_PHP) {
                    $retval = '/index.php' . $retval;
                }

                $retval = $_CONF['site_url'] . $retval;

                if (self::$debug) {
                    COM_errorLog(__METHOD__ . ': "' . $originalUrl . '" matched with simple comparison route "' . $A['route'] . '"');
                }

                return $retval;
            }

            // Try comparison with placeholders
            if (preg_match_all(self::PLACEHOLDER_MATCH, $route, $matches, PREG_SET_ORDER)) {
                $placeHolders = array();

                // Escape '.', '?' and '+' in the route so that they can safely be used in a regular expression
                $route = str_replace(array('.', '?', '+'), array('\.', '\?', '\+'), $route);

                // Replace placeholders in a route with ones for regular expressions
                foreach ($matches as $match) {
                    $placeHolders[] = $match[1];
                    $route = str_replace($match[1], self::PLACEHOLDER_REPLACE, $route);
                }

                $route = '|\A' . $route . '\z|i';

                if (!preg_match($route, $url, $values)) {
                    continue;
                }

                array_shift($values);

                foreach ($values as $value) {
                    if (preg_match(self::VALUE_MATCH, $value)) {
                        $value = urlencode($value);
                    }

                    $placeHolder = array_shift($placeHolders);
                    $rule = str_replace($placeHolder, $value, $rule);
                }

                if ((strpos($rule, '@') !== false) && self::$debug) {
                    COM_errorLog(
                        sprintf(
                            '%s: %s. Rule (rid = %d) = %s, Route = %s',
                            __METHOD__, @$LANG_ROUTER[15], $A['rid'], $A['rule'], $A['route']
                        )
                    );
                    continue;
                }

                $retval = $rule;
                $retval = str_replace('&', '&amp;', $retval);

                if ($routingType === self::ROUTING_WITH_INDEX_PHP) {
                    $retval = '/index.php' . $retval;
                }

                $retval = $_CONF['site_url'] . $retval;

                if (self::$debug) {
                    COM_errorLog(__METHOD__ . ': "' . $originalUrl . '" matched with regular expression rule "' . $A['route'] . '", converted into "' . $retval . '"');
                }

                return $retval;
            }
        }

        return $originalUrl;
    }
}
