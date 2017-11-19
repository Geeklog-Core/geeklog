<?php

/**
 * File: SLV.Examine.class.php
 * This is the Spam Link Verification Examine class for the Geeklog Spam-X plugin
 * Copyright (C) 2006-2017 by the following authors:
 * Author        Dirk Haun       dirk AT haun-online DOT de
 * Licensed under the GNU General Public License
 *
 * @package    Spam-X
 * @subpackage Modules
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// Include Base Classes
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';
require_once $_CONF['path'] . 'plugins/spamx/' . 'SLVbase.class.php';

/**
 * Sends posts to SLV (linksleeve.org) for examination
 *
 * @author  Dirk Haun     dirk AT haun-online DOT de
 *          based on the works of Tom Willet (Spam-X) and Russ Jones (SLV)
 * @package Spam-X
 */
class SLV extends BaseCommand
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
        global $LANG_SX00;

        $answer = PLG_SPAM_NOT_FOUND;
        $uid = $this->getUid();

        $slv = new SLVbase();
        if ($slv->CheckForSpam($comment)) {
            $answer = PLG_SPAM_FOUND;
            SPAMX_log($LANG_SX00['foundspam'] . 'Spam Link Verification (SLV)' .
                $LANG_SX00['foundspam2'] . $uid .
                $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']
            );
        }

        // tell the Action module that we've already been triggered
        $GLOBALS['slv_triggered'] = true;

        return $answer;
    }
}
