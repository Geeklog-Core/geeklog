<?php

namespace Geeklog;

use Exception;

/**
 * Class Db
 *
 * @package Geeklog
 */
abstract class Db
{
    const DB_MYSQL = 'mysql';
    const DB_MYSQLI = 'mysqli';
    const DB_POSTGRES = 'postgres';

    /**
     * @var Db
     */
    private static $engine = null;

    /**
     * @var array
     */
    protected $args = array();

    /**
     * Return a list of available PHP's database extensions
     *
     * @param  bool $onlyMysql
     * @return array
     */
    public static function getDrivers($onlyMysql = true)
    {
        $retval = array();

        if (is_callable('mysql_connect')) {
            $retval[] = self::DB_MYSQL;
        }

        if (is_callable('mysqli_connect')) {
            $retval[] = self::DB_MYSQLI;
        }

        if (!$onlyMysql && is_callable('pg_connect')) {
            $retval[] = self::DB_POSTGRES;
        }

        return $retval;
    }

    /**
     * Convert Geeklog's $_CONF['default_charset'] to MySQL's charset
     *
     * @param  string $charset
     * @return string
     */
    public function fixMysqlCharset($charset)
    {
        $charset = strtolower($charset);
        $charset = preg_replace('/[^0-9a-z]/', '', $charset);

        return $charset;
    }

    /**
     * Connect to database driver
     *
     * @param  string $type
     * @param  array  $args
     * @return Db
     */
    public final static function connect($type, array $args)
    {
        try {
            switch ($type) {
                case self::DB_MYSQL:
                    require_once __DIR__ . '/mysql.class.php';

                    self::$engine = new Db_Mysql($args);
                    break;

                case self::DB_MYSQLI:
                    require_once __DIR__ . '/mysqli.class.php';

                    self::$engine = new Db_Mysqli($args);
                    break;

                case self::DB_POSTGRES:
                    require_once __DIR__ . '/pgsql.class.php';

                    self::$engine = new Db_Pgsql($args);
                    break;

                default:
                    throw new Exception(__METHOD__ . ': unknown database type "' . $type . '" was given.');
                    break;
            }

            $retval = self::$engine;
        } catch (Exception $e) {
            $retval = null;
        }

        return $retval;
    }

    /**
     * Perform a query
     *
     * @param  string $sql
     * @return mixed
     */
    abstract public function query($sql);

    /**
     * Return error message
     *
     * @return string
     */
    abstract public function error();

    /**
     * Return server version
     *
     * @return int
     */
    abstract public function getVersion();
}
