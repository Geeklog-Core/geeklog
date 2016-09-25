--TEST--
Integer XML-RPC decoding (Php Backend)
--SKIPIF--
<?php
if (PHP_INT_SIZE < 8) print "Skip: Integer64 is only available on 64bit systems"
?>
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../../') . PATH_SEPARATOR . get_include_path());
require_once('XML/RPC2/Backend/Php/Value.php');
printf("Native value: %s\n", XML_RPC2_Backend_Php_Value::createFromDecode(simplexml_load_string('<?xml version="1.0"?><value><i8>34359738368</i8></value>'))->getNativeValue());
?>
--EXPECT--
Native value: 34359738368
