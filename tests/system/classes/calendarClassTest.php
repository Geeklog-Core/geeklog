<?php

use \PHPUnit\Framework\TestCase;

/**
 * Simple tests for calendarClassTest
 */
class calendarClass extends TestCase
{
    /**
     * @var Calendar
     */
    private $c;

    /**
     * @var array
     */
    private $langDays;

    /**
     * @var array
     */
    private $langMonths;

    protected function setUp()
    {
        TimeZoneConfig::setSystemTimeZone();
        $this->c = new Calendar;
    }

    public function test_isRollingModeIsFalse()
    {
        $this->assertFalse($this->c->isRollingMode());
    }

    public function testCalendarConstructor()
    {
        $this->c->setRollingMode(true);
        $this->c->setDefaultYear(2008);
        $this->c->setLanguage();
        $testDateArray = getdate(time());
        $this->c->reset();
        $this->assertFalse($this->c->isRollingMode());
        $this->assertEquals($testDateArray['year'], $this->c->getDefaultYear());
        $langMonths = $this->c->getLangMonths();
        $this->assertEquals('January', $langMonths['january']);
    }

    public function testGetDayOfWeekEqualsCorrectNum()
    {
        $this->c->setDefaultYear(2009);
        $this->assertEquals(2, $this->c->getDayOfWeek(26, 5),
            'Error asserting when using default year.');
        $this->assertEquals(2, $this->c->getDayOfWeek(26, 5, 2009),
            'Error asserting when using specified year.');
    }

    public function testGetWeekOfMonthEqualsCorrectNum()
    {
        $this->c->setDefaultYear(2009);
        $this->assertEquals(4, $this->c->getWeekOfMonth(26, 5),
            'Error asserting when using default year.');
        $this->assertEquals(4, $this->c->getWeekOfMonth(26, 5, 2009),
            'Error asserting when using specified year.');
    }

    public function testIsLeapYear()
    {
        $this->assertEquals(0, $this->c->isLeapYear(1900),
            '1900 is NOT a leap year');
        $this->assertEquals(1, $this->c->isLeapYear(2000),
            '2000 is a leap year');
        $this->assertEquals(0, $this->c->isLeapYear(2001),
            '2001 is not a leap year');
        $this->assertEquals(1, $this->c->isLeapYear(2004),
            '2004 is a leap year');
        $this->assertEquals(0, $this->c->isLeapYear(2100),
            '2100 is NOT a leap year');
    }

    public function testGetDaysInMonthEqualsCorrectTotal()
    {
        $testDays = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        foreach ($testDays as $k => $v) {
            $this->assertEquals($v, $this->c->getDaysInMonth($k + 1, 2009),
                'Error asserting that the ' . ($k + 1) . ' month of 2009 had ' . $v . ' days.');
        }
        $this->assertEquals(29, $this->c->getDaysInMonth(2, 2008),
            'Error asserting that February 2008 had 29 days.');
        $this->assertEquals(31, $this->c->getDaysInMonth(1),
            'Error asserting that January of (default year) had 31 days.');
    }

    public function testGetDayNameEqualsEnglishDefaultOnWkStrtSunday()
    {
        $this->c->setLangDays(array(
            'sunday'    => 'Domingo',
            'monday'    => 'Lunes',
            'tuesday'   => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday'  => 'Jueves',
            'friday'    => 'Viernes',
            'saturday'  => 'Sábado',
        ));
        $i = 1;

        foreach ($this->c->getLangDays() as $k => $v) {
            $this->assertEquals($v, $this->c->getDayName($i),
                'Error asserting that day ' . $i . ' of week is ' . $v . '.');
            $i++;
        }
        $this->assertEquals('Domingo', $this->c->getDayName(),
            'Error asserting default value is ' . $k . '.');
    }

    public function testGetDayNameEqualsEnglishDefaultOnWkStartMon()
    {
        $this->c->setWeekStart('Mon');
        $this->c->setLangDays(array(
            'monday'    => 'Lunes',
            'tuesday'   => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday'  => 'Jueves',
            'friday'    => 'Viernes',
            'saturday'  => 'Sábado',
            'sunday'    => 'Domingo',
        ));
        $i = 1;

        foreach ($this->c->getLangDays() as $k => $v) {
            $this->assertEquals($v, $this->c->getDayName($i),
                'Error asserting that day ' . $i . ' of week is ' . $v . '.');
            $i++;
        }
        $this->assertEquals('Lunes', $this->c->getDayName(),
            'Error asserting default value is ' . $k . '.');
    }

    public function testGetMonthNameTranslates()
    {
        $this->c->setLangMonths(array(
            'january'   => 'Enero',
            'february'  => 'Febrero',
            'march'     => 'Marzo',
            'april'     => 'Abril',
            'may'       => 'Mayo',
            'june'      => 'Junio',
            'july'      => 'Julio',
            'august'    => 'Agosto',
            'september' => 'Septiembre',
            'october'   => 'Octubre',
            'november'  => 'Noviembre',
            'december'  => 'Diciembre',
        ));
        $i = 1;

        foreach ($this->c->getLangMonths() as $k => $v) {
            $this->assertEquals($v, $this->c->getMonthName($i));
            $i++;
        }

        $this->assertEquals('Enero', $this->c->getMonthName());
    }

    public function testGetMonthNameDefaultsEnglish()
    {
        $i = 1;

        foreach ($this->c->getLangMonths() as $k => $v) {
            $this->assertEquals($v, $this->c->getMonthName($i));
            $i++;
        }

        $this->assertEquals('January', $this->c->getMonthName());
    }

    public function testSetRollingModeToTrue()
    {
        $this->c->setRollingMode(false);
        $this->c->setRollingMode(true);
        $this->assertEquals(true, $this->c->isRollingMode());
    }

    public function testSetLanguageTranslates()
    {
        $this->langDays = array(
            'sunday'    => 'Domingo',
            'monday'    => 'Lunes',
            'tuesday'   => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday'  => 'Jueves',
            'friday'    => 'Viernes',
            'saturday'  => 'Sábado',
        );
        $this->langMonths = array(
            'january'   => 'Enero',
            'february'  => 'Febrero',
            'march'     => 'Marzo',
            'april'     => 'Abril',
            'may'       => 'Mayo',
            'june'      => 'Junio',
            'july'      => 'Julio',
            'august'    => 'Agosto',
            'september' => 'Septiembre',
            'october'   => 'Octubre',
            'november'  => 'Noviembre',
            'december'  => 'Diciembre',
        );
        $this->c->setLanguage($this->langDays, $this->langMonths);
        $langDays = $this->c->getLangDays();

        foreach ($this->langDays as $k => $v) {
            $this->assertEquals($this->langDays[$k], $langDays[$k],
                'Error translating _lang_days[' . $k . '] to Spanish.');
        }

        $langMonths = $this->c->getLangMonths();

        foreach ($this->langMonths as $k => $v) {
            $this->assertEquals($this->langMonths[$k], $langMonths[$k],
                'Error translating _lang_months[' . $k . '] to Spanish.');
        }
    }

    public function testSetLanguageDefaults()
    {
        $this->langDays = array(
            'sunday'    => 'Sunday',
            'monday'    => 'Monday',
            'tuesday'   => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday'  => 'Thursday',
            'friday'    => 'Friday',
            'saturday'  => 'Saturday',
        );
        $this->langMonths = array(
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
        $this->c->setLanguage();
        $langDays = $this->c->getLangDays();

        foreach ($this->langDays as $k => $v) {
            $this->assertEquals($v, $langDays[$k],
                'Error translating _lang_days[' . $k . '] to default.');
        }

        $langMonths = $this->c->getLangMonths();

        foreach ($this->langMonths as $k => $v) {
            $this->assertEquals($v, $langMonths[$k],
                'Error translating _lang_months[' . $k . '] to default.');
        }
    }

    public function testSetCalendarMatrixWkStartSunDay1()
    {
        $currentDay = new CalendarDay();
        $currentDay->setYear(2009);
        $currentDay->setDayNumber(1);
        $week = array();
        $week[0][0] = $currentDay;
        $this->c->setCalendarMatrix(5, 2009);

        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->getDayData(1, 6),
                'Error setting May 1, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartSunDay17()
    {
        $currentDay = new CalendarDay();
        $currentDay->setYear(2009);
        $currentDay->setDayNumber(17);
        $week = array();
        $week[0][0] = $currentDay;
        $this->c->setCalendarMatrix(5, 2009);

        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->getDayData(4, 1),
                'Error setting May 4, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartSunDay31()
    {
        $currentDay = new CalendarDay();
        $currentDay->setYear(2009);
        $currentDay->setDayNumber(31);
        $week = array();
        $week[0][0] = $currentDay;
        $this->c->setCalendarMatrix(5, 2009);

        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->getDayData(6, 1),
                'Error setting May 31, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartMonDay1()
    {
        $this->c->setWeekStart('Mon');
        $currentDay = new CalendarDay();
        $currentDay->setYear(2009);
        $currentDay->setDayNumber(1);
        $week = array();
        $week[0][0] = $currentDay;
        $this->c->setCalendarMatrix(5, 2009);

        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->getDayData(1, 5),
                'Error setting May 1, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartMonDay17()
    {
        $this->c->setWeekStart('Mon');
        $currentDay = new CalendarDay();
        $currentDay->setYear(2009);
        $currentDay->setDayNumber(17);
        $week = array();
        $week[0][0] = $currentDay;
        $this->c->setCalendarMatrix(5, 2009);

        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->getDayData(3, 7),
                'Error setting May 4, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartMonDay31()
    {
        $this->c->setWeekStart('Mon');
        $currentDay = new CalendarDay();
        $currentDay->setYear(2009);
        $currentDay->setDayNumber(31);
        $week = array();
        $week[0][0] = $currentDay;
        $this->c->setCalendarMatrix(5, 2009);

        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->getDayData(5, 7),
                'Error setting May 31, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixReturnNullPastMonthEndWkStrtSun()
    {
        $this->c->setCalendarMatrix(5, 2009);
        //$this->assertNull($this->c->_matrix[6][2]);
        $dayData = $this->c->getDayData(6, 2);
        $this->assertFalse(isset($dayData));
    }

    public function testSetCalendarMatrixReturnEmptyStringBeforeMonthStartWkStrtMon()
    {
        $this->c->setWeekStart('Mon');
        $this->c->setCalendarMatrix(5, 2009);
        //$this->assertEquals('', $this->c->_matrix[6][1]);
        $dayData = $this->c->getDayData(6, 1);
        $this->assertFalse(isset($dayData));
    }

    public function testGetDayDataReturnsEmptyStringWithoutMatrixSet()
    {
        $this->assertEquals('', $this->c->getDayData(6, 1));
    }

    public function testGetDayDataReturnsMatrix()
    {
        $currentDay = new CalendarDay();
        $currentDay->setYear(2009);
        $currentDay->setDayNumber(31);
        $week = array();
        $week[0][0] = $currentDay;
        $this->c->setCalendarMatrix(5, 2009);

        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->getDayData(6, 1),
                'Error returning day data for May 31, 2009, test has objects of CalendarDay');
        }
    }
}    
