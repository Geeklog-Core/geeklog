<?php

// +---------------------------------------------------------------------------+
// | Geeklog Emergency Rescue Tool                                             |
// +---------------------------------------------------------------------------+
// | admin/rescue.php                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010-2022 Wayne Patterson [suprsidr@flashyourweb.com]       |
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
//

use Geeklog\Autoload;

require_once dirname(dirname(__DIR__)) . '/siteconfig.php';

// Set dummy contents to prevent "undefined variable" E_NOTICE
$_CONF['backup_path'] = $_CONF['path'] . 'backups/';
$_CONF['commentspeedlimit'] = 10;
$_CONF['invalidloginattempts'] = 3;
$_CONF['invalidloginmaxtime'] = 10;
$_CONF['min_theme_gl_version'] = '2.2.2';
$_CONF['site_admin_url'] = '';
$_CONF['site_name'] = '';
$_CONF['site_url'] = '';
$_CONF['speedlimit'] = 10;
$_CONF['theme'] = 'denim_three';
$_CONF['theme_site_default'] = 'denim_three';

// Load autoloader
if (is_readable($_CONF['path'] . 'system/classes/Autoload.php')) {
    require_once $_CONF['path'] . 'system/classes/Autoload.php';
    Autoload::initialize();
}

require_once $_CONF['path'] . 'db-config.php';
require_once $_CONF['path_system'] . 'lib-database.php';
require_once $_CONF['path_system'] . 'lib-security.php';

if (!defined('LB')) {
    define('LB', "\n");
}

if (!defined('CRLB')) {
    define('CRLB', "\r\n");
}

if (!defined('XHTML')) {
    define('XHTML', '');
}

// This
$self = basename(__FILE__);

// The conf_values we're making available to edit.
$configs = [
    'site_url', 'site_admin_url', 'site_mail', 'language', 'path_html', 'path_log',
    'path_language', 'backup_path', 'path_data', 'theme', 'cookie_path', 'cookiedomain',
];

// Start it off
$lang = 'english';

if (isset($_POST['lang'])) {
    $lang = preg_replace('/[^0-9_a-z-]/i', '', $_POST['lang']);
} elseif (isset($_GET['lang'])) {
    $lang = preg_replace('/[^0-9_a-z-]/i', '', $_GET['lang']);
}

$langfile = __DIR__ . '/language/' . $lang . '.php';
if (!file_exists($langfile)) {
    $lang = 'english';
    $langfile = __DIR__ . '/language/' . $lang . '.php';
}
require_once $langfile;

if (! empty($_COOKIE['GLEMERGENCY']) && trim($_COOKIE['GLEMERGENCY']) == md5($_DB_pass)) {
    /* Already logged in, got a cookie */
    $view = (isset($_REQUEST['view']) && $_REQUEST['view'] != '') ? trim($_REQUEST['view']) : 'options';
    $tmpArray = $args = array();
    $tmp = (isset($_REQUEST['args']) && $_REQUEST['args'] != '') ? trim($_REQUEST['args']) : '';
    if (strlen($tmp)) {
        $tmpArray = explode('|', $tmp);
        foreach ($tmpArray as $pair) {
            $parts = explode(':', $pair);
            $args[$parts[0]] = $parts[1];
        }
    }
    render($view, $args);
    exit;
} elseif (! empty($_POST['gl_password'])) {
    // Login attempt
    if ($_POST['gl_password'] == $_DB_pass) {
        $sql = "SELECT name, value FROM {$_TABLES['conf_values']} "
            . "WHERE (group_name = 'Core') "
            . "AND ((name = 'cookie_path') OR (name = 'cookiedomain') OR (name = 'cookiesecure'))";
        $result = DB_query($sql);

        if (!DB_error()) {
            $rows = [];

            while (($A = DB_fetchArray($result, false))) {
                $rows[$A['name']] = unserialize($A['value']);
            }
        } else {
            $rows = [
                'cookie_path'  => str_ireplace(
                    basename(__FILE__),
                    '',
                    str_replace(
                        $_SERVER['DOCUMENT_ROOT'], '', @$_SERVER['SCRIPT_FILENAME']
                    )
                ),
                'cookiedomain' => '',
                'cookiesecure' => (isset($_SERVER['REQUEST_SCHEME']) && ($_SERVER['REQUEST_SCHEME'] === 'https')) ||
                    (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on')) ||
                    (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] == 443)),
            ];
        }

        SEC_setCookie(
            "GLEMERGENCY", md5($_DB_pass), 0,
            $rows['cookie_path'], $rows['cookiedomain'], $rows['cookiesecure']
        );
        $url = $self . '?view=options&amp;args=result:success|statusMessage:' . urlencode(s(0)) . '&amp;lang=' . urlencode($lang);
        echo "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>" . LB;
    } else {
        render('passwordForm', array('incorrectPassword' => 1));
        exit;
    }
} else {
    render('passwordForm');
    exit;
}

function s($index) {
    global $self, $LANG_RESCUE;

    return str_replace('{{SELF}}', $self, $LANG_RESCUE[$index]);
}

function e($index) {
    echo s($index);
}

function langSelector() {
    global $lang;

    $retval = '<form action="" method="post">' . LB
            . '<div>' . LB
            . '<select name="lang">' . LB;

    if (is_readable(__DIR__ .'/language/_list.php')) {
        $files = include __DIR__ . '/language/_list.php';

        foreach ($files as $file => $data) {
            $file = basename($file);
            $file = str_replace('.php', '', $file);
            $selected = ($file === $lang) ? ' selected="selected"' : '';
            $retval .= '<option value="' . $file . '"' . $selected . '>' . $data['langName'] . ' (' . $data['english'] . ')' . '</option>' . LB;
        }
    }

    $retval .= '</select>' . LB
            .  '<input type="submit" name="submit" value="' . s(41) . '" />' . LB
            .  '</div>' . LB
            .  '</form>' . LB;

    return $retval;
}

function encryptPassword($password) {
    global $_TABLES;

    $version = preg_replace('/[^0-9.]/', '', VERSION);

    if (version_compare($version, '2.0.0', '<')) {
        $retval = SEC_encryptPassword($password);
    } else {
        $salt      = DB_getItem($_TABLES['users'], 'salt', "uid = 2");
        $algorithm = DB_getItem($_TABLES['conf_values'], 'value', "name = 'pass_alg'");
        $stretch   = DB_getItem($_TABLES['conf_values'], 'value', "name = 'pass_stretch'");
        $algorithm = unserialize($algorithm);
        $stretch   = unserialize($stretch);
        $retval = SEC_encryptPassword($password, $salt, $algorithm, $stretch);
    }

    return $retval;
}

function render($renderType, $args = array()) {
    global $_TABLES, $self, $configs, $LANG_CHARSET, $LANG_DIRECTION, $lang;

    header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="<?php echo isset($LANG_DIRECTION) ? $LANG_DIRECTION : 'ltr'; ?>">
    <head>
        <title><?php e(1); ?></title>
        <?php printHtmlStyle(); ?>
        <?php printJs(); ?>
    </head>
    <body>
        <div class="main center">
        <div class="header-navigation-container">
            <div class="header-navigation-line">
                <a href="index.php?language=<?php echo $lang; ?>" class="header-navigation"><?php e(2); ?></a>&nbsp;&nbsp;&nbsp;<?php echo langSelector(); ?>&nbsp;&nbsp;
            </div>
        </div>
        <h1><?php e(3); ?></h1>
        <div class="box important">
            <p><?php e(4); ?></p>
        </div>
        <?php if (! empty($args['statusMessage'])): ?>
        <div class="box <?php echo trim($args['result']); ?>">
            <strong><?php e(5); ?>:</strong>
            <?php echo $args['statusMessage']; ?>
        </div>
        <?php endif; ?>
        <?php if ($renderType === 'passwordForm'): ?>
        <h2><?php e(6); ?></h2>
        <div class="password_form">
            <div class="box">
                <span class="message"><?php e(7); ?></span>
                <form id="loginForm" method="post" action="">
                    <?php e(8); ?>:<input type="password" name="gl_password" />
                    <script type="text/javascript">
                        document.getElementById('loginForm')['gl_password'].focus();
                    </script>
                    <input type="submit" value="<?php e(9); ?>" onclick="this.disabled=true;this.form.submit();" />
                    <input type="hidden" name="lang" value="<?php echo $lang; ?>" />
                </form>
                <?php if (! empty($args['incorrectPassword'])): ?>
                <div class="error">
                    <?php e(10); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php elseif ($renderType === 'handleRequest'):
            $sql = sprintf("%s %s SET %s = '%s' WHERE %s = '%s'", $args['operation'], $_TABLES[$args['table']], $args['field'], trim($_POST['value']), $args['where'], trim($_POST['target']));
            $enable = (trim($_POST['value'])) ? s(11) : s(12);
            $success = (DB_query($sql)) ? s(13) : s(14);
            $url = $self . '?view=options&amp;args=result:' . urlencode($success) . '|statusMessage:' . urlencode($success . $enable . trim($_POST['target'])) . '&amp;lang=' . urlencode($lang);
            echo "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>" . LB;
        ?>
        <?php elseif ($renderType === 'updateConfigs'):
            if ($_POST['old_path_html'] !== $_POST['path_html']) {
                // $_CONF['path_html'] was changed, so we have to update $_CONF['path_themes'],
                // $_CONF['path_editors'], $_CONF['path_images'], and $_CONF['rdf_file'] values accordingly
                $_POST['path_html'] = rtrim($_POST['path_html'], '/\\') . '/';
                $_POST['path_themes'] = $_POST['path_html'] . 'layout/';
                $_POST['path_editors'] = $_POST['path_html'] . 'editors/';
                $_POST['path_images'] = $_POST['path_html'] . 'images/';
                $_POST['rdf_file'] = str_ireplace($_POST['old_path_html'], $_POST['path_html'], $_POST['rdf_file']);
            }

            foreach ($configs as $config){
                $sql = sprintf("UPDATE %s SET value = '%s' WHERE name = '%s'", $_TABLES['conf_values'], serialize($_POST[$config]), $config);
                if (DB_query($sql)) {
                    continue;
                } else {
                    $url = $self.'?view=options&amp;args=result:error|statusMessage:' . urlencode(s(15)) . '&amp;lang=' . urlencode($lang);
                    echo "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>" . 'LB';
                    exit;
                }
            }
            $url = $self.'?view=options&amp;args=result:success|statusMessage:' . urlencode(s(16)) . '&amp;lang=' . urlencode($lang);
            echo "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>" . 'LB';
        ?>
        <?php elseif ($renderType === 'updateEmail'):
            $passwd = rand();
            $passwd = md5($passwd);
            $passwd = substr($passwd, 1, 8);
            $username = DB_getItem($_TABLES['users'], 'username', "uid = '2'");
            $sql = sprintf("UPDATE %s SET passwd = '%s' WHERE username = '%s'", $_TABLES['users'], encryptPassword($passwd), $username);
            if (!(DB_query($sql))) {
                $url = $self . '?view=options&amp;args=result:error|statusMessage:' . urlencode(s(17)) . '&amp;lang=' . urlencode($lang);
                echo "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>" . LB;
                exit;
            }
            $email = DB_getItem($_TABLES['users'], 'email', "uid = '2'");
            $site_url = unserialize(DB_getItem($_TABLES['conf_values'], 'value', "name = 'site_url'"));
            $to  = $email;
            $subject = s(18);
            $message = sprintf('
            <html>
            <head>
              <title>' . s(19) . '</title>
            </head>
            <body>
              <p>' . s(20) . '</p>
              <p>' . s(21) . '</p>
            </body>
            </html>
            ', $passwd, $username, $site_url);
            $headers  = 'MIME-Version: 1.0' . CRLB;
            $headers .= 'Content-type: text/html; charset=' . $LANG_CHARSET . CRLB;
            $headers .= 'X-Mailer: PHP/' . PHP_VERSION;
            if (mail($to, $subject, $message, $headers)) {
                $url = $self.'?view=options&amp;args=result:success|statusMessage:' . urlencode(s(22)) . '&amp;lang=' . urlencode($lang);
                echo "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
                exit;
            } else {
                $url = $self.'?view=options&amp;args=result:error|statusMessage:' . urlencode(s(23) . $subject) . '&amp;lang=' . urlencode($lang);
                echo "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
                exit;
            }
        ?>
        <?php elseif ($renderType === 'phpinfo'): ?>
        <h2><?php e(24); ?></h2>
        <ul><li><a href="javascript:self.location.href='<?php echo $self . '?lang=' . urlencode($lang); ?>';"> <?php e(25); ?></a></li></ul>
        <div class="info">
            <?php phpinfo(); ?>
        </div>
        <ul><li><a href="javascript:self.location.href='<?php echo $self . '?lang=' . urlencode($lang); ?>';"> <?php e(25); ?></a></li></ul>
        <?php elseif ($renderType === 'options'): ?>
        <h2><?php e(26); ?></h2>
        <div class="info">
            <ul>
                <li><?php e(27); ?>: <?php echo PHP_VERSION; ?> <?php if (is_callable('phpinfo')): ?><a href="<?php echo $self; ?>?view=phpinfo<?php echo '&amp;lang=' . urlencode($lang); ?>"> <small>phpinfo</small></a><?php endif; ?></li>
                <li><?php e(28); ?> <?php echo VERSION; ?></li>
            </ul>
        </div>

        <?php
        // ********************************************************
        // A few checks to see if Geeklog is installed properly. If not we generate a php error and stop tool
        function fatal_handler() {
            $error = error_get_last();
            //check if it's a core/fatal error, otherwise it's a normal shutdown
            if ($error !== null) {
            ?>
            <div class="box error">
                <p><?php e(45); ?></p>
            </div>
        </div>
    </body>
</html>
            <?php
                die;
            }
        }
        register_shutdown_function( 'fatal_handler');

        // Check if `conf_values` table exists
        $count = DB_count($_TABLES['conf_values']);
        if ($count == 0) {
            trigger_error('Fatal error', E_USER_ERROR);
        }

        // Check if `vars` table exists
        $count = DB_count($_TABLES['vars']);
        if ($count == 0) {
            trigger_error('Fatal error', E_USER_ERROR);
        }
        // ********************************************************
        ?>


        <h2><?php e(29); ?></h2>
        <p style="margin-left:5px;"><?php e(30); ?></p>
        <ul class="option">
            <li><a href="javascript:toggle('plugins')"><?php e(31); ?></a></li>
            <li><a href="javascript:toggle('blocks')"><?php e(32); ?></a></li>
            <li><a href="javascript:toggle('conf')"><?php e(33); ?></a></li>
            <li><a href="javascript:toggle('pass')"><?php e(34); ?></a></li>
        </ul>
        <div id="plugins" name="options" class="box option" style="display: none;">
            <h3><?php e(35); ?></h3>
            <form id="plugin-operator" method="post" action="">
                <select name="target" onchange="toggleRadio(this.options[this.selectedIndex].getAttribute('class') == 'disabled', this.form.elements['value']);">
                    <option selected="selected" value=""><?php e(36); ?></option>
                    <?php
                    $result = DB_query("SELECT * FROM {$_TABLES['plugins']}");
                    while ($A = DB_fetchArray($result)){
                        $class = ($A['pi_enabled'] == 0) ? 'class="disabled"' : '';
                        echo '<option ' . $class . ' value="' . $A['pi_name'] . '">' . $A['pi_name'] . '</option>'."\n";
                    }
                    ?>
                </select>
                <input type="radio" name="value" id="enable_plugin" value="1" /><label for="enable_plugin"><?php e(37); ?></label>
                <input type="radio" name="value" id="disable_plugin" value="0" checked="checked" /><label for="disable_plugin"><?php e(38); ?></label><br />
                <input type="hidden" name="view" value="handleRequest" />
                <input type="hidden" name="args" value="operation:UPDATE|table:plugins|field:pi_enabled|where:pi_name" />
                <input type="submit" value="<?php e(41); ?>" onclick="this.disabled=true;this.form.submit();" />
            </form>
            <p>&nbsp;</p>
        </div>
        <div id="blocks" name="options" class="box option" style="display: none;">
            <h3><?php e(39); ?></h3>
            <form id="block-operator" method="post">
                <select name="target" onchange="toggleRadio(this.options[this.selectedIndex].getAttribute('class') == 'disabled', this.form.elements['value']);">
                    <option selected="selected" value=""><?php e(40); ?></option>
                    <?php
                    $result = DB_query("SELECT * FROM {$_TABLES['blocks']}");
                    while ($A = DB_fetchArray($result)){
                        $class = ($A['is_enabled'] == 0) ? 'class="disabled"' : '';
                        echo '<option ' . $class . ' value="' . $A['name'] . '">' . $A['title'] . '</option>'."\n";
                    }
                    ?>
                </select>
                <input type="radio" name="value" id="enable_block" value="1" /><label for="enable_block"><?php e(37); ?></label>
                <input type="radio" name="value" id="disable_block" value="0" checked="checked" /><label for="disable_block"><?php e(38); ?></label><br />
                <input type="hidden" name="view" value="handleRequest" />
                <input type="hidden" name="args" value="operation:UPDATE|table:blocks|field:is_enabled|where:name" />
                <input type="submit" value="<?php e(41); ?>" onclick="this.disabled=true;this.form.submit();" />
            </form>
            <p>&nbsp;</p>
        </div>
        <div id="conf" name="options" class="box option" style="display: none;">
            <h3><?php e(42); ?></h3>
            <form id="config-operator" method="post" action="<?php echo $self . '?view=updateConfigs' . '&amp;lang=' . urlencode($lang); ?>" />
                <?php
                    foreach ($configs as $config) {
                        $sql = "SELECT value FROM {$_TABLES['conf_values']} WHERE name ='{$config}' LIMIT 1";
                        $res = DB_query($sql);
                        $row = DB_fetchArray($res);
                ?>
                        <fieldset><legend><?php echo $config; ?>:</legend><input type="text" size="80" id="<?php echo $config; ?>" name="<?php echo $config; ?>" value="<?php echo unserialize($row['value']); ?>" /></fieldset>
                <?php
                        if ($config === 'path_html') {
                            echo '<input type="hidden" name="old_path_html" id="old_path_html" value="' . unserialize($row['value']) . '" />';
                        }
                    }
                ?>
                <input type="submit" value="<?php e(41); ?>" onclick="this.disabled=true;this.form.submit();" />
            </form>
            <p>&nbsp;</p>
        </div>
        <div id="pass" name="options" class="box option" style="display: none;">
            <h3><?php e(43); ?></h3>
            <form id="config-operator" method="post" action="<?php echo $self . '?view=updateEmail' . '&amp;lang=' . urlencode($lang); ?>" />
                <input type="submit" value="<?php e(44); ?>" onclick="this.disabled=true;this.form.submit();" />
            </form>
            <p>&nbsp;</p>
        </div>
        <?php endif; ?>
        <div class="box important">
            <p><?php e(4); ?></p>
        </div>
        </div>
    </body>
    </html>
<?php
}

function printHtmlStyle() {
?>
<style type="text/css">
    html {
        font-family: "Lucida Grande", Verdana, Arial, sans-serif;
        font-size: 1.0em;
    }

    body {
        font-size: .80em;
        margin: 16px 16px 0 16px;
        background: white;
    }

    h1, h2 {
        font-family: "Gill Sans", Verdana, Arial, sans-serif;
        color: #333;
        margin: 0;
        padding: 1.0em 0 0.15em 0;
    }

    h1 {
        font-size: 1.5em;
        border-bottom: 1px solid #ddd;
    }

    h2 {
        font-size: 1.3em;
        padding: 2px;
    }

    h3 {
        color: #333;
        font-size: .9em;
        padding: 2px;
    }

    pre {
        font-size: 1.2em;
    }

    div.box {
        border: solid #ddd 1px;
        margin: 15px;
        padding: 10px;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
    }

    div.important {
        background: #5ba3e3;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
    }

    div.success {
        color: #333;
        background: #c1fec0;
    }

    div.error {
        color: #333;
        background: #ffd2d2;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
    }

    div.option {
        display: block;
        color: #919191;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
    }

    ul.option li a, ul.option li a:hover {
        color: #333;
        text-decoration: none;
    }

    ul.option li a:hover {
        color: #adadad;
        text-decoration: underline;
    }

    div.center {
        margin: 0 auto;
        position: relative;
    }

    div.main {
        width: 960px;
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
    }

    option.disabled {
        background-color: #e5e5e3;
    }

    fieldset {
        border: 0px solid #ccc;
    }

    .header-navigation-line {
        text-align:right;
    }
</style>
<?php
}

function printJs() {
?>
<script type="text/javascript">
    function toggle(objId){
        var o = document.getElementById(objId),
            i, others;

        o.style.display = (o.style.display === 'none') ? 'block' : 'none';
        others = document.getElementsByTagName('div');

        for (i = 0; i < others.length; i++) {
            if (((others[i].id === 'plugins') || (others[i].id === 'blocks') ||
                 (others[i].id === 'conf') || (others[i].id === 'pass')) &&
                (others[i].id !== objId)) {
                others[i].style.display = 'none';
            }
        }
    }

    //The following does not work in IE and I don't care!
    function toggleRadio(checked, elements){
        var radios = elements;

        if (checked) {
            radios[0].click();
        } else {
            radios[1].click();
        }
    }
</script>
<?php
}
