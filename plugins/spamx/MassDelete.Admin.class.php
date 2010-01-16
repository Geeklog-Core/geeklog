<?php

/**
* File:  MassDelete.Admin.class.php
* Mass delete comment spam
*
* Copyright (C) 2004-2008 by the following authors:
*
* Author        Tom Willett        tomw AT pigstye DOT net
*
* Licensed under GNU General Public License
*
* @package Spam-X
* @subpackage Modules
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'massdelete.admin.class.php') !== false) {
    die('This file can not be used on its own!');
}

/**
* Include Abstract Base Class and comment library
*/
require_once $_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php';
require_once $_CONF['path_system'] . 'lib-comment.php';

/**
* MassDelete class: Mass-delete comments
*
* @package Spam-X
*
*/
class MassDelete extends BaseAdmin {
    /**
    * Constructor
    *
    */
    function display()
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $display = $LANG_SX00['masshead'];

        $act = '';
        if (isset($_POST['action'])) {
            $act = COM_applyFilter($_POST['action']);
        }
        $lmt = 0;
        if (isset($_POST['limit'])) {
            $lmt = COM_applyFilter($_POST['limit'], true);
        }

        if (($act == $LANG_SX00['deletespam']) && ($lmt > 0) &&
                SEC_checkToken()) {
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
            $nrows = DB_numRows($result);
            for ($i = 0; $i < $nrows; $i++) {
                $A = DB_fetchArray($result);
                foreach ($Spamx_Examine as $Examine) {
                    $EX = new $Examine;
                    if(method_exists($EX, 'reexecute'))
                    {
                    	$res = $EX->reexecute($A['comment'], $A['date'], $A['ipaddress'], $A['type']);
                    } else {
                    	$res = $EX->execute($A['comment']);
                    }
                    if ($res == 1) {
                        break;
                    }
                }
                if ($res == 1) {
                    $this->delcomment($A['cid'], $A['sid'], $A['type']);
                    $numc = $numc + 1;
                }
            }
            $display .= '<p>' . $numc . $LANG_SX00['comdel'] . '</p>' . LB;
        } else {
            $token = SEC_createToken();
            $display .= '<form method="post" action="'
                     .  $_CONF['site_admin_url']
                     .  '/plugins/spamx/index.php?command=MassDelete"><div>';
            $display .= $LANG_SX00['numtocheck'] . '&nbsp;&nbsp;&nbsp;'
                     .  ' <select name="limit">' . LB;
            $display .= '<option value="10">10</option>' . LB
                     .  '<option value="50">50</option>' . LB
                     .  '<option value="100" selected="selected">100</option>'
                     .  LB
                     .  '<option value="200">200</option>' . LB
                     .  '<option value="300">300</option>' . LB
                     .  '<option value="400">400</option>' . LB;
            $display .= '</select>' . LB;
            $display .= $LANG_SX00['note1'];
            $display .= $LANG_SX00['note2'];
            $display .= $LANG_SX00['note3'];
            $display .= $LANG_SX00['note4'];
            $display .= $LANG_SX00['note5'];
            $display .= $LANG_SX00['note6'] . LB;
            $display .= '<input type="submit" name="action" value="'
                     . $LANG_SX00['deletespam'] . '"' . XHTML . '>' . LB;
            $display .= '<input type="hidden" name="' . CSRF_TOKEN
                 . "\" value=\"{$token}\"" . XHTML . '>' . LB;
            $display .= '</div></form>' . LB;
        }

        return $display;
    }

    function link()
    {
        return 'Mass Delete Spam Comments';
    }

    /**
    * Deletes a given comment
    * (lifted from comment.php)
    * @param    int         $cid    Comment ID
    * @param    string      $sid    ID of object comment belongs to
    * @param    string      $type   Comment type (e.g. article, poll, etc)
    * @return   string      Returns string needed to redirect page to right place
    *
    */
    function delcomment($cid, $sid, $type)
    {
        global $_CONF, $_TABLES, $LANG_SX00;

        $type = COM_applyFilter($type);
        $sid = COM_applyFilter($sid);

        switch ($type) {
        case 'article':
            $has_editPermissions = SEC_hasRights('story.edit');
            $result = DB_query("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'");
            $A = DB_fetchArray($result);

            if ($has_editPermissions && SEC_hasAccess($A['owner_id'],
                    $A['group_id'], $A['perm_owner'], $A['perm_group'],
                    $A['perm_members'], $A['perm_anon']) == 3) {
                CMT_deleteComment(COM_applyFilter($cid, true), $sid, 'article');
                $comments = DB_count($_TABLES['comments'],
                        array('sid', 'type'), array($sid, 'article'));
                DB_change($_TABLES['stories'], 'comments', $comments,
                          'sid', $sid);
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

?>
