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
        global $result, $_USER, $_CONF, $LANG_SX00, $_SPX_CONF, $comment;

        $msg = sprintf($LANG_SX00['emailmsg'], $_CONF['site_name'], $_USER['uid'], $comment);

        COM_mail($_SPX_CONF['notification_email'], 'Spam Comment at ' . $_CONF['site_name'], $msg);
        $result = 8;
        SPAMX_log('Mail Sent to Admin');
        return 0;
    } 
} 

?>
