<?php

namespace RFM\Facade;

use function RFM\logger;

class Log
{
    /**
     * Logs an informational message to the log.
     * @param string $message
     */
    public static function info($message)
    {
        logger()->log($message);
    }
}