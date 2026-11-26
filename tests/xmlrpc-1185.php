<?php

error_reporting(E_ALL);

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

require_once dirname(__DIR__) . '/system/classes/XML/RPC/Server.php';

$passed = 0;

function checkResult($condition, $label)
{
    global $passed;

    if (!$condition) {
        throw new RuntimeException('FAIL: ' . $label);
    }

    ++$passed;
    echo 'OK: ' . $label . "\n";
}

function testEcho($message)
{
    return new XML_RPC_Response($message->getParam(0));
}

// Parser identity and isolation.
$p1 = xml_parser_create();
$p2 = xml_parser_create();

checkResult(
    XML_RPC_getParserKey($p1) === XML_RPC_getParserKey($p1),
    'Stable parser key'
);

checkResult(
    XML_RPC_getParserKey($p1) !== XML_RPC_getParserKey($p2),
    'Distinct parser keys'
);

xml_parser_free($p1);
xml_parser_free($p2);

// Server tests.
$HTTP_RAW_POST_DATA = '';

$server = new XML_RPC_Server(
    array(
        'test.echo' => array('function' => 'testEcho')
    ),
    0
);

$response = $server->parseRequest('');

checkResult(
    $response->faultCode() == 7,
    'Empty request'
);

$response = $server->parseRequest('<invalid');

checkResult(
    $response->faultCode() > 0 &&
    strpos($response->faultString(), 'XML error') !== false,
    'Malformed XML request'
);

$response = $server->parseRequest(
    '<methodCall><methodName>test.unknown</methodName>'
    . '<params></params></methodCall>'
);

checkResult(
    $response->faultCode() == 1,
    'Unknown method'
);

$response = $server->parseRequest(
    '<methodCall><methodName>test.echo</methodName>'
    . '<params><param><value><string>Hello Geeklog</string>'
    . '</value></param></params></methodCall>'
);

checkResult(
    $response->faultCode() == 0 &&
    strpos($response->serialize(), 'Hello Geeklog') !== false,
    'Valid method with string parameter'
);

// Client tests.
$message = new XML_RPC_Message('test.echo');

function httpResponse($body)
{
    return "HTTP/1.1 200 OK\r\n"
        . "Content-Type: text/xml\r\n"
        . "Content-Length: " . strlen($body) . "\r\n"
        . "\r\n"
        . $body;
}

$response = $message->parseResponse(httpResponse(
    '<?xml version="1.0"?>'
    . '<methodResponse><params><param><value>'
    . '<string>Hello Geeklog</string>'
    . '</value></param></params></methodResponse>'
));

checkResult(
    $response->faultCode() == 0 &&
    strpos($response->serialize(), 'Hello Geeklog') !== false,
    'Client parses valid response'
);

$response = $message->parseResponse(httpResponse(
    '<?xml version="1.0"?>'
    . '<methodResponse><fault><value><struct>'
    . '<member><name>faultCode</name>'
    . '<value><int>1</int></value></member>'
    . '<member><name>faultString</name>'
    . '<value><string>Unknown method</string></value></member>'
    . '</struct></value></fault></methodResponse>'
));

checkResult(
    $response->faultCode() == 1,
    'Client parses fault response'
);

$response = $message->parseResponse(httpResponse('<invalid'));

checkResult(
    $response->faultCode() != 0,
    'Client handles malformed response'
);

echo "\nTOTAL: $passed/9 checks passed\n";
