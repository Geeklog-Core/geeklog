<?php
// Standalone regression test: php tests/mail-footer-1181.php
// No database, SMTP server or real email delivery is required.
class Mail
{
    public static $args;
    public static function send()
    {
        self::$args = func_get_args();
        return true;
    }
}
class FooterTemplate
{
    public $preprocess_fn;
    public function set_file($files) {}
    public function set_var($name, $value) {}
    public function parse($output, $name)
    {
        return $name === 'email_html' ? '[HTML FOOTER]' : '[TEXT FOOTER]';
    }
}
function COM_newTemplate($path) {
    $GLOBALS['templates']++;
    return new FooterTemplate();
}
function CTL_core_templatePath($path) { return $path; }
function DB_getItem($table, $field, $where) { return $GLOBALS['accountStatus']; }
function COM_isDemoMode() { return false; }
define('LB', "\n");
define('USER_ACCOUNT_DISABLED', 0);
define('USER_ACCOUNT_LOCKED', 2);
define('USER_ACCOUNT_NEW_EMAIL', 3);

$source = file_get_contents(__DIR__ . '/../public_html/lib-common.php');
$start = strpos($source, 'function COM_mail(');
$end = strpos($source, "\n/**", $start);
if ($start === false || $end === false) {
    throw new RuntimeException('COM_mail not found');
}
eval(substr($source, $start, $end - $start));

$_CONF = array('site_mail' => 'site@example.com', 'noreply_mail' => 'no-reply@example.com',
    'site_name' => 'Geeklog', 'path_layout' => '');
$_TABLES = array('users' => 'users');
$LANG31 = array('email_divider' => '', 'email_divider_html' => '',
    'email_footer_msg_noreply' => '', 'email_footer_msg_content' => '');
$LANG08 = array(34 => '');
$templates = 0;
$accountStatus = '';
$passed = 0;
function check($label, $condition)
{
    global $passed;
    if (!$condition) {
        throw new RuntimeException('FAIL: ' . $label);
    }
    ++$passed;
    echo 'OK: ' . $label . PHP_EOL;
}
$to = 'recipient@example.com';
COM_mail($to, 'Subject', 'Text');
check('Default plaintext footer', Mail::$args[2] === 'Text[TEXT FOOTER]');
COM_mail($to, 'Subject', 'HTML', '', true);
check('Default HTML footer', Mail::$args[2] === 'HTML[HTML FOOTER]');
COM_mail($to, 'Subject', array('HTML', 'Text'), '', true);
check('Default multipart footers', Mail::$args[2] === array('HTML[HTML FOOTER]', 'Text[TEXT FOOTER]'));
$before = $templates;
$headers = array('Reply-To' => 'visitor@example.com');
$attachments = array('example.txt');
COM_mail($to, 'Subject', 'Text', '', false, 1, $headers, $attachments, true);
check('Skip plaintext footer', Mail::$args[2] === 'Text');
check('Sender preserved', Mail::$args[3] === $_CONF['noreply_mail']);
check('Priority, headers and attachments preserved', Mail::$args[5] === 1 && Mail::$args[6] === $headers && Mail::$args[7] === $attachments);
COM_mail($to, 'Subject', 'HTML', '', true, 0, null, array(), true);
check('Skip HTML footer', Mail::$args[2] === 'HTML');
COM_mail($to, 'Subject', array('HTML', 'Text'), '', true, 0, null, array(), true);
check('Skip multipart footers', Mail::$args[2] === array('HTML', 'Text'));
check('No footer templates loaded when skipped', $templates === $before);
COM_mail($to, 'Subject', 'Text');
check('Footer restored for next message', Mail::$args[2] === 'Text[TEXT FOOTER]');
$_CONF['noreply_mail'] = $_CONF['site_mail'];
COM_mail($to, 'Subject', 'Text', '', false, 0, null, array(), true);
check('Site sender preserved', Mail::$args[3] === array($_CONF['site_mail'] => $_CONF['site_name']));
check('Invalid multipart rejected', COM_mail($to, 'Subject', array('HTML', 'Text')) === false);
$accountStatus = USER_ACCOUNT_LOCKED;
Mail::$args = null;
check('Locked account rejected', COM_mail($to, 'Subject', 'Text', '', false, 0, null, array(), true) === false && Mail::$args === null);
echo 'TOTAL: ' . $passed . '/13 checks passed' . PHP_EOL;
