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

// Below is Javascript for Repositiory
// Either displays or hides the data link
function smart_toggle_datalink(id, e, divisor)
{
    if (document.getElementById(id).style.display == "none") {
        display_datalink(id,e, divisor);
    }
    else {
        hide_datalink(id);
    }
};

// Displays data link
function display_datalink(id,e, divisor)
{
    var arr = XYpos(e);
    
    if (divisor) {
        if (divisor == false) {
            var tleft = (screen.width / 2);
            arr[1] = (screen.height / 2);
        }
        else {
            var tleft = arr[0] / divisor;
        }
    }
    else {
        var tleft = arr[0];
    }
    
    
    set_topleftpos(arr[1],tleft, id);
    document.getElementById(id).style.display = "";
};

// Hide data link
function hide_datalink(id)
{
    document.getElementById(id).style.display = "none";
};

// Open warning box, warning of potential malicious content
function warn_malicious_plugin(id,e, mode)
{
    if (mode == "install_unsafe") {
        var cmd = "install";
    }
    else {
        var cmd = "download";
    }
    var data = '<b style="color:red">'+MALICIOUS_PLUGIN_WARN['warning']+'!!</b><br /><br />'+MALICIOUS_PLUGIN_WARN['msg']+'<br /><br />'+MALICIOUS_PLUGIN_WARN['msg2']+'<br /><br /><input type="button" name="get_me_out" value="'+MALICIOUS_PLUGIN_WARN['cancel']+'" onclick="javascript:hide_maliciouswarning();" /><input type="button" name="install" value="'+MALICIOUS_PLUGIN_WARN['install']+'" onclick="javascript:hide_maliciouswarning();window.location = \'plugins.php?cmd='+cmd+'&id='+id+'\'" />';
    document.getElementById("MALICIOUS_PLUGIN_WARN").innerHTML = data;    
    display_datalink("MALICIOUS_PLUGIN_WARN",e);
};

// Bring up install/download plugin warning enabled box
// id is plugin id, e = event
function is_downloadinstall_plugin(mode, id, e)
{ 
    // Switch through the modes --
    // install_safe = auto redirect
    // install_unsafe = bring up prompt
    // same for download, download_safe and download_unsafe
    switch(mode)
    {
        case "install_safe":
        case "download_safe":
            if (mode == "install_safe") {
                var cmd = "install";
            }
            else {
                var cmd = "download";
            }
            
            window.location = "plugins.php?cmd="+cmd+"&id="+id;
            break;
        case "download_unsafe":
        case "install_unsafe":
            // Open message box
            warn_malicious_plugin(id,e, mode);
            break;
    }
};

// Hides warning
function hide_maliciouswarning()
{
    hide_datalink("MALICIOUS_PLUGIN_WARN");
};


