<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | xmldb.class.php                                                           |
// |                                                                           |
// | Geeklog functions to interact with XML stub database for PHPunit          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Sean Clark       - smclark89 AT gmail DOT com                    |
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

class Xmldb {
    
    private $xml;
    
    /**
    * Constructor, requires tst.class.php for paths
    *
    */    
    function xmldb() {
        require_once 'tst.class.php';
    }
    
    /**
    * Retrieves configuration values from XML database. Also overwrite paths with user-configured
    * paths found in tst.class.php for PHPUnit test package.
    *
    * @param    string  $db      XML database to retrieved CONF values from, defaults to default.xml
    * @return   array   $_CONF   Array of CONF values
    *
    */
    
    function get_CONF($db = 'default') {
        $xml = $this->loadDb($db);
        global $_CONF;
        $_CONF = array();
        $values = $xml->xpath('/geeklog/gl_conf_values');
        foreach($values as $value) {
            // Some values are not portable, in the future may be easier to use install utility.
            // Meanwhile, use switch statements to overwrite necessary config values now.
            switch((string) $value->name) {
                case 'rdf_file':
                    $_CONF[(string) $value->name] = Tst::$public.'backend/geeklog.rss';
                    break;
                case 'path_html':
                    $_CONF[(string) $value->name] = Tst::$public.'';
                    break;
                case 'path_log':
                    $_CONF[(string) $value->name] = Tst::$root.'logs/';
                    break;
                case 'path_language':
                    $_CONF[(string) $value->name] = Tst::$root.'language/';
                    break;
                case 'backup_path':
                    $_CONF[(string) $value->name] = Tst::$root.'backups/';
                    break;
                case 'path_data':
                    $_CONF[(string) $value->name] = Tst::$root.'data/';
                    break;
                case 'path_images':
                    $_CONF[(string) $value->name] = Tst::$public.'images/';
                    break;
                case 'path_pear':
                    $_CONF[(string) $value->name] = Tst::$root.'system/pear/';
                    break;
                case 'path_themes':
                    $_CONF[(string) $value->name] = Tst::$public.'layout/';
                    break;
                default:
                    if ($value->value != 'unset') {
                        $_CONF[(string) $value->name] = unserialize((string) $value->value);
                    }
            }
        }
        return $_CONF;
    }

	/**
    * Retrieves Activated plugins from XML database.
    *
    * @param    string  $db      XML database to retrieved CONF values from, defaults to default.xml
    * @return   array   $_PLUGINS   Array of CONF values
    *
    */
    
    function get_PLUGINS($db = 'default') {
        $xml = $this->loadDb($db);
        global $_PLUGINS;
        $_PLUGINS = array();
        $values = $xml->xpath('/geeklog/gl_plugins');
        foreach($values as $value) {    
			if ($value->pi_enabled = 1) {
             $_PLUGINS[] = (string) $value->pi_name;
            }
        }
        return $_PLUGINS;
    }
    
    
    /**
    * Loads XML db using simpleXML_load_file
    *
    * @param    string  $db     XML database to retrieved CONF values from, defaults to default.xml
    * @return   array   $xml    database parsed with simpleXML 
    */
    function loadDb($db = 'default') {
        $db .= '.xml';
        $xml = simplexml_load_file(Tst::$tests.'files/databases/'.$db) or die ('Unable to load XML file '.$db);
        return $xml;
    }
	
	
	// Below is in progress, may not be necessary
	
	/**
    * Translates SQL query to xPath query and returns result
    *
    * @param    string  $db     XML database to retrieved CONF values from, defaults to default.xml
    * @return   array   $xml    database parsed with simpleXML 
    */
	/*
	function DB_query($sql, $db = 'default') {
		if(!empty($sql)) {
			$xml = $this->loadDb($db);
			
			if(substr_count($sql, 'SELECT ') != 0)) {
				static $select = $this->assembleSelect($sql)
			}

		
		$values = $xml->xpath('/geeklog/gl_conf_values');
	}
	
	function assembleSelect($sql) {
			$arr = explode(' FROM', $sql);
			$values = explode(',', substr_replace($arr[0], '', 0, 7));
			foreach($values as $k => $v) {
				$values[$k] = trim($v);
			}
			return $values;			
	}
    */
}

?>
