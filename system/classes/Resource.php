<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | Resource.php                                                              |
// |                                                                           |
// | Geeklog class to include javascript, javascript files and css files.      |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2017 by the following authors:                         |
// |                                                                           |
// | Authors: Tom Homer, tomhomer AT gmail DOT com                             |
// |          Kenji ITO, mystralkk AT gmail DOT com                            |
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

namespace Geeklog;

use JSMin\JSMin;
use MatthiasMullie\Minify;

class Resource
{
    const DEFAULT_CACHE_LIFESPAN = 604800; // 1 week

    const JS_TAG_TEMPLATE = '<script type="text/javascript" src="%s"></script>';
    const EXTERNAL_JS_TAG_TEMPLATE = '<script type="text/javascript" src="%s" async defer></script>';

    // Default theme
    const DEFAULT_THEME = 'denim';

    // Local library versions
    const JQUERY_VERSION = '3.2.1';
    const JQUERY_PRIORITY = -5000;

    const JQUERY_UI_VERSION = '1.12.1';
    const JQUERY_UI_THEME = 'redmond';
    const JQUERY_UI_PRIORITY = -4000;

    const UIKIT_VERSION = '2.27.2';
    const UIKIT_PRIORITY = -3000;

    const UIKIT3_VERSION = '3.0.0-beta.35';
    const UIKIT3_PRIORITY = -3000;

    /**
     * Tags for CDN
     */

    // JQuery & JQuery UI
    const JQUERY_CDN = 'https://ajax.googleapis.com/ajax/libs/jquery/%s/jquery.min.js';
    const JQUERY_UI_CDN = 'https://ajax.googleapis.com/ajax/libs/jqueryui/%s/jquery-ui.min.js';
    const JQUERY_UI_CSS_CDN = 'https://ajax.googleapis.com/ajax/libs/jqueryui/%s/themes/%s/jquery-ui.css';

    // UIkit v2
    const UIKIT_CDN = 'https://cdnjs.cloudflare.com/ajax/libs/uikit/%s/js/uikit.min.js';
    const UIKIT_CSS_CDN = 'https://cdnjs.cloudflare.com/ajax/libs/uikit/%s/css/uikit.min.css';

    // UIkit v3
    const UIKIT3_CDN = 'https://cdnjs.cloudflare.com/ajax/libs/uikit/%s/js/uikit.min.js';
    const UIKIT3_CDN2 = 'https://cdnjs.cloudflare.com/ajax/libs/uikit/%s/js/uikit-icons.min.js';
    const UIKIT3_CSS_CDN = 'https://cdnjs.cloudflare.com/ajax/libs/uikit/%s/css/uikit.min.css';

    /**
     * Debug mode
     *
     * @var bool
     */
    private $debug = false;

    /**
     * @var string either '', 'header' or 'footer'
     */
    private $jQueryPosition = '';

    /**
     * @var string either '', 'header' or 'footer'
     */
    private $jQueryUIPosition = '';

    /**
     * @var bool
     */
    private $useUIkit = false;

    /**
     * @var bool
     */
    private $useUIkit3 = false;

    /**
     * @var string
     */
    private $theme = self::DEFAULT_THEME;

    /**
     * @var array
     */
    private $libraryLocations = array(
        'jquery'                          => '/vendor/jquery/jquery.min.js',
        'jquery-ui'                       => '/vendor/jquery-ui/jquery-ui.min.js',
        'jquery-ui-i18n'                  => '/javascript/jquery_ui/jquery-ui-i18n.min.js',
        'jquery-ui-slideraccess'          => '/javascript/jquery_ui/jquery-ui-slideraccess.min.js',
        'jquery-ui-timepicker-addon'      => '/javascript/jquery_ui/jquery-ui-timepicker-addon.min.js',
        'jquery-ui-timepicker-addon-i18n' => '/javascript/jquery_ui/jquery-ui-timepicker-addon-i18n.min.js',
        'admin.configuration'             => '/javascript/admin.configuration.js',
        'admin.topic'                     => '/javascript/admin.topic.js',
        'advanced_editor'                 => '/javascript/advanced_editor.js',
        'comment'                         => '/javascript/comment.js',
        'common'                          => '/javascript/common.js',
        'datepicker'                      => '/javascript/datepicker.js',
        'datetimepicker'                  => '/javascript/datetimepicker.js',
        'dbadmin'                         => '/javascript/dbadmin.js',
        'dbbackup'                        => '/javascript/dbbackup.js',
        'dialog_help'                     => '/javascript/dialog_help.js',
        'fix_tooltip'                     => '/javascript/fix_tooltip.js',
        'login'                           => '/javascript/login.js',
        'moveuser'                        => '/javascript/moveuser.js',
        'postmode_control'                => '/javascript/postmode_control.js',
        'profile_editor'                  => '/javascript/profile_editor.js',
        'story_editor'                    => '/javascript/story_editor.js',
        'storyeditor_advanced'            => '/javascript/storyeditor_advanced.js',
        'submitcomment_adveditor'         => '/javascript/submitcomment_adveitor.js',
        'submitstory_adveditor'           => '/javascript/submitstory_adveditor',
        'title_2_id'                      => '/javascript/title_2_id.js',
        'topic_control'                   => '/javascript/topic_control.js',
        'uikit_modifier'                  => '/javascript/uikit_modifier.js',
        'uikit'                           => '/vendor/uikit/js/uikit.min.js',
        'uikit.accordion'                 => '/vendor/uikit/js/components/accordion.min.js',
        'uikit.autocomplete'              => '/vendor/uikit/js/components/autocomplete.min.js',
        'uikit.datepicker'                => '/vendor/uikit/js/components/datepicker.min.js',
        'uikit.form-password'             => '/vendor/uikit/js/components/form-password.min.js',
        'uikit.form-select'               => '/vendor/uikit/js/components/form-select.min.js',
        'uikit.grid-parallax'             => '/vendor/uikit/js/components/grid-parallax.min.js',
        'uikit.grid'                      => '/vendor/uikit/js/components/grid.min.js',
        'uikit.htmleditor'                => '/vendor/uikit/js/components/htmleditor.min.js',
        'uikit.lightbox'                  => '/vendor/uikit/js/components/lightbox.min.js',
        'uikit.nestable'                  => '/vendor/uikit/js/components/nestable.min.js',
        'uikit.notify'                    => '/vendor/uikit/js/components/notify.min.js',
        'uikit.pagination'                => '/vendor/uikit/js/components/pagination.min.js',
        'uikit.parallax'                  => '/vendor/uikit/js/components/parallax.min.js',
        'uikit.search'                    => '/vendor/uikit/js/components/search.min.js',
        'uikit.slider'                    => '/vendor/uikit/js/components/slider.min.js',
        'uikit.slideset'                  => '/vendor/uikit/js/components/slideset.min.js',
        'uikit.slideshow-fx'              => '/vendor/uikit/js/components/slideshow-fx.min.js',
        'uikit.slideshow'                 => '/vendor/uikit/js/components/slideshow.min.js',
        'uikit.sortable'                  => '/vendor/uikit/js/components/sortable.min.js',
        'uikit.sticky'                    => '/vendor/uikit/js/components/sticky.min.js',
        'uikit.timepicker'                => '/vendor/uikit/js/components/timepicker.min.js',
        'uikit.tooltip'                   => '/vendor/uikit/js/components/tooltip.min.js',
        'uikit.upload'                    => '/vendor/uikit/js/components/upload.min.js',
        'uikit3'                          => '/vendor/uikit3/js/uikit.min.js',
        'uikit3-icons'                    => '/vendor/uikit3/js/uikit-icons.min.js',
    );

    /**
     * @var array a copy of $_CONF
     */
    private $config;

    /**
     * Array of CSS code block to write between <style> and </style> tags
     *
     * @var array
     */
    private $cssBlocks = array();

    /**
     * Array of local CSS files
     *
     * @var array
     */
    private $localCssFiles = array();

    /**
     * Array of external CSS URIs
     *
     * @var array
     */
    private $externalCssFiles = array();

    /**
     * Array of JavaScript code to write between <script> and </script> tags
     *
     * @var array
     */
    private $jsBlocks = array(
        'header' => array(),
        'footer' => array(),
    );

    /**
     * Array of local JavaScript files
     *
     * @var array
     */
    private $localJsFiles = array(
        'header' => array(),
        'footer' => array(),
    );

    /**
     * Array of external JavaScript URIs
     *
     * @var array
     */
    private $externalJsFiles = array(
        'header' => array(),
        'footer' => array(),
    );

    /**
     * @var array
     */
    private $lang = array();

    /**
     * @var bool
     */
    private $isHeaderSet = false;

    /**
     * Resource constructor.
     *
     * @param  array $config
     */
    public function __construct(array $config)
    {
        if (isset($config['developer_mode'], $config['developer_mode_log']['resource']) &&
            $config['developer_mode'] &&
            $config['developer_mode_log']['resource']) {
            $this->setDebug(true);
        }

        $config['path_html'] = str_replace('\\', '/', rtrim($config['path_html'], '/\\'));
        $this->config = $config;
        $this->theme = $config['theme'];
        $this->setJavaScriptLibrary('common', false);
    }

    /**
     * Set debug mode
     *
     * @param  bool $switch
     */
    public function setDebug($switch)
    {
        $this->debug = (bool) $switch;
    }

    /**
     * Write an entry into log
     *
     * @param  string $entry
     */
    private function log($entry)
    {
        static $isErrorLogAvailable = null;

        if ($isErrorLogAvailable === null) {
            $isErrorLogAvailable = is_callable('COM_errorLog');
        }

        if ($isErrorLogAvailable) {
            COM_errorLog($entry);
        } else {
            $entry = nl2br($entry);
            @log($entry);
        }
    }

    /**
     * Return if a URI given is an external file
     *
     * @param  string $uri
     * @return bool
     */
    private function isExternal($uri)
    {
        $retval = (stripos($uri, 'http://') === 0) ||
            (stripos($uri, 'https://') === 0) ||
            (strpos($uri, '//') === 0);

        return $retval;
    }

    /**
     * Return if a path exists
     *
     * @param  string $path absolute path
     * @return bool
     */
    private function exists($path)
    {
        clearstatcache();

        return @is_file($path) && @is_readable($path);
    }

    /**
     * Check CSS attributes
     *
     * @param  array $attributes
     * @return array
     */
    private function checkCssAttributes(array $attributes)
    {
        $retval = array();

        foreach ($attributes as $key => $value) {
            $key = strtolower($key);

            switch ($key) {
                case 'rel':
                    if (!isset($retval[$key])) {
                        $value = strtolower($value);

                        if (($value === 'stylesheet') || ($value === 'alternate stylesheet')) {
                            $retval[$key] = $value;
                        }
                    }

                    break;

                case 'title':
                case 'media':
                    if (!isset($retval[$key])) {
                        $retval[$key] = $value;
                    }

                    break;
            }
        }

        if (!isset($retval['rel'])) {
            $retval['rel'] = 'stylesheet';
        }

        $retval['type'] = 'text/css';

        return $retval;
    }

    /**
     * Set JavaScript Libraries to load
     *
     * @param  string $name
     * @param  bool   $isFooter
     * @return bool
     */
    public function setJavaScriptLibrary($name, $isFooter = true)
    {
        global $LANG_DIRECTION;

        $name = strtolower($name);
        $position = $isFooter ? 'footer' : 'header';

        if (!isset($this->libraryLocations[$name])) {
            if (stripos($name, 'jquery.ui.') === 0) {
                $name = 'jquery-ui';
            } else {
                return false;
            }
        }

        switch ($name) {
            case 'jquery':
                if (!empty($this->jQueryPosition)) {
                    // Already used
                    return true;
                }

                $this->jQueryPosition = $position;

                return true;
                break;

            case 'jquery-ui':
                if (!empty($this->jQueryUIPosition)) {
                    // Already used
                    return true;
                }

                if (!$this->jQueryPosition) {
                    $this->setJavaScriptLibrary('jquery', $isFooter);
                }

                $this->jQueryUIPosition = $position;

                return true;
                break;

            case 'uikit':
                if ($this->useUIkit) {
                    // Already used
                    return true;
                }

                if (!$this->jQueryPosition) {
                    $this->setJavaScriptLibrary('jquery', false);
                }

                $this->useUIkit = true;

                return true;
                break;

            case 'uikit3':
                if ($this->useUIkit3) {
                    // Already used
                    return true;
                }

                $this->useUIkit3 = true;

                return true;
                break;

            default:
                $this->localJsFiles[$position][] = array(
                    'file'     => $this->libraryLocations[$name],
                    'priority' => 100,
                );

                // In case of a UIkit component, add a suitable CSS file
                if (strpos($name, 'uikit.') === 0) {
                    if (!$this->useUIkit) {
                        $this->setJavaScriptLibrary('uikit');
                    }

                    list (, $componentName) = explode('.', $name, 2);
                    $dir = (isset($LANG_DIRECTION) && ($LANG_DIRECTION === 'rtl')) ? 'css_rtl' : 'css';
                    $cssPath = '/vendor/uikit/' . $dir . '/components/' . $componentName . '.min.css';
                    $this->setCssFile($name, $cssPath, true, array());
                }

                break;
        }

        return false;
    }

    /**
     * Set JavaScript to load
     *
     * @param  string $code
     * @param  bool   $wrap (not used)
     * @param  bool   $isFooter
     * @return bool
     */
    public function setJavaScript($code, $wrap = false, $isFooter = true)
    {
        if ($this->isHeaderSet && !$isFooter) {
            return false;
        } else {
            if (!$wrap) {
                // Strip <script> and </script> tags
                $code = preg_replace('@<script[^>]+>@i', '', $code);
                $code = str_ireplace('</script>', '', $code);
            }

            $this->jsBlocks[$isFooter ? 'footer' : 'header'][] = $code;

            return true;
        }
    }

    /**
     * Set JavaScript file to load
     *
     * @param  string $name (not used)
     * @param  string $file relative to public_html (must start with '/')
     * @param  bool   $isFooter
     * @param  int    $priority
     * @return bool
     */
    public function setJavaScriptFile($name, $file, $isFooter = true, $priority = 100)
    {
        if ($this->isHeaderSet && !$isFooter) {
            return false;
        }

        $position = $isFooter ? 'footer' : 'header';

        if ($this->isExternal($file)) {
            $this->externalJsFiles[$position][] = array(
                'file'     => $file,
                'priority' => $priority,
            );

            return true;
        } else {
            if ($this->exists($this->config['path_html'] . $file)) {
                $this->localJsFiles[$position][] = array(
                    'file'     => $file,
                    'priority' => $priority,
                );

                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Set language variables used in JavaScript.
     *
     * @param  array $lang_array array of language variables
     * @return bool
     */
    public function setLang(array $lang_array)
    {
        $this->lang = array_merge($this->lang, $lang_array);

        return true;
    }

    /**
     * Set CSS file to load
     *
     * @param  string $name     (not used)
     * @param  string $file     relative public_html (must start with '/')
     * @param  bool   $constant (not used)
     * @param  array  $attributes
     * @param  int    $priority
     * @param  string $type     (not used)
     * @return bool
     */
    public function setCssFile($name, $file, $constant = true, $attributes = array(), $priority = 100, $type = '')
    {
        if ($this->isHeaderSet) {
            return false;
        }

        $attributes = $this->checkCssAttributes($attributes);

        if ($this->isExternal($file)) {
            $this->externalCssFiles[] = array(
                'file'       => $file,
                'attributes' => $attributes,
                'priority'   => $priority,
                'type'       => $type,
            );

            return true;
        } else {
            if ($this->exists($this->config['path_html'] . $file)) {
                $this->localCssFiles[] = array(
                    'name'       => $name,
                    'file'       => $file,
                    'attributes' => $attributes,
                    'priority'   => $priority,
                    'type'       => $type,
                );

                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Set CSS in header using style tag
     *
     * @param  string $css
     * @return bool
     */
    public function setCSS($css)
    {
        if ($this->isHeaderSet) {
            return false;
        } else {
            $this->cssBlocks[] = $css;

            return true;
        }
    }

    /**
     * Make a key for caching based on paths relative to public_html
     *
     * @param  array $relativePaths
     * @return string
     */
    private function makeCacheKey(array $relativePaths)
    {
        return md5(implode('|', $relativePaths));
    }

    /**
     * Sort criterion by priority
     *
     * @param  array $a
     * @param  array $b
     * @return int
     */
    private static function comparePriority(array $a, array $b)
    {
        if ($a['priority'] < $b['priority']) {
            return -1;
        } elseif ($a['priority'] > $b['priority']) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Return a <link> tag
     *
     * @param  string $href
     * @param  array  $attributes
     * @return string
     */
    private function buildLinkTag($href, array $attributes = array())
    {
        if (empty($attributes)) {
            $attributes['rel'] = 'stylesheet';
        }

        $retval = sprintf('<link rel="%s" href="%s"', $attributes['rel'], $href);
        unset($attributes['rel']);

        foreach ($attributes as $key => $value) {
            $key = htmlspecialchars($key, ENT_QUOTES, 'utf-8');
            $value = htmlspecialchars($value, ENT_QUOTES, 'utf-8');
            $retval .= sprintf(' %s="%s"', $key, $value);
        }

        $retval .= XHTML . '>';

        return $retval;
    }

    /**
     * Return the latest modified time of the files given
     *
     * @param  array $absolutePaths
     * @return int
     */
    private function getLatestModifiedTime(array $absolutePaths)
    {
        clearstatcache();
        $retval = time() - 3600 * 24 * 365;

        foreach ($absolutePaths as $absolutePath) {
            if ($this->exists($absolutePath)) {
                $mTime = @filemtime($absolutePath);

                if ($retval < $mTime) {
                    $retval = $mTime;
                }
            }
        }

        return $retval;
    }

    /**
     * Minify CSS
     *
     * @param  array $files
     * @return string
     * @note   Currently, this method does NOT minify CSS code
     */
    private function minifyCSS(array $files)
    {
        global $LANG_DIRECTION;

        if ($this->debug || !Cache::isEnabled()) {
            $retval = '';

            foreach ($files as $file) {
                $retval .= $this->buildLinkTag($this->config['site_url'] . $file['file'], array()) . PHP_EOL;
            }

            return $retval;
        }

        $isUseMinify = false;
        $min = new Minify\CSS();
        $contents = '';
        $relativePaths = array();

        // Concatenate all CSS files
        foreach ($files as $file) {
            if (preg_match('@min\.css$@', $file['file'])) {
                $chunk = @file_get_contents($this->config['path_html'] . $file['file']);

                if ($chunk !== false) {
                    $relativePaths[] = $file['file'];
                    $contents .= $chunk . PHP_EOL;
                }
            } else {
                $min->add($this->config['path_html'] . $file['file']);
                $isUseMinify = true;
            }
        }

        if ($isUseMinify) {
            $contents .= $min->execute($this->config['path_html']);
        }

        $theme = strtolower($this->config['theme']);

        // Replace {left} and {right} place-holders
        if (isset($LANG_DIRECTION) && ($LANG_DIRECTION === 'rtl')) {
            $dir = 'rtl';
            $left = 'right';
            $right = 'left';
        } else {
            $dir = 'ltr';
            $left = 'left';
            $right = 'right';
        }

        if ($theme === 'modern_curve') {
            $contents = str_replace(array('{left}', '{right}'), array($left, $right), $contents);
        }

        // Unify lien ends
        $contents = str_replace(array("\r\n", "\r"), "\n", $contents);

        $key = $this->makeCacheKey($relativePaths) . $dir;
        $data = array(
            'createdAt' => microtime(true),
            'data'      => $contents,
            'paths'     => $relativePaths,
            'type'      => 'c',
        );
        Cache::set($key, $data);
        $retval = $this->buildLinkTag($this->config['site_url'] . '/r.php?k=' . $key, array());

        return $retval;
    }

    /**
     * Minify file contents
     *
     * @param  array $paths array of absolute paths
     * @return string minified code
     */
    private function minifyJS(array $paths)
    {
        $retval = '';

        foreach ($paths as $path) {
            if ($this->debug) {
                $retval .= '/* ' . $path . ' */' . PHP_EOL;
            }

            if (preg_match('/[.-]min\.js$/i', $path)) {
                // Already minified
                $retval .= @file_get_contents($path) . PHP_EOL;
            } else {
                $data = @file_get_contents($path);

                if ($data !== false) {
                    $data = JSMin::minify($data);
                    $retval .= $data . PHP_EOL;
                }
            }
        }

        return $retval;
    }

    /**
     * Minify local files and build a tag to serve the data
     *
     * @param  array $files array of array('file', 'priority', 'attributes') or array('file', 'priority')
     * @param  bool  $isCss
     * @return string
     */
    private function makeFileServerTag(array $files, $isCss = true)
    {
        if ($this->debug) {
            $temp = array();
            foreach ($files as $file) {
                $temp[] = $file['file'];
            }
            $entry = __METHOD__ . ':' . PHP_EOL
                . '$files: ' . implode(', ', $temp) . PHP_EOL
                . '$isCss: ' . ($isCss ? 'true' : 'false') . PHP_EOL;
            $this->log($entry);
        }

        usort($files, array('Geeklog\\Resource', 'comparePriority'));

        if ($isCss) {
            // Make an item with 'name' property being 'theme' the top of the list to load the theme CSS first
            $temp = array();

            foreach ($files as $file) {
                if (isset($file['name']) && ($file['name'] === 'theme')) {
                    $temp = array_unshift($temp, $file);
                } else {
                    $temp[] = $file;
                }
            }

            $files = $temp;

            return $this->minifyCSS($files);
        }

        // Minify JavaScript
        $retval = '';

        // Exclude files for advanced editor, since they wouldn't work in displaced locations

        // typically, /editors/
        $editorPath = str_replace(
            $this->config['path_html'],
            '',
            str_replace('\\', '/', $this->config['path_editors'])
        );
        $temp = $files;
        $files = array();

        foreach ($temp as $file) {
            if (stripos($file['file'], $editorPath) === 0) {
                $retval .= sprintf(self::JS_TAG_TEMPLATE, $this->config['site_url'] . $file['file']) . PHP_EOL;
            } else {
                $files[] = $file;
            }
        }

        $absolutePaths = array();
        $relativePaths = array();
        $success = false;

        foreach ($files as $file) {
            $absolutePaths[] = $this->config['path_html'] . $file['file'];
            $relativePaths[] = $file['file'];
        }

        $key = $this->makeCacheKey($relativePaths);
        $cachedData = Cache::get($key);

        // Whether cached data exist and they are still valid?
        if (!empty($compressedData) && isset($cachedData['createdAt']) &&
            ($this->getLatestModifiedTime($absolutePaths) <= $cachedData['createdAt'])) {
            $success = true;
        }

        if (!$success && !$this->debug) {
            // Cached data are missing or stale
            $data = array(
                'createdAt' => microtime(true),
                'data'      => $this->minifyJS($absolutePaths),
                'paths'     => $relativePaths,
                'type'      => ($isCss ? 'c' : 'j'),
            );
            $success = Cache::set($key, $data, 0);
        }

        if ($success && !$this->debug) {
            $url = $this->config['site_url'] . '/r.php?k=' . $key;
            $retval .= sprintf(self::JS_TAG_TEMPLATE, $url);
        } else {
            // Somehow failed to save data into cache or debug mode is on
            $retval .= PHP_EOL;

            foreach ($files as $file) {
                $retval .= sprintf(
                        self::JS_TAG_TEMPLATE, $this->config['site_url'] . $file['file']
                    )
                    . PHP_EOL;
            }
        }

        return $retval;
    }

    /**
     * Convert from array to JavaScript object format string
     *
     * @param  array $source
     * @return string
     */
    private function arrayToJavaScriptObject(array $source)
    {
        $retval = '{';

        foreach ($source as $key => $val) {
            $retval .= "$key:";

            switch (gettype($val)) {
                case 'array':
                    $retval .= $this->arrayToJavaScriptObject($val) . ',';
                    break;

                case 'boolean':
                    $retval .= $val ? 'true,' : 'false,';
                    break;

                case 'NULL':
                    $retval .= 'null,';
                    break;

                case 'integer':
                case 'double':
                    $retval .= $val . ',';
                    break;

                default:
                    $retval .= '"' . $val . '",';
                    break;
            }
        }

        $retval = rtrim($retval, ',') . '}';

        return $retval;
    }

    /**
     * Make tags for system libraries
     *
     * @param  bool $isFooter
     * @return string
     */
    private function makeTagsForSystemLibraries($isFooter = true)
    {
        $retval = '';

        // JQuery
        if ((!$isFooter && ($this->jQueryPosition === 'header')) ||
            ($isFooter && ($this->jQueryPosition === 'footer'))) {
            if ($this->config['cdn_hosted']) {
                $retval .= sprintf(
                    self::JS_TAG_TEMPLATE,
                    sprintf(self::JQUERY_CDN, self::JQUERY_VERSION)
                );
            } else {
                $retval .= sprintf(
                    self::JS_TAG_TEMPLATE,
                    $this->config['site_url'] . $this->libraryLocations['jquery']
                );
            }

            $retval .= PHP_EOL;
        }

        // JQuery UI
        if ((!$isFooter && ($this->jQueryUIPosition === 'header')) ||
            ($isFooter && ($this->jQueryUIPosition === 'footer'))) {
            if ($this->config['cdn_hosted']) {
                $retval .= sprintf(
                    self::JS_TAG_TEMPLATE,
                    sprintf(self::JQUERY_UI_CDN, self::JQUERY_UI_VERSION)
                );
            } else {
                $retval .= sprintf(
                    self::JS_TAG_TEMPLATE,
                    $this->config['site_url'] . $this->libraryLocations['jquery-ui']
                );
            }

            $retval .= PHP_EOL;
        }

        // UIkit
        if (!$isFooter && $this->useUIkit) {
            if ($this->config['cdn_hosted']) {
                $retval .= sprintf(
                    self::JS_TAG_TEMPLATE,
                    sprintf(self::UIKIT_CDN, self::UIKIT_VERSION)
                );
            } else {
                $retval .= sprintf(
                    self::JS_TAG_TEMPLATE,
                    $this->config['site_url'] . $this->libraryLocations['uikit']
                );
            }

            $retval .= PHP_EOL;
        }

        // UIkit3
        if (!$isFooter && $this->useUIkit3) {
            if ($this->config['cdn_hosted']) {
                $retval .= sprintf(
                    self::JS_TAG_TEMPLATE,
                    sprintf(self::UIKIT3_CDN, self::UIKIT3_VERSION)
                );
            } else {
                $retval .= sprintf(
                        self::JS_TAG_TEMPLATE,
                        $this->config['site_url'] . $this->libraryLocations['uikit3']
                    )
                    . PHP_EOL
                    . sprintf(self::JS_TAG_TEMPLATE, $this->libraryLocations['uikit3-icons']);
            }

            $retval .= PHP_EOL;
        }

        return $retval;
    }

    /**
     * Returns header code (JavaScript and CSS) to include in the Head of the web page
     *
     * @return string
     */
    public function getHeader()
    {
        global $LANG_DIRECTION, $MESSAGE;

        $retval = PHP_EOL;
        $this->isHeaderSet = true;

        /**
         * Collect CSS files
         */

        // 1. External CSS files
        if (count($this->externalCssFiles) > 0) {
            usort($this->externalCssFiles, array('\\Geeklog\\Resource', 'comparePriority'));

            foreach ($this->externalCssFiles as $cssFile) {
                $retval .= $this->buildLinkTag($cssFile['file'], $cssFile['attributes']) . PHP_EOL;
            }
        }

        // 2. System CSS files
        $cssFiles = array();

        if (!empty($this->jQueryUIPosition)) {
            $cssFiles = array(
                array(
                    'file'     => '/vendor/jquery-ui/jquery-ui.min.css',
                    'priority' => self::JQUERY_UI_PRIORITY,
                ),
                array(
                    'file'     => '/vendor/jquery-ui/jquery-ui.structure.min.css',
                    'priority' => self::JQUERY_UI_PRIORITY + 10,
                ),
                array(
                    'file'     => '/vendor/jquery-ui/jquery-ui.theme.min.css',
                    'priority' => self::JQUERY_UI_PRIORITY + 20,
                ),
                array(
                    'file'     => '/layout/' . $this->config['theme'] . '/jquery_ui/jquery-ui.geeklog.css',
                    'priority' => self::JQUERY_UI_PRIORITY + 30,
                ),
            );
        } elseif ($this->useUIkit3) {
            $cssFileName = (isset($LANG_DIRECTION) && ($LANG_DIRECTION === 'rtl')) ? 'uikit-rtl' : 'uikit';
            $cssFiles = array(
                array(
                    'file'     => '/vendor/uikit3/css/' . $cssFileName . '.min.css',
                    'priority' => self::UIKIT3_PRIORITY,
                ),
            );
        }

        // 3. Local CSS files
        if (count($this->localCssFiles) > 0) {
            $cssFiles = array_merge($cssFiles, $this->localCssFiles);
        }

        $retval .= $this->makeFileServerTag($cssFiles, true) . PHP_EOL;

        // 4. CSS code blocks
        if (count($this->cssBlocks) > 0) {
            $retval .= '<style type="text/css">' . PHP_EOL
                . implode(PHP_EOL, $this->cssBlocks) . PHP_EOL
                . '</style>' . PHP_EOL;
        }

        /**
         * Collect JavaScript files
         */

        // 5. System libraries
        $retval .= $this->makeTagsForSystemLibraries(false);

        // 6. External JavaScript files
        if (count($this->externalJsFiles['header']) > 0) {
            usort($this->externalJsFiles['header'], array('\\Geeklog\\Resource', 'comparePriority'));

            foreach ($this->externalJsFiles['header'] as $jsFile) {
                $retval .= sprintf(self::EXTERNAL_JS_TAG_TEMPLATE, $jsFile['file']) . PHP_EOL;
            }
        }

        // 7. JavaScript variables
        $iso639Code = COM_getLangIso639Code();
        $lang = array(
            'iso639Code'          => $iso639Code,
            'tooltip_loading'     => $MESSAGE[116],
            'tooltip_not_found'   => $MESSAGE[117],
            'tooltip_select_date' => $MESSAGE[118],
            'tabs_more'           => $MESSAGE[119],
            'confirm_delete'      => $MESSAGE[76],
            'confirm_send'        => $MESSAGE[120],
        );
        if (!empty($this->lang)) {
            $lang = array_merge($lang, $this->lang);
        }

        $detect = new \Mobile_Detect;
        $device = array(
            'isMobile' => $detect->isMobile(),
            'isTablet' => $detect->isTablet(),
        );

        $src = array(
            'site_url'       => $this->config['site_url'],
            'site_admin_url' => $this->config['site_admin_url'],
            'layout_url'     => $this->config['layout_url'],
            'xhtml'          => XHTML,
            'lang'           => $lang,
            'device'         => $device,
            'theme_options'  => $this->config['theme_options'],
        );
        $str = $this->arrayToJavaScriptObject($src);

        // Strip '{' and '}' from both ends of $str
        $str = substr($str, 1);
        $str = substr($str, 0, strlen($str) - 1);
        $retval .= '<script>var geeklog={ doc:document,win:window,$:function(id){ return this.doc.getElementById(id); },'
            . $str . ' };</script>' . PHP_EOL;

        // 8. Local JavaScript files
        if (count($this->localJsFiles['header']) > 0) {
            $retval .= $this->makeFileServerTag($this->localJsFiles['header'], false) . PHP_EOL;
        }

        // 9. JavaScript code blocks
        if (count($this->jsBlocks['header']) > 0) {
            if ($this->debug) {
                $retval .= '<script type="text/javascript">'
                    . implode(PHP_EOL, $this->jsBlocks['header'])
                    . '</script>' . PHP_EOL;
            } else {
                $code = implode(PHP_EOL, $this->jsBlocks['header']);
                $code = JSMin::minify($code);
                $retval .= '<script type="text/javascript">' . $code . '</script>' . PHP_EOL;
            }
        }

        return $retval;
    }

    /**
     * Returns JavaScript footer code to be placed just before </body>
     *
     * @return string
     */
    public function getFooter()
    {
        $retval = '';

        // 1. System JavaScript files
        $retval .= $this->makeTagsForSystemLibraries(true);

        // 2. External JavaScript files
        if (count($this->externalJsFiles['footer']) > 0) {
            usort($this->externalJsFiles['footer'], array('\\Geeklog\\Resource', 'comparePriority'));

            foreach ($this->externalJsFiles['footer'] as $jsFile) {
                $retval .= sprintf(self::EXTERNAL_JS_TAG_TEMPLATE, $jsFile['file']) . PHP_EOL;
            }
        }

        // 3. Local JavaScript files
        if (count($this->localJsFiles['footer']) > 0) {
            $retval .= $this->makeFileServerTag($this->localJsFiles['footer'], false) . PHP_EOL;
        }

        // 4. JavaScript code blocks
        if (count($this->jsBlocks['footer']) > 0) {
            $code = implode(PHP_EOL, $this->jsBlocks['footer']);

            if (!$this->debug) {
                $code = JSMin::minify($code);
            }

            $retval .= '<script type="text/javascript">' . $code . '</script>' . PHP_EOL;
        }

        return $retval;
    }
}
