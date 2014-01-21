<?php

/**
 * Basic Command Abstract class
 * 
 * @author Tom Willett	tomw AT pigstye DOT net 
 *
 * @package Spam-X
 * @subpackage Modules
 *
 */
abstract class BaseCommand
{
    protected $result     = PLG_SPAM_ACTION_NONE;	// Result of execute command
    protected $actionCode = PLG_SPAM_ACTION_NONE;	// Action code

    abstract function execute($comment);

    public function getResult()
    {
        return $this->result;
    } 

    public function getActionCode()
    {
        return $this->actionCode;
    }
}

?>
