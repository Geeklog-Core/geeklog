<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | device.class.php                                                          |
// |                                                                           |
// | Geeklog class to detect device type of visitor.                           |
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
* This class is used to detect the type of device accessing the Geeklog website.
* It is a wrapper class for http://mobiledetect.net/ 
* https://github.com/serbanghita/Mobile-Detect/.
*
* @author Tom Homer
*
*/

define("DEVICE_PHONE", 'phone');
define("DEVICE_TABLET", 'tablet');
define("DEVICE_COMPUTER", 'computer');
define("DEVICE_MOBILE", 'mobile');
define("DEVICE_ALL", 'all');

class device {

    private $type; // To store device type if already checked before
    
    private $is_mobile; // To store if mobile device (includes phones and tablets) if already checked before

    function __construct() {

        global $_CONF, $_USER;

        // Include and instantiate the class.
        require_once 'mobiledetect/Mobile_Detect.php';
        $detect = new Mobile_Detect;
         
        // Any mobile device (phones or tablets).
        if ( $detect->isMobile() ) {
            $this->is_mobile = true;
            if( $detect->isTablet() ){
                $this->type = DEVICE_TABLET;
            } else {
                $this->type = DEVICE_PHONE;
            }
        } else {
            $this->is_mobile = false;            
            $this->type = DEVICE_COMPUTER;
        }

    }

    /**
    * Is user device a mobile device?
    *
    * @access   public
    * @return   boolean
    *
    */
    public function is_mobile() {

        return $this->is_mobile;
        
    }

    /**
    * Does current device accessing Geeklog equal passed device?
    *
    * @access   public
    * @param    constant    $device Device to compare current device accessing site
    * @return   boolean
    *
    */
    public function compare($device) {
        
        $retval = false;
        if ($device == DEVICE_ALL) {
            $retval = true;
        } elseif ($device == DEVICE_MOBILE) {
            if ($this->type == DEVICE_TABLET OR $this->type == DEVICE_PHONE) {
                $retval = true;
            }
        } else {
            if ($device == $this->type) {
                $retval = true;
            }
        }

        return $retval;
        
    }
    
    /**
    * What type of device is the user using?
    *
    * @access   public
    * @return   constant (DEVICE_PHONE, DEVICE_TABLET, DEVICE_COMPUTER)
    *
    */
    public function type() {

        return $this->type;
        
    }    
}

?>
