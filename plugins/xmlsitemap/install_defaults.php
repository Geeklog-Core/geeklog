<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 1.0                                                     |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009 by the following authors:                              |
// |                                                                           |
// | Authors: Kenji ITO         - geeklog AT mystral-kk DOT net                |
// |          Dirk Haun         - dirk AT haun-online DOT de                   |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is free software; you can redistribute it and/or             |
// | modify it under the terms of the GNU General Public License               |
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
// | GNU General Public License for more details.                              |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* Install data and defaults for the XMLSitemap plugin configuration
*
* @package XMLSitemap
*/

if (strpos(strtolower($_SERVER['PHP_SELF']), 'install_defaults.php') !== FALSE) {
    die('This file can not be used on its own!');
}

/**
* XMLSitemap default settings
*
* Initial Installation Defaults used when loading the online configuration
* records.  These settings are only used during the initial installation
* and not referenced any more once the plugin is installed
*/

global $_XMLSMAP_DEFAULT;
$_XMLSMAP_DEFAULT = array();

// XML sitemap names
$_XMLSMAP_DEFAULT['sitemap_file']        = 'sitemap.xml';
$_XMLSMAP_DEFAULT['mobile_sitemap_file'] = 'mobile_sitemap.xml';

// Content types
$_XMLSMAP_DEFAULT['types'] = array('article', 'calendar', 'polls', 'staticpages');

// Plugins to exclude from sitemap
$_XMLSMAP_DEFAULT['exclude'] = array('links');

// Priorities (must be between 0.0 and 1.0; default value is 0.5)
$_XMLSMAP_DEFAULT['priorities'] = array(
    'article'     => 0.5,
    'calendar'    => 0.5,
    'polls'       => 0.5,
    'staticpages' => 0.5
);

// Frequencies (must be one of 'always', 'hourly', 'daily', 'weekly',
// 'monthly', 'yearly', 'never')
$_XMLSMAP_DEFAULT['frequencies'] = array(
    'article'     => 'daily',
    'calendar'    => 'daily',
    'polls'       => 'daily',
    'staticpages' => 'weekly'
);

/**
* Initialize XMLSitemap plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist.  Initial values will be taken from $_XMLSMAP_DEFAULT.
*
* @return   boolean     TRUE: success; FALSE: an error occurred
*/
function plugin_initconfig_xmlsitemap()
{
    global $_XMLSMAP_DEFAULT;
    
    $me = 'xmlsitemap';
    
    $c = config::get_instance();
    if (!$c->group_exists($me)) {
        $c->add('sg_main', NULL, 'subgroup', 0, 0, NULL, 0, TRUE, $me, 0);
        $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, TRUE, $me, 0);
        $c->add('fs_main', NULL, 'fieldset', 0, 0, NULL, 0, TRUE, $me, 0);
        $c->add('sitemap_file', $_XMLSMAP_DEFAULT['sitemap_file'], 'text',
            0, 0, NULL, 10, TRUE, $me, 0);
        $c->add('mobile_sitemap_file', $_XMLSMAP_DEFAULT['mobile_sitemap_file'],
            'text', 0, 0, NULL, 20, FALSE, $me, 0);
        $c->add('types', $_XMLSMAP_DEFAULT['types'], '%text', 0, 0, NULL, 30,
            TRUE, $me, 0);
        $c->add('exclude', $_XMLSMAP_DEFAULT['exclude'], '%text', 0, 0, NULL,
            40, TRUE, $me, 0);
        
        // Priorities
        $c->add('tab_pri', NULL, 'tab', 0, 1, NULL, 0, TRUE, $me, 1);
        $c->add('fs_pri', NULL, 'fieldset', 0, 1, NULL, 0, TRUE, $me, 1);
        $c->add('priorities', $_XMLSMAP_DEFAULT['priorities'], '*text', 0, 1,
             NULL, 50, TRUE, $me, 1);
        
        // Frequencies
        $c->add('tab_freq', NULL, 'tab', 0, 2, NULL, 0, TRUE, $me, 2);
        $c->add('fs_freq', NULL, 'fieldset', 0, 2, NULL, 0, TRUE, $me, 2);
        $c->add('frequencies', $_XMLSMAP_DEFAULT['frequencies'], '@select', 0,
            2, 20, 60, TRUE, $me, 2);
    }
    
    return TRUE;
}

?>
