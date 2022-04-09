<?php

namespace Geeklog\Install;

use config;
use MicroTemplate;

require_once __DIR__ . '/Common.php';

/**
 * Class Install
 *
 * @package Geeklog\Install
 */
class Install extends Common
{
    /**
     * Check for InnoDB table support (usually as of MySQL 4.0, but may be
     * available in earlier versions, e.g. "Max" or custom builds).
     *
     * @return  bool     true = InnoDB tables supported, false = not supported
     */
    private function isInnoDbSupported()
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
        $_SQL = [];
        $_DATA = [];
        $dbTableAndDataPath = $_CONF['path'] . 'sql/' . $_DB_dbms . '_tableanddata.php';

        $progress = '';

        if ($this->tableExists('access')) {
            return false;
        }

        switch ($_DB_dbms) {
            case 'mysql':
                if (Common::$env['use_innodb']) {
                    $dbTableAndData = @file_get_contents($dbTableAndDataPath);
                    $dbTableAndData = str_replace('<' . '?php', '', $dbTableAndData);
                    $dbTableAndData = preg_replace('/ENGINE\s*=\s*MyISAM/i', 'ENGINE=InnoDB ROW_FORMAT=DYNAMIC', $dbTableAndData);
                    eval($dbTableAndData);
                } else {
                    require_once $dbTableAndDataPath;
                }

                $this->updateDB($_SQL, $progress);

                if (Common::$env['use_innodb']) {
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
     * @param  string  $site_mail  email address, e.g. the site email
     * @param  string  $site_url   the site's URL
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

    public function step2($retval, $req_string, $DB, $utf8, $params)
    {
        Common::$env['installType'] = 'install';
        Common::$env['utf8_string'] = $utf8 ? 'true' : 'false';

        // If using MySQL check to see if InnoDB is supported
        if ($DB['type'] === 'mysql-innodb' && !$this->isInnoDbSupported()) {
            // Warn that InnoDB tables are not supported
            $retval .= MicroTemplate::quick(PATH_LAYOUT, 'step2-install', array_merge(Common::$env, $params));

            return $retval;
        } else {
            // Continue on to step 3 where the installation will happen
            if ($DB['type'] === 'mysql-innodb') {
                $req_string .= '&innodb=true';
            }

            header('Location: ' . $req_string);
        }
    }

    public function step3($retval, $_DB_dbms, $installPlugins, $nextLink, $gl_path)
    {
        global $_CONF, $_DEVICE, $_LOCALE, $_URL, $_TABLES;
        global $LANG01, $LANG03, $LANG04, $LANG05, $LANG08, $LANG09, $LANG10, $LANG11, $LANG12, $LANG20, $LANG21;
        global $LANG23, $LANG24, $LANG27, $LANG28, $LANG29, $LANG31, $LANG32, $LANG33, $MESSAGE;

        if ($this->post('submit') === '<< ' . Common::$LANG['INSTALL'][61]) {
            header('Location: index.php?mode=install');
        }

        // Check whether to use InnoDB tables
        $use_innodb = ($this->post('innodb') === 'true') || ($this->get('innodb') === 'true');
        Common::$env['use_innodb'] = $use_innodb;
        $utf8 = ($this->post('utf8') === 'true') || ($this->get('utf8') === 'true');

        // We need all this just to do one DB query
        $this->includeConfig(Common::$env['dbconfig_path']);
        require_once Common::$env['siteconfig_path'];
        $_CONF['path_system'] = Common::$env['gl_path'] . 'system/';
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
            Common::$env['use_innodb_string'] = $use_innodb ? 'true' : 'false';
            Common::$env['installPlugins'] = $installPlugins ? 'true' : 'false';
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

            Common::$env['site_name'] = $site_name;
            Common::$env['site_slogan'] = $site_slogan;
            Common::$env['site_url'] = urldecode($site_url);
            Common::$env['site_admin_url'] = urldecode($site_admin_url);
            Common::$env['site_mail'] = urldecode($site_mail);
            Common::$env['noreply_mail'] = urldecode($noreply_mail);
            $retval .= MicroTemplate::quick(PATH_LAYOUT, 'step3-install', Common::$env);
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
                $config->set('path_html', Common::$env['html_path']);
                $config->set('path_log', $gl_path . 'logs/');
                $config->set('path_language', $gl_path . 'language/');
                $config->set('backup_path', $gl_path . 'backups/');
                $config->set('path_data', $gl_path . 'data/');
                $config->set('path_images', Common::$env['html_path'] . 'images/');
                $config->set('path_themes', Common::$env['html_path'] . 'layout/');
                $config->set('path_editors', Common::$env['html_path'] . 'editors/');
                $config->set('rdf_file', Common::$env['html_path'] . 'backend/geeklog.rss');
                $config->set('cookie_path', $this->guessCookiePath(urldecode($site_url)));
                $config->set_default('default_photo', urldecode($site_url) . '/images/userphotos/default.png');

                $lng = $this->getDefaultLanguage();

                if (!empty($lng)) {
                    $config->set('language', $lng);
                }

                $this->setVersion(Common::$env['siteconfig_path']);

                if (!$installPlugins) {
                    // do a default install of all available plugins

                    /**
                     * For the plugin install we would actually need
                     * lib-common.php in the global namespace. Since
                     * we're in a function, we need to hack a few
                     * things and rely on a few global declarations
                     * (see beginning of function).
                     */
                    require str_replace('siteconfig.php', 'lib-common.php', Common::$env['siteconfig_path']);
                    $this->defaultPluginInstall();
                }

                // Installation is complete. Continue onto either
                // custom plugin installation page or success page
                header('Location: ' . $nextLink);
            } else {
                $retval .= '<h2>' . Common::$LANG['INSTALL'][67] . '</h2>' . PHP_EOL
                    . '<p>' . Common::$LANG['INSTALL'][68] . '</p>' . PHP_EOL;
            }
        }

        return $retval;
    }
}
