<?php
###############################################################################
# links.php
# This is the link resource script!
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
include('lib-common.php');
###############################################################################
# MAIN
$display .= site_header()
	.startblock($LANG06[1])
	.'[ <a href="'.$CONF['site_url'].'/submit.php?type=link">'.$LANG06[3].'</a> ]';
	
$result = dbquery("SELECT * from links ORDER BY category asc,title");
$nrows = mysql_num_rows($result);
if ($nrows==0) {
	$display .= $LANG06[2].'<br>';
} else {
	for($i=0;$i<$nrows;$i++) {
		$A	= mysql_fetch_array($result);
		if (hasaccess($A['owner_id'],$A['group_id'],$A['perm_owner'],$A['perm_group'],$A['perm_members'],$A['perm_anon']) > 0) {
			if ($A['category']!=$currentcat) {
				$display .= sprintf("<h3>%s</h3>\n<ul>",$A['category']);
			}
			$display .= '<li><b><a target="_new" '
				.sprintf("href=\"{$CONF['site_url']}/portal.php?url=%s&what=link&item=%s\">%s</a></b> (%s)"
				,urlencode($A['url']),$A['lid'],$A['title'],$A['hits'])
				.'<br>'.stripslashes($A['description']).'</li>'.LB;
				
			$currentcat	= $A['category'];
/*
			print "<b><a target=_new ";
			printf("href={$CONF["site_url"]}/portal.php?url=%s&what=link&item=%s>%s</a></b> (%s)",
			urlencode($A["url"]),$A["lid"],$A["title"],$A["hits"]);
			print "<br>" . stripslashes($A["description"]) . "<br><br>\n";
*/
		}
	} 
	$display .= '</ul>'.LB;
}
$display .= '<br>'
	.endblock()
	.site_footer();
echo $display;
?>
