<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | XMLSitemap Plugin 2.0                                                     |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2009-2014 by the following authors:                         |
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

if (stripos($_SERVER['PHP_SELF'], 'install_defaults.php') !== false) {
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

// Content types to include lastmod element for (last modification date)
$_XMLSMAP_DEFAULT['lastmod'] = array('article', 'calendar', 'polls', 'staticpages');

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

// Ping targets
$_XMLSMAP_DEFAULT['ping_google'] = true;
$_XMLSMAP_DEFAULT['ping_bing']   = true;
$_XMLSMAP_DEFAULT['ping_ask']    = true;

/**
* Initialize XMLSitemap plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist.  Initial values will be taken from $_XMLSMAP_DEFAULT.
*
* @return   boolean     true: success; false: an error occurred
*/
function plugin_initconfig_xmlsitemap()
{
    global $_XMLSMAP_DEFAULT;

    $me = 'xmlsitemap';
    $c = config::get_instance();

    if (!$c->group_exists($me)) {
        $c->add('sg_main', null, 'subgroup', 0, 0, null, 0, true, $me, 0);
        $c->add('tab_main', null, 'tab', 0, 0, null, 0, true, $me, 0);
        $c->add('fs_main', null, 'fieldset', 0, 0, null, 0, true, $me, 0);
        $c->add('sitemap_file', $_XMLSMAP_DEFAULT['sitemap_file'], 'text',
            0, 0, null, 10, true, $me, 0);
        $c->add('mobile_sitemap_file', $_XMLSMAP_DEFAULT['mobile_sitemap_file'],
            'text', 0, 0, null, 20, false, $me, 0);
        $c->add('types', $_XMLSMAP_DEFAULT['types'], '%text', 0, 0, null, 30,
            true, $me, 0);
        $c->add('exclude', $_XMLSMAP_DEFAULT['exclude'], '%text', 0, 0, null,
            40, true, $me, 0);
        $c->add('lastmod', $_XMLSMAP_DEFAULT['lastmod'], '%text', 0, 0, null,
            50, true, $me, 0);        

        // Priorities
        $c->add('tab_pri', null, 'tab', 0, 1, null, 0, true, $me, 1);
        $c->add('fs_pri', null, 'fieldset', 0, 1, null, 0, true, $me, 1);
        $c->add('priorities', $_XMLSMAP_DEFAULT['priorities'], '*text', 0, 1,
             null, 50, true, $me, 1);

        // Frequencies
        $c->add('tab_freq', null, 'tab', 0, 2, null, 0, true, $me, 2);
        $c->add('fs_freq', null, 'fieldset', 0, 2, null, 0, true, $me, 2);
        $c->add('frequencies', $_XMLSMAP_DEFAULT['frequencies'], '@select', 0,
            2, 20, 60, true, $me, 2);

        // Ping targets
        $c->add('tab_ping', null, 'tab', 0, 3, null, 0, true, $me, 3);
        $c->add('fs_ping', null, 'fieldset', 0, 3, null, 0, true, $me, 3);
        $c->add('ping_google', $_XMLSMAP_DEFAULT['ping_google'], 'select', 0,
            3, 1, 100, true, $me, 3);
        $c->add('ping_bing', $_XMLSMAP_DEFAULT['ping_bing'], 'select', 0,
            3, 1, 110, true, $me, 3);
    }

    return true;
}

?>
