<?php

/**
 * File: MailAdmin.Action.class.php
 * This is the Mail Admin Action for the Geeklog Spam-X plugin
 * Copyright (C) 2004-2017 by the following authors:
 * Author   Tom Willett     tomw AT pigstye DOT net
 * Licensed under GNU General Public License
 *
 * @package    Spam-X
 * @subpackage Modules
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// Include Abstract Action Class
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Action Class which emails the spam post to the site admin
 *
 * @author  Tom Willett  tomw@pigstye.net
 * @package Spam-X
 */
class MailAdmin extends BaseCommand
{
    public function __construct()
    {
        $this->actionCode = PLG_SPAM_ACTION_NOTIFY;
    }

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
        global $_CONF, $LANG_SX00, $_SPX_CONF;

        $uid = $this->getUid() . '@' . \Geeklog\IP::getIPAddress();
        $msg = sprintf($LANG_SX00['emailmsg'],
            $_CONF['site_name'], $uid, $comment);

        // Add headers of the spam post to help track down the source.
        // Function 'getallheaders' is not available when PHP is running as
        // CGI. Print the HTTP_... headers from $_SERVER array instead then.
        $msg .= "\n\n" . $LANG_SX00['headers'] . "\n";
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
            foreach ($headers as $key => $content) {
                if (strcasecmp($key, 'Cookie') != 0) {
                    $msg .= $key . ': ' . $content . "\n";
                }
            }
        } else {
            foreach ($_SERVER as $key => $content) {
                if (substr($key, 0, 4) == 'HTTP') {
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
        $this->result = PLG_SPAM_ACTION_NOTIFY;
        SPAMX_log('Mail Sent to Admin');

        return PLG_SPAM_NOT_FOUND;
    }
}
