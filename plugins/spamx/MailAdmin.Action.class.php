<?php
/**
 * File: MailAdmin.Action.class.php
 * This is the Mail Admin Action for the Geeklog SpamX Plug-in!
 * 
 * Copyright (C) 2004 by the following authors:
 * Author		Tom Willett		tomw@pigstye.net
 * 
 * Licensed under GNU General Public License
 */

/**
 * Include Abstract Action Class
 */
require_once($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');

/**
 * Action Class which just discards comment
 * 
 * @author Tom Willett  tomw@pigstye.net 
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
        $msg = sprintf($LANG_SX00['emailmsg'], $_CONF['site_name'], $uid, $comment);

        $subject = sprintf ($LANG_SX00['emailsubject'], $_CONF['site_name']);
        COM_mail($_SPX_CONF['notification_email'], $subject, $msg);
        $result = 8;
        SPAMX_log('Mail Sent to Admin');
        return 0;
    } 
} 

?>
