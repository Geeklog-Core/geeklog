<?php

require_once('lib-common.php');

$display = COM_siteHeader('menu');
$display .= COM_startBlock('404 Error');
$display .= "Gee, I've looked everywhere but I can not find <b>http://{$HTTP_SERVER_VARS["HTTP_HOST"]}{$HTTP_SERVER_VARS["REQUEST_URI"]}</b>.";
$display .= "<p>We're sorry, but the file you have requested does not exist. Please feel free to check the <a href={$_CONF['site_url']}>main page</a> or the <a href={$_CONF['site_url']}/search.php>search page</a> to see if you can find what you lost.";
$display .= COM_endBlock();
$display .= COM_siteFooter();

echo $display

?>
