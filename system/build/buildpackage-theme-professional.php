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
 */

/**
 * Generates the package.xml for Geeklog's Professional Theme. 
 *
 * @author Christian Weiske <cweiske@cweiske.de>
 * @author Tony Bibbs <tony.bibbs@geeklog.net>
 * @version $Id: buildpackage-theme-professional.php,v 1.1 2007/03/19 18:40:39 tony Exp $
 * @copyright The Geeklog Development Team, 2007
 * 
 */
require_once 'PEAR/PackageFileManager2.php';

//using this, we don't need to do any error handling ourselves
PEAR::setErrorHandling(PEAR_ERROR_DIE);

// NOTE: this theme uses the same version number as Geeklog because it is shipped by default
$glDir = realpath(dirname(__FILE__).'/../../');
require_once $glDir . '/config.php';
$currentGeeklogVersion = '1.4.1';

$packagedir = $glDir . '\public_html\layout\professional\\';

$channel     = 'pear.geeklog.net';
$category    = 'Geeklog Themes';
$package     = 'Geeklog_Theme_Professional';
$version     = VERSION;
$summary     = <<<EOT
Professional theme for Geeklog.
EOT;
$description = <<<EOT
Professional theme templates for Geeklog.
EOT;
$license     = 'GPL';
$notes       = 'Initial Release';

// Instanciate package file manager
$pkg = new PEAR_PackageFileManager2();

// Setting options
$e = $pkg->setOptions(
    array(
        'packagefile'       => 'package-theme-professional.xml',
        'outputdirectory'   => $glDir . DIRECTORY_SEPARATOR,
        'packagedirectory'  => $glDir . DIRECTORY_SEPARATOR,
        'baseinstalldir'    => 'Geeklog',
        'filelistgenerator' => 'CVS',
        'ignore'            => array('package*.xml','buildpackage*.php'),
        'include'           => array($packagedir),
        'simpleoutput'      => true,
        'dir_roles'         => array('*' => 'web'),
        'roles'             => array('*' => 'web'),
    )
);

include 'buildpackage-end.php';

?>