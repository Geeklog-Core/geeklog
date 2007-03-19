<?php

/* Reminder: always indent with 4 spaces (no tabs). */

/**
 * Geeklog 1.x
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the 
 * GNU General Public License as published by the Free Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See 
 * the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program; if 
 * not, write to the Free Software Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA
 * 02111-1307, USA.
 * 
 *
 */

/**
 * Generates the package.xml for Geeklog Plugins and such have their own buildPackage, or their own
 * package.xml
 *
 * @author Christian Weiske <cweiske@cweiske.de>
 * @author Tony Bibbs <tony.bibbs@geeklog.net>
 * @version $Id: buildpackage.php,v 1.1 2007/03/19 18:40:39 tony Exp $
 * @copyright The Geeklog Development Team, 2007
 * @todo chmod directories as said in public_html/docs/install.html
 * 
 */

/**
 * PEAR::PEAR_PackageFileManager2
 */
require_once 'PEAR/PackageFileManager2.php';

// Set the main package directory
$packagedir  = realpath(dirname(__FILE__) . '\..\..\\');
require_once $packagedir . '/config.php';

// Name of the channel, this package will be distributed through
$channel     = 'pear.geeklog.net';

// Category and name of the package
$category    = 'Applications';
$package     = 'Geeklog';

// Version
$version     = VERSION;

// Summary description
$summary     = <<<EOT
Geeklog is a weblog powered by PHP and MySQL. It allows you within minutes to set up a fully 
functioning dynamic website, and has many features and plugins to customize your site!
EOT;

// Longer description
$description = <<<EOT
GeekLog was originally developed for the Security Geeks web site and was originally authored by 
Jason Whittenburg. In early 2001, Jason decided it was time to devote his time to other things and 
handed the project over to Tony Bibbs who uses Geeklog to run Iowa Outdoors. Tony is currently 
focusing on getting the next generation Geeklog, dubbed GL2, off the ground, while Dirk Haun is now 
maintaining the 1.x branch.

Geeklog is bona fide open-source software and has been released under the GNU GPL for use by others. 
Configuring GeekLog is meant to be an easy process though it will require you to have access to 
several components of your system.

It's assumed that you have some working experience with some form of Apache (or IIS), SQL databases 
(such as MySQL), PHP and PEAR.
EOT;

// License information
$license = 'GPL';

// Notes, included on pear.geeklog.net site to use with care.
$notes = 'Initial PEAR-enabled Release';

// Let PEAR do all the error handling
//PEAR::setErrorHandling(PEAR_ERROR_DIE);

// Instantiate package file manager
$pkg = new PEAR_PackageFileManager2();

// Create a config.php.dist if it does not exist
$strConfigDistFile = $packagedir . '/config.php.dist';
$bConfigCopy = !file_exists($strConfigDistFile);
if ($bConfigCopy) {
    copy(
        $packagedir . '/config.php',
        $strConfigDistFile
    );
}

// Create a lib-custom.php.dist if it does not exist
$strCustDistFile = $packagedir . '/system/lib-custom.php.dist';
$bCustCopy = !file_exists($strCustDistFile);
if ($bCustCopy) {
    copy(
        $packagedir . '/system/lib-custom.php',
        $strCustDistFile
    );
}

// We have some hard coded ignores here but also add all the includes of the subpackages to the 
// ignore list.
$arGlIgnores = array(
    $packagedir . '/config.php',
    $packagedir . '/system/lib-custom.php',
    'package*.xml',
    '*.tgz',
    $packagedir . '/public_html/fckeditor/',
    $packagedir . '/public_html/layout/',
    $packagedir . '/plugins/',
    $packagedir . '/public_html/admin/plugins/',
    $packagedir . '/public_html/calendar/',
    $packagedir . '/public_html/polls/',
    $packagedir . '/public_html/links/',
    $packagedir . '/public_html/staticpages/',
    $packagedir . '/pdfs/',
);

/*foreach ($arIncludes as $arSubpackageIgnores) {
    $arGlIgnores = array_merge($arGlIgnores, $arSubpackageIgnores);
}*/

//print 'packagedir: ' . $packagedir; exit;
// Setting options
$e = $pkg->setOptions(
    array(
        'packagefile'       => 'package.xml',
        // Where are our package files.
        'packagedirectory'  => $packagedir,
        // Where will package files be installed in the local web_dir
        'baseinstalldir'    => 'Geeklog',
        'outputdirectory' => $packagedir . DIRECTORY_SEPARATOR,
        // Just simple output, no MD5 sums and <provides> tags
        'simpleoutput'      => true,
        // Use standard file list generator, choose CVS, if you have your code in CVS
        'filelistgenerator' => 'CVS',

        // List of files to ignore and put not explicitly into the package
        'ignore'            => $arGlIgnores,
        // Global mapping of directories to file roles.
        // @see http://pear.php.net/manual/en/guide.migrating.customroles.defining.php
        'dir_roles'         => array(
            'backups'                  => 'web',
            'system'                   => 'web',
            'language'                 => 'web',
            'plugins'                  => 'web',
            'sql'                      => 'web',
            'data'                     => 'data',
            'logs'                     => 'web',
            'public_html'              => 'web'
        ),
        'roles' => array('*' => 'web'),        
    )
);

// The following modifies the require_once of config.php in lib-common.php automagically
$pkg->addReplacement('public_html/lib-common.php', 'pear-config', '@WEB_DIR@', 'web_dir');
$pkg->addReplacement('public_html/lib-common.php', 'package-info', '@PACKAGE@', 'name');

// PEAR error checking
if (PEAR::isError($e)) {
    die($e->getMessage());
}

// Choices for this are alpha, beta and stable.
$pkg->setReleaseStability('stable');

// Set misc package information.  You shouldn't have to ever change these.
$pkg->setPackage($package);
$pkg->setSummary($summary);
$pkg->setDescription($description);
$pkg->setChannel($channel);
$pkg->setAPIStability('stable');
$pkg->setReleaseVersion($version);
$pkg->setAPIVersion($version);
$pkg->setLicense($license);
$pkg->setNotes($notes);
$pkg->setPackageType('php');
$pkg->setPhpDep('4.3.0');
$pkg->setPearinstallerDep('1.4.2');

// Require custom file role for our web installation
$pkg->addPackageDepWithChannel('required', 'Role_Web', 'pearified.com');

// Geeklog Required Packages.  In a 'typcial' for non-core plugins this wouldn't happen and
// instead the plugins would require a specific version of Geeklog.  In fact, for non-core
// plugins (e.g. Forum, File Manager, etc) that's exactly what should happen
$pkg->addPackageDepWithChannel('required', 'Geeklog_FCKeditor', 'pear.geeklog.net', '2.3.1');
$pkg->addPackageDepWithChannel('required', 'Geeklog_Layout_Professional', 'pear.geeklog.net', $currentGeeklogVersion);
$pkg->addPackageDepWithChannel('required', 'Geeklog_Plugin_Calendar', 'pear.geeklog.net', '1.0.2');
$pkg->addPackageDepWithChannel('required', 'Geeklog_Plugin_Links', 'pear.geeklog.net', '1.1.1');
$pkg->addPackageDepWithChannel('required', 'Geeklog_Plugin_Polls', 'pear.geeklog.net', '2.0.1');
$pkg->addPackageDepWithChannel('required', 'Geeklog_Plugin_Spamx', 'pear.geeklog.net', '1.1.1');
$pkg->addPackageDepWithChannel('required', 'Geeklog_Plugin_Staticpages', 'pear.geeklog.net', '1.4.4');

// Define that we will use our custom file role in this script
$pkg->addUsesRole('web', 'Webfiles');

// Mapping misc roles to file name extensions
$pkg->addRole('', 'web');
$pkg->addRole('png', 'web');
$pkg->addRole('gif', 'web');
$pkg->addRole('jpeg', 'web');

// Create the current release and add it to the package definition
$pkg->addRelease();

// Package release needs a maintainer
$pkg->addMaintainer('lead', 'tony', 'Tony Bibbs', 'tony@tonybibbs.com');

// Internally generate the XML for our package.xml (does not perform output!)
$test = $pkg->generateContents();

// If called without "make" parameter, we just want to debug the generated package.xml file and 
// want to receive additional information on error.
if (isset($argv[1]) AND $argv[1] === 'make') {
    $pkg->writePackageFile();
} else {
    $pkg->debugPackageFile();
}

?>