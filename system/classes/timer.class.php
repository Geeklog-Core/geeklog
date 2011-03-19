<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.8                                                               |
// +---------------------------------------------------------------------------+
// | timer.class.php                                                           |
// |                                                                           |
// | Geeklog timer class.  Use this to do performance testing.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2011 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony AT tonybibbs DOT com                            |
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

/* EXAMPLE  USAGE

    // Instantiate new timer object
    $mytimer = new timerobject();

    // Set precision of the results to 4 significan't digits
    // NOTE: this call is optional, code defaults to 2 
    $mytimer->setPrecision(4);

    // Start the timer
    $mytimer->startTimer();

    // Stop timer and print elapsed time
    echo $mytimer->stopTimer();

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
    var $_precision = 2;

    // PUBLIC METHODS

    /**
    * Constructor
    *
    * This initializes the timerobject and sets the default
    * precision of results to two decimal places
    *
    */
    function timerobject()
    {
    }

    /**
    * Set precision on timer results
    *
    * This sets how many significant digits get
    * sent back when elapsedTime is called
    *
    * @param    int     $num_dec_places     Number of significant digits
    *
    */
    function setPrecision($num_dec_places)
    {
        $this->_precision = $num_dec_places;
    }

    /**
    * Deprecated - use setPrecision instead
    *
    * @deprecated since Geeklog 1.6.0
    * @see setPrecision
    */
    function setPercision($num_dec_places)
    {
        return $this->setPrecision($num_dec_places);
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
    * @return   float   elapsed time to degree of precision specified
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
    * Same as startTimer excepts this clears everything out first
    *
    */
    function restart()
    {
        $this->_endtime = '';
        $this->_elapsedtime = '';
        
        $this->startTimer();      
    }

    /**
    * Gets the elapsed time
    *
    * This returns the elapsed time with the proper number of 
    * significant digits
    *
    * @return   float   Elasped time in seconds formatted to degree of precision specified
    *
    */
    function getElapsedTime()
    {
        return sprintf("%.{$this->_precision}f", $this->_elapsedtime);
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
