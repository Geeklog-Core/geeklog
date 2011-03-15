<?php

// this file can't be used on its own
if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.php') !== false) {
    die('This file can not be used on its own!');
}

$_IMAGE_TYPE = 'png';

$_SCRIPTS->setJavaScriptFile('theme.confirm', '/layout/' . $_CONF['theme'] . '/javascript/confirm.js');
$_SCRIPTS->setJavaScriptFile('theme.fix_html', '/layout/' . $_CONF['theme'] . '/javascript/fix_html.js');

/*
 * For left/right block support there is no longer any need for the theme to
 * put code into functions.php to set specific templates for the left/right
 * versions of blocks. Instead, Geeklog will automagically look for
 * blocktemplate-left.thtml and blocktemplate-right.thtml if given
 * blocktemplate.thtml from $_BLOCK_TEMPLATE. So, if you want different left
 * and right templates from admin_block, just create blockheader-list-left.thtml
 * etc.
 */

$_BLOCK_TEMPLATE['_msg_block'] = 'blockheader-message.thtml,blockfooter-message.thtml';
$_BLOCK_TEMPLATE['configmanager_block'] = 'blockheader-config.thtml,blockfooter-config.thtml';
$_BLOCK_TEMPLATE['configmanager_subblock'] = 'blockheader-config.thtml,blockfooter-config.thtml';
$_BLOCK_TEMPLATE['whats_related_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';
$_BLOCK_TEMPLATE['story_options_block'] = 'blockheader-related.thtml,blockfooter-related.thtml';

// Define the blocks that are a list of links styled as an unordered list - using class="blocklist"
$_BLOCK_TEMPLATE['admin_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
$_BLOCK_TEMPLATE['section_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';

if (!COM_isAnonUser()) {
    $_BLOCK_TEMPLATE['user_block'] = 'blockheader-list.thtml,blockfooter-list.thtml';
}

?>
