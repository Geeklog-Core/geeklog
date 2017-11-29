<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | pluginupdater class                                                       |
// |                                                                           |
// | Geeklog file download class library.                                      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2016 by the following authors:                         |
// |                                                                           |
// | Authors: Tim Patrick       - timpatrick12@gmail.com                       |
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

// Required interface for updates to adhere to
interface PluginUpdateInterface
{
    public static function init();
}

// Static global variable class holder
class PLData
{
    // Not needed atm #static public $CURRENT_OBJ = NULL; // Current pluginupdater object
    /**
    * @access private
    */
    static private $FAILED_UPDATES = array(); // Failed updates holder in format: failed_update_name => error #

    /**
    * @access private
    */
    static private $ERROR = false; // Boolean

    /**
    * Inserts a new failed update into the list
    *
    * @param    string    $name    The update name that failed
    * @param    int       $errno   The error number that occurred
    *
    */
    static public function failedupdate($name, $errno)
    {
        self::$FAILED_UPDATES[$name] = $errno;
        self::$ERROR = true;
        
    }
    
    /**
    * Get error code message
    *
    * @param    int       $errno   The error number that occurred
    *
    */
    static public function errmsg($errno)
    {
        global $LANG_PUPDATE_ERROR;
        
        return $LANG_PUPDATE_ERROR[$errno];
    }

    /**
    * Recursively copy over directory contents to an existing directory
    * 
    * @return HTML string 
    */
    static public function report($data='')
    {
        global $LANG32;
        
        $man = $data;

        // Any updates?
        if (self::$ERROR) {
            $man .= '<br />'.$LANG32[337] . '<br />';
            foreach (self::$FAILED_UPDATES as $name => $errno) {
                $man .= '<br />' . $name . ' - '. self::errmsg($errno);
            }    
        }

        return $man;
    }

}

/**
* This class manages the operation of updating a plugin with a patch.
*
* @author   Tim Patrick
*
*/
class pluginupdater
{
    // Private Properties

    /**
    * @access private
    */
    private $ERROR_LOOKUP; // Array

    /**
    * @access private
    */
    private $SQL_CURRENT;
    private $SQL_NEW;
    private $PLNAME;
    private $DIR;
    private $SJR_TYPE;
    
    /**
    * Constructor
    *
    */
    public function __construct()
    {
        $FAILED_UPDATES = array();
        $ERROR = false;
        $this->SQL_CURRENT = array();
        $SQL_NAME = array();
        $this->PLNAME = '';
        $this->DIR = '';
        $this->SJR_TYPE = 'update';
    }
    
    // Destructor
    public function __destruct()
    {
    
    }
        
    /**
    * Set variables
    *
    * @param    mixed    $var   $variable_value
    * @param    string   $name  variable name
    *
    */
    public function set_var($var, $name)
    {
        switch ($name) {
            case 'pn':
                $this->PLNAME = $var;   
                break;
            case 'sql':
                $this->SQL_NEW = $var;   
                break;
            case 'tbl':
                $this->SQL_CURRENT = $var;   
                break;
            case 'dir':
                $this->DIR = $var;
                break;
            case 'type':
                $this->SJR_TYPE = $var;
                break;
        }
    }
    
    /**
    * Start update installation
    *
    * @return boolean true | false
    */
    public function start()
    {
        // Global Variables
        global $_CONF, $_TABLES;
        
        // Start backup process
        // Do MYSQL dumps
        foreach ($this->SQL_CURRENT AS $db) {
            $backup_dir = $_CONF['path'] . "data/backup_mysql_update_{$db}.tgfrsgi935";
            $tbl = $_TABLES[$db];
            DB_query("SELECT * INTO OUTFILE '$backup_dir' FROM {$tbl};");
        }

        // Backup file folders
        $fpath = $_CONF['path_data'];
        $this->copy_ru($_CONF['path_html'] . $this->PLNAME, $fpath . 'plugin_backup_dir_ph_' . $this->PLNAME);
        $this->copy_ru($_CONF['path_html'] . 'admin/plugins/' . $this->PLNAME, $fpath . 'plugin_backup_dir_admin_' . $this->PLNAME);
        $this->copy_ru($_CONF['path'] . 'plugins/' . $this->PLNAME, $fpath . 'plugin_backup_dir_plugins_' . $this->PLNAME);

        // Run SQL commands
        foreach ($this->SQL_NEW as $sql) {
            // Run query
            DB_query($sql);
        }

        // Copy over directories
        if (file_exists($_CONF['path_data'] . $this->DIR . '/admin')) {
            $this->copy_ru($_CONF['path_data'] . $this->DIR . '/admin', $_CONF['path_html'] . '/admin/plugins/' . $this->PLNAME);
        }

        if (file_exists($_CONF['path_data'] . $this->DIR . '/public_html')) {
            $this->copy_ru($_CONF['path_data'] . $this->DIR  . '/public_html' , $_CONF['path_html'] . $this->PLNAME);
        }

        if (file_exists($_CONF['path_data'] . $this->DIR . '/plugins')) {
            $this->copy_ru($_CONF['path_data'] . $this->DIR . '/plugins', $_CONF['path'] . 'plugins/' . $this->PLNAME);
        }

        // return true
        return true;
    }

    /**
    * Finish update installation
    * @param integer  $int  The update count number || The new version number (depending on if 
    *
    * @return boolean true | false
    */
    public function finish($int)
    {
        global $_TABLES;
 
        // Update?
        if ($this->SJR_TYPE == 'update') {        
            $int = (int)$int;

            // Update plugin table
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_update_count = {$int} WHERE pi_name = '{$this->PLNAME}';");
        }
        else {
            $int = COM_applyFilter($int);
            
            // Update plugin table with new version
            DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '{$int}' WHERE pi_name = '{$this->PLNAME}';");
        }

        // return true
        return true;
    }

    /**
    * Clean up temp files and folders
    * @param  string  $ball The file name of the tarball downloaded
    *
    * @return boolean true | false
    */
    function cleanup($ball)
    {
        global $_CONF;
       
        // Start Cleanup, by removing directory
        if (file_exists($_CONF['path'] . 'data/' . $this->DIR)) {
            @System::rm('-rf ' . $_CONF['path'] . 'data/' . $this->DIR);
        }

        // Clean up tarball
        if (file_exists($_CONF['path'] . 'data/' . $ball)) {
            @System::rm('-rf ' . $_CONF['path'] . 'data/' . $ball);    
        }

        // Clean up backup dirs | public_html
        if (file_exists($_CONF['path'] . 'data/' . 'plugin_backup_dir_ph_' . $this->PLNAME)) {
            @System::rm('-rf ' . $_CONF['path'] . 'data/' . 'plugin_backup_dir_ph_' . $this->PLNAME);    
        }       
       
        // Clean up backup dirs | admin
        if (file_exists($_CONF['path'] . 'data/' . 'plugin_backup_dir_admin_' . $this->PLNAME)) {
            @System::rm('-rf ' . $_CONF['path'] . 'data/' . 'plugin_backup_dir_admin_' . $this->PLNAME);    
        } 

        // Clean up backup dirs | plugin
        if (file_exists($_CONF['path'] . 'data/' . 'plugin_backup_dir_plugins_' . $this->PLNAME)) {
            @System::rm('-rf ' . $_CONF['path'] . 'data/' . 'plugin_backup_dir_plugins_' . $this->PLNAME);    
        } 

        // Remove SQL backups
        foreach ($this->SQL_CURRENT AS $db) {
            $backup_dir = $_CONF['path'] . "data/backup_mysql_update_{$db}.tgfrsgi935";
            if (file_exists($backup_dir)) {
                unlink($backup_dir);  
            }
        }

        return true;
    }

    /**
    * Restores old files and SQL, because of error
    *
    * @return boolean true | false
    */
    function restore()
    {
        global $_CONF, $_TABLES;
        
        // Remove existing directories, apply backups
       
        // Clean up backup dirs | public_html
        if (file_exists($_CONF['path_html'] . $this->DIR)) {
            @System::rm('-rf ' . $_CONF['path_html'] . $this->DIR);    
            
            // Now restore
            rename($_CONF['path_data'] . 'plugin_backup_dir_ph_' . $this->PLNAME ,$_CONF['path_html'] . $this->PLNAME);
        }       
       
        // Clean up backup dirs | admin
        if (file_exists($_CONF['path_html'] . 'admin/plugins/' . $this->PLNAME)) {
            @System::rm('-rf ' . $_CONF['path_html'] . 'admin/plugins/' . $this->PLNAME);    
            
            // Now restore
            rename($_CONF['path_data'] . 'plugin_backup_dir_admin_' . $this->PLNAME ,$_CONF['path_html'] . 'admin/plugins' . $this->PLNAME);
        } 

        // Clean up backup dirs | plugin
        if (file_exists($_CONF['path'] . 'plugins/' . $this->PLNAME)) {
            @System::rm('-rf ' . $_CONF['path'] . 'plugins/' . $this->PLNAME);    
            
            // Now restore
            rename($_CONF['path_data'] . 'plugin_backup_dir_plugins_' . $this->PLNAME ,$_CONF['path'] . 'plugins/' . $this->PLNAME);
        }

        // Restore SQL
        foreach ($this->SQL_CURRENT AS $db) {
            $backup_dir = $_CONF['path'] . "data/backup_mysql_update_{$db}.tgfrsgi935";
            $tbl = $_TABLES[$db];
            DB_query("LOAD DATA INFILE '{$backup_dir}' INTO TABLE {$tbl};");
        }

        return true;
        
    }

    /**
    * Recursively copy over directory contents to an existing directory
    * @return
    */
    public function copy_ru($src,$dst) 
    {
        $dir = opendir($src);
        $true = file_exists($dst);
        
        // We have to make directory
        if(!$true) {
            mkdir($dst);
        }
        
        while (false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->copy_ru($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                     copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    } 

}        


?>
