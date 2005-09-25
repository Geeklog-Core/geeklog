<?php

/**
* file:  MassDelete.Admin.class.php
* Mass delete comment spam
*
* Copyright (C) 2004-2005 by the following authors:
*
* @ Author		Tom Willett		tomw AT pigstye DOT net
*
* Licensed under GNU General Public License
*
* $Id: MassDelete.Admin.class.php,v 1.6 2005/09/25 16:41:28 dhaun Exp $
*/

require_once($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');


class MassDelete extends BaseAdmin {
	/**
	* Constructor
	*
	*/
	function display(){
		global $_CONF, $_POST, $_TABLES, $LANG_SX00;

		$display = $LANG_SX00['masshead'];

		$act = $_POST['action'];
		$lmt = $_POST['limit'];

		if (($act == $LANG_SX00['deletespam']) && ($lmt>0)) {
			$numc = 0;
			if ($dir = @opendir($_CONF['path'] . 'plugins/spamx/')) {
				while(($file = readdir($dir)) !== false) {
					if (is_file($_CONF['path'] . 'plugins/spamx/' . $file))
					{
						if (substr($file,-18) == '.Examine.class.php') {
				        	$tmp = str_replace(".Examine.class.php","",$file);
							$Spamx_Examine[]=$tmp;
						}
					}
				}
				closedir($dir);
			}
			$result = DB_query("SELECT * from {$_TABLES['comments']} ORDER by Date DESC LIMIT $lmt");
			$nrows = DB_numRows($result);
			for($i=1;$i<=$nrows;$i++) {
				$A=DB_fetchArray($result);
		        foreach($Spamx_Examine as $Examine) {
					$filename=$Examine . '.Examine.class.php';
        	        if (file_exists($_CONF['path'] . 'plugins/spamx/' . $filename)) {
            	    	require_once($_CONF['path'] . 'plugins/spamx/' . $filename);
						$EX = new $Examine;
						$res = $EX->execute($A['comment']);
						if ($res == 1) {
							break;
						}
					}
				}
				if ($res == 1) {
					$this->delcomment($A['cid'], $A['sid'], $A['type']);
					$numc = $numc + 1;
				}
			}
			$display .= $numc . $LANG_SX00['comdel'];
		} else {
			$display .= '<form method="post" action="' . $_CONF['site_admin_url'] . '/plugins/spamx/index.php?command=MassDelete">';
			$display .= $LANG_SX00['numtocheck'] . "&nbsp;&nbsp&nbsp" . ' <select name="limit">';
			$display .= '<option value = "10">10</option><option value="50">50</option>';
			$display .= '<option value = "100" selected="selected">100</option><option value="200">200</option>';
			$display .= '<option value = "300">300</option><option value="400">400</option>';
			$display .= '</select>';
			$display .= $LANG_SX00['note1'];
			$display .= $LANG_SX00['note2'];
			$display .= $LANG_SX00['note3'];
			$display .= $LANG_SX00['note4'];
			$display .= $LANG_SX00['note5'];
			$display .= $LANG_SX00['note6'];
			$display .= '<input type = "Submit" name="action" value="' . $LANG_SX00['deletespam'] . '">';
			$display .= '</form>';
		}

		return $display;

	}

	function link()
	{
		global $LANG_SX00;
		return "Mass Delete Spam Comments";
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
	function delcomment ($cid, $sid, $type)
	{
	    global $_REQUEST, $_TABLES, $_CONF;

        $type = COM_applyFilter ($type);
        $sid = COM_applyFilter ($sid);
        switch ( $type ) {
            case 'article':
                $has_editPermissions = SEC_hasRights ('story.edit');
                $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$_TABLES['stories']} WHERE sid = '$sid'");
                $A = DB_fetchArray ($result);

                if ($has_editPermissions && SEC_hasAccess ($A['owner_id'],
                        $A['group_id'], $A['perm_owner'], $A['perm_group'],
                        $A['perm_members'], $A['perm_anon']) == 3) {
                    CMT_deleteComment(COM_applyFilter($cid, true), $sid, 'article');
                    $comments = DB_count ($_TABLES['comments'], 'sid', $sid);
                    DB_change ($_TABLES['stories'], 'comments', $comments,
                               'sid', $sid);
                    $display .= COM_refresh (COM_buildUrl ($_CONF['site_url']
                                    . "/article.php?story=$sid") . '#comments');
                } else {
                    COM_errorLog ("User {$_USER['username']} (IP: {$_SERVER['REMOTE_ADDR']}) "
                                . "tried to illegally delete comment $cid from $type $sid");
                    $display .= COM_refresh ($_CONF['site_url'] . '/index.php');
                }
                break;
            default: //assume plugin
                if ( !($display = PLG_commentDelete($type,
                                    COM_applyFilter($cid, true), $sid)) ) {
                    $display = COM_refresh ($_CONF['site_url'] . '/index.php');
                }
                break;
        }
    	SPAMX_log($LANG_SX00['spamdeleted']);
	}
}

?>
