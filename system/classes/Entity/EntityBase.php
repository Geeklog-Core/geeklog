<?php

namespace Geeklog\Entity;

abstract class EntityBase
{
    /**
     * @var bool
     */
    protected static $emulateMagicQuotes = true;

    /**
     * Return the current value to decide if we should behave as if magic_quotes_gpc were on
     *
     * @return bool
     */
    public static function isEmulateMagicQuotes()
    {
        return self::$emulateMagicQuotes;
    }

    /**
     * Set the value to decide if we should behave as if magic_quotes_gpc were on
     *
     * @param  bool  $emulateMagicQuotes
     */
    public static function setEmulateMagicQuotes($emulateMagicQuotes)
    {
        self::$emulateMagicQuotes = (bool) $emulateMagicQuotes;
    }

    /**
     * Add slashes if we should behave as if magic_quotes_gpc were on
     *
     * @param  string  $value
     * @return string
     */
    protected static function addSlashes($value)
    {
        return self::$emulateMagicQuotes ? addslashes($value) : $value;
    }

    /**
     * Strip slashes if we should behave as if magic_quotes_gpc were on
     *
     * @param  string  $value
     * @return string
     */
    protected static function stripSlashes($value)
    {
        return self::$emulateMagicQuotes ? stripslashes($value) : $value;
    }

    /**
     * Escape a string for database
     *
     * @param  string  $value
     * @return string
     */
    protected function escapeForDatabase($value)
    {
        return DB_escapeString($value);
    }

    /**
     * Make the entity into an array to be used for database or request
     *
     * @param  bool  $forDatabase
     * @return array
     */
    abstract public function toArray($forDatabase = true);
}
