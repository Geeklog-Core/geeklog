<?php

/**
* Basic Command Abstract class
*
* @author	Tom Willett	tomw AT pigstye DOT net
*
*/
class BaseCommand {
	/**
	* @access public
	*/
	
	var $comment;   //Comment array
	
	var $result = null;    //Result of execute command
	
	/**
	* Constructor
	*
	* @access public
	*
	*/
	function BaseCommand()
	{	
		global $comment;
		
		$comment = array();
	}
	
	function execute()
	{
		return 0;
	}
	
	function init($comm) {
		global $comment;
		
		$comment = $comm;
	}

	function getComment() {
		global $comment;
		return $comment;
	}
	function result()
	{
		global $result;
		
		return $result;
	}
}
?>