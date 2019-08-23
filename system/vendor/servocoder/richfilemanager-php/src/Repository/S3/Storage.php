<?php

namespace RFM\Repository\S3;

use RFM\Facade\Log;
use RFM\Repository\BaseStorage;
use RFM\Repository\StorageInterface;
use function RFM\mime_type_by_extension;

/**
 *	AWS S3 storage class.
 *
 *	@license	MIT License
 *	@author		Pavel Solomienko <https://github.com/servocoder/>
 *	@copyright	Authors
 */

class Storage extends BaseStorage implements StorageInterface
{
    /**
     * Full path to S3 storage bucket including protocol.
     * Being built automatically at the base of S3 credentials.
     * Example: "s3://bucket_name/"
     *
     * @var mixed
     */
	protected $storageRoot;

    /**
     * Directory inside bucket for storing files.
     * Can be changed via "setRoot()" method.
     * Example: "user1" or "users/john"
     *
     * @var string
     */
    protected $dynamicRoot;

    /**
     * S3 client wrapper class.
     *
     * @var StorageHelper
     */
    public $s3 = null;

    /**
     * ACL policy accorging to the configuration file.
     *
     * @var array|null
     */
    public $aclPolicy = [];

    /**
     * Storage constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->setName(BaseStorage::STORAGE_S3_NAME);
        $this->setConfig($config);
        $this->setS3Client();

        $this->setDynamicRoot('userfiles');
        $this->storageRoot = $this->getS3WrapperPath($this->getDynamicRoot());
    }

    /**
     * Set S3 client wrapper.
     */
    public function setS3Client()
    {
        if (!$this->config('credentials')) {
            throw new \Exception("S3 storage credentials isn't set");
        }

        $this->aclPolicy = $this->config('aclPolicy', []);

        $storage = new StorageHelper;
        $storage->region = $this->config('credentials.region');
        $storage->bucket = $this->config('credentials.bucket');
        $storage->endpoint = $this->config('credentials.endpoint');
        $storage->credentials = $this->config('credentials.credentials');
        $storage->defaultAcl = $this->config('credentials.defaultAcl');
        $storage->cdnHostname = $this->config('credentials.cdnHostname');
        $storage->encryption = $this->config('encryption', null);
        $storage->debug = $this->config('credentials.debug', false);
        $storage->options = $this->config('credentials.options', []);
        $storage->init();

        $this->s3 = $storage;
    }

    /**
     * @inheritdoc
     */
    public function setRoot($path, $makeDir = false)
    {
        $this->setDynamicRoot($path);
        $this->storageRoot = $this->getS3WrapperPath($this->getDynamicRoot());

        if($makeDir === true && !is_dir($this->storageRoot)) {
            Log::info('creating "' . $this->storageRoot . '" root folder');
            $this->s3->put($this->getDynamicRoot());
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
     * @param string $path
     */
    public function setDynamicRoot($path)
    {
        $this->dynamicRoot = $this->cleanPath('/' . $path . '/');
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
     * Returns full path to S3 object to use via PHP S3 wrapper stream
     * @param string $path
     * @return mixed
     */
    public function getS3WrapperPath($path)
    {
        $path = $this->cleanPath($this->s3->bucket . '/' . $path);

        return 's3://' . $path;
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
        return is_writable($path);
    }

    /**
     * Get files list recursively.
     *
     * @param string $dir - absolute path
     * @return array
     */
    public function getFilesList($dir)
    {
        $list = [];
        $iterator = \Aws\recursive_dir_iterator($dir);
        foreach ($iterator as $filename) {
            $list[] = $filename;
        }
        return $list;
    }

    /**
     * Retrieve metadata of an S3 object.
     *
     * @param string $key
     * @return array
     */
    public function getMetaData($key)
    {
        $head = $this->s3->head($key, true);

        return $head ? $head['@metadata']['headers'] : (array) $head;
    }

    /**
     * Check whether S3 object exists.
     * Could be used to check real state of cached object.
     *
     * @param string $key
     * @return bool
     */
    public function isObjectExists($key)
    {
        return $this->s3->exist($key);
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
     * Create new folder respecting parent folder ACL policies.
     *
     * @param ItemModel $target
     * @param ItemModel $prototype
     * @param $options array
     * @return bool
     */
    public function createFolder($target, $prototype = null, $options = [])
    {
        $options = [];
        if ($this->aclPolicy === StorageHelper::ACL_POLICY_INHERIT) {
            if (is_null($prototype)) {
                $prototype = $target->closest();
            }
            $options = array_merge($options, $prototype->getAclParams());
        }

        return (bool) $this->s3->put($target->getDynamicPath(), '', $options);
    }

    /**
     * Copy item from source to target destination.
     *
     * @param ItemModel $source
     * @param ItemModel $target
     * @param bool $remove
     * @return bool
     */
    public function copyItem($source, $target, $remove = false)
    {
        $context = stream_context_create([
            's3' => array_merge($source->getAclParams(), [
                'ServerSideEncryption' => $this->s3->encryption,
            ]),
        ]);

        $copied = copy($source->getAbsolutePath(), $target->getAbsolutePath(), $context);

        if ($copied && $remove === true) {
            $this->s3->delete($source->getDynamicPath());
        }

        return $copied;
    }

    /**
     * Copy a single file or a whole directory.
     * In case of directory it will be copied recursively.
     *
     * @param ItemModel $source
     * @param ItemModel $target
     * @return bool
     */
    public function copyRecursive($source, $target)
    {
        $flag = true;
        if ($source->isDirectory()) {
            $files = $this->getFilesList(rtrim($source->getAbsolutePath(), '/'));
            $files = array_reverse($files);
            $flag = $flag && $this->createFolder($target, $source);

            foreach ($files as $path) {
                $pattern = preg_quote($source->getAbsolutePath());
                $relativePath = preg_replace("#^{$pattern}#", '', $path);
                $itemSource = new ItemModel($source->getRelativePath() . $relativePath);
                $itemTarget = new ItemModel($target->getRelativePath() . $relativePath);

                if ($itemSource->isDirectory()) {
                    $flag = $flag && $this->createFolder($itemTarget, $itemSource);
                } else {
                    $flag = $flag && $this->copyItem($itemSource, $itemTarget);
                }
            }
        } else {
            $flag = $flag && $this->copyItem($source, $target);
        }

        return $flag;
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
        $flag = true;
        if ($source->isDirectory()) {
            $files = $this->getFilesList(rtrim($source->getAbsolutePath(), '/'));
            $files = array_reverse($files);
            $flag = $flag && $this->createFolder($target, $source);

            foreach ($files as $path) {
                $pattern = preg_quote($source->getAbsolutePath());
                $relativePath = preg_replace("#^{$pattern}#", '', $path);
                $itemSource = new ItemModel($source->getRelativePath() . $relativePath);
                $itemTarget = new ItemModel($target->getRelativePath() . $relativePath);

                if ($itemSource->isDirectory()) {
                    $flag = $flag && $this->createFolder($itemTarget, $itemSource);
                    rmdir($itemSource->getAbsolutePath());
                } else {
                    $flag = $flag && $this->copyItem($itemSource, $itemTarget, true);
                }
            }
            rmdir($source->getAbsolutePath());
        } else {
            $flag = $flag && $this->copyItem($source, $target, true);
        }

        return $flag;
    }

    /**
     * Delete folder recursive.
     *
     * @param ItemModel $target
     * @return bool
     */
    public function unlinkRecursive($target)
    {
        $key = $target->getDynamicPath();
        if ($target->isDirectory()) {
            $this->s3->batchDelete($key);
        } else {
            $this->s3->delete($key);
        }

        return !$this->isObjectExists($key);
    }

    /**
     * Read item and write it to the output buffer.
     *
     * @param string $path - absolute path
     */
    public function readFile($path)
    {
        $fileSize = $this->getFileSize($path);
        $bytesRead = $fileSize;
        $context = null;

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
            $context = stream_context_create([
                's3' => [
                    'seekable' => true,
                    'Range' => "bytes={$bytesStart}-{$bytesEnd}",
                ]
            ]);

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

        readfile($path, null, $context);
    }

    /**
     * Retrieve mime type of S3 object.
     *
     * @param string $path - absolute or relative path
     * @return string
     */
    public function getMimeType($path)
    {
        // It's not possible to get mime type with "mime_content_type" function.
        // See the discussion: https://github.com/aws/aws-sdk-php/issues/982
        // The workaround is to retrieve type from Head request, see example below.
        // However defining mime type based on file extension works well and covers most cases.

        //$meta = $this->getMetaData($key);
        //$type = $meta['content-type'];

        return mime_type_by_extension($path);
    }

    /**
     * Defines size of S3 object.
     *
     * @param string $path - absolute path
     * @return int|string
     */
    public function getFileSize($path)
    {
        return filesize($path);
    }

	/**
	 * Return summary info for specified folder.
     *
	 * @param string $dir - relative path
	 * @param array $result
	 * @return array
	 */
	public function getDirSummary($dir, &$result = ['size' => 0, 'files' => 0])
	{
	    $modelDir = new ItemModel($dir);

        /**
         * set empty delimiter to get recursive objects list
         * @see \Aws\S3\StreamWrapper::dir_opendir()
         */
        $context = stream_context_create([
            's3' => [
                'delimiter' => ''
            ]
        ]);

        $handle = @opendir($modelDir->getAbsolutePath(), $context);

        while (false !== ($file = readdir($handle))) {
            if (is_dir($modelDir->getAbsolutePath() . $file)) {
                $file .= '/';
            }

            $model = new ItemModel($modelDir->getRelativePath() . $file);

            if ($model->hasReadPermission() && $model->isUnrestricted()) {
                if (!$model->isDirectory()) {
                    $result['files']++;
                    $result['size'] += $this->getFileSize($model->getAbsolutePath());
                } else {
                    // stream wrapper opendir() lists only files
                }
            }
        }
        closedir($handle);

        return $result;
	}
}
