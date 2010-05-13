/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.7                                                               |
// +---------------------------------------------------------------------------+
// | Commmon JavaScript functions                                              |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2005-2010 by the following authors:                         |
// |                                                                           |
// |            Blaine Lang - blaine AT portalparts DOT com                    |
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

// -------------------------------------------------------------------
// caItems(form object)
// Check All Items - generic function that can be used to check and un-check all items in a list
// Used in the Admin Lists - like on the moderation page
// -------------------------------------------------------------------
   function caItems(f) {  
       var n=f.elements.length;
       for (i=0;i<n; i++) {
           var field=f.elements[i];
           if (field.type == 'checkbox' && field.name.match("delitem")) {
                if (f.chk_selectall.checked) {
                    field.checked=true;
                } else {
                    field.checked=false;
                }
           }

       }
   }




// Basic function to show/hide (toggle) an element - pass in the elment id
    function elementToggle(id) {
        var obj = document.getElementById(id);
        if (obj.style.display == 'none') {
            obj.style.display = '';
        } else {
            obj.style.display = 'none';
        }
    }

// Basic function to show/hide an element - pass in the elment id and option.
// Where option can be: show or hide or toggle
    function elementShowHide(id,option) {
        var obj = document.getElementById(id);
        if (option == 'hide') {
            obj.style.display = 'none';
        } else if (option == 'show') {
            obj.style.display = '';
        } else if (option == 'toggle') {
            elementToggle(id);
        }
    }

//Basic function to hide the default option checkbox
//displays the other checkbox on selecting the first checkbox.
//used in the default group selection

    function showHide(id1) {
        el1 = document.getElementById(id1);
        el1.style.display = (el1.style.display != 'block')? 'block' : 'none';
    }

