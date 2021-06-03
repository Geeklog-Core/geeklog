<?php

namespace Geeklog;

use InvalidArgumentException;
use IPLib\Address\AddressInterface;
use IPLib\Address\IPv4;
use IPLib\Address\IPv6;
use IPLib\Factory;
use IPLib\Range\RangeInterface;

/**
 * Class IP
 *
 * @package       Geeklog
 * @copyright (C) 2004-2017 Tom Willett - tomw AT pigstye DOT net
 * @copyright (C) 2017-2021 Kenji ITO   - mystralkk AT gmail DOT com
 * @license       GPL
 * @note          most of the code below were taken from IP.Examine.class.php created by Tom Willett.
 */
abstract class IP
{
    // Anonymization policy
    const POLICY_NEVER_ANONYMIZE = -1;
    const POLICY_ANONYMIZE_IMMEDIATELY = 0;

    const INVALID_SEQ = 0;

    /**
     * @var bool
     */
    private static $isInitialized = false;

    /**
     * @var string
     */
    private static $ipAddressTable = 'gl_ip_addresses';

    /**
     * @var int
     */
    private static $anonymizationPolicy = self::POLICY_NEVER_ANONYMIZE;

    /**
     * @var string
     */
    private static $ipAddress;

    /**
     * Initialize the IP class
     *
     * @param  string  $ipAddressTable
     * @param  int     $anonymizationPolicy
     */
    public static function init($ipAddressTable = 'gl_ip_addresses', $anonymizationPolicy = self::POLICY_NEVER_ANONYMIZE)
    {
        if (!self::$isInitialized) {
            self::$ipAddressTable = $ipAddressTable;

            $anonymizationPolicy = (int) $anonymizationPolicy;
            if ($anonymizationPolicy < 0) {
                $anonymizationPolicy = self::POLICY_NEVER_ANONYMIZE;
            }
            self::$anonymizationPolicy = $anonymizationPolicy;

            self::$ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.01';
            $_SERVER['REMOTE_ADDR'] = '0.0.0.0';
            self::$isInitialized = true;
        }
    }

    /**
     * Return if an IP address matches a CIDR
     *
     * @param  string  $ipAddressToCheck  IP address (IPv4 and IPv6) to check
     * @param  string  $CIDR              CIDR
     * @return bool                true if IP falls into the CIDR, else false
     */
    public static function matchCIDR($ipAddressToCheck, $CIDR)
    {
        $address = Factory::addressFromString($ipAddressToCheck);
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
     * @param  string  $ipAddress  IP address (IPv4 or IPv6) to check
     * @param  string  $range      IP address range to check against
     * @return  bool          true if IP falls into the IP range, else false
     * @throws InvalidArgumentException
     */
    public static function matchRange($ipAddress, $range)
    {
        if (strpos($range, '-') === false) {
            throw new InvalidArgumentException(__METHOD__ . ': range must be in "IP1-IP2" format');
        }

        // not for IPv6 addresses
        if (strpos($ipAddress, ':') !== false) {
            return self::matchRangeIPv6($ipAddress, $range);
        }

        $d = strpos($range, '-');
        $from = ip2long(trim(substr($range, 0, $d)));
        $to = ip2long(trim(substr($range, $d + 1)));
        $ipAddress = ip2long($ipAddress);

        return (($ipAddress >= $from) && ($ipAddress <= $to));
    }

    /**
     * Return if an IP address is in the range given
     *
     * @param  string  $ipAddress  IP address to check
     * @param  string  $range      IP address range to check against
     * @return  bool          true if IP falls into the IP range, else false
     * @throws InvalidArgumentException
     */
    private static function matchRangeIPv6($ipAddress, $range)
    {
        $ips = explode('-', $range, 2);
        $from = Factory::addressFromString($ips[0]);
        $to = Factory::addressFromString($ips[1]);
        if ((!$from instanceof AddressInterface) || (!$to instanceof AddressInterface)) {
            throw new InvalidArgumentException(__METHOD__ . ': an IP in the range was invalid as IPv6 address');
        }

        $address = Factory::addressFromString($ipAddress);
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
     * @param  string  $ipAddress
     * @return bool
     */
    public static function isValidIP($ipAddress)
    {
        return (filter_var($ipAddress, FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV4 || FILTER_FLAG_IPV6]) !== false);
    }

    /**
     * Return if the IP address given is valid as an IPv4 address
     *
     * @param  string  $ipAddress
     * @return bool
     */
    public static function isValidIPv4($ipAddress)
    {
        return (filter_var($ipAddress, FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV4]) !== false);
    }

    /**
     * Return if the IP address given is valid as an IPv6 address
     *
     * @param  string  $ipAddress
     * @return bool
     */
    public static function isValidIPv6($ipAddress)
    {
        return (filter_var($ipAddress, FILTER_VALIDATE_IP, ['flags' => FILTER_FLAG_IPV6]) !== false);
    }

    /**
     * Anonymize an IP address
     *
     * @param  string  $ipAddress
     * @param  int     $anonymizationPolicy
     * @return string
     * @throws InvalidArgumentException
     */
    public static function anonymize($ipAddress, $anonymizationPolicy = null)
    {
        if ($anonymizationPolicy === null) {
            $anonymizationPolicy = self::$anonymizationPolicy;
        }

        if ($anonymizationPolicy >= 0) {
            if (self::isValidIPv4($ipAddress)) {
                // Change the least significant byte to zero
                $bytes = IPv4::fromString($ipAddress)->getBytes();
                $bytes[3] = 0;
                $ipAddress = IPv4::fromBytes($bytes)->toString();
            } elseif (self::isValidIPv6($ipAddress)) {
                // Change the last 80 bits to zeros
                $bytes = IPv6::fromString($ipAddress)->getBytes();

                for ($i = 6; $i <= 15; $i++) {
                    $bytes[$i] = 0;
                }

                $ipAddress = IPv6::fromBytes($bytes)->toString();
            }
        } else {
            throw new InvalidArgumentException(__METHOD__ . ": Bad IP address was given: $ipAddress");
        }

        return $ipAddress;
    }

    /**
     * Return a sequential number corresponding with an IP address stored in the 'ip_addresses' table
     *
     * @param  string  $ipAddress
     * @return int
     */
    public static function getSeq($ipAddress = null)
    {
        if (empty($ipAddress)) {
            $ipAddress = self::$ipAddress;
        }

        if (self::$anonymizationPolicy === self::POLICY_ANONYMIZE_IMMEDIATELY) {
            $ipAddress = self::anonymize($ipAddress);
            $isAnonymized = 1;
        } else {
            $isAnonymized = 0;
        }

        $ipAddress = DB_escapeString($ipAddress);
        $sql = sprintf(
            "INSERT INTO %s (ipaddress, created_at, is_anonymized) VALUES('%s', %d, %d)",
            self::$ipAddressTable, $ipAddress, time(), $isAnonymized
        );
        DB_query($sql);

        if (DB_error()) {
            return self::INVALID_SEQ;
        } else {
            return (int) DB_insertId();
        }
    }

    /**
     * Scan the 'ip_addresses' table and anonymize IP addresses if necessary
     *
     * @note This method is intended to called from within PLG_runScheduledTask() or at the end of "lib-common.php"
     */
    public static function updateIPAddressesTable()
    {
        if (self::$anonymizationPolicy === self::POLICY_NEVER_ANONYMIZE) {
            return;
        }

        // Get all old records
        $threshold = time() - self::$anonymizationPolicy;
        $sql = sprintf(
            "SELECT seq, ipaddress FROM %s WHERE (is_anonymized = 0) AND (created_at <= %d)",
            self::$ipAddressTable, $threshold
        );
        $result = DB_query($sql);
        $rows = [];

        while (($A = DB_fetchArray($result, false)) != false) {
            $rows[] = $A;
        }

        // Anonymize IP addresses and save them
        foreach ($rows as $row) {
            $seq = (int) $row['seq'];
            $ipAddress = $row['ipaddress'];
            $ipAddress = self::anonymize($ipAddress);
            $ipAddress = DB_escapeString($ipAddress);
            $sql = sprintf(
                "UPDATE %s SET ipaddress = '%s', is_anonymized = 1 WHERE seq = %d",
                self::$ipAddressTable, $ipAddress, $seq
            );
            DB_query($sql);
        }
    }
}
