--TEST--
XMLRPCext Backend XML-RPC cachedServer Validator1 test (easyStructTest with cache off by default 2)
--SKIPIF--
<?php
if (!function_exists('xmlrpc_server_create')) {
    print "Skip XMLRPC extension unavailable";
}
?>
--FILE--
<?php
class TestServer {
    /**
     * test function
     *
     * see http://www.xmlrpc.com/validator1Docs
     *
     * @param array $struct a struct
     * @xmlrpc.caching true
     * @return int result
     */
    public static function easyStructTest($struct) {
        return ($struct['moe'] + $struct['larry'] + $struct['curly']);
    }
}

set_include_path(realpath(dirname(__FILE__) . '/../../../../') . PATH_SEPARATOR . get_include_path());
require_once 'XML/RPC2/CachedServer.php';
require_once 'tmpdir.inc';
require_once 'XML/RPC2/Backend/Php/Response.php';

$options = array(
	'prefix' => 'validator1.',
	'backend' => 'Xmlrpcext',
	'cacheOptions' => array(
		'cacheDir' => tmpDir() . '/',
		'lifetime' => 60,
		'cacheByDefault' => false
	),
	'cacheDebug' => true
);

$server = XML_RPC2_CachedServer::create('TestServer', $options);
$GLOBALS['HTTP_RAW_POST_DATA'] = <<<EOS
<?xml version="1.0" encoding="iso-8859-1"?>
<methodCall>
<methodName>validator1.easyStructTest</methodName>
<params>
 <param>
  <value>
   <struct>
    <member>
     <name>moe</name>
     <value>
      <int>5</int>
     </value>
    </member>
    <member>
     <name>larry</name>
     <value>
      <int>6</int>
     </value>
    </member>
    <member>
     <name>curly</name>
     <value>
      <int>8</int>
     </value>
    </member>
   </struct>
  </value>
 </param>
</params>
</methodCall>
EOS
;
$response = $server->getResponse();
$result = (XML_RPC2_Backend_Php_Response::decode(simplexml_load_string($response)));
var_dump($result);
$response = $server->getResponse();
$result = (XML_RPC2_Backend_Php_Response::decode(simplexml_load_string($response)));
var_dump($result);
$response = $server->getResponse();
$result = (XML_RPC2_Backend_Php_Response::decode(simplexml_load_string($response)));
var_dump($result);
$server->clean();

?>
--EXPECT--
CACHE DEBUG : default values  => weCache=false, lifetime=60
CACHE DEBUG : phpdoc comments => weCache=true, lifetime=60
CACHE DEBUG : cache is not hit !
int(19)
CACHE DEBUG : default values  => weCache=false, lifetime=60
CACHE DEBUG : phpdoc comments => weCache=true, lifetime=60
CACHE DEBUG : cache is hit !
int(19)
CACHE DEBUG : default values  => weCache=false, lifetime=60
CACHE DEBUG : phpdoc comments => weCache=true, lifetime=60
CACHE DEBUG : cache is hit !
int(19)
