<?php 

require_once('../../lib-common.php');

$display = COM_siteHeader();
$display .= "<h2>Installation of Geeklog $VERSION complete!</h2>";
if (DB_count($_TABLES['users'],'username','NewAdmin') > 0) {
    $display .= "Because the security model has been changed, we have created a new account with the rights you need to administer your new site.  The username for this new account is <b>NewAdmin</b> and the password is <b>password</b>. <a href=\"{$_CONF['site_url']}\">Click here</a> to see your new Geeklog site!";
} else {
    $display .= "<a href=\"{$_CONF['site_url']}\">Click here</a> to see your new Geeklog site!";
}
$display .= "<p><b><font color=\"red\">IMPORTANT:</font></b> Once you have your site up and running without any errors, do not forget to remove the install directory <b>{$_CONF['path_html']}admin/install</b>. Otherwise, malicious users could seriously damage your site.";
$display .= "<p><b>NOTE:</b> As of Geeklog 1.3.5, we include the Static Pages Plug-in for Geeklog by default.  If you just completed a fresh installation, you don't need to do anything to start using the Static Pages Plug-in.  If you just upgraded Geeklog, you can activate the Static Pages Plug-in by going <a href=\"{$_CONF['site_admin_url']}/plugins/staticpages/install.php\">here</a>. If you do not want to use this plugin you can disable it from the plugin administration page OR you can follow the directions in {$_CONF['path']}plugins/staticpages/README";
$display .= COM_siteFooter();

echo $display;

?>
