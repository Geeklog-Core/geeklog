--TEST--
Request #18258  Can not call remote function called create() because XML_RPC2_Client::create()
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../') . PATH_SEPARATOR . get_include_path());
require_once 'XML/RPC2/Server.php';
require_once 'XML/RPC2/Client.php';
require_once 'XML/RPC2/Backend/Php/Request.php';


class TestServer {

    /**
     * returns something
     *
     * @param int   $id     Some id
     *
     * @return id The same id
     */
    public static function create($id)
    {
        return $id;
    }

}

$options = array(
    'prefix' => 'test.',
    'encoding' => 'utf-8'
);

$server = XML_RPC2_Server::create('TestServer', $options);
$request = new XML_RPC2_Backend_Php_Request('test.create');
$request->addParameter(12);
$GLOBALS['HTTP_RAW_POST_DATA'] = $request->encode();
$server->handleCall();
?>
--EXPECT--
<?xml version="1.0" encoding="utf-8"?>
<methodResponse><params><param><value><int>12</int></value></param></params></methodResponse>
