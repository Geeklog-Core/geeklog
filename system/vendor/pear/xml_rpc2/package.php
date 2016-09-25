<?php
/**
 * This is the package.xml generator for XML_RPC2
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   XML
 * @package    XML_RPC2
 * @author     Sergio Carvalho <sergiosgc@php.net>
 * @copyright  2005-2007 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: package.php,v 1.37 2007/11/20 20:04:24 farell Exp $
 * @link       http://pear.php.net/package/PEAR_PackageFileManager
 * @since      File available since Release 1.6.0
 */
require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$release_version = '1.1.3';
$release_state   = 'stable';
$api_version     = '1.0.5';
$api_state   = 'stable';
$release_notes   = 'QA release
Fix issues when installed via composer
';

$packagexml = new PEAR_PackageFileManager2();
$packagexml->setOptions(
    array(
      'packagefile' => 'package.xml',
      'exceptions' => array(
          'ChangeLog' => 'doc',
          'NEWS' => 'doc'),
      'filelistgenerator' => 'file',
      'packagedirectory' => dirname(__FILE__),
      'changelogoldtonew' => false,
      'baseinstalldir' => '/',
      'simpleoutput' => true,
      'dirroles' => array('tests' => 'test'),
      'ignore' => array('package.php', '_MTN/', '.svn'),
      ));
$packagexml->setPackage('XML_RPC2');
$packagexml->setSummary('XML-RPC client/server library');
$packagexml->setDescription(<<<EOS
XML_RPC2 is a pear package providing XML_RPC client and server services. XML-RPC is a simple remote procedure call protocol built using HTTP as transport and XML as encoding.
    As a client library, XML_RPC2 is capable of creating a proxy class which exposes the methods exported by the server. As a server library, XML_RPC2 is capable of exposing methods from a class or object instance, seamlessly exporting local methods as remotely callable procedures.
EOS
);
$packagexml->addMaintainer('lead', 'sergiosgc', 'Sergio Carvalho', 'sergiosgc@php.net');
$packagexml->addMaintainer('developer', 'fab', 'Fabien MARTY', 'fab@php.net');
$packagexml->addMaintainer('developer', 'instance', 'Alan Langford', 'jal@ambitonline.com');
$packagexml->setNotes($release_notes);
$packagexml->addIgnore(array('package.php', '*.tgz'));
$packagexml->setPackageType('php');
$packagexml->addRelease();
$packagexml->clearDeps();
$packagexml->detectDependencies();
$packagexml->addPackageDepWithChannel('required', 'HTTP_Request2', 'pear.php.net', '2.0.0');
$packagexml->addPackageDepWithChannel('required', 'Cache_Lite', 'pear.php.net', '1.6.0');
$packagexml->setChannel('pear.php.net');
$packagexml->setLicense('LGPL', 'http://www.gnu.org/copyleft/lesser.html');
$packagexml->setReleaseVersion($release_version);
$packagexml->setAPIVersion($api_version);
$packagexml->setReleaseStability($release_state);
$packagexml->setAPIStability($api_state);
$packagexml->setPhpDep('5.0.0');
$packagexml->setPearinstallerDep('1.5.4');
$packagexml->generateContents();
$packagexml->writePackageFile();
?>
