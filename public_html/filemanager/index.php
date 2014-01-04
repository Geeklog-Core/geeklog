<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | index.php                                                                 |
// |                                                                           |
// | Filemanager browser                                                       |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2013 by the following authors:                              |
// |                                                                           |
// | Authors: Riaan Los       - mail AT riaanlos DOT nl                        |
// |          Simon Georget   - simon AT linea21 DOT com                       |
// |          Kenji ITO       - geeklog AT mystral-kk DOT net                  |
// +---------------------------------------------------------------------------+
// | Original file "index.html" is licensed under MIT License.                 |
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

require_once dirname(__FILE__) . '/../lib-common.php';

/**
* Converts formats used in strftime() into counterparts used in date()
*
* @param   string   $format    a format string used for strftime() function
* @return  string              a format string used for date() function
*/
function convertDateTimeFormat($format) {
	$table = array(
		// strftime()               => date()
		'%h' => '%b',				// = %b
		'%r' => '%I:%M:%S %p',		// = "%I:%M:%S %p"
		'%R' => '%H:%M',			// = "%H:%M"
		'%T' => '%H:%M:%S',			// = "%H:%M:%S"
		'%D' => '%m/%d/%y',			// = "%m/%d/%y"
		'%F' => '%Y-%m-%d',			// = "%Y-%m-%d"
		'%X' => 'H:i:s',			// ?: '03:59:16', '15:59:16', ...
		'%c' => 'D M j H:i:s Y',	// ?: 'Tue Feb 5 00:45:10 2009'
		'%x' => 'm/d/y',			// ?: 02/05/09

		'%a' => 'D',				// abbr. day: 'Sun', 'Mon', ...
		'%A' => 'l',				// day: 'Sunday', 'Monday', ...
		'%d' => 'd',				// day of the month: '01', '02', ..., '31'
		'%e' => 'j',				// day of the month: ' 1', ' 2', ..., '31'
		'%j' => '?',				// day of the year: '001' ... '366'
		'%u' => 'N',				// ISO-8601 day of the week: 1 = Monday, 7 = Sunday
		'%w' => 'w',				// day of the week: 0 = Sunday, 6 = Saturday
		'%U' => 'W',				// week number: 1, 2, ...
		'%V' => 'W',				// ISO-8601:1988 week number: 01 ... 53
		'%W' => 'W',				// week number: 1, 2, ...
		'%b' => 'M',				// abbr. month name: 'Jan', 'Feb', ...
		'%B' => 'F',				// month name: 'January', 'February', ...
		'%m' => 'm',				// month: '01' ... '12'
		'%C' => '?',				// century: 19 = 20th century
		'%g' => 'y',				// year: 09 = 2009
		'%G' => 'Y',				// year: 2009
		'%y' => 'y',				// year: 09 = 2009, 79 = 1979
		'%Y' => 'Y',				// year: 2009
		'%H' => 'H',				// hour: 00 ... 23
		'%k' => 'G',				// hour: ' 0', ' 1' ... '23'
		'%I' => 'h',				// hour: 01 ... 12
		'%l' => 'g',				// hour: ' 1', ' 2' ... '12'
		'%M' => 'i',				// minute: 00 ... 59
		'%p' => 'A',				// 'AM' | 'PM'
		'%P' => 'a',				// 'am' | 'pm'
		'%S' => 's',				// second: 00 ... 59
		'%z' => 'O',				// time zone offset: -0500
		'%s' => 'U',				// Unix Epoch Time timestamp: 305815200 = 'September 10, 1979 08:40:00 AM'
		'%n' => "\n",				// "\n"
		'%t' => "\t",				// "\t"
		'%%' => '%',				// '%'
	);

	$retval = '';
	$keys   = array_keys($table);
	$values = array_values($table);
	
	foreach (explode('%%', $format) as $part) {
		$retval .= str_replace($keys, $values, $part);
	}
	
	return $retval;
}

//=============================================================================
// Main
//=============================================================================

if (!$_CONF['advanced_editor'] || !$_USER['advanced_editor'] || COM_isAnonUser()) {
	COM_handle404();
	exit;
}

// Checks a referer
$refererCheck = false;
COM_errorLog('$_SERVER[\'HTTP_REFERER\'] = ' . $_SERVER['HTTP_REFERER']);

$validReferers = array(
	// CKEditor
	$_CONF['site_admin_url'] . '/story.php?mode=edit',
	$_CONF['site_admin_url'] . '/plugins/staticpages/index.php?mode=edit',
	
	// FCKeditor
	$_CONF['site_url'] . '/editors/fckeditor/editor/dialog/fck_flash.html',
	$_CONF['site_url'] . '/editors/fckeditor/editor/dialog/fck_image.html',
	$_CONF['site_url'] . '/editors/fckeditor/editor/dialog/fck_link.html',
);

foreach ($validReferers as $referer) {
	if (stripos($_SERVER['HTTP_REFERER'], $referer) === 0) {
		$refererCheck = true;
		break;
	}
}

if (!$refererCheck) {
	COM_handle404();
	exit;
}

// Add extra checks here




// Default values defined in filemanager.config.js.dist
$_FILEMANAGER_CONF = array(
	'_comment' => 'IMPORTANT : go to the wiki page to know about options configuration https://github.com/simogeo/Filemanager/wiki/Filemanager-configuration-file',
	'options' => array(
		'culture' => 'en',
		'lang' => 'php',
		'defaultViewMode' => 'grid',
		'autoload' => true,
		'showFullPath' => false,
		'browseOnly' => false,
		'showConfirmation' => true,
		'showThumbs' => true,
		'generateThumbnails' => true,
		'searchBox' => true,
		'listFiles' => true,
		'fileSorting' => 'default',
		'chars_only_latin' => true,
		'dateFormat' => 'd M Y H:i',
		'serverRoot' => false,
		'fileRoot' => true,
		'relPath' => false,
		'logger' => false,
		'capabilities' => array('select', 'download', 'rename', 'move', 'delete'),
		'plugins' => array()
	),
	'security' => array(
		'uploadPolicy' => 'DISALLOW_ALL',
		'uploadRestrictions' => array(
			'jpg',
			'jpeg',
			'gif',
			'png',
			'svg',
			'txt',
			'pdf',
			'odp',
			'ods',
			'odt',
			'rtf',
			'doc',
			'docx',
			'xls',
			'xlsx',
			'ppt',
			'pptx',
			'ogv',
			'mp4',
			'webm',
			'ogg',
			'mp3',
			'wav'
		)
	),
	'upload' => array(
		'overwrite' => false,
		'imagesOnly' => false,
		'fileSizeLimit' => 16
	),
	'exclude' => array(
		'unallowed_files' => array(
			'.htaccess'
		),
		'unallowed_dirs' => array(
			'_thumbs',
			'.CDN_ACCESS_LOGS',
			'cloudservers'
		),
		'unallowed_files_REGEXP' => '/^\\./uis',
		'unallowed_dirs_REGEXP' => '/^\\./uis'
	),
	'images' => array(
		'imagesExt' => array(
			'jpg',
			'jpeg',
			'gif',
			'png',
			'svg'
		)
	),
	'videos' => array(
		'showVideoPlayer' => true,
		'videosExt' => array(
			'ogv',
			'mp4',
			'webm'
		),
		'videosPlayerWidth' => 400,
		'videosPlayerHeight' => 222
	),
	'audios' => array(
		'showAudioPlayer' => true,
		'audiosExt' => array(
			'ogg',
			'mp3',
			'wav'
		)
	),
	'extras' => array(
		'extra_js' => array(),
		'extra_js_async' => true
	),
	'icons' => array(
		'path' => 'images/fileicons/',
		'directory' => '_Open.png',
		'default' => 'default.png'
	)
);

// Values to be overridden by Geeklog
$_CONF['path_html'] = str_replace('\\', '/', $_CONF['path_html']);
$fileRoot = $_CONF['path_html'] . 'images/library/';
$docRoot  = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

$_FILEMANAGER_CONF['options']['capabilities'] = array(
	'select', 'download', 'rename', 'move', 'delete'
);
$_FILEMANAGER_CONF['options']['culture']      = COM_getLangIso639Code();
$_FILEMANAGER_CONF['options']['dateFormat']   = convertDateTimeFormat($_CONF['daytime']);
$_FILEMANAGER_CONF['options']['fileRoot']     = $fileRoot;
$_FILEMANAGER_CONF['options']['relPath']      = str_replace($docRoot, '', $fileRoot);

// Writes into config file
$path = $_CONF['path_html'] . 'filemanager/scripts/filemanager.config.js';
$data = json_encode($_FILEMANAGER_CONF);

if (is_callable('json_last_error') && (json_last_error() !== JSON_ERROR_NONE)) {
	$data = false;
	COM_errorLog('Filemanager: json_encode() failed.  Error code = ' . json_last_error());
}

if ($data !== false) {
	if (file_put_contents($path, $data) === false) {
		COM_errorLog('Filemanager: configuration file "' . $path . '" is not writable');
	}
}

// Display
header('Expires: on, 01 Jan 1970 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>File Manager</title>
<link rel="stylesheet" type="text/css" href="styles/reset.css" />
<link rel="stylesheet" type="text/css" href="scripts/jquery.filetree/jqueryFileTree.css" />
<link rel="stylesheet" type="text/css" href="scripts/jquery.contextmenu/jquery.contextMenu-1.01.css" />
<link rel="stylesheet" type="text/css" href="styles/filemanager.css" />
<!--[if IE 9]>
<link rel="stylesheet" type="text/css" href="styles/ie9.css" />
<![endif]-->
<!--[if lte IE 8]>
<link rel="stylesheet" type="text/css" href="styles/ie8.css" />
<![endif]-->
</head>
<body>
<div>
<form id="uploader" method="post">
	<button id="home" name="home" type="button" value="Home">&nbsp;</button>
	<h1></h1>
	<div id="uploadresponse"></div>
	<input id="mode" name="mode" type="hidden" value="add" /> 
	<input id="currentpath" name="currentpath" type="hidden" />
	<div id="file-input-container">
		<div id="alt-fileinput">
			<input id="filepath" name="filepath" type="text" /><button id="browse" name="browse" type="button" value="Browse"></button>
		</div>
		<input	id="newfile" name="newfile" type="file" />
	</div>
	<button id="upload" name="upload" type="submit" value="Upload"></button>
	<button id="newfolder" name="newfolder" type="button" value="New Folder"></button>
	<button id="grid" class="ON" type="button">&nbsp;</button>
	<button id="list" type="button">&nbsp;</button>
</form>
<div id="splitter">
<div id="filetree"></div>
<div id="fileinfo">
<h1></h1>
</div>
</div>
<form name="search" id="search" method="get">
		<div>
			<input type="text" value="" name="q" id="q" />
			<a id="reset" href="#" class="q-reset"></a>
			<span class="q-inactive"></span>
		</div> 
</form>

<ul id="itemOptions" class="contextMenu">
	<li class="select"><a href="#select"></a></li>
	<li class="download"><a href="#download"></a></li>
	<li class="rename"><a href="#rename"></a></li>
	<li class="move"><a href="#move"></a></li>
	<li class="delete separator"><a href="#delete"></a></li>
</ul>

<script type="text/javascript" src="scripts/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="scripts/jquery.form-3.24.min.js"></script>
<script type="text/javascript" src="scripts/jquery.splitter/jquery.splitter-1.5.1.min.js"></script>
<script type="text/javascript" src="scripts/jquery.filetree/jqueryFileTree.min.js"></script>
<script type="text/javascript" src="scripts/jquery.contextmenu/jquery.contextMenu-1.01.min.js"></script>
<script type="text/javascript" src="scripts/jquery.impromptu-3.2.min.js"></script>
<script type="text/javascript" src="scripts/jquery.tablesorter-2.7.2.min.js"></script>
<script type="text/javascript" src="scripts/filemanager.min.js"></script>
</div>
</body>
</html>