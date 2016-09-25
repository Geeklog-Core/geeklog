--TEST--
PHP Backend XML-RPC cachedClient against phpxmlrpc validator1 (easyStructTest with cache off by default 2)
--SKIPIF--
<?php
if (!function_exists('curl_init')) {
    print "Skip no CURI extension available";
}
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../../') . PATH_SEPARATOR . get_include_path());
require_once('tmpdir.inc');
require_once 'XML/RPC2/CachedClient.php';

$options = array(
	'debug' => false,
	'backend' => 'Php',
	'prefix' => 'validator1.',
	'cacheOptions' => array(
		'cacheDir' => tmpDir() . '/',
		'lifetime' => 60,
		'cacheByDefault' => false,
		'cachedMethods' => array('foo', 'bar', 'easyStructTest', 'foo2', 'bar2')
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
$result = $client->easyStructTest($arg);
var_dump($result);
$result = $client->easyStructTest($arg);
var_dump($result);
$client->dropCacheFile___('easyStructTest', array($arg));

?>
--EXPECT--
CACHE DEBUG : cache is not hit !
int(19)
CACHE DEBUG : cache is hit !
int(19)
CACHE DEBUG : cache is hit !
int(19)
