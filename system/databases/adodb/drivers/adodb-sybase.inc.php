<?php
/* 
V2.00 13 May 2002 (c) 2000-2002 John Lim. All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence. 
  Set tabs to 4 for best viewing.
  
  Latest version is available at http://php.weblogs.com/
  
  Sybase driver contributed by Toni (toni.tunkkari@finebyte.com)
  
  - MSSQL date patch applied.
  
  Date patch by Toni 15 Feb 2002
*/
 
class ADODB_sybase extends ADOConnection {
	var $databaseType = "sybase";	
	var $replaceQuote = "''"; // string to use to replace quotes
	var $fmtDate = "'Y-m-d'";
	var $fmtTimeStamp = "'Y-m-d H:i:s'";
	var $hasInsertID = true;
    var $hasAffectedRows = true;
  	var $metaTablesSQL="select name from sysobjects where type='U' or type='V'";
	var $metaColumnsSQL = "select c.name,t.name,c.length from syscolumns c join systypes t on t.xusertype=c.xusertype join sysobjects o on o.id=c.id where o.name='%s'";
	var $concat_operator = '+'; 
	var $sysDate = 'GetDate()';
	var $arrayClass = 'ADORecordSet_array_sybase';
	var $sysDate = 'GetDate()';
	
	function ADODB_sybase() 
	{			
	}
 
    // might require begintrans -- committrans
    function _insertid()
    {
    	return $this->GetOne('select @@identity');
    }
      // might require begintrans -- committrans
    function _affectedrows()
    {
       return $this->GetOne('select @@rowcount');
    }

              
    function BeginTrans()
	{       
    	$this->Execute('BEGIN TRAN');
    	return true;
	}
	
	function CommitTrans($ok=true) 
	{ 
		if (!$ok) return $this->RollbackTrans();
    	$this->Execute('COMMIT TRAN');
    	return true;
	}
	
	function RollbackTrans()
	{
    	$this->Execute('ROLLBACK TRAN');
        return true;
	}
	
	// http://www.isug.com/Sybase_FAQ/ASE/section6.1.html#6.1.4
	function RowLock($tables,$where) 
	{
		if (!$this->_hastrans) $this->BeginTrans();
		$tables = str_replace(',',' HOLDLOCK,',$tables);
		return $this->GetOne("select top 1 null as ignore from $tables HOLDLOCK where $where");
		
	}	
        
	function SelectDB($dbName) {
		$this->databaseName = $dbName;
		if ($this->_connectionID) {
			return @sybase_select_db($dbName);		
		}
		else return false;	
	}

	/*	Returns: the last error message from previous database operation
		Note: This function is NOT available for Microsoft SQL Server.	*/	

	function ErrorMsg() {
		$this->_errorMsg = sybase_get_last_message();
		return $this->_errorMsg;
	}

	// returns true or false
	function _connect($argHostname, $argUsername, $argPassword, $argDatabasename)
	{
		$this->_connectionID = sybase_connect($argHostname,$argUsername,$argPassword);
		if ($this->_connectionID === false) return false;
		if ($argDatabasename) return $this->SelectDB($argDatabasename);
		return true;	
	}
	// returns true or false
	function _pconnect($argHostname, $argUsername, $argPassword, $argDatabasename)
	{
		$this->_connectionID = sybase_pconnect($argHostname,$argUsername,$argPassword);
		if ($this->_connectionID === false) return false;
		if ($argDatabasename) return $this->SelectDB($argDatabasename);
		return true;	
	}
	
	// returns query ID if successful, otherwise false
	function _query($sql,$inputarr)
	{
		//@sybase_free_result($this->_queryID);
		return sybase_query($sql,$this->_connectionID);
	}
	
	// See http://www.isug.com/Sybase_FAQ/ASE/section6.2.html#6.2.12
	function &SelectLimit($sql,$nrows=-1,$offset=-1,$inputarr=false,$arg3=false,$secs2cache=0) 
	{
		$cnt = ($nrows > 0) ? $nrows : 0;
		if ($offset > 0 && $cnt) $cnt += $offset;
		
		$this->Execute("set rowcount $cnt"); 
		$rs = &ADOConnection::SelectLimit($sql,$nrows,$offset,$inputarr,$arg3,$secs2cache);
		$this->Execute("set rowcount 0"); 
		
		return $rs;
	}

	// returns true or false
	function _close()
	{ 
		return @sybase_close($this->_connectionID);
	}
	
	function UnixDate($v)
	{
		return ADORecordSet_array_sybase::UnixDate($v);
	}
	
	function UnixTimeStamp($v)
	{
		return ADORecordSet_array_sybase::UnixTimeStamp($v);
	}	
}
	
/*--------------------------------------------------------------------------------------
	 Class Name: Recordset
--------------------------------------------------------------------------------------*/
global $ADODB_sybase_mths;
$ADODB_sybase_mths = array(
	'JAN'=>1,'FEB'=>2,'MAR'=>3,'APR'=>4,'MAY'=>5,'JUN'=>6,
	'JUL'=>7,'AUG'=>8,'SEP'=>9,'OCT'=>10,'NOV'=>11,'DEC'=>12);

class ADORecordset_sybase extends ADORecordSet {	

	var $databaseType = "sybase";
	var $canSeek = true;
	// _mths works only in non-localised system
	var  $_mths = array('JAN'=>1,'FEB'=>2,'MAR'=>3,'APR'=>4,'MAY'=>5,'JUN'=>6,'JUL'=>7,'AUG'=>8,'SEP'=>9,'OCT'=>10,'NOV'=>11,'DEC'=>12);	

	function ADORecordset_sybase($id)
	{
	global $ADODB_FETCH_MODE;
	
		if (!$ADODB_FETCH_MODE) $this->fetchMode = ADODB_FETCH_ASSOC;
		else $this->fetchMode = $ADODB_FETCH_MODE;
		return $this->ADORecordSet($id);
	}
	
	/*	Returns: an object containing field information. 
		Get column information in the Recordset object. fetchField() can be used in order to obtain information about
		fields in a certain query result. If the field offset isn't specified, the next field that wasn't yet retrieved by
		fetchField() is retrieved.	*/
	function &FetchField($fieldOffset = -1) 
	{
		if ($fieldOffset != -1) {
			$o = @sybase_fetch_field($this->_queryID, $fieldOffset);
		}
		else if ($fieldOffset == -1) {	/*	The $fieldOffset argument is not provided thus its -1 	*/
			$o = @sybase_fetch_field($this->_queryID);
		}
		// older versions of PHP did not support type, only numeric
		if ($o && !isset($o->type)) $o->type = ($o->numeric) ? 'float' : 'varchar';
		return $o;
	}
	
	function _initrs()
	{
	global $ADODB_COUNTRECS;
		$this->_numOfRows = ($ADODB_COUNTRECS)? @sybase_num_rows($this->_queryID):-1;
		$this->_numOfFields = @sybase_num_fields($this->_queryID);
	}
	
	function _seek($row) 
	{
		return @sybase_data_seek($this->_queryID, $row);
	}		

	function _fetch($ignore_fields=false) {
		
		if ($this->fetchMode == ADODB_FETCH_NUM) $this->fields = @sybase_fetch_row($this->_queryID);
		else $this->fields = @sybase_fetch_array($this->_queryID);
		return is_array($this->fields);
	}
	
	/*	close() only needs to be called if you are worried about using too much memory while your script
		is running. All associated result memory for the specified result identifier will automatically be freed.	*/
	function _close() {
		return @sybase_free_result($this->_queryID);		
	}
	
	// sybase/mssql uses a default date like Dec 30 2000 12:00AM
	function UnixDate($v)
	{
		return ADORecordSet_array_sybase::UnixDate($v);
	}
	
	function UnixTimeStamp($v)
	{
		return ADORecordSet_array_sybase::UnixTimeStamp($v);
	}
}

class ADORecordSet_array_sybase extends ADORecordSet_array {
	function ADORecordSet_array_sybase($id=-1)
	{
		$this->ADORecordSet_array($id);
	}
	
		// sybase/mssql uses a default date like Dec 30 2000 12:00AM
	function UnixDate($v)
	{
	global $ADODB_sybase_mths;
	
		//Dec 30 2000 12:00AM
		if (!ereg( "([A-Za-z]{3})[-/\. ]+([0-9]{1,2})[-/\. ]+([0-9]{4})"
			,$v, $rr)) return parent::UnixDate($v);
			
		if ($rr[3] <= 1970) return 0;
		
		$themth = substr(strtoupper($rr[1]),0,3);
		$themth = $ADODB_sybase_mths[$themth];
		if ($themth <= 0) return false;
		// h-m-s-MM-DD-YY
		return  mktime(0,0,0,$themth,$rr[2],$rr[3]);
	}
	
	function UnixTimeStamp($v)
	{
	global $ADODB_sybase_mths;
		//11.02.2001 Toni Tunkkari toni.tunkkari@finebyte.com
		//Changed [0-9] to [0-9 ] in day conversion
		if (!ereg( "([A-Za-z]{3})[-/\. ]([0-9 ]{1,2})[-/\. ]([0-9]{4}) +([0-9]{1,2}):([0-9]{1,2}) *([apAP]{0,1})"
			,$v, $rr)) return parent::UnixTimeStamp($v);
		if ($rr[3] <= 1970) return 0;
		
		$themth = substr(strtoupper($rr[1]),0,3);
		$themth = $ADODB_sybase_mths[$themth];
		if ($themth <= 0) return false;
		
		switch (strtoupper($rr[6])) {
		case 'P':
			if ($rr[4]<12) $rr[4] += 12;
			break;
		case 'A':
			if ($rr[4]==12) $rr[4] = 0;
			break;
		default:
			break;
		}
		// h-m-s-MM-DD-YY
		return  mktime($rr[4],$rr[5],0,$themth,$rr[2],$rr[3]);
	}
}
?>
