<?php

class url {
    var $_arguments;		// Array of argument names
    var $_enabled;
    
    /**
    * Constructor
    *
    * @enabled  boolean whether rewriting is enabled
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
    */
    function _getArguments()
    {
        global $PATH_INFO;

        $this->_arguments = explode('/',$PATH_INFO);
        array_shift($this->_arguments);
    }

    /**
    * Enables url rewriting, otherwise URL's are passed back
    *
    * @switch   boolean     true/false
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
    */
    function numArguments()
    {
        return count($this->_arguments);
    }
    
    /**
    * Assigns logical names to query string variables
    *
    * @names        Array   String array of names to assign to variables pulled from query string
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
    * @name     string  Name of argument to fetch value for
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
    * Builds crawler friendly URL
    *
    * @url      string      URL to try and convert
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