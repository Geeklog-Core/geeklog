<?php

namespace Geeklog\Text\Wiki;

/**
 * Parses for Text_Wiki delimiter characters already in the source text.
 *
 * @category Text
 * @package  Text_Wiki
 * @author   Paul M. Jones <pmjones@php.net>
 * @license  LGPL
 * @version  $Id: Delimiter.php 180591 2005-02-23 17:38:29Z pmjones $
 */

use Geeklog\Text\Wiki;

/**
 * Parses for Text_Wiki delimiter characters already in the source text.
 * This class implements a Text_Wiki_Parse to find instances of the delimiter
 * character already embedded in the source text; it extracts them and replaces
 * them with a delimited token, then renders them as the delimiter itself
 * when the target format is XHTML.
 *
 * @category Text
 * @package  Text_Wiki
 * @author   Paul M. Jones <pmjones@php.net>
 */
class Text_Wiki_Parse_Delimiter extends Text_Wiki_Parse
{
    /**
     * Constructor.  Overrides the Text_Wiki_Parse constructor so that we
     * can set the $regex property dynamically (we need to include the
     * Text_Wiki $delim character.
     *
     * @param Wiki &$obj The calling "parent" Text_Wiki object.
     */
    public function __construct($obj)
    {
        parent::__construct($obj);
        $this->regex = '/' . $this->wiki->delim . '/';
    }

    /**
     * Generates a token entry for the matched text.  Token options are:
     * 'text' => The full matched text.
     *
     * @param  array &$matches The array of matches from parse().
     * @return string A delimited token number to be used as a placeholder in
     *                        the source text.
     */
    public function process(&$matches)
    {
        return $this->wiki->addToken(
            $this->rule,
            array('text' => $this->wiki->delim)
        );
    }
}
