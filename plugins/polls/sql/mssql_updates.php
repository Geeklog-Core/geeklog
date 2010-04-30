<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Polls Plugin 2.1                                                          |
// +---------------------------------------------------------------------------+
// | mssql_updates.php                                                         |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2008-2010 by the following authors:                         |
// |                                                                           |
// | Authors: Dirk Haun         - dirk AT haun-online DOT de                   |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+

/**
* MS SQL updates
*
* @package Polls
*/

$_UPDATES = array(

    '2.1.0' => array(
        // These pid changes should have happened when upgrading from 2.0.2
        // to 2.1.0 but were previously listed for an upgrade from 2.0.1 and
        // therefore may have not been applied. Apply again to be sure.
        "ALTER TABLE {$_TABLES['pollanswers']} ALTER COLUMN [pid] VARCHAR(40)",
        "ALTER TABLE {$_TABLES['pollquestions']} ALTER COLUMN [pid] VARCHAR(40)",
        "ALTER TABLE {$_TABLES['polltopics']} ALTER COLUMN [pid] VARCHAR(40)",
        "ALTER TABLE {$_TABLES['pollvoters']} ALTER COLUMN [pid] VARCHAR(40)",

        // New field post-2.1.0
        "ALTER TABLE {$_TABLES['polltopics']} ADD meta_description [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL AFTER topic, ADD meta_keywords [meta_keywords] [varchar] (5000) COLLATE SQL_Latin1_General_CP1_CI_AS NULL AFTER meta_description"
    ),

    '2.1.1' => array(
        // make room to store IPv6 addresses
        "ALTER TABLE {$_TABLES['pollvoters']} ALTER COLUMN [ipaddress] VARCHAR(39) NOT NULL",

        "EXEC sp_rename '{$_TABLES['polltopics']}.date', 'created', 'COLUMN'",
        "ALTER TABLE {$_TABLES['polltopics']} ADD modified [datetime] NULL AFTER created",
        "UPDATE {$_TABLES['polltopics']} SET modified = created"        
    )

);

function update_ConfValues_2_1_0()
{
    global $_CONF, $_PO_DEFAULT;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $_CONF['path'] . 'plugins/polls/install_defaults.php';

    $c = config::get_instance();
    
    // meta tag config options.
    $c->add('meta_tags', $_PO_DEFAULT['meta_tags'], 'select', 0, 0, 0, 100, true, 'polls');

    return true;
}

function update_ConfValues_2_1_1()
{
    global $_CONF, $_PO_DEFAULT, $_PO_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';
    require_once $_CONF['path'] . 'plugins/polls/install_defaults.php';
    
    $c = config::get_instance();

    // What's New Block    
    $c->add('fs_whatsnew', NULL, 'fieldset',
            0, 1, NULL, 0, true, 'polls');
    $c->add('newpollsinterval',$_PO_DEFAULT['new_polls_interval'],'text',
            0, 1, NULL, 10, TRUE, 'polls');
    $c->add('hidenewpolls',$_PO_DEFAULT['hide_new_polls'],'select',
            0, 1, 5, 20, TRUE, 'polls');
    $c->add('title_trim_length',$_PO_DEFAULT['title_trim_length'],'text',
            0, 1, NULL, 30, TRUE, 'polls');

    // Permissions (needed to redefine order on configuration form)
    $c->del('fs_permissions','polls');
    $c->del('default_permissions','polls');
    
    $c->add('fs_permissions', NULL, 'fieldset', 
            0, 2, NULL, 0, true, 'polls');
    $c->add('default_permissions', $_PO_CONF['default_permissions'], '@select', 
            0, 2, 12, 100, true, 'polls');    

    return true;
}

?>
