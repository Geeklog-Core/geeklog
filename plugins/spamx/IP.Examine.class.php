<?php

/**
* File: IP.Examine.class.php
* This is the IP BlackList Examine class for the Geeklog Spam-X Plug-in!
*
* Copyright (C) 2004-2005 by the following authors:
* Author        Tom Willett        tomw AT pigstye DOT net
*
* Licensed under GNU General Public License
*
* $Id: IP.Examine.class.php,v 1.7 2006/05/07 20:44:42 mjervis Exp $
*/

/**
* Include Abstract Examine Class
*/
require_once($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');

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
     * @param $comment string 				Comment text to examine
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
     * @param $comment string 				Comment text to examine
     * @param $date	   unixtimestamp  Date/time the comment was posted
     * @param $ip			 string				  IPAddress comment posted from
     * @param $type		 string					Type of comment (article etc)
     */
    function reexecute($comment, $date, $ip, $type)
    {
    		return $this->_process($ip);
    }

		/**
		 * Private internal method, this actually processes a given ip
		 * address against a blacklist of IP regular expressions.
		 *
		 * @param $ip	string	IP address of comment poster
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
        for ($i = 1; $i <= $nrows; $i++) {
            list ($val) = DB_fetchArray ($result);
            if ( preg_match ("#$val#i", $ip)) {
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
