<?php 

include_once('../../lib-common.php');

$display = COM_siteHeader();
if (DB_count($_TABLES['users'],'username','NewAdmin') > 0) {
    $display .= "Installation of Geeklog $VERSION complete! Because the security model has been changed, we have created a new account with the rights you need to administer your new site.  The username for this new account is <b>NewAdmin</b> and the password is <b>password</b>. Click <a href={$_CONF['site_url']}>here</a> to see your new Geeklog site! <font color=\"red\"><b>WARNING:</b></font>Before you do anything else you need to make sure that {$_CONF['path_html']}admin/install/install.php can not be executed by the webserver otherwise someone could do damage to your new Geeklog installation.  Either change the file permissions so it can't be executed OR move the file someplace outside your web tree.";
} else {
    $display .= "Installation of Geeklog $VERSION complete! Click <a href=\"{$_CONF['site_url']}\">here</a> to see your new Geeklog site! <font color=\"red\"><b>WARNING:</b></font>Before you do anything else you need to make sure that {$_CONF['path_html']}admin/install/install.php can not be executed by the webserver otherwise someone could do damage to your new Geeklog installation.  Either change the file permissions so it can't be executed OR move the file someplace outside your web tree.";
}
$display .= COM_siteFooter();

echo $display;

?>
