<?php

namespace Geeklog\Text;

abstract class Utility
{
    /**
     * Convert a string to camel case
     *
     * @param  string  $str
     * @param  string  $glue
     * @param  string  $separator
     * @return string
     * @example 'this_is_snake_case' => 'thisIsSnakeCase'
     */
    public static function toCamelCase($str, $glue = '', $separator = '_')
    {
        return lcfirst(self::toPascalCase($str, $glue, $separator));
    }

    /**
     * Convert a string to Pascal case
     *
     * @param  string  $str
     * @param  string  $glue
     * @param  string  $separator
     * @return string
     * @example 'this_is_snake_case' => 'ThisIsSnakeCase'
     */
    public static function toPascalCase($str, $glue = '', $separator = '_')
    {
        $parts = [];

        foreach (explode($separator, $str) as $part) {
            if ((strlen($part) >= 2)
                && ($part[0] === strtolower($part[0])) && ($part[1] === strtolower($part[1]))) {
                $part = ucfirst($part);
            }

            $parts[] = $part;
        }

        return implode($glue, $parts);
    }
}
