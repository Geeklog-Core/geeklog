<?php
/**
* File: Config.Admin.class.php
* This is configures the modules used by the Geeklog SpamX Plug-in!
*
* Copyright (C) 2004 by the following authors:
*
* @ Author		Tom Willett		tomw@pigstye.net
*
* Licensed under GNU General Public License
*
*/
/**
* SpamX config module
*
*/

require_once($_CONF['path'] . 'plugins/spamx/BaseAdmin.class.php');

class Config extends BaseAdmin {
	/**
	* Constructor
	* 
	*/
	function display(){
		global $_CONF, $HTTP_GET_VARS, $_TABLES, $LANG_SX00;
		
		require_once($_CONF['path'] . 'plugins/spamx/ArrayWriter.class.php');
		// Set up Spamx_Actiona dn SpamX_Examine arrays
		$result=DB_query("SELECT * FROM {$_TABLES['spamx']} WHERE name='Action'");
		$nrows = DB_numRows($result);
		for ($i=1;$i<=$nrows;$i++) {
			$A=DB_fetchArray($result);
			$Spamx_Action[]=$A['value'];
		}
	    $result=DB_query("SELECT * FROM {$_TABLES['spamx']} WHERE name='Examine'");
    	$nrows = DB_numRows($result);
	    for ($i=1;$i<=$nrows;$i++) {
    	    $A=DB_fetchArray($result);
        	$Spamx_Examine[]=$A['value'];
	    }   
 
		// Handle possible actions

		$action = SPAMX_applyFilter($HTTP_GET_VARS['action']);
		$item = SPAMX_applyFilter($HTTP_GET_VARS['item']);
		$Eflg=0;
		$Aflg=0;
		if ($action == 'Edel') {
			$ta = array();
			$Eflg=1;
			foreach($Spamx_Examine as $it) {
				if ($it != $item) {
					$ta[]=$it;
				} else {
					$result = DB_query('DELETE FROM ' . $_TABLES['spamx'] . ' where name="Examine" AND value="' . $item . '"');
				}
			}
			$Spamx_Examine=$ta;
		} elseif ($action == 'Eadd'){
			$Spamx_Examine[]=$item;
			$result = DB_query('INSERT INTO ' . $_TABLES['spamx'] . ' VALUES ("Examine","' . $item . '")');
		} elseif ($action == 'Adel') {
			$ta = array();
			$Aflg=1;
			foreach($Spamx_Action as $it) {
				if ($it != $item) {
					$ta[]=$it;
                } else {
                    $result = DB_query('DELETE FROM ' . $_TABLES['spamx'] . ' where name="Action" AND value="' . $item . '"');
                }
                                                    
			}
			$Spamx_Action=$ta;
		} elseif ($action == 'Aadd'){
			$Spamx_Action[]=$item;
			$result = DB_query('INSERT INTO ' . $_TABLES['spamx'] . ' VALUES ("Action","' . $item . '")');
		}
		//Make File array and display Examine Modules
		$sfiles = array();
		$self = $_CONF['site_admin_url'] . '/plugins/spamx/index.php';
		if ($dir = @opendir($_CONF['path'] . 'plugins/spamx/')) {
    			while(($file = readdir($dir)) !== false) {
        			if (is_file($_CONF['path'] . 'plugins/spamx/' . $file)) 
       				{ 
        				if (substr($file,-18) == '.Examine.class.php') {
	        				$sfiles[] = str_replace(".Examine.class.php","",$file);
	        			}
        			}
    			}
    			closedir($dir);
		}
		$cnt = count($sfiles) - count($Spamx_Examine);
		if ($cnt > 0) {
			do {
				$cnt = $cnt-1;
				$Spamx_Examine[]="";
			} while ($cnt>0);
		}
		if ($cnt < 0) {
			do {
				$cnt = $cnt+1;
				$sfiles[]="";
			} while ($cnt<0);
		}
		$display = $LANG_SX00['coninst'];
		$display .= '<p align="center"><b>';
		$display .= $LANG_SX00['exmod'];
		$display .= '</b></p><table width="100%" border="1">';
		$display .= '<tr><td><b>';
		$display .= $LANG_SX00['actmod'];
		$display .= '</b></td><td><b>';
		$display .= $LANG_SX00['avmod'];
		$display .= '</b></td></tr>';
		foreach($Spamx_Examine as $it) {
			$sfile = each($sfiles);
			$display .= '<tr><td><a href="' . $self . '?command=Config&action=Edel&item=' . urlencode($it) . '">' . $it . '</a></td>';
			$display .= '<td><a href="' . $self . '?command=Config&action=Eadd&item=' . urlencode($sfile[1]) . '">' . $sfile[1] . '</a></td></tr>';
		}
		$display .= '</table>';
		// Make Array and display Action Modules
		$sfiles = array();
		if ($dir = @opendir($_CONF['path'] . 'plugins/spamx/')) {
    			while(($file = readdir($dir)) !== false) {
        			if (is_file($_CONF['path'] . 'plugins/spamx/' . $file)) 
       				{ 
        				if (substr($file,-17) == '.Action.class.php') {
	        				$sfiles[] = str_replace(".Action.class.php","",$file);
	        			}
        			}
    			}
    			closedir($dir);
		}
		$cnt = count($sfiles) - count($Spamx_Action);
		if ($cnt > 0) {
			do {
				$cnt = $cnt-1;
				$Spamx_Action[]="";
			} while ($cnt>0);
		}
		if ($cnt < 0) {
			do {
				$cnt = $cnt+1;
				$sfiles[]="";
			} while ($cnt<0);
		}
		$display .= '<p>';
		$display .= $LANG_SX00['coninst'];
		$display .= '<p align="center"><b>';
		$display .= $LANG_SX00['acmod'];
		$display .= '</b></p><table width="100%" border="1">';
		$display .= '<tr><td><b>';
		$display .= $LANG_SX00['actmod'];
		$display .= '</b></td><td><b>';
		$display .= $LANG_SX00['avmod'];
		$display .= '</b></td></tr>';
		foreach($Spamx_Action as $it) {
			$sfile = each($sfiles);
			$display .= '<tr><td><a href="' . $self . '?command=Config&action=Adel&item=' . urlencode($it) . '">' . $it . '</a></td>';
			$display .= '<td><a href="' . $self . '?command=Config&action=Aadd&item=' . urlencode($sfile[1]) . '">' . $sfile[1] . '</a></td></tr>';
		}
		$display .= '</table>';
		return $display;

	}
	
	function link()
	{
        global $LANG_SX00;
		
		return $LANG_SX00['conmod'];
	}
}

?>