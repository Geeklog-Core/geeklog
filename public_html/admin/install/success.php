<?php 

include_once('../../lib-common.php');

$display = COM_siteHeader();
if (DB_count($_TABLES['users'],'username','NewAdmin') > 0) {
    $display .= "Installation of Geeklog $VERSION complete! Because the security model has been changed, we have created a new account with the rights you need to administer your new site.  The username for this new account is <b>NewAdmin</b> and the password is <b>password</b>. Click <a href={$_CONF['site_url']}>here</a> to see your new Geeklog site! <font color=\"red\"><P><b>WARNING:</b></font>Before you do anything else you need to make sure that {$_CONF['path_html']}admin/install/install.php can not be executed by the webserver otherwise someone could do damage to your new Geeklog installation.  Either change the file permissions so it can't be executed OR move the file someplace outside your web tree.";
} else {
    $display .= "Installation of Geeklog $VERSION complete! Click <a href=\"{$_CONF['site_url']}\">here</a> to see your new Geeklog site! <font color=\"red\"><P><b>WARNING:</b></font>Before you do anything else you need to make sure that {$_CONF['path_html']}admin/install/install.php can not be executed by the webserver otherwise someone could do damage to your new Geeklog installation.  Either change the file permissions so it can't be executed OR move the file someplace outside your web tree.";
}
$display .= "<P><B>NOTE:</B> As of Geeklog 1.3.5, we include the Static Pages Plug-in for Geeklog by default.  If you just completed a fresh installation, you don't need to do anything to start using the Static Pages Plug-in.  If you just upgraded Geeklog, you can activate the Static Pages Plug-in by going <a href=\"{$_CONF['site_admin_url']}/plugins/staticpages/install.php\">here</a>. If you do not want to use this plugin you can disable it from the plugin administration page OR you can follow the directions in /path/to/geeklog/plugins/staticpages/INSTALL";
$display .= COM_siteFooter();

echo $display;

?>
