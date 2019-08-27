<?php

namespace Geeklog;

use InvalidArgumentException;
use IPLib\Address\AddressInterface;
use IPLib\Address\IPv4;
use IPLib\Factory;
use IPLib\Range\RangeInterface;
use IPLib\Range\Subnet;

/**
 * Class IP
 *
 * @package       Geeklog
 * @copyright (C) 2004-2017 Tom Willett - tomw AT pigstye DOT net
 * @copyright (C) 2017-2019 Kenji ITO   - mystralkk AT gmail DOT com
 * @license       GPL
 * @note          most of the code below were taken from IP.Examine.class.php created by Tom Willett.
 */
abstract class IP
{
    /**
     * Return if an IP address matches a CIDR
     *
     * @param  string  $ipToCheck  IP address (IPv4 and IPv6) to check
     * @param  string  $CIDR       CIDR
     * @return bool                true if IP falls into the CIDR, else false
     */
    public static function matchCIDR($ipToCheck, $CIDR)
    {
        $address = Factory::addressFromString($ipToCheck);
        $range = Factory::rangeFromString($CIDR);

        if ((!$address instanceof AddressInterface) || (!$range instanceof RangeInterface)) {
            return false;
        } else {
            return $range->contains($address);
        }
    }

    /**
     * Return if an IP address is in the range given
     *
     * Original authors: dh06 and Stephane, taken from
     *
     * @link http://www.php.net/manual/en/function.ip2long.php#70707
     * @param  string  $ip     IP address (IPv4 or IPv6) to check
     * @param  string  $range  IP address range to check against
     * @return  bool          true if IP falls into the IP range, else false
     * @throws InvalidArgumentException
     */
    public static function matchRange($ip, $range)
    {
        if (strpos($range, '-') === false) {
            throw new InvalidArgumentException(__METHOD__ . ': range must be in "IP1-IP2" format');
        }

        // not for IPv6 addresses
        if (strpos($ip, ':') !== false) {
            return self::matchRangeIPv6($ip, $range);
        }

        $d = strpos($range, '-');
        $from = ip2long(trim(substr($range, 0, $d)));
        $to = ip2long(trim(substr($range, $d + 1)));
        $ip = ip2long($ip);

        return (($ip >= $from) && ($ip <= $to));
    }

    /**
     * Return if an IP address is in the range given
     *
     * @param  string  $ip     IP address to check
     * @param  string  $range  IP address range to check against
     * @return  bool          true if IP falls into the IP range, else false
     * @throws InvalidArgumentException
     */
    private static function matchRangeIPv6($ip, $range)
    {
        $ips = explode('-', $range, 2);
        $from = Factory::addressFromString($ips[0]);
        $to = Factory::addressFromString($ips[1]);
        if ((!$from instanceof AddressInterface) || (!$to instanceof AddressInterface)) {
            throw new InvalidArgumentException(__METHOD__ . ': an IP in the range was invalid as IPv6 address');
        }

        $address = Factory::addressFromString($ip);
        if (!$address instanceof AddressInterface) {
            throw new InvalidArgumentException(__METHOD__ . ': IP was invalid as IPv6 address');
        }

        $from = $from->toString(true);
        $to = $to->toString(true);
        $address = $address->toString(true);

        return (strcmp($from, $address) <= 0) && (strcmp($address, $to) <= 0);
    }

    /**
     * Return if the IP address given is valid
     *
     * @param  string  $ip
     * @return bool
     */
    public static function isValidIP($ip)
    {
        return (filter_var($ip, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV4 || FILTER_FLAG_IPV6)) !== false);
    }

    /**
     * Return if the IP address given is valid as an IPv4 address
     *
     * @param  string  $ip
     * @return bool
     */
    public static function isValidIPv4($ip)
    {
        return (filter_var($ip, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV4)) !== false);
    }

    /**
     * Return if the IP address given is valid as an IPv6 address
     *
     * @param  string  $ip
     * @return bool
     */
    public static function isValidIPv6($ip)
    {
        return (filter_var($ip, FILTER_VALIDATE_IP, array('flags' => FILTER_FLAG_IPV6)) !== false);
    }
}
