<?php 

require_once ('../../lib-common.php');

// enable detailed error reporting
$_CONF['rootdebug'] = true;

$display = COM_siteHeader ('menu', 'Installation complete');
$display .= COM_startBlock ('Installation complete');
$display .= '<h2>Installation of Geeklog ' . VERSION . ' complete!</h2>';

$display .= '<p>Congratulations, you have successfully installed Geeklog. Please take a minute to read the information displayed below.</p>';

$display .= '<p>Then <a href="' . $_CONF['site_url'] . '">click here</a> to go to your site\'s front page and <b>learn about the default login</b>.</p>';

$display .= '<h2>Check Permissions</h2>';
$display .= '<p>Geeklog requires certain files and directories to be writable. To check if those are set up properly, please use <a href="check.php">this script</a>.</p>';

$display .= '<h2>Security Warning</h2>';
$display .= '<p>Once your site is up and running, don\'t forget to <strong>remove the install directory</strong>, <tt>' . $_CONF['path_html'] . 'admin/install</tt>, and <strong>change the password</strong> of the default \'Admin\' account.</p>';

// note for those upgrading from Geeklog 1.2.5-1 or older
if (DB_count ($_TABLES['users'], 'username', 'NewAdmin') > 0) {
    $display .= '<p><strong>Note:</strong> Because the security model has been changed, we have created a new account with the rights you need to administer your new site.  The username for this new account is <b>NewAdmin</b> and the password is <b>password</b></p>.';
}

$display .= COM_endBlock ();
$display .= COM_siteFooter ();

echo $display;

?>
