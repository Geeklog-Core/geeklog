<?php

require_once('lib-common.php');

$display = COM_siteHeader('menu');
$display .= COM_startBlock($LANG_404[1]);
$display .= $LANG_404[2];
$display .= $LANG_404[3];
$display .= COM_endBlock();
$display .= COM_siteFooter();

echo $display

?>
