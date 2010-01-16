/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | Geeklog 1.6                                                               |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2003-2009 by the following authors:                         |
// | Version 1.1    Date: Jun 4, 2006                                          |
// | Authors:   Blaine Lang - blaine@portalparts.com                           |
// |                                                                           |
// | Javascript functions for Geeklog Advanced Editor                          |
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


    function enablearchive(obj) {
        var f = obj.form;               // all elements have their parent form in "form"
        var disable = obj.checked;      // Disable when checked
        if (f.elements["archiveflag"].checked==true && f.elements["storycode11"].checked==false) {
            f.elements["storycode10"].checked=true;
        }
        f.elements["storycode10"].disabled=!disable;
        f.elements["storycode11"].disabled=!disable;
        f.elements["expire_month"].disabled=!disable;
        f.elements["expire_day"].disabled=!disable;
        f.elements["expire_year"].disabled=!disable;
        f.elements["expire_hour"].disabled=!disable;
        f.elements["expire_minute"].disabled=!disable;
        f.elements["expire_ampm"].disabled=!disable;
    }

    function showhideEditorDiv(option,selindex) {
        var obj = document.getElementById('adveditor');
        var divarray = new Array('publish','images','archive','perms','options','bottom');

        // Reset the current selected navbar tab
        var navbar = document.getElementById('current');
        if (navbar) navbar.id = '';
        // Cycle thru the navlist child elements - building an array of just the link items
        var navbar = document.getElementById('navlist');
        var menuitems = new Array(8);
        var item = 0;
        for (var i=0 ;i < navbar.childNodes.length ; i++ ) {
            if (navbar.childNodes[i].nodeName.toLowerCase() == 'li') {
                menuitems[item] = navbar.childNodes[i];
                item++;
            }
        }
        // Now that I have just the link items I can set the selected tab using the passed selected Item number
        // Set the <a> tag to have an id called 'current'
        var menuitem = menuitems[selindex];
        for (var j=0 ;j < menuitem.childNodes.length ; j++ ) {
            if (menuitem.childNodes[j].nodeName.toLowerCase() == 'a')  menuitem.childNodes[j].id = 'current';
        }

        // Reset or show all the main divs - editor tab sections
        for (i=0; i < divarray.length; i++) {
            div = 'se_' + divarray[i];
            if (option != 'all' && option != divarray[i]) {
                document.getElementById(div).style.display = 'none';
            } else {
                document.getElementById(div).style.display = '';
            }
        }
        document.getElementById('text_editor').style.display = 'none';
        document.getElementById('html_editor').style.display = 'none';
        document.getElementById('preview').style.display = 'none';

        if (option == 'editor' || option == 'all') {
            document.getElementById('editor_mode').style.display = '';
            document.getElementById('se_bottom').style.display = '';
            if (document.getElementById('sel_editmode').value == 'adveditor') {
                document.getElementById('text_editor').style.display = 'none';
                document.getElementById('html_editor').style.display = '';
            } else {
                document.getElementById('text_editor').style.display = '';
                document.getElementById('html_editor').style.display = 'none';
            }
            if (option == 'all') {
                document.getElementById('se_options').style.display = '';
                document.getElementById('preview').style.display = '';
            }

        } else if (option == 'preview') {
            document.getElementById('preview').style.display = '';
            document.getElementById('editor_mode').style.display = 'none';
        } else {
            document.getElementById('se_options').style.display = '';
            document.getElementById('se_bottom').style.display = '';
            document.getElementById('text_editor').style.display = 'none';
            document.getElementById('html_editor').style.display = 'none';
            document.getElementById('editor_mode').style.display = 'none';
            document.getElementById('preview').style.display = 'none';
        }

    }

    /* Enable if you want to have toolbar only auto-collapse when not editing in field */
    /*
    function FCKeditor_OnComplete( editorInstance )  {
        editorInstance.Events.AttachEvent( 'OnBlur'    , FCKeditor_OnBlur ) ;
        editorInstance.Events.AttachEvent( 'OnFocus', FCKeditor_OnFocus ) ;
    }

    function FCKeditor_OnBlur( editorInstance ) {
        editorInstance.ToolbarSet.Collapse() ;
    }

    function FCKeditor_OnFocus( editorInstance ) {
        editorInstance.ToolbarSet.Expand() ;
    }
    */
