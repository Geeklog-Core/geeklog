<?php

namespace Geeklog\Test;

use CalendarDay;
use PHPUnit\Framework\TestCase;

/**
 * Simple tests for the CalendarDay class
 */
class CalendarDayClassTest extends TestCase
{
    private $cd;

    protected function setUp(): void
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
