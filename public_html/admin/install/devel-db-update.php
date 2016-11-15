<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog                                                                   |
// +---------------------------------------------------------------------------+
// | devel-db-update.php                                                       |
// |                                                                           |
// | Geeklog Developer Database update page.                                   |
// | Based in part on the glFusion Development SQL Updates.                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 20016 by the following authors:                             |
// |                                                                           |
// | Authors: Tom Homer        - tomhomer AT esilverstrike DOT com             |
// |          Mark R. Evans    - mark AT glfusion DOT org                      |
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

require_once '../../lib-common.php';

// For Root users only
if (!SEC_inGroup('Root')) {
    $display .= COM_showMessageText($MESSAGE[29], $MESSAGE[30]);
    $display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[30]));
    COM_errorLog("Someone has tried to access the Geeklog Development Database Upgrade Routine without proper permissions.  User id: {$_USER['uid']}, Username: {$_USER['username']}, IP: " . $_SERVER['REMOTE_ADDR'],1);
    COM_output($display);
    exit;
}


function update_DatabaseFor212()
{
    global $_TABLES, $_CONF, $_PLUGINS, $use_innodb, $_DB_table_prefix, $gl_devel_version;

    // ***************************************     
    // Add database Geeklog Core updates here. 
    // NOTE: Cannot use ones found in normal upgrade script as no checks are performed to see if already done.
    
    // Modify DATETIME columns with '0000-00-00 00:00:00' being the default value to DATETIME DEFAULT NULL
    // to make Geeklog compatible with MySQL-5.7 with NO_ZERO_DATE in sql_mode
    $_SQL[] = "ALTER TABLE {$_TABLES['blocks']} MODIFY COLUMN `rdfupdated` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['stories']} MODIFY COLUMN `comment_expire` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['stories']} MODIFY COLUMN `expire` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['syndication']} MODIFY COLUMN `updated` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['users']} MODIFY COLUMN `regdate` DATETIME DEFAULT NULL";

    // Add device type to blocks table
    $_SQL[] = "ALTER TABLE {$_TABLES['blocks']} ADD `device` VARCHAR( 15 ) NOT NULL DEFAULT 'all' AFTER `blockorder`";

    // Check for language group
    $result = DB_query("SELECT * FROM {$_TABLES['groups']} WHERE grp_name='Language Admin'");
    if ( DB_numRows($result) == 0 ) {
        // Add `language_items` table
        $_SQL[] = "
        CREATE TABLE IF NOT EXISTS {$_TABLES['language_items']} (
          id INT(11) NOT NULL AUTO_INCREMENT,
          var_name VARCHAR(30) NOT NULL,
          language VARCHAR(30) NOT NULL,
          name VARCHAR(30) NOT NULL,
          value VARCHAR(255) NOT NULL DEFAULT '',
          PRIMARY KEY (id)
        ) ENGINE=MyISAM
        ";
    
        // Add `Language Admin` group
        $_SQL[] = "INSERT INTO {$_TABLES['groups']} (grp_id, grp_name, grp_descr, grp_gl_core) VALUES (18, 'Language Admin', 'Has full access to language', 1);";

        // Add `language.edit` feature
        $_SQL[] = "INSERT INTO {$_TABLES['features']} (ft_id, ft_name, ft_descr, ft_gl_core) VALUES (68, 'language.edit', 'Can manage Language Settings', 1)";

        // Give `language.edit` feature to `Language Admin` group
        $_SQL[] = "INSERT INTO {$_TABLES['access']} (acc_ft_id, acc_grp_id) VALUES (68,18) ";
    }

    // Check for language group
    $result = DB_query("SELECT * FROM {$_TABLES['group_assignments']} WHERE ug_main_grp_id = 18 AND ug_grp_id = 1");
    if ( DB_numRows($result) == 0 ) {
        // Add Root users to `Language Admin`
        $_SQL[] = "INSERT INTO {$_TABLES['group_assignments']} (ug_main_grp_id, ug_uid, ug_grp_id) VALUES (18,NULL,1) ";

        // Add 'Routes' table
        $_SQL[] = "CREATE TABLE IF NOT EXISTS {$_TABLES['routes']} (
            rid INT(11) NOT NULL AUTO_INCREMENT,
            method INT(11) NOT NULL DEFAULT 1,
            rule VARCHAR(255) NOT NULL DEFAULT '',
            route VARCHAR(255) NOT NULL DEFAULT '',
            priority INT(11) NOT NULL DEFAULT 100,
            PRIMARY KEY (rid)
        ) ENGINE=MyISAM
        ";

        // Add sample routes
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid/print', '/article.php?story=@sid&mode=print', 100)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/article/@sid', '/article.php?story=@sid', 110)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/archives/@topic/@year/@month', '/directory.php?topic=@topic&year=@year&month=@month', 120)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/page/@page', '/staticpages/index.php?page=@page', 130)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/links/portal/@item', '/links/portal.php?what=link&item=@item', 140)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/links/category/@cat', '/links/index.php?category=@cat', 150)";
        $_SQL[] = "INSERT INTO {$_TABLES['routes']} (method, rule, route, priority) VALUES (1, '/topic/@topic', '/index.php?topic=@topic', 160)";
    }

    // Change Topic Id (and Name) from 128 to 75 since we have an issue with the primary key on the topic_assignments table since it has too many bytes for tables with a utf8mb4 collation
    $_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE `tid` `tid` VARCHAR(75) NOT NULL default ''";
    $_SQL[] = "ALTER TABLE {$_TABLES['topics']} CHANGE `topic` `topic` VARCHAR(75) NOT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['topic_assignments']} CHANGE `tid` `tid` VARCHAR(75) NOT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['sessions']} CHANGE `topic` `topic` VARCHAR(75) NOT NULL default ''";
    $_SQL[] = "ALTER TABLE {$_TABLES['syndication']} CHANGE `topic` `topic` VARCHAR(75) NOT NULL default '::all'";
    $_SQL[] = "ALTER TABLE {$_TABLES['syndication']} CHANGE `header_tid` `header_tid` VARCHAR(75) NOT NULL default 'none'";

    // Change Url from 255 to 250 since the field has too many bytes for tables with a utf8mb4 collation
    $_SQL[] = "ALTER TABLE {$_TABLES['trackback']} CHANGE `url` `url` VARCHAR(250) DEFAULT NULL";

    
    // ***************************************     
    // Core Plugin Updates Here
    
    // Staticpages
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} MODIFY COLUMN `created` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} MODIFY COLUMN `modified` DATETIME DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD `sp_onhits` TINYINT NOT NULL DEFAULT '1' AFTER `sp_onmenu`"; 
    $_SQL[] = "ALTER TABLE {$_TABLES['staticpage']} ADD `sp_onlastupdate` TINYINT NOT NULL DEFAULT '1' AFTER `sp_onhits`";
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.6.8', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='staticpages'";
    
    // SpamX
    $_SQL[] = "ALTER TABLE {$_TABLES['spamx']} MODIFY COLUMN regdate DATETIME DEFAULT NULL";
    $_SQL[] = "DROP INDEX `primary` ON {$_TABLES['spamx']}";
    $_SQL[] = "DROP INDEX `spamx_name` ON {$_TABLES['spamx']}";
    $_SQL[] = "ALTER TABLE {$_TABLES['spamx']} ADD PRIMARY KEY (name)";    
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.3.3', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='spamx'";
    
    // Links
    // $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.1.4', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='links'";
    
    // Polls
    $_SQL[] = "ALTER TABLE {$_TABLES['pollquestions']} ADD `allow_multipleanswers` TINYINT(1) NULL DEFAULT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['pollquestions']} ADD `description` MEDIUMTEXT NULL";
    $_SQL[] = "ALTER TABLE {$_TABLES['polltopics']} ADD `description` MEDIUMTEXT NULL";    
    $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.1.7', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='polls'";
    
    // Calendar
    // $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='1.1.5', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='calendar'";
    
    // XMLSiteMap
    // $_SQL[] = "UPDATE {$_TABLES['plugins']} SET pi_version='2.0.0', pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='xmlsitemap'";


    if ($use_innodb) {
        $statements = count($_SQL);
        for ($i = 0; $i < $statements; $i++) {
            $_SQL[$i] = str_replace('MyISAM', 'InnoDB', $_SQL[$i]);
        }
    }

    foreach ($_SQL as $sql) {
        DB_query($sql,1);
    }

    // update Geeklog version number
    DB_query("INSERT INTO {$_TABLES['vars']} SET value='$gl_devel_version',name='geeklog'",1);
    DB_query("UPDATE {$_TABLES['vars']} SET value='$gl_devel_version' WHERE name='geeklog'",1);
    
    return true;
}

$display = '<h2>Development Database Update</h2>';

$gl_old_version = "2.1.1";
$gl_devel_version = "2.1.2";
$short_version = str_replace(".","", $gl_devel_version);

$display .= "<p>Update is for Geeklog Core and Core Plugins. Can include changes to database structure and data, along with configuration options.</p> 
             <p>Update works for Geeklog $gl_old_version up to latest Geeklog development version for $gl_devel_version.</p>";


// ***************************************             
// Geeklog Core Updates
$display .= '<ul><li>Performing Geeklog Core configuration upgrades if necessary...<ul><li>';

require_once($_CONF['path'] . 'sql/updates/' . $_DB_dbms . '_' . $gl_old_version . '_to_' . $gl_devel_version . '.php');
$function = 'update_ConfValuesFor' . $short_version;
if (function_exists($function)) {
    if ($function()) {;
        $display .= 'Configuration settings updated successfully.';
    } else {
        $display .= 'There was problems updating the configuration settings.';
    }
} else {
    $display .= 'No configuration settings found to updated.';
}
$display .= '</li></ul>';

// Reset rest of config
//resetConfig();

// ***************************************
// Geeklog Core Plugins
$display .= '<li>Performing Geeklog Core Plugin configuration upgrades if necessary...<ul>';
// Loop through core plugin config updates
$corePlugins = array('staticpages','spamx','links','polls','calendar', 'xmlsitemap');
foreach ($corePlugins AS $pi_name) {
    $new_plugin_version = false;
    switch ($pi_name) {
        case 'staticpages':
            $new_plugin_version = true;
            $plugin_version = '1.6.8';
            break;
        case 'spamx':
            $new_plugin_version = true;
            $plugin_version = '1.3.3';
            break;
        case 'links':
            $plugin_version = '2.1.4';
            break;
        case 'polls':
            $new_plugin_version = true;
            $plugin_version = '2.1.7';
            break;
        case 'calendar':
            $plugin_version = '1.1.5';
            break;
        case 'xmlsitemap':
            $plugin_version = '2.0.0';
            break;
    }
    
    $display .= "<li>";
    if ($new_plugin_version) {
        require_once $_CONF['path'] . 'plugins/' . $pi_name . '/install_updates.php';

        $function = $pi_name . '_update_ConfValues_' . str_replace(".","_", $plugin_version);
        
        if (function_exists($function)) {
            if ($function()) {;
                $display .= "Configuration settings updated successfully for $pi_name plugin.";
            } else {
                $display .= "There was problems updating the configuration settings for $pi_name plugin.";
            }
        } else {
            $display .= "No configuration settings found for updating $pi_name plugin.";
        }
    } else {
        $display .= "No new version found for $pi_name plugin.";    
    }
    $display .= "</li>";
}
$display .= "</ul></li>";

$display .= '<li>Performing Geeklog Core and Geeklog Core Plugin database upgrades if necessary...<ul><li>';

// InnoDB?
$use_innodb = false;
if (($_DB_dbms == 'mysql') && (DB_getItem($_TABLES['vars'], 'value', "name = 'database_engine'") == 'InnoDB')) {
    $use_innodb = true;
}

$function = 'update_DatabaseFor' . $short_version;
if (function_exists($function)) {
    if ($function()) {;
        $display .= 'Database updated successfully.';
    } else {
        $display .= 'There was problems updating the database settings.';
    }
} else {
    $display .= 'No database settings found to updated.';
}
$display .= "</li></ul></li></ul>";

foreach ($corePlugins AS $pi_name) {
    DB_query("UPDATE {$_TABLES['plugins']} SET pi_gl_version='". VERSION ."', pi_homepage='https://www.geeklog.net' WHERE pi_name='".$pi_name."'",1);
}

// ***************************************
// need to clear the template cache so do it here
CTL_clearCache();

$display .= '<p>The Geeklog Core Development Database Update has completed.</p>
             <p>Please visit the <a href="' . $_CONF['site_admin_url'] . '/plugins.php">Plugin Admin page</a> and validate if any other plugins needs to be updated.</p>';

$display = COM_createHTMLDocument($display, array('pagetitle' => $MESSAGE[40]));
COM_output($display);

exit;
?>