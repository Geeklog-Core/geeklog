<?php

require_once ('lib-common.php');

$display = COM_siteHeader ('menu');
$display .= COM_startBlock ($LANG_404[1]);
if (isset ($HTTP_SERVER_VARS['SCRIPT_URI'])) {
    $url = strip_tags ($HTTP_SERVER_VARS['SCRIPT_URI']);
} else {
    $pos = strpos ($HTTP_SERVER_VARS['REQUEST_URI'], '?');
    if ($pos === false) {
        $request = $HTTP_SERVER_VARS['REQUEST_URI'];
    } else {
        $request = substr ($HTTP_SERVER_VARS['REQUEST_URI'], 0, $pos);
    }
    $url = 'http://' . $HTTP_SERVER_VARS['HTTP_HOST'] . strip_tags ($request);
}
$display .= sprintf ($LANG_404[2], $url);
$display .= $LANG_404[3];
$display .= COM_endBlock ();
$display .= COM_siteFooter ();

echo $display

?>
