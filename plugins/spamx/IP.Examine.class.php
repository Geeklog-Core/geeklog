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
        return $this->_process(\Geeklog\IP::getIPAddress());
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
     * @param   string $ipToCheck  IP address (IPv4 or IPv6) to check
     * @param   string $CIDR       IP address range to check against
     * @return  boolean            true if IP falls into the CIDR, else false
     */
    private function _matchCIDR($ipToCheck, $CIDR)
    {
        return Geeklog\IP::matchCIDR($ipToCheck, $CIDR);
    }

    /**
     * Private internal method to match an IP address against an address range
     *
     * @param   string $ip    IP address (IPv4 or IPv6) to check
     * @param   string $range IP address range to check against
     * @return  boolean       true if IP falls into the IP range, else false
     */
    private function _matchRange($ip, $range)
    {
        return Geeklog\IP::matchRange($ip, $range);
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
