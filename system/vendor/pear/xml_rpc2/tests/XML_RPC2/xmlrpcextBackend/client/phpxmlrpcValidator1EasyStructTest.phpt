--TEST--
XMLRPCext Backend XML-RPC client against phpxmlrpc validator1 (easyStructTest)
--SKIPIF--
<?php
if (!function_exists('xmlrpc_server_create')) {
    print "Skip XMLRPC extension unavailable";
}
if (!function_exists('curl_init')) {
    print "Skip CURL extension unavailable";
}
?>
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../../') . PATH_SEPARATOR . get_include_path());
require_once 'XML/RPC2/Client.php';
$options = array(
	'debug' => false,
	'backend' => 'Xmlrpcext',
	'prefix' => 'validator1.'
);
$client = XML_RPC2_Client::create('http://phpxmlrpc.sourceforge.net/server.php', $options);
$arg = array(
    'moe' => 5,
    'larry' => 6,
    'curly' => 8
);
$result = $client->easyStructTest($arg);
var_dump($result);

?>
--EXPECT--
int(19)
