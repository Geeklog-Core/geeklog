<?php
/**
 * File: ViewBlacklist.Admin.class.php
 * This is a Module which allows you to view/import other blacklists. for the Geeklog SpamX Plug-in!
 * 
 * Copyright (C) 2004 by the following authors:
 * Author		Tom Willett		tomw@pigstye.net
 * 
 * Licensed under GNU General Public License
 */

require_once($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');

class ViewBlacklist extends BaseAdmin {
    /**
     * Constructor
     */
    function display()
    {
        global $_CONF, $_TABLES, $HTTP_GET_VARS, $HTTP_POST_VARS,
        $LANG_SX00, $_SPX_CONF;

        require_once($_CONF['path'] . 'plugins/spamx/magpierss/rss_fetch.inc');
        require_once($_CONF['path'] . 'plugins/spamx/magpierss/rss_utils.inc');
        require_once($_CONF['path'] . 'plugins/spamx/rss.inc.php');

        $result = DB_query("SELECT * FROM {$_TABLES['spamx']} WHERE name='Personal'");
        $nrows = DB_numRows($result);
        for($i = 1;$i <= $nrows;$i++) {
            $A = DB_fetchArray($result);
            $SPAMX_BLACKLIST[] = $A['value'];
        } 
        $action = COM_applyFilter($HTTP_GET_VARS['action']);
        $paction = COM_applyFilter($HTTP_POST_VARS['paction']);
        $site = COM_applyFilter($HTTP_GET_VARS['site']);
        $rss = fetch_rss($_SPX_CONF['spamx_rss_url']);
        if ($action == 'import') {
            $rdf = '';
            foreach($rss->items as $item) {
                if ($item['title'] == $site) {
                    $rdf = $item['rdf'];
                    break;
                } 
            } 
            if ($rdf != '') {
                $rss = fetch_rss($rdf);
                $i = 0;
                foreach($rss->items as $item) {
                    $result = DB_query('INSERT INTO ' . $_TABLES['spamx'] . ' VALUES ("Personal","' . $item['title'] . '")');
                    $SPAMX_BLACKLIST[] = $item['title'];
                    $i = $i + 1;
                } 
                Spamx_rss($SPAMX_BLACKLIST);
                SPAMX_log($LANG_SX00['add1'] . $i . $LANG_SX00['add2'] . $site . $LANG_SX00['add3']);
                return COM_refresh($_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=EditBlackList');
            } 
        } 
        if ($paction == 'Create Rss') {
            Spamx_rss($SPAMX_BLACKLIST);
            $display = $LANG_SX00['rsscreated'] . '<br>';
            $display .= '<form method="post" action="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=ViewBlackList">';
            $display .= '<input type="submit" name="paction" value="' . $LANG_SX00['ok'] . '">';
            $display .= '</form>';
            DB_query("Replace INTO " . $_TABLES['vars'] . " set name='spamx', value=1");
        } elseif (DB_getItem($_TABLES['vars'], 'value', 'name = "spamx"') == 1) {
            $display .= "<p><b>" . $LANG_SX00['availb'] . "</b></p><table border='1' cellpadding='4'>";
            $display .= '<tr><td>' . $LANG_SX00['clickv'] . '</td><td>' . $LANG_SX00['clicki'] . '</td></tr>';
            foreach($rss->items as $item) {
                $display .= '<tr><td><a href="' . $item['link'] . '">' . $item['title'] . '</a></td>';
                $display .= '<td><a href="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=ViewBlackList&action=import&site=' . urlencode($item['title']) . '">Import ' . $item['title'] . '</a></td></tr>';
            } 
            $display .= '</table>';
        } else {
            $display = '<p>' . $LANG_SX00['impinst1a'] . $LANG_SX00['impinst1b'] . '</p><p>';
            $display .= $LANG_SX00['impinst2'] . $LANG_SX00['impinst2a'] . $LANG_SX00['impinst2b'];
            $display .= $LANG_SX00['impinst2c'] . '</p>';
            $display .= $LANG_SX00['impinst3'];
            $display .= '<form method="post" action="' . $_SPX_CONF['spamx_submit_url'] . '">';
            $display .= '<table>';
            $display .= '<tr><td>' . $LANG_SX00['sitename'] . '</td><td><input type="text" size="45" name="site" value="' . $_CONF['site_name'] . '"></td></tr>';
            $display .= '<tr><td>' . $LANG_SX00['URL'] . '</td><td><input type="text" size="45" name="url" value="' . $_CONF['site_url'] . '/spamx/index.php"></td></tr>';
            $rdfpath = str_replace($_CONF['path_html'], "", dirname($_CONF['rdf_file']));
            $display .= '<tr><td>' . $LANG_SX00['RDF'] . '</td><td><input type="text" size="45" name="rdf" value="' . $_CONF['site_url'] . '/' . $rdfpath . '/spamx.rdf"></td></tr>';
            $display .= '</table>';
            $display .= '<input type="submit" name="paction" value="' . $LANG_SX00['submit'] . '"> ' . $LANG_SX00['subthis'];
            $display .= '</form>';
            $display .= '<p>This second button creates an rdf feed so that others can import your list.</p>';
            $display .= '<form method="post" action="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=ViewBlackList">';
            $display .= '<input type="submit" name="paction" value="Create Rss">';
            $display .= '</form>';
            $display .= $LANG_SX00['inst1'];
            $display .= $LANG_SX00['inst2'];
            $display .= $LANG_SX00['inst3'];
            $display .= $LANG_SX00['inst4'];
            $display .= $LANG_SX00['inst5'];
        } 
        return $display;
    } 

    function link()
    {
        return "View/Import Other SpamX Blacklists";
    } 
} 

?>
