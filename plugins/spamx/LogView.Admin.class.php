<?php

/**
 * File: Logview.Admin.class.php
 * This is the LogViewer for the Geeklog Spam-X plugin
 *
 * Copyright (C) 2004-2006 by the following authors:
 * Author       Tom Willett     tomw AT pigstye DOT net
 *
 * Licensed under GNU General Public License
 *
 * @package Spam-X
 * @subpackage Modules
 */

if (strpos(strtolower($_SERVER['PHP_SELF']), 'logview.admin.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Base Class
*/
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';

/**
* LogView class
*
* @package Spam-X
*
*/
class LogView extends BaseAdmin
{
    const MAX_LOG_SIZE = 100000;
    const LOG_FILE     = 'spamx.log';

    public function __construct()
    {
        global $LANG_SX00;

        $this->moduleName = '';
        $this->command    = 'LogView';
        $this->titleText  = '';
        $this->linkText   = $LANG_SX00['viewlog'];
    }

    public function display()
    {
        global $_CONF, $LANG_SX00;

        $action = $this->getAction();
        $path = $_CONF['site_admin_url']
              . '/plugins/spamx/index.php?command=LogView';
        $log = 'spamx.log';
        $display = '<form method="post" action="' . $path . '"><div>'
                 . '<input type="submit" name="action" value="'
                 . $LANG_SX00['clearlog'] . '"' . XHTML . '>'
                 . '</div></form>';

        if ($action === $LANG_SX00['clearlog']) {
            $entry = strftime('%c') . ' ' . $LANG_SX00['logcleared'] . " \n";
            file_put_contents($_CONF['path_log'] . self::LOG_FILE, $entry, LOCK_EX);
        }

        $fsize = filesize($_CONF['path_log'] . self::LOG_FILE);

        if ($fsize > self::MAX_LOG_SIZE) {
            $fd = fopen($_CONF['path_log'] . self::LOG_FILE, 'r');
            fseek($fd, - self::MAX_LOG_SIZE, SEEK_END);
            $data = fgets($fd);
            $data = fread($fd, self::MAX_LOG_SIZE);
            fclose($fd);

            $entry = $timestamp . ' ' . $LANG_SX00['logcleared'] . " \n"
                   . $data;
            file_put_contents($_CONF['path_log'] . self::LOG_FILE, $entry, LOCK_EX);
        }

        $display .= '<hr' . XHTML . '><pre>'
                 .  file_get_contents($_CONF['path_log'] . self::LOG_FILE)
                 .  '</pre>';

        return $display;
    }
}

?>
