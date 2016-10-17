<?php

namespace Geeklog\Text\Wiki;

/**
 * Anchor rule end renderer for Xhtml
 * PHP versions 4 and 5
 *
 * @category   Text
 * @package    Text_Wiki
 * @author     Paul M. Jones <pmjones@php.net>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Anchor.php 206940 2006-02-10 23:07:03Z toggg $
 * @link       http://pear.php.net/package/Text_Wiki
 */

/**
 * This class renders an anchor target name in XHTML.
 *
 * @category   Text
 * @package    Text_Wiki
 * @author     Paul M. Jones <pmjones@php.net>
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: @package_version@
 * @link       http://pear.php.net/package/Text_Wiki
 */
class Text_Wiki_Render_Xhtml_Anchor extends Text_Wiki_Render
{
    public $conf = array(
        'css' => null,
    );

    public function token($options)
    {
        $type = '';
        $name = '';
        extract($options); // $type, $name

        if ($type === 'start') {
            $css = $this->formatConf(' class="%s"', 'css');
            $format = "<a$css id=\"%s\">";

            return sprintf($format, $this->textEncode($name));
        }

        if ($type === 'end') {
            return '</a>';
        }

        return null;
    }
}
