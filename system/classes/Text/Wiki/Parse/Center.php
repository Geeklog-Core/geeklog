<?php

namespace Geeklog\Text\Wiki;

    /**
     * Parses for centered lines of text.
     *
     * @category Text
     * @package  Text_Wiki
     * @author   Paul M. Jones <pmjones@php.net>
     * @license  LGPL
     * @version  $Id: Center.php 180591 2005-02-23 17:38:29Z pmjones $
     */

/**
 * Parses for centered lines of text.
 * This class implements a Text_Wiki_Parse to find lines marked for centering.
 * The line must start with "= " (i.e., an equal-sign followed by a space).
 *
 * @category Text
 * @package  Text_Wiki
 * @author   Paul M. Jones <pmjones@php.net>
 */
class Text_Wiki_Parse_Center extends Text_Wiki_Parse
{
    /**
     * The regular expression used to find source text matching this
     * rule.
     *
     * @var string
     */
    public $regex = '/\n\= (.*?)\n/';

    /**
     * Generates a token entry for the matched text.
     *
     * @param  array &$matches The array of matches from parse().
     * @return string A delimited token number to be used as a placeholder in
     *                        the source text.
     */
    public function process(&$matches)
    {
        $start = $this->wiki->addToken(
            $this->rule,
            array('type' => 'start')
        );

        $end = $this->wiki->addToken(
            $this->rule,
            array('type' => 'end')
        );

        return "\n" . $start . $matches[1] . $end . "\n";
    }
}
