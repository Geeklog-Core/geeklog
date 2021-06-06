<?php

/**
 *   SFS.Misc.class.php
 *   Special examiner to check email and IP addresses during registration.
 *   Checks stopforumspam.com and, if the result is positive, addes the
 *   email and/or IP address to the spamx table.
 *
 * @author       Lee Garner <lee@leegarner.com>
 * @copyright    Copyright (c) 2010-2017 Lee Garner <lee@leegarner.com>
 * @package      spamx
 * @subpackage   Modules
 * @version      1.0.0
 * @license      http://opensource.org/licenses/gpl-2.0.php
 *               GNU Public License v2 or later
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// Include Abstract Examine Class
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Examines Email and IP
 *
 * @author  Tom Willett, tomw AT pigstye DOT net
 * @package Spam-X
 */
class SFS extends BaseCommand
{
    /**
     * @var bool
     */
    private $_verbose = false;

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
        $this->result = $this->_process($commentAuthorEmail, \Geeklog\IP::getIPAddress());

        return $this->result;
    }


    /**
     * Private internal method,
     *
     * @param   string $email Email address of user
     * @param   string $ip    IP address of user
     * @return  int             0: no spam, else: spam detected
     */
    private function _process($email, $ip)
    {
        global $_TABLES, $LANG_SX00, $_SPX_CONF;

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

        $db_email = DB_escapeString($email);
        $db_ip = DB_escapeString($ip);
        //  Include Blacklist Data
        //  Check for IP address
        $result = DB_query("SELECT name, value FROM {$_TABLES['spamx']}
                WHERE name='IP' AND value='$db_ip'
                OR name='email' AND value='$db_email'", 1);
        if (DB_numRows($result) > 0) {
            list ($name, $value) = DB_fetchArray($result);
            $timestamp = DB_escapeString(date('Y-m-d H:i:s'));
            DB_query("UPDATE {$_TABLES['spamx']} SET counter = counter + 1, regdate = '$timestamp' WHERE name='" . DB_escapeString($name) . "' AND value='" . DB_escapeString($value) . "'", 1);

            return PLG_SPAM_FOUND;
        }

        $em = urlencode($email);
        $query = "http://api.stopforumspam.org/api?f=serial&email=$em";
        if (!empty($ip)) {
            $query .= "&ip=$ip";
        }

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

        if (
            (isset($result['email']) && $result['email']['appears'] == 1 && $result['email']['confidence'] > (float) $_SPX_CONF['sfs_confidence']) ||
            ($result['ip']['appears'] == 1 && $result['ip']['confidence'] > (float) $_SPX_CONF['sfs_confidence'])
        ) {
            $value_arr = array();
            $timestamp = DB_escapeString(date('Y-m-d H:i:s'));
            if (isset($result['email']) && $result['email']['appears'] == 1 && $result['email']['confidence'] > (float) $_SPX_CONF['sfs_confidence']) {
                $value_arr[] = "('email', '$db_email', '$timestamp')";
            }
            if ($result['ip']['appears'] == 1 && $result['ip']['confidence'] > (float) $_SPX_CONF['sfs_confidence']) {
                $value_arr[] = "('IP', '$db_ip', '$timestamp')";
            }
            $values = implode(',', $value_arr);
            $sql = "INSERT INTO {$_TABLES['spamx']} (name, value, regdate)
                    VALUES $values";
            DB_query($sql);

            $log_msg = sprintf($LANG_SX00['email_ip_spam'], $email, $ip);
            SPAMX_log($log_msg);

            return PLG_SPAM_FOUND;
        } else {
            if ($this->_verbose) {
                SPAMX_log("SFS: spammer IP not detected: " . $ip . " Spammer email not detected: " . $email);
            }
        }

        // Passed the checks
        return PLG_SPAM_NOT_FOUND;
    }
}
