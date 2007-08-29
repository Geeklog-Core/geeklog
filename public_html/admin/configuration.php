<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.4                                                               |
// +---------------------------------------------------------------------------+
// | configuration.php                                                         |
// |                                                                           |
// | Loads the administration UI and sends input to config.class               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2007 by the following authors:                              |
// |                                                                           |
// | Authors: Aaron Blankstein                  kantai@gmail.com               |
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
//

require_once('../lib-common.php');

$config = config::create(array_key_exists('conf_group', $_POST) ? 
			 $_POST['conf_group'] : 'Core');

if(array_key_exists('set_action', $_POST)){
    if (SEC_inGroup('Root')) {
        if($_POST['set_action'] == 'restore')
            $config->restore_param($_POST['name']);
        else if($_POST['set_action'] == 'unset')
            $config->unset_param($_POST['name']);
    }
}

if(array_key_exists('form_submit', $_POST)){
  $result = null;
  if(! array_key_exists('form_reset', $_POST))
    $result = $config->updateConfig($_POST);
  print $config->get_ui($_POST['sub_group'], $result );
}else{
  print $config->get_ui(array_key_exists('subgroup', $_POST) ?
                        $_POST['subgroup'] : null);
}
?>