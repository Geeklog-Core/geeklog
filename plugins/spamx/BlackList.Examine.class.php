<?php
/**
* File: BlackList.Examine.class.php
* This is the Personal BlackList Examine class for the Geeklog SpamX Plug-in!
*
* Copyright (C) 2004 by the following authors:
*
* @ Author		Tom Willett		tomw@pigstye.net
*
* Licensed under GNU General Public License
*
*/

/**
*Include Abstract Examine Class
*
*/
require_once($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');


/**
* Examines Comment according to Personal BLacklist
*
* @author Tom Willett tomw AT pigstye DOT net
*
*/

class BlackList extends BaseCommand {
	/**
	* No Constructor Use BaseCommand constructor
	*
	*/
	/**
	* Here we do the work
	*
	*/
	function execute()
	{
		global $_CONF, $result, $comment, $_USER, $_TABLES, $REMOTE_ADDR, $LANG_SX00;
		
		/**
		* Include Blacklist Data
		*
		*/
		$result=DB_query("SELECT * FROM {$_TABLES['spamx']} WHERE name='Personal'",1);
		$nrows=DB_numRows($result);

		$ans = 0;
		for($i=1;$i<=$nrows;$i++) {
			$A=DB_fetchArray($result);
			$val=$A['value'];
			if (preg_match("#$val#",$comment['comment'])) {
				$ans=1;  // quit on first positive match
				SPAMX_log($LANG_SX00['foundspam'] . $val .$LANG_SX00['foundspam2'] . $_USER['uid'] . $LANG_SX00['foundspam3'] . $REMOTE_ADDR);
				break;
			}
		}				
		return $ans;
	}
}

?>