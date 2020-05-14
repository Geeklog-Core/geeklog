<?php

require_once dirname(__DIR__) . '/vendor/phing/phing/classes/phing/Task.php';

class MyRemoveUnchangedFilesTask extends Task
{
    /**
     * @var array
     */
    private $startsWith = [];

    /**
     * @var array of paths that should be excluded from the resulting archive
     */
    private $excludes = [];

    /**
     * @var array
     */
    private $filesToInclude = [];

    /**
     * @var string
     */
    private $previousVersionSHA;

    /**
     * @var string
     */
    private $currentVersionSHA;

    /**
     * @var string
     */
    private $dstDir;

    /**
     * Initialize the task
     */
    public function init()
    {
        require_once __DIR__ . '/MyTaskCommon.php';
        $this->startsWith = MyTaskCommon::$startsWith;
        $this->excludes = MyTaskCommon::$excludes;

        return true;
    }

    /**
     * Setter for the attribute "previousVersionSHA"
     *
     * @param  string  $version
     */
    public function setPreviousVersionSHA($version)
    {
        $this->previousVersionSHA = $version;
    }

    /**
     * Setter for the attribute "currentVersionSHA"
     *
     * @param  string  $version
     */
    public function setCurrentVersionSHA($version)
    {
        $this->currentVersionSHA = $version;
    }

    /**
     * Setter for the attribute "dstDir"
     *
     * @param  string  $dir
     */
    public function setDstDir($dir)
    {
        $this->dstDir = str_replace('/\\', '/', $dir) . '/';
    }

    /**
     * Return if a given path should be included in diff result
     *
     * @param  string  $path
     * @return bool   true if the $path should be included in diff result
     */
    private function shouldInclude($path)
    {
        foreach ($this->startsWith as $needle) {
            if (strpos($path, $needle) === 0) {
                return false;
            }
        }

        foreach ($this->excludes as $needle2) {
            if (strpos($path, $needle2) > 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Remove files to exclude from the upgrade package
     *
     * @param  string  $dir  current directory
     */
    private function removeUnnecessaryFiles($dir)
    {
        foreach (scandir($dir) as $item) {
            if (($item === '.') || ($item === '..')) {
                continue;
            }

            $path = $dir . $item;

            if (is_dir($path)) {
                $this->removeUnnecessaryFiles($path . '/');
            } else {
                $relativePath = str_ireplace($this->dstDir, '', $path);

                if (!in_array($relativePath, $this->filesToInclude) || !$this->shouldInclude($relativePath)) {
                    @unlink($path);
                }
            }
        }

        // Remove an empty directory
        if (count(scandir($dir)) === 2) {
            @rmdir($dir);
        }
    }

    /**
     * Create an upgrade distribution tarball
     */
    public function main()
    {
        $currentDir = getcwd();
        chdir(__DIR__ . '/../../../');
        exec('git config diff.renameLimit 999999');

        exec(sprintf('git diff --name-only --diff-filter=ACMR %s %s', $this->previousVersionSHA, $this->currentVersionSHA), $lines);
        $this->filesToInclude = array_filter($lines, [$this, 'shouldInclude']);
        $this->removeUnnecessaryFiles($this->dstDir);

        // Create the 'removed-files' file
        unset($lines);
        exec(sprintf('git diff --name-only --diff-filter=R %s %s', $this->previousVersionSHA, $this->currentVersionSHA), $lines);
        $removedFiles = array_filter($lines, [$this, 'shouldInclude']);
        @file_put_contents('./public_html/docs/removed-files', implode("\n", $removedFiles) . "\n");

        exec('git config --unset diff.renameLimit');

        if ($currentDir !== false) {
            chdir($currentDir);
        }

    }
}
