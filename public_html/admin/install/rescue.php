<?php
// +---------------------------------------------------------------------------+
// | Geeklog Emergency Rescue Tool                                             |
// +---------------------------------------------------------------------------+
// | admin/rescue.php                                                          |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 Wayne Patterson [suprsidr@flashyourweb.com]            |
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
require_once '../../siteconfig.php';
require_once $_CONF['path'].'db-config.php';
require_once $_CONF['path_system'].'lib-database.php';

// This
$self = basename(__FILE__);

// The conf_values we're making available to edit.
$configs = array('site_url', 'site_admin_url', 'path_html', 'path_themes', 'path_log', 'path_language', 'theme');

// Start it off
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
} else if (! empty($_POST['gl_password'])) {
    /* Login attempt */
    if ($_POST['gl_password'] == $_DB_pass) {
        setcookie("GLEMERGENCY", md5($_DB_pass), 0);
        $url = $self.'?view=options&args=result:success|statusMessage:'.urlencode('Login successful');
        print "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
    } else {
        render('passwordForm', array('incorrectPassword'=>1));
        exit;
    }
} else {
    render('passwordForm');
    exit;
}


function render($renderType, $args = array()) {
    global $_TABLES, $self, $configs;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Geeklog Emergency Rescue Tool</title>
        <?php printHtmlStyle(); ?>
        <?php printJs(); ?>
    </head>
    <body>
        <div class="main center">
        <div class="header-navigation-container">
            <div class="header-navigation-line">    
                <a href="index.php" class="header-navigation">Geeklog Install</a>&nbsp;&nbsp;&nbsp;
            </div>
        </div>          
        <h1>Geeklog Emergency Rescue Tool</h1>
        <div class="box important">
            <p>Do not forget to <b>delete this <?php print $self; ?> file and the install directory once you are done!</b>
               If other users guess the password, they can seriously harm your geeklog installation!
            <p>
        </div>
        <?php if (! empty($args['statusMessage'])): ?>
        <div class="box <?php print trim($args['result']); ?>">
            <b>Status:</b>
            <?php print $args['statusMessage']; ?>
        </div>
        <?php endif; ?>
        <?php if ($renderType == 'passwordForm'): ?>
        <h2>You are attempting to access a secure section.  You can't
            proceed until you pass the security check.</h2>
        <div class="password_form">
            <div class="box">
                <span class="message">In order to verify you, we require you to enter your database password.  This is
                    the password that is stored in geeklog's db-config.php</span>
                <form id="loginForm" method="post">
                    Password:<input type="password" name="gl_password"/>
                    <script type="text/javascript">
                        document.getElementById('loginForm')['gl_password'].focus();
                    </script>
                    <input type="submit" value="Verify Me" onclick="this.disabled=true;this.form.submit();"/>
                </form>
                <?php if (! empty($args['incorrectPassword'])): ?>
                <div class="error">
                    Password incorrect!
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php elseif ($renderType == 'handleRequest'):
            $sql = sprintf("%s %s SET %s = '%s' WHERE %s = '%s'", $args['operation'], $_TABLES[$args['table']], $args['field'], trim($_POST['value']), $args['where'], trim($_POST['target']));
            $enable = (trim($_POST['value']))?'enabling ':'disabling ';
            $success = (DB_query($sql))?'success ':'error ';
            $url = $self.'?view=options&args=result:'.$success.'|statusMessage:'.urlencode($success.$enable.trim($_POST['target']));
            print "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
        ?>
        <?php elseif ($renderType == 'updateConfigs'):
            foreach ($configs as $config){
                $sql = sprintf("UPDATE %s SET value = '%s' WHERE name = '%s'", $_TABLES['conf_values'], serialize($_POST[$config]), $config);
                if(DB_query($sql)){
                    continue;
                }else{
                    $url = $self.'?view=options&args=result:error|statusMessage:'.urlencode('There was an error updating configs');
                    print "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
                    exit;
                }
            }
            $url = $self.'?view=options&args=result:success|statusMessage:'.urlencode('Updating configs completed successfully');
            print "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
        ?>
        <?php elseif ($renderType == 'updateEmail'):
            $passwd = rand ();
            $passwd = md5 ($passwd);
            $passwd = substr ($passwd, 1, 8);
            $username = DB_getItem($_TABLES['users'], 'username', "uid = '2'");
            $sql = sprintf("UPDATE %s SET passwd = '%s' WHERE username = '%s'", $_TABLES['users'], md5($passwd), $username);
            if(!(DB_query($sql))){
                $url = $self.'?view=options&args=result:error|statusMessage:'.urlencode('There was an error updating your password');
                print "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
                exit;
            }
            $email = DB_getItem($_TABLES['users'], 'email', "uid = '2'");
            $site_url = unserialize(DB_getItem($_TABLES['conf_values'], 'value', "name = 'site_url'"));
            $to  = $email;
            $subject = 'Geeklog password request';
            $message = sprintf('
            <html>
            <head>
              <title>Requested Password</title>
            </head>
            <body>
              <p>Someone (hopefully you) has accessed the emergency password request form and a new password:"%s" for your account "%s" on %s, has been generated.</p>
              <p>If it was not you, please check the security of your site. Make sure to remove the Emergency Rescue Form /admin/rescue.php</p>
            </body>
            </html>
            ', $passwd, $username, $site_url);
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();
            if(mail($to, $subject, $message, $headers)){
                $url = $self.'?view=options&args=result:success|statusMessage:'.urlencode('New password has been sent to the recorded email address');
                print "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
                exit;
            }else{
                $url = $self.'?view=options&args=result:error|statusMessage:'.urlencode('There was an error sending email with the subject: '.$subject);
                print "<html><head><meta http-equiv=\"refresh\" content=\"0; URL=$url\"></head></html>\n";
                exit;
            }
        ?>
        <?php elseif ($renderType == 'phpinfo'): ?>
        <h2>PHP Information </h2>
        <ul><li><a href="javascript:self.location.href='<?php print $self; ?>';"> Reset</a></li></ul>
        <div class="info">
            <?php phpinfo(); ?>
        </div>
        <ul><li><a href="javascript:self.location.href='<?php print $self; ?>';"> Reset</a></li></ul>
        <?php elseif ($renderType == 'options'): ?>
        <h2>System Information </h2>
        <div class="info">
            <ul>
                <li>PHP version: <?php print phpversion(); ?> <a href="<?php print $self; ?>?view=phpinfo"> <small>phpinfo</small></a></li>
                <li>Geeklog version <?php print VERSION; ?></li>
            </ul>
        </div>
        <h2>Options </h2>
        <p style="margin-left:5px;">If you happen to install a plugin or addon that brings down your geeklog site, you can remedy the problem with the options below.</p>
        <ul class="option">
            <li><a href="javascript:toggle('plugins')">Enable/Disable Plugins</a></li>
            <li><a href="javascript:toggle('blocks')">Enable/Disable Blocks</a></li>
            <li><a href="javascript:toggle('conf')">Edit Select $_CONF Values</a></li>
            <li><a href="javascript:toggle('pass')">Reset Admin Password</a></li>
        </ul>
        <div id="plugins" name="options" class="box option" style="display:none;">
            <h3>Here you can enable/disable any plugin that is currently installed on your geeklog website.</h3>
            <form id="plugin-operator" method="post">
                <select name="target" onchange="toggleRadio(this.options[this.selectedIndex].getAttribute('class') == 'disabled', this.form.elements['value']);">
                    <option selected="selected" value="">Select a plugin</option>
                    <?php
                    $result = DB_query( "SELECT * FROM {$_TABLES['plugins']}");
                    while ($A = DB_fetchArray($result)){
                        $class = ($A['pi_enabled'] == 0)?'class="disabled"':'';
                        echo '<option '.$class.' value="'.$A['pi_name'].'">'.$A['pi_name'].'</option>'."\n";
                    }
                    ?>
                </select>
                <input type="radio" name="value" value="1"/>Enable
                <input type="radio" name="value" value="0" checked="checked"/>Disable<br />
                <input type="hidden" name="view" value="handleRequest"/>
                <input type="hidden" name="args" value="operation:UPDATE|table:plugins|field:pi_enabled|where:pi_name"/>
                <input type="submit" value="Go" onclick="this.disabled=true;this.form.submit();"/>
            </form>
            <p>&nbsp;</p>
        </div>
        <div id="blocks" name="options" class="box option" style="display:none;">
            <h3>Here you can enable/disable any block that is currently installed on your geeklog website.</h3>
            <form id="block-operator" method="post">
                <select name="target" onchange="toggleRadio(this.options[this.selectedIndex].getAttribute('class') == 'disabled', this.form.elements['value']);">
                    <option selected="selected" value="">Select a block</option>
                    <?php
                    $result = DB_query( "SELECT * FROM {$_TABLES['blocks']}");
                    while ($A = DB_fetchArray($result)){
                        $class = ($A['is_enabled'] == 0)?'class="disabled"':'';
                        echo '<option '.$class.' value="'.$A['name'].'">'.$A['title'].'</option>'."\n";
                    }
                    ?>
                </select>
                <input type="radio" name="value" value="1"/>Enable
                <input type="radio" name="value" value="0" checked="checked"/>Disable<br />
                <input type="hidden" name="table" value="blocks"/>
                <input type="hidden" name="view" value="handleRequest"/>
                <input type="hidden" name="args" value="operation:UPDATE|table:blocks|field:is_enabled|where:name"/>
                <input type="submit" value="Go" onclick="this.disabled=true;this.form.submit();"/>
            </form>
            <p>&nbsp;</p>
        </div>
        <div id="conf" name="options" class="box option" style="display:none;">
            <h3>You can edit some key $_CONF options.</h3>
            <form id="config-operator" method="POST" action="<?php print $self.'?view=updateConfigs'; ?>"/>
                <?php
                    foreach ($configs as $config){
                        $sql = "SELECT value FROM {$_TABLES['conf_values']} WHERE name ='{$config}' LIMIT 1";
                        $res = DB_query($sql);
                        $row = DB_fetchArray($res);
                ?>
                        <fieldset><legend><?php print $config; ?>:</legend><input type="text" size="80" id="<?php print $config; ?>" name="<?php print $config; ?>" value="<?php print unserialize($row['value']); ?>"/></fieldset>
                <?php
                    }
                ?>
                <input type="submit" value="Go" onclick="this.disabled=true;this.form.submit();"/>
            </form>
            <p>&nbsp;</p>
        </div>
        <div id="pass" name="options" class="box option" style="display:none;">
            <h3>Here you can reset your geeklog root/admin password.</h3>
            <form id="config-operator" method="POST" action="<?php print $self.'?view=updateEmail'; ?>"/>
                <input type="submit" value="Email my password" onclick="this.disabled=true;this.form.submit();"/>
            </form>
            <p>&nbsp;</p>
        </div>
        <?php endif; ?>
        <div class="box important">
            <p>Do not forget to <b>delete this <?php print $self; ?> file and the install directory once you are done!</b>
                If other users guess the password, they can seriously harm your geeklog installation!
             <p>
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
        margin: 16px 16px 0px 16px;
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
        margin: 0px auto;
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
    //The following does not work correctly in IE and I don't care!
    function toggle(objId){
        var o = document.getElementById(objId);
        if (o.style.display == 'none') {
            o.style.display = 'block';
        }
        else {
            o.style.display = 'none';
        }
        //IE does not support getElementsByName for <div>
        var others = document.getElementsByName('options');
        for (var i = 0; i < others.length; i++) {
            if (others[i] != o) {
                others[i].style.display = 'none';
            }
        }
    }

    //The following does not work in IE and I don't care!
    function toggleRadio(checked, elements){
        var radios = elements;
        if (checked) {
            radios[0].click();
        }
        else {
            radios[1].click();
        }
    }
</script>
<?php
}
?>
