<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
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
 */
class Scripts
{
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
     * This initializes the Scripts object
     */
    public function __construct()
    {
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
     */
    private function findJavaScriptLibraries()
    {
        global $_CONF;

        $theme_path = '/layout/' . $_CONF['theme'];

        // Add Geeklog Specific JavaScript files. Treat them as library files since other plugins may try to load them
        $name = 'common';
        $this->library_files[$name]['file'] = 'javascript/common.js';
        $this->library_files[$name]['load'] = false;

        // jQuery (http://jquery.com/download/)
        // Find available jQuery library files
        $version_jQuery = '3.1.1'; // '1.11.3'; // '1.11.2'; // '1.10.2'; // '1.9.1'; // '1.9.0'; // '1.7.2'; // '1.6.3';
        $this->jquery_cdn_file = 'https://ajax.googleapis.com/ajax/libs/jquery/' . $version_jQuery . '/jquery.min.js';
        $name = 'jquery';
        // $this->library_files[$name]['file'] = 'javascript/jquery-' . $version_jQuery . '.min.js';
        $this->library_files[$name]['file'] = 'javascript/jquery.min.js';
        $this->library_files[$name]['load'] = false;

        // jQuery UI (http://plugins.jquery.com/ui.core/ and https://github.com/jquery/jquery-ui/releases)
        // When upgrading jQuery UI include the Redmond theme and all Core, Interactions and Widgets
        // Include minified version only of js
        // After Upgrade Test: Story Editor Topic Control, Story Editor Date & Time Picker, Submissions Help Pop up box, Admin Configuration Search and Tabs, Etc..
        $version_jQuery_ui = '1.12.1'; // '1.11.4'; // '1.11.2'; // '1.10.3'; // '1.10.1'; // '1.10.0'; // '1.8.20'; // '1.8.11';
        $this->jquery_ui_cdn_file = 'https://ajax.googleapis.com/ajax/libs/jqueryui/' . $version_jQuery_ui . '/jquery-ui.min.js';

        // Set jQuery UI CSS
        $this->setCSSFilePrivate('jquery-ui', $theme_path . '/jquery_ui/jquery-ui.min.css', 0.1, false);
        $this->setCSSFilePrivate('jquery-ui.structure', $theme_path . '/jquery_ui/jquery-ui.structure.min.css', 0.2, false);
        $this->setCSSFilePrivate('jquery-ui.theme', $theme_path . '/jquery_ui/jquery-ui.theme.min.css', 0.3, false);
        $this->setCSSFilePrivate('jquery-ui.geeklog', $theme_path . '/jquery_ui/jquery-ui.geeklog.css', 0.4, false);

        // Set jQuery UI 
        $names[] = 'jquery-ui';

        // Set jQuery UI Widgets (not included with core)
        $names[] = 'jquery-ui-i18n'; // extra included in core plugin under i18n directory (used by calendar and article dates)

        // jQuery Timepicker Addon (https://github.com/trentrichardson/jQuery-Timepicker-Addon and http://trentrichardson.com/examples/timepicker/)
        // Version 1.5.4
        $names[] = 'jquery-ui-timepicker-addon';
        $names[] = 'jquery-ui-timepicker-addon-i18n';
        $names[] = 'jquery-ui-slideraccess';

        foreach ($names as $name) {
            $this->library_files[$name]['file'] = 'javascript/jquery_ui/' . $name . '.min.js';
            $this->library_files[$name]['load'] = false;
        }
    }

    /**
     * Set JavaScript Libraries to load
     *
     * @param    string      $name       name of JavaScript library to flag for loading
     * @param    boolean     $footer     set to true to include script in footer, else script placed in header
     * @return   boolean
     */
    public function setJavaScriptLibrary($name, $footer = true)
    {
        global $_CONF;

        $name = strtolower($name);

        if (!$footer) {
            // If something wants a library in the header then all in the header
            $this->library_files_footer = false;
        }
        
        // For backwards compatible (Geeklog v2.1.1 and lower plugins)with jquery ui library when we specified individual widgets, effects, etc...
        if (substr($name, 0, 10) == 'jquery.ui.') {
            $name = 'jquery-ui'; // Instead we now load entire library
        }

        if (isset($this->library_files[$name])) {
            if (!$this->library_files[$name]['load']) {
                $this->library_files[$name]['load'] = true;
                // If name is subset of jQuery (. or - can be used) make sure all Core UI libraries are loaded
                if ((substr($name, 0, 7) === 'jquery-' || substr($name, 0, 7) === 'jquery.') && !$this->jquery_ui_cdn) {
                    // Check that file exists, if not use Google version
                    if (!file_exists($_CONF['path_html'] . $this->library_files[$name]['file'])) {
                        $this->jquery_ui_cdn = true;
                        $this->css_files['jquery-ui']['load'] = false;
                    } else {
                        $this->css_files['jquery-ui']['load'] = true;
                    }
                    $this->css_files['jquery-ui.structure']['load'] = true;
                    $this->css_files['jquery-ui.theme']['load'] = true;

                    // Geeklog specific css overrides for jQuery (includes timepicker-addon css)
                    $this->css_files['jquery-ui.geeklog']['load'] = true;

                    $this->library_files['jquery']['load'] = true;
                    $this->library_files['jquery-ui']['load'] = true;

                    if ($_CONF['cdn_hosted']) {
                        $this->jquery_cdn = true;
                        $this->jquery_ui_cdn = true;
                    }
                } elseif ($name === 'jquery' && $_CONF['cdn_hosted']) {
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
     */
    private function setJavaScriptLibraries()
    {
        global $_CONF;

        $libraryCode = '';

        if ($this->jquery_cdn) {
            $libraryCode .= '<script type="text/javascript" src="' . $this->jquery_cdn_file . '"></script>' . LB;
            $this->library_files['jquery']['load'] = false; // Set to false so not reloaded
            if ($this->jquery_ui_cdn) {
                $libraryCode .= '<script type="text/javascript" src="' . $this->jquery_ui_cdn_file . '"></script>' . LB;
                // Since using CDN file reset loading of jQuery UI
                foreach ($this->library_files as $key => &$file) {
                    if (substr($key, 0, 7) === 'jquery.') {
                        $file['load'] = false;
                    }
                }
                unset($file);
            }
        } elseif ($this->jquery_ui_cdn) { // This might happen if a jQuery UI file is not found
            $libraryCode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . '/' . $this->library_files['jquery']['file'] . '"></script>' . LB;
            $this->library_files['jquery']['load'] = false; // Set to false so not reloaded
            $libraryCode .= '<script type="text/javascript" src="' . $this->jquery_ui_cdn_file . '"></script>' . LB;
            // Since using CDN file reset loading of jQuery UI
            foreach ($this->library_files as $key => &$file) {
                if (substr($key, 0, 7) === 'jquery.') {
                    $file['load'] = false;
                }
            }
            unset($file);
        }

        // Now load in the rest of the libraries
        foreach ($this->library_files as $file) {
            if ($file['load']) {
                $libraryCode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . '/' . $file['file'] . '"></script>' . LB;
            }
        }

        return $libraryCode;
    }

    /**
     * Set JavaScript to load
     *
     * @param    string      $script     script to include in page
     * @param    boolean     $wrap       set to true to place script tags around contents of $script
     * @param    boolean     $footer     set to true to include script in footer, else script placed in header
     * @return   boolean
     */
    public function setJavaScript($script, $wrap = false, $footer = true)
    {
        // If header code make sure header not already set
        if ($this->header_set && !$footer) {
            return false;
        }

        $location = $footer ? 'footer' : 'header';

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
     * @param    string      $name       name of JavaScript file
     * @param    string      $file       location of file relative to public_html directory. Include '/' at beginning
     * @param    boolean     $footer     set to true to include script in footer, else script placed in header
     * @param    int         $priority   In what order the script should be loaded in
     * @return   boolean
     */
    public function setJavaScriptFile($name, $file, $footer = true, $priority = 100)
    {
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
        if (!is_file($path) || !is_readable($path)) {
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
     * This function is used to include any CSS needed by the JavaScript Libraries
     *
     * @param    string      $name       name of CSS file
     * @param    string      $file       location of file relative to public_html directory. Include '/' at beginning
     * @param    int         $priority   In what order the script should be loaded in
     * @param    boolean     $load       set to true to load script right away. Should only be loaded when related script is loaded
     * @return   boolean
     */
    private function setCSSFilePrivate($name, $file, $priority = 100, $load = true)
    {
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
        if (!is_file($path) || !is_readable($path)) {
            return false;
        }

        $this->css_files[$name]['file'] = $file;
        $this->css_files[$name]['extra'] = '';
        $this->css_files[$name]['priority'] = $priority; // Default is 100
        $this->css_files[$name]['constant'] = false;
        $this->css_files[$name]['load'] = $load;

        return true;
    }

    /**
     * Set language variables used in JavaScript.
     *
     * @param    array     $lang_array   array of language variables
     * @return   boolean
     */
    public function setLang($lang_array)
    {
        $this->lang = array_merge($this->lang, $lang_array);

        return true;
    }

    /**
     * Set CSS file to load
     *
     * @param    string      $name       name of CSS file
     * @param    string      $file       location of file relative to public_html directory. Include '/' at beginning
     * @param    boolean     $constant   Future use. Set to true if file is planned to be loaded all the time (Caching/Compression)
     * @param    array       $attributes (optional) array of extra attributes
     * @param    int         $priority   In what order the script should be loaded in
     * @param    string      $type       Type of css file  (current possible choices are theme or other)
     * @return   boolean
     */
    public function setCSSFile($name, $file, $constant = true, $attributes = array(), $priority = 100, $type = '')
    {
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
        if (!is_file($path) || !is_readable($path)) {
            return false;
        }

        $extra = '';
        foreach ($attributes as $key => $value) {
            if (in_array($key, array('rel', 'type', 'href'))) {
                $this->css_files[$name][$key] = $value;
            } else {
                $extra .= " $key=\"$value\"";
            }
        }

        $this->css_files[$name]['name'] = $name;
        $this->css_files[$name]['file'] = $file;
        $this->css_files[$name]['extra'] = $extra;
        $this->css_files[$name]['priority'] = $priority;
        $this->css_files[$name]['constant'] = $constant;

        if ($_CONF['theme_etag'] && ($type === 'theme')) {
            // Don't load css regular way for themes with eTag enabled
            $this->css_files[$name]['load'] = false;
        } else {
            $this->css_files[$name]['load'] = true;
        }

        return true;
    }

    /**
     * Set CSS in header using style tag
     *
     * @param    string      $css        css to include in head
     * @return   boolean
     */
    public function setCSS($css)
    {
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
     * @return   string
     */
    public function getHeader()
    {
        global $_CONF, $MESSAGE, $LANG_DIRECTION;

        $this->header_set = true;
        $headerCode = '';

        // Sort CSS Files based on priority
        $priority = array();
        foreach ($this->css_files as $k => $d) {
            $priority[$k] = $d['priority'];
        }
        array_multisort($priority, SORT_ASC, $this->css_files);

        // See if theme uses ETag, if so load first
        if ($_CONF['theme_etag']) {
            $cssLink = '<link rel="stylesheet" type="text/css" href="'
                . $_CONF['layout_url'] . '/style.css.php?theme=' . $_CONF['theme'] . '&amp;dir=' . $LANG_DIRECTION . '" media="all"' . XHTML . '>' . LB;
            $headerCode = $cssLink . $headerCode;
        }
        // Set CSS Files
        foreach ($this->css_files as $file) {
            $rel = 'stylesheet';
            if (!empty($file['rel'])) {
                $rel = $file['rel'];
            }
            $type = 'text/css';
            if (!empty($file['type'])) {
                $type = $file['type'];
            }
            $href = '';
            if (!empty($file['file'])) {
                $href = $_CONF['site_url'] . $file['file'];
            }
            if (!empty($file['href'])) {
                $href = $file['href'];
            }

            if ($file['load'] && !empty($href)) {
                $cssLink = '<link rel="' . $rel
                    . '" type="' . $type
                    . '" href="' . $href
                    . '"' . $file['extra'] . XHTML . '>' . LB;

                if (isset($file['name']) && $file['name'] === 'theme') { // load theme css first
                    $headerCode = $cssLink . $headerCode;
                } else {
                    $headerCode .= $cssLink;
                }
            }
        }
        // Set CSS
        if ($this->css_set) {
            $headerCode .= '<style type="text/css">' . LB;
            foreach ($this->css as $css) {
                $headerCode .= $css . LB;
            }
            $headerCode .= '</style>' . LB;
        }

        // Set JavaScript Library files first in case other scripts need them
        if (!$this->library_files_footer) { // // Do we load jQuery now?
            $headerCode .= $this->setJavaScriptLibraries();
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
            'confirm_send'        => $MESSAGE[120],
        );
        if (!empty($this->lang)) {
            $lang = array_merge($lang, $this->lang);
        }

        require_once __DIR__ . '/mobiledetect/Mobile_Detect.php';
        $detect = new Mobile_Detect;
        $device = array(
            'isMobile' => $detect->isMobile(),
            'isTablet' => $detect->isTablet(),
        );

        $src = array(
            'site_url'       => $_CONF['site_url'],
            'site_admin_url' => $_CONF['site_admin_url'],
            'layout_url'     => $_CONF['layout_url'],
            'xhtml'          => XHTML,
            'lang'           => $lang,
            'device'         => $device,
            'theme_options'  => $_CONF['theme_options'],
        );
        $str = $this->_array_to_jsobj($src);
        // Strip '{' and '}' from both ends of $str
        $str = substr($str, 1);
        $str = substr($str, 0, strlen($str) - 1);
        $headerCode .= <<<EOD
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
                $headerCode .= $script . LB;
            }
        }

        // Sort JavaScript Files based on priority (this is for both header and footer)
        $priority = array();
        foreach ($this->script_files as $k => $d) {
            $priority[$k] = $d['priority'];
        }
        array_multisort($priority, SORT_ASC, $this->script_files);

        // Set JavaScript Files
        foreach ($this->script_files as $file) {
            if (!$file['footer']) {
                $headerCode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . $file['file'] . '"></script>' . LB;
            }
        }

        return $headerCode;
    }

    /**
     * Convert from array to JavaScript object format string
     *
     * @param  array $src
     * @return string
     */
    private function _array_to_jsobj($src)
    {
        $retval = '{';
        foreach ($src as $key => $val) {
            $retval .= "$key:";
            switch (gettype($val)) {
                case 'array':
                    $retval .= $this->_array_to_jsobj($val) . ',';
                    break;

                case 'boolean':
                    $retval .= $val ? 'true,' : 'false,';
                    break;

                case 'NULL':
                    $retval .= 'null,';
                    break;

                case 'integer':
                case 'double':
                    $retval .= $val . ',';
                    break;

                default:
                    $retval .= '"' . $val . '",';
                    break;
            }
        }
        $retval = rtrim($retval, ',') . '}';

        return $retval;
    }

    /**
     * Returns JavaScript footer code to be placed just before </body>
     *
     * @return   string
     */
    public function getFooter()
    {
        global $_CONF;

        $footerCode = '';

        // Do we need to set JavaScript
        if ($this->javascript_set) {
            // Set JavaScript Library files first in case other scripts need them
            if ($this->library_files_footer) { // Has jQuery already been loaded in header?
                $footerCode .= $this->setJavaScriptLibraries();
            }

            // Set JavaScript (do this before file in case variables are needed)
            if (isset($this->scripts['footer'])) {
                foreach ($this->scripts['footer'] as $script) {
                    $footerCode .= $script . LB;
                }
            }

            // Set JavaScript Files
            foreach ($this->script_files as $file) {
                if ($file['footer']) {
                    $footerCode .= '<script type="text/javascript" src="' . $_CONF['site_url'] . $file['file'] . '"></script>' . LB;
                }
            }
        }

        return $footerCode;
    }
}
