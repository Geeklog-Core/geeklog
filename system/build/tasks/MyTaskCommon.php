<?php

abstract class MyTaskCommon
{
    /**
     * @var array
     */
    public static $startsWith = [
        '.git',
        '.idea',
        'build',
        'phpunit.xml',
        'public_html/layout/glnet_curve',
        'system/build',
        'tests',
    ];

    /**
     * @var array of paths that should be excluded from the resulting package
     */
    public static $excludes = [
        '/node_modules/',
        '/css_src/dest/',
        'buildpackage.php',
        '.php.dist',
    ];
}
