<?php
/* 
V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence. See License.txt. 
  Set tabs to 4 for best viewing.
  
  Less commonly used functions are placed here to reduce size of adodb.inc.php. 
*/ 

function _adodb_totalpages(&$rs)
{
	if  ($rs->rowsPerPage) {
		$rows = ($rs->RecordCount()+$rs->rowsPerPage-1) / $rs->rowsPerPage;
		if ($rows < 0) return -1;
		else return $rows;
	} else return -1;
}

// Requires $ADODB_FETCH_MODE = ADODB_FETCH_NUM
function _adodb_getmenu(&$zthis, $name,$defstr='',$blank1stItem=true,$multiple=false,
			$size=0, $selectAttr='',$compareFields0=true)
{
	$hasvalue = false;

	if ($multiple or is_array($defstr)) {
		if ($size==0) $size=5;
		$attr = " multiple size=$size";
		if (!strpos($name,'[]')) $name .= '[]';
	} else if ($size) $attr = " size=$size";
	else $attr ='';
	
			
	$s = "<select name=\"$name\"$attr $selectAttr>";
	if ($blank1stItem) $s .= "\n<option></option>";

	if ($zthis->FieldCount() > 1) $hasvalue=true;
	else $compareFields0 = true;
	
	while(!$zthis->EOF) {
		$zval = trim($zthis->fields[0]);
		$selected = trim($zthis->fields[$compareFields0 ? 0 : 1]);
		
		if ($blank1stItem && $zval=="") {
			$zthis->MoveNext();
			continue;
		}
		if ($hasvalue) 
			$value = 'value="'.htmlspecialchars(trim($zthis->fields[1])).'"';
		
		
		if (is_array($defstr))  {
			
			if (in_array($selected,$defstr)) 
				$s .= "<option selected $value>".htmlspecialchars($zval).'</option>';
			else 
				$s .= "\n<option ".$value.'>'.htmlspecialchars($zval).'</option>';
		}
		else {
			if (strcasecmp($selected,$defstr)==0) 
				$s .= "<option selected $value>".htmlspecialchars($zval).'</option>';
			else 
				$s .= "\n<option ".$value.'>'.htmlspecialchars($zval).'</option>';
		}
		$zthis->MoveNext();
	} // while
	
	return $s ."\n</select>\n";
}

function &_adodb_pageexecute(&$zthis, $sql, $nrows, $page, $inputarr=false, $arg3=false, $secs2cache=0) 
{

	$atfirstpage = false;
	$atlastpage = false;
	
	if (!isset($page) || $page <= 1) {	// If page number <= 1, then we are at the first page
		$page = 1;
		$atfirstpage = true;
	}
	if ($nrows <= 0) $nrows = 10;	// If an invalid nrows is supplied, we assume a default value of 10 rows per page
	
	// ***** Here we check whether $page is the last page or whether we are trying to retrieve a page number greater than 
	// the last page number.
	$pagecounter = $page + 1;
	$pagecounteroffset = ($pagecounter * $nrows) - $nrows;
	if ($secs2cache>0) $rstest = &$zthis->CacheSelectLimit($secs2cache, $sql, $nrows, $pagecounteroffset, $inputarr, $arg3);
	else $rstest = &$zthis->SelectLimit($sql, $nrows, $pagecounteroffset, $inputarr, $arg3, $secs2cache);
	if ($rstest) {
		while ($rstest && $rstest->EOF && $pagecounter>0) {
			$atlastpage = true;
			$pagecounter--;
			$pagecounteroffset = $nrows * ($pagecounter - 1);
			$rstest->Close();
			if ($secs2cache>0) $rstest = &$zthis->CacheSelectLimit($secs2cache, $sql, $nrows, $pagecounteroffset, $inputarr, $arg3);
			else $rstest = &$zthis->SelectLimit($sql, $nrows, $pagecounteroffset, $inputarr, $arg3, $secs2cache);
		}
		if ($rstest) $rstest->Close();
	}
	if ($atlastpage) {	// If we are at the last page or beyond it, we are going to retrieve it
		$page = $pagecounter;
		if ($page == 1) $atfirstpage = true;	// We have to do this again in case the last page is the same as the first
			//... page, that is, the recordset has only 1 page.
	}
	
	// We get the data we want
	$offset = $nrows * ($page-1);
	if ($secs2cache > 0) $rsreturn = &$zthis->CacheSelectLimit($secs2cache, $sql, $nrows, $offset, $inputarr, $arg3);
	else $rsreturn = &$zthis->SelectLimit($sql, $nrows, $offset, $inputarr, $arg3, $secs2cache);
	
	// Before returning the RecordSet, we set the pagination properties we need
	if ($rsreturn) {
		$rsreturn->rowsPerPage = $nrows;
		$rsreturn->AbsolutePage($page);
		$rsreturn->AtFirstPage($atfirstpage);
		$rsreturn->AtLastPage($atlastpage);
	}
	return $rsreturn;
}

function _adodb_getupdatesql(&$zthis,&$rs, $arrFields,$forceUpdate=false,$magicq=false)
{
		if (!$rs) {
			printf(ADODB_BAD_RS,'GetUpdateSQL');
			return false;
		}
	
		$fieldUpdatedCount = 0;
		
		// Get the table name from the existing query.
		preg_match("/FROM\s".ADODB_TABLE_REGEX."/i", $rs->sql, $tableName);

		// Get the full where clause excluding the word "WHERE" from
		// the existing query.
		preg_match("/WHERE\s(.*)/i", $rs->sql, $whereClause);

		// updateSQL will contain the full update query when all
		// processing has completed.
		$updateSQL = "UPDATE " . $tableName[1] . " SET ";
		
		// Loop through all of the fields in the recordset
		for ($i=0, $max=$rs->FieldCount(); $i < $max; $i++) {
		
			// Get the field from the recordset
			$field = $rs->FetchField($i);

			// If the recordset field is one
			// of the fields passed in then process.
			if (isset($arrFields[$field->name])) {

				// If the existing field value in the recordset
				// is different from the value passed in then
				// go ahead and append the field name and new value to
				// the update query.

				if ($forceUpdate || strcmp($rs->fields[$i], $arrFields[$field->name])) {
					// Set the counter for the number of fields that will be updated.
					$fieldUpdatedCount++;

					// Based on the datatype of the field
					// Format the value properly for the database
					$mt = $rs->MetaType($field->type);
					
					// "mike" <mike@partner2partner.com> patch and "Ryan Bailey" <rebel@windriders.com> 
					//PostgreSQL uses a 't' or 'f' and therefore needs to be processed as a string ('C') type field.
					if ((substr($zthis->databaseType,0,8) == "postgres") && ($mt == "L")) $mt = "C";

					switch($mt) {
						case "C":
						case "X":
							$updateSQL .= $field->name . " = " . $zthis->qstr($arrFields[$field->name],$magicq) . ", ";
							break;
						case "D":
							$updateSQL .= $field->name . " = " . $zthis->DBDate($arrFields[$field->name]) . ", ";
       						break;
						case "T":
							$updateSQL .= $field->name . " = " . $zthis->DBTimeStamp($arrFields[$field->name]) . ", ";
							break;
						default:
							$updateSQL .= $field->name . " = " . (float) $arrFields[$field->name] . ", ";
							break;
					};
				};
    		};
		};

		// If there were any modified fields then build the rest of the update query.
		if ($fieldUpdatedCount > 0 || $forceUpdate) {
			// Strip off the comma and space on the end of the update query.
			$updateSQL = substr($updateSQL, 0, -2);

			// If the recordset has a where clause then use that same where clause
			// for the update.
			if ($whereClause[1]) $updateSQL .= " WHERE " . $whereClause[1];

			return $updateSQL;
		} else {
			return false;
   		};
}

function _adodb_getinsertsql(&$zthis,&$rs,$arrFields,$magicq=false)
{
	$values = '';
	$fields = '';
	
	if (!$rs) {
			printf(ADODB_BAD_RS,'GetInsertSQL');
			return false;
		}

		$fieldInsertedCount = 0;
	
		// Get the table name from the existing query.
		preg_match("/FROM\s".ADODB_TABLE_REGEX."/i", $rs->sql, $tableName);

		// Loop through all of the fields in the recordset
		for ($i=0, $max=$rs->FieldCount(); $i < $max; $i++) {

			// Get the field from the recordset
			$field = $rs->FetchField($i);
			// If the recordset field is one
			// of the fields passed in then process.
			if (isset($arrFields[$field->name])) {
	
				// Set the counter for the number of fields that will be inserted.
				$fieldInsertedCount++;

				// Get the name of the fields to insert
				$fields .= $field->name . ", ";
				
				$mt = $rs->MetaType($field->type);
				
				// "mike" <mike@partner2partner.com> patch and "Ryan Bailey" <rebel@windriders.com> 
				//PostgreSQL uses a 't' or 'f' and therefore needs to be processed as a string ('C') type field.
				if ((substr($zthis->databaseType,0,8) == "postgres") && ($mt == "L")) $mt = "C";

				// Based on the datatype of the field
				// Format the value properly for the database
				switch($mt) {
					case "C":
					case "X":
						$values .= $zthis->qstr($arrFields[$field->name],$magicq) . ", ";
						break;
					case "D":
						$values .= $zthis->DBDate($arrFields[$field->name]) . ", ";
						break;
					case "T":
						$values .= $zthis->DBTimeStamp($arrFields[$field->name]) . ", ";
						break;
					default:
						$values .= (float) $arrFields[$field->name] . ", ";
						break;
				};
    		};
      	};

		// If there were any inserted fields then build the rest of the insert query.
		if ($fieldInsertedCount > 0) {

			// Strip off the comma and space on the end of both the fields
			// and their values.
			$fields = substr($fields, 0, -2);
			$values = substr($values, 0, -2);

			// Append the fields and their values to the insert query.
			$insertSQL = "INSERT INTO " . $tableName[1] . " ( $fields ) VALUES ( $values )";

			return $insertSQL;

		} else {
			return false;
   		};
}
?>