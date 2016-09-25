--TEST--
Integer XML-RPC decoding (Php Backend)
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../../') . PATH_SEPARATOR . get_include_path());
require_once('XML/RPC2/Backend/Php/Value.php');
$value = XML_RPC2_Backend_Php_Value::createFromDecode(simplexml_load_string('<?xml version="1.0"?><value><nil/></value>'))->getNativeValue();

printf("Native value: %s\n", is_null($value) ? 'null' : 'not null');
?>
--EXPECT--
Native value: null
