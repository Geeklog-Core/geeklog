<?php

$_SP_CONF['version'] = '1.4';

// If you don't plan on using PHP code in static pages, you should set this
// to 0, thus disabling the execution of PHP.

$_SP_CONF['allow_php'] = 1;


// If you have more than one static page that is to be displayed in Geeklog's 
// center area, you can specify how to sort them:

$_SP_CONF['sort_by'] = 'id'; // can be 'id', 'title', 'date'


// When a user is deleted, ownership of static pages created by that user can
// be transfered to a user in the Root group (= 0) or the pages can be
// deleted (= 1).
$_SP_CONF['delete_pages'] = 0;


// Static pages can optionally be wrapped in a block. This setting defines
// the default for that option (1 = wrap in a block, 0 = don't).
$_SP_CONF['in_block'] = 1;


// If you experience timeout issues, you may need to set both of the
// following values to 0 as they are intensive

// NOTE: using filter_html will render any blank pages useless
$_SP_CONF['filter_html'] = 0;
$_SP_CONF['censor'] = 1;

?>
