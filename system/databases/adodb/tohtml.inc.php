<?php 
/*
V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence.
  
  Some pretty-printing by Chris Oxenreider <oxenreid@state.net>
*/ 
  
// specific code for tohtml
GLOBAL $gSQLMaxRows,$gSQLBlockRows;
	 
$gSQLMaxRows = 1000; // max no of rows to download
$gSQLBlockRows=20; // max no of rows per table block

// RecordSet to HTML Table
//------------------------------------------------------------
// Convert a recordset to a html table. Multiple tables are generated
// if the number of rows is > $gSQLBlockRows. This is because
// web browsers normally require the whole table to be downloaded
// before it can be rendered, so we break the output into several
// smaller faster rendering tables.
//
// $rs: the recordset
// $ztabhtml: the table tag attributes (optional)
// $zheaderarray: contains the replacement strings for the headers (optional)
//
//  USAGE:
//    include('adodb.inc.php');
//    $db = ADONewConnection('mysql');
//    $db->Connect('mysql','userid','password','database');
//    $rs = $db->Execute('select col1,col2,col3 from table');
//    rs2html($rs, 'BORDER=2', array('Title1', 'Title2', 'Title3'));
//    $rs->Close();
//
// RETURNS: number of rows displayed
function rs2html(&$rs,$ztabhtml='',$zheaderarray="")
{
$s ='';$rows=0;$docnt = false;
GLOBAL $gSQLMaxRows,$gSQLBlockRows;

	if (!$rs) {
		printf(ADODB_BAD_RS,'rs2html');
		return false;
	}
	
	if (! $ztabhtml) $ztabhtml = "BORDER='1' WIDTH='98%'";
	//else $docnt = true;
	$typearr = array();
	$ncols = $rs->FieldCount();
    $hdr = "<TABLE COLS=$ncols $ztabhtml>\n\n";
	
	for ($i=0; $i < $ncols; $i++) {	
		$field = $rs->FetchField($i);
		if ($zheaderarray) $fname = $zheaderarray[$i];
		else $fname = htmlspecialchars($field->name);	
		$typearr[$i] = $rs->MetaType($field->type,$field->max_length);
 		//print " $field->name $field->type $typearr[$i] ";
		    
		if (empty($fname)) $fname = '&nbsp;';
		$hdr .= "<TH>$fname</TH>";
    }

	print $hdr."\n\n";
	
	// smart algorithm - handles ADODB_FETCH_MODE's correctly!
	$numoffset = isset($rs->fields[0]);
    while (!$rs->EOF) {
        $s .= "<TR>\n";
		
    	for ($i=0, $v=($numoffset) ? $rs->fields[0] : reset($rs->fields); 
			$i < $ncols; 
			$i++, $v = ($numoffset) ? @$rs->fields[$i] : next($rs->fields)) {
			
			$type = $typearr[$i];
			switch($type) {
			case 'T':
				$s .= "	<TD>".$rs->UserTimeStamp($v,"D d, M Y, h:i:s") ."&nbsp;</TD>\n";
			break;
			case 'D':
				$s .= "	<TD>".$rs->UserDate($v,"D d, M Y") ."&nbsp;</TD>\n";
			break;
			case 'I':
			case 'N':
				$s .= "	<TD align=right>".htmlspecialchars(trim($v)) ."&nbsp;</TD>\n";
               	$s = stripslashes($s);
               	$s = urldecode($s);
			break;
			default:
				$s .= "	<TD>".htmlspecialchars(trim($v)) ."&nbsp;</TD>\n";
               	$s = stripslashes($s);
               	$s = urldecode($s);
			}
		} // for
        $s .= "</TR>\n\n";
              
		$rows += 1;
		if ($rows >= $gSQLMaxRows) {
			$rows = "<p>Truncated at $gSQLMaxRows</p>";
			break;
		} // switch

		$rs->MoveNext();
	
	// additional EOF check to prevent a widow header
        if (!$rs->EOF && $rows % $gSQLBlockRows == 0) {
	
		//if (connection_aborted()) break;// not needed as PHP aborts script, unlike ASP
        	print $s . "</TABLE>\n\n";
        	$s = $hdr;
		}
    } // while

    print $s."</TABLE>\n\n";

	if ($docnt) print "<H2>".$rows." Rows</H2>";
	
	return $rows;
 }
 

function arr2html(&$arr,$ztabhtml='',$zheaderarray='')
{
	if (!$ztabhtml) $ztabhtml = 'BORDER=1';
	
	$s = "<TABLE $ztabhtml>";//';print_r($arr);

	if ($zheaderarray) {
		$s .= '<TR>';
		for ($i=0; $i<sizeof($zheaderarray); $i++) {
			$s .= "    <TD>{$zheaderarray[$i]}</TD>\n";
		}
		$s .= "\n</TR>";
	}
	
	for ($i=0; $i<sizeof($arr); $i++) {
		$s .= '<TR>';
		$a = &$arr[$i];
		if (is_array($a)) 
			for ($j=0; $j<sizeof($a); $j++) {
				$val = $a[$j];
				if (empty($val)) $val = '&nbsp;';
				$s .= "    <TD>$val</TD>\n";
			}
		else if ($a) {
			$s .=  '    <TD>'.$a."</TD>\n";
		} else $s .= "    <TD>&nbsp;</TD>\n";
		$s .= "\n</TR>\n";
	}
	$s .= '</TABLE>';
	print $s;
}


