<?php

namespace Geeklog\Install;

use config;
use MicroTemplate;

require_once __DIR__ . '/Common.php';

/**
 * Class Upgrade
 *
 * @package Geeklog\Install
 */
class Upgrade extends Common
{
    /**
     * Do a sanity check on the paths and URLs
     * This is somewhat speculative but should provide the user with a working
     * site even if, for example, a site backup was installed elsewhere.
     *
     * @param  string  $path            proper /path/to/Geeklog
     * @param  string  $path_html       path to public_html
     * @param  string  $site_url        The site's URL
     * @param  string  $site_admin_url  URL to the admin directory
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

        // Functions.php is the only file required for a theme
        if (!file_exists($_CONF['path_themes'] . $_CONF['theme']
            . '/functions.php')
        ) {
            $config->set('path_themes', $path_html . 'layout/');

            if (!file_exists($path_html . 'layout/' . $_CONF['theme']
                . '/functions.php')
            ) {
                $config->set('theme', self::DEFAULT_THEME);
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


    public function step2($retval, $req_string)
    {
        // Try and find out what the current version of GL is
        $currentVersion = $this->identifyGeeklogVersion();

        if ($currentVersion == self::GL_VERSION) {
            // If current version is the newest version
            // then there's no need to update.
            $retval .= '<h2>' . Common::$LANG['INSTALL'][74] . '</h2>' . PHP_EOL
                . '<p>' . Common::$LANG['INSTALL'][75] . '</p>';
        } elseif ($currentVersion === 'empty') {
            $retval .= '<h2>' . Common::$LANG['INSTALL'][90] . '</h2>' . PHP_EOL
                . '<p>' . Common::$LANG['INSTALL'][91] . '</p>';
        } else {
            if (!empty($currentVersion)) {
                // Continue on to step 3 where the upgrade will happen
                header('Location: ' . $req_string . '&version=' . $currentVersion);
            }

            // If we were unable to determine the current GL
            // version is then ask the user what it is
            Common::$env['old_versions'] = [];
            $old_versions = [
                '1.2.5-1', '1.3', '1.3.1', '1.3.2', '1.3.2-1', '1.3.3', '1.3.4',
                '1.3.5', '1.3.6', '1.3.7', '1.3.8', '1.3.9', '1.3.10', '1.3.11',
                '1.4.0', '1.4.1', '1.5.0', '1.5.1', '1.5.2', '1.6.0', '1.6.1',
                '1.7.0', '1.7.1', '1.7.2', '1.8.0', '1.8.1', '1.8.2', '2.0.0',
                '2.1.0', '2.1.1', '2.2.0', '2.2.1',
            ];
            $tempCounter = 0;

            foreach ($old_versions as $version) {
                Common::$env['old_versions'][] = [
                    'selected' => (($tempCounter === count($old_versions) - 1) ? ' selected="selected"' : ''),
                    'value'    => $version,
                ];
                $tempCounter++;
            }

            $retval .= MicroTemplate::quick(PATH_LAYOUT, 'step2-upgrade', Common::$env);
            $currentVersion = $old_versions[count($old_versions) - 1];
        }

        return $retval;
    }

    public function step3($retval, $installPlugins)
    {
        global $_CONF;

        // Get and set which version to display
        $version = $this->get('version', $this->post('version', ''));

        // Let's do this
        /**
         * @global $_DB_dbms
         */
        $this->includeConfig(Common::$env['dbconfig_path']);
        /**
         * @global $_CONF
         */
        require_once Common::$env['siteconfig_path'];

        /**
         * @global $_TABLES
         */
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

            if (is_array($row) && isset($row['value'])) {
                Common::$env['use_innodb'] = $use_innodb = ($row['value'] === 'InnoDB');
            } else {
                Common::$env['use_innodb'] = $use_innodb = false;
            }
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
                $_CONF['path'], Common::$env['html_path'],
                urldecode($site_url), urldecode($site_admin_url)
            );

            // disable plugins for which we don't have the source files
            $this->checkPlugins();

            // extra step 4: upgrade plugins
            $nextLink = 'index.php?step=4&mode=upgrade&language=' . Common::$env['language'];

            if ($installPlugins) {
                $nextLink .= '&install_plugins=true';
            }

            header('Location: ' . $nextLink);
        } else {
            $retval .= '<h2>' . Common::$LANG['INSTALL'][78] . '</h2>' . PHP_EOL
                . '<p>' . Common::$LANG['INSTALL'][79] . '</p>' . PHP_EOL;
        }

        return $retval;
    }
}
