<?php

// Allows plugin to add extra css and javascript libraries for individual themes.
// Theme settings will overwrite any plugin settimgs that are the same name/file


// this file can't be used on its own (keep this in as plugin template files could be located with theme) 
if (strpos(strtolower($_SERVER['PHP_SELF']), 'functions.php') !== false) {
    die('This file can not be used on its own!');
}


/**
 * Return an array of CSS files to be loaded
 */
function polls_css_denim()
{
    global $_CONF, $LANG_DIRECTION;

    $direction = ($LANG_DIRECTION == 'rtl') ? '_rtl' : '';

    // The only extra thing that the plugin needs from uikit is the progress bar for displaying results 
    return array(
        array(
            'name'       => 'uikit-progress',
            'file'       => '/vendor/uikit/css' . $direction . '/components/progress.gradient.min.css',
            'attributes' => array('media' => 'all'),
            'priority'   => 70
        )

    );
}

/**
 * Return an array of JS libraries to be loaded
 */
function polls_js_libs_denim()
{
    // No extra JS libraries needed by plugin. Assume theme loads all required.
    return array();
}

/**
 * Return an array of JS files to be loaded
 */
function polls_js_files_denim()
{
    // No extra JS files needed by plugin. Assume theme loads all required.
    return array();
}

?>
