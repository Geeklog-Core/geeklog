<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.5                                                               |
// +---------------------------------------------------------------------------+
// | sanitize.class.php                                                        |
// |                                                                           |
// | Geeklog data filtering or sanitizing class library.                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
// |          Dirk Haun        - dirk AT haun-online DOT de                    |
// |          Blaine Lang      - blaine AT portalparts DOT com                 |
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

/* Class derived from original procedural code in Geeklog 1.3.x lib-common.php
*  Jan 2005: Blaine Lang
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'sanitize.class.php') !== false) {
    die('This file can not be used on its own.');
}

/**
 * Include the base kses class if not already loaded
 */
require_once $_CONF['path_system'] . 'classes/kses.class.php';

class sanitize extends kses {

    var $string = '';
    var $_parmissions = '';
    var $_isnumeric = false;
    var $_logging = false;
    var $_setglobal = false;
    var $_censordata = false;

    /* Filter or sanitize single parm */
    function filterparm ($parm) {

        $p = $this->Parse( $parm );

        if( $this->_isnumeric )
        {
            // Note: PHP's is_numeric() accepts values like 4e4 as numeric
            if( !is_numeric( $p ) || ( preg_match( '/^([0-9]+)$/', $p ) == 0 ))
            {
               $p = 0;
            }
        }
        else
        {
            $p = preg_replace( '/\/\*.*/', '', $p );
            $pa = explode( "'", $p );
            $pa = explode( '"', $pa[0] );
            $pa = explode( '`', $pa[0] );
            $pa = explode( ';', $pa[0] );
            $pa = explode( '\\', $pa[0] );
            $p = $pa[0];
        }

        if( $this->logging )
        {
            if( strcmp( $p, $parm ) != 0 )
            {
                COM_errorLog( "Filter applied: >> $parm << filtered to $p [IP {$_SERVER['REMOTE_ADDR']}]", 1);
            }
        }

        return $p;

    }

    /* Prepare data for SQL insert and apply filtering 
    *  Supports passing a single parm or array of parms
    */
    function prepareForDB($data) {
        if (is_array($data)) {
            # loop through array and apply the filters
            foreach($data as $var)  {
                $return_data[]  = addslashes($this->filterHTML($var));
            }
            return $return_data;
        }
        else
        {
            $data = $this->filterHTML($data);
            $data = addslashes($data);
            return $data;
        }
    }

    function filterHTML ($message) {
        global $_CONF;

        // strip_tags() gets confused by HTML comments ...
        $message = preg_replace( '/<!--.+?-->/', '', $message );

        if( isset( $_CONF['allowed_protocols'] ) && is_array( $_CONF['allowed_protocols'] ) && ( sizeof( $_CONF['allowed_protocols'] ) > 0 ))
        {
            $this->Protocols( $_CONF['allowed_protocols'] );
        }
        else
        {
            $this->Protocols( array( 'http:', 'https:', 'ftp:' ));
        }

        if( empty( $this->permissions) || !SEC_hasRights( $this->permissions ) ||
                empty( $_CONF['admin_html'] ))
        {
            $html = $_CONF['user_html'];
        }
        else
        {
            $html = array_merge_recursive( $_CONF['user_html'],
                                           $_CONF['admin_html'] );
        }

        foreach( $html as $tag => $attr )
        {
            $this->AddHTML( $tag, $attr );
        }

        $message = $this->Parse( $message );
        $message = $this->formatCode($message);
        $message = $this->censor($message);
        return $message;

    }


    /* Apply filtering to a single parm or array of parms
    *  Parms may be in either $_POST or $_GET input parms array
    *  If type (GET or POST) is not set then POST is checked first
    *  Optionally Parms can be made global
    */
    function sanitizeParms($vars,$type='')  {
      $return_data = array();

      #setup common reference to SuperGlobals depending which array is needed
      if ($type == "GET" OR $type == "POST") {
        if ($type =="GET") { $SG_Array =& $_GET; }
        if ($type =="POST") { $SG_Array =& $_POST; }

        # loop through SuperGlobal data array and grab out data for allowed fields if found
        foreach($vars as $key)  {
          if (array_key_exists($key,$SG_Array)) { $return_data[$key]=$SG_Array[$key]; }
        }

      }
      else
      {
        foreach ($vars as $key) {
          if (array_key_exists($key, $_POST)) { 
            $return_data[$key] = $_POST[$key];
          }
          elseif (array_key_exists($key, $_GET))
          { 
            $return_data[$key] = $_GET[$key];
          }
        }
      }

        # loop through $vars array and apply the filter
        foreach($vars as $value)  {
          $return_data[$value]  = $this->filterparm($return_data[$value]);
        }

      // Optionally set $GLOBALS or return the array
      if ($this->_setglobal) {
          # loop through final data and define all the variables using the $GLOBALS array
          foreach ($return_data as $key=>$value)  {
            $GLOBALS[$key]=$value;
          }
      }
      else
      {
         return $return_data;
      }

    }


    function formatCode($message)  {

        // Get rid of any newline characters
        $message = preg_replace( "/\n/", '', $message );

        // Replace any $ with &#36; (HTML equiv)
        $message = str_replace( '$', '&#36;', $message );

        // handle [code] ... [/code]
        do
        {
            $start_pos = MBYTE_substr( MBYTE_strtolower( $message ), '[code]' );
            if( $start_pos !== false )
            {
                $end_pos = MBYTE_substr( MBYTE_strtolower( $message ), '[/code]' );
                if( $end_pos !== false )
                {
                    $encoded = $this->_handleCode( MBYTE_substr( $message, $start_pos + 6,
                            $end_pos - ( $start_pos + 6 )));
                    $encoded = '<pre><code>' . $encoded . '</code></pre>';
                    $message = MBYTE_substr( $message, 0, $start_pos ) . $encoded
                         . MBYTE_substr( $message, $end_pos + 7 );
                }
                else // missing [/code]
                {
                    // Treat the rest of the text as code (so as not to lose any
                    // special characters). However, the calling entity should
                    // better be checking for missing [/code] before calling this
                    // function ...
                    $encoded = $this->_handleCode( MBYTE_substr( $message, $start_pos + 6 ));
                    $encoded = '<pre><code>' . $encoded . '</code></pre>';
                    $message = MBYTE_substr( $message, 0, $start_pos ) . $encoded;
                }
            }
        }
        while( $start_pos !== false );

        return $message;

    }

    /**
    * Handles the part within a [code] ... [/code] section, i.e. escapes all
    * special characters.
    *
    * @param   string  $str  the code section to encode
    * @return  string  $str with the special characters encoded
    *
    */
    function _handleCode( $str )
    {
        $search  = array( '&',     '\\',    '<',    '>',    '[',     ']'     );
        $replace = array( '&amp;', '&#92;', '&lt;', '&gt;', '&#91;', '&#93;' );

        $str = str_replace( $search, $replace, $str );

        return( $str );
    }


    /**
    * This censors inappropriate content
    *
    * This will replace 'bad words' with something more appropriate
    *
    * @param        string      $message        String to check
    * @return   string  Edited $Message
    *
    */

    function censor ($message)
    {
        global $_CONF;

        $editedMessage = $message;

        if( $this->_censordata )
        {
            if( is_array( $_CONF['censorlist'] ))
            {
                $replacement = $_CONF['censorreplace'];

                switch( $_CONF['censormode'])
                {
                    case 1: # Exact match
                        $regExPrefix = '(\s*)';
                        $regExSuffix = '(\W*)';
                        break;

                    case 2: # Word beginning
                        $regExPrefix = '(\s*)';
                        $regExSuffix = '(\w*)';
                        break;

                    case 3: # Word fragment
                        $regExPrefix   = '(\w*)';
                        $regExSuffix   = '(\w*)';
                        break;
                }

                for( $i = 0; $i < count( $_CONF['censorlist']); $i++ )
                {
                    $editedMessage = MBYTE_eregi_replace( $regExPrefix . $_CONF['censorlist'][$i] . $regExSuffix, "\\1$replacement\\2", $editedMessage );
                }
            }
        }

        return $editedMessage;
    }


    function setPermissions($permissions) {
        $this->permissions = $permissions;
    }

    function setLogging($state=false) {
        $this->logging = $state;
    }

}

?>
