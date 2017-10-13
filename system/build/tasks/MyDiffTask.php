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
    private $startsWith = array(
        '.git',
        '.idea',
        'build',
        'phpunit.xml',
        'public_html/layout/professional_css',
        'system/build',
        'tests',
    );

    /**
     * @var array
     */
    private $includes = array(
        '/node_modules/',
        '/css_src/dest/',
        'buildpackage.php',
        '.php.dist',
    );

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
     * Create the 'changed-files' file
     */
    public function main()
    {
        $currentDir = getcwd();
        chdir(__DIR__ . '/../../../');
        exec(sprintf('git diff --name-only %s %s', $this->previousVersionSHA, $this->currentVersionSHA), $lines);
        $lines = array_filter($lines, array($this, 'shouldInclude'));
        @file_put_contents('./public_html/docs/changed-files', implode("\n", $lines) . "\n");

        if ($currentDir !== false) {
            chdir($currentDir);
        }
    }
}
