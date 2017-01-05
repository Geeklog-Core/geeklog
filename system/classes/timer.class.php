<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
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
 */
class timerobject
{
    /**
     * @var float
     */
    private $_starttime = 0.0;

    /**
     * @var float
     */
    private $_endtime = 0.0;

    /**
     * @var float
     */
    private $_elapsedtime = 0.0;

    /**
     * @var int
     */
    private $_precision = 2;

    /**
     * Set precision on timer results
     * This sets how many significant digits get
     * sent back when elapsedTime is called
     *
     * @param    int $num_dec_places Number of significant digits
     */
    public function setPrecision($num_dec_places)
    {
        $this->_precision = $num_dec_places;
    }

    /**
     * Return the precision
     *
     * @return float
     */
    public function getPrecision()
    {
        return $this->_precision;
    }

    /**
     * Deprecated - use setPrecision instead
     *
     * @param  int $num_dec_places
     * @deprecated since Geeklog 1.6.0
     * @see        setPrecision
     */
    public function setPercision($num_dec_places)
    {
        COM_deprecatedLog(__FUNCTION__, '1.6.0', '3.0.0', 'setPrecision');
        
        $this->setPrecision($num_dec_places);
    }

    /**
     * Starts the timer
     */
    public function startTimer()
    {
        $this->_starttime = microtime(true);
    }

    /**
     * Stops the timer
     *
     * @return   float   elapsed time to degree of precision specified
     */
    public function stopTimer()
    {
        $this->_endtime = microtime(true);
        $this->_setElapsedTime();

        // We are going to assume that when the timer is stopped
        // they will want the elapsed time immediately
        return $this->getElapsedTime();
    }

    /**
     * Restarts the timer
     * Same as startTimer excepts this clears everything out first
     */
    public function restart()
    {
        $this->_endtime = 0.0;
        $this->_elapsedtime = 0.0;

        $this->startTimer();
    }

    /**
     * @param  float $time
     */
    public function setStartTime($time)
    {
        $this->_starttime = $time;
    }

    /**
     * @return float
     */
    public function getStartTime()
    {
        return $this->_starttime;
    }


    /**
     * @param  float $time
     */
    public function setEndTime($time)
    {
        $this->_endtime = $time;
        $this->_setElapsedTime();
    }

    /**
     * @return float
     */
    public function getEndTime()
    {
        return $this->_endtime;
    }

    /**
     * Gets the elapsed time
     * This returns the elapsed time with the proper number of
     * significant digits
     *
     * @return   string   Elapsed time in seconds formatted to degree of precision specified
     */
    public function getElapsedTime()
    {
        return sprintf("%.{$this->_precision}f", $this->_elapsedtime);
    }

    /**
     * Sets the elapsed time
     * once stop timer is called this gets called to calculate
     * the elapsed time for later retrieval
     */
    private function _setElapsedTime()
    {
        $this->_elapsedtime = $this->_endtime - $this->_starttime;
    }
}
