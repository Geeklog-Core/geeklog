--TEST--
Bug #11314: Following codesniffer standards param docs mess up
--FILE--
<?php
set_include_path(realpath(dirname(__FILE__) . '/../../../') . PATH_SEPARATOR . get_include_path());
/**
 * Point to a problem with the autodocumentation of servers which follows the specifications
 * in PHPCodeSniffer.
 *
 * PHP version 5
 *
 * @category  XML
 * @package   XML_RPC2
 * @author    Lars Olesen <lars@legestue.net>

 * @copyright 2007 Lars Olesen
 * @license   GPL http://www.opensource.org/licenses/gpl-license.php
 * @version   @package-version@
 * @link      http://pear.php.net/package/XML_RPC2
 */
require_once 'XML/RPC2/Server.php';

/**
 * The implementation
 *
 * @category  XML
 * @package   XML_RPC2
 * @author    Lars Olesen <lars@legestue.net>
 * @copyright 2007 Lars Olesen
 * @license   GPL http://www.opensource.org/licenses/gpl-license.php
 * @version   @package-version@
 * @link      http://pear.php.net/package/XML_RPC2
 */
class DocumentationServer {

    /**
     * returns something
     *
     * @param array   $something     A description
     * @param string  $another_thing A description of another thing
     * @param boolean $return        Whether to return nothing - server doesn't care though
     *
     * @return string An international string
     */
    public static function getSomething($something, $another_thing, $credentials) {
        return 'nothing interesting';
    }

}

$options = array(
    'prefix' => 'test.',
    'encoding' => 'utf-8'
);

$server = XML_RPC2_Server::create('DocumentationServer', $options);
$GLOBALS['HTTP_RAW_POST_DATA'] = '';
$server->handleCall();
?>
--EXPECT--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/HTML; charset=utf-8"  />
    <title>Available XMLRPC methods for this server</title>
    <style type="text/css">
      li,p { font-size: 10pt; font-family: Arial,Helvetia,sans-serif; }
      a:link { background-color: white; color: blue; text-decoration: underline; font-weight: bold; }
      a:visited { background-color: white; color: blue; text-decoration: underline; font-weight: bold; }
      table { border-collapse:collapse; width: 100% }
      table,td { padding: 5px; border: 1px solid black; }
      div.bloc { border: 1px dashed gray; padding: 10px; margin-bottom: 20px; }
      div.description { border: 1px solid black; padding: 10px; }
      span.type { background-color: white; color: gray; font-weight: normal; }
      span.paratype { background-color: white; color: gray; font-weight: normal; }
      span.name { background-color: white; color: #660000; }
      span.paraname { background-color: white; color: #336600; }
      img { border: 0px; }
      li { font-size: 12pt; }
    </style>
  </head>
  <body>
    <h1>Available XMLRPC methods for this server</h1>
    <h2><a name="index">Index</a></h2>
    <ul>
      <li><a href="#2d6b7f96be69b46a6523f48b4a288864">test.getSomething()</a></li>
    </ul>
    <h2>Details</h2>
    <div class="bloc">
      <h3><a name="2d6b7f96be69b46a6523f48b4a288864"><span class="type">(string)</span> <span class="name">test.getSomething</span><span class="other">(</span><span class="paratype">(array) </span><span class="paraname">something</span>, <span class="paratype">(string) </span><span class="paraname">another_thing</span>, <span class="paratype">(boolean) </span><span class="paraname">credentials</span><span class="other">)</span></a></h3>
      <p><b>Description :</b></p>
      <div class="description">
        returns something
      </div>
      <p><b>Parameters : </b></p>
      <table>
        <tr><td><b>Type</b></td><td><b>Name</b></td><td><b>Documentation</b></td></tr>
        <tr><td>array</td><td>something</td><td>A description</td></tr>
        <tr><td>string</td><td>another_thing</td><td>A description of another thing</td></tr>
        <tr><td>boolean</td><td>credentials</td><td>Whether to return nothing - server doesn't care though</td></tr>
      </table>
      <p>(return to <a href="#index">index</a>)</p>
    </div>
  </body>
</html>
