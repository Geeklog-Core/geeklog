<?php
/**
* Upload.class.php - File Upload Class v1.1 - 02 July 2001
* Copyright Darren Beale <mail@bealers.com>
*
* The contents of this file remain the intellectual property of Darren Beale.
* It is free for Personal and non-profit use as long as this 
* entire comment block remains as-is. (Yes all of it)
*
* If you're using it commercially, please mail <mail@bealers.com> for a postal 
* address. You can then get your boss to send me a measly £10 UKP so you can 
* have unlimited use. 
*
* Either way, If you modify or extend it, please Fw: me on a copy with a 
* small note on what you've done and why.
*
* TODO: 
*	Check that source_dir is writeable
*	Allow for auto-rename option on overwrite
*	Handle exceptions and notices better
*	Extend Pear/HTML/Form??
* 	Fix Macintosh Upload issues (it won't work)
*	100% Pear Compliant
*	PHPDoc commenting and bundled docs 
*
* ChangeLog 
* v1.0 - 	Initial Release 						01/07/01
* v1.1 - 	Allowed for Multiple File uploads 		02/07/01
*
* I WILL PROVIDE SUPPORT FOR THIS SCRIPT!
* This script *should* be able to handle the uploading of any file, if it
* doesn't as a first port of call please change the settings 
* UPLOAD_DEBUG_OUTPUT and UPLOAD_ENV_OUTPUT to see what is happening. 
* If you still have problems, mail
* me and I'll see what I can do. Don't expect me to code your app though!
* BTW You Need PHP > 4.0.2
*
* Useage: (bare bones)
*
<?php
require_once("Upload.class.php");

$upload = new Upload();
$upload->printFormStart("index.php");

// put as many of these in as you want, 
// pass a string filename, else a default is used.
$upload->printFormField();
print"<br />";
$upload->printFormField();

$upload->printFormSubmit();
$upload->printFormEnd();

if ($submit) {
	$upload->setAllowedMimeTypes(array("image/bmp","image/gif","image/pjpeg","image/jpeg","image/x-png"));
	$upload->setUploadPath("c:\apache\htdocs");
	
	if ($upload->doUpload()) {
		print "Files Uploaded!";
	} else {
		$errors = $upload->getUploadErrors();
		print "<strong>::Errors occured::</strong><br />\n";
		while(list($filename,$values) = each($errors)) {
			"File: " . print $filename . "<br />";
			$count = count($values);
			for($i=0; $i<$count; $i++) {
				print "==>" . $values[$i] . "<br />";
			}
		}
	}
}
?>
*
* This class is complete re-write of my original code that I used
* as a basis for one of my PHPBuilder.com articles.
* http://www.phpbuilder.com/columns/bealers20000904.php3
*
* @author   Darren Beale <mail@bealers.com>
*/

// CONSTANTS ///////////////////////////////////////////////////////////////////

/*
*	Funny one this, during testing I couldn't assertain the dimensions of certain images.
*	Until I can figure out why, you can set this flag to allow the images
*	that don't return anything.
*/
if (!defined('UPLOAD_ALLOW_DUBIOUS_IMAGES')) {
	define('UPLOAD_ALLOW_DUBIOUS_IMAGES', true);
}

/*
*	Defaults only, they can be overridden using methods.
*/
if (!defined('UPLOAD_MAX_FILE_SIZE')) {
   define('UPLOAD_MAX_FILE_SIZE', 1048576); // 1MB = 1048576
}
if (!defined('UPLOAD_IMAGE_MAX_WIDTH')) {
    define('UPLOAD_IMAGE_MAX_WIDTH', 300);
}
if (!defined('UPLOAD_IMAGE_MAX_HEIGHT')) {
    define('UPLOAD_IMAGE_MAX_HEIGHT', 300);
}
if (!defined('UPLOAD_FIELD_NAME')) {
    define('UPLOAD_FIELD_NAME', "uploadFile");
}


/*
* un-essential, only change if in development and you are having problems
*/
if (!defined('UPLOAD_DEBUG_OUTPUT')) {
    define('UPLOAD_DEBUG_OUTPUT', false);
}
if (!defined('UPLOAD_ENV_OUTPUT')) {
    define('UPLOAD_ENV_OUTPUT', false);
}
if (!defined('UPLOAD_LINE_BREAK')) {
    define('UPLOAD_LINE_BREAK',"<br />"); // markup specific
}

class Upload
{

	// {{{ properties
	
	// array
	var $uploadErrors;
	var $registeredMimeTypes;
	var $allowedMimeTypes;
	
	// int
	var $maxImageWidth;
	var $maxImageHeight;
	var $maxFileSize;
	
	/*
	*	used to track the number of fields created and name them accordingly 
	*/
	var $fieldCounter;
	
	// string
	var $uploadPath;
	var $uploadFieldName;
	var $fieldName;
	var $errorType;
	
	// bool
	var $imageSizeOk;
	var $uploadValidated;
	var $uploadFail;
	
	//}}}
	//{{{ constructor
	
	function Upload()
	{
		$this->uploadErrors 		= array();
		$this->registeredMimeTypes 	= array();
		$this->allowedMimeTypes 	= array();
		
		$this->maxImageWidth		= 0;
		$this->maxImageHeight		= 0;
		$this->maxFileSize			= 0;
		$this->fieldCounter			= 0;
		
		$this->uploadFieldName 		= "";
		$this->uploadPath			= "";
		
		$this->imageSizeOk			= false;
		$this->uploadValidated		= false;
		$this->uploadFail			= false;
		
		/* 
		* set defaults
		*/
		if(!$this->registeredMimeTypes) {
			$this->setRegisteredMimeTypes();
		}
		
		if(!$this->maxImageWidth || !$this->maxImageHeight) {
			$this->setMaxImageSize();
		}
		
		if(!$this->maxFileSize) {
			$this->setMaxFileSize();
		}
		
		/*
		*	check to see what our environment is like, nothing happens unless
		*	UPLOAD_ENV_OUTPUT == true
		*/
		$this->checkLocalEnv();
	}
	
	//}}}
	
	/* 
	* public methods ///////////////////////////////////////////////////////////
	*/
	
	//{{{ setImageSize()
	
	function setMaxImageSize($maxImageWidth = UPLOAD_IMAGE_MAX_WIDTH, $maxImageHeight = UPLOAD_IMAGE_MAX_HEIGHT)
	{
		$this->maxImageWidth 	= $maxImageWidth;
		$this->maxImageHeight 	= $maxImageHeight;
	}
	
	//}}}
	//{{{ setUploadPath()
	
	function setUploadPath($uploadPath)
	{
		$this->uploadPath 	= $uploadPath;
	}
	
	//}}}
	//{{{ setDestinationFileName()
	
	function setDestinationFileName($destinationFileName = "uploadedFile.file")
	{
		$this->uploadFieldName = $destinationFileName; //+++
	}
	
	//}}}
	//{{{ setRegisteredMimeTypes()
	
	function setRegisteredMimeTypes($registeredMimeTypes = array())
	{
		if (sizeof($registeredMimeTypes) == 0) {
			$this->registeredMimeTypes = 
				array(
					"application/x-gzip-compressed" 	=> ".tar.gz, .tgz",
					"application/x-zip-compressed" 		=> ".zip",
					"application/x-tar"					=> ".tar",
					"text/plain"						=> ".php, .txt, .inc (etc)",
					"text/html"							=> ".html, .htm (etc)",
					"image/bmp" 						=> ".bmp, .ico",
					"image/gif" 						=> ".gif",
					"image/pjpeg"						=> ".jpg, .jpeg",
					"image/jpeg"						=> ".jpg, .jpeg",
					"image/x-png"						=> ".png",
					"audio/mpeg"						=> ".mp3 etc",
					"audio/wav"							=> ".wav",
					"application/pdf"					=> ".pdf",
					"application/x-shockwave-flash" 	=> ".swf",
					"application/msword"				=> ".doc",
					"application/vnd.ms-excel"			=> ".xls",
					"application/octet-stream"			=> ".exe, .fla, .psd (etc)"
				);
		} else {
			$this->registeredMimeTypes = $registeredMimeTypes;
		}
	}
	
	//}}}
	//{{{ setAllowedMimeTypes()
	
	function setAllowedMimeTypes($allowedMimeTypes = array())
	{
		$this->allowedMimeTypes = $allowedMimeTypes;
	}
	
	//}}}
	//{{{ setMaxFileSize()
	
	function setMaxFileSize($maxFileSize = UPLOAD_MAX_FILE_SIZE)
	{
		$this->maxFileSize = $maxFileSize;
	}
	
	//}}}
	//{{{ getUploadErrors()
	
	function getUploadErrors()
	{
		return $this->uploadErrors; // array
	}
	
	//}}}
	//{{{ printFormStart() 	TODO Extend HTML/Form ??
	
	function printFormStart($formAction = "./", $formMethod = "POST", $formName = "uploadForm", $formTarget = "_self", $formInlineJavaScript="")
	{
		print "<FORM ACTION='" 	. $formAction . 
				"' METHOD='" 	. $formMethod . 
				"' TARGET='" 	. $formTarget . 
				"' NAME='" 		. $formName . 
				"' ENCTYPE='multipart/form-data'" . $formInlineJavaScript . ">\n";
	}
	
	//}}}
	//{{{ printFormField()
	
	function printFormField($fieldName = "") //+++
	{
		if(!$fieldName) {
			$fieldName = UPLOAD_FIELD_NAME . "_" . $this->fieldCounter;
		}
		print "<INPUT TYPE='FILE' NAME='" . $fieldName . "'>\n";
		print "<INPUT TYPE='HIDDEN' NAME='uploadFileName[" . 
				$this->fieldCounter . "]' VALUE='" . $fieldName . "'>\n";
		$this->fieldCounter++;
	}
	
	//}}}
	//{{{ printFormSubmit()
	
	function printFormSubmit($name="submit", $value="Upload", $formInlineJavaScript="")
	{
		print "<INPUT TYPE='HIDDEN' NAME='fieldCounter' VALUE='" . 
				$this->fieldCounter . "'>\n";
		print "<INPUT TYPE='SUBMIT' 
				NAME='" . $name . "' VALUE='" . $value . "'" . $formInlineJavaScript . ">\n";
	}
		
	//}}}
	//{{{ printFormEnd()
	
	function printFormEnd()
	{
		print "</FORM>\n";
	}

	//}}}
	
	/* 
	* private methods //////////////////////////////////////////////////////////
	*/
	
	//{{{ checkLocalEnv()
	
	function checkLocalEnv()
	{
		/*
		*	this is a developer helper method and a pre-emptive strike
		*	towards any support emails ;)
		*/
		if (UPLOAD_ENV_OUTPUT) {
			print UPLOAD_LINE_BREAK . "::PHP Environment - php.ini settings::" . UPLOAD_LINE_BREAK; 
			
			print UPLOAD_LINE_BREAK . "(php.ini variable: file_uploads)" . UPLOAD_LINE_BREAK;
			print "HTTP File Uploads are ";
			if (ini_get("file_uploads")) {
				print "[ On ]";
			} else {
				print "[ Off ] - This is a *major* issue. This script WILL NOT WORK!";
				print UPLOAD_LINE_BREAK . "Please check php.ini if you have access to it, if not you cannot use this Script, sorry.";
			}
			print UPLOAD_LINE_BREAK . UPLOAD_LINE_BREAK . "(php.ini variable: upload_tmp_dir)";
			print UPLOAD_LINE_BREAK . "Temp Upload Directory is set to [ " . ini_get("upload_tmp_dir") . " ]";
			print UPLOAD_LINE_BREAK . "Note, this is a fully qualified path on the *server*";
			
			print UPLOAD_LINE_BREAK . UPLOAD_LINE_BREAK . "(php.ini variable: upload_max_filesize)";
			print UPLOAD_LINE_BREAK . "Maximum allowed file size is set to [ " . ini_get("upload_max_filesize") . " ]";
			
			print UPLOAD_LINE_BREAK . UPLOAD_LINE_BREAK . "(php.ini variable: safe_mode)" . UPLOAD_LINE_BREAK;
			print "Safe mode is ";
			if (!ini_get("safe_mode")) {
				print "[ Off ]";
			} else {
				print "[ On ] - This script will almost certainly not work!";
				print UPLOAD_LINE_BREAK . "Please check php.ini if you have access to it, if not you cannot use this Script, sorry.";
			}
		}
	}
	
	//}}}	
	//{{{ setError()
	
	function setError($errorType)
	{
		$this->uploadErrors[$this->HTTP_POST_FILES[$this->uploadFieldName]['name']][] = $errorType; //+++
	}

	//}}}
	//{{{ getAllowedMimeTypes()
	
	function getAllowedMimeTypes()
	{
		return $this->allowedMimeTypes;
	}
	
	//}}}
	//{{{ getUploadImageSize()
	
	function getUploadImageSize()
	{
		$dimensions = GetImageSize($this->uploadFile); //+++
		
		/*
		*	I've been having some issues when uploading images with regards 
		*	to the array passed back (i.e. No values)
		*/
		if (UPLOAD_DEBUG_OUTPUT) {
			print "WIDTH: " . $dimensions[0] . UPLOAD_LINE_BREAK . "HEIGHT: " . 
					$dimensions[1] . UPLOAD_LINE_BREAK;
		}
		
		if (!UPLOAD_ALLOW_DUBIOUS_IMAGES) {
			$this->setError("cannotGetImageSize");
		}
		return array($dimensions[0],$dimensions[1]);
	}
	
	//}}}
	//{{{ checkMimeType()
	
	function checkMimeType()
	{
		if (!in_array($this->HTTP_POST_FILES[$this->uploadFieldName]['type'],$this->getAllowedMimeTypes())) {
			$this->setError("mimeException");
			return false;
		} else {
			return true;
		}
	}
	
	//}}}
	//{{{ checkImageSize()
	
	function checkImageSize()
	{
		$this->imageSize = $this->getUploadImageSize($this->uploadFile); //+++
		
		$imageSizeOK = true;
		
		if ($this->imageSize[0] > $this->maxImageWidth) {
			$imageSizeOK = false;
			$this->setError("imageWidthException");
		}

		if ($this->imageSize[1] > $this->maxImageHeight) {
			$imageSizeOK= false;
			$this->setError("imageHeightException");
		}
		return $imageSizeOK;
	}
	
	//}}}
	//{{{ copyFile()

	
	function copyFile() // TODO check for is_writeable()
	{
		return move_uploaded_file($this->uploadFile, $this->uploadPath . "/" . $this->HTTP_POST_FILES[$this->uploadFieldName]['name']); //+++
		
	}
	
	//}}}
	//{{{ checkMaxFileSize()
	
	function checkMaxFileSize()
	{
		if ($this->HTTP_POST_FILES[$this->uploadFieldName]['size'] > $this->maxFileSize) { 		//+++ ISSUE
			return false;
		} else {
			return true;
		}
	}
	
	//}}}
	//{{{ setDefaults()
	
	function setDefaults()
	{
		if(!$this->registeredMimeTypes) {
			$this->setRegisteredMimeTypes();
		}
		
		if(!$this->maxImageWidth || !$this->maxImageHeight) {
			$this->setMaxImageSize();
		}
		
		if(!$this->maxFileSize) {
			$this->setMaxFileSize();
		}
	}
	
	//}}}
	//{{{ processUpload()
	
	function processUpload() { //+++
		
		/*
		*	Some MIME types seem to be rather randomly set, I'm assuming that this
		*	is an OS issue. For example M$ Word documents have been, in my experience,
		*	application/octet-stream, text/richtext or application/msword
		*	<shrug> if UPLOAD_DEBUG_OUTPUT == true, echo the MIME type.
		*	This is arguably useful for a development environment.
		*	Disabled by default.
		*/
		if (UPLOAD_DEBUG_OUTPUT) {
			print UPLOAD_LINE_BREAK . "::DEBUG::" . UPLOAD_LINE_BREAK  .
				"Field Name: " . $this->uploadFieldName .
				UPLOAD_LINE_BREAK .
				"Mime Type: " . $this->HTTP_POST_FILES[$this->uploadFieldName]['type'] . 
				UPLOAD_LINE_BREAK .
				"File Name: " . $this->HTTP_POST_FILES[$this->uploadFieldName]['name'] . 
				UPLOAD_LINE_BREAK .
				"File Size: " . $this->HTTP_POST_FILES[$this->uploadFieldName]['size'] . 
				UPLOAD_LINE_BREAK .
				"Temp Name: " . $this->HTTP_POST_FILES[$this->uploadFieldName]['tmp_name'] . 
				UPLOAD_LINE_BREAK;
		}
		
		$this->uploadFile = $this->HTTP_POST_FILES[$this->uploadFieldName]['tmp_name'];
		$this->setDefaults();

		if (!$this->uploadPath) {
			$this->setError("noUploadPathException");
			$this->uploadFail = true;
		}

		if (!$this->allowedMimeTypes) {
			$this->setError("noAllowedTypesException");
			$this->uploadFail = true;
		}

		if ($this->uploadFile == "none") {
			$this->setError("noFileException");
			$this->uploadFail = true;
		}
		
		if (!$this->checkMaxFileSize()) {
			$this->setError("fileTooBigException");
			$this->uploadFail = true;
		} elseif(in_array("cannotGetImageSize",$this->getUploadErrors())) {
			// no dimensions special case, see definitions @ top
			$this->uploadFail = true;
		}
		
		if (!$this->uploadFail) {
			if (ereg("image",$this->HTTP_POST_FILES[$this->uploadFieldName]['type'])) {
				$this->imageSizeOk = $this->checkImageSize();
			} else {
				$this->imageSizeOk = true;
			}
		}
		
		if($this->checkMimeType() && $this->imageSizeOk && !$this->uploadFail) {
			if (!$this->copyFile()) {
				$this->setError("fileCopyException");
			}
		}
		
		if (sizeof($this->uploadErrors) == 0)
		{
			$this->uploadValidated = true;
		}
		return $this->uploadValidated;
	}
	
	function doUpload() {
	
		$this->HTTP_POST_FILES 	= $GLOBALS['HTTP_POST_FILES']; 	//array
		$this->fieldCounter 	= $GLOBALS['fieldCounter'];		//int

		for ($i=0; $i<$this->fieldCounter; $i++) {
		
			$this->uploadFieldName	= $GLOBALS['uploadFileName'][$i];
			$currentUpload = $this->processUpload();

			if (!$currentUpload) {
				$errorsOccured = true;
			}
		}
		
		if ($errorsOccured) {
			return false;
		} else {
			return true;
		}
	}
	
	///}}}
}
?>
