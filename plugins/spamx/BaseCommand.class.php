<?php

/**
 * Basic Command Abstract class
 * 
 * @author Tom Willett	tomw AT pigstye DOT net 
 *
 * $Id: BaseCommand.class.php,v 1.3 2005/04/10 10:02:43 dhaun Exp $
 */

class BaseCommand {
    /**
     * 
     * @access public 
     */

    var $result = null; //Result of execute command
    var $num = 0; // Action Number	
    /**
     * Constructor
     * 
     * @access public 
     */
    function BaseCommand()
    {
    } 

    function execute($comment)
    {
        return 0;
    } 

    function result()
    {
        global $result;

        return $result;
    } 
    function number()
    {
        global $num;

        return $num;
    } 
} 

?>
