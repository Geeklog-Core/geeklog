<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | timer.class.php                                                           |
// | Geeklog timer class.  Use this to do performance testing.                 |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2002 by the following authors:                         |
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
// $Id: timer.class.php,v 1.6 2002/05/08 18:32:25 tony_bibbs Exp $

/* EXAMPLE  USAGE

    // Instantiate new timer object
    $mytimer = new timerobject();

    // Set percision of the results to 4 significan't digits
    // NOTE: this call is optional, code defaults to 2 
    $mytimer->setPercision(4);

    // Start the timer
    $mytimer->startTimer();

    // Stop timer and print elapsed time
    echo $mytimer->endTimer();

*/

/**
* This class is used to time program execution. This is particularly handy for
* performance trouble shooting.
*
* @author Tony Bibbs
*
*/
class timerobject {

    // PRIVATE PROPERTIES

    /**
    * @access private
    */
    var $_starttime = '';
    /**
    * @access private
    */
    var $_endtime = '';
    /**
    * @access private
    */
    var $_elapsedtime = '';
    /**
    * @access private
    */
    var $_percision = 2;

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
    }

    /**
    * Set percision on timer results
    *
    * This sets how many significant digits get
    * sent back when elapsedTime is called
    *
    * @param    int     $num_dec_places     Number of significant digits
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
    * @return   float   elapsed time to degree of percision specified
    *
    */
    function stopTimer()
    {
        $mtime = microtime();
        $mtime = explode(' ',$mtime);
        $mtime = $mtime[1] + $mtime[0];
        $this->_endtime = $mtime;
        $this->_setElapsedTime();

        // We are going to assume that when the timer is stopped
        // they will want the elapsed time immediately
        return $this->getElapsedTime();
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
    * @return   float   Elasped time in seconds formatted to degree of percision specified
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
    * @access private
    */
    function _setElapsedTime()
    {
        $this->_elapsedtime = $this->_endtime - $this->_starttime;
    }

}

?>