--TEST--
Integer XML-RPC encoding (Php Backend)
--SKIPIF--
<?php
if (PHP_INT_SIZE < 8) print "Skip: Integer64 is only available on 64bit systems"
?>
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../../') . PATH_SEPARATOR . get_include_path());
require_once 'XML/RPC2/Backend/Php/Value/Integer64.php';
$integer = new XML_RPC2_Backend_Php_Value_Integer64(34359738368);
var_dump($integer->encode());
?>
--EXPECT--
string(20) "<i8>34359738368</i8>"
