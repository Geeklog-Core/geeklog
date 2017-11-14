<?php

namespace Geeklog;

use MatthiasMullie\Minify;

class Resource
{
    const DEFAULT_CACHE_LIFESPAN = 604800; // 1 week

    // Local library versions
    const JQUERY_VERSION = '3.1.1';
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
     * @var array
     */
    private $localLibraries = array(
        'jquery'                          => '/javascript/jquery.min.js',
        'jquery-ui'                       => '/javascript/jquery_ui/jquery-ui.min.js',
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
    );

    /**
     * @var array a copy of $_CONF
     */
    private $config;

    /**
     * @var bool
     */
    private $useJQuery = false;

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
     * Array of local JavaScript libraries managed by Geeklog
     *
     * @var array
     */
    private $localJsLibraries = array(
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
        $config['path_html'] = str_replace('\\', '/', rtrim($config['path_html'], '/\\'));
        $this->config = $config;
        $this->setJavaScriptLibrary('common');
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
     * @param  string $path
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
                    if (!isset($retval[$key])) {
                        $retval[$key] = $value;
                    }

                    break;
            }
        }

        if (!isset($retval['rel'])) {
            $retval['rel'] = 'stylesheet';
        }

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
        $name = strtolower($name);
        $position = $isFooter ? 'footer' : 'header';

        if (!isset($this->localLibraries[$name])) {
            return false;
        }

        switch ($name) {
            case 'jquery':
                if ($this->useJQuery) {
                    // Already used
                    return true;
                }

                $this->useJQuery = true;

                if ($this->config['cdn_hosted']) {
                    $this->externalJsFiles[$position][] = array(
                        'file'     => sprintf(self::JQUERY_CDN, self::JQUERY_VERSION),
                        'priority' => -self::JQUERY_PRIORITY,
                    );
                } else {
                    $this->localJsFiles[$position][] = array(
                        'file'     => $this->localLibraries[$name],
                        'priority' => self::JQUERY_PRIORITY,
                    );
                }

                return true;
                break;

            case 'jquery-ui':
                if (!$this->useJQuery) {
                    $this->setJavaScriptLibrary('jquery', $isFooter);
                }

                if ($this->config['cdn_hosted']) {
                    $this->externalJsFiles[$position][] = array(
                        'file'     => sprintf(self::JQUERY_UI_CDN, self::JQUERY_UI_VERSION),
                        'priority' => self::JQUERY_UI_PRIORITY,
                    );
                    $this->externalCssFiles[] = array(
                        'file'       => sprintf(self::JQUERY_UI_CDN, self::JQUERY_UI_VERSION, self::JQUERY_UI_THEME),
                        'attributes' => array('rel' => 'stylesheet'),
                        'priority'   => self::JQUERY_UI_PRIORITY,
                    );
                } else {
                    $this->localJsFiles[$position][] = array(
                        'file'     => $this->localLibraries[$name],
                        'priority' => self::JQUERY_UI_PRIORITY,
                    );
                    $this->localCssFiles[] = array(
                        'file'       => '/javascript/jquery-ui/jquery-ui-min.css',
                        'attributes' => array('rel' => 'stylesheet'),
                        'priority'   => self::JQUERY_UI_PRIORITY,
                    );
                }

                return true;
                break;

            case 'uikit':
                if (!$this->useJQuery) {
                    $this->setJavaScriptLibrary('jquery', false);
                }

                if ($this->config['cdn_hosted']) {
                    $this->externalJsFiles['header'][] = array(
                        'file'     => sprintf(self::UIKIT_CDN, self::UIKIT_VERSION),
                        'priority' => self::UIKIT_PRIORITY,
                    );
                    $this->externalCssFiles[] = array(
                        'file'       => sprintf(self::UIKIT_CSS_CDN, self::UIKIT_VERSION),
                        'attributes' => array('rel' => 'stylesheet'),
                        'priority'   => self::UIKIT_PRIORITY,
                    );
                } else {
                    $this->localJsFiles['header'] = array(
                        'file'     => $this->localLibraries['uikit'],
                        'priority' => self::UIKIT_PRIORITY,
                    );
                    $this->localCssFiles[] = array(
                        'file'       => '/vendor/uikit/css/uikit.css',
                        'attributes' => array('rel' => 'stylesheet'),
                        'priority'   => self::UIKIT_PRIORITY,
                    );
                }

                return true;
                break;

            default:
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
            $this->jsBlocks[$isFooter ? 'footer' : 'header'][] = $code;

            return true;
        }
    }

    /**
     * Set JavaScript file to load
     *
     * @param  string $name (not used)
     * @param  string $file relative to public_html (must start with '/')
     * @param  bool   $wrap (not used)
     * @param  bool   $isFooter
     * @param  int    $priority
     * @return bool
     */
    public function setJavaScriptFile($name, $file, $wrap = false, $isFooter = true, $priority = 100)
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
            );

            return true;
        } else {
            if ($this->exists($this->config['path_html'] . $file)) {
                $this->localCssFiles[] = array(
                    'file'       => $file,
                    'attributes' => $attributes,
                    'priority'   => $priority,
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
    private function buildLinkTag($href, array $attributes)
    {
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
     * Minify local files and build a tag to serve the data
     *
     * @param  array $files array of array('file', 'priority', 'attributes') or array('file', 'priority')
     * @param  bool  $isCss
     * @return string
     */
    private function makeFileServerTag(array $files, $isCss = true)
    {
        $absolutePaths = array();
        $relativePaths = array();
        $success = false;

        usort($files, array('Geeklog\\Resource', 'comparePriority'));

        foreach ($files as $file) {
            $absolutePaths[] = $this->config['path_html'] . $file['file'];
            $relativePaths[] = $file['file'];
        }

        $key = md5(implode('|', $relativePaths));
        $cachedData = Cache::get($key);

        // Whether cached data exists and it is still valid?
        if (!empty($compressedData) && isset($cachedData['createdAt']) &&
            ($this->getLatestModifiedTime($absolutePaths) <= $cachedData['createdAt'])) {
            $success = true;
        }

        if (!$success) {
            // Cached data is missing or stale
            if ($isCss) {
                $min = new Minify\CSS();
            } else {
                $min = new Minify\JS();
            }

            $min->add($absolutePaths);
            $data = array(
                'createdAt' => microtime(true),
                'data'      => $min->minify(),
                'paths'     => $relativePaths,
                'type'      => ($isCss ? 'c' : 'j'),
            );
            $success = Cache::set($key, $data, 0);
        }

        if ($success) {
            $url = $this->config['site_url'] . '/r.php?k=' . $key;

            if ($isCss) {
                $retval = sprintf('<link rel="stylesheet" href="%s"%s>', $url, XHTML);
            } else {
                $retval = sprintf('<script type="text/javascript" src="%s"></script>', $url);
            }
        } else {
            // Somehow failed to save data into cache
            $retval = PHP_EOL;

            foreach ($files as $file) {
                if ($isCss) {
                    $retval .= $this->buildLinkTag(
                        $this->config['site_url'] . $file['file'], $file['attributes']
                    );
                } else {
                    $retval .= sprintf(
                        '<script src="%s"></script>',
                        $this->config['site_url'] . $file['file']
                    );
                }

                $retval .= PHP_EOL;
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
     * Returns header code (JavaScript and CSS) to include in the Head of the web page
     *
     * @return string
     */
    public function getHeader()
    {
        global $MESSAGE;

        $retval = '';
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

        // 2. Local CSS files
        if (count($this->localCssFiles) > 0) {
            $retval .= $this->makeFileServerTag($this->localCssFiles, true);
        }

        // 3. CSS code blocks
        if (count($this->cssBlocks) > 0) {
            $min = new Minify\Css();
            $min->add(implode(PHP_EOL, $this->cssBlocks));
            $compressedCss = $min->minify();
            $retval .= '<style type="text/css">' . PHP_EOL
                . $compressedCss . PHP_EOL
                . '</style>' . PHP_EOL;
        }

        // 4. External JavaScript files
        if (count($this->externalJsFiles['header']) > 0) {
            usort($this->externalJsFiles['header'], array('\\Geeklog\\Resource', 'comparePriority'));

            foreach ($this->externalJsFiles['header'] as $jsFile) {
                $retval .= sprintf('<script src="%s"></script>', $jsFile['file']) . PHP_EOL;
            }
        }

        // 5. JavaScript variables
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

        // 6. Local JavaScript files
        if (count($this->localJsFiles['header']) > 0) {
            $retval .= $this->makeFileServerTag($this->localJsFiles['header'], false);
        }

        // 7. JavaScript code blocks
        if (count($this->jsBlocks['header']) > 0) {
            $min = new Minify\JS();
            $min->add(PHP_EOL, $this->jsBlocks['header']);
            $compressedJs = $min->minify();
            $retval .= '<script>' . $compressedJs . '</script>' . PHP_EOL;
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

        // 1. External JavaScript files
        if (count($this->externalJsFiles['footer']) > 0) {
            usort($this->externalJsFiles['footer'], array('\\Geeklog\\Resource', 'comparePriority'));

            foreach ($this->externalJsFiles['footer'] as $jsFile) {
                $retval .= sprintf('<script src="%s"></script>', $jsFile['file']) . PHP_EOL;
            }
        }

        // 2. Local JavaScript files
        if (count($this->localJsFiles['footer']) > 0) {
            $retval .= $this->makeFileServerTag($this->localJsFiles['footer'], false);
        }

        // 3. JavaScript code blocks
        if (count($this->jsBlocks['footer']) > 0) {
            $min = new JS();
            $min->add(PHP_EOL, $this->jsBlocks['footer']);
            $compressedJs = $min->minify();
            $retval .= '<script>' . $compressedJs . '</script>' . PHP_EOL;
        }

        return $retval;
    }
}
