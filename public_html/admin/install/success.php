<?php 

include_once('../../lib-common.php');

$display = COM_siteHeader();
if (DB_count($_TABLES['users'],'username','NewAdmin') > 0) {
    $display .= "Installation of Geeklog $VERSION complete! Because the security model has been changed, we have created a new account with the rights you need to administer your new site.  The username for this new account is <b>NewAdmin</b> and the password is <b>password</b>. Click <a href={$_CONF['site_url']}>here</a> to see your new Geeklog site!";
} else {
    $display .= "Installation of Geeklog $VERSION complete! Click <a href={$_CONF['site_url']}>here</a> to see your new Geeklog site!";
}
$display .= COM_siteFooter();

echo $display;

?>
