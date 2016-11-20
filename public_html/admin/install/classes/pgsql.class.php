<?php

namespace Geeklog;

/**
 * Class Db_Pgsql
 *
 * @package Geeklog
 */
class Db_Pgsql extends Db
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
     * Db_Pgsql constructor.
     *
     * @param  array $args
     * @throws \Exception
     */
    public function __construct(array $args)
    {
        $this->args = $args;

        if (!is_callable('pgsql_connect')) {
            throw new \Exception(__METHOD__ . ': pgsql_connect is not supported.');
        }

        $this->conn = pg_connect(sprintf('host=%s user=%s password=%s dbname=%s', $args['host'], $args['user'], $args['pass'], $args['name']));

        if ($this->conn === false) {
            throw new \Exception(__METHOD__ . ': failed to connect to PostgreSQL server.');
        }

        $version = pg_version($this->conn);

        if (is_array($version) && isset($version['server'])) {
            $this->serverVersion = $this->getIntVersion($version['server']);
        } else {
            $this->serverVersion = 0;
        }

        if (!empty($args['charset'])) {
            pg_set_client_encoding($this->conn, $args['charset']);
        }
    }

    /**
     * Close database connection
     *
     * @return void
     */
    public function close()
    {
        pg_close($this->conn);
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
        $retval = pg_query($this->conn, $sql);

        return $retval;
    }

    /**
     * Return error message
     *
     * @return string
     */
    public function error()
    {
        return pg_last_error($this->conn);
    }

    /**
     * @param  string $version
     * @return int
     */
    private function getIntVersion($version)
    {
        $retval = 0;
        $version = preg_replace('/[^0-9.]/', '', $version);

        foreach (explode('.', $version) as $digit) {
            $retval = 100 * $retval + (int) $digit;
        }

        return $retval;
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
