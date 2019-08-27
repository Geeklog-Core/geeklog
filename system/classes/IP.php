<?php

namespace Geeklog;

/**
 * Class IP
 *
 * @package Geeklog
 * @copyright (C) 2004-2017 Tom Willett - tomw AT pigstye DOT net
 * @copyright (C) 2017-2017 Kenji ITO   - mystralkk AT gmail DOT com
 * @license GPL
 * @note most of the code below were taken from IP.Examine.class.php created by Tom Willett.
 */
class IP
{
    /**
     * Private internal method to match an IP address against a CIDR
     *
     * @param  string $ipToCheck IP address to check
     * @param  string $ipInCIDR  IP address range to check against
     * @return bool              true if IP falls into the CIDR, else false
     * @todo    CIDR support for IPv6 addresses
     * @link    http://www.php.net/manual/en/function.ip2long.php#71939
     */
    public static function matchCIDR($ipToCheck, $ipInCIDR)
    {
        // not for IPv6 addresses
        if (strpos($ipToCheck, ':') !== false) {
            return false;
        }

        list ($base, $bits) = explode('/', $ipInCIDR, 2);

        // now split it up into its classes
        $classes = explode('.', $base);
        $elements = count($classes);
        if ($elements < 4) {
            for ($i = $elements; $i < 4; $i++) {
                $classes[$i] = 0;
            }
        }
        list ($a, $b, $c, $d) = $classes;

        // now do some bit shifting/switching to convert to ints
        $i = ($a << 24) + ($b << 16) + ($c << 8) + $d;
        $mask = $bits == 0 ? 0 : (~0 << (32 - $bits));

        // here's our lowest int
        $low = $i & $mask;

        // here's our highest int
        $high = $i | (~$mask & 0xFFFFFFFF);

        // now split the ip we're checking against up into classes
        $ex = explode('.', $ipToCheck);

        if (count($ex) === 4) {
            // now convert the ip we're checking against to an int
            $check = ($ex[0] << 24) + ($ex[1] << 16) + ($ex[2] << 8) + $ex[3];

            // if the ip is within the range, including
            // highest/lowest values, then it's within the CIDR range
            if (($check >= $low) && ($check <= $high)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Private internal method to match an IP address against an address range
     * Original authors: dh06 and Stephane, taken from
     *
     * @link http://www.php.net/manual/en/function.ip2long.php#70707
     * @param   string $ip    IP address to check
     * @param   string $range IP address range to check against
     * @return  bool          true if IP falls into the IP range, else false
     */
    public static function matchRange($ip, $range)
    {
        // not for IPv6 addresses
        if (strpos($ip, ':') !== false) {
            return false;
        }

        $d = strpos($range, '-');
        if ($d !== false) {
            $from = ip2long(trim(substr($range, 0, $d)));
            $to = ip2long(trim(substr($range, $d + 1)));

            $ip = ip2long($ip);

            return (($ip >= $from) && ($ip <= $to));
        }

        return false;
    }

    /**
     * Return if the IP address given is valid
     *
     * @param  string $ip
     * @return bool
     */
    public static function isValidIP($ip)
    {
        return (filter_var($ip, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV4 || FILTER_FLAG_IPV6)) !== false);
    }

    /**
     * Return if the IP address given is valid as an IPv4 address
     *
     * @param  string $ip
     * @return bool
     */
    public static function isValidIPv4($ip)
    {
        return (filter_var($ip, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV4)) !== false);
    }

    /**
     * Return if the IP address given is valid as an IPv6 address
     *
     * @param  string $ip
     * @return bool
     */
    public static function isValidIPv6($ip)
    {
        return (filter_var($ip, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV6)) !== false);
    }
}
