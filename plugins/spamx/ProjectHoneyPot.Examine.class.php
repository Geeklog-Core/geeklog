<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | ProjectHoneyPot.Examine.class.php                                         |
// |                                                                           |
// | Geeklog ProjectHoneyPot.org http:BL examine class for spamx.              |
// | This examine class *REQUIRES* you to register on projecthoneypot.org, and |
// | get your own access key for the http:BL API. It also *REQUIRES* a PEAR    |
// | package PEAR:Net_DNS:                                                     |
// |    http://pear.php.net/package/Net_DNS                                    |
// |   Based on the works of Tom Willett <tomw AT pigstye DOT net>             |
// +---------------------------------------------------------------------------+
// | Copyright (C)      2007 by the following authors:                         |
// |                                                                           |
// | Authors: Michael Jervis    - mike@fuckingbrit.com                         |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* @package Spam-X
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'ProjectHoneyPot.Examine.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Examine Class
*/
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

define('HTTP_BL_SEARCH_ENGINE',        0);
define('HTTP_BL_SUSPICIOUS',           1);
define('HTTP_BL_HARVESTER',            2);
define('HTTP_BL_SUSPICIOUS_HARVESTER', 3);
define('HTTP_BL_COMMENT_SPAMMER',      4);
define('HTTP_BL_SUSPICIOUS_COMMENT',   5);
define('HTTP_BL_HARVESTER_COMMENT',    6);
define('HTTP_BL_ALL',                  7);

/*
 * The following settings all relate to the ProjectHoneyPot.org http:BL
 * examine module. In order to use this, you *MUST* register with
 * ProjectHoneyPot. You *MUST* install a Honey Pot. You *MUST* accept the
 * terms of use of the http:BL and acquire your own http:BL access key.
 */
$_SPX_CONF['http_bl_enable'] = true; // Whether or not to use the http:BL, true or false.
// You can get your access key from: http://www.projecthoneypot.org/httpbl_configure.php
// regardless of http_bl_enable, if you don't have a key, this won't work.
$_SPX_CONF['http_bl_access_key'] = 'NOT.CONFIGURED.RIGHT';
// Whether or not to use TCP (Virtual Circuits) instead of UDP. If set to false,
// UDP will be used unless TCP is required. TCP is required for questions or
// responses greater than 512 bytes.
$_SPX_CONF['http_bl_use_tcp'] = true; 
// DNS Servers to use, in my development environment, I found that the examine
// failed without configuring this. Must be an array of IP addresses, or false:
$_SPX_CONF['http_bl_dns_servers'] = false;
// example of array with dummy values: $_SPX_CONF['http_bl_dns_servers'] = array('ip1','ip2');


/*
 * Debug settings:
 *
 * HTTP_BL_VERBOSE_LOGGING if set to 1 will increase the amount of logging
 * performed to logs/spamx.log, this is helpful when you are trying to set up
 * your nameservers and http:BL access key. You /really/ want to set this to 0.
 *
 * HTTP_BL_DEBUG_MODE is purely for testing, if set to 1, rather than using
 * the IP address of the person posting comment/request will use HTTP_BL_TEST_IP
 * this allows you to test and confirm that it is functioning correctly and
 * trapping all real blacklisted ip types. For a list of valid test values see:
 * http://www.projecthoneypot.org/httpbl_api.php
 */
define('HTTP_BL_VERBOSE_LOGGING',      0);
define('HTTP_BL_DEBUG_MODE',           0);
define('HTTP_BL_TEST_IP',              '127.1.1.1');


/**
* Examines the IP address of the poster using the http:BL available to users of
* ProjectHoneyPot.org. This involves performing a special DNS query using a
* special Project Honey Pot access key. See this plugins config.php for use.
*
* @author Mike Jervis <mike AT fuckingbrit DOT com>
*/

class ProjectHoneyPot extends BaseCommand {
    /**
     * Here we do the work
     */
    function execute($comment)
    {
        global $_SPX_CONF;
        $ans = 0;
        //$_CONF, $_TABLES, $_USER, $LANG_SX00, $result;
        if (isset ($_SPX_CONF['http_bl_access_key']) && $_SPX_CONF['http_bl_enable']) {
            /*
             * We query for accesskey.reversedipaddress.dnsbl.httpbl.org
             */
            if (HTTP_BL_DEBUG_MODE == 1) {
                $targetip = explode('.', HTTP_BL_TEST_IP);
            } else {
                $targetip = explode('.', $_SERVER['REMOTE_ADDR']);
            }
            $querydomain = $_SPX_CONF['http_bl_access_key'];
            for($i = 3; $i >= 0; $i--) {
                $querydomain .= ".{$targetip[$i]}";
            }                
            $querydomain .= '.dnsbl.httpbl.org';
            require_once('Net/DNS.php');
            $resolver = new Net_DNS_Resolver();
            if ($_SPX_CONF['http_bl_use_tcp']) {
                $resolver->usevc = 1;
            }
            if (is_array($_SPX_CONF['http_bl_dns_servers'])) {
                $resolver->nameservers = $_SPX_CONF['http_bl_dns_servers'];
            }
            if (HTTP_BL_VERBOSE_LOGGING == 1) {
                SPAMX_Log("Performing http:BL query for $querydomain");
            }
            $response = $resolver->query($querydomain);
            if ($response) {
                $result = $response->answer[0]->address;
                $resultArray = explode('.', $result);
                if (($resultArray[0] == 127) && ($resultArray[3] > HTTP_BL_SEARCH_ENGINE)) {
                    // Valid, and not a search engine.
                    $days = $resultArray[1];
                    $threat = $resultArray[2];
                    switch($resultArray[3]) {
                        case HTTP_BL_SUSPICIOUS: // suspicious
                            $type = '"Suspicious"';
                            break;
                        case HTTP_BL_HARVESTER: // harvester
                            $type = '"Harvester"';
                            break;
                        case HTTP_BL_SUSPICIOUS_HARVESTER: // suspicious harvester
                            $type = '"Suspicious" and "Harvester"';
                            break;
                        case HTTP_BL_COMMENT_SPAMMER: // comment spammer
                            $type = '"Comment Spammer"';
                            break;
                        case HTTP_BL_SUSPICIOUS_COMMENT: // suspicious & comment spammer
                            $type = '"Suspicious" and "Comment Spammer"';
                            break;
                        case HTTP_BL_HARVESTER_COMMENT: // harvester & comment spammer
                            $type = '"Harvester" and "Comment Spammer"';
                            break;
                        case HTTP_BL_ALL: // suspicious, harvesting comment spammer
                            $type = '"Suspicious", "Harvester" and "Comment Spammer"';
                            break;
                    }
                    SPAMX_Log("http:BL reports {$_SERVER['REMOTE_ADDR']} as a $type of threat level $threat. Activity was last seen $days day(s) ago.");
                    $ans = 1;
                } else {
                    // Either invalid query, or, a search engine.
                    if (!($resultArray[3] == HTTP_BL_SEARCH_ENGINE)) {
                        SPAMX_Log('Invalid response from http:BL queried: "' .
                                    $querydomain . '". Received: "' . $result . '"');
                    }
                    $ans = 0;
                }
            }
        } else {
            if (HTTP_BL_VERBOSE_LOGGING == 1) {
                SPAMX_Log('No response received from http:BL for '.$queryDomain);
            }
            $ans = 0;
        }
                        

        return $ans;
    }
}

?>
