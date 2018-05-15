<?php

/**
 * File: DeleteComment.Action.class.php
 * This is the Delete Comment Action  for the Geeklog Spam-X plugin
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

/**
 * Include Abstract Action Class
 */
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Action Class which just discards comment
 *
 * @author  Tom Willett  tomw@pigstye.net
 * @package Spam-X
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
        global $_CONF, $_TABLES, $LANG_SX00;

        $this->result = PLG_SPAM_ACTION_DELETE;

        // update count of deleted spam posts
        $sql['mysql'] = "UPDATE {$_TABLES['vars']} "
            . "SET value = value + 1 "
            . "WHERE name = 'spamx.counter' ";
        $sql['pgsql'] = "UPDATE {$_TABLES['vars']} "
            . "SET value = CAST(value AS int) + 1 "
            . "WHERE name = 'spamx.counter' ";
        DB_query($sql);
        SPAMX_log($LANG_SX00['spamdeleted']);

        return PLG_SPAM_FOUND;
    }
}
