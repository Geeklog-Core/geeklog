<?php
/* 
V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence. 
Set tabs to 4 for best viewing.
  
  Latest version is available at http://php.weblogs.com/
  
  Microsoft Visual FoxPro data driver. Requires ODBC. Works only on MS Windows.
*/

if (!defined('_ADODB_ODBC_LAYER')) {
	include(ADODB_DIR."/drivers/adodb-odbc.inc.php");
}
if (!defined('ADODB_VFP')){
define('ADODB_VFP',1);
class ADODB_vfp extends ADODB_odbc {
	var $databaseType = "vfp";	
	var $fmtDate = "{^Y-m-d}";
	var $fmtTimeStamp = "{^Y-m-d, h:i:sA}";
	var $replaceQuote = "'+chr(39)+'" ;
	var $true = '.T.';
	var $false = '.F.';
	var $hasTop = 'top';		// support mssql SELECT TOP 10 * FROM TABLE
	var $upperCase = 'upper';
	var $_bindInputArray = false; // strangely enough, setting to true does not work reliably
	var $sysTimeStamp = 'datetime()';
	var $sysDate = 'date()';
	
	function ADODB_vfp()
	{
		$this->ADODB_odbc();
	}
	
	function BeginTrans() { return false;}

	// quote string to be sent back to database
	function qstr($s,$nofixquotes=false)
	{
		if (!$nofixquotes) return  "'".str_replace("\r\n","'+chr(13)+'",str_replace("'",$this->replaceQuote,$s))."'";
		return "'".$s."'";
	}
	
	// TOP requires ORDER BY for VFP
	function &SelectLimit($sql,$nrows=-1,$offset=-1, $inputarr=false,$arg3=false,$secs2cache=0)
	{
		if (!preg_match('/ORDER[ \t\r\n]+BY/i',$sql)) $sql .= ' ORDER BY 1';
		return ADOConnection::SelectLimit($sql,$nrows,$offset,$inputarr,$arg3,$secs2cache);
	}


};
 

class  ADORecordSet_vfp extends ADORecordSet_odbc {	
	
	var $databaseType = "vfp";		

	
	function ADORecordSet_vfp($id)
	{
		return $this->ADORecordSet_odbc($id);
	}

	function MetaType($t,$len=-1)
	{
		switch (strtoupper($t)) {
		case 'C':
			if ($len <= $this->blobSize) return 'C';
		case 'M':
			return 'X';
			 
		case 'D': return 'D';
		
		case 'T': return 'T';
		
		case 'L': return 'L';
		
		case 'I': return 'I';
		
		default: return 'N';
		}
	}
}

} //define
?>