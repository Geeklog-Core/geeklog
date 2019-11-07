<?php

/**
 * Class Installer
 */
class Installer
{
    // Geeklog version
    const GL_VERSION = '2.2.1';

    // System requirements
    const SUPPORTED_PHP_VER = '5.6.4';
    const SUPPORTED_MYSQL_VER = '4.1.3';

    // Default UI language
    const DEFAULT_LANGUAGE = 'english';

    // Default theme
    const DEFAULT_THEME = 'denim';

    // Database configuration file
    const DB_CONFIG_FILE = 'db-config.php';

    /**
     * Language meta data
     *
     * @var array of ['name' => language name, 'code' => ISO 639-1 (regional tag)
     */
    private $languages = [];

    /**
     * @var array
     */
    private $env = array();

    /**
     * @var bool
     */
    private $isMagicQuotes = false;

    /**
     * @var array
     */
    private $LANG = array();

    /**
     * @var array
     */
    private $upgradeMessages = array();

    /**
     * Replaces all newlines in a string with <br> or <br />,
     * depending on the detected setting.  Ported from "lib-common.php"
     *
     * @param   string $string The string to modify
     * @return  string         The modified string
     */
    public static function nl2br($string)
    {
        $replace = '<br>';
        $find = array("\r\n", "\n\r", "\r", "\n");

        return str_replace($find, $replace, $string);
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->env['language'];
    }

    /**
     * Installer constructor.
     */
    public function __construct()
    {
        global $LANG_BIGDUMP, $LANG_CHARSET, $LANG_DIRECTION, $LANG_ERROR, $LANG_HELP, $LANG_INSTALL,
               $LANG_LABEL, $LANG_MIGRATE, $LANG_PLUGINS, $LANG_RESCUE, $LANG_SUCCESS;

        // this is not ideal but will stop PHP 5.3.0ff from complaining ...
        date_default_timezone_set(@date_default_timezone_get());

        $langInfo = @include_once __DIR__ . '/../language/_list.php';
        uasort($langInfo, function ($a, $b) { return strcasecmp($a['langName'], $b['langName']); });
        $this->languages = $langInfo;

        $this->isMagicQuotes = (bool) get_magic_quotes_gpc();
        $this->env['mode'] = $this->get('mode', $this->post('mode', ''));
        $this->env['step'] = intval($this->get('step', $this->post('step', 1)), 10);
        $this->env['language_selector'] = '';
        $language = $this->post('language', $this->get('language', $this->getDefaultLanguage()));

        // Upgrade Message check flag for if continue button clicked if any messages present
        $this->env['upgrade_check'] = $this->get('upgrade_check', $this->post('upgrade_check', ''));

        // Include language file

        if (!file_exists(PATH_INSTALL . 'language/' . $language . '.php')) {
            $language = self::DEFAULT_LANGUAGE;
        }

        $this->env['language'] = $language;
        require_once PATH_INSTALL . 'language/' . $language . '.php';

        if (!isset($LANG_DIRECTION)) {
            $LANG_DIRECTION = 'ltr';
        }
        $this->env['rtl'] = $LANG_DIRECTION ==='rtl' ? '-rtl' : '';
        if ($LANG_DIRECTION === 'rtl') {
            $this->env['icon_arrow_next'] = '<span uk-icon="icon: chevron-double-left"></span>';
            $this->env['icon_arrow_prev'] = '<span uk-icon="icon: chevron-double-right"></span>';
        } else {
            $this->env['icon_arrow_next'] = '<span uk-icon="icon: chevron-double-right"></span>';
            $this->env['icon_arrow_prev'] = '<span uk-icon="icon: chevron-double-left"></span>';
        }

        /** @noinspection PhpUndefinedVariableInspection */
        $this->env['LANG'] = $this->LANG = array(
            'BIGDUMP'   => $LANG_BIGDUMP,
            'CHARSET'   => $LANG_CHARSET,
            'DIRECTION' => $LANG_DIRECTION,
            'ERROR'     => $LANG_ERROR,
            'HELP'      => $LANG_HELP,
            'INSTALL'   => $LANG_INSTALL,
            'LABEL'     => $LANG_LABEL,
            'MIGRATE'   => $LANG_MIGRATE,
            'PLUGINS'   => $LANG_PLUGINS,
            'RESCUE'    => $LANG_RESCUE,
            'SUCCESS'   => $LANG_SUCCESS,
        );

        // Check PHP version and exit the installer if the environment is too old
        $this->checkPhpVersion();

        // Check the size of an uploaded file
        $this->checkUploadedFileSize();
    }

    /**
     * Convert a string like '2m' to bytes
     *
     * @param  string $val
     * @return int
     */
    private function toBytes($val)
    {
        $val = trim($val);
        $last = strtolower(substr($val, -1));
        $val = intval(substr($val, 0, -1), 10);

        if ($last === 'g') {
            $val *= 1024 * 1024 * 1024;
        } elseif ($last === 'm') {
            $val *= 1024 * 1024;
        } elseif ($last === 'k') {
            $val *= 1024;
        }

        return $val;
    }

    /**
     * Nicely formats the alert messages
     *
     * @param    string $message Message string
     * @param    string $type    'error', 'warning', 'success', or 'notice'
     * @return   string          HTML formatted dialog message
     */
    public function getAlertMessage($message, $type = 'notice', $title = '')
    {
        switch (strtolower($type)) {
            case 'error':
                $type = $this->LANG['INSTALL'][38];
                $style = 'danger';
                break;

            case 'warning':
                $type = $this->LANG['INSTALL'][20];
                $style = 'warning';
                break;

            case 'success':
                $type = $this->LANG['INSTALL'][93];
                $style = 'success';
                break;

            default:
                $type = $this->LANG['INSTALL'][59];
                $style = 'warning';
                break;
        }

        $retval = '';
        if (!empty($title)) {
            $retval .= '<h3>' . $title . '</h3>';
        }
        $retval .= '<div class="uk-alert uk-alert-' . $style . '">';
        $retval .= '<span class="uk-label uk-label-' . $style . '">' . $type . '</span> ' . $message . '</div>' . PHP_EOL;

        return $retval;
    }

    /**
     * Check if an uploaded file exceeds PHP's post_max_size and, if so,  exit the installer
     */
    private function checkUploadedFileSize()
    {
        $contentLength = $this->server('CONTENT_LENGTH', 0);

        if ($contentLength > 0) {
            $postMaxSize = @ini_get('post_max_size');
            $postMaxSize = $this->toBytes($postMaxSize);

            if ($postMaxSize && ($contentLength > $postMaxSize)) {
                // If size exceeds, display an error message
                $template = $this->getTemplateObject();
                $content = '<h1>' . $this->LANG['ERROR'][8] . '</h1>' . PHP_EOL
                    . $this->getAlertMessage($this->LANG['ERROR'][7]);
                $template->set('content', $content);
                $template->display('index');
                die(1);
            }
        }
    }

    /**
     * Check if any message for upgrades,  exit the installer
     *
     * @param  string $currentVersion
     * @return string
     */
    private function checkUpgradeMessage($currentVersion)
    {
        $retval = '';

        if ($this->doDatabaseUpgrades($currentVersion, true) && !empty($this->upgradeMessages)) {
            $prompt = 'information';
            $retval = '<h1>' . $this->LANG['ERROR'][14] . '</h1>' . PHP_EOL; // Upgrade Notice
            $this->env['site_url'] = $this->get('site_url', $this->post('site_url', $this->getSiteUrl()));
            $this->env['site_admin_url'] = $this->get('site_admin_url', $this->post('site_admin_url', $this->getSiteAdminUrl()));

            foreach ($this->upgradeMessages as $version => $message) {
                $retval .= '<h2>' . $this->LANG['INSTALL'][111] . ' ' . $version . '</h2>' . PHP_EOL;
                if (version_compare($version, '2.1.2', '<')) {
                    foreach ($message as $type => $message_id) {
                        $retval .= $this->getAlertMessage($this->LANG['ERROR'][$message_id], $type);
                        // record what type of prompt we need
                        if ($type === 'information' || $type === 'warning' || $type === 'error') {
                            if ($prompt !== 'error') {
                                $prompt = $type;
                            }
                        }
                    }
                } else {
                    // Upgrade message array changed in Geeklog v2.2.0 to allow multiple boxes of the same type (warning, information or error) to be displayed in the same Geeklog version
                    foreach ($message as $id => $info) {
                        $type = $info[0];
                        $title_id = $info[1];
                        $message_id = $info[2];
                        $retval .= $this->getAlertMessage($this->LANG['ERROR'][$message_id], $type, $this->LANG['ERROR'][$title_id]);
                        // record what type of prompt we need
                        if ($type === 'information' || $type === 'warning' || $type === 'error') {
                            if ($prompt !== 'error') {
                                $prompt = $type;
                            }
                        }
                    }
                }
            }

            // Add prompt
            if ($prompt === 'error') {
                $retval .= MicroTemplate::quick(PATH_LAYOUT, 'upgrade_prompt_error', $this->env);
            } else {
                // add current version to array so set in template
                $this->env['currentVersion'] = $currentVersion;

                $retval .= MicroTemplate::quick(PATH_LAYOUT, 'upgrade_prompt_warning', $this->env);
            }
        }

        return $retval;
    }

    /**
     * Return a request variable undoing magic_quotes
     *
     * @param  array|string $var
     * @return array|string
     */
    private function processRequestVar($var)
    {
        if (is_array($var)) {
            return array_map(array($this, 'processRequestVar'), $var);
        } else {
            return $this->isMagicQuotes ? stripslashes($var) : $var;
        }
    }

    /**
     * Return a $_GET variable
     *
     * @param  string       $name
     * @param  array|string $defaultValue
     * @return array|null|string
     */
    public function get($name, $defaultValue = null)
    {
        return array_key_exists($name, $_GET) ? $this->processRequestVar($_GET[$name]) : $defaultValue;
    }

    /**
     * Return a $_POST variable
     *
     * @param  string       $name
     * @param  array|string $defaultValue
     * @return array|null|string
     */
    public function post($name, $defaultValue = null)
    {
        return array_key_exists($name, $_POST) ? $this->processRequestVar($_POST[$name]) : $defaultValue;
    }

    /**
     * Return a $_REQUEST variable
     *
     * @param  string       $name
     * @param  array|string $defaultValue
     * @return array|null|string
     */
    public function request($name, $defaultValue = null)
    {
        return array_key_exists($name, $_REQUEST) ? $this->processRequestVar($_REQUEST[$name]) : $defaultValue;
    }

    /**
     * Return a $_SERVER variable
     *
     * @param  string       $name
     * @param  array|string $defaultValue
     * @return array|null|string
     */
    private function server($name, $defaultValue = null)
    {
        return array_key_exists($name, $_SERVER) ? $_SERVER[$name] : $defaultValue;
    }

    /**
     * Return a template object with basic template variables set
     *
     * @return MicroTemplate
     */
    private function getTemplateObject()
    {
        $retval = new MicroTemplate(PATH_LAYOUT);
        $retval->set($this->env);

        return $retval;
    }

    /**
     * Check PHP version and exit if the environment is too pld
     */
    public function checkPhpVersion()
    {
        if (version_compare(PHP_VERSION, self::SUPPORTED_PHP_VER) >= 0) {
            return;
        }

        $content = '<h1>' . $this->LANG['INSTALL'][3] . '</h1>' . PHP_EOL
            . '<p>' . sprintf($this->LANG['INSTALL'][5], '<strong>' . self::SUPPORTED_PHP_VER . '</strong>')
            . '<strong>' . PHP_VERSION . '</strong>' . $this->LANG['INSTALL'][6] . '</p>' . PHP_EOL;
        $template = $this->getTemplateObject();
        $template->set('content', $content);
        $template->display('index');
        die(1);
    }

    /**
     * Return a list of acceptable language of the user
     *
     * @return array
     */
    private function getLanguagesFromUserAgent()
    {
        $retval = [];

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);

            if (count($languages) > 0) {
                foreach ($languages as $language) {
                    if (strpos($language, ';') !== false) {
                        list ($langName, $temp) = explode(';', $language, 2);

                        if (strpos('=', $temp) !== false) {
                            list (, $quality) = explode('=', $temp, 2);
                        } else {
                            $quality = 1.0;
                        }
                    } else {
                        $langName = $language;
                        $quality = 1.0;
                    }

                    $retval[] = [
                        'name' => trim($langName),
                        'quality' => (float) trim($quality)
                    ];
                }

                uasort($retval, function ($a, $b) { return -($a['quality'] - $b['quality']); });
                $temp = [];

                foreach ($retval as $r) {
                    $temp[] = $r['name'];
                }

                $retval = $temp;
            }
        }

        return $retval;
    }

    /**
     * Return a UI language selector
     *
     * @return string
     */
    private function getLanguageSelector()
    {
        $env = $this->env;
        $env['hidden_items'] = array();
        $env['languages'] = array();

        if (!empty($this->env['mode'])) {
            $env['hidden_items'][] = array('name' => 'mode', 'value' => $this->env['mode']);
        }

        $paths = array('dbconfig', 'public_html');
        foreach ($paths as $path) {
            $name = $path . '_path';
            $value = $this->get($name, $this->post($name));

            if (!empty($value)) {
                $value = $this->sanitizePath($value);
                $env['hidden_items'][] = array(
                    'name'  => $name,
                    'value' => $value,
                );
            }
        }

        foreach ($this->languages as $languageName => $data) {
            $languageName = strtolower($languageName);
            $languageName = str_replace('.php', '', $languageName);
            $env['languages'][] = array(
                'value'    => $languageName,
                'selected' => (($languageName === $this->env['language']) ? ' selected="selected"' : ''),
                'text'     => $data['langName'] . ' (' . $data['english'] . ')',
            );
        }

        return MicroTemplate::quick(PATH_LAYOUT, 'language_selector', $env);
    }

    /**
     * Helper function: Derive 'path_html' from __FILE__
     *
     * @return string
     */
    public function getHtmlPath()
    {
        $path = str_replace('\\', '/', BASE_FILE);
        $path = str_replace('//', '/', $path);
        $parts = explode('/', $path);
        $numParts = count($parts);

        if (($numParts < 3) || ($parts[$numParts - 1] !== basename(BASE_FILE))) {
            die('Fatal error - cannot figure out my own path');
        }

        return implode('/', array_slice($parts, 0, $numParts - 3)) . '/';
    }

    /**
     * Helper function: Derive path of the 'admin' directory from index.php
     *
     * @return string
     */
    public function getAdminPath()
    {
        $path = str_replace('\\', '/', BASE_FILE);
        $path = str_replace('//', '/', $path);
        $parts = explode('/', $path);
        $num_parts = count($parts);

        if (($num_parts < 3) || ($parts[$num_parts - 1] !== 'index.php')) {
            die('Fatal error - can not figure out my own path');
        }

        return implode('/', array_slice($parts, 0, $num_parts - 2)) . '/';
    }

    /**
     * Filter path value for junk and injections
     *
     * @param   string $path a path on the file system
     * @return  string          filtered path value
     */
    public function sanitizePath($path)
    {
        $path = strip_tags($path);
        $path = str_replace(array('"', "'"), '', $path);
        $path = str_replace('..', '', $path);

        return $path;
    }

    /**
     * Check the location of db-config.php.  We'll base our /path/to/geeklog on its location
     *
     * @return string
     */
    private function checkFileLocations()
    {
        $this->env['gl_path'] .= '/';
        $this->env['dbconfig_path'] = '';

        if (file_exists($this->env['gl_path'] . self::DB_CONFIG_FILE) ||
            file_exists($this->env['gl_path'] . 'public_html/' . self::DB_CONFIG_FILE)
        ) {
            // See whether the file/directory is located in the default place or in public_html
            $this->env['dbconfig_path'] = file_exists($this->env['gl_path'] . self::DB_CONFIG_FILE)
                ? $this->env['gl_path'] . self::DB_CONFIG_FILE
                : $this->env['gl_path'] . 'public_html/' . self::DB_CONFIG_FILE;

            // If the script was able to locate all the system files/directories move onto the next step
            $args = array(
                'mode'          => 'check_permissions',
                'dbconfig_path' => $this->env['dbconfig_path'],
            );

            if (!empty($this->env['language'])) {
                $args['language'] = $this->env['language'];
            }

            $url = 'index.php?' . http_build_query($args);
            header('Location: ' . $url);
        }

        $this->env['base_file'] = str_replace('\\', '/', BASE_FILE);
        $this->env['search_here'] = sprintf(
            $this->LANG['INSTALL'][96],
            '<code>' . self::DB_CONFIG_FILE . '</code>'
        );
        $retval = MicroTemplate::quick(PATH_LAYOUT, 'system_path', $this->env);

        return $retval;
    }

    /**
     * Write configuration values into siteconfig.php
     *
     * @return string
     */
    private function writeSiteConfig()
    {
        $retval = '';

        // Get the paths from the previous page
        $paths = array(
            'db-config.php' => $this->sanitizePath(urldecode($_REQUEST['dbconfig_path'])),
            'public_html/'  => $this->sanitizePath(urldecode($_REQUEST['public_html_path'])),
        );
        $this->env['dbconfig_path'] = str_replace(self::DB_CONFIG_FILE, '', $paths['db-config.php']);

        // Edit siteconfig.php and enter the correct GL path and system directory path
        clearstatcache();
        $this->env['siteconfig_path'] = $paths['public_html/'] . 'siteconfig.php';
        $siteConfigData = @file_get_contents($this->env['siteconfig_path']);

        // $_CONF['path']
        $_CONF = array();
        require_once $this->env['siteconfig_path'];
        $siteConfigData = str_replace(
            "\$_CONF['path'] = '{$_CONF['path']}';",
            "\$_CONF['path'] = '" . str_replace('db-config.php', '', $paths['db-config.php']) . "';",
            $siteConfigData
        );

        if (@file_put_contents($this->env['siteconfig_path'], $siteConfigData) === false) {
            exit($this->LANG['INSTALL'][26] . ' ' . $paths['public_html/'] . $this->LANG['INSTALL'][28]);
        }

        // Continue onto the install, upgrade, or migration
        switch ($this->get('op')) {
            case 'migrate':
                header('Location: index.php?mode=migrate'
                    . '&dbconfig_path=' . urlencode($paths['db-config.php'])
                    . '&public_html_path=' . urlencode($paths['public_html/'])
                    . '&language=' . $this->env['language']);
                break;

            case $this->LANG['INSTALL'][24] || $this->LANG['INSTALL'][25]:
                // install or upgrade
                header('Location: index.php?mode=' . $_GET['op']
                    . '&dbconfig_path=' . urlencode($paths['db-config.php'])
                    . '&language=' . $this->env['language']
                    . '&display_step=' . $_REQUEST['display_step']);
                break;

            default:
                $retval = '<p>' . $this->LANG['INSTALL'][100] . '</p>' . PHP_EOL;
                break;
        }

        return $retval;
    }

    /**
     * Check file and directory permissions
     *
     * @return string
     */
    private function checkPermissions()
    {
        $retval = '';

        // Get the paths from the previous page
        $paths = array(
            'db-config.php' => $this->sanitizePath(urldecode($this->get('dbconfig_path', $this->post('dbconfig_path', '')))),
            'public_html/'  => $this->getHtmlPath(),
        );

        // Be fault-tolerant with the path the user enters
        if (strpos($paths['db-config.php'], self::DB_CONFIG_FILE) === false) {
            $paths['db-config.php'] = rtrim($paths['db-config.php'], '/') . '/' . self::DB_CONFIG_FILE;
        }

        // The path to db-config.php is what we'll use to generate our /path/to/geeklog so
        // we want to make sure it's valid and exists before we continue and create problems.
        if (!file_exists($paths['db-config.php'])) {
            $this->env['path_db_config'] = $paths['db-config.php'];
            $retval = MicroTemplate::quick(PATH_LAYOUT, 'system_path_error', $this->env);

            return $retval;
        }

        $_DB_dbms = '';
        require_once $paths['db-config.php'];       // We need db-config.php the current DB information
        require_once $this->env['siteconfig_path']; // We need siteconfig.php for core $_CONF values.

        $this->env['gl_path'] = str_replace(self::DB_CONFIG_FILE, '', $paths['db-config.php']);

        // number of files with wrong permissions
        $numWrong = 0;
        $retval_permissions = '
            <div class="uk-overflow-auto">
            <table class="uk-table uk-table-small">
                <thead>
                    <tr>
                        <th><strong>' . $this->LANG['INSTALL'][10] . '</strong></th>
                        <th><strong>' . $this->LANG['INSTALL'][11] . '</strong></th>
                    </tr>
                </thead>
                <tbody>';

        $chmodString = 'chmod -R 777 ';

        // Files to check if writable
        $fileList = array(
            $paths['db-config.php'],
            $this->env['gl_path'] . 'data/',
            $this->env['gl_path'] . 'data/cache/',
            $this->env['gl_path'] . 'data/layout_cache/',
            $this->env['gl_path'] . 'data/layout_css/',
            $this->env['gl_path'] . 'logs/404.log',
            $this->env['gl_path'] . 'logs/access.log',
            $this->env['gl_path'] . 'logs/error.log',
            $this->env['gl_path'] . 'logs/spamx.log',
            $paths['public_html/'] . 'siteconfig.php',
            $paths['public_html/'] . 'backend/geeklog.rss',
            $paths['public_html/'] . 'filemanager/config/filemanager.config.json',
            $paths['public_html/'] . 'images/articles/',                // Used by article editor for when image is uploaded (to be included in article)
            $paths['public_html/'] . 'images/topics/',                  // Used by topic editor for when image is uploaded
            $paths['public_html/'] . 'images/userphotos',               // Used by user editor for when image is uploaded
            $paths['public_html/'] . 'images/library/File/',            // Used by CKEditor (launches File Manager to this directory when "image button" button pressed in CKeditor tool bar)
            $paths['public_html/'] . 'images/library/Flash/',           // Used by CKEditor (launches File Manager to this directory when "flash" button pressed in CKeditor tool bar)
            $paths['public_html/'] . 'images/library/Image/',           // Used by CKEditor (launches File Manager to this directory when "image" button pressed in CKeditor tool bar)
            $paths['public_html/'] . 'images/library/Image/_thumbs/',   // Used by CKEditor for thumbnails when File Manager used to pick images
            $paths['public_html/'] . 'images/library/Media/',           // Used by CKEditor (assumed as not sure how it is accessed)
            $paths['public_html/'] . 'images/_thumbs/',                 // Used by File Manager when launched from Geeklog Control Panel
            $paths['public_html/'] . 'images/_thumbs/articles/',        // Used by File Manager when launched from Geeklog Control Panel. Article Editor also stores article thumbnail images here
            $paths['public_html/'] . 'images/_thumbs/userphotos/',      // Used by File Manager when launched from Geeklog Control Panel
        );

        if ($_DB_dbms === 'mysql') {
            array_splice($fileList, 1, 0, $this->env['gl_path'] . 'backups/');
        }

        $checkSelinux = false;
        $cmdSelinux = '';

        foreach ($fileList as $file) {
            if (!is_writable($file)) {
                $permShouldBe = is_file($file) ? '666' : '777';
                $permission = sprintf("%3o", @fileperms($file) & 0777);
                $checkPerm = 0;

                for ($i = 0; $i < strlen($permission); $i++) {
                    if ($permission[$i] >= $permShouldBe[$i]) {
                        $checkPerm++;
                    }
                }

                if ($checkPerm >= 3) {
                    $checkSelinux = true;
                    $cmdSelinux .= $file . ' ';
                }

                $retval_permissions .= '
                    <tr>
                        <td><code>' . $file . '</code></td>
                        <td><span class="uk-text-danger uk-text-nowrap">' . $this->LANG['INSTALL'][12] . ' ' . $permShouldBe . '</span> (' . $this->LANG['INSTALL'][13] . ' ' . $permission . ')</td>
                    </tr>';

                $chmodString .= $file . ' ';
                $numWrong++;
            }
        }
        $retval_permissions .= '</tbody></table></div>';

        $retval_step = 1;

        // Display permissions, etc
        if ($checkSelinux) {
            $retval .= '<h1>' . $this->LANG['INSTALL'][101] . ' ' . $retval_step . ' - ' . $this->LANG['INSTALL'][97] . '</h1>' . PHP_EOL
                . $this->LANG['INSTALL'][110];
            $cmd = 'chcon -Rt httpd_user_rw_content_t ' . $cmdSelinux;
            $retval .= '<pre><code>' . $cmd . PHP_EOL
                . '</code></pre><br>' . PHP_EOL;
            $retval_step++;
        } elseif ($numWrong) {
            // If any files have incorrect permissions
            $retval .= '<h1>' . $this->LANG['INSTALL'][101] . ' ' . $retval_step . ' - ' . $this->LANG['INSTALL'][97] . '</h1>' . PHP_EOL;
            $retval_step++;

            if ($this->get('install_type') !== null) {
                // If the user tried to start an installation before setting file permissions
                $retval .= '<p>'
                    . '<div class="uk-alert-danger" uk-alert>'
                    . '<a class="uk-alert-close" uk-close></a>'
                    . '<span class="uk-label uk-label-danger">' . $this->LANG['INSTALL'][38] . '</span> '
                    . $this->LANG['INSTALL'][21]
                    . '</div>' . PHP_EOL;
            } else {
                // The first page that is displayed during the "check_permissions" step
                $retval .= '<p>' . $this->LANG['INSTALL'][9] . '</p>' . PHP_EOL
                    . '<p>' . $this->LANG['INSTALL'][19] . '</p>' . PHP_EOL;
            }

            // List the files that have incorrect permissions and also what the permissions should be
            // Also, list the auto-generated chmod command for advanced users
            $retval .= $retval_permissions . PHP_EOL
                . '<h2>' . $this->LANG['INSTALL'][98] . '</h2>' . PHP_EOL
                . '<p>' . $this->LANG['INSTALL'][99] . '</p>' . PHP_EOL
                . '<pre><code>' . $chmodString . PHP_EOL
                . '</code></pre>' . PHP_EOL;
            $this->env['step']++;
        } else {
            // Set the install type if the user clicked one
            $install_type = $this->request('install_type', null);

            // Check if the user clicked one of the install, upgrade, or migrate buttons
            if ($install_type !== null) {
                // If they did, determine which method they selected
                switch ($install_type) {
                    case $this->LANG['INSTALL'][16]:
                        $install_type = 'migrate';
                        break;

                    case $this->LANG['INSTALL'][24]:
                        $install_type = 'install';
                        break;

                    case $this->LANG['INSTALL'][25]:
                        $install_type = 'upgrade';
                        break;
                }

                // Go to the 'write_paths' step
                $url = 'index.php?'
                    . http_build_query(array(
                            'mode'             => 'write_paths',
                            'dbconfig_path'    => $paths['db-config.php'],
                            'public_html_path' => $paths['public_html/'],
                            'language'         => $this->env['language'],
                            'op'               => $install_type,
                            'display_step'     => $retval_step + 1,
                        )
                    );
                header('Location: ' . $url);
            }
        }

        // Show the "Select your installation method" buttons
        $this->env['dbconfig_path'] = $paths['db-config.php'];
        $this->env['retval_step'] = $retval_step;
        $this->env['display_step'] = $retval_step + 1;
        $retval .= MicroTemplate::quick(PATH_LAYOUT, 'select_installation_method', $this->env);

        return $retval;
    }

    /**
     * Return if the current HTTP protocol is HTTPS
     *
     * @return bool
     */
    private function isHttps()
    {
        if (isset($_SERVER['HTTPS']) === true) {
            // Apache
            return ($_SERVER['HTTPS'] === 'on') || ($_SERVER['HTTPS'] === '1');
        } elseif (isset($_SERVER['SSL']) === true) {
            // IIS
            return ($_SERVER['SSL'] === 'on');
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) === true) {
            // Reverse proxy
            return (strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https');
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_PORT']) === true) {
            // Reverse proxy
            return ($_SERVER['HTTP_X_FORWARDED_PORT'] === '443');
        } elseif (isset($_SERVER['SERVER_PORT']) === true) {
            return ($_SERVER['SERVER_PORT'] === '443');
        }

        return false;
    }

    /**
     * Helper function: Derive 'site_url' from PHP_SELF
     *
     * @return string
     */
    private function getSiteUrl()
    {
        $url = str_replace('//', '/', $this->server('PHP_SELF'));
        $parts = explode('/', $url);
        $numParts = count($parts);

        if (($numParts < 3) || (substr($parts[$numParts - 1], -4) !== '.php')) {
            die('Fatal error - can not figure out my own URL');
        }

        $url = implode('/', array_slice($parts, 0, $numParts - 3));
        $protocol = $this->isHttps() ? 'https://' : 'http://';
        $url = $protocol . $this->server('HTTP_HOST') . $url;

        return $url;
    }

    /**
     * Helper function: Derive 'site_admin_url' from PHP_SELF
     *
     * @return string
     */
    private function getSiteAdminUrl()
    {
        $url = str_replace('//', '/', $this->server('PHP_SELF'));
        $parts = explode('/', $url);
        $numParts = count($parts);

        if (($numParts < 3) || (substr($parts[$numParts - 1], -4) !== '.php')) {
            die('Fatal error - can not figure out my own URL');
        }

        $url = implode('/', array_slice($parts, 0, $numParts - 2));
        $protocol = $this->isHttps() ? 'https://' : 'http://';
        $url = $protocol . $this->server('HTTP_HOST') . $url;

        return $url;
    }

    /**
     * Provide a link to the help page for an option
     *
     * @param   string $var key of the label, used as an anchor on the help page
     * @return  string          HTML for the link
     */
    public function getHelpLink($var)
    {
        global $LANG_HELP, $LANG_LABEL;

        $id = 'help-' . $var;

        return '<span uk-icon="icon: info" uk-tooltip="' . htmlentities($LANG_HELP[$var]) . '"</span>';
    }

    /**
     * Prepare a dropdown list of all available databases
     * Checks which driver classes and "tableanddata" files are actually present,
     * so that unwanted dbs can be removed (still requires special code all over the
     * place so you can't simply drop in new files to add support for new dbs).
     * If support for a database has not been compiled into PHP, the option will be
     * listed as disabled.
     *
     * @param  string $gl_path         base Geeklog install path
     * @param  string $selected_dbtype currently selected db type
     * @param  bool   $list_innodb     whether to list InnoDB option
     * @param  bool   $isInstall       whether to install or update
     * @return string
     * @throws Exception
     */
    private function listOfSupportedDBs($gl_path, $selected_dbtype, $list_innodb = false, $isInstall = true)
    {
        $retval = '';

        if (substr($gl_path, -strlen(self::DB_CONFIG_FILE)) === self::DB_CONFIG_FILE) {
            $gl_path = dirname($gl_path);
        }

        $dbs = array(
            'mysql'        => array(
                'file'  => 'mysql',
                'label' => $this->LANG['INSTALL'][35],
            ),
            'mysql-innodb' => array(
                'file'  => 'mysql',
                'label' => $this->LANG['INSTALL'][36],
            ),
            'pgsql'        => array(
                'file'  => 'pgsql',
                'label' => $this->LANG['INSTALL'][106],
            ),
        );

        // may not be needed as a separate option, e.g. for upgrades
        if (!$list_innodb) {
            unset($dbs['mysql-innodb']);
        }

        foreach ($dbs as $dbname => $info) {
            $prefix = $info['file'];

            if (file_exists($gl_path . '/sql/' . $prefix . '_tableanddata.php') &&
                file_exists($gl_path . '/system/databases/' . $prefix
                    . '.class.php')
            ) {
                if ($prefix === 'mysql') {
                    // check that the MySQLi driver file is also there so we
                    // don't have to check for it every time at runtime
                    if (!file_exists($gl_path . '/system/databases/'
                        . 'mysqli.class.php')
                    ) {
                        continue;
                    }
                }

                $retval .= '<option value="' . $dbname . '"';

                switch ($dbname) {
                    case 'mysql':
                    case 'mysql-innodb':
                        $shouldDisable = !is_callable('mysql_connect') && !is_callable('mysqli_connect');
                        break;

                    case 'pgsql':
                        $shouldDisable = !is_callable('pg_connect');
                        break;

                    default:
                        throw new Exception(__METHOD__ . ': unknown database type');
                        break;
                }

                if ($shouldDisable) {
                    $retval .= ' disabled="disabled"';
                    unset($dbs[$dbname]);
                } elseif ($dbname === $selected_dbtype) {
                    $retval .= ' selected="selected"';
                }

                $retval .= '>' . $info['label'] . '</option>' . PHP_EOL;
            } else {
                unset($dbs[$dbname]);
            }
        }

        if (count($dbs) === 0) {
            $retval = '<span class="uk-text-danger uk-text-emphasis">' . $this->LANG['INSTALL'][108] . '</span>' . PHP_EOL;
        } else {
            $disabled = $isInstall ? '' : ' disabled';
            $retval = '<select id="db_type" name="db_type"' . $disabled . ' class="uk-select uk-width-auto">' . PHP_EOL
                . $retval
                . '</select>' . PHP_EOL;

            if ($disabled) {
                $retval .= '<input type="hidden" name="db_type" value="' . $selected_dbtype . '">'
                    . PHP_EOL;
            }
        }

        return $retval;
    }

    /**
     * Upgrade any enabled plugins
     * NOTE: Needs a fully working Geeklog, so can only be done late in the upgrade
     *       process!
     *
     * @param  boolean $migration whether the upgrade is part of a site migration
     * @param  array   $old_conf  old $_CONF values before the migration
     * @return int     number of failed plugin updates (0 = everything's fine)
     * @see     PLG_upgrade
     * @see     PLG_migrate
     */
    private function upgradePlugins($migration = false, array $old_conf = array())
    {
        global $_TABLES;

        $failed = 0;

        $result = DB_query("SELECT pi_name, pi_version FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
        $numPlugins = DB_numRows($result);

        for ($i = 0; $i < $numPlugins; $i++) {
            list($pi_name, $pi_version) = DB_fetchArray($result);
            $success = true;

            if ($migration) {
                $success = PLG_migrate($pi_name, $old_conf);
            }

            if ($success === true) {
                $codeVersion = PLG_chkVersion($pi_name);

                if (!empty($codeVersion) && ($codeVersion != $pi_version)) {
                    $success = PLG_upgrade($pi_name);
                }
            }

            if ($success !== true) {
                // migration or upgrade failed - disable plugin
                DB_change($_TABLES['plugins'], 'pi_enabled', 0, 'pi_name', $pi_name);
                COM_errorLog("Migration or upgrade for '$pi_name' plugin failed - plugin disabled");
                $failed++;
            }
        }

        return $failed;
    }

    /**
     * Do the actual plugin auto install
     *
     * @param   string $plugin      Plugin name
     * @param   array  $inst_params Installation parameters for the plugin
     * @param   bool   $verbose     true: enable verbose logging
     * @return  bool             true on success, false otherwise
     */
    private function autoInstallPlugin($plugin, array $inst_params, $verbose = true)
    {
        global $_CONF, $_TABLES, $_USER, $_DB_dbms, $_DB_table_prefix;

        // Don't use 'include' or 'require' here! (bug #951)
        $this->includeConfig($this->env['dbconfig_path']);
        $fake_uid = false;

        if (!isset($_USER['uid'])) {
            $_USER['uid'] = 1;
            $fake_uid = false;
        }

        $basePath = $_CONF['path'] . 'plugins/' . $plugin . '/';

        if ($verbose) {
            COM_errorLog("Attempting to install the '{$plugin}' plugin", 1);
        }

        // sanity checks for $inst_params
        if (isset($inst_params['info'])) {
            $pi_name = $inst_params['info']['pi_name'];
            $pi_version = $inst_params['info']['pi_version'];
            $pi_gl_version = $inst_params['info']['pi_gl_version'];
            $pi_homepage = $inst_params['info']['pi_homepage'];
        }

        if (empty($pi_name) || ($pi_name !== $plugin) || empty($pi_version) ||
            empty($pi_gl_version) || empty($pi_homepage)
        ) {
            COM_errorLog('Incomplete plugin info', 1);

            return false;
        }

        // add plugin tables, if any
        if (!empty($inst_params['tables'])) {
            $tables = $inst_params['tables'];

            foreach ($tables as $table) {
                $_TABLES[$table] = $_DB_table_prefix . $table;
            }
        }

        // Create the plugin's group(s), if any
        $groups = array();
        $adminGroupId = 0;

        if (!empty($inst_params['groups'])) {
            $groups = $inst_params['groups'];

            foreach ($groups as $name => $desc) {
                if ($verbose) {
                    COM_errorLog("Attempting to create '$name' group", 1);
                }

                $grp_name = DB_escapeString($name);
                $grp_desc = DB_escapeString($desc);
                DB_query(
                    "INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) VALUES ('"
                    . DB_escapeString($grp_name) . "', '" . DB_escapeString($grp_desc) . "')",
                    1
                );

                if (DB_error()) {
                    COM_errorLog('Error creating plugin group', 1);
                    PLG_uninstall($plugin);

                    return false;
                }

                // keep the new group's ID for use in the mappings section (below)
                $groups[$name] = DB_insertId();

                // assume that the first group is the plugin's Admin group
                if ($adminGroupId == 0) {
                    $adminGroupId = $groups[$name];
                }
            }
        }

        // Create the plugin's table(s)
        $_SQL = array();
        $DEFVALUES = array();

        if (file_exists($basePath . 'sql/' . $_DB_dbms . '_install.php')) {
            require_once $basePath . 'sql/' . $_DB_dbms . '_install.php';
        }

        if (count($_SQL) > 0) {
            $useInnodb = false;

            if (($_DB_dbms === 'mysql') &&
                (DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'") === 'InnoDB')
            ) {
                $useInnodb = true;
            }

            $this->env['use_innodb'] = $useInnodb;

            foreach ($_SQL as $sql) {
                if ($useInnodb) {
                    $sql = preg_replace('/ENGINE\s*=\s*MyISAM/i', 'ENGINE=InnoDB ROW_FORMAT=DYNAMIC', $sql);
                }
                $sql = str_replace('#group#', $adminGroupId, $sql);
                DB_query($sql);

                if (DB_error()) {
                    COM_errorLog('Error creating plugin table', 1);
                    PLG_uninstall($plugin);

                    return false;
                }
            }
        }

        // Add the plugin's features
        if ($verbose) {
            COM_errorLog("Attempting to add '$plugin' features", 1);
        }

        $mappings = array();

        if (!empty($inst_params['features'])) {
            $features = $inst_params['features'];

            if (!empty($inst_params['mappings'])) {
                $mappings = $inst_params['mappings'];
            }

            foreach ($features as $feature => $desc) {
                $ft_name = DB_escapeString($feature);
                $ft_desc = DB_escapeString($desc);
                DB_query(
                    "INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
                    . "VALUES ('{$ft_name}', '{$ft_desc}')",
                    1
                );

                if (DB_error()) {
                    COM_errorLog('Error adding plugin feature', 1);
                    PLG_uninstall($plugin);

                    return false;
                }

                $feat_id = DB_insertId();

                if (isset($mappings[$feature])) {
                    foreach ($mappings[$feature] as $group) {
                        if ($verbose) {
                            COM_errorLog("Adding '$feature' feature to the '$group' group", 1);
                        }

                        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($feat_id, {$groups[$group]})");

                        if (DB_error()) {
                            COM_errorLog('Error mapping plugin feature', 1);
                            PLG_uninstall($plugin);

                            return false;
                        }
                    }
                }
            }
        }

        // Add plugin's Admin group to the Root user group
        // (assumes that the Root group's ID is always 1)
        if (count($groups) > 0) {
            if ($verbose) {
                COM_errorLog("Attempting to give all users in the Root group access to the '$plugin' Admin group", 1);
            }

            foreach ($groups as $key => $value) {
                DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES "
                    . "($adminGroupId, NULL, 1)");

                if (DB_error()) {
                    COM_errorLog('Error adding plugin admin group to Root group', 1);
                    PLG_uninstall($plugin);

                    return false;
                }
            }
        }

        // Pre-populate tables or run any other SQL queries
        if (count($DEFVALUES) > 0) {
            if ($verbose) {
                COM_errorLog('Inserting default data', 1);
            }

            foreach ($DEFVALUES as $sql) {
                $sql = str_replace('#group#', $adminGroupId, $sql);
                DB_query($sql, 1);

                if (DB_error()) {
                    COM_errorLog('Error adding plugin default data', 1);
                    PLG_uninstall($plugin);

                    return false;
                }
            }
        }

        // Load the online configuration records
        $load_config = 'plugin_load_configuration_' . $plugin;
        if (function_exists($load_config)) {
            if (!$load_config($plugin)) {
                COM_errorLog('Error loading plugin configuration', 1);
                PLG_uninstall($plugin);

                return false;
            }

            require_once $_CONF['path'] . 'system/classes/ConfigInterface.php';
            require_once $_CONF['path'] . 'system/classes/config.class.php';
            $config = config::get_instance();
            $config->initConfig(); // force re-reading, including new plugin conf
        }

        // Finally, register the plugin with Geeklog
        if ($verbose) {
            COM_errorLog("Registering '$plugin' plugin", 1);
        }

        // silently delete an existing entry
        DB_delete($_TABLES['plugins'], 'pi_name', $plugin);
        $plugin = DB_escapeString($plugin);
        $pi_version = DB_escapeString($pi_version);
        $pi_gl_version = DB_escapeString($pi_gl_version);
        $pi_homepage = DB_escapeString($pi_homepage);
        DB_query(
            "INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) "
            . "VALUES ('{$plugin}', '{$pi_version}', '{$pi_gl_version}', '{$pi_homepage}', 1)"
        );

        if (DB_error()) {
            COM_errorLog('Failed to register plugin', 1);
            PLG_uninstall($plugin);

            return false;
        }

        // give the plugin a chance to perform any post-install operations
        $postInstall = 'plugin_postinstall_' . $plugin;

        if (function_exists($postInstall)) {
            if (!$postInstall($plugin)) {
                COM_errorLog('Plugin postinstall failed', 1);
                PLG_uninstall($plugin);

                return false;
            }
        }

        if ($verbose) {
            COM_errorLog("Successfully installed the '$plugin' plugin!", 1);
        }

        if ($fake_uid) {
            unset($_USER['uid']);
        }

        return true;
    }

    /**
     * Do the actual plugin auto install
     *
     * @param    string  $plugin      Plugin name
     * @param    array   $inst_params Installation parameters for the plugin
     * @param    boolean $verbose     true: enable verbose logging
     * @return   boolean              true on success, false otherwise
     */
    public function pluginAutoInstall($plugin, $inst_params, $verbose = true)
    {
        global $_CONF, $_TABLES, $_USER, $_DB_dbms, $_DB_table_prefix;

        $fake_uid = false;
        if (!isset($_USER['uid'])) {
            $_USER['uid'] = 1;
            $fake_uid = false;
        }

        $base_path = $_CONF['path'] . 'plugins/' . $plugin . '/';

        if ($verbose) {
            COM_errorLog("Attempting to install the '$plugin' plugin", 1);
        }

        // sanity checks for $inst_params
        if (isset($inst_params['info'])) {
            $pi_name = $inst_params['info']['pi_name'];
            $pi_version = $inst_params['info']['pi_version'];
            $pi_gl_version = $inst_params['info']['pi_gl_version'];
            $pi_homepage = $inst_params['info']['pi_homepage'];
        }
        if (empty($pi_name) || ($pi_name != $plugin) || empty($pi_version) ||
            empty($pi_gl_version) || empty($pi_homepage)
        ) {
            COM_errorLog('Incomplete plugin info', 1);

            return false;
        }

        // add plugin tables, if any
        if (!empty($inst_params['tables'])) {
            $tables = $inst_params['tables'];
            foreach ($tables as $table) {
                $_TABLES[$table] = $_DB_table_prefix . $table;
            }
        }

        // Create the plugin's group(s), if any
        $groups = array();
        $admin_group_id = 0;
        if (!empty($inst_params['groups'])) {
            $groups = $inst_params['groups'];
            foreach ($groups as $name => $desc) {
                if ($verbose) {
                    COM_errorLog("Attempting to create '$name' group", 1);
                }

                $grp_name = DB_escapeString($name);
                $grp_desc = DB_escapeString($desc);
                DB_query("INSERT INTO {$_TABLES['groups']} (grp_name, grp_descr) VALUES ('$grp_name', '$grp_desc')", 1);
                if (DB_error()) {
                    COM_errorLog('Error creating plugin group', 1);
                    PLG_uninstall($plugin);

                    return false;
                }

                // keep the new group's ID for use in the mappings section (below)
                $groups[$name] = DB_insertId();

                // assume that the first group is the plugin's Admin group
                if ($admin_group_id == 0) {
                    $admin_group_id = $groups[$name];
                }
            }
        }

        // Create the plugin's table(s)
        $_SQL = array();
        $DEFVALUES = array();
        if (file_exists($base_path . 'sql/' . $_DB_dbms . '_install.php')) {
            require_once $base_path . 'sql/' . $_DB_dbms . '_install.php';
        }

        if (count($_SQL) > 0) {
            $use_innodb = false;
            if (($_DB_dbms === 'mysql') &&
                (DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'") === 'InnoDB')
            ) {
                $use_innodb = true;
            }

            foreach ($_SQL as $sql) {
                if ($use_innodb) {
                    $sql = preg_replace('/ENGINE\s*=\s*MyISAM/i', 'ENGINE=InnoDB ROW_FORMAT=DYNAMIC', $sql);
                }
                $sql = str_replace('#group#', $admin_group_id, $sql);
                DB_query($sql);
                if (DB_error()) {
                    COM_errorLog('Error creating plugin table', 1);
                    PLG_uninstall($plugin);

                    return false;
                }
            }
        }

        // Add the plugin's features
        if ($verbose) {
            COM_errorLog("Attempting to add '$plugin' features", 1);
        }

        $features = array();
        $mappings = array();
        if (!empty($inst_params['features'])) {
            $features = $inst_params['features'];
            if (!empty($inst_params['mappings'])) {
                $mappings = $inst_params['mappings'];
            }

            foreach ($features as $feature => $desc) {
                $ft_name = DB_escapeString($feature);
                $ft_desc = DB_escapeString($desc);
                DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) "
                    . "VALUES ('$ft_name', '$ft_desc')", 1);
                if (DB_error()) {
                    COM_errorLog('Error adding plugin feature', 1);
                    PLG_uninstall($plugin);

                    return false;
                }

                $feat_id = DB_insertId();

                if (isset($mappings[$feature])) {
                    foreach ($mappings[$feature] as $group) {
                        if ($verbose) {
                            COM_errorLog("Adding '$feature' feature to the '$group' group", 1);
                        }

                        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($feat_id, {$groups[$group]})");
                        if (DB_error()) {
                            COM_errorLog('Error mapping plugin feature', 1);
                            PLG_uninstall($plugin);

                            return false;
                        }
                    }
                }
            }
        }

        // Add plugin's Admin group to the Root user group
        // (assumes that the Root group's ID is always 1)
        if (count($groups) > 0) {
            if ($verbose) {
                COM_errorLog("Attempting to give all users in the Root group access to the '$plugin' Admin group", 1);
            }

            foreach ($groups as $key => $value) {
                DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES "
                    . "($admin_group_id, NULL, 1)");
                if (DB_error()) {
                    COM_errorLog('Error adding plugin admin group to Root group', 1);
                    PLG_uninstall($plugin);

                    return false;
                }
            }
        }

        // Pre-populate tables or run any other SQL queries
        if (count($DEFVALUES) > 0) {
            if ($verbose) {
                COM_errorLog('Inserting default data', 1);
            }
            foreach ($DEFVALUES as $sql) {
                $sql = str_replace('#group#', $admin_group_id, $sql);
                DB_query($sql, 1);
                if (DB_error()) {
                    COM_errorLog('Error adding plugin default data', 1);
                    PLG_uninstall($plugin);

                    return false;
                }
            }
        }

        // Load the online configuration records
        $load_config = 'plugin_load_configuration_' . $plugin;
        if (function_exists($load_config)) {
            if (!$load_config($plugin)) {
                COM_errorLog('Error loading plugin configuration', 1);
                PLG_uninstall($plugin);

                return false;
            }

            require_once $_CONF['path'] . 'system/classes/ConfigInterface.php';
            require_once $_CONF['path'] . 'system/classes/config.class.php';
            $config = config::get_instance();
            $config->initConfig(); // force re-reading, including new plugin conf
        }

        // Finally, register the plugin with Geeklog
        if ($verbose) {
            COM_errorLog("Registering '$plugin' plugin", 1);
        }

        // silently delete an existing entry
        DB_delete($_TABLES['plugins'], 'pi_name', $plugin);

        DB_query("INSERT INTO {$_TABLES['plugins']} (pi_name, pi_version, pi_gl_version, pi_homepage, pi_enabled) VALUES "
            . "('$plugin', '$pi_version', '$pi_gl_version', '$pi_homepage', 1)");

        if (DB_error()) {
            COM_errorLog('Failed to register plugin', 1);
            PLG_uninstall($plugin);

            return false;
        }

        // give the plugin a chance to perform any post-install operations
        $post_install = 'plugin_postinstall_' . $plugin;
        if (function_exists($post_install)) {
            if (!$post_install($plugin)) {
                COM_errorLog('Plugin postinstall failed', 1);
                PLG_uninstall($plugin);

                return false;
            }
        }

        if ($verbose) {
            COM_errorLog("Successfully installed the '$plugin' plugin!", 1);
        }

        if ($fake_uid) {
            unset($_USER['uid']);
        }

        return true;
    }

    /**
     * Pick up and install any new plugins
     * Search for plugins that exist in the filesystem but are not registered with
     * Geeklog. If they support auto install, install them now.
     */
    private function autoInstallNewPlugins()
    {
        global $_CONF, $_TABLES, $_DB_dbms, $_DB_table_prefix;

        $newPlugins = array();
        clearstatcache();

        foreach (glob($_CONF['path'] . 'plugins/*') as $path) {
            $plugin = basename($path);

            if (DB_count($_TABLES['plugins'], 'pi_name', $plugin) == 0) {
                // found a new plugin: remember name, keep on searching
                $newPlugins[] = $plugin;
            }

        }

        // automatically install all new plugins that come with a autoinstall.php
        foreach ($newPlugins as $pi_name) {
            $plugin_inst = $_CONF['path'] . 'plugins/' . $pi_name . '/autoinstall.php';

            if (file_exists($plugin_inst)) {
                require_once $plugin_inst;

                $check_compatible = 'plugin_compatible_with_this_version_' . $pi_name;

                if (function_exists($check_compatible)) {
                    if (!$check_compatible($pi_name)) {
                        continue; // with next plugin
                    }
                }

                $auto_install = 'plugin_autoinstall_' . $pi_name;

                if (!function_exists($auto_install)) {
                    continue; // with next plugin
                }

                $inst_params = $auto_install($pi_name);

                if (($inst_params === false) || empty($inst_params)) {
                    continue; // with next plugin
                }

                $this->autoInstallPlugin($pi_name, $inst_params);
            }
        }
    }

    /**
     * Check if URL exists
     * NOTE:    This code is a modified copy from marufit at gmail dot com
     *
     * @param   string $url URL
     * @return  bool         True if URL exists, false if not
     */
    private function urlExists($url)
    {
        /*
            $handle = curl_init($url);
            if ($handle === false) {
                return false;
            }
            curl_setopt($handle, CURLOPT_HEADER, false);
            curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
            curl_setopt($handle, CURLOPT_NOBODY, true);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
            $response = curl_exec($handle);
            curl_close($handle);
            return $response;
        */
        return true;
    }

    /**
     * Returns the HTML form to return the user's inputted data to the
     * previous page.
     *
     * @param  array $postData
     * @return string  HTML form code.
     */
    private function showReturnFormData(array $postData)
    {
        $this->env['req_display_step'] = $this->request('display_step');
        $this->env['postData'] = $postData;
        $retval = MicroTemplate::quick(PATH_LAYOUT, 'return_form_data', $this->env);

        return $retval;
    }

    /**
     * Check for blank database password in production environment
     *
     * @param   string $site_url The site's URL
     * @param   array  $db       Database    information
     * @return  bool                 True if password is set or it is a local server
     */
    private function checkDbPassword($site_url, array $db)
    {
        if (!empty($db['pass']) ||
            (isset($site_url) && (strpos($site_url, '127.0.0.1') !== false) || (strpos($site_url, 'localhost') !== false))
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Can the install script connect to the database?
     *
     * @param   array $db Database information
     * @return  mixed     Returns the DB handle if true, false if not
     */
    private function dbConnect($db)
    {
        $dbHandle = false;

        switch ($db['type']) {
            case 'mysql-innodb':
                // deliberate fallthrough - no "break"
            case 'mysql':
                if (is_callable('mysqli_connect')) {
                    $dbHandle = @mysqli_connect($db['host'], $db['user'], $db['pass']);

                    if (!$dbHandle instanceof mysqli) {
                        $dbHandle = false;
                    }
                } elseif (is_callable('mysql_connect')) {
                    $dbHandle = @mysql_connect($db['host'], $db['user'], $db['pass']);
                }

                break;

            case 'pgsql':
                $dbHandle = @pg_connect('host=' . $db['host'] . ' dbname=' . $db['name'] . ' user=' . $db['user'] . ' password=' . $db['pass']);
                break;
        }

        return $dbHandle;
    }

    /**
     * Return the MySQL version
     *
     * @param  string $host
     * @param  string $user
     * @param  string $pass
     * @return array|false   array[0..2] of the parts of the version number or false
     */
    private function getMysqlVersion($host, $user, $pass)
    {
        if (is_callable('mysqli_connect')) {
            $dbHandle = @mysqli_connect($host, $user, $pass);

            if (!$dbHandle instanceof mysqli) {
                return false;
            }

            $version = $dbHandle->server_info;
            $dbHandle->close();
        } elseif (is_callable('mysql_connect')) {
            $dbHandle = @mysql_connect($host, $user, $pass);

            if ($dbHandle === false) {
                return false;
            }

            $version = @mysql_get_server_info($dbHandle);
            @mysql_close($dbHandle);

            if ($version === false) {
                return false;
            }
        } else {
            return false;
        }

        if (preg_match('/^([0-9]+).([0-9]+).([0-9]+)/', $version, $match)) {
            return array($match[1], $match[2], $match[3]);
        } else {
            return array(0, 0, 0);
        }
    }

    /**
     * Check if the user's MySQL version is supported by Geeklog
     *
     * @param   array $db Database information
     * @return  bool True if supported, false if not supported
     */
    private function isMysqlOutOfDate(array $db)
    {
        if ($db['type'] === 'mysql' || $db['type'] === 'mysql-innodb') {
            $minVersion = explode('.', self::SUPPORTED_MYSQL_VER);
            $myVersion = $this->getMysqlVersion($db['host'], $db['user'], $db['pass']);

            if (($myVersion[0] < $minVersion[0]) ||
                (($myVersion[0] == $minVersion[0]) && ($myVersion[1] < $minVersion[1])) ||
                (($myVersion[0] == $minVersion[0]) && ($myVersion[1] == $minVersion[1]) && ($myVersion[2] < $minVersion[2]))
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a Geeklog database exists
     *
     * @param   array $db Array containing connection info
     * @return  bool      True if a database exists, false if not
     */
    private function dbExists(array $db)
    {
        $dbHandle = $this->dbConnect($db);
        $retval = false;

        if ($dbHandle !== false) {
            switch ($db['type']) {
                case 'mysql':
                    // deliberate fallthrough - no "break"
                case 'mysql-innodb':
                    if ($dbHandle instanceof mysqli) {
                        $retval = $dbHandle->select_db($db['name']);
                        $dbHandle->close();
                    } else {
                        $retval = @mysql_select_db($db['name'], $dbHandle);
                        @mysql_close($dbHandle);
                    }

                    break;

                case 'pgsql':
                    $result = @pg_query(
                        $dbHandle,
                        'SELECT COUNT(*) FROM pg_catalog.pg_database WHERE datname = \'' . $db['name'] . '\' ;'
                    );
                    $ifExists = pg_fetch_row($result);
                    $retval = $ifExists[0] ? true : false;
                    @pg_close($dbHandle);
            }
        }

        return $retval;
    }

    /**
     * Modify db-config.php
     *
     * @param   string $dbConfigFilePath Full path to db-config.php
     * @param   array  $db               Database information to save
     * @return  bool True if successful, false if not
     */
    private function writeConfig($dbConfigFilePath, array $db)
    {
        // We may have included db-config.php elsewhere already, in which case
        // all of these variables need to be imported from the global namespace
        global $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix,
               $_DB_dbms, $_DB_charset;

        require_once $dbConfigFilePath; // Grab the current DB values

        $isUtf8 = false;

        if (!empty($_DB_charset)) {
            $isUtf8 = ($_DB_charset === 'utf8') || ($_DB_charset === 'utf8mb4');
        } elseif (isset($db['utf8'])) {
            $isUtf8 = $db['utf8'];
        }

        $db = array(
            'host'         => (isset($db['host']) ? $db['host'] : $_DB_host),
            'name'         => (isset($db['name']) ? $db['name'] : $_DB_name),
            'user'         => (isset($db['user']) ? $db['user'] : $_DB_user),
            'pass'         => (isset($db['pass']) ? $db['pass'] : $_DB_pass),
            'table_prefix' => (isset($db['table_prefix']) ? $db['table_prefix'] : $_DB_table_prefix),
            'type'         => (isset($db['type']) ? $db['type'] : $_DB_dbms),
        );

        if ($db['type'] === 'mysql-innodb') {
            $db['type'] = 'mysql';
        }

        // Read in db-config.php so we can insert the DB information
        clearstatcache();
        $dbConfigData = @file_get_contents($dbConfigFilePath);

        // Replace the values with the new ones
        $dbConfigData = str_replace("\$_DB_host = '" . $_DB_host . "';", "\$_DB_host = '" . $db['host'] . "';", $dbConfigData); // Host
        $dbConfigData = str_replace("\$_DB_name = '" . $_DB_name . "';", "\$_DB_name = '" . $db['name'] . "';", $dbConfigData); // Database
        $dbConfigData = str_replace("\$_DB_user = '" . $_DB_user . "';", "\$_DB_user = '" . $db['user'] . "';", $dbConfigData); // Username
        $dbConfigData = str_replace("\$_DB_pass = '" . $_DB_pass . "';", "\$_DB_pass = '" . $db['pass'] . "';", $dbConfigData); // Password
        $dbConfigData = str_replace("\$_DB_table_prefix = '" . $_DB_table_prefix . "';", "\$_DB_table_prefix = '" . $db['table_prefix'] . "';", $dbConfigData); // Table prefix
        $dbConfigData = str_replace("\$_DB_dbms = '" . $_DB_dbms . "';", "\$_DB_dbms = '" . $db['type'] . "';", $dbConfigData); // Database type ('mysql' or 'pgsql')

        if (($db['type'] === 'mysql') && $isUtf8 && version_compare(self::GL_VERSION, '2.1.2', '>=') &&
            (!empty($_DB_charset) || ($this->env['mode'] === 'install'))
        ) {
            if (!empty($_DB_charset)) {
                $db['charset'] = $_DB_charset;
            } else {
                require_once __DIR__ . '/db.class.php';
                $dbTypes = Geeklog\Db::getDrivers();

                if (in_array(Geeklog\Db::DB_MYSQLI, $dbTypes)) {
                    $driver = Geeklog\Db::connect(Geeklog\Db::DB_MYSQLI, $db);
                } else {
                    $driver = Geeklog\Db::connect(Geeklog\Db::DB_MYSQL, $db);
                }

                $db['charset'] = ($driver->getVersion() >= 50503) ? 'utf8mb4' : 'utf8';
            }

            $dbConfigData = str_replace("\$_DB_charset = '" . $_DB_charset . "';", "\$_DB_charset = '" . $db['charset'] . "';", $dbConfigData); // Charset
        }

        // Write our changes to db-config.php
        $result = (@file_put_contents($dbConfigFilePath, $dbConfigData, LOCK_EX) !== false);

        return $result;
    }

    /**
     * Make sure to include(require) db-config.php
     *
     * NOTE: In Ubuntu OS (maybe also in similar Linux distros), when include
     * db-config.php right after the writeConfig method is called, the read value is
     * equal to the value before being changed by the writeConfig method, and an error
     * occurs on installation because it is different from the DB information.
     * This method is to make sure to read the value changed by the writeConfig method.
     *
     * @param string $dbConfigFilePath Full path to db-config.php
     */
    private function includeConfig($dbConfigFilePath)
    {
        global $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix,
               $_DB_dbms, $_DB_charset;

        $dbConfigData = @file_get_contents($dbConfigFilePath);
        $dbConfigData = str_replace('<' . '?php', '', $dbConfigData);
        eval($dbConfigData);
    }

    /**
     * Change default character set to UTF-8
     * NOTE:    Yes, this means that we need to patch siteconfig.php a second time.
     *
     * @param   string $siteConfigFilePath complete path to siteconfig.php
     * @param   string $charset            default character set to use
     * @return  bool                       true: success; false: an error occurred
     */
    private function setDefaultCharset($siteConfigFilePath, $charset)
    {
        clearstatcache();
        $siteConfigData = @file_get_contents($siteConfigFilePath);
        $siteConfigData = preg_replace(
            '/\$_CONF\[\'default_charset\'\] = \'[^\']*\';/',
            "\$_CONF['default_charset'] = '" . $charset . "';",
            $siteConfigData
        );
        $result = (@file_put_contents($siteConfigFilePath, $siteConfigData) !== false);

        return $result;
    }

    /**
     * Check for InnoDB table support (usually as of MySQL 4.0, but may be
     * available in earlier versions, e.g. "Max" or custom builds).
     *
     * @return  bool true = InnoDB tables supported, false = not supported
     */
    private function isInnodbSupported()
    {
        $retval = false;

        $result = DB_query("SHOW ENGINES");
        $numEngines = DB_numRows($result);

        for ($i = 0; $i < $numEngines; $i++) {
            $A = DB_fetchArray($result);

            if (strcasecmp($A['Engine'], 'InnoDB') === 0) {
                if ((strcasecmp($A['Support'], 'yes') === 0) ||
                    (strcasecmp($A['Support'], 'default') === 0)
                ) {
                    $retval = true;
                }

                break;
            }
        }

        return $retval;
    }

    /**
     * Get the current installed version of Geeklog
     *
     * @return  string  Geeklog version in x.x.x format
     */
    private function identifyGeeklogVersion()
    {
        global $_TABLES, $_DB, $_DB_dbms;

        $_DB->setDisplayError(true);
        $version = '';

        /**
         * First check for 'database_version' in gl_vars. If that exists, assume
         * it's the correct version. Else, try some heuristics (below).
         * Note: Need to handle 'sr1' etc. appendices.
         */
        if (DB_checkTableExists('vars')) {
            $dbVersion = DB_getItem($_TABLES['vars'], 'value', "name = 'database_version'");

            if (!empty($dbVersion)) {
                $v = explode('.', $dbVersion);

                if (count($v) === 3) {
                    $v[2] = (int) $v[2];
                    $version = implode('.', $v);

                    return $version;
                }
            }
        }

        // simple tests for the version of the database:
        // "DESCRIBE sometable somefield", ''
        //  => just test that the field exists
        // "DESCRIBE sometable somefield", 'somefield,sometype'
        //  => test that the field exists and is of the given type
        //
        // Should always include a test for the current version so that we can
        // warn the user if they try to run the update again.

        switch ($_DB_dbms) {
            case 'mysql':
                $tests = array(
                    // as of 1.5.1, we should have the 'database_version' entry
                    '1.5.0'  => array("DESCRIBE {$_TABLES['storysubmission']} bodytext", ''),
                    '1.4.1'  => array("SELECT ft_name FROM {$_TABLES['features']} WHERE ft_name = 'syndication.edit'", 'syndication.edit'),
                    '1.4.0'  => array("DESCRIBE {$_TABLES['users']} remoteusername", ''),
                    '1.3.11' => array("DESCRIBE {$_TABLES['comments']} sid", 'sid,varchar(40)'),
                    '1.3.10' => array("DESCRIBE {$_TABLES['comments']} lft", ''),
                    '1.3.9'  => array("DESCRIBE {$_TABLES['syndication']} fid", ''),
                    '1.3.8'  => array("DESCRIBE {$_TABLES['userprefs']} showonline", '')
                    // It's hard to (reliably) test for 1.3.7 - let's just hope
                    // nobody uses such an old version any more ...
                );
                $firstCheck = "DESCRIBE {$_TABLES['access']} acc_ft_id";
                $result = DB_query($firstCheck, 1);

                if ($result === false) {
                    // A check for the first field in the first table failed?
                    // Sounds suspiciously like an empty table ...
                    return 'empty';
                }

                break;

            default:
                // @TODO not implemented for pgsql
                $tests = array();
                break;
        }

        foreach ($tests as $v => $queries) {
            $result = DB_query($queries[0], 1);

            if ($result === false) {
                // error - continue with next test
            } elseif (DB_numRows($result) > 0) {
                $A = DB_fetchArray($result);

                if (empty($queries[1])) {
                    // test only for existence of field - succeeded
                    $version = $v;
                    break;
                } else {
                    if (substr($queries[0], 0, 6) === 'SELECT') {
                        // text for a certain value
                        if ($A[0] == $queries[1]) {
                            $version = $v;
                            break;
                        }
                    } else {
                        // test for certain type of field
                        $tst = explode(',', $queries[1]);

                        if (($A['Field'] == $tst[0]) && ($A['Type'] == $tst[1])) {
                            $version = $v;
                            break;
                        }
                    }
                }
            }
        }

        return $version;
    }

    /**
     * Check if a table exists
     *
     * @param   string $table Table name
     * @return  bool         True if table exists, false if it does not
     * @see     DB_checkTableExists
     */
    private function tableExists($table)
    {
        return DB_checkTableExists($table);
    }

    /**
     * Run all the database queries from the update file.
     *
     * @param  array  $_SQL Array of queries to perform
     * @param  string $progress
     */
    private function updateDB(array $_SQL, &$progress)
    {
        foreach ($_SQL as $sql) {
            $progress .= "executing {$sql}<br>" . PHP_EOL;
            DB_query($sql);
        }
    }

    /**
     * Sets up the database tables
     *
     * @return  bool True if successful
     */
    private function createDatabaseStructures()
    {
        global $_CONF, $_TABLES, $_DB, $_DB_dbms, $_DB_host, $_DB_user, $_DB_pass;

        $_DB->setDisplayError(true);

        // Because the create table syntax can vary from dbms-to-dbms we are
        // leaving that up to each database driver (e.g. mysql.class.php,
        // postgresql.class.php, etc)

        // Get DBMS-specific create table array and data array
        $_SQL = array();
        $_DATA = array();
        $dbTableAndDataPath = $_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php';

        $progress = '';

        if ($this->tableExists('access')) {
            return false;
        }

        switch ($_DB_dbms) {
            case 'mysql':
                if ($this->env['use_innodb']) {
                    $dbTableAndData = @file_get_contents($dbTableAndDataPath);
                    $dbTableAndData = str_replace('<' . '?php', '', $dbTableAndData);
                    $dbTableAndData = preg_replace('/ENGINE\s*=\s*MyISAM/i', 'ENGINE=InnoDB ROW_FORMAT=DYNAMIC', $dbTableAndData);
                    eval($dbTableAndData);
                } else {
                    require_once $dbTableAndDataPath;
                }

                $this->updateDB($_SQL, $progress);

                if ($this->env['use_innodb']) {
                    DB_query("INSERT INTO {$_TABLES['vars']} (name, value) VALUES ('database_engine', 'InnoDB')");
                }

                break;

            case 'pgsql':
                require_once $dbTableAndDataPath;
                foreach ($_SQL as $sql) {
                    $_DB->dbQuery($sql, 0, 1);
                }
                break;

            default:
                die("Unknown DB type '$_DB_dbms'");
                break;
        }

        // Now insert mandatory data and a small subset of initial data
        foreach ($_DATA as $data) {
            $progress .= "executing {$data}<br>" . PHP_EOL;
            DB_query($data);
        }

        return true;
    }

    /**
     * On a fresh install, set the Admin's account email and homepage
     *
     * @param   string $site_mail email address, e.g. the site email
     * @param   string $site_url  the site's URL
     */
    private function personalizeAdminAccount($site_mail, $site_url)
    {
        global $_TABLES, $_DB_dbms;

        if (($_DB_dbms === 'mysql') || ($_DB_dbms === 'pgsql')) {
            // let's try and personalize the Admin account a bit ...
            if (!empty($site_mail)) {
                if (strpos($site_mail, 'example.com') === false) {
                    DB_query("UPDATE {$_TABLES['users']} SET email = '" . DB_escapeString($site_mail) . "' WHERE uid = 2");
                }
            }

            if (!empty($site_url)) {
                if (strpos($site_url, 'example.com') === false) {
                    DB_query("UPDATE {$_TABLES['users']} SET homepage = '" . DB_escapeString($site_url) . "' WHERE uid = 2");
                }
            }
        }
    }

    /**
     * Returns a cleaned string
     *
     * @param  string $str
     * @return string
     */
    private function cleanString($str)
    {
        $str = preg_replace('/[[:cntrl:]]/', '', $str);
        $str = strip_tags($str);

        return $str;
    }

    /**
     * Returns a cookie path for a site URL
     *
     * @param   string $site_url site URL
     * @return  string               a cookie path
     */
    private function guessCookiePath($site_url)
    {
        $retval = '/';

        if (preg_match('|(^https?://[^/]+)|i', $site_url, $match)) {
            $path = substr($site_url, strlen($match[1]));

            if (($path !== '') && ($path !== false)) {
                $retval = $path;

                if (substr($retval, -1) !== '/') {
                    $retval .= '/';
                }
            }
        }

        return $retval;
    }

    /**
     * Derive site's default language from available information
     *
     * @return   string  name of default language (for the config)
     */
    private function getDefaultLanguage()
    {
        $languagesFromUserAgent = $this->getLanguagesFromUserAgent();

        if (count($languagesFromUserAgent) > 0) {
            foreach ($languagesFromUserAgent as $languageFromUserAgent) {
                if (strpos($languageFromUserAgent, '_') !== false) {
                    $languageFromUserAgent = str_replace('_', '-', $languageFromUserAgent);
                }

                foreach ($this->languages as $languageFileName => $data) {
                    $languageFileName = str_ireplace('.php', '', $languageFileName);

                    if (strcasecmp($data['langCode'], $languageFromUserAgent) === 0) {
                        return $languageFileName;
                    }

                    if (strpos($languageFromUserAgent, '-')) {
                        list ($country, ) = explode('-', $languageFromUserAgent, 2);

                        if (strcasecmp($data['langCode'], $country) === 0) {
                            return $languageFileName;
                        }
                    }
                }
            }
        }

        return self::DEFAULT_LANGUAGE;
    }

    /**
     * Set Geeklog version number in siteconfig.php and in the database
     *
     * @param   string $siteConfigFilePath path to siteconfig.php
     */
    private function setVersion($siteConfigFilePath)
    {
        global $_TABLES;

        $siteConfigData = @file_get_contents($siteConfigFilePath);
        $siteConfigData = preg_replace(
            '/define\s*\(\'VERSION\',[^;]*;/',
            "define('VERSION', '" . self::GL_VERSION . "');",
            $siteConfigData
        );

        if (@file_put_contents($siteConfigFilePath, $siteConfigData) === false) {
            exit($this->LANG['INSTALL'][26] . ' ' . $this->LANG['INSTALL'][28]);
        }

        // for the database version, get rid of any appendices ('sr1' etc.)
        $version = self::GL_VERSION;
        $v = explode('.', self::GL_VERSION);

        if (count($v) === 3) {
            $v[2] = (int) $v[2];
            $version = implode('.', $v);
        }

        $version = DB_escapeString($version);
        DB_change($_TABLES['vars'], 'value', $version, 'name', 'database_version');
    }

    /**
     * Handle default install of available plugins
     * Picks up and installs all plugins with an autoinstall.php.
     * Any errors are silently ignored ...
     */
    private function defaultPluginInstall()
    {
        if (!function_exists('COM_errorLog')) {
            // "Emergency" version of COM_errorLog
            function COM_errorLog($a, $b = '')
            {
                return '';
            }
        }

        $this->autoInstallNewPlugins();
    }

    /**
     * Get information about a plugin
     * Only works for plugins that have a autoinstall.php file
     *
     * @param  string $plugin plugin's directory name
     * @return array|false         array of plugin info or false: error
     */
    public function getPluginInfo($plugin)
    {
        global $_CONF, $_TABLES, $_DB_dbms, $_DB_table_prefix;

        $info = false;

        $autoInstall = $_CONF['path'] . 'plugins/' . $plugin . '/autoinstall.php';
        if (!file_exists($autoInstall)) {
            return false;
        }

        include_once $autoInstall;

        $fn = 'plugin_autoinstall_' . $plugin;

        if (function_exists($fn)) {
            $inst_info = $fn($plugin);
            if (isset($inst_info['info']) && !empty($inst_info['info']['pi_name'])) {
                $info = $inst_info['info'];
            }
        }

        return $info;
    }

    /**
     * Checks for Static Pages Version
     * Note: Needed for upgrades from old versions - don't remove.
     *
     * @return int indicates which version of the plugin we're dealing with:
     *             - 0 = not installed,
     *             - 1 = original plugin,
     *             - 2 = version by Phill or Tom,
     *             - 3 = v1.3 (center block, etc.),
     *             - 4 = v1.4 ('in block' flag)
     */
    private function getStaticPagesVersion()
    {
        global $_TABLES;

        $retval = 0;

        if (DB_count($_TABLES['plugins'], 'pi_name', 'staticpages') > 0) {
            $result = DB_query("DESCRIBE {$_TABLES['staticpage']}");
            $numRows = DB_numRows($result);
            $retval = 1; // assume v1.1 for now ...

            for ($i = 0; $i < $numRows; $i++) {
                $A = DB_fetchArray($result, true);

                if ($A[0] === 'sp_nf') {
                    $retval = 3; // v1.3
                } elseif ($A[0] === 'sp_pos') {
                    $retval = 2; // v1.2
                } elseif ($A[0] === 'sp_inblock') {
                    $retval = 4; // v1.4
                    break;
                }
            }
        }

        return $retval;
    }

    /**
     * Make sure optional config options can be disabled
     * Back when Geeklog used a config.php file, some of the comment options were
     * commented out, i.e. they were optional. Make sure those options can still be
     * disabled from the Configuration admin panel.
     */
    private function fixOptionalConfig()
    {
        global $_TABLES;

        // list of optional config options
        $optionalConfig = array(
            'copyrightyear', 'debug_image_upload', 'default_photo',
            'force_photo_width', 'gravatar_rating', 'ip_lookup', 'language_files',
            'languages', 'path_to_mogrify', 'path_to_netpbm',
        );

        foreach ($optionalConfig as $name) {
            $result = DB_query("SELECT value, default_value FROM {$_TABLES['conf_values']} WHERE name = '$name'");
            list($value, $defaultValue) = DB_fetchArray($result);

            if ($value != 'unset') {
                if (substr($defaultValue, 0, 6) != 'unset:') {
                    $unset = DB_escapeString('unset:' . $defaultValue);
                    DB_query("UPDATE {$_TABLES['conf_values']} SET default_value = '$unset' WHERE name = '$name'");
                }
            }
        }
    }


    /**
     * Perform database upgrades
     *
     * @param  string $currentGlVersion Current Geeklog version
     * @param  bool   $checkForMessage
     * @return bool                     True if successful
     */
    private function doDatabaseUpgrades($currentGlVersion, $checkForMessage = false)
    {
        global $_TABLES, $_CONF, $_SP_CONF, $_DB, $_DB_dbms, $_DB_table_prefix;

        // Upgrade messages only supported for Geeklog 2.1.2 and higher
        if ($checkForMessage && (version_compare($currentGlVersion, '2.1.1') < 0)) {
            $currentGlVersion = '2.1.1';
        }

        // Don't do this if just checking for upgrade messages
        if (!$checkForMessage) {
            $_DB->setDisplayError(true);
        }

        // Because the upgrade sql syntax can vary from dbms-to-dbms we are
        // leaving that up to each Geeklog database driver
        $done = false;
        $progress = '';
        DB_setMysqlSqlMode(Database::MYSQL_SQL_MODE_NONE);
        $_SQL = array();

        while (!$done) {
            switch ($currentGlVersion) {
                case '1.2.5-1':
                    // Get DMBS-specific update sql
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.2.5-1_to_1.3.php';
                    $this->updateDB($_SQL, $progress);

                    // OK, now we need to add all users except anonymous to the All Users group and Logged in users group
                    // I can hard-code these group numbers because the group table was JUST created with these numbers
                    $result = DB_query("SELECT uid FROM {$_TABLES['users']} WHERE uid <> 1");
                    $numRows = DB_numRows($result);

                    for ($i = 1; $i <= $numRows; $i++) {
                        $U = DB_fetchArray($result);
                        DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES (2, {$U['uid']}, NULL)");
                        DB_query("INSERT INTO {$_TABLES['group_assignments']} VALUES (13, {$U['uid']}, NULL)");
                    }

                    // Now take care of any orphans off the user table...and let me curse MySQL lack for supporting foreign
                    // keys at this time ;-)
                    $result = DB_query("SELECT MAX(uid) FROM {$_TABLES['users']}");
                    $ITEM = DB_fetchArray($result);
                    $max_uid = $ITEM[0];

                    if (!empty($max_uid) && ($max_uid != 0)) {
                        DB_query("DELETE FROM {$_TABLES['userindex']} WHERE uid > $max_uid");
                        DB_query("DELETE FROM {$_TABLES['userinfo']} WHERE uid > $max_uid");
                        DB_query("DELETE FROM {$_TABLES['userprefs']} WHERE uid > $max_uid");
                        DB_query("DELETE FROM {$_TABLES['usercomment']} WHERE uid > $max_uid");
                    }

                    $currentGlVersion = '1.3';
                    $_SQL = array();
                    break;

                case '1.3':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3_to_1.3.1.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.3.1';
                    $_SQL = array();
                    break;

                case '1.3.1':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.1_to_1.3.2.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.3.2-1';
                    $_SQL = array();
                    break;

                case '1.3.2':
                case '1.3.2-1':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.2-1_to_1.3.3.php';
                    $this->updateDB($_SQL, $progress);

                    // Now we need to switch how user blocks are stored.  Right now we only store the blocks the
                    // user wants.  This will switch it to store the ones they don't want which allows us to add
                    // new blocks and ensure they are shown to the user.
                    $result = DB_query("SELECT {$_TABLES['users']}.uid,boxes FROM {$_TABLES['users']},{$_TABLES['userindex']} WHERE boxes IS NOT NULL AND boxes <> '' AND {$_TABLES['users']}.uid = {$_TABLES['userindex']}.uid");
                    $numRows = DB_numRows($result);

                    for ($i = 1; $i <= $numRows; $i++) {
                        $row = DB_fetchArray($result);
                        $uBlocks = str_replace(' ', ',', $row['boxes']);
                        $result2 = DB_query("SELECT bid,name FROM {$_TABLES['blocks']} WHERE bid NOT IN ($uBlocks)");
                        $newBlocks = '';

                        for ($x = 1; $x <= DB_numRows($result2); $x++) {
                            $currentBlock = DB_fetchArray($result2);

                            if (($currentBlock['name'] !== 'user_block') &&
                                ($currentBlock['name'] !== 'admin_block') &&
                                ($currentBlock['name'] !== 'section_block')
                            ) {
                                $newBlocks .= $currentBlock['bid'];

                                if ($x != DB_numRows($result2)) {
                                    $newBlocks .= ' ';
                                }
                            }
                        }

                        DB_query("UPDATE {$_TABLES['userindex']} SET boxes = '$newBlocks' WHERE uid = {$row['uid']}");

                    }
                    $currentGlVersion = '1.3.3';
                    $_SQL = array();
                    break;

                case '1.3.3':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.3_to_1.3.4.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.3.4';
                    $_SQL = array();
                    break;

                case '1.3.4':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.4_to_1.3.5.php';
                    $this->updateDB($_SQL, $progress);
                    $result = DB_query("SELECT ft_id FROM {$_TABLES['features']} WHERE ft_name = 'user.mail'");
                    $row = DB_fetchArray($result);
                    $mail_ft = $row['ft_id'];
                    $result = DB_query("SELECT grp_id FROM {$_TABLES['groups']} WHERE grp_name = 'Mail Admin'");
                    $row = DB_fetchArray($result);
                    $group_id = $row['grp_id'];
                    DB_query("INSERT INTO {$_TABLES['access']} (acc_grp_id, acc_ft_id) VALUES ($group_id, $mail_ft)");
                    $currentGlVersion = '1.3.5';
                    $_SQL = array();
                    break;

                case '1.3.5':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.5_to_1.3.6.php';
                    $this->updateDB($_SQL, $progress);

                    if (!empty($_DB_table_prefix)) {
                        DB_query("RENAME TABLE staticpage TO {$_TABLES['staticpage']}");
                    }

                    $currentGlVersion = '1.3.6';
                    $_SQL = array();
                    break;

                case '1.3.6':
                    // fix wrong permissions value
                    DB_query("UPDATE {$_TABLES['topics']} SET perm_anon = 2 WHERE perm_anon = 3");

                    // check for existence of 'date' field in gl_links table
                    DB_query("SELECT date FROM {$_TABLES['links']}", 1);

                    if (strpos(DB_error(), 'date') > 0) {
                        DB_query("ALTER TABLE {$_TABLES['links']} ADD date datetime default NULL");
                    }

                    // Fix primary key so that more than one user can add an event
                    // to his/her personal calendar.
                    DB_query("ALTER TABLE {$_TABLES['personal_events']} DROP PRIMARY KEY, ADD PRIMARY KEY (eid,uid)");

                    $currentGlVersion = '1.3.7';
                    $_SQL = array();
                    break;

                case '1.3.7':
                    require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.7_to_1.3.8.php');
                    $this->updateDB($_SQL, $progress);

                    // upgrade Static Pages plugin
                    $spVersion = $this->getStaticPagesVersion();

                    if ($spVersion == 1) { // original version
                        DB_query("ALTER TABLE {$_TABLES['staticpage']} "
                            . "ADD COLUMN group_id mediumint(8) unsigned DEFAULT '1',"
                            . "ADD COLUMN owner_id mediumint(8) unsigned DEFAULT '1',"
                            . "ADD COLUMN perm_owner tinyint(1) unsigned DEFAULT '3',"
                            . "ADD COLUMN perm_group tinyint(1) unsigned DEFAULT '2',"
                            . "ADD COLUMN perm_members tinyint(1) unsigned DEFAULT '2',"
                            . "ADD COLUMN perm_anon tinyint(1) unsigned DEFAULT '2',"
                            . "ADD COLUMN sp_php tinyint(1) unsigned DEFAULT '0',"
                            . "ADD COLUMN sp_nf tinyint(1) unsigned DEFAULT '0',"
                            . "ADD COLUMN sp_centerblock tinyint(1) unsigned NOT NULL default '0',"
                            . "ADD COLUMN sp_tid varchar(20) NOT NULL default 'none',"
                            . "ADD COLUMN sp_where tinyint(1) unsigned NOT NULL default '1'");
                        DB_query("INSERT INTO {$_TABLES['features']} (ft_name, ft_descr) VALUES ('staticpages.PHP','Ability to use PHP in static pages')");
                        $php_id = DB_insertId();
                        $group_id = DB_getItem($_TABLES['groups'], 'grp_id', "grp_name = 'Static Page Admin'");
                        DB_query("INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES ($php_id, $group_id)");
                    } elseif ($spVersion == 2) { // extended version by Phill or Tom
                        DB_query("ALTER TABLE {$_TABLES['staticpage']} "
                            . "DROP COLUMN sp_pos,"
                            . "DROP COLUMN sp_search_keywords,"
                            . "ADD COLUMN sp_nf tinyint(1) unsigned DEFAULT '0',"
                            . "ADD COLUMN sp_centerblock tinyint(1) unsigned NOT NULL default '0',"
                            . "ADD COLUMN sp_tid varchar(20) NOT NULL default 'none',"
                            . "ADD COLUMN sp_where tinyint(1) unsigned NOT NULL default '1'");
                    }

                    if ($spVersion > 0) {
                        // update plugin version number
                        DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '1.3', pi_gl_version = '1.3.8' WHERE pi_name = 'staticpages'");

                        // remove Static Pages 'lock' flag
                        DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = 'staticpages'");

                        // remove Static Pages Admin group id
                        DB_query("DELETE FROM {$_TABLES['vars']} WHERE name = 'sp_group_id'");

                        if ($spVersion == 1) {
                            $result = DB_query("SELECT DISTINCT sp_uid FROM {$_TABLES['staticpage']}");
                            $authors = DB_numRows($result);

                            for ($i = 0; $i < $authors; $i++) {
                                $A = DB_fetchArray($result);
                                DB_query("UPDATE {$_TABLES['staticpage']} SET owner_id = '{$A['sp_uid']}' WHERE sp_uid = '{$A['sp_uid']}'");
                            }
                        }

                        $result = DB_query("SELECT sp_label FROM {$_TABLES['staticpage']} WHERE sp_title = 'Frontpage'");

                        if (DB_numRows($result) > 0) {
                            $A = DB_fetchArray($result);

                            if ($A['sp_label'] == 'nonews') {
                                DB_query("UPDATE {$_TABLES['staticpage']} SET sp_centerblock = 1, sp_where = 0 WHERE sp_title = 'Frontpage'");
                            } elseif (!empty ($A['sp_label'])) {
                                DB_query("UPDATE {$_TABLES['staticpage']} SET sp_centerblock = 1, sp_title = '{$A['sp_label']}' WHERE sp_title = 'Frontpage'");
                            } else {
                                DB_query("UPDATE {$_TABLES['staticpage']} SET sp_centerblock = 1 WHERE sp_title = 'Frontpage'");
                            }
                        }
                    }

                    $currentGlVersion = '1.3.8';
                    $_SQL = array();
                    break;

                case '1.3.8':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.8_to_1.3.9.php';
                    $this->updateDB($_SQL, $progress);

                    $pos = strrpos($_CONF['rdf_file'], '/');
                    $filename = substr($_CONF['rdf_file'], $pos + 1);
                    $siteName = DB_escapeString($_CONF['site_name']);
                    $siteSlogan = DB_escapeString($_CONF['site_slogan']);
                    DB_query("INSERT INTO {$_TABLES['syndication']} (title, description, limits, content_length, filename, charset, language, is_enabled, updated, update_info) VALUES ('{$siteName}', '{$siteSlogan}', '{$_CONF['rdf_limit']}', {$_CONF['rdf_storytext']}, '{$filename}', '{$_CONF['default_charset']}', '{$_CONF['rdf_language']}', {$_CONF['backend']}, CURRENT_TIMESTAMP, NULL)");

                    // upgrade static pages plugin
                    $spVersion = $this->getStaticPagesVersion();

                    if ($spVersion > 0) {
                        if ($spVersion < 4) {
                            if (!isset($_SP_CONF['in_block'])) {
                                $_SP_CONF['in_block'] = 1;
                            } elseif ($_SP_CONF['in_block'] > 1) {
                                $_SP_CONF['in_block'] = 1;
                            } elseif ($_SP_CONF['in_block'] < 0) {
                                $_SP_CONF['in_block'] = 0;
                            }

                            DB_query("ALTER TABLE {$_TABLES['staticpage']} ADD COLUMN sp_inblock tinyint(1) unsigned DEFAULT '{$_SP_CONF['in_block']}'");
                        }

                        DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '1.4', pi_gl_version = '1.3.9' WHERE pi_name = 'staticpages'");
                    }

                    // recreate 'date' field for old links
                    $result = DB_query("SELECT lid FROM {$_TABLES['links']} WHERE date IS NULL");
                    $num = DB_numRows($result);

                    if ($num > 0) {
                        for ($i = 0; $i < $num; $i++) {
                            $A = DB_fetchArray($result);
                            $myYear = substr($A['lid'], 0, 4);
                            $myMonth = substr($A['lid'], 4, 2);
                            $myDay = substr($A['lid'], 6, 2);
                            $myHour = substr($A['lid'], 8, 2);
                            $myMin = substr($A['lid'], 10, 2);
                            $mySec = substr($A['lid'], 12, 2);
                            $mTime = mktime($myHour, $myMin, $mySec, $myMonth, $myDay, $myYear);
                            $date = date('Y-m-d H:i:s', $mTime);
                            DB_query("UPDATE {$_TABLES['links']} SET date = '$date' WHERE lid = '{$A['lid']}'");
                        }
                    }

                    // remove unused entries left over from deleted groups
                    $result = DB_query("SELECT grp_id FROM {$_TABLES['groups']}");
                    $num = DB_numRows($result);
                    $groups = array();

                    for ($i = 0; $i < $num; $i++) {
                        $A = DB_fetchArray($result);
                        $groups[] = $A['grp_id'];
                    }

                    $groupList = '(' . implode(',', $groups) . ')';
                    DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_main_grp_id NOT IN $groupList) OR (ug_grp_id NOT IN $groupList)");
                    $currentGlVersion = '1.3.9';
                    $_SQL = array();
                    break;

                case '1.3.9':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.9_to_1.3.10.php';
                    $this->updateDB($_SQL, $progress);
                    commentsToPreorderTree();
                    $result = DB_query("SELECT sid,introtext,bodytext FROM {$_TABLES['stories']}");
                    $numStories = DB_numRows($result);

                    for ($i = 0; $i < $numStories; $i++) {
                        $A = DB_fetchArray($result);
                        $related = DB_escapeString(implode("\n", UPDATE_extractLinks($A['introtext'] . ' ' . $A['bodytext'])));

                        if (empty ($related)) {
                            DB_query("UPDATE {$_TABLES['stories']} SET related = NULL WHERE sid = '{$A['sid']}'");
                        } else {
                            DB_query("UPDATE {$_TABLES['stories']} SET related = '$related' WHERE sid = '{$A['sid']}'");
                        }
                    }

                    $spVersion = $this->getStaticPagesVersion();

                    if ($spVersion > 0) {
                        // no database changes this time, but set new version number
                        DB_query("UPDATE {$_TABLES['plugins']} SET pi_version = '1.4.1', pi_gl_version = '1.3.10' WHERE pi_name = 'staticpages'");
                    }

                    // install SpamX plugin
                    // (also handles updates from version 1.0)
                    install_spamx_plugin();
                    $currentGlVersion = '1.3.10';
                    $_SQL = array();
                    break;

                case '1.3.10':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.10_to_1.3.11.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.3.11';
                    $_SQL = array();
                    break;

                case '1.3.11':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.11_to_1.4.0.php';
                    $this->updateDB($_SQL, $progress);
                    upgrade_addFeature();
                    upgrade_uniqueGroupNames();
                    $currentGlVersion = '1.4.0';
                    $_SQL = array();
                    break;

                case '1.4.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.4.0_to_1.4.1.php';
                    $this->updateDB($_SQL, $progress);
                    upgrade_addSyndicationFeature();
                    upgrade_ensureLastScheduledRunFlag();
                    upgrade_plugins_141();
                    $currentGlVersion = '1.4.1';
                    $_SQL = array();
                    break;

                case '1.4.1':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.4.1_to_1.5.0.php';
                    $this->updateDB($_SQL, $progress);
                    upgrade_addWebservicesFeature();
                    create_ConfValues();
                    require_once $_CONF['path_system'] . 'classes/ConfigInterface.php';
                    require_once $_CONF['path_system'] . 'classes/config.class.php';
                    $config = config::get_instance();

                    if (file_exists($_CONF['path'] . 'config.php')) {
                        // Read the values from config.php and use them to populate conf_values
                        $tempPath = $_CONF['path']; // We'll need this to remember what the correct path is.

                        // Including config.php will overwrite all our $_CONF values.
                        require $tempPath . 'config.php';

                        // Load some important values from config.php into conf_values
                        foreach ($_CONF as $key => $val) {
                            $config->set($key, $val);
                        }

                        if (!$this->setDefaultCharset($this->env['siteconfig_path'], $_CONF['default_charset'])) {
                            exit($this->LANG['INSTALL'][26] . ' ' . $this->env['siteconfig_path'] . $this->LANG['INSTALL'][58]);
                        }

                        require $this->env['siteconfig_path'];
                        $this->includeConfig($this->env['dbconfig_path']);
                    }

                    // Update the GL configuration with the correct paths.
                    $config->set('path_html', $this->env['html_path']);
                    $config->set('path_log', $_CONF['path'] . 'logs/');
                    $config->set('path_language', $_CONF['path'] . 'language/');
                    $config->set('backup_path', $_CONF['path'] . 'backups/');
                    $config->set('path_data', $_CONF['path'] . 'data/');
                    $config->set('path_images', $this->env['html_path'] . 'images/');
                    $config->set('path_themes', $this->env['html_path'] . 'layout/');
                    $config->set('path_editors', $this->env['html_path'] . 'editors/');
                    $config->set('rdf_file', $this->env['html_path'] . 'backend/geeklog.rss');
                    $config->set('path_pear', $_CONF['path_system'] . 'pear/');

                    // core plugin updates are done in the plugins themselves
                    $currentGlVersion = '1.5.0';
                    $_SQL = array();
                    break;

                case '1.5.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.5.0_to_1.5.1.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.5.1';
                    $_SQL = array();
                    break;

                case '1.5.1':
                    // there were no core database changes in 1.5.2
                    $currentGlVersion = '1.5.2';
                    $_SQL = array();
                    break;

                case '1.5.2':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.5.2_to_1.6.0.php';
                    $this->updateDB($_SQL, $progress);
                    update_ConfValues();
                    upgrade_addNewPermissions();
                    upgrade_addIsoFormat();
                    $this->fixOptionalConfig();
                    $currentGlVersion = '1.6.0';
                    $_SQL = array();
                    break;

                case '1.6.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.6.0_to_1.6.1.php';
                    $this->updateDB($_SQL, $progress);
                    update_ConfValuesFor161();
                    $currentGlVersion = '1.6.1';
                    $_SQL = array();
                    break;

                case '1.6.1':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.6.1_to_1.7.0.php';
                    $this->updateDB($_SQL, $progress);
                    update_ConfValuesFor170();
                    $currentGlVersion = '1.7.0';
                    $_SQL = array();
                    break;

                case '1.7.0':
                    $currentGlVersion = '1.7.2'; // skip ahead
                    $_SQL = array();
                    break;

                case '1.7.1':
                    // there were no database changes in 1.7.1
                case '1.7.2':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.7.2_to_1.8.0.php';
                    $this->updateDB($_SQL, $progress);
                    update_ConfValuesFor180();
                    update_ConfigSecurityFor180();
                    update_UsersFor180();
                    $currentGlVersion = '1.8.0';
                    $_SQL = array();
                    break;

                case '1.8.0':
                case '1.8.1':
                case '1.8.2':
                    // there were no database changes in 1.8.x
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.8.2_to_2.0.0.php';
                    $this->updateDB($_SQL, $progress);
                    update_ConfValuesFor200();
                    update_BlockTopicAssignmentsFor200();
                    update_StoryTopicAssignmentsFor200();
                    $currentGlVersion = '2.0.0';
                    $_SQL = array();
                    break;

                case '2.0.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.0.0_to_2.1.0.php';
                    $this->updateDB($_SQL, $progress);
                    update_addFilemanager();
                    update_ConfValuesFor210();
                    $currentGlVersion = '2.1.0';
                    $_SQL = array();
                    break;

                case '2.1.0':
                    // there were no database changes in 2.1.0
                case '2.1.1':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.1.1_to_2.1.2.php';
                    if ($checkForMessage) {
                        $retval = upgrade_message211();
                        if (is_array($retval)) {
                            $this->upgradeMessages = array_merge($this->upgradeMessages, $retval);
                        }
                    } else {
                        $this->updateDB($_SQL, $progress);
                        update_dateTimeColumns212();
                        update_addLanguage();
                        update_addRouting();
                        updateUserTheme212();
                        update_ConfValuesFor212();
                    }
                    $currentGlVersion = '2.1.2';
                    $_SQL = array();
                    break;
                case '2.1.2':
                    // there were no database changes in 2.1.2

                    $currentGlVersion = '2.1.3';
                    break;

                case '2.1.3':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.1.3_to_2.2.0.php';
                    if ($checkForMessage) {
                        $retval = upgrade_message213();
                        if (is_array($retval)) {
                            $this->upgradeMessages = array_merge($this->upgradeMessages, $retval);
                        }
                    } else {
                        $this->updateDB($_SQL, $progress);
                        removeCommentSig220();
                        update_ConfValuesFor220();
                        addThemeAdminFor220();
                    }
                    $currentGlVersion = '2.2.0';
                    $_SQL = array();
                    break;

                case '2.2.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.2.0_to_2.2.1.php';
                    if ($checkForMessage) {
                        $retval = upgrade_message220();
                        if (is_array($retval)) {
                            $this->upgradeMessages = array_merge($this->upgradeMessages, $retval);
                        }
                    } else {
                        $this->updateDB($_SQL, $progress);
                        update_ConfValuesFor221();
                        fixDuplicateUsernames221();
                    }
                    $currentGlVersion = '2.2.1';
                    break;

                default:
                    $done = true;
                    break;
            }
        }

        // Don't do this if just checking for upgrade messages
        if (!$checkForMessage) {
            $this->setVersion($this->env['siteconfig_path']);

            // delete the security check flag on every update to force the user
            // to run admin/sectest.php again
            DB_delete($_TABLES['vars'], 'name', 'security_check');
        }

        return true;
    }

    /**
     * Do a sanity check on the paths and URLs
     * This is somewhat speculative but should provide the user with a working
     * site even if, for example, a site backup was installed elsewhere.
     *
     * @param    string $path           proper /path/to/Geeklog
     * @param    string $path_html      path to public_html
     * @param    string $site_url       The site's URL
     * @param    string $site_admin_url URL to the admin directory
     */
    private function fixPathsAndUrls($path, $path_html, $site_url, $site_admin_url)
    {
        require_once $path . 'system/classes/ConfigInterface.php';
        require_once $path . 'system/classes/config.class.php';

        $config = config::get_instance();
        $config->set_configfile($path . 'db-config.php');
        $config->load_baseconfig();
        $config->initConfig();
        $_CONF = $config->get_config('Core');
        clearstatcache();

        if (!file_exists($_CONF['path_log'] . 'error.log')) {
            $config->set('path_log', $path . 'logs/');
        }

        if (!file_exists($_CONF['path_language'] . $_CONF['language'] . '.php')) {
            $config->set('path_language', $path . 'language/');
        }

        if (!file_exists($_CONF['backup_path'])) {
            $config->set('backup_path', $path . 'backups/');
        }

        if (!file_exists($_CONF['path_data'])) {
            $config->set('path_data', $path . 'data/');
        }

        if (version_compare(self::GL_VERSION, '2.1.2', '<')) {
            if ((!$_CONF['have_pear']) &&
                (!file_exists($_CONF['path_pear'] . 'PEAR.php'))
            ) {
                $config->set('path_pear', $path . 'system/pear/');
            }
        }

        if (!file_exists($_CONF['path_html'] . 'lib-common.php')) {
            $config->set('path_html', $path_html);
        }

        if (!file_exists($_CONF['path_themes'] . $_CONF['theme']
            . '/header.thtml')
        ) {
            $config->set('path_themes', $path_html . 'layout/');

            if (!file_exists($path_html . 'layout/' . $_CONF['theme']
                . '/header.thtml')
            ) {
                $config->set('theme', 'professional');
            }
        }

        if (!file_exists($_CONF['path_images'] . 'articles')) {
            $config->set('path_images', $path_html . 'images/');
        }

        if (!file_exists($_CONF['path_editors'] . 'ckeditor')) {
            $config->set('path_editors', $path_html . 'editors/');
        }

        if (substr($_CONF['rdf_file'], strlen($path_html)) != $path_html) {
            // this may not be correct but neither was the old value apparently ...
            $config->set('rdf_file', $path_html . 'backend/geeklog.rss');
        }

        if (!empty($site_url) && ($_CONF['site_url'] != $site_url)) {
            $config->set('site_url', $site_url);

            // if we had to fix the site's URL, chances are that cookie domain
            // and path are also wrong and the user won't be able to log in
            $config->set('cookiedomain', '');
            $config->set('cookie_path', $this->guessCookiePath($site_url));
        }

        if (!empty($site_admin_url) &&
            ($_CONF['site_admin_url'] != $site_admin_url)
        ) {
            $config->set('site_admin_url', $site_admin_url);
        }
    }

    /**
     * Check which plugins are actually installed and disable them if needed
     *
     * @return   int     number of plugins that were disabled
     */
    private function checkPlugins()
    {
        global $_CONF, $_TABLES;

        $disabled = 0;
        $plugin_path = $_CONF['path'] . 'plugins/';

        $result = DB_query("SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
        $numPlugins = DB_numRows($result);

        for ($i = 0; $i < $numPlugins; $i++) {
            $A = DB_fetchArray($result);

            if (!file_exists($plugin_path . $A['pi_name'] . '/functions.inc')) {
                DB_query("UPDATE {$_TABLES['plugins']} SET pi_enabled = 0 WHERE pi_name = '{$A['pi_name']}'");
                $disabled++;
            }
        }

        return $disabled;
    }

    private function clearCacheDirectories($path, $needle = '')
    {
        if ($path[strlen($path) - 1] !== '/') {
            $path .= '/';
        }

        if ($dir = @opendir($path)) {
            while ($entry = readdir($dir)) {
                if ($entry == '.' || $entry == '..' || is_link($entry) || $entry == '.svn' || $entry == 'index.html') {
                    continue;
                } elseif (is_dir($path . $entry)) {
                    $this->clearCacheDirectories($path . $entry, $needle);
                    @rmdir($path . $entry);
                } elseif (empty($needle) || strpos($entry, $needle) !== false) {
                    @unlink($path . $entry);
                }
            }

            @closedir($dir);
        }
    }

    /**
     * Clear cache files
     *
     * @param string $plugin
     */
    private function clearCache($plugin = '')
    {
        global $_CONF;

        if (!empty($plugin)) {
            $plugin = '__' . $plugin . '__';
        }

        $this->clearCacheDirectories($_CONF['path'] . 'data/layout_cache/', $plugin);
        $this->clearCacheDirectories($_CONF['path'] . 'data/layout_css/', $plugin);
    }

    /**
     * Check if we can skip upgrade steps (post-1.5.0)
     * If we're doing an upgrade from 1.5.0 or later and we have the necessary
     * DB credentials, skip the forms and upgrade directly.
     * NOTE:    Will not return if upgrading from 1.5.0 or later.
     *
     * @param   string $dbConfigFilePath   path to db-config.php
     * @param   string $siteConfigFilePath path to siteconfig.php
     * @return  string                      database version, if possible
     */
    private function checkPost150Upgrade($dbConfigFilePath, $siteConfigFilePath)
    {
        global $_CONF, $_TABLES, $_DB, $_DB_dbms, $_DB_host, $_DB_user, $_DB_pass, $_DB_name, $_DB_table_prefix;

        require_once $dbConfigFilePath;
        require_once $siteConfigFilePath;

        $dbHandle = null;
        $connected = false;
        $version = '';

        switch ($_DB_dbms) {
            case 'mysql':
                if (is_callable('mysqli_connect')) {
                    $dbHandle = @mysqli_connect($_DB_host, $_DB_user, $_DB_pass);

                    if ($dbHandle instanceof mysqli) {
                        $connected = $dbHandle->select_db($_DB_name);
                    }
                } elseif (is_callable('mysql_connect')) {
                    $dbHandle = @mysql_connect($_DB_host, $_DB_user, $_DB_pass);

                    if (is_resource($dbHandle)) {
                        $connected = @mysql_select_db($_DB_name, $dbHandle);
                    }
                }
                break;

            default:
                $connected = false;
                break;
        }

        if ($connected) {
            require_once $_CONF['path_system'] . 'lib-database.php';
            $version = $this->identifyGeeklogVersion();

            switch ($_DB_dbms) {
                case 'mysql':
                    if ($dbHandle instanceof mysqli) {
                        $dbHandle->close();
                    } else {
                        @mysql_close($dbHandle);
                    }

                    break;
            }

            if (!empty($version) && ($version != self::GL_VERSION) &&
                (version_compare($version, '1.5.0') >= 0)
            ) {
                // current version is at least 1.5.0, so upgrade directly
                $req_string = 'index.php?mode=upgrade&step=3'
                    . '&dbconfig_path=' . $dbConfigFilePath
                    . '&language=' . $this->env['language']
                    . '&version=' . $version;
                header('Location: ' . $req_string);
                exit;
            }
        }

        return $version;
    }

    /**
     * Written to aid in install script development
     * NOTE:    This code is a modified copy from PHP.net
     *
     * @param   int $size       file size
     * @param   int $dec_places Number of decimal places
     * @return  string             file size string
     */
    private function formatSize($size, $dec_places = 0)
    {
        $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        for ($i = 0; ($size > 1024 && isset($sizes[$i + 1])); $i++) {
            $size /= 1024;
        }

        return round($size, $dec_places) . ' ' . $sizes[$i];
    }

    /**
     * Check if an error occurred while uploading a file
     *
     * @param   array $mFile    $_FILE['uploaded_file']
     * @return  mixed           Returns the error string if an error occurred,
     *                          returns false if no error occurred
     */
    public function getUploadError($mFile)
    {
        global $LANG_ERROR;

        $mErrors = array(
            UPLOAD_ERR_INI_SIZE   => $LANG_ERROR[0],
            UPLOAD_ERR_FORM_SIZE  => $LANG_ERROR[1],
            UPLOAD_ERR_PARTIAL    => $LANG_ERROR[2],
            UPLOAD_ERR_NO_FILE    => $LANG_ERROR[3],
            UPLOAD_ERR_NO_TMP_DIR => $LANG_ERROR[4],
            UPLOAD_ERR_CANT_WRITE => $LANG_ERROR[5],
            UPLOAD_ERR_EXTENSION  => $LANG_ERROR[6],
        );

        if ($mFile['error'] != UPLOAD_ERR_OK) { // If an error occurred while uploading the file.
            if ($mFile['error'] > count($mErrors)) { // If the error code isn't listed in $mErrors
                $mRetval = 'An unknown error occurred'; // Unknown error
            } else {
                $mRetval = $mErrors[$mFile['error']]; // Print the error
            }
        } else { // If no upload error occurred
            $mRetval = false;
        }

        return $mRetval;
    }

    /**
     * Nicely formats the alert messages
     *
     * @param  string $mMessage Message string
     * @param  string $mType    'error', 'warning', 'success', or 'notice'
     * @return string           HTML formatted dialog message
     */
    public function getAlertMsg($mMessage, $mType = 'notice')
    {
        global $LANG_INSTALL;

        switch (strtolower($mType)) {
            case 'error':
                $mType = $LANG_INSTALL[38];
                $mStyle = 'danger';
                break;

            case 'warning':
                $mType = $LANG_INSTALL[20];
                $mStyle = 'warning';
                break;

            case 'success':
                $mType = $LANG_INSTALL[93];
                $mStyle = 'success';
                break;

            default:
                $mType = $LANG_INSTALL[59];
                $mStyle = 'primary';
                break;
        }

        return '<div class="uk-alert uk-alert-' . $mStyle . '">'
            . '<span class="uk-label uk-label-' . $mStyle . '">' . $mType . '</span> ' . $mMessage . '</div>' . PHP_EOL;
    }

    /**
     * Unpack a db backup file, if necessary
     * Note: This requires a minimal PEAR setup (incl. Tar and Zip classes) and a
     *       way to set the PEAR include path. But if that doesn't work on your
     *       setup, then chances are you won't get Geeklog up and running anyway ...
     *
     * @param    string $backupPath path to the "backups" directory
     * @param    string $backupFile backup file name
     * @param    string $display    reference to HTML string (for error msg)
     * @return   mixed              file name of unpacked file or false: error
     */
    private function unpackFile($backupPath, $backupFile, &$display)
    {
        global $_CONF, $LANG_MIGRATE;

        if (!preg_match('/\.(zip|tar\.gz|tgz|gz)$/i', $backupFile)) {
            // not packed
            return $backupFile;
        }

        $gl_path = str_replace(self::DB_CONFIG_FILE, '', $this->env['dbconfig_path']);

        require_once $gl_path . 'system/classes/Autoload.php';
        Geeklog\Autoload::initialize();
        $archive = new Unpacker($backupPath . $backupFile);

        // we're going to extract the first .sql file we find in the archive
        $dirName = '';
        $foundSqlFile = false;
        $file = '';
        $files = $archive->getList();

        if (is_array($files) && (count($files) > 0)) {
            foreach ($files as $file) {
                if (!isset($file['folder']) || !$file['folder']) {
                    if (preg_match('/\.sql$/', $file['filename'])) {
                        $dirName = preg_replace('/\/.*$/', '', $file['filename']);
                        $foundSqlFile = true;
                        break;
                    }
                }
            }
        }

        if (!$foundSqlFile) {
            // no .sql file found in archive
            return false;
        }

        if (isset($file) && ($dirName === $file['filename'])) {
            $dirName = ''; // no directory
        }

        if (empty($dirName)) {
            $unpacked_file = $file['filename'];
        } else {
            $unpacked_file = substr($file['filename'], strlen($dirName) + 1);
        }

        $success = $archive->unpack($backupPath, '|' . preg_quote($file['filename'], '|') . '|');

        if (!$success || !file_exists($backupPath . $unpacked_file)) {
            // error unpacking file
            $display .= $this->getAlertMsg(sprintf($LANG_MIGRATE[41], $unpacked_file));

            return false;
        }

        unset($archive);

        return $unpacked_file;
    }

    /**
     * Check for InnoDB table support (usually as of MySQL 4.0, but may be
     * available in earlier versions, e.g. "Max" or custom builds).
     *
     * @return  bool     true = InnoDB tables supported, false = not supported
     */
    private function innodbSupported()
    {
        $retval = false;

        $result = DB_query("SHOW ENGINES");
        $numEngines = DB_numRows($result);

        for ($i = 0; $i < $numEngines; $i++) {
            $A = DB_fetchArray($result);

            if (strcasecmp($A['Engine'], 'InnoDB') === 0) {
                if ((strcasecmp($A['Support'], 'yes') === 0) ||
                    (strcasecmp($A['Support'], 'default') === 0)
                ) {
                    $retval = true;
                }
                break;
            }
        }

        return $retval;
    }

    /**
     * Upgrade any enabled plugins
     * NOTE: Needs a fully working Geeklog, so can only be done late in the upgrade
     *       process!
     *
     * @param    boolean $migration whether the upgrade is part of a site migration
     * @param    array   $old_conf  old $_CONF values before the migration
     * @return   int     number of failed plugin updates (0 = everything's fine)
     * @see      PLG_upgrade
     * @see      PLG_migrate
     */
    private function pluginUpgrades($migration = false, $old_conf = array())
    {
        global $_CONF, $_PLUGINS, $_TABLES;

        $failed = 0;

        $result = DB_query("SELECT pi_name, pi_version FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
        $numPlugins = DB_numRows($result);

        for ($i = 0; $i < $numPlugins; $i++) {
            list($pi_name, $pi_version) = DB_fetchArray($result);

            $isSuccess = true;
            if ($migration) {
                $isSuccess = PLG_migrate($pi_name, $old_conf);
            }

            if ($isSuccess) {
                $code_version = PLG_chkVersion($pi_name);
                if (!empty($code_version) && ($code_version != $pi_version)) {
                    $isSuccess = PLG_upgrade($pi_name);
                }
            }

            if (!$isSuccess) {
                // migration or upgrade failed - disable plugin
                DB_change($_TABLES['plugins'], 'pi_enabled', 0,
                    'pi_name', $pi_name);
                COM_errorLog("Migration or upgrade for '{$pi_name}' plugin failed - plugin disabled");
                $failed++;
            }
        }

        // Only after all the other plugins are updated can we update sitemaps
        if (in_array('xmlsitemap', $_PLUGINS)) {
            require_once $_CONF['path'] . 'plugins/xmlsitemap/functions.inc';
            XMLSMAP_update();
            COM_errorLog('Successfully updated/migrated the "XMLSitemap" plugin');
        }

        return $failed;
    }

    /**
     * Fix site_url in content
     * If the site's URL changed due to the migration, this function will replace
     * the old URL with the new one in text content of the given tables.
     *
     * @param    string $oldUrl    the site's previous URL
     * @param    string $newUrl    the site's new URL after the migration
     * @param    array  $tableSpec (optional) list of tables to patch
     *                             The $tablespec is an array of tablename => fieldlist pairs, where the field
     *                             list contains the text fields to be searched and the table's index field
     *                             as the first(!) entry.
     *                             NOTE: This function may be used by plugins during PLG_migrate. Changes should
     *                             ensure backward compatibility.
     */
    public static function updateSiteUrl($oldUrl, $newUrl, array $tableSpec = array())
    {
        global $_TABLES;

        // standard tables to update if no $tablespec given
        $tables = array(
            'stories'         => 'sid, introtext, bodytext, related',
            'storysubmission' => 'sid, introtext, bodytext',
            'comments'        => 'cid, comment',
            'trackback'       => 'cid, excerpt, url',
            'blocks'          => 'bid, content',
        );

        if (count($tableSpec) === 0) {
            $tableSpec = $tables;
        }

        if (empty($oldUrl) || empty($newUrl) || ($oldUrl === $newUrl)) {
            return;
        }

        foreach ($tableSpec as $table => $fieldList) {
            $fields = explode(',', str_replace(' ', '', $fieldList));
            $index = array_shift($fields);

            if (empty($_TABLES[$table]) || !DB_checkTableExists($table)) {
                COM_errorLog("Table {$table} does not exist - skipping migration");
                continue;
            }

            $result = DB_query("SELECT {$fieldList} FROM {$_TABLES[$table]}");
            $numRows = DB_numRows($result);

            for ($i = 0; $i < $numRows; $i++) {
                $A = DB_fetchArray($result);
                $changed = false;

                foreach ($fields as $field) {
                    $newText = str_replace($oldUrl, $newUrl, $A[$field]);

                    if ($newText != $A[$field]) {
                        $A[$field] = $newText;
                        $changed = true;
                    }
                }

                if ($changed) {
                    $sql = "UPDATE {$_TABLES[$table]} SET ";

                    foreach ($fields as $field) {
                        $sql .= "$field = '" . DB_escapeString($A[$field]) . "', ";
                    }

                    $sql = substr($sql, 0, -2);
                    DB_query($sql . " WHERE $index = '" . DB_escapeString($A[$index]) . "'");
                }
            }
        }
    }

    /**
     * Migrate page 1 - Form for user to enter their database and path information
     * and to select a database backup file from the backups directory
     * or upload a backup from their computer.
     *
     * @return string
     */
    private function migrateStep1()
    {
        global $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix,
               $LANG_INSTALL, $LANG_MIGRATE;

        $this->env['alert_message1'] = $this->getAlertMessage($LANG_MIGRATE[0]);

        // Default form values
        $_FORM = array(
            'host'   => 'localhost',
            'name'   => 'geeklog',
            'user'   => 'username',
            'pass'   => '',
            'prefix' => 'gl_',
        );

        if (file_exists($this->env['dbconfig_path'])) {
            require_once $this->env['dbconfig_path'];

            if (($_DB_host !== 'localhost') || ($_DB_name !== 'geeklog')
                || ($_DB_user !== 'username') || ($_DB_pass != 'password')
            ) {
                // only display those if they all have their default values
                $_DB_host = '';
                $_DB_name = '';
                $_DB_user = '';
                $_DB_pass = '';
            }

            $_FORM['host'] = ($_DB_host !== 'localhost') ? '' : $_DB_host;
            $_FORM['name'] = ($_DB_name !== 'geeklog') ? '' : $_DB_name;
            $_FORM['user'] = ($_DB_user !== 'username)') ? '' : $_DB_user;
            $_FORM['prefix'] = $_DB_table_prefix;
        }

        $this->env['host'] = $_FORM['host'];
        $this->env['name'] = $_FORM['name'];
        $this->env['user'] = $_FORM['user'];
        $this->env['pass'] = '';
        $this->env['prefix'] = $_FORM['prefix'];

        // Set up the URL and admin URL paths.
        $this->env['site_url'] = isset($_REQUEST['site_url']) ? $_REQUEST['site_url'] : $this->getSiteUrl();
        $this->env['site_admin_url'] = isset($_REQUEST['site_admin_url']) ? $_REQUEST['site_admin_url'] : $this->getSiteAdminUrl();
        $this->env['help_db_type'] = $this->getHelpLink('db_type');
        $this->env['help_db_host'] = $this->getHelpLink('db_host');
        $this->env['help_db_name'] = $this->getHelpLink('db_name');
        $this->env['help_db_user'] = $this->getHelpLink('db_user');
        $this->env['help_db_pass'] = $this->getHelpLink('db_pass');
        $this->env['help_site_url'] = $this->getHelpLink('site_url');
        $this->env['help_site_admin_url'] = $this->getHelpLink('site_admin_url');
        $this->env['help_migrate_file'] = $this->getHelpLink('migrate_file');

        // Identify the backup files in backups/ and order them newest to oldest
        $gl_path = str_replace(self::DB_CONFIG_FILE, '', $this->env['dbconfig_path']);
        $backup_dir = $gl_path . 'backups/';
        $backupFiles = array();

        foreach (array('*.sql', '*.gz', '*.tar.gz', '*.tgz', '*.zip') as $pattern) {
            $files = glob($backup_dir . $pattern);

            if (is_array($files)) {
                $backupFiles = array_merge($backupFiles, $files);
            }
        }

        rsort($backupFiles);

        // Check if there are any files in the backups directory
        if (count($backupFiles) > 0) {
            $backupFileSelector = '<select name="backup_file" class="uk-select uk-width-auto">' . PHP_EOL
                . '<option value="">' . $LANG_MIGRATE[10] . '</option>' . PHP_EOL;

            // List each of the backup files in the backups directory
            foreach ($backupFiles as $filePath) {
                $filePath = str_replace('../../../backups/', '', $filePath);
                $filename = str_replace($backup_dir, '', $filePath);
                $backupFile = str_replace($backup_dir, '', $filePath);

                $backupFileSelector .= '<option value="' . $filename . '">'
                    . $backupFile . ' (' . $this->formatSize(@filesize($filePath)) . ')' . PHP_EOL
                    . '</option>' . PHP_EOL;
            }

            $backupFileSelector .= '</select>' . PHP_EOL;
        } else {
            $backupFileSelector = $LANG_MIGRATE[11] . PHP_EOL;
        }

        $this->env['backup_file_selector'] = $backupFileSelector;

        // Check if the user's PHP configuration has 'file_uploads' enabled
        $fileUploads = (bool) ini_get('file_uploads');

        // Check if the plugins directory is writable by the web server before we even bother uploading anything
        $isWritable = is_writable($backup_dir);
        $this->env['backup_file'] = ($fileUploads && $isWritable)
            ? '<input type="file" name="backup_file">' . PHP_EOL
            : '';

        if ($fileUploads) {
            if ($isWritable) {
                $alertMessage2 = $this->getAlertMessage($LANG_MIGRATE[12] . ini_get('upload_max_filesize') . $LANG_MIGRATE[13] . ini_get('upload_max_filesize') . $LANG_MIGRATE[14], 'notice');
            } else {
                $alertMessage2 = $this->getAlertMessage($LANG_MIGRATE[15], 'warning');
            }
        } else {
            $alertMessage2 = '';
        }

        $this->env['alert_message2'] = $alertMessage2;

        return MicroTemplate::quick(PATH_LAYOUT, 'step1-migrate', $this->env);
    }

    /**
     * Migrate page 2 - Check database credentials and write db-config.php using the form data
     */
    private function migrateStep2()
    {
        global $_CONF, $LANG_INSTALL, $LANG_CHARSET, $LANG_MIGRATE;

        // Check a few things before beginning the import process
        $importErrors = 0;
        $display = '';

        // Get the backup_file
        switch ($_REQUEST['migration_type']) {
            case 'select': // Select a backup file from the backups directory
                if (isset($_REQUEST['backup_file']) && !empty($_REQUEST['backup_file'])) {
                    $backupFile = array('name' => $_REQUEST['backup_file']);
                } else { // No backup file was selected
                    $display .= $this->getAlertMessage($LANG_MIGRATE[18], 'warning');
                    $backupFile = false;
                    $importErrors++;
                }

                break;

            case 'upload': // Upload a new backup file
                if ($upload_error = $this->getUploadError($_FILES['backup_file'])) { // If an error occurred while uploading the file
                    // or if no backup file was selected
                    $display .= $this->getAlertMsg($upload_error, 'warning');
                    $backupFile = false;
                    $importErrors++;
                } else {
                    $backupFile = $_FILES['backup_file'];
                }

                break;

            case 'dbcontent': // No upload / import required - use db as is
                $backupFile = false;
                $importErrors = 0;
                break;

            default:
                $display .= $this->getAlertMsg($LANG_MIGRATE[18], 'warning');
                $backupFile = false;
                $importErrors++;
        } // End switch ($_REQUEST['migration_type'])

        // Check if we can't connect to the database
        $DB = $_REQUEST['db'];

        if (!$this->dbConnect($DB)) {
            $display .= $this->getAlertMsg($LANG_INSTALL[54], 'warning');
            $importErrors++;
        } else {
            // Check if the user's version of MySQL is out of date
            // (needs to connect to MySQL in order to check)
            if ($this->isMysqlOutOfDate($DB)) {
                $display .= $this->getAlertMsg(sprintf($LANG_INSTALL[51], self::SUPPORTED_MYSQL_VER));
                $importErrors++;
            }
        }

        // Check if the database doesn't exist
        if (!$this->dbExists($DB)) {
            $display .= $this->getAlertMsg($LANG_INSTALL[56], 'warning');
            $importErrors++;
        }

        // Continue with the import if there were no previous errors
        if ($importErrors == 0) {
            // Check if the form was received from Step 1
            if (isset($_REQUEST['db'])) {
                // Write the database info to db-config.php
                if (!$this->writeConfig($this->sanitizePath($this->env['dbconfig_path']), $DB)) {
                    exit($LANG_INSTALL[26] . ' ' . $this->env['dbconfig_path'] . $LANG_INSTALL[58]);
                }
            }

            $this->includeConfig($this->env['dbconfig_path']); // Not sure if this needs to be included..

            switch ($_REQUEST['migration_type']) {
                case 'select':
                    header('Location: index.php?mode=migrate&step=3&dbconfig_path=' . $this->env['dbconfig_path']
                        . '&language=' . $this->env['language']
                        . '&backup_file=' . urlencode($backupFile['name'])
                        . '&site_url=' . urlencode($_REQUEST['site_url'])
                        . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));
                    break;

                case 'upload':
                    $gl_path = str_replace(self::DB_CONFIG_FILE, '', $this->env['dbconfig_path']);
                    $backup_dir = $gl_path . 'backups/';
                    $backupFile = $_FILES['backup_file'];

                    if (file_exists($backup_dir . $backupFile['name'])) { // If file already exists.
                        // Ask the user if they want to overwrite the original
                        // but for now save the file as a copy so it won't need
                        // to be uploaded again.
                        $backup_file_copy = str_replace('.sql', '_uploaded.sql', $backupFile['name']);

                        if (!move_uploaded_file($backupFile['tmp_name'], $backup_dir . $backup_file_copy)) { // If able to save the file
                            $display .= $LANG_MIGRATE[19] . $backup_file_copy . $LANG_MIGRATE[20] . $backup_dir . '.' . PHP_EOL;
                        } else {
                            $display .= '<p>' . $LANG_MIGRATE[21] . ' <code>' . $backupFile['name'] . '</code> ' . $LANG_MIGRATE[22] . '</p>' . PHP_EOL
                                . '<form action="index.php" method="post">' . PHP_EOL
                                . '<input type="hidden" name="mode" value="migrate">' . PHP_EOL
                                . '<input type="hidden" name="step" value="3">' . PHP_EOL
                                . '<input type="hidden" name="dbconfig_path" value="' . htmlspecialchars($this->env['dbconfig_path']) . '">' . PHP_EOL
                                . '<input type="hidden" name="site_url" value="' . urlencode($_REQUEST['site_url']) . '">' . PHP_EOL
                                . '<input type="hidden" name="site_admin_url" value="' . urlencode($_REQUEST['site_admin_url']) . '">' . PHP_EOL
                                . '<input type="hidden" name="backup_file" value="' . $backupFile['name'] . '">' . PHP_EOL
                                . '<input type="hidden" name="language" value="' . $this->env['language'] . '">' . PHP_EOL
                                . '<button type="submit" class="uk-button uk-button-primary uk-margin-small" name="overwrite_file" value="' . $LANG_MIGRATE[23] . '">' . $LANG_MIGRATE[23] . '</button>' . PHP_EOL
                                . '<button type="submit" class="uk-button uk-button-primary uk-margin-small" name="no" value="' . $LANG_MIGRATE[24] . '" onclick="document.location=\'index.php\'">' . $LANG_MIGRATE[24] . '</button>' . PHP_EOL
                                . '</form>' . PHP_EOL;
                        }
                    } else {
                        if (!move_uploaded_file($backupFile['tmp_name'], $backup_dir . $backupFile['name'])) { // If able to save the uploaded file
                            $display .= $LANG_MIGRATE[19] . $backupFile['name'] . $LANG_MIGRATE[20] . $backup_dir . '.' . PHP_EOL;
                        } else {
                            header('Location: index.php?mode=migrate&step=3&dbconfig_path=' . $this->env['dbconfig_path']
                                . '&language=' . $this->env['language']
                                . '&backup_file=' . urlencode($backupFile['name'])
                                . '&site_url=' . urlencode($_REQUEST['site_url'])
                                . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));
                        }
                    }

                    break;

                case 'dbcontent':
                    require_once $_CONF['path_system'] . 'lib-database.php';

                    // we need the following information
                    $has_config = false;
                    $db_connection_charset = '';
                    $DB['table_prefix'] = '';

                    // get table prefix and check for conf_values table
                    $result = DB_query("SHOW TABLES");
                    $num_tables = DB_numRows($result);

                    for ($i = 0; $i < $num_tables; $i++) {
                        list($table) = DB_fetchArray($result);

                        if (substr($table, -6) === 'access') {
                            $DB['table_prefix'] = substr($table, 0, -6);
                        } elseif (strpos($table, 'conf_values') !== false) {
                            $has_config = true;
                            break;
                        }
                    }

                    // try to figure out the charset
                    $result = DB_query("SHOW CREATE TABLE " . $DB['table_prefix'] . "access");
                    list(, $create) = DB_fetchArray($result);

                    if (strpos($create, 'DEFAULT CHARSET=utf8mb4') !== false) {
                        $db_connection_charset = 'utf8mb4';
                    } elseif (strpos($create, 'DEFAULT CHARSET=utf8') !== false) {
                        $db_connection_charset = 'utf8';
                    }

                    // Update db-config.php with the table prefix from the db
                    if (!$this->writeConfig($this->env['dbconfig_path'], $DB)) {
                        exit($LANG_INSTALL[26] . ' ' . $this->env['dbconfig_path'] . $LANG_INSTALL[58]);
                    }

                    // In case of migration, we don't use either 'utf8' or 'utf8mb4'
                    if (($db_connection_charset === 'utf8') || ($db_connection_charset === 'utf8mb4')) {
                        $defaultCharset = 'utf-8';
                    } else {
                        $defaultCharset = $LANG_CHARSET;
                    }

                    if (!$this->setDefaultCharset($this->env['siteconfig_path'], $defaultCharset)) {
                        exit($LANG_INSTALL[26] . ' ' . $this->env['siteconfig_path'] . $LANG_INSTALL[58]);
                    }

                    // skip step 3 since we don't need to import anything
                    header('Location: index.php?mode=migrate&step=4&language=' . $this->env['language']
                        . '&site_url=' . urlencode($_REQUEST['site_url'])
                        . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));
                    break;
            } // End switch ($_REQUEST['migration_type']
        } else {
            // Add prompt
            $this->env['migrate_errors'] = $display;
            $display = MicroTemplate::quick(PATH_LAYOUT, 'migrate_prompt_error', $this->env);
        }

        return $display;
    }

    /**
     * Migrate page 3 - Gets the database table prefix from the database file.
     * Overwrites an existing database file if requested by the user.
     * Sends the database filename (and a few other variables)
     * to bigdump.php, which performs the import.
     */
    private function migrateStep3()
    {
        global $LANG_INSTALL, $LANG_MIGRATE, $LANG_CHARSET;

        $display = '';

        $gl_path = str_replace(self::DB_CONFIG_FILE, '', $this->env['dbconfig_path']);
        $backup_dir = $gl_path . 'backups/';
        // Get the backup filename
        $backupFile = $_REQUEST['backup_file'];

        // If the user chose to overwrite an existing backup file
        if (isset($_REQUEST['overwrite_file'])) {
            // Overwrite the old file with the new file.
            rename($backup_dir . str_replace('.sql', '_uploaded.sql', $backupFile), $backup_dir . $backupFile);
        }

        $unpacked_file = $this->unpackFile($backup_dir, $backupFile, $display);

        if ($unpacked_file !== false) {
            $backupFile = $unpacked_file;

            // Parse the .sql file to grab the table prefix
            $has_config = false;
            $num_create = 0;
            $db_connection_charset = '';
            $DB['table_prefix'] = '';

            $sql_file = @fopen($backup_dir . $backupFile, 'r');

            if (!$sql_file) {
                // "This shouldn't happen" - just unpacked and now it's gone?
                exit(sprintf($LANG_MIGRATE[42], $backup_dir . $backupFile));
            }

            while (!feof($sql_file)) {
                $line = @fgets($sql_file);

                if (!empty($line)) {
                    if (preg_match('/CREATE TABLE/i', $line)) {
                        $num_create++;
                        $line = trim($line);

                        if (strpos($line, 'access') !== false) {
                            $line = str_replace('IF NOT EXISTS ', '', $line);
                            $words = explode(' ', $line);

                            if (count($words) >= 3) {
                                $table = str_replace('`', '', $words[2]);

                                if (substr($table, -6) === 'access') {
                                    $DB['table_prefix'] = substr($table, 0, -6);
                                }
                            }
                        } elseif (strpos($line, 'conf_values') !== false) {
                            $has_config = true;
                            break;
                        } elseif (strpos($line, 'featurecodes') !== false) {
                            // assume there's no conf_values table in here
                            break;
                        }
                    } elseif (substr($line, 0, 3) === '/*!') {
                        if ((strpos($line, 'SET NAMES utf8mb4') !== false) || (strpos($line, 'SET NAMES utf8') !== false)) {
                            $db_connection_charset = 'utf-8';
                        }
                    } elseif (empty($db_connection_charset) && strpos($line, 'ENGINE=') !== false) {
                        if ((strpos($line, 'DEFAULT CHARSET=utf8mb4') !== false) || (strpos($line, 'DEFAULT CHARSET=utf8') !== false)) {
                            $db_connection_charset = 'utf-8';
                        }
                    }
                }
            }

            fclose($sql_file);

            if ($num_create <= 1) {
                // this doesn't look like an SQL dump ...
                $display .= $this->getAlertMsg(sprintf($LANG_MIGRATE[43], $backupFile));
            } else {
                // Update db-config.php with the table prefix from the backup file.
                if (!$this->writeConfig($this->env['dbconfig_path'], $DB)) {
                    exit($LANG_INSTALL[26] . ' ' . $this->env['dbconfig_path'] . $LANG_INSTALL[58]);
                }

                // In case of $_CONF['default_charset'], we don't use either 'utf8' or 'utf8mb4'
                if ($db_connection_charset === 'utf-8') {
                    $defaultCharset = 'utf-8';
                } else {
                    $defaultCharset = $LANG_CHARSET;
                }

                if (!$this->setDefaultCharset($this->env['siteconfig_path'], $defaultCharset)) {
                    exit($LANG_INSTALL[26] . ' ' . $this->env['siteconfig_path'] . $LANG_INSTALL[58]);
                }

                // Send file to bigdump.php script to do the import.
                header('Location: bigdump.php?start=1&foffset=0&totalqueries=0'
                    . '&db_connection_charset=' . $db_connection_charset
                    . '&language=' . $this->env['language']
                    . '&fn=' . urlencode($backup_dir . $backupFile)
                    . '&site_url=' . urlencode($_REQUEST['site_url'])
                    . '&site_admin_url=' . urlencode($_REQUEST['site_admin_url']));
            }
        } else {
            // No SQL file found
            $backLink = 'index.php?'
                . http_build_query(array(
                    'mode'           => 'migrate',
                    'language'       => $this->getLanguage(),
                ));
            exit($this->getAlertMsg(sprintf($LANG_MIGRATE[40], $backupFile, $backLink)));
        }
    }

    /**
     * Page 4 - Post-import operations
     * Update the database, if necessary. Then check for missing plugins,
     * incorrect paths, and other required Geeklog files
     */
    private function migrateStep4()
    {
        global $_CONF, $_DB_dbms, $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix,
               $_TABLES, $LANG_INSTALL, $LANG_MIGRATE, $_DEVICE, $_URL;

        if (empty($this->env['dbconfig_path'])) {
            $this->env['dbconfig_path'] = $_CONF['path'] . 'db-config.php';
        }

        $this->includeConfig($this->env['dbconfig_path']);
        require_once $_CONF['path_system'] . 'lib-database.php';
        require_once $_CONF['path_system'] . 'classes/Autoload.php';
        Geeklog\Autoload::initialize();

        $display = '';
        $upgrade_error = false;
        $version = $this->identifyGeeklogVersion();

        if ($version === 'empty') {
            // "This shouldn't happen"
            $display .= $this->getAlertMsg($LANG_MIGRATE[44]);
            $upgrade_error = true;
        } elseif (empty($version)) {
            $display .= $this->getAlertMsg($LANG_MIGRATE[45]);
            // TBD: add a link back to the install script, preferably a direct link to the upgrade screen
            $upgrade_error = true;
        } elseif ($version != self::GL_VERSION) {
            $use_innodb = false;

            if (DB_checkTableExists('vars')) {
                $db_engine = DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'");
            } else {
                $db_engine = '';
            }

            if ($db_engine === 'InnoDB') {
                // we've migrated, probably to a different server
                // - so check InnoDB support again
                if ($this->innodbSupported()) {
                    $use_innodb = true;
                } else {
                    // no InnoDB support on this server
                    DB_delete($_TABLES['vars'], 'name', 'database_engine');
                }
            }

            // Check for any upgrade info and/or warning messages for specific upgrade path. Skip if continued has been clicked already
            if ($this->post('upgrade_check') !== 'confirmed') {
                $retval = $this->checkUpgradeMessage($version);
                if (!empty($retval)) {
                    return $retval;
                }
            }


            if (!$this->doDatabaseUpgrades($version)) {
                $display .= $this->getAlertMsg(sprintf($LANG_MIGRATE[47], $version, self::GL_VERSION));
                $upgrade_error = true;
            }
        }

        if ($upgrade_error) {
            $display .= <<<HTML
                <br><br>
                </div>
                </div>
                </body>
                </html>
HTML;
            echo $display;
            exit;
        }

        /**
         * Let's assume that the paths that were imported from the backup are
         * incorrect and update them with the current paths.
         * Note: When updating the config settings in the database, we also
         *       need to fix the $_CONF values. We can _not_ simply reload
         *       them via get_config('Core') here yet.
         */
        $html_path = $this->env['html_path'];

        $config = config::get_instance();
        $config->initConfig();

        // save a copy of the old config
        $_OLD_CONF = $config->get_config('Core');

        $_CONF['site_url'] = urldecode(urldecode(Geeklog\Input::get('site_url', Geeklog\Input::post('site_url', ''))));
        $config->set('site_url', $_CONF['site_url']);
        $_CONF['site_admin_url'] = urldecode(Geeklog\Input::get('site_admin_url', Geeklog\Input::post('site_admin_url', '')));
        $config->set('site_admin_url', $_CONF['site_admin_url']);
        $_CONF['path_html'] = $html_path;
        $config->set('path_html', $html_path);
        $_CONF['path_log'] = $_CONF['path'] . 'logs/';
        $config->set('path_log', $_CONF['path_log']);
        $_CONF['path_language'] = $_CONF['path'] . 'language/';
        $config->set('path_language', $_CONF['path_language']);
        $_CONF['backup_path'] = $_CONF['path'] . 'backups/';
        $config->set('backup_path', $_CONF['backup_path']);
        $_CONF['path_data'] = $_CONF['path'] . 'data/';
        $config->set('path_data', $_CONF['path_data']);
        $_CONF['path_images'] = $html_path . 'images/';
        $config->set('path_images', $_CONF['path_images']);
        $_CONF['path_themes'] = $html_path . 'layout/';
        $config->set('path_themes', $_CONF['path_themes']);
        $_CONF['path_editors'] = $html_path . 'editors/';
        $config->set('path_editors', $_CONF['path_editors']);
        $_CONF['rdf_file'] = $html_path . 'backend/geeklog.rss';
        $config->set('rdf_file', $_CONF['rdf_file']);

        // reset cookie domain and path as wrong values may prevent login
        $_CONF['cookiedomain'] = '';
        $config->set('cookiedomain', $_CONF['cookiedomain']);
        $_CONF['cookie_path'] = $this->guessCookiePath($_CONF['site_url']);
        $config->set('cookie_path', $_CONF['cookie_path']);

        if (substr($_CONF['site_url'], 0, 6) === 'https:') {
            $config->set('cookiesecure', true);
            $_CONF['cookiesecure'] = 1;
        } else {
            $config->set('cookiesecure', false);
            $_CONF['cookiesecure'] = 0;
        }

        // check the default theme
        if (empty($_CONF['theme'])) {
            // try old conf value
            $theme = $_OLD_CONF['theme'];
        } else {
            $theme = $_CONF['theme'];
        }

        if (!file_exists($_CONF['path_themes'] . $theme . '/header.thtml')) {
            $config->set('theme', self::DEFAULT_THEME);
            $_CONF['theme'] = self::DEFAULT_THEME;
        }

        // set noreply_mail when updating from an old version
        if (empty($_CONF['noreply_mail']) && !empty($_CONF['site_mail'])) {
            $_CONF['noreply_mail'] = $_CONF['site_mail'];
            $config->set('noreply_mail', $_CONF['noreply_mail']);
        }

        if (!empty($_OLD_CONF['ip_lookup'])) {
            $_CONF['ip_lookup'] = str_replace($_OLD_CONF['site_url'],
                $_CONF['site_url'], $_OLD_CONF['ip_lookup']);
            $config->set('ip_lookup', $_CONF['ip_lookup']);
        }

        /**
         * Check for missing plugins
         */

        // We want to add a log entry for any plugins that have been disabled
        // but we can't actually call lib-common.php until all missing plugins
        // have been disabled. So we keep track of missing plugins in the
        // $_MISSING_PLUGINS array then call lib-common.php and log them after
        // they've been disabled.
        $_MISSING_PLUGINS = array();

        // Query {$_TABLES['plugins']} to get a list of installed plugins
        $missing_plugins = 0;
        $result = DB_query("SELECT pi_name FROM {$_TABLES['plugins']} WHERE pi_enabled = 1");
        $num_plugins = DB_numRows($result);

        for ($i = 0; $i < $num_plugins; $i++) { // Look in the plugins directories to ensure that those plugins exist.
            $plugin = DB_fetchArray($result);

            if (!file_exists($_CONF['path'] . 'plugins/' . $plugin['pi_name'])) { // If plugin does not exist
                // Deactivate the plugin
                DB_query("UPDATE {$_TABLES['plugins']} SET pi_enabled='0' WHERE pi_name='{$plugin['pi_name']}'");
                $_MISSING_PLUGINS[] = $plugin['pi_name'];
                $missing_plugins++;
            }
        }

        // Any missing plugins have been disabled, now we can get lib-common.php
        // so we can call COM_errorLog().
        require_once $html_path . 'lib-common.php';

        // including lib-common.php overwrites our $language variable
        $language = $this->env['language'];

        // Log any missing plugins
        if (count($_MISSING_PLUGINS) > 0) {
            foreach ($_MISSING_PLUGINS as $m_p) {
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[27] . $m_p . $LANG_MIGRATE[28]);
            }
        }

        $disabled_plugins = 0;

        if ($version != self::GL_VERSION) {
            // We did a database upgrade above. Now that any missing plugins
            // have been disabled and we've loaded lib-common.php, perform
            // upgrades for the remaining plugins.
            $disabled_plugins = $this->pluginUpgrades(true, $_OLD_CONF);
        }

        // finally, check for any new plugins and install them
        //        $this->autoInstallNewPlugins();

        /**
         * Check for other missing files
         * e.g. images/articles, images/topics, images/userphotos
         */
        $missing_images = false;

        // Article images
        $missing_article_images = false;
        $result = DB_query("SELECT `ai_filename` FROM {$_TABLES['article_images']}");
        $num_article_images = DB_numRows($result);

        for ($i = 0; $i < $num_article_images; $i++) {
            $article_image = DB_fetchArray($result, false); //

            if (!file_exists($html_path . 'images/articles/' . $article_image['ai_filename'])) { // If article image does not exist
                // Log the error
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[29] . $article_image['ai_filename'] . $LANG_MIGRATE[30] . $_TABLES['article_images'] . $LANG_MIGRATE[31] . $html_path . 'images/articles/');
                $missing_article_images = true;
                $missing_images = true;
            }
        }

        // Topic images
        $missing_topic_images = false;
        $result = DB_query("SELECT `imageurl` FROM {$_TABLES['topics']}");
        $num_topic_images = DB_numRows($result);

        for ($i = 0; $i < $num_topic_images; $i++) {
            $topic_image = DB_fetchArray($result, false);

            if (!file_exists($html_path . $topic_image['imageurl'])) { // If topic image does not exist
                // Log the error
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[29] . $topic_image['imageurl'] . $LANG_MIGRATE[30] . $_TABLES['topics'] . $LANG_MIGRATE[31] . $html_path . 'images/topics/');
                $missing_topic_images = true;
                $missing_images = true;
            }
        }

        // Userphoto images
        $missing_userphoto_images = false;
        $result = DB_query("SELECT `photo` FROM {$_TABLES['users']} WHERE `photo` IS NOT NULL AND `photo` <> ''");
        $num_userphoto_images = DB_numRows($result);

        for ($i = 0; $i < $num_userphoto_images; $i++) {
            $userphoto_image = DB_fetchArray($result, false);

            if (!file_exists($html_path . 'images/userphotos/' . $userphoto_image['photo'])) { // If userphoto image does not exist
                // Log the error
                COM_errorLog($LANG_MIGRATE[26] . $LANG_MIGRATE[29] . $userphoto_image['photo'] . $LANG_MIGRATE[30] . $_TABLES['users'] . $LANG_MIGRATE[31] . $html_path . 'images/userphotos/');
                $missing_userphoto_images = true;
                $missing_images = true;
            }
        }

        // did the site URL change?
        if ((!empty($_OLD_CONF['site_url'])) & (!empty($_CONF['site_url'])) && ($_OLD_CONF['site_url'] != $_CONF['site_url'])) {
            self::updateSiteUrl($_OLD_CONF['site_url'], $_CONF['site_url']);
        }

        // Clear the Geeklog Cache in case paths etc. in cache files
        $this->clearCache();

        /**
         * Import complete.
         */

        // Check if there are any missing files or plugins
        if ($missing_images || ($missing_plugins > 0) || ($disabled_plugins > 0)) {
            $display .= '<h2>' . $LANG_MIGRATE[37] . '</h2>' . PHP_EOL
                . '<p>' . $LANG_MIGRATE[38] . '</p>' . PHP_EOL;
            // Plugins
            if ($missing_plugins > 0) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[32] . ' <code>' . $_CONF['path'] . 'plugins/</code> ' . $LANG_MIGRATE[33], 'notice');
            }

            if ($disabled_plugins > 0) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[48]);
            }

            // Article images
            if ($missing_article_images) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[34] . ' <code>' . $html_path . 'images/articles/</code> ' . $LANG_MIGRATE[35], 'notice');
            }

            // Topic images
            if ($missing_topic_images) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[34] . ' <code>' . $html_path . 'images/topics/</code> ' . $LANG_MIGRATE[35], 'notice');
            }

            // Userphoto images
            if ($missing_userphoto_images) {
                $display .= $this->getAlertMsg($LANG_MIGRATE[34] . ' <code>' . $html_path . 'images/userphotos/</code> ' . $LANG_MIGRATE[35], 'notice');
            }

            $display .= '<p>' . $LANG_MIGRATE[36] . '</p>' . PHP_EOL
                . '<form action="success.php" method="get">' . PHP_EOL
                . '<input type="hidden" name="type" value="migrate">' . PHP_EOL
                . '<input type="hidden" name="language" value="' . $language . '">' . PHP_EOL
                . '<input type="hidden" name="" value="">' . PHP_EOL
                . '<button type="submit" class="uk-button uk-button-primary uk-margin-small" name="" value="' . $LANG_INSTALL[62] . '">' . $LANG_INSTALL[62] . '&nbsp;&nbsp;' . $this->env['icon_arrow_next'] . '</button>' . PHP_EOL
                . '</form>';
        } else {
            header('Location: success.php?type=migrate&language=' . $language);
        }

        return $display;
    }

    /**
     * Installer engine
     * The guts of the installation and upgrade package.
     *
     * @param  string  $installType  'install' or 'upgrade'
     * @param  int     $installStep  1 - 4
     * @return string
     * @throws Exception
     */
    private function installEngine($installType, $installStep)
    {
        global $_CONF, $_TABLES, $_DB, $_DB_dbms, $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix, $_DEVICE, $_URL;

        $retval = '';

        switch ($installStep) {
            // Page 1 - Enter Geeklog config information
            case 1:
                if ($installType === 'migrate') {
                    $retval = $this->migrateStep1();
                    break;
                }

                include $this->env['dbconfig_path']; // Get the current DB info

                if ($installType === 'upgrade') {
                    $v = $this->checkPost150Upgrade($this->env['dbconfig_path'], $this->env['siteconfig_path']);
                    // will skip to step 3 if possible, otherwise return here

                    if ($v == self::GL_VERSION) {
                        // looks like we're already up to date
                        $retval .= '<h2>' . $this->LANG['INSTALL'][74] . '</h2>' . PHP_EOL
                            . '<p>' . $this->LANG['INSTALL'][75] . '</p>' . PHP_EOL;

                        return $retval;
                    }
                }

                $retval .= '<h1>'
                    . $this->LANG['INSTALL'][101] . ' ' . htmlspecialchars($this->request('display_step'))
                    . ' - ' . $this->LANG['INSTALL'][102]
                    . '</h1>' . PHP_EOL;

                // Set all the form values either with their defaults or with received POST data.
                // The only instance where you'd get POST data would be if the user has to
                // go back because they entered incorrect database information.
                $site_name = $this->post('site_name', $this->LANG['INSTALL'][29]);
                $site_name = str_replace('\\', '', $site_name);
                $site_slogan = $this->post('site_slogan', $this->LANG['INSTALL'][30]);
                $site_slogan = str_replace('\\', '', $site_slogan);
                $dbType = $this->post('db_type');

                if (!empty($dbType)) {
                    switch ($dbType) {
                        case 'mysql-innodb':
                            $db_selected = 'mysql-innodb';
                            break;

                        case 'pgsql':
                            $db_selected = 'pgsql';
                            break;

                        default:
                            $db_selected = 'mysql';
                            break;
                    }
                } else {
                    switch ($_DB_dbms) {
                        case 'pgsql':
                            $db_selected = 'pgsql';
                            break;

                        default:
                            $db_selected = 'mysql';
                            break;
                    }
                }

                if (($_DB_host !== 'localhost') || ($_DB_name !== 'geeklog') ||
                    ($_DB_user !== 'username') || ($_DB_pass !== 'password')
                ) {
                    // only display those if they all have their default values
                    $_DB_host = '';
                    $_DB_name = '';
                    $_DB_user = '';
                    $_DB_pass = '';
                }

                $db_host = $this->post(
                    'db_host',
                    ($_DB_host !== 'localhost' ? '' : $_DB_host)
                );
                $db_name = $this->post(
                    'db_name',
                    ($_DB_name !== 'geeklog' ? '' : $_DB_name)
                );
                $db_user = $this->post(
                    'db_user',
                    ($_DB_user !== 'username' ? '' : $_DB_user)
                );
                $db_pass = $this->post('db_pass', '');
                $db_prefix = $this->post('db_prefix', $_DB_table_prefix);
                $site_url = $this->post('site_url', $this->getSiteUrl());
                $site_admin_url = $this->post('site_admin_url', $this->getSiteAdminUrl());
                $host_name = explode(':', $this->server('HTTP_HOST'));
                $host_name = $host_name[0];

                if (empty($_CONF['site_mail'])) {
                    $_CONF['site_mail'] = 'admin@example.com';
                }

                $site_mail = $this->post(
                    'site_mail',
                    ($_CONF['site_mail'] !== 'admin@example.com' ? $_CONF['site_mail'] : 'admin@' . $host_name)
                );

                if (empty($_CONF['noreply_mail'])) {
                    $_CONF['noreply_mail'] = 'noreply@example.com';
                }

                $noreply_mail = $this->post(
                    'noreply_mail',
                    ($_CONF['noreply_mail'] != 'noreply@example.com' ? $_CONF['noreply_mail'] : 'noreply@' . $host_name)
                );

                if ($this->post('utf8') === 'on') {
                    $utf8 = true;
                } else {
                    $utf8 = false;

                    if (strcasecmp($this->LANG['CHARSET'], 'utf-8') === 0) {
                        $utf8 = true;
                    }
                }

                $this->env['install_type'] = $installType;
                $this->env['display_step'] = $this->request('display_step');
                $this->env['help_site_name'] = $this->getHelpLink('site_name');
                $this->env['site_name'] = $site_name;
                $this->env['help_site_slogan'] = $this->getHelpLink('site_slogan');
                $this->env['site_slogan'] = $site_slogan;
                $this->env['help_db_type'] = $this->getHelpLink('db_type');
                $this->env['db_type_selector'] = $this->listOfSupportedDBs(
                    $this->env['dbconfig_path'],
                    $db_selected,
                    ($installType === 'install'),
                    ($installType === 'install')
                );
                $this->env['help_db_host'] = $this->getHelpLink('db_host');
                $this->env['db_host'] = $db_host;
                $this->env['help_db_name'] = $this->getHelpLink('db_name');
                $this->env['db_name'] = $db_name;
                $this->env['help_db_user'] = $this->getHelpLink('db_user');
                $this->env['db_user'] = $db_user;
                $this->env['help_db_pass'] = $this->getHelpLink('db_pass');
                $this->env['db_pass'] = $db_pass;
                $this->env['help_db_prefix'] = $this->getHelpLink('db_prefix');
                $this->env['db_prefix'] = $db_prefix;
                $this->env['help_site_url'] = $this->getHelpLink('site_url');
                $this->env['site_url'] = $site_url;
                $this->env['help_site_admin_url'] = $this->getHelpLink('site_admin_url');
                $this->env['site_admin_url'] = $site_admin_url;
                $this->env['help_site_mail'] = $this->getHelpLink('site_mail');
                $this->env['site_mail'] = $site_mail;
                $this->env['help_noreply_mail'] = $this->getHelpLink('noreply_mail');
                $this->env['noreply_mail'] = $noreply_mail;
                $this->env['new_install'] = ($installType === 'install');
                $this->env['help_utf8'] = $this->getHelpLink('utf8');
                $this->env['utf8'] = $utf8;
                $this->env['button_text'] = ($installType === 'install')
                    ? $this->LANG['INSTALL'][50]
                    : $this->LANG['INSTALL'][25];

                $retval .= MicroTemplate::quick(PATH_LAYOUT, 'step1', $this->env);
                break;

            // Page 2 - Enter information into db-config.php and ask about InnoDB tables (if supported)
            case 2:
                if ($installType === 'migrate') {
                    $retval = $this->migrateStep2();
                    break;
                }

                // Set all the variables from the received POST data.
                $site_name = $this->post('site_name');
                $site_slogan = $this->post('site_slogan');
                $site_url = $this->post('site_url');
                $site_admin_url = $this->post('site_admin_url');
                $site_mail = $this->post('site_mail');
                $noreply_mail = $this->post('noreply_mail');
                $utf8 = ($this->post('utf8') === 'on');
                $installPlugins = ($this->post('install_plugins') !== null);
                $DB = array(
                    'type'         => $this->post('db_type'),
                    'host'         => $this->post('db_host'),
                    'name'         => $this->post('db_name'),
                    'user'         => $this->post('db_user'),
                    'pass'         => $this->post('db_pass'),
                    'table_prefix' => $this->post('db_prefix'),
                    'utf8'         => $utf8,
                );

                // Check if $site_admin_url is correct
                if (!$this->urlExists($site_admin_url)) {
                    $retval .= '<h2>' . $this->LANG['INSTALL'][104] . '</h2>' . PHP_EOL
                        . '<p>' . $this->LANG['INSTALL'][105] . '</p>' . PHP_EOL
                        . $this->showReturnFormData($_POST) . PHP_EOL;
                    // Check for blank password in production environment
                } elseif (!$this->checkDbPassword($site_url, $DB)) {
                    $retval .= '<h2>' . $this->LANG['INSTALL'][54] . '</h2>' . PHP_EOL
                        . '<p>' . $this->LANG['INSTALL'][107] . '</p>' . PHP_EOL
                        . $this->showReturnFormData($_POST) . PHP_EOL;
                    // Check if we can connect to the database
                } elseif (!$this->dbConnect($DB)) {
                    $retval .= '<h2>' . $this->LANG['INSTALL'][54] . '</h2>' . PHP_EOL
                        . '<p>' . $this->LANG['INSTALL'][55] . '</p>'
                        . $this->showReturnFormData($_POST) . PHP_EOL;
                    // Check if the user's version of MySQL is out of date
                } elseif ($this->isMysqlOutOfDate($DB)) {
                    $mysqlVersion = $this->getMysqlVersion($DB['host'], $DB['user'], $DB['pass']);
                    $retval .= '<h1>' . sprintf($this->LANG['INSTALL'][51], self::SUPPORTED_MYSQL_VER) . '</h1>' . PHP_EOL
                        . '<p>' . sprintf($this->LANG['INSTALL'][52], self::SUPPORTED_MYSQL_VER)
                        . (is_array($mysqlVersion) ? implode('.', $mysqlVersion) : '?')
                        . $this->LANG['INSTALL'][53] . '</p>' . PHP_EOL;
                    // Check if database doesn't exist
                } elseif (!$this->dbExists($DB)) {
                    $retval .= '<h2>' . $this->LANG['INSTALL'][56] . '</h2>' . PHP_EOL
                        . '<p>' . $this->LANG['INSTALL'][57] . '</p>' . PHP_EOL
                        . $this->showReturnFormData($_POST) . PHP_EOL;
                } else {
                    // Write the database info to db-config.php
                    if (!$this->writeConfig($this->env['dbconfig_path'], $DB)) {
                        exit($this->LANG['INSTALL'][26] . ' ' . htmlspecialchars($this->env['dbconfig_path'])
                            . $this->LANG['INSTALL'][58]);
                    }

                    // for the default charset, patch siteconfig.php again
                    if ($installType !== 'upgrade') {
                        if (!$this->setDefaultCharset($this->env['siteconfig_path'],
                            ($utf8 ? 'utf-8' : $this->LANG['CHARSET']))
                        ) {
                            exit($this->LANG['INSTALL'][26] . ' ' . $this->env['siteconfig_path']
                                . $this->LANG['INSTALL'][58]);
                        }
                    }

                    $this->includeConfig($this->env['dbconfig_path']);
                    require_once $this->env['siteconfig_path'];
                    $_CONF['path_system'] = $this->env['gl_path'] . '/system/';
                    require_once $_CONF['path_system'] . 'lib-database.php';

                    $params = array(
                        'mode'            => $installType,
                        'step'            => 3,
                        'dbconfig_path'   => $this->env['dbconfig_path'],
                        'install_plugins' => ($installPlugins ? 'true' : 'false'),
                        'language'        => $this->env['language'],
                        'site_name'       => $site_name,
                        'site_slogan'     => $site_slogan,
                        'site_url'        => $site_url,
                        'site_admin_url'  => $site_admin_url,
                        'site_mail'       => $site_mail,
                        'noreply_mail'    => $noreply_mail,
                        //'upgrade_check'   => $this->post('upgrade_check', 'confirmed'),
                    );

                    if ($utf8) {
                        $params['utf8'] = 'true';
                    }

                    $req_string = 'index.php?' . http_build_query($params);

                    switch ($installType) {
                        case 'install':
                            $this->env['installType'] = $installType;
                            $this->env['utf8_string'] = $utf8 ? 'true' : 'false';

                            // If using MySQL check to see if InnoDB is supported
                            if ($DB['type'] === 'mysql-innodb' && !$this->isInnodbSupported()) {
                                // Warn that InnoDB tables are not supported
                                $retval .= MicroTemplate::quick(PATH_LAYOUT, 'step2-install', array_merge($this->env, $params));
                            } else {
                                // Continue on to step 3 where the installation will happen
                                if ($DB['type'] === 'mysql-innodb') {
                                    $req_string .= '&innodb=true';
                                }

                                header('Location: ' . $req_string);
                            }

                            break;

                        case 'upgrade':
                            // Try and find out what the current version of GL is
                            $currentVersion = $this->identifyGeeklogVersion();

                            if ($currentVersion == self::GL_VERSION) {
                                // If current version is the newest version
                                // then there's no need to update.
                                $retval .= '<h2>' . $this->LANG['INSTALL'][74] . '</h2>' . PHP_EOL
                                    . '<p>' . $this->LANG['INSTALL'][75] . '</p>';
                            } elseif ($currentVersion === 'empty') {
                                $retval .= '<h2>' . $this->LANG['INSTALL'][90] . '</h2>' . PHP_EOL
                                    . '<p>' . $this->LANG['INSTALL'][91] . '</p>';
                            } else {
                                if (!empty($currentVersion)) {
                                    // Continue on to step 3 where the upgrade will happen
                                    header('Location: ' . $req_string . '&version=' . $currentVersion);
                                }

                                // If we were unable to determine the current GL
                                // version is then ask the user what it is
                                $this->env['old_versions'] = array();
                                $old_versions = array(
                                    '1.2.5-1', '1.3', '1.3.1', '1.3.2', '1.3.2-1', '1.3.3', '1.3.4',
                                    '1.3.5', '1.3.6', '1.3.7', '1.3.8', '1.3.9', '1.3.10', '1.3.11',
                                    '1.4.0', '1.4.1', '1.5.0', '1.5.1', '1.5.2', '1.6.0', '1.6.1',
                                    '1.7.0', '1.7.1', '1.7.2', '1.8.0', '1.8.1', '1.8.2', '2.0.0',
                                    '2.1.0', '2.1.1', '2.2.0',
                                );
                                $tempCounter = 0;

                                foreach ($old_versions as $version) {
                                    $this->env['old_versions'][] = array(
                                        'selected' => (($tempCounter === count($old_versions) - 1) ? ' selected="selected"' : ''),
                                        'value'    => $version,
                                    );
                                    $tempCounter++;
                                }

                                $retval .= MicroTemplate::quick(PATH_LAYOUT, 'step2-upgrade', $this->env);
                                $currentVersion = $old_versions[count($old_versions) - 1];
                            }

                            break;
                    }
                }

                break;

            // Page 3 - Install
            case 3:
                if ($installType === 'migrate') {
                    $this->migrateStep3();  // Go on to bigdump.php so will not return here
                    break;
                }

                $gl_path = str_replace(self::DB_CONFIG_FILE, '', $this->env['dbconfig_path']);
                $installPlugins = ($this->request('install_plugins') === 'true');
                $nextLink = $installPlugins
                    ? 'install-plugins.php?language=' . $this->env['language']
                    : 'success.php?type=' . $installType . '&language=' . $this->env['language'];

                switch ($installType) {
                    case 'install':
                        if ($this->post('submit') === '<< ' . $this->LANG['INSTALL'][61]) {
                            header('Location: index.php?mode=install');
                        }

                        // Check whether to use InnoDB tables
                        $use_innodb = ($this->post('innodb') === 'true') || ($this->get('innodb') === 'true');
                        $this->env['use_innodb'] = $use_innodb;
                        $utf8 = ($this->post('utf8') === 'true') || ($this->get('utf8') === 'true');

                        // We need all this just to do one DB query
                        $this->includeConfig($this->env['dbconfig_path']);
                        require_once $this->env['siteconfig_path'];
                        $_CONF['path_system'] = $this->env['gl_path'] . '/system/';
                        require_once $_CONF['path_system'] . 'lib-database.php';

                        if ($_DB_dbms === 'pgsql') {
                            //Create a func to check if plpgsql is already installed
                            DB_query("CREATE OR REPLACE FUNCTION make_plpgsql()
                    RETURNS VOID LANGUAGE SQL AS $$
                    CREATE LANGUAGE plpgsql;
                    $$;
                    SELECT
                        CASE
                        WHEN EXISTS( SELECT 1 FROM pg_catalog.pg_language WHERE lanname='plpgsql')
                        THEN NULL
                        ELSE make_plpgsql() END;");
                            //Create a function to check if table exists
                            DB_query("CREATE OR REPLACE FUNCTION check_table(varchar, varchar)
                        RETURNS boolean AS $$
                         DECLARE
                           v_cnt integer;
                           v_tbl boolean;
                         BEGIN
                           SELECT count(1) INTO v_cnt FROM pg_tables where tablename = $1 and
                        schemaname = $2;
                            IF v_cnt > 0 THEN
                             v_tbl = 'true';
                            END IF;
                        return v_tbl;
                        END;
                        $$ LANGUAGE 'plpgsql'");
                        }

                        // Check if GL is already installed
                        if ($this->tableExists('vars')) {
                            $this->env['use_innodb_string'] = $use_innodb ? 'true' : 'false';
                            $this->env['installPlugins'] = $installPlugins ? 'true' : 'false';
                            $site_name = $this->post('site_name', $this->get('site_name', ''));
                            $site_slogan = $this->post('site_slogan', $this->get('site_slogan', ''));
                            $site_url = $this->post('site_url', $this->get('site_url', ''));
                            $site_admin_url = $this->post('site_admin_url', $this->get('site_admin_url', ''));
                            $site_mail = $this->post('site_mail', $this->get('site_mail', ''));
                            $noreply_mail = $this->post('noreply_mail', $this->get('noreply_mail', ''));

                            $site_name = urldecode($site_name);
                            $site_name = $this->cleanString($site_name);
                            $site_slogan = urldecode($site_slogan);
                            $site_slogan = $this->cleanString($site_slogan);

                            $this->env['site_name'] = $site_name;
                            $this->env['site_slogan'] = $site_slogan;
                            $this->env['site_url'] = urldecode($site_url);
                            $this->env['site_admin_url'] = urldecode($site_admin_url);
                            $this->env['site_mail'] = urldecode($site_mail);
                            $this->env['noreply_mail'] = urldecode($noreply_mail);
                            $retval .= MicroTemplate::quick(PATH_LAYOUT, 'step3-install', $this->env);
                        } else {
                            if ($this->createDatabaseStructures()) {
                                $site_name = $this->post('site_name', $this->get('site_name', ''));
                                $site_slogan = $this->post('site_slogan', $this->get('site_slogan', ''));
                                $site_url = $this->post('site_url', $this->get('site_url', ''));
                                $site_admin_url = $this->post('site_admin_url', $this->get('site_admin_url', ''));
                                $site_mail = $this->post('site_mail', $this->get('site_mail', ''));
                                $noreply_mail = $this->post('noreply_mail', $this->get('noreply_mail', ''));
                                $this->personalizeAdminAccount($site_mail, $site_url);

                                // Insert the form data into the conf_values table
                                $site_name = urldecode($site_name);
                                $site_name = $this->cleanString($site_name);
                                $site_slogan = urldecode($site_slogan);
                                $site_slogan = $this->cleanString($site_slogan);

                                require_once $_CONF['path_system'] . 'classes/ConfigInterface.php';
                                require_once $_CONF['path_system'] . 'classes/config.class.php';
                                require_once PATH_INSTALL . 'config-install.php';
                                $config = config::get_instance();
                                install_config($config);

                                $config->set('site_name', $site_name);
                                $config->set('site_slogan', $site_slogan);
                                $config->set('site_url', urldecode($site_url));
                                $config->set('site_admin_url', urldecode($site_admin_url));
                                $config->set('site_mail', urldecode($site_mail));
                                $config->set('noreply_mail', urldecode($noreply_mail));
                                $config->set('path_html', $this->env['html_path']);
                                $config->set('path_log', $gl_path . 'logs/');
                                $config->set('path_language', $gl_path . 'language/');
                                $config->set('backup_path', $gl_path . 'backups/');
                                $config->set('path_data', $gl_path . 'data/');
                                $config->set('path_images', $this->env['html_path'] . 'images/');
                                $config->set('path_themes', $this->env['html_path'] . 'layout/');
                                $config->set('path_editors', $this->env['html_path'] . 'editors/');
                                $config->set('rdf_file', $this->env['html_path'] . 'backend/geeklog.rss');
                                $config->set('cookie_path', $this->guessCookiePath(urldecode($site_url)));
                                $config->set_default('default_photo', urldecode($site_url) . '/images/userphotos/default.png');

                                $lng = $this->getDefaultLanguage($gl_path . 'language/', $this->env['language'], $utf8);

                                if (!empty($lng)) {
                                    $config->set('language', $lng);
                                }

                                $this->setVersion($this->env['siteconfig_path']);

                                if (!$installPlugins) {
                                    // do a default install of all available plugins

                                    /**
                                     * For the plugin install we would actually need
                                     * lib-common.php in the global namespace. Since
                                     * we're in a function, we need to hack a few
                                     * things and rely on a few global declarations
                                     * (see beginning of function).
                                     */
                                    require str_replace('siteconfig.php', 'lib-common.php', $this->env['siteconfig_path']);
                                    $this->defaultPluginInstall();
                                }

                                // Installation is complete. Continue onto either
                                // custom plugin installation page or success page
                                header('Location: ' . $nextLink);
                            } else {
                                $retval .= '<h2>' . $this->LANG['INSTALL'][67] . '</h2>' . PHP_EOL
                                    . '<p>' . $this->LANG['INSTALL'][68] . '</p>' . PHP_EOL;
                            }
                        }

                        break;

                    case 'upgrade':
                        // Get and set which version to display
                        $version = $this->get('version', $this->post('version', ''));

                        // Let's do this
                        $this->includeConfig($this->env['dbconfig_path']);
                        require_once $this->env['siteconfig_path'];
                        require_once $_CONF['path_system'] . 'lib-database.php';

                        // Check for any upgrade info and/or warning messages for specific upgrade path. Skip if continued has been clicked already
                        if ($this->post('upgrade_check') !== 'confirmed') {
                            $retval = $this->checkUpgradeMessage($version);
                            if (!empty($retval)) {
                                return $retval;
                            }
                        }

                        // If this is a MySQL database check to see if it was
                        // installed with InnoDB support
                        if ($_DB_dbms === 'mysql') {
                            // Query `vars` and see if 'database_engine' == 'InnoDB'
                            $result = DB_query("SELECT value FROM {$_TABLES['vars']} WHERE name = 'database_engine'");
                            $row = DB_fetchArray($result);
                            $this->env['use_innodb'] = $use_innodb = ($row['value'] === 'InnoDB');
                        }

                        if ($this->doDatabaseUpgrades($version)) {
                            if (version_compare($version, '1.5.0') < 0) {
                                // After updating the database we'll want to update some of the information from the form.
                                $site_name = $this->post('site_name', $this->get('site_name', ''));
                                $site_slogan = $this->post('site_slogan', $this->get('site_slogan', ''));
                                $site_url = $this->post('site_url', $this->get('site_url', ''));
                                $site_admin_url = $this->post('site_admin_url', $this->get('site_admin_url', ''));
                                $site_mail = $this->post('site_mail', $this->get('site_mail', ''));
                                $noreply_mail = $this->post('noreply_mail', $this->get('noreply_mail', ''));

                                $site_name = urldecode($site_name);
                                $site_name = $this->cleanString($site_name);
                                $site_slogan = urldecode($site_slogan);
                                $site_slogan = $this->cleanString($site_slogan);

                                require_once $_CONF['path_system'] . 'classes/ConfigInterface.php';
                                require_once $_CONF['path_system'] . 'classes/config.class.php';
                                $config = config::get_instance();
                                $config->set('site_name', $site_name);
                                $config->set('site_slogan', $site_slogan);
                                $config->set('site_url', urldecode($site_url));
                                $config->set('site_admin_url', urldecode($site_admin_url));
                                $config->set('site_mail', urldecode($site_mail));
                                $config->set('noreply_mail', urldecode($noreply_mail));
                                $config->set_default('default_photo', urldecode($site_url) . '/images/userphotos/default.png');
                            } else {
                                $site_url = $this->post('site_url', $this->get('site_url', ''));
                                $site_admin_url = $this->post('site_admin_url', $this->get('site_admin_url', ''));
                            }

                            $this->fixPathsAndUrls(
                                $_CONF['path'], $this->env['html_path'],
                                urldecode($site_url), urldecode($site_admin_url)
                            );

                            // disable plugins for which we don't have the source files
                            $this->checkPlugins();

                            // extra step 4: upgrade plugins
                            $nextLink = 'index.php?step=4&mode=' . $installType
                                . '&language=' . $this->env['language'];

                            if ($installPlugins) {
                                $nextLink .= '&install_plugins=true';
                            }

                            header('Location: ' . $nextLink);
                        } else {
                            $retval .= '<h2>' . $this->LANG['INSTALL'][78] . '</h2>' . PHP_EOL
                                . '<p>' . $this->LANG['INSTALL'][79] . '</p>' . PHP_EOL;
                        }

                        break;
                }

                // Clear the Geeklog Cache
                $this->clearCache();
                break;

            // Extra Step 4 - Upgrade plugins
            case 4:
                if ($installType === 'migrate') {
                    $retval = $this->migrateStep4();
                    break;
                }

                $this->upgradePlugins();
                $installPlugins = ($this->get('install_plugins') === 'true');

                if (!$installPlugins) {
                    // if we don't do the manual selection, install all new plugins now
                    $this->autoInstallNewPlugins();
                }

                $nextLink = $installPlugins
                    ? 'install-plugins.php?language=' . $this->env['language']
                    : 'success.php?type=' . $installType . '&language=' . $this->env['language'];
                header('Location: ' . $nextLink);
                break;
        }

        return $retval;
    }

    /**
     * Display the installer
     */
    public function display($content)
    {
		// Need to do this for install-plugins.php when called for a new install but want to select plugins
		if (!isset($this->env['language_selector_menu'])) {
			$this->env['language_selector'] = '';
			$this->env['language_selector_menu'] = 'uk-hidden';
		}

        $this->env['content'] = $content;
        $T = $this->getTemplateObject();
        $T->set($this->env);
        $T->display('index');
    }

    /**
     * Run the installer
     */
    public function run()
    {
        global $_CONF, $_TABLES, $_VARS, $_URL, $_DEVICE, $_SCRIPTS, $_IMAGE_TYPE, $TEMPLATE_OPTIONS, $_GROUPS, $_RIGHTS, $_USER, $_DB_dbms, $_DB_table_prefix;

        // Prepare some hints about what /path/to/geeklog might be ...
        $this->env['gl_path'] = BASE_FILE;

        for ($i = 0; $i < 4; $i++) {
            $remains = strrchr($this->env['gl_path'], '/');

            if ($remains === false) {
                break;
            } else {
                $this->env['gl_path'] = substr($this->env['gl_path'], 0, -strlen($remains));
            }
        }

        $this->env['html_path'] = $this->getHtmlPath();
        $this->env['siteconfig_path'] = $this->env['html_path'] . 'siteconfig.php';
        $this->env['dbconfig_path'] = $this->post('dbconfig_path', $this->get('dbconfig_path', ''));
        $this->env['dbconfig_path'] = $this->sanitizePath($this->env['dbconfig_path']);
        $this->env['use_innodb'] = false;


        // Need conf php error reporting settings
        // Use Geeklog settings since they get overwritten anyways when lib-common is included
        require_once $this->env['siteconfig_path'];
        if ((isset($_CONF['developer_mode']) && ($_CONF['developer_mode'] === true)) &&
            isset($_CONF['developer_mode_php'], $_CONF['developer_mode_php']['error_reporting'])) {
            error_reporting((int) $_CONF['developer_mode_php']['error_reporting']);
        } else {
            // Same setting as Geeklog - Prevent PHP from reporting uninitialized variables
            error_reporting(E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR);
        }

        // Set UI language selector if necessary
        if (empty($this->env['mode']) || ($this->env['mode'] === 'check_permissions')) {
            $this->env['language_selector'] = $this->getLanguageSelector();
            $this->env['language_selector_menu'] = '';
        } else {
            // This only works on the first page so hide any language stuff
            $this->env['language_selector'] = '';
            $this->env['language_selector_menu'] = 'uk-hidden';
        }

        // Render content
        switch ($this->env['mode']) {
            // The script first checks the location of the db-config.php file. By default
            // the file is located in Geeklog-1.x/ but the script will also check the
            // public_html/ directory. If the script can't find the file in either of these
            // two places, then it will ask the user to user its location.
            default:
                $content = $this->checkFileLocations();
                break;

            // The second step is to check permissions on the files/directories
            // that Geeklog needs to be able to write to. The script uses the location of
            // db-config.php from the previous step to determine location of everything.
            case 'check_permissions':
                $content = $this->checkPermissions();
                break;

            // Write the GL path to siteconfig.php
            case 'write_paths':
                $content = $this->writeSiteConfig();
                break;

            // Start the install/upgrade process
            case 'install': // Deliberate fall-through, no "break"
            case 'upgrade':
            case 'migrate':
                if ($this->env['mode'] === 'migrate') {
                    // Need conf paths etc for migration
                    require_once $this->env['siteconfig_path'];
                }
                if (($this->env['step'] == 4) && ($this->env['mode'] !== 'migrate')) {
                    // for the plugin install and upgrade,
                    // we need lib-common.php in the global(!) namespace
                    require_once dirname(dirname(dirname(__DIR__))) . '/lib-common.php';
                }

                // Run the installation function
                $content = $this->installEngine($this->env['mode'], $this->env['step']);
                break;
        }

        $this->display($content);
    }
}
