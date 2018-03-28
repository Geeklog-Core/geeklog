<?php

/**
 * File:  MassDelTrackback.Admin.class.php
 * Mass delete trackback spam
 * Copyright (C) 2004-2017 by the following authors:
 *
 * @author     Tom Willett     tomw AT pigstye DOT net
 * @author     Dirk Haun       dirk AT haun-online DOT de
 *             Licensed under GNU General Public License
 * @package    Spam-X
 * @subpackage Modules
 */

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

// Include Abstract Base Class
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';

/**
 * MassDelTrackback class: Mass-delete trackbacks
 *
 * @package Spam-X
 */
class MassDelTrackback extends BaseAdmin
{
    public function __construct()
    {
        global $LANG_SX00;

        $this->moduleName = '';
        $this->command = 'MassDelTrackback';
        $this->titleText = '';
        $this->linkText = $LANG_SX00['mass_delete_trackback_spam'];
    }

    /**
     * Return HTML widget
     *
     * @return string
     */
    public function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $template = COM_newTemplate(CTL_plugin_templatePath('spamx'));
        $template->set_file('massdeltrackback', 'massdeltrackback.thtml');
        
        $template->set_var('lang_title', $LANG_SX00['masstb']);        

        $act = Geeklog\Input::fPost('action', '');
        $lmt = (int) Geeklog\Input::fPost('limit', 0);
        
        if (($act == $LANG_SX00['deletespam']) && ($lmt > 0) &&
            SEC_checkToken()
        ) {
            $numc = 0;
            $spamx_path = $_CONF['path'] . 'plugins/spamx/';

            if ($dir = @opendir($spamx_path)) {
                while (($file = readdir($dir)) !== false) {
                    if (is_file($spamx_path . $file)) {
                        if (substr($file, -18) == '.Examine.class.php') {
                            $tmp = str_replace('.Examine.class.php', '', $file);
                            $Spamx_Examine[] = $tmp;

                            require_once $spamx_path . $file;
                        }
                    }
                }

                closedir($dir);
            }

            require_once $_CONF['path_system'] . 'lib-trackback.php';

            $result = DB_query("SELECT cid,sid,type,url,title,blog,excerpt,ipaddress,UNIX_TIMESTAMP(date) AS date FROM {$_TABLES['trackback']} ORDER BY date DESC LIMIT $lmt");
            $numRows = DB_numRows($result);

            for ($i = 0; $i < $numRows; $i++) {
                $A = DB_fetchArray($result);
                $comment = TRB_formatComment($A['url'], $A['title'],
                    $A['blog'], $A['excerpt']);

                foreach ($Spamx_Examine as $Examine) {
                    $EX = new $Examine;

                    if (method_exists($EX, 'reexecute')) {
                        $res = $EX->reexecute($comment, $A['date'], $A['ipaddress'], $A['type']);
                    } else {
                        $res = $EX->execute($comment);
                    }

                    if ($res == PLG_SPAM_FOUND) {
                        break;
                    }
                }

                if ($res == PLG_SPAM_FOUND) {
                    $this->deltrackback($A['cid'], $A['sid'], $A['type']);
                    $numc++;
                }
            }

            $template->set_var('num_comments', $numc);
            $template->set_var('lang_comments_deleted', $LANG_SX00['comdel']);            
        } else {
            $template->set_var('lang_num_to_check', $LANG_SX00['numtocheck']);
            
            $options = '<option value="10">10</option>' . LB
                . '<option value="50">50</option>' . LB
                . '<option value="100" selected="selected">100</option>'
                . LB
                . '<option value="200">200</option>' . LB
                . '<option value="300">300</option>' . LB
                . '<option value="400">400</option>' . LB;
            $template->set_var('limit_options', $options);

            $template->set_var('lang_note1', $LANG_SX00['note1']);
            $template->set_var('lang_note2', $LANG_SX00['note2']);
            $template->set_var('lang_note3', $LANG_SX00['note3']);
            $template->set_var('lang_note4', $LANG_SX00['note4']);
            $template->set_var('lang_note5', $LANG_SX00['note5']);
            $template->set_var('lang_note6', $LANG_SX00['note6']);
            
            
            $template->set_var('lang_delete_spam', $LANG_SX00['deletespam']);
            $template->set_var('gltoken_name', CSRF_TOKEN);
            $template->set_var('gltoken', SEC_createToken());
        }

        return $template->finish($template->parse('output', 'massdeltrackback'));
    }

    /**
     * Deletes a given trackback comment
     *
     * @param    int    $cid  Comment ID
     * @param    string $sid  ID of object comment belongs to
     * @param    string $type Comment type (e.g. article, poll, etc)
     * @return   void
     */
    public function deltrackback($cid, $sid, $type)
    {
        global $_TABLES, $LANG_SX00;

        if (TRB_allowDelete($sid, $type)) {
            TRB_deleteTrackbackComment($cid);

            if ($type === 'article') {
                $tbcount = DB_count($_TABLES['trackback'],
                    array('type', 'sid'),
                    array('article', $sid));
                DB_query("UPDATE {$_TABLES['stories']} SET trackbacks = $tbcount WHERE sid = '$sid'");
            }

            SPAMX_log($LANG_SX00['spamdeleted']);
        }
    }
}
