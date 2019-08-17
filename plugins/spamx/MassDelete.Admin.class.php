<?php

/**
 * File:  MassDelete.Admin.class.php
 * Mass delete comment spam
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

// Include Abstract Base Class and comment library
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';
require_once $_CONF['path_system'] . 'lib-comment.php';

/**
 * MassDelete class: Mass-delete comments
 *
 * @package Spam-X
 */
class MassDelete extends BaseAdmin
{
    public function __construct()
    {
        global $LANG_SX00;

        $this->moduleName = '';
        $this->command = 'MassDelete';
        $this->titleText = '';
        $this->linkText = $LANG_SX00['mass_delete_spam_comments'];
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
        $template->set_file('massdelete', 'massdelete.thtml');
        
        $template->set_var('lang_title', $LANG_SX00['masshead']);        
        
        $act = Geeklog\Input::fPost('action', '');
        $lmt = (int) Geeklog\Input::fPost('limit', 0);

        if (($act === $LANG_SX00['deletespam']) && ($lmt > 0) &&
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

            $result = DB_query("SELECT comment,cid,sid,type,UNIX_TIMESTAMP(date) as date,ipaddress FROM {$_TABLES['comments']} ORDER BY date DESC LIMIT $lmt");
            $numRows = DB_numRows($result);

            for ($i = 0; $i < $numRows; $i++) {
                $A = DB_fetchArray($result);

                foreach ($Spamx_Examine as $Examine) {
                    $EX = new $Examine;

                    if (method_exists($EX, 'reexecute')) {
                        $res = $EX->reexecute($A['comment'], $A['date'], $A['ipaddress'], $A['type']);
                    } else {
                        $res = $EX->execute($A['comment']);
                    }

                    if ($res == PLG_SPAM_FOUND) {
                        break;
                    }
                }

                if ($res == PLG_SPAM_FOUND) {
                    $this->delcomment($A['cid'], $A['sid'], $A['type']);
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

        return $template->finish($template->parse('output', 'massdelete'));
    }

    /**
     * Deletes a given comment
     * (lifted from comment.php)
     *
     * @param    int    $cid  Comment ID
     * @param    string $sid  ID of object comment belongs to
     * @param    string $type Comment type (e.g. article, poll, etc)
     */
    public function delcomment($cid, $sid, $type)
    {
        global $_TABLES, $LANG_SX00, $_USER;

        $type = COM_applyFilter($type);
        $sid = COM_applyFilter($sid);

        switch ($type) {
            case 'article':
                $has_editPermissions = SEC_hasRights('story.edit');
                $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'");
                $A = DB_fetchArray($result);

                if ($has_editPermissions && SEC_hasAccess($A['owner_id'],
                        $A['group_id'], $A['perm_owner'], $A['perm_group'],
                        $A['perm_members'], $A['perm_anon']) == 3
                ) {
                    CMT_deleteComment(COM_applyFilter($cid, true), $sid, 'article');
                    $comments = DB_count($_TABLES['comments'],
                        array('sid', 'type'), array($sid, 'article'));
                    DB_change($_TABLES['stories'], 'comments', $comments, 'sid', $sid);
                } else {
                    COM_errorLog("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) tried to illegally delete comment $cid from $type $sid");
                }

                break;

            default: // assume plugin
                PLG_commentDelete($type, COM_applyFilter($cid, true), $sid);
                break;
        }

        SPAMX_log($LANG_SX00['spamdeleted']);
    }
}
