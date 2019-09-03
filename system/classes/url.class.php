<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | url.class.php                                                             |
// |                                                                           |
// | class to allow for spider friendly URL's                                  |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
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
 * This class will allow you to use friendlier URL's, like:
 * http://www.example.com/index.php/arg_value_1/arg_value_2/ instead of
 * uglier http://www.example.com?arg1=value1&arg2=value2.
 * NOTE: this does not currently work under windows as there is a well documented
 * bug with IIS and PATH_INFO.  Not sure yet if this will work with windows under
 * apache.  This was built so you could use this class and just disable it
 * if you are an IIS user.
 *
 * @author       Tony Bibbs <tony@tonybibbs.com>
 */
class Url
{
    /**
     * @var array
     */
    private $originalArguments = array();

    /**
     * @var array
     */
    private $arguments = array();  // Array of argument names

    /**
     * @var bool
     */
    private $urlRewrite = true;

    /**
     * @var int
     */
    private $urlRouting;

    /**
     * Constructor
     *
     * @param  bool $urlRewrite whether rewriting is enabled
     * @param  int  $urlRouting URL routing mode, see Router class
     */
    public function __construct($urlRewrite = true, $urlRouting = Router::ROUTING_DISABLED)
    {
        $this->urlRewrite = (bool) $urlRewrite;
        $urlRouting = (int) $urlRouting;

        if (($urlRouting >= Router::ROUTING_DISABLED) && ($urlRouting <= Router::ROUTING_WITHOUT_INDEX_PHP)) {
            $this->urlRouting = $urlRouting;
        } else {
            $this->urlRouting = Router::ROUTING_DISABLED;
        }

        $this->arguments = array();

        if ($this->urlRewrite) {
            $this->getArguments();

            // Cache $this->arguments for later use
            $this->originalArguments = $this->arguments;
        }
    }

    /**
     * Returns the number of variables found in query string
     * This is particularly useful just before calling setArgNames() method
     *
     * @return   int     Number of arguments found in URL
     */
    public function numArguments()
    {
        return count($this->arguments);
    }

    /**
     * Assigns logical names to query string variables
     *
     * @param        array $names String array of names to assign to variables pulled from query string
     * @return       boolean     true on success otherwise false
     */
    public function setArgNames(array $names)
    {
        if ($this->urlRewrite) {
            if ($this->urlRouting) {
                // Grab converted orginal route url from router class and then parse query string into array
                parse_str( parse_url(Router::getRoute(), PHP_URL_QUERY), $this->arguments);
            } else {
                $this->arguments = $this->originalArguments;
                
                $newArray = array();

                foreach ($names as $name) {
                    $newArray[$name] = array_shift($this->arguments);
                }

                $this->arguments = $newArray;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Gets the value for an argument
     *
     * @param        string $name Name of argument to fetch value for
     * @return       mixed       returns value for a given argument
     */
    public function getArgument($name)
    {
        // if in GET VARS array return it
        if (!empty($_GET[$name])) {
            return Geeklog\Input::get($name);
        }

        // Added for IIS 7 to work in FastCGI mode
        // if in REQUEST VARS array return it
        if (!empty($_REQUEST[$name])) {
            return Geeklog\Input::request($name);
        }
        // end of add

        // ok, pull from query string
        if (in_array($name, array_keys($this->arguments))) {
            return $this->arguments[$name];
        }

        return '';
    }

    /**
     * Builds crawler friendly URL if URL rewriting is enabled
     * This function will attempt to build a crawler friendly URL.  If this feature is
     * disabled because of platform issue it just returns original $url value
     *
     * @param  string $url URL to try and convert
     * @return string      rewritten if $this->urlRewrite is true otherwise original url
     */
    public function buildURL($url)
    {
        if (!$this->urlRewrite) {
            return $url;
        }

        if (($this->urlRouting === Router::ROUTING_WITH_INDEX_PHP) ||
            ($this->urlRouting === Router::ROUTING_WITHOUT_INDEX_PHP)
        ) {
            $newUrl = Router::convertUrl($url);

            if ($newUrl !== $url) {
                return $newUrl;
            }
        }

        $pos = strpos($url, '?');
        $query_string = substr($url, $pos + 1);
        $finalList = array();
        $paramList = explode('&', $query_string);

        for ($i = 1; $i <= count($paramList); $i++) {
            $keyValuePairs = explode('=', current($paramList));
            if (is_array($keyValuePairs)) {
                $argName = current($keyValuePairs);
                next($keyValuePairs);
                $finalList[$argName] = current($keyValuePairs);
            }

            next($paramList);
        }

        $newArgs = '/';

        for ($i = 1; $i <= count($finalList); $i++) {
            $newArgs .= current($finalList);

            if ($i !== count($finalList)) {
                $newArgs .= '/';
            }

            next($finalList);
        }

        return str_replace('?' . $query_string, $newArgs, $url);
    }

    /**
     * Grabs any variables from the query string
     */
    private function getArguments()
    {
        global $_CONF;
        
        if ($this->urlRouting === Router::ROUTING_WITHOUT_INDEX_PHP) {
            $check_for_dirs = true;
        } else{
            $check_for_dirs = false;
        }
        
        if (isset($_SERVER['PATH_INFO'])) {
            if ($_SERVER['PATH_INFO'] == '') {
                if (isset($_ENV['ORIG_PATH_INFO'])) {
                    $this->arguments = explode('/', $_ENV['ORIG_PATH_INFO']);
                    $check_for_dirs = true;
                } else {
                    $this->arguments = array();
                }
            } else {
                $this->arguments = explode('/', $_SERVER['PATH_INFO']);
            }
            array_shift($this->arguments);
        } elseif (isset($_ENV['ORIG_PATH_INFO'])) {
            $this->arguments = explode('/', substr($_ENV['ORIG_PATH_INFO'], 1));
            $check_for_dirs = true;
        } elseif (isset($_SERVER['ORIG_PATH_INFO'])) {
            $this->arguments = explode('/', substr($_SERVER['ORIG_PATH_INFO'], 1));
            $check_for_dirs = true;

            // Added for IIS 7 to work in FastCGI mode
            array_shift($this->arguments);
            if (isset($this->arguments[0]) AND $this->arguments[0] == substr($_SERVER['SCRIPT_NAME'], 1)) {
                array_shift($this->arguments);
            }
            // end of add
        } else {
            $this->arguments = array();
        }
        
        // For when Routing enabled - Deal with site_url if it has directories in it. These are not arguments so we need to add extra array shifts
        // For Routing with ROUTING_WITH_INDEX_PHP - Only ORIG_PATH_INFO variables contains these directories
        // For Routing with ROUTING_WITHOUT_INDEX_PHP - Both PATH_INFO and ORIG_PATH_INFO variables contains these directories
        // So add extra array_shifts if needed
        if ($this->urlRouting) {
            $url_path = parse_url($_CONF['site_url'], PHP_URL_PATH);
            if (!empty($url_path) AND $check_for_dirs) {
                $url_dir = explode('/', $url_path);
                $num_url_dir = count($url_dir);
                for ($i = 1; $i <= $num_url_dir; $i++) {
                    array_shift($this->arguments);
                }
            }
        }
    }

    /**
     * Return if URL rewrite feature is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->urlRewrite;
    }

    /**
     * Enable/Disable URL rewrite feature
     *
     * @param  bool $switch
     */
    public function setEnabled($switch)
    {
        $this->urlRewrite = (bool) $switch;
    }
}
