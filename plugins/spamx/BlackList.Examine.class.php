<?php

/**
 * File: BlackList.Examine.class.php
 * This is the Personal BlackList Examine class for the Geeklog Spam-X plugin
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
 * Include Abstract Examine Class
 */
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Examines Comment according to Personal BLacklist
 *
 * @author  Tom Willett tomw AT pigstye DOT net
 * @package Spam-X
 */
class BlackList extends BaseCommand
{
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
    public function execute($comment, $permanentLink, $commentType = Geeklog\Akismet::COMMENT_TYPE_COMMENT,
                            $commentAuthor = null, $commentAuthorEmail = null, $commentAuthorURL = null)
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $uid = $this->getUid();

        /**
         * Include Blacklist Data
         */
        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name='Personal'", 1);
        $numRows = DB_numRows($result);

        // named entities
        $comment = html_entity_decode($comment);

        // decimal notation
        $comment = preg_replace_callback('/&#(\d+);/m', array($this, 'callbackDecimal'), $comment);

        // hex notation
        $comment = preg_replace_callback('/&#x([a-f0-9]+);/mi', array($this, 'callbackHex'), $comment);

        $answer = PLG_SPAM_NOT_FOUND;

        for ($i = 1; $i <= $numRows; $i++) {
            list($val) = DB_fetchArray($result);
            $pattern = $this->prepareRegularExpression($val);

            if (preg_match($pattern, $comment)) {
                $answer = PLG_SPAM_FOUND;  // quit on first positive match
                $this->updateStat('Personal', $val);
                SPAMX_log($LANG_SX00['foundspam'] . $val .
                    $LANG_SX00['foundspam2'] . $uid .
                    $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']);
                break;
            }
        }

        return $answer;
    }
}
