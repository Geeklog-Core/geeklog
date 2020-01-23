<?php

namespace Geeklog;

use Exception;

/**
 * Class Db_Mysql
 *
 * @package Geeklog
 */
class Db_Mysql extends Db
{
    /**
     * @var resource
     */
    private $conn;

    /**
     * @var int
     */
    private $serverVersion;

    /**
     * Db_Mysql constructor.
     *
     * @param  array $args
     * @throws Exception
     */
    public function __construct(array $args)
    {
        if (!empty($args['charset'])) {
            $args['charset'] = $this->fixMysqlCharset($args['charset']);
        }

        $this->args = $args;

        if (!is_callable('mysql_connect')) {
            throw new Exception(__METHOD__ . ': mysql_connect is not supported.');
        }

        $this->conn = mysql_connect($args['host'], $args['user'], $args['pass']);

        if ($this->conn === false) {
            throw new Exception(__METHOD__ . ': failed to connect to MySQL server.');
        }

        if (!mysql_select_db($args['name'], $this->conn)) {
            throw new Exception(__METHOD__ . ': could not select database.');
        }

        $this->serverVersion = @mysql_get_server_info($this->conn);

        if (!empty($args['charset'])) {
            if (!mysql_set_charset($args['charset'], $this->conn)) {
                @mysql_query("SET NAMES {$args['charset']}");
            }
        }
    }

    /**
     * Close database connection
     *
     * @return void
     */
    public function close()
    {
        mysql_close($this->conn);
        $this->conn = null;
    }

    /**
     * Perform a query
     *
     * @param  string $sql
     * @return mixed
     */
    public function query($sql)
    {
        return mysql_query($sql, $this->conn);
    }

    /**
     * Return error message
     *
     * @return string
     */
    public function error()
    {
        return mysql_error($this->conn);
    }

    /**
     * Return server version
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->serverVersion;
    }
}
