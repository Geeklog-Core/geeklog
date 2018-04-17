<?php

/**
 * File: IPofUrl.Examine.class.php
 * This is the Personal BlackList Examine class for the Geeklog Spam-X plugin
 * Copyright (C) 2004-2017 by the following authors:
 * Author        Tom Willett        tomw AT pigstye DOT net
 * Licensed under GNU General Public License
 *
 * @package    Spam-X
 * @subpackage Modules
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// Include Abstract Examine Class
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
 * Examines Comment according to Personal BLacklist
 *
 * @author  Tom Willett tomw AT pigstye DOT net
 * @package Spam-X
 */
class IPofUrl extends BaseCommand
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
    public function execute($comment, $permanentLink = null, $commentType = Geeklog\Akismet::COMMENT_TYPE_COMMENT,
                            $commentAuthor = null, $commentAuthorEmail = null, $commentAuthorURL = null)
    {
        global $_TABLES, $LANG_SX00;

        $uid = $this->getUid();

        /**
         * Check for IP of url in blacklist
         */
        /*
        * regex to find urls $2 = fqd
        */
        $num = preg_match_all('#(https|http|ftps|ftp|file)://([^/\\s]+)#', html_entity_decode($comment), $urls);
        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name='IPofUrl'", 1);
        $numRows = DB_numRows($result);

        $answer = PLG_SPAM_NOT_FOUND;

        for ($j = 1; $j <= $numRows; $j++) {
            list($val) = DB_fetchArray($result);

            for ($i = 0; $i < $num; $i++) {
                $ip = gethostbyname($urls[2][$i]);

                if ($val == $ip) {
                    $answer = PLG_SPAM_FOUND;  // quit on first positive match
                    $this->updateStat('IPofUrl', $val);
                    SPAMX_log($LANG_SX00['foundspam'] . $urls[2][$i] .
                        $LANG_SX00['foundspam2'] . $uid .
                        $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']
                    );
                    break;
                }
            }

            if ($answer == PLG_SPAM_FOUND) {
                break;
            }
        }

        return $answer;
    }
}
