Crash Course on Building Geeklog's PEAR packages
-------------------------------------------------
1) If you have added or changed default options for Geeklog's config.php, copy config.php to 
   config.php.dist and be sure to check in the changes to CVS.  NOTE: config.php isn't shipped in 
   PEAR-based releases that's why this is so important.
   
2) Open shell in windows and unix and build the PEAR package XML files.  These files contain all
   the metadata about a package:
   
   #>php build-geeklog-packagexmls.hp
   
3) Verify you have at least eight package*.xml files in /path/to/geeklog/.  Five of them should be
   for the core Geeklog plugins along with one for the Professional theme, one for FCKeditor and
   one for Geeklog itself.  If one didn't build or didn't build properly you will want to generate
   the PEAR XML by hand to debug. Each plugin has their own buildpackage.php file in 
   /path/to/geeklog/plugins/[plugin_name] that you can run as either with:
   
   #>php buildpackage.php
   
   ...which outputs the XML to the screen OR by running
   
   #>php buildpackage.php make
   
   ...which otuputs the XML in an XML file in /path/to/geeklog
   
4) Using the same shell from step #3 build the PEAR compatible tarballs

   #>php build-geeklog-pear-packages.php
   
   ...or
   
   #>php build-geeklog-pear-package.php keepXML
   
   ...which keeps the package*.xml files around in case you were to need them for something else
   
5) Verify this worked by looking in /path/to/geeklog/system/build for all the .tgz files.  Then you
   should verify further by running:
   
   #>pear install [package_tarball]
   
   ...for each package you created
   
6) Once you have tested everything for your release, please upload the tarballs from step #4 to 
   pear.geeklog.net which publishes them to the public
   
Description of Files
---------------------

build-geeklog-packagexmls.php - Scans the entire GL tree for buildpackage.php files.  For the ones
it finds it runs them which generates a package*.xml file that is then used to build the PEAR
compatible files

build-geeklog-pear-packages.php - Scans the entire GL tee for package*.xml and then runs "pear 
package" on it to create the PEAR compatible .tgz file.

buildpackage-end.php - Used by most buildpackage.php files to do common finsihing tasks

buildpackage-fckeditor.php - Builds the package XML for FCKeditor

buildpackage-theme-professional.php - Builds the package XML for the Professional theme

buildpackage.php - Builds the package XML for Geeklog itself.

Important Note
----------------

This is directory is where PEAR build data and files should go.  There is a "bug" in PEAR that 
prevents us from puting the PEAR package XML files in this directory.  Namely, despite the fact we
specify the "packagedirectory" option with PEAR_PackageFileManager2 the XML files must be in the
root of the project for it to work.  I am working with the PEAR developers to ensure this is, in
fact a bug and if they agree get a patch.