<?php

use \PHPUnit\Framework\TestCase;

/**
 * Class ValidatorClassTest
 * @package system\classes
 */
class ValidatorClassTest extends TestCase
{
    public function setUp(): void
    {
        require_once \Tst::$root . 'system/lib-mbyte.php';
    }

    /**
     * Test for notEmpty method
     */
    public function testNotEmpty()
    {
        $validator = Validator::getInstance();
        $this->assertEquals(true, $validator->notEmpty('0'));
        $this->assertEquals(true, $validator->notEmpty('8'));
        $this->assertEquals(true, $validator->notEmpty('some'));
        $this->assertEquals(false, $validator->notEmpty(''));
        $this->assertEquals(false, $validator->notEmpty([]));
    }

    /**
     * Test for alphaNumeric method
     */
    public function testAlphaNumeric()
    {
        $validator = Validator::getInstance();
        $this->assertEquals(true, $validator->alphaNumeric('0'));
        $this->assertEquals(true, $validator->alphaNumeric('8'));
        $this->assertEquals(true, $validator->alphaNumeric('some'));
        $this->assertEquals(false, $validator->alphaNumeric(''));
        $this->assertEquals(false, $validator->alphaNumeric('*'));
        $this->assertEquals(false, $validator->alphaNumeric([]));
    }

    /**
     * Test for between method
     */
    public function testBetween()
    {
        $validator = Validator::getInstance();
        $this->assertEquals(true, $validator->between('Geeklog', 1, 16));
        $this->assertEquals(true, $validator->between('日本', 1, 10));
        $this->assertEquals(false, $validator->between('Geeklog', 1, 5));
        $this->assertEquals(false, $validator->between('アメリカ合衆国', 1, 15));
    }

    /**
     * Test for blank method
     */
    public function testBlank()
    {
        $validator = Validator::getInstance();
        $this->assertEquals(true, $validator->blank(''));
        $this->assertEquals(true, $validator->blank(' '));
        $this->assertEquals(true, $validator->blank("\n"));
        $this->assertEquals(true, $validator->blank("\r"));
        $this->assertEquals(true, $validator->blank("\t"));
        $this->assertEquals(false, $validator->blank('0'));
        $this->assertEquals(false, $validator->blank('Geeklog'));
        $this->assertEquals(false, $validator->blank('カナダ'));
    }

    /**
     * Test for date method
     */
    public function testDate()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, '2019-08-28', 'ymd'],
            [false, '2019-13-28', 'ymd'],
            [true, '28-08-2019', 'dmy'],
            [false, '28-13-2019', 'dmy'],
            [true, '08-28-2019', 'mdy'],
            [false, '02-30-2019', 'mdy'],
            [true, '28 August 2019', 'dMy'],
            [true, '28 Aug 2019', 'dMy'],
            [false, '28 2019 Aug', 'dMy'],
            [true, 'August 28 2019', 'Mdy'],
            [false, '28 August 2019', 'Mdy'],
            [true, 'August 2019', 'My'],
            [false, '2019 August', 'My'],
            [true, '08-2019', 'my'],
            [false, '2019-08', 'my'],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->date($items[1], $items[2]),
                'Expected ' . $items[1] . ' was ' . ($items[0] ? 'a valid' : 'an invalid') . ' date, but such is not the case.');
        }
    }

    /**
     * Test for time method
     */
    public function testTime()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, '09:00'],
            [false, '09:60'],
            [false, '25:00'],
            [true, '13:59'],
            [false, '13:60'],
            [true, '09:00AM'],
            [true, '09:00am'],
            [true, '9:00AM'],
            [false, '13:00AM'],
            [true, '09:00PM'],
            [true, '09:00pm'],
            [false, '13:00PM'],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->time($items[1]),
                'Expected ' . $items[1] . ' was ' . ($items[0] ? 'a valid' : 'an invalid') . ' time, but such is not the case.');
        }
    }

    /**
     * Test for boolean method
     */
    public function testBoolean()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 0],
            [true, '0'],
            [true, false],
            [true, 1],
            [true, '1'],
            [true, true],
            [false, null],
            [false, 'true'],
            [false, 'Geeklog'],
            [false, '-1'],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->boolean($items[1]),
                'Expected ' . $items[1] . ' was ' . ($items[0] ? 'a valid' : 'an invalid') . ' boolean value, but such is not the case.');
        }
    }

    /**
     * Test for decimal method
     */
    public function testDecimal()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 0.1],
            [false, 0],
            [true, 1.23],
            [false, 1.0],
            [true, -1.1],
            [true, 12.3],
            [true, '1.23e10'],
            [true, '1.23E10'],
            [true, '1.23e-10'],
            [true, '1.23E-10'],
            [false, '1.23e'],
            [false, '1.23E'],
            [false, 0xff],
            [false, 'true'],
            [false, 'Geeklog'],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->decimal($items[1]),
                'Expected ' . $items[1] . ' was ' . ($items[0] ? 'a valid' : 'an invalid') . ' decimal value, but such is not the case.');
        }
    }

    /**
     * Test for email method
     */
    public function testEmail()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 'admin@example.net'],
            [false, 'admin@localhost'],
            [false, 'admin'],
            [true, 'nobody@geeklog.net'],
            [true, 'someone@geeklog.jp'],
            [false, 'starge@name@example.net'],
            [false, '@geeklog.net'],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->email($items[1]),
                'Expected ' . $items[1] . ' was ' . ($items[0] ? 'a valid' : 'an invalid') . ' email address, but such is not the case.');
        }
    }

    /**
     * Test for equalTo method
     */
    public function testEqualTo()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 'admin', 'admin'],
            [false, 'admin', 'Admin'],
            [false, 10, '10'],
            [true, 0xff, 255],
            [false, '0xff', 255],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->equalTo($items[1], $items[2]),
                'Expected ' . $items[1] . ' was ' . ($items[0] ? 'equal' : 'not equal') . ' to ' . $items[2] . ', but such is not the case.');
        }
    }

    /**
     * Test for extension method
     */
    public function testExtension()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 'logo.png', ['gif', 'jpeg', 'png', 'jpg']],
            [true, 'logo.PNG', ['gif', 'jpeg', 'png', 'jpg']],
            [true, 'logo.img.png', ['gif', 'jpeg', 'png', 'jpg']],
            [false, 'logo.png.img', ['gif', 'jpeg', 'png', 'jpg']],
            [false, 'logo', ['gif', 'jpeg', 'png', 'jpg']],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->extension($items[1], $items[2]),
                'Expected ' . $items[1] . ($items[0] ? 'has' : 'does not have') . ' one of  (' . implode(', ', $items[2]) . ') extensions, but such is not the case.');
        }
    }

    /**
     * Test for ip method
     */
    public function testIp()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, '127.0.0.1', 'both'],
            [true, '::1', 'both'],
            [true, '127.0.0.1', 'ipv4'],
            [false, '::1', 'ipv4'],
            [true, '2001:4860:4860:0000:0000:0000:0000:8888', 'ipv6'],
            [false, '127.0.0.1', 'ipv6'],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->ip($items[1], $items[2]),
                'Expected ' . $items[1] . ' was ' . ($items[0] ? 'a valid' : 'an invalid') . ' IP address, but such is not the case.');
        }
    }

    /**
     * Test for minLength method
     */
    public function testMinLength()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 'Geeklog', 5],
            [true, 'Geeklog', strlen('Geeklog')],
            [false, 'Geeklog', strlen('Geeklog') + 10],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->minLength($items[1], $items[2]),
                'Expected the length of ' . $items[1] . ($items[0] ? 'is' : 'is not') . ' at least ' . $items[2] . ', but such is not the case.');
        }
    }

    /**
     * Test for maxLength method
     */
    public function testMaxLength()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 'Geeklog', 20],
            [true, 'Geeklog', strlen('Geeklog')],
            [false, 'Geeklog', strlen('Geeklog') - 2],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->maxLength($items[1], $items[2]),
                'Expected the length of ' . $items[1] . ($items[0] ? 'is' : 'is not') . ' at least ' . $items[2] . ', but such is not the case.');
        }
    }

    /**
     * Test for multiple method
     */
    public function testMultiple()
    {
        $validator = Validator::getInstance();
        $values = [0, 5, 10, 20];
        $data = [
            [true, 10, ['in' => $values]],
            [true, 10, ['in' => $values, 'min' => 1, 'max' => 1]],
            [false, 10, ['in' => $values, 'min' => 2, 'max' => 4]],
            [true, [5, 10], ['in' => $values, 'min' => 1, 'max' => 2]],
            [false, [5, 10], ['in' => $values, 'min' => 1, 'max' => 1]],
            [false, [5, 7, 10], ['in' => $values, 'min' => 1, 'max' => 1]],
            [false, [5, 7, 10], ['in' => $values, 'min' => 1, 'max' => 3]],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->multiple($items[1], $items[2]),
                'Expected ' . $items[0] . ', but such is not the case.');
        }
    }

    /**
     * Test for numeric method
     */
    public function testNumeric()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 10],
            [true, 10.1],
            [true, 1.23e9],
            [true, -1.23E7],
            [true, 0777],
            [true, 0xde],
            [false, 'Geeklog'],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->numeric($items[1]),
                'Expected ' . $items[1] . ') is ' . ($items[0] ? '' : 'not') . ' a numeric value, but such is not the case.');
        }
    }

    /**
     * Test for phone method
     *
     * @todo Implement this method
     */
    public function testPhone()
    {
        $validator = Validator::getInstance();

        // USA
        $data = [
            [true, '234-235-5678'],
//            [false, '234-911-5678'],
            [false, '314-159-2653'],
            [false, '123-234-5678'],
            [true, '1-213-555-0123'],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->phone($items[1]),
                'Expected ' . $items[1] . ' is ' . ($items[0] ? '' : 'not') . ' the right phone number given, but such is not the case.');
        }
    }

    /**
     * Test for range method
     */
    public function testRange()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 10, 0, 100],
            [true, 10.1, -10, 20],
            [true, 1.23e3, 1000, 10000],
            [true, 20, 0, null],
            [false, 'Geeklog', 10, 30],
            [true, 0xde, 0x00, 0xff],
            [false, 20, 30, 50],
            [false, -100, 0, 100],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->range($items[1], $items[2], $items[3]),
                'Expected ' . $items[1] . ' is ' . ($items[0] ? '' : 'not') . ' in the range given, but such is not the case.');
        }
    }

    /**
     * Test for string method
     */
    public function testString()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 'Geeklog'],
            [true, '0'],
            [false, ''],
            [false, null],
            [true, ['Geeklog', 'admin']],
            [true, ['Geeklog', null]],
            [true, [null, 'Geeklog']],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->string($items[1]),
                'Expected (' . implode(', ', (array) $items[1]) . ') is ' . ($items[0] ? '' : 'not') . ' a string, but such is not the case.');
        }
    }

    /**
     * Test for stringOrEmpty method
     */
    public function testStringOrEmpty()
    {
        $validator = Validator::getInstance();
        $this->assertEquals(true, $validator->stringOrEmpty('0'));
        $this->assertEquals(true, $validator->stringOrEmpty('8'));
        $this->assertEquals(true, $validator->stringOrEmpty('some'));
        $this->assertEquals(true, $validator->stringOrEmpty(''));
        $this->assertEquals(true, $validator->stringOrEmpty([]));
        $this->assertEquals(true, $validator->stringOrEmpty(null));
    }

    /**
     * Test for url method
     */
    public function testUrl()
    {
        $validator = Validator::getInstance();
        $data = [
            [false, 'localhost'],
            [true, 'https://www.geeklog.net'],
            [true, 'https://www.geeklog.jp/:80'],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->url($items[1]),
                'Expected (' . implode(', ', (array) $items[1]) . ') is ' . ($items[0] ? '' : 'not') . ' a valid URL, but such is not the case.');
        }
    }

    /**
     * Test for inList method
     */
    public function testInList()
    {
        $validator = Validator::getInstance();
        $data = [
            [true, 10, [0, 5, 10, 15], true],
            [false, '10', [0, 5, 10, 15], true],
            [true, 'en', ['de', 'en', 'jp', 'fr'], true],
            [false, 'EN', ['de', 'en', 'jp', 'fr'], true],
        ];

        foreach ($data as $items) {
            $this->assertEquals(
                $items[0],
                $validator->inList($items[1], $items[2], $items[3]),
                'Expected ' . $items[1] . ' is ' . ($items[0] ? '' : 'not') . ' in the list given, but such is not the case.');
        }
    }
}
