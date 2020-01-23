<?php

namespace Geeklog;

use Exception;
use mysqli;

/**
 * Class Db_Mysqli
 *
 * @package Geeklog
 */
class Db_Mysqli extends Db
{
    /**
     * @var mysqli
     */
    private $conn;

    /**
     * @var int
     */
    private $serverVersion;

    /**
     * Db_Mysqli constructor.
     *
     * @param  array  $args
     * @throws Exception
     */
    public function __construct(array $args)
    {
        if (!empty($args['charset'])) {
            $args['charset'] = $this->fixMysqlCharset($args['charset']);
        }

        $this->args = $args;

        if (!is_callable('mysqli_connect')) {
            throw new Exception(__METHOD__ . ': mysqli_connect is not supported.');
        }

        $this->conn = new mysqli($args['host'], $args['user'], $args['pass'], $args['name']);

        if ($this->conn->connect_error) {
            throw new Exception(__METHOD__ . ': failed to connect to MySQL server.');
        }

        $this->serverVersion = $this->conn->server_version;

        if (!empty($args['charset'])) {
            if (!$this->conn->set_charset($args['charset'])) {
                @$this->conn->query("SET NAMES {$args['charset']}");
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
        $this->conn->close();
        $this->conn = null;
    }

    /**
     * Perform a query
     *
     * @param  string  $sql
     * @return mixed
     */
    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    /**
     * Return error message
     *
     * @return string
     */
    public function error()
    {
        return $this->conn->error;
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
