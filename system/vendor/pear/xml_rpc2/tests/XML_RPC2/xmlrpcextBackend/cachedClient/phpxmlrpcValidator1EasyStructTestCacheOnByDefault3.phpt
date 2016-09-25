--TEST--
XMLRPCext Backend XML-RPC cachedClient against phpxmlrpc validator1 (easyStructTest with cache on by default 3)
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
require_once('tmpdir.inc');
require_once 'XML/RPC2/CachedClient.php';

$dir = tmpDir() . '/cache_' . rand().'/';
@mkdir($dir);
$options = array(
	'debug' => false,
	'backend' => 'Xmlrpcext',
	'prefix' => 'validator1.',
	'cacheOptions' => array(
		'cacheDir' => $dir,
		'lifetime' => 1,
		'cacheByDefault' => true,
		'cachedMethods' => array(
			'foo' => 1,
			'bar' => 2,
			'easyStructTest' => 60
		)
	),
	'cacheDebug' => true
);

$client = XML_RPC2_CachedClient::create('http://phpxmlrpc.sourceforge.net/server.php', $options);
$arg = array(
    'moe' => 5,
    'larry' => 6,
    'curly' => 8
);
$result = $client->easyStructTest($arg);
var_dump($result);
sleep(3);
$result = $client->easyStructTest($arg);
var_dump($result);
$client->dropCacheFile___('easyStructTest', array($arg));
@rmdir($dir);

?>
--EXPECT--
CACHE DEBUG : cache is not hit !
int(19)
CACHE DEBUG : cache is hit !
int(19)
