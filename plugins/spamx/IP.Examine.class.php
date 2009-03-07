<?php

/**
* File: IP.Examine.class.php
* This is the IP BlackList Examine class for the Geeklog Spam-X plugin
*
* Copyright (C) 2004-2007 by the following authors:
* Author        Tom Willett        tomw AT pigstye DOT net
*
* Licensed under GNU General Public License
*
* @package Spam-X
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'IP.Examine.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Examine Class
*/
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
* Examines Comment according to Personal BLacklist
*
* @author Tom Willett tomw AT pigstye DOT net
*/

class IP extends BaseCommand {
    /**
     * No Constructor Use BaseCommand constructor
     */

    /**
     * The execute method examines the IP address a comment is coming from,
     * comparing it against a blacklist of banned IP addresses.
     *
     * @param $comment string                 Comment text to examine
     */
    function execute($comment)
    {
        return $this->_process($_SERVER['REMOTE_ADDR']);
    }

    /**
     * The re-execute method is used to massdelete spam, essentially
     * it does the same as execute, but is called with recorded comments
     * in order to match them against new rules that were not in effect
     * at the time of posting. To do that, it uses the IP address logged
     * when the comment was saved.
     *
     * @param $comment string            Comment text to examine
     * @param $date       unixtimestamp  Date/time the comment was posted
     * @param $ip         string         IPAddress comment posted from
     * @param $type       string         Type of comment (article etc)
     */
    function reexecute($comment, $date, $ip, $type)
    {
        return $this->_process($ip);
    }

    /**
     * Private internal method to match an IP address against a CIDR
     *
     * @param   string  $iptocheck  IP address to check
     * @param   string  $CIDR       IP address range to check against
     * @return  boolean             true if IP falls into the CIDR, else false
     *
     * Original author: Ian B, taken from
     * http://www.php.net/manual/en/function.ip2long.php#71939
     *
     */
    function _matchCIDR ($iptocheck, $CIDR)
    {
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

        // now split the ip were checking against up into classes
        list($a, $b, $c, $d) = explode('.', $iptocheck);

        // now convert the ip we're checking against to an int
        $check = ($a << 24) + ($b << 16) + ($c << 8) + $d;

        // if the ip is within the range, including
        // highest/lowest values, then it's witin the CIDR range
        if (($check >= $low) && ($check <= $high)) {
            return true;
        }

        return false;
    }

    /**
     * Private internal method to match an IP address against an address range
     *
     * @param   string  $ip     IP address to check
     * @param   string  $range  IP address range to check against
     * @return  boolean         true if IP falls into the IP range, else false
     *
     * Original authors: dh06 and Stephane, taken from
     * http://www.php.net/manual/en/function.ip2long.php#70707
     *
     */
    function _matchRange ($ip, $range)
    {
        $d = strpos ($range, '-');
        if ($d !== false) {
           $from = ip2long (trim (substr ($range, 0, $d)));
           $to = ip2long (trim (substr ($range, $d + 1)));

           $ip = ip2long ($ip);
           return (($ip >= $from) && ($ip <= $to));
        }

        return false;
    }

    /**
     * Private internal method, this actually processes a given ip
     * address against a blacklist of IP regular expressions.
     *
     * @param $ip    string    IP address of comment poster
     */
    function _process($ip)
    {
        global $_CONF, $_TABLES, $_USER, $LANG_SX00, $result;

        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }

        /**
         * Include Blacklist Data
         */
        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name='IP'", 1);
        $nrows = DB_numRows($result);

        $ans = 0;
        for ($i = 0; $i < $nrows; $i++) {
            list ($val) = DB_fetchArray ($result);

            $matches = false;
            if (strpos ($val, '/') !== false) {
                $matches = $this->_matchCIDR ($ip, $val);
            } else if (strpos ($val, '-') !== false) {
                $matches = $this->_matchRange ($ip, $val);
            } else {
                $matches = (preg_match ("#$val#i", $ip) == 0 ? false : true);
            }

            if ($matches) {
                $ans = 1; // quit on first positive match
                SPAMX_log ($LANG_SX00['foundspam'] . $val .
                           $LANG_SX00['foundspam2'] . $uid .
                           $LANG_SX00['foundspam3'] . $ip);
                break;
            }
        }

        return $ans;
    }
}

?>
