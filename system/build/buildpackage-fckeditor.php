<?php
/**
*   Generates the package.xml for Geeklog_FCKeditor component.
*
*   @author Christian Weiske <cweiske@cweiske.de>
*/

require_once 'PEAR/PackageFileManager2.php';

//using this, we don't need to do any error handling ourselves
PEAR::setErrorHandling(PEAR_ERROR_DIE);

/* don't modify this */
// Directory where the package files are located.
$glDir = realpath(dirname(__FILE__).'/../../');
$packagedir  = $glDir . '\public_html\fckeditor\\';

$channel     = 'pear.geeklog.net';
$category    = 'Geeklog Plugins';
$package     = 'Geeklog_Plugin_FCKeditor';
// Should be actual FCKeditor version number to avoid any confusion
$version     = '2.3.1';
$summary     = <<<EOT
FCKeditor component for Geeklog.
EOT;
$description = <<<EOT
HTML editor for the browser, adapted for Geeklog.
EOT;
$license     = 'GPL';
$notes       = 'Initial Release';

// Instanciate package file manager
$pkg = new PEAR_PackageFileManager2();

// Setting options
$e = $pkg->setOptions(
    array(
        'packagefile'       => 'package-FCKeditor.xml',
        'packagedirectory'  => $glDir . DIRECTORY_SEPARATOR,
        'outputdirectory'   => $glDir . DIRECTORY_SEPARATOR,
        'baseinstalldir'    => 'Geeklog',
        //'pathtopackagefile' => dirname(__FILE__),
        'filelistgenerator' => 'CVS',
        'ignore'            => array('package*.xml','buildpackage*.php'),
        'include'           => array($packagedir . DIRECTORY_SEPARATOR),
        'simpleoutput'      => true,
        'dir_roles'         => array('*' => 'web'),
        'roles'             => array('*' => 'web'),
    )
);

include 'buildpackage-end.php';

?>