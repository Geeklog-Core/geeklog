<?php
/*
V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence.
  Set tabs to 8.
  
  MySQL code that does not support transactions. Use mysqlt if you need transactions.
  Requires mysql client. Works on Windows and Unix.
  
 28 Feb 2001: MetaColumns bug fix - suggested by  Freek Dijkstra (phpeverywhere@macfreek.com)
*/ 

if (! defined("_ADODB_MYSQL_LAYER")) {
 define("_ADODB_MYSQL_LAYER", 1 );

class ADODB_mysql extends ADOConnection {
	var $databaseType = 'mysql';
    var $hasInsertID = true;
    var $hasAffectedRows = true;	
	var $metaTablesSQL = "SHOW TABLES";	
	var $metaColumnsSQL = "SHOW COLUMNS FROM %s";
	var $fmtTimeStamp = "'Y-m-d H:i:s'";
	var $hasLimit = true;
	var $hasMoveFirst = true;
	var $hasGenID = true;
	var $upperCase = 'upper';
	var $isoDates = true; // accepts dates in ISO format
	var $sysDate = 'CURDATE()';
	var $sysTimeStamp = 'NOW()';
	
	function ADODB_mysql() 
	{			
	}
	
    function _insertid()
    {
            return mysql_insert_id($this->_connectionID);
    }
    
    function _affectedrows()
    {
            return mysql_affected_rows($this->_connectionID);
    }
  
 	// See http://www.mysql.com/doc/M/i/Miscellaneous_functions.html
	// Reference on Last_Insert_ID on the recommended way to simulate sequences
 	var $_genIDSQL = "update %s set id=LAST_INSERT_ID(id+1);";
	var $_genSeqSQL = "create table %s (id int not null)";
	var $_genSeq2SQL = "insert into %s values (%s)";
	
	function GenID($seqname='adodbseq',$startID=1)
	{
		//if (!$this->hasGenID) return false;
		$getnext = sprintf($this->_genIDSQL,$seqname);
		$rs = @$this->Execute($getnext);
		if (!$rs) {
			$u = strtoupper($seqname);
			$this->Execute(sprintf($this->_genSeqSQL,$seqname));
			$this->Execute(sprintf($this->_genSeq2SQL,$seqname,$startID-1));
			$rs = $this->Execute($getnext);
		}
		$this->genID = mysql_insert_id($this->_connectionID);
		
		if ($rs) $rs->Close();
		
		return $this->genID;
	}
	
  	function &MetaDatabases()
	{
		$qid = mysql_list_dbs($this->_connectionID);
		$arr = array();
		$i = 0;
		$max = mysql_num_rows($qid);
		while ($i < $max) {
			$arr[] = mysql_tablename($qid,$i);
			$i += 1;
		}
		return $arr;
	}

	// returns concatenated string
	function Concat()
	{
		$s = "";
		$arr = func_get_args();
		$first = true;
		/*
		foreach($arr as $a) {
			if ($first) {
				$s = $a;
				$first = false;
			} else $s .= ','.$a;
		}*/
		
		// suggestion by andrew005@mnogo.ru
	        $s = implode(',',$arr); 
		if (strlen($s) > 0) return "CONCAT($s)";
		else return '';
	}
	
	// returns true or false
	function _connect($argHostname, $argUsername, $argPassword, $argDatabasename)
	{
		$this->_connectionID = mysql_connect($argHostname,$argUsername,$argPassword);
		if ($this->_connectionID === false) return false;
		if ($argDatabasename) return $this->SelectDB($argDatabasename);
		return true;	
	}
	
	// returns true or false
	function _pconnect($argHostname, $argUsername, $argPassword, $argDatabasename)
	{
		$this->_connectionID = mysql_pconnect($argHostname,$argUsername,$argPassword);
		if ($this->_connectionID === false) return false;
		if ($argDatabasename) return $this->SelectDB($argDatabasename);
		return true;	
	}
	
 	function &MetaColumns($table) 
	{
	
		if ($this->metaColumnsSQL) {
		global $ADODB_FETCH_MODE;
		
			$save = $ADODB_FETCH_MODE;
			$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
			
			$rs = $this->Execute(sprintf($this->metaColumnsSQL,$table));
			
			$ADODB_FETCH_MODE = $save;
			
			if ($rs === false) return false;
			
			$retarr = array();
			while (!$rs->EOF){
				$fld = new ADOFieldObject();
				$fld->name = $rs->fields[0];
				$fld->type = $rs->fields[1];
					
				// split type into type(length):
				if (preg_match("/^(.+)\((\d+)\)$/", $fld->type, $query_array)) {
					$fld->type = $query_array[1];
					$fld->max_length = $query_array[2];
				} else {
					$fld->max_length = -1;
				}
				$fld->not_null = ($rs->fields[2] != 'YES');
				$fld->primary_key = ($rs->fields[3] == 'PRI');
				$fld->auto_increment = (strpos($rs->fields[5], 'auto_increment') !== false);
				$fld->binary = (strpos($fld->type,'blob') !== false);
				if (!$fld->binary) {
					$d = $rs->fields[4];
					if ($d != "" && $d != "NULL") {
						$fld->has_default = true;
						$fld->default_value = $d;
					} else {
						$fld->has_default = false;
					}
				}
				
				$retarr[strtoupper($fld->name)] = $fld;	
				$rs->MoveNext();
			}
			$rs->Close();
			return $retarr;	
		}
		return false;
	}
		
	// returns true or false
	function SelectDB($dbName) 
	{
		$this->databaseName = $dbName;
		if ($this->_connectionID) {
			return @mysql_select_db($dbName,$this->_connectionID);		
		}
		else return false;	
	}
	
	// parameters use PostgreSQL convention, not MySQL
	function &SelectLimit($sql,$nrows=-1,$offset=-1,$inputarr=false, $arg3=false,$secs=0)
	{
		$offsetStr =($offset>=0) ? "$offset," : '';
		
		return ($secs) ? $this->CacheExecute($secs,$sql." LIMIT $offsetStr$nrows",$inputarr,$arg3)
			: $this->Execute($sql." LIMIT $offsetStr$nrows",$inputarr,$arg3);
		
	}
	
	// returns queryID or false
	function _query($sql,$inputarr)
	{
	global $ADODB_COUNTRECS;
		if($ADODB_COUNTRECS) return mysql_query($sql,$this->_connectionID);
		else return mysql_unbuffered_query($sql,$this->_connectionID); // requires PHP >= 4.0.6
	}

	/*	Returns: the last error message from previous database operation	*/	
	function ErrorMsg() 
	{
		if (empty($this->_connectionID)) $this->_errorMsg = @mysql_error();
		else $this->_errorMsg = @mysql_error($this->_connectionID);
	    return $this->_errorMsg;
	}
	
	/*	Returns: the last error number from previous database operation	*/	
	function ErrorNo() 
	{
			if (empty($this->_connectionID))  return @mysql_errno();
			else return @mysql_errno($this->_connectionID);
	}
	

	
	// returns true or false
	function _close()
	{
		@mysql_close($this->_connectionID);
		$this->_connectionID = false;
	}

	 function ActualType($meta)
	{
		switch($meta) {
		case 'C': return 'VARCHAR';
		case 'X': return 'LONGTEXT';
		
		case 'C2': return 'VARCHAR';
		case 'X2': return 'LONGTEXT';
		
		case 'B': return 'LONGBLOB';
			
		case 'D': return 'DATE';
		case 'T': return 'DATETIME';
		case 'L': return 'TINYINT';
		case 'R': return 'INTEGER NOT NULL AUTO_INCREMENT';
		case 'I': return 'INTEGER';  // enough for 9 petabytes!
		
		case 'F': return 'DOUBLE';
		case 'N': return 'NUMERIC';
		default:
			return false;
		}
	}
	
	/*
	* Maximum size of C field
	*/
	function CharMax()
	{
		return 255; 
	}
	
	/*
	* Maximum size of X field
	*/
	function TextMax()
	{
		return 4294967295; 
	}
	
}
	
/*--------------------------------------------------------------------------------------
	 Class Name: Recordset
--------------------------------------------------------------------------------------*/

class ADORecordSet_mysql extends ADORecordSet{	
	
	var $databaseType = "mysql";
	var $canSeek = true;
	
	function ADORecordSet_mysql($queryID) {
	GLOBAL $ADODB_FETCH_MODE;
	
		switch ($ADODB_FETCH_MODE)
		{
		case ADODB_FETCH_NUM: $this->fetchMode = MYSQL_NUM; break;
		case ADODB_FETCH_ASSOC:$this->fetchMode = MYSQL_ASSOC; break;
		default:
		case ADODB_FETCH_DEFAULT:
		case ADODB_FETCH_BOTH:$this->fetchMode = MYSQL_BOTH; break;
		}
	
		$this->ADORecordSet($queryID);	
	}
	
	function _initrs()
	{
	GLOBAL $ADODB_COUNTRECS;
		$this->_numOfRows = ($ADODB_COUNTRECS) ? @mysql_num_rows($this->_queryID):-1;
		$this->_numOfFields = @mysql_num_fields($this->_queryID);
	}
	
	function &FetchField($fieldOffset = -1) {
		if ($fieldOffset != -1) {
			$o =  @mysql_fetch_field($this->_queryID, $fieldOffset);
			$f = @mysql_field_flags($this->_queryID,$fieldOffset);
			$o->max_length = @mysql_field_len($this->_queryID,$fieldOffset); // suggested by: Jim Nicholson (jnich@att.com)
			//$o->max_length = -1; // mysql returns the max length less spaces -- so it is unrealiable
			$o->binary = (strpos($f,'binary')!== false);
		}
		else if ($fieldOffset == -1) {	/*	The $fieldOffset argument is not provided thus its -1 	*/
			$o = @mysql_fetch_field($this->_queryID);
			$o->max_length = @mysql_field_len($this->_queryID); // suggested by: Jim Nicholson (jnich@att.com)
			//$o->max_length = -1; // mysql returns the max length less spaces -- so it is unrealiable
		}
		
		return $o;
	}

	function &GetRowAssoc($upper=true)
	{
		if ($this->fetchMode == MYSQL_ASSOC && !$upper) return $rs->fields;
		return ADORecordSet::GetRowAssoc($upper);
	}
	
	/* Use associative array to get fields array */
	function Fields($colname)
	{	
		// added @ by "Michael William Miller" <mille562@pilot.msu.edu>
		if ($this->fetchMode != MYSQL_NUM) return @$this->fields[$colname];
		
		if (!$this->bind) {
			$this->bind = array();
			for ($i=0; $i < $this->_numOfFields; $i++) {
				$o = $this->FetchField($i);
				$this->bind[strtoupper($o->name)] = $i;
			}
		}
		 return $this->fields[$this->bind[strtoupper($colname)]];
	}
	
	function _seek($row)
	{
		return @mysql_data_seek($this->_queryID,$row);
	}
	
	/*function &FetchRow()
	{
		if ($this->EOF) return false;
		
		$arr = $this->fields;
		$this->_currentRow++;
			// using & below slows things down by 20%!
		$this->fields = @mysql_fetch_array($this->_queryID,$this->fetchMode);
			
		if (is_array($this->fields)) return $arr;
		$this->EOF = true;
		return false;
	} */
	
	// 10% speedup to move MoveNext to child class
	function MoveNext() 
	{
		if (!$this->EOF) {		
			$this->_currentRow++;
			// using & below slows things down by 20%!
			$this->fields = @mysql_fetch_array($this->_queryID,$this->fetchMode);
			
			if (is_array($this->fields)) return true;
			$this->EOF = true;
		}
		/* -- tested raising an error -- appears pointless
		$conn = $this->connection;
		if ($conn && $conn->raiseErrorFn && ($errno = $conn->ErrorNo())) {
			$fn = $conn->raiseErrorFn;
			$fn($conn->databaseType,'MOVENEXT',$errno,$conn->ErrorMsg().' ('.$this->sql.')',$conn->host,$conn->database);
		}
		*/
		return false;
	}	
	
	function _fetch()
	{
		$this->fields = @mysql_fetch_array($this->_queryID,$this->fetchMode);
		return (is_array($this->fields));
	}
	
	function _close() {
		@mysql_free_result($this->_queryID);	
		$this->_queryID = false;	
	}
	
	function MetaType($t,$len=-1,$fieldobj=false)
	{
		$len = -1; // mysql max_length is not accurate
		switch (strtoupper($t)) {
		case 'STRING': 
		case 'CHAR':
		case 'VARCHAR': 
		case 'TINYBLOB': 
		case 'TINYTEXT': 
		case 'ENUM': 
		case 'SET': 
			if ($len <= $this->blobSize) return 'C';
			
		case 'TEXT':
		case 'LONGTEXT': 
		case 'MEDIUMTEXT':
			return 'X';
			
		// php_mysql extension always returns 'blob' even if 'text'
		// so we have to check whether binary...
		case 'IMAGE':
		case 'LONGBLOB': 
		case 'BLOB':
		case 'MEDIUMBLOB':
			return !empty($fieldobj->binary) ? 'B' : 'X';
			
		case 'DATE': return 'D';
		
		case 'TIME':
		case 'DATETIME':
		case 'TIMESTAMP': return 'T';
		
		case 'INT': 
		case 'INTEGER':
		case 'BIGINT':
		case 'TINYINT':
		case 'MEDIUMINT':
		case 'SMALLINT': 
			
			if (!empty($fieldobj->primary_key)) return 'R';
			else return 'I';
		
		default: return 'N';
		}
	}

}
}
?>
