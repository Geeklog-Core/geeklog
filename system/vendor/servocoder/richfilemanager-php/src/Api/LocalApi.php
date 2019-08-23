<?php

namespace RFM\Api;

use RFM\Facade\Input;
use RFM\Facade\Log;
use RFM\Event\Api as ApiEvent;
use RFM\Repository\BaseStorage;
use RFM\Repository\Local\ItemModel;
use function RFM\app;
use function RFM\request;
use function RFM\dispatcher;

class LocalApi implements ApiInterface
{
    /**
     * @var \RFM\Repository\Local\Storage
     */
    protected $storage;

    /**
     * Api constructor.
     */
    public function __construct()
    {
        $this->storage = app()->getStorage(BaseStorage::STORAGE_LOCAL_NAME);
    }

    /**
     * @inheritdoc
     */
    public function actionInitiate()
    {
        // config options that affect the client-side
        $shared_config = [
            'security' => [
                'readOnly' => $this->storage->config('security.readOnly'),
                'extensions' => [
                    'policy' => $this->storage->config('security.extensions.policy'),
                    'ignoreCase' => $this->storage->config('security.extensions.ignoreCase'),
                    'restrictions' => $this->storage->config('security.extensions.restrictions'),
                ],
            ],
            'upload' => [
                'fileSizeLimit' => $this->storage->config('upload.fileSizeLimit'),
                'paramName' => $this->storage->config('upload.paramName'),
            ],
            'viewer' => [
                'absolutePath' => $this->storage->config('viewer.absolutePath'),
                'previewUrl' => $this->storage->config('viewer.previewUrl'),
            ],
        ];

        return [
            'id' => '/',
            'type' => 'initiate',
            'attributes' => [
                'config' => $shared_config,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionReadFolder()
    {
        $filesList = [];
        $filesPaths = [];
        $responseData = [];
        $model = new ItemModel(Input::get('path'));
        Log::info('opening folder "' . $model->getAbsolutePath() . '"');

        $model->checkPath();
        $model->checkReadPermission();
        $model->checkRestrictions();

        if (!$model->isDirectory()) {
            app()->error('DIRECTORY_NOT_EXIST', [$model->getRelativePath()]);
        }

        if (!$handle = @opendir($model->getAbsolutePath())) {
            app()->error('UNABLE_TO_OPEN_DIRECTORY', [$model->getRelativePath()]);
        } else {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    array_push($filesList, $file);
                }
            }
            closedir($handle);

            foreach ($filesList as $file) {
                $filePath = $model->getRelativePath() . $file;
                $fileFullPath = $model->getAbsolutePath() . $file;

                // directory path must end with slash
                if (is_dir($fileFullPath)) {
                    $filePath .= '/';
                }

                $item = new ItemModel($filePath);
                if ($item->isUnrestricted()) {
                    $filesPaths[] = $item->getAbsolutePath();
                    $responseData[] = $item->getData()->formatJsonApi();
                }
            }
        }

        // create event and dispatch it
        $event = new ApiEvent\AfterFolderReadEvent($model->getData(), $filesPaths);
        dispatcher()->dispatch($event::NAME, $event);

        return $responseData;
    }

    /**
     * @inheritdoc
     */
    public function actionSeekFolder()
    {
        $searchString = Input::get('string');
        $model = new ItemModel(Input::get('path'));
        Log::info('search for "' . $searchString . '" in "' . $model->getAbsolutePath() . '" folder');

        $model->checkPath();
        $model->checkReadPermission();
        $model->checkRestrictions();

        $filesPaths = [];
        $responseData = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($model->getAbsolutePath(),
                \FilesystemIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::SELF_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        );

        foreach ($iterator as $spl) {
            $filename = $spl->getFilename();
            $pathname = $spl->getPathname();

            // case insensitive comparison
            if (starts_with(mb_strtolower($filename), mb_strtolower($searchString))) {
                // directory path must end with slash
                $pathname .= $spl->isDir() ? '/' : '';

                $relativePath = $this->storage->subtractPath($pathname, $this->storage->getRoot());
                $item = new ItemModel($relativePath);
                if ($item->isUnrestricted()) {
                    $filesPaths[] = $item->getAbsolutePath();
                    $responseData[] = $item->getData()->formatJsonApi();
                }
            }
        }

        // create event and dispatch it
        $event = new ApiEvent\AfterFolderSeekEvent($model->getData(), $searchString, $filesPaths);
        dispatcher()->dispatch($event::NAME, $event);

        return $responseData;
    }

    /**
     * @inheritdoc
     */
    public function actionGetInfo()
    {
        $model = new ItemModel(Input::get('path'));
        Log::info('opening file "' . $model->getAbsolutePath() . '"');

        $model->checkPath();
        $model->checkReadPermission();
        $model->checkRestrictions();

        return $model->getData()->formatJsonApi();
    }

    /**
     * @inheritdoc
     */
    public function actionUpload()
    {
        $model = new ItemModel(Input::get('path'));
        Log::info('uploading to "' . $model->getAbsolutePath() . '"');

        $model->checkPath();
        $model->checkWritePermission();

        $itemData = null;
        $responseData = [];
        $paramName = $this->storage->config('upload.paramName');
        $content = $this->storage->initUploader($model)->post(false);
        $files = isset($content[$paramName]) ? $content[$paramName] : null;

        // there is only one file in the array as long as "singleFileUploads" is set to "true"
        if ($files && is_array($files) && is_object($files[0])) {
            $file = $files[0];
            if (isset($file->error)) {
                $error = is_array($file->error) ? $file->error : [$file->error];
                app()->error($error[0], isset($error[1]) ? $error[1] : []);
            } else {
                $uploadedPath = $this->storage->cleanPath('/' . $model->getRelativePath() . '/' . $file->name);
                $modelUploaded = new ItemModel($uploadedPath);
                $itemData = $modelUploaded->getData();
                $responseData[] = $itemData->formatJsonApi();
            }
        } else {
            app()->error('ERROR_UPLOADING_FILE');
        }

        // create event and dispatch it
        $event = new ApiEvent\AfterFileUploadEvent($itemData);
        dispatcher()->dispatch($event::NAME, $event);

        return $responseData;
    }

    /**
     * @inheritdoc
     */
    public function actionAddFolder()
    {
        $targetPath = Input::get('path');
        $targetName = Input::get('name');

        $modelTarget = new ItemModel($targetPath);
        $modelTarget->checkPath();
        $modelTarget->checkWritePermission();

        $dirName = $this->storage->normalizeString(trim($targetName, '/')) . '/';
        $relativePath = $this->storage->cleanPath('/' . $targetPath . '/' . $dirName);

        $model = new ItemModel($relativePath);
        Log::info('adding folder "' . $model->getAbsolutePath() . '"');

        $model->checkRestrictions();

        if ($model->isExists() && $model->isDirectory()) {
            app()->error('DIRECTORY_ALREADY_EXISTS', [$targetName]);
        }

        if (!$this->storage->createFolder($model, $modelTarget)) {
            app()->error('UNABLE_TO_CREATE_DIRECTORY', [$targetName]);
        }

        // update items stats
        $model->resetStats()->compileData();

        // create event and dispatch it
        $event = new ApiEvent\AfterFolderCreateEvent($model->getData());
        dispatcher()->dispatch($event::NAME, $event);

        return $model->getData()->formatJsonApi();
    }

    /**
     * @inheritdoc
     */
    public function actionRename()
    {
        $modelOld = new ItemModel(Input::get('old'));
        $suffix = $modelOld->isDirectory() ? '/' : '';
        $filename = Input::get('new');

        // forbid to change path during rename
        if (strrpos($filename, '/') !== false) {
            app()->error('FORBIDDEN_CHAR_SLASH');
        }

        // check if not requesting root storage folder
        if ($modelOld->isDirectory() && $modelOld->isRoot()) {
            app()->error('NOT_ALLOWED');
        }

        $modelNew = new ItemModel($modelOld->closest()->getRelativePath() . $filename . $suffix);
        Log::info('moving "' . $modelOld->getAbsolutePath() . '" to "' . $modelNew->getAbsolutePath() . '"');

        $modelOld->checkPath();
        $modelOld->checkWritePermission();
        $modelOld->checkRestrictions();
        $modelNew->checkRestrictions();

        // define thumbnails models
        $modelThumbOld = $modelOld->thumbnail();
        $modelThumbNew = $modelNew->thumbnail();

        // check thumbnail file or thumbnails folder permissions
        if ($modelThumbOld->isExists()) {
            $modelThumbOld->checkWritePermission();
        }

        if ($modelNew->isExists()) {
            if ($modelNew->isDirectory()) {
                app()->error('DIRECTORY_ALREADY_EXISTS', [$modelNew->getRelativePath()]);
            } else {
                app()->error('FILE_ALREADY_EXISTS', [$modelNew->getRelativePath()]);
            }
        }

        // rename file or folder
        if ($this->storage->renameRecursive($modelOld, $modelNew)) {
            Log::info('renamed "' . $modelOld->getAbsolutePath() . '" to "' . $modelNew->getAbsolutePath() . '"');

            // rename thumbnail file or thumbnails folder if exists
            if ($modelThumbOld->isExists()) {
                $this->storage->renameRecursive($modelThumbOld, $modelThumbNew);
            }
        } else {
            if ($modelOld->isDirectory()) {
                app()->error('ERROR_RENAMING_DIRECTORY', [$modelOld->getRelativePath(), $modelNew->getRelativePath()]);
            } else {
                app()->error('ERROR_RENAMING_FILE', [$modelOld->getRelativePath(), $modelNew->getRelativePath()]);
            }
        }

        // update items stats
        $modelNew->resetStats()->compileData();
        $modelOld->resetStats()->compileData();

        // create event and dispatch it
        $event = new ApiEvent\AfterItemRenameEvent($modelNew->getData(), $modelOld->getData());
        dispatcher()->dispatch($event::NAME, $event);

        return $modelNew->getData()->formatJsonApi();
    }

    /**
     * @inheritdoc
     */
    public function actionCopy()
    {
        $modelSource = new ItemModel(Input::get('source'));
        $modelTarget = new ItemModel(Input::get('target'));

        $suffix = $modelSource->isDirectory() ? '/' : '';
        $basename = basename($modelSource->getAbsolutePath());
        $modelNew = new ItemModel($modelTarget->getRelativePath() . $basename . $suffix);
        Log::info('copying "' . $modelSource->getAbsolutePath() . '" to "' . $modelNew->getAbsolutePath() . '"');

        if (!$modelTarget->isDirectory()) {
            app()->error('DIRECTORY_NOT_EXIST', [$modelTarget->getRelativePath()]);
        }

        // check if not requesting root storage folder
        if ($modelSource->isDirectory() && $modelSource->isRoot()) {
            app()->error('NOT_ALLOWED');
        }

        // check items permissions
        $modelSource->checkPath();
        $modelSource->checkReadPermission();
        $modelSource->checkRestrictions();
        $modelTarget->checkPath();
        $modelTarget->checkWritePermission();
        $modelNew->checkRestrictions();

        // check if file already exists
        if ($modelNew->isExists()) {
            if ($modelNew->isDirectory()) {
                app()->error('DIRECTORY_ALREADY_EXISTS', [$modelNew->getRelativePath()]);
            } else {
                app()->error('FILE_ALREADY_EXISTS', [$modelNew->getRelativePath()]);
            }
        }

        // define thumbnails models
        $modelThumbOld = $modelSource->thumbnail();
        $modelThumbNew = $modelNew->thumbnail();

        // check thumbnail file or thumbnails folder permissions
        if ($modelThumbOld->isExists()) {
            $modelThumbOld->checkReadPermission();
            if ($modelThumbNew->closest()->isExists()) {
                $modelThumbNew->closest()->checkWritePermission();
            }
        }

        // copy file or folder
        if($this->storage->copyRecursive($modelSource, $modelNew)) {
            Log::info('copied "' . $modelSource->getAbsolutePath() . '" to "' . $modelNew->getAbsolutePath() . '"');

            // copy thumbnail file or thumbnails folder
            if ($modelThumbOld->isExists()) {
                if ($modelThumbNew->closest()->isExists()) {
                    $this->storage->copyRecursive($modelThumbOld, $modelThumbNew);
                }
            }
        } else {
            if ($modelSource->isDirectory()) {
                app()->error('ERROR_COPYING_DIRECTORY', [$basename, $modelTarget->getRelativePath()]);
            } else {
                app()->error('ERROR_COPYING_FILE', [$basename, $modelTarget->getRelativePath()]);
            }
        }

        // update items stats
        $modelNew->resetStats()->compileData();

        // create event and dispatch it
        $event = new ApiEvent\AfterItemCopyEvent($modelNew->getData(), $modelSource->getData());
        dispatcher()->dispatch($event::NAME, $event);

        return $modelNew->getData()->formatJsonApi();
    }

    /**
     * @inheritdoc
     */
    public function actionMove()
    {
        $modelSource = new ItemModel(Input::get('old'));
        $modelTarget = new ItemModel(Input::get('new'));

        $suffix = $modelSource->isDirectory() ? '/' : '';
        $basename = basename($modelSource->getAbsolutePath());
        $modelNew = new ItemModel($modelTarget->getRelativePath() . $basename . $suffix);
        Log::info('moving "' . $modelSource->getAbsolutePath() . '" to "' . $modelNew->getAbsolutePath() . '"');

        if (!$modelTarget->isDirectory()) {
            app()->error('DIRECTORY_NOT_EXIST', [$modelTarget->getRelativePath()]);
        }

        // check if not requesting root storage folder
        if ($modelSource->isDirectory() && $modelSource->isRoot()) {
            app()->error('NOT_ALLOWED');
        }

        // check items permissions
        $modelSource->checkPath();
        $modelSource->checkWritePermission();
        $modelSource->checkRestrictions();
        $modelTarget->checkPath();
        $modelTarget->checkWritePermission();
        $modelNew->checkRestrictions();

        // check if file already exists
        if ($modelNew->isExists()) {
            if ($modelNew->isDirectory()) {
                app()->error('DIRECTORY_ALREADY_EXISTS', [$modelNew->getRelativePath()]);
            } else {
                app()->error('FILE_ALREADY_EXISTS', [$modelNew->getRelativePath()]);
            }
        }

        // define thumbnails models
        $modelThumbOld = $modelSource->thumbnail();
        $modelThumbNew = $modelNew->thumbnail();

        // check thumbnail file or thumbnails folder permissions
        if ($modelThumbOld->isExists()) {
            $modelThumbOld->checkWritePermission();
            if ($modelThumbNew->closest()->isExists()) {
                $modelThumbNew->closest()->checkWritePermission();
            }
        }

        // move file or folder
        if ($this->storage->renameRecursive($modelSource, $modelNew)) {
            Log::info('moved "' . $modelSource->getAbsolutePath() . '" to "' . $modelNew->getAbsolutePath() . '"');

            // move thumbnail file or thumbnails folder if exists
            if ($modelThumbOld->isExists()) {
                // do if target paths exists, otherwise remove old thumbnail(s)
                if ($modelThumbNew->closest()->isExists()) {
                    $this->storage->renameRecursive($modelThumbOld, $modelThumbNew);
                } else {
                    $modelThumbOld->remove();
                }
            }
        } else {
            if ($modelSource->isDirectory()) {
                app()->error('ERROR_MOVING_DIRECTORY', [$basename, $modelTarget->getRelativePath()]);
            } else {
                app()->error('ERROR_MOVING_FILE', [$basename, $modelTarget->getRelativePath()]);
            }
        }

        // update items stats
        $modelNew->resetStats()->compileData();
        $modelSource->resetStats()->compileData();

        // create event and dispatch it
        $event = new ApiEvent\AfterItemMoveEvent($modelNew->getData(), $modelSource->getData());
        dispatcher()->dispatch($event::NAME, $event);

        return $modelNew->getData()->formatJsonApi();
    }

    /**
     * @inheritdoc
     */
    public function actionSaveFile()
    {
        $model = new ItemModel(Input::get('path'));
        Log::info('saving file "' . $model->getAbsolutePath() . '"');

        $model->checkPath();
        $model->checkWritePermission();
        $model->checkRestrictions();

        if($model->isDirectory()) {
            app()->error('FORBIDDEN_ACTION_DIR');
        }

        $result = file_put_contents($model->getAbsolutePath(), Input::get('content'), LOCK_EX);

        if(!is_numeric($result)) {
            app()->error('ERROR_SAVING_FILE');
        }

        Log::info('saved "' . $model->getAbsolutePath() . '"');

        // get updated file info after save
        clearstatcache();
        return $model->getData()->formatJsonApi();
    }

    /**
     * @inheritdoc
     */
    public function actionReadFile()
    {
        $model = new ItemModel(Input::get('path'));
        Log::info('reading file "' . $model->getAbsolutePath() . '"');

        $model->checkPath();
        $model->checkReadPermission();
        $model->checkRestrictions();

        if($model->isDirectory()) {
            app()->error('FORBIDDEN_ACTION_DIR');
        }

        header('Content-Disposition: inline');

        $this->storage->readFile($model->getAbsolutePath());
        exit;
    }

    /**
     * @inheritdoc
     */
    public function actionGetImage($thumbnail)
    {
        $modelImage = new ItemModel(Input::get('path'));
        Log::info('loading image "' . $modelImage->getAbsolutePath() . '"');

        if ($modelImage->isDirectory()) {
            app()->error('FORBIDDEN_ACTION_DIR');
        }

        // if $thumbnail is set to true we return the thumbnail
        if ($thumbnail === true && $this->storage->config('images.thumbnail.enabled')) {
            // create thumbnail model
            $model = $modelImage->thumbnail();

            // generate thumbnail if it doesn't exist or caching is disabled
            if (!$model->isExists() || $this->storage->config('images.thumbnail.cache') === false) {
                $modelImage->createThumbnail();
            }
        } else {
            $model = $modelImage;
        }

        $model->checkReadPermission();
        $model->checkRestrictions();

        header('Content-Disposition: inline');

        $this->storage->readFile($model->getAbsolutePath());
        exit;
    }

    /**
     * @inheritdoc
     */
    public function actionDelete()
    {
        $model = new ItemModel(Input::get('path'));
        Log::info('deleting "' . $model->getAbsolutePath() . '"');

        $model->checkPath();
        $model->checkWritePermission();
        $model->checkRestrictions();

        // check if not requesting root storage folder
        if ($model->isDirectory() && $model->isRoot()) {
            app()->error('NOT_ALLOWED');
        }

        $modelThumb = $model->thumbnail();

        if ($model->remove()) {
            Log::info('deleted "' . $model->getAbsolutePath() . '"');

            // delete thumbnail(s) if exist(s)
            if ($modelThumb->isExists()) {
                $modelThumb->remove();
            }
        } else {
            if ($model->isDirectory()) {
                app()->error('ERROR_DELETING_DIRECTORY', [$model->getRelativePath()]);
            } else {
                app()->error('ERROR_DELETING_FILE', [$model->getRelativePath()]);
            }
        }

        // update items stats
        $model->resetStats()->compileData();

        // create event and dispatch it
        $event = new ApiEvent\AfterItemDeleteEvent($model->getData());
        dispatcher()->dispatch($event::NAME, $event);

        return $model->getData()->formatJsonApi();
    }

    /**
     * @inheritdoc
     */
    public function actionDownload()
    {
        $model = new ItemModel(Input::get('path'));
        Log::info('downloading "' . $model->getAbsolutePath() . '"');

        $model->checkPath();
        $model->checkReadPermission();
        $model->checkRestrictions();

        // check if not requesting root storage folder
        if ($model->isDirectory() && $model->isRoot()) {
            app()->error('NOT_ALLOWED');
        }

        $targetPath = $model->getAbsolutePath();

        if ($model->isDirectory()) {
            $destinationPath = sys_get_temp_dir() . '/' . basename($model->getAbsolutePath()) . '.zip';

            // if Zip archive is created
            if ($this->storage->zipFile($targetPath, $destinationPath, true)) {
                $targetPath = $destinationPath;
            } else {
                app()->error('ERROR_CREATING_ZIP');
            }
        }

        header('Content-Description: File Transfer');
        header('Content-Disposition: attachment; filename="' . basename($targetPath) . '"');
        // handle caching
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

        $this->storage->readFile($targetPath);

        // create event and dispatch it
        $event = new ApiEvent\AfterItemDownloadEvent($model->getData());
        dispatcher()->dispatch($event::NAME, $event);

        Log::info('downloaded "' . $targetPath . '"');
        exit;
    }

    /**
     * @inheritdoc
     */
    public function actionSummarize()
    {
        $path = '/';
        $attributes = [
            'size' => 0,
            'files' => 0,
            'folders' => 0,
            'sizeLimit' => $this->storage->config('options.fileRootSizeLimit'),
        ];

        try {
            $this->storage->getDirSummary($path, $attributes);
        } catch (\Exception $e) {
            app()->error('ERROR_SERVER');
        }

        return [
            'id' => $path,
            'type' => 'summary',
            'attributes' => $attributes,
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionExtract()
    {
        if (!extension_loaded('zip')) {
            app()->error('NOT_FOUND_SYSTEM_MODULE', ['zip']);
        }

        $modelSource = new ItemModel(Input::get('source'));
        $modelTarget = new ItemModel(Input::get('target'));
        Log::info('extracting "' . $modelSource->getAbsolutePath() . '" to "' . $modelTarget->getAbsolutePath() . '"');

        $modelSource->checkPath();
        $modelTarget->checkPath();
        $modelSource->checkReadPermission();
        $modelTarget->checkWritePermission();
        $modelSource->checkRestrictions();
        $modelTarget->checkRestrictions();

        if ($modelSource->isDirectory()) {
            app()->error('FORBIDDEN_ACTION_DIR');
        }

        $zip = new \ZipArchive();
        if ($zip->open($modelSource->getAbsolutePath()) !== true) {
            app()->error('ERROR_EXTRACTING_FILE');
        }

        $fileNames = [];
        $rootLevelItems = [];
        $responseData = [];

        // make all the folders first
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            $model = new ItemModel($modelTarget->getRelativePath() . $filename);

            if ($model->isDirectory() && $model->isUnrestricted()) {
                $created = $this->storage->createFolder($model, $modelTarget);

                if ($created) {
                    // extract root-level folders from archive manually
                    $rootName = substr($filename, 0, strpos($filename, '/') + 1);
                    if (!array_key_exists($rootName, $rootLevelItems)) {
                        $rootItemModel = ($rootName === $filename) ? $model : new ItemModel($modelTarget->getRelativePath() . $rootName);
                        $rootLevelItems[$rootName] = $rootItemModel;
                    }
                }
            }
        }

        // unzip files into the created folders
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            $model = new ItemModel($modelTarget->getRelativePath() . $filename);

            if (!$model->isDirectory() && $model->isUnrestricted()) {
                $copied = copy('zip://' . $modelSource->getAbsolutePath() . '#' . $filename, $model->getAbsolutePath());

                if ($copied) {
                    $fileNames[] = $model->getAbsolutePath();
                    if (strpos($filename, '/') === false) {
                        $rootLevelItems[] = $model;
                    }
                }
            }
        }

        $zip->close();

        foreach ($rootLevelItems as $model) { /* @var $model ItemModel */
            // update items stats
            $responseData[] = $model->resetStats()->getData()->formatJsonApi();
        }

        // create event and dispatch it
        $event = new ApiEvent\AfterFileExtractEvent($modelSource->getData(), $fileNames);
        dispatcher()->dispatch($event::NAME, $event);

        return $responseData;
    }
}