<?php
/*
V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence.
  Set tabs to 4.
  
  Synonym for csv driver.
*/ 

if (! defined("_ADODB_PROXY_LAYER")) {
	 define("_ADODB_PROXY_LAYER", 1 );
	 include(ADODB_DIR."/drivers/adodb-csv.inc.php");
	 
	class ADODB_proxy extends ADODB_csv {
		var $databaseType = 'proxy';
	    
	}
	class ADORecordset_proxy extends ADORecordset_csv {
	var $databaseType = "proxy";		
	
		function ADORecordset_proxy($id) 
		{
			$this->ADORecordset($id);
		}
	};
} // define
	
?>