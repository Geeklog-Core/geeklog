<?php

use \PHPUnit\Framework\TestCase;

/**
 * Simple tests for timerobjectClassTest
 */
class timerobjectClass extends TestCase
{
    /**
     * @var timerobject
     */
    private $t;

    /**
     * @var double
     */
    private $prec;

    protected function setUp()
    {
        $this->t = new timerobject;
        $this->prec = 0.001;
    }

    public function testSetPrecisionReturnsDecimalPlaces()
    {
        $this->t->setPrecision(0);
        $this->t->setPrecision(3);
        $this->assertEquals(3, $this->t->getPrecision());
    }

    public function testStartTimerEqualsDummy()
    {
        $time = microtime(true);
        $this->t->startTimer();
        $this->assertEquals($time, $this->t->getStartTime(), '', $this->prec);
    }

    public function testStartTimerReturnsFloat()
    {
        $this->t->setStartTime('String');
        $this->t->startTimer();
        $this->assertTrue(is_float($this->t->getStartTime()));
    }

    public function testStopTimerEqualsDummy()
    {
        $time = microtime(true);
        $this->t->stopTimer();
        $this->assertEquals($time, $this->t->getEndTime(), '', $this->prec);
    }

    public function testStopTimerReturnsCorrectDefaultDegreeOfPrecision()
    {
        $parts = explode('.', $this->t->stopTimer());
        $this->assertEquals(2, count($parts));
        $this->assertEquals($this->t->getPrecision(), strlen($parts[1]));
    }

    public function testStopTimerReturnsCorrectDefinedDegreeOfPrecision()
    {
        $this->t->setPrecision(3);
        $parts = explode('.', $this->t->stopTimer());
        $this->assertEquals(2, count($parts));
        $this->assertEquals(3, strlen($parts[1]));
    }

    public function testStopTimerReturnsString()
    {
        $this->t->setStartTime(.56);
        $this->assertTrue(is_string($this->t->stopTimer()));
    }

    public function testRestartResets_EndTime()
    {
        $this->t->restart();
        $this->assertEquals(0.0, $this->t->getEndTime());
    }

    public function testRestartRedefines_StartTime()
    {
        $this->t->restart();
        $time = microtime(true);
        $this->assertEquals($time, $this->t->getStartTime(), '', $this->prec);
    }

    public function testGetElapsedTimeReturnsDefaultDegreeOfPrecision()
    {
        $timeStart = time();
        $timeEnd = $timeStart + .12345;
        $this->t->setStartTime($timeStart);
        $this->t->setEndTime($timeEnd);
        $var1 = sprintf('%.2f', .12345);
        $this->assertEquals($var1, $this->t->getElapsedTime());
    }

    public function testGetElapsedTimeReturnsDefinedDegreeOfPrecision()
    {
        $timeStart = time();
        $timeEnd = $timeStart + .12345;
        $this->t->setStartTime($timeStart);
        $this->t->setEndTime($timeEnd);
        $this->t->setPrecision(3);
        $var1 = sprintf('%.3f', .12345);
        $this->assertEquals($var1, $this->t->getElapsedTime());
    }

    public function test_SetElapsedTime()
    {
        $this->t->setStartTime(.56);
        $this->t->setEndTime(.66);
        $this->assertEquals(.10, $this->t->getElapsedTime(), '', $this->prec);
    }
}
