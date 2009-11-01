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
class LogView extends BaseAdmin {
    /**
     * Constructor
     */
    function display()
    {
        global $_CONF, $LANG_SX00;

        $display = '';

        $max_Log_Size = 100000;
        $action = '';
        if (isset ($_POST['action'])) {
            $action = COM_applyFilter ($_POST['action']);
        }
        $path = $_CONF['site_admin_url']
              . '/plugins/spamx/index.php?command=LogView';
        $log = 'spamx.log';
        $display .= "<form method=\"post\" action=\"{$path}\"><div>";
        $display .= "<input type=\"submit\" name=\"action\" value=\"{$LANG_SX00['clearlog']}\"" . XHTML . ">";
        $display .= "</div></form>";
        if ($action == $LANG_SX00['clearlog']) {
            $timestamp = strftime("%c");
            $fd = fopen($_CONF['path_log'] . $log, "w");
            fputs($fd, "$timestamp {$LANG_SX00['logcleared']} \n");
            fclose($fd);
        }
        $fsize = filesize($_CONF['path_log'] . $log);
        if ($fsize > $max_Log_Size) {
          $fd=fopen($_CONF['path_log'] . $log, "r");
          fseek($fd,-$max_Log_Size,SEEK_END);
          $data = fgets($fd);
          $data = fread($fd,$max_Log_Size);
          fclose($fd);
          $fd = fopen($_CONF['path_log'] . $log, "w");
          fputs($fd, "$timestamp {$LANG_SX00['logcleared']} \n");
          fwrite($fd,$data);
          fclose($fd);
        }
        $display .= "<hr" . XHTML . "><pre>";
        $display .= implode('', file($_CONF['path_log'] . $log));
        $display .= "</pre>";
        return $display;
    }

    function link()
    {
        global $LANG_SX00;

        return $LANG_SX00['viewlog'];
    }
}

?>
