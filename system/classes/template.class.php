<?php

/** 
* FOLLOWING CODE IS FROM PHPLib (http://phplib.sourceforge.net)
* This code is under the LGPL and NOT the GPL.  
*
* We provide this as opposed to requiring PHPLib as this is the only
* feature we are using thus far.
*
* Template Management for PHP3
*
* (C) Copyright 1999-2000 NetUSE GmbH
*                    Kristian Koehntopp
*
* $Id&
*/ 
class Template {
  var $classname = "Template";

  /* if set, echo assignments */
  var $debug     = false;

  /* $file[handle] = "filename"; */
  var $file  = array();

  /* relative filenames are relative to this pathname */
  var $root   = "";

  /* $varkeys[key] = "key"; $varvals[key] = "value"; */
  var $varkeys = array();
  var $varvals = array();

  /* "remove"  => remove undefined variables
   * "comment" => replace undefined variables with comments
   * "keep"    => keep undefined variables
   */
  var $unknowns = "remove";
  
  /* "yes" => halt, "report" => report error, continue, "no" => ignore error quietly */
  var $halt_on_error  = "yes";
  
  /* last error message is retained here */
  var $last_error     = "";

  /**
  * Constructor.
  *
  * @param      string      $root       template directory.
  * @param      string      $unknowns   how to handle unknown variables
  *
  */
  function Template($root = ".", $unknowns = "remove") {
    $this->set_root($root);
    $this->set_unknowns($unknowns);
  }

  /**
  * Sets root template directory
  * 
  * @param  string      $root   new template directory.
  * @return boolean     true if successful, otherwise false
  *
  */  
  function set_root($root) {
    if (!is_dir($root)) {
      $this->halt("set_root: $root is not a directory.");
      return false;
    }
    
    $this->root = $root;
    return true;
  }

  /**
  * Specifies what to do with unparsed variables
  *
  * @param  string  $unknowns   can either "remove", "comment" or "keep"
  *
  */
  function set_unknowns($unknowns = "keep") {
    $this->unknowns = $unknowns;
  }

  /**
  * Assigns handle to file and puts file in memory for later use
  *
  * @param  string      $handle     handle for a filename
  * @param  string      $filename   name of template file
  *
  */
  function set_file($handle, $filename = "") {
    if (!is_array($handle)) {
      if ($filename == "") {
        $this->halt("set_file: For handle $handle filename is empty.");
        return false;
      }
      $this->file[$handle] = $this->filename($filename);
    } else {
      reset($handle);
      while(list($h, $f) = each($handle)) {
        $this->file[$h] = $this->filename($f);
      }
    }
  }

  /**
  * Extracts the template $handle from $parent
  *
  * @param  string      $parent     ??
  * @param  string      $handle     handle to template to operate on
  * @param  string      $name       ??
  *
  */
  function set_block($parent, $handle, $name = "") {
    if (!$this->loadfile($parent)) {
      $this->halt("subst: unable to load $parent.");
      return false;
    }
    if ($name == "")
      $name = $handle;

    $str = $this->get_var($parent);
    $reg = "/<!--\s+BEGIN $handle\s+-->(.*)\n\s*<!--\s+END $handle\s+-->/sm";
    preg_match_all($reg, $str, $m);
    $str = preg_replace($reg, "{" . "$name}", $str);
    $this->set_var($handle, $m[1][0]);
    $this->set_var($parent, $str);
  }
  
  /**
  * replaces template variable with a value
  *
  * @param  string  $varname    name of a variable that is to be defined
  * @param  string  $value      value of that variable
  *
  */
  function set_var($varname, $value = "") {
    if (!is_array($varname)) {
      if (!empty($varname))
        if ($this->debug) print "scalar: set *$varname* to *$value*<br>\n";
        $this->varkeys[$varname] = "/".$this->varname($varname)."/";
        $this->varvals[$varname] = $value;
    } else {
      reset($varname);
      while(list($k, $v) = each($varname)) {
        if (!empty($k))
          if ($this->debug) print "array: set *$k* to *$v*<br>\n";
          $this->varkeys[$k] = "/".$this->varname($k)."/";
          $this->varvals[$k] = $v;
      }
    }
  }

  /**
  * Substitute variables into template and returns result
  *
  * @param  string      $handle     handle of template where variables are to be substituted.
  * @return string      resulting, fully parsed file
  *
  */
  function subst($handle) {
    if (!$this->loadfile($handle)) {
      $this->halt("subst: unable to load $handle.");
      return false;
    }

    $str = $this->get_var($handle);
    
    foreach ($this->varvals as $k=>$v) {
        $this->varvalsfixed[$k] = preg_replace('/\\\\/', '\\\\\\\\', $v);
    }
    
    $str = @preg_replace($this->varkeys, $this->varvalsfixed, $str);

    return $str;
  }
  
  /**
  * Same as subst but prints results
  *
  * @param  string  $handle     handle of template where variables are to be substituted.
  * @return boolean returns false...no idea why
  *
  */
  function psubst($handle) {
    print $this->subst($handle);
    
    return false;
  }

  /**
  * Parses a tempalte and assigns to target variable.
  *
  * @param      string      $target     handle of variable to generate
  * @param      string      $handle     handle of template to substitute
  * @param      boolean     $append     append to target handle
  * @return     string      returns parsed string
  *
  */
  function parse($target, $handle, $append = false) {
    if (!is_array($handle)) {
      $str = $this->subst($handle);
      if ($append) {
        $this->set_var($target, $this->get_var($target) . $str);
      } else {
        $this->set_var($target, $str);
      }
    } else {
      reset($handle);
      while(list($i, $h) = each($handle)) {
        $str = $this->subst($h);
        $this->set_var($target, $str);
      }
    }
    
    return $str;
  }
  
  /**
  * Same as parse() but this also issues a print
  *
  * @param      string      $target     handle of variable to generate
  * @param      string      $handle     handle of template to substitute
  * @param      boolean     $append     append to target handle
  * @return     boolean     false...not sure why
  *
  */
  function pparse($target, $handle, $append = false) {
    print $this->parse($target, $handle, $append);
    return false;
  }

  
  /**
  * Returns array of all template variables in memory
  *
  * @return     array       All variables in memory
  *
  */
  function get_vars() {
    reset($this->varkeys);
    while(list($k, $v) = each($this->varkeys)) {
      $result[$k] = $this->varvals[$k];
    }
    
    return $result;
  }
  
  /**
  * Returns value for specified template variable
  *
  * @param      string  $varname    name of variable to get value for
  * @return     mixed   value of variable
  *
  */
  function get_var($varname) {
    if (!is_array($varname)) {
      return $this->varvals[$varname];
    } else {
      reset($varname);
      while(list($k, $v) = each($varname)) {
        $result[$k] = $this->varvals[$k];
      }
      
      return $result;
    }
  }
  
  /**
  * Returns all undefined template variables
  *
  * @param      string      $handle     template file to get undefined vars for
  * @return     array       Returns an array of all undefined variables
  *
  */
  function get_undefined($handle) {
    if (!$this->loadfile($handle)) {
      $this->halt("get_undefined: unable to load $handle.");
      return false;
    }
    
    preg_match_all("/\{([^}]+)\}/", $this->get_var($handle), $m);
    $m = $m[1];
    if (!is_array($m))
      return false;

    reset($m);
    while(list($k, $v) = each($m)) {
      if (!isset($this->varkeys[$v]))
        $result[$v] = $v;
    }
    
    if (count($result))
      return $result;
    else
      return false;
  }

  /**
  * This will take a parsed string and handle the undefined variables as
  * told by the unknowns property
  *
  * @param      string      $str    string to finish processing
  * @return     string      Finished string
  *
  */
  function finish($str) {
    switch ($this->unknowns) {
      case "keep":
      break;
      
      case "remove":
        $str = preg_replace('/{[^ \t\r\n}]+}/', "", $str);
      break;

      case "comment":
        $str = preg_replace('/{([^ \t\r\n}]+)}/', "<!-- Template $handle: Variable \\1 undefined -->", $str);
      break;
    }
  
    return $str;
  }

  /**
  * Finishes and prints a given variable
  *
  * @param      string      $varname        Variable to print
  *
  */
  function p($varname) {
    print $this->finish($this->get_var($varname));
  }

  /**
  * Gets a parsed variable
  *
  * @param      string      $varname        Variable to get
  * @return     string      Finished version of variable
  *
  */
  function get($varname) {
    return $this->finish($this->get_var($varname));
  }
    
  /** Verifies a filename is valid
  *
  * @param      string      $filename       Name of file to verify
  * @return     string      Fully quailified file location
  * @access     private
  *
  */
  function filename($filename) {
    if (substr($filename, 0, 1) != "/") {
      $filename = $this->root."/".$filename;
    }
    
    if (!file_exists($filename))
      $this->halt("filename: file $filename does not exist.");

    return $filename;
  }
  
  /**
  * returns proper template variable name
  *
  * @param      string      $varname    variable name to process
  * @return     string      properly formated template variable
  * @access     private
  *
  */
  function varname($varname) {
    return preg_quote("{".$varname."}");
  }

  /**
  * Attempts to load file represented by $handle into memory
  *
  * @param      string      $handle     Handle to file to load
  * @return     boolean     true on success otherwise false
  * @access     private
  *
  */
  function loadfile($handle) {
    if (isset($this->varkeys[$handle]) and !empty($this->varvals[$handle]))
      return true;

    if (!isset($this->file[$handle])) {
      $this->halt("loadfile: $handle is not a valid handle.");
      return false;
    }
    $filename = $this->file[$handle];

    $str = implode("", @file($filename));
    if (empty($str)) {
      $this->halt("loadfile: While loading $handle, $filename does not exist or is empty.");
      return false;
    }

    $this->set_var($handle, $str);
    
    return true;
  }

  /**
  * Processes an error
  *
  * @param      string      $msg        Error message
  * @return     boolean     Always false...no idea why
  *
  */
  function halt($msg) {
    $this->last_error = $msg;
    
    if ($this->halt_on_error != "no")
      $this->haltmsg($msg);
    
    if ($this->halt_on_error == "yes")
      die("<b>Halted.</b>");
    
    return false;
  }
  
  /**
  * Prints a formated error message
  *
  * @param      string      $msg        Error message to print
  *
  */
  function haltmsg($msg) {
    printf("<b>Template Error:</b> %s<br>\n", $msg);
  }
}

?>