<?php
/**
*   SFS.Misc.class.php
*   Special examiner to check email and IP addresses during registration.
*   Checks stopforumspam.com and, if the result is positive, addes the
*   email and/or IP address to the spamx table.
*
*   @author     Lee Garner <lee@leegarner.com>
*   @copyright  Copyright (c) 2010 Lee Garner <lee@leegarner.com>
*   @package    spamx
*   @subpackage Modules
*   @version    1.0.0
*   @license    http://opensource.org/licenses/gpl-2.0.php 
*               GNU Public License v2 or later
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'sfs.misc.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Examine Class
*/
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
* Examines Email and IP
*
* @author Tom Willett, tomw AT pigstye DOT net
*
* @package Spam-X
*
*/
class SFS extends BaseCommand {
    /**
     * No Constructor - use BaseCommand constructor
     */

    /**
     * The execute method examines the Email address
     *
     * @param   string  $email      Email text to examine
     * @return  int                 0: no spam, else: spam detected
     */
    function execute($email)
    {
        global $result;

        $result = $this->_process($email, $_SERVER['REMOTE_ADDR']);
        return $result;
    }


    /**
     * Private internal method, 
     *
     * @param   string  $email  Email address of user
     * @param   string  $ip     IP address of user
     * @return  int             0: no spam, else: spam detected
     * @access  private
     */
    function _process($email, $ip)
    {
        global $_TABLES, $LANG_SX00, $_SPX_CONF;

        if (!isset ($_SPX_CONF['sfs_enabled'])) {
            $_SPX_CONF['sfs_enabled'] = false;
        }
        
        if (!$_SPX_CONF['sfs_enabled']) {
            return 0;     // invalid data, assume ok
        }
        
        $db_email = mysql_escape_string($email);
        $db_ip = mysql_escape_string($ip);
        //  Include Blacklist Data
        //  Check for IP address
        $result = DB_query("SELECT value FROM {$_TABLES['spamx']}
                WHERE name='IP' AND value='$db_ip'
                OR name='email' AND value='$db_email'", 1);
        if (DB_numRows($result) > 0) {
            return 1;
        }

        $em = urlencode($email);
        $query = "http://www.stopforumspam.com/api?f=serial&email=$em";
        if (!empty($ip)) {
            $query .= "&ip=$ip";
        }
        
        if (!isset ($_SPX_CONF['timeout'])) {
            $_SPX_CONF['timeout'] = 5; // seconds
        }

        $ctx = stream_context_create(array( 
            'http' => array( 
                'timeout' => $_SPX_CONF['timeout'] 
                ) 
            ) 
        );
        
        if ($this->_verbose) {
            SPAMX_log ("Sending to SFS: $query");
        }        

        $result = file_get_contents($query, 0, $ctx);
        $result = unserialize($result);
        if (!$result) {
            if ($this->_verbose) {
                SPAMX_log ("SFS: no spam detected");
            }
            return 0;     // invalid data, assume ok
        }

        if ($result['email']['appears'] == 1)
            $value_arr[] = "('email', '$db_email')";
        if ($result['ip']['appears'] == 1)
            $value_arr[] = "('IP', '$db_ip')";
        if (!empty($value_arr)) {
            $values = implode(',', $value_arr);
            $sql = "INSERT INTO {$_TABLES['spamx']} (name, value) 
                    VALUES $values";
            DB_query($sql);
            
            $log_msg = sprintf($LANG_SX00['email_ip_spam'], $email, $ip);
            SPAMX_log($log_msg);
           
            return 1;
        }

        return 0;
    }
}

?>
