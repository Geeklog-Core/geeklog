<?php
/**
 * File: Logview.Admin.class.php
 * This is the LogViewer for the Geeklog SpamX Plug-in!
 * 
 * Copyright (C) 2004 by the following authors:
 * Author		Tom Willett		tomw@pigstye.net
 * 
 * Licensed under GNU General Public License
 */

require_once($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');

class LogView extends BaseAdmin {
    /**
     * Constructor
     */
    function display()
    {
        global $_CONF, $HTTP_POST_VARS, $LANG_SX00;

        $action = COM_applyFilter($HTTP_POST_VARS['action']);
        $path = $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=LogView';
        $log = 'spamx.log';
        $display .= "<form method=\"post\" action=\"{$path}\">";
        $display .= "<input type=\"submit\" name=\"action\" value=\"{$LANG_SX00['clearlog']}\">";
        $display .= "</form>";
        if ($action == $LANG_SX00['clearlog']) {
            $timestamp = strftime("%c");
            $fd = fopen($_CONF['path_log'] . $log, "w");
            fputs($fd, "$timestamp {$LANG_SX00['logcleared']} \n");
            fclose($fd);
        } 
        $display .= "<hr><pre>";
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