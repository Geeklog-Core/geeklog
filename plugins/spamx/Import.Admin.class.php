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


class Import extends BaseAdmin {
	/**
	* Constructor
	* 
	*/
	function display(){
		global $_CONF, $rss_url, $_TABLES, $LANG_SX00;
		
		require_once($_CONF['path'] . 'plugins/spamx/magpierss/rss_fetch.inc');
		require_once($_CONF['path'] . 'plugins/spamx/magpierss/rss_utils.inc');
		
		$rss = fetch_rss($rss_url);
		// entries to add and delete, according to the blacklist changes feed
		$to_add = array();
		$to_delete = array();

		foreach( $rss->items as $item ) {
			// time this entry was published (currently unused)
			//  $published_time = parse_w3cdtf( $item['dc']['date'] );

			$entry = substr( $item['description'], 0, -3 );  // blacklist entry
			$subject = $item['dc']['subject'];  // indicates addition or deletion

			// is this an addition or a deletion?
			if( strpos( $subject, 'addition' ) !== false ) {
				// save it to database
				$result = DB_query('SELECT * FROM ' . $_TABLES['spamx'] . ' WHERE name="MTBlacklist" AND value="' . $entry . '"');
				$nrows = DB_numRows($result);
				if ($nrows < 1) {
					$result = DB_query('INSERT INTO ' . $_TABLES['spamx'] . ' VALUES ("MTBlacklist","' . $entry . '")');
					$to_add[]=$entry;
				}
			} else if( strpos( $subject, 'deletion' ) !== false ) {
				// delete it from database
				$result = DB_query('SELECT * FROM ' . $_TABLES['spamx'] . ' where name="MTBlacklist" AND value="' . $entry . '"');
				$nrows = DB_numRows($result);
				if ($nrows >= 1) {
					$result = DB_query('DELETE FROM ' . $_TABLES['spamx'] . ' where name="MTBlacklist" AND value="' . $entry . '"');
					$to_delete[]=$entry;
				}
			}
		}
		$display = '<hr><p><b>' . $LANG_SX00['entriesadded'] . '</b></p><ul>';
		foreach ($to_add as $e) {
			$display .= "<li>$e</li>";
		}
		$display .= '</ul><p><b>' . $LANG_SX00['entriesdeleted'] . '</b></p><ul>';
		foreach ($to_delete as $e) {
			$display .= "<li>$e</li>";
		}
		$display .= '</ul>';
		SPAMX_log($LANG_SX00['uMTlist'] . $LANG_SX00['uMTlist2'] . count($to_add) . $LANG_SX00['uMTlist3'] . count($to_delete) . $LANG_SX00['entries']);
		return $display;
	}
	
	function link()
	{
		global $LANG_SX00;
		return $LANG_SX00['uMTlist'];
	}
}

?>