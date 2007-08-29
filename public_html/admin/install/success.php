<?php

require_once ('../../lib-common.php');

$type = (isset( $_GET['type'] ) && !empty( $_GET['type'] )) ? $_GET['type'] : 'install';
$language = (isset( $_GET['language'] ) && !empty( $_GET['language'] )) ? $_GET['language'] : 'english';
require_once( 'language/' . $language . '.php' );
// enable detailed error reporting
$_CONF['rootdebug'] = true;

$display = COM_siteHeader( 'menu', $LANG_INSTALL[80] );
$display .= COM_startBlock( $LANG_INSTALL[81] . VERSION . $LANG_INSTALL[82] );

$display .= '<p>' . $LANG_INSTALL[83] . (($type == 'install') ? 'installed' : 'upgraded') . $LANG_INSTALL[84] . '</p>' ;

if ($type == 'install') {
	$display .= '<p>' . $LANG_INSTALL[85] . '</p>
    <p>' . $LANG_INSTALL[86] . ' <strong>' . $LANG_INSTALL[87] . '</strong><br />
    ' . $LANG_INSTALL[88] . ' <strong>' . $LANG_INSTALL[89] . '</strong></p> <br />';
}

$display .= '<h2>' . $LANG_INSTALL[90] . '</h2>
<p>' . $LANG_INSTALL[91] . ' <strong>' . (($type == 'upgrade') ? '2' : '3') . ' ' . $LANG_INSTALL[92] . '</strong>:
<ul>
<li>' . $LANG_INSTALL[93] . ' <tt>' . $_CONF['path_html'] . 'admin/install</tt>.</li>';


if ($type == 'install') {
    $display .= "<li><a href=\"{$_CONF['site_url']}/usersettings.php?mode=edit\">" . $LANG_INSTALL[94] . ' <strong>' . $LANG_INSTALL[87] . '</strong> ' . $LANG_INSTALL[95] . '</a></li>';
}

$display .= '<li>' . $LANG_INSTALL[96] . ' <tt>' . $_CONF['path'] . 'db-config.php</tt> ' . $LANG_INSTALL[97] . ' <tt>' . $_CONF['path_html'] . 'siteconfig.php</tt> ' . $LANG_INSTALL[98] . ' 755.</li>
</ul>
</p>';

// note for those upgrading from Geeklog 1.2.5-1 or older
if (DB_count ($_TABLES['users'], 'username', 'NewAdmin') > 0) {
    $display .= '<p>' . $LANG_INSTALL[99] . '</p>.';
}

$display .= COM_endBlock ();
$display .= COM_siteFooter ();

echo $display;

?>
