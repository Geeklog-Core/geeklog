<?php
/**
* File: DeleteComment.Action.class.php
* This is the Delete Comment Action  for the Geeklog SpamX Plug-in!
*
* Copyright (C) 2004 by the following authors:
*
* @ Author		Tom Willett		tomw@pigstye.net
*
* Licensed under GNU General Public License
*
*/

/**
* Include Abstract Action Class
*
*/
require_once($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');


/**
* Action Class which just discards comment
*
* @author Tom Willett  tomw@pigstye.net
*
*/
class MailAdmin extends BaseCommand {
	/**
	* No Constructor  Uses BaseCommand
	*
	*/

	function execute()
	{
		global $result, $_CONF, $LANG_SX00, $_SPX_CONF, $comment;

		$msg = 'A new comment has been posted at ' . $_CONF['site_name'] . ":\n";
		$msg .= "Title: {$comment['title']}\n";
		$msg .= "UID: {$comment['uid']}\n";
		$msg .= "Content: {$comment['comment']}";
		COM_mail($_SPX_CONF['notification_email'], 'Spam Comment at ' . $_CONF['site_name'], $msg);
		$result = '';
		SPAMX_log('Mail Sent to Admin');
		return 1;
	}
}
?>
