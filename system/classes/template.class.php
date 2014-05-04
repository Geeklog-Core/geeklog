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
 *
 */

/* This should be the only Geeklog-isms in the file. Didn't want to "infect" the class but it was necessary.
 * These options are global to all templates.
 */
$xhtml = '';
if (defined('XHTML')) { // usually not defined yet but will be later
    $xhtml = XHTML;
}
$TEMPLATE_OPTIONS = array(
    'path_cache'    => $_CONF['path_data'].'layout_cache/',   // location of template cache
    'path_prefixes' => array(                               // used to strip directories off file names. Order is important here.
                        $_CONF['path_themes'],  // this is not path_layout. When stripping directories, you want files in different themes to end up in different directories.
                        $_CONF['path'],
                        '/'                     // this entry must always exist and must always be last
                       ),
    'incl_phpself_header' => true,          // set this to true if your template cache exists within your web server's docroot.
    'cache_by_language' => true,            // create cache directories for each language. Takes extra space but moves all $LANG variable text directly into the cached file
    'default_vars' => array(                                // list of vars found in all templates.
                        'xhtml' => $xhtml, // Will be reset by lib-common       
                        'site_url' => $_CONF['site_url'],
                        'site_admin_url' => $_CONF['site_admin_url'],
                        'layout_url' => $_CONF['layout_url'], // Can be set by lib-common on theme change
                        'anonymous_user' => true, // Set to false in lib-common if current visitor is logged in
                        
                      ),
    'hook' => array(),
);

class Template
{
 /**
  * Serialization helper, the name of this class.
  *
  * @var       string
  * @access    public
  */
  var $classname = "Template";

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
  * @access    public
  */
  var $debug    = 0;

 /**
  * The base directory array from which template files are loaded. When
  * attempting to open a file, the paths in this array are searched one at
  * a time. As soon as a file exists, the array search stops.
  *
  * @var       string
  * @access    private
  * @see       set_root
  */
  var $root     = array();

 /**
  * A hash of strings forming a translation table which translates variable names
  * into names of files containing the variable content.
  * $file[varname] = "filename";
  *
  * @var       array
  * @access    private
  * @see       set_file
  */
  var $file     = array();

 /**
  * A hash of strings forming a translation table which translates variable names
  * into names of files containing the variable content.
  * $location[varname] = "full path to template";
  *
  * @var       array
  * @access    private
  * @see       set_file
  */
  var $location     = array();

 /**
  * The in memory template
  *
  * @var       array
  * @access    private
  * @see       set_file
  */
  var $templateCode = array();

 /**
  * A hash of strings forming a translation table which translates variable names
  * into names of files containing the variable content.
  * $file[varname] = "filename";
  *
  * @var       array
  * @access    private
  * @see       cache_blocks,set_block
  */
  var $blocks   = array();

 /**
  * A hash of strings forming a translation table which translates variable names
  * into the parent name of the variable.
  *
  * @var       array
  * @access    private
  * @see       cache_blocks,set_block, block_echo
  */
  var $block_replace = array();

 /**
  * A hash of strings forming a translation table which translates variable names
  * into regular expressions for themselves.
  * $varkeys[varname] = "/varname/"
  *
  * @var       array
  * @access    private
  * @see       set_var
  */
  var $varkeys  = array();

 /**
  * A hash of strings forming a translation table which translates variable names
  * into values for their respective varkeys.
  * $varvals[varname] = "value"
  *
  * @var       array
  * @access    private
  * @see       set_var
  */
  var $varvals  = array();

 /**
  * A hash of vars that are not to be translated when create_instance() is called.
  * $nocache[varname] = true
  *
  * @var       array
  * @access    private
  * @see       create_instance, val_echo, mod_echo
  */
  var $nocache  = array();

 /**
  * Determines how to output variable tags with no assigned value in templates.
  *
  * @var       string
  * @access    private
  * @see       set_unknowns
  */
  var $unknowns = "remove";

 /**
  * Determines how Template handles error conditions.
  * "yes"      = the error is reported, then execution is halted
  * "report"   = the error is reported, then execution continues by returning "false"
  * "no"       = errors are silently ignored, and execution resumes reporting "false"
  * "log"      = writes errors to Error log and returns false.
  *
  * @var       string
  * @access    public
  * @see       halt
  */
  var $halt_on_error  = "yes";

 /**
  * The last error message is retained in this variable.
  *
  * @var       string
  * @access    public
  * @see       halt
  */
  var $last_error     = "";
 
  /**
  * The name of a function is retained in this variable and is used to do any pre processing work.
  *
  * @var       string
  * @access    public
  * @see       _preprocess
  */
  var $preprocess_fn     = '';
   
  /**
  * The name of a function is retained in this variable and is used to do any post processing work.
  *
  * @var       string
  * @access    public
  * @see       _postprocess
  */
  var $postprocess_fn     = '';

 /**
* Pre Process
*
* Perform any post processing work by calling the function held in $preprocess_fn
*
* @param    string      $str        
* @access   private
*/
function _preprocess($str)
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
* @param    string      $str        
* @access   private
*/
function _postprocess($str)
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
    * @param     $root        path to template directory
    * @param     $string      what to do with undefined variables
    * @see       set_root
    * @see       set_unknowns
    * @access    public
    * @return    void
    */
    function Template($root = array('.'), $unknowns = 'remove')
    {
        global $_CONF, $TEMPLATE_OPTIONS;

        $this->set_root($root);
        $this->set_unknowns($unknowns);
        if (is_array($TEMPLATE_OPTIONS) AND array_key_exists('default_vars',$TEMPLATE_OPTIONS) and is_array($TEMPLATE_OPTIONS['default_vars'])) {
            foreach ($TEMPLATE_OPTIONS['default_vars'] as $k => $v) {
                $this->set_var($k, $v);
            }
        }
        if ( isset($_CONF['cache_templates']) && $_CONF['cache_templates'] == true ) {
            clearstatcache();
        }
    }


   /******************************************************************************
    * Checks that $root is a valid directory and if so sets this directory as the
    * base directory from which templates are loaded by storing the value in
    * $this->root. Relative filenames are prepended with the path in $this->root.
    *
    * Returns true on success, false on error.
    *
    * usage: set_root(string $root)
    *
    * @param     $root         string containing new template directory
    * @see       root
    * @access    public
    * @return    boolean
    */
    function set_root($root)
    {
        global $TEMPLATE_OPTIONS;

        if (!is_array($root)) {
            $root = array($root);
        }
        if ($this->debug & 4) {
            echo '<p><b>set_root:</b> root = array(' . (count($root) > 0 ? '"' . implode('","', $root) . '"' : '') .")</p>\n";
        }
        if (isset($TEMPLATE_OPTIONS['hook']['set_root'])) {
            $function = $TEMPLATE_OPTIONS['hook']['set_root'];
            if (is_callable($function)) {
                $root = call_user_func($function, $root);
            }
        }

        if ($this->debug & 4) {
            echo '<p><b>set_root:</b> root = array(' . (count($root) > 0 ? '"' . implode('","', $root) . '"' : '') .")</p>\n";
        }
        $this->root = array();
        $missing = array();
        foreach ($root as $r) {
            if (substr($r, -1) == '/') {
                $r = substr ($r, 0, -1);
            }
            if (!@is_dir($r)) {
                $missing[] = $r;
                continue;
            }
            $this->root[] = $r;
        }
        if ($this->debug & 4) {
            echo '<p><b>set_root:</b> root = array(' . (count($root) > 0 ? '"' . implode('","', $root) . '"' : '') .")</p>\n";
        }
        if (count($this->root) > 0) {
            return true;
        }

        if (count($missing) > 0) {
            $this->halt("set_root: none of these directories exist: " . implode(', ', $missing));
        } else {
            $this->halt("set_root: at least on existing directory must be set as root.");
        }
        return false;
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
    * @param     $unknowns         new value for unknowns
    * @see       unknowns
    * @access    public
    * @return    void
    */
    function set_unknowns($unknowns = "")
    {
        global $TEMPLATE_OPTIONS;

        if (isset($TEMPLATE_OPTIONS['force_unknowns'])) {
            $unknowns = $TEMPLATE_OPTIONS['force_unknowns'];
        } else if (empty($unknowns)) {
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
    * Defines a filename for the initial value of a variable.
    *
    * It may be passed either a varname and a file name as two strings or
    * a hash of strings with the key being the varname and the value
    * being the file name.
    *
    * The new mappings are stored in the array $this->file.
    * The files are not loaded yet, but only when needed.
    *
    * Returns true on success, false on error.
    *
    * usage: set_file(array $filelist = (string $varname => string $filename))
    * or
    * usage: set_file(string $varname, string $filename)
    *
    * @param     $varname      either a string containing a varname or a hash of varname/file name pairs.
    * @param     $filename     if varname is a string this is the filename otherwise filename is not required
    * @access    public
    * @return    boolean
    */
    function set_file($varname, $filename = "")
    {
        global $_CONF;

        if (!is_array($varname)) {
            if ($this->debug & 4) {
                echo "<p><b>set_file:</b> (with scalar) varname = $varname, filename = $filename</p>\n";
            }
            if ($filename == "") {
                $this->halt("set_file: For varname $varname filename is empty.");
                return false;
            }
            $tFilename = $this->filename($filename);
            if ( isset($_CONF['cache_templates']) && $_CONF['cache_templates'] == true ) {
                $filename = $this->check_cache($varname, $tFilename);
                $this->file[$varname] = $filename;
            } else {
                $templateCode = $this->compile_template($varname,$tFilename);
                $this->templateCode[$varname] = $templateCode;
            }
            $this->location[$varname] = $tFilename;
        } else {
            reset($varname);
            while(list($v, $f) = each($varname)) {
                if ($this->debug & 4) {
                    echo "<p><b>set_file:</b> (with array) varname = $v, filename = $f</p>\n";
                }
                if ($f == "") {
                    $this->halt("set_file: For varname $v filename is empty.");
                    return false;
                }
                $tFilename = $this->filename($f);
                if ( isset($_CONF['cache_templates']) && $_CONF['cache_templates'] == true ) {
                     $f = $this->check_cache($v, $tFilename);
                    $this->file[$v] = $f;
                } else {
                    $f = $this->compile_template($v,$tFilename);
                    $this->templateCode[$v] = $f;
                }
                $this->location[$v] = $tFilename;
            }
        }
        return true;
    }


   /******************************************************************************
    * A variable $parent may contain a variable block defined by:
    * &lt;!-- BEGIN $varname --&gt; content &lt;!-- END $varname --&gt;. This function removes
    * that block from $parent and replaces it with a variable reference named $name.
    * The block is inserted into the varkeys and varvals hashes. If $name is
    * omitted, it is assumed to be the same as $varname.
    *
    * Blocks may be nested but care must be taken to extract the blocks in order
    * from the innermost block to the outermost block.
    *
    * Returns true on success, false on error.
    *
    * usage: set_block(string $parent, string $varname, [string $name = ""])
    *
    * @param     $parent       a string containing the name of the parent variable
    * @param     $varname      a string containing the name of the block to be extracted
    * @param     $name         the name of the variable in which to store the block
    * @access    public
    * @return    boolean
    */
    function set_block($parent, $varname, $name = "")
    {
        global $_CONF;

        $this->block_replace[$varname] = !empty($name)?$name:$parent;

        if ( isset($_CONF['cache_templates']) && $_CONF['cache_templates'] == true ) {
            $filename = $this->file[$parent];
            $p = pathinfo($filename);
            $this->blocks[$varname] = $p['dirname'].'/'.substr($p['basename'],0,-(strlen($p['extension'])+1)).'__'.$varname.'.'.$p['extension'];
            $this->file[$varname] = $p['dirname'].'/'.substr($p['basename'],0,-(strlen($p['extension'])+1)).'.'.$p['extension'];
        }
        
        return true;
    }

    /**
    * Modifies template location to prevent non-Root users from seeing it
    *
    * @param    string   $location
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
    * It may be called with either a varname and a value as two strings or an
    * an associative array with the key being the varname and the value being
    * the new variable value.
    *
    * The function inserts the new value of the variable into the $varkeys and
    * $varvals hashes. It is not necessary for a variable to exist in these hashes
    * before calling this function.
    *
    * An optional third parameter allows the value for each varname to be appended
    * to the existing variable instead of replacing it. The default is to replace.
    * This feature was introduced after the 7.2d release.
    *
    *
    * usage: set_var(string $varname, [string $value = ""], [boolean $append = false])
    * or
    * usage: set_var(array $varname = (string $varname => string $value), [mixed $dummy_var], [boolean $append = false])
    *
    * @param     $varname      either a string containing a varname or a hash of varname/value pairs.
    * @param     $value        if $varname is a string this contains the new value for the variable otherwise this parameter is ignored
    * @param     $append       if true, the value is appended to the variable's existing value
    * @param     $nocache      if true, the variable is added to the list of variable that are not instance cached.
    * @access    public
    * @return    void
    */
    function set_var($varname, $value = "", $append = false, $nocache = false)
    {
        if (!is_array($varname)) {
            if (!empty($varname) || $varname == 0) { // Allow varname to be numbers including 0
                if ($this->debug & 1) {
                    printf("<b>set_var:</b> (with scalar) <b>%s</b> = '%s'<br>\n", $varname, htmlentities($value));
                }

                if ($varname === 'templatelocation') {
                    $value = $this->_modifyTemplateLocation($value);
                }

                if ($append && isset($this->varvals[$varname])) {
                    $this->varvals[$varname] .= $value;
                } else {
                    $this->varvals[$varname] = $value;
                }
                if ($nocache) {
                    $this->nocache[$varname] = true;
                }
            }
        } else {
            reset($varname);
            while(list($k, $v) = each($varname)) {
                if (!empty($k) || $k == 0) { // Allow varname to be numbers including 0
                    if ($this->debug & 1) {
                        printf("<b>set_var:</b> (with array) <b>%s</b> = '%s'<br>\n", $k, htmlentities($v));
                    }

                    if ($k === 'templatelocation') {
                        $v = $this->_modifyTemplateLocation($v);
                    }

                    if ($append && isset($this->varvals[$k])) {
                        $this->varvals[$k] .= $v;
                    } else {
                        $this->varvals[$k] = $v;
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
    * It may be called with either a varname as a string or an array with the
    * values being the varnames to be cleared.
    *
    * The function sets the value of the variable in the $varkeys and $varvals
    * hashes to "". It is not necessary for a variable to exist in these hashes
    * before calling this function.
    *
    *
    * usage: clear_var(string $varname)
    * or
    * usage: clear_var(array $varname = (string $varname))
    *
    * @param     $varname      either a string containing a varname or an array of varnames.
    * @access    public
    * @return    void
    */
    function clear_var($varname)
    {
        if (!is_array($varname)) {
            if (!empty($varname) || $varname == 0) { // Allow number variable names including 0
                if ($this->debug & 1) {
                    printf("<b>clear_var:</b> (with scalar) <b>%s</b><br>\n", $varname);
                }
                $this->set_var($varname, "");
            }
        } else {
            reset($varname);
            while(list($k, $v) = each($varname)) {
                if (!empty($v) || $v == 0) { // Allow number variable names including 0
                    if ($this->debug & 1) {
                        printf("<b>clear_var:</b> (with array) <b>%s</b><br>\n", $v);
                    }
                    $this->set_var($v, "");
                }
            }
        }
    }


   /******************************************************************************
    * This functions unsets a variable completely.
    *
    * It may be called with either a varname as a string or an array with the
    * values being the varnames to be cleared.
    *
    * The function removes the variable from the $varkeys and $varvals hashes.
    * It is not necessary for a variable to exist in these hashes before calling
    * this function.
    *
    *
    * usage: unset_var(string $varname)
    * or
    * usage: unset_var(array $varname = (string $varname))
    *
    * @param     $varname      either a string containing a varname or an array of varnames.
    * @access    public
    * @return    void
    */
    function unset_var($varname)
    {
        if (!is_array($varname)) {
            if (!empty($varname) || $varname == 0) { // Allow number variable names including 0
                if ($this->debug & 1) {
                    printf("<b>unset_var:</b> (with scalar) <b>%s</b><br>\n", $varname);
                }
                unset($this->varkeys[$varname]);
                unset($this->varvals[$varname]);
            }
        } else {
            reset($varname);
            while(list($k, $v) = each($varname)) {
                if (!empty($v) || $v == 0) { // Allow number variable names including 0
                    if ($this->debug & 1) {
                        printf("<b>unset_var:</b> (with array) <b>%s</b><br>\n", $v);
                    }
                    unset($this->varkeys[$v]);
                    unset($this->varvals[$v]);
                }
            }
        }
    }


    /******************************************************************************
    * This function fills in all the variables contained within the variable named
    * $varname. The resulting value is returned as the function result and the
    * original value of the variable varname is not changed. The resulting string
    * is not "finished", that is, the unresolved variable name policy has not been
    * applied yet.
    *
    * Returns: the value of the variable $varname with all variables substituted.
    *
    * usage: subst(string $varname)
    *
    * @param     $varname      the name of the variable within which variables are to be substituted
    * @access    public
    * @return    string
    */
    function subst($varname) {
        global $_CONF;

        if ( isset($_CONF['cache_templates']) && $_CONF['cache_templates'] == true ) {
            if (isset($this->blocks[$varname])) {
                $filename = $this->blocks[$varname];
            } else if (isset($this->file[$varname])) {
                $filename = $this->file[$varname];
            } else if (isset($this->varvals[$varname]) OR empty($varname)) {
                return $this->slow_subst($varname);
            } else {
                // $varname does not reference a file so return
                if ($this->debug & 4) {
                    echo "<p><b>subst:</b> varname $varname does not reference a file</p>\n";
                }
                return "";
            }

            if (!is_readable($filename)) {
                // file missing
                if ($this->debug & 4) {
                    echo "<p><b>subst:</b> file $filename Does Not Exist or is not readable</p>\n";
                }
                return "";
            }

            $p = pathinfo($filename);
            if ($p['extension'] == 'php') {
                ob_start();
                include $filename;
                $str = ob_get_contents();
                ob_end_clean();
            } else {
                $str = slow_subst($varname);
            }
            return $str;
        } else {
            if (isset($this->blocks[$varname])) {
                $templateCode = $this->blocks[$varname];
            } else if (isset($this->templateCode[$varname])) {
                $templateCode = $this->templateCode[$varname];
            } else if (isset($this->varvals[$varname]) OR empty($varname)) {
                return $this->slow_subst($varname);
            } else {
                // $varname does not reference a file so return
                if ($this->debug & 4) {
                    echo "<p><b>subst:</b> varname $varname does not reference a file</p>\n";
                }
                return "";
            }

            ob_start();
            eval('?>'.$templateCode.'<?php ');
            $str = ob_get_contents();
            ob_end_clean();
            return $str;
        }
    }

   /******************************************************************************
    * This function fills in all the variables contained within the variable named
    * $varname. The resulting value is returned as the function result and the
    * original value of the variable varname is not changed. The resulting string
    * is not "finished", that is, the unresolved variable name policy has not been
    * applied yet.
    *
    * This is the old version of subst.
    *
    * Returns: the value of the variable $varname with all variables substituted.
    *
    * usage: subst(string $varname)
    *
    * @param     $varname      the name of the variable within which variables are to be substituted
    * @access    public
    * @return    string
    */
    function slow_subst($varname)
    {
        $varvals_quoted = array();
        if ($this->debug & 4) {
            echo "<p><b>subst:</b> varname = $varname</p>\n";
        }

        if (count($this->varkeys) < count($this->varvals)) {
            foreach ($this->varvals as $k => $v) {
                $this->varkeys[$k] = "{".$k."}";
            }
        }

        // quote the replacement strings to prevent bogus stripping of special chars
        reset($this->varvals);
        while(list($k, $v) = each($this->varvals)) {
            $varvals_quoted[$k] = str_replace(array('\\\\', '$'), array('\\\\\\\\', '\\\\$'), $v);
        }

        $str = $this->get_var($varname);
        $str = str_replace($this->varkeys, $varvals_quoted, $str);
        return $str;
    }


   /******************************************************************************
    * This is shorthand for print $this->subst($varname). See subst for further
    * details.
    *
    * Returns: always returns false.
    *
    * usage: psubst(string $varname)
    *
    * @param     $varname      the name of the variable within which variables are to be substituted
    * @access    public
    * @return    false
    * @see       subst
    */
    function psubst($varname)
    {
        if ($this->debug & 4) {
            echo "<p><b>psubst:</b> varname = $varname</p>\n";
        }
        print $this->subst($varname);

        return false;
    }


   /******************************************************************************
    * The function substitutes the values of all defined variables in the variable
    * named $varname and stores or appends the result in the variable named $target.
    *
    * It may be called with either a target and a varname as two strings or a
    * target as a string and an array of variable names in varname.
    *
    * The function inserts the new value of the variable into the $varkeys and
    * $varvals hashes. It is not necessary for a variable to exist in these hashes
    * before calling this function.
    *
    * An optional third parameter allows the value for each varname to be appended
    * to the existing target variable instead of replacing it. The default is to
    * replace.
    *
    * If $target and $varname are both strings, the substituted value of the
    * variable $varname is inserted into or appended to $target.
    *
    * If $handle is an array of variable names the variables named by $handle are
    * sequentially substituted and the result of each substitution step is
    * inserted into or appended to in $target. The resulting substitution is
    * available in the variable named by $target, as is each intermediate step
    * for the next $varname in sequence. Note that while it is possible, it
    * is only rarely desirable to call this function with an array of varnames
    * and with $append = true. This append feature was introduced after the 7.2d
    * release.
    *
    * Returns: the last value assigned to $target.
    *
    * usage: parse(string $target, string $varname, [boolean $append])
    * or
    * usage: parse(string $target, array $varname = (string $varname), [boolean $append])
    *
    * @param     $target      a string containing the name of the variable into which substituted $varnames are to be stored
    * @param     $varname     if a string, the name the name of the variable to substitute or if an array a list of variables to be substituted
    * @param     $append      if true, the substituted variables are appended to $target otherwise the existing value of $target is replaced
    * @access    public
    * @return    string
    * @see       subst
    */
    function parse($target, $varname, $append = false)
    {
        if (!is_array($varname)) {
            if ($this->debug & 4) {
                echo "<p><b>parse:</b> (with scalar) target = $target, varname = $varname, append = $append</p>\n";
            }
            if ( isset($this->location[$varname]) ) {
                $this->set_var('templatelocation',$this->location[$varname]);
            }
            $str = $this->subst($varname);
            if ($append) {
                $this->set_var($target, $this->get_var($target) . $str);
            } else {
                $this->set_var($target, $str);
            }
        } else {
            reset($varname);
            while(list($i, $v) = each($varname)) {
                if ($this->debug & 4) {
                    echo "<p><b>parse:</b> (with array) target = $target, i = $i, varname = $v, append = $append</p>\n";
                }
                $this->set_var('templatelocation',$this->location[$v]);
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
    * Returns: always returns false.
    *
    * usage: pparse(string $target, string $varname, [boolean $append])
    * or
    * usage: pparse(string $target, array $varname = (string $varname), [boolean $append])
    *
    * @param     $target      a string containing the name of the variable into which substituted $varnames are to be stored
    * @param     $varname     if a string, the name the name of the variable to substitute or if an array a list of variables to be substituted
    * @param     $append      if true, the substituted variables are appended to $target otherwise the existing value of $target is replaced
    * @access    public
    * @return    false
    * @see       parse
    */
    function pparse($target, $varname, $append = false)
    {
        if ($this->debug & 4) {
            echo "<p><b>pparse:</b> passing parameters to parse...</p>\n";
        }
        print $this->finish($this->parse($target, $varname, $append));
        return false;
    }


   /******************************************************************************
    * This function returns an associative array of all defined variables with the
    * name as the key and the value of the variable as the value.
    *
    * This is mostly useful for debugging. Also note that $this->debug can be used
    * to echo all variable assignments as they occur and to trace execution.
    *
    * Returns: a hash of all defined variable values keyed by their names.
    *
    * usage: get_vars()
    *
    * @access    public
    * @return    array
    * @see       $debug
    */
    function get_vars()
    {
        if ($this->debug & 4) {
            echo "<p><b>get_vars:</b> constructing array of vars...</p>\n";
        }
        reset($this->varvals);
        while(list($k, $v) = each($this->varvals)) {
            $result[$k] = $this->get_var($k);
        }
        return $result;
    }


   /******************************************************************************
    * This function returns the value of the variable named by $varname.
    * If $varname references a file and that file has not been loaded yet, the
    * variable will be reported as empty.
    *
    * When called with an array of variable names this function will return a a
    * hash of variable values keyed by their names.
    *
    * Returns: a string or an array containing the value of $varname.
    *
    * usage: get_var(string $varname)
    * or
    * usage: get_var(array $varname)
    *
    * @param     $varname     if a string, the name the name of the variable to get the value of, or if an array a list of variables to return the value of
    * @access    public
    * @return    string or array
    */
    function get_var($varname)
    {
        if (!is_array($varname)) {
            if (isset($this->varvals[$varname])) {
                $str = $this->varvals[$varname];
            } else {
                $str = "";
            }
            if ($this->debug & 2) {
                printf ("<b>get_var</b> (with scalar) <b>%s</b> = '%s'<br>\n", $varname, htmlentities($str));
            }
            return $str;
        } else {
            reset($varname);
            while(list($k, $v) = each($varname)) {
                if (isset($this->varvals[$v])) {
                    $str = $this->varvals[$v];
                } else {
                    $str = "";
                }
                if ($this->debug & 2) {
                    printf ("<b>get_var:</b> (with array) <b>%s</b> = '%s'<br>\n", $v, htmlentities($str));
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
    * This function returns a hash of unresolved variable names in $varname, keyed
    * by their names (that is, the hash has the form $a[$name] = $name).
    *
    * Returns: a hash of varname/varname pairs or false on error.
    *
    * usage: get_undefined(string $varname)
    *
    * @param     $varname     a string containing the name the name of the variable to scan for unresolved variables
    * @access    public
    * @return    array
    */
    function get_undefined($varname)
    {
        if ($this->debug & 4) {
            echo "<p><b>get_undefined (DEPRECATED):</b> varname = $varname</p>\n";
        }
        if (!$this->loadfile($varname)) {
            $this->halt("get_undefined: unable to load $varname.");
            return false;
        }

        preg_match_all("/{([^ \t\r\n}]+)}/", $this->get_var($varname), $m);
        $m = $m[1];
        if (!is_array($m)) {
            return false;
        }

        reset($m);
        while(list($k, $v) = each($m)) {
            if (!isset($this->varvals[$v])) {
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
    * @param     $str         a string to return
    * @access    public
    * @return    string
    */
    function finish($str)
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
    * by $varname. That is, the policy regarding unresolved variable names will be
    * applied to the variable $varname then it will be printed.
    *
    * usage: p(string $varname)
    *
    * @param     $varname     a string containing the name of the variable to finish and print
    * @access    public
    * @return    void
    * @see       set_unknowns
    * @see       finish
    */
    function p($varname)
    {
        print $this->finish($this->get_var($varname));
    }


   /******************************************************************************
    * This function returns the finished version of the value of the variable named
    * by $varname. That is, the policy regarding unresolved variable names will be
    * applied to the variable $varname and the result returned.
    *
    * Returns: a finished string derived from the variable $varname.
    *
    * usage: get(string $varname)
    *
    * @param     $varname     a string containing the name of the variable to finish
    * @access    public
    * @return    void
    * @see       set_unknowns
    * @see       finish
    */
    function get($varname)
    {
        return $this->finish($this->get_var($varname));
    }


   /******************************************************************************
    * When called with a relative pathname, this function will return the pathname
    * with $this->root prepended. Absolute pathnames are returned unchanged.
    *
    * Returns: a string containing an absolute pathname.
    *
    * usage: filename(string $filename)
    *
    * @param     $filename    a string containing a filename
    * @access    private
    * @return    string
    * @see       set_root
    */
    function filename($filename)
    {
        if ($this->debug & 4) {
            echo "<p><b>filename:</b> filename = $filename</p>\n";
        }
        if ($this->debug & 8) {
            foreach($this->root as $r) {
                echo "root: " . $r . "<br>";
            }
        }

        // if path reaches root, just use it.
        if (substr($filename, 0, 1) == '/' ||   // handle unix root /
            substr($filename, 1, 1) == ':' ||   // handle windows d:\path
            substr($filename, 0, 2) == '\\\\'   // handle windows network path \\server\path
           ) {
            if (!file_exists($filename)) {
                $this->halt("filename: file $filename does not exist.(1)");
            }
            return $filename;
        } else {
            // check each path in order
            foreach ($this->root as $r) {
                $f = $r.'/'.$filename;
                if ($this->debug & 8) {
                    echo "<p><b>filename:</b> filename = $f</p>\n";
                }
                if (file_exists($f)) {
                    return $f;
                }
            }
        }
        $this->halt("filename: file $filename does not exist.(2)");
        return $filename;
    }


   /******************************************************************************
    * This function will construct a regexp for a given variable name with any
    * special chars quoted.
    *
    * Returns: a string containing an escaped variable name.
    *
    * usage: varname(string $varname)
    *
    * @param     $varname    a string containing a variable name
    * @access    private
    * @return    string
    */
    function varname($varname)
    {
        return preg_quote("{".$varname."}");
    }


   /******************************************************************************
    * If a variable's value is undefined and the variable has a filename stored in
    * $this->file[$varname] then the backing file will be loaded and the file's
    * contents will be assigned as the variable's value.
    *
    * Note that the behaviour of this function changed slightly after the 7.2d
    * release. Where previously a variable was reloaded from file if the value
    * was empty, now this is not done. This allows a variable to be loaded then
    * set to "", and also prevents attempts to load empty variables. Files are
    * now only loaded if $this->varvals[$varname] is unset.
    *
    * Returns: true on success, false on error.
    *
    * usage: loadfile(string $varname)
    *
    * @param     $varname    a string containing the name of a variable to load
    * @access    private
    * @return    boolean
    * @see       set_file
    */
    function loadfile($varname)
    {
        if ($this->debug & 4) {
            echo "<p><b>loadfile:</b> varname = $varname</p>\n";
        }

        if (!isset($this->file[$varname])) {
            // $varname does not reference a file so return
            if ($this->debug & 4) {
                echo "<p><b>loadfile:</b> varname $varname does not reference a file</p>\n";
            }
            return true;
        }

        if (isset($this->varvals[$varname])) {
            // will only be unset if varname was created with set_file and has never been loaded
            // $varname has already been loaded so return
            if ($this->debug & 4) {
                echo "<p><b>loadfile:</b> varname $varname is already loaded</p>\n";
            }
            return true;
        }
        $filename = $this->file[$varname];

        /* use @file here to avoid leaking filesystem information if there is an error */
        $str = @file_get_contents($filename);
        if (empty($str)) {
            $this->halt("loadfile: While loading $varname, $filename does not exist or is empty.");
            return false;
        }

        if ($this->debug & 4) {
            printf("<b>loadfile:</b> loaded $filename into $varname<br>\n");
        }
        $this->set_var($varname, $str);

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
    * @param     $msg         a string containing an error message
    * @access    private
    * @return    void
    * @see       $halt_on_error
    */
    function halt($msg)
    {
        $this->last_error = $msg;

        if ($this->halt_on_error != "no" && $this->halt_on_error != "log") {
            $this->haltmsg($msg);
        }

        if ($this->halt_on_error == "log") {
            COM_errorLog($msg);
        }

        return false;
    }


   /******************************************************************************
    * This function prints an error message.
    * It can be overridden by your subclass of Template. It will be called with an
    * error message to display.
    *
    * usage: haltmsg(string $msg)
    *
    * @param     $msg         a string containing the error message to display
    * @access    public
    * @return    void
    * @see       halt
    */
    function haltmsg($msg)
    {
        if ($this->halt_on_error == 'yes') {
            trigger_error(sprintf("Template Error: %s", $msg));
        } else {
            printf("<b>Template Error:</b> %s<br />\n", $msg);
        }
    }

   /******************************************************************************
    * These functions are called from the cached php file to fetch data into the template.
    * You should NEVER have to call them directly.
    *
    * @param  $val             string containing name of template variable
    * @param  $modifier        Optional parameter to apply modifiers to template variables
    * @access private
    * @return string
    * @see    cache_blocks,check_cache
    *
    */
    function val_echo($val)
    {
      if (array_key_exists($val, $this->nocache) && $this->unknowns == 'PHP') {
          return '<?php echo $this->val_echo(\''.$val.'\'); ?>';
      }

      if (array_key_exists($val, $this->varvals)) {
          return $this->varvals[$val];
      }
      if ($this->unknowns == 'comment') {
          return "<!-- Template variable $val undefined -->";
      } else if ($this->unknowns == 'keep') {
          // return '{'.$val.'}{'.$this->varvals[$val].'}'; // Not sure why this was like this and not like below
          return '{'.$val.'}';
      }
      return '';
    }

   /***
    * Used in {!if var}. Avoid duplicating a large string when all we care about is if the string is non-zero length
    */
    function var_notempty($val)
    {
        if (array_key_exists($val, $this->varvals)) {
            return !empty($this->varvals[$val]);
        }
        return false;
    }

    function mod_echo($val, $modifier = '')
    {
        if (array_key_exists($val, $this->nocache) && $this->unknowns == 'PHP') {
            if (empty($modifier)) {
                return '<?php echo $this->val_echo(\''.$val.'\'); ?>';
            } else {
                return '<?php echo $this->mod_echo(\''.$val.'\',\''.$modifier.'\'); ?>';
            }
        }

        if (array_key_exists($val, $this->varvals)) {
            $mods = explode(':', substr($modifier,1));
            $ret = $this->varvals[$val];
            foreach ($mods as $mod) {
                switch ($mod[0]) {
                    case 'u':
                        $ret = urlencode($ret);
                        break;
                    case 's':
                        $ret = htmlspecialchars($ret);
                        break;
                    case 't':
                        $ret = substr($ret, 0, intval(substr($mod,1))); // truncate
                        break;
                }
            }
            return $ret;
        }
        if ($this->unknowns == 'comment') {
            return '<!-- Template variable '.htmlspecialchars($val).' undefined -->';
        } else if ($this->unknowns == 'keep') {
            return '{'.htmlspecialchars($val.$modifier).'}';
        }
        return '';
    }

    function lang_echo($val)
    {
        // only allow variables with LANG in them to somewhat protect this from harm.
        if (stristr($val, 'LANG') === false) {
            return '';
        }
        $A = explode('[',$val);
        if (isset($GLOBALS[$A[0]])) {
            $var = $GLOBALS[$A[0]];
            for ($i = 1; $i < count($A); ++$i) {
                $idx = str_replace(array(']',"'"),'',$A[$i]);
                if (array_key_exists($idx, $var)) {
                    $var = $var[$idx];
                } else {
                    break;
                }
            }
            if (is_scalar($var)) {
                return htmlspecialchars($var);
            }
        }
        if ($this->unknowns == 'comment') {
            return '<!-- Language variable '.htmlspecialchars($val).' undefined -->';
        } else if ($this->unknowns == 'keep') {
            return '{'.htmlspecialchars($val).'}';
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
        $loopvar = $var . '__loopvar';
        $limit = $this->get_var($var);
        $current = $this->get_var($loopvar);
        if ($limit > 0) {
            $this->set_var($loopvar, ++$current);
            $ret = $current <= $limit;
        } else {
            $this->set_var($loopvar, --$current);
            $ret = $current >= $limit;
        }
        if (!$ret) $this->unset_var($loopvar);
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
    * @param  $in_php          boolean used to determing if php escape chars need to be printed
    * @access private
    * @return string
    * @see    cache_write
    *
    */
    function replace_vars($tmplt, $in_php = false)
    {
        // do all the common substitutions
        if ($in_php) {
            $tmplt = preg_replace(
                      array(
                            '/\{([-\.\w\d_\[\]]+)\}/',                              // matches {identifier}
                            '/\{([-\.\w\d_\[\]]+)((:u|:s|:t\d+)+)\}/',              // matches {identifier} with optional :s, :u or :t### suffix
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
                            '/\{([-\.\w\d_\[\]]+)((:u|:s|:t\d+)+)\}/',              // matches {identifier} with optional :s, :u or :t### suffix
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
        return $this->lang_echo($matches[1].'['.$matches[3].']');
    }

    function parse_quoted_lang_callback($matches)
    {
        return '\'' . addslashes($this->lang_echo($matches[1].'['.$matches[3].']')) . '\'';
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
        global $TEMPLATE_OPTIONS;

        $cond    = '';
        $prefix  = '';
        $postfix = '';

        if ( $matches[1] == 'autotag' ) {
            $cond = "echo PLG_replaceTags('[".$matches[2]."]');";
        } else if ($matches[1] == 'set') {
            $cond = $matches[3];
            $prefix = '$this->set_var(\'' . addslashes($matches[2]) . '\', ';
            $postfix = ');';
        } else if ($matches[1] == 'global' || $matches[1] == 'echo' || $matches[1] == '') {
            $cond = $matches[2];
            $prefix = $matches[1] . ' ';
            $postfix = ';';
        } else if (substr($matches[1],0,5) == '$LANG') {
            $lang = substr($matches[1],1);
            $cond = $matches[4];

            $prefix = 'echo sprintf($this->lang_echo(\''.$lang.'['.$matches[3].']\'),';
            $postfix = ');';
        } else {
            $cond = $matches[2];
            $prefix = $matches[1] . ' (';
            $postfix = '):';
        }

        $cond = $this->replace_vars($cond,true);
        $cond = $this->replace_lang($cond,true);

        return '<?php ' . $prefix . $cond . $postfix . ' ?>';
    }

   /******************************************************************************
    * This function does the final replace of {variable} with the appropriate PHP
    * and writes the text to the cache directory.
    *
    * As an internal function, you should never call it directly
    * usage: cache_write(string $filename, string $tmplt, string $replace)
    *
    * @param  $filename       string containing complete path to the cache file
    * @param  $tmplt          contents of the template file before replacement
    * @access private
    * @return void
    * @see    cache_blocks,check_cache
    *
    */
    function cache_write($filename, $tmplt)
    {
        global $TEMPLATE_OPTIONS, $_CONF;

        // order of operations could matter a lot so get rid of
        // template comments first: emits nothing to the output file
        // since the regex is multiline, make sure there is a comment before calling it

        if (strpos($tmplt, '{#') !== false) {
            if ( isset($_CONF['template_comments']) && $_CONF['template_comments'] == true ) {
                $tmplt = str_replace('{#','<!-- ',$tmplt);
                $tmplt = str_replace('#}',' -->',$tmplt);
            } else {
                $tmplt = preg_replace('!\{#.*?#\}(\n)?!sm', '', $tmplt);
            }
        }

        $tmplt = $this->replace_extended($tmplt);
        $tmplt = $this->replace_lang($tmplt);
        $tmplt = $this->replace_vars($tmplt);

        // clean up concatenation.
        $tmplt = str_replace('?'.'><'.'?php ', // makes the cache file easier on the eyes (need the concat to avoid PHP interpreting the ? >< ?php incorrectly
                            "\n", $tmplt);

        if ($this->debug & 4) {
            printf("<b>cache_write:</b> opening $filename<br>\n");
        }
        $f = @fopen($filename,'w');
        if ($f !== false ) {
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
    * @param  $filestub       format string for sprintf to create cache filename
    * @param  $parent         array containing name and content of the block
    * @access private
    * @return void
    * @see    cache_write,check_cache,set_block
    *
    */
    function cache_blocks($filestub, $parent)
    {
        $reg = "/\s*<!--\s+BEGIN ([-\w\d_]+)\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END \\1\s+-->\s*?\n?/smU";
        $matches = array();
        $str = $parent[2];
        $matches = array();
        if (preg_match_all($reg, $str, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $replace = '<?php echo $this->block_echo(\''.$m[1].'\'); ?>';
                $str = str_replace($m[0], $replace, $str);
                $this->cache_blocks($filestub, $m);
            }
        }
        $filename = sprintf($filestub, $parent[1]);
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
    * @param  $varname        unused, name of the variable associated with the file
    * @param  $filename       path to the template file
    * @access private
    * @return void
    * @see    cache_block,cache_write,filename
    *
    */
    function check_cache($varname, $filename)
    {
        global $TEMPLATE_OPTIONS, $_CONF;

        if ($this->debug & 8) {
            printf("<check_cache> Var %s for file %s<br>", $varname, $filename);
        }
        $p = pathinfo($filename);
        if ($p['extension'] == 'php') {
            return $filename;
        }
        $basefile = basename($p['basename'],".{$p['extension']}");

        // convert /path_to_geeklog//layout/theme/dir1/dir2/file to dir1/dir2/file
        $extra_path = '';
        if ( is_array($TEMPLATE_OPTIONS['path_prefixes']) ) {
            foreach ($TEMPLATE_OPTIONS['path_prefixes'] as $prefix) {
                if (strpos($p['dirname'], $prefix) === 0) {
                    $extra_path = substr($p['dirname'].'/', strlen($prefix));
                    break;
                }
            }
        }

        if (!empty($extra_path)) {
            $extra_path = str_replace(array('/','\\',':'), '__', $extra_path);
        }

        if ($TEMPLATE_OPTIONS['cache_by_language']) {
            $extra_path = $_CONF['language'] . '/' . $extra_path;
            if (!is_dir($TEMPLATE_OPTIONS['path_cache'] . $_CONF['language'])) {
                @mkdir($TEMPLATE_OPTIONS['path_cache'] . $_CONF['language']);
                @touch($TEMPLATE_OPTIONS['path_cache'] . $_CONF['language'] . '/index.html');
            }
        }
        $phpfile = $TEMPLATE_OPTIONS['path_cache'] . $extra_path . $basefile . '.php';

        $template_fstat = @filemtime($filename);
        if (file_exists($phpfile)) {
            $cache_fstat = @filemtime($phpfile);
        } else {
            $cache_fstat = 0;
        }

        if ($this->debug & 8) {
            printf("<check_cache> Look for %s<br>", $filename);
        }

        if ($template_fstat > $cache_fstat ) {

            $str = @file_get_contents($filename);
            
            // Do any preprocessing
            $str = $this->_preprocess($str);            

            // check for begin/end block stuff
            $reg = "/\s*<!--\s+BEGIN ([-\w\d_]+)\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END \\1\s+-->\s*?\n?/smU";
            $matches = array();
            if (preg_match_all($reg, $str, $matches, PREG_SET_ORDER)) {
                $phpstub = $TEMPLATE_OPTIONS['path_cache'] . $extra_path . $basefile . '__%s' . '.php';
                foreach ($matches as $m) {
                    $str = str_replace($m[0], '<?php echo $this->block_echo(\''.$m[1].'\'); ?>', $str);
                    $this->cache_blocks($phpstub, $m);
                }
            }
            $this->cache_write($phpfile, $str);
        }
        return $phpfile;
    }

   /******************************************************************************
    * This function is only used with template files that contain BEGIN/END BLOCK
    * sections. See set_block for more details.
    *
    * As an internal function, you should never call it directly
    * usage: compile_blocks(string $filestub, array $parent, string $replace)
    *
    * @param  $filestub       format string for sprintf to create cache filename
    * @param  $parent         array containing name and content of the block
    * @access private
    * @return void
    * @see    cache_write,compile_template,set_block
    *
    */
    function compile_blocks($parent)
    {
        global $_CONF;

        $reg = "/\s*<!--\s+BEGIN ([-\w\d_]+)\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END \\1\s+-->\s*?\n?/smU";
        $matches = array();
        $str = $parent[2];
        $matches = array();
        if (preg_match_all($reg, $str, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $replace = '<?php echo $this->block_echo(\''.$m[1].'\'); ?>';
                $str = str_replace($m[0], $replace, $str);
                $this->compile_blocks($m);
            }
        }

        // order of operations could matter a lot so get rid of
        // template comments first: emits nothing to the output file
        // since the regex is multiline, make sure there is a comment before calling it
        if (strpos($str, '{#') !== false) {
            if ( isset($_CONF['template_comments']) && $_CONF['template_comments'] == true ) {
                $str = str_replace('{#','<!-- ',$str);
                $str = str_replace('#}',' -->',$str);
            } else {
                $str = preg_replace('!\{#.*?#\}(\n)?!sm', '', $str);
            }
        }

        $tmplt = $this->replace_extended($str);
        $tmplt = $this->replace_lang($tmplt);
        $tmplt = $this->replace_vars($tmplt);

        // clean up concatenation.
        $tmplt = str_replace('?'.'><'.'?php ', // makes the cache file easier on the eyes (need the concat to avoid PHP interpreting the ? >< ?php incorrectly
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
    * @param  $varname        unused, name of the variable associated with the file
    * @param  $filename       path to the template file
    * @access private
    * @return void
    * @see    cache_block,cache_write,filename
    *
    */
    function compile_template($varname, $filename)
    {
        global $TEMPLATE_OPTIONS, $_CONF;

        if ($this->debug & 8) {
            printf("<compile_template> Var %s for file %s<br>", $varname, $filename);
        }

        $str = @file_get_contents($filename);

        // Do any preprocessing
        $str = $this->_preprocess($str);
        
        // check for begin/end block stuff
        $reg = "/\s*<!--\s+BEGIN ([-\w\d_]+)\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END \\1\s+-->\s*?\n?/smU";
        $matches = array();
        if (preg_match_all($reg, $str, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $str = str_replace($m[0], '<?php echo $this->block_echo(\''.$m[1].'\'); ?>', $str);
                $this->compile_blocks($m);
            }
        }

        // order of operations could matter a lot so get rid of
        // template comments first: emits nothing to the output file
        // since the regex is multiline, make sure there is a comment before calling it
        if (strpos($str, '{#') !== false) {
            if ( isset($_CONF['template_comments']) && $_CONF['template_comments'] == true ) {
                $str = str_replace('{#','<!-- ',$str);
                $str = str_replace('#}',' -->',$str);
            } else {
                $str = preg_replace('!\{#.*?#\}(\n)?!sm', '', $str);
            }
        }

        $tmplt = $this->replace_extended($str);
        $tmplt = $this->replace_lang($tmplt);
        $tmplt = $this->replace_vars($tmplt);

        // clean up concatenation.
        $tmplt = str_replace('?'.'><'.'?php ', // makes the cache file easier on the eyes (need the concat to avoid PHP interpreting the ? >< ?php incorrectly
                             "\n", $tmplt);

        return $tmplt;

    }

   /******************************************************************************
    * Prevents certain variables from being cached in the instance cache.
    *
    * @param  $vars           A string varname or array of varnames
    * @access public
    * @return none
    * @see    create_instance, set_var
    */
    function uncached_var($vars)
    {
        if (empty($vars)) {
            return;
        } elseif (!is_array($vars)) {
            $vars = array($vars);
        }
        foreach ($vars as $varname) {
            $this->nocache[$varname] = true;
        }
    }

   /******************************************************************************
    * Creates an instance of the current template. Variables in the nocache array
    * are untranslated by returning the original PHP back. Conceptually, this
    * function is equivalent to the parse function.
    *
    * The $iid parameter must be globally unique. The recommended format is
    *   $plugin_$primarykey  or $plugin_$page_$uid
    *
    * The $filevar parameter is supposed to match one of the varnames passed to
    * set_file.
    *
    * usage: create_instance(string $iid, string $filevar)
    *
    * @param  $iid            A globally unique instance identifier.
    * @param  $filevar        This is the varname passed to $T->set_file.
    * @access public
    * @return string          The fullpath of the cached file.
    * @see    check_instance
    *
    */
    function create_instance($iid, $filevar) {
      global $TEMPLATE_OPTIONS, $_CONF;

      $old_unknowns = $this->unknowns;
      $this->unknowns = 'PHP';
      $tmplt = $this->parse($iid, $filevar);
      $path_cache = $TEMPLATE_OPTIONS['path_cache'];
      if ($TEMPLATE_OPTIONS['cache_by_language']) {
          $path_cache .= $_CONF['language'] . '/';
      }
      $iid = str_replace(array('..', '/', '\\', ':'), '', $iid);
      // COMMENT ORIGINAL LINE below out since not sure why changing dashes to under scores ... this affects articles and staticpages
      // $iid = str_replace('-','_',$iid);
      $filename = $path_cache.'instance__'.$iid.'.php';
      $tmplt = '{# begin cached as '.htmlspecialchars($iid)." #}\n"
             . $tmplt
             . '{# end cached as '.htmlspecialchars($iid)." #}\n";
      $this->cache_write($filename, $tmplt);
      $this->unknowns = $old_unknowns;
      return $filename;
    }

   /******************************************************************************
    * Checks for an instance of the current template. This check is based soley on
    * the $iid. The $filevar is replaces with the cached file if it exists.
    *
    * The $iid parameter must be globally unique. The recommended format is
    *   $plugin_$primarykey  or $plugin_$page_$uid
    *
    * The $filevar parameter is supposed to match one of the varnames passed set_file.
    *
    * usage:
    *          $T->set_file('main', 'main.thtml');
    *          $iid = 'mainfile_'.$primarykey;
    *          if (!$T->check_instance($iid, 'main')) {
    *              $T->set_var(...); //...
    *              $T->create_instance($iid, 'main');
    *          }
    *          $T->set_var('hits', $hit_count, false, true);
    *          $T->parse('output', 'main');
    *
    * @param  $iid            A globally unique instance identifier.
    * @param  $filevar        This is the varname passed to $T->set_file.
    * @access public
    * @return boolean         true if the instance file exists
    * @see    create_instance
    *
    */
    function check_instance($iid, $filevar) {
      global $TEMPLATE_OPTIONS, $_CONF;

      $path_cache = $TEMPLATE_OPTIONS['path_cache'];
      if ($TEMPLATE_OPTIONS['cache_by_language']) {
          $path_cache .= $_CONF['language'] . '/';
      }
      $iid = str_replace(array('..', '/', '\\', ':'), '', $iid);
      // COMMENT ORIGINAL LINE below out since not sure why changing dashes to under scores ... this affects articles and staticpages
      // $iid = str_replace('-','_',$iid);
      $filename = $path_cache.'instance__'.$iid.'.php';
      if (file_exists($filename) && array_key_exists($filevar, $this->file)) {
          $this->file[$filevar] = $filename; 
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
 * @param  $path            Directory path being cleaned
 * @param  $needle          String matched against cache filenames
 * @access private
 * @return void
 *
 */
function cache_clean_directories($path, $needle = '', $since = 0)
{
    if ($dir = @opendir($path)) {
        while (false !== ($entry = readdir($dir))) {
            if ($entry == '.' || $entry == '..' || $entry == '.svn' || is_link($entry)) {
            } elseif (is_dir($path . '/' . $entry)) {
                cache_clean_directories($path . '/' . $entry, $needle);
                @rmdir($path . '/' . $entry);
            } elseif (empty($needle) || strpos($entry, $needle) !== false) {
                if (!$since || @filectime($path . '/' . $entry) <= $since) {
                    @unlink($path . '/' . $entry);
                }
            }
        }
        @closedir($dir);
    }
}

/******************************************************************************
 * Removes all cached files associated with a plugin.
 *
 * usage: CACHE_cleanup_plugin($plugin);
 *
 * @param  $plugin          String containing the plugin's name
 * @access public
 * @return void
 *
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
 * @param  $iid            A globally unique instance identifier.
 * @access public
 * @return void
 * @see    check_instance, create_instance
 *
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
    CACHE_clean_directories($path_cache, 'instance__'.$iid);
}


/******************************************************************************
 * Creates a cached copy of the data passed.
 *
 * usage: CACHE_create_instance($iid, $data, $bypass_lang);
 *
 * @param  $iid            A globally unique instance identifier.
 * @param  $data           The data to cache
 * @param  $bypass_lang    If true, the cached data is not instanced by language
 * @access public
 * @return void
 * @see    CACHE_check_instance, CACHE_remove_instance
 *
 */
function CACHE_create_instance($iid, $data, $bypass_lang = false)
{
    global $TEMPLATE_OPTIONS, $_CONF;

    if ($TEMPLATE_OPTIONS['cache_by_language']) {
        if (!is_dir($TEMPLATE_OPTIONS['path_cache'] . $_CONF['language'])) {
            @mkdir($TEMPLATE_OPTIONS['path_cache'] . $_CONF['language']);
            @touch($TEMPLATE_OPTIONS['path_cache'] . $_CONF['language'] . '/index.html');
        }
    }

    $filename = CACHE_instance_filename($iid, $bypass_lang);
    file_put_contents($filename, $data);

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
 * @param  $iid            A globally unique instance identifier.
 * @param  $bypass_lang    If true, the cached data is not instanced by language
 * @access public
 * @return the data string or false is there is no such instance
 * @see    CACHE_check_instance, CACHE_remove_instance
 *
 */
function CACHE_check_instance($iid, $bypass_lang = false)
{
    global $_CONF;

    $filename = CACHE_instance_filename($iid, $bypass_lang);
    if (file_exists($filename)) {
        $str = @file_get_contents($filename);
        return $str === FALSE ? false : $str;
    }
    return false;
}

/******************************************************************************
 * Returns the time when the referenced instance was generated.
 *
 * usage: $time = CACHE_get_instance_update($iid, $bypass_lang = false)
 *
 * @param  $iid            A globally unique instance identifier.
 * @param  $bypass_lang    If true, the cached data is not instanced by language
 * @access public
 * @return unix_timestamp of when the instance was generated or false
 * @see    CACHE_check_instance, CACHE_remove_instance
 *
 */
function CACHE_get_instance_update($iid, $bypass_lang = false)
{
    global $_CONF;

    $filename = CACHE_instance_filename($iid, $bypass_lang);
    return @filemtime($filename);

}

/******************************************************************************
 * Generates a full path to the instance file. Should really only be used
 * internally but there are probably reasons to use it externally.
 *
 * usage: $time = CACHE_instance_filename($iid, $bypass_lang = false)
 *
 * @param  $iid            A globally unique instance identifier.
 * @param  $bypass_lang    If true, the cached data is not instanced by language
 * @access public
 * @return unix_timestamp of when the instance was generated or false
 * @see    CACHE_create_instance, CACHE_check_instance, CACHE_remove_instance
 *
 */
function CACHE_instance_filename($iid,$bypass_lang = false)
{
    global $TEMPLATE_OPTIONS, $_CONF;

    $path_cache = $TEMPLATE_OPTIONS['path_cache'];
    if (!$bypass_lang && $TEMPLATE_OPTIONS['cache_by_language']) {
        $path_cache .= $_CONF['language'] . '/';
    }
    $iid = COM_sanitizeFilename($iid, true);
    $filename = $path_cache.'instance__'.$iid.'.php';

    return $filename;
}

/******************************************************************************
 * Generates a hash based on the current user's secutiry profile.
 *
 * Currently that is just a list of groups the user is a member of but if
 * additional data is found to be necessary for creating a unique security
 * profile, this centralized function would be the place for it.
 *
 * usage: $hash = CACHE_security_hash()
 *        $instance = "somedata__$someid__$hash";
 *        CACHE_create_instance($instance, $thedata);
 *
 * @access public
 * @return a string uniquely identifying the user's security profile
 *
 */
function CACHE_security_hash()
{
    global $_GROUPS, $_USER;

    static $hash = NULL;

    if (empty($hash)) {
        $groups = implode(',',$_GROUPS);
        $hash = strtolower(md5($groups));
        if ( !empty($_USER['tzid']) ) {
            $hash .= 'tz'.md5($_USER['tzid']);
        }
    }
    return $hash;

}

?>