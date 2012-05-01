<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | scripts.class.php                                                         |
// |                                                                           |
// | Geeklog class to include javascript, javascript files and css files.      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Tom Homer, tomhomer AT gmail DOT com                             |
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
* This class is used to set JavaScript, JavaScript Files, jQuery JavaScript Libraries
* and CSS files that need to be loaded either in the header of the footer.
*
* @author Tom Homer
*
*/
class scripts {

    private $library_files; // Array of available jQuery library files that can be loaded
    
    private $jquery_cdn; // Flag to use jQuery file from CDN-hosted source (Google)
    private $jquery_cdn_file; // Location of jQuery file at Google
    
    private $jquery_ui_cdn; // Flag to use jQuery UI file from CDN-hosted source (Google)
    private $jquery_ui_cdn_file; // Location of jQuery UI file at Google
    
    private $script_files; // Array of JavaScript files set to be loaded either in the header or footer
    
    private $css_files; // Array of CSS files set to be loaded
    
    private $scripts; // Array of JavaScript set to be loaded either in the header or footer
    
    private $restricted_names; // Restricted names list for JavaScript files
    
    private $header_set; // Flag to know if Header Code already has been retrieved
    private $javascript_set; // Flag to know if ANY JavaScript has been set yet

    /**
    * Constructor
    *
    * This initializes the scriptsobject
    *
    */
    function __construct() {
        
        global $_CONF, $_USER;
        
        $this->library_files = array();
        $this->jquery_ui_cdn = false;
        $this->script_files = array();
        $this->css_files = array();
        $this->scripts = array();
        $this->restricted_names = array();
        
        $this->header_set = false;
        $this->javascript_set = false;
        
        $this->jquery_cdn = false;
        $this->jquery_ui_cdn = false;
        
        // Find available JavaScript libraries
        $this->findJavaScriptLibraries();     
        
        // Automatically set Common library since we have not updated core yet to set it when needed
        $this->setJavaScriptLibrary('common');
        
        // Check to see if advanced editor is needed, this should be setup as a library at some point like common
        if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
            $this->setJavaScriptFile('fckeditor','/fckeditor/fckeditor.js');
        }            
        
        // Setup restricted names after setting main libraries (do not want plugins messing with them)
        $this->restricted_names = array('fckeditor', 'core', 'jquery');
        
    }
    
    /**
    * Build a list of available JavaScript Libraries
    *
    * @access    private
    * @return    boolean 
    *
    */
    private function findJavaScriptLibraries() {
        
        global $_CONF;
        
        $theme_path = '/layout/' . $_CONF['theme'];
        
        
        // Add Geeklog Specific JavaScript files. Treat them as library files since other plugins may try to load them
        $name = 'common';
        $this->library_files[$name]['file'] = 'javascript/common.js';
        $this->library_files[$name]['load'] = false;        
                     
        
        // Find available jQuery library files
        $version_jQuery = '1.7.2'; // '1.6.3';
        $this->jquery_cdn_file = 'https://ajax.googleapis.com/ajax/libs/jquery/' . $version_jQuery .'/jquery.min.js';
        $name = 'jquery';
        $this->library_files[$name]['file'] = 'javascript/jquery.min.js';
        $this->library_files[$name]['load'] = false;

        // jQuery UI
        // When upgrading jQuery UI include the redmond theme
        $version_jQuery_ui = '1.8.20'; // '1.8.11';
        $this->jquery_ui_cdn_file = 'https://ajax.googleapis.com/ajax/libs/jqueryui/' . $version_jQuery_ui .'/jquery-ui.min.js';
        
        // Set jQuery UI CSS
        $this->setCSSFilePrivate('jquery.ui.all', $theme_path . '/jquery_ui/jquery.ui.all.css', false);
        $this->setCSSFilePrivate('jquery.ui', $theme_path . '/jquery_ui/jquery-ui.css', false);
        $this->setCSSFilePrivate('jquery.ui.geeklog', $theme_path . '/jquery_ui/jquery.ui.geeklog.css', false);        

        // Set jQuery UI Core
        $names[] = 'jquery.ui.core';
        $names[] = 'jquery.ui.widget';
        $names[] = 'jquery.ui.position';
        $names[] = 'jquery.ui.mouse';
        // Set jQuery UI Widgets
        $names[] = 'jquery.ui.accordion';
        $names[] = 'jquery.ui.autocomplete';
        $names[] = 'jquery.ui.button';
        $names[] = 'jquery.ui.datepicker';
        $names[] = 'jquery.ui.dialog';
        $names[] = 'jquery.ui.draggable';
        $names[] = 'jquery.ui.droppable';
        $names[] = 'jquery.ui.progressbar';
        $names[] = 'jquery.ui.resizable';
        $names[] = 'jquery.ui.selectable';
        $names[] = 'jquery.ui.slider';
        $names[] = 'jquery.ui.sortable';
        $names[] = 'jquery.ui.tabs';
        // Set jQuery UI Effects
        $names[] = 'jquery.effects.blind';
        $names[] = 'jquery.effects.bounce';
        $names[] = 'jquery.effects.clip';
        $names[] = 'jquery.effects.core';
        $names[] = 'jquery.effects.drop';
        $names[] = 'jquery.effects.explode';
        $names[] = 'jquery.effects.fade';
        $names[] = 'jquery.effects.fold';
        $names[] = 'jquery.effects.highlight';
        $names[] = 'jquery.effects.pulsate';
        $names[] = 'jquery.effects.scale';
        $names[] = 'jquery.effects.shake';
        $names[] = 'jquery.effects.slide';
        $names[] = 'jquery.effects.transfer';
        
        foreach ($names as $name) {
            $this->library_files[$name]['file'] = 'javascript/jquery_ui/' . $name . '.min.js';
            $this->library_files[$name]['load'] = false;
        }         
    }

    /**
    * Set JavaScript Libraries to load
    *
    * @param    $name       name of JavaScript library to flag for loading
    * @access   public
    * @return   boolean 
    *
    */
    public function setJavaScriptLibrary($name) {
        
        global $_CONF;
        
        $name = strtolower($name);
        
        if (isset($this->library_files[$name])) {
            if (!$this->library_files[$name]['load']) {
                $this->library_files[$name]['load'] = true;
                // If name is subset of jQuery. make sure all Core UI libraries are loaded
                if (substr($name, 0, 7) == 'jquery.' && !$this->jquery_ui_cdn) {
                    // Check that file exists, if not use Google version
                    if (!file_exists($_CONF['path_html'] . $this->library_files[$name]['file'])) {
                        $this->jquery_ui_cdn = true;
                        
                        $this->css_files['jquery.ui']['load'] = true;
                        $this->css_files['jquery.ui.all']['load'] = false;
                    } else {
                        $this->css_files['jquery.ui.all']['load'] = true;
                    }                  
                    $this->css_files['jquery.ui.geeklog']['load'] = true;
                    
                    $this->library_files['jquery']['load'] = true;
                    $this->library_files['jquery.ui.core']['load'] = true;
                    $this->library_files['jquery.ui.widget']['load'] = true;
                    $this->library_files['jquery.ui.position']['load'] = true;
                    $this->library_files['jquery.ui.mouse']['load'] = true;
                    
                    if ($_CONF['cdn_hosted']) {
                        $this->jquery_cdn = true;
                        $this->jquery_ui_cdn = true;
                    }
                } elseif ($name == 'jquery' && $_CONF['cdn_hosted']) {
                    $this->jquery_cdn = true;
                }

            }
            $this->javascript_set = true;
            
            return true;
        } else {
            return false;
        }
    }

    /**
    * Set JavaScript to load
    *
    * @param    $script     script to include in page
    * @param    $wrap       set to true to place script tags around contents of $script
    * @param    $footer     set to true to include script in footer, else script placed in header
    * @param    $constant   Future use. Set to true if script is planned to be loaded all the time (Caching/Compression)
    * @access   public
    * @return   boolean 
    *
    */    
    public function setJavaScript($script, $wrap = false, $footer = true, $constant = false) {
        
        // If header code make sure header not already set
        if ($this->header_set && !$footer) {
            return false;
        }

        if ($footer) {
            $location = 'footer';
        } else {
            $location = 'header';
        }
        
        if ($wrap) {
            $script = '<script type="text/javascript">' . $script . '</script>';
        }
            
        $this->scripts[$location][] = $script;
        
        $this->javascript_set = true;
        
        return true;
    }

    /**
    * Set JavaScript file to load
    *
    * @param    $name       name of JavaScript file
    * @param    $file       location of file relative to public_html directory. Include '/' at beginning
    * @param    $footer     set to true to include script in footer, else script placed in header
    * @param    $constant   Future use. Set to true if file is planned to be loaded all the time (Caching/Compression)
    * @access   public
    * @return   boolean 
    *
    */     
    public function setJavaScriptFile($name, $file, $footer = true, $constant = false) {
        
        global $_CONF;

        // If header code make sure header not already set
        if ($this->header_set && !$footer) {
            return false;
        }

        // Make sure valid name
        if (in_array(strtolower($name), $this->restricted_names, true)) {
            return false;
        }

        // Make sure file exists and is readable. We don't want any 403 or 404, right?
        $path = substr($_CONF['path_html'], 0, -1) . $file;
        // Strip parameters
        if (strrpos($path, '?') !== false) {
            $path = substr($path, 0, strrpos($path, '?'));
        }
        if (! is_file($path) || ! is_readable($path)) {
            return false;
        }
        
        $this->script_files[$name]['file'] = $file;
        $this->script_files[$name]['footer'] = $footer;
        $this->script_files[$name]['constant'] = $constant;
        
        $this->javascript_set = true;
        
        return true;
    }
    
    /**
    * Set CSS file to load. Used only by class.
    *
    * This function is used to include any CSS needed by the JavaScript Libraries
    *
    * @param    $name       name of CSS file
    * @param    $file       location of file relative to public_html directory. Include '/' at beginning
    * @param    $load       set to true to load script right away. Should only be loaded when related script is loaded
    * @access   private
    * @return   boolean 
    *
    */      
    private function setCSSFilePrivate($name, $file, $load = true) {

        global $_CONF;

        // If header code make sure header not already set
        if ($this->header_set) {
            return false;
        }
        
        // Make sure valid name
        if (in_array(strtolower($name), $this->restricted_names, true)) {
            return false;
        }        

        // Make sure file exists and is readable. We don't want any 403 or 404, right?
        $path = substr($_CONF['path_html'], 0, -1) . $file;
        if (! is_file($path) || ! is_readable($path)) {
            return false;
        }
        
        $this->css_files[$name]['file'] = $file;
        $this->css_files[$name]['extra'] = '';
        $this->css_files[$name]['constant'] = false;
        $this->css_files[$name]['load'] = $load;
        
        return true;
    }
    
    /**
    * Set CSS file to load
    *
    * @param    $name       name of CSS file
    * @param    $file       location of file relative to public_html directory. Include '/' at beginning
    * @param    $constant   Future use. Set to true if file is planned to be loaded all the time (Caching/Compression)
    * @param    $attributes (optional) array of extra attributes
    * @access   public
    * @return   boolean 
    *
    */
    public function setCSSFile($name, $file, $constant = true, $attributes = array()) {
        
        global $_CONF;

        // If header code make sure header not already set
        if ($this->header_set) {
            return false;
        }
        
        // Make sure valid name
        if (in_array(strtolower($name), $this->restricted_names, true)) {
            return false;
        }        
        
        // Make sure file exists and is readable. We don't want any 403 or 404, right?
        $path = substr($_CONF['path_html'], 0, -1) . $file;
        // Strip parameters
        if (strrpos($path, '?') !== false) {
            $path = substr($path, 0, strrpos($path, '?'));
        }
        if (! is_file($path) || ! is_readable($path)) {
            return false;
        }

        $extra = '';
        foreach ($attributes as $key => $value) {
            $extra .= " $key=\"$value\"";
        }

        $this->css_files[$name]['name'] = $name;
        $this->css_files[$name]['file'] = $file;
        $this->css_files[$name]['extra'] = $extra;
        $this->css_files[$name]['constant'] = $constant;
        $this->css_files[$name]['load'] = true;
        
        return true;
    }

    /**
    * Returns header code (JavaScript and CSS) to include in the Head of the webpage
    *
    * @access   public
    * @return   string 
    *
    */     
    public function getHeader() {
        
        global $_CONF;
        
        $this->header_set = true;
        
        $headercode = '';

        // Set CSS Files
        foreach ($this->css_files as $file) {
            if ($file['load'] && isset($file['file'])) {
                $csslink = '<link rel="stylesheet" type="text/css" href="'
                         . $_CONF['site_url'] . $file['file'] . '"' . $file['extra'] . XHTML . '>' . LB;
                if (isset($file['name']) && $file['name'] == 'theme') { // load theme css first
                    $headercode = $csslink . $headercode;
                } else {
                    $headercode .= $csslink;
                }
            }
        }

        // Set JavaScript (do this before file incase variables are needed)
        if (isset($this->scripts['header'])) {
            foreach ($this->scripts['header'] as $script) {
                $headercode .= $script . LB;
            }
        }
        
        // Set JavaScript Files
        foreach ($this->script_files as $file) {
            if (!$file['footer']) {
                $headercode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . $file['file'] . '"></script>' . LB;
            }
        }
            
        return $headercode;
    }

    /**
    * Returns JavaScript footer code to be placed just before </body>
    *
    * @access   public
    * @return   string 
    *
    */     
    public function getFooter() {
        
        global $_CONF, $_USER;
        
        $footercode = '';
        
        // Do we need to set JavaScript
        if ($this->javascript_set) {
            // Add Core JavaScript global variables
            $footercode = '';
            if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
                $footercode = '<script type="text/javascript">' . LB;
                $footercode .= "var geeklogEditorBaseUrl = '" . $_CONF['site_url'] . "';" . LB;
                $footercode .= '</script>' . LB;
            }
            
            // Set JavaScript Library files first incase other scripts need them
            if ($this->jquery_cdn) {
                $footercode .= '<script type="text/javascript" src="' . $this->jquery_cdn_file . '"></script>' . LB;
                $this->library_files['jquery']['load'] = false; // Set to false so not reloaded
                if ($this->jquery_ui_cdn) {
                    $footercode .= '<script type="text/javascript" src="' . $this->jquery_ui_cdn_file . '"></script>' . LB;
                    // Since using CDN file reset loading of jQuery UI
                    foreach ($this->library_files as $key => &$file) {
                        if (substr($key, 0, 7) == 'jquery.') {
                            $file['load'] = false;
                        }
                    }                    
                }
            } elseif ($this->jquery_ui_cdn) { // This might happen if a jQuery UI file is not found
                $footercode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . '/' . $this->library_files['jquery']['file'] . '"></script>' . LB;
                $this->library_files['jquery']['load'] = false; // Set to false so not reloaded
                $footercode .= '<script type="text/javascript" src="' . $this->jquery_ui_cdn_file . '"></script>' . LB;
                // Since using CDN file reset loading of jQuery UI
                foreach ($this->library_files as $key => &$file) {
                    if (substr($key, 0, 7) == 'jquery.') {
                        $file['load'] = false;
                    }
                }                  
            }
            // Now load in the rest of the libraries
            foreach ($this->library_files as $file) {
                if ($file['load']) {
                    $footercode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . '/' . $file['file'] . '"></script>' . LB;
                }
            }
            
            // Set JavaScript (do this before file incase variables are needed)
            if (isset($this->scripts['footer'])) {
                foreach ($this->scripts['footer'] as $script) {
                    $footercode .= $script . LB;
                }
            }
            
            // Set JavaScript Files
            foreach ($this->script_files as $file) {
                if ($file['footer']) {
                    $footercode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . $file['file'] . '"></script>' . LB;
                }
            }

        }
        
        return $footercode;
    }

}

?>
