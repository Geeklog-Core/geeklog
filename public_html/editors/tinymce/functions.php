<?php
// Geeklog Advanced Editor adapter. GPL-2.0-or-later.
if (stripos($_SERVER['PHP_SELF'], basename(__FILE__)) !== false) {
    die('This file can not be used on its own!');
}
function adveditor_config_tinymce()
{
    return array('name' => 'TinyMCE', 'file' => 'vendor/tinymce.min.js',
        'footer' => true, 'priority' => 200);
}
