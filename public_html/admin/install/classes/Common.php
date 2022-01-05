<?php

namespace Geeklog\Install;

use config;
use Geeklog\Database\DbMysqli;
use Geeklog\Db;
use InvalidArgumentException;
use MicroTemplate;
use mysqli;

/**
 * Class Common
 *
 * @package Geeklog\Install
 */
abstract class Common
{
    // Geeklog version
    const GL_VERSION = '2.2.2';

    // System requirements
    const SUPPORTED_PHP_VER = '5.6.4';
    const SUPPORTED_MYSQL_VER = '4.1.3';
    const SUPPORTED_PGSQL_VER = '9.1.7';

    // Default database character set
    const DEFAULT_DB_CHARSET = 'latin1';

    // Default UI language
    const DEFAULT_LANGUAGE = 'english';

    // Default theme
    const DEFAULT_THEME = 'denim_three';

    // Database configuration file
    const DB_CONFIG_FILE = 'db-config.php';

    /**
     * Language meta data
     *
     * @var array of ['name' => language name, 'code' => ISO 639-1 (regional tag)
     */
    public static $languages = [];

    /**
     * @var array
     */
    public static $env = [];

    /**
     * @var array
     */
    public static $LANG = [];

    /**
     * @var array
     */
    public static $upgradeMessages = [];

    /**
     * @var array
     */
    private $databaseCharsets = [
        'mysql' => [
            // $LANG_CHARSET => $_DB_charset
            'iso-8859-1'  => 'latin1',
            'iso-8859-2'  => 'latin2',
            'iso-8859-15' => 'latin1',
            'utf-8'       => 'utf8',
        ],
        'pgsql' => [
            // $LANG_CHARSET => $_DB_charset
            'iso-8859-1'  => 'LATIN1',
            'iso-8859-2'  => 'LATIN2',
            'iso-8859-15' => 'LATIN9',
            'utf-8'       => 'UTF8',
        ],
    ];

    /**
     * Return a $_GET variable
     *
     * @param  string        $name
     * @param  array|string  $defaultValue
     * @return array|null|string
     */
    public function get($name, $defaultValue = null)
    {
        return array_key_exists($name, $_GET) ? $_GET[$name] : $defaultValue;
    }

    /**
     * Return a $_POST variable
     *
     * @param  string        $name
     * @param  array|string  $defaultValue
     * @return array|null|string
     */
    public function post($name, $defaultValue = null)
    {
        return array_key_exists($name, $_POST) ? $_POST[$name] : $defaultValue;
    }

    /**
     * Return a $_REQUEST variable
     *
     * @param  string        $name
     * @param  array|string  $defaultValue
     * @return array|null|string
     */
    public function request($name, $defaultValue = null)
    {
        return array_key_exists($name, $_REQUEST) ? $_REQUEST[$name] : $defaultValue;
    }

    /**
     * Return a $_SERVER variable
     *
     * @param  string        $name
     * @param  array|string  $defaultValue
     * @return array|null|string
     */
    public function server($name, $defaultValue = null)
    {
        return array_key_exists($name, $_SERVER) ? $_SERVER[$name] : $defaultValue;
    }

    /**
     * Fix site_url in content
     * If the site's URL changed due to the migration, this function will replace
     * the old URL with the new one in text content of the given tables.
     *
     * @param  string  $oldUrl     the site's previous URL
     * @param  string  $newUrl     the site's new URL after the migration
     * @param  array   $tableSpec  (optional) list of tables to patch
     *                             The $tablespec is an array of tablename => fieldlist pairs, where the field
     *                             list contains the text fields to be searched and the table's index field
     *                             as the first(!) entry.
     *                             NOTE: This function may be used by plugins during PLG_migrate. Changes should
     *                             ensure backward compatibility.
     */
    public static function updateSiteUrl($oldUrl, $newUrl, array $tableSpec = [])
    {
        global $_TABLES;

        // standard tables to update if no $tablespec given
        $tables = [
            'stories'         => 'sid, introtext, bodytext, related',
            'storysubmission' => 'sid, introtext, bodytext',
            'comments'        => 'cid, comment',
            'trackback'       => 'cid, excerpt, url',
            'blocks'          => 'bid, content',
        ];

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
     * Make sure to include(require) db-config.php
     *
     * NOTE: In Ubuntu OS (maybe also in similar Linux distros), when include
     * db-config.php right after the writeConfig method is called, the read value is
     * equal to the value before being changed by the writeConfig method, and an error
     * occurs on installation because it is different from the DB information.
     * This method is to make sure to read the value changed by the writeConfig method.
     *
     * @param  string  $dbConfigFilePath  Full path to db-config.php
     */
    protected function includeConfig($dbConfigFilePath)
    {
        global $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix,
               $_DB_dbms, $_DB_charset;

        $dbConfigData = @file_get_contents($dbConfigFilePath);
        $dbConfigData = str_replace('<' . '?php', '', $dbConfigData);

        /**
         * @global $_DB_host
         * @global $_DB_name
         * @global $_DB_user
         * @global $_DB_pass
         * @global $_DB_table_prefix
         * @global $_DB_dbms
         * @global $_DB_charset
         */
        eval($dbConfigData);
    }

    /**
     * Check if a table exists
     *
     * @param  string  $table  Table name
     * @return  bool         True if table exists, false if it does not
     * @see     DB_checkTableExists
     */
    protected function tableExists($table)
    {
        return DB_checkTableExists($table);
    }

    /**
     * Run all the database queries from the update file.
     *
     * @param  array   $_SQL  Array of queries to perform
     * @param  string  $progress
     */
    protected function updateDB(array $_SQL, &$progress)
    {
        foreach ($_SQL as $sql) {
            $progress .= "executing {$sql}<br>" . PHP_EOL;
            DB_query($sql);
        }
    }

    /**
     * Returns a cleaned string
     *
     * @param  string  $str
     * @return string
     */
    protected function cleanString($str)
    {
        $str = preg_replace('/[[:cntrl:]]/', '', $str);
        $str = strip_tags($str);

        return $str;
    }

    /**
     * Returns a cookie path for a site URL
     *
     * @param  string  $site_url  site URL
     * @return  string               a cookie path
     */
    protected function guessCookiePath($site_url)
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
                        'name'    => trim($langName),
                        'quality' => (float) trim($quality),
                    ];
                }

                uasort($retval, function ($a, $b) {
                    return -($a['quality'] - $b['quality']);
                });
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
     * Derive site's default language from available information
     *
     * @return   string  name of default language (for the config)
     */
    protected function getDefaultLanguage()
    {
        $languagesFromUserAgent = $this->getLanguagesFromUserAgent();

        if (count($languagesFromUserAgent) > 0) {
            foreach ($languagesFromUserAgent as $languageFromUserAgent) {
                if (strpos($languageFromUserAgent, '_') !== false) {
                    $languageFromUserAgent = str_replace('_', '-', $languageFromUserAgent);
                }

                foreach (Common::$languages as $languageFileName => $data) {
                    $languageFileName = str_ireplace('.php', '', $languageFileName);

                    if (strcasecmp($data['langCode'], $languageFromUserAgent) === 0) {
                        return $languageFileName;
                    }

                    if (strpos($languageFromUserAgent, '-')) {
                        list ($country,) = explode('-', $languageFromUserAgent, 2);

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
     * Return a UI language selector
     *
     * @return string
     */
    protected function getLanguageSelector()
    {
        $env = Common::$env;
        $env['hidden_items'] = [];
        $env['languages'] = [];

        if (!empty(Common::$env['mode'])) {
            $env['hidden_items'][] = ['name' => 'mode', 'value' => Common::$env['mode']];
        }

        $paths = ['dbconfig', 'public_html'];
        foreach ($paths as $path) {
            $name = $path . '_path';
            $value = $this->get($name, $this->post($name));

            if (!empty($value)) {
                $value = $this->sanitizePath($value);
                $env['hidden_items'][] = [
                    'name'  => $name,
                    'value' => $value,
                ];
            }
        }

        foreach (Common::$languages as $languageName => $data) {
            $languageName = strtolower($languageName);
            $languageName = str_replace('.php', '', $languageName);
            $env['languages'][] = [
                'value'    => $languageName,
                'selected' => (($languageName === Common::$env['language']) ? ' selected="selected"' : ''),
                'text'     => $data['langName'] . ' (' . $data['english'] . ')',
            ];
        }

        return MicroTemplate::quick(PATH_LAYOUT, 'language_selector', $env);
    }

    /**
     * Set Geeklog version number in siteconfig.php and in the database
     *
     * @param  string  $siteConfigFilePath  path to siteconfig.php
     */
    protected function setVersion($siteConfigFilePath)
    {
        global $_TABLES;

        $siteConfigData = @file_get_contents($siteConfigFilePath);
        $siteConfigData = preg_replace(
            '/define\s*\(\'VERSION\',[^;]*;/',
            "define('VERSION', '" . self::GL_VERSION . "');",
            $siteConfigData
        );

        if (@file_put_contents($siteConfigFilePath, $siteConfigData) === false) {
            exit(Common::$LANG['INSTALL'][26] . ' ' . Common::$LANG['INSTALL'][28]);
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
     * Pick up and install any new plugins
     * Search for plugins that exist in the filesystem but are not registered with
     * Geeklog. If they support auto install, install them now.
     */
    protected function autoInstallNewPlugins()
    {
        global $_CONF, $_TABLES, $_DB_dbms, $_DB_table_prefix;

        $newPlugins = [];
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

                $this->pluginAutoInstall($pi_name, $inst_params);
            }
        }
    }

    /**
     * Do the actual plugin auto install
     *
     * @param  string  $plugin       Plugin name
     * @param  array   $inst_params  Installation parameters for the plugin
     * @param  bool    $verbose      true: enable verbose logging
     * @return  bool             true on success, false otherwise
     */
    public function pluginAutoInstall($plugin, array $inst_params, $verbose = true)
    {
        global $_CONF, $_TABLES, $_USER, $_DB_dbms, $_DB_table_prefix;

        // Don't use 'include' or 'require' here! (bug #951)
        $this->includeConfig(Common::$env['dbconfig_path']);

        if (!isset($_USER['uid'])) {
            $_USER['uid'] = 1;
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
            empty($pi_gl_version) || empty($pi_homepage)) {
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
        $groups = [];
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
        $_SQL = [];
        $DEFVALUES = [];

        if (file_exists($basePath . 'sql/' . $_DB_dbms . '_install.php')) {
            require_once $basePath . 'sql/' . $_DB_dbms . '_install.php';
        }

        if (count($_SQL) > 0) {
            $useInnodb = false;

            if (($_DB_dbms === 'mysql') &&
                (DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'") === 'InnoDB')) {
                $useInnodb = true;
            }

            Common::$env['use_innodb'] = $useInnodb;

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

        $mappings = [];

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

        return true;
    }

    /**
     * Get the current installed version of Geeklog
     *
     * @return  string  Geeklog version in x.x.x format
     */
    protected function identifyGeeklogVersion()
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
                $tests = [
                    // as of 1.5.1, we should have the 'database_version' entry
                    '1.5.0'  => ["DESCRIBE {$_TABLES['storysubmission']} bodytext", ''],
                    '1.4.1'  => ["SELECT ft_name FROM {$_TABLES['features']} WHERE ft_name = 'syndication.edit'", 'syndication.edit'],
                    '1.4.0'  => ["DESCRIBE {$_TABLES['users']} remoteusername", ''],
                    '1.3.11' => ["DESCRIBE {$_TABLES['comments']} sid", 'sid,varchar(40)'],
                    '1.3.10' => ["DESCRIBE {$_TABLES['comments']} lft", ''],
                    '1.3.9'  => ["DESCRIBE {$_TABLES['syndication']} fid", ''],
                    '1.3.8'  => ["DESCRIBE {$_TABLES['userprefs']} showonline", '']
                    // It's hard to (reliably) test for 1.3.7 - let's just hope
                    // nobody uses such an old version any more ...
                ];
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
                $tests = [];
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
     * Helper function: Derive 'site_admin_url' from PHP_SELF
     *
     * @return string
     */
    protected function getSiteAdminUrl()
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
     * Check if any message for upgrades, exit the installer
     *
     * @param  string  $currentVersion
     * @return string
     */
    protected function checkUpgradeMessage($currentVersion)
    {
        $retval = '';

        if ($this->doDatabaseUpgrades($currentVersion, true) && !empty(Common::$upgradeMessages)) {
            $prompt = 'information';
            $retval = '<h1>' . Common::$LANG['ERROR'][14] . '</h1>' . PHP_EOL; // Upgrade Notice
            $retval .= sprintf(Common::$LANG['ERROR'][13], $currentVersion, self::GL_VERSION); // Upgrade Instructions
            Common::$env['site_url'] = $this->get('site_url', $this->post('site_url', $this->getSiteUrl()));
            Common::$env['site_admin_url'] = $this->get('site_admin_url', $this->post('site_admin_url', $this->getSiteAdminUrl()));

            foreach (Common::$upgradeMessages as $version => $message) {
                $retval .= '<h2>' . Common::$LANG['INSTALL'][111] . ' ' . $version . '</h2>' . PHP_EOL;
                if (version_compare($version, '2.1.2', '<')) {
                    foreach ($message as $type => $message_id) {
                        $retval .= $this->getAlertMessage(Common::$LANG['ERROR'][$message_id], $type);
                        // record what type of prompt we need
                        if ($type === 'information' || $type === 'warning' || $type === 'error') {
                            if ($prompt !== 'error') {
                                $prompt = $type;
                            }
                        }
                    }
                } else {
                    // Upgrade message array changed in Geeklog v2.2.0 to allow multiple boxes of the same type
                    // (warning, information or error) to be displayed in the same Geeklog version
                    foreach ($message as $id => $info) {
                        $type = $info[0];
                        $title_id = $info[1];
                        $message_id = $info[2];
                        $retval .= $this->getAlertMessage(Common::$LANG['ERROR'][$message_id], $type, Common::$LANG['ERROR'][$title_id]);

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
                $retval .= MicroTemplate::quick(PATH_LAYOUT, 'upgrade_prompt_error', Common::$env);
            } else {
                // add current version to array so set in template
                Common::$env['currentVersion'] = $currentVersion;

                $retval .= MicroTemplate::quick(PATH_LAYOUT, 'upgrade_prompt_warning', Common::$env);
            }
        }

        return $retval;
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
        $optionalConfig = [
            'copyrightyear', 'debug_image_upload', 'default_photo',
            'force_photo_width', 'gravatar_rating', 'ip_lookup', 'language_files',
            'languages', 'path_to_mogrify', 'path_to_netpbm',
        ];

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
     * @param  string  $currentGlVersion  Current Geeklog version
     * @param  bool    $checkForMessage
     * @return bool                     True if successful
     */
    protected function doDatabaseUpgrades($currentGlVersion, $checkForMessage = false)
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
        DB_setMysqlSqlMode(DbMysqli::MYSQL_SQL_MODE_NONE);
        $_SQL = [];

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
                    $_SQL = [];
                    break;

                case '1.3':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3_to_1.3.1.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.3.1';
                    $_SQL = [];
                    break;

                case '1.3.1':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.1_to_1.3.2.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.3.2-1';
                    $_SQL = [];
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
                    $_SQL = [];
                    break;

                case '1.3.3':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.3_to_1.3.4.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.3.4';
                    $_SQL = [];
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
                    $_SQL = [];
                    break;

                case '1.3.5':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.5_to_1.3.6.php';
                    $this->updateDB($_SQL, $progress);

                    if (!empty($_DB_table_prefix)) {
                        DB_query("RENAME TABLE staticpage TO {$_TABLES['staticpage']}");
                    }

                    $currentGlVersion = '1.3.6';
                    $_SQL = [];
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
                    $_SQL = [];
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
                    $_SQL = [];
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
                    $groups = [];

                    for ($i = 0; $i < $num; $i++) {
                        $A = DB_fetchArray($result);
                        $groups[] = $A['grp_id'];
                    }

                    $groupList = '(' . implode(',', $groups) . ')';
                    DB_query("DELETE FROM {$_TABLES['group_assignments']} WHERE (ug_main_grp_id NOT IN $groupList) OR (ug_grp_id NOT IN $groupList)");
                    $currentGlVersion = '1.3.9';
                    $_SQL = [];
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
                    $_SQL = [];
                    break;

                case '1.3.10':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.10_to_1.3.11.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.3.11';
                    $_SQL = [];
                    break;

                case '1.3.11':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.3.11_to_1.4.0.php';
                    $this->updateDB($_SQL, $progress);
                    upgrade_addFeature();
                    upgrade_uniqueGroupNames();
                    $currentGlVersion = '1.4.0';
                    $_SQL = [];
                    break;

                case '1.4.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.4.0_to_1.4.1.php';
                    $this->updateDB($_SQL, $progress);
                    upgrade_addSyndicationFeature();
                    upgrade_ensureLastScheduledRunFlag();
                    upgrade_plugins_141();
                    $currentGlVersion = '1.4.1';
                    $_SQL = [];
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

                        if (!$this->setDefaultCharset(Common::$env['siteconfig_path'], $_CONF['default_charset'])) {
                            exit(Common::$LANG['INSTALL'][26] . ' ' . Common::$env['siteconfig_path'] . Common::$LANG['INSTALL'][58]);
                        }

                        require Common::$env['siteconfig_path'];
                        $this->includeConfig(Common::$env['dbconfig_path']);
                    }

                    // Update the GL configuration with the correct paths.
                    $config->set('path_html', Common::$env['html_path']);
                    $config->set('path_log', $_CONF['path'] . 'logs/');
                    $config->set('path_language', $_CONF['path'] . 'language/');
                    $config->set('backup_path', $_CONF['path'] . 'backups/');
                    $config->set('path_data', $_CONF['path'] . 'data/');
                    $config->set('path_images', Common::$env['html_path'] . 'images/');
                    $config->set('path_themes', Common::$env['html_path'] . 'layout/');
                    $config->set('path_editors', Common::$env['html_path'] . 'editors/');
                    $config->set('rdf_file', Common::$env['html_path'] . 'backend/geeklog.rss');
                    $config->set('path_pear', $_CONF['path_system'] . 'pear/');

                    // core plugin updates are done in the plugins themselves
                    $currentGlVersion = '1.5.0';
                    $_SQL = [];
                    break;

                case '1.5.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.5.0_to_1.5.1.php';
                    $this->updateDB($_SQL, $progress);
                    $currentGlVersion = '1.5.1';
                    $_SQL = [];
                    break;

                case '1.5.1':
                    // there were no core database changes in 1.5.2
                    $currentGlVersion = '1.5.2';
                    $_SQL = [];
                    break;

                case '1.5.2':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.5.2_to_1.6.0.php';
                    $this->updateDB($_SQL, $progress);
                    update_ConfValues();
                    upgrade_addNewPermissions();
                    upgrade_addIsoFormat();
                    $this->fixOptionalConfig();
                    $currentGlVersion = '1.6.0';
                    $_SQL = [];
                    break;

                case '1.6.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.6.0_to_1.6.1.php';
                    $this->updateDB($_SQL, $progress);
                    update_ConfValuesFor161();
                    $currentGlVersion = '1.6.1';
                    $_SQL = [];
                    break;

                case '1.6.1':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_1.6.1_to_1.7.0.php';
                    $this->updateDB($_SQL, $progress);
                    update_ConfValuesFor170();
                    $currentGlVersion = '1.7.0';
                    $_SQL = [];
                    break;

                case '1.7.0':
                    $currentGlVersion = '1.7.2'; // skip ahead
                    $_SQL = [];
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
                    $_SQL = [];
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
                    $_SQL = [];
                    break;

                case '2.0.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.0.0_to_2.1.0.php';
                    $this->updateDB($_SQL, $progress);
                    update_addFilemanager();
                    update_ConfValuesFor210();
                    $currentGlVersion = '2.1.0';
                    $_SQL = [];
                    break;

                case '2.1.0':
                    // there were no database changes in 2.1.0
                case '2.1.1':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.1.1_to_2.1.2.php';
                    if ($checkForMessage) {
                        $retval = upgrade_message211();
                        if (is_array($retval)) {
                            Common::$upgradeMessages = array_merge(Common::$upgradeMessages, $retval);
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
                    $_SQL = [];
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
                            Common::$upgradeMessages = array_merge(Common::$upgradeMessages, $retval);
                        }
                    } else {
                        $this->updateDB($_SQL, $progress);
                        removeCommentSig220();
                        update_ConfValuesFor220();
                        addThemeAdminFor220();
                    }
                    $currentGlVersion = '2.2.0';
                    $_SQL = [];
                    break;

                case '2.2.0':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.2.0_to_2.2.1.php';
                    if ($checkForMessage) {
                        $retval = upgrade_message220();
                        if (is_array($retval)) {
                            Common::$upgradeMessages = array_merge(Common::$upgradeMessages, $retval);
                        }
                    } else {
                        $this->updateDB($_SQL, $progress);
                        update_ConfValuesFor221();
                        fixDuplicateUsernames221();
                        addStructuredDataSecurityRight221();
                        calculateNumPagesArticles221();
                    }
                    $currentGlVersion = '2.2.1';
					$_SQL = [];
                    break;

                case '2.2.1':
                    $currentGlVersion = '2.2.1sr1';
					$_SQL = [];
                    break;

                case '2.2.1sr1':
                    require_once $_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_2.2.1_to_2.2.2.php';

                    if (!$checkForMessage) {
                        $this->updateDB($_SQL, $progress);
                        update_ConfValuesFor222();
                        update_TablesContainingIPAddresses222();
                    }

                    $currentGlVersion = '2.2.2';
					$_SQL = [];
                    break;

                default:
                    $done = true;
                    break;
            }
        }

        // Don't do this if just checking for upgrade messages
        if (!$checkForMessage) {
            $this->setVersion(Common::$env['siteconfig_path']);

            // delete the security check flag on every update to force the user
            // to run admin/sectest.php again
            DB_delete($_TABLES['vars'], 'name', 'security_check');
        }

        return true;
    }

    /**
     * Nicely formats the alert messages
     *
     * @param  string  $message  Message string
     * @param  string  $type     'error', 'warning', 'success', or 'notice'
     * @param  string  $title
     * @return   string          HTML formatted dialog message
     */
    protected function getAlertMessage($message, $type = 'notice', $title = '')
    {
        switch (strtolower($type)) {
            case 'error':
                $type = Common::$LANG['INSTALL'][38];
                $style = 'danger';
                break;

            case 'warning':
                $type = Common::$LANG['INSTALL'][20];
                $style = 'warning';
                break;

            case 'success':
                $type = Common::$LANG['INSTALL'][93];
                $style = 'success';
                break;

            default:
                $type = Common::$LANG['INSTALL'][59];
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
     * Display the installer
     *
     * @param  string  $content
     */
    public function display($content)
    {
        // Need to do this for install-plugins.php when called for a new install but want to select plugins
        if (!isset(Common::$env['language_selector_menu'])) {
            Common::$env['language_selector'] = '';
            Common::$env['language_selector_menu'] = 'uk-hidden';
        }

        Common::$env['content'] = $content;
        $T = new MicroTemplate(PATH_LAYOUT);
        $T->set(Common::$env);
        $T->display('index');
    }

    /**
     * Check if Database Character Set has been set. Required for Upgrades and Migrations
     * Needs to be done after dbconfig.php is loaded
     */
    protected function checkDatabaseCharacterSet()
    {
        global $_DB_charset;

        // Since Geeklog 2.1.2, $_DB_charset was introduced
        if (empty($_DB_charset)) {
            // If database character set missing, display an error message
            $content = '<h1>' . Common::$LANG['ERROR'][34] . '</h1>' . PHP_EOL
                . $this->getAlertMessage(Common::$LANG['ERROR'][35], 'error');

            $this->display($content);
            die(1);
        }

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
    protected function getSiteUrl()
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
     * Provide a link to the help page for an option
     *
     * @param  string  $var  key of the label, used as an anchor on the help page
     * @return  string          HTML for the link
     */
    protected function getHelpLink($var)
    {
        global $LANG_HELP;

        return '<span uk-icon="icon: info" uk-tooltip="' . htmlentities($LANG_HELP[$var]) . '"</span>';
    }

    /**
     * Nicely formats the alert messages
     *
     * @param  string  $mMessage  Message string
     * @param  string  $mType     'error', 'warning', 'success', or 'notice'
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
     * Can the install script connect to the database?
     *
     * @param  array  $db  Database information
     * @return  mixed     Returns the DB handle if true, false if not
     */
    protected function dbConnect($db)
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
     * @param  string  $host
     * @param  string  $user
     * @param  string  $pass
     * @return array|false   array[0..2] of the parts of the version number or false
     */
    protected function getMysqlVersion($host, $user, $pass)
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
            return [$match[1], $match[2], $match[3]];
        } else {
            return [0, 0, 0];
        }
    }

    /**
     * Check if the user's MySQL version is supported by Geeklog
     *
     * @param  array  $db  Database information
     * @return  bool True if supported, false if not supported
     */
    protected function isMysqlOutOfDate(array $db)
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
     * @param  array  $db  Array containing connection info
     * @return  bool      True if a database exists, false if not
     */
    protected function dbExists(array $db)
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
     * @param  string  $dbConfigFilePath  Full path to db-config.php
     * @param  array   $db                Database information to save
     * @return  bool True if successful, false if not
     */
    protected function writeDbConfig($dbConfigFilePath, array $db)
    {
        // We may have included db-config.php elsewhere already, in which case
        // all of these variables need to be imported from the global namespace
        global $_DB_host, $_DB_name, $_DB_user, $_DB_pass, $_DB_table_prefix,
               $_DB_dbms, $_DB_charset, $LANG_CHARSET, $_CONF;

        // Grab the current DB values
        require $dbConfigFilePath;

        $isUtf8 = false;

        if (isset($db['utf8']) &&
            (empty($_DB_charset) ||
                ((Common::$env['mode'] === 'install') && ($_DB_charset === 'latin1')))) {
            $isUtf8 = $db['utf8'];
        } elseif (isset($db['utf8'])) {
            $isUtf8 = in_array(strtolower($_DB_charset), ['utf8', 'utf8mb4', 'utf-8']);
        }

        $db = [
            'host'         => (isset($db['host']) ? $db['host'] : $_DB_host),
            'name'         => (isset($db['name']) ? $db['name'] : $_DB_name),
            'user'         => (isset($db['user']) ? $db['user'] : $_DB_user),
            'pass'         => (isset($db['pass']) ? $db['pass'] : $_DB_pass),
            'table_prefix' => (isset($db['table_prefix']) ? $db['table_prefix'] : $_DB_table_prefix),
            'type'         => (isset($db['type']) ? $db['type'] : $_DB_dbms),
        ];

        if ($db['type'] === 'mysql-innodb') {
            $db['type'] = 'mysql';
        }

        if (Common::$env['mode'] == 'install') {
            // Set database charset based on $LANG_CHARSET (this will be overwritten later)
            $langCharSet = $LANG_CHARSET;
        } else {
            // If migrate then use current settings
            $langCharSet = $_CONF['default_charset'];
        }

        $db['charset'] = $this->convertLangCharsetToDatabaseCharset(
            $db['type'],
            ($isUtf8 ? 'utf-8' : $langCharSet)
        );

        // Read in db-config.php so we can insert the DB information
        clearstatcache();
        $dbConfigData = @file_get_contents($dbConfigFilePath);
        if ($dbConfigData === false) {
            die('Could not read "db-config.php"');
        }

        // Replace the values with the new ones
        $dbConfigData = str_replace("\$_DB_host = '" . $_DB_host . "';", "\$_DB_host = '" . $db['host'] . "';", $dbConfigData); // Host
        $dbConfigData = str_replace("\$_DB_name = '" . $_DB_name . "';", "\$_DB_name = '" . $db['name'] . "';", $dbConfigData); // Database
        $dbConfigData = str_replace("\$_DB_user = '" . $_DB_user . "';", "\$_DB_user = '" . $db['user'] . "';", $dbConfigData); // Username
        $dbConfigData = str_replace("\$_DB_pass = '" . $_DB_pass . "';", "\$_DB_pass = '" . $db['pass'] . "';", $dbConfigData); // Password
        $dbConfigData = str_replace("\$_DB_table_prefix = '" . $_DB_table_prefix . "';", "\$_DB_table_prefix = '" . $db['table_prefix'] . "';", $dbConfigData); // Table prefix
        $dbConfigData = str_replace("\$_DB_dbms = '" . $_DB_dbms . "';", "\$_DB_dbms = '" . $db['type'] . "';", $dbConfigData); // Database type ('mysql' or 'pgsql')

        // Since Geeklog 2.1.2, $_DB_charset was introduced
        if (version_compare(self::GL_VERSION, '2.1.2', '>=')) {
            switch ($db['type']) {
                case 'mysql':
                case 'mysql-innodb':
                    if ((Common::$env['mode'] !== 'install') && isset($_DB_charset) && ($_DB_charset !== '')) {
                        $db['charset'] = $_DB_charset;
                    }

                    if ($isUtf8) {
                        require_once __DIR__ . '/db.class.php';
                        $dbTypes = Db::getDrivers();

                        if (in_array(Db::DB_MYSQLI, $dbTypes)) {
                            $driver = Db::connect(Db::DB_MYSQLI, $db);
                        } else {
                            $driver = Db::connect(Db::DB_MYSQL, $db);
                        }

                        $db['charset'] = ($driver->getVersion() >= 50503) ? 'utf8mb4' : 'utf8';
                    }

                    break;

                case 'pgsql':
                    break;

                default:
                    throw new InvalidArgumentException(sprintf('Unknown database driver "%s" was given', $db['type']));
            }

            // Update $_DB_charset in the "db-config.php"
            if (isset($_DB_charset)) {
                $dbConfigData = str_replace(
                    "\$_DB_charset = '" . $_DB_charset . "';",
                    "\$_DB_charset = '" . $db['charset'] . "';",
                    $dbConfigData
                );
            } else {
                // Update or migrate from Geeklog 2.1.1 or older
                $dbConfigData = str_replace('?>', '', $db);
                $dbConfigData .= PHP_EOL
                    . "\$_DB_charset = '" . $db['charset'] . "';" . PHP_EOL;
            }
        }

        // make sure global variable gets updated
        $_DB_charset = $db['charset'];

        // Write our changes to db-config.php
        return (@file_put_contents($dbConfigFilePath, $dbConfigData, LOCK_EX) !== false);
    }

    /**
     * Filter path value for junk and injections
     *
     * @param  string  $path  a path on the file system
     * @return  string          filtered path value
     */
    public function sanitizePath($path)
    {
        $path = strip_tags($path);
        $path = str_replace(['"', "'"], '', $path);
        $path = str_replace('..', '', $path);

        return $path;
    }

    /**
     * Change default character set to UTF-8
     * NOTE:    Yes, this means that we need to patch siteconfig.php a second time.
     *
     * @param  string  $siteConfigFilePath  complete path to siteconfig.php
     * @param  string  $charset             default character set to use
     * @return  bool                       true: success; false: an error occurred
     */
    protected function setDefaultCharset($siteConfigFilePath, $charset)
    {
        clearstatcache();
        $siteConfigData = @file_get_contents($siteConfigFilePath);
        $siteConfigData = preg_replace(
            '/\$_CONF\[\'default_charset\'] = \'[^\']*\';/',
            "\$_CONF['default_charset'] = '" . $charset . "';",
            $siteConfigData
        );

        return (@file_put_contents($siteConfigFilePath, $siteConfigData) !== false);
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
     * Return the database character set
     *
     * @param  string  $driver  either 'mysql' or 'pgsql'
     * @param  string  $charset
     * @return string
     * @throws InvalidArgumentException
     */
    private function convertLangCharsetToDatabaseCharset($driver, $charset)
    {
        $driver = strtolower($driver);
        if (!in_array($driver, ['mysql', 'pgsql'])) {
            throw new InvalidArgumentException(sprintf('Unknown database driver "%s" was given', $driver));
        }

        $charset = strtolower($charset);

        return array_key_exists($charset, $this->databaseCharsets[$driver])
            ? $this->databaseCharsets[$driver][$charset]
            : self::DEFAULT_DB_CHARSET;
    }

    /**
     * Upgrade any enabled plugins
     * NOTE: Needs a fully working Geeklog, so can only be done late in the upgrade
     *       process!
     *
     * @param  boolean  $migration  whether the upgrade is part of a site migration
     * @param  bool  $upgrade  whether to upgrade plugins
     * @param  array    $old_conf   old $_CONF values before the migration
     * @return int     number of failed plugin updates (0 = everything's fine)
     * @see     PLG_upgrade
     * @see     PLG_migrate
     */
    protected function upgradePlugins($migration = false, $upgrade = false, array $old_conf = [])
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

            if (($success === true) && $upgrade) {
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
}
