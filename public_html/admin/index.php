<?php

###############################################################################
# /admin/index.php
# This is the admin index page that does nothing more that login you in.
#
# Copyright (C) 2000 Jason Whittenburg
# jwhitten@securitygeeks.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
###############################################################################

include("../common.php");
include("../custom_code.php");
include("auth.inc.php");

###############################################################################
# MAIN

if ($mode=="logout") {
	$tmp = $HTTP_COOKIE_VARS["gl_loginname"] . " logged out.";
	accesslog($tmp);
	setcookie("gl_loginname","",0,"/","",0);
	setcookie("gl_password","",0,"/","",0);
	refresh("{$CONF["site_url"]}/index.php");
}
refresh("{$CONF["site_url"]}/admin/moderation.php");

?>
