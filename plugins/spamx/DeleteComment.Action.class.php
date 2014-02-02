<?php

/**
 * File: DeleteComment.Action.class.php
 * This is the Delete Comment Action  for the Geeklog Spam-X plugin
 * 
 * Copyright (C) 2004-2005 by the following authors:
 * Author   Tom Willett     tomw AT pigstye DOT net
 * 
 * Licensed under GNU General Public License
 *
 * @package Spam-X
 * @subpackage Modules
 */

if (strpos(strtolower($_SERVER['PHP_SELF']), 'deletecomment.action.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
 * Include Abstract Action Class
 */
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Action Class which just discards comment
 * 
 * @author Tom Willett  tomw@pigstye.net 
 * @package Spam-X
 *
 */
class DeleteComment extends BaseCommand
{
    /**
     * Constructor
     * Numbers are always binary digits and added together to make call
     */
    public function __construct()
    {
        $this->actionCode = PLG_SPAM_ACTION_DELETE;
    } 

    public function execute($comment)
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $this->result = PLG_SPAM_ACTION_DELETE;

        // update count of deleted spam posts
        $sql['mysql'] = "UPDATE {$_TABLES['vars']} "
                      . "SET value = value + 1 "
                      . "WHERE name = 'spamx.counter' ";
        $sql['mssql'] = $sql['mysql'];
        $sql['pgsql'] = "UPDATE {$_TABLES['vars']} "
                      . "SET value = CAST(value AS int) + 1 "
                      . "WHERE name = 'spamx.counter' ";
        DB_query($sql);
        SPAMX_log($LANG_SX00['spamdeleted']);

        return PLG_SPAM_FOUND;
    }
}

?>
