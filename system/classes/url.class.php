<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | url.class.php                                                             |
// | class to allow for spider friendly URL's                                  |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002 by the following authors:                              |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
// |                                                                           |
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
//
// $Id: url.class.php,v 1.6 2003/07/14 10:10:42 dhaun Exp $

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
*
*/
class url {
    /**
    * @access private
    */
    var $_arguments = array();		// Array of argument names
    /**
    * @access private
    */
    var $_enabled = true;
    
    /**
    * Constructor
    *
    * @param        boolean     $enabled    whether rewriting is enabled
    *
    */
    function url($enabled=true)
    {
        $this->setEnabled($enabled);
        $this->_arguments = array();
        if ($this->_enabled) {
            $this->_getArguments();
        }
    }

    /**
    * Grabs any variables from the query string
    *
    * @access   private
    */
    function _getArguments()
    {
        global $HTTP_SERVER_VARS;

        $this->_arguments = explode('/',$HTTP_SERVER_VARS['PATH_INFO']);
        array_shift($this->_arguments);
    }

    /**
    * Enables url rewriting, otherwise URL's are passed back
    *
    * @param        boolean     $switch     turns URL rewriting on/off
    *
    */
    function setEnabled($switch)
    {
        if ($switch) {
            $this->_enabled = true;
        } else {
            $this->_enabled = false;
        }
    }
    
    /**
    * Returns whether or not URL rewriting is enabled
    *
    * @return   boolean true if URl rewriting is enabled, otherwise false
    *
    */
    function isEnabled()
    {
        return $this->_enabled;
    }
    
    /**
    * Returns the number of variables found in query string
    *
    * This is particularly useful just before calling setArgNames() method
    *
    * @return   int     Number of arguments found in URL
    *
    */
    function numArguments()
    {
        return count($this->_arguments);
    }
    
    /**
    * Assigns logical names to query string variables
    *
    * @param        array       $names      String array of names to assign to variables pulled from query string
    * @return       boolean     true on success otherwise false
    *
    */
    function setArgNames($names)
    {
        if (count($names) < count($this->arguments)) {
            print "URL Class: number of names passed to setArgNames must be equal or greater than number of arguments found in URL";
            exit;
        }
        if (is_array($names)) {
            $newArray = array();
            for ($i = 1; $i <= count($this->_arguments); $i++) {
                $newArray[current($names)] = current($this->_arguments);
                next($names);
		next($this->_arguments);
            }
            $this->_arguments = $newArray;
            reset($this->_arguments);
        } else {
            return false;
        }
        return true;
    }

    /**
    * Gets the value for an argument
    *
    * @param        string      $name       Name of argument to fetch value for
    * @return       mixed       returns value for a given argument
    *
    */
    function getArgument($name)
    {
        global $HTTP_GET_VARS;
        
        // if in GET VARS array return it 
        if (!empty($HTTP_GET_VARS[$name])) {
            return $HTTP_GET_VARS[$name];
        }
        
        // ok, pull from query string
        if (in_array($name,array_keys($this->_arguments))) {
            return $this->_arguments[$name];
        }
        
        return '';
    }

    /**
    * Builds crawler friendly URL if URL rewriting is enabled
    *
    * This function will attempt to build a crawler friendly URL.  If this feature is
    * disabled because of platform issue it just returns original $url value
    *
    * @param        string      $url    URL to try and convert
    * @return       string      rewritten if _isenabled is true otherwise original url
    *
    */
    function buildURL($url)
    {
        if (!$this->isEnabled()) {
            return $url;
        }
        
        $pos = strpos($url,'?');
        $query_string = substr($url,$pos+1);
        $finalList = array();
        $paramList = explode('&',$query_string);
        for ($i = 1; $i <= count($paramList); $i++) {
            $keyValuePairs = explode('=',current($paramList));
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
            if ($i <> count($finalList)) {
                $newArgs .= '/';
            }
            next($finalList);
        }
        return str_replace('?' . $query_string,$newArgs,$url);
    }    
}

?>
