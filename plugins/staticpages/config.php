<?php

$_SP_CONF['version'] = '1.3';

// If you have more than one static page that is to be displayed in Geeklog's 
// center area, you can specify how to sort them:

$_SP_CONF['sort_by'] = 'id'; // can be 'id', 'title', 'date'


// If you experience timeout issues, you may need to set both of the
// following values to 0 as they are intensive

// NOTE: using filter_html will render any blank pages useless
$_SP_CONF['filter_html'] = 0;
$_SP_CONF['censor'] = 1;

// set to 1 if static pages should be wrapped in a block
$_SP_CONF['in_block'] = 1;

?>
