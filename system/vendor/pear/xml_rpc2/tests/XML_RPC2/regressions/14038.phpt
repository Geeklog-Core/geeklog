--TEST--
Empty array should not trigger notice
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../') . PATH_SEPARATOR . get_include_path());
require 'XML/RPC2/Backend/Php/Value.php';
class Empty_Array_Value_Test extends XML_RPC2_Backend_Php_Value
{
}

{
    function errorHandler ($errno, $errstr, $errfile, $errline,
$errcontext)
    {
        echo $errno;
    }

    set_error_handler('errorHandler');


    $array_class = new Empty_Array_Value_Test();
    $array_class->createFromNative(array());
}
--EXPECT--
