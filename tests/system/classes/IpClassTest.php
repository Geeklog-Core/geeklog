<?php

use \PHPUnit\Framework\TestCase;

class IpClassTest extends TestCase
{
    private static $boolString = [false => 'false', true => 'true'];

    /**
     * Test for IPv4 CIDR matching
     */
    public function testMatchCIDR()
    {
        $data = [
            '204.0.63.255'  => false,
            '204.0.64.0'    => true,
            '204.0.127.255' => true,
            '204.0.128.0.0' => false,
        ];
        $CIDR = '204.0.113.1/18';

        foreach ($data as $ip => $expected) {
            $got = \Geeklog\IP::matchCIDR($ip, $CIDR);
            $this->assertEquals(
                $expected,
                $got,
                'Expected: ' . self::$boolString[$expected] . ', Got: ' . self::$boolString[$got]
            );
        }
    }

    /**
     * Test for IPv6 CIDR matching
     */
    public function testMatchCIDRIPv6()
    {
        $data = [
            '2001:4760:4800:0000:0000:0000:0000:0000' => false,
            '2001:4860:4860:0000:0000:0000:0000:8888' => true,
            '2001:4860:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF' => true,
            '2001:4900:0000:0000:0000:0000:0000:0000' => false,
        ];
        $CIDR = '2001:4860:4860::8888/32';

        foreach ($data as $ip => $expected) {
            $got = \Geeklog\IP::matchCIDR($ip, $CIDR);
            $this->assertEquals(
                $expected,
                $got,
                'Expected: ' . self::$boolString[$expected] . ', Got: ' . self::$boolString[$got]
            );
        }
    }

    /**
     * Test for IPv4 IP range matching
     */
    public function testMatchRange()
    {
        // IPv4
        $data = [
            '::1-::2'                   => false,
            '100.0.112.0-100.0.127.255' => true,
            '100.0.111.0-100.0.111.255' => false,
            '100.0.128.0-100.0.128.255' => false,
        ];
        $ipToCheck = '100.0.113.0';

        foreach ($data as $range => $expected) {
            $got = \Geeklog\IP::matchRange($ipToCheck, $range);
            $this->assertEquals(
                $expected,
                $got,
                'Expected: ' . self::$boolString[$expected] . ', Got: ' . self::$boolString[$got]
            );
        }

        // IPv6
        $data = [
            '2001:4860:4860:0000:0000:0000:0000:8888-2001:4860:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF' => true,
        ];
        $ipToCheck = '2001:4860:4860:0000:0000:0000:1000:8888';

        foreach ($data as $range => $expected) {
            $got = \Geeklog\IP::matchRange($ipToCheck, $range);
            $this->assertEquals(
                $expected,
                $got,
                'Expected: ' . self::$boolString[$expected] . ', Got: ' . self::$boolString[$got]
            );
        }
    }

    /**
     * Test for IP validity
     */
    public function testIsValidIP()
    {
        $data = [
            '::1'             => true,
            '127.0.0.1'       => true,
            '255.255.255.255' => true,
            '256.0.0.1'       => false,
            '-1.0.0.1'        => false,
        ];

        foreach ($data as $ip => $expected) {
            $got = \Geeklog\IP::isValidIP($ip);
            $this->assertEquals(
                $expected,
                $got,
                'Expected: ' . self::$boolString[$expected] . ', Got: ' . self::$boolString[$got]
            );
        }
    }

    /**
     * Test for IPv4 validity
     */
    public function testIsValidIPv4()
    {
        $data = [
            '::1'             => false,
            '127.0.0.1'       => true,
            '255.255.255.255' => true,
            '100.0.11.0'      => true,
            '256.0.0.1'       => false,
            '-1.0.0.1'        => false,
        ];

        foreach ($data as $ip => $expected) {
            $got = \Geeklog\IP::isValidIPv4($ip);
            $this->assertEquals(
                $expected,
                $got,
                'Expected: ' . self::$boolString[$expected] . ', Got: ' . self::$boolString[$got]
            );
        }
    }

    /**
     * Test for IPv6 validity
     */
    public function testIsValidIPv6()
    {
        $data = [
            '::1'                      => true,
            '127.0.0.1'                => false,
            '0:0:0:0:0:FFFF:2A96:5B5E' => true,     // IPv4-mapped IPv6 address of 42.150.91.94
            '2002:2a96:5b5e:0:0:0:0:0' => true,     // 6to4 address of 42.150.91.94
        ];

        foreach ($data as $ip => $expected) {
            $got = \Geeklog\IP::isValidIPv6($ip);
            $this->assertEquals(
                $expected,
                $got,
                'Expected: ' . self::$boolString[$expected] . ', Got: ' . self::$boolString[$got]
            );
        }
    }
}
