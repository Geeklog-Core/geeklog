<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | calendar.class.php                                                        |
// | Geeklog calendar library.                                                 |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Much of this code is from Jim Wright jdlwright@yahoo.com with minor       |
// | customizations.                                                           |
// |                                                                           |
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony@tonybibbs.com                            |
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
// $Id: calendar.class.php,v 1.1 2001/10/29 23:30:05 tony_bibbs Exp $

class CalendarDay {
    var $daynumber;
    var $year;

    var $weekendflag; 
    var $holidayflag;
    var $selectedflag;

    function CalendarDay()
    {
        $this->weekendflag = false; 
        $this->holidayflag = false;
        $this->selectedflag = false;
    }

    function isWeekend()
    {
        return $this->weekendflag; 
    }
   
    function isHoliday()
    {
        return $this->holdiayflag;
    }

    function isSelected()
    {
        return $this->selectedflag;
    }

}

class Calendar {

    // PRIVATE PROPERTIES

    var $_rollingmode;
    var $_lang_days;
    var $_lang_months;
    var $_default_year;
    var $_selected_days;
    var $_holidays;
    var $_matrix;
     
    // PRIVATE METHODS

    /**
    * Returns if calendar is in rolling mode
    *
    */
    function _isRollingMode()
    {
        return $this->_rollingmode;
    }

    /**
    * Constructor
    *
    * Initializes calendar object
    *
    */
    function Calender()
    {
        $this->setRollingMode(false);
        $dateArray = getdate(time());
        $this->_default_year = $dateArray['year'];
	$this->setLanguage();
    }

    /**
    * Returns the day of the week (1-7) for given date
    *
    * @day      int         Number of day in month (1-31)
    * @month    int         Number of the month (1-12)
    * @year     int         Four digit year
    *
    */
    function getDayOfWeek($day = 1, $month = 1, $year = '')
    {
	if (empty($year)) {
            $year = $this->_default_year;
        }

        $dateArray = getdate(mktime(0,0,0,$month,$day,$year));
        return $dateArray['wday'];
    }

    /**
    * Returns the week of the month (1-5) for a given date
    *
    * @day      int         Number of day in month (1-31)
    * @month    int         Number of the month (1-12)
    * @year     int         Four digit year
    *
    */
    function getWeekOfMonth($day = 1, $month = 1, $year = '')
    {
        if (empty($year)) {
            $year = $this->_default_year;
        }

        $firstDayOfMonth = 1 + $this->getDayOfWeek(1,$month,$year);

        //we know first day of month is in the first week
        $dDiff = $day - $firstDayOfMonth;
        $wDiff = round($dDiff/7);
        return $wDiff + 1;
    }

    /**
    * Determines if given year is a leap year or not
    *
    * @year     int     Four digit year
    *
    */
    function isLeapYear($year = '')
    {
        if (empty($year)) {
            $year = $this->_default_year;
        }

        if (round(($year - 2000)/4) == (($year - 2000)/4)){
            return 1;
        } else {
            return 0;
        }
    }

    /** 
    * Returns the number of days in a given month/year
    *
    * @month        int         Month (1-12)
    * @year         int         Four digit year
    *
    */
    function getDaysInMonth($month = 1, $year = '')
    {
        if (empty($year)) {
            $year = $this->_default_year;
        }
        switch ($month - 1) {
        case 0:
            return 31;
            break;
        case 1:
            if ($this->isLeapYear($year)) {
                return 29;
            } else {
                return 28;
            }
            break;
        case 2:
            return 31;
            break;
        case 3:
            return 30;
            break;
        case 4:
            return 31;
            break;
        case 5:
            return 30;
            break;
        case 6:
            return 31;
            break;
        case 7:
            return 31;
            break;
        case 8:
            return 30;
            break;
        case 9:
            return 31;
            break;
        case 10:
            return 30;
            break;
        case 11:
            return 31;
            break;
        default:
            return 0;
            break;

        }
    }

    /**
    * Returns the name of the day of the week
    *
    * @day          int         Numeric day of week (1-7)
    *
    */
    function getDayName($day = 1) {
        switch ($day - 1) {
        case 0:
            return $this->_lang_days['sunday'];
            break;
        case 1:
            return $this->_lang_days['monday'];
            break;
        case 2:
            return $this->_lang_days['tuesday'];
            break;
        case 3:
            return $this->_lang_days['wednesday'];
            break;
        case 4:
            return $this->_lang_days['thursday'];
            break;
        case 5:
            return $this->_lang_days['friday'];
            break;
        case 6:
            return $this->_lang_days['saturday'];
            break;
        default:
            return 0;
            break;
        }
    } 

    /** 
    * Returns the name of the given month (can handle different languages)
    *
    * @month        int     Month (1-12) to get name of 
    *
    */
    function getMonthName($month = 1)
    {
	$month = $month - 1;
	if (empty($this->_lang->months)) $this->setLanguage();

	COM_errorLog("MONTH: $month");
	COM_errorLog("lang: " . $this->_lang_months['september']);

        switch ($month) {
        case 0:
            return $this->_lang_months['january'];
            break;
        case 1:
            return $this->_lang_months['february'];
            break;
        case 2:
            return $this->_lang_months['march'];
            break;
        case 3:
            return $this->_lang_months['april'];
            break;
        case 4:
            return $this->_lang_months['may'];
            break;
        case 5:
            return $this->_lang_months['june'];
            break;
        case 6:
            return $this->_lang_months['july'];
            break;
        case 7:
            return $this->_lang_months['august'];
            break;
        case 8:
            return $this->_lang_months['september'];
            break;
        case 9:
            return $this->_lang_months['october'];
            break;
        case 10:
            return $this->_lang_months['november'];
            break;
        case 11:
            return $this->_lang_months['december'];
            break;
        default:
            return 0;
            break;
        }
    }

    /**
    * Sets the rolling mode status
    *
    * Will put calendar in normal mode or in rolling mode.  Rolling
    * mode
    * 
    * @flag     boolean     True of False
    *
    */
    function setRollingMode($flag)
    {
        $this->_rollingmode = $flag;
    }

    /**
    * Sets the language for days of the week and months of year
    *
    * This function defaults to English.  
    * Day array format is _lang_days['<daynameinenglish>'] = '<translation>'
    * Mondy array format is _lang_months['<monthnameinenglish'] = '<translation>'
    *
    * @lang_days        array       Array of strings holding day language
    * @lang_months      array       Array of string holding month language
    *
    */
    function setLanguage($lang_days='', $lang_months='') 
    {
        if (empty($lang_days)) {
            $this->_lang_days['sunday'] = 'Sunday';
            $this->_lang_days['monday'] = 'Monday';
            $this->_lang_days['tuesday'] = 'Tuesday';
            $this->_lang_days['wednesday'] = 'Wednesday';
            $this->_lang_days['thursday'] = 'Thursday';
            $this->_lang_days['friday'] = 'Friday';
            $this->_lang_days['saturday'] = 'Saturday';
        } else {
            $this->_lang_days = $lang_days;
        }

        if (empty($lang_months)) {
            $this->_lang_months['january'] = 'January';
            $this->_lang_months['february'] = 'February';
            $this->_lang_months['march'] = 'March';
            $this->_lang_months['april'] = 'April';
            $this->_lang_months['may'] = 'May';
            $this->_lang_months['june'] = 'June';
            $this->_lang_months['july'] = 'July';
            $this->_lang_months['august'] = 'August';
            $this->_lang_months['september'] = 'September';
            $this->_lang_months['october'] = 'October';
            $this->_lang_months['november'] = 'November';
            $this->_lang_months['december'] = 'December';
        } else {
            $this->_lang_months = $lang_months;
        }
    }
    
    function setCalendarMatrix($month, $year, $selecteddays='')
    {
        $firstday = 1 + $this->getDayOfWeek(1,$month,$year);
        $nextday = 1;
        $lastday = $this->getDaysInMonth();

        $monthname = $this->getMonthName($month);

        // There are as many as 6 weeks in a calendar grid (I call these
        // absolute weeks hence the variable name aw.  Loop through and 
        // populate data
        for ($aw = 1; $aw <= 6; $aw++) {
            for ($wd = 1;  $wd <= 7; $wd++) {
                if ($aw == 1 && $wd < $firstday) {
                    $week[$aw][$wd] = '';
                } else {
                    $cur_day = new CalendarDay();
                    $cur_day->year = $year;
                    $cur_day->daynumber = $nextday; 
                    $week[$aw][$wd] = $cur_day;

                    // Bail if we just printed last day
                    if ($nextday < $this->getDaysInMonth($month,$year)) {
                        $nextday++;
                    } else {
                        $aw++;
                        while ($aw <= 6) {
                            $week[$aw] = '';
                            $aw++;
                        }
                        $aw = 7;
                    }
                }
       /* 
                // Bail if we just printed last day
                if ($nextday < $this->getDaysInMonth($month,$year)) {
                    $nextday++;
                } else {
                    $aw++;
                    while ($aw <= 6) {
                        $week[$aw] = '';
                        $aw++;
                    }
                    $aw = 7;
                }
	*/
            }
        }

        $this->_matrix = $week;

    }   

    function getDayData($week,$daynum) {
        return $this->_matrix[$week][$daynum];
    }

}

?>
