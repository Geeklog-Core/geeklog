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
$packagedir  = dirname(__FILE__);
$glDir = realpath(dirname(__FILE__).'/../../');

/**
 * Calendar configuration file
 */
require $packagedir . '/config.php';

//print $glDir; exit;

$channel     = 'pear.geeklog.net';
$category    = 'Geeklog Plugins';
$package     = 'Geeklog_Plugin_Calendar';
// Should be actual FCKeditor version number to avoid any confusion
$version     = $_CA_CONF['version'];
$summary     = <<<EOT
Calendar Plugin for Geeklog 1.x
EOT;
$description = <<<EOT
Calendar Plugin for Geeklog 1.x
EOT;
$license     = 'GPL';
$notes       = 'Initial Release';

// Instanciate package file manager
$pkg = new PEAR_PackageFileManager2();

// Setting options
$e = $pkg->setOptions(
    array(
        'packagefile'       => 'package-calendar.xml',
        'outputdirectory'    => $glDir . DIRECTORY_SEPARATOR,
        'packagedirectory'  => $glDir . DIRECTORY_SEPARATOR,        
        'baseinstalldir'    => 'Geeklog',
        'pathtopackagefile' => dirname(__FILE__),
        'filelistgenerator' => 'CVS',
        'ignore'            => array(
                                 'buildpackage*.php',
                                 'package.xml',
                                 '*.tgz'  
                               ),
        'include'           => array(
                                    $packagedir . '/',
                                    $glDir.'/public_html/calendar/',
                                    $glDir . '/public_html/admin/plugins/calendar/'
                               ),
        'simpleoutput'      => true,
        'dir_roles'         => array('*' => 'web'),
        'roles'             => array('*' => 'web'),
    )
);

include $glDir . '/system/build/buildpackage-end.php';

?>