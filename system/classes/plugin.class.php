<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.3                                                               |
// +---------------------------------------------------------------------------+
// | plugin.class.php                                                          |
// | Geeklog plugin class.                                                     |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000,2001 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs, tony@tonybibbs.com                                   |
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
// $Id: plugin.class.php,v 1.1 2001/11/07 23:34:58 tony_bibbs Exp $

class Plugin {

    // PRIVATE PROPERTIES

    // PUBLIC PROPERTIES
    var $adminlabel;
    var $adminurl;
    var $numsubmissions;

    // PUBLIC METHODS

    /**
    * Constructor
    *
    * This initializes the plugin
    *
    */
    function Plugin()
    {
        $this->reset();
    }

    /**
    * Resets the object
    *
    */
    function reset()
    {
        $adminlabel = '';
        $aadminurl = '';
        $numsubmissions = '';
    }

}

?>
