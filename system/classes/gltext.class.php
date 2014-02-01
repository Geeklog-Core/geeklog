<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.0                                                               |
// +---------------------------------------------------------------------------+
// | gltext.class.php                                                          |
// |                                                                           |
// | Geeklog Text Abstraction.                                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2013 by the following authors:                         |
// |                                                                           |
// | Authors: Michael Jervis, mike AT fuckingbrit DOT com                      |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
 * Constants for GLText
 * Version of GLText engine
 */
define('GLTEXT_FIRST_VERSION',  1);
define('GLTEXT_LATEST_VERSION', 2);

class GLText
{
    /**
     * Returns text ready for the edit fields.
     *
     * @param   string  $text      Text to prepare for editing
     * @param   string  $postmode  Indicates if text is html, wikitext or plaintext
     * @param   int     $version   version of GLText engine
     * @return  string  Escaped String
     * @access  public
     *
     */
    public static function getEditText($text, $postmode, $version)
    {
        if ($version == GLTEXT_FIRST_VERSION) {

            // first version

            // Remove any autotags the user doesn't have permission to use
            $text = PLG_replaceTags($text, '', true);

            if ($postmode == 'plaintext') {

                $text = COM_undoClickableLinks($text);

            } elseif ($postmode == 'wikitext') {

                $text = self::_editUnescape($text, $postmode);

            } else {
                // html
                $text = str_replace('<pre><code>',   '[code]',  $text);
                $text = str_replace('</code></pre>', '[/code]', $text);
                $text = str_replace('<!--raw--><span class="raw">', '[raw]',  $text);
                $text = str_replace('</span><!--/raw-->',           '[/raw]', $text);
                $text = self::_editUnescape($text, $postmode);
                $text = htmlspecialchars($text, ENT_QUOTES, COM_getEncodingt());
            }

            $text = self::_displayEscape($text);

        } else {

            // latest version

            $text = htmlspecialchars($text, ENT_QUOTES, COM_getEncodingt());
        }

        return $text;
    }

    /**
     * Returns text ready for display.
     *
     * @param   string  $text         Text to prepare for display
     * @param   string  $postmode     Indicates if text is html, adveditor, wikitext or plaintext
     * @param   int     $version      version of GLText engine
     * @return  string  Escaped String
     * @access  public
     *
     */
    public static function getDisplayText($text, $postmode, $version)
    {
        if ($version == GLTEXT_FIRST_VERSION) {

            // first version

            if ($postmode == 'plaintext') {
                $text = COM_nl2br($text);
            }

            if ($postmode == 'wikitext') {
                $text = self::_editUnescape($text, $postmode);
                $text = self::renderWikiText($text);
            }

        } else {

            // latest version

            if ($postmode == 'html' || $postmode == 'adveditor') {

                // Get rid of any newline characters
                $text = str_replace("\n", '', $text);

                $text = self::_handleSpecialTag_callback($text,
                    array('[code]', '[/code]', '<pre><code>', '</code></pre>'),
                    '_escapeSPChars');

                $text = self::_handleSpecialTag_callback($text,
                    array('[raw]', '[/raw]', '<!--raw--><span class="raw">', '</span><!--/raw-->'),
                    '_escapeSPChars');
            }

            if ($postmode == 'plaintext') {
                $text = htmlspecialchars($text, ENT_QUOTES, COM_getEncodingt());
                $text = COM_makeClickableLinks($text);
                $text = COM_nl2br($text);
            }

            if ($postmode == 'wikitext') {
                $text = self::_editUnescape($text, $postmode);
                $text = self::renderWikiText($text);
//              $text = self::_htmLawed($text, 'story.edit');
            }

            $text = COM_checkWords($text);
        }

        $text = PLG_replaceTags(self::_displayEscape($text));

        return $text;
    }

    /**
     * Apply HTML filter to the text
     *
     * @param   string  $text         Text to prepare for store to databese
     * @param   string  $postmode     Indicates if text is html, adveditor, wikitext or plaintext
     * @param   string  $permissions  comma-separated list of rights which identify the current user as an "Admin"
     * @param   int     $version      version of GLText engine
     * @return  string  Escaped String
     * @access  public
     *
     */
    public static function applyHTMLFilter($text, $postmode, $permissions, $version)
    {
        global $_CONF;

        if (($version != GLTEXT_FIRST_VERSION) &&
            ($postmode == 'html' || $postmode == 'adveditor')) {

            if (!SEC_hasRights('htmlfilter.skip') &&
                (($_CONF['skip_html_filter_for_root'] != 1) || !SEC_inGroup('Root'))) {

                $text = self::_handleSpecialTag_callback($text,
                    array('[code]', '[/code]', '[code2]', '[/code2]'),
                    '_maskCode');
                $text = self::_handleSpecialTag_callback($text,
                    array('[raw]', '[/raw]', '[raw2]', '[/raw2]'),
                    '_maskCode');

                $text = self::_htmLawed($text, $permissions);

                $text = self::_handleSpecialTag_callback($text,
                    array('[code2]', '[/code2]', '[code]', '[/code]'),
                    '_unmaskCode');
                $text = self::_handleSpecialTag_callback($text,
                    array('[raw2]', '[/raw2]', '[raw]', '[/raw]'),
                    '_unmaskCode');
            }
        }

        return $text;
    }

    /**
     * Returns text ready for preview.
     *
     * @param   string  $text         Text to prepare for store to databese
     * @param   string  $postmode     Indicates if text is html, adveditor, wikitext or plaintext
     * @param   string  $permissions  comma-separated list of rights which identify the current user as an "Admin"
     * @param   int     $version      version of GLText engine
     * @return  string  Escaped String
     * @access  public
     *
     */
    public static function getPreviewText($text, $postmode, $permissions, $version)
    {
        $text = self::applyHTMLFilter($text, $postmode, $permissions, $version);
        $text = self::getDisplayText($text, $postmode, $version);

        return $text;
    }

    /**
     * This function checks html tags.
     *
     * Checks to see that the HTML tags are on the approved list and
     * removes them if not.
     *
     * @param   string  $str          HTML to check
     * @param   string  $permissions  comma-separated list of rights which identify the current user as an "Admin"
     * @return  string  Filtered HTML
     * @access  public
     *
     */
    public static function checkHTML($str, $permissions = 'story.edit')
    {
        global $_CONF, $_USER;

//        $str = COM_stripslashes($str); // it should not be here

        // Get rid of any newline characters
        $str = str_replace("\n", '', $str);

        $str = self::_handleSpecialTag_callback($str,
            array('[code]', '[/code]', '<pre><code>', '</code></pre>'),
            '_escapeSPChars');
        $str = self::_handleSpecialTag_callback($str,
            array('[raw]', '[/raw]', '[raw2]', '[/raw2]'),
            '_escapeSPChars');

        // To begin with, why handle '$' and '\' as the special character?
        //
        // // replace any \ with &#092; (HTML equiv)
        // $str = str_replace('\\', '&#92;', $str);
        //
        // // Replace any $ with &#36; (HTML equiv)
        // $str = str_replace( '$', '&#36;', $str);

        if (!SEC_hasRights('htmlfilter.skip') &&
            (($_CONF['skip_html_filter_for_root'] != 1) || !SEC_inGroup('Root'))) {
            $str = self::_htmLawed($str, $permissions);
        }

        // Replace [raw][/raw] with <!--raw--><!--/raw-->, note done "late" because
        // of the above noted // strip_tags() gets confused by HTML comments ...
        $str = str_replace('[raw2]', '<!--raw--><span class="raw">', $str);
        $str = str_replace('[/raw2]', '</span><!--/raw-->', $str);

        return $str;
    }

    /**
    * Convert wiki-formatted text to (X)HTML
    *
    * @param    string  $wikitext   wiki-formatted text
    * @return   string              XHTML formatted text
    *
    */
    public static function renderWikiText($wikitext)
    {
        global $_CONF;

        if (!$_CONF['wikitext_editor']) {
            return $wikitext;
        }

        require_once 'Text/Wiki.php';

        $wiki = new Text_Wiki();
        $wiki->setFormatConf('Xhtml', 'translate', HTML_SPECIALCHARS);
        $wiki->setRenderConf('Xhtml', 'charset', COM_getCharset());
        $wiki->disableRule('wikilink');
        $wiki->disableRule('freelink');
        $wiki->disableRule('interwiki');

        return $wiki->transform($wikitext, 'Xhtml');
    }

    // Private Methods:

    private static function _htmLawed($str, $permissions)
    {
        global $_CONF, $_USER;

        require_once $_CONF['path_system'] . 'classes/htmlawed/htmLawed.php';

        // Sets config options for htmLawed.  See http://www.bioinformatics.org/
        // phplabware/internal_utilities/htmLawed/htmLawed_README.htm
        $config = array(
            'balance'        => 1, // Balance tags for well-formedness and proper nesting
            'comment'        => 3, // Allow HTML comment
            'css_expression' => 1, // Allow dynamic CSS expression in "style" attributes
//            'keep_bad'       => 1, // Neutralize both tags and element content
            'keep_bad'       => 0, // Neutralize both tags and element content
            'tidy'           => 0, // Don't beautify or compact HTML code
            'unique_ids'     => 1, // Remove duplicate and/or invalid ids
            'valid_xhtml'    => 1, // Magic parameter to make input the most valid XHTML
        );

        if (isset($_CONF['allowed_protocols']) &&
                is_array($_CONF['allowed_protocols']) &&
                (count($_CONF['allowed_protocols']) > 0)) {
            $schemes = $_CONF['allowed_protocols'];
        } else {
            $schemes = array('http:', 'https:', 'ftp:');
        }

        $schemes = str_replace(':', '', implode(', ', $schemes));
        $config['schemes'] = 'href: ' . $schemes . '; *: ' . $schemes;

        if (empty($permissions) || !SEC_hasRights($permissions) ||
                empty($_CONF['admin_html'])) {
            $html = $_CONF['user_html'];
        } else {
            if ($_CONF['advanced_editor'] && $_USER['advanced_editor']) {
                $html = array_merge_recursive($_CONF['user_html'],
                                              $_CONF['admin_html'],
                                              $_CONF['advanced_html']);
            } else {
                $html = array_merge_recursive($_CONF['user_html'],
                                              $_CONF['admin_html']);
            }
        }

        foreach ($html as $tag => $attr) {
            if (is_array($attr) && (count($attr) > 0)) {
                $spec[] = $tag . '=' . implode(', ', array_keys($attr));
            } else {
                $spec[] = $tag . '=-*';
            }

            $elements[] = $tag;
        }

        $config['elements'] = implode(', ', $elements);
        $spec = implode('; ', $spec);
        $str = htmLawed($str, $config, $spec);

        return $str;
    }

    /**
     * Escapes certain HTML for nicely encoded HTML.
     *
     * @param   string  $text  Text to escpae
     * @return  string  Escaped string
     * @access  private
     *
     */
    private static function _displayEscape($text)
    {
        return str_replace(
            array('$',     '{',      '}',      '\\'),
            array('&#36;', '&#123;', '&#125;', '&#92;'), $text);
    }

    /**
     * Unescapes certain HTML for editing again.
     *
     * @param   string  $in        Text escaped to unescape for editing
     * @param   string  $postmode  Indicates if text is html, wikitext or plaintext
     * @return  string  Unescaped string
     * @access  private
     *
     */
    private static function _editUnescape($in, $postmode)
    {
        if (!in_array($postmode, array('html', 'wikitext'))) {
            // advanced editor or plaintext can handle themselves...
            return $in;
        }

        // To begin with, why handle '$' and '\' as the special character?
        //
        // // replace any &#092; with \ (see checkHTML)
        // $in = str_replace('&#92;', '\\', $in);
        //
        // // Replace any &#36; with $ (see checkHTML)
        // $in = str_replace('&#36;', '$', $in);

        // Raw and code blocks need entity decoding. Other areas do not.
        // otherwise, annoyingly, &lt; will end up as < on preview 1, on
        // preview 2 it'll be stripped by KSES. Can't beleive I missed that
        // in rewrite phase 1.
        //
        // First, raw
        $in = self::_unescapeSpecialTag($in, array('[raw]',  '[/raw]'));
        // Then, code
        $in = self::_unescapeSpecialTag($in, array('[code]', '[/code]'));

        return $in;
    }

    /**
     * Callback funtion for escapes all special characters within a 
     * [code] ... [/code] section.
     *
     * @param   string  $str  the code section to encode
     * @return  string  String with the special characters encoded
     * @access  private
     *
     */
    private static function _escapeSPChars($str)
    {
        $search  = array('&',     '<',    '>',    '[',     ']'    );
        $replace = array('&amp;', '&lt;', '&gt;', '&#91;', '&#93;');
        $str = str_replace($search, $replace, $str);

        return $str;
    }

    /**
     * Callback funtion for mask text within a [code] ... [/code] section.
     *
     * @param   string  $str  the code section to mask
     * @return  string  String with characters encoded
     * @access  private
     *
     */
    private static function _maskCode($str)
    {
        return rawurlencode($str);
    }

    /**
     * Callback funtion for unmask text within a [code] ... [/code] section.
     *
     * @param   string  $str  the code section to unmask
     * @return  string  String with characters decoded
     * @access  private
     *
     */
    private static function _unmaskCode($str)
    {
        return rawurldecode($str);
    }

    private static function _handleSpecialTag_callback($str, $tags, $args)
    {
        if (is_array($args)) {
            $function = array_shift($args);
        } else {
            $function = $args;
        }

        // handle [code] ... [/code] or [raw] ... [/raw]
        do {
            $start_pos = MBYTE_strpos(MBYTE_strtolower($str), $tags[0]);
            if ($start_pos !== false) {
                $len_start = strlen($tags[0]);
                $end_pos = MBYTE_strpos(MBYTE_strtolower($str), $tags[1]);
                if ($end_pos !== false) {
                    $len_end = strlen($tags[1]);

                    $part = MBYTE_substr($str, $start_pos + $len_start,
                        $end_pos - ($start_pos + $len_start));
                    if (is_array($args)) {
                        $encoded = self::$function($part, $args);
                    } else {
                        $encoded = self::$function($part);
                    }

                    $encoded = $tags[2] . $encoded . $tags[3];
                    $str = MBYTE_substr($str, 0, $start_pos) . $encoded
                         . MBYTE_substr($str, $end_pos + $len_end);

                } else { // missing [/code] or [/raw]

                    $part = MBYTE_substr($str, $start_pos + $len_start);
                    if (is_array($args)) {
                        $encoded = self::$function($part, $args);
                    } else {
                        $encoded = self::$function($part);
                    }

                    $encoded = $tags[2] . $encoded . $tags[3];
                    $str = MBYTE_substr($str, 0, $start_pos) . $encoded;
                }
            }
        } while ($start_pos !== false);

        return $str;
    }

    private static function _unescapeSpecialTag($in, $tags)
    {
        $inlower = MBYTE_strtolower($in);
        $start_pos = MBYTE_strpos($inlower, $tags[0]);
        if ($start_pos === false) return $in;
        $buffer = $in;
        $out = '';
        while ($start_pos !== false) {
            // Copy in to start to out
            $out .= MBYTE_substr($buffer, 0, $start_pos);
            // Find end
            $end_pos = MBYTE_strpos($inlower, $tags[1]);
            if ($end_pos !== false) {
                // Encode body and append to out
                $encoded = html_entity_decode(
                    MBYTE_substr($buffer, $start_pos, $end_pos - $start_pos));
                $out .= $encoded . $tags[1];
                $len_end = strlen($tags[1]);
                // Nibble in
                $inlower = MBYTE_substr($inlower, $end_pos + $len_end);
                $buffer  = MBYTE_substr($buffer,  $end_pos + $len_end);
            } else { // missing end
                $len_start = strlen($tags[0]);
                // Treat the remainder as code, but this should have been
                // checked prior to calling:
                $out .= html_entity_decode(
                    MBYTE_substr($buffer, $start_pos + $len_start));
                $inlower = '';
            }
            $start_pos = MBYTE_strpos($inlower, $tags[0]);
        }
        // Append remainder:
        if ($buffer != '') {
            $out .= $buffer;
        }

        return $out;
    }
}

?>
