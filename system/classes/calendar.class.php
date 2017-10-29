<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | calendar.class.php                                                        |
// |                                                                           |
// | Geeklog calendar library.                                                 |
// +---------------------------------------------------------------------------+
// | Much of this code is from Jim Wright jdlwright AT yahoo DOT com with      |
// | minor customizations.                                                     |
// |                                                                           |
// | Copyright (C) 2000-2009 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs       - tony AT tonybibbs DOT com                     |
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
 * This file contains the two classes used to help support the calendar pages.
 * Please note that our calendar code is in shambles and is hard to understand.
 * Not so much this file as /calendar/index.php and calendar/event.php.
 * Those files along with this class need to be reworked to be easier
 * to maintain and support rich calendaring features
 *
 * @author   Tony Bibbs, tony AT tonybibbs DOT com
 */

/**
 * This class represents the logical structure of a calendar day and is used by
 * the greater calendar class
 *
 */
class CalendarDay
{
    /**
     * @var int
     */
    private $dayNumber = 0;

    /**
     * @var int
     */
    private $year = 0;

    /**
     * @var bool
     */
    private $weekendFlag = false;

    /**
     * @var bool
     */
    private $holidayFlag = false;

    /**
     * @var bool
     */
    private $selectedFlag = false;

    /**
     * CalendarDay class constructor
     */
    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->weekendFlag = false;
        $this->holidayFlag = false;
        $this->selectedFlag = false;
    }

    /**
     * Returns if this day is on a weekend
     *
     * @return   bool true if is on weekend otherwise false
     */
    public function isWeekend()
    {
        return $this->weekendFlag;
    }

    /**
     * Returns if this day is a holiday
     *
     * @return   bool     true if day is a holiday otherwise false
     */
    public function isHoliday()
    {
        return $this->holidayFlag;
    }

    /**
     * Returns if this day is selected
     *
     * @return   bool     true if day is selected otherwise false
     */
    public function isSelected()
    {
        return $this->selectedFlag;
    }

    /**
     * Set the year
     *
     * @param  int $year
     */
    public function setYear($year)
    {
        $this->year = (int) $year;
    }

    /**
     * Set the day number
     *
     * @param  int $dayNumber 1-31
     */
    public function setDayNumber($dayNumber)
    {
        $dayNumber = (int) $dayNumber;

        if (($dayNumber < 1) || ($dayNumber > 31)) {
            throw new \InvalidArgumentException(__METHOD__ . ': day number must be between 1 and 31');
        }

        $this->dayNumber = $dayNumber;
    }

    /**
     * Return the day number
     *
     * @return int
     */
    public function getDayNumber()
    {
        return $this->dayNumber;
    }
}

class Calendar
{
    /**
     * @var bool
     */
    private $rollingMode = false;

    /**
     * @var array
     */
    private $langDays;

    /**
     * @var array
     */
    private $langMonths;

    /**
     * @var string  Currently, 'Mon' and 'Sun' are supported
     */
    private $weekStart;

    /**
     * @var int
     */
    private $defaultYear;

    /**
     * @var array
     */
    private $selectedDays;

    /**
     * @var array
     */
    private $holidays;

    /**
     * @var array
     */
    private $matrix;

    /**
     * Constructor
     *
     * Initializes calendar object
     */
    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->setRollingMode(false);
        $this->setDefaultYear(date('Y'));
        $this->setLanguage();
    }

    /**
     * Set default year
     *
     * @param  int $year
     */
    public function setDefaultYear($year)
    {
        $year = (int) $year;

        if ($year <= 0) {
            $year = date('Y');
        }

        $this->defaultYear = $year;
    }

    /**
     * Return default year
     *
     * @return  int
     */
    public function getDefaultYear()
    {
        return $this->defaultYear;
    }

    /**
     * Set day names
     *
     * @param array $days
     */
    public function setLangDays(array $days)
    {
        $this->langDays = $days;
    }

    /**
     * Return day names
     *
     * @return array
     */
    public function getLangDays()
    {
        return $this->langDays;
    }

    /**
     * Set month names
     *
     * @param array $months
     */
    public function setLangMonths(array $months)
    {
        $this->langMonths = $months;
    }

    /**
     * Return month names
     *
     * @return array
     */
    public function getLangMonths()
    {
        return $this->langMonths;
    }

    /**
     * Set the start of the week
     *
     * @param  string $start
     */
    public function setWeekStart($start)
    {
        if ($start !== 'Mon') {
            $start = 'Sun';
        }

        $this->weekStart = $start;
    }

    /**
     * Return the start of the week
     *
     * @return string
     */
    public function getWeekStart()
    {
        return $this->weekStart;
    }

    /**
     * Returns the day of the week (1-7) for given date
     *
     * @param    int $day   Number of day in month (1-31)
     * @param    int $month Number of the month (1-12)
     * @param    int $year  Four digit year
     * @return   int        Returns integer for day of week 1 = Sunday through 7 = Saturday
     */
    public function getDayOfWeek($day = 1, $month = 1, $year = 0)
    {
        if (empty($year)) {
            $year = $this->getDefaultYear();
        }

        $dateArray = getdate(mktime(0, 0, 0, $month, $day, $year));
        $result = $dateArray['wday'];
        if ($this->getWeekStart() === 'Mon') {
            $result = ($result == 0) ? 6 : $result - 1;
        }

        return $result;
    }

    /**
     * Returns the week of the month (1-5) for a given date
     *
     * @param    int $day   Number of day in month (1-31)
     * @param    int $month Number of the month (1-12)
     * @param    int $year  Four digit year
     * @return   int     Week of the month, 1 - 5
     */
    public function getWeekOfMonth($day = 1, $month = 1, $year = 0)
    {
        if (empty($year)) {
            $year = $this->getDefaultYear();
        }

        $firstDayOfMonth = 1 + $this->getDayOfWeek(1, $month, $year);

        //we know first day of month is in the first week
        $dDiff = $day - $firstDayOfMonth;
        $wDiff = round($dDiff / 7);

        return $wDiff + 1;
    }

    /**
     * Determines if given year is a leap year or not
     *
     * @param    int $year Four digit year
     * @return   bool     returns true if year is a leap year otherwise false
     */
    public function isLeapYear($year = 0)
    {
        if (empty($year)) {
            $year = $this->getDefaultYear();
        }

        if (($year % 4) == 0) {
            if (($year % 100) == 0) {
                if (($year % 400) == 0) {
                    return 1;
                } else {
                    return 0;
                }
            }

            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Returns the number of days in a given month/year
     *
     * If no year is given, the default year is used
     *
     * @param    int $month Month (1-12)
     * @param    int $year  Four digit year
     * @return   int        Returns the number of days in the month
     */
    public function getDaysInMonth($month = 1, $year = 0)
    {
        if (empty($year)) {
            $year = $this->getDefaultYear();
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
     * This aims to help with multilingual support
     *
     * @param    int $day Numeric day of week (1-7)
     * @return   string   Returns the text for the given day of the week
     */
    public function getDayName($day = 1)
    {
        if ($this->getWeekStart() === 'Mon') {
            if ($day == 7) {
                return $this->langDays['sunday'];
            } else {
                $day++;
            }
        }

        switch ($day - 1) {
            case 0:
                return $this->langDays['sunday'];
                break;

            case 1:
                return $this->langDays['monday'];
                break;

            case 2:
                return $this->langDays['tuesday'];
                break;

            case 3:
                return $this->langDays['wednesday'];
                break;

            case 4:
                return $this->langDays['thursday'];
                break;

            case 5:
                return $this->langDays['friday'];
                break;

            case 6:
                return $this->langDays['saturday'];
                break;

            default:
                return 0;
                break;
        }
    }

    /**
     * Returns the name of the given month (can handle different languages)
     *
     * This aims to help with multi-lingual support
     *
     * @param    int $month Month (1-12) to get name of
     * @return   string     returns text for current month name
     */
    public function getMonthName($month = 1)
    {
        $month = $month - 1;
        if (empty($this->langMonths)) {
            $this->setLanguage();
        }

        switch ($month) {
            case 0:
                return $this->langMonths['january'];
                break;

            case 1:
                return $this->langMonths['february'];
                break;

            case 2:
                return $this->langMonths['march'];
                break;

            case 3:
                return $this->langMonths['april'];
                break;

            case 4:
                return $this->langMonths['may'];
                break;

            case 5:
                return $this->langMonths['june'];
                break;

            case 6:
                return $this->langMonths['july'];
                break;

            case 7:
                return $this->langMonths['august'];
                break;
            case 8:
                return $this->langMonths['september'];
                break;

            case 9:
                return $this->langMonths['october'];
                break;

            case 10:
                return $this->langMonths['november'];
                break;

            case 11:
                return $this->langMonths['december'];
                break;

            default:
                return 0;
                break;
        }
    }

    /**
     * Sets the rolling mode status
     *
     * Will put calendar in normal mode or in rolling mode.  Rolling mode
     *
     * @param    bool $flag True of False
     */
    public function setRollingMode($flag)
    {
        $this->rollingMode = (bool) $flag;
    }

    /**
     * Return the rolling mode status
     *
     * @return   bool     returns true if in rolling mode otherwise false
     */
    public function isRollingMode()
    {
        return $this->rollingMode;
    }

    /**
     * Sets the language for days of the week and months of year
     *
     * This function defaults to English.
     * Day array format is _lang_days['<daynameinenglish>'] = '<translation>'
     * Month array format is _lang_months['<monthnameinenglish'] = '<translation>'
     *
     * @param  array  $langDays   Array of strings holding day language
     * @param  array  $langMonths Array of string holding month language
     * @param  string $weekStart
     */
    public function setLanguage(array $langDays = array(), array $langMonths = array(), $weekStart = 'Sun')
    {
        if (empty($langDays)) {
            $langDays = array(
                'sunday'    => 'Sunday',
                'monday'    => 'Monday',
                'tuesday'   => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday'  => 'Thursday',
                'friday'    => 'Friday',
                'saturday'  => 'Saturday',
            );
        }
        $this->setLangDays($langDays);

        if (empty($langMonths)) {
            $langMonths = array(
                'january'   => 'January',
                'february'  => 'February',
                'march'     => 'March',
                'april'     => 'April',
                'may'       => 'May',
                'june'      => 'June',
                'july'      => 'July',
                'august'    => 'August',
                'september' => 'September',
                'october'   => 'October',
                'november'  => 'November',
                'december'  => 'December',
            );
        }
        $this->setLangMonths($langMonths);

        if ($weekStart !== 'Mon') {
            $weekStart = 'Sun';
        }

        $this->setWeekStart($weekStart);
    }

    /**
     * Builds logical model of the month in memory
     *
     * @param    int    $month        Month to build matrix for
     * @param    int    $year         Year to build matrix for
     */
    public function setCalendarMatrix($month, $year)
    {
        $firstDay = 1 + $this->getDayOfWeek(1, $month, $year);
        $nextDay = 1;
        $week = array();

        // There are as many as 6 weeks in a calendar grid (I call these
        // absolute weeks hence the variable name aw.  Loop through and
        // populate data
        for ($aw = 1; $aw <= 6; $aw++) {
            for ($wd = 1; $wd <= 7; $wd++) {
                if ($aw == 1 && $wd < $firstDay) {
                    $week[$aw][$wd] = '';
                } else {
                    $currentDay = new CalendarDay();
                    $currentDay->setYear($year);
                    $currentDay->setDayNumber($nextDay);
                    $week[$aw][$wd] = $currentDay;

                    // Bail if we just printed last day
                    if ($nextDay < $this->getDaysInMonth($month, $year)) {
                        $nextDay++;
                    } else {
                        $aw++;
                        while ($aw <= 6) {
                            $week[$aw] = '';
                            $aw++;
                        }
                        $aw = 7;
                    }
                }
            }
        }

        $this->matrix = $week;
    }

    /**
     * Gets data for a given day
     *
     * @param    int $week   week of day to get data for
     * @param    int $dayNum Number of day to get data for
     * @return   CalendarDay Returns calendarDay object
     */
    public function getDayData($week, $dayNum)
    {
        if (isset ($this->matrix[$week][$dayNum])) {
            return $this->matrix[$week][$dayNum];
        } else {
            return null;
        }
    }
}
