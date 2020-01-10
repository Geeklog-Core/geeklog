<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | device.class.php                                                          |
// |                                                                           |
// | Geeklog class to detect device type of visitor.                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2020 by the following authors:                         |
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
 */
class Device
{
    // Constants for device types
    const PHONE = 'phone';
    const TABLET = 'tablet';
    const COMPUTER = 'computer';
    const MOBILE = 'mobile';
    const ALL = 'all';

    /**
     * device type if already checked before
     *
     * @var string one of self::PHONE, self::TABLET, or self::COMPUTER
     */
    private $type;

    /**
     * Store if mobile device (includes phones and tablets) if already checked before
     *
     * @var bool
     */
    private $is_mobile;

    /**
     * Device constructor.
     */
    public function __construct()
    {
        // Include and instantiate the class.
        $detect = new Mobile_Detect;

        // Any mobile device (phones or tablets).
        if ($detect->isMobile()) {
            $this->is_mobile = true;

            if ($detect->isTablet()) {
                $this->type = self::TABLET;
            } else {
                $this->type = self::PHONE;
            }
        } else {
            $this->is_mobile = false;
            $this->type = self::COMPUTER;
        }
    }

    /**
     * Is user device a mobile device?
     *
     * @return   boolean
     */
    public function is_mobile()
    {
        return $this->is_mobile;
    }

    /**
     * Does current device accessing Geeklog equal passed device?
     *
     * @param    string $device Device to compare current device accessing site
     * @return   boolean
     */
    public function compare($device)
    {
        $retval = false;

        if ($device == self::ALL) {
            $retval = true;
        } elseif ($device == self::MOBILE) {
            if ($this->type == self::TABLET || $this->type == self::PHONE) {
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
     * @return   string (self::PHONE, self::TABLET, self::COMPUTER)
     */
    public function type()
    {
        return $this->type;
    }
}
