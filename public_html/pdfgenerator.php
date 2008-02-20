<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | pdfgenerator.php                                                          |
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
// $Id: pdfgenerator.php,v 1.13 2008/02/20 20:07:58 mjervis Exp $

require_once 'lib-common.php';

// Ensure the PDF feature is even enabled
if ($_CONF['pdf_enabled'] == 0 OR
    (($_CONF['pdf_enabled'] == 1) AND ($_CONF['pdf_adhoc_enabled'] == 0) AND (!SEC_inGroup('Root')))) {
    echo COM_siteHeader();
    echo $LANG_PDF[1];
    echo COM_siteFooter();
    exit;
} else {
    // Ensure we got a handle to a valid HTMLDoc binary
    if (function_exists('is_executable')) {
        $is_exec = is_executable($_CONF['path_to_htmldoc']);
    } else {
        $is_exec = file_exists($_CONF['path_to_htmldoc']);
    }
    if (!$is_exec) {
        echo COM_siteHeader();
        echo $LANG_PDF[8];
        echo COM_siteFooter();
        exit;
    }
    // Ensure we can open URL's using fopen
    if (!ini_get('allow_url_fopen')) {
        echo COM_siteHeader();
        echo $LANG_PDF[13];
        echo COM_siteFooter();
        exit;
    }
}

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
    global $_CONF, $LANG_PDF;
    
    require_once $_CONF['path_system'] . 'classes/downloader.class.php';
    
    $downloader = new downloader();
    $downloader->setLogFile($_CONF['path_log'] . 'error.log');
    $downloader->setLogging(true);
    $downloader->setAllowedExtensions(array('pdf' => 'application/pdf'));
    $downloader->setPath($_CONF['path_pdf']);
    $fileToGet = $_CONF['path_pdf'] . $pdfFileName;
    // OK, now make sure the file they requested exists and ensure they didn't
    // try to use relative pathing (e.g. ../../some.pdf)
    if ((dirname(realpath($fileToGet)) == strtolower(realpath($_CONF['path_pdf']))) AND
       (is_file($fileToGet))) {
        if (!$downloader->downloadFile($pdfFileName)) {
            echo COM_siteHeader();
            $downloader->printErrors();
            echo COM_siteFooter();
        }
    } else {
        echo COM_siteHeader();
        echo $LANG_PDF[14];
        echo COM_siteFooter();
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
    global $_CONF, $LANG_PDF;
    
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
                // Optionally, use HTML tidy
                if (!extension_loaded('tidy')) {
                    $_CONF['use_html_tidy'] = 0;
                    COM_errorLog('WARNING: PDF generator settings in config.php indicate we should use HTML Tidy but the
                        tidy extension is not loaded into PHP so we are skipping calls to tidy');
                }
                if ($_CONF['use_html_tidy'] == 1) {
                    $tidy  = tidy_parse_file($_REQUEST['pageData'], $_CONF['tidy_options']);
                    $tidy->cleanRepair();
                    fwrite($handle(stripslashes(tidy_get_output($tidy))));
                } else {
                    $file = implode('', file($_REQUEST['pageData']));
                    $handle = fopen("$path.html", 'w');
                    fwrite($handle, stripslashes($file));
                }
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
        
        // Generate call to HTMLDoc
        $cmd = sprintf("%s -t pdf%s --fontsize %i %s--webpage '%s' > %s.pdf",
            $_CONF['path_to_htmldoc'], $params, $_CONF['pdf_font_size'], $_CONF['pdf_logo'], $target, $path);
        exec($cmd);
    
        // CHECK THE PDF FILE SIZE
        $checkSUM = @filesize("$path.pdf");
    
        // IF THE PDF IS LESS THAN 10 BYTES , WE ASSUME ERROR
        if ($checkSUM < 1) {
            echo $LANG_PDF[2];
            COM_errorLog($LANG_PDF . ' COMMAND EXECUTED: ' . $cmd);
        } else {
            $pdf = new Template( $_CONF['path_layout'] . 'pdfgenerator/');
            $pdf->set_file( array(
            'pdf'         => 'pdf.thtml'
            ));

            $pdf->set_var( 'xhtml', XHTML );
            $pdf->set_var('layout_url', $_CONF['layout_url']);
            $pdf->set_var('site_url', $_CONF['site_url']);
            $pdf->set_var('site_admin_url', $_CONF['site_admin_url']);
            $pdf->set_var('lang_loading_document', $LANG_PDF[5]);
            $pdf->set_var('lang_please_wait', $LANG_PDF[6]);
            $pdf->set_var('lang_right_click', $LANG_PDF[7]);
            $pdf->set_var('page_text', $pageText);
            $pdf->set_var('pdf_url', $urlpath);
            if (!$_REQUEST['instant'] OR $_REQUEST['instant'] == 0) {
                if ($waitTime > 30 OR $waitTime < 5 OR !$waitTime) {
                    $waitTime=10;
                }
                $pdf->set_var('meta_tag', "<meta http-equiv=\"refresh\" content=\"$waitTime; url=$urlpath\"" . XHTML . ">");
            } else {
                $pdf->set_var('meta_tag', "<meta http-equiv=\"refresh\" content=\"0; url=$urlpath\"" . XHTML . ">");
            }
            $pdf->parse('page', 'pdf' );
            echo $pdf->finish($pdf->get_var('page'));
        }
    } else {
        if (!$_REQUEST['pageData']) {
            $pdf = new Template( $_CONF['path_layout'] . 'pdfgenerator/');
            $pdf->set_file( array(
            'pdf'         => 'pdf_form.thtml'
            ));

            $pdf->set_var( 'xhtml', XHTML );
            $pdf->set_var('layout_url', $_CONF['layout_url']);
            $pdf->set_var('site_url', $_CONF['site_url']);
            $pdf->set_var('site_admin_url', $_CONF['site_admin_url']);
            $pdf->set_var('lang_error_msg', $LANG_PDF[4]);
            $pdf->set_var('lang_pdf_generator', $LANG_PDF[9]);
            $pdf->set_var('lang_instructions', $LANG_PDF[10]);
            $pdf->set_var('lang_URL', $LANG_PDF[11]);
            $pdf->set_var('lang_generate_pdf', $LANG_PDF[12]);
            $pdf->parse('page', 'pdf' );
            echo $pdf->finish($pdf->get_var('page'));
        } else {
            echo $LANG_PDF[3];
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
