<?php
/*
 V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence.
  Set tabs to 4.
  
  Postgres7 support.
  28 Feb 2001: Currently indicate that we support LIMIT
  01 Dec 2001: dannym added support for default values
*/

include_once(ADODB_DIR."/drivers/adodb-postgres64.inc.php");

class ADODB_postgres7 extends ADODB_postgres64 {
	var $databaseType = 'postgres7';	
	var $hasLimit = true;	// set to true for pgsql 6.5+ only. support pgsql/mysql SELECT * FROM TABLE LIMIT 10

	function ADODB_postgres7() 
	{
		
	}

	// the following should be compat with postgresql 7.2, 
	// which makes obsolete the LIMIT limit,offset syntax
	 function &SelectLimit($sql,$nrows=-1,$offset=-1,$inputarr=false,$arg3=false,$secs2cache=0) 
	 {
	  $offsetStr = ($offset >= 0) ? " OFFSET $offset" : '';
	  $limitStr  = ($nrows >= 0)  ? " LIMIT $nrows" : '';
	  return $secs2cache ?
	   $this->CacheExecute($secs2cache,$sql."$limitStr$offsetStr",$inputarr,$arg3)
	  :
	   $this->Execute($sql."$limitStr$offsetStr",$inputarr,$arg3);
	 }
 
 	// 10% speedup to move MoveNext to child class
	function MoveNext() 
	{
		if (!$this->EOF) {		
			$this->_currentRow++;
			$this->fields = @pg_fetch_array($this->_queryID,$this->_currentRow,$this->fetchMode);
			if (is_array($this->fields)) return true;
		}
		$this->EOF = true;
		return false;
	}	
}
	
/*--------------------------------------------------------------------------------------
	 Class Name: Recordset
--------------------------------------------------------------------------------------*/

class ADORecordSet_postgres7 extends ADORecordSet_postgres64{

	var $databaseType = "postgres7";

	function ADORecordSet_postgres7($queryID) 
	{
		$this->ADORecordSet_postgres64($queryID);
	}

}
?>
