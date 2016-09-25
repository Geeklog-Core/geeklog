--TEST--
Nil XML-RPC encoding (Php Backend)
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../../') . PATH_SEPARATOR . get_include_path());
require_once 'XML/RPC2/Backend/Php/Value/Nil.php';
$null = new XML_RPC2_Backend_Php_Value_Nil();
var_dump($null->encode());
?>
--EXPECT--
string(11) "<nil></nil>"
