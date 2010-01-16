/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2009 by the following authors:                         |
// | Version 1.0    Date: Jun 24, 2006                                         |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for Account Profile Editor                           |
// |                                                                           |
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

// @param  string   selected    Name of div that has been selected
// @param  int      selindex    index id of the selected tab as in 1 - 7 used to set the selected tab
function showhideProfileEditorDiv(selected, selindex) {
    
    // Reset the current selected navbar tab
    var cnavbar = document.getElementById('current');
    if (cnavbar) cnavbar.id = '';

    // Cycle thru the navlist child elements - buiding an array of just the link items 
    var navbar = document.getElementById('navlist');
    var menuitems = new Array(7);
    var item = 0;
    for (var i=0 ;i < navbar.childNodes.length ; i++ ) {
        if (navbar.childNodes[i].nodeName.toLowerCase() == 'li') {
            menuitems[item] = navbar.childNodes[i];
            item++;
        }
    }
    // Now that I have just the link items I can set the selected tab using the passed selected Item number
    // Set the <a tag to have an id called 'current'
    var menuitem = menuitems[selindex];
    for (var j=0 ;j < menuitem.childNodes.length ; j++ ) {
        if (menuitem.childNodes[j].nodeName.toLowerCase() == 'a')  menuitem.childNodes[j].id = 'current';
    }
    
    // Reset or show all the main divs - editor tab sections
    // Object profilepanels defined in profile.thtml after page is generated
    for( var divid in profilepanels){  
        if (selected != divid) {
            document.getElementById(divid).style.display = 'none';
        } else {
            document.getElementById(divid).style.display = '';
        }
    }

    document.getElementById('pe_preview').style.display = 'none';

    if (selected != 'pe_preview') {
        document.getElementById('save_button').style.display = '';
    } else if (selected == 'pe_preview') {
        document.getElementById('pe_preview').style.display = '';
        document.getElementById('save_button').style.display = 'none';
    } else {
        document.getElementById('pe_preview').style.display = '';
        document.getElementById('save_button').style.display = 'none';
    }     
    
}
