<?php
/* 
V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
Released under both BSD license and Lesser GPL library license. 
Whenever there is any discrepancy between the two licenses, 
the BSD license will take precedence. See License.txt. 
Set tabs to 4 for best viewing.
  
  Latest version is available at http://php.weblogs.com/
  
    Microsoft Access ADO data driver. Requires ADO and ODBC. Works only on MS Windows.
*/

if (!defined('_ADODB_ADO_LAYER')) {
	include(ADODB_DIR."/drivers/adodb-ado.inc.php");
}

class  ADODB_ado_access extends ADODB_ado {	
	var $databaseType = 'ado_access';
	var $hasTop = 'top';		// support mssql SELECT TOP 10 * FROM TABLE
	var $fmtDate = "#Y-m-d#";
	var $fmtTimeStamp = "#Y-m-d h:i:sA#";// note no comma

	function ADODB_ado_access()
	{
	}
	
	function BeginTrans() { return false;}

}

 
class  ADORecordSet_ado_access extends ADORecordSet_ado {	
	
	var $databaseType = "ado_access";		
	
	function ADORecordSet_ado_access(&$id)
	{
		return $this->ADORecordSet_ado($id);
	}
}
?>