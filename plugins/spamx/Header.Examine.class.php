<?php

/**
* File: Header.Examine.class.php
* This is the HTTP Header Examine class for the Geeklog Spam-X plugin
*
* Copyright (C) 2005-2009 by the following authors:
* Author    Dirk Haun <dirk AT haun-online DOT de>
*
* based on the works of Tom Willett <tomw AT pigstye DOT net>
*
* Licensed under the GNU General Public License
*
* @package Spam-X
* @subpackage Modules
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'header.examine.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Examine Class
*/
require_once $_CONF['path'] . 'plugins/spamx/' . 'BaseCommand.class.php';

/**
* Examines Post according to HTTP Headers
*
* @author Dirk Haun, dirk AT haun-online DOT de
*
* @package Spam-X
*
*/
class Header extends BaseCommand
{
    /**
     * Here we do the work
     */
    public function execute($comment)
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $uid = $this->getUid();

        // get HTTP headers of the current request
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        } else {
            // if getallheaders() is not available, we have to fake it using
            // the $_SERVER['HTTP_...'] values
            $headers = array();

            foreach ($_SERVER as $key => $content) {
                if (substr($key, 0, 4) === 'HTTP') {
                    $name = str_replace ('_', '-', substr ($key, 5));
                    $headers[$name] = $content;
                }
            }
        }

        $result = DB_query("SELECT value FROM {$_TABLES['spamx']} WHERE name='HTTPHeader'", 1);
        $nrows = DB_numRows($result);

        $ans = PLG_SPAM_NOT_FOUND;

        for ($i = 0; $i < $nrows; $i++) {
            list ($entry) = DB_fetchArray($result);

            $v = explode(':', $entry);
            $name  = trim($v[0]);
            $value = trim($v[1]);
            $value = str_replace('#', '\\#', $value);

            foreach ($headers as $key => $content) {
                if (strcasecmp($name, $key) === 0) {
                    if (preg_match("#{$value}#i", $content)) {
                        $ans = PLG_SPAM_FOUND;	// quit on first positive match
                        $this->updateStat('HTTPHeader', $entry);
                        SPAMX_log ($LANG_SX00['foundspam'] . $entry .
                                   $LANG_SX00['foundspam2'] . $uid . 
                                   $LANG_SX00['foundspam3'] .
                                   $_SERVER['REMOTE_ADDR']);
                        break;
                    }
                }
            }
        }

        return $ans;
    }
}

?>
