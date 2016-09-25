--TEST--
PHP Backend XML-RPC client with transport error
--SKIPIF--
<?php
if (!function_exists('curl_init')) {
    print "Skip no CURI extension available";
}
?>
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../../') . PATH_SEPARATOR . get_include_path());
require_once 'XML/RPC2/Client.php';
require_once 'XML/RPC2/Backend.php';
XML_RPC2_Backend::setBackend('php');
$client = XML_RPC2_Client::create('http://rpc.example.com:1000/', '', null);
try {
    $client->invalidMethod('World');
} catch (XML_RPC2_CurlException $e) {
    var_dump($e->getMessage());
}
?>
--EXPECTREGEX--
string\(.*\) \"HTTP_Request2_ConnectionException.*
