<html>
<body>
<?php
/* 
V2.00 13 May 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence. 
  Set tabs to 4 for best viewing.
    
  Latest version is available at http://php.weblogs.com/
*/

$ADODB_CACHE_DIR = dirname(tempnam('/tmp',''));
include("../adodb.inc.php");

if (isset($access)) {
	$db=ADONewConnection('access');
	$db->PConnect('nwind');
} else {
	$db = ADONewConnection('mysql');
	$db->PConnect('mangrove','root','','xphplens');
}
if (isset($cache)) $rs = $db->CacheExecute(120,'select * from products');
else $rs = $db->Execute('select * from products');

$arr = $rs->GetArray();
print sizeof($arr);
?>