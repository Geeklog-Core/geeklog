<?php
/**
* file:  Import.Admin.class.php
* MTBlacklist refresh module
*
* Updates Sites MT Blacklist via Master MT Blacklist rss feed
* 
* Copyright (C) 2004 by the following authors:
*
* @ Author		Tom Willett		tomw@pigstye.net
*
* Licensed under GNU General Public License
*
* Based on MT-Blacklist Updater by
* Cheah Chu Yeow (http://blog.codefront.net/)
*
*/

require_once($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');


class MassDelete extends BaseAdmin {
	/**
	* Constructor
	* 
	*/
	function display(){
		global $_CONF, $HTTP_POST_VARS, $_TABLES, $LANG_SX00;
		
		$display = $LANG_SX00['masshead'];

		$act = $HTTP_POST_VARS['action'];
		$lmt = $HTTP_POST_VARS['limit'];

		if (($act == $LANG_SX00['deletespam']) && ($lmt>0)) {
			$numc = 0;
		    $result=DB_query("SELECT * FROM {$_TABLES['spamx']} WHERE name='Examine'");
		    $nrows = DB_numRows($result);
		    for ($i=1;$i<=$nrows;$i++) {
		    	$A=DB_fetchArray($result);
		        $Spamx_Examine[]=$A['value'];
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
			$display .= '<option value = "10">10</option><option value="50" selected>50</option>';
			$display .= '<option value = "100" selected>100</option><option value="200">200</option>';
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
    	global $_CONF, $_TABLES, $_USER, $REMOTE_ADDR;

	    $retval = '';

	    if (is_numeric ($cid) && ($cid > 0) && !empty ($sid) && !empty ($type)) {

        	// only comments of type 'article' and 'poll' are handled by Geeklog
        	if (($type == 'article') || ($type == 'poll')) {

            	if ($type == 'article') {
                	$table = $_TABLES['stories'];
	                $idname = 'sid';
        	    } else {
            	    $table = $_TABLES['pollquestions'];
            	    $idname = 'qid';
    	        }
        	    $result = DB_query ("SELECT owner_id,group_id,perm_owner,perm_group,perm_members,perm_anon FROM {$table} WHERE {$idname} = '{$sid}'");
        	    $A = DB_fetchArray ($result);

           	    $pid = DB_getItem ($_TABLES['comments'], 'pid', "cid = '$cid'");

           	    DB_change ($_TABLES['comments'], 'pid', $pid, 'pid', $cid);
                DB_delete ($_TABLES['comments'], 'cid', $cid);

   	            if ($type == 'article') {
               	    $comments = DB_count ($_TABLES['comments'], 'sid', $sid);
               	    DB_change ($_TABLES['stories'], 'comments', $comments, 'sid', $sid);
   	            }
    	    } else {
        	    // See if plugin will handle this
        	    $retval = PLG_handlePluginComment ($type, $cid, 'delete');
	        }
			SPAMX_log($LANG_SX00['spamdeleted']);
	    }
	}
}

?>