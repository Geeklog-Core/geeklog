<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | pdfgenerator.php                                                               |
// |                                                                           |
// | Geeklog PDF generator.                                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2004 by the following authors:                              |
// |                                                                           |
// | Authors: Justin Carlson    - justin@w3abode.com                           |
// |          Tony Bibbs        - tony@geeklog.net                             |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
// $Id: pdfgenerator.php,v 1.1 2004/06/04 21:44:53 tony Exp $

require_once 'lib-common.php';

/**
* Fetches a PDF from the Geeklog system
*
* @author Tony Bibbs <tony@geeklog.net>
* @access public
* @param string $pdfURL Url to the PDF
*
*/
function PDF_servePDF($pdfFileName)
{
    global $_CONF;
    
    require_once $_CONF['path_system'] . 'classes/downloader.class.php';

    $downloader = new downloader();
    $downloader->setLogFile($_CONF['path_log'] . 'error.log');
    $downloader->setLogging(true);
    $downloader->setAllowedExtensions(array('pdf' => 'application/pdf'));
    $downloader->setPath($_CONF['path_pdf']);
    if (is_file($downloader->getPath() . $pdfFileName)) {
        $downloader->downloadFile($pdfFileName);
    } else {
        header ('HTTP/1.0 404 Not Found');
    }
}

/**
* Generates the PDF and then shows it to the user
*
* NOTE: only pages accessible to the public will work, particularly for
* URL's pointing to an application server (i.e. java, PHP, etc).  That's
* becuase the URL is pulled using fopen so none your session/cookie data
* will get passed.  Seems obvious but probably worth stating
*
*/
function PDF_generatePDF()
{
    global $_CONF;
    
    require_once $_CONF['path_system'] . 'classes/conversion.class.php';
    
    echo COM_siteHeader();
    
    // Grab a logo image is given one:
    if ($_REQUEST['logo']!='') {
        $logo = '--logoimage ' . $_REQUEST['logo'] . ' ';
    }
    
    // Check for submitted data and check the client
    if ($_REQUEST['pageData'] != '') {
        $id = COM_makesid();
        $path = sprintf('%s%s', $_CONF['path_pdf'], $id);
        $urlpath = sprintf('%s/pdfgenerator.php?cmd=getPDF&pdfFile=%s.pdf',$_CONF['site_url'], $id);
        
        if ($_REQUEST['pageType'] == 1 OR !$_REQUEST['pageType']) {
            $_REQUEST['pageData'] = stripslashes($_REQUEST['pageData']);
    
            // Got an HTML page, write to a temp file
            $handle = fopen("$path.html", 'w');
            fwrite($handle, stripslashes($_REQUEST['pageData']));
            fclose($handle);
    
            // Now set the target HTML path
            $target = $path . '.html';
    
            // Uh, what's this?
            $params = '';
    
        } else {
            if ($_REQUEST['pageType'] == 2) {
                // Some sort of server side page, go get it
                // NOTE this should check php.ini to make sure external URL grabbing is allowed
                $file = implode('', file($_REQUEST['pageData']));
                $handle = fopen("$path.html", 'w');
                fwrite($handle, stripslashes($file));
                fclose($handle);
        
                // Now set the target HTML path
                $target = $path.'.html';

                // Uh, what's this?
                $params = '';
            }
        }
    
        $doc = new conversion();
        $doc->addHtml(implode('',file(stripslashes("$path.html"))));
        $file = $doc->convert(1,0);
        $handle = fopen("$path.html",'w');
        fwrite($handle,stripslashes($file));
        fclose($handle);
        $doc = null;
    
        PDF_garbageCollector();
        
        // GENERATE THE PDF
        //exec("htmldoc -t pdf$params --fontsize 9 $logo--webpage '$target' > $path.pdf");
        //echo sprintf("%s -t pdf%s --fontsize %i %s--webpage '%s' > %s.pdf",
        //    $_CONF['path_to_htmldoc'], $params, $_CONF['pdf_font_size'], $_CONF['pdf_logo'], $target, $path);
        //exit;   
        exec(sprintf("%s -t pdf%s --fontsize %i %s--webpage '%s' > %s.pdf",
            $_CONF['path_to_htmldoc'], $params, $_CONF['pdf_font_size'], $_CONF['pdf_logo'], $target, $path));
    
        // CHECK THE PDF FILE SIZE
        $checkSUM = @filesize("$path.pdf");
    
        // IF THE PDF IS LESS THAN 10 BYTES , WE ASSUME ERROR
        if ($checkSUM < 1) {
            echo '<b class="heading">Error</b>';
            echo '<BR/><BR/>';
            echo 'The document provided was not rendered. The document was received but could not be processed.  Please make sure to submit only html formatted documents that have been written';
            echo ' to the xHTML standard. Please note that overly complex html documents may not render correctly or at all.';
                echo '<BR/><BR/>';
            echo 'The document resulting from your attempt was 0 bytes in length, and has been deleted. If you\'re sure that your document should render fine, please re-submit it.';
                echo '<BR/><BR/>';
            echo '<i>error nr1001 - '.@filesize("$path.html").'</i>';
            echo '<BR/><BR/>';
            echo '<BR/><BR/>';
            echo '<A HREF="'.$clientURL.'" class="button">Back</A>';
        } else {	
            echo '<b class="heading">Loading your document.</b>';
                echo '<BR/><BR/>';
            echo 'Please wait while your document is loaded.';
            echo '<BR/><BR/>';
            echo 'You may right click the button below and choose \'save target...\' or \'save link location...\' to save a copy of your document.';
            echo '<BR/><BR/>';
            echo $pageText;
            echo '<BR/><BR/>';
            echo '<A CLASS="button" HREF="'.$urlpath.'.pdf">PDF</A>';
            $foot2='<div style="font-size:6pt;width:750;padding:1px;background:url(\'images/working.gif\');border-bottom:2px solid //000000;border-right:2px solid //000000;border-left:2px solid //000000;text-align:center;font-family:arial,verdana,san-serif;color://ffffff;">Processing your request...</div>';
    
            if (!$_REQUEST['instant'] OR $_REQUEST['instant'] == 0) {
                if ($waitTime > 30 OR $waitTime < 5 OR !$waitTime) {
                    $waitTime=10;
                }
                echo "<META HTTP-EQUIV=REFRESH CONTENT=\"$waitTime; URL='$urlpath\">";
            } else {
                echo "<META HTTP-EQUIV=REFRESH CONTENT=\"0; URL='$urlpath\">";
            }
        }
    } else {
        if (!$_REQUEST['pageData']) {
            echo 'No page data was given.  PDF generation cannot continue';
        } else {
            echo 'Unknown error during PDF generation';
        }
    }
    
    //$display .= COM_siteFooter();
    echo COM_siteFooter();
}

/**
* Deletes any old PDF's
*
* The PDF generator puts the PDF's it builds into a directory specifie by
* $_CONF['path_pdf'].  To conserve space, this method checks any existing PDF's
* to see if they are ready to be deleted
* 
* @author Tony Bibbs <tony@geeklog.net>
* @access public
* @return int Number of PDF's deleted
* 
*/
function PDF_garbageCollector()
{
    global $_CONF;
    
    // Open directory and read in files
    $fd = opendir($_CONF['path_pdf']);
    
    $numDeleted = 0;
    while (($curFile = @readdir($fd)) == TRUE ) {
        if (stristr($curFile,'.pdf') AND is_file($_CONF['path_pdf'] . $curFile)) {
            $diff = COM_dateDiff('h', time(), filemtime($_CONF['path_pdf'] . $curFile));
            // Ensure a sane # of days to keep was given
            if ($_CONF['days_to_keep'] == 0 OR empty($_CONF['days_to_keep'])) {
                $_CONF['days_to_keep'] = 1;
            }
            // Delete the file if it is older than our configured threshold
            if ($diff > (24 * $_CONF['days_to_keep'])) {
                if (!unlink($_CONF['path_pdf'] . $curFile)) {
                    // Unable to delete the file
                    COM_errorLog(sprintf('PDF_garbageCollector() was unable to delete file: %s%s',
                        $_CONF['path_pdf'], $curFile));
                } else {
                    $numDeleted = $numDelete + 1;
                }
            }
        }
    }
    return $numDeleted;
}

if ($_REQUEST['cmd'] == 'getPDF') {
    PDF_servePDF($_REQUEST['pdfFile']);
} else {
    PDF_generatePDF();
}

?>