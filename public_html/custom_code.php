<?php
###############################################################################
# custom_code.php
#  
# This is the file where you should put all of your custom code.  When possible
# you should not alter common.php but, instead, put code here.  This will make
# upgrading to future versions of Geeklog easier for you because you will always
# be gauranteed that the Geeklog developers will add code to this file.
#
# Copyright (C) 2001  Tony Bibbs
# tony@tonybibbs.com
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

#this is a sample function used by a PHP block.  This will show the rights that 
#a user has in the "What you have access to" block.
function phpblock_showrights() {
	global $RIGHTS;

	for ($i=0;$i<count($RIGHTS);$i++) {
		print "<BR>{$RIGHTS[$i]}";
	}
}

?>
