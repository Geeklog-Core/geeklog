<?php
/* 
V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence. See License.txt. 
  Set tabs to 4 for best viewing.
  
  Latest version is available at http://php.weblogs.com/
  
  Microsoft Access data driver. Requires ODBC. Works only on MS Windows.
*/
if (!defined('_ADODB_ODBC_LAYER')) {
	include(ADODB_DIR."/drivers/adodb-odbc.inc.php");
}
 if (!defined('_ADODB_ACCESS')) {
 	define('_ADODB_ACCESS',1);
	
class  ADODB_access extends ADODB_odbc {	
	var $databaseType = 'access';
	var $hasTop = 'top';		// support mssql SELECT TOP 10 * FROM TABLE
	var $fmtDate = "#Y-m-d#";
	var $fmtTimeStamp = "#Y-m-d h:i:sA#"; // note not comma
	var $_bindInputArray = false; // strangely enough, setting to true does not work reliably
	var $sysDate = "FORMAT(NOW,'yyyy-mm-dd')";
	var $sysTimeStamp = 'NOW';
	
	function ADODB_access()
	{
		$this->ADODB_odbc();
	}
	
	function BeginTrans() { return false;}
	
	function &MetaTables()
	{
	global $ADODB_FETCH_MODE;
	
		$savem = $ADODB_FETCH_MODE;
		$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
		$qid = odbc_tables($this->_connectionID);
		$ADODB_FETCH_MODE = $savem;
		$rs = new ADORecordSet_odbc($qid);
		if (!$rs) return false;
		
		$rs->_has_stupid_odbc_fetch_api_change = $this->_has_stupid_odbc_fetch_api_change;
		
		$arr = &$rs->GetArray();
		
		$arr2 = array();
		for ($i=0; $i < sizeof($arr); $i++) {
			if ($arr[$i][2] && substr($arr[$i][2],0,4) != 'MSys')
				$arr2[] = $arr[$i][2];
		}
		return $arr2;
	}
}

 
class  ADORecordSet_access extends ADORecordSet_odbc {	
	
	var $databaseType = "access";		
	
	function ADORecordSet_access($id)
	{
		return $this->ADORecordSet_odbc($id);
	}
}
} // class
?>