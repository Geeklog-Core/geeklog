<?php

// +--------------------------------------------------------------------------+
// | Geeklog 2.0                                                              |
// +--------------------------------------------------------------------------+
// | template.class.php                                                       |
// |                                                                          |
// | Geeklog template library.                                                |
// +--------------------------------------------------------------------------+
// | Copyright (C) 2007-2013 by the following authors:                        |
// |                                                                          |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                  |
// |          Dirk Haun          - dirk AT haun-online DOT de                 |
// |          Oliver Spiesshofer - oliver AT spiesshofer DOT com              |
// |          Blaine Lang        - blaine AT portalparts DOT com              |
// |          Kenji ITO          - geeklog AT mystral-kk DOT net              |
// |          dengen             - taharaxp AT gmail DOT com                  |
// |          Tom Homer          - websitemaster AT cogeco DOT net            |
// |          Joe Mucchiello     - joe AT throwingdice DOT com                |
// |          Mark R. Evans      - mark AT glfusion DOT org                   |
// |                                                                          |
// | Based on phpLib Template Library                                         |
// | (C) Copyright 1999-2000 NetUSE GmbH                                      |
// |                 Kristian Koehntopp                                       |
// | Bug fixes to version 7.2c compiled by                                    |
// |          Richard Archer <rha@juggernaut.com.au>:                         |
// | (credits given to first person to post a diff to phplib mailing list)    |
// +--------------------------------------------------------------------------+
// |                                                                          |
// | This program is free software; you can redistribute it and/or            |
// | modify it under the terms of the GNU General Public License              |
// | as published by the Free Software Foundation; either version 2           |
// | of the License, or (at your option) any later version.                   |
// |                                                                          |
// | This program is distributed in the hope that it will be useful,          |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of           |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            |
// | GNU General Public License for more details.                             |
// |                                                                          |
// | You should have received a copy of the GNU General Public License        |
// | along with this program; if not, write to the Free Software Foundation,  |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.          |
// |                                                                          |
// +--------------------------------------------------------------------------+

/**
 * The template class allows you to keep your HTML code in some external files
 * which are completely free of PHP code, but contain replacement fields.
 * The class provides you with functions which can fill in the replacement fields
 * with arbitrary strings. These strings can become very large, e.g. entire tables.
 *
 * Note: If you think that this is like FastTemplates, read carefully. It isn't.
 */
/* This should be the only Geeklog-isms in the file. Didn't want to "infect" the class but it was necessary.
 * These options are global to all templates.
 */

class Template
{
    /**
     * Serialization helper, the name of this class.
     *
     * @var       string
     */
    public $classname = 'Template';

    /**
     * Determines how much debugging output Template will produce.
     * This is a bitwise mask of available debug levels:
     * 0 = no debugging
     * 1 = debug variable assignments
     * 2 = debug calls to get variable
     * 4 = debug internals (outputs all function calls with parameters).
     * 8 = debug caching (incomplete)
     *
     * Note: setting $this->debug = true will enable debugging of variable
     * assignments only which is the same behaviour as versions up to release 7.2d.
     *
     * @var       int
     */
    public $debug = 0;

    /**
     * The base directory array from which template files are loaded. When
     * attempting to open a file, the paths in this array are searched one at
     * a time. As soon as a file exists, the array search stops.
     *
     * @var       array|string
     * @see       set_root
     */
    private $root = array();

    /**
     * A hash of strings forming a translation table which translates variable names
     * into names of files containing the variable content.
     * $file[$varName] = "filename";
     *
     * @var       array/string
     * @see       set_file
     */
    private $file = array();

    /**
     * A hash of strings forming a translation table which translates variable names
     * into names of files containing the variable content.
     * $location[$varName] = "full path to template";
     *
     * @var       array
     * @see       set_file
     */
    private $location = array();

    /**
     * Tells template class if dealing with a template file or a view passed instead.
     * If view no file access needed and no caching allowed. Default assumed always is no view.
     * $view[$varName] = true;
     *
     * @var       array/boolean
     * @see       set_view
     */
    private $view = array();

    /**
     * The in memory template
     *
     * @var       array
     * @see       set_file
     */
    private $templateCode = array();

    /**
     * A hash of strings forming a translation table which translates variable names
     * into names of files containing the variable content.
     * $file[$varName] = "filename";
     *
     * @var       array
     * @see       cache_blocks,set_block
     */
    private $blocks = array();

    /**
     * A hash of strings forming a translation table which translates variable names
     * into the parent name of the variable.
     *
     * @var       array
     * @see       cache_blocks,set_block, block_echo
     */
    private $block_replace = array();

    /**
     * A hash of strings forming a translation table which translates variable names
     * into regular expressions for themselves.
     * $varKeys[$varName] = "/varName/"
     *
     * @var       array
     * @see       set_var
     */
    private $varKeys = array();

    /**
     * A hash of strings forming a translation table which translates variable names
     * into values for their respective varKeys.
     * $varVals[$varName] = "value"
     *
     * @var       array
     * @access    private
     * @see       set_var
     */
    private $varVals = array();

    /**
     * A hash of vars that are not to be translated when create_instance() is called.
     * $nocache[varName] = true
     *
     * @var       array
     * @see       create_instance, val_echo, mod_echo
     */
    private $nocache = array();

    /**
     * Determines how to output variable tags with no assigned value in templates.
     *
     * @var       string
     * @see       set_unknowns
     */
    private $unknowns = 'remove';

    /**
     * Determines how Template handles error conditions.
     * "yes"      = the error is reported, then execution is halted
     * "report"   = the error is reported, then execution continues by returning "false"
     * "no"       = errors are silently ignored, and execution resumes reporting "false"
     * "log"      = writes errors to Error log and returns false.
     *
     * @var       string
     * @see       halt
     */
    public $halt_on_error = 'yes';

    /**
     * The last error message is retained in this variable.
     *
     * @var       string
     * @see       halt
     */
    public $last_error = '';

    /**
     * The name of a function is retained in this variable and is used to do any pre processing work.
     *
     * @var       string
     * @see       _preprocess
     */
    public $preprocess_fn = '';

    /**
     * The name of a function is retained in this variable and is used to do any post processing work.
     *
     * @var       string
     * @see       _postprocess
     */
    public $postprocess_fn = '';

    /**
     * Pre Process
     *
     * Perform any post processing work by calling the function held in $preprocess_fn
     *
     * @param    string $str
     * @return   string
     */
    private function _preprocess($str)
    {
        $function = $this->preprocess_fn;

        if (function_exists($function)) {
            $str = $function($str);
        }

        return $str;
    }

    /**
     * Post Process
     *
     * Perform any post processing work by calling the function held in $postprocess_fn
     *
     * @param    string $str
     * @return   string
     */
    private function _postprocess($str)
    {
        $function = $this->postprocess_fn;

        if (function_exists($function)) {
            $str = $function($str);
        }

        return $str;
    }

    /******************************************************************************
     * Class constructor. May be called with two optional parameters.
     * The first parameter sets the template directory the second parameter
     * sets the policy regarding handling of unknown variables.
     *
     * usage: Template([string $root = array()], [string $unknowns = "remove"])
     *
     * @param    array|string $root     path to template directory
     * @param    string       $unknowns what to do with undefined variables
     * @see      set_root
     * @see      set_unknowns
     */
    public function __construct($root = array('.'), $unknowns = 'remove')
    {
        global $_CONF, $TEMPLATE_OPTIONS, $LANG_ISO639_1;

        // Set $TEMPLATE_OPTIONS if Template class is called during tests
        if (empty($TEMPLATE_OPTIONS) || !is_array($TEMPLATE_OPTIONS)) {
            $TEMPLATE_OPTIONS = array(
                'path_cache'          => $_CONF['path_data'] . 'layout_cache/',   // location of template cache
                'path_prefixes'       => array(                               // used to strip directories off file names. Order is important here.
                    $_CONF['path_themes'],  // this is not path_layout. When stripping directories, you want files in different themes to end up in different directories.
                    $_CONF['path'],
                    '/'                     // this entry must always exist and must always be last
                ),
                'incl_phpself_header' => true,          // set this to true if your template cache exists within your web server's docroot.
                'cache_by_language'   => true,            // create cache directories for each language. Takes extra space but moves all $LANG variable text directly into the cached file
                'cache_for_mobile'    => $_CONF['cache_mobile'],  // create cache directories for mobile devices. Non mobile devices uses regular directory. If disabled mobile uses regular cache files. Takes extra space
                'default_vars'        => array(                                // list of vars found in all templates.
                    'xhtml'           => (defined('XHTML') ? XHTML : ''),
                    'site_url'        => $_CONF['site_url'],
                    'site_admin_url'  => $_CONF['site_admin_url'],
                    'layout_url'      => $_CONF['layout_url'], // Can be set by lib-common on theme change
                    'anonymous_user'  => true,
                    'device_mobile'   => false,
					'language_code'	  => $LANG_ISO639_1,
                    'front_page'      => false,
                    'current_url'     => ''
                ),
                'hook'                => array(),
            );
        }

        if (array_key_exists('default_vars', $TEMPLATE_OPTIONS) && is_array($TEMPLATE_OPTIONS['default_vars'])) {
            foreach ($TEMPLATE_OPTIONS['default_vars'] as $k => $v) {
                $this->set_var($k, $v);
            }
        }

        $this->set_root($root);
        $this->set_unknowns($unknowns);

        if (isset($_CONF['cache_templates']) && ($_CONF['cache_templates'] == true) &&
            !defined('GL_INSTALL_ACTIVE')) {
            clearstatcache();
        }

        // Since GL-2.2.0
        if (COM_isEnableDeveloperModeLog('template')) {
            $this->halt_on_error = 'log';
        }
    }

    /******************************************************************************
     * Checks that $root is a valid directory and if so sets this directory as the
     * base directory from which templates are loaded by storing the value in
     * $this->root. Relative file names are prepended with the path in $this->root.
     *
     * Returns true on success, false on error.
     *
     * usage: set_root(string $root)
     *
     * @param     string|array $root string|array containing new template directory
     * @see       root
     * @return    boolean
     */
    public function set_root($root)
    {
        global $TEMPLATE_OPTIONS;

        if ($this->debug & 4) {
            echo '<p><b>set_root:</b> root = array(' . (count($root) > 0 ? '"' . implode('","', $root) . '"' : '') . ")</p>\n";
        }
        if (isset($TEMPLATE_OPTIONS['hook']['set_root'])) {
            $function = $TEMPLATE_OPTIONS['hook']['set_root'];
            if (is_callable($function)) {
                $root = call_user_func($function, $root);
            }
        }

        // Make root now array if not already (hook above runs CTL_setTemplateRoot for plugins that do not use COM_newTemplate and CTL_core_templatePath which will be required as of Geeklog 3.0.0
        // CTL_setTemplateRoot needs to figure out things based on if the root passed is an array or not
        // As of Geeklog 3.0.0 this arracy check should be moved to right after setting global variables in this function
        // For more info see COM_newTemplate, CTL_setTemplateRoot, CTL_core_templatePath, CTL_plugin_templatePath
        if (!is_array($root)) {
            $root = array($root);
        }

        if ($this->debug & 4) {
            echo '<p><b>set_root:</b> root = array(' . (count($root) > 0 ? '"' . implode('","', $root) . '"' : '') . ")</p>\n";
        }
        $this->root = array();
        $missing = array();

        foreach ($root as $r) {
            if (substr($r, -1) == '/') {
                $r = substr($r, 0, -1);
            }
            if (!@is_dir($r)) {
                $missing[] = $r;
                continue;
            }
            $this->root[] = $r;
        }

        if ($this->debug & 4) {
            echo '<p><b>set_root:</b> root = array(' . (count($root) > 0 ? '"' . implode('","', $root) . '"' : '') . ")</p>\n";
        }
        if (count($this->root) > 0) {
            return true;
        }

        if (count($missing) > 0) {
            $this->halt("set_root: none of these directories exist: " . implode(', ', $missing));
        } else {
            $this->halt("set_root: at least one existing directory must be set as root.");
        }

        return false;
    }

    /**
     * Return the root directory of the templates
     *
     * @return array|string
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Return unknowns
     *
     * @return string
     */
    public function getUnknowns()
    {
        return $this->unknowns;
    }

    /******************************************************************************
     * Sets the policy for dealing with unresolved variable names.
     *
     * unknowns defines what to do with undefined template variables
     * "remove"   = remove undefined variables
     * "comment"  = replace undefined variables with comments
     * "keep"     = keep undefined variables
     *
     * Note: "comment" can cause unexpected results when the variable tag is embedded
     * inside an HTML tag, for example a tag which is expected to be replaced with a URL.
     *
     * usage: set_unknowns(string $unknowns)
     *
     * @param    string $unknowns new value for unknowns
     * @see       unknowns
     * @return    void
     */
    public function set_unknowns($unknowns = '')
    {
        global $TEMPLATE_OPTIONS;

        if (isset($TEMPLATE_OPTIONS['force_unknowns'])) {
            $unknowns = $TEMPLATE_OPTIONS['force_unknowns'];
        } elseif (empty($unknowns)) {
            if (isset($TEMPLATE_OPTIONS['unknowns'])) {
                $unknowns = $TEMPLATE_OPTIONS['unknowns'];
            } else {
                $unknowns = 'remove';
            }
        }

        if ($this->debug & 4) {
            echo "<p><b>unknowns:</b> unknowns = $unknowns</p>\n";
        }
        $this->unknowns = $unknowns;
    }

    /******************************************************************************
     * Defines a view for the initial value of a variable. A view is the template
     * contents (similarly what a template file contains).
     *
     * It may be passed either a var name and a view as two strings or
     * a hash of strings with the key being the var name and the value
     * being the file name.
     *
     * Since the content is already loaded and passed to the class (from whatever
     * source like database or other file, the class does not care) there is no
     * mappings. The contents of the view are then complied right away.  Views
     * cannot be cached since in most cases whatever is requesting the view to be
     * complied is probably going to be cached.
     *
     * Returns true on success, false on error.
     *
     * usage: set_view(array $views = (string $varName => string $view))
     * or
     * usage: set_view(string $varName, string $view)
     *
     * @param     string|array $varName  either a string containing a var name
     *                                   or a hash of var name/view pairs.
     * @param     string       $view     if var name is a string this is the view
     *                                   otherwise view is not required
     * @return    bool
     */
    public function set_view($varName, $view = '')
    {
        if (!is_array($varName)) {
            if ($this->debug & 4) {
                echo "<p><b>set_view:</b> (with scalar) varName = $varName, view = $view</p>\n";
            }
            if ($view == '') {
                $this->halt("set_view: For varName $varName view is empty.");

                return false;
            }

            $templateCode = $this->compile_template($varName, $view, false);
            $this->templateCode[$varName] = $templateCode;

            $this->location[$varName] = ''; // No location since view
            $this->view[$varName] = true;
        } else {
            foreach ($varName as $var => $v) {
                if ($this->debug & 4) {
                    echo "<p><b>set_view:</b> (with array) varName = $var, view = $v</p>\n";
                }
                if ($v == '') {
                    $this->halt("set_view: For varName $var view is empty.");

                    return false;
                }

                $v = $this->compile_template($var, $v, false);
                $this->templateCode[$var] = $v;

                $this->location[$var] = ''; // no location since view
                $this->view[$var] = true;
            }
        }

        return true;
    }

    /******************************************************************************
     * Defines a filename for the initial value of a variable.
     *
     * It may be passed either a var name and a file name as two strings or
     * a hash of strings with the key being the var name and the value
     * being the file name.
     *
     * The new mappings are stored in the array $this->file.
     * The files are not loaded yet, but only when needed.
     *
     * Returns true on success, false on error.
     *
     * usage: set_file(array $fileList = (string $varName => string $filename))
     * or
     * usage: set_file(string $varName, string $filename)
     *
     * @param     string|array $varName          either a string containing a var name
     *                                           or a hash of var name/file name pairs.
     * @param     string       $filename         if var name is a string this is the filename otherwise filename is not
     *                                           required
     * @return    boolean
     */
    public function set_file($varName, $filename = '')
    {
        global $_CONF;

        if (!is_array($varName)) {
            if ($this->debug & 4) {
                echo "<p><b>set_file:</b> (with scalar) varName = $varName, filename = $filename</p>\n";
            }
            if ($filename == "") {
                $this->halt("set_file: For varName $varName filename is empty.");

                return false;
            }
            $tFilename = $this->filename($filename);
            if (isset($_CONF['cache_templates']) && ($_CONF['cache_templates'] == true) &&
                !defined('GL_INSTALL_ACTIVE')) {
                $filename = $this->check_cache($varName, $tFilename);
                $this->file[$varName] = $filename;
            } else {
                $templateCode = $this->compile_template($varName, $tFilename);
                $this->templateCode[$varName] = $templateCode;
            }
            $this->location[$varName] = $tFilename;
            $this->view[$varName] = false;
        } else {
            foreach ($varName as $v => $f) {
                if ($this->debug & 4) {
                    echo "<p><b>set_file:</b> (with array) varName = $v, filename = $f</p>\n";
                }
                if ($f == "") {
                    $this->halt("set_file: For varName $v filename is empty.");

                    return false;
                }
                $tFilename = $this->filename($f);
                if (isset($_CONF['cache_templates']) && ($_CONF['cache_templates'] == true) &&
                    !defined('GL_INSTALL_ACTIVE')) {
                    $f = $this->check_cache($v, $tFilename);
                    $this->file[$v] = $f;
                } else {
                    $f = $this->compile_template($v, $tFilename);
                    $this->templateCode[$v] = $f;
                }
                $this->location[$v] = $tFilename;
                $this->view[$v] = false;
            }
        }

        return true;
    }

    /******************************************************************************
     * A variable $parent may contain a variable block defined by:
     * &lt;!-- BEGIN $varName --&gt; content &lt;!-- END $varName --&gt;. This function removes
     * that block from $parent and replaces it with a variable reference named $name.
     * The block is inserted into the varKeys and varVals hashes. If $name is
     * omitted, it is assumed to be the same as $varName.
     *
     * Blocks may be nested but care must be taken to extract the blocks in order
     * from the innermost block to the outermost block.
     *
     * Returns true on success, false on error.
     *
     * usage: set_block(string $parent, string $varName, [string $name = ""])
     *
     * @param     string $parent  a string containing the name of the parent variable
     * @param     string $varName a string containing the name of the block to be extracted
     * @param     string $name    the name of the variable in which to store the block
     * @return    boolean
     */
    public function set_block($parent, $varName, $name = '')
    {
        global $_CONF;

        $this->block_replace[$varName] = !empty($name) ? $name : $parent;

        // if (isset($_CONF['cache_templates']) && ($_CONF['cache_templates'] == true)) {
        // if (isset($_CONF['cache_templates']) && ($_CONF['cache_templates'] == true) && (!isset($this->view[$varName]) || ($this->view[$varName] == false))) {
        // Should use parent here when checking view since assumed parent is the view that was set or not.
        // NOTE: This means while blocks can be set in views they CANNOT be nested
        // VIEWS with blocks need to be TESTED better as maybe there is a workaround to this
        if (isset($_CONF['cache_templates']) && ($_CONF['cache_templates'] == true) &&
            !defined('GL_INSTALL_ACTIVE') &&
            (!isset($this->view[$parent]) || ($this->view[$parent] == false))) {
            $filename = $this->file[$parent];
            $p = pathinfo($filename);
            $this->blocks[$varName] = $p['dirname'] . '/' . substr($p['basename'], 0, -(strlen($p['extension']) + 1)) . '__' . $varName . '.' . $p['extension'];
            $this->file[$varName] = $p['dirname'] . '/' . substr($p['basename'], 0, -(strlen($p['extension']) + 1)) . '.' . $p['extension'];
        }

        return true;
    }

    /**
     * Modifies template location to prevent non-Root users from seeing it
     *
     * @param    string $location
     * @return   string   If the current user is in the Root group, $location is
     *                    unchanged.  Otherwise, $location is changed into a path
     *                    relative to $_CONF['path_layout'].
     */
    protected function _modifyTemplateLocation($location)
    {
        global $_CONF;
        static $switch = null;

        if ($switch === null) {
            $switch = ($this->debug > 0) && SEC_inGroup('Root');
        }

        if (!$switch) {
            $location = str_ireplace($_CONF['path_layout'], '', $location);
        }

        return $location;
    }

    /******************************************************************************
     * This functions sets the value of a variable.
     *
     * It may be called with either a varName and a value as two strings or an
     * an associative array with the key being the varName and the value being
     * the new variable value.
     *
     * The function inserts the new value of the variable into the $varKeys and
     * $varVals hashes. It is not necessary for a variable to exist in these hashes
     * before calling this function.
     *
     * An optional third parameter allows the value for each varName to be appended
     * to the existing variable instead of replacing it. The default is to replace.
     * This feature was introduced after the 7.2d release.
     *
     * usage: set_var(string $varName, [string $value = ""], [boolean $append = false])
     * or
     * usage: set_var(array $varName = (string $varName => string $value), [mixed $dummy_var], [boolean $append =
     * false])
     *
     * @param     string|array $varName          either a string containing a varName or a hash of varName/value pairs.
     * @param     string       $value            if $varName is a string this contains the new value
     *                                           for the variable otherwise this parameter is ignored
     * @param     boolean      $append           if true, the value is appended to the variable's existing value
     * @param     boolean      $nocache          if true, the variable is added to the list of variable that are not
     *                                           instance cached.
     * @return    void
     */
    public function set_var($varName, $value = '', $append = false, $nocache = false)
    {
        if (!is_array($varName)) {
            if (!empty($varName) || ($varName == 0)) { // Allow varName to be numbers including 0
                if ($this->debug & 1) {
                    printf("<b>set_var:</b> (with scalar) <b>%s</b> = '%s'<br>\n", $varName, htmlentities($value));
                }

                if ($varName === 'templatelocation') {
                    $value = $this->_modifyTemplateLocation($value);
                }

                if ($append && isset($this->varVals[$varName])) {
                    $this->varVals[$varName] .= $value;
                } else {
                    $this->varVals[$varName] = $value;
                }
                if ($nocache) {
                    $this->nocache[$varName] = true;
                }
            }
        } else {
            foreach ($varName as $k => $v) {
                if (!empty($k) || ($k == 0)) { // Allow varName to be numbers including 0
                    if ($this->debug & 1) {
                        printf("<b>set_var:</b> (with array) <b>%s</b> = '%s'<br>\n", $k, htmlentities($v));
                    }

                    if ($k === 'templatelocation') {
                        $v = $this->_modifyTemplateLocation($v);
                    }

                    if ($append && isset($this->varVals[$k])) {
                        $this->varVals[$k] .= $v;
                    } else {
                        $this->varVals[$k] = $v;

                        if (is_array($value)) {
                            foreach ($value as $k2 => $v2) {
                                $this->set_var($varName . '[' . $k2 . ']', $v2, $append);
                            }
                        }
                    }
                    if ($nocache) {
                        $this->nocache[$k] = true;
                    }
                }
            }
        }
    }

    /******************************************************************************
     * This functions clears the value of a variable.
     *
     * It may be called with either a varName as a string or an array with the
     * values being the varNames to be cleared.
     *
     * The function sets the value of the variable in the $varKeys and $varVals
     * hashes to "". It is not necessary for a variable to exist in these hashes
     * before calling this function.
     *
     *
     * usage: clear_var(string $varName)
     * or
     * usage: clear_var(array $varName = (string $varName))
     *
     * @param     string|array $varName either a string containing a varName or an array of varNames.
     * @return    void
     */
    public function clear_var($varName)
    {
        if (!is_array($varName)) {
            if (!empty($varName) || ($varName == 0)) { // Allow number variable names including 0
                if ($this->debug & 1) {
                    printf("<b>clear_var:</b> (with scalar) <b>%s</b><br>\n", $varName);
                }
                $this->set_var($varName, "");
            }
        } else {
            foreach ($varName as $k => $v) {
                if (!empty($v) || ($v == 0)) { // Allow number variable names including 0
                    if ($this->debug & 1) {
                        printf("<b>clear_var:</b> (with array) <b>%s</b><br>\n", $v);
                    }
                    $this->set_var($v, '');
                }
            }
        }
    }

    /******************************************************************************
     * This functions unsets a variable completely.
     *
     * It may be called with either a varName as a string or an array with the
     * values being the varNames to be cleared.
     *
     * The function removes the variable from the $varKeys and $varVals hashes.
     * It is not necessary for a variable to exist in these hashes before calling
     * this function.
     *
     * usage: unset_var(string $varName)
     * or
     * usage: unset_var(array $varName = (string $varName))
     *
     * @param     string|array $varName either a string containing a varName or an array of varNames.
     * @return    void
     */
    public function unset_var($varName)
    {
        if (!is_array($varName)) {
            if (!empty($varName) || ($varName == 0)) { // Allow number variable names including 0
                if ($this->debug & 1) {
                    printf("<b>unset_var:</b> (with scalar) <b>%s</b><br>\n", $varName);
                }
                unset($this->varKeys[$varName]);
                unset($this->varVals[$varName]);
            }
        } else {
            foreach ($varName as $k => $v) {
                if (!empty($v) || ($v == 0)) { // Allow number variable names including 0
                    if ($this->debug & 1) {
                        printf("<b>unset_var:</b> (with array) <b>%s</b><br>\n", $v);
                    }
                    unset($this->varKeys[$v]);
                    unset($this->varVals[$v]);
                }
            }
        }
    }

    /******************************************************************************
     * This function fills in all the variables contained within the variable named
     * $varName. The resulting value is returned as the function result and the
     * original value of the variable varName is not changed. The resulting string
     * is not "finished", that is, the unresolved variable name policy has not been
     * applied yet.
     *
     * Returns: the value of the variable $varName with all variables substituted.
     *
     * usage: subst(string $varName)
     *
     * @param     string $varName the name of the variable within which variables are to be substituted
     * @return    string
     */
    public function subst($varName)
    {
        global $_CONF, $LANG01;

        // If view always bypass cache
        if (isset($_CONF['cache_templates']) && ($_CONF['cache_templates'] == true) &&
            !defined('GL_INSTALL_ACTIVE') &&
            (!isset($this->view[$varName]) || ($this->view[$varName] == false))) {
            if (isset($this->blocks[$varName])) {
                $filename = $this->blocks[$varName];
            } elseif (isset($this->file[$varName])) {
                $filename = $this->file[$varName];
            } elseif (isset($this->varVals[$varName]) || empty($varName)) {
                return $this->slow_subst($varName);
            } else {
                // $varName does not reference a file so return
                if ($this->debug & 4) {
                    echo "<p><b>subst:</b> varName $varName does not reference a file</p>\n";
                }

                return '';
            }

            if (!is_readable($filename)) {
                // file missing
                if ($this->debug & 4) {
                    echo "<p><b>subst:</b> file $filename Does Not Exist or is not readable</p>\n";
                }

                return '';
            }

            $p = pathinfo($filename);
            if ($p['extension'] === 'php') {
                ob_start();
                /** @noinspection PhpIncludeInspection */
                include $filename;
                $str = ob_get_clean();
            } else {
                $str = $this->slow_subst($varName);
            }

            return $str;
        } else {
            if (isset($this->blocks[$varName])) {
                $templateCode = $this->blocks[$varName];
            } elseif (isset($this->templateCode[$varName])) {
                $templateCode = $this->templateCode[$varName];
            } elseif (isset($this->varVals[$varName]) || empty($varName)) {
                return $this->slow_subst($varName);
            } else {
                // $varName does not reference a file so return
                if ($this->debug & 4) {
                    echo "<p><b>subst:</b> varName $varName does not reference a file</p>\n";
                }

                return '';
            }

            // Lets try to error gracefully if we need too when evaluating PHP
            // Cannot use COM_handleEval as that is an outside function as the code we need to evaluate contains references to the template class ($this->...)
            // This code gets executed when the template class function set_view is used (like in the staticpages plugin when a page is used as a template)
            $errorMessage = '';
            $templateCode = '?>' . $templateCode . '<?php ';
            ob_start();
            if (version_compare(PHP_VERSION, '7.0.0', '<')) {
                $str = eval($templateCode);

                if ($str === false) {
                    $errorMessage = $LANG01[144];
                }
            } else {
                try {
                    $str = eval($templateCode);
                } catch (ParseError $e) {
                    COM_errorLog(__FUNCTION__ . ': ' . $e->getMessage());
                    $errorMessage = $LANG01[144];
                }
            }
            $str = ob_get_clean();

            return empty($errorMessage) ? $str : $errorMessage;
        }
    }

    /******************************************************************************
     * This function fills in all the variables contained within the variable named
     * $varName. The resulting value is returned as the function result and the
     * original value of the variable varName is not changed. The resulting string
     * is not "finished", that is, the unresolved variable name policy has not been
     * applied yet.
     *
     * This is the old version of subst.
     *
     * Returns: the value of the variable $varName with all variables substituted.
     *
     * usage: subst(string $varName)
     *
     * @param     string $varName the name of the variable within which variables are to be substituted
     * @return    string
     */
    public function slow_subst($varName)
    {
        $varVals_quoted = array();
        if ($this->debug & 4) {
            echo "<p><b>subst:</b> varName = $varName</p>\n";
        }

        if (count($this->varKeys) < count($this->varVals)) {
            foreach ($this->varVals as $k => $v) {
                $this->varKeys[$k] = '{' . $k . '}';
            }
        }

        // quote the replacement strings to prevent bogus stripping of special chars
        foreach ($this->varVals as $k => $v) {
            $varVals_quoted[$k] = str_replace(array('\\\\', '$'), array('\\\\\\\\', '\\\\$'), $v);
        }

        $str = $this->get_var($varName);
        $str = str_replace($this->varKeys, $varVals_quoted, $str);

        return $str;
    }

    /******************************************************************************
     * This is shorthand for print $this->subst($varName). See subst for further
     * details.
     *
     * usage: psubst(string $varName)
     *
     * @param     string $varName the name of the variable within which variables are to be substituted
     * @return    false     (always)
     * @see       subst
     */
    public function psubst($varName)
    {
        if ($this->debug & 4) {
            echo "<p><b>psubst:</b> varName = $varName</p>\n";
        }
        echo $this->subst($varName);

        return false;
    }

    /******************************************************************************
     * The function substitutes the values of all defined variables in the variable
     * named $varName and stores or appends the result in the variable named $target.
     *
     * It may be called with either a target and a varName as two strings or a
     * target as a string and an array of variable names in varName.
     *
     * The function inserts the new value of the variable into the $varKeys and
     * $varVals hashes. It is not necessary for a variable to exist in these hashes
     * before calling this function.
     *
     * An optional third parameter allows the value for each varName to be appended
     * to the existing target variable instead of replacing it. The default is to
     * replace.
     *
     * If $target and $varName are both strings, the substituted value of the
     * variable $varName is inserted into or appended to $target.
     *
     * If $handle is an array of variable names the variables named by $handle are
     * sequentially substituted and the result of each substitution step is
     * inserted into or appended to in $target. The resulting substitution is
     * available in the variable named by $target, as is each intermediate step
     * for the next $varName in sequence. Note that while it is possible, it
     * is only rarely desirable to call this function with an array of varNames
     * and with $append = true. This append feature was introduced after the 7.2d
     * release.
     *
     * usage: parse(string $target, string $varName, [boolean $append])
     * or
     * usage: parse(string $target, array $varName = (string $varName), [boolean $append])
     *
     * @param     string  $target  a string containing the name of the variable into
     *                             which substituted $varnames are to be stored
     * @param     string  $varName if a string, the name the name of the variable to
     *                             substitute or if an array a list of variables to
     *                             be substituted
     * @param     boolean $append  if true, the substituted variables are appended to
     *                             $target otherwise the existing value of $target is replaced
     * @return    string       the last value assigned to $target
     * @see       subst
     */
    public function parse($target, $varName, $append = false)
    {
        $str = '';

        if (!is_array($varName)) {
            if ($this->debug & 4) {
                echo "<p><b>parse:</b> (with scalar) target = $target, varName = $varName, append = $append</p>\n";
            }
            if (isset($this->location[$varName])) {
                $this->set_var('templatelocation', $this->location[$varName]);
            }
            $str = $this->subst($varName);
            if ($append) {
                $this->set_var($target, $this->get_var($target) . $str);
            } else {
                $this->set_var($target, $str);
            }
        } else {
            foreach ($varName as $i => $v) {
                if ($this->debug & 4) {
                    echo "<p><b>parse:</b> (with array) target = $target, i = $i, varName = $v, append = $append</p>\n";
                }
                $this->set_var('templatelocation', $this->location[$v]);
                $str = $this->subst($v);
                if ($append) {
                    $this->set_var($target, $this->get_var($target) . $str);
                } else {
                    $this->set_var($target, $str);
                }
            }
        }

        if ($this->debug & 4) {
            echo "<p><b>parse:</b> completed</p>\n";
        }

        return $str;
    }

    /******************************************************************************
     * This is shorthand for print $this->parse(...) and is functionally identical.
     * See parse for further details.
     *
     * usage: pparse(string $target, string $varName, [boolean $append])
     * or
     * usage: pparse(string $target, array $varName = (string $varName), [boolean $append])
     *
     * @param     string       $target  a string containing the name of the variable into
     *                                  which substituted $varnames are to be stored
     * @param     string|array $varName if a string, the name the name of the variable to
     *                                  substitute or if an array a list of variables to
     *                                  be substituted
     * @param     boolean      $append  if true, the substituted variables are appended to
     *                                  $target otherwise the existing value of $target is
     *                                  replaced
     * @return    false        (always)
     * @see       parse
     */
    public function pparse($target, $varName, $append = false)
    {
        if ($this->debug & 4) {
            echo "<p><b>pparse:</b> passing parameters to parse...</p>\n";
        }
        echo $this->finish($this->parse($target, $varName, $append));

        return false;
    }

    /******************************************************************************
     * This function returns an associative array of all defined variables with the
     * name as the key and the value of the variable as the value.
     *
     * This is mostly useful for debugging. Also note that $this->debug can be used
     * to echo all variable assignments as they occur and to trace execution.
     *
     * usage: get_vars()
     *
     * @return    array    a hash of all defined variable values keyed by their names
     * @see       $debug
     */
    public function get_vars()
    {
        $result = array();

        if ($this->debug & 4) {
            echo "<p><b>get_vars:</b> constructing array of vars...</p>\n";
        }

        foreach ($this->varVals as $k => $v) {
            $result[$k] = $this->get_var($k);
        }

        return $result;
    }

    /******************************************************************************
     * This function returns the value of the variable named by $varName.
     * If $varName references a file and that file has not been loaded yet, the
     * variable will be reported as empty.
     *
     * When called with an array of variable names this function will return a a
     * hash of variable values keyed by their names.
     *
     * Returns: a string or an array containing the value of $varName.
     *
     * usage: get_var(string $varName)
     * or
     * usage: get_var(array $varName)
     *
     * @param     string|array $varName if a string, the name the name of the variable to get the value of, or if an
     *                                  array a list of variables to return the value of
     * @return    string|array
     */
    public function get_var($varName)
    {
        $result = array();

        if (!is_array($varName)) {
            if (isset($this->varVals[$varName])) {
                $str = $this->varVals[$varName];
            } else {
                $str = "";
            }
            if ($this->debug & 2) {
                printf("<b>get_var</b> (with scalar) <b>%s</b> = '%s'<br>\n", $varName, htmlentities($str));
            }

            return $str;
        } else {
            foreach ($varName as $v) {
                if (isset($this->varVals[$v])) {
                    $str = $this->varVals[$v];
                } else {
                    $str = "";
                }
                if ($this->debug & 2) {
                    printf("<b>get_var:</b> (with array) <b>%s</b> = '%s'<br>\n", $v, htmlentities($str));
                }
                $result[$v] = $str;
            }

            return $result;
        }
    }

    /******************************************************************************
     * DEPRECATED: This function doesn't really work any more. Processing in val_echo
     * could be done to gather unknowns. But coding that seems like a waste of time
     * and would only cause 99.99% of the normal use of this class to be slower.
     *
     * This function returns a hash of unresolved variable names in $varName, keyed
     * by their names (that is, the hash has the form $a[$name] = $name).
     *
     * Returns: a hash of varName/varName pairs or false on error.
     *
     * usage: get_undefined(string $varName)
     *
     * @param     string $varName a string containing the name the name of the variable to scan for unresolved variables
     * @return    array|bool
     */
    public function get_undefined($varName)
    {
        $result = array();

        if ($this->debug & 4) {
            echo "<p><b>get_undefined (DEPRECATED):</b> varName = $varName</p>\n";
        }
        if (!$this->loadFile($varName)) {
            $this->halt("get_undefined: unable to load $varName.");

            return false;
        }

        preg_match_all("/{([^ \t\r\n}]+)}/", $this->get_var($varName), $m);
        $m = $m[1];
        if (!is_array($m)) {
            return false;
        }

        foreach ($m as $v) {
            if (!isset($this->varVals[$v])) {
                if ($this->debug & 4) {
                    echo "<p><b>get_undefined:</b> undefined: $v</p>\n";
                }
                $result[$v] = $v;
            }
        }

        if (count($result)) {
            return $result;
        } else {
            return false;
        }
    }

    /******************************************************************************
     * Returns: Unknown processing use to take place here. Now it happens directly
     * in the cache file. This function is still necessary for being able to hook
     * the final output from the library.
     *
     * usage: finish(string $str)
     *
     * @param     string $str a string to return
     * @return    string
     */
    public function finish($str)
    {
        global $TEMPLATE_OPTIONS;

        if (isset($TEMPLATE_OPTIONS['hook']['finish'])) {
            $function = $TEMPLATE_OPTIONS['hook']['finish'];
            if (is_callable($function)) {
                $str = call_user_func($function, $str);
            }
        }

        $str = $this->_postprocess($str);

        return $str;
    }

    /******************************************************************************
     * This function prints the finished version of the value of the variable named
     * by $varName. That is, the policy regarding unresolved variable names will be
     * applied to the variable $varName then it will be printed.
     *
     * usage: p(string $varName)
     *
     * @param     string $varName a string containing the name of the variable to finish and print
     * @return    void
     * @see       set_unknowns
     * @see       finish
     */
    public function p($varName)
    {
        print $this->finish($this->get_var($varName));
    }

    /******************************************************************************
     * This function returns the finished version of the value of the variable named
     * by $varName. That is, the policy regarding unresolved variable names will be
     * applied to the variable $varName and the result returned.
     *
     * usage: get(string $varName)
     *
     * @param     string $varName a string containing the name of the variable to finish
     * @return    string    a finished string derived from the variable $varName
     * @see       set_unknowns
     * @see       finish
     */
    public function get($varName)
    {
        return $this->finish($this->get_var($varName));
    }

    /******************************************************************************
     * When called with a relative pathname, this function will return the pathname
     * with $this->root prepended. Absolute path names are returned unchanged.
     *
     * Returns: a string containing an absolute pathname.
     *
     * usage: filename(string $filename)
     *
     * @param     string $fileName a string containing a filename
     * @return    string
     * @see       set_root
     */
    public function filename($fileName)
    {
        if ($this->debug & 4) {
            echo "<p><b>filename:</b> filename = $fileName</p>\n";
        }
        if ($this->debug & 8) {
            foreach ($this->root as $r) {
                echo 'root: ' . $r . '<br>';
            }
        }

        // if path reaches root, just use it.
        if (substr($fileName, 0, 1) === '/' ||   // handle unix root /
            substr($fileName, 1, 1) === ':' ||   // handle windows d:\path
            substr($fileName, 0, 2) === '\\\\'   // handle windows network path \\server\path
        ) {
            if (!file_exists($fileName)) {
                $this->halt("filename: file $fileName does not exist.(1)");
            }

            return $fileName;
        } else {
            // check each path in order
            foreach ($this->root as $r) {
                $f = $r . '/' . $fileName;
                if ($this->debug & 8) {
                    echo "<p><b>filename:</b> filename = $f</p>\n";
                }
                if (file_exists($f)) {
                    return $f;
                }
            }
        }
        $this->halt("filename: file $fileName does not exist.(2)");

        return $fileName;
    }

    /******************************************************************************
     * If a variable's value is undefined and the variable has a filename stored in
     * $this->file[$varName] then the backing file will be loaded and the file's
     * contents will be assigned as the variable's value.
     *
     * Note that the behaviour of this function changed slightly after the 7.2d
     * release. Where previously a variable was reloaded from file if the value
     * was empty, now this is not done. This allows a variable to be loaded then
     * set to "", and also prevents attempts to load empty variables. Files are
     * now only loaded if $this->varVals[$varName] is unset.
     *
     * Returns: true on success, false on error.
     *
     * usage: loadFile(string $varName)
     *
     * @param     string $varName a string containing the name of a variable to load
     * @return    boolean
     * @see       set_file
     */
    private function loadFile($varName)
    {
        if ($this->debug & 4) {
            echo "<p><b>loadFile:</b> varName = $varName</p>\n";
        }

        if (!isset($this->file[$varName])) {
            // $varName does not reference a file so return
            if ($this->debug & 4) {
                echo "<p><b>loadFile:</b> varName $varName does not reference a file</p>\n";
            }

            return true;
        }

        if (isset($this->varVals[$varName])) {
            // will only be unset if varName was created with set_file and has never been loaded
            // $varName has already been loaded so return
            if ($this->debug & 4) {
                echo "<p><b>loadFile:</b> varName $varName is already loaded</p>\n";
            }

            return true;
        }
        $filename = $this->file[$varName];

        /* use @file here to avoid leaking filesystem information if there is an error */
        $str = @file_get_contents($filename);
        if (empty($str)) {
            $this->halt("loadFile: While loading $varName, $filename does not exist or is empty.");

            return false;
        }

        if ($this->debug & 4) {
            printf("<b>loadFile:</b> loaded $filename into $varName<br>\n");
        }
        $this->set_var($varName, $str);

        return true;
    }

    /******************************************************************************
     * This function is called whenever an error occurs and will handle the error
     * according to the policy defined in $this->halt_on_error. Additionally the
     * error message will be saved in $this->last_error.
     *
     * Returns: always returns false.
     *
     * usage: halt(string $msg)
     *
     * @param     string $msg a string containing an error message
     * @return    void
     * @see       $halt_on_error
     */
    public function halt($msg)
    {
        $this->last_error = $msg;

        if (($this->halt_on_error !== 'no') && ($this->halt_on_error !== 'log')) {
            $this->haltmsg($msg);
        }

        if ($this->halt_on_error === 'log') {
            COM_errorLog($msg);
        }
    }

    /******************************************************************************
     * This function prints an error message.
     * It can be overridden by your subclass of Template. It will be called with an
     * error message to display.
     *
     * usage: haltmsg(string $msg)
     *
     * @param     string $msg a string containing the error message to display
     * @return    void
     * @see       halt
     */
    public function haltmsg($msg)
    {
        if ($this->halt_on_error === 'yes') {
            trigger_error(sprintf('Template Error: %s', $msg));
        } else {
            printf("<b>Template Error:</b> %s<br />\n", $msg);
        }
    }

    /******************************************************************************
     * These functions are called from the cached php file to fetch data into the template.
     * You should NEVER have to call them directly.
     *
     * @param  string $val string containing name of template variable
     * @return string
     * @see    cache_blocks,check_cache
     */
    private function val_echo($val)
    {
        if (array_key_exists($val, $this->nocache) && ($this->unknowns === 'PHP')) {
            return '<?php echo $this->val_echo(\'' . $val . '\'); ?>';
        }

        if (array_key_exists($val, $this->varVals)) {
            return $this->varVals[$val];
        }
        if ($this->unknowns === 'comment') {
            return "<!-- Template variable $val undefined -->";
        } elseif ($this->unknowns === 'keep') {
            // return '{'.$val.'}{'.$this->varVals[$val].'}'; // Not sure why this was like this and not like below
            return '{' . $val . '}';
        }

        return '';
    }

    /***
     * Used in {!if var}. Avoid duplicating a large string when all we care about is if the string is non-zero length
     *
     * @param  string $val
     * @return bool
     */
    function var_notempty($val)
    {
        if (array_key_exists($val, $this->varVals)) {
            return !empty($this->varVals[$val]);
        }

        return false;
    }

    function mod_echo($val, $modifier = '')
    {
        if (array_key_exists($val, $this->nocache) && $this->unknowns == 'PHP') {
            if (empty($modifier)) {
                return '<?php echo $this->val_echo(\'' . $val . '\'); ?>';
            } else {
                return '<?php echo $this->mod_echo(\'' . $val . '\',\'' . $modifier . '\'); ?>';
            }
        }

        if (array_key_exists($val, $this->varVals)) {
            $mods = explode(':', substr($modifier, 1));
            $ret = $this->varVals[$val];
            foreach ($mods as $mod) {
                switch ($mod[0]) {
                    case 'u':
                        $ret = urlencode($ret);
                        break;

                    case 's':
                        $ret = htmlspecialchars($ret);
                        break;

                    case 'h':
                        $ret = strip_tags($ret);
                        break;

                    case 't':
                        $ret = substr($ret, 0, intval(substr($mod, 1))); // truncate
                        break;
                }
            }

            return $ret;
        }
        if ($this->unknowns == 'comment') {
			return '<!-- Template variable ' . $val . ' undefined -->'; // Do not need to use htmlspecialchars on $ val as in html comment
        } elseif ($this->unknowns == 'keep') {
			return '{' . htmlspecialchars($val . $modifier) . '}';
        }

        return '';
    }

    function lang_echo($val)
    {
        // only allow variables with LANG in them to somewhat protect this from harm.
        if (stristr($val, 'LANG') === false) {
            return '';
        }
        $A = explode('[', $val);
        if (isset($GLOBALS[$A[0]])) {
            $var = $GLOBALS[$A[0]];
            for ($i = 1; $i < count($A); ++$i) {
                $idx = str_replace(array(']', "'"), '', $A[$i]);
                if (array_key_exists($idx, $var)) {
                    $var = $var[$idx];
                } else {
                    break;
                }
            }
            if (is_scalar($var)) {
				return $var; // Changed from "return htmlspecialchars($var);" as lang should translate exactly. If need entities then should be that way in language string
            }
        }
        if ($this->unknowns == 'comment') {
			return '<!-- Language variable ' . $val . ' undefined -->'; // Do not need to use htmlspecialchars on $ val as in html comment
        } elseif ($this->unknowns == 'keep') {
            return '{' . htmlspecialchars($val) . '}';
        }

        return '';
    }

    function block_echo($block)
    {
        if (array_key_exists($block, $this->block_replace)) {
            return $this->get_var($this->block_replace[$block]);
        }

        return '';
    }

    function loop($var)
    {
        $loopVar = $var . '__loopvar';
        $limit = $this->get_var($var);
        $current = $this->get_var($loopVar);
        if ($limit > 0) {
            $this->set_var($loopVar, ++$current);
            $ret = $current <= $limit;
        } else {
            $this->set_var($loopVar, --$current);
            $ret = $current >= $limit;
        }
        if (!$ret) $this->unset_var($loopVar);

        return $ret;
    }

    function inc_echo($var)
    {
        $val = $this->get_var($var);
        if ($val == 0) $val = 0;
        $this->set_var($var, ++$val);

        return $val;
    }

    function dec_echo($var)
    {
        $val = $this->get_var($var);
        if ($val == 0) $val = 0;
        $this->set_var($var, --$val);

        return $val;
    }

    /******************************************************************************
     * These functions build the cached php file.
     * You should NEVER have to call them directly.
     *
     * @param  $tmplt           string being cached
     * @param  $in_php          boolean used to determine if php escape chars need to be printed
     * @return string
     * @see    cache_write
     */
    private function replace_vars($tmplt, $in_php = false)
    {
        // do all the common substitutions
        if ($in_php) {
            $tmplt = preg_replace(
                array(
                    '/\{([-\.\w\d_\[\]]+)\}/',                              // matches {identifier}
                    '/\{([-\.\w\d_\[\]]+)((:u|:s|:h|:t\d+)+)\}/',              // matches {identifier} with optional :s, :u or :t### suffix
                ),
                array(
                    '$this->get_var(\'\1\')',
                    '$this->mod_echo(\'\1\',\'\2\')',
                ),
                $tmplt);
        } else {
            $tmplt = preg_replace(
                array(
                    '/\{([-\.\w\d_\[\]]+)\}/',                              // matches {identifier}
                    '/\{([-\.\w\d_\[\]]+)((:u|:s|:h|:t\d+)+)\}/',              // matches {identifier} with optional :s, :u or :t### suffix
                ),
                array(
                    '<?php echo $this->val_echo(\'\1\'); ?>',
                    '<?php echo $this->mod_echo(\'\1\',\'\2\'); ?>',
                ),
                $tmplt);
        }

        return $tmplt;
    }

    function replace_lang($tmplt, $in_php = false)
    {
        global $TEMPLATE_OPTIONS;

        if ($TEMPLATE_OPTIONS['cache_by_language']) {
            if ($in_php) {
                $tmplt = preg_replace_callback(
                    '/\{\$(LANG[\w\d_]+)\[(\')?([\w\d_]+)(?(2)\')\]\}/',
                    array($this, 'parse_quoted_lang_callback'),
                    $tmplt);
            } else {
                $tmplt = preg_replace_callback(
                    '/\{\$(LANG[\w\d_]+)\[(\')?([\w\d_]+)(?(2)\')\]\}/',
                    array($this, 'parse_lang_callback'),
                    $tmplt);
            }
        } else {
            if ($in_php) {
                $tmplt = preg_replace(
                    '/\{\$(LANG[\w\d_]+)\[(\')?([\w\d_]+)(?(2)\')\]\}/',
                    '$this->lang_echo(\'\1[\3]\')',
                    $tmplt);
            } else {
                $tmplt = preg_replace(
                    '/\{\$(LANG[\w\d_]+)\[(\')?([\w\d_]+)(?(2)\')\]\}/',
                    '<?php echo $this->lang_echo(\'\1[\3]\'); ?>',
                    $tmplt);
            }
        }

        return $tmplt;
    }

    // Callbacks for replace_lang
    function parse_lang_callback($matches)
    {
        return $this->lang_echo($matches[1] . '[' . $matches[3] . ']');
    }

    function parse_quoted_lang_callback($matches)
    {
        return '\'' . addslashes($this->lang_echo($matches[1] . '[' . $matches[3] . ']')) . '\'';
    }

    function replace_extended($tmplt)
    {
        if (strpos($tmplt, '!}') !== false || strpos($tmplt, '$}') !== false) {
            $tmplt = preg_replace_callback(
                array('/\{\!\!(if|elseif|while|echo|global|autotag) (([^\\\']|\\\\|\\\')+?) \!\!\}/',
                    '/\{\!\!(set) ([-\.\w\d_\[\]]+) (([^\\\']|\\\\|\\\')+?) \!\!\}/',       // sets a variable
                    '/\{(\$LANG[\w\d_]+)\[(\')?([\w\d_]+)(?(2)\')\] (([^\\\']|\\\\|\\\')+?) \$\}/',       // Substitutable language independence
                ),
                array($this, 'parse_extended_callback'),
                $tmplt);
        }

        if (strpos($tmplt, '{!') !== false) {
            $tmplt = preg_replace(
                array(
                    '/\{!(if|elseif|while) ([-\.\w\d_\[\]]+)\}/',
                    '/\{!else(|!| !)\}/',
                    '/\{!end(if|while|for)(|!| !)\}/',                    // for is not yet supported but here for future use
                    '/\{!loop ([-\.\w\d_\[\]]+)(|!| !)\}/',
                    '/\{!endloop(|!| !)\}/',
                    '/\{!(inc|dec)(\+(echo))? ([-\.\w\d_\[\]]+)(|!| !)\}/',
                    '/\{!(break|continue)( \d+)?(|!| !)\}/',
                    '/\{!unset ([-\.\w\d_\[\]]+)(|!| !)\}/',                // unsets a variable
                ),
                array(
                    '<?php \1 ($this->var_notempty(\'\2\')): ?>',         // if exists and is non-zero
                    '<?php else: ?>',
                    '<?php end\1; ?>',
                    '<?php while ($this->loop(\'\1\')): ?>',              // !loop
                    '<?php endwhile; ?>',                                 // !endloop
                    '<?php \3 $this->\1_echo(\'\4\'); ?>',                // !inc and !dec and +echo
                    '<?php \1\2; ?>',                                     // !break and !continue
                    '<?php $this->unset_var(\'\1\'); ?>',
                ),
                $tmplt);
        }

        return $tmplt;
    }

    // Callbacks for replace_extended
    function parse_extended_callback($matches)
    {
        if ($matches[1] == 'autotag') {
            $prefix = '';
            $postfix = '';
            $cond = "echo PLG_replaceTags('[" . $matches[2] . "]');";
        } elseif ($matches[1] == 'set') {
            $cond = $matches[3];
            $prefix = '$this->set_var(\'' . addslashes($matches[2]) . '\', ';
            $postfix = ');';
        } elseif ($matches[1] == 'global' || $matches[1] == 'echo' || $matches[1] == '') {
            $cond = $matches[2];
            $prefix = $matches[1] . ' ';
            $postfix = ';';
        } elseif (substr($matches[1], 0, 5) === '$LANG') {
            $lang = substr($matches[1], 1);
            $cond = $matches[4];

            $prefix = 'echo sprintf($this->lang_echo(\'' . $lang . '[' . $matches[3] . ']\'),';
            $postfix = ');';
        } else {
            $cond = $matches[2];
            $prefix = $matches[1] . ' (';
            $postfix = '):';
        }

        $cond = $this->replace_vars($cond, true);
        $cond = $this->replace_lang($cond, true);

        return '<?php ' . $prefix . $cond . $postfix . ' ?>';
    }

    /******************************************************************************
     * This function does the final replace of {variable} with the appropriate PHP
     * and writes the text to the cache directory.
     *
     * As an internal function, you should never call it directly
     * usage: cache_write(string $filename, string $tmplt, string $replace)
     *
     * @param  string $filename string containing complete path to the cache file
     * @param  string $tmplt    contents of the template file before replacement
     * @return void
     * @see    cache_blocks,check_cache
     */
    private function cache_write($filename, $tmplt)
    {
        global $TEMPLATE_OPTIONS, $_CONF;

        // order of operations could matter a lot so get rid of
        // template comments first: emits nothing to the output file
        // since the regex is multi-line, make sure there is a comment before calling it
        if (strpos($tmplt, '{#') !== false) {
            if (isset($_CONF['template_comments']) && $_CONF['template_comments'] == true) {
                $tmplt = str_replace('{#', '<!-- ', $tmplt);
                $tmplt = str_replace('#}', ' -->', $tmplt);
            } else {
                $tmplt = preg_replace('!\{#.*?#\}(\n)?!sm', '', $tmplt);
            }
        }

        $tmplt = $this->replace_extended($tmplt);
        $tmplt = $this->replace_lang($tmplt);
        $tmplt = $this->replace_vars($tmplt);

        // clean up concatenation.
        $tmplt = str_replace('?' . '><' . '?php ', // makes the cache file easier on the eyes (need the concat to avoid PHP interpreting the ? >< ?php incorrectly
            "\n", $tmplt);

        if ($this->debug & 4) {
            printf("<b>cache_write:</b> opening $filename<br>\n");
        }
        $f = @fopen($filename, 'w');
        if ($f !== false) {
            if ($TEMPLATE_OPTIONS['incl_phpself_header']) {
                fwrite($f,
                    "<?php if (!defined('VERSION')) {
    die ('This file can not be used on its own.');
} ?>\n");
            }
            fwrite($f, $tmplt);
            fclose($f);
        }
    }

    /******************************************************************************
     * This function is only used with template files that contain BEGIN/END BLOCK
     * sections. See set_block for more details.
     *
     * As an internal function, you should never call it directly
     * usage: cache_blocks(string $filestub, array $parent, string $replace)
     *
     * @param  string $fileStub format string for sprintf to create cache filename
     * @param  array  $parent   array containing name and content of the block
     * @return void
     * @see    cache_write,check_cache,set_block
     */
    private function cache_blocks($fileStub, $parent)
    {
        $reg = "/\s*<!--\s+BEGIN ([-\w\d_]+)\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END \\1\s+-->\s*?\n?/smU";
        $str = $parent[2];
        $matches = array();
        if (preg_match_all($reg, $str, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $replace = '<?php echo $this->block_echo(\'' . $m[1] . '\'); ?>';
                $str = str_replace($m[0], $replace, $str);
                $this->cache_blocks($fileStub, $m);
            }
        }
        $filename = sprintf($fileStub, $parent[1]);
        $this->blocks[$parent[1]] = $filename;
        $this->cache_write($filename, $str);
    }

    /******************************************************************************
     * Called by filename(), check_cache verifies that the cache file is not out of
     * date. If it is, it recreates it from the existing template file.
     *
     * As an internal function, you should never call it directly
     * usage: check_cache(string $filename, string $tmplt, string $replace)
     *
     * @param  string $varName  unused, name of the variable associated with the file
     * @param  string $filename path to the template file
     * @return string
     * @see    cache_block,cache_write,filename
     */
    private function check_cache($varName, $filename)
    {
        global $TEMPLATE_OPTIONS, $_CONF, $_DEVICE;

        if ($this->debug & 8) {
            printf("<check_cache> Var %s for file %s<br>", $varName, $filename);
        }
        $p = pathinfo($filename);
        if ($p['extension'] == 'php') {
            return $filename;
        }
        $baseFile = basename($p['basename'], ".{$p['extension']}");

        // convert /path_to_geeklog//layout/theme/dir1/dir2/file to dir1/dir2/file
        $extra_path = '';
        if (is_array($TEMPLATE_OPTIONS['path_prefixes'])) {
            foreach ($TEMPLATE_OPTIONS['path_prefixes'] as $prefix) {
                if (strpos($p['dirname'], $prefix) === 0) {
                    $extra_path = substr($p['dirname'] . '/', strlen($prefix));
                    break;
                }
            }
        }

        if (!empty($extra_path)) {
            $extra_path = str_replace(array('/', '\\', ':'), '__', $extra_path);
        }

        if ($TEMPLATE_OPTIONS['cache_by_language'] || $TEMPLATE_OPTIONS['cache_for_mobile']) {
            $directory = '';
            if ($TEMPLATE_OPTIONS['cache_by_language']) {
                $directory = $_CONF['language'] . '/';
            }
            if ($TEMPLATE_OPTIONS['cache_for_mobile'] && $_DEVICE->is_mobile()) {
                $directory .= 'mobile/';
            }
            $extra_path = $directory . '/' . $extra_path;
            if (!is_dir($TEMPLATE_OPTIONS['path_cache'] . $directory)) {
                @mkdir($TEMPLATE_OPTIONS['path_cache'] . $directory);
                @touch($TEMPLATE_OPTIONS['path_cache'] . $directory . '/index.html');
            }
        }
        $phpFile = $TEMPLATE_OPTIONS['path_cache'] . $extra_path . $baseFile . '.php';

        $template_fstat = is_readable($filename) ? @filemtime($filename) : 0;
        if (file_exists($phpFile)) {
            $cache_fstat = @filemtime($phpFile);
        } else {
            $cache_fstat = 0;
        }

        if ($this->debug & 8) {
            printf("<check_cache> Look for %s<br>", $filename);
        }

        if ($template_fstat > $cache_fstat) {

            $str = @file_get_contents($filename);

            // Do any preprocessing
            $str = $this->_preprocess($str);

            // check for begin/end block stuff
            $reg = "/\s*<!--\s+BEGIN ([-\w\d_]+)\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END \\1\s+-->\s*?\n?/smU";
            $matches = array();
            if (preg_match_all($reg, $str, $matches, PREG_SET_ORDER)) {
                $phpStub = $TEMPLATE_OPTIONS['path_cache'] . $extra_path . $baseFile . '__%s' . '.php';
                foreach ($matches as $m) {
                    $str = str_replace($m[0], '<?php echo $this->block_echo(\'' . $m[1] . '\'); ?>', $str);
                    $this->cache_blocks($phpStub, $m);
                }
            }
            $this->cache_write($phpFile, $str);
        }

        return $phpFile;
    }

    /******************************************************************************
     * This function is only used with template files that contain BEGIN/END BLOCK
     * sections. See set_block for more details.
     *
     * As an internal function, you should never call it directly
     * usage: compile_blocks(string $filestub, array $parent, string $replace)
     *
     * @param  array $parent array containing name and content of the block
     * @return void
     * @see    cache_write,compile_template,set_block
     */
    private function compile_blocks($parent)
    {
        global $_CONF;

        $reg = "/\s*<!--\s+BEGIN ([-\w\d_]+)\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END \\1\s+-->\s*?\n?/smU";
        $str = $parent[2];
        $matches = array();
        if (preg_match_all($reg, $str, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $replace = '<?php echo $this->block_echo(\'' . $m[1] . '\'); ?>';
                $str = str_replace($m[0], $replace, $str);
                $this->compile_blocks($m);
            }
        }

        // order of operations could matter a lot so get rid of
        // template comments first: emits nothing to the output file
        // since the regex is multi-line, make sure there is a comment before calling it
        if (strpos($str, '{#') !== false) {
            if (isset($_CONF['template_comments']) && $_CONF['template_comments'] == true) {
                $str = str_replace('{#', '<!-- ', $str);
                $str = str_replace('#}', ' -->', $str);
            } else {
                $str = preg_replace('!\{#.*?#\}(\n)?!sm', '', $str);
            }
        }

        $tmplt = $this->replace_extended($str);
        $tmplt = $this->replace_lang($tmplt);
        $tmplt = $this->replace_vars($tmplt);

        // clean up concatenation.
        $tmplt = str_replace('?' . '><' . '?php ', // makes the cache file easier on the eyes (need the concat to avoid PHP interpreting the ? >< ?php incorrectly
            "\n", $tmplt);

        $this->blocks[$parent[1]] = $tmplt;
    }

    /******************************************************************************
     * Called by filename(), compile_template verifies that the cache file is not out of
     * date. If it is, it recreates it from the existing template file.
     *
     * As an internal function, you should never call it directly
     * usage: compile_template(string $filename, string $tmplt, string $replace)
     *
     * @param  string $varName  unused, name of the variable associated with the file
     * @param  string $filename path to the template file
     * @param  bool   $isFile
     * @return string
     * @see    cache_block,cache_write,filename
     */
    private function compile_template($varName, $filename, $isFile = true)
    {
        global $_CONF;

        if ($this->debug & 8) {
            printf("<compile_template> Var %s for file %s<br>", $varName, $filename);
        }

        if ($isFile) {
            $str = @file_get_contents($filename);
        } else {
            $str = $filename;
        }

        // Do any preprocessing
        $str = $this->_preprocess($str);

        // check for begin/end block stuff
        $reg = "/\s*<!--\s+BEGIN ([-\w\d_]+)\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END \\1\s+-->\s*?\n?/smU";
        $matches = array();
        if (preg_match_all($reg, $str, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $str = str_replace($m[0], '<?php echo $this->block_echo(\'' . $m[1] . '\'); ?>', $str);
                $this->compile_blocks($m);
            }
        }

        // order of operations could matter a lot so get rid of
        // template comments first: emits nothing to the output file
        // since the regex is multi-line, make sure there is a comment before calling it
        if (strpos($str, '{#') !== false) {
            if (isset($_CONF['template_comments']) && $_CONF['template_comments'] == true) {
                $str = str_replace('{#', '<!-- ', $str);
                $str = str_replace('#}', ' -->', $str);
            } else {
                $str = preg_replace('!\{#.*?#\}(\n)?!sm', '', $str);
            }
        }

        $tmplt = $this->replace_extended($str);
        $tmplt = $this->replace_lang($tmplt);
        $tmplt = $this->replace_vars($tmplt);

        // clean up concatenation.
        $tmplt = str_replace('?' . '><' . '?php ', // makes the cache file easier on the eyes (need the concat to avoid PHP interpreting the ? >< ?php incorrectly
            "\n", $tmplt);

        return $tmplt;
    }

    /******************************************************************************
     * Prevents certain variables from being cached in the instance cache.
     *
     * @param  string|array $vars A string varName or array of varNames
     * @return void
     * @see    create_instance, set_var
     */
    public function uncached_var($vars)
    {
        if (empty($vars)) {
            return;
        } elseif (!is_array($vars)) {
            $vars = array($vars);
        }
        foreach ($vars as $varName) {
            $this->nocache[$varName] = true;
        }
    }

    /******************************************************************************
     * Creates an instance of the current template. Variables in the nocache array
     * are untranslated by returning the original PHP back. Conceptually, this
     * function is equivalent to the parse function.
     *
     * The $iid parameter must be globally unique. The recommended format is
     *   $plugin_$primaryKey  or $plugin_$page_$uid
     *
     * The $fileVar parameter is supposed to match one of the varNames passed to
     * set_file.
     *
     * usage: create_instance(string $iid, string $fileVar)
     *
     * @param  string $iid     A globally unique instance identifier.
     * @param  string $fileVar This is the varName passed to $T->set_file.
     * @return string          The full path of the cached file.
     * @see    check_instance
     */
    public function create_instance($iid, $fileVar)
    {
        global $TEMPLATE_OPTIONS, $_CONF, $_DEVICE;

        $old_unknowns = $this->unknowns;
        $this->unknowns = 'PHP';
        $tmplt = $this->parse($iid, $fileVar);
        $path_cache = $TEMPLATE_OPTIONS['path_cache'];
        if ($TEMPLATE_OPTIONS['cache_by_language']) {
            $path_cache .= $_CONF['language'] . '/';
        }
        if ($TEMPLATE_OPTIONS['cache_for_mobile'] && $_DEVICE->is_mobile()) {
            $path_cache .= 'mobile/';
        }
        $iid = str_replace(array('..', '/', '\\', ':'), '', $iid);
        // COMMENT ORIGINAL LINE below out since not sure why changing dashes to under scores ... this affects articles and staticpages
        // $iid = str_replace('-','_',$iid);
        $filename = $path_cache . 'instance__' . $iid . '.php';
        $tmplt = '{# begin cached as ' . htmlspecialchars($iid) . " #}\n"
            . $tmplt
            . '{# end cached as ' . htmlspecialchars($iid) . " #}\n";
        $this->cache_write($filename, $tmplt);
        $this->unknowns = $old_unknowns;

        return $filename;
    }

    /******************************************************************************
     * Checks for an instance of the current template. This check is based solely on
     * the $iid. The $fileVar is replaces with the cached file if it exists.
     *
     * The $iid parameter must be globally unique. The recommended format is
     *   $plugin_$primaryKey  or $plugin_$page_$uid
     *
     * The $fileVar parameter is supposed to match one of the varNames passed set_file.
     *
     * usage:
     *          $T->set_file('main', 'main.thtml');
     *          $iid = 'mainfile_'.$primaryKey;
     *          if (!$T->check_instance($iid, 'main')) {
     *              $T->set_var(...); //...
     *              $T->create_instance($iid, 'main');
     *          }
     *          $T->set_var('hits', $hit_count, false, true);
     *          $T->parse('output', 'main');
     *
     * @param  string $iid     A globally unique instance identifier.
     * @param  string $fileVar This is the varName passed to $T->set_file.
     * @return boolean         true if the instance file exists
     * @see    create_instance
     */
    public function check_instance($iid, $fileVar)
    {
        global $TEMPLATE_OPTIONS, $_CONF, $_DEVICE;

        $path_cache = $TEMPLATE_OPTIONS['path_cache'];
        if ($TEMPLATE_OPTIONS['cache_by_language']) {
            $path_cache .= $_CONF['language'] . '/';
        }
        if ($TEMPLATE_OPTIONS['cache_for_mobile'] && $_DEVICE->is_mobile()) {
            $path_cache .= 'mobile/';
        }
        $iid = str_replace(array('..', '/', '\\', ':'), '', $iid);
        // COMMENT ORIGINAL LINE below out since not sure why changing dashes to under scores ... this affects articles and staticpages
        // $iid = str_replace('-','_',$iid);
        $filename = $path_cache . 'instance__' . $iid . '.php';
        if (file_exists($filename) && array_key_exists($fileVar, $this->file)) {
            $this->file[$fileVar] = $filename;

            return true;
        }

        return false;
    }

} // end class

/******************************************************************************
 * Internal function used to traverse directory tree when cleaning cache
 *
 * usage: cache_clean_directories($plugin);
 *
 * @param  string $path   Directory path being cleaned
 * @param  string $needle String matched against cache filenames
 * @param  int    $since
 * @access private
 * @return int            number of files not deleted
 */
function cache_clean_directories($path, $needle = '', $since = 0)
{
    $numFiles = 0;

    if ($dir = @opendir($path)) {
        while (false !== ($entry = readdir($dir))) {
            if ($entry === '.' || $entry === '..') {
                continue;
            } elseif ($entry === '.svn' || is_link($entry)) {
                $numFiles++;
            } elseif (is_dir($path . '/' . $entry)) {
                if (cache_clean_directories($path . '/' . $entry, $needle) === 0) {
                    @rmdir($path . '/' . $entry);
                }
            } elseif (empty($needle) || strpos($entry, $needle) !== false) {
                if (!$since || @filectime($path . '/' . $entry) <= $since) {
                    @unlink($path . '/' . $entry);
                } else {
                    $numFiles++;
                }
            } else {
                $numFiles++;
            }
        }
        @closedir($dir);
    }

    return $numFiles;
}

/******************************************************************************
 * Removes all cached files associated with a plugin.
 *
 * usage: CACHE_cleanup_plugin($plugin);
 *
 * @param  $plugin          String containing the plugin's name
 * @access public
 * @return void
 */
function CACHE_cleanup_plugin($plugin)
{
    global $TEMPLATE_OPTIONS;

    if (!empty($plugin)) {
        $plugin = str_replace(array('..', '/', '\\'), '', $plugin);
        $plugin = '__' . $plugin . '__';
    }
    $path_cache = substr($TEMPLATE_OPTIONS['path_cache'], 0, -1);
    cache_clean_directories($path_cache, $plugin);
}

/******************************************************************************
 * Deletes an instance of the specified instance identifier
 *
 * usage: CACHE_remove_instance($iid, $glob);
 *
 * @param  string $iid A globally unique instance identifier.
 * @access public
 * @return void
 * @see    check_instance, create_instance
 */
function CACHE_remove_instance($iid)
{
    global $TEMPLATE_OPTIONS;

    $iid = str_replace(array('..', '/', '\\', ':'), '', $iid);
    // COMMENT ORIGINAL LINE below out since not sure why changing dashes to under scores ... this affects articles and staticpages
    // When creating the cache instance file we use COM_sanitizeFilename which doesn't change dashes so
    // no need to change here when deleting cache file (since names will not match).
    // Dashes can be used in ids like with blocks, articles, and staticpages
    // Confusion may have happened since this is done for cache theme template files but not cache instances
    // $iid = str_replace('-','_',$iid);
    $path_cache = substr($TEMPLATE_OPTIONS['path_cache'], 0, -1);
    cache_clean_directories($path_cache, 'instance__' . $iid);
}

/******************************************************************************
 * Creates a cached copy of the data passed.
 *
 * usage: CACHE_create_instance($iid, $data, $bypass_lang);
 *
 * @param  string $iid         A globally unique instance identifier.
 * @param  string $data        The data to cache
 * @param  bool   $bypass_lang If true, the cached data is not instanced by language
 * @param  bool   $bypass_mobile
 * @access public
 * @return void
 * @see    CACHE_check_instance, CACHE_remove_instance
 */
function CACHE_create_instance($iid, $data, $bypass_lang = false, $bypass_mobile = false)
{
    global $TEMPLATE_OPTIONS, $_CONF, $_DEVICE;

    if ($TEMPLATE_OPTIONS['cache_by_language'] || $TEMPLATE_OPTIONS['cache_for_mobile']) {
        $directory = '';
        if (!$bypass_lang && $TEMPLATE_OPTIONS['cache_by_language']) {
            $directory = $_CONF['language'] . '/';
        }
        if (!$bypass_mobile && $TEMPLATE_OPTIONS['cache_for_mobile'] && $_DEVICE->is_mobile()) {
            $directory .= 'mobile/';
        }
        if (!is_dir($TEMPLATE_OPTIONS['path_cache'] . $directory)) {
            @mkdir($TEMPLATE_OPTIONS['path_cache'] . $directory);
            @touch($TEMPLATE_OPTIONS['path_cache'] . $directory . '/index.html');
        }
    }

    $filename = CACHE_instance_filename($iid, $bypass_lang, $bypass_mobile);
    @file_put_contents($filename, $data);
}

/******************************************************************************
 * Finds a cached copy of the referenced data.
 *
 * usage: $data = CACHE_check_instance($iid, $bypass_lang)
 *        if (!$data === false) {
 *            // generate the data
 *            $data = 'stuff';
 *            CACHE_create_instance($iid, $data, $bypass_lang);
 *        }
 *        // use the data
 *
 * The caching functions only work with strings. If you want to store structures
 * you must serialize/unserialize the data yourself:
 *
 *      $data = CACHE_check_instance($iid);
 *      if ($data === false) {
 *          $data = new SomeObj();
 *          CACHE_create_instance($iid, serialize($data));
 *      } else {
 *          $data = unserialize($data);
 *      }
 *      // use the object
 *
 * @param  string $iid         A globally unique instance identifier.
 * @param  bool   $bypass_lang If true, the cached data is not instanced by language
 * @param  bool   $bypass_mobile
 * @access public
 * @return string|false the data string or false is there is no such instance
 * @see    CACHE_check_instance, CACHE_remove_instance
 */
function CACHE_check_instance($iid, $bypass_lang = false, $bypass_mobile = false)
{
    $filename = CACHE_instance_filename($iid, $bypass_lang, $bypass_mobile);
    if (file_exists($filename)) {
        $str = @file_get_contents($filename);

        return ($str === false) ? false : $str;
    }

    return false;
}

/******************************************************************************
 * Returns the time when the referenced instance was generated.
 *
 * usage: $time = CACHE_get_instance_update($iid, $bypass_lang = false)
 *
 * @param  string $iid         A globally unique instance identifier.
 * @param  bool   $bypass_lang If true, the cached data is not instanced by language
 * @param  bool   $bypass_mobile
 * @access public
 * @return int unix_timestamp of when the instance was generated or false
 * @see    CACHE_check_instance, CACHE_remove_instance
 */
function CACHE_get_instance_update($iid, $bypass_lang = false, $bypass_mobile = false)
{
    $filename = CACHE_instance_filename($iid, $bypass_lang, $bypass_mobile);

    return @filemtime($filename);
}

/******************************************************************************
 * Generates a full path to the instance file. Should really only be used
 * internally but there are probably reasons to use it externally.
 *
 * usage: $time = CACHE_instance_filename($iid, $bypass_lang = false)
 *
 * @param  string $iid         A globally unique instance identifier.
 * @param  bool   $bypass_lang If true, the cached data is not instanced by language
 * @param  bool   $bypass_mobile
 * @access public
 * @return int unix_timestamp of when the instance was generated or false
 * @see    CACHE_create_instance, CACHE_check_instance, CACHE_remove_instance
 */
function CACHE_instance_filename($iid, $bypass_lang = false, $bypass_mobile = false)
{
    global $TEMPLATE_OPTIONS, $_CONF, $_DEVICE;

    $path_cache = $TEMPLATE_OPTIONS['path_cache'];
    if (!$bypass_lang && $TEMPLATE_OPTIONS['cache_by_language']) {
        $path_cache .= $_CONF['language'] . '/';
    }
    if (!$bypass_mobile && $TEMPLATE_OPTIONS['cache_for_mobile'] && $_DEVICE->is_mobile()) {
        $path_cache .= 'mobile/';
    }
    $iid = COM_sanitizeFilename($iid, true);
    $filename = $path_cache . 'instance__' . $iid . '.php';

    return $filename;
}

/******************************************************************************
 * Generates a hash based on the current user's security profile.
 *
 * Currently that is just a list of groups the user is a member of but if
 * additional data is found to be necessary for creating a unique security
 * profile, this centralized function would be the place for it.
 *
 * usage: $hash = CACHE_security_hash()
 *        $instance = "someData__$someId__$hash";
 *        CACHE_create_instance($instance, $theData);
 *
 * @access public
 * @return string    a string uniquely identifying the user's security profile
 *
 */
function CACHE_security_hash()
{
    global $_GROUPS, $_USER;

    static $hash = null;

    if (empty($hash)) {
        $groups = implode(',', $_GROUPS);
        $hash = strtolower(md5($groups));
        if (!empty($_USER['tzid'])) {
            $hash .= 'tz' . md5($_USER['tzid']);
        }
    }

    return $hash;
}
