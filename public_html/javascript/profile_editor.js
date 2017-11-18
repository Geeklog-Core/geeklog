/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 2.2                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2009 by the following authors:                         |
// | Version 1.0    Date: Jun 24, 2006                                         |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// | Javascript functions for Account Profile Editor                           |
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

// @param  string selected      Name of div that has been selected
// @param  int    selectedIndex index id of the selected tab as in 1 - 7 used to set the selected tab
function showhideProfileEditorDiv(selected, selectedIndex) {
    'use strict';
    // Reset the current selected navbar tab
    var cNavbar = document.getElementById('current');

    if (cNavbar) {
        cNavbar.id = '';
    }

    // Cycle thru the navlist child elements - building an array of just the link items
    var navbar = document.getElementById('navlist');
    var menuItems = new Array(7);
    var item = 0;
    for (var i = 0; i < navbar.childNodes.length; i++) {
        if (navbar.childNodes[i].nodeName.toLowerCase() === 'li') {
            menuItems[item] = navbar.childNodes[i];
            item++;
        }
    }

    // Now that I have just the link items I can set the selected tab using the passed selected Item number
    // Set the <a tag to have an id called 'current'
    var menuItem = menuItems[selectedIndex];
    for (var j = 0; j < menuItem.childNodes.length; j++) {
        if (menuItem.childNodes[j].nodeName.toLowerCase() === 'a') {
            menuItem.childNodes[j].id = 'current';
        }
    }

    // Reset or show all the main divs - editor tab sections
    // Object profilepanels defined in profile.thtml after page is generated
    for (var divId in window.profilepanels) {
        if (window.profilepanels.hasOwnProperty(divId)) {
            if (selected !== divId) {
                document.getElementById(divId).style.display = 'none';
            } else {
                document.getElementById(divId).style.display = '';
            }
        }
    }

    document.getElementById('pe_preview').style.display = 'none';

    if (selected !== 'pe_preview') {
        document.getElementById('save_button').style.display = '';
    } else if (selected === 'pe_preview') {
        document.getElementById('pe_preview').style.display = '';
        document.getElementById('save_button').style.display = 'none';
    } else {
        document.getElementById('pe_preview').style.display = '';
        document.getElementById('save_button').style.display = 'none';
    }
}

(function () {
    'use strict';
    /* Initially the navbar is hidden - in case JS is disabled. Enable it now */
    document.getElementById('pe_navbar').style.display = '';

    /* Now cycle through the profile tabs as the number in the template could have been modified (personalized)
       If you add custom panels, just ensure you use the class jsenabled_hide or jsenabled_show
       Build an object that can then be referenced in the function showhideProfileEditorDiv
    */

    var profilePanels = {};
    var el = document.getElementsByTagName("div");

    for (var i = 0; i < el.length; i++) {
        var divName = el[i].id;
        if (el[i].className === "jsenabled_show") {
            el[i].style.display = "";
            profilePanels[divName] = "show";
        } else if (el[i].className === "jsenabled_hide") {
            el[i].style.display = "none";
            profilePanels[divName] = "hidden";
        }
    }

    window.profilepanels = profilePanels;
})();
