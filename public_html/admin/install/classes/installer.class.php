<?php

use Geeklog\Install\Common;
use Geeklog\Install\Install;
use Geeklog\Install\Migrate;
use Geeklog\Install\Upgrade;

require_once __DIR__ . '/Common.php';

/**
 * Class Installer
 */
class Installer extends Common
{
    /**
     * Installer constructor.
     */
    public function __construct()
    {
        global $LANG_BIGDUMP, $LANG_CHARSET, $LANG_DIRECTION, $LANG_ERROR, $LANG_HELP,
               $LANG_INSTALL, $LANG_LABEL, $LANG_MIGRATE, $LANG_PLUGINS, $LANG_SUCCESS;

        // this is not ideal but will stop PHP 5.3.0ff from complaining ...
        date_default_timezone_set(@date_default_timezone_get());

        $langInfo = @include_once __DIR__ . '/../language/_list.php';
        uasort($langInfo, function ($a, $b) {
            return strcasecmp($a['langName'], $b['langName']);
        });
        Common::$languages = $langInfo;

        Common::$env['mode'] = $this->get('mode', $this->post('mode', ''));
        Common::$env['step'] = intval($this->get('step', $this->post('step', 1)), 10);
        Common::$env['language_selector'] = '';
        $language = $this->post('language', $this->get('language', $this->getDefaultLanguage()));

        // Upgrade Message check flag for if continue button clicked if any messages present
        Common::$env['upgrade_check'] = $this->get('upgrade_check', $this->post('upgrade_check', ''));

        // Include language file
        if (!file_exists(PATH_INSTALL . 'language/' . $language . '.php')) {
            $language = self::DEFAULT_LANGUAGE;
        }
        Common::$env['language'] = $language;
        require_once PATH_INSTALL . 'language/' . $language . '.php';

        if (!isset($LANG_DIRECTION)) {
            $LANG_DIRECTION = 'ltr';
        }
        Common::$env['rtl'] = ($LANG_DIRECTION === 'rtl') ? '-rtl' : '';
        if ($LANG_DIRECTION === 'rtl') {
            Common::$env['icon_arrow_next'] = '<span uk-icon="icon: chevron-double-left"></span>';
            Common::$env['icon_arrow_prev'] = '<span uk-icon="icon: chevron-double-right"></span>';
        } else {
            Common::$env['icon_arrow_next'] = '<span uk-icon="icon: chevron-double-right"></span>';
            Common::$env['icon_arrow_prev'] = '<span uk-icon="icon: chevron-double-left"></span>';
        }

        Common::$env['LANG'] = Common::$LANG = [
            'BIGDUMP'   => $LANG_BIGDUMP,
            'CHARSET'   => $LANG_CHARSET,
            'DIRECTION' => $LANG_DIRECTION,
            'ERROR'     => $LANG_ERROR,
            'HELP'      => $LANG_HELP,
            'INSTALL'   => $LANG_INSTALL,
            'LABEL'     => $LANG_LABEL,
            'MIGRATE'   => $LANG_MIGRATE,
            'PLUGINS'   => $LANG_PLUGINS,
            'SUCCESS'   => $LANG_SUCCESS,
        ];

        // Check PHP version and exit the installer if the environment is too old
        $this->checkPhpVersion();

        // Check the size of an uploaded file
        $this->checkUploadedFileSize();
    }

    /**
     * Convert a string like '2m' to bytes
     *
     * @param  string  $val
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
                $content = '<h1>' . Common::$LANG['ERROR'][8] . '</h1>' . PHP_EOL
                    . $this->getAlertMessage(Common::$LANG['ERROR'][7], 'error');
                $this->display($content);
                die(1);
            }
        }
    }

    /**
     * Check PHP version and exit if the environment is too old
     */
    public function checkPhpVersion()
    {
        if (version_compare(PHP_VERSION, self::SUPPORTED_PHP_VER) >= 0) {
            return;
        }

        $msg = '<p>' . sprintf(Common::$LANG['INSTALL'][5], '<strong>' . self::SUPPORTED_PHP_VER . '</strong>')
            . '<strong>' . PHP_VERSION . '</strong>' . Common::$LANG['INSTALL'][6] . '</p>' . PHP_EOL;
        $msg = $this->getAlertMessage($msg, 'error');

        $content = '<h1>' . Common::$LANG['INSTALL'][3] . '</h1>' . PHP_EOL
            . $msg . PHP_EOL;

        $this->display($content);
        die(1);
    }

    public function getLanguage()
    {
        return Common::$env['language'];
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
     * Check the location of db-config.php.  We'll base our /path/to/geeklog on its location
     *
     * @return string
     */
    private function checkFileLocations()
    {
        Common::$env['gl_path'] .= '/';
        Common::$env['dbconfig_path'] = '';

        if (file_exists(Common::$env['gl_path'] . self::DB_CONFIG_FILE) ||
            file_exists(Common::$env['gl_path'] . 'public_html/' . self::DB_CONFIG_FILE)
        ) {
            // See whether the file/directory is located in the default place or in public_html
            Common::$env['dbconfig_path'] = file_exists(Common::$env['gl_path'] . self::DB_CONFIG_FILE)
                ? Common::$env['gl_path'] . self::DB_CONFIG_FILE
                : Common::$env['gl_path'] . 'public_html/' . self::DB_CONFIG_FILE;

            // If the script was able to locate all the system files/directories move onto the next step
            $args = [
                'mode'          => 'check_permissions',
                'dbconfig_path' => Common::$env['dbconfig_path'],
            ];

            if (!empty(Common::$env['language'])) {
                $args['language'] = Common::$env['language'];
            }

            $url = 'index.php?' . http_build_query($args);
            header('Location: ' . $url);
        }

        Common::$env['base_file'] = str_replace('\\', '/', BASE_FILE);
        Common::$env['search_here'] = sprintf(
            Common::$LANG['INSTALL'][96],
            '<code>' . self::DB_CONFIG_FILE . '</code>'
        );

        return MicroTemplate::quick(PATH_LAYOUT, 'system_path', Common::$env);
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
        $paths = [
            'db-config.php' => $this->sanitizePath(urldecode($_REQUEST['dbconfig_path'])),
            'public_html/'  => $this->sanitizePath(urldecode($_REQUEST['public_html_path'])),
        ];
        Common::$env['dbconfig_path'] = str_replace(self::DB_CONFIG_FILE, '', $paths['db-config.php']);

        // Edit siteconfig.php and enter the correct GL path and system directory path
        clearstatcache();
        Common::$env['siteconfig_path'] = $paths['public_html/'] . 'siteconfig.php';
        $siteConfigData = @file_get_contents(Common::$env['siteconfig_path']);

        // $_CONF['path']
        $_CONF = [];
        require Common::$env['siteconfig_path']; // must acquire CONF again for compare so use require and not require_once as file could have been called before
        $siteConfigData = str_replace(
            "\$_CONF['path'] = '{$_CONF['path']}';",
            "\$_CONF['path'] = '" . str_replace('db-config.php', '', $paths['db-config.php']) . "';",
            $siteConfigData
        );

        if (@file_put_contents(Common::$env['siteconfig_path'], $siteConfigData) === false) {
            exit(Common::$LANG['INSTALL'][26] . ' ' . $paths['public_html/'] . Common::$LANG['INSTALL'][28]);
        }

        // Continue onto the install, upgrade, or migration
        switch ($this->get('op')) {
            case 'migrate':
                header('Location: index.php?mode=migrate'
                    . '&dbconfig_path=' . urlencode($paths['db-config.php'])
                    . '&public_html_path=' . urlencode($paths['public_html/'])
                    . '&language=' . Common::$env['language']);
                break;

            case Common::$LANG['INSTALL'][24] || Common::$LANG['INSTALL'][25]:
                // install or upgrade
                header('Location: index.php?mode=' . $_GET['op']
                    . '&dbconfig_path=' . urlencode($paths['db-config.php'])
                    . '&language=' . Common::$env['language']
                    . '&display_step=' . $_REQUEST['display_step']);
                break;

            default:
                $retval = '<p>' . Common::$LANG['INSTALL'][100] . '</p>' . PHP_EOL;
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
        $paths = [
            'db-config.php' => $this->sanitizePath(urldecode($this->get('dbconfig_path', $this->post('dbconfig_path', '')))),
            'public_html/'  => $this->getHtmlPath(),
        ];

        // Be fault-tolerant with the path the user enters
        if (strpos($paths['db-config.php'], self::DB_CONFIG_FILE) === false) {
            $paths['db-config.php'] = rtrim($paths['db-config.php'], '/') . '/' . self::DB_CONFIG_FILE;
        }

        // The path to db-config.php is what we'll use to generate our /path/to/geeklog so
        // we want to make sure it's valid and exists before we continue and create problems.
        if (!file_exists($paths['db-config.php'])) {
            Common::$env['path_db_config'] = $paths['db-config.php'];
            $retval = MicroTemplate::quick(PATH_LAYOUT, 'system_path_error', Common::$env);

            return $retval;
        }

        $_DB_dbms = '';
        require_once $paths['db-config.php'];       // We need db-config.php the current DB information
        require_once Common::$env['siteconfig_path']; // We need siteconfig.php for core $_CONF values.

        Common::$env['gl_path'] = str_replace(self::DB_CONFIG_FILE, '', $paths['db-config.php']);

        // number of files with wrong permissions
        $numWrong = 0;
        $retval_permissions = '
            <div class="uk-overflow-auto">
            <table class="uk-table uk-table-small">
                <thead>
                    <tr>
                        <th><strong>' . Common::$LANG['INSTALL'][10] . '</strong></th>
                        <th><strong>' . Common::$LANG['INSTALL'][11] . '</strong></th>
                    </tr>
                </thead>
                <tbody>';

        $chmodString = 'chmod -R 777 ';

        // Files to check if writable
        $fileList = [
            $paths['db-config.php'],
            Common::$env['gl_path'] . 'data/',
            Common::$env['gl_path'] . 'data/cache/',
            Common::$env['gl_path'] . 'data/layout_cache/',
            Common::$env['gl_path'] . 'data/layout_css/',
            Common::$env['gl_path'] . 'logs/404.log',
            Common::$env['gl_path'] . 'logs/access.log',
            Common::$env['gl_path'] . 'logs/error.log',
            Common::$env['gl_path'] . 'logs/spamx.log',
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
        ];

        if ($_DB_dbms === 'mysql') {
            array_splice($fileList, 1, 0, Common::$env['gl_path'] . 'backups/');
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
                        <td><span class="uk-text-danger uk-text-nowrap">' . Common::$LANG['INSTALL'][12] . ' ' . $permShouldBe . '</span> (' . Common::$LANG['INSTALL'][13] . ' ' . $permission . ')</td>
                    </tr>';

                $chmodString .= $file . ' ';
                $numWrong++;
            }
        }
        $retval_permissions .= '</tbody></table></div>';

        $retval_step = 1;

        // Display permissions, etc
        if ($checkSelinux) {
            $retval .= '<h1>' . Common::$LANG['INSTALL'][101] . ' ' . $retval_step . ' - ' . Common::$LANG['INSTALL'][97] . '</h1>' . PHP_EOL
                . Common::$LANG['INSTALL'][110];
            $cmd = 'chcon -Rt httpd_user_rw_content_t ' . $cmdSelinux;
            $retval .= '<pre><code>' . $cmd . PHP_EOL
                . '</code></pre><br>' . PHP_EOL;
            $retval_step++;
        } elseif ($numWrong) {
            // If any files have incorrect permissions
            $retval .= '<h1>' . Common::$LANG['INSTALL'][101] . ' ' . $retval_step . ' - ' . Common::$LANG['INSTALL'][97] . '</h1>' . PHP_EOL;
            $retval_step++;

            if ($this->get('install_type') !== null) {
                // If the user tried to start an installation before setting file permissions
                $retval .= '<p>'
                    . '<div class="uk-alert-danger" uk-alert>'
                    . '<a class="uk-alert-close" uk-close></a>'
                    . '<span class="uk-label uk-label-danger">' . Common::$LANG['INSTALL'][38] . '</span> '
                    . Common::$LANG['INSTALL'][21]
                    . '</div>' . PHP_EOL;
            } else {
                // The first page that is displayed during the "check_permissions" step
                $retval .= '<p>' . Common::$LANG['INSTALL'][9] . '</p>' . PHP_EOL
                    . '<p>' . Common::$LANG['INSTALL'][19] . '</p>' . PHP_EOL;
            }

            // List the files that have incorrect permissions and also what the permissions should be
            // Also, list the auto-generated chmod command for advanced users
            $retval .= $retval_permissions . PHP_EOL
                . '<h2>' . Common::$LANG['INSTALL'][98] . '</h2>' . PHP_EOL
                . '<p>' . Common::$LANG['INSTALL'][99] . '</p>' . PHP_EOL
                . '<pre><code>' . $chmodString . PHP_EOL
                . '</code></pre>' . PHP_EOL;
            Common::$env['step']++;
        } else {
            // Set the install type if the user clicked one
            $install_type = $this->request('install_type', null);

            // Check if the user clicked one of the install, upgrade, or migrate buttons
            if ($install_type !== null) {
                // If they did, determine which method they selected
                switch ($install_type) {
                    case Common::$LANG['INSTALL'][16]:
                        $install_type = 'migrate';
                        break;

                    case Common::$LANG['INSTALL'][24]:
                        $install_type = 'install';
                        break;

                    case Common::$LANG['INSTALL'][25]:
                        $install_type = 'upgrade';
                        break;
                }

                // Go to the 'write_paths' step
                $url = 'index.php?'
                    . http_build_query([
                            'mode'             => 'write_paths',
                            'dbconfig_path'    => $paths['db-config.php'],
                            'public_html_path' => $paths['public_html/'],
                            'language'         => Common::$env['language'],
                            'op'               => $install_type,
                            'display_step'     => $retval_step + 1,
                        ]
                    );
                header('Location: ' . $url);
            }
        }

        // Show the "Select your installation method" buttons
        Common::$env['dbconfig_path'] = $paths['db-config.php'];
        Common::$env['retval_step'] = $retval_step;
        Common::$env['display_step'] = $retval_step + 1;
        $retval .= MicroTemplate::quick(PATH_LAYOUT, 'select_installation_method', Common::$env);

        return $retval;
    }

    /**
     * Prepare a dropdown list of all available databases
     * Checks which driver classes and "tableanddata" files are actually present,
     * so that unwanted dbs can be removed (still requires special code all over the
     * place so you can't simply drop in new files to add support for new dbs).
     * If support for a database has not been compiled into PHP, the option will be
     * listed as disabled.
     *
     * @param  string  $gl_path          base Geeklog install path
     * @param  string  $selected_dbtype  currently selected db type
     * @param  bool    $list_innodb      whether to list InnoDB option
     * @param  bool    $isInstall        whether to install or update
     * @return string
     * @throws Exception
     */
    private function listOfSupportedDBs($gl_path, $selected_dbtype, $list_innodb = false, $isInstall = true)
    {
        $retval = '';

        if (substr($gl_path, -strlen(self::DB_CONFIG_FILE)) === self::DB_CONFIG_FILE) {
            $gl_path = dirname($gl_path);
        }

        $dbs = [
            'mysql'        => [
                'file'  => 'mysql',
                'label' => Common::$LANG['INSTALL'][35],
            ],
            'mysql-innodb' => [
                'file'  => 'mysql',
                'label' => Common::$LANG['INSTALL'][36],
            ],
            'pgsql'        => [
                'file'  => 'pgsql',
                'label' => Common::$LANG['INSTALL'][106],
            ],
        ];

        // may not be needed as a separate option, e.g. for upgrades
        if (!$list_innodb) {
            unset($dbs['mysql-innodb']);
        }

        foreach ($dbs as $dbname => $info) {
            $prefix = $info['file'];

            if (file_exists($gl_path . '/sql/' . $prefix . '_tableanddata.php') &&
                file_exists($gl_path . '/system/classes/Database/Db' . ucfirst($prefix)
                    . '.php')
            ) {
                if ($prefix === 'mysql') {
                    // check that the MySQLi driver file is also there so we
                    // don't have to check for it every time at runtime
                    if (!file_exists($gl_path . '/system/classes/Database/DbMysqli.php')) {
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
            $retval = '<span class="uk-text-danger uk-text-emphasis">' . Common::$LANG['INSTALL'][108] . '</span>' . PHP_EOL;
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
     * Returns the HTML form to return the user's inputted data to the
     * previous page.
     *
     * @param  array  $postData
     * @return string  HTML form code.
     */
    private function showReturnFormData(array $postData)
    {
        Common::$env['req_display_step'] = $this->request('display_step');
        Common::$env['postData'] = $postData;

        return MicroTemplate::quick(PATH_LAYOUT, 'return_form_data', Common::$env);
    }

    /**
     * Check for blank database password in production environment
     *
     * @param  string  $site_url  The site's URL
     * @param  array   $db        Database    information
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
     * Get information about a plugin
     * Only works for plugins that have a autoinstall.php file
     *
     * @param  string  $plugin  plugin's directory name
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
     * Check if we can skip upgrade steps (post-1.5.0)
     * If we're doing an upgrade from 1.5.0 or later and we have the necessary
     * DB credentials, skip the forms and upgrade directly.
     * NOTE:    Will not return if upgrading from 1.5.0 or later.
     *
     * @param  string  $dbConfigFilePath    path to db-config.php
     * @param  string  $siteConfigFilePath  path to siteconfig.php
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
                    . '&language=' . Common::$env['language']
                    . '&version=' . $version;
                header('Location: ' . $req_string);
                exit;
            }
        }

        return $version;
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
                    $install = new Migrate();

                    return $install->step1();
                }

                include Common::$env['dbconfig_path']; // Get the current DB info

                if ($installType === 'upgrade') {
                    $v = $this->checkPost150Upgrade(Common::$env['dbconfig_path'], Common::$env['siteconfig_path']);
                    // will skip to step 3 if possible, otherwise return here

                    $this->checkDatabaseCharacterSet();

                    if ($v == self::GL_VERSION) {
                        // looks like we're already up to date
                        $retval .= '<h2>' . Common::$LANG['INSTALL'][74] . '</h2>' . PHP_EOL
                            . '<p>' . Common::$LANG['INSTALL'][75] . '</p>' . PHP_EOL;

                        return $retval;
                    }
                }

                $retval .= '<h1>'
                    . Common::$LANG['INSTALL'][101] . ' ' . htmlspecialchars($this->request('display_step'))
                    . ' - ' . Common::$LANG['INSTALL'][102]
                    . '</h1>' . PHP_EOL;

                // Set all the form values either with their defaults or with received POST data.
                // The only instance where you'd get POST data would be if the user has to
                // go back because they entered incorrect database information.
                $site_name = $this->post('site_name', Common::$LANG['INSTALL'][29]);
                $site_name = str_replace('\\', '', $site_name);
                $site_slogan = $this->post('site_slogan', Common::$LANG['INSTALL'][30]);
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

                    if (strcasecmp(Common::$LANG['CHARSET'], 'utf-8') === 0) {
                        $utf8 = true;
                    }
                }

                Common::$env['install_type'] = $installType;
                Common::$env['display_step'] = $this->request('display_step');
                Common::$env['help_site_name'] = $this->getHelpLink('site_name');
                Common::$env['site_name'] = $site_name;
                Common::$env['help_site_slogan'] = $this->getHelpLink('site_slogan');
                Common::$env['site_slogan'] = $site_slogan;
                Common::$env['help_db_type'] = $this->getHelpLink('db_type');
                Common::$env['db_type_selector'] = $this->listOfSupportedDBs(
                    Common::$env['dbconfig_path'],
                    $db_selected,
                    ($installType === 'install'),
                    ($installType === 'install')
                );
                Common::$env['help_db_host'] = $this->getHelpLink('db_host');
                Common::$env['db_host'] = $db_host;
                Common::$env['help_db_name'] = $this->getHelpLink('db_name');
                Common::$env['db_name'] = $db_name;
                Common::$env['help_db_user'] = $this->getHelpLink('db_user');
                Common::$env['db_user'] = $db_user;
                Common::$env['help_db_pass'] = $this->getHelpLink('db_pass');
                Common::$env['db_pass'] = $db_pass;
                Common::$env['help_db_prefix'] = $this->getHelpLink('db_prefix');
                Common::$env['db_prefix'] = $db_prefix;
                Common::$env['help_site_url'] = $this->getHelpLink('site_url');
                Common::$env['site_url'] = $site_url;
                Common::$env['help_site_admin_url'] = $this->getHelpLink('site_admin_url');
                Common::$env['site_admin_url'] = $site_admin_url;
                Common::$env['help_site_mail'] = $this->getHelpLink('site_mail');
                Common::$env['site_mail'] = $site_mail;
                Common::$env['help_noreply_mail'] = $this->getHelpLink('noreply_mail');
                Common::$env['noreply_mail'] = $noreply_mail;
                Common::$env['new_install'] = ($installType === 'install');
                Common::$env['help_utf8'] = $this->getHelpLink('utf8');
                Common::$env['utf8'] = $utf8;
                Common::$env['button_text'] = ($installType === 'install')
                    ? Common::$LANG['INSTALL'][50]
                    : Common::$LANG['INSTALL'][25];

                $retval .= MicroTemplate::quick(PATH_LAYOUT, 'step1', Common::$env);

                return $retval;

            // Page 2 - Enter information into db-config.php and ask about InnoDB tables (if supported)
            case 2:
                if ($installType === 'migrate') {
                    $migrate = new Migrate();

                    return $migrate->step2();
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
                $DB = [
                    'type'         => $this->post('db_type'),
                    'host'         => $this->post('db_host'),
                    'name'         => $this->post('db_name'),
                    'user'         => $this->post('db_user'),
                    'pass'         => $this->post('db_pass'),
                    'table_prefix' => $this->post('db_prefix'),
                    'utf8'         => $utf8,
                ];

                // Check for blank password in production environment
                if (!$this->checkDbPassword($site_url, $DB)) {
                    $retval .= '<h2>' . Common::$LANG['INSTALL'][54] . '</h2>' . PHP_EOL
                        . '<p>' . Common::$LANG['INSTALL'][107] . '</p>' . PHP_EOL
                        . $this->showReturnFormData($_POST) . PHP_EOL;
                    // Check if we can connect to the database
                } elseif (!$this->dbConnect($DB)) {
                    $retval .= '<h2>' . Common::$LANG['INSTALL'][54] . '</h2>' . PHP_EOL
                        . '<p>' . Common::$LANG['INSTALL'][55] . '</p>'
                        . $this->showReturnFormData($_POST) . PHP_EOL;
                    // Check if the user's version of MySQL is out of date
                } elseif ($this->isMysqlOutOfDate($DB)) {
                    $mysqlVersion = $this->getMysqlVersion($DB['host'], $DB['user'], $DB['pass']);
                    $retval .= '<h1>' . sprintf(Common::$LANG['INSTALL'][51], self::SUPPORTED_MYSQL_VER) . '</h1>' . PHP_EOL
                        . '<p>' . sprintf(Common::$LANG['INSTALL'][52], self::SUPPORTED_MYSQL_VER)
                        . (is_array($mysqlVersion) ? implode('.', $mysqlVersion) : '?')
                        . Common::$LANG['INSTALL'][53] . '</p>' . PHP_EOL;
                    // Check if database doesn't exist
                } elseif (!$this->dbExists($DB)) {
                    $retval .= '<h2>' . Common::$LANG['INSTALL'][56] . '</h2>' . PHP_EOL
                        . '<p>' . Common::$LANG['INSTALL'][57] . '</p>' . PHP_EOL
                        . $this->showReturnFormData($_POST) . PHP_EOL;
                } else {
                    // Write the database info to db-config.php
                    if (!$this->writeDbConfig(Common::$env['dbconfig_path'], $DB)) {
                        exit(Common::$LANG['INSTALL'][26] . ' ' . htmlspecialchars(Common::$env['dbconfig_path'])
                            . Common::$LANG['INSTALL'][58]);
                    }

                    // for the default charset, patch siteconfig.php again
                    if ($installType !== 'upgrade') {
                        if (!$this->setDefaultCharset(Common::$env['siteconfig_path'],
                            ($utf8 ? 'utf-8' : Common::$LANG['CHARSET']))
                        ) {
                            exit(Common::$LANG['INSTALL'][26] . ' ' . Common::$env['siteconfig_path']
                                . Common::$LANG['INSTALL'][58]);
                        }
                    }

                    $this->includeConfig(Common::$env['dbconfig_path']);
                    require_once Common::$env['siteconfig_path'];
                    $_CONF['path_system'] = Common::$env['gl_path'] . '/system/';
                    require_once $_CONF['path_system'] . 'lib-database.php';

                    $params = [
                        'mode'            => $installType,
                        'step'            => 3,
                        'dbconfig_path'   => Common::$env['dbconfig_path'],
                        'install_plugins' => ($installPlugins ? 'true' : 'false'),
                        'language'        => Common::$env['language'],
                        'site_name'       => $site_name,
                        'site_slogan'     => $site_slogan,
                        'site_url'        => $site_url,
                        'site_admin_url'  => $site_admin_url,
                        'site_mail'       => $site_mail,
                        'noreply_mail'    => $noreply_mail,
                        //'upgrade_check'   => $this->post('upgrade_check', 'confirmed'),
                    ];

                    if ($utf8) {
                        $params['utf8'] = 'true';
                    }

                    $req_string = 'index.php?' . http_build_query($params);

                    switch ($installType) {
                        case 'install':
                            $install = new Geeklog\Install\Install();

                            return $install->step2($retval, $req_string, $DB, $utf8, $params);

                        case 'upgrade':
                            $upgrade = new Geeklog\Install\Upgrade();

                            return $upgrade->step2($retval, $req_string);
                    }
                }

                break;

            // Page 3 - Install
            case 3:
                if ($installType === 'migrate') {
                    $controller = new Migrate();
                    $controller->step3();   // Go on to bigdump.php so will not return here
                    break;
                }

                $gl_path = str_replace(self::DB_CONFIG_FILE, '', Common::$env['dbconfig_path']);
                $installPlugins = ($this->request('install_plugins') === 'true');
                $nextLink = $installPlugins
                    ? 'install-plugins.php?language=' . Common::$env['language']
                    : 'success.php?type=' . $installType . '&language=' . Common::$env['language'];

                switch ($installType) {
                    case 'install':
                        $install = new Install();
                        $retval = $install->step3($retval, $_DB_dbms, $installPlugins, $nextLink, $gl_path);
                        break;

                    case 'upgrade':
                        $upgrade = new Upgrade();
                        $retval = $upgrade->step3($retval, $installPlugins);
                        break;
                }

                break;

            case 4:
                // Extra Step 4 - Upgrade plugins
                if ($installType === 'migrate') {
                    $controller = new Migrate();

                    return $controller->step4();
                }

                // $this->upgradePlugins(false, false, []);
                $installPlugins = ($this->get('install_plugins') === 'true');

                if (!$installPlugins) {
                    // if we don't do the manual selection, install all new plugins now
                    $this->autoInstallNewPlugins();
                }

                $nextLink = $installPlugins
                    ? 'install-plugins.php?language=' . Common::$env['language']
                    : 'success.php?type=' . $installType . '&language=' . Common::$env['language'];
                header('Location: ' . $nextLink);
                break;
        }

        return $retval;
    }

    /**
     * Run the installer
     */
    public function run()
    {
        global $_CONF, $_TABLES, $_VARS, $_URL, $_DEVICE, $_SCRIPTS, $_IMAGE_TYPE, $TEMPLATE_OPTIONS, $_GROUPS, $_RIGHTS, $_USER, $_DB_dbms, $_DB_table_prefix;

        Common::$env['html_path'] = $this->getHtmlPath();
        Common::$env['siteconfig_path'] = Common::$env['html_path'] . 'siteconfig.php';
        Common::$env['dbconfig_path'] = $this->post('dbconfig_path', $this->get('dbconfig_path', ''));
        Common::$env['dbconfig_path'] = $this->sanitizePath(Common::$env['dbconfig_path']);
        Common::$env['use_innodb'] = false;

        // Before we have db-config path let's guess
        if (empty(Common::$env['dbconfig_path'])) {
            // Prepare some hints about what /path/to/geeklog might be ...
            Common::$env['gl_path'] = BASE_FILE;

            for ($i = 0; $i < 4; $i++) {
                $remains = strrchr(Common::$env['gl_path'], '/');

                if ($remains === false) {
                    break;
                } else {
                    Common::$env['gl_path'] = substr(Common::$env['gl_path'], 0, -strlen($remains));
                }
            }
        } else {
            // Once we know location of dbconfig.php we have gl_path
            Common::$env['gl_path'] = str_replace(self::DB_CONFIG_FILE, '', Common::$env['dbconfig_path']);
        }

        // Need conf php error reporting settings
        // Use Geeklog settings since they get overwritten anyways when lib-common is included
        // Need conf settings for migration as well
        require_once Common::$env['siteconfig_path'];
        if ((isset($_CONF['developer_mode']) && ($_CONF['developer_mode'] === true)) &&
            isset($_CONF['developer_mode_php'], $_CONF['developer_mode_php']['error_reporting'])) {
            error_reporting((int) $_CONF['developer_mode_php']['error_reporting']);
        } else {
            // Same setting as Geeklog - Prevent PHP from reporting uninitialized variables
            error_reporting(E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_COMPILE_ERROR | E_USER_ERROR | E_RECOVERABLE_ERROR);
        }

        // Set UI language selector if necessary
        if (empty(Common::$env['mode']) || (Common::$env['mode'] === 'check_permissions')) {
            Common::$env['language_selector'] = $this->getLanguageSelector();
            Common::$env['language_selector_menu'] = '';
        } else {
            // This only works on the first page so hide any language stuff
            Common::$env['language_selector'] = '';
            Common::$env['language_selector_menu'] = 'uk-hidden';
        }

        // Render content
        switch (Common::$env['mode']) {
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
                if ((Common::$env['step'] == 4) && (Common::$env['mode'] !== 'migrate')) {
                    // for the plugin install and upgrade,
                    // we need lib-common.php in the global(!) namespace
                    require_once dirname(dirname(dirname(__DIR__))) . '/lib-common.php';

                    // Clear all speed limits for login to prevent login issues after install/upgrade/migrate (bug #995)
                    COM_clearSpeedlimit(0, 'login');
                }

                // Run the installation function
                try {
                    $content = $this->installEngine(Common::$env['mode'], Common::$env['step']);
                } catch (Exception $e) {
                    $content = $e->getMessage();
                }
                break;
        }

        $this->display($content);
    }
}
