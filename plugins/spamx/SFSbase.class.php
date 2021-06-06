<?php

/**
 * File: SFSbase.class.php
 * Stop Forum Spam (SFS) Base Class
 * Copyright  (C) 2014-2017 Tom Homer  - WebSiteMaster AT cogeco DOT com
 * Licensed under the GNU General Public License


 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die ('This file can not be used on its own!');
}

/**
 * Checks number of links in post.
 * based in large part on the works of Dirk Haun, Tom Willet (Spam-X) and Russ Jones (SLV)
 */
class SFSbase
{
    private $_debug = false;
    private $_verbose = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_debug = false;
        $this->_verbose = false;
    }

    /**
     * Check if spam IP
     *
     * @param    string $post post to check for spam
     * @return   boolean         true = spam found, false = no spam
     *                        Note: Also returns 'false' in case of problems communicating with SFS.
     *                        Error messages are logged in Geeklog's error.log

     */
    function CheckForSpam($post)
    {
        global $_SPX_CONF, $_TABLES;

        if (!isset($_SPX_CONF['sfs_enabled'])) {
            $_SPX_CONF['sfs_enabled'] = false;
        }

        if (!$_SPX_CONF['sfs_enabled']) {
            return PLG_SPAM_NOT_FOUND;  // invalid data, assume ok
        }

        if (!$_SPX_CONF['sfs_confidence']) {
            $_SPX_CONF['sfs_enabled'] = 25;
        }

        if (!isset($_SPX_CONF['timeout'])) {
            $_SPX_CONF['timeout'] = 5; // seconds
        }


        $ip = \Geeklog\IP::getIPAddress();
        $query = "http://api.stopforumspam.org/api?f=serial&ip=$ip";

        $req = new HTTP_Request2(
            $query,
            HTTP_Request2::METHOD_GET,
            array(
                'timeout' => $_SPX_CONF['timeout'],
            )
        );

        if ($this->_verbose) {
            SPAMX_log('Sending to SFS: ' . $query);
        }

        try {
            $response = $req->send();

            if ($response->getStatus() == 200) {
                $result = $response->getBody();

                if (strlen($result) === 0) {
                    return PLG_SPAM_NOT_FOUND;  // Response body is not set, assume ok
                }

                $result = @unserialize($result);

                if ($result === false) {
                    if ($this->_verbose) {
                        SPAMX_log("SFS: no spam detected");
                    }

                    return PLG_SPAM_NOT_FOUND;  // Invalid data, assume ok
                }
            } else {
                return PLG_SPAM_NOT_FOUND;  // PEAR Error, assume ok
            }
        } catch (HTTP_Request2_Exception $e) {
            COM_errorLog(__METHOD__ . ': ' . $e->getMessage());

            return PLG_SPAM_NOT_FOUND;  // assumes OK
        }

        if ($result['ip']['appears'] == 1 && $result['ip']['confidence'] > (float) $_SPX_CONF['sfs_confidence']) {
            $retval = PLG_SPAM_FOUND;
            SPAMX_log("SFS: spammer IP detected: " . $ip);

            // Add IP to SFS IP list... assuming sfs runs after ip check so no dups
            // Double Check for IP address just in case
            $db_ip = DB_escapeString($ip);
            $result = DB_query("SELECT value FROM {$_TABLES['spamx']}
                    WHERE name='IP' AND value='$db_ip'", 1);
            if (DB_numRows($result) == 0) { // Not in db so add
                $timestamp = DB_escapeString(date('Y-m-d H:i:s'));
                $sql = "INSERT INTO {$_TABLES['spamx']} (name, value, regdate)
                        VALUES ('IP', '$db_ip', '$timestamp')";
                DB_query($sql);
            }
        } else {
            $retval = PLG_SPAM_NOT_FOUND;
            if ($this->_verbose) {
                SPAMX_log("SFS: spammer IP not detected: " . $ip);
            }
        }

        return $retval;
    }
}
