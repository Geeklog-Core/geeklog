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
class DeleteComment extends BaseCommand {
	/**
	* No Constructor  Uses BaseCommand
	*
	*/

	function execute()
	{
		global $result, $_CONF, $LANG_SX00;
		$result = COM_refresh ($_CONF['site_url'] . '/index.php');
		SPAMX_log($LANG_SX00['spamdeleted']);
		return 1;
	}
}
?>