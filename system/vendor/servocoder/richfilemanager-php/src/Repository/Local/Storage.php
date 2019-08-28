<?php

namespace RFM\Repository\Local;

use RFM\Facade\Log;
use RFM\Repository\BaseStorage;
use RFM\Repository\StorageInterface;
use function RFM\app;

/**
 *	Local storage class.
 *
 *	@license	MIT License
 *	@author		Pavel Solomienko <https://github.com/servocoder/>
 *	@copyright	Authors
 */

class Storage extends BaseStorage implements StorageInterface
{
    /**
     * Full path to server document root folder.
     * Being defined automatically based on configuration options.
     * Example: "/var/www/html"
     *
     * @var string
     */
    protected $documentRoot;

    /**
     * Full path to directory for storing user files.
     * Being set in the configuration file and can be changed via "setRoot()" method.
     * Example: "/var/www/html/filemanager/userfiles"
     *
     * @var string
     */
	protected $storageRoot;

    /**
     * User files storage folder path, relative to the server document root.
     * Being defined automatically by subtracting $documentRoot from $storageRoot.
     *
     * @var string
     */
	protected $dynamicRoot;

    /**
     * Default folder name. Affect only in case $storageRoot is not defined explicitly.
     * In such a case it is appended to $documentRoot and thus forms default $storageRoot.
     *
     * @var string
     */
    protected $defaultDir = 'userfiles';

    /**
     * Storage constructor.
     *
     * @param array $config
     */
	public function __construct($config = [])
    {
		$this->setName(BaseStorage::STORAGE_LOCAL_NAME);
		$this->setConfig($config);
        $this->setDefaults();
	}

    /**
     * Set paths and other initial data.
     */
    protected function setDefaults()
    {
        $fileRoot = $this->config('options.fileRoot');
        if ($fileRoot !== false) {
            // takes $_SERVER['DOCUMENT_ROOT'] as files root; "fileRoot" is a suffix
            if($this->config('options.serverRoot') === true) {
                $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
                $this->storageRoot = $_SERVER['DOCUMENT_ROOT'] . '/' . $fileRoot;
            }
            // takes "fileRoot" as files root; "fileRoot" is a full server path
            else {
                $this->documentRoot = $fileRoot;
                $this->storageRoot = $fileRoot;
            }
        } else {
            // default storage folder in case of default RFM structure
            $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
            $this->storageRoot = dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME']))) . '/' . $this->defaultDir;
        }

        // normalize slashes in paths
        $this->documentRoot = $this->cleanPath($this->documentRoot);
        $this->storageRoot = $this->cleanPath($this->storageRoot . '/');
        $this->dynamicRoot = $this->subtractPath($this->storageRoot, $this->documentRoot);

        Log::info('$this->storageRoot: "' . $this->storageRoot . '"');
        Log::info('$this->documentRoot: "' . $this->documentRoot . '"');
        Log::info('$this->dynamicRoot: "' . $this->dynamicRoot . '"');
    }

    /**
     * Set user storage folder.
     *
     * @param string $path
     * @param bool $makeDir
     * @param bool $relativeToDocumentRoot
     */
	public function setRoot($path, $makeDir = false, $relativeToDocumentRoot = null)
    {
        // prevent to override config file settings
        if (is_bool($relativeToDocumentRoot)) {
            $this->storageRoot = $path . '/';

            if($relativeToDocumentRoot === true) {
                $this->storageRoot = $this->documentRoot . '/' . $this->storageRoot;
            }

            // normalize slashes in paths
            $this->storageRoot = $this->cleanPath($this->storageRoot);
            $this->dynamicRoot = $this->subtractPath($this->storageRoot, $this->documentRoot);
        }

		Log::info('Overwritten with setRoot() method:');
		Log::info('$this->storageRoot: "' . $this->storageRoot . '"');
		Log::info('$this->dynamicRoot: "' . $this->dynamicRoot . '"');

		if($makeDir && !file_exists($this->storageRoot)) {
            Log::info('creating "' . $this->storageRoot . '" root folder');
			mkdir($this->storageRoot, $this->config('mkdir_mode'), true);
		}
	}

    /**
     * @inheritdoc
     */
    public function getRoot()
    {
        return $this->storageRoot;
    }

    /**
     * @inheritdoc
     */
    public function getDynamicRoot()
    {
        return $this->dynamicRoot;
    }

    /**
     * Return path without storage root path.
     *
     * @param string $path - absolute path
     * @return mixed
     */
    public function getRelativePath($path)
    {
        return $this->subtractPath($path, $this->storageRoot);
    }

    /**
     * Subtracts subpath from the fullpath.
     *
     * @param string $fullPath
     * @param string $subPath
     * @return string
     */
    public function subtractPath($fullPath, $subPath)
    {
        $position = strrpos($fullPath, $subPath);
        if($position === 0) {
            $path = substr($fullPath, strlen($subPath));
            return $path ? $this->cleanPath('/' . $path) : '';
        }
        return '';
    }

    /**
     * Clean path string to remove multiple slashes, etc.
     *
     * @param string $string
     * @return string
     */
    public function cleanPath($string)
    {
        // replace backslashes (windows separators)
        $string = str_replace("\\", "/", $string);
        // remove multiple slashes
        $string = preg_replace('#/+#', '/', $string);

        return $string;
    }

    /**
     * Verify if system read permission is granted.
     *
     * @param string $path - absolute path
     * @return bool
     */
    public function hasSystemReadPermission($path)
    {
        return is_readable($path);
    }

    /**
     * Verify if system write permission is granted.
     *
     * @param string $path - absolute path
     * @return bool
     */
    public function hasSystemWritePermission($path)
    {
        // In order to create an entry in a POSIX dir, it must have
        // both `-w-` write and `--x` execute permissions.
        //
        // NOTE: Windows PHP doesn't support standard POSIX permissions.
        if (is_dir($path) && !(app()->php_os_is_windows())) {
            return (is_writable($path) && is_executable($path));
        }

        return is_writable($path);
    }

	/**
     * Initiate uploader instance and handle uploads.
     *
	 * @param ItemModel $model
	 * @return UploadHandler
	 */
	public function initUploader($model)
	{
		return new UploadHandler([
			'model' => $model,
			'storage' => $this,
		]);
	}

    /**
     * Calculate total size of all files.
     *
     * @return mixed
     */
    public function getRootTotalSize()
    {
        $result = $this->getDirSummary('/');

        return $result['size'];
    }

	/**
	 * Create a zip file from source to destination.
     *
	 * @param  	string $source Source path for zip
	 * @param  	string $destination Destination path for zip
	 * @param  	boolean $includeFolder If true includes the source folder also
	 * @return 	boolean
	 * @link	http://stackoverflow.com/questions/17584869/zip-main-folder-with-sub-folder-inside
	 */
	public function zipFile($source, $destination, $includeFolder = false)
	{
		if (!extension_loaded('zip') || !file_exists($source)) {
			return false;
		}

		$zip = new \ZipArchive();
		if (!$zip->open($destination, \ZipArchive::CREATE)) {
			return false;
		}

		$source = str_replace('\\', '/', realpath($source));
		$folder = $includeFolder ? basename($source) . '/' : '';

		if (is_dir($source) === true) {
			// add file to prevent empty archive error on download
			$zip->addFromString('fm.txt', "This archive has been generated by Rich Filemanager : https://github.com/servocoder/RichFilemanager/");

			$files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
				\RecursiveIteratorIterator::SELF_FIRST
			);

			foreach ($files as $file) {
				$file = str_replace('\\', '/', realpath($file));

				if (is_dir($file) === true) {
					$path = str_replace($source . '/', '', $file . '/');
					$zip->addEmptyDir($folder . $path);
				} else if (is_file($file) === true) {
					$path = str_replace($source . '/', '', $file);
					$zip->addFile($file, $folder . $path);
				}
			}
		} else if (is_file($source) === true) {
			$zip->addFile($source, $folder . basename($source));
		}

		return $zip->close();
	}

    /**
     * Create new folder.
     *
     * @param ItemModel $target
     * @param ItemModel $prototype
     * @param $options array
     * @return bool
     */
    public function createFolder($target, $prototype = null, $options = [])
    {
        $defaults = [
            'recursive' => true,
            'mode' => $this->config('mkdir_mode'),
        ];

        $options = array_merge($defaults, $options);

        return mkdir($target->getAbsolutePath(), $options['mode'], $options['recursive']);
    }

    /**
     * Copies a single file, symlink or a whole directory.
     * In case of directory it will be copied recursively.
     *
     * @param ItemModel $source
     * @param ItemModel $target
     * @return bool
     */
    public function copyRecursive($source, $target)
    {
        $sourcePath = $source->getAbsolutePath();
        $targetPath = $target->getAbsolutePath();

        // handle symlinks
        if (is_link($sourcePath)) {
            return symlink(readlink($sourcePath), $targetPath);
        }

        // copy a single file
        if (is_file($sourcePath)) {
            return copy($sourcePath, $targetPath);
        }

        // make target directory
        if (!is_dir($targetPath)) {
            $this->createFolder($target);
        }

        $handle = opendir($sourcePath);
        // loop through the directory
        while (($file = readdir($handle)) !== false) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $itemSource = new ItemModel($source->getRelativePath() . $file);
            $itemTarget = new ItemModel($target->getRelativePath() . $file);
            $this->copyRecursive($itemSource, $itemTarget);
        }
        closedir($handle);
        return true;
    }

    /**
     * Rename/move a single file or a whole directory.
     * In case of directory it will be copied recursively.
     *
     * @param ItemModel $source
     * @param ItemModel $target
     * @return bool
     */
    public function renameRecursive($source, $target)
    {
        return rename($source->getAbsolutePath(), $target->getAbsolutePath());
    }

    /**
     * Delete folder recursive.
     *
     * @param ItemModel $target
     * @return bool
     */
    public function unlinkRecursive($target)
    {
        $targetPath = $target->getAbsolutePath();

        // delete a single file
        if (!is_dir($targetPath)) {
            unlink($targetPath);
            return true;
        }

        // filed to read folder
		if(!$handle = @opendir($targetPath)) {
			return false;
		}

		while (false !== ($obj = readdir($handle))) {
			if($obj == '.' || $obj == '..') {
				continue;
			}

            $itemTarget = new ItemModel($target->getRelativePath() . '/' . $obj);
            $this->unlinkRecursive($itemTarget);
		}

		closedir($handle);
        return rmdir($targetPath);
	}

    /**
     * Read item and write it to the output buffer.
     * Seekable stream: http://stackoverflow.com/a/23046071/1789808
     *
     * @param string $path - absolute path
     */
    public function readFile($path)
    {
        $handle = fopen($path, 'rb');
        $fileSize = $this->getFileSize($path);
        $bytesRead = $fileSize;

        // handle HTTP RANGE for stream files (audio/video)
        if(isset($_SERVER['HTTP_RANGE'])) {
            if(!preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches)) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header('Content-Range: bytes */' . $fileSize);
                exit;
            }

            $offset = intval($matches[1]);

            if(isset($matches[2])) {
                $end = intval($matches[2]);
                if($offset > $end) {
                    header('HTTP/1.1 416 Requested Range Not Satisfiable');
                    header('Content-Range: bytes */' . $fileSize);
                    exit;
                }
                $bytesRead = $end - $offset;
            } else {
                $bytesRead = $fileSize - $offset;
            }

            $bytesStart = $offset;
            $bytesEnd = $offset + $bytesRead - 1;
            fseek($handle, $offset);

            header('HTTP/1.1 206 Partial Content');
            // A full-length file will indeed be "bytes 0-x/x+1", think of 0-indexed array counts
            header('Content-Range: bytes ' . $bytesStart . '-' . $bytesEnd . '/' . $fileSize);
            // While playing media by direct link (not via FM) FireFox and IE doesn't allow seeking (rewind) it in player
            // This header can fix this behavior if to put it out of this condition, but it breaks PDF preview
            header('Accept-Ranges: bytes');
        }

        header('Content-Type: ' . $this->getMimeType($path));
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . $bytesRead);

        $position = 0;
        while($position < $bytesRead) {
            $chunk = min($bytesRead - $position, 1024 * 8);

            echo fread($handle, $chunk);
            flush();

            if (ob_get_length() > 0) {
                ob_flush();
            }

            $position += $chunk;
        }
    }

    /**
     * Retrieve mime type of file.
     *
     * @param string $path - absolute or relative path
     * @return string
     */
    public function getMimeType($path)
    {
        return mime_content_type($path);
    }

    /**
     * Defines real size of file.
     * Based on https://github.com/jkuchar/BigFileTools project by Jan Kuchar
     *
     * @param string $path - absolute path
     * @return int|string
     * @throws \Exception
     */
    public function getFileSize($path)
    {
        // This should work for large files on 64bit platforms and for small files everywhere
        $fp = fopen($path, "rb");
        if (!$fp) {
            throw new \Exception("Cannot open specified file for reading.");
        }
        $flockResult = flock($fp, LOCK_SH);
        $seekResult = fseek($fp, 0, SEEK_END);
        $position = ftell($fp);
        flock($fp, LOCK_UN);
        fclose($fp);

        if(!($flockResult === false || $seekResult !== 0 || $position === false)) {
            return sprintf("%u", $position);
        }

        // Try to define file size via CURL if installed
        if (function_exists("curl_init")) {
            $ch = curl_init("file://" . rawurlencode($path));
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, true);
            $data = curl_exec($ch);
            curl_close($ch);
            if ($data !== false && preg_match('/Content-Length: (\d+)/', $data, $matches)) {
                return $matches[1];
            }
        }

        // Use native function otherwise
        return filesize($path);
    }

	/**
	 * Return summary info for specified folder.
     *
	 * @param string $dir - relative path
	 * @param array $result
	 * @return array
	 */
	public function getDirSummary($dir, &$result = ['size' => 0, 'files' => 0, 'folders' => 0])
	{
	    $modelDir = new ItemModel($dir);

		// suppress permission denied and other errors
		$files = @scandir($modelDir->getAbsolutePath());
		if($files === false) {
			return $result;
		}

		foreach($files as $file) {
			if($file == "." || $file == "..") {
				continue;
			}
            if (is_dir($modelDir->getAbsolutePath() . $file)) {
                $file .= '/';
            }

            $model = new ItemModel($modelDir->getRelativePath() . $file);

            if ($model->hasReadPermission() && $model->isUnrestricted()) {
                if ($model->isDirectory()) {
                    $result['folders']++;
                    $this->getDirSummary($model->getRelativePath(), $result);
                } else {
                    $result['files']++;
                    $result['size'] += $this->getFileSize($model->getAbsolutePath());
                }
            }
		}

		return $result;
	}
}
