<?php

/**
 * File: IP.Examine.class.php
 * This is the IP BlackList Examine class for the Geeklog Spam-X plugin
 * Copyright (C) 2004-2017 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 * Licensed under GNU General Public License
 *
 * @package    Spam-X
 * @subpackage Modules
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// Include Abstract Examine Class
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Examines Comment according to Personal IP Blacklist
 *
 * @author  Tom Willett, tomw AT pigstye DOT net
 * @package Spam-X
 */
class IP extends BaseCommand
{
    /**
     * Here we do the work
     *
     * @param  string $comment
     * @param  string $permanentLink (since GL 2.2.0)
     * @param  string $commentType (since GL 2.2.0)
     * @param  string $commentAuthor (since GL 2.2.0)
     * @param  string $commentAuthorEmail (since GL 2.2.0)
     * @param  string $commentAuthorURL (since GL 2.2.0)
     * @return int    either PLG_SPAM_NOT_FOUND, PLG_SPAM_FOUND or PLG_SPAM_UNSURE
     * @note As for valid value for $commentType, see system/classes/Akismet.php
     */
    public function execute($comment, $permanentLink = null, $commentType = Geeklog\Akismet::COMMENT_TYPE_COMMENT,
                            $commentAuthor = null, $commentAuthorEmail = null, $commentAuthorURL = null)
    {
        return $this->_process($_SERVER['REMOTE_ADDR']);
    }

    /**
     * The re-execute method is used to mass-delete spam, essentially.
     * It does the same as execute, but is called with recorded comments
     * in order to match them against new rules that were not in effect
     * at the time of posting. To do that, it uses the IP address logged
     * when the comment was saved.
     *
     * @param   string $comment Comment text to examine
     * @param   int    $date    Date/time the comment was posted
     * @param   string $ip      IPAddress comment posted from
     * @param   string $type    Type of comment ('article', etc)
     * @return  int                 0: no spam, else: spam detected
     */
    public function reexecute($comment, $date, $ip, $type)
    {
        return $this->_process($ip);
    }

    /**
     * Private internal method to match an IP address against a CIDR
     *
     * @param   string $ipToCheck IP address to check
     * @param   string $CIDR      IP address range to check against
     * @return  boolean             true if IP falls into the CIDR, else false
     * @todo    CIDR support for IPv6 addresses
     *                            Original author: Ian B, taken from
     * @link    http://www.php.net/manual/en/function.ip2long.php#71939
     */
    private function _matchCIDR($ipToCheck, $CIDR)
    {
        // not for IPv6 addresses
        if (strpos($ipToCheck, ':') !== false) {
            return false;
        }

        // get the base and the bits from the ban in the database
        list($base, $bits) = explode('/', $CIDR);

        // now split it up into its classes
        $classes = explode('.', $base);
        $elements = count($classes);
        if ($elements < 4) {
            for ($i = $elements; $i < 4; $i++) {
                $classes[$i] = 0;
            }
        }
        list($a, $b, $c, $d) = $classes;

        // now do some bit shifting/switching to convert to ints
        $i = ($a << 24) + ($b << 16) + ($c << 8) + $d;
        $mask = $bits == 0 ? 0 : (~0 << (32 - $bits));

        // here's our lowest int
        $low = $i & $mask;

        // here's our highest int
        $high = $i | (~$mask & 0xFFFFFFFF);

        // now split the ip we're checking against up into classes
        $ex = explode('.', $ipToCheck);

        if (count($ex) == 4) {
            // now convert the ip we're checking against to an int
            $check = ($ex[0] << 24) + ($ex[1] << 16) + ($ex[2] << 8) + $ex[3];

            // if the ip is within the range, including
            // highest/lowest values, then it's witin the CIDR range
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
     * @return  boolean         true if IP falls into the IP range, else false
     */
    private function _matchRange($ip, $range)
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
     * Private internal method, this actually processes a given ip
     * address against a blacklist of IP regular expressions.
     *
     * @param   string $ip IP address of comment poster
     * @return  int        PLG_SPAM_NOT_FOUND: no spam, PLG_SPAM_FOUND: spam detected
     */
    private function _process($ip)
    {
        global $_TABLES, $LANG_SX00;

        $uid = $this->getUid();

        /**
         * Include Blacklist Data
         */
        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name='IP'", 1);
        $numRows = DB_numRows($result);

        $answer = PLG_SPAM_NOT_FOUND;

        for ($i = 0; $i < $numRows; $i++) {
            list($val) = DB_fetchArray($result);

            if (strpos($val, '/') !== false) {
                $matches = $this->_matchCIDR($ip, $val);
            } elseif (strpos($val, '-') !== false) {
                $matches = $this->_matchRange($ip, $val);
            } else {
                $pattern = $this->prepareRegularExpression($val);
                $matches = preg_match($pattern, $ip);
            }

            if ($matches) {
                $answer = PLG_SPAM_FOUND;  // quit on first positive match
                $this->updateStat('IP', $val);
                SPAMX_log($LANG_SX00['foundspam'] . $val .
                    $LANG_SX00['foundspam2'] . $uid .
                    $LANG_SX00['foundspam3'] . $ip)
                ;
                break;
            }
        }

        return $answer;
    }
}
