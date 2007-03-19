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
 * Generates the package*.xml for the FCKeditor in Geeklog
 *
 * @author Christian Weiske <cweiske@cweiske.de>
 * @author Tony Bibbs <tony.bibbs@geeklog.net>
 * @version $Id: buildpackage-end.php,v 1.1 2007/03/19 18:40:39 tony Exp $
 * @copyright The Geeklog Development Team, 2007
 * @todo chmod directories as said in public_html/docs/install.html
 * 
 */

// Set misc package information 
$pkg->setPackage($package);
$pkg->setSummary($summary);
$pkg->setDescription($description);
$pkg->setChannel($channel);

$pkg->setReleaseStability('stable');
$pkg->setAPIStability('stable');
$pkg->setReleaseVersion($version);
$pkg->setAPIVersion($version);

$pkg->setLicense($license);
$pkg->setNotes($notes);

// Our package contains PHP files (not C extension files)
$pkg->setPackageType('php');

// Must be available in new package.xml format
$pkg->setPhpDep('4.3.0');
$pkg->setPearinstallerDep('1.4.2');

// Require custom file role for our web installation
$pkg->addPackageDepWithChannel('required', 'Role_Web', 'pearified.com');

// Define that we will use our custom file role in this script
$pkg->addUsesRole('web', 'Webfiles');

// Mapping misc roles to file name extensions
$pkg->addRole('', 'web');
$pkg->addRole('png', 'web');
$pkg->addRole('gif', 'web');
$pkg->addRole('jpeg', 'web');

$pkg->addRelease();
$pkg->addMaintainer('lead', 'tony', 'Tony Bibbs', 'tony@tonybibbs.com');
$test = $pkg->generateContents();

if (isset($argv[1]) && $argv[1] === 'make') {
    $pkg->writePackageFile();
} else {
    $pkg->debugPackageFile();
}
?>