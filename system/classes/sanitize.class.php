<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | sanitize.class.php                                                        |
// |                                                                           |
// | Geeklog data filtering or sanitizing class library.                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007-2009 by the following authors:                         |
// | Authors: Blaine Lang      - blaine AT portalparts DOT com                 |
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

/* This class can be used to filter a single variable or an array of data
*  Three filtering modes are currently supported but the class can easily be extended
*  Mode int:   will return integer value or 0 if NULL or non-integer
*  Mode char:  strong character  filter that will remove any HTML or quotes
*  Mode text:  Use for text fields and will use the site HTML filtering functions and user allowable HTML returned as well as quotes
*
*  Data can be returned filtered or optionally prep'ed for DB or Web use
*  Usage Examples:
*  $filter = new sanitizer();
*
*  Example 1: Load up data to be filtered and then call method to return data prep'ed for DB, Web or default format
*  Better if you have a lot of data to filter and if you want to return it for DB and Web Presentation format

   $filter = new sanitizer();
   $charvars = array(
        'id'    => $_REQUEST['id'],
        'mode'  => $_REQUEST['mode']
    );
    $textvars = array(
        'title' => $_REQUEST['movietitle'],     // Able to change the key that will be used in filtered return array
        'desc'  => $_REQUEST['moviedesc'],
        'keywords'  => $_REQUEST['keywords'],
    );

    // Initialize the filter and load the data and types to be filtered
    $filter = new nexfilter();
    $filter->cleanData('char',$charvars);
    $filter->cleanData('text',$textvars);

    $dbData = $filter->getDbData();     // Filtered data is prep'ed for SQL use - addslashes added
    $webData = $filter->getWebData();  //  Filtered data like text filtered data with stripslashes already done

    $title = $dbData['title'];
    DB_query("UPDATE {$_TABLES['media']} SET title='{$dbData['title']} WHERE id='{$dbData['id']}'");


* Example 2:  Define the variables to be filtered, mode and returns sanitized data
* Not able to specify SUPER GLOBAL to filter data from unless you call multiple methods
* but you can specify multiple filtering modes

  $filter = new sanitizer();
  $clean = $filter->cleanPostData(array('movietitle' => 'text', 'id' => 'int'));
  DB_query("UPDATE {$_TABLES['media']} SET title='{$clean['movietitle']} WHERE id='{$clean['id']}'");

* Example 3: Pass in multiple variables but a single filtering mode
  $clean = $filter->getCleanData('text', array('title' => $_POST['movietitle'],'desc' => $_POST['moviedesc'] ));

* Example 4: Pass in a single variable to sanitize
  $id = $filter->getCleanData('int',$_GET['id']);

*  How to extend allowable types - add a new function
*  Example Type: Int -- function _cleanInt(), so adding a function called _cleanDate could be added for a date filter

*/


if (strpos ($_SERVER['PHP_SELF'], 'sanitize.class.php') !== false) {
    die ('This file can not be used on its own.');
}


class sanitizer {

    var $_dirtydata = array();      // Data to be filtered
    var $_cleandata = array();      // Sanitized Data after filtering
    var $_makeglobal = false;       // Set to true to also create a global matching variable name if passed in
    var $_logmode    = false;       // Set true to log to error.log
    var $_checkwords = true;        // Set true to enable word censor filter
    var $_checkhtml = true;         // Set true to enable HTML filtering
    var $_prepfordb = false;        // Set true to place filter class into DB mode -- will addslashes around quotes
    var $_prepforweb = false;       // Set true to place filter class into WEB mode - will use stripslashes before returning data
    var $_maxlength = 0;            // Set to 0 to disable, else if set will trim data to this length

    /* Filter modes allows this class to be extended.
     * Need to have matching class method _cleanType
     */
    var $_filtermodes = array('int','char','text');


    public function setLogging($state) {
        if ($state === true or $state == 'on') {
            $this->_logmode = true;
        } elseif ($state === false or $state == 'off') {
            $this->_logmode = false;
        }
    }

    public function setGlobals($state) {
        if ($state === true or $state == 'on') {
            $this->_makeglobal = true;
        } elseif ($state === false or $state == 'off') {
            $this->_makeglobal = false;
        }
    }

    public function setCheckwords($state) {
        if ($state === true or $state == 'on') {
            $this->_checkwords = true;
        } elseif ($state === false or $state == 'off') {
            $this->_checkwords = false;
        }
    }

    public function setPrepfordb($state) {
        if ($state === true or $state == 'on') {
            $this->_prepfordb = true;
            $this->_prepforweb = false;
        } elseif ($state === false or $state == 'off') {
            $this->_prepfordb = false;
        }
    }

    public function setPrepforweb($state) {
        if ($state === true or $state == 'on') {
            $this->_prepforweb = true;
            $this->_prepfordb = false;
        } elseif ($state === false or $state == 'off') {
            $this->_prepforweb = false;
        }
    }

    public function setMaxlength($length) {
        if ($length > 0) {
            $this->_maxlength = $length;
        } else {
            $this->_maxlength = 0;
        }
    }

    public function initFilter() {
        $this->_dirtydata = array();
        $this->_cleandata = array();
    }

    /* apply the free webtext filter to input which may need to contain quote's or other special characters */
    private function _filterText( $var ) {
        // Need to call addslashes again as COM_checkHTML strips it out
        if ($this->_checkhtml) $var = COM_checkHTML($var);
        if ($this->_checkwords) $var = COM_checkWords($var);
        $var = COM_killJS($var);
        if ($this->_maxlength > 0) {
            $var = substr($var, 0, $this->_maxlength);
        }
        if ($this->_prepfordb) {
            $var = addslashes($var);
        } elseif ($this->_prepforweb) {
            $var = stripslashes($var);
        }
        return $var;
    }

    /* Default filter for character and numeric data */
    private function _applyFilter( $parameter, $isnumeric = false ) {
        $p = COM_stripslashes( $parameter );
        $p = strip_tags( $p );
        $p = COM_killJS( $p ); // doesn't help a lot right now, but still ...
        if( $isnumeric ) {
            // Note: PHP's is_numeric() accepts values like 4e4 as numeric
            if( !is_numeric( $p ) || ( preg_match( '/^-?\d+$/', $p ) == 0 )) {
                $p = 0;
            }
        } else {
            if ($this->_checkwords) $p = COM_checkWords($p);
            $p = preg_replace( '/\/\*.*/', '', $p );
            $pa = explode( "'", $p );
            $pa = explode( '"', $pa[0] );
            $pa = explode( '`', $pa[0] );
            $pa = explode( ';', $pa[0] );
            //$pa = explode( ',', $pa[0] );
            $pa = explode( '\\', $pa[0] );
            $p = $pa[0];

            if ($this->_prepfordb) {
                $p = addslashes($p);
            } elseif ($this->_prepforweb) {
                $p = stripslashes($p);
            }
        }

        if ($this->_maxlength > 0) {
            $p = substr($p, 0, $this->_maxlength);
        }

        if( $this->_logmode ) {
            if( strcmp( $p, $parameter ) != 0 ) {
                COM_errorLog( "Filter applied: >> $parameter << filtered to $p [IP {$_SERVER['REMOTE_ADDR']}]", 1);
            }
        }

        return $p;
    }


    private function _makeGlobal() {

        if ($this->_makeglobal) {
            foreach ($this->_cleandata as $var) {
                if (is_array($var)) {
                    foreach ($var as $varname => $value) {
                        // Only if variable name is a true string like name
                        if (!is_numeric($varname)) $GLOBALS[$varname] = $value;
                    }
                }
            }
        }

    }


    private function _cleanText() {

        foreach ($this->_dirtydata['text'] as $var => $value) {
            // Check if this variable is an array - maybe a checkbox or multiple select
            if (is_array($value)) {
                $subvalues_array = array();
                foreach ($value as $subvalue) {
                    $subvalues_array[] = $this->_filterText($subvalue);
                }
                $this->_cleandata['text'][$var] = $subvalues_array;
            } else {
                $this->_cleandata['text'][$var] = $this->_filterText($value);
            }
        }

    }


    private function _cleanChar() {

        foreach ($this->_dirtydata['char'] as $var => $value) {
            // Check if this variable is an array - maybe a checkbox or multiple select
            if (is_array($value)) {
                $subvalues_array = array();
                foreach ($value as $subvalue) {
                    $subvalues_array[] = $this->_applyFilter($subvalue);
                }
                $this->_cleandata['char'][$var] = $subvalues_array;
            } else {
                $this->_cleandata['char'][$var] = $this->_applyFilter($value);
            }
        }

    }

    private function _cleanInt() {

        foreach ($this->_dirtydata['int'] as $var => $value) {
            // Check if this variable is an array - maybe a checkbox or multiple select
            if (is_array($value)) {
                $subvalues_array = array();
                foreach ($value as $subvalue) {
                    $subvalues_array[] = $this->_applyFilter($subvalue,true);
                }
                $this->_cleandata['int'][$var] = $subvalues_array;
            } else {
                $this->_cleandata['int'][$var] = $this->_applyFilter($value,true);
            }
        }

    }

    private function _santizeData($type='',$data='') {

        if (!empty($data)) {
            $this->cleanData($type,$data);
        }

        /* Check if we need to return just one type of filtered data */
        if ($type != '' AND in_array($type,$this->_filtermodes)) {
            $filterFunction = '_clean' . ucfirst($type);
            if (method_exists($this,$filterFunction)) {
                $this->$filterFunction();
                // If just one variable in clean data, then no need to return an array of values
                if (count($this->_cleandata[$type]) == 1) {
                    $retval = $this->_cleandata[$type][0];
                } else {
                    $retval = $this->_cleandata[$type];
                }
            }

        } else {
            /* Filter and return an associative array of filtered data - per filter type */
            foreach($this->_dirtydata as $type => $data)  {
                $filterFunction = '_clean' . ucfirst($type);
                if (method_exists($this,$filterFunction)) {
                    $this->$filterFunction();
                }
            }
            $retval = $this->_cleandata;
        }

        return $retval;

    }


    /* Used to load the data that you want cleaned
    *  Call the getCleanData or getDbData or getWebData() methods to return filtered data
    */
    public function cleanData($mode,$data) {
        if (in_array($mode,$this->_filtermodes)) {
            if (is_array($data)) {
                foreach ($data as $var => $value ) {
                  $this->_dirtydata[$mode][$var] = $value;
                }
            } else {
                $this->_dirtydata[$mode][] = $data;
            }
        }
    }

    /* Optional methods to clean and return filtered data from a specific GLOBAL (GET, POST, COOKIE or REQUEST) */
    /* Expect an array of variables from a specific SUPPER GLOBAL
       $data is an array of variable names and type - example:
         array ( 'var1' => 'int', 'var2name' => 'char', 'message' => 'text')
    */

    /* Expect an array of $_GET variables as per above array format to filter and return sanitized values  */
    public function cleanGetData($data) {
        if (!is_array($data)) {
            return FALSE;
        }
        $cleandata = array();
        foreach ($data as $varname => $type) {
            if (isset($_GET[$varname]) AND !empty($_GET[$varname])) {
                $data = $_GET[$varname];
                $cleandata[$varname] = $this->getCleanData($type,$data);
            } else {
                if ($type = 'int') {
                    $cleandata[$varname] = 0;
                } else {
                    $cleandata[$varname] = '';
                }
            }
        }
        return $cleandata;

    }

    /* Expect an array of $_POST variables to filter and return sanitized values  */
    public function cleanPostData($data) {
        if (!is_array($data)) {
            return FALSE;
        }
        $cleandata = array();
        foreach ($data as $varname => $type) {
            if (isset($_POST[$varname]) AND !empty($_POST[$varname])) {
                $data = $_POST[$varname];
                $cleandata[$varname] = $this->getCleanData($type,$data);
            } else {
                if ($type = 'int') {
                    $cleandata[$varname] = 0;
                } else {
                    $cleandata[$varname] = '';
                }
            }
        }
        return $cleandata;

    }

    /* Expect an array of $_REQUEST variables to filter and return sanitized values  */
    public function cleanRequestData($data) {
        if (!is_array($data)) {
            return FALSE;
        }
        $cleandata = array();
        foreach ($data as $varname => $type) {
            if (isset($_REQUEST[$varname]) AND !empty($_REQUEST[$varname])) {
                $data = $_REQUEST[$varname];
                $cleandata[$varname] = $this->getCleanData($type,$data);
            } else {
                if ($type = 'int') {
                    $cleandata[$varname] = 0;
                } else {
                    $cleandata[$varname] = '';
                }
            }
        }
        return $cleandata;

    }


    /* Expect an array of $_COOKIE variables to filter and return sanitized values  */
    public function cleanCookieData($data) {
        if (!is_array($data)) {
            return FALSE;
        }
        $cleandata = array();
        foreach ($data as $varname => $type) {
            if (isset($_COOKIE[$varname]) AND !empty($_COOKIE[$varname])) {
                $data = $_COOKIE[$varname];
                $cleandata[$varname] = $this->getCleanData($type,$data);
            } else {
                if ($type = 'int') {
                    $cleandata[$varname] = 0;
                } else {
                    $cleandata[$varname] = '';
                }
            }
        }
        return $cleandata;

    }




    /* Main public functions to filter data
       Return the cleaned data loaded using the cleanData method
     * Or optionally pass in the data to be cleaned as well for a direct one-function call use
    */
    public function getCleanData($type='',$data='') {

        $retval = $this->_santizeData($type,$data);
        $this->_makeGlobal();
        // Reset the filter class data now that we have processed the filtering
        $this->initFilter();

        return $retval;
    }

    public function getWebData($type='',$data='') {

        $retval = '';
        $currentWebState = $this->_prepforweb;
        $currentDbState = $this->_prepfordb;
        $this->setPrepforweb(true);

        $retval = $this->_santizeData($type,$data);

        // Reset filter options
        $this->setPrepforweb($currentWebState);
        $this->setPrepfordb($currentDbState);

        return $retval;
    }

    public function getDbData($type='',$data='') {

        $retval = '';
        $currentWebState = $this->_prepforweb;
        $currentDbState = $this->_prepfordb;
        $this->setPrepfordb(true);

        $retval = $this->_santizeData($type,$data);

        // Reset filter options
        $this->setPrepforweb($currentWebState);
        $this->setPrepfordb($currentDbState);

        return $retval;
    }


} // End of class



?>