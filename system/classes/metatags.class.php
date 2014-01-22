<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.1                                                               |
// +---------------------------------------------------------------------------+
// | metatags.class.php                                                        |
// |                                                                           |
// | This file deals with HTML <meta> tags.                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2014 by the following authors:                              |
// |                                                                           |
// | Authors: Kenji ITO        - mystralkk AT gmail DOT com                    |
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

if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}

class Metatags
{
    const LF = "\n";

    private $logPath;
    private $charset;
    private $htmlVersion;
    private $isXhtml;
    private $tags;

    /**
    * Constructor
    *
    * @param    string     $charset        the character set of meta tags
    * @param    int        $htmlVersion    HTML version
    * @param    boolean    $isXhtml        true = XHTML, false = HTML
    */
    public function __construct($charset = 'utf-8', $htmlVersion = 4, $isXhtml = false)
    {
        $this->logPath = '';
        $this->setCharset($charset)
             ->setHtmlVersion($htmlVersion)
             ->setXhtml($isXhtml);

        $this->tags = array();

        // This property has the following key/values:
# 		'charset'					// New in HTML5
# 		'name/*
# 		'http-equiv/content-type'
# 		'http-equiv/default-style'
# 		'http-equiv/refresh'
# 		'scheme'					// Not supported in HTML5
#		'others'
    }

    /**
    * Sets the character set of meta tags
    *
    * @param     string    $charset
    * @return    $this
    */
    protected function setCharset($charset)
    {
        $charset = trim($charset);

        if ($charset === '') {
            $charset = 'utf-8';
        }

        $this->charset = $charset;

        return $this;
    }

    /**
    * Sets the version of HTML of meta tags
    *
    * @param     int      $version
    * @return    $this
    */
    protected function setHtmlVersion($version)
    {
        $this->htmlVersion = (int) floor(floatval($version));

        return $this;
    }

    /**
    * Sets if meta tags is written in XHTML
    *
    * @param     boolean    $isXhtml
    * @return    $this
    */
    protected function setXhtml($isXhtml)
    {
        $this->isXhtml = (boolean) $isXhtml;

        return $this;
    }

    /**
    * Writes an entery into a log file
    *
    * @param     string       $entry
    * @return    $this
    * @throws    Exception
    */
    protected function log($entry)
    {
        if ($this->logPath !== '') {
            $entry = date('[Y-m-d H:i:s] ') . $entry . PHP_EOL;
            if (@file_put_contents($this->logPath, $entry, FILE_APPEND) === false) {
                throw new Exception(__METHOD__ . ': cannot save into log file');
            }
        }

        return $this;
    }

    /**
    * Sets the path to a log file
    *
    * @param     string       $path
    * @return    $this
    * @throws    Exception
    */
    public function setLog($path)
    {
        clearstatcache();

        if (file_exists($path) && is_file($path) && is_writable($path)) {
            $this->logPath = $path;
        } else {
            throw new Exception(__METHOD__ . ': $path is not valid');
        }

        return $this;
    }

    /**
    * Returns if an attribute is one of HTML global attributes
    *
    * @param     string     $attr
    * @return    boolean
    */
    protected function isHtmlGlobalAttribute($attr)
    {
        $htmlGlobalAttributes4 = array(
            'accesskey', 'class', 'dir', 'id', 'lang', 'style', 'tabindex',
            'title',
        );

        $htmlGlobalAttributes5 = array(
            'contenteditable', 'draggable', 'dropzone', 'hidden',
            'spellcheck', 'translate',
        );	// plus 'data-*'

        if (in_array($attr, $htmlGlobalAttributes4)) {
            return true;
        } else if ($this->htmlVersion < 5) {
            $this->log(__METHOD__ . ': invalid HTML global attribute "' . $attr . '" detected');
            return false;
        } else {
            if (in_array($attr, $htmlGlobalAttributes5) || (strpos($attr, 'data-') === 0)) {
                return true;
            } else {
                $this->log(__METHOD__ . ': invalid HTML global attribute "' . $attr . '" detected');
                return false;
            }
        }
    }

    /**
    * Normalizes an attribute
    *
    * @param     string    $attr
    * @return    string
    */
    protected function normalizeAttribute($attr)
    {
        $attr = strtolower($attr);
        $attr = preg_replace('/[^a-z\-]/', '', $attr);

        return $attr;
    }

    /**
    * Processes a value
    *
    * @param     string    $value
    * @return    string
    */
    protected function processValue($value)
    {
        $value = preg_replace('/[[:cntrl:]]/', ' ', $value);
        $value = strip_tags($value);
        $value = trim($value);
        $value = preg_replace('/\s\s+/', ' ', $value);

        if ($this->htmlVersion == 4) {
            $value = htmlspecialchars($value, ENT_COMPAT | ENT_HTML401, $this->charset);
        } else {
            $value = htmlspecialchars($value, ENT_COMPAT | ENT_HTML5, $this->charset);
        }

        return $value;
    }

    /**
    * Adds a meta tag
    *
    * @param    array    $pairs    For example, if you want to add
	*                              <meta name="description" content="SOME CONTENT">,
	*                              specifify array('name' => 'description',
    *                              'content' => 'SOME CONTENT').  This method can
	*                              be called many times, but values specified later
	*                              will overwrite the previous ones if they are the
	*                              same meta tag.
    * @return   boolean            true = valid tag, false = otherwise
    */
    public function addTag(array $pairs)
    {
        if (count($pairs) === 0) {
            return false;
        }

        $validAttributes      = array('http-equiv', 'name', 'content');
        $validHttpEquivValues = array('content-type', 'default-style', 'refresh');

        if ($this->htmlVersion == 4) {
            $validAttributes[] = 'scheme';
        } else if ($this->htmlVersion == 5) {
            $validAttributes[] = 'charset';
        }

        $attr    = '';
        $value   = '';
        $content = '';
        $others  = array();

        foreach ($pairs as $k => $v) {
            $k = $this->normalizeAttribute($k);
            $v = $this->processValue($v);

            if (in_array($k, $validAttributes)) {
                if (($k !== 'content') && ($attr !== '')) {
                    $this->log(__METHOD__ . ': duplicate attribute "' . $k . '" detected');
                    return false;	// Duplicate attribute
                }

                switch ($k) {
                    case 'name':
                        $attr  = $k;
                        $value = $v;
                        break;

                    case 'http-equiv':
                        if (in_array(strtolower($v), $validHttpEquivValues)) {
                            $attr  = $k;
                            $value = strtolower($v);
                        } else {
                            $this->log(__METHOD__ . ': invalid http-equiv value "' . $v . '" detected');
                            return false;
                        }

                        break;

                    case 'content':
                        if ($content === '') {
                            $content = $v;
                        } else {
                            $this->log(__METHOD__ . ': duplicate "content" attribute detected');
                            return false;	// Duplicate content
                        }

                        break;
                }
            } else if ($this->isHtmlGlobalAttribute($k)) {
                $others[$k] = $v;
            } else {
                // Invalid attribute
                $this->log(__METHOD__ . ': invalid attribute "' . $k . '" detected');
                return false;
            }
        }

        $tag = '<meta ';

        if (($attr === 'name') || ($attr === 'http-equiv')) {
            if ($content !== '') {
                $tag .= $attr . '="' . $value . '" content="' . $content . '"';
            } else {
                $this->log(__METHOD__ . ': required "content" attribute is missing');
                return false;
            }
        } else if (($attr === 'charset') || ($attr === 'scheme')) {
            if ($content === '') {
                $tag .= $attr . '="' . $value . '"';
            } else {
                $this->log(__METHOD__ . ': an extra "content" attribute detected');
                return false;
            }
        } else {
            // Lacks required attributes
            $this->log(__METHOD__ . ': required attribute missing');
            return false;
        }

        if (count($others) > 0) {
            foreach ($others as $k => $v) {
                $tag .= ' ' . $k . '="' . $v . '"';
            }
        }

        if ($this->isXhtml) {
            $tag .= ' />';
        } else {
            $tag .= '>';
        }

        // Duplicate attributes will be overwritten
        if (($attr === 'charset') || ($attr === 'scheme')) {
            $this->tags[$attr] = $tag;
        } else {
            $this->tags[$attr . '/' . $value] = $tag;
        }

        return true;
    }

    /**
    * Renders meta tags
    *
    * @return    string
    */
    public function build()
    {
        return implode(self::LF, $this->tags) . self::LF;
    }
}
