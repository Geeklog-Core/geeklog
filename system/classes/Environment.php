<?php

namespace Geeklog;

/**
 * Class Environment
 *
 * @package Geeklog
 */
abstract class Environment
{
    // Server software types
    const SS_APACHE = 'Apache';
    const SS_IIS = 'IIS';
    const SS_LITESPEED = 'LiteSpeed';
    const SS_NGINX = 'Nginx';
    const SS_UNKNOWN = 'unknown';

    // Web server PHP interface types
    const SI_APACHE_MODULE = 'module';
    const SI_CGI = 'cgi';
    const SI_CLI = 'cli';
    const SI_FASTCGI = 'fastcgi';
    const SI_UNKNOWN = 'unknown';

    /**
     * Return the server software
     *
     * @return string
     */
    public static function getServerSoftware()
    {
        if (stripos($_SERVER['SERVER_SOFTWARE'], 'apache') !== false) {
            $retval = self::SS_APACHE;
        } elseif (stripos($_SERVER['SERVER_SOFTWARE'], 'litespeed') !== false ||
            (PHP_SAPI === 'litespeed')) {
            $retval = self::SS_LITESPEED;
        } elseif (stripos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false) {
            $retval = self::SS_NGINX;
        } elseif (stripos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false ||
            (stripos($_SERVER['SERVER_SOFTWARE'], 'ExpressionDevServer') !== false)) {
            $retval = self::SS_IIS;
        } else {
            $retval = self::SS_UNKNOWN;
        }

        return $retval;
    }

    /**
     * Return web server PHP interface type
     *
     * @return string
     */
    public static function getServerInterface()
    {
        if (PHP_SAPI === 'cli') {
            // Command Line Interface
            $retval = self::SI_CLI;
        } elseif ((PHP_SAPI === 'fpm-fcgi') || (PHP_SAPI === 'cgi-fcgi')) {
            $retval = self::SI_FASTCGI;
        } elseif (strpos(PHP_SAPI, 'cgi') !== false) {
            $retval = self::SI_CGI;
        } else {
            if (strpos(PHP_SAPI, 'apache') !== false) {
                $retval = self::SI_APACHE_MODULE;
            } else {
                $retval = self::SI_UNKNOWN;
            }
        }

        return $retval;
    }
}
