<?php

/**
 * There is now a dependency between the entries for dropdown menus in
 * $LANG_configselects and $_CONF_VALIDATE. If you accidentally translate
 * the keyword, it gets written to the database and fails the validation.
 * These tests ensure that all selection list entries match their equivalent
 * in the list of to-be-validated entries.
 */
class langConfValidation extends PHPUnit_Framework_TestCase
{
    /**
     * @var config
     */
    private $c;

    protected function setUp()
    {
        global $_CONF, $_CONF_VALIDATE, $_USER;

        // set dummy values for the $_CONF options used in the language files
        $_CONF = array();
        $_CONF['site_url'] = 'http://www.example.com';
        $_CONF['site_admin_url'] = 'http://www.example.com/admin';
        $_CONF['site_name'] = 'Test Site';
        $_CONF['speedlimit'] = 42;
        $_CONF['commentspeedlimit'] = 42;
        $_CONF['backup_path'] = '/path/to/geeklog/';
        $_DB_mysqldump_path = '/usr/bin/mysqldump';

        $_USER['username'] = 'John Doe';

        if (!defined('XHTML')) {
            define('XHTML', '');
        }

        if (!defined('TOPIC_ALL_OPTION')) {
            define('TOPIC_ALL_OPTION', 'all');
        }

        if (!defined('TOPIC_NONE_OPTION')) {
            define('TOPIC_NONE_OPTION', 'none');
        }

        if (!defined('TOPIC_HOMEONLY_OPTION')) {
            define('TOPIC_HOMEONLY_OPTION', 'homeonly');
        }

        if (!defined('TOPIC_SELECTED_OPTION')) {
            define('TOPIC_SELECTED_OPTION', 'selectedtopics');
        }

        if (!defined('TOPIC_ROOT')) {
            define('TOPIC_ROOT', 'root');
        }

        // there's a date() call somewhere - make PHP 5.2 shut up
        $system_timezone = @date_default_timezone_get();
        date_default_timezone_set($system_timezone);

        $this->c = config::get_instance();

        include Tst::$root . 'language/english.php';
        include Tst::$public . 'admin/configuration_validation.php';
        require_once Tst::$public . 'admin/install/config-install.php';

        install_config();
    }

    /**
     * Check for missing entries in a language array
     *
     * @param  string $type e.g. 'Core', 'calendar', ...
     * @param  string $lang e.g., 'english.php', 'english_utf-8.php', ...
     */
    protected function checkForMissingEntries($type, $lang = '')
    {
        global $_CONF_VALIDATE, $LANG_configselects;

        // loop through validation rules
        foreach ($_CONF_VALIDATE[$type] as $key => $val) {
            $this->assertTrue((@$val['rule'] !== null), "Rule missing: type = {$type}, lang = '{$lang}', key = '{$key}.");

            if (is_array($val['rule'])) {
                $rule = $val['rule'];
                // pick only those comparing against a list
                if ($rule[0] == 'inList') {
                    $values = $rule[1];
                    $numeric = false;
                    foreach ($values as $v) {
                        if (is_numeric($v)) {
                            $numeric = true;
                            break;
                        }
                    }
                    // we're only interested in lists with non-numeric entries
                    if (!$numeric) {
                        $sel = $this->c->has_sel($key);
                        // does it refer to a $LANG_configselects?
                        if ($sel !== false) {
                            if (isset($LANG_configselects[$type][$sel])) {
                                // entries we compare against (reference)
                                $ref = $LANG_configselects[$type][$sel];
                                // should have same number of entries, obviously
                                $this->assertEquals(count($ref), count($values));
                                // key/value is flipped in language file
                                $flipped = array_flip($ref);
                                foreach ($values as $v) {
                                    $this->assertTrue(isset($flipped[$v]),
                                        "$lang: '$key' missing '$v'");
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function testBasics()
    {
        global $_CONF_VALIDATE;

        // dummy entry, should not be set
        $this->assertFalse($this->c->has_sel('does_not_exist'));

        // is not a selection
        $this->assertFalse($this->c->has_sel('maximagesperarticle'));

        // is a selection and the index is 7
        $this->assertEquals(7, $this->c->has_sel('page_break_comments'));

        // look at one validation entry a little closer
        $rule = $_CONF_VALIDATE['Core']['page_break_comments']['rule'];
        $this->assertEquals($rule[0], "inList");
        $this->assertTrue(is_array($rule[1]));
        $this->assertEquals(3, count($rule[1]));
        $this->assertEquals("all", $rule[1][0]);
    }

    /* covered by testCoreLanguages() below
        public function testCoreEnglish() {
            global $_CONF,
                   $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

            include Tst::$root.'language/english.php';
            $this->checkForMissingEntries('Core');
        }
        public function testLinksPluginEnglish() {
            global $_CONF,
                   $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

            include Tst::$root.'plugins/links/language/english.php';
            include Tst::$root.'plugins/links/configuration_validation.php';
            $this->checkForMissingEntries('links', 'english.php');
        }
    */
    /**
     * @group slow
     */
    public function testCoreLanguages()
    {
        global $_CONF, $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $basePath = Tst::$root . 'language/';

        foreach (glob($basePath . '*.php') as $file) {
            include $file;
            $this->checkForMissingEntries('Core', $file);
        }
    }

    public function testCalendarPluginLanguages()
    {
        global $_CONF, $_CONF_VALIDATE, $_USER, $_DB_mysqldump_path, $LANG_configselects;

        $basePath = Tst::$root . 'plugins/calendar/';

        include $basePath . 'configuration_validation.php';

        foreach (glob($basePath . 'language/*.php') as $file) {
            include $file;
            $this->checkForMissingEntries('calendar', $file);
        }
    }

    public function testLinksPluginLanguages()
    {
        global $_CONF, $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $basePath = Tst::$root . 'plugins/links/';

        include $basePath . 'configuration_validation.php';

        foreach (glob($basePath . 'language/*.php') as $file) {
            include $file;
            $this->checkForMissingEntries('links', $file);
        }
    }

    public function testPollsPluginLanguages()
    {
        global $_CONF, $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $basePath = Tst::$root . 'plugins/polls/';

        include $basePath . 'configuration_validation.php';

        foreach (glob($basePath . 'language/*.php') as $file) {
            include $file;
            $this->checkForMissingEntries('polls', $file);
        }
    }

    public function testSpamXPluginLanguages()
    {
        global $_CONF, $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $basePath = Tst::$root . 'plugins/spamx/';

        include $basePath . 'configuration_validation.php';

        foreach (glob($basePath . 'language/*.php') as $file) {
            include $file;
            $this->checkForMissingEntries('spamx', $file);
        }
    }

    public function testStaticPagesPluginLanguages()
    {
        global $_CONF, $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $basePath = Tst::$root . 'plugins/staticpages/';

        include $basePath . 'configuration_validation.php';

        foreach (glob($basePath . 'language/*.php') as $file) {
            include $file;
            $this->checkForMissingEntries('staticpages', $file);
        }
    }

    public function testXMLSitemapPluginLanguages()
    {
        global $_CONF, $_CONF_VALIDATE, $_DB_mysqldump_path, $LANG_configselects;

        $basePath = Tst::$root . 'plugins/xmlsitemap/';

        include $basePath . 'configuration_validation.php';

        foreach (glob($basePath . 'language/*.php') as $file) {
            include $file;
            $this->checkForMissingEntries('xmlsitemap', $file);
        }
    }
}

/**
 * Class config
 *
 * This class is a dummy for testing the langConfValidation class
 */
class config
{
    private $cfg;

    public function __construct()
    {
        $this->cfg = array();
    }

    public static function get_instance()
    {
        static $instance;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    function add($param_name, $default_value, $type, $subgroup, $fieldset = null,
                 $selection_array = null, $sort = 0, $set = true, $group = 'Core', $tab = null)
    {
        if ($selection_array !== null) {
            $this->cfg[$param_name] = $selection_array;
        }
    }

    function has_sel($param_name)
    {
        if (isset($this->cfg[$param_name]) && ($this->cfg[$param_name] !== null)) {
            return $this->cfg[$param_name];
        } else {
            return false;
        }
    }
}
