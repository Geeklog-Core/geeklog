<?php

/**
 * File: SFS.Examine.class.php
 * This is the Stop Forum Spam Examine class for the Geeklog Spam-X plugin
 * Copyright  (C) 2014-2017 Tom Homer  - WebSiteMaster AT cogeco DOT com
 * Licensed under the GNU General Public License
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die ('This file can not be used on its own!');
}

// Include Base Classes
require_once($_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php');
require_once($_CONF['path'] . 'plugins/spamx/' . 'SFSbase.class.php');

/**
 * Checks number of links in post.
 * based in large part on the works of Dirk Haun, Tom Willet (Spam-X) and Russ Jones (SLV)
 */
class SFS extends BaseCommand
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

        $SFS = new SFSbase();
        if ($SFS->CheckForSpam($comment)) {
            $answer = PLG_SPAM_FOUND;
            SPAMX_log($LANG_SX00['foundspam'] . 'Stop Forum Spam (SFS)' .
                $LANG_SX00['foundspam2'] . $uid .
                $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']
            );
        }

        // tell the Action module that we've already been triggered
        $GLOBALS['SFS_triggered'] = true;

        return $answer;
    }
}
