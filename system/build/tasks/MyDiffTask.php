<?php

require_once __DIR__ . '/../vendor/phing/phing/classes/phing/Task.php';

class MyDiffTask extends Task
{
    /**
     * @var string
     */
    private $previousVersionSHA;

    /**
     * @var
     */
    private $currentVersionSHA;

    /**
     * @var array
     */
    private $startsWith = [
        '.git',
        '.idea',
        'build',
        'phpunit.xml',
        'public_html/layout/glnet_curve',
        'system/build',
        'tests',
    ];

    /**
     * @var array
     */
    private $includes = [
        '/node_modules/',
        '/css_src/dest/',
        'buildpackage.php',
        '.php.dist',
    ];

    /**
     * Initialize the task
     */
    public function init()
    {
        return true;
    }

    /**
     * Setter for the attribute "previousVersionSHA"
     *
     * @param  string $version
     */
    public function setPreviousVersionSHA($version)
    {
        $this->previousVersionSHA = $version;
    }

    /**
     * Setter for the attribute "currentVersionSHA"
     *
     * @param  string $version
     */
    public function setCurrentVersionSHA($version)
    {
        $this->currentVersionSHA = $version;
    }

    /**
     * Return if a given path should be included in diff result
     *
     * @param  string $path
     * @return bool   true if the $path should be included in diff result
     */
    private function shouldInclude($path)
    {
        foreach ($this->startsWith as $needle) {
            if (strpos($path, $needle) === 0) {
                return false;
            }
        }

        foreach ($this->includes as $needle2) {
            if (strpos($path, $needle2) > 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Create the 'changed-files' and 'removed-files' files
     */
    public function main()
    {
        $currentDir = getcwd();
        chdir(__DIR__ . '/../../../');

		exec('git config diff.renameLimit 999999');

		// Create 'changed-files'
		exec(sprintf('git diff --name-only %s %s', $this->previousVersionSHA, $this->currentVersionSHA), $lines);
        $changedFiles = array_filter($lines, [$this, 'shouldInclude']);
        @file_put_contents('./public_html/docs/changed-files', implode("\n", $changedFiles) . "\n");

        // Create 'removed-files'
        unset($lines);
        exec(sprintf('git diff --name-only --diff-filter=ACMRTUX %s %s', $this->previousVersionSHA, $this->currentVersionSHA), $lines);
        $otherFiles = array_filter($lines, [$this, 'shouldInclude']);
        $otherFiles = array_diff($changedFiles, $otherFiles);
        @file_put_contents('./public_html/docs/removed-files', implode("\n", $otherFiles) . "\n");

        exec('git config --unset diff.renameLimit');

        if ($currentDir !== false) {
            chdir($currentDir);
        }
    }
}
