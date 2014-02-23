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
    private $library_files_footer; // Location of loading library files
    
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
    private $css_set; // Flag to know if ANY css has been set yet

    private $lang; // Array of language variables used in JavaScript

    /**
    * Constructor
    *
    * This initializes the scriptsobject
    *
    */
    function __construct() {
        
        global $_CONF, $_USER;
        
        $this->library_files = array();
        $this->library_files_footer = true;
        $this->jquery_ui_cdn = false;
        $this->script_files = array();
        $this->css_files = array();
        $this->scripts = array();
        $this->css = array();
        $this->restricted_names = array();
        $this->lang = array();
        
        $this->header_set = false;
        $this->javascript_set = false;
        
        $this->jquery_cdn = false;
        $this->jquery_ui_cdn = false;
        
        // Find available JavaScript libraries
        $this->findJavaScriptLibraries();     
        
        // Automatically set Common library since we have not updated core yet to set it when needed
        $this->setJavaScriptLibrary('common');
        
        // Setup restricted names after setting main libraries (do not want plugins messing with them)
        $this->restricted_names = array('core', 'jquery');
        
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
                     
        // jQuery (http://jquery.com/download/)
        // Find available jQuery library files
        $version_jQuery = '1.10.2'; // '1.9.1'; // '1.9.0'; // '1.7.2'; // '1.6.3';
        $this->jquery_cdn_file = 'https://ajax.googleapis.com/ajax/libs/jquery/' . $version_jQuery . '/jquery.min.js';
        $name = 'jquery';
        // $this->library_files[$name]['file'] = 'javascript/jquery-' . $version_jQuery . '.min.js';
        $this->library_files[$name]['file'] = 'javascript/jquery.min.js';
        $this->library_files[$name]['load'] = false;

        // jQuery UI (http://plugins.jquery.com/ui.core/)
        // When upgrading jQuery UI include the redmond theme and all Core, Interactions and Widgets
        // Include minified version only of js
        $version_jQuery_ui = '1.10.3'; // '1.10.1'; // '1.10.0'; // '1.8.20'; // '1.8.11';
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
        
        // Set jQuery UI Interactions
        $names[] = 'jquery.ui.draggable';
        $names[] = 'jquery.ui.droppable';
        $names[] = 'jquery.ui.resizable';
        $names[] = 'jquery.ui.selectable';
        $names[] = 'jquery.ui.sortable';
        
        // Set jQuery UI Widgets
        $names[] = 'jquery.ui.accordion';
        $names[] = 'jquery.ui.autocomplete';
        $names[] = 'jquery.ui.button';
        $names[] = 'jquery.ui.datepicker';
        $names[] = 'jquery-ui-i18n'; // extra included in core plugin under i18n directory (used by calendar and article dates)
        $names[] = 'jquery.ui.dialog';
        $names[] = 'jquery.ui.menu';
        $names[] = 'jquery.ui.progressbar';
        $names[] = 'jquery.ui.slider';
        $names[] = 'jquery.ui.spinner';
        $names[] = 'jquery.ui.tabs';
        $names[] = 'jquery.ui.tooltip';

        // jQuery Timepicker Addon (http://trentrichardson.com/examples/timepicker/)
        $names[] = 'jquery-ui-timepicker-addon';
        $names[] = 'jquery-ui-timepicker-addon-i18n';
        $names[] = 'jquery-ui-slideraccess';

        // Set jQuery UI Effects
        $names[] = 'jquery.ui.effect-min'; // core
        $names[] = 'jquery.ui.effect-blind';
        $names[] = 'jquery.ui.effect-bounce';
        $names[] = 'jquery.ui.effect-clip';
        $names[] = 'jquery.ui.effect-drop';
        $names[] = 'jquery.ui.effect-explode';
        $names[] = 'jquery.ui.effect-fade';
        $names[] = 'jquery.ui.effect-fold';
        $names[] = 'jquery.ui.effect-highlight';
        $names[] = 'jquery.ui.effect-pulsate';
        $names[] = 'jquery.ui.effect-scale';
        $names[] = 'jquery.ui.effect-shake';
        $names[] = 'jquery.ui.effect-slide';
        $names[] = 'jquery.ui.effect-transfer';
        
        foreach ($names as $name) {
            $this->library_files[$name]['file'] = 'javascript/jquery_ui/' . $name . '.min.js';
            $this->library_files[$name]['load'] = false;
        }         
    }
    
    /**
    * Set JavaScript Libraries to load
    *
    * @param    $name       name of JavaScript library to flag for loading
    * @param    $footer     set to true to include script in footer, else script placed in header
    * @access   public
    * @return   boolean 
    *
    */
    public function setJavaScriptLibrary($name, $footer = true) {
        
        global $_CONF;
        
        $name = strtolower($name);
                 
        if (!$footer) {
            // If something wants a library in the header then all in the header
            $this->library_files_footer = false;    
        }
        
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
    * Set Libraries file to load. Used only by class.
    *
    * @access   private
    * @return   boolean 
    *
    */      
    private function setJavaScriptLibraries() {

        global $_CONF;

        $librarycode = '';
        
        if ($this->jquery_cdn) {
            $librarycode .= '<script type="text/javascript" src="' . $this->jquery_cdn_file . '"></script>' . LB;
            $this->library_files['jquery']['load'] = false; // Set to false so not reloaded
            if ($this->jquery_ui_cdn) {
                $librarycode .= '<script type="text/javascript" src="' . $this->jquery_ui_cdn_file . '"></script>' . LB;
                // Since using CDN file reset loading of jQuery UI
                foreach ($this->library_files as $key => &$file) {
                    if (substr($key, 0, 7) == 'jquery.') {
                        $file['load'] = false;
                    }
                }                    
            }
        } elseif ($this->jquery_ui_cdn) { // This might happen if a jQuery UI file is not found
            $librarycode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . '/' . $this->library_files['jquery']['file'] . '"></script>' . LB;
            $this->library_files['jquery']['load'] = false; // Set to false so not reloaded
            $librarycode .= '<script type="text/javascript" src="' . $this->jquery_ui_cdn_file . '"></script>' . LB;
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
                $librarycode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . '/' . $file['file'] . '"></script>' . LB;
            }
        }
        
        return $librarycode;
    }     

    /**
    * Set JavaScript to load
    *
    * @param    $script     script to include in page
    * @param    $wrap       set to true to place script tags around contents of $script
    * @param    $footer     set to true to include script in footer, else script placed in header
    * @access   public
    * @return   boolean 
    *
    */    
    public function setJavaScript($script, $wrap = false, $footer = true) {
        
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
    * @param    $priority   In what order the script should be loaded in
    * @access   public
    * @return   boolean 
    *
    */     
    public function setJavaScriptFile($name, $file, $footer = true, $priority = 100) {
        
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
        $this->script_files[$name]['priority'] = $priority;
        
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
        $this->css_files[$name]['priority'] = 100; // Default is 100
        $this->css_files[$name]['constant'] = false;
        $this->css_files[$name]['load'] = $load;
        
        return true;
    }
    
    /**
    * Set language variables used in JavaScript.
    *
    * @param    $lang_array   array of language variables
    * @access   public
    * @return   boolean
    *
    */
    public function setLang($lang_array) {

        $this->lang = array_merge($this->lang, $lang_array);

        return true;
    }

    /**
    * Set CSS file to load
    *
    * @param    $name       name of CSS file
    * @param    $file       location of file relative to public_html directory. Include '/' at beginning
    * @param    $constant   Future use. Set to true if file is planned to be loaded all the time (Caching/Compression)
    * @param    $attributes (optional) array of extra attributes
    * @param    $priority   In what order the script should be loaded in
    * @param    $type       Type of css file  (current possible choices are theme or other)   
    * @access   public
    * @return   boolean 
    *
    */
    public function setCSSFile($name, $file, $constant = true, $attributes = array(), $priority = 100, $type = '') {
        
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
        $this->css_files[$name]['priority'] = $priority;
        $this->css_files[$name]['constant'] = $constant;
        if ($_CONF['theme_etag'] AND $type == 'theme') {
            // Don't load css regular way for themes with etag enabled
            $this->css_files[$name]['load'] = false;
        } else {
            $this->css_files[$name]['load'] = true;
        }
        
        return true;
    }
    

    /**
    * Set CSS in header using style tag
    *
    * @param    $css        css to include in head
    * @access   public
    * @return   boolean 
    *
    */    
    public function setCSS($css) {
        
        // If header code make sure header not already set
        if ($this->header_set) {
            return false;
        }
            
        $this->css[] = $css;
        
        $this->css_set = true;
        
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
        
        global $_CONF, $MESSAGE, $LANG_DIRECTION;
        
        $this->header_set = true;
        
        $headercode = '';

        // Sort CSS Files based on priority
        $priority = array();
        foreach($this->css_files as $k => $d) {
          $priority[$k] = $d['priority'];
        }
        array_multisort($priority, SORT_ASC, $this->css_files);
        
        // See if theme uses ETag, if so load first
        if ($_CONF['theme_etag']) {
            $csslink = '<link rel="stylesheet" type="text/css" href="'
                     . $_CONF['layout_url'] . '/style.css.php?theme=' . $_CONF['theme'] . '&amp;dir=' . $LANG_DIRECTION . '" media="all"' . XHTML . '>' . LB;
            $headercode = $csslink . $headercode;
        }
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
        // Set CSS         
        if ($this->css_set) {
            $headercode .= '<style type="text/css">' . LB;
            foreach ($this->css as $css) {
                $headercode .= $css . LB;
            }
            $headercode .= '</style>' . LB;
        }
        
        // Set JavaScript Library files first incase other scripts need them
        if (!$this->library_files_footer) { // // Do we load jQuery now?
            $headercode .= $this->setJavaScriptLibraries();
        }
        
        // Set JavaScript Variables (do this before file in case variables are needed)
        $iso639Code = COM_getLangIso639Code();
        $lang = array(
            'iso639Code'          => $iso639Code,
            'tooltip_loading'     => $MESSAGE[116],
            'tooltip_not_found'   => $MESSAGE[117],
            'tooltip_select_date' => $MESSAGE[118],
            'tabs_more'           => $MESSAGE[119],
            'confirm_delete'      => $MESSAGE[76],
            'confirm_send'        => $MESSAGE[120]
        );
        if (!empty($this->lang)) {
            $lang = array_merge($lang, $this->lang);
        }
        $src = array(
            'site_url'       => $_CONF['site_url'],
            'site_admin_url' => $_CONF['site_admin_url'],
            'layout_url'     => $_CONF['layout_url'],
            'xhtml'          => XHTML,
            'lang'           => $lang,
        );
        $str = $this->_array_to_jsobj($src);
        // Strip '{' and '}' from both ends of $str
        $str = substr($str, 1);
        $str = substr($str, 0, strlen($str) - 1);
        $headercode .= <<<EOD
<script type="text/javascript">
var geeklog = {
    doc: document,
    win: window,
    $: function (id) {
        return this.doc.getElementById(id);
    },
    {$str}
};
</script>

EOD;

        if (isset($this->scripts['header'])) {
            foreach ($this->scripts['header'] as $script) {
                $headercode .= $script . LB;
            }
        }

        // Sort JavaScript Files based on priority (this is for both header and footer)
        $priority = array();
        foreach($this->script_files as $k => $d) {
          $priority[$k] = $d['priority'];
        }
        array_multisort($priority, SORT_ASC, $this->script_files);          

        // Set JavaScript Files
        foreach ($this->script_files as $file) {
            if (!$file['footer']) {
                $headercode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . $file['file'] . '"></script>' . LB;
            }
        }
            
        return $headercode;
    }

    /**
    * Convert from array to JavaScript object format string
    *
    */
    private function _array_to_jsobj($src) {
        $retval = '{';
        foreach ($src as $key => $val) {
            $retval .= "$key:";
            if (is_array($val)) {
                $retval .= $this->_array_to_jsobj($val) . ',';
            } else {
                $retval .= '"' . $val . '",';
            }
        }
        $retval = rtrim($retval, ',') . '}';
        return $retval;
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
            // Set JavaScript Library files first incase other scripts need them
            if ($this->library_files_footer) { // Has jQuery already been loaded in header?
                $footercode .= $this->setJavaScriptLibraries();
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
