<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | timer.class.php                                                           |
// | Geeklog timer class.  Use this to do performance testing.                 |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony@tonybibbs.com                                   |
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
// $Id

class timerobject {

    // PRIVATE PROPERTIES

    var $_starttime;
    var $_endtime;
    var $_elapsedtime;
    var $_percision;

    // PUBLIC METHODS

    /**
    * Constructor
    *
    * This initializes the timerobject and sets the default
    * percision of results to two decimal places
    *
    */
    function timerobject()
    {
        $this->_starttime = '';
        $this->_endtime = '';
        $this->_elapsedtime = '';
        $this->setPercision(2);
    }

    /**
    * Set percision on timer results
    *
    * This sets how many significant digits get
    * sent back when elapsedTime is called
    *
    * @num_dec_places       int     Number of significant digits
    *
    */
    function setPercision($num_dec_places)
    {
        $this->_percision = $num_dec_places;
    }

    /**
    * Starts the timer
    *
    */
    function startTimer()
    {
        $mtime = microtime();
        $mtime = explode(' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $this->_starttime = $mtime;
    }

    /**
    * Stops the timer
    *
    */
    function stopTimer()
    {
        $mtime = microtime();
        $mtime = explode(' ',$mtime);
        $mtime = $mtime[1] + $mtime[0];
        $this->_endtime = $mtime;
        $this->_setElapsedTime();
    }

    /** 
    * Restarts the timer
    *
    * Same as starTimer excepts this clears everything out first
    *
    */
    function restart()
    {
        $this->_endtime = '';
        $this->_elapsedtime = '';
        
        $this->starTimer();      
    }

    /**
    * Gets the elapsed time
    *
    * This returns the elapsed time with the proper number of 
    * significant digits
    *
    */
    function getElapsedTime()
    {
        return sprintf("%.{$this->_percision}f", $this->_elapsedtime);
    }

    // PRIVATE METHODS

    /**
    * Sets the elapsed time
    *
    * once stop timer is called this gets called to calculate
    * the elapsed time for later retrieval
    *
    */
    function _setElapsedTime()
    {
        $this->_elapsedtime = $this->_endtime - $this->_starttime;
    }

}

?>
