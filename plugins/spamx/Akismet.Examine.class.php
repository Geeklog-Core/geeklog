<?php

/**
 * File: Akismet.Examine.class.php
 * This is the Akismet Examine class for the Geeklog Spam-X plugin
 * Copyright (C) 2017 by the following authors:
 * Author        Kenji ITO       mystralkk AT gmail DOT com
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

/**
 * Sends posts to Akismet for examination
 *
 * @package Spam-X
 */
class Akismet extends BaseCommand
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
        global $_CONF, $_SPX_CONF, $LANG_SX00;

        $answer = PLG_SPAM_NOT_FOUND;

        if (!isset($_SPX_CONF['akismet_enabled'], $_SPX_CONF['akismet_api_key'])) {
            $_SPX_CONF['akismet_enabled'] = false;
        }

        // Akismet is not enabled or the user hasn't set Akismet API key
        if (!$_SPX_CONF['akismet_enabled']) {
            return $answer;
        }

        $akismet = new Geeklog\Akismet($_SPX_CONF['akismet_api_key'], $_CONF['site_url']);

        if($akismet->verifyAPIKey()) {
            $answer = $akismet->checkForSpam(
                $comment, $permanentLink, $commentType, $commentAuthor, $commentAuthorEmail, $commentAuthorURL
            );

            if (($answer == PLG_SPAM_FOUND) || ($answer == PLG_SPAM_UNSURE)) {
                SPAMX_log(
                    $LANG_SX00['foundspam'] . 'Akismet' . $LANG_SX00['foundspam2'] . $this->getUid()
                    . $LANG_SX00['foundspam3'] . $_SERVER['REMOTE_ADDR']
                );
            }
        }

        return $answer;
    }
}
