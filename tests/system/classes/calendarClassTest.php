<?php

use \PHPUnit\Framework\TestCase as TestCase;

/**
 * Simple tests for calendarClassTest
 */
class calendarClass extends TestCase
{
    /**
     * @var Calendar
     */
    private $c;

    protected function setUp()
    {
        TimeZoneConfig::setSystemTimeZone();
        $this->c = new Calendar;
    }

    public function test_isRollingModeIsFalse()
    {
        $this->assertFalse($this->c->_isRollingMode());
    }

    public function testCalendarConstructor()
    {
        $this->c->_rollingmode = true;
        $this->c->_default_year = 2008;
        $this->c->setLanguage();
        $testDateArray = getdate(time());
        $this->c->reset();
        $this->assertFalse($this->c->_rollingmode);
        $this->assertEquals($testDateArray['year'], $this->c->_default_year);
        $this->assertEquals('January', $this->c->_lang_months['january']);
    }

    public function testGetDayOfWeekEqualsCorrectNum()
    {
        $this->c->_default_year = 2009;
        $this->assertEquals(2, $this->c->getDayOfWeek(26, 5),
            'Error asserting when using default year.');
        $this->assertEquals(2, $this->c->getDayOfWeek(26, 5, 2009),
            'Error asserting when using specified year.');
    }

    public function testGetWeekOfMonthEqualsCorrectNum()
    {
        $this->c->_default_year = 2009;
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
        $this->assertEquals(29, $this->c->getDaysInMonth(2, 2008,
            'Error asserting that February 2008 had 29 days.'));
        $this->assertEquals(31, $this->c->getDaysInMonth(1),
            'Error asserting that January of (default year) had 31 days.');
    }

    public function testGetDayNameEqualsEnglishDefaultOnWkStrtSunday()
    {
        $this->c->_lang_days = array(
            'sunday'    => 'Domingo',
            'monday'    => 'Lunes',
            'tuesday'   => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday'  => 'Jueves',
            'friday'    => 'Viernes',
            'saturday'  => 'Sábado');
        $i = 1;
        foreach ($this->c->_lang_days as $k => $v) {
            $this->assertEquals($v, $this->c->getDayName($i),
                'Error asserting that day ' . $i . ' of week is ' . $v . '.');
            $i++;
        }
        $this->assertEquals('Domingo', $this->c->getDayName(),
            'Error asserting default value is ' . $k . '.');
    }

    public function testGetDayNameEqualsEnglishDefaultOnWkStrtMon()
    {
        $this->c->_week_start = 'Mon';
        $this->c->_lang_days = array(
            'monday'    => 'Lunes',
            'tuesday'   => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday'  => 'Jueves',
            'friday'    => 'Viernes',
            'saturday'  => 'Sábado',
            'sunday'    => 'Domingo');
        $i = 1;
        foreach ($this->c->_lang_days as $k => $v) {
            $this->assertEquals($v, $this->c->getDayName($i),
                'Error asserting that day ' . $i . ' of week is ' . $v . '.');
            $i++;
        }
        $this->assertEquals('Lunes', $this->c->getDayName(),
            'Error asserting default value is ' . $k . '.');
    }

    public function testGetMonthNameTranslates()
    {
        $this->c->_lang_months = array(
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
            'december'  => 'Diciembre');
        $i = 1;
        foreach ($this->c->_lang_months as $k => $v) {
            $this->assertEquals($v, $this->c->getMonthName($i));
            $i++;
        }
        $this->assertEquals('Enero', $this->c->getMonthName());
    }

    public function testGetMonthNameDefaultsEnglish()
    {
        $i = 1;
        foreach ($this->c->_lang_months as $k => $v) {
            $this->assertEquals($v, $this->c->getMonthName($i));
            $i++;
        }
        $this->assertEquals('January', $this->c->getMonthName());
    }

    public function testSetRollingModeToTrue()
    {
        $this->c->_rolling_mode = false;
        $this->c->setRollingMode(true);
        $this->assertEquals(true, $this->c->_isRollingMode());
    }

    public function testSetLanguageTranslates()
    {
        $this->lang_days = array(
            'sunday'    => 'Domingo',
            'monday'    => 'Lunes',
            'tuesday'   => 'Martes',
            'wednesday' => 'Miércoles',
            'thursday'  => 'Jueves',
            'friday'    => 'Viernes',
            'saturday'  => 'Sábado');
        $this->lang_months = array(
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
            'december'  => 'Diciembre');
        $this->c->setLanguage($this->lang_days, $this->lang_months);
        foreach ($this->lang_days as $k => $v) {
            $this->assertEquals($this->lang_days[$k], $this->c->_lang_days[$k],
                'Error translating _lang_days[' . $k . '] to Spanish.');
        }
        foreach ($this->lang_months as $k => $v) {
            $this->assertEquals($this->lang_months[$k], $this->c->_lang_months[$k],
                'Error translating _lang_months[' . $k . '] to Spanish.');
        }
    }

    public function testSetLanguageDefaults()
    {
        $this->lang_days = array(
            'sunday'    => 'Sunday',
            'monday'    => 'Monday',
            'tuesday'   => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday'  => 'Thursday',
            'friday'    => 'Friday',
            'saturday'  => 'Saturday');
        $this->lang_months = array(
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
            'december'  => 'December');
        $this->c->setLanguage();
        foreach ($this->lang_days as $k => $v) {
            $this->assertEquals($v, $this->c->_lang_days[$k],
                'Error translating _lang_days[' . $k . '] to default.');
        }
        foreach ($this->lang_months as $k => $v) {
            $this->assertEquals($v, $this->c->_lang_months[$k],
                'Error translating _lang_months[' . $k . '] to default.');
        }
    }

    public function testSetCalendarMatrixWkStartSunDay1()
    {
        $cur_day = new CalendarDay();
        $cur_day->year = 2009;
        $cur_day->daynumber = 1;
        $week[0][0] = $cur_day;
        $this->c->setCalendarMatrix(5, 2009);
        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->_matrix[1][6],
                'Error setting May 1, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartSunDay17()
    {

        $cur_day = new CalendarDay();
        $cur_day->year = 2009;
        $cur_day->daynumber = 17;
        $week[0][0] = $cur_day;
        $this->c->setCalendarMatrix(5, 2009);
        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->_matrix[4][1],
                'Error setting May 4, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartSunDay31()
    {
        $cur_day = new CalendarDay();
        $cur_day->year = 2009;
        $cur_day->daynumber = 31;
        $week[0][0] = $cur_day;
        $this->c->setCalendarMatrix(5, 2009);
        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->_matrix[6][1],
                'Error setting May 31, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartMonDay1()
    {
        $this->c->_week_start = 'Mon';
        $cur_day = new CalendarDay();
        $cur_day->year = 2009;
        $cur_day->daynumber = 1;
        $week[0][0] = $cur_day;
        $this->c->setCalendarMatrix(5, 2009);
        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->_matrix[1][5],
                'Error setting May 1, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartMonDay17()
    {
        $this->c->_week_start = 'Mon';
        $cur_day = new CalendarDay();
        $cur_day->year = 2009;
        $cur_day->daynumber = 17;
        $week[0][0] = $cur_day;
        $this->c->setCalendarMatrix(5, 2009);
        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->_matrix[3][7],
                'Error setting May 4, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixWkStartMonDay31()
    {
        $this->c->_week_start = 'Mon';
        $cur_day = new CalendarDay();
        $cur_day->year = 2009;
        $cur_day->daynumber = 31;
        $week[0][0] = $cur_day;
        $this->c->setCalendarMatrix(5, 2009);
        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->_matrix[5][7],
                'Error setting May 31, 2009, test has objects of CalendarDay().');
        }
    }

    public function testSetCalendarMatrixReturnNullPastMonthEndWkStrtSun()
    {
        $this->c->setCalendarMatrix(5, 2009);
        //$this->assertNull($this->c->_matrix[6][2]);
        $this->assertFalse(isset($this->c->_matrix[6][2]));
    }

    public function testSetCalendarMatrixReturnEmptyStringBeforeMonthStartWkStrtMon()
    {
        $this->c->_week_start = 'Mon';
        $this->c->setCalendarMatrix(5, 2009);
        //$this->assertEquals('', $this->c->_matrix[6][1]);
        $this->assertFalse(isset($this->c->_matrix[6][1]));
    }

    public function testGetDayDataReturnsEmptyStringWithoutMatrixSet()
    {
        $this->assertEquals('', $this->c->_matrix[6][1]);
    }

    public function testGetDayDataReturnsMatrix()
    {
        $cur_day = new CalendarDay();
        $cur_day->year = 2009;
        $cur_day->daynumber = 31;
        $week[0][0] = $cur_day;

        $this->c->setCalendarMatrix(5, 2009);
        foreach ($week as $k => $v) {
            $this->assertEquals($week[0][0], $this->c->_matrix[6][1],
                'Error returning day data for May 31, 2009, test has objects of CalendarDay');
        }
    }
}    
