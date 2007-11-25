<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | check.php                                                                 |
// |                                                                           |
// | Geeklog check installation script                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2002-2006 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun        - dirk AT haun-online DOT de                    |
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
// $Id: check.php,v 1.9 2007/11/25 06:58:55 ospiess Exp $

/**
* This script tests the file and directory permissions, thus addressing the
* most common errors / omissions when setting up a new Geeklog site ...
*
* @author   Dirk Haun <dirk AT haun-online DOT de>
*
*/

require_once ('../../lib-common.php');

$numTests   = 7;  // total number of tests to perform
$successful = 0;  // number of successful tests
$failed     = 0;  // number of failed tests
$notTested  = 0;  // number of tests that were skipped (for disabled features)

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . LB;
echo '<html>' . LB;
echo '<head>' . LB;
echo '<title>Geeklog installation check</title>' . LB;
echo '</head>' . LB;
echo '<body text="#000000" bgcolor="#ffffff">' . LB;
echo '<h2>Testing your Geeklog installation ...</h2>' . LB;

echo '<p>Testing <b>logs</b> directory ' . $_CONF['path_log'] . ' ...<br' . XHTML . '>' . LB;
$errfile = @fopen ($_CONF['path_log'] . 'error.log', 'a');
if ($errfile) fclose ($errfile);
$accfile = @fopen ($_CONF['path_log'] . 'access.log', 'a');
if ($accfile) fclose ($accfile);

if (!$errfile || !$accfile) {
    echo '<font color="#ff0000">Could not open ';
    if (!$errfile) {
        echo '<b>error.log</b> ';
    }
    if (!$errfile && !$accfile) {
        echo 'and ';
    }
    if (!$accfile) {
        echo '<b>access.log</b> ';
    }
    echo 'for writing.</font><br' . XHTML . '>Please check that you have set the <b>logs</b> directory <em>and</em> the files <b>error.log</b> and <b>access.log</b> in that directory to <b>chmod 775</b>.' . LB;
    $logPerms = sprintf ("%3o", @fileperms ($_CONF['path_log']) & 0777);
    $errPerms = sprintf ("%3o", @fileperms ($_CONF['path_log'] . 'error.log') & 0777);
    $accPerms = sprintf ("%3o", @fileperms ($_CONF['path_log'] . 'access.log') & 0777);
    echo '<table cellspacing="0" cellpadding="0" border="0">' . LB;
    echo "<tr><td>Current permissions for <b>logs</b>:&nbsp;</td><td>$logPerms</td></tr>" . LB;
    echo "<tr><td>Current permissions for <b>error.log</b>:&nbsp;</td><td>$errPerms</td></tr>" . LB;
    echo "<tr><td>Current permissions for <b>access.log</b>:&nbsp;</td><td>$accPerms</td></tr>" . LB;
    echo '</table>' . LB;
    $failed++;
} else {
    echo '<b>logs</b> directory and the <b>error.log</b> and <b>access.log</b> files are okay.' . LB;
    $successful++;
}

echo '<p>Testing <b>backend</b> directory ' . SYND_getFeedPath() . ' ...<br' . XHTML . '>' . LB;
if ($_CONF['backend'] > 0) {
    if (!$file = @fopen ($_CONF['rdf_file'], 'w')) {
        echo '<font color="#ff0000">Could not open the RSS file ' . $_CONF['rdf_file'] . ' for writing.</font><br' . XHTML . '>Please check that you have set both the <b>backend</b> directory <em>and</em> the <b>geeklog.rss</b> file in that directory to <b>chmod 775</b>.' . LB;
        $endPerms = sprintf ("%3o", @fileperms (SYND_getFeedPath()) & 0777);
        $rdfPerms = sprintf ("%3o", @fileperms ($_CONF['rdf_file']) & 0777);
        echo '<table cellspacing="0" cellpadding="0" border="0">' . LB;
        echo "<tr><td>Current permissions for <b>backend</b>:&nbsp;</td><td>$endPerms</td></tr>" . LB;
        echo "<tr><td>Current permissions for <b>geeklog.rss</b>:&nbsp;</td><td>$rdfPerms</td></tr>" . LB;
        echo '</table>' . LB;
        $failed++;
    } else {
        fclose ($file);
        echo '<b>backend</b> directory and the <b>geeklog.rss</b> file are okay.' . LB;
        $successful++;
    }
} else {
    echo '<p>Export of Geeklog headlines is switched off - <b>backend</b> directory not tested.</p>' . LB;
    $notTested++;
}

if ($_CONF['allow_user_photo'] > 0) {
    echo '<p>Testing <b>userphotos</b> directory ' . $_CONF['path_images'] . 'userphotos/ ...<br' . XHTML . '>' . LB;
    if (!$file = @fopen ($_CONF['path_images'] . 'userphotos/test.gif', 'w')) {
        echo '<font color="#ff0000">Could not write to <b>' . $_CONF['path_images'] . 'userphotos/</b>.</font><br' . XHTML . '>Please make sure this directory exists and is set to <b>chmod 775</b>.<br' . XHTML . '>' . LB; 
        echo 'Current permissions for <b>userphotos</b>: ' . sprintf ("%3o", @fileperms ($_CONF['path_images'] . 'userphotos/') & 0777);
        $failed++;
    } else {
        fclose ($file);
        unlink ($_CONF['path_images'] . 'userphotos/test.gif');
        echo '<b>userphotos</b> directory is okay.' . LB;
        $successful++;
    }
} else {
    echo '<p>User photos are disabled - <b>userphotos</b> directory not tested.' . LB;
    $notTested++;
}

if ($_CONF['maximagesperarticle'] > 0) {
    echo '<p>Testing <b>articles</b> directory ' . $_CONF['path_images'] . 'articles/ ...<br' . XHTML . '>' . LB;
    if (!$file = @fopen ($_CONF['path_images'] . 'articles/test.gif', 'w')) {
        echo '<font color="#ff0000">Could not write to <b>' . $_CONF['path_images'] . 'articles/</b>.</font><br' . XHTML . '>Please make sure this directory exists and is set to <b>chmod 775</b>.<br' . XHTML . '>' . LB; 
        echo 'Current permissions for <b>articles</b>: ' . sprintf ("%3o", @fileperms ($_CONF['path_images'] . 'articles/') & 0777);
        $failed++;
    } else {
        fclose ($file);
        unlink ($_CONF['path_images'] . 'articles/test.gif');
        echo '<b>articles</b> directory is okay.' . LB;
        $successful++;
    }
} else {
    echo '<p>Images in articles are disabled - <b>articles</b> directory not tested.' . LB;
    $notTested++;
}

echo '<p>Testing <b>topics</b> directory ' . $_CONF['path_images'] . 'topics/ ...<br' . XHTML . '>' . LB;
if (!$file = @fopen ($_CONF['path_images'] . 'topics/test.gif', 'w')) {
    echo '<font color="#ff0000">Could not write to <b>' . $_CONF['path_images'] . 'topics/</b>.</font><br' . XHTML . '>Please make sure this directory exists and is set to <b>chmod 775</b>.<br' . XHTML . '>' . LB; 
    echo 'Current permissions for <b>topics</b>: ' . sprintf ("%3o", @fileperms ($_CONF['path_images'] . 'articles/') & 0777);
    $failed++;
} else {
    fclose ($file);
    unlink ($_CONF['path_images'] . 'topics/test.gif');
    echo '<b>topics</b> directory is okay.' . LB;
    $successful++;
}

/*

if ($_CONF['pdf_enabled'] != 0) {
    echo '<p>Testing <b>pdfs</b> directory ' . $_CONF['path_pdf'] . ' ...<br' . XHTML . '>' . LB;
    if (!$file = @fopen ($_CONF['path_pdf'] . 'test.pdf', 'w')) {
        echo '<font color="#ff0000">Could not write to <b>' . $_CONF['path_pdf'] . '</b>.</font><br' . XHTML . '>Please make sure this directory exists and is set to <b>chmod 775</b>.<br' . XHTML . '>' . LB; 
        echo 'Current permissions for <b>pdfs</b>: ' . sprintf ("%3o", @fileperms ($_CONF['path_pdf']) & 0777);
        $failed++;
    } else {
        fclose ($file);
        unlink ($_CONF['path_pdf'] . 'test.pdf');
        echo '<b>pdfs</b> directory is okay.' . LB;
        $successful++;
    }
} else {
    echo '<p>PDF support is disabled - <b>pdfs</b> directory not tested.' . LB;
    $notTested++;
}

*/

if ($_CONF['allow_mysqldump'] == 1) {
    echo '<p>Testing <b>backups</b> directory ' . $_CONF['backup_path'] . ' ...<br' . XHTML . '>' . LB;
    if (!$file = @fopen ($_CONF['backup_path'] . 'test.txt', 'w')) {
        echo '<font color="#ff0000">Could not write to <b>' . $_CONF['backup_path'] . '</b>.</font><br' . XHTML . '>Please make sure this directory exists and is set to <b>chmod 775</b>.<br' . XHTML . '>' . LB; 
        echo 'Current permissions for <b>backups</b>: ' . sprintf ("%3o", @fileperms ($_CONF['backup_path']) & 0777);
        $failed++;
    } else {
        fclose ($file);
        unlink ($_CONF['backup_path'] . 'test.txt');
        echo '<b>backups</b> directory is okay.' . LB;
        $successful++;
    }
} else {
    echo '<p>Database backups are disabled - <b>backups</b> directory not tested.' . LB;
    $notTested++;
}

echo '<p>Testing <b>data</b> directory ' . $_CONF['path_data'] . ' ...<br' . XHTML . '>' . LB;
if (!$file = @fopen ($_CONF['path_data'] . 'test.txt', 'w')) {
    echo '<font color="#ff0000">Could not write to <b>' . $_CONF['path_data'] . '</b>.</font><br' . XHTML . '>Please make sure this directory exists and is set to <b>chmod 775</b>.<br' . XHTML . '>' . LB; 
    echo 'Current permissions for <b>data</b>: ' . sprintf ("%3o", @fileperms ($_CONF['path_data']) & 0777);
    $failed++;
} else {
    fclose ($file);
    unlink ($_CONF['path_data'] . 'test.txt');
    echo '<b>data</b> directory is okay.' . LB;
    $successful++;
}

echo "<p><strong>Results:</strong> " . ($numTests - $notTested) . " of $numTests tests performed: $successful successful, ";
if ($failed > 0) {
    echo "<font color=\"#ff0000\">$failed failed</font>.</p>" . LB;
} else {
    echo "$failed failed.</p>" . LB;
}

if ($failed > 0) {
    echo '<h2>Test failed!</h2>';
    echo '<p><font color="#ff0000"><strong>Warning!</strong> Your Geeklog site is not set up properly. Please fix the errors listed above!</font></p>';
    echo '<p><strong>Note:</strong> If the above instructions tell you to chmod files and/or directories to 775 but they already are at 775, try <b>chmod 777</b> instead.</p>';
} else {
    echo '<h2>Test passed</h2>';
    echo '<p><strong>Congratulations!</strong> Your Geeklog site is set up properly and ready to go.</p>';
}

echo '</body>' . LB;
echo '</html>' . LB;

?>
