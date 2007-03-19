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
 * Static page configuration file
 */
require $packagedir . '/config.php';

$channel     = 'pear.geeklog.net';
$category    = 'Geeklog Plugins';
$package     = 'Geeklog_Plugin_Staticpages';
// Should be actual FCKeditor version number to avoid any confusion
$version     = $_SP_CONF['version'];
$summary     = <<<EOT
Staticpages Plugin for Geeklog 1.x
EOT;
$description = <<<EOT
Staticpages Plugin for Geeklog 1.x
EOT;
$license     = 'GPL';
$notes       = 'Initial Release';

// Instanciate package file manager
$pkg = new PEAR_PackageFileManager2();

// Setting options
$e = $pkg->setOptions(
    array(
        'packagefile'       => 'package-staticpages.xml',
        'packagedirectory'  => $glDir  . DIRECTORY_SEPARATOR,
        'baseinstalldir'    => 'Geeklog',
        'outputdirectory'    => $glDir . DIRECTORY_SEPARATOR,
        'pathtopackagefile' => dirname(__FILE__),
        'filelistgenerator' => 'CVS',
        'ignore'            => array(
                                 'buildpackage*.php',
                                 'package.xml',
                                 '*.tgz'  
                               ),
        'include'           => array(
                                    $packagedir . '/',
                                    $glDir.'/public_html/staticpages/',
                                    $glDir . '/public_html/admin/plugins/staticpages/',
                                    $glDir . '/public_html/javascript/staticpages_fckeditor.js',
                               ),
        'simpleoutput'      => true,
        'dir_roles'         => array('*' => 'web'),
        'roles'             => array('*' => 'web'),
    )
);

include $glDir . '/system/build/buildpackage-end.php';

?>