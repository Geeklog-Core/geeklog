<?php

namespace RFM\Api;

interface ApiInterface
{
    /**
     * Return server-side data to override on the client-side
     *
     * @return array
     */
    public function actionInitiate();

    /**
     * Return file or folder stats info
     *
     * @return array
     */
    public function actionGetInfo();

    /**
     * Read folder and list its content
     *
     * @return array
     */
    public function actionReadFolder();

    /**
     * Look for files and/or folders that match search string
     *
     * @return array
     */
    public function actionSeekFolder();

    /**
     * Save data to file after editing
     */
    public function actionSaveFile();

    /**
     * Rename file or folder
     */
    public function actionRename();

    /**
     * Copy file or folder
     */
    public function actionCopy();

    /**
     * Move file or folder.
     * Also move file thumbnail, if it exists, and the destination dir already has a thumbnail dir.
     * If the destination dir does not have a thumbnail dir, it just deletes the thumbnail.
     */
    public function actionMove();

    /**
     * Delete existed file or folder
     */
    public function actionDelete();

    /**
     * Upload new file
     */
    public function actionUpload();

    /**
     * Create new folder
     *
     * @return array
     */
    public function actionAddFolder();

    /**
     * Download file
     */
    public function actionDownload();

    /**
     * Returns image file
     *
     * @param bool $thumbnail Whether to generate image thumbnail
     */
    public function actionGetImage($thumbnail);

    /**
     * Read and output file contents data
     */
    public function actionReadFile();

    /**
     * Retrieves storage summarize info
     *
     * @return array
     */
    public function actionSummarize();

    /**
     * Extracts files and folders from archive
     *
     * @return array
     */
    public function actionExtract();
}