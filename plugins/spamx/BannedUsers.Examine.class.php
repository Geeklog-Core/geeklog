<?php

/**
 * File: BannedUsers.Examine.class.php
 * This Exame class for Geeklog's Spam-X plugin checks posts against URLs
 * that banned users used as their homepage URL.
 * Copyright (C) 2012 by the following authors:
 * Author   Dirk Haun       dirk AT haun-online DOT de
 * Licensed under GNU General Public License
 *
 * @package    Spam-X
 * @subpackage Modules
 */

if (stripos($_SERVER['PHP_SELF'], 'bannedusers.examine.class.php') !== false) {
    die('This file can not be used on its own!');
}

// Include Abstract Examine Class
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Examines Comment according to Personal Blacklist
 *
 * @author  Dirk Haun dirk AT haun-online DOT de
 * @package Spam-X
 */
class BannedUsers extends BaseCommand
{
    // No Constructor Use BaseCommand constructor

    /**
     * Here we do the work
     *
     * @param  string $comment
     * @return int
     */
    public function execute($comment)
    {
        global $_TABLES, $_USER, $LANG_SX00, $LANG28;

        $uid = COM_isAnonUser() ? 1 : $_USER['uid'];

        // Get homepage URLs of all banned users
        $result = DB_query("SELECT DISTINCT homepage FROM {$_TABLES['users']} WHERE status = 0 AND homepage IS NOT NULL AND homepage <> ''");
        $numRows = DB_numRows($result);

        // named entities
        $comment = html_entity_decode($comment);

        // decimal notation
        $comment = preg_replace('/&#(\d+);/me', "chr(\\1)", $comment);

        // hex notation
        $comment = preg_replace('/&#x([a-f0-9]+);/mei', "chr(0x\\1)", $comment);

        $ans = 0;

        for ($i = 0; $i < $numRows; $i++) {
            list($val) = DB_fetchArray($result);
            $val = str_replace('#', '\\#', $val);

            if (preg_match("#$val#i", $comment)) {
                $ans = 1; // quit on first positive match
                SPAMX_log($LANG_SX00['foundspam'] . $val .
                    ' (' . $LANG28[42] . ')' .
                    $LANG_SX00['foundspam2'] . $uid .
                    $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']);
                break;
            }
        }

        $this->result = $ans;

        return $ans;
    }
}
