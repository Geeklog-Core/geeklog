<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | gltext.class.php                                                          |
// |                                                                           |
// | Geeklog Text Abstraction.                                                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2006-2019 by the following authors:                         |
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

require_once __DIR__ . '/htmLawed/htmLawed.php';

/**
 * Constants for GLText
 * Version of GLText engine
 */
define('GLTEXT_FIRST_VERSION', 1);
define('GLTEXT_LATEST_VERSION', 2);

class GLText
{
    // Temporary markers to process JavaScript
    const SCRIPT_MARKER = '__SCRIPT_%s_MARKER__';

    /**
     * Returns text ready for the edit fields.
     *
     * @param   string $text     Text to prepare for editing
     * @param   string $postMode Indicates if text is html, wikitext or plaintext
     * @param   int    $version  version of GLText engine
     * @return  string  Escaped String
     * @access  public
     */
    public static function getEditText($text, $postMode, $version)
    {
        if ($version == GLTEXT_FIRST_VERSION) {
            // first version

            // Remove any autotags the user doesn't have permission to use
            $text = PLG_replaceTags($text, '', true);

            if ($postMode === 'plaintext') {
                $text = COM_undoClickableLinks($text);
            } elseif ($postMode === 'wikitext') {
                $text = self::_editUnescape($text, $postMode);
            } else {
                // html
                $text = str_replace('<pre><code>', '[code]', $text);
                $text = str_replace('</code></pre>', '[/code]', $text);
                $text = str_replace('<!--raw--><span class="raw">', '[raw]', $text);
                $text = str_replace('</span><!--/raw-->', '[/raw]', $text);
                $text = self::_editUnescape($text, $postMode);
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
     * @param   string  $text      Text to prepare for display
     * @param   string  $postMode  Indicates if text is html, adveditor, wikitext or plaintext
     * @param   int     $version   Version of GLText engine
     * @param   string  $type      Content type
     * @param   string  $id        Content Id
     * @return  string             Escaped String
     */
    public static function getDisplayText($text, $postMode, $version, $type = NULL, $id = NULL)
    {
        if ($version == GLTEXT_FIRST_VERSION) {
            // first version
            if ($postMode === 'plaintext') {
                $text = COM_nl2br($text);
            }

            if ($postMode === 'wikitext') {
                $text = self::_editUnescape($text, $postMode);
                $text = self::renderWikiText($text);
            }
        } else {
            // latest version
            if ($postMode === 'html' || $postMode === 'adveditor') {
                // Get rid of any newline characters
                $text = str_replace("\n", '', $text);

                $text = self::_handleSpecialTag_callback(
                    $text,
                    array('[code]', '[/code]', '<pre><code>', '</code></pre>'),
                    '_escapeSPChars'
                );

                $text = self::_handleSpecialTag_callback(
                    $text,
                    array('[raw]', '[/raw]', '<!--raw--><span class="raw">', '</span><!--/raw-->'),
                    '_escapeSPChars'
                );
            }

            if ($postMode === 'plaintext') {
                $text = htmlspecialchars($text, ENT_QUOTES, COM_getEncodingt());
                $text = COM_makeClickableLinks($text);
                $text = COM_nl2br($text);
            }

            if ($postMode === 'wikitext') {
                $text = self::_editUnescape($text, $postMode);
                $text = self::renderWikiText($text);
                //              $text = self::_htmLawed($text, 'story.edit');
            }

            $text = COM_checkWords($text, 'story');
        }

        if (isset($type, $id)) {
            $text = PLG_replaceTags(self::_displayEscape($text), '', false, $type, $id);
        } else {
            $text = PLG_replaceTags(self::_displayEscape($text));
        }

        return $text;
    }

    /**
     * Apply HTML filter to the text
     *
     * @param   string $text        Text to prepare for store to database
     * @param   string $postMode    Indicates if text is html, adveditor, wikitext or plaintext
     * @param   string $permissions comma-separated list of rights which identify the current user as an "Admin"
     * @param   int    $version     version of GLText engine
     * @return  string  Escaped String
     * @access  public
     */
    public static function applyHTMLFilter($text, $postMode, $permissions, $version)
    {
        global $_CONF;

        if (($version != GLTEXT_FIRST_VERSION) &&
            ($postMode === 'html' || $postMode === 'adveditor')
        ) {
            if (!SEC_hasRights('htmlfilter.skip') &&
                (($_CONF['skip_html_filter_for_root'] != 1) || !SEC_inGroup('Root'))
            ) {
                $text = self::_handleSpecialTag_callback(
                    $text,
                    array('[code]', '[/code]', '[code2]', '[/code2]'),
                    '_maskCode'
                );
                $text = self::_handleSpecialTag_callback(
                    $text,
                    array('[raw]', '[/raw]', '[raw2]', '[/raw2]'),
                    '_maskCode'
                );

                $text = self::_htmLawed($text, $permissions);

                $text = self::_handleSpecialTag_callback(
                    $text,
                    array('[code2]', '[/code2]', '[code]', '[/code]'),
                    '_unmaskCode'
                );
                $text = self::_handleSpecialTag_callback(
                    $text,
                    array('[raw2]', '[/raw2]', '[raw]', '[/raw]'),
                    '_unmaskCode'
                );
            }
        }

        return $text;
    }

    /**
     * Returns text ready for preview.
     *
     * @param   string $text        Text to prepare for store to database
     * @param   string $postMode    Indicates if text is html, adveditor, wikitext or plaintext
     * @param   string $permissions comma-separated list of rights which identify the current user as an "Admin"
     * @param   int    $version     version of GLText engine
     * @return  string  Escaped String
     * @access  public
     */
    public static function getPreviewText($text, $postMode, $permissions, $version, $type = NULL, $id = NULL)
    {
        $text = self::applyHTMLFilter($text, $postMode, $permissions, $version);
        $text = self::getDisplayText($text, $postMode, $version, $type, $id);

        return $text;
    }

    /**
     * This function checks html tags.
     * Checks to see that the HTML tags are on the approved list and
     * removes them if not.
     *
     * @param   string $str         HTML to check
     * @param   string $permissions comma-separated list of rights which identify the current user as an "Admin"
     * @return  string  Filtered HTML
     * @access  public
     */
    public static function checkHTML($str, $permissions = 'story.edit')
    {
        global $_CONF;

        //        $str = COM_stripslashes($str); // it should not be here

        // Get rid of any newline characters
        $str = str_replace("\n", '', $str);

        $str = self::_handleSpecialTag_callback(
            $str,
            array('[code]', '[/code]', '<pre><code>', '</code></pre>'),
            '_escapeSPChars'
        );
        $str = self::_handleSpecialTag_callback(
            $str,
            array('[raw]', '[/raw]', '[raw2]', '[/raw2]'),
            '_escapeSPChars'
        );

        // To begin with, why handle '$' and '\' as the special character?
        //
        // // replace any \ with &#092; (HTML equiv)
        // $str = str_replace('\\', '&#92;', $str);
        //
        // // Replace any $ with &#36; (HTML equiv)
        // $str = str_replace( '$', '&#36;', $str);

        if (!SEC_hasRights('htmlfilter.skip') &&
            (($_CONF['skip_html_filter_for_root'] != 1) || !SEC_inGroup('Root'))
        ) {
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
     * @param    string $wikiText wiki-formatted text
     * @return   string              XHTML formatted text
     */
    public static function renderWikiText($wikiText)
    {
        global $_CONF;

        if (!$_CONF['wikitext_editor']) {
            return $wikiText;
        }

        $wiki = new Geeklog\Text\Wiki();
        $wiki->setFormatConf('Xhtml', 'translate', HTML_SPECIALCHARS);
        $wiki->setRenderConf('Xhtml', 'charset', COM_getCharset());
        $wiki->disableRule('wikilink');
        $wiki->disableRule('freelink');
        $wiki->disableRule('interwiki');

        return $wiki->transform($wikiText, 'Xhtml');
    }

    /**
     * Remove all HTML tags and attributes
     *
     * @param  string  $text
     * @return string
     */
    public static function removeAllHTMLTagsAndAttributes($text)
    {
        // Use htmLawed to remove all HTML tags
        // http://www.bioinformatics.org/phplabware/forum/viewtopic.php?id=88
        $config = [
            'elements' => '-*',
            'keep_bad' => 0,
        ];
        $text = htmLawed($text, $config);

        return $text;
    }

    private static function _htmLawed($str, $permissions)
    {
        global $_CONF, $_USER;

        // Sets config options for htmLawed.
        // See http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/htmLawed_README.htm
        $config = array(
            'abs_url'            => 0, // No action
            'anti_link_spam'     => 0, // No measure taken
            'anti_mail_spam'     => 0, // No measure taken
            'balance'            => 1, // Balance tags for well-formedness and proper nesting
            'cdata'              => 3, // Allow CDATA sections
            'clean_ms_char'      => 0, // Don't replace discouraged characters introduced by Microsoft Word, etc.
            'comment'            => 3, // Allow HTML comment
            'css_expression'     => 1, // Allow dynamic CSS expression in "style" attributes
            'deny_attribute'     => 0, // No denied HTML attributes
            'direct_nest_list'   => 0, // Don' allow direct nesting of a list within another without requiring it to be a list item
            'hexdec_entity'      => 1, // Allow hexadecimal numeric entities
            'hook'               => 0, // No hook function
            'hook_tag'           => 0, // No hook function
            'keep_bad'           => 1, // Neutralize both tags and element content
            'lc_std_val'         => 1, // Yes
            'make_tag_strict'    => 0, // No
            'named_entity'       => 1, // Allow non-universal named HTML entities
            'no_deprecated_attr' => 1, // Transform deprecated attributes, but name attributes for a and map are retained
            'safe'               => 0, // No
            'style_pass'         => 0, // Don't ignore style attribute values
            'tidy'               => 0, // Don't beautify or compact HTML code
            'unique_ids'         => 1, // Remove duplicate and/or invalid ids
            'valid_xhtml'        => 1, // Magic parameter to make input the most valid XHTML
            'xml:lang'           => 0, // Don't auto-add xml:lang attribute
        );

        if (isset($_CONF['allowed_protocols']) && is_array($_CONF['allowed_protocols']) &&
            (count($_CONF['allowed_protocols']) > 0)
        ) {
            $schemes = $_CONF['allowed_protocols'];
        } else {
            $schemes = array('http:', 'https:', 'ftp:', 'ftps:');
        }

        $schemes = str_replace(':', '', implode(', ', $schemes));
        $config['schemes'] = 'href: ' . $schemes . '; *: ' . $schemes;

        if (empty($permissions) || !SEC_hasRights($permissions) || empty($_CONF['admin_html'])) {
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

        $spec = array();
        $elements = array();

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
     * @param   string $text Text to escape
     * @return  string  Escaped string
     * @access  private
     */
    private static function _displayEscape($text)
    {
        return str_replace(
            array('$', '{', '}', '\\'),
            array('&#36;', '&#123;', '&#125;', '&#92;'),
            $text
        );
    }

    /**
     * Unescape certain HTML for editing again.
     *
     * @param   string $in       Text escaped to unescape for editing
     * @param   string $postMode Indicates if text is html, wikitext or plaintext
     * @return  string  Unescaped string
     * @access  private
     */
    private static function _editUnescape($in, $postMode)
    {
        if (!in_array($postMode, array('html', 'wikitext'))) {
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
        // preview 2 it'll be stripped by KSES. Can't believe I missed that
        // in rewrite phase 1.
        //
        // First, raw
        $in = self::_unescapeSpecialTag($in, array('[raw]', '[/raw]'));
        // Then, code
        $in = self::_unescapeSpecialTag($in, array('[code]', '[/code]'));

        return $in;
    }

    /**
     * Callback function for escapes all special characters within a
     * [code] ... [/code] section.
     *
     * @param   string $str the code section to encode
     * @return  string  String with the special characters encoded
     * @access  private
     */
    private static function _escapeSPChars($str)
    {
        $search = array('&', '<', '>', '[', ']');
        $replace = array('&amp;', '&lt;', '&gt;', '&#91;', '&#93;');
        $str = str_replace($search, $replace, $str);

        return $str;
    }

    /**
     * Callback function for mask text within a [code] ... [/code] section.
     *
     * @param   string $str the code section to mask
     * @return  string  String with characters encoded
     * @access  private
     */
    private static function _maskCode($str)
    {
        return rawurlencode($str);
    }

    /**
     * Callback function for unmask text within a [code] ... [/code] section.
     *
     * @param   string $str the code section to unmask
     * @return  string  String with characters decoded
     * @access  private
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
        $inLower = MBYTE_strtolower($in);
        $start_pos = MBYTE_strpos($inLower, $tags[0]);

        if ($start_pos === false) {
            return $in;
        }

        $buffer = $in;
        $out = '';

        while ($start_pos !== false) {
            // Copy in to start to out
            $out .= MBYTE_substr($buffer, 0, $start_pos);
            // Find end
            $end_pos = MBYTE_strpos($inLower, $tags[1]);
            if ($end_pos !== false) {
                // Encode body and append to out
                $encoded = html_entity_decode(
                    MBYTE_substr($buffer, $start_pos, $end_pos - $start_pos)
                );
                $out .= $encoded . $tags[1];
                $len_end = strlen($tags[1]);
                // Nibble in
                $inLower = MBYTE_substr($inLower, $end_pos + $len_end);
                $buffer = MBYTE_substr($buffer, $end_pos + $len_end);
            } else { // missing end
                $len_start = strlen($tags[0]);
                // Treat the remainder as code, but this should have been
                // checked prior to calling:
                $out .= html_entity_decode(
                    MBYTE_substr($buffer, $start_pos + $len_start)
                );
                $inLower = '';
            }
            $start_pos = MBYTE_strpos($inLower, $tags[0]);
        }
        // Append remainder:
        if ($buffer != '') {
            $out .= $buffer;
        }

        return $out;
    }

    /**
     * Remove 4-6 byte UTF-8 characters, including emoji icons used on mobile phones
     *
     * @param  string $text
     * @param  string $replace
     * @return string
     */
    public static function remove4byteUtf8Chars($text, $replace = '')
    {
        global $_CONF, $_DB_dbms;
        static $isRemove = null;

        if ($isRemove === null) {
            if (!isset($_CONF['remove_4byte_chars']) || $_CONF['remove_4byte_chars']) {
                $isRemove = true;
            } else {
                // in case $_CONF['remove_4byte_chars'] is set to false
                if (strcasecmp($_DB_dbms, 'mysql') === 0) {
                    $isRemove = version_compare('5.5.3', DB_getVersion(), '>');
                } else {
                    $isRemove = false;
                }
            }
        }

        if ($isRemove) {
            $text = preg_replace('/[\xf0-\xfd][\x80-\xbf]{2}[\x80-\xbf]{1,3}/', $replace, $text);
        }

        return $text;
    }

    /**
     * Parse a string and replace JavaScript code with temporary markers
     *
     * @param  string $text
     * @return array        array(0 => 'modified text', 1=> array of temporary markers)
     */
    public static function protectJavascript($text)
    {
        $new_text = '';
        $markers = array();

        while ($text !== '') {
            $posStart = stripos($text, '<script');

            if ($posStart === false) {
                // There is no JavaScript left
                $new_text .= $text;
                $text = '';
            } else {
                if ($posStart > 0) {
                    $new_text .= substr($text, 0, $posStart);
                    $text = substr($text, $posStart);
                }

                $posEnd = stripos($text, '</script>');

                if ($posEnd === false) {
                    // '</script>' tag is missing
                    $posEnd = strlen($text);
                } else {
                    $posEnd += strlen('</script>');
                }

                $part = substr($text, 0, $posEnd);
                $marker = sprintf(self::SCRIPT_MARKER, self::_getUniqueStr());
                $marker = str_replace('.', '', $marker);
                $markers[] = array(
                    'text'   => $part,
                    'marker' => $marker,
                );
                $new_text .= $marker;
                $text = substr($text, $posEnd);
            }
        }

        return array($new_text, $markers);
    }

    /**
     * Parse a string and replace temporary markers with the original JavaScript code
     *
     * @param  string $text    the first element of the value returned by self::protectJavascript
     * @param  array  $markers the second element of the value returned by self::protectJavascript
     * @return string
     */
    public static function unprotectJavaScript($text, array $markers = array())
    {
        if (count($markers) > 0) {
            foreach ($markers as $marker) {
                $text = str_replace($marker['marker'], $marker['text'], $text);
            }
        }

        return $text;
    }

    /**
     * Better strip_tags
     *
     * @param  mixed  $var
     * @return string
     */
    public static function stripTags($var)
    {
        if (is_array($var)) {
            list($var, ) = $var;
        }

        $var = strip_tags($var);

        return $var;
    }

    /**
     * Generate unique string
     *
     * @param  int  $length length of string to generate
     * @return string
     */
    private static function _getUniqueStr($length = 8)
    {
        static $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, 61)];
        }
        return $str;
    }
}
