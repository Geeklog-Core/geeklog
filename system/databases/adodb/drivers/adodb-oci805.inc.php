<?php
/** 
 * @version V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
 * Released under both BSD license and Lesser GPL library license. 
 * Whenever there is any discrepancy between the two licenses, 
 * the BSD license will take precedence. 
 *
 * Set tabs to 4 for best viewing.
 * 
 * Latest version is available at http://php.weblogs.com
 *
 * Oracle 8.0.5 driver
*/

include_once(ADODB_DIR.'/drivers/adodb-oci8.inc.php');

class ADODB_oci805 extends ADODB_oci8 {
	var $databaseType = "oci805";	
	var $connectSID = true;
	
	function &SelectLimit($sql,$nrows=-1,$offset=-1, $inputarr=false,$arg3=false,$secs2cache=0)
	{
		// seems that oracle only supports 1 hint comment in 8i
		if (strpos($sql,'/*+') !== false)
			$sql = str_replace('/*+ ','/*+FIRST_ROWS ',$sql);
		else
			$sql = preg_replace('/^[ \t\n]*select/i','SELECT /*+FIRST_ROWS*/',$sql);
		
		/* 
			The following is only available from 8.1.5 because order by in inline views not 
			available before then...
			http://www.jlcomp.demon.co.uk/faq/top_sql.html
		if ($nrows > 0) {	
			if ($offset > 0) $nrows += $offset;
			$sql = "select * from ($sql) where rownum <= $nrows";
			$nrows = -1;
		}
		*/

		return ADOConnection::SelectLimit($sql,$nrows,$offset,$inputarr,$arg3,$secs2cache);
	}
}

class ADORecordset_oci805 extends ADORecordset_oci8 {	
	var $databaseType = "oci805";
	function ADORecordset_oci805($id)
	{
		$this->ADORecordset_oci8($id);
	}
}
?>