<?php

use \PHPUnit\Framework\TestCase as TestCase;

/**
 * Simple tests for the CalendarDay class
 */
class calendarDayClass extends TestCase
{
    private $cd;

    protected function setUp()
    {
        // Assign default values
        $this->cd = new CalendarDay;
    }

    public function testIsWeekendIsFalse()
    {
        $this->assertFalse($this->cd->isWeekend());
    }

    public function testIsHolidayIsFalse()
    {
        $this->assertFalse($this->cd->isHoliday());
    }

    public function testIsSelectedIsFalse()
    {
        $this->assertFalse($this->cd->isSelected());
    }
}
