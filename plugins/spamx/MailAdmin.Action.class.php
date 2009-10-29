<?php

/**
 * File: MailAdmin.Action.class.php
 * This is the Mail Admin Action for the Geeklog Spam-X plugin
 * 
 * Copyright (C) 2004-2008 by the following authors:
 * Author   Tom Willett     tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 * @package Spam-X
 * @subpackage Modules
 */

if (strpos(strtolower($_SERVER['PHP_SELF']), 'mailadmin.action.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Include Abstract Action Class
 */
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Action Class which emails the spam post to the site admin
 * 
 * @author Tom Willett  tomw@pigstye.net 
 *
 * @package Spam-X
 *
 */
class MailAdmin extends BaseCommand {
    /**
     * Constructor
     */
    function MailAdmin()
    {
        global $num;

        $num = 8;
    } 

    function execute($comment)
    {
        global $result, $_CONF, $_USER, $LANG_SX00, $_SPX_CONF;

        if (isset ($_USER['uid']) && ($_USER['uid'] > 1)) {
            $uid = $_USER['uid'];
        } else {
            $uid = 1;
        }
        $uid .= '@' . $_SERVER['REMOTE_ADDR'];
        $msg = sprintf ($LANG_SX00['emailmsg'],
                        $_CONF['site_name'], $uid, $comment);

        // Add headers of the spam post to help track down the source.
        // Function 'getallheaders' is not available when PHP is running as
        // CGI. Print the HTTP_... headers from $_SERVER array instead then.
        $msg .= "\n\n" . $LANG_SX00['headers'] . "\n";
        if (function_exists ('getallheaders')) {
            $headers = getallheaders ();
            foreach ($headers as $key => $content) {
                if (strcasecmp ($key, 'Cookie') != 0) {
                    $msg .= $key . ': ' . $content . "\n";
                }
            }
        } else {
            foreach ($_SERVER as $key => $content) {
                if (substr ($key, 0, 4) == 'HTTP') {
                    if ($key != 'HTTP_COOKIE') {
                        $msg .= $key . ': ' . $content . "\n";
                    }
                }
            }
        }

        $subject = sprintf($LANG_SX00['emailsubject'], $_CONF['site_name']);
        if (empty($_SPX_CONF['notification_email'])) {
            $email_address = $_CONF['site_mail'];
        } else {
            $email_address = $_SPX_CONF['notification_email'];
        }
        COM_mail($email_address, $subject, $msg);
        $result = 8;
        SPAMX_log('Mail Sent to Admin');

        return 0;
    }
}

?>
